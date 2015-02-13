<?php
/**
 * Created by PhpStorm.
 * User: rtolentino
 * Date: 2/13/15
 * Time: 1:51 PM
 */

class Jenu_GoogleAnalytics_Block_Ga extends Mage_GoogleAnalytics_Block_Ga
{

    protected function _getPageTrackingCodeUniversal($accountId)
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            $loggedInId = $customerData->getId();
        }
        return "
        var prefix = ['abc', 'def', 'ghi'],
          middle = ['123', '456', '789'],
          suffix = ['rst', 'uvw', 'xyz'],
          random = function() {
              return Math.floor(Math.random() * 3);
          };
        var customUserId;
        customUserId = '{$loggedInId}';
        if (customUserId) {
        customUserId = '{$loggedInId}';
        } else {
        customUserId = prefix[random()] + '-' + middle[random()] + '-' + suffix[random()];
        }
        ga('create', '{$this->jsQuoteEscape($accountId)}', {'userId': customUserId});
        ga('create', '{$this->jsQuoteEscape($accountId)}', 'auto');
        " . $this->_getAnonymizationCode() . "
        ga('require', 'displayfeatures');
        ga('set', 'dimension1', customUserId);
        ga('send', 'pageview');
        ";
    }

}