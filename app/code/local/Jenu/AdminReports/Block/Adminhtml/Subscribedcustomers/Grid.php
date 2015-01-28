<?php

class Jenu_AdminReports_Block_Adminhtml_Subscribedcustomers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('jenu_adminreports_subscribedcustomers_grid');
        $this->setFilterVisibility(true);
        $this->setSaveParametersInSession(true);
        $this->setPagerVisibility(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('jenu_adminreports/subscribedcustomers')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {
        $this->addColumn('customer_name', array(
            'header' => Mage::helper('reports')->__('Customer'),
            'align' => 'right',
            'width' => '100px',
            'index' => 'customer_name',
        ));
        $this->addColumn('period_type', array(
            'header' => Mage::helper('sarp')->__('Subscription type'),
            'align' => 'left',
            'width' => '150px',
            'type' => 'options',
            'sortable' => false,
            'options' => Mage::getModel('sarp/source_subscription_periods')->getGridOptions(),
            'index' => 'period_type',
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('reports')->__('Status'),
            'align' => 'left',
            'width' => '150px',
            //'type' => 'options',
            //'sortable' => false,
            //'options' => Mage::getModel('sarp/source_subscription_status')->getGridOptions(),
            'index' => 'status',
        ));
        $this->addColumn('products_text', array(
            'header' => Mage::helper('reports')->__('Products'),
            'align' => 'right',
            'width' => '100px',
            'index' => 'products_text',
            'renderer' => 'sarp/adminhtml_widget_grid_column_renderer_products'
        ));
        $this->addColumn('revenue', array(
            'header' => $this->__('Revenue'),
            'index' => 'revenue',
            'type' => 'currency',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('reports')->__('Excel XML'));

        parent::_prepareColumns();
    }
}