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
class Emipro_Paymentservicecharge_Model_Order_Pdf_Total_Servicecharge extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    public function getTotalsForDisplay()
    {
	
		$amt = $this->getSource()->getServiceCharge();
        $nameAmt = $this->getSource()->getServiceChargeName();
        if ($amt != 0 ) {
        $total = array(
            'amount'    => $amt,
            'label' => $nameAmt
           
        );
        
       }
        return array($total);
    }
}
