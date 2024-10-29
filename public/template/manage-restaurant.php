<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//test 
echo FO_create_post_QR_code();//phpcs:ignore
//------------------

FO_access_denied();

do_action( 'manage_restaurant_page_head' );

include_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( !is_plugin_active('flash_order_pro/flash_order_pro.php') ) {
    FO_pass_to_pro();
    return;
} else{
    do_action( 'manage_restaurant_pro_page_head' );
    include_once( WP_PLUGIN_DIR .'/flash_order/public/template/manage-tables.php');
}


// if ( is_plugin_active('flash_order/flash_order.php') ) {
//     include_once( WP_PLUGIN_DIR .'/flash_order/public/template/manage-tables.php');
// }



