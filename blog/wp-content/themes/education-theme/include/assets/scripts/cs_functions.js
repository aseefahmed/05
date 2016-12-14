var contheight;

// hide page section

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



function _delIcon(id){

	var	delId	= '#cs_infobox_'+id;

	jQuery(""+delId+ " .cs-search-icon-hidden").val('');

	jQuery(""+delId+ " .lead i").attr('class', '');

	jQuery(""+delId+ " .lead i").addClass('picker-target');

	jQuery(""+delId+ " .drop_icon_box").hide();

	jQuery(""+delId+ " .dp_icon").val('Choose Icon');

	jQuery(""+delId+ " .choose_icon_box").show();

	jQuery(""+delId+ " #cs-icon-wrap").removeClass('hideicon');

}

					

function del_media(id) {

	var $ = jQuery;

	jQuery('#' + id + '_box').hide();

	jQuery('#' + id).val('');

}



function addtrack(id) {

	var $ = jQuery;

	contheight = $('.page-opts').height();

	//var widthvr = $('.page-opts').outerWidth(true);

	var popd = $("#" + id).height();

	$("#" + id).css("top", popd);

	$("#" + id).css("display", "block");

	$(".poped-up").css("height", popd);

	$(".page-opts").css("height", popd);

	$("#" + id).animate({

		top: 0,

	}, 500, function() {

		// Animation complete.

	});

	/*$.scrollTo('#normal-sortables', 800, {

		easing: 'swing'

	});*/

};



function closetrack(id) {

	var $ = jQuery;

	$(".page-opts").css("height", "auto");

	//var widthvr = $('.page-opts').outerHeight();

	$("#" + id).animate({

		top: contheight + 100,

	}, 500, function() {

		// Animation complete.

	});

	$("#" + id).hide(500).delay(500);

	$.scrollTo('#normal-sortables', 800, {

		easing: 'swing'

	});

};



var counter_track = 0;

function add_attendor_to_list(admin_url, theme_url) {

	counter_track++;

 	var dataString = 'counter_track=' + counter_track +

		'&var_cp_attendor=' + jQuery("#var_cp_attendor").val() +

		'&var_cp_transaction_id=' + jQuery("#var_cp_transaction_id").val() +

		'&var_cp_ticket_quantity=' + jQuery("#var_cp_ticket_quantity").val() +

		'&action=add_attendor_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_tracks").append(response);

			jQuery("#loading").html("");

			closepopedup('add_ingrediant');

			jQuery("#var_cp_attendor").val("Title");



		}

	});

	//return false;

}







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



function update_port_other(id) {

	var val;

	val = jQuery('#port_other_info_title' + id).val();

	jQuery('#port-title' + id).html(val);

}



function update_title(id) {

	var val;

	val = jQuery('#address_name' + id).val();

	jQuery('#address_name' + id).html(val);

}



function update_attendor(id) {

	var val;

	val = jQuery('#var_cp_attendor' + id).val();

	jQuery('#var_cp_attendor' + id).html(val);

}



function gll_search_map() {

	var vals;

	vals = jQuery('#loc_address').val();

	vals = vals + ", " + jQuery('#loc_city').val();

	vals = vals + ", " + jQuery('#loc_postcode').val();

	vals = vals + ", " + jQuery('#loc_region').val();

	vals = vals + ", " + jQuery('#loc_country').val();

	jQuery('.gllpSearchField').val(vals);

}



function hide_custom_color_scheme(id) {

	if (id == "custom") {

		jQuery("#cs_color_scheme").slideDown("slow");

	} else jQuery("#cs_color_scheme").slideUp("slow");

}



function remove_image(id) {

	var $ = jQuery;

	$('#' + id).val('');

	$('#' + id + '_img_div').hide();

	//$('#'+id+'_div').attr('src', '');

}



function track_toggle(id) {

	title = jQuery('#album_track_title' + id).val();

	jQuery('#album-title' + id).html(title);

	jQuery('#edit_track_form' + id).toggle("slow");

}



