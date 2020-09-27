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

			add_shortcode( 'wfop_shop', array( $this, 'wfop_shop_shortcode' ) );

		}

		public function wfop_shop_shortcode() {

			$seven_days   = get_dates_for_calendar();
			$intervals    = get_option( 'wc_food_ordering_plugin_time_interval', true );
			$total_slots  = get_option( 'wfop_total_slots', true );
			$pieces       = get_option( 'wc_food_ordering_plugin_no_of_pieces', true );
			$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );

			$all_eligible_products = get_all_eligible_products();

			include WFOP_TEMP_DIR . '/frontend/template-wfop_shortcode.php';

		}



	}
	new WFOP_FRONTEND();
}



