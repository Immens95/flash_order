<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://innovazioneweb.com
 * @since      1.0.0
 *
 * @package    Flash_order
 * @subpackage Flash_order/admin
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//add_action(
//    'admin_enqueue_scripts',
//    function() {
//      wp_enqueue_script( 'flash-order-admin', plugin_dir_url(__FILE__) . 'js/flash-order-admin.js', array('jquery'), '1.0', true );
//    }
//);

function FO_initial_setup(){
    //product_ingredients_tax
}


function FO_menu_page(){
    $menu_slug = 'flash_order';
    $position = (FO_get_meta( 'FO_menu_order') != '')?FO_get_meta( 'FO_menu_order') : '15';

    $link = get_home_url().'/wp-content/plugins/flash_order/includes/img/logo-20.webp';

   add_menu_page( 'FlashOrder', esc_html__( 'FlashOrder', 'flash_order' ), 'manage_options', $menu_slug, 'FO_main_menu_page', $link, $position );
   add_submenu_page( $menu_slug, 'flash_order_settings', esc_html__( 'Settings', 'flash_order' ), 'manage_options', $menu_slug.'_settings', 'FO_sub_menu_page_settings' );
   add_submenu_page( $menu_slug, 'flash_order_style', esc_html__( 'Style', 'flash_order' ), 'manage_options', $menu_slug.'_style', 'FO_sub_menu_page_style' );

   add_submenu_page( $menu_slug, 'flash_order_addons', esc_html__( 'Addons', 'flash_order' ), 'manage_options', $menu_slug.'_addons', 'FO_sub_menu_page_addons' );
   add_submenu_page( $menu_slug, 'flash_order_pro', esc_html__( 'Pro', 'flash_order' ), 'manage_options', $menu_slug.'_pro', 'FO_sub_menu_page_pro' );
}
add_action( 'admin_menu', 'FO_menu_page' );

function FO_head_menu_page(){
    // FO_debug(wp_get_attachment_image(1));
    ?>
    <div id="FOadminContent">
    <h1 style="margin:30px 0px;display:flex;"> 
        <img src="<?php echo wp_kses_post('https://innovazioneweb.com/wp-content/uploads/2023/10/cropped-logo-512-transparent-bg.png');//phpcs:ignore?>" width="50" height="50" alt="light logo">
        Flash Order 
        <img src="<?php echo wp_kses_post('https://innovazioneweb.com/wp-content/uploads/2024/09/logo-512.png');//phpcs:ignore?>" width="50" height="50" alt="light logo">
        <!-- <button class="FOzero FObutton" onclick="FOtutorialPage();" style="margin: 0px 20px 0px auto!important;padding: 0px 10px!important;"> tutorial </button>  -->
    </h1>
    <?php

}

