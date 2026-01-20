<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the general settings fields for the Size Chart feature
 * from the EKWC_Size_Chart_Admin_Settings class.
 *
 * @var array $fields Array of settings fields related to Size Chart general settings.
 */
$fields = EKWC_Size_Chart_Admin_Settings::general_field();

/**
 * Retrieve the saved Size Chart settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings array or false if not set.
 */
$options = get_option( 'ekwc_size_chart_setting', true );

/**
 * Load the settings form template for the Size Chart general settings.
 *
 * This template displays a form that allows users to configure general settings
 * related to the Size Chart functionality.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'General Settings',
        'metaKey' => 'ekwc_size_chart_setting',
        'fields'  => $fields,
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH
);