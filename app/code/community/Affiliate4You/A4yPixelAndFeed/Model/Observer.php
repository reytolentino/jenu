<?php
class Affiliate4You_A4yPixelAndFeed_Model_Observer
{
	public function captureReferral(Varien_Event_Observer $observer)
	{
		if (!empty($_GET["a4ytrid"]) && !empty($_GET["a4yadvid"]))
		{
			// If you do not use the built-in session functionality in PHP, modify below
			session_start();
			// set domain from the SERVER vars
			$a4yCookieDomain = str_replace("www.", "", (!empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']));

			// set cookie for default 100 days. Actual time will be set when checking order
			setcookie("A4Ytrid[".$_GET["a4yadvid"]."]", $_GET["a4ytrid"],(time() + 100*24*60*60), "/", '.'.$a4yCookieDomain);
			// If you do not use the built-in session functionality in PHP, modify
			// the following expression to work with your session handling routines.
			$_SESSION["A4Ytrid"] = $_GET["a4ytrid"];
		}
	}
}