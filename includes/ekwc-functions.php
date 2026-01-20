<?php
/**
 * Utility functions for Essential Kit For WooCommerce plugin.
 *
 * @package Essential Kit For WooCommerce
 */

defined( 'ABSPATH' ) || exit;

/**
 * Save or update a wishlist in the database.
 *
 * @param array $args Wishlist data.
 * @return int|bool Wishlist ID on success, false on failure.
 */
if ( ! function_exists( 'ekwc_save_wishlist' ) ) :

    function ekwc_save_wishlist( $args ) {
        global $wpdb;

        // Ensure required arguments are set
        if ( empty( $args ) || ! is_array( $args ) ) return false;

        $wishlist_table = $wpdb->prefix . 'ekwc_wishlists';

        // Prepare data for database
        $data = apply_filters(
            'ekwc_save_wishlist_data',
            array(
                'user_id'           => isset( $args['user_id'] ) ? absint( $args['user_id'] ) : null,
                'session_id'        => isset( $args['session_id'] ) ? sanitize_text_field( $args['session_id'] ) : null,
                'wishlist_slug'     => sanitize_title( $args['wishlist_slug'] ),
                'wishlist_name'     => sanitize_text_field( $args['wishlist_name'] ),
                'wishlist_token'    => sanitize_text_field( $args['wishlist_token'] ),
                'wishlist_privacy'  => isset( $args['wishlist_privacy'] ) ? absint( $args['wishlist_privacy'] ) : 0,
                'expiration'        => isset( $args['expiration'] ) ? sanitize_text_field( $args['expiration'] ) : null,
            )
        );

        $format = [ '%d', '%s', '%s', '%s', '%s', '%d', '%s' ];

        do_action( 'ekwc_before_save_wishlist', $args );

        // Check if updating or inserting a new wishlist
        if ( ! empty( $args['wishlist_id'] ) ) :
            $wishlist_id = absint( $args['wishlist_id'] );
            $updated     = $wpdb->update( $wishlist_table, $data, [ 'ID' => $wishlist_id ], $format, [ '%d' ] );

            if ( false === $updated ) :
                return false; // Update failed
            endif;
        else :
            $wpdb->insert( $wishlist_table, $data, $format );

            $wishlist_id = $wpdb->insert_id;
            if ( ! $wishlist_id ) :
                return false; // Insert failed
            endif;
        endif;

        // Trigger action after wishlist is saved
        do_action( 'ekwc_after_save_wishlist', $wishlist_id, $args );

        return $wishlist_id;
    }

endif;


/**
 * Save or update a wishlist item in the database.
 *
 * @param array $args Wishlist item data.
 * @return int|bool Wishlist item ID on success, false on failure.
 */
if ( ! function_exists( 'ekwc_save_wishlist_item' ) ) :

    function ekwc_save_wishlist_item( $args ) {
        global $wpdb;

        // Ensure required arguments are set
        if ( empty( $args ) || ! is_array( $args ) ) return false;

        $wishlist_item_table = $wpdb->prefix . 'ekwc_wishlist_item';

        // Prepare data for database
        $data = apply_filters(
            'ekwc_save_wishlist_item_data',
            array(
                'prod_id'      => isset( $args['prod_id'] ) ? absint( $args['prod_id'] ) : 0,
                'user_id'      => isset( $args['user_id'] ) ? absint( $args['user_id'] ) : 0,
                'wishlist_id'  => isset( $args['wishlist_id'] ) ? absint( $args['wishlist_id'] ) : 0,
            )
        );

        $format = [ '%d', '%d', '%d' ];

        do_action( 'ekwc_before_save_wishlist_item', $args );

        // Check if updating or inserting a new wishlist item
        if ( ! empty( $args['item_id'] ) ) :
            $item_id = absint( $args['item_id'] );
            $updated = $wpdb->update( $wishlist_item_table, $data, [ 'ID' => $item_id ], $format, [ '%d' ] );

            if ( false === $updated ) :
                return false; // Update failed
            endif;
        else :
            $wpdb->insert( $wishlist_item_table, $data, $format );

            $item_id = $wpdb->insert_id;
            if ( ! $item_id ) :
                return false; // Insert failed
            endif;
        endif;

        // Trigger action after wishlist item is saved
        do_action( 'ekwc_after_save_wishlist_item', $item_id, $args );

        return $item_id;
    }

