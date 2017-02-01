<?php
/**
 * Install Notification Table
 *
 * @category    Installer
 * @package     Gremlin_Lowstocknotify
 * @author      Junaid Bhura <info@gremlin.io>
 */

$installer = $this;
$installer->startSetup();

$sql = <<<SQLTEXT
CREATE TABLE IF NOT EXISTS `{$this->getTable( 'gremlin_lowstocknotify' )}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `notified_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQLTEXT;

$installer->run( $sql );
$installer->endSetup();
