<?php 

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);


function cprintf()
{
    $args = func_get_args();
    echo call_user_func_array('sprintf', $args) . PHP_EOL;
}

/**
 * Log error message
 * @param $error
 */
function logError($error)
{
    static $file;

    if(!$file) {

        $file = !empty($matches[1]) ? 'fulfillment_' . $matches[1] . '_errors.log' : 'fulfillment_errors.log';
    }

    if($error instanceof Exception) {
        $error = $error->__toString();
    }
    if(class_exists('Mage')) {
        Mage::log("\n" . $error, Zend_Log::ERR, $file, true);
    }
    errorReport($error); // Remember error for error report
}

/**
 * Add error to list of errors encountered during life of script. Return $errors
 * @param $error
 * @return array
 */
function errorReport($error = null)
{
    static $errors = array();

    if($error) {
        $errors[] = $error;
    }
    else {
        return $errors;
    }
}

function sendErrorReport()
{
    $errors = errorReport();
    if(count($errors) == 0) {
        return;
    }

    $action = getScriptAction();
    $to = 'rey@jenu.com';
    $headers = 'From: info@jenu.com' . "\r\n";
    $subject = "MyJenu.com Prolog Prowares Fulfillment " . strtoupper($action) . " Error Report";

    $message = "Date: " . date('Y-m-d G:i:s, e') . PHP_EOL . PHP_EOL .
        "The JeNu Prolog Prowares Fulfillment $action process encountered the following errors: " . PHP_EOL . PHP_EOL .
        implode(PHP_EOL . PHP_EOL, $errors);

    mail($to, $subject, $message, $headers);
}

/**
 * Get script name less extension, for example, "send"
 * @return string
 */
function getScriptAction()
{
    preg_match('/\/([a-z]+)\.php$/', $_SERVER['SCRIPT_FILENAME'], $matches);
    return !empty($matches[1]) ? $matches[1] : '';
}