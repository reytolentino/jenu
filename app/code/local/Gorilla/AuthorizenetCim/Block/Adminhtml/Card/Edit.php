<?php

class Gorilla_AuthorizenetCim_Block_Adminhtml_Card_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'authorizenetcim';
        $this->_controller = 'adminhtml_card';
        $this->_mode = 'edit';

        $this->_headerText = $this->helper('authorizenetcim')->__('Authorize.net CIM Card');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->_updateButton('save', 'label', $this->__('Save Card'));
        $this->_addButton('delete', array(
            'label'   => Mage::helper('authorizenetcim')->__('Delete Card'),
            'onclick' => 'deleteConfirm(\'' . Mage::helper('authorizenetcim')->__('Are you sure you want to do this?')
                . '\', \'' . Mage::helper('adminhtml')->getUrl('*/*/delete', array('id' => $this->getListId())) . '\')',
            'class'   => 'scalable delete',
            'level'   => -1
        ));

        $this->_updateButton('back', 'onclick', 'setLocation(\'' . Mage::helper('adminhtml')->getUrl('adminhtml/customer/edit/id/' . Mage::app()->getRequest()->getParam('customer_id') . '/tab/customer_info_tabs_customer_tab_card', array('_secure' => true)) . '\');');

        if (Mage::app()->getRequest()->getParam('id')) {
            $this->_updateButton('delete', 'onclick', 'deleteConfirm(\'' . $this->__('Are you sure you want to do this?') . '\', \'' . Mage::helper('adminhtml')->getUrl('authorizenetcim/adminhtml_card/delete/id/' . Mage::app()->getRequest()->getParam('id') . '/customer_id/' . Mage::app()->getRequest()->getParam('customer_id')) . '\');');
        } else {
            $this->_removeButton('delete');
        }

        return $this;
    }

    /**
     * Get current instance id
     *
     * @return int
     */
    public function getListId()
    {
        return Mage::registry('card_form_data')->getId();
    }
}
