<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Sarp
 * @version    1.7.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */

class AW_Sarp_SubscriptionsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_initAction()
                ->_setActiveMenu('catalog')
                ->_addContent($this->getLayout()->createBlock('sarp/adminhtml_subscriptions'))
                ->renderLayout();
    }

    /**
     * Draw edit form for subscription
     * @return
     */
    public function editAction()
    {
        $Subscription = Mage::getModel('sarp/subscription')->load($this->getRequest()->getParam('id'));
        $this->_initAction();
        $this->_title($this->__('Edit subscription'));
        $this
            ->_addContent($this->getLayout()->createBlock('sarp/adminhtml_subscriptions_edit')->setSubscription($Subscription))
            ->_addLeft(
                $this->getLayout()->createBlock('sarp/adminhtml_subscriptions_edit_tabs')->setSubscription($Subscription)
            )
                ->renderLayout();
    }

    /**
     * Saves subscription
     * @return
     */
    public function saveAction()
    {
        $Subscription = Mage::getModel('sarp/subscription')->load($this->getRequest()->getParam('id'));
        try {
            if (!$Subscription->getId()) {
                throw new AW_Sarp_Exception("Subscription doesn't exist!");
            }
            $Subscription->setStatus($this->getRequest()->getParam('status'))->save();
            Mage::getSingleton('adminhtml/session')->addSuccess("Subscription successfully saved");
        } catch (AW_Sarp_Exception $E) {
            Mage::getSingleton('adminhtml/session')->addError($E->getMessage());

        }
        $this->_redirect('*/*');
    }


    public function payAction()
    {
        $subscriptionId = $this->getRequest()->getParam('id');
        $sequenceId = $this->getRequest()->getParam('seq');
        $subscription = Mage::getModel('sarp/subscription')->load($subscriptionId);
        $sequence = Mage::getModel('sarp/sequence')->load($sequenceId);
        $dateForPay = new Zend_Date($sequence->getDate(), AW_Sarp_Model_Subscription::DB_DATE_FORMAT);
        $dateForPayLoc = Mage::app()->getLocale()->date($dateForPay);
        $diff = (int)$dateForPayLoc->toString('X');
        $dateForPay->subSecond($diff);
        AW_Sarp_Model_Cron::$isCronSession = 1;
        $subscription->payForDate($dateForPay);
        AW_Sarp_Model_Cron::$isCronSession = 0;
        $this->_redirectReferer();
    }

    public function skipAction()
    {
        $sequenceId = $this->getRequest()->getParam('seq');
        $sequence = Mage::getModel('sarp/sequence')
                ->load($sequenceId)
                ->setStatus(AW_Sarp_Model_Sequence::STATUS_FAILED)
                ->save();
        $this->_redirectReferer();
    }

    protected function _initAction()
    {
        $this->_title($this->__('Subscriptions List'));
        $this->loadLayout()
                ->_setActiveMenu('sarp');
        return $this;
    }

    protected function _title($text = null, $resetIfExists = true)
    {
        if (!Mage::helper('sarp')->checkVersion('1.4.0.0')) {
            return $this;
        }
        return parent::_title($text, $resetIfExists);
    }

    /**
     * Clear errors for current subscription
     * @return
     */
    public function errclearAction()
    {
        $Subscription = Mage::getModel('sarp/subscription')->load($this->getRequest()->getParam('id'));
        if (is_null($Subscription->getId())) {
            Mage::getSingleton('adminhtml/session')->addError($this->__("Subscription doesn't exist!"));
            $this->_redirect('*/*');
            return;
        }
        if(! $Subscription->isActiveWithErrors()) {
            Mage::getSingleton('adminhtml/session')->addError($this->__("Subscription is inactive or doesn't have errors"));
            $this->_redirect('*/*/edit', array('id'=>$this->getRequest()->getParam('id')));
            return;
        }
        if($Subscription->clearErrorForLastSequence()) {
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Error from subscription removed"));
        } else {
            Mage::getSingleton('adminhtml/session')->addError($this->__("Failed to remove error"));
        }
        $this->_redirect('*/*/edit', array('id'=>$this->getRequest()->getParam('id')));
    }

}