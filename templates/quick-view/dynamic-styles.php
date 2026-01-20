<?php
/**
 * Dynamic Styles for Quick View - Essential Kit for WooCommerce
 */
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

$general_style           = isset( $general_style ) ? $general_style : array();
$quick_view_style        = isset( $quick_view_style ) ? $quick_view_style : array();
$wishlist_style          = isset( $wishlist_style ) ? $wishlist_style : array();
$shipping_style          = isset( $shipping_style ) ? $shipping_style : array();
$compare_style           = isset( $compare_style ) ? $compare_style : array();

$wl_btn_text             = isset( $wishlist_style['wishlist_btn_text_color'] ) ? esc_attr( $wishlist_style['wishlist_btn_text_color'] ) : '#cc5500';
$wl_btn_bg               = isset( $wishlist_style['wishlist_btn_bg_color'] ) ? esc_attr( $wishlist_style['wishlist_btn_bg_color'] ) : '#ffffff';
$wl_btn_bg_hover         = isset( $wishlist_style['wishlist_btn_hover_bg_color'] ) ? esc_attr( $wishlist_style['wishlist_btn_hover_bg_color'] ) : '#ff6600';
$wl_btn_text_hover       = isset( $wishlist_style['wishlist_btn_hover_text_color'] ) ? esc_attr( $wishlist_style['wishlist_btn_hover_text_color'] ) : '#ffffff';
$wl_addtocart_text       = isset( $wishlist_style[ 'add_to_cart_btn_text_color' ] ) ? esc_attr( $wishlist_style[ 'add_to_cart_btn_text_color' ] ) : '#ffffff';
$wl_addtocart_bg         = isset( $wishlist_style[ 'add_to_cart_btn_bg_color' ] ) ? esc_attr( $wishlist_style[ 'add_to_cart_btn_bg_color' ] ) : '#ff6600';
$wl_addtocart_text_hover = isset( $wishlist_style[ 'add_to_cart_btn_hover_text_color' ] ) ? esc_attr( $wishlist_style[ 'add_to_cart_btn_hover_text_color' ] ) : '#ffffff';
$wl_addtocart_bg_hover   = isset( $wishlist_style[ 'add_to_cart_btn_hover_bg_color' ] ) ? esc_attr( $wishlist_style[ 'add_to_cart_btn_hover_bg_color' ] ) : '#cc5500';


