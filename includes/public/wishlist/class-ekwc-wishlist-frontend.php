<?php
/**
 * EKWC Wishlist Frontend Class
 * 
 * Handles the frontend display and functionality of the wishlist feature.
 * 
 * @package Essential Kit for WooCommerce
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; 

if ( ! class_exists( 'EKWC_Wishlist_Frontend' ) ) :

    /**
     * Class EKWC_Wishlist_Frontend
     *
     * Manages the display and interaction of the wishlist feature on the frontend.
     */
    class EKWC_Wishlist_Frontend {

        /**
         * Wishlist settings.
         *
         * @var array
         */
        private $wishlist_setting;

        /**
         * Constructor.
         *
         * Initializes the wishlist settings and sets up event handlers.
         */
        public function __construct() {
            $this->wishlist_setting = get_option( 'ekwc_wishlist_setting', [] ); 
            $this->event_handler();
        }

        /**
         * Registers actions based on the wishlist settings.
         */
        public function event_handler() {          
            // Enqueue frontend scripts and styles.
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
        }

        /**
         * Enqueues frontend scripts and styles for the wishlist.
         */
        public function enqueue_frontend_styles() {
            // Enqueue wishlist JavaScript file.
            wp_enqueue_script( 
                'ekwc-wishlist-js', 
                EKWC_URL . 'assets/js/wishlist/ekwc-wishlist-frontend.js', 
                array( 'jquery' ), 
                EKWC_VERSION, 
                true 
            );

            // Enqueue wishlist CSS file.
            wp_enqueue_style( 
                'ekwc-wishlist-style', 
                EKWC_URL . 'assets/css/wishlist/ekwc-wishlist-style.css', 
                array(), 
                EKWC_VERSION 
            );

            // Localize script with dynamic variables.
            wp_localize_script( 'ekwc-wishlist-js', 'ekwc_wishlist_vars', array(
                'ajax_url'              => admin_url( 'admin-ajax.php' ),
                'wishlist_nonce'        => wp_create_nonce( 'ekwc_wishlist_nonce' ),
                'is_user_logged_in'     => is_user_logged_in() ? 1 : 0,
                'wishlist_setting'      => get_option( 'ekwc_wishlist_setting' ),
                'quick_view_setting'    => get_option( 'ekwc_quick_view_setting' ),
                'checkout_url'          => wc_get_checkout_url(),
            ) );

            // Enqueue WooCommerce add-to-cart script.
            wp_enqueue_script( 'wc-add-to-cart' );
        }
    }

    // Initialize the Wishlist Frontend class.
    new EKWC_Wishlist_Frontend();

endif;
