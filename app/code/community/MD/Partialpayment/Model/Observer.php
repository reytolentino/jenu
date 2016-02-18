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
class MD_Partialpayment_Model_Observer
{
    public function addPartialpaymentTab(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        
        
        $id = $this->_getRequest()->getParam('id',null);
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs) {
            if(Mage::registry('current_product')){
                $product = Mage::registry('current_product');
                $type = $product->getTypeId();
            }
            else{
                $type = $this->_getRequest()->getParam('type',null);
            }
            if (!is_null($type) && $type != Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                $block->addTab('md_partialpayment_options', array(
                'label'     => Mage::helper('md_partialpayment')->__('Partial Payment Information'),
                'title'       => Mage::helper('md_partialpayment')->__('Partial Payment Information'),
                'content'     => $block->getLayout()->createBlock("md_partialpayment/adminhtml_catalog_product_edit_tab_partialpayment")->toHtml(),
            ));
            }
        }
    }
    public function savePartialPaymentOptions(Varien_Event_Observer $observer)
    {
        $databaseFields = array('status','initial_payment_amount','additional_payment_amount','installments','frequency_payment');
        $productId = $observer->getEvent()->getProduct()->getId();
        $storeId = $this->_getRequest()->getParam('store',0);
        $existingId = Mage::getModel('md_partialpayment/options')->getIdByInfo($productId,$storeId);
        $params = $this->_getRequest()->getPost('partialpayment');
        $options = array();
        $options['store_id'] = $storeId;
        $options['product_id'] = $productId;
        
        $options['status'] = (array_key_exists('status',$params)) ? $params['status']: NULL;
        $options['initial_payment_amount'] = (array_key_exists('initial_payment_amount',$params)) ? $params['initial_payment_amount']: NULL;
        $options['additional_payment_amount'] = (array_key_exists('additional_payment_amount',$params)) ? $params['additional_payment_amount']: NULL;
        $options['installments'] = (array_key_exists('installments',$params)) ? $params['installments']: NULL;
        $options['frequency_payment'] = (array_key_exists('frequency_payment',$params)) ? $params['frequency_payment']: NULL;
        $model = Mage::getModel('md_partialpayment/options');
        if(NULL === $options['status'] && 
           NULL === $options['initial_payment_amount'] && 
           NULL === $options['additional_payment_amount'] &&
           NULL === $options['installments'] && 
           NULL === $options['frequency_payment']){
                try{
                    if(!is_null($existingId) && $existingId > 0){
                        $model->load($existingId)->delete();
                    }
                }catch(Exception $e){
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }    
           }else{
                foreach($options as $key=>$value){
                    if(is_array($value)){
                        $model->setData($key,implode(",",$value));
                    }else{
                        $model->setData($key,$value);
                    }
                }
                try{
                    if(!is_null($existingId) && $existingId > 0){
                        $model->setId($existingId);
                    }
                    $model->save();
                }catch(Exception $e){
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
           }
        return $this;
    }
    
    public function deletePartialPaymentOptions(Varien_Event_Observer $observer)
    {
        $productId = $observer->getEvent()->getProduct()->getId();
        $collection = Mage::getModel('md_partialpayment/options')
                        ->getCollection()
                        ->addFieldToFilter('product_id',array('eq'=>$productId));
        
        if($collection->count() > 0){
            foreach($collection as $option)
            {
                try{
                    $option->setId($option->getId())->delete();
                }catch(Exception $e){
                    Mage::log($e->getMessage(),false,'partial-payment.log');
                }
            }
        }
        return $this;
    }
    protected function _getRequest() {
        return Mage::app()->getRequest();
    }
 
    public function setPartialpaymentOptions(Varien_Event_Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        
        if(!$quoteItem->getParentItemId()){
            
            $product = $observer->getEvent()->getProduct();
            $buyRequest = $quoteItem->getBuyRequest()->getData();
            $frequencyMap = array(
                'weekly'=>' +7 days',
                'quarterly'=>' +3 months',
                'monthly'=>' +1 month'
            );
   
            if(isset($buyRequest['custom_options']['partialpayment']) && $buyRequest['custom_options']['partialpayment'] == 1 && $product->getId() == $buyRequest['product']){
                $qty = 1;

                $partialPaymentOptions = Mage::getModel('md_partialpayment/options')->getStoreOptions($product);
                if($partialPaymentOptions){
                    $frequency = (!is_null($partialPaymentOptions->getFrequencyPayment())) ? $partialPaymentOptions->getFrequencyPayment() : Mage::getStoreConfig('md_partialpayment/general/frequency_of_payments');
                    $createdAt = date('Y-m-d',strtotime($quoteItem->getCreatedAt()));
                    $nextPaymentDate = date('Y-m-d',strtotime($createdAt.$frequencyMap[$frequency]));
                    $installmentSummary = Mage::getModel('md_partialpayment/options')->getInstallmentSummary($product, $partialPaymentOptions, $qty, $quoteItem->getPrice());
                    if(count($installmentSummary) > 0){
                        $quoteItem->setData('partialpayment_option_selected','1');
                        $quoteItem->setData('partialpayment_installment_count',$installmentSummary['installment_count']);
                        $quoteItem->setData('partialpayment_paid_amount',$installmentSummary['initial_payment_amount']);
                        $quoteItem->setData('partialpayment_due_amount',$installmentSummary['remaining_amount']);
                        $quoteItem->setData('partialpayment_frequency',$frequency);
                        $quoteItem->setData('partialpayment_amount_due_after_date',$installmentSummary['installment_amount']);
                        $quoteItem->setData('partialpayment_next_installment_date',$nextPaymentDate);
                        $quoteItem->getProduct()        
                        ->setSpecialPrice($installmentSummary['unit_payment']);
                        $quoteItem->setPrice($installmentSummary['unit_payment']);
                        $quoteItem->setBasePrice($installmentSummary['unit_payment']);
                        $quoteItem->setCustomPrice($installmentSummary['unit_payment']);
                        $quoteItem->setOriginalCustomPrice($installmentSummary['unit_payment']);
                        $quoteItem->getProduct()->setIsSuperMode(true);
                    }
                }
            }
        }
        return $this;
    }
    
    public function setCustomSubtotal(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $grandTotal = $order->getGrandTotal();
        $baseGrandTotal = $order->getBaseGrandTotal();
        $subtotal = $order->getSubtotal();
        $subtotalInclTax = $order->getSubtotalInclTax();
        $baseSubtotal = $order->getBaseSubtotal();
        $baseSubtotalInclTax = $order->getBaseSubtotalInclTax();
        $hasPartial = false;
        
        foreach($order->getAllVisibleItems() as $item){
            if($item->getPartialpaymentOptionSelected() == 1){
                $amount = $item->getPartialpaymentPaidAmount();/* - $item->getTaxAmount();*/
                $baseAmount = $item->getPartialpaymentPaidAmount();/* - $item->getBaseTaxAmount();*/
                $hasPartial = true;
                
                $subtotal -= $item->getRowTotal();
                $subtotalInclTax -= $item->getRowTotal();
                $baseSubtotal -= $item->getBaseRowTotal();
                $baseSubtotalInclTax -= $item->getBaseRowTotal();
                $grandTotal -= $item->getRowTotal();
                $baseGrandTotal -= $item->getBaseRowTotal();
                $subtotal += $amount;
                $subtotalInclTax += $amount;
                $baseSubtotal += $baseAmount;
                $baseSubtotalInclTax += $baseAmount;
                $grandTotal += $amount;
                $baseGrandTotal += $baseAmount;
                if($order->getPayment()->getMethod() == Mage_Paypal_Model_Config::METHOD_WPS){
                    Mage::dispatchEvent('md_partialpayment_order_item_payment_placed',array('order_item'=>$item,'forced_state'=>array()));
                }                
            }
        }
        if($hasPartial){
            $order->setSubtotal($subtotal);
            $order->getQuote()->setSubtotal($subtotal);
            $order->setBaseSubtotal($baseSubtotal);
            $order->getQuote()->setBaseSubtotal($baseSubtotal);
            $order->setSubtotalInclTax($subtotalInclTax);
            $order->getQuote()->setSubtotalInclTax($subtotalInclTax);
            $order->setBaseSubtotalInclTax($baseSubtotalInclTax);
            $order->getQuote()->setBaseSubtotalInclTax($baseSubtotalInclTax);
            $order->setGrandTotal($grandTotal);
            $order->getQuote()->setGrandTotal($grandTotal);
            $order->setBaseGrandTotal($baseGrandTotal);
            $order->getQuote()->setBaseGrandTotal($baseGrandTotal);
        }
        return $this;
    }
    
    public function resetTotalsForOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        
        if($order->getPayment()->getMethod() != Mage_Paypal_Model_Config::METHOD_WPS){
        $grandTotal = $order->getGrandTotal();
        $baseGrandTotal = $order->getBaseGrandTotal();
        $subtotal = $order->getSubtotal();
        $subtotalInclTax = $order->getSubtotalInclTax();
        $baseSubtotal = $order->getBaseSubtotal();
        $baseSubtotalInclTax = $order->getBaseSubtotalInclTax();
        $hasPartial = false;
        
        $totalDue = $order->getTotalDue();
        $baseTotalDue = $order->getBaseTotalDue();
        foreach($order->getAllVisibleItems() as $item){
            if($item->getPartialpaymentOptionSelected() == 1){
                $amount = $item->getPartialpaymentPaidAmount();/* - $item->getTaxAmount();*/
                $baseAmount = $item->getPartialpaymentPaidAmount();/* - $item->getBaseTaxAmount();*/
                $hasPartial = true;
                
                $subtotal -= $amount;
                $subtotalInclTax -= $amount;
                $baseSubtotal -= $baseAmount;
                $baseSubtotalInclTax -= $baseAmount;
                $grandTotal -= $amount;
                $baseGrandTotal -= $baseAmount;
                
                $subtotal += $item->getRowTotal();
                $subtotalInclTax += $item->getRowTotal();
                $baseSubtotal += $item->getBaseRowTotal();
                $baseSubtotalInclTax += $item->getBaseRowTotal();
                $grandTotal += $item->getRowTotal();
                $baseGrandTotal += $item->getBaseRowTotal();
                
                $totalDue += $amount;
                $baseTotalDue += $baseAmount;
                $order->getItemByQuoteItemId($item->getQuoteItemId())
                                ->setRowInvoiced($amount)
                                ->setBaseRowInvoiced($baseAmount);
                Mage::dispatchEvent('md_partialpayment_order_item_payment_placed',array('order_item'=>$item,'forced_state'=>array()));
            }
        }
        
        if($hasPartial){
            $order->setSubtotal($subtotal);
            $order->getQuote()->setSubtotal($subtotal);
            $order->setBaseSubtotal($baseSubtotal);
            $order->getQuote()->setBaseSubtotal($baseSubtotal);
            $order->setSubtotalInclTax($subtotalInclTax);
            $order->getQuote()->setSubtotalInclTax($subtotalInclTax);
            $order->setBaseSubtotalInclTax($baseSubtotalInclTax);
            $order->getQuote()->setBaseSubtotalInclTax($baseSubtotalInclTax);
            $order->setGrandTotal($grandTotal);
            $order->getQuote()->setGrandTotal($grandTotal);
            $order->setBaseGrandTotal($baseGrandTotal);
            $order->getQuote()->setBaseGrandTotal($baseGrandTotal);
            $order->setTotalDue($totalDue - $order->getShippingAmount());
            $order->setBaseTotalDue($baseTotalDue - $order->getBaseShippingAmount());
        }
        }
        return $this;
    }
    
    public function insertPaymentSummary(Varien_Event_Observer $observer)
    {
        $orderItem = $observer->getEvent()->getOrderItem();
        $forcedState = $observer->getEvent()->getForcedState();
        $order = $orderItem->getOrder();
        $payment = $order->getPayment();
        $paidAmount = ($payment->getMethodInstance()->isGateway()) ? $orderItem->getPartialpaymentPaidAmount(): 0;
        $dueAmount = ($payment->getMethodInstance()->isGateway()) ? $orderItem->getPartialpaymentDueAmount(): $orderItem->getPartialpaymentDueAmount() + $orderItem->getPartialpaymentPaidAmount();
        $paidInstallments = ($payment->getMethodInstance()->isGateway()) ? 1: 0;
        $installmentPayment = Mage::getModel('md_partialpayment/payments')
                                ->setData('order_id',$order->getRealOrderId())
                                ->setData('order_item_id',$orderItem->getId())
                                ->setData('store_id',$order->getStoreId())
                                ->setData('paid_amount',$paidAmount)
                                ->setData('due_amount',$dueAmount)
                                ->setData('customer_id',$order->getCustomerId())
                                ->setData('customer_name',$order->getCustomerFirstname().' '.$order->getCustomerLastname())
                                ->setData('customer_email',$order->getCustomerEmail())
                                ->setData('paid_installments',$paidInstallments)
                                ->setData('due_installments',$orderItem->getPartialpaymentInstallmentCount() - $paidInstallments)
                                ->setData('last_installment_date',date('Y-m-d',strtotime($orderItem->getCreatedAt())))
                                ->setData('next_installment_date',$orderItem->getPartialpaymentNextInstallmentDate())
                                ->setData('created_at',date('Y-m-d H:i:s'));
        try{
            $installmentPayment->save();
            $lastId = $installmentPayment->getId();
            
            $summaryData = Mage::helper('md_partialpayment')->getInstallmentSummary($orderItem);
            
            if(count($summaryData) > 0)
            {
                foreach($summaryData as $data)
                {
                    $data['payment_id'] = $lastId;
                    Mage::getModel('md_partialpayment/summary')
                                        ->setData($data)
                                        ->save();
                    
                }
            }
        Mage::dispatchEvent("md_partial_payment_summary_save_after",array('payments'=>$installmentPayment));    
        }catch(Exception $e){
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }
    }
    
    public function removePaymentMethods(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if($block instanceof Mage_Checkout_Block_Onepage_Payment_Methods){
            $quote = $block->getQuote();
            $isPartial = Mage::helper('md_partialpayment')->isQuotePartialPayment($quote);
            if($isPartial){
                $revisedMethods = array();
                foreach($block->getMethods() as $mthod){
                    if(Mage::helper('md_partialpayment')->isAllowedMethod($mthod->getCode())){
                        $revisedMethods[] = $mthod;
                    }
                }
                $block->setData('methods',$revisedMethods);
            }
        }
        return $this;
    }
    
    public function setPaypalActionItems(Varien_Event_Observer $observer)
    {
        
        if($observer->getEvent()->getControllerAction()->getFullActionName() == 'paypal_standard_success')
        {
            $quoteId = Mage::getSingleton('checkout/session')->getPaypalStandardQuoteId(true);
            $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            Mage::dispatchEvent("paypal_redirect_action_after",array("order_id"=>$orderId,"quote_id"=>$quoteId,"paypal_action"=>"success"));
        }elseif($observer->getEvent()->getControllerAction()->getFullActionName() == 'paypal_standard_cancel'){
            $quoteId = Mage::getSingleton('checkout/session')->getPaypalStandardQuoteId(true);
            $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            Mage::dispatchEvent("paypal_redirect_action_after",array("order_id"=>$orderId,"quote_id"=>$quoteId,"paypal_action"=>"cancel"));
        }elseif($observer->getEvent()->getControllerAction()->getFullActionName() == 'paypal_ipn_index'){
            Mage::dispatchEvent("paypal_first_ipn_received_after",array("request"=>$observer->getControllerAction()->getRequest()));
        }
        return $this;
    }
    
    public function insertPartialPaymentDetailsByAction(Varien_Event_Observer $observer)
    {
        $quoteId = $observer->getEvent()->getQuoteId();
        $orderId = $observer->getEvent()->getOrderId();
        $action = $observer->getEvent()->getPaypalAction();
        
        if($orderId){
            $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
            if($action == "success"){ 
                foreach($order->getAllVisibleItems() as $item){
                    if($item->getPartialpaymentOptionSelected() == 1){
                        $existsPayments = Mage::getModel('md_partialpayment/payments')->getPaymentsByOrderItem($item);
                        if(!$existsPayments){
                            Mage::dispatchEvent('md_partialpayment_order_item_payment_placed',array('order_item'=>$item,'forced_state'=>array()));
                        }
                    }
                }
            }else{
                foreach($order->getAllVisibleItems() as $item){
                    $payments = Mage::getModel('md_partialpayment/payments')->getPaymentsByOrderItem($item);
                    if($payments){
                        $payments->setId($payments->getId())->delete();
                    }
                }
            }
        }
        return $this;
    }
    
    public function sendInstallmentReminderEmail()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $writeConnection = $resource->getConnection('core_write');
        $days = Mage::getStoreConfig('md_partialpayment/email/remind_days_before');
        $table = $resource->getTableName('md_partialpayment/summary');
        
        $query = "SELECT e.summary_id  FROM `".$table."` as e WHERE DATEDIFF(e.due_date, now()) = '".$days."' AND e.status NOT IN ('".MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS."')";
        $summaryIds = $readConnection->fetchCol($query);
        if(count($summaryIds) > 0){
            Mage::helper('md_partialpayment')->sendReminderEmail($summaryIds);
        }
        
       return $this;
    }
    
    public function sendInstallmentSummaryEmail(Varien_Event_Observer $observer)
    {
        $payments = $observer->getEvent()->getPayments();
        Mage::helper('md_partialpayment')->sendPaymentScheduleEmail($payments);
        return $this;
    }
    
    public function saveFirstInstallmentStatus(Varien_Event_Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        if (!$request->isPost()) {
            return;
        }
        $data = $request->getPost();
        Mage::getModel('md_partialpayment/payment_paypal_standard')->processIpnRequest($data);
    }
    
    public function calculatePartialItemsToInvoice(Varien_Event_Observer $observer)
    {
        
        $invoice = $observer->getEvent()->getInvoice();
        if((!$invoice->getOrder()->getPayment()->getMethodInstance()->isGateway() && $invoice->getOrder()->getPayment()->getMethod() != Mage_Paypal_Model_Config::METHOD_WPS) || $invoice->getRequestedCaptureCase() == $invoice::CAPTURE_OFFLINE){
        $items = $invoice->getAllItems();
        
        $grandTotal = $invoice->getOrder()->getGrandTotal();
        $baseGrandTotal = $invoice->getOrder()->getBaseGrandTotal();
        
        $subtotal = $invoice->getOrder()->getSubtotal();
        $baseSubtotal = $invoice->getOrder()->getBaseSubtotal();
        
        $subtotalInclTax = $invoice->getOrder()->getSubtotalInclTax();
        $baseSubtotalInclTax = $invoice->getOrder()->getBaseSubtotalInclTax();
        
        $totalDue = $invoice->getOrder()->getGrandTotal();
        $baseTotalDue = $invoice->getOrder()->getBaseGrandTotal();
        
        foreach($items as $item){
            $orderItem = $item->getOrderItem();
            
            if($orderItem->getPartialpaymentOptionSelected() == 1){
                $payments = Mage::getModel('md_partialpayment/payments')->getPaymentsByOrderItem($orderItem);
                $summaryStatusProcessing = $payments->getPaymentSummaryCollection()->getFirstItem();
                
                $amount = ($item->getQty() > 0) ? $orderItem->getPartialpaymentPaidAmount() : 0;/* - $orderItem->getTaxAmount();*/
                $baseAmount = ($item->getQty() > 0) ? $orderItem->getPartialpaymentPaidAmount() : 0;/* - $orderItem->getBaseTaxAmount();*/
                
                    $totalDue -= $orderItem->getRowTotal();
                    $baseTotalDue -= $orderItem->getBaseRowTotal();
                    
                $grandTotal -= $orderItem->getRowTotal();
                $baseGrandTotal -= $orderItem->getBaseRowTotal();
                
                $subtotal -= $orderItem->getRowTotal();
                $baseSubtotal -= $orderItem->getBaseRowTotal();
                
                $subtotalInclTax -= $orderItem->getRowTotal();
                $baseSubtotalInclTax -= $orderItem->getBaseRowTotal();
                
                $totalDue += $amount;
                $baseTotalDue += $baseAmount;
                
                $grandTotal += $amount;
                $baseGrandTotal += $baseAmount;
                
                $subtotal += $amount;
                $baseSubtotal += $baseAmount;
                
                $subtotalInclTax += $amount;
                $baseSubtotalInclTax += $baseAmount;
                
                if($invoice->getState() == $invoice::STATE_PAID && !is_null($payments)){
                    $payments->setPaidAmount($payments->getPaidAmount() + $summaryStatusProcessing->getAmount())
                              ->setDueAmount($payments->getDueAmount() - $summaryStatusProcessing->getAmount())
                              ->setPaidInstallments($payments->getPaidInstallments() + 1)
                              ->setDueInstallments($payments->getDueInstallments() - 1);
                    
                    $summaryStatusProcessing->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS);
                    
                    $transaction = Mage::getModel('core/resource_transaction');
                    $transaction->addObject($summaryStatusProcessing);
                    $transaction->addObject($payments);
                    try{
                        $transaction->save();
                        Mage::helper('md_partialpayment')->sendPaymentScheduleEmail($payments);
                    }catch(Exception $e){
                        Mage::getSingleton('core/session')->addError($e->getMessage());
                    }
                    
                }
            }
        }
        
        $invoice->setSubtotal($subtotal);
        $invoice->setBaseSubtotal($baseSubtotal);
        $invoice->setSubtotalInclTax($subtotalInclTax);
        $invoice->setBaseSubtotalInclTax($baseSubtotalInclTax);
        $invoice->setGrandTotal($grandTotal);
        $invoice->setBaseGrandTotal($baseGrandTotal);
        
        $invoice->getOrder()->setTotalPaid(max(0,$totalDue));
        $invoice->getOrder()->setBaseTotalPaid(max(0,$baseTotalDue));
        }elseif($invoice->getOrder()->getPayment()->getMethod() == Mage_Paypal_Model_Config::METHOD_WPS){
			
		}
        return $this;
    }
	
	public function resetOrderTotalForPaypal(Varien_Event_Observer $observer){
		$invoice = $observer->getEvent()->getInvoice();
		$order = $observer->getEvent()->getOrder();
		if($order->getPayment()->getMethod() == Mage_Paypal_Model_Config::METHOD_WPS){
			$grandTotal = $order->getGrandTotal();
			$baseGrandTotal = $order->getBaseGrandTotal();
			$subtotal = $order->getSubtotal();
			$subtotalInclTax = $order->getSubtotalInclTax();
			$baseSubtotal = $order->getBaseSubtotal();
			$baseSubtotalInclTax = $order->getBaseSubtotalInclTax();
			
			$totalDue = $order->getTotalDue();
			$baseTotalDue = $order->getBaseTotalDue();
			
			foreach($order->getAllVisibleItems() as $item){
				if($item->getPartialpaymentOptionSelected() == 1){
					$amount = $item->getPartialpaymentDueAmount();/* - $item->getTaxAmount();*/
					
					$subtotal += $amount;
					$subtotalInclTax += $amount;
					$baseSubtotal += $amount;
					$baseSubtotalInclTax += $amount;
					$grandTotal += $amount;
					$baseGrandTotal += $amount;
                
					$totalDue += $amount;
					$baseTotalDue += $amount;
				}
			}
			
		$order->setSubtotal($subtotal);
        $order->setBaseSubtotal($baseSubtotal);
        $order->setSubtotalInclTax($subtotalInclTax);
        $order->setBaseSubtotalInclTax($baseSubtotalInclTax);
        $order->setGrandTotal($grandTotal);
        $order->setBaseGrandTotal($baseGrandTotal);
        $order->setTotalDue($totalDue - $order->getShippingAmount());
        $order->setBaseTotalDue($baseTotalDue - $order->getBaseShippingAmount());
		}
		return $this;
	}
    
    public function setUpdatedSubtotalPaypal(Varien_Event_Observer $observer)
    {
        $paypalCart = $observer->getEvent()->getPaypalCart();
        $entity = $paypalCart->getSalesEntity();
        $baseSubtotal = $entity->getBaseSubtotal();
        $baseGrandTotal = $entity->getBaseGrandTotal();
        $calculatedBaseAmount = 0;
        
        foreach($paypalCart->getItems() as $paypalItem){
            if($paypalItem->getPartialpaymentOptionSelected() == 1){
                
                $baseAmount = $paypalItem->getPartialpaymentPaidAmount();/* - $paypalItem->getBaseTaxAmount();*/

                $calculatedBaseAmount += $paypalItem->getBaseRowTotal();
                
                $calculatedBaseAmount -= $baseAmount;
                $paypalCart->removeItem($paypalItem->getSku());
                if ($entity instanceof Mage_Sales_Model_Order) {
                    $qty = (int) $paypalItem->getQtyOrdered();
                    $amount = (float) $baseAmount;
                    // TODO: nominal item for order
                } else {
                    $qty = (int) $paypalItem->getTotalQty();
                    $amount = $paypalItem->isNominal() ? 0 : (float) $baseAmount;
                }
                $paypalCart->addItem($paypalItem->getName(), $qty, $amount, $paypalItem->getSku());
                
            }
        }
        $baseGrandTotal -= $calculatedBaseAmount;
        $entity->setBaseGrandTotal($baseGrandTotal);
        $paypalCart->updateTotal($paypalCart::TOTAL_SUBTOTAL,-$calculatedBaseAmount);
        return $this;
    }
    
    public function removePartialpaymentOptions(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        
        $collection = Mage::getModel('md_partialpayment/options')
                            ->getCollection()
                            ->addFieldToFilter('product_id',array('eq'=>$product->getId()));
        
        foreach($collection as $option){
            $option->setId($option->getId())->delete();
        }
        return $this;
    }
    
    public function setCustomSubtotalForBundleProduct(Varien_Event_Observer $observer)
    {
        $subtotalDelta = 0;
        $baseSubtotalDelta = 0;
        $quote = $observer->getEvent()->getQuote();
        $isBundleProductExists = false;
        foreach($quote->getAllItems() as $item){
            if($item->getPartialpaymentOptionSelected() == 1){
                if($item->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
                    if(!$isBundleProductExists){
                        $isBundleProductExists = true;
                    }
                    $product = $item->getProduct();

                    $partialPaymentOptions = Mage::getModel('md_partialpayment/options')->getStoreOptions($product);
                    if($partialPaymentOptions){
                        $installmentSummary = Mage::getModel('md_partialpayment/options')->getInstallmentSummary($product, $partialPaymentOptions, $item->getQty(), $item->getPrice());
                    }
                    $subtotalDelta += max(0,$installmentSummary['additional_payment_amount']);
                    $baseSubtotalDelta += max(0,$installmentSummary['additional_payment_amount']);
                    
                                        $item->setRowTotal($item->getRowTotal() + $installmentSummary['additional_payment_amount'])
                                        ->setBaseRowTotal($item->getBaseRowTotal() + $installmentSummary['additional_payment_amount'])
                                        ->setRowTotalInclTax($item->getRowTotalInclTax() + $installmentSummary['additional_payment_amount'])
                                        ->setBaseRowTotalInclTax($item->getBaseRowTotalInclTax() + $installmentSummary['additional_payment_amount'])
                                        ->setRowTotalWithDiscount($item->getRowTotalWithDiscount() + $installmentSummary['additional_payment_amount'])
                                        ->setBaseRowTotalWithDiscount($item->getBaseRowTotalWithDiscount() + $installmentSummary['additional_payment_amount']);
                }
            }
        }
        if($isBundleProductExists){
            if($quote->isVirtual()){
                $quote->getBillingAddress()
                            ->setSubtotal($quote->getBillingAddress()->getSubtotal() + $subtotalDelta)
                            ->setBaseSubtotal($quote->getBillingAddress()->getBaseSubtotal() + $baseSubtotalDelta)
                            ->setGrandTotal($quote->getBillingAddress()->getGrandTotal() + $subtotalDelta)
                            ->setBaseGrandTotal($quote->getBillingAddress()->getBaseGrandTotal() + $baseSubtotalDelta)
                            ->setSubtotalInclTax($quote->getBillingAddress()->getSubtotalInclTax() + $subtotalDelta)
                            ->setBaseSubtotalIncltax($quote->getBillingAddress()->getBaseSubtotalIncltax() + $baseSubtotalDelta);
            }else{
                $quote->getShippingAddress()
                        ->setSubtotal($quote->getShippingAddress()->getSubtotal() + $subtotalDelta)
                        ->setBaseSubtotal($quote->getShippingAddress()->getBaseSubtotal() + $baseSubtotalDelta)
                        ->setGrandTotal($quote->getShippingAddress()->getGrandTotal() + $subtotalDelta)
                            ->setBaseGrandTotal($quote->getShippingAddress()->getBaseGrandTotal() + $baseSubtotalDelta)
                            ->setSubtotalInclTax($quote->getShippingAddress()->getSubtotalInclTax() + $subtotalDelta)
                            ->setBaseSubtotalIncltax($quote->getShippingAddress()->getBaseSubtotalIncltax() + $baseSubtotalDelta);
            }
            $quote->setSubtotal($quote->getSubtotal() + $subtotalDelta);
            $quote->setBaseSubtotal($quote->getBaseSubtotal() + $baseSubtotalDelta);
            $quote->setSubtotalWithDiscount($quote->getSubtotalWithDiscount() + $subtotalDelta);
            $quote->setBaseSubtotalWithDiscount($quote->getBaseSubtotalWithDiscount() + $baseSubtotalDelta);
            $quote->setGrandTotal($quote->getGrandTotal() + $subtotalDelta);
            $quote->setBaseGrandTotal($quote->getBaseGrandTotal() + $baseSubtotalDelta);
        }
        return $this;
    }
    
    public function captureAuthorizeCimPayment(Varien_Event_Observer $observer)
    {
        $adapter = Mage::getSingleton('core/resource');
        $gorillaHelper = Mage::helper('authorizenetcim');
        $gateway = Mage::getSingleton('authorizenetcim/gateway');
        $summatyTable = $adapter->getTableName('md_partialpayment/summary');
        $partialPaymentTable = $adapter->getTableName('md_partialpayment/payments');
        $orderTable = $adapter->getTableName('sales/order');
        $paymentTable = $adapter->getTableName('sales/order_payment');
      
        $readAdapter = $adapter->getConnection('core_read');
        $writeAdapter = $adapter->getConnection('core_write');
        
        $query = "SELECT e.*,p.order_id,o.increment_id,op.authorizenetcim_customer_id,op.authorizenetcim_payment_id FROM `".$summatyTable."` as `e` LEFT JOIN `".$partialPaymentTable."` AS `p` ON `e`.payment_id=`p`.payment_id LEFT JOIN `".$orderTable."` AS `o` ON `p`.order_id=`o`.increment_id LEFT JOIN `".$paymentTable."` AS `op` ON `o`.entity_id=`op`.parent_id  WHERE DATEDIFF(e.due_date,now()) <= 0 AND `e`.status NOT IN (".MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS.",".MD_Partialpayment_Model_Summary::PAYMENT_PROCESS.") AND `op`.method='".Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE."'";
        
        $queryResult = $readAdapter->fetchAll($query);
        
        if(is_array($queryResult) && count($queryResult) > 0)
        {
            foreach($queryResult as $_result){
                
                $responseBody = false;
                if(!is_null($_result['authorizenetcim_customer_id']) && strlen($_result['authorizenetcim_customer_id']) > 0 && !is_null($_result['authorizenetcim_payment_id']) && strlen($_result['authorizenetcim_payment_id']))
                {
                    $isTestMode = (boolean)$gateway->getConfigData('test',$_result['store_id']);
                    $apiLoginId = ($isTestMode) ? $gateway->getConfigData('test_login',$_result['store_id']): $gateway->getConfigData('login',$_result['store_id']);
                    $transactionKey = ($isTestMode) ? $gateway->getConfigData('test_trans_key',$_result['store_id']): $gateway->getConfigData('trans_key',$_result['store_id']);
                    $wsdlUrl = ($isTestMode) ? $gateway->getConfigData('test_gateway_wsdl',$_result['store_id']): $gateway->getConfigData('gateway_wsdl',$_result['store_id']);
                    $gatewayUrl = ($isTestMode) ? $gateway->getConfigData('test_gateway_url',$_result['store_id']): $gateway->getConfigData('gateway_url',$_result['store_id']);
                    $paymentAction = $gateway->getConfigData('payment_action',$_result['store_id']);
                    $anetTransType = ($paymentAction == Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE) ? Gorilla_AuthorizenetCim_Model_Profile::TRANS_AUTH_ONLY: Gorilla_AuthorizenetCim_Model_Profile::TRANS_AUTH_CAPTURE;
 
                    $soap_env = array(
                    Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_TRANS => array(
                        'merchantAuthentication' => array(
                            'name' => $apiLoginId,
                            'transactionKey' => $transactionKey
                        ),
                        'transaction' => array(
                            $anetTransType => array(
                                'amount' => $_result['amount'],
                                'tax'=>array(
                                    'amount' => 0
                                ),
                                'shipping'=>array(
                                    'amount' => 0  
                                ),
                                'customerProfileId' => $_result['authorizenetcim_customer_id'],
                                'customerPaymentProfileId' => $_result['authorizenetcim_payment_id'],
                                'order' => array(
                                    'invoiceNumber' => $_result['increment_id'].'Partial Summary Id: '.$_result['summary_id']
                                )
                            )
                        ),
                        'extraOptions' => 'x_delim_char='.  Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_DELIM_CHAR . '&x_duplicate_window=' . $gateway->getConfigData('transaction_timeout',$_result['store_id']),
                        'x_duplicate_window' => $gateway->getConfigData('transaction_timeout',$_result['store_id'])
                    )
                    );
                    try{
                        
                        $directResponse = Mage::getSingleton('authorizenetcim/profile')->doCall(Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_TRANS, $soap_env);
                        $responseBody = $directResponse->CreateCustomerProfileTransactionResult->directResponse;
                        
                    }catch(Exception $e){
                        $responseBody = false;
                        echo $e->getMessage().'<br />';
                    }
                    
                
                if($responseBody){
                    $r = explode(Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_DELIM_CHAR, $responseBody);
                    if ($r) {
                        $summary = Mage::getModel('md_partialpayment/summary')->load($_result['summary_id']);
                        $payments = $summary->getPayments();
                        $order = $payments->getOrder();
                        $text = '';
                        $result = Mage::getModel('authorizenetcim/gateway_result');
                        $result->setResponseCode((int)str_replace('"','',$r[0]))
                               ->setResponseSubcode((int)str_replace('"','',$r[1]))
                                ->setResponseReasonCode((int)str_replace('"','',$r[2]))
                                ->setResponseReasonText($r[3])->setApprovalCode($r[4])->setAvsResultCode($r[5])
                                ->setTransactionId($r[6])->setInvoiceNumber($r[7])->setDescription($r[8])
                                ->setAmount($r[9])->setMethod($r[10])->setTransactionType($r[11])
                                ->setCustomerId($r[12])->setMd5Hash($r[37])->setCardCodeResponseCode($r[38])
                                ->setCAVVResponseCode( (isset($r[39])) ? $r[39] : null)->setSplitTenderId($r[52])
                                ->setAccNumber($r[50])->setCardType($r[51])->setRequestedAmount($r[53])
                                ->setBalanceOnCard($r[54])->setCcLast4(substr($r[50], -4));
                        
                        
                        switch ($result->getResponseCode()) {
                             case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_APPROVED:
                                     $text = $gorillaHelper->__('successful');
                                     $summary->setPaidDate(date('Y-m-d'))
                                        ->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS)
                                        ->setTransactionId($result->getTransactionId())
                                        ->setPaymentMethod(Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE)
                                        ->setPaymentFailCount($summary->getPaymentFailCount() + 0)
                                        ->setTransactionDetails(serialize($result->getData()));
                                 
                                     $payments->setPaidAmount($payments->getPaidAmount() + $result->getAmount())
                                        ->setDueAmount(max(0,($payments->getDueAmount() - $result->getAmount())))
                                        ->setLastInstallmentDate(date('Y-m-d'))
                                        ->setPaidInstallments($payments->getPaidInstallments() + 1)
                                        ->setDueInstallments(max(0,($payments->getDueInstallments() - 1)))
                                        ->setUpdatedAt(date('Y-m-d H:i:s'));
                                     
                                    $order->setTotalPaid($order->getTotalPaid() + $result->getAmount())
                                        ->setBaseTotalPaid($order->getBaseTotalPaid() + $result->getAmount())
                                        ->setTotalDue(max(0,($order->getTotalDue() - $result->getAmount())))
                                        ->setBaseTotalDue(max(0,($order->getBaseTotalDue() - $result->getAmount())));
                                     
                                     break;
                             case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_DECLINED:
                             case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_ERROR:
                                 $text = $gorillaHelper->__('failed');
                                 $summary->setPaidDate(date('Y-m-d'))
                                        ->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_FAIL)
                                        ->setTransactionId($result->getTransactionId())
                                        ->setPaymentMethod(Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE)
                                        ->setPaymentFailCount($summary->getPaymentFailCount() + 1)
                                        ->setTransactionDetails(serialize($result->getData()));
                                 break;
                             default:
                                 break;
                        }
                        
                        if(strlen($text) > 0){
                            
                            $operation = ($paymentAction == Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE) ? 'authorize': 'authorize and capture';
                            $amount = $gorillaHelper->__('amount %s',$order->formatPrice($result->getAmount()));
                            $card = $gorillaHelper->__('Credit Card: xxxx-%s', $result->getCcLast4());
                            $transactionString = $gorillaHelper->__('Authorize.Net CIM Transaction ID %s', $result->getTransactionId());
                            $statusHistryText = $gorillaHelper->__('%s %s %s - %s. %s. %s', $card, strip_tags($amount), $operation, $text, $transactionString, $result->getResponseReasonText());
                            $order->addStatusHistoryComment($statusHistryText);
                            $transaction = Mage::getModel('core/resource_transaction');
                            $transaction->addObject($summary);
                            $transaction->addObject($payments);
                            $transaction->addObject($order);
                            try{
                                $transaction->save();
                                $summary->sendStatusPaymentEmail(true,false);
                            }catch(Exception $e){
                                Mage::getSingleton('core/session')->addError($e->getMessage());
                            }
                            
                        }
                        
                    }
                }
                }
            }
        }
        
        return $this;
    }

    public function appendFullCartPaymentBlock(Varien_Event_Observer $observer) 
    {
        /*$controller = Mage::app()->getRequest()->getControllerName();
        $router = Mage::app()->getRequest()->getRouteName();
        $action = Mage::app()->getRequest()->getActionName();*/
        $block = $observer->getEvent()->getBlock();
        
        if ($block instanceof Mage_Paypal_Block_Express_Shortcut || $block instanceof Amazon_Payments_Block_Button
            || $block instanceof Mage_Paypal_Block_Bml_Banners || $block instanceof Affirm_Affirm_Block_Button) {
            $quote = Mage::getSingleton("checkout/session")->getQuote();
            $hasPartial = false;
            if ($quote) {
                $hasPartial = Mage::helper("md_partialpayment")->isQuotePartialPayment($quote);
            }

            if ($hasPartial) {
                $transportObject = $observer->getEvent()->getTransport();
                $transportObject->setHtml("");
            }
        }
        return $this;
    }
    
}

