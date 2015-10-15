<?php
class Szokart_Crosssell_Model_Order_Invoice_Total_Crosssell
extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
		$order=$invoice->getOrder();
        $orderCrosssellTotal = $order->getCrosssellTotal();
        if ($orderCrosssellTotal&&count($order->getInvoiceCollection())==0) {
            $invoice->setGrandTotal($invoice->getGrandTotal()+$orderCrosssellTotal);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal()+$orderCrosssellTotal);
        }
        return $this;
    }
}