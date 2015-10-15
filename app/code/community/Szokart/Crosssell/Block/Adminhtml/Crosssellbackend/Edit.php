<?php
/** This script is part of the crosssell project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Adminhtml_Crosssellbackend_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

public function __construct()
{
parent::__construct();
$this->_objectId = 'id';
$this->_blockGroup = 'crosssell';
$this->_controller = 'adminhtml_crosssellbackend';
$this->_updateButton('save', 'label', Mage::helper('crosssell')->__('Save Rule'));
$this->_updateButton('delete', 'label', Mage::helper('crosssell')->__('Delete Rule'));

}

public function getHeaderText()
{
if( Mage::registry('crosssell_data') && Mage::registry('crosssell_data')->getId() ) {
return Mage::helper('crosssell')->__("Edit '%s'", $this->htmlEscape(Mage::registry('crosssell_data')->getName()));
}else{
return Mage::helper('crosssell')->__('Add Rule');
}
}

}