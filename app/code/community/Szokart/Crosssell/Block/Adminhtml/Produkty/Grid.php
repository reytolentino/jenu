<?php
/** This script is part of the crosssell project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Adminhtml_Produkty_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

public function __construct()
{
parent::__construct();
$this->setId('crosssellGrid');
$this->setDefaultSort('csx_id');
$this->setDefaultDir('ASC');
$this->setSaveParametersInSession(true);
}

protected function _prepareCollection()
{
$id  = $this->getRequest()->getParam('rules');
$collection = Mage::getModel('crosssell/crosssellx')->getCollection();
if ($id != NULL) {
$collection->getSelect()->where('cs_id='.$id);	
}
$this->setCollection($collection);
return parent::_prepareCollection();
}




protected function _prepareColumns()
{
$this->addColumn('csx_id', array(
'header'    => Mage::helper('crosssell')->__('ID'),
'align'     =>'right',
'width'     => '50px',
'index'     => 'csx_id',
));

$this->addColumn('cs_id', array(
'header'    => Mage::helper('crosssell')->__('Rules'),
'align'     =>'right',
'width'     => '50px',
'index'     => 'cs_id',
));


$this->addColumn('proid', array(
'header'    => Mage::helper('crosssell')->__('IDP'),
'align'     =>'left',
'width'     => '50px',
'index'     => 'proid',
));

$this->addColumn('namepro', array(
'header'    => Mage::helper('crosssell')->__('Product'),
'align'     =>'left',
'index'     => 'namepro',
));


return parent::_prepareColumns();
}

protected function _prepareMassaction()
{
$this->setMassactionIdField('csx_id');
$this->getMassactionBlock()->setFormFieldName('crosssellx');
$this->getMassactionBlock()->addItem('delete', array(
'label'    => Mage::helper('crosssell')->__('Delete'),
'url'      => $this->getUrl('*/*/massDelete'),
'confirm'  => Mage::helper('crosssell')->__('Are you sure?')
));
return $this;
}



}