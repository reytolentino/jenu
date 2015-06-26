<?php

/**
 * Product:       Xtento_TrackingImport (2.0.5)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2013-11-03T16:33:42+01:00
 * File:          app/code/local/Xtento/TrackingImport/Helper/Import.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Helper_Import extends Mage_Core_Helper_Abstract
{
    public function getImportBkpDir()
    {
        return Mage::getBaseDir('var') . DS . "import_bkp" . DS;
    }

    public function getProcessorName($processor)
    {
        $processors = Mage::getSingleton('xtento_trackingimport/import')->getProcessors();
        $processorName = $processors[$processor];
        return $processorName;
    }
}