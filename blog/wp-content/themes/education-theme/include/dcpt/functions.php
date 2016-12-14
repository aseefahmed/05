<?php
// Event Custom Fields
if ( ! function_exists( 'cs_cusotm_post_event_fields' ) ) {
	function cs_cusotm_post_event_fields(){
		global $post,$cs_xmlObject;
		$dynamic_post_event_from_date = '';
		$event_organizer = array();
		$post_meta = get_post_meta($post->ID, "dynamic_cusotm_post", true);
		if ( $post_meta <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_meta);
			$dynamic_post_event_from_date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);
			if(isset($cs_xmlObject->dynamic_post_event_all_day)){ $dynamic_post_event_all_day = $cs_xmlObject->dynamic_post_event_all_day;} else {$dynamic_post_event_all_day = '';}
		} else {
			$dynamic_post_event_all_day = '';
			$dynamic_post_event_from_date = '';
		}
		$event_organizer = array();
		if(isset($cs_xmlObject->event_organizer))
		$event_organizer = $cs_xmlObject->event_organizer;
		if ($event_organizer){
			$event_organizer = explode(",", $event_organizer);
		}
			
		cs_enqueue_timepicker_script();
		?>
<script type="text/javascript" src="<?php echo esc_js(get_template_directory_uri().'/include/assets/scripts/ui_multiselect.js');?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo esc_js(get_template_directory_uri().'/include/assets/css/jquery_ui.css');?>" />
<link type="text/css" rel="stylesheet"  href="<?php echo esc_js(get_template_directory_uri().'/include/assets/css/ui_multiselect.css');?>" />
<link type="text/css" rel="stylesheet"  href="<?php echo esc_js(get_template_directory_uri().'/include/assets/css/common.css');?>" />
		<script type="text/javascript">
			jQuery(function($){
				jQuery(".multiselect").multiselect();
			//	jQuery('#switcher').themeswitcher();
			});
		</script>
	<script>
				 jQuery(function(){
				 jQuery('#dynamic_post_event_start_time').datetimepicker({
				  datepicker:false,
						format:'H:i',
						formatTime: 'H:i',
						step:30,
				  onSgow:function( at ){
				   this.setOptions({
					maxTime:jQuery('#dynamic_post_event_end_time').val()?jQuery('#dynamic_post_event_end_time').val():false
				   })
				  }
				 });
				 jQuery('#dynamic_post_event_end_time').datetimepicker({
					datepicker:false,
						format:'H:i',
						formatTime: 'H:i',
						step:30,
				  onShow:function( at ){
				   this.setOptions({
					minTime:jQuery('#dynamic_post_event_start_time').val()?jQuery('#dynamic_post_event_start_time').val():false
				   })
				  }
				 });
				 jQuery('#from_date').datetimepicker({
				  format:'Y/m/d',
				  onShow:function( ct ){
				   this.setOptions({
					maxDate:jQuery('#to_date').val()?jQuery('#to_date').val():false
				   })
				  },
				  timepicker:false
				 });
				 jQuery('#to_date').datetimepicker({
				  format:'Y/m/d',
				  onShow:function( ct ){
				   this.setOptions({
					minDate:jQuery('#from_date').val()?jQuery('#from_date').val():false
				   })
				  },
				  timepicker:false
				 });
				});
			</script>
	
	<div class="clear"></div>
	<ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Event Date','LMS');?></label>
	  </li>
	  <li class="to-field short-field">
		<input type="text" id="from_date" name="dynamic_post_event_from_date" value="<?php if(isset($dynamic_post_event_from_date) && $dynamic_post_event_from_date=='') echo gmdate("Y/m/d"); else echo esc_attr($dynamic_post_event_from_date); ?>" />
	  </li>
 
	</ul>
	<ul class="form-elements event-day bcevent_title">
	  <li class="to-label">
		<label><?php _e('Event Time','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div id="event_time" <?php /*?><?php if($dynamic_post_event_all_day=='on')echo 'style="display:none"'?><?php */?>>
		  <div class="input-sec">
			<input id="dynamic_post_event_start_time" name="dynamic_post_event_start_time" value="<?php if(isset($cs_xmlObject->dynamic_post_event_start_time)){echo esc_attr($cs_xmlObject->dynamic_post_event_start_time);} else { echo date('H:i');}?>" type="text" class="vsmall" />
			<label class="first-label"><?php _e('Start time','LMS');?></label>
		  </div>
		  <!--<span class="short">To</span>-->
		  <div class="input-sec">
			<input id="dynamic_post_event_end_time" name="dynamic_post_event_end_time" value="<?php if(isset($cs_xmlObject->dynamic_post_event_start_time)){echo esc_attr($cs_xmlObject->dynamic_post_event_end_time);} else { echo date('H:i');}?>" type="text" class="vsmall"  />
			<label class="sec-label"><?php _e('End time','LMS');?></label>
		  </div>
		  <div class="input-sec">
			<div class="checkbox-list">
			  <div class="checkbox-item">
				<input type="checkbox" name="dynamic_post_event_all_day" value="on" <?php if(isset($cs_xmlObject->dynamic_post_event_all_day) && $cs_xmlObject->dynamic_post_event_all_day == 'on'){echo "checked";}?>  class="styled" />
			  </div>
			</div>
			<label><?php _e('All Day','LMS');?></label>
		  </div>
		</div>
	  </li>
	</ul>
	<?php if ( empty( $_GET['post']) ) {?>
	<ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Repeat','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="dynamic_post_event_repeat" class="dropdown" onchange="toggle_with_value('num_repeat', this.value)">
			  <option value="0"><?php _e('-- Never Repeat --','LMS');?></option>
			  <option value="+1 day"><?php _e('Every Day','LMS');?></option>
			  <option value="+1 week"><?php _e('Every Week','LMS');?></option>
			  <option value="+1 month"><?php _e('Every Month','LMS');?></option>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<ul class="form-elements" id="num_repeat" style="display:none">
	  <li class="to-label">
		<label><?php _e('Repeat how many time','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="dynamic_post_event_num_repeat" class="dropdown">
			  <?php for ( $i = 1; $i <= 25; $i++ ) {?>
			  <option><?php echo absint($i)?></option>
			  <?php }?>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php }?>
	<div class="clear"></div>
	<ul class="form-elements bcevent_title">
	  <li class="to-label">
		<label><?php _e('Ticket Option','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" id="dynamic_post_event_ticket_options" name="dynamic_post_event_ticket_options" value="<?php if(isset($cs_xmlObject->dynamic_post_event_ticket_options)){echo esc_attr($cs_xmlObject->dynamic_post_event_ticket_options);}?>" />
		  <label><?php _e('Title','LMS');?></label>
		</div>
		<div class="input-sec">
		  <input type="text" id="dynamic_post_event_buy_now" name="dynamic_post_event_buy_now" value="<?php if(isset($cs_xmlObject->dynamic_post_event_buy_now)){echo esc_attr($cs_xmlObject->dynamic_post_event_buy_now);}?>" />
		  <label>Url</label>
		</div>
		<div class="input-sec">
		  <input type="text" name="dynamic_post_event_ticket_color" value="<?php if(isset($cs_xmlObject->dynamic_post_event_ticket_color)){echo esc_attr($cs_xmlObject->dynamic_post_event_ticket_color);}?>" class="bg_color" />
		  <label><?php _e('Color','LMS');?></label>
		</div>
	  </li>
	</ul><div class="clear"></div>
    
    <ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Contact No','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" id="dynamic_post_event_contact_no" name="dynamic_post_event_contact_no" value="<?php if(isset($cs_xmlObject->dynamic_post_event_contact_no)){echo esc_attr($cs_xmlObject->dynamic_post_event_contact_no);}?>" />
	
		</div>
	  </li>
	</ul>
    
	<div class="clear"></div>
    <ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Email','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" id="dynamic_post_event_email" name="dynamic_post_event_email" value="<?php if(isset($cs_xmlObject->dynamic_post_event_email)){echo esc_attr($cs_xmlObject->dynamic_post_event_email);}?>" />
		</div>
	  </li>
	</ul>
	<div class="clear"></div>
	<ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Event Detail','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="dynamic_post_event_content_view" id="dynamic_post_event_content_view" >
			  <option value="in_post" <?php if(isset($cs_xmlObject->dynamic_post_event_content_view) && $cs_xmlObject->dynamic_post_event_content_view == 'in_post'){echo 'selected="selected"';}?>><?php _e('In Post','LMS');?></option>
			  <option value="none" <?php if(isset($cs_xmlObject->dynamic_post_event_content_view) && $cs_xmlObject->dynamic_post_event_content_view == 'none'){echo 'selected="selected"';}?>><?php _e('None','LMS');?></option>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<div class="clear"></div>
	<input type="hidden" name="dynamic_post_location" value="1" />
	<?php
	}
}
// Dynamic custom page builder
if ( ! function_exists( 'cs_pb_dcpt' ) ) {
	function cs_pb_dcpt($die = 0){
	
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		if ( isset($_POST['action']) ) {
	
			$name = $_POST['action'];
			$cs_counter = $_POST['counter'];
			$blog_element_size = '50';
			$cs_dcpt_title = '';
			$cs_dcpt_description = '';
			$cs_dcpt_view = '';
			$cs_dcpt_cat = '';
			$cs_dcpt_excerpt = '255';
			$cs_dcpt_num_post = get_option("posts_per_page");
			$cs_dcpt_pagination = '';
			$cs_dcpt_description = '';
			$cs_categories_name = '';
			$cs_dcpt_cat = '';
			$cs_blog_orderby_db = 'DESC';
			
			$coloumn_class = 'column_'.$dcpt_element_size;
				if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
					$shortcode_element = 'shortcode_element_class';
					$shortcode_view = 'cs-pbwp-shortcode';
					$filter_element = 'ajax-drag';
					$coloumn_class = '';
				}
		}
		else {
	
			$name = $cs_node->getName();
				$cs_count_node++;
				$dcpt_element_size = $cs_node->dcpt_element_size;
				$cs_dcpt_title = $cs_node->cs_dcpt_title;
				$cs_dcpt_post_type = $cs_node->cs_dcpt_post_type;
				$cs_dcpt_view = $cs_node->cs_dcpt_view;
				$cs_dcpt_cat = $cs_node->cs_dcpt_cat;
				$cs_dcpt_excerpt = $cs_node->cs_dcpt_excerpt;
				$cs_dcpt_num_post = $cs_node->cs_dcpt_num_post;
				$cs_dcpt_pagination = $cs_node->cs_dcpt_pagination;
				$cs_dcpt_description = $cs_node->cs_dcpt_description;
				$cs_dcpt_orderby = $cs_node->cs_dcpt_orderby;
				
				if($cs_dcpt_post_type){
					$cs_categories_name = get_post_meta($cs_dcpt_post_type, 'cs_categories_name', true);
				}
				$cs_counter = $post->ID.$cs_count_node;
				$coloumn_class = 'column_'.$dcpt_element_size;
		}
	?>
	<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($dcpt_element_size)?>" >
	<?php cs_element_setting($name,$cs_counter,$dcpt_element_size);?>
	<div class="cs-wrapp-class-<?php echo esc_attr($cs_counter);?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" style="display: none;">
	  <div class="cs-heading-area">
		<h5><?php _e('Edit DCPT Options','LMS');?></h5>
		<a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
	  <div class="cs-pbwp-content">
		<div class="opt-conts <?php echo esc_attr($name);?> ">
		  <ul class="form-elements">
			<li class="to-label">
			  <label><?php _e('Section Title','LMS');?></label>
			</li>
			<li class="to-field">
			  <div class="input-sec">
				<input type="text" name="cs_dcpt_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_dcpt_title)?>" />
			  </div>
			</li>
		  </ul>
		  <ul class="form-elements">
			<li class="to-label">
			  <label><?php _e('Select Post Type','LMS');?></label>
			</li>
			<li class="to-field">
			  <div class="input-sec">
				<div class="select-style">
				  <select name="cs_dcpt_post_type[]" class="dropdown"  onchange="javascript:cs_select_cat_views(this.value,'<?php echo esc_attr($cs_counter)?>','<?php echo admin_url('admin-ajax.php');?>')">
					<option value="0"><?php _e('Select Post Type','LMS');?></option>
					<?php
							query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'dcpt') );
								while ( have_posts()) : the_post();
					?>
					<option <?php if(isset($cs_dcpt_post_type) && $cs_dcpt_post_type==$post->ID) echo "selected"?> value="<?php the_ID()?>">
					<?php the_title()?>
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
		  <div  id="dcpt-categories<?php echo esc_attr($cs_counter)?>">
			<?php if(isset($cs_dcpt_post_type) && $cs_dcpt_post_type <> ''){
						$design_settings = get_post_meta($cs_dcpt_post_type, 'design_settings', true);
						
						?>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Select View','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <div class="select-style">
					<select name="cs_dcpt_view[]" class="dropdown">
					  <?php 
												 
							   query_posts( array(
										  'post_type' => 'cs_design',
										  'posts_per_page' => "-1",
										  'post_status' => 'publish', 
									  ) );
							  while ( have_posts()) : the_post();
								  $checked = '';
								  $selectedd = '';
								  $design_custom_posttypes = get_post_meta( $post->ID, 'design_custom_posttypes', true);
								  
								  if(!empty($design_custom_posttypes) && is_array($design_custom_posttypes) && in_array($cs_dcpt_post_type,$design_custom_posttypes)){
									  
								  
					   ?>
					  <option value="<?php echo absint($post->ID);?>" <?php if(!empty($cs_dcpt_view) && ($post->ID == $cs_dcpt_view)){echo 'selected="selected"';};?>><?php echo get_the_title();?></option>
					  <?php }
					  		endwhile;
					 		wp_reset_query(); 
					   ?>
					</select>
				  </div>
				</div>
			  </li>
			</ul>
			<?php }?>
			<?php if(isset($cs_categories_name) && $cs_categories_name<> ''){?>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Choose Category','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <div class="select-style dcp-category">
					<select name="cs_dcpt_cat[]" class="dropdown">
					  <option value="0"><?php _e('-- Select Category --','LMS');?></option>
					  <?php show_all_cats('', '', $cs_dcpt_cat, strtolower($cs_categories_name));?>
					</select>
				  </div>
				</div>
			  </li>
			</ul>
			<?php }?>
		  </div>
		  <div id="Blog-listing<?php echo esc_attr($cs_counter)?>">
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Post Order','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <div class="select-style">
					<select name="cs_dcpt_orderby[]" class="dropdown" >
					  <option <?php if($cs_dcpt_orderby=="ASC")echo "selected";?> value="ASC"><?php _e('Asc','LMS');?></option>
					  <option <?php if($cs_dcpt_orderby=="DESC")echo "selected";?> value="DESC"><?php _e('DESC','LMS');?></option>
					</select>
				  </div>
				</div>
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Post Description','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <div class="select-style">
					<select name="cs_dcpt_description[]" class="dropdown" >
					  <option <?php if($cs_dcpt_description=="yes")echo "selected";?> value="yes"><?php _e('Yes','LMS');?></option>
					  <option <?php if($cs_dcpt_description=="no")echo "selected";?> value="no"><?php _e('No','LMS');?></option>
					</select>
				  </div>
				</div>
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Length of Excerpt','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <input type="text" name="cs_dcpt_excerpt[]" class="txtfield" value="<?php echo esc_attr($cs_dcpt_excerpt);?>" />
				</div>
				<div class="left-info">
				  <p><?php _e('Enter number of character for short description text','LMS');?></p>
				</div>
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Pagination','LMS');?></label>
			  </li>
			  <li class="to-field">
				<div class="input-sec">
				  <div class="select-style">
					<select name="cs_dcpt_pagination[]" class="dropdown" >
					  <option <?php if($cs_dcpt_pagination=="Show Pagination")echo "selected";?> ><?php _e('Show Pagination','LMS');?></option>
					  <option <?php if($cs_dcpt_pagination=="Single Page")echo "selected";?> ><?php _e('Single Page','LMS');?></option>
					</select>
				  </div>
				</div>
			  </li>
			</ul>
		  </div>
		  <ul class="form-elements">
			<li class="to-label">
			  <label><?php _e('No. of Post Per Page','LMS');?></label>
			</li>
			<li class="to-field">
			  <div class="input-sec">
				<input type="text" name="cs_dcpt_num_post[]" class="txtfield" value="<?php echo esc_attr($cs_dcpt_num_post); ?>" />
			  </div>
			</li>
		  </ul>
		  <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
		  <ul class="form-elements">
			<li class="to-label"></li>
			<li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>',<?php echo esc_attr($name.$cs_counter);?>)"><?php _e('Insert','LMS');?></a> </li>
		  </ul>
		  <div id="results-shortocde"></div>
		  <?php } else {?>
		  <ul class="form-elements">
			<li class="to-label"></li>
			<li class="to-field">
			  <input type="hidden" name="cs_orderby[]" value="dcpt" />
			  <input name="button" type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:show_all('<?php echo esc_attr($name.$cs_counter);?>')" />
			</li>
		  </ul>
		  <?php }?>
		</div>
	  </div>
	</div>
	<?php
	
		if ( $die <> 1 ) die();
	
	}
	add_action('wp_ajax_cs_pb_dcpt', 'cs_pb_dcpt');
}
// Dynamic post type Dropdown values
if ( ! function_exists( 'cs_dcpt_page_element_values' ) ) {
	function cs_dcpt_page_element_values($die = 0){
		global $post;
		if(isset($_REQUEST['post_id']) && $_REQUEST['post_id'] <> ''){
			$design_settings = get_post_meta($_REQUEST['post_id'], 'design_settings', true);
			$cs_categories_name = get_post_meta($_REQUEST['post_id'], 'cs_categories_name', true);
			?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Select View','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_view[]" class="dropdown">
			  <?php 
									 
				 query_posts( array(
							'post_type' => 'cs_design',
							'posts_per_page' => "-1",
							'post_status' => 'publish', 
						) );
				while ( have_posts()) : the_post();
					$checked = '';
					$selectedd = '';
					$design_custom_posttypes = get_post_meta( $post->ID, 'design_custom_posttypes', true);
				   
					if(!empty($design_custom_posttypes) && is_array($design_custom_posttypes) && in_array($_REQUEST['post_id'],$design_custom_posttypes)){
				 ?>
			  		<option value="<?php echo absint($post->ID);?>" ><?php echo get_the_title();?></option>
			  <?php }
				endwhile;
				wp_reset_query(); 
			 ?>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php
		if(isset($cs_categories_name) && $cs_categories_name <> ''){
		?>
			<ul class="form-elements noborder">
			  <li class="to-label">
				<label><?php _e('Choose Category','LMS');?></label>
			  </li>
			  <li class="to-field">
				<select name="cs_dcpt_cat[]" class="dropdown">
				  <option value="0"><?php _e('-- Select Category --','LMS');?></option>
				  <?php show_all_cats('', '', '', strtolower($cs_categories_name));?>
				</select>
			  </li>
			</ul>
	<?php 
		}
		}
		die();
	}
	add_action('wp_ajax_cs_dcpt_page_element_values', 'cs_dcpt_page_element_values');
}
// Dynamic post type Ajax Categories Dropdown values
if ( ! function_exists( 'cs_dcpt_categories_values' ) ) {
	function cs_dcpt_categories_values($die = 0){
		global $post;
		if(isset($_REQUEST['post_id']) && $_REQUEST['post_id'] <> ''){
			$cs_categories_name = get_post_meta($_REQUEST['post_id'], 'cs_categories_name', true);
			if(isset($cs_categories_name) && $cs_categories_name <> ''){
			?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Choose Category','LMS');?></label>
	  </li>
	  <li class="to-field">
		<select name="cs_dcpt_cat[]" class="dropdown">
		  <option value="0"><?php _e('-- Select Category --','LMS');?></option>
		  <?php show_all_cats('', '', '', strtolower($cs_categories_name));?>
		</select>
	  </li>
	</ul>
	<?php 
			}
		}
		die();
	}
	add_action('wp_ajax_cs_dcpt_categories_values', 'cs_dcpt_categories_values');
}
// Faqs 
if ( ! function_exists( 'cs_faqs_section' ) ) {
	function cs_faqs_section(){
			global $cs_xmlObject,$post;
			if(!isset($cs_xmlObject))
				$cs_xmlObject = new stdClass();
			?>
	<input type="hidden" name="dynamic_post_faq" value="1" />
	 
	  <script>
		jQuery(document).ready(function($) {
			$("#total_faqs").sortable({
				cancel : 'td div.table-form-elem'
			});
		});
	 </script>
      <ul class="form-elements">
            <li class="to-label"><?php _e('Add FAQ','LMS');?></li>
            <li class="to-button"><a href="javascript:_createpop('add_faq_title','filter')" class="button"><?php _e('Add FAQ','LMS');?></a> </li>
       </ul>
	  <div class="cs-list-table">
      <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
			<th style="width:80%;"><?php _e('Title','LMS');?></th>
			<th style="width:80%;" class="centr"><?php _e('Actions','LMS');?></th>
            <th style="width:0%;" class="centr"></th>
		  </tr>
		</thead>
		<tbody id="total_faqs">
		  <?php
							global $counter_faq, $faq_title, $faq_description;
							$counter_faq = $post->ID;
							if ( isset($cs_xmlObject->faqs) && is_object($cs_xmlObject) && count($cs_xmlObject->faqs)>0) {
								foreach ( $cs_xmlObject->faqs as $faqs ){
									 $faq_title = $faqs->faq_title;
									 $faq_description = $faqs->faq_description;
									 cs_add_faq_to_list();
									 $counter_faq++;
								}
							}
						?>
		</tbody>
	  </table>
      </div>
	  <div id="add_faq_title" style="display: none;">
		<div class="cs-heading-area">
		  <h5> <i class="fa fa-plus-circle"></i><?php _e('FAQ Settings','LMS');?>  </h5>
		  <span class="cs-btnclose" onClick="javascript:removeoverlay('add_faq_title','append')"> <i class="fa fa-times"></i></span> </div>
		<ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Title','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="faq_title" name="faq_title" value="Title" />
		  </li>
		</ul>
		<ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('FAQ Description','LMS');?></label>
		  </li>
		  <li class="to-field">
			<textarea name="faq_description" id="faq_description"></textarea>
		  </li>
		</ul>
		<ul class="form-elements noborder">
		  <li class="to-label"></li>
		  <li class="to-field">
			<input type="button" value="<?php _e('Add FAQ to List','LMS');?>" onClick="add_faq_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
		  </li>
		</ul>
	  </div>
	<?php
		}
}

