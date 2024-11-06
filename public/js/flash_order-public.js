jQuery(document).ready(function($) {
	   "use strict";
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
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

    // Codice JavaScript per gestire la richiesta AJAX e l'aggiornamento del front-end
    //$('#refresh-button').click(function() {
    //    $.ajax({
    //        type: 'POST',
    //        url: flash_orders_ajax_vars.ajaxurl,
    //        data: {
    //            action: 'flash_orders_ajax_orders',
    //            nonce: flash_orders_ajax_vars.nonce
    //        },
    //        success: function(response) {
    //        	
    //        	console.log(response.data);
    //            $('#result-container').append("<tr><td>" + response.data + "</td></tr>");
    //        }
    //    });
    //});

// jQuery( "#datepicker" ).datepicker();

    jQuery('#submit_order null').click(function() {
    	var inputs;
    	var table_name = jQuery('#table_name').val();

    	jQuery('#summ_order input.prod_input').each(function(i,v){
    		if ( v != null ) {
    			inputs += v.name.toString()+','+v.value.toString()+'|';
    		}
    	});
    	console.log(inputs);
        jQuery.ajax({
            type: 'POST',
            url: flash_orders_ajax_vars.ajaxurl,
            data: {
                action: 'flash_orders_ajax_ordination',
                nonce: flash_orders_ajax_vars.nonce,
                products: inputs,
                table: table_name,
            },
            success: function(response) {
                console.log(' ...ajax-response... ');
                console.log(response.data);
                if (response.success) {
                	alert(' PERFETTO, la tua ordinazione é andata a buon fine! ');
                } else{
                	alert(' ERRORE!!! , la tua ordinazione NON é andata a buon fine! ');
                }
                //location.reload();
            }
        });
    });


    //jQuery('.fo_column_products .fo_tab_prod').bind('touchstart', function(event) {
	//	console.log(event);
	//	jQuery(event).trigger('ondragstart');
	//	//element.ontouchstart
	//});


});


function FO_Hide_all_popup(targetClass){
	jQuery(targetClass).each(function(i,e){
		jQuery(e).hide();
	});
}

/*
	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
	  coll[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var content = this.nextElementSibling;
	    if (content.style.display === "block") {
	      content.style.display = "none";
	    } else {
	      content.style.display = "block";
	    }
	  });
	}
*/

function FO_toggle_elements( target ) {
	console.log(target);
	jQuery(target).toggle();
}

function FO_Remove_Item_to_Order( target ) {
	jQuery(target).parent().parent().remove();
	jQuery('#FOProdNumber').text( parseInt(jQuery('#FOProdNumber').text()) - 1 );
	jQuery('#FOProdNumberMenu').text( parseInt(jQuery('#FOProdNumberMenu').text()) - 1 );
}

function FO_Add_Item_to_Order( target ) {
	var id, category, name, permalink, image, quantity, note, value;
	id = jQuery(target).parent().parent().attr('foid');
	category = jQuery(target).parent().parent().attr('focategories');
	name = jQuery(target).parent().parent().attr('foname');

	permalink = jQuery(target).parent().parent().find('.fopermalink a').attr('href');
	image = jQuery(target).parent().parent().find('.fopermalink a').html();

	quantity = jQuery(target).parent().parent().find('.foquantity').text();
	note = jQuery(target).parent().parent().find('.fonote textarea').val();
	value = jQuery(target).parent().find('input').val();


//console.log(image);
	var copy = jQuery(target).parent().parent().clone();
	copy.find('.FOAddBut').attr('onclick', 'FO_Remove_Item_to_Order(this);return false;');
	copy.find('.FOAddBut').text('RIMUOVI');

	// copy.find('.prod_input input').attr('name', jQuery('#FOProdNumber').text()+'~'+id+'~' );

	jQuery('#FOProdNumber').text( parseInt(jQuery('#FOProdNumber').text()) + 1 );
	jQuery('#FOProdNumberMenu').text( parseInt(jQuery('#FOProdNumberMenu').text()) + 1 );

	jQuery('#FOProdNumberMenu').parent().css( "background-color", 'var(--fo-invert-color)');
	jQuery('#FOProdNumberMenu').parent().css( "opacity", '1');

	setTimeout( function(){ 
		jQuery('#FOProdNumberMenu').parent().css( "background-color", 'var(--fo-bg3-color)'); 
		jQuery('#FOProdNumberMenu').parent().css( "opacity", '0.5');
	},800);

	copy.attr('foindex', jQuery('#FOProdNumber').text());

jQuery('#summ_order').append( copy );
	
	// jQuery(target).parent().parent().addClass('selected');

}


function FO_validate_flash_order_form( target ){
	if ( jQuery(target).parent().find('#table_name').val() <= 0 ) {
		event.preventDefault();
		alert('seleziona il numero del tavolo');
		return false;
	} else{
		jQuery('#left-fixed-menu').animate({left:'-100%'});
		jQuery('.FOloadingMessage').show();
		FO_assign_index_to_inputs(this);
	}
}


function FO_assign_index_to_inputs(){
	// event.preventDefault();
	var table = jQuery('#summ_order').find('tr');

	table.each(function(I,E){
		var foindex = jQuery(E).attr('foindex');
		var stringToAdd = 'foindex['+foindex+']';
// console.log(jQuery(E).find('input, textarea'));
		jQuery(E).find('input, textarea').each(function(i,e){
			var name = jQuery(e).attr('name');
			// if ( name.indexOf('[') ) {
// 				var newName = stringToAdd+name.slice(0, name.indexOf('['))+']'+name.slice(name.indexOf('['));
			// } else{
// 				var newName = stringToAdd+name+']';
			// }
			var newName = stringToAdd+name;
			jQuery(e).attr('name', newName );
			console.log(newName);
		});
	});
}

// let FOstickyParent = document.querySelector('.sticky').parentElement;
// while (FOstickyParent) {
//   const hasOverflow = getComputedStyle(FOstickyParent).overflow;
//   if (hasOverflow !== 'visible') {
//     console.log(hasOverflow, parent);
//   }
//   let FOstickyParent = FOstickyParent.parentElement;
// }

function FO_Edit_Item_ingredients(trigger){
	// $(trigger).next().;
}

function FOSearchIngred(search) {
	var searchValue = jQuery(search).val();
	var FilterSec = jQuery(search).next();

	FilterSec.find('.FOIngredProdTab').each(function(index, element){
		var DataInput = jQuery(element).find('input');
		if (DataInput.length > 0) {
			var regExp = new RegExp(searchValue, "i");
	        if (regExp.test(jQuery(DataInput).val())) {
	            // jQuery(element).slideUp();
	            jQuery(element).slideDown();
	        } else {
	        	// jQuery(element).slideDown();
	        	jQuery(element).slideUp();
	        }
		}
		if ( searchValue == '') {jQuery(element).slideUp();}
	});

	// console.log(searchValue);
	// console.log('--------');
	// console.log(FilterSec);
}

function FOadvToRegularFit(input){
	var editIng = jQuery(input).closest('.foProdCard').find('input[value='+jQuery(input).val()+']');
	if ( !jQuery(input).is(':checked') ) {
		editIng.each(function(i,e){
			jQuery(e).addClass('FOstatus_modified');
			jQuery(e).attr('checked','');
		});
		// jQuery(input).closest('.foProdCard').find('#FOeditIngTab input[value='+jQuery(input).val()+']').addClass('FOstatus_modified');
	} else{
		editIng.each(function(i,e){
			jQuery(e).removeClass('FOstatus_modified');
			jQuery(e).attr('checked','checked');
		});
		// jQuery(input).closest('.foProdCard').find('#FOeditIngTab input[value='+jQuery(input).val()+']').removeClass('FOstatus_modified');
	}
}

function FOaddIng(input){
	jQuery(input).attr('onclick', 'FOremoveIng(this);FOcheckCardModified(this);');
		var copy = jQuery(input).parent().clone();
	copy.addClass('FOstatus_modified');
	// console.log( jQuery(input).parent().parent().parent() );
	jQuery(input).parent().parent().parent().prepend(copy);
	// if ( jQuery(input).parent().parent().parent().find('[modified=modified]').length ) {
	// 	jQuery(input).parent().parent().parent().parent().addClass('FOstatus_modified');
	// }
	FOcheckIfModified(input);
	jQuery(input).parent().remove();
}

function FOcheckIfModified(input){
	if ( !jQuery(input).is(':checked') ) {
		jQuery(input).parent().addClass('FOstatus_modified');
	} else{
		jQuery(input).parent().removeClass('FOstatus_modified');
	}
	FOcheckCardModified(input);
}
function FOcheckCardModified(input){
	// if ( jQuery(input).closest('.foProdCard').find('.FOstatus_modified').length ) {
	// 	jQuery(input).closest('.foProdCard').addClass('FOstatus_modified');
	// } else{
	// 	jQuery(input).closest('.foProdCard').removeClass('FOstatus_modified');
	// }
	jQuery('.foProdCard').each(function(i,e){
		if ( jQuery(e).find('.FOstatus_modified').length ) {
			jQuery(e).addClass('FOstatus_modified');
		} else{
			jQuery(e).removeClass('FOstatus_modified');
		}
	})
}
function FOremoveIng(input){
	// var parent = jQuery(input).parent();
	jQuery(input).parent().removeClass('FOstatus_modified');

	jQuery(input).attr('onclick', 'FOaddIng(this);FOcheckCardModified(this);');
		var copy = jQuery(input).parent().clone();
	copy.removeClass('FOstatus_modified');
	jQuery(input).parent().parent().find('.FOIngredProdSec').prepend(copy);

	if ( jQuery(input).parent().parent().find('input[modified=modified]:checked').length  <= 0 &&
	 jQuery(input).parent().parent().find('input[modified=native]:checked').length < jQuery(input).attr('nat-ing') ) {
		jQuery(input).parent().parent().parent().removeClass('FOstatus_modified');
	}
	FOcheckIfModified(input);
	jQuery(input).parent().remove();
}
function FOcheckIng(input){
	if ( !jQuery(input).is(':checked') ) {
		jQuery(input).parent().addClass('FOstatus_modified');
	} else{
		jQuery(input).parent().removeClass('FOstatus_modified');
	}
	if ( jQuery(input).parent().parent().find('input[modified=native]:checked').length < jQuery(input).attr('nat-ing') ) {
		jQuery(input).parent().parent().parent().parent().addClass('FOstatus_modified');
	} else {
		jQuery(input).parent().parent().parent().parent().removeClass('FOstatus_modified');
	}
}

function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else if (document.exitFullscreen) {
    document.exitFullscreen();
  }
}

function FO_grid_adjust( value ){
	console.log(value);
	document.documentElement.style.setProperty('--fo-grid-width', value+'%');
	jQuery('.GridRange').val(value);
}




function FO_animate_css( target, first, second, time = 200 ) {
	if ( second == null || second == '' ) { second = first}
var target = target;
var first = first;
var second = second;
var time = time;

    jQuery(target).animate({ first }, time, function(){
        jQuery(target).animate({ second }, time, function(){
            FO_animate_css( target, first, second, time );
        });
    });
}






function FOallowDrop(ev) {
  ev.preventDefault();
}

function FOdrag(ev) {
	//jQuery(input)
	var foprodid = ev.target.attributes.foprodid.nodeValue;
	//var foprodid = jQuery(input).attr('foprodid');

	//console.log(ev);
	// console.log(jQuery(ev.target).find('.FO_prod_name_manage').text());
	// console.log(foprodid);
	ev.dataTransfer.setData("foprodid", foprodid);
	ev.dataTransfer.setData("foprodname", jQuery(ev.target).find('.FO_prod_name_manage').text().trim());
}

function FOdrop(ev) {
	ev.preventDefault();
	var foprodid = ev.dataTransfer.getData("foprodid");
	var foprodname = ev.dataTransfer.getData("foprodname");
	var fo_cat_name = ev.target.attributes.fo_cat_name.nodeValue;
	var fo_cat_id = ev.target.attributes.fo_cat_id.nodeValue;
	var fo_cat_ceck = ev.target.attributes.fo_cat_ceck.nodeValue;

	console.log(foprodid);
	console.log(foprodname);

	console.log(fo_cat_name);
	console.log(fo_cat_id);
	console.log(fo_cat_ceck);

	var args = [];

	args['foprodid'] = foprodid;
	args['foprodname'] = foprodname;
	args['fo_cat_name'] = fo_cat_name;
	args['fo_cat_id'] = fo_cat_id;
	args['fo_cat_ceck'] = fo_cat_ceck;
	args['fo_cat_copy'] = jQuery('.fo_cat_copy').attr('fo_cat_copy');
	
	jQuery('.fo_tab_prod[foprodid="'+foprodid+'"]').attr('fomacrocat',fo_cat_name);
console.log(fo_cat_name);
	if (args['fo_cat_copy']) {

	} else{
		jQuery('.fo_tab_prod[foprodid="'+foprodid+'"]').hide();
	}

	FOP_change_category( args );
	// ev.target.appendChild(document.getElementById(data));

}

