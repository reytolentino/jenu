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
        return "
        function readCookie(name) {
          name += '=';
          for (var ca = document.cookie.split(/;\s*/), i = ca.length - 1; i >= 0; i--)
          if (!ca[i].indexOf(name))
            return ca[i].replace(name, '');
        }

        var gaUserCookie = readCookie('_ga');
        var customUserId;
        if (gaUserCookie != undefined) {
          var cookieValues = gaUserCookie.split('.');
          if (cookieValues.length > 2 )
          {
            var customUserId = cookieValues[2];
           }
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