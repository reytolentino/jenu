<?php
/* 
* ////////////////////////////////////////////////////////////////////////////////////// 
* 
* @Author Emipro Technologies Private Limited 
* @Category Emipro 
* @Package  Emipro_Paymentservicecharge 
* @License http://shop.emiprotechnologies.com/license-agreement/ 
* 
* ////////////////////////////////////////////////////////////////////////////////////// 
*/ 
class Emipro_paymentservicecharge_Block_Adminhtml_System_Config_Form_Field_Extrachargetype extends Mage_Core_Block_Html_Select
{
   
    private $_chargetype;
	protected $_addChargeAllOption = true;

    public function getExtrachargetype()
	{
		$methods = array();
	
       return array(
            'fixed'=>Mage::helper('emipro_paymentservicecharge')->__('Fixed Charge'),
           'percentage'=>Mage::helper('emipro_paymentservicecharge')->__('Percentage')
        );
		 //return $methods;
 
	} 
  
  public function setInputName($value)
    {
        return $this->setName($value);
    }
 
    public function _toHtml()
    {
		
		if (!$this->getOptions()) {
            if ($this->_addChargeAllOption) 
            {
                $this->addOption(Mage_Customer_Model_Group::CUST_GROUP_ALL, Mage::helper('emipro_paymentservicecharge')->__('--Select--'));
            }
            foreach ($this->getExtrachargetype() as $key => $Titles)
            {
				 
				 $this->addOption($key, addslashes($Titles));
            }
        }
        return parent::_toHtml();
    }
}
