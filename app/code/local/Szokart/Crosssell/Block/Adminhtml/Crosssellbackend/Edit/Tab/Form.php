<?php
/** This script is part of the crosssell project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Block_Adminhtml_Crosssellbackend_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

protected function _prepareForm()
{
$form = new Varien_Data_Form();
$this->setForm($form);
$fieldset = $form->addFieldset('crosssell_form', array('legend'=>Mage::helper('crosssell')->__('Group')));



$fieldset->addField('name', 'text', array(
'label'     => Mage::helper('crosssell')->__('Name'),
'class'     => 'required-entry',
'required'  => true,
'name'      => 'name',
));

$fieldset->addField('status', 'select', array(
		'name' => 'status',
		'label' => Mage::helper('crosssell')->__('Status'),
		'title' => Mage::helper('crosssell')->__('Status'),
		'values'=>  array(
			array(
			'value' => '0',
			'label' => Mage::helper('crosssell')->__('Disabled')
			),
			array(
			'value' => '1',
			'label' => Mage::helper('crosssell')->__('Enabled')
			),
)
));

$fieldset->addField('lager', 'text', array(
'label'     => Mage::helper('crosssell')->__('Percentage Value Discounts'),
'class'     => 'required-entry validate-number',
'required'  => true,
'name'      => 'lager',
));


 $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $fieldset->addField('dfrom', 'date', array(
            'name'   => 'dfrom',
            'label'  => Mage::helper('crosssell')->__('Date From'),
            'title'  => Mage::helper('crosssell')->__('Date From'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => $dateFormatIso
        ));

   $fieldset->addField('dto', 'date', array(
            'name'   => 'dto',
            'label'  => Mage::helper('crosssell')->__('Date To'),
            'title'  => Mage::helper('crosssell')->__('Date To'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => $dateFormatIso
        ));
		
		
		$customerGroups = Mage::getResourceModel('customer/group_collection')->load()->toOptionArray(); 
 		$fieldset->addField('customer_group', 'multiselect', array(
          'label'     => Mage::helper('crosssell')->__('Customer group'),
          'name'      => 'customer_group',
		  'note'      => Mage::helper('crosssell')->__('if not selected to display all customer groups'),
		  'values'   => $customerGroups,
        )); 
		
	
if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('stores', 'multiselect', array(
                'label'     => Mage::helper('crosssell')->__('Visible In'),
                'required'  => true,
                'name'      => 'stores[]',
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
              
            ));
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
}	


 

if ( Mage::getSingleton('adminhtml/session')->getcrosssellData() )
{
$form->setValues(Mage::getSingleton('adminhtml/session')->getcrosssellData());
Mage::getSingleton('adminhtml/session')->setcrosssellData(null);
} elseif ( Mage::registry('crosssell_data') ) {
$form->setValues(Mage::registry('crosssell_data')->getData());
}

return parent::_prepareForm();

}
}