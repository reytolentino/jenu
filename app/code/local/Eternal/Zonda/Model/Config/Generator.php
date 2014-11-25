<?php 
class Eternal_Zonda_Model_Config_Generator extends Mage_Core_Model_Abstract
{ 
    public function __construct()
    {
        parent::__construct(); 
    } 
    
    public function generateCss($websiteCode, $storeCode)
    {
        if ($websiteCode)
        { 
            if ($storeCode) 
            {
                $this->_generateStoreCss($storeCode); 
            } 
            else 
            {
                $this->_generateWebsiteCss($websiteCode); 
            }
        }
        else
        {
            $websites = Mage::app()->getWebsites(false, true);
            foreach ($websites as $website => $value) 
            {
                $this->_generateWebsiteCss($website); 
            }
        } 
    }
    
    protected function _generateWebsiteCss($websiteCode) 
    {
        $store = Mage::app()->getWebsite($websiteCode);
        foreach ($store->getStoreCodes() as $storeCode)
        { 
            if (!$this->_generateStoreCss($storeCode))
                break;
        }
    } 
    
    protected function _generateStoreCss($storeCode)
    {
        if (!Mage::app()->getStore($storeCode)->getIsActive()) 
            return false;
            
        $fileName = 'store_' . $storeCode . '.css';
        $file = Mage::helper('zonda/config')->getGeneratedCssDir() . $fileName;
        $templateFile = 'eternal/zonda/config.phtml';
        Mage::register('zonda_css_generate_store', $storeCode);
        try
        { 
            $tempalte = Mage::app()->getLayout()->createBlock("core/template")->setData('area', 'frontend')->setTemplate($templateFile)->toHtml();
            if (empty($tempalte)) 
            {
                throw new Exception( Mage::helper('zonda')->__("Template file is empty or doesn't exist: %s", $templateFile) ); 
                return false;
            }
            $io = new Varien_Io_File(); 
            $io->setAllowCreateFolders(true); 
            $io->open(array( 'path' => Mage::helper('zonda/config')->getGeneratedCssDir() )); 
            $io->streamOpen($file, 'w+'); 
            $io->streamLock(true); 
            $io->streamWrite($tempalte); 
            $io->streamUnlock(); 
            $io->streamClose(); 
        }
        catch (Exception $exception)
        { 
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zonda')->__('Failed generating CSS file: %s in %s', $fileName, Mage::helper('zonda/config')->getGeneratedCssDir()). '<br/>Message: ' . $exception->getMessage()); 
            Mage::logException($exception);
            return false;
        }
        Mage::unregister('zonda_css_generate_store');
        return true; 
    } 
}