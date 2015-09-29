<?php
class MD_Partialpayment_Model_Quote_Address_Total_Installment_Paid extends Mage_Sales_Model_Quote_Address_Total_Abstract
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
                    $totalPaidAmount += $quoteItem->getPartialpaymentPaidAmount() * $quoteItem->getQty();
                    $baseTotalPaidAmount += $quoteItem->getPartialpaymentPaidAmount() * $quoteItem->getQty();
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
    
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amount = $address->getPartialpaymentPaidAmount();
        if($amount != 0){
            $address->addTotal(array(
                'code'  => 'md_partialpayment_paid',
                'title' => Mage::helper('md_partialpayment')->__('PORTION YOU PAY TODAY'),
                'value' => $amount,
                'area' => 'footer'
            ));
        }
        return $this;
    }
}