// Projects
if ( ! function_exists( 'cs_projects_listing_section' ) ) {
	function cs_projects_listing_section(){
		global $cs_xmlObject,$post;
	?>
    <script>
	jQuery(function($) {
		jQuery("#project_start_date").datetimepicker({format:"Y/m/d",timepicker:false});
		jQuery("#project_end_date").datetimepicker({format:"Y/m/d",timepicker:false});
	});
</script>
	<input type="hidden" name="dynamic_post_projects" value="1" />
	<div class="boxes tracklists">
	  <div id="add_project_listings" style="display: none;">
		<div class="cs-heading-area">
		  <h5> <i class="fa fa-plus-circle"></i><?php _e('Project Listings','LMS');?>  </h5>
		  <span onClick="javascript:removeoverlay('add_project_listings','append')" class="cs-btnclose"><i class="fa fa-times"></i></span> </div>
         <ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Project Title','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="project_title" name="project_title" value="" />
		  </li>
		</ul>
		<ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Project Start Date','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="project_start_date" name="project_start_date" value="" />
		  </li>
		</ul>
        <ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Project End Date','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="project_end_date" name="project_end_date" value="" />
		  </li>
		</ul>
		<ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Project Url','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="project_url" name="project_url" value="" />
		  </li>
		</ul>
		<ul class="form-elements noborder">
		  <li class="to-label"></li>
		  <li class="to-field">
			<input type="button" value="<?php _e('Add project','LMS');?>" onClick="add_project_to_list('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri())?>')" />
		  </li>
		</ul>
	  </div>
	  <script>
				jQuery(document).ready(function($) {
					$("#total_project_names").sortable({
						cancel : 'td div.cancel-drag',
					});
				});
			</script>
	  <div class="opt-head">
		<h4 style="padding-top:12px;"><?php _e('Projects','LMS');?></h4>
		<a href="javascript:_createpop('add_project_listings','filter')" class="button"><?php _e('Add project','LMS');?></a>
		<div class="clear"></div>
	  </div>
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
			<th style="width:20%;"><?php _e('Project Title','LMS');?></th>
			<th style="width:20%;"><?php _e('Project Start Date','LMS');?></th>
			<th style="width:20%;"><?php _e('Project End Date','LMS');?></th>
			<th style="width:20%;"><?php _e('Project Url','LMS');?></th>
			<th style="width:20%;" class="centr"><?php _e('Actions','LMS');?></th>
		  </tr>
		</thead>
		<tbody id="total_project_names">
		  <?php
				global $counter_projects, $project_title, $project_start_date, $project_end_date, $project_url;

				$counter_projects = $post->ID;
				if(isset($cs_xmlObject->projects) && count($cs_xmlObject->projects)){
					foreach ( $cs_xmlObject->projects as $transct ){

							$project_title = $transct->project_title;

							$project_start_date = $transct->project_start_date;

							$project_end_date = $transct->project_end_date;

							$project_url = $transct->project_url;
							
							$counter_projects++;
							
							add_project_name_to_list();
					}
				}
			?>
		</tbody>
	  </table>
	</div>
	<?php
	}
}
// Lms Projects
if ( ! function_exists( 'cs_lms_projects_listing_section' ) ) {
	function cs_lms_projects_listing_section(){
		global $post,$cs_xmlObject;
			 
   		?>
 <link type="text/css" rel="stylesheet"  href="<?php echo esc_url(get_template_directory_uri().'/include/assets/css/common.css');?>" />
 	<div class="clear"></div>
	<ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Clients','LMS');?></label>
	  </li>
	  <li class="to-field short-field">
		<input type="text" id="dynamic_post_lms_project_client" name="dynamic_post_lms_project_client" value="<?php if(isset($cs_xmlObject->dynamic_post_lms_project_client)){echo esc_attr($cs_xmlObject->dynamic_post_lms_project_client);} else { echo '';} ?>" />
	  </li>
	 </ul>
    <div class="clear"></div> 
	<ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Skills','LMS');?></label>
	  </li>
	  <li class="to-field">
 			<input id="dynamic_post_lms_project_skills" name="dynamic_post_lms_project_skills" value="<?php if(isset($cs_xmlObject->dynamic_post_lms_project_skills)){echo esc_attr($cs_xmlObject->dynamic_post_lms_project_skills);} else { echo '';} ?>" type="text" />
			<label class="first-label"><?php _e('Skills Needed','LMS');?></label>
 	  </li>
	</ul>
    <div class="clear"></div>
    <ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Software','LMS');?></label>
	  </li>
	  <li class="to-field">
 			<input id="dynamic_post_lms_project_software" name="dynamic_post_lms_project_software" value="<?php if(isset($cs_xmlObject->dynamic_post_lms_project_software)){echo esc_attr($cs_xmlObject->dynamic_post_lms_project_software);} else { echo '';} ?>" type="text" />
			<label class="first-label"><?php _e('Software Used','LMS');?></label>
 	  </li>
	</ul>
    <div class="clear"></div>
    <ul class="form-elements">
	  <li class="to-label">
		<label><?php _e('Project Url','LMS');?></label>
	  </li>
	  <li class="to-field">
 			<input id="dynamic_post_lms_project_url" name="dynamic_post_lms_project_url" value="<?php if(isset($cs_xmlObject->dynamic_post_lms_project_url)){echo esc_attr($cs_xmlObject->dynamic_post_lms_project_url);} else { echo '';} ?>" type="text" />
			<label class="first-label"></label>
 	  </li>
	</ul>
	<div class="clear"></div>
 	<input type="hidden" name="dynamic_post_lms_project" value="1" />
	<?php
	}
}
// Add Project to cause list
if ( ! function_exists( 'add_project_name_to_list' ) ) {
	add_action('wp_ajax_add_project_name_to_list', 'add_project_name_to_list');
	function add_project_name_to_list(){
		global $counter_projects, $project_title, $project_start_date, $project_end_date, $project_url;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
	?>
		<tr id="edit_track<?php echo esc_attr($counter_projects)?>">
	
			<td id="address_name<?php echo esc_attr($counter_projects)?>" style="width:20%;"><?php echo esc_attr($project_title)?></td>
	
			<td id="payer_email<?php echo esc_attr($counter_projects)?>" style="width:20%;"><?php echo esc_attr($project_start_date)?></td>
	
			<td id="payment_gross<?php echo esc_attr($counter_projects)?>" style="width:20%;"><?php echo esc_attr($project_end_date)?></td>
	
			<td id="txn_id<?php echo esc_attr($counter_projects)?>" style="width:20%;"><?php echo esc_attr($project_url)?></td>
	
			<td class="centr" style="width:20%;">
	
				<a href="javascript:_createpop('edit_track_form<?php echo esc_attr($counter_projects);?>','filter')" class="actions edit">&nbsp;</a>
	
				<a onclick="javascript:return confirm('Are you sure! You want to delete this Project')" href="javascript:cs_div_remove('edit_track<?php echo esc_attr($counter_projects);?>')" class="actions delete">&nbsp;</a>
	
				<div class="cancel-drag" id="edit_track_form<?php echo esc_attr($counter_projects)?>" style="display:none;">
	
					<div class="cs-heading-area">
	
						<h5><?php _e('Edit Project','LMS');?></h5>
	
						<span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_attr($counter_projects)?>','append')" class="cs-btnclose"><i class="fa fa-times"></i></span>
	
						<div class="clear"></div>
	
					</div>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Project Title','LMS');?></label></li>
	
						<li class="to-field"><input type="text" name="project_title_array[]" value="<?php echo htmlspecialchars($project_title)?>" id="project_title<?php echo esc_attr($counter_projects)?>" /></li>
	
					</ul>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Project Start Date','LMS');?></label></li>
	
						<li class="to-field"><input type="text" name="project_start_date_array[]" value="<?php echo htmlspecialchars($project_start_date)?>" id="project_start_date<?php echo esc_attr($counter_projects)?>" /></li>
	
					</ul>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Project End Date','LMS');?></label></li>
	
						<li class="to-field"><input type="text" name="project_end_date_array[]" value="<?php echo htmlspecialchars($project_end_date)?>" id="project_end_date<?php echo esc_attr($counter_projects)?>" /></li>
	
					</ul>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Project Url','LMS');?></label></li>
	
						<li class="to-field"><input type="text" name="project_url_array[]" value="<?php echo htmlspecialchars($project_url)?>" id="project_url<?php echo esc_attr($counter_projects)?>" /></li>
	
					</ul>
	
					<ul class="form-elements noborder">
	
						<li class="to-label"><label></label></li>
	
						<li class="to-field"><input type="button" value="Update Project" onclick="update_title(<?php echo esc_js($counter_projects);?>); removeoverlay('edit_track_form<?php echo esc_attr($counter_projects)?>','append')" /></li>
	
					</ul>
	
				</div>
	
			</td>
	
		</tr>
	
	<?php
	
	}
}

