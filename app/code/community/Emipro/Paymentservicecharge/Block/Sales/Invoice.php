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
class Emipro_Paymentservicecharge_Block_Sales_Invoice extends Mage_Sales_Block_Order_Invoice_Totals {

    protected function _initTotals() {
        parent::_initTotals();
        $cur_order_id=$this->getRequest()->getParam('order_id');
		//$order_id=Mage::helper("emipro_codpayment")->get_selected_method($cur_order_id);
        $amt = $this->getSource()->getServiceCharge();
        $nameAmt = $this->getSource()->getServiceChargeName();
        if ($amt != 0) {
            $this->addTotal(new Varien_Object(array(
                        'code' => $this->getCode(),
                        'value' => $amt,
						'base_value' =>  $this->getSource()->getBaseServiceCharge(),
                        'label' => $nameAmt,
                    )), 'service_charge');
        }
        return $this;
    }

}
