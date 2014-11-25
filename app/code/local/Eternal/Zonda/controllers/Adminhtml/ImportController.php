<?php
class Eternal_Zonda_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
        $website = Mage::app()->getRequest()->getParam('website');
        $store   = Mage::app()->getRequest()->getParam('store');
        
        $url = 'adminhtml/system_config/edit/section/zonda_data';
        if ($website)
            $url .= '/website/' . $website;
        if ($store)
            $url .= '/store/' . $store;
        
        $url = $this->getUrl($url);
        
		$this->getResponse()->setRedirect($url);
	}
    
    public function blocksAction()
    {
        $website = Mage::app()->getRequest()->getParam('website');
        $store   = Mage::app()->getRequest()->getParam('store');
        
        $url = 'adminhtml/system_config/edit/section/zonda_data';
        if ($website)
            $url .= '/website/' . $website;
        if ($store)
            $url .= '/store/' . $store;
        
        $url = $this->getUrl($url);
        
        $overwrite = Mage::helper('zonda')->getConfigData('theme_import/overwrite_blocks');
        Mage::getSingleton('zonda/import_blocks')->importBlockItems('cms/block', 'blocks', $overwrite);
        $this->getResponse()->setRedirect($url); 
    }
    
    public function pagesAction() 
    {
        $website = Mage::app()->getRequest()->getParam('website');
        $store   = Mage::app()->getRequest()->getParam('store');
        
        $url = 'adminhtml/system_config/edit/section/zonda_data';
        if ($website)
            $url .= '/website/' . $website;
        if ($store)
            $url .= '/store/' . $store;
        
        $url = $this->getUrl($url);
        
        $overwrite = Mage::helper('zonda')->getConfigData('theme_import/overwrite_pages');
        Mage::getSingleton('zonda/import_pages')->importPageItems('cms/page', 'pages', $overwrite);
        $this->getResponse()->setRedirect($url);
    }
    
    public function settingsAction() 
    {
        $website = Mage::app()->getRequest()->getParam('website');
        $store   = Mage::app()->getRequest()->getParam('store');
        
        $url = 'adminhtml/system_config/edit/section/zonda_data';
        if ($website)
            $url .= '/website/' . $website;
        if ($store)
            $url .= '/store/' . $store;
        
        $url = $this->getUrl($url);
        
        Mage::getSingleton('zonda/import_settings')->exportSettings($website, $store);
        $this->getResponse()->setRedirect($url);
    }
}