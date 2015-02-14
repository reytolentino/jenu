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
        $userID = Mage::getSingleton("core/session")->getEncryptedSessionId();
        return "
        var customUserId;
        customUserId = '{$userID}';
        ga('create', '{$this->jsQuoteEscape($accountId)}', {'userId': customUserId});
        ga('create', '{$this->jsQuoteEscape($accountId)}', 'auto');
        " . $this->_getAnonymizationCode() . "
        ga('require', 'displayfeatures');
        ga('set', 'dimension1', customUserId);
        ga('send', 'pageview');
        ";
    }

}