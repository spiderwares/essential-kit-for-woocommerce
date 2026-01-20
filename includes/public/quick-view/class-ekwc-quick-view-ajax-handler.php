<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

if ( ! class_exists( 'EKWC_Quick_View_Ajax_Handler' ) ) :

    class EKWC_Quick_View_Ajax_Handler {

        /**
         * Holds plugin settings
         *
         * @var array
         */
        protected $settings;
    
        /**
         * Constructor - Initialize the class
         */
        public function __construct() {
            $this->settings = get_option( 'ekwc_quick_view_setting', array() ); // Fetch settings from options table
            $this->event_handler();
        }
    
        /**
         * Register event handlers and hooks
         */
        public function event_handler() { 
            // Register AJAX hooks
            add_action( 'wp_ajax_ekwc_load_quick_view', array( $this, 'quick_view_model' ) );
            add_action( 'wp_ajax_nopriv_ekwc_load_quick_view', array( $this, 'quick_view_model' ) );
        }


        /**
         * AJAX handler for loading Quick View content.
         */
        public function quick_view_model() {
            // verify nonce
            if ( ! isset( $_POST['ekwc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ekwc_nonce'] ) ), 'ekwc_nonce' ) ) :
                wp_send_json_error( 'Nonce verification failed.' );
                exit;
            endif;

            // Get product ID
            $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

            if ( ! $product_id ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid product ID.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            // Get product data
            $product = wc_get_product( $product_id );

            if ( ! $product ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Product not found.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            list( $file_path, $directory, $template_path ) = apply_filters( 'ekwc_quick_view_template_paths', [
                'quick-view/quick-view-popup.php',
                'essential-kit-for-woocommerce/', 
                EKWC_TEMPLATE_PATH
            ] );

            ob_start();

            // Load the Quick View template
            wc_get_template(
                $file_path,
                array( 
                    'product'   => $product ,
                    'settings'  => $this->settings,
                 ),
                $directory,
                $template_path
            );

            $html = ob_get_clean();

            wp_send_json_success( [ 'html' => $html ] );
        }

    }
    
    new EKWC_Quick_View_Ajax_Handler();

endif;