<?php
/**
 * Plugin Name:       Essential Kit For Woocommerce
 * Description:       A powerful, all-in-one toolkit to enhance your WooCommerce store. Includes must-have features like product compare, quick view, wishlist, free shipping bar, and more — all designed to boost conversions and improve the customer experience.
 * Version:           1.0.8
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            jthemesstudio
 * Author URI:        https://jthemes.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins:  woocommerce
 * Text Domain:       essential-kit-for-woocommerce
 *
 * @package Essential Kit For Woocommerce
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'EKWC_FILE' ) ) :
    define( 'EKWC_FILE', __FILE__ ); // Define the plugin file path.
endif;

if ( ! defined( 'EKWC_BASENAME' ) ) :
    define( 'EKWC_BASENAME', plugin_basename( EKWC_FILE ) ); // Define the plugin basename.
endif;

if ( ! defined( 'EKWC_VERSION' ) ) :
    define( 'EKWC_VERSION', '1.0.8' ); // Define the plugin version.
endif;

if ( ! defined( 'EKWC_PATH' ) ) :
    define( 'EKWC_PATH', plugin_dir_path( __FILE__ ) ); // Define the plugin directory path.
endif;

if ( ! defined( 'EKWC_TEMPLATE_PATH' ) ) :
	define( 'EKWC_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . '/templates/' ); // Define the plugin directory path.
endif;

if ( ! defined( 'EKWC_URL' ) ) :
    define( 'EKWC_URL', plugin_dir_url( __FILE__ ) ); // Define the plugin directory URL.
endif;

if ( ! defined( 'EKWC_REVIEWS' ) ) :
    define( 'EKWC_REVIEWS', 'https://jthemes.com/' ); // Define the plugin directory URL.
endif;

if ( ! defined( 'EKWC_CHANGELOG' ) ) :
    define( 'EKWC_CHANGELOG', 'https://jthemes.com/' ); // Define the plugin directory URL.
endif;

if ( ! defined( 'EKWC_DISCUSSION' ) ) :
    define( 'EKWC_DISCUSSION', 'https://jthemes.com/' ); // Define the plugin directory URL.
endif;

if ( ! defined( 'EKWC_PRO_VERSION_URL' ) ) :
    define( 'EKWC_PRO_VERSION_URL', 'https://codecanyon.net/item/essential-kit-for-woocommerce/57741240' ); // Define the Pro Version URL.
endif;

if ( ! class_exists( 'EKWC', false ) ) :
    include_once EKWC_PATH . 'includes/class-ekwc.php';
endif;

$GLOBALS['ekwc'] = EKWC::instance();
