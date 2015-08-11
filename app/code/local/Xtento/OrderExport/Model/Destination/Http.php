<?php

/**
 * Product:       Xtento_OrderExport (1.7.9)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2015-05-04T15:05:24+02:00
 * File:          app/code/local/Xtento/OrderExport/Model/Destination/Http.php.sample
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Destination_Http extends Xtento_OrderExport_Model_Destination_Abstract
{
    public function moulton($fileArray)
    {
        // Do whatever - sample code for a webservice request below.
        foreach ($fileArray as $filename => $fileContent) {
// TEST
$curl = curl_init("https://qcmoultonordervision.com/Ws/ORDAPI.asmx/OrderNewAPITrackable");
// Live
#$curl = curl_init("https://www.moultonordervision.com/Ws/ORDAPI.asmx/OrderNewAPITrackable"); 

#curl_setopt($curl, CURLOPT_SSLVERSION,3); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
#curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
#curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1' );
curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
curl_setopt($curl, CURLOPT_HEADER ,0); // DO NOT RETURN HTTP HEADERS 
curl_setopt($curl, CURLOPT_POST, true); 
curl_setopt($curl, CURLOPT_POST, true); 

// TEST
#$data = 'Username=&Password=&groupcode=TEST&ClNo=WB&project=proj1&UniqueId='.basename($filename, '.xml').'&XMLFormatCode=new_order_20130723V015&ORDXML='.urlencode($fileContent);

// TST
$data = 'Username=JENU_JENU&Password=aeRK3892xCCs84&groupcode=TEST&ClNo=DR&project=PROJ1&UniqueId='.basename($filename, '.xml').'&XMLFormatCode=new_order_20130723V015&ORDXML='.urlencode($fileContent);

curl_setopt($curl, CURLOPT_POSTFIELDS ,$data); 

curl_setopt($curl, CURLOPT_RETURNTRANSFER ,1); // RETURN THE CONTENTS OF THE CALL 
$str = curl_exec($curl); 
if (curl_error($curl)) {
  $str .= " - " . curl_error($curl);
}
curl_close($curl);
$logstr = new SimpleXMLElement($str);
$errornode = $logstr->ErrorMsg;
if($errornode !== 'Success'){
    $to = 'rey@jenu.com';
    $headers = 'From: info@jenu.com' . "\r\n";
    $subject = "Moulton Error Report";

    $message = "Date: " . date('Y-m-d G:i:s, e') . PHP_EOL . PHP_EOL .
        "Moulton API encountered the following errors: " . PHP_EOL . PHP_EOL .
        implode(PHP_EOL . PHP_EOL, $logstr);

    mail($to, $subject, $message, $headers);
}

$logEntry = Mage::registry('export_log');
$logEntry->addResultMessage(Mage::helper('xtento_orderexport')->__('Destination "%s" (ID: %s): %s', $this->getDestination()->getName(), $this->getDestination()->getId(), 'Moulton API returned: '.$str));
        }
    }


    public function moultonlive($fileArray)
    {
        // Do whatever - sample code for a webservice request below.
        foreach ($fileArray as $filename => $fileContent) {
// TEST
#$curl = curl_init("https://qcmoultonordervision.com/Ws/ORDAPI.asmx/OrderNewAPITrackable");
// Live
$curl = curl_init("https://www.moultonordervision.com/Ws/ORDAPI.asmx/OrderNewAPITrackable"); 

#curl_setopt($curl, CURLOPT_SSLVERSION,3); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
#curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
#curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1' );
curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
curl_setopt($curl, CURLOPT_HEADER ,0); // DO NOT RETURN HTTP HEADERS 
curl_setopt($curl, CURLOPT_POST, true); 
curl_setopt($curl, CURLOPT_POST, true); 

// TEST
#$data = 'Username=&Password=&groupcode=TEST&ClNo=WB&project=proj1&UniqueId='.basename($filename, '.xml').'&XMLFormatCode=new_order_20130723V015&ORDXML='.urlencode($fileContent);

// LIVE
$data = 'Username=JENU_JENU&Password=aeRK3892xCCs84&groupcode=JENU&ClNo=JU&project=PROJ1&UniqueId='.basename($filename, '.xml').'&XMLFormatCode=new_order_20130723V015&ORDXML='.urlencode($fileContent);

curl_setopt($curl, CURLOPT_POSTFIELDS ,$data); 

curl_setopt($curl, CURLOPT_RETURNTRANSFER ,1); // RETURN THE CONTENTS OF THE CALL 
$str = curl_exec($curl); 
if (curl_error($curl)) {
  $str .= " - " . curl_error($curl);
}
curl_close($curl);

$logstr = new SimpleXMLElement($str);
$errornode = $logstr->ErrorMsg;
if($errornode !== 'Success'){
    $to = 'rey@jenu.com';
    $headers = 'From: info@jenu.com' . "\r\n";
    $subject = "Moulton Error Report";

    $message = "Date: " . date('Y-m-d G:i:s, e') . PHP_EOL . PHP_EOL .
        "Moulton API encountered the following errors: " . PHP_EOL . PHP_EOL .
        implode(PHP_EOL . PHP_EOL, $logstr);

    mail($to, $subject, $message, $headers);
}

$logEntry = Mage::registry('export_log');
$logEntry->addResultMessage(Mage::helper('xtento_orderexport')->__('Destination "%s" (ID: %s): %s', $this->getDestination()->getName(), $this->getDestination()->getId(), 'Moulton API returned: '.$str));
        }
    }


    /*
     * !!!!! IMPORTANT !!!!!
     *
     * Modify below this line. Add custom functions, similar to the function below. There MUST be one parameter which will contain the files which have been generated by the module in the format array($filename => $fileContent)
     */
    public function yourFunctionName($fileArray)
    {
        // Do whatever - sample code for a HTTP request below.
        foreach ($fileArray as $filename => $fileContent) {
            $curlClient = curl_init();
            curl_setopt($curlClient, CURLOPT_URL, '');
            curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlClient, CURLOPT_POST, 1);
            curl_setopt($curlClient, CURLOPT_POSTFIELDS, $fileContent);
            //curl_setopt($curlClient, CURLOPT_POSTFIELDS, array('SampleParameter' => $fileContent)); // Send as a parameter instead
            /*curl_setopt($curlClient, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic ' . base64_encode("user:password"), // HTTP Basic Authorization
                'Accept: text/html', // Sample header Accept
            ));*/
            curl_setopt($curlClient, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlClient, CURLOPT_SSL_VERIFYHOST, 0);
            $result = curl_exec($curlClient);
            curl_close($curlClient);

            // Log result
            $logEntry = Mage::registry('export_log');
            #$logEntry->setResult(Xtento_OrderExport_Model_Log::RESULT_WARNING);
            $logEntry->addResultMessage(Mage::helper('xtento_orderexport')->__('Destination "%s" (ID: %s): %s', $this->getDestination()->getName(), $this->getDestination()->getId(), htmlentities($result)));
        }
    }

    /*
     * !!!!! Do not modify below this line !!!!!
     */
    public function testConnection()
    {
        $this->initConnection();
        if (!$this->getDestination()->getBackupDestination()) {
            $this->getDestination()->setLastResult($this->getTestResult()->getSuccess())->setLastResultMessage($this->getTestResult()->getMessage())->save();
        }
        return $this->getTestResult();
    }

    public function initConnection()
    {
        $this->setDestination(Mage::getModel('xtento_orderexport/destination')->load($this->getDestination()->getId()));
        $testResult = new Varien_Object();
        $this->setTestResult($testResult);
        if (!@method_exists($this, $this->getDestination()->getCustomFunction())) {
            $this->getTestResult()->setSuccess(false)->setMessage(Mage::helper('xtento_orderexport')->__('Custom function/method \'%s\' not found in %s.', $this->getDestination()->getCustomFunction(), __FILE__));
        } else {
            $this->getTestResult()->setSuccess(true)->setMessage(Mage::helper('xtento_orderexport')->__('Custom function/method found and ready to use.', __FILE__));
        }
        return true;
    }

    public function saveFiles($fileArray)
    {
        if (empty($fileArray)) {
            return array();
        }
        // Init connection
        $this->initConnection();
        // Call custom function
        @$this->{$this->getDestination()->getCustomFunction()}($fileArray);
        return array_keys($fileArray);
    }
}