function tab_close() {

	jQuery(".form-msgs").slideUp("slow");

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



function cs_div_remove(id) {

	jQuery("#" + id).remove();

}



function cs_toggle(id) {

	jQuery("#" + id).slideToggle("slow");

}



function toggle_with_value(id, value) {

	if (value == 0) jQuery("#" + id).hide("slow");

	else jQuery("#" + id).show("slow");

}



function cs_toggle_tog(id) {

	jQuery("#" + id).toggle();

}



function cs_toggle_menu_filterable(id, value) {

	if (value == "menu-list-filterable") {

		jQuery("#" + id).hide();

	} else {

		jQuery("#" + id).show();

	}

}



function cs_toggle_height(value, id) {

	var $ = jQuery;

	if (value == "Post Slider") {

		jQuery("#post_slider" + id).show();

		jQuery("#choose_slider" + id).hide();

		jQuery("#layer_slider" + id).hide();

		jQuery("#show_post" + id).show();

	} else if (value == "Flex Slider") {

		jQuery("#choose_slider" + id).show();

		jQuery("#layer_slider" + id).hide();

		jQuery("#post_slider" + id).hide();

		jQuery("#show_post" + id).hide();

	} else if (value == "Custom Slider") {

		jQuery("#layer_slider" + id).show();

		jQuery("#choose_slider" + id).hide();

		jQuery("#post_slider" + id).hide();

		jQuery("#show_post" + id).hide();

	} else {

		jQuery("#" + id).removeClass("no-display");

		jQuery("#post_slider" + id).show();

		jQuery("#choose_slider" + id).hide();

		jQuery("#layer_slider" + id).hide();

		jQuery("#show_post" + id).hide();

	}

}







function cs_toggle_list(value, id) {

	var $ = jQuery;



	if (value == "custom_icon") {

		jQuery("#" + id).addClass("no-display");

		jQuery("#cs_list_icon").show();

	} else {

		jQuery("#" + id).removeClass("no-display");

		jQuery("#cs_list_icon").hide();

	}

}



/* -- Fancy Heading Icon List Show Hide Start --*/

function cs_toggle_headingicon(value, id) {

	var $ = jQuery;

	if (value == "center" || value == "left") {

		jQuery("#select_heading_icon" + id).show();

	} else {

		jQuery("#select_heading_icon" + id).hide();

	}

}



/* -- Fancy Heading Icon List Show Hide End --*/

/* -- Alert Messages Show Hide Start --*/

function cs_toggle_alerts(value, id) {

	var $ = jQuery;

	var cs_message_style	= jQuery("#cs_message_style"+id).val();

	if (value == "alert") {

		jQuery("#fancy_button"+id).hide();

		var cs_message_type = jQuery("#cs_alert_style" + id).val()

		

		if (cs_message_type == 'threed_messagebox') {

			jQuery("#cs_style_type" + id).show();

			jQuery("#fancy_active" + id).hide();

		}



	} else {

		jQuery("#cs_alerts_style" + id).hide();

	}



	if (value == "message") {

		jQuery("#cs_style_type" + id).hide();

		jQuery("#fancy_active" + id).show();

		jQuery("#cs_message_style_div" + id).show();

		

		if (cs_message_style == 'btn_style'){

			jQuery("#fancy_button"+id).show();

		} else{

			jQuery("#fancy_button"+id).hide();

		}

		

	} else {

		jQuery("#cs_message_style_div" + id).hide();

	}

}

/* -- Alert Messages Show Hide End --*/



/* -- Alert Messages Show Hide Start --*/



function cs_toggle_fancyalert(value, id) {

	var $ = jQuery;

	var cs_message_type = jQuery("#cs_message_type" + id).val()



	if (value == "threed_messagebox" && cs_message_type == 'alert') {

		jQuery("#cs_style_type" + id).show();

		jQuery("#fancy_active" + id).hide();

	} else {

		jQuery("#cs_style_type" + id).hide();

		jQuery("#fancy_active" + id).show();

	}

}

/* -- Alert Messages Show Hide End --*/

/* -- Alert Messages Show Hide Start --*/



function cs_toggle_fancybutton(value, id) {

	var $ = jQuery;

	if (value == "btn_style") {

		jQuery("#fancy_button"+id).show();

	} else {

		jQuery("#fancy_button"+id).hide();

	}

}

/* -- Alert Messages Show Hide End --*/





/* -- Alert Messages Show Hide Start --*/



function toggle_event_organizer(value) {

	var $ = jQuery;

	if ( jQuery(this).is(":checked") ){

		alert('on');

	}else{

		alert('off');

	}

	if (value == "btn_style") {

		jQuery("#fancy_button"+id).show();

	} else {

		jQuery("#fancy_button"+id).hide();

	}

}

/* -- Alert Messages Show Hide End --*/





/* -- Counter Image Show Hide Start --*/



function cs_counter_image(value, id, object) {

	var $ = jQuery;
	if (value == "image") {
		jQuery("#selected_image_type"+id).show();
		jQuery("#selected_icon_type"+id).hide();
	} else if (value == "icon") {
		jQuery("#selected_image_type"+id).hide();
		jQuery("#selected_icon_type"+id).show();
	}
}

/* -- Counter Image Show Hide End --*/



/* -- Pricetable Title Show Hide Start --*/



function cs_pricetable_style_vlaue(value, id) {

	var $ = jQuery;

	if (value == "classic") {

		jQuery("#pricetbale-title"+id).hide();

	} else {

		jQuery("#pricetbale-title"+id).show();

	}

}



function show_sidebar(id, random_id) {

	var $ = jQuery;

	jQuery('input[class="radio_cs_sidebar"]').click(function() {

		jQuery(this).parent().parent().find(".check-list").removeClass("check-list");

		jQuery(this).siblings("label").children("#check-list").addClass("check-list");

	});

	var randomeID = "#" + random_id;

	if ((id == 'left') || (id == 'right')) {

		$(randomeID + "_sidebar_right,"+randomeID+"_sidebar_left").hide();

		$(randomeID+"_sidebar_"+id).show();

	} else if ((id == 'both') || (id == 'none'))  {

		$(randomeID + "_sidebar_right,"+randomeID+"_sidebar_left").hide();

	} 

}





function show_sidebar_page(id) {

	var $ = jQuery;

	jQuery('input[name="cs_page_layout"]').live('click', function() {

		jQuery(this).parent().parent().find(".check-list").removeClass("check-list");

		jQuery(this).siblings("label").children("#check-list").addClass("check-list");

	});

	if ((id == 'left') || (id == 'right') ) {

		$("#sidebar_right,#sidebar_left").hide();

		$("#sidebar_"+id).show();

	}  else if (id == 'both') {

		$("#sidebar_left,#sidebar_right").show();

	} else if (id == 'none') {

		$("#sidebar_left,#sidebar_right").hide();

	}

}
 
function select_pattern() {

	var $ = jQuery;

	jQuery('input[name="pattern_img"]').change(function() {

		jQuery(this).parent().parent().find(".check-list").removeClass("check-list");

		jQuery(this).siblings("label").children("#check-list").addClass("check-list");

	});

}





function cs_toggle_gal(id, counter) {

	if (id == 0) {

		jQuery("#link_url" + counter).hide();

		jQuery("#video_code" + counter).hide();

	} else if (id == 1) {

		jQuery("#link_url" + counter).hide();

		jQuery("#video_code" + counter).show();

	} else if (id == 2) {

		jQuery("#link_url" + counter).show();

		jQuery("#video_code" + counter).hide();

	}

}





function map_contactus_element(id, counter) {

	if (id == "contact us") {

		jQuery("#map_contactustext" + counter).show();

	} else jQuery("#map_contactustext" + counter).hide();

}



function blog_toggle(id, counter) {

	if (id == "blog-carousel-view") {

		jQuery("#Blog-listing" + counter).hide();

	} else {

		jQuery("#Blog-listing" + counter).show();

	}

}



function event_toggle(id, counter) {





	if (id == "event-timeline") {

		jQuery("#event-lising" + counter).show();

		jQuery("#featured_timeline_event" + counter).show();

	} else if (id == "event-calendarview") {



		jQuery("#featured_timeline_event" + counter).hide();

		jQuery("#event-lising" + counter).hide();



	} else {

		jQuery("#featured_timeline_event" + counter).hide();

		jQuery("#event-lising" + counter).show();



	}





}

var counter = 0;



function delete_this(id) {

	jQuery('#' + id).remove();

	jQuery('#' + id + '_del').remove();

	count_widget--;

	if (count_widget < 1) jQuery("#add_page_builder_item").addClass("hasclass");

}



var Data = [{

	"Class": "column_100",	"title": "100",	"element": ["course_search","course","gallery", "slider", "blog","event", "team", "column", "accordions", "team", "client", "contact", "column", "divider", "message_box",'image', "image_frame", "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "prayer", "advance_search", "parallax","table","call_to_action","flex_column","courses_categories","clients","spacer","heading","testimonials","infobox","promobox","offerslider","audio","icons","contactus",'faq',"page_element","contentslider","highlight","list","members","piecharts","progressbars","register","tweets","tooltip","mesage","toggle"]}, 

	{"Class": "column_75","title": "75",	"element": ["course_search","course","gallery", "slider", "blog", "event", "team", "column", "accordions", "team", "client", "contact", "column", "divider", "message_box", "image_frame",'image', "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "advance_search", "prayer","table","flex_column","courses_categories","clients","spacer","heading","testimonials","infobox","promobox","offerslider","audio","icons","contactus",'faq',"page_element","contentslider","highlight","list","members","piecharts","progressbars","register","tweets","tooltip","mesage","toggle"]}, 
	{"Class": "column_67","title": "67","element": ["course_search","course","gallery", "slider", "blog", "event", "team", "column", "accordions", "team", "client", "contact", "divider", "message_box",'image', "image_frame", "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "advance_search", "prayer", "pointtable","table","flex_column","courses_categories","clients","spacer","heading","testimonials","testimonials","infobox","promobox","offerslider","audio","icons","contactus",'faq',"page_element","contentslider","highlight","list","members","piecharts","progressbars","register","tweets","tooltip","mesage","toggle"]}, 
	{"Class": "column_50","title": "50","element": ["course_search","course","gallery", "slider", "blog", "event", "team", "column", "services", "accordions", "team", "client", "contact", "column", "divider", "message_box", "image_frame",'image', "map", "video", "quote", "dropcap", "pricetable", "services", "tabs", "accordion", "advance_search", "prayer","piechart","table","flex_column","courses_categories","clients","spacer","heading","testimonials","infobox","promobox","offerslider","audio","icons","contactus",'faq',"page_element","contentslider","highlight","list","members","piecharts","progressbars","register","tweets","tooltip","mesage","toggle"]},
	{"Class": "column_33","title": "33","element": ["course_search","gallery", "slider", "event", "team", "column", "accordions", "message_box",'image', "fixtures", "map", "video", "quote", "dropcap", "pricetable", "services", "tabs", "accordion", "prayer", "pointtable","flex_column","courses_categories","spacer","heading","testimonials","infobox","promobox","audio","icons","contactus","highlight","list","piecharts","tweets","tooltip","mesage","progressbars","toggle"]}, 
	{"Class": "column_25","title": "25","element": ["course_search","column", "divider", "message_box", "image_frame", "map", "video", "quote", "dropcap", "pricetable", "services", "pastor",'services','counter',"flex_column","courses_categories","spacer","heading","testimonials","infobox","promobox","audio","icons","contactus","highlight","list","piecharts","tweets","tooltip","mesage","progressbars","toggle"]}, ];



var DataElement = [{

	"ClassName": "col_width_full",

	"element": ["gallery", "slider", "blog", "event", "contact", "parallax"]

}];



function show_popup(id, Classname) {

	jQuery('.composer-' + id).show();

	var $ = jQuery;

	var itemmain = $('.composer-' + id);

	$("#add_page_builder_item > div").css({

		"transition": "none",

		"-moz-transition": "none",

		"-webkit-transition": "none",

		"-o-transition": "none",

		"-ms-transition": "none"

	});

	itemmain.css({

		"padding": 0

	});

	itemmain.parent('.column').css({

		"width": "100%"

	});

	var showdiv = itemmain.parents(".column");

	$(".column,.column-in,.page-builder,.elementhidden").not(showdiv).show();

	itemmain.slideDown(600);

	$('html, body').animate({

		scrollTop: itemmain.offset().top - 50

	}, 600);



}





function cs_to_restore_default(admin_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("You current theme options will be replaced with the default theme activation options.");

	if (var_confirm == true) {

		var dataString = 'action=theme_option_restore_default';

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			success: function(response) {

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(response);

				jQuery(".loading_div").hide();

				var loc = window.location;

				var url = admin_url + "/themes.php?page=cs_theme_options";

				window.location.reload();

				slideout();

			}

		});

	}

	//return false;

}



function cs_to_backup(admin_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("Are you sure! you want to take your current theme option backup?");

	if (var_confirm == true) {

		var dataString = 'action=theme_option_backup';

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			success: function(response) {

				parts = response.split("@");

				jQuery("#last_backup_taken").html(parts[1]);

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(parts[0]);

				jQuery(".loading_div").hide();

				window.location.reload();

				slideout();

			}

		});

	}

	//return false;

}



function cs_to_backup_restore(admin_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("Are you sure! you want to replace your current theme options with your last backup?");

	if (var_confirm == true) {

		var dataString = 'action=theme_option_backup_restore';

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			success: function(response) {

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(response);

				jQuery(".loading_div").hide();

				window.location.reload();

				slideout();

			}

		});

	}

	//return false;

}



function cs_to_import_export(home_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("Are you sure! you want to import this theme options?");

	if (var_confirm == true) {

		var theme_option_data = jQuery("#theme_option_data").val();

		var dataString = 'action=theme_option_import_export&theme_option_data=' + theme_option_data;

		jQuery.ajax({

			type: "POST",

			url: home_url + "/wp-admin/admin-ajax.php",

			data: dataString,

			success: function(response) {

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(response);

				jQuery(".loading_div").hide();

				window.location.reload();

				slideout();

			}

		});

		//return false;

	}

}

 



var counter_subject = 0;



function cs_add_item_to_list(home_url, theme_url) {

	counter_subject++;

	var dataString = 'counter_subject=' + counter_subject +

		'&subject_title=' + jQuery("#subject_title_dummy").val() +

	'&rating_value=' + jQuery("#rating_value").val() +

		'&action=cs_add_item_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: home_url + "/wp-admin/admin-ajax.php",

		data: dataString,

		success: function(response) {

			jQuery("#total_tracks").append(response);

			jQuery("#loading").html("");

			closepopedup('add_item');

			jQuery("#subject_title_dummy").val("Item Title");



		}

	});

	//return false;

}



