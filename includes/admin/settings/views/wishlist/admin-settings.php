<?php
defined('ABSPATH') || exit;

if( ! class_exists( 'EKWC_Wishlist_Admin_Settings' ) ):

    class EKWC_Wishlist_Admin_Settings {

        public static function general_field() {
            $fields = array(
                'after_add_to_wishlist_action' => array(
                    'title'      => esc_html__( 'After product is added to wishlist', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => 'no',
                    'name'       => 'ekwc_wishlist_setting[after_add_to_wishlist_action]',
                    'options'    => array(
                        'added_to_wishlist_btn'   => esc_html__( 'Show Added to wishlist button', 'essential-kit-for-woocommerce' ),
                        'view_wishlist_link'      => esc_html__( 'Show View wishlist link', 'essential-kit-for-woocommerce' ),
                        'remove_from_list'        => esc_html__( 'Show Remove from list link', 'essential-kit-for-woocommerce' ),
                    ),
                    'desc'      => esc_html__( 'Choose what happens when a product is added to the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'multi_wishlist_feature' => array(
                    'title'       => esc_html__( 'Enable Multi-Wishlist Feature', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'button_text' => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description' => esc_html__( 'Get the Pro version to Enable Multi-Wishlist Feature.', 'essential-kit-for-woocommerce' ),
                    'default'     => 'no',
                ),
                'download_wishlist' => array(
                    'title'       => esc_html__( 'Download Wishlist', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'button_text' => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description' => esc_html__( 'Get the Pro version to Download Wishlist as PDF.', 'essential-kit-for-woocommerce' ),
                    'default'     => 'no',
                ),

            );
            
            return $fields = apply_filters( 'ekwc_wishlist_genral_fields', $fields );
        
        }


        public static function wishlist_page_field() {
            $fields = array(
                'wishlist_page' => array(
                    'title'      => esc_html__( 'Select Wishlist Page', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcselect',
                    'default'    => '',
                    'name'       => 'ekwc_wishlist_setting[wishlist_page]',
                    'options'    => self::get_pages_list(),
                    'desc'       => wp_kses_post( 'Pick a page as the main Wishlist page; make sure you add the <span class="code"><code>[ekwc_wishlist]</code></span> shortcode into the page content', 'essential-kit-for-woocommerce' ),
                ),
                'wishlist_table_setting' => array(
                    'title'      => esc_html__('Table Setting', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'ekwc_price_show' => array(
                    'title'      => esc_html__('Product price', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_price_show]',
                    'desc'       => esc_html__('Enable this option to display the product price in the wishlist.', 'essential-kit-for-woocommerce'),
                ),
                'ekwc_stock_show' => array(
                    'title'      => esc_html__('Product stock (availability)', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_stock_show]',
                    'desc'       => esc_html__('Enable this option to display product stock status (whether it is available or out of stock) in the wishlist.', 'essential-kit-for-woocommerce'),
                ),
                // 'ekwc_show_dateadded' => array(
                //     'title'       => esc_html__( 'Date added to wishlist', 'essential-kit-for-woocommerce' ),
                //     'field_type'  => 'ekwcbuypro',
                //     'pro_link'    => EKWC_PRO_VERSION_URL,
                //     'button_text' => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                //     'description' => esc_html__( 'Enable this option to show the date when the product was added to the wishlist.', 'essential-kit-for-woocommerce' ),
                //     'default'     => 'no',
                // ),
                'ekwc_add_to_cart_show' => array(
                    'title'      => esc_html__('Add to cart option', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_add_to_cart_show]',
                    'desc'       => esc_html__('Enable this option to show the "Add to Cart" button for each product in the wishlist.', 'essential-kit-for-woocommerce'),
                ),
                'ekwc_left_show_remove' => array(
                    'title'      => esc_html__('Remove icon (left side)', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_left_show_remove]',
                    'desc'       => esc_html__('Enable this option to show a remove icon to the left of the product in the wishlist.', 'essential-kit-for-woocommerce'),
                ),
                'ekwc_right_remove_button' => array(
                    'title'      => esc_html__('Remove button (right side)', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_wishlist_setting[ekwc_right_remove_button]',
                    'desc'       => esc_html__('Enable this option to display a "Remove" button to the right of the product in the wishlist.', 'essential-kit-for-woocommerce'),
                ),
                'ekwc_redirect_to_cart' => array(
                    'title'      => esc_html__('Redirect to cart', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_wishlist_setting[ekwc_redirect_to_cart]',
                    'desc'       => esc_html__('Redirect users to the cart page when they add a product to the cart from the wishlist page.', 'essential-kit-for-woocommerce'),
                ),
                'ekwc_remove_on_add_to_cart' => array(
                    'title'      => esc_html__('Remove items when added to the cart', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_wishlist_setting[ekwc_remove_on_add_to_cart]',
                    'desc'       => esc_html__('Remove the product from the wishlist after it has been added to the cart.', 'essential-kit-for-woocommerce'),
                ),
                'share_setting' => array(
                    'title'      => esc_html__('Share Setting', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'ekwc_share_wishlist' => array(
                    'title'      => esc_html__('Share wishlist', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_wishlist]',
                    'desc'       => esc_html__('Enable this option to let users share their wishlist on social media.', 'essential-kit-for-woocommerce'),
                    'data_show'  => '.ekwc_share_wishlist',
                ),
                'ekwc_share_facebook' => array(
                    'title'      => esc_html__('Share on Facebook', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_facebook]',
                    'desc'       => esc_html__('Allow users to share their wishlist on Facebook.', 'essential-kit-for-woocommerce'),
                    'style'      => 'ekwc_share_wishlist.yes',
                    'extra_class'=> 'ekwc_share_wishlist'
                ),
                'ekwc_share_twitter' => array(
                    'title'      => esc_html__('Tweet on Twitter (X)', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_twitter]',
                    'desc'       => esc_html__('Allow users to share their wishlist on Twitter (X).', 'essential-kit-for-woocommerce'),
                    'style'      => 'ekwc_share_wishlist.yes',
                    'extra_class'=> 'ekwc_share_wishlist'
                ),
                'ekwc_share_pinterest' => array(
                    'title'      => esc_html__('Pin on Pinterest', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_pinterest]',
                    'desc'       => esc_html__('Allow users to share their wishlist on Pinterest.', 'essential-kit-for-woocommerce'),
                    'style'      => 'ekwc_share_wishlist.yes',
                    'extra_class'=> 'ekwc_share_wishlist'
                ),
                'ekwc_share_email' => array(
                    'title'      => esc_html__('Share by email', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_email]',
                    'desc'       => esc_html__('Allow users to share their wishlist via email.', 'essential-kit-for-woocommerce'),
                    'style'      => 'ekwc_share_wishlist.yes',
                    'extra_class'=> 'ekwc_share_wishlist'
                ),
                'ekwc_share_whatsapp' => array(
                    'title'      => esc_html__('Share on WhatsApp', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_wishlist_setting[ekwc_share_whatsapp]',
                    'desc'       => esc_html__('Allow users to share their wishlist on WhatsApp.', 'essential-kit-for-woocommerce'),
                    'style'      => 'ekwc_share_wishlist.yes',
                    'extra_class'=> 'ekwc_share_wishlist'
                ),
            );
            
            return $fields = apply_filters( 'ekwc_wishlist_page_fields', $fields );
        
        }

        public static function style_field() {
            $fields = array(
                'wishlist_btn_bg_color' => array(
                    'title'      => esc_html__( 'Wishlist Button Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[wishlist_btn_bg_color]',
                    'default'    => '#ffffff',
                ),
                'wishlist_btn_text_color' => array(
                    'title'      => esc_html__( 'Wishlist Button Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[wishlist_btn_text_color]',
                    'default'    => '#cc5500',
                ),
                'wishlist_btn_hover_bg_color' => array(
                    'title'      => esc_html__( 'Wishlist Button Hover Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[wishlist_btn_hover_bg_color]',
                    'default'    => '#ff6600',
                ),
                'wishlist_btn_hover_text_color' => array(
                    'title'      => esc_html__( 'Wishlist Button Hover Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[wishlist_btn_hover_text_color]',
                    'default'    => '#ffffff',
                ),
                'add_to_wishlist_icon' => array(
                    'title'      => esc_html__( 'Add to wishlist icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[add_to_wishlist_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/heart-outline.svg',
                ),
                'added_to_wishlist_icon' => array(
                    'title'      => esc_html__( 'Added to wishlist icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[added_to_wishlist_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/heart.svg',
                ),
                'add_to_cart_setting' => array(
                    'title'      => esc_html__('Add To cart Button', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'add_to_cart_btn_text_color' => array(
                    'title'      => esc_html__('Add to Cart Button Text Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[add_to_cart_btn_text_color]',
                    'default'    => '#ffffff',
                ),
                'add_to_cart_btn_bg_color' => array(
                    'title'      => esc_html__('Add to Cart Button Background Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[add_to_cart_btn_bg_color]',
                    'default'    => '#ff6600',
                ),
                'add_to_cart_btn_hover_text_color' => array(
                    'title'      => esc_html__('Add to Cart Button Hover Text Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[add_to_cart_btn_hover_text_color]',
                    'default'    => '#ffffff',
                ),
                'add_to_cart_btn_hover_bg_color' => array(
                    'title'      => esc_html__('Add to Cart Button Hover Background Color', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwccolor',
                    'name'       => 'ekwc_wishlist_setting[add_to_cart_btn_hover_bg_color]',
                    'default'    => '#cc5500',
                ),
                'share_setting' => array(
                    'title'      => esc_html__('Share Icon Setting', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),
                'facebook_icon' => array(
                    'title'      => esc_html__( 'Facebook share button icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[facebook_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/facebook.svg',
                ),
                'twitter_icon' => array(
                    'title'      => esc_html__( 'Twitter (X) share button icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[twitter_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/twitter.svg',
                ),
                'pinterest_icon' => array(
                    'title'      => esc_html__( 'Pinterest share button icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[pinterest_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/pinterest.svg',
                ),
                'email_icon' => array(
                    'title'      => esc_html__( 'Email share button icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[email_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/email.png',
                ),
                'whatsapp_icon' => array(
                    'title'      => esc_html__( 'WhatsApp share button icon', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[whatsapp_icon]',
                    'default'    => EKWC_URL . 'assets/img/wishlist/whatsapp.png',
                ),
            );            
            
            return $fields = apply_filters( 'ekwc_wishlist_style_fields', $fields );
        }

        public static function localization_field() {

            $fields = array(
                'add_to_wishlist_text' => array(
                    'title'      => esc_html__( 'Add to Wishlist Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[add_to_wishlist_text]',
                    'default'    => esc_html__( 'Add to Wishlist', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Customize the text for the "Add to Wishlist" button.', 'essential-kit-for-woocommerce' ),
                ),
                'added_to_wishlist_text' => array(
                    'title'      => esc_html__( 'Product Added Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[added_to_wishlist_text]',
                    'default'    => esc_html__( 'Added to Wishlist', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Customize the text shown when a product is added to the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'remove_from_wishlist_text' => array(
                    'title'      => esc_html__( 'Remove from Wishlist Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[remove_from_wishlist_text]',
                    'default'    => esc_html__( 'Remove from Wishlist', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Customize the text for the "Remove from Wishlist" button.', 'essential-kit-for-woocommerce' ),
                ),
                'browse_wishlist_text' => array(
                    'title'      => esc_html__( 'Browse Wishlist Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[browse_wishlist_text]',
                    'default'    => esc_html__( 'Browse Wishlist', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Customize the text for the "Browse Wishlist" button.', 'essential-kit-for-woocommerce' ),
                ),
                'product_already_in_wishlist_text' => array(
                    'title'      => esc_html__( 'Product Already in Wishlist Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[product_already_in_wishlist_text]',
                    'default'    => esc_html__( 'The product is already in your wishlist!', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Customize the text displayed when a product is already in the wishlist.', 'essential-kit-for-woocommerce' ),
                ),
                'create_wishlist_btn_text' => array(
                    'title'       => esc_html__( 'Create Wishlist Button Text', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwcbuypro',
                    'pro_link'    => EKWC_PRO_VERSION_URL,
                    'button_text' => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'default'     => '',
                ),
                'wishlist_page' => array(
                    'title'      => esc_html__('Wishlist Page Label', 'essential-kit-for-woocommerce'),
                    'field_type' => 'ekwctitle',
                    'default'    => '',
                ),

                'default_wishlist_name' => array(
                    'title'      => esc_html__( 'Default Wishlist Name', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[default_wishlist_name]',
                    'default'    => esc_html__( 'My Wishlist', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Enter a name for the default wishlist. This will be automatically generated for all users if they do not create a custom one.', 'essential-kit-for-woocommerce' ),
                ),
                'wishlist_table_title' => array(
                    'title'      => esc_html__( 'Wishlist Table Title', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[wishlist_table_title]',
                    'default'    => esc_html__( 'Wishlists on Essential Kit', 'essential-kit-for-woocommerce' ),
                ),
                'wishlist_share_title' => array(
                    'title'      => esc_html__( 'Share Section Title', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[wishlist_share_title]',
                    'default'    => esc_html__( 'Share on:', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Share section title text.', 'essential-kit-for-woocommerce' ),
                ),
                'add_to_cart_text' => array(
                    'title'      => esc_html__( 'Add to Cart Button Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_wishlist_setting[add_to_cart_text]',
                    'default'    => esc_html__( 'Add to Cart', 'essential-kit-for-woocommerce' ),
                    'desc'       => esc_html__( 'Enter the text for the "Add to Cart" button.', 'essential-kit-for-woocommerce' ),
                ),
            );     

            return $fields = apply_filters( 'ekwc_wishlist_localization_fields', $fields );
        }

        /**
         * Get list of pages for Wishlist Page selection.
         */
        public static function get_pages_list() {
            $pages = get_pages();
            $page_options = array( '' => esc_html__( 'Select a Page', 'essential-kit-for-woocommerce' ) );

            if ( ! empty( $pages ) ) :
                foreach ( $pages as $page ) :
                    $page_options[$page->ID] = $page->post_title;
                endforeach;
            endif;

            return $page_options;
        }

    }

endif;