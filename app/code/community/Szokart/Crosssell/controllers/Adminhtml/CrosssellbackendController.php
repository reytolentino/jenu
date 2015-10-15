<?php
class Szokart_Crosssell_Adminhtml_CrosssellbackendController extends Mage_Adminhtml_Controller_Action
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

// Edytuj /////////////////////////////////////////
public function editAction() {
$id     = $this->getRequest()->getParam('id');
$model  = Mage::getModel('crosssell/crosssell')->load($id);
if ($model->getId() || $id == 0) {
$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
if (!empty($data)) {
$model->setData($data);
}
Mage::register('crosssell_data', $model);
$this->loadLayout();
$this->_setActiveMenu('crosssell/items');
$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
$this->_addContent($this->getLayout()->createBlock('crosssell/adminhtml_crosssellbackend_edit'))
->_addLeft($this->getLayout()->createBlock('crosssell/adminhtml_crosssellbackend_edit_tabs'));
$this->renderLayout();

} else {
Mage::getSingleton('adminhtml/session')->addError(Mage::helper('crosssell')->__('Item does not exist'));
$this->_redirect('*/*/');
}}

// zapisz edycje ///////////////////////////////////////////////////////////////////////////////////////////
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
		
		
		$model = Mage::getModel('crosssell/crosssell');		
		$model->setData($data)->setId($this->getRequest()->getParam('id'));
		
		try {
		if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
		$model->setCreatedTime(now())->setUpdateTime(now());
		} else {
		$model->setUpdateTime(now());
		}	
		
		$model->setStores(implode(',',$data['stores']));
		
		if(isset($data['customer_group'])){
		$model->setCustomerGroup(implode(',',$data['customer_group']));
		}
		

		$model->save();
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('crosssell')->__('The item has been saved'));
		Mage::getSingleton('adminhtml/session')->setFormData(false);
		
		if ($this->getRequest()->getParam('back')) {
		$this->_redirect('*/*/edit', array('id' => $model->getId()));
		return;
		}
		$this->_redirect('*/*/');
		return;
		} catch (Exception $e) {
		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		Mage::getSingleton('adminhtml/session')->setFormData($data);
		$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
		return;
		
		}
		}
		
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('crosssell')->__('Can not find the item to save'));
		$this->_redirect('*/*/');
	}




// Usuwanei /////////////////////////////////////////
public function massDeleteAction() {
$crosssellIds = $this->getRequest()->getParam('crosssell');
if(!is_array($crosssellIds)) {
	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select an item'));
} else {
	
	try {
		foreach ($crosssellIds as $crosssellId) {
			$crosssell = Mage::getModel('crosssell/crosssell')->load($crosssellId);
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