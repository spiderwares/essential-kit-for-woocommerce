<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve style fields from the general settings class.
 *
 * @var array $fields Array of style fields.
 */
$fields = EKWC_General_Setting::style_field();

/**
 * Get the saved options for style settings.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_general_setting', true );

/**
 * Load the style settings form template.
 *
 * This template is used to render the style fields in the admin settings.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'Style', 
        'metaKey' => 'ekwc_general_setting', 
        'fields'  => $fields, 
        'options' => $options,
    ),
    'essential-tool-for-woocommerce/fields/',
    EKWC_TEMPLATE_PATH 
);
