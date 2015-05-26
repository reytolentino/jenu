<?php
/*
	Author: 	Lennart Kramer
    Company: 	Affiliate4You
    Version: 	0.1.1
    Date: 		14 August 2013
*/
class Affiliate4You_A4yPixelAndFeed_IndexController extends Mage_Core_Controller_Front_Action {
	private $_Products;
	private $_ProductIds;
	private $_Config;
	private $_ConfigPaths = array 
	(	
		'a4yfeed/general/enabled',
		'a4yfeed/general/urlparam',
		'a4yfeed/general/imgsmall_width',
		'a4yfeed/general/imgsmall_height',
		'a4yfeed/general/imgmedium_width',
		'a4yfeed/general/imgmedium_height',
		'a4yfeed/general/shippingtime',
		'a4yfeed/general/shippingcost'
	);

	public function indexAction() 
	{
		set_time_limit(3600);		
		$this->_setConfig();
		if($this->_Config->general->enabled == 1)
		{
			$Feed = new Affiliate4You_A4yPixelAndFeed_Helper_XmlFeed($this->_Config);
			$this->_buildProductsArray();
			$_Products = array();
			foreach($this->_ProductIds as $iProduct)
			{
				array_push($_Products,$this->_getProductData($iProduct));
			}
			$xmlFeed = $Feed->build_xml($_Products);
			$this->_sendHeader();
			echo $xmlFeed;
		}
	}
	
	private function _setConfig()
	{
		$this->_Config = new StdClass();
		foreach($this->_ConfigPaths as $Path)
		{
			$Parts = explode('/',$Path);
			@$this->_Config->$Parts[1]->$Parts[2] = Mage::getStoreConfig($Path);
		}
		
		if(!is_numeric($this->_Config->general->imgsmall_width))
		{
			$this->_Config->general->imgsmall_width = 150;
		}

		if(!is_numeric($this->_Config->general->imgsmall_height))
		{
			$this->_Config->general->imgsmall_height = 150;
		}

		if(!is_numeric($this->_Config->general->imgmedium_width))
		{
			$this->_Config->general->imgmedium_width = 320;
		}

		if(!is_numeric($this->_Config->general->imgmedium_height))
		{
			$this->_Config->general->imgmedium_height = 320;
		}		
	}
	
	private function _buildProductsArray()
	{
		$this->_Products = Mage::getModel('catalog/product')->getCollection();
		$this->_Products->addAttributeToFilter('status', 1);//enabled
		$this->_Products->addAttributeToFilter('visibility', 4);//catalog, search
		$this->_Products->addAttributeToSelect('*');
		$this->_ProductIds = $this->_Products->getAllIds();
	}

	private function _getProductData($ProductInput)
	{
		$Product = Mage::getModel('catalog/product')->load($ProductInput);
		$Cats = $this->_getCategories($Product);
	    $Data = array();
	    $Data['id']=$ProductInput;
	    $Data['title']=$Product->getName();
	    $Data['description']=strip_tags($Product->getDescription());
	    $Data['price']=$Product->getPrice();
	    $Data['special_price']=$Product->getSpecialPrice();
		$Data['link']=$Product->getProductUrl();
		$Data['image_link_large']= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$Product->getImage();
		$Data['image_link_small']= (string) Mage::helper('catalog/image')->init(  $Product, 'image')->resize($this->_Config->general->imgsmall_width,$this->_Config->general->imgsmall_height);
		$Data['image_link_medium']= (string) Mage::helper('catalog/image')->init($Product, 'image')->resize($this->_Config->general->imgmedium_width,$this->_Config->general->imgmedium_width);
		$Data['category'] = $Cats['main'];
		$Data['subcategory'] = $Cats['sub'];
		$Data['brand']=$Product->getResource()->getAttribute('manufacturer')->getFrontend()->getValue($Product);
		$Data['availability']='yes';
		$Data['shippingcost'] = $this->_Config->general->shippingcost;
		$Data['shippingtime'] = $this->_Config->general->shippingtime;

		$attributes = $Product->getAttributes();

		foreach ($attributes as $attribute) 
		{
			if ($attribute->getIsVisibleOnFront()) 
			{
				$Data[$attribute->getAttributeCode()] = $attribute->getFrontend()->getValue($Product);
				// do something with $value here
			}
		}

	    if($Data['special_price'] == '')
		{
	    	$Data['special_price'] = $Data['price'];
	    }

	    return $Data;
	}

	private function _getCategories($Product)
	{
		$Ids = $Product->getCategoryIds();

		$Categories = array();
		
		foreach($Ids as $Category)
		{
			$CategoryModel = Mage::getModel('catalog/category')->load($Category);
			if ($CategoryModel->getLevel() != '3' && $CategoryModel->getLevel() != '4')
			{
				continue;
			}
			$Categories['main'] = $CategoryModel->getParentCategory()->getName();
			$Categories['sub'] = $CategoryModel->getName();
	    }

	    return $Categories;
	}

	private function _sendHeader() 
	{
		header('Content-type: text/xml');
	}

	private function _debug($m) 
	{
		echo '<pre>';
		print_r($m);
		echo '</pre>';
	}
}
