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

class AW_Sarp_Block_Checkout_Cart_Item_Renderer_Default extends Mage_Checkout_Block_Cart_Item_Renderer
{

    protected function _getSarpOptions()
    {
        //$data = AW_Booking_Model_Observer::getProductFromTo($this->getProduct(), true);

        $product = $this->getProduct();
        /*		$data = array(
              new Zend_Date($product->getCustomOption('aw_booking_from')->getValue()." ". $product->getCustomOption('aw_booking_time_from')->getValue()),
              new Zend_Date($product->getCustomOption('aw_booking_to')->getValue()." ". $product->getCustomOption('aw_booking_time_to')->getValue())
          );
      */
        $startDateLabel = $product->getAwSarpHasShipping() ? $this->__("First delivery:")
                : $this->__("Subscription from:");

        $subscription_options = array();

        if ($product->getCustomOption('aw_sarp_subscription_type') && $product->getCustomOption('aw_sarp_subscription_type')->getValue() > 0) {
            $subscription_options[] = array('label' => $this->__('Subscription type:'), 'value' => Mage::getModel('sarp/period')->load($product->getCustomOption('aw_sarp_subscription_type')->getValue())->getName());
            if ($product->getCustomOption('aw_sarp_subscription_start')) {
                $date = new Zend_Date($product->getCustomOption('aw_sarp_subscription_start')->getValue(), 'Y-MM-dd');
                $subscription_options[] = array('label' => $startDateLabel, 'value' => $this->formatDate($date));
            }

        }

        return $subscription_options;

    }

    public function getOptionList()
    {
        return array_merge($this->_getSarpOptions(), parent::getOptionList());
    }

}
