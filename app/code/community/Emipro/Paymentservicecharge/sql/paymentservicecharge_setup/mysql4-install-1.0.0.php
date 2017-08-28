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
 
$installer = $this;  
$installer->startSetup();

$installer->run("ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `base_service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `service_charge_name` varchar(255)  NULL");

$installer->run("ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `base_service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `service_charge_name` varchar(255)  NULL");

$installer->run("ALTER TABLE  `".$this->getTable('sales/invoice')."` ADD  `service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/invoice')."` ADD  `base_service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/invoice')."` ADD  `service_charge_name` varchar(255)  NULL");

$installer->run("ALTER TABLE  `".$this->getTable('sales/creditmemo')."` ADD  `service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/creditmemo')."` ADD  `base_service_charge` DECIMAL( 10, 2 )  NULL");
$installer->run("ALTER TABLE  `".$this->getTable('sales/creditmemo')."` ADD  `service_charge_name` varchar(255)  NULL");

$installer->endSetup();



?>
