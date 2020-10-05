<?php
/**
 *
 * Ajax Function File.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WFOP_ALL_AJAX_CALLS' ) ) {

	/**
	 *
	 * WFOP_ALL_AJAX_CALLS class
	 */
	class WFOP_ALL_AJAX_CALLS {

		/**
		 *
		 * Cunstruct function
		 */
		public function __construct() {

			add_action( 'wp_ajax_nopriv_wfop_add_to_cart', array( $this, 'wfop_add_to_cart' ) );
			add_action( 'wp_ajax_wfop_add_to_cart', array( $this, 'wfop_add_to_cart' ) );

		}


		public function wfop_add_to_cart() {

			$product_id = sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) );
			$quantity   = sanitize_text_field( wp_unslash( $_REQUEST['quantity'] ) );
			$date       = sanitize_text_field( wp_unslash( $_REQUEST['date'] ) );
			$time       = sanitize_text_field( wp_unslash( $_REQUEST['time'] ) );

			if ( isset( $product_id ) && isset( $quantity ) && isset( $date ) && isset( $time ) ) {
				$product = wc_get_product( $product_id );
				global $woocommerce;
				WC()->cart->add_to_cart(
					$product_id,
					1,
					0,
					null,
					array(
						'date' => $date,
						'time' => $time,
					)
				);
			}

			wp_die();
		}
	}

	new WFOP_ALL_AJAX_CALLS();

}


