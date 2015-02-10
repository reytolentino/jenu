<?php
/**
* Magedelight
* Copyright (C) 2014 Magedelight <info@magedelight.com>
*
* NOTICE OF LICENSE
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
*
* @category MD
* @package MD_Partialpayment
* @copyright Copyright (c) 2014 Mage Delight (http://www.magedelight.com/)
* @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
* @author Magedelight <info@magedelight.com>
*/
class MD_Partialpayment_Block_Adminhtml_System_Config_Export extends Mage_Adminhtml_Block_System_Config_Form_Field  
implements Varien_Data_Form_Element_Renderer_Interface{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $buttonBlock = Mage::app()->getLayout()->createBlock('adminhtml/widget_button');
        $params = array(
            'website' => $buttonBlock->getRequest()->getParam('website')
        );
        $data = array(
            'label'     => Mage::helper('adminhtml')->__('Export'),
            'onclick'   => 'setLocation(\''.Mage::helper('adminhtml')->getUrl("md_partialpayment/adminhtml_index/export", $params) . '\' )',
            'class'     => '',
        );

        $html = $buttonBlock->setData($data)->toHtml();
        return $html;
    }
}

