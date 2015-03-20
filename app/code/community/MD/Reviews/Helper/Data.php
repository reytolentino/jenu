<?php

class MD_Reviews_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getReviewUrl($id) {
	return Mage::getUrl('review/product/view', array('id' => $id));
    }
}
