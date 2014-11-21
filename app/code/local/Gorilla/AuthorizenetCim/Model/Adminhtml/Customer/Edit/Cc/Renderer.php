<?php

class Gorilla_AuthorizenetCim_Model_Adminhtml_Customer_Edit_Cc_Renderer
    implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {   $html = '<td class="label">'.$element->getLabelHtml().'</td>';
        $html .= '<td class="value">';
        $html .= '<input id="' . $element->getId() . '" name="' . $element->getName() . '" value="" class="input-text required-entry validate-cc-number validate-cc-type" type="text" autocomplete="off">';
        $html .= '</td>';

        return $html;
    }
}

