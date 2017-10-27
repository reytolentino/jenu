<?php

/**
 * @category   BusinessKing
 * @package    BusinessKing_PaymentCharge
 */
class BusinessKing_PaymentCharge_Model_Sales_Quote_Address_Total_Paymentcharge extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function __construct()
    {
        $this->setCode('payment_charge');
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {

        $productId = 205;
        $productId2 = 206;
        $productId3 = 207;
        $productId4 = 208;
        $productId5 = 209;
        $productId6 = 210;
        $productId7 = 212;
        $productId8 = 213;
        $productId9 = 214;
        $productId10 = 215;
        $productId11 = 216;
        $productId12 = 217;
        $productId13 = 222;
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $grandTotal = Mage::getModel('checkout/session')->getQuote()->getGrandTotal();
        if (($quote->hasProductId($productId) || $quote->hasProductId($productId2) || $quote->hasProductId($productId3) || $quote->hasProductId($productId4) || $quote->hasProductId($productId5) || $quote->hasProductId($productId6) && $grandTotal < 100 || $quote->hasProductId($productId7) || $quote->hasProductId($productId8) || $quote->hasProductId($productId9) || $quote->hasProductId($productId10) || $quote->hasProductId($productId11) || $quote->hasProductId($productId12)) && $grandTotal < 100) {

            // Product is not in the shopping cart so
            // enable service charge
            $address->setPaymentCharge(0);
            $address->setBasePaymentCharge(0);

            $items = $address->getAllItems();
            if (!count($items)) {
                return $this;
            }

            $paymentMethod = $address->getQuote()->getPayment()->getMethod();
            if ($paymentMethod) {
                $amount = Mage::helper('paymentcharge')->getPaymentCharge($paymentMethod, $address->getQuote());
                $address->setPaymentCharge($amount);
                $address->setBasePaymentCharge($amount);
            }

            $address->setGrandTotal($address->getGrandTotal() + $address->getPaymentCharge());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBasePaymentCharge());

            return $this;
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $productId = 205;
        $productId2 = 206;
        $productId3 = 207;
        $productId4 = 208;
        $productId5 = 209;
        $productId6 = 210;
        $productId7 = 212;
        $productId8 = 213;
        $productId9 = 214;
        $productId10 = 215;
        $productId11 = 216;
        $productId12 = 217;
        $productId13 = 222;
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $grandTotal = Mage::getModel('checkout/session')->getQuote()->getGrandTotal();
        if (($quote->hasProductId($productId) || $quote->hasProductId($productId2) || $quote->hasProductId($productId3) || $quote->hasProductId($productId4) || $quote->hasProductId($productId5) || $quote->hasProductId($productId6) && $grandTotal < 100 || $quote->hasProductId($productId7) || $quote->hasProductId($productId8) || $quote->hasProductId($productId9) || $quote->hasProductId($productId10) || $quote->hasProductId($productId11) || $quote->hasProductId($productId12)) && $grandTotal < 100) {

            $amount = $address->getPaymentCharge();
            if (($amount!=0)) {
                $address->addTotal(array(
                    'code' => $this->getCode(),
                    'title' => Mage::helper('sales')->__('Affirm Service Charge'),
                    'full_info' => array(),
                    'value' => $amount
                ));
            }
            return $this;

        }
    }
}