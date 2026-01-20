<?php
/***
 * Free Shipping Annoucement Message Style 2
 */

defined( 'ABSPATH' ) || exit;

$width = $width > 100 ? 100 : $width; ?>


<div class="ekwc-shipping-bar-topbar" >
	<div id="ekwc-shipping-bar-topbar" class="<?php echo esc_attr( 'rectangle-3 ' . $position ); ?>" style="<?php echo esc_attr( 'background-color:' . $bg_color . '; text-align: ' . $text_align . '; display: none' ); ?>">
		<div class="ekwc-shipping-bar-container">
			<div class="">
				<img src="<?php echo esc_url( EKWC_URL . '/assets/img/free-shipping-bar/boy-with-courier.png' ); ?>" alt="img">
			</div>
			<div class="content" style="width: 100%">
				<h4 class="rectangle-3-title" style="font-weight: 600; margin: 10px 0px; font-size: 18px; <?php echo esc_attr( 'color: ' . $text_color . '; font-size:' . $font_size . 'px; font-weight: 700;' ); ?>"><?php echo wp_kses_post( $message ); ?></h4> 
				<?php if ( $enable_progress === 'yes' ) :
				$width = $width > 100 ? 100 : $width; ?>
				<div class="progress progress-2" style="<?php echo esc_attr( 'background-color:' . $progress_bg_color ); ?>">
					<div class="progress-bar progress-bar-2" style="<?php echo esc_attr( 'width:' . $width . '%; background-color:' . $curr_prog_color ); ?>">
						<div class="pricing">
							<p style="text-align: left; font-weight: 600; <?php echo esc_attr( 'color: ' . $text_color . '; font-size:' . $font_size . 'px;'); ?>"><?php echo esc_html__( '$0.00', 'essential-kit-for-woocommerce' ); ?></p>
							<p style="text-align: right; font-weight: 600; <?php echo esc_attr( 'color: ' . $text_color . '; font-size:' . $font_size . 'px;'); ?>"><?php echo wp_kses_post( wc_price( $shipping_option['total'] ) ); ?></p>
						</div>
					</div>
				</div>  
				<?php endif; ?>          
			</div> 
			<?php if ( $closebar_button === 'yes' ) : ?>
				<div class="closebar">&#10005;</div>   
			<?php endif; ?>     
		</div>
	</div>
</div>