function touchstartDrag(event,input) {
	if (jQuery('input[name="fop_touch_drag_drop"]').prop('checked')) {
	
	  var prod = jQuery(input);
	
	  let left = parseFloat(event.touches[0].clientX) - 50;
	  let top = parseFloat(event.touches[0].clientY) - 25;
	
	  prod.addClass("fo_touch_drag");
	  prod.css("left", left+"px");
	  prod.css("top", top+"px");
	  prod.attr("fo_posX", left+50);
	  prod.attr("fo_posY", top+25);
	}
}

function FOtouchdrop(event) {
	if (jQuery('input[name="fop_touch_drag_drop"]').prop('checked')) {
		var elem = jQuery(event.target).closest('.fo_tab_prod');
			jQuery(elem).removeClass("fo_touch_drag");
			jQuery(elem).css("left", "");
			jQuery(elem).css("top", "");

		var targ = document.elementFromPoint(jQuery(elem).attr('fo_posX'),jQuery(elem).attr('fo_posY')) // x, y

		if (jQuery(targ).hasClass('fo_cat_butt')) {

			var foprodid = jQuery(elem).attr("foprodid");
			var foprodname = jQuery(elem).find('.FO_prod_name_manage').text().trim();
			var fo_cat_name = jQuery(targ).attr("fo_cat_name");
			var fo_cat_id = jQuery(targ).attr("fo_cat_id");
			var fo_cat_ceck = jQuery(targ).attr("fo_cat_ceck");
		
			var args = [];
		
			args['foprodid'] = foprodid;
			args['foprodname'] = foprodname;
			args['fo_cat_name'] = fo_cat_name;
			args['fo_cat_id'] = fo_cat_id;
			args['fo_cat_ceck'] = fo_cat_ceck;
			args['fo_cat_copy'] = jQuery('.fo_cat_copy').attr('fo_cat_copy');
			
			FOP_change_category( args );

			jQuery(elem).attr('fomacrocat',fo_cat_name);
			jQuery(elem).hide();

			console.log(elem);
		} else{
			
		}
	}
}









function FO_add_prod_to_favorites(input){

	var p_clone = jQuery(input).clone();

	p_clone.attr('focategories','FO_favourite');

	p_clone.find('.foheart span').removeClass('dashicons-heart');
	p_clone.find('.foheart span').addClass('dashicons-no');
	
	p_clone.find('.foheart').attr('onclick',"FO_remove_prod_from_favorites(jQuery(this).closest('.foProdCard'))");

	jQuery('.FO_favourites_container').prepend(p_clone);


}

function FO_remove_prod_from_favorites(input){
	jQuery(input).remove();
}









function FO_refine_search(input){
	var searchVal = jQuery(input).val();
	var target = jQuery(input).attr('fotargetcat');
	var items = jQuery('#products_container [focategories='+target+']');

		items.each(function(index, row){
		var allDataPerRow = jQuery(row).find('.foname');
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
				// jQuery(row).css('scale','0');
				jQuery(row).css('scale','1');
				jQuery(row).show();
			}else {
				jQuery(row).css('scale','0');
				jQuery(row).fadeOut();
				// jQuery(row).hide();
			}
		}
	});
}
function FO_search_for_all(input){
	var searchVal = jQuery(input).val();
	var items = jQuery('#products_container .foProdCard');

	items.each(function(index, row){
		var allDataPerRow = jQuery(row).find('.foname');
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
}
function FO_search_for_target(input,target){
	var searchVal = jQuery(input).val();
	var items = jQuery(target);

	items.each(function(index, row){
		var allDataPerRow = jQuery(row).find('.foname');
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
				jQuery('.FO_order_list').show()
			}else {
				jQuery(row).hide();
			}
			if (searchVal == '') {jQuery(row).show();jQuery('.FO_order_list').show()}
		}
	});
}

function FO_inizialize_timer( check = '' ){
	console.log('--FO_inizialize_timer--');
	if ( check == 'table ') {
		jQuery('#result-container tr[identify="orders"] tr').each(function(i,e){
			if ( jQuery(e).attr('orderdata') != null ) {
				var status = jQuery(e).attr('orderstatus');
				if ( status != 'cancelled' && status != 'refunded' && status != 'completed' ) {
					FO_timer( jQuery(e) );
				} else{
					FO_clearTimer( jQuery(e) );
				}
			}
		});
	}else{
		jQuery('#result-container tr').each(function(i,e){
			if ( jQuery(e).attr('orderdata') != null ) {
				var status = jQuery(e).attr('orderstatus');
				if ( status != 'cancelled' && status != 'refunded' && status != 'completed' ) {
					FO_timer( jQuery(e) );
				} else{
					FO_clearTimer( jQuery(e) );
				}
			}
		});
	}
}


















  // date.getMonth();
  // date.getDate();
  // date.getFullYear();
//   date.getHours();
//   date.getMinutes();
//   date.getSeconds();
function FO_timer( target ){
	// FO_clearTimer( target );
	var status = jQuery(target).attr('orderstatus');
	var data = jQuery(target).attr('orderdata');
var adv_durat = parseInt(jQuery('#fotimer_duration').text());
	if ( jQuery('#fotimer_advanced').text() == 'yes' ) {
		// adv_durat = parseInt(jQuery('#fotimer_advanced_factor').text()) * parseInt(jQuery('#fotimer_duration').text()) * jQuery(target).find('[identify="products"]').length;
	}
	// console.log(jQuery(target).find('[identify="products"]').length);
	// console.log(adv_durat);

	var now = new Date();
	var date = new Date( data );

	var duration = parseInt( adv_durat ) * 60 * 1000;
	var difference = now.getTime() - date.getTime();
// difference = Math.floor(difference / 1000);
	var diff_min = duration - difference;
	diff_min = Math.floor(diff_min / 1000);
// console.log(diff_min);
	if ( status != 'cancelled' || status != 'refunded' || status != 'completed'  ) {
		FO_startTimer( diff_min, jQuery(target).find('.fotimer'), jQuery(target).attr('orderid') );
	} else{
		jQuery(target).find('.fotimer').slideUp();
		FO_clearTimer( jQuery(target) );
		clearInterval(jQuery(target).attr('orderid'));
	}
}

function FO_startTimer( duration, display, id ) {

	var status = jQuery(display).parent().parent().attr('orderstatus');
	if (status == 'cancelled' || status == 'refunded' || status == 'completed') {
		jQuery( display ).slideUp();
		FO_clearTimer( jQuery(display).parent().parent() );
		return;
	}
	// window.fointerval = [];
    	var start = Date.now();
    	var durat_fixed = parseInt( jQuery('#fotimer_duration').text() );
    	var percent = parseInt(durat_fixed*60) / 100;

	function timer( id ) {
		var diff = duration - ((Date.now() - start) / 1000);
		var minutes = (diff / 60) | 0;
		var seconds = (diff % 60) | 0;
		var fullseconds = diff | 0;
// console.log(fullseconds);	
		minutes_ = minutes < 10 ? "0" + minutes : minutes;
		seconds_ = seconds < 10 ? "0" + seconds : seconds;
		var time = minutes_ + ":" + seconds_;

jQuery( display ).removeClass('foyelcol');
jQuery( display ).removeClass('foerrcol');
jQuery( display ).removeClass('fo_status_timer_2');
jQuery( display ).removeClass('fo_status_timer_3');
// jQuery( display ).removeClass('foTimeOutAnim');
		jQuery( display ).text( time );
		jQuery( display ).css('width', parseInt(fullseconds) / percent +'%' );
		jQuery( display ).slideDown();

	if ( status == 'cancelled' || status == 'refunded' || status == 'completed' ) {
		jQuery(jQuery(display).parent().parent()).slideUp();
		FO_clearTimer(jQuery(display).parent().parent());
		clearInterval(id);
		return;
	} else{
		if (fullseconds <= 0  ) {
			clearInterval(id);
			FO_clearTimer(jQuery(display).parent().parent());
			return;
		} else{
				jQuery( display ).text( time );
				jQuery( display ).css('width', parseInt(fullseconds) / percent +'%' );
				jQuery(display).removeClass('foTimeOutAnim');
			if ( minutes < 10 &&  minutes > 5 ) {
				jQuery( display ).addClass('fo_status_timer_2');
				jQuery( display ).addClass('foyelcol');
			} else {
				if(minutes < 5) {
					jQuery( display ).removeClass('fo_status_timer_2');
					jQuery( display ).addClass('fo_status_timer_3');
					jQuery( display ).removeClass('foyelcol');
					jQuery( display ).addClass('foerrcol');
				}
			}
		}
	}
};
	// fointerval[String(id)] = setInterval(timer, 1000);
	setIntervalWrapper(timer, 1000, id);

	// window.fointerval.push( fointerval );
}

function FO_clearTimer( target ){
	console.log('FO_clearTimer');
	var id = jQuery(target).attr('orderid');
	var display = jQuery(target).find('.fotimer');
// var fointerval;
	// FO_startTimer( 0, display, id ).cancTimer(id);
	clearInterval( id );
	jQuery(display).text("00:00");
	jQuery(display).addClass('foTimeOutAnim');
	// return;
}

function setIntervalWrapper(callback, time) {
    var args = Array.prototype.slice.call(arguments, 1);
    args[0] = setInterval(function() {
        callback.apply(null, args);
    }, time);
}


// function FO_loop() {
//   setTimeout(() => {
//     // Your logic here
//     FO_loop();
//   }, delay);
// }

// console.log(window );








function FO_Show_temp(target){
	var src = jQuery(target).find('[value="'+jQuery(target).val()+'"]').attr('img');
	var color = jQuery(target).find('[value="'+jQuery(target).val()+'"]').attr('color');

	jQuery(target).prev().val(jQuery(target).val());

	jQuery(target).parent().parent().find('.fotax_image_temp').attr('src',src);
	jQuery(target).parent().parent().find('.FOthermometer').attr('color',color);

	jQuery(target).parent().parent().find('.fotax_image_temp').css('display','block');
	jQuery(target).parent().parent().find('.fotemp_card').slideUp();
}



function Show_FO_Front_Float(){
	jQuery('#FO_Front_Float').css('bottom','0px');
	jQuery('#FO_Front_Float').css('opacity','0.992');
	// jQuery('header').css('display','none');
	// jQuery('footer').css('display','none');
	fo_toggle_header_footer();
}

function Hide_FO_Front_Float(){
	jQuery('#FO_Front_Float').css('bottom','calc(-100% - 15px)');
	jQuery('#FO_Front_Float').css('opacity','0.5');
	// jQuery('header').css('display','');
	// jQuery('header').css('display','');
	fo_toggle_header_footer();
}

function Show_FOListRapidView(){
	jQuery('.FOListRapidView').css('left','0px');
	jQuery('.FOListRapidView').css('opacity','1');
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');
	// fo_toggle_header_footer();
}

function Hide_FOListRapidView(){
	jQuery('.FOListRapidView').css('left','-200px');
	jQuery('.FOListRapidView').css('opacity','0');
	// jQuery('header').css('display','');
	// jQuery('header').css('display','');
	fo_toggle_header_footer();
}

