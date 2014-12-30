<?php
/**
 * Gorilla GCheckout
 *
 * @category     Gorilla
 * @copyright    Copyright (c) 2011-2012 Gorilla (http://www.gorillagroup.com)
 */

class Gorilla_GCheckout_Block_Subscription_Confirm extends Mage_Core_Block_Template
{
    /**
     * Object of a current subscription product
     * @var Mage_Catalog_Model_Product
     */
    protected $_product;
    
    /**
     * Init a product
     * @return Mage_Catalog_Model_Product | false 
     */
    public function getProduct()
    {
        if (empty($this->_product)) {
            $productId = $this->getProductId();
            if ($productId) {
                $product = Mage::getModel('catalog/product')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($productId);
                if ($product->getId()) {
                    $this->_product = $product;
                }
            }
        }
        return $this->_product;
    }
    
    /**
     * Getting a name of a product
     * @return string 
     */
    public function getProductName()
    {
        $name = '';
        $product = $this->getProduct();
        if ($product->getId()) {
            $name = $product->getName();
        }
        return $name;
    }
    
    /**
     * return string
     */
    public function getProductImageUrl()
    {
        $url = '';
        $product = $this->getProduct();
        if ($product->getId()) {
            $url = $product->getImageUrl();
        }
        return $url;
    }
    
    /**
     * Getting parameters ID of a product
     * @return string
     */
    public function getProductId()
    {
        return $this->getParam('product');
    }
    
    /**
     * Getting a specific parameter
     * @param string $name
     * @return string 
     */
    public function getParam($name)
    {
        $value = '';
        $params = Mage::getSingleton('customer/session')->getConfirmationParams();
        if (is_array($params) && isset($params[$name])){
            $value = $params[$name];
        }
        return $value;  
    }
    
    /**
     * Getting a link
     * @param string $type
     * @return string 
     */
    public function getLink($type)
    {
        $link = Mage::getBaseUrl();
        switch ($type) {
            case "continue_shopping":
                $link .= "customer-care/purchase-jenu-online/";
                break;
            case "subscription_agree":
                $link .= "checkout/cart/add";
                break;
            default:
        }
        return $link;
    }
}

?>
