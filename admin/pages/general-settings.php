<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// global $wp;
// echo $_SERVER['REQUEST_URI'];
// FO_debug($_SERVER);
$disp_general = 'display:none;';

if ( isset($_GET['sub']) ){//phpcs:ignore
    if ( $_GET['sub'] == 'general' || $_GET['sub'] == '' ) {//phpcs:ignore
        $disp_general = 'display:flex;';
    }
    if ( $_GET['sub'] == 'pro' ) {//phpcs:ignore
        $disp_pro = 'display:flex;';
    }
    if ( $_GET['sub'] == 'WooPrint' ) {//phpcs:ignore
        $disp_WooPrint = 'display:flex;';
    }
    if ( $_GET['sub'] == 'FOWarehouse' ) {//phpcs:ignore
        $disp_FOWarehouse = 'display:flex;';
    }
} else{
    $disp_general = 'display:flex;';
}





?>
<nav>
    <?php do_action('fo_settings_navigation_start') ?>
    <button onclick="FO_settings_navigations( jQuery('#general') );">General</button>

    <?php do_action('fo_settings_navigation_end') ?>
</nav>


<div id="settSection">
<form id="general" method="post" class="FOForm" style="<?php echo esc_attr($disp_general); ?>">
    <button name="update" value="update" class="FObutton pointer" style="position:sticky;margin: 10px 10px 10px auto;top:45px;"> UPDATE </button>

    <div class="FOFormSeparator" onclick="jQuery(`[board='global']`).slideToggle()">
        <b> <?php esc_html_e('Impostazioni Globali' , 'flash_order'); ?> </b>
        <span class="dashicons dashicons-arrow-down"></span>
    </div>

<!-- global --><div class="FOSetting_Board" board="global">
<?php


    $nonce_save = wp_create_nonce( 'FO_save_settings' );
    echo '<input type="hidden" id="_fononce_save_settings" name="_fononce_save_settings" value="'.esc_attr($nonce_save).'" />';

    $nonce = wp_create_nonce( 'FO_manage_pages' );
    echo '<input type="hidden" id="_fononce_manage_pages" name="_fononce_manage_pages" value="'.esc_attr($nonce).'" />';

// do_action('fo_setting_general_head');

// FO_create_QR_code( array( 'size' => '150', 'post_id' => get_the_ID() ) );

FO_manage_pages();

// FO_general_setting( array( 'name' => 'site_tutorial',
//     'default'   => '',
//     'options'   => array( 'yes', 'no' ),
//     'type'      => 'select',
//     'class'     => '',
//     'text'      => __('fai partire il tutorial dell\'intero sito web' , 'flash_order'),
//     'info'      => __('partirà un tutorial per illustrare tutte le funzionalità del sito, pagina per pagina una volta che si visita', 'flash_order')
// ) );
// FO_general_setting( array( 'name' => 'FO_admin_bar_show',
//     'default'   => '',
//     'options'   => array( 'yes', 'no' ),
//     'type'      => 'select',
//     'class'     => '',
//     'text'      => __('mostra il menù nella admin bar' , 'flash_order'),
//     'info'      => __('mostra il bottone menù nella admin bar', 'flash_order')
// ) );
FO_general_setting( array( 'name' => 'FO_menu_order',
    'default'   => '5',
    'type'      => 'number',
    'class'     => '',
    'text'      => __('posizione del menù admin' , 'flash_order'),
    'info'      => __('inserisci la posizione del pannello menù nel backend', 'flash_order')
) );
FO_general_setting( array( 'name' => 'fo_show_admin_bar_all',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('scegli se mostrare la barra admin', 'flash_order'),
    'info'      => __('scegli se mostrare la barra admin', 'flash_order')
) );

// FO_general_setting( array( 'name' => 'fo_notify_audio',
//     'default'   => '',
//     'options'   => '',
//     'type'      => 'audio',
//     'class'     => '',
//     'text'      => __('seleziona l\'audio delle notifiche per i nuovi ordini nella pagina (manage-order)', 'flash_order'),
//     'info'      => __('la notifica per i nuovi ordini verrà riprodotta nella pagina (manage-order)', 'flash_order')
// ) );

