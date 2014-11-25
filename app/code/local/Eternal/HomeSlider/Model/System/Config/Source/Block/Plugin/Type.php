<?php

class Eternal_HomeSlider_Model_System_Config_Source_Block_Plugin_Type
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'revolution',    'label' => Mage::helper('eternal_homeslider')->__('Revolution Slider')),
            array('value' => 'ios',    'label' => Mage::helper('eternal_homeslider')->__('IOS Slider'))
        );
    }
}
