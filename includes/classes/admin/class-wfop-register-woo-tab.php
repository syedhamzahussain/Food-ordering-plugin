<?php
/**
 * Registered new setting in woocommerce.
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

			add_action( 'woocommerce_admin_field_add_slot_btn', array( $this, 'add_slot_btn' ) );
			add_action( 'woocommerce_admin_field_add_slots_to_product', array( $this, 'add_slots_to_product' ) );
			add_action( 'woocommerce_admin_field_show_all_added_slots', array( $this, 'show_all_added_slots' ) );

			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'get_settings' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		}

		public function show_all_added_slots() {

			require_once WFOP_TEMP_DIR . '/admin/show-all-slots.php';

		}

		public function add_slot_btn() {

			require_once WFOP_TEMP_DIR . '/admin/btn-add-slot.php';

		}

		public function add_slots_to_product() {
			$args['posts_per_page'] = -1;
			$all_products           = wc_get_products( $args );

			$temp_slot = array( '0' => '01:00 pm-01:15 pm' );

			require_once WFOP_TEMP_DIR . '/admin/add-slot-to-product.php';
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
				'section_1'                    => array(
					'name'     => __( 'Time Slots:', 'wc_food_ordering_plugin' ),
					'type'     => 'title',
					'desc'     => __( '<b>Add Timeslots</b>', 'wc_food_ordering_plugin' ),
					'desc_tip' => true,
					'id'       => $this->id . '_section-time',
				),
				'time_from'                    => array(
					'name' => __( 'Time From:', 'wc_food_ordering_plugin' ),
					'type' => 'time',
					'id'   => $this->id . '_time_from',
				),
				'time_to'                      => array(
					'name' => __( 'Time To:', 'wc_food_ordering_plugin' ),
					'type' => 'time',
					'id'   => $this->id . '_time_to',
				),
				'section_1_end'                => array(
					'type' => 'sectionend',
					'id'   => $this->id . '_end_section-time',
				),
				'add_slot'                     => array(
					'name' => __( 'Add New Slot:', 'wc_food_ordering_plugin' ),
					'type' => 'add_slot_btn',
					'id'   => $this->id . '_add_slot',
				),
				'section_2'                    => array(
					'name'     => __( 'Set Slot For Product:', 'wc_food_ordering_plugin' ),
					'type'     => 'title',
					'desc'     => __( '<b>Set timeslots to products.</b>', 'wc_food_ordering_plugin' ),
					'desc_tip' => true,
					'id'       => $this->id . '_section_2-time',
				),
				'add_slots_to_product_section' => array(
					'type' => 'add_slots_to_product',
					'id'   => $this->id . '_add_slots_to_product_section',
				),
				'section_2_end'                => array(
					'type' => 'sectionend',
					'id'   => $this->id . '_end_section_2-time',
				),
				'section_3'                    => array(
					'name' => __( 'All Time Slots Data:', 'wc_food_ordering_plugin' ),
					'type' => 'title',
					'id'   => $this->id . '_section_3-time',
				),
				'all_slots_table'              => array(
					'type' => 'show_all_added_slots',
					'id'   => $this->id . '_all_slots_table',
				),
				'section_3_end'                => array(
					'type' => 'sectionend',
					'id'   => $this->id . '_end_section_3-time',
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


