<?php

/**
 * Product:       Xtento_StockImport (2.2.8)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2013-06-26T18:03:19+02:00
 * File:          app/code/local/Xtento/StockImport/Model/System/Config/Source/Import/Type.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_StockImport_Model_System_Config_Source_Import_Type
{

    public function toOptionArray()
    {
        return Mage::getSingleton('xtento_stockimport/import')->getImportTypes();
    }

}