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
class Emipro_Paymentservicecharge_Adminhtml_PaymentservicechargebackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Backend Page Title"));
	   $this->renderLayout();
    }
}
