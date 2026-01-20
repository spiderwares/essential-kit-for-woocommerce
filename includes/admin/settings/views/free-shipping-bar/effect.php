<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Fetch the effect-related fields from the EKWC_Shipping_Admin_Settings class.
$fields = EKWC_Shipping_Admin_Settings::fsbwc_effect_field();

// Get the saved shipping bar settings from the WordPress options table.
$options = get_option( 'ekwc_shipping_bar_settings', true );

// Use WooCommerce's wc_get_template function to load the 'setting-forms.php' template.
// Pass necessary arguments to the template.
wc_get_template(
    'fields/setting-forms.php', // The template file to load.
    array(
        'title'   => 'Effect', // The title of the settings section.
        'metaKey' => 'ekwc_shipping_bar_settings', // The option key to be used for saving settings.
        'fields'  => $fields, // The fields to be displayed in the settings form.
        'options' => $options, // The current saved settings.
    ),
    'essential-tool-for-woocommerce/fields/', // The folder within the plugin's template directory.
    EKWC_TEMPLATE_PATH // The path to the templates folder for the plugin.
);
?>
