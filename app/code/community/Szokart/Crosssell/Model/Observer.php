<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Model_Observer
{
	
	public function addMassactionToProductGrid(Varien_Event_Observer $observer)
	{
		$block = $observer->getBlock();
		if(($block instanceof Mage_Adminhtml_Block_Catalog_Product_Grid) or ($block instanceof TBT_Enhancedgrid_Block_Catalog_Product_Grid)){


		$setsx = Mage::getModel('crosssell/crosssell')->toOptionArray();
		$sets[] = array( 'value' => 0, 'label' => Mage::helper('crosssell')->__('Create new - Add the major product') );
					
		$block->getMassactionBlock()->addItem('masscsadd', 
		array(
		'label'=> Mage::helper('crosssell')->__('Rules Crossells'), 
		'url'  => $block->getUrl('*/*/masscsadd', array('_current'=>true)), 
		'additional' => array(
		'visibility' => array(
		'name' => 'crossx',
		'type' => 'select',
		'class' => 'required-entry',
		'label' => Mage::helper('crosssell')->__('Choose'),
		'values' => $sets
		)
		)));
		
		////////////////////////
		

			
		$block->getMassactionBlock()->addItem('crosssellx', 
		array(
		'label'=> Mage::helper('crosssell')->__('Associate with Rules Crossells'), 
		'url'  => $block->getUrl('*/*/crosssellx', array('_current'=>true)), 
		'additional' => array(
		'visibility' => array(
		'name' => 'crossxx',
		'type' => 'select',
		'class' => 'required-entry',
		'label' => Mage::helper('crosssell')->__('Choose'),
		'values' => $setsx
		)
		)));
		



}
}
}
