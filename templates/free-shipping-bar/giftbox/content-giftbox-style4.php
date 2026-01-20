<?php 
/**
 *  Giftbox style 3
 * 
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; ?>

<div id="ekwc-shipping-bar-giftbox_model" class="ekwc-shipping-bar-model-main" style="<?php echo esc_attr( '--bg_gift_color: ' . $bg_color ); ?>">
    <div class="ekwc-shipping-bar-model-inner">    
        <div class="ekwc-shipping-bar-model-wrap">
            <div class="rectangle rectangle-2" style="position: relative;">
                <div id="ekwc-shipping-bar-close" class="cross-dark">×</div>
                <div class="content content-2">
                    <img src="<?php echo esc_url( EKWC_URL . 'assets/img/free-shipping-bar/free-shipping-2.png' ); ?>" class="rectangle-3-bg" alt="img">                
                    <div class="content-inner">
                        <h3 style="<?php echo esc_attr( 'color: ' . $text_color . '; text-transform: uppercase; font-size: 36px; font-weight: 600;margin:0px;padding-top: 20px;' ); ?>">
                            <?php esc_html_e( 'free shipping', 'essential-kit-for-woocommerce' ); ?>
                        </h3>

                        <?php if( $width < 100 ) : ?>
                            <h5 style="<?php echo esc_attr( 'color:' . $text_color ); ?> ;font-size: 18px;font-weight: 600;padding: 5px 0;"><?php echo wp_kses_post( $announcement_msg ); ?></h5>
                        <?php endif; ?>

                        <div class="ekwc-shipping-bar-cart-progress">
                            <div class="ekwc-shipping-bar-cart-progress-wrapper">
                                <div class="progress-bar" style="<?php echo esc_attr( '--width: ' . $width . '%; --curr_bg_color: ' . $curr_bg_pcolor . '; --bg_color: ' . $bg_pcolor . ';' ); ?>">
                                    <progress value="50" min="0" max="100" style="visibility:hidden;height:0;width:0;"><?php echo esc_html( '50%', 'essential-kit-for-woocommerce-pro' ); ?></progress>
                                    <div class="ekwc-shipping-bar--progressbar_label"><?php echo wp_kses_post( wc_price( $shipping_option['total'] ) ); ?></div>
                                </div>
                                <div class="ekwc-shipping-bar-cart-progress-title">
                                    <?php if( $width < 100 ) : ?>
                                        <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>" style="<?php echo esc_attr( 'color: ' . $link_color . ';' ); ?>">
                                            <?php esc_html_e( 'Continue shopping', 'essential-kit-for-woocommerce' ); ?>
                                        </a>
                                    <?php else : ?>
                                        <h5 style="<?php echo esc_attr( 'color:' . $text_color ); ?>"><?php echo wp_kses_post( $success_msg ); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>           
                </div>
            </div>
        </div>  
    </div>  
    <div class="ekwc-shipping-bar-bg_overlay"></div>
</div>