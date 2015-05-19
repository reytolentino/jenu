<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Follow Up Email
 * @version   1.0.2
 * @build     407
 * @copyright Copyright (C) 2015 Mirasvit (http://mirasvit.com/)
 */


class Mirasvit_Email_Model_Rule_Condition_Customer extends Mirasvit_Email_Model_Rule_Condition_Abstract
{
    public function loadAttributeOptions()
    {
        $attributes = array(
            'group_id'         => Mage::helper('email')->__('Customer: Group'),
            'lifetime_sales'   => Mage::helper('email')->__('Customer: Lifetime Sales'),
            'number_of_orders' => Mage::helper('email')->__('Customer: Number of Orders'),
            'is_subscriber'    => Mage::helper('email')->__('Customer: Is subscriber of newsletter'),
            'reviews_count'    => Mage::helper('email')->__('Customer: Number of reviews'),
        );

        $arAttbiutes = Mage::getModel('customer/customer')->getAttributes();
        foreach ($arAttbiutes as $attr) {
            if ($attr->getStoreLabel()
                && $attr->getAttributeCode()) {
                $attributes[$attr->getAttributeCode()] = Mage::helper('email')->__('Customer: ').$attr->getStoreLabel();
            }
        }

        if (Mage::helper('mstcore')->isModuleInstalled('AW_Marketsuite')) {
            $attributes['mss_rule'] = Mage::helper('email')->__('Customer: AheadWorks MSS rule');
        }

        // asort($attributes);
        $this->setAttributeOption($attributes);

        return $this;
    }

    public function getInputType()
    {
        $type = 'string';

        switch ($this->getAttribute()) {
            case 'group_id':
                $type = 'multiselect';
            break;

            case 'is_subscriber':
            case 'mss_rule':
                $type = 'select';
            break;
        }

        return $type;
    }

    public function getValueElementType()
    {
        $type = 'text';

        switch ($this->getAttribute()) {
            case 'group_id':
                $type = 'multiselect';
            break;

            case 'is_subscriber':
            case 'mss_rule':
                $type = 'select';
            break;
        }

        return $type;
    }

    protected function _prepareValueOptions()
    {
        $selectOptions = array();

        if ($this->getAttribute() === 'group_id') {
            $selectOptions = Mage::helper('customer')->getGroups()->toOptionArray();

            array_unshift($selectOptions, array('value' => 0, 'label' => Mage::helper('email')->__('Not registered')));
        }

        if ($this->getAttribute() === 'is_subscriber') {
            $selectOptions = array(
                array('value' => 0, 'label' => Mage::helper('email')->__('No')),
                array('value' => 1, 'label' => Mage::helper('email')->__('Yes')),
            );
        }

        if ($this->getAttribute() === 'mss_rule' && Mage::helper('mstcore')->isModuleInstalled('AW_Marketsuite')) {
            $ruleCollection = Mage::getModel('marketsuite/filter')->getActiveRuleCollection();
            foreach ($ruleCollection as $rule) {
                $selectOptions[] = array(
                    'value' => $rule->getId(),
                    'label' => $rule->getName(),
                );
            }
        }
        
        $this->setData('value_select_options', $selectOptions);

        $hashedOptions = array();
        foreach ($selectOptions as $o) {
            $hashedOptions[$o['value']] = $o['label'];
        }
        $this->setData('value_option', $hashedOptions);

        return $this;
    }

    public function validate(Varien_Object $object)
    {
        $attrCode = $this->getAttribute();

        if ($object->getData('customer_id')) {
            $customer = Mage::getModel('customer/customer')->load($object->getData('customer_id'));
            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($customer->getEmail());
            $mssRule = 0;

            $reviews = Mage::getModel('review/review')->getCollection()
                ->addFieldToFilter('customer_id', $customer->getId());
            $reviewsCount = $reviews->count();


            $customerTotals = Mage::getResourceModel('sales/sale_collection')
                ->setCustomerFilter($customer)
                ->setOrderStateFilter(Mage_Sales_Model_Order::STATE_CANCELED, true)
                ->load()
                ->getTotals();
            $lifetimeSales = floatval($customerTotals['lifetime']);

            $numberOfOrders = Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('customer_id', $customer->getId())
                ->count();

            if (Mage::helper('mstcore')->isModuleInstalled('AW_Marketsuite')) {
                $mssApi = Mage::getModel('marketsuite/api');
                if ($mssApi->checkRule($customer, (int) $this->getValue())) {
                    $mssRule = $this->getValue();
                }
            }

            $object->addData($customer->getData())
                ->setData('is_subscriber', $subscriber->getId() ? 1 : 0)
                ->setData('reviews_count', $reviewsCount)
                ->setData('lifetime_sales', $lifetimeSales)
                ->setData('number_of_orders', $numberOfOrders)
                ->setData('mss_rule', $mssRule);

        } else {
            $email = $object->getData('customer_email');
            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
            
            $object->setData('group_id', 1)
                ->setData('is_subscriber', $subscriber->getId() ? 1 : 0)
                ->setData('reviews_count', 0)
                ->setData('lifetime_sales', 0)
                ->setData('number_of_orders', 0)
                ->setData('mss_rule', 0);
        }

        $value = $object->getData($attrCode);

        return $this->validateAttribute($value);
    }
}
