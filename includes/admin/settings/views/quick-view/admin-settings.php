<?php
defined('ABSPATH') || exit;  // Exit if accessed directly

if( ! class_exists( 'EKWC_Quick_View_Admin_Settings' ) ):

    /**
     * Class EKWC_Quick_View_Admin_Settings
     * Admin settings for the quick view feature.
     */
    class EKWC_Quick_View_Admin_Settings {

        /**
         * General settings for Quick View.
         *
         * @return array Fields for Quick View settings.
         */
        public static function general_field() {
            $fields = array(
                'enable_on_mobile' => array(
                    'title'      => esc_html__( 'Enable Quick View on mobile', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_quick_view_setting[enable_on_mobile]',
                    'desc'       => esc_html__( 'Enable Quick View on mobile devices.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_quick_view_wishlist' => array(
                    'title'      => esc_html__( 'Enable Quick View on wishlist', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable the Enable Quick View on wishlist', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
                'product_description' => array(
                    'title'      => esc_html__( 'Product Description', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'short',
                    'name'       => 'ekwc_quick_view_setting[product_description]',
                    'options'    => array(
                        'short' => esc_html__( 'Show short description', 'essential-kit-for-woocommerce' ),
                        'full'  => esc_html__( 'Show full description', 'essential-kit-for-woocommerce' ),
                    ),
                    'desc'       => esc_html__( 'Choose whether to display the short or full product description in Quick View.', 'essential-kit-for-woocommerce' ),
                ),
                'product_image_dimensions' => array(
                    'title'      => esc_html__( 'Product Image Dimensions', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcsize',
                    'default'    => array(
                        'width'  => 300,
                        'height' => 300,
                    ),
                    'name'       => 'ekwc_quick_view_setting[product_image_dimensions]',
                    'desc'       => esc_html__( 'Set the dimensions for the product image in Quick View.', 'essential-kit-for-woocommerce' ),
                ),
                'quick_view_style' => array(
                    'title'      => esc_html__( 'Quick View Style', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable the Quick View style', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
                'quick_view_button_label' => array(
                    'title'      => esc_html__( 'Quick View Button Label', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'default'    => esc_html__( 'Quick View', 'essential-kit-for-woocommerce' ),
                    'name'       => 'ekwc_quick_view_setting[quick_view_button_label]',
                    'desc'       => esc_html__( 'Customize the label of the Quick View button.', 'essential-kit-for-woocommerce' ),
                ),
            );
            
            return apply_filters( 'ekwc_quick_view_general_fields', $fields );
        }
        
        /**
         * Style settings for Quick View.
         *
         * @return array Fields for Quick View style settings.
         */
        public static function style_field() {
            $fields = array(
                'quick_view_section' => array(
                    'title'      => esc_html__('Quick View', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'content_background' => array(
                    'title'      => esc_html__('Content Background', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[content_background]',
                    'default'    => '#ffffff',
                ),
                'overlay_color' => array(
                    'title'      => esc_html__('Overlay Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[overlay_color]',
                    'default'    => '#000000',
                ),
                'overlay_opacity' => array(
                    'title'      => esc_html__('Overlay Opacity', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcnumber',
                    'name'       => 'ekwc_quick_view_setting[overlay_opacity]',
                    'default'    => '0.5',
                    'min'        => '0',
                    'max'        => '1',
                    'step'       => '0.1',
                ),
                'close_icon_section' => array(
                    'title'      => esc_html__('Close Icon', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'close_icon_color' => array(
                    'title'      => esc_html__('Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[close_icon_color]',
                    'default'    => '#cdcdcd',
                ),
                'close_icon_hover' => array(
                    'title'      => esc_html__('Color Hover', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[close_icon_hover]',
                    'default'    => '#ff0000',
                ),
                'quick_view_button_section' => array(
                    'title'      => esc_html__('Quick View Button', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'button_bg_color' => array(
                    'title'      => esc_html__('Background Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[button_bg_color]',
                    'default'    => '#000000',
                ),
                'button_bg_hover' => array(
                    'title'      => esc_html__('Background Hover', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[button_bg_hover]',
                    'default'    => '#000000',
                ),
                'button_text_color' => array(
                    'title'      => esc_html__('Text Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[button_text_color]',
                    'default'    => '#ffffff',
                ),
                'button_text_hover' => array(
                    'title'      => esc_html__('Text Hover', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_quick_view_setting[button_text_hover]',
                    'default'    => '#ffffff',
                ),
                'content_section' => array(
                    'title'      => esc_html__('Content style', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'main_text_color' => array(
                    'title'      => esc_html__( 'Main Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Main Text Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

                'star_color' => array(
                    'title'      => esc_html__( 'Star Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Star Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

                'add_to_cart_btn_bg_color' => array(
                    'title'      => esc_html__( 'Add to Cart Button Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Add to Cart Button Background Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

                'add_to_cart_btn_bg_hover_color' => array(
                    'title'      => esc_html__( 'Add to Cart Button Background Hover Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Add to Cart Button Background Hover Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

                'add_to_cart_text_color' => array(
                    'title'      => esc_html__( 'Add to Cart Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Add to Cart Text Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

                'add_to_cart_text_hover_color' => array(
                    'title'      => esc_html__( 'Add to Cart Text Hover Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'description'=> esc_html__( 'Get the Pro version to enable Add to Cart Text Hover Color', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),

            );
            
            return apply_filters('ekwc_quick_view_style_fields', $fields);
        }

        /**
         * Advanced settings for Quick View.
         *
         * @return array Fields for Quick View advanced settings.
         */
        public static function advance_field() {

            $fields = array(
                'show_product_image' => array(
                    'title'      => esc_html__( 'Show Product Image', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to show product images in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'show_product_name' => array(
                    'title'      => esc_html__( 'Show Product Name', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to show product names in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'show_product_rating' => array(
                    'title'      => esc_html__( 'Show Product Rating', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to display product ratings in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'show_product_price' => array(
                    'title'      => esc_html__( 'Show Product Price', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to display product prices in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'show_add_to_cart' => array(
                    'title'      => esc_html__( 'Show "Add to Cart" Button', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to show the "Add to Cart" button for wishlist items.', 'essential-kit-for-woocommerce' ),
                ),
                'show_wishlist_button' => array(
                    'title'      => esc_html__( 'Show Wishlist Button', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to display the wishlist button.', 'essential-kit-for-woocommerce' ),
                ),
                'show_product_meta' => array(
                    'title'      => esc_html__( 'Show Product Meta', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to show additional product meta information in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'button_section' => array(
                    'title'      => esc_html__('After Add to Cart Actions', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'close_popup_after_add_to_cart' => array(
                    'title'      => esc_html__( 'Close Popup After Adding to Cart', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to automatically close the popup after adding a product to the cart.', 'essential-kit-for-woocommerce' ),
                ),
                'redirect_to_checkout_after_add_to_cart' => array(
                    'title'      => esc_html__( 'Redirect to Checkout After Adding to Cart', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to redirect users to checkout after adding a product to the cart.', 'essential-kit-for-woocommerce' ),
                ),
                'sharing_section' => array(
                    'title'      => esc_html__('Sharing options', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'enable_facebook_share' => array(
                    'title'      => esc_html__( 'Enable Facebook Share', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to allow sharing wishlists on Facebook.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_x_share' => array(
                    'title'      => esc_html__( 'Enable X (Twitter) Share', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to allow sharing wishlists on X (formerly Twitter).', 'essential-kit-for-woocommerce' ),
                ),
                'enable_pinterest_share' => array(
                    'title'      => esc_html__( 'Enable Pinterest Share', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to allow sharing wishlists on Pinterest.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_email_share' => array(
                    'title'      => esc_html__( 'Enable Email Share', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to allow sharing wishlists via email.', 'essential-kit-for-woocommerce' ),
                ),
                'enable_whatsapp_share' => array(
                    'title'      => esc_html__( 'Enable WhatsApp Share', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'default'    => 'no',
                    'desc'       => esc_html__( 'Enable to allow sharing wishlists on WhatsApp.', 'essential-kit-for-woocommerce' ),
                ),
            );
        
            return apply_filters( 'ekwc_quick_view_advance_fields', $fields );
        }

    }

endif;