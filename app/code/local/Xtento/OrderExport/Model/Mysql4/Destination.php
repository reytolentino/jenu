<?php

/**
 * Product:       Xtento_OrderExport (1.4.1)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2013-02-10T15:47:26+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Mysql4/Destination.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Mysql4_Destination extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('xtento_orderexport/destination', 'destination_id');
    }
}