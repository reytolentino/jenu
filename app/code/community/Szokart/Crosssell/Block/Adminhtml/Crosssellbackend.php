<?php  

class Szokart_Crosssell_Block_Adminhtml_Crosssellbackend extends Mage_Adminhtml_Block_Widget_Grid_Container{

public function __construct()
{
$this->_controller = 'adminhtml_crosssellbackend'; 
$this->_blockGroup = 'crosssell';
$this->_headerText = Mage::helper('crosssell')->__('Rules Cross Sale - manager');
$this->_addButtonLabel = Mage::helper('crosssell')->__('Add New');
parent::__construct();
$this->_removeButton('add');
}

protected function _prepareLayout(){
    $this->setChild( 'grid',
       $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',
       $this->_controller . '.grid')->setSaveParametersInSession(true) );
   return parent::_prepareLayout();
}




}