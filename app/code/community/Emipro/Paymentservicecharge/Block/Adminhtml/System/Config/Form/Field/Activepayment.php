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
class Emipro_paymentservicecharge_Block_Adminhtml_System_Config_Form_Field_Activepayment extends Mage_Core_Block_Html_Select
{
   
    private $_activepayment;
	protected $_addPaymentAllOption = true;

    public function getActivePaymentMethods()
	{
		$methods = array();
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();
		foreach ($payments as $paymentCode=>$paymentModel)
	   {
           $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = $paymentTitle;
       }
		 return $methods;
 
	} 
  
  public function setInputName($value)
    {
        return $this->setName($value);
    }
 
    public function _toHtml()
    {
		if (!$this->getOptions()) {
            if ($this->_addPaymentAllOption) 
            {
                $this->addOption(Mage_Customer_Model_Group::CUST_GROUP_ALL, Mage::helper('emipro_paymentservicecharge')->__('ALL METHODS'));
            }
            foreach ($this->getActivePaymentMethods() as $paymentId => $paymentTitles)
            {
				 $this->addOption($paymentId, addslashes($paymentTitles));
            }
        }
        return parent::_toHtml();
    }
}
