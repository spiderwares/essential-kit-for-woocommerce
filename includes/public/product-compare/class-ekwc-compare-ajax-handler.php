<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( ! class_exists( 'EKWC_Compare_Ajax_Handler' ) ) :

    /**
     * Class EKWC_Compare_Ajax_Handler
     *
     * Handles AJAX requests for Compare Products.
     */
    class EKWC_Compare_Ajax_Handler {

        /**
         * Constructor.
         *
         * Initialize hooks.
         */
        public function __construct() {
            // Hook to handle AJAX requests.
            $this->event_handler();
        }

        /**
         * Register AJAX event handlers.
         */
        public function event_handler() {
            add_action( 'wp_ajax_ekwc_get_compare_products', array( $this, 'get_compare_products' ) );
            add_action( 'wp_ajax_nopriv_ekwc_get_compare_products', array( $this, 'get_compare_products' ) );
        }

        /**
         * Handle AJAX request for fetching compare products.
         */
        public function get_compare_products() {   
            // Verify nonce for security.
            if ( ! isset( $_POST['ekwc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ekwc_nonce'] ) ), 'ekwc_nonce' ) ) :
                wp_send_json_error( 'Nonce verification failed.' );
                exit;
            endif;


            
            // Check if product IDs are provided.
            if ( ! isset( $_POST['product_ids'] ) || ! is_array( $_POST['product_ids'] ) ) :
                wp_send_json_error( 'No product IDs provided.' );
                exit;
            endif;
            
            $product_ids = array_map( 'intval', $_POST['product_ids'] );
            $products    = [];

            $ekwc_compare_genral = get_option( 'ekwc_compare_genral' );
            $ekwc_compare_table  = get_option( 'ekwc_compare_table' );
            $ekwc_compare_style  = get_option( 'ekwc_compare_style' );
            $compare_style       = isset( $ekwc_compare_style['product_compare_style'] ) ? $ekwc_compare_style['product_compare_style'] : 'compare-table';
            $table_title         = isset( $ekwc_compare_table['compare_table_title'] ) ? $ekwc_compare_table['compare_table_title'] : '' ;
            $buy_pro_options     = [ 'buy-pro-2', 'buy-pro-3', 'buy-pro-4', 'buy-pro-5', 'buy-pro-6' ];

            // Check if compare style is a pro version style.
            if ( in_array( $compare_style, $buy_pro_options, true ) ) :
                $compare_style = 'compare-table';
            endif;

            // Loop through product IDs to get product data.
            foreach ( $product_ids as $product_id ) :

                $product = wc_get_product( $product_id );

                $image_url = wp_get_attachment_url( $product->get_image_id() ) ? wp_get_attachment_url( $product->get_image_id() ) : wc_placeholder_img_src();

                $average_rating = $product->get_average_rating();

                // Generate product rating HTML.
                if ( empty( $average_rating ) || 0 == $average_rating ) :
                    $rating_html = '<div class="star-rating" title="Rated 0 out of 5"><span style="width: 0%"><strong class="rating">0</strong> out of 5</span></div>';
                else :
                    $rating_html = wc_get_rating_html( $average_rating );
                endif;

                if ( $product ) :

                    $product_data = [
                        'id'           => $product->get_id(),
                        'title'        => $product->get_name(),
                        'image'        => $image_url,
                        'price'        => $product->get_price_html(),
                        'description'  => wp_trim_words( $product->get_description(), 15 ),
                        'sku'          => $product->get_sku(),
                        'availability' => $product->get_stock_status(),
                        'weight'       => $product->get_weight(),
                        'dimensions'   => $product->get_dimensions(),
                        'add_to_cart'  => do_shortcode( '[add_to_cart id="' . $product->get_id() . '" show_price="false"]' ),
                        'rating'       => $rating_html,
                    ];

                    // Filter attributes to display in comparison.
                    $pcwc_attributes = array_filter( $ekwc_compare_table, function( $key ) {
                        return strpos( $key, 'pcwc_attr_' ) === 0;
                    }, ARRAY_FILTER_USE_KEY );

                    if ( isset( $pcwc_attributes ) && is_array( $pcwc_attributes ) ) :
                        foreach ( $pcwc_attributes as $attr => $val ) :
                            if ( 'yes' === $val ) :
                                $attribute_slug  = str_replace( 'pcwc_attr_', '', $attr );
                                $attribute_value = $product->get_attribute( $attribute_slug );
                                $attribute_name  = wc_attribute_label( $attribute_slug, $product );

                                $product_data['attr'][ $attr ] = [
                                    'name'  => $attribute_name,
                                    'value' => $attribute_value,
                                ];
                            endif;
                        endforeach;
                    endif;

                    /**
                     * Filter product data before adding to compare list.
                     */
                    $product_data = apply_filters( 'ekwc_add_product_metadata', $product_data, $product, $ekwc_compare_table );

                    $products[] = $product_data;

                endif;

            endforeach;

            if ( ! empty( $products ) ) :

                $args = [
                    'products'              => $products,
                    'ekwc_compare_genral'   => $ekwc_compare_genral,
                    'ekwc_compare_table'    => $ekwc_compare_table,
                    'ekwc_compare_style'    => $ekwc_compare_style,
                    'table_title'           => $table_title,
                ];

                $args = apply_filters( 'ekwc_before_template_data', $args, $products );

                ob_start();

                $template_data = apply_filters( 'ekwc_compare_table_template', [
                    'path' => EKWC_TEMPLATE_PATH . 'product-compare/',
                    'file' => 'compare-table.php',
                ], $ekwc_compare_style );

                wc_get_template(
                    $template_data['file'],
                    $args,
                    '',
                    $template_data['path']
                );

                $table_html = ob_get_clean();

                wp_send_json_success( [ 'html' => $table_html ] );

            else :
                wp_send_json_error( 'No products found.' );
            endif;
        }
    }

    new EKWC_Compare_Ajax_Handler();

endif;