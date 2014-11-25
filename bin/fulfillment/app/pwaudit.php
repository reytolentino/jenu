<?php 

$orderNumbers = array_slice($argv,1);

if (empty($orderNumbers)) {
    die(debug('You need to specify some order numbers... Lets try that again shall we?'));
}

$user = 'clientdev';
$pass = 'prolog';
$prowares = new SoapClient('http://clientws.prolog3pl.com/ProWaresService.asmx?WSDL', array(
	'trace' => 1,
	'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));

$magento = new SoapClient('http://dev4.ecoxotic.com/index.php/api/soap?wsdl', array(
	'trace' => 1,
	'features' => SOAP_SINGLE_ELEMENT_ARRAYS
));
$sessionId = $magento->login('prowares', 'asdfjkl;');

###################################################################################################
###################################################################################################
###################################################################################################

$out = array();

try {
    $status = $prowares->PLGetOrderStatus(array(
        'args' => array(
            'SystemId' => $user,
            'Password' => $pass,
            'OrderNumbers' => array_map('prowares_order', $orderNumbers)
        )
    ));
    
    // die(debug($status));
}
catch (Exception $e) {
    debug('Unable to get order data for order ' . $orderNumber);
}

$orders = $status->PLGetOrderStatusResult->Orders->PLOrderStatusHeader;

die(debug($orders));

foreach ($orders as $order) {
    $mageOrder = $magento->call($sessionId, 'sales_order.info', array(
        array(magento_order($order->OrderNumber))
    ));
    
    $orderSummary = array(
        'status'    => $order->Status,
        'shipments' => array()
    );

    $shipments = $order->Shipments;
    
    if (!empty($shipments->PLOrderStatusShipment)) {
        $shipments = $shipments->PLOrderStatusShipment;
    }
    else {
        continue;
    }
    
    $shipmentsCounter = -1;

    foreach ($shipments as $shipment) {
        $packages = (!empty($shipment->Packages) && !empty($shipment->Packages->PLOrderStatusPackage))
            ? $shipment->Packages->PLOrderStatusPackage
            : null;
        
        if ($packages === null) continue;
        
        $orderSummary['shipments'][++$shipmentsCounter] = array(
            'trackingNumbers' => array(),
            'items' => array()
        );

        foreach ($packages as $package) {
            $orderSummary['shipments'][$shipmentsCounter]['trackingNumbers'][] = $package->TrackingNumber;
            $items = $package->Contents->PLOrderStatusPackageContent;

            foreach ($items as $item) {
                // $orderSummary['shipments'][$shipmentsCounter]['items'][$item->Sku] = $item->SkuQuantity;
                $orderSummary['shipments'][$shipmentsCounter]['items'][$item->Product] = $item->SkuQuantity;
            }
        }
    }

    $out[] = $orderSummary;
}

die(debug($out));

###################################################################################################
###################################################################################################
###################################################################################################

function debug($data)
{
    $out = array();
    $args = func_get_args();
    
    if (is_object($data) or is_array($data)) {
        foreach ($args as $arg) {
            $out[] = print_r($arg, 1);
        }
    }
    else {
        $args = func_get_args();
        $out[] = call_user_func_array('sprintf', $args);
    }
    
    return implode(str_repeat('-', 80) . PHP_EOL, $out) . PHP_EOL;
}

function dump($title, $data)
{
    echo PHP_EOL;
    echo $title . PHP_EOL;
    echo str_repeat('=', 80) . PHP_EOL;
    echo $data . PHP_EOL;
}

function prowares_order($orderNumber)
{
    return '845_' . magento_order($orderNumber);
}

function magento_order($orderNumber)
{
    return str_replace('845_', '', $orderNumber);
}