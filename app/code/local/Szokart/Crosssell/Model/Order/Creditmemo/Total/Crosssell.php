<?php
class Szokart_Crosssell_Model_Order_Creditmemo_Total_Crosssell 
extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {

		return $this;

        $order = $creditmemo->getOrder();
        $orderCrosssellTotal        = $order->getCrosssellTotal();

        if ($orderCrosssellTotal) {
			$creditmemo->setGrandTotal($creditmemo->getGrandTotal()+$orderCrosssellTotal);
			$creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal()+$orderCrosssellTotal);
        }

        return $this;
    }
}