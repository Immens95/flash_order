<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://innovazioneweb.com
 * @since      1.0.0
 *
 * @package    Flash_order
 * @subpackage Flash_order/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * @package    Flash_order
 * @subpackage Flash_order/public
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */

// flash_order

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//function FO_add_endpoints() {
//	global $wp_rewrite;
//  //Author page
//	add_rewrite_endpoint( 'flash-orders', EP_ALL );
//	add_rewrite_endpoint( 'manage-orders', EP_ALL );
//	add_rewrite_endpoint( 'manage-tables', EP_ALL );
//    $wp_rewrite->flush_rules();
//    flush_rewrite_rules();
//}
//add_action( 'init', 'FO_add_endpoints' );


include_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	add_action( 'admin_notices', 'FO_admin_notice_woocommerce_plugin_error' );
	return;
}

function FO_admin_notice_woocommerce_plugin_error() {
?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'ERROR! Flash Order requires Woocommerce Plugin to be installed and active', 'flash_order' ); ?></p>
	</div>
<?php
}

if ( FO_get_meta('fo_show_admin_bar_all') == 'no' ) {
	// if ( !current_user_can('manage_options', get_current_user_id()) ) {
		add_filter( 'show_admin_bar', '__return_false' );
	// }
}


// FO_create_all_necessary_settings();
function FO_create_all_necessary_settings(){
	FO_update_meta( 'fo_show_admin_bar_all', 'no', 'setting');
	FO_update_meta( 'fo_pickup_delivery_checkout', 'yes', 'setting');
	FO_update_meta( 'fo_notify_audio', esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/audio/achive-sound-132273.mp3', 'setting');
	FO_update_meta( 'fo_default_grid_view', 'no', 'setting');

	FO_update_meta( 'flash_order_order_summary', 'side_page', 'setting');
	FO_update_meta( 'flash_order_front_name', 'TAVOLO', 'setting');
	FO_update_meta( 'flash_order_front_surname', '', 'setting');
	FO_update_meta( 'fotimer_advanced', 'yes', 'setting');
	FO_update_meta( 'fotimer_advanced_factor', '0.25', 'setting');
	
	FO_update_meta( 'flash_orders_table_visualize_id', 'yes', 'setting' );
	FO_update_meta( 'flash_orders_table_visualize_name', 'yes', 'setting' );
	FO_update_meta( 'flash_orders_table_visualize_image', 'yes', 'setting' );
	FO_update_meta( 'flash_orders_table_visualize_warehouse', 'yes', 'setting' );
	FO_update_meta( 'flash_orders_table_visualize_note', 'yes', 'setting' );
	FO_update_meta( 'flash_orders_table_visualize_actions', 'yes', 'setting' );
	FO_update_meta( 'orders_limit_view', '200', 'setting' );
	FO_update_meta( 'orders_date_created', '240', 'setting' );
	FO_update_meta( 'ajax_refresh_order_seconds', '2000', 'setting' );

	FO_update_meta( 'manage_orders_table_visualize_id', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_name', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_products', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_info', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_status', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_actions', 'yes', 'setting' );
	FO_update_meta( 'manage_orders_table_visualize_totals', 'yes', 'setting' );

	FO_update_meta( 'product_ingredients_tax', 'yes', 'setting' );
	FO_update_meta( 'show_product_ingredients_tax', 'no', 'setting' );

	FO_update_meta( 'product_allergens_tax', 'yes', 'setting' );
	FO_update_meta( 'show_product_allergens_tax', 'no', 'setting' );

	FO_update_meta( 'product_temperature_tax', 'yes', 'setting' );
	FO_update_meta( 'show_product_temperature_tax', 'no', 'setting' );

	FO_update_meta( 'product_sticker_tax', 'yes', 'setting' );
	FO_update_meta( 'product_macro_categories_tax', 'yes', 'setting' );

	FO_update_meta( 'product_ingredients_images', 'yes', 'setting' );
	FO_update_meta( 'product_allergens_images', 'yes', 'setting' );
	FO_update_meta( 'product_tags_images', 'yes', 'setting' );
	FO_update_meta( 'posts_category_images', 'yes', 'setting' );
	FO_update_meta( 'posts_tag_images', 'yes', 'setting' );
}

// function FO_custom_mime_types( $mimes ) {
// 	// New allowed mime types.
// 	$mimes['webp']  = 'image/webp';
// 	return $mimes;
// }
// add_filter( 'upload_mimes', 'FO_custom_mime_types' );

function FO_clear_meta_database( $meta_key ){
	$database_val = FO_get_meta( $meta_key, 'all' );
	foreach ($database_val as $key => $value) {
		if ($value->meta_value == '') {
			FO_delete_meta_by_id( $value->id );
		}
		if ( $key == 0 ) { continue; }
		FO_delete_meta_by_id( $value->id );
	}
}
FO_clear_meta_database( 'default_css' );

FO_clear_meta_database( 'page_id_flash-orders' );
FO_clear_meta_database( 'page_version_flash-orders' );
FO_clear_meta_database( 'last_update_flash-orders' );

FO_clear_meta_database( 'page_id_flash-orders-ajax' );
FO_clear_meta_database( 'page_version_flash-orders-ajax' );
FO_clear_meta_database( 'last_update_flash-orders-ajax' );

FO_clear_meta_database( 'page_id_manage-orders' );
FO_clear_meta_database( 'page_version_manage-orders' );
FO_clear_meta_database( 'last_update_manage-orders' );

FO_clear_meta_database( 'page_id_manage-tables' );
FO_clear_meta_database( 'page_version_manage-tables' );
FO_clear_meta_database( 'last_update_manage-tables' );

FO_clear_meta_database( 'page_id_manage-restaurant' );
FO_clear_meta_database( 'page_version_manage-restaurant' );
FO_clear_meta_database( 'last_update_manage-restaurant' );

FO_clear_meta_database( 'page_id_warehouse' );
FO_clear_meta_database( 'page_version_warehouse' );
FO_clear_meta_database( 'last_update_warehouse' );


// add_action('plugins_loaded', 'FO_create_all_necessary_pages');
// FO_create_all_necessary_pages();
function FO_create_all_necessary_pages(){
	$response = array();
	// FO_create_page( 'flash-orders','<!-- wp:shortcode -->[FO_front_order_section]<!-- /wp:shortcode -->', '1.0.1' );
	// $response['flash-orders'] = '1.0.1';
	FO_create_page( 'flash-orders-ajax','<!-- wp:shortcode -->[FO_front_order_ajax_section]<!-- /wp:shortcode -->', '1.0.2' );
		$response['flash-orders-ajax'] = '1.0.2';
	// FO_create_page( 'manage-orders','<!-- wp:shortcode -->[FO_manage_order_section]<!-- /wp:shortcode -->', '1.0.1');
		// $response['manage-orders'] = '1.0.1';
	FO_create_page( 'manage-tables','<!-- wp:shortcode -->[FO_manage_tables_section]<!-- /wp:shortcode -->', '1.0.2' );
		$response['manage-tables'] = '1.0.2';
	FO_create_page( 'manage-restaurant','<!-- wp:shortcode -->[FO_manage_restaurant_section]<!-- /wp:shortcode -->', '1.0.1' );
		$response['manage-restaurant'] = '1.0.1';

	wp_send_json(array(
    	'response' 	=> $response,
    	// 'time_exec' => $time,
		// 'post' => $_POST,
	));
	die();
}
add_action('wp_ajax_FO_create_all_necessary_pages', 'FO_create_all_necessary_pages');
add_action('wp_ajax_nopriv_FO_create_all_necessary_pages', 'FO_create_all_necessary_pages');

function FO_create_page( $page_name, $content = '', $version = '1.0.0' ){
	$fo_page_id = FO_get_meta('page_id_'.$page_name);
	$fo_version = FO_get_meta('page_version_'.$page_name);

	$query_page_name = new WP_Query(  array(
	        'post_type'              => 'page',
	        'title'                  => $page_name,
	        'post_status'            => 'all',
	        'posts_per_page'         => 1,
	        'no_found_rows'          => true,
	    )
	);
	if ( get_post( $fo_page_id ) != null && !version_compare( $version, $fo_version, ">" ) ) {
	    return;
	}
	if( !FOcheck($fo_page_id) ) {
		if( $query_page_name ) {
			// add_action( 'init', function() use ($page_name, $content, $version ) {
			    $page_id = wp_insert_post( array(
			        'comment_status' => 'close',
			        'ping_status'    => 'close',
			        'post_author'    => get_current_user_id(),
			        'post_title'     => $page_name,
			        'post_name'      => strtolower(str_replace(' ', '-', trim($page_name))),
			        'post_status'    => 'publish',
			        'post_content'   => $content,
			        'post_type'      => 'page'
			        //'post_parent'    => ''
			        )
			    );
			    FO_update_meta( 'last_update_'.$page_name, current_datetime()->format('Y-m-d H:i:s'), 'page');
	    		FO_update_meta('page_version_'.$page_name, $version, 'page_id_'.$page_id );
	    		FO_update_meta('page_id_'.$page_name, $page_id, 'page_id');
			// });
	    }
	} else{
		if ( version_compare( $version, $fo_version, ">" ) ) {
		    // add_action( 'init', function() use ($fo_page_id, $content, $version ) {
			    wp_update_post( array(
				    	'ID' => $fo_page_id,
				    	'post_content'=> $content,
				    )
				);
			// });
			$query_page_name = new WP_Query( array( 
				'post_type'              => 'page',
				'title'                  => $page_name,
				// 'post_title'			 => $page_name,
				'post_status'            => 'all',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'orderby'                => 'post_date ID',
				'order'                  => 'ASC',
				)
			);

		    FO_update_meta( 'last_update_'.$page_name, current_datetime()->format('Y-m-d H:i:s'), 'page');
		    FO_update_meta('page_version_'.$page_name, $version, 'page_id_'.$query_page_name->ID );
		    FO_update_meta('page_id_'.$page_name, $query_page_name->ID, 'page_id');
		}
	}
}

/**
 * Recursive sanitation for an array
 * 
 * @param $array
 *
 * @return mixed
 */
function FO_recursive_sanitize_text_field($array) {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = recursive_sanitize_text_field($value);
        }
        else {
            $value = sanitize_text_field( $value );
        }
    }
    return $array;
}

function FO_delete_page(){
    if ( !isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'FO_manage_pages' ) ) {
        return;
    }
    $response = array();
    $page_name = (isset($_POST['page'])) ? sanitize_text_field(wp_unslash($_POST['page'])):'';
    $fo_page_id = FO_get_meta('page_id_'.$page_name);
    $fo_version = FO_get_meta('page_version_'.$page_name);

    $query_page_name = new WP_Query( array(
            'post_type'              => 'page',
            'title'                  => $page_name,
            'post_status'            => 'all',
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
        )
    );

    if( $query_page_name ) {
        wp_delete_post( $fo_page_id );
        // FO_delete_meta( 'last_update_'.$page_name );
        FO_delete_meta('page_version_'.$page_name );
        FO_delete_meta('page_id_'.$page_name );
        $response['deleted'] = 'deleted page -> '.$page_name;
    }

    wp_send_json(array(
        'response'  => $response,
        // 'time_exec' => $time,
        'post' => $_POST,
    ));
    die();
}
add_action('wp_ajax_FO_delete_page', 'FO_delete_page');
add_action('wp_ajax_nopriv_FO_delete_page', 'FO_delete_page');


function FO_display_post_states( $post_states, $post ) {
	$pages = FO_get_meta_by_assoc_id('page_id','OBJECT'); 
    foreach ( $pages as $key => $value ) {
        if ( $value->meta_value == $post->ID ) {
            $post_states[ 'fo_page_' . $value->meta_key ] = sprintf( 'FO page' );
        }
    }
    return $post_states;
}
add_filter( 'display_post_states', 'FO_display_post_states', 10, 2 );

// function FO_add_role(){
// 	add_role('worker', 'Worker', array());
// }
// add_action( 'init', 'FO_add_role' );

function FO_get_page_id_by_title( $title, $post_type = 'post' ) {
	// $page = get_page_by_title( $title, OBJECT, $post_type ); //deprecated function
	$page = get_posts(
	    array(
	        'post_type'              => 'page',
	        'title'                  => $post_type,
	        'post_status'            => 'all',
	        'numberposts'            => 1,
	        'update_post_term_cache' => false,
	        'update_post_meta_cache' => false,           
	        'orderby'                => 'post_date ID',
	        'order'                  => 'ASC',
	    )
	);
	return $page->ID;
}








function FOuserMetaForm($user) {
	if( !current_user_can('manage_options') ){return;};

	$user_id = $user->ID;

	$worker_checked = ( isset(get_user_meta($user_id, 'flash_order_user_role_worker')[0]) ) ? get_user_meta($user_id, 'flash_order_user_role_worker')[0] : false;
	$supervisor_checked = ( isset(get_user_meta($user_id, 'flash_order_user_role_supervisor')[0]) ) ? get_user_meta($user_id, 'flash_order_user_role_supervisor')[0] : false;
	$manager_checked = ( isset(get_user_meta($user_id, 'flash_order_user_role_manager')[0]) ) ? get_user_meta($user_id, 'flash_order_user_role_manager')[0] : false;

	$worker_checked = ( $worker_checked == 'on' ) ? 'checked="checked"' : '';
	$supervisor_checked = ( $supervisor_checked == 'on' ) ? 'checked="checked"' : '';
	$manager_checked = ( $manager_checked == 'on' ) ? 'checked="checked"' : '';
?>
<div style="width:100%;height:70px;"></div>
<h2>Flash-Order</h2>
	<table class="form-table">
		<tr>
			<th>
				<label for="flash_order_user_role_worker"><?php echo esc_html__( 'Aggiungi il ruolo worker', 'flash_order' );?></label>
			</th>
			<td>
				<input type="checkbox" name="flash_order_user_role_worker" id="flash_order_user_role_worker" <?php echo esc_attr($worker_checked);?>>
				<span class="description">
					<?php echo esc_html__( 'Aggiungi il ruolo (worker) all\'utente', 'flash_order' ); ?>
				</span>
			</td>
		</tr>

		<tr>
			<th>
				<label for="flash_order_user_role_supervisor"><?php echo esc_html__( 'Aggiungi il ruolo supervisor', 'flash_order' );?></label>
			</th>
			<td>
				<input type="checkbox" name="flash_order_user_role_supervisor" id="flash_order_user_role_supervisor" <?php echo esc_attr($supervisor_checked);?>>
				<span class="description">
					<?php echo esc_html__( 'Aggiungi il ruolo (supervisor) all\'utente', 'flash_order' ); ?>
				</span>
			</td>
		</tr>

		<tr>
			<th>
				<label for="flash_order_user_role_manager"><?php echo esc_html__( 'Aggiungi il ruolo manager', 'flash_order' );?></label>
			</th>
			<td>
				<input type="checkbox" name="flash_order_user_role_manager" id="flash_order_user_role_manager" <?php echo esc_attr($manager_checked);?>>
				<span class="description">
					<?php echo esc_html__( 'Aggiungi il ruolo (manager) all\'utente', 'flash_order' ); ?>
				</span>
			</td>
		</tr>

	</table>
<div style="width:100%;height:70px;"></div>
<?php
}

add_action('show_user_profile', 'FOuserMetaForm'); // editing your own profile
add_action('edit_user_profile', 'FOuserMetaForm'); // editing another user
add_action('user_new_form', 'FOuserMetaForm'); // creating a new user

function FOuserMetaSave($userId) {
	if (!current_user_can('edit_user', $userId)) {
		return;
	}
	if ( $_REQUEST['flash_order_user_role_worker'] == null ) {update_user_meta($userId, 'flash_order_user_role_worker', false);//phpcs:ignore
	}else{ update_user_meta($userId, 'flash_order_user_role_worker', $_REQUEST['flash_order_user_role_worker']); }//phpcs:ignore

	if ( $_REQUEST['flash_order_user_role_supervisor'] == null ) {update_user_meta($userId, 'flash_order_user_role_supervisor', false);//phpcs:ignore
	}else{ update_user_meta($userId, 'flash_order_user_role_supervisor', $_REQUEST['flash_order_user_role_supervisor']); }//phpcs:ignore

	if ( $_REQUEST['flash_order_user_role_manager'] == null ) {update_user_meta($userId, 'flash_order_user_role_manager', false);//phpcs:ignore
	}else{ update_user_meta($userId, 'flash_order_user_role_manager', $_REQUEST['flash_order_user_role_manager']); }//phpcs:ignore
	// update_user_meta($userId, 'flash_order_user_role_worker', $_REQUEST['flash_order_user_role_worker']);
	// update_user_meta($userId, 'flash_order_user_role_supervisor', $_REQUEST['flash_order_user_role_supervisor']);
	// update_user_meta($userId, 'flash_order_user_role_manager', $_REQUEST['flash_order_user_role_manager']);
}
add_action('personal_options_update', 'FOuserMetaSave');
add_action('edit_user_profile_update', 'FOuserMetaSave');
add_action('user_register', 'FOuserMetaSave');





function FO_view_table_in_grid(){
$checked =  ( FO_get_meta('fo_default_grid_view') == 'yes' ) ? 'checked' : '';
$style = ( FO_get_meta('fo_default_grid_view') == 'yes' ) ? 'display:block' : 'display:none';
?>
	<p title="<?php echo esc_html__( 'visualizza i risultati in griglia', 'flash_order' );?>">
		<?php echo esc_html__( 'Grid View', 'flash_order' );?>
	</p>

	<input type="checkbox" class="toggleView" onclick="jQuery(this).next().toggle();" <?php echo esc_attr($checked); ?>>
	<input type="range" min="10" max="100" value="50" class="FOslider GridRange" oninput="FO_grid_adjust(this.value)" style="<?php echo esc_attr($style); ?>">
<?php
}



function FOecho( $var = '' ){ 
	if ( $var != '' && $var != null ) {
		echo esc_attr($var);
	} else{
		echo '';
	}
}
function FOcheck( $var = '' ){ 
	if ( $var != '' && $var != null && $var != false ) {
		return true;
	} else{
		return false;
	}
}
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function FO_head_needed(){ ?>
	<!-- <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" /> -->
	<input type="hidden" class="fo_toggle_header_footer" name="fo_toggle_header_footer" value="true">
	<input type="hidden" class="fo_home_url" name="fo_home_url" value="<?php echo esc_url( get_home_url() ); ?>">
	<?php
}
add_action( 'wp_head', 'FO_head_needed' );

function fo_header_style() { ?>
	<style type="text/css" id=fo-root>
	:root{
		<?php 
			$styles = FO_get_meta_by_assoc_id('style_css','OBJECT'); 
			foreach( $styles as $style ){
				echo esc_attr($style->meta_key).': '.esc_attr($style->meta_value).'; ';
			}
		?>
	}
	</style>
	<?php
}
add_action( 'wp_head', 'fo_header_style' );
add_action( 'admin_head', 'fo_header_style' );

function fo_template_changer() {
	// global $wp;
	// if (isset($wp->query_vars['pagename'])) {
	// 	if ( $wp->query_vars['pagename'] == 'flash-orders' ) {
	// 		include_once('template/front-order.php');
	// 	} elseif ( $wp->query_vars['pagename'] == 'manage-orders' ) {
	// 		include_once('template/manage-order.php');
	// 	} elseif ( $wp->query_vars['pagename'] == 'manage-tables' ) {
	// 		include_once('template/manage-tables.php');
	// 	} elseif ( $wp->query_vars['pagename'] == 'manage-restaurant' ) {
	// 		include_once('template/manage-restaurant.php');
	// 	} else{}
	// }
}
function FO_init_page_maker(){
	$pages = FO_get_meta_by_assoc_id('page','OBJECT'); 
	if ( isset( $_SERVER["REDIRECT_URL"]) ) {
	foreach( $pages as $page ) {
		// FO_debug($page->meta_key);
			if ( str_contains( sanitize_text_field(wp_unslash($_SERVER["REDIRECT_URL"])), $page->meta_key ) ) {
				?>
 				
 				<?php
				// add_action( 'loop_end', 'fo_template_changer' );
				break;
			}
		}
	} // FO_debug($_SERVER["REDIRECT_URL"]);
}
// add_action( 'wp_body_open', 'FO_init_page_maker' );


add_action( 'woocommerce_account_content', 'FO_add_special_pages_navigations' );

function FO_add_special_pages_navigations(){
	$user = wp_get_current_user();

	$worker_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_worker')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_worker')[0] : false;
	$supervisor_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0] : false;
	$manager_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_manager')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_manager')[0] : false;
	
	if ( isset($manager_checked)  && $manager_checked == 'on' ) { $supervisor_checked = 'on'; $worker_checked = 'on'; }
	if ( isset($supervisor_checked) && $supervisor_checked == 'on' ) { $worker_checked = 'on'; }

	if ( $worker_checked == 'on' ) { 
		$fo_pages = FO_get_meta_by_assoc_id('page_id','OBJECT');
		?>
		<div>
			<nav id="FOSpecialPagesNavigation" style=""> <strong><?php esc_html_e( 'Pagine Speciali:', 'flash_order' );?> </strong>
				<?php foreach ($fo_pages as $key => $value) {
					$post = get_post($value->meta_value);
					if ( !$worker_checked && substr($value->meta_key, 8) == 'flash-orders-ajax' ) { continue; }
					if ( !$worker_checked && substr($value->meta_key, 8) == 'flash-orders' ) { continue; }

					if ( !$supervisor_checked && substr($value->meta_key, 8) == 'manage-tables' ) { continue; }
					if ( !$supervisor_checked && substr($value->meta_key, 8) == 'manage-orders' ) { continue; }
					if ( !$supervisor_checked && substr($value->meta_key, 8) == 'warehouse' ) { continue; }

					if ( !$manager_checked && substr($value->meta_key, 8) == 'manage-restaurant' ) { continue; }
					?>
					<?php if (get_post_status($value->meta_value) == 'publish') {?>
						<a href="<?php echo esc_url(get_post_permalink($value->meta_value));?>">
							<?php echo esc_attr(get_the_title($value->meta_value)); ?>
						</a>
					<?php } ?>
				<?php } ?>
			</nav>
		</div>
	<?php }
}



// add_action('plugins_loaded', 'FO_admin_autorole');
function FO_admin_autorole(){
	$user_query = get_users( array( 'role' => 'Administrator' ) );
	foreach ($user_query as $key => $value) {
		// FO_debug($value->data->ID);
		update_user_meta( $value->data->ID, 'flash_order_user_role_manager', 'on');
	}
}





function FO_header_special_pages_navigations(){
	$user = wp_get_current_user();
	$worker_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_worker')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_worker')[0] : false;
	$supervisor_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0] : false;
	$manager_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_manager')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_manager')[0] : false;
$fo_pages = FO_get_meta_by_assoc_id('page_id','OBJECT');

	$autorization = FO_access_autorization();
	if ( $autorization ) { ?>
		<div>
			<nav id="FOSpecialPagesNavigation" style=""> <strong><?php esc_html_e( 'Pagine Speciali:', 'flash_order' );?> </strong>
				<?php foreach ($fo_pages as $key => $value) {
					$post = get_post($value->meta_value);

					if ( !$worker_checked && substr($value->meta_key, 8) == 'flash-orders-ajax' ) { continue; }
					if ( !$worker_checked && substr($value->meta_key, 8) == 'flash-orders' ) { continue; }

					if ( !$supervisor_checked && substr($value->meta_key, 8) == 'manage-tables' ) { continue; }
					if ( !$supervisor_checked && substr($value->meta_key, 8) == 'manage-orders' ) { continue; }
					if( !$supervisor_checked && substr($value->meta_key, 8) == 'warehouse' ){ continue; }
					if( !$manager_checked && substr($value->meta_key, 8) == 'manage-restaurant' ){ continue; }
					?>
					<a href="<?php echo esc_url(get_post_permalink($value->meta_value));?>">
						<?php echo esc_attr($post->post_name);?>
					</a>
				<?php } ?>
				<?php 
				// do_action( 'FO_woocommerce_special_pages_navigations' );
				?>
			</nav>
		</div>
	<?php return; } 
}


add_shortcode( 'FO_front_order_section', 'FO_front_order_section' );
function FO_front_order_section(){
	if (!is_admin()) {
		if ( FO_access_autorization() ){
			FO_add_special_pages_navigations();
			FO_pages_header_controls();
		}
		include_once('template/front-order.php');
	}
}
add_shortcode( 'FO_front_order_ajax_section', 'FO_front_order_ajax_section' );
function FO_front_order_ajax_section(){
	if (!is_admin()) {
		if ( FO_access_autorization() ){
			// FO_add_special_pages_navigations();
			// FO_pages_header_controls();
		}
		include_once('template/front-order-ajax.php');
	}
}

add_shortcode( 'FO_manage_order_section', 'FO_manage_order_section' );
function FO_manage_order_section(){
	if (!is_admin()) {
		if ( FO_access_autorization() ){
			FO_add_special_pages_navigations();
			FO_pages_header_controls();
		}
		include_once('template/manage-order.php');
	}
}
add_shortcode( 'FO_manage_tables_section', 'FO_manage_tables_section' );
function FO_manage_tables_section(){
	if (!is_admin()) {
		if ( FO_access_autorization() ){
			FO_add_special_pages_navigations();
			FO_pages_header_controls();
		}
		include_once('template/manage-tables.php');
		// if ( defined('FLASH_ORDER_PRO_VERSION') ) {
		// 	FOP_manage_table();
		// }
		// do_action( 'manage_tables_page_head' );
	}
}
add_shortcode( 'FO_manage_restaurant_section', 'FO_manage_restaurant_section' );
function FO_manage_restaurant_section(){
	if (!is_admin()) {
		if ( FO_access_autorization() ){
			FO_add_special_pages_navigations();
			FO_pages_header_controls();
		}
		include_once('template/manage-restaurant.php');
	}
}


function FO_pages_header_controls(){
	?>
	<div id="" style="width:100%;border-bottom:1px solid;">
		<nav class="FO_nav_menu">
			<button onclick="toggleFullScreen()" title="<?php echo esc_html__( 'imposta il sito a schermo intero..... clicca nuovamente per uscire dalla modalità', 'flash_order' ); ?>"><?php echo esc_html__( 'Schermo Intero', 'flash_order' ); ?></button>

			<button id="FO_Hide_all_popup" onclick="FO_Hide_all_popup('.fo_tab_show, .fo_pay_tab_show,  .FOP_tab_catering_fixed_window, .fo_fixed_container')" title="<?php echo esc_html__( 'nascondi tutte le finestre popup della pagina', 'flash_order' ); ?>"><?php echo esc_html__( 'Nascondi tutti i PopUp', 'flash_order' ); ?></button>

			<button id="FO_Refresh0" onclick="javascript:history.go(0);" title="<?php echo esc_html__( 'aggiorna la pagina eludendo la cache', 'flash_order' ); ?>"><?php echo esc_html__( 'Aggiorna la Pagina', 'flash_order' ); ?></button>

			<button id="FO_hide_head_foot" onclick="fo_toggle_header_footer(true);" title="<?php echo esc_html__( 'Mostra/Nascondi header e footer della pagina.', 'flash_order' ); ?>"><?php esc_html_e( 'Mostra/Nascondi Header e Footer', 'flash_order' ); ?></button>
			
		</nav>
	</div>
	<?php
}

// FO_debug( FOW_get_warehouse_by_assoc_id_tax(14,'woo_product','OBJECT') );



