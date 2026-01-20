<?php
/**
 * Free Shipping Annoucement Message
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; ?>

<div class="ekwc_shipping_topbar_wrap">
	<div id="ekwc-shipping-bar-topbar" class="<?php echo esc_attr( $position ); ?>" style="<?php echo esc_attr( 'background-color:' . $bg_color . '; text-align: ' . $text_align . ' display: none' ); ?>">
		<div class="ekwc-shipping-bar-container">
			<div class="message" style="<?php echo esc_attr( 'color: ' . $text_color . '; font-size:' . $font_size . 'px; font-weight: 700;' ); ?>">
				<?php echo wp_kses_post( $message ); ?>
			</div>
			<?php if ( $enable_progress === 'yes' ) :
				$width = $width > 100 ? 100 : $width; ?>
				<div class="progress progress-1" style="<?php echo esc_attr( 'background-color:' . $progress_bg_color ); ?>">
					<div class="progress-bar progress-bar-1" style="<?php echo esc_attr( 'width:' . $width . '%; background-color:' . $curr_prog_color ); ?>">
						<div id="ekwc-shipping-bar-label" style="<?php echo esc_attr( 'font-weight: 700; color: ' . $progress_text_color . ';' ); ?> "></div>
					</div>
				</div>  
			<?php endif; ?>
			<?php if ( $closebar_button === 'yes' ) : ?>
				<div class="closebar">&#10005;</div> 
			<?php endif; ?>
		</div>
	</div>
</div>