$background_color        = isset( $quick_view_style[ 'content_background' ] ) ? esc_attr( $quick_view_style[ 'content_background' ] ) : '#ffffff';
$overlay_color           = isset( $quick_view_style[ 'overlay_color' ] ) ? esc_attr( $quick_view_style[ 'overlay_color' ] ) : '#000000';
$overlay_opacity         = isset( $quick_view_style[ 'overlay_opacity' ] ) ? esc_attr( $quick_view_style[ 'overlay_opacity' ] ) : '0.5';
$close_icon_color        = isset( $quick_view_style[ 'close_icon_color' ] ) ? esc_attr( $quick_view_style[ 'close_icon_color' ] ) : '#cdcdcd';
$close_icon_hover        = isset( $quick_view_style[ 'close_icon_hover' ] ) ? esc_attr( $quick_view_style[ 'close_icon_hover' ] ) : '#ff0000';
$button_bg_color         = isset( $quick_view_style[ 'button_bg_color' ] ) ? esc_attr( $quick_view_style[ 'button_bg_color' ] ) : '#000000';
$button_bg_hover         = isset( $quick_view_style[ 'button_bg_hover' ] ) ? esc_attr( $quick_view_style[ 'button_bg_hover' ] ) : '#000000';
$button_text_color       = isset( $quick_view_style[ 'button_text_color' ] ) ? esc_attr( $quick_view_style[ 'button_text_color' ] ) : '#ffffff';
$button_text_hover       = isset( $quick_view_style[ 'button_text_hover' ] ) ? esc_attr( $quick_view_style[ 'button_text_hover' ] ) : '#ffffff';
$image_width             = isset( $quick_view_style[ 'product_image_dimensions' ][ 'width' ] ) ? esc_attr( $quick_view_style[ 'product_image_dimensions' ][ 'width' ] ) . 'px' : '300px';
$image_height            = isset( $quick_view_style[ 'product_image_dimensions' ][ 'height' ] ) ? esc_attr( $quick_view_style[ 'product_image_dimensions' ][ 'height' ] ) . 'px' : '300px';
$add_to_cart_bg          = isset( $quick_view_style[ 'add_to_cart_btn_bg_color' ] ) ? esc_attr( $quick_view_style[ 'add_to_cart_btn_bg_color' ] ) : '#000000';
$add_to_cart_bg_hover    = isset( $quick_view_style[ 'add_to_cart_btn_bg_hover_color' ] ) ? esc_attr( $quick_view_style[ 'add_to_cart_btn_bg_hover_color' ] ) : '#333333';
$add_to_cart_text        = isset( $quick_view_style[ 'add_to_cart_text_color' ] ) ? esc_attr( $quick_view_style[ 'add_to_cart_text_color' ] ) : '#ffffff';
$add_to_cart_text_hover  = isset( $quick_view_style[ 'add_to_cart_text_hover_color' ] ) ? esc_attr( $quick_view_style[ 'add_to_cart_text_hover_color' ] ) : '#ffffff';
$star_color              = isset( $quick_view_style[ 'star_color' ] ) ? esc_attr( $quick_view_style[ 'star_color' ] ) : '#f7c104';
$main_text_color         = isset( $quick_view_style[ 'main_text_color' ] ) ? esc_attr( $quick_view_style[ 'main_text_color' ] ) : '#333333';

$compare_btn_bg          = isset( $compare_style[ 'compare_button_bg_color' ] ) ? esc_attr( $compare_style[ 'compare_button_bg_color' ] ) : '#274c4f';
$compare_btn_text        = isset( $compare_style[ 'compare_button_text_color' ] ) ? esc_attr( $compare_style[ 'compare_button_text_color' ] ) : '#ffffff';
$compare_add_to_cart_bg  = isset( $compare_style[ 'style_1_button_color' ] ) ? esc_attr( $compare_style[ 'style_1_button_color' ] ) : '#274c4f';
$compare_add_to_cart_text= isset( $compare_style[ 'style_1_button_text_color' ] ) ? esc_attr( $compare_style[ 'style_1_button_text_color' ] ) : '#ffffff';


$icon_hover_bg_color     = isset( $general_style[ 'icon_hover_bg_color' ] ) ? esc_attr( $general_style[ 'icon_hover_bg_color' ] ) : '#274c4f';
$icon_hover_color        = isset( $general_style[ 'icon_bg_color' ] ) ? esc_attr( $general_style[ 'icon_bg_color' ] ) : '#ffffff'; 

if ( isset( $shipping_style['custom_css'] ) && ! empty( $shipping_style['custom_css'] ) ) :
    echo wp_strip_all_tags( $shipping_style['custom_css'], true );
endif; ?>

.ekwc-quick-view-body {
    background-color: <?php echo esc_attr( $background_color ); ?>;
}

.ekwc-model::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: <?php echo esc_attr( $overlay_color ); ?>;
    opacity: <?php echo esc_attr( $overlay_opacity ); ?>;
}

.ekwc-quick-view-close {
    color: <?php echo esc_attr( $close_icon_color ); ?>;
}

.ekwc-quick-view-close:hover {
    color: <?php echo esc_attr( $close_icon_hover ); ?>;
}

.ekwc-quick-view {
    background-color: <?php echo esc_attr( $button_bg_color ); ?>;
    color: <?php echo esc_attr( $button_text_color ); ?>;
}

.ekwc-quick-view:hover {
    background-color: <?php echo esc_attr( $button_bg_hover ); ?>;
    color: <?php echo esc_attr( $button_text_hover ); ?>;
}