FO_general_setting( array( 'name' => 'fo_pickup_delivery_checkout',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('visualizza la sezione per scegliere la modalità di consegna ( ritiro o consegna ), la data e l\'ora, nella pagina (checkout)', 'flash_order'),
    'info'      => __('visualizza la sezione per scegliere la modalità di consegna (ritiro o consegna), la data e l\'ora, nella pagina (checkout)', 'flash_order')
) );

FO_general_setting( array( 'name' => 'fo_allow_menu_order',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('abilita l\'inserimento ordini dalla pagina del menu ( flash-order-ajax )', 'flash_order'),
    'info'      => __('i clienti potranno inserire gli ordini direttamente dalla pagina del menu', 'flash_order')
) );

/*

?>
    </div>

     <div class="FOFormSeparator" onclick="jQuery(`[board='page_flash_order']`).slideToggle()">
        <b> <?php esc_html_e('Pagina creazione ordini flash (flash-orders)' , 'flash_order'); ?> </b>
        <span class="dashicons dashicons-arrow-down"></span>
    </div>

<!-- page_flash_order --><div class="FOSetting_Board" board="page_flash_order" style="display:none;">
<?php
?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('impostazioni generali' , 'flash_order'); ?> </b>
    </div>
<?php
// FO_general_setting( array( 'name' => 'flash_order_front_name',
//     'default'   => __('TAVOLO','flash_order'),
//     'options'   => '',
//     'type'      => 'text',
//     'class'     => '',
//     'text'      => __('inserisci il nome per la prenotazione degli ordini del tavolo dal front-end nella pagina (flash-order)', 'flash_order'),
//     'info'      => __('il nome del destinatario dell\'ordine, che apparirà quando viene effettuato un\'ordine dal front-end', 'flash_order')
// ) );

FO_general_setting( array( 'name' => 'flash_order_front_surname',
    'options'   => '',
    'type'      => 'textarea',
    'class'     => '',
    'text'      => __('scrivi tutti i soprannomi per i tavoli o per le zone del locale ad es: colonna, giardino, etc...', 'flash_order'),
    'info'      => __('( i nomi devono essere separati dalla virgola )', 'flash_order')
) );

FO_general_setting( array( 'name' => 'flash_order_order_summary',
    'default'   => '',
    'options'   => array('top_page','side_page'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('scegli come visualizzare il riepilogo ordine nella pagina (flash-order)', 'flash_order'),
    'info'      => __('scegli come visualizzare il riepilogo ordine nella pagina (flash-order)', 'flash_order')
) );

?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('visualizza sezioni della Tabella' , 'flash_order'); ?> </b>
    </div>
<?php

FO_general_setting( array( 'name' => 'flash_orders_table_visualize_id',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('id', 'flash_order'),
    'info'      => __('visualizza l\'id del prodotto nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'flash_orders_table_visualize_name',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('nome', 'flash_order'),
    'info'      => __('visualizza il nome del prodotto nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'flash_orders_table_visualize_image',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('immagine', 'flash_order'),
    'info'      => __('visualizza l\'immagine del prodotto nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'flash_orders_table_visualize_warehouse',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('magazzino', 'flash_order'),
    'info'      => __('visualizza la disponibilità in magazzino del prodotto nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'flash_orders_table_visualize_note',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('note', 'flash_order'),
    'info'      => __('visualizza le note del prodotto nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'flash_orders_table_visualize_actions',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('azioni', 'flash_order'),
    'info'      => __('visualizza le azioni possibili per il prodotto nella tabella', 'flash_order')
) );



// FO_general_setting( array( 'name' => 'flash_orders_ajax_visualize_warehouse',
//     'options'   => array('yes','no'),
//     'type'      => 'select',
//     'class'     => '',
//     'text'      => __('azioni', 'flash_order'),
//     'info'      => __('visualizza le azioni possibili per il prodotto nella tabella', 'flash_order')
// ) );




*/
?>
<!-- page_flash_order --></div>

    <div class="FOFormSeparator" onclick="jQuery(`[board='page_manage_order']`).slideToggle()" style="display:none;">
        <b> <?php esc_html_e('Pagina gestione ordini (manage-orders)' , 'flash_order'); ?> </b>
        <span class="dashicons dashicons-arrow-down"></span>
    </div>

