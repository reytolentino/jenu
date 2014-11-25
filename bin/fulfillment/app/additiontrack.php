<?php
chdir(dirname(__FILE__));

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';

echo "begin";
$pseuOrderArr = array(100002885);

$infoFromProware = $fulfillment->getOrderStatus($pseuOrderArr);
var_dump($infoFromProware);

//////////////////
$E =array (
'status'=>"COMPLETED",
'shipments'=> array(
array('service'=>'U11',
'trackingNumbers' => array('123_FAKE', 'meadd')
)
),
);

$m = array('status'=>'COMPLETED',
'shipments'=>array(array('service'=>'U11',
'trackingNumbers'=> array('test1','test2')), 
array('service' =>'U11',
'trackingNumbers'=>array('tttr', 'seco777'))
));
if (empty($m)) {

}
//
//$infoFromProware = array(100002885=> $E);
$infoFromProware = array(100002885=>$m);
echo "THUY TEESSTT";
//ad more tracking number to information provided by Prowares
//foreach ($infoFromProware as $orderId => $detail) {
	//foreach ($detail['shipments'] as $shipment)  {
	 //$shipment['trackingNumbers'][]= "hungnamadd";
	     	// $infoFromProware[$orderId]['shipments']['trackingNumbers'][] = "hungnamadd";
	//} 
	
//}
//////////////modification
//for ($i= 0; $i  < count($infoFromProware); $i++) {
     
	//for ($j = 0; $j < count(); $j++) {
	
	//}
//}
//////////////////////
///

//$infoFromProware = $fulfillment->getOrderStatus($pseuOrderArr);

if (!empty($infoFromProware)) {
	foreach ($infoFromProware as $orderNumber=> $detailProware) {
	  // shipment id correspondent to the $orderNumber
	  
        	  $shipmentId = $catalog->getShipmentIdByOrderId($orderNumber);
	  echo "Order id ".$orderNumber;
	  echo "Shipment id is .". $shipmentId;
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