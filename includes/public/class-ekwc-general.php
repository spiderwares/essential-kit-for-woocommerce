<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

/**
 * Class EKWC_Genral
 * Handles general settings and product icons display for the Essential Kit for WooCommerce plugin.
 */
if ( ! class_exists( 'EKWC_Genral' ) ) :

    class EKWC_Genral {

        /**
         * General settings options.
         *
         * @var array
         */
        private $general_settings;

        /**
         * Theme Button Class options.
         *
         * @var array
         */
        private  $theme_button_class;

        /**
         * Compare General settings options.
         *
         * @var array
         */
        private $compare_genral;

        /**
         * Wishlist settings options.
         *
         * @var array
         */
        private $wishlist_setting;

        /**
         * Quick View settings options.
         *
         * @var array
         */
        private $qv_settings;


        /**
         * Constructor to initialize class properties and add action hooks.
         */
        public function __construct() {
            global $wpdb;
            $this->general_settings     = get_option( 'ekwc_general_setting', [] );
            $this->compare_genral       = get_option( 'ekwc_compare_genral' );
            $this->wishlist_setting     = get_option( 'ekwc_wishlist_setting', [] );
            $this->qv_settings          = get_option( 'ekwc_quick_view_setting', [] );
            $this->theme_button_class   = $this->get_theme_button_class();
            $this->event_handler();
        }

        public function event_handler(){
            $enable                     = isset( $this->general_settings['enable'] ) && 'yes' === $this->general_settings['enable'];
            $enable_compare             = isset( $this->general_settings['enable_compare'] ) && 'yes' === $this->general_settings['enable_compare'];
            $enable_wishlist            = isset( $this->general_settings['enable_wishlist'] ) && 'yes' === $this->general_settings['enable_wishlist'];
            $enable_quick_view          = isset( $this->general_settings['enable_quick_view'] ) && 'yes' === $this->general_settings['enable_quick_view'];
            $single_position            = isset($this->general_settings['single_position']) ? $this->general_settings['single_position'] : 'woocommerce_product_thumbnails-0';
            $shop_position              = isset($this->general_settings['shop_position']) ? $this->general_settings['shop_position'] : 'woocommerce_before_shop_loop_item-10';
            $single_hook                = ! empty( $single_position ) ? explode( '-', $single_position ) : array();
            $shop_hook                  = ! empty( $shop_position ) ? explode( '-', $shop_position ) : array();
            
        
            // If no icons are enabled, stop execution
            if ( ! $enable || ( ! $enable_compare && ! $enable_wishlist && ! $enable_quick_view ) ) :
                return;
            endif;

            if ( is_array( $single_hook ) ) :
                $single_priority    = isset( $single_hook[1] ) ? $single_hook[1] : 10;
                $single_hookname    = isset( $single_hook[0] ) ? $single_hook[0] : 'disable';
                
                if($single_hookname == 'woocommerce_product_thumbnails' ):
                    add_action( $single_hookname, array( $this, 'display_icons_on_product_image' ), $single_priority );
                else:
                    add_action( $single_hookname, array( $this, 'essential_kit_buttons' ), $single_priority );
                endif;
            endif;

            
            if ( is_array( $shop_hook ) ) :
                $shop_priority           = isset( $shop_hook[1] ) ? $shop_hook[1] : 10;
                $shop_hookname      = isset( $shop_hook[0] ) ? $shop_hook[0] : 'disable';
                
                if( $shop_hookname == 'woocommerce_before_shop_loop_item' ):
                    add_action( $shop_hookname, array( $this, 'display_icons_on_product_image' ), $shop_priority );
                else:
                    add_action( $shop_hookname, array( $this, 'essential_kit_buttons' ), $shop_priority );
                endif;
            endif;
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
         * Display icons (Compare, Wishlist, Quick View) on product images.
         */
        public function display_icons_on_product_image() {
            global $product, $wp_query;
        
            // Check if the product exists
            if ( ! $product ) :
                return;
            endif;
        
            // Check if this is the main single product (not a related product)
            $is_main_product        = is_product() && isset( $wp_query->queried_object_id ) && $wp_query->queried_object_id === $product->get_id();
            $is_in_loop             = wc_get_loop_prop('name') ? true : false;
            $icon_position_shop     = isset( $this->general_settings['icon_position_shop'] ) ? $this->general_settings['icon_position_shop'] : 'top-right';
            $icon_position_single   = isset( $this->general_settings['icon_position_single'] ) ? $this->general_settings['icon_position_single'] : 'top-right';
            $shop_viewport          = isset( $this->general_settings['icon_viewport_shop'] ) ? $this->general_settings['icon_viewport_shop'] : 'top-right';
            $single_viewport        = isset( $this->general_settings['icon_viewport_single'] ) ? $this->general_settings['icon_viewport_single'] : 'top-right';
            $display_type           = isset( $this->general_settings['icon_display_type'] ) ? $this->general_settings['icon_display_type'] : 'fixed';
        
            // Set class based on location
            if ( $is_main_product ) :
                $container_class = 'ekwc-single-product-icons';  // Main product page
                $icon_position   = $icon_position_single .' '. $single_viewport;
            else :
                $container_class = 'ekwc-loop-product-icons';  // Related products / Loop
                $icon_position   = $icon_position_shop .' '. $shop_viewport .' '. $display_type;
            endif;
        
            // Get the product ID
            $product_id = $product->get_id();

            echo '<div class="ekwc-product-icons-container ' . esc_attr( $container_class . ' ' . $icon_position ) . '">';

                do_action( 'ekwc_before_product_icons', $product_id );
            
                // Display Compare icon if enabled.
                if ( isset( $this->general_settings['enable_compare'] ) && 'yes' === $this->general_settings['enable_compare'] ) :
                    echo '<div class="ekwc-compare-icon ekwc-compare-button" data-product_id="' . esc_attr( $product_id ) . '">' . wp_kses_post($this->get_compare_icon()) . '</div>';
                endif;
                
                // Display Quick View icon only in loops !$is_main_product && 
                if ( isset( $this->general_settings['enable_quick_view'] ) && 'yes' === $this->general_settings['enable_quick_view'] ) :
                    echo '<div class="ekwc-quick-view-icon ekwc-quick-view" data-product_id="' . esc_attr( $product_id ) . '">' . wp_kses_post($this->get_quick_view_icon()) . '<img class="ekwc-loader" style="display: none;" src="' . esc_url( admin_url( 'images/spinner.gif' ) ) . '" alt="Loading..."></div>';
                endif;

                // Display Wishlist icon if enabled.
                if ( isset( $this->general_settings['enable_wishlist'] ) && 'yes' === $this->general_settings['enable_wishlist'] ) :
                    $this->get_wishlist_icon();
                endif;

                do_action( 'ekwc_after_product_icons', $product_id );
        
            echo '</div>';
        }


        /**
         * Get the compare icon SVG or custom image.
         *
         * @return string HTML markup for the compare icon.
         */
        public function get_compare_icon() {
            $compare_url = isset( $this->general_settings['compare_img'] ) ? $this->general_settings['compare_img'] : '';
            if ( ! empty( $compare_url ) ) :
                return '<img src="' . esc_url( $compare_url ) . '"/>';
            endif;

            // Check if the image URL is provided and valid
            return '
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="none">
                    <path d="M511.034 286.759L511.038 286.813L511.054 286.866C511.305 287.689 511.454 288.541 511.5 289.401C511.487 290.241 511.373 291.078 511.16 291.892L511.15 291.93L511.146 291.97C511.091 292.536 510.995 293.098 510.859 293.65C501.89 312.219 487.865 327.885 470.392 338.851C452.904 349.826 432.672 355.648 412.022 355.648C391.371 355.648 371.139 349.826 353.651 338.851C336.178 327.885 322.153 312.219 313.184 293.65C313.048 293.098 312.952 292.536 312.897 291.97L312.891 291.909L312.871 291.852C312.299 290.231 312.299 288.463 312.871 286.842L312.893 286.78L312.898 286.714C312.943 286.141 313.038 285.573 313.185 285.017L400.293 89.1576L400.559 88.5595L399.912 88.4602L267.276 68.1138L266.7 68.0254V68.608V489.739V490.239H267.2H378.584C381.406 490.239 384.112 491.359 386.107 493.353C388.102 495.346 389.223 498.05 389.223 500.87C389.223 503.689 388.102 506.393 386.107 508.386C384.112 510.38 381.406 511.5 378.584 511.5H133.539C130.717 511.5 128.011 510.38 126.016 508.386C124.021 506.393 122.901 503.689 122.901 500.87C122.901 498.05 124.021 495.346 126.016 493.353C128.011 491.359 130.717 490.239 133.539 490.239H244.923H245.423V489.739V65.2021V64.7729L244.999 64.7079L112.563 44.406L111.659 44.2673L112.031 45.1033L198.894 240.517C199.04 241.073 199.136 241.641 199.18 242.215L199.186 242.28L199.207 242.342C199.779 243.963 199.779 245.731 199.207 247.352L199.187 247.41L199.181 247.471C199.126 248.038 199.03 248.601 198.893 249.155C190.228 267.955 176.273 283.828 158.732 294.838C141.178 305.855 120.792 311.524 100.066 311.152L100.057 311.152L100.048 311.152C79.3328 311.526 58.9568 305.865 41.4077 294.859C23.8719 283.863 9.91672 268.006 1.24293 249.222C1.10607 248.668 1.00982 248.105 0.954989 247.537L0.949125 247.477L0.928835 247.419C0.357055 245.798 0.357055 244.03 0.928835 242.409L0.950719 242.347L0.955807 242.281C1.00027 241.708 1.09616 241.14 1.24229 240.584L89.7319 41.5416L89.9979 40.9432L89.3506 40.8442L34.1932 32.4073L34.193 32.4073C31.4024 31.9815 28.8954 30.4654 27.2236 28.1927C25.5517 25.9199 24.8518 23.0767 25.2779 20.2884C25.7039 17.5001 27.2209 14.995 29.4954 13.3243C31.7698 11.6535 34.6154 10.9541 37.406 11.3798L244.781 43.1906L245.356 43.2789V42.6964V11.1304C245.356 8.31118 246.477 5.60733 248.472 3.61371C250.467 1.62008 253.173 0.5 255.995 0.5C258.816 0.5 261.522 1.62008 263.517 3.61371C265.512 5.60733 266.633 8.31118 266.633 11.1304V46.1023V46.5315L267.057 46.5965L477.796 78.897L477.802 78.8978C480.475 79.2776 482.903 80.659 484.595 82.7617C486.287 84.8644 487.115 87.5311 486.912 90.2214C486.709 92.9117 485.49 95.4242 483.502 97.2498C481.514 99.0754 478.906 100.077 476.206 100.052H476.201C475.66 100.052 475.12 100.01 474.586 99.9249L474.584 99.9246L425.931 92.4672L425.027 92.3285L425.399 93.1646L510.747 285.061C510.893 285.617 510.989 286.185 511.034 286.759ZM30.3083 255.5H29.2833L29.9142 256.308C38.2177 266.939 48.8726 275.503 61.0434 281.33C73.2121 287.156 86.5655 290.086 100.057 289.891C113.549 290.086 126.902 287.156 139.071 281.33C151.241 275.503 161.896 266.939 170.2 256.308L170.831 255.5H169.806H30.3083ZM27.646 233.536L27.3333 234.239H28.1028H172.011H172.781L172.468 233.536L100.514 71.7217L100.057 70.6943L99.6001 71.7217L27.646 233.536ZM412.389 116.243L411.932 115.216L411.476 116.243L339.522 278.058L339.209 278.761H339.978H483.887H484.656L484.343 278.058L412.389 116.243ZM372.919 325.852C385.088 331.677 398.441 334.608 411.933 334.413C425.424 334.608 438.777 331.677 450.946 325.852C463.117 320.025 473.772 311.461 482.075 300.83L482.706 300.022H481.681H342.184H341.159L341.79 300.83C350.093 311.461 360.748 320.025 372.919 325.852Z" fill="black" stroke="black"></path>
                </svg>';
        }


        /**
         * Get the quick view icon SVG or custom image.
         *
         * @return string HTML markup for the quick view icon.
         */
        public function get_quick_view_icon() {
            $quick_view_url = isset( $this->general_settings['quick_view_img'] ) ? $this->general_settings['quick_view_img'] : '';
            if ( ! empty( $quick_view_url ) ) :
                return '<img src="' . esc_url( $quick_view_url ) . '" />';
            endif;

            // If no image is set, return the default SVG
            return '
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="view" height="24px" width="24px">
                    <path d="M12 5C7.064 5 3.308 8.058 1 12c2.308 3.942 6.064 7 11 7s8.693-3.058 11-7c-2.307-3.942-6.065-7-11-7zm0 12c-4.31 0-7.009-2.713-8.624-5C4.991 9.713 7.69 7 12 7c4.311 0 7.01 2.713 8.624 5-1.614 2.287-4.313 5-8.624 5z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>';
        }

        /**
         * Display the wishlist icon with dynamic states (added/not added).
         */
        public function get_wishlist_icon() {
            global $product;

            // Check if the product exists
            if ( ! $product ) :
                return;
            endif;
            $product_id     = $product->get_id();
            $wishlist_icon  = isset( $this->general_settings['wishlist_img'] ) ? $this->general_settings['wishlist_img'] : '';
            $added_icon     = isset( $this->wishlist_setting['added_to_wishlist_icon'] ) ? esc_url( $this->wishlist_setting['added_to_wishlist_icon'] ) : '';
            $wishlist_ids   = ekwc_get_wishlist_product_ids();
            $is_in_wishlist = in_array( $product_id, $wishlist_ids );
            $wishlist_icon  = $is_in_wishlist ? $added_icon : $wishlist_icon; 
            $loader_img     = esc_url( admin_url( 'images/spinner.gif' ) );
            $after_action   = isset( $this->wishlist_setting['after_add_to_wishlist_action'] ) ? $this->wishlist_setting['after_add_to_wishlist_action'] : 'added_to_wishlist_btn';
            
            if( isset( $this->wishlist_setting['multi_wishlist_feature'] ) && $this->wishlist_setting['multi_wishlist_feature'] === 'yes' && class_exists( 'EKWC_PRO' ) ):
                if( $is_in_wishlist ):
                    switch ( $after_action ) {
                        case 'view_wishlist_link':
                            $action_class = 'view_wishlist';
                            break;
                        case 'remove_from_list':
                            $action_class = 'ekwc-remove-wishlist';
                            break;
                        case 'added_to_wishlist_btn':
                        default:
                            $action_class = 'ekwc_multiselect_wishlist';
                            break;
                    }
                else:
                    $action_class = 'ekwc_multiselect_wishlist';
                endif;
            else:
                if( $is_in_wishlist ):
                    switch ( $after_action ) {
                        case 'view_wishlist_link':
                            $action_class = 'view_wishlist';
                            break;
                        case 'remove_from_list':
                            $action_class = 'ekwc-remove-wishlist';
                            break;
                        case 'added_to_wishlist_btn':
                        default:
                            $action_class = 'ekwc-wishlist-button';
                            break;
                    }
                else:
                    $action_class = 'ekwc-wishlist-button';
                endif;

            endif;
        
            // Display Wishlist Icon
            printf(                
                '<div class="ekwc-wishlist-icon %1$s" data-product-id="%2$s">
                    <img class="ekwc-loop-img" src="%3$s" alt="%4$s">
                    <img class="ekwc-loader" style="display: none;" src="%5$s" alt="Loading...">
                </div>',
                esc_attr( $action_class ),
                esc_attr( $product_id ),
                esc_url( $wishlist_icon ),
                esc_attr__( 'Wishlist', 'essential-kit-for-woocommerce' ),
                esc_attr( $loader_img ),
            );
        }

        /**
         * Displays the compare button on the product page (single or product list).
         */
        public function compare_button( $product_id ) {
            $compare_text       = isset( $this->compare_genral['compare_btn_text'] ) ? $this->compare_genral['compare_btn_text'] : esc_html__( 'Compare', 'essential-kit-for-woocommerce' );
            $compare_products   = isset( $_COOKIE['wcpc_compare_products'] ) ? json_decode( sanitize_text_field( wp_unslash( $_COOKIE['wcpc_compare_products'] ) ), true ) : []; 
            $compare_text       = in_array( $product_id, $compare_products ) ? esc_html__( 'Added to compare', 'essential-kit-for-woocommerce' ) : $compare_text;
            $loader_img         = esc_url( admin_url( 'images/spinner.gif' ) );
            $button_class       = 'ekwc-compare-button wp-element-button ' . esc_attr( $this->theme_button_class );
        
            $html = sprintf(
                '<div class="ekwc-compare-button-wrapper">
                    <button type="button" class="%s" data-product_id="%d">%s</button>
                </div>',
                esc_attr( $button_class ),
                esc_attr( $product_id ),
                esc_html( $compare_text ),
                esc_attr( $loader_img )
            );

            echo wp_kses_post( $html );
        }

        /**
         * Renders the wishlist button for a product.
         */
        public function wishlist_button( $product_id ) {
            $wishlist_setting   = $this->wishlist_setting;
            $wishlist_ids       = ekwc_get_wishlist_product_ids();
            $wishlist_page_id   = get_option( 'ekwc_wishlist_page_id' );
            $wishlist_url       = get_permalink( $wishlist_page_id );
        
            ob_start();
        
            // Load the wishlist button template.
            wc_get_template(
                'wishlist/wishlist-button.php',
                array(
                    'product_id'       => $product_id,
                    'wishlist_setting' => $wishlist_setting,
                    'wishlist_ids'     => $wishlist_ids,
                    'wishlist_url'     => $wishlist_url
                ),
                'essential-tool-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        
            $button_html = ob_get_clean();
            echo wp_kses_post( $button_html );
        }

        /**
         * Check if Quick View is enabled on mobile
         *
         * @return bool
         */
        public function is_quick_view_enabled_on_mobile() {
            return isset( $this->qv_settings['enable_on_mobile'] ) && $this->qv_settings['enable_on_mobile'] === 'yes';
        }

        /**
         * Display Quick View button on product pages
         */
        public function quick_view_btn( $product_id ) {
            if ( wp_is_mobile() && ! $this->is_quick_view_enabled_on_mobile() ) :
                return;
            endif;

            $button_label = isset( $this->qv_settings['quick_view_button_label'] ) 
                ? esc_html( $this->qv_settings['quick_view_button_label'] ) 
                : esc_html__( 'Quick View', 'essential-kit-for-woocommerce' );

            $html = sprintf(
                '<button class="wp-element-button ekwc-quick-view" data-product_id="%d">%s <span class="ekwc-loader"></span></button>',
                esc_attr( $product_id ),
                esc_html( $button_label )
            );

            echo wp_kses_post( $html );
        }

        /**
         * Display Essential Kit buttons (Compare, Quick View, Wishlist) on product pages.
         */
        public function essential_kit_buttons() {
            global $product;

            $product_id = $product->get_id();

            do_action( 'ekwc_before_buttons', $product_id );

            // Display Compare button if the Compare feature is enabled.
            if ( isset( $this->general_settings['enable_compare'] ) && 'yes' === $this->general_settings['enable_compare'] ) :
                $this->compare_button( $product_id );
            endif;

            // Display Quick View button if the Quick View feature is enabled.
            if ( isset( $this->general_settings['enable_quick_view'] ) && 'yes' === $this->general_settings['enable_quick_view'] ) :
                $this->quick_view_btn( $product_id );
            endif;

            // Display Wishlist button if the Wishlist feature is enabled.
            if ( isset( $this->general_settings['enable_wishlist'] ) && 'yes' === $this->general_settings['enable_wishlist'] ) :
                $this->wishlist_button( $product_id );
            endif;

            do_action( 'ekwc_after_essential_kit_buttons', $product_id );
        }


    }

    // Initialize the class.
    new EKWC_Genral();

endif;