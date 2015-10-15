<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Crosssell extends Mage_Core_Block_Template
{ 

public function _prepareLayout()
{ return parent::_prepareLayout(); }

public function getCrosssell()     
{ 
if (!$this->hasData('crosssell')) {
$this->setData('crosssell', Mage::registry('crosssell'));
}
return $this->getData('crosssell');
}




public function getCroCollection($czyl = NULL){

$product_ids = Mage::getModel('checkout/cart')->getProductIds(); //get cart product ids
//print_r($product_ids); 
$tabpro= array();

$storeId = Mage::app()->getStore()->getId();
if($this->helper('customer')->isLoggedIn()) { 
$idgpc =   Mage::getSingleton('customer/session')->getCustomer()->getGroupId(); 
} else { $idgpc = 0;  } 
	
foreach($product_ids as $proid){

$collection = Mage::getModel('crosssell/crosssell')->getCollection();
$collection->addFieldToFilter('customer_group',array( array('finset' => $idgpc), array('eq' => 0), array('null'=> 1)));

$collection->addFieldToFilter('stores',array( array('finset' => $storeId), array('null'=> 1), array('eq'=> 0)));

$collection->addFieldToFilter('dfrom', array( array('lteq' =>date("Y-m-d")),array('null'=> 1)));
$collection->addFieldToFilter('dto', array( array('gteq' =>date("Y-m-d")),array('null'=> 1)));

$collection->addFieldToFilter('proid', array('eq' => $proid) );
$collection->addFieldToFilter('status', array('eq' => 1) );



foreach($collection as $rule){
	
$collectionx = Mage::getModel('crosssell/crosssellx')->getCollection();
$collectionx->getSelect()->where("cs_id=".$rule->getCsId());
//echo count($collectionx);	
foreach($collectionx as $pro){$tabpro[]= $pro->getProid();  $lager[$pro->getProid()]= $rule->getLager(); }		
}

}
if($czyl == NULL){
return $tabpro;
}else{
	return $lager;
}


}


// pobranie listy produtków /////////
public function getCroItem(){
	
// remove outstock configuroable //////////////////////////////////////	
$collectionConfigurable = Mage::getModel('catalog/product')->getCollection()
->addMinimalPrice()
->addFinalPrice()
->addTaxPercents()
->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
->addUrlRewrite()
->addAttributeToFilter('type_id', array('eq' => 'configurable'))
->addAttributeToFilter('entity_id', array('in' => $this->getCroCollection()))
->addAttributeToFilter('status', 1)
->addAttributeToFilter('visibility', 4)
->setPageSize(12)
->setCurPage(1);

$outOfStockConfis = array();
foreach ($collectionConfigurable as $_configurableproduct) {
    $product = Mage::getModel('catalog/product')->load($_configurableproduct->getId());
    if (!$product->getData('is_salable')) {
       $outOfStockConfis[] = $product->getId();
    }
}	
	
	
// end remove outstock configuroable //////////////////////////////////////		

$products = Mage::getModel('catalog/product')->getCollection()
->addMinimalPrice()
->addFinalPrice()
->addTaxPercents()
->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
->addUrlRewrite()
->addAttributeToSelect('image')
->addAttributeToFilter('entity_id', array('in' => $this->getCroCollection()));

if(count($outOfStockConfis) > 0){
$products->addAttributeToFilter('entity_id', array('nin' => $outOfStockConfis));
}
$products->addAttributeToFilter('status', 1)
->addAttributeToFilter('visibility', 4)
->setPageSize(12)
->setCurPage(1);

Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products);

return $products;

}





}