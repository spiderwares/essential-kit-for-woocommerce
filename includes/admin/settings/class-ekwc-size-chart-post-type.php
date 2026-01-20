<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

if ( ! class_exists( 'EKWC_Size_Chart_Post_Type' ) ) :

    /**
     * Main EKWC_Size_Chart_Post_Type Class
     *
     * @class EKWC_Size_Chart_Post_Type
     * @version 1.0.0
     */
    final class EKWC_Size_Chart_Post_Type {

        /**
         * Constructor for the class.
         */
        public function __construct() {
            add_action( 'init', [ $this, 'register_size_chart_cpt' ] );
            add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
            add_action( 'save_post', [ $this, 'save_size_chart_meta' ] );            
        }

        /**
         * Register the Size Chart custom post type.
         */
        public function register_size_chart_cpt() {

            $labels = [
                'name'                  => esc_html__( 'Size Charts', 'essential-kit-for-woocommerce' ),
                'singular_name'         => esc_html__( 'Size Chart', 'essential-kit-for-woocommerce' ),
                'menu_name'             => esc_html__( 'Size Charts', 'essential-kit-for-woocommerce' ),
                'name_admin_bar'        => esc_html__( 'Size Chart', 'essential-kit-for-woocommerce' ),
                'add_new'               => esc_html__( 'Add New', 'essential-kit-for-woocommerce' ),
                'add_new_item'          => esc_html__( 'Add New Size Chart', 'essential-kit-for-woocommerce' ),
                'edit_item'             => esc_html__( 'Edit Size Chart', 'essential-kit-for-woocommerce' ),
                'new_item'              => esc_html__( 'New Size Chart', 'essential-kit-for-woocommerce' ),
                'view_item'             => esc_html__( 'View Size Chart', 'essential-kit-for-woocommerce' ),
                'all_items'             => esc_html__( 'All Size Charts', 'essential-kit-for-woocommerce' ),
                'search_items'          => esc_html__( 'Search Size Charts', 'essential-kit-for-woocommerce' ),
                'not_found'             => esc_html__( 'No size charts found.', 'essential-kit-for-woocommerce' ),
                'not_found_in_trash'    => esc_html__( 'No size charts found in Trash.', 'essential-kit-for-woocommerce' ),
            ];

            $args = [
                'label'               => esc_html__( 'Size Chart', 'essential-kit-for-woocommerce' ),
                'labels'              => $labels,
                'supports'            => [ 'title' ],
                'hierarchical'        => false,
                'public'              => false,
                'show_ui'             => true,
                'menu_position'       => 28,
                'menu_icon'           => 'dashicons-chart-line',
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'show_in_rest'        => false,
            ];

            register_post_type( 'ekwc_size_chart', $args );
        }

        /**
         * Register meta boxes for the Size Chart custom post type.
         *
         * @return void
         */
        public function add_meta_boxes() {
            add_meta_box(
                'ekwc_content',                                                     
                esc_html__( 'Size Chart Content', 'essential-kit-for-woocommerce' ),
                [ $this, 'content_callback' ],                                      
                'ekwc_size_chart',
                'advanced',
                'low'
            );

            add_meta_box(
                'ekwc_shortcode',
                esc_html__( 'Shortcode', 'essential-kit-for-woocommerce' ),
                [ $this, 'shortcode_callback' ],
                'ekwc_size_chart',
                'side',
                'default'
            );

            add_meta_box(
                'ekwc_display_rules',
                esc_html__( 'Display Rules', 'essential-kit-for-woocommerce' ),
                [ $this, 'display_rules_callback' ], 
                'ekwc_size_chart',
                'advanced',
                'low'
            );

            add_meta_box(
                'ekwc_table_style',
                esc_html__( 'Table Style', 'essential-kit-for-woocommerce' ),
                [ $this, 'table_style_callback' ], 
                'ekwc_size_chart', 
                'advanced', 
                'low' 
            );
            
            
        }

        /**
         * Callback function for the Configuration meta box.
         *
         * @param WP_Post $post The current post object.
         *
         * @return void
         */
        public function content_callback( $post ) {
            $post_id            = $post->ID;
            $top_description    = get_post_meta( $post_id, 'ekwc_top_description', true );
            $bottom_notes       = get_post_meta( $post_id, 'ekwc_bottom_notes', true );
            $table_data         = get_post_meta( $post_id, 'ekwc_table_data', true ) ?: '[[""]]';
            $table_data_arr     = json_decode( $table_data );

            wc_get_template(
                'size-chart/content-meta-box.php',
                array(
                    'post_id'           => $post_id,
                    'top_description'   => $top_description,
                    'bottom_notes'      => $bottom_notes,
                    'table_data'        => $table_data,
                    'table_data_arr'    => $table_data_arr,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
            
        }
        
        /**
         * Callback function for the Shortcode meta box.
         *
         * @param WP_Post $post The current post object.
         *
         * @return void
         */
        public function shortcode_callback( $post ) {
            wc_get_template(
                'size-chart/shortcode-meta-box.php',
                array(
                    'post_id' => $post->ID,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        }

        /**
         * Callback function for the Display Rules meta box.
         *
         * @param WP_Post $post The current post object.
         */
        public function display_rules_callback( $post ) {
            $post_id = $post->ID;

            // Assign options list
            $assign_options = array(
                'none'               => esc_html__( 'None', 'essential-kit-for-woocommerce' ),
                'all'                => esc_html__( 'All Products', 'essential-kit-for-woocommerce' ),
                'products'           => esc_html__( 'Products', 'essential-kit-for-woocommerce' ),
                'product_cat'        => esc_html__( 'Product Categories', 'essential-kit-for-woocommerce' ),
                'combined'           => esc_html__( 'Combined (Premium)', 'essential-kit-for-woocommerce' ),
                'product_type'       => esc_html__( 'Product Type (Premium)', 'essential-kit-for-woocommerce' ),
                'product_visibility' => esc_html__( 'Product Visibility (Premium)', 'essential-kit-for-woocommerce' ),
                'product_tag'        => esc_html__( 'Product Tags (Premium)', 'essential-kit-for-woocommerce' ),
                'shipping_class'     => esc_html__( 'Product Shipping Class (Premium)', 'essential-kit-for-woocommerce' ),
            );

            $assign_options = apply_filters( 'ekwc_assign_options', $assign_options );

            // Get stored data
            $ekwc_data      = get_post_meta( $post_id, 'ekwc_data', true );
            $ekwc_assign    = $ekwc_data['assign'] ?? 'none';
            $ekwc_condition = $ekwc_data['condition'] ?? [];

            // Render template
            wc_get_template(
                'size-chart/display-rule-meta-box.php',
                array(
                    'post_id'        => $post_id,
                    'assign_options' => $assign_options,
                    'ekwc_assign'    => $ekwc_assign,
                    'ekwc_condition' => $ekwc_condition,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        }

        /**
         * Callback function for the Table Style meta box.
         *
         * @param WP_Post $post The current post object.
         *
         * @return void
         */
        public function table_style_callback( $post ) {
            $post_id = $post->ID;
        
            // Get the saved style data
            $style_data         = get_post_meta( $post_id, 'ekwc_size_chart_style', true );
                    
            // Set default values if the style data is empty
            $heading_bgcolor    = isset( $style_data['heading']['bgcolor'] ) ? esc_attr( $style_data['heading']['bgcolor'] ) : '#e0f2fe';
            $heading_color      = isset( $style_data['heading']['color'] ) ? esc_attr( $style_data['heading']['color'] ) : '#111827';
            $odd_row_bgcolor    = isset( $style_data['odd']['bgcolor'] ) ? esc_attr( $style_data['odd']['bgcolor'] ) : '#ffffff';
            $odd_row_color      = isset( $style_data['odd']['color'] ) ? esc_attr( $style_data['odd']['color'] ) : '#374151';
            $even_row_bgcolor   = isset( $style_data['even']['bgcolor'] ) ? esc_attr( $style_data['even']['bgcolor'] ) : '#f7f9fc';
            $even_row_color     = isset( $style_data['even']['color'] ) ? esc_attr( $style_data['even']['color'] ) : '#111827';
        
            // Correct the variable names when passing to wc_get_template
            wc_get_template(
                'size-chart/table-style-meta-box.php',
                array(
                    'post_id'             => $post_id,
                    'heading_bgcolor'     => $heading_bgcolor,
                    'heading_color'       => $heading_color,
                    'odd_row_bgcolor'     => $odd_row_bgcolor,
                    'odd_row_color'       => $odd_row_color,
                    'even_row_bgcolor'    => $even_row_bgcolor,
                    'even_row_color'      => $even_row_color,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        }


        /**
		 * Enqueue admin-specific styles for the dashboard.
		 */
		public function enqueue_scripts( $hook ) {
			wp_enqueue_script(
				'ekwc-size-chart-handler',
				EKWC_URL . '/assets/js/size-chart/ekwc-size-chart-handler.js',
				array( 'jquery', 'wc-enhanced-select', 'wp-color-picker' ), // Dependencies
				EKWC_VERSION,
				true // Load in footer
			);

			wp_enqueue_style(
				'select2-css',
				EKWC_URL . 'assets/css/select2.min.css',
				[],
				EKWC_VERSION
			);

			// Enqueue Select2 JS.
			wp_enqueue_script(
				'select2-js',
				EKWC_URL . 'assets/js/select2.min.js',
				[ 'jquery' ],
				EKWC_VERSION,
				true
			);
		}

        /**
         * Save meta box content for Size Chart Content.
         *
         * @param int $post_id Post ID.
         */
        public function save_size_chart_meta( $post_id ) {

            // Bail early on autosave, revision, or wrong post type.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( get_post_type( $post_id ) !== 'ekwc_size_chart' ) return;
            if ( ! current_user_can( 'edit_post', $post_id ) ) return;

            // Sanitize and save top description.
            if ( isset( $_POST['ekwc_top_description'] ) ) :
                $top_description = wp_kses_post( wp_unslash( $_POST['ekwc_top_description'] ) );
                update_post_meta( $post_id, 'ekwc_top_description', $top_description );
            endif;

            // Sanitize and save bottom notes.
            if ( isset( $_POST['ekwc_bottom_notes'] ) ) :
                $bottom_notes = wp_kses_post( wp_unslash($_POST['ekwc_bottom_notes'] ) );
                update_post_meta( $post_id, 'ekwc_bottom_notes', $bottom_notes );
            endif;

            // Save table data if valid JSON.
            if ( isset( $_POST['ekwc_table_data'] ) ) :
                $table_data = stripslashes( $_POST['ekwc_table_data'] );
                if ( json_decode( $table_data ) !== null ) :
                    update_post_meta( $post_id, 'ekwc_table_data', $table_data );
                endif;
            endif;

            // --- Save Display Rules ---
            $assign    = isset( $_POST['ekwc_assign'] ) ? sanitize_text_field( $_POST['ekwc_assign'] ) : 'none';
            $condition = array();

            switch ( $assign ) :
                case 'products':
                    if ( isset( $_POST['ekwc_assign_products'] ) && is_array( $_POST['ekwc_assign_products'] ) ) :
                        foreach ( $_POST['ekwc_assign_products'] as $product_id ) :
                            $product_id = absint( $product_id );
                            $product    = wc_get_product( $product_id );
                            if ( $product ) :
                                $condition[] = 'products:' . $product_id . ':' . $product->get_name();
                            endif;
                        endforeach;
                    endif;
                    break;
            
                case 'product_cat':
                    if ( isset( $_POST['ekwc_assign_product_cat'] ) && is_array( $_POST['ekwc_assign_product_cat'] ) ) :
                        foreach ( $_POST['ekwc_assign_product_cat'] as $cat_id ) :
                            $term = get_term( absint( $cat_id ), 'product_cat' );
                            if ( $term && ! is_wp_error( $term ) ) :
                                $condition[] = 'product_cat:' . $term->term_id . ':' . $term->name;
                            endif;
                        endforeach;
                    endif;
                    break;
            
                case 'product_type':
                    if ( isset( $_POST['ekwc_assign_product_type'] ) && is_array( $_POST['ekwc_assign_product_type'] ) ) :
                        foreach ( $_POST['ekwc_assign_product_type'] as $type ) :
                            $condition[] = 'product_type:' . sanitize_text_field( $type );
                        endforeach;
                    endif;
                    break;
            
                case 'product_visibility':
                    if ( isset( $_POST['ekwc_assign_product_visibility'] ) && is_array( $_POST['ekwc_assign_product_visibility'] ) ) :
                        foreach ( $_POST['ekwc_assign_product_visibility'] as $visibility ) :
                            $condition[] = 'product_visibility:' . sanitize_text_field( $visibility );
                        endforeach;
                    endif;
                    break;
            
                case 'product_tag':
                    if ( isset( $_POST['ekwc_assign_product_tag'] ) && is_array( $_POST['ekwc_assign_product_tag'] ) ) :
                        foreach ( $_POST['ekwc_assign_product_tag'] as $tag_id ) :
                            $term = get_term( absint( $tag_id ), 'product_tag' );
                            if ( $term && ! is_wp_error( $term ) ) :
                                $condition[] = 'product_tag:' . $term->term_id . ':' . $term->name;
                            endif;
                        endforeach;
                    endif;
                    break;
            
                case 'shipping_class':
                    if ( isset( $_POST['ekwc_assign_shipping_class'] ) && is_array( $_POST['ekwc_assign_shipping_class'] ) ) :
                        foreach ( $_POST['ekwc_assign_shipping_class'] as $class_id ) :
                            $term = get_term( absint( $class_id ), 'product_shipping_class' );
                            if ( $term && ! is_wp_error( $term ) ) :
                                $condition[] = 'shipping_class:' . $term->term_id . ':' . $term->name;
                            endif;
                        endforeach;
                    endif;
                    break;
            
                default:
                    $condition = array();
                    break;
            endswitch;

            $data = array(
                'assign'    => $assign,
                'condition' => $condition,
            );

            update_post_meta( $post_id, 'ekwc_data', $data );



            // Prepare the style data array
            $style_data = [
                'heading' => [
                    'bgcolor' => isset( $_POST['ekwc_size_chart_style']['heading']['bgcolor'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['heading']['bgcolor'] ) : '#e0f2fe',
                    'color'   => isset( $_POST['ekwc_size_chart_style']['heading']['color'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['heading']['color'] ) : '#111827',
                ],
                'odd' => [
                    'bgcolor' => isset( $_POST['ekwc_size_chart_style']['odd']['bgcolor'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['odd']['bgcolor'] ) : '#ffffff',
                    'color'   => isset( $_POST['ekwc_size_chart_style']['odd']['color'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['odd']['color'] ) : '#374151',
                ],
                'even' => [
                    'bgcolor' => isset( $_POST['ekwc_size_chart_style']['even']['bgcolor'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['even']['bgcolor'] ) : '#f7f9fc',
                    'color'   => isset( $_POST['ekwc_size_chart_style']['even']['color'] ) ? sanitize_hex_color( $_POST['ekwc_size_chart_style']['even']['color'] ) : '#111827',
                ],
            ];

            // Save the serialized data in a single meta field
            update_post_meta( $post_id, 'ekwc_size_chart_style', $style_data );

        }

        
    }

    // Instantiate the class.
    new EKWC_Size_Chart_Post_Type();

endif;