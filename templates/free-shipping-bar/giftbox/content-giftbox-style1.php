<?php
/**
 *  Giftbox style 1
 */
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; 

$order_min_amount = wc_price( $shipping_option['order_min_amount'] - $shipping_option['total'] ); ?>

<div id="ekwc-shipping-bar-giftbox_model" class="ekwc-shipping-bar-model-main"  style="<?php echo esc_attr( '--bg_gift_color: ' . $bg_color . '; --width: ' . $width ); ?>">
	<div class="ekwc-shipping-bar-model-inner">    
		<div class="ekwc-shipping-bar-model-wrap">
			<div class="rectangle rectangle-8" style="position: relative;">
				<div id="ekwc-shipping-bar-close" class="cross-dark">×</div>
				<div class="content">        
					<div class="content-inner">
						<?php if ( $shipping_option['order_min_amount'] > $shipping_option['total'] ) : ?>
							<div class="pill-rounded">
								<h6 style="<?php echo esc_attr( 'color: ' . $text_color . ';font-weight: 600;font-size: 16px; margin: 0px; font-weight: normal; adding-top: 20px;' ); ?>">
									<?php esc_html_e( 'Add at least', 'essential-kit-for-woocommerce' ); ?>
								</h6>
								<h2 style="<?php echo esc_attr( 'color: ' . $text_color . ';font-weight: 700; padding: 0px; margin: 0px;' ); ?>">
									<?php echo wp_kses_post( $order_min_amount ); ?>
								</h2>
								<p style="<?php echo esc_attr( 'color: ' . $text_color . ';font-weight: 500;margin:0px' ); ?>">
									<?php esc_html_e( 'More to get free Shipping', 'essential-kit-for-woocommerce' ); ?>
								</p>
							</div>    
						<?php else : ?>  
							<div class="pill-rounded">
								<h2 style="<?php echo esc_attr( 'color: ' . $text_color . ';font-weight: 500; font-weight: 700; padding: 0px; font-size: 32px' ); ?>">
									<?php esc_html_e( 'Congratulation!', 'essential-kit-for-woocommerce' ); ?>
								</h2>
								<p style="<?php echo esc_attr( 'color: ' . $text_color . ';font-weight: 500;margin:0px' ); ?>">
									<?php esc_html_e( 'You have got free shipping.', 'essential-kit-for-woocommerce' ); ?>
								</p>
							</div>   
						<?php endif; ?>

						<div class="progress progress-4" style="<?php echo esc_attr( 'background-color:' . $bg_pcolor ); ?>">
							<div class="progress-bar progress-bar-4 progress-bar-striped" style="<?php echo esc_attr( 'width: ' . $width . '%; background-color:' . $curr_bg_pcolor ); ?>"></div>
						</div>

						<h3 style="<?php echo esc_attr( 'color: ' . $text_color . 'font-weight: 700; padding: 0px; margin: 20px 0px 0px 0px;' ); ?>">
							<?php
							// translators: %1$s is the minimum order amount for free shipping.
							printf( 
								esc_html__( 'Over %1$s', 'essential-kit-for-woocommerce' ), 
								wp_kses_post( wc_price( $shipping_option['order_min_amount'] ) ) 
							); ?>
						</h3>
						<img style="margin: 0 auto;" src="<?php echo esc_url( EKWC_URL . 'assets/img/free-shipping-bar/green-line.png' ); ?>" class="green-line" alt="img">                              
					</div>
				</div>
			</div>
		</div>  
	</div>  
	<div class="ekwc-shipping-bar-bg_overlay"></div>
</div>