// Sermons
if ( ! function_exists( 'cs_sermons_listing_section' ) ) {
	function cs_sermons_listing_section(){
		global $post,$cs_xmlObject;
	?>
	<input type="hidden" name="dynamic_post_sermons" value="1" />
    <ul class="form-elements">
      <li class="to-label">
        <label><?php _e('Sermon Short Summary','LMS');?></label>
      </li>
      <li class="to-field">
      	<textarea name="cs_sermon_short_summary" rows="10" cols="30"><?php if(isset($cs_xmlObject->cs_sermon_short_summary)) echo esc_textarea($cs_xmlObject->cs_sermon_short_summary);?></textarea>
      </li>
    </ul>
	<div class="boxes tracklists">
	  <div id="add_sermon_listings" style="display: none;">
		<div class="cs-heading-area">
		  <h5> <i class="fa fa-plus-circle"></i> <?php _e('Sermon Listings','LMS');?> </h5>
		  <span onClick="javascript:removeoverlay('add_sermon_listings','append')" class="cs-btnclose"><i class="fa fa-times"></i></span> </div>
         <ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Sermon Title','LMS');?></label>
		  </li>
		  <li class="to-field">
			<input type="text" id="sermon_title" name="sermon_title" value="" />
		  </li>
		</ul>
		<ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Sermon Type','LMS');?></label>
		  </li>
		  <li class="to-field">
          	<select name="sermon_type" id="sermon_type">
            	<option value="adudio"><?php _e('Audio','LMS');?></option>
                <option value="video"><?php _e('Video','LMS');?></option>
            </select>
		  </li>
		</ul>
        <ul class="form-elements">
		  <li class="to-label">
			<label><?php _e('Sermon Url','LMS');?></label>
		  </li>
		  <li class="to-field">
          	<input id="sermon_file_url" name="sermon_file_url" value="" type="text" class="small" />
             <input id="sermon_file_url" name="sermon_file_url" type="button" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
		  </li>
		</ul>
		
		<ul class="form-elements noborder">
		  <li class="to-label"></li>
		  <li class="to-field">
			<input type="button" value="<?php _e('Add Sermon','LMS');?>" onClick="add_sermon_to_list('<?php echo esc_js(admin_url('admin-ajax.php'))?>', '<?php echo esc_js(get_template_directory_uri())?>')" />
		  </li>
		</ul>
	  </div>
	  	<script>
			jQuery(document).ready(function($) {
				$("#total_project_names").sortable({
					cancel : 'td div.cancel-drag',
				});
			});
		</script>
	  <div class="opt-head">
		<h4 style="padding-top:12px;"><?php _e('Sermons','LMS');?></h4>
		<a href="javascript:_createpop('add_sermon_listings','filter')" class="button"><?php _e('Add Sermon','LMS');?></a>
		<div class="clear"></div>
	  </div>
	  <table class="to-table" border="0" cellspacing="0">
		<thead>
		  <tr>
			<th style="width:20%;"><?php _e('Sermon Title','LMS');?></th>
			<th style="width:20%;"><?php _e('Sermon Url','LMS');?></th>
			<th style="width:20%;" class="centr"><?php _e('Actions','LMS');?></th>
		  </tr>
		</thead>
		<tbody id="total_sermon_names">
		  <?php
				global $counter_sermons, $sermon_title, $sermon_type, $sermon_file_url;
				$counter_sermons = $post->ID;
				if(isset($cs_xmlObject->sermons) && count($cs_xmlObject->sermons)){
					foreach ( $cs_xmlObject->sermons as $transct ){
							$sermon_title = $transct->sermon_title;
							$sermon_type = $transct->sermon_type;
							$sermon_file_url = $transct->sermon_file_url;
							$counter_sermons++;
							add_sermon_name_to_list();
					}
				}
			?>
		</tbody>
	  </table>
	</div>
	<?php
	}
}

