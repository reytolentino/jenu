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
class Web2Market_Report_Model_Report extends Mage_Core_Model_Abstract
{
    /**
     * @var Clean_SqlReports_Model_Report_GridConfig
     */
    protected $_gridConfig = null;
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('queryreport/report');
    }

    public function getReportCollection()
    {
        $connection = Mage::helper('queryreport')->getDefaultConnection();
            
        $collection = Mage::getModel('queryreport/reportCollection', $connection);
        $collection->getSelect()->from(new Zend_Db_Expr('(' . $this->getData('sql_query') . ')'));
		

        return $collection;
    }

    public function getChartDiv()
    {
        return 'chart_' . $this->getId();
    }

    /**
     * @return Clean_SqlReports_Model_Report_GridConfig
     */
    public function getGridConfig()
    {
        if (!$this->_gridConfig) {
            $config = json_decode($this->getData('grid_config'), true);
            if (!is_array($config)) {
                $config = array();
            }
            $this->_gridConfig = Mage::getModel('queryreport/report_gridConfig', $config);
        }
        return $this->_gridConfig;
    }
}