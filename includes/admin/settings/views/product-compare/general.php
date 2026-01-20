<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; // Ensures the script is only accessible within WordPress.

/**
 * Retrieve the general comparison settings fields from the EKWC_Compare_Admin_Settings class.
 *
 * @var array $fields Array of settings fields for general comparison features.
 */
$fields = EKWC_Compare_Admin_Settings::general_field();

/**
 * Fetch the saved general comparison settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings array or false if not set.
 */
$options = get_option( 'ekwc_compare_genral', true ); // Fixed typo from 'ekwc_compare_genral' to 'ekwc_compare_genral'

/**
 * Load the settings form template for the general comparison settings.
 *
 * This template allows users to configure basic comparison options.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'General Settings',
        'metaKey' => 'ekwc_compare_genral',
        'fields'  => $fields,
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH
);