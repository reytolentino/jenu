<?php

/**
 * Default helper for our Admin module
 * 
 * Hook for translations
 */
class Web2Market_Report_Helper_Data 
    extends Mage_Core_Helper_Abstract
{
    
	
	public function getDefaultConnection()
    {
        /* @var $resource Mage_Core_Model_Resource */
        $resource       = Mage::getSingleton('core/resource');
        $connectionName = 'default_setup';
        if (!$connectionName) {
            $connectionName = 'core_read';
        }
        return $resource->getConnection($connectionName);
    }
	
	
	    public function getConnectionResourceConfig()
    {
        $resourceConfig = Mage::getConfig()->getXpath('global/resources/*[child::connection and descendant::active=1]');
        return $resourceConfig;
    }
	
	   public function getAdminSession()
    {
        return Mage::getSingleton('admin/session');
    }
	
	
	
	
	
	
	
	
	
}