function FO_nav_menu_page(){
    $color1 = 'var(--fo-main-color)';
    $color2 = 'var(--fo-bg3-color)';
    $FlashOrder_color = ( $_REQUEST['page'] == 'flash_order' )? $color1 : $color2;//phpcs:ignore
    $Settings_color = ( $_REQUEST['page'] == 'flash_order_settings' )? $color1 : $color2;//phpcs:ignore
    $Style_color = ( $_REQUEST['page'] == 'flash_order_style' )? $color1 : $color2;//phpcs:ignore
    $Addons_color = ( $_REQUEST['page'] == 'flash_order_addons' )? $color1 : $color2;//phpcs:ignore
    $Pro_color = ( $_REQUEST['page'] == 'flash_order_pro' )? $color1 : $color2;//phpcs:ignore
    FO_head_menu_page();
    ?>
    <nav class="FOMainNav">
        <a href="admin.php?page=flash_order" class="FOMainNavEl" style="background-color:<?php echo esc_attr($FlashOrder_color); ?>;">
        <?php esc_html_e( 'FlashOrder', 'flash_order' ); ?></a>
        <a href="admin.php?page=flash_order_settings" class="FOMainNavEl" style="background-color:<?php echo esc_attr($Settings_color); ?>;">
        <?php esc_html_e( 'Settings', 'flash_order' ); ?></a>
        <a href="admin.php?page=flash_order_style" class="FOMainNavEl" style="background-color:<?php echo esc_attr($Style_color); ?>">
        <?php esc_html_e( 'Style', 'flash_order' ); ?></a>
        <a href="admin.php?page=flash_order_addons" class="FOMainNavEl" style="background-color:<?php echo esc_attr($Addons_color); ?>">
        <?php esc_html_e( 'Addons', 'flash_order' ); ?></a>
        <a href="admin.php?page=flash_order_pro" class="FOMainNavEl" style="background-color:<?php echo esc_attr($Pro_color); ?>">
        <?php esc_html_e( 'Pro', 'flash_order' ); ?></a>
    </nav>
    <?php
}
function FO_foot_menu_page( $debug = false ){
    ?>
    </div>
    <?php
    if ( $debug ) {
        FO_debug( $_POST );//phpcs:ignore
    }
}
function FO_main_menu_page(){
FO_nav_menu_page();
include( plugin_dir_path( __FILE__ ) . 'pages/main.php');
FO_foot_menu_page();
}
function FO_sub_menu_page_settings(){
FO_nav_menu_page();
include( plugin_dir_path( __FILE__ ) . 'pages/general-settings.php');
FO_foot_menu_page();
}
function FO_sub_menu_page_style(){
FO_nav_menu_page();
include( plugin_dir_path( __FILE__ ) . 'pages/style.php');
FO_foot_menu_page();
}
function FO_sub_menu_page_addons(){
FO_nav_menu_page();
include( plugin_dir_path( __FILE__ ) . 'pages/addons.php');
FO_foot_menu_page();
}
function FO_sub_menu_page_pro(){
FO_nav_menu_page();
include( plugin_dir_path( __FILE__ ) . 'pages/pro.php');
FO_foot_menu_page();
}


function FO_style_setting( $setting, $style, $type ){
    $style = ( $style == null ) ? FO_customized_css() : $style;
    if ( $type == 'color' ) {
        $background_color = $style[$setting];
    }
    ?>
    <div class="FOsettingStyle" id="<?php echo 'setting'. esc_attr($setting); ?>"style="background-color:<?php echo esc_attr($background_color); ?>" onclick="document.getElementById(<?php echo'`'.esc_attr($setting).'`';?>).click();">
        <p title="<?php echo esc_attr($setting); ?>"> <?php echo esc_attr($setting); ?>
            <input id="<?php echo esc_attr($setting); ?>" type="<?php echo esc_attr($type); ?>" name="css[<?php echo esc_attr($setting); ?>]" value="<?php echo esc_attr($style[$setting]); ?>" oninput="document.getElementById(<?php echo'`setting'.esc_attr($setting).'`';?>).style.backgroundColor = this.value;">
            <span class="dashicons dashicons-image-rotate pointer" onclick="FO_adm_restore_prev_prev( this, <?php echo "'".esc_attr($style[$setting])."'";?> )"></span>
        </p>
    </div>
    <?php
}

function FO_new_style_setting( $setting, $args = array() ){
    $default_css = FO_default_css();
    $args['type'] = (isset($args['type']) && $args['type']!='')?$args['type']:'color';

    $set_val = FO_get_meta($setting);

    if ( $args['type'] == 'color' ) {
        $background_color = $set_val;
    }
    ?>
    <div class="FOsettingStyle" id="<?php echo 'setting'.esc_attr($setting); ?>"style="background-color:<?php echo esc_attr($background_color); ?>" onclick="document.getElementById(<?php echo'`'.esc_attr($setting).'`';?>).click();">
        <p title="<?php echo esc_attr($setting); ?>"> <?php echo esc_attr($setting); ?>
            <input id="<?php echo esc_attr($setting); ?>" type="<?php echo esc_attr($args['type']); ?>" name="css[<?php echo esc_attr($setting); ?>]" value="<?php echo esc_attr($set_val); ?>" oninput="document.getElementById(<?php echo'`setting'.esc_attr($setting).'`';?>).style.backgroundColor = this.value;">
            <span class="dashicons dashicons-image-rotate pointer" onclick="FO_adm_restore_prev_prev( this, <?php echo "'".esc_attr($default_css[$setting])."'";?> )" title="<?php esc_html_e('Ripristina il valore di default', 'flash_order' );?>"></span>
        </p>
    </div>
    <?php
}
//function FO_settings_loop(){
//    $settings = (array)json_decode( FO_get_meta( 'settings' ) );
//}



