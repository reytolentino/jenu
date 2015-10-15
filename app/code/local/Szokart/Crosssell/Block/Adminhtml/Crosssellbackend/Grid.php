<?php
/** This script is part of the crosssell project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Adminhtml_Crosssellbackend_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

public function __construct()
{
parent::__construct();
$this->setId('crosssellGrid');
$this->setDefaultSort('cs_id');
$this->setDefaultDir('DESC');
$this->setSaveParametersInSession(true);
}

protected function _prepareCollection()
{
$collection = Mage::getModel('crosssell/crosssell')->getCollection();
$this->setCollection($collection);
return parent::_prepareCollection();
}




protected function _prepareColumns()
{
$this->addColumn('cs_id', array(
'header'    => Mage::helper('crosssell')->__('ID'),
'align'     =>'right',
'width'     => '50px',
'index'     => 'cs_id',
));

$this->addColumn('name', array(
'header'    => Mage::helper('crosssell')->__('Name'),
'align'     =>'left',
'index'     => 'name',
));

//$this->addColumn('proid', array(
//'header'    => Mage::helper('crosssell')->__('IDP'),
//'align'     =>'left',
//'width'     => '50px',
//'index'     => 'proid',
//));

$this->addColumn('prosku', array(
'header'    => Mage::helper('crosssell')->__('Sku'),
'align'     =>'left',
'width'     => '100px',
'index'     => 'prosku',
));

$this->addColumn('namepro', array(
'header'    => Mage::helper('crosssell')->__('Product'),
'align'     =>'left',
'index'     => 'namepro',
));

$this->addColumn('lager', array(
'header'    => Mage::helper('crosssell')->__('Value [%]'),
'align'     =>'left',
'index'     => 'lager',
));

 $this->addColumn('dfrom', array(
            'header'    => Mage::helper('crosssell')->__('Date From'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'dfrom',
        ));
		
 $this->addColumn('dto', array(
            'header'    => Mage::helper('crosssell')->__('Date To'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--', 
            'index'     => 'dto',
        ));		




$this->addColumn('status',
            array(
                'header'=> 'Status',
                'index' => 'status',
                'type'  => 'options',
                'options' => array('0'=>Mage::helper('crosssell')->__('Disabled'),'1'=>Mage::helper('crosssell')->__('Enabled')),
)); 






$this->addColumn('action',
array(
'header'    =>  Mage::helper('crosssell')->__('Action'),
'width'     => '100',
'type'      => 'action',
'getter'    => 'getId',
'actions'   => array(
array(
'caption'   => Mage::helper('crosssell')->__('Edit General'),
'url'       => array('base'=> '*/*/edit'),
'field'     => 'id'
),
array(
'caption'   => Mage::helper('crosssell')->__('Edit Products'),
'url'       => array('base'=> '*/adminhtml_produkty/index'),
'field'     => 'rules'
),
),
'filter'    => false,
'sortable'  => false,
'index'     => 'stores',
'is_system' => true,
));

return parent::_prepareColumns();
}

protected function _prepareMassaction()
{
$this->setMassactionIdField('cs_id');
$this->getMassactionBlock()->setFormFieldName('crosssell');
$this->getMassactionBlock()->addItem('delete', array(
'label'    => Mage::helper('crosssell')->__('Delete'),
'url'      => $this->getUrl('*/*/massDelete'),
'confirm'  => Mage::helper('crosssell')->__('Are you sure?')
));
return $this;
}

public function getRowUrl($row)
{
return $this->getUrl('*/*/edit', array('id' => $row->getId()));
}

}