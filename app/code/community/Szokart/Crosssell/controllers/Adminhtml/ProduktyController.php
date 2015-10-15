<?php
class Szokart_Crosssell_Adminhtml_ProduktyController extends Mage_Adminhtml_Controller_Action
{
	
	protected function _initAction() {
	$this->loadLayout()
	->_setActiveMenu('crosssell/items')
	->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
	
	return $this;
	}   
	
	
	public function indexAction() { 
$this->_initAction()->renderLayout();
}





// Usuwanei /////////////////////////////////////////
public function massDeleteAction() {
$crosssellIds = $this->getRequest()->getParam('crosssellx');
if(!is_array($crosssellIds)) {
	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select an item'));
} else {
	
	try {
		foreach ($crosssellIds as $crosssellId) {
			$crosssell = Mage::getModel('crosssell/crosssellx')->load($crosssellId);
			$crosssell->delete();
		}

		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('A total of %d data has been successfully deleted', count($crosssellIds)));
	} catch (Exception $e) {
		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	}
}
$this->_redirect('*/*/index');
}

}