<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento enterprise edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Raf
 * @version    2.1.6
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Raf_Block_Adminhtml_Bonus_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('id');
        $this->setTitle($this->__('Rule Information'));
    }

    protected function _prepareForm()
    {
        $id = Mage::app()->getRequest()->getParam('id');
        $form = new Varien_Data_Form(
            array(
                 'id'      => 'edit_form',
                 'action'  =>  Mage::helper('adminhtml')->getUrl('*/*/save', array('id' => $id)),
                 'method'  => 'post',
                 'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);

        $fieldset = $form->addFieldset('base_fieldset',
            array(
                'legend' => $this->__('Discount Details')
            )
        );

        $fieldset->addField('discount', 'text',
            array(
                'label'    => $this->__('Discount Amount %'),
                'title'    => $this->__('Discount Amount %'),
                'required' => true,
                'class'    => 'validate-greater-than-zero validate-percents',
                'name'     => 'discount'
            )
        );

         $fieldset->addField('comment', 'text',
            array(
                'label'    => $this->__('Comment'),
                'title'    => $this->__('Comment'),
                'name'     => 'comment'
            )
         );

        $discountModel = Mage::registry('awraf_discount');

        if (Mage::app()->isSingleStoreMode()) {
            $websiteId = Mage::app()->getStore(true)->getWebsiteId();
            $fieldset->addField('raf_website', 'hidden',
                array(
                    'name'  => 'raf_website',
                    'value' => $websiteId
                )
            );

        } else {
            $fieldset->addField('raf_website', 'select',
                array(
                    'name'   => 'raf_website',
                    'label'  => $this->__('Website'),
                    'title'  => $this->__('Website'),
                    'values' => Mage::getSingleton('adminhtml/system_config_source_website')->toOptionArray()
                )
            );
        }

        if ($discountModel->getId()) {
            if ($discountModel->getRuleId()) {
                $ruleObj = Mage::getModel('awraf/rule')->load($discountModel->getRuleId());
                if ($ruleObj->getId()) {
                    $fieldset
                        ->addField('rule_name', 'label',
                            array(
                                 'label' => $this->__('Related Rule')
                            )
                        )
                        ->setRule($ruleObj)
                        ->setRenderer($this->getLayout()->createBlock('awraf/adminhtml_edit_renderer_ruleName'))
                    ;
                }
            }

            $customer = Mage::getModel('customer/customer')->load($discountModel->getCustomerId());

            if ($customer->getId()) {
                $fieldset
                    ->addField('customer_name', 'label',
                        array(
                             'label' => $this->__('Customer')
                        )
                    )
                    ->setCustomer($customer)
                    ->setRenderer($this->getLayout()->createBlock('awraf/adminhtml_edit_renderer_customerName'))
                ;
            }

        } else {
            $fieldset
                ->addField('selected_values', 'hidden',
                    array(
                         'name' => 'selected_values'
                    )
                )
            ;

            $customerFieldset = $form->addFieldset('customer_fieldset',
                array(
                     'legend' => $this->__('Customers')
                )
            );

            $customerFieldset
                ->addField('customer_grid', 'text',
                    array(
                         'label' => $this->__('Customer Grid')
                    )
                )
                ->setRenderer($this->getLayout()->createBlock('awraf/adminhtml_edit_renderer_customerGrid'))
            ;
        }

        if ($formData = Mage::getSingleton('adminhtml/session')->getFormData(true)) {
            $form->setValues($formData);
        } else if (null !== $discountModel->getId()){
            $form->setValues($discountModel->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}