<!-- page_manage_order --><div class="FOSetting_Board" board="page_manage_order" style="display:none;">
<?php
?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('impostazioni generali' , 'flash_order'); ?> </b>
    </div>
<?php
FO_general_setting( array( 'name' => 'orders_limit_view',
    'default'   => '200',
    'options'   => '',
    'type'      => 'number',
    'class'     => '',
    'text'      => __('inserisci il numero massimo di ordini da visualizzare nella pagina (manage-order)', 'flash_order'),
    'info'      => __('imposta a "-1" per visualizzare tutti gli ordini', 'flash_order')
) );
FO_general_setting( array( 'name' => 'orders_date_created',
   'default'   => '24',
   'options'   => '',
   'type'      => 'number',
   'class'     => '',
   'text'      => __('inserisci fino a quante ore prima verranno visualizzati gli ordini nella pagina "manage-order"', 'flash_order'),
   'info'      => __('imposta il numero di ore', 'flash_order')
) );
FO_general_setting( array( 'name' => 'ajax_refresh_order_seconds',
    'default'   => '2000',
    'other'     => 'min="500"',
    'options'   => '',
    'type'      => 'number',
    'class'     => '',
    'text'      => __('inserisci ogni quanti millisecondi si aggiornano gli ordini nella pagina (manage-order)', 'flash_order'),
    'info'      => __('il valore minimo è 500 cioé 0.5 secondi ( 1000 millisecondi = 1 secondo )', 'flash_order')
) );

?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('visualizza sezioni della Tabella' , 'flash_order'); ?> </b>
    </div>
<?php