function FO_Advanced_Prod_Card( input ){
	jQuery('.Advanced_Card').fadeIn();
	jQuery('.Advanced_Card_background').fadeIn();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');

	var AC_ID = jQuery(input).closest('.foProdCard').attr('foid');
	var AC_Name = jQuery(input).closest('.foProdCard').attr('foname');
	var Advanced_Card_gallery = jQuery(input).closest('.foProdCard').attr('fo_gallery');

	var AC_description = jQuery(input).closest('.foProdCard').attr('fo_description');

	var AC_tax_cat = jQuery(input).closest('.foProdCard').attr('fo_tax_cat');
	var AC_tax_tag = jQuery(input).closest('.foProdCard').attr('fo_tax_tag');
	var AC_tax_ing = jQuery(input).closest('.foProdCard').attr('fo_tax_ing');
	var AC_tax_allerg = jQuery(input).closest('.foProdCard').attr('fo_tax_allerg');

	var AC_tot = jQuery(input).closest('.foProdCard').attr('fo_tot');
	var AC_Variant = jQuery(input).closest('.foProdCard').find('.fovariantcont').clone();
	AC_Variant.show();

	jQuery('.AC_ID').text(AC_ID);
	jQuery('.AC_Name').text(AC_Name);
	jQuery('.AC_description').text(AC_description);
	jQuery('.Advanced_Card_gallery').text(Advanced_Card_gallery);
	jQuery('.AC_tax_cat').text(AC_tax_cat);
	jQuery('.AC_tax_tag').text(AC_tax_tag);
	jQuery('.AC_tax_ing').text(AC_tax_ing);
	jQuery('.AC_tax_allerg').text(AC_tax_allerg);
	jQuery('.AC_tot').text(AC_tot);
	jQuery('.AC_Variant').append(AC_Variant);
}

function FO_Advanced_Prod_Card_hide( target ){
	jQuery('.Advanced_Card').fadeOut();
	jQuery('.Advanced_Card_background').fadeOut();
	// jQuery('header').css('display','');
	// jQuery('footer').css('display','');
	fo_toggle_header_footer();

	jQuery('.AC_ID').text('');
	jQuery('.AC_Name').text('');
	jQuery('.AC_description').text('');
	jQuery('.Advanced_Card_gallery').text('');
	jQuery('.AC_tax_cat').text('');
	jQuery('.AC_tax_tag').text('');
	jQuery('.AC_tax_ing').text('');
	jQuery('.AC_tax_allerg').text('');
	jQuery('.AC_tot').text('');
	jQuery('.AC_Variant').empty();
}

function FO_Advanced_Prod_Card_hide_all(){
	jQuery('.Advanced_Card').hide();
	jQuery('.Advanced_Card_background').hide();
	
}
// if ( !jQuery('.fothermo').is(':focus') ) {
// jQuery(this).hide();
// }

document.addEventListener('click', function handleClickOutsideBox(event) {
//   const box = document.getElementById('FO_Front_Float');
// console.log(event.target);
//   if (!box.contains(event.target)) {
//     box.style.display = 'none';
//   }

	// jQuery('.fobox').each(function(i,e){
		// if ( !jQuery.contains(event.target, jQuery('#products_container') ) ) {
		// 	jQuery('.fobox').hide();
		// 	console.log('no');
		// } else{
		// 	console.log('si');
		// }
	// });

});






function FO_check_warehouse(item){
	if (jQuery(item).closest('.foProdCard').attr('foware')>0) {
		FO_ajax_Add_Item_to_Order(item);
		jQuery(item).closest('.foProdCard').find('.fovariation_card').slideUp();
	}else{
		FO_alert( '', jQuery('#FO_warehouse_alert').text() );
		// alert(jQuery('#FO_warehouse_alert').text());
		// return false;
	}
}

function FO_ajax_selectVarBefore_Add_Item_to_Order(item){
	if (jQuery(item).closest('.foProdCard').attr('fovariations') != '') {
		jQuery(item).closest('.foProdCard').find('.fovariation_card').slideDown();
	} else{
		FO_check_warehouse(item);
	}
}

function FO_ajax_selectVarAfter_Add_Item_to_Order(item){
	var check = true;
	// jQuery(item).closest('.foProdCard').find('.fovariant select').each(function(i,e){
	// 	if ( jQuery(e).val() == '') { check = false; }
	// });
	if ( check ) {
		FO_check_warehouse(item);
	} else{
	// FO_alert( '', jQuery('#FO_select_variant_alert').text() );
		// alert(jQuery('#FO_select_variant_alert').text());
		// return false;
	}
}
function FO_ajax_Remove_Item_to_Order( target ) {
	jQuery(target).closest('.foProdCard').remove();
	jQuery('#FOProdNumber').text( parseInt(jQuery('#FOProdNumber').text()) - 1 );
	jQuery('#FO_order_live_count').text( parseInt(jQuery('#FO_order_live_count').text()) - 1 );
	jQuery('#FOProdNumberMenu').text( parseInt(jQuery('#FOProdNumberMenu').text()) - 1 );
}
function FO_ajax_Add_Item_to_Order(item){
	var id, category, name, permalink, image, quantity, note, value;
	id = jQuery(item).closest('.foProdCard').attr('foid');
	category = jQuery(item).closest('.foProdCard').attr('focategories');
	name = jQuery(item).closest('.foProdCard').attr('foname');
	image = jQuery(item).closest('.foProdCard').find('img').attr('src');

	quantity = jQuery(item).closest('.foProdCard').find('.foquantity').text();
	note = jQuery(item).closest('.foProdCard').find('.fonote textarea').val();
// 	value = jQuery(item).parent().find('input').val();

	// jQuery(item).closest('.foProdCard').removeClass('selected');
	// jQuery(item).closest('.foProdCard').addClass('selected');
	var copy = jQuery(item).closest('.foProdCard').clone();

	copy.find('.foadd').attr('onclick', 'FO_ajax_Remove_Item_to_Order(this);');
	copy.find('.foadd').text('-');
	copy.find('.fovariation_card .foadd').remove();
	copy.find('.fovariation_card').slideUp();

	copy.find('select').each(function(i,e){
		jQuery(e).find('option[value="'+jQuery(e).attr('value')+'"]').attr('selected','selected');
		// jQuery(e).val(jQuery(e).attr('value'));
	});

	// jQuery(e).val(jQuery(e).attr('value'));

	// copy.find('.foProdCardHead img').attr('onclick', '');
	// copy.find('.Advanced_Card').remove();
	
// 	// copy.find('.prod_input input').attr('name', jQuery('#FOProdNumber').text()+'~'+id+'~' );
	jQuery('#FOProdNumber').text( parseInt(jQuery('#FOProdNumber').text()) + 1 );
	jQuery('#FO_order_live_count').text( parseInt(jQuery('#FO_order_live_count').text()) + 1 );

jQuery('.FO_show_order_summary').addClass('foBorderPulse');
jQuery('.FO_show_order_summary img').attr('src', image);
jQuery('.FO_show_order_summary img').show();
	
	copy.attr('foindex', jQuery('#FOProdNumber').text());

jQuery('#FO_sum_order').append( copy );
}

function FO_variant_set(input){
	jQuery(input).attr('value',jQuery(input).val());
	jQuery(input).parent().find('input').val(jQuery(input).val());
	// jQuery(input).closest('.fovariation_card').find('.foadd').show(); 

	jQuery(input).closest('.foProdCard').find(`.Advanced_Card select[foadvariant='`+jQuery(input).attr('founivariant')+`']`)
		.val(jQuery(input).val());
	jQuery(input).closest('.foProdCard').find(`.Advanced_Card select[foadvariant='`+jQuery(input).attr('founivariant')+`']`)
		.attr('value',jQuery(input).val());

	jQuery(input).closest('.foProdCard')
		.find(`[fovariant='`+jQuery(input).attr('foadvariant')+`'] input, [fovariant='`+jQuery(input).attr('foadvariant')+`'] select`)
			.val(jQuery(input).val());
	jQuery(input).closest('.foProdCard')
		.find(`[fovariant='`+jQuery(input).attr('foadvariant')+`'] input, [fovariant='`+jQuery(input).attr('foadvariant')+`'] select`)
			.attr('value',jQuery(input).val());

	FO_show_variant_tag(input);
}

function FO_show_variant_tag(input){
	var attr = ( jQuery(input).attr('founivariant')!= null )? jQuery(input).attr('founivariant') : jQuery(input).attr('foadvariant');
	jQuery(input).closest('.foProdCard').find(`.fovariantag_container [founivariant='`+attr+`']`)
		.each(function(i,e){
			// console.log( jQuery(e).attr('founitag') );
		if ( jQuery(input).val() != '' && jQuery(e).attr('founitag') == jQuery(input).val() ) {
			jQuery(e).show();
		} else{
			jQuery(e).hide();
		}
	});
}




function FO_validate_flash_order_form_ajax( target ){
	if(jQuery('#FOSetting_UserLoggedIn').text() == 0) {
        event.preventDefault();
        FO_alert( '', jQuery('#FO_access_alert').text() );
        // alert('Per poter effettuare ordini su questa pagina, é neccessario Effettuare l\'accesso!');
		Hide_FO_Front_Float();
		jQuery('.FO_logIn_popUp').fadeIn();
		return false;
    } else{
		if ( jQuery(target).parent().find('#table_name').val() <= 0 ) {
			event.preventDefault();
			alert('seleziona il numero del tavolo');
			return false;
		} else {
			jQuery('.FOloadingMessage').fadeIn();
			FO_assign_index_to_ajax_inputs(target);
			FO_submit_flash_order_ajax_form(target);
		}
	}
}
function FO_assign_index_to_ajax_inputs(){
	// event.preventDefault();
	var table = jQuery('#FO_sum_order').find('.foProdCard');

	table.each(function(I,E){
		var foindex = jQuery(E).attr('foindex');
		var stringToAdd = '['+foindex+']';
// console.log(jQuery(E).find('input, textarea'));
		jQuery(E).find('input, textarea').each(function(i,e){
			var name = jQuery(e).attr('name');
			var newName = stringToAdd+name;
			jQuery(e).attr('name', newName );
			console.log(newName);
		});
	});
}

function FO_submit_flash_order_ajax_form(target){
	var table = jQuery('#FO_sum_order').find('.foProdCard');
	var foserial = jQuery(table).find('input, textarea').serializeArray();
	// foserial.filter(function(e){return e});
	var foserialmap = foserial.map(({ name, value }) => ({ [name]: value }));

foserialmap = foserial.map(item => {
    var container = {};
    container[item.name] = item.value;
    return container;
});

console.log(foserialmap);
	console.log(' order submitted sucessfully !!! ');
		jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
		    action: 'FO_submit_order_ajax',
		    nonce: flash_orders_ajax_view_orders_vars.nonce,
		    table_name: jQuery('#table_name').val(),
		    table_surname: jQuery('select[name="table_surname"]').val(),
		    order_note: jQuery('#orderNote').val(),
		    foserial: foserial,
		    foserialmap: foserialmap,
		    _fononce_front_order_ajax: jQuery('input[name="_fononce_front_order_ajax"]').val()
		    // obj: obj,
		},
		success: function (response) {
			console.log(response);
			jQuery(target).closest('#FO_Front_Float').find('#FO_sum_order').empty();

				jQuery('#FOProdNumber').text( 0 );
				jQuery('#FO_order_live_count').text( 0 );
				jQuery('.FO_show_order_summary').removeClass('foBorderPulse');
				jQuery('.FO_show_order_summary img').attr('src', '');
				jQuery('.FO_show_order_summary img').hide();
				Hide_FO_Front_Float();
				jQuery('.FOloadingMessage').fadeOut();
			return;
		}
	});
}


function FO_order_list_ajax(item){
	if ( jQuery(item).closest('.FO_flash_list_order_container').find('#table_name').val() <= 0 && 
			jQuery(item).closest('.FO_flash_list_order_container').find('[name="table_name_cpt"]').val() <= '' ) {
		event.preventDefault();
		alert(jQuery('#folist_order_table_mex').text());
		return false;
	} else {
		jQuery(item).closest('.FO_flash_list_order_container').find('.FOloadingCardPublic').fadeIn();
		jQuery(item).closest('.FO_flash_list_order_container').find('.FO_list_height').val('');
		jQuery(item).closest('.FO_flash_list_order_container').find('.FO_target_search').hide();
		var table = jQuery(item).closest('.FO_flash_list_order_container').find('.FO_order_list_summary');

		var foserial = jQuery(table).find('input, textarea').serializeArray();
		var foserialmap = foserial.map(({ name, value }) => ({ [name]: value }));
	foserialmap = foserial.map(item => {
	    var container = {};
	    container[item.name] = item.value;
	    return container;
	});
	console.log(foserialmap);
		// console.log(' order submitted sucessfully !!! ');
			jQuery.ajax({
			type: 'POST',
			url: flash_orders_ajax_view_orders_vars.ajaxurl,
			data: {
			    action: 'FO_flash_list_order_ajax',
			    nonce: flash_orders_ajax_view_orders_vars.nonce,
			    table_name: jQuery('input[name="table_name"]').val(),
			    table_surname: jQuery('select[name="table_surname"]').val(),
			    table_name_cpt: jQuery('select[name="table_name_cpt"]').val(),
			    order_note: jQuery('textarea[name="order_note"]').val(),
			    foserial: foserial,
			    foserialmap: foserialmap,
			    _fononce_flash_list_order: jQuery('input[name="_fononce_flash_list_order"]').val(),
			},
			success: function (response) {
				console.log(response);
					jQuery('.FO_order_list_summary').empty();

					jQuery('input[name="discount"]').val( 0 );
					jQuery('input[name="table_name"]').val( 0 );
					jQuery('select[name="table_name_cpt"]').val('');
					jQuery('select[name="table_surname"]').val('');

					jQuery('.FO_summ_tot span').text('0');
					jQuery('.FONum_products').text('0');

					jQuery('.FO_flash_list_order_container').find('.FOloadingCardPublic').fadeOut();
				return;
			}
		});
	}
}


