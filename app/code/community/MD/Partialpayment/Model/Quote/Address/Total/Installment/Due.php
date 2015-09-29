<?php
class MD_Partialpayment_Model_Quote_Address_Total_Installment_Due extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        //parent::collect($address);
        $totalDueAmount = 0;

        
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
                    $totalDueAmount += $quoteItem->getPartialpaymentDueAmount() * $quoteItem->getQty();
                    $isPartialExists = true;
                }
            }
        }
        if($isPartialExists){
            $address->setPartialpaymentDueAmount($totalDueAmount);
        }else{
            $address->setPartialpaymentDueAmount(0);
        }
        return $this;
    }
    
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amount = $address->getPartialpaymentDueAmount();
        if($amount != 0){
            $address->addTotal(array(
                'code'  => 'md_partialpayment_due',
                'title' => Mage::helper('md_partialpayment')->__('Amount to be paid later'),
                'value' => $amount,
                'area' => 'footer'
            ));
        }
        return $this;
    }
}

