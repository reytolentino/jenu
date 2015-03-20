<?php
class MD_Reviews_Block_Form extends Mage_Core_Block_Template
{
    
    protected $_productId = null;
    protected $_product = null;
    public function __construct() {
	parent::__construct();
	$this->setTemplate("md/reviews/form.phtml");
    }
    
    public function getProductInfo()
    {
        $product = Mage::getModel('catalog/product');
        return $product->load($this->_productId);
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->_productId = $this->getProductId();
        
        $this->_product = Mage::getModel("catalog/product")->setStoreId(Mage::app()->getStore()->getId())->load($this->_productId);
        Mage::getModel('review/review')
               ->getEntitySummary($this->_product, Mage::app()->getStore()->getId());
        $summary = $this->getLayout()->createBlock("review/helper")->setProduct($this->getProductInfo());
        $this->setChild('review.short.summary', $summary);
        
    }
    
    public function getAction()
    {
        return Mage::getUrl('review/product/post', array('id' => $this->_productId));
    }
    
    public function getRatings()
    {
        $ratingCollection = Mage::getModel('rating/rating')
            ->getResourceCollection()
            ->addEntityFilter('product')
            ->setPositionOrder()
            ->addRatingPerStoreName(Mage::app()->getStore()->getId())
            ->setStoreFilter(Mage::app()->getStore()->getId())
            ->load()
            ->addOptionToItems();
        return $ratingCollection;
    }
    
    public function getRatingSummary()
    {
        return $this->_product->getRatingSummary()->getRatingSummary();
    }

    public function getReviewsCount()
    {
        return $this->_product->getRatingSummary()->getReviewsCount();
    }

    public function getReviewsUrl()
    {
        return Mage::getUrl('review/product/list', array(
           'id'        => $this->_product->getId(),
           'category'  => $this->_product->getCategoryId()
        ));
    }
    
    
}

