<?php
/**
 * Lowstocknotify MySQL4 Lowstocknotify Model
 *
 * @category    Model
 * @package     Gremlin_Lowstocknotify
 * @author      Junaid Bhura <info@gremlin.io>
 */

class Gremlin_Lowstocknotify_Model_Mysql4_Lowstocknotify extends Mage_Core_Model_Mysql4_Abstract {
	
	/**
	 * Constructor
	 */
	protected function _construct() {
		$this->_init( 'lowstocknotify/lowstocknotify', 'id' );
	}

}
