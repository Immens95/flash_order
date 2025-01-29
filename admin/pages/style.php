<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$style = FO_customized_css();
?>
<div id="settSection">
<form id="" method="post" class="FOForm">
    <button name="update" value="update" class="FObutton pointer" style="position:sticky;margin: 10px 10px 10px auto;top:45px;"> <?php esc_html_e( 'SALVA', 'flash_order' ); ?> </button>

    <?php 
    $nonce = wp_create_nonce( 'FO_save_settings' );
    echo '<input type="hidden" id="_fononce_save_settings" name="_fononce_save_settings" value="'.esc_attr($nonce).'"/>'; 
    ?>
    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori principali', 'flash_order' ); ?> </b>
    </div>
<!-- </div style="width:100%;display:flex;flex-wrap:wrap;align-items:center;padding:10px;margin:10px;"> -->
    <div class="FOFormZone">
    <?php FO_new_style_setting('--fo-main-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-scnd-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-high-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-invert-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-link-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-selection-color', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-error-color', array('type'=>'color')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori di Background principali', 'flash_order' ); ?> </b>
    </div>
    <div class="FOFormZone">
        <?php FO_new_style_setting('--fo-bg-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-bg2-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-bg3-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-bg4-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-bg5-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-bg6-color', array('type'=>'color')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori dei testi e effetti', 'flash_order' ); ?> </b>
    </div>
    <div class="FOFormZone">
        <?php FO_new_style_setting('--fo-text-color', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-text-color-inv', array('type'=>'color')); ?>
        <?php FO_new_style_setting('--fo-text-shadow', array('type'=>'text')); ?>
        <?php FO_new_style_setting('--fo-main-border', array('type'=>'text')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Tempi delle animazioni', 'flash_order' ); ?> </b>
    </div>
    <div class="FOFormZone">
        <?php FO_new_style_setting('--fo-main-tran', array('type'=>'text')); ?>
        <?php FO_new_style_setting('--fo-scnd-tran', array('type'=>'text')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori degli status degli ordini di woocommerce', 'flash_order' ); ?> </b>
    </div>
    <div class="FOFormZone">
    <?php FO_new_style_setting('--fo-pending', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-processing', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-failed', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-cancelled', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-refunded', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-completed', array('type'=>'color')); ?>
    
    <?php FO_new_style_setting('--fo-modified', array('type'=>'color')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori della gestione tavoli', 'flash_order' ); ?> </b>
    </div>

    <div class="FOFormZone">
    <?php FO_new_style_setting('--fo-tab-1', array('type'=>'color') ); ?>
    <?php FO_new_style_setting('--fo-tab-2', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-tab-3', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-tab-4', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-tab-5', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-tab-6', array('type'=>'color')); ?>
    </div>

    <div class="FOFormSeparator">
        <b> <?php esc_html_e( 'Colori degli status del timer', 'flash_order' ); ?> </b>
    </div>

    <div class="FOFormZone">
    <?php FO_new_style_setting('--fo-timer-1', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-timer-2', array('type'=>'color')); ?>
    <?php FO_new_style_setting('--fo-timer-3', array('type'=>'color')); ?>
    </div>
<!-- </div> -->
  <button name="update" value="update" class="FObutton pointer" style="margin: 10px auto;"> <?php esc_html_e( 'SALVA', 'flash_order' ); ?> </button>
</form>
</div>
<?php

FO_save_settings( 'css', 'style_css' );

//if ( isset($_POST["update"]) && current_user_can( 'manage_options' ) ) {

    //if ( isset($_POST["css"]["--fo-main-color"]) ) { FO_update_meta('--fo-main-color',$_POST["css"]["--fo-main-color"],'style_css//'); }
    //if ( isset($_POST["css"]["--fo-scnd-color"]) ) { FO_update_meta('--fo-scnd-color',$_POST["css"]["--fo-scnd-color"],'style_css//'); }
    //if ( isset($_POST["css"]["--fo-high-color"]) ) { FO_update_meta('--fo-high-color',$_POST["css"]["--fo-high-color"],'style_css'); }
    //if ( isset($_POST["css"]["--fo-invert-color"]) ) { FO_update_meta('--fo-invert-color',$_POST["css"]["--fo-invert-color"],'//style_css'); }
    //if ( isset($_POST["css"]["--fo-link-color"]) ) { FO_update_meta('--fo-link-color',$_POST["css"]["--fo-link-color"],'style_css//'); }
    //if ( isset($_POST["css"]["--fo-selection-color"]) ) { FO_update_meta('--fo-selection-color',$_POST["css"]["//--fo-selection-color"],'style_css'); }
//
    //if ( isset($_POST["css"]["--fo-bg-color"]) ) { FO_update_meta('--fo-bg-color',$_POST["css"]["--fo-bg-color"],'style_css'); }
    //if ( isset($_POST["css"]["--fo-bg2-color"]) ) { FO_update_meta('--fo-bg2-color',$_POST["css"]["--fo-bg2-color"],'style_css');// }
    //if ( isset($_POST["css"]["--fo-bg3-color"]) ) { FO_update_meta('--fo-bg3-color',$_POST["css"]["--fo-bg3-color"],'style_css');// }
    //if ( isset($_POST["css"]["--fo-bg4-color"]) ) { FO_update_meta('--fo-bg4-color',$_POST["css"]["--fo-bg4-color"],'style_css');// }
    //if ( isset($_POST["css"]["--fo-bg5-color"]) ) { FO_update_meta('--fo-bg5-color',$_POST["css"]["--fo-bg5-color"],'style_css');// }
    //if ( isset($_POST["css"]["--fo-bg6-color"]) ) { FO_update_meta('--fo-bg6-color',$_POST["css"]["--fo-bg6-color"],'style_css');// }
//
    //if ( isset($_POST["css"]["--fo-text-color"]) ) { FO_update_meta('--fo-text-color',$_POST["css"]["--fo-text-color"],'style_css//'); }
    //if ( isset($_POST["css"]["--fo-text-color-inv"]) ) { FO_update_meta('--fo-text-color-inv',$_POST["css"]["--fo-text-color-inv"//],'style_css'); }
    //if ( isset($_POST["css"]["--fo-text-shadow"]) ) { FO_update_meta('--fo-text-shadow',$_POST["css"]["--fo-text-shadow"],'//style_css'); }
    //if ( isset($_POST["css"]["--fo-main-border"]) ) { FO_update_meta('--fo-main-border',$_POST["css"]["--fo-main-border"],'//style_css'); }
//
    //if ( isset($_POST["css"]["--fo-main-tran"]) ) { FO_update_meta('--fo-main-tran',$_POST["css"]["--fo-main-tran"],'style_css');// }
    //if ( isset($_POST["css"]["--fo-scnd-tran"]) ) { FO_update_meta('--fo-scnd-tran',$_POST["css"]["--fo-scnd-tran"],'style_css'); }
//}














