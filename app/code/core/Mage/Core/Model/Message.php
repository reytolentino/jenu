<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Message model
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Core_Model_Message
{
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const SUCCESS   = 'success';
    
    protected function _factory($code, $type, $class='', $method='')
    {
        switch (strtolower($type)) {
            case self::ERROR :
                $message = new Mage_Core_Model_Message_Error($code);
                break;
            case self::WARNING :
                $message = new Mage_Core_Model_Message_Warning($code);
                break;
            case self::SUCCESS :
                $message = new Mage_Core_Model_Message_Success($code);
                break;
            default:
                $message = new Mage_Core_Model_Message_Notice($code);
                break;
        }
        $message->setClass($class);
        $message->setMethod($method);
        
        return $message;
    }
    
    public function error($code, $class='', $method='')
    {
        return $this->_factory($code, self::ERROR, $class, $method);
    }

    public function warning($code, $class='', $method='')
    {
        return $this->_factory($code, self::WARNING, $class, $method);
    }

    public function notice($code, $class='', $method='')
    {
        return $this->_factory($code, self::NOTICE, $class, $method);
    }

    public function success($code, $class='', $method='')
    {
        return $this->_factory($code, self::SUCCESS, $class, $method);
    }
}
