<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Sarp
 * @version    1.7.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */

class Jenu_Sarp_Block_Adminhtml_Subscriptions_Grid extends AW_Sarp_Block_Adminhtml_Subscriptions_Grid
{    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sarp/subscription')->getCollection();
        $collection->getSelect();

        $this->setCollection($collection);


        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
                                    'header' => Mage::helper('sarp')->__('ID'),
                                    'align' => 'right',
                                    'width' => '5px',
                                    'index' => 'id',
                               ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                                              'header' => Mage::helper('sarp')->__('Store'),
                                              'align' => 'right',
                                              'width' => '100px',
                                              'type' => 'store',
                                              'index' => 'store_id',
                                         ));
        }
        $this->addColumn('customer_name', array(
                                               'header' => Mage::helper('sarp')->__('Customer'),
                                               'align' => 'right',
                                               'width' => '100px',
                                               'index' => 'customer_name',
                                          ));


        $this->addColumn('date_start', array(
                                            'header' => Mage::helper('sarp')->__('Subscription Start'),
                                            'align' => 'right',
                                            'width' => '150px',
                                            'type' => 'date',
                                            'index' => 'date_start',
                                       ));
        $this->addColumn('flat_date_expire', array(
                                                  'header' => Mage::helper('sarp')->__('Subscription End'),
                                                  'align' => 'right',
                                                  'width' => '150px',
                                                  'type' => 'date',
                                                  'index' => 'flat_date_expire',
                                             ));
        $this->addColumn('flat_next_payment_date', array(
                                                        'header' => Mage::helper('sarp')->__('Next Payment'),
                                                        'align' => 'right',
                                                        'width' => '150px',
                                                        'type' => 'date',
                                                        'index' => 'flat_next_payment_date',
                                                   ));

        $this->addColumn('flat_next_delivery_date', array(
                                                         'header' => Mage::helper('sarp')->__('Next Delivery'),
                                                         'align' => 'right',
                                                         'width' => '150px',
                                                         'type' => 'date',
                                                         'index' => 'flat_next_delivery_date',
                                                    ));
        $this->addColumn('date_canceled', array(
                                            'header' => Mage::helper('sarp')->__('Subscription cancel date'),
                                            'align' => 'right',
                                            'width' => '150px',
                                            'type' => 'date',
                                            'index' => 'date_canceled',
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
                                        'header' => Mage::helper('sarp')->__('Status'),
                                        'align' => 'left',
                                        'width' => '150px',
                                        'type' => 'options',
                                        'sortable' => false,
                                        'options' => Mage::getModel('sarp/source_subscription_status')->getGridOptions(),
                                        'index' => 'status',
                                   ));

        $this->addColumn('flat_last_order_status', array(
                                                        'header' => Mage::helper('sales')->__('Last order state'),
                                                        'index' => 'flat_last_order_status',
                                                        'type' => 'options',
                                                        'width' => '70px',
                                                        'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
                                                   ));
        $this->addColumn('flat_last_order_amount', array(
                                                        'header' => $this->__('Last Order Amount'),
                                                        'index' => 'flat_last_order_amount',
                                                        'type' => 'currency',
                                                        'currency' => 'flat_last_order_currency_code',
                                                   ));


        $this->addColumn('products_sku', array(
                                              'header' => Mage::helper('sarp')->__('SKU'),
                                              'align' => 'right',
                                              'width' => '100px',
                                              'index' => 'products_sku',
                                              'renderer' => 'sarp/adminhtml_widget_grid_column_renderer_products'
                                         ));

        $this->addColumn('products_text', array(
                                               'header' => Mage::helper('sarp')->__('Products'),
                                               'align' => 'right',
                                               'width' => '100px',
                                               'index' => 'products_text',
                                               'renderer' => 'sarp/adminhtml_widget_grid_column_renderer_products'
                                          ));


        $this->addColumn('action',
                         array(
                              'header' => $this->__('Action'),
                              'width' => '100',
                              'type' => 'action',
                              'getter' => 'getId',
                              'actions' => array(

                                  array(
                                      'caption' => $this->__('Edit'),
                                      'url' => array('base' => '*/*/edit'),
                                      'field' => 'id'
                                  )
                              ),
                              'filter' => false,
                              'sortable' => false,
                              'index' => 'stores',
                              'is_system' => true,
                         ));


        $ret = parent::_prepareColumns();


        return $ret;
    }

}
