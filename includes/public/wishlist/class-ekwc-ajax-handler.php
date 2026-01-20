<?php
/**
 * AJAX Handler for Wishlist
 *
 * Handles AJAX requests for adding, removing, and deleting wishlist items.
 *
 * @package Essential Kit for WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

if ( ! class_exists( 'EKWC_Ajax_Handler' ) ) :

    /**
     * Class EKWC_Ajax_Handler
     *
     * Handles AJAX actions related to the wishlist.
     */
    class EKWC_Ajax_Handler {

        /**
         * Wishlist settings.
         *
         * @var array
         */
        private $wishlist_settings;

        /**
         * Wishlist table name.
         *
         * @var string
         */
        private $wishlist_table;

        /**
         * Wishlist item table name.
         *
         * @var string
         */
        private $wishlist_item_table;

        /**
         * Constructor.
         *
         * Initializes class properties and hooks AJAX actions.
         */
        public function __construct() {
            global $wpdb;
            $this->wishlist_settings   = get_option( 'ekwc_wishlist_setting', [] );
            $this->wishlist_table      = $wpdb->prefix . 'ekwc_wishlists';
            $this->wishlist_item_table = $wpdb->prefix . 'ekwc_wishlist_item';
            
            $this->event_handler();
        }

        /**
         * Register AJAX events.
         */
        public function event_handler() {
            add_action( 'init', array( $this, 'create_wishlist_page' ) );
            add_action( 'wp_ajax_ekwc_add_to_wishlist', array( $this, 'add_to_wishlist' ) );
            add_action( 'wp_ajax_nopriv_ekwc_add_to_wishlist', array( $this, 'add_to_wishlist' ) );
            add_action( 'wp_ajax_ekwc_remove_from_wishlist', array( $this, 'remove_from_wishlist' ) );
            add_action( 'wp_ajax_nopriv_ekwc_remove_from_wishlist', array( $this, 'remove_from_wishlist' ) );        
            add_action( 'wp_ajax_ekwc_delete_wishlist', array( $this, 'delete_wishlist' ) );
            add_action( 'wp_ajax_nopriv_ekwc_delete_wishlist', array( $this, 'delete_wishlist' ) ); 
            add_action( 'wp_ajax_get_wishlist_page_url', array( $this, 'get_wishlist_page_url_callback' ) );
            add_action( 'wp_ajax_nopriv_get_wishlist_page_url', array( $this, 'get_wishlist_page_url_callback' ) );        
        }

        /**
         * Retrieve wishlist ID based on user or session.
         *
         * @param int|null    $user_id    User ID.
         * @param string|null $session_id Session ID.
         *
         * @return int|null Wishlist ID.
         */
        public function get_wishlist_id( $user_id, $session_id ) {
            global $wpdb;
            return $wpdb->get_var( $wpdb->prepare(
                "SELECT ID FROM {$this->wishlist_table} WHERE (user_id = %d OR session_id = %s) LIMIT 1",
                $user_id, $session_id
            ));
        }

        /**
         * Handle adding a product to the wishlist.
         */
        public function add_to_wishlist() {
            global $wpdb;

            // Verify nonce for security.
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ekwc_wishlist_nonce' ) ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid security token.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            // Validate product ID.
            $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
            if ( ! $product_id ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid product.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            $user_id        = is_user_logged_in() ? get_current_user_id() : null;
            $session_id     = $user_id ? null : ( isset( $_COOKIE['ekwc_wishlist_session'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ekwc_wishlist_session'] ) ) : wp_generate_uuid4() );
            
            if (!$user_id) :
                setcookie( 'ekwc_wishlist_session', $session_id, time() + (86400 * 30), '/' );
            endif;

            $wishlist_id    = $this->get_wishlist_id( $user_id, $session_id );
            if ( ! $wishlist_id ) :

                $wishlist_name = isset( $this->wishlist_settings['default_wishlist_name'] ) && ! empty( $this->wishlist_settings['default_wishlist_name'] ) 
                                ? $this->wishlist_settings['default_wishlist_name'] 
                                : esc_html__( 'My Wishlist', 'essential-kit-for-woocommerce' );

                $wishlist_id = ekwc_save_wishlist( [
                    'user_id'           => $user_id,
                    'session_id'        => $session_id,
                    'wishlist_slug'     => 'default',
                    'wishlist_name'     => $wishlist_name,
                    'wishlist_token'    => wp_generate_password( 8, false ),
                    'wishlist_privacy'  => 0,
                ] );
                
                if ( ! $wishlist_id ) :
                    wp_send_json_error( [ 'message' => esc_html__( 'Failed to create wishlist.', 'essential-kit-for-woocommerce' ) ] );
                endif;
            endif;

            $exists = $wpdb->get_var( $wpdb->prepare(
                "SELECT ID FROM {$this->wishlist_item_table} WHERE wishlist_id = %d AND prod_id = %d",
                $wishlist_id, $product_id
            ));

            if ( $exists ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Already in wishlist.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            $wishlist_item_id = ekwc_save_wishlist_item( [
                'prod_id'     => $product_id,
                'user_id'     => $user_id,
                'wishlist_id' => $wishlist_id,
            ] );

            if ( ! $wishlist_item_id ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Failed to add item to wishlist.', 'essential-kit-for-woocommerce' ) ] );
            else:
                wp_send_json_success( [ 'message' => esc_html__( 'Added to wishlist.', 'essential-kit-for-woocommerce' ) ] );
            endif;
        }

        /**
         * Remove a product to the wishlist.
         */
        public function remove_from_wishlist() {
            global $wpdb;
        
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ekwc_wishlist_nonce' ) ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid security token.', 'essential-kit-for-woocommerce' ) ] );
            endif;
        
            $product_id       = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
            $wishlist_token   = isset( $_POST['wishlist_token'] ) ? sanitize_text_field( wp_unslash( $_POST['wishlist_token'] ) ) : '';
            $wishlist_id      = ekwc_get_wishlist_id_by_token( $wishlist_token );

            if( !isset($_POST['wishlist_token']) ):
                $user_id    = is_user_logged_in() ? get_current_user_id() : null;
                $session_id = $user_id ? null : ( isset( $_COOKIE['ekwc_wishlist_session'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ekwc_wishlist_session'] ) ) : '' );
                $wishlist_id = $this->get_wishlist_id( $user_id, $session_id );
            endif;

            if ( ! $product_id ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid product.', 'essential-kit-for-woocommerce' ) ] );
            endif;
        
            if ( ! $wishlist_id ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Wishlist not found.', 'essential-kit-for-woocommerce' ) ] );
            endif;
        
            // Prepare the query
            $query = $wpdb->prepare(
                "DELETE FROM {$this->wishlist_item_table} WHERE wishlist_id = %d AND prod_id = %d",
                $wishlist_id,
                $product_id
            );
        
            // Perform the deletion
            $wpdb->query( $query );
        
            wp_send_json_success( [ 'message' => esc_html__( 'Removed from wishlist.', 'essential-kit-for-woocommerce' ) ] );
        }
        

        /**
         * Delete the wishlist.
         */
        public function delete_wishlist() {

            // Verify nonce for security.
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ekwc_wishlist_nonce' ) ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid security token.', 'essential-kit-for-woocommerce' ) ] );
            endif;
        
            if (!isset($_POST['wishlist_id'])) :
                wp_send_json_error("Invalid request!");
            endif;
        
            $wishlist_id = intval($_POST['wishlist_id']);
        
            // Call the function to delete the wishlist
            $deleted = ekwc_delete_wishlist( $wishlist_id );
        
            if ($deleted) :
                wp_send_json_success("Wishlist deleted successfully!");
            else :
                wp_send_json_error("Failed to delete wishlist.");
            endif;
        }

        /**
         * Create a wishlist page.
         */
        public function create_wishlist_page() {
            $page_id = get_option('ekwc_wishlist_page_id');
        
            if ($page_id && get_post_status($page_id) === 'publish') :
                return;
            endif;
        
            $page_title = 'Wishlist';
        
            // Check if the page already exists using WP_Query
            $query = new WP_Query([
                'post_type'   => 'page',
                'title'       => $page_title,
                'post_status' => 'publish',
                'fields'      => 'ids',
                'posts_per_page' => 1
            ]);
        
            // If no page is found, create a new one
            if (!$query->have_posts()) :
                $page_id = wp_insert_post([
                    'post_title'     => $page_title,
                    'post_content'   => '[ekwc_wishlist]',
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'post_author'    => get_current_user_id(),
                    'comment_status' => 'closed',
                ]);
        
                if ($page_id) :
                    update_option('ekwc_wishlist_page_id', $page_id);
                endif;
            else :
                // Save the existing page ID in options if found
                $existing_page_id = $query->posts[0];
                update_option('ekwc_wishlist_page_id', $existing_page_id);
            endif;
        }

        /**
         * Handles the AJAX request to get the wishlist page URL.
         *
         * Verifies nonce for security, retrieves the wishlist settings, and 
         * returns the wishlist page URL or an error message.
         */
        public function get_wishlist_page_url_callback() {
            // Verify nonce for security.
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ekwc_wishlist_nonce' ) ) :
                wp_send_json_error( [ 'message' => esc_html__( 'Invalid security token.', 'essential-kit-for-woocommerce' ) ] );
            endif;

            // Get wishlist settings from options
            $wishlist_settings = get_option( 'ekwc_wishlist_setting' );

            if ( isset( $wishlist_settings['wishlist_page'] ) ) :
                // Get the page ID of the wishlist page
                $wishlist_page_id = $wishlist_settings['wishlist_page'];

                // Get the URL of the wishlist page
                $wishlist_page_url = get_permalink( $wishlist_page_id );

                if ( $wishlist_page_url ) :
                    wp_send_json_success( [ 'url' => $wishlist_page_url ] );
                else :
                    wp_send_json_error( [ 'message' => 'Wishlist page not found' ] );
                endif;
            else :
                wp_send_json_error( [ 'message' => 'Wishlist page setting not found' ] );
            endif;
        }
        
    }

    new EKWC_Ajax_Handler();
endif;