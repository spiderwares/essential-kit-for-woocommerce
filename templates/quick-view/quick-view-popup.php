<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

if ( ! isset( $product ) || ! $product instanceof WC_Product ) :
    return;
endif;

// Extract product data to prevent multiple function calls
$product_id    = $product->get_id();
$product_name  = $product->get_name();
$product_sku   = $product->get_sku();
$product_price = $product->get_price_html();
$product_image = $product->get_image();
$gallery_ids   = $product->get_gallery_image_ids();

// Determine which description to show based on settings
$description_type   = isset( $settings['product_description'] ) ? $settings['product_description'] : 'short';
$description        = ( $description_type === 'full' ) ? $product->get_description() : $product->get_short_description();

if ( empty( $description ) && $description_type === 'short' ) :
    $description = wp_trim_words( $product->get_description(), 20, '...' );
endif;
?>

<div class="ekwc-quick-view-content">
    <div class="ekwc-quick-view-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </div>
    <div class="ekwc-quick-view-body">

        <div class="ekwc-quick-view-image ekwc-quick-view-image-slider">
            <div class="ekwc-slider">
                <!-- Featured Image -->
                <div class="ekwc-slide">
                    <?php echo wp_kses_post( $product_image ); ?>
                </div>

                <!-- Additional Gallery Images -->
                <?php if ( ! empty( $gallery_ids ) ) : ?>
                    <?php foreach ( $gallery_ids as $attachment_id ) : ?>
                        <div class="ekwc-slide">
                            <?php echo wp_get_attachment_image( $attachment_id, 'woocommerce_single' ); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="ekwc-quick-view-details">
            <h2><?php echo esc_html( $product_name ); ?></h2>
            <p class="ekwc-quick-view-price"><?php echo wp_kses_post( $product_price ); ?></p>
            <div class="ekwc-quick-view-description">
                <?php echo wpautop( wp_kses_post( $description ) ); ?>
            </div>

            <!-- Add to Cart Button -->
            
            <?php if ( $product->is_type( 'simple' ) ) : ?>
                <button type="submit" class="wp-element-button button ekwc_add_to_cart" 
                    data-product_id="<?php echo esc_attr( $product_id ); ?>" 
                    data-product_sku="<?php echo esc_attr( $product_sku ); ?>" 
                    aria-label="<?php esc_attr_e( 'Add to cart', 'essential-kit-for-woocommerce' ); ?>">
                    <?php esc_html_e( 'Add to Cart', 'essential-kit-for-woocommerce' ); ?>
                    <img class="ekwc-loader-img" style="display: none;" src="<?php echo esc_url( admin_url( 'images/spinner.gif' ) ); ?>" alt="Loading...">
                </button>
            <?php else : ?>
                <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="button view_product_button">
                    <?php esc_html_e( 'View Product', 'essential-kit-for-woocommerce' ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>