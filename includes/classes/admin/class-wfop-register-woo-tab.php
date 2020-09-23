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

		public function add_slots_to_cat() {
			$orderby = 'name';
			$order = 'asc';
			$hide_empty = false ;
			$cat_args = array(
			    'orderby'    => $orderby,
			    'order'      => $order,
			    'hide_empty' => $hide_empty,
			);
			 
			$product_categories = get_terms( 'product_cat', $cat_args );

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

			$all_intervals = array(
				'15' => '15min',
				'30' => '30min',
				'45' => '45min',
				'60' => '1hr',
				'120' => '2hrs',
				'180' => '3hrs',
							);

			$orderby = 'name';
			$order = 'asc';
			$hide_empty = false ;
			$cat_args = array(
			    'orderby'    => $orderby,
			    'order'      => $order,
			    'hide_empty' => $hide_empty,
			);
			 
			$product_cat = get_terms( 'product_cat', $cat_args );

			foreach ( $product_cat as $key => $value ) {
				$product_categories[$value->term_id] = 'ID ' . $value->term_id . '-' . $value->name;
			};

			$settings = array(
				'section_1'                    => array(
					'name'     => __( 'Time Slots Ordering:', 'wc_food_ordering_plugin' ),
					'type'     => 'title',
					'desc'     => __( '<b>Working Hours</b>', 'wc_food_ordering_plugin' ),
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
				'section_2'                    => array(
					'name'     => __( 'Create Time Slots:', 'wc_food_ordering_plugin' ),
					'type'     => 'title',
					'id'       => $this->id . '_section_2-time',
				),
				'time_interval'                => array(
					'title' => __( 'Time Intervals', 'wc_food_ordering_plugin' ),
					'type' => 'select',
					'options' => $all_intervals,
					'id'   => $this->id . '_time_interval',
				),
				'no_of_pieces'                => array(
					'title' => __( 'Number of pieces per time slot (per product type).', 'wc_food_ordering_plugin' ),
					'type' => 'number',
					'id'   => $this->id . '_no_of_pieces',
				),
				'add_slots_to_cat' => array(
					'title' => __( 'Affected Products', 'wc_food_ordering_plugin' ),
					'type' => 'multiselect',
					'options' => $product_categories,
					// 'custom_attributes' => array(
					// 	'multiple' => 'true',
					// ),
					'id'   => $this->id . '_add_slots_to_cat',
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

			if ( isset( $_POST['wc_food_ordering_plugin_time_from'] ) && isset( $_POST['wc_food_ordering_plugin_time_to'] ) && isset( $_POST['wc_food_ordering_plugin_time_interval'] ) ) {
				$StartTime = $_POST['wc_food_ordering_plugin_time_from'];
				$EndTime = $_POST['wc_food_ordering_plugin_time_to'];
				$Duration = $_POST['wc_food_ordering_plugin_time_interval'];

				$total_slots = total_slots($StartTime, $EndTime, $Duration);

				update_option( 'wfop_total_slots', $total_slots, 0 );
			}

			woocommerce_update_options( self::get_settings() );

		}

	}

}
new WFOP_REGISTER_WOO_TAB();


