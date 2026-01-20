<?php
/**
 * JThemes Dashboard Class
 *
 * Handles the admin dashboard setup and related functionalities.
 *
 * @package JThemes
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Essential_Kit_Dashboard' ) ) {

	/**
	 * Class Essential_Kit_Dashboard
	 *
	 * Initializes the admin dashboard for JThemes.
	 */
	class Essential_Kit_Dashboard {

		/**
		 * Constructor for Essential_Kit_Dashboard class.
		 * Initializes the event handler.
		 */
		public function __construct() {
			$this->events_handler();
		}

		/**
		 * Initialize hooks for admin functionality.
		 */
		private function events_handler() {
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		}

		/**
		 * Enqueue admin-specific styles for the dashboard.
		 */
		public function enqueue_scripts() {
			// Enqueue the JThemes dashboard CSS.
			wp_enqueue_style(
				'jthemes-dashboard',
				EKWC_URL . '/assets/css/admin-styles.css',
				[],
				EKWC_VERSION 
			);

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				'ekwc-admin-js',
				EKWC_URL . '/assets/js/ekwc-admin.js',
				array( 'jquery', 'wp-color-picker' ), // Dependencies
				EKWC_VERSION,
				true // Load in footer
			);
		}

		/**
		 * Add JThemes menu and submenu to the WordPress admin menu.
		 */
		public function admin_menu() {
			// Add the main menu page.
			add_menu_page(
				'Essential Kit',
				'Essential Kit',
				'manage_options',
				'essential_kit',
				[ $this, 'dashboard_callback' ], 
				'data:image/svg+xml;base64,' . base64_encode( file_get_contents( EKWC_PATH . '/assets/img/ekwc.svg' ) ),
				26
			);

			// Add a submenu page under the main JThemes menu.
			add_submenu_page( 
                'essential_kit',
                esc_html__( 'Essential Kit General', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'General', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'essential_kit', 
            );
		}

		/**
		 * Callback function for rendering the dashboard content.
		 */
		public function dashboard_callback() {
			$active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
			// Include the about page view file.
			require_once EKWC_PATH . 'includes/admin/dashboard/views/about.php';
		}
	}

	// Instantiate the Essential_Kit_Dashboard class.
	new Essential_Kit_Dashboard();
}
