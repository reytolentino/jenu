<?php

/**
 * Product:       Xtento_TrackingImport (2.0.5)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2014-06-23T22:32:01+02:00
 * File:          app/code/local/Xtento/TrackingImport/Model/Import/Condition/Object.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Model_Import_Condition_Object extends Mage_SalesRule_Model_Rule_Condition_Address
{
    public function loadAttributeOptions()
    {
        $attributes = array();

        $attributes = array_merge($attributes, Mage::getSingleton('xtento_trackingimport/import_condition_custom')->getCustomAttributes());
        $attributes = array_merge($attributes, Mage::getSingleton('xtento_trackingimport/import_condition_custom')->getCustomNotMappedAttributes());

        $this->setAttributeOption($attributes);

        return $this;
    }

    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'base_subtotal':
            case 'weight':
            case 'total_qty':
                return 'numeric';

            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
            case 'status':
                return 'select';
        }
        // Get type for custom
        return 'string';
    }

    public function getValueElementType()
    {
        switch ($this->getAttribute()) {
            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
            case 'status':
                return 'select';
        }
        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            switch ($this->getAttribute()) {
                case 'country_id':
                    $options = Mage::getModel('adminhtml/system_config_source_country')
                        ->toOptionArray();
                    break;

                case 'region_id':
                    $options = Mage::getModel('adminhtml/system_config_source_allregion')
                        ->toOptionArray();
                    break;

                case 'shipping_method':
                    $options = Mage::getModel('adminhtml/system_config_source_shipping_allmethods')
                        ->toOptionArray();
                    break;

                case 'payment_method':
                    $options = Mage::getModel('adminhtml/system_config_source_payment_allmethods')
                        ->toOptionArray();
                    array_unshift($options, array('value' => '', 'label' => Mage::helper('xtento_trackingimport')->__('Empty (no value set)')));
                    break;

                case 'status':
                    $options = Mage::getModel('xtento_trackingimport/system_config_source_order_status')
                        ->toOptionArray();
                    array_shift($options); // Remove first option
                    break;

                default:
                    $options = array();
            }
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    /**
     * Validate Address Rule Condition
     *
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        if ($this->getAttribute() == 'payment_method' && !$object->hasPaymentMethod()) {
            if ($object->getOrder()) {
                $object->setPaymentMethod($object->getOrder()->getPayment()->getMethod());
            } else {
                $object->setPaymentMethod($object->getPayment()->getMethod());
            }
        }

        if ($object instanceof Mage_Sales_Model_Order_Shipment) {
            $object = $object->getOrder();
        }

        #Zend_Debug::dump($object->getData());
        #Zend_Debug::dump($this->validateAttribute($object->getData($this->getAttribute())), $object->getData($this->getAttribute()));

        return $this->validateAttribute($object->getData($this->getAttribute()));
    }
}
