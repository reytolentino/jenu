<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Controller_Action
{
	
public function masscsaddAction() 
{
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
		$danex     = (string)$this->getRequest()->getParam('crossx');

        try {
		Mage::getSingleton('crosssell/crosssell')->zapisPro($productIds, $danex);	
        $this->_getSession()->addSuccess( $this->__('Created rules %d', count($productIds)) );
        }

		catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        catch (Exception $e) {
           $this->_getSession()->addException($e, $this->__('Failed'));
        }

        if($storeId==0){
        $this->_redirect('adminhtml/catalog_product/index/', array());
		}else{
		$this->_redirect('adminhtml/catalog_product/index/store/'.$storeId, array());
		}

    }
	
	public function crosssellxAction() 
{
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
		$danex     = (string)$this->getRequest()->getParam('crossxx');

        try {
		$ilosc = Mage::getSingleton('crosssell/crosssell')->powiazPro($productIds, $danex);	
        $this->_getSession()->addSuccess( $this->__('added products - %d', $ilosc) );
        }

		catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        catch (Exception $e) {
           $this->_getSession()->addException($e, $this->__('Failed'));
        }

        if($storeId==0){
        $this->_redirect('adminhtml/catalog_product/index/', array());
		}else{
		$this->_redirect('adminhtml/catalog_product/index/store/'.$storeId, array());
		}

    }

	

	
	
	
	
	
}
