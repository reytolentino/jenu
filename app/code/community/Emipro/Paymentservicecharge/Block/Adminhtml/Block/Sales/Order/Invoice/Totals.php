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
class Emipro_Paymentservicecharge_Block_Adminhtml_Block_Sales_Order_Invoice_Totals extends Mage_Adminhtml_Block_Sales_Order_Invoice_Totals
{
    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
         parent::_initTotals();
       
		$amt = $this->getSource()->getServiceCharge();
        $nameAmt = $this->getSource()->getServiceChargeName();
        if ($amt && $amt!=0) {
            $this->addTotalBefore(new Varien_Object(array(
                'code'      =>  'service_charge',
                'value'     =>  $amt,
				'label'     => $nameAmt,
				'base_value'=> $this->getSource()->getBaseServiceCharge(),
                    )), 'service_charge');
        }
	
 
        return $this;
    }
 
}