var counter_port_project = 0;

var count_port_project_js = 0;



function cs_add_port_project(home_url, theme_url) {

	counter_port_project++;

	count_port_project_js++;

	if (count_port_project_js > 0) jQuery("#port_project_header").show("");

	var dataString = 'counter_port_project=' + counter_port_project +

		'&port_other_info_title=' + jQuery("#port_other_info_title_dummy").val() +

		'&port_other_info_desc=' + jQuery("#port_other_info_desc").val() +

		'&port_other_info_icon=' + jQuery("#port_other_info_icon").val() +

		'&action=cs_add_port_project';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: home_url + "/wp-admin/admin-ajax.php",

		data: dataString,

		success: function(response) {

			jQuery("#port_other_info_title_dummy").val("");

			jQuery("#port_other_info_desc").val("");

			jQuery("#port_other_info_icon").val("");

			jQuery("#total_port_project").append(response);

			jQuery("#loading").html("");

			closepopedup('add_port_other');

		}

	});

	//return false;

}

var _commonshortcode = (function(id) {

	var mainConitem = jQuery("#" + id)

	var totalItemCon = mainConitem.find(".cs-wrapp-clone").size();

	mainConitem.find(".fieldCounter").val(totalItemCon);

	mainConitem.sortable({

		cancel: '.cs-clone-append .form-elements,.cs-disable-true',

		placeholder: "ui-state-highlight"

	});



});

