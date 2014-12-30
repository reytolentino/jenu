<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getTable('authorizenetcim/profile');

$installer->getConnection()->addColumn($table, 'is_test_mode', "INT(11) DEFAULT 0");

$installer->endSetup();