<?php
class  MD_Partialpayment_Block_Cart_Totals extends Mage_Checkout_Block_Cart_Totals
{

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $totalPaidAmount = 0;
        $baseTotalPaidAmount = 0;

        $items = $address->getAllItems();
        $isPartialExists = false;
        foreach ($items as $item) {
            if ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
                $quoteItem = $item->getAddress()->getQuote()->getItemById($item->getQuoteItemId());
            }
            else {
                $quoteItem = $item;
            }
            if (!$quoteItem->getParentItem()) {
                if($quoteItem->getPartialpaymentOptionSelected() == 1){
                    $isPartialExists = true;
                    $totalPaidAmount += $quoteItem->getPartialpaymentPaidAmount();
                    $baseTotalPaidAmount += $quoteItem->getPartialpaymentPaidAmount();
                }else{
                    $totalPaidAmount += $quoteItem->getRowTotal();
                    $baseTotalPaidAmount += $quoteItem->getBaseRowTotal();
                }
            }
        }
        if($isPartialExists){
            $address->setPartialpaymentPaidAmount($totalPaidAmount + $address->getShippingAmount() + $address->getTaxAmount());
        }else{
            $address->setPartialpaymentPaidAmount(0);
        }
        return $this;
    }

    public function renderTotals($area = null, $colspan = 1)
    {
        return $this->_replaceLabels(parent::renderTotals($area, $colspan));
    }

    protected function _replaceLabels($html){
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $items = $cart->getAllItems();
        $isPartialExists = false;
        foreach ($items as $item) {
            if ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
                $quoteItem = $item->getAddress()->getQuote()->getItemById($item->getQuoteItemId());
            }
            else {
                $quoteItem = $item;
            }
            if (!$quoteItem->getParentItem()) {
                if($quoteItem->getPartialpaymentOptionSelected() == 1){
                    $isPartialExists = true;
                }
            }
        }
        $labelMap = array();
        if($isPartialExists) {
            $labelMap['Tax'] = "Tax (you will be charged this amount today)";
        }
        foreach($labelMap as $key => $value){
            $html = str_replace($key, $value,$html) ;
        }
        return $html;
    }
}

