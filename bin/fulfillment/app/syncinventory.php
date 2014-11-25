<?php


chdir(dirname(__FILE__));

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';
echo "Begin synchronize inventory \n";

$inventory_info = $fulfillment->getInventory();
if ( $inventory_info) {
	$catalog->synchQuantity($inventory_info);
}
echo "Done with synchronization quantity \n";
exit;
