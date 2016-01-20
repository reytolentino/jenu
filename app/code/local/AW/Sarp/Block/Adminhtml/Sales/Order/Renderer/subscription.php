<?php

/**
 * Magedelight
 * Copyright (C) 2014 Magedelight <info@magedelight.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @category MD
 * @package MD_Partialpayment
 * @copyright Copyright (c) 2014 Mage Delight (http://www.magedelight.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Magedelight <info@magedelight.com>
 */

/**
 * Adminhtml operations orders grid renderer
 *
 * @category   Inchoo
 * @package    Inchoo_DateOrder
 */
class AW_Sarp_Block_Adminhtml_Sales_Order_Renderer_Subscription extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row) {
		{
			$order_id=$row->getData('increment_id');
			$order = Mage::getModel('sales/order')->loadByIncrementID($order_id);
			$items = $order->getAllItems();
			$orderDate = $order->getCreatedAtStoreDate();
			$orderDateFormat = date('Y-m-d', strtotime($orderDate));
			foreach ($items as $itemId => $item)
			{
				if($item->getProductOptions())
				{
					$options = $item->getProductOptions();
					if (isset($options['info_buyRequest'])) {

						$periodTypeId = @$options['info_buyRequest']['aw_sarp_subscription_type'];
						$periodStartDate = @$options['info_buyRequest']['aw_sarp_subscription_start'];
						$periodStartDateFormat = date('Y-m-d', strtotime($periodStartDate));
						$subscriptionName = Mage::getModel('sarp/period')->load($periodTypeId)->getName();
						if($subscriptionName && strtotime($periodStartDateFormat) !== strtotime($orderDateFormat)){
							$result = "Y";
						} else {
							$result = "N";
						}
					}
				}
			}
			return $result;
		}
	}
}