var counter_ingredient = 0;

var html_popup = "<div id='confirmOverlay' style='display:block'> \
								<div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
								<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
								<div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>";
// deleting the accordion start

jQuery("a.deleteit_node").live('click', function() {

	var mainConitem = jQuery(this).parents(".cs-wrapp-tab-box");

	jQuery(this).parent().append(html_popup);

	jQuery(this).parents(".cs-wrapp-clone").addClass("warning");

	jQuery(".confirm-yes").click(function() {

		var totalItemCon = mainConitem.find(".cs-wrapp-clone").size();

		var totalItems = jQuery(".cs-wrapp-tab-box .fieldCounter").val();

		mainConitem.find(".fieldCounter").val(totalItems - 1);

		jQuery(this).parents(".cs-wrapp-clone").fadeOut(400, function() {

			jQuery(this).remove();

		});



		jQuery("#confirmOverlay").remove();

	});



	jQuery(".confirm-no").click(function() {

		jQuery(".cs-wrapp-clone").removeClass("warning");

		jQuery("#confirmOverlay").remove();

	});

	return false;

});



//page Section items delete start

jQuery(".btndeleteitsection").live("click", function() {

	jQuery(this).parents(".parentdeletesection").addClass("warning");

	jQuery(this).parent().append(html_popup);



	jQuery(".confirm-yes").click(function() {

		jQuery(this).parents(".parentdeletesection").fadeOut(400, function() {

			jQuery(this).remove();

		});

		jQuery("#confirmOverlay").remove();

		count_widget--;

		if (count_widget == 0) jQuery("#add_page_builder_item").removeClass("hasclass");

	});

	jQuery(".confirm-no").click(function() {

		jQuery(this).parents(".parentdeletesection").removeClass("warning");

		jQuery("#confirmOverlay").remove();

	});

	return false;

});





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





// layer slider show / hide



function home_slider_toggle(id) {

	if (id == "") {

		jQuery("#flex_sliders, #custom_slider").hide();

	} else if (id == "custom") {

		jQuery("#flex_sliders").hide();

		jQuery("#custom_slider").show();

		jQuery("#post_sliders").hide();

	} else if (id == "post_slider") {

		jQuery("#flex_sliders").hide();

		jQuery("#custom_slider").hide();

		jQuery("#post_sliders").show();

	} else {

		jQuery("#custom_slider").hide();

		jQuery("#post_sliders").hide();

		jQuery("#flex_sliders").show();

	}

}

// related title on/off start



function related_title_toggle_inside_post(id) {

	if (id.checked == true) {

		jQuery("#related_post").show();

	} else {

		jQuery("#related_post").hide();

	}

}

// realated title on/off end





// adding social network start



function social_icon_del(id) {

	jQuery("#del_" + id).remove();

	jQuery("#" + id).remove();

}



var counter_social_network = 0;



/*function cs_add_social_icon(admin_url) {

	counter_social_network++;

	var social_net_icon_path = jQuery("#social_net_icon_path_input").val();

	var social_net_awesome = jQuery("#social_net_awesome_input").val();

	var social_net_color_input = jQuery("#social_net_color_input").val();

	var social_net_url = jQuery("#social_net_url_input").val();

	var social_net_tooltip = jQuery("#social_net_tooltip_input").val();

	var social_font_awesome_color = jQuery("#social_font_awesome_color").val();

	

	if (social_net_url != "" && (social_net_icon_path != "" || social_net_awesome != "")) {

		var dataString = 'social_net_icon_path=' + social_net_icon_path +

			'&social_net_awesome=' + social_net_awesome +

			'&social_net_color_input=' + social_net_color_input +

			'&social_net_url=' + social_net_url +

			'&social_net_tooltip=' + social_net_tooltip +

			'&counter_social_network=' + counter_social_network +

			'&social_font_awesome_color=' + social_font_awesome_color +

			'&action=add_social_icon';

		//jQuery("#loading").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			success: function(response) {

				jQuery("#social_network_area").append(response);

				jQuery("#social_net_icon_path_input").val("");

				jQuery("#social_net_awesome_input").val("");

				jQuery("#social_net_color_input").val("");

				jQuery("#social_net_url_input").val("");

				jQuery("#social_net_tooltip_input").val("");

				jQuery("#social_font_awesome_color").val("");

			}

		});

		//return false;

	}

}

*/

// Team Social icon

var counter_track = 0;



function add_social_to_list(admin_url, theme_url) {

	counter_track++;

	var dataString = 'counter_track=' + counter_track +

		'&var_cp_title=' + jQuery("#var_cp_title").val() +

		'&var_cp_image_url=' + jQuery("#var_cp_image_url").val() +

		'&var_cp_team_text=' + jQuery("#var_cp_team_text").val() +



	'&action=cs_add_social_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url + "/admin-ajax.php",

		data: dataString,

		success: function(response) {

			jQuery("#total_tracks").append(response);

			jQuery("#loading").html("");

			closepopedup('add_track');

			jQuery("#var_cp_title").val("Title");

			jQuery("#var_cp_image_url").val("");

			jQuery("#var_cp_team_text").val("");



		}

	});

	//return false;

}





