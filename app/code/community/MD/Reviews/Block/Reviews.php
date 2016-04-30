<?php
class MD_Reviews_Block_Reviews extends Mage_Core_Block_Template {

    protected $_productId = null;
    protected $_product = null;
    public function __construct() {
	parent::__construct();
	$this->setTemplate("md/reviews/list.phtml");
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $productId = $this->getProductId();
        if(!is_null($this->getProductId())){
            $this->_productId = $this->getProductId();
        }
        $reviewesCollection = Mage::getModel('review/review')->getCollection()
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
                ->addEntityFilter('product', $productId)
                ->setDateOrder();
        $this->setReviewsCollection($reviewesCollection);
            $toolbar = $this->getLayout()->createBlock("page/html_pager");
            $toolbar->setCollection($reviewesCollection);
	    $reviewesCollection->addRateVotes();
            $this->setChild('toolbar', $toolbar);
        return $this;
    }
}
