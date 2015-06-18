<?php

/**
 * Product:       Xtento_TrackingImport (2.0.4)
 * ID:            /rRDmPy6ZEZj9ocZGuuFjhblVHpQKfaGmtArmCqlOFM=
 * Packaged:      2015-06-18T20:34:30+00:00
 * Last Modified: 2013-11-23T16:13:03+01:00
 * File:          app/code/local/Xtento/TrackingImport/controllers/Adminhtml/Trackingimport/IndexController.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Adminhtml_TrackingImport_IndexController extends Xtento_TrackingImport_Controller_Abstract
{
    public function redirectAction()
    {
        $redirectController = Mage::getStoreConfig('trackingimport/general/default_page');
        if (!$redirectController) {
            $redirectController = 'trackingimport_manual';
        }
        $this->_redirect('*/'.$redirectController);
    }

    public function installationAction() {
        Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('xtento_trackingimport')->__('The extension has not been installed properly. The required database tables have not been created yet. Please check out our <a href="http://support.xtento.com/wiki/Troubleshooting:_Database_tables_have_not_been_initialized" target="_blank">wiki</a> for instructions. After following these instructions access the module at Sales > Tracking Import again.'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function disabledAction() {
        Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('xtento_trackingimport')->__('The extension is currently disabled. Please go to System > XTENTO Extensions > Tracking Import Configuration to enable it. After that access the module at Sales > Tracking Import again.'));
        $this->loadLayout();
        $this->renderLayout();
    }
}