jQuery(document).ready(function($) {
	//$('.bg_color').wpColorPicker();
	/*jQuery("#date").datetimepicker({
		format: 'd.m.Y H:i'

	});*/
});
function cs_toggle(id) {
	jQuery("#" + id).slideToggle("slow");
}

function cs_remove_image(id){
	var $ = jQuery;
	$('#'+id).val('');
	$('#'+id+'_img_div').hide();
	//$('#'+id+'_div').attr('src', '');
}
	
function social_icon_del(id){
	jQuery("#del_"+id).remove();
	jQuery("#"+id).remove();
}

function update_title(id) {
	var val;
	val = jQuery('#address_name' + id).val();
	jQuery('#address_name' + id).html(val);
}


var html_popup = "<div id='confirmOverlay' style='display:block'> \
								<div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
								<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
								<div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>"
								
//page Builder items delete start
jQuery(".btndeleteit").live("click", function() {
	
	jQuery(this).parents(".parentdelete").addClass("warning");
	jQuery(this).parent().append(html_popup);

	jQuery(".confirm-yes").click(function() {
		jQuery(this).parents(".parentdelete").fadeOut(400, function() {
			jQuery(this).remove();
		});
		
		jQuery(this).parents(".parentdelete").each(function(){
			var lengthitem = jQuery(this).parents(".dragarea").find(".parentdelete").size() - 1;
			jQuery(this).parents(".dragarea").find("input.textfld") .val(lengthitem);
		});

		jQuery("#confirmOverlay").remove();
		count_widget--;
		if (count_widget == 0) jQuery("#add_page_builder_item").removeClass("hasclass");
	
	});
	jQuery(".confirm-no").click(function() {
		jQuery(this).parents(".parentdelete").removeClass("warning");
		jQuery("#confirmOverlay").remove();
	});
	
	return false;
});
//page Builder items delete end

function _createpop(data, type) {
	var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
		$elem = jQuery('#cs-widgets-list');
	jQuery('body').addClass("cs-overflow");
	if (type == "csmedia") {
		$elem.append(data);
	}
	if (type == "filter") {
		jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
		jQuery('#' + data).parent().addClass("wide-width");
	}
	if (type == "filterdrag") {
		jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
	}

}

function removeoverlay(id, text) {
	jQuery("#cs-widgets-list .loader").remove();
	var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
		_elem2 = "<div id='cs-widgets-list'></div>";
	$elem = jQuery("#" + id);
	jQuery("#cs-widgets-list").unwrap(_elem1);
	if (text == "append" || text == "filterdrag") {
		$elem.hide().unwrap(_elem2);
	}
	if (text == "widgetitem") {
		$elem.hide().unwrap(_elem2);
		jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
		return false;

	}
	if (text == "ajax-drag") {
		jQuery("#cs-widgets-list").remove();
	}
	jQuery("body").removeClass("cs-overflow");
}

jQuery(".uploadMedia").live('click', function() {
	var $ = jQuery;
	var id = $(this).attr("name");
	var custom_uploader = wp.media({
		title: 'Select File',
		button: {
			text: 'Add File'
		},
		multiple: false
	})
		.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			jQuery('#' + id).val(attachment.url);
			jQuery('#' + id + '_img').attr('src', attachment.url);
			jQuery('#' + id + '_box').show();
		}).open();
		
});
function openpopedup(id) {
	var $ = jQuery;
	$(".elementhidden,.opt-head,.to-table thead,.to-table tr").hide();
	$("#" + id).parents("tr").show();
	$("#" + id).parents("td").css("width", "100%");
	$("#" + id).parents("td").prev().hide();
	$("#" + id).parents("td").find("a.actions").hide();
	$("#" + id).children(".opt-head").show();
	$("#" + id).slideDown();

	$("#" + id).animate({
		top: 0,
	}, 400, function() {
		// Animation complete.
	});
	/*$.scrollTo('#normal-sortables', 800, {
		easing: 'swing'
	});*/
};

function closepopedup(id) {
	var $ = jQuery;
	$("#" + id).slideUp(800);

	$(".to-table tr").css("width", "");
	$(".elementhidden,.opt-head,.option-sec,.to-table thead,.to-table tr,a.actions,.to-table tr td").delay(600).fadeIn(200);

	$.scrollTo('.elementhidden', 800, {
		
	});
};


