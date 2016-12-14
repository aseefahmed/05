<?php
/**
 * The template for displaying all Single Courses
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */

//======================================================================
// Courses Categories html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_courses_categories' ) ) {
	function cs_pb_courses_categories($die = 0){
		global $cs_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
			$cs_counter = $_POST['counter'];
		} else {
			$POSTID = $_POST['POSTID'];
			$cs_counter = $_POST['counter'];
			$PREFIX = 'cs_courses_categories';
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$parseObject = new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array( 'cs_courses_categories_title' => '','cs_courses_categories_view' => 'view-1','cs_courses_categories_bg_color' => '','cs_courses_categories_txt_color' => '', 'cs_courses_categories_cats' => '','cs_custom_class' => '','cs_custom_animation' => '');

		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$cs_courses_categories_description = $output['0']['content'];
		else 
			$cs_courses_categories_description = "";
			
		$courses_categories_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_courses_categories';
		$coloumn_class = 'column_'.$courses_categories_element_size	;
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}
	
	?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/include/assets/scripts/ui_multiselect.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri();?>/include/assets/css/jquery_ui.css" />
    <link type="text/css" rel="stylesheet"  href="<?php echo get_template_directory_uri();?>/include/assets/css/ui_multiselect.css" />
    <link type="text/css" rel="stylesheet"  href="<?php echo get_template_directory_uri();?>/include/assets/css/common.css" />
    <script type="text/javascript">
        jQuery(function($){
            jQuery(".multiselect").multiselect();
        });
    </script>
    <div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="courses_categories" data="<?php echo element_size_data_array_index($courses_categories_element_size)?>" >
      <?php cs_element_setting($name,$cs_counter,$courses_categories_element_size);?>
      <div class="cs-wrapp-class-<?php echo absint($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_courses_categories {{attributes}}]" style="display: none;">
        <div class="cs-heading-area">
          <h5><?php _e('Edit Courses Categories Options','EDULMS');?></h5>
          <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
        <div class="cs-wrapp-tab-box">
          <div class="cs-clone-append cs-pbwp-content" >
            <div id="shortcode-item-<?php echo absint($cs_counter);?>">
            <?php
			if ($cs_courses_categories_cats){
				$cs_courses_categories_cats = explode(",", $cs_courses_categories_cats);
				echo '
					<script type="text/javascript" src="'.get_template_directory_uri().'/include/assets/scripts/ui_multiselect.js"></script>
					<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri().'/include/assets/css/jquery_ui.css" />
					<link type="text/css" rel="stylesheet"  href="'.get_template_directory_uri().'/include/assets/css/ui_multiselect.css" />
					<link type="text/css" rel="stylesheet"  href="'.get_template_directory_uri().'/include/assets/css/common.css" />
					<script type="text/javascript">
						jQuery(".multiselect").multiselect();
					</script>';
			}
			?>
              <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true">
                <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
                <ul class="form-elements">
                    <li class="to-label"><label><?php _e('Section Title','EDULMS');?></label></li>
                    <li class="to-field">
                        <input  name="cs_courses_categories_title[]" type="text"  value="<?php echo esc_attr($cs_courses_categories_title);?>"   />
                    </li>                  
                 </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Categories Views','EDULMS');?></label>
                  </li>
                  <li class="to-field select-style">
                    <select class="cs_size" name="cs_courses_categories_view[]">
                      <option value="view-1" <?php if(@$cs_courses_categories_view == 'view-1'){echo 'selected="selected"';}?>><?php _e('Grid Counter','EDULMS');?></option>
                      <option value="view-2" <?php if(@$cs_courses_categories_view == 'view-2'){echo 'selected="selected"';}?>><?php _e('List','EDULMS');?></option>
                      <option value="view-3" <?php if(@$cs_courses_categories_view == 'view-3'){echo 'selected="selected"';}?>><?php _e('Grid','EDULMS');?></option>
                    </select>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Background Color','EDULMS');?></label>
                    
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_courses_categories_bg_color[]" class="txtfield bg_color" value="<?php echo esc_attr($cs_courses_categories_bg_color)?>" />
                    <div class="left-info">
                    <p><?php _e('Add a hex background colour code, If you want to override the default','EDULMS');?></p>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Text Color','EDULMS');?></label>
                    
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_courses_categories_txt_color[]" class="txtfield bg_color" value="<?php echo esc_attr($cs_courses_categories_txt_color)?>" />
                    <div class="left-info">
                    <p><?php _e('Add a hex background colour code, If you want to override the default','EDULMS');?></p>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Select Categories','EDULMS');?></label>
                  </li>
                  <li class="to-field">
                    <select name="cs_courses_categories_cats[<?php echo absint($cs_counter)?>][]" multiple="multiple" class="multiselect" style="min-height:100px;">
                      <?php
					  	if(is_array($cs_courses_categories_cats)){
							foreach($cs_courses_categories_cats as $cats){
								$term = get_term( $cats, 'course-category' );
								echo '<option value="'.$cats.'" selected="selected">'.$term->name.'</option>';
							}
						}
						
					  	$args = array(
							'hide_empty' => 0,
							'taxonomy' => 'course-category'
						);
						$fetch_cats = get_categories($args);
                        foreach($fetch_cats as $f_cats){
                            echo '<option value="'.$f_cats->term_id.'">'.$f_cats->name.'</option>';	 
                        }
						
                     ?>
                    </select>
                  </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label><?php _e('Custom Id','EDULMS');?></label></li>
                    <li class="to-field">
                        <input type="text" name="cs_custom_class[]" class="txtfield"  value="<?php echo absint($cs_custom_class)?>" />
                    </li>
                 </ul>
                <ul class="form-elements">
                    <li class="to-label"><label><?php _e('Animation Class','EDULMS');?> </label></li>
                    <li class="to-field select-style">
                        <select class="dropdown" name="cs_custom_animation[]">
                            <option value=""><?php _e('Select Animation','EDULMS');?></option>
                            <?php 
                                $animation_array = cs_animation_style();
                                foreach($animation_array as $animation_key=>$animation_value){
                                    echo '<optgroup label="'.$animation_key.'">';	
                                    foreach($animation_value as $key=>$value){
                                        $selected = '';
                                        if($cs_custom_animation == $key){$selected = 'selected="selected"';}
                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                    }
                                }
                             ?>
                          </select>
                    </li>
                </ul>
              </div>
            </div>
            <div class="wrapptabbox no-padding-lr">
              
              <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
                  <ul class="form-elements insert-bg">
                    <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')"><?php _e('Insert','EDULMS');?></a> </li>
                  </ul>
              	<div id="results-shortocde"></div>
              <?php } else {?>
                  <ul class="form-elements noborder no-padding-lr">
                    <li class="to-label"></li>
                    <li class="to-field">
                      <input type="hidden" name="cs_orderby[]" value="courses_categories" />
                      <input type="hidden" name="cs_courses_categories_counter[]" value="<?php echo absint($cs_counter)?>" />
                      <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
                    </li>
                  </ul>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
            if ( $die <> 1 ) die();
        }
        add_action('wp_ajax_cs_pb_courses_categories', 'cs_pb_courses_categories');
    }

