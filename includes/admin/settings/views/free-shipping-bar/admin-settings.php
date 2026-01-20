<?php
defined('ABSPATH') || exit;

if( ! class_exists( 'EKWC_Shipping_Admin_Settings' ) ):

    /**
     * Class EKWC_Shipping_Admin_Settings
     * Handles the admin settings for the free shipping bar in WooCommerce.
     */
    class EKWC_Shipping_Admin_Settings {

        /**
         * Generates the general settings fields for the shipping bar.
         *
         * @return array The settings fields for the general configuration.
         */
        public static function general_field() {
            $fields = array(
                'enable' => array(
                    'title'      => esc_html__( 'Enable', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_shipping_bar_settings[enable]',
                    'desc'       => 'Enable/Disable display progressbar.',
                    'data_show'  => '.enable',
                ),

                'shipping_zone' => array(
                    'title'      => esc_html__( 'Free Shipping Zone', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'name'       => 'ekwc_shipping_bar_settings[shipping_zone]',
                    'default'    => '',
                    'options'    => self::get_default_shipping_zone(),
                    'desc'       => esc_html__( 'Please select the default shipping zone where the Free Shipping method is set. (*) Required', 'essential-kit-for-woocommerce' ),
                    'style'      => 'enable.yes',
                    'extra_class'=> 'enable',
                ),

                'mobile' => array(
                    'title'      => esc_html__( 'Mobile', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_shipping_bar_settings[mobile]',
                    'desc'       => 'Enable on mobile and tablet.',
                    'style'      => 'enable.yes',
                    'extra_class'=> 'enable',
                ),
                
            );   
            // Apply filter to allow modifications to the general fields.
            return $fields = apply_filters( 'ekwc_genral_shipping_fields', $fields );
        }

        /**
         * Generates the position settings fields for the shipping bar.
         *
         * @return array The settings fields for the position configuration.
         */
        public static function position_field() {
            $fields = array(
                'bar_position' => array(
                    'title'      => esc_html__( 'Topbar Position', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'name'       => 'ekwc_shipping_bar_settings[bar_position]',
                    'default'    => 'top_bar',
                    'options'    => array(
                        'top_bar'    => esc_html__( 'Top', 'essential-kit-for-woocommerce' ),
                        'bottom_bar' => esc_html__( 'Bottom', 'essential-kit-for-woocommerce' ),
                    ),
                ),

                'topbar_style' => array(
                    'title'      => esc_html__( 'Topbar Style', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'name'       => 'ekwc_shipping_bar_settings[topbar_style]',
                    'default'    => 'style1',
                    'options'    => array(
                        'style1' => esc_html__( 'Style 1', 'essential-kit-for-woocommerce' ),
                        'style2' => esc_html__( 'Style 2', 'essential-kit-for-woocommerce' ),
                    ),
                    'desc'       => wp_kses_post( 'To override this template copy this file from <code>essential-tool-for-woocommerce/topbar/conte-style{1-2}.php</code> to your theme folder.', 'essential-kit-for-woocommerce' ),
                ),

                'show_minicart' => array(
                    'title'       => esc_html__( 'Position on Mini Cart', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'show_cart' => array(
                    'title'       => esc_html__( 'Position on Cart Page', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'show_checkout' => array(
                    'title'       => esc_html__( 'Position on Checkout Page', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'checkout_style' => array(
                    'title'       => esc_html__( 'Checkout Page Style', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),

                'show_product' => array(
                    'title'       => esc_html__( 'Show on Single Product Page', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                ),
            );

            // Apply filter to allow modifications to the position fields.
            return apply_filters( 'ekwc_free_shipping_position_fields', $fields );
        }

        /**
         * Generates the style settings fields for the shipping bar.
         *
         * @return array The settings fields for the style configuration.
         */        
        public static function style_field() {
            $fields = array(
                'bg_color' => array(
                    'title'      => esc_html__('Background Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[bg_color]',
                    'default'    => '#d2f2ff',
                ),
                'text_color' => array(
                    'title'      => esc_html__('Text Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[text_color]',
                    'default'    => '#3e3f5e',
                ),
                'link_color' => array(
                    'title'      => esc_html__('Link Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[link_color]',
                    'default'    => '#83b834',
                ),
                'font_size' => array(
                    'title'      => esc_html__('Font Size', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcnumber',
                    'name'       => 'ekwc_shipping_bar_settings[font_size]',
                    'default'    => '18',
                    'desc'       => esc_html__('Font size in pixels', 'essential-kit-for-woocommerce'),
                ),
                'text_align' => array(
                    'title'      => esc_html__('Text Align', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcselect',
                    'name'       => 'ekwc_shipping_bar_settings[text_align]',
                    'default'    => 'center',
                    'options'    => array(
                        'left'   => esc_html__('Left', 'essential-kit-for-woocommerce'),
                        'center' => esc_html__('Center', 'essential-kit-for-woocommerce'),
                        'right'  => esc_html__('Right', 'essential-kit-for-woocommerce'),
                    ),
                ),
                'enable_progress' => array(
                    'title'      => esc_html__('Enable Progress', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'name'       => 'ekwc_shipping_bar_settings[enable_progress]',
                    'default'    => 'yes',
                    'desc'       => esc_html__('Enable/Disable progress bar', 'essential-kit-for-woocommerce'),
                    'data_show'  => '.enable_progress',
                ),
                'progress_bg_color' => array(
                    'title'      => esc_html__('Progress Background Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[progress_bg_color]',
                    'default'    => '#e7e7ef',
                    'style'      => 'enable_progress.yes',
                    'extra_class'=> 'enable_progress',
                ),
                'curr_progress_color' => array(
                    'title'      => esc_html__('Current Progress Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[curr_progress_color]',
                    'default'    => '#45defe',
                    'style'      => 'enable_progress.yes',
                    'extra_class'=> 'enable_progress',
                ),
                'progress_text_color' => array(
                    'title'      => esc_html__('Progress Text Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_shipping_bar_settings[progress_text_color]',
                    'default'    => '#ffffff',
                    'style'      => 'enable_progress.yes',
                    'extra_class'=> 'enable_progress',
                ),
                'single_product_bar_style' => array(
                    'title'      => esc_html__('Single Product Bar Style', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'sp_progress_bg_color' => array(
                    'title'       => esc_html__( 'Progress Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'sp_curr_progress_color' => array(
                    'title'       => esc_html__( 'Current Progress Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'sp_text_color' => array(
                    'title'       => esc_html__( 'Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),

                'mini_cart_bar_style' => array(
                    'title'      => esc_html__('Mini Cart Bar Style', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'mc_progress_bg_color' => array(
                    'title'       => esc_html__( 'Progress Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'mc_curr_progress_color' => array(
                    'title'       => esc_html__( 'Current Progress Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'mc_text_color' => array(
                    'title'       => esc_html__( 'Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                
                'cart_bar_style' => array(
                    'title'      => esc_html__('Cart Bar Style', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'cart_progress_bg_color' => array(
                    'title'       => esc_html__( 'Progress Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'cart_curr_progress_color' => array(
                    'title'       => esc_html__( 'Current Progress Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'cart_text_color' => array(
                    'title'       => esc_html__( 'Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                
                'checkout_bar_style' => array(
                    'title'      => esc_html__('Checkout Bar Style', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'checkout_progress_bg_color' => array(
                    'title'       => esc_html__( 'Progress Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'checkout_curr_progress_color' => array(
                    'title'       => esc_html__( 'Current Progress Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'checkout_text_color' => array(
                    'title'       => esc_html__( 'Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'default'     => 'no',
                ),
                'custom_css_title' => array(
                    'title'      => esc_html__('Custom CSS', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'custom_css' => array(
                    'title'      => esc_html__('Custom CSS', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctextarea',
                    'name'       => 'ekwc_shipping_bar_settings[custom_css]',
                    'default'    => '',
                    'rows'       => 8,
                    'desc'       => esc_html__('Add your custom CSS styles.', 'essential-kit-for-woocommerce'),
                ),
            );
        
            return apply_filters('ekwc_free_shipping_style_fields', $fields);
        }

        /**
         * Generates the notification settings fields for the shipping bar.
         *
         * @return array The settings fields for the notification configuration.
         */  
        public static function notificatons_field() {

            $fields = array(
                'announcement_notifications' => array(
                    'title'      => esc_html__('Announcement Notifications', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctextarea',
                    'name'       => 'ekwc_shipping_bar_settings[announcement_notifications]',
                    'default'    => 'Free shipping for billing over {min_amount}',
                    'desc'       => esc_html__('{min_amount}- Minimum order amount Free Shipping.', 'essential-kit-for-woocommerce')
                ),
                'purchased_notifications' => array(
                    'title'      => esc_html__('Purchased Notification', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctextarea',
                    'name'       => 'ekwc_shipping_bar_settings[purchased_notifications]',
                    'default'    => 'You have purchased {total_amounts} of {min_amount}',
                    'desc'       => wp_kses_post('{total_amounts}- The total amount of your purchases<br>
                                    {cart_qty}- Total quantity in cart.<br>
                                    {min_amount}- Minimum order amount Free Shipping.<br>
                                    {missing_amount}- The outstanding amount of the free shipping program.', 'essential-kit-for-woocommerce')
                ),
                'success_notifications' => array(
                    'title'      => esc_html__('Success Notifications', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctextarea',
                    'name'       => 'ekwc_shipping_bar_settings[success_notifications]',
                    'default'    => 'Congratulation! You have got free shipping. Go to {checkout_page}',
                    'desc'       => esc_html__('{checkout_page}- Cehckout page Link.', 'essential-kit-for-woocommerce'),
                ),
                'error_notifications' => array(
                    'title'      => esc_html__('Error Notifications', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctextarea',
                    'name'       => 'ekwc_shipping_bar_settings[error_notifications]',
                    'default'    => 'You are missing {missing_amount} to get Free Shipping. Continue {shopping}',
                    'desc'       => wp_kses_post('{missing_amount}-The outstanding amount of the free shipping program.<br>
                                    {shopping}-Link to shop page', 'essential-kit-for-woocommerce'),
                ),
            );

            return apply_filters( 'ekwc_shipping_notificatons_fields', $fields );
        }


        /**
         * Generates the effect settings fields for the shipping bar.
         *
         * @return array The settings fields for the effect configuration.
         */  
        public static function fsbwc_effect_field(){

            $fields = array(
                'intial_delay' => array(
                    'title'         => esc_html__('Initial Delay', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcnumber',
                    'name'          => 'ekwc_shipping_bar_settings[intial_delay]',
                    'default'       => '1',
                    'desc'          => esc_html__('(Enter value in seconds)', 'essential-kit-for-woocommerce'),
                    'min'           => 0,
                    'max'           => 10,
                ),
                'closebar_button' => array(
                    'title'         => esc_html__('Close Bar Button', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'default'       => 'no',
                ),
                'is_time_to_disappear' => array(
                    'title'         => esc_html__('Time to Disappear', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'default'       => 'no',
                ),
                'time_to_disappear' => array(
                    'title'         => esc_html__('Set Time to Disappear', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'default'       => 'no',
                ),
                'enable_gift_box' => array(
                    'title'         => esc_html__('Show Gift Box', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'name'          => 'ekwc_shipping_bar_settings[enable_gift_box]',
                    'data_show'     => '.enable_gift_box',
                    'default'       => 'no',
                    'desc'          => esc_html__('(Display gift box when customer adds product to cart)', 'essential-kit-for-woocommerce'),
                ),
                'giftbox_position' => array(
                    'title'         => esc_html__('Giftbox Position', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcselect',
                    'name'          => 'ekwc_shipping_bar_settings[giftbox_position]',
                    'default'       => 'bottom_right',
                    'options'       => array(
                        'top_left'     => esc_html__('Top Left', 'essential-kit-for-woocommerce'),
                        'top_right'    => esc_html__('Top Right', 'essential-kit-for-woocommerce'),
                        'bottom_left'  => esc_html__('Bottom Left', 'essential-kit-for-woocommerce'),
                        'bottom_right' => esc_html__('Bottom Right', 'essential-kit-for-woocommerce'),
                    ),
                    'style'         => 'enable_gift_box.yes',
                    'extra_class'   => 'enable_gift_box',
                ),
                'gift_icon_url' => array(
                    'title'         => esc_html__('Gift Icon URL', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwctext',
                    'name'          => 'ekwc_shipping_bar_settings[gift_icon_url]',
                    'default'       => EKWC_URL . 'assets/img/free-shipping-bar/free-shipping.png',
                    'desc'          => esc_html__('Enter the URL of the gift icon.', 'essential-kit-for-woocommerce'),
                    'style'         => 'enable_gift_box.yes',
                    'extra_class'   => 'enable_gift_box',
                ),
                'giftbox_style' => array(
                    'title'         => esc_html__('Giftbox Style', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'default'       => 'no',
                ),
            );
            
            return apply_filters( 'ekwc_free_shipping_effect_fields', $fields );

        }

        /**
         * Generates the dispaly rute settings fields for the shipping bar.
         *
         * @return array The settings fields for the dispaly rute configuration.
         */  
        public static function display_rules_field() {
            $fields = array(
                'home_page' => array(
                    'title'         => esc_html__('Home Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[home_page]',
                ),
                'cart_page' => array(
                    'title'         => esc_html__('Cart Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[cart_page]',
                ),
                'shop_page' => array(
                    'title'         => esc_html__('Shop Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[shop_page]',
                ),
                'checkout_page' => array(
                    'title'         => esc_html__('Checkout Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[checkout_page]',
                ),
                'single_product_page' => array(
                    'title'         => esc_html__('Single Product Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[single_product_page]',
                ),
                'product_cat_page' => array(
                    'title'         => esc_html__('Product Category Page', 'essential-kit-for-woocommerce'),
                    'field_type'    => 'ekwcswitch',
                    'default'       => 'no',
                    'name'          => 'ekwc_shipping_bar_settings[product_cat_page]',
                ),
            );
            return apply_filters( 'ekwc_free_shipping_display_rules_fields', $fields );
        }

        /**
         * Generates the report settings fields for the shipping bar.
         *
         * @return array The settings fields for the report configuration.
         */  
        public static function reports_field() {
            $fields = array(
                'continue_shopping_clicks' => array(
                    'title'      => esc_html__('Continue Shopping click', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcnumber',
                    'name'       => 'ekwc_shipping_bar_settings[continue_shopping_clicks]',
                    'default'    => '',
                ),
            );
            return apply_filters( 'ekwc_free_shipping_reports_fields', $fields );
        }        


        /**
         * Retrieves the default shipping zones in WooCommerce.
         *
         * This method creates a new shipping zone object and fetches all available shipping zones.
         * It returns an array of available shipping zones to be used in the settings.
         *
         * @return array The shipping zones.
         */
        public static function get_default_shipping_zone() {
            $zones = array();
            $zone  = new \WC_Shipping_Zone( 0 );
        
            // Add default zone
            $zones[ $zone->get_id() ] = $zone->get_data();
            $zones[ $zone->get_id() ]['formatted_zone_location'] = $zone->get_formatted_location();
            $zones[ $zone->get_id() ]['shipping_methods']        = $zone->get_shipping_methods();
        
            // Add user-configured zones
            $zones = array_merge( $zones, WC_Shipping_Zones::get_zones() );
        
            // Prepare an array for select options
            $shipping_zone_options = array();
        
            foreach ( $zones as $each_zone ) :
                if ( isset( $each_zone['id'] ) && $each_zone['id'] != 0 ) :
                    $zone_id         = $each_zone['id'];
                    $zone_name       = $each_zone['zone_name'];
                    $shipping_methods = $each_zone['shipping_methods'];
        
                    if ( is_array( $shipping_methods ) && count( $shipping_methods ) ) :
                        foreach ( $shipping_methods as $method ) :
                            if ( $method->id == 'free_shipping' ) :
                                $shipping_zone_options[ $zone_id ] = esc_html( $zone_name );
                                break; // Stop checking if free shipping is found
                            endif;
                        endforeach;
                    endif;
                endif;
            endforeach;
        
            return $shipping_zone_options;
        }
        

    }

endif;