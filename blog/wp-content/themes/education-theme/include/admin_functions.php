<?php
/**
 * Page Builder Functions
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 
/**
 * @Generate Random String
 */
if ( ! function_exists( 'cs_generate_random_string' ) ) {
	function cs_generate_random_string($length = 3) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}

/**
 * @Generate Random number
 */
if ( ! function_exists( 'cs_generate_random_integers' ) ) {
	function cs_generate_random_integers($length = 7) {
		$characters = '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}


/**
 * @Html Form for Page builder
 */
if ( ! function_exists( 'cs_pb_page_element' ) ) {
		function cs_pb_page_element($die = 0){
			global $cs_node, $post;
			$shortcode_element = '';
			$filter_element = 'filterdrag';
			$shortcode_view = '';
			$output = array();
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$cs_counter = $_POST['counter'];
			if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
				$POSTID = '';
				$shortcode_element_id = '';
				$name = $_POST['action'];
				$element_name = $_POST['element_name'];
				$name = 'cs_pb_'.$element_name;
			
			} else {
				$POSTID = $_POST['POSTID'];
				//$element_name = $_POST['element_name'];
				$shortcode_element_id = $_POST['shortcode_element_id'];
				$shortcode_str = stripslashes ($shortcode_element_id);
				$element_name = $_POST['element_name'];
				$name = 'cs_pb_'.$element_name;
				$PREFIX = 'cs_'.str_replace('cs_pb_','',$name);
				$parseObject 	= new ShortcodeParse();
				$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
			}
			$defaults = array( 'cs_dcpt_section_title' => '', 'cs_dcpt_listing_type'=>'','cs_dcpt_post_category' => '', 'cs_dcpt_post_view' => '', 'cs_dcpt_post_excerpt' => '255', 'cs_dcpt_post_time' => 'Yes', 'cs_dcpt_post_filterable' => '', 'cs_dcpt_post_pagination' => '', 'cs_dcpt_post_per_page' => '10', 'cs_page_element_class' => '', 'cs_page_element_animation' => '');
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			$dcptpost_element_size = '50';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$coloumn_class = 'column_'.$dcptpost_element_size;
			if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
				$shortcode_element = 'shortcode_element_class';
				$shortcode_view = 'cs-pbwp-shortcode';
				$filter_element = 'ajax-drag';
				$coloumn_class = '';
			}

		$dcpt_slug = str_replace('cs_pb_','',$name);
		$args=array(
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
		wp_reset_query();
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
		$icon='star';
		if($post_title=='Portfolio'){
			$icon='briefcase';
		}elseif($post_title=='Events'){
			$icon='calendar';
		}
?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($dcptpost_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$dcptpost_element_size,'',$icon,'page_element');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" data-shortcode-template="[cs_<?php echo str_replace('cs_pb_','',$name);?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5>
        <?php _e('Edit','LMS'); ?>
        <?php echo esc_attr($post_title);?>
        <?php _e('Options','LMS'); ?>
      </h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="loading-option"></div>
    <div class="cs-pbwp-content">
      <ul class="form-elements noborder">
        <li class="to-label">
          <label>
            <?php _e('Select View','LMS'); ?>
          </label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_dcpt_post_view[]" class="dropdown" onchange="cs_dcp_page_element_view(this.value, '<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>','<?php echo esc_js($dcpt_slug);?>','<?php echo esc_js($cs_dcpt_section_title);?>','<?php echo esc_js($cs_dcpt_listing_type);?>','<?php echo esc_js($cs_dcpt_post_filterable);?>','<?php echo esc_js($cs_dcpt_post_time);?>','<?php echo esc_js($cs_dcpt_post_excerpt);?>','<?php echo esc_js($cs_dcpt_post_pagination);?>','<?php echo esc_js($cs_dcpt_post_per_page);?>')">
                <?php 
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
							?>
                <option <?php if((string)$cs_dcpt_post_view==(string)$design_value)echo "selected";?> value="<?php echo esc_attr($design_value);?>"><?php echo esc_attr($design_title);?></option>
                <?php
						}
					}
				?>
              </select>
            </div>
          </div>
        </li>
      </ul>
      <div class="design-elements-options">
        <?php
			if ( isset($cs_xmlObject)) {
				foreach ( $cs_xmlObject->designs as $designs ){
					 $design_title = $designs->design_title;
					 $design_value = $designs->design_value;
					 $design_section_title = $designs->design_section_title;
					 $design_post_listing_type = $designs->design_post_listing_type;
					 $design_show_time = $designs->design_show_time;
					 $design_default_excerpt_length = $designs->design_default_excerpt_length;
					 $design_post_categories = $designs->design_post_categories;
					 $design_excerpt_length = $designs->design_excerpt_length;
					 $design_filterable = $designs->design_filterable;
					 $design_post_per_page = $designs->design_post_per_page;
					 $design_pagination = $designs->design_pagination;
					 $design_post_order = $designs->design_post_order;
					 break;
				}
			}
        ?>
        <?php if(isset($design_section_title) && $design_section_title == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Section Title','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="cs_dcpt_section_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_dcpt_section_title)?>" />
            </div>
          </li>
        </ul>
        <?php }?>
        <?php if(isset($design_post_listing_type) && $design_post_listing_type == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Post Listing Types','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_dcpt_listing_type[]" class="dropdown">
                  <option <?php if($cs_dcpt_listing_type=="All Events")echo "selected";?>>
                  <?php _e('All Events','LMS'); ?>
                  </option>
                  <option <?php if($cs_dcpt_listing_type=="Upcoming Events")echo "selected";?>>
                  <?php _e('Upcoming Events','LMS'); ?>
                  </option>
                  <option <?php if($cs_dcpt_listing_type=="Past Events")echo "selected";?>>
                  <?php _e('Past Events','LMS'); ?>
                  </option>
                </select>
              </div>
            </div>
          </li>
        </ul>
        <?php }?>
        <?php if(isset($design_post_categories) && $design_post_categories == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Select Post Category','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_dcpt_post_category[]" class="dropdown">
                  <option value="0">
                  <?php			 
				    _e('All Categories','LMS');  ?>
                  </option>
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
            <label> <?php _e('Show Time','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_dcpt_post_time[]" class="dropdown">
                  <option value="Yes" <?php if($cs_dcpt_post_time=="Yes")echo "selected";?> ><?php _e('Yes','LMS'); ?></option>
                  <option value="No" <?php if($cs_dcpt_post_time=="No")echo "selected";?> > <?php _e('No','LMS'); ?></option>
                </select>
              </div>
            </div>
          </li>
        </ul>
        <?php }?>
        <?php if(isset($design_filterable) && $design_filterable == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Filterable','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_dcpt_post_filterable[]" class="dropdown">
                  <option value="Yes" <?php if($cs_dcpt_post_filterable=="Yes")echo "selected";?> >
                  <?php _e('Yes','LMS'); ?>
                  </option>
                  <option value="No" <?php if($cs_dcpt_post_filterable=="No")echo "selected";?> >
                  <?php _e('No','LMS'); ?>
                  </option>
                </select>
              </div>
            </div>
          </li>
        </ul>
        <?php }?>
        <?php 
		if($cs_dcpt_post_excerpt == ''){
			$cs_dcpt_post_excerpt = $cs_dcpt_post_excerpt;
		}		
		if(isset($design_excerpt_length) && $design_excerpt_length == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Length of Excerpt','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="cs_dcpt_post_excerpt[]" class="txtfield" value="<?php echo htmlspecialchars($cs_dcpt_post_excerpt)?>" />
            </div>
            <div class="left-info">
              <p>
                <?php _e('Enter number of character for short description text.','LMS'); ?>
              </p>
            </div>
          </li>
        </ul>
        <?php }?>
        <?php if(isset($design_pagination) && $design_pagination == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('Pagination','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_dcpt_post_pagination[]" class="dropdown" >
                  <option <?php if($cs_dcpt_post_pagination=="Show Pagination")echo "selected";?> >
                  <?php _e('Show Pagination','LMS'); ?>
                  </option>
                  <option <?php if($cs_dcpt_post_pagination=="Single Page")echo "selected";?> >
                  <?php _e('Single Page','LMS'); ?>
                  </option>
                </select>
              </div>
            </div>
            <div class="left-info">
              <p>
                <?php _e('Show navigation only at List View.','LMS'); ?>
              </p>
            </div>
          </li>
        </ul>
        <?php }?>
        <?php if(isset($design_post_per_page) && $design_post_per_page == 'yes'){?>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label>
              <?php _e('No. of POSTS Per Page','LMS'); ?>
            </label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="cs_dcpt_post_per_page[]" class="txtfield" value="<?php echo htmlspecialchars($cs_dcpt_post_per_page)?>" />
            </div>
            <div class="left-info">
              <p>
                <?php _e('To display all the records, leave this field blank','LMS'); ?>
              </p>
            </div>
          </li>
        </ul>
        <?php }?>
      </div>
      <?php 
		if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
			cs_shortcode_custom_dynamic_classes($cs_page_element_class,$cs_page_element_animation,'','cs_page_element');
		}
		?>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" >
          <?php _e('Insert','LMS'); ?>
          </a> </li>
      </ul>
      
      <?php } else {?>
      <div id="results-shortocde-id-form"></div>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="page_element" />
          <input type="hidden" name="cs_page_element[]" value="<?php echo esc_attr(str_replace('cs_pb_','',$name));?>" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))"/>
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
	wp_reset_query();
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_page_element', 'cs_pb_page_element');
}

