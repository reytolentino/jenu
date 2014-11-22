<?php


$installer = $this;

/* $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$connection = $installer->getConnection();
$connection->addColumn($this->getTable('sarp/subscription'), 'date_canceled', 'date default NULL');
        
$installer->endSetup();