function cs_payment_method(value) {

	if (value == 'custom') {

		jQuery("#custom_option").show(400);

		jQuery("#paypal_option").hide(400);

	} else if (value == 'paypal') {

		jQuery("#custom_option").hide(400);

		jQuery("#paypal_option").show(400);

	} else {

		jQuery("#custom_option").hide(400);

		jQuery("#paypal_option").hide(400);

	}



}





function cs_to_import_export_option(admin_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("Are you sure! you want to import this theme options?");

	if (var_confirm == true) {

		var theme_option_data = jQuery("#theme_option_data_import").val();

		var dataString = 'action=theme_option_import_export&theme_option_data=' + theme_option_data;

		jQuery.ajaxSetup({

			cache: false

		});

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			cache: false,

			success: function(response) {

				jQuery.ajaxSetup({

					cache: false

				});

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(response);

				jQuery(".loading_div").hide();

				window.location.href = admin_url + "/themes.php?page=cs_theme_options",

				//window.location.reload();

				slideout();

			}

		});

		//return false;

	}

}







function cs_to_restore_default_option(admin_url, theme_url) {

	//jQuery(".loading_div").show('');

	var var_confirm = confirm("You current theme options will be replaced with the default theme activation options.");

	if (var_confirm == true) {

		var dataString = 'action=theme_option_restore_default';

		jQuery.ajax({

			type: "POST",

			url: admin_url + "/admin-ajax.php",

			data: dataString,

			cache: false,

			success: function(response) {

				jQuery.ajaxSetup({

					cache: false

				});

				jQuery(".form-msg").show();

				jQuery(".form-msg").html(response);

				jQuery(".loading_div").hide();

				window.location.href = admin_url + "/themes.php?page=cs_theme_options",

				//window.location.reload();

				slideout();

			}

		});

	}

	//return false;

}



jQuery(document).ready(function() {

	// Map Fix

	jQuery('a[href="#tab-location-settings-cs-events"]').click(function (e){

		var map = jQuery("#cs-map-location-id")[0];

		setTimeout(function(){google.maps.event.trigger(map, 'resize');},400)

     });

	// End here

	jQuery('#wrapper_boxed_layoutoptions1').click(function() {

		var theme_option_layout = jQuery('#wrapper_boxed_layoutoptions1 input[name=layout_option]:checked').val();

		if (theme_option_layout == 'wrapper_boxed') {

			jQuery("#layout-background-theme-options").show();

		} else {

			jQuery("#layout-background-theme-options").hide();

		}

	});

	jQuery('#wrapper_boxed_layoutoptions2').click(function() {

		var theme_option_layout = jQuery('#wrapper_boxed_layoutoptions2 input[name=layout_option]:checked').val();

		if (theme_option_layout == 'wrapper_boxed') {

			jQuery("#layout-background-theme-options").show();

		} else {

			jQuery("#layout-background-theme-options").hide();



		}



	});

});

var counter_faq = 0;

function add_faq_to_list(admin_url, theme_url) {

	counter_faq++;

	var dataString = 'counter_faq=' + counter_faq +

		'&faq_title=' + jQuery("#faq_title").val() +

		'&faq_description=' + jQuery("#faq_description").val() +

		'&action=cs_add_faq_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_faqs").append(response);

			jQuery("#loading").html("");

			removeoverlay('add_faq_title', 'append');

			jQuery("#faq_title").val("Title");

			jQuery("#faq_description").val("");

		}

	});

	return false;

}



var counter_design = 0;

function add_design_to_list(admin_url, theme_url) {

	counter_design++;

	var dataString = 'counter_design=' + counter_design +

		'&design_title=' + jQuery("#design_title").val() +

		'&design_value=' + jQuery("#design_value").val() +

		'&design_section_title=' + jQuery("#design_section_title").val() +

		'&design_post_categories=' + jQuery("#design_post_categories").val() +

		'&design_excerpt_length=' + jQuery("#design_excerpt_length").val() +

		'&design_filterable=' + jQuery("#design_filterable").val() +

		'&design_post_per_page=' + jQuery("#design_post_per_page").val() +

		'&design_pagination=' + jQuery("#design_pagination").val() +

		'&design_post_order=' + jQuery("#design_post_order").val() +

		'&action=cs_add_design_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_designs").append(response);

			jQuery("#loading").html("");

			removeoverlay('add_design_views', 'append');

			jQuery("#design_title").val("Title");

		

		}

	});

	return false;

}

var counter_track = 0;

function cs_add_curriculm_to_list(admin_url, theme_url) {

	counter_track++;

	var dataString = 'counter_track=' + counter_track +

		'&address_name=' + jQuery("#var_cp_course_assignment").val() +

		'&payer_email=' + jQuery("#var_cp_course_certificate").val() +

		'&payment_gross=' + jQuery("#var_cp_course_curriculum").val() +

		'&txn_id=' + jQuery("#txn_id").val() +

		'&payment_date=' + jQuery("#payment_date").val() +

		'&action=add_gradiants_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_tracks").append(response);

			jQuery("#loading").html("");

			removeoverlay('add_faq_title', 'append');

		}

	});

	//return false;

}





function cs_change_answer_type(id) {

	jQuery("#multiple-option").hide();

	jQuery("#one-word-answer").hide();

	jQuery("#true-false").hide();

	jQuery("#large-text").hide();

	jQuery("#" + id).show();



}



// add course subjects





//// Curriculums Upload

/*

function cs_curriculum_toggle(value) {

	if (value == 'Text') {

		jQuery('#var_cp_upload_file').hide(300);

		jQuery('#var_cp_text_file').show(300);

	} else {

		jQuery('#var_cp_upload_file').show(300);

		jQuery('#var_cp_text_file').hide(300);

	}

}

*/



// user assignment submission



function cs_assignments_instructor_remarks(counter, user_id, post_id, admin_url, theme_url) {

	'use strict';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	//var formData = new FormData($(this)[0]);

	var dataString = 'counter=' + counter +

		'&user_id=' + user_id +

		'&post_id=' + post_id +

		'&action=cs_remarksss';

	jQuery.ajax({

		url: admin_url,

		type: 'POST',

		data: dataString,

		async: false,

		success: function(response) {

			jQuery(".modal-content").append(response);



		},

		cache: false,

		contentType: false,

		processData: false

	});







	return false;

}







