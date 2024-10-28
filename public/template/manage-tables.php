<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

    FO_access_denied();

    do_action( 'manage_tables_page_head' );

function FO_manage_table(){

    $tavoli = get_posts( array(
        'numberposts'      => -1,
        'orderby'          => 'title',
        'order'            => 'ASC',
        'post_type'        => 'tavoli',
    ) );
    
    $nonce = wp_create_nonce( 'FO_insert_post_ajax_nonce' );
    echo '<input type="hidden" id="_fononce_insert_post_ajax_nonce" name="_fononce_insert_post_ajax_nonce" value="'.esc_attr($nonce).'" />';
    
    FO_get_settings_head_manage_tables();
?>
<div id="FO_Front_Content">
    <?php 
        if (function_exists('FOP_tab_status_bar')){FOP_tab_status_bar();}

        if (function_exists('FOP_tab_Statistics_section')){ 
            FOP_tab_Statistics_section(); 
        } 

        if (function_exists('FOP_tab_Settings_section')){
            FOP_tab_Settings_section($tavoli);
        ?>
        <div class="fo_button fo_show_settings" onclick="FO_settings_show();">
            <span class="dashicons dashicons-admin-settings" style="width:40px;height:40px;font-size:40px;"></span>
        </div>

    <?php }?>

    <div class="FO_table_grid">
        <div class="FOloadingCardPublic FOloadingCardPublicMain tab_fix_load" style="">
            <span style="animation: fospin 1s infinite;font-size:120px;width:120px;height:120px;" class="dashicons dashicons-update"></span>
        </div>
        
        <?php 

        foreach ( $tavoli as $key => $tavolo ) {
        $zone = get_the_terms( $tavolo->ID, 'zone' );
        $macro_status = get_the_terms( $tavolo->ID, 'status' );
        $status = FO_get_meta( 'status_table_'.$tavolo->ID );
        // FO_debug($status);
        if ( $macro_status != false ) {
            if ($macro_status[0]->name == 'Libero' || $macro_status[0]->name == 'Aperto' || $macro_status[0]->name == 'Open') {
                $tab_check = true;
            } else{
                $tab_check = false;
            }
        } else { $tab_check = true;}
        if ( $tab_check ) {
            if ($status == 0) {
                $Style = 'background-color:green;';$status_string = __( 'Libero', 'flash_order' );
            } elseif ($status == 1) {
                $Style = 'background-color:red;';$status_string = __( 'Occupato', 'flash_order' );
            } elseif ($status == 2) {
                $Style = 'background-color:yellow;';$status_string = __( 'Libero', 'flash_order' );
            } else{
                $Style = 'background-color:var(--fo-bg4-color);';$status_string = '';
            }
        } else{
            $Style = 'background-color:var(--fo-bg4-color);';$status_string = '';
        }
            $tab_info = FO_get_table_by_table_number_status_last($tavolo->post_title);
            ?>
            <div class="fo_table_cell relative" fotable="<?php echo esc_attr($tavolo->post_title);?>" fo_tableid="<?php echo esc_attr($tavolo->ID);?>" fotable_status="<?php echo esc_attr($status);?>" style="<?php echo esc_attr($Style);?>" onclick="FO_tab_Card_show( this )">
                <span class="fo_tab_notify" fo_not_counter="" onclick="" style="display:none;">0</span>
                <span class="fo_tab_abs_info dashicons dashicons-info" onclick="" style="display: none;"></span>
                <div class="FOloadingTable" style="display:none;">
                    <span style="animation: fospin 1s infinite;font-size:120px;width:120px;height:120px;" class="dashicons dashicons-update"></span>
                </div>
                <h6> <?php echo esc_attr($tavolo->post_title);?> </h6>
                <?php if ( $zone != false ) {
                foreach ($zone as $k => $zona) { ?>
                    <strong> <?php echo esc_attr($zona->name);?> </strong>
                <?php } } ?>
                <p class="fo_status_string"> <?php echo esc_attr($status_string);?> </p>
                <?php 
                // if ( $status >= 1 ) { 
                	// if ( $tab_info != null ) {
                    $date = new DateTime($tavolo->last_update);?>
                    <span class="fo_tab_abs_data" title="<?php esc_html_e( 'Ora e data dell\'ultima modifica', 'flash_order' );?>"><?php echo esc_attr(date_format($date, 'H:i:s d/m')); ?></span>
                <?php 
            // } 
            		// } 
            	?>
            </div>
        <?php } ?>
        <?php FO_flash_tab_order( $tavoli );?>
    </div>

    <?php if (function_exists('FOP_tab_Catering_section')){ FOP_tab_Catering_section(); } ?>

    <script type="text/javascript">
        // console.log(window);
        jQuery(window).on('load', function() {
            jQuery(".FOloadingCardPublicMain").fadeOut(200);
            fo_toggle_header_footer(true);
        });
        //jQuery(document).bind("touchstart", function(e) {
        //	if (true) {
        //		if ( e.target == '.fo_tab_prod_story') {
		//
        //		}
        //		
        //	}
		//});
    </script>

</div>

<?php

}

FO_manage_table();







