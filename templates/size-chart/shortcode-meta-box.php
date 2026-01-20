<?php
/**
 * Shortcode Meta Box Template
 *
 * @var int $post_id
 */

if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif; ?>

<div class="ekwc-shortcode-wrap">
    <p><?php esc_html_e( 'You can use the shortcode below to display this size chart anywhere on your site.', 'essential-kit-for-woocommerce' ); ?></p>
    <label>
        <input type="text"
               onfocus="this.select();"
               readonly="readonly"
               class="code ekwc-size-chart-input"
               value="<?php echo esc_attr( sprintf( '[ekwc_size_chart id="%d"]', $post_id ) ); ?>" />
    </label>
</div>