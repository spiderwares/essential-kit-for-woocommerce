<?php
defined( 'ABSPATH' ) || exit; // Ensure the file is being called from a valid WordPress environment.

/**
 * EKWC Shipping Ajax Handler
 *
 * Handles AJAX requests for tracking "Continue Shopping" clicks.
 *
 * @package EKWC
 */

if ( ! class_exists( 'EKWC_Shipping_Ajax_Handler' ) ) :

	/**
	 * Class EKWC_Shipping_Ajax_Handler
	 *
	 * Manages AJAX events for reporting "Continue Shopping" clicks.
	 */
	class EKWC_Shipping_Ajax_Handler {

		/**
		 * Constructor.
		 * Initializes the event handler.
		 */
		public function __construct() {
			$this->event_handler();
		}

		/**
		 * Registers AJAX actions.
		 */
		public function event_handler() {
			add_action( 'wp_ajax_increment_report_continue_shopping', array( __CLASS__, 'report_continue_shopping' ) );
			add_action( 'wp_ajax_nopriv_increment_report_continue_shopping', array( __CLASS__, 'report_continue_shopping' ) );
		}

		/**
		 * Handles the AJAX request to increment "Continue Shopping" click count.
		 *
		 * Increments the count in the WooCommerce settings and returns the shop page URL.
		 */
		public static function report_continue_shopping() {
			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
			$response      = array(
				'success' => false,
				'url'     => $shop_page_url,
			);

			// Verify nonce for security.
			if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'report-nonce' ) ) :
				$settings                             = get_option( 'ekwc_shipping_bar_settings', array() );
				$settings['continue_shopping_clicks'] = (int) ( $settings['continue_shopping_clicks'] ?? 0 ) + 1;

				// Update the WooCommerce settings option.
				update_option( 'ekwc_shipping_bar_settings', $settings );

				$response = array(
					'success' => true,
					'url'     => $shop_page_url,
				);
			endif;
			// Return response in JSON format.
			wp_send_json( $response );
		}
	}

	// Initialize the class.
	new EKWC_Shipping_Ajax_Handler();

endif;