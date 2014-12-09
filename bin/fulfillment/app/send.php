<?php 

chdir(dirname(__FILE__));

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';

// Orders to be sent to fulfillment
$fulfillmentOrders = array(
    'standard' => array(),
    'etailers' => array()
);
//die("\nNot sending orders in dev environment");
// Outbound orders
$magentoOrders = array(
    'standard' => $catalog->getStandardOrders(),
    'etailers' => $catalog->getEtailerOrders()
);

// Standard Orders First
// =============================================================================

foreach ($magentoOrders['standard'] as $order) {
	
     $fulfillmentOrders['standard'][] = $fulfillment->formatOrderData($order);
}
//print_r($fulfillmentOrders['standard']); exit;
if (empty($fulfillmentOrders['standard'])) {
  echo "No standard orders to send.\n";
  
}
else {
    echo "Sending " . count($fulfillmentOrders['standard']) . " standard orders to fulfillment: ";

    // Attempt to send each order. Orders that are sent successfully are then marked as SENT
    foreach($fulfillmentOrders['standard'] as $order) {
        try {
            if ($fulfillment->sendOrder(array($order))) {
                print_r($order);
                $incrementId = str_replace('845_', '', $order['OrderNumber']);
                $catalog->setOrderFulfillmentStatus($incrementId, 'SENT', 'processing');
            } else { // Failure condition logged in sendOrder
                echo "Unable to send standard order $incrementId. \n";
            }
        } catch (Exception $e) {
            logError($e);
        }
    }
    /*if ($fulfillment->sendOrder($fulfillmentOrders['standard'])) {
        foreach ($magentoOrders['standard'] as $order) {
            echo ". ";
            $catalog->setOrderFulfillmentStatus($order['increment_id'], 'SENT', 'processing');
        }

        echo "Done.\n";
    }
    else {
        echo "Unable to send order.\n";
    }*/
}

// Etailer Order last (note the different status)
// =============================================================================

foreach ($magentoOrders['etailers'] as $order) {
     $fulfillmentOrders['etailers'][] = $fulfillment->formatOrderData($order, $catalog);
}

if (empty($fulfillmentOrders['etailers'])) {
    echo "No etailer orders to send.\n";
}
else {
    echo "Sending " . count($fulfillmentOrders['etailers']) . " etailers orders to fulfillment: ";

    // Attempt to send each order. Orders that are sent successfully are then marked as SENT
    foreach($fulfillmentOrders['etailers'] as $order) {
        try {
            if ($fulfillment->sendOrder(array($order))) {
                $incrementId = str_replace('845_', '', $order['OrderNumber']);
                $catalog->setOrderFulfillmentStatus($incrementId, 'SENT', 'processing');
            } else { // Failure condition logged in sendOrder
                echo "Unable to send etailers order $incrementId. \n";
            }
        } catch (Exception $e) {
            logError($e);
        }
    }
    /*if ($fulfillment->sendOrder($fulfillmentOrders['etailers'])) {
        foreach ($magentoOrders['etailers'] as $order) {
            echo ". ";
            $catalog->setOrderFulfillmentStatus($order['increment_id'], 'SENT', 'pending');
        }

        echo "Done.\n";
    }
    else {
        echo "Unable to send order.\n";
    }*/
}

// Send error report
//sendErrorReport();