endif;


/**
 * Get the product IDs in the wishlist from the database.
 *
 * This function retrieves the product IDs associated with a user's wishlist from the database.
 *
 * @param array $args Wishlist item data, including necessary parameters such as user ID or wishlist ID.
 * @return array|bool An array of product IDs on success, or false on failure.
 */
if ( ! function_exists( 'ekwc_get_wishlist_product_ids' ) ) :

    function ekwc_get_wishlist_product_ids() {
        global $wpdb;

        $wishlist_ids = [];

        if ( is_user_logged_in() ) :
            $user_id = get_current_user_id();

            // Fetch wishlist items from database for logged-in users
            $wishlist_ids = $wpdb->get_col( 
                $wpdb->prepare(
                    "SELECT prod_id FROM {$wpdb->prefix}ekwc_wishlist_item WHERE user_id = %d",
                    $user_id
                ) 
            );
        else :
            $session_id = isset( $_COOKIE['ekwc_wishlist_session'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ekwc_wishlist_session'] ) )  : '';

            if ( ! empty( $session_id ) ) :
                // Fetch wishlist items from database for guest users
                $wishlist_ids = $wpdb->get_col(
                    $wpdb->prepare(
                        "SELECT prod_id FROM {$wpdb->prefix}ekwc_wishlist_item 
                        WHERE wishlist_id IN (SELECT ID FROM {$wpdb->prefix}ekwc_wishlists WHERE session_id = %s)",
                        $session_id
                    )
                );
            endif;
        endif;

        return is_array( $wishlist_ids ) ? $wishlist_ids : [];
    }

endif;

/**
 * Retrieve wishlists for a user from the database.
 *
 * @param int|null $user_id (Optional) User ID. If null, fetch for the logged-in user.
 * @return array List of wishlists (ID & Name).
 */
if ( ! function_exists( 'ekwc_get_user_wishlists' ) ) :

    function ekwc_get_user_wishlists( $user_id = null ) {
        global $wpdb;

        // Determine user ID (for logged-in users)
        if ( is_null( $user_id ) && is_user_logged_in() ) :
            $user_id = get_current_user_id();
        endif;

        $wishlist_table = $wpdb->prefix . 'ekwc_wishlists';
        $wishlist_table = esc_sql( $wishlist_table );
        $wishlists      = [];

        if ( $user_id ) :
            // Fetch wishlists for logged-in users
            $wishlists = $wpdb->get_results( 
                $wpdb->prepare(
                    "SELECT * FROM {$wishlist_table} WHERE user_id = %d",
                    $user_id
                ), 
                ARRAY_A 
            );
        else :
            // Fetch wishlists for guest users based on session
            $session_id = isset( $_COOKIE['ekwc_wishlist_session'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['ekwc_wishlist_session'] ) ) : '';

            if ( ! empty( $session_id ) ) :
                $wishlists = $wpdb->get_results( 
                    $wpdb->prepare(
                        "SELECT * FROM $wishlist_table WHERE session_id = %s",
                        $session_id
                    ), 
                    ARRAY_A 
                );
            endif;
        endif;

        return ! empty( $wishlists ) ? $wishlists : [];
    }

endif;

/**
 * Get all items in a wishlist along with the total count.
 *
 * @param int $wishlist_id The ID of the wishlist.
 * @return array An array containing wishlist items and the total count.
 */
if ( ! function_exists( 'ekwc_get_wishlist_items_with_count' ) ) :

    function ekwc_get_wishlist_items_with_count( $wishlist_id ) {
        global $wpdb;

        if ( empty( $wishlist_id ) || ! is_numeric( $wishlist_id ) ) :
            return [ 'count' => 0, 'items' => [] ]; // Return empty data if no valid wishlist ID
        endif;        

        // Retrieve all wishlist items
        $wishlist_items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}ekwc_wishlist_item WHERE wishlist_id = %d",
                $wishlist_id
            ),
            ARRAY_A
        );

        // Get the count of items in the wishlist
        $count = count( $wishlist_items );

        return [
            'count' => $count,
            'items' => $wishlist_items
        ];
    }

