<?php

/**
 * Product:       Xtento_OrderExport (1.4.1)
 * ID:            %!uniqueid!%
 * Packaged:      %!packaged!%
 * Last Modified: 2012-12-16T13:35:18+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/System/Config/Source/Export/Events.php
 * Copyright:     Copyright (c) 2014 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_System_Config_Source_Export_Events
{
    public function toOptionArray($entity = false)
    {
        $optionArray = array();
        $events = Mage::getSingleton('xtento_orderexport/observer_event')->getEvents($entity);
        foreach ($events as $entityEvents) {
            foreach ($entityEvents as $eventId => $eventOptions) {
                $optionArray[$eventId] = $eventOptions['label'];
            }
        }
        return $optionArray;
    }
}