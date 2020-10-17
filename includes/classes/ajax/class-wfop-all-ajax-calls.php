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

			add_action( 'wp_ajax_nopriv_get_pieces_by_date', array( $this, 'get_pieces_by_date' ) );
			add_action( 'wp_ajax_get_pieces_by_date', array( $this, 'get_pieces_by_date' ) );

		}

		public function get_pieces_by_date(){

			    $date = date( 'Y' ).'-'.trim( sanitize_text_field( wp_unslash( $_REQUEST['date'] ) ) );

				$new_array = array();
				$details = get_products_details();

				foreach (get_products_details() as $key => $value) {
					$details[$key]['date'] = $date;
					
				}

				
				 
				$orders          = wc_get_orders($args);
				$done_orders = array();

				foreach ( $orders as $key => $value ) {

				foreach ( $value->get_items() as $item_id => $item ) {

					$item_date = $item->get_meta( 'date', true );
					$item_time = $item->get_meta( 'time', true );

					if ( (! empty( $item_date ) && ! empty( $item_time ) ) && ($item_date ==  $date  ) ) {
						array_push($done_orders, array('id' => $item->get_product_id() ,'quantity' => $item->get_quantity(),'slot' => $item_time,'date' =>  $item_date) );
						
					} else {
						continue;
					}
				}
			}
				
			foreach ($details as $key => $value) {

				foreach ($done_orders as $o_key) {
					if($details[$key]['id'] == $o_key['id'] && $details[$key]['date'] == $o_key['date'] && $details[$key]['slot'] == $o_key['slot']){

						$details[$key]['pieces'] = $details[$key]['pieces'] - $o_key['quantity'];
					}
				}
				
			}

			
			
			wp_die(wp_json_encode($details));

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


