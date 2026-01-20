<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the Style settings fields for the Quick View feature 
 * from the EKWC_Quick_View_Admin_Settings class.
 *
 * @var array $fields Array of settings fields related to Quick View Style.
 */
$fields = EKWC_Quick_View_Admin_Settings::style_field();

/**
 * Get the saved Quick View settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings array or false if not set.
 */
$options = get_option( 'ekwc_quick_view_setting', true );

/**
 * Load the settings form template for the Quick View Style settings.
 *
 * This template allows users to configure various Style options 
 * for the Quick View feature.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Style Settings',
        'metaKey' => 'ekwc_quick_view_setting',
        'fields'  => $fields,
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH
);