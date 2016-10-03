<?php
class Rkt_CrossSell_Block_Catalog_Product_View_Crosssell extends Mage_Checkout_Block_Cart_Crosssell
{

    /**
     * Get crosssell items
     *
     * @return array
     */
    public function getItems()
    {
        $items = $this->getData('items');
        if (is_null($items)) {
            $items = $this->getProduct()->getCrossSellProducts();
            $this->setData('items', $items);
        }
        return $items;
    }
}