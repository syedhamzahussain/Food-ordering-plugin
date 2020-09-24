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

			include WFOP_TEMP_DIR . '/frontend/template-wfop_shortcode.php';

		}



	}
	new WFOP_FRONTEND();
}



