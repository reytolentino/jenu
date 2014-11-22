<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Sarp
 * @version    1.7.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */

class AW_Sarp_Model_Payment_Method_Authorizenetcim extends AW_Sarp_Model_Payment_Method_Abstract
{

    const PAYMENT_METHOD_CODE = 'authorizenetcim';

    const XML_PATH_AUTHORIZENETCIM_API_LOGIN_ID = 'payment/authorizenetcim/login';
    const XML_PATH_AUTHORIZENETCIM_API_TEST_LOGIN_ID = 'payment/authorizenetcim/test_login';
    const XML_PATH_AUTHORIZENETCIM_TEST_MODE = 'payment/authorizenetcim/test';
    const XML_PATH_AUTHORIZENETCIM_DEBUG = 'payment/authorizenetcim/debug';
    const XML_PATH_AUTHORIZENETCIM_TRANSACTION_KEY = 'payment/authorizenetcim/trans_key';
    const XML_PATH_AUTHORIZENETCIM_TEST_TRANSACTION_KEY = 'payment/authorizenetcim/test_trans_key';
    const XML_PATH_AUTHORIZENETCIM_PAYMENT_ACTION = 'payment/authorizenetcim/payment_action';
    const XML_PATH_AUTHORIZENETCIM_ORDER_STATUS = 'payment/authorizenetcim/order_status';
    const XML_PATH_AUTHORIZENETCIM_SOAP_TEST = 'payment/authorizenetcim/soap_test';

    const WEB_SERVICE_MODEL = 'sarp/web_service_client_authorizenetcim';
    //const WEB_SERVICE_MODEL = 'authorizenetcim/gateway';

    public function __construct()
    {
        $this->_initWebService();
    }

    /**
     * Initializes web service instance
     * @return AW_Sarp_Model_Payment_Method_Authorizenetcim
     */
    protected function _initWebService()
    {
        $service = Mage::getModel(self::WEB_SERVICE_MODEL);
        $this->setWebService($service);
        return $this;
    }

    /**
     * This function is run when subscription is created and new order creates
     * @param AW_Sarp_Model_Subscription $Subscription
     * @param Mage_Sales_Model_Order     $Order
     * @param Mage_Sales_Model_Quote     $Quote
     * @return AW_Sarp_Model_Payment_Method_Abstract
     */
    public function onSubscriptionCreate(AW_Sarp_Model_Subscription $Subscription, Mage_Sales_Model_Order $Order, Mage_Sales_Model_Quote $Quote)
    {
        $this->createSubscription($Subscription, $Order, $Quote);
        return $this;
    }

    public function onBillingAddressChange(AW_Sarp_Model_Subscription $Subscription, $billingAddress)
    {
        $service = $this->getWebService()
                            ->setSubscription($Subscription)
                            ->setBillingAddress($billingAddress)
        ;
        $service->updateBillingAddress();
        return $this;
    }

    public function createSubscription($Subscription, $Order, $Quote)
    {
        $this->getWebService()
                ->setSubscriptionName(Mage::helper('sarp')->__('Subscription #%s', $Subscription->getId()))
                ->setSubscription($Subscription)
                ->setPayment($Quote->getPayment());
        //$CIMInfo = $this->getWebService()->createCIMAccount();
        //$CIMId = $this->getWebService()->getCIMCustomerProfileId($CIMInfo);
        //$CIMPaymentId = $this->getWebService()->getCIMCustomerPaymentProfileId($CIMInfo);

        $CIMInfo = $this->getWebService()
                        ->getPayment()
                        ->getAdditionalInformation();
        
        if (is_array($CIMInfo) && isset($CIMInfo['authorizenetcim_customer_id']) && isset($CIMInfo['authorizenetcim_payment_id']))
        {
            $CIMId = $CIMInfo['authorizenetcim_customer_id'];
            $CIMPaymentId = $CIMInfo['authorizenetcim_payment_id'];
            $Subscription
                    ->setRealId($CIMId)
                    ->setRealPaymentId($CIMPaymentId)
                    ->save();
        }

        return $this;

    }

    /**
     * Processes payment for specified order
     * @param Mage_Sales_Model_Order $Order
     * @return
     */
    public function processOrder(Mage_Sales_Model_Order $PrimaryOrder, Mage_Sales_Model_Order $Order = null)
    {
        if ($Order->getBaseGrandTotal() > 0) {
            $result = $this->getWebService()
                    ->setSubscription($this->getSubscription())
                    ->setOrder($Order)
                    ->createTransaction();
            $ccTransId = @$result->transactionId;
            $Order->getPayment()->setCcTransId($ccTransId);
        }
    }
}