// Add Sermon to cause list
if ( ! function_exists( 'add_sermon_name_to_list' ) ) {
	add_action('wp_ajax_add_sermon_name_to_list', 'add_sermon_name_to_list');
	function add_sermon_name_to_list(){
		global $counter_sermons, $sermon_title, $sermon_type, $sermon_file_url;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
	?>
		<tr id="edit_track<?php echo esc_attr($counter_sermons)?>">
	
			<td id="sermon_title<?php echo esc_attr($counter_sermons)?>" style="width:20%;"><?php echo esc_attr($sermon_title)?></td>
	
			<td id="sermon_file_url<?php echo esc_attr($counter_sermons)?>" style="width:20%;"><?php echo esc_attr($sermon_file_url)?></td>

			<td class="centr" style="width:20%;">
	
				<a href="javascript:_createpop('edit_track_form<?php echo esc_attr($counter_sermons)?>','filter')" class="actions edit">&nbsp;</a>
	
				<a onclick="javascript:return confirm('Are you sure! You want to delete this Sermon')" href="javascript:cs_div_remove('edit_track<?php echo esc_attr($counter_sermons)?>')" class="actions delete">&nbsp;</a>
	
				<div class="cancel-drag" id="edit_track_form<?php echo esc_attr($counter_sermons)?>" style="display:none;">
	
					<div class="cs-heading-area">
	
						<h5><?php _e('Edit Sermon','LMS');?></h5>
	
						<span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_attr($counter_sermons)?>','append')" class="cs-btnclose"><i class="fa fa-times"></i></span>
	
						<div class="clear"></div>
	
					</div>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Sermon Title','LMS');?></label></li>
	
						<li class="to-field"><input type="text" name="sermon_title_array[]" value="<?php echo htmlspecialchars($sermon_title)?>" id="sermon_title<?php echo esc_attr($counter_sermons);?>" /></li>
	
					</ul>
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Sermon Title','LMS');?> <?php echo esc_attr($sermon_type)?></label></li>
	
						<li class="to-field">
                        	<select name="sermon_type_array[]" id="sermon_title<?php echo esc_attr($sermon_type)?>">
                            <option value="adudio" <?php if(isset($sermon_type) && $sermon_type == 'audio'){echo 'selected';}?>><?php _e('Audio','LMS');?></option>
                            <option value="video" <?php if(isset($sermon_type) && $sermon_type == 'video'){echo 'selected';}?>><?php _e('Video','LMS');?></option>
                        </select>
                       </li>
					</ul>
	
					<ul class="form-elements">
	
						<li class="to-label"><label><?php _e('Sermon Url','LMS');?></label></li>
	
						<li class="to-field">
                        	<input id="sermon_file_url<?php echo esc_attr($counter_sermons);?>" name="sermon_file_url_array[]" value="<?php echo esc_url($sermon_file_url)?>" type="text" class="small" />
             				<input id="sermon_file_url<?php echo esc_attr($counter_sermons);?>" name="sermon_file_url_array[]" type="button" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
					</ul>
	
					<ul class="form-elements noborder">
	
						<li class="to-label"><label></label></li>
	
						<li class="to-field"><input type="button" value="<?php _e('Update Sermon','LMS');?>" onclick="update_title(<?php echo esc_js($counter_sermons)?>); removeoverlay('edit_track_form<?php echo esc_js($counter_sermons)?>','append')" /></li>
	
					</ul>
	
				</div>
	
			</td>
	
		</tr>
	
	<?php
	
	}
}