//===============================================



function cs_slider_element_toggle(id) {
	if (id == 'default_header') {
		jQuery("#subheader-background-image").hide();
		jQuery("#default_header_div").show();
		jQuery("#subheader_custom_slider").hide();
		jQuery("#subheader_map").hide();
		jQuery("#subheader_no_header").hide();
	} else if (id == 'custom_slider') {
		jQuery("#subheader-background-image").hide();
		jQuery("#default_header_div").hide();
		jQuery("#subheader_custom_slider").show();
		jQuery("#subheader_map").hide();
		jQuery("#subheader_no_header").hide();
	} else if (id == 'no-header') {
		jQuery("#subheader-background-image").hide();
		jQuery("#default_header_div").hide();
		jQuery("#subheader_custom_slider").hide();
		jQuery("#subheader_map").hide();
		jQuery("#subheader_no_header").show();
	} else if (id == 'breadcrumb_header') {
		jQuery("#subheader-background-image").show();
		jQuery("#default_header_div").show();
		jQuery("#subheader_custom_slider").hide();
		jQuery("#subheader_map").hide();
		jQuery("#subheader_no_header").hide();
	}else if (id == 'map') {
		jQuery("#subheader-background-image").hide();
		jQuery("#subheader_custom_slider").hide();
		jQuery("#subheader_map").show();
		jQuery("#default_header_div").hide();
		jQuery("#subheader_no_header").hide();
	} else {
		jQuery("#subheader-background-image").hide();
		jQuery("#subheader_custom_slider").hide();
		jQuery("#subheader_map").hide();
		jQuery("#subheader_no_header").hide();
	}

}

function cs_hide_show_toggle(id,div,type) {

	

	if ( type == 'theme_options') {

		if (id == 'default') {

			jQuery("#cs_sh_paddingtop_range").hide();

			jQuery("#cs_sh_paddingbottom_range").hide();

		} else if (id == 'custom') {

			jQuery("#cs_sh_paddingtop_range").show();

			jQuery("#cs_sh_paddingbottom_range").show();

		}

		

	} else {

		if (id == 'default') {

			jQuery("#"+div).hide();

		} else if (id == 'custom') {

			jQuery("#"+div).show();

		}

	}

}

// background options



function cs_background_settings_toggle(id) {



	for (var i = 1; i <= 5; i++) {

		jQuery("#home_v" + i).hide();

	}

	if (id == "no-image") {

		jQuery("#home_v1").show();



	} else if (id == "custom-background-image") {

		jQuery("#home_v3").show();



	} else if (id == "background_video") {

		jQuery("#home_v2").show();



	} else if (id == "background_gallery") {

		jQuery("#home_v5").show();



	} else if (id == "featured-image") {

		jQuery("#home_v4").hide();



	} else if (id == "default-options") {

		jQuery("#home_v4").hide();



	} else {

		jQuery("#home_v4").show();

	}

}







function cs_section_background_settings_toggle(id, rand_no) {



	if (id == "no-image") {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).hide();

	} else if (id == "section-custom-background-image") {

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).hide();

		jQuery(".section-custom-background-image-" + rand_no).show();

	} else if (id == "section-slider") {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).show();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).hide();



	} else if (id == "section-custom-slider") {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).show();

		jQuery(".section-background-video-" + rand_no).hide();



	} else if (id == "section_background_video") {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).show();



	} else {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).hide();

	}

}







function cs_parallax_background_settings_toggle(id, rand_no) {

	if (id == "parallax-custom-background-image") {

		jQuery(".parallax-slider-" + rand_no).hide();

		jQuery(".parallax-custom-slider-" + rand_no).hide();

		jQuery(".parallax-background-video-" + rand_no).hide();

		jQuery(".parallax-custom-background-image-" + rand_no).show();

	} else if (id == "parallax-slider") {

		jQuery(".parallax-custom-background-image-" + rand_no).hide();

		jQuery(".parallax-slider-" + rand_no).show();

		jQuery(".parallax-custom-slider-" + rand_no).hide();

		jQuery(".parallax-background-video-" + rand_no).hide();



	} else if (id == "parallax-custom-slider") {

		jQuery(".parallax-custom-background-image-" + rand_no).hide();

		jQuery(".parallax-slider-" + rand_no).hide();

		jQuery(".parallax-custom-slider-" + rand_no).show();

		jQuery(".parallax-background-video-" + rand_no).hide();



	} else if (id == "parallax_background_video") {

		jQuery(".parallax-custom-background-image-" + rand_no).hide();

		jQuery(".parallax-slider-" + rand_no).hide();

		jQuery(".parallax-custom-slider-" + rand_no).hide();

		jQuery(".parallax-background-video-" + rand_no).show();



	} else {

		jQuery(".section-custom-background-image-" + rand_no).hide();

		jQuery(".section-slider-" + rand_no).hide();

		jQuery(".section-custom-slider-" + rand_no).hide();

		jQuery(".section-background-video-" + rand_no).hide();

	}

}





function home_slider_header_toggle(id) {

	if (id == 'custom_slider') {

		jQuery("#header_custom_image").hide();

		jQuery("#ws_slider_options").hide();

		jQuery("#header_custom_slider").show();

	} else if (id == 'flex_slider') {

		jQuery("#header_custom_image").hide();

		jQuery("#ws_slider_options").show();

		jQuery("#header_custom_slider").hide();

	} else if (id == 'breadcrumbs') {

		jQuery("#header_custom_image").show();

		jQuery("#ws_slider_options").hide();

		jQuery("#header_custom_slider").hide();

	} else {

		jQuery("#header_custom_image").hide();

		jQuery("#ws_slider_options").hide();

		jQuery("#header_custom_slider").hide();

	}



}



var counter_projects = 0;

function add_project_to_list(admin_url, theme_url) {

	counter_projects++;

	var dataString = 'counter_projects=' + counter_projects +

		'&project_title=' + jQuery("#project_title").val() +

		'&project_start_date=' + jQuery("#project_start_date").val() +

		'&project_end_date=' + jQuery("#project_end_date").val() +

		'&project_url=' + jQuery("#project_url").val() +

		'&action=add_project_name_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_project_names").append(response);

			jQuery("#loading").html("");

			removeoverlay('add_project_listings', 'append');

			jQuery("#project_title").val("Title");

		}

	});

	//return false;

}



