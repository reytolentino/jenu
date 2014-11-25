<?php 

chdir(dirname(__FILE__));

require '../lib/debug.php';
require '../lib/fulfillment.php';
require '../lib/setup.php';

//$p_info = $catalog->unit_test_getQty('tet');
//print_r($p_info);
try {
//$catalog->getListShipment();
//$catalog->sendWinMail();
echo "+++++++++++++++++++++++++++++++++++++++++++++++++";
$catalog->getListShipmentByTime();
} catch (Exception 

$e) {
	echo "there is an exception";
}
