<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit; // Prevent direct access to the file.

/**
 * Retrieve the fields for General settings from the EKWC_General_Setting class.
 *
 * @var array $fields Array of general settings fields.
 */
$fields = EKWC_General_Setting::general_field();

/**
 * Get the saved options for general settings.
 *
 * @var array|bool $options Retrieved settings or false if not set.
 */
$options = get_option( 'ekwc_general_setting', true );

/**
 * Load the general settings form template.
 *
 * This template is used to render the general settings fields in the admin settings.
 */
wc_get_template(
    'fields/setting-forms.php',
    array(
        'title'   => 'General Options', 
        'metaKey' => 'ekwc_general_setting', 
        'fields'  => $fields, 
        'options' => $options, 
    ),
    'essential-tool-for-woocommerce/fields/', 
    EKWC_TEMPLATE_PATH
);