function FO_order_list(item){
	var price = parseFloat(jQuery(item).attr('foprice'));
	var tot = parseFloat(jQuery('.FO_summ_tot span').text());
	var NumProd = parseInt(jQuery('.FONum_products').text());

	jQuery('.FO_summ_tot span').text( parseFloat(tot + price).toFixed(2) );

 if (jQuery('.FO_summ_tot span').text()=='NaN') { jQuery('.FO_summ_tot span').text('0') }

	var copy = jQuery(item).clone();
copy.removeClass('FO_target_search');

	copy.find('.FO_list_price').show();
	copy.find('.FO_clear_target').show();
	copy.find('.FO_clear_target').attr('onclick','FO_order_list_remove(jQuery(this).parent());jQuery(this).parent().remove();');
	copy.find('input').attr('name', '['+NumProd+']'+copy.find('input').attr('name') );
	copy.attr('onclick','');
	jQuery(item).closest('.FO_flash_list_order_container').find('.FO_order_list_summary').append(copy);

	jQuery('.FONum_products').text( parseInt(parseInt(NumProd) + 1) );
}

function FO_add_new_customer( item ){
	var fo_cu_name = jQuery(item).find('.N_customer_name').val();
	var fo_cu_mail = jQuery(item).find('.N_customer_mail').val();
	var fo_cu_phone = jQuery(item).find('.N_customer_phone').val();

	if (fo_cu_name == '') {
		FO_alert( '', jQuery('#fo_tab_new_customer_error_name_text').text());return;}
	if (fo_cu_mail == '' && fo_cu_phone == '' ) {
		FO_alert( '', jQuery('#fo_tab_new_customer_error_mail_phone_text').text());return;}
	
	var input = jQuery(item).find('input').clone();
	input.removeClass('fot_pay_input');
	input.attr('type','hidden');

	var copy = jQuery('.FO_exemple_customer_card').clone();
	copy.removeClass('FO_exemple_customer_card');
	copy.removeClass('FO_example');
	copy.css('display','flex');
	copy.css('backgroundColor','var(--fo-high-color)');

	copy.find('.FO_pay_customer_name').text(fo_cu_name);
	copy.find('.FO_pay_customer_mail').text(fo_cu_mail);
	copy.find('.FO_pay_customer_phone').text(fo_cu_phone);

	copy.append(input);
	
	console.log(copy);
	jQuery('.FO_customers_container').empty();
	jQuery('.FO_customers_container').append(copy);
	console.log(jQuery('.FO_customers_container input').serializeArray());
}

function FO_pay_customer_list(item){
	console.log(item);
	var fo_u_id = jQuery(item).attr('fo_u_id');
	var fo_u_name = jQuery(item).attr('fo_u_name');
	var fo_u_mail = jQuery(item).attr('fo_u_mail');
	var fo_u_phone = jQuery(item).attr('fo_u_phone');
	var fo_u_since = jQuery(item).attr('fo_u_since');
	var fo_u_aurl = jQuery(item).attr('fo_u_aurl');

	var input = jQuery(item).find('input').clone();

	var copy = jQuery('.FO_exemple_customer_card').clone();
copy.removeClass('FO_exemple_customer_card');
copy.removeClass('FO_example');
copy.css('display','flex');

	copy.find('.FO_pay_customer_id').text(fo_u_id);
	copy.find('.FO_pay_customer_name').text(fo_u_name);
	copy.find('.FO_pay_customer_mail').text(fo_u_mail);
	copy.find('.FO_pay_customer_phone').text(fo_u_phone);

	copy.prepend(fo_u_aurl);
	copy.append(input);
	
	console.log(copy);
	jQuery('.FO_customers_container').empty();
	jQuery('.FO_customers_container').append(copy);
	console.log(jQuery('.FO_customers_container input').serializeArray());
}

function FO_order_list_remove(item){
	var price = parseFloat(jQuery(item).attr('foprice'));
	var tot = parseFloat(jQuery('.FO_summ_tot span').text());
	var NumProd = jQuery('.FONum_products').text();

	jQuery('.FO_summ_tot span').text( parseFloat(tot - price).toFixed(2) );
	jQuery('.FONum_products').text( parseInt(NumProd - 1) );
 // if (jQuery('.FO_summ_tot span').text()=='NaN') { jQuery('.FO_summ_tot span').text('0') }
 	
}

function FO_order_discount_list(item, qtyTarget){
	var price = parseFloat(jQuery(qtyTarget).val());
	var tot = parseFloat(jQuery('.FO_summ_tot span').text());
var NumProd = parseInt(jQuery('.FONum_products').text());

	var copy = jQuery(item).parent().find('.FO_list_prod_summ').clone();
	copy.css('display','');
	copy.attr('foprice', price);
	copy.find('.FO_list_price').text( parseFloat(price).toFixed(2) );
	copy.find('input').attr('name', '['+NumProd+']'+copy.find('input').attr('name') );
	copy.find('input').val( price );

	jQuery(item).closest('.FO_flash_list_order_container').find('.FO_order_list_summary').append(copy);

	jQuery('.FO_summ_tot span').text( parseFloat(tot + price).toFixed(2) );
	jQuery('.FONum_products').text( parseInt(parseInt(NumProd) + 1) );
 	
}

















function FO_add_value_to_input( value, target ){
	jQuery(target).val(parseFloat(parseFloat(jQuery(target).val()) + parseFloat(value)).toFixed(2));

}



function FO_filter_tab_product( slug_target ){
	jQuery('.fo_column_products .fo_tab_prod').hide();
	jQuery('.fo_column_products .fo_tab_prod[fomacrocat="'+slug_target+'"]').show();

}

function fo_filter_tab_story( input, slug_target ){
	jQuery('.fo_tab_prod').removeClass('fo_tab_prod_story');
	jQuery('.fo_order_table_story').removeClass('fo_tab_prod_story');
	jQuery('.fo_column_story .fo_tab_prod').removeClass('fo_tab_prod_story');
	jQuery('.fo_column_story .fo_tab_prod').hide();
	jQuery(input).addClass('fo_tab_prod_story');
	if (slug_target == 'all') {
		jQuery('.fo_column_story .fo_tab_prod[fotableid="'+jQuery(input).attr('fotableid')+'"]').show();
		jQuery('.fo_column_story .fo_tab_prod[fotableid="'+jQuery(input).attr('fotableid')+'"]').addClass('fo_tab_prod_story');
	}else{
		jQuery('.fo_column_story .fo_tab_prod[fo_index_story="'+slug_target+'"]').show();
		jQuery('.fo_column_story .fo_tab_prod[fotableid="'+jQuery(input).attr('fotableid')+'"][fo_index_story="'+jQuery(input).attr('fo_order_id')+'"]').addClass('fo_tab_prod_story');
	}
	FO_calc_totals();
}
function FO_filter_tab_variant( input, slug_target ){
	jQuery('.fo_tab_prod').removeClass('fo_tab_prod_selected');
	jQuery('.fo_tab_prod').removeClass('fo_tab_prod_modify');

	if (jQuery(input).attr('fo_type') == 'new') {
		jQuery(input).addClass('fo_tab_prod_selected');
	}else if (jQuery(input).attr('fo_type') == 'modify') {
		jQuery(input).addClass('fo_tab_prod_modify');
	}else if (jQuery(input).attr('fo_type') == 'story') {
		jQuery(input).addClass('fo_tab_prod_story');
	}else {
		// jQuery(input).addClass('fo_tab_prod_selected');
	}

//fix the params -----------------------------------
	jQuery('.fo_actual_prod').text(jQuery(input).attr('foprodid'));
	jQuery('.fo_actual_index').text(jQuery(input).attr('fo_index'));
	jQuery('.fo_actual_index_story').text(jQuery(input).attr('fo_index_story'));

//variant -------------------------------------------
	jQuery(input).find('[fo_tab_target="variante"]').each(function(i,e){
		if (jQuery(e).val() == '') {
			jQuery('.fo_tab_variantcont[foprodidtarget="'+slug_target+'"]').find('input[fovariant="'+jQuery(e).attr('fovariant')+'"]').prop('checked', false);
		}else{
			jQuery('.fo_tab_variantcont[foprodidtarget="'+slug_target+'"]').find('input[fovariant="'+jQuery(e).attr('fovariant')+'"][value="'+jQuery(e).val()+'"]').prop('checked', true);
		}
	});
	jQuery('.fo_tab_variantcont[foprodidtarget="'+slug_target+'"]').attr('fo_modificable',jQuery(input).attr('fo_modificable') );
	jQuery('.fo_tab_variantcont').hide();
	jQuery('.fo_tab_variantcont[foprodidtarget="'+slug_target+'"]').show();

//temperature --------------------------------------
	jQuery('.FO_flash_tab_temperature[foprodidtarget="'+slug_target+'"]').find('input').prop('checked', false);
	jQuery('.FO_flash_tab_temperature[foprodidtarget="'+slug_target+'"]').find('input[value="'+jQuery(input).find('[fo_tab_target="Temperature"]').val()+'"]').prop('checked', true);
	jQuery('.FO_flash_tab_temperature[foprodidtarget="'+slug_target+'"]').attr('fo_modificable',jQuery(input).attr('fo_modificable') );
	jQuery('.FO_flash_tab_temperature').hide();
	jQuery('.FO_flash_tab_temperature[foprodidtarget="'+slug_target+'"]').show();

//name ---------------------------------------------
	var name = jQuery(input).find('.FO_prod_name_manage').text();
	var order_text = 'ORD n°'+jQuery(input).attr('fo_index_story')+'  |  ';
	if ( parseInt(jQuery(input).attr('fo_index_story')) >= 999999 ) { order_text = '' }
	jQuery('.fo_col_2_name').text( order_text + name );

//price --------------------------------------------
	var price = jQuery(input).find('[fo_tab_target="price"]').val();
		if (price==''||price==null||!price) {price = 0.00}
	jQuery('.fo_tab_price').attr('fo_modificable',jQuery(input).attr('fo_modificable') );
	jQuery('.fo_tab_price').text( parseFloat(price).toFixed(2));
	jQuery('.fo_tab_price').attr('fo_status_modify','false');

	// jQuery(input).attr('foprodtot', slug_target );
	jQuery('.fo_tab_price').attr('fo_actual_prod', slug_target );
	jQuery('.fo_tab_price').attr('fo_actual_index', jQuery(input).attr('fo_index') );

	jQuery('.fo_tab_reset_price').attr('fovalue', parseFloat(jQuery(input).attr('foprodtot')).toFixed(2) );

//qty --------------------------------------------------
	if ( jQuery(input).attr('fo_special') == 'Special' ||  jQuery(input).attr('fo_special') == 'Sconto' ) {
			// prod.find('input[fo_tab_target="id"]').attr('name', prod.find('input[fo_tab_target="id"]').attr('name')+'['+jQuery(input).text()+']');
		jQuery('.FO_flash_tab_qty').hide();
	} else{
		jQuery('.FO_flash_tab_qty').show();
	}
	jQuery('.fo_target_qty_prod').val(jQuery(input).find('[fo_tab_target="qty"]').val());
	jQuery('.fo_target_qty_prod').attr('fo_modificable',jQuery(input).attr('fo_modificable'));

//note -------------------------------------------------
	jQuery('.fo_target_note_prod').empty();
	jQuery('.fo_target_note_prod').val(jQuery(input).find('[fo_tab_target="note"]').val());
	jQuery('.fo_target_note_prod').attr('fo_modificable',jQuery(input).attr('fo_modificable'));
	jQuery('.FO_flash_tab_note').show();
	
	if ( jQuery(input).attr('fo_type') == 'new' ) {
		fo_tab_add_product_to_order();
	}
	FO_calc_totals();
}

