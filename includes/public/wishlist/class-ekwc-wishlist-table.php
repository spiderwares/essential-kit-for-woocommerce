<?php 
/**
 * Wishlist Table Class
 * 
 * This class handles the rendering of the wishlist table using WooCommerce templates.
 * 
 * @package Essential Kit for WooCommerce
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; 

if ( ! class_exists( 'EKWC_Wishlist_Table' ) ) :

/**
 * Class EKWC_Wishlist_Table
 *
 * Handles the wishlist table rendering through shortcodes.
 */
class EKWC_Wishlist_Table {

    /**
     * Constructor.
     *
     * Adds the shortcode for displaying the wishlist table.
     */
    public function __construct() {
        add_shortcode( 'ekwc_wishlist', [ $this, 'render_wishlist_table' ] );
    }

    /**
     * Render Wishlist Table using wc_get_template().
     *
     * @return string Rendered wishlist table.
     */
    public function render_wishlist_table() {
        $setting = get_option( 'ekwc_wishlist_setting' );

        ob_start();
        
        // Check if a specific wishlist is being viewed.
        if ( isset( $_GET['view'] ) && ! empty( $_GET['view'] ) ) :

            $wishlist_token = sanitize_text_field( wp_unslash( $_GET['view'] ) );
            $wishlist       = ekwc_get_product_ids_by_wishlist_token( $wishlist_token );
            $current_url    = isset( $_SERVER['REQUEST_URI'] ) ? esc_url( home_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) ) : '';



            // Load the wishlist table template.
            wc_get_template(
                'wishlist/wishlist-table.php',
                array(
                    'wishlist'       => $wishlist,
                    'setting'        => $setting,
                    'current_url'    => $current_url,
                    'wishlist_token' => $wishlist_token
                ),
                'essential-tool-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );              
        else:
            
            // Retrieve user wishlists.
            $wishlists = ekwc_get_user_wishlists();
            
            // Load the wishlist management template.
            wc_get_template(
                'wishlist/wishlist-manage-table.php',
                array(
                    'wishlists' => $wishlists,
                    'setting'   => $setting,
                ),
                'essential-tool-for-woocommerce/',
                EKWC_TEMPLATE_PATH
            );
        endif;
        
        return ob_get_clean();
    }
}

// Initialize the Wishlist Table class.
new EKWC_Wishlist_Table();

endif;