<?php

	//adding columns start
    add_filter('manage_courses_posts_columns', 'course_columns_add');
	function course_columns_add($columns) {
		$columns['category'] =__('Category','LMS');
		$columns['author'] =__('Author','LMS');
		return $columns;
	}
    add_action('manage_courses_posts_custom_column', 'course_columns');
	function course_columns($name) {
		global $post;
		switch ($name) {
			case 'category':
				$categories = get_the_terms( $post->ID, 'course-category' );
					if($categories <> ""){
						$couter_comma = 0;
						foreach ( $categories as $category ) {
							echo $category->name;
							$couter_comma++;
							if ( $couter_comma < count($categories) ) {
								echo ", ";
							}
						}
					}
				break;
			case 'author':
				echo get_the_author();
				break;
		}
	}
	//adding columns end
	if ( ! function_exists( 'cs_course_register' ) ) {
		function cs_course_register() {
			$labels = array(
				'name' =>__('LMS','LMS'),
				'all_items' => __('Courses','LMS'),
				'add_new_item' =>__('Add New Course','LMS'),
				'edit_item' =>__('Edit Course','LMS'),
				'new_item' =>__('New Course Item','LMS'),
				'add_new' =>__('Add New Course','LMS'),
				'view_item' =>__('View Course Item','LMS'),
				'search_items' =>__('Search Course','LMS'),
				'not_found' =>__( 'Nothing found','LMS'),
				'not_found_in_trash' =>__('Nothing found in Trash','LMS'),
				'parent_item_colon' => ''
			);
			$capabilities = array(
				'publish_courses' => 'publish_courses',
				'edit_courses' => 'edit_courses',
				'edit_others_courses' => 'edit_others_courses',
				'delete_courses' => 'delete_courses',
				'delete_others_courses' => 'delete_others_courses',
				'read_private_courses' => 'read_private_courses',
				'edit_courses' => 'edit_courses',
				'delete_courses' => 'delete_courses',
				'read_courses' => 'read_courses'
			);
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => 'dashicons-book',
				'rewrite' => true,
				'capability_type' => 'post',
				//'capabilities' => $capabilities,
				'has_archive' => true,
				'map_meta_cap' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title','editor','thumbnail')
			); 
			register_post_type( 'courses' , $args );
		}
		add_action('init', 'cs_course_register');
	}
		// adding cat start
		  $labels = array(
			'name' =>__('Course Categories','LMS'),
			'search_items' =>__('Search Course Categories','LMS'),
			'edit_item' =>__('Edit Course Category','LMS'),
			'update_item' =>__('Update Course Category','LMS'),
			'add_new_item' =>__('Add New Category','LMS'),
			'menu_name' =>__('Categories','LMS'),
		  ); 	
		  register_taxonomy('course-category',array('courses'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'course-category' ),
		  ));
		// adding cat end
		// adding tag start
		  $labels = array(
			'name' =>__('Course Tags','LMS'),
			'singular_name' => 'course-tag',
			'search_items' =>__('Search Tags','LMS'),
			'popular_items' =>__('Popular Tags','LMS'),
			'all_items' =>__('All Tags','LMS'),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' =>__('Edit Tag','LMS'),
			'update_item' =>__('Update Tag','LMS'),
			'add_new_item' =>__('Add New Tag','LMS'),
			'new_item_name' =>__('New Tag Name','LMS'),
			'separate_items_with_commas' =>__('Separate tags with commas','LMS'),
			'add_or_remove_items' =>__('Add or remove tags','LMS'),
			'choose_from_most_used' =>__('Choose from the most used tags','LMS'),
			'menu_name' => 'Tags',
		  ); 
		  register_taxonomy('course-tag','courses',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'course-tag' ),
		  ));
		// adding tag end

	// adding course meta info start
	add_action( 'add_meta_boxes', 'cs_meta_course_add' );
	function cs_hide_addnew_course_text() {
		global $submenu;
		unset($submenu['edit.php?post_type=courses'][10]);
		if('courses' == get_post_type())
			echo '';
	}
	add_action( 'admin_head', 'cs_hide_addnew_course_text');
	
	function cs_meta_course_add()
	{  
		add_meta_box( 'cs_meta_course', __('Course Options','LMS'), 'cs_meta_course', 'courses', 'normal', 'high' );  
	}
	function cs_meta_course( $post ) {
		global $post,$cs_xmlObject,$cs_theme_options;
		 $cs_theme_options=$cs_theme_options;
		$course_post_id = $post->ID;
		$cs_builtin_seo_fields =$cs_theme_options['cs_builtin_seo_fields'];
		$cs_course = get_post_meta($post->ID, "cs_course", true);
		if ( $cs_course <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_course);
			$var_cp_course_instructor = $cs_xmlObject->var_cp_course_instructor;
			$dynamic_post_course_view = $cs_xmlObject->dynamic_post_course_view;
			$course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
			$var_cp_course_members = $cs_xmlObject->var_cp_course_members;
			if ($var_cp_course_members){
				$var_cp_course_members = explode(",", $var_cp_course_members);
			}
		} else {
			$var_cp_course_instructor = '';
			$dynamic_post_course_view = '';
			$course_subheader_bg_color = '#d35941';
			$var_cp_course_members = '';
			$var_cp_course_members = array();
			if(!isset($cs_xmlObject))
				$cs_xmlObject = new stdClass();
		}
		$var_cp_course_instructor = get_post_meta( $post->ID, 'var_cp_course_instructor', true);
		cs_enqueue_timepicker_script();
		?>		
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/include/assets/scripts/bootstrap_transfer.js"></script> 
		<div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
			<div class="option-sec" style="margin-bottom:0;">
				<div class="opt-conts">
					<div class="elementhidden">
						<div class="tabs vertical">
							<nav class="admin-navigtion">
								<ul id="myTab" class="nav nav-tabs">
									<li class="active"><a href="#tab-general-settings" data-toggle="tab"><i class="fa fa-cog"></i><?php _e('General','LMS');?> </a></li>
									<li><a href="#tab-subheader-options" data-toggle="tab"><i class="fa fa-indent"></i><?php _e('Sub Header','LMS');?>  </a></li>
									<?php if($cs_builtin_seo_fields == 'on'){?>
									<li><a href="#tab-seo-advance-settings" data-toggle="tab"><i class="fa fa-dribbble"></i><?php _e('Seo Options','LMS');?> </a></li>
									<?php }?>
									<li><a href="#tab-course-options" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php _e('Course Options','LMS');?> </a></li>
									<li><a href="#tab-event-options" data-toggle="tab"><i class="fa fa-calendar"></i> <?php _e('Event','LMS');?> </a></li>
									<li><a href="#tab-member-settings" data-toggle="tab"><i class="fa fa-users"></i><?php _e('Members','LMS');?></a></li>
									<li><a href="#tab-curriculm-settings" data-toggle="tab"><i class="fa fa-folder-open"></i><?php _e('curriculum','LMS');?></a></li>
									<li><a href="#tab-faqs" data-toggle="tab"><i class="fa fa-question-circle"></i><?php _e('FAQs','LMS');?></a></li>
							  </ul>
						  </nav>
							<div class="tab-content">
							<div id="tab-subheader-options" class="tab-pane fade">
								<?php cs_subheader_element();?>
							</div>
							<div id="tab-event-options" class="tab-pane fade">
								<?php cs_course_event_element();?>
							</div>
							<div id="tab-general-settings" class="tab-pane fade active in">
								<?php cs_general_settings_element();
									  cs_sidebar_layout_options();
								?>
							</div>
							<div id="tab-course-options" class="tab-pane fade">
								<ul class="form-elements">
									<li class="to-label">
										<label><?php _e('Course Detail Views','LMS');?> </label>
									</li>
									<li class="to-field">
										<div class="input-sec">
											<div class="select-style">
												<select name="dynamic_post_course_view" id="dynamic_post_course_view" >
													<option value="Wide" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'Wide'){echo 'selected="selected"';}?>><?php _e('Wide','LMS');?></option>
													<option value="Fullwidth" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'Fullwidth'){echo 'selected="selected"';}?>><?php _e('Fullwidth','LMS');?></option>
													 <option value="InPost" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'InPost'){echo 'selected="selected"';}?>><?php _e('In Post','LMS');?></option>
												</select>
											</div>
										</div>
									</li>
							   </ul>
							   <?php cs_course_general_settings();?>
							</div>
							<div id="tab-curriculm-settings" class="tab-pane fade">
								<?php cs_curriculm_settings();?>
							</div>
							<div id="tab-member-settings" class="tab-pane fade">
								<ul class="form-elements">
										<li class="to-label"><label><?php _e('Select Instructor','LMS');?></label></li>
										<li class="to-field select-style">
										<?php
											$blogusers = get_users('orderby=nicename&role=instructor');
											echo '<select name="var_cp_course_instructor" id="var_cp_course_instructor">
													<option value="">None</option>';
													  foreach ($blogusers as $user) {?>
													<?php
													if($user->ID=="$var_cp_course_instructor"){
														$selected =' selected="selected"';
													}else{ 
														$selected = '';
													}
													echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
													 ?>
											<?php }
											echo '</select>';
										?>
                                        </li>
									 </ul>
									<?php 
									wp_reset_postdata();
									cs_course_members_section($course_post_id);?>
									 <!--<ul class="form-elements">
										<li class="to-label to-title"><label><?php _e('Select Members','LMS'); ?></label></li>
										<li id="course-members">
											 <script>
												jQuery(function() {
													var t = jQuery('#course-members').bootstrapTransferrr(
														{'target_id': 'multi-select-input-members',
														 'height': '15em',
														 'hilite_selection': false});
													t.populate([
													<?php 
														$blogusers = get_users('orderby=nicename');
														foreach ($blogusers as $user) {
															echo '{value:"'.$user->ID.'", content:"'.$user->display_name.'"},';
														}
													?>
													]);
													t.set_values([
														<?php
															if(is_array($var_cp_course_members) && $var_cp_course_members){
																foreach ($var_cp_course_members as $user) {
																		$cs_user_data = get_userdata((int)$user);
																		echo '"'.$cs_user_data->ID.'",';
																}
															}
														?>
													]);
													//console.log(t.get_values());
												});
											</script> 
										</li>
									</ul>-->
							</div>
							<div id="tab-faqs" class="tab-pane fade">
								<?php 
									global $cs_xmlObject;
									cs_faqs_section();
								?>
							</div>
							<?php if($cs_builtin_seo_fields == 'on'){?>
							<div id="tab-seo-advance-settings" class="tab-pane fade">
								<?php cs_seo_settitngs_element();?>
							</div>
							<?php }?>
						  </div>
						</div>
					  </div>
					</div>
				<input type="hidden" name="course_meta_form" value="1" />
			</div>
		</div>
		<div class="clear"></div>
	<?php 
    }
   //course event Settings
   if ( ! function_exists( 'cs_course_event_element' ) ) {	
  	 function cs_course_event_element(){
			global $cs_xmlObject;
			if(!isset($cs_xmlObject))
				$cs_xmlObject = new stdClass();
			if ( empty($cs_xmlObject->cs_courses_events_listing_type) ) $cs_courses_events_listing_type = "All Events"; else $cs_courses_events_listing_type = $cs_xmlObject->cs_courses_events_listing_type;
			if ( empty($cs_xmlObject->var_cp_course_event) ) $var_cp_course_event_string = $var_cp_course_event = ''; else $var_cp_course_event_string = $var_cp_course_event = $cs_xmlObject->var_cp_course_event;
			if ($var_cp_course_event) {
				$var_cp_course_event = explode(",", $var_cp_course_event);
			}else{
				$var_cp_course_event = array();
			}
			if ( empty($cs_xmlObject->course_event_excerpt_length) ) $course_event_excerpt_length = ""; else $course_event_excerpt_length = $cs_xmlObject->course_event_excerpt_length;
		//course_event_section_display
		?>
        <ul class="form-elements">
          <li class="to-label">
            <label>
              <?php _e('Events Listing Types','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_courses_events_listing_type" class="dropdown">
                  <option <?php if($cs_courses_events_listing_type=="All Events")echo "selected";?>> <?php _e('All Events','LMS'); ?> </option>
                  <option <?php if($cs_courses_events_listing_type=="Upcoming Events")echo "selected";?>> <?php _e('Upcoming Events','LMS'); ?> </option>
                  <option <?php if($cs_courses_events_listing_type=="Past Events")echo "selected";?>> <?php _e('Past Events','LMS'); ?> </option>
                </select>
              </div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
        <li class="to-label"><label><?php _e('Event Excerpt Length','LMS');?></label></li>
        <li class="to-field">
            <div class="input-sec">
            <input type="text" name="course_event_excerpt_length" value="<?php echo htmlspecialchars($course_event_excerpt_length)?>" />
            </div>
        </li>
    </ul>
        <ul class="form-elements" id="event_list_dropdown">
        	<?php 
				date_default_timezone_set('UTC');
				$current_time = strtotime(current_time('m/d/Y H:i', $gmt = 0));
				$meta_compare = '';
				if ( $cs_courses_events_listing_type == "Upcoming Events" ) $meta_compare = ">=";
        		else if ( $cs_courses_events_listing_type == "Past Events" ) $meta_compare = "<";
				$user_meta_key				= '';
				$user_meta_value			= '';
				$meta_value = $current_time;
				$meta_key	  = 'cs_dynamic_event_from_date_time';
				$order	= 'DESC';
				$orderby	= 'meta_value';
				
				
				
				if ( $cs_courses_events_listing_type == "All Events" ) {
					$args = array(
						'posts_per_page'			=> "-1",
						'post_type'					=> 'cs-events',
						'post_status'				=> 'publish',
						'orderby'					=> $orderby,
						'order'						=> $order,
					);
					
				} else {
					$args = array(
						'posts_per_page'			=> "-1",
						'post_type'					=> 'cs-events',
						'post_status'				=> 'publish',
						'meta_key'					=> $meta_key,
						'meta_value'				=> $meta_value,
						'meta_compare'				=> $meta_compare,
						'orderby'					=> $orderby,
						'order'						=> $order,
					);
				}
			
			?>
        
            <li class="to-label"><label><?php _e('Select Event','LMS'); ?></label></li>
            <li id="test">
                 <script>
                    jQuery(function() {
                        var t = jQuery('#test').bootstrapTransfer(
                            {'target_id': 'multi-select-input',
                             'height': '15em',
                             'hilite_selection': false});
                        t.populate([
                             <?php 
                                 $events=get_posts( $args );
                                foreach($events as $event){
                                    $cs_event_id = get_the_ID();
                                    echo '{value:"'.$event->ID.'", content:"'.$event->post_title.'"},';
                                }
                             ?> 
                        ]);
                        t.set_values([
                        <?php
                            if($var_cp_course_event <> ''){
                                foreach($var_cp_course_event as $events){
                                    echo '"'.$events.'",';
                                }
                            }
                        ?>
                        ]);
                        //console.log(t.get_values());
                    });
                </script> 
            </li>
      </ul>
         
    <?php
   }
   }
   //course general Settings
   if ( ! function_exists( 'cs_course_general_settings' ) ) {
   		function cs_course_general_settings(){
		global $cs_xmlObject, $cs_theme_options;
		if(!isset($cs_xmlObject))
			$cs_xmlObject = new stdClass();
		if ( !isset($cs_xmlObject->course_breif_section_display) ){ $cs_xmlObject->course_breif_section_display = "on";}
		if ( !isset($cs_xmlObject->course_reviews_section_display) ){ $cs_xmlObject->course_reviews_section_display = "on";}
		if ( !isset($cs_xmlObject->dynamic_post_faq_display) ){ $cs_xmlObject->dynamic_post_faq_display = "on";}
		if ( !isset($cs_xmlObject->course_curriculm_section_display) ){ $cs_xmlObject->course_curriculm_section_display = "on";}
		if ( !isset($cs_xmlObject->course_members_section_display) ){ $cs_xmlObject->course_members_section_display = "on"; $course_members_section_display = 'on'; }
		if ( !isset($cs_xmlObject->course_events_section_display) ){ $cs_xmlObject->course_events_section_display = "on";}
		if ( empty($cs_xmlObject->course_breif_section_display) ) $course_breif_section_display = ""; else $course_breif_section_display = $cs_xmlObject->course_breif_section_display;
		if ( empty($cs_xmlObject->course_reviews_section_display) ) $course_reviews_section_display = ""; else $course_reviews_section_display = $cs_xmlObject->course_reviews_section_display	;
		if ( empty($cs_xmlObject->dynamic_post_faq_display) ) $dynamic_post_faq_display = ""; else $dynamic_post_faq_display = $cs_xmlObject->dynamic_post_faq_display;
		if ( empty($cs_xmlObject->course_curriculm_section_display) ) $course_curriculm_section_display = ""; else $course_curriculm_section_display = $cs_xmlObject->course_curriculm_section_display;
		if ( empty($cs_xmlObject->course_members_section_display) ) $course_members_section_display = ""; else $course_members_section_display = $cs_xmlObject->course_members_section_display;
		if ( empty($cs_xmlObject->course_events_section_display) ) $course_events_section_display = ""; else $course_events_section_display = $cs_xmlObject->course_events_section_display;
		if ( empty($cs_xmlObject->course_id) ) $course_id = ""; else $course_id = $cs_xmlObject->course_id;
		if ( empty($cs_xmlObject->cs_tabs_style) ) $cs_tabs_style = ""; else $cs_tabs_style = $cs_xmlObject->cs_tabs_style;
		if ( empty($cs_xmlObject->course_pass_marks) ) $course_pass_marks = ""; else $course_pass_marks = $cs_xmlObject->course_pass_marks;
		if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
		if ( empty($cs_xmlObject->course_duration) ) $course_duration = ""; else $course_duration = $cs_xmlObject->course_duration;
		if ( empty($cs_xmlObject->course_subheader_bg_color) ) $course_subheader_bg_color = ""; else $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
		if ( empty($cs_xmlObject->var_cp_course_event) ) $var_cp_course_event = ""; else $var_cp_course_event = $cs_xmlObject->var_cp_course_event;
		if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
		if ( empty($cs_xmlObject->var_cp_course_cds_product) ) $var_cp_course_cds_product = ""; else $var_cp_course_cds_product = $cs_xmlObject->var_cp_course_cds_product;
		if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
		if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
		if ( empty($cs_xmlObject->var_cp_course_cds_product) ) $var_cp_course_cds_product = ""; else $var_cp_course_cds_product = $cs_xmlObject->var_cp_course_cds_product;
		if ( empty($cs_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
		if ( empty($cs_xmlObject->cs_course_badge) ) $cs_course_badge = ""; else $cs_course_badge = $cs_xmlObject->cs_course_badge;
		if ( empty($cs_xmlObject->cs_course_badge_assign) ) $cs_course_badge_assign = ""; else $cs_course_badge_assign = $cs_xmlObject->cs_course_badge_assign;
		if ( empty($cs_xmlObject->cs_course_certificate) ) $cs_course_certificate = ""; else $cs_course_certificate = $cs_xmlObject->cs_course_certificate;
		?>
             <ul class="form-elements">
                <li class="to-label"><label><?php _e('Choose Tabs View','LMS');?></label></li>
                <li class="to-field">
                    <div class="input-sec">
                        <div class="select-style">
                            <select name="cs_tabs_style" class="dropdown">
                                <option <?php if(isset($cs_tabs_style) and $cs_tabs_style=="classic"){echo "selected";}?> value="classic" ><?php _e('Classic','LMS');?></option>
                                <option <?php if(isset($cs_tabs_style) and $cs_tabs_style=="modren"){echo "selected";}?> value="modren" ><?php _e('Modern','LMS');?></option>
                            </select>
                        </div>
                    </div>
                </li>
             </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Course Brief Tab Title','LMS');?></label></li>
                <li class="to-field has_input">
                    <label class="pbwp-checkbox">
                        <input type="hidden" name="course_breif_section_display" value="" />
                        <input type="checkbox" name="course_breif_section_display" value="on" class="myClass" <?php if($course_breif_section_display=='on')echo "checked"?> />
                        <span class="pbwp-box"></span>
                    </label>
                </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('FAQS Tab Title','LMS');?></label>
              </li>
              <li class="to-field has_input">
                <label class="pbwp-checkbox">
                  <input type="hidden" name="dynamic_post_faq_display" value="" />
                  <input type="checkbox" name="dynamic_post_faq_display" value="on" class="myClass" <?php if($dynamic_post_faq_display=='on')echo "checked"?> />
                  <span class="pbwp-box"></span> </label>
              </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Curriculum Tab Title','LMS');?></label></li>
                <li class="to-field has_input">
                    <label class="pbwp-checkbox">
                        <input type="hidden" name="course_curriculm_section_display" value="" />
                        <input type="checkbox" name="course_curriculm_section_display" value="on" class="myClass" <?php if($course_curriculm_section_display=='on')echo "checked"?> />
                        <span class="pbwp-box"></span>
                    </label>
                </li>
            </ul>
            <ul class="form-elements">
            <li class="to-label"><label><?php _e('Event Tab Title','LMS');?></label></li>
            <li class="to-field has_input">
                <label class="pbwp-checkbox">
                	<input type="hidden" name="course_events_section_display" value="" />
                    <input type="checkbox" name="course_events_section_display" value="on" class="myClass" <?php if($course_events_section_display=='on')echo "checked"?> />
                    <span class="pbwp-box"></span>
                </label>
            </li>
        </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Members Tab Title','LMS');?></label></li>
                <li class="to-field has_input">
                    <label class="pbwp-checkbox">
                        <input type="hidden" name="course_members_section_display" value="" />
                        <input type="checkbox" name="course_members_section_display" value="on" class="myClass" <?php if($course_members_section_display=='on')echo "checked"?> />
                        <span class="pbwp-box"></span>
                    </label>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Reviews Tab Title','LMS');?></label></li>
                <li class="to-field has_input">
                    <label class="pbwp-checkbox">
                        <input type="hidden" name="course_reviews_section_display" value="" />
                        <input type="checkbox" name="course_reviews_section_display" value="on" class="myClass" <?php if($course_reviews_section_display=='on')echo "checked"?> />
                        <span class="pbwp-box"></span>
                    </label>
                </li>
            </ul>
            <ul class="form-elements">
            	<?php $badges = isset($cs_theme_options['badges_net_icons']) ? $cs_theme_options['badges_net_icons'] : ''; ?>
                <li class="to-label"><label><?php _e('Badges','LMS');?></label></li>
                <li class="to-field">
                	<div class="select-style">
                        <select name="cs_course_badge" class="dropdown">
                            <option value="" ><?php _e('Select Badge','LMS');?></option>
                            <?php
                            if(isset($badges) and $badges <> ''){
                                foreach($badges as $badge){
                            ?>
                                <option <?php if(isset($cs_course_badge) and $cs_course_badge==$badge){echo "selected";}?>><?php echo $badge; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </li>
               
            </ul>
            <ul class="form-elements">
            <li class="to-label"><label><?php _e('Assign Badge On','LMS');?></label></li>
                <li class="to-field">
                	<div class="select-style">
                        <select name="cs_course_badge_assign" class="dropdown">
                            <option value="expire" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'expire'){echo "selected";}?>><?php _e('Course Expire','LMS');?></option>
                            <option value="purchase" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'purchase'){echo "selected";}?>><?php _e('Course Purchase','LMS');?></option>
                            <option value="completetion" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'completetion'){echo "selected";}?>><?php _e('Successfully Compilation','LMS');?></option>
                        </select>
                   </div>
               </li>
            </ul>
           <?php  if( class_exists( 'cs_lms_badges_certificates' ) ){?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Certificate','LMS');?></label></li>
                <li class="to-field">
                	<div class="select-style">
                        <select name="cs_course_certificate" class="dropdown">
                            <option value="" ><?php _e('Select Certificate','LMS');?></option>
                            <?php
							$args = array('posts_per_page' => "-1", 'post_type' => 'cs-certificates','order' => 'DESC', 'orderby' => 'ID', 'post_status' => 'publish');
							$query = new WP_Query( $args );
							$count_post = $query->post_count;
                            if ( $query->have_posts() ) {  
                                while ( $query->have_posts() ) { $query->the_post();
                            ?>
                                <option value="<?php echo get_the_ID();?>" <?php echo  $cs_course_certificate == get_the_ID() ? 'selected="selected"' : '';?>><?php echo the_title();?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </li>
            </ul>
            <?php }?>
        	<ul class="form-elements">
                <li class="to-label"><label><?php _e('Course Id','LMS');?></label></li>
                <li class="to-field">
                    <div class="input-sec">
                    <input type="text" name="course_id" value="<?php echo htmlspecialchars($course_id)?>" />
                    </div>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Course Passing Marks in %','LMS');?></label></li>
                <li class="to-field">
                    <div class="input-sec">
                    <input type="text" name="course_pass_marks" value="<?php echo htmlspecialchars($course_pass_marks)?>" />
                    </div>
                    
                </li>
            </ul>
           <ul class="form-elements">
                <li class="to-label"><label><?php _e('Short Description','LMS');?></label></li>
                <li class="to-field">
                    <div class="input-sec">
                    <textarea rows="20" cols="40" name="course_short_description" ><?php echo htmlspecialchars($course_short_description)?></textarea>
                    </div>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Course Duration (No of Days)','LMS');?></label></li>
                <li class="to-field">
                    <div class="input-sec">
                     <input type="text" id="course_duration" name="course_duration" value="<?php if($course_duration) echo $course_duration?>" />
                    </div>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Course Paid','LMS');?></label></li>
                <li class="to-field select-style">
                  <select name="var_cp_course_paid" onchange="cs_course_product_option(this.value)">
                        <option value="free" <?php if( $var_cp_course_paid == 'free' ) { echo 'selected';}?>><?php _e('Free Open Course','LMS');?> </option>
                        <option value="registered_user_access" <?php if( $var_cp_course_paid == 'registered_user_access' ) { echo 'selected';}?>><?php _e('Restricted Open Course','LMS');?></option>
                        <option value="paid" <?php if( $var_cp_course_paid == 'paid' ) { echo 'selected';}?>><?php _e('Restricted Course','LMS');?></option>
                  </select>
                </li>
            </ul>
            <?php if(class_exists('Woocommerce')) {?>
            
            <ul class="form-elements" id="var_cp_course_product" <?php if($var_cp_course_paid=='free')echo 'style="display: none;"';?> >
                <li class="to-label"><label><?php _e('Select Product','LMS');?></label></li>
                <li class="to-field">
                <div class="input-sec">
                	<div class="select-style">
                        <select name="var_cp_course_product">
                            <option value=""><?php _e('Select','LMS');?></option>
                            <?php
                                wp_reset_query();
                                $args = array('post_type' => 'product','posts_per_page' => "-1", 'post_status' => 'publish');
                                  $loop = new WP_Query( $args );
                                    while ( $loop->have_posts() ) : $loop->the_post(); 
                                    global $product;
                                    ?>
                                    <option <?php  if ($var_cp_course_product == get_the_id()) { echo 'selected="selected"';}?> value="<?php  echo get_the_id()?>">
                                        <?php the_title();   ?>
                                    </option>
                                    <?php
                                    endwhile;
                                    wp_reset_query();
                            ?>
                        </select>
                    </div>
                    </div>
                </li>
            </ul>
            
            <ul class="form-elements" id="var_cp_course_cds_product">
                <li class="to-label"><label><?php _e('Select Course CDs Product','LMS');?></label></li>
                <li class="to-field">
                <div class="input-sec">
                	<div class="select-style">
                        <select name="var_cp_course_cds_product">
                            <option value=""><?php _e('Select','LMS');?></option>
                            <?php
                                wp_reset_query();
                                $args = array('post_type' => 'product','posts_per_page' => "-1", 'post_status' => 'publish');
                                  $loop = new WP_Query( $args );
                                    while ( $loop->have_posts() ) : $loop->the_post(); 
                                    global $product;
                                    ?>
                                    <option <?php  if ($var_cp_course_cds_product == get_the_id()) { echo 'selected="selected"';}?> value="<?php  echo get_the_id()?>">
                                        <?php the_title();   ?>
                                    </option>
                                    <?php
                                    endwhile;
                                    wp_reset_query();
                            ?>
                        </select>
                    </div>
                    </div>
                </li>
            </ul>
            <?php } ?>
            <ul class="form-elements">
                <li class="to-label">
                    <label><?php _e('Course Color','LMS');?> </label>
                </li>
                <li class="to-field">
                    <div class="input-sec">
                        <input type="text" name="course_subheader_bg_color" class="bg_color" value="<?php echo $course_subheader_bg_color;?>"  />
                    </div>
                </li>
           </ul>
        <?php
		
	}
   }
	//Curriculums Settings
	if ( ! function_exists( 'cs_curriculm_settings' ) ) {
		function cs_curriculm_settings(){
		global $post,$cs_xmlObject;
		$cs_lms = get_option('cs_lms_plugin_activation');	
		if(!isset($cs_xmlObject))
			$cs_xmlObject = new stdClass();
		?>
        <div class="curriculm">
                	<script>
					jQuery(document).ready(function($) {
						$("#total_tracks").sortable({
							cancel : 'td div.poped-up',
						});
					});
					</script>
                 
                    <div class="opt-head">
                        <ul class="form-elements">
                        	<li class="to-label"><label><?php _e('Add Curriculums','LMS');?></label></li>
                            <li class="to-button">
                            	<a href="javascript:_createpop('add_track_title','filter')" class="button"><?php _e('Add Section Title','LMS');?></a>
                                <a href="javascript:_createpop('add_track_curriculums','filter')" class="button"><?php _e('Add Curriculum','LMS');?></a>
                                <?php if(isset($cs_lms) && $cs_lms == 'installed'){?>
                                <a href="javascript:_createpop('add_track_assigments','filter')" class="button"><?php _e('Add Assignment','LMS');?></a>
                                <a href="javascript:_createpop('add_track_quiz','filter')" class="button"><?php _e('Add Quiz','LMS');?></a>
                                <?php }?>
                            </li>
                        </ul>
                    </div>
                    <!--Section Title Start-->
                    <div id="add_track_title" class="poped-up padding-none">
                      <div class="cs-heading-area">
                            <h5> <i class="fa fa-plus-circle"></i>
                                <?php _e('Course Members Settings','LMS');?>
                            </h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_title','append')"> <i class="fa fa-times"></i></span>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Section Title','LMS');?></label></li>
                            <li class="to-field">
                            	<input type="text" id="subject_title_dummy" name="subject_title_dummy" value="Subject Title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                        	<li class="to-label"></li>
                            <li class="to-field">
                            	<input type="button" value="<?php _e('Add Section Title to List','LMS');?>" onclick="add_subject_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />
                            </li>
                        </ul>
                    </div>
                  	<!--Section Title end-->
                    <?php if(isset($cs_lms) && $cs_lms == 'installed'){?>
                    <!--Assignment section Start-->
                    <div id="add_track_assigments" class="poped-up padding-none">
                        <div class="cs-heading-area">
                            <h5> <i class="fa fa-plus-circle"></i>
                                <?php _e('Assignment Settings','LMS');?>
                            </h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_assigments','append')"> <i class="fa fa-times"></i></span>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                          <li class="to-label"><label><?php _e('Assignment Title','LMS');?></label></li>
							<?php 
								echo '<li class="to-field select-style"><select name="var_cp_assignment_title" id="var_cp_assignment_title">
										<option value="">None</option>';
										query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-assignments') );
										while (have_posts() ) : the_post(); ?>
										<?php
											echo '<option value="'.get_the_id().'" >'.get_the_title().'</option>';
										 ?>
								<?php endwhile; wp_reset_query();
								echo '</select></li>';
							 ?>
                        </ul>
                        <!--<ul class="form-elements">
                          <li class="to-label"><label>Assignment Description</label></li>
                          <li class="to-field">
                            <div class="input-sec">
                            	<textarea name="var_cp_assignment_description" id="var_cp_assignment_description"></textarea>
                            </div>
                          </li>
                        </ul>-->
                        <?php $allowed_types = get_allowed_mime_types();?>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Upload File Format','LMS');?></label></li>
                            <li class="to-field">
                                <div class="input-sec">
                                    <select name="var_cp_assigment_type[]" id="var_cp_assigment_type" multiple="multiple" style="min-height:150px;">
                                    	<?php
										foreach($allowed_types as $ext_keys=>$ext_value){
											echo '<option value="'.$ext_value.'">'.$ext_value.'</option>';
										}
										?>
                                    </select>
                                    <p><?php _e('Select the Assignment type in which format user upload his assignment','LMS');?></p>
                                </div>
                            </li>
                         </ul>
                         <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('File Upload Size','LMS');?></label>
                            </li>
                            <li class="to-field">
                            	<div class="input-sec">
                            		<input type="text" id="assignment_upload_size" name="assignment_upload_size" value="1024" />
                                </div>
                            </li>
                          </ul>
                         <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Passing Marks(%)','LMS');?></label>
                            </li>
                            <li class="to-field select-style">
                            	<select name="assignment_passing_marks" id="assignment_passing_marks">
                                	<?php for($i = 1; $i<=100; $i++){?>
                                		<option value="<?php echo $i;?>" <?php if($i == 50){echo 'selected="selected"';}?>><?php echo $i;?></option>
                                    <?php }?>
                                </select>
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Total Marks','LMS');?></label>
                            </li>
                            <li class="to-field">
                            	<div class="input-sec">
                            		<input type="text" id="assignment_total_marks" name="assignment_total_marks" value="100" />
                                </div>
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Extra Retakes','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="input-sec">
                            		<input type="text" id="assignment_retakes_no" name="assignment_retakes_no" value="5" />
                                </div>
 							</li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"></li>
                            <li class="to-field">
                            	<input type="button" value="<?php _e('Add Assignment to List','LMS');?>" onclick="add_assignment_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />
                            </li>
                        </ul>
                    </div>
                    <!--Assignment section end-->
                    
                    <!--Quiz section start-->
                 	<div id="add_track_quiz" class="poped-up padding-none">
                        <div class="cs-heading-area">
                            <h5> <i class="fa fa-plus-circle"></i>
                                <?php _e('Quiz Settings','LMS');?>
                            </h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_quiz','append')"> <i class="fa fa-times"></i></span>
                            <div class="clear"></div>
                        </div>
      
                         <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Select Quiz','LMS'); ?></label></li>
                            <?php 
							//$forums = get_forums(); ?>
                         	<?php 
							echo '<li class="to-field select-style"><select name="var_cp_course_quiz" id="var_cp_course_quiz">
									<option value="">None</option>';
								 	query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'quiz') );
									while (have_posts() ) : the_post(); ?>
									<?php
									
									echo $cs_quiz_id = get_the_id();
							
									if($cs_quiz_id=="$var_cp_course_quiz"){
											$selected =' selected="selected"';
										}else{ 
											$selected = '';
										}
									echo '<option value="'.$cs_quiz_id.'" '.$selected.'>'.get_the_title().'</option>';
									 ?>
	                        <?php endwhile; wp_reset_query();
							echo '</select></li>';
						 ?>
                         </ul>
                         <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Passing Marks(%)','LMS');?></label>
                            </li>
                            <li class="to-field select-style">
                            	<select name="quiz_passing_marks" id="quiz_passing_marks">
                                	<?php for($i = 1; $i<=100; $i++){?>
                                		<option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                </select>
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Extra Retakes','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="input-sec">
                            		<input type="text" id="quiz_retakes_no" name="quiz_retakes_no" value="10" />
                                </div>
 							</li>
                        </ul>
                         <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Select Free/Paid Quiz','LMS');?></label></li>
                            <li class="to-field select-style">
                            	<select name="var_cp_course_quiz_type" id="var_cp_course_quiz_type">
                                	<option value="paid"><?php _e('Paid','LMS');?></option>
                                    <option value="free"><?php _e('Free','LMS');?></option>
                                </select>
 							</li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"></li>
                            <li class="to-field">
                            	<input type="button" value="Add Quiz to List" onclick="add_quiz_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />
                            </li>
                        </ul>
                    </div>
                 	<!--Quiz section end-->
                    <?php }?>
                    <!--Curriculm section start-->
                    <div id="add_track_curriculums" class="poped-up padding-none">
                         <div class="cs-heading-area">
                            <h5> <i class="fa fa-plus-circle"></i>
                              <?php _e('Curriculum Settings','LMS');?> 
                            </h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_curriculums','append')"> <i class="fa fa-times"></i></span>
                            <div class="clear"></div>
                        </div>
                         
                         <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Select Curriculum','LMS'); ?></label></li>
                            <?php 
							//$forums = get_forums(); ?>
                         	<?php 
							echo '<li class="to-field select-style"><select name="var_cp_course_curriculum" id="var_cp_course_curriculum">
									<option value="">None</option>';
								 	query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-curriculums') );
									while (have_posts() ) : the_post(); ?>
									<?php
									
									$cs_course_curriculum = get_the_id();
							
									if($cs_course_curriculum=="$var_cp_course_curriculum"){
											$selected =' selected="selected"';
										}else{ 
											$selected = '';
										}
									echo '<option value="'.$cs_course_curriculum.'" '.$selected.'>'.get_the_title().'</option>';
									 ?>
	                        <?php endwhile; wp_reset_query();
							echo '</select></li>';
						 ?>
                         </ul>
                        <ul class="form-elements">
                            <li class="to-label"></li>
                            <li class="to-field">
                            	<input type="button" value="<?php _e('Add Curriculum to List','LMS'); ?>" onclick="add_curriculum_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />
                            </li>
                        </ul>
                    </div>
                  	<!--Curriculm section end-->
                    
                   	<!--Certificate section start--> 
                    <div id="add_track_certificate" class="poped-up">
                        <div class="opt-head">
                            <h5><?php _e('Certificates Settings','LMS'); ?></h5>
                            <span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_certificate','append')"> <i class="fa fa-times"></i></span>
                            <div class="clear"></div>
                        </div>                        
                        <ul class="form-elements">
                        <li class="to-label select-style"><label><?php _e('Select Certificate','LMS'); ?></label></li>
                            <?php 
							//$forums = get_forums(); ?>
                         	<?php 
							echo '<select name="var_cp_course_certificate" id="var_cp_course_certificate">
									<option value="">None</option>';
								 	query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-certificates') );
									while (have_posts() ) : the_post(); ?>
									<?php
									
									$cs_certificate_id = get_the_id();
							
									if($cs_certificate_id=="$var_cp_course_certificate"){
											$selected =' selected="selected"';
										}else{ 
											$selected = '';
										}
									echo '<option value="'.$cs_certificate_id.'" '.$selected.'>'.get_the_title().'</option>';
									 ?>
	                        <?php endwhile; wp_reset_query();
							echo '</select>';
						 ?>
                         </ul>
                        <ul class="form-elements">
                            <li class="to-label"></li>
                            <li class="to-field">
                            	<input type="button" value="<?php _e('Add Certificate to List','LMS');?>" onclick="add_certificate_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />                            </li>
                        </ul>
                    </div>
                   <!--Certificate section end-->
                    
                    <!--Diplay all Curriculm Listings--> 
                    <div class="cs-list-table">
                    	<table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;"><?php _e('Title','LMS');?></th>
                                <th style="width:80%;" class="centr"><?php _e('Actions','LMS');?></th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								
								global $counter_subject, $subject_title, $assignment_id, $var_cp_course_curriculum,$var_cp_course_quiz_list,$quiz_passing_marks,$quiz_retakes_no,$var_cp_course_certificate,$counter_subject,$counter_certificate,$counter_curriculum, $var_cp_course_curriculum ,$counter_assignment,$counter_quiz,$counter_subject, $var_cp_assignment_title, $var_cp_assignment_description, $assignment_total_marks, $var_cp_assigment_type, $assignment_upload_size, $var_cp_course_quiz_type, $assignment_passing_marks, $assignment_retakes_no;
								$counter_subject = $counter_certificate = $counter_curriculum = $counter_assignment = $counter_quiz = $counter_subject = $post->ID;
								$counter_subject = $post->ID;
								
								if ( is_object($cs_xmlObject) && isset($cs_xmlObject->course_curriculms) && count($cs_xmlObject->course_curriculms)>0 ) {
									foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
											 $listing_type = $curriculm->listing_type;
											if($listing_type == 'assigment' && isset($cs_lms) && $cs_lms == 'installed'){
												 $assignment_passing_marks = $curriculm->assignment_passing_marks;
												 $assignment_total_marks = $curriculm->assignment_total_marks;
												 $assignment_retakes_no = $curriculm->assignment_retakes_no;
												 $var_cp_assignment_title = $curriculm->var_cp_assignment_title;
												 $assignment_upload_size = $curriculm->assignment_upload_size;
												 $var_cp_assigment_type = $curriculm->var_cp_assigment_type;
												 if($var_cp_assigment_type){
													 $var_cp_assigment_type = explode(',',$var_cp_assigment_type);
												 }
												 $assignment_id = $curriculm->assignment_id;
												cs_add_assignment_to_list();
											} else if($listing_type == 'certificate'){
												$var_cp_course_certificate = $curriculm->var_cp_course_certificate;
												cs_add_certificate_to_list();
											} else if($listing_type == 'title'){
												$subject_title = $curriculm->subject_title;
												cs_add_subject_to_list();
											} else if($listing_type == 'quiz' && isset($cs_lms) && $cs_lms == 'installed'){
												
												$var_cp_course_quiz_type = $curriculm->var_cp_course_quiz_type;
												$quiz_passing_marks = $curriculm->quiz_passing_marks;
												$quiz_retakes_no = $curriculm->quiz_retakes_no;
												$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
												cs_add_quiz_to_list();
											} else if($listing_type == 'curriculum'){
												$var_cp_course_curriculum = $curriculm->var_cp_course_curriculum;
												cs_add_curriculum_to_list();
											}
											$counter_subject++;
											$counter_certificate++;
											$counter_curriculum++;
											$counter_assignment++;
											$counter_quiz++;
											$counter_subject++;
									}
								}
							?>
                        </tbody>
                    </table>
                    </div>
                </div>
        <?php
	}
	}
	// Course Meta option save
	if ( isset($_POST['course_meta_form']) and $_POST['course_meta_form'] == 1 ) {
			//if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_course_save' );  
			function cs_meta_course_save( $post_id )
			{  
				$sxe = new SimpleXMLElement("<course></course>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;  //course_description
					if ( empty($cs_xmlObject->course_id) ) $course_id = ""; else $course_id = $cs_xmlObject->course_id;
					if ( empty($cs_xmlObject->cs_tabs_style) ) $cs_tabs_style = ""; else $cs_tabs_style = $cs_xmlObject->cs_tabs_style;
					if ( empty($cs_xmlObject->course_pass_marks) ) $course_pass_marks = ""; else $course_pass_marks = $cs_xmlObject->course_pass_marks;
					if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
					if ( empty($cs_xmlObject->course_duration) ) $course_duration = ""; else $course_duration = $cs_xmlObject->course_duration;
					if ( empty($cs_xmlObject->var_cp_course_event) ) $var_cp_course_event = ""; else $var_cp_course_event = $cs_xmlObject->var_cp_course_event;
					if ( empty($cs_xmlObject->course_event_excerpt_length) ) $course_event_excerpt_length = ""; else $course_event_excerpt_length = $cs_xmlObject->course_event_excerpt_length;
					if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
					if ( empty($cs_xmlObject->var_cp_course_cds_product) ) $var_cp_course_cds_product = ""; else $var_cp_course_cds_product = $cs_xmlObject->var_cp_course_cds_product;
					if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
					if ( empty($cs_xmlObject->course_related) ) $course_related = ""; else $course_related = $cs_xmlObject->course_related;
					if ( empty($cs_xmlObject->course_related_title) ) $course_related_title = ""; else $course_related_title = $cs_xmlObject->course_related_title;
					if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
					if ( empty($cs_xmlObject->var_cp_course_cds_product) ) $var_cp_course_cds_product = ""; else $var_cp_course_cds_product = $cs_xmlObject->var_cp_course_cds_product;
					if ( empty($cs_xmlObject->course_subheader_bg_color) ) $course_subheader_bg_color = ""; else $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
					if ( empty($cs_xmlObject->var_cp_course_event) ) $var_cp_course_event_string = $var_cp_course_event = ''; else $var_cp_course_event_string = $var_cp_course_event = $cs_xmlObject->var_cp_course_event;
					if ($var_cp_course_event)
					{
						$var_cp_course_event = explode(",", $var_cp_course_event);
					} else {
						$var_cp_course_event = array();
					}
					if ( empty($cs_xmlObject->course_social) ) $course_social = ""; else $course_social = $cs_xmlObject->course_social;
					if ( empty($cs_xmlObject->course_author_info_show) ) $course_author_info_show = ""; else $course_author_info_show = $cs_xmlObject->course_author_info_show;
					if ( empty($cs_xmlObject->course_tags_show) ) $course_tags_show = ""; else $course_tags_show = $cs_xmlObject->course_tags_show;
					if ( empty($_POST["course_id"]) ) $_POST["course_id"] = "";
					if ( empty($_POST["cs_tabs_style"]) ) $_POST["cs_tabs_style"] = "";
					if ( empty($_POST["course_pass_marks"]) ) $_POST["course_pass_marks"] = "";
					if ( empty($_POST["course_short_description"]) ) $_POST["course_short_description"] = "";
					if ( empty($_POST["course_duration"]) ) $_POST["course_duration"] = "";
					if ( empty($_POST["var_cp_course_members"]) ) $_POST["var_cp_course_members"] = "";
					if ( empty($_POST["var_cp_course_instructor"]) ) $_POST["var_cp_course_instructor"] = "";
					if ( empty($_POST["var_cp_course_product"]) ) $_POST["var_cp_course_product"] = "";
					if ( empty($_POST["var_cp_course_cds_product"]) ) $_POST["var_cp_course_cds_product"] = "";
					if ( empty($_POST["course_subheader_bg_color"]) ) $_POST["course_subheader_bg_color"] = "";
					if ( empty($_POST["cs_courses_events_listing_type"]) ) $_POST["cs_courses_events_listing_type"] = "";
					if (empty($_POST["var_cp_course_event"])){ $var_cp_course_event = "";} else {
						$var_cp_course_event = implode(",", $_POST["var_cp_course_event"]);
					}
					if ( empty($_POST["course_event_excerpt_length"]) ) $_POST["course_event_excerpt_length"] = "";
					if ( empty($_POST["course_social"]) ) $_POST["course_social"] = "";
					if ( empty($_POST["course_author_info_show"]) ) $_POST["course_author_info_show"] = "";
					if ( empty($_POST["course_tags_show"]) ) $_POST["course_tags_show"] = "";
					if ( empty($_POST["var_cp_course_paid"]) ) $_POST["var_cp_course_paid"] = "";
					if ( empty($_POST["dynamic_post_course_view"]) ) $_POST["dynamic_post_course_view"] = "";
					if ( empty($_POST["course_curriculm_section_display"]) ) $_POST["course_curriculm_section_display"] = "";
					if ( empty($_POST["course_events_section_display"]) ) $_POST["course_events_section_display"] = "";
					if ( empty($_POST["course_members_section_display"]) ) $_POST["course_members_section_display"] = "";
					if ( empty($_POST["course_breif_section_display"]) ) $_POST["course_breif_section_display"] = "";
					if ( empty($_POST["course_reviews_section_display"]) ) $_POST["course_reviews_section_display"] = "";
					if ( empty($_POST["dynamic_post_faq_display"]) ) $_POST["dynamic_post_faq_display"] = "";
					if ( empty($_POST["course_related"]) ) $_POST["course_related"] = "";
					if ( empty($_POST["cs_course_badge"]) ) $_POST["cs_course_badge"] = "";
					if ( empty($_POST["cs_course_badge_assign"]) ) $_POST["cs_course_badge_assign"] = "";
					if ( empty($_POST["cs_course_certificate"]) ) $_POST["cs_course_certificate"] = "";
					if ( empty($_POST["course_related_title"]) ) $_POST["course_related_title"] = "";
					$course_instructor = '';
					$var_cp_course_instructor = (int)$_POST["var_cp_course_instructor"];
					if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
						$user_info = get_userdata($var_cp_course_instructor);
						$course_instructor = $user_info->display_name;
					}
					//course_event_section_title
					$sxe->addChild('course_id', $_POST['course_id'] );
					$sxe->addChild('cs_tabs_style', $_POST['cs_tabs_style'] );
					$sxe->addChild('course_pass_marks', $_POST['course_pass_marks'] );
					$sxe->addChild('course_short_description', $_POST['course_short_description'] );
					$sxe->addChild('course_duration', htmlspecialchars($_POST['course_duration']) );
					$sxe->addChild('course_subheader_bg_color', htmlspecialchars($_POST['course_subheader_bg_color']) );
					$sxe->addChild('course_social', htmlspecialchars($_POST['course_social']) );
					$sxe->addChild('course_related', htmlspecialchars($_POST['course_related']) );
					$sxe->addChild('course_related_title', htmlspecialchars($_POST['course_related_title']) );
					$sxe->addChild('course_social', $_POST['course_social'] );
					$sxe->addChild('course_author_info_show', $_POST['course_author_info_show'] );
					$sxe->addChild('course_tags_show', $_POST['course_tags_show'] );
					if (empty($_POST["var_cp_course_members"])){ $var_cp_course_members = "";} else {
						$var_cp_course_members = implode(",", $_POST["var_cp_course_members"]);
					}
					$sxe->addChild('var_cp_course_paid', $_POST['var_cp_course_paid'] );
					$sxe->addChild('var_cp_course_members', htmlspecialchars($var_cp_course_members));
					$sxe->addChild('var_cp_course_instructor', htmlspecialchars($_POST['var_cp_course_instructor']));
					$sxe->addChild('dynamic_post_course_view', htmlspecialchars($_POST['dynamic_post_course_view']));
					$sxe->addChild('cs_courses_events_listing_type', htmlspecialchars($_POST['cs_courses_events_listing_type']));
					
					$sxe->addChild('var_cp_course_event', $var_cp_course_event);
					$sxe->addChild('course_event_excerpt_length', $_POST['course_event_excerpt_length']);
					$sxe->addChild('var_cp_course_product', $_POST['var_cp_course_product']);
					$sxe->addChild('var_cp_course_cds_product', $_POST['var_cp_course_cds_product']);
					$sxe->addChild('course_curriculm_section_display', $_POST['course_curriculm_section_display']);
					$sxe->addChild('course_events_section_display', $_POST['course_events_section_display']);
					$sxe->addChild('course_members_section_display', $_POST['course_members_section_display']);
					$sxe->addChild('course_breif_section_display', $_POST['course_breif_section_display']);
					$sxe->addChild('course_reviews_section_display', $_POST['course_reviews_section_display']);
					$sxe->addChild('dynamic_post_faq_display', htmlspecialchars($_POST['dynamic_post_faq_display']));
					$sxe->addChild('cs_course_badge',  htmlspecialchars($_POST['cs_course_badge']));
					$sxe->addChild('cs_course_badge_assign',  htmlspecialchars($_POST['cs_course_badge_assign']));
					$sxe->addChild('cs_course_certificate',  htmlspecialchars($_POST['cs_course_certificate']));
 					$counter = 0;
					$assignment_counter = $subject_counter = $quiz_counter = $cirriculm_counter = $certificate_counter = 0;
					$faq_counter = 0;
					if (isset($_POST['listing_type'])) {
						foreach ( $_POST['listing_type'] as $type ){
							$track = $sxe->addChild('course_curriculms');
							$type = $_POST['listing_type'][$counter];
 							$track->addChild('listing_type', htmlspecialchars($_POST['listing_type'][$counter]) );
							if($type == 'assigment'){
								$assignment_id = $_POST['assignment_id'][$assignment_counter];
								$track->addChild('assignment_id', htmlspecialchars($_POST['assignment_id'][$assignment_counter]) );
								$track->addChild('var_cp_assignment_title', htmlspecialchars($_POST['var_cp_assignment_title_array'][$assignment_counter]) );
								//$track->addChild('var_cp_assignment_description', htmlspecialchars($_POST['var_cp_assignment_description_array'][$assignment_counter]) );
								$var_cp_assigment_type = '';
								if(isset($_POST['var_cp_assigment_type_array'][$assignment_id])){
									$var_cp_assigment_type = $_POST['var_cp_assigment_type_array'][$assignment_id];
									$var_cp_assigment_type = implode(',', $var_cp_assigment_type);
								}
								$track->addChild('var_cp_assigment_type', htmlspecialchars($var_cp_assigment_type) );
								$track->addChild('assignment_upload_size', htmlspecialchars($_POST['assignment_upload_size_array'][$assignment_counter]) );
								$track->addChild('assignment_passing_marks', htmlspecialchars($_POST['assignment_passing_marks_array'][$assignment_counter]) );
								$track->addChild('assignment_total_marks', htmlspecialchars($_POST['assignment_total_marks_array'][$assignment_counter]) );
								$track->addChild('assignment_retakes_no', htmlspecialchars($_POST['assignment_retakes_no_array'][$assignment_counter]) );
								$assignment_counter++;
							}elseif($type == 'title'){
								$track->addChild('subject_title', htmlspecialchars($_POST['subject_title_array'][$subject_counter]) );
								$subject_counter++;
							}
							elseif($type == 'quiz'){
								
								$track->addChild('var_cp_course_quiz_list', htmlspecialchars($_POST['var_cp_course_quiz_array'][$quiz_counter]) );
								$track->addChild('quiz_passing_marks', htmlspecialchars($_POST['quiz_passing_marks_array'][$quiz_counter]) );
								$track->addChild('quiz_retakes_no', htmlspecialchars($_POST['quiz_retakes_no_array'][$quiz_counter]) );
								$track->addChild('var_cp_course_quiz_type', htmlspecialchars($_POST['var_cp_course_quiz_type'][$quiz_counter]) );
								$quiz_counter++;
							}
							elseif($type == 'certificate'){
								$track->addChild('var_cp_course_certificate', htmlspecialchars($_POST['var_cp_course_certificate_array'][$certificate_counter]) );
								$certificate_counter++;
							}
							elseif($type == 'curriculum'){
								$track->addChild('var_cp_course_curriculum', htmlspecialchars($_POST['var_cp_course_curriculum_array'][$cirriculm_counter]) );
								$cirriculm_counter++;
							}
							$counter++;
						}
					}
					if (isset($_POST['dynamic_post_faq']) && $_POST['dynamic_post_faq'] == '1' && isset($_POST['faq_title_array']) && is_array($_POST['faq_title_array'])) {
						$sxe->addChild('dynamic_post_faq_display', $_POST['dynamic_post_faq_display']);
						foreach ( $_POST['faq_title_array'] as $type ){
							$faq_list = $sxe->addChild('faqs');
							$faq_list->addChild('faq_title', htmlspecialchars($_POST['faq_title_array'][$faq_counter]) );
							$faq_list->addChild('faq_description', htmlspecialchars($_POST['faq_description_array'][$faq_counter]) );
							$faq_counter++;
						}
					}
					$sxe = cs_page_options_save_xml($sxe);
					
					update_post_meta( $post_id, 'cs_course', $sxe->asXML() );										
					
					$user_course_data = array();
					$memers_counter = 0;
					$cs_user_ids_option = array();
					$cs_course_ids_option = array();
					$cs_course_instructor_ids_option = array();
					$cs_course_register_option = array();
					$cs_course_register_option = get_option("cs_course_register_option", true);
					if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
						$cs_course_register_option = array();	
					}
					if(isset($cs_course_register_option['cs_user_ids_option']))
						$cs_user_ids_option = @$cs_course_register_option['cs_user_ids_option'];
					if(isset($cs_course_register_option['cs_course_ids_option']))
						$cs_course_ids_option = @$cs_course_register_option['cs_course_ids_option'];
					if(isset($cs_course_register_option['cs_course_instructor_ids_option']))
						$cs_course_instructor_ids_option = @$cs_course_register_option['cs_course_instructor_ids_option'];
					
					
					if (isset($_POST['dynamic_post_course_members']) && $_POST['dynamic_post_course_members'] == '1') {
						if(isset($_POST['course_user_id_array']) && count($_POST['course_user_id_array'])>0){
							foreach ( $_POST['course_user_id_array'] as $type ){
								$course_user_array = array();
								
								//==Update User certificate
								/*if( isset( $_POST['cs_course_certificate'] ) && $_POST['cs_course_certificate'] !=''){							
									update_user_meta( $type, 'user_certificate', $_POST['cs_course_certificate'] );
								}*/
								//==Update User certificate End
								
								if(isset($_POST['transaction_id_array'][$memers_counter]) && $_POST['transaction_id_array'][$memers_counter] <> ''){
									$transaction_id = $_POST['transaction_id_array'][$memers_counter];	
								} else {
									$transaction_id = cs_generate_random_string('11');	
									$user_id = $_POST['course_user_id_array'][$memers_counter];
								}
								if(isset($_POST['course_title_array'][$memers_counter]) && $_POST['course_title_array'][$memers_counter] <> ''){
									$course_title = $_POST['course_title_array'][$memers_counter];
								} else {
									$course_title = get_the_title($post_id);
								}
								if(isset($_POST['course_instructor_array'][$memers_counter]) && $_POST['course_instructor_array'][$memers_counter] <> ''){
									$course_instructor = $_POST['course_instructor_array'][$memers_counter];
									$var_cp_course_instructor = get_post_meta( $post_id, 'var_cp_course_instructor', true);
								} else {
									$var_cp_course_instructor = get_post_meta( $post_id, 'var_cp_course_instructor', true);
									if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
										$user_information = get_userdata((int)$var_cp_course_instructor);
										$course_instructor = $user_information->user_login;
									} else {
										$course_instructor = '';	
									}
								}
								if(isset($_POST['course_title_array'][$memers_counter]) && $_POST['course_title_array'][$memers_counter] <> ''){
									$course_title = $_POST['course_title_array'][$memers_counter];
								} else {
									$course_title = get_the_title($post_id);
								}
								if(isset($_POST['course_user_email_array'][$memers_counter]) && $_POST['course_user_email_array'][$memers_counter] <> ''){
									$course_user_email = $_POST['course_user_email_array'][$memers_counter];
								}
								
								$user_id = $_POST['course_user_id_array'][$memers_counter];
								
								if(isset($_POST['course_user_id_array'][$memers_counter]) && $_POST['course_user_id_array'][$memers_counter] <> ''){
									$course_user_id = $_POST['course_user_id_array'][$memers_counter];
								} else if(isset($_POST['user_display_id_array'][$memers_counter]) && $_POST['user_display_id_array'][$memers_counter] <> ''){
									$course_user_id = $_POST['user_display_id_array'][$memers_counter];
								}
								if(isset($_POST['user_display_name_array'][$memers_counter]) && $_POST['user_display_name_array'][$memers_counter] <> ''){
									$user_display_name = $_POST['user_display_name_array'][$memers_counter];
								} else {
									$user_information = get_userdata((int)$course_user_id);
									$user_display_name = $user_information->user_login;
								}
								
								
								$post_status = get_post_status( $post_id );
								
								if($post_status == 'publish')	{
									$course_title = get_the_title($post_id);
								}  else {
									$course_title = $course_title;
								}
								$user_information = get_userdata((int)$course_user_id);
								if($user_information){
									$course_user_email = $user_information->user_email;
									$user_display_name = $user_information->user_login;
								}
								if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
									$user_information = get_userdata((int)$var_cp_course_instructor);
									$course_instructor = $user_information->user_login;
								}
								
								$course_user_array['transaction_id'] = $transaction_id;
								$course_user_array['user_id'] = $course_user_id;
								$course_user_array['user_display_name'] = $user_display_name;
								$course_user_array['course_id'] = $post_id;
								$course_user_array['order_id'] = $_POST['order_id_array'][$memers_counter];
								$course_user_array['course_user_email'] = $course_user_email;
								$course_user_array['course_title'] = $course_title;
								$course_user_array['course_price'] = $_POST['course_price_array'][$memers_counter];
								$course_user_array['course_instructor'] = htmlspecialchars($course_instructor);
								$course_user_array['register_date'] = $_POST['register_date_array'][$memers_counter];
								$course_user_array['expiry_date'] = $_POST['expiry_date_array'][$memers_counter];
								$course_user_array['result'] = $_POST['result_array'][$memers_counter];
								$course_user_array['remarks'] = $_POST['remarks_array'][$memers_counter];
								$course_user_array['payment_method_title'] = $_POST['payment_method_title_array'][$memers_counter];
								$course_user_array['payment_status'] = $_POST['payment_status_array'][$memers_counter];
								$course_user_array['disable'] = $_POST['disable_array'][$memers_counter];
								$user_course_data[] = $course_user_array;
								$memers_counter++;
								
								$cs_user_ids_option[(int)$user_id] = $user_display_name;
								$cs_course_ids_option[(int)$post_id] = $course_title;
								$user_instructors_ids_data[(int)$var_cp_course_instructor] = $course_instructor;
								
								
								$course_user_meta_array = array();
								$course_user_meta_array = get_option($user_id."_cs_course_data", true);
								if(!is_array($course_user_meta_array))
									$course_user_meta_array = array();
								$course_user_meta_array[$post_id] = array();
								$course_user_meta_array[$post_id]['transaction_id'] = $transaction_id;
								$course_user_meta_array[$post_id]['course_id'] = $post_id;
								$course_user_meta_array[$post_id]['course_instructor'] = htmlspecialchars($course_instructor);
								$course_user_meta_array[$post_id]['course_title'] = $course_title;
								update_option($user_id."_cs_course_data", $course_user_meta_array);							
								
							}
							$cs_course_register_option['cs_user_ids_option'] = $cs_user_ids_option;
							$cs_course_register_option['cs_course_ids_option'] = $cs_course_ids_option;
							$cs_course_register_option['cs_course_instructor_ids_option'] = $user_instructors_ids_data;
							update_option("cs_course_register_option", $cs_course_register_option);
						}
					}
					
					update_post_meta( $post_id, 'cs_user_course_data', $user_course_data );
					update_option($post_id."_cs_user_course_data", $user_course_data);
					update_post_meta( $post_id, 'var_cp_course_members', htmlspecialchars($_POST["var_cp_course_members"]) );
					update_post_meta( $post_id, 'var_cp_course_instructor', htmlspecialchars($_POST['var_cp_course_instructor']) );
					
					
					
			}
		}
		// adding course meta info end
		
		// Event type doropdown
		if ( ! function_exists( 'cs_event_type_dropdown' ) ) {
			function cs_event_type_dropdown($die = 0){
				date_default_timezone_set('UTC');
				$current_time = strtotime(current_time('m/d/Y', $gmt = 0));
				$event_type = $_POST['event_type'];
				if ( $event_type == "Upcoming Events" ) $meta_compare = ">=";
        		else if ( $event_type == "Past Events" ) $meta_compare = "<";
				$var_cp_course_event = $_POST['var_cp_course_event'];
				if ($var_cp_course_event) {
					$var_cp_course_event = explode(",", $var_cp_course_event);
				}
				$user_meta_key				= '';
				$user_meta_value			= '';
				$meta_value = $current_time;
				$meta_key = 'cs_dynamic_event_from_date_time';
				$order	= 'DESC';
				$orderby = 'meta_value';
				if ( $event_type == "All Events" ) {
					$args = array(
						'posts_per_page'			=> "-1",
						'paged'						=> "1",
						'post_type'					=> 'cs-events',
						'post_status'				=> 'publish',
						'orderby'					=> $orderby,
						'order'						=> $order,
					);
					
				} else {
					$args = array(
						'posts_per_page'			=> "-1",
						'paged'						=> "1",
						'post_type'					=> 'cs-events',
						'post_status'				=> 'publish',
						'meta_key'					=> $meta_key,
						'meta_value'				=> $meta_value,
						'meta_compare'				=> $meta_compare,
						'orderby'					=> $orderby,
						'order'						=> $order,
					);
				}
				?>
                 <li class="to-label"><label><?php _e('Select Event','LMS'); ?></label></li>
            	 <li id="test">
					<script>
                        jQuery(function() {
                            var t = jQuery('#test').bootstrapTransfer(
                                {'target_id': 'multi-select-input',
                                 'height': '15em',
                                 'hilite_selection': false});
                            t.populate([
                                 <?php 
                                     $events=get_posts( $args );
                                    foreach($events as $event){
                                        $cs_event_id = get_the_ID();
                                        echo '{value:"'.$event->ID.'", content:"'.$event->post_title.'"},';
                                    }
                                 ?> 
                            ]);
                            t.set_values([
                            <?php
                                if($var_cp_course_event <> ''){
                                    foreach($var_cp_course_event as $events){
                                        echo '"'.$events.'",';
                                    }
                                }
                            ?>
                            ]);
                            //console.log(t.get_values());
                        });
                    </script>
                 </li>
                <?php
				exit;
			}
			add_action('wp_ajax_cs_event_type_dropdown', 'cs_event_type_dropdown');
		}
?>