function FO_calc_totals(){
	var tot_r = 0.00;
	jQuery('.fo_column_riepilogo .fo_tab_prod').each(function(i,e){
		var temp_r_price = 0.00;
		var qty_r = parseFloat(jQuery(e).find('[fo_tab_target="qty"]').val());
			if (qty_r==''||qty_r==null) {qty_r = 1}
		// if (jQuery(e).find('[fo_tab_target="price"]').val()!='') {
		var temp_r_price =  parseFloat( jQuery(e).find('[fo_tab_target="price"]').val() );
			if (temp_r_price==''||temp_r_price==null||!temp_r_price) {temp_r_price = 0}
		temp_r_price = parseFloat( temp_r_price * qty_r);
		// }
		tot_r = parseFloat( tot_r ) + parseFloat( temp_r_price );
	});
	jQuery('.fo_tool_riepilogo .fo_tab_tool_total strong').text( parseFloat(tot_r).toFixed(2) + jQuery('.fo_woo_symb').text() );

	var tot_s = 0.00;
	jQuery('.fo_column_story .fo_tab_prod.fo_tab_prod_story[fotableid="'+jQuery('input[name="table_ID"]').val()+'"]').each(function(i,e){
		var temp_s_price = 0.00;
		var qty_s = parseFloat(jQuery(e).find('[fo_tab_target="qty"]').val());
			if (qty_s==''||qty_s==null) {qty_s = 1}
		// if (jQuery(e).find('[fo_tab_target="price"]').val()!='') {
		var temp_s_price =  parseFloat( jQuery(e).find('[fo_tab_target="price"]').val() );
			if (temp_s_price==''||temp_s_price==null) {temp_s_price = 0}
		temp_s_price = parseFloat( temp_s_price * qty_s );
		// }
		tot_s = parseFloat( tot_s ) + parseFloat( temp_s_price );
	});
	jQuery('.fo_tool_story .fo_tab_tool_total strong').text( parseFloat(tot_s).toFixed(2) + jQuery('.fo_woo_symb').text() );

	var tot_p = 0.00;
	jQuery('.fo_pay_column .fo_tab_prod').each(function(i,e){
		var temp_p_price = 0.00;
		var qty_p = parseFloat(jQuery(e).find('[fo_tab_target="qty"]').val());
			if (qty_p==''||qty_p==null) {qty_p = 1}
		// if (jQuery(e).find('[fo_tab_target="price"]').val()!='') {
		var temp_p_price =  parseFloat( jQuery(e).find('[fo_tab_target="price"]').val() );
			if (temp_p_price==''||temp_p_price==null) {temp_p_price = 0}
			temp_p_price = parseFloat( temp_p_price * qty_p );
		// }
		tot_p = parseFloat( tot_p ) + parseFloat( temp_p_price );
	});
	jQuery('.fo_pay_total').text( parseFloat(tot_p).toFixed(2) + jQuery('.fo_woo_symb').text() );
}


function fo_tab_add_product_to_order(){
	var copy = jQuery('.fo_column_products .fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"]').clone();

	copy.attr('draggable','false');
	copy.attr('ontouchmove','');
	copy.attr('ondragstart','');
	copy.attr('ontouchcancel','');
	copy.attr('ontouchend','');

	if ( copy.attr('fo_type') == 'new' ) {
		var index = jQuery('.fo_tab_prod_index').text();
		var index_story = jQuery('.fo_tab_prod_index_story').text();
	// copy.find('input').attr('name', '['+index+']'+copy.find('input').attr('name') );
		copy.find('input').each(function(i,e){
			jQuery(e).attr('name', '['+index+']'+jQuery(e).attr('name') );
		});
		copy.attr('fo_index', index);
		copy.attr('fo_index_story', index_story);
		copy.attr('fo_type','modify');
		copy.removeClass('fo_tab_prod_selected');
		copy.find('.fo_tab_prod_remove').show();
		copy.find('.fo_tab_prod_remove').attr('onclick','fo_tab_prod_remove(this);');
		jQuery('.fo_column_riepilogo').append(copy.first());

		jQuery('.fo_tab_prod_index').text( parseInt(index) + 1 );
		jQuery('.fo_tab_prod_index_story').text( parseInt(index_story) + 1 );

		jQuery('.fo_column_riepilogo .fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"]').click();
		// fo_ajax_riepilogo_height();
		// fo_tab_hystory_space('.fo_column_riepilogo','.fo_column_story','.fo_column_products');
	}
}


function fo_tab_prod_remove( input ){
	jQuery('.FO_flash_tab_header').removeClass('fo_tab_prod_modify');
	jQuery('.FO_flash_tab_footer').removeClass('fo_tab_prod_modify');

	jQuery(input).parent().remove();
	FO_calc_totals();
}

function fo_tab_parse_price( input ){
	var prod = jQuery('.fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"][fo_index="'+jQuery('.fo_actual_index').text()+'"][fo_index_story="'+jQuery('.fo_actual_index_story').text()+'"]');
	var DisplayValue = jQuery(input).text();
	if (DisplayValue==''||DisplayValue==null) { DisplayValue='0' }
	if ( jQuery(input).attr('fo_modificable') == 'true' ) {
		prod.find('input[fo_tab_target="price"]').val(DisplayValue);
		if ( jQuery(input).text() == '' ) {
			prod.find('input[fo_tab_target="price"]').val(jQuery('.fo_tab_reset_price').attr('fovalue'));
		}
		if ( prod.attr('fo_special') == 'Sconto' ) {
			prod.find('input[fo_tab_target="id"]').val(DisplayValue);
		}
		if ( prod.attr('fo_special') == 'Special' ) {
			prod.find('input[fo_tab_target="id"]').val(DisplayValue);
		}
	}
}

function fo_tab_parse_qty( input ){
	var prod = jQuery('.fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"][fo_index="'+jQuery('.fo_actual_index').text()+'"][fo_index_story="'+jQuery('.fo_actual_index_story').text()+'"]');
	if ( jQuery(prod).attr('fo_modificable') == 'true' ) {
		if ( prod.attr('fo_special') == 'Special' ||  prod.attr('fo_special') == 'Sconto' ) {
			prod.find('input[fo_tab_target="qty"]').val(jQuery(input).val());
		} else{
			prod.find('input[fo_tab_target="id"]').val(jQuery(input).val());
			prod.find('input[fo_tab_target="qty"]').val(jQuery(input).val().trim());
		}
	}
	FO_calc_totals();
}

function fo_tab_parse_note( input ){
	var prod = jQuery('.fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"][fo_index="'+jQuery('.fo_actual_index').text()+'"][fo_index_story="'+jQuery('.fo_actual_index_story').text()+'"]');
	if ( jQuery(prod).attr('fo_modificable') == 'true' ) {
		if ( prod.attr('fo_special') != 'Special' &&  prod.attr('fo_special') != 'Sconto' ) {
			prod.find('input[fo_tab_target="note"]').val(jQuery(input).val());
		}
	}
}

function fo_tab_parse_temp( input ){
	var prod = jQuery('.fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"][fo_index="'+jQuery('.fo_actual_index').text()+'"][fo_index_story="'+jQuery('.fo_actual_index_story').text()+'"]');
	if ( jQuery(prod).attr('fo_modificable') == 'true' ) {
		if ( prod.attr('fo_special') != 'Special' &&  prod.attr('fo_special') != 'Sconto' ) {
			prod.find('input[fo_tab_target="Temperature"]').val(jQuery(input).val());
		}
	}
}

function fo_tab_parse_variant( input ){
	var prod = jQuery('.fo_tab_prod[foprodid="'+jQuery('.fo_actual_prod').text()+'"][fo_index="'+jQuery('.fo_actual_index').text()+'"][fo_index_story="'+jQuery('.fo_actual_index_story').text()+'"]');
	var price = parseFloat(prod.find('input[fo_tab_target="price"]').attr('regularPrice')).toFixed(2);
	var finalPrice = price;
	var priceToAdd = 0.00;
//variant --------------------------------
	prod.find('input[fo_tab_target="variante"][fovariant="'+jQuery(input).attr('fovariant')+'"]').val(jQuery(input).val());
	var variVal = prod.find('input[fo_tab_target="variante"][fovariant="'+jQuery(input).attr('fovariant')+'"]').val();
	prod.find('input[fo_tab_target="variante"][fovariant="'+jQuery(input).attr('fovariant')+'"]').attr('priceadded',jQuery(input).parent().attr('fo_price_to_add'));
//price ----------------------------------
	prod.find('input[fo_tab_target="variante"]').each(function(i,e){
		if ( jQuery(e).attr('priceadded') != null && jQuery(e).attr('priceadded') != '' ) {
			priceToAdd = parseFloat( parseFloat(priceToAdd)+parseFloat( jQuery(e).attr('priceadded') ) ).toFixed(2);
		}
	});
	finalPrice = parseFloat(  parseFloat(price)+parseFloat(priceToAdd) ).toFixed(2);
	jQuery('.fo_tab_price').text( parseFloat(finalPrice).toFixed(2) );
	jQuery('.fo_tab_reset_price').attr('fovalue', parseFloat(finalPrice).toFixed(2) );
}

function fo_tab_price_default( input ){
	var price = jQuery(input).attr('fovalue');
	if (price!='') {
		jQuery('.fo_tab_price').text( parseFloat(price).toFixed(2));
		jQuery('.fo_tab_price').attr('fo_status_modify','false');
	}
}
function fo_keyboard_price( number ){
	var price = jQuery('.fo_tab_price').text();
	var modify = jQuery('.fo_tab_price').attr('fo_status_modify');
	if (modify == 'false') {
		if (number == '.') { jQuery('.fo_tab_price').text('0.') }else{
			jQuery('.fo_tab_price').text(number);
		}
	}
	if (modify == 'true') {
		if (number == '.') {
			if (price == '') { jQuery('.fo_tab_price').text('0.'); 
			}else if (price == '0.') { jQuery('.fo_tab_price').text(price);
			}else if (price.includes(".")) {jQuery('.fo_tab_price').text(price.replace(".", "")+'.');
			} else{ jQuery('.fo_tab_price').text( price + number );}
		} else{
			jQuery('.fo_tab_price').text( price + number );
		}
	}
	jQuery('.fo_tab_price').attr('fo_status_modify','true');
	fo_tab_parse_price( jQuery('.fo_tab_price') );
}

function fo_tab_price_del( input ){
	var price = jQuery('.fo_tab_price').text();
	jQuery('.fo_tab_price').text( price.slice(0, -1) );
	jQuery('.fo_tab_price').attr('fo_status_modify','true');
}

function fo_tab_price_ac( input ){
	jQuery('.fo_tab_price').text('');
	jQuery('.fo_tab_price').attr('fo_status_modify','true');
}

function fo_keyboard_special( number, text ){
	jQuery('.fo_tab_price').attr('fo_status_modify','true');
	if ( number == 'special' ) {
		FO_add_special_product(text);
	} else if(number == 'sub'){

	} else if(number == '-'){
		FO_add_discount_product(number);
	} else if(number == '%'){
		FO_add_discount_product(number);
	} else {}
	// fo_actual_table
	var price = jQuery('.fo_tab_price').text();
	var modify = jQuery('.fo_tab_price').attr('fo_status_modify');
}

