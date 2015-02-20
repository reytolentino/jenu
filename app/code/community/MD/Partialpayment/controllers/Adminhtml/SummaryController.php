<?php
/**
* Magedelight
* Copyright (C) 2014 Magedelight <info@magedelight.com>
*
* NOTICE OF LICENSE
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
*
* @category MD
* @package MD_Partialpayment
* @copyright Copyright (c) 2014 Mage Delight (http://www.magedelight.com/)
* @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
* @author Magedelight <info@magedelight.com>
*/
class MD_Partialpayment_Adminhtml_SummaryController extends Mage_Adminhtml_Controller_Action
{
    protected $_publicActions = array('pay','paypalCancel','paypalSuccess','paypalRedirect','view');
    protected $_redirectMethods = array(
        Mage_Paypal_Model_Config::METHOD_WPS
    );
    
    protected $_creditCardRequiredMethod = array(
        Mage_Paygate_Model_Authorizenet::METHOD_CODE
    );
    
    protected $_processMethod = array(
        Mage_Paygate_Model_Authorizenet::METHOD_CODE => 'md_partialpayment/payment_authorizenet',
        'ccsave'=>'md_partialpayment/payment_ccsave',
        'checkmo'=>'md_partialpayment/payment_checkmo',
        'cashondelivery'=>'md_partialpayment/payment_cashondelivery',
        'authorizenet_directpost' => 'md_partialpayment/payment_authorizenet_directpost',
        Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE => 'md_partialpayment/payment_authorizenetcim'
    );
    
    protected $_redirectAction = array(
        Mage_Paypal_Model_Config::METHOD_WPS => '*/*/paypalRedirect'
    );
    
    protected $_adminActionMethod = array(
        'ccsave','checkmo','cashondelivery'
    );
    
