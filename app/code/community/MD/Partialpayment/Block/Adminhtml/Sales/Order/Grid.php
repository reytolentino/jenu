<?php

/**
 * Magedelight
 * Copyright (C) 2014 Magedelight <info@magedelight.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @category MD
 * @package MD_Partialpayment
 * @copyright Copyright (c) 2014 Mage Delight (http://www.magedelight.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Magedelight <info@magedelight.com>
 */
class MD_Partialpayment_Block_Adminhtml_Sales_Order_Grid extends AW_Sarp_Block_Adminhtml_Sales_Order_Grid {

    public function __construct() {
	parent::__construct();
	$this->setId('sales_order_grid');
	$this->setUseAjax(true);
	$this->setDefaultSort('created_at');
	$this->setDefaultDir('DESC');
	$this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass() {
	return 'sales/order_grid_collection';
    }

    protected function _prepareCollection() {
	$collection = Mage::getResourceModel($this->_getCollectionClass());
	$collection->getSelect()->joinLeft('sales_flat_order', 'main_table.entity_id = sales_flat_order.entity_id','tax_amount');
	$collection->addFilterToMap('created_at','main_table.created_at');
	$this->setCollection($collection);
	return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

	$this->addColumn('real_order_id', array(
	    'header' => Mage::helper('sales')->__('Order #'),
	    'width' => '80px',
	    'type' => 'text',
	    'index' => 'increment_id',
	));

	if (!Mage::app()->isSingleStoreMode()) {
	    $this->addColumn('store_id', array(
		'header' => Mage::helper('sales')->__('Purchased From (Store)'),
		'index' => 'store_id',
		'type' => 'store',
		'store_view' => true,
		'display_deleted' => true,
	    ));
	}

	$this->addColumn('created_at', array(
	    'header' => Mage::helper('sales')->__('Purchased On'),
	    'index' => 'created_at',
	    'type' => 'datetime',
	    'width' => '100px',
	));

	$this->addColumn('billing_name', array(
	    'header' => Mage::helper('sales')->__('Bill to Name'),
	    'index' => 'billing_name',
	));

	$this->addColumn('shipping_name', array(
	    'header' => Mage::helper('sales')->__('Ship to Name'),
	    'index' => 'shipping_name',
	));

	$this->addColumn('base_grand_total', array(
	    'header' => Mage::helper('sales')->__('G.T. (Excl Tax)'),
	    'index' => 'base_grand_total',
	    'type' => 'currency',
	    'currency' => 'base_currency_code',
		'renderer' => 'MD_Partialpayment_Block_Adminhtml_Sales_Order_Renderer_GrandtotalExclTax',
	));

	$this->addColumn('grand_total', array(
	    'header'   => Mage::helper('sales')->__('G.T. (Purchased)'),
	    'index'    => 'grand_total',
	    'type'     => 'currency',
	    'currency' => 'order_currency_code',
	    'renderer' => 'MD_Partialpayment_Block_Adminhtml_Sales_Order_Renderer_Grandtotal',
	));

	$this->addColumn('status', array(
	    'header' => Mage::helper('sales')->__('Status'),
	    'index' => 'status',
	    'type' => 'options',
	    'width' => '70px',
	    'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
	));

	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
	    $this->addColumn('action', array(
		'header' => Mage::helper('sales')->__('Action'),
		'width' => '50px',
		'type' => 'action',
		'getter' => 'getId',
		'actions' => array(
		    array(
			'caption' => Mage::helper('sales')->__('View'),
			'url' => array('base' => '*/sales_order/view'),
			'field' => 'order_id'
		    )
		),
		'filter' => false,
		'sortable' => false,
		'index' => 'stores',
		'is_system' => true,
	    ));
	}
	$this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

	$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
	$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

	return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
	$this->setMassactionIdField('entity_id');
	$this->getMassactionBlock()->setFormFielfdName('order_ids');
	$this->getMassactionBlock()->setUseSelectAll(false);

	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/cancel')) {
	    $this->getMassactionBlock()->addItem('cancel_order', array(
		'label' => Mage::helper('sales')->__('Cancel'),
		'url' => $this->getUrl('*/sales_order/massCancel'),
	    ));
	}

	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/hold')) {
	    $this->getMassactionBlock()->addItem('hold_order', array(
		'label' => Mage::helper('sales')->__('Hold'),
		'url' => $this->getUrl('*/sales_order/massHold'),
	    ));
	}

	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
	    $this->getMassactionBlock()->addItem('unhold_order', array(
		'label' => Mage::helper('sales')->__('Unhold'),
		'url' => $this->getUrl('*/sales_order/massUnhold'),
	    ));
	}

	$this->getMassactionBlock()->addItem('pdfinvoices_order', array(
	    'label' => Mage::helper('sales')->__('Print Invoices'),
	    'url' => $this->getUrl('*/sales_order/pdfinvoices'),
	));

	$this->getMassactionBlock()->addItem('pdfshipments_order', array(
	    'label' => Mage::helper('sales')->__('Print Packingslips'),
	    'url' => $this->getUrl('*/sales_order/pdfshipments'),
	));

	$this->getMassactionBlock()->addItem('pdfcreditmemos_order', array(
	    'label' => Mage::helper('sales')->__('Print Credit Memos'),
	    'url' => $this->getUrl('*/sales_order/pdfcreditmemos'),
	));

	$this->getMassactionBlock()->addItem('pdfdocs_order', array(
	    'label' => Mage::helper('sales')->__('Print All'),
	    'url' => $this->getUrl('*/sales_order/pdfdocs'),
	));

	$this->getMassactionBlock()->addItem('print_shipping_label', array(
	    'label' => Mage::helper('sales')->__('Print Shipping Labels'),
	    'url' => $this->getUrl('*/sales_order_shipment/massPrintShippingLabel'),
	));

	return $this;
    }

    public function getRowUrl($row) {
	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
	    return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
	}
	return false;
    }

    public function getGridUrl() {
	return $this->getUrl('*/*/grid', array('_current' => true));
    }

}