function gll_search_map() {
	var vals;
	vals = jQuery('#loc_address').val();
	vals = vals + ", " + jQuery('#loc_city').val();
	vals = vals + ", " + jQuery('#loc_postcode').val();
	vals = vals + ", " + jQuery('#loc_region').val();
	vals = vals + ", " + jQuery('#loc_country').val();
	jQuery('.gllpSearchField').val(vals);
}
// Course Product dropdown
function cs_course_product_option(value){
	
	if(value){
		if(value == 'free'){
			jQuery("#var_cp_course_product").hide();
			jQuery("#course_custom_payment_url").hide();
			jQuery("#course_paid_price").hide();
			jQuery("#course_paypal_email").hide();
			jQuery("#woocommerce_plugin_error").hide();	
			jQuery("#course_curriculums_tabs_display").hide();
		} else if(value == 'paid-with-paypal'){
			jQuery("#var_cp_course_product").hide();
			jQuery("#course_custom_payment_url").hide();
			jQuery("#course_curriculums_tabs_display").hide();
			jQuery("#course_paid_price").show();
			jQuery("#course_paypal_email").show();
			jQuery("#woocommerce_plugin_error").hide();		
		} else if(value == 'paid'){
			jQuery("#var_cp_course_product").hide();
			jQuery("#course_custom_payment_url").show();
			jQuery("#course_curriculums_tabs_display").show();
			jQuery("#course_paid_price").show();
			jQuery("#course_paypal_email").hide();	
			jQuery("#woocommerce_plugin_error").hide();	
		} else if(value == 'paid-with-woocommerce'){
			var woocomerce_length = jQuery( "#var_cp_course_product" ).length;
			if(woocomerce_length){
				jQuery("#var_cp_course_product").show();
			} else {
				jQuery("#woocommerce_plugin_error").show();	
			}
			jQuery("#course_paid_price").hide();
			jQuery("#course_curriculums_tabs_display").show();
			jQuery("#course_custom_payment_url").hide();
			jQuery("#course_paypal_email").hide();
		} else {
			jQuery("#var_cp_course_product").hide();
			jQuery("#course_curriculums_tabs_display").hide();
			jQuery("#course_custom_payment_url").hide();
			jQuery("#course_paid_price").hide();
			jQuery("#course_paypal_email").hide();
			jQuery("#woocommerce_plugin_error").hide();	
		}
	}
}

var counter_members = 0;
function add_course_member_to_list(admin_url, theme_url) {
	counter_members++;
	var dataString = 'counter_members=' + counter_members +
		'&course_user_id=' + jQuery("#course_user_id").val() +
		'&course_id=' + jQuery("#course_id").val() +
		'&course_price=' + jQuery("#course_price").val() +
		'&order_id=' + jQuery("#order_id").val() +
		'&register_date=' + jQuery("#register_date").val() +
		'&expiry_date=' + jQuery("#expiry_date").val() +
		'&result=' + jQuery("#result").val() +
		'&remarks=' + jQuery("#remarks").val() +
		'&payment_method_title=' + jQuery("#payment_method_title").val() +
		'&payment_status=' + jQuery("#payment_status").val() +
		'&disable=' + jQuery("#disable").val() +
		'&action=cs_add_course_members_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_course_members").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_course_members', 'append');
			jQuery("#course_user_id").val("");
			jQuery("#course_id").val("");
			jQuery("#course_price").val("");
			jQuery("#order_id").val("");
			jQuery("#register_date").val("");
			jQuery("#expiry_date").val("");
			jQuery("#result").val("");
			jQuery("#remarks").val("");
			jQuery("#payment_status").val("");
			jQuery("#payment_status").val("");
			jQuery("#disable").val("");
		}
	});
	return false;
}

// add course subjects
var counter_subject = 0;
function add_subject_to_list(admin_url, theme_url) {
	counter_subject++;
	var dataString = 'counter_subject=' + counter_subject +
		'&subject_title=' + jQuery("#subject_title_dummy").val() +
		'&action=cs_add_subject_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_tracks").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_track_title', 'append');
			jQuery("#subject_title_dummy").val("Subject Title");
		}
	});
	//return false;
}
var counter_quiz = 0;
function add_quiz_to_list(admin_url, theme_url) {
	counter_quiz++;
	var dataString = 'counter_quiz=' + counter_quiz +
		'&var_cp_course_quiz_list=' + jQuery("#var_cp_course_quiz").val() +
		'&quiz_passing_marks=' + jQuery("#quiz_passing_marks").val() +
		'&quiz_retakes_no=' + jQuery("#quiz_retakes_no").val() +
		'&action=cs_add_quiz_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_tracks").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_track_quiz', 'append');
			jQuery("#var_cp_course_quiz").val("");
		}
	});
	//return false;
}

