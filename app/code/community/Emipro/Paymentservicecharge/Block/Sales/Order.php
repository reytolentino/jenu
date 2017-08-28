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
class Emipro_Paymentservicecharge_Block_Sales_Order extends Mage_Sales_Block_Order_Totals {

  protected function _initTotals() {
        parent::_initTotals();
		
		$amt = $this->getSource()->getServiceCharge();
		$nameAmt = $this->getSource()->getServiceChargeName();
        if($amt != 0 )
		{
			$this->addTotal(new Varien_Object(array(
                       'code' =>'service_charge',
                       'value' => $amt,
                       'base_value' =>  $this->getSource()->getBaseServiceCharge(),
						'label' => $nameAmt,
                    )), 'service_charge');
       
		}
		return $this;
    }

}
