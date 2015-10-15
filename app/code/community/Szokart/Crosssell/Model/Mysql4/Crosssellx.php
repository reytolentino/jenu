<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Model_Mysql4_Crosssellx extends Mage_Core_Model_Mysql4_Abstract
{ 

    public function _construct() 
    {    
        $this->_init('crosssell/crosssellx', 'csx_id'); 
    }

		 public function toOptionArray()
    {
        $options = array(); 
        foreach ($this as $item) {
            $options[] = array(
			   'value' => $item->getCsId(),
               'label' => $item->getName()
            );
        }
        return $options;
    }

}