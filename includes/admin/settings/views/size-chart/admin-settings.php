<?php
/**
 * Size Chart Admin Settings.
 *
 * @package Essential Kit for WooCommerce
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'EKWC_Size_Chart_Admin_Settings' ) ) :

    /**
     * EKWC Size Chart Admin Settings Class.
     */
    class EKWC_Size_Chart_Admin_Settings {

        /**
         * Returns general fields for the Size Chart settings.
         *
         * @return array
         */
        public static function general_field() {

            $fields = array(
                'popup_library' => array(
                    'title'      => esc_html__( 'Popup Library', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'magnific',
                    'name'       => 'ekwc_size_chart_setting[popup_library]',
                    'options'    => array(
                        'featherlight'      => esc_html__( 'Featherlight', 'essential-kit-for-woocommerce' ),
                        'magnific'          => esc_html__( 'Magnific', 'essential-kit-for-woocommerce' ),
                    ),
                    'data_hide'  => '.popup_library_option',
                    'desc'       => wp_kses_post( sprintf(
                        __( 'Read more about %1$s and %2$s. We recommend using the popup library that is already used in your theme or other plugins.', 'essential-kit-for-woocommerce' ),
                        '<a href="https://noelboss.github.io/featherlight/" target="_blank">Featherlight</a>',
                        '<a href="https://dimsemenov.com/plugins/magnific-popup/" target="_blank">Magnific</a>'
                    ) ),
                ),
                'effect' => array(
                    'title'         => esc_html__( 'Effect', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwcselect',
                    'name'          => 'ekwc_size_chart_setting[effect]',
                    'default'       => 'mfp-3d-unfold',
                    'options'       => array(
                        'mfp-fade'              => esc_html__( 'de', 'essential-kit-for-woocommerce' ),
                        'mfp-zoom-in'           => esc_html__( 'Zoom in', 'essential-kit-for-woocommerce' ),
                        'mfp-zoom-out'          => esc_html__( 'Zoom out', 'essential-kit-for-woocommerce' ),
                        'mfp-newspaper">'       => esc_html__( 'wspaper', 'essential-kit-for-woocommerce' ),
                        'mfp-move-horizontal'   => esc_html__( 'Move horizontal', 'essential-kit-for-woocommerce' ),
                        'mfp-move-from-top'     => esc_html__( 'Move from top', 'essential-kit-for-woocommerce' ),
                        'mfp-3d-unfold'         => esc_html__( '3d unfold', 'essential-kit-for-woocommerce' ),
                        'mfp-slide-bottom'      => esc_html__( 'Slide bottom', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'         => 'popup_library.magnific',
                    'extra_class'   => 'popup_library_option magnific',
                    'desc'          => esc_html__( 'Effect for popup.', 'essential-kit-for-woocommerce' ),
                ),
                'position' => array(
                    'title'      => esc_html__( 'Position', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'name'       => 'ekwc_size_chart_setting[position]',
                    'default'    => 'above_atc',
                    'options'    => array(
                        'disable-0'                                     => esc_html__( 'Disable', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_product_tabs-0'                    => esc_html__( 'In a new tab', 'essential-kit-for-woocommerce' ),
                        'woocommerce_single_product_summary-6'          => esc_html__( 'After Product Title', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-11'         => esc_html__( 'After Product Price', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-21'         => esc_html__( 'After Short Description', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-29'         => esc_html__( 'Before Add to Cart Button', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-31'         => esc_html__( 'After Add to Cart Button', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-41'         => esc_html__( 'After Product Meta Information', 'essential-kit-for-woocommerce' ), 
                    ),
                    'desc' => wp_kses_post( __( 'Choose the position to show the size-chart links on the single product page.', 'essential-kit-for-woocommerce' ) ),
                ),
                'label' => array(
                    'title'      => esc_html__( 'Label', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_size_chart_setting[label]',
                    'default'    => 'Size Charts',
                    'desc'       => esc_html__( 'Customize the label for the size chart link.', 'essential-kit-for-woocommerce' ),
                ),
            );
            
            return $fields = apply_filters( 'ekwc_size_chart_general_fields', $fields );
        }

        /**
         * Returns premium fields for the Size Chart settings.
         *
         * @return array
         */
        public static function premium_fields() {

            $fields = array(
                'use_combined_source' => array(
                    'title'      => esc_html__( 'Use Combined Source', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'product_type_rule' => array(
                    'title'      => esc_html__( 'Product Type Rule', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'product_visibility_rule' => array(
                    'title'      => esc_html__( 'Product Visibility Rule', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'product_tag_rule' => array(
                    'title'      => esc_html__( 'Product Tag Rule', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'shipping_class_rule' => array(
                    'title'      => esc_html__( 'Shipping Class Rule', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'premium_support' => array(
                    'title'      => esc_html__( 'Updates & Premium Support', 'size-chart-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),
            );

            return $fields = apply_filters( 'ekwc_size_chart_premium_fields', $fields );
        
        }

    }

endif;