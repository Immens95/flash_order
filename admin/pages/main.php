<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


//echo 'main file';

// FO_coming_soon();
$nonce = wp_create_nonce( 'FO_main_page' );
echo '<input type="hidden" id="_fononce_main_page" name="_fononce_main_page" value="'.esc_attr($nonce).'" />';

// FO_statistics_in_flash();

FO_manage_QR_codes();

// FO_submit_suggestions();

FO_donate();


// echo FO_Google_QR_code( 'https://natillabistrot.it/' );