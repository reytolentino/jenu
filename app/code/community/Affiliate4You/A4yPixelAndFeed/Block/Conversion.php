<?php

class Affiliate4You_A4yPixelAndFeed_Block_Conversion extends Mage_Core_Block_Template
{
	public function getIsActive()
	{
		return Mage::getStoreConfig('a4ypixel/general/enabled') ? true : false;
	}

	public function getCampaignId()
	{
		return Mage::getStoreConfig('a4ypixel/general/campaign_id');
	}
}