function FO_general_setting( $setting = array() ){
    $name = ( isset($setting['name']) ) ? $setting['name'] : '';
    $title = ( isset($setting['title']) ) ? $setting['title'] : '';
    $default = ( isset($setting['default']) ) ? $setting['default'] : null;
    $data_default = ( FO_get_meta($name) ) ? FO_get_meta($name) : $default;
    $options = ( isset($setting['options']) ) ? $setting['options'] : array();
    $type = ( isset($setting['type']) ) ? $setting['type'] : 'text';
    $class = ( isset($setting['class']) ) ? $setting['class'] : '';
    $text = ( isset($setting['text']) ) ? $setting['text'] : '';
    $info = ( isset($setting['info']) ) ? $setting['info'] : '';
    $other = ( isset($setting['other']) ) ? $setting['other'] : '';

    $id = ( isset($setting['id']) ) ? $setting['id'] : '';
    $bool = ( isset($setting['bool']) ) ? $setting['bool'] : '';
    ?>
<?php //FO_debug( array_diff(scandir(plugin_dir_path( __DIR__ ) . 'includes/audio/'), array('..', '.') ) );?>

    <div id="<?php echo esc_attr($id);?>" class="FOsettingEl <?php echo esc_attr($class);?>" title="<?php echo esc_attr($info).' ______ '.esc_html_e('nome dell\'impostazione nel database: ( ', 'flash_order').esc_attr($name).' )';?>">
        <?php if($title != ''){ ?>
            <strong class="FOtextSettings" style="flex-basis:100%"><?php echo esc_attr($title);?></strong>
        <?php }?>
        <p class="FOtextSettings"><?php echo esc_attr($text);?></p>
        <?php if($type == 'audio'){ 
            $audio = ( FO_get_meta('fo_notify_audio') ) ? FO_get_meta('fo_notify_audio') : '';
            $options = array_diff(scandir(plugin_dir_path(__DIR__).'includes/audio/'),array('..', '.'));
            ?>
            <select name="setting[<?php echo esc_attr($name); ?>]" value="<?php echo esc_attr($data_default); ?>" onchange="addSrcToAudio(this.value);" <?php echo esc_attr($other);?>>
                <option selected disabled hidden><?php esc_html_e('Seleziona l\'audio...', 'flash_order'); ?></option>
                <?php if ( count($options) ) { ?>
                    <?php foreach ($options as $option) { ?>
                        <option value="<?php echo esc_url(get_home_url()).'/wp-content/plugins/flash_order/includes/audio/'.esc_attr($option);?>"><?php echo esc_attr($option);?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <audio id="FOadminAudio" controls autoplay>
              <source  src="<?php echo esc_attr($audio);?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <script>
              var audio = document.getElementById("FOadminAudio");
              audio.volume = 0.1;
            </script>
        <?php } elseif($type == 'textarea'){ ?>
           <textarea type="<?php echo esc_attr($type);?>" name="setting[<?php echo esc_attr($name);?>]" <?php echo esc_attr($other);?>><?php echo esc_attr($data_default);?></textarea>
        <?php } elseif ($type != 'select') { ?>
            <input type="<?php echo esc_attr($type); ?>" name="setting[<?php echo esc_attr($name); ?>]" value="<?php echo esc_attr($data_default);?>" <?php echo esc_attr($other);?>>
        <?php } else{ ?>
            <select name="setting[<?php echo esc_attr($name); ?>]" value="<?php echo esc_attr($data_default); ?>" <?php echo esc_attr($other);?>>
                <option selected disabled hidden><?php echo esc_attr($data_default); ?></option>
                <?php if ( count($options) ) { ?>
                    <?php foreach ($options as $option) { ?>
                        <option value="<?php echo esc_attr($option);?>"><?php echo esc_attr($option);?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        <?php } ?>
        <?php if ( $default != '' ) { ?>
            <span class="dashicons dashicons-image-rotate pointer" onclick="FO_adm_restore_prev_prev( this, <?php echo "'".esc_attr($default)."'";?> )"></span>
        <?php } ?>
    </div>

    <?php
}


function FO_conditional_setting( $setting = array() ){
    $name = ( isset($setting['name']) ) ? $setting['name'] : '';
    $title = ( isset($setting['title']) ) ? $setting['title'] : '';

    $default = ( isset($setting['default']) ) ? $setting['default'] : '';
    $data_default = ( FO_get_meta($name) ) ? FO_get_meta($name) : $default;

    $options = ( isset($setting['options']) ) ? $setting['options'] : array();
    $type = ( isset($setting['type']) ) ? $setting['type'] : 'text';

    $id = ( isset($setting['id']) ) ? $setting['id'] : '';
    $class = ( isset($setting['class']) ) ? $setting['class'] : '';

    $text = ( isset($setting['text']) ) ? $setting['text'] : '';
    $info = ( isset($setting['info']) ) ? $setting['info'] : '';
    $other = ( isset($setting['other']) ) ? $setting['other'] : '';

    $bool = ( isset($setting['bool']) ) ? $setting['bool'] : '';
    $fo_dep = ( isset($setting['fo_dep']) ) ? $setting['fo_dep'] : '';
    $target_bool = ( isset($setting['target_bool']) ) ? $setting['target_bool'] : '';
    ?>

    <div id="<?php echo esc_attr($id);?>" class="FOsettingEl <?php echo esc_attr($class);?>" title="<?php echo esc_attr($info).' ______ '.esc_html_e('nome dell\'impostazione nel database: ( ', 'flash_order').esc_attr($name).' )';?>" fo_val="<?php echo esc_attr($data_default);?>" fo_dep="<?php echo esc_attr($fo_dep);?>">
        <?php if ($title != '') { ?>
            <strong class="FOtextSettings" style="flex-basis:100%"><?php echo esc_attr($title);?></strong>
        <?php } ?>
        <p class="FOtextSettings"><?php echo esc_attr($text);?></p>
        <?php if ($type == 'radio') { ?>
            <input type="<?php echo esc_attr($type); ?>" name="setting[<?php echo esc_attr($name); ?>]" value="<?php echo esc_attr($data_default);?>" <?php echo esc_attr($other);?>>
        <?php } elseif ($type == 'select'){ ?>
            <select name="setting[<?php echo esc_attr($name);?>]" value="<?php echo esc_attr($data_default);?>" onchange="FO_condition_setting(this);" fo_bool="<?php echo esc_attr($bool);?>" target_bool="<?php echo esc_attr($target_bool);?>" <?php echo esc_attr($other);?>>
                <option selected disabled hidden><?php echo esc_attr($data_default);?></option>
                <?php if ( count($options) ) { ?>
                    <?php foreach ($options as $option) { ?>
                        <option value="<?php echo esc_attr($option);?>"><?php echo esc_attr($option);?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        <?php } else{

        } ?>
        <?php if ( $default != '' ) { ?>
            <span class="dashicons dashicons-image-rotate pointer" onclick="FO_adm_restore_prev_prev( this, <?php echo "'".esc_attr($default)."'";?> )"></span>
        <?php } ?>
    </div>

    <?php
}

function FO_set_local_network( $setting = array() ){
    $net_info = FO_get_connection_info();

    $name = ( isset($setting['name']) ) ? $setting['name'] : '';

    $data_default = ( FO_get_meta('fo_limit_ip_to_local_network') ) ? FO_get_meta('fo_limit_ip_to_local_network') : '';

    $class = ( isset($setting['class']) ) ? $setting['class'] : '';

    $text = ( isset($setting['text']) ) ? $setting['text'] : '';
    $info = ( isset($setting['info']) ) ? $setting['info'] : '';
    $other = ( isset($setting['other']) ) ? $setting['other'] : '';

    $bool = ( isset($setting['bool']) ) ? $setting['bool'] : 'yes';
    $fo_dep = ( isset($setting['fo_dep']) ) ? $setting['fo_dep'] : '#FO_limit_ip_to_local_network';
    ?>
    <div id="FO_select_local_network" class="FOsettingEl <?php echo esc_attr($class);?>" title="" style="max-width:100%;flex-basis:100%;" fo_val="<?php echo esc_attr($data_default);?>" fo_dep="<?php echo esc_attr($fo_dep);?>">
        <strong class="FOtextSettings title" style="flex-basis:100%;">
            <?php esc_html_e('Impostazioni di rete', 'flash_order' );?>
        </strong>
        <input type="text" name="setting[ipv4]" value="<?php echo esc_attr($net_info['ip']);?>">
    </div>
    <?php 
}

function FO_save_settings( $args, $assoc_id = '', $debug = false ){
    if ( isset($_POST["update"]) && current_user_can( 'manage_options' ) ) {
        if ( isset($_POST['_fononce_save_settings']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_fononce_save_settings'])), 'FO_save_settings' ) ) {
            return;
        }
        if ( isset( $_POST[$args] ) ) { 
            $sany_args = FO_recursive_sanitize_text_field(wp_unslash($_POST[$args]));//phpcs:ignore
            foreach ($sany_args as $key => $value) {
                FO_update_meta( sanitize_text_field(wp_unslash($key)), sanitize_text_field(wp_unslash($value)), $assoc_id ); 
            }
        }
        if ( isset( $_POST['PGSett'] ) ) { 
            $assoc_id = 'page_settings';
            foreach ( $_POST['PGSett'] as $PGSett_K => $PGSett_V ) {//phpcs:ignore
                // foreach ( $PGSett as $key => $value ) {
                //     FO_update_meta( sanitize_text_field(wp_unslash($PGSett_K)), sanitize_text_field(wp_unslash($vl)), $assoc_id ); 
                // }
                $settings = json_decode(FO_get_meta( sanitize_text_field(wp_unslash($PGSett_K)) ));

                $default_sett = array(
                  'showHead'    => 'yes',
                  'showFoot'    => 'yes',
                  'showQR'      => 'yes',
                  'OverColor'   => 'no',
                  'BGColor'     => '#00000f',
                  'TextColor'   => '#ffffff',
                  'EXTCss'      => 'body, header, footer',
                  'info'        => '',
                  'last_update' => wp_date('Y-m-d H:i:s')
                  );

                $new_sett = wp_parse_args( $settings, $default_sett );

                $fin_sett = wp_parse_args( $PGSett_V, $new_sett );

                FO_update_meta( sanitize_text_field(wp_unslash($PGSett_K)), wp_json_encode($fin_sett), $assoc_id ); 
            }
        }
        if ($debug) {
            FO_debug($_POST);
        } else{
            if (isset($_SERVER['REQUEST_URI'])) {
                $req_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
                $url = 'Location: '. $req_uri;
                header( $url );
            }
        }
    }
}

function FO_get_post_by_post_name( $slug = '', $post_type = '' ) {
    //Make sure that we have values set for $slug and $post_type
    if ( !$slug  || !$post_type ){
        return false;
    }
    // We will not sanitize the input as get_page_by_path() will handle that
    $post_object = get_page_by_path( $slug, OBJECT, $post_type );
    if ( !$post_object )
        return false;

    return $post_object;
}

function FO_manage_pages( $setting = array() ){
    $fo_pages = FO_get_meta_by_assoc_id( 'page_id', 'OBJECT' );
?>
    <div class="FOsettingEl"style="max-width:100%;flex-basis:100%;">
        <strong class="FOtextSettings title" style="flex-basis:100%;">
            <?php esc_html_e('Gestione Pagine del Plugin', 'flash_order'); ?>
        </strong> 
        <?php foreach ($fo_pages as $key => $value) {
            if ( get_post( $value->meta_value ) == null ) {
                FO_delete_meta( $value->meta_key );
                continue;
            }
            ?>
            <div class="FOsettingEl">
                <strong class="FOtextSettings"style="flex-basis:100%;">
                    <?php 
                    echo esc_attr(substr($value->meta_key, 8)); ?>
                </strong>
                 <?php
                    echo '<p class="FOtextSettings">'.esc_html__('Ultima modifica della pagina: ', 'flash_order').esc_attr(FO_get_meta('last_update_'.substr($value->meta_key, 8))).'</p>';
                    echo '<p class="FOtextSettings">'.esc_html__('l\'ID della pagina é: ', 'flash_order').esc_attr($value->meta_value).'</p>';
                    echo '<p class="FOtextSettings">'.esc_html__('la versione della pagina é: ', 'flash_order').esc_attr(FO_get_meta('page_version_'.substr($value->meta_key, 8))).'</p>';
                ?>
                <div class="FObutton" style="height:20px;cursor:pointer;" onclick="FO_toggle_pages_rapid_impost(<?php echo '`'.esc_attr($value->meta_value).'`'?>)">
                    <?php esc_html_e('IMPOSTAZIONI', 'flash_order');?>
                </div>

                <?php FO_get_pages_impost($value->meta_value);?>

                <div class="FObutton" style="height:20px;cursor:pointer;" onclick="FO_delete_page(<?php echo "'".esc_attr( substr($value->meta_key, 8) )."'"; ?>);">
                    <?php esc_html_e('ELIMINA pagina', 'flash_order');?>
                </div>
                <a class="FObutton" style="height:20px;cursor:pointer;text-decoration:none;" href="<?php echo esc_attr(get_home_url()).'?p='.esc_attr($value->meta_value);?>">
                    <?php esc_html_e('VISITA pagina', 'flash_order');?>
                </a>
            </div>
       <?php } ?>
        <div class="FObutton" style="height:20px;cursor:pointer;" onclick="FO_create_refresh_pages();" title="<?php esc_html_e( 'Aggiorna tutte le pagine necessarie al plugin, e se non sono ancora state create, le Crea.', 'flash_order' );?>">
             <?php esc_html_e('CREA o AGGIORNA pagine', 'flash_order');?>
        </div>
        <!-- <span class="dashicons dashicons-image-rotate pointer" onclick=""></span> -->
    </div>
<?php
}




function FO_coming_soon( $args = array() ){
    //$name = ( isset($args['name']) ) ? $args['name'] : '';
    ?>
    <div class="FOcomingSoon">
        <?php 
        echo esc_html__('questa sezione è in costruzione, stiamo lavorando in continuazione e questa sezione sarà presto disponibile.', 'flash_order'); 
        //FO_submit_suggestions();
        ?>
    </div>
    <?php
}



function FO_pass_to_pro(){
    ?>
    <div class="FO_section">
        <?php 
        echo esc_html__( 'Questa sezione é destinata alla versione pro del plugin (Flash Order Pro)', 'flash_order' ); 
        ?>
    </div>
    <?php
    FO_watch_flash_order_pro();
}

function FO_donate(){
    ?>
    <div class="FO_section">
        <?php 
        esc_html_e('Se vuoi sostenerci con una donazione, ','flash_order');
        echo '<a href="https://innovazioneweb.com/donate" target="_blank">'.esc_html__(' Visita Questa Pagina ','flash_order').'</a>';
        esc_html_e('. Ogni tuo gesto è per noi un prezioso impegno, e siamo lieti di ascoltare le tue proposte e suggerimenti.','flash_order');
        ?>
    </div>
    <?php
}

function FO_submit_suggestions(){
    ?>
    <div class="FO_section">
        <?php 
        esc_html_e('Se desideri darci un feedback o fare una richiesta, ','flash_order');
        echo '<a href="https://innovazioneweb.com/feedback" target="_blank">'.esc_html__(' Clicca QUI ','flash_order').'</a>';
        esc_html_e('. Siamo sempre pronti ad ascoltare le tue opinioni e suggerimenti, impegnandoci al massimo per soddisfare ogni tua richiesta con attenzione e dedizione.','flash_order');
        ?>
    </div>
    <?php
}

function FO_watch_flash_order_pro(){
    ?>
    <div class="FO_section">
        <?php 
        echo esc_html__( ' Puoi vedere il Plugin Qui: ', 'flash_order' ); 
        ?>
        </br>
        <a href="https://innovazioneweb.com/flash-order-pro"> Flash Order Pro </a>
    </div>
    <?php
}



















