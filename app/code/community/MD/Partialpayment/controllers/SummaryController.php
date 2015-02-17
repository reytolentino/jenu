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
class MD_Partialpayment_SummaryController extends Mage_Core_Controller_Front_Action
{
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
        $p = $this->getRequest()->getParam('p',null);
        $limit = $this->getRequest()->getParam('limit',null);
        $paymentRequestArea = $this->getRequest()->getParam('request_area',null);
        $session = Mage::getSingleton('core/session');
        $session->setPartialSummaryId($summaryId);
        
        $this->getResponse()->setBody($this->getLayout()->createBlock('md_partialpayment/paypal_standard_redirect')->setPageNo($p)->setPagerLimit($limit)->setPaymentRequestArea($paymentRequestArea)->toHtml());
    }
    
    public function paypalCancelAction()
    {
        $params = $this->getRequest()->getParams();
        $p = ($params['p']) ? $params['p']: null;
        $limit = ($params['limit']) ? $params['limit']: null;
        Mage::getSingleton('core/session')->addError($this->__('Error Occured during payment.'));
        $returnUrl = Mage::getUrl('md_partialpayment/summary/view',array('payment_id'=>$params['payment_id']));
            if($p && $limit){
                $returnUrl .= '?p='.$p.'&limit='.$limit;
            }elseif($p){
                $returnUrl .= '?p='.$p;
            }elseif($limit){
                $returnUrl .= '?limit='.$limit;
            }
            $this->getResponse()->setRedirect($returnUrl);
    }
    
    public function paypalSuccessAction()
    {
        $params = $this->getRequest()->getParams();
        $p = ($params['p']) ? $params['p']: null;
        $limit = ($params['limit']) ? $params['limit']: null;
        Mage::getSingleton('core/session')->addSuccess($this->__('Payment has been submited'));
        $returnUrl = Mage::getUrl('md_partialpayment/summary/view',array('payment_id'=>$params['payment_id']));
            if($p && $limit){
                $returnUrl .= '?p='.$p.'&limit='.$limit;
            }elseif($p){
                $returnUrl .= '?p='.$p;
            }elseif($limit){
                $returnUrl .= '?limit='.$limit;
            }
        $this->getResponse()->setRedirect($returnUrl);
    }
    
    public function paypalIpnAction()
    {
        if (!$this->getRequest()->isPost()) {
            return;
        }
        try {
            $data = $this->getRequest()->getPost();
            $param = $this->getRequest()->getParams();
            
            Mage::getModel('md_partialpayment/payment_paypal_standard')->processIpnRequest($data, $param['summary_id'], $param['payment_id']);
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setHttpResponseCode(500);
        }
    }
    
    public function preDispatch()
    {
        
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        //die($action);
        if(!in_array($action,array('paypalIpn','relayResponse','pay','paypalRedirect'))){
            $loginUrl = Mage::helper('customer')->getLoginUrl();

            if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }
        }
        return $this;
    }
    
    public function relayResponseAction()
    {
        $data = $this->getRequest()->getPost();
        $summaryId = $this->getRequest()->getParam('summary_id', null);
        Mage::getModel('md_partialpayment/payment_authorizenet_directpost')->process($data, $summaryId);
    }
    
    public function listAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function viewAction()
    {
        if (!$this->_loadValidInstallment()) {
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');

        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
        if ($navigationBlock) {
            $navigationBlock->setActive('md_partialpayment/summary/list');
        }
        $this->renderLayout();
    }
    
    protected function _loadValidInstallment($paymentId = null)
    {
        if (null === $paymentId) {
            $paymentId = (int) $this->getRequest()->getParam('payment_id');
        }
        if (!$paymentId) {
            $this->_forward('noRoute');
            return false;
        }

        $payment = Mage::getModel('md_partialpayment/payments')->load($paymentId);

        if ($payment->getId()) {
            return true;
        } else {
            $this->_redirect('*/*/list');
        }
        return false;
    }
    
    public function paymentOptionsAction()
    {
        $this->loadLayout();
        $params = $this->getRequest()->getParam('summary_id');
        $block = $this->getLayout()->createBlock('md_partialpayment/summary_payment_methods')->setSummaryId($params);
        $this->getResponse()->setBody($block->toHtml());
    }
    
    public function payAction()
    {
        $params = $this->getRequest()->getParams();
        $p = ($params['p']) ? $params['p']: null;
        $limit = ($params['limit']) ? $params['limit']: null;
        $summaryId = $params['payment_summary'];
        $summary = Mage::getModel('md_partialpayment/summary')->load($summaryId);
        $method = $params['partial']['method'];
        $info = $params[$method];
        $info['method'] = $method;
        
        $payments = $summary->getPayments();
        $order = $payments->getOrder();
        
        
        if(in_array($method, $this->_redirectMethods)){
            
            $this->_redirect($this->_redirectAction[$method], array('_secure' => true,'summary_id'=>$summaryId,'p'=>$p,'limit'=>$limit));
        }
        else{
            try{
            Mage::getModel($this->_processMethod[$method])
                        ->setSummary($summary)
                        ->setPayments($payments)
                        ->setOrder($order)
                        ->pay($info);
                }catch(Exception $e){
                Mage::getSingleton('core/session')->addError($e->getMessage());
            }
            $returnUrl = Mage::getUrl('md_partialpayment/summary/view',array('payment_id'=>$summary->getPaymentId()));
            if($p && $limit){
                $returnUrl .= '?p='.$p.'&limit='.$limit;
            }elseif($p){
                $returnUrl .= '?p='.$p;
            }elseif($limit){
                $returnUrl .= '?limit='.$limit;
            }
            $this->getResponse()->setRedirect($returnUrl);
        }    
        
    }
}

