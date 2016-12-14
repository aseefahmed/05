<?php
	//adding columns start
    add_filter('manage_courses_posts_columns', 'course_columns_add');
	function course_columns_add($columns) {
		$columns['category'] =__('Category','EDULMS');
		$columns['author'] =__('Author','EDULMS');
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
							echo esc_attr($category->name);
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
	if(!class_exists('post_type_courses')){
		/**
		 * Assignment Post Type Class
		*/
		class post_type_courses
		{
			/**
			 * The Constructor
			*/
			public function __construct()
			{
				// register actions
				//require_once ('/../include/edulms-courses/course-functions.php');
				add_action('init', array(&$this, 'cs_course_init'));
				add_action('admin_init', array(&$this, 'cs_course_admin_init'));
				add_action('wp_enqueue_scripts', array('edulms', 'cs_course_files_enqueue'));
				add_action('admin_enqueue_scripts', array('edulms', 'cs_course_files_enqueue'));
				if ( isset($_POST['course_meta_form']) and $_POST['course_meta_form'] == 1 ) {
					add_action( 'save_post', array(&$this, 'cs_meta_course_save') );  
				}
			} 
			
			/**
			 * hook into WP's init action hook
			*/
			public function cs_course_init()
			{
				// Initialize Post Type
				$this->cs_course_register();
				$this->cs_course_register_categories();
				$this->cs_course_register_tags();
			}
			
			/**
			 * Create the Assignment post type
			 */
			public function cs_course_register()
			{
				register_post_type( 'courses',	array(
									'labels'             => array(
									'name' 				 => __('LMS','EDULMS'),
									'all_items'			 => __('Courses','EDULMS'),
									'singular_name'      => __( 'Course','EDULMS' ),
									//'menu_name'          => _x( 'LMS', 'Admin menu name', 'EDULMS' ),
									'add_new'            => __( 'Add Course','EDULMS' ),
									'add_new_item'       => __( 'Add New Course','EDULMS' ),
									'edit'               => __( 'Edit', 'EDULMS' ),
									'edit_item'          => __( 'Edit Course','EDULMS' ),
									'new_item'           => __( 'New Course','EDULMS' ),
									'view'               => __( 'View Courses', 'EDULMS' ),
									'view_item'          => __( 'View Course','EDULMS' ),
									'search_items'       => __( 'Search Courses','EDULMS' ),
									'not_found'          => __( 'No Course found', 'EDULMS' ),
									'not_found_in_trash' => __( 'No Course found in trash', 'EDULMS' ),
									'parent'             => __( 'Parent Course', 'EDULMS' )
								),
							'description'         => __( 'This is where you can add new Assignment.', 'EDULMS' ),
							'public'              => true,
							'show_ui'             => true,
							'capability_type'     => 'post',
							//'show_in_menu' => 'edit.php?post_type=courses',
							'map_meta_cap'        => true,
							'publicly_queryable'  => true,
							'exclude_from_search' => false,
							'hierarchical'        => false, 
							'rewrite'             => true,
							'query_var'           => true,
							'supports'            => array( 'title', 'editor', 'thumbnail'),
							'has_archive'         => 'courses',
						)
					);
			}
			/**
			 * Course Categories
			 */
			public function cs_course_register_categories(){
				  $labels = array(
					'name' =>__('Course Categories','EDULMS'),
					'search_items' =>__('Search Course Categories','EDULMS'),
					'edit_item' =>__('Edit Course Category','EDULMS'),
					'update_item' =>__('Update Course Category','EDULMS'),
					'add_new_item' =>__('Add New Category','EDULMS'),
					'menu_name' =>__('Categories','EDULMS'),
				  ); 	
				  register_taxonomy('course-category',array('courses'), array(
					'hierarchical' => true,
					'labels' => $labels,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => 'course-category' ),
				  ));
			}
			
			/**
			 * Course Tags
			 */
			public function cs_course_register_tags(){
				// adding tag start
				  $labels = array(
					'name' =>__('Course Tags','EDULMS'),
					'singular_name' => 'course-tag',
					'search_items' =>__('Search Tags','EDULMS'),
					'popular_items' =>__('Popular Tags','EDULMS'),
					'all_items' =>__('All Tags','EDULMS'),
					'parent_item' => null,
					'parent_item_colon' => null,
					'edit_item' =>__('Edit Tag','EDULMS'),
					'update_item' =>__('Update Tag','EDULMS'),
					'add_new_item' =>__('Add New Tag','EDULMS'),
					'new_item_name' => 'New Tag Name',
					'separate_items_with_commas' => 'Separate tags with commas',
					'add_or_remove_items' =>__('Add or remove tags','EDULMS'),
					'choose_from_most_used' =>__('Choose from the most used tags','EDULMS'),
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
			}
			/**
			 * Hide Course Add new link
			 */
			public function cs_hide_addnew_course_text() {
				global $submenu;
				unset($submenu['edit.php?post_type=courses'][10]);
				if('courses' == get_post_type())
					echo '';
			}
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_course_admin_init()
			{           
				add_action( 'admin_head', array(&$this, 'cs_hide_addnew_course_text'));
				add_action('wp_ajax_cs_add_subject_to_list', array(&$this, 'cs_add_subject_to_list'));
				add_action('wp_ajax_cs_add_quiz_to_list', array(&$this, 'cs_add_quiz_to_list'));
				add_action('wp_ajax_cs_add_assignment_to_list', array(&$this, 'cs_add_assignment_to_list'));
				add_action('wp_ajax_cs_add_curriculum_to_list', array(&$this, 'cs_add_curriculum_to_list'));
				add_action('wp_ajax_cs_add_certificate_to_list', array(&$this, 'cs_add_certificate_to_list'));
				// Add metaboxes
				add_action('add_meta_boxes', array(&$this, 'cs_meta_course_add'));
			}
			/**
			 * hook into WP's add_meta_boxes action hook
			*/
			public function cs_meta_course_add()
			{  
				add_meta_box( 'cs_meta_course', __('Course Options','EDULMS'), array(&$this, 'cs_meta_course'), 'courses', 'normal', 'high' );  
			}
			
			/**
			 * Course meta Fields
			*/
			public function cs_meta_course( $post ) {
				global $post,$cs_xmlObject;
				$cs_theme_options=get_option('cs_theme_options');
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
			?>		
                <div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
                    <div class="option-sec" style="margin-bottom:0;">
                        <div class="opt-conts">
                            <div class="elementhidden">
                                <div class="tabs vertical">
                                    <nav class="admin-navigtion">
                                        <ul id="myTab" class="nav nav-tabs">
                                        	<?php
											if ( function_exists( 'cs_general_settings_element' ) ||  function_exists( 'cs_sidebar_layout_options' )) { 
											?>
                                            <li class="active"><a href="#tab-general-settings" data-toggle="tab"><i class="fa fa-cog"></i><?php _e('General','EDULMS');?></a></li>
                                            <?php
											}
											if ( function_exists( 'cs_subheader_element' ) ) { 
												?>
                                            	<li><a href="#tab-subheader-options" data-toggle="tab"><i class="fa fa-indent"></i><?php _e('Sub Header','EDULMS');?> </a></li>
                                            	<?php
											}
											if(isset($cs_builtin_seo_fields) && $cs_builtin_seo_fields == 'on' && function_exists( 'cs_seo_settitngs_element' )){
												?>
                                            	<li><a href="#tab-seo-advance-settings" data-toggle="tab"><i class="fa fa-dribbble"></i><?php _e('Seo Options','EDULMS');?></a></li>
                                            	<?php 
											}
											?>
                                            <li><a href="#tab-course-options" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php _e('Course Options','EDULMS');?> </a></li>
                                            <?php
											if ( post_type_exists( 'cs-events' ) ) {
											?>
                                            	<li><a href="#tab-event-options" data-toggle="tab"><i class="fa fa-calendar"></i><?php _e('Event','EDULMS');?></a></li>
                                            <?php 
											}
											?>
                                            <li><a href="#tab-member-settings" data-toggle="tab"><i class="fa fa-users"></i><?php _e('Members','EDULMS');?></a></li>
                                            <li><a href="#tab-curriculm-settings" data-toggle="tab"><i class="fa fa-folder-open"></i><?php _e('Unit Settings','EDULMS');?></a></li>
                                           
                                      </ul>
                                  </nav>
                                    <div class="tab-content">
                                    <?php
									if ( function_exists( 'cs_subheader_element' ) ) { 
										?>
                                        <div id="tab-subheader-options" class="tab-pane fade">
                                            <?php cs_subheader_element();?>
                                        </div>
                                    	<?php 
									}
									if ( post_type_exists( 'cs-events' ) ) {
										?>
											<div id="tab-event-options" class="tab-pane fade">
												<?php $this->cs_course_event_element();?>
											</div>
										<?php
									}
									if ( function_exists( 'cs_general_settings_element' ) ||  function_exists( 'cs_sidebar_layout_options' )) { 
									?>
                                        <div id="tab-general-settings" class="tab-pane fade active in">
                                            <?php 
                                                if ( function_exists( 'cs_general_settings_element' ) ) { 
                                                    cs_general_settings_element();
                                                }
                                                if ( function_exists( 'cs_sidebar_layout_options' ) ) { 
													 if ( isset($cs_theme_sidebar['sidebar']) and count($cs_theme_sidebar['sidebar']) > 0 ) {
                                                    	cs_sidebar_layout_options();
													 }
                                                }
                                            ?>
                                        </div>
                                     <?php
									}
									?>
                                    <div id="tab-course-options" class="tab-pane fade">
                                        <ul class="form-elements">
                                            <li class="to-label">
                                                <label><?php _e('Course Detail Views','EDULMS');?> </label>
                                            </li>
                                            <li class="to-field">
                                                <div class="input-sec">
                                                    <div class="select-style">
                                                        <select name="dynamic_post_course_view" id="dynamic_post_course_view">
                                                            <option value="Wide" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'Wide'){echo 'selected="selected"';}?>><?php _e('Wide','EDULMS');?></option>
                                                            <option value="Fullwidth" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'Fullwidth'){echo 'selected="selected"';}?>><?php _e('Fullwidth','EDULMS');?></option>
                                                             <option value="InPost" <?php if(isset($cs_xmlObject->dynamic_post_course_view) && $cs_xmlObject->dynamic_post_course_view == 'InPost'){echo 'selected="selected"';}?>><?php _e('In Post','EDULMS');?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                       </ul>
                                       <?php $this->cs_course_general_settings($course_post_id);?>
                                    </div>
                                    <div id="tab-curriculm-settings" class="tab-pane fade">
                                        <?php $this->cs_curriculm_settings($course_post_id);?>
                                    </div>
                                    <div id="tab-member-settings" class="tab-pane fade">
                                    	<ul class="form-elements">
                                            <li class="to-label"><label><?php _e('Date Time','EDULMS');?></label></li>
                                            <li class="to-field">
                                            	<input type="text" name="date_test[]" value="" id="date_test" />
												<script>
                                                    jQuery(function(){
                                                        jQuery('#date_test').datetimepicker();
                                                    });
                                                </script>
                                            </li>
                                         </ul>
                                        <ul class="form-elements">
                                                <li class="to-label"><label><?php _e('Select Instructor','EDULMS');?></label></li>
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
                                            //wp_reset_postdata();
                                            	$this->cs_course_members_section($course_post_id);
                                            ?>
                                    </div>
                                 
                                    <?php if(isset($cs_builtin_seo_fields) && $cs_builtin_seo_fields == 'on' && function_exists( 'cs_seo_settitngs_element' )){?>
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
		   /**
			* course event Settings
		   */
		   public function cs_course_event_element(){
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
				?>
				<ul class="form-elements">
				  <li class="to-label">
					<label>
					  <?php _e('Events Listing Types','EDULMS'); ?>
					</label>
				  </li>
				  <li class="to-field">
					<div class="input-sec">
					  <div class="select-style">
						<select name="cs_courses_events_listing_type" class="dropdown">
						  <option <?php if($cs_courses_events_listing_type=="All Events")echo "selected";?>> <?php _e('All Events','EDULMS'); ?> </option>
						  <option <?php if($cs_courses_events_listing_type=="Upcoming Events")echo "selected";?>> <?php _e('Upcoming Events','EDULMS'); ?> </option>
						  <option <?php if($cs_courses_events_listing_type=="Past Events")echo "selected";?>> <?php _e('Past Events','EDULMS'); ?> </option>
						</select>
					  </div>
					</div>
				  </li>
				</ul>
				<ul class="form-elements">
                    <li class="to-label"><label><?php _e('Event Excerpt Length','EDULMS');?></label></li>
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
					<li class="to-label"><label><?php _e('Select Event','EDULMS'); ?></label></li>
					<li class="to-field">
                    	<div class="input-sec">
                        	<select multiple="multiple" id="var_cp_course_event" name="var_cp_course_event[]" style="min-height:150px;">
                        		<?php 
								   $events=get_posts( $args );
								  foreach($events as $event){
									  $cs_event_id = get_the_ID();
									  $selected = (in_array($event->ID,$var_cp_course_event))?'selected':'';
									  echo '<option value="'.$event->ID.'" '.$selected.'>'.$event->post_title.'</option>';
								  }
							   ?> 
                        	</select>
                        </div>

					</li>
			  </ul>
			<?php
		   }
		   
		   /**
			* course general Settings
		   */
			public function cs_course_general_settings($course_post_id=''){
				global $post, $cs_xmlObject, $cs_theme_options;
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
				if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
				if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
 				if ( empty($cs_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
				if ( empty($cs_xmlObject->cs_course_badge) ) $cs_course_badge = ""; else $cs_course_badge = $cs_xmlObject->cs_course_badge;
				if ( empty($cs_xmlObject->cs_course_badge_assign) ) $cs_course_badge_assign = ""; else $cs_course_badge_assign = $cs_xmlObject->cs_course_badge_assign;
				if ( empty($cs_xmlObject->cs_course_certificate_assign) ) $cs_course_certificate_assign = ""; else $cs_course_certificate_assign = $cs_xmlObject->cs_course_certificate_assign;
				if ( empty($cs_xmlObject->cs_course_certificate) ) $cs_course_certificate = ""; else $cs_course_certificate = $cs_xmlObject->cs_course_certificate;
				if ( empty($cs_xmlObject->course_paid_price) ) $course_paid_price = ""; else $course_paid_price = $cs_xmlObject->course_paid_price;
				if ( empty($cs_xmlObject->course_paypal_email) ) $course_paypal_email = ""; else $course_paypal_email = $cs_xmlObject->course_paypal_email;
				if ( empty($cs_xmlObject->course_custom_payment_url) ) $course_custom_payment_url = ""; else $course_custom_payment_url = $cs_xmlObject->course_custom_payment_url;
				
				if ( empty($cs_xmlObject->course_curriculums_tabs_display) ) $course_curriculums_tabs_display = ""; else $course_curriculums_tabs_display = $cs_xmlObject->course_curriculums_tabs_display;
				?>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Choose Tabs View','EDULMS');?></label></li>
						<li class="to-field">
							<div class="input-sec">
								<div class="select-style">
									<select name="cs_tabs_style" class="dropdown">
										<option <?php if(isset($cs_tabs_style) and $cs_tabs_style=="classic"){echo "selected";}?> value="classic" ><?php _e('Classic','EDULMS');?></option>
										<option <?php if(isset($cs_tabs_style) and $cs_tabs_style=="modren"){echo "selected";}?> value="modren" ><?php _e('Modern','EDULMS');?></option>
									</select>
								</div>
							</div>
						</li>
					 </ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Course Brief Tab Title','EDULMS');?></label></li>
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
						<label><?php _e('FAQS Tab Title','EDULMS');?></label>
					  </li>
					  <li class="to-field has_input">
						<label class="pbwp-checkbox">
						  <input type="hidden" name="dynamic_post_faq_display" value="" />
						  <input type="checkbox" name="dynamic_post_faq_display" value="on" class="myClass" <?php if($dynamic_post_faq_display=='on')echo "checked"?> />
						  <span class="pbwp-box"></span> </label>
					  </li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Curriclum Tab Title','EDULMS');?></label></li>
						<li class="to-field has_input">
							<label class="pbwp-checkbox">
								<input type="hidden" name="course_curriculm_section_display" value="" />
								<input type="checkbox" name="course_curriculm_section_display" value="on" class="myClass" <?php if($course_curriculm_section_display=='on')echo "checked"?> />
								<span class="pbwp-box"></span>
							</label>
						</li>
					</ul>
					<ul class="form-elements">
					<li class="to-label"><label><?php _e('Event Tab Title','EDULMS');?></label></li>
					<li class="to-field has_input">
						<label class="pbwp-checkbox">
							<input type="hidden" name="course_events_section_display" value="" />
							<input type="checkbox" name="course_events_section_display" value="on" class="myClass" <?php if($course_events_section_display=='on')echo "checked"?> />
							<span class="pbwp-box"></span>
						</label>
					</li>
				</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Members Tab Title','EDULMS');?></label></li>
						<li class="to-field has_input">
							<label class="pbwp-checkbox">
								<input type="hidden" name="course_members_section_display" value="" />
								<input type="checkbox" name="course_members_section_display" value="on" class="myClass" <?php if($course_members_section_display=='on')echo "checked"?> />
								<span class="pbwp-box"></span>
							</label>
						</li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Reviews Tab Title','EDULMS');?></label></li>
						<li class="to-field has_input">
							<label class="pbwp-checkbox">
								<input type="hidden" name="course_reviews_section_display" value="" />
								<input type="checkbox" name="course_reviews_section_display" value="on" class="myClass" <?php if($course_reviews_section_display=='on')echo "checked"?> />
								<span class="pbwp-box"></span>
							</label>
						</li>
					</ul>
					<ul class="form-elements">
						<?php 
						$cs_badges_list	=  get_option('cs_badges');
						$badges = isset($cs_badges_list['badges_net_icons']) ? $cs_badges_list['badges_net_icons'] : ''; ?>
						<li class="to-label"><label><?php _e('Badges','EDULMS');?></label></li>
						<li class="to-field">
							<div class="select-style">
								<select name="cs_course_badge" class="dropdown">
									<option value="" ><?php _e('None','EDULMS');?></option>
									<?php
									if(isset($badges) and $badges <> ''){
										foreach($badges as $badge){
									?>
										<option <?php if(isset($cs_course_badge) and $cs_course_badge==$badge){echo "selected";}?>><?php echo esc_attr($badge); ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
						</li>
					</ul>
					<ul class="form-elements">
					<li class="to-label"><label><?php _e('Assign Badge On','EDULMS');?></label></li>
						<li class="to-field">
							<div class="select-style">
								<select name="cs_course_badge_assign" class="dropdown">
									<option value="expire" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'expire'){echo "selected";}?>><?php _e('Course Expire','EDULMS');?></option>
									<option value="purchase" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'purchase'){echo "selected";}?>><?php _e('Course Purchase','EDULMS');?></option>
									<option value="completion" <?php if(isset($cs_course_badge_assign) and $cs_course_badge_assign == 'completion'){echo "selected";}?>><?php _e('Course Successfully Completion','EDULMS');?></option>
								</select>
						   </div>
					   </li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Certificate','EDULMS');?></label></li>
						<li class="to-field">
							<div class="select-style">
								<select name="cs_course_certificate" class="dropdown">
									<option value="" ><?php _e('None','EDULMS');?></option>
									<?php
									$args = array('posts_per_page' => "-1", 'post_type' => 'cs-certificates','order' => 'DESC', 'orderby' => 'ID', 'post_status' => 'publish');
									$query = new WP_Query( $args );
									$count_post = $query->post_count;
									if ( $query->have_posts() ) {  
										while ( $query->have_posts() ) { $query->the_post();
									?>
										<option value="<?php echo get_the_ID();?>" <?php echo  isset($cs_course_certificate) && $cs_course_certificate == get_the_ID() ? 'selected="selected"' : '';?>><?php echo the_title();?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
						</li>
					</ul>
                    <ul class="form-elements">
						<li class="to-label"><label><?php _e('Assign Certificate On','EDULMS');?></label></li>
						<li class="to-field">
							<div class="select-style">
								<select name="cs_course_certificate_assign" class="dropdown">
									<option value="expire" <?php if(isset($cs_course_certificate_assign) and $cs_course_certificate_assign == 'expire'){echo "selected";}?>><?php _e('Course Expire','EDULMS');?></option>
									<option value="purchase" <?php if(isset($cs_course_certificate_assign) and $cs_course_certificate_assign == 'purchase'){echo "selected";}?>><?php _e('Course Purchase','EDULMS');?></option>
									<option value="completion" <?php if(isset($cs_course_certificate_assign) and $cs_course_certificate_assign == 'completion'){echo "selected";}?>><?php _e('Course Successfully Completion','EDULMS');?></option>
								</select>
						   </div>
					   </li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Course Code','EDULMS');?></label></li>
						<li class="to-field">
							<div class="input-sec">
							<input type="text" name="course_id" value="<?php echo htmlspecialchars($course_id)?>" />
							</div>
						</li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Course Passing Marks in','EDULMS');?> %</label></li>
						<li class="to-field">
							<div class="input-sec">
							<input type="text" name="course_pass_marks" value="<?php echo htmlspecialchars($course_pass_marks)?>" />
							</div>
							
						</li>
					</ul>
				    <ul class="form-elements">
						<li class="to-label"><label><?php _e('Short Description','EDULMS');?></label></li>
						<li class="to-field">
							<div class="input-sec">
							<textarea rows="20" cols="40" name="course_short_description" ><?php echo htmlspecialchars($course_short_description)?></textarea>
							</div>
						</li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Course Duration (No of Days)','EDULMS');?></label></li>
						<li class="to-field">
							<div class="input-sec">
							 <input type="text" id="course_duration" name="course_duration" value="<?php if($course_duration) echo htmlspecialchars($course_duration)?>" />
							</div>
						</li>
					</ul>
					<ul class="form-elements">
						<li class="to-label"><label><?php _e('Course Paid','EDULMS');?></label></li>
						<li class="to-field select-style">
						  <select name="var_cp_course_paid" onchange="cs_course_product_option(this.value)">
								<!--<option value="free" <?php if( $var_cp_course_paid == 'free' ) { echo 'selected';}?>>Free Open Course </option>-->
								<option value="registered_user_access" <?php if( $var_cp_course_paid == 'registered_user_access' ) { echo 'selected';}?>>
                                <?php _e('FREE Course WITH USER REGISTRATION','EDULMS'); ?></option>
                                <option value="paid-with-woocommerce" <?php if( $var_cp_course_paid == 'paid-with-woocommerce' ) { echo 'selected';}?>><?php _e('Restricted Course (PAID WITH WOOCOMMERCE)','EDULMS');?></option>
                                <!--<option value="paid-with-paypal" <?php if( $var_cp_course_paid == 'paid-with-paypal' ) { echo 'selected';}?>>Restricted Course (PAID WITH Paypal)</option>-->
                                <option value="paid" <?php if( $var_cp_course_paid == 'paid' ) { echo 'selected';}?>><?php _e('Restricted Course (Paid With Custom)','EDULMS');?></option>
 						  </select>
						</li>
					</ul>
                   <ul class="form-elements" id="course_paid_price" <?php if($var_cp_course_paid <> 'paid' && $var_cp_course_paid <> 'paid-with-paypal')echo 'style="display: none;"';?>>
						<li class="to-label">
							<label><?php _e('Price','EDULMS');?> </label>
						</li>
						<li class="to-field">
							<div class="input-sec">
								<input type="text" name="course_paid_price" value="<?php echo htmlspecialchars($course_paid_price);?>"  />
							</div>
						</li>
				   </ul>
                   <ul class="form-elements" id="course_paypal_email" <?php if($var_cp_course_paid <> 'paid-with-paypal')echo 'style="display: none;"';?>>
						<li class="to-label">
							<label><?php _e('Paypal Email','EDULMS');?> </label>
						</li>
						<li class="to-field">
							<div class="input-sec">
                            	<input type="text" name="course_paypal_email" value="<?php echo htmlspecialchars($course_paypal_email)?>" /><p> <?php _e('Please enter your paypal bussiness email for individual Course. If you dont enter paypal email here. You must enter paypal email at plugin settings that will be used for default for all payment.','EDULMS');?></p>
							</div>
						</li>
				   </ul>
                   <ul class="form-elements" id="course_custom_payment_url" <?php if($var_cp_course_paid <> 'paid')echo 'style="display: none;"';?>>
						<li class="to-label">
							<label><?php _e('Custom Payment Url','EDULMS');?> </label>
						</li>
						<li class="to-field">
							<div class="input-sec">
                            	<input type="text" name="course_custom_payment_url" value="<?php echo htmlspecialchars($course_custom_payment_url)?>" />
                                <p><?php _e('You can enter custom payment Url where user can pay course price. And you have to enter the member data in members section after payment.','EDULMS');?></p>
							</div>
						</li>
				   </ul>
					<?php if(class_exists('Woocommerce')) {?>
                        <ul class="form-elements" id="var_cp_course_product" <?php if($var_cp_course_paid <> 'paid-with-woocommerce')echo 'style="display: none;"';?> >
                            <li class="to-label"><label><?php _e('Select Product','EDULMS');?></label></li>
                            <li class="to-field">
                            <div class="input-sec">
                                <?php
									$args = array(
										'post_type'  => 'product',
										'meta_key'   => 'cs_select_course',
										'meta_value' => $course_post_id,
										'meta_compare' => '=',
										'order'      => 'ASC'
									);
									$the_query = new WP_Query( $args );
									if ( $the_query->have_posts() ) {
										while ( $the_query->have_posts() ): $the_query->the_post(); 
											echo get_the_title();
										endwhile;
									} else {
										echo __('Please set Course at product page.','EDULMS');	
									}
								?>
                                    <!--<select name="var_cp_course_product">
                                        <option value="">Select ..</option>
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
                                    </select>-->
                                </div>
                            </li>
                        </ul>
                         
					<?php }  else {
							?>
                            <ul class="form-elements" id="woocommerce_plugin_error">
                            	<li class="to-label"><label></label></li>
                                <li class="to-field">
                            		<div class="input-sec"><?php echo __('Woocommerce plugin is required for this option. Please Install Woocommerce.','EDULMS');?></div>
                                </li>
                            </ul>
					<?php				
						}
					?>
                    
                   <ul class="form-elements"  id="course_curriculums_tabs_display" <?php if($var_cp_course_paid == 'registered_user_access' || $var_cp_course_paid == 'free')echo 'style="display: none;"';?>>
						<li class="to-label"><label><?php _e('Curriculums Tabs on/off','EDULMS');?></label></li>
						<li class="to-field has_input">
							<label class="pbwp-checkbox">
								<input type="hidden" name="course_curriculums_tabs_display" value="" />
								<input type="checkbox" name="course_curriculums_tabs_display" value="on" class="myClass" <?php if($course_curriculums_tabs_display=='on')echo "checked"?> />
								<span class="pbwp-box"></span>
							</label>
						</li>
					</ul>
					<ul class="form-elements">
						<li class="to-label">
							<label><?php _e('Course Color','EDULMS');?> </label>
						</li>
						<li class="to-field">
							<div class="input-sec">
								<input type="text" name="course_subheader_bg_color" class="bg_color" value="<?php echo esc_attr($course_subheader_bg_color);?>"  />
							</div>
						</li>
				   </ul>
				<?php
			}
			/**
			* Curriculums Settings
		    */
			public function cs_curriculm_settings(){
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
									<li class="to-label"><label><?php _e('Add Unit','EDULMS');?></label></li>
									<li class="to-button">
										<a href="javascript:_createpop('add_track_title','filter')" class="button"><?php _e('Add Unit Title','EDULMS'); ?></a>
										<a href="javascript:_createpop('add_track_curriculums','filter')" class="button"><?php _e('Add Curriculum','EDULMS'); ?></a>
										<a href="javascript:_createpop('add_track_assigments','filter')" class="button"><?php _e('Add Assignment','EDULMS'); ?></a>
										<a href="javascript:_createpop('add_track_quiz','filter')" class="button"><?php _e('Add Quiz','EDULMS'); ?></a>
									</li>
								</ul>
							</div>
							<!--Section Title Start-->
							<div id="add_track_title" class="poped-up padding-none">
							  <div class="cs-heading-area">
									<h5> <i class="fa fa-plus-circle"></i>
										<?php _e('Course Members Settings','EDULMS');?>
									</h5>
									<span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_title','append')"> <i class="fa fa-times"></i></span>
								</div>
								<ul class="form-elements">
									<li class="to-label"><label><?php _e('Unit Title','EDULMS'); ?></label></li>
									<li class="to-field">
										<input type="text" id="subject_title_dummy" name="subject_title_dummy" value="Unit Title"/>
									</li>
								</ul>
								<ul class="form-elements">
									<li class="to-label"></li>
									<li class="to-field">
										<input type="button" value="<?php _e('Add Unit Title to List','EDULMS'); ?>" onclick="add_subject_to_list('<?php echo esc_js(admin_url('admin-ajax.php'))?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
									</li>
								</ul>
							</div>
							<!--Section Title end-->
							<!--Assignment section Start-->
							<div id="add_track_assigments" class="poped-up padding-none">
								<div class="cs-heading-area">
									<h5> <i class="fa fa-plus-circle"></i>
										<?php _e('Assignment Settings','EDULMS');?>
									</h5>
									<span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_assigments','append')"> <i class="fa fa-times"></i></span>
									<div class="clear"></div>
								</div>
								<ul class="form-elements">
								  <li class="to-label"><label><?php _e('Assignment Title','EDULMS');?></label></li>
									<?php 
										echo '<li class="to-field select-style"><select name="var_cp_assignment_title" id="var_cp_assignment_title">';
												query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-assignments') );
												while (have_posts() ) : the_post(); ?>
												<?php
													echo '<option value="'.get_the_id().'" >'.get_the_title().'</option>';
												 ?>
										<?php endwhile; wp_reset_query();
										echo '</select></li>';
									 ?>
								</ul>
								<?php $allowed_types = get_allowed_mime_types();?>
								<ul class="form-elements">
									<li class="to-label"><label><?php _e('Upload File Format:','EDULMS');?></label></li>
									<li class="to-field">
										<div class="input-sec">
											<select name="var_cp_assigment_type[]" id="var_cp_assigment_type" multiple="multiple" style="min-height:150px;">
												<?php
												foreach($allowed_types as $ext_keys=>$ext_value){
													echo '<option value="'.$ext_value.'">'.$ext_value.'</option>';
												}
												?>
											</select>
											<p><?php _e('Select the Assignment type in which format user upload his assignment.','EDULMS');?></p>
										</div>
									</li>
								 </ul>
								 <ul class="form-elements">
									<li class="to-label">
									  <label><?php _e('File Upload Size:','EDULMS');?></label>
									</li>
									<li class="to-field">
										<div class="input-sec">
											<input type="text" id="assignment_upload_size" name="assignment_upload_size" value="1024" />
                                            <p><?php _e('Upload File Size in MB','EDULMS'); ?></p>
										</div>
									</li>
								  </ul>
								 <ul class="form-elements">
									<li class="to-label">
									  <label><?php _e('Passing Marks','EDULMS');?>(%)</label>
									</li>
									<li class="to-field select-style">
										<select name="assignment_passing_marks" id="assignment_passing_marks">
											<?php for($i = 1; $i<=100; $i++){?>
												<option value="<?php echo absint($i);?>" <?php if($i == 50){echo 'selected="selected"';}?>><?php echo absint($i);?></option>
											<?php }?>
										</select>
									</li>
								  </ul>
								  <ul class="form-elements">
									<li class="to-label">
									  <label><?php _e('Total Marks','EDULMS');?></label>
									</li>
									<li class="to-field">
										<div class="input-sec">
											<input type="text" id="assignment_total_marks" name="assignment_total_marks" value="100" />
										</div>
									</li>
								  </ul>
								  <ul class="form-elements">
									<li class="to-label"><label><?php _e('Extra Retakes','EDULMS');?></label></li>
									<li class="to-field">
										<div class="input-sec">
											<input type="text" id="assignment_retakes_no" name="assignment_retakes_no" value="5" />
										</div>
									</li>
								</ul>
								<ul class="form-elements">
									<li class="to-label"></li>
									<li class="to-field">
										<input type="button" value="Add Assignment to List" onclick="add_assignment_to_list('<?php echo admin_url('admin-ajax.php')?>', '<?php echo get_template_directory_uri()?>')" />
									</li>
								</ul>
							</div>
							<!--Assignment section end-->
							
							<!--Quiz section start-->
							<div id="add_track_quiz" class="poped-up padding-none">
								<div class="cs-heading-area">
									<h5> <i class="fa fa-plus-circle"></i>
										<?php _e('Quiz Settings','EDULMS');?>
									</h5>
									<span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_quiz','append')"> <i class="fa fa-times"></i></span>
									<div class="clear"></div>
								</div>
			  
								 <ul class="form-elements">
								<li class="to-label"><label><?php _e('Select Quiz','EDULMS'); ?></label></li>
									<?php 
									//$forums = get_forums(); ?>
									<?php 
									echo '<li class="to-field select-style"><select name="var_cp_course_quiz" id="var_cp_course_quiz">
											<option value="">None</option>';
											query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'quiz') );
											while (have_posts() ) : the_post(); 
												$cs_quiz_id = get_the_id();
												if($cs_quiz_id=="$var_cp_course_quiz"){
													$selected =' selected="selected"';
												}else{ 
													$selected = '';
												}
												echo '<option value="'.$cs_quiz_id.'" '.$selected.'>'.get_the_title().'</option>';
										 	endwhile;
										 	wp_reset_query();
									echo '</select></li>';
								 ?>
								 </ul>
								 <ul class="form-elements">
									<li class="to-label">
									  <label><?php _e('Passing Marks(%)','EDULMS');?></label>
									</li>
									<li class="to-field select-style">
										<select name="quiz_passing_marks" id="quiz_passing_marks">
											<?php for($i = 1; $i<=100; $i++){?>
												<option value="<?php echo absint($i);?>"><?php echo absint($i);?></option>
											<?php }?>
										</select>
									</li>
								  </ul>
								  <ul class="form-elements">
									<li class="to-label"><label><?php _e('Extra Retakes','EDULMS');?></label></li>
									<li class="to-field">
										<div class="input-sec">
											<input type="text" id="quiz_retakes_no" name="quiz_retakes_no" value="10" />
										</div>
									</li>
								</ul>
								 
								<ul class="form-elements">
									<li class="to-label"></li>
									<li class="to-field">
										<input type="button" value="Add Quiz to List" onclick="add_quiz_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
									</li>
								</ul>
							</div>
							<!--Quiz section end-->
							
							<!--Curriculm section start-->
							<div id="add_track_curriculums" class="poped-up padding-none">
								 <div class="cs-heading-area">
									<h5> <i class="fa fa-plus-circle"></i>
									   <?php _e('Curriculum Settings','EDULMS');?>
									</h5>
									<span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_curriculums','append')"> <i class="fa fa-times"></i></span>
									<div class="clear"></div>
								</div>
								<ul class="form-elements">
								<li class="to-label"><label><?php _e('Select Curriculum','EDULMS'); ?></label></li>
									<?php 
									echo '<li class="to-field select-style"><select name="var_cp_course_curriculum" id="var_cp_course_curriculum">
											<option value="">None</option>';
											query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-curriculums') );
											while (have_posts() ) : the_post();
												$cs_course_curriculum = get_the_id();
												if($cs_course_curriculum=="$var_cp_course_curriculum"){
													$selected =' selected="selected"';
												}else{ 
													$selected = '';
												}
												echo '<option value="'.$cs_course_curriculum.'" '.$selected.'>'.get_the_title().'</option>';
									 		endwhile;
											wp_reset_query();
									echo '</select></li>';
								 ?>
								 </ul>
								<ul class="form-elements">
									<li class="to-label"></li>
									<li class="to-field">
										<input type="button" value="Add Curriculum to List" onclick="add_curriculum_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
									</li>
								</ul>
							</div>
							<!--Curriculm section end-->
							
							<!--Certificate section start--> 
							<div id="add_track_certificate" class="poped-up">
								<div class="opt-head">
									<h5><?php _e('Certificates Settings','EDULMS');?></h5>
									<span class="cs-btnclose" onclick="javascript:removeoverlay('add_track_certificate','append')"> <i class="fa fa-times"></i></span>
									<div class="clear"></div>
								</div>                        
								<ul class="form-elements">
								<li class="to-label select-style"><label><?php _e('Select Certificate','EDULMS'); ?></label></li>
									<?php 
									echo '<select name="var_cp_course_certificate" id="var_cp_course_certificate">
											<option value="">'.__('None','EDULMS').'</option>';
											query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-certificates') );
											while (have_posts() ) : the_post();
												$cs_certificate_id = get_the_id();
												if($cs_certificate_id=="$var_cp_course_certificate"){
													$selected =' selected="selected"';
												}else{ 
													$selected = '';
												}
												echo '<option value="'.$cs_certificate_id.'" '.$selected.'>'.get_the_title().'</option>';
											endwhile;
											wp_reset_query();
									echo '</select>';
								 ?>
								 </ul>
								<ul class="form-elements">
									<li class="to-label"></li>
									<li class="to-field">
										<input type="button" value="Add Certificate to List" onclick="add_certificate_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />                            </li>
								</ul>
							</div>
						   <!--Certificate section end-->
							<!--Diplay all Curriculm Listings--> 
							<div class="cs-list-table">
								<table class="to-table" border="0" cellspacing="0">
								<thead>
									<tr>
										<th style="width:80%;"><?php _e('Title','EDULMS');?></th>
										<th style="width:80%;" class="centr"><?php _e('Actions','EDULMS');?></th>
									</tr>
								</thead>
								<tbody id="total_tracks">
									<?php
										global $counter_subject, $subject_title, $assignment_id, $var_cp_course_curriculum,$var_cp_course_quiz_list,$quiz_passing_marks,$quiz_retakes_no,$var_cp_course_certificate,$counter_subject,$counter_certificate,$counter_curriculum, $var_cp_course_curriculum ,$counter_assignment,$counter_quiz,$counter_subject, $var_cp_assignment_title, $var_cp_assignment_description, $assignment_total_marks, $var_cp_assigment_type, $assignment_upload_size,$assignment_passing_marks, $assignment_retakes_no;
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
														$this->cs_add_assignment_to_list();
													} else if($listing_type == 'certificate'){
														$var_cp_course_certificate = $curriculm->var_cp_course_certificate;
														$this->cs_add_certificate_to_list();
													} else if($listing_type == 'title'){
														$subject_title = $curriculm->subject_title;
														$this->cs_add_subject_to_list();
													} else if($listing_type == 'quiz' && isset($cs_lms) && $cs_lms == 'installed'){
													
														$quiz_passing_marks = $curriculm->quiz_passing_marks;
														$quiz_retakes_no = $curriculm->quiz_retakes_no;
														$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
														$this->cs_add_quiz_to_list();
														
													} else if($listing_type == 'curriculum'){
														$var_cp_course_curriculum = $curriculm->var_cp_course_curriculum;
														$this->cs_add_curriculum_to_list();
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
			/**
			* Course Meta option save
		    */
			public function cs_meta_course_save( $post_id ){  
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
					 
					if ( empty($cs_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = $cs_xmlObject->course_short_description;
					if ( empty($cs_xmlObject->course_related) ) $course_related = ""; else $course_related = $cs_xmlObject->course_related;
					if ( empty($cs_xmlObject->course_related_title) ) $course_related_title = ""; else $course_related_title = $cs_xmlObject->course_related_title;
					if ( empty($cs_xmlObject->var_cp_course_product) ) $var_cp_course_product = ""; else $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
					 
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
					if ( empty($_POST["cs_course_certificate_assign"]) ) $_POST["cs_course_certificate_assign"] = "";
					if ( empty($_POST["cs_course_certificate"]) ) $_POST["cs_course_certificate"] = "";
					if ( empty($_POST["course_related_title"]) ) $_POST["course_related_title"] = "";
					if ( empty($_POST["course_paid_price"]) ) $_POST["course_paid_price"] = "";
					if ( empty($_POST["course_paypal_email"]) ) $_POST["course_paypal_email"] = "";
					if ( empty($_POST["course_custom_payment_url"]) ) $_POST["course_custom_payment_url"] = "";
					if ( empty($_POST["course_curriculums_tabs_display"]) ) $_POST["course_curriculums_tabs_display"] = "";
					
					$course_instructor = '';
					$var_cp_course_instructor = (int)$_POST["var_cp_course_instructor"];
					if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
						$user_info = get_userdata($var_cp_course_instructor);
						$course_instructor = $user_info->display_name;
					}
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
 					$sxe->addChild('course_curriculm_section_display', $_POST['course_curriculm_section_display']);
					$sxe->addChild('course_events_section_display', $_POST['course_events_section_display']);
					$sxe->addChild('course_members_section_display', $_POST['course_members_section_display']);
					$sxe->addChild('course_breif_section_display', $_POST['course_breif_section_display']);
					$sxe->addChild('course_reviews_section_display', $_POST['course_reviews_section_display']);
					$sxe->addChild('dynamic_post_faq_display', htmlspecialchars($_POST['dynamic_post_faq_display']));
					$sxe->addChild('cs_course_badge',  htmlspecialchars($_POST['cs_course_badge']));
					$sxe->addChild('cs_course_badge_assign',  htmlspecialchars($_POST['cs_course_badge_assign']));
					$sxe->addChild('cs_course_certificate_assign',  htmlspecialchars($_POST['cs_course_certificate_assign']));
					$sxe->addChild('cs_course_certificate',  htmlspecialchars($_POST['cs_course_certificate']));
					$sxe->addChild('course_paid_price',  htmlspecialchars($_POST['course_paid_price']));
					$sxe->addChild('course_paypal_email',  htmlspecialchars($_POST['course_paypal_email']));
					$sxe->addChild('course_custom_payment_url',  htmlspecialchars($_POST['course_custom_payment_url']));
					
					$sxe->addChild('course_curriculums_tabs_display',  htmlspecialchars($_POST['course_curriculums_tabs_display']));
					
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
					if ( function_exists( 'cs_page_options_save_xml' ) ) {
						$sxe = cs_page_options_save_xml($sxe);
					}
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

			/**
			 * @Course Members Section
			 */
			public function cs_course_members_section($course_post_id){
				global $post;
				?>
				 <input type="hidden" name="dynamic_post_course_members" value="1" />
				 <ul class="form-elements">
					<li class="to-label"><?php _e('Add Members','EDULMS');?></li>
					<li class="to-button"><a href="javascript:_createpop('add_course_members','filter')" class="button"><?php _e('Add Members','EDULMS');?></a></li>
				</ul>
				<script>
				jQuery(document).ready(function($) {
					$("#total_course_members").sortable({
						cancel : 'td div.table-form-elem'
					});
				});
				</script>
			   <div class="cs-list-table">	
					<table class="to-table" border="0" cellspacing="0">
						<thead>
							<tr>
								<th style="width:40%;"><?php _e('Title','EDULMS');?></th>
								<th style="width:20%;"><?php _e('Order Id','EDULMS');?></th>
								<th style="width:20%;"><?php _e('Transaction Id','EDULMS');?></th>
								<th style="width:80%;" class="centr"><?php _e('Actions','EDULMS');?></th>
								<th style="width:0%;" class="centr"></th>
							</tr>
						</thead>
						<tbody id="total_course_members">
							<?php
								global $counter_members, $course_user_id, $course_user_email, $transaction_id, $order_id, $course_instructor, $course_title, $course_title, $course_price, $course_id, $user_display_name, $register_date, $expiry_date, $result, $payment_method_title, $payment_status, $remarks, $disable;
								$counter_members = $course_post_id;
								$user_course_data = get_option($course_post_id."_cs_user_course_data", true);
								if ( isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0) {
									foreach ( $user_course_data as $members ){
										$payment_method_title = 'Direct Bank Transfer';
										$payment_status = 'pending';
										 $course_user_id = $members['user_id'];
										 if(isset($course_user_id) && $course_user_id <> ''){
											 $course_id = $members['course_id'];
											 $transaction_id = $members['transaction_id'];
											 if(isset($members['order_id']))
												$order_id = $members['order_id'];
											 else 
												$order_id = '';
											 if(isset($members['course_user_email']))
												$course_user_email = $members['course_user_email'];
											 else 
												$course_user_email = '';
											if(isset($members['user_display_name']))
												$user_display_name = $members['user_display_name'];
											 else 
												$user_display_name = '';
											if(isset($members['course_title']))
												$course_title = $members['course_title'];
											 else 
												$course_title = '';
											if(isset($members['course_price']))
												$course_price = $members['course_price'];
											 else 
												$course_price = '';
											 $course_instructor = $members['course_instructor'];
											 $register_date = $members['register_date'];
											 $expiry_date = $members['expiry_date'];
											 $result = $members['result'];
											 $remarks = $members['remarks'];
											 if(isset($members['payment_method_title']))
												$payment_method_title = $members['payment_method_title'];
											 if(isset($members['payment_status']))
												 $payment_status = $members['payment_status'];
											 $disable = $members['disable'];
											 cs_add_course_members_to_list();
											 $counter_members++;
										 }
									}
								}
							?>
						</tbody>
					</table>
			   </div>
			   <div id="add_course_members" style="display: none;">
						<div class="cs-heading-area">
							<h5> <i class="fa fa-plus-circle"></i>
								<?php _e('Course Members Settings','EDULMS');?>
							</h5>
							<span class="cs-btnclose" onclick="javascript:removeoverlay('add_course_members','append')"> <i class="fa fa-times"></i></span>
						</div>
                        <script>
							jQuery(document).ready(function () { 
								jQuery(document).on('click', '#register_date', function () {
									jQuery(this).datetimepicker({
										format:'Y-m-d H:i',
										formatTime:'H:i',
										step:30,  
									});
								});
								
								jQuery(document).on('click', '#expiry_date', function () {
									jQuery(this).datetimepicker({
										format:'Y-m-d H:i',
										formatTime:'H:i',
										step:30,
										onShow:function( ct ){
											this.setOptions({
												minDate:jQuery('#register_date').val()?jQuery('#register_date').val():false
											})
										},
									});
								});
							});
						</script>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('User Name','EDULMS');?></label></li>
							<li class="to-field select-style">
								 <?php
									$blogusers = get_users('orderby=nicename');
									echo '<select name="course_user_id" id="course_user_id">
											<option value="">'.__('None','EDULMS').'</option>';
											  foreach ($blogusers as $user) {
												if($user->ID=="$course_user_id"){
													$selected =' selected="selected"';
												}else{ 
													$selected = '';
												}
												echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
											 
											}
									echo '</select>';
								 ?>
							</li>
						</ul>
						<input type="hidden" id="course_id" name="course_id" value="<?php echo esc_attr($course_post_id);?>" />
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Order Id','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="order_id" name="order_id" value="<?php echo esc_attr($order_id);?>" />
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Course Price','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="course_price" name="course_price" value="<?php echo esc_attr($course_price);?>" />
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Registeration Date','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="register_date" name="register_date" value="<?php echo esc_attr($register_date);?>" />
								<p><?php _e('Date Format: 2014-10-22 13:44','EDULMS');?></p>
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Expiry Date','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="expiry_date" name="expiry_date" value="<?php echo esc_attr($expiry_date);?>" />
								<p><?php _e('Date Format: 2015-10-22 13:44','EDULMS');?></p>
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Result','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="result" name="result" value="" />
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Remarks','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="remarks" name="remarks" value="" />
							</li>
						</ul>
						
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Payment Method Title','EDULMS');?></label></li>
							<li class="to-field">
								<input type="text" id="payment_method_title" name="payment_method_title" value="" />
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('Payment Status','EDULMS');?></label></li>
							<li class="to-field select-style">
								<select name="payment_status" id="payment_status">
									<option value="completed"><?php _e('Completed','EDULMS');?></option>
									<option value="Pending"><?php _e('Pending','EDULMS');?></option>
									<option value="Processing"><?php _e('Processing','EDULMS');?></option>
									<option value="on-hold"><?php _e('On-Hold','EDULMS');?></option>
									<option value="cancelled"><?php _e('Cancelled','EDULMS');?></option>
									<option value="refunded"><?php _e('Refunded','EDULMS');?></option>
									<option value="Failed"><?php _e('Failed','EDULMS');?></option>
								</select>
							</li>
						</ul>
						<ul class="form-elements">
							<li class="to-label"><label><?php _e('User Course Status','EDULMS');?></label></li>
							<li class="to-field select-style">
								<select name="disable" id="disable">
									<option value="0"><?php _e('Approved','EDULMS');?></option>
									<option value="1"><?php _e('Pending','EDULMS');?></option>
									<option value="2"><?php _e('Disable','EDULMS');?></option>
									<option value="3"><?php _e('Completed','EDULMS');?></option>
                                    <option value="4"><?php _e('Expired','EDULMS');?></option>
								</select>
							</li>
						</ul>
						<ul class="form-elements noborder">
							<li class="to-label"></li>
							<li class="to-field">
								<input type="button" value="<?php _e('Add Course Member to List','EDULMS');?>" onclick="add_course_member_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
							</li>
						</ul>
	
					</div>
				<?php
			}
			/**
			 * @Add Course Subject To List
			 */
			public function cs_add_subject_to_list(){
				global $counter_subject, $subject_title;
				foreach ($_POST as $keys=>$values) {
					$$keys = $values;
				}
				?>
				<tr class="parentdelete color-title" id="edit_track<?php echo (int)$counter_subject?>">
				  <td id="subject-title<?php echo absint($counter_subject);?>" style="width:80%;"><h4><?php echo esc_attr($subject_title)?></h4></td>
				  <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_form<?php echo (int)$counter_subject?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
					<input type="hidden" name="listing_type[]" value="title" />
					<div class="poped-up padding-none" id="edit_track_form<?php echo (int)$counter_subject?>">
					  <div class="cs-heading-area">
						<h5><i class="fa fa-plus-circle"></i> <?php _e('Section Title Settings','EDULMS');?></h5>
						<span onclick="javascript:removeoverlay('edit_track_form<?php echo absint($counter_subject);?>','append')" class="closeit cs-btnclose"><i class="fa fa-times"></i></span>
						<div class="clear"></div>
					  </div>
					  <ul class="form-elements">
						<li class="to-label">
						  <label><?php _e('Section Title','EDULMS');?></label>
						</li>
						<li class="to-field">
						  <input type="text" name="subject_title_array[]" value="<?php echo htmlspecialchars($subject_title)?>" id="subject_track_title<?php echo absint($counter_subject)?>" />
						  <p><?php _e('Put Section title','EDULMS');?></p>
						</li>
					  </ul>
					  <ul class="form-elements noborder">
						<li class="to-label">
						  <label></label>
						</li>
						<li class="to-field">
						  <input type="button" value="><?php _e('Update Subject','EDULMS');?>" onclick="update_title(<?php echo absint($counter_subject)?>); removeoverlay('edit_track_form<?php echo absint($counter_subject)?>','append')" />
						</li>
					  </ul>
					</div></td>
				</tr>
				<?php
				if ( isset($action) ) die();
			}
			/**
			 * @Add Course Quize To List
			 */
			public function cs_add_quiz_to_list(){
					global $counter_quiz, $var_cp_course_quiz_list, $quiz_retakes_no, $quiz_passing_marks, $var_cp_course_quiz_type;
					foreach ($_POST as $keys=>$values) {
						$$keys = $values;
					}
					?>
                    <tr class="parentdelete" id="edit_track<?php echo absint($counter_quiz);?>">
                      <td id="var_cp_course_quiz<?php echo absint($counter_quiz);?>" style="width:80%;"><?php echo get_the_title((int)$var_cp_course_quiz_list);?></td>
                      <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_quiz<?php echo absint($counter_quiz)?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
                        <div class="poped-up padding-none" id="edit_track_quiz<?php echo absint($counter_quiz)?>">
                          <div class="cs-heading-area">
                            <h5><i class="fa fa-plus-circle"></i> <?php _e('Quiz Settings','EDULMS'); ?></h5>
                            <span onclick="javascript:removeoverlay('edit_track_quiz<?php echo absint($counter_quiz)?>','append')" class="closeit cs-btnclose"> <i class="fa fa-times"></i></span>
                            <div class="clear"></div>
                          </div>
                          <input type="hidden" name="listing_type[]" value="quiz" />
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Quiz Title','EDULMS'); ?></label>
                            </li>
                            <li class="to-field select-style">
                              <?php 
                                echo '<select name="var_cp_course_quiz_array[]" id="var_cp_course_quiz'.$counter_quiz.'">
                                        <option value="">'.__('None','EDULMS').'</option>';
                                        query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'quiz') );
                                        while (have_posts() ) : the_post(); 
											$cs_quiz_id = get_the_id();
											if($cs_quiz_id==(int)$var_cp_course_quiz_list){
												$selected =' selected="selected"';
											}else{ 
												$selected = '';
											}
											echo '<option value="'.$cs_quiz_id.'" '.$selected.'>'.get_the_title().'</option>';
                                        endwhile;
                                        wp_reset_query();
                                 echo '</select>';
                             ?>
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Passing Marks(%)','EDULMS'); ?></label>
                            </li>
                            <li class="to-field select-style">
                                 <select name="quiz_passing_marks_array[]" id="quiz_passing_marks<?php echo absint($counter_quiz)?>">
                                    <?php for($i = 1; $i<=100; $i++){?>
                                        <option value="<?php echo absint($i);?>" <?php if($quiz_passing_marks == $i){echo 'selected="selected"';}?>><?php echo absint($i);?></option>
                                    <?php }?>
                                </select>
                          
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Number of Extra Quiz Retakes','EDULMS'); ?></label></li>
                            <li class="to-field">
                                <div class="input-sec">
                                  <input type="text" name="quiz_retakes_no_array[]" id="quiz_retakes_no<?php echo absint($counter_quiz);?>" value="<?php echo absint($quiz_retakes_no)?>" />
                                </div>
                            </li>
                          </ul>
                          <ul class="form-elements noborder">
                            <li class="to-label">
                              <label></label>
                            </li>
                            <li class="to-field">
                              <input type="button" value="<?php _e('Update Quiz','EDULMS'); ?>" onclick="update_title(<?php echo absint($counter_quiz)?>); removeoverlay('edit_track_quiz<?php echo absint($counter_quiz)?>','append')" />
                            </li>
                          </ul>
                        </div></td>
                    </tr>
			<?php
					if ( isset($action) ) die();

				
			}
			/**
			 * @Add Course Assignment To list
			 */
			public function cs_add_assignment_to_list(){
				global $post,$counter_assignment, $assignment_id, $var_cp_assignment_title, $var_cp_assignment_description, $assignment_total_marks, $assignment_upload_size, $var_cp_assigment_type, $assignment_passing_marks, $assignment_retakes_no;
				foreach ($_POST as $keys=>$values) {
					$$keys = $values;
				}
				if(isset($_POST['var_cp_assignment_title']) && $_POST['var_cp_assignment_title'] <> ''){
					$assignment_id = time();
				}
				if(empty($assignment_id)){
					$assignment_id = $counter_assignment;
				}
				?>
                <tr class="parentdelete" id="edit_track<?php echo absint($counter_assignment);?>">
                  <td id="var_cp_course_assignment<?php echo absint($counter_assignment); ?>" style="width:80%;"><?php if($var_cp_assignment_title != ''){echo get_the_title((int)$var_cp_assignment_title);}?></td>
                  <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_assignment<?php echo absint($counter_assignment);?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
                    <div class="poped-up padding-none" id="edit_track_assignment<?php echo absint($counter_assignment);?>">
                      <div class="cs-heading-area">
                        <h5><i class="fa fa-plus-circle"></i> <?php _e('Assignment Settings','EDULMS'); ?></h5>
                        <span onclick="javascript:removeoverlay('edit_track_assignment<?php echo absint($counter_assignment);?>','append')" class="closeit cs-btnclose"> <i class="fa fa-times"></i></span>
                        <div class="clear"></div>
                      </div>
                      <input type="hidden" name="listing_type[]" value="assigment" />
                      <input type="hidden" name="assignment_id[]" value="<?php echo absint($assignment_id);?>"  />
                       <ul class="form-elements">
                          <li class="to-label"><label><?php _e('Assignment Title','EDULMS'); ?></label></li>
                          <li class="to-field">
                            <div class="input-sec">
                                 <?php 
                                    echo '<select name="var_cp_assignment_title_array[]" id="var_cp_assignment_title'.$counter_assignment.'">';
                                            query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-assignments') );
                                            while (have_posts() ) : the_post(); 
                                            
                                            $cs_assignment_id = get_the_id();
                                            if($cs_assignment_id==(int)$var_cp_assignment_title){
                                                    $selected =' selected="selected"';
                                                }else{ 
                                                    $selected = '';
                                                }
                                            echo '<option value="'.$cs_assignment_id.'" '.$selected.'>'.get_the_title().'</option>';
                                            endwhile;
                                            wp_reset_query();
                                     echo '</select>';
                                 ?>
                            </div>
                          </li>
                        </ul>
                      <?php
                        $allowed_types = get_allowed_mime_types();
                        if(!is_array($var_cp_assigment_type)){
                            $var_cp_assigment_type = explode(',', $var_cp_assigment_type);
                        }
                      ?>
                      <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Upload File Format','EDULMS');?>:</label></li>
                        <li class="to-field">
                            <div class="input-sec">
                                <select name="var_cp_assigment_type_array[<?php echo absint($assignment_id);?>][]" id="var_cp_assigment_type<?php echo absint( $counter_assignment );?>" class="gllpSearchButton" multiple="multiple" style="min-height:150px;">
                                    <?php
                                    foreach($allowed_types as $ext_keys=>$ext_value){
                                        $selected_value = '';
                                        if(in_array($ext_value, $var_cp_assigment_type)){$selected_value = 'selected';}
                                        echo '<option value="'.$ext_value.'" '.$selected_value.'>'.$ext_value.'</option>';
                                    }
                                    ?>
                                </select>
                                <p><?php _e('Select the Assignment type in which format user upload his assignment.', 'EDULMS');?></p>
                            </div>
                        </li>
                     </ul>
                     <ul class="form-elements">
                        <li class="to-label">
                          <label><?php _e('Upload Size','EDULMS'); ?></label>
                        </li>
                        <li class="to-field">
                             <div class="input-sec">
                              <input type="text" name="assignment_upload_size_array[]" id="assignment_upload_size<?php echo absint($counter_assignment);?>" value="<?php echo esc_attr($assignment_upload_size);?>" />
                              <p><?php _e('Upload File Size in MB','EDULMS'); ?></p>
                            </div>
                        </li>
                      </ul>
                      <ul class="form-elements">
                        <li class="to-label">
                          <label><?php _e('Passing Marks(%)', 'EDULMS');?></label>
                        </li>
                        <li class="to-field">
                            <select name="assignment_passing_marks_array[]" id="assignment_passing_marks<?php echo absint($counter_assignment);?>">
                                <?php for($i = 1; $i<=100; $i++){?>
                                    <option value="<?php echo absint($i);;?>" <?php if($i == $assignment_passing_marks){echo 'selected="selected"';}?>><?php echo absint($i);?></option>
                                <?php }?>
                            </select>
                        </li>
                      </ul>
                      <ul class="form-elements">
                        <li class="to-label">
                          <label><?php _e('Total Marks', 'EDULMS');?></label>
                        </li>
                        <li class="to-field">
                             <div class="input-sec">
                              <input type="text" name="assignment_total_marks_array[]" id="assignment_total_marks<?php echo absint($counter_assignment);?>" value="<?php echo absint($assignment_total_marks)?>" />
                            </div>
                        </li>
                      </ul>
                      <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Number of Extra Assignment Retakes', 'EDULMS');?></label></li>
                        <li class="to-field">
                             <div class="input-sec">
                              <input type="text" name="assignment_retakes_no_array[]" id="assignment_retakes_no<?php echo absint($counter_assignment)?>" value="<?php echo absint($assignment_retakes_no)?>" />
                            </div>
                        </li>
                      </ul>
                      <ul class="form-elements noborder">
                        <li class="to-label">
                          <label></label>
                        </li>
                        <li class="to-field">
                          <input type="button" value="<?php _e('Update Assignment', 'EDULMS');?>" onclick="update_title(<?php echo absint($counter_assignment)?>); removeoverlay('edit_track_assignment<?php echo absint($counter_assignment)?>','append')" />
                        </li>
                      </ul>
                    </div></td>
                </tr>
	<?php
		if ( isset($action) ) die();
	}
			/**
			 * @Add Course Curriculums To List
			*/
			public function cs_add_curriculum_to_list(){
				global $counter_curriculum, $var_cp_course_curriculum;
				foreach ($_POST as $keys=>$values) {
					$$keys = $values;
				}
				?>
				<tr class="parentdelete" id="edit_track<?php echo absint($counter_curriculum);?>">
				  <td id="var_cp_course_curriculum<?php echo absint($counter_curriculum);?>" style="width:80%;"><?php if($var_cp_course_curriculum != ''){echo get_the_title((int)$var_cp_course_curriculum);}?></td>
				  <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_curriculum<?php echo absint($counter_curriculum);?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
					<div class="poped-up padding-none" id="edit_track_curriculum<?php echo absint($counter_curriculum);?>">
					  <div class="cs-heading-area">
						<h5><i class="fa fa-plus-circle"></i> <?php _e('Curriculum Settings', 'EDULMS');?></h5>
						<span onclick="javascript:removeoverlay('edit_track_curriculum<?php echo absint($counter_curriculum);?>','append')" class="closeit cs-btnclose"><i class="fa fa-times"></i></span>
						<div class="clear"></div>
					  </div>
					  <input type="hidden" name="listing_type[]" value="curriculum" />
					  <ul class="form-elements">
						<li class="to-label">
						  <label><?php _e('Curriculum','EDULMS');?></label>
						</li>
						<li class="to-field select-style">
						  <?php 
							echo '<select name="var_cp_course_curriculum_array[]" id="var_cp_course_curriculum'.$counter_curriculum.'">
									<option value="">None</option>';
									query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-curriculums') );
									while (have_posts() ) : the_post(); 
									$cs_curriculum_id = get_the_id();
									if($cs_curriculum_id==$var_cp_course_curriculum){
										$selected =' selected="selected"';
									}else{ 
										$selected = '';
									}
									echo '<option value="'.$cs_curriculum_id.'" '.$selected.'>'.get_the_title().'</option>';
									endwhile;
									wp_reset_query();
							echo '</select>';
						 ?>
						</li>
					  </ul>
					  <ul class="form-elements noborder">
						<li class="to-label">
						  <label></label>
						</li>
						<li class="to-field">
						  <input type="button" value="<?php _e('Update Curriculum','EDULMS');?>" onclick="update_title(<?php echo absint($counter_curriculum);?>); removeoverlay('edit_track_curriculum<?php echo absint($counter_curriculum);?>','append')" />
						</li>
					  </ul>
					</div></td>
				</tr>
				<?php
				if ( isset($action) ) die();
			}
			/**
			 * @Add Certificate To List
			*/
			public function cs_add_certificate_to_list(){
				global $counter_certificate, $var_cp_course_certificate;
				foreach ($_POST as $keys=>$values) {
					$$keys = $values;
				}
				?>
					<tr class="parentdelete" id="edit_track<?php echo absint($counter_certificate);?>">
					  <td id="var_cp_course_certificate<?php echo absint($counter_certificate);?>" style="width:80%;"><?php echo get_the_title((int)$var_cp_course_certificate);?></td>
					  <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_certificate<?php echo absint($counter_certificate);?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
						<div class="poped-up" id="edit_track_certificate<?php echo absint($counter_certificate);?>">
						  <div class="cs-heading-area">
							<h5><?php _e('Certificate Settings', 'EDULMS');?></h5>
							<a href="javascript:removeoverlay('edit_track_certificate<?php echo absint($counter_certificate);?>','append')" class="closeit">&nbsp;</a>
							<div class="clear"></div>
						  </div>
						  <input type="hidden" name="listing_type[]" value="certificate" />
						  <ul class="form-elements">
							<li class="to-label">
							  <label><?php _e('Certificate', 'EDULMS');?></label>
							</li>
							<li class="to-field select-style">
							  <?php 
									echo '<select name="var_cp_course_certificate_array[]" id="var_cp_course_certificate'.$counter_certificate.'">
											<option value="">None</option>';
											query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'cs-certificates') );
											while (have_posts() ) : the_post(); 
											$cs_certificate_id = get_the_id();
											if($cs_certificate_id==(int)$var_cp_course_certificate){
													$selected =' selected="selected"';
												}else{ 
													$selected = '';
												}
											echo '<option value="'.$cs_certificate_id.'" '.$selected.'>'.get_the_title().'</option>';
											endwhile;
											wp_reset_query();
									echo '</select>';
								 ?>
							  <p><?php _e('Put Certificate', 'EDULMS');?></p>
							</li>
						  </ul>
						  <ul class="form-elements noborder">
							<li class="to-label">
							  <label></label>
							</li>
							<li class="to-field">
							  <input type="button" value="<?php _e('Update Certificate', 'EDULMS');?>" onclick="update_title(<?php echo absint($counter_certificate);?>); removeoverlay('edit_track_certificate<?php echo absint($counter_certificate);?>','append')" />
							</li>
						  </ul>
						</div></td>
					</tr>
					<?php
				if ( isset($action) ) die();
			}
		} // END class
	}