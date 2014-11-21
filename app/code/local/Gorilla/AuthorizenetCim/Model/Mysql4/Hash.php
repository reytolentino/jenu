<?php
/**
 * Gorilla AuthorizeNet CIM module
 *
 * @category     Gorilla
 * @copyright    Copyright (c) 2011-2012 Gorilla (http://www.gorillagroup.com)
 */
class Gorilla_AuthorizenetCim_Model_Mysql4_Hash extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('authorizenetcim/hash','eneity_id');
    }


   public function getTimestampByHash($hash, $object)
   {
       if ($read = $this->_getReadAdapter())
       {
           $select = $read->select()
               ->from($this->getMainTable(),array('entity_id', 'timestamp', 'hash'))
               ->where('hash = ?', $hash);

           if ($data = $read->fetchRow($select))
           {
               $object->setData($data);
           }
       }

       return $this;
   }

    public function cleanOldHash()
    {
        if ($write = $this->_getWriteAdapter())
        {
            $write->delete($this->getMainTable(), array(
                'timestamp < ?' => (int)time() - Mage::getSingleton('authorizenetcim/gateway')->getConfigData('transaction_timeout')
            ));
        }

        return $this;
    }
}