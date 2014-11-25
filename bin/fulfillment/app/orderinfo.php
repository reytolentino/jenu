<?php 

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';

$order = $catalog->getOrderInfo(100000206);
//$order = $fulfillment->getOrderStatus(array('100000222'));

print_r($order);

echo "Done\n";
