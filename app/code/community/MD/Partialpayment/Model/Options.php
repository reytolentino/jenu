<?php
/**
* Magedelight
* Copyright (C) 2014 Magedelight <info@magedelight.com>
*
* NOTICE OF LICENSE
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
*
* @category MD
* @package MD_Partialpayment
* @copyright Copyright (c) 2014 Mage Delight (http://www.magedelight.com/)
* @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
* @author Magedelight <info@magedelight.com>
*/
class MD_Partialpayment_Model_Options extends Mage_Core_Model_Abstract
{
    const INSTALLMENT_REPORTS = 'md_partialpayment_installments';
    
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_QUARTERLY = 'quarterly';
    
    const PAYMENT_FIXED = 'F';
    const PAYMENT_PERCENTAGE = 'P';
    public function _construct()
    {
        parent::_construct();
        $this->_init('md_partialpayment/options');
    }
    
    public function getIdByInfo($productId,$storeId = 0)
    {
        $id = null;
        
            $existingOption = $this->getCollection()
                            ->addFieldToFilter('product_id',array('eq'=>$productId))
                            ->addFieldToFilter('store_id',array('eq'=>$storeId))
                            ->getFirstItem();
            if($existingOption->getId()){
                $id = $existingOption->getId();
            }
        return $id;
    }
    
    public function getOptionByProduct(Mage_Catalog_Model_Product $product)
    {
        $object = null;
        $productId = (int)$product->getId();
        $storeId = (int)$product->getStoreId();
        if(is_int($productId) && is_int($storeId)){
            $object = $this->getCollection()
                            ->addFieldToFilter('product_id',array('eq'=>$productId))
                            ->addFieldToFilter('store_id',array('eq'=>$storeId))
                            ->getFirstItem();
        }
        return $object;
    }
    
    public function getStoreOptions(Mage_Catalog_Model_Product $product)
    {
        $object = null;
        $productId = (int)$product->getId();
        $storeId = (int)$product->getStoreId();
        $helper = Mage::helper('md_partialpayment');
        $isGroupEnabled = $helper->isAllowGroups();
        $isConfigEnabled = $helper->isEnabledOnFrontend();
        if(is_int($productId) && $isGroupEnabled && $isConfigEnabled){
            
            $storeOption = $this->getCollection()
                            ->addFieldToFilter('product_id',array('eq'=>$productId))
                            ->addFieldToFilter('store_id',array('eq'=>$storeId));
            if($storeOption->count() > 0){                
               $object = $storeOption->getFirstItem();
            }else{
                $defaultOption = $this->getCollection()
                                ->addFieldToFilter('product_id',array('eq'=>$productId))
                                ->addFieldToFilter('store_id',array('eq'=>0));
                
                if($defaultOption->count() > 0){
                    $object = $defaultOption->getFirstItem();
                }
            }
        }
        return $object;
    }
    
    public function getInstallmentSummary(Mage_Catalog_Model_Product $product, MD_Partialpayment_Model_Options $option, $qty = 1, $price = null)
    {
        $options = array();
        
        if(($product instanceof Mage_Catalog_Model_Product && $option instanceof MD_Partialpayment_Model_Options) && ($product->getId() == $option->getProductId()))
        {
            $price = round($product->getFinalPrice(),4);
            $options['initial_price'] = $price;
            
            $configInitialAmountType = Mage::getStoreConfig('md_partialpayment/general/initial_payment_type');
            $configInitialAmount = Mage::getStoreConfig('md_partialpayment/general/initial_payment_amount');
            $calculatedConfigInitialAmount = ($configInitialAmountType == 'F') ? $configInitialAmount: (($configInitialAmount * $price) / 100);
            $configAdditionalAmountType = Mage::getStoreConfig('md_partialpayment/general/additional_payment_type');
            $configAdditionalAmount = Mage::getStoreConfig('md_partialpayment/general/additional_payment_amount');
            $calculatedConfigAdditionalAmount = ($configAdditionalAmountType == 'F') ? $configAdditionalAmount: (($configAdditionalAmount * $price) / 100);
            $configInstallmentCount = Mage::getStoreConfig('md_partialpayment/general/total_installments');
            
            $productInitialPaymentAmount = $option->getInitialPaymentAmount();
            $productAdditionalPaymentAmount = $option->getAdditionalPaymentAmount();
            $productInstallmentCount = (!is_null($option->getInstallments())) ? $option->getInstallments(): $configInstallmentCount;
            
            $initialPaymentAmount = (!is_null($productInitialPaymentAmount)) ? $productInitialPaymentAmount: $calculatedConfigInitialAmount;
            $additionalPaymentAmount = (!is_null($productAdditionalPaymentAmount)) ? $productAdditionalPaymentAmount: $calculatedConfigAdditionalAmount;
            if(($options['initial_price'] + $additionalPaymentAmount) > $initialPaymentAmount){
                $options['initial_payment_amount'] = round($initialPaymentAmount * $qty, 4);
                $installmentCount = ($initialPaymentAmount > 0) ? $productInstallmentCount - 1: $productInstallmentCount;
                $options['installment_count'] = $productInstallmentCount;
                
                $options['additional_payment_amount'] = $additionalPaymentAmount;
                $totalPaymentAmount = (float)$price + (float)$additionalPaymentAmount;
                $options['unit_payment'] = $totalPaymentAmount;
                $options['total_payment_amount'] = round($totalPaymentAmount,4);
                $remainingAmount = (float)$totalPaymentAmount - (float)$initialPaymentAmount;
                $options['remaining_amount'] = round($remainingAmount * $qty,4);

                $parts = (float)$remainingAmount / (float)$installmentCount;
                $options['installment_amount'] = round($parts * $qty,4);
                if($initialPaymentAmount <= 0){
                    $options['initial_payment_amount'] = $parts * $qty;
                }
            }else{
				$options = array();
			}
        }
        return $options;
    }
    
    public function isActive()
    {
        return (boolean)$this->getStatus();
    }
}

