(function( $ ) {
	//'use strict';


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
	console.log(jQuery('#_fononce_manage_pages').val());
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			action: 'FO_delete_page',
			page: page,
			nonce: jQuery('#_fononce_manage_pages').val(),
		},
		success: function(response) {
			console.log(' ...ajax-response... ');
			console.log(response);
			location.reload();
		}
	});
}


<<<<<<< HEAD
function FO_show_pages_rapid_impost( pageId ){
	jQuery('[fo_page_id="'+pageId+'"]').slideDown();
}

function FO_hide_pages_rapid_impost( pageId ){
	jQuery('[fo_page_id="'+pageId+'"]').slideUp();
}

function FO_toggle_pages_rapid_impost( pageId ){
	jQuery('[fo_page_id="'+pageId+'"]').slideToggle();
}
=======


function FO_condition_setting(input){
	if (jQuery(input).val() == jQuery(input).attr('fo_bool')) {
		jQuery( jQuery(input).attr('target_bool') ).slideDown();
	} else{
		jQuery( jQuery(input).attr('target_bool') ).slideUp();
	}
}



function FO_hide_condition_setting(input){
	if ( jQuery( jQuery(input).attr('fo_dep') ).attr('fo_val') != 'yes' || jQuery( jQuery(input).attr('fo_dep') ).attr('fo_val') != 'si') {
		jQuery(input).hide();
	} else{
		jQuery(input).show();
	}
}












>>>>>>> origin/main



