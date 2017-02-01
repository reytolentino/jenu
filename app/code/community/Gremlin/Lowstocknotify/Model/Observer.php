<?php
/**
 * Observer Model
 *
 * @category    Model
 * @package     Gremlin_Lowstocknotify
 * @author      Junaid Bhura <info@gremlin.io>
 */

class Gremlin_Lowstocknotify_Model_Observer {

	/**
	 * Triggered when a product's stock is changed
	 *
	 * @param  Varien_Event_Observer $observer
	 * @return void
	 */
	public function stockChanged( Varien_Event_Observer $observer ) {
		// Check if extension is enabled
		if ( ! Mage::getStoreConfig( 'cataloginventory/lowstocknotify/active' ) )
			return;

		// Get stock item and stock level config
		$stock_item = $observer->getEvent()->getItem();
		
		// Check notification for this stock item, if it's simple or virtual
		if ( $stock_item->getTypeId() == 'simple' || $stock_item->getTypeId() == 'virtual' )
			$this->checkNotification( $stock_item );
	}

	/**
	 * Triggered when a new order is placed
	 *
	 * @param  Varien_Event_Observer $observer
	 * @return void
	 */
	public function orderPlaced( Varien_Event_Observer $observer ) {
		// Check if extension is enabled
		if ( ! Mage::getStoreConfig( 'cataloginventory/lowstocknotify/active' ) )
			return;

		// Get order and items
		$order = $observer->getEvent()->getOrder();
		$items = $order->getAllItems();

		// Check notification for each stock item
		foreach ( $items as $item ) {
			$product = Mage::getModel( 'catalog/product' )->load( $item->getProductId() );
			
			// Skip products that are not simple or virtual
			if ( $product->getTypeId() != 'simple' && $product->getTypeId() != 'virtual' )
				continue;

			$stock_item = Mage::getModel( 'cataloginventory/stock_item' )->loadByProduct( $product );
			$this->checkNotification( $stock_item );
		}
	}

	/**
	 * Checks the notification of a stock item
	 * 
	 * @param  Mage_CatalogInventory_Model_Stock_Item $stock_item
	 * @return void
	 */
	private function checkNotification( $stock_item ) {
		// Get stock level config
		$stock_level = Mage::getStoreConfig( 'cataloginventory/lowstocknotify/stock_level' );

		// Check if item quantity is less than stock level
		if ( $stock_item->getQty() <= $stock_level ) {
			// Check if notification has already been sent
			$notify = Mage::getModel( 'lowstocknotify/lowstocknotify' )
				->getCollection()
				->addFieldToFilter( 'product_id', $stock_item->getProductId() )
				->load();

			// Notification not sent, send it now
			if ( $notify->getSize() == 0 ) {
				// Get and validate email addresses
				$emails = array_map( 'trim', explode( ',', Mage::getStoreConfig( 'cataloginventory/lowstocknotify/email_addresses' ) ) );
				$to_emails = array();
				foreach ( $emails as $email ) {
					if ( Zend_Validate::is( $email, 'EmailAddress' ) )
						$to_emails[] = $email;
				}

				if ( ! $to_emails )
					return;

				// Get email template
				if ( is_numeric( Mage::getStoreConfig( 'cataloginventory/lowstocknotify/email_template' ) ) )
					$template = Mage::getModel( 'core/email_template' )->load( Mage::getStoreConfig( 'cataloginventory/lowstocknotify/email_template' ) );
				else
					$template = Mage::getModel( 'core/email_template' )->loadDefault( 'gremlin_lowstocknotify_email' );
				$params = array(
					'product' => Mage::getModel('catalog/product')->load( $stock_item->getProductId() ),
					'stock_item' => $stock_item,
				);
				$content = $template->getProcessedTemplate( $params );
				$subject = $template->getProcessedTemplateSubject( $params );

				// Send mail
				foreach ( $to_emails as $email ) {
					$mail = Mage::getModel('core/email')
						->setToEmail( $email )
						->setBody( $content )
						->setSubject( $subject )
						->setFromEmail( Mage::getStoreConfig( 'trans_email/ident_general/email' ) )
						->setFromName( Mage::getStoreConfig( 'trans_email/ident_general/name' ) )
						->setType( 'html' );

					$mail->send();
				}

				// Save into database
				Mage::getModel( 'lowstocknotify/lowstocknotify' )
					->setProductId( $stock_item->getProductId() )
					->setNotifiedAt( date( 'Y-m-d H:i:s', Mage::getModel( 'core/date' )->timestamp( time() ) ) )
					->save();

				// Trigger event
				Mage::dispatchEvent( 'gremlin_lowstocknotify_email_after', array( 'stock_item' => $stock_item, 'product' => $product, 'to_emails' => $to_emails ) );
			}
		}

		// Item quantity is greater than stock level
		else {
			// Check if notification has been sent
			$notify = Mage::getModel( 'lowstocknotify/lowstocknotify' )
				->getCollection()
				->addFieldToFilter( 'product_id', $stock_item->getProductId() )
				->load();

			// Notification sent, remove it from log
			if ( $notify->getSize() != 0 ) {
				foreach ( $notify as $item ) {
					$item->delete();
				}
			}
		}
	}

}
