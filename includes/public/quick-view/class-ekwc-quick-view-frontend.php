<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

if ( ! class_exists( 'EKWC_Quick_View_Frontend' ) ) :

    class EKWC_Quick_View_Frontend {

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
            add_action( 'wp_footer', array( $this, 'add_modal' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_dynamic_styles' ) ); // Enqueue styles
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_quick_view_assets' ) );
        }

        /**
         * Add Modal to the footer
         */
        public function add_modal() {
            $modal_classes = apply_filters('ekwc_quick_view_modal_classes', 'ekwc-model');
        
            echo sprintf(
                '<div class="%s">
                    <div class="ekwc-model-content"></div>
                </div>',
                esc_attr($modal_classes)
            );
        }
    
        /**
         * Enqueue Dynamic Styles
         */
        public function enqueue_dynamic_styles() {
            // Generate the dynamic styles
            $styles = $this->generate_dynamic_styles();

            if ( ! empty( $styles ) ) :
                $handle = 'ekwc-quick-view';
                if ( ! wp_style_is( $handle, 'registered' ) ) :
                    wp_register_style( $handle, false, array(), EKWC_VERSION );
                    wp_enqueue_style( $handle ); 
                endif;

                wp_add_inline_style( 'ekwc-quick-view', $styles );
            endif;
        }
    
        /**
         * Generate Dynamic Styles based on settings
         *
         * @return string
         */
        public function generate_dynamic_styles() { 
            $general_style  = get_option( 'ekwc_general_setting', array() );
            $wishlist_style = get_option( 'ekwc_wishlist_setting', array() );
            $compare_style  = get_option( 'ekwc_compare_style', array() );
            $shipping_style = get_option( 'ekwc_shipping_bar_settings', array() );

            ob_start();
            wc_get_template( 
                'quick-view/dynamic-styles.php', 
                array( 
                    'general_style'     => $general_style,
                    'quick_view_style'  => $this->settings,
                    'wishlist_style'    => $wishlist_style,
                    'shipping_style'    => $shipping_style,
                    'compare_style'     => $compare_style,
                ),
                'essential-kit-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
            $output = ob_get_clean();

            return apply_filters( 'ekwc_dynamic_styles', $output, $this->settings );
        }

        /**
         * Enqueue frontend styles and scripts for the Quick View feature.
         */
        public function enqueue_quick_view_assets() {
                        
            wp_enqueue_script( 'wc-add-to-cart' );

            wp_enqueue_style( 
                'slick-theme', 
                EKWC_URL . 'assets/css/quick-view/slick-theme.css', 
                array(), 
                EKWC_VERSION 
            );
        
            wp_enqueue_style( 
                'slick', 
                EKWC_URL . 'assets/css/quick-view/slick.css', 
                array(), 
                EKWC_VERSION 
            );
        
            // Enqueue Slick Carousel JS (Local Copy)
            wp_enqueue_script( 
                'slick', 
                EKWC_URL . 'assets/js/quick-view/slick.js', 
                array( 'jquery' ), 
                EKWC_VERSION, 
                true 
            );

            // Enqueue the Quick View JavaScript file
            wp_enqueue_script( 
                'ekwc-quick-view-js', 
                EKWC_URL . 'assets/js/quick-view/ekwc-quick-view.js', 
                array( 'jquery', 'wc-add-to-cart' ), 
                EKWC_VERSION, 
                true 
            );

            // Enqueue the Quick View CSS file
            wp_enqueue_style( 
                'ekwc-quick-view-style', 
                EKWC_URL . 'assets/css/quick-view/ekwc-quick-view.css', 
                array(), 
                EKWC_VERSION 
            );
            
        }

    }
    
    new EKWC_Quick_View_Frontend();

endif;