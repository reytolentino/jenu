<?php
/** This script is part of the crosssell project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Adminhtml_Crosssellbackend_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

public function __construct()
{
parent::__construct();
$this->setId('crosssell_tabs');
$this->setDestElementId('edit_form');
$this->setTitle(Mage::helper('crosssell')->__('Group'));
}

protected function _beforeToHtml()
{
$this->addTab('form_section', array(
'label'     => Mage::helper('crosssell')->__('Group'),
'title'     => Mage::helper('crosssell')->__('Group'),
'content'   => $this->getLayout()->createBlock('crosssell/adminhtml_crosssellbackend_edit_tab_form')->toHtml(),
));

return parent::_beforeToHtml();
}
}