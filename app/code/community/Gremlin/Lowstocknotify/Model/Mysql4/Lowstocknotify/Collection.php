<?php
/**
 * Lowstocknotify MySQL4 Lowstocknotify Collection Model
 *
 * @category    Model
 * @package     Gremlin_Lowstocknotify
 * @author      Junaid Bhura <info@gremlin.io>
 */

class Gremlin_Lowstocknotify_Model_Mysql4_Lowstocknotify_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	
	/**
	 * Constructor
	 */
	public function _construct() {
		$this->_init( 'lowstocknotify/lowstocknotify' );
	}
	
}
