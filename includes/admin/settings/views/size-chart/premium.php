<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the premium settings fields for the Size Chart feature
 * from the EKWC_Size_Chart_Admin_Settings class.
 *
 * @var array $fields Array of settings fields for premium Size Chart options.
 */
$fields = EKWC_Size_Chart_Admin_Settings::premium_fields();

/**
 * Retrieve the saved Size Chart settings from the WordPress options table.
 *
 * @var array|false $options Retrieved settings array or false if not set.
 */
$options = get_option( 'ekwc_size_chart_setting', true );

/**
 * Load the settings form template for the Size Chart premium settings.
 *
 * This template renders a form allowing users to configure premium-related
 * Size Chart settings within the admin panel.
 */
wc_get_template(
	'fields/setting-forms.php',
	array(
		'title'   => 'Premium Settings',
		'metaKey' => 'ekwc_size_chart_setting',
		'fields'  => $fields,
		'options' => $options,
	),
	'essential-tool-for-woocommerce/fields/',
	EKWC_TEMPLATE_PATH
);