var counter_assignment = 0;
function add_assignment_to_list(admin_url, theme_url) {
	counter_assignment++;
	var dataString = 'counter_assignment=' + counter_assignment +
		'&var_cp_assignment_title=' + jQuery("#var_cp_assignment_title").val() +
		'&assignment_upload_size=' + jQuery("#assignment_upload_size").val() +
		'&var_cp_assigment_type=' + jQuery("#var_cp_assigment_type").val() +
		'&assignment_passing_marks=' + jQuery("#assignment_passing_marks").val() +
		'&assignment_total_marks=' + jQuery("#assignment_total_marks").val() +
		'&assignment_retakes_no=' + jQuery("#assignment_retakes_no").val() +
		'&action=cs_add_assignment_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_tracks").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_track_assigments', 'append');
			jQuery("#var_cp_course_assignment").val("");
		}
	});
	return false;
}

var counter_curriculum = 0;

function add_curriculum_to_list(admin_url, theme_url) {
	counter_curriculum++;
	var dataString = 'counter_curriculum=' + counter_curriculum +
		'&var_cp_course_curriculum=' + jQuery("#var_cp_course_curriculum").val() +
		'&action=cs_add_curriculum_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_tracks").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_track_curriculums', 'append');
			jQuery("#var_cp_course_curriculum").val("");
		}
	});
	//return false;
}

var counter_certificate = 0;

function add_certificate_to_list(admin_url, theme_url) {
	counter_certificate++;
	var dataString = 'counter_certificate=' + counter_certificate +
		'&var_cp_course_certificate=' + jQuery("#var_cp_course_certificate").val() +
		'&action=cs_add_certificate_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_tracks").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_track_certificate', 'append');
			jQuery("#var_cp_course_certificate").val("");
		}
	});
	//return false;
}
function cs_courses_events_listing_type_func(event_value, var_cp_course_event, admin_url, theme_url) {
	
			var dataString = 'event_type=' + event_value +
			'&var_cp_course_event=' + var_cp_course_event + 
			'&action=cs_event_type_dropdown';
			jQuery("#event_list_dropdown").html("<img src='" + theme_url + "/assets/include/assets/images/ajax_loading.gif' />");
			jQuery.ajax({
				type: "POST",
				url: admin_url,
				data: dataString,
				success: function(response) {
					jQuery("#event_list_dropdown").html(response);
					//jQuery("#loading").html("");
				}
			});
		return false;
	}
//// Curriculums Upload

function cs_curriculum_toggle(value,id) {
	if (value == 'Text') {
		jQuery('#var_cp_file'+id).hide(300);
		jQuery('#var_cp_text_file').show(300);
	} else {
		jQuery('#var_cp_file'+id).show(300);
		jQuery('#var_cp_text_file').hide(300);
	}
}

jQuery('#tab-location-settings-cs-events').bind('tabsshow', function(event, ui) {
    if (ui.panel.id == "map-tab") {
        resizeMap();
    }
});

// Map Fix
jQuery(document).ready(function() {
	jQuery('a[href="#tab-location-settings-cs-events"]').click(function (e){
		var map = jQuery("#cs-map-location-id")[0];
		setTimeout(function(){google.maps.event.trigger(map, 'resize');},400)
	 });
});	



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// certificate signature
function cs_certificate_signature_toggle(value) {
	if (value == 'Text') {
		jQuery('#var_cp_signature_type_image').hide(300);
		jQuery('#var_cp_signature_type_text').show(300);
	} else if (value == 'Image'){
		jQuery('#var_cp_signature_type_image').show(300);
		jQuery('#var_cp_signature_type_text').hide(300);
	}else{
		jQuery('#var_cp_signature_type_image').hide(300);
		jQuery('#var_cp_signature_type_text').hide(300);
		
	}
}
// certificate logo
function cs_certificate_logo_toggle(value) {
	if (value == 'Text') {
		jQuery('#var_cp_signature_logo_image_type').hide(300);
		jQuery('#var_cp_signature_logo_text').show(300);
	} else if (value == 'Image'){
		jQuery('#var_cp_signature_logo_image_type').show(300);
		jQuery('#var_cp_signature_logo_text').hide(300);
	}else{
		jQuery('#var_cp_signature_logo_image_type').hide(300);
		jQuery('#var_cp_signature_logo_text').hide(300);
		
	}
}

