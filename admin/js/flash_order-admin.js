(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

$.noConflict();



})( jQuery );

function FO_adm_restore_prev_prev( target, value ){
	target.previousElementSibling.value = value;
	jQuery(target).closest('.FOsettingStyle').css('backgroundColor',value);
}

function addSrcToAudio(value){
	var audio = document.getElementById('FOadminAudio');
	//console.log();
	audio.setAttribute('src', value);
	//audio.play();
}




jQuery(function($){
    $('body').on('click', '.aw_upload_image_button', function(e){
        e.preventDefault();
        aw_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#tax-image').val(attachment.url);
            $('#tax-img-src').attr('src',attachment.url);
             $('#tax-img-src').css('display','block');
        })
        .open();
    });
});




function FOsettingSync(input){
	jQuery(input).parent().parent().css('background-color', jQuery(this).val());
}

function FO_settings_navigations( target ){
	
	jQuery('#settSection form').slideUp();

	jQuery(target).slideDown();
}

// console.log(window);
function FO_create_refresh_pages(){
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			action: 'FO_create_all_necessary_pages',
			// nonce: flash_orders_ajax_vars.nonce,
		},
		success: function(response) {
			console.log(' ...ajax-response... ');
			console.log(response);
			location.reload();
		}
	});
}

function FO_delete_page( page ){
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			action: 'FO_delete_page',
			page: page,
			// nonce: flash_orders_ajax_vars.nonce,
		},
		success: function(response) {
			console.log(' ...ajax-response... ');
			console.log(response);
			location.reload();
		}
	});
}