function FO_add_discount_product( number ){
	var prodSpecial = jQuery('.fo_generic_prod .fo_tab_prod_discount').clone();
	var index = jQuery('.fo_tab_prod_index').text();
	var index_story = jQuery('.fo_tab_prod_index_story').text();
	var tab_price = jQuery('.fo_tab_price').text();
	if (tab_price=='') {tab_price='0';}
	if (parseFloat(tab_price) <= 0) {
		return false;
	}
	prodSpecial.find('input').each(function(i,e){
		jQuery(e).attr('name', '['+index+']'+jQuery(e).attr('name')+'[Sconto'+index+']' );
	});
	prodSpecial.attr('foprodid', 'Sconto'+index );
	prodSpecial.attr('fo_index', index);
	prodSpecial.attr('fo_index_story', index_story);
	prodSpecial.attr('foprodtot', tab_price);

	prodSpecial.removeClass('fo_tab_prod_selected');

	prodSpecial.find('[fo_tab_target="id"]').val(tab_price);

	prodSpecial.find('[fo_tab_target="price"]').val(tab_price);
	prodSpecial.find('[fo_tab_target="price"]').attr('regularPrice',tab_price);

	if (number == '-') {
		prodSpecial.find('.fo_tab_prod_price').text('- '+parseFloat(tab_price).toFixed(2)+' '+jQuery('.fo_woo_symb').text());
	} else if (number == '%') {
		prodSpecial.find('.fo_tab_prod_price').text(tab_price+' %');
	} else{
		prodSpecial.find('.fo_tab_prod_price').text(tab_price);
	}
	

	prodSpecial.find('.fo_tab_prod_remove').show();
	prodSpecial.find('.fo_tab_prod_remove').attr('onclick','fo_tab_prod_remove(this);');
	jQuery('.fo_column_riepilogo').append(prodSpecial);

jQuery('.fo_column_riepilogo .fo_tab_prod_special[foprodid="Special'+index+'"]').click();

	jQuery('.fo_tab_prod_index').text( parseInt(index) + 1 );
	jQuery('.fo_tab_prod_index_story').text( parseInt(index_story) + 1 );

	fo_tab_hystory_space('.fo_column_riepilogo','.fo_column_story','.fo_column_products');
}



function FO_add_special_product( text ){
	var prodSpecial = jQuery('.fo_generic_prod .fo_tab_prod_special').clone();
	var index = jQuery('.fo_tab_prod_index').text();
	var index_story = jQuery('.fo_tab_prod_index_story').text();
	var tab_price = jQuery('.fo_tab_price').text();
	if (tab_price==''||tab_price==null) {tab_price='0';}

	prodSpecial.find('input').each(function(i,e){
		jQuery(e).attr('name', '['+index+']'+jQuery(e).attr('name')+'['+text+index+']' );
	});
	prodSpecial.attr('foprodid', text+index );
	prodSpecial.attr('fo_index', index);
	prodSpecial.attr('fo_index_story', index_story);
	prodSpecial.attr('foprodtot', tab_price);

	prodSpecial.removeClass('fo_tab_prod_selected');

	prodSpecial.find('[fo_tab_target="price"]').val(tab_price);
	prodSpecial.find('[fo_tab_target="id"]').val(tab_price);

	prodSpecial.find('[fo_tab_target="price"]').attr('regularPrice',tab_price);
	prodSpecial.find('.FO_prod_name_manage').text(text);

	prodSpecial.find('.fo_tab_prod_remove').show();
	prodSpecial.find('.fo_tab_prod_remove').attr('onclick','fo_tab_prod_remove(this);');
	jQuery('.fo_column_riepilogo').append(prodSpecial);

jQuery('.fo_column_riepilogo .fo_tab_prod_special[foprodid="'+text+index+'"]').click();

	jQuery('.fo_tab_prod_index').text( parseInt(index) + 1 );
	jQuery('.fo_tab_prod_index_story').text( parseInt(index_story) + 1 );

	fo_tab_hystory_space('.fo_column_riepilogo','.fo_column_story','.fo_column_products');
}
















function FO_tab_Card_show( target ){
	jQuery('.fo_tab_show').show();
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');

	jQuery('.fo_story').hide();
	jQuery('.fo_story').removeClass('fo_tab_prod_story');
	jQuery('.fo_story[fotableid="'+jQuery(target).attr('fo_tableid')+'"]').show();
	jQuery('.fo_story[fotableid="'+jQuery(target).attr('fo_tableid')+'"]').addClass('fo_tab_prod_story');

	jQuery('input[name="table_name_cpt"]').val( jQuery(target).attr('fotable') );
	jQuery('input[name="table_ID"]').val( jQuery(target).attr('fo_tableid') );

	jQuery('input[name="table_start_time"]').val( jQuery(target).attr('table_start_time') );
	jQuery('input[name="table_last_update"]').val( jQuery(target).attr('table_last_update') );
	jQuery('input[name="table_orders"]').val( jQuery(target).attr('table_orders') );
	jQuery('input[name="table_info"]').val( jQuery(target).attr('table_info') );
	jQuery('input[name="table_receipt"]').val( jQuery(target).attr('table_receipt') );
	jQuery('input[name="table_other"]').val( jQuery(target).attr('table_other') );
	jQuery('input[name="table_totals"]').val( jQuery(target).attr('table_totals') );
	jQuery('input[name="table_table_tableid"]').val( jQuery(target).attr('table_table_tableid') );

	jQuery('.fo_actual_table').text( jQuery(target).attr('fo_tableid') );
	// if (true) {}fo_order_table_story 
	jQuery('.fo_pay_table_button').attr('fotableid', jQuery(target).attr('fo_tableid') );

	jQuery('.fo_tab_table_name').text( jQuery(target).attr('fotable') );
	jQuery('.fo_tab_table_name').parent().attr('style', jQuery(target).attr('style'));

	if ( jQuery(target).attr('fotable_status') > 0 ) {
		jQuery('.fo_pay_table_button').show();
		jQuery('.fo_clear_table_button').show();
	} else { 
		jQuery('.fo_pay_table_button').hide(); 
		jQuery('.fo_clear_table_button').hide(); 
	}
	FO_calc_totals();
}
function FO_tab_Card_hide(){
	jQuery('.fo_tab_show').hide();
	// jQuery('header').css('display','');
	// jQuery('footer').css('display','');
	fo_toggle_header_footer();
}

function FO_confirm( call_b, text, text_v = '', text_f = '' ){
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');
	// jQuery('.fo_tab_show').hide();
	if (text_v == '') {text_v = ' si '}
	if (text_f == '') {text_f = ' no '}
	var ELconfirm = '';
	ELconfirm += '<div class="FO_confirm_container">';
		ELconfirm += '<div class="Advanced_Card_background"></div>';
		ELconfirm += '<div class="FO_confirm_message">';
			ELconfirm += '<p style="flex-basis:100%;">'+text+'</p>';
		ELconfirm += '<button style="margin-right:auto;min-width:75px;" class="fo_button" onclick="jQuery(this).closest(`.FO_confirm_container`).remove();'+call_b+'">'+
			text_v+'</button>';
		ELconfirm += '<button style="margin-left:auto;min-width:75px;" class="fo_button" onclick="jQuery(this).closest(`.FO_confirm_container`).remove();">'+
			text_f+'</button>';
			ELconfirm += '</div>';
		ELconfirm += '</div>';
	ELconfirm += '</div>';
	jQuery('body').append(ELconfirm);
}

function FO_alert( call_b, text, text_v = '' ){
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');
	// jQuery('.fo_tab_show').hide();
	if (text_v == '') {text_v = ' OK '}
	var ELconfirm = '';
	ELconfirm += '<div class="FO_confirm_container">';
		ELconfirm += '<div class="Advanced_Card_background"></div>';
		ELconfirm += '<div class="FO_confirm_message">';
			ELconfirm += '<p style="flex-basis:100%;">'+text+'</p>';
		ELconfirm += '<button style="margin-left:auto;margin-right:auto;min-width:75px;" class="fo_button" onclick="jQuery(this).closest(`.FO_confirm_container`).remove();'+call_b+'">'+
			text_v+'</button>';
			ELconfirm += '</div>';
		ELconfirm += '</div>';
	ELconfirm += '</div>';
	jQuery('body').append(ELconfirm);
}

function FO_tab_clear_table( def_confirm = false, hide = true ){
	if ( def_confirm == false ) {
		text = jQuery('#fo_tab_clear_table_text').text();
		// if ( !FO_confirm('FO_tab_clear_table(true)',text) ) { return false; }
		FO_confirm('FO_tab_clear_table(true)',text);
		return false;
	}
	// jQuery('.FOloadingCardPublic').show();
	jQuery('.FO_flash_tab_order_container').find('.FOloadingCardPublic').fadeOut();

	jQuery('.fo_table_cell[fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"]').attr('onclick','return false;');
	// jQuery(".FOloadingCardPublicMain").fadeOut(200);
	jQuery('.FO_table_grid [fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"] .FOloadingTable').show();
	if (hide) {
		FO_tab_Card_hide();
	}
	jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
		    action: 'FO_flash_tab_clear_table',
		    nonce: flash_orders_ajax_view_orders_vars.nonce,
		    table_name_cpt: jQuery('input[name="table_name_cpt"]').val(),
		    table_id: jQuery('input[name="table_ID"]').val(),
		    _fononce_flash_tab_order: jQuery('input[name="_fononce_flash_tab_order"]').val(),
		    // def_confirm: def_confirm,
		},
		success: function (response) {
			console.log(response);
			// console.log(jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]'));
			// jQuery('.FO_order_list_summary').empty();
			// var strong = jQuery('.fo_column_story strong').clone();
			jQuery('.fo_order_table_story[fotableid="'+response.table_id+'"][fo_order_id]').remove();
			jQuery('.fo_tab_prod[fo_type="story"][fotableid="'+response.table_id+'"]').remove();
			// jQuery('.fo_column_story').append(strong);
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').attr('fotable_status','0');
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').css('backgroundColor','green');
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_status_string')
				.text(jQuery('#fo_tab_table_status_free_text').text());
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_tab_notify').hide();
				
			// jQuery('.FO_flash_tab_order_container').find('.FOloadingCardPublic').fadeOut();
			// FO_tab_Card_hide();
			jQuery(".FOloadingCardPublicMain").fadeOut(200);
			jQuery('.fo_table_cell[fo_tableid="'+response.table_id+'"]').attr('onclick','FO_tab_Card_show(this)');
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"] .FOloadingTable').hide();
			return;
		}
	});
}


function fo_clear_all_tables( def_confirm = false ){
	if ( def_confirm == false ) {
		text = jQuery('#fo_tab_clear_all_table_text').text();
		FO_confirm('fo_clear_all_tables(true)',text);
		return false;
	}
	jQuery('.FOloadingCardPublic').show();
	jQuery('.FO_flash_tab_order_container').find('.FOloadingCardPublic').fadeOut();

	jQuery('.fo_table_cell').attr('onclick','return false;');
	jQuery('.FO_table_grid .FOloadingTable').show();
	FO_tab_Card_hide();
	FO_statistics_hide();

	jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
		    action: 'FO_flash_tab_clear_all_tables',
		    nonce: flash_orders_ajax_view_orders_vars.nonce,
		    _fononce_flash_tab_order: jQuery('input[name="_fononce_flash_tab_order"]').val(),
		},
		success: function (response) {
			console.log(response);
			jQuery('.fo_order_table_story[fo_order_id]').remove();
			jQuery('.fo_tab_prod[fo_type="story"]').remove();
			jQuery('.fo_table_cell').attr('fotable_status','0');
			jQuery('.fo_table_cell').css('backgroundColor','green');
			jQuery('.fo_table_cell').find('.fo_status_string').text(jQuery('#fo_tab_table_status_free_text').text());

			jQuery(".FOloadingCardPublicMain").fadeOut(200);
			jQuery('.fo_table_cell').attr('onclick','FO_tab_Card_show(this)');
			jQuery('.FO_table_grid').find('.fo_tab_notify').hide();
			jQuery('.FO_table_grid .FOloadingTable').hide();
			return;
		}
	});
}

function FO_tab_go_order(input){
	text = jQuery('#fo_tab_go_order_text').text();
	// if (confirm(text) == true) {
		jQuery('.FOloadingCardPublic').show();
		if (jQuery(input).attr('fo_order_type') == 'new_order') {
			FO_order_tab_ajax();
		} else if(jQuery(input).attr('fo_order_type') == 'modify_order'){
		} else{ }
	// }
}

