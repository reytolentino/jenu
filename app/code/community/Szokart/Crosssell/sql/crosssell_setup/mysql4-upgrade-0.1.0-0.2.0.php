<?php
$installer = $this;

$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('crosssell')};

CREATE TABLE {$this->getTable('crosssell')} (
  `cs_id` int(11) unsigned NOT NULL auto_increment,
  `proid` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `namepro` varchar(255) NOT NULL default '',
  `proval` int(11),
  `lager` int(11),
  `status` int(11),
  `dfrom` datetime NULL,
  `dto` datetime NULL,
   `stores` text default '',
  `customer_group` text default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
 `prosku` text default '',
  PRIMARY KEY (`cs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('crosssellx')};

CREATE TABLE {$this->getTable('crosssellx')} (
  `csx_id` int(11) unsigned NOT NULL auto_increment,
  `cs_id` int(11),
  `proid` varchar(255) NOT NULL default '',
  `namepro` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`csx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


"); 

$installer->endSetup(); 

