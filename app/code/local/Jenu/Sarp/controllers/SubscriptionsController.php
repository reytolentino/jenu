<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Sarp
 * @version    1.7.0
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */

require_once 'AW/Sarp/controllers/SubscriptionsController.php';

class Jenu_Sarp_SubscriptionsController extends AW_Sarp_SubscriptionsController
{
    /**
     * Saves subscription
     * @return
     */
    public function saveAction()
    {
        $Subscription = Mage::getModel('sarp/subscription')->load($this->getRequest()->getParam('id'));
        try {
            if (!$Subscription->getId()) {
                throw new AW_Sarp_Exception("Subscription doesn't exist!");
            }
            $Subscription->setStatus($this->getRequest()->getParam('status'))
                         ->setDateCanceled($this->getRequest()->getParam('date_canceled'))
                         ->save();
            Mage::getSingleton('adminhtml/session')->addSuccess("Subscription successfully saved");
        } catch (AW_Sarp_Exception $E) {
            Mage::getSingleton('adminhtml/session')->addError($E->getMessage());

        }
        $this->_redirect('*/*');
    }
}