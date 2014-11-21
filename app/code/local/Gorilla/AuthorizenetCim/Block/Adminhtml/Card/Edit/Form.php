<?php

class Gorilla_AuthorizenetCim_Block_Adminhtml_Card_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $card = Mage::registry('card_form_data');

        $form = new Varien_Data_Form(array(
            'id' =>'edit_form',
            'action'=> $this->getUrl('*/*/save',
                array(
                    'id' => $this->getRequest()->getParam('id')
                )),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $fieldset = $form->addFieldset('card_form', array('legend' => $this->__('Authorize.net CIM Card')));

        $fieldset->addField('id', 'hidden', array('name' => 'id'));


        $fieldset->addField('cc_first_name', 'text', array(
            'name' => 'cc_first_name',
            'label' => 'First Name',
            'required' => true
        ));

        $fieldset->addField('cc_last_name', 'text', array(
            'name' => 'cc_last_name',
            'label' => 'Last Name',
            'required' => true
        ));

        $fieldset->addField('cc_company', 'text', array(
            'name' => 'cc_company',
            'label' => 'Company',
            'required' => false
        ));

        $fieldset->addField('cc_billing_address', 'text', array(
            'name' => 'cc_billing_address',
            'label' => 'Billing Address',
            'required' => true
        ));

        $fieldset->addField('country_id', 'select', array(
            'name'  => 'country_id',
            'label'     => 'Country',
            'values'    => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
            'required' => true,
            'class' => 'countries'
        ))
            ;

        $fieldset->addField('region_id', 'select', array(
            'name'  => 'region_id',
            'label'     => 'State',
            'required' => true,
        ))
            ->setRenderer(Mage::getModel('authorizenetcim/adminhtml_customer_edit_region_renderer'))
        ;

        $fieldset->addField('cc_billing_city', 'text', array(
            'name' => 'cc_billing_city',
            'label' => 'City',
            'required' => true
        ));

        $fieldset->addField('cc_billing_zip', 'text', array(
            'name' => 'cc_billing_zip',
            'label' => 'Zip Code',
            'required' => true
        ));

        $fieldset->addField('cc_billing_phone', 'text', array(
            'name' => 'cc_billing_phone',
            'label' => 'Phone Number',
            'class' => 'validate-phoneStrict',
            'required' => true
        ));

        $fieldset->addField('cc_billing_fax', 'text', array(
            'name' => 'cc_billing_fax',
            'label' => 'Fax Number',
            'required' => false
        ));

        if ($this->getRequest()->getParam('id')) {
            $fieldset->addField('cc_number_to_show', 'note', array(
                'name' => 'cc_number_to_show',
                'label' => 'Card Number',
                'text' => $card->getCcNumber()
            ));

            $fieldset->addField('cc_number', 'hidden', array(
                'name' => 'cc_number',
            ));
        } else {

            $types = Mage::getSingleton('payment/config')->getCcTypes();
            $availableTypes = explode(',',Mage::getModel('authorizenetcim/gateway')->getConfigData('cctypes'));
            if ($availableTypes) {
                foreach ($types as $code=>$name) {
                    if (!in_array($code, $availableTypes)) {
                        unset($types[$code]);
                    }
                }
            }

            $fieldset->addField('cc_type', 'select', array(
                'name' => 'cc_type',
                'label' => 'Card Type',
                'required' => true,
                'values' => array('' => $this->__('-- Please Select --')) + $types
            ));

            $fieldset->addField('cc_number', 'text', array(
                'name' => 'cc_number',
                'label' => 'Card Number',
                'required' => true
            ))
                ->setRenderer(Mage::getModel('authorizenetcim/adminhtml_customer_edit_cc_renderer'))
            ;
        }

        if ($this->getRequest()->getParam('id')) {
            $_months['XX'] = $this->__('XX');
        } else {
            $_months[''] = $this->__('-- Please Select --');
        }

        $_months += Mage::app()->getLocale()->getTranslationList('month');
        $fieldset->addField('cc_exp_month', 'select', array(
            'name' => 'cc_exp_month',
            'label' => 'Expiration Month',
            'required' => true,
            'values' => $_months,
            'class' => 'validate-expiration-date',
            'after_element_html' => "
                <script type=\"text/javascript\">
                    Validation.add('validate-expiration-date','Incorrect credit card expiration date.',function(v, elm){
                        var ccExpMonth   = v;
                        var ccExpYear    = $('cc_exp_year').value;
                        var currentTime  = new Date();
                        var currentMonth = currentTime.getMonth() + 1;
                        var currentYear  = currentTime.getFullYear();
                        if (ccExpMonth < currentMonth && ccExpYear == currentYear && !(ccExpMonth == 'XX' && ccExpYear == 'XX')) {
                            return false;
                        }
                        return true;
                    });
                </script>"
        ));

        if ($this->getRequest()->getParam('id')) {
            $_years['XX'] = $this->__('XX');
        } else {
            $_years[''] = $this->__('-- Please Select --');
        }

        $_years += Mage::getSingleton('payment/config')->getYears();
        $fieldset->addField('cc_exp_year', 'select', array(
            'name' => 'cc_exp_year',
            'label' => 'Expiration Year',
            'required' => true,
            'values' => $_years,
        ));

        $fieldset->addField('cc_cvn', 'text', array(
            'name' => 'cc_cvn',
            'label' => 'Card Verification Number',
            'required' => true,
            'class' => 'validate-cvn',
            'after_element_html' => "
                <script type=\"text/javascript\">
                    Validation.add('validate-cvn','Please enter a valid credit card verification number.',function(v, elm){
                        var ccTypeContainer = $('cc_type');
                        if (!ccTypeContainer) {
                            return true;
                        }
                        var ccType = ccTypeContainer.value;

                        if (typeof Validation.creditCartTypes.get(ccType) == 'undefined') {
                            return false;
                        }

                        var re = Validation.creditCartTypes.get(ccType)[1];

                        if (v.match(re)) {
                            return true;
                        }

                        return false;
                    });
                </script>
            "
        ));

        $card->setCcIsDefault(false);
        $_customer = Mage::getModel('customer/customer')->load($card->getCustomerId());
        if ($_customer->getId()) {
            $card->setCcIsDefault($_customer->getCimDefaultToken() == $card->getId()? '1' : '0');
        }

        $fieldset->addField('cc_is_default', 'select', array(
            'name' => 'cc_is_default',
            'label' => 'Make This Card Default',
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('customer_id', 'hidden', array(
            'name' => 'customer_id',
            'value' => $card->getCustomerId()
        ));

        $fieldset->addField('cim_gateway_id', 'hidden', array(
            'name' => 'cim_gateway_id',
            'value' => $card->getCimGatewayId()
        ));

        $form->setValues($card->getData());

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
