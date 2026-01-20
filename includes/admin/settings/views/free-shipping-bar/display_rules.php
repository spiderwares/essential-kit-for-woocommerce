<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; // Prevent direct file access.

/**
 * Fetch the display rules fields from the EKWC_Shipping_Admin_Settings class.
 *
 * @var array $fields Array of display rule fields for the Free Shipping Bar.
 */
$fields = EKWC_Shipping_Admin_Settings::display_rules_field();

/**
 * Retrieve the saved shipping bar settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_shipping_bar_settings', true );

/**
 * Load the settings form template for the display rules.
 *
 * This template handles the configuration for hiding the Free Shipping Bar on specific pages.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Hide on Page',
        'metaKey' => 'ekwc_shipping_bar_settings',
        'fields'  => $fields,
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH 
);
?>
