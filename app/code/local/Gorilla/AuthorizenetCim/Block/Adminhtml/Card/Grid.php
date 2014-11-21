<?php

class Gorilla_AuthorizenetCim_Block_Adminhtml_Card_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('cardGrid');
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
        $this->setEmptyText(Mage::helper('authorizenetcim')->__('There are no cards associated with this user.'));
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_getCards(Mage::app()->getRequest()->getParam('id')));
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('cc_number', array(
            'header'    => Mage::helper('authorizenetcim')->__('Card Number'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'cc_number',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('gateway_id', array(
            'header'    => Mage::helper('authorizenetcim')->__('Profile Id'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'gateway_id',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('firstname', array(
            'header'    => Mage::helper('authorizenetcim')->__('First Name'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'firstname',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('authorizenetcim')->__('Last Name'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'lastname',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('address', array(
            'header'    => Mage::helper('authorizenetcim')->__('Address'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'address',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('city', array(
            'header'    => Mage::helper('authorizenetcim')->__('City'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'city',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('state', array(
            'header'    => Mage::helper('authorizenetcim')->__('State'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'state',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('zip', array(
            'header'    => Mage::helper('authorizenetcim')->__('Zip Code'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'zip',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('country', array(
            'header'    => Mage::helper('authorizenetcim')->__('Country'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'country',
            'filter'    => false,
            'sortable'  => false,

        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('authorizenetcim')->__('Edit'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('authorizenetcim')->__('Edit Card'),
                        'field'   => 'gateway_id',
                        'href'    => $this->getUrl($this->_getControllerUrl('edit/id/$gateway_id/customer_id/' . Mage::app()->getRequest()->getParam('id')))
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return '#';
    }

    /**
     * Get Url to action
     *
     * @param  string $action action Url part
     * @return string
     */
    protected function _getControllerUrl($action = '')
    {
        return '*/*/' . $action;
    }

    protected function _getCards($_customerId)
    {
        $cards = new Varien_Data_Collection();

        $customer = Mage::getModel('customer/customer')->load($_customerId);

        if (!$customer->getCimGatewayId()) {
            return $cards;
        }

        $cim_profile = Mage::getModel('authorizenetcim/profile')->getCustomerProfile($customer->getCimGatewayId());
        if ($cim_profile) {
            if (isset($cim_profile->paymentProfiles) && is_object($cim_profile->paymentProfiles)) {
                /**
                 * The Soap XML response may be a single stdClass or it may be an
                 * array. We need to adjust it to make it uniform.
                 */
                if (is_array($cim_profile->paymentProfiles->CustomerPaymentProfileMaskedType)) {
                    $payment_profiles = $cim_profile->paymentProfiles->CustomerPaymentProfileMaskedType;
                } else {
                    $payment_profiles = array($cim_profile->paymentProfiles->CustomerPaymentProfileMaskedType);
                }

                // Assign card objects to array
                foreach ($payment_profiles as $payment_profile) {
                    $card = new Varien_Object();
                    $card->setCcNumber($payment_profile->payment->creditCard->cardNumber)
                        ->setGatewayId($payment_profile->customerPaymentProfileId)
                        ->setFirstname($payment_profile->billTo->firstName)
                        ->setLastname($payment_profile->billTo->lastName)
                        ->setAddress($payment_profile->billTo->address)
                        ->setCity($payment_profile->billTo->city)
                        ->setState($payment_profile->billTo->state)
                        ->setZip($payment_profile->billTo->zip)
                        ->setCountry($payment_profile->billTo->country);

                    $cards->addItem($card);
                }
            }
        }

        return $cards;
    }

}