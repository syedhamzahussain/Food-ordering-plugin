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

			add_action( 'wp_ajax_nopriv_change_calendar', array( $this, 'change_calendar' ) );
			add_action( 'wp_ajax_change_calendar', array( $this, 'change_calendar' ) );

			add_action( 'wp_ajax_wfop_delete_order', array( $this, 'wfop_delete_order' ) );

		}
		public function wfop_delete_order() {
			if ( isset( $_REQUEST['order_id'] ) ) {
				wp_trash_post( $_REQUEST['order_id'] );
			}
		}

		public function change_calendar() {

			if ( isset( $_POST['want'] ) && isset( $_POST['date'] ) ) {
				$want = $_POST['want'];
				$date = $_POST['date'];
			}

			$seven_days = get_dates_for_calendar_ajax( $want, date( 'Y-' ) . $date );
			$open_days  = get_option( 'wc_food_ordering_plugin_open_days', true );

			echo $html = "<span class='previous_week'><button data-want='previous' type='button' id='week_btn'> < </button></span>";
			foreach ( $seven_days as $key => $day ) {
				if ( reset( $seven_days ) == $day ) {
					echo $html = "<span class='wfop_date active' style='padding-left:8px;' data-date='" . $day . "'>";
				} else {
					echo $html = "<span class='wfop_date' data-date='" . $day . "'>";
				}
				$d        = date( 'Y-' ) . $day;
				$day_name = date( 'D', strtotime( $d ) );

				if ( ! in_array( ( date( 'l', strtotime( $d ) ) ), $open_days ) ) {
					echo "<button disabled='disabled' type='button'>" . $day_name . '<br>' . $day . '</button></span>';
				} else {
					echo "<button type='button'>" . $day_name . '<br>' . $day . '</button></span>';
				}
			}
			echo $html = "<span class='next_week'><button data-want='next' type='button' id='week_btn'> > </button></span>";

			wp_die();

		}

		public function get_pieces_by_date() {

			if ( isset( $_POST['date'] ) ) {

				$date = date( 'Y' ) . '-' . trim( sanitize_text_field( wp_unslash( $_POST['date'] ) ) );

			} else {
				$date = date( 'Y-m-d' );
			}

			//$open = sanitize_text_field( wp_unslash( $_POST['not_open'] ) );

			if ( $_POST['not_open'] == 'true' ) {

				$open_days    = get_option( 'wc_food_ordering_plugin_open_days', true );
				$seven_days   = get_dates_for_calendar();
				$intervals    = get_option( 'wc_food_ordering_plugin_time_interval', true );
				$total_slots  = get_option( 'wfop_total_slots', true );
				$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );

				$all_eligible_products = get_all_eligible_products();

				$Single_Food_Product_page = get_page_by_title( 'Single Food Product' );

				foreach ( $total_slots as $key => $s_time ) {

					$html = + require WFOP_TEMP_DIR . '/frontend/template-wfop_indiv_pro_row.php';
				}

				wp_die( $html );
			} else {

				$new_array = array();
				$details   = get_products_details();

				foreach ( get_products_details() as $key => $value ) {
					$details[ $key ]['date'] = $date;

				}

				$orders      = wc_get_orders( $args );
				$done_orders = array();

				foreach ( $orders as $key => $value ) {

					foreach ( $value->get_items() as $item_id => $item ) {

						$item_date = $item->get_meta( 'date', true );
						$item_time = $item->get_meta( 'time', true );

						if ( ( ! empty( $item_date ) && ! empty( $item_time ) ) && ( $item_date == $date ) ) {
							array_push(
								$done_orders,
								array(
									'id'       => $item->get_product_id(),
									'quantity' => $item->get_quantity(),
									'slot'     => $item_time,
									'date'     => $item_date,
								)
							);

						} else {
							continue;
						}
					}
				}

				foreach ( $details as $key => $value ) {

					foreach ( $done_orders as $o_key ) {
						if ( $details[ $key ]['id'] == $o_key['id'] && $details[ $key ]['date'] == $o_key['date'] && $details[ $key ]['slot'] == $o_key['slot'] ) {

							$details[ $key ]['pieces'] = $details[ $key ]['pieces'] - $o_key['quantity'];
						}
					}
				}

				if ( isset( $_REQUEST['date'] ) ) {
					wp_die( wp_json_encode( $details ) );
				} else {
					wp_die( wp_json_encode( $details ) );
				}
			}

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
					$quantity,
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


