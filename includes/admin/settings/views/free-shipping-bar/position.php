<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; // Prevent direct file access.

/**
 * Retrieve the position settings fields from the EKWC_Shipping_Admin_Settings class.
 *
 * @var array $fields Array of position settings fields for the Free Shipping Bar.
 */
$fields = EKWC_Shipping_Admin_Settings::position_field();

/**
 * Fetch the saved shipping bar settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_shipping_bar_settings', true );

/**
 * Load the settings form template for the position settings.
 *
 * This template allows users to configure the position of the Free Shipping Bar.
 */
wc_get_template(
    'fields/setting-forms.php', 
    array(
        'title'   => 'Shipping Bar Position',
        'metaKey' => 'ekwc_shipping_bar_settings',
        'fields'  => $fields,
        'options' => $options, 
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH 
);
?>
