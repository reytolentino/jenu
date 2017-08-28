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
class  Emipro_Paymentservicecharge_Model_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
		
		$order_id=$creditmemo->getOrderId();
		$order=Mage::getModel('sales/order')->load($order_id);
		$creditmemo->setServiceCharge($order->getServiceCharge());
		$creditmemo->setBaseServiceCharge($order->getBaseServiceCharge());
        $creditmemo->setServiceChargeName($order->getServiceChargeName());
		
        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getServiceCharge());
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getBaseServiceCharge());

        return $this;
    }
}
