<?php
class MD_Partialpayment_Model_Mysql4_Payments extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('md_partialpayment/payments','payment_id');
    }
}

