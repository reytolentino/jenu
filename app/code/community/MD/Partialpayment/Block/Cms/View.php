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
class MD_Partialpayment_Block_Cms_View extends Mage_Core_Block_Template
{
    protected $_product = null;
    protected $_options = null;
    public function __construct() {
        parent::__construct();
        $this->setTemplate('md/partialpayment/cms/view.phtml');
    }
    
    public function getProduct()
    {
        return $this->_product;
    }
    
    public function getPartialPaymentOption()
    {
        return $this->_options;
    }
    
    public function getSubmitUrl()
    {
        $additional = array();
        $addUrlKey = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
        $addUrlValue = Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_current' => true));
        $additional[$addUrlKey] = Mage::helper('core')->urlEncode($addUrlValue);
        return Mage::helper('checkout/cart')->getAddUrl($this->getProduct(), $additional);
    }
    
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $productId = $this->getData('partial_product_id');
        if($productId){
            $this->_product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load($productId);
            
            if($this->_product){
                $this->_options = Mage::getModel('md_partialpayment/options')->getStoreOptions($this->_product);
            }
        }
        
        return $this;
    }
    
    protected function _prepareLayout() { 
        $this->getLayout()->getBlock('head')->addItem('skin_css','md/partialpayment/style.css');
        return parent::_prepareLayout();
    }
    
}

