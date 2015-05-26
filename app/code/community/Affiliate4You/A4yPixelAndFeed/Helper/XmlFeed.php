<?php
/*
	Author: 	Lennart Kramer
    Company: 	Affiliate4You
    Version: 	0.1.1
    Date: 		14 August 2013
*/

class Affiliate4You_A4yPixelAndFeed_Helper_XmlFeed
{
	private $_config;

	function __construct($config)
	{
		$this->_config = $config;
	}

	public function build_xml(array $products)
	{
		$xml_feed = new Affiliate4You_A4yPixelAndFeed_Helper_SimpleXml('<?xml version="1.0" encoding="UTF-8"?><products></products>');
		foreach ($products as $product)
		{
			$xml_product = $xml_feed->addChild('product');
			$xml_product = $this->_add_product_fields($xml_product, $product);
		}
		return $xml_feed->as_formated_xml();
	}

	private function _add_product_fields($xml_product, $product_fields)
	{
		foreach($product_fields as $field_name => $field_value)
		{
			$field_value = $this->_clean_string($field_value);
			if ($field_name == 'link')
			{
				$field_value = $this->_add_url_params($field_value);
			}
			$product = $xml_product->addChild($field_name, NULL);
			$product->add_cdata($field_value);
		}

		return $xml_product;
	}

	private function _add_url_params($url)
	{
		if( ! strstr($url, '?'))
		{
			$url .= '?'.str_replace('?','', $this->_config->general->urlparam);
		}
		else
		{
			$url .= '&'.str_replace('?','', $this->_config->general->urlparam);
		}
		return $url;
	}

	private function _clean_string($string)
	{
		$string = strip_tags($string);
		$string = str_replace(array('"',"\r\n","\n","\r","\t"), array(""," "," "," ",""), $string);
		return $string;
	}
}
?>