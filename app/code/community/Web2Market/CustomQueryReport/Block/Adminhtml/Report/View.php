<?php

class Web2Market_CustomQueryReport_Block_Adminhtml_Report_View extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_report_view';
        $this->_blockGroup = 'customqueryreport';
        $this->_headerText = Mage::helper('core')->__($this->_getReport()->getTitle());

        parent::__construct();
        $this->_removeButton('add');
        $this->_removeButton('search');
    }

    protected function _prepareLayout()
    {
        return Mage_Adminhtml_Block_Widget_Container::_prepareLayout();
    }

    /**
     * @return Web2Market_CustomQueryReport_Model_Report
     */
    protected function _getReport()
    {
        return Mage::registry('current_report');
    }
}