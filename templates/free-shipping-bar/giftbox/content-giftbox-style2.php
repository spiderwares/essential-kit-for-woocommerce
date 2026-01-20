<?php
/**
 *  Giftbox style 2
 *
 */
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; ?>

<div id="ekwc-shipping-bar-giftbox_model" class="ekwc-shipping-bar-model-main" style="<?php echo esc_attr( '--bg_gift_color: ' . $bg_color ); ?>">
    <div class="ekwc-shipping-bar-model-inner">
        <div class="ekwc-shipping-bar-model-wrap">
            <div class="rectangle rectangle-2" style="position: relative;">
                <div id="ekwc-shipping-bar-close" class="cross-dark">×</div>
                <div class="content">
                    <img src="<?php echo esc_url( EKWC_URL . 'assets/img/free-shipping-bar/giftbox.png' ); ?>" class="giftbox" alt="img">
                    <div class="content-inner">

                        <?php if ( $width < 100 ) : ?>
                            <h3 style="<?php echo esc_attr( 'color: ' . $text_color . '; margin: 30px 0px 0px 0px;font-weight: 700;' ); ?>">
                                <?php esc_html_e( 'Add at least', 'essential-kit-for-woocommerce' ); ?>
                            </h3>
                            <h2 style="<?php echo esc_attr( 'color: ' . $text_color . '; margin: 10px 0px; padding: 0px;' ); ?>">
                                <?php echo wp_kses_post( wc_price( $shipping_option['order_min_amount'] - $shipping_option['total'] ) ); ?>
                            </h2>
                            <p style="<?php echo esc_attr( 'color: ' . $text_color . ';' ); ?>" class="dark-pill-bg">
                                <?php esc_html_e( 'More to get free Shipping', 'essential-kit-for-woocommerce' ); ?>
                            </p>
                        <?php else : ?>
                            <h3 style="<?php echo esc_attr( 'color: ' . $text_color . '; margin-top: 30px;font-weight: 700; font-size: 32px;' ); ?>">
                                <?php esc_html_e( 'Congratulation!', 'essential-kit-for-woocommerce' ); ?>
                            </h3>
                            <p style="<?php echo esc_attr( 'color: ' . $text_color . '; font-weight: 500;' ); ?>" class="dark-pill-bg">
                                <?php esc_html_e( 'You have got free shipping', 'essential-kit-for-woocommerce' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <img src="<?php echo esc_url( EKWC_URL . 'assets/img/free-shipping-bar/green-line.png' ); ?>" class="green-line" alt="img">
                </div>
            </div>
        </div>
    </div>
    <div class="ekwc-shipping-bar-bg_overlay"></div>
</div>