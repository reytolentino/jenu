<?php

/**
 *
 * @author Vladimir Kalchenko <vkalchenko@gorillagroup.com>
 */
class Jenu_Sarp_Model_Observer extends Mage_Core_Model_Abstract
{
    const XML_PATH_CREDIT_CARD_ISSUE_EMAIL_TEMPLATE = 'sarp/emailtemplates/credit_card_issue_email_template';

    public function notifyIsSuspended($event)
    {
        try {
            $subscription = $event->getSubscription();
            $customer = Mage::getModel('customer/customer')->load($subscription->getCustomerId());
            $template = Mage::getStoreConfig(self::XML_PATH_CREDIT_CARD_ISSUE_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());

            $mailTemplate = Mage::getModel('core/email_template');
            $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))->sendTransactional(
                $template,
                Mage::getStoreConfig('trans_email/ident_general', Mage::app()->getStore()->getId()),
                $customer->getEmail(),
                $customer->getFirstname() . ' ' . $customer->getLastname(),
                array(
                    'customer' => $customer,
                    'error_message' => $event->getErrorMessage(),
                    'store' => Mage::app()->getStore(),
               )
            );
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    
    /**
     * Sets subscription cancel date on 'sarp_subscription_cancel_before' event
     * 
     * @param Varien_Event_Observer $observer
     * @return \Jenu_Sarp_Model_Observer
     */
    public function onCancelBefore($observer)
    {
        try {
            $subscription = $observer->getSubscription();
            if (empty($subscription->getDateCanceled())) {
                $date = new Zend_Date();
                $subscription->setDateCanceled($date->get(AW_Sarp_Model_Subscription::DB_DATE_FORMAT));
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
        
        return $this;
    }
}
