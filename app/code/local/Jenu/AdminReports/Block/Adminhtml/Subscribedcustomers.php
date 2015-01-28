<?php

class Jenu_AdminReports_Block_Adminhtml_Subscribedcustomers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'jenu_adminreports';
        $this->_controller = 'adminhtml_subscribedcustomers';
        $this->_headerText = Mage::helper('jenu_adminreports')->__('Subscribed Customers Report');

        parent::__construct();
        $this->_removeButton('add');
    }
}