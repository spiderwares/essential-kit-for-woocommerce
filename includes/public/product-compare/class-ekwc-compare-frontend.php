<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

// Check if the class is not already defined.
if ( ! class_exists( 'EKWC_Compare_Frontend' ) ) :

    /**
     * EKWC_Compare_Frontend Class
     *
     * Handles the functionality of the product comparison feature on the frontend.
     */
    class EKWC_Compare_Frontend {

        private $compare_genral;
        private $theme_button_class;

        /**
         * Constructor to initialize properties and set up event handlers.
         */
        public function __construct() {
            $this->compare_genral       = get_option( 'ekwc_compare_genral' ); // Retrieve comparison settings.
            $this->theme_button_class   = $this->get_theme_button_class(); // Get the theme button class.
            $this->event_handler(); // Initialize the event handlers.
        }

        /**
         * Event handler to manage display of the compare button and assets.
         */
        public function event_handler() {
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
            add_action( 'wp_footer', array( $this, 'add_compare_table' ) );
        }

        /**
         * Retrieves the theme's button class, which can be filtered.
         *
         * @return string The button class.
         */
        private function get_theme_button_class() {
            return apply_filters( 'ekwc_theme_button_class', 'button woocommerce-button' );
        }

        /**
         * Adds the compare table to the footer of the page.
         */
        public function add_compare_table() {
            // Check if the lightbox should open automatically.
            $lightbox = isset( $this->compare_genral['open_auto_lightbox'] ) ? $this->compare_genral['open_auto_lightbox'] : 'no';

            // HTML structure for the compare table modal.
            $compare_table = '<div id="ekwc-compare-modal" class="ekwc-compare-modal" data-lightbox="' . esc_attr( $lightbox ) . '">
                                <div class="ekwc-compare-modal-content">
                                    <span class="ekwc-compare-modal-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="#0F1729"/>
                                        </svg>
                                    </span>
                                <div class="compare-table-container"></div>
                                </div>
                            </div>';

            // Output the compare table HTML.
            echo $compare_table;
        }

        /**
         * Enqueues the necessary frontend assets (JavaScript and CSS).
         */
        public function enqueue_frontend_assets() {
            wp_enqueue_script( 
                'ekwc-compare-js', 
                EKWC_URL . 'assets/js/product-compare/ekwc-compare.js', 
                array( 'jquery' ), 
                EKWC_VERSION, 
                true 
            );

            wp_enqueue_style( 
                'ekwc-frontend-style', 
                EKWC_URL . 'assets/css/product-compare/ekwc-frontend-style.css', 
                array(), 
                EKWC_VERSION 
            );

            wp_localize_script( 'ekwc-compare-js', 'ekwc_vars', array(
                'ekwc_nonce'    => wp_create_nonce( 'ekwc_nonce' ),
                'ajax_url'      => admin_url( 'admin-ajax.php' ),
                'cookie_name'   => 'wcpc_compare_products',
            ) );
        }
        
    }

    // Initialize the class.
    new EKWC_Compare_Frontend();

endif;