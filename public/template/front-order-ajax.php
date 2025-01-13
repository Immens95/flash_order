<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// FO_access_denied();
// FO_loading_message();


function FO_front_order_ajax(){

FO_soft_access_denied();
// $role = FO_access_autorization();
$user_id = get_current_user();

$net_info = FO_get_connection_info();

$options = array(
	'menu' 		=> '',
	'closebtn' 	=> '',
	'sidebtn' 	=> '',
	// 'menu' 		=> '',
);

$tavoli = get_posts( array(
    'numberposts'      => -1,
    'orderby'          => 'title',
    'order'            => 'ASC',
    'post_type'        => 'tavoli',
) );

$args = array(
	'status'            => 'publish',
	'orderby' 			=> 'title',
	'order'             => 'DESC',
	'limit'             => -1,  // -1 for unlimited
    'offset'            => null,
    'page'              => 1,
    'return'            => 'objects',
	'paginate'          => false,
);
$search_products = wc_get_products( $args );

$products = FO_get_products_for_loop();


if ( isset($_GET['_fononce_tab_check']) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_GET['_fononce_tab_check'])), 'FO_check_table_nonce' ) ) {
// get table_id from link
	if ( isset($_GET['tab_hs']) && sanitize_text_field(wp_unslash($_GET['tab_hs'])) != '' ) {
		$table_link_hs = sanitize_text_field(wp_unslash($_GET['tab_hs']));
	} else{ $table_link_hs = ''; }
// get table_id from link
	if ( isset($_GET['tab_id']) && sanitize_text_field(wp_unslash($_GET['tab_id'])) != '' ) {
		$table_link_id = sanitize_text_field(wp_unslash($_GET['tab_id']));
	} else{ $table_link_id = '0'; }
} else{
	$net_info['is_local'] = false;
}

?>
<div class="FOmniContent">
	
	<div style="display:none!important;">
		<div id="FO_select_variant_alert"><?php esc_html_e( 'Seleziona prima la variante', 'flash_order' );?></div>
		<div id="FO_warehouse_alert"><?php esc_html_e( 'Siamo spiacenti ma il prodotto non é al momento disponibile', 'flash_order' );?></div>
		<div id="FO_access_alert"><?php esc_html_e( 'Per poter effettuare ordini su questa pagina, é neccessario Effettuare l\'accesso!', 'flash_order' );?></div>

		<div id="FO_favourite_alert"><?php esc_html_e( 'Il prodotto é già tra i favoriti', 'flash_order' );?></div>

		<div id="FO_home_url"><?php echo esc_attr(get_home_url());?></div>

		<div id="FO_woo_currency_sym"><?php echo esc_attr(get_woocommerce_currency_symbol());?></div>

		<style type="text/css">
			#eltdf-back-to-top{
				margin-bottom: 120px!important;
			}
		</style>
	</div>

	<span class="FObuttListRapidView dashicons dashicons-menu-alt3" onclick="Show_FOListRapidView()"></span>

	<div class="FOListRapidView" style="left:-200px;">
		<div class="Hide_FOListRapidView" onclick="Hide_FOListRapidView()">
			<?php esc_html_e( 'CHIUDI', 'flash_order' ); ?>
		</div>
		<a class="FOListRapidView_cathead" href="#FO_favourite" style="background-color:var(--fo-main-color)!important;backdrop-filter: opacity(20%);"><?php esc_html_e('Prodotti Preferiti','flash_order' );?>
		</a>
		<?php foreach ($products as $key => $value) { 
			$term = get_term_by('name', $key, 'product_cat');
			$term_meta = (FOcheck($term))? get_term_meta($term->term_id):false;
			$image = ( isset($term_meta['thumbnail_id']) )? wp_get_attachment_image_src($term_meta['thumbnail_id'][0] ):array('0');
			$stylec = '';
			if ($image[0]!= null) {
				$stylec = 'background: url('.esc_attr($image[0]).')!important;';
			}
			?>
			<a class="FOListRapidView_cathead" href="#<?php echo esc_attr($key);?>" style="background-color: var(--fo-main-color)!important;backdrop-filter: opacity(20%);<?php echo esc_attr($stylec);?>"><?php echo esc_attr($key);?></a>
		<?php } ?>

	</div>

		<div id="products_container" class="foflex">

			<div class="focathead FO_list_view_selector" style="background-color: var(--fo-main-color)!important;">
				<input type="search" onkeyup="FO_refine_search(this, 'hide')" fotargetcat="search" class="focatsearchall" placeholder="<?php esc_html_e('Cerchi Qualcosa?','flash_order' );?>">

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
			<div class="FO_search_container">
				<?php 
				foreach ($search_products as $key => $value) {
					FO_product_to_div_loop( $value ); 
				}
				?>
			</div>

			<div class="focathead" id="FO_favourite" style="background-color: var(--fo-main-color)!important;">
				<div class="title" style="font-weight:800;font-size:30px;z-index:10;">
					<?php esc_html_e('Prodotti Preferiti','flash_order' );?>
				</div>
				<input type="search" fotargetcat="FO_favourite" onkeyup="FO_refine_search(this)" class="focatsearch" placeholder="Cerca..." style="z-index:10;">
				<div class="fo_button" onclick="FO_toggle_Favourite(this);">
					<span class="dashicons dashicons-arrow-down-alt2"></span>
				</div>
			</div>
			<div class="FO_favourites_container"></div>
			<?php 
					$fav_prod = get_user_meta($user_id, 'FO_favourite_products');
					if (isset($fav_prod) && $fav_prod != '') {
						$fav_prod_arr = json_decode($fav_prod);
						foreach ($fav_prod_arr as $key => $value) {
							
						}
					}

				?>

			<?php FO_products_for_div_loop( $products ); ?>

		</div>



		<div class="FO_show_order_summary" onclick="Show_FO_Front_Float()">
			<strong class="text_white" style="z-index:99;"> 
				<?php esc_html_e( 'ORDINE', 'flash_order' ); ?> 
			</strong>
			<strong id="FO_order_live_count" class="text_white" style="z-index:99;">0</strong>
			<img class="FO_img_summary" src="" style="display:none;">
		</div>
		
		<?php FO_Advanced_prod_card(); ?>
		
		<div id="FO_Front_Float">
			<div class="Hide_FO_Front_Float" onclick="Hide_FO_Front_Float()">
				<?php esc_html_e( 'CHIUDI', 'flash_order' ); ?>
			</div>
	<!-- .unbind("hover"); -->
	<!-- onclick="jQuery(this).animate({left:'0%'});" -->
	
			<div id="FO_sum_order">
			</div>

