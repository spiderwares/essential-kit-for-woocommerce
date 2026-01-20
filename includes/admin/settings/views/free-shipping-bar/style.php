<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; // Prevent direct access to the file.

/**
 * Retrieve the style fields for the Free Shipping Bar settings from the EKWC_Shipping_Admin_Settings class.
 *
 * @var array $fields Array of style-related settings fields.
 */
$fields = EKWC_Shipping_Admin_Settings::style_field();

/**
 * Get the saved options for the Free Shipping Bar style settings.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_shipping_bar_settings', true );

/**
 * Load the style settings form template.
 *
 * This template is used to render the style-related settings fields in the admin panel.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Topbar Style',
        'metaKey' => 'ekwc_shipping_bar_settings',
        'fields'  => $fields,
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH
);