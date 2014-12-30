<?php 

require dirname(dirname(__FILE__)) . '/lib/debug.php';
require dirname(dirname(__FILE__)) . '/lib/fulfillment.php';
require dirname(dirname(__FILE__)) . '/lib/setup.php';


//$order = $catalog->getOrderInfo(array_slice($argv,1));
// Put in an order number for testing, should work with line above uncommented
$order = $catalog->getOrderInfo(100000001);
echo <<< END

== Summary ====================================================================

Order ID ............. {$order['order_id']}
Increment ID ......... {$order['increment_id']}
Created On ........... {$order['created_at']}
Updated On ........... {$order['updated_at']}
Grand Total .......... {$order['grand_total']}
Total Paid ........... {$order['total_paid']}
Total Invoiced ....... {$order['total_invoiced']}
Order Status ......... {$order['status']}
Order State .......... {$order['state']}
Weight ............... {$order['weight']}
PO Number ............ {$order['payment']['po_number']}

== Shipping To =================================================================

{$order['shipping_address']['firstname']} {$order['shipping_address']['lastname']}
{$order['shipping_address']['company']}
{$order['shipping_address']['street']}
{$order['shipping_address']['city']}, {$order['shipping_address']['region']} {$order['shipping_address']['postcode']}

== Billed To ===================================================================

{$order['billing_address']['firstname']} {$order['billing_address']['lastname']}
{$order['billing_address']['company']}
{$order['billing_address']['street']}
{$order['billing_address']['city']}, {$order['billing_address']['region']} {$order['billing_address']['postcode']}

== Items Ordered ===============================================================


END;

foreach ($order['items'] as $item) {
    cprintf('%2d x %-60.60s @ $%s',
        (int) $item['qty_ordered'],
        $item['name'],
        number_format($item['price'], 2)
    );
}

cprintf(PHP_EOL . '== Comment History =============================================================' . PHP_EOL);

foreach($order['status_history'] as $status) {
    cprintf('%s.10 (%s) %s', $status['created_at'], $status['status'], empty($status['comment']) ? '[empty]' : $status['comment']);
}

cprintf('');

exit;
