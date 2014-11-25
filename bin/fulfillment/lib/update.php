<?php 

chdir(dirname(__FILE__));

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';



// Orders which can be updated
$orders = array(
    'standard' => $catalog->getStandardUpdatableOrders(),
    'etailers' => $catalog->getEtailerUpdatableOrders()
);
$orders = array_merge($orders['standard'], $orders['etailers']);
//$orders[] = '845_100002859';

//print_r($orders);
echo "Found " . count($orders) . " orders in need of updates.\n";

if (!empty($orders)) {
    $updatableOrders = $fulfillment->getOrderStatus($orders);
    echo count($updatableOrders) . " of which have updates.\n";

    if (!empty($updatableOrders)) {
        foreach ($updatableOrders as $orderNumber => $details) {
            cprintf('Updating order "%s"', $orderNumber);
            
            foreach ($details['shipments'] as $shipment) {
                cprintf('Creating shipment for order "%s"', $orderNumber);
                $catalog->createShipment($orderNumber, $shipment);
            }
            
            $orderInfo = $catalog->getOrderInfo($orderNumber);
            $lastMagentoStatus = $orderInfo['status_history'][0]['status'];

            // The status according to Magento should be 'processing' unless the shipment
            // status is 'COMPLETED', then it should be 'complete'
            $magentoStatus = $details['status'] === 'COMPLETED' ? 'complete' : $lastMagentoStatus;
            
            cprintf('Last status for order "%s" was "%s". Updating to "%s".', $orderNumber, $lastMagentoStatus, $magentoStatus);
            $catalog->setOrderFulfillmentStatus($orderNumber, $details['status'], $magentoStatus);
        }
    }
}

echo "Done\n";

echo "Update tracking number for the shipments which created in the range 7 days recently .\n";
$orderArr = $catalog->getListShipmentByTime();
if (!empty($orderArr))  {
$infoFromProware = $fulfillment->getOrderStatus($orderArr);

if (!empty($infoFromProware)) {
	foreach ($infoFromProware as $orderNumber=> $detailProware) {
	  // shipment id correspondent to the $orderNumber
	  
	  $shipmentId = $catalog->getShipmentIdByOrderId($orderNumber);
	  
	 foreach ($detailProware['shipments'] as $shipment) {
	 	if (!empty( $shipment['trackingNumbers'])) {
	 		foreach ($shipment['trackingNumbers'] as $trackingNumberProwares) {
					 	$exist = $catalog->trackingNumberAlreadyExist($shipmentId,$trackingNumberProwares );   	
					 	
					 	if (!$exist) {
					 		$catalog->addTrackingNumber($shipmentId, 'custom' , $shipment['service'] , $trackingNumberProwares);
					 		echo "Updating tracking number ". $trackingNumberProwares. " for shipment id " . $shipmentId;
					 	}  else {
					 	   echo "The tracking number ". $trackingNumberProwares. "already exist. Skip .\n";
					 	}
	 		}
	 	} 
	  }
    }
    
    echo "end of updating additional tracking numbers \n";
}
}
exit;
