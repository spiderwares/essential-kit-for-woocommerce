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
                    <img src="<?php echo esc_url( EKWC_URL . 'assets/img/free-shipping-bar/car-black.png' ); ?>" class="rectangle-3-bg" alt="img">                
                    <div class="content-inner">
                        <h3 style="<?php echo esc_attr( 'color: ' . $text_color . '; text-transform: uppercase; font-size: 36px; font-weight: 600;margin:0px;padding-top: 20px;' ); ?>">
                            <?php esc_html_e( 'free shipping', 'essential-kit-for-woocommerce' ); ?>
                        </h3>
                        <h2 style="font-weight: 500;display: flex;font-size: 22px;justify-content: center; <?php echo esc_attr( 'color: ' . $text_color . ';' ); ?>">
                            <?php printf( 
                                esc_html__( 'Orders Over %s', 'essential-kit-for-woocommerce' ), 
                                wp_kses_post( wc_price( $shipping_option['order_min_amount'] ) ) // Escape HTML output
                            ); ?>
                        </h2>   
                        <div class="progress progress-3" style="<?php echo esc_attr( 'background-color:' . $bg_pcolor ); ?>">
                            <div class="progress-bar progress-bar-3" style="<?php echo esc_attr( 'width: ' . $width . '%; background-color:' . $curr_bg_pcolor ); ?>">
                            </div>
                        </div>       
                    </div>           
                </div>
                <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>" style="<?php echo esc_attr( 'color: ' . $link_color . ';' ); ?>">
                    <?php esc_html_e( 'Continue shopping', 'essential-kit-for-woocommerce' ); ?>
                </a>
            </div>
        </div>  
    </div>  
    <div class="ekwc-shipping-bar-bg_overlay"></div>
</div>
