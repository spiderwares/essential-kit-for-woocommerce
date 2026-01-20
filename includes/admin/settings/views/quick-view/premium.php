<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the advanced settings fields for the Quick View feature 
 * from the EKWC_Quick_View_Admin_Settings class.
 *
 * @var array $fields Array of settings fields related to Quick View content options.
 */
$fields = EKWC_Quick_View_Admin_Settings::advance_field();

/**
 * Get the saved Quick View settings from the WordPress options table.
 *
 * @var array|bool $options Retrieved settings array or false if not set.
 */
$options = get_option( 'ekwc_quick_view_setting', true );

/**
 * Load the settings form template for the Quick View content options.
 *
 * This template allows users to configure the content settings for Quick View.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Content Options',
        'metaKey' => 'ekwc_quick_view_setting',
        'fields'  => $fields, 
        'options' => $options, 
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH
);