    public function paypalRedirectAction()
    {
        $summaryId = $this->getRequest()->getParam('summary_id');
        $session = Mage::getSingleton('adminhtml/session');
        $session->setPartialSummaryId($summaryId);
        
        $this->getResponse()->setBody($this->getLayout()->createBlock('md_partialpayment/paypal_standard_redirect')->setPaymentRequestArea('adminhtml')->toHtml());
    }
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('md_partialpayment');
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('md_partialpayment')->__('Installment Summary'));
        $this->renderLayout();
    }
    
    public function viewAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('md_partialpayment');
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('md_partialpayment')->__('Installment Summary Details'));
        $this->renderLayout();
    }
    /*public function preDispatch()
    {
        $action = $this->getRequest()->getActionName();
        $refererUrl = $this->getRequest()->getServer('HTTP_REFERER');
        die($refererUrl);
        $dispatch = false;
        if($action == 'view'){
            if(strstr($refererUrl,'md_partialpayment/adminhtml_summary/index') !== FALSE){
                $dispatch = true;
            }
            //die();
        }
        if(!in_array($action,array('pay','paypalCancel','paypalSuccess','paypalRedirect')) || $dispatch){
            parent::preDispatch();
        }else{
            
            Mage::getDesign()
                ->setArea('adminhtml')
                ->setPackageName((string)Mage::getConfig()->getNode('stores/admin/design/package/name'))
                ->setTheme((string)Mage::getConfig()->getNode('stores/admin/design/theme/default'))
            ;
            foreach (array('layout', 'template', 'skin', 'locale') as $type) {
                if ($value = (string)Mage::getConfig()->getNode("stores/admin/design/theme/{$type}")) {
                    Mage::getDesign()->setTheme($type, $value);
                }
            }

            $this->getLayout()->setArea('adminhtml');

            Mage::dispatchEvent('adminhtml_controller_action_predispatch_start', array());
            $_isValidFormKey = true;
            $_isValidSecretKey = true;
            if (!$_isValidFormKey || !$_isValidSecretKey) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            $this->setFlag('', self::FLAG_NO_POST_DISPATCH, true);
            if ($this->getRequest()->getQuery('isAjax', false) || $this->getRequest()->getQuery('ajax', false)) {
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array(
                    'error' => true,
                    'message' => $_keyErrorMsg
                )));
            } else {
                $this->_redirect( Mage::getSingleton('admin/session')->getUser()->getStartupPageUrl() );
            }
            return $this;
        }
        
        if ($this->getRequest()->isDispatched()
            && $this->getRequest()->getActionName() !== 'denied'
            && !$this->_isAllowed()) {
            $this->_forward('denied');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return $this;
        }

        if (!$this->getFlag('', self::FLAG_IS_URLS_CHECKED)
            && !$this->getRequest()->getParam('forwarded')
            && !$this->_getSession()->getIsUrlNotice(true)
            && !Mage::getConfig()->getNode('global/can_use_base_url')) {
            //$this->_checkUrlSettings();
            $this->setFlag('', self::FLAG_IS_URLS_CHECKED, true);
        }
        if (is_null(Mage::getSingleton('adminhtml/session')->getLocale())) {
            Mage::getSingleton('adminhtml/session')->setLocale(Mage::app()->getLocale()->getLocaleCode());
        }
        
        }
        return $this;
    }*/
    public function paypalCancelAction()
    {
        $params = $this->getRequest()->getParams();
        Mage::getSingleton('adminhtml/session')->addError($this->__('Error Occured during payment.'));
        $this->_redirect('*/*/view',array('id'=>$params['payment_id']));
    }
    
    public function paypalSuccessAction()
    {
        $params = $this->getRequest()->getParams();
        //die($params);
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Payment has been submited'));
        $this->_redirect('*/*/view',array('id'=>$params['payment_id']));
    }
    
    public function confirmPaymentAction()
    {
        $summaryId = $this->getRequest()->getParam('summary_id',null);
        $paymentId = $this->getRequest()->getParam('payment_id',null);
        if($summaryId){
            $summary = Mage::getModel('md_partialpayment/summary')->load($summaryId);
            $summary->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS);
            $amount = $summary->getAmount();
            $payments = $summary->getPayments();
            $payments->setPaidAmount($payments->getPaidAmount() + $amount)
                        ->setDueAmount($payments->getDueAmount() - $amount)
                        ->setLastInstallmentDate($summary->getPaidDate())
                        ->setPaidInstallments($payments->getPaidInstallments() + 1)
                        ->setDueInstallments($payments->getDueInstallments() - 1)
                        ->setUpdatedAt(date('Y-m-d H:i:s'));
            
            if($payments->getDueInstallments() > 0){
                    $orderDueAmount = max(0,($payments->getOrder()->getTotalDue() - $amount));
                    $baseOrderDueAmount = max(0,($payments->getOrder()->getBaseTotalDue() - $amount));
            }else{
                    $orderDueAmount = 0;
                    $baseOrderDueAmount = 0;
            }
            
            $order = $payments->getOrder();
            
                   $order->setTotalPaid($order->getTotalPaid() + $amount)
                    ->setBaseTotalPaid($order->getBaseTotalPaid() + $amount)
                    ->setTotalDue($orderDueAmount)
                    ->setBaseTotalDue($baseOrderDueAmount);
            $transaction = Mage::getModel('core/resource_transaction');
            $transaction->addObject($summary);
            $transaction->addObject($payments);
            $transaction->addObject($order);
            try{
               $transaction->save();
               Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('md_partialpayment')->__('Payment Confirmed Successfully.'));
            }catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/view',array('id'=>$paymentId));
    }
    
    public function rejectPaymentAction()
    {
        $summaryId = $this->getRequest()->getParam('summary_id',null);
        $paymentId = $this->getRequest()->getParam('payment_id',null);
        if($summaryId){
            $summary = Mage::getModel('md_partialpayment/summary')->load($summaryId);
            $summary->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_FAIL);
            try{
               $summary->save();
               Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('md_partialpayment')->__('Payment Status changed successfully..'));
            }catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/view',array('id'=>$paymentId));
    }
    
    public function _initReportAction($blocks)
    {
        if (!is_array($blocks)) {
            $blocks = array($blocks);
        }
 
        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
        $requestData = $this->_filterDates($requestData, array('from', 'to'));
        $params = new Varien_Object();
 
        foreach ($requestData as $key => $value) {
            if (!empty($value)) {
                $params->setData($key, $value);
            }
        }
 
        foreach ($blocks as $block) {
            if ($block) {
                $block->setPeriodType($params->getData('period_type'));
                $block->setFilterData($params);
            }
        }
        return $this;
    }
    
    public function reportAction()
    {
        $this->loadLayout();
        $gridBlock = $this->getLayout()->getBlock('adminhtml_report.grid');
        $filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');
 
        $this->_initReportAction(array(
        $gridBlock,
        $filterFormBlock
        ));
        $this->renderLayout();
    }
    
    public function sendEmailAction()
    {
        $params = $this->getRequest()->getParams();
        $helper = Mage::helper('md_partialpayment');
        $payment = null;
        $summary = null;
        if(!is_null($params['summary_id'])){
            $summary = Mage::getModel('md_partialpayment/summary')->load($params['summary_id']);
        }
        if(!is_null($params['payment_id'])){
            $payment = Mage::getModel('md_partialpayment/payments')->load($params['payment_id']);
        }
        
        switch($params['action']){
            case 'reminder':
                            try{
                                $helper->sendReminderEmail($params['summary_id']);
                                Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Reminder Email has been sent.'));
                            }catch(Exception $e){
                                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                            }
                            break;
            case 'failed':
                        try{
                                $summary->sendStatusPaymentEmail(true,false,'failed');
                                Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Installment Status Email has been sent.'));
                            }catch(Exception $e){
                                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                            }
                            break;
                        
            case'success':
                        try{
                                $summary->sendStatusPaymentEmail(true,false);
                                Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Installment Status Email has been sent.'));
                            }catch(Exception $e){
                                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                            }
                            break;
            case 'schedule':
                            try{
                                $helper->sendPaymentScheduleEmail($payment);
                                Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Schedule Email has been sent.'));
                            }catch(Exception $e){
                                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                            }
                            break;
        }
        $this->_redirect('*/*/view',array('id'=>$params['payment_id']));
    }
    
    public function massDeleteAction()
    {
        $helper = Mage::helper('md_partialpayment');
        $ids = $this->getRequest()->getParam("partialpayment");
        if(!is_array($ids))
        {
            Mage::getSingleton("adminhtml/session")->addError($helper->__("Please select any item to delete."));
        }
        else
        {
            try{
                foreach($ids as $id)
                {
                    $model = Mage::getModel("md_partialpayment/payments")->load($id);
                    $model->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess($helper->__("Total %d item(s) are deleted successfully",count($ids)));
            }catch(Exception $e){
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
           }
        }
        $this->_redirect("*/*/index");
    }
    
    public function payAction()
    {
        
        $params = $this->getRequest()->getParams();
        
        $summaryId = $params['payment_summary'];
        $summary = Mage::getModel('md_partialpayment/summary')->load($summaryId);
        $requestArea = 'adminhtml';
        $method = $params['partial']['method'];
        $info = $params[$method];
        $info['method'] = $method;
        
        $payments = $summary->getPayments();
        $order = $payments->getOrder();
        
        
        if(in_array($method, $this->_redirectMethods)){
            
            $this->_redirect($this->_redirectAction[$method], array('_secure' => true,'summary_id'=>$summaryId,'request_area'=>$requestArea));
        }
        else{
            try{
            Mage::getModel($this->_processMethod[$method])
                        ->setSummary($summary)
                        ->setPayments($payments)
                        ->setOrder($order)
                        ->setPaymentRequestArea('adminhtml')
                        ->pay($info);
                }catch(Exception $e){
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            $this->_redirect('*/*/view',array('id'=>$summary->getPaymentId()));
        }    
    }
}

