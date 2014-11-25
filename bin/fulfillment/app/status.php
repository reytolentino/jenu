<?php 

require dirname(dirname(__FILE__)) . '/lib/debug.php';
require dirname(dirname(__FILE__)) . '/lib/fulfillment.php';
require dirname(dirname(__FILE__)) . '/lib/setup.php';

$outbound = in_array('outbound', $argv);
$inbound = in_array('inbound', $argv);

if (!$outbound && !$inbound) {
    $outbound   = true;
    $inbound    = true;
}

$standardOrders     = $catalog->getStandardOrders();
$etailerOrders      = $catalog->getEtailerOrders();
$standardUpdates    = $catalog->getStandardUpdatableOrders();
$etailerUpdates     = $catalog->getEtailerUpdatableOrders();

if ($outbound) {
    cprintf('Outbound Orders:');
    cprintf('%-2d x Standard orders are waiting to be sent.', count($standardOrders));
    cprintf(implode(', ', array_keys($standardOrders)));
    cprintf('%-2d x E-tailer orders are waiting to be sent.', count($etailerOrders));
    cprintf(implode(', ', array_keys($etailerOrders)));
}

if ($inbound) {
    cprintf('Inbound Updates:');
    cprintf('%-2d x Standard orders are awaiting updates.', count($standardUpdates));
    cprintf(implode(', ', $standardUpdates));
    cprintf('%-2d x E-tailer orders are awaiting updates.', count($etailerUpdates));
    cprintf(implode(', ', $etailerUpdates));
}

cprintf(''); 
exit;