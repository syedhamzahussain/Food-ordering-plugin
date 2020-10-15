<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WFOP_TODAYS_ORDER' ) ) {

	/**
	 *
	 * Class new setting in woocommerce
	 */
	class WFOP_TODAYS_ORDER {

		/**
		 * Constructor
		 */
		public function __construct() {

			add_action( 'init', array( $this, 'init' ) );

		}

		public function init() {
			$this->wfop_create_menu();

		}

		public function wfop_create_menu() {

			add_action(
				'admin_menu',
				'wfop_options_page'
			);

			function wfop_options_page() {
				add_menu_page(
					'wfop',
					'Today Orders',
					'manage_options',
					'wfop',
					'wfop_options_page_html',
					'dashicons-admin-generic',
					20
				);
			}

			function wfop_options_page_html() {
				require_once WFOP_TEMP_DIR . '/admin/todays-orders.php';
			}

		}

	}

	new WFOP_TODAYS_ORDER();
}



