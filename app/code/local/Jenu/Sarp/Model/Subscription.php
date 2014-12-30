<?php

/**
 *
 * @author Vladimir Kalchenko <vkalchenko@gorillagroup.com>
 */
class Jenu_Sarp_Model_Subscription extends AW_Sarp_Model_Subscription
{
    /**
     * Processes subscription by sequence
     * @param object $Item
     * @return bool
     */
    public function payBySequence($Item)
    {
        $result = parent::payBySequence($Item);
        $lastLogMessage = Mage::getSingleton('awcore/logger')->getContent();

        if ($this->getStatus() == self::STATUS_SUSPENDED) {
            Mage::dispatchEvent('suspended_subscription', array('subscription' => $this, 'error_message' => $lastLogMessage));
        }
        return $result;
    }
}
