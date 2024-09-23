<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
FO_access_denied();
// FO_loading_message();
// $ord_summ_style = (FO_get_meta('flash_order_order_summary') != null && FO_get_meta('flash_order_order_summary') != '') ? FO_get_meta('flash_order_order_summary'): 'side_page';
$ord_summ_class = array(
	'menu' 		=> '',
	'closebtn' 	=> '',
	'sidebtn' 	=> '',
	// 'menu' 		=> '',
);

$fo_front_surname = (!in_array(FO_get_meta('flash_order_front_surname'), array(null, ''), true)) ? explode(",", FO_get_meta('flash_order_front_surname')): '';

$ord_summ_style = (!in_array(FO_get_meta('flash_order_order_summary'), array(null, ''), true)) ? FO_get_meta('flash_order_order_summary'): 'side_page';

$ord_summ_class['menu'] = $ord_summ_style;

if ( $ord_summ_style == 'top_page') {
	$ord_summ_class['closebtn'] = 'hide';
	$ord_summ_class['sidebtn'] = 'hide';
}
if ( $ord_summ_style == 'side_page') {}
?>

<div id="FO_Front_Content">

<!-- .unbind("hover"); -->
<!-- onclick="jQuery(this).animate({left:'0%'});" -->

<div id="left-fixed-menu" class="<?php echo esc_attr($ord_summ_class['menu']);?>">
	<!-- <div class="headord"> -->
		<button tarhei class="zind <?php echo esc_attr($ord_summ_class['closebtn']);?>" onclick="jQuery(this).parent().animate({left:'-100%'});" style="width:100%" title="<?php esc_html_e( 'Chiudi il riepilogo ordine', 'flash_order' ); ?>"><?php esc_html_e( 'CHIUDI', 'flash_order' ); ?></button>
		<button tarhei class="vertical zind <?php echo esc_attr($ord_summ_class['sidebtn']);?>" style="left: -10px;" onclick="jQuery(this).parent().animate({left:'-100%'});" title="<?php esc_html_e( 'Chiudi il riepilogo ordine', 'flash_order' ); ?>"> <p>.</p><p>.</p><p>.</p><p><</p><p>.</p><p>.</p><p>.</p> </button>

		<div tarhei class="title" style="width: 100%;"><?php esc_html_e( 'RIEPILOGO ORDINAZIONE', 'flash_order' ); ?></div>
	<!-- </div> -->

	<form method="post" style="">
<?php
	FO_view_table_in_grid();
 ?>
		<table id="summ_order">
			<thead class="zind">
				<tr class="sticky" style="top:-1px;">
					<?php
						$visualize = FO_get_flash_orders_visualize_settings();
						if ( isset($visualize['id']) && $visualize['id'] ) { ?>
							<th style="width:50px;"><?php esc_html_e( 'ID', 'flash_order' ); ?></th>
						<?php } 
						if ( isset($visualize['name']) && $visualize['name'] ) { ?>
							<th style="width:100px;"><?php esc_html_e( 'NOME', 'flash_order' ); ?></th>
						<?php } 
						if ( isset($visualize['image']) && $visualize['image'] ) { ?>
							<th style="width:120px;"><?php esc_html_e( 'IMMAGINE', 'flash_order' ); ?></th>
						<?php } 
						if ( isset($visualize['warehouse']) && $visualize['warehouse'] ) { ?>
							<th style="width:50px;"><?php esc_html_e( 'MAGAZZINO', 'flash_order' ); ?></th>
						<?php } 
						if ( isset($visualize['note']) && $visualize['note'] ) { ?>
							<th style="width:120px;"><?php esc_html_e( 'NOTE', 'flash_order' ); ?></th>
						<?php } 
						if ( isset($visualize['actions']) && $visualize['actions'] ) { ?>
							<th style="width:120px;"><?php esc_html_e( 'AZIONI', 'flash_order' ); ?></th>
						<?php } 
						?>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<div id="order_actions">
			<p><?php esc_html_e( 'Varianti Prodotti _', 'flash_order' ); ?>
				<div id="FOProdNumber">0</div>
			</p>
			<div id="table_input"> <div class="title"> <?php esc_html_e( 'TAVOLO', 'flash_order' ); ?> </div>
				<div class="spinner-button-big" onclick="jQuery(this).next().val(parseInt(jQuery(this).next().val()) - 1)">-</div>
				<input id="table_name" type="number" name="table_name" value="0">
				<div class="spinner-button-big" onclick="jQuery(this).prev().val(parseInt(jQuery(this).prev().val()) + 1)">+</div>
				<?php if ( $fo_front_surname != '' ) { ?>
					<select name="table_surname" class="fo-select">
						<option value=""><?php esc_html_e( '- zona -', 'flash_order' );?></option>
						<?php foreach ($fo_front_surname as $key => $value) { ?>
							<option value="<?php echo esc_attr($value);?>"><?php echo esc_attr($value);?></option>
						<?php } ?>
					</select>
				<?php } ?>
			</div>

			<textarea id="orderNote" type="text" name="order_note" class="" style="width:300px;margin:10px 20px;" placeholder="<?php esc_html_e('Note dell\'ordine...' , 'flash_order'); ?>"></textarea>
