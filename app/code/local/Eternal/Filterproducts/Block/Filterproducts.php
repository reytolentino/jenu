<?php
class Eternal_Filterproducts_Block_Filterproducts extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFilterproducts()     
     { 
        if (!$this->hasData('filterproducts')) {
            $this->setData('filterproducts', Mage::registry('filterproducts'));
        }
        return $this->getData('filterproducts');
        
    }
}