<?php
defined( 'ABSPATH' ) || exit; // Ensure the file is being called from a valid WordPress environment.

/**
 * Class EKWC_Shipping_Bar_Frontend
 *
 * Handles the display and functionality of the shipping bar on the frontend of the site.
 */
if ( ! class_exists( 'EKWC_Shipping_Bar_Frontend' ) ) :

	class EKWC_Shipping_Bar_Frontend {
		protected $settings;
		protected $ignore_discounts;

		/**
		 * Constructor to initialize settings and event handler.
		 */
		function __construct() {
			$this->settings = new EKWC_Shipping_Options();
			$this->event_handler();
		}

		/**
		 * Registers actions and filters for the frontend.
		 */
		public function event_handler() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script_frontend' ), 100 );
			add_action( 'wp_footer', array( $this, 'show_bar_conditional' ), 90 );
			add_action( 'wp_footer', array( $this, 'show_giftbox' ), 95 );
			add_filter( 'woocommerce_shipping_free_shipping_is_available', array( $this, 'free_shipping_option' ), 10, 3 );

			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_shipping_bar_fragment' ) );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'gift_box_fragment' ) );
		}
		
		/**
		 * Enqueues necessary styles and scripts for the frontend.
		 */
		public function enqueue_script_frontend() {
			wp_enqueue_style( 'shipping-bar', EKWC_URL . 'assets/css/free-shipping-bar/ekwc-style.css', array(), EKWC_VERSION, 'all' );
			wp_register_script( 'shipping-bar', EKWC_URL . 'assets/js/free-shipping-bar/ekwc-script.js', array(), EKWC_VERSION, true );
			wp_localize_script(
				'shipping-bar',
				'ekwc_shipping',
				array(
					'initdelay'            => $this->settings->get_option( 'intial_delay' ),
					'is_time_to_disappear' => $this->settings->get_option( 'is_time_to_disappear' ),
					'time_to_disappear'    => $this->settings->get_option( 'time_to_disappear' ),
					'ajax_url'             => admin_url( 'admin-ajax.php' ),
					'nonce'                => wp_create_nonce( 'report-nonce' ),
				)
			);
			wp_enqueue_script( 'shipping-bar' );
		}

		/**
		 * Adjusts the availability of free shipping based on the settings.
		 *
		 * @param bool $is_available Whether the free shipping option is available.
		 * @param array $package The shipping package.
		 * @param object $_this The WooCommerce shipping method object.
		 * 
		 * @return bool
		 */
		public function free_shipping_option( $is_available, $package, $_this ) {
			if ( ! $this->ignore_discounts ) :
				$this->ignore_discounts = $_this->ignore_discounts;
			endif;
			return $is_available;
		}

		/**
		 * Conditionally displays the shipping bar on the frontend.
		 */
		public function show_bar_conditional() {			
			if ( ! is_admin() ) :
				$enable = $this->settings->get_option( 'enable' );
				if ( $enable === 'yes' && $this->settings->is_active_shipping_zone() && $this->is_topbar_hide() && $this->is_topbar_hide_on_mobile() ) :				
					$this->show_bar();
				endif;
			endif;
		}

		/**
		 * Fetches the free shipping bar pricing data.
		 *
		 * @return array
		 */
		public function get_free_shipping_bar_pricing_data() {
			$response     = array(
				'order_min_amount' => 0
			);
			$total        = WC()->cart->get_displayed_subtotal();
			$default_zone = $this->settings->get_option( 'shipping_zone' );
			$customer     = WC()->session->get( 'customer' );
			$country      = isset( $customer['shipping_country'] ) ? $customer['shipping_country'] : '';
			$state        = isset( $customer['shipping_state'] ) ? $customer['shipping_state'] : '';
			$postcode     = isset( $customer['shipping_postcode'] ) ? $customer['shipping_postcode'] : '';

			if ( $country ) :
				$result           = EKWC_Shipping_Options::detect_ip( $country, $state, $postcode );
				$order_min_amount = isset( $result['min_amount'] ) ? $result['min_amount'] : false;
				$ignore_discounts = isset( $result['ignore_discounts'] ) ? $result['ignore_discounts'] : false;

				if ( $order_min_amount && $default_zone ) :
					$result                       = $this->settings->get_min_amount( $default_zone );
					$response['ignore_discounts'] = $result['ignore_discounts'];
					$response['order_min_amount'] = $this->settings->toInt( $result['min_amount'] );

				endif;

			elseif ( $default_zone ) :
				$result                       = $this->settings->get_min_amount( $default_zone );
				$response['ignore_discounts'] = $result['ignore_discounts'];
				$response['order_min_amount'] = $this->settings->toInt( $result['min_amount'] );

			else :
				$result                       = $this->settings->get_shipping_min_amount();
				$response['order_min_amount'] = $result['min_amount'];
				$response['ignore_discounts'] = $result['ignore_discounts'];

			endif;

			if ( WC()->cart->display_prices_including_tax() ) :
				$total = $total - WC()->cart->get_discount_tax();
			endif;

			if ( isset( $response['ignore_discounts'] ) && 'no' == $response['ignore_discounts'] ) :
				$total = $total - WC()->cart->get_discount_total();
			endif;
			$total             = round( $total, wc_get_price_decimals() );
			$response['total'] = $total;
			return $response;
		}

		/**
		 * Displays the shipping bar on the frontend.
		 */
		public function show_bar() {
			$this->settings  = $this->settings;
			$progress_effect = $this->settings->get_option( 'progress_effect' );

			$shipping_option = $this->get_free_shipping_bar_pricing_data();
			$cart_qty        = WC()->cart->cart_contents_count;

			if ( ! isset( $shipping_option['order_min_amount'] ) ) :
				return;
			endif;

			if ( $shipping_option['total'] == 0 ) :
				$message_text = $this->get_announcement_message( $shipping_option['order_min_amount'] );
				$this->get_notification_topbar( $message_text, $shipping_option );
				return;
			endif;

			if ( $shipping_option['total'] < $shipping_option['order_min_amount'] ) :
				$missing_amount = $shipping_option['order_min_amount'] - $shipping_option['total'];

				if ( is_checkout() || is_cart() ) :
					$message_text = $this->get_error_message( $shipping_option['total'], $shipping_option['order_min_amount'] );
				else :
					if ( ! is_cart() && WC()->cart->display_prices_including_tax() ) :
						$missing_amount = $this->settings->get_price_including_tax( $missing_amount );
					endif;
					$message_text = $this->get_pruchased_message( $shipping_option['total'], $shipping_option['order_min_amount'], $cart_qty, $missing_amount );
				endif;
			else :
				$missing_amount = 0;
				$message_text   = $this->get_success_message();
			endif;

			$this->get_notification_topbar( $message_text, $shipping_option, $missing_amount );
		}

		/**
		 * Displays the notification topbar with appropriate messages.
		 *
		 * @param string $message The message to display.
		 * @param array $shipping_option The shipping options data.
		 * @param float $missing_amount The missing amount for free shipping.
		 */
		public function get_notification_topbar( $message, $shipping_option, $missing_amount = 0 ) {
			$topbar_style    = $this->settings->get_option( 'topbar_style', 'style1' );
			$position        = $this->settings->get_option( 'bar_position', 'top_bar' );
			$enable_progress = $this->settings->get_option( 'enable_progress' );
			$bg_color        = $this->settings->get_option( 'bg_color', '#d2f2ff' );

			$progress_bg_color = $this->settings->get_option( 'progress_bg_color', '#e7e7ef' );
			$curr_prog_color   = $this->settings->get_option( 'curr_progress_color', '#e7e7ef' );

			$text_color          = $this->settings->get_option( 'text_color', '#3e3f5e' );
			$progress_text_color = $this->settings->get_option( 'progress_text_color', '#3e3f5e' );
			$text_align          = $this->settings->get_option( 'text_align', 'center' );
			$font_size           = $this->settings->get_option( 'font_size', '18' );
			$closebar_button     = $this->settings->get_option( 'closebar_button', 'no' );
			$width 				 = ( ! empty( $shipping_option['order_min_amount'] ) && $shipping_option['order_min_amount'] != 0 ) ? ( $shipping_option['total'] / $shipping_option['order_min_amount'] * 100 ) : 0;

			echo '<div id="ekwc-shipping-bar-wrapper">';
				wc_get_template( 
					'topbar/content-' . $topbar_style . '.php',
					array(
						'message'             => $message,
						'missing_amount'      => $missing_amount,
						'position'            => $position,
						'closebar_button'     => $closebar_button,
						'enable_progress'     => $enable_progress,
						'bg_color'            => $bg_color,
						'text_color'          => $text_color,
						'progress_text_color' => $progress_text_color,
						'text_align'          => $text_align,
						'font_size'           => $font_size,
						'shipping_option'     => $shipping_option,
						'width'               => $width,
						'progress_bg_color'   => $progress_bg_color,
						'curr_prog_color'     => $curr_prog_color,
					),
					'essential-tool-for-woocommerce/', 
					EKWC_PATH . 'templates/free-shipping-bar/' 
				);
			echo '</div>';
		}

		/**
		 * Constructs the purchased message for the shipping bar.
		 *
		 * @param float $total The current total amount in the cart.
		 * @param float $order_min_amount The minimum order amount for free shipping.
		 * @param int $cart_qty The number of items in the cart.
		 * @param float $missing_amount The amount missing to reach the free shipping threshold.
		 * 
		 * @return string
		 */
		public function get_pruchased_message( $total, $order_min_amount, $cart_qty, $missing_amount ) {
			$message_purchased = $this->settings->get_message( 'purchased_notifications', 'You have purchased {total_amounts} of {min_amount}' );

			$message = str_replace(
				array( '{total_amounts}', '{min_amount}', '{cart_qty}', '{missing_amount}' ),
				array( wc_price( $total ), wc_price( $order_min_amount ), $cart_qty, wc_price( $missing_amount ) ),
				'<div id="ekwc-shipping-bar-main-content">' . wp_unslash( $message_purchased ) . '</div>'
			);
			return apply_filters( 'ekwc_shipping_notifications_text_purchased_message', $message, $total, $order_min_amount, $cart_qty, $missing_amount );
		}

		/**
		 * Constructs the error message when the cart total is less than the free shipping threshold.
		 *
		 * @param float $total The current total amount in the cart.
		 * @param float $order_min_amount The minimum order amount for free shipping.
		 * 
		 * @return string
		 */
		public function get_error_message( $total, $order_min_amount ) {
			$message_error  = $this->settings->get_message( 'error_notifications', 'You are missing {missing_amount} to get Free Shipping.{shopping}' );
			$missing_amount = $order_min_amount - $total;

			$message = str_replace(
				array( '{missing_amount}', '{shopping}' ),
				array( wc_price( $missing_amount ), $this->settings->get_shop_page_link_html() ),
				'<div id="ekwc-shipping-bar-main-content">' . wp_unslash( $message_error ) . '</div>'
			);
			return apply_filters( 'ekwc_shipping_notifications_text_error_message', $message, $total, $order_min_amount );
		}

		/**
		 * Constructs the success message when the free shipping threshold is reached.
		 *
		 * @param string $color The color for the success message text (optional).
		 * 
		 * @return string
		 */
		public function get_success_message( $color = '' ) {
			$message_success = $this->settings->get_message( 'success_notifications', 'Congratulation! You have got free shipping. Go to {checkout_page}' );
			$message         = str_replace(
				'{checkout_page}',
				$this->settings->get_checkout_page_link_html(),
				'<div style="color: ' . $color . '" id="ekwc-shipping-bar-main-content">' . wp_unslash( $message_success ) . '</div>'
			);
			return apply_filters( 'ekwc_shipping_notifications_text_success_message', $message );
		}

		/**
		 * Constructs the announcement message for free shipping.
		 *
		 * @param float $order_min_amount The minimum order amount for free shipping.
		 * @param string $color The color for the announcement message text (optional).
		 * 
		 * @return string
		 */
		public function get_announcement_message( $order_min_amount, $color = '' ) {
			$announce_system = $this->settings->get_message( 'announcement_notifications', 'Free shipping for billing over {min_amount}' );
			$message         = str_replace(
				'{min_amount}',
				wc_price( $order_min_amount ),
				'<div style="color: ' . $color . '" id="ekwc-shipping-bar-main-content">' . wp_unslash( $announce_system ) . '</div>'
			);
			return apply_filters( 'ekwc_shipping_notifications_text_announcement_message', $message, $order_min_amount );
		}

		/**
		 * Displays the gift box on the frontend.
		 */
		public function show_giftbox() {
			$enable = $this->settings->get_option( 'enable', 'no' );

			if ( $enable !== 'yes' ) :
				return;
			endif;

			$shipping_option  	= $this->get_free_shipping_bar_pricing_data();
			$giftbox_style    	= $this->settings->get_option( 'giftbox_style', 'style1' );
			$width 			  	= ( ! empty( $shipping_option['order_min_amount'] ) && $shipping_option['order_min_amount'] != 0 ) ? ( $shipping_option['total'] / $shipping_option['order_min_amount'] * 100 ) : 0;
			$show_giftbox     	= $this->settings->get_option( 'enable_gift_box' );
			$bg_pcolor        	= $this->settings->get_option( 'progress_bg_color', '#aaaaaa' );
			$curr_bg_pcolor   	= $this->settings->get_option( 'curr_progress_color', '#7f54b3' );
			$bg_color         	= $this->settings->get_option( 'bg_color', '#d2f2ff' );
			$text_color       	= $this->settings->get_option( 'text_color', '#d2f2ff' );
			$link_color       	= $this->settings->get_option( 'link_color', '#d2f2ff' );
			$giftbox_position 	= $this->settings->get_option( 'giftbox_position', 'bottom_right' );
			$giftbox_icon	  	= $this->settings->get_option( 'gift_icon_url' );
			$success_msg  		= $this->get_success_message();
			$announcement_msg 	= isset( $shipping_option['order_min_amount'] ) ? $this->get_announcement_message( $shipping_option['order_min_amount'] ) : '';
			

			if ( $show_giftbox === 'yes' && $enable ) :
				echo '<div id="ekwc-shipping-giftbox-wrapper">';
				wc_get_template(
					'giftbox/content-giftbox-icon.php',
					array(
						'giftbox_position' 	=> $giftbox_position,
						'giftbox_icon'		=> $giftbox_icon,
					),
					'essential-tool-for-woocommerce/',
                	EKWC_PATH . 'templates/free-shipping-bar/'
				);
				wc_get_template(
					'giftbox/content-giftbox-' . $giftbox_style . '.php',
					array(
						'shipping_option' 	=> $shipping_option,
						'width'           	=> $width,
						'bg_color'        	=> $bg_color,
						'text_color'      	=> $text_color,
						'link_color'      	=> $link_color,
						'bg_pcolor'       	=> $bg_pcolor,
						'curr_bg_pcolor'  	=> $curr_bg_pcolor,
						'giftbox_style'   	=> $giftbox_style,
						'success_msg'		=> $success_msg,
						'announcement_msg'	=> $announcement_msg
					),
					'essential-tool-for-woocommerce/',
                	EKWC_PATH . 'templates/free-shipping-bar/'
				);
				echo '</div>';
			endif;
			return false;
		}

		public function is_topbar_hide_on_mobile() {
			$enable_mobile_tab = $this->settings->get_option( 'mobile', 'no' );
			if ( wp_is_mobile() ) :
				return ( $enable_mobile_tab === 'yes' ); 
			endif;			
			return true;
		}
		

		public function is_topbar_hide() {
			$home_page           = $this->settings->get_option( 'home_page', 'no' );
			$cart_page           = $this->settings->get_option( 'cart_page', 'no' );
			$shop_page           = $this->settings->get_option( 'shop_page', 'no' );
			$checkout_page       = $this->settings->get_option( 'checkout_page', 'no' );
			$single_product_page = $this->settings->get_option( 'single_product_page', 'no' );
			$product_cat_page    = $this->settings->get_option( 'product_cat_page', 'no' );
		
			if ( is_front_page() ) :
				return ( $home_page === 'yes' ) ? false : true;
			endif;
		
			if ( is_cart() ) :
				return ( $cart_page === 'yes' ) ? false : true;
			endif;
		
			if ( is_shop() ) :
				return ( $shop_page === 'yes' ) ? false : true;
			endif;
		
			if ( is_checkout() ) :
				return ( $checkout_page === 'yes' ) ? false : true;
			endif;
		
			if ( is_product() ) :
				return ( $single_product_page === 'yes' ) ? false : true;
			endif;
		
			if ( is_product_category() ) :
				return ( $product_cat_page === 'yes' ) ? false : true;
			endif;
		
			return true;
		}

		/**
		 * Adds the shipping bar HTML to WooCommerce cart fragments.
		 *
		 * @param array $fragments Existing fragments.
		 * @return array Modified fragments.
		 */
		public function add_shipping_bar_fragment( $fragments ) {
			ob_start();
			$this->show_bar(); // Outputs the HTML via get_notification_topbar
			$fragments['#ekwc-shipping-bar-wrapper'] = ob_get_clean();
			return $fragments;
		}

		/**
		 * Adds the shipping bar HTML to WooCommerce cart fragments.
		 *
		 * @param array $fragments Existing fragments.
		 * @return array Modified fragments.
		 */
		public function gift_box_fragment( $fragments ) {
			ob_start();
			$this->show_giftbox(); // Outputs the HTML via get_notification_topbar
			$fragments['#ekwc-shipping-giftbox-wrapper'] = ob_get_clean();
			return $fragments;
		}

		
	}
	new EKWC_Shipping_Bar_Frontend();
endif;
