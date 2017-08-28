<?php
/* 
* ////////////////////////////////////////////////////////////////////////////////////// 
* 
* @Author Emipro Technologies Private Limited 
* @Category Emipro 
* @Package  Emipro_Paymentservicecharge 
* @License http://shop.emiprotechnologies.com/license-agreement/ 
* 
* ////////////////////////////////////////////////////////////////////////////////////// 
*/ 
 

class Emipro_paymentservicecharge_Block_Adminhtml_System_Config_Form_Field_Regexceptions extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    
    protected $_groupRenderer;
	protected $_paymentRenderer;
	protected $_chargeTypeRenderer;
    /**
     * Retrieve group column renderer
     *
     * @return Mage_CatalogInventory_Block_Adminhtml_Form_Field_Customergroup
     */
    protected function _getGroupRenderer()
    {
        if (!$this->_groupRenderer) {
            $this->_groupRenderer = $this->getLayout()->createBlock(
                'cataloginventory/adminhtml_form_field_customergroup', '',
                array('is_render_to_js_template' => true)
            );
            $this->_groupRenderer->setClass('customer_group_select');
            $this->_groupRenderer->setExtraParams('style="width:120px"');
        }
       // Mage::log($this->_getGroupRenderer,null,"customer.log");
        return $this->_groupRenderer;
    }

	protected function _getPaymentRenderer()
    {
        if (!$this->_paymentRenderer) {
            $this->_paymentRenderer = $this->getLayout()->createBlock(
                'emipro_paymentservicecharge/adminhtml_system_config_form_field_activepayment', '',
                array('is_render_to_js_template' => true)
            );
            $this->_paymentRenderer->setClass('payment_method_select');
            
            $this->_paymentRenderer->setExtraParams('style="width:120px"');
        }  
        return $this->_paymentRenderer;
    }
    
    protected function _getChargeTypeRenderer()
    {
        if (!$this->_chargeTypeRenderer) {
            $this->_chargeTypeRenderer = $this->getLayout()->createBlock(
                'emipro_paymentservicecharge/adminhtml_system_config_form_field_extrachargetype', '',
                array('is_render_to_js_template' => true)
            );
            $this->_chargeTypeRenderer->setClass('extract_charge_type');
            
            $this->_chargeTypeRenderer->setExtraParams('style="width:120px"');
        }  
        return $this->_chargeTypeRenderer;
    }
    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
		 Mage::helper("emipro_paymentservicecharge")->validpaymentservicechargedata();
		 
		 $this->addColumn('name', array(
            'label' => Mage::helper('emipro_paymentservicecharge')->__('Label'),
            'style' => 'width:100px',
             'required' => true,
        ));
		
		   $this->addColumn('payment_method', array(
            'label' => Mage::helper('emipro_paymentservicecharge')->__('Payment Method'),
            'style' => 'width:120px',
            'renderer' =>$this->_getPaymentRenderer(),

        ));
		
        $this->addColumn('customer_group_id', array(
            'label' => Mage::helper('emipro_paymentservicecharge')->__('Customer Group'),
            'renderer' => $this->_getGroupRenderer(),
        ));
        $this->addColumn('extra_charge_value', array(
            'label' => Mage::helper('emipro_paymentservicecharge')->__('Extra Charge Value'),
            'style' => 'width:100px',
             'required' => true,
        ));
         $this->addColumn('extra_charge_type', array(
            'label' => Mage::helper('emipro_paymentservicecharge')->__('Extra Charge Type'),
            'style' => 'width:100px',
            'renderer' => $this->_getChargeTypeRenderer(),
            'required' => true,
        ));
        
        
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('emipro_paymentservicecharge')->__('Add New');
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
		//Mage::log($row,null,"row.log");
        $row->setData(
            'option_extra_attr_' . $this->_getGroupRenderer()->calcOptionHash($row->getData('customer_group_id')),
            'selected="selected"'
        );
         $row->setData(
            'option_extra_attr_' . $this->_getPaymentRenderer()->calcOptionHash($row->getData('payment_method')),
            'selected="selected"'
        );
          $row->setData(
            'option_extra_attr_' . $this->_getChargeTypeRenderer()->calcOptionHash($row->getData('extra_charge_type')),
            'selected="selected"'
        );
    }
    
}
