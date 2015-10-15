<?php
class Szokart_Crosssell_Model_Quote_Address_Total_Crosssell
extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
     public function __construct()
    {
         $this -> setCode('crosssell_total');
         }


		 private function getCroCollection(){

		$product_ids = Mage::getModel('checkout/cart')->getProductIds(); //get cart product ids
		//$product_ids = array();
		//$items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
		//foreach($items as $item) { if(!in_array($item->getProductId(), $product_ids)){ $product_ids[] = $item->getProductId(); } }

		$tabpro= array();
		$crosssellAmount= NULL;

		$storeId = Mage::app()->getStore()->getId();
		//if($this->helper('customer')->isLoggedIn()) {
		$idgpc =   Mage::getSingleton('customer/session')->getCustomer()->getGroupId();
		//} else { $idgpc = 0;  }

		foreach($product_ids as $proid){

		$collection = Mage::getModel('crosssell/crosssell')->getCollection();

		$collection->addFieldToFilter('customer_group',array( array('finset' => $idgpc), array('eq' => 0), array('null'=> 1)));

		$collection->addFieldToFilter('stores',array( array('finset' => $storeId), array('null'=> 1), array('eq'=> 0)));

		$collection->addFieldToFilter('dfrom', array( array('lteq' =>date("Y-m-d")),array('null'=> 1)));
		$collection->addFieldToFilter('dto', array( array('gteq' =>date("Y-m-d")),array('null'=> 1)));

		$collection->addFieldToFilter('proid', array('eq' => $proid) );
		$collection->addFieldToFilter('status', array('eq' => 1) );


		foreach($collection as $rule){

		$collectionx = Mage::getModel('crosssell/crosssellx')->getCollection();
		$collectionx->getSelect()->where("cs_id=".$rule->getCsId());


		 foreach($collectionx as $pro){
			   //$tabpro[]= $pro->getProid();

			   if(in_array($pro->getProid(), $product_ids)){

				$productx = Mage::getModel('catalog/product')->getCollection()
				->addFinalPrice()
				->addAttributeToSelect('*')
				->addAttributeToFilter('entity_id', $pro->getProid())
				->setPageSize(1)
				->setCurPage(1);
				$_taxHelper = Mage::helper('tax');

				 foreach($productx as $pid){
					$cena = $pid->getPrice();

					$_store = $pid->getStore();
					$_convertedFinalPrice = $_store->roundPrice($_store->convertPrice($pid->getFinalPrice()));

					if(Mage::getStoreConfig('tax/display/type') == 1){
					$cena =	$_finalPrice = $_taxHelper->getPrice($pid, $_convertedFinalPrice);
					}else{
					$cena = $_taxHelper->getPrice($pid, $_convertedFinalPrice, true);
					}

					//if($pid->getSpecialPrice() > 0){ $cena = $pid->getSpecialPrice(); }
					//$cena = 75;
					$crosssellAmount = $crosssellAmount + (($rule->getLager()/100) * $cena);

				 }
			   }
		 }
		}}

		return $crosssellAmount;

		}

/////////////////////////////////////////////////////







    /**
     * Collect totals information about crosssell
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
     public function collect(Mage_Sales_Model_Quote_Address $address)
    {
         parent :: collect($address);
         $items = $this->_getAddressItems($address);
         if (!count($items)) {
            return $this;
         }
         $quote= $address->getQuote();
		 $crosssellAmount = NULL;

		//$crosssellAmount = $znizka[$proid];
        $crosssellAmount = $this->getCroCollection();
         //amount definition

		//if($crosssellAmount != ''){
		 $crosssellAmount = -$crosssellAmount;
         $crosssellAmount = $quote -> getStore() -> roundPrice($crosssellAmount);
         $this -> _setAmount($crosssellAmount) -> _setBaseAmount($crosssellAmount);
         $address->setData('crosssell_total',$crosssellAmount);
		//}

         return $this;
     }

    /**
     * Add crosssell totals information to address object
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping
     */
     public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
         parent :: fetch($address);
         $amount = $address -> getTotalAmount($this -> getCode());
         if ($amount != 0){
             $address -> addTotal(array(
                     'code' => $this -> getCode(),
                     'title' => $this -> getLabel(),
                     'value' => $amount
                    ));
         }

         return $this;
     }

    /**
     * Get label
     *
     * @return string
     */
     public function getLabel()
    {
         return Mage::helper('crosssell')->__('Cross Sell');
		 //return Mage::getStoreConfig('crosssellinfo/global/clabel');
    }
}