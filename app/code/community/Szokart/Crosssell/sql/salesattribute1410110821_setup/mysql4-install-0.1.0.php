<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("quote_address", "crosssell_total", array("type"=>"varchar"));
$installer->addAttribute("order", "crosssell_total", array("type"=>"varchar"));
$installer->endSetup();
	 