.ekwc-quick-view-image img {
    width: <?php echo esc_attr( $image_width ); ?>;
    height: <?php echo esc_attr( $image_height ); ?>;
    object-fit: cover;
    display: block;
    margin: 0 auto;
}

.ekwc-quick-view-cart button, 
.ekwc-quick-view-cart .view_product_button,
.ekwc-quick-view-content .ekwc_add_to_cart{
    background-color: <?php echo esc_attr( $add_to_cart_bg ); ?>;
    color: <?php echo esc_attr( $add_to_cart_text ); ?>;
}

.ekwc-quick-view-cart button:hover, 
.ekwc-quick-view-cart .view_product_button:hover,
.ekwc-quick-view-content .ekwc_add_to_cart:hover {
    background-color: <?php echo esc_attr( $add_to_cart_bg_hover ); ?>;
    color: <?php echo esc_attr( $add_to_cart_text_hover ); ?>;
}

.ekwc-quick-view-rating .star-rating span:before,
.ekwc-quick-view-rating .star-rating span:before{
    color: <?php echo esc_attr( $star_color ); ?>;
}

.ekwc-quick-view-description{
    color: <?php echo esc_attr( $main_text_color ); ?>;
}

.ekwc-wishlist-table .ekwc-add-to-cart{
    background-color: <?php echo esc_attr( $wl_addtocart_bg ); ?>;
    color: <?php echo esc_attr( $wl_addtocart_text ); ?>;
}
.ekwc-wishlist-modal .ekwc-wishlist-add:hover, 
button.ekwc-wishlist-create:hover,
.ekwc-wishlist-table .ekwc-add-to-cart:hover{
    background-color: <?php echo esc_attr( $wl_addtocart_bg_hover ); ?>;
    color: <?php echo esc_attr( $wl_addtocart_text_hover ); ?>;
}

.ekwc-wishlist-modal .ekwc-wishlist-add:hover, 
button.ekwc-wishlist-create:hover,
button.ekwc_multiselect_wishlist,
button.ekwc-wishlist-button{
    background-color: <?php echo esc_attr( $wl_btn_bg ); ?>;
    color: <?php echo esc_attr( $wl_btn_text ); ?>;
}

button.ekwc_multiselect_wishlist:hover,
button.ekwc-wishlist-button:hover{
    background-color: <?php echo esc_attr( $wl_btn_bg_hover ); ?>;
    color: <?php echo esc_attr( $wl_btn_text_hover ); ?>;
}

.ekwc-compare-button-wrapper button {
    background-color:<?php echo esc_attr( $compare_btn_bg ); ?>;
    color: <?php echo esc_attr( $compare_btn_text ); ?>;
}

.ekwc-comparison-table.ekwc-vertical-table.style-1 .ekwc-compare-add-to-cart a, 
.ekwc-comparison-table.ekwc-horizontal-table.style-1 .ekwc-compare-add-to-cart a{
    background-color: <?php echo esc_attr($compare_add_to_cart_bg); ?>;
    color: <?php echo esc_attr($compare_add_to_cart_text);  ?>;
}

.ekwc-product-icons-container .ekwc-compare-icon:hover, 
.ekwc-product-icons-container .ekwc-wishlist-icon:hover, 
.ekwc-product-icons-container .ekwc-quick-view-icon:hover{
    background: <?php echo esc_attr($icon_hover_bg_color); ?>;
    border: 1px solid <?php echo esc_attr($icon_hover_bg_color); ?>;
}

.ekwc-product-icons-container .ekwc-compare-icon, 
.ekwc-product-icons-container .ekwc-wishlist-icon, 
.ekwc-product-icons-container .ekwc-quick-view-icon{
    background: <?php echo esc_attr($icon_hover_color); ?>;
    border: 1px solid <?php echo esc_attr($icon_hover_color); ?>;
}

.ekwc-wishlist-table thead th{
    background: <?php echo esc_attr($wl_btn_bg); ?>;
    color: <?php echo esc_attr($wl_btn_text); ?>;
}