// Error Message 
if ( ! function_exists( 'px_error_msg' ) ) {
	function px_error_msg( $error_msg ) {
		$msg_string = '';
		foreach ($error_msg as $value) {
			if ( !empty( $value ) ) {
				$msg_string = $msg_string . '<div class="error">' . $value . '</div>';
			}
		}
		return $msg_string;
	}
}
// Error upload Attachment 
if ( ! function_exists( 'px_upload_attachment' ) ) {
	function px_upload_attachment( $post_id ) {
		if ( !isset( $_FILES['px_post_attachments'] ) ) {
			return false;
		}
		$file_name = basename( $_FILES['px_post_attachments']['name']);
		if ( $file_name ) {
			if ( $file_name ) {
				$upload = array(
					'name' => $_FILES['px_post_attachments']['name'],
					'type' => $_FILES['px_post_attachments']['type'],
					'tmp_name' => $_FILES['px_post_attachments']['tmp_name'],
					'error' => $_FILES['px_post_attachments']['error'],
					'size' => $_FILES['px_post_attachments']['size']
				);
				px_upload_file( $upload );
			}//file exists
		 }
	}
}
// Error upload File 
if ( ! function_exists( 'px_upload_file' ) ) {
	function px_upload_file( $upload_data ) {
				include_once ABSPATH . 'wp-admin/includes/media.php';
				include_once ABSPATH . 'wp-admin/includes/file.php';
				include_once ABSPATH . 'wp-admin/includes/image.php';
				$uploaded_file = wp_handle_upload( $upload_data, array('test_form' => false) );
				if ( isset( $uploaded_file['file'] ) ) {
					$file_loc = $uploaded_file['file'];
					$file_name = basename( $upload_data['name'] );
					$file_type = wp_check_filetype( $file_name );
					$attachment = array(
						'post_mime_type' => $file_type['type'],
						'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
						'post_content' => '',
						'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $file_loc );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
					wp_update_attachment_metadata( $attach_id, $attach_data );
					return $attach_id;
				}
				return false;
			}
}
// Error Submit Post
if ( ! function_exists( 'submit_post' ) ) {		
	function submit_post() {
        global $userdata, $post_id;
        $errors = array();
       	$size_limit = 50000000;
		$mime = get_allowed_mime_types();
		if(isset($_POST['px_post_upload_type']) && $_POST['px_post_upload_type'] == 'upload'){
			 if ( !empty( $_FILES['px_post_attachments'] ) ) {
				$attachment = $_FILES['px_post_attachments'];
				$attachment_name = $_FILES['px_post_attachments']['name'];
				if ( $attachment_name ) {
					$tmp_name = $_FILES['px_post_attachments']['tmp_name'];
					$attach_size = $_FILES['px_post_attachments']['size'];
					$attach_type = wp_check_filetype( $attachment_name );
					//check file size
					if ( $attach_size > $size_limit ) {
						$errors[] = __( "Attachment file is too big",'LMS' );
					}
					//check file type
					if ( !in_array( $attach_type['type'], $mime ) ) {
						$errors[] = __( "Invalid Featured file type",'LMS' );
					}
				}
			 }
		}

		if ( $errors ) {
            return px_error_msg( $errors );
        }

        if ( $post_id ) {
			$featured_url = $attachment_url ='';
			
			if ( !empty( $_FILES['px_post_attachments'] ) ) {
				$attachment = $_FILES['px_post_attachments'];
				$attachment_id = px_upload_file( $attachment );
				$attach_id = isset( $attachment_id ) ? intval( $attachment_id ) : 0;
				
				return $attachment_url = wp_get_attachment_url( $attach_id );
			 }
        }
    }
}
// Media Attachment
if ( ! function_exists( 'cs_media_attachments' ) ) {	
	function cs_media_attachments(){
		?>
	<div class="to-social-network">
	  <div class="gal-active">
		<div class="clear"></div>
		<div class="dragareamain">
		  <div class="placehoder"><?php _e('Gallery is Empty. Please Select Media','LMS');?> <img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/bg-arrowdown.png');?>" alt="" /></div>
		  <ul id="gal-sortable">
			<?php 
							global $cs_node, $cs_xmlObject, $cs_counter;
							$cs_counter_gal = 0;
							if(count($cs_xmlObject->gallery)>0){
								foreach ( $cs_xmlObject->gallery as $cs_node ){
									$cs_counter_gal++;
									$cs_counter = $post->ID.$cs_counter_gal;
									cs_gallery_clone();
								}
							}
						?>
		  </ul>
		</div>
	  </div>
	  <div class="to-social-list">
		<div class="soc-head">
		  <h5><?php _e('Select Media','LMS');?></h5>
		  <div class="right">
			<input type="button" class="button reload" value="Reload" onClick="refresh_media()" />
			<input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="<?php _e('Upload Media','LMS');?>" />
		  </div>
		  <div class="clear"></div>
		</div>
		<div class="clear"></div>
		<script type="text/javascript">
							function show_next(page_id, total_pages){
								var dataString = 'action=media_pagination&page_id='+page_id+'&total_pages='+total_pages;
								jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' />");
								jQuery.ajax({
									type:'POST', 
									url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
									data: dataString,
									success: function(response) {
										jQuery("#pagination").html(response);
									}
								});
							}
							function refresh_media(){
								var dataString = 'action=media_pagination';
								jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' />");
								jQuery.ajax({
									type:'POST', 
									url: "<?php echo esc_js(admin_url('admin-ajax.php'))?>",
									data: dataString,
									success: function(response) {
										jQuery("#pagination").html(response);
									}
								});
							}
						</script> 
		<!--<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>--> 
		<script>
							jQuery(document).ready(function($) {
								$("#gal-sortable").sortable({
									cancel:'li div.poped-up',
								});
								//$(this).append("#gal-sortable").clone() ;
								});
								var counter = 0;
								var count_items = <?php echo esc_js($cs_counter_gal)?>;
								if ( count_items > 0 ) {
									jQuery(".dragareamain") .addClass("noborder");	
								}
	
								function clone(path){
									counter = counter + 1;
									var dataString = 'path='+path+'&counter='+counter+'&action=gallery_clone';
									
									jQuery("#gal-sortable").append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' /></li>");
									jQuery.ajax({
										type:'POST', 
										url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
										data: dataString,
										success: function(response) {
											jQuery("#loading").remove();
											jQuery("#gal-sortable").append(response);
											count_items = jQuery("#gal-sortable li") .length;
												if ( count_items > 0 ) {
													jQuery(".dragareamain") .addClass("noborder");	
												}
										}
									});
								}
								function del_this(id){
									jQuery("#"+id).remove();
									count_items = jQuery("#gal-sortable li") .length;
										if ( count_items == 0 ) {
											jQuery(".dragareamain") .removeClass("noborder");	
										}
								}
						</script> 
		<script type="text/javascript">
							var contheight;
							  function galedit(id){
								  var $ = jQuery;
								  $(".to-social-list,.gal-active h4.left,#gal-sortable li,#gal-sortable .thumb-secs") .not("#"+id) .fadeOut(200);
								  $.scrollTo( '.page-wrap', 400, {easing:'swing'} );
										$('.poped-up').animate({
											top: 0,
										}, 300, function() {
											$("#edit_" + id+" li")  .show(); 
											$("#edit_" + id)   .slideDown(300); 
										});
							   };
							   function galclose(id){
								  var $ = jQuery;
								  $("#edit_" + id) .slideUp(300);
								  $(".to-social-list,.gal-active h4.left,#gal-sortable li,#gal-sortable .thumb-secs")  .fadeIn(300);
							  };
						
						</script>
		<div id="pagination">
		  <?php media_pagination();?>
		</div>
		<input type="hidden" name="gallery_meta_form" value="1" />
		<div class="clear"></div>
	  </div>
	</div>
	<?php	
	}
}
// Section Slider
if ( ! function_exists( 'cs_section_slider' ) ) {	
	function cs_section_slider($section_field_name = 'section_'){
		$rand_id = rand(5,63);
		?>
	<div class="to-social-network">
	  <div class="gal-active">
		<div class="clear"></div>
		<div class="dragareamain">
		  <div class="placehoder"><?php _e('Gallery is Empty. Please Select Media','LMS');?> <img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/bg-arrowdown.png');?>" alt="" /></div>
		  <ul id="gal-sortable-slider-<?php echo esc_attr($rand_id);?>">
			<?php 
							global $cs_node, $cs_xmlObject, $cs_counter;
							$cs_counter_gal = 0;
							if(count($cs_xmlObject->gallery)>0){
								foreach ( $cs_xmlObject->gallery as $cs_node ){
									$cs_counter_gal++;
									$cs_counter = $post->ID.$cs_counter_gal;
									cs_gallery_clone('section_');
								}
							}
						?>
		  </ul>
		</div>
	  </div>
	  <div class="to-social-list">
		<div class="soc-head">
		  <h5><?php _e('Select Media','LMS');?></h5>
		  <div class="right">
			<input type="button" class="button reload" value="Reload" onClick="refresh_media()" />
			<input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="<?php _e('Upload Media','LMS');?>" />
		  </div>
		  <div class="clear"></div>
		</div>
		<div class="clear"></div>
		<script type="text/javascript">
							function show_next(page_id, total_pages){
								var dataString = 'action=media_pagination&page_id='+page_id+'&total_pages='+total_pages;
								jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' />");
								jQuery.ajax({
									type:'POST', 
									url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
									data: dataString,
									success: function(response) {
										jQuery("#pagination").html(response);
									}
								});
							}
							function refresh_media(){
								var dataString = 'action=media_pagination';
								jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' />");
								jQuery.ajax({
									type:'POST', 
									url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
									data: dataString,
									success: function(response) {
										jQuery("#pagination").html(response);
									}
								});
							}
						</script> 
		<!--   <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>--> 
		<script>
							jQuery(document).ready(function($) {
								$("#gal-sortable-slider-<?php echo esc_js($rand_id);?>").sortable({
									cancel:'li div.poped-up',
								});
								//$(this).append("#gal-sortable").clone() ;
								});
								var counter = 0;
								var count_items = <?php echo esc_js($cs_counter_gal)?>;
								if ( count_items > 0 ) {
									jQuery(".dragareamain") .addClass("noborder");	
								}
	
								function clone(path){
									counter = counter + 1;
									var dataString = 'path='+path+'&counter='+counter+'&action=gallery_clone';
									
									jQuery("#gal-sortable-slider-<?php echo esc_js($rand_id);?>").append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'));?>' /></li>");
									jQuery.ajax({
										type:'POST', 
										url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
										data: dataString,
										success: function(response) {
											jQuery("#loading").remove();
											jQuery("#gal-sortable-slider-<?php echo esc_js($rand_id);?>").append(response);
											count_items = jQuery("#gal-sortable-slider-<?php echo esc_js($rand_id);?> li") .length;
												if ( count_items > 0 ) {
													jQuery(".dragareamain") .addClass("noborder");	
												}
										}
									});
								}
								function del_this(id){
									jQuery("#"+id).remove();
									count_items = jQuery("#gal-sortable-slider-<?php echo esc_js($rand_id);?> li") .length;
										if ( count_items == 0 ) {
											jQuery(".dragareamain") .removeClass("noborder");	
										}
								}
						</script> 
		<script type="text/javascript">
							var contheight;
							  function galedit(id){
								  var $ = jQuery;
								  $(".to-social-list,.gal-active h4.left,#gal-sortable-slider-<?php echo esc_js($rand_id);?> li,#gal-sortable .thumb-secs") .not("#"+id) .fadeOut(200);
								  $.scrollTo( '.page-wrap', 400, {easing:'swing'} );
										$('.poped-up').animate({
											top: 0,
										}, 300, function() {
											$("#edit_" + id+" li")  .show(); 
											$("#edit_" + id)   .slideDown(300); 
										});
							   };
							   function galclose(id){
								  var $ = jQuery;
								  $("#edit_" + id) .slideUp(300);
								  $(".to-social-list,.gal-active h4.left,#gal-sortable li,#gal-sortable-slider-<?php echo esc_js($rand_id);?> .thumb-secs")  .fadeIn(300);
							  };
						
						</script>
		<div id="pagination">
		  <?php media_pagination($rand_id,'clone');?>
		</div>
		<input type="hidden" name="gallery_meta_form" value="1" />
		<div class="clear"></div>
	  </div>
	</div>
	<?php	
	}
}
// Design Element
if ( ! function_exists( 'cs_design_element' ) ) {	
	function cs_design_element(){
		if(isset($_POST['design_name'])){
			$design_name = $_POST['design_name'];
			$html_values = htmlentities($_POST['design_html']);
			update_option($design_name,$html_values);
		}
		die;
	}
	add_action('wp_ajax_cs_design_element', 'cs_design_element');
}

// Event Location Fields
if ( ! function_exists( 'cs_location_fields' ) ) {
	function cs_location_fields(){
		global $cs_xmlObject;
		if ( isset($cs_xmlObject)) {
			if(isset($cs_xmlObject->dynamic_post_location_latitude)){ $dynamic_post_location_latitude = $cs_xmlObject->dynamic_post_location_latitude;} else {$dynamic_post_location_latitude = '';}
			if(isset($cs_xmlObject->dynamic_post_location_longitude)){ $dynamic_post_location_longitude = $cs_xmlObject->dynamic_post_location_longitude;} else {$dynamic_post_location_longitude = '';}
			if(isset($cs_xmlObject->dynamic_post_location_zoom)){ $dynamic_post_location_zoom = $cs_xmlObject->dynamic_post_location_zoom;} else {$dynamic_post_location_zoom = '';}
			if(isset($cs_xmlObject->dynamic_post_location_address)){ $dynamic_post_location_address = $cs_xmlObject->dynamic_post_location_address;} else {$dynamic_post_location_address = '';}
			if(isset($cs_xmlObject->loc_city)){ $loc_city = $cs_xmlObject->loc_city;} else {$loc_city = '';}
			if(isset($cs_xmlObject->loc_postcode)){ $loc_postcode = $cs_xmlObject->loc_postcode;} else {$loc_postcode = '';}
			if(isset($cs_xmlObject->loc_region)){ $loc_region = $cs_xmlObject->loc_region;} else {$loc_region = '';}
			if(isset($cs_xmlObject->loc_country)){ $loc_country = $cs_xmlObject->loc_country;} else {$loc_country = '';}
			if(isset($cs_xmlObject->event_map_switch)){ $event_map_switch = $cs_xmlObject->event_map_switch;} else {$event_map_switch = '';}
			if(isset($cs_xmlObject->event_map_heading)){ $event_map_heading = $cs_xmlObject->event_map_heading;} else {$event_map_heading = '';}
	
		}
		else {
			$dynamic_post_location_latitude = '';
			$dynamic_post_location_longitude = '';
			$dynamic_post_location_zoom = '';
			$dynamic_post_location_address = '';
			$loc_city = '';
			$loc_postcode = '';
			$loc_region = '';
			$loc_country = '';
			$event_map_switch = '';
			$event_map_heading = 'Event Location';
		}							
		cs_enqueue_location_gmap_script();
			?>
   
	<fieldset class="gllpLatlonPicker"  style="width:100%; float:left;">
	  <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
		<div class="option-sec" style="margin-bottom:0;">
		  <div class="opt-conts">
			<ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Location Map','LMS');?></label>
              </li>
              <li class="to-field has_input">
                <div class="input-sec">
                  <label class="pbwp-checkbox">
                    <input type="hidden" name="dcpt[event_map_switch]" value=""/>
                    <input type="checkbox" class="myClass" name="dcpt[event_map_switch]" <?php if (isset($cs_xmlObject->event_map_switch) && $cs_xmlObject->event_map_switch == "on") echo "checked" ?>/>
                    <span class="pbwp-box"></span> </label>
                    <input type="text" name="dcpt[event_map_heading]" value="<?php echo htmlspecialchars($event_map_heading)?>" />
                </div>
              </li>
            </ul>
            <ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Address','LMS');?></label>
			  </li>
			  <li class="to-field">
				<input name="dcpt[dynamic_post_location_address]" id="loc_address" type="text" value="<?php echo htmlspecialchars($dynamic_post_location_address)?>" class="gllpSearchButton" onBlur="gll_search_map()" />
			  </li>
			</ul>
			
            <ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('City / Town','LMS');?></label>
			  </li>
			  <li class="to-field">
				<input name="dcpt[loc_city]" id="loc_city" type="text" value="<?php echo htmlspecialchars($loc_city)?>" class="gllpSearchButton" onBlur="gll_search_map()" />
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Post Code','LMS');?></label>
			  </li>
			  <li class="to-field">
				<input name="dcpt[loc_postcode]" id="loc_postcode" type="text" value="<?php echo htmlspecialchars($loc_postcode)?>" class="gllpSearchButton" onBlur="gll_search_map()" />
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Region','LMS');?></label>
			  </li>
			  <li class="to-field">
				<input name="dcpt[loc_region]" id="loc_region" type="text" value="<?php echo htmlspecialchars($loc_region)?>" class="gllpSearchButton" onBlur="gll_search_map()" />
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label><?php _e('Country','LMS');?></label>
			  </li>
			  <li class="to-field">
				<select name="dcpt[loc_country]" id="loc_country" class="gllpSearchButton" onBlur="gll_search_map()" >
				  <?php foreach( cs_get_countries() as $key => $val ):?>
				  <option <?php if($loc_country==$val)echo "selected"?> ><?php echo esc_attr($val);?></option>
				  <?php endforeach; ?>
				</select>
			  </li>
			</ul>
			<ul class="form-elements">
			  <li class="to-label">
				<label></label>
			  </li>
			  <li class="to-field">
				<input type="button" class="gllpSearchButton" value="<?php _e('Search This Location on Map','LMS');?>" onClick="gll_search_map()">
			  </li>
			</ul>
			<ul class="form-elements " style="float: left;">
			  <li>
				<div class="clear"></div>
				<input type="hidden" name="add_new_loc" class="gllpSearchField" style="margin-bottom:10px;" >
				<div style="float:left; width:100%; height:100%;">
				  <div class="gllpMap" id="cs-map-location-id"></div>
				</div>
				<input type="hidden" name="dcpt[dynamic_post_location_latitude]" value="<?php echo esc_attr($dynamic_post_location_latitude);?>" class="gllpLatitude" />
				<input type="hidden" name="dcpt[dynamic_post_location_longitude]" value="<?php echo esc_attr($dynamic_post_location_longitude);?>" class="gllpLongitude" />
				<input type="hidden" name="dcpt[dynamic_post_location_zoom]" value="<?php echo esc_attr($dynamic_post_location_zoom);?>" class="gllpZoom" />
				<input type="button" class="gllpUpdateButton" value="update map" style="display:none">
				<div class="clear"></div>
			  </li>
			</ul>
		  </div>
		</div>
	  </div>
	</fieldset>
	<?php	
	}
}
//Dynamic Custom Pirce Fields
if ( ! function_exists( 'cs_sale_fields' ) ) {
	function cs_sale_fields(){
		global $cs_xmlObject;									
		$dynamic_post_other_options['slae'] = array(
				'title' => __('Sale Settings', 'LMS'),
				'id' => 'location-meta-option',
				'notes' => __('Location Options.', 'LMS'),
				'params' => array(
						'dynamic_post_sale_oldprice' => array(
							'name' => 'dynamic_post_sale_oldprice',
							'type' => 'text',
							'title' => 'Old Price',
							'description' => '',
							'default' => '',
						),
						'dynamic_post_sale_newprice' => array(
							'name' => 'dynamic_post_sale_newprice',
							'type' => 'text',
							'title' => 'New Price',
							'description' => '',
							'default' => '',
						),						
						
				)
			);
			$output = '';			
			foreach($dynamic_post_other_options['slae'] as $params){
					if(is_array($params)){
						foreach($params as $key=>$param){
							if(isset($param['title'])){$param_title = $param['title'];}	 else {$param_title = '';}
							if(isset($param['description'])){$param_description = $param['description'];}	 else {$param_description = '';}
							if(isset($key)){$key = $key;}	 else {$key = '';}
							if(isset($cs_xmlObject->$key)){$cs_xmlObject_key = $cs_xmlObject->$key;}	 else {$cs_xmlObject_key = '';}
							switch( $param['type'] )
								{
									case 'text' :
										$output .= '<ul class="form-elements noborder">
											<li class="to-label"><label>'.$param_title.'</label></li>
											<li class="to-field">
												<div class="input-sec">
													 <input type="text" id="dynamic_post_location_address_icon" name="dcpt[' . $key . ']" value="'.$cs_xmlObject_key.'" />
												</div>
												<div class="left-info">
													<p>'.$param_description.'</p>
												</div>
											</li>
										</ul>';
										break;
									case 'range' :
									$output .= '<ul class="form-elements noborder">
										<li class="to-label"><label>'.$param_title.'</label></li>
										<li class="to-field">
										<div class="input-sec">
											<input id="' . $key . '" data-slider-id="dropcap_size" class="cs-drag-slider" name="dcpt[' . $key . ']" type="text"  data-slider-min="5" data-slider-max="20" data-slider-step="10" data-slider-value="' . $key . '" value="'.$cs_xmlObject_key.'"/>
										
										</div>
										<div class="left-info">
											<p>'.$param_description.'</p>
										</div>
										</li>
									</ul>';
									break;
								}
						}
					}
			}			
			echo balanceTags($output, true);	
	}
}
//Dynamic Custom coupon Fields
if ( ! function_exists( 'cs_coupons_fields' ) ) {
	function cs_coupons_fields(){
		global $cs_xmlObject;									
		$dynamic_post_other_options['coupon'] = array(
				'title' => __('Coupon Settings', 'LMS'),
				'id' => 'coupon-meta-option',
				'notes' => __('Coupon Options.', 'LMS'),
				'params' => array(
						'dynamic_post_coupon_text' => array(
							'name' => 'dynamic_post_coupon_text',
							'type' => 'text',
							'title' => 'Coupon Code',
							'description' => '',
							'default' => '',
						),
				)
			);
			$output = '';
			foreach($dynamic_post_other_options['coupon'] as $params){
					if(is_array($params)){
						foreach($params as $key=>$param){
							switch( $param['type'] )
								{
									case 'text' :
										$output .= '<ul class="form-elements noborder">
											<li class="to-label"><label>'.$param['title'].'</label></li>
											<li class="to-field">
												<div class="input-sec">
													 <input type="text" name="dcpt[' . $key . ']" value="'.$cs_xmlObject->$key.'" />
												</div>
												<div class="left-info">
													<p>'.$param['description'].'</p>
												</div>
											</li>
										</ul>';
										break;
									case 'range' :
									$output .= '<ul class="form-elements noborder">
										<li class="to-label"><label>'.$param['title'].'</label></li>
										<li class="to-field">
										<div class="input-sec">
											<input id="' . $key . '" data-slider-id="dropcap_size" class="cs-drag-slider" name="dcpt[' . $key . ']" type="text"  data-slider-min="5" data-slider-max="20" data-slider-step="10" data-slider-value="' . $key . '" value="'.$cs_xmlObject->$key.'"/>
										
										</div>
										<div class="left-info">
											<p>'.$param['description'].'</p>
										</div>
										</li>
									</ul>';
									break;
								}
						}
					}
			}
			echo balanceTags($output, true);	
	}
}
//Dynamic Custom Cause Fields
if ( ! function_exists( 'cs_projects_fields' ) ) {
	function cs_projects_fields(){
		global $post,$cs_xmlObject;
		$dynamic_post_other_options['projects'] = array(
				'title' => __('Projects', 'LMS'),
				'id' => 'cause-meta-option',
				'notes' => __('Cause Options.', 'LMS'),
				'params' => array(
						'cs_project_start_date' => array(
							'name' => 'cs_project_start_date',
							'id' => 'cs_project_start_date',
							'type' => 'text',
							'title' => 'Project Start Date',
							'description' => '',
							'default' => '',
						),
						'cs_project_end_date' => array(
							'name' => 'cs_project_end_date',
							'id' => 'cs_project_end_date',
							'type' => 'text',
							'title' => 'Project End Date',
							'description' => '',
							'default' => '',
						),
						
				)
			);			
			echo '<script>
					jQuery(function($) {
						jQuery("#cause_end_date").datetimepicker({format:"Y/m/d",timepicker:false});
					});
			</script>';
			$output = '';
			foreach($dynamic_post_other_options['cause'] as $params){
				if(is_array($params)){
					foreach($params as $key=>$param){
						$cs_value = '';
						if(isset($cs_xmlObject->$key) && $cs_xmlObject->$key <> ''){
							$cs_value = $cs_xmlObject->$key;
						} else {
							$cs_value = $param['default'];
						}
						if(isset($param['class']))
							$class = $param['class'];
						else {
							$class = '';	
						}
						if(isset($param['id']))
							$param_id = $param['id'];
						else {
							$param_id = '';	
						}
						switch( $param['type'] )
							{
								case 'text' :
										$output .= '<ul class="form-elements noborder">
											<li class="to-label"><label>'.$param['title'].'</label></li>
											<li class="to-field">
												<div class="input-sec">
													 <input type="text" id="'.$param_id.'" name="dcpt[' . $key . ']" value="'.$cs_value.'" class="' . $class . '" />
												</div>
												<div class="left-info">
													<p>'.$param['description'].'</p>
												</div>
											</li>
										</ul>';
										break;
									case 'range' :
									$output .= '<ul class="form-elements noborder">
										<li class="to-label"><label>'.$param['title'].'</label></li>
										<li class="to-field">
										<div class="input-sec">
											 <input type="range" id="dynamic_post_location_address_icon" name="dcpt[' . $key . ']" value="'.$cs_value.'" />
										</div>
										<div class="left-info">
											<p>'.$param['description'].'</p>
										</div>
										</li>
									</ul>';
									break;
							}
					}
				}
			}
			echo balanceTags($output, true);	
	}
}
//Fontawsome POPup
if ( ! function_exists( 'cs_fontawsome_popup_load' ) ) {
	function cs_fontawsome_popup_load(){		
		?>
	<ul class='form-elements'>
	  <li class='to-label'>
		<label><?php _e('Fontawsome Icon','LMS');?></label>
	  </li>
	  <li>
		<div class="cs-custom-fonts">
		  <div class="cs-font-header">
			<input type="serach" placeholder="<?php _e('Search icon','LMS');?>" class="cs-search-icon">
			<input type="hidden" class="cs-search-icon-hidden" name="counter_icon">
		  </div>
		  <div class="cs-font-container" id="fixed-height-icons">
			<?php cs_fontawsome_icons_box();?>
		  </div>
		</div>
	  </li>
	</ul>
	<?php		
	}
	add_action('wp_ajax_cs_fontawsome_popup_load', 'cs_fontawsome_popup_load');
}
// Dynamci page element Ajax
if ( ! function_exists( 'cs_dcp_page_element_ajax_fun' ) ) {
	function cs_dcp_page_element_ajax_fun(){	
		$view_name = $_POST['view_name'];
		$dcpt_slug = $_POST['dcpt_slug'];
		$cs_dcpt_section_title 		= $_POST['cs_title'];
		$cs_dcpt_listing_type 		= $_POST['cs_listing'];
		$cs_dcpt_post_filterable 	= $_POST['cs_filter'];
		$cs_dcpt_post_time		 	= $_POST['cs_time'];
		$cs_dcpt_post_excerpt 		= $_POST['cs_excerpt'];
		$cs_dcpt_post_pagination 	= $_POST['cs_pagination'];
		$cs_dcpt_post_per_page 		= $_POST['cs_no_of_post'];
		$args = array(
		  'name' => $dcpt_slug,
		  'post_type' => 'dcpt',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);
		$pageelement_posts = get_posts($args);
		if( $pageelement_posts ) {
		
			$post_title = $pageelement_posts[0]->post_title;
			$post_id = $pageelement_posts[0]->ID;
		}
		$cs_categories_name = get_post_meta($post_id, 'cs_categories_name', true);
		$design_elemnts = get_post_meta($post_id, "dcpt_design_settings", true);
		if ( $design_elemnts <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($design_elemnts);		
			$designs_settings = $cs_xmlObject->designs_settings;			
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
		}		
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
				 $design_post_per_page = $designs->design_post_per_page;
				 $design_pagination = $designs->design_pagination;
				 $design_post_order = $designs->design_post_order;				 
				if((string)$view_name == (string)$design_value) 
				break;
			}
		}
		?>
	<?php if(isset($design_section_title) && $design_section_title == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Section Title','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" name="cs_dcpt_section_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_dcpt_section_title)?>" />
		</div>
		<div class="left-info">
		  <p><?php _e('Event Page Title','LMS');?></p>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_post_listing_type) && $design_post_listing_type == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Post Listing Types','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_listing_type[]" class="dropdown">
			  <option <?php if($cs_dcpt_listing_type=="All Events")echo "selected";?>><?php _e('All Events','LMS');?></option>
			  <option <?php if($cs_dcpt_listing_type=="Upcoming Events")echo "selected";?>><?php _e('Upcoming Events','LMS');?></option>
			  <option <?php if($cs_dcpt_listing_type=="Past Events")echo "selected";?>><?php _e('Past Events','LMS');?></option>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_post_categories) && $design_post_categories == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Select Post Category','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_post_category[]" class="dropdown">
			  <option value="0"><?php _e('-- All Categories Posts --','LMS');?></option>
			  <?php show_all_cats('', '', $cs_dcpt_post_category, "$cs_categories_name");?>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_show_time) && $design_show_time == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Show Time','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_post_time[]" class="dropdown">
			  <option value="Yes" <?php if($cs_dcpt_post_time=="Yes")echo "selected";?> ><?php _e('Yes','LMS');?></option>
			  <option value="No" <?php if($cs_dcpt_post_time=="No")echo "selected";?> ><?php _e('No','LMS');?></option>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_filterable) && $design_filterable == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Filterable','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_post_filterable[]" class="dropdown">
			  <option value="Yes" <?php if($cs_dcpt_post_filterable=="Yes")echo "selected";?> ><?php _e('Yes','LMS');?></option>
			  <option value="No" <?php if($cs_dcpt_post_filterable=="No")echo "selected";?> ><?php _e('No','LMS');?></option>
			</select>
		  </div>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_excerpt_length) && $design_excerpt_length == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Length of Excerpt','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" name="cs_dcpt_post_excerpt[]" class="txtfield" value="<?php echo esc_attr($cs_dcpt_post_excerpt);?>" />
		</div>
		<div class="left-info">
		  <p><?php _e('Enter number of character for short description text','LMS');?></p>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_pagination) && $design_pagination == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('Pagination','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <div class="select-style">
			<select name="cs_dcpt_post_pagination[]" class="dropdown" >
			  <option <?php if($cs_dcpt_post_pagination=="Show Pagination")echo "selected";?> ><?php _e('Show Pagination','LMS');?></option>
			  <option <?php if($cs_dcpt_post_pagination=="Single Page")echo "selected";?> ><?php _e('Single Page','LMS');?></option>
			</select>
		  </div>
		</div>
		<div class="left-info">
		  <p><?php _e('Show navigation only at List View','LMS');?></p>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php if(isset($design_post_per_page) && $design_post_per_page == 'yes'){?>
	<ul class="form-elements noborder">
	  <li class="to-label">
		<label><?php _e('No. of POSTS Per Page','LMS');?></label>
	  </li>
	  <li class="to-field">
		<div class="input-sec">
		  <input type="text" name="cs_dcpt_post_per_page[]" class="txtfield" value="<?php echo esc_attr($cs_dcpt_post_per_page); ?>" />
		</div>
		<div class="left-info">
		  <p> <?php _e('To display all the records, leave this field blank','LMS'); ?></p>
		</div>
	  </li>
	</ul>
	<?php }?>
	<?php
	}
	add_action('wp_ajax_cs_dcp_page_element_ajax_fun', 'cs_dcp_page_element_ajax_fun');
}
