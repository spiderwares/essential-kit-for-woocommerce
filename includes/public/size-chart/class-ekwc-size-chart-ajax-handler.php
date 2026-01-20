<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

// Check if the class already exists to avoid redeclaration.
if ( ! class_exists( 'EKWC_Size_Chart_Ajax_Handler' ) ) :

    /**
     * Class EKWC_Size_Chart_Ajax_Handler
     *
     * Handles the frontend display of size charts on WooCommerce product pages.
     */
    class EKWC_Size_Chart_Ajax_Handler {

        /**
         * Size Chart settings options.
         *
         * @var array
         */
        private $setting;

        /**
         * Constructor to initialize hooks.
         */
        public function __construct() {
            $this->setting = get_option( 'ekwc_size_chart_setting', [] );
            $this->event_handler();
        }

        /**
         * Register frontend hooks and filters.
         */
        public function event_handler() {
            // Enqueue required styles on the frontend.
            add_action( 'wp_ajax_ekwc_get_size_chart_content', [ $this, 'get_size_chart_content' ] );
            add_action( 'wp_ajax_nopriv_ekwc_get_size_chart_content', [ $this, 'get_size_chart_content' ] );
        }

        /**
         * Render the content of the custom size chart tab.
         */
        public function get_size_chart_content() {

            // Sanitize and validate post ID
            $post_id = isset( $_POST[ 'chart_id' ] ) ? absint( $_POST[ 'chart_id' ] ) : 0;
        
            if ( !$post_id || get_post_type( $post_id ) !== 'ekwc_size_chart' ) :
                wp_send_json_error(['message' => 'Invalid size chart ID.']);
            endif;
        
            $top_description = get_post_meta( $post_id, 'ekwc_top_description', true );
            $bottom_notes    = get_post_meta( $post_id, 'ekwc_bottom_notes', true );
            $style           = get_post_meta( $post_id, 'ekwc_size_chart_style', true );
            $table_data_json = get_post_meta( $post_id, 'ekwc_table_data', true ); // this was missing
            $table_data      = json_decode( $table_data_json, true );
        
            ob_start();
        
            wc_get_template(
                'size-chart/display-size-chart.php',
                array(
                    'top_description' => $top_description,
                    'bottom_notes'    => $bottom_notes,
                    'table_data'      => $table_data,
                    'style'           => $style,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        
            $output = ob_get_clean();
        
            wp_send_json_success( [ 'html' => $output ] );
        }        

    }

    new EKWC_Size_Chart_Ajax_Handler();

endif;