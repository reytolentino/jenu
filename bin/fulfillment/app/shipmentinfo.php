<?php
require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';

$shipmentInfo = $catalog->getShipmentInfo(100001344);

var_dump($shipmentInfo);
echo "============================ <br>";
$InfoProware = $fulfillment->getOrderStatus(array(100002885));
if (empty($InfoProware)) {
  echo "result is empty";
} else { 
var_dump($InfoProware);
echo "============================ <br>";
foreach ($InfoProware as $orderN=>$infor){
	echo "order id". $orderN;
	echo "dumping information-----------------------....";
	var_dump($infor);
}
};
//var_dump($shipmentInfo['tracks']);