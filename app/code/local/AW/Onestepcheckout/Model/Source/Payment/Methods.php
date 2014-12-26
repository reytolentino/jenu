<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento enterprise edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento enterprise edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Onestepcheckout
 * @version    1.2.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Onestepcheckout_Model_Source_Payment_Methods
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $paymentMethodsOptionArray = array(
            array(
                'label' => '',
                'value' => '',
            )
        );
        $paymentMethodsList = Mage::getModel('payment/config')->getActiveMethods();
        ksort($paymentMethodsList);
        foreach ($paymentMethodsList as $paymentMethodCode => $paymentMethod) {
            if ($paymentMethodCode == 'googlecheckout') {
                continue;
            }
            $paymentMethodsOptionArray[] = array(
                'label' => $paymentMethod->getTitle(),
                'value' => $paymentMethodCode,
            );
        }
        return $paymentMethodsOptionArray;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $paymentMethodsArray = array();
        $paymentMethodsList = Mage::getModel('payment/config')->getActiveMethods();
        ksort($paymentMethodsList);
        foreach ($paymentMethodsList as $paymentMethodCode => $paymentMethod) {
            $paymentMethodsArray[$paymentMethodCode] = $paymentMethod->getTitle();
        }
        return $paymentMethodsArray;
    }
}