if ( ! function_exists('FO_Catering_cpt') ) {
	// Register Custom Post Type
	function FO_Catering_cpt() {
		$labels = array(
			'name'                  => esc_html__( 'Catering', 'flash_order' ),
			'singular_name'         => esc_html__( 'Catering', 'flash_order' ),
			'menu_name'             => esc_html__( 'Catering', 'flash_order' ),
			'name_admin_bar'        => esc_html__( 'Catering', 'flash_order' ),
			'archives'              => esc_html__( 'Catering Archives', 'flash_order' ),
			'attributes'            => esc_html__( 'Catering Attributes', 'flash_order' ),
			'parent_item_colon'     => esc_html__( 'Parent Catering:', 'flash_order' ),
			'all_items'             => esc_html__( 'All Catering', 'flash_order' ),
			'add_new_item'          => esc_html__( 'Add New Catering', 'flash_order' ),
			'add_new'               => esc_html__( 'Add New', 'flash_order' ),
			'new_item'              => esc_html__( 'New Catering', 'flash_order' ),
			'edit_item'             => esc_html__( 'Edit Catering', 'flash_order' ),
			'update_item'           => esc_html__( 'Update Catering', 'flash_order' ),
			'view_item'             => esc_html__( 'View Catering', 'flash_order' ),
			'view_items'            => esc_html__( 'View Catering', 'flash_order' ),
			'search_items'          => esc_html__( 'Search Catering', 'flash_order' ),
			'not_found'             => esc_html__( 'Not found', 'flash_order' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'flash_order' ),
			'featured_image'        => esc_html__( 'Featured Image', 'flash_order' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'flash_order' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'flash_order' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'flash_order' ),
			'insert_into_item'      => esc_html__( 'Insert into Catering', 'flash_order' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this Catering', 'flash_order' ),
			'items_list'            => esc_html__( 'Items Catering', 'flash_order' ),
			'items_list_navigation' => esc_html__( 'Items Catering navigation', 'flash_order' ),
			'filter_items_list'     => esc_html__( 'Filter Catering list', 'flash_order' ),
		);
		$args = array(
			'label'                 => esc_html__( 'Catering', 'flash_order' ),
			'description'           => esc_html__( 'Post Type for Catering', 'flash_order' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'author', 'comments', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-list-view',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			// 'register_meta_box_cb' 	=> 'fo_catering_section_data',
		);
		register_post_type( 'catering', $args );
	}
	add_action( 'init', 'FO_Catering_cpt', 0 );
}




// Funzione per aggiungere la metabox personalizzata
function fo_add_data_metabox() {
    add_meta_box(
        'fo_add_data_metabox',    // ID univoco della metabox
        esc_html__('Data di Consegna: ', 'flash_order'), // Titolo della metabox
        'fo_show_data_metabox',   // Callback per visualizzare il contenuto della metabox
        'catering',               // Screen (CPT) dove visualizzare la metabox
        'normal',                 // Contesto della metabox (normal, side, ecc.)
        'high'                    // Priorità della metabox (high, low)
    );
}
add_action('add_meta_boxes', 'fo_add_data_metabox');

function fo_show_data_metabox($post) {
	$fo_delivery_date = get_post_meta($post->ID, 'fo_delivery_date', true);
	echo '<label for="fo_delivery_date">'.esc_html__(' Data di Consegna: ', 'flash_order').'</label>';
	echo '<input type="datetime-local" id="fo_delivery_date" name="fo_delivery_date" value="' . esc_attr($fo_delivery_date) . '" size="25" />';
	$nonce = wp_create_nonce( 'fo_data_metabox' );
	echo '<input type="hidden" id="_fononce" name="_fononce" value="'.esc_attr($nonce).'" />';
}

function fo_save_data_metabox($post_id) {
	if (!isset($_POST['_fononce'])) {
		return;
	}
	if ( !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce'])), 'fo_data_metabox' ) ) {
		return $post_id;
	}
	$fo_delivery_date = (isset($_POST['fo_delivery_date']) ? sanitize_text_field(wp_unslash($_POST['fo_delivery_date'])) : '');
	update_post_meta($post_id, 'fo_delivery_date', $fo_delivery_date);
}
add_action('save_post', 'fo_save_data_metabox');







// Register Custom Taxonomy
function FO_custom_taxonomy_ingredients() {
	$labels = array(
		'name'                       => esc_html__( 'Ingredienti', 'flash_order' ),
		'singular_name'              => esc_html__( 'Ingrediente', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Ingrediente', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutti gli Ingredienti', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore dell\'Ingrediente', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore dell\'Ingrediente:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuovo Ingrediente', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuovo Ingrediente', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Ingrediente', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Ingrediente', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Ingrediente', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa gli Ingredienti con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Ingredienti', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Ingredienti Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Ingredienti', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessun Ingrediente', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista ingredienti', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista ingredienti', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'Ingredienti', 'flash_order' ), array( 'product', 'product_variation','flash_product'  ), $args );
}
if (FO_get_meta('product_ingredients_tax') == 'yes') {
	add_action( 'init', 'FO_custom_taxonomy_ingredients', 0 );
	if (FO_get_meta('show_product_ingredients_tax') == 'yes') {
		add_action( 'woocommerce_product_meta_end', 'FO_show_ingredients_tax_to_product_page' );
	}
}

function FO_show_ingredients_tax_to_product_page(){
 echo get_the_term_list( get_the_ID(), 'Ingredienti', '<span class="tagged_as">Ingredienti: ', ', ', '</span>' );
}

// Register Custom Taxonomy
function FO_custom_taxonomy_allergens() {
	$labels = array(
		'name'                       => esc_html__( 'Allergeni', 'flash_order' ),
		'singular_name'              => esc_html__( 'Allergene', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Allergene', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutti gli Allergeni', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore dell\'Allergene', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore dell\'Allergene:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuovo Allergene', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuovo Allergene', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Allergene', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Allergene', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Allergene', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa gli Allergeni con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Allergeni', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Allergeni Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Allergeni', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessun Allergene', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Allergeni', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Allergeni', 'flash_order' ),
	);
	$args = array(
		'labels'            	=> $labels,
		'hierarchical'      	=> true,
		'public'            	=> true,
		'show_ui'           	=> true,
		'show_admin_column' 	=> true,
		'show_in_menu' 			=> true,
		'show_in_nav_menus' 	=> true,
		'show_in_quick_edit'	=> true,
		'show_tagcloud'     	=> true,
		'show_in_rest'      	=> true,
	);
	register_taxonomy( esc_html__( 'Allergeni', 'flash_order' ), array( 'product', 'product_variation','flash_product' ), $args );
}
if (FO_get_meta('product_allergens_tax') == 'yes') {
	add_action( 'init', 'FO_custom_taxonomy_allergens', 0 );
	if (FO_get_meta('show_product_allergens_tax') == 'yes') {
		add_action( 'woocommerce_product_meta_end', 'FO_show_allergeni_tax_to_product_page' );
	}
}

function FO_show_allergeni_tax_to_product_page(){
 echo get_the_term_list( get_the_ID(), 'Allergeni', '<span class="tagged_as">Allergeni: ', ', ', '</span>' );
}

// Register Custom Taxonomy
function FO_custom_taxonomy_temperature() {
	$labels = array(
		'name'                       => esc_html__( 'Temperature', 'flash_order' ),
		'singular_name'              => esc_html__( 'Temperatura', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Temperatura', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutte le Temperature', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore della Temperatura', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore della Temperatura:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuova Temperatura', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuova Temperatura', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Temperatura', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Temperatura', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Temperatura', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa le Temperature con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Temperature', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Temperature Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Temperature', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessuna Temperatura', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Temperature', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Temperature', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'Temperature', 'flash_order' ), array( 'product', 'product_variation','flash_product' ), $args );
}
if (FO_get_meta('product_temperature_tax') == 'yes') {
	add_action( 'init', 'FO_custom_taxonomy_temperature', 0 );
	// if (FO_get_meta('show_product_temperature_tax') == 'yes') {
	// 	add_action( 'woocommerce_product_meta_end', 'FO_show_temperature_tax_to_product_page' );
	// }
}

function FO_show_temperature_tax_to_product_page(){
 echo get_the_term_list( get_the_ID(), 'Temperature', '<span class="tagged_as">Temperature: ', ', ', '</span>' );
}


// Register Custom Taxonomy
function FO_custom_taxonomy_sticker() {
	$labels = array(
		'name'                       => esc_html__( 'Sticker', 'flash_order' ),
		'singular_name'              => esc_html__( 'Sticker', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Sticker', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutti gli Sticker', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore dello Sticker', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore dello Sticker:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuovo Sticker', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuovo Sticker', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Sticker', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Sticker', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Sticker', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa gli Sticker con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Sticker', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Sticker Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Sticker', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessuno Sticker', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Sticker', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Sticker', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'Sticker', 'flash_order' ), array( 'product', 'product_variation','flash_product' ), $args );
}
if (FO_get_meta('product_sticker_tax') == 'yes') {
	add_action( 'init', 'FO_custom_taxonomy_sticker', 0 );
	// if (FO_get_meta('show_product_sticker_tax') == 'yes') {
	// 	add_action( 'woocommerce_product_meta_end', 'FO_show_sticker_tax_to_product_page' );
	// }
}

function FO_show_sticker_tax_to_product_page(){
 echo get_the_term_list( get_the_ID(), 'Sticker', '<span class="tagged_as">Sticker: ', ', ', '</span>' );
}






// Register Custom Taxonomy
function FO_custom_taxonomy_macro_categories() {
	$labels = array(
		'name'                       => esc_html__( 'Macro Categorie', 'flash_order' ),
		'singular_name'              => esc_html__( 'Macro Categoria', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Macro Categorie', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutte le Macro Categorie', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore delle Macro Categorie', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore della Macro Categoria:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuova Macro Categorie', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuova Macro Categoria', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Macro Categoria', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Macro Categoria', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Macro Categoria', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa le Macro Categorie con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Macro Categoria', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra le più usate', 'flash_order' ),
		'popular_items'              => esc_html__( 'Macro Categorie Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Macro Categoria', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessuna Macro Categoria', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Macro Categorie', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Macro Categorie', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'macro_categories', 'flash_order' ), array( 'product','flash_product' ), $args );
}
if (FO_get_meta('product_macro_categories_tax') == 'yes') {
	add_action( 'init', 'FO_custom_taxonomy_macro_categories', 0 );
	
	if (FO_get_meta('show_product_macro_cat_tax') == 'yes') {
		add_action( 'woocommerce_product_meta_end', 'FO_show_macro_cat_tax_to_product_page' );
	}
}
function FO_show_macro_cat_tax_to_product_page(){
 echo get_the_term_list( get_the_ID(), 'Sticker', '<span class="tagged_as">Sticker: ', ', ', '</span>' );
}




// Register Custom Post Type
function FOP_tables_cpt() {

	$labels = array(
		'name'                  => esc_html__( 'tavoli', 'flash_order' ),
		'singular_name'         => esc_html__( 'tavolo', 'flash_order' ),
		'menu_name'             => esc_html__( 'Tavoli', 'flash_order' ),
		'name_admin_bar'        => esc_html__( 'Tavoli', 'flash_order' ),
		'archives'              => esc_html__( 'Tavoli', 'flash_order' ),
		'attributes'            => esc_html__( 'Tavoli', 'flash_order' ),
		'parent_item_colon'     => esc_html__( 'Genitore tavolo:', 'flash_order' ),
		'all_items'             => esc_html__( 'Tutti i tavoli', 'flash_order' ),
		'add_new_item'          => esc_html__( 'Aggiungi nuovo tavolo', 'flash_order' ),
		'add_new'               => esc_html__( 'Aggiungi nuovo', 'flash_order' ),
		'new_item'              => esc_html__( 'Nuovo tavolo', 'flash_order' ),
		'edit_item'             => esc_html__( 'Modifica tavolo', 'flash_order' ),
		'update_item'           => esc_html__( 'Aggiorna elemento', 'flash_order' ),
		'view_item'             => esc_html__( 'Visualizza tavolo', 'flash_order' ),
		'view_items'            => esc_html__( 'Visualizza tavoli', 'flash_order' ),
		'search_items'          => esc_html__( 'Cerca tavolo', 'flash_order' ),
		'not_found'             => esc_html__( 'Nessun tavolo', 'flash_order' ),
		'not_found_in_trash'    => esc_html__( 'Nessun tavolo in Trash', 'flash_order' ),
		'featured_image'        => esc_html__( 'Featured Image', 'flash_order' ),
		'set_featured_image'    => esc_html__( 'Imposta featured image', 'flash_order' ),
		'remove_featured_image' => esc_html__( 'Rimuovi la featured image', 'flash_order' ),
		'use_featured_image'    => esc_html__( 'Usa come featured image', 'flash_order' ),
		'insert_into_item'      => esc_html__( 'Inserisci nel tavolo', 'flash_order' ),
		'uploaded_to_this_item' => esc_html__( 'Aggiornato in questo tavolo', 'flash_order' ),
		'items_list'            => esc_html__( 'lista tavoli', 'flash_order' ),
		'items_list_navigation' => esc_html__( 'Items list navigation', 'flash_order' ),
		'filter_items_list'     => esc_html__( 'Filtra lista tavoli', 'flash_order' ),
	);
	$args = array(
		'label'                 => esc_html__( 'tavolo', 'flash_order' ),
		'description'           => esc_html__( 'Questo post type generato dal plug-in: FlashOrderPRO, serve per controllare e gestire i tavoli(o anche le zone speciali come ad es. il bancone, il cortile, il gazebo etc...), del tuo ristorante.', 'flash_order' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-food',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'tavoli', $args );
}
add_action( 'init', 'FOP_tables_cpt', 0 );



// Register Custom Taxonomy
function FOP_custom_taxonomy_status() {
	$labels = array(
		'name'                       => esc_html__( 'status', 'flash_order' ),
		'singular_name'              => esc_html__( 'Status', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Status', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutti gli Status', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore dello Status', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore dello Status:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuovo Status', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuovo Status', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Status', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Status', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Status', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa gli Status con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Status', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Status Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Status', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessuno Status', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Status', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Status', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'status', 'flash_order' ), array( 'tavoli' ), $args );
}
// if (FO_get_meta('product_sticker_tax') == 'yes') {
	add_action( 'init', 'FOP_custom_taxonomy_status', 0 );
// }


// Register Custom Taxonomy
function FOP_custom_taxonomy_zone() {
	$labels = array(
		'name'                       => esc_html__( 'zone', 'flash_order' ),
		'singular_name'              => esc_html__( 'Zona', 'flash_order' ),
		'menu_name'                  => esc_html__( 'Zone', 'flash_order' ),
		'all_items'                  => esc_html__( 'Tutti le Zone', 'flash_order' ),
		'parent_item'                => esc_html__( 'Genitore della Zona', 'flash_order' ),
		'parent_item_colon'          => esc_html__( 'Genitore della Zona:', 'flash_order' ),
		'new_item_name'              => esc_html__( 'Nuova Zona', 'flash_order' ),
		'add_new_item'               => esc_html__( 'Aggiungi Nuova Zona', 'flash_order' ),
		'edit_item'                  => esc_html__( 'Edita Zona', 'flash_order' ),
		'update_item'                => esc_html__( 'Aggiorna Zona', 'flash_order' ),
		'view_item'                  => esc_html__( 'Visualizza Zona', 'flash_order' ),
		'separate_items_with_commas' => esc_html__( 'Separa le Zone con la virgola', 'flash_order' ),
		'add_or_remove_items'        => esc_html__( 'Aggiungi o Rimuovi Zone', 'flash_order' ),
		'choose_from_most_used'      => esc_html__( 'Scegli fra i più usati', 'flash_order' ),
		'popular_items'              => esc_html__( 'Zone Popolari', 'flash_order' ),
		'search_items'               => esc_html__( 'Cerca Zone', 'flash_order' ),
		'not_found'                  => esc_html__( 'Nessun risultato', 'flash_order' ),
		'no_terms'                   => esc_html__( 'Nessuna Zona', 'flash_order' ),
		'items_list'                 => esc_html__( 'lista Zone', 'flash_order' ),
		'items_list_navigation'      => esc_html__( 'navigazione lista Zone', 'flash_order' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu' 		=> true,
		'show_in_nav_menus' => true,
		'show_in_quick_edit'=> true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
	);
	register_taxonomy( esc_html__( 'zone', 'flash_order' ), array( 'tavoli' ), $args );
}
// if (FO_get_meta('product_sticker_tax') == 'yes') {
	add_action( 'init', 'FOP_custom_taxonomy_zone', 0 );
// }








// add_filter( 'woocommerce_single_variations_taxonomies', 'FO_add_custom_taxonomies', 10, 1 );
// function FO_add_custom_taxonomies( $taxonomies ) {
//    $taxonomies[] = 'Ingredienti';
//    $taxonomies[] = 'Allergeni';
//    return $taxonomies;
// }






add_action( 'woocommerce_variation_options_pricing', 'FO_add_custom_field_to_variations', 10, 3 );
function FO_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
echo '<div class="fo-vari-tabs-container">';
	// if (FO_get_meta('product_price_to_add') == 'yes') {
		// FO_price_to_add_variation( $loop, $variation_data, $variation );
	// }
    $nonce = wp_create_nonce( 'FO_custom_field_to_variations_nonce' );
    echo '<input type="hidden" id="_fononce" name="_fononce" value="'.esc_attr($nonce).'" />';

	if (FO_get_meta('product_ingredients_tax') == 'yes') {
		FO_tax_field_variation( 'Ingredienti', $loop, $variation_data, $variation );
	}
	if (FO_get_meta('product_allergens_tax') == 'yes') {
		FO_tax_field_variation( 'Allergeni', $loop, $variation_data, $variation );
	}
	if (FO_get_meta('product_temperature_tax') == 'yes') {
		FO_tax_field_variation( 'Temperature', $loop, $variation_data, $variation );
	}
	if (FO_get_meta('product_sticker_tax') == 'yes') {
		FO_tax_field_variation( 'Sticker', $loop, $variation_data, $variation );
	}
echo '</div>';
}
// function FO_price_to_add_variation( $loop, $variation_data, $variation ){
// 	$Price = $variation_data['price_to_add'][0];
// // FO_debug($Tax);
// 	echo '<div class="variable_pricing" style="width:100%;">';
// 		echo '<p class="form-field form-row form-row-first">';
// 			echo '<label >'.esc_html__('Prezzo Aggiunta','flash_order').'</label>';
// 			echo '<input type="text" class="short wc_input_price" name="price_to_add['.$loop.']" value="'.$Price.'" placeholder="'.esc_html__('Il Prezzo da aggiungere al prezzo di listino').'">';
// 		echo '</p>';
// 	echo '</div>';
// }

function FO_tax_field_variation( $taxonomy, $loop, $variation_data, $variation ){
	$Tax = json_decode($variation_data[$taxonomy][0]);
	$fo_check = '';
// FO_debug($variation_data);
	echo '<div class="fo-vari-tabs-panel">';
		echo '<div class="fo-vari-title">'.esc_attr($taxonomy).'</div>';
		echo '<ul class="categorychecklist form-no-clear">';
	$terms = get_terms( array('taxonomy'=>$taxonomy,'hide_empty'=>false) );
	foreach ($terms as $key => $value) {
		$fo_check = ( FO_in_array( $value->slug, $Tax ) )? 'checked="checked"': '';
		echo '<li>';
			echo '<label class="selectit">';
				echo '<input name="'.esc_attr($taxonomy).'['.esc_attr($variation->ID).']['.esc_attr($key).']" type="checkbox" value="'.esc_attr($value->slug).'" '.esc_attr($fo_check).'>';
					echo esc_attr($value->slug);
			echo '</label>';
		echo '</li>';
	}
		echo '</ul>';
	echo '</div>';
}
function FO_in_array( $search_for, $haystack = array() ){
	foreach ($haystack as $k => $v) {
		if ( $v == $search_for ) {
			$return = true;
			break;
		} else{ $return = false; }
	}
	return $return;
}

add_action( 'woocommerce_save_product_variation', 'FO_save_custom_field_variations', 10, 2 );
add_action( 'woocommerce_update_product_variation', 'FO_update_custom_field_variations', 10, 2 );
function FO_update_custom_field_variations( $variation_id, $product ){
	if ( !isset($_POST['_fononce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce'])), 'FO_custom_field_to_variations_nonce' ) ) {
		return $variation_id;
	}
   // if ( isset( $_POST['price_to_add'][$variation_id] ) ) {
   // 	   	$price_to_add = FO_recursive_sanitize_text_field(wp_unslash($_POST['price_to_add'][$variation_id]));//phpcs:ignore
// 		update_post_meta( $variation_id, 'price_to_add',  wp_json_encode($price_to_add) );
   // }
   if ( isset( $_POST['Ingredienti'][$variation_id] ) ) {
   	   	$Ingredienti = FO_recursive_sanitize_text_field(wp_unslash($_POST['Ingredienti'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Ingredienti', wp_json_encode( $Ingredienti ) );
   }
   if ( isset( $_POST['Allergeni'][$variation_id] ) ) {
   	   	$Allergeni = FO_recursive_sanitize_text_field(wp_unslash($_POST['Allergeni'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Allergeni',  wp_json_encode($Allergeni) );
   }
   if ( isset( $_POST['Temperature'][$variation_id] ) ) {
   	   	$Temperature = FO_recursive_sanitize_text_field(wp_unslash($_POST['Temperature'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Temperature',  wp_json_encode($Temperature) );
   }
   if ( isset( $_POST['Sticker'][$variation_id] ) ) {
   	   	$Sticker = FO_recursive_sanitize_text_field(wp_unslash($_POST['Sticker'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Sticker',  wp_json_encode($Sticker) );
   }
}
function FO_save_custom_field_variations( $variation_id, $i ) {
	if ( !isset($_POST['_fononce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce'])), 'FO_custom_field_to_variations_nonce' ) ) {
		return $variation_id;
	}
   if ( isset( $_POST['Ingredienti'][$variation_id] ) ) {
   	   	$Ingredienti = FO_recursive_sanitize_text_field(wp_unslash($_POST['Ingredienti'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Ingredienti', wp_json_encode( $Ingredienti ) );
   }
   if ( isset( $_POST['Allergeni'][$variation_id] ) ) {
   	   	$Allergeni = FO_recursive_sanitize_text_field(wp_unslash($_POST['Allergeni'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Allergeni',  wp_json_encode($Allergeni) );
   }
   if ( isset( $_POST['Temperature'][$variation_id] ) ) {
   	   	$Temperature = FO_recursive_sanitize_text_field(wp_unslash($_POST['Temperature'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Temperature',  wp_json_encode($Temperature) );
   }
   if ( isset( $_POST['Sticker'][$variation_id] ) ) {
   	   	$Sticker = FO_recursive_sanitize_text_field(wp_unslash($_POST['Sticker'][$variation_id]));//phpcs:ignore
		update_post_meta( $variation_id, 'Sticker',  wp_json_encode($Sticker) );
   }
}
 


// -----------------------------------------
// 3. Store custom field value into variation data
// add_filter( 'woocommerce_available_variation', 'FO_add_custom_field_variation_data' );
function FO_add_custom_field_variation_data( $variations ) {
	$variations['price_to_add'] = '<div class="woocommerce_custom_field">price_to_add: <span>' . get_post_meta( $variations[ 'price_to_add' ], 'price_to_add', true ) . '</span></div>';
   $variations['Ingredienti'] = '<div class="woocommerce_custom_field">Ingredienti: <span>' . get_post_meta( $variations[ 'variation_id' ], 'Ingredienti', true ) . '</span></div>';
   $variations['Allergeni'] = '<div class="woocommerce_custom_field">Allergeni: <span>' . get_post_meta( $variations[ 'variation_id' ], 'Allergeni', true ) . '</span></div>';
   $variations['Temperature'] = '<div class="woocommerce_custom_field">Temperature: <span>' . get_post_meta( $variations[ 'variation_id' ], 'Temperature', true ) . '</span></div>';
    $variations['Sticker'] = '<div class="woocommerce_custom_field">Sticker: <span>' . get_post_meta( $variations[ 'variation_id' ], 'Sticker', true ) . '</span></div>';
   return $variations;
}





/*

function FO_wc_attribute_price_to_add( $taxonomy ) {
	// FO_debug( $_GET['tag_ID'] );
	// get_term_by('name',$taxonomy);
	$id = isset( $_GET['tag_ID'] ) ? absint( $_GET['tag_ID'] ) : 0;
	$value = $id ? get_term_meta( $id, 'price_to_add',true ) : '';

	FO_debug( $value );
	?>
		<tr class="form-field" style="margin: 10px 0px;">
			<th scope="row" valign="top">
				<label for="price_to_add"><?php esc_html_e('Prezzo Aggiunta','flash_order'); ?></label>
			</th>
			<td>
				<input name="price_to_add" id="price_to_add" type="text" value="<?php echo esc_attr($value); ?>" placeholder="<?php esc_html_e('Il Prezzo da aggiungere al prezzo di listino');?>" style="width:100%;margin: 10px 0px;"/>
			</td>
		</tr>
	<?php
}
function FO_save_wc_attribute_price_to_add( $term_id ) {
    if( isset( $_POST['price_to_add'] ) && ! empty( $_POST['price_to_add'] ) ) {
        update_term_meta( $term_id, 'price_to_add', $_POST['price_to_add'] );
    } else {
        // delete_term_meta( $term_id, 'price_to_add' );
    }
}
*/

// function FO_price_to_add_column_content( $content, $column_name, $term_id ) {
// 	$price_to_add = get_term_meta($term_id, 'price_to_add', true);
// 	// if ( $column_name == 'price_to_add' ) {
// 	// 	echo '<div>'.$price_to_add.'</div>';
// 	// }
// 	switch ( $column_name ) {
//         case 'price_to_add' :
//         echo '<div>'.$price_to_add.'</div>';
//     break;
// 	}
// }
// function FO_add_new_price_to_add_taxonomy_columns( $columns ) {
//     $columns['price_to_add'] = esc_html__( 'Aggiunta', 'flash_order' );
//     return $columns;
// }
// if (isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
// 	add_action( 'add_tag_form_fields', 'FO_wc_attribute_price_to_add' );
// 	add_action( 'edit_tag_form_fields', 'FO_wc_attribute_price_to_add' );

// 	if (isset($_GET['taxonomy']) && $_GET['taxonomy'] != '') {
// 		// add_filter( 'manage_'.$_GET['taxonomy'].'_custom_column', 'FO_price_to_add_column_content', 10, 3 );
// 		// add_filter( 'manage_edit-'.$_GET['taxonomy'].'_columns', 'FO_add_new_price_to_add_taxonomy_columns', 10, 3 );
// 		add_action( 'created_'.$_GET['taxonomy'], 'FO_save_wc_attribute_price_to_add' );
// 		add_action( 'edit_'.$_GET['taxonomy'], 'FO_save_wc_attribute_price_to_add' );
// 	}

// }

// $term = get_queried_object();
// $attr_id = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
// get_term_meta( $term_id, 'price_to_add' );









function FO_taxonomy_add_custom_field() {
	$nonce = wp_create_nonce( 'FO_tax_image_nonce' );
    ?>
    <div class="form-field term-image-wrap">
        <label for="cat-image"><?php esc_html_e( 'Image', 'flash_order' ); ?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary"><?php esc_html_e('Carica Immagine', 'flash_order' ); ?></a></p>
        <img width="250px" src="" id="tax-img-src" style="display:none;padding:10px;margin:10px;" />
        <input type="text" name="taxonomy_image" id="tax-image" size="40" />
        <input type="hidden" id="_fononce_tax_image" name="_fononce_tax_image" value="<?php echo esc_attr($nonce);?>"/>
    </div>
    <?php
}
function FO_taxonomy_edit_custom_field($term) {
    $image = get_term_meta($term->term_id, 'taxonomy_image', true);
    $nonce = wp_create_nonce( 'FO_tax_image_nonce' );
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="taxonomy_image"><?php esc_html_e( 'Image', 'flash_order' ); ?></label></th>
        <td>
            <p><a href="#" class="aw_upload_image_button button button-secondary"><?php esc_html_e('Carica Immagine', 'flash_order' ); ?></a></p><br/>
            <img width="250px" src="<?php echo esc_attr($image); ?>" id="tax-img-src" style="padding:10px;margin:10px;" />
            <input type="text" name="taxonomy_image" id="tax-image" placeholder="image url" value="<?php echo esc_attr($image); ?>" size="40" />
            <input type="hidden" id="_fononce_tax_image" name="_fononce_tax_image" value="<?php echo esc_attr($nonce);?>"/>
        </td>
    </tr>
    <?php
    // FO_debug($image );
}
function FO_taxonomy_column_content( $content, $column_name, $term_id ) {
    $image = get_term_meta($term_id, 'taxonomy_image', true);
    if(!FOcheck($image)){
    	$image = esc_url( get_home_url() ).'/wp-content/plugins/woocommerce/assets/images/placeholder.png';
    }
        switch ( $column_name ) {
        case 'image' :
        echo '<img style="max-width:80px;max-height:60px" src="'.esc_attr($image).'" />';
        break;
    }
}
function FO_add_new_taxonomy_columns( $columns ) {
    $columns['image'] = esc_html__( 'Immagine', 'flash_order' );
    return $columns;
}
function FO_save_taxonomy_custom_meta_field( $term_id ) {
	if (!isset($_POST['_fononce_tax_image']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce_tax_image'], 'FO_tax_image_nonce' ))) ) {
		return $term_id;
	}
    if ( isset( $_POST['taxonomy_image'] ) ) {
        update_term_meta($term_id, 'taxonomy_image', sanitize_text_field(wp_unslash($_POST['taxonomy_image'])));
    }
}
function FO_taxonomy_add_meta_image( $taxonomy ){
	add_action( 'edited_'.$taxonomy, 'FO_save_taxonomy_custom_meta_field', 10, 2 );  
	add_action( 'create_'.$taxonomy, 'FO_save_taxonomy_custom_meta_field', 10, 2 );
	add_action( $taxonomy.'_add_form_fields', 'FO_taxonomy_add_custom_field', 10, 2 );
	add_action( $taxonomy.'_edit_form_fields', 'FO_taxonomy_edit_custom_field', 10, 2 );
	add_filter( 'manage_'.$taxonomy.'_custom_column', 'FO_taxonomy_column_content', 10, 3 );
	add_filter( 'manage_edit-'.$taxonomy.'_columns', 'FO_add_new_taxonomy_columns', 10, 3 );
}
function FO_add_image_custom_field_to_tax(){
	if ( FO_get_meta('product_ingredients_tax') == 'yes' ) {
		if ( FO_get_meta('product_ingredients_images') == 'yes' ) {
			FO_taxonomy_add_meta_image('Ingredienti');
		} 
	}
	if ( FO_get_meta('product_allergens_tax') == 'yes' ) {
		if ( FO_get_meta('product_allergens_images') == 'yes' ) {
			FO_taxonomy_add_meta_image('Allergeni');
		} 
	}
	if ( FO_get_meta('product_temperature_tax') == 'yes' ) {
		if ( FO_get_meta('product_temperature_images') == 'yes' ) {
			FO_taxonomy_add_meta_image('Temperature');
		} 
	}
	if ( FO_get_meta('product_sticker_tax') == 'yes' ) {
		if ( FO_get_meta('product_sticker_images') == 'yes' ) {
			FO_taxonomy_add_meta_image('Sticker');
		} 
	}
	if ( FO_get_meta('product_macro_categories_tax') == 'yes' ) {
		// if ( FO_get_meta('product_macro_categories_images') == 'yes' ) {
			FO_taxonomy_add_meta_image('macro_categories');
		// } 
	}
	if ( FO_get_meta('product_tags_images') == 'yes' ) {
		FO_taxonomy_add_meta_image('product_tag');
	}
	if ( FO_get_meta('posts_category_images') == 'yes' ) {
		FO_taxonomy_add_meta_image('category');
	}
	if ( FO_get_meta('posts_tag_images') == 'yes' ) {
		FO_taxonomy_add_meta_image('post_tag');
	}
}
add_action( 'init', 'FO_add_image_custom_field_to_tax' );








/**
 *
 * ---------- Utility functions ---------- 
 * 
 * 
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     GraphicNTT <info@graphicntt.com>
 */
function FO_debug( $var ){ 
	echo "<pre>";
		var_dump($var);//phpcs:ignore
	echo "</pre>";
}
function FO_access_autorization( $role = 'worker',  $mode = true ){
	$user = wp_get_current_user();
	$autorization = false;

	$worker_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_worker')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_worker')[0] : false;
	$supervisor_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0] : false;
	$manager_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_manager')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_manager')[0] : false;

	$worker 	= ( $worker_checked !== false && $role == 'worker' ) ? true : false;
	$supervisor = ( $supervisor_checked !== false && $role == 'supervisor' ) ? true : false;
	$manager 	= ( $manager_checked !== false && $role == 'manager' ) ? true : false;

	if ( $mode ) {
		if ($worker) { $autorization = true; }
		if ($supervisor) { $autorization = true; }
		if ($manager) { $autorization = true; }
	}else{
		if ($worker && $supervisor && $manager) { $autorization = true; }
	}
	return $autorization;
}
function FO_access_autorization_level(){
	$user = wp_get_current_user();
	$autorization = 0;

	$worker_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_worker')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_worker')[0] : false;
	$supervisor_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_supervisor')[0] : false;
	$manager_checked = ( isset(get_user_meta($user->ID, 'flash_order_user_role_manager')[0]) ) ? get_user_meta($user->ID, 'flash_order_user_role_manager')[0] : false;

	$worker 	= ( $worker_checked !== false ) ? true : false;
	$supervisor = ( $supervisor_checked !== false ) ? true : false;
	$manager 	= ( $manager_checked !== false) ? true : false;

	if ($worker) { $autorization += 1; }
	if ($supervisor) { $autorization += 1; }
	if ($manager) { $autorization += 1; }

	return $autorization;
}


function FO_access_denied(){
	$autorization = FO_access_autorization();
	if ( !$autorization ) { ?>
	<div style="width:calc(100% - 60px);margin:20px;padding:10px;">
		<div class="title">
			<?php esc_html_e( 'NON Hai il permesso per accedere a questa pagina!', 'flash_order' ); ?>
			<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>"><?php esc_html_e( ' Clicca qui per Accedere ', 'flash_order' ); ?> </a>
		</div>
	</div>
	<?php exit; } 
}

function FO_soft_access_denied(){
	$user = wp_get_current_user();

	if ( !$user->ID ) { ?>
		<div id="FOSetting_UserLoggedIn" style="display:none!important;">0</div>
	<div style="width:calc(100% - 60px);margin:20px;padding:10px;">
		<div class="title">
			<?php esc_html_e( 'Per poter effettuare ordini su questa pagina, é necessario effettuare l\'accesso.', 'flash_order' ); ?>
			<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>"><?php esc_html_e( ' Clicca qui per Accedere ', 'flash_order' ); ?> </a>
		</div>
	</div>

	<div class="FO_logIn_popUp" style="display:none;">
		<div class="fo_short_form">
			<?php 
			if ( FO_get_meta('custom_shortcode_login')!='' ) {
				$login_short = FO_get_meta('custom_shortcode_login');
			} else{
				$login_short = '[woocommerce_my_account]';
			}
			echo do_shortcode( $login_short ); 
			?>
		</div>
		<div class="foBackground"></div>
	</div>

	<?php } else{ ?>
		<div id="FOSetting_UserLoggedIn" style="display:none!important;">100000</div>
	<?php }
}






function FO_create_post_QR_code_shortcode( $atts ) {
 
	// The file responsible for defining qr code generator library
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/qrlib.php';

	// Extract shortcode attributes.
	$atts = shortcode_atts(
		array(
			'size'    	=> '150', // Default size.
			'post_id' 	=> get_the_ID(), // Default post ID.
		),
		$atts,
		'fo_qr_code' // Shortcode tag.
	);
	$def_class = 'fo_qr_image ';

	$post_id = absint( $atts['post_id'] );
	$size    = absint( $atts['size'] );
	// $class   = $def_class . $atts['class'];

	$url = esc_url_raw( trailingslashit( get_site_url() ) . '?p=' . $post_id );

	$qr_dir   = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/';
	$filename = $qr_dir . 'post_' . $post_id . '.png';

	// Check if the file exists.
	if ( ! file_exists( $filename ) ) {
		QRcode::png( $url, $filename, 'L', 10, 2 ); // Create the QR code.
	}
	// Return the image tag.
	$qr_url = esc_url_raw( plugin_dir_url( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/post_' . $post_id . '.png' );
	return '<img src="'.$qr_url.'" height="'.$size.'" width="'.$size.'">';
}
add_shortcode( 'fo_qr_code', 'FO_create_post_QR_code_shortcode' );

function FO_create_post_QR_code() {
	// The file responsible for defining qr code generator library
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/qrlib.php';

	$atts = array(
		'size'    	=> '150', // Default size.
		'post_id' 	=> get_the_ID(), // Default post ID.
	);
	$post_id = absint( $atts['post_id'] );
	$size    = absint( $atts['size'] );

	$url = esc_url_raw( trailingslashit( get_site_url() ) . '?p=' . $post_id );

	$qr_dir   = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/';
	// $qr_dir   = content_url() . 'uploads/';
	$filename = $qr_dir . 'post_' . $post_id . '.png';

	// Check if the file exists.
	if ( ! file_exists( $filename ) ) {
		QRcode::png( $url, $filename, 'L', 10, 2 ); // Create the QR code.
	}
	// Return the image tag.
	$qr_url = esc_url_raw( plugin_dir_url( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/post_' . $post_id . '.png' );
	return '<img src="'.esc_attr($qr_url).'" height="'.esc_attr($size).'" width="'.esc_attr($size).'">';
}





function FO_create_any_QR_code( $atts ) {
	// The file responsible for defining qr code generator library
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/qrlib.php';

	$def_atts = array(
		'size'    	=> '150', // Default size.
		'content' 	=> get_home_url(), // Default post ID.
		'name'		=> 'Home Url',
	);
	$size 	 = absint( $atts['size'] );
	$content = sanitize_text_field( $atts['content'] );
	$name 	 = sanitize_text_field( $atts['name'] );

	$qr_dir   = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/';
	$filename = $qr_dir . 'any - ' . $name . '.png';

	// Check if the file exists.
	if ( ! file_exists( $filename ) ) {
		QRcode::png( $content, $filename, 'L', 10, 2 ); // Create the QR code.
	}
	// Return the image tag.
	$qr_url = esc_url_raw( plugin_dir_url( dirname( __FILE__ ) ) . 'includes/phpqrcode/QRgenerate/any - ' . $name . '.png' );
	return '<img src="'.$qr_url.'" height="'.$size.'" width="'.$size.'">';
}










function FO_hover_message( $message = '', $args = array() ){
	$default_args = array(
		'callback' 	=> '',
		'action' 	=> ''
	);
	$action 	= ( isset($args['action']) ) ? $args['action'] : $default_args['action'];
	$callback 	= ( isset($args['callback']) ) ? $args['callback'] : $default_args['callback'];
?>
<div class="hoverMessage" style="display:none;" onclick="jQuery(this).hide()">
	<?php 
	echo esc_attr($message); 
	if ( $callback != '' ) {
		add_action('FO_hover_message', $callback );
	}
	do_action( 'FO_hover_message' );
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		    "use strict";
		    jQuery('.hoverMessage').appendTo('body');
		    jQuery('.hoverMessage').show();
		    jQuery('.hoverMessage').css('opacity','0.95');
		});
	</script>
</div>
<?php
}

function FO_loading_message(){
	?>
	<div class="FOloadingMessage" style="display:none;">
		<span style="animation: fospin 1s infinite;font-size:150px;width:150px;height:150px;margin-top:20vh;" class="dashicons dashicons-update"></span>
<!-- dashicons-update-alt -->
<!-- dashicons-hourglass -->
	</div>
<?php
}
add_action( 'wp_body_open', 'FO_loading_message' );


function fo_load_dashicons(){
   wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'fo_load_dashicons', 999);


// FO_init_css_activator();
function FO_init_css_activator(){
	$default_css = FO_default_css();
	foreach ($default_css as $key => $value) {
		FO_update_meta( $key, $value, 'style_css' );
		FO_clear_meta_database( $key );
	}
}
// FO_default_css();
function FO_default_css(){
	// $data_css = (array)json_decode( FO_get_meta('default_css') );
	$default_css = array(
		'--fo-main-color' 		=> '#354357',
		'--fo-scnd-color' 		=> '#715b3e',
		'--fo-high-color' 		=> '#3a5a2d',
		'--fo-invert-color' 	=> '#0091ff',
		'--fo-link-color' 		=> '#c2c2c2',
		'--fo-selection-color' 	=> '#ffc4b1',
		'--fo-error-color' 		=> '#f50000',

		'--fo-bg-color' 		=> '#505050',
		'--fo-bg2-color' 		=> '#404040',
		'--fo-bg3-color' 		=> '#303030',
		'--fo-bg4-color' 		=> '#202020',
		'--fo-bg5-color' 		=> '#101010',
		'--fo-bg6-color' 		=> '#000000',

		'--fo-text-color' 		=> '#ffffff',
		'--fo-text-color-inv' 	=> '#000000',
		'--fo-text-shadow' 		=> ' 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;',
		'--fo-main-border' 		=> '1px solid #715b3e',

		'--fo-main-tran' 		=> '0.6s',
		'--fo-scnd-tran' 		=> '0.3s',

		'--fo-pending' 		=> '#00f5d0',
		'--fo-processing' 	=> '#f5d400',
		'--fo-failed' 		=> '#f50000',
		'--fo-cancelled' 	=> '#f50000',
		'--fo-refunded' 	=> '#f50000',
		'--fo-completed' 	=> '#279900',
		'--fo-modified' 	=> '#f55600',

		'--fo-tab-1' 	=> '#279900',
		'--fo-tab-2' 	=> '#f50000',
		'--fo-tab-3' 	=> '#9300f5',
		'--fo-tab-4' 	=> '#f5d400',
		'--fo-tab-5' 	=> '#1a63f4',
		'--fo-tab-6' 	=> '#00f5d0',

		'--fo-timer-1' 	=> '#279900',
		'--fo-timer-2' 	=> '#f5d400',
		'--fo-timer-3' 	=> '#f50000'
	);
	FO_update_meta( 'default_css', wp_json_encode( $default_css ) );
	foreach ($default_css as $key => $value) {
		FO_clear_meta_database( $key );
	}
	return $default_css;
}
function FO_customized_css(){
	$default_css = FO_default_css();
	$style = array(
		'--fo-main-color' 		=> ( FO_get_meta( '--fo-main-color' ) != null ) ? FO_get_meta( '--fo-main-color' ) : $default_css['--fo-main-color'],
		'--fo-scnd-color' 		=> ( FO_get_meta( '--fo-scnd-color' ) != null ) ? FO_get_meta( '--fo-scnd-color' ) : $default_css['--fo-scnd-color'],
		'--fo-high-color' 		=> ( FO_get_meta( '--fo-high-color' ) != null ) ? FO_get_meta( '--fo-high-color' ) : $default_css['--fo-high-color'],
		'--fo-invert-color' 	=> ( FO_get_meta( '--fo-invert-color' ) != null ) ? FO_get_meta( '--fo-invert-color' ) : $default_css['--fo-invert-color'],
		'--fo-link-color' 		=> ( FO_get_meta( '--fo-link-color' ) != null ) ? FO_get_meta( '--fo-link-color' ) : $default_css['--fo-link-color'],
		'--fo-selection-color' 	=> ( FO_get_meta( '--fo-selection-color' ) != null ) ? FO_get_meta( '--fo-selection-color' ) : $default_css['--fo-selection-color'],
		'--fo-bg-color' 		=> ( FO_get_meta( '--fo-bg-color' ) != null ) ? FO_get_meta( '--fo-bg-color' ) : $default_css['--fo-bg-color'],
		'--fo-bg2-color' 		=> ( FO_get_meta( '--fo-bg2-color' ) != null ) ? FO_get_meta( '--fo-bg2-color' ) : $default_css['--fo-bg2-color'],
		'--fo-bg3-color' 		=> ( FO_get_meta( '--fo-bg3-color' ) != null ) ? FO_get_meta( '--fo-bg3-color' ) : $default_css['--fo-bg3-color'],
		'--fo-bg4-color' 		=> ( FO_get_meta( '--fo-bg4-color' ) != null ) ? FO_get_meta( '--fo-bg4-color' ) : $default_css['--fo-bg4-color'],
		'--fo-bg5-color' 		=> ( FO_get_meta( '--fo-bg5-color' ) != null ) ? FO_get_meta( '--fo-bg5-color' ) : $default_css['--fo-bg5-color'],
		'--fo-bg6-color' 		=> ( FO_get_meta( '--fo-bg6-color' ) != null ) ? FO_get_meta( '--fo-bg6-color' ) : $default_css['--fo-bg6-color'],
		'--fo-text-color' 		=> ( FO_get_meta( '--fo-text-color' ) != null ) ? FO_get_meta( '--fo-text-color' ) : $default_css['--fo-text-color'],
		'--fo-text-color-inv' 	=> ( FO_get_meta( '--fo-text-color-inv' ) != null ) ? FO_get_meta( '--fo-text-color-inv' ) : $default_css['--fo-text-color-inv'],
		'--fo-text-shadow' 		=> ( FO_get_meta( '--fo-text-shadow' ) != null ) ? FO_get_meta( '--fo-text-shadow' ) : $default_css['--fo-text-shadow'],
		'--fo-main-border' 		=> ( FO_get_meta( '--fo-main-border' ) != null ) ? FO_get_meta( '--fo-main-border' ) : $default_css['--fo-main-border'],
		'--fo-main-tran' 		=> ( FO_get_meta( '--fo-main-tran' ) != null ) ? FO_get_meta( '--fo-main-tran' ) : $default_css['--fo-main-tran'],
		'--fo-scnd-tran' 		=> ( FO_get_meta( '--fo-scnd-tran' ) != null ) ? FO_get_meta( '--fo-scnd-tran' ) : $default_css['--fo-scnd-tran'],

		'--fo-pending' 		=> ( FO_get_meta( '--fo-pending' ) != null ) ? FO_get_meta( '--fo-pending' ) : $default_css['--fo-pending'],
		'--fo-processing' 	=> ( FO_get_meta( '--fo-processing' ) != null ) ? FO_get_meta( '--fo-processing' ) : $default_css['--fo-processing'],
		'--fo-failed' 		=> ( FO_get_meta( '--fo-failed' ) != null ) ? FO_get_meta( '--fo-failed' ) : $default_css['--fo-failed'],
		'--fo-cancelled' 	=> ( FO_get_meta( '--fo-cancelled' ) != null ) ? FO_get_meta( '--fo-cancelled' ) : $default_css['--fo-cancelled'],
		'--fo-refunded' 	=> ( FO_get_meta( '--fo-refunded' ) != null ) ? FO_get_meta( '--fo-refunded' ) : $default_css['--fo-refunded'],
		'--fo-completed' 	=> ( FO_get_meta( '--fo-completed' ) != null ) ? FO_get_meta( '--fo-completed' ) : $default_css['--fo-completed'],

		'--fo-modified' 	=> ( FO_get_meta( '--fo-modified' ) != null ) ? FO_get_meta( '--fo-modified' ) : $default_css['--fo-modified'],

		'--fo-tab-1' 	=> ( FO_get_meta( '--fo-tab-1' ) != null ) ? FO_get_meta( '--fo-tab-1' ) : $default_css['--fo-tab-1'],
		'--fo-tab-2' 	=> ( FO_get_meta( '--fo-tab-2' ) != null ) ? FO_get_meta( '--fo-tab-2' ) : $default_css['--fo-tab-2'],
		'--fo-tab-3' 	=> ( FO_get_meta( '--fo-tab-3' ) != null ) ? FO_get_meta( '--fo-tab-3' ) : $default_css['--fo-tab-3'],
		'--fo-tab-4' 	=> ( FO_get_meta( '--fo-tab-4' ) != null ) ? FO_get_meta( '--fo-tab-4' ) : $default_css['--fo-tab-4'],
		'--fo-tab-5' 	=> ( FO_get_meta( '--fo-tab-5' ) != null ) ? FO_get_meta( '--fo-tab-5' ) : $default_css['--fo-tab-5'],
		'--fo-tab-6' 	=> ( FO_get_meta( '--fo-tab-6' ) != null ) ? FO_get_meta( '--fo-tab-6' ) : $default_css['--fo-tab-6'],


		'--fo-timer-1' 	=> ( FO_get_meta( '--fo-timer-1' ) != null ) ? FO_get_meta( '--fo-timer-1' ) : $default_css['--fo-timer-1'],
		'--fo-timer-2' 	=> ( FO_get_meta( '--fo-timer-2' ) != null ) ? FO_get_meta( '--fo-timer-2' ) : $default_css['--fo-timer-2'],
		'--fo-timer-3' 	=> ( FO_get_meta( '--fo-timer-3' ) != null ) ? FO_get_meta( '--fo-timer-3' ) : $default_css['--fo-timer-3']
	);
		return $style;
}
/**
 * Fired during plugin activation.
 *
 * This function create flash order meta table, called 'flash_order_meta' in the database.
 *
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_create_meta_table( $version = FLASH_ORDER_META_VERSION ){
	update_option( 'flash_order_meta_table', FLASH_ORDER_META_VERSION );
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . "flash_order_meta";  //get the database table prefix to create my new table

    $sql = "CREATE TABLE $table_name (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      meta_key varchar(255),
      meta_value text,
      assoc_id varchar(255),
      assoc_tb varchar(255),
      PRIMARY KEY  (id),
      KEY meta_key (meta_key),
      KEY assoc_id (assoc_id),
      KEY assoc_tb (assoc_tb)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    dbDelta( $sql );

  $meta_table = get_option( 'flash_order_meta_table' );
  if ( $meta_table != $version ) {
    update_option( 'flash_order_meta_table', $version );
  }
}
/**
 * This function retrieve flash order meta_value or entire row from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_get_meta( $meta_key, $type = 'var' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  if ( $type == 'var' ) {
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM %i WHERE meta_key = %s", [ $table, $meta_key ] ) );
  } elseif ( $type == 'all' ) {
    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM %i WHERE meta_key = %s ORDER BY id", [ $table, $meta_key ] ) );
  } else {
    $result = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM %i WHERE meta_key = %s", [ $table, $meta_key ] ), $type );
  }
  return $result;
}
/**
 * This function retrieve flash order meta_value or entire results from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_get_meta_by_assoc_id( $assoc_id, $type = 'var' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  if ( $type == 'var' ) {
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM %i WHERE assoc_id = %s", [ $table, $assoc_id ]) );
  } else {
    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM %i WHERE assoc_id = %s", [ $table, $assoc_id ] ), $type );
  }
  return $result;
}
/**
 * This function retrieve flash order meta_value or entire results from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_get_meta_by_assoc_tb( $assoc_tb, $type = 'var' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  if ( $type == 'var' ) {
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM %i WHERE assoc_tb = %s", [ $table, $assoc_tb ] ) );
  } else {
    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM %i WHERE assoc_tb = %s", [ $table, $assoc_tb ] ), $type );
  }
  return $result;
}
/**
 * This function retrieve flash order meta_value or entire row from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_get_meta_by_id( $id, $type = 'var' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  if ( $type == 'var' ) {
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM %i WHERE id = %s", [ $table, $id ] ) );
  } else {
    $result = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM %i WHERE id = %s", [ $table, $id ] ), $type );
  }
  return $result;
}
/**
 * This function insert meta row in the table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_insert_meta( $meta_key, $meta_value, $assoc_id = null, $assoc_tb = null ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  $result = $wpdb->insert( $table, array( 'meta_key'=>$meta_key, 'meta_value'=>$meta_value, 'assoc_id'=>$assoc_id,'assoc_tb'=>$assoc_tb ) );
  return $result;
}
/**
 * This function update meta row in the table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_update_meta( $meta_key, $meta_value, $assoc_id = null, $assoc_tb = null ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  $meta = FO_get_meta( $meta_key );

  if ( $meta != null ) {
    $result = $wpdb->update( $table, array( 'meta_value'=>$meta_value, 'assoc_id'=>$assoc_id,'assoc_tb'=>$assoc_tb ), array( 'meta_key'=>$meta_key ) );
  } else {
    $result = $wpdb->insert( $table, array( 'meta_key'=>$meta_key, 'meta_value'=>$meta_value, 'assoc_id'=>$assoc_id,'assoc_tb'=>$assoc_tb ) );
  }
  return $result;
}
/**
 * This function delete meta row from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_delete_meta( $meta_key ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  $result = $wpdb->delete( $table, array( 'meta_key'=>$meta_key ) );
  return $result;
}
/**
 * This function delete meta row from table 'flash_order_meta'
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
function FO_delete_meta_by_id( $id ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_meta";
  $result = $wpdb->delete( $table, array( 'id'=>$id ) );
  return $result;
}

function FO_get_table_by_table_number_status_last( $table_number, $status = 0, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_number = %s AND status > %d ORDER BY last_update DESC", $table, $table_number, $status ), $type );
	return $result;
}





/**
 * Fired during plugin activation.
 *
 * This function create flash order table, called 'flash_order_table' in the database.
 *
 * @since      1.0.0
 * @package    Flash_order
 * @subpackage Flash_order/includes
 * @author     InnovazioneWeb <info@innovazioneweb.com>
 */
// FOP_create_table(FLASH_ORDER_TABLE_VERSION);
function FOP_create_table( $version = FLASH_ORDER_TABLE_VERSION ){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . "flash_order_table";

    $sql = "CREATE TABLE $table_name (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      table_number varchar(75),
      table_id varchar(75),
      start_time datetime,
      orders varchar(200),
      status varchar(75),
      prev_status varchar(75),
      end_time datetime,
      totals varchar(10),
      info text,
      receipt text,
      other varchar(255),
      last_update datetime,
      PRIMARY KEY  (id),
      KEY table_number (table_number),
      KEY orders (orders),
      KEY status (status),
      KEY prev_status (prev_status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    dbDelta( $sql );

  $meta_table = get_option( 'flash_order_table' );
  if ( $meta_table != $version ) {
    update_option( 'flash_order_table', $version );
  }
}
function FOP_get_table_by_id( $id, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  if ( $type == 'var' ) {
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT table_number FROM %i WHERE id = %s", $table, $id ) );
  } else {
    $result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE id = %s", $table, $id ), $type );
  }
  return $result;
}

function FOP_get_active_tables( $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  	$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM %i WHERE status > 0", $table ), $type );
  return $result;
}

function FOP_set_inactive_tables_from_date( $type = 'OBJECT' ){
	global $wpdb;
	$table = $wpdb->prefix . "flash_order_table";
	$now = new DateTime();
	$result = FOP_get_active_tables();
	$limit_date_expiry = intval( FO_get_meta('limit_date_expiry') ) * 3600;

	$date_to_compare = gmdate('Y-m-d H:i:s', time() - $limit_date_expiry );

// FO_debug( $limit_date_expiry );
// FO_debug( gmdate('Y-m-d H:i:s', time() - $limit_date_expiry ) );
// FO_debug( $result[0]->last_update );

	foreach ($result as $key => $value) {
		if ( $value->last_update <= $date_to_compare ) {
			// echo " string ";
			// $result = $wpdb->update( $table, array( 'status'=>'0', 'prev_status'=>$value->status, 'end_time'=>$now->format('Y-m-d H:i:s'), 'last_update'=>$now->format('Y-m-d H:i:s') ), array( 'id'=>$value->id ) );
		}
	}
	// return $result;
}
function FOP_insert_table( $args ){
  global $wpdb;
  $now = new DateTime();
  $default_args = array(
  	'table_number' 	=> 0,
  	'table_id' 		=> 0,
  	'start_time' 	=> wp_date('Y-m-d H:i:s'),
  	'orders' 		=> '',
  	'status' 		=> 1,
  	'prev_status' 	=> '',
  	'end_time' 		=> '',
  	'totals' 		=> '',
  	'info' 			=> '',
  	'receipt' 		=> '',
  	'other' 		=> '',
  	'last_update' 	=> wp_date('Y-m-d H:i:s')
  	);
  $final = wp_parse_args( $args, $default_args );
  $final['orders'] = wp_json_encode( (array)$final['orders'] );

  $table = $wpdb->prefix . "flash_order_table";
  $result = $wpdb->insert( $table, array( 'table_number'=>$final['table_number'], 'table_id'=>$final['table_id'], 'start_time'=>$final['start_time'], 'orders'=>$final['orders'], 'status'=>$final['status'], 'prev_status'=>$final['prev_status'], 'end_time'=>$final['end_time'], 'totals'=>$final['totals'], 'info'=>$final['info'], 'receipt'=>$final['receipt'], 'other'=>$final['other'], 'last_update'=>$final['last_update'] ) );
  return $result;
}
function FOP_update_table( $id, $args ){
  global $wpdb;
  	$table = $wpdb->prefix . "flash_order_table";
  	$now = new DateTime();
	$meta = FOP_get_table_by_id( $id, 'OBJECT' );
	// $default_args = array(
	// 'table_number' 	=> 0,
	// 'table_id' 		=> 0,
	// 'orders' 		=> '',
	// 'status' 		=> 1,
	// 'end_time' 		=> '',
	// 'totals' 		=> 0,
	// 'info' 			=> '',
	// 'receipt' 		=> '',
	// 'other' 		=> '',
	// 'last_update' 	=> ''
	// );
  // $final_args = wp_parse_args( $args, $default_args );
	$final = wp_parse_args( $meta, $args );
	if (isset($args['status']) ) {
		$final['status'] = $args['status'];
	}
	if ( $final['status'] == 10 ) {
		$final['end_time'] = wp_date('Y-m-d H:i:s');
	}
	$meta_order = ($meta->orders!='')?json_decode( $meta->orders ):array();
	$args_order = ($meta->orders!='')?json_decode( $args['orders'] ):array();
// FO_debug( count(array_diff( $final_args, (array)$meta )) );
	$final['orders'] = wp_json_encode( array_unique(array_merge( (array)$meta_order, (array)$args_order )) );
	// if ( count(array_diff( $args, (array)$meta )) ) {
		$result = $wpdb->update( $table, array( 
			'table_number'=> $final['table_number'], 
			'table_id'	=> $final['table_id'], 
			'orders'	=> $final['orders'], 
			'status'	=> $final['status'], 
			'prev_status'=> $meta->status, 
			'end_time'	=> $final['end_time'], 
			'totals'	=> $final['totals'], 
			'info'		=> $final['info'], 
			'receipt'	=> $final['receipt'], 
			'other'		=> $final['other'], 
			'last_update'=> wp_date('Y-m-d H:i:s') 
		), array( 'id'	=> $id ) );
	// } else{
	// 	$result = $wpdb->update( $table, array( 
	// 		'table_number'=>$final['table_number'], 
	// 		'table_id'=>$final['table_id'], 
	// 		'orders'=>$final['orders'], 
	// 		'status'=>$final['status'], 
	// 		'prev_status'=>$meta->status, 
	// 		'end_time'=>$final['end_time'], 
	// 		'totals'=>$final['totals'], 
	// 		'info'=>$final['info'], 
	// 		'receipt'=>$final['receipt'], 
	// 		'other'=>$final['other'] 
	// 	), array( 'id'=>$id ) );
	// }
  return $result;
}
function FOP_get_all_active_tables( $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  // $date = wp_date('Y-m-d H:i:s');
	$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM %i WHERE status < 10", $table ), $type );
	return $result;
}

function FOP_get_table_by_table_number_status_negative( $table_number, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_number = %s AND status > 0", $table, $table_number ), $type );
	return $result;
}
function FOP_get_table_by_table_number_status( $table_number, $status = 0, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_number = %s AND status > %d", $table, $table_number, $status ), $type );
	return $result;
}

function FOP_get_table_by_table_number_status_last( $table_number, $status = 0, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_number = %s AND status > %d ORDER BY last_update DESC", $table, $table_number, $status ), $type );
	return $result;
}

function FOP_get_table_by_table_number_end_time( $table_number, $date = '', $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  	$now = new DateTime();
	$date = ( $date == '' ) ? $now->format('Y-m-d H:i:s') : '';
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_number = %s AND end_time < %s", $table, $table_number, $date ), $type );
	return $result;
}

function FOP_update_table_from_id( $id, $args ){
  global $wpdb;
  	$table = $wpdb->prefix . "flash_order_table";
  	$meta = FOP_get_table_by_id( $id, 'OBJECT' );
  if ( $meta != null ) {
    $result = FOP_update_table( $id, $args );
  } else {
    $result = FOP_insert_table( $args );
  }
  return $result;
}
function FOP_update_table_from_table_id( $table_id, $args ){
  global $wpdb;
  	$table = $wpdb->prefix . "flash_order_table";
  	$meta = FOP_get_table_by_table_id_last( $table_id, 'OBJECT' );

  if ( $meta != null && $meta->status != 10 ) {
    $result = FOP_update_table( $meta->id, $args );
  } else {
    $result = FOP_insert_table( $args );
  }
  return $result;
}
function FOP_update_table_from_table_number_status( $table_number, $args = array() ){
  global $wpdb;
  	$table = $wpdb->prefix . "flash_order_table";
  	$meta = FOP_get_table_by_table_number_status( $table_number );
  	// FOP_debug($meta, 'meta');
  if ( $meta != null ) {
    $result = FOP_update_table( $meta->id, $args );
  } else {
    $result = FOP_insert_table( $args );
  }
  return $result;
}
function FOP_delete_table_by_id( $id ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  $result = $wpdb->delete( $table, array( 'id'=>$id ) );
  return $result;
}






 /*
function flash_orders_ajax_ordination() {
	//$order = wc_create_order();
	$user = wp_get_current_user();
	$response = array( 
		'messages' 	=> ' --- inizio ordinazione --- ',
		'_POST' 	=> $_POST
	);

	$order = new WC_Order();
	//$order = wc_create_order();
	//$order->set_status( 'Processing' );
	$address = array(
        'first_name' =>  esc_html__( 'TAVOLO', 'flash_order' ),
        'address_1'  => $_POST['table']
    );
    $order->set_address( $address, 'shipping' );

    $addressBilling = array(
	   'first_name' => $user->user_firstname,
	   'last_name' 	=> $user->user_lastname,
	   'email'      => $user->user_email,
	   'phone'      => $user->user_phone
	//   'address_1'  => $user->get_billing_address_1
	//   'address_2'  => $user->get_billing_address_2
	//   'city'       => $user->get_billing_city
	//   'state'      => $user->get_billing_state
	//   'postcode'   => $user->get_billing_postcode
	//   'country'    => $user->get_billing_country
	);

	$order->set_address( $addressBilling, 'billing' );

	$products = array();
	$asArr = explode( '|', str_replace('undefined', '', $_POST['products']) );
	foreach( $asArr as $val ){
	  $tmp = explode( ',', $val );
	  $products[ $tmp[0] ] = (int)$tmp[1];
	}
	$response['products_id'] = array_filter($products);
	//$response['product'] = wc_get_product( 28 );
	//$order->add_product( wc_get_product( 28 ), 2 );

	foreach( $products as $k => $v ){
		$order->add_product( wc_get_product( (int)$k ), (int)$v ); //(get_product with id and next is for quantity)
	}
	$order->update_meta_data( 'Table', $_POST['table'] ); // Add the custom field
	//$order->calculate_totals();
    $order->calculate_totals();
    $response['messages'] .= ' --- fine ordinazione --- ';

    $order->save();
	wp_send_json_success($response);
}
add_action('wp_ajax_flash_orders_ajax_ordination', 'flash_orders_ajax_ordination');
add_action('wp_ajax_nopriv_flash_orders_ajax_ordination', 'flash_orders_ajax_ordination');

*/

add_action( 'init', 'FO_get_category_by_slug', 999, 1 );
function FO_get_category_by_slug( $value = '' ){
    $term = get_term_by( 'slug', $value, 'category' );
    // var_dump($term);
    return $term;
}


function FO_product_to_table_loop( $object ){
	foreach ( $object as $key => $value) {
		?>
	<thead fotargetcat="<?php echo esc_attr($key);?>" onclick="jQuery(this).parent().find(`tbody tr[focategories='<?php echo esc_attr($key);?>']`).toggle();">
		<tr class="title" style="font-weight:800;font-size:30px;">
			<th style="background-color: var(--fo-main-color)!important;">
			<?php echo esc_attr($key); ?>
			<span class="dashicons dashicons-arrow-down"></span>
			</th>
		</tr>
	</thead>

	<?php 
		foreach( $value as $product ){
			FO_product_to_table( $product, $key );
		}
	}
}
function FO_product_to_table( $product, $cat_slug ){
	$id = $product->get_id();
	if ( !$product->get_parent_id() ) {
		$category = $product->get_category_ids()[0];
	} else {
		$category = wc_get_product( $product->get_parent_id() )->get_category_ids()[0];
	}
	// FO_debug( $cat_slug );
	$visualize = FO_get_flash_orders_visualize_settings();
?>
	<tr focategories="<?php echo esc_attr($cat_slug); ?>" focatid="<?php echo esc_attr($category); ?>" id="<?php echo 'prod-'.esc_attr($id); ?>" style="transition:var(--fo-main-tran);position:relative;" foid="<?php echo esc_attr($id); ?>" foname="<?php echo esc_attr($product->get_name()); ?>">
		<?php if ( isset($visualize['id']) && $visualize['id'] ) { ?>

			<td style="width:50px;"><?php echo esc_attr($product->get_id()); ?></td>
		<?php } ?>
		<?php if ( isset($visualize['name']) && $visualize['name'] ) { ?>
			<td class="target_search"> <?php echo esc_attr($product->get_name()); ?></td>
		<?php } ?>
		<?php if ( isset($visualize['image']) && $visualize['image'] ) { ?>
			<td class="fopermalink relative">
				
					<?php 
					echo wp_kses_post($product->get_image()); 
					$ware_color = ($product->get_stock_quantity()>0||$product->get_stock_quantity()=='') ? 'green' : 'red';
					$ware_text = ($product->get_stock_quantity() != '' ) ? esc_html__('Non Disponibile' , 'flash_order') : esc_html__('Disponibile' , 'flash_order'); 
					?>
				<!-- </a> -->
				<div class="fowarehouse">
					<img color="<?php echo esc_attr($ware_color);?>" src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/sphere4.webp'?>"/>
					<p><?php echo esc_attr($ware_text);?></p>
				</div>
			</td>
		<?php } ?>
		<?php if ( isset($visualize['warehouse']) && $visualize['warehouse'] ) { ?>
		<td class="foquantity"> <?php echo ($product->get_stock_quantity() != '' ) ? esc_attr($product->get_stock_quantity()) : esc_html__('Disponibile' , 'flash_order'); ?> </td>
		<?php } ?>
		<?php if ( isset($visualize['note']) && $visualize['note'] ) { ?>
		<td class="fonote"> <textarea type="text" name="<?php echo '[note]['.esc_attr($id).']';?>" style="width:calc(100% - 20px);" placeholder="<?php echo esc_html__('Note del prodotto...' , 'flash_order'); ?>"></textarea> 
			<button onclick="jQuery(this).next().slideToggle();return false;"> <?php echo esc_html__( 'MODIFICA INGREDIENTI', 'flash_order' ); ?> </button>
			<div id="FOeditIngTab" class="FOEditProdTab" style="display:none;overflow:auto;">
				<div onclick="jQuery(this).parent().slideToggle()" class="FOCloseProdTab"><?php echo esc_html__('CHIUDI','flash_order');?></div>
				<?php 
				$Ingredienti = get_the_terms($product->get_id(), 'Ingredienti');
				if ( $Ingredienti != null ) {
					foreach( $Ingredienti as $key => $value ){ ?>
						<div class="FOIngredProdTab" modified="native">
							<input type="checkbox" name="[Ingredienti][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($value->term_id);?>]" value="<?php echo esc_attr($value->name);?>" checked="checked" onclick="FOcheckIng(this)" nat-ing="<?php echo count($Ingredienti);?>" modified="native"><?php echo esc_attr($value->name); ?>
						</div>
					<?php } 
				} 
				?>
				<input type="search" name="[searched]" class="FOSearchIngred" onkeyup="FOSearchIngred(this)" placeholder="<?php echo esc_html__( 'Cerca ingredienti da aggiungere...', 'flash_order' ); ?>">
				<div class="FOIngredProdSec">
					<?php 
						$terms = get_terms( array('taxonomy'=>'Ingredienti','hide_empty'=>false) );
						foreach ($terms as $k => $v) {
							// if ( in_array( $v, $Ingredienti, true ) ) { continue; }
							 ?>
								<div id="FOselSearchIng" class="FOIngredProdTab" style="display:none;">
									<input type="checkbox" name="[Ingredienti][<?php echo esc_attr($product->get_id());?>][<?php echo  esc_attr($v->term_id);?>]" value="<?php echo esc_attr($v->name);?>" onclick="FOaddIng(this)" modified="modified"><?php echo esc_attr($v->name); ?>
								</div>
							<?php
						}
					?>
				</div>
			</div>
		</td>
		<?php } ?>
		<?php if ( isset($visualize['actions']) && $visualize['actions'] ) { ?>
		<td class="foquantity"><div class="prod_input">
				<div class="spinner-button" onclick="jQuery(this).next().val(parseInt(jQuery(this).next().val()) - 1)">-</div>
				<input class="prod_input" type="number"name="[<?php echo esc_attr($id);?>]"value="1"min="1"style="width:30px;">
				<div class="spinner-button" onclick="jQuery(this).prev().val(parseInt(jQuery(this).prev().val()) + 1)">+</div>
			</div>
			<button class="FOAddBut" onclick="FO_Add_Item_to_Order(this);return false;"> <?php echo esc_html__( 'AGGIUNGI', 'flash_order' ); ?> </button>
		</td>
		<?php } ?>

	</tr>
	
	<?php
}
function FO_products_for_div_loop( $object ){
	foreach ( $object as $key => $value) {
		$term = get_term_by('name', $key, 'product_cat');
		$term_meta = (FOcheck($term))? get_term_meta($term->term_id):false;
		$image = ( isset($term_meta['thumbnail_id']) )? wp_get_attachment_image_src($term_meta['thumbnail_id'][0] ):array('0');
		$style = ( !FOcheck($image[0]) )? 'display:none;':'';
		?>
	<div class="focathead" id="<?php echo esc_attr($key);?>" fotargetcat="<?php echo esc_attr($key);?>" style="background-color: var(--fo-main-color)!important;">
		<div class="title" style="font-weight:800;font-size:30px;z-index:10;">
			<?php echo esc_attr($key); ?>
		</div>
		<input type="search" fotargetcat="<?php echo esc_attr($key);?>" onkeyup="FO_refine_search(this)" class="focatsearch" placeholder="<?php esc_html_e('Cerca...','flash_order');?>" style="z-index:10;">
		<span class="focatnumber" style="z-index:10;"><?php echo count($value);?></span>
		<img src="<?php echo esc_attr($image[0]) ?>" style="<?php echo esc_attr($style);?>">
	</div>

	<?php 
	// FO_debug(count($value));
		foreach( $value as $product ){
			FO_product_to_div_loop( $product, $key );
		}
	}
}
function FO_product_to_div_loop( $product, $cat_slug ){
	$id = $product->get_id();
	$role = FO_access_autorization();
	if ( !$product->get_parent_id() ) {
		$category = $product->get_category_ids()[0];
	} else {
		$category = wc_get_product( $product->get_parent_id() )->get_category_ids()[0];
	}
	$ware_color = ($product->get_stock_quantity()>0||$product->get_stock_quantity()=='') ? 'green' : 'red';
	$ware_text = ($product->get_stock_quantity()>0||$product->get_stock_quantity()=='') ? esc_html__('Disponibile' , 'flash_order') : esc_html__('Non Disponibile' , 'flash_order'); 
	$fo_ware = ($product->get_stock_quantity()>0||$product->get_stock_quantity()=='') ? '1' : '0';

	$variations = $product->get_children();
// FOcheck($variations);
	// FO_debug( FOcheck($variations) );
	if ( FOcheck($variations) ) {
		foreach ($variations as $key => $value) {
			$prod_vari = wc_get_product( $value );
		}
	}
	$vari_arr = ( FOcheck($variations) ) ? wp_json_encode($variations) : '';
	$Ingredienti = get_the_terms($product->get_id(), 'Ingredienti');
	$count_ing = (is_array($Ingredienti))? count($Ingredienti): 0;

	$meta_data = get_post_meta( $product->get_id() );
	$Sticker = get_the_terms($product->get_id(), 'Sticker');
	$sticker = (isset($meta_data['sticker']) && $meta_data['sticker'] != null ) ? $meta_data['sticker'] : array();
	$sticker = ( $Sticker ) ? $Sticker : $sticker;
?>
	<div class="foProdCard" foware="<?php echo esc_attr($fo_ware);?>" focategories="<?php echo esc_attr($cat_slug);?>" focatid="<?php echo esc_attr($category);?>" id="<?php echo 'prod-'.esc_attr($id);?>" style="transition:var(--fo-main-tran);position:relative;" foid="<?php echo esc_attr($id);?>" foname="<?php echo esc_attr($product->get_name());?>" fovariations="<?php echo esc_attr($vari_arr);?>" nat-ing="<?php echo esc_attr($count_ing);?>">
		<input type="hidden" name="[id][<?php echo esc_attr($id);?>]" value="1">
		<div class="foProdCardHead">
			<?php echo wp_kses_post($product->get_image(array( 340, 340 ), array( 'foprod'=>'foprod', 'onclick'=>'FO_Advanced_Prod_Card(this)' ))); ?>
			<div class="foname target_search" onclick="FO_Advanced_Prod_Card(this)"><?php echo esc_attr($product->get_name());?></div>
			<?php 
				// FO_get_product_temperature_options($product);
			?>
			<span class="dashicons dashicons-heart"></span>

		<?php if ( $role ) { ?>
			<img class="gear" color="" style="right:-10px"src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/gear.webp'?>" onclick="jQuery(this).parent().parent().find('.fo_flash_ing').slideToggle();return false;"/>
			<div id="FOeditIngTab" class="FOEditProdTab fo_ajax_edit_tab fo_flash_ing" style="display:none;overflow:auto;">
				<div onclick="jQuery(this).parent().slideToggle()" class="FOCloseProdTab fo_ajax_edit_tab_close"><?php echo esc_html__('CHIUDI','flash_order');?></div>
				<?php 
				// $Ingredienti = get_the_terms($product->get_id(), 'Ingredienti');
				if ( $Ingredienti != null ) {
					foreach( $Ingredienti as $key => $value ){ 
						$tax_img = get_term_meta($value->term_id, 'taxonomy_image');
						?>
						<div class="FOIngredProdTab">
							<input type="checkbox" name="[Ingredienti][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($value->term_id);?>]" value="<?php echo esc_attr($value->name);?>" checked="checked" onclick="FOcheckIfModified(this)" nat-ing="<?php echo count($Ingredienti);?>" modified="native">
							<?php  
							if ( isset($tax_img[0]) && FOcheck($tax_img[0]) ) { ?>
								<img class="fotax_image" src="<?php echo esc_attr($tax_img[0]);?>">
							<?php } ?>
							<p class="fo_ing_text"><?php echo esc_attr($value->name); ?></p>
							
						</div>
					<?php }
					}
				?>
				<input type="search" name="searched" class="FOSearchIngred fo_ajax_search_ing" onkeyup="FOSearchIngred(this)" placeholder="<?php echo esc_html__( 'Cerca ingredienti da aggiungere...', 'flash_order' ); ?>">
				<div class="FOIngredProdSec fo_ajax_ing_sect">
					<?php 
						$terms = get_terms( array('taxonomy'=>'Ingredienti','hide_empty'=>false) );
						// FO_debug($terms);
						foreach ($terms as $k => $v) {
							$tax_img = get_term_meta($v->term_id, 'taxonomy_image');
							 ?>
								<div id="FOselSearchIng" class="FOIngredProdTab" style="display:none;">
								<?php if ( $tax_img != null && FOcheck($tax_img[0]) ) { ?>
									<img class="fotax_image" width="30" height="30" src="<?php echo esc_attr($tax_img[0]);?>">
								<?php } ?>
									<p class="fo_ing_text"><?php echo esc_attr($v->name); ?></p>
									<input type="checkbox" name="[Ingredienti][<?php echo esc_attr($product->get_id());?>][<?php echo  esc_attr($v->term_id);?>]" value="<?php echo esc_attr($v->name);?>" onclick="FOaddIng(this);FOcheckCardModified(this)" modified="modified">
								</div>
							<?php
						}
					?>
				</div>
				<div class="foRole"> 
				<textarea type="text" name="<?php echo '[note]['.esc_attr($id).']';?>" placeholder="<?php esc_html_e('Note del prodotto...','flash_order');?>" style="height:100%;"></textarea> 
				</div>
			</div>
		<?php } ?>

			<div id="FOeditIngTab" class="FOEditProdTab fo_ajax_edit_tab fovariation_card" style="display:none;overflow:auto;">
				<div onclick="jQuery(this).parent().slideToggle()" class="FOCloseProdTab fo_ajax_edit_tab_close"><?php echo esc_html__('CHIUDI','flash_order');?></div>
				<?php 
					if ( !empty( $product->get_children() ) ) {
						?><div class="fovariantcont"><?php esc_html_e('Seleziona la variante: ','flash_order');?><?php 
							$product_attr = $product->get_attributes();
							foreach ($product_attr as $k => $v) {
								$attr = explode( ' | ', $product->get_attribute( $k ) );
								?><div class="fovariant" fovariant="<?php echo esc_attr($k);?>" ><?php 
								echo esc_attr($k);
									?>
									<input type="hidden" name="[Variante][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($k);?>]" founivariant="<?php echo esc_attr($k);?>">
									<select onchange="FO_variant_set(this);" founivariant="<?php echo esc_attr($k);?>">
										<option value=""><?php esc_html_e( '- seleziona -', 'flash_order' );?></option>
										<?php 
									foreach ($attr as $key => $opt) {
										?><option value="<?php echo esc_attr($opt);?>"><?php echo esc_attr($opt);?></option><?php 
									}
								?></select></div><?php 
							}
						?></div><?php 
					}
				?>
				<div class="foadd foaddfix" onclick="FO_ajax_selectVarAfter_Add_Item_to_Order(this);" style=""> +
				</div>
			</div>


<div class="fovariantag_container" onclick="FO_Advanced_Prod_Card(this)">
	<?php /*
	$product_attr = (isset($product_attr))? $product_attr: $product->get_attributes();
	foreach ($product_attr as $k => $v) {
		$attr = explode( ' | ', $product->get_attribute( $k ) );
		foreach ($attr as $key => $opt) {
			?>
			<div style="display:none;" founivariant="<?php echo esc_attr($k);?>" founitag="<?php echo esc_attr($opt);?>">
				<p class="fotype"><?php echo esc_attr($k);?></p>
				<p class="fovari"><?php echo esc_attr($opt);?></p>
			</div>
		<?php } ?>
	<?php } */ ?>
</div>

<div class="fosticker">
	<?php foreach ($sticker as $key => $value) { ?>
		<?php if ( $value == 'fo-vegan' ) { ?>
			<div>
				<p style="display:none;" onclick="jQuery(this).toggle()"><?php esc_html_e('VEGANO','flash_order');?></p>
				<img width="50"height="50"src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/vegan.webp'?>" onclick="jQuery(this).prev().toggle()">
			</div>
		<?php } ?>
		<?php if ( $value == 'fo-veget' ) { ?>
			<div>
				<p style="display:none;" onclick="jQuery(this).toggle()"><?php esc_html_e('VEGETARIANO','flash_order');?></p>
				<img width="50"height="50"src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/veget.webp'?>" onclick="jQuery(this).prev().toggle()">
			</div>
		<?php } ?>
		<?php if ( $value == 'fo-bio' ) { ?>
			<div>
				<p style="display:none;" onclick="jQuery(this).toggle()"><?php esc_html_e('BIOLOGICO','flash_order');?></p>
				<img width="50"height="50"src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/bio.webp'?>" onclick="jQuery(this).prev().toggle()">
			</div>
		<?php } ?>
		<?php if ( $value == 'fo-spicy' ) { ?>
			<div>
				<p style="display:none;" onclick="jQuery(this).toggle()"><?php esc_html_e('PICCANTE','flash_order');?></p>
				<img width="50"height="50"src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/spicy.webp'?>" onclick="jQuery(this).prev().toggle()">
			</div>
		<?php } ?>

		<?php if ($value !='fo-vegan'&&$value!='fo-veget'&&$value!='fo-bio'&&$value!='fo-spicy') { 
			if ( !is_object($value) ) { continue; }
			$sticker_img = get_term_meta($value->term_id, 'taxonomy_image');
			?>
			<div>
				<p style="display:none;" onclick="jQuery(this).toggle()" title="<?php echo esc_attr($value->description);?>"><?php echo esc_attr($value->name);?></p>
				<img width="50"height="50"src="<?php echo esc_attr($sticker_img[0]);?>" onclick="jQuery(this).prev().toggle()">
			</div>
		<?php } ?>
	<?php } ?>
</div>
<!-- clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%); -->

			<div class="fowarehouse">
				<img color="<?php echo esc_attr($ware_color);?>" src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/sphere4.webp'?>"/>
				<p><?php echo esc_attr($ware_text);?></p>
			</div>
			<?php if (FOcheck($variations)) {?>
				<div class="foadd" onclick="FO_Advanced_Prod_Card(this)"> +
					<input type="hidden" name="[<?php echo esc_attr($id);?>]" value="1">
				</div>
			<?php } else{ ?>
				<div class="foadd" onclick="FO_ajax_selectVarBefore_Add_Item_to_Order(this);"> +
					<input type="hidden" name="[<?php echo esc_attr($id);?>]" value="1">
				</div>
			<?php } ?>
		</div>

		<div class="Advanced_Card" style="display:none;">
			<div class="Advanced_Card_Close" onclick="FO_Advanced_Prod_Card_hide(jQuery(this))" style="padding: 5px;">
				<span class="dashicons dashicons-no" style="font-size:40px;display:contents;"></span>
			</div>
			<div class="Advanced_Card_header">
				<div class="fowarehouse fixware" style="top:-10px;max-width:230px;">
					<!-- <p><?php echo esc_attr($ware_text);?></p> -->
					<img color="<?php echo esc_attr($ware_color);?>" src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/sphere4.webp'?>"/>
				</div>
				<p style="width:80px;">#<?php echo esc_attr($product->get_id());?></p>
				<p style="max-width:calc(100% - 250px);"><?php echo esc_attr($product->get_name());?></p>
				<?php if ( $product->get_sku() != '' ) { ?>
					<p style="width:80px;">SKU: <?php echo esc_attr($product->get_sku());?></p>
				<?php } ?>
				
				<div class="Advanced_Card_Close fo_close"onclick="FO_Advanced_Prod_Card_hide(jQuery(this).parent())"><?php esc_html_e('CHIUDI','flash_order');?></div>
			</div>

			<div class="Advanced_Card_gallery">
			<?php 
				echo wp_kses_post($product->get_image(array( 300, 300 ), array( 'foprod'=>'gallery' )));

				if ( !empty($product->get_gallery_image_ids()) ) {
					foreach ($product->get_gallery_image_ids() as $key => $value) {
						echo wp_get_attachment_image( $value, array(300, 300), false, array('foprod'=>'gallery') );
					}
				}
			?>
			</div>
			<div class="Advanced_Card_column">
				<div class="focol">
					<?php echo esc_attr($product->get_description()); ?>
				</div>

				<div class="focol">
	<?php
	$product_cat = get_the_terms($product->get_id(),'product_cat');
		if ( !empty( $product_cat ) ) {
		?><span class="fo_adv_tax"><strong><?php esc_html_e('Category:','flash_order');?></strong></span><?php
			echo wp_kses_post(FO_get_tax_cloud( $product_cat ));
		}
	$product_tag = get_the_terms($product->get_id(),'product_tag');
		if ( !empty( $product_tag ) ) {
			?><span class="fo_adv_tax"><strong><?php esc_html_e('Tag:','flash_order');?></strong></span><?php
			echo wp_kses_post(FO_get_tax_cloud( $product_tag ));
		}
	$Ingredienti = get_the_terms($product->get_id(),'Ingredienti');
	// FO_debug($Ingredienti);
		if ( !empty( $Ingredienti ) ) {
			?><span class="fo_adv_tax"><strong><?php esc_html_e('Ingredienti:','flash_order');?></strong></span><?php
			echo wp_kses_post(FO_get_tax_cloud( $Ingredienti, $product->get_id() ));
		}
	$Allergeni = get_the_terms($product->get_id(),'Allergeni');
		if ( !empty( $Allergeni ) ) {
			?><span class="fo_adv_tax"><strong><?php esc_html_e('Allergeni:','flash_order');?></strong></span><?php
			echo wp_kses_post(FO_get_tax_cloud( $Allergeni ));
		}
	?>
				</div>
			</div>

			<div class="Advanced_Card_footer">
				<p class="fo_adv_tot"><?php
				FOecho(number_format(floatval($product->get_price()), 2, '.', ',').get_woocommerce_currency_symbol());?></p>

				<?php if ( !empty( $product->get_children() ) ) { ?>
						<div class="fovariantcont">
							<?php esc_html_e('Seleziona la variante: ','flash_order');

								$product_attr = $product->get_attributes();
								foreach ($product_attr as $k => $v) {
									if (str_contains($k, 'pa_')) {
										$k = str_replace('pa_', '', $k);
										$attr = explode( ', ', $product->get_attribute( $k ) );
										$attr_term = 'pa_'.$k;
									} else{
										$attr_term = false;
										$attr = explode( ' | ', $product->get_attribute( $k ) );
									}
									?>
									<div class="fovariant" fovariant="<?php echo esc_attr($k);?>">
										<strong><?php echo esc_attr($k);?></strong>

										<select class="fo_button_thin" foadvariant="<?php echo esc_attr($k);?>" fo_prod_id="<?php echo esc_attr($product->get_id());?>" fo_price="<?php echo esc_attr($product->get_price());?>" onchange="FO_variant_set(this);">

											<?php foreach ($attr as $key => $opt) { 
												$price_to_add = '0.0';
												if ( taxonomy_exists( $attr_term ) ) {
													$price_to_add = get_string_between(get_term_by('name', $opt, $attr_term )->description,'[',']');
												}
												?>
												<option name="[Variante][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($k);?>]" type="radio" value="<?php echo esc_attr($opt);?>" fovariant="<?php echo esc_attr($k);?>" fo_price_to_add="<?php echo esc_attr($price_to_add);?>"><?php echo esc_attr($opt);?></option>
											<?php } ?>
										</select>
									</div>
								<?php } ?>
						</div><?php 
					}
				?>
				<div class="foadd" style="scale:0.8;bottom:25px;right:-10px;" onclick="FO_Advanced_Prod_Card_hide_all();FO_ajax_selectVarAfter_Add_Item_to_Order(this);"> +
				</div>

			</div>
		</div>
		<div class="Advanced_Card_background" style="display:none;"></div>

		<div class="foProdCardFoot">
		<?php if ( $role ) { ?>
			<!--  -->
		<?php } ?>
		</div>
	</div>
	<?php
}


function FO_list_view_selector(){
	?>
	<div class="focathead FO_list_view_selector">
		<select onchange="jQuery('.foProdCard').attr('foview',jQuery(this).val())" foview="normal">
			<option value="list">
				<span class="dashicons dashicons-list-view"> List View </span>
			</option>
			<option value="small">
				<span class="dashicons dashicons-grid-view"> Small View </span>
			</option>
			<option value="normal" selected>
				<span class="dashicons dashicons-format-image"> Normal View </span>
			</option>
		</select>
	</div>
	<?php
}






function FO_get_tax_cloud( $terms = array(), $product_id = '', $check = 'checked'  ){
	$role = FO_access_autorization();
	foreach ($terms as $key=>$value) {
		$tax_img = get_term_meta($value->term_id, 'taxonomy_image'); ?>
		<div class="FOAdvIngredProdTab">
			<p><?php echo esc_attr($value->name);?></p>
			<?php if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) { ?>
				<img class="fotax_image"width="30"height="30"src="<?php echo esc_attr($tax_img[0]);?>">
			<?php } 
			if ( $role && $product_id != '' && false ) { ?>
				<input type="checkbox"name="[Ingredienti][<?php echo esc_attr($product_id);?>][<?php echo esc_attr($value->term_id);?>]" value="<?php echo esc_attr($value->name);?>" onclick="FOcheckIfModified(this);FOadvToRegularFit(this);" modified="modified" <?php echo esc_attr($check);?>>
			<?php } ?>
		</div>
		<?php
	}
}
function FO_get_tax_cloud_ajax( $terms = array(), $product_id = '', $check = 'checked' ){
	$return = ''; $role = FO_access_autorization();
	foreach ($terms as $key=>$value) {
		// if (is_int($value)) { $value = get_term( $value, $taxonomy ); }
		$tax_img = get_term_meta($value->term_id, 'taxonomy_image'); 
		$return .= '<div class="FOAdvIngredProdTab">';
			$return .= '<p>'.esc_attr($value->name).'</p>';
			if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
				$return .= '<img class="fotax_image"width="30"height="30"src="'.esc_attr($tax_img[0]).'">';
			}
			if ( $role && $product_id != '' ) {
				$return .= '<input type="checkbox"name="[Ingredienti]['.esc_attr($product_id).']['.esc_attr($value->term_id).']" value="'.esc_attr($value->name).'" modified="modified" '.esc_attr($check).'>';
			}
		$return .= '</div>';
	}
	return $return;
}

function FO_get_tax_cloud_from_id_ajax( $terms = array(), $taxonomy = '', $product_id = '', $check = 'checked' ){
	$return = ''; $role = FO_access_autorization();
	foreach ($terms as $key=>$value) {
		$value = get_term( $value, $taxonomy );
		$tax_img = get_term_meta($value->term_id, 'taxonomy_image'); 
		$return .= '<div class="FOAdvIngredProdTab">';
			$return .= '<p>'.esc_attr($value->name).'</p>';
			if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
				$return .= '<img class="fotax_image"width="30"height="30"src="'.esc_attr($tax_img[0]).'">';
			}
			if ( $role && $product_id != '' ) {
				$return .= '<input type="checkbox"name="[Ingredienti]['.esc_attr($product_id).']['.esc_attr($value->term_id).']" value="'.esc_attr($value->name).'" modified="modified" '.esc_attr($check).'>';
			}
		$return .= '</div>';
	}
	return $return;
}
function FO_get_product_temperature_options( $product ){
	if ( FO_get_meta('product_temperature_tax') == 'yes') {
		$Temperature = get_the_terms($product->get_id(), 'Temperature');
		// $terms = get_terms( array('taxonomy'=>'Temperature','hide_empty'=>false) );
		if ( $Temperature != null ) {
	?>
		<div class="fothermo foboxclick">
			<img color="" width="50" height="50" class="FOthermometer" src="<?php echo esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/thermometer2.webp'?>" onclick="jQuery(this).parent().parent().find('.fotemp_card').slideToggle();"/>
				<img class="fotax_image_temp" width="30" height="30" src="" onclick="jQuery(this).parent().parent().find('.fotemp_card').slideToggle();" style="display:none;">
		</div>

		<div id="FOeditIngTab" class="FOEditProdTab fo_ajax_edit_tab fotemp_card" style="display:none;overflow:auto;">
			<div onclick="jQuery(this).parent().slideToggle()" class="FOCloseProdTab fo_ajax_edit_tab_close"><?php echo esc_html__('CHIUDI','flash_order');?></div>
	<!-- <div class="fobox FOeditTemp FOIngredProdTab" style="display:none;"> -->
			<p><?php esc_html_e( 'Che temperatura gradisci? ', 'flash_order' ); ?></p>
			<input type="hidden" name="[Temperature][<?php echo esc_attr($product->get_id());?>]">
			<select onchange="FO_Show_temp(this)">
				<option color="" value=""><?php esc_html_e( '-scegli-', 'flash_order' ); ?></option>
			<?php foreach ($Temperature as $k => $v) { ?>
				<?php $tax_img = get_term_meta($v->term_id, 'taxonomy_image');
				$color = 'white';
				$color = ( str_contains( substr($tax_img[0], strrpos($tax_img[0], '/', 0) ), 'hot' ) )? 'red': $color;
				$color = ( str_contains( substr($tax_img[0], strrpos($tax_img[0], '/', 0) ), 'cold' ) )? 'blue': $color;
				?>
				<option img="<?php echo esc_attr($tax_img[0]);?>" color="<?php echo esc_attr($color);?>" value="<?php echo esc_attr($v->name);?>">
					<?php echo esc_attr($v->name);?>
				</option>
			<?php } ?>
			</select>
		</div>
<?php
		} 
	}
}
function FO_get_products_for_loop( $args = array() ){
	$object = array();
	// $final_products = array();
	// $products = array();
	// $default_args = array(
	//     'status'            => 'publish', // array( 'draft', 'pending', 'private', 'publish' )
	//     // 'category'          => get_term($category_id, 'product_cat')->slug,
	//     'tag'               => array(),
	//     'limit'             => -1,  // -1 for unlimited
	//     'offset'            => null,
	//     'page'              => 1,
	//     'include'           => array(),
	//     'exclude'           => array(),
	//     'orderby'           => 'menu_order',
	//     'taxonomy'			=> 'product_cat',
	//     'order'             => 'DESC',
	//     'return'            => 'objects',
	//     'paginate'          => false,
	//     'shipping_class'    => array()
	// );
	// $args = wp_parse_args( $args, $default_args );
// $products = wc_get_products( $args );
	// $cat_args = array(
	//    'number'     => false,
	//    'include' => 'all',
	//    'hide_empty' => true, //can be 1, '1' too
	//    'orderby'   => 'title',
	//    'order'     => 'ASC',
	// );
	// $products_categories = get_terms( 'product_cat', $cat_args );

	$products_categories = new WP_Term_Query( array(
		'taxonomy'	=> 'product_cat',
		'include' 	=> 'all',
		'hide_empty' => true, //can be 1, '1' too
		'orderby'   => 'title',
		'order'     => 'ASC',
	) );
	// if ( $products_categories ){
	if ( count($products_categories->terms) > 0 ){
		foreach ( $products_categories->terms as $products_category ) {
			$temp_args = array(
				'category' 			=> $products_category->slug,
				'status'            => 'publish',
				'orderby' 			=> 'title',
				'order'             => 'DESC',
				'limit'             => -1,  // -1 for unlimited
			    'offset'            => null,
			    'page'              => 1,
			    'return'            => 'objects',
	    		'paginate'          => false,
			);
			$args = wp_parse_args( $temp_args, $args );
			$temp_products = wc_get_products( $args );
			if ( count($temp_products) > 0 ) {
				$object[$products_category->slug] = $temp_products;
			}
		}
	}
	return $object;
}

function FO_get_products_macro_for_loop( $args = array() ){
	$object = array();
	$final_products = array();
	$products = array();
	$default_args = array(
	    'status'            => 'publish', // array( 'draft', 'pending', 'private', 'publish' )
	    // 'category'          => get_term($category_id, 'product_cat')->slug,
	    'tag'               => array(),
	    'limit'             => -1,  // -1 for unlimited
	    'offset'            => null,
	    'page'              => 1,
	    'include'           => array(),
	    'exclude'           => array(),
	    'orderby'           => 'menu_order',
	    'taxonomy'			=> 'product_cat',
	    'order'             => 'DESC',
	    'return'            => 'objects',
	    'paginate'          => false,
	    'shipping_class'    => array()
	);
	$args = wp_parse_args( $args, $default_args );
// $products = wc_get_products( $args );
	// $macro_cat_args = array(
	//    'number'     => false,
	//    'include' => 'all',
	//    'hide_empty' => true, //can be 1, '1' too
	//    'orderby'   => 'title',
	//    'order'     => 'ASC',
	// );
	// $products_macro_categories = get_terms( 'macro_categories', $macro_cat_args );

	$products_macro_categories = new WP_Term_Query( array(
		'taxonomy'	=> 'macro_categories',
		'include' 	=> 'all',
		'hide_empty' => true, //can be 1, '1' too
		'orderby'   => 'title',
		'order'     => 'ASC',
	) );

	// $cat_args = array(
	//    'number'     => false,
	//    'include' => 'all',
	//    'hide_empty' => true, //can be 1, '1' too
	//    'orderby'   => 'title',
	//    'order'     => 'ASC',
	// );
	// $products_categories = get_terms( 'product_cat', $cat_args );

	$products_categories = new WP_Term_Query( array(
		'taxonomy'	=> 'product_cat',
		'include' 	=> 'all',
		'hide_empty' => true, //can be 1, '1' too
		'orderby'   => 'title',
		'order'     => 'ASC',
	) );
// FO_debug($products_categories);
	if ( count($products_categories->terms) > 0 ){
		foreach ($products_macro_categories->terms as $key => $value) {
			foreach ( $products_categories->terms as $products_category ) {
				$temp_args = array(
					'category' 			=> $products_category->slug,
					'status'            => 'publish',
					'orderby' 			=> 'title',
					'order'             => 'DESC',
					'limit'             => -1,  // -1 for unlimited
				    'offset'            => null,
				    'page'              => 1,
				    'return'            => 'objects',
		    		'paginate'          => false,
				);
				$temp_products = wc_get_products( $temp_args );
				if ( count($temp_products) > 0 ) {
					$object[$value->slug][$products_category->slug] = $temp_products;
				}
			}
		}
	}
	return $object;
}

function flash_orders_ordination() {
	//global $woocommerce, $post;
	// $flash_order_front_name = ( FO_get_meta('flash_order_front_name' ) != '' ) ? FO_get_meta('flash_order_front_name') : esc_html__('TAVOLO','flash_order');
	// $_POST = FO_recursive_sanitize_text_field($_POST);
	if ( !isset($_POST['_fononce_front_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_fononce_front_order'])), 'FO_front_order' ) ) {
		return;
	}
	$user = wp_get_current_user();
	$order = new WC_Order();
	
	$table_name_cpt = ( isset($_POST['table_name_cpt']) ) ? sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) : esc_html__('Tavolo','flash_order');
	$address = array(
	    'address_1' => $table_name_cpt,
	    'address_2'  => (isset($_POST['table_name']))?sanitize_text_field(wp_unslash($_POST['table_name'])):'',
	    'company'  => (isset($_POST['table_surname']))?sanitize_text_field(wp_unslash($_POST['table_surname'])):''
	);
	$order->set_address( $address, 'shipping' );
	$addressBilling = array(
		'first_name' 	=> $user->user_firstname,
		'last_name' 	=> $user->user_lastname,
		'email'      	=> $user->user_email,
		'phone'      	=> $user->user_phone,
		// 'address_1'  	=> $user->get_billing_address_1(),
		// 'address_2'  	=> $user->get_billing_address_2(),
		// 'city'       	=> $user->get_billing_city(),
		// 'state'      	=> $user->get_billing_state(),
		// 'postcode'   	=> $user->get_billing_postcode(),
		// 'country'    	=> $user->get_billing_country()
	);
	$order->set_address( $addressBilling, 'billing' );
	// $products = array();
	$i = 0;
	// FO_debug( $_POST );
foreach ($_POST['foindex'] as $K => $E) {//phpcs:ignore

	$order->update_meta_data( '{'.$K.'}info-', wp_json_encode( $E ) );

	foreach ( $E as $pos => $item) {
		if ( is_numeric($pos) ) { 
			$order->update_meta_data( '{'.$K.'}index-'.$pos, $item );
			$order->add_product( wc_get_product( $pos ), $item );
		} $i++;
	}
	if (isset($E['note'])) {
		$order->update_meta_data( '{'.$K.'}prod-'.sanitize_text_field(key($E['note'])).'_note-', sanitize_text_field( array_values( $E['note'] )[0] ) );
	}
	if (isset($E['Ingredienti'])) {
		foreach ( $E['Ingredienti'] as $index => $element) {
			foreach( $element as $ing_key => $ing_val ){
				$order->update_meta_data( '{'.$K.'}prod-'.$index.'_ingredient-'.$ing_key, $ing_key.' | '.$ing_val );
			}
		}
	}
	if (isset($E['Variante'])) {
		foreach ( $E['Variante'] as $index => $element) {
			foreach( $element as $var_key => $var_val ){
				$order->update_meta_data( '{'.$K.'}prod-'.$index.'_variant-'.$var_key, $var_key.' | '.$var_val );
			}
		}
	}
	if (isset($E['Temperature'])) {
		foreach ( $E['Temperature'] as $index => $element) {
			$order->update_meta_data( '{'.$K.'}prod-'.$index.'_temperature-'.$index, $index.' | '.$element );
		}
	}
}
	// foreach ($products as $k => $v) {
	  // $order->update_meta_data( 'Product-'.$k, $v );
	  // $order->add_product( wc_get_product( $k ), $v );
	// }

	if (isset($_POST['table_name_cpt'])) {
		$order->update_meta_data( 'Table_cpt', sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) );
	}
	if (isset($_POST['table_name'])) {
		$order->update_meta_data( 'Table', sanitize_text_field(wp_unslash($_POST['table_name'])) );
	}
	if (isset($_POST['order_note'])) {
		$order->update_meta_data( 'order_note', sanitize_text_field(wp_unslash($_POST['order_note'])) );
		$order->add_order_note( sanitize_text_field(wp_unslash($_POST['order_note'])) );
	}
	if (isset($_POST['table_surname'])) {
		$order->update_meta_data( 'table_surname', sanitize_text_field(wp_unslash($_POST['table_surname'])) );
	}
	
	$order->update_meta_data( 'delivery_type', 'table' );

	FO_update_meta( 'last_woocommerce_order', wp_json_encode( $order ) );
	// FO_update_meta( 'last_woocommerce_order_products', wp_json_encode( $products ) );

	$order->set_payment_method('cod');//set_prop( 'payment_method', 'cod' );


	$order->set_created_via( 'FO page' );

	$order->calculate_totals();

	$order->save();

	$table = $order->id;
	do_action( 'fo_front_flash_order', $table );
}






function FO_submit_order_ajax() {
	// $_POST = FO_recursive_sanitize_text_field($_POST);
	if (!isset($_POST['_fononce_front_order_ajax']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce_front_order_ajax'])), 'FO_front_order_ajax' ) ) {
		return;
	}
	$user = wp_get_current_user();
	$order = new WC_Order();
	$table_name_cpt = ( isset($_POST['table_name_cpt']) ) ? sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) : esc_html__('Tavolo','flash_order');
	$address = array(
	    'address_1' => $table_name_cpt,
	    'address_2'  => (isset($_POST['table_name']))?sanitize_text_field(wp_unslash($_POST['table_name'])):'',
	    'company'  => (isset($_POST['table_surname']))?sanitize_text_field(wp_unslash($_POST['table_surname'])):''
	);
	$order->set_address( $address, 'shipping' );
	$addressBilling = array(
		'first_name' 	=> $user->user_firstname,
		'last_name' 	=> $user->user_lastname,
		'email'      	=> $user->user_email,
		'phone'      	=> $user->user_phone,
		// 'address_1'  	=> $user->get_billing_address_1(),
		// 'address_2'  	=> $user->get_billing_address_2(),
		// 'city'       	=> $user->get_billing_city(),
		// 'state'      	=> $user->get_billing_state(),
		// 'postcode'   	=> $user->get_billing_postcode(),
		// 'country'    	=> $user->get_billing_country()
	);
	$order->set_address( $addressBilling, 'billing' );
$info_string = array();

if (isset($_POST['foserialmap'])) {
	foreach ($_POST['foserialmap'] as $K => $E) {//phpcs:ignore
		foreach ( $E as $pos => $item) {
			if ( isset($item['id']) ) { 
				$order->update_meta_data( '{'.substr($pos,1).'}index-'.sanitize_text_field(wp_unslash(key($item['id']))), sanitize_text_field(wp_unslash( array_values( $item['id'] )[0] )) );
				$product = wc_get_product(sanitize_text_field(wp_unslash(key($item['id']))));
				$order->add_product( $product, sanitize_text_field(wp_unslash( array_values( $item['id'] )[0] )) );
				$info_string[sanitize_text_field(wp_unslash(key($item['id'])))] = sanitize_text_field(wp_unslash(array_values($item['id'])[0]));
			}
			if (isset($item['note'])) {
				$order->update_meta_data( '{'.substr($pos,1).'}prod-'.sanitize_text_field(wp_unslash(key($item['note']))).'_note-', sanitize_text_field(wp_unslash( array_values( $item['note'] )[0] )) );
				$info_string['note'][sanitize_text_field(wp_unslash(key($item['note'])))] = sanitize_text_field(wp_unslash(array_values($item['note'])[0]));
			}
			if (isset($item['Ingredienti'])) {
				foreach ( $item['Ingredienti'] as $index => $element) {
					foreach( $element as $ing_key => $ing_val ){
						$info_string['Ingredienti'][$index][$ing_key] = $ing_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_ingredient-'.$ing_key, $ing_key.' | '.$ing_val );
					}
				}
			}
			if (isset($item['Variante'])) {
				foreach ( $item['Variante'] as $index => $element) {
					foreach( $element as $var_key => $var_val ){
						$info_string['Variante'][$index][$var_key] = $var_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_variant-'.$var_key, $var_key.' | '.$var_val );
					}
				}
			}
			if (isset($item['Temperature'])) {
				foreach ( $item['Temperature'] as $index => $element) {
					$info_string['Temperature'][$index] = $element;
					$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_temperature-'.$index, $index.' | '.$element );
				}
			}
			if (isset($item['searched'])) {
				$info_string['searched'] = sanitize_text_field(wp_unslash( array_values( $item['searched'] )[0] ));
			}
			$order->update_meta_data( '{'.substr($pos,1).'}info-', wp_json_encode($info_string) );
		}
	}
}
	if (isset($_POST['table_name_cpt'])) {
		$order->update_meta_data( 'Table_cpt', sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) );
	}
	if (isset($_POST['table_name'])) {
		$order->update_meta_data( 'Table', sanitize_text_field(wp_unslash($_POST['table_name'])) );
	}
	if (isset($_POST['order_note'])) {
		$order->update_meta_data( 'order_note', sanitize_text_field(wp_unslash($_POST['order_note'])) );
		$order->add_order_note( sanitize_text_field(wp_unslash($_POST['order_note'])) );
	}
	if (isset($_POST['table_surname'])) {
		$order->update_meta_data( 'table_surname', sanitize_text_field(wp_unslash($_POST['table_surname'])) );
	}
	$order->update_meta_data( 'delivery_type', 'table' );
	// FO_update_meta( 'last_woocommerce_order', wp_json_encode( $order ) );
	// FO_update_meta( 'last_woocommerce_order_products', wp_json_encode( $products ) );
	$order->set_payment_method('cod');//set_prop( 'payment_method', 'cod' );
	$order->set_created_via( 'ajax' );


$order->calculate_totals();

	$order->save();

	$order_id = $order->get_id();
do_action( 'FO_submit_order_ajax', $order_id );
	// $table = $order->id;
    wp_send_json(array(
    	// 'response' 	=> $response,
    	// 'time_exec' => $time,
		'post' => $_POST,
		// 'loop_array' => $loop_array
	));
	die();
}
add_action('wp_ajax_FO_submit_order_ajax', 'FO_submit_order_ajax');
add_action('wp_ajax_nopriv_FO_submit_order_ajax', 'FO_submit_order_ajax');






function FO_flash_list_order_ajax(){
	if (!isset($_POST['_fononce_flash_list_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_fononce_flash_list_order'])), 'FO_flash_list_order' ) ) {
		return $variation_id;
	}
	$user = wp_get_current_user();
	$order = new WC_Order();
	$table_name_cpt = ( isset($_POST['table_name_cpt']) ) ? sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) : esc_html__('TAVOLO','flash_order');
	$address = array(
	    'address_1' => $table_name_cpt,
	    'address_2'  => (isset($_POST['table_name']))?sanitize_text_field(wp_unslash($_POST['table_name'])):'',
	    'company'  => (isset($_POST['table_surname']))?sanitize_text_field(wp_unslash($_POST['table_surname'])):''
	);
	$order->set_address( $address, 'shipping' );
	$addressBilling = array(
		'first_name' 	=> $user->user_firstname,
		'last_name' 	=> $user->user_lastname,
		'email'      	=> $user->user_email,
		'phone'      	=> $user->user_phone,
	);
	$order->set_address( $addressBilling, 'billing' );
	$info_string = array();

if (isset($_POST['foserialmap'])) {
$order->update_meta_data( 'foserialmap', sanitize_text_field(wp_unslash(wp_json_encode($_POST['foserialmap']))) );//phpcs:ignore
	$total_fee = 0.0;
	foreach ( $_POST['foserialmap'] as $K => $E) {//phpcs:ignore
		foreach ( $E as $pos => $item) {
			if ( isset($item['id']) ) { 
				$order->update_meta_data( '{'.substr($pos,1).'}index-'.sanitize_text_field(wp_unslash(key($item['id']))), sanitize_text_field(wp_unslash( array_values( $item['id'] )[0] )) );
				$product = wc_get_product(sanitize_text_field(wp_unslash(key($item['id']))));
				$order->add_product( $product, sanitize_text_field(wp_unslash( array_values( $item['id'] )[0] )) );
				$info_string[sanitize_text_field(wp_unslash(key($item['id'])))] = sanitize_text_field(wp_unslash(array_values($item['id'])[0]));
			}
			if (isset($item['note'])) {
				$order->update_meta_data( '{'.substr($pos,1).'}prod-'.sanitize_text_field(wp_unslash(key($item['note']))).'_note-', sanitize_text_field(wp_unslash( array_values( $item['note'] )[0] )) );
				$info_string['note'][sanitize_text_field(wp_unslash(key($item['note'])))] = sanitize_text_field(wp_unslash(array_values($item['note'])[0]));
			}
			if (isset($item['Ingredienti'])) {
				foreach ( $item['Ingredienti'] as $index => $element) {
					foreach( $element as $ing_key => $ing_val ){
						$info_string['Ingredienti'][$index][$ing_key] = $ing_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_ingredient-'.$ing_key, $ing_key.' | '.$ing_val );
					}
				}
			}
			if (isset($item['Variante'])) {
				foreach ( $item['Variante'] as $index => $element) {
					foreach( $element as $var_key => $var_val ){
						$info_string['Variante'][$index][$var_key] = $var_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_variant-'.$var_key, $var_key.' | '.$var_val );
					}
				}
			}
			if (isset($item['Temperature'])) {
				foreach ( $item['Temperature'] as $index => $element) {
					$info_string['Temperature'][$index] = $element;
					$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_temperature-'.$index, $index.' | '.$element );
				}
			}
			if (isset($item['searched'])) {
				$info_string['searched'] = sanitize_text_field(wp_unslash( array_values( $item['searched'] )[0] ));
			}
			if (isset($item['sconto'])) {
				$order->update_meta_data( '{'.substr($pos,1).'}sconto-', sanitize_text_field(wp_unslash( array_values( $item['sconto'] )[0] )) );
				$info_string[sanitize_text_field(key($item['sconto']))] = sanitize_text_field(wp_unslash(array_values($item['sconto'])[0]));
				$total_fee = floatval($total_fee) + floatval( sanitize_text_field(wp_unslash(array_values($item['sconto'])[0])) );
			}

			if (isset($item['prod_generic'])) {
				foreach ( $item['prod_generic'] as $ind => $ele) {
					$info_string['prod_generic'][$ind] = $ele;
					$order->update_meta_data( '{'.substr($pos,1).'}prod_generic-'.$ind, $ind.' | '.$ele );

					$prod_generic_fee = new WC_Order_Item_Fee();
					$prod_generic_fee->set_name($ind);
				  	$prod_generic_fee->set_total( $ele );

				  	$order->add_item($prod_generic_fee);
				}
			}
			$order->update_meta_data( '{'.substr($pos,1).'}info-', wp_json_encode($info_string) );
		}
	}
}
	if (isset($_POST['table_name_cpt'])) {
		$order->update_meta_data( 'Table_cpt', sanitize_text_field(wp_unslash($_POST['table_name_cpt'])) );
	}
	if (isset($_POST['table_name'])) {
		$order->update_meta_data( 'Table', sanitize_text_field(wp_unslash($_POST['table_name'])) );
	}
	if (isset($_POST['order_note'])) {
		$order->update_meta_data( 'order_note', sanitize_text_field(wp_unslash($_POST['order_note'])) );
		$order->add_order_note( sanitize_text_field(wp_unslash($_POST['order_note'])) );
	}
	if (isset($_POST['table_surname'])) {
		$order->update_meta_data( 'table_surname', sanitize_text_field(wp_unslash($_POST['table_surname'])) );
	}
	$order->update_meta_data( 'delivery_type', 'table' );
	// FO_update_meta( 'last_woocommerce_order', wp_json_encode( $order ) );
	// FO_update_meta( 'last_woocommerce_order_products', wp_json_encode( $products ) );
	$order->set_payment_method('cod');
	$order->set_created_via( 'lista_ajax' );


if ( $total_fee > 0.0 ) {
	$fee = new WC_Order_Item_Fee();
	$fee->set_name('Discount');		//Give the Fee a name e.g. Discount
  	$fee->set_total( $total_fee );	//Set the Fee $total_fee
  	$order->add_item($fee);			//Add to the Order
}


  	$order->calculate_totals();		//Recalculate the totals. IMPORTANT!

	$order->save();

	$order_id = $order->get_id();

	if ($_POST['table_name_cpt'] != '' ) {
		$table_id = FO_get_page_id_by_title(sanitize_text_field(wp_unslash($_POST['table_name_cpt'])),'tavoli');
		FO_update_meta( 'status_table_'.$table_id, 1, 'table_status' );
		if (function_exists('FOP_update_table_from_table_id')) {
			FOP_update_table_from_table_id( $table_id ,array(
				'table_number'=>sanitize_text_field(wp_unslash($_POST['table_name_cpt'])),
				'table_id'=>$table_id,
				'status' => 1,
				'orders' => $order_id,
				'totals' => (string)$order->get_total(),
			) );
		}
	}

do_action( 'FO_flash_list_order_ajax', $order_id );
	// $table = $order->id;
    wp_send_json(array(
    	// 'response' 	=> $response,
    	// 'time_exec' => $time,
		'post' => $_POST,
		// 'loop_array' => $loop_array
	));
	die();
}
add_action('wp_ajax_FO_flash_list_order_ajax', 'FO_flash_list_order_ajax');
add_action('wp_ajax_nopriv_FO_flash_list_order_ajax', 'FO_flash_list_order_ajax');









function FO_flash_list_order(){
	$args = array(
		'status'            => 'publish',
		'orderby' 			=> 'title',
		'order'             => 'ASC',
		'post_type' 		=> array('product', 'product_variation'),
		'type' 				=> array('simple', 'variation'),
		'limit'             => -1,  // -1 for unlimited
	    'offset'            => null,
	    'page'              => 1,
	    'return'            => 'objects',
		'paginate'          => false,
	);
	$list_products = wc_get_products( $args );

	// $parent_product = wc_get_product(22998);
	// $args = array(
	//     'attribute_billing-period' => 'Yearly',
	//     'attribute_subscription-type' => 'Both'
	// );
	// $product_variation = $parent_product->get_matching_variation($args);
	$nonce = wp_create_nonce( 'FO_flash_list_order' );
    echo '<input type="hidden" id="_fononce_flash_list_order" name="_fononce_flash_list_order" value="'.esc_attr($nonce).'" />';
	?>
	<div class="FO_flash_list_order_container">
			<div class="FOloadingCardPublic" style="display:none;">
				<span style="animation: fospin 1s infinite;font-size:120px;width:120px;height:120px;" class="dashicons dashicons-update"></span>
			</div>
		<div class="FO_order_list_summary">
			
		</div>
		<div class="FONum_products" style="display:none;">0</div>
<!-- products list -->
		<div id="FO_order_list_search" class="FO_order_list_search">
			<input type="search" onkeyup="FO_search_for_target(this,'.FO_target_search');jQuery('.FO_order_list').show()" onclick="FO_search_for_target(this,'.FO_target_search')" class="focatsearchall FO_list_height" placeholder="<?php esc_html_e('Cerca prodotto...','flash_order' );?>">
			<div class="FO_clear_input" onclick="jQuery(this).prev().val('');jQuery(this).next().find('.FO_target_search').hide();">X</div>
			<div class="FO_order_list" style="display:none;">
			<?php 
				foreach ($list_products as $key => $value) {
					$name = $value->get_name();

					$price = ($value->get_price()!='')?$value->get_price():'0';
					$short_title = (get_post_meta($value->get_id(),'short_title'))?get_post_meta($value->get_id(),'short_title')[0]:$value->get_name();
					$slang_title = (get_post_meta($value->get_id(),'slang_title'))?get_post_meta($value->get_id(),'slang_title')[0]:$short_title;
				// $name = $slang_title;
					$class = ($value->get_type() == 'variation')? 'FO_list_variation': '';
				?>
				<div class="FO_target_search FO_list_prod_summ <?php echo esc_attr($class);?>" foid="<?php echo esc_attr($value->get_id());?>" foname="<?php echo esc_attr($name);?>" fonameshort="<?php echo esc_attr($short_title);?>" fonameslug="<?php echo esc_attr($slang_title);?>" foprice="<?php echo esc_attr($price);?>" style="display:none;" onclick="FO_order_list(this);">
					<div class="foname">
						<?php 
						echo esc_attr($slang_title);
						if ( $value->get_type() == 'variation' ) {
							echo "  |->  ".wp_kses_data(implode(", ", $value->get_attributes() ));
							// foreach ( $value->get_attributes() as $k => $attribute) {
							// 	echo $attribute.', ';
							// }
						}
						?>
					</div>
					<div class="FO_list_price" style="display:none;"><?php echo esc_attr(FO_price($value->get_price()));?></div>
					<div class="FO_clear_target" style="display:none;">X</div>
					<input type="hidden" name="[id][<?php echo esc_attr($value->get_id());?>]" value="1">
				</div>
			<?php } ?>
				
			</div>
			<script type="text/javascript">
				function fo_list_order_height(){
					var formVal = jQuery("#FO_list_height").height();
					jQuery(".FO_order_list").css("top", formVal );
				}
				window.addEventListener('scroll', fo_list_order_height);
				window.addEventListener('resize', fo_list_order_height);
				fo_list_order_height();

				jQuery( window ).on( "click", function() {
					if (!jQuery(".FO_order_list, .FO_target_search, .FO_list_height").is(":focus") ) {
						jQuery(".FO_order_list").hide();
					}
					// if (!jQuery(".FO_order_list, .FO_list_height").is(":focus") ) {
					// 	jQuery(".FO_order_list").hide();
					// }
				});
			</script>


			<div class="FO_table_input" style="border:1px solid #ffffff6b;">
<!-- Prodotto Generico -->
				<input type="text" value="<?php esc_html_e( 'Prodotto Generico', 'flash_order');?>" style="flex-basis:100%;" onkeyup="jQuery(this).parent().find('.final_input').attr('name','[prod_generic]['+jQuery(this).val()+']');jQuery(this).parent().find('.foname').text(jQuery(this).val())">

				<div class="spinner-button-big" onclick="FO_add_value_to_input(-1.00,'.fo_target_discount_prod')">-1</div>
				<div class="spinner-button-big" onclick="jQuery(this).next().val(parseFloat(parseFloat(jQuery(this).next().val()) - 0.10).toFixed(2))">-</div>
					<input id="discount" class="fo_target_discount_prod" type="number" name="discount" value="0">
				<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseFloat(parseFloat(jQuery(this).prev().val()) + 0.10).toFixed(2))">+</div>
				<div class="spinner-button-big" onclick="FO_add_value_to_input(1.00,'.fo_target_discount_prod')">+1</div>
				<div class="FO_list_prod_summ" style="display:none;" foprice="">
					<div class="foname"><?php esc_html_e( 'Prodotto Generico', 'flash_order');?></div>
					<input class="final_input" type="hidden" name="[prod_generic][Prodotto Generico]" value="">
					<div class="FO_list_price"></div>
					<div class="FO_clear_target" onclick="FO_order_list_remove(jQuery(this).parent());jQuery(this).parent().remove();">X</div>
				</div>
				<div class="spinner-button-big" style="font-size:15px!important;" onclick="FO_order_discount_list(this,'.fo_target_discount_prod');">AGGIUNGI</div>
			</div>

		</div>
<!-- Tavolo -->
		<div class="FO_order_list_search">
			<?php 
			$fo_front_surname = (!in_array(FO_get_meta('flash_order_front_surname'), array(null, ''), true)) ? explode(",", FO_get_meta('flash_order_front_surname')): '';
			if (post_type_exists( 'tavoli' )) {
				$tavoli = get_posts( array(
					'numberposts' => -1,
					'orderby'     => 'title',
					'order'       => 'ASC',
					'post_type'   => 'tavoli',
				) );
			}
			?>
			<div class="FO_table_input"> 
				<select name="table_name_cpt" class="fo-select" style="flex-basis:100%">
					<option value=""><?php esc_html_e('Seleziona Tavolo','flash_order');?></option>
					<?php foreach ($tavoli as $key => $value) { ?>
						<option value="<?php echo esc_attr($value->post_title);?>"><?php echo esc_attr($value->post_title);?></option>
					<?php } ?>
				</select>
				<span style="flex-basis:100%">
					<?php echo ' - '.esc_html__( 'oppure impostalo','flash_order').' - ';?>
				</span>
				<div class="spinner-button-big" onclick="jQuery(this).next().val(parseInt(jQuery(this).next().val()) - 1)">-</div>
				<input id="table_name" type="number" name="table_name" value="0">
				<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseInt(jQuery(this).prev().val()) + 1)">+</div>
				<select name="table_surname" class="fo-select">
					<option value=""><?php esc_html_e('- zona -','flash_order');?></option>
					<?php foreach ($fo_front_surname as $key => $value) { ?>
						<option value="<?php echo esc_attr($value);?>"><?php echo esc_attr($value);?></option>
					<?php } ?>
				</select>
			</div>
		</div>
<!-- prezzo / sconto -->
		<div class="FO_order_list_search">

			<div class="FO_table_input">
				<span style="flex-basis:100%;">
					<?php echo ' - '.esc_html__( 'prezzo / sconto','flash_order').' - ';?>
				</span>
				<div class="spinner-button-big" onclick="FO_add_value_to_input(-1.00,'.fo_target_discount')">-1</div>
				<div class="spinner-button-big" onclick="jQuery(this).next().val(parseFloat(parseFloat(jQuery(this).next().val()) - 0.10).toFixed(2))">-</div>
					<input id="discount" class="fo_target_discount" type="number" name="discount"  value="0">
				<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseFloat(parseFloat(jQuery(this).prev().val()) + 0.10).toFixed(2))">+</div>
				<div class="spinner-button-big" onclick="FO_add_value_to_input(1.00,'.fo_target_discount')">+1</div>
				<div class="FO_list_prod_summ" style="display:none;" foprice="">
					<div class="foname"><?php echo '- prezzo / sconto -';?></div>
					<input class="final_input" type="hidden" name="[sconto][]" value="">
					<div class="FO_list_price"></div>
					<div class="FO_clear_target" onclick="FO_order_list_remove(jQuery(this).parent());jQuery(this).parent().remove();">X</div>
				</div>
				<div class="spinner-button-big" style="font-size:15px!important;" onclick="FO_order_discount_list(this,'.fo_target_discount');">AGGIUNGI</div>
			</div>

		</div>

		<textarea name="order_note" placeholder="Note..." style="margin:5px;"></textarea>
		<div class="FO_summ_container">
			<div class="FO_summ_tot" style="flex-basis:100%">
				<span>0</span> <?php echo esc_attr(get_woocommerce_currency_symbol());?>
			</div>
			<div class="FO_order_avvia" style="flex-basis:100%" onclick="FO_order_list_ajax(this)">
				AVVIA
			</div>
		</div>
	</div>
	
	<?php
}












function FO_flash_tab_order_ajax( $poste = '', $clear = false ){
	if ( !isset($_POST['_fononce_flash_tab_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_fononce_flash_tab_order'])), 'FO_flash_tab_order' ) ) {
		return;
	}
	if (FOcheck($poste) && is_array($poste) ) {
		$_POST = $poste;
	}
	// wp_send_json(array(
	// 	// 'S_customers' => $_POST['S_customers'],
	// 	// 'customer_type' => $_POST['customer_type'],
	// 	'post' => $_POST,
	// ));
	// die();
	$order = new WC_Order();

	$user_id = (isset($_POST['user_id'])) ? sanitize_text_field(wp_unslash($_POST['user_id'])):'';
	$created_via = (isset($_POST['created_via'])) ? sanitize_text_field(wp_unslash($_POST['created_via'])):'';
	// $user = wp_get_current_user();

	$order->update_meta_data( 'created_via', $created_via );
	$order->update_meta_data( 'user_id', $user_id );

	$c_index = 1;

	if (isset($_POST['S_customers']) && $_POST['S_customers'] != null ) {
		foreach ($_POST['S_customers'] as $S_key => $S_value) {//phpcs:ignore
			foreach ($S_value as $key => $value) {
				foreach ($value as $k => $v) {
					$order->update_meta_data( '{customer_ind_'.$c_index.'}'.$k, array_values($v)[0] );
					if ($k == 'customer_ID') {
						$order->set_customer_id(array_values($v)[0]);
					}
				}
				$c_index++;
			}
		}
	}
	// if (isset($_POST['N_customers'])  && $_POST['N_customers'] != null ) {
		// foreach ($_POST['N_customers'] as $N_key => $N_value) {
			// foreach ($N_value as $key => $value) {
				// $order->update_meta_data( '{customer_ind'.$c_index.'}'.$N_key, $value );
				// $c_index++;
			// }
		// }
	// }
	$table_name_cpt = (isset($_POST['table_name_cpt'])) ? sanitize_text_field(wp_unslash($_POST['table_name_cpt'])):'';
	$order->update_meta_data( 'Table_cpt', $table_name_cpt );

	$address = array(
		'first_name'=> $user->user_firstname,
		'last_name' => $user->user_lastname,
		'email'     => $user->user_email,
		'phone'     => $user->user_phone,
	    'address_1' => $table_name_cpt,
	    'address_2' => '', //sanitize_text_field($_POST['table_name']),
	    'company'   => '', //sanitize_text_field($_POST['table_surname'])
	);
	$order->set_address( $address, 'shipping' );
	$addressBilling = array(
		'first_name'=> $user->user_firstname,
		'last_name' => $user->user_lastname,
		'email'     => $user->user_email,
		'phone'     => $user->user_phone,
	);
	$order->set_address( $addressBilling, 'billing' );

	$info_string = array(); $vari_arr = array(); 
	$price_array = array(); $prod_args = array();
$order->update_meta_data( 'foserialmap', sanitize_text_field(wp_unslash(wp_json_encode($_POST['foserialmap']))) );//phpcs:ignore
	$total_fee = 0.0;
if (isset($_POST['foserialmap'])) {
	foreach ( $_POST['foserialmap'] as $K => $E) {//phpcs:ignore
		foreach ($E as $ind => $ele) {
			if (isset($ele['Variante'])) {
				foreach ( $ele['Variante'] as $index => $element) {
					foreach( $element as $var_key => $var_val ){
						$vari_arr[$index]['attribute_'.$var_key] = $var_val;
					}
				}
			}
		}
		foreach ($E as $ind => $ele) {
			if (isset($ele['price'])) {
				foreach ( $ele['price'] as $index => $element) {

					if ($element==null||$element=='') {
						$element = 0;
					}
					$price_array[$index] = $element;
					// $product = new WC_Product(sanitize_text_field($index) );
					// $product = wc_get_product( sanitize_text_field($index) );
						// $product->set_price( sanitize_text_field($element) );
						// update_post_meta(sanitize_text_field($index),'_price', sanitize_text_field($element));
					// $product->save();
					// $price_arr[$index] = array(
					// 	'subtotal'	=> $element,
					// 	'total' 	=> $element,
					// );
				}
			}
		}
		$price_array = $price_array;

		foreach ( $E as $pos => $item) {
			if ( isset($item['price']) ) { 
				$order->update_meta_data( '{'.substr($pos,1).'}price-'.sanitize_text_field(key($item['price'])), sanitize_text_field( array_values( $item['price'] )[0] ) );
				$info_string[sanitize_text_field(key($item['price']))] = sanitize_text_field(array_values($item['price'])[0]);
			}
			if ( isset($item['id']) ) {
				$order->update_meta_data( '{'.substr($pos,1).'}index-'.sanitize_text_field(key($item['id'])), sanitize_text_field( array_values( $item['id'] )[0] ) );
				$product = new WC_Product(sanitize_text_field(key($item['id'])) );
				// $product = wc_get_product(sanitize_text_field(key($item['id'])) );
				// $prod_id = sanitize_text_field(key($item['id']));
				// if ( $price_arr[key($item['id'])] != null ) {
					// $prod_args = array(
					// 	// 'subtotal'=> array_values($price_array)[key($item['id'])],
					// 	'total' => esc($price_array[sanitize_text_field(key($item['id']))]),
					// );
					$total = $price_array[sanitize_text_field(key($item['id']))];
					$order->update_meta_data( '{'.substr($pos,1).'}'.sanitize_text_field(key($item['id'])), $total );
					// $prod_args = $price_arr[sanitize_text_field(key($item['id']))];
				// } else{
					// $prod_args[key($item['id'])] = array();
					// $price_arr[sanitize_text_field(key($item['id']))] = '100';
					// $prod_args = array(
					// // 	'subtotal'=> '100',
					// 	'total' => '100',
					// );
				// }
				if ( isset( $vari_arr[sanitize_text_field(key($item['id']))] ) ) {
					$product_variation = $product->get_matching_variation( $vari_arr[sanitize_text_field(key($item['id']))] );
					$product = wc_get_product($product_variation);
					// $product->set_price( $price_arr[strval(key($item['id']))] );
					// $product->save();
					$order->add_product( $product, sanitize_text_field( array_values( $item['id'] )[0] ), array('total'=>$total) );
				} else{
					$order->add_product( $product, sanitize_text_field( array_values( $item['id'] )[0] ), array('total'=>$total ) );
				}
				$info_string[sanitize_text_field(key($item['id']))] = sanitize_text_field(array_values($item['id'])[0]);
			}
			if (isset($item['note'])) {
				$order->update_meta_data('{'.substr($pos,1).'}prod-'.sanitize_text_field(key($item['note'])).'_note-',sanitize_text_field(array_values($item['note'])[0]));
				$info_string['note'][sanitize_text_field(key($item['note']))] = sanitize_text_field(array_values($item['note'])[0]);
			}
			if (isset($item['Ingredienti'])) {
				foreach ( $item['Ingredienti'] as $index => $element) {
					foreach( $element as $ing_key => $ing_val ){
						$info_string['Ingredienti'][$index][$ing_key] = $ing_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_ingredient-'.$ing_key, $ing_key.' | '.$ing_val );
					}
				}
			}
			if (isset($item['Variante'])) {
				foreach ( $item['Variante'] as $index => $element) {
					foreach( $element as $var_key => $var_val ){
						$info_string['Variante'][$index][$var_key] = $var_val;
						$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_variant-'.$var_key, $var_key.' | '.$var_val );
					}
				}
			}
			if (isset($item['Temperature'])) {
				foreach ( $item['Temperature'] as $index => $element) {
					$info_string['Temperature'][$index] = $element;
					$order->update_meta_data( '{'.substr($pos,1).'}prod-'.$index.'_temperature-'.$index, $index.' | '.$element );
				}
			}
			if (isset($item['searched'])) {
				$info_string['searched'] = sanitize_text_field( array_values( $item['searched'] )[0] );
			}
			if (isset($item['sconto'])) {
				$order->update_meta_data( '{'.substr($pos,1).'}sconto-', sanitize_text_field( array_values( $item['sconto'] )[0] ) );
				$info_string[sanitize_text_field(key($item['sconto']))] = sanitize_text_field(array_values($item['sconto'])[0]);
				$total_fee = floatval($total_fee) + floatval( sanitize_text_field(array_values($item['sconto'])[0]) );
			}

			if (isset($item['prod_generic'])) {
				foreach ( $item['prod_generic'] as $ind => $ele) {
					$info_string['prod_generic'][$ind] = $ele;
					$order->update_meta_data( '{'.substr($pos,1).'}prod_generic-'.$ind, $ind.' | '.$ele );

					$prod_generic_fee = new WC_Order_Item_Fee();
					$prod_generic_fee->set_name($ind);
				  	$prod_generic_fee->set_total( $ele );

				  	$order->add_item($prod_generic_fee);
				}
			}
			if ( isset($item['orders']) ) { 
				foreach ( $item['orders'] as $index => $element) {
					$info_string['orders'][$index] = $element;
					$order->update_meta_data( '{'.substr($pos,1).'}order-'.$index, $element );
					// $old_order = new WC_Order($element);
					$old_order = wc_get_order($element);
					if (!empty($old_order)) {
						// $old_order->update_status( 'completed' );
					}
				}
			}
			$order->update_meta_data( '{'.substr($pos,1).'}info-', wp_json_encode($info_string) );
		}
	}
}

	if (isset($_POST['table_name'])) {
		$order->update_meta_data( 'Table', sanitize_text_field(wp_unslash($_POST['table_name'])) );
	}
	if (isset($_POST['order_note'])) {
		$order->update_meta_data( 'order_note', sanitize_text_field(wp_unslash($_POST['order_note'])) );
		$order->add_order_note( sanitize_text_field(wp_unslash($_POST['order_note'])) );
	}
	if (isset($_POST['table_surname'])) {
		$order->update_meta_data( 'table_surname', sanitize_text_field(wp_unslash($_POST['table_surname'])) );
	}

	$order->update_meta_data( 'delivery_type', 'table' );

	$order->set_payment_method('cod');
	$order->set_created_via( 'tab_ajax' );

if ( $total_fee > 0.0 ) {
	$fee = new WC_Order_Item_Fee();
	$fee->set_name('Sconto');		//Give the Fee a name e.g. Discount
  	$fee->set_total( $total_fee );	//Set the Fee $total_fee
  	$order->add_item($fee);			//Add to the Order
}

	foreach ($order->get_items() as $key => $item) {
		// $price_arr[$item->get_id()]
		$tot = $price_array[$item->get_product_id()];

	    wc_update_order_item_meta($item->get_id(),'_line_total',$tot); //_line_total discount_amount coupon_amount
	    wc_update_order_item_meta($item->get_id(),'_line_subtotal',$tot); //_line_total discount_amount coupon_amount
		$item->save_meta_data();
		$item->save();
	}

	$order->calculate_totals();	//Recalculate the totals. IMPORTANT!
	$order->save();

	$order_id = $order->get_id();

	if (isset($_POST['status'])) {
		$order->update_status(sanitize_text_field(wp_unslash($_POST['status'])));
	}

	$order = wc_get_order($order_id);

	if ($c_index == 1) {
		$order->set_customer_id($user_id);
	}

	$order->calculate_totals();	
	$order->save();

$table_id = (isset($_POST['table_id'])) ? sanitize_text_field(wp_unslash($_POST['table_id'])):'';

	FO_update_meta( 'status_table_'.$table_id, 1, 'table_status' );
	if ( function_exists('FOP_update_table_from_table_id') ) {
		FOP_update_table_from_table_id( $table_id, array(
			'table_number'=> $table_name_cpt,
			'table_id'=> $table_id,
			'status' => 1,
			'orders' => $order_id,
			'totals' => (string)$order->get_total(),
		) );
	}

	if ($clear) {
		FO_update_meta( 'status_table_'.$table_id, 0, 'table_status' );
		if (function_exists('FOP_update_table_from_table_id')) {
			FOP_update_table_from_table_id( $table_id, array(
				'end_time' 	=> wp_date('Y-m-d H:i:s'),
				'status' 	=> 10,
			) );
		}
	}
	
do_action( 'FO_flash_tab_order_ajax', $order_id );
	if (!FOcheck($poste) && !is_array($poste) ) {
		wp_send_json(array(
			// 'time_exec' => $time,
			// 'post' => $_POST,
			'table_id' => $table_id,
			'order_id'=> wp_json_encode($order_id),
			'order_total'=> (string)$order->get_total(),
			'price_array' => $price_array,
			// 'vari_arr' => $vari_arr
		));
		die();
	}
}
add_action('wp_ajax_FO_flash_tab_order_ajax', 'FO_flash_tab_order_ajax');
add_action('wp_ajax_nopriv_FO_flash_tab_order_ajax', 'FO_flash_tab_order_ajax');

function FO_flash_tab_clear_table( $poste = '' ){
	if ( !isset($_POST['_fononce_flash_tab_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_fononce_flash_tab_order'])), 'FO_flash_tab_order' ) ) {
		return;
	}
	if (FOcheck($poste) && is_array($poste) ) {
		$_POST = $poste;
	}
	$table_id = (isset($_POST['table_id'])) ? sanitize_text_field(wp_unslash($_POST['table_id'])):'';
	// do_action( 'FO_flash_tab_clear_table', $order_id );
	FO_update_meta( 'status_table_'.$table_id, 0, 'table_status' );
	if (function_exists('FOP_update_table_from_table_id')) {
		FOP_update_table_from_table_id( $table_id, array(
			'end_time' 	=> wp_date('Y-m-d H:i:s'),
			'status' 	=> 10,
		) );
	}
	if (!FOcheck($poste) && !is_array($poste) ) {
	    wp_send_json(array(
			'post' => $_POST,
			'table_id' => $table_id,
		));
		die();
	}
}
add_action('wp_ajax_FO_flash_tab_clear_table', 'FO_flash_tab_clear_table');
add_action('wp_ajax_nopriv_FO_flash_tab_clear_table', 'FO_flash_tab_clear_table');

function FO_flash_tab_clear_all_tables(){
	if ( !isset($_POST['_fononce_flash_tab_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_fononce_flash_tab_order'])), 'FO_flash_tab_order' ) ) {
		return;
	}

	$tables = FO_get_meta_by_assoc_id( 'table_status', 'OBJECT' );

	foreach ($tables as $table) {
		FO_update_meta( $table->meta_key, 0, 'table_status' );
		if (function_exists('FOP_update_table_from_table_id')) {
			FOP_update_table_from_table_id( str_replace( "status_table_", "", $table->meta_key ), array(
				'end_time' 	=> wp_date('Y-m-d H:i:s'),
				'status' 	=> 10,
			) );
		}
	}

   wp_send_json(array(
		// 'post' => $_POST,
		'tables' => $tables,
	));
	die();
	
}
add_action('wp_ajax_FO_flash_tab_clear_all_tables', 'FO_flash_tab_clear_all_tables');
add_action('wp_ajax_nopriv_FO_flash_tab_clear_all_tables', 'FO_flash_tab_clear_all_tables');




function FO_flash_tab_pay_ajax(){
	if ( !isset($_POST['_fononce_flash_tab_order']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_flash_tab_order'])), 'FO_flash_tab_order' ) ) {
		return;
	}
	$table_id = (isset($_POST['table_id'])) ? sanitize_text_field(wp_unslash($_POST['table_id'])):'';
	// do_action( 'FO_flash_tab_clear_table', $order_id );
	$_POST['status'] = 'completed';
	// $_POST['pay_status_order'] = 'completed';
	// foreach ($_POST['orders'] as $key => $value) {
		// $_POST['order_id'] = $value;
		// $order = new WC_Order($value);
		// if (!empty($order)) {
		// 	$order->update_status( 'completed' );
		// }
	//	// FO_ajax_change_order_status( $_POST );
	// }
	// FO_flash_tab_clear_table( $_POST );
	// FO_update_meta( 'status_table_'.sanitize_text_field($_POST['table_id']), 0, 'table_status' );
	// // FO_update_meta( 'table_object_'.sanitize_text_field($_POST['table_id']), 1, 'table_status' );
	// if (function_exists('FOP_update_table_from_table_id')) {
	// 	FOP_update_table_from_table_id(sanitize_text_field($_POST['table_id']),array(
	// 		'end_time' 	=> wp_date('Y-m-d H:i:s'),
	// 		'status' 	=> 10,
	// 	) );
	// }
	FO_flash_tab_order_ajax( $_POST, true );

	wp_send_json(array(
		'post' => $_POST,
		'table_id' => $table_id,
	));
	die();
}
add_action('wp_ajax_FO_flash_tab_pay_ajax', 'FO_flash_tab_pay_ajax');
add_action('wp_ajax_nopriv_FO_flash_tab_pay_ajax', 'FO_flash_tab_pay_ajax');









function FOP_get_table_by_table_id_last( $table_id, $type = 'OBJECT' ){
  global $wpdb;
  $table = $wpdb->prefix . "flash_order_table";
  // $date = wp_date('Y-m-d H:i:s');
	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM %i WHERE table_id = %s AND status < 10", $table, $table_id ), $type );
	return $result;
}


function FO_flash_tab_order( $tavoli = array() ){
	$order_index = 999999;
	$products = FO_get_products_for_loop(array('taxonomy'=>'macro_categories'));
	$products_w_vari = FO_get_products_for_loop(array('taxonomy'=>'macro_categories','type'=>array('simple','variable')));

	// $macro_cat_args = array(
	//    'number'     => false,
	//    'include' => 'all',
	//    'hide_empty' => true, //can be 1, '1' too
	//    'orderby'   => 'title',
	//    'order'     => 'ASC',
	// );
	// $products_macro_categories = get_terms( 'macro_categories', $macro_cat_args );

	$products_macro_categories = new WP_Term_Query( array(
		'taxonomy'	=> 'macro_categories',
		'include' 	=> 'all',
		'hide_empty' => false,
		'orderby'   => 'title',
		'order'     => 'ASC',
	) );
		$m_cat_check = 'macro_categories';
	if ( $products_macro_categories->terms == null ) {
		$m_cat_check = 'product_cat';
		$products_macro_categories = new WP_Term_Query( array(
			'taxonomy'	=> 'product_cat',
			'include' 	=> 'all',
			'hide_empty' => false,
			'orderby'   => 'title',
			'order'     => 'ASC',
		) );
	}
	if ( $products_macro_categories->terms != null ) {
		$first_macro = $products_macro_categories->terms[0];
	} else{ $first_macro = false; }
	
	
	$nonce = wp_create_nonce( 'FO_flash_tab_order' );
    echo '<input type="hidden" id="_fononce_flash_tab_order" name="_fononce_flash_tab_order" value="'.esc_attr($nonce).'" />';

	?>
	<div class="FO_flash_tab_order_container fo_tab_show" style="display:none;">
		<!-- <div class="Advanced_Card_Close"onclick="FO_tab_Card_hide()"><?php esc_html_e('CHIUDI','flash_order');?></div> -->
		<div class="FOloadingCardPublic tab_fix_load" style="display:none;">
			<span style="animation: fospin 1s infinite;font-size:120px;width:120px;height:120px;" class="dashicons dashicons-update"></span>
		</div>

		<div class="FO_flash_tab_header">
			<?php foreach ($products_macro_categories->terms as $key => $value) { ?>
				<div class="fo_button" onclick="FO_filter_tab_product(<?php echo "'".esc_attr($value->slug)."'"; ?>)" ondrop="FOdrop(event)" ondragover="FOallowDrop(event)" fo_cat_name="<?php echo esc_attr($value->slug);?>" fo_cat_id="<?php echo esc_attr($value->term_id);?>" fo_cat_ceck="<?php echo esc_attr($m_cat_check);?>">
					<?php echo esc_attr($value->name);?>
				</div>
			<?php } ?>
			<div class="fo_button Advanced_Card_Close_float" onclick="FO_tab_Card_hide()" style="margin-left:auto!important;">
				<?php esc_html_e('CHIUDI','flash_order');?>
			</div>
		</div>

		<div class="FO_flash_tab_body">
			<div class="fo_tab_prod_index_story" style="display:none;">999999</div>
			<div class="fo_tab_prod_index" style="display:none;">1</div>
			<div class="fo_tab_prod_ghost_draft_index" style="display:none;">1</div>

			<div class="fo_actual_prod" style="display:none;"></div>
			<div class="fo_actual_index" style="display:none;">0</div>
			<div class="fo_actual_index_story" style="display:none;">0</div>

			<div class="fo_actual_table" style="display:none;"></div>
			<div class="fo_woo_symb" style="display:none;"><?php echo esc_attr(get_woocommerce_currency_symbol());?></div>
<!-- COL 1: -->
			<div class="FO_flash_tab_max_column fo_tab_col_1" style="">
	<!-- RIEPILOGO: -->
				<div class="FO_flash_tab_column fo_column_story" style="width:calc(100% - 20px);height:calc(50% - 55px);padding-right:80px;" onclick="fo_tab_hystory_space(this,'.fo_column_riepilogo')">
					<div class="fo_ghost_draft" style="display:none;"></div>
					<!-- <strong class="fo_title_" style=""><?php esc_html_e('STORICO:','flash_order'); ?></strong> -->
					<?php $abs_total = 0; foreach ( $tavoli as $tavolo_key => $tavolo ) { ?>
						<strong class="fo_button fo_story fo_order_table_story fo_tab_prod_story fo_title_all" fotableid="<?php echo esc_attr($tavolo->ID);?>" ondblclick="console.log('yesssss')" onclick="fo_filter_tab_story(this,'all')">
							<?php esc_html_e('STORY','flash_order');?>
						</strong>
						<?php
							$data_table = FOP_get_table_by_table_id_last($tavolo->ID);
							$story = ( $data_table != null ) ? json_decode($data_table->orders) : array();
							foreach ((array)$story as $story_v) {
								$order = new WC_Order($story_v); 
								?>
								<div class="fo_button fo_story fo_order_table_story" fotableid="<?php echo esc_attr($tavolo->ID);?>"  ondblclick="fo_change_order_status(<?php echo "'".esc_attr($order->get_id())."'";?>, 'processing' );console.log('yesssss')" onclick="fo_filter_tab_story(this,<?php echo "'".esc_attr($order->get_id())."'";?>)" fo_order_id="<?php echo esc_attr($order->get_id());?>" fo_order_total="<?php echo esc_attr($order->get_total());?>" fo_order_subtotal="<?php echo esc_attr($order->get_subtotal());?>">
									<?php echo esc_attr($order->get_id());?>
								</div>
								<?php //fo_change_order_status
							} 
							foreach ((array)$story as $story_v) {
								$f_i = 200000;
								// $order = new WC_Order($story_v); 
								$order = wc_get_order($story_v); 
								$items = $order->get_items();

								$meta_data = get_post_meta( $order->get_id() );
								$meta_array = FO_extract_meta_array($meta_data);
					// FO_debug($meta_array);
								foreach ( $meta_array as $meta_index => $meta_elem ){
									$varianti = (array_key_exists('variant', $meta_elem))?$meta_elem['variant']:array();
								}
								foreach ($items as $item_id => $item) {
									$product = $item->get_product();
									// $product_variation = $product->get_matching_variation( array('attribute_tipo'=>'Naturale') );
									if ($product == false||$product == null) {continue;}
										$short_title = (FOcheck(get_post_meta($product->get_id(),'short_title')) && get_post_meta($product->get_id(),'short_title')[0]!='')?get_post_meta($product->get_id(),'short_title')[0]:$product->get_name();
										$slang_title = ( FOcheck(get_post_meta($product->get_id(),'slang_title') ) && get_post_meta($product->get_id(),'slang_title')[0]!='' )?get_post_meta($product->get_id(),'slang_title')[0]:$short_title;
									$order_index++;
										if ($product->get_type() == 'variation') {
											$product_id = $product->get_parent_id();
											$product_attr = $product->get_variation_attributes();
										} else{
											$product_id = $product->get_id();
											$product_attr = $product->get_attributes();
										}
										// FO_debug($product_attr);
										// $product = wc_get_product( $product_id );
										$def_p_attr = $product->get_default_attributes();
										// FO_debug( $product->get_default_attributes() );
										?>
										<div class="fo_tab_prod fo_story relative" foprodid="<?php echo esc_attr($product_id);?>" foprodtot="<?php echo esc_attr($item->get_subtotal());?>" onclick="FO_filter_tab_variant(this,<?php echo "'".esc_attr($product_id)."'"; ?>)" fo_index="<?php echo esc_attr($order_index);?>" fo_index_story="<?php echo esc_attr($story_v);?>" fo_modificable="false" fo_type="story" fotableid="<?php echo esc_attr($tavolo->ID);?>">
											<div class="FO_prod_name_manage fo_text_fix">
												<?php echo esc_attr($slang_title);?>
											</div>
											<div class="FO_prod_img" style="border-radius:5px;">
												<?php echo wp_kses_post($product->get_image());?>
											</div>
											<input fo_tab_target="id" type="hidden" name="[<?php echo esc_attr($f_i);?>][id][<?php echo esc_attr($product_id);?>]" value="1">
											<input fo_tab_target="Ingredienti" type="hidden" name="[<?php echo esc_attr($f_i);?>][Ingredienti][<?php echo esc_attr($product_id);?>]" value="">
											<input fo_tab_target="Temperature" type="hidden" name="[<?php echo esc_attr($f_i);?>][Temperature][<?php echo esc_attr($product_id);?>]" value="">
											<input fo_tab_target="price" type="hidden" name="[<?php echo esc_attr($f_i);?>][price][<?php echo esc_attr($product_id);?>]" value="<?php echo esc_attr($item->get_subtotal());?>">
											<input fo_tab_target="note" type="hidden" name="[<?php echo esc_attr($f_i);?>][note][<?php echo esc_attr($product_id);?>]" value="">
											<?php 
											// foreach ($product_attr as $k => $v) {
												// if (str_contains($k, 'pa_')) {
												// 	$k = str_replace('pa_', '', $k);
												// }
												// foreach ($varianti as $key_varianti => $value_varianti) {
												foreach ($varianti as $k => $v) {
													// FO_debug( $value_varianti );
												// }
												// if (isset($varianti[$k]) && $varianti[$k] != '' ) {
													// $vari_val = key( $varianti[$k] );
													// $vari_key = $varianti[$k];
												// } else{
													// if ($product->get_type()=='variation') {
													// 	$vari_val = $v;
													// 	$vari_key = str_replace('attribute_', '', $k);
													// } else {
													// 	$vari_val = (isset($def_p_attr[$k]))?$def_p_attr[$k]:'';
													// 	$vari_key = str_replace('pa_', '', $k);
													// }
												// }
												$vari_val = $v;
												$vari_key = $k;
												?>
												<input fo_tab_target="variante" fovariant="<?php echo esc_attr($vari_key);?>" name="[<?php echo esc_attr($f_i);?>][Variante][<?php echo esc_attr($product_id);?>][<?php echo esc_attr($vari_key);?>]" type="hidden" value="<?php echo esc_attr($vari_val);?>">
											<?php } ?>
										</div>
								<?php $f_i++; }
								 foreach ( $order->get_fees() as $item_fee ) {
									$fee_name = $item_fee->get_name();
									$fee_total = $item_fee->get_total();
									$abs_total = floatval($abs_total) + floatval($fee_total);
								?>
									<div class="fo_tab_prod fo_story relative" foprodid="<?php echo esc_attr($fee_name);?>" foprodtot="<?php echo esc_attr($fee_total);?>" onclick="FO_filter_tab_variant(this,<?php echo "'".esc_attr($fee_name)."'"; ?>)" fo_index="<?php echo esc_attr($order_index);?>" fo_index_story="<?php echo esc_attr($story_v);?>" fo_modificable="false" fo_type="story" fotableid="<?php echo esc_attr($tavolo->ID);?>">
										<div class="FO_prod_name_manage fo_text_fix">
											<?php echo esc_attr($fee_name);?>
										</div>
										<div class="FO_prod_img" style="border-radius:5px;">
											<img width="300" height="300" src="<?php echo esc_url(wc_placeholder_img_src( 300 )); ?>">
										</div>
										<input fo_tab_target="id" type="hidden" name="[<?php echo esc_attr($f_i);?>][id][<?php echo esc_attr($fee_name);?>]" value="1">
										<input fo_tab_target="Ingredienti" type="hidden" name="[<?php echo esc_attr($f_i);?>][Ingredienti][<?php echo esc_attr($fee_name);?>]" value="">
										<input fo_tab_target="price" type="hidden" name="[<?php echo esc_attr($f_i);?>][price][<?php echo esc_attr($fee_name);?>]" value="<?php echo esc_attr($fee_total);?>">
										<input fo_tab_target="note" type="hidden" name="[<?php echo esc_attr($f_i);?>][note][<?php echo esc_attr($fee_name);?>]" value="">
									</div>
								<?php $f_i++; } ?>
							<?php } ?>
						<?php } ?>
					<div class="fo_tab_tool_section fo_tool_story">
						<?php
							if ( in_array( 'WooPrint/WooPrint.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
							?>
								<div class="fo_button_thin fo_wooprint_preconto" onclick="WooPrint(this, 'fo-tab-story');" style="color: yellow;">
									<span class="dashicons dashicons-printer"></span>
									<?php esc_html_e('Preconto','flash_order');?>
								</div>
							<?php 
							}
						?>
						<div class="fo_tab_tool_total" style="margin-top:auto;">
							<b>Totale:</b>
							<strong> <?php echo esc_attr(FO_price($abs_total));?> </strong>
						</div>
					</div>
				</div>
<!-- <strong style=""><?php esc_html_e('RIEPILOGO:','flash_order'); ?></strong> -->
				<div class="FO_flash_tab_column fo_column_riepilogo" style="width:calc(100% - 20px);padding-right:80px;" onclick="fo_tab_hystory_space(this,'.fo_column_story')">
					<div class="fo_tab_tool_section fo_tool_riepilogo">
						<div class="fo_button_thin" onclick="fo_tab_empty_section(jQuery('.fo_column_riepilogo'))" style="color: red;">
							<span class="dashicons dashicons-trash"></span>
							<?php esc_html_e('TUTTO','flash_order');?>
						</div>
						<div class="fo_tab_tool_total" style="margin-top:auto;">
							<b>Totale:</b>
							<strong> - </strong>
						</div>
						<script type="text/javascript">
							FO_calc_totals();
							// jQuery(".fo_column_riepilogo").scroll(function(){
							// 	if (jQuery(".fo_column_riepilogo").scrollTop()>1) {
							// 		jQuery(".fo_tool_riepilogo").css('marginTop',jQuery(".fo_column_riepilogo").scrollTop());
							// 	}
							// });
							// jQuery(".fo_column_story").scroll(function(){
							// 	// if (jQuery(".fo_column_story").scrollTop()>1) {
							// 		jQuery(".fo_tool_story").css('marginTop',jQuery(".fo_column_story").scrollTop());
							// 	// }
							// });
							// addEventListener("message", (event) => {
							// 	console.log('message');
								
							// });
						</script>
					</div>
				</div>
	<!-- PRODOTTI: -->
				<div class="FO_flash_tab_column fo_column_products" style="width:calc(100% - 20px);">
					<!-- <strong style=""><?php esc_html_e('PRODOTTI','flash_order'); ?></strong> -->
					<?php foreach ($products as $key => $value) { ?>
						<?php foreach ($value as $product) { 
							$macro_cat = get_the_terms( $product->get_id(), 'macro_categories');
							if ( $macro_cat == null ) {
								$macro_cat = get_the_terms( $product->get_id(), 'product_cat');
							}
							$display = 'display:none';
							if ( $first_macro != false ) {
								if ( $first_macro->slug == $macro_cat[0]->slug) {
									$display = 'display:block';
								}
							}

							$short_title = (FOcheck(get_post_meta($product->get_id(),'short_title')) && get_post_meta($product->get_id(),'short_title')[0]!='')?get_post_meta($product->get_id(),'short_title')[0]:$product->get_name();
							$slang_title = (FOcheck(get_post_meta($product->get_id(),'slang_title')) && get_post_meta($product->get_id(),'slang_title')[0]!='' )?get_post_meta($product->get_id(),'slang_title')[0]:$short_title;
							?>
							<div class="fo_tab_prod relative" foprodid="<?php echo esc_attr($product->get_id());?>" foprodtot="<?php echo esc_attr($product->get_price());?>" fomacrocat="<?php echo esc_attr($macro_cat[0]->slug);?>" style="<?php echo esc_attr($display);?>" onclick="FO_filter_tab_variant(this,<?php echo "'".esc_attr($product->get_id())."'"; ?>)" fo_index="0" fo_index_story="0" fo_modificable="true" fo_type="new" draggable="true" ondragstart="FOdrag(event)">
								<span class="fo_tab_prod_remove dashicons dashicons-trash" onclick="" style="display:none;"></span>
								<div class="FO_prod_name_manage fo_text_fix">
									<?php echo esc_attr($slang_title); ?>
								</div>
								<div class="FO_prod_img" style="border-radius:5px;">
									<?php echo wp_kses_post($product->get_image()); ?>
								</div>
								<input fo_tab_target="id" type="hidden" name="[id][<?php echo esc_attr($product->get_id());?>]" value="1">
								<input fo_tab_target="qty" type="hidden" name="[qty][<?php echo esc_attr($product->get_id());?>]" value="1">
								<input fo_tab_target="Ingredienti" type="hidden" name="[Ingredienti][<?php echo esc_attr($product->get_id());?>]" value="">
								<input fo_tab_target="Temperature" type="hidden" name="[Temperature][<?php echo esc_attr($product->get_id());?>]" value="">
								<input fo_tab_target="price" type="hidden" name="[price][<?php echo esc_attr($product->get_id());?>]" value="<?php echo esc_attr($product->get_price());?>" regularPrice="<?php echo esc_attr($product->get_price());?>" price_added="">

								<input fo_tab_target="note" type="hidden" name="[note][<?php echo esc_attr($product->get_id());?>]" value="">
								<?php 
								$product_attr = $product->get_attributes();
								foreach ($product_attr as $k => $v) {
									if (str_contains($k, 'pa_')) {
										$k = str_replace('pa_', '', $k);
									}
									?>
									<input fo_tab_target="variante" fovariant="<?php echo esc_attr($k);?>" name="[Variante][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($k);?>]" type="hidden" priceadded="" value="">
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<script type="text/javascript">
					// function fo_ajax_riepilogo_height(){
					// 	var formVal = jQuery(".FO_flash_tab_max_column").height() - jQuery(".fo_column_riepilogo").height();
					// 	jQuery(".fo_column_products").css("maxHeight", formVal );
					// }
					// window.addEventListener('scroll', fo_ajax_riepilogo_height);
					// window.addEventListener('resize', fo_ajax_riepilogo_height);
					// fo_ajax_riepilogo_height();
				</script>
			</div>
<!-- COL 2: -->
	<!-- VARIANTI: -->
			<div class="FO_flash_tab_column fo_tab_col_2" style="">
				<!-- <strong style=""><?php esc_html_e('VARIANTI:','flash_order'); ?></strong> -->
				<div class="FO_flash_tab_qty" style="display:none;"> Quantità
					<div class="spinner-button-big" onclick="fo_keyboard_qty_value(-1)">-</div>
						<input class="fo_target_qty_prod" type="number" name="qty" step="1" value="1" fo_actual_prod="" fo_actual_index="0" fo_actual_index_story="0" fo_modificable="" onchange="fo_tab_parse_qty(this);">
					<div class="spinner-button-big" onclick="fo_keyboard_qty_value(+1)">+</div>
					<script type="text/javascript">
						jQuery('.fo_target_qty_prod').on('DOMSubtreeModified', function(){
						  fo_tab_parse_qty(jQuery('.fo_target_qty_prod'));
						});
					</script>
				</div>
				<?php foreach ($products_w_vari as $key => $value) { ?>
					<?php foreach ($value as $k => $product) { 
						$macro_cat = get_the_terms( $product->get_id(), 'macro_categories');
						$product_child = $product->get_children();
						if ( !empty( $product_child ) && $macro_cat ) { ?>
							<div class="fo_tab_variantcont" fomacrocat="<?php echo esc_attr($macro_cat[0]->slug);?>" foprodidtarget="<?php echo esc_attr($product->get_id());?>" fo_modificable="true" style="display:none;">
							<?php 
								$product_attr = $product->get_attributes();
								foreach ($product_attr as $k => $v) {
									// FO_debug($product_attr);
									if (str_contains($k, 'pa_')) {
										$k = str_replace('pa_', '', $k);
										$attr = explode( ', ', $product->get_attribute( $k ) );
										$attr_term = 'pa_'.$k;
									} else{
										$attr_term = false;
										$attr = explode( ' | ', $product->get_attribute( $k ) );
									}
									// FO_debug($attr);
									?>
									<div class="fovariant fovariant_fix" fovariant="<?php echo esc_attr($k);?>">
										<strong style="flex-basis:100%;"><?php echo esc_attr($k);?></strong>
											<?php 
										foreach ($attr as $key => $opt) { 
											// FO_debug( get_string_between(get_term_by('name', $opt, 'pa_'.$k )->description,'[',']') );
											// get_term_by('name', $opt, 'pa_'.$k );
											$price_to_add = '0.0';
											if ( taxonomy_exists( $attr_term ) ) {
												$price_to_add = get_string_between(get_term_by('name', $opt, $attr_term )->description,'[',']');
											}
											?>
											<div class="fo_button_thin" fo_prod_id="<?php echo esc_attr($product->get_id());?>" onclick="jQuery(this).find('input').prop('checked', true);fo_tab_parse_variant(jQuery(this).find('input'));" fo_price="<?php echo esc_attr($product->get_price());?>" fo_price_to_add="<?php echo esc_attr($price_to_add);?>"><?php echo esc_attr($opt);?>
											<input name="[Variante][<?php echo esc_attr($product->get_id());?>][<?php echo esc_attr($k);?>]" type="radio" value="<?php echo esc_attr($opt);?>" fovariant="<?php echo esc_attr($k);?>">
											</div>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
<!-- COL 3: -->
			<div class="FO_flash_tab_column fo_tab_col_3" style="">
				<div class="fo_generic_prod" style="display:none!important;">
					
					<div class="fo_tab_prod fo_tab_prod_special relative" foprodid="Special" foprodtot="0" fomacrocat="Special" onclick="FO_filter_tab_variant(this,'Special')" fo_index="0" fo_index_story="0" fo_modificable="true" fo_type="modify" fo_special="Special">
						<span class="fo_tab_prod_remove dashicons dashicons-trash" onclick="" style="display:none;"></span>
						<div class="FO_prod_name_manage fo_text_fix">
							Special
						</div>
						<div class="FO_prod_img" style="border-radius:5px;">
							<img width="300" height="300" src="<?php echo esc_url(wc_placeholder_img_src( 300 )); ?>">
						</div>
						<input fo_tab_target="id" type="hidden" name="[prod_generic]" value="">
						<input fo_tab_target="Ingredienti" type="hidden" name="[Ingredienti]" value="">
						<input fo_tab_target="Temperature" type="hidden" name="[Temperature]" value="">
						<input fo_tab_target="price" type="hidden" name="[price]" value="0" regularPrice="0" price_added="">
						<input fo_tab_target="note" type="hidden" name="[note]" value="">
					</div>

					<div class="fo_tab_prod fo_tab_prod_discount relative" foprodid="Sconto" foprodtot="0" fomacrocat="Special" onclick="FO_filter_tab_variant(this,'Sconto')" fo_index="0" fo_index_story="0" fo_modificable="true" fo_type="modify" fo_special="Sconto">
						<span class="fo_tab_prod_remove dashicons dashicons-trash" onclick="" style="display:none;"></span>
						<div class="FO_prod_name_manage fo_text_fix">
							<?php esc_html_e( 'Sconto', 'flash_order' ); ?>
						</div>
						<span class="fo_tab_prod_price"> 0.00 </span>

						<div class="FO_prod_img" style="border-radius:5px;">
							<img width="300" height="300" src="<?php echo esc_url(wc_placeholder_img_src( 300 )); ?>">
						</div>
						<input fo_tab_target="id" type="hidden" name="[sconto]" value="">
						<input fo_tab_target="price" type="hidden" name="[price]" value="0" regularPrice="0" price_added="">
						<input fo_tab_target="note" type="hidden" name="[note]" value="">
					</div>

				</div>
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_special('special','Special')">
							<strong style="height:50px!important;display:flex;flex-direction:column;justify-content:center;">Special</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_special('special','Bar')">
							<strong style="height:50px!important;display:flex;flex-direction:column;justify-content:center;">Bar</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_special('special','Bevande')">
							<strong style="height:50px!important;display:flex;flex-direction:column;justify-content:center;">Bevande</strong>
						</div>
					</div>

				<div class="fo_tab_calc_display">
					<span class="fo_tab_price" fo_status_modify="false" fo_actual_prod="" fo_actual_index="" fo_modificable="" onchange="fo_tab_parse_price(this)"></span>
					<script type="text/javascript">
						jQuery('.fo_tab_price').on('DOMSubtreeModified', function(){
						  fo_tab_parse_price(jQuery('.fo_tab_price'));
						});
					</script>
					<!-- <div class="fo_tab_calc_keyboard_key fo_tab_add_to_order" onclick="fo_tab_add_product_to_order()">
						<strong>AGGIUNGI</strong>
					</div> -->
				</div>


				<div class="fo_tab_calc_keyboard">

					<!-- <div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_special('sub')">
							<strong>SUB</strong>
						</div>
						<div class="fo_tab_calc_keyboard_special" onclick="fo_keyboard_special('-')">
							<strong>( - )</strong>
						</div>
						<div class="fo_tab_calc_keyboard_special" onclick="fo_keyboard_special('%')">
							<strong>( % )</strong>
						</div>
					</div> -->
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('7')">
							<strong>7</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('8')">
							<strong>8</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('9')">
							<strong>9</strong>
						</div>
					</div>
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('4')">
							<strong>4</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('5')">
							<strong>5</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('6')">
							<strong>6</strong>
						</div>
					</div>
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('1')">
							<strong>1</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('2')">
							<strong>2</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('3')">
							<strong>3</strong>
						</div>
					</div>
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('.')">
							<strong>.</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('0')">
							<strong>0</strong>
						</div>
						<div class="fo_tab_calc_keyboard_key" onclick="fo_keyboard_price('.')">
							<strong>.</strong>
						</div>
					</div>
					<div class="fo_tab_calc_keyboard_row">
						<div class="fo_tab_calc_keyboard_key fo_tab_reset_price" fovalue="" onclick="fo_tab_price_default(this);">
							<span class="dashicons dashicons-image-rotate"></span>
						</div>

						<div class="fo_tab_calc_keyboard_key" onclick="fo_tab_price_del();">
							<span class="dashicons dashicons-minus"></span>
						</div>

						<div class="fo_tab_calc_keyboard_key" onclick="fo_tab_price_ac();">
							<span class="dashicons dashicons-no"></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="FO_flash_tab_footer">
			<div class="fo_table_name" onclick="FO_tab_Card_hide()">
				<strong> <?php esc_html_e('TAVOLO: ','flash_order'); ?> </strong>
				<strong class="fo_tab_table_name"> - - - - </strong>
			</div>

			<div class="fo_button_fix fo_clear_table_button" style="margin: 0 auto 0 15px;" onclick="FO_tab_clear_table()"><?php esc_html_e('LIBERA TAVOLO','flash_order');?></div>
			<!-- <textarea class="fo_tab_fix_order_note" name="order_note" placeholder="Note..." style=""></textarea> -->
			<div class="fo_button_fix fo_pay_table_button" style="margin-left:auto;display:none;" fotableid="" onclick="FO_pay_tab_Card_show(this)">
				<?php esc_html_e('PAGA TALOLO','flash_order');?>
			</div>

			<?php FO_pay_this_order_tab();?>

			<div class="fo_button_fix" style="margin-left:auto;" fo_order_type="new_order" onclick="FO_tab_go_order(this)"><?php esc_html_e('AVVIA ORDINE','flash_order');?></div>

			<div class="fo_button_fix fo_variant_show_button" style="bottom:220px!important;" onclick="fo_tab_show_variation_button()">
				<span class="dashicons dashicons-table-col-after"></span>
			</div>
			<div class="fo_button_fix fo_pay_show_keyboard_button" style="" onclick="fo_tab_show_keyboard_button()">
				<span class="dashicons dashicons-editor-table"></span>
			</div>

			<input id="table_name" type="hidden" name="table_name_cpt" value="">
			<input type="hidden" name="table_ID" value="">
		</div>

	</div>
	<div class="Advanced_Card_background fo_tab_show" style="display:none;"></div>
	<style type="text/css">
		#eltdf-back-to-top{
			visibility: hidden!important;
		}
	</style>

	<?php
}





function FO_pay_this_order_tab(){
?>
	<div class="FO_flash_tab_order_pay_container fo_flex fo_pay_tab_show" style="display:none;">
		
		<div class="FOloadingCardPublic tab_fix_load" style="display:none;">
			<span style="animation: fospin 1s infinite;font-size:120px;width:120px;height:120px;" class="dashicons dashicons-update"></span>
		</div>

		<div class="fo_pay_column fo_pay_ajax_container" style="border-right: 1px solid">
			<div class="fo_flex fo_list_items">
			</div>
			<div class="fo_flex fo_list_final_order" style="border-top: 1px solid">
			</div>
		</div>

		<div class="fo_pay_column fo_flex">
			<div class="fo_button Advanced_Card_Close_float" onclick="FO_pay_tab_Card_hide()" style="position:absolute;right:15px;">
				<?php esc_html_e('CHIUDI','flash_order');?>
			</div>
			<div class="fo_pay_body fo_flex">
				<div class="fo_pay_customer_type">
					<span> <?php esc_html_e('Cliente Esistente ? ','flash_order');?> </span>
					<input type="checkbox" name="customer_type" onclick="FO_customer_pay(this);">
				</div>
				
				<div class="fot_pay_new_customer">
					<strong style="width:100%"> <?php esc_html_e('inserisci un nuovo cliente:','flash_order');?> </strong>
					<input class="fot_pay_input N_customer_name" type="text" name="[N_customer][customer_name][]" placeholder="<?php esc_html_e('nome Cliente','flash_order');?>" style="width: 200px!important;">
					<input class="fot_pay_input N_customer_mail" type="text" name="[N_customer][customer_mail][]" placeholder="<?php esc_html_e('mail Cliente','flash_order');?>" style="width: 300px!important;">
					<input class="fot_pay_input N_customer_phone" type="text" name="[N_customer][customer_phone][]" placeholder="<?php esc_html_e('telefono Cliente','flash_order');?>" style="width: 200px!important;">
					<div class="fo_button fo_border" style="width:calc(100% - 50px);" onclick="FO_add_new_customer(jQuery(this).parent());"><?php esc_html_e('AGGIUNGI','flash_order');?></div>
				</div>

				<div class="fot_pay_search_customer" style="display:none;">
					<strong style="width:100%"> <?php esc_html_e('Cerca un cliente:','flash_order');?> </strong>
					<input type="search" onkeyup="FO_search_for_target(this,'.FO_customer_target_search');jQuery('.FO_customer_list').show()" onclick="FO_search_for_target(this,'.FO_customer_target_search');jQuery('.FO_customer_list').show()" class="focatsearchall FO_list_height" style="width: 200px!important;" placeholder="<?php esc_html_e('Cerca cliente...','flash_order' );?>">
					<div class="FO_clear_input" onclick="jQuery(this).prev().val('');jQuery(this).next().hide();">X</div>

					<div class="FO_customer_list" style="display:none;">
					<?php 
						$users = get_users(array( 'fields' => array( 'ID','display_name','user_email','user_registered' ) ) );
						// FO_debug($users);
						foreach ($users as $key => $value) {
							$u_id = ( FOcheck( $value->ID) ) ? $value->ID : ' - ';
							$u_name = ( FOcheck( $value->display_name ) ) ? $value->display_name : ' - ';
							$u_mail = ( FOcheck( $value->user_email) ) ? $value->user_email : ' - ';
							$u_phone = ( FOcheck( get_user_meta( $u_id, 'billing_phone', true ) ) ) ? get_user_meta( $u_id, 'billing_phone', true ) : ' - ';

							$u_since = ( FOcheck( $value->user_registered) ) ? $value->user_registered : '';
							$u_aurl = ( FOcheck( get_avatar( $u_id, 50 ) ) ) ? get_avatar( $u_id, 50, $default = '', $alt = '', $args = array( 'class' => 'FO_pay_customer_img' ) ) : '';
							
						?>
						<div class="FO_customer_target_search FO_list_prod_summ" style="display:none;" onclick="FO_pay_customer_list(this);" fo_u_id="<?php echo esc_attr($u_id);?>" fo_u_name="<?php echo esc_attr($u_name);?>" fo_u_mail="<?php echo esc_attr($u_mail);?>" fo_u_phone="<?php echo esc_attr($u_phone);?>" fo_u_since="<?php echo esc_attr($u_since);?>" fo_u_aurl="<?php echo esc_attr($u_aurl);?>">
							<div class="foname">
								<div> <?php echo esc_attr($u_id);?> </div>
								<div> <?php echo esc_attr($u_name);?> </div>
								<div> <?php echo esc_attr($u_mail);?> </div>
								<div> <?php echo esc_attr($u_phone);?> </div>
							</div>
							<div class="FO_clear_target" style="display:none;" onclick="">X</div>
							<input type="hidden" name="[S_customer][customer_ID][<?php echo esc_attr($u_id);?>]" value="<?php echo esc_attr($u_id);?>">
							<input type="hidden" name="[S_customer][customer_name][<?php echo esc_attr($u_id);?>]" value="<?php echo esc_attr($u_name);?>">
							<input type="hidden" name="[S_customer][customer_mail][<?php echo esc_attr($u_id);?>]" value="<?php echo esc_attr($u_mail);?>">
							<input type="hidden" name="[S_customer][customer_phone][<?php echo esc_attr($u_id);?>]" value="<?php echo esc_attr($u_phone);?>">
						</div>
						<?php
						} 
					?>
					</div>
					
				</div>
			</div>

			<div class="FO_example FO_pay_customer_card FO_exemple_customer_card" style="display:none;">
				<!-- <img class="FO_pay_customer_img" src=""> -->
				<span class="fo_tab_remove dashicons dashicons-trash" onclick="jQuery(this).parent().remove();"></span>
				<span class="FO_pay_customer_id"> <?php esc_html_e('NUOVO!','flash_order'); ?> </span>
				<span class="FO_pay_customer_name"> name </span>
				<span class="FO_pay_customer_mail"> mail@gmail.com </span>
				<span class="FO_pay_customer_phone"> 123456789 </span>
			</div>

			<div class="FO_customers_container">
			</div>

		</div>
<?php /*
				<!-- <div class="FO_table_input" style="border:1px solid #ffffff6b;"> -->
				<!-- Prodotto Generico -->
					<!-- <input type="text" value="<?php esc_html_e('Special','flash_order');?>" style="flex-basis:100%;" onkeyup="jQuery(this).parent().find('.final_input').attr('name','[prod_generic]['+jQuery(this).val()+']');jQuery(this).parent().find('.foname').text(jQuery(this).val())">
					<div class="spinner-button-big" onclick="FO_add_value_to_input(-1.00,'.fo_target_discount_prod')">-1</div>
					<div class="spinner-button-big" onclick="jQuery(this).next().val(parseFloat(parseFloat(jQuery(this).next().val()) - 0.10).toFixed(2))">-</div>
						<input id="discount" class="fo_target_discount_prod" type="number" name="discount" value="0">
					<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseFloat(parseFloat(jQuery(this).prev().val()) + 0.10).toFixed(2))">+</div>
					<div class="spinner-button-big" onclick="FO_add_value_to_input(1.00,'.fo_target_discount_prod')">+1</div> -->
					<!-- <div class="FO_list_prod_summ" style="display:none;" foprice="">
						<div class="foname"><?php esc_html_e('Prodotto Generico','flash_order');?></div>
						<input class="final_input" type="hidden" name="[prod_generic][Prodotto Generico]" value="">
						<div class="FO_list_price"></div>
						<div class="FO_clear_target" onclick="FO_order_list_remove(jQuery(this).parent());jQuery(this).parent().remove();">X</div>
					</div> -->
					<!-- <div class="spinner-button-big" style="font-size:15px!important;" onclick="FO_order_discount_list(this,'.fo_target_discount_prod');"><?php esc_html_e('AGGIUNGI','flash_order');?></div> -->
				<!-- </div> -->

				<!-- <div class="fo_flex" style="border:1px solid #ffffff6b;">
					<span style="flex-basis:100%;">
						<?php esc_html_e('prezzo / sconto','flash_order');?>
					</span>
					<div class="spinner-button-big" onclick="FO_add_value_to_input(-1.00,'.fo_target_discount')">-1</div>
					<div class="spinner-button-big" onclick="jQuery(this).next().val(parseFloat(parseFloat(jQuery(this).next().val()) - 0.10).toFixed(2))">-</div>
						<input id="discount" class="fo_target_discount" type="number" name="discount"  value="0">
					<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseFloat(parseFloat(jQuery(this).prev().val()) + 0.10).toFixed(2))">+</div>
					<div class="spinner-button-big" onclick="FO_add_value_to_input(1.00,'.fo_target_discount')">+1</div>
					<div class="FO_list_prod_summ" style="display:none;" foprice="">
						<div class="foname"><?php echo '- prezzo / sconto -';?></div>
						<input class="final_input" type="hidden" name="[sconto][]" value="">
						<div class="FO_list_price"></div>
						<div class="FO_clear_target" onclick="FO_order_list_remove(jQuery(this).parent());jQuery(this).parent().remove();">X</div>
					</div>
					<div class="spinner-button-big" style="font-size:15px!important;" onclick="FO_order_discount_list(this,'.fo_target_discount');"><?php esc_html_e('AGGIUNGI','flash_order');?></div>
				</div> -->
*/ ?>
		<div class="fo_pay_footer fo_flex">
			<div class="" style="margin-right:auto;" onclick="">
				<strong> <?php esc_html_e('TOTALE: ','flash_order');?> </strong>
				<strong class="fo_pay_total">  </strong>
				<!-- <strong> <?php echo esc_attr(get_woocommerce_currency_symbol());?> </strong> -->
			</div>

			<?php
				if ( in_array( 'WooPrint/WooPrint.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				?>
					<div class="fo_button_thin fo_wooprint_preconto" onclick="WooPrint(this, 'fo-tab-pay');" style="color: yellow;">
						<span class="dashicons dashicons-printer"></span>
						<?php esc_html_e('Preconto','flash_order');?>
					</div>
				<?php 
				}
			?>

			<div class="fo_button_fix fo_pay_table_button" style="margin-left:auto;" onclick="FO_order_tab_pay_ajax()">
				<?php esc_html_e('PAGA','flash_order');?>
				<!-- FO_order_tab_pay_ajax() -->
			</div>
		</div>
	
	</div>
	<div class="Advanced_Card_background fo_pay_tab_show" style="display:none;"></div>
<?php
}











// add_filter('woocommerce_rest_check_permissions', 'my_woocommerce_rest_check_permissions', 90, 4);
// function my_woocommerce_rest_check_permissions($permission, $context, $object_id, $post_type) {
// 	// if($_GET['consumer_key']=='ck_2bdb98b40c89c0314a683f8eda705364563b7ed5' && $_GET['consumer_secret']=='cs_684407889915a2d4fe8a840cf4b12ddc1fd7f3f1') {
// 		return true;
// 	// }
// 	// return $permission;
// }

// wp_insert_term(
//   'New Category', // the term 
//   'product_cat', // the taxonomy
//   array(
//     'description'=> 'Category description',
//     'slug' => 'new-category'
//   )
// );


function FO_insert_macro_cat_ajax(){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}
	// if (isset($_POST['term_id']) && $_POST['term_id'] != '' ) {
	//     FO_update_post_ajax( $_POST );
	//     return;
	// }
	if (!isset($_POST['name']) || $_POST['name'] == '' ) {
	    return;
	}
	$term_id = wp_insert_term(
		sanitize_text_field(wp_unslash($_POST['name'])), // the term 
		'macro_categories', // the taxonomy
		// array(
		// 	'description'=> (isset($_POST['description']))?sanitize_text_field(wp_unslash($_POST['description'])):'',
		// 	'slug' => 'new-category'
		// )
	);
	wp_send_json(array(
		//'post' => $_POST,
		'term_id' => $term_id,
	));
	die();
}
add_action('wp_ajax_FO_insert_macro_cat_ajax', 'FO_insert_macro_cat_ajax');
add_action('wp_ajax_nopriv_FO_insert_macro_cat_ajax', 'FO_insert_macro_cat_ajax');

function FO_delete_macro_cat_ajax(){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}//_fononce_stat_update_nonce: jQuery('input[name="_fononce_stat_update_nonce"]').val(),

	if (isset($_POST['delete_id'])) {
		$post = wp_delete_term( (int)sanitize_text_field(wp_unslash($_POST['delete_id'])),'macro_categories' );
	} else { $post = ''; }

	wp_send_json(array(
		//'post' => $_POST,
		'post' => $post,
	));
	die();
}
add_action('wp_ajax_FO_delete_macro_cat_ajax', 'FO_delete_macro_cat_ajax');
add_action('wp_ajax_nopriv_FO_delete_macro_cat_ajax', 'FO_delete_macro_cat_ajax');





function FO_insert_post_ajax(){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}
	if (isset($_POST['post_id']) && $_POST['post_id'] != '' ) {
	    FO_update_post_ajax( $_POST );
	    return;
	}
	$post_id = wp_insert_post(array (
	    'post_type' => (isset($_POST['cpt']))?sanitize_text_field(wp_unslash($_POST['cpt'])):'',
	    'post_title' => (isset($_POST['title']))?sanitize_text_field(wp_unslash($_POST['title'])):'',
	    'post_content' => (isset($_POST['content']))?sanitize_text_field(wp_unslash($_POST['content'])):'',
	    'post_status' => 'publish',
	));
	if ($post_id) {
	    add_post_meta($post_id, 'from_user_id', get_current_user_id());
	    if (isset($_POST['fo_delivery_date'])) {
	    	add_post_meta($post_id, 'fo_delivery_date', sanitize_text_field(wp_unslash($_POST['fo_delivery_date'])));
	    }
	    if (isset($_POST['fo_catering_status'])) {
	    	add_post_meta($post_id, 'fo_catering_status', sanitize_text_field(wp_unslash($_POST['fo_catering_status'])));
	    }
	}
	wp_send_json(array(
		//'post' => $_POST,
		'post_id' => $post_id,
	));
	die();
}
add_action('wp_ajax_FO_insert_post_ajax', 'FO_insert_post_ajax');
add_action('wp_ajax_nopriv_FO_insert_post_ajax', 'FO_insert_post_ajax');


function FO_update_post_macro_cat_ajax( $_poste = '' ){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}
	if ($_poste != '') {
		$_POST = $_poste;
	}
	if (isset($_POST['macro_category_check']) && sanitize_text_field(wp_unslash($_POST['macro_category_check'])) != 'macro_categories' ) {
		return;
	}
	$post_id = (isset($_POST['post_id'])) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
	$macro_category = (isset($_POST['macro_category'])) ? sanitize_text_field(wp_unslash($_POST['macro_category'])) : '';

	$term_id = wp_set_post_terms( $post_id, $macro_category, 'macro_categories', false );

	wp_send_json(array(
		//'post' => $_POST,
		'term_id' => $term_id,
	));
	die();
}
add_action('wp_ajax_FO_update_post_macro_cat_ajax', 'FO_update_post_macro_cat_ajax');
add_action('wp_ajax_nopriv_FO_update_post_macro_cat_ajax', 'FO_update_post_macro_cat_ajax');


function FO_remove_post_macro_cat_ajax( $_poste = '' ){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}
	if ($_poste != '') {
		$_POST = $_poste;
	}
	if (isset($_POST['macro_category_check']) && sanitize_text_field(wp_unslash($_POST['macro_category_check'])) != 'macro_categories' ) {
		return;
	}
	$post_id = (isset($_POST['post_id'])) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
	$macro_category = (isset($_POST['macro_category'])) ? sanitize_text_field(wp_unslash($_POST['macro_category'])) : '';

	$term_id = wp_remove_object_terms( $post_id, $macro_category, 'macro_categories' );

	wp_send_json(array(
		//'post' => $_POST,
		'term_id' => $term_id,
	));
	die();
}
add_action('wp_ajax_FO_remove_post_macro_cat_ajax', 'FO_remove_post_macro_cat_ajax');
add_action('wp_ajax_nopriv_FO_remove_post_macro_cat_ajax', 'FO_remove_post_macro_cat_ajax');




function FO_update_post_ajax( $_poste = '' ){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}
	if ($_poste != '') {
		$_POST = $_poste;
	}
	$post_id = wp_update_post(array (
		'ID' => (isset($_POST['post_id']))?sanitize_text_field(wp_unslash($_POST['post_id'])):'',
	    'post_title' => (isset($_POST['title']))?sanitize_text_field(wp_unslash($_POST['title'])):'',
	    'post_content' => (isset($_POST['content']))?sanitize_text_field(wp_unslash($_POST['content'])):'',
	    'post_status' => 'publish',
	));
	if ($post_id) {
	    if (isset($_POST['fo_delivery_date'])) {
	    	update_post_meta($post_id, 'fo_delivery_date', sanitize_text_field(wp_unslash($_POST['fo_delivery_date'])));
	    }
	    if (isset($_POST['fo_catering_status'])) {
	    	update_post_meta($post_id, 'fo_catering_status', sanitize_text_field(wp_unslash($_POST['fo_catering_status'])));
	    }
	}
	wp_send_json(array(
		//'post' => $_POST,
		'post_id' => $post_id,
	));
	die();
}
add_action('wp_ajax_FO_update_post_ajax', 'FO_update_post_ajax');
add_action('wp_ajax_nopriv_FO_update_post_ajax', 'FO_update_post_ajax');

function FO_delete_post_ajax(){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}//_fononce_stat_update_nonce: jQuery('input[name="_fononce_stat_update_nonce"]').val(),

	if (isset($_POST['delete_id'])) {
		$post = wp_delete_post( (int)sanitize_text_field(wp_unslash($_POST['delete_id'])) );
	} else { $post = ''; }

	wp_send_json(array(
		//'post' => $_POST,
		'post' => $post,
	));
	die();
}
add_action('wp_ajax_FO_delete_post_ajax', 'FO_delete_post_ajax');
add_action('wp_ajax_nopriv_FO_delete_post_ajax', 'FO_delete_post_ajax');

function FO_trash_post_ajax(){
	if ( !isset($_POST['_fononce_insert_post_ajax_nonce']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_insert_post_ajax_nonce'])), 'FO_insert_post_ajax_nonce' ) ) {
		return;
	}//_fononce_stat_update_nonce: jQuery('input[name="_fononce_stat_update_nonce"]').val(),

	if (isset($_POST['delete_id'])) {
		$post = wp_trash_post( (int)sanitize_text_field(wp_unslash($_POST['delete_id'])) );
	} else { $post = ''; }

	wp_send_json(array(
		//'post' => $_POST,
		'post' => $post,
	));
	die();
}
add_action('wp_ajax_FO_trash_post_ajax', 'FO_trash_post_ajax');
add_action('wp_ajax_nopriv_FO_trash_post_ajax', 'FO_trash_post_ajax');





function FO_price( $number ){
	$return = $number;
	if ( strstr($number, '.') ) {
		if ( strlen( substr( $number, strpos($number,'.') ) )-1 == 1 ) {
			$return .= '0 '.get_woocommerce_currency_symbol();
		} elseif ( strlen( substr( $number, strpos($number,'.') ) )-1 == 2 ) {
			$return .= ' '.get_woocommerce_currency_symbol();
		}
	}else{
		if ( $number == '' ) {
			$return .= '0.00 '.get_woocommerce_currency_symbol();
		}else{
			$return .= '.00 '.get_woocommerce_currency_symbol();
		}
	}
	return $return;
}







function FO_get_translated_status( $status ) {
	if ( $status == 'processing' ) {
		$status = esc_html__('In Lavorazione','flash_order');
	} elseif ( $status == 'completed' ) {
		$status = esc_html__('Completato','flash_order');
	} elseif ( $status == 'cancelled' ) {
		$status = esc_html__('Cancellato','flash_order');
	} elseif ( $status == 'delivered' ) {
		$status = esc_html__('Consegnato','flash_order');
	} elseif ( $status == 'pending' ) {
		$status = esc_html__('In Attesa','flash_order');
	}else{}
	return $status;
}










if (isset( $_GET['post_type']) && $_GET['post_type'] === 'product' ) {//phpcs:ignore
	add_action('edit_form_before_permalink', 'FO_add_extra_field_to_post' );
	// add_action('quick_edit_custom_box', 'FO_add_extra_field_to_post' );
}else{
	if (isset( $_GET['post']) && get_post(sanitize_text_field(wp_unslash($_GET['post'])))->post_type === 'product') {//phpcs:ignore
		add_action('edit_form_before_permalink', 'FO_add_extra_field_to_post' );
	}
}

function FO_add_extra_field_to_post() {
	// if ( !isset($_POST['_fononce_product']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_product'])), 'FO_product_nonce' ) ) {
	// 	return;
	// }

	$short_title = array('');
	$slang_title = array('');
	if ( isset( $_GET['post'] ) ) {
		$post_id = sanitize_text_field(wp_unslash( $_GET['post']));
		$short_title = (get_post_meta( $post_id , 'short_title'))?get_post_meta($post_id , 'short_title'): array('');
		$slang_title = (get_post_meta( $post_id , 'slang_title'))?get_post_meta($post_id , 'slang_title'):array('');
	}
	$nonce = wp_create_nonce( 'FO_post_extra_field_nonce' );
    echo '<input type="hidden" id="_fononce_post_extra_field" name="_fononce_post_extra_field" value="'.esc_attr($nonce).'" />';
	?>
	<div id="titlediv">
		<div id="titlewrap">
			<input type="text" name="short_title" size="30" value="<?php echo esc_attr($short_title[0]);?>" id="shortTitle" spellcheck="true" autocomplete="off" placeholder="<?php esc_html_e('Nome breve', 'flash_order');?>">
			<input type="text" name="slang_title" size="30" value="<?php echo esc_attr($slang_title[0]);?>" id="slangTitle" spellcheck="true" autocomplete="off" placeholder="<?php esc_html_e('Nome slang', 'flash_order');?>">
		</div>
	</div>
	<?php
}

add_filter( 'manage_product_posts_columns', 'FO_short_slang_title_columns' );
function FO_short_slang_title_columns( $column_array ) {
	$column_array[ 'short_title' ] = 'Short Title';
	$column_array[ 'slang_title' ] = 'Slang Title';
	return $column_array;
}
// Populate our new columns with data
add_action( 'manage_posts_custom_column', 'FO_populate_both_columns', 10, 2 );
function FO_populate_both_columns( $column_name, $post_id ) {
	// if you have to populate more that one columns, use switch()
	switch( $column_name ) {
		case 'short_title': {
			$short_title = (get_post_meta(get_the_ID(),'short_title'))?get_post_meta(get_the_ID(),'short_title',true):'';
			echo esc_attr($short_title);
			break;
		}
		case 'slang_title': {
			$slang_title = (get_post_meta(get_the_ID(),'slang_title'))?get_post_meta(get_the_ID(),'slang_title',true):'';
			echo esc_attr($slang_title);
			break;
		}
	}
}
add_action( 'quick_edit_custom_box', 'FO_quick_edit_fields', 10, 2 );
function FO_quick_edit_fields( $column_name, $post_type ) {
	// global $post;
    $nonce = wp_create_nonce( 'FO_post_extra_field_nonce' );
    echo '<input type="hidden" id="_fononce_post_extra_field" name="_fononce_post_extra_field" value="'.esc_attr($nonce).'" />';
	switch( $column_name ) {
		case 'short_title': { 
			?>
				<fieldset class="inline-edit-col-left">
					<div id="titlediv">
						<div id="titlewrap">
							<span class="short_title"><?php esc_html_e('Nome breve', 'flash_order');?></span>
							<input type="text" name="short_title" size="30" value="" id="shortTitle" spellcheck="true" autocomplete="off" placeholder="<?php esc_html_e('Nome breve', 'flash_order');?>">
						</div>
					</div>
				</fieldset>
				<?php
			break;
		}
		case 'slang_title': { 
			?>
				<fieldset class="inline-edit-col-left">
					<div id="titlediv">
						<div id="titlewrap">
							<span class="slang_title"><?php esc_html_e('Nome slang', 'flash_order');?></span>
							<input type="text" name="slang_title" size="30" value="" id="slangTitle" spellcheck="true" autocomplete="off" placeholder="<?php esc_html_e('Nome slang', 'flash_order');?>">
						</div>
					</div>
				</fieldset>
			<?php
			break;
		}
	}
	?>
	<script type="text/javascript">
		jQuery( function( $ ){
			const wp_inline_edit_function = inlineEditPost.edit;
			// we overwrite the it with our own
			inlineEditPost.edit = function( post_id ) {
				// let's merge arguments of the original function
				wp_inline_edit_function.apply( this, arguments );
				// get the post ID from the argument
				if ( typeof( post_id ) == 'object' ) { // if it is object, get the ID number
					post_id = parseInt( this.getId( post_id ) );
				}
				// add rows to variables
				const edit_row = $( '#edit-' + post_id )
				const post_row = $( '#post-' + post_id )

				const short_title = $( '.short_title', post_row ).text()
				const slang_title = $( '.slang_title', post_row ).text()

				// populate the inputs with column data
				$(':input[name="short_title"]', edit_row ).val( short_title );
				$(':input[name="slang_title"]', edit_row ).val( slang_title );
			}
		});
	</script>
	<?php
}
// add_action( 'manage_product_posts_custom_column', 'FO_show_custom_field_quick_edit_data', 9999, 2 );
// function FO_show_custom_field_quick_edit_data( $column, $post_id ){
//     if ( 'short_title' == $column ) {
// 	    echo '<div>Short Title: <span id="cf_' . esc_attr($post_id) . '">' . get_post_meta( $post_id, 'short_title', true ) . '</span></div>';
// 	    wc_enqueue_js( "
// 	      $('#the-list').on('click', '.editinline', function() {
// 	         var post_id = $(this).closest('tr').attr('id');
// 	         post_id = post_id.replace('post-', '');
// 	         var custom_field = $('#cf_' + post_id).text();
// 	         $('input[name=\'short_title\']', '.inline-edit-row').val(custom_field);
// 	        });
// 	    " );
// 	}
// 	if ( 'slang_title' == $column ) {
// 	    echo '<div>Slang Title: <span id="cf_' . esc_attr($post_id) . '">' . get_post_meta( $post_id, 'slang_title', true ) . '</span></div>';
// 	    wc_enqueue_js( "
// 	      $('#the-list').on('click', '.editinline', function() {
// 	         var post_id = $(this).closest('tr').attr('id');
// 	         post_id = post_id.replace('post-', '');
// 	         var custom_field = $('#cf_' + post_id).text();
// 	         $('input[name=\'slang_title\']', '.inline-edit-row').val(custom_field);
// 	        });
// 	    " );
// 	}
// }

function FO_get_settings_head_manage_tables(){
$ajax_refresh_table_seconds = ( intval( FO_get_meta('ajax_refresh_table_seconds') ) < 500 ) ? 500 : intval( FO_get_meta('ajax_refresh_table_seconds'));
?>
	<div id="settings" style="display:none!important;">
	    <div id="ajax_refresh_table_seconds"> <?php echo esc_attr($ajax_refresh_table_seconds);?> </div>
	    <div id="fo_tab_go_order_text"> <?php esc_html_e( 'Sicuro di voler procedere con l\'Ordinazione?', 'flash_order' );?> </div>
	    <div id="fo_tab_clear_table_text"><?php esc_html_e('Sicuro di voler LIBERARE il tavolo?','flash_order');?></div>
	    <div id="fo_tab_clear_all_table_text"><?php esc_html_e('Sicuro di voler LIBERARE tutti i tavoli?','flash_order');?></div>
	    <div id="fo_tab_table_status_free_text"> <?php esc_html_e( 'Libero', 'flash_order' );?> </div>
	    <div id="fo_tab_table_status_wait_text"> <?php esc_html_e( 'Attesa', 'flash_order' );?> </div>
	    <div id="fo_tab_table_status_close_text"> <?php esc_html_e( 'Occupato', 'flash_order' );?> </div>

	    <div id="fo_tab_create_table_text"> <?php esc_html_e( 'Vuoi creare un nuovo tavolo chiamato: ', 'flash_order' );?> </div>
	    <div id="fo_tab_create_table_error_text"> <?php esc_html_e( 'Inserisci prima il nome del tavolo.', 'flash_order' );?> </div>
	    <div id="fo_tab_delete_table_text"> <?php esc_html_e( 'Vuoi ELIMINARE il tavolo chiamato: ', 'flash_order' );?> </div>
	    <div id="fo_tab_delete_table_error_text"> <?php esc_html_e( 'seleziona prima il tavolo da eliminare.', 'flash_order' );?> </div>

	    <div id="fo_tab_create_catering_text"> <?php esc_html_e( 'Vuoi creare un nuovo evento chiamato: ', 'flash_order' );?> </div>
	    <div id="fo_tab_refresh_catering_text"> <?php esc_html_e( 'Vuoi aggiornare l\'evento chiamato: ', 'flash_order' );?> </div>
	    <div id="fo_tab_create_catering_error_text"> <?php esc_html_e( 'Completa prima i campi obbligatori contrassegnati da: * .', 'flash_order' );?> </div>
	    <div id="fo_tab_create_catering_delete_text"> <?php esc_html_e( 'Vuoi ELIMINARE in modo definitivo questo evento, chiamato: ', 'flash_order' );?> </div>

	    <div id="fo_tab_new_customer_error_name_text"> <?php esc_html_e( 'Inserisci prima il Nome del Cliente!', 'flash_order' );?> </div>
	    <div id="fo_tab_new_customer_error_mail_phone_text"> <?php esc_html_e( 'Inserisci almeno la mail o il numero di telefono del Cliente!', 'flash_order' );?> </div>

	    <div id="fo_tab_change_category_to_product_text"> <?php esc_html_e( 'Sei sicuro di voler cambiare la categoria di questo prodotto?', 'flash_order' );?> </div>

	    <div id="fo_tab_create_macro_cat_text"> <?php esc_html_e( 'Vuoi creare una nuova macro categoria chiamata: ', 'flash_order' );?> </div>
	    <div id="fo_tab_create_macro_cat_error_text"> <?php esc_html_e( 'Inserisci prima il nome della categoria.', 'flash_order' );?> </div>
	    <div id="fo_tab_delete_macro_cat_text"> <?php esc_html_e( 'Vuoi ELIMINARE la categoria chiamata: ', 'flash_order' );?> </div>
	    <div id="fo_tab_delete_macro_cat_error_text"> <?php esc_html_e( 'seleziona prima la categoria da eliminare.', 'flash_order' );?> </div>


	</div>

	<style type="text/css">
	    .foTimeOutAnim {
	        animation: foerrcol 2s alternate infinite!important;
	    }
	</style>

<?php
}


































function FO_save_post_extra_field( $post_id, $post, $update ) {
	// Only want to set if this is a new post!
		// if ( $update ){
		// 	return;
		// }
	// Only set for post_type = post!
		// if ( 'post' !== $post->post_type ) {
		// 	return;
		// }
	if ( !isset($_POST['_fononce_post_extra_field']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_post_extra_field'])), 'FO_post_extra_field_nonce' ) ) {
		return;
	}//_fononce_post_extra_field: jQuery('input[name="_fononce_post_extra_field"]').val(),

	if ( isset( $_POST['short_title'] ) ) {
		$short_title = $_POST['short_title'];
		update_post_meta( $post_id, 'short_title', $short_title );
	}
	if ( isset( $_POST['slang_title'] ) ) {
		$slang_title = $_POST['slang_title'];
		update_post_meta( $post_id, 'slang_title', $slang_title );
	}
}
add_action('save_post','FO_save_post_extra_field',10,3);





function isNumber($s) { 
	$ss = str_split($s);
    for ($i = 0; $i < strlen($s); $i++) 
        if (is_numeric($s[$i]) == false) {
            return false; 
        }
    return true; 
} 









/**
 * Function for `woocommerce_new_order` action-hook.
 * 
 * @param int       $order_id Order ID.
 * @param \WC_Order $order    Order object.
 *
 * @return void
 */
function FO_add_products_to_order( $order_id, $order ) {
	if ( $order->post_type === 'shop_order' ) {
		$fin_prod = array();
		$order = wc_get_order( $order_id );
		$meta_data = get_post_meta( $order_id );
		foreach( $meta_data as $key => $value ){
			if ( str_contains( (string)$key, 'Product-' ) ) {
				$fin_prod[$key] = explode( ',', $value[0] );
			}
		}
		foreach( $fin_prod as $k => $v ){
			$order->add_product( wc_get_product( $v[0] ), $v[1] );
		}
	}
}
//add_action('wp_insert_post','FO_add_products_to_order', 10, 2);
//add_action('wp_ajax_FO_add_products_to_order', 'FO_add_products_to_order');
//add_action('wp_ajax_nopriv_FO_add_products_to_order', 'FO_add_products_to_order');

function FO_get_order_info_button_tab ( $order ){
	?>
	<button onclick="jQuery(this).next().toggle();"><?php echo esc_html__( 'INFO', 'flash_order' ); ?></button>
	<div class="flash_card" style="display:none;" onclick="jQuery(this).css('display', 'none')">

		<div class="title" style="font-size:30px;color:var(--fo-scnd-color);"><?php echo esc_html__( 'ORDINE', 'flash_order' ).' #'.esc_attr($order->get_id()); ?>
		</div>

		<div class="title"><?php echo esc_html__( 'FATTURAZIONE', 'flash_order' ); ?>
			<p><?php echo esc_attr($order->get_billing_first_name()).' '.esc_attr($order->get_billing_last_name()); ?></p>
			<p><?php echo esc_attr($order->get_billing_company()); ?></p>
			<p><?php echo esc_attr($order->get_billing_address_1()); ?></p>
			<p><?php echo esc_attr($order->get_billing_address_2()); ?></p>
			<p><?php echo esc_attr($order->get_billing_city()).' '.esc_attr($order->get_billing_state()); ?></p>
			<p><?php echo esc_attr($order->get_billing_postcode()).' '.esc_attr($order->get_billing_country()); ?></p>
		</div>
		<div class="title"><?php echo esc_html__( 'SPEDIZIONE', 'flash_order' ); ?>
			<p><?php echo esc_attr($order->get_shipping_first_name()).' '.esc_attr($order->get_shipping_last_name()); ?></p>
			<p><?php echo esc_attr($order->get_shipping_company()); ?></p>
			<p><?php echo esc_attr($order->get_shipping_address_1()); ?></p>
			<p><?php echo esc_attr($order->get_shipping_address_2()); ?></p>
			<p><?php echo esc_attr($order->get_shipping_city()).' '.esc_attr($order->get_shipping_state()); ?></p>
			<p><?php echo esc_attr($order->get_shipping_postcode()).' '.esc_attr($order->get_shipping_country()); ?></p>
		</div>
		<div class="title"><?php echo esc_html__( 'CONTATTO', 'flash_order' ); ?>
			<p><?php echo esc_attr($order->get_billing_email()); ?></p>
			<p><?php echo esc_attr($order->get_billing_phone()); ?></p>
		</div>
	</div>
	<?php
}
function FO_get_print_receipt ( $order ){
	?>
	<button type="button" onClick="window.print()"> <?php echo esc_html__( 'Stampa scontrino', 'flash_order' ); ?> </button>
	<?php
}



function FO_get_flash_orders_visualize_settings() {
	$visualize = array();
	$settings = FO_get_meta_by_assoc_id( 'setting', 'OBJECT' );
	foreach ( $settings as $key => $val) {
	if ($val->meta_key == 'flash_orders_table_visualize_id' && $val->meta_value == 'yes') { $visualize['id'] = true;} 
	if ($val->meta_key == 'flash_orders_table_visualize_name' && $val->meta_value == 'yes') { $visualize['name'] = true;} 
	if ($val->meta_key == 'flash_orders_table_visualize_image' && $val->meta_value == 'yes') { $visualize['image'] = true;} 
	if ($val->meta_key == 'flash_orders_table_visualize_warehouse' && $val->meta_value == 'yes') { $visualize['warehouse'] = true;} 
	if ($val->meta_key == 'flash_orders_table_visualize_note' && $val->meta_value == 'yes') { $visualize['note'] = true;} 
	if ($val->meta_key == 'flash_orders_table_visualize_actions' && $val->meta_value == 'yes') { $visualize['actions'] = true;}
	} 
	return $visualize;
}

function FO_get_manage_orders_visualize_settings() {
	$visualize = array();
	$settings = FO_get_meta_by_assoc_id( 'setting', 'OBJECT' );
	foreach ( $settings as $key => $val) {
	if ($val->meta_key == 'manage_orders_table_visualize_id' && $val->meta_value == 'yes') { $visualize['id'] = true;} 
	if ($val->meta_key == 'manage_orders_table_visualize_name' && $val->meta_value == 'yes') { $visualize['name'] = true;} 
	if ($val->meta_key == 'manage_orders_table_visualize_products' && $val->meta_value == 'yes') { $visualize['products'] = true;} 
	if ($val->meta_key == 'manage_orders_table_visualize_info' && $val->meta_value == 'yes') { $visualize['info'] = true;} 
	if ($val->meta_key == 'manage_orders_table_visualize_status' && $val->meta_value == 'yes') { $visualize['status'] = true;} 
	if ($val->meta_key == 'manage_orders_table_visualize_actions' && $val->meta_value == 'yes') { $visualize['actions'] = true;}
	if ($val->meta_key == 'manage_orders_table_visualize_totals' && $val->meta_value == 'yes') { $visualize['totals'] = true;} 
	} 
	return $visualize;
}



function FO_manage_order_add_order( $order, $visualize = array() ){
	$order = new WC_Order($order->get_id()); 
	$visualize = wp_parse_args( FO_get_manage_orders_visualize_settings(), $visualize );

	if ($order->get_status() == 'pending') {$back_status = 'FOstatus_pending';
	} elseif ($order->get_status() == 'processing') {$back_status = 'FOstatus_processing';
	} elseif ($order->get_status() == 'failed') {$back_status = 'FOstatus_failed';
	} elseif ($order->get_status() == 'cancelled') {$back_status = 'FOstatus_cancelled';
	} elseif ($order->get_status() == 'refunded') {$back_status = 'FOstatus_refunded';
	} elseif ($order->get_status() == 'completed') {$back_status = 'FOstatus_completed';
	} else { $back_status = ''; }

if ( isset($visualize['div']) && $visualize['div'] ) {
	$_div_class = ' order-div-class';
}else{
	$_div_class = '';
}
	$string = '';
	$string .= '<tr orderid="'.$order->get_id().'" orderdata="'.$order->get_date_modified().'" orderstatus="'.$order->get_status().'" ordertype="'.$order->get_meta('delivery_type').'" class="'.$back_status.$_div_class.'" style="position:relative;">';

	if ( isset($visualize['id']) && $visualize['id'] ) {
		$string .= '<td identify="ID">'.$order->get_id().'</td>';
	}
	if ( isset($visualize['name']) && $visualize['name'] ) {
		$string .= '<td identify="name">';
			$string .= $order->get_billing_first_name().' '.$order->get_billing_last_name();
		$string .= '</td>';
	}
	$meta_data = get_post_meta( $order->get_id() );
	$Front_Post = array();
	foreach ($meta_data as $key => $value) {
		if ( str_contains( (string)$key, 'info-' )) {
			$index_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT); 
			$Front_Post[$index_var] = $value;
		}
	}

	if ( isset($visualize['products']) && $visualize['products'] ) {
		$string .= '<td identify="products" class="FOmanOrderImg">';
		// echo FO_get_product_image_and_ingredient( $order->get_id() );
		if ( $order->get_created_via() == 'checkout' ) {
			foreach ( $order->get_items() as $item_id => $item ) {
				$prod_ing = array(); $i = 1;
				$products = $item->get_product();
					$short_title = (get_post_meta($products->get_id(),'short_title'))?get_post_meta($products->get_id(),'short_title')[0]:$products->get_name();
					$slang_title = (get_post_meta($products->get_id(),'slang_title'))?get_post_meta($products->get_id(),'slang_title')[0]:$short_title;
				$product_note = '';
				$Ingredienti = get_the_terms( $item->get_product_id(), 'Ingredienti');
				$default_ing = array(); $p = 1;
			// FO_debug($Ingredienti);
				if (is_array($Ingredienti)) {
					foreach ( $Ingredienti as $key => $value) {
						$default_ing[$p] = $value->term_id;
						$p++;
					} 
				}
				$class = '';
				if ( array_diff_assoc( $prod_ing, $default_ing ) != null || $product_note != '' ) {
					$class = 'FOmodified';
				}
				$string .= '<div foprodid="'.$products->get_id().'" foprodtot="'.number_format( $products->get_price(), 2 ).get_woocommerce_currency_symbol().'" class="relative">';
				$string .= '<div class="'.$class.'"  onclick="jQuery(this).next().slideToggle()">';
					$string .= wp_kses_post($products->get_image());
					$string .= '<span class="FO_id_info">#'.$item->get_id().'</span>';
	//-----------------				
						$string .= '<div class="FO_prod_name_manage">';
							$string .= $products->get_name();
							// echo $slang_title;
							if ( $products->get_type() == 'variation' ) {
								$string .= "  |>".implode(", ", $products->get_attributes() );
							}
						$string .= '</div>';

					$string .= '<span class="FO_quantity_info">'.$item->get_quantity().'</span>';
				$string .= '</div>';
				$string .= '<div class="FOimgProdInfo" style="display:none;">';
					$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
					$string .= '<div class="FO_prod_name">';
						$string .= $item->get_name();

					$string .= '</div>';
					$string .= '<div class="FO_prod_img">';
						$string .= wp_kses_post($products->get_image());
					$string .= '</div>';
				
				if ( $class != '' ) {
					$string .= '<div class="FO_prod_ingred">';
						$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
					$string .= '</div>';
					if (count($prod_ing) > 0 ) {
						foreach ($prod_ing as $key => $value) {
							$clssmod = ''; if ( !in_array( $value, $default_ing ) ) {
								$clssmod = 'FOstatus_modified';
							}
							$string .= '<div class="FOIngredProdTab '.$clssmod.'">';
								$string .= get_term( $value, 'Ingredienti' )->name;
							$string .= '</div>';
						}
					}
				} else{
					if ( count($default_ing) == 0 ) {
						$string .= '<div class="FO_prod_ingred">';
							$string .= esc_html__( 'il prodotto non ha nessun ingrediente associato ad esso', 'flash_order' );
						$string .= '</div>';
					} else{
						$string .= '<div class="FO_prod_ingred">';
							$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
						$string .= '</div>';
						foreach ($default_ing as $key => $value) {
							$string .= '<div class="FOIngredProdTab">';
								$string .= get_term( $value, 'Ingredienti' )->name;
							$string .= '</div>';
						}
					}
				}
				if ( $product_note != '' ) {
					$string .= '<div class="FO_prod_note">';
						$string .= esc_html__( 'Note prodotto:', 'flash_order' );
					$string .= '</div>';
					$string .= '<div style="width:100%;justify-content:center;">';
						$string .= $product_note;
					$string .= '</div>';
				}
				$string .= '</div>';
				$string .= '</div>';
			}
		} else{
			if ( $order->get_created_via() == 'ajax' || $order->get_created_via() == 'lista_ajax'|| $order->get_created_via() != 'checkout' ) {
				$meta_array = FO_extract_meta_array($meta_data);
				// FO_debug( $meta_array  );
				foreach ( $meta_array as $meta_index => $meta_elem ){
					$product_id = (array_key_exists('id', $meta_elem))?$meta_elem['id']:'';
					$product_quantity = (array_key_exists('qty', $meta_elem))?$meta_elem['qty']:'';
					$product_note = (array_key_exists('note', $meta_elem))?$meta_elem['note']:'';
					$prod_ing = (array_key_exists('ingredient', $meta_elem))?$meta_elem['ingredient']:array();

					$varianti = (array_key_exists('variant', $meta_elem))?$meta_elem['variant']:array();
					$temperature = (array_key_exists('temperature', $meta_elem))?$meta_elem['temperature']:'';

					if ($temperature!='') {
						$temper_id = get_term_by( 'name', $temperature, 'Temperature' )->term_id;
						$tax_img = get_term_meta($temper_id, 'taxonomy_image'); 
					}
					
					$Ingredienti = get_the_terms($product_id,'Ingredienti');
					$default_ing = array(); 
					if (is_array($Ingredienti)) { $p = 1;
						foreach ( $Ingredienti as $key => $value) {
							$default_ing[$p] = $value->term_id;
							$p++;
						}
					}
					// FO_debug( $product_note  );
					$products = wc_get_product( $product_id );
					if ($products == false||$products == null) {continue;}
					$short_title = ( FOcheck(get_post_meta($products->get_id(),'short_title') ) && get_post_meta($products->get_id(),'short_title')[0]!='')?get_post_meta($products->get_id(),'short_title')[0]:$products->get_name();
					$slang_title = ( FOcheck(get_post_meta($products->get_id(),'slang_title') ) && get_post_meta($products->get_id(),'slang_title')[0]!='' )?get_post_meta($products->get_id(),'slang_title')[0]:$short_title;
					if ( FOcheck( array_diff_assoc( $prod_ing, $default_ing ) ) || $product_note != '' || count($varianti) || $products->get_type() == 'variation' ) {
						$class = 'FOmodified';
					}else{$class = '';}

					$string .= '<div foprodid="'.$products->get_id().'" foprodtot="'.$products->get_price().get_woocommerce_currency_symbol().'" class="relative">';
					$string .= '<div class="'.$class.'"  onclick="jQuery(this).next().slideToggle()">';
						$string .= wp_kses_post($products->get_image());
						$string .= '<span class="FO_id_info">#'.$products->get_id().'</span>';
						if (count($varianti) || $products->get_type() == 'variation') {
							$string .= '<span class="FO_id_variant" title="'.count($varianti).'"><img src="'.esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/cycle.webp"></span>';
						}
						$string .= '<div class="FO_prod_name_manage">';
							$string .= $slang_title;
							if ( $products->get_type() == 'variation' ) {
								$string .= "  |>".implode(", ", $products->get_attributes() );
							}
						$string .= '</div>';
						if ($temperature!='') {
							$string .= '<span class="FO_id_temperature" title="'.$temperature.'">';
								$string .= '<img src="'.esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/thermometer2.webp">';
								if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
									$string .= '<img class="fotemper_image"width="20"height="20"src="'.$tax_img[0].'">';
								}
							$string .= '</span>';
						}
						$string .= '<span class="FO_quantity_info">'.$product_quantity.'</span>';
					$string .= '</div>';
					$string .= '<div class="FOimgProdInfo" style="display:none;">';
						$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
						$string .= '<div class="FO_prod_name">';
							$string .= $slang_title;
							if ( $products->get_type() == 'variation' ) {
								$string .= "  |>".implode(", ", $products->get_attributes() );
							}
						$string .= '</div>';
						$string .= '<div class="FO_prod_img">';
							$string .= wp_kses_post($products->get_image());
						$string .= '</div>';
						
						if (count($varianti)) {
							$string .= '<div class="FO_prod_variant">';
								$string .= esc_html__( 'le varianti:', 'flash_order' );
							$string .= '</div>';
							$string .= '<div class="FOAdvVariantProdTab">';
							foreach ($varianti as $key => $value) {
								$string .= '<div class="FO_variant" title="'.$key.'">';
									$string .= '<p>'.$key.': </p>';
									$string .= '<p> '.$value.'</p>';
								$string .= '</div>';
							}
							$string .= '</div>';
						}

						if ($temperature!='') {
							$string .= '<div class="FO_prod_temperature" style="width:100%;justify-content:center;">';
								$string .= '<div class="FO_prod_temp">';
									$string .= esc_html__( 'Temperatura:', 'flash_order' );
								$string .= '</div>';

								$string .= '<img src="'.esc_url( get_home_url() ).'/wp-content/plugins/flash_order/includes/img/thermometer2.webp">';

									if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
										$string .= '<img class="fotemper_image"width="20"height="20"src="'.$tax_img[0].'">';
									}
								$string .= '<span class="FO_temperature" title="'.$temperature.'">'.$temperature.'</span>';
							$string .= '</div>';
						}

					if ( $class != '' ) {
						$string .= '<div class="FO_prod_ingred">';
							$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
						$string .= '</div>';
						if (count($prod_ing) > 0 ) {
							// echo FO_get_tax_cloud_from_id_ajax( $prod_ing, 'Ingredienti', $products->get_id() );
							foreach ($prod_ing as $key => $value) {
								$clssmod = ''; if ( !in_array( $value, $default_ing ) ) {
									$clssmod = 'FOstatus_modified';
								}
								$value = get_term( $value, 'Ingredienti' );
								$tax_img = get_term_meta($value->term_id, 'taxonomy_image'); 
								$string .= '<div class="FOAdvIngredProdTab '.$clssmod.'">';
									$string .= '<p>'.$value->name.'</p>';
									if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
										$string .= '<img class="fotax_image"width="30"height="30"src="'.$tax_img[0].'">';
									}
								$string .= '</div>';
							}
						}
					} else{
						if ( count($default_ing) == 0 ) {
							$string .= '<div class="FO_prod_ingred">';
								$string .= esc_html__( 'il prodotto non ha nessun ingrediente associato ad esso', 'flash_order' );
							$string .= '</div>';
						} else{
							$string .= '<div class="FO_prod_ingred">';
								$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
							$string .= '</div>';
							foreach ($default_ing as $key => $value) {
								if ( FOcheck($value) ) {
									$ing_name = (FOcheck(get_term($value,'Ingredienti')))?get_term($value,'Ingredienti')->name:'';
									$tax_img = get_term_meta($value, 'taxonomy_image'); 

									$string .= '<div class="FOAdvIngredProdTab">';
										$string .= '<p>'.$ing_name.'</p>';
										// $string .= $ing_name;
										if ( FOcheck($tax_img) && isset($tax_img[0]) && $tax_img[0] != '' ) {
											$string .= '<img class="fotax_image"width="30"height="30"src="'.$tax_img[0].'">';
										}
									$string .= '</div>';
								}
							}
						}
					}
					if ( is_string($product_note) && $product_note != '' ) {
						$string .= '<div class="FO_prod_note">';
							$string .= esc_html__( 'Note prodotto:', 'flash_order' );
						$string .= '</div>';
						$string .= '<div style="width:100%;justify-content:center;">';
							$string .= $product_note;
						$string .= '</div>';
					}
					$string .= '</div>';
					$string .= '</div>';
				}
			} else{
				$product_note = '';
				foreach ( $Front_Post as $item_id => $it ) {
				foreach ( $it as $kk => $vv ) {
					// FO_debug($vv);
					$item = json_decode($vv);
				if ( is_string($item) || $item == null ){continue;}

					$prod_ing = array(); $i = 1;
						foreach ( $item as $keykey => $valval ) {
							$product_id = null;
							if ( is_numeric( $keykey)) {
								$product_id = $keykey;
								$product_quantity = $valval;
							}
							if ( str_contains( (string)$keykey, 'Ingredienti' ) ) {
								foreach ((array)$valval as $inkey => $invalue) {
									// FO_debug($invalue);
									if (is_string( $invalue ) ) {
										$prod_ing[$i] = get_term_by( 'name', $invalue, 'Ingredienti' )->term_id;
										$i++;
									} else { continue;
										$prod_ing[$i] = get_term_by( 'name', '', 'Ingredienti' )->term_id;
										$i++;
									}
								}
							}
							if ( str_contains( (string)$keykey, 'note' ) ) {
								$product_note = (array)$valval;
							}
						}
					$product_id = ($product_id != null ) ? $product_id: '';
					$products = wc_get_product( $product_id );

					if ($products == false||$products == null) {continue;}

					$Ingredienti = get_the_terms($product_id, 'Ingredienti');
					$default_ing = array(); $p = 1;
					if (is_array($Ingredienti)) {
						foreach ( $Ingredienti as $key => $value) {
							$default_ing[$p] = $value->term_id;
							$p++;
						} 
					}
					$class = '';
					if ( array_diff_assoc( $prod_ing, $default_ing ) != null || $product_note != '' ) {
						$class = 'FOmodified';
					}
					
					$string .= '<div foprodid="'.$products->get_id().'" foprodtot="'.$products->get_price().get_woocommerce_currency_symbol().'" class="relative">';
						$string .= '<div class="'.$class.'"  onclick="jQuery(this).next().slideToggle()">';
							$string .= wp_kses_post($products->get_image());
							$string .= '<span class="FO_id_info">#'.$products->get_id().'</span>';
							$string .= '<span class="FO_quantity_info">'.$product_quantity.'</span>';
						$string .= '</div>';
						$string .= '<div class="FOimgProdInfo" style="display:none;">';
							$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
							$string .= '<div class="FO_prod_name">';
								$string .= $products->get_name();
							$string .= '</div>';
							$string .= '<div class="FO_prod_img">';
								$string .= wp_kses_post($products->get_image());
							$string .= '</div>';
				
						if ( $class != '' ) {
							$string .= '<div class="FO_prod_ingred">';
								$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
							$string .= '</div>';
							if (count($prod_ing) > 0 ) {
								foreach ($prod_ing as $key => $value) {
									$clssmod = ''; if ( !in_array( $value, $default_ing ) ) {
										$clssmod = 'FOstatus_modified';
									}
									$string .= '<div class="FOIngredProdTab '.$clssmod.'">';
										$string .= get_term( $value, 'Ingredienti' )->name;
									$string .= '</div>';
								}
							}
						} else{
							if ( count($default_ing) == 0 ) {
								$string .= '<div class="FO_prod_ingred">';
									$string .= esc_html__( 'il prodotto non ha nessun ingrediente associato ad esso', 'flash_order' );
								$string .= '</div>';
							} else{
								$string .= '<div class="FO_prod_ingred">';
									$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
								$string .= '</div>';
								foreach ($default_ing as $key => $value) {
									$string .= '<div class="FOIngredProdTab">';
										$string .= get_term( $value, 'Ingredienti' )->name;
									$string .= '</div>';
								}
							}
						}
						if ( is_string($product_note) && $product_note != '' ) {
							$string .= '<div class="FO_prod_note">';
								$string .= esc_html__( 'Note prodotto:', 'flash_order' );
							$string .= '</div>';
							$string .= '<div style="width:100%;justify-content:center;">';
								$string .= $product_note;
							$string .= '</div>';
						}
						$string .= '</div>';
					$string .= '</div>';
				}
				}
			}
// fee -------------------------------------
			foreach ( $order->get_fees() as $item_fee ) {
				$fee_name = $item_fee->get_name();
				$fee_total = $item_fee->get_total();

				$string .= '<div foprodid="'.$fee_name.'" foprodtot="'.$fee_total.'" class="relative">';
					$string .= '<div onclick="jQuery(this).next().slideToggle()">';
							$string .= '<div class="fo_fake_image_fee">'.esc_html__( 'Special', 'flash_order' ).'</div>';
						$string .= '<div class="FO_prod_name_manage">';
							$string .= $fee_name;
						$string .= '</div>';
						
						$string .= '<span class="FO_quantity_info">'.FO_price($fee_total).'</span>';
					$string .= '</div>';

					$string .= '<div class="FOimgProdInfo" style="display:none;">';
						$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';

						$string .= '<div class="FO_prod_name">';
							$string .= $fee_name;
						$string .= '</div>';
						$string .= '<div class="FO_prod_img">';
							$string .= '<div class="fo_fake_image_fee">'.esc_html__( 'Special', 'flash_order' ).'</div>';
						$string .= '</div>';
						$string .= '<div class="FO_prod_ingred">';
							$string .= FO_price($fee_total);
						$string .= '</div>';
					$string .= '</div>';
				$string .= '</div>';
				
			}

		} 
		$string .= '</td>';
	}
	if ( isset($visualize['info']) && $visualize['info'] ) {
		$string .= '<td identify="info">';
		$del_type = '';
		$tab_num_data = '';
		$table_surname = '';
		if ($order->get_meta('delivery_type') != null && $order->get_meta('delivery_type') != '') {
			if ( $order->get_meta('delivery_type') == 'table' ) {
				$del_type = esc_html__( 'Tavolo', 'flash_order' );
				$tab_num_data = $order->get_meta('Table');
				$table_surname = $order->get_meta('table_surname');
			} elseif ($order->get_meta('delivery_type') == 'pickup') {
				$del_type = esc_html__( 'Ritiro', 'flash_order' );
			} elseif ($order->get_meta('delivery_type') == 'delivery') {
				$del_type = esc_html__( 'Consegna', 'flash_order' );
			} else{
				$del_type = '';
			}
		}
		$string .= '<div fotarget="ordertype" title="'.esc_html__( 'Tipo di ordine', 'flash_order' ).'">';
		if ($order->get_meta('Table_cpt')!= '') {
			$string .= $order->get_meta('Table_cpt');
			$separator_1 = ' - ';
		} else{	$separator_1 = '';
			// $order = new WC_Order($order->get_id()); 
		}
		if ($tab_num_data != '0' ) {
			$string .= $separator_1.$del_type;
			$string .= ' '.$tab_num_data;
			$string .= ' '.$table_surname;
		}
		$string .= '</div>';
		$string .= FO_get_order_info_button_tab_string($order->get_id());
//--------------------------------------
		$string .= '</td>';
	}
	if ( isset($visualize['status']) && $visualize['status'] ) {
		$string .= '<td identify="status" class="status '.$back_status.'" style="">';
			$string .= '<p>'.FO_status_titled( $order->get_status() ).'</p>';
			$string .= '<button statustarget onclick="jQuery(this).next().slideToggle();" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'" class="relative">';
				$string .= FO_status_titled( $order->get_status() );
			$string .= '</button>';
			$string .= FO_get_status_changer( $order );
	if ( FO_get_meta( 'visualize_orders_timer') == 'yes' ) {
			$string .= '<div identify="fotimer" class="fotimer fo_status_timer_1" style="display:none">';
				$string .= 'timer';
			$string .= '</div>';
	}
		$string .= '</td>';
	}
	if ( isset($visualize['actions']) && $visualize['actions'] ) {
		$string .= '<td identify="actions">';
			$string .= '<div class="FOloadingCardPublic" style="display:none;">';
				$string .= '<span style="animation: fospin 1s infinite;font-size:70px;width:70px;height:70px;" class="dashicons dashicons-update"></span>';
			$string .= '</div>';
		if ( !isset($visualize['status']) ) {
			$string .= '<button statustarget onclick="jQuery(this).next().slideToggle();" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'" class="relative">';
				$string .= FO_status_titled( $order->get_status() );
			$string .= '</button>';
			$string .= FO_get_status_changer( $order );
		}

		if ( in_array( 'WooPrint/WooPrint.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if ( function_exists('WOP_print_receipt') ) {
				$string .= WOP_print_receipt('Stampa');
			}
		}
		if ( FO_get_meta( 'visualize_orders_timer') == 'yes' ) {
			$string .= '<div identify="fotimer" class="fotimer fo_status_timer_1" style="display:none">';
				$string .= 'timer';
			$string .= '</div>';
		}
		$string .= '</td>';
	}
	if ( isset($visualize['totals']) && $visualize['totals'] ) {
		$string .= '<td identify="totals">'; 
			if ( $order->get_subtotal() != 0 ) {
				$string .= FO_price( $order->get_subtotal() ).' </br>';
			}
			if ( $order->get_total_fees() != 0 ) {
				$string .= FO_price( $order->get_total_fees() ).' </br>';
			}
			if ( $order->get_total() != 0 ) {
				$string .= 'tot '.FO_price( $order->get_total() ).' </br>';
			} else{
				if ($order->get_total_fees() != 0) {
					$string .= 'tot '.FO_price( $order->get_total() ).' </br>';
				} else{
					$string .= 'tot '.FO_price( $order->get_subtotal() ).' </br>';
				}
			}
		$string .= '</td>';
	}
	$string .= '</tr>';
	//FO_get_order_info_button_tab ( $order ); 
	//FO_get_print_receipt ( $order ); 
	return $string;
}
function FO_status_titled( $status ){
	if ( $status == 'pending') {
		$return = esc_html__('nuovo','flash_order');
	} elseif( $status == 'processing' ){
		$return = esc_html__('in lavorazione','flash_order');
	} elseif( $status == 'cancelled' ){
		$return = esc_html__('cancellato','flash_order');
	} elseif( $status == 'refunded' ){
		$return = esc_html__('rimborsato','flash_order');
	} elseif( $status == 'completed' ){
		$return = esc_html__('completato','flash_order');
	}else{ $return = ''; }
	return $return;
}
function FO_extract_meta_array( $meta ){
	$array = array();$i = 1;
	if (!is_array($meta)) {
		// $order->get_meta('delivery_type');
	}
	foreach ($meta as $key => $value) {
		if ( str_contains( (string)$key, '{' ) ) {
			$index = substr( (string)$key, 1, strpos((string)$key,'}')-1 );
			if ( str_contains( (string)$key, 'index' ) ) {
				$array[$index][substr( (string)$key, strpos((string)$key,'-')+1 )] = $value[0];
				$array[$index]['id'] = substr( (string)$key, strpos((string)$key,'-')+1 );
				$array[$index]['qty'] = $value[0];
			}
			if ( str_contains( (string)$key, 'note' ) ) {
				if (is_array($value)) {
					$array[$index]['note'] = $value[0];
				}else{
					$array[$index]['note'] = $value;
				}
			}
			if ( str_contains( (string)$key, 'searched' ) ) {
				$array[$index]['searched'] = $value;
			}
			// if (str_contains( (string)$key, 'ingredient' )){$array[$index]['ingredient'][substr((string)$key, strpos((string)$key,'ingredient-')+11)] = substr($value[0], strpos($value[0], '| ')+2);}
			if ( str_contains( (string)$key, 'ingredient' ) ) {
				$array[$index]['ingredient'][$i] = substr( (string)$key, strpos((string)$key,'ingredient-')+11 );
				$i++;
			}
			if ( str_contains( (string)$key, 'temperature' ) ) {
				$array[$index]['temperature'] = substr($value[0],strpos($value[0],'| ')+2);
			}
			if ( str_contains( (string)$key, 'variant' ) ) {
				$array[$index]['variant'][substr((string)$key,strpos((string)$key,'variant-')+8)] = substr($value[0],strpos($value[0],'| ')+2);
			}
			if ( str_contains( (string)$key, 'price' ) ) {
				$array[$index]['total'] = $value[0];
			}
			
			// $array[$index]['total'] = $value[0];
		}
	}
	return $array;
}


function FO_get_product_image_and_ingredient( $order_id ){
	$order = new WC_Order($order_id); 
		$meta_data = get_post_meta( $order->get_id() );
	$Front_Post = array();
	$string = '';

	foreach ($meta_data as $key => $value) {
		if ( str_contains( (string)$key, 'info-' )) {
			$index_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT); 
			$Front_Post[$index_var] = $value;
		}
	}
	if ( $order->get_created_via() == 'checkout' ) {
		foreach ( $order->get_items() as $item_id => $item ) {
			// FO_debug($item);
			$prod_ing = array(); $i = 1;
			$products = $item->get_product();
			$product_note = '';
			$Ingredienti = get_the_terms( $item->get_product_id(), 'Ingredienti');
			$default_ing = array(); $p = 1;
	// FO_debug($Ingredienti);
			if (is_array($Ingredienti)) {
				foreach ( $Ingredienti as $key => $value) {
					$default_ing[$p] = $value->term_id;
					$p++;
				} 
			}
			$class = '';
			if ( array_diff_assoc( $prod_ing, $default_ing ) != null || $product_note != '' ) {
				$class = 'FOmodified';
			}
			$string .= '<div class="relative">';
			$string .= '<div class="'.$class.'"  onclick="jQuery(this).next().slideToggle()">';
				$string .= wp_kses_post($products->get_image());
				$string .= '<span class="FO_quantity_info">'.$item->get_quantity().'</span>';
			$string .= '</div>';
			$string .= '<div class="FOimgProdInfo" style="display:none;">';
				$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
				$string .= '<div style="width:100%;justify-content:center;">';
					$string .= $item->get_name();
				$string .= '</div>';
				$string .= '<div style="width:100%;justify-content:center;">';
					$string .= wp_kses_post($products->get_image());
				$string .= '</div>';
			
			if ( $class != '' ) {
				$string .= '<div class="FO_prod_ingred">';
					$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
				$string .= '</div>';
				if (count($prod_ing) > 0 ) {
					foreach ($prod_ing as $key => $value) {
						$string .= '<div class="FOIngredProdTab">';
							$string .= get_term( $value, 'Ingredienti' )->name;
						$string .= '</div>';
					}
				}
			} else{
				if ( count($default_ing) == 0 ) {
					$string .= '<div class="FO_prod_ingred">';
						$string .= esc_html__( 'il prodotto non ha nessun ingrediente associato ad esso', 'flash_order' );
					$string .= '</div>';
				} else{
					$string .= '<div class="FO_prod_ingred">';
						$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
					$string .= '</div>';
					foreach ($default_ing as $key => $value) {
						$string .= '<div class="FOIngredProdTab">';
							$string .= get_term( $value, 'Ingredienti' )->name;
						$string .= '</div>';
					}
				}
			}
			if ( $product_note != '' ) {
				$string .= '<div class="FO_prod_note">';
					$string .= esc_html__( 'Note prodotto:', 'flash_order' );
				$string .= '</div>';
				$string .= '<div style="width:100%;justify-content:center;">';
					$string .= $product_note;
				$string .= '</div>';
			}
			$string .= '</div>';
			$string .= '</div>';
		}
	} else{
		foreach ( $Front_Post as $item_id => $it ) {

			foreach ( $it as $kk => $vv ) {
				$item = json_decode($vv);
				$prod_ing = array(); $i = 1;
					foreach ( $item as $keykey => $valval ) {
						if ( is_numeric( $keykey)) {
							$product_id = $keykey;
							$product_quantity = $valval;
						}
						if ( str_contains( (string)$keykey, 'Ingredienti' ) ) {
							foreach (current($valval) as $inkey => $invalue) {
								$prod_ing[$i] = get_term_by( 'name', $invalue, 'Ingredienti' )->term_id;
								$i++;
							}
						}
						if ( str_contains( (string)$keykey, 'note' ) ) {
							$product_note = current($valval);
						}
					}
				// $product_id = ($product_id) ? : ;
				$products = wc_get_product( $product_id );
				$Ingredienti = get_the_terms($product_id, 'Ingredienti');
				$default_ing = array(); $p = 1;
				if (is_array($Ingredienti)) {
					foreach ( $Ingredienti as $key => $value) {
						$default_ing[$p] = $value->term_id;
						$p++;
					} 
				}

				$class = '';
				if ( array_diff_assoc( $prod_ing, $default_ing ) != null || $product_note != '' ) {
					$class = 'FOmodified';
				}
				$string .= '<div class="relative">';
					$string .= '<div class="'.$class.'"  onclick="jQuery(this).next().slideToggle()">';
						$string .= wp_kses_post($products->get_image());
						$string .= '<span class="FO_quantity_info">'.$product_quantity.'</span>';
					$string .= '</div>';
					$string .= '<div class="FOimgProdInfo" style="display:none;">';
						$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
						$string .= '<div style="width:100%;justify-content:center;">';
							$string .= $products->get_name();
						$string .= '</div>';
						$string .= '<div style="width:100%;justify-content:center;">';
							$string .= wp_kses_post($products->get_image());
						$string .= '</div>';
			
					if ( $class != '' ) {
						$string .= '<div class="FO_prod_ingred">';
							$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
						$string .= '</div>';
						if (count($prod_ing) > 0 ) {
							foreach ($prod_ing as $key => $value) {
								$string .= '<div class="FOIngredProdTab">';
									$string .= get_term( $value, 'Ingredienti' )->name;
								$string .= '</div>';
							}
						}
					} else{
						if ( count($default_ing) == 0 ) {
							$string .= '<div class="FO_prod_ingred">';
								$string .= esc_html__( 'il prodotto non ha nessun ingrediente associato ad esso', 'flash_order' );
							$string .= '</div>';
						} else{
							$string .= '<div class="FO_prod_ingred">';
								$string .= esc_html__( 'gli ingredienti:', 'flash_order' );
							$string .= '</div>';
							foreach ($default_ing as $key => $value) {
								$string .= '<div class="FOIngredProdTab">';
									$string .= get_term( $value, 'Ingredienti' )->name;
								$string .= '</div>';
							}
						}
					}
					if ( $product_note != '' ) {
						$string .= '<div class="FO_prod_note">';
							$string .= esc_html__( 'Note prodotto:', 'flash_order' );
						$string .= '</div>';
						$string .= '<div style="width:100%;justify-content:center;">';
							$string .= $product_note;
						$string .= '</div>';
					}
					$string .= '</div>';
				$string .= '</div>';
			}
		}
	}
	return $string;
}

function FO_get_status_changer( $order ){
	$string = '';
	$string .= '<div class="FOstatusChanger" style="display:none;">';
	$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle();">';
	$string .= esc_html__( 'CHIUDI', 'flash_order' );
	$string .= '</div>';
	// if ( $order->get_status() == 'pending' ) {
		$string .= '<button onclick="FO_change_order_status(`'.$order->get_id().'`, `processing`, `'.esc_html__( 'Sei sicuro di voler cambiare lo status dell\'ordine?`', 'flash_order' ).');" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'">'.esc_html__( 'in lavorazione', 'flash_order' ).'</button>';
	// }
	$string .= '<button onclick="FO_change_order_status(`'.$order->get_id().'`, `cancelled`, `'.esc_html__( 'Sei sicuro di voler cambiare lo status dell\'ordine?`', 'flash_order' ).');" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'">'.esc_html__( 'cancellato', 'flash_order' ).'</button>';
	$string .= '<button onclick="FO_change_order_status(`'.$order->get_id().'`, `refunded`, `'.esc_html__( 'Sei sicuro di voler cambiare lo status dell\'ordine?`', 'flash_order' ).');" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'">'.esc_html__( 'rimborsato', 'flash_order' ).'</button>';
	$string .= '<button onclick="FO_change_order_status(`'.$order->get_id().'`, `completed`, `'.esc_html__( 'Sei sicuro di voler cambiare lo status dell\'ordine?`', 'flash_order' ).');" title="'.esc_html__( 'cambia lo status dell\'ordine', 'flash_order' ).'">'.esc_html__( 'completato', 'flash_order' ).'</button>';
	$string .= '</div>';
	return $string;
}

function FO_get_order_info_button_tab_string ( $order_id ){

	if ( isset($_POST['ajax_order_id']) && $order_id == null ) { //phpcs:ignore
		$order_id = $_POST['ajax_order_id'];//phpcs:ignore
		$ajax_check = true;
	} else{
		$ajax_check = false;
	}
$order = new WC_Order($order_id); 
	$string = '';
	if (!$ajax_check) {
		$string .= '<button onclick="jQuery(this).next().slideToggle();">'.esc_html__( 'INFO', 'flash_order' ).'</button>';
	}
	$string .= '<div class="flash_card" style="display:none;">';
		$string .= '<div class="FOCloseTab" onclick="jQuery(this).parent().slideToggle()">'.esc_html__('CHIUDI','flash_order').'</div>';
		
		$string .= '<div class="FO_info_section">';
			$string .= '<div class="title" style="font-size:30px;color:var(--fo-scnd-color);">';
			$string .= esc_html__( 'ORDINE', 'flash_order' ).' #'.$order->get_id();
			$string .= '</div>';

			$string .= '<div class="title" style="font-size:20px;color:var(--fo-scnd-color);">';
			$string .= esc_html__( 'Tipo di ordine', 'flash_order' ).'- '.$order->get_meta('delivery_type');
			$string .= '</div>';
		$string .= '</div>';	
		$string .= '<div class="FO_info_section">';
			$string .= '<div class="title">'.esc_html__( '[DATE]', 'flash_order' );
			if ( $order->get_date_created() ) {
				$string .= '<p class="fo-fake-table" title="'.esc_html__( 'data di creazione dell\'ordine', 'flash_order' ).'">';
					$string .= esc_html__( 'creato: ', 'flash_order' ).'<p style="margin: 5px 5px 15px 15px;">'.date_format($order->get_date_created(),"Y/m/d H:i:s").'</p>';
				$string .= '</p>';
			} if ( $order->get_date_modified() ) {
				$string .= '<p class="fo-fake-table" title="'.esc_html__( 'data dell\'ultima modifica dell\'ordine', 'flash_order' ).'">';
					$string .= esc_html__( 'ultima modifica: ', 'flash_order' ).'<p style="margin: 5px 5px 15px 15px;">'.date_format($order->get_date_modified(),"Y/m/d H:i:s").'</p>';
				$string .= '</p>';
			} if ( $order->get_date_paid() ) {
				$string .= '<p class="fo-fake-table" title="'.esc_html__( 'data della fatturazione dell\'ordine', 'flash_order' ).'">';
					$string .= esc_html__( 'fatturazione: ', 'flash_order' ).'<p style="margin: 5px 5px 15px 15px;">'.date_format($order->get_date_paid(),"Y/m/d H:i:s").'</p>';
				$string .= '</p>';
			} if ( $order->get_date_completed() ) {
				$string .= '<p class="fo-fake-table" title="'.esc_html__( 'data del completamento dell\'ordine', 'flash_order' ).'">';
						$string .= esc_html__( 'completato: ', 'flash_order' ).'<p style="margin: 5px 5px 15px 15px;">'.date_format($order->get_date_completed(),"Y/m/d H:i:s").'</p>';
				$string .= '</p>';
			}
			$string .= '</div>';

			$string .= '<div class="title">'.esc_html__( '[FATTURAZIONE]', 'flash_order' );
				$string .= '<p title="get_billing_first_name - get_billing_last_name">'.$order->get_billing_first_name().' '.$order->get_billing_last_name().'</p>';
				$string .= '<p title="get_billing_company">'.$order->get_billing_company().'</p>';
				$string .= '<p title="get_billing_address_1">'.$order->get_billing_address_1().'</p>';
				$string .= '<p title="get_billing_address_2">'.$order->get_billing_address_2().'</p>';
				$string .= '<p title="get_billing_city - get_billing_state">'.$order->get_billing_city().' '.$order->get_billing_state().'</p>';
				$string .= '<p title="get_billing_postcode - get_billing_country">'.$order->get_billing_postcode().' '.$order->get_billing_country().'</p>';
			$string .= '</div>';

			$string .= '<div class="title">'.esc_html__( '[SPEDIZIONE]', 'flash_order' );
				$string .= '<p title="get_shipping_first_name - get_shipping_last_name">'.$order->get_shipping_first_name().' '.$order->get_shipping_last_name().'</p>';
				$string .= '<p title="get_shipping_company">'.$order->get_shipping_company().'</p>';
				$string .= '<p title="get_shipping_address_1">'.$order->get_shipping_address_1().'</p>';
				$string .= '<p title="get_shipping_address_2">'.$order->get_shipping_address_2().'</p>';


				$string .= '<p title="get_shipping_city - get_shipping_state">'.$order->get_shipping_city().' '.$order->get_shipping_state().'</p>';
				$string .= '<p title="get_shipping_postcode - get_shipping_country">'.$order->get_shipping_postcode().' '.$order->get_shipping_country().'</p>';

			$string .= '</div>';

			$string .= '<div class="title">'.esc_html__( '[INFO]', 'flash_order' );
				$string .= '<p title="get_created_via">'.esc_html__( 'creato da - ', 'flash_order' ).$order->get_created_via().'</p>';
				$string .= '<p title="get_billing_email">'.$order->get_billing_email().'</p>';
				$string .= '<p title="get_billing_phone">'.$order->get_billing_phone().'</p>';
				$string .= '<p title="get_customer_ip_address">'.esc_html__('indirizzo ip - ','flash_order').$order->get_customer_ip_address().'</p>';
				$string .= '<p title="get_customer_user_agent">'.esc_html__('user agent - ','flash_order').$order->get_customer_user_agent().'</p>';
			$string .= '</div>';
		$string .= '</div>';

		$string .= '<div class="FO_info_section">';
			$string .= '<div class="title">'.esc_html__( '[ALTRO]', 'flash_order' );
				$string .= '<p>'.esc_html__( 'note dell\'ordine: - ', 'flash_order' ).$order->get_meta('order_note').'</p>';
			$string .= '</div>';
		$string .= '</div>';
	$string .= '</div>';

	if ($ajax_check) {
		wp_send_json(array(
			'string' => $string,
		));
	} else{
		return $string;
	}
}
add_action('wp_ajax_FO_get_order_info_button_tab_string', 'FO_get_order_info_button_tab_string');
add_action('wp_ajax_nopriv_FO_get_order_info_button_tab_string', 'FO_get_order_info_button_tab_string');









if ( FO_get_meta('fo_pickup_delivery_checkout') == 'yes' ) {
	/* Add Checkout field*/
	add_action('woocommerce_checkout_before_customer_details','FO_add_pickup_delivery_section');
	/* Validate Checkout field*/
	add_action('woocommerce_checkout_process', 'FO_validate_pickup_delivery_section');
	/* Save Checkout field*/
	add_action('woocommerce_checkout_update_order_meta', 'FO_save_pickup_delivery_section');

	add_action( 'woocommerce_view_order', 'FO_view_Pickup_Delivery' );
	add_action( 'woocommerce_thankyou', 'FO_view_Pickup_Delivery' );
}
function FO_add_pickup_delivery_section(){
	$nonce = wp_create_nonce( 'FO_pickup_delivery_section_nonce' );
	?>
	<div id="FO_pickup_delivery">
		<p>
			<span class="woocommerce-input-wrapper">
				<input type="radio" class="input-radio " value="pickup" name="delivery_type" id="fo_order_type_pickup">
				<label for="fo_order_type_pickup" class="radio "><?php echo esc_html__( 'Ritiro in Sede', 'flash_order' ); ?></label>

				<input type="radio" class="input-radio " value="delivery" name="delivery_type" id="fo_order_type_delivery" checked="checked">
				<label for="fo_order_type_delivery" class="radio "><?php echo esc_html__( 'Consegna a domicilio', 'flash_order' ); ?></label>
			</span>
		</p>
		<div class="fo_error_message" style="display: none;"></div>

        <div class="fo_delivery">
	        <div class="fo_date_section">
	            <p>
	            	<label for="fo_delivery_date" class=""><?php echo esc_html__( 'Data di consegna', 'flash_order' ); ?>
	            		<abbr class="required" title="obbligatorio">*</abbr>
	            	</label>
	            	<span class="woocommerce-input-wrapper">
	            		<input type="date" name="fo_delivery_date" id="fo_delivery_date" placeholder="" value="">
	            		<input type="hidden" id="_fononce_pickup_delivery_section" name="_fononce_pickup_delivery_section" value="<?php echo esc_attr($nonce);?>">
	            	</span>
	            </p>                
	        </div>
	        <div class="fo_time_section" title="<?php echo esc_html__( 'Cercheremo di rispettare questo orario con il massimo dell\'impegno, tuttavia l\'orario effettivo potrebbe non corrispondere.', 'flash_order' ); ?>">
	            <p>
	            	<label for="fo_delivery_time" class=""><?php echo esc_html__( 'Ora di consegna', 'flash_order' ); ?>
	            		<abbr class="required" title="obbligatorio">*</abbr>
	            	</label>
	            	<span class="woocommerce-input-wrapper">
	            		<input type="time" name="fo_delivery_time" id="fo_delivery_time" placeholder="" value="">
	            		<input type="hidden" id="_fononce_pickup_delivery_section" name="_fononce_pickup_delivery_section" value="<?php echo esc_attr($nonce);?>">
	            	</span>
	            </p>              
	        </div>
        </div>
    </div>
	<?php
}

function FO_view_Pickup_Delivery( $order_id ){
	$delivery_type = get_post_meta( $order_id, 'delivery_type', true );
		if ($delivery_type == 'delivery'){ $delivery_type = esc_html__('Consegna a Domicilio', 'flash_order'); }
		if ($delivery_type == 'pickup'){ $delivery_type = esc_html__('Ritiro in Sede', 'flash_order'); }
	$fo_delivery_date = get_post_meta( $order_id, 'fo_delivery_date', true );
	$fo_delivery_time = get_post_meta( $order_id, 'fo_delivery_time', true );

	echo '<p>'.esc_html__("Tipo Ordine: ", 'flash_order').'<strong>'.esc_attr($delivery_type).'</strong></p>';
	echo '<p>'.esc_html__("Data: ", 'flash_order').'<strong>'.esc_attr($fo_delivery_date).'</strong> '.esc_html__("Ora: ", 'flash_order').'<strong>'.esc_attr($fo_delivery_time).'</strong></p>';
}

function FO_validate_pickup_delivery_section(){
// Show an error message if the field is not set.
    if ( !isset($_POST['_fononce_pickup_delivery_section']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_pickup_delivery_section'])), 'FO_pickup_delivery_section_nonce' ) ) {
		return;
	}	//_fononce_stat_update_nonce: jQuery('input[name="_fononce_stat_update_nonce"]').val(),
	if (!$_POST['fo_delivery_date']) wc_add_notice(esc_html__('Seleziona una data!', 'flash_order') , 'error');
	if (!$_POST['fo_delivery_time']) wc_add_notice(esc_html__('Seleziona un\'orario!', 'flash_order') , 'error');
}

function FO_save_pickup_delivery_section($order_id){
    if ( !isset($_POST['_fononce_pickup_delivery_section']) && !wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_fononce_pickup_delivery_section'])), 'FO_pickup_delivery_section_nonce' ) ) {
		return;
	}	//_fononce_stat_update_nonce: jQuery('input[name="_fononce_stat_update_nonce"]').val(),
	if (!empty($_POST['delivery_type'])) {
		update_post_meta($order_id, 'delivery_type',sanitize_text_field($_POST['delivery_type']));
	}
	if (!empty($_POST['fo_delivery_date'])) {
		update_post_meta($order_id, 'fo_delivery_date',sanitize_text_field($_POST['fo_delivery_date']));
	}
	if (!empty($_POST['fo_delivery_time'])) {
		update_post_meta($order_id, 'fo_delivery_time',sanitize_text_field($_POST['fo_delivery_time']));
	}
}











//ajax & auto refresh

function FO_check_for_orders() {
    $update_needed = false;
    $orders_to_refresh = array();
    $order_items = array();
    $string = '';
    $orders_date_created = intval( FO_get_meta('orders_date_created') ) * 3600;
	$orders_date_created_operator =  ( $orders_date_created == 0 ) ? '<' : '>';

	$orders = wc_get_orders( array(
		'numberposts'    	=> 5,
		'posts_per_page' 	=> -1,
		'paged'          	=> 'page',
		'orderby'           => 'date',
		'order'             => 'DESC',
		'return'            => 'objects',
		'paginate'          => false,
		'date_created' => $orders_date_created_operator . ( time() - $orders_date_created ),// 3600s = 1h  28800s = 8h
	) );
	$last_id = $orders[0]->get_id();
	
	if ( $_POST['last_order_id'] != $last_id ) {
		foreach( $orders as $k => $v ){
			FO_add_products_to_order( $v->get_id(), $v );
			if ( $v->get_date_modified() > $_POST['last_order_data']) {
				if ( !in_array( $v->get_id(), $_POST['order_id_table'] ) ) {
					$orders_to_refresh[$k] = $v->get_data();
					//$order_items[$k] = $v->get_items();
					$string .= FO_manage_order_add_order( $v );
				}
			} else { continue; }
		}
		if (isset($orders_to_refresh)) {
			$update_needed = true;
		}
		if ( FO_get_meta( 'last_woocommerce_order_id') != $last_id ) {
			FO_update_meta( 'last_woocommerce_order_id', $last_id );
		}
	}
	// return wp_json_encode('prova');
    wp_send_json(array(
		'updateNeeded' 	=> $update_needed,
		'newOrders' 	=> $orders_to_refresh,
		'last_id' 		=> $last_id,
		'order_id_table' => $_POST['order_id_table'],
		'string' 		=> $string,
		//'debug' 		=> $orders[0]->get_data()
	));
	// wp_send_json_error();
	die();
}
add_action('wp_ajax_FO_check_for_orders', 'FO_check_for_orders');
add_action('wp_ajax_nopriv_FO_check_for_orders', 'FO_check_for_orders');


function FO_ajax_change_order_status( $poste = '' ){
	if (FOcheck($poste) && is_array($poste) ) {
		$_POST = $poste;
	}
	$order_id = sanitize_text_field( $_POST['order_id'] );
	$status = sanitize_text_field( $_POST['status'] );
	$order = wc_get_order($order_id);
	// $order = new WC_Order($order_id); 
	if (!empty($order)) {
		$order->update_status( $status );
	}
	wp_send_json(array(
		'order_id' 	=> $order_id,
		'status' 	=> $status,
		// 'order' 	=> $order
	));
	// wp_send_json_success();
	if (!FOcheck($poste) && !is_array($poste) ) {
		die();
	}
}
add_action('wp_ajax_FO_ajax_change_order_status', 'FO_ajax_change_order_status');
add_action('wp_ajax_nopriv_FO_ajax_change_order_status', 'FO_ajax_change_order_status');



function enqueue_ajax_scripts() {
	// wp_enqueue_script('flash-order-public', plugin_dir_url(__FILE__) . 'js/flash_order-public.js', array('jquery', 'wp-api'), '1.0', false);
    // Passa i dati che possono essere utili per la tua richiesta AJAX
    wp_localize_script('flash-order-public', 'flash_orders_ajax_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('flash_orders_ajax_vars'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');
// add_action('admin_enqueue_scripts', 'enqueue_ajax_scripts');

function enqueue_ajax_view_orders_scripts() {
	wp_enqueue_script('flash-order-ajax-view-orders', plugin_dir_url(__FILE__) . 'js/ajax-view-orders.js', array('jquery', 'wp-api'), '1.0', false);
    wp_localize_script('flash-order-ajax-view-orders', 'flash_orders_ajax_view_orders_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('flash_orders_ajax_view_orders_vars'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_view_orders_scripts');

function enqueue_ajax_manage_restaurant_scripts() {
	// wp_enqueue_script('flash-order-ajax-manage-tables',plugin_dir_url(__FILE__).'js/ajax-manage-tables.js', array('jquery', 'wp-api'), '1.0', false);
    wp_localize_script('flash-order-ajax-manage-tables', 'flash_orders_ajax_manage_restaurant_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('flash_orders_ajax_manage_restaurant_vars'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_manage_restaurant_scripts');
