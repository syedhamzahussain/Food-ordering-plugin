<?php
/**
 * Registered new setting in woocommerce.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WFOP_FRONTEND' ) ) {

	/**
	 *
	 * Class new setting in woocommerce
	 */
	class WFOP_FRONTEND {

		/**
		 * Constructor
		 */
		public function __construct() {

			$this->id = 'wc_food_ordering_plugin';
			add_action( 'init', array( $this, 'init' ) );

		}

		public function init() {
			$this->create_single_product_page();
			add_shortcode( 'wfop_shop', array( $this, 'wfop_shop_shortcode' ) );
			add_shortcode( 'wfop_product', array( $this, 'wfop_product_shortcode' ) );
			add_filter( 'the_title', array( $this, 'filter_function_name' ) );
			add_filter( 'woocommerce_get_item_data', array( $this, 'wfop_display_cart_meta' ), 10, 2 );

			add_action( 'woocommerce_add_order_item_meta', array( $this, 'wfop_add_order_item_meta' ), 10, 3 );

		}

		// Add order item meta.

		function wfop_add_order_item_meta( $item_id, $cart_item, $cart_item_key ) {
			if ( isset( $cart_item['date'] ) && isset( $cart_item['time'] ) ) {

				wc_add_order_item_meta( $item_id, 'date', $cart_item['date'] );
				wc_add_order_item_meta( $item_id, 'time', $cart_item['time'] );
			}
		}

		public function wfop_display_cart_meta( $item_data, $cart_item ) {

			if ( empty( $cart_item['date'] ) && empty( $cart_item['time'] ) ) {

				return $item_data;

			}

			$item_data['date'] = array(

				'key'     => __( 'Date' ),

				'value'   => wc_clean( $cart_item['date'] ),

				'display' => '',

			);

			$item_data['time'] = array(

				'key'     => __( 'time' ),

				'value'   => wc_clean( $cart_item['time'] ),

				'display' => '',

			);

			return $item_data;

		}


		public function filter_function_name( $title ) {
			 $product_id = $_GET['product_id'];
			if ($product_id) {
				
			$product    = wc_get_product( $product_id );

			if ( $title == 'Single Food Product' && ! empty( $product_id ) ) {
				return $title = __( $product->get_name() );
			} 
			}

			return $title;
		}

		public function wfop_shop_shortcode() {

			$seven_days   = get_dates_for_calendar();
			$intervals    = get_option( 'wc_food_ordering_plugin_time_interval', true );
			$total_slots  = get_option( 'wfop_total_slots', true );
			$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );

			$all_eligible_products = get_all_eligible_products();

			$Single_Food_Product_page = get_page_by_title( 'Single Food Product' );

			include WFOP_TEMP_DIR . '/frontend/template-wfop_shortcode.php';

		}

		public function wfop_product_shortcode() {
			include WFOP_TEMP_DIR . '/frontend/template-wfop_product-shortcode.php';

		}

		public function create_single_product_page() {

			$Single_Food_Product_page_template = ''; // ex. template-custom.php. Leave blank if you don't want a custom page template.

			$Single_Food_Product_page_check = get_page_by_title( 'Single Food Product' );

			$Single_Food_Product_page = array(
				'post_type'    => 'page',
				'post_title'   => 'Single Food Product',
				'post_content' => '<!-- wp:shortcode -->[wfop_product]<!-- /wp:shortcode -->',
				'post_status'  => 'publish',
				'post_author'  => 1,
			);

			if ( ! isset( $Single_Food_Product_page_check->ID ) ) {
				$Single_Food_Product_id = wp_insert_post( $Single_Food_Product_page );
			}

		}



	}
	new WFOP_FRONTEND();
}



