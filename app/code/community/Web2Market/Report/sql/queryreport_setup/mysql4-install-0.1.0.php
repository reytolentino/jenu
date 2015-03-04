<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 */

/**
 * @category   Web2Market
 * @package    Web2Market_Restrictions
 * @author     Web2Market
 */

/** @var $installer Web2Market_Restrictions_Model_Resource_Eav_Mysql4_Setup */

/* @var $installer Mage_Core_Model_Resource_Setup */



$installer = $this;
$installer->startSetup();


$sql=<<<SQLTEXT
create table queryreport(id int not null auto_increment, description_type varchar(255), query_type varchar(1000),primary key(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
SQLTEXT;

$installer->run($sql);
$installer->endSetup();


$installer1 = $this;
$installer1->startSetup();

$sql1=<<<SQLTEXT
INSERT INTO queryreport (id, description_type, query_type)
VALUES (1,"BestSeller Product Report", "SELECT SUM(qty_ordered) AS ordered_qty, name AS order_items_name, IF(parent_id IS NOT NULL AND visibility != 4, parent_id, product_id) AS final_product_id FROM (SELECT order_items.qty_ordered, order_items.name, order_items.product_id, cpr.parent_id, cat_index.store_id, cat_index.visibility, cat_index.category_id FROM `sales_flat_order_item` AS `order_items` INNER JOIN `sales_flat_order` AS `order` ON `order`.entity_id = order_items.order_id AND `order`.state != 'canceled' LEFT JOIN catalog_product_relation AS cpr ON cpr.child_id = order_items.product_id LEFT JOIN catalog_category_product_index AS cat_index ON cat_index.product_id = order_items.product_id WHERE parent_item_id IS NULL AND cat_index.store_id = 1 AND category_id = 2) AS T1 GROUP BY final_product_id ORDER by ordered_qty DESC")
SQLTEXT;

$installer1->run($sql1);
$installer1->endSetup();



$installer2 = $this;
$installer2->startSetup();
$sql2=<<<SQLTEXT
INSERT INTO queryreport (id, description_type, query_type)
VALUES (2, "Sale By Date", "SELECT DATE(created_at) AS date, SUM(qty_ordered) AS total_sales
FROM sales_flat_order_item
GROUP BY date")
SQLTEXT;

$installer2->run($sql2);
$installer2->endSetup();


$installer3 = $this;
$installer3->startSetup();
$sql3=<<<SQLTEXT
INSERT INTO queryreport (id, description_type, query_type)
VALUES (3, "Calculating Lifetime Value of a Customer in Magento", "SELECT DISTINCT customer_email, customer_firstname, customer_lastname,
SUM(subtotal_invoiced) AS Total
FROM `sales_flat_order` AS a
GROUP BY customer_email
ORDER BY SUM(subtotal_invoiced) DESC")
SQLTEXT;
$installer3->run($sql3);
$installer3->endSetup();

$installer4 = $this;
$installer4->startSetup();
$sql4=<<<SQLTEXT
INSERT INTO queryreport (id, description_type, query_type)
VALUES (4, "Customer Who did not Purchase Product", "SELECT email
FROM customer_entity AS t1
LEFT JOIN sales_flat_order AS t2 ON t1.entity_id = t2.customer_id WHERE t2.customer_id IS NULL ")
SQLTEXT;

$installer4->run($sql4);
$installer4->endSetup();