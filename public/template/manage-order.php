<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

FO_access_denied();
// FO_loading_message();
$fo_notify_audio = FO_get_meta( 'fo_notify_audio');

$orders_limit_view = intval( FO_get_meta('orders_limit_view') );

$orders_date_created = intval( FO_get_meta('orders_date_created') ) * 3600;
$orders_date_created_operator =  ( $orders_date_created == 0 ) ? '<' : '>';

$ajax_refresh_order_seconds = ( intval( FO_get_meta('ajax_refresh_order_seconds') ) < 500 ) ? 500 : intval( FO_get_meta('ajax_refresh_order_seconds'));

$flash_order_front_name = ( FO_get_meta('flash_order_front_name' ) != '' ) ? FO_get_meta('flash_order_front_name') : __('TAVOLO','flash_order');
$fotimer_duration = ( FO_get_meta('fotimer_duration' ) != '' ) ? FO_get_meta('fotimer_duration') : 30;

$fotimer_advanced = ( FO_get_meta('fotimer_advanced' ) != '' ) ? FO_get_meta('fotimer_advanced') : 'yes';
$fotimer_advanced_factor = ( FO_get_meta('fotimer_advanced_factor' ) != '' ) ? (float)FO_get_meta('fotimer_advanced_factor') : 0.25;

	$args = array(
    	'limit' 	=> -1,
    	'paged'   	=> 'page',
    	'orderby' 	=> 'date',
	    'order'   	=> 'DESC',
	    'return'  	=> 'objects',
	    'paginate'	=> true,
	    'date_created' => $orders_date_created_operator . ( time() - $orders_date_created ),// 3600s = 1h  28800s = 8h
	    //'date_created'  	=> '<'.( time() + (int)$orders_date_created ) // 3600s = 1h  28800s = 8h
  );
	$orders = wc_get_orders( $args )->orders;
	$count = 0;
	// FO_debug($orders[0]->get_data());
?>

<div id="settings" style="display:none!important;">
	<div id="ajax_refresh_order_seconds"> <?php echo esc_attr($ajax_refresh_order_seconds);?> </div>
	<div id="flash_order_front_name"> <?php echo esc_attr($flash_order_front_name);?> </div>
	<div id="orders_limit_view"> <?php echo esc_attr($orders_limit_view);?> </div>
	<div id="orders_date_created"> <?php echo esc_attr($orders_date_created);?> </div>
	<div id="fotimer_duration"> <?php echo esc_attr($fotimer_duration);?> </div>

	<div id="fotimer_advanced"> <?php echo esc_attr($fotimer_advanced);?> </div>
	<div id="fotimer_advanced_factor"> <?php echo esc_attr($fotimer_advanced_factor);?> </div>

	<div id="folist_order_table_mex"> <?php esc_html_e('seleziona il tavolo, oppure impostane il numero.','flash_order');?> </div>
</div>

<?php 
FO_hover_message(__('clicca per continuare...','flash_order')); 
?>

<div id="fopage" fopage="front-orders" style="display:none;"></div>

<div id="FO_Front_Content">

	<nav id="FO_Nav_Order">
		<button id="But_All" class="FOhighMenu" onclick="FO_order_filter('all')"> <?php esc_html_e( 'TUTTI', 'flash_order' ); ?> <div class="notify" id="Not_All" style="display:none;">0</div></button>
		<button id="But_Restaurant" onclick="FO_order_filter('table')"> <?php esc_html_e( 'SALA', 'flash_order' ); ?> <div class="notify" id="Not_Restaurant" style="display:none;">0</div></button>
		<button id="But_Pickup" onclick="FO_order_filter('pickup')"> <?php esc_html_e( 'RITIRO', 'flash_order' ); ?> <div class="notify" id="Not_Pickup" style="display:none;">0</div></button>
		<button id="But_Delivery" onclick="FO_order_filter('delivery')"> <?php esc_html_e( 'CONSEGNA', 'flash_order' ); ?> <div class="notify" id="Not_Delivery" style="display:none;">0</div></button>
		<audio id="FO_audio" allow="autoplay" src="<?php echo esc_attr($fo_notify_audio);?>" onclick="">
		  <source src="<?php echo esc_attr($fo_notify_audio);?>" type="audio/mpeg">
			Your browser does not support the audio element.
		</audio>
	</nav>

	<div id="FO_active_filter" active="all">
	</div>

<?php
	FO_flash_list_order();

	FO_view_table_in_grid();
	// class="over relative"
?>
<!-- <form method="post" style=""> -->
<!-- <div style="width: 100%;height: 100%;overflow: auto;position:relative;"> -->
	<table id="result-container" class="table" pending="<?php esc_html_e('nuovo','flash_order')?>" processing="<?php esc_html_e('in lavorazione','flash_order')?>" cancelled="<?php esc_html_e('cancellato','flash_order')?>" refunded="<?php esc_html_e('rimborsato','flash_order')?>" completed="<?php esc_html_e('completato','flash_order')?>">
		<thead class="sticky">
			<tr>
				<?php 
				$visualize = FO_get_manage_orders_visualize_settings();
				if ( isset($visualize['id']) && $visualize['id'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'ID', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['name']) && $visualize['name'] ) { ?>
					<th style="width:100px;"><?php esc_html_e( 'NOME', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['products']) && $visualize['products'] ) { ?>
					<th style="width:200px;"><?php esc_html_e( 'PRODOTTI', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['info']) && $visualize['info'] ) { ?>
					<th style="width:100px;"><?php esc_html_e( 'INFO', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['status']) && $visualize['status'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'STATO', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['actions']) && $visualize['actions'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'AZIONI', 'flash_order' ); ?></th>
				<?php } 
				if ( isset($visualize['totals']) && $visualize['totals'] ) { ?>
					<th style="width:50px;"><?php esc_html_e( 'TOTALE', 'flash_order' ); ?></th>
				<?php } 
				?>
			</tr>
		</thead>
		<tbody style="justify-content:center;">
		<?php foreach( $orders as $order ){
			if ( $count == $orders_limit_view ) { break; }
			// $meta_data = get_post_meta( $order->get_id() );
			// FO_debug($meta_data);
			// foreach( $meta_data as $key => $value ){
			// 	if ( str_contains( (string)$key, 'prod-' ) ) {
			// 		$fin_prod = explode( ',', $value[0] );
			// 	}
			// } 
			?>
			<?php 
			echo FO_manage_order_add_order( $order, $visualize ); // phpcs:ignore
			?>
		<?php $count++; } ?>
		</tbody>
	</table>
<!-- </div> -->
<!-- </form> -->

</div>
<script type="text/javascript">
	FO_inizialize_timer();
	console.log(window);

	var sticky = document.getElementsByClassName('sticky')[0];
	var jSticky = jQuery('.sticky').clone().prependTo( "#result-container tbody" );
	jSticky.css('position','fixed');jSticky.css('top','0');
	jSticky.css('display','none');
	var stickyAnchor = sticky.parentNode;
	var state = false;
	function getAnchorOffset() {
	  return stickyAnchor.getBoundingClientRect().top;
	}
	updateSticky = function (e) {
	  if (!state && getAnchorOffset() < 0) {
	  	jSticky.slideDown();
	    // sticky.classList.add('is-sticky');
	    state = true;
	  } else if (state && getAnchorOffset() >= 0) {
	  	jSticky.slideUp();
	    // sticky.classList.remove('is-sticky');
	    state = false;
	  }
	};
	// window.addEventListener('scroll', updateSticky);
	// window.addEventListener('resize', updateSticky);
	// updateSticky();
</script>

<?php





