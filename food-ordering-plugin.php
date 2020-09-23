<?php
/**
 * Plugin Name: Food Ordering Plugin
 * Description: Plugin for Woocommerce that will to book a food product at a specific time of the day.
 * Version:     1.1.1.0
 * Author:      Syed Hamza Hussain
 * Author URI:  https://www.upwork.com/fl/syedhamzahussain
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wc_food_ordering_plugin
 *
 * @package Food Ordering Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WFOP_PLUGIN_DIR' ) ) {
	define( 'WFOP_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'WFOP_PLUGIN_DIR_URL' ) ) {
	define( 'WFOP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WFOP_TEMP_DIR' ) ) {
	define( 'WFOP_TEMP_DIR', WFOP_PLUGIN_DIR . '/templates' );
}

if ( ! defined( 'WFOP_ASSETS_DIR_URL' ) ) {
	define( 'WFOP_ASSETS_DIR_URL', WFOP_PLUGIN_DIR_URL . 'assets' );
}

require_once WFOP_PLUGIN_DIR . '/includes/helper.php';
require_once WFOP_PLUGIN_DIR . '/includes/classes/class-wfop-loader.php';

