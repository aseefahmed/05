<?php
function cs_dynamic_design_settings(){
	global $post,$cs_xmlObject;
	$design_elemnts = get_post_meta($post->ID, "dcpt_design_settings", true);
	if ( $design_elemnts <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($design_elemnts);
		$designs_settings = $cs_xmlObject->designs_settings;
		$design_section_title = $designs_settings->design_section_title;
		$design_post_listing_type = $designs_settings->design_post_listing_type;
		$design_post_categories = $designs_settings->design_post_categories;
		$design_excerpt_length = $designs_settings->design_excerpt_length;
		$design_filterable = $designs_settings->design_filterable;
		$design_post_per_page = $designs_settings->design_post_per_page;
		$design_pagination = $designs_settings->design_pagination;
		$design_post_order = $designs_settings->design_post_order;
		$design_show_time = $designs_settings->design_show_time;
		$design_default_excerpt_length = $designs_settings->design_default_excerpt_length;
	} else {
		$design_section_title = '';
		$design_post_listing_type = '';
		$design_post_categories = '';
		$design_excerpt_length = '';
		$design_filterable = '';
		$design_post_per_page = '';
		$design_pagination = '';
		$design_post_order = '';
		$design_show_time = '';
		$design_default_excerpt_length = '';
	}
	?>
    <div class="row">
    	<div class="col-md-9">
    	<div class="row">
        	<div class="col-md-12">
            	<input type="hidden" name="dynamic_post_design" value="1" />
                 <div class="boxes tracklists">
                    <script>
                    jQuery(document).ready(function($) {
                        $("#total_faqs").sortable({
                            cancel : 'td div.table-form-elem'
                        });
                    });
                    </script>
                    <div class="opt-head">
                       
                        
                         <h4 style="padding-top:12px;">Design Views</h4>
                        <a href="javascript:_createpop('add_design_views','filter')" class="button">Add Design View</a>
                        <div class="clear"></div>
                    </div>
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;">Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_designs">
                            <?php
                                global $counter_design,$design_title,$design_value,$design_section_title,$design_post_listing_type,$design_post_categories,$design_excerpt_length,$design_default_excerpt_length,$design_show_time,$design_filterable,$design_post_per_page,$design_pagination, $design_post_order;
                                $counter_design = $post->ID;
                                if ( isset($cs_xmlObject)) {
                                    foreach ( $cs_xmlObject->designs as $designs ){
                                         $design_title = $designs->design_title;
                                         $design_value = $designs->design_value;
										 $design_section_title = $designs->design_section_title;
										 $design_post_listing_type = $designs->design_post_listing_type;
										 $design_default_excerpt_length = $designs->design_default_excerpt_length;
										 $design_post_categories = $designs->design_post_categories;
                                         $design_excerpt_length = $designs->design_excerpt_length;
										 $design_filterable = $designs->design_filterable;
										 $design_show_time = $designs->design_show_time;
                                         $design_post_per_page = $designs->design_post_per_page;
										 $design_pagination = $designs->design_pagination;
                                         $design_post_order = $designs->design_post_order;
                                         cs_add_design_to_list();
                                         $counter_design++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <div id="add_design_views" style="display: none;">
                        <div class="cs-heading-area">
                            <h5> <i class="fa fa-plus-circle"></i>
                               <?php _e('Design Settings','LMS');?> 
                            </h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_design_views','append')"> <a><i class="fa fa-times"></i></a>
                            </span>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Title','LMS');?></label></li>
                            <li class="to-field">
                                <input type="text" id="design_title" name="design_title" value="Title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Value','LMS');?></label></li>
                            <li class="to-field">
                                <input type="text" id="design_value" name="design_value" value="title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Section Title','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                            	<select name="design_section_title" id="design_section_title">
                                	<option value="yes" <?php if($design_section_title == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                    <option value="no" <?php if($design_section_title == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Listing Type','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_post_listing_type" id="design_post_listing_type">
                                        <option value="yes" <?php if($design_post_listing_type == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_post_listing_type == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                         <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Categories','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_post_categories" id="design_post_categories">
                                        <option value="yes" <?php if($design_post_categories == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_post_categories == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Default Excerpt Length','LMS');?></label></li>
                            <li class="to-field">
                                <input type="text" id="design_default_excerpt_length" name="design_default_excerpt_length" value="<?php echo esc_attr($design_default_excerpt_length);?>" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Excerpt Length','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_excerpt_length" id="design_excerpt_length">
                                        <option value="yes" <?php if($design_excerpt_length == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_excerpt_length == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post show time','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_show_time" id="design_show_time">
                                        <option value="yes" <?php if($design_show_time == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_show_time == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Filterable','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_filterable" id="design_filterable">
                                        <option value="yes" <?php if($design_filterable == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_filterable == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post No of Posts','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_post_per_page" id="design_post_per_page">
                                        <option value="yes" <?php if($design_post_per_page == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_post_per_page == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Pagination','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_pagination" id="design_pagination">
                                        <option value="yes" <?php if($design_pagination == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_pagination == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Design Post Order','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="select-style">
                                    <select name="design_post_order" id="design_post_order">
                                        <option value="yes" <?php if($design_post_order == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
                                        <option value="no" <?php if($design_post_order == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                         <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="button" value="<?php _e('Add Design to List','LMS');?>" onclick="add_design_to_list('<?php echo esc_js(admin_url('admin-ajax.php'))?>', '<?php echo esc_js(get_template_directory_uri())?>')" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="col-md-3">
	<aside id="cs-pbwp-search-design-setting">
		<div class="cs-search-area">
			<h4><?php _e('Search for','LMS');?></h4>
			<input type="search" placeholder="<?php _e('Enter any keyword','LMS');?>">
		</div>
		<div class="cs-pbwp-content-nav">
			<h4><?php _e('Categories','LMS');?></h4>
			<ul>
				<li><label><input type="checkbox"><?php _e('Select All','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Events','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Campaign / Causes','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Job Portal','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Real Estate','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Business Directory','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Classified Ads','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Course Directory','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Hotels','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Auto Dealer','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Tour Package','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Restaurant','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Coupons','LMS');?></label></li>
				<li><label><input type="checkbox"><?php _e('Portfolio (in Plan)','LMS');?></label></li>
			</ul>
		</div>
	</aside>
</div>
</div>
	<script>
    jQuery(document).ready(function($) {
        $(".pbwp-btnedit") .click(function(event) {
            /* Act on the event */
            $(this).next().slideToggle(300);
            $(this).next().next().slideToggle();
            return false;
        });
        $(".pbwp-design-content") .each(function() {
            var a = $(this).find("input.pbwp-check");
            if ($(a).is(":checked")) {
                $(this).addClass("pbwp-active");
            }
        });
        $(".pbwp-design-content") .click(function() {
            $(this).toggleClass("pbwp-active")
             var checkBoxes = $(this).find("input.pbwp-check");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    
        });
        return false;
    });
    function cs_edit_page_design(design_name,admin_url){
        'use strict';
        var html_values = jQuery(".design-html-code-"+design_name+" textarea").val();
        jQuery(".design-html-code-"+design_name).prepend('<i class="icon-rotate fa fa-spin fa-spinner"></i>');
        //var formData = new FormData($(this)[0]);
        var dataString = 'design_html="' + html_values + '&design_name=' + design_name + '&action=cs_design_element';
         jQuery.ajax({
             url: admin_url,
            type: 'POST',
       //     data: jQuery('#cs-assignments-form').serialize()+'&attachment='fd,
            data: dataString,
            async: false,
    
            success:function(response){
                    jQuery( ".icon-rotate" ).remove();
                    jQuery(".design-html-code-"+design_name).hide();
            }
         });
        return false;
    }
    </script>
<?php
	}
?>