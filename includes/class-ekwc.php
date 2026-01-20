<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'EKWC' ) ) :

    /**
     * Main EKWC Class
     *
     * @class EKWC
     * @version 1.0.0
     */
    final class EKWC {

        /**
         * The single instance of the class.
         *
         * @var EKWC
         */
        protected static $instance = null;

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->event_handler();
            $this->includes();
        }

        /**
         * Initialize hooks and filters.
         */
        private function event_handler() {
            // Register plugin activation hook
            register_activation_hook( EKWC_FILE, array( __CLASS__, 'install' ) );
            add_action( 'plugins_loaded', array( $this, 'ekwc_install' ), 11 );
            add_action( 'plugins_loaded', array( $this, 'includes' ), 11 );
        }

        /**
         * Main EKWC Instance.
         *
         * Ensures only one instance of EKWC is loaded or can be loaded.
         *
         * @static
         * @return EKWC - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) :
                self::$instance = new self();
                do_action( 'ekwc_plugin_loaded' );
            endif;
            return self::$instance;
        }

        /**
         * Function to display admin notice if WooCommerce is not active.
         */
        public function woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php esc_html_e( 'Essential Kit For WooCommerce requires WooCommerce to work.', 'essential-kit-for-woocommerce' ); ?></p>
            </div>
            <?php
        }

        /**
         * Function to initialize the plugin after WooCommerce is loaded.
         */
        public function ekwc_install() {
            if ( ! function_exists( 'WC' ) ) :
                add_action( 'admin_notices', array( $this, 'woocommerce_admin_notice' ) );
            else :
                do_action( 'ekwc_init' );
            endif;
        }

        /**
         * Include required files.
         */
        public function includes() {
            require_once EKWC_PATH . 'includes/public/product-compare/class-ekwc-compare-ajax-handler.php';
            require_once EKWC_PATH . 'includes/public/wishlist/class-ekwc-ajax-handler.php';
            require_once EKWC_PATH . 'includes/public/free-shipping-bar/class-ekwc-shipping-options.php';
            require_once EKWC_PATH . 'includes/public/free-shipping-bar/class-ekwc-shipping-bar-ajax-handler.php';
            require_once EKWC_PATH . 'includes/ekwc-functions.php';
            require_once EKWC_PATH . 'includes/public/quick-view/class-ekwc-quick-view-ajax-handler.php';
            require_once EKWC_PATH . 'includes/public/free-shipping-bar/class-ekwc-shipping-bar-frontend.php';
            require_once EKWC_PATH . 'includes/public/size-chart/class-ekwc-size-chart-ajax-handler.php';
            if( is_admin() ) :
                $this->includes_admin();
            else :
                $this->includes_public();
            endif;
        }

        /**
         * Include Admin required files.
         */
        public function includes_admin() {
            require_once EKWC_PATH . 'includes/class-ekwc-install.php';
            require_once EKWC_PATH . 'includes/admin/dashboard/views/class-ekwc-general-setting.php';
            require_once EKWC_PATH . 'includes/admin/dashboard/class-essential_kit-dashboard.php';
            require_once EKWC_PATH . 'includes/admin/settings/class-ekwc-admin-menu.php';
            require_once EKWC_PATH . 'includes/admin/settings/class-ekwc-size-chart-post-type.php';
        }

        /**
         * Include Public required files.
         */
        public function includes_public(){
            require_once EKWC_PATH . 'includes/public/product-compare/class-ekwc-compare-frontend.php';
            require_once EKWC_PATH . 'includes/public/wishlist/class-ekwc-wishlist-frontend.php';
            require_once EKWC_PATH . 'includes/public/wishlist/class-ekwc-wishlist-table.php';
            require_once EKWC_PATH . 'includes/public/quick-view/class-ekwc-quick-view-frontend.php';
            require_once EKWC_PATH . 'includes/public/class-ekwc-general.php';
            require_once EKWC_PATH . 'includes/public/size-chart/class-ekwc-size-chart-frontend.php';
            require_once EKWC_PATH . 'includes/public/size-chart/class-ekwc-size-chart-shortcode.php';
        }

        /**
         * Install the plugin tables.
         */
        public static function install() {
            self::create_wishlist_tables();
            self::default_data();
        }

        /**
         * Create Wishlist Tables in Database.
         */
        private static function create_wishlist_tables() {
            global $wpdb;
            $collate                = $wpdb->get_charset_collate();
            $wishlists_table        = $wpdb->prefix . 'ekwc_wishlists';
            $wishlist_item_table    = $wpdb->prefix . 'ekwc_wishlist_item'; 
        
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
            // Wishlist Table
            $sql1 = "CREATE TABLE {$wishlists_table} (
                ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                user_id BIGINT(20) UNSIGNED NULL DEFAULT NULL,
                session_id VARCHAR(255) DEFAULT NULL,
                wishlist_slug VARCHAR(200) NOT NULL,
                wishlist_name TEXT NULL,
                wishlist_token VARCHAR(64) NOT NULL UNIQUE,
                wishlist_privacy TINYINT(1) NOT NULL DEFAULT 0,
                dateadded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                expiration TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (ID),
                KEY wishlist_slug (wishlist_slug)
            ) $collate;";
 
            // Wishlist Item Table (updated table name and fields)
            $sql2 = "CREATE TABLE {$wishlist_item_table} (
                ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                prod_id BIGINT(20) UNSIGNED NOT NULL,
                user_id BIGINT(20) UNSIGNED,
                wishlist_id BIGINT(20) UNSIGNED NOT NULL,
                dateadded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (ID),
                KEY wishlist_id (wishlist_id),
                KEY prod_id (prod_id),
                KEY user_id (user_id)
            ) $collate;";
        
            dbDelta($sql1);
            dbDelta($sql2);
        }

        /**
         * Execute function on plugin activation
         */
        public static function default_data() {
            $defaultOptions = require_once EKWC_PATH . '/includes/static/ekwc-default-options.php';
            foreach ( $defaultOptions as $optionKey => $option ) :
                $existingOption = get_option( $optionKey );
                if ( ! $existingOption ) :
                    update_option( $optionKey, $option );
                endif;
            endforeach;    
        }

    }
endif;