<?php

class Eco_Fulfillment_Auth_Catalog
extends Eco_Fulfillment_Auth
{
	protected $_wsdl = 'http://www.jenu.com/index.php/api/soap?wsdl';
	protected $_user = 'prolog2m';
	protected $_pass = 'pr0l0g2m;';
	
	public function __construct($wsdl = null)
	{
		if (!empty($wsdl)) {
			$this->_wsdl = $wsdl;
		}
		parent::__construct();
	}
	
	public function setWsdl($wsdl)
	{
		$this->_wsdl = $wsdl;
		return $this;
	}
	
	public function getWsdl()
	{
		return $this->_wsdl;
	}
}

class Eco_Fulfillment_Auth_Prowares_Devel
extends Eco_Fulfillment_Auth
{
	protected $_wsdl = 'http://clientws.prolog3pl.com/ProWaresService.asmx?WSDL';
	protected $_user = 'clientdev';
	protected $_pass = 'prolog';
}

class Eco_Fulfillment_Auth_Prowares_Prod
extends Eco_Fulfillment_Auth
{
	protected $_wsdl = 'http://clientws.prolog3pl.com/ProWaresService.asmx?WSDL';
	protected $_user = '845system';
	protected $_pass = '845!jEnU$';
}

class Eco_Fulfillment_Api_Catalog
extends Eco_Fulfillment_Api
{
	protected $fulfillmentMessagePrefix = 'Fulfillment Status is ';

	protected function _prepareApi()
	{
		$wsdl = $this->_auth->wsdl();
		$user = $this->_auth->user();
		$pass = $this->_auth->pass();

		// Log into the store
		$this->_api = new SoapClient($wsdl, array('trace' => 1, 'proxy_login'=>'rtolentino', 'proxy_password'=>'Today1020'));
		$sessionId = $this->_api->login($user, $pass);

		// Capture the session ID for later use
		$this->_auth->addValue('sessionId', $sessionId);
	}

	public function getOrders($status)
	{
		$out = array();
		$sessionId = $this->_auth->sessionId();
		$orders = $this->_api->call($sessionId, 'sales_order.list', array(
		array('status' => $status)
		));

		foreach ($orders as $order) {
		//fedor debug
		if($order['increment_id']=='100000984') continue;
		//end debug
			$out[] = $this->getOrderInfo($order['increment_id']);
		}
		//hungnam debug
		//if ($status == 'pending') {
       //print_r($out);
		//}
		return $out;
	}

	public function addOrderComment($orderIncrementId, $status, $comment = '', $notify = false)
	{
		$sessionId = $this->_auth->sessionId();

		return $this->_api->call($sessionId, 'sales_order.addComment', array(
		$orderIncrementId,
		$status,
		$comment,
		$notify
		));
	}

	public function getOrderInfo($orderIncrementId)
	{
		$sessionId = $this->_auth->sessionId();

		static $cache;

		if ($cache === null) {
			$cache = array();
		}

		if (empty($cache[$orderIncrementId])) {
			$cache[$orderIncrementId] = $this->_api->call($sessionId, 'sales_order.info', array(
			array($orderIncrementId)
			));

			printf('Read %s order %s.'.PHP_EOL, $cache[$orderIncrementId]['status'], $orderIncrementId);
		}
		else {
			printf('Read %s order %s. (Cache)'.PHP_EOL, $cache[$orderIncrementId]['status'], $orderIncrementId);
		}

		return $cache[$orderIncrementId];
	}

	public function getOrderFulfillmentStatus($orderIncrementId)
	{
		$orderInfo = $this->getOrderInfo($orderIncrementId);

		if (empty($orderInfo)) {
			return null;
		}

		// The order history is automatically sorted with the newest updates on
		// top. We need to look for the first status comment which looks like
		// "Fulfillment status is "
		foreach ($orderInfo['status_history'] as $status) {
			if (
			// If the comment is empty ...
			(empty($status['comment'])) ||

			// Or if the message prefix ISNT in the comment
			(!strstr($status['comment'], $this->fulfillmentMessagePrefix))) {
				// Get out of here     
				continue;
			}

			$fulfillmentStatus = str_replace($this->fulfillmentMessagePrefix, '', $status['comment']);

			if (!empty($fulfillmentStatus)) {
				return $fulfillmentStatus;
			}
		}
		// This order is unfulfilled
		return null;
	}

	public function setOrderFulfillmentStatus($orderIncrementId, $fulfillmentStatus, $magentoStatus)
	{
		$this->addOrderComment(
		$orderIncrementId,
		$magentoStatus,
		$this->fulfillmentMessagePrefix .
		$fulfillmentStatus,
		false
		);
	}

	public function getOrdersByFulfillmentStatus($fulfillmentStatus, $magentoStatus)
	{
		
		 
		$out = array();

		if (!is_array($fulfillmentStatus)) {
			$fulfillmentStatus = array($fulfillmentStatus);
		}

		$processingOrders = $this->getOrders($magentoStatus);
		foreach ($processingOrders as $order) {
			
			$orderFulfillmentStatus = $this->getOrderFulfillmentStatus($order['increment_id']);
			
			if (in_array($orderFulfillmentStatus, $fulfillmentStatus)) {
				$out[$order['increment_id']] = $order;
			}
		}
		
		return $out;
	}

	public function getStandardOrders()
	{
		return $this->getOrdersByFulfillmentStatus(null, 'processing');
	}

	public function getStandardUpdatableOrders()
	{
		$out = array();
		$orders = $this->getOrdersByFulfillmentStatus(array('OPEN', 'SENT'), 'processing');

		foreach ($orders as $order) {
			$out[] = $order['increment_id'];
		}

		return $out;
	}

	public function getEtailerOrders()
	{
		$out = array();
		$orders = $this->getOrdersByFulfillmentStatus(null, 'pending');

		// Etail orders are made with a PO number, and are "approved" by someone
		foreach ($orders as $order) {
			// First, make sure there's a PO number
			if (empty($order['payment']['po_number'])) {
				// continue;
			}

			// Find the "Approved" comment
			foreach ($order['status_history'] as $history) {
				if (strstr(strtoupper($history['comment']), 'APPROVED')) {
					$out[] = $order;
					break;
				}
			}
		}

		return $out;
	}

	public function getEtailerUpdatableOrders()
	{
		$out = array();
		$orders = $this->getOrdersByFulfillmentStatus('OPEN', 'pending');

		// Etail orders are made with a PO number, and are "approved" by someone
		foreach ($orders as $order) {
			// First, make sure there's a PO number
			if (empty($order['payment']['po_number'])) {
				continue;
			}

			// Find the "Approved" comment
			foreach ($order['status_history'] as $history) {
				if (strstr(strtoupper($history['comment']), 'APPROVED')) {
					$out[] = $order['increment_id'];
					break;
				}
			}
		}

		return $out;
	}

	/**
	 * The basic rules are:
	 *  - All orders should be shipped fedex ground by default.
	 *  - Orders 200lbs and more should be "LTL"
	 *  - The shipping code for fedex ground changes from dev to prod (not sure why, ask Prolog)
	 */
	public function getOrderShippingService($orderData)
	{
		/*
		if ($orderData['weight'] > 200) {
			return 'LTLTBD';
		}

		return 'U11';
		*/
		
		/*

		USPS: First Class                       USPSFC
		USPS: First Class International         USPSINTLFC
		USPS: Priority Mail                     USPSPRI
		USPS: Priority Mail International       USPSINTLPRI
		USPS: Express Mail International        USPSEXINTL
		
		FedEx: 2-Day                            FEDEX2
		FedEx: Standard Overnight               FEDEX1S
		
		UPS: Next Day Air Saver                 UPS1S
		UPS: 2nd Day Air                        UPS2

		*/

		$shippingService = 'USPSPRI';
		switch ($orderData['shipping_method']) {

			case 'freeshipping_freeshipping':
				$shippingService = 'USPSPRI';
				break;

			// FedEx: Standard Overnight
			case 'fedex_STANDARD_OVERNIGHT':
				$shippingService = 'FEDEX1S';
				break;

			case 'fedex_FEDEX_2_DAY':
				$shippingService = 'FEDEX2';
				break;

			default:
				$shippingService = 'USPSPRI';
		}
		return $shippingService;
	}


	// description :if the $item['sku'] equal the $ship['sku'] then get the qty of $skip
	public function findMatchingSkip($sk, $shipment) {
		foreach ($shipment['items'] as $sku=>$qty) {
			if ($sku == $sk) {
				return $qty;
			}
		}
        return 0;
	}

	public function createShipment($orderNumber, array $shipment)
	{

		$carrier_code = '';
		$tracking_description = '';
		$sessionId = $this->_auth->sessionId();

		if (empty($shipment['trackingNumbers'][0])) {
			echo "Not ready to apply tracking numbers yet. Bailing.\n";
			return;
		}

		$itemsQty = array();
		// Add the comment to the order
		try {
			$oderInfo = $this->_api->call($sessionId, "sales_order.info", $orderNumber);
			
			
			$tracking_description = $oderInfo['shipping_description'];
            $temporary = explode('_', $oderInfo['shipping_method']);
            $carrier_code = $temporary[0];
            
            
	  		$orderitems = $oderInfo['items'];
			foreach ($orderitems as $item) {
				//$itemsQty = array( $item['item_id']=> "1" );
				if ($this->findMatchingSkip($item['sku'], $shipment) != 0) {
					$itemsQty[$item['item_id']] = $this->findMatchingSkip($item['sku'], $shipment);
				}
			}
			$shipmentparam = array($orderNumber,
                                   $itemsQty,
                                   '',
                                   1);
			 
			 $shippingId = $this->_api->call($sessionId, 'sales_order_shipment.create', $shipmentparam );
			 
			 
		} catch (Exception $e) {

			echo "Failed to create shipment on $orderNumber. Did one exist already?\n";
			return false;
		}

		// echo "Created shipment: $shippingId\n";
        
		foreach ($shipment['trackingNumbers'] as $trackingNumber) {
			if ($carrier_code == 'dhl' || $carrier_code == 'ups' || $carrier_code == 'fedex' || $carrier_code == 'usps') {
			$this->_api->call($sessionId, 'sales_order_shipment.addTrack', array(
			$shippingId,
            $carrier_code, 
			$tracking_description,
			$trackingNumber
			));
			} else {
				$this->_api->call($sessionId, 'sales_order_shipment.addTrack', array(
			$shippingId,
            'custom', 
			$shipment['service'],
			$trackingNumber
			));
				
			}
		}
	}
	/**
	 * ad additional tracking number
	 */
	public function addTrackingNumber($shippingId, $carrier_code,$tracking_description, $trackingNumber) {
		$this->_api->call($this->_auth->sessionId(), 'sales_order_shipment.addTrack', array($shippingId, $carrier_code, $tracking_description, $trackingNumber));
		
	}
	
	/**
	 * get the shipment information to fetch the trackingNumber of shipment
	 * @param the shipment id
	 * @return the 
	 */
	public function getShipmentInfo($shipmentId) {
		$info = $this->_api->call($this->_auth->sessionId(), 'sales_order_shipment.info', $shipmentId);
		return $info;
	}
	
	/**
	 * check to see if the tracking number exist or not in a particular shipmentId
	 * @param shipment_id, tracking_numbers
	 */
	public function trackingNumberAlreadyExist($shipmentId, $trackingNumber) {
		$info = $this->_api->call($this->_auth->sessionId(), 'sales_order_shipment.info' , $shipmentId);
		if (empty($info)) {
			return false;
		} else {
			foreach ($info['tracks'] as $record) {
			    
				if ($record['number'] == $trackingNumber) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * synchronise the quantity of Magento with ProWares
	 * @author Luu Thanh Thuy luuthuy205@gmail.com
	 *
	 */
	public function synchQuantity($input) {

		$log = fopen('/var/www/sites/dev.jenu.com/var/log/qtysync.log', 'w');
		// fputs($log, print_r($input, true));
		
		$sessionId = $this->_auth->sessionId();
		$need_send_mail = false;
		$html = "<table> <tr> <td> sku </td> <td> Magento</td> <td> Prolog</td> <td>Difference </td></tr>\n";
		foreach ($input as $atom) {
			$product_exist = true;
			try  {
				fputs($log, $atom['sku'] . "\t: checking Magento... ");
				$product_exist = $this->_api->call($sessionId, 'product.info', $atom['sku']);
				fputs($log, "[exists] ");
			} catch (Exception $e) {
				//var_dump($e);
				$product_exist = false;
				$msg = "WARN: ProWares SKU '". $atom['sku']. "';\tMagento: " .$e->getMessage(). "<br>\n";
				fputs($log, $msg);
				echo $msg;
			}
			if ($product_exist) {
				// Gorilla Group improvenemt for EE version
				$doUpdate = true;
				try {
				    $qty = null;
				    $stock = $this->_api->call($sessionId, 'product_stock.list', $atom['sku']);
				    $qty = (isset($stock[0]['qty']) && !is_null($stock[0]['qty'])) ? (int)$stock[0]['qty'] : null;
				    if (!is_null($qty) && (int)$qty == (int)$atom['qty']) {
				        $doUpdate = false;
				    }
				    $product_exist['qty'] = $qty;
				    fputs($log, ": Qty:" .$qty. " | " .(int)$atom['qty']. "\n");
				} catch (Exception $e) {
				    fputs($log, ": Qty:ERROR:" .$e->getMessage(). "\n");
				}
				//if the quantity between the Magento and ProWares have a gap then update it and send notification email
				//if ($doUpdate) { // $product_exist['qty'] != $atom['qty'] ) {
				if ((int)$qty != (int)$atom['qty'] ) {
				    $need_send_mail = true;
				    $this->_api->call($sessionId, 'product_stock.update', array($atom['sku'], array('qty'=>$atom['qty'], 'is_in_stock'=>1)));
				    $dif = (int)$atom['qty'] - (int)$product_exist['qty'];
				    $html .= "<tr> <td>". $atom['sku']."</td> <td>". $product_exist['qty']."</td> <td>".$atom['qty'] ."</td> <td>". $dif ."</td></tr>\n";
				} else {
				    $html .= "<tr> <td>". $atom['sku']."</td> <td>". $product_exist['qty']."</td> <td>".$atom['qty'] ."</td> <td>-</td></tr>\n";
				}
			}
		} //end of foreach
		
		if ($need_send_mail) {
			$html .="</table>\n";
			try {
				echo $html;
				$this->_api->call($sessionId, 'product.sendWinMail', $html);
				fputs($log, "\nEmail log has been sent!\n");
			} catch (Exception  $e) { 
				fputs($log, "\nWARN: Email log has NOT been sent!\nWARN: " . $e->getMessage() . "\n");
			}
		}

		fputs($log, "\n$html\n");
		fclose($log);
	}
	
	
	public function sendWinMail() {
		$sessionId = $this->_auth->sessionId();
		
		 $this->_api->call($sessionId, 'product.sendWinMail', 'abitrary');
		
	}
	
	/***
	 * add by luuthuy205@gmail.com
	 * retrieve the list of shipment which is created in 7 days
	 */
	public function getListShipment() {
		$sessionId = $this->_auth->sessionId();
		
		//filters which specify the range of created day of the shipments
		$filters = array();
		$create = array("total_qty"=>1);
		
		$filters[] = $create;
		$result = $this->_api->call($sessionId , 'sales_order_shipment.list' , $filters);
		var_dump($result);
	}
	
	/**
	 *
	 */
	public function getListShipmentByTime() {
		$sessionId = $this->_auth->sessionId();
		
		//filters which specify the range of created day of the shipments
		$t = getdate(strtotime('now - 7 days'));
		$timeString = $t['year'].'-'. $t['mon']. '-'. $t['mday'];
		$filters = array();
		$create = array("created_at"=>array("from"=> $timeString));
		
		$filters[] = $create;
		$result = $this->_api->call($sessionId , 'sales_order_shipment.list' , $filters);
		//var_dump($result);/
		$orderIds = array();
		foreach ($result as $shipmentInfo) {
            if(isset($shipmentInfo['order_id']) {
                $orderIds[] = $shipmentInfo['order_id'];   //$orderIds[] = $shipmentInfo['increment_id'];
            }
		}
		return $orderIds;
	}
	
	/**
	 * get shipment_id by passing an param of increment_id (order_id)
	 * @param order_id
	 * @return shipment_id
	 * @author luuthuy205@gmail.com
	 */
	public function getShipmentIdByOrderId($orderId) {
	    $sessionId = $this->_auth->sessionId();
		
		//filters which specify the range of created day of the shipments
		$t = getdate(strtotime('now - 200 days'));
		$timeString = $t['year'].'-'. $t['mon']. '-'. $t['mday'];
		$filters = array();
		$create = array("created_at"=>array("from"=> $timeString));
		
		$filters[] = $create;
		
		$result = $this->_api->call($sessionId , 'sales_order_shipment.list' , $filters);
		
		$orderIds = array();
		foreach ($result as $shipmentInfo) {
			if ($shipmentInfo['order_increment_id'] == $orderId) {
				return $shipmentInfo['increment_id'];
			} 
		}
		return false;
	}
	

}

class Eco_Fulfillment_Api_Prowares
extends Eco_Fulfillment_Api
{
	public $orderNumberPrefix = '845_'; // Needed for sandboxed environment
	public $dateFormat = 'Y-m-d\Th:i:s'; // YYYY-MM-DDTHH:MM:SS
	public $orderDelay = ''; //15; // Minutes
	public $packingListMap = array(
	// Defaul to consumer
        '__DEFAULT__' => '', // '57588416-82EE-4F96-B2C8-86309B74B176', 

	// Wholesalers
        '2' => '' // 'F50453FC-73FA-4C80-AD30-10573DC93012'
        );
        protected $_catalogApi;

        public function __construct(Eco_Fulfillment_Auth $auth, Eco_Fulfillment_Api $catalogApi)
        {
        	$this->_catalogApi = $catalogApi;
        	parent::__construct($auth);
        }

        protected function getPackingListTemplate(array $orderData)
        {
        	if (!empty($this->packingListMap[$orderData['customer_group_id']])) {
        		return $this->packingListMap[$orderData['customer_group_id']];
        	}

        	return $this->packingListMap['__DEFAULT__'];
        }

        protected function _prepareApi()
        {
        	$wsdl = $this->_auth->wsdl();
        	$this->_api = new SoapClient($wsdl, array('trace'=>1,'features' => SOAP_SINGLE_ELEMENT_ARRAYS));
        }

        public function formatOrderNumber($orderNumber)
        {
        	return $this->orderNumberPrefix . $orderNumber;
        }

        public function formatCatalogOrderNumber($orderNumber)
        {
        	return str_replace('845_', '', $orderNumber);
        }

        public function formatDate($orderDate)
        {
        	return date($this->dateFormat, strtotime($orderDate));
        }

        public function formatOrderLines(array $items)
        {
        	$lines = array();

        	foreach ($items as $number => $item) {
        		$lines[] = array(
                'LineNumber'    => $number,
                'Product'       => $item['sku'],
                'Quantity'      => (int) $item['qty_ordered'], // Prowares requires an int value
                'Description'   => $item['name'],
                'Price'         => (float) number_format($item['price'], 2)
        		);
        	}

        	return $lines;
        }

        public function formatAddress(array $address)
        {
        	return array(
            'FirstName'     => $address['firstname'],
            'LastName'      => $address['lastname'],
            'CompanyName'   => $address['company'],
            'Address1'      => $address['street'],
            'City'          => $address['city'],
            'State'         => $address['region'],
            'PostalCode'    => $address['postcode'],
            'Country'       => $address['country_id']
        	);
        }

        public function formatOrderData(array $orderData)
        
        {
        	
        	return array(
            'OrderNumber'       => $this->formatOrderNumber($orderData['increment_id']),
            'OrderDate'         => NULL,
            'Delay'             => $this->orderDelay,
            'EmailConfirmationAddress'  => $orderData['customer_email'],
            // 'PackingListTemplate'       => $this->getPackingListTemplate($orderData),
            'ShippingService'   => $this->_catalogApi->getOrderShippingService($orderData),
            'OrderLines'        => $this->formatOrderLines($orderData['items']), 
            'ShippingAddress'   => $this->formatAddress($orderData['shipping_address']),
            'BillingAddress'    => $this->formatAddress($orderData['billing_address']),
            'CustomerPO'        => $orderData['payment']['po_number']
        	);
        }

        public function sendOrder(array $orderData)
        {
        	try {
        		$result = $this->_api->PLSubmitOrder(array(
                'args' => array(
                    'SystemId' => $this->_auth->user(),
                    'Password' => $this->_auth->pass(),
                    'Orders' => $orderData
        		)
        		));

                $proLogCode = $result->PLSubmitOrderResult->ProLogCode;

        		if ($proLogCode != 'SUCCESS') {
                    if(count($orderData) == 1 && !empty($orderData[0]['OrderNumber'])) {
                        $error = "Error sending order {$orderData[0]['OrderNumber']}.";
                    }
                    else {
                        $error = "Error sending orders.";
                    }

                    $error .= ' ProLogCode: ' . $proLogCode . ' ProLogMessage: ' . $result->PLSubmitOrderResult->ProLogMessage;
                    // if we're only sending one order, add the detailed error message
                    if(count($orderData) == 1 && isset($result->PLSubmitOrderResult->OrderResults->PLOrderResult)) {
                        $errorDetails = $this->parseSendOrderError($result->PLSubmitOrderResult->OrderResults->PLOrderResult);
                        $error .= $errorDetails ? " Details: $errorDetails" : '';
                    }

        			echo "\nSomething went wrong. Prowares said: \n";
        			echo $result->PLSubmitOrderResult->ProLogMessage . "\n";
        			echo "Original Request: \n";
                    // Output request and response. Remove password so it doesn't get logged
        			echo str_replace('<ns1:Password>845!jEnU$</ns1:Password>', '<ns1:Password>...</ns1:Password>',$this->_api->__getLastRequest());
                    echo "Original Response: \n";
                    echo $this->_api->__getLastResponse();
 echo "Response: \n";
 echo $this->_api->__getLastResponse();
                    logError($error);

        			return false;
        		}
        		else {
        			return true;
        		}
        	}
        	catch (Exception $e) {
                logError($e);
        		return false;
        	}
        }


        public function parseSendOrderError($plOrderResult)
        {
            if(is_array($plOrderResult) &&
                count($plOrderResult) == 1 &&
                isset($plOrderResult[0]->Errors) &&
                is_array($plOrderResult[0]->Errors->string) &&
                isset($plOrderResult[0]->Errors->string[0])) {

                return $plOrderResult[0]->Errors->string[0];
            }
            return '';
        }

        /**
         * synchronise the quanity of product in Magento with ProWares
         * @author Luu Thanh Thuy luuthuy205@gmail.com
         */

        public  function getInventory() {
        	$out = array();
        	$result = $this->_api->PLGetInventory(
        	array(
                'args' => array(
                    'SystemId' => $this->_auth->user(),
                    'Password' => $this->_auth->pass(),
                    'AllProducts' => true
        	)
        	)
        	);
        	 
        	if ($result->PLGetInventoryResult->ProLogCode != "SUCCESS") {
        		echo "There is an error <br>";
        		echo $result->PLGetInventoryResult->ProLogCode;
        		exit();
        	} else {    //synchronise the product quantity
        		
        		///$product_inventory = $result->PLGetInventoryResult->PLWarehouseInventory;
        		$product_inventory = $result->PLGetInventoryResult->Inventory->PLInventory;

        		foreach ($product_inventory as $p_i) {
        			$product_sku = $p_i->Product;
        			$qty = $p_i->QuantityAvailable;
        			$out[] = array('sku'=>$product_sku, "qty"=>$qty);
        		}

        	}
        	return $out;
        }

        /**
         * Returns a Magento-normalized order status
         *
         * Notes:
         *  - Magento doesn't have the granularity that PW does
         *      Prowares: Shipments > Packages > Items
         *      Magento:  Shipments > Items
         *  - Magento places trackingNumber[n] on the shipment
         *  - Prowares places trackingNumber on the package
         *
         * The resulting order should look like the following. This translates
         * exactly to what the Magento API is expecting. This method returns an
         * array of these.
         *
         *  array(
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
        public function getOrderStatus(array $orderNumbers)
        
        {
        	 $out = array();
             $in = array();
        	// Order numbers won't be prefixed...
        	foreach ($orderNumbers as $orderNumber) {
        		$orderNumber = $this->orderNumberPrefix . $orderNumber;
        		$in[] = $orderNumber;
        
        	}
        	try {
        		$status = $this->_api->PLGetOrderStatus(array(
                'args' => array(
                    'SystemId' => $this->_auth->user(),
                    'Password' => $this->_auth->pass(),
                    'OrderNumbers' => $in
        		)
        		));
        		
        	}
        	catch (Exception $e) {
        		echo "Something happened on the fulfillment side.\n";
        		echo "They said: " . $e->getMessage() . "\n";
        		return null;
        	}

        	if (!property_exists($status->PLGetOrderStatusResult->Orders, 'PLOrderStatusHeader')) {
        		return array();
        	}

        	$orders = $status->PLGetOrderStatusResult->Orders->PLOrderStatusHeader;

        	foreach ($orders as $order) {
        		
        		$mageOrder = $this->_catalogApi->getOrderInfo($this->formatCatalogOrderNumber($order->OrderNumber));

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
                    'service' => $shipment->ShippingService,
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
                         
                      

        		$out[$this->formatCatalogOrderNumber($order->OrderNumber)] = $orderSummary;
        	}

        	return $out;
        }
       
}

// =============================================================================

class DataObject
{
	protected $data = array();

	public function __construct(array $data)
	{
		foreach ($data as $name => $value) {
			$this->data[$name] = $value;
		}
	}

	public function __call($name, array $params)
	{
		if (empty($this->data[$name])) {
			throw new Exception("Invalid data: $name is not a valid key.");
		}

		if (!empty($params) && !empty($params[0])) {
			$this->data[$name] = $params[0];
		}

		return $this->data[$name];
	}

	public function addValue($name, $value)
	{
		$this->data[$name] = $value;
	}
}

abstract class Eco_Fulfillment_Auth
extends DataObject
{
	protected $_wsdl;
	protected $_user;
	protected $_pass;

	public function __construct()
	{
		if (empty($this->_wsdl) || empty($this->_user) || empty($this->_pass)) {
			throw new Exception('Incomplete auth configuration.');
		}

		parent::__construct(array(
            'wsdl' => $this->_wsdl,
            'user' => $this->_user,
            'pass' => $this->_pass
		));
	}
}

abstract class Eco_Fulfillment_Api
{
	protected $_auth;
	protected $_api;

	public function __construct(Eco_Fulfillment_Auth $auth)
	{
		$this->_auth = $auth;
		$this->_prepareApi();
	}

	abstract protected function _prepareApi();
}
