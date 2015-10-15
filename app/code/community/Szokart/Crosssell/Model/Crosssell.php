<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/

class Szokart_Crosssell_Model_Crosssell extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('crosssell/crosssell');
    }

	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function toOptionArray() 
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('crosssell/crosssell_collection')->loadData()->toOptionArray(); 
        }

		$options = $this->_options;
        return $options;
    }

// zapisywanie ////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function zapisPro($productIds, $attrData) 
{

if($attrData==0){
	
$id_store = Mage::app()->getRequest()->getParam('store', 0); 		
$ilosc= 0;

	foreach ($productIds as $productId){
	
	$pro = NULL;
	$time = date("Y-m-d H:i:s");
	$products = Mage::getModel('catalog/product')->getCollection()
	->addAttributeToSelect('*')
	->addAttributeToFilter('entity_id', $productId)
	->setPageSize(1)
	->setCurPage(1);
	
	foreach ($products as $item){ $time = $time.' - '.$item->getName(); $nampro = $item->getName();	 $prosku = $item->getSku();	 }
	
	   
		$model = Mage::getModel('crosssell/crosssell');		
		$model->setProsku($prosku);
		$model->setProid($productId);
		$model->setName($time);
		$model->setNamepro($nampro);
		$model->setStatus(0);
		$model->setCreatedTime(now());
		$model->setUpdateTime(now());
		$model->save();
		 
	
	$ilosc++;
	}

}
return $ilosc;
}



// zapisywanie ////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function powiazPro($productIds, $attrData) 
{
	
$id_store = Mage::app()->getRequest()->getParam('store', 0); 		
$ilosc= 0;

	$modelx = Mage::getModel('crosssell/crosssell')->load($attrData);
	
	$checkpros = Mage::getModel('crosssell/crosssellx')->getCollection();
	$checkpros->getSelect()->where('cs_id='.$attrData);	
	$tcheckpros= array();
	
	foreach ($checkpros as $itemx){ $tcheckpros[] = $itemx->getProid(); }
	
	
	
	

	foreach ($productIds as $productId){
	
	if($productId != $modelx->getProid() and !in_array($productId, $tcheckpros)){
	
	$pro = NULL;
	$time = date("Y-m-d H:i:s");
	$products = Mage::getModel('catalog/product')->getCollection()
	->addAttributeToSelect('name')
	->addAttributeToFilter('entity_id', $productId)
	->setPageSize(1)
	->setCurPage(1);
	
	
	
	foreach ($products as $item){ $time = $time.' - '.$item->getName(); $nampro = $item->getName();	 }
		   
		$model = Mage::getModel('crosssell/crosssellx');		
		$model->setProid($productId);
		$model->setCsId($attrData);
		$model->setNamepro($nampro);
		$model->save(); 
		 
	
	$ilosc++;
	}}

return $ilosc;
}





}