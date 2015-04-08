<?php

/**
 * @method getCreatedAt()
 * @method Web2Market_CustomQueryReport_Model_Report setCreatedAt($value)
 * @method getTitle()
 * @method Web2Market_CustomQueryReport_Model_Report setTitle($value)
 */
class Web2Market_CustomQueryReport_Model_Report extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customqueryreport/report');
    }
}