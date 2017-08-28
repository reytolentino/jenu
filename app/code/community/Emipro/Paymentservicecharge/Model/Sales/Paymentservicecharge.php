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
class Emipro_Paymentservicecharge_Model_Sales_Paymentservicecharge extends Mage_Sales_Model_Quote_Address_Total_Abstract{
    protected $_code = 'fee';
 
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
		$items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }
			
		$quote = $address->getQuote();
		$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrency()->getCode();
		if($quote->getPayment()->getMethod()!="")
		{
			$paymentcode = $quote->getPayment()->getMethod();
			$service_charge=Mage::helper("emipro_paymentservicecharge")->paymentServiceCharge($paymentcode,$currentCurrencyCode);
			if($service_charge["enable"] && ($quote->getPayment()->getMethod()!=$service_charge["selected_method"]))
			{
				$address->setServiceCharge(0);
				$address->setBaseServiceCharge(0);
				$quote->setServiceCharge(0);
				$quote->setBaseServiceCharge(0);
				$address->setGrandTotal(0);
				$address->setBaseGrandTotal(0);
			}
			if($service_charge["enable"] && ($quote->getPayment()->getMethod()==$service_charge["selected_method"] || $service_charge["selected_method"]==32000))
			{
				$fee =$service_charge["charge"];
				$balance = $fee;
				if($balance!=0)
				{
					$address->setServiceCharge($balance);
					$address->setBaseServiceCharge($service_charge["base_charge"]);
					$address->setServiceChargeName($service_charge["name"]);
					$quote->setServiceCharge($balance);
					$quote->setBaseServiceCharge($service_charge["base_charge"]);
					$address->setGrandTotal($address->getGrandTotal() + $address->getServiceCharge());
					$address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseServiceCharge());
				}
			}
		}	
        
    }
 
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
		$quote = $address->getQuote();
		if($quote->getPayment()->getMethod()!="")
		{
			$paymentcode=$quote->getPayment()->getMethod();
			$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrency()->getCode();
			$service_charge=Mage::helper("emipro_paymentservicecharge")->paymentServiceCharge($paymentcode,$currentCurrencyCode);
			if($service_charge["enable"] && ($quote->getPayment()->getMethod()==$service_charge["selected_method"] || $service_charge["selected_method"]==32000))
			{
				$amt = $address->getServiceCharge();
				if($amt!=0)
				{
					$address->addTotal(array(
						'code'=>$this->getCode(),
						'title'=>$service_charge["name"],
						'value'=> $amt
					));
				}
			}
		}
			
		return $this;
	}
}
