<?php

class Gorilla_AuthorizenetCim_Block_System_Config_Form_Gorilla_Info extends Mage_Adminhtml_Block_System_Config_Form_Field

{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $version = '0.5.3';

        $mage_version = 'enterprise';

        if (Mage::helper('authorizenetcim')->canUseMethod()) {
            $can_use_msg = "Module is enable";
        } else {
            $can_use_msg = "Module is disabled.<br/><br/>This version of the module is for the enterprise edition only before ver. 1.12.0.0 .";
        }

        $defaultFormJs = '';

        $html = <<<FEED
            <div style='margin-top:30px; width:430px;'>
                <i>Authorize.net Customer Information Manager (CIM) ver. {$version} ({$mage_version}).</i><br/>
                <br/>
                <b>{$can_use_msg}</b>
            </div>

<script type="text/javascript">//<![CDATA[
        {$defaultFormJs}
        //]]></script>
FEED;

        return $html;
    }

}