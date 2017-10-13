<?php
/**
 * Activo Extensions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Activo Commercial License
 * that is available through the world-wide-web at this URL:
 * http://extensions.activo.com/license_professional
 *
 * @copyright   Copyright (c) 2014 Activo Extensions (http://extensions.activo.com)
 * @license     Commercial
 * @thanks      Several updates were committed by Aydus/Matthew Valenti
 */

class Activo_Nopobox_Block_Message extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $message = Mage::getStoreConfig('activo_nopobox/global/message');
        if ($message==null || $message=="")
        {
            $message = "PO Box addresses are not allowed. Please use a valid address instead.";
        }

        $messageUseBilling = Mage::getStoreConfig('activo_nopobox/global/messageusebill');
        if ($messageUseBilling==null || $messageUseBilling=="")
        {
            $messageUseBilling = "Shipping cannot be a PO BOX Address, please change your billing or select a different address.";
        }

        $nopobox_regex_values = array(
            'P\.?\s*O\.?\s*Bo?x?'
        );

        $regex_options = array('apo' => 'APO', 'fpo' => 'FPO', 'dpo' => 'DPO');
        foreach($regex_options as $o => $v) {
            $option = Mage::getStoreConfig('activo_nopobox/global/restrict_' . $o);
            if (!empty($option)) {
                $nopobox_regex_values[] = $v;
            }
        }

        $nopobox_regex = implode('|', $nopobox_regex_values);


$html = <<<HTMLEND

<script type="text/javascript">
//<![CDATA[
var noPoBoxRegex = /\b($nopobox_regex)\b/i;

Validation.add('validate-nopobox', "$message", function(v) {
    return !Validation.get('IsEmpty').test(v) && !noPoBoxRegex.test(v);
});

Validation.add('validate-nopobox2', "$message", function(v) {
    return !noPoBoxRegex.test(v);
});

Validation.add('validate-nopobox-sh', "$messageUseBilling", function(v) {
    var billing1 = \$F('billing:street1');
    var billing2 = \$F('billing:street2');
    var billingSelect = 'new address';

    if ($('billing-address-select') != undefined) {
        var billingSelect = $('billing-address-select')[$('billing-address-select').selectedIndex].text;
        if (billingSelect.toLowerCase() != 'new address') {
            billingSelect = billingSelect.split(',')[1];
        }
    }

   var useForShipping = Form.getInputs('co-billing-form','radio','billing[use_for_shipping]').find(function(radio) { return radio.checked; }).value;

   return !(billingSelect.toLowerCase() != 'new address' && useForShipping==1 && noPoBoxRegex.test(billingSelect) || (billingSelect.toLowerCase() == 'new address' && useForShipping==1 && (noPoBoxRegex.test(billing1) || noPoBoxRegex.test(billing2))));
});

Validation.add('validate-nopobox-select', "$messageUseBilling", function(v) {
    var address = $('shipping-address-select')[$('shipping-address-select').selectedIndex].text;
    return !(noPoBoxRegex.test(address));
});

{$this->addAddressRestrictionsJS()}
//]]>
</script>

HTMLEND;

        return $html;
    }

    protected function addAddressRestrictionsJS()
    {
        $jsCode = "";
        if (Mage::getStoreConfig('activo_nopobox/global/restrict_billing') ||
            Mage::getStoreConfig('activo_nopobox/global/restrict_shipping'))
        {
            $jsCode = 'document.observe("dom:loaded", function() { ';
            $jsCode.= $this->addBillingAddressRestrictionsJS();
            $jsCode.= $this->addShippingAddressRestrictionsJS();
            $jsCode.= "\n });";
        }

        return $jsCode;
    }

    protected function addBillingAddressRestrictionsJS()
    {
        $html = "";

        if (Mage::getStoreConfig('activo_nopobox/global/restrict_billing'))
        {
            $html = "\n    if ($('billing:street1') != undefined) { $('billing:street1').addClassName('validate-nopobox'); }";
            if (Mage::getStoreConfig('activo_nopobox/global/address2_allow_empty')) {
                $html.= "\n    if ($('billing:street2') != undefined) { $('billing:street2').addClassName('validate-nopobox2'); }";
            } else {
                $html.= "\n    if ($('billing:street2') != undefined) { $('billing:street2').addClassName('validate-nopobox'); }";
            }
        }

        return $html;
    }

    protected function addShippingAddressRestrictionsJS()
    {
        $html = "";

        if (Mage::getStoreConfig('activo_nopobox/global/restrict_shipping'))
        {
            $html = "\n    if ($('shipping:street1') != undefined) { $('shipping:street1').addClassName('validate-nopobox'); }";
            if (Mage::getStoreConfig('activo_nopobox/global/address2_allow_empty')) {
                $html.= "\n    if ($('shipping:street2') != undefined) { $('shipping:street2').addClassName('validate-nopobox2'); }";
            } else {
                $html.= "\n    if ($('shipping:street2') != undefined) { $('shipping:street2').addClassName('validate-nopobox'); }";
            }

            if (!Mage::getStoreConfig('activo_nopobox/global/restrict_billing'))
            {
                //handle the special case of billing can be POBOX but shipping cannot
                $html.= "\n    if ($('billing:use_for_shipping_yes') != undefined) { $('billing:use_for_shipping_yes').addClassName('validate-nopobox-sh'); }";
            }

            $html .= "\n     if ($('shipping-address-select') != undefined) { $('shipping-address-select').addClassName('validate-nopobox-select'); }";
        }

        return $html;
    }
}
