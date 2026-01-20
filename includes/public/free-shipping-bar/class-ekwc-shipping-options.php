<?php
// Ensure the file is being called from a valid WordPress environment.
defined( 'ABSPATH' ) || exit;

// Prevent direct access if not included in a WordPress environment.
if ( ! class_exists( 'EKWC_Shipping_Options' ) ) :

	/**
	 * EKWC_Shipping_Options class
	 * Handles the settings and functionality for free shipping options.
	 */
	class EKWC_Shipping_Options {
		// Declare private property to hold shipping options.
		private $options;

		/**
		 * Constructor - Initializes the shipping options.
		 */
		function __construct() {
			// Check if the options are not already set and then fetch them from the database.
			if ( ! $this->options ) :
				$this->options = get_option( 'ekwc_shipping_bar_settings', array() );
			endif;
		}

		/**
		 * Converts a string to an integer by removing any non-numeric characters.
		 *
		 * @param string $str The string to be converted.
		 * @return string The cleaned string containing only numeric values.
		 */
		public function toInt( $str ) {
			// Remove any non-numeric characters except for the dot (decimal point).
			return preg_replace( '/([^0-9\\.])/i', '', $str );
		}

		/**
		 * Filters the availability of free shipping based on the settings.
		 *
		 * @param bool $is_available The current availability status of the shipping method.
		 * @param array $package The package being shipped.
		 * @param object $_this The current instance of the class.
		 * @return bool Modified availability status of the shipping method.
		 */
		public function free_shipping_option( $is_available, $package, $_this ) {
			// Check if we need to ignore discounts (if set in the instance).
			if ( ! $this->ignore_discounts ) :
				$this->ignore_discounts = $_this->ignore_discounts;
			endif;

			// Return the availability status.
			return $is_available;
		}

		/**
		 * Retrieves the value of a specific option from the settings.
		 *
		 * @param string $field_name The name of the field (option) to retrieve.
		 * @param mixed $default The default value to return if the option is not found.
		 * @return mixed The option value, or the default value if the option is not set.
		 */
		public function get_option( $field_name, $default = '' ) {
			// Check if the option exists and apply a filter to modify the value.
			if ( isset( $this->options[ $field_name ] ) ) :
				return apply_filters( 'ekwc_free_shipping_bar_get_option_' . $field_name, $this->options[ $field_name ] );
			endif;

			// Return the default value if the option does not exist.
			return $default;
		}

		/**
		 * Checks if the current shipping zone is active.
		 *
		 * @return bool True if the shipping zone is active, false otherwise.
		 */
		public function is_active_shipping_zone() {
			global $wpdb;

			// Query to check for active free shipping in the shipping zones.
			$wfspb_query = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}woocommerce_shipping_zone_methods WHERE method_id = %s AND is_enabled = %d", 'free_shipping', 1 );
			$zone_data   = $wpdb->get_results( $wfspb_query, OBJECT );

			// Return true if the zone data exists (i.e., active zone).
			if ( ! empty( $zone_data ) ) :
				return true;
			endif;

			// Return false if no active zone is found.
			return false;
		}

		/**
		 * Retrieves a custom message for a specific notification.
		 *
		 * @param string $notification_name The name of the notification.
		 * @param string $defaultMessage The default message to show if no custom message is set.
		 * @return string The custom message if available, otherwise the default message.
		 */
		public function get_message( $notification_name, $defaultMessage = '' ) {
			// Get the custom message for the notification.
			$message = $this->get_option( $notification_name );

			// Return the message or default message if not set.
			return ! empty( $message ) ? $message : $defaultMessage;
		}

		/**
		 * Generates HTML link to the checkout page.
		 *
		 * @return string HTML for the checkout link.
		 */
		public function get_checkout_page_link_html() {
			// Retrieve the link color from the settings or default.
			$link_color = $this->get_option( 'link_color', '#83b834' );

			// Return the HTML for the checkout link.
			return '<a style="color:' . $link_color . '" href="' . wc_get_checkout_url() . '" title="' . esc_html__( 'Checkout', 'essential-kit-for-woocommerce' ) . '">' . esc_html__( 'Checkout', 'essential-kit-for-woocommerce' ) . '</a>';
		}

		/**
		 * Generates HTML link to the shop page.
		 *
		 * @return string HTML for the continue shopping link.
		 */
		public function get_shop_page_link_html() {
			// Retrieve the link color from the settings or default.
			$link_color = $this->get_option( 'link_color', '#83b834' );

			// Return the HTML for the continue shopping link.
			return '<a id="ekwc_continue_shopping" style="color:' . $link_color . '" href="' . get_permalink( get_option( 'woocommerce_shop_page_id' ) ) . '">' . esc_html__( 'Continue Shopping', 'essential-kit-for-woocommerce' ) . '</a>';
		}

		/**
		 * Detects the shipping method options based on the customer's location.
		 *
		 * @param string|null $country The country code.
		 * @param string $state The state code.
		 * @param string $postcode The postcode.
		 * @return array|false Shipping method details or false if no match.
		 */
		public static function detect_ip( $country = null, $state = '', $postcode = '' ) {
			global $wpdb;

			// Proceed only if the country is provided.
			if ( $country ) :
				// Initialize an array for search criteria.
				$criteria  = array();
				$continent = strtoupper( wc_clean( WC()->countries->get_continent_code_for_country( $country ) ) );

				// Set up criteria based on country, state, and continent.
				$criteria[] = $wpdb->prepare( "( ( location_type = 'country' AND location_code = %s )", $country );
				$criteria[] = ! empty( $state ) ? $wpdb->prepare( "OR ( location_type = 'state' AND location_code = %s )", $country . ':' . $state ) : '';
				$criteria[] = $wpdb->prepare( "OR ( location_type = 'continent' AND location_code = %s )", $continent );
				$criteria[] = 'OR ( location_type IS NULL ) )';

				// Handle postcode-specific logic if a postcode is provided.
				if ( $postcode ) :
					$postcode_locations = $wpdb->get_results( "SELECT zone_id, location_code FROM {$wpdb->prefix}woocommerce_shipping_zone_locations WHERE location_type = 'postcode';" );

					if ( $postcode_locations ) :
						$zone_ids_with_postcode_rules = array_map( 'absint', wp_list_pluck( $postcode_locations, 'zone_id' ) );
						$matches                      = wc_postcode_location_matcher( $postcode, $postcode_locations, 'zone_id', 'location_code', $country );
						$do_not_match                 = array_unique( array_diff( $zone_ids_with_postcode_rules, array_keys( $matches ) ) );

						// Exclude zones that do not match the postcode.
						if ( ! empty( $do_not_match ) ) :
							$criteria[] = 'AND zones.zone_id NOT IN (' . implode( ',', $do_not_match ) . ')';
						endif;
					endif;
				endif;

				// Query the database for matching shipping zones.
				$matching_zone_id = $wpdb->get_var(
					"SELECT zones.zone_id FROM {$wpdb->prefix}woocommerce_shipping_zones as zones
                    INNER JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as locations ON zones.zone_id = locations.zone_id AND location_type != 'postcode'
                    WHERE " . implode( ' ', $criteria ) . '
                    ORDER BY zone_order ASC LIMIT 1'
				);

				// Fetch the shipping methods for the matched zone.
				$shipping_methods = new WC_Shipping_Zone( $matching_zone_id ? $matching_zone_id : 0 );
				$shipping_methods = $shipping_methods->get_shipping_methods();
				foreach ( $shipping_methods as $i => $shipping_method ) :
					if ( is_numeric( $i ) ) :
						// Return details if 'free_shipping' is enabled.
						if ( $shipping_method->id == 'free_shipping' && $shipping_method->enabled == 'yes' ) :
							return array(
								'min_amount'       => $shipping_method->min_amount,
								'ignore_discounts' => $shipping_method->ignore_discounts,
							);
						endif;
					endif;
				endforeach;
			endif;

			// Return false if no matching shipping method is found.
			return false;
		}

		/**
		 * Retrieves the minimum amount for free shipping in the active shipping zone.
		 *
		 * @return array|false An array with the minimum amount and discount setting, or false if no zone is matched.
		 */
		public function get_shipping_min_amount() {
			// Retrieve global WordPress database object.
			global $wpdb;

			// Get customer's location details.
			$country          = strtoupper( wc_clean( WC()->customer->country ) );
			$state            = strtoupper( wc_clean( WC()->customer->state ) );
			$continent        = strtoupper( wc_clean( WC()->countries->get_continent_code_for_country( $country ) ) );
			$postcode         = wc_normalize_postcode( WC()->customer->postcode );
			$cache_key        = WC_Cache_Helper::get_cache_prefix( 'shipping_zones' ) . 'wc_shipping_zone_' . md5( sprintf( '%s+%s+%s', $country, $state, $postcode ) );
			$matching_zone_id = wp_cache_get( $cache_key, 'shipping_zones' );

			// Check the cache for the shipping zone, if not cached, query the database.
			if ( false === $matching_zone_id ) :

				// Setup the criteria for zone lookup.
				$criteria   = array();
				$criteria[] = $wpdb->prepare( "( ( location_type = 'country' AND location_code = %s )", $country );
				$criteria[] = $wpdb->prepare( "OR ( location_type = 'state' AND location_code = %s )", $country . ':' . $state );
				$criteria[] = $wpdb->prepare( "OR ( location_type = 'continent' AND location_code = %s )", $continent );
				$criteria[] = 'OR ( location_type IS NULL ) )';

				// Handle postcode matching.
				$postcode_locations = $wpdb->get_results( "SELECT zone_id, location_code FROM {$wpdb->prefix}woocommerce_shipping_zone_locations WHERE location_type = 'postcode';" );

				if ( $postcode_locations ) :
					$zone_ids_with_postcode_rules = array_map( 'absint', wp_list_pluck( $postcode_locations, 'zone_id' ) );
					$matches                      = wc_postcode_location_matcher( $postcode, $postcode_locations, 'zone_id', 'location_code', $country );
					$do_not_match                 = array_unique( array_diff( $zone_ids_with_postcode_rules, array_keys( $matches ) ) );

					// Exclude non-matching zones.
					if ( ! empty( $do_not_match ) ) :
						$criteria[] = 'AND zones.zone_id NOT IN (' . implode( ',', $do_not_match ) . ')';
					endif;
				endif;

				// Build the SQL query.
				$sql = "SELECT zones.zone_id 
				FROM {$wpdb->prefix}woocommerce_shipping_zones as zones 
				INNER JOIN {$wpdb->prefix}woocommerce_shipping_zone_locations as locations 
					ON zones.zone_id = locations.zone_id 
					AND location_type != 'postcode' 
				WHERE ( 
					( location_type = 'country' AND location_code = %s )
					OR ( location_type = 'state' AND location_code = %s )
					OR ( location_type = 'continent' AND location_code = %s )
					OR ( location_type IS NULL ) 
				)";

				// Prepare query args.
				$query_args = array( $country, $country . ':' . $state, $continent );

				// Handle NOT IN clause if needed.
				if ( ! empty( $do_not_match ) ) :
					$placeholders = implode( ',', array_fill( 0, count( $do_not_match ), '%d' ) );
					$sql         .= " AND zones.zone_id NOT IN ( $placeholders )";
					$query_args  = array_merge( $query_args, $do_not_match );
				endif;

				// Add order and limit.
				$sql .= " ORDER BY zone_order ASC LIMIT 1";

				// Run the prepared query.
				$matching_zone_id = $wpdb->get_var( $wpdb->prepare( $sql, $query_args ) );

			endif;

			// Fetch shipping methods for the matching zone.
			$shipping_methods = new WC_Shipping_Zone( $matching_zone_id ? $matching_zone_id : 0 );
			$shipping_methods = $shipping_methods->get_shipping_methods();
			foreach ( $shipping_methods as $i => $shipping_method ) :
				if ( is_numeric( $i ) ) :
					// Return details if free shipping is enabled.
					if ( $shipping_method->id == 'free_shipping' ) :
						return array(
							'min_amount'       => $shipping_method->min_amount,
							'ignore_discounts' => $shipping_method->ignore_discounts,
						);
					else :
						continue;
					endif;
				endif;
			endforeach;

			// Return false if no matching method is found.
			return false;
		}

		/**
		 * Retrieves the minimum amount for free shipping from a specific zone.
		 *
		 * @param int $zone_id The zone ID to retrieve settings for.
		 * @return array|false The minimum amount and discount settings or false if not available.
		 */
		public function get_min_amount( $zone_id ) {
			global $wpdb;

			// Query to get the active free shipping methods for the zone.
			$wfspb_query = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}woocommerce_shipping_zone_methods WHERE method_id = 'free_shipping' AND is_enabled = 1 AND zone_id=%d", $zone_id );
			$zone_data   = $wpdb->get_results( $wfspb_query, OBJECT );

			// If zone data is found, retrieve free shipping settings.
			if ( ! empty( $zone_data ) ) :
				$first_zone      = $zone_data[0];
				$instance_id     = $first_zone->instance_id;
				$method_id       = $first_zone->method_id;
				$arr_method      = array( $method_id, $instance_id );
				$implode_method  = implode( '_', $arr_method );
				$free_option     = 'woocommerce_' . $implode_method . '_settings';
				$free_shipping_s = get_option( $free_option );

				// Return the minimum amount and discounts options.
				return array(
					'min_amount'       => $free_shipping_s['min_amount'],
					'ignore_discounts' => $free_shipping_s['ignore_discounts'],
				);
			endif;

			// Return null if no matching data is found.
			__return_null();
		}
	}

endif;