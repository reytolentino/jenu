<?php 

require dirname(dirname(__FILE__)) . '/lib/debug.php';
require dirname(dirname(__FILE__)) . '/lib/fulfillment.php';
require dirname(dirname(__FILE__)) . '/lib/setup.php';

//$order = $fulfillment->getOrderStatus(array_slice($argv,1,1));
//$order = $order[ $argv[1] ];
$order="TEST1";
echo <<< END

== Summary ====================================================================

Order Status ......... {$order['status']}

== Shipments ===================================================================


END;

foreach ($order['shipments'] as $shipment) {
    cprintf('Service ...... ' . $shipment['service']);
    cprintf('Tracking ..... ' . implode(', ', $shipment['trackingNumbers']));
    
    foreach ($shipment['items'] as $sku => $qty) {
        cprintf('%d x %s', $qty, $sku);
    }
}

cprintf('');

exit;