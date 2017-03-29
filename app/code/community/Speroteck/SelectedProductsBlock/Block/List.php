<?php
/**
 *
 * Selected products
 *
 * @category    Speroteck
 * @package     Speroteck_SelectedProductsBlock
 * @licence
 *
 */

/**
 * Class Speroteck_SelectedProductsBlock_Block_List
 *
 * @method integer getProductsLimit()
 * @method string getSelectedProducts()
 * @method string getBlockName()
 * @method string getUniqueId()
 *
 */
class Speroteck_SelectedProductsBlock_Block_List extends Mage_Catalog_Block_Product_List
        implements Mage_Widget_Block_Interface
{
    /**
     * Return products collection
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     *
     */
    public function getProductCollection()
    {
        $skuList = $this->_filterSkuList($this->getSelectedProducts());

        /** @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents();
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        $collection->getSelect()->limit($this->getProductsLimit());
        $collection->getSelect()->where('e.sku IN(?)', $skuList);

        return $collection;
    }

    /**
     *
     * @param string $skuList
     *
     * @return Array
     */
    protected function _filterSkuList($skuList)
    {
        $result = array();
        foreach (explode(',', $skuList) as $sku) {
            $result[] = trim($sku);
        }

        return $result;
    }
}