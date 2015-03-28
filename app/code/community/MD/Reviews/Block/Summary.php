<?php

class MD_Reviews_Block_Summary extends Mage_Core_Block_Template {

    protected $_productId = null;
    protected $_product = null;

    public function __construct() {
	parent::__construct();
	$this->setTemplate("md/reviews/summary.phtml");
    }

    protected function _prepareLayout() {
	parent::_prepareLayout();
	$this->_productId = $this->getProductId();

	$this->_product = Mage::getModel("catalog/product")->setStoreId(Mage::app()->getStore()->getId())->load($this->_productId);
    }

}