// in the pay function:   (input = '.fo_pay_ajax_container',action= 'FO_flash_tab_pay_ajax' )
function FO_order_tab_ajax(input = '.fo_column_riepilogo', action = 'FO_flash_tab_order_ajax'){
	var table = jQuery(input);
	var item;
	var foserial = jQuery(table).find('input, textarea').serializeArray();
	var foserialmap = foserial.map(({ name, value }) => ({ [name]: value }));
	foserialmap = foserial.map(item => {
	    var container = {};
	    container[item.name] = item.value;
	    return container;
	}); 
		var Src_custom = jQuery('.FO_customers_container input').serializeArray();
	var Src_customers = Src_custom.map(({ name, value }) => ({ [name]: value }));
	Src_customers = Src_custom.map(item => {
	    var Src_container = {};
	    Src_container[item.name] = item.value;
	    return Src_container;
	}); 
	console.log(Src_customers);

	var created_via = 'tab';
	if (action == 'FO_flash_tab_pay_ajax') {
		created_via = 'pay_tab';
		console.log(' Pay order submitted sucessfully !!! ');
	}else{
		console.log(' order submitted sucessfully !!! ');
	}

	jQuery('.FO_flash_tab_order_container').find('.FOloadingCardPublic').fadeOut();
	jQuery(".FOloadingCardPublicMain").fadeOut(200);

	jQuery('.FO_table_grid [fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"] .FOloadingTable').show();
	jQuery('.fo_table_cell[fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"]').attr('onclick','return false;');

	jQuery('.fo_column_story .fo_title_all[fotableid="'+jQuery('input[name="table_ID"]').val()+'"]')
		.after('<div class="fo_button fo_story fo_order_table_story" fotableid="'+jQuery('input[name="table_ID"]').val()+'" fo_status="Loading" > Loading </div>');

	var Ghost = jQuery(input).find('.fo_tab_prod').clone();
	// Ghost.attr('onclick','');
	jQuery('.fo_ghost_draft').append('<div fotableid="'+jQuery('input[name="table_ID"]').val()+'" index="'+jQuery('.fo_tab_prod_ghost_draft_index').text()+'" fo_status="Loading"></div>');
	jQuery('.fo_ghost_draft [fotableid="'+jQuery('input[name="table_ID"]').val()+'"][index="'+jQuery('.fo_tab_prod_ghost_draft_index').text()+'"]').append( Ghost );
	jQuery('.fo_tab_prod_ghost_draft_index').text( parseInt(jQuery('.fo_tab_prod_ghost_draft_index').text()) +1 );

	jQuery(input).find('.fo_tab_prod').remove();
	FO_tab_Card_hide();
	FO_pay_tab_Card_hide();

	// console.log(jQuery('input[name="user_ID"]').val());
	
	jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
			action: action,
			nonce: flash_orders_ajax_view_orders_vars.nonce,
			table_name_cpt: jQuery('input[name="table_name_cpt"]').val(),
			order_note: jQuery('textarea[name="order_note"]').val(),
			table_id: jQuery('input[name="table_ID"]').val(),
			table_total: jQuery('input[name="table_total"]').val(),

			user_id: jQuery('input[name="user_ID"]').val(),
			// customer_id: jQuery('input[name="customer_ID"]').val(),
			// N_customers: N_customers,
			S_customers: Src_customers,
			customer_type: jQuery('input[name="customer_type"]').prop('checked'),
			created_via: created_via,
			foserial: foserial,
			foserialmap: foserialmap,
			_fononce_flash_tab_order: jQuery('input[name="_fononce_flash_tab_order"]').val(),
		},
		success: function (response) {
			console.log(response);

			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').css('backgroundColor','red');
			jQuery('.FO_table_grid').removeClass('fo_tab_prod_last_modify');
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_status_string')
				.text(jQuery('#fo_tab_table_status_close_text').text());

			jQuery('.fo_ghost_draft [fotableid="'+response.table_id+'"][fo_status="Loading"] .fo_tab_prod').each(function(i,e){
				var story = jQuery(e).clone();
				console.log(story);
				story.attr('fo_index_story',response.order_id);
				story.attr('fotableid',response.table_id);
				story.attr('fo_index',jQuery('.fo_tab_prod_index_story').text());
				story.removeClass('fo_tab_prod_modify');
				story.addClass('fo_story');

				story.attr('fo_modificable','false');
				story.attr('fo_type','story');

				story.css('display','none');
				story.find('.fo_tab_prod_remove').remove();
				jQuery('.fo_column_story').append(story);
			});
			jQuery('.fo_ghost_draft [fotableid="'+response.table_id+'"][fo_status="Loading"]').remove();

			jQuery('.fo_order_table_story[fotableid="'+response.table_id+'" ][fo_status="Loading"]').attr('fo_order_id', response.order_id);
			jQuery('.fo_order_table_story[fotableid="'+response.table_id+'"][fo_status="Loading"]').attr('onclick', 'fo_filter_tab_story(this,`'+response.order_id+'`)');
			jQuery('.fo_order_table_story[fotableid="'+response.table_id+'"][fo_status="Loading"]').text( response.order_id );

			jQuery('.fo_order_table_story[fotableid="'+response.table_id+'" ][fo_status="Loading"]').attr('fo_status', 'completed');

			if (action != 'FO_flash_tab_pay_ajax') {
				jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').attr('fotable_status','1');
			} else{
				jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').attr('fotable_status','0');
				jQuery('.fo_order_table_story[fotableid="'+response.table_id+'"][fo_order_id]').remove();
				jQuery('.fo_tab_prod[fo_type="story"][fotableid="'+response.table_id+'"]').remove();
				jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').css('backgroundColor','green');
				jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_status_string')
					.text(jQuery('#fo_tab_table_status_free_text').text());
				jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_tab_notify').hide();
			}

			jQuery('.fo_table_cell[fo_tableid="'+response.table_id+'"]').attr('onclick','FO_tab_Card_show(this)');
			jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"] .FOloadingTable').hide();

			return;
		}
		//error: function(response){
		//	console.log(response);
		//}
	});
}




function fo_tab_hystory_space( input, target, sc_target = '' ){
	// if ( window.screen.width > 1100 ) {
	// 	// if (jQuery(input).find('.fo_tab_prod').length) {
	// 		// jQuery(target).find('.fo_tab_prod').css('scale', 0.2);
	// 		jQuery(target).find('.fo_tab_prod').css('height', '30px');
	// 		jQuery(target).find('.fo_tab_prod').css('width', '45px');
	// 		// jQuery(target).css('height', '40px');
	// 		jQuery(target).css("font-size", "15px");
	// 		// jQuery(target).find('.fo_tab_prod_remove').slideUp();
	// 		// jQuery(input).find('.fo_tab_prod').css('scale', 1);
	// 		jQuery(input).find('.fo_tab_prod').css('height', '90px');
	// 		jQuery(input).find('.fo_tab_prod').css('width', '90px');
	// 		// jQuery(input).css('height', 'calc(50% - 55px)');
	// 		jQuery(input).css("font-size", "");
	// 		jQuery(input).find('.fo_tab_prod_remove').slideDown();
	// 	// }
	// }

jQuery('.fo_column_story, .fo_column_riepilogo, .fo_column_products').removeClass('fo_area_expanded_full');
jQuery('.fo_column_story, .fo_column_riepilogo, .fo_column_products').removeClass('fo_area_expanded_med');
jQuery('.fo_column_story, .fo_column_riepilogo, .fo_column_products').removeClass('fo_area_expanded_thin');

	jQuery(input).addClass('fo_area_expanded_full');
	// jQuery(input).removeClass('fo_area_expanded_thin');
	jQuery(target).addClass('fo_area_expanded_thin');
	// jQuery(target).removeClass('fo_area_expanded_full');
	jQuery(sc_target).addClass('fo_area_expanded_thin');
	// jQuery(sc_target).removeClass('fo_area_expanded_full');
}

function fo_tab_empty_section( target ){
	jQuery(target).find('.fo_tab_prod').remove();
	FO_calc_totals();
}





function fo_keyboard_qty_value( number ){
	jQuery('.fo_target_qty_prod').val( parseInt(jQuery('.fo_target_qty_prod').val()) + number);
	if( jQuery('.fo_target_qty_prod').val() < 1 ){
		jQuery('.fo_target_qty_prod').val(1);
	}
	fo_tab_parse_qty( jQuery('.fo_target_qty_prod') );
	// jQuery('.fo_target_qty_prod').attr('value',)
}





// function fo_update_table_page(){
// 	setInterval(function () {
//         jQuery.ajax({
//             type: 'POST',
//             url: flash_orders_ajax_view_orders_vars.ajaxurl,
//             data: {
//                 action: 'FO_check_for_orders',
//                 nonce: flash_orders_ajax_view_orders_vars.nonce,
//                 last_order_id: jQuery('#result-container tr:nth-child(1)').attr('orderid'),
//                 last_order_data: jQuery('#result-container tr:nth-child(1)').attr('orderdata'),
//                 order_id_table: order_id_table,
//             },
//             success: function (response) {
//                 console.log(response);
//                 if ( response.updateNeeded ) {
//                     if (response.newOrders.length) {
//                         response.newOrders.forEach(function(order) {
//                             if ( jQuery('#result-container tr:nth-child(1)').attr('orderid') != order.id ) {
//                                 FO_append_to_order( order, response.string );
//                                 FO_play_sound_notify();
//                                 FO_inizialize_timer();
//                             }
//                         });
//                     }
//                 }
//                 return;
//             }
//         });
//         FO_hide_duplicate_orders();
//     }, 1000 );
// }
function FO_pay_tab_Card_show( input ){
	jQuery('.fo_pay_tab_show').show();
	jQuery('.fo_tab_prod').removeClass('fo_tab_prod_story');
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');
	
	jQuery('.fo_list_items').empty();
	jQuery('.fo_list_final_order').empty();
	jQuery('.fo_pay_total').empty();
var tot = 0.00;
	jQuery('.fo_tab_prod[fotableid="'+jQuery(input).attr('fotableid')+'"]').each(function(i,e){
		var item_clone = jQuery(e).clone();
		tot = parseFloat( tot ) + parseFloat( jQuery(e).find('[fo_tab_target="price"]').val() );
		item_clone.attr('style','');
		jQuery('.fo_list_items').append(item_clone);
	});
	jQuery('.fo_column_riepilogo .fo_tab_prod').each(function(i,e){
		var item_clone = jQuery(e).clone();
		tot = parseFloat( tot ) + parseFloat( jQuery(e).find('[fo_tab_target="price"]').val() );
		item_clone.attr('style','');
		jQuery('.fo_list_items').append(item_clone);
	});
var index = 10000;
	jQuery('.fo_order_table_story[fotableid="'+jQuery(input).attr('fotableid')+'"]').each(function(i,e){
		if ( jQuery(e).attr('fo_order_id') != null ) {
			jQuery('.fo_list_final_order').append('<input type="hidden" name="['+index+i+'][orders]['+jQuery(e).attr('fo_order_id')+']" value="'+jQuery(e).attr('fo_order_id')+'">');
		}
	});
	jQuery('.fo_pay_total').text( parseFloat(tot).toFixed(2) );
	Fo_add_index_to_products();
}
function FO_pay_tab_Card_hide( input ){
	jQuery('.fo_list_items').empty();
	jQuery('.fo_list_final_order').empty();
	jQuery('.fo_pay_total').empty();
	jQuery('.fo_pay_tab_show').hide();
	jQuery('.FO_customers_container').empty();
}

function Fo_add_index_to_products() {
	jQuery('.fo_pay_column .fo_tab_prod').each(function(i,e){
		var fake = i + 1 ;
		jQuery(e).find('input').each(function(ind,ele){
			jQuery(ele).attr('name', '['+fake+']'+jQuery(ele).attr('name'));
		});
	});
}




