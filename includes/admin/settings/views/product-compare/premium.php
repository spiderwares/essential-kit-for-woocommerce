<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; // Ensures the script is only accessible via WordPress.

/**
 * Retrieve the advanced comparison fields from the EKWC_Compare_Admin_Settings class.
 *
 * @var array $fields Array of settings fields for premium comparison features.
 */
$fields = EKWC_Compare_Admin_Settings::compare_premium_field();

/**
 * Fetch the saved premium comparison settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_compare_premium', true );

/**
 * Load the settings form template for the premium comparison features.
 *
 * This template allows users to configure additional comparison options.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Premium Features',
        'metaKey' => 'ekwc_compare_premium',
        'fields'  => $fields, 
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/', 
    EKWC_TEMPLATE_PATH 
);
?>
