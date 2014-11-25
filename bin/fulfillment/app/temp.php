<?php 

/*
 * array(
 *      'status' => 'foo',
 *      'shipments' => array(
 *          '0' => array(
 *              'trackingNumbers' => array(
 *                  '0' => array('carier' => 'abc', 'number' => '123'),
 *                  '1' => ...
 *              )
 *              'items' => array(
 *                  '123456789' => '3', // Item ID => QTY
 *                  ...
 *              )
 *          ),
 *          '1' => ...
 *      )
 *  )
 */

$out = array();
$data = unserialize('O:8:"stdClass":1:{s:22:"PLGetOrderStatusResult";O:8:"stdClass":2:{s:6:"Orders";O:8:"stdClass":1:{s:19:"PLOrderStatusHeader";a:1:{i:0;O:8:"stdClass":8:{s:13:"ProLogOrderId";s:36:"975f0f6f-3c2b-4c0c-b102-4eebe9d4ce23";s:11:"OrderNumber";s:13:"966_100000222";s:6:"Status";s:9:"COMPLETED";s:13:"CompletedDate";s:23:"2010-03-25T15:41:25.663";s:15:"ShippingService";s:5:"FEDEG";s:15:"LastUpdatedDate";s:22:"2010-03-25T15:42:14.76";s:5:"Lines";O:8:"stdClass":1:{s:17:"PLOrderStatusLine";a:6:{i:0;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092026;s:10:"LineNumber";i:0;s:7:"Product";s:4:"6061";s:15:"QuantityOrdered";i:2;s:15:"QuantityShipped";i:2;s:19:"QuantityBackordered";i:0;}i:1;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092027;s:10:"LineNumber";i:1;s:7:"Product";s:4:"8008";s:15:"QuantityOrdered";i:1;s:15:"QuantityShipped";i:1;s:19:"QuantityBackordered";i:0;}i:2;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092028;s:10:"LineNumber";i:2;s:7:"Product";s:4:"1010";s:15:"QuantityOrdered";i:1;s:15:"QuantityShipped";i:1;s:19:"QuantityBackordered";i:0;}i:3;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092029;s:10:"LineNumber";i:3;s:7:"Product";s:4:"8030";s:15:"QuantityOrdered";i:2;s:15:"QuantityShipped";i:2;s:19:"QuantityBackordered";i:0;}i:4;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092030;s:10:"LineNumber";i:4;s:7:"Product";s:4:"8013";s:15:"QuantityOrdered";i:2;s:15:"QuantityShipped";i:2;s:19:"QuantityBackordered";i:0;}i:5;O:8:"stdClass":6:{s:12:"ProLogLineId";i:1092031;s:10:"LineNumber";i:5;s:7:"Product";s:4:"8210";s:15:"QuantityOrdered";i:1;s:15:"QuantityShipped";i:1;s:19:"QuantityBackordered";i:0;}}}s:9:"Shipments";O:8:"stdClass":1:{s:21:"PLOrderStatusShipment";a:1:{i:0;O:8:"stdClass":6:{s:16:"ProLogShipmentId";i:455674;s:9:"Warehouse";s:11:"San Diego A";s:15:"ShippingService";s:5:"FEDEG";s:6:"Status";s:7:"SHIPPED";s:11:"ShippedDate";s:21:"2010-03-25T15:41:25.6";s:8:"Packages";O:8:"stdClass":1:{s:20:"PLOrderStatusPackage";a:3:{i:0;O:8:"stdClass":6:{s:20:"ProLogTrackingNumber";i:549636;s:14:"TrackingNumber";s:15:"092448871330306";s:11:"ShippedDate";s:23:"2010-03-25T15:40:15.513";s:6:"Weight";s:5:"15.00";s:4:"Cost";s:6:"6.2000";s:8:"Contents";O:8:"stdClass":1:{s:27:"PLOrderStatusPackageContent";a:5:{i:0;O:8:"stdClass":6:{s:7:"Product";s:4:"1010";s:8:"Quantity";i:1;s:3:"Sku";s:12:"845881010102";s:11:"SkuQuantity";i:1;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":0:{}}i:1;O:8:"stdClass":6:{s:7:"Product";s:4:"8030";s:8:"Quantity";i:2;s:3:"Sku";s:12:"845881080303";s:11:"SkuQuantity";i:2;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":1:{s:33:"PLOrderStatusPackageContentSerial";a:12:{i:0;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (2 of 6)";s:6:"Serial";s:13:"8010021002350";}i:1;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (5 of 6)";s:6:"Serial";s:13:"8010021002359";}i:2;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (6 of 6)";s:6:"Serial";s:13:"8010021002358";}i:3;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (4 of 6)";s:6:"Serial";s:13:"8010021002348";}i:4;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (5 of 6)";s:6:"Serial";s:13:"8010021002347";}i:5;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (2 of 6)";s:6:"Serial";s:13:"8010021002362";}i:6;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (3 of 6)";s:6:"Serial";s:13:"8010021002349";}i:7;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (1 of 6)";s:6:"Serial";s:13:"8010021002351";}i:8;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (6 of 6)";s:6:"Serial";s:13:"8010021002346";}i:9;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (1 of 6)";s:6:"Serial";s:13:"8010021002363";}i:10;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (3 of 6)";s:6:"Serial";s:13:"8010021002360";}i:11;O:8:"stdClass":2:{s:11:"Description";s:22:"Serial Number (4 of 6)";s:6:"Serial";s:13:"8010021002361";}}}}i:2;O:8:"stdClass":6:{s:7:"Product";s:4:"8008";s:8:"Quantity";i:1;s:3:"Sku";s:12:"845881080082";s:11:"SkuQuantity";i:1;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":0:{}}i:3;O:8:"stdClass":6:{s:7:"Product";s:4:"8013";s:8:"Quantity";i:2;s:3:"Sku";s:12:"845881080136";s:11:"SkuQuantity";i:2;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":1:{s:33:"PLOrderStatusPackageContentSerial";a:2:{i:0;O:8:"stdClass":2:{s:11:"Description";s:8:"Serial #";s:6:"Serial";s:13:"8013021000584";}i:1;O:8:"stdClass":2:{s:11:"Description";s:8:"Serial #";s:6:"Serial";s:13:"8013021000593";}}}}i:4;O:8:"stdClass":6:{s:7:"Product";s:4:"8210";s:8:"Quantity";i:1;s:3:"Sku";s:12:"845881082109";s:11:"SkuQuantity";i:1;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":1:{s:33:"PLOrderStatusPackageContentSerial";a:4:{i:0;O:8:"stdClass":2:{s:11:"Description";s:17:"Serial # (3 of 4)";s:6:"Serial";s:16:"8200 06 10 00042";}i:1;O:8:"stdClass":2:{s:11:"Description";s:17:"Serial # (2 of 4)";s:6:"Serial";s:16:"8200 06 10 00043";}i:2;O:8:"stdClass":2:{s:11:"Description";s:17:"Serial # (1 of 4)";s:6:"Serial";s:16:"8200 06 10 00044";}i:3;O:8:"stdClass":2:{s:11:"Description";s:17:"Serial # (4 of 4)";s:6:"Serial";s:16:"8200 06 10 00041";}}}}}}}i:1;O:8:"stdClass":6:{s:20:"ProLogTrackingNumber";i:569363;s:14:"TrackingNumber";s:15:"092448871330337";s:11:"ShippedDate";s:23:"2010-03-25T15:41:19.003";s:6:"Weight";s:5:"35.00";s:4:"Cost";s:7:"10.3200";s:8:"Contents";O:8:"stdClass":1:{s:27:"PLOrderStatusPackageContent";a:1:{i:0;O:8:"stdClass":6:{s:7:"Product";s:4:"6061";s:8:"Quantity";i:1;s:3:"Sku";s:12:"845881060619";s:11:"SkuQuantity";i:1;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":1:{s:33:"PLOrderStatusPackageContentSerial";a:1:{i:0;O:8:"stdClass":2:{s:11:"Description";s:8:"Serial #";s:6:"Serial";s:17:"6030 40 09 000130";}}}}}}}i:2;O:8:"stdClass":6:{s:20:"ProLogTrackingNumber";i:569362;s:14:"TrackingNumber";s:15:"092448871330320";s:11:"ShippedDate";s:22:"2010-03-25T15:41:04.83";s:6:"Weight";s:5:"35.00";s:4:"Cost";s:7:"10.3200";s:8:"Contents";O:8:"stdClass":1:{s:27:"PLOrderStatusPackageContent";a:1:{i:0;O:8:"stdClass":6:{s:7:"Product";s:4:"6061";s:8:"Quantity";i:1;s:3:"Sku";s:12:"845881060619";s:11:"SkuQuantity";i:1;s:4:"Lots";O:8:"stdClass":0:{}s:7:"Serials";O:8:"stdClass":1:{s:33:"PLOrderStatusPackageContentSerial";a:1:{i:0;O:8:"stdClass":2:{s:11:"Description";s:8:"Serial #";s:6:"Serial";s:17:"6030 40 09 000131";}}}}}}}}}}}}}}}s:10:"ProLogCode";s:7:"SUCCESS";}}');

$orders = $data->PLGetOrderStatusResult->Orders->PLOrderStatusHeader;

foreach ($orders as $order) {
    $orderSummary = array(
        'status'    => $order->Status,
        'shipments' => array()
    );
    
    $shipments = $order->Shipments->PLOrderStatusShipment;
    $shipmentsCounter = -1;
    
    foreach ($shipments as $shipment) {
        $packages = $shipment->Packages->PLOrderStatusPackage;
        $orderSummary['shipments'][++$shipmentsCounter] = array(
            'trackingNumbers' => array(),
            'items' => array()
        );
        
        foreach ($packages as $package) {
            $orderSummary['shipments'][$shipmentsCounter]['trackingNumbers'][] = $package->TrackingNumber;
            $items = $package->Contents->PLOrderStatusPackageContent;
            
            foreach ($items as $item) {
                $orderSummary['shipments'][$shipmentsCounter]['items'][$item->Product] = $item->SkuQuantity;
            }
        }
    }
    
    $out[] = $orderSummary;
}

print_r($data);
print_r($out);