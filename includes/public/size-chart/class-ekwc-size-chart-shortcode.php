<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Check if the class already exists to avoid redeclaration.
if ( ! class_exists( 'EKWC_Size_Chart_Shortcode' ) ) :

    /**
     * Class EKWC_Size_Chart_Shortcode
     *
     * Handles the frontend display of size charts on WooCommerce product pages.
     */
    class EKWC_Size_Chart_Shortcode {


        /**
         * Constructor to initialize hooks.
         */
        public function __construct() {
            $this->event_handler();
        }

        /**
         * Register frontend hooks and filters.
         */
        public function event_handler() {
            add_shortcode( 'ekwc_size_chart', [ $this, 'size_chart_shortcode' ] );
        }


        /**
         * Shortcode callback to render the size chart using wc_get_template().
         *
         * @param array $atts Shortcode attributes.
         * @return string HTML output.
         */
        public function size_chart_shortcode( $atts ) {
            $atts = shortcode_atts( [
                'id' => '',
            ], $atts, 'ekwc_size_chart' );

            $chart_id = intval( $atts['id'] );

            if ( ! $chart_id ) return '';

            $chart           = get_post( $chart_id );
            $top_description = get_post_meta( $chart_id, 'ekwc_top_description', true );
            $bottom_notes    = get_post_meta( $chart_id, 'ekwc_bottom_notes', true );
            $style           = get_post_meta( $chart_id, 'ekwc_size_chart_style', true );
            $table_data_raw  = get_post_meta( $chart_id, 'ekwc_table_data', true );
            $table_data      = json_decode( $table_data_raw, true );

            // Start buffering the output
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

            return ob_get_clean();
        }        

    }

    new EKWC_Size_Chart_Shortcode();

endif;