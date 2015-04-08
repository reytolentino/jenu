<?php

class Web2Market_CustomQueryReport_Model_Mysql4_Report_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('customqueryreport/report');
    }
}