/**
 * @Page builder Element (shortcode(s))
 */
 if ( ! function_exists( 'cs_element_setting' ) ) {
	function cs_element_setting($name,$cs_counter,$element_size, $element_description='', $page_element_icon = 'fa-star',$type=''){
		$element_title = str_replace("cs_pb_","",$name);
		$element_title = str_replace("cs-","",$name);
		?>
        <div class="column-in">
          <?php  if($type == 'page_element'){?>
          <input type="hidden" name="dcptpost_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >
          <?php } else {?>
          <input type="hidden" name="<?php echo esc_attr(str_replace("cs_pb_","",$name)); ?>_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >
          <?php }?>
          <!--<a href="javascript:;" onclick="javascript:_createclone(jQuery(this),'<?php echo esc_attr($cs_counter);?>', '', '')" class="options"><i class="fa fa-star"></i></a>--><a href="javascript:;" onclick="javascript:_createpopshort(jQuery(this))" class="options"><i class="fa fa-gear"></i></a> <a href="#" class="delete-it btndeleteit"><i class="fa fa-trash-o"></i></a> &nbsp; <a class="decrement" onclick="javascript:decrement(this)"><i class="fa fa-minus"></i></a> &nbsp; <a class="increment" onclick="javascript:increment(this)"><i class="fa fa-plus"></i></a> 
          <span> <i class="fa fa-<?php echo esc_attr($page_element_icon);?>"></i> 
          <strong><?php echo strtoupper(str_replace('_',' ',str_replace("cs_pb_","",$name)))?></strong><br/>
          <?php echo esc_attr($element_description);?> </span>
        </div>
<?php
	}
}

/**
 * @Page builder Element (shortcode(s))
 */
if ( ! function_exists( 'cs_page_composer_elements' ) ) {
	function cs_page_composer_elements($element='',$icon='accordion-icon',$description='Dribble is community of designers'){
		echo '<i class="fa '.$icon.'"></i><span data-title="'.$element.'"> '.$element.'</span>';
	}
}

/**
 * @Page builder Sorting List
 */
if ( ! function_exists( 'cs_elements_categories' ) ) {
	function cs_elements_categories(){
		return array('typography'=>__('Typography','LMS'),'commonelements'=>__('Common Elements','LMS'),'mediaelement'=>__('Media Element','LMS'),'contentblocks'=>__('Content Blocks','LMS'),'loops'=>__('Loops','LMS'));
	}
}

/**
 * @Page builder Ajax Element (shortcode(s))
 */
 if ( ! function_exists( 'cs_ajax_element_setting' ) ) {
	function cs_ajax_element_setting($name,$cs_counter,$element_size, $shortcode_element_id, $POSTID, $element_description='', $page_element_icon = '',$type=''){
		global $cs_node,$post;
		$element_title = str_replace("cs_pb_","",$name);
		?>
        <div class="column-in">
          <?php  if($type == 'page_element'){?>
          <input type="hidden" name="dcptpost_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >
          <?php } else {?>
          <input type="hidden" name="<?php echo esc_attr($element_title); ?>_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >
          <?php }?>
         <!--<a href="javascript:;" onclick="javascript:_createclone(jQuery(this),'<?php echo esc_attr($cs_counter)?>', '<?php echo esc_attr($shortcode_element_id);?>', '<?php echo esc_attr($POSTID);?>')" class="options"><i class="fa fa-star"></i></a>--><a href="javascript:;" onclick="javascript:ajax_shortcode_widget_element(jQuery(this),'<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js($POSTID);?>','<?php echo esc_js($name);?>')" class="options"><i class="fa fa-gear"></i></a><a href="#" class="delete-it btndeleteit"><i class="fa fa-trash-o"></i></a> &nbsp; <a class="decrement" onclick="javascript:decrement(this)"><i class="fa fa-minus"></i></a> &nbsp; <a class="increment" onclick="javascript:increment(this)"><i class="fa fa-plus"></i></a> 
          <span> <i class="fa <?php echo esc_attr($page_element_icon);?>"></i> 
          <strong>
		  <?php 
		  if($cs_node->getName() == 'page_element'){
				$element_name = $cs_node->element_name;
				$element_name = str_replace("cs-","",$element_name);
			} else {
				$element_name = $cs_node->getName();
			}
		  
		  echo strtoupper(str_replace('_',' ',$element_name));?></strong><br/>
          <?php echo esc_attr($element_description);?> </span>
        </div>
<?php
	}
}

/**
 * @Page builder Section Settings
 */
