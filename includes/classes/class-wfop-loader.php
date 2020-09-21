<?php
/**
 *
 * Main Plugin files loader.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WFOP_LOADER' ) ) {

	/**
	 *
	 * WFOP_LOADER class
	 */
	class WFOP_LOADER {

		/**
		 *
		 * Cunstruct function
		 */
		public function __construct() {
			$this->includes();
			add_action( 'admin_enqueue_scripts', array( $this, 'register_backend_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_scripts' ) );
		}

		/**
		 *
		 * Includes function.
		 */
		public function includes() {

			if ( wp_doing_ajax() ) {
				// inluding all files those will only use in ajax request.
				require_once WFOP_PLUGIN_DIR . '/includes/classes/ajax/class-wfop-all-ajax-calls.php';
			}

			require_once WFOP_PLUGIN_DIR . '/includes/classes/admin/class-wfop-register-woo-tab.php';

		}

		/**
		 *
		 * Register frontend scripts function.
		 */
		public function register_frontend_scripts() {

				// enqueue plugin styles and scripts.
				wp_enqueue_script( 'wfop-script', WFOP_ASSETS_DIR_URL . '/js/main.js', array( 'jquery' ), wp_rand(), true );
				wp_enqueue_style( 'wfop-style', WFOP_ASSETS_DIR_URL . '/css/style.css', '', wp_rand() );

				// localize script.
				wp_localize_script(
					'wfop-script',
					'wfop_ajax',
					array(
						'ajaxurl'   => admin_url( 'admin-ajax.php' ),
						'wfopnonce' => wp_create_nonce( 'wfop-nonce' ),
					)
				);

		}

		/**
		 *
		 * Register backend scripts function.
		 */
		public function register_backend_scripts() {
			wp_enqueue_style( 'wfop-style', WFOP_ASSETS_DIR_URL . '/css/style.css', '', wp_rand() );
			wp_enqueue_script( 'wfop-admin-script', WFOP_ASSETS_DIR_URL . '/js/admin.js', array( 'jquery' ), wp_rand(), true );
			wp_localize_script(
				'wfop-admin-script',
				'wfop_ajax',
				array(
					'ajaxurl'   => admin_url( 'admin-ajax.php' ),
					'wfopnonce' => wp_create_nonce( 'wfop-nonce' ),
				)
			);
		}

	}

}

new WFOP_LOADER();
