<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'EKWC_Admin_Menu' ) ) :

    /**
     * Main EKWC_Admin_Menu Class
     *
     * @class EKWC_Admin_Menu
     * @version     
     */
    final class EKWC_Admin_Menu {

        /**
         * The single instance of the class.
         *
         * @var EKWC_Admin_Menu
         */
        protected static $instance = null;

        /**
         * Constructor for the class.
         * Initializes the event handler (hooks and actions).
         */
        public function __construct() {
            $this->event_handler();
        }

        /**
         * Initialize hooks and filters for the admin menu.
         * This includes the settings registration and filter actions.
         */
        private function event_handler() {
            // Add admin init action to register settings
            add_action( 'admin_init', [ $this, 'register_settings' ] );

            // Add admin menu action to create submenu pages
            add_action( 'admin_menu', [ $this, 'admin_menu' ] );

            // Add filters to modify options before updating
            add_filter( 'pre_update_option_ekwc_general_setting', [ $this, 'filter_data_before_update' ], 10, 3 );
            add_filter( 'pre_update_option_ekwc_shipping_bar_settings', [ $this, 'filter_data_before_update' ], 10, 3 );
            add_filter( 'pre_update_option_ekwc_wishlist_setting', [ $this, 'filter_data_before_update' ], 10, 3 );
            add_filter( 'pre_update_option_ekwc_quick_view_setting', [ $this, 'filter_data_before_update' ], 10, 3 );
        }

        /**
         * Register plugin settings.
         * This is used to register all the settings that will be stored in the options table.
         */
        public function register_settings() {
            // Register settings with a common sanitization function
            $settings = [
                'ekwc_general_setting',
                'ekwc_compare_genral',
                'ekwc_compare_table',
                'ekwc_compare_style',
                'ekwc_compare_premium',
                'ekwc_shipping_bar_settings',
                'ekwc_wishlist_setting',
                'ekwc_quick_view_setting',
                'ekwc_size_chart_setting'
            ];
        
            foreach ( $settings as $setting ) :
                register_setting( $setting, $setting, [ 'sanitize_callback' => [ $this, 'sanitize_input' ] ] );
            endforeach;
        }
        
        /**
         * Generic sanitization function for all settings.
         *
         * @param mixed $input The input value to sanitize.
         * @return mixed Sanitized input value.
         */
        public function sanitize_input( $input ) {

            if ( is_array( $input ) ) :
                $sanitized = [];

                foreach ( $input as $key => $value ) :
                    if ( is_array( $value ) ) :
                        $sanitized[ $key ] = $this->sanitize_input( $value );
                    elseif ( strpos( $key, 'textarea' ) !== false || strpos( $key, 'description' ) !== false || strpos( $key, 'content' ) !== false ) :
                        $sanitized[ $key ] = sanitize_textarea_field( $value );
                    else :
                        $sanitized[ $key ] = sanitize_text_field( $value );
                    endif;
                endforeach;
                return $sanitized;
            endif;

            return sanitize_text_field( $input );
        }
      
        

        /**
         * Add submenus to the "Essential Kit" menu.
         * These submenus allow users to navigate and configure various settings.
         */
        public function admin_menu() {
            // Add Product Compare submenu
            add_submenu_page( 
                'essential_kit', 
                esc_html__( 'Essential Kit Product Compare', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'Product Compare', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'ekwc-product-compare', 
                [ $this, 'admin_menu_content' ] 
            );

            // Add Free Shipping Bar submenu
            add_submenu_page( 
                'essential_kit', 
                esc_html__( 'Essential Kit Free Shipping Bar', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'Free Shipping Bar', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'ekwc-free-shipping-bar', 
                [ $this, 'free_shipping_bar_menu_content' ] 
            );

            // Add Wishlist submenu
            add_submenu_page( 
                'essential_kit', 
                esc_html__( 'Essential Kit Wishlist', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'Wishlist', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'ekwc-wishlist', 
                [ $this, 'wishlist_menu_content' ] 
            );

            // Add Quick View submenu
            add_submenu_page( 
                'essential_kit', 
                esc_html__( 'Essential Kit Quick View', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'Quick View', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'ekwc-quick-view', 
                [ $this, 'quick_view_menu_content' ] 
            );

            // Add Quick View submenu
            add_submenu_page( 
                'essential_kit', 
                esc_html__( 'Essential Kit Size Chart', 'essential-kit-for-woocommerce' ), 
                esc_html__( 'Size Chart', 'essential-kit-for-woocommerce' ), 
                'manage_options', 
                'ekwc-size-chart', 
                [ $this, 'size_chart_menu_content' ] 
            );
        }

        /**
         * Display content for the Product Compare settings page.
         */
        public function admin_menu_content() {
            // Get the active tab (default to 'general')
            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';

            // Include the view file for the Product Compare settings page
            require_once EKWC_PATH . 'includes/admin/settings/views/product-compare-menu.php';
        }

        /**
         * Display content for the Free Shipping Bar settings page.
         */
        public function free_shipping_bar_menu_content() {
            // Get the active tab (default to 'general')
            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';

            // Include the view file for the Free Shipping Bar settings page
            require_once EKWC_PATH . 'includes/admin/settings/views/free-shipping-bar-menu.php';
        }

        /**
         * Display content for the Wishlist settings page.
         */
        public function wishlist_menu_content() {
            // Get the active tab (default to 'general')
            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';

            // Include the view file for the Wishlist settings page
            require_once EKWC_PATH . 'includes/admin/settings/views/wishlist-menu.php';
        }

        /**
         * Display content for the Quick View settings page.
         */
        public function quick_view_menu_content() {
            // Get the active tab (default to 'general')
            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';

            // Include the view file for the Quick View settings page
            require_once EKWC_PATH . 'includes/admin/settings/views/quick-view-menu.php';
        }    
        
        /**
         * Display content for the Size Chart settings page.
         */
        public function size_chart_menu_content() {
            // Get the active tab (default to 'general')
            $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';

            // Include the view file for the Size Chart settings page
            require_once EKWC_PATH . 'includes/admin/settings/views/size-chart-menu.php';
        }    

        /**
         * Filter data before updating options in the database.
         *
         * @param mixed  $value     The new value to be updated.
         * @param mixed  $old_value The previous value.
         * @param string $option    The option name.
         *
         * @return mixed The filtered data.
         */
        public function filter_data_before_update( $value, $old_value, $option ) {
            // Merge old value with new value to retain all settings
            $data = array_merge( (array) $old_value, (array) $value );
            return $data;
        }

    }

    // Instantiate the EKWC_Admin_Menu class
    new EKWC_Admin_Menu();

endif;
