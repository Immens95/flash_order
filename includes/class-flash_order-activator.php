<?php

/**
 * Fired during plugin activation
 *
 * @link       https://innovazioneweb.com
 * @since      1.0.0
 *
 * @package    Flash_order
 * @subpackage Flash_order/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
class Flash_order_Activator {

	/**
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// if ( get_option( 'flash_order_meta_table' ) == null ) {
		// 	// update_option( 'flash_order_meta_table', FLASH_ORDER_META_VERSION );
		// 	FO_create_meta_table();
		// }
		// if ( get_option( 'flash_order_necessary_settings' ) == null ) {
		// 	// update_option( 'flash_order_necessary_settings', FLASH_ORDER_TABLE_VERSION );
		// 	// FO_create_all_necessary_settings();
		// }
		
		FO_create_meta_table();

//genera errore
		// FOP_create_table();

		FO_init_css_activator();

		FO_create_all_necessary_settings();

		// FO_create_all_necessary_pages();

		FO_admin_autorole();
		
	}

}
