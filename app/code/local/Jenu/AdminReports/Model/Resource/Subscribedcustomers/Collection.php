<?php

class Jenu_AdminReports_Model_Resource_Subscribedcustomers_Collection  extends AW_Sarp_Model_Mysql4_Subscription_Collection
{
    public function getCollectionForReport()
    {
        //@todo create query for collection
    }

    public function _initSelect() {
        $this->getSelect()->from(array('main_table' => $this->getMainTable()), array('customer_id'));

        //$this->removeAllFieldsFromSelect();

        //$this->addFieldToSelect(array('customer_id'));

        $this->getSelect()->join(array('f' => Mage::getResourceModel('sarp/subscription_flat')->getMainTable()),
            'f.subscription_id=main_table.id',
            array('f.customer_name')
        );

        $this->getSelect()->join(array('t2' => 'aw_sarp_subscription_items'),
            'main_table.id = t2.subscription_id',
            array('')
        );

        $this->getSelect()->join(array('t3' => 'sales_flat_order'),
            't2.primary_order_id = t3.entity_id',
            array('')
        );

        //$this->addExpressionFieldToSelect('revenue', 'SUM({{f.flat_last_order_amount}})', 'f.flat_last_order_amount');
        $this->addExpressionFieldToSelect('revenue', 'SUM({{t3.base_total_paid}})', 't3.base_total_paid');
        $this->addExpressionFieldToSelect('status', 'if(LOCATE(\'active\', group_concat(IF({{main_table.status}} = '.AW_Sarp_Model_Subscription::STATUS_ENABLED.', \'active\', \'not\') SEPARATOR \'#\')) > 0, \'active\', \'not active\')', 'main_table.status');
        $this->addExpressionFieldToSelect('period_type', 'group_concat(DISTINCT {{period_type}} SEPARATOR \'#\')', 'period_type');
        $this->addExpressionFieldToSelect('products_text', 'group_concat(DISTINCT {{f.products_text}} SEPARATOR \'#\')', 'f.products_text');

        $this->getSelect()->group(array('customer_id', 'f.customer_name'));

        //$this->_pageSize = null;

        //die($this->getSelectSql(true));

        return $this;

        /*
         * products_text
         sum(t3.base_total_paid)

        join aw_sarp_subscription_items as t2 on id = t2.subscription_id
        join sales_flat_order as t3 on t2.primary_order_id = t3.entity_id

            if(LOCATE(\'1\', group_concat(DISTINCT f.status SEPARATOR '#') > 0), \'active\', \'not active\') as `status`
            group_concat(DISTINCT t1.period_type SEPARATOR \'#\') as `period_type`           *
        */

    }

    public function getSelectCountSql()
    {
        $this->_renderFilters();
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $sql = $countSelect->__toString();
        $sql = 'select count(*) from ('.$sql.') as t';
        //die($sql);
        return $sql;
    }


}