<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

// Debugging: Check if $wishlist is properly received.
if ( empty( $wishlist ) ) :
    echo '<p>' . esc_html__( 'Your wishlist is empty.', 'essential-kit-for-woocommerce' ) . '</p>';
    return;
endif;
?>

<table class="ekwc-wishlist-table">
    <thead>
        <tr>

            <?php if( isset( $setting[ 'ekwc_left_show_remove' ] ) && $setting[ 'ekwc_left_show_remove' ] === 'yes'  ): ?>
                <th></th> <!-- Remove icon -->
            <?php endif; ?>

            <th><?php esc_html_e( 'Product', 'essential-kit-for-woocommerce' ); ?></th>
            
            <?php if( isset( $setting[ 'ekwc_price_show' ] ) && $setting[ 'ekwc_price_show' ] === 'yes'  ): ?>
                <th><?php esc_html_e( 'Price', 'essential-kit-for-woocommerce' ); ?></th>
            <?php endif; ?>
                
            <?php if( isset( $setting[ 'ekwc_stock_show' ] ) && $setting[ 'ekwc_stock_show' ] === 'yes'  ): ?>
                <th><?php esc_html_e( 'Stock', 'essential-kit-for-woocommerce' ); ?></th>
            <?php endif; ?>

            <?php 
            /**
             * Hook for adding Quick View heading
             */
            do_action( 'ekwc_quick_view_heading' ); 
            ?>
            
            <?php if( isset( $setting[ 'ekwc_add_to_cart_show' ] ) && $setting[ 'ekwc_add_to_cart_show' ] === 'yes'  ): ?>
                <th><?php esc_html_e( 'Add to Cart', 'essential-kit-for-woocommerce' ); ?></th>
            <?php endif; ?>

            <?php if( isset( $setting[ 'ekwc_right_remove_button' ] ) && $setting[ 'ekwc_right_remove_button' ] === 'yes'  ): ?>
                <th></th> <!-- Remove button -->
            <?php endif; ?>

        </tr>
    </thead>
    <tbody>
        <?php foreach ( $wishlist as $product_id ) : ?>
            <?php 
                $product = wc_get_product( $product_id );
                if ( ! $product ) continue; // Skip invalid products

                $product_link  = get_permalink( $product_id );
                $product_image = $product->get_image();
                $product_price = $product->get_price_html();
                $stock_status  = $product->is_in_stock() ? esc_html__( 'In Stock', 'essential-kit-for-woocommerce' ) : esc_html__( 'Out of Stock', 'essential-kit-for-woocommerce' );

                // Add to Cart Button
                $add_to_cart_url = esc_url( wc_get_cart_url() . '?add-to-cart=' . $product_id );
            ?>
            <tr class="ekwc-wishlist-row">
                <!-- Remove Icon (Left) -->
                <?php if( isset( $setting[ 'ekwc_left_show_remove' ] ) && $setting[ 'ekwc_left_show_remove' ] === 'yes'  ): ?>
                    <td style="text-align: center;">
                        <span class="ekwc-remove-wishlist" data-wishlist-token="<?php echo esc_attr( $wishlist_token ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">×</span>
                    </td>
                <?php endif; ?>

                <!-- Product Name & Image -->
                <td class="ekwc-wishlist-image">
                    <a href="<?php echo esc_url( $product_link ); ?>">
                        <?php echo wp_kses_post( $product_image ); ?> <?php echo esc_html( $product->get_name() ); ?>
                    </a>
                </td>

                <!-- Price -->
                <?php if( isset( $setting[ 'ekwc_price_show' ] ) && $setting[ 'ekwc_price_show' ] === 'yes'  ): ?>
                    <td class="ekwc-center"><?php echo wp_kses_post( $product_price ); ?></td>
                <?php endif; ?>

                <!-- Stock Status -->
                <?php if( isset( $setting[ 'ekwc_stock_show' ] ) && $setting[ 'ekwc_stock_show' ] === 'yes'  ): ?>
                    <td class="ekwc-center"><?php echo esc_html( $stock_status ); ?></td>
                <?php endif; ?>

                <?php /**
                        * Hook for adding Quick View heading
                        */
                    do_action( 'ekwc_quick_view_button', $product_id ); ?>

                <!-- Add to Cart Button -->
                <?php if ( isset( $setting['ekwc_add_to_cart_show'] ) && $setting['ekwc_add_to_cart_show'] === 'yes' ): ?>
                    <td class="ekwc-center ekwc-add_to_cart_td">
                        <?php  $product_type = $product->get_type(); ?>
                        <?php if ( $product_type === 'simple' ) : ?>
                            <?php if ( $product->is_in_stock() ) : ?>
                                <a  data-quantity="1"
                                    data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
                                    data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                    class="button ekwc-add-to-cart ajax_add_to_cart add_to_cart_button">
                                    <?php echo esc_html($setting[ 'add_to_cart_text' ] ); ?>
                                    <img class="ekwc-loader-img" style="display: none;" src="<?php echo esc_url( admin_url( 'images/spinner.gif' ) ); ?>" alt="Loading...">
                                </a>
                            <?php else : ?>
                                <span class="out-of-stock-text"><?php esc_html_e( 'Out of Stock', 'essential-kit-for-woocommerce' ); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo esc_url( $product_link ); ?>" class="button ekwc-add-to-cart  ekwc-select-options">
                                <?php esc_html_e( 'Select Options', 'essential-kit-for-woocommerce' ); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>


                <!-- Remove Button (Right) -->
                <?php if( isset( $setting[ 'ekwc_right_remove_button' ] ) && $setting[ 'ekwc_right_remove_button' ] === 'yes'  ): ?>
                    <td style="text-align: center;">
                        <span class="ekwc-remove-wishlist" data-wishlist-token="<?php echo esc_attr( $wishlist_token ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">×</span>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="ekwc-share">
    <?php if ( ! empty( $setting['ekwc_share_wishlist'] ) && $setting['ekwc_share_wishlist'] === 'yes' ) : ?>
        <h4 class="ekwc-share-title"><?php echo esc_html( $setting['wishlist_share_title'] ); ?></h4>
        <ul class="ekwc-share-list">
            <?php if ( ! empty( $setting['ekwc_share_facebook'] ) && $setting['ekwc_share_facebook'] === 'yes' ) : ?>
                <li class="share-button">
                    <a target="_blank" rel="noopener" class="facebook" href="https://www.facebook.com/sharer.php?u=<?php echo esc_attr( $current_url ); ?>" title="Facebook">
                        <img src="<?php echo esc_url( $setting['facebook_icon'] ); ?>" alt="Facebook">
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( ! empty( $setting['ekwc_share_twitter'] ) && $setting['ekwc_share_twitter'] === 'yes' ) : ?>
                <li class="share-button">
                    <a target="_blank" rel="noopener" class="twitter" href="https://twitter.com/share?url=<?php echo esc_attr( $current_url ); ?>" title="Twitter (X)">
                        <img src="<?php echo esc_url( $setting['twitter_icon'] ); ?>" alt="Twitter">
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( ! empty( $setting['ekwc_share_pinterest'] ) && $setting['ekwc_share_pinterest'] === 'yes' ) : ?>
                <li class="share-button">
                    <a target="_blank" rel="noopener" class="pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_attr( $current_url ); ?>" title="Pinterest" onclick="window.open(this.href); return false;">
                        <img src="<?php echo esc_url( $setting['pinterest_icon'] ); ?>" alt="Pinterest">
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( ! empty( $setting['ekwc_share_email'] ) && $setting['ekwc_share_email'] === 'yes' ) : ?>
                <li class="share-button">
                    <a class="email" href="mailto:?subject=Checkout with this&amp;body=<?php echo esc_attr( $current_url ); ?>" title="Email">
                        <img src="<?php echo esc_url( $setting['email_icon'] ); ?>" alt="Email">
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( ! empty( $setting['ekwc_share_whatsapp'] ) && $setting['ekwc_share_whatsapp'] === 'yes' ) : ?>
                <li class="share-button">
                    <a class="whatsapp" href="https://wa.me/?text=<?php echo esc_attr( 'Checkout with this: ' . $current_url ); ?>" data-action="share/whatsapp/share" target="_blank" rel="noopener" title="WhatsApp">
                        <img src="<?php echo esc_url( $setting['whatsapp_icon'] ); ?>" alt="WhatsApp">
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</div>
