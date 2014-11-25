<?php

require dirname(dirname(__FILE__)) . '/lib/debug.php';
require dirname(dirname(__FILE__)) . '/lib/fulfillment.php';
require dirname(dirname(__FILE__)) . '/lib/setup.php';

print_r($catalog->getEtailerOrders());
