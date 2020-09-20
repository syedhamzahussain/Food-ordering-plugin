<?php
/**
 * Registered new setting in woocommerce.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WFOP_REGISTER_WOO_TAB' ) ) {

	/**
	 *
	 * Class new setting in woocommerce
	 */
	class WFOP_REGISTER_WOO_TAB {

		/**
		 * Constructor
		 */
		public function __construct() {

			$this->id = 'wc_food_ordering_plugin';


			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'get_settings' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		}


		/**
		 * Add plugin options tab
		 *
		 * @param array $settings_tabs All Settings.
		 * @return array
		 */
		public function add_settings_tab( $settings_tabs ) {
			$settings_tabs[ $this->id ] = __( 'Food Ordering Settings', 'wc_food_ordering_plugin' );
			return $settings_tabs;
		}

		/**
		 * Get sections.
		 *
		 * @return array
		 */
		public function get_sections() {

			$sections = array(
				'section-0' => __( 'Plugin Options', 'wc_food_ordering_plugin' ),
			);

			return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
		}

		/**
		 * Get sections
		 *
		 * @param array $section All Section.
		 * @return array
		 */
		public function get_settings( $section = null ) {

			$settings = array(
				'section_1'                     => array(
					'name'     => __( 'Attachments for Admins :', 'wc_food_ordering_plugin' ),
					'type'     => 'title',
					'desc'     => __( '<b>Enabling this will allow you to add attachments on Product Page.</b>', 'wc_food_ordering_plugin' ),
					'desc_tip' => true,
					'id'       => 'wc_settings_tab_wppe_section-1',
				),
				
				'section_1_end'                 => array(
					'type' => 'sectionend',
					'id'   => 'wc_settings_tab_wppe_end-section-1',
				),
				
			);

			return apply_filters( 'wc_settings_tab_demo_settings', $settings, $section );
		}

		/**
		 * Output the settings
		 */
		public function output() {
			global $current_section;

			$settings = $this->get_settings( $current_section );
			WC_Admin_Settings::output_fields( $settings );
		}

		/**
		 * Save settings
		 */
		public function save() {

			woocommerce_update_options( self::get_settings() );

		}

	}

}
new WFOP_REGISTER_WOO_TAB();


