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
 
class Emipro_Paymentservicecharge_IndexController extends Mage_Core_Controller_Front_Action
{   
    
	public function paymentservicechargeAction() 
	{		
		$modules = Mage::getConfig()->getNode('modules')->children();
		$modulesArray = (array)$modules;		
		if(isset($modulesArray['Emipro_Paymentservicecharge']) && $modulesArray['Emipro_Paymentservicecharge']->active=='true') {
				$this->getResponse()->setBody("true");
		} else {
			$this->getResponse()->setBody("false");
		}   
	}	
 
}
