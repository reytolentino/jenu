<?php

class Web2Market_CustomQueryReport_Model_Mysql4_Report extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('customqueryreport/report', 'report_id');
    }
}