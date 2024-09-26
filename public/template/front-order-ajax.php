<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// FO_access_denied();
// FO_loading_message();

FO_soft_access_denied();
$role = FO_access_autorization();
// FO_debug(wp_get_current_user());
$options = array(
	'menu' 		=> '',
	'closebtn' 	=> '',
	'sidebtn' 	=> '',
	// 'menu' 		=> '',
);

$tavoli = get_posts( array(
    'numberposts'      => -1,
    // 'category'         => 0,
    'orderby'          => 'title',
    'order'            => 'ASC',
    // 'include'          => array(),
    // 'exclude'          => array(),
    // 'meta_key'         => '',
    // 'meta_value'       => '',
    'post_type'        => 'tavoli',
    // 'suppress_filters' => true,
) );

$products = FO_get_products_for_loop();

$fo_front_surname = (!in_array(FO_get_meta('flash_order_front_surname'), array(null, ''), true)) ? explode(",", FO_get_meta('flash_order_front_surname')): '';

$table_link_num = 0;
if ( isset($_GET['table']) && $_GET['table'] != '' ) {
	$table_link_num = sanitize_text_field($_GET['table']);
}
?>
<div class="FOmniContent">
	
	<div style="display:none!important;">
		<div id="FO_select_variant_alert"><?php esc_html_e( 'Seleziona prima la variante', 'flash_order' );?></div>
		<div id="FO_warehouse_alert"><?php esc_html_e( 'Siamo spiacenti ma il prodotto non é al momento disponibile', 'flash_order' );?></div>
		<div id="FO_access_alert"><?php esc_html_e( 'Per poter effettuare ordini su questa pagina, é neccessario Effettuare l\'accesso!', 'flash_order' );?></div>

	</div>


	<span class="FObuttListRapidView dashicons dashicons-menu-alt3" onclick="Show_FOListRapidView()"></span>

	<div class="FOListRapidView" style="left:-200px;">
		<div class="Hide_FOListRapidView" onclick="Hide_FOListRapidView()">
			<?php esc_html_e( 'CHIUDI', 'flash_order' ); ?>
		</div>

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

<?php 
echo wp_kses_post(FO_list_view_selector()); 
// FO_debug(get_post_types());
// get_post_types();
?>
		<div id="products_container" class="foflex">
			<div class="focathead" style="background-color: var(--fo-main-color)!important;">
				<input type="search" onkeyup="FO_search_for_all(this)" class="focatsearchall" placeholder="<?php esc_html_e('Cerchi Qualcosa?','flash_order' );?>">
			</div>
			<?php 
			// echo FO_list_view_selector(); 
				// $products = FO_get_products_for_loop();
				FO_products_for_div_loop( $products );
			?>
		</div>

		<div class="FO_show_order_summary" onclick="Show_FO_Front_Float()">
			<strong class="text_white" style="z-index:99;"> 
				<?php esc_html_e( 'ORDINE', 'flash_order' ); ?> 
			</strong>
			<strong id="FO_order_live_count" class="text_white" style="z-index:99;">0</strong>
			<img class="FO_img_summary" src="" style="display:none;">
		</div>
		
		<div id="FO_Front_Float">

			<div class="Hide_FO_Front_Float" onclick="Hide_FO_Front_Float()">
				<?php esc_html_e( 'CHIUDI', 'flash_order' ); ?>
			</div>
	<!-- .unbind("hover"); -->
	<!-- onclick="jQuery(this).animate({left:'0%'});" -->
	
			<div id="FO_sum_order">
			</div>

			<div id="order_actions">
				<?php 	$nonce = wp_create_nonce( 'FO_front_order_ajax' );
    				echo '<input type="hidden" id="_fononce_front_order_ajax" name="_fononce_front_order_ajax" value="'.esc_attr($nonce).'" />';
				?>
				<p><?php esc_html_e( 'Varianti Prodotti', 'flash_order' );?>
					<div id="FOProdNumber" style="margin-left:15px">0</div>
				</p>
				<div id="table_input"> 
					<!-- <div class="title"> <?php esc_html_e( 'TAVOLO', 'flash_order' ); ?> </div>
					<div class="spinner-button-big" onclick="jQuery(this).next().val(parseInt(jQuery(this).next().val()) - 1)">-</div>
					<input id="table_name" type="number" name="table_name" value="<?php echo esc_attr($table_link_num);?>">
					<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseInt(jQuery(this).prev().val()) + 1)">+</div> -->
					<select class="fo-select" name="table_name_cpt">
						<option value=""> <?php esc_html_e( 'Seleziona il Tavolo', 'flash_order_pro' );?> </option>
						<?php foreach ($tavoli as $tavolo) { ?>
							<option value="<?php echo esc_attr($tavolo->ID);?>">
								<?php echo esc_attr($tavolo->post_title);?>
							</option>
						<?php } ?>
					</select>
				</div>
			<?php if ( $role ) { ?>
				<textarea id="orderNote" type="text" name="order_note" class="" style="width:300px;margin:10px 20px;" placeholder="<?php esc_html_e('Note dell\'ordine...' , 'flash_order'); ?>"></textarea>
			<?php } ?>
				<div class="FO_order_sub" id="submit_order" onclick="FO_validate_flash_order_form_ajax(this);">
					<?php esc_html_e( 'AVVIA ORDINE', 'flash_order' ); ?>
				</div>
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
		</script>
	</div>
</div>
<?php
// if ( isset($_POST['submit']) && $_POST['submit'] == 'submit' ) {
// 	flash_orders_ordination();
// }



