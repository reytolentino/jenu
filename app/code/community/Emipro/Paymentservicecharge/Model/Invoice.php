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
class  Emipro_Paymentservicecharge_Model_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
			
		$order_id=$invoice->getOrderId();
		$order=Mage::getModel('sales/order')->load($order_id);
		$invoice->setServiceCharge($order->getServiceCharge());
		$invoice->setBaseServiceCharge($order->getBaseServiceCharge());
        $invoice->setServiceChargeName($order->getServiceChargeName());
		$invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getServiceCharge());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBaseServiceCharge());
		return $this;
    }
}
