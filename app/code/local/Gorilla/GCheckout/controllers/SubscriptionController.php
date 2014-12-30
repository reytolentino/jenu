<?php
/**
 * Gorilla GCheckout
 *
 * @category     Gorilla
 * @copyright    Copyright (c) 2011-2012 Gorilla (http://www.gorillagroup.com)
 */
    
class Gorilla_GCheckout_SubscriptionController extends Mage_Core_Controller_Front_Action
{
    public function confirmAction()
    {
        //$params = $this->getRequest()->getParams();
        $params = Mage::getSingleton('customer/session')->getConfirmationParams();

        if (isset($params['qty'])) {
            $filter = new Zend_Filter_LocalizedToNormalized(
                array('locale' => Mage::app()->getLocale()->getLocaleCode())
            );
            $params['qty'] = $filter->filter($params['qty']);
        }

        $product = $this->_initProduct();
        $related = $this->getRequest()->getParam('related_product');

        /**
         * Check product availability
         */
        if (!$product) {
            $this->_goBack();
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function agreeAction()
    {
        echo "Adding subscription-product into shopping cart";
    }

    
    /**
     * Initialize product instance from request data
     *
     * @return Mage_Catalog_Model_Product || false
     */
    protected function _initProduct()
    {
        $productId = (int) $this->_getParam('product'); //(int) $this->getRequest()->getParam('product');
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }

    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
        $returnUrl = $this->_getParam('return_url'); //$this->getRequest()->getParam('return_url');
        if ($returnUrl) {
            // clear layout messages in case of external url redirect
            if ($this->_isUrlInternal($returnUrl)) {
                $this->_getSession()->getMessages(true);
            }
            $this->getResponse()->setRedirect($returnUrl);
        } else {
            $this->_redirect('customer-care/purchase-jenu-online/');
        }
        return $this;
    }
    
    /**
     * Getting a specific parameter
     * @param string $name
     * @return string 
     */
    protected function _getParam($name)
    {
        $value = '';
        $params = Mage::getSingleton('customer/session')->getConfirmationParams();
        if (is_array($params) && isset($params[$name])){
            $value = $params[$name];
        }
        return $value;  
    }

    
}