<?php 
	if ( !FO_check_meta_setting('fo_allow_menu_order') ) {
		$net_info['is_local'] = false;
	}
	$net_info['is_local'] = true;
?>
			<div id="order_actions">
				<input type="hidden" id="FO_order_index" name="FO_order_index" value="10000">
				<?php if ($net_info['is_local']) {
					$nonce = wp_create_nonce( 'FO_front_order_ajax' );
    				echo '<input type="hidden" id="_fononce_front_order_ajax" name="_fononce_front_order_ajax" value="'.esc_attr($nonce).'" />';
				} ?>

				<p><?php esc_html_e( 'Varianti Prodotti', 'flash_order' );?>
					<div id="FOProdNumber" style="margin-left:15px">0</div>
				</p>

				<?php if ( $net_info['is_local'] ) { ?>
					<div id="table_input"> 
						<select class="fo-select" name="table_name_cpt">
							<option value=""> <?php esc_html_e( 'Seleziona il Tavolo', 'flash_order' );?> </option>
							<?php foreach ($tavoli as $tavolo) { ?>
								<option value="<?php echo esc_attr($tavolo->ID);?>">
									<?php echo esc_attr($tavolo->post_title);?>
								</option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>

				<?php if ( $net_info['is_local'] ) { ?>
					<div class="FO_order_sub" id="submit_order" onclick="FO_validate_flash_order_form_ajax(this);">
						<?php esc_html_e( 'AVVIA ORDINE', 'flash_order' ); ?>
					</div>
				<?php } ?>

			</div>
		</div>
	
		<script type="text/javascript">
			function fo_ajax_form_height(){
				var formVal = window.innerHeight - jQuery("#order_actions").height() - 70;
				jQuery("#FO_sum_order").css("height", formVal );
			}
			window.addEventListener('scroll', fo_ajax_form_height);
			window.addEventListener('resize', fo_ajax_form_height);
			fo_ajax_form_height();

			jQuery(window).on('load', function() {
            	jQuery(".FOloadingCardPublicMain").fadeOut(200);
           		fo_toggle_header_footer(true);
        	});
		</script>
	</div>
</div>
<?php
// if ( isset($_POST['submit']) && $_POST['submit'] == 'submit' ) {
// 	flash_orders_ordination();
// }
}