<?php $nonce = wp_create_nonce( 'FO_front_order' );
    echo '<input type="hidden" id="_fononce_front_order" name="_fononce_front_order" value="'.esc_attr($nonce).'" />';
?>
			<button name="submit" value="submit" id="submit_order" onclick="FO_validate_flash_order_form(this);"><?php esc_html_e( 'AVVIA ORDINE', 'flash_order' ); ?></button>
		</div>
	</form>
	<script>
		toggleFullScreen();
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
		// document.getElementById("left-fixed-menu").showModal();
	</script>
	
	<button class="vertical zind handleOrder <?php echo esc_attr($ord_summ_class['sidebtn']);?>" style="left:100%;" onclick="jQuery(this).parent().animate({left:'0%'});" title="<?php esc_html_e( 'Riepilogo ordine', 'flash_order' ); ?>"> <p>.</p><p>.</p><p>.</p> <div id="FOProdNumberMenu">0</div> <p>.</p><p>.</p><p>.</p> </button>
</div>

<div style="width:100%;height:50px;"></div>
	
	<div class="title" style="width: 100%;"><?php esc_html_e( 'PRODOTTI', 'flash_order' ); ?></div>
	<div style="width:100%;" class="title"> <input id="filter_tables" type="search" style="min-width:250px;width:auto;margin:20px;padding:15px;" placeholder="<?php esc_html_e( 'Cerca prodotto ...', 'flash_order' ); ?>"></div>
<?php
	FO_view_table_in_grid();
 ?>
	<table id="products_container">
		<thead>
			<tr class="sticky"> 
				<?php 
				$visualize = FO_get_flash_orders_visualize_settings();
				if ( isset($visualize['id']) && $visualize['id'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'ID', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['name']) && $visualize['name'] ) { ?>
					<th style="width:100px;"><?php esc_html_e( 'NOME', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['image']) && $visualize['image'] ) { ?>
					<th style="width:120px;"><?php esc_html_e( 'IMMAGINE', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['warehouse']) && $visualize['warehouse'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'MAGAZZINO', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['note']) && $visualize['note'] ) { ?>
					<th style="width:120px;"><?php esc_html_e( 'NOTE', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['actions']) && $visualize['actions'] ) { ?>
					<th style="width:120px;"><?php esc_html_e( 'AZIONI', 'flash_order' ); ?></th>
				<?php } 
				?>
			</tr>
		</thead>
		<?php 
		$products = FO_get_products_for_loop();
	//FO_debug($products);
		FO_product_to_table_loop( $products );
		?>
	</table>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#filter_tables').keyup(function() {
				var searchVal = jQuery('#filter_tables').val()
				var table = jQuery('#products_container')
				table.find('tr').each(function(index, row){
					var allDataPerRow = jQuery(row).find('td');
					if (allDataPerRow.length > 0) {
						var found = false;
						allDataPerRow.each(function(ind, td) {
							var regExp = new RegExp(searchVal, "i");
							if (regExp.test(jQuery(td).text())) {
								found = true;
								return false;
							}
						});
						if(found === true) {
							jQuery(row).show();
						}else {
							jQuery(row).hide();
						}
					}
				});
			});
			jQuery("#submit_order").one("click", function () {
		    //   alert("You clicked this button");
		    });
		});

	function fo_form_height(){
		var formVal = window.innerHeight - jQuery("#order_actions").height() - 125;
		jQuery("#left-fixed-menu form").css("height", formVal );
	}
	window.addEventListener('scroll', fo_form_height);
	window.addEventListener('resize', fo_form_height);
	fo_form_height();
	</script>
</div>
<?php
if ( isset($_POST['submit']) && $_POST['submit'] == 'submit' ) {
	flash_orders_ordination();
}