if ( ! function_exists( 'cs_column_pb' ) ) {
	function cs_column_pb($die = 0, $shortcode=''){
 		global $cs_node, $cs_xmlObject, $cs_count_node, $post, $column_container, $coloum_width;
		
 		 $total_widget = 0;
		 $postID = $post->ID;
		 $i = 1;
		 $cs_page_section_title = $cs_page_section_height = $cs_page_section_width = '';
		 $cs_section_background_option = '';
		 $cs_section_bg_image = '';
		 $cs_section_bg_image_position = '';
		 $cs_section_parallax = '';
		 $cs_section_flex_slider = '';
		 $cs_section_custom_slider = '';
		 $cs_section_video_url = '';
		 $cs_section_ogv_url = '';
		 $cs_section_webm_url = '';
		 $cs_section_video_mute = '';
		 $cs_section_video_autoplay = '';
		 $cs_section_border_bottom = '0';
		 $cs_section_border_top = '0';
		 $cs_section_border_color = '#e0e0e0';
		 $cs_section_padding_top = '30';
		 $cs_section_padding_bottom = '30';
		 $cs_section_margin_top = '0';
		 $cs_section_margin_bottom = '30';
		 $cs_section_css_class = '';
		 $cs_section_css_id = '';
		 $cs_section_view = 'container';
		 $cs_layout = '';
		 
		 $cs_sidebar_left = '';
		 $cs_sidebar_right = ''; 
		 $cs_section_bg_color = '';
		if ( isset( $column_container ) ){
			$column_attributes= $column_container->attributes();
			 $column_class = $column_attributes->class;
			 $cs_section_background_option = $column_attributes->cs_section_background_option;
			 $cs_section_bg_image = $column_attributes->cs_section_bg_image;
			 $cs_section_bg_image_position = $column_attributes->cs_section_bg_image_position;
			 $cs_section_flex_slider = $column_attributes->cs_section_flex_slider;
			 $cs_section_custom_slider = $column_attributes->cs_section_custom_slider;
			 $cs_section_video_url = $column_attributes->cs_section_video_url;	 
			 $cs_section_ogv_url = $column_attributes->cs_section_ogv_url;	 
			 $cs_section_webm_url = $column_attributes->cs_section_webm_url;	 
			 $cs_section_video_mute = $column_attributes->cs_section_video_mute;
			 $cs_section_video_autoplay = $column_attributes->cs_section_video_autoplay;
			 $cs_section_bg_color = $column_attributes->cs_section_bg_color; 
			 $cs_section_parallax = $column_attributes->cs_section_parallax;
			 $cs_section_padding_top = $column_attributes->cs_section_padding_top;
			 $cs_section_padding_bottom = $column_attributes->cs_section_padding_bottom; 
			 $cs_section_border_bottom = $column_attributes->cs_section_border_bottom;
			 $cs_section_border_top = $column_attributes->cs_section_border_top;
			 $cs_section_border_color = $column_attributes->cs_section_border_color;
			 $cs_section_margin_top = $column_attributes->cs_section_margin_top;
			 $cs_section_margin_bottom = $column_attributes->cs_section_margin_bottom;
			 $cs_section_css_id = $column_attributes->cs_section_css_id;
			 $cs_section_view = $column_attributes->cs_section_view;
			 $cs_layout = $column_attributes->cs_layout;
			 $cs_sidebar_left = $column_attributes->cs_sidebar_left;
			 $cs_sidebar_right = $column_attributes->cs_sidebar_right; 
		}
		$style='';
	
		if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$cs_counter = $_POST['counter'];
			$total_column = $_POST['total_column'];
			$column_class = $_POST['column_class'];
			$randomno = cs_generate_random_string('5');
			$rand = rand(1,999);
			$style='';
		} else {
			$name = '';
			$cs_counter = '';
			$total_column = 0;
			$rand = rand(1,999);
			$randomno = cs_generate_random_string('5');
			$name = $_REQUEST['action'];
			$style='style="display:none;"';
		}
		$cs_page_elements_name = cs_shortcode_names();
		$cs_page_elements_dcpt_name = cs_shortcode_dcpt_names();
		$cs_page_categories_name =  cs_elements_categories();
		
	?>
<div class="cs-page-composer composer-<?php echo cs_allow_special_char($rand)?>" id="composer-<?php echo cs_allow_special_char($rand);?>" style="display:none">
  <div class="page-elements">
    <div class="cs-heading-area">
      <h5> <i class="fa fa-plus-circle"></i><?php _e('Add Element','LMS')?> </h5>
      <span class='cs-btnclose' onclick='javascript:removeoverlay("composer-<?php echo esc_js($rand);?>","append")'><i class="fa fa-times"></i></span> </div>
		<script>
            jQuery(document).ready(function($){
                cs_page_composer_filterable('<?php echo esc_js($rand);?>');
            });
        </script>
    <div class="cs-filter-content">
      <p><input type="text" id="quicksearch<?php echo cs_allow_special_char($rand)?>" placeholder="<?php _e('Search','LMS')?>" /></p>
      <div class="cs-filtermenu-wrap">
        <h6><?php  _e('Filter by','LMS'); ?></h6>
        <ul class="cs-filter-menu" id="filters<?php echo cs_allow_special_char($rand)?>">
          <li data-filter="all" class="active"><?php  _e('Show all','LMS'); ?></li>
          <?php foreach($cs_page_categories_name as $key=>$value){?>
          <li data-filter="<?php echo esc_attr($key);?>"><?php echo esc_attr($value);?></li>
          <?php }?>
        </ul>
      </div>
      <div class="cs-filter-inner" id="page_element_container<?php echo esc_attr($rand)?>">
        <?php foreach($cs_page_elements_name as $key=>$value){?>
        <div class="element-item <?php echo esc_attr($value['categories']);?>"> <a href='javascript:ajaxSubmitwidget("cs_pb_<?php echo esc_js($value['name']);?>","<?php echo esc_js($rand)?>")'>
          <?php cs_page_composer_elements($value['title'], $value['icon']); ?>
          </a> </div>
        <?php }?>
        <?php foreach($cs_page_elements_dcpt_name as $key=>$value){
       			if($key=='cs-events'){
					$icon = 'fa-calendar';
				}elseif($key=='portfolio'){
					$icon = 'fa-briefcase';
				}else{ $icon ='fa-star';}
					
					?>
        <div class="element-item <?php echo esc_attr($value['categories']);?>">
         <a href='javascript:ajaxSubmitwidget_element("cs_pb_<?php echo esc_js($value['name']);?>","<?php echo esc_js($rand)?>","<?php echo esc_js($key);?>")'>
          <?php cs_page_composer_elements($value['title'],$icon)?>
          </a>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<?php 
if(isset($shortcode) && $shortcode <> ''){
	?>
	<a class="button" href="javascript:_createpop('composer-<?php echo cs_allow_special_char($rand)?>', 'filter')"><i class="fa fa-plus-circle"></i> CS: Insert shortcode</a>
<?php
} else {
?>
<div id="<?php echo cs_allow_special_char($randomno)?>_del" class="column columnmain parentdeletesection column_100" >
  <div class="column-in"> <a class="button" href="javascript:_createpop('composer-<?php echo cs_allow_special_char($rand)?>', 'filter')"><i class="fa fa-plus-circle"></i> <?php _e('Add Element','LMS')?></a>
    <p> <a href="javascript:_createpop('<?php echo cs_allow_special_char($column_class.$randomno);?>','filterdrag')" class="options"><i class="fa fa-gear"></i></a> &nbsp; <a href="#" class="delete-it btndeleteitsection"><i class="fa fa-trash-o"></i></a> &nbsp; </p>
  </div>
  <div class="column column_container page_section <?php echo cs_allow_special_char($column_class);?>" >
    <?php
		$parts = explode('_', $column_class);
		if ( $total_column > 0  ){
			for ( $i = 1; $i <= $total_column; $i++ ) {
			?>
    <div class="dragarea" data-item-width="col_width_<?php echo cs_allow_special_char($parts[$i]);?>">
      <input name="total_widget[]" type="hidden" value="0" class="textfld" />
      <div class="draginner" id="counter_<?php echo cs_allow_special_char($rand);?>"></div>
    </div>
    <?php 
		}
	}
	$i = 1;
	
	if ( isset( $column_container ) ) {
		global $wpdb;
		$total_column = count($column_container->children());
		$section = 0;
		$section_widget_element_num = 0;
		foreach ( $column_container->children() as $column ){
			$section++;
			$total_widget = count($column->children());
			?>
            <div class="dragarea" data-item-width="col_width_<?php echo cs_allow_special_char($parts[$i]);?>">
              <div class="toparea">
                <input name="total_widget[]" type="hidden" value="<?php echo cs_allow_special_char($total_widget);?>" class="textfld page-element-total-widget" />
              </div>
              <div class="draginner" id="counter_<?php echo esc_attr($rand);?>">
                <?php
                    $shortcode_element = '';
                    $abccc_golabal = 'Glo0ab testinggg';
                    $filter_element = 'filterdrag';
                    $shortcode_view = '';
                    $global_array = array();
                    $section_widget__element = 0;
                    foreach ( $column->children() as $cs_node ){
						
                        $section_widget__element++;
                        $shortcode_element_idd = $rand.'_'.$section_widget__element;
                        $global_array[] = $cs_node;
                        $cs_count_node++;
                        $cs_counter = $postID.$cs_count_node;
                        $a = $name = "cs_pb_".$cs_node->getName();
                        $coloumn_class = 'column_'.$cs_node->page_element_size;
                        $abbbbc = (string)$cs_node->cs_shortcode;
						$type = '';
						if($cs_node->getName() == 'page_element'){
							$type = 'page_element';
						}
						$page_icon ='fa-star';
						$page_element_icon = cs_shortcode_names();
						if(isset($page_element_icon[$cs_node->getName()]['icon'])){
							$page_icon = $page_element_icon[$cs_node->getName()]['icon'];
							
						}else if(str_replace("cs-","",$cs_node->element_name)=='events'){
							
							$page_icon = 'fa-calendar';
						}elseif(str_replace("cs-","",$cs_node->element_name)=='portfolio'){
							
							$page_icon = 'fa-briefcase';
						}
						
                        ?>
                    <div id="<?php echo cs_allow_special_char($name.$cs_counter);?>_del" class="column  parentdelete  <?php echo cs_allow_special_char($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="<?php echo esc_attr($cs_node->getName());?>" data="<?php echo element_size_data_array_index($cs_node->page_element_size)?>" >
                    <?php cs_ajax_element_setting($cs_node->getName(),$cs_counter,$cs_node->page_element_size,$shortcode_element_idd, $postID, $element_description='', $page_icon,$type);?>
                        <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" style="display: none;">
                            <div class="cs-heading-area">
                                <h5>Edit 
                                <?php 
								if($cs_node->getName() == 'page_element'){
									echo str_replace("cs-","",$cs_node->element_name);
								} else {
									echo esc_attr($cs_node->getName());
								}
								?> 
                                Options</h5>
                                <a href="javascript:;" onclick="javascript:_removerlay(jQuery(this))" class="cs-btnclose"><i class="fa fa-times"></i></a>
                            </div>
                            <?php 
							echo '<input type="hidden"  class="cs-wiget-element-type"  id="shortcode_'.cs_allow_special_char($name.$cs_counter).'" name="cs_widget_element_num[]" value="shortcode" />';
							?>
                            <div class="pagebuilder-data-load">
								<?php
									if($cs_node->getName() == 'page_element'){
										echo '<input type="hidden" class="cs-dcpt-element" name="cs_dcpt_element__element_name_slug[]" value="'.esc_attr($cs_node->element_name).'" />';	
									}
                                	echo '<input type="hidden" name="cs_orderby[]" value="'.cs_allow_special_char($cs_node->getName()).'" />';
                                	echo '<textarea name="shortcode['.cs_allow_special_char($cs_node->getName()).'][]" style="display:none;" class="cs-textarea-val">'.htmlspecialchars_decode($cs_node->cs_shortcode).'</textarea>';
                                 ?>
                            </div>
                         </div>
                    </div>
                    <?php
                    }
                    ?>
              </div>
            </div>
    <?php
			$i++;
		}
	}
	?>
  </div>
<div id="<?php echo esc_attr($column_class.$randomno);?>" style="display:none">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Page Section','LMS'); ?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($column_class.$randomno);?>','filterdrag')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <ul class="form-elements  noborder">
        <li class="to-label">
          <label><?php _e('Background View','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_section_background_option[]" class="dropdown" onchange="javascript:cs_section_background_settings_toggle(this.value,'<?php echo esc_attr($randomno);?>')">
                <option <?php if($cs_section_background_option=='no-image') echo "selected";?> value="no-image"><?php  _e('None','LMS'); ?></option>
                <option <?php if($cs_section_background_option=='section-custom-background-image') echo "selected";?> value="section-custom-background-image"><?php  _e('Background Image','LMS'); ?></option>
                <option <?php if($cs_section_background_option=='section-custom-slider') echo "selected";?> value="section-custom-slider">
				<?php  _e('Custom Slider','LMS'); ?></option>
                <option  <?php if($cs_section_background_option=='section_background_video')echo "selected";?> value="section_background_video" ><?php  _e('Video','LMS'); ?> </option>
              </select>
            </div>
          </div>
        </li>
      </ul>
      <div class="meta-body noborder section-custom-background-image-<?php echo esc_attr($randomno);?>" style=" <?php if($cs_section_background_option == "section-custom-background-image"){echo "display:block";}else echo "display:none";?>" >
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Image','LMS'); ?></label>
          </li>
          <li class="to-field">
            <input id="cs_section_bg_image<?php echo cs_allow_special_char($rand)?>" name="cs_section_bg_image[]" type="hidden" class="" value="<?php echo esc_attr($cs_section_bg_image);?>"/>
            <input name="cs_section_bg_image<?php echo cs_allow_special_char($rand)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/>
          </li>
        </ul>
        <div class="page-wrap" style="overflow:hidden; display:<?php echo cs_allow_special_char($cs_section_bg_image) && trim($cs_section_bg_image) !='' ? 'inline' : 'none';?>" id="cs_section_bg_image<?php echo esc_attr($rand)?>_box" >
          <div class="gal-active">
            <div class="dragareamain" style="padding-bottom:0px;">
              <ul id="gal-sortable">
                <li class="ui-state-default" id="">
                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_section_bg_image);?>"  id="cs_section_bg_image<?php echo cs_allow_special_char($rand)?>_img" width="100" height="150"  />
                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_section_bg_image<?php echo cs_allow_special_char($rand)?>')" class="delete"></a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="form-elements noborder">
          <li class="to-label">
            <label><?php _e('Background Image Position','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_section_bg_image_position[]" class="select_dropdown">
                  <option value="">Select position</option>
                  <option value="left" <?php if ($cs_section_bg_image_position=='light')echo "selected";?>><?php  _e('Left','LMS'); ?></option>
                  <option value="right" <?php if ($cs_section_bg_image_position=='right')echo "selected";?>><?php  _e('Right','LMS'); ?></option>
                  <option value="center" <?php if ($cs_section_bg_image_position=='center')echo "selected";?>><?php  _e('Center','LMS'); ?></option>
                  <option value="repeat" <?php if ($cs_section_bg_image_position=='repeat')echo "selected";?>><?php  _e('Repeat','LMS'); ?></option>
                </select>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="meta-body noborder section-slider-<?php echo esc_attr($randomno);?>" style=" <?php if($cs_section_background_option == "section-slider"){echo "display:block";}else echo "display:none";?>" >
        <?php //cs_section_slider('section_field_name2');?>
      </div>
      <div class="meta-body noborder section-custom-slider-<?php echo esc_attr($randomno);?>" style=" <?php if($cs_section_background_option == "section-custom-slider"){echo "display:block";}else echo "display:none";?>" >
        <ul class="form-elements noborder">
          <li class="to-label">
            <label><?php _e('Custom Slider','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
                <input type="text" name="cs_section_custom_slider[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_section_custom_slider);?>" />
            </div>
          </li>
        </ul>
      </div>
      <div class="meta-body noborder section-background-video-<?php echo cs_allow_special_char($randomno);?>" style=" <?php if($cs_section_background_option == "section_background_video"){echo "display:block";}else echo "display:none";?>">
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Video Url','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input id="cs_section_video_url_<?php echo cs_allow_special_char($randomno);?>" name="cs_section_video_url[]" value="<?php echo cs_allow_special_char($cs_section_video_url);?>" type="text" />
              <label class="cs-browse">
                <input name="cs_section_video_url_<?php echo cs_allow_special_char($randomno);?>" type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>" />
              </label>
            </div>
            <div class="left-info">
              <p><?php _e('Please enter Vimeo/Youtube Video Url','LMS'); ?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('OGV Url','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input id="cs_section_ogv_url_<?php echo cs_allow_special_char($randomno);?>" name="cs_section_ogv_url[]" value="<?php echo cs_allow_special_char($cs_section_video_url);?>" type="text" />
              <label class="cs-browse">
                <input name="cs_section_ogv_url_<?php echo cs_allow_special_char($randomno);?>" type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>" />
              </label>
            </div>
            <div class="left-info">
              <p><?php _e('Please enter alternate sources for maximum HTML5 playback','LMS'); ?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('WEBM Url','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input id="cs_section_webm_url_<?php echo cs_allow_special_char($randomno);?>" name="cs_section_webm_url[]" value="<?php echo cs_allow_special_char($cs_section_webm_url);?>" type="text" />
              <label class="cs-browse">
                <input name="cs_section_webm_url_<?php echo cs_allow_special_char($randomno);?>" type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>" />
              </label>
            </div>
            <div class="left-info">
              <p><?php _e('Please enter alternate sources for maximum HTML5 playback','LMS'); ?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
        <li class="to-label">
          <label><?php  _e('Enable Mute','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_section_video_mute[]" class="select_dropdown">
                <option value="yes" <?php if ($cs_section_video_mute=='yes')echo "selected";?>><?php _e('Yes','LMS'); ?></option>
                <option value="no" <?php if ($cs_section_video_mute=='no')echo "selected";?>><?php _e('No','LMS'); ?></option>
              </select>
            </div>
          </div>
        </li>
      </ul>
      <ul class="form-elements">
        <li class="to-label">
          <label><?php _e('Video Auto Play','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_section_video_autoplay[]" class="select_dropdown">
                <option value="yes" <?php if ($cs_section_video_autoplay=='yes')echo "selected";?>><?php _e('Yes','LMS'); ?></option>
                <option value="no" <?php if ($cs_section_video_autoplay=='no')echo "selected";?>><?php _e('No','LMS'); ?></option>
              </select>
            </div>
          </div>
        </li>
      </ul>
      </div>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Enable Parallax','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_section_parallax[]" class="select_dropdown">
                <option value="no" <?php if ($cs_section_parallax=='no')echo "selected";?>><?php  _e('No','LMS'); ?></option>
                <option value="yes" <?php if ($cs_section_parallax=='yes')echo "selected";?>><?php  _e('Yes','LMS'); ?></option>
              </select>
            </div>
          </div>
        </li>
      </ul>
      <ul class="form-elements">
        <li class="to-label">
          <label><?php _e('Select View','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="select-style">
              <select name="cs_section_view[]" class="select_dropdown">
                <option value="container" <?php if ($cs_section_view=='container')echo "selected";?>><?php _e('Box','LMS'); ?></option>
                <option value="wide" <?php if ($cs_section_view=='wide')echo "selected";?>><?php _e('Wide','LMS'); ?></option>
              </select>
            </div>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Background Color','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <input type="text" name="cs_section_bg_color[]" class="bg_color" value="<?php if(isset($cs_section_bg_color)) echo esc_attr($cs_section_bg_color);?>" />
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Padding Top','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_padding_top);?>"></div>
            <input  class="cs-range-input"  name="cs_section_padding_top[]" type="text" value="<?php echo esc_attr($cs_section_padding_top)?>"   />
            <p><?php _e('Set the Padding top (In px)','LMS'); ?></p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Padding Bottom','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_padding_bottom)?>"></div>
            <input  class="cs-range-input"  name="cs_section_padding_bottom[]" type="text" value="<?php echo esc_attr($cs_section_padding_bottom);?>"   />
            <p><?php _e('Set the Padding Bottom (In px)','LMS'); ?></p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Margin Top','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_margin_top);?>"></div>
            <input  class="cs-range-input"  name="cs_section_margin_top[]" type="text" value="<?php echo esc_attr($cs_section_margin_top);?>"   />
            <p><?php  _e('Background Image','LMS'); ?>Set the Border Bottom (In px)</p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Margin Bottom','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_margin_bottom);?>"></div>
            <input  class="cs-range-input"  name="cs_section_margin_bottom[]" type="text" value="<?php echo esc_attr($cs_section_margin_bottom);?>"   />
            <p><?php _e('Set the Margin Bottom (In px)','LMS'); ?></p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php _e('Border Top','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_border_top);?>"></div>
            <input  class="cs-range-input"  name="cs_section_border_top[]" type="text" value="<?php echo esc_attr($cs_section_border_top);?>"   />
            <p><?php _e('Set the Border top (In px)','LMS'); ?></p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php  _e('Border Bottom','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <div class="cs-drag-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo esc_attr($cs_section_border_bottom);?>"></div>
            <input  class="cs-range-input"  name="cs_section_border_bottom[]" type="text" value="<?php echo esc_attr($cs_section_border_bottom);?>"   />
            <p><?php _e('Set the Border Bottom (In px)','LMS'); ?></p>
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php  _e('Border Color','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <input type="text" name="cs_section_border_color[]" class="bg_color" value="<?php echo esc_attr($cs_section_border_color);?>" />
          </div>
        </li>
      </ul>
      <ul class="form-elements noborder">
        <li class="to-label">
          <label><?php  _e('Custom Id','LMS'); ?></label>
        </li>
        <li class="to-field">
          <div class="input-sec">
            <input type="text" name="cs_section_css_id[]" class="txtfield" value="<?php echo esc_attr($cs_section_css_id);?>" />
          </div>
        </li>
      </ul>
      <div class="form-elements elementhiddenn">
        <ul class="noborder">
          <li class="to-label">
            <label><?php  _e('Select Layout','LMS'); ?></label>
          </li>
          <li class="to-field">
            <div class="meta-input">
              <div class="meta-input pattern">
                <div class='radio-image-wrapper'>
                  <input <?php if($cs_layout=="none")echo "checked"?> onclick="show_sidebar('none','<?php echo esc_js($randomno)?>')" type="radio" name="cs_layout[<?php echo esc_js($rand);?>][]" class="radio_cs_sidebar" value="none" id="radio_1<?php echo esc_js($randomno)?>" />
                  <label for="radio_1<?php echo esc_js($randomno);?>"> <span class="ss"><img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/no_sidebar.png');?>"  alt="" /></span> <span <?php if($cs_layout=="none")echo "class='check-list'"?> id="check-list"></span> </label>
                </div>
                <div class='radio-image-wrapper'>
                  <input <?php if($cs_layout=="right")echo "checked"?> onclick="show_sidebar('right','<?php echo esc_js($randomno)?>')" type="radio" name="cs_layout[<?php echo esc_attr($rand)?>][]" class="radio_cs_sidebar" value="right" id="radio_2<?php echo esc_attr($randomno)?>"  />
                  <label for="radio_2<?php echo esc_attr($randomno);?>"> <span class="ss"><img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/sidebar_right.png');?>" alt="" /></span> <span <?php if($cs_layout=="right")echo "class='check-list'"?> id="check-list"></span> </label>
                </div>
                <div class='radio-image-wrapper'>
                  <input <?php if($cs_layout=="left")echo "checked"?> onclick="show_sidebar('left','<?php echo esc_js($randomno)?>')" type="radio" name="cs_layout[<?php echo esc_attr($rand)?>][]" class="radio_cs_sidebar" value="left" id="radio_3<?php echo esc_attr($randomno);?>" />
                  <label for="radio_3<?php echo esc_attr( $randomno );?>"> <span class="ss"><img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/sidebar_left.png');?>" alt="" /></span> <span <?php if($cs_layout=="left")echo "class='check-list'"?> id="check-list"></span> </label>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <ul class="meta-body" style=" <?php if($cs_layout == "left"){echo "display:block";}else echo "display:none";?>" id="<?php echo esc_attr($randomno)?>_sidebar_left" >
          <li class="to-label">
            <label><?php  _e('Select Left Sidebar','LMS'); ?></label>
          </li>
          <li class="to-field">
            <select name="cs_sidebar_left[]" class="select_dropdown">
              <?php
			  		 global $wpdb, $cs_theme_options;
					 $cs_theme_options = $cs_theme_options;
				$cs_theme_options = $cs_theme_options;
				if ( isset($cs_theme_options['sidebar']) and count($cs_theme_options['sidebar']) > 0 ) {
					foreach ( $cs_theme_options['sidebar'] as $sidebar ){?>
				<option <?php if ($cs_sidebar_left==$sidebar)echo "selected";?> ><?php echo esc_attr($sidebar);?></option>
				<?php
					}
				}
			 ?>
            </select>
            <p><?php _e(' Add New Sidebar','LMS'); ?><a href="<?php echo esc_url(admin_url('themes.php?page=cs_theme_options#tab-manage-sidebars-show'));?>" target="_blank"><?php _e('Click Here','LMS'); ?></a></p>
          </li>
        </ul>
        <ul class="meta-body" style=" <?php if($cs_layout == "right"){echo "display:block";}else echo "display:none";?>" id="<?php echo esc_attr($randomno)?>_sidebar_right" >
          <li class="to-label">
            <label><?php _e('Select Right Sidebar','LMS'); ?></label>
          </li>
          <li class="to-field">
            <select name="cs_sidebar_right[]" class="select_dropdown">
              <?php
				if ( isset($cs_theme_options['sidebar']) and count($cs_theme_options['sidebar']) > 0 ) {
					foreach ( $cs_theme_options['sidebar'] as $sidebar ){
					?>
              <option <?php if ($cs_sidebar_right==$sidebar)echo "selected";?> ><?php echo esc_attr($sidebar);?></option>
              <?php
					}
				}
				?>
            </select>
            <p><?php _e(' Add New Sidebar','LMS'); ?> <a href="<?php echo  esc_url(admin_url('themes.php?page=cs_theme_options#tab-manage-sidebars-show'));?>" target="_blank"><?php _e(' Click Here','LMS'); ?></a></p>
          </li>
        </ul>
      </div>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:removeoverlay('<?php echo esc_js($column_class.$randomno)?>','filterdrag')" />
        </li>
      </ul>
    </div>
  </div>
  <input type="hidden" name="column_rand_id[]" value="<?php echo esc_attr($rand)?>" />
  <input type="hidden" name="column_class[]" value="<?php echo esc_attr($column_class)?>" />
  <input type="hidden" name="total_column[]" value="<?php echo esc_attr($total_column)?>" />
</div>
<?php

		}
	
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_column_pb', 'cs_column_pb');
}


/**
 * @Import, Export Theme Options
 */
if ( ! function_exists( 'theme_option_import_export' ) ) {
	function theme_option_import_export() {
		if($_POST['theme_option_data'] and $_POST['theme_option_data'] <> ''){
			$a = unserialize(base64_decode(trim($_POST['theme_option_data'])));
			update_option( "cs_theme_options", $a );
			echo "OPtions Imported";
			die();
		}else{
			echo "Import failed<br>Textarea is empty.";
			die();
		}
	}
	add_action('wp_ajax_theme_option_import_export', 'theme_option_import_export');
}

/**
 * @Restore Default Theme Options
 */
if ( ! function_exists( 'theme_option_restore_default' ) ) {
	function theme_option_restore_default() {
		update_option( "cs_theme_options", get_option('cs_theme_option_restore') );
		echo __("Default Theme Options Restored","LMS");
		die();
	}
	add_action('wp_ajax_theme_option_restore_default', 'theme_option_restore_default');
}

/**
 * @Backup Theme Options
 */
if ( ! function_exists( 'theme_options_backup' ) ) {
	function theme_options_backup() {
		update_option( "cs_theme_options_backup", get_option('cs_theme_options') );
		update_option( "cs_theme_options_backup_time", gmdate("Y-m-d H:i:s") );
		echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");
		die();
	}
	add_action('wp_ajax_theme_options_backup', 'theme_options_backup');
}

/**
 * @Restore Backup Theme Options
 */
if ( ! function_exists( 'theme_options_backup_restore' ) ) {
	function theme_option_backup_restore() {
		update_option( "cs_theme_options", get_option('cs_theme_options_backup') );
		echo __("Backup Restored","LMS");
		die();
	}
	add_action('wp_ajax_theme_options_backup_restore', 'theme_options_backup_restore');
}

/**
 * @Media Pagination for slider/gallery in admin side
 */
if ( ! function_exists( 'media_pagination' ) ) {
	function media_pagination($id='',$func='clone'){
		foreach ( $_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$records_per_page = 18;
		if ( empty($page_id) ) $page_id = 1;
		$offset = $records_per_page * ($page_id-1);
	
	?>
    <ul class="gal-list">
      <?php
            $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
            $query_images = new WP_Query( $query_images_args );
            if ( empty($total_pages) ) $total_pages = count( $query_images->posts );
            $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
            $query_images = new WP_Query( $query_images_args );
            $images = array();
            foreach ( $query_images->posts as $image) {
                $image_path = wp_get_attachment_image_src( (int)$image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
    
            ?>
        <li style="cursor:pointer"><img src="<?php echo esc_url($image_path[0])?>" onclick="javascript:<?php echo esc_attr($func);?>('<?php echo esc_js($image->ID)?>','gal-sortable-<?php echo esc_js($id);?>')" alt="" /></li>
      <?php } ?>
    </ul>
	<br />
    <div class="pagination-cus">
      <ul>
        <?php
            if ( $page_id > 1 ) echo "<li><a href='javascript:show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
                for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
                    if ( $i <> $page_id ) echo "<li><a href='javascript:show_next($i,$total_pages)'>" . $i . "</a></li> ";
                    else echo "<li class='active'><a>" . $i . "</a></li>";
                }
            if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
        ?>
      </ul>
    </div>
<?php
		if ( isset($_POST['action']) ) die();
	}
	add_action('wp_ajax_media_pagination', 'media_pagination');
}

/**
 * @Media Slider Pagination
 */
if ( ! function_exists( 'slider_media_pagination' ) ) {
	function slider_media_pagination($id='',$func='clone'){
  	
		foreach ( $_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$records_per_page = 18;
		if ( empty($page_id) ) $page_id = 1;
		$offset = $records_per_page * ($page_id-1);
	
	?>
    <ul class="gal-list">
      <?php
            $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
            $query_images = new WP_Query( $query_images_args );
            if ( empty($total_pages) ) $total_pages = count( $query_images->posts );
            $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
            $query_images = new WP_Query( $query_images_args );
            $images = array();
            foreach ( $query_images->posts as $image) {
                $image_path = wp_get_attachment_image_src( (int)$image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
            ?>
      <li style="cursor:pointer"><img src="<?php echo esc_url($image_path[0])?>" onclick="javascript:slider('<?php echo esc_js($image->ID);?>','gal-sortable-<?php echo esc_js($id);?>')" alt="" /></li>
      <?php  } ?>
    </ul>
	<br />
    <div class="pagination-cus">
      <ul>
        <?php
            if ( $page_id > 1 ) echo "<li><a href='javascript:slider_show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
                for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
                    if ( $i <> $page_id ) echo "<li><a href='javascript:slider_show_next($i,$total_pages)'>" . $i . "</a></li> ";
                    else echo "<li class='active'><a>" . $i . "</a></li>";
                }
            if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:slider_show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
    
            ?>
      </ul>
    </div>
<?php
		if ( isset($_POST['action']) ) die();
	}
	add_action('wp_ajax_slider_media_pagination', 'slider_media_pagination');
}
/**
 * @Make a copy of media image for slider start
 */
if ( ! function_exists( 'cs_slider_clone' ) ) {
	function cs_slider_clone(){
		global $cs_node, $cs_counter;
		if( isset($_POST['action']) ) {
			$cs_node = new stdClass();
			$cs_node->cs_slider_title = '';
			$cs_node->cs_slider_description = '';
			$cs_node->cs_slider_link = '';
			$cs_node->cs_slider_link_target = '';
			$cs_node->slider_use_image_as = '';
			$cs_node->slider_video_code = '';
		}
		if ( isset($_POST['counter']) ) $cs_counter = esc_attr($_POST['counter']);
		if ( isset($_POST['path']) ) $cs_node->cs_slider_path = esc_attr($_POST['path']);
	
	?>
    <li class="ui-state-default" id="<?php echo esc_attr($cs_counter)?>">
      <div class="thumb-secs">
        <?php $image_path = wp_get_attachment_image_src( (int)$cs_node->cs_slider_path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
        <img src="<?php echo esc_url($image_path[0]);?>" alt="">
        <div class="gal-edit-opts"> 
          <a href="javascript:slidedit(<?php echo esc_attr($cs_counter)?>)" class="edit"></a> <a href="javascript:del_this('inside_post_thumb_slider',<?php echo esc_attr($cs_counter)?>)" class="delete"></a> </div>
      </div>
      <div class="poped-up" id="edit_<?php echo esc_attr($cs_counter)?>">
        <div class="cs-heading-area">
          <h5><?php  _e('Edit Options','LMS'); ?></h5>
          <a href="javascript:slideclose(<?php echo esc_attr($cs_counter)?>)" class="closeit">&nbsp;</a>
          <div class="clear"></div>
        </div>
        <div class="cs-pbwp-content">
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Image Title','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="cs_slider_title[]" value="<?php echo htmlspecialchars($cs_node->cs_slider_title)?>" class="txtfield" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Image Description','LMS'); ?></label>
            </li>
            <li class="to-field">
              <textarea class="txtarea" name="cs_slider_description[]"><?php echo htmlspecialchars($cs_node->cs_slider_description)?></textarea>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Link','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="cs_slider_link[]" value="<?php echo htmlspecialchars($cs_node->cs_slider_link)?>" class="txtfield" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Link Target','LMS'); ?></label>
            </li>
            <li class="to-field">
              <select name="cs_slider_link_target[]" class="select_dropdown">
                <option <?php if($cs_node->link_target=="_self")echo "selected";?> >_self</option>
                <option <?php if($cs_node->link_target=="_blank")echo "selected";?> >_blank</option>
              </select>
              <p><?php  _e('Please select image target','LMS'); ?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"></li>
            <li class="to-field">
              <input type="hidden" name="cs_slider_path[]" value="<?php echo esc_attr($cs_node->cs_slider_path)?>" />
              <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo esc_attr($cs_counter)?>)" class="close-submit" />
            </li>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
    </li>
<?php
		if ( isset($_POST['action']) ) die();
	}
	add_action('wp_ajax_slider_clone', 'cs_slider_clone');
}


/**
 * @Make a copy of media image for gallery start
 */
if ( ! function_exists( 'cs_gallery_clone' ) ) {
	function cs_gallery_clone($clone_field_name = ''){
		global $cs_node, $cs_counter;
		if( isset($_POST['action']) ) {
			$cs_node = new stdClass();
			$cs_node->title = "";
			$cs_node->use_image_as = "";
			$cs_node->video_code = "";
			$cs_node->link_url = "";
			$cs_node->use_image_as_db = "";
			$cs_node->link_url_db = '';
		}
		if ( isset($_POST['counter']) ) $cs_counter = esc_attr($_POST['counter']);
		if ( isset($_POST['path']) ) $cs_node->path = esc_attr($_POST['path']);
	?>
    <li class="ui-state-default" id="<?php echo esc_attr($cs_counter)?>">
      <div class="thumb-secs">
        <?php $image_path = wp_get_attachment_image_src( (int)$cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
        <img src="<?php echo esc_url($image_path[0])?>" alt="">
        <div class="gal-edit-opts"> 
          <a href="javascript:galedit(<?php echo esc_js($cs_counter)?>)" class="edit"></a> <a href="javascript:del_this('post_thumb_slider',<?php echo esc_js($cs_counter);?>)" class="delete"></a> </div>
      </div>
      <div class="poped-up" id="edit_<?php echo esc_attr($cs_counter)?>">
        <div class="cs-heading-area">
          <h5><?php  _e('Edit Options','LMS'); ?></h5>
          <a href="javascript:galclose(<?php echo esc_attr($cs_counter)?>)" class="closeit">&nbsp;</a> </div>
        <div class="cs-pbwp-content">
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Image Title','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="<?php echo esc_attr($clone_field_name);?>title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Use Image As','LMS'); ?></label>
            </li>
            <li class="to-field">
              <select name="<?php echo esc_attr($clone_field_name);?>use_image_as[]" class="select_dropdown" onchange="cs_toggle_gal(this.value, <?php echo esc_attr($cs_counter)?>)">
                <option <?php if($cs_node->use_image_as=="0")echo "selected";?> value="0"><?php  _e('LightBox to current thumbnail','LMS'); ?></option>
                <option <?php if($cs_node->use_image_as=="1")echo "selected";?> value="1"><?php  _e('LightBox to Video','LMS'); ?></option>
                <option <?php if($cs_node->use_image_as=="2")echo "selected";?> value="2"><?php  _e('Url','LMS'); ?></option>
              </select>
              <p><?php  _e('Please select Image link where it will go','LMS'); ?></p>
            </li>
          </ul>
          <ul class="form-elements" id="video_code<?php echo esc_attr($cs_counter)?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="2")echo 'style="display:none"';?> >
            <li class="to-label">
              <label><?php  _e('Video Url','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="<?php echo esc_attr($clone_field_name);?>video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />
              <p><?php  _e('(Enter Specific Video Url Youtube or Vimeo)','LMS'); ?></p>
            </li>
          </ul>
          <ul class="form-elements" id="<?php echo esc_attr($clone_field_name);?>link_url<?php echo esc_attr($cs_counter);?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >
            <li class="to-label">
              <label><?php  _e('Url','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="<?php echo esc_attr($clone_field_name);?>link_url[]" value="<?php echo htmlspecialchars($cs_node->link_url)?>" class="txtfield" />
              <p><?php  _e('Enter Specific Link','LMS'); ?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"></li>
            <li class="to-field">
              <input type="hidden" name="<?php echo esc_attr($clone_field_name);?>path[]" value="<?php echo esc_attr($cs_node->path)?>" />
              <input type="button" onclick="javascript:galclose(<?php echo esc_attr($cs_counter)?>)" value="Submit" class="close-submit" />
            </li>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
    </li>
<?php
		if ( isset($_POST['action']) ) die();
	}
	add_action('wp_ajax_gallery_clone', 'cs_gallery_clone');
}
/**
 * @add Team Scoial function
 */ 
if ( ! function_exists( 'cs_add_social_to_list' ) ) {
	function cs_add_social_to_list(){
		global $counter_social, $var_cp_title, $var_cp_image_url , $var_cp_team_text;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
	?>
    <tr id="edit_track<?php echo esc_attr($counter_social)?>">
      <td id="album-title<?php echo esc_attr($counter_social)?>" style="width:80%;"><?php echo esc_attr($var_cp_title)?></td>
      <td class="centr" style="width:20%;"><a href="javascript:openpopedup('edit_track_form<?php echo esc_js($counter_social);?>')" class="actions edit">&nbsp;</a> <a onclick="javascript:return confirm('Are you sure! You want to delete this social icon')" href="javascript:cs_div_remove('edit_track<?php echo esc_js($counter_social);?>')" class="actions delete">&nbsp;</a>
        <div class="poped-up" id="edit_track_form<?php echo esc_attr($counter_social)?>">
          <div class="cs-heading-area">
            <h5><?php  _e('Settings','LMS'); ?></h5>
            <a href="javascript:removeoverlay('edit_track_form<?php echo esc_js($counter_social);?>','append')" class="closeit">&nbsp;</a>
            <div class="clear"></div>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Title','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="var_cp_title[]" value="<?php echo htmlspecialchars($var_cp_title)?>" id="var_cp_title<?php echo esc_attr($counter_social)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('icon/image Url','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input id="var_cp_image_url<?php echo esc_attr($counter_social)?>" name="var_cp_image_url[]" value="<?php echo htmlspecialchars($var_cp_image_url)?>" type="text" class="small" />
              <input id="var_cp_image_url<?php echo esc_attr($counter_social)?>" name="var_cp_image_url<?php echo esc_attr($counter_track);?>" type="button" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
              <p><?php  _e('Put Fontawsome icon/image url. You can get fontawsome icons from','LMS'); ?> <a href="<?php _e('http://fortawesome.github.io/Font-Awesome/icons/','LMS')?>"><?php  _e('here','LMS'); ?></a></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Text','LMS'); ?></label>
            </li>
            <li class="to-field">
              <textarea name="var_cp_team_text[]" rows="5" cols="20"><?php echo htmlspecialchars($var_cp_team_text)?></textarea>
            </li>
          </ul>
          <ul class="form-elements noborder">
            <li class="to-label">
              <label></label>
            </li>
            <li class="to-field">
              <input type="button" value="Update Personal Information" onclick="update_title(<?php echo esc_attr($counter_social)?>); removeoverlay('edit_track_form<?php echo esc_attr($counter_social);?>','append')" />
            </li>
          </ul>
        </div></td>
    </tr>
<?php
		if ( isset($action) ) die();
	}
	add_action('wp_ajax_cs_add_social_to_list', 'cs_add_social_to_list');
}

/**
 * @Section element Size(s)
 */
if ( ! function_exists( 'element_size_data_array_index' ) ) {
	function element_size_data_array_index($size){
		if ( $size == "" or $size == 100 ) return 0;
		else if ( $size == 75 ) return 1;
		else if ( $size == 67 ) return 2;
		else if ( $size == 50 ) return 3;
		else if ( $size == 33 ) return 4;
		else if ( $size == 25 ) return 5;
	
	}
}

/**
 * @Get  all Categories of posts or Custom posts
 */
if ( ! function_exists( 'show_all_cats' ) ) {
	function show_all_cats($parent, $separator, $selected = "", $taxonomy) {
		if ($parent == "") {
			global $wpdb;
			$parent = 0;
		}
		else
		$separator .= " &ndash; ";
		$args = array(
			'parent' => $parent,
			'hide_empty' => 0,
			'taxonomy' => $taxonomy
		);
		$categories = get_categories($args);
		foreach ($categories as $category) {
			?>
		<option <?php if ($selected == $category->slug) echo "selected"; ?> value="<?php echo esc_attr($category->slug) ?>"><?php echo esc_attr($separator . $category->cat_name); ?></option>
<?php
		show_all_cats($category->term_id, $separator, $selected, $taxonomy);
		}
	}
}



/**
 * @Page Builder Course Form html
 */
if ( ! function_exists( 'cs_pb_course' ) ) {
	function cs_pb_course($die = 0){
		global $cs_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$counter = $_POST['counter'];
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$PREFIX = 'cs_course';
			$parseObject 	= new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array( 'var_pb_course_title' => '', 'var_pb_course_cat' => '','var_pb_course_view' => '','var_pb_course_excerpt' => '','var_pb_course_filterable' => '','cs_courses_orderby'=>'','var_pb_course_pagination' => '','var_pb_course_per_page' => '','cs_course_class' => '','cs_course_animation' => '');
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		$course_element_size = '50';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_course';
		$coloumn_class = 'column_'.$course_element_size;
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>
    <div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="course" data="<?php echo element_size_data_array_index($course_element_size)?>" >
      <?php cs_element_setting($name,$cs_counter,$course_element_size,'','graduation-cap');?>
      <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_course {{attributes}}]"  style="display: none;">
        <div class="cs-heading-area">
          <h5><?php _e('Edit Course Options','LMS');?></h5>
          <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
        <div class="cs-pbwp-content">
          <div class="cs-wrapp-clone cs-shortcode-wrapp">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Course Title','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="var_pb_course_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_course_title)?>" />
                <p><?php _e('Course Page Title','LMS');?></p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Choose Category','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select name="var_pb_course_cat[]" class="dropdown">
                  <option value="0"><?php _e('-- Select Category --','LMS');?></option>
                  <?php show_all_cats('', '', $var_pb_course_cat, "course-category");?>
                </select>
                <p><?php _e('Choose category to show Class list','LMS');?></p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Select View','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select class="dropdown" name="var_pb_course_view[]">
                  <option <?php if($var_pb_course_view=="plain")echo "selected";?> value="plain"><?php _e('Default','LMS');?></option>
                  <option <?php if($var_pb_course_view=="classic")echo "selected";?> value="classic"><?php _e('Classic','LMS');?></option>
                  <option <?php if($var_pb_course_view=="three-column")echo "selected";?> value="three-column"><?php _e('Grid 3 Column','LMS');?></option>
                  <option <?php if($var_pb_course_view=="four-column")echo "selected";?> value="four-column"><?php _e('Grid 4 Column','LMS');?></option>
                  <option <?php if($var_pb_course_view=="timeline")echo "selected";?> value="timeline"><?php _e('Timeline','LMS');?></option>
                  <option <?php if($var_pb_course_view=="flat")echo "selected";?> value="flat"><?php _e('Flat','LMS');?></option>
                  <option <?php if($var_pb_course_view=="flat-grid")echo "selected";?> value="flat-grid"><?php _e('Flat Grid','LMS');?></option>
                  <option <?php if($var_pb_course_view=="grid-slider")echo "selected";?> value="grid-slider"><?php _e('Grid Slider','LMS');?></option>
                  <option <?php if($var_pb_course_view=="minimal")echo "selected";?> value="minimal"><?php _e('Minimal','LMS');?></option>
                  <option <?php if($var_pb_course_view=="modren")echo "selected";?> value="modren"><?php _e('Modern','LMS');?></option>
                  <option <?php if($var_pb_course_view=="list")echo "selected";?> value="list"><?php _e('List','LMS');?></option>
                  <option <?php if($var_pb_course_view=="big")echo "selected";?> value="big"><?php _e('Big','LMS');?></option>
                   <option <?php if($var_pb_course_view=="unique")echo "selected";?> value="unique"><?php _e('Unique','LMS');?></option>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Filterable','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select name="var_pb_course_filterable[]" class="dropdown">
                  <option <?php if($var_pb_course_filterable=="yes")echo "selected";?> value="yes"><?php _e('Yes','LMS');?></option>
                  <option <?php if($var_pb_course_filterable=="no")echo "selected";?> value="no"><?php _e('No','LMS');?></option>
                </select>
              </li>
            </ul>
             <ul class="form-elements noborder">
                <li class="to-label">
                  <label><?php _e('Post Order','LMS');?></label>
                </li>
                <li class="to-field">
                  <div class="input-sec">
                    <div class="select-style">
                      <select name="cs_courses_orderby[]" class="dropdown" >
                        <option <?php if($cs_courses_orderby=="ASC")echo "selected";?> value="ASC"><?php _e('Asc','LMS');?></option>
                        <option <?php if($cs_courses_orderby=="DESC")echo "selected";?> value="DESC"><?php _e('DESC','LMS');?></option>
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
                <input type="text" name="var_pb_course_excerpt[]" class="txtfield" value="<?php echo esc_attr($var_pb_course_excerpt);?>" />
                <p><?php _e('Enter number of characters for short description text.','LMS');?></p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Pagination','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select name="var_pb_course_pagination[]" class="dropdown" >
                  <option <?php if($var_pb_course_pagination=="Show Pagination")echo "selected";?> ><?php _e('Show Pagination','LMS');?></option>
                  <option <?php if($var_pb_course_pagination=="Single Page")echo "selected";?> ><?php _e('Single Page','LMS');?></option>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('No. of Courses Per Page','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="var_pb_course_per_page[]" class="txtfield" value="<?php echo esc_attr($var_pb_course_per_page);?>" />
                <p><?php _e('To display all the records, leave this field blank','LMS');?></p>
              </li>
            </ul>
            <?php 
                if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
                    cs_shortcode_custom_dynamic_classes($cs_course_class,$cs_course_animation,'','cs_course');
                }
            ?>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
                    <ul class="form-elements" style=" background-color: #fcfcfc; margin-top: -15px; padding-top: 12px; ">
                      <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>','<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
                    </ul>
                    <div id="results-shortocde"></div>
             <?php } else {?>
                    <ul class="form-elements noborder">
                      <li class="to-label"></li>
                      <li class="to-field">
                        <input type="hidden" name="cs_orderby[]" value="course" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
                      </li>
                    </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_course', 'cs_pb_course');
}

/**
 * @Add FAQ List
 */
if ( ! function_exists( 'cs_add_faq_to_list' ) ) {
	function cs_add_faq_to_list(){
		global $counter_faq, $faq_title,$faq_description;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
	?>
    <tr class="parentdelete" id="edit_track<?php echo esc_attr($counter_faq);?>">
      <td id="subject-title<?php echo esc_attr($counter_faq);?>" style="width:80%;"><?php echo esc_attr($faq_title)?></td>
      <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_form<?php echo esc_attr($counter_faq)?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
      <td style="width:0"><div  id="edit_track_form<?php echo esc_attr($counter_faq);?>" style="display: none;" class="table-form-elem">
          <div class="cs-heading-area">
            <h5 style="text-align: left;"><?php  _e('FAQ Settings','LMS'); ?></h5>
            <span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_attr($counter_faq);?>','append')" class="cs-btnclose"> <i class="fa fa-times"></i></span>
            <div class="clear"></div>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('FAQ Title','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="faq_title_array[]" value="<?php echo htmlspecialchars($faq_title)?>" id="faq_track_title<?php echo esc_attr($counter_faq);?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('FAQ Description','LMS'); ?></label>
            </li>
            <li class="to-field">
              <textarea name="faq_description_array[]" rows="5"  id="faq_track_description<?php echo esc_attr($counter_faq);?>" cols="20"><?php echo htmlspecialchars($faq_description)?></textarea>
            </li>
          </ul>
          <ul class="form-elements noborder">
            <li class="to-label">
              <label></label>
            </li>
            <li class="to-field">
              <input type="button" value="Update FAQ" onclick="update_title(<?php echo esc_attr($counter_faq);?>); removeoverlay('edit_track_form<?php echo esc_attr($counter_faq)?>','append')" />
            </li>
          </ul>
        </div></td>
    </tr>
<?php
		if ( isset($action) ) die();
	}
	add_action('wp_ajax_cs_add_faq_to_list', 'cs_add_faq_to_list');
}



/**
 * @Add Dynmamically Course Design
 */
if ( ! function_exists( 'cs_add_design_to_list' ) ) {
	function cs_add_design_to_list(){
		global $counter_design,$design_title,$design_value,$design_section_title,$design_post_listing_type,$design_post_categories,$design_excerpt_length,$design_default_excerpt_length,$design_filterable,$design_show_time,$design_post_per_page,$design_pagination, $design_post_order;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
	?>
    <tr class="parentdelete" id="edit_track<?php echo esc_attr($counter_design);?>">
      <td id="subject-title<?php echo esc_attr($counter_design)?>" style="width:80%;"><?php echo esc_attr($design_title)?></td>
      <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_form<?php echo esc_js($counter_design)?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
      <td style="width:0"><div  id="edit_track_form<?php echo esc_attr($counter_design)?>" style="display: none;" class="table-form-elem">
          <div class="cs-heading-area">
            <h5 style="text-align: left;"><?php  _e('Design Settings','LMS'); ?></h5>
            <span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_js($counter_design)?>','append')" class="cs-btnclose"> <i class="fa fa-times"></i></span>
            <div class="clear"></div>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Title','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="design_title_array[]" value="<?php echo htmlspecialchars($design_title)?>" id="design_title<?php echo esc_attr($counter_design)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Value','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" name="design_value_array[]" value="<?php echo htmlspecialchars($design_value)?>" id="design_value<?php echo esc_attr($counter_design)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Section Title','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_section_title_array[]" id="design_section_title<?php echo esc_attr($counter_design)?>">
                <option value="yes" <?php if($design_section_title == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_section_title == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Listing Type','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_post_listing_type_array[]" id="design_post_listing_type<?php echo esc_attr($counter_design)?>">
                <option value="yes" <?php if($design_post_listing_type == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_post_listing_type == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Categories','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_post_categories_array[]" id="design_post_categories<?php echo esc_attr($counter_design)?>">
                <option value="yes" <?php if($design_post_categories == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_post_categories == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Default Excerpt Length','LMS'); ?></label>
            </li>
            <li class="to-field">
              <input type="text" id="design_default_excerpt_length<?php echo esc_attr($counter_design);?>" name="design_default_excerpt_length_array[]" value="<?php echo esc_attr($design_default_excerpt_length);?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Excerpt Length','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_excerpt_length_array[]" id="design_excerpt_length<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_excerpt_length == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_excerpt_length == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post show time','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_show_time_array[]" id="design_show_time<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_show_time == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_show_time == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Filterable','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_filterable_array[]" id="design_filterable<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_filterable == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_filterable == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post No of Posts','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_post_per_page_array[]" id="design_post_per_page<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_post_per_page == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_post_per_page == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Pagination','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_pagination_array[]" id="design_pagination<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_pagination == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_pagination == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php  _e('Design Post Order','LMS'); ?></label>
            </li>
            <li class="to-field select-style">
              <select name="design_post_order_array[]" id="design_post_order<?php echo esc_attr($counter_design);?>">
                <option value="yes" <?php if($design_post_order == 'yes'){echo 'selected="selected"';}?>><?php  _e('Yes','LMS'); ?></option>
                <option value="no" <?php if($design_post_order == 'no'){echo 'selected="selected"';}?>><?php  _e('No','LMS'); ?></option>
              </select>
            </li>
          </ul>
          <ul class="form-elements noborder">
            <li class="to-label">
              <label></label>
            </li>
            <li class="to-field">
              <input type="button" value="<?php _e('Update Design View','LMS');?>" onclick="update_title(<?php echo esc_js($counter_design);?>); removeoverlay('edit_track_form<?php echo esc_js($counter_design);?>','append')" />
            </li>
          </ul>
        </div></td>
    </tr>
<?php
		if ( isset($action) ) die();
	}
	add_action('wp_ajax_cs_add_design_to_list', 'cs_add_design_to_list');
}




/**
 * @Add Assignment remarks
 */
if ( ! function_exists( 'cs_remarksss' ) ) {
	function cs_remarksss(){
		print_r($_REQUEST);
	}
	add_action('wp_ajax_cs_remarksss', 'cs_remarksss');
}

if ( ! function_exists( 'cs_edit_assignment_remarksss' ) ) {
	function cs_edit_assignment_remarksss(){
		//print_r($_REQUEST);
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
			$user_id = abstint($_POST['user_id']);
			$post_id = absint($_POST['post_id']);
			$counter = esc_attr($_POST['counter']);
			?>
            <form name="c-assignments-form" id="cs-assignments-form" enctype="multipart/form-data">
              <input type="hidden" name="action" value="cs_assignment_remarks_submission" />
              <input type="hidden" name="assignment_id" value="<?php echo absint($post->ID);?>" />
              <input type="hidden" name="user_id" value="<?php echo absint($user_id);?>" />
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&ast;</button>
                <h4 class="modal-title"><?php  _e('Instructor Remarks about Assignments','LMS'); ?></h4>
              </div>
              <div class="modal-body">
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php  _e('Marks','LMS'); ?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" id="assignment_marks" name="assignment_marks" value="" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php  _e('Instructor Assignments Reviews','LMS'); ?></label>
                  </li>
                  <li class="to-field">
                    <textarea name="assignments_remarks" id="assignments_remarks" rows="15" cols="15"></textarea>
                  </li>
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php  _e('Close','LMS'); ?></button>
                <button type="button" class="btn btn-primary" onclick="cs_instructor_assignments_remarks_save('<?php echo esc_js(admin_url('admin-ajax.php'))?>', '<?php echo esc_js(get_template_directory_uri())?>');"><?php  _e('Save changes','LMS'); ?></button>
              </div>
            </form>
<?php
			
		}
		die();
	}
	add_action("wp_ajax_nopriv_cs_edit_assignment_remarksss", "cs_edit_assignment_remarksss");
	add_action('wp_ajax_cs_edit_assignment_remarksss', 'cs_edit_assignment_remarksss');

}



/**
 * @Add Social Icons
 */
$counter_icon = 0;
if ( ! function_exists( 'add_social_icon' ) ) {
	function add_social_icon(){
	
		$template_path = get_template_directory_uri() . '/include/assets/scripts/media_upload.js';
	
		wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
		if($_POST['social_net_awesome']){
			 
			$icon_awesome = $_POST['social_net_awesome'];
		}
		$socail_network=get_option('cs_social_network');
		echo '<tr id="del_' .str_replace(' ','-',$_POST['social_net_tooltip']).'">
	
			<td>';if(isset($icon_awesome) and $icon_awesome<>''){;echo '<i style="color:'.$_POST['social_font_awesome_color'].'!important;" class="fa '.$_POST['social_net_awesome'].' fa-2x"></i>';}else{;echo '<img width="50" src="' .$_POST['social_net_icon_path']. '">';}echo '</td> 
			
			<td>' .$_POST['social_net_tooltip']. '</td> 
	
			<td><a href="#">' .$_POST['social_net_url'].'</a></td> 
	
			<td class="centr"> 
				<a class="remove-btn" onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del(\''.str_replace(' ','-',$_POST['social_net_tooltip']).'\')"><i class="fa fa-times"></i></a>
				 <a href="javascript:cs_toggle(\''.str_replace(' ','-',$_POST['social_net_tooltip']).'\')"><i class="fa fa-edit"></i></a>
			</td></tr>
	
		</tr>';
		
		echo '<tr id="'.str_replace(' ','-',$_POST['social_net_tooltip']).'" style="display:none">
				<td colspan="3"><ul class="form-elements">
				<li><a onclick="cs_toggle(\''.str_replace(' ','-',esc_js($_POST['social_net_tooltip'])).'\')"><img src="'.get_template_directory_uri().'/include/assets/images/close-red.png" /></a></li>
				  <li class="to-label">
					  <label>'.__('Title'.'LMS').'</label>
					</li>
					<li class="to-field">
					  <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="'.$_POST['social_net_tooltip'].'"  />
					  <p>'.__('Please enter text for icon tooltip'.'LMS').'</p>
					</li>
					<li class="to-label">
					  <label>'.__('Url'.'LMS').'</label>
					</li>
					<li class="to-field">
					  <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="'.$_POST['social_net_url'].'"/>
					  <p>'.__('Please enter Full Url'.'LMS').'</p>
					</li>
					<li class="full">&nbsp;</li>
					<li class="to-label">
					  <label>'.__('Icon Path'.'LMS').'</label>
					</li>
					<li class="to-field">
					  <input id="social_net_icon_path'.$counter_icon.'" name="social_net_icon_path[]" value="'.$_POST['social_net_icon_path'].'" type="text" class="small" />
					  <label class="browse-icon"><input id="social_net_icon_path'.$counter_icon.'" name="social_net_icon_path'.$i.'" type="button" class="uploadMedia left" value="'. __( 'Browse', 'LMS' ) .'"/></label>
					</li>
					
					<li style="padding: 10px 0px 20px;" class="full">
					   <ul id="cs_infobox_networks'.$counter_icon.'">
						  <li class="to-label">
							<label>'.__('Fontawsome Icon'.'LMS').'</label>
						  </li>
						  <li class="to-field">'.cs_fontawsome_theme_options($_POST['social_net_awesome'],"networks".$counter_icon).'
							<input id="social_net_awesome'.$counter_icon.'" type="hidden" class="cs-search-icon-hidden" name="social_net_awesome[]" value="'.$_POST['social_net_awesome'].'">
						  </li>
					   </ul>
					  </li>
					<li class="to-label">
					  <label>'.__('FontAwesome Color'.'LMS').'<span></span></label>
					</li>
					<li class="to-field">
					  <div class="input-sec">
					  <input type="text" name="social_font_awesome_color[]" id="social_font_awesome_color" value="'.$_POST['social_font_awesome_color'].'" class="bg_color" data-default-color="'.$_POST['social_font_awesome_color'].'" /></div>
					  <div class="left-info">
						  <p></p>
					  </div>
					</li>
					<li class="full">&nbsp;</li>
					
				  </ul></td>
			  </tr>';
			  $counter_icon++;
		die;
	
	}
	add_action('wp_ajax_add_social_icon', 'add_social_icon');
}



/**
 * @Icon Box html theme option social icon
 */
 /*
*/
// Fontawsome icon box
if ( ! function_exists( 'cs_fontawsome_icons_box') ) {
	function cs_fontawsome_icons_box($icon_value='',$id=''){
		$iconClass	= '';
		if ( isset ( $icon_value ) && $icon_value !='' ){
			$iconClass	= 'hideicon';
		}
		
		?>
            <style type="text/css" scoped>
				.iconpicker-selected{
					 background-color: #428bca;
    				 color: #fff;
				}
			</style>
			<script>
				 jQuery(document).ready(function($){
 					_iconSearch();
					jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-items .iconpicker-item").live('click', function() {
					   
					   var item_html	= jQuery(this).html();
					   var item_title	= jQuery(this).attr('title');
					   item_title       = item_title.split('.').join("");
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .cs-search-icon-hidden").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-input").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .lead").html(item_html);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box i").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .choose_icon_box").hide();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> #cs-icon-wrap").addClass('hideicon');
					   jQuery(".dp_icon").val('Choose Icon'); 
					   });
				});
			</script>
			<div class="btn-group">
                <div class="input-group <?php echo esc_attr($iconClass);?>" id="cs-icon-wrap">
                        <span class="drop_icon_box" style=" <?php if( trim($icon_value) !='' ){ echo 'display:block';}else{ echo 'display:none';};?>">
                            <span class="lead">
                                <i class="fa  <?php echo esc_attr($icon_value);?>"></i>
                            </span>
                            <div class="del-icon">
                                <a href="javascript:_delIcon('<?php echo esc_js($id);?>');"><i class="fa fa-times"></i></a>
                            </div>
                        </span>
                        <input type="button"  class="form-control icp icp-auto dp_icon" name="icon" value="<?php _e('Choose Icon','LMS');?>" />
				 </div>
            </div>
	<?php 
	
	}
}

if ( ! function_exists( 'cs_fontawsome_icons_box_courses') ) {
	function cs_fontawsome_icons_box_courses($icon_value='',$id=''){
		?>
            <style type="text/css" scoped>
				.iconpicker-selected{
					 background-color: #428bca;
    				 color: #fff;
				}
				.fa-icon-popover{
					position:absolute !important;
					left: 0 !important;
					top: -400px !important;
					z-index: 9999 !important;
				}
				.fa-icon-popover > .arrow{
					display:none !important;
				}
				.form-elements{
					padding:5px 0;
					border:none;
				}
			</style>
			<script>
				 jQuery(document).ready(function($){
 					_iconSearch();					
					jQuery("#btn_group_<?php echo esc_js($id);?> .iconpicker-popover").addClass('fa-icon-popover');
					jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-items .iconpicker-item").live('click', function() {
					   
					   var item_html	= jQuery(this).html();
					   var item_title	= jQuery(this).attr('title');
					   item_title       = item_title.split('.').join("");
					   
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .cs-search-icon-hidden").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-input").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .lead").html(item_html);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box i").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .choose_icon_box").hide();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> #cs-icon-wrap").addClass('hideicon');
					   jQuery(".dp_icon").val('Choose Icon'); 
					   });
				});
			</script>
			<div class="btn-group" id="btn_group_<?php echo esc_attr($id);?>">
                <div class="input-group" id="cs-icon-wrap">
                        <span class="drop_icon_box" style=" <?php if( trim($icon_value) !='' ){ echo 'display:block';}else{ echo 'display:none';};?>">
                            <span class="lead">
                                <i class="fa  <?php echo esc_attr($icon_value);?>"></i>
                            </span>
                            <div class="del-icon">
                                <a href="javascript:_delIcon('<?php echo esc_js($id);?>');"><i class="fa fa-times"></i></a>
                            </div>
                        </span>
                        <input type="button"  class="form-control icp icp-auto dp_icon" name="icon" value="<?php echo 'Choose Icon';?>" />
				 </div>
            </div>
	<?php 
	
	}
}

// Fontawsome icon box for Theme Options
if ( ! function_exists( 'cs_fontawsome_theme_options') ) {
	function cs_fontawsome_theme_options($icon_value='',$id=''){
		ob_start();
		?>
            <style type="text/css" scoped>
				.iconpicker-selected{
					 background-color: #428bca;
    				 color: #fff;
				}
			</style>
			<script>
				 jQuery(document).ready(function($){
 					_iconSearch();
					jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-items .iconpicker-item").live('click', function() {
					   jQuery(".dp_icon").val('Choos Icon'); 
					   var item_html	= jQuery(this).html();
					   var item_title	= jQuery(this).attr('title');
					   item_title       = item_title.split('.').join("");
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .cs-search-icon-hidden").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .iconpicker-input").val(item_title);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .lead").html(item_html);
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .drop_icon_box i").show();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> .choose_icon_box").hide();
					   jQuery("#cs_infobox_<?php echo esc_js($id);?> #cs-icon-wrap").addClass('hideicon');
					   });
				});
			</script>
			<div class="btn-group">
                <div class="input-group" id="cs-icon-wrap">
                        <span class="drop_icon_box" style=" <?php if( trim($icon_value) !='' ){ echo 'display:block';}else{ echo 'display:none';};?>">
                            <span class="lead">
                                <i class="fa  <?php echo esc_attr($icon_value);?>"></i>
                            </span>
                            <div class="del-icon">
                                <a href="javascript:_delIcon('<?php echo esc_attr($id);?>');"><i class="fa fa-times"></i></a>
                            </div>
                        </span>
                        <input type="button"  class="form-control icp icp-auto dp_icon" name="icon" value="<?php _e('Choose Icon','LMS');?>" />
				    </div>
            </div>
		<?php 
		$fontawesome = ob_get_clean();
		return $fontawesome;
	}
}