var counter_sermons = 0;



function add_sermon_to_list(admin_url, theme_url) {

	counter_sermons++;

	var dataString = 'counter_sermons=' + counter_sermons +

		'&sermon_title=' + jQuery("#sermon_title").val() +

		'&sermon_type=' + jQuery("#sermon_type").val() +

		'&sermon_file_url=' + jQuery("#sermon_file_url").val() +

		'&action=add_sermon_name_to_list';

	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery("#total_sermon_names").append(response);

			jQuery("#loading").html("");

			removeoverlay('add_sermon_listings', 'append');

			jQuery("#sermon_title").val("Title");

		}

	});

	//return false;

}



jQuery(document).ready(function($) {

	$('.bg_color').wpColorPicker();

	/*jQuery("#date").datetimepicker({

		format: 'd.m.Y H:i'



	});*/

});



function new_toggle(id) {

	if (id == "Single Image") {

		jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

		jQuery("#post_thumb_image").show();

	} else if (id == "Audio") {

		jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

		jQuery("#post_thumb_audio").show();

	} else if (id == "Video") {

		jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

		jQuery("#post_thumb_video").show();

	} else if (id == "Slider") {

		jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

		jQuery("#post_thumb_slider").show();

	} else if (id == "Map") {

		jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

		jQuery("#post_thumb_map").show();

	} else jQuery("#post_thumb_image, #post_thumb_audio, #post_thumb_video, #post_thumb_slider, #post_thumb_map").hide();

}



