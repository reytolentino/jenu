<?php

/**
 * Recurring profile orders grid
 */
class Gorilla_AuthorizenetCim_Block_Adminhtml_Tab_Card
    extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Initialize basic parameters
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('authorizenetcim_card')
            ->setUseAjax(true)
            ->setSaveParametersInSession(false)
        ;
    }

    /**
     * Get Url to action
     *
     * @param  string $action action Url part
     * @return string
     */
    protected function _getControllerUrl($action = '')
    {
        return '*/*/' . $action;
    }

    /**
     * Url for ajax grid submission
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('authorizenetcim/adminhtml_card/grid', array('_current' => true));
    }

    /**
     * Label getter
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('sales')->__('Authorize.net CIM Cards');
    }

    /**
     * Same as label getter
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        if (!Mage::helper('authorizenetcim')->isActive()) {
            return false;
        }

        if (!Mage::app()->getRequest()->getParam('id')) {
            return false;
        }

        return true;
    }

    public function isHidden()
    {
        return false;
    }

    public function getTabClass()
    {
        return 'authorizenetcim-card ajax';
    }

    public function getSkipGenerateContent()
    {
        return true;
    }

    public function getTabUrl()
    {
        return $this->getGridUrl();
    }

}
