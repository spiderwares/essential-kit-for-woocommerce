<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

// Check if the class EKWC_Compare_Admin_Settings does not exist to avoid redeclaration.
if( ! class_exists( 'EKWC_Compare_Admin_Settings' ) ):

    /**
     * Class EKWC_Compare_Admin_Settings
     * This class contains methods to define and return the various fields for the product comparison settings.
     */
    class EKWC_Compare_Admin_Settings {

        /**
         * Define and return general fields for the product comparison settings.
         * 
         * @return array $fields The general fields for the comparison settings.
         */
        public static function general_field() {
            $fields = array(
                'compare_btn_text' => array(
                    'title'      => esc_html__( 'Compare Button Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_compare_genral[compare_btn_text]',
                    'default'    => esc_html__( 'Compare Product', 'essential-kit-for-woocommerce' ),
                ),
                'remove_btn_text' => array(
                    'title'      => esc_html__( 'Button Remove Text', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_compare_genral[remove_btn_text]',
                    'default'    => esc_html__( 'Remove', 'essential-kit-for-woocommerce' )
                ),
                'open_auto_lightbox' => array(
                    'title'      => esc_html__( 'Open Automatically Lightbox', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'no',
                    'name'       => 'ekwc_compare_genral[open_auto_lightbox]',
                    'desc'       => 'Automatically open the lightbox when clicking on the compare button.'
                ),
            );
            
            // Allow other plugins to modify the general fields.
            return $fields = apply_filters( 'ekwc_compare_genral_fields', $fields );
        
        }

        /**
         * Define and return fields for the product comparison table.
         * 
         * @return array $fields The fields for the comparison table settings.
         */
        public static function table_field() {

            // Fetch all attribute taxonomies from WooCommerce.
            $attributes = wc_get_attribute_taxonomies();
        
            $fields = array(
                'compare_table_title' => array(
                    'title'      => esc_html__( 'Table Title', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwctext',
                    'name'       => 'ekwc_compare_table[compare_table_title]',
                    'default'    => esc_html__( 'Product Comparison', 'essential-kit-for-woocommerce' ),
                ),
                'show_image' => array(
                    'title'      => esc_html__( 'Show Image', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_image]',
                    'desc'       => 'Enable or disable the display image on compare table.'
                ),
                'show_title' => array(
                    'title'      => esc_html__( 'Show Title', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_title]',
                    'desc'       => 'Enable or disable the product title in the compare table.'
                ),
                'show_price' => array(
                    'title'      => esc_html__( 'Show Price', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_price]',
                    'desc'       => 'Enable or disable the product price in the compare table.'
                ),
                'show_rating' => array(
                    'title'      => esc_html__( 'Show Rating', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_rating]',
                    'desc'       => 'Enable or disable the product rating in the compare table.'
                ),
                'show_description' => array(
                    'title'      => esc_html__( 'Show Description', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_description]',
                    'desc'       => 'Enable or disable the product description in the compare table.'
                ),
                'show_sku' => array(
                    'title'      => esc_html__( 'Show SKU', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_sku]',
                    'desc'       => 'Enable or disable the product SKU in the compare table.'
                ),
                'show_availability' => array(
                    'title'      => esc_html__( 'Show Availability', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_availability]',
                    'desc'       => 'Enable or disable product stock availability in the compare table.'
                ),
                'show_weight' => array(
                    'title'      => esc_html__( 'Show Weight', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_weight]',
                    'desc'       => 'Enable or disable the product weight in the compare table.'
                ),
                'show_dimensions' => array(
                    'title'      => esc_html__( 'Show Dimensions', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_dimensions]',
                    'desc'       => 'Enable or disable product dimensions in the compare table.'
                ),
                'show_add_to_cart' => array(
                    'title'      => esc_html__( 'Show Add to Cart', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcswitch',
                    'default'    => 'yes',
                    'name'       => 'ekwc_compare_table[show_add_to_cart]',
                    'desc'       => 'Enable or disable the Add to Cart button in the compare table.'
                ),
        
            );
        
            // Loop through attributes and add fields for each one.
            if ( ! empty( $attributes ) ) :
                foreach ( $attributes as $attribute ) :
                    $attribute_slug = $attribute->attribute_name;
                    $fields['pcwc_attr_'.$attribute_slug ] = array(
                        // Translators: %s is replaced with the attribute label.
                        'title'      => sprintf( esc_html__( 'Show %s', 'essential-kit-for-woocommerce' ), wc_attribute_label( $attribute_slug ) ),
                        'field_type' => 'ekwcswitch',
                        'default'    => 'no',
                        'name'       => 'ekwc_compare_table[pcwc_attr_'.$attribute_slug.']',
                        // Translators: %s is replaced with the attribute label.
                        'desc'       => sprintf( esc_html__( 'Enable or disable the attribute %s in the compare table.', 'essential-kit-for-woocommerce' ), wc_attribute_label( $attribute_slug ) ),
                    );
                endforeach;
            endif;      
            
            // Add a field for enabling the Pro version for additional features.
            $fields['product_meta'] = array(
                'title'      => esc_html__( 'Add Product Meta', 'essential-kit-for-woocommerce' ),
                'field_type' => 'ekwcbuypro',
                'pro_link'   => EKWC_PRO_VERSION_URL,
                'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                'description'=> esc_html__( 'Get the Pro version to enable the Add Product Meta.', 'essential-kit-for-woocommerce' ),
                'default'    => 'no',
            );
            
            // Allow other plugins to modify the table fields.
            return $fields = apply_filters( 'ekwc_product_compare_table_fields', $fields );
        }

        /**
         * Define and return style fields for the product comparison settings.
         * 
         * @return array $fields The style fields for the comparison settings.
         */
        public static function style_field() {
            $fields = array(
                'compare_button_bg_color' => array(
                    'title'       => esc_html__( 'Compare Button Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwccolor',
                    'default'     => '#274c4f',
                    'name'        => 'ekwc_compare_style[compare_button_bg_color]',
                    'desc'        => esc_html__( 'Select the background color for the Compare button.', 'essential-kit-for-woocommerce' ),
                ),
                'compare_button_text_color' => array(
                    'title'       => esc_html__( 'Compare Button Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'  => 'ekwccolor',
                    'default'     => '#ffffff',
                    'name'        => 'ekwc_compare_style[compare_button_text_color]',
                    'desc'        => esc_html__( 'Select the text color for the Compare button.', 'essential-kit-for-woocommerce' ),
                ),
                
                'product_compare_style' => array(
                    'title'         => esc_html__( 'Product Compare Style', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwcselect',
                    'name'          => 'ekwc_compare_style[product_compare_style]',
                    'default'       => 'compare-table',
                    'options'       => array(
                        'compare-table' => esc_html__( 'Style 1', 'essential-kit-for-woocommerce' ),
                        'buy-pro-2'     => esc_html__( 'Buy Pro For Style 2', 'essential-kit-for-woocommerce' ),
                        'buy-pro-3'     => esc_html__( 'Buy Pro For Style 3', 'essential-kit-for-woocommerce' ),
                        'buy-pro-4'     => esc_html__( 'Buy Pro For Style 4', 'essential-kit-for-woocommerce' ),
                        'buy-pro-5'     => esc_html__( 'Buy Pro For Style 5', 'essential-kit-for-woocommerce' ),
                        'buy-pro-6'     => esc_html__( 'Buy Pro For Style 6', 'essential-kit-for-woocommerce' ),
                    ),
                    'data_hide'         => '.compare_style_option',
                    'disabled_options'  => array( 'buy-pro-2', 'buy-pro-3', 'buy-pro-4', 'buy-pro-5', 'buy-pro-6' ),
                ),
                'comparison_table_layout' => array(
                    'title'         => esc_html__( 'Comparison Table Layout', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'button_text'   => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'   => esc_html__( 'Get the Pro version to enable the Comparison Table Layout feature.', 'essential-kit-for-woocommerce' ),
                    'default'       => 'no',
                ),
                'style_1_button_color' => array(
                    'title'         => esc_html__( 'Add To Cart Button Background Color', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwccolor',
                    'name'          => 'ekwc_compare_style[style_1_button_color]',
                    'default'       => '#000000',
                    'desc'          => esc_html__( 'Choose a color for the Add to Cart button.', 'essential-kit-for-woocommerce' ),
                    'style'         => 'product_compare_style.compare-table',
                    'extra_class'   => 'compare_style_option compare-table',
                ),
                'style_1_button_text_color' => array(
                    'title'         => esc_html__( 'Add To Cart Button Text Color', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwccolor',
                    'name'          => 'ekwc_compare_style[style_1_button_text_color]',
                    'default'       => '#ffffff',
                    'desc'          => esc_html__( 'Choose a text color for the Add to Cart button.', 'essential-kit-for-woocommerce' ),
                    'style'         => 'product_compare_style.compare-table',
                    'extra_class'   => 'compare_style_option compare-table',
                ),
                'enable_more_style_option' => array(
                    'title'         => esc_html__( 'Enable More Style option', 'essential-kit-for-woocommerce' ),
                    'field_type'    => 'ekwcbuypro',
                    'pro_link'      => EKWC_PRO_VERSION_URL,
                    'button_text'   => esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'   => esc_html__( 'Get the Pro version to enable the Enable More Style option.', 'essential-kit-for-woocommerce' ),
                    'default'       => 'no',
                ),
            );
            
            // Allow other plugins to modify the style fields.
            return $fields = apply_filters( 'ekwc_product_compare_style_fields', $fields );
        
        }

        /**
         * Define and return advanced fields for the product comparison settings.
         * 
         * @return array $fields The advanced fields for the comparison settings.
         */
        public static function compare_premium_field() {

            $fields = array(
            
                'hide_similarities' => array(
                    'title'       => esc_html__( 'Hide Similarities', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'=> esc_html__( 'Get the Pro version to enable the Hide Similarities feature.', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
            
                'highlight_differences' => array(
                    'title'       => esc_html__( 'Highlight Differences', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'=> esc_html__( 'Get the Pro version to enable the Highlight Differences feature.', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
            
                'related_product_compare' => array(
                    'title'       => esc_html__( 'Related Product Compare', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'=> esc_html__( 'Get the Pro version to enable the Related Product Compare feature.', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
            
                'shareable_comparison_table_url' => array(
                    'title'       => esc_html__( 'Shareable Comparison Table URL', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'=> esc_html__( 'Get the Pro version to enable the Shareable Comparison Table URL feature.', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
            
                'enable_sticky_bar_of_product_comparison' => array(
                    'title'       => esc_html__( 'Enable Sticky Bar of Product Comparison', 'essential-kit-for-woocommerce' ),
                    'field_type' => 'ekwcbuypro',
                    'pro_link'   => EKWC_PRO_VERSION_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'essential-kit-for-woocommerce' ),
                    'description'=> esc_html__( 'Get the Pro version to enable the Enable Sticky Bar of Product Comparison feature.', 'essential-kit-for-woocommerce' ),
                    'default'    => 'no',
                ),
        
            );
            
            // Allow other plugins to modify the advanced fields.
            return $fields = apply_filters( 'ekwc_product_compare_premium_fields', $fields );
        
        }

    }

endif;