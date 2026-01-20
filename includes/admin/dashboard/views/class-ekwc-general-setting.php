<?php
defined('ABSPATH') || exit;  // Exit if accessed directly

if( ! class_exists( 'EKWC_General_Setting' ) ):

    /**
     * Class EKWC_General_Setting
     * Admin settings for the quick view feature.
     */
    class EKWC_General_Setting {

        /**
         * General settings for Quick View.
         *
         * @return array Fields for Quick View settings.
         */
        public static function general_field() {
            $fields = array(
                'enable' => array(
                    'title'      => esc_html__( 'Enable Essential Kit', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_general_setting[enable]',
                    'desc'       => esc_html__( 'Enable Essential Kit For WooCommerce.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_compare' => array(
                    'title'      => esc_html__( 'Enable Compare Icon / Button', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_general_setting[enable_compare]',
                    'desc'       => esc_html__( 'Enable Compare Icon / Button.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_wishlist' => array(
                    'title'      => esc_html__( 'Enable Wishlist Icon / Button', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_general_setting[enable_wishlist]',
                    'desc'       => esc_html__( 'Enable Wishlist Icon / Button.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_quick_view' => array(
                    'title'      => esc_html__( 'Enable Quick View Icon / Button', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_general_setting[enable_quick_view]',
                    'desc'       => esc_html__( 'Enable Quick View Icon / Button.', 'essential-kit-for-woocommerce' ),
                ),


                'single_page_setting' => array(
                    'title'      => esc_html__( 'Single Page Setting', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'single_position' => array(
                    'title'      => esc_html__( 'Display Position On Single Page', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'woocommerce_product_thumbnails-0',
                    'name'       => 'ekwc_general_setting[single_position]',
                    'options'    => array(
                        'disable-0'                                     => esc_html__('Disable Button/Icon', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_product_thumbnails-0'              => esc_html__( 'Over The Image', 'essential-kit-for-woocommerce' ),
                        'woocommerce_before_single_product_summary-0'   => esc_html__( 'Top of Product Page', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-4'          => esc_html__( 'Before Product Title', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_single_product_summary-6'          => esc_html__( 'After Product Title', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_before_add_to_cart_form-10'        => esc_html__( 'After Short Description', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_before_add_to_cart_quantity-10'    => esc_html__( 'Before Quantity Input Field', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_after_add_to_cart_quantity-10'     => esc_html__( 'After Quantity Input Field', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_before_add_to_cart_button-10'      => esc_html__( 'Before Add to Cart Button', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_after_add_to_cart_button-10'       => esc_html__( 'After Add to Cart Button', 'essential-kit-for-woocommerce' ), 
                        'woocommerce_product_meta_end-10'               => esc_html__( 'After Product Meta Information', 'essential-kit-for-woocommerce' ), 
                    ),
                    'data_hide'  => '.single_position_option',
                    'desc'       => esc_html__( 'Choose how Button/Icon Position on single page.', 'essential-kit-for-woocommerce' ),
                ),
                'icon_position_single' => array(
                    'title'      => esc_html__( 'Icon Position in Single Page', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'top-right',
                    'name'       => 'ekwc_general_setting[icon_position_single]',
                    'options'    => array(
                        'top-left'     => esc_html__( 'Top Left', 'essential-kit-for-woocommerce' ),
                        'top-right'    => esc_html__( 'Top Right', 'essential-kit-for-woocommerce' ),
                        'bottom-left'  => esc_html__( 'Bottom Left', 'essential-kit-for-woocommerce' ),
                        'bottom-right' => esc_html__( 'Bottom Right', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'      => 'single_position.woocommerce_product_thumbnails-0',
                    'extra_class'=> 'single_position_option woocommerce_product_thumbnails-0',
                    'desc'       => esc_html__( 'Choose the position of icons on the single product page.', 'essential-kit-for-woocommerce' ),
                ),
                'icon_viewport_single' => array(
                    'title'      => esc_html__( 'Icon Position in Single Page', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'top-right',
                    'name'       => 'ekwc_general_setting[icon_viewport_single]',
                    'options'    => array(
                        'vertical'     => esc_html__( 'Vertical', 'essential-kit-for-woocommerce' ),
                        'horizontal'   => esc_html__( 'Horizontal', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'      => 'single_position.woocommerce_product_thumbnails-0',
                    'extra_class'=> 'single_position_option woocommerce_product_thumbnails-0',
                    'desc'       => esc_html__( 'Choose the position of icons on the single product page.', 'essential-kit-for-woocommerce' ),
                ),



                'shop_archive_page_setting' => array(
                    'title'      => esc_html__( 'Shop / Archive Page Setting', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'shop_position' => array(
                    'title'      => esc_html__( 'Display Position On Shop Page', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'woocommerce_before_shop_loop_item-10',
                    'name'       => 'ekwc_general_setting[shop_position]',
                    'options'    => array(
                        'disable-0'                                 => esc_html__( 'Disable Button/Icon', 'essential-kit-for-woocommerce' ),
                        'woocommerce_before_shop_loop_item-10'      => esc_html__( 'Over The Image', 'essential-kit-for-woocommerce' ),
                        'woocommerce_before_shop_loop_item_title-0' => esc_html__( 'After Featured Image/Before Title', 'essential-kit-for-woocommerce' ),
                        'woocommerce_after_shop_loop_item_title-0'  => esc_html__( 'After Title', 'essential-kit-for-woocommerce' ),
                        'woocommerce_after_shop_loop_item-1'        => esc_html__( 'Before Add to Cart', 'essential-kit-for-woocommerce' ),
                        'woocommerce_after_shop_loop_item-20'       => esc_html__( 'After Add to Cart', 'essential-kit-for-woocommerce' ),
                    ),
                    'data_hide'  => '.shop_position_option',
                    'desc'       => esc_html__( 'Choose how Button/Icon Position on single and archive page.', 'essential-kit-for-woocommerce' ),
                ),
                'icon_display_type' => array(
                    'title'      => esc_html__( 'Icon Display Type', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'fixed',
                    'name'       => 'ekwc_general_setting[icon_display_type]',
                    'options'    => array(
                        'fixed' => esc_html__( 'Fixed', 'essential-kit-for-woocommerce' ),
                        'hover' => esc_html__( 'On Hover', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'      => 'shop_position.woocommerce_before_shop_loop_item-10',
                    'extra_class'=> 'shop_position_option woocommerce_before_shop_loop_item-10',
                    'desc'       => esc_html__( 'Choose how icons should appear on product images.', 'essential-kit-for-woocommerce' ),
                ),
                'icon_position_shop' => array(
                    'title'      => esc_html__( 'Icon Position in Shop', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'top-right',
                    'name'       => 'ekwc_general_setting[icon_position_shop]',
                    'options'    => array(
                        'top-left'     => esc_html__( 'Top Left', 'essential-kit-for-woocommerce' ),
                        'top-right'    => esc_html__( 'Top Right', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'      => 'shop_position.woocommerce_before_shop_loop_item-10',
                    'extra_class'=> 'shop_position_option woocommerce_before_shop_loop_item-10',
                    'desc'       => esc_html__( 'Choose the position of icons in product loops (shop, category pages).', 'essential-kit-for-woocommerce' ),
                ),
                'icon_viewport_shop' => array(
                    'title'      => esc_html__( 'Icon Position in Shop', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'vertical',
                    'name'       => 'ekwc_general_setting[icon_viewport_shop]',
                    'options'    => array(
                        'vertical'     => esc_html__( 'Vertical', 'essential-kit-for-woocommerce' ),
                        'horizontal'   => esc_html__( 'Horizontal', 'essential-kit-for-woocommerce' ),
                    ),
                    'style'      => 'shop_position.woocommerce_before_shop_loop_item-10',
                    'extra_class'=> 'shop_position_option woocommerce_before_shop_loop_item-10',
                    'desc'       => esc_html__( 'Choose the position of icons on the single product page.', 'essential-kit-for-woocommerce' ),
                ),
            );
            
            return apply_filters( 'ekwc_general_fields', $fields );
        } 


        /**
         * Customization function to add text field options for icons
         * 
         * @return array Fields for customization of icons.
         */
        public static function style_field() {
            $fields = array(
                'icon_bg_color' => array(
                    'title'      => esc_html__( 'Icon Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'default'    => '#ffffff',
                    'name'       => 'ekwc_general_setting[icon_bg_color]',
                    'desc'       => esc_html__( 'Set the background color for the icons.', 'essential-kit-for-woocommerce' ),
                ),
                'icon_hover_bg_color' => array(
                    'title'      => esc_html__( 'Icon Hover Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'default'    => '#274c4f',
                    'name'       => 'ekwc_general_setting[icon_hover_bg_color]',
                    'desc'       => esc_html__( 'Set the background color for the icons on hover.', 'essential-kit-for-woocommerce' ),
                ),
                'compare_img' => array(
                    'title'      => esc_html__( 'Compare Icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'default'    => EKWC_URL . 'assets/img/compare.svg',
                    'name'       => 'ekwc_general_setting[compare_img]',
                    'desc'       => esc_html__( 'Customize the icon for the Compare icon on the product image.', 'essential-kit-for-woocommerce' ),
                ),
                'wishlist_img' => array(
                    'title'      => esc_html__( 'Wishlist Icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'default'    => EKWC_URL . 'assets/img/wishlist/heart-outline.svg',
                    'name'       => 'ekwc_general_setting[wishlist_img]',
                    'desc'       => esc_html__( 'Customize the icon for the Wishlist icon on the product image.', 'essential-kit-for-woocommerce' ),
                ),
                'quick_view_img' => array(
                    'title'      => esc_html__( 'Quick View Icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'default'    => EKWC_URL . 'assets/img/quick-view.svg',
                    'name'       => 'ekwc_general_setting[quick_view_img]',
                    'desc'       => esc_html__( 'Customize the icon for the Quick View icon on the product image.', 'essential-kit-for-woocommerce' ),
                ),
            );
            
            return apply_filters( 'ekwc_customization_fields', $fields );
        }
    
    }

endif;