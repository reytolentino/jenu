<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/

class Szokart_Crosssell_Model_Crosssellx extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('crosssell/crosssellx');
    }

	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function toOptionArray() 
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('crosssell/crosssellx_collection')->loadData()->toOptionArray(); 
        }

		$options = $this->_options;
        return $options;
    }






}