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
 * @category    Enterprise
 * @package     Enterprise_SalesArchive
 * @copyright Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Order archive model
 *
 */
 class Enterprise_SalesArchive_Model_Order_Status_Source extends Mage_Adminhtml_Model_System_Config_Source_Order_Status
 {
     /**
      * Retrive order statuses as options for select
      *
      * @see Mage_Adminhtml_Model_System_Config_Source_Order_Status:toOptionArray()
      * @return array
      */
     public function toOptionArray()
     {
         $options = parent::toOptionArray();
         array_shift($options); // Remove '--please select--' option
         return $options;
     }
 }
