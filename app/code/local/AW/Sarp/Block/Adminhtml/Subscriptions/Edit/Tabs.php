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

class AW_Sarp_Block_Adminhtml_Subscriptions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sarp_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Subscription Information'));
    }

    protected function _beforeToHtml()
    {
        $tabTitle = 'Main';

        $this->addTab('main_section', array(
                                           'label' => $this->__($tabTitle),
                                           'title' => $this->__($tabTitle),
                                           'content' => $this->getLayout()->createBlock('sarp/adminhtml_subscriptions_edit_tab_main')->setSubscription($this->getSubscription())->toHtml()
                                      )
        );
        $this->addTab('payments_section', array(
                                               'label' => $this->__('Payments'),
                                               'title' => $this->__('Payments'),
                                               'content' => $this->getLayout()->createBlock('sarp/adminhtml_subscriptions_edit_tab_payments')->setSubscription($this->getSubscription())->toHtml()
                                          )
        );
        return parent::_beforeToHtml();
    }
}
