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
class MD_Partialpayment_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PAYMENT_MONTHLY = 'monthly';
    const PAYMENT_WEEKLY = 'weekly';
    const PAYMENT_QUARTERLY = 'quarterly';
    const PARTIAL_ALLOWED_PAYMENT_METHODS = 'global/md_partial_validator/allowed/payment/methods';
    public function getInstallmentSummary(Mage_Sales_Model_Order_Item $item)
    {
        $data = array();
        $frequencyMap = array(
            self::PAYMENT_WEEKLY => ' +7 days',
            self::PAYMENT_QUARTERLY => ' +3 months',
            self::PAYMENT_MONTHLY => ' +1 month'
        );
        if($item instanceof Mage_Sales_Model_Order_Item && $item->getId())
        {
            $current = date('Y-m-d',strtotime($item->getCreatedAt()));
            $frequency = $item->getPartialpaymentFrequency();
            $payment = $item->getOrder()->getPayment();
            $count = $item->getPartialpaymentInstallmentCount();
            $data[0] = array(
                'amount'=> $item->getPartialpaymentPaidAmount(),
                'paid_date'=> $current,
                'status'=>($payment->getMethodInstance()->isGateway()) ? MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS : MD_Partialpayment_Model_Summary::PAYMENT_PROCESS,
                'transaction_id'=> $payment->getLastTransId(),
                'payment_method'=> $payment->getMethod() 
            );
            $current = date('Y-m-d',strtotime($current.$frequencyMap[$frequency]));
            for($c=1;$c<$count;$c++)
            {
                $data[$c] = array(
                    'amount'=> $item->getPartialpaymentAmountDueAfterDate(),
                    'due_date'=> $current,
                );
                $current = date('Y-m-d',strtotime($current.$frequencyMap[$frequency]));
            }
        }
        return $data;
    }
    
    public function isQuotePartialPayment(Mage_Sales_Model_Quote $quote)
    {
        $isPartial = false;
        if($quote instanceof Mage_Sales_Model_Quote){
            foreach($quote->getAllVisibleItems() as $item){
                if($item->getPartialpaymentOptionSelected()){
                    $isPartial = true;
                    break;
                }
            }
        }
        return $isPartial;
    }
    
    public function isAllowedMethod($code){
        $node = Mage::getConfig()->getNode(self::PARTIAL_ALLOWED_PAYMENT_METHODS);
        if(!$node){
            $methods = array();
        }else{
            $methods = array_keys((array) $node);
        }
        
        if(in_array($code, $methods)){
            return true;
        }
        return false;
    }
    
    public function sendReminderEmail($summaryIds){
        if(!is_array($summaryIds)){
            $summaryIds = array($summaryIds);
        }
        
        foreach($summaryIds as $summaryId){
            $summary = Mage::getModel('md_partialpayment/summary')->load($summaryId);
            $payments = $summary->getPayments();
            $order = $payments->getOrder();
            $orderItem = $order->getItemById($payments->getOrderItemId());
            $translate = Mage::getSingleton('core/translate');
            $translate->setTranslateInline(false);
            $mailTemplate = Mage::getModel('core/email_template');
            $template = (!Mage::getStoreConfig('md_partialpayment/email/installment_reminder',$order->getStoreId())) ? 'md_partialpayment_email_installment_reminder' : Mage::getStoreConfig('md_partialpayment/email/installment_reminder',$order->getStoreId());
            $bccConfig = Mage::getStoreConfig('md_partialpayment/email/installment_reminder_copy_to',$order->getStoreId());
            $bcc = ($bccConfig) ? explode(",",$bccConfig): array();
            $sendTo = array(
                    array(
                    'email' => $payments->getCustomerEmail(),
                    'name'  => $payments->getCustomerName()
                )
            ) ;
                    
            foreach ($sendTo as $recipient) {
                if(count($bcc) > 0){
                    foreach($bcc as $copyTo){
                        $mailTemplate->addBcc($copyTo); 
                    }
                }
                $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$order->getStoreId()))
                ->sendTransactional(
                    $template,
                    Mage::getStoreConfig('md_partialpayment/email/installment_reminder_from',$order->getStoreId()),
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'paidAmount' => $order->formatPrice($payments->getPaidAmount()),
                        'dueAmount' => $order->formatPrice($payments->getDueAmount()),
                        'installmetAmount' => $order->formatPrice($summary->getAmount()),
                        'productName' => $orderItem->getName(),
                        'billingAddress' => $order->getBillingAddress(),
                        'shippingAddress' => $order->getShippingAddress(),
                        'customerName' => $payments->getCustomerName(),
                        'customerEmail' => $payments->getCustomerEmail(),
                        'dueDate' => Mage::helper('core')->formatDate($summary->getDueDate(), 'medium'),
                        'orderDate' => Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium'),
                        'orderId'=>$order->getIncrementId()
                    )
                );
            }
        }
        return $this;
    }
    
    public function sendPaymentScheduleEmail(MD_Partialpayment_Model_Payments $payments)
    {
        if($payments instanceof MD_Partialpayment_Model_Payments)
        {
            $order = $payments->getOrder();
            $orderItem = $order->getItemById($payments->getOrderItemId());
            $translate = Mage::getSingleton('core/translate');
            $translate->setTranslateInline(false);
            $mailTemplate = Mage::getModel('core/email_template');
            $template = (!Mage::getStoreConfig('md_partialpayment/email/installment_schedule',$order->getStoreId())) ? 'md_partialpayment_email_installment_schedule' : Mage::getStoreConfig('md_partialpayment/email/installment_schedule',$order->getStoreId());
            $bccConfig = Mage::getStoreConfig('md_partialpayment/email/installment_schedule_copy_to',$order->getStoreId());
            $bcc = ($bccConfig) ? explode(",",$bccConfig): array();
            $sendTo = array(
                    array(
                    'email' => $payments->getCustomerEmail(),
                    'name'  => $payments->getCustomerName()
                )
            );
            foreach ($sendTo as $recipient) {
                if(count($bcc) > 0){
                    foreach($bcc as $copyTo){
                        $mailTemplate->addBcc($copyTo); 
                    }
                }
                $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$order->getStoreId()))
                ->sendTransactional(
                    $template,
                    Mage::getStoreConfig('md_partialpayment/email/installment_schedule_from',$order->getStoreId()),
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'paidAmount' => $order->formatPrice($payments->getPaidAmount()),
                        'dueAmount' => $order->formatPrice($payments->getDueAmount()),
                        'productName' => $orderItem->getName(),
                        'billingAddress' => $order->getBillingAddress(),
                        'shippingAddress' => $order->getShippingAddress(),
                        'customerName' => $payments->getCustomerName(),
                        'customerEmail' => $payments->getCustomerEmail(),
                        'orderId'=>$order->getIncrementId(),
                        'payments'=>$payments
                    )
                );
            }
        }
    }
    
    public function isTermsEnabled()
    {
        return !is_null(Mage::getStoreConfig('md_partialpayment/general/terms'));
    }
    
    public function getTermsContents()
    {
        $termsId = Mage::getStoreConfig('md_partialpayment/general/terms');
        $data = array();
        if($termsId){
            $condition = Mage::getModel('checkout/agreement')->load($termsId);
            $data['link_title'] = $condition->getCheckboxText();
            $data['content'] = $condition->getContent();
        }
        return $data;
    }
    
    public function isAllowGroups(){
       
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $config = null;
        $isAllowed = false;
        $value = array();
        if(strlen(Mage::getStoreConfig("md_partialpayment/general/customer_groups"))){
            $config = (string)Mage::getStoreConfig("md_partialpayment/general/customer_groups");
                $value = explode(",",$config);
        }
        
        if(strlen($config) <= 0){
            $isAllowed = true;
        }elseif(count($value) < 0){
            $isAllowed = true;
        }elseif(in_array($customerGroupId,$value)){
            $isAllowed = true;
        }
        
        return $isAllowed;
    }
    
    public function isEnabledOnFrontend()
    {
        return (boolean)Mage::getStoreConfig('md_partialpayment/general/enabled');
    }
    
    public function shouldDisplayOtherPayments(Mage_Sales_Model_Order_Payment $orderPayment)
    {
        return (boolean)($orderPayment->getMethod() != Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE);
    }
}

