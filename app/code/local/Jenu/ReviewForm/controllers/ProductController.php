<?php

require_once(Mage::getModuleDir('controllers','Mage_Review').DS.'ProductController.php');

class Jenu_ReviewForm_ProductController extends Mage_Review_ProductController
{

    protected function _cropReviewData(array $reviewData)
    {
        $croppedValues = array();
        $allowedKeys = array_fill_keys(array('detail', 'title', 'nickname', 'email', 'products'), true);

        foreach ($reviewData as $key => $value) {
            if (isset($allowedKeys[$key])) {
                $croppedValues[$key] = $value;
            }
        }

        return $croppedValues;
    }

}
