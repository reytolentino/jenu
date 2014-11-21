<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getTable('sales/quote');

$installer->getConnection()->addColumn($table, 'authorizenetcim_customer_id', "VARCHAR(40) DEFAULT NULL");
$installer->getConnection()->addColumn($table, 'authorizenet_cim_payment_id', "VARCHAR(40) DEFAULT NULL");

$installer->endSetup();