<?php
 
include_once '../app/Mage.php';
 
Mage::app();
 
try{
	// usage /scripts/addToCart.php?product_id=838&qty=1
	$product_id = '';

	// get query string
	if (!isset($_GET['product_id'])) { $product_id = ''; } else { $product_id = $_GET['product_id']; }
	if (!isset($_GET['qty'])) { $qty = '1'; } else { $qty = $_GET['qty']; }

	$product = Mage::getModel('catalog/product')->load($product_id);

	$session = Mage::getSingleton('core/session', array('name'=>'frontend'));
	$cart = Mage::helper('checkout/cart')->getCart();

	$cart->addProduct($product, $qty);

	$session->setLastAddedProductId($product->getId());
	$session->setCartWasUpdated(true);

	$cart->save();

	$result = "{'result':'success'}";
	 
	echo $result;
 
} catch (Exception $e) {
	$result = "{'result':'error'";
	$result .= ", 'message': '".$e->getMessage()."'}";
	echo $result;
}