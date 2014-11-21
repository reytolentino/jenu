<?php

class Gorilla_AuthorizenetCim_Adminhtml_CardController extends Mage_Adminhtml_Controller_Action
{

    public function editAction()
    {
        $_session = Mage::getSingleton('core/session');
        $_session->setEscapeMessages(true); // prevent XSS injection in user input

        $_cardId = (int)$this->getRequest()->getParam('id');
        $_customerId = (int)$this->getRequest()->getParam('customer_id');

        $_customer = Mage::getModel('customer/customer')->load($_customerId);

        if (!$_cimGatewayId = $_customer->getCimGatewayId()) {
            $_session->addError($this->__('There is so Cim Gateway Id associated with this customer.'));
            $this->_redirectError(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $_customerId . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            return false;
        }

        $_paymentProfile = Mage::getModel('authorizenetcim/profile')
            ->getCustomerPaymentProfile($_cimGatewayId, $_cardId);

        if (!$_paymentProfile) {
            $_session->addError($this->__('Payment profile was not found.'));
            $this->_redirectError(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $_customerId . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            return false;
        }

        $_form_data = $this->_prepareGatewayDataForForm($_paymentProfile);

        $_form_data
            ->setId($_cardId)
            ->setCustomerId($_customerId)
            ->setCimGatewayId($_cimGatewayId)
        ;

        Mage::register('card_form_data', $_form_data);

        $this->loadLayout()->_addContent(
        $this->getLayout()->createBlock('authorizenetcim/adminhtml_card_edit'));

        $this->_title($this->__('Authorize.net CIM'))->_title($this->__('Card #') . $_form_data->getCcNumber());

        $this->renderLayout();
    }

    public function addAction()
    {
        $_session = Mage::getSingleton('core/session');
        $_session->setEscapeMessages(true); // prevent XSS injection in user input

        $_customerId = (int)$this->getRequest()->getParam('customer_id');

        $_customer = Mage::getModel('customer/customer')->load($_customerId);

        $_form_data = new Varien_Object();

        if ($_cimGatewayId = $_customer->getCimGatewayId()) {
           $_form_data->setCimGatewayId($_cimGatewayId);
        }

        $_form_data
            ->setId(null)
            ->setCustomerId($_customerId)
        ;

        if (is_array($_session->getCustomerCardFormData())) {
            $_form_data->setData($_session->getCustomerCardFormData());
            $_form_data->unsetData('form_key');
            $_form_data->unsetData('cc_number');
            $_form_data->unsetData('cc_cvn');

            $_session->setCustomerCardFormData(null);
        }

        Mage::register('card_form_data', $_form_data);

        $this->loadLayout()->_addContent(
            $this->getLayout()->createBlock('authorizenetcim/adminhtml_card_edit'));

        $this->_title($this->__('Authorize.net CIM'))->_title($this->__('New Card'));

        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this
                ->getLayout()
                ->createBlock('authorizenetcim/adminhtml_card_grid')
                ->toHtml()
        .
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                    'label'     => 'Add New Card',
                    'onclick'   => 'setLocation(\'' . Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/add/customer_id/' . $this->getRequest()->getParam('id') , array('_secure' => true)) . '\');',
                    'class'     => 'cim-add-card add',
                    'type'      => 'button',
                    'id'        => 'cim-add-card',
                ))
                    ->toHtml()
        );
    }

    public function saveAction()
    {
        $_session = Mage::getSingleton('core/session');
        $_session->setEscapeMessages(true); // prevent XSS injection in user input

        $_cimProfileModel = Mage::getModel('authorizenetcim/profile');
        $_cardCustomer = $this->_prepareCustomerForGateway($this->getRequest()->getParams());

        // If this is a new profile entirely, create the customer and card at
        // the same time.
        if (!$_cardCustomer->getGatewayId()) {
            // create the customer profile and payment profile
            $_cimProfile = $_cimProfileModel->createCustomerProfile($_cardCustomer, true);

            // If we didn't get a profile ID, then set the error and redirect the customer
            if (!$_cimProfile) {
                foreach ($_cimProfileModel->getErrorMessages() as $_errorMessage)
                {
                    $_session->addError($_errorMessage);
                }

                $_session->setCustomerCardFormData($this->getRequest()->getPost());
                $this->_redirectError(Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/add/customer_id/' . $_cardCustomer->getId() , array('_secure' => true)));
                return;
            } else {
                $_cardCustomer->setGatewayId($_cimProfile->getCustomerProfileId());

                // save profile id on customer record
                Mage::getModel('authorizenetcim/profile')->setCustomerId($_cardCustomer->getId())->setGatewayId($_cimProfile->getCustomerProfileId())
                    ->setDefaultPaymentId($_cimProfile->getCustomerPaymentProfileId())
                    ->saveWithMode();

                $_session->addSuccess($this->__('Card has been successfully saved.'));
                $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $_cardCustomer->getId() . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
                return;
            }

        }

        // If this is just a card add/update do the following
        if ($_cardCustomer->getPaymentProfile()->getGatewayId()) {
            $_result = $_cimProfileModel->updateCustomerPaymentProfile($_cardCustomer);
            if ($_result) {
                if ($this->getRequest()->getParam('cc_is_default')) {
                    $_customerObject = Mage::getSingleton('customer/customer')->load($this->getRequest()->getParam('customer_id'));

                    if ($_cimProfileId = $_customerObject->getCimProfileId()) {
                        Mage::getModel('authorizenetcim/profile')->load($_cimProfileId)
                            ->setDefaultPaymentId($this->getRequest()->getParam('id'))
                            ->saveWithMode();
                    }
                }

                $_session->addSuccess($this->__('Card has been successfully saved.'));
                $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $_cardCustomer->getId() . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            } else {
                foreach ($_cimProfileModel->getErrorMessages() as $_errorMessage) {
                    $_session->addError($_errorMessage);
                }
                $this->_redirectError(Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/edit/id/' . $this->getRequest()->getParam('id') . '/customer_id/' . $_cardCustomer->getId() , array('_secure' => true)));
                return;
            }


        } else { // Add new CC to CIM
            $_paymentProfileId = $_cimProfileModel->createCustomerPaymentProfile($_cardCustomer);
            if (!$_paymentProfileId) {
                foreach ($_cimProfileModel->getErrorMessages() as $error_message)
                {
                    $_session->addError($error_message);
                }
                $_session->setCustomerCardFormData($this->getRequest()->getPost());
                $this->_redirectError(Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/add/customer_id/' . $_cardCustomer->getId() , array('_secure' => true)));
                return;
            } else {
                $_session->addSuccess($this->__('Card has been successfully saved.'));

                if ($this->getRequest()->getParam('cc_is_default')) {
                    $_customerObject = Mage::getSingleton('customer/customer')->load($this->getRequest()->getParam('customer_id'));

                    if ($_cimProfileId = $_customerObject->getCimProfileId()) {
                        Mage::getModel('authorizenetcim/profile')->load($_cimProfileId)
                            ->setDefaultPaymentId($_paymentProfileId)
                            ->saveWithMode();
                    }
                }

                $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $_cardCustomer->getId() . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
                return;
            }
        }
    }

    public function deleteAction()
    {
        $_session = Mage::getSingleton('core/session');
        $_session->setEscapeMessages(true);// prevent XSS injection in user input

        $_customerId = (int)$this->getRequest()->getParam('customer_id');

        $_customer = Mage::getModel('customer/customer')->load($_customerId);

        if (!$_customerProfileId = $_customer->getCimGatewayId()) {
            $_session->addError($this->__('There is no CIM gateway id associated with this customer.'));
            $this->_redirectError(Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/edit/id/' . $this->getRequest()->getParam('id') . '/customer_id/' . $this->getRequest()->getParam('customer_id') , array('_secure' => true)));
            return;
        }

        $_customerPaymentProfileId = $this->getRequest()->getParam('id', false);

        // Make sure this is a valid profile, we don't want customers deleting
        // other peoples' info just by knowing the Id
        $_paymentProfile = Mage::getModel('authorizenetcim/profile')
            ->getCustomerPaymentProfile($_customerProfileId, $_customerPaymentProfileId);

        if (!$_paymentProfile) {
            $_session->addError($this->__('Invalid payment profile requested.'));
            $this->_redirectError(Mage::helper("adminhtml")->getUrl('authorizenetcim/adminhtml_card/edit/id/' . $this->getRequest()->getParam('id') . '/customer_id/' . $this->getRequest()->getParam('customer_id') , array('_secure' => true)));
            return;
        }

        // Check to see if we can delete the card
        if (!$this->_canDeletePaymentProfile($_customerPaymentProfileId, $_customerId)) {
            $_session->addError($this->__('The card you requested to delete is currently in use on one or more order. Please try again once your orders have been completed.'));
            $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $this->getRequest()->getParam('customer_id') . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            return;
        }

        // Perform the Delete
        $result = Mage::getModel('authorizenetcim/profile')->deleteCustomerPaymentProfile($_customerProfileId, $_customerPaymentProfileId);
        if ($result) {
            $_session->addSuccess($this->__('Card has been successfully removed.'));
            $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $this->getRequest()->getParam('customer_id') . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            return;
        } else {
            $_session->addError($this->__('Unable to delete card at this time.'));
            $this->_redirectSuccess(Mage::helper("adminhtml")->getUrl('adminhtml/customer/edit/id/' . $this->getRequest()->getParam('customer_id') . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)));
            return;
        }
    }

    /**
     * Format the data properly for the Gateway post
     *
     * @param type $customer_data
     * @return Varien_Object $customer
     */
    public function _prepareCustomerForGateway($_customerDataArray)
    {
        if (!isset($_customerDataArray['customer_id'])) {
            return new Varien_Object();
        }

        $_customerObject = Mage::getSingleton('customer/customer')->load($_customerDataArray['customer_id']);

        if (!$_customerObject->getId()) {
            return new Varien_Object();
        }

        $_state = '';
        if (isset($_customerDataArray['region_id']) && !empty($_customerDataArray['region_id'])) {
            $_state = Mage::getModel('directory/region')->load($_customerDataArray['region_id'])->getCode();
        } else {
            $_state = $_customerDataArray['region'];
        }

        $_customerDataObject = new Varien_Object;
        $_customerDataObject->setEmail($_customerObject->getEmail())
            ->setId($_customerObject->getId())
            ->setDescription('Magento Customer ID: ' . $_customerObject->getId())
            ->setGatewayId($_customerObject->getCimGatewayId())
            ->setFirstname(isset($_customerDataArray['cc_first_name']) ? $_customerDataArray['cc_first_name'] : '')
            ->setLastname(isset($_customerDataArray['cc_last_name']) ? $_customerDataArray['cc_last_name'] : '')
            ->setCompany(isset($_customerDataArray['cc_company']) ? $_customerDataArray['cc_company'] : '')
            ->setAddress(isset($_customerDataArray['cc_billing_address']) ? $_customerDataArray['cc_billing_address'] : '')
            ->setCity(isset($_customerDataArray['cc_billing_city']) ? $_customerDataArray['cc_billing_city']: '')
            ->setState($_state)
            ->setZip(isset($_customerDataArray['cc_billing_zip']) ? $_customerDataArray['cc_billing_zip'] : '')
            ->setPhoneNumber(isset($_customerDataArray['cc_billing_phone']) ? $_customerDataArray['cc_billing_phone'] : '')
            ->setFaxNumber(isset($_customerDataArray['cc_billing_fax']) ? $_customerDataArray['cc_billing_fax']: '')
            ->setCountry(isset($_customerDataArray['country_id']) ? $_customerDataArray['country_id'] : '');

        $_paymentProfile = new Varien_Object;
        $_customerDataObject->setPaymentProfile($_paymentProfile);

        $_customerDataObject->getPaymentProfile()
            ->setCc(isset($_customerDataArray['cc_number']) ? $_customerDataArray['cc_number'] : '')
            ->setCcv(isset($_customerDataArray['cc_cvn']) ? $_customerDataArray['cc_cvn'] : '')
            ->setGatewayId($this->getRequest()->getParam('id', false));


        $formatted_expiration = '';
        //Adding leading zero
        if (strlen($_customerDataArray['cc_exp_month']) == 1) {
            $_customerDataArray['cc_exp_month'] = '0' . $_customerDataArray['cc_exp_month'];
        }

        if ($_customerDataArray['cc_exp_year'] == "XX" && $_customerDataArray['cc_exp_month'] = "XX")
        {
            $formatted_expiration = $_customerDataArray['cc_exp_year'] . $_customerDataArray['cc_exp_month'];
        } else {
            $formatted_expiration = $_customerDataArray['cc_exp_year'] . "-" . $_customerDataArray['cc_exp_month'];
        }

        $_customerDataObject->getPaymentProfile()->setExpiration($formatted_expiration);

        return $_customerDataObject;
    }


    public function _prepareGatewayDataForForm($_paymentProfile)
    {
        $_regionModel = Mage::getModel('directory/region')->loadByCode($_paymentProfile->billTo->state, $_paymentProfile->billTo->country);

        //Try to load by name
        if (!$_regionModel->getId()) {
            $_regionModel = Mage::getModel('directory/region')->loadByName($_paymentProfile->billTo->state, $_paymentProfile->billTo->country);
        }

        $_customerData = new Varien_Object(
            array(
                'region_id' => $_regionModel->getId()
            )
        );

        if (isset($_paymentProfile->billTo->firstName)) {
            $_customerData->setData('cc_first_name', $_paymentProfile->billTo->firstName);
        }

        if (isset($_paymentProfile->billTo->lastName)) {
            $_customerData->setData('cc_last_name', $_paymentProfile->billTo->lastName);
        }

        if (isset($_paymentProfile->billTo->company)) {
            $_customerData->setData('cc_company', $_paymentProfile->billTo->company);
        }

        if (isset($_paymentProfile->billTo->address)) {
            $_customerData->setData('cc_billing_address', $_paymentProfile->billTo->address);
        }

        if (isset($_paymentProfile->billTo->city)) {
            $_customerData->setData('cc_billing_city', $_paymentProfile->billTo->city);
        }

        if (isset($_paymentProfile->billTo->zip)) {
            $_customerData->setData('cc_billing_zip', $_paymentProfile->billTo->zip);
        }

        if (isset($_paymentProfile->billTo->phoneNumber)) {
            $_customerData->setData('cc_billing_phone', $_paymentProfile->billTo->phoneNumber);
        }

        if (isset($_paymentProfile->billTo->faxNumber)) {
            $_customerData->setData('cc_billing_fax', $_paymentProfile->billTo->faxNumber);
        }

        if (isset($_paymentProfile->billTo->country)) {
            $_customerData->setData('country_id', $_paymentProfile->billTo->country);
        }

        if (isset($_paymentProfile->payment->creditCard->cardNumber)) {
            $_customerData->setData('cc_number', $_paymentProfile->payment->creditCard->cardNumber);
        }

        return $_customerData;
    }



    /**
     * Check to make sure the customer has no open orders before deleting the
     * payment profile.
     *
     * @param int $_paymentProfileId
     * @param int $_customerId
     * @return bool
     */
    protected function _canDeletePaymentProfile($_paymentProfileId, $_customerId)
    {
        $ordersCollection = Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('customer_id', array('eq' => $_customerId))
            ->addFieldToFilter('status', array('nin' => array('complete','canceled')));

        foreach ($ordersCollection as $order) {
            if ($order->getPayment()->getAuthorizenetcimPaymentId() == $_paymentProfileId) {
                return false;
                break;
            }
        }

        return true;
    }
}