function cs_courses_events_listing_type_func(event_value, var_cp_course_event, admin_url, theme_url) {

		var dataString = 'event_type=' + event_value +
		'&var_cp_course_event=' + var_cp_course_event + 
		'&action=cs_event_type_dropdown';
		jQuery("#event_list_dropdown").html("<img src='" + theme_url + "/assets/include/assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type: "POST",
			url: admin_url,
			data: dataString,
			success: function(response) {
				jQuery("#event_list_dropdown").html(response);
				//jQuery("#loading").html("");
			}
		});
	return false;
}

function cs_user_statements_date_value(date_value,url){
	if(date_value){
		window.location = url+'&sort_by='+date_value;
	}
	return false;
}



function cs_badge_save(admin_url, theme_url){
	jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
	
	function newValues() {
	  var serializedValues = jQuery("#bdg_form input,#bdg_form select,#bdg_form input[name!=action]").serialize();
	  return serializedValues;
	}
	var serializedReturn = newValues();
	 jQuery.ajax({
		type:"POST",
		url: admin_url,
		data:serializedReturn, 
		success:function(response){
			
			jQuery(".loading_div").hide();
			jQuery(".form-msg .innermsg").html(response);
			jQuery(".form-msg").show();
			jQuery(".outerwrapp-layer").delay(100).fadeOut(100)
			//window.location.reload(true);
			slideout();
		}
	});
	//return false;
}

function slideout() {
	setTimeout(function() {
		jQuery(".form-msg").slideUp("slow", function() {});
	}, 5000);
}

function slideout_msgs() {
	setTimeout(function() {
		jQuery("#newsletter_mess").slideUp("slow", function() {});
	}, 5000);
}

function cs_course_options_save(admin_url){
	jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
	function newValues() {
	  var serializedValues = jQuery("#course_options_form input,#course_options_form select,#course_options_form input[name!=action]").serialize();
	  return serializedValues;
	}
	var serializedReturn = newValues();
	 jQuery.ajax({
		type:"POST",
		url: admin_url,
		data:serializedReturn, 
		success:function(response){
			jQuery(".loading_div").hide();
			jQuery(".form-msg .innermsg").html(response);
			jQuery(".form-msg").show();
			jQuery(".outerwrapp-layer").delay(100).fadeOut(100)
			//window.location.reload(true);
			slideout();
		}
	});
	return false;
}

// Media upload
jQuery(document).ready(function() {
	var ww = jQuery('#post_id_reference').text();
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor_clone = function(html){
		imgurl = jQuery('a','<p>'+html+'</p>').attr('href');
		jQuery('#'+formfield).val(imgurl);
		tb_remove();
	}
	jQuery('input.uploadfile').click(function() {
		window.send_to_editor=window.send_to_editor_clone;
		formfield = jQuery(this).attr('name');
		tb_show('', 'media-upload.php?post_id=' + ww + '&type=image&TB_iframe=true');
		return false;
	});
});

var counter_badges = 0;
function cs_add_badges(admin_url){
	counter_badges++;
	
	var badges_net_icons = jQuery("#badges_net_icons_input").val();
	var badges_net_icons_short_name = jQuery("#badges_net_icons_short_name_input").val();
	var badges_net_icons_paths = jQuery("#badges_net_icons_paths_input").val();
	if ( badges_net_icons != "" && (badges_net_icons_short_name != "" || badges_net_icons_paths != "" ) ) {
		jQuery(".badge_spiner").show();
		var dataString = 'badges_net_icons=' + badges_net_icons + 
						'&badges_net_icons_short_name=' + badges_net_icons_short_name +
						'&badges_net_icons_paths=' + badges_net_icons_paths +
						'&counter_badges=' + counter_badges +
						'&action=add_badge';
		
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				jQuery(".badge_spiner").hide();
				jQuery("#badges_area").append(response);
				jQuery(".badges-area").show(200);
				jQuery("#badges_net_icons_input,#badges_net_icons_short_name_input,#badges_net_icons_paths_input").val("");
				jQuery("#badges_net_icons_paths_input_box img").attr('src', '');
				jQuery("#badges_net_icons_paths_input_box").hide();
				jQuery(".browse-icon input#badges_net_icons_paths_input").val('Brows');
				
			}
		});
		//return false;
	}
}

function cs_pop_certificate(admin_url, course_id,id,transection_id) {
	counter_subject++;
	var dataString = 'course_id=' + course_id +
		'&id=' + id +
		'&transection_id=' + transection_id +
		'&action=cs_pop_certificate';
		jQuery.ajax({
			type: "POST",
			url: admin_url,
			data: dataString,
			success: function(response) {
				jQuery("#myCertificates-"+id).html('');
				jQuery("#myCertificates-"+id).html(response);
			}
		});
		//return false;
}

