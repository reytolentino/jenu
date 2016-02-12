<?php
/**
 * Created by PhpStorm.
 * User: rtolentino
 * Date: 2/11/16
 * Time: 3:42 PM
 */

require_once 'Mage/Catalog/controllers/Product/CompareController.php';

class Jenu_GlobalMessagesFix_Product_CompareController extends Mage_Catalog_Product_CompareController
{
    protected function _redirectReferer()
    {
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        }

        /*inject ignore global full page cache param*/
        if (!strpos($refererUrl, '?___store'))
        {
            $refererUrl .= '?___store';
        }
        /*end of hacking*/

        $this->getResponse()->setRedirect($refererUrl);
        //parent::_redirectReferer($url); // call _redirectReferer from Mage_Core_Controller_Varien_Action
        return $this;
    }
}
