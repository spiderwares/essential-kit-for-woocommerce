<?php
/**
 * Giftbox Icon Template
 */
defined( 'ABSPATH' ) || exit; ?>

<div id="ekwc-shipping-bar-gift-box-icon" class="<?php echo esc_attr( $giftbox_position ); ?>">
	<img src="<?php echo esc_url( ! empty( $giftbox_icon ) ? $giftbox_icon : EKWC_URL . 'assets/img/free-shipping-bar/free-shipping.png' ); ?>" alt="Giftbox Icon"/>
</div>
