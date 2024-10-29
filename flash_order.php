<?php
/**
 *
 * @link              https://innovazioneweb.com
 * @since             1.0.0
 * @package           Flash_order
 *
 * @wordpress-plugin
 * Plugin Name:       IW Flash Order
 * Plugin URI:        https://innovazioneweb.com/flash-order
 * Description:       IW Flash Order is the ultimate solution for streamlining restaurant order management on your WooCommerce-powered website. With this powerful plugin, you can supercharge your restaurant's online ordering process.
 * Version:           1.0.0
 * Author:            InnovazioneWeb
 * Author URI:        https://innovazioneweb.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       flash_order
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 */
define( 'FLASH_ORDER_VERSION', '1.0.0' );

/**
 * Currently database version for flash_order_meta table.
 * Start at version 1.0.0
 */
define( 'FLASH_ORDER_META_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-flash_order-activator.php
 */
function activate_flash_order() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flash_order-activator.php';
	Flash_order_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-flash_order-deactivator.php
 */
function deactivate_flash_order() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-flash_order-deactivator.php';
	Flash_order_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flash_order' );
register_deactivation_hook( __FILE__, 'deactivate_flash_order' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-flash_order.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_flash_order() {

	$plugin = new Flash_order();
	$plugin->run();

}
run_flash_order();