function FO_order_tab_pay_ajax(){
	// jQuery('.FO_flash_tab_order_pay_container .FOloadingCardPublic').show();
	// jQuery('.fo_table_cell[fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"]').attr('onclick','return false;');
	
	// var table = jQuery('.fo_pay_ajax_container'); 
	// var item; 
	// var foserial = jQuery(table).find('input, textarea').serializeArray(); 
	// var foserialmap = foserial.map(({ name, value }) => ({ [name]: value })); 
	// foserialmap = foserial.map(item => {
	// 	var container = {};
	// 	container[item.name] = item.value;
	// 	return container;
	// });
	// console.log(foserialmap);
	// console.log(window);
	// console.log(' order submitted sucessfully !!! ');
	// FO_pay_tab_Card_hide();
	// FO_tab_Card_hide();
	// jQuery('.FO_flash_tab_order_pay_container .FOloadingCardPublic').hide();
	// jQuery(".FOloadingCardPublicMain").fadeOut(200);

// jQuery('.FO_table_grid [fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"] .FOloadingTable').show();
// jQuery('.fo_table_cell[fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"]').attr('onclick','return false;');

// jQuery('.fo_column_story .fo_title_all[fotableid="'+jQuery('input[name="table_ID"]').val()+'"]')
// 		.after('<div class="fo_button fo_story fo_order_table_story" fotableid="'+jQuery('input[name="table_ID"]').val()+'" fo_status="Loading" > Loading </div>');

// var Ghost = jQuery('.fo_column_riepilogo .fo_tab_prod').clone();
// 	// Ghost.attr('onclick','');
// 	jQuery('.fo_ghost_draft').append('<div fotableid="'+jQuery('input[name="table_ID"]').val()+'" index="'+jQuery('.fo_tab_prod_ghost_draft_index').text()+'" fo_status="Loading"></div>');
// 	jQuery('.fo_ghost_draft [fotableid="'+jQuery('input[name="table_ID"]').val()+'"][index="'+jQuery('.fo_tab_prod_ghost_draft_index').text()+'"]').append( Ghost );
// 	jQuery('.fo_tab_prod_ghost_draft_index').text( parseInt(jQuery('.fo_tab_prod_ghost_draft_index').text()) +1 );

	// jQuery.ajax({
	// 	type: 'POST',
	// 	url: flash_orders_ajax_view_orders_vars.ajaxurl,
	// 	data: {
	// 	    action: 'FO_flash_tab_pay_ajax',
	// 	    nonce: flash_orders_ajax_view_orders_vars.nonce,
	// 	    table_name_cpt: jQuery('input[name="table_name_cpt"]').val(),
	// 	    order_note: jQuery('textarea[name="order_note"]').val(),
	// 	    table_id: jQuery('input[name="table_ID"]').val(),
	// 	    foserial: foserial,
	// 	    foserialmap: foserialmap,
	// 	    // order_id: ,
	// 	},
	// 	success: function (response) {
	// 		console.log(response);
	// 			// jQuery('.FO_order_list_summary').empty();
	// 		// jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').css('backgroundColor','red');
	// 		// jQuery('.FO_table_grid').removeClass('fo_tab_prod_last_modify');
	// 		// // jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').addClass('fo_tab_prod_last_modify');

	// 		// jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').find('.fo_status_string')
	// 		// 	.text(jQuery('#fo_tab_table_status_close_text').text());
	// 		// 	jQuery('.FO_flash_tab_order_container').find('.FOloadingCardPublic').fadeOut();

	// 		// jQuery('.fo_column_story .fo_story').remove();
	// 		// jQuery('.fo_column_riepilogo .fo_tab_prod').remove();

	// 		// fo_change_order_status();
	// 		FO_tab_clear_table(true, false);
	// 	// jQuery('.fo_table_cell[fo_tableid="'+response.table_id+'"]').attr('onclick','FO_tab_Card_show(this)');
	// 	// jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"]').attr('fotable_status','0');
	// 	// jQuery('.FO_table_grid [fo_tableid="'+response.table_id+'"] .FOloadingTable').hide();
	// 		// return;
	// 	}
	// });

	// console.log(' order submitted sucessfully 2 !!! ');
	FO_order_tab_ajax('.fo_pay_ajax_container', 'FO_flash_tab_pay_ajax');
	// FO_tab_clear_table(true, false);
}





function fo_change_order_status( order_id = '', status = '' ){
	if (order_id != '') {
		if (status == '') {status = 'completed'}
		jQuery.ajax({
		    type: 'POST',
		    url: flash_orders_ajax_view_orders_vars.ajaxurl,
		    data: {
		        action: 'FO_ajax_change_order_status',
		        nonce: flash_orders_ajax_view_orders_vars.nonce,
		        order_id: order_id,
		        status: status
		    },
		    success: function(response) {
		        console.log(' ...ajax-response... ');
		        console.log(response);
			}
		});
	}
}



function fo_toggle_header_footer( check = false ){
	if (check) {
		if (jQuery('.fo_toggle_header_footer').val() == 'true') {
			jQuery('.fo_toggle_header_footer').val('false');
		} else{
			jQuery('.fo_toggle_header_footer').val('true');
		}
	}
	if ( jQuery('.fo_toggle_header_footer').val() == 'true') {
		if (jQuery('header').css('display') == 'none') {
			jQuery('header').css('display','');
			jQuery('footer').css('display','');
		}else{
			jQuery('header').css('display','none');
			jQuery('footer').css('display','none');
		}
	} else{
		jQuery('header').css('display','none');
		jQuery('footer').css('display','none');
	}
}










function FO_toggle_inner_checkbox(input){
	if ( jQuery(input).find('input[type="checkbox"]').is(":checked") ) {
		jQuery(input).find('input[type="checkbox"]').prop('checked', false);
	} else{
		jQuery(input).find('input[type="checkbox"]').prop('checked', true);
	}
}
function FO_toggle_inverted_checkbox(input){
	if ( jQuery(input).is(":checked") ) {
		jQuery(input).prop('checked', false);
	} else{
		jQuery(input).prop('checked', true);
	}
}
function FO_customer_pay(input){
	if ( jQuery(input).is(":checked") ) {
		jQuery('.fot_pay_new_customer').slideUp();
		jQuery('.fot_pay_search_customer').slideDown();
	} else{
		jQuery('.fot_pay_new_customer').slideDown();
		jQuery('.fot_pay_search_customer').slideUp();
	}
}









function FO_catering_show(){
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');

	jQuery('.FOP_tab_catering_fixed_window').show();
}

function FO_catering_hide(){
	fo_toggle_header_footer();

	jQuery('.FOP_tab_catering_fixed_window').hide();

	jQuery('input[name="fo_catering_id"]').val('');
	jQuery('input[name="fo_tab_catering_title"]').val('');
	jQuery('textarea[name="fo_tab_catering_desc"]').val('');
	jQuery('input[name="fo_delivery_date"]').val('');
	jQuery('select[name="fo_catering_status"]').val('');

	jQuery('input[name="fo_catering_type"]').val('');
}

function fo_catering_modify( input ){
	jQuery('strong.FOP_tab_catering_title').text(jQuery('strong.FOP_tab_catering_title').attr('modify'));

	jQuery('input[name="fo_catering_id"]').val(jQuery(input).attr('fo_catering_id'));

	jQuery('input[name="fo_tab_catering_title"]').val(jQuery(input).find('.fo_catering_name').text().replace(/^\s+|\s+$/gm,''));
	jQuery('textarea[name="fo_tab_catering_desc"]').val(jQuery(input).find('.fo_catering_desc').text().replace(/^\s+|\s+$/gm,''));
	jQuery('input[name="fo_delivery_date"]').val(jQuery(input).find('.fo_catering_date').attr('fo_date'));
	jQuery('select[name="fo_catering_status"]').val(jQuery(input).find('.fo_catering_status').attr('fo_status'));
	jQuery('input[name="fo_catering_type"]').val('update');
	FO_catering_show();
}


function FO_catering_save( def_confirm = false ){
	var title = jQuery('input[name="fo_tab_catering_title"]').val();
	var date = jQuery('input[name="fo_delivery_date"]').val();
	if ( title == '' || date == '' ) {
		FO_alert('', jQuery('#fo_tab_create_catering_error_text').text() );
		return false;
	}
	if ( def_confirm == false ) {
		if ( jQuery('input[name="fo_catering_type"]').val() == 'update' ) {
			var text = jQuery('#fo_tab_refresh_catering_text').text();
		} else{
			var text = jQuery('#fo_tab_create_catering_text').text();
		}
		
		FO_confirm('FO_catering_save( true )', text + '</br> 	"' + title + '" ?' );
		return false;
	}
	// jQuery('.fo_table_cell[fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"]').attr('onclick','return false;');
	jQuery(".FOloadingCardPublicMain").show();
	// jQuery('.FO_table_grid [fo_tableid="'+jQuery('input[name="table_ID"]').val()+'"] .FOloadingTable').show();
	jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
		    action: 'FO_insert_post_ajax',
		    nonce: flash_orders_ajax_view_orders_vars.nonce,
		    cpt: 'catering',
		    title: jQuery('input[name="fo_tab_catering_title"]').val(),
		    content: jQuery('textarea[name="fo_tab_catering_desc"]').val(),
		    fo_delivery_date: jQuery('input[name="fo_delivery_date"]').val(),
		    fo_catering_status: jQuery('select[name="fo_catering_status"]').val(),
		    post_id: jQuery('input[name="fo_catering_id"]').val(),
		    _fononce_insert_post_ajax_nonce: jQuery('input[name="_fononce_insert_post_ajax_nonce"]').val(),
		},
		success: function (response) {
			console.log(response);
			FO_catering_hide();
			javascript:history.go(0);
			return;
		}
	});

}
function FO_catering_delete( input_id, def_confirm = false ){
	if ( def_confirm == false ) {
		var title = jQuery('input[name="fo_tab_catering_title"]').text();
		var text = jQuery('#fo_tab_create_catering_delete_text').text();
		FO_confirm('FO_catering_delete('+ input_id +', true )', text + '</br> 	"' + title + '" ?' );
		return false;
	}
	jQuery(".FOloadingCardPublicMain").show();

	jQuery.ajax({
		type: 'POST',
		url: flash_orders_ajax_view_orders_vars.ajaxurl,
		data: {
		    action: 'FO_trash_post_ajax',
		    nonce: flash_orders_ajax_view_orders_vars.nonce,
		    cpt: 'catering',
		    delete_id: input_id,
		     _fononce_insert_post_ajax_nonce: jQuery('input[name="_fononce_insert_post_ajax_nonce"]').val(),
		},
		success: function (response) {
			console.log(response);
			FO_catering_hide();
			javascript:history.go(0);
			return;
		}
	});

}


function FO_settings_show(){
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');
	jQuery('#FO_active_settings').animate({
		right: '0px',
	}, 300);
	jQuery('.fo_setting_show').fadeIn();
	setTimeout(function() {
		jQuery('#FO_active_settings').addClass('setting_is_show');
	}, 1000);
}

function FO_statistics_show(){
	fo_toggle_header_footer();
	jQuery('header').css('display','none');
	jQuery('footer').css('display','none');

	fo_stat_filter_table();
	jQuery('.fo_stat_container').slideDown();
	jQuery('.fo_statistic_show').fadeIn();
	

	setTimeout(function() {
		jQuery('.fo_stat_container').addClass('setting_is_show');
	}, 1000);
}

function FO_statistics_hide(){
	fo_toggle_header_footer();

	jQuery('.fo_stat_container').removeClass('setting_is_show');
	jQuery('.fo_stat_container').slideUp();
	jQuery('.fo_statistic_show').fadeOut();
}

function FO_settings_hide(){
	var str
	if ( window.screen.width < 1100 ) {
		str = '-100%';
	} else{ str = '-50%'; }
	jQuery('#FO_active_settings').animate({
		right: str,
	}, 300);
	jQuery('.fo_setting_show').fadeOut();
	jQuery('#FO_active_settings').removeClass('setting_is_show');
	fo_toggle_header_footer();
}



function fo_tab_show_keyboard_button(){
	if ( window.screen.width <= 1100 ) {
		if ( jQuery('.fo_tab_col_3').attr('fo_show') == 'hide' ) {
			jQuery('.fo_tab_col_3').show();
			jQuery('.fo_tab_col_3').attr('fo_show','show');
		} else{
			jQuery('.fo_tab_col_3').hide();
			jQuery('.fo_tab_col_3').attr('fo_show','hide');
		}
		
	}
}

function fo_tab_show_variation_button(){
	if (  window.screen.width > 600 && window.screen.width <= 1100 ) {
		if ( jQuery('.fo_tab_col_2').attr('fo_show') == 'hide' ) {
			jQuery('.fo_tab_col_2').show();
			jQuery('.fo_tab_col_2').attr('fo_show','show');
			jQuery('.fo_tab_col_1').attr('style','width:calc(65% - 21px);');
		} else{
			jQuery('.fo_tab_col_2').hide();
			jQuery('.fo_tab_col_2').attr('fo_show','hide');
			jQuery('.fo_tab_col_1').attr('style','width:calc(100% - 21px);');
		}
		
	} else if ( window.screen.width <= 600 ) {
		jQuery('.fo_tab_col_1').attr('style','width:calc(100% - 21px);');
		if ( jQuery('.fo_tab_col_2').attr('fo_show') == 'hide' ) {
			jQuery('.fo_tab_col_2').show();
			jQuery('.fo_tab_col_2').attr('fo_show','show');
			//jQuery('.fo_tab_col_1').attr('style','width:calc(55% - 21px);');
		} else{
			jQuery('.fo_tab_col_2').hide();
			jQuery('.fo_tab_col_2').attr('fo_show','hide');
			//jQuery('.fo_tab_col_1').attr('style','width:calc(65% - 21px);');
		}
	} else{

	}
}

















function FO_list_view_sel(input){
	jQuery('.foProdCard').attr('foview',jQuery(input).val());
}