//======================================================================
// Adding courses categories start
//=====================================================================
if (!function_exists('cs_courses_categories_shortcode')) {
	function cs_courses_categories_shortcode($atts, $content = "") {
	$defaults = array( 'column_size'=>'','cs_courses_categories_title' => '','cs_courses_categories_view' => 'view-1','cs_courses_categories_bg_color' => '','cs_courses_categories_txt_color' => '', 'cs_courses_categories_cats' => '','cs_custom_class' => '','cs_custom_animation' => '');	
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		$catColumn	= 'col-md-3';
		if(isset($cs_courses_categories_view) and $cs_courses_categories_view == 'view-2'){
			$cat_class = 'cat-plain';
		}
		else if(isset($cs_courses_categories_view) and $cs_courses_categories_view == 'view-3'){
			$cat_class = 'cat-clean';
			$catColumn	= 'col-md-3';
		}
		else{
			$cat_class = '';
		}
		
		$sectionTitle	= '';
		if ( isset ( $cs_courses_categories_title ) && $cs_courses_categories_title !='' ) {
			$sectionTitle	= '<div class="cs-section-title"><h2>'.$cs_courses_categories_title.'</h2></div>';
		}
		
		$html = '';
		
		$html .= '<div class="cs_course_categories '.$cat_class.' '.$column_class.' '.$cs_custom_class.' '.$cs_custom_animation.'">
					'.$sectionTitle.'
					<ul class="row">';
					if(!empty($cs_courses_categories_cats)){
						
						$args = array(
							'hide_empty' => 0,
							'taxonomy' => 'course-category'
						);
						$fetch_cats = get_categories($args);
						$conf_cats = array();
						foreach($fetch_cats as $ca){
							$conf_cats[] = $ca->term_id;
						}
						
						$cs_courses_categories_cats = explode(",", $cs_courses_categories_cats);
						
						$exec_code = true;
						foreach($cs_courses_categories_cats as $cats){
							if(!in_array($cats, $conf_cats)){
								$exec_code = false;
								break;
							}
						}
						if($exec_code == true){
							foreach($cs_courses_categories_cats as $cats){
								$term = get_term( $cats, 'course-category' );
								$term_id = $term->term_id;
								$cat_meta = get_option( "course_cat_$term_id");
								$cat_img = '';
								if(isset($cs_courses_categories_view) and $cs_courses_categories_view == 'view-1'){
									$post_count = '('.$term->count.')';
								}
								else{
									$post_count = '';
								}
								if($cat_meta){
									if(isset($cat_meta['icon'])) $cat_img .= '<i class="fa '.$cat_meta['icon'].'" style="color:'.$cs_courses_categories_txt_color.';"></i>';
								}
								
								$html .= '<li class="'.$catColumn.'"><div class="cat-inner" style="background-color:'.$cs_courses_categories_bg_color.';color:'.$cs_courses_categories_txt_color.';">'.$cat_img.'<a href="'.get_term_link($term->term_id, 'course-category').'" style="color:'.$cs_courses_categories_txt_color.';">'.$term->name.'</a>'.$post_count.'</div></li>';
							}
						}
					}
					$html .= 
					'</ul>
				  </div>';
		$html = do_shortcode($html);
		
		return $html;
		
	}
	add_shortcode('cs_courses_categories', 'cs_courses_categories_shortcode');
}