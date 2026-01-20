<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

// Check if the class already exists to avoid redeclaration.
if ( ! class_exists( 'EKWC_Size_Chart_Frontend' ) ) :

    /**
     * Class EKWC_Size_Chart_Frontend
     *
     * Handles the frontend display of size charts on WooCommerce product pages.
     */
    class EKWC_Size_Chart_Frontend {

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

            // Dynamically hook the size chart link based on settings.
            if ( ! empty( $this->setting['position'] ) && $this->setting['position'] !== 'disable-0' ) :
                list( $hook, $priority ) = explode( '-', $this->setting['position'] );
            
                $priority = (int) $priority;
            
                if ( $hook === 'woocommerce_product_tabs' ) :
                    add_filter( $hook, array( $this, 'add_size_chart_tab' ), $priority );
                else :
                    add_action( $hook, array( $this, 'render_size_chart_link' ), $priority );
                endif;
            endif;

            // Render popup container.
            add_action( 'wp_footer', array( $this, 'size_chart_popup' ) );

            // Enqueue required styles on the frontend.
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
        }

        /**
         * Get all published size chart posts.
         *
         * @return WP_Query
         */
        public function get_all_size_charts() {
            return new WP_Query( array(
                'post_type'      => 'ekwc_size_chart',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ) );
        }

        /**
         * Match applicable size charts to the given product.
         *
         * @param int $product_id Product ID.
         * @return array Array of matched size charts.
         */
        private function get_matching_size_charts( $product_id ) {
            $product_cats = wc_get_product_term_ids( $product_id, 'product_cat' );
            $charts       = $this->get_all_size_charts();
            $matched      = array();

            if ( $charts && ! empty( $charts->posts ) ) :
                foreach ( $charts->posts as $chart ) :
                    $display_data = get_post_meta( $chart->ID, 'ekwc_data', true );
                    $assign_type  = isset( $display_data['assign'] ) ? $display_data['assign'] : 'none';
                    $conditions   = isset( $display_data['condition'] ) ? $display_data['condition'] : array();

                    $is_match = false;

                    // Match chart based on assignment type.
                    switch ( $assign_type ) :
                        case 'products':
                            foreach ( $conditions as $cond ) :
                                $parts = explode( ':', $cond );
                                if ( isset( $parts[1] ) && (int) $parts[1] === $product_id ) :
                                    $is_match = true;
                                    break;
                                endif;
                            endforeach;
                            break;

                        case 'product_cat':
                            foreach ( $conditions as $cond ) :
                                $parts = explode( ':', $cond );
                                if ( isset( $parts[1] ) && in_array( (int) $parts[1], $product_cats, true ) ) :
                                    $is_match = true;
                                    break;
                                endif;
                            endforeach;
                            break;

                        case 'all':
                            $is_match = true;
                            break;

                        case 'none':
                        default:
                            $is_match = false;
                            break;
                    endswitch;

                    $is_match = apply_filters( 'ekwc_chart_match', $is_match, $chart, $product_id, $display_data );

                    // If matched, add the chart to the output.
                    if ( $is_match ) :
                        $table_data = get_post_meta( $chart->ID, 'ekwc_table_data', true );
                        if ( ! empty( $table_data ) ) :
                            $matched[] = array(
                                'chart'           => $chart,
                                'top_description' => get_post_meta( $chart->ID, 'ekwc_top_description', true ),
                                'bottom_notes'    => get_post_meta( $chart->ID, 'ekwc_bottom_notes', true ),
                                'style'           => get_post_meta( $chart->ID, 'ekwc_size_chart_style', true ),
                                'table_data'      => json_decode( $table_data, true ),
                            );
                        endif;
                    endif;

                endforeach;
            endif;

            return apply_filters( 'ekwc_matched_size_charts', $matched, $product_id );
        }

        /**
         * Add custom tab for size chart if applicable charts exist.
         *
         * @param array $tabs Existing WooCommerce tabs.
         * @return array Modified tabs with size chart tab added.
         */
        public function add_size_chart_tab( $tabs ) {
            global $product;

            $matching_charts = $this->get_matching_size_charts( $product->get_id() );

            if ( ! empty( $matching_charts ) ) :
                $tabs['ekwc_size_chart'] = array(
                    'title'    => esc_html( isset( $this->setting['label'] ) ? $this->setting['label'] : esc_html__( 'Size Chart', 'essential-kit-for-woocommerce' ) ),
                    'priority' => 50,
                    'callback' => array( $this, 'render_size_chart_tab_content' ),
                );
            endif;

            return $tabs;
        }

        /**
         * Render the content of the custom size chart tab.
         */
        public function render_size_chart_tab_content() {
            global $product;

            $matching_charts = $this->get_matching_size_charts( $product->get_id() );

            foreach ( $matching_charts as $data ) :
                wc_get_template(
                    'size-chart/display-size-chart.php',
                    array(
                        'top_description' => $data['top_description'],
                        'bottom_notes'    => $data['bottom_notes'],
                        'table_data'      => $data['table_data'],
                        'style'           => $data['style'],
                    ),
                    'essential-kit-for-woocommerce/',
                    EKWC_TEMPLATE_PATH
                );
            endforeach;
        }

        /**
         * Enqueue frontend CSS styles for the size chart display.
         */
        public function enqueue_frontend_assets() {
            wp_enqueue_style(
                'ekwc-size-chart-style',
                EKWC_URL . 'assets/css/size-chart/ekwc-size-chart-style.css',
                array(),
                EKWC_VERSION
            );

            wp_enqueue_script(
                'ekwc-size-chart-frontend',
                EKWC_URL . 'assets/js/size-chart/ekwc-size-chart-frontend.js',
                array('jquery'),
                EKWC_VERSION,
                true
            );
            
            if ( isset( $this->setting['popup_library'] ) && $this->setting['popup_library'] === 'featherlight' ):
                wp_enqueue_style(
                    'featherlight-css',
                    EKWC_URL . 'assets/css/size-chart/featherlight.min.css',
                    array(),
                    EKWC_VERSION
                );
                
                wp_enqueue_script(
                    'featherlight-js',
                    EKWC_URL . 'assets/js/size-chart/featherlight.min.js',
                    array('jquery'),
                    EKWC_VERSION,
                    true
                );
            endif;

            if ( isset( $this->setting['popup_library'] ) && $this->setting['popup_library'] === 'magnific' ):
                wp_enqueue_style(
                    'magnific-css',
                    EKWC_URL . 'assets/css/size-chart/magnific.min.css',
                    array(),
                    EKWC_VERSION
                );
                
                wp_enqueue_script(
                    'magnific-js',
                    EKWC_URL . 'assets/js/size-chart/magnific.min.js',
                    array('jquery'),
                    EKWC_VERSION,
                    true
                );
            endif;
        
            // Optional: Localize script if you need to pass data to JS
            wp_localize_script( 'ekwc-size-chart-frontend', 'ekwc_size_chart_vars', array(
                'ajax_url'  => admin_url('admin-ajax.php'),
                'setting'   => $this->setting,
                'nonce'     => wp_create_nonce('ekwc_size_chart_nonce'),
            ));
        }

        /**
         * Render the size chart link selector outside the tab.
         */
        public function render_size_chart_link() {
            global $product;

            if ( ! $product instanceof WC_Product ) :
                return;
            endif;

            $matching_charts = $this->get_matching_size_charts( $product->get_id() );

            if ( ! empty( $matching_charts ) ) :
                echo '<div class="ekwc-size-charts-list">';
                echo '<span class="ekwc-size-charts-list-label">' . ( isset( $this->setting['label'] ) ? esc_html( $this->setting['label'] ) . ':' : esc_html__( 'Size Charts', 'essential-kit-for-woocommerce' ) ) . '</span>';

                foreach ( $matching_charts as $chart_data ) :
                    if ( isset( $chart_data['chart'] ) && $chart_data['chart'] instanceof WP_Post ) :
                        $chart_id    = (int) $chart_data['chart']->ID;
                        $chart_title = esc_html( $chart_data['chart']->post_title );

                        echo '<a class="ekwc-btn ekwc-size-charts-list-item" data-id="' . $chart_id . '">' . $chart_title . '</a>';
                    endif;
                endforeach;

                echo '</div>';
            endif;
        }

        /**
         * Output the size chart popup container in footer.
         */
        public function size_chart_popup() { ?>
            <div id="ekwc-size-chart-popup" class="ekwc-size-chart-popup" style="display: none;">
                <div class="ekwc-popup-overlay"></div>
                <div class="ekwc-popup-content">
                    <button class="ekwc-close-popup" aria-label="<?php esc_attr_e( 'Close', 'essential-kit-for-woocommerce' ); ?>">&times;</button>
                    <div class="ekwc-popup-inner"></div>
                </div>
            </div>
            <?php
        }


    }

    // Instantiate the class.
    new EKWC_Size_Chart_Frontend();

endif;