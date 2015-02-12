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
class MD_Partialpayment_Block_Adminhtml_Summary_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_helper = null;
    public function __construct()
    {
        parent::__construct();
        $this->_helper = Mage::helper('md_partialpayment');
        $this->setId('installmentSummaryGrid');
        $this->setUseAjax(false);
        $this->setDefaultSort('payment_id');
	$this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    public function _prepareCollection()
    {
        $collection = Mage::getModel('md_partialpayment/payments')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('payment_id', array(
            'header' => $this->_helper->__('Id'),
            'index' => 'payment_id',
            'width'=> '20px'
        ));
        $this->addColumn('store_id', array(
                'header'        => $this->_helper->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => false,
                'store_view'    => true,
                'sortable'      => false
            ));
        $this->addColumn('order_id', array(
            'header' => $this->_helper->__('Order #'),
            'index' => 'order_id',
            'width'=> '20px'
        ));
        $this->addColumn('customer_name', array(
            'header' => $this->_helper->__('Customer Name'),
            'index' => 'customer_name',
        ));
        $this->addColumn('customer_email', array(
            'header' => $this->_helper->__('Customer Email'),
            'index' => 'customer_email',
        ));
        $this->addColumn('paid_amount',array(
           'header'=>$this->_helper->__('Paid Amount'),
            'index'=>'paid_amount',
	    'type'=>'text',
            'filter'=>false,
            'frame_callback' => array($this, 'decorateAmount'),
            'width'=> '20px'
        ));
        $this->addColumn('due_amount',array(
           'header'=>$this->_helper->__('Due Amount'),
            'index'=>'due_amount',
	    'type'=>'text',
            'filter'=>false,
            'frame_callback' => array($this, 'decorateAmount'),
            'width'=> '20px'
        ));
        $this->addColumn('paid_installments', array(
            'header' => $this->_helper->__('Paid Installments'),
            'index' => 'paid_installments',
            'width'=> '20px'
        ));
        $this->addColumn('due_installments', array(
            'header' => $this->_helper->__('Due Installments'),
            'index' => 'due_installments',
            'width'=> '20px'
        ));
        $this->addColumn('last_installment_date',array(
           'header'=>$this->_helper->__('Last Paid Installment'),
            'index'=>'last_installment_date',
			'type'=>'date',
			'gmtoffset' => true,
                        'width'=> '50px'
        ));
        $this->addColumn('next_installment_date',array(
           'header'=>$this->_helper->__('Next Installment Date'),
            'index'=>'next_installment_date',
			'type'=>'date',
			'gmtoffset' => true,
                        'width'=> '50px'
        ));
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('payment_id');
		$this->getMassactionBlock()->setFormFieldName('partialpayment');
		$this->getMassactionBlock()->addItem('delete',array(
			'label'=>$this->_helper->__('Delete'),
			'url'=>$this->getUrl('*/*/massDelete'),
			'confirm'=>'Are you sure?'
		));
		 return parent::_prepareMassaction();
    }
    
    public function decorateAmount($value, $row, $column, $isExport)
    {
        $storeId = $row->getStoreId();
        
        return Mage::helper('core')->currencyByStore($value, $storeId, true, false);
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('md_partialpayment/adminhtml_summary/view',array('id'=>$row->getId()));  
    }
}

