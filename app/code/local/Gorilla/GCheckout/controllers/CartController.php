<?php
/**
 * Gorilla GCheckout
 *
 * @category     Gorilla
 * @copyright    Copyright (c) 2011-2012 Gorilla (http://www.gorillagroup.com)
 */

/**
 * Shopping cart controller
 */

include_once 'Mage/Checkout/controllers/CartController.php';

class Gorilla_GCheckout_CartController extends Mage_Checkout_CartController
{

    /**
     * Add product to shopping cart action
     */
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
Mage::log($params, NULL, 'yakoff.log');
        try {
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
			// is it Subcription product
            $agree = (isset($params['agree']) && (in_array($params['agree'],array('true','on','1'))));
			if (isset($params['aw_sarp_subscription_type'])) {
				$subscriptionTypeId = (int)$params['aw_sarp_subscription_type'];
				if (in_array($subscriptionTypeId, array(-1, 0, 1))) {
					$agree = 'on';
					$product->setAgree(1);
				}
			}
            
            if ($product->getTypeId() == 'subscription_simple' && !$agree) {
                $params['return_url'] = $_SERVER['HTTP_REFERER'];
                Mage::getSingleton('customer/session')->setConfirmationParams($params);
                Mage::app()
                    ->getResponse()
                    ->setRedirect(
                        Mage::helper('adminhtml')->getUrl('gcheckout/subscription/confirm')                        
                    );
                return;
            } else {
                Mage::getSingleton('customer/session')->unsConfirmationParams();
                parent::addAction();
            }
            
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice($e->getMessage());
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError($message);
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
            Mage::logException($e);
            $this->_goBack();
        }
    }

    public function sendqueueAction()
    {
        $id = $this->getRequest()->getParam('stacksku');
		$params = $this->getRequest()->getParam('stacksku');
		$this->getRequest()->setParam('product', $id);
		$this->getRequest()->setParam('qty', 1);
		$this->getRequest()->setParam('aw_sarp_subscription_type', 4);
		$this->getRequest()->setParam('aw_sarp_subscription_start', date('m/d/y'));
		$this->getRequest()->setParam('agree', 'on');
		Mage::log($params = $this->getRequest()->getParams(), NULL, 'yakoff2.log');
   		//parent::addAction();
         if ($params > 0) {
                $this->addmultipleAction($params);
            }

    }

    public function addmultipleAction($item)
    {
        /*$productIds = array();
        $productIds[] = $item;
        if (!is_array($productIds)) {
            $this->_goBack();
            return;
        }

        foreach( $productIds as $productId) {*/
            try {
                $qty = 1;

                $now = date('m/d/y');

                $cart   = $this->_getCart();
        		$params = $this->getRequest()->getParams();
                /*$product = Mage::getModel('catalog/product')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($productId)
                    ->setData('aw_sarp_subscription_type', 4)
                    ->setData('aw_sarp_subscription_start', $now);
*/
				$product = $this->_initProduct();
                $related = $this->getRequest()->getParam('related_product');
 
                /**
                 * Check product availability
                 */
                /*if (!$product) {
                    $response['status'] = 'ERROR';
                    $response['message'] = $this->__('Unable to find Product ID');
                }*/
 				$session = Mage::getSingleton('core/session', array('name'=>'frontend'));
                $cart->addProduct($product, $params);
                if (!empty($related)) {
                    $cart->addProductsByIds(explode(',', $related));
                }
 				$session->setLastAddedProductId($product->getId());
				$session->setCartWasUpdated(true);
                $cart->save();
 
                $this->_getSession()->setCartWasUpdated(true);
 
                /**
                 * @todo remove wishlist observer processAddToCart
                 */
                Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
                );
                //Mage::dispatchEvent('checkout_cart_before_add', $eventArgs);
//parent::addAction();
                //$cart->addProduct($product, $qty);

               // Mage::dispatchEvent('checkout_cart_after_add', $eventArgs);

                //$cart->save();

                //Mage::dispatchEvent('checkout_cart_add_product', array('product'=>$product));

                $message = $this->__('%s was successfully added to your shopping cart.', $product->getName());
                Mage::getSingleton('checkout/session')->addSuccess($message);
            }
            catch (Mage_Core_Exception $e) {
                if (Mage::getSingleton('checkout/session')->getUseNotice(true)) {
                    Mage::getSingleton('checkout/session')->addNotice($product->getName() . ': ' . $e->getMessage());
                }
                else {
                    Mage::getSingleton('checkout/session')->addError($product->getName() . ': ' . $e->getMessage());
                }
            }
            catch (Exception $e) {
                Mage::getSingleton('checkout/session')->addException($e, $this->__('Can not add item to shopping cart'));
            }
        //}
        //$this->_goBack();
    }

}
