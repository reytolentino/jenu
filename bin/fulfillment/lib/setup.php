<?php 

require_once(__DIR__.'/../../../app/Mage.php');
Mage::app();

date_default_timezone_set('America/Chicago');

$baseUrl = Mage::getBaseUrl('web');
$wsdl = $baseUrl . 'index.php/api/soap?wsdl';
$catalogAuth = new Eco_Fulfillment_Auth_Catalog($wsdl);
$catalog = new Eco_Fulfillment_Api_Catalog($catalogAuth);

if($baseUrl == 'https://www.jenu.com/') {
    $fulfillmentAuth = new Eco_Fulfillment_Auth_Prowares_Prod;
    echo "Using Production credentials\n";
}
else {
    $fulfillmentAuth = new Eco_Fulfillment_Auth_Prowares_Devel;
    echo "Using Sandbox credentials\n";
}
$fulfillment = new Eco_Fulfillment_Api_Prowares($fulfillmentAuth, $catalog);
