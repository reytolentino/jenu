<?php

/**
 * Created by PhpStorm.
 * User: rtolentino
 * Date: 4/22/15
 * Time: 9:25 AM
 */
class BTS_AddMultipleProducts_AddController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $products = explode(',', $this->getRequest()->getParam('products'));
        $cart = Mage::getModel('checkout/cart');
        $cart->init();
        /* @var $pModel Mage_Catalog_Model_Product */
        foreach ($products as $product_id) {
            if ($product_id == '') {
                continue;
            }
            $pModel = Mage::getModel('catalog/product')->load($product_id);
            if ($pModel->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                try {
                    $cart->addProduct($pModel, array('qty' => '1'));
                } catch (Exception $e) {
                    continue;
                }
            }
        }
        $cart->save();
        if ($this->getRequest()->isXmlHttpRequest()) {
            exit('1');
        }
        $this->_redirect('checkout/cart');
    }
}