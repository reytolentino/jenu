<?php
class MD_Partialpayment_Model_Payment_Checkmo extends MD_Partialpayment_Model_Payment_Abstract
{
    public function pay($details = null)
    {
        $area = ($this->getPaymentRequestArea() == 'adminhtml_') ? 'adminhtml': 'core';
        $summary = $this->getSummary();
        
        $summary->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_PROCESS);
        $summary->setPaymentMethod($details['method']);
        $summary->setPaidDate(date('Y-m-d'));
        try{
            $summary->setId($summary->getId())->save();
            Mage::getSingleton($area.'/session')->addSuccess(Mage::helper('md_partialpayment')->__('Your Payment Has Been Submitted for review.'));
        }catch(Exception $e){
            Mage::getSingleton($area.'/session')->addError($e->getMessage());
        }
    } 
    public function getDetails()
    {
        return '';
    }
    
    public function getResponseText()
    {
        return '';
    }
}

