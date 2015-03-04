<?php

/**
 * @method getCreatedAt()
 * @method Clean_SqlReports_Model_Report setCreatedAt($value)
 * @method getTitle()
 * @method Clean_SqlReports_Model_Report setTitle($value)
 * @method getOutputType()
 * @method Clean_SqlReports_Model_Report setOutputType($value)
 *
 * @method Clean_SqlReports_Model_Report setChartConfig($value)
 */
class Web2Market_Report_Model_Reportsave extends Mage_Core_Model_Abstract
{
    /**
     * @var Clean_SqlReports_Model_Report_GridConfig
     */

    
    public function _construct()
    {
        parent::_construct();
        $this->_init('queryreport/reportsave');
    }
	
	

	
   
}