endif;

/**
 * Delete a wishlist and its associated items.
 *
 * @param int $wishlist_id The ID of the wishlist to delete.
 * @return bool True on success, false on failure.
 */
if ( ! function_exists( 'ekwc_delete_wishlist' ) ) :

    function ekwc_delete_wishlist( $wishlist_id ) {
        global $wpdb;

        if ( empty( $wishlist_id ) || ! is_numeric( $wishlist_id ) ) :
            return false; // Invalid wishlist ID
        endif;

        $wishlist_table = $wpdb->prefix . 'ekwc_wishlists';
        $wishlist_item_table = $wpdb->prefix . 'ekwc_wishlist_item';

        do_action( 'ekwc_before_delete_wishlist', $wishlist_id );

        // Delete wishlist items first
        $wpdb->delete( $wishlist_item_table, [ 'wishlist_id' => $wishlist_id ], [ '%d' ] );

        // Delete wishlist itself
        $deleted = $wpdb->delete( $wishlist_table, [ 'ID' => $wishlist_id ], [ '%d' ] );

        if ( false === $deleted ) :
            return false; // Deletion failed
        endif;

        do_action( 'ekwc_after_delete_wishlist', $wishlist_id );

        return true;
    }

endif;


/**
 * Get product IDs from a wishlist using the wishlist token.
 *
 * @param string $wishlist_token The token of the wishlist.
 * @return array|bool An array of product IDs on success, or false if not found.
 */
if ( ! function_exists( 'ekwc_get_product_ids_by_wishlist_token' ) ) :

    function ekwc_get_product_ids_by_wishlist_token( $wishlist_token ) {
        global $wpdb;

        if ( empty( $wishlist_token ) ) :
            return false; // Invalid token
        endif;

        // Get wishlist ID using the token
        $wishlist_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->prefix}ekwc_wishlists WHERE wishlist_token = %s",
                $wishlist_token
            )
        );

        if ( empty( $wishlist_id ) ) :
            return false; // Wishlist not found
        endif;

        // Get product IDs associated with the wishlist
        $product_ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT prod_id FROM {$wpdb->prefix}ekwc_wishlist_item WHERE wishlist_id = %d",
                $wishlist_id
            )
        );

        return ! empty( $product_ids ) ? $product_ids : false;
    }

endif;


/**
 * Retrieve the wishlist ID based on a given wishlist token.
 *
 * This function queries the database to find the wishlist ID associated with the provided
 * wishlist token. If the token is invalid or no wishlist is found, it returns false.
 *
 * @param string $wishlist_token The token of the wishlist.
 * 
 * @return int|false The wishlist ID on success, or false if the token is invalid or no wishlist is found.
 */
if ( ! function_exists( 'ekwc_get_wishlist_id_by_token' ) ) :

    function ekwc_get_wishlist_id_by_token( $wishlist_token ) {
        global $wpdb;

        if ( empty( $wishlist_token ) ) :
            return false; // Invalid token
        endif;

        // Get wishlist ID using the token
        $wishlist_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->prefix}ekwc_wishlists WHERE wishlist_token = %s",
                $wishlist_token
            )
        );
        return ! empty( $wishlist_id ) ? $wishlist_id : false;
    }

endif;