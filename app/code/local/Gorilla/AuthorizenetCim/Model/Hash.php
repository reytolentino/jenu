<?php
/**
 * Gorilla AuthorizeNet CIM module
 *
 * Class for interacting with CIM profile management via SOAP
 *
 * For documentation:
 * @see http://www.authorize.net/support/CIM_SOAP_guide.pdf
 * @see https://api.authorize.net/soap/v1/Service.asmx?WSDL
 * @category     Gorilla
 * @copyright    Copyright (c) 2011-2012 Gorilla (http://www.gorillagroup.com)
 */
class Gorilla_AuthorizenetCim_Model_Hash extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('authorizenetcim/hash');
    }

    public function getTimestampByHash($hash)
    {
        $this->getResource()->getTimestampByHash($hash, $this);
        return $this;
    }

    public function cleanOldHash()
    {
        $this->getResource()->cleanOldHash();
        return $this;
    }

}