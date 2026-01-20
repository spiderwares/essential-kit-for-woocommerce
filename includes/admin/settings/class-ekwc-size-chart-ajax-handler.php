<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'EKWC_Size_Chart_Ajax_Handler' ) ) :

    /**
     * Handles AJAX requests related to Size Charts in EKWC plugin.
     *
     * @since 1.0.0
     * @package Essential_Kit_For_WooCommerce
     */
    final class EKWC_Size_Chart_Ajax_Handler {

        /**
         * Initialize AJAX actions.
         */
        public function __construct() {
            add_action( 'wp_ajax_ekwc_search_size_chart', [ $this, 'handle_search_size_chart' ] );
            add_action( 'wp_ajax_ekwc_add_combined', [ $this, 'handle_add_combined_condition' ] );
            add_action( 'wp_ajax_ekwc_search_term', [ $this, 'handle_search_term' ] );
        }

        /**
         * AJAX: Search published size chart posts by title.
         */
        public function handle_search_size_chart() {
            $response = [];

            $search_term = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

            $query = new WP_Query( [
                'post_type'           => 'ekwc_size_chart',
                's'                   => $search_term,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'posts_per_page'      => 50,
            ] );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $title = get_the_title();
                    if ( mb_strlen( $title ) > 50 ) :
                        $title = mb_substr( $title, 0, 49 ) . '...';
                    endif;
                    $response[] = [ get_the_ID(), $title ];
                endwhile;
                wp_reset_postdata();
            endif;

            wp_send_json( $response );
        }

        /**
         * AJAX: Handle adding a combined condition (Pro only placeholder).
         *
         * @since 1.0.0
         */
        public function handle_add_combined_condition() {
            // Placeholder for combined condition logic (Pro feature).
            wp_send_json_success( [
                'message' => __( 'This feature is available in the Pro version.', 'essential-kit-for-woocommerce' ),
            ] );
        }

        /**
         * AJAX: Search taxonomy terms matching the query.
         */
        public function handle_search_term() {
            $response = [];

            $taxonomy  = isset( $_REQUEST['taxonomy'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['taxonomy'] ) ) : '';
            $term_name = isset( $_REQUEST['q'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['q'] ) ) : '';

            $terms = get_terms( [
                'taxonomy'   => $taxonomy,
                'orderby'    => 'id',
                'order'      => 'ASC',
                'hide_empty' => false,
                'fields'     => 'all',
                'name__like' => $term_name,
            ] );

            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) :
                foreach ( $terms as $term ) :
                    $response[] = [ $term->slug, $term->name ];
                endforeach;
            endif;

            wp_send_json( $response );
        }
    }

    // Initialize the AJAX handler.
    new EKWC_Size_Chart_Ajax_Handler();

endif;