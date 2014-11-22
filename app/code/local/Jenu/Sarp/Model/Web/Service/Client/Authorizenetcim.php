<?php

class Jenu_Sarp_Model_Web_Service_Client_Authorizenetcim extends AW_Sarp_Model_Web_Service_Client_Authorizenetcim
{

    const WSDL_ARB_TEST_PATH = 'https://apitest.authorize.net/soap/v1/Service.asmx?WSDL';
    const WSDL_ARB_PROD_PATH = 'https://api.authorize.net/soap/v1/Service.asmx?WSDL';

    public function getWsdl()
    {
        if (Mage::getStoreConfig(AW_Sarp_Model_Payment_Method_Authorizenetcim::XML_PATH_AUTHORIZENETCIM_TEST_MODE)) {
            return self::WSDL_ARB_TEST_PATH;
        } else {
            return self::WSDL_ARB_PROD_PATH;
        }
    }

}
