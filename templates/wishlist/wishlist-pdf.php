<?php
/**
 * Wishlist PDF Template
 */
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif; ?>

<h2 class="wishlist-title" style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #ddd; padding-bottom: 5px;"><?php esc_html_e( 'Wishlist', 'essential-kit-for-woocommerce' ); ?></h2>

<table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:12px;">
    <tr style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle; background-color:#f8f8f8; font-weight:bold;">
        <th style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php esc_html_e( 'Image', 'essential-kit-for-woocommerce' ); ?></th>
        <th style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php esc_html_e( 'Product', 'essential-kit-for-woocommerce' ); ?></th>
        <th style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php esc_html_e( 'Price', 'essential-kit-for-woocommerce' ); ?></th>
        <th style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php esc_html_e( 'Stock Status', 'essential-kit-for-woocommerce' ); ?></th>
    </tr>

    <?php foreach ( $wishlist_items['items'] as $item ) : ?>
        <?php 
            $product = wc_get_product( $item['prod_id'] );
            if ( ! $product ) continue;

            $product_name       =  $product->get_name();
            $product_price      = $product->get_price() ? wc_price( $product->get_price() ) : '-';
            $product_qty        = isset( $item['quantity'] ) ? intval( $item['quantity'] ) : 1;
            $stock_status       = $product->is_in_stock()
                                    ? '<span class="stock-in" style="color: green; font-weight: bold;">' . esc_html__( 'In Stock', 'essential-kit-for-woocommerce' ) . '</span>'
                                    : '<span class="stock-out" style="color: red; font-weight: bold;">' . esc_html__( 'Out of Stock', 'essential-kit-for-woocommerce' ) . '</span>';
            $product_image      = wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' );
            $product_img_html   = $product_image ? '<img src="' . esc_url( $product_image[0] ) . '" style="max-width:100px; height:auto; display:block; margin:auto;" />' : '';
            $product_url        = get_permalink( $item['prod_id'] );
        ?>
        <tr class="wishlist-data" style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;">
            <td class="image" style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php echo wp_kses_post( $product_img_html ); ?></td>
            <td style="border:1px solid #ddd; padding:10px; text-align:left; vertical-align:middle;"><a href="<?php echo esc_url( $product_url ); ?>" target="_blank" style="color:#0073aa; text-decoration:none; font-weight:bold;"><?php echo esc_html( $product_name ); ?></a></td>
            <td style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php echo wp_kses_post( $product_price ); ?></td>
            <td style="border:1px solid #ddd; padding:10px; text-align:center; vertical-align:middle;"><?php echo wp_kses_post( $stock_status ); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