function new_toggle_inside_post(id) {

	if (id == "Single Image") {

		jQuery("#inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

		jQuery("#inside_post_thumb_image").show();

	} else if (id == "Audio") {

		jQuery("#inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

		jQuery("#inside_post_thumb_audio").show();

	} else if (id == "Video") {

		jQuery("#inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

		jQuery("#inside_post_thumb_video").show();

	} else if (id == "Slider") {

		jQuery("#inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

		jQuery("#inside_post_thumb_slider").show();

	} else if (id == "Map") {

		jQuery("#inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

		jQuery("#inside_post_thumb_map").show();

	} else jQuery("inside_post_thumb_image, #inside_post_thumb_audio, #inside_post_thumb_video, #inside_post_thumb_slider, #inside_post_thumb_map").hide();

}





function cs_dcp_page_element_view(value, admin_url, theme_url,dcpt_slug,cs_title,cs_listing,cs_filter,cs_time,cs_excerpt,cs_pagination,cs_no_of_post) {

	var dataString = 'view_name=' + value +

	'&dcpt_slug=' + dcpt_slug + 

	'&cs_title=' + cs_title + 

	'&cs_listing=' + cs_listing + 

	'&cs_filter=' + cs_filter + 

	'&cs_time=' + cs_time + 

	'&cs_excerpt=' + cs_excerpt + 

	'&cs_pagination=' + cs_pagination + 

	'&cs_no_of_post=' + cs_no_of_post + 

	'&action=cs_dcp_page_element_ajax_fun';

	jQuery(".loading-option").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");

	jQuery.ajax({

		type: "POST",

		url: admin_url,

		data: dataString,

		success: function(response) {

			jQuery(".loading-option").html('');

			jQuery(".design-elements-options").html(response);

		}

	});

	//return false;

}



function cs_product_select_toggle(){

	var course_paid = jQuery('input:checkbox[name=var_cp_course_paid]').val();

	if(course_paid == 'on'){

		jQuery("#var_cp_course_product").show();

	} else {

		jQuery("#var_cp_course_product").hide();

	}

		

	

}



//

function cs_show_slider(value){

	if(value=='Revolution Slider'){

  		jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').hide();

		jQuery('#cs_default_header_header').show();

		jQuery('#cs_custom_slider_1').show();

	}else if(value=='No sub Header'){

		jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').hide();

		jQuery('#cs_default_header_header').show();

	} else{

		jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').show();

		jQuery('#cs_custom_slider_1').hide();

	}

	

	

}





//theme option font awesome icon social network	

/*

var cs_font_awesome_selection = (function(admin_url, value) {

			id='';

			SuccessLoader()

			//jQuery("#" + id).parents('#cs-widgets-list').removeClass('wide-width');

				var shortcode_counter = 1

				var action = 'cs_font_awesome_selection';

				var newCustomerForm = "action=" + action + '&counter=' + shortcode_counter + '&shortcode_element=shortcode'+ '&id=' + value;

				jQuery.ajax({

					type: "POST",

					url: admin_url,

					data: newCustomerForm,

					success: function(data) {

						

						_fontnamesearch();

						removeoverlay(id, 'widgetitem');

						_createpop(data, "csmedia");

					}

				});



		})

		*/

		

//theme option font awesome icon social network		

function add_font_awesome_icon(name,filter,id){

	if(jQuery('.webfonts-wrapper li').hasClass('active')){

		icon_name = jQuery('.webfonts-wrapper li.active').attr('data-icon-title');

		jQuery('#'+id).val(icon_name);

		removeoverlay(name,filter);

	}

}



jQuery(document).ready(function($){

	$('textarea.header_code_indent').keydown(function(e) {

		if(e.keyCode == 9) {

		  var start = $(this).get(0).selectionStart;

		  $(this).val($(this).val().substring(0, start) + "    " + $(this).val().substring($(this).get(0).selectionEnd));

		  $(this).get(0).selectionStart = $(this).get(0).selectionEnd = start + 4;

		  return false;

		}

	});

});



function _iconSearch() {

	   jQuery('.icp-auto').iconpicker({

			title: 'Choose an Icon',

			selectedCustomClass: 'cs-search-icon-hidden',

			hideOnSelect: true,

			selected: true, // use this value as the current item and ignore the original

			defaultValue: false,

		});			

}

function cs_add_field(id,type){

	var wrapper         = jQuery("#"+id+" .input_fields_wrap"); //Fields wrapper

	var items			= jQuery("#"+id+" .input_fields_wrap > div").length + 1;

	

	var uniqueNum 		= type+'_'+Math.floor( Math.random()*99999 );

	

	var remove = 'javascript:cs_remove_field("'+uniqueNum+'","'+id+'")';

	

	jQuery("#"+id+"  .counter_num").val(items);

	

	jQuery(wrapper).append('<div class="cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content" id="'+uniqueNum+'"><ul class="form-elements bcevent_title"><li class="to-label"><label>Pricing Feature '+items+'</label></li><li class="to-field"><div class="input-sec"><input class="txtfield" type="text" value="" name="pricing_feature[]"></div><div id="price_remove"><a class="remove_field" onclick='+remove+'><i class="fa fa-minus-circle" style="color:#000; font-size:18px"></i></div></a></li></ul></div>'); //add input box

}



function cs_remove_field(id,wrapper){

	var totalItems	= jQuery("#"+wrapper+"  .counter_num").val() - 1;

	jQuery("#"+wrapper+"  .counter_num").val(totalItems);

	jQuery("#"+wrapper+" #"+id+"").remove();

}









jQuery('#tab-location-settings-cs-events').bind('tabsshow', function(event, ui) {

    if (ui.panel.id == "map-tab") {

        resizeMap();

    }

});



// Members 

function cs_members_all_tab(value, counter){

	if(value == 'on'){

		jQuery('#members_all_tab'+counter).show();

	} else {

		jQuery('#members_all_tab'+counter).hide();

	}

}





function openPopup() {

    //document.getElementById('test').style.display = 'block';

   jQuery('#test').fadeIn(300);

}



function close_popup()

{

	jQuery('#test').fadeOut(100);	

}



function del_media(id) {

	var $ = jQuery;

	jQuery('#' + id + '_box').hide();

	jQuery('#' + id).val('');

}







	



 function _createclone(object,id,section,post){



		var _this = object.closest(".column");

		_this.clone().insertAfter(_this);

		//jQuery('.bg_color').wpColorPicker();

		callme();

		jQuery( ".draginner" ) .sortable({

				connectWith: '.draginner',

				handle:'.column-in',

				cancel:'.draginner .poped-up,#confirmOverlay',

				revert:false,

				start: function( event, ui ) {jQuery(ui.item).css({"width":"25%"})},

				receive: function( event, ui ) {callme(); getsorting (ui)},

				placeholder: "ui-state-highlight",

				forcePlaceholderSize:true

		 });

		return false;

  }



	function ajax_shortcode_widget_element(object,admin_url,POSTID,name){

			var wraper	=  object.closest(".column-in") .next();

			var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",

			$elem = jQuery('#cs-widgets-list');

			

			jQuery(wraper).wrap(_structure).delay(100).fadeIn(150);

			var shortcodevalue = object.closest(".column-in") .next().find(".cs-textarea-val").val();

			if(shortcodevalue){

				

				var elementnamevalue = object.closest(".column-in") .next().find(".cs-dcpt-element").val();

				SuccessLoader ();

				//_createpop(wraper, "filterdrag");

				counter++;

				var dcpt_element_data = '';

				if(elementnamevalue){

					var dcpt_element_data = '&element_name=' + elementnamevalue;

				}
				var random_num = Math.floor((Math.random() * 56855367) + 1);
				var newCustomerForm = "action=cs_pb_" + name + '&counter=' + random_num + '&shortcode_element_id=' + encodeURIComponent(shortcodevalue) + '&POSTID=' + POSTID + dcpt_element_data;

				var edit_url = action + counter;

				//_createpop();

				jQuery.ajax({

					type:"POST",

					url: admin_url,

					data: newCustomerForm,

					success:function(data){

					rsponse = jQuery(data);

					var response_html = rsponse.find(".cs-pbwp-content").html();	

					object.closest(".column-in") .next() .find(".pagebuilder-data-load").html(response_html);

					object.closest(".column-in") .next().find(".cs-wiget-element-type").val('form');

					jQuery('.loader').remove();

						jQuery('.bg_color').wpColorPicker(); 

						jQuery('div.cs-drag-slider').each(function() {

						var _this = jQuery(this);

							_this.slider({

								range:'min',

								step: _this.data('slider-step'),

								min: _this.data('slider-min'),

								max: _this.data('slider-max'),

								value: _this.data('slider-value'),

								slide: function (event, ui) {

									jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)

								}

							});

						});

						  jQuery( ".draginner" ) .sortable({

							connectWith: '.draginner',

							handle:'.column-in',

							cancel:'.draginner .poped-up,#confirmOverlay',

							revert:false,

							receive: function( event, ui ) {callme(); getsorting (ui)},

							placeholder: "ui-state-highlight",

							forcePlaceholderSize:true

							

					   });

					}

				});

			}

		}



	

	function _removerlay (object) {

			jQuery("#cs-widgets-list .loader").remove();

				var _elem1 = "<div id='cs-pbwp-outerlay'></div>",

					_elem2 = "<div id='cs-widgets-list'></div>";

				$elem = object.closest('div[class*="cs-wrapp-class-"]') ;

				$elem.unwrap(_elem2);

				$elem.unwrap(_elem1);

				$elem.hide()

		}

	

	function _createpopshort (object) {

			var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",

			$elem = jQuery('#cs-widgets-list');

			var a = object.closest(".column-in").next();

			jQuery(a).wrap(_structure).delay(100).fadeIn(150);

		}

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







	

	// Post xml import

	function cs_post_importer(admin_url){

	

	var dataString ='action=cs_post_importer';

	jQuery('.post-import').html('Please wait <i style="color:#7ad03a;" class="fa fa-circle-o-notch fa-spin"></i>');

			

			jQuery.ajax({

				type: "POST",

				url: admin_url,

				data: dataString,

				success: function(response) {

					//alert(response);

					jQuery('.post-import').html(response);

					//jQuery("#loading").html("");

				}

			});

}



// Header Options

function cs_header_option(val){

	if(val=='none'){

		jQuery('#cs_rev_slider,#cs_headerbg_image_div').hide();

	}else if(val=='cs_rev_slider'){

				jQuery('#cs_rev_slider').fadeIn();

				jQuery('#cs_headerbg_image_div').hide();

	}else if(val=='cs_bg_image_color'){

				jQuery('#cs_headerbg_image_div').fadeIn();

				jQuery('#cs_rev_slider').hide();

	}

}

	

		