FO_general_setting( array( 'name' => 'manage_orders_table_visualize_id',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('id', 'flash_order'),
    'info'      => __('visualizza l\'id dell\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_name',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('nome', 'flash_order'),
    'info'      => __('visualizza il nome di chi ha effettuato l\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_products',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('prodotti', 'flash_order'),
    'info'      => __('visualizza i prodotti dell\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_info',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('info', 'flash_order'),
    'info'      => __('visualizza le info dell\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_status',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('stato', 'flash_order'),
    'info'      => __('visualizza lo stato dell\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_actions',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('azioni', 'flash_order'),
    'info'      => __('visualizza le azioni possibili per l\'ordine nella tabella', 'flash_order')
) );
FO_general_setting( array( 'name' => 'manage_orders_table_visualize_totals',
    'options'   => array('yes','no'),
    'type'      => 'select',
    'class'     => '',
    'text'      => __('totale', 'flash_order'),
    'info'      => __('visualizza il totale dell\'ordine nella tabella', 'flash_order')
) );


?>
    </div>

    <div class="FOFormSeparator" onclick="jQuery(`[board='advanced']`).slideToggle()">
        <b> <?php esc_html_e('Avanzate' , 'flash_order'); ?> </b>
        <span class="dashicons dashicons-arrow-down"></span>
    </div>

<!-- advanced --><div class="FOSetting_Board" board="advanced" style="display:none;">
<?php

FO_general_setting( array( 'name' => 'custom_shortcode_login',
    'default'   => '[woocommerce_my_account]',
    'type'      => 'textarea',
    'class'     => '',
    'text'      => __('inserisci lo shortcode per effettuare il login dalla finestra pop up. (pagina flash-orders-ajax)', 'flash_order'),
    'info'      => __('inserisci lo shortcode per effettuare il login dalla finestra pop up. (pagina flash-orders-ajax)', 'flash_order')
) );

?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('Tassonomie' , 'flash_order'); ?> </b>
    </div>
<?php
do_action('fo_setting_advanced');
FO_general_setting( array( 'name' => 'product_ingredients_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('INGREDIENTI', 'flash_order'),
    'text'      => __('utilizza la tassonomia per gli ingredienti dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà una nuova tassonomia per selezionare facilmente gli ingredienti di cui è composto un piatto, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'show_product_ingredients_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('VISUALIZZA INGREDIENTI', 'flash_order'),
    'text'      => __('visualizza la tassonomia ingredienti nella pagina del prodotto' , 'flash_order'),
    'info'      => __('mostrerà la tassonomia degli ingredienti di cui è composto un piatto, nella pagina prodotto di woocommerce', 'flash_order')
) );

FO_general_setting( array( 'name' => 'product_allergens_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('ALLERGENI', 'flash_order'),
    'text'      => __('utilizza la tassonomia per gli allergeni dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà una nuova tassonomia per selezionare facilmente gli allergeni di un piatto, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'show_product_allergens_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('VISUALIZZA ALLERGENI', 'flash_order'),
    'text'      => __('visualizza la tassonomia allergeni nella pagina del prodotto' , 'flash_order'),
    'info'      => __('mostrerà la tassonomia degli allergeni di un piatto, nella pagina prodotto di woocommerce', 'flash_order')
) );

FO_general_setting( array( 'name' => 'product_temperature_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('TEMPERATURE', 'flash_order'),
    'text'      => __('utilizza la tassonomia per le temperature' , 'flash_order'),
    'info'      => __('mostrerà una nuova tassonomia per selezionare facilmente le temperature di consegna che possono essere associate ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_sticker_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('STICKER', 'flash_order'),
    'text'      => __('utilizza la tassonomia per gli sticker' , 'flash_order'),
    'info'      => __('mostrerà una nuova tassonomia per selezionare facilmente gli sticker che possono essere associati ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_macro_categories_tax',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('MACRO CATEGORIE', 'flash_order'),
    'text'      => __('utilizza la tassonomia per le macro categorie' , 'flash_order'),
    'info'      => __('mostrerà una nuova tassonomia per selezionare facilmente le macro categorie che possono essere associate ai prodotti di woocommerce', 'flash_order')
) );
// FO_general_setting( array( 'name' => 'show_product_temperature_tax',
//     //'default'   => '',
//     'options'   => array( 'yes', 'no' ),
//     'type'      => 'select',
//     'class'     => '',
//     'text'      => __('visualizza la tassonomia allergeni nella pagina prodotto' , 'flash_order'),
//     'info'      => __('mostrerà la tassonomia degli allergeni di un piatto, nella pagina prodotto di woocommerce', 'flash_order')
// ) );
?>
    <div class="FOFormCategory">
        <b> <?php esc_html_e('Immagini delle Tassonomie' , 'flash_order'); ?> </b>
    </div>
<?php

FO_general_setting( array( 'name' => 'product_ingredients_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('INGREDIENTI', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per gli ingredienti dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia degli ingredienti, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_allergens_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('ALLERGENI', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per gli allergeni dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia degli allergeni, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_temperature_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('TEMPERATURE', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per le temperature dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia delle temperature, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_sticker_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('STICKER', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per gli sticker dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia degli sticker, associata ai prodotti di woocommerce', 'flash_order')
) );
FO_general_setting( array( 'name' => 'product_tags_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('TAG PRODOTTI', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per i tag dei prodotti' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia dei tag, associata ai prodotti di woocommerce', 'flash_order')
) );

FO_general_setting( array( 'name' => 'posts_tag_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('TAG POST', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per i tag dei post' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia dei tag, associata ai post di wordpress', 'flash_order')
) );

FO_general_setting( array( 'name' => 'posts_category_images',
    //'default'   => '',
    'options'   => array( 'yes', 'no' ),
    'type'      => 'select',
    'class'     => '',
    'title'      => __('CATEGORIE POST', 'flash_order'),
    'text'      => __('aggiungi un\'immagine alla tassonomia per le categorie dei post' , 'flash_order'),
    'info'      => __('mostrerà un nuovo meta box per selezionare facilmente l\' immagine da associare alla tassonomia delle categorie, associate ai post di wordpress', 'flash_order')
) );




    $nonce = wp_create_nonce( 'FO_save_settings' );
    echo '<input type="hidden" name="_fononce_save_settings" value="'.esc_attr($nonce).'" />';

?>

<!-- advanced --></div>

<?php
do_action('fo_setting_general_foot');
?>
<button name="update" value="update" class="FObutton pointer" style="margin: 10px auto;">UPDATE</button>
</form>


<?php do_action('fo_settings_sections_end'); ?>

</div>

<?php
//FO_debug($_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']);
FO_save_settings( "setting", 'setting' );













