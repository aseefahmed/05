<?php
/**
 * File Type: Common Elements Shortcode Form Elements
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 
 
//======================================================================
// Button html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_button' ) ) {
	function cs_pb_button($die = 0){
		global $cs_node, $cs_count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_button';
		$counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array( 'button_size'=>'btn-lg','button_border' => '','border_button_color' => '','button_title' => '','button_link' => '#','button_color' => '','button_bg_color' => '','button_icon_position' => 'left','button_icon'=>'', 'button_type' => 'rounded','button_target' => '_self','cs_button_class' => '','cs_button_animation' => '');
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			if(isset($output['0']['content']))
				$atts_content = $output['0']['content'];
			else 
				$atts_content = array();
			$button_element_size = '25';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$name = 'cs_pb_button';
			$cs_count_node++;
			$coloumn_class = 'column_'.$button_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>

<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($button_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$button_element_size,'','heart');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_button {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Button Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Size','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="button_size" id="button_size" name="button_size[]">
              <option value="btn-lg" <?php if($button_size == 'btn-lg'){echo 'selected="selected"';}?>><?php _e('Large','LMS');?> </option>
              <option  value="btn-sm" <?php if($button_size == 'btn-sm'){echo 'selected="selected"';}?>><?php _e('Medium','LMS');?></option>
              <option value="btn-sml" <?php if($button_size == 'btn-sml'){echo 'selected="selected"';}?>><?php _e('Small','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('Select column width. This width will be calculated depend page width','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="button_title[]" class="txtfield" value="<?php echo cs_allow_special_char($button_title)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Link','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="button_link[]" class="txtfield" value="<?php echo esc_attr($button_link);?>" />
            <div class='left-info'><p><?php _e('Button external&internal Url','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Border','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="button_border" id="button_border" name="button_border[]">
              <option value="yes" <?php if($button_border == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?> </option>
              <option  value="no" <?php if($button_border == 'no'){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Border Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="border_button_color[]" class="bg_color" value="<?php echo esc_attr($border_button_color)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Background Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="button_bg_color[]" class="bg_color" value="<?php echo esc_attr($button_bg_color)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="button_color[]" class="bg_color" value="<?php echo esc_attr($button_color)?>" />
            <div class='left-info'><p><?php _e('select a color which you want on the buttons','LMS');?></p>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label><?php _e('Fontawsome Icon','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="hidden" class="cs-search-icon-hidden" name="button_icon[]" value="<?php echo esc_attr($button_icon)?>">
            <?php cs_fontawsome_icons_box( $button_icon ,$name.$cs_counter);?>
            <div class='left-info'><p> <?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Icon Position','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="button_icon_position" id="button_icon_position" name="button_icon_position[]">
              <option value="left" <?php if($button_icon_position == 'left'){echo 'selected="selected"';}?>><?php _e('Left','LMS');?></option>
              <option value="right" <?php if($button_icon_position == 'right'){echo 'selected="selected"';}?>><?php _e('Right','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('set a position for the button','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Type','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="button_type" id="button_type" name="button_type[]">
              <option value="rectangle" <?php if($button_type == 'rectangle'){echo 'selected="selected"';}?>><?php _e('Square','LMS');?></option>
              <option value="rounded" <?php if($button_type == 'rounded'){echo 'selected="selected"';}?>><?php _e('Rounded','LMS');?></option>
              <option value="three-d" <?php if($button_type == 'three-d'){echo 'selected="selected"';}?>><?php _e('3D','LMS');?></option>
            </select>
           <div class='left-info'> <p><?php _e('Select the display type for the button','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Target','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="button_target" id="button_target" name="button_target[]">
              <option value="_blank" <?php if($button_target == '_blank'){echo 'selected="selected"';}?>><?php _e('Blank','LMS');?></option>
              <option value="_self" <?php if($button_target == '_self'){echo 'selected="selected"';}?>><?php _e('Self','LMS');?></option>
            </select>
          </li>
        </ul>
        <?php 
		if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
			cs_shortcode_custom_dynamic_classes($cs_button_class,$cs_button_animation,'','cs_button');
		}
		?>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="button" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
    </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_button', 'cs_pb_button');
}

//======================================================================
// tabs html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_tabs' ) ) {
	function cs_pb_tabs($die = 0){
		global $cs_node, $count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$tabs_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$PREFIX = 'cs_tabs|tab_item';
			$parseObject 	= new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array(  
			'cs_tab_style' => '',
			'cs_tab_class' => '',
			'cs_tabs_class' => '',
			'column_size'=>'1/1', 
			'cs_tabs_section_title' => '',
			'cs_tabs_animation' => '',
			'cs_custom_animation_duration' => ''
		);
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
		
		if(is_array($atts_content))
				$tabs_num = count($atts_content);
		
		$tabs_element_size = '25';
		
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		
		$name = 'cs_pb_tabs';
		$coloumn_class = 'column_'.$tabs_element_size;
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		$randD_id = rand(56, 3453441);
	?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="tabs" data="<?php echo element_size_data_array_index($tabs_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$tabs_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Tabs Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($randD_id);?>" data-shortcode-template="{{child_shortcode}} [/cs_tabs]" data-shortcode-child-template="[tab_item {{attributes}}] {{content}} [/tab_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_tabs {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','LMS');?></label>
              </li>
              <li class="to-field">
                <input  name="cs_tabs_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_tabs_section_title)?>"   />
                <div class='left-info'>
                  <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?>  </p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Tab Style','LMS');?></label>
              </li>
              <li class="to-field">
                <div class="select-style">
                  <select name="cs_tab_style[]">
                    <option <?php if($cs_tab_style=="nav_position_top")echo "selected";?> value="nav_position_top" ><?php _e('Horizontal','LMS');?></option>
                    <option <?php if($cs_tab_style=="nav_position_left")echo "selected";?> value="nav_position_left" ><?php _e('Vertical','LMS');?></option>
                  </select>
                </div>
              </li>
            </ul>
            <?php 
				if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
					cs_shortcode_custom_dynamic_classes($cs_tabs_class,$cs_tabs_animation,'','cs_tabs');
				}
				
				?>
          </div>
          <?php
			if ( isset($tabs_num) && $tabs_num <> '' && isset($atts_content) && is_array($atts_content)){
			
				foreach ( $atts_content as $tabs ){
					$rand_id = $cs_counter.''.cs_generate_random_string(6);
					$tabs_text = $tabs['content'];
					$defaults = array(  
						'cs_tab_icon' => '',
						'tab_title' => '',
						'cs_tab_icon' => '',
						'tab_active'=>'no' 
					);
					foreach($defaults as $key=>$values){
						if(isset($tabs['atts'][$key]))
							$$key = $tabs['atts'][$key];
						else 
							$$key =$values;
					 }
					?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='fa fa-arrows'></i><?php _e('Tab','LMS');?></h4>
              <a href='#' class='deleteit_node'><i class='fa fa-minus-circle'></i><?php _e('Remove','LMS');?></a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Active','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class="select-style">
                  <select name='tab_active[]'>
                    <option <?php if(isset($tab_active) and $tab_active == 'no') echo 'selected'; ?> value="no"><?php _e('No','LMS');?></option>
                    <option <?php if(isset($tab_active) and $tab_active == 'yes') echo 'selected'; ?> value="yes"><?php _e('Yes','LMS');?></option>
                  </select>
                  <div class='left-info'>
                    <p><?php _e('You can set the section that is active here by select dropdown','LMS');?></p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Tab Title','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='tab_title[]'  value="<?php echo cs_allow_special_char($tab_title);?>"/>
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo cs_allow_special_char($name.$cs_counter);?>">
              <li class='to-label'>
                <label><?php _e('Tab Fontawsome Icon','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="hidden" class="cs-search-icon-hidden" name="cs_tab_icon[]" value="<?php echo esc_attr($cs_tab_icon);?>">
                <?php cs_fontawsome_icons_box($cs_tab_icon,$rand_id);?>
                <div class='left-info'>
                  <p> <?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?></p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Tab Text','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='tab_text[]'><?php echo cs_allow_special_char($tabs_text);?></textarea>
                </div>
                <div class='left-info'>
                  <p><?php _e('Enter tab body content here','LMS');?></p>
                </div>
              </li>
            </ul>
          </div>
          <?php
			}
		}
		?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="tabs_num[]" value="<?php echo cs_allow_special_char($tabs_num)?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('tabs', 'shortcode-item-<?php echo cs_allow_special_char($randD_id);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="fa fa-plus-circle"></i><?php _e('Add Tab','LMS');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($randD_id);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="tabs" />
                <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))"  />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
	if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
}

//======================================================================
// Toggle html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_toggle' ) ) {
	function cs_pb_toggle($die = 0){
		global $cs_node, $count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_toggle';
		$cs_counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array( 'column_size'=>'1/1','cs_toggle_section_title' => '','cs_toggle_title' => '','cs_toggle_state' => '','cs_toggle_icon' => '','cs_toggle_custom_class' => '','cs_toggle_custom_animation' => '','cs_toggle_custom_animation_duration' => '1');
			
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = "";
			
		$toggle_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_toggle';
		$coloumn_class = 'column_'.$toggle_element_size;
	
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}	
	?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="column" data="<?php echo element_size_data_array_index($toggle_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$toggle_element_size,'','life-ring');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_toggle {{attributes}}]{{content}}[/cs_toggle]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Toggle Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_toggle_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_toggle_section_title)?>"   />
            <div class='left-info'><p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Toggle Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_toggle_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_toggle_title)?>" />
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label><?php _e('Toggle Fontawsome Icon','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="hidden" class="cs-search-icon-hidden" name="cs_toggle_icon[]" value="<?php echo esc_attr($cs_toggle_icon)?>">
            <?php cs_fontawsome_icons_box($cs_toggle_icon,$name.$cs_counter);?>
            <div class='left-info'><p> <?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Toggle State','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select name="cs_toggle_state[]">
              <option <?php if($cs_toggle_state=="open")echo "selected";?> value="open" ><?php _e('Open','LMS');?></option>
              <option <?php if($cs_toggle_state=="close")echo "selected";?> value="close" ><?php _e('Close','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('Select this if you want toggle to be open by default','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Toggle Text','LMS');?></label>
          </li>
          <li class="to-field">
            <textarea rows="20" cols="40" name="cs_toggle_text[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content)?></textarea>
            <div class='left-info'><p><?php _e('Enter content here','LMS');?></p></div>
          </li>
        </ul>
        <?php 
			if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
				cs_shortcode_custom_dynamic_classes($cs_toggle_custom_class,$cs_toggle_custom_animation,$cs_toggle_custom_animation_duration,'cs_toggle_custom');
			}
		?>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="toggle" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_toggle', 'cs_pb_toggle');
}

//======================================================================
// price table html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_pricetable' ) ) {
	function cs_pb_pricetable($die = 0){
		global $cs_node, $cs_count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$PREFIX = 'cs_pricetable|pricing_item';
		$parseObject 	= new ShortcodeParse();
		$price_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/1','pricetable_style'=>'','pricetable_title'=>'','pricetable_price'=>'','pricetable_img'=>'','pricetable_period'=>'','pricetable_bgcolor'=>'#000','btn_text'=>'','btn_link'=>'','btn_bg_color'=>'','pricetable_featured'=>'','pricetable_class'=>'','pricetable_animation'=>'');
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			
			if(isset($output['0']['content']))
				$atts_content = $output['0']['content'];
			else 
				$atts_content = array();
			
			if(is_array($atts_content))
				$price_num = count($atts_content);
				
			$pricetable_element_size = '25';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$name = 'cs_pb_pricetable';
			$coloumn_class = 'column_'.$pricetable_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		
		$cs_counter = $cs_counter.rand(11,555);
		
	?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="pricetable" data="<?php echo element_size_data_array_index($pricetable_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$pricetable_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Price Table Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
       <div class="cs-clone-append cs-pbwp-content">
        <div class="cs-wrapp-tab-box">
         <div  id="cs-shortcode-wrapp_<?php echo esc_attr($name.$cs_counter)?>">
          <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/cs_pricetable]" data-shortcode-child-template="[pricing_item {{attributes}}] {{content}} [/pricing_item]">
            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[cs_pricetable {{attributes}}]">
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Choose View','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <div class="select-style">
                      <select name="pricetable_style[]" class="dropdown" onchange="cs_pricetable_style_vlaue(this.value, <?php echo esc_js($cs_counter);?>)" >
                        <option <?php if($pricetable_style=="classic")echo "selected";?> value="classic" ><?php _e('Classic','LMS');?></option>
                        <option <?php if($pricetable_style=="simple")echo "selected";?> value="simple" ><?php _e('Simple','LMS');?></option>
                        <option <?php if($pricetable_style=="clean")echo "selected";?> value="clean" ><?php _e('Clean','LMS');?></option>
                      </select>
                      <div class='left-info'>
                        <div class='left-info'><p><?php _e('Choose a pricetable view','LMS');?></p></div>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Title','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_title[]" class="txtfield" value="<?php echo cs_allow_special_char($pricetable_title);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p> <?php _e('set title for the item','LMS');?></p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Price','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_price[]" class="" value="<?php echo esc_attr($pricetable_price);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('item Price','LMS');?></p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Image','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input id="pricetable_img<?php echo esc_attr($cs_counter)?>" name="pricetable_img[]" type="hidden" class="" value="<?php echo esc_url($pricetable_img);?>"/>
                    <label class="browse-icon"><input name="pricetable_img<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/></label>
                    <div class='left-info'>
                      <div class='left-info'><p> <?php _e('set image for the item','LMS');?></p></div>
                    </div>
                  </li>
                </ul>
                <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($pricetable_img) && trim($pricetable_img) !='' ? 'inline' : 'none';?>" id="pricetable_img<?php echo esc_attr($cs_counter)?>_box" >
                  <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                      <ul id="gal-sortable">
                        <li class="ui-state-default" id="">
                          <div class="thumb-secs"> <img src="<?php echo esc_url($pricetable_img);?>"  id="pricetable_img<?php echo esc_attr($cs_counter);?>_img" width="100" height="150"  />
                            <div class="gal-edit-opts"> <a   href="javascript:del_media('pricetable_img<?php echo esc_attr($cs_counter);?>')" class="delete"></a> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Time Duration','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_period[]" class="" value="<?php echo esc_attr($pricetable_period);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('set a time duration','LMS');?></p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Table Column Color','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text"  name="pricetable_bgcolor[]" class="bg_color" value="<?php echo esc_attr($pricetable_bgcolor);?>" data-default-color=""  />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('Provide a hex colour code here (include #) if you want to override the default','LMS');?> </p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements bcevent_title">
                  <li class="to-label">
                    <label><?php _e('Button Text','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <div class="input-sec">
                      <input type="text" name="btn_text[]" class="txtfield" value="<?php echo cs_allow_special_char($btn_text);?>" />
                      <div id="pricetbale-title<?php echo esc_attr($cs_counter);?>" class="color-picker">
                        <input type="text" name="btn_bg_color[]" class="bg_color" value="<?php echo esc_attr($btn_bg_color);?>" />
                        <label><?php _e('Background Color','LMS');?></label>
                        <div class='left-info'>
                          <div class='left-info'><p><?php _e('Text color on the button,If you want to override the default','LMS');?></p></div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
               <ul class="form-elements bcevent_title">
                  	<li class="to-label">
                    	<label><?php _e('Button Link','LMS');?></label>
                  	</li>
                  	<li class="to-field">
                  		<div class="input-sec">
                    		<input type="text" name="btn_link[]" class="txtfield" value="<?php echo cs_allow_special_char($btn_link);?>" />
                     	</div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Featured','LMS');?></label>
                  </li>
                  <li class="to-field select-style">
                    <select name="pricetable_featured[]" class="dropdown" >
                      <option <?php if($pricetable_featured=="Yes")echo "selected";?> ><?php _e('Yes','LMS');?></option>
                      <option <?php if($pricetable_featured=="No")echo "selected";?> ><?php _e('No','LMS');?></option>
                    </select>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Custom Id','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_class[]" class="txtfield"  value="<?php echo esc_attr($pricetable_class);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Animation Class','LMS');?></label>
                  </li>
                  <li class="to-field">
                    <div class="select-style">
                      <select class="dropdown" name="pricetable_animation[]">
                        <option value=""><?php _e('Select Animation','LMS')?></option>
                        <?php 
                            $animation_array = cs_animation_style();
                            foreach($animation_array as $animation_key=>$animation_value){
                                echo '<optgroup label="'.$animation_key.'">';	
                                foreach($animation_value as $key=>$value){
                                    $active_class = '';
                                    if($pricetable_animation == $key){$active_class = 'selected="selected"';}
                                    echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                                }
                            }
                         ?>
                      </select>
                      <div class='left-info'>
                        <div class='left-info'><p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p></div>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Pricing Features','LMS');?></label>
                  </li>
                  <li class="to-field"> <a class="add_field_button" href="#"  onclick="javascript:cs_add_field('cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>','cs_infobox')"><?php _e('Add New Feature input box','LMS');?> <i class="fa fa-plus-circle" style="color:red; font-size:18px"></i></a> 
                  
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('set feature price of the product','LMS');?></p></div>
                    </div>
                    
                  </li>
                </ul>
              </div>
          <!--Items-->
          <div class="input_fields_wrap">
            <?php
			if ( isset($price_num) && $price_num <> '' && isset($atts_content) && is_array($atts_content)){
				$itemCounter	= 0;
				foreach ( $atts_content as $pricing ){
					$rand_id = $cs_counter.''.cs_generate_random_string(3);
					$itemCounter++;
					$pricing_text = $pricing['content'];
					$defaults = array('pricing_feature' => '');
					foreach($defaults as $key=>$values){
						if(isset($pricing['atts'][$key]))
							$$key = $pricing['atts'][$key];
						else 
							$$key =$values;
					 }
					?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo esc_attr($rand_id);?>">
                      <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <div id="<?php echo 'priceTable_'.esc_attr($rand_id);?>">
                          <ul class="form-elements bcevent_title">
                            <li class="to-label">
                              <label><?php _e('Pricing Feature','LMS');?><?php echo esc_attr($itemCounter);?></label>
                            </li>
                            <li class="to-field">
                              <div class="input-sec">
                                <input class="txtfield" type="text" value="<?php echo esc_attr($pricing_feature);?>" name="pricing_feature[]">
                              </div>
                              <div id="price_remove">
                                <a class="remove_field" onclick="javascript:cs_remove_field('cs_infobox_<?php echo esc_js($rand_id);?>','cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>')"><i class="fa fa-minus-circle" style="color:#000; font-size:18px"></i></a></div>
                              </li>
                          </ul>
                        </div>
                      </div>
                    </div>
				<?php
						}
					}
                 ?>
          </div>
          <!--Items--> 
         </div>
         <div class="hidden-object">
          <input type="hidden" name="price_num[]" value="<?php echo (int)$price_num?>" class="counter_num"  />
         </div>
        	<div class="wrapptabbox">
          <div class="opt-conts">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="pricetable" />
                <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
         </div>
       </div>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_pricetable', 'cs_pb_pricetable');
}

//======================================================================
// Accordion html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_accordion' ) ) {
	function cs_pb_accordion($die = 0){
		global $cs_node, $count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$PREFIX = 'cs_accordian|accordian_item';
		$parseObject 	= new ShortcodeParse();
		$accordion_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/2', 'class' => 'cs-accrodian','accordian_style' => '','accordion_class' => '','accordion_animation' => '','cs_accordian_section_title'=>'');
		
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
		
		if(is_array($atts_content))
			$accordion_num = count($atts_content);
			
		$accordion_element_size = '50';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_accordion';
		$coloumn_class = 'column_'.$accordion_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		$ranD_id = rand(34, 5465465);
	?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($accordion_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$accordion_element_size,'','list-ul');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_accordian {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Accordion Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>" data-shortcode-template="{{child_shortcode}}[/cs_accordian]" data-shortcode-child-template="[accordian_item {{attributes}}] {{content}} [/accordian_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_accordian {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','LMS');?></label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input  name="cs_accordian_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_accordian_section_title)?>" /></div>
                <div class='left-info'>
                  <p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?></p>
                </div>
              </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Style','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec select-style'>
                  <select name='accordian_style[]' class='dropdown'>
                    <option value='normal' <?php if($accordian_style == 'normal'){echo 'selected';}?>><?php _e('Normal','LMS');?></option>
                    <option value='colored' <?php if($accordian_style == 'colored'){echo 'selected';}?>><?php _e('Colored','LMS');?></option>
                  </select>
                </div>
                <div class='left-info'>
                  <p><?php _e('choose a style type for accordion element','LMS');?></p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Custom Id','LMS');?></label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input type="text" name="accordion_class[]" class="txtfield"  value="<?php echo esc_attr($accordion_class);?>" /></div>
                <div class='left-info'>
                  <p><?php _e('Use this option if you want to use specified  id for this element','LMS');?></p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Animation Class','LMS');?> </label>
              </li>
              <li class="to-field select-style">
              	<div class='input-sec select-style'>
                <select class="dropdown" name="accordion_animation[]">
                  <option value=""><?php _e('Select Animation','LMS')?></option>
                  <?php 
						$animation_array = cs_animation_style();
						foreach($animation_array as $animation_key=>$animation_value){
							echo '<optgroup label="'.$animation_key.'">';	
							foreach($animation_value as $key=>$value){
								$active_class = '';
								if($accordion_animation == $key){$active_class = 'selected="selected"';}
								echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
							}
						}
					
					 ?>
                </select>
                </div>
                <div class='left-info'>
                  <p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p>
                </div>
              </li>
            </ul>
          </div>
          <?php
			if ( isset($accordion_num) && $accordion_num <> '' && isset($atts_content) && is_array($atts_content)){
				foreach ( $atts_content as $accordion ){
					$rand_id = $cs_counter.''.cs_generate_random_string(6);
					$accordion_text = $accordion['content'];
					$defaults = array( 'accordion_title' => 'Title','accordion_active' => 'yes','cs_accordian_icon' => '');
					foreach($defaults as $key=>$values){
						if(isset($accordion['atts'][$key]))
							$$key = $accordion['atts'][$key];
						else 
							$$key =$values;
					 }
					
					if ( $accordion_active == "yes" ) 
					{
						$accordian_active = "selected"; 
					} else { 
						$accordian_active = ""; 
					}
					?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='fa fa-arrows'></i><?php _e('Accordion','LMS');?></h4>
              <a href='#' class='deleteit_node'><i class='fa fa-minus-circle'></i><?php _e('Remove','LMS');?></a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Active','LMS');?></label>
              </li>
              <li class='to-field select-style'>
                <div class='input-sec select-style'>
                <select name='accordion_active[]'>
                  <option value="no" ><?php _e('No','LMS');?></option>
                  <option value="yes" <?php echo esc_attr($accordian_active);?>><?php _e('Yes','LMS');?></option>
                </select>
                </div>
                <div class='left-info'>
                  <p><?php _e('You can set the section that is active here by select dropdown','LMS');?></p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Accordion Title','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <div class='input-sec'><input class='txtfield' type='text' name='accordion_title[]' value="<?php echo cs_allow_special_char($accordion_title);?>" /></div>
                  <div class='left-info'>
                    <p><?php _e('Enter accordion title','LMS');?></p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
              <li class='to-label'>
                <label><?php _e('Title Fontawsome Icon','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="hidden" class="cs-search-icon-hidden" name="cs_accordian_icon[]" value="<?php echo cs_allow_special_char($cs_accordian_icon);?>">
                <?php cs_fontawsome_icons_box($cs_accordian_icon,$rand_id);?>
                <div class='left-info'>
                  <p> <?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?></p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Accordion Text','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='accordion_text[]'><?php echo esc_textarea($accordion_text);?></textarea>
                  <div class='left-info'>
                    <p><?php _e('Enter your content','LMS');?></p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <?php
			}
		}
		?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="accordion_num[]" value="<?php echo esc_attr($accordion_num);?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('accordions', 'shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="fa fa-plus-circle"></i><?php _e('Add accordion','LMS');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="accordion" />
                <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
}

//======================================================================
//Call to action html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_call_to_action' ) ) {
	function cs_pb_call_to_action($die = 0){
		global $cs_node, $count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'call_to_action';
		$cs_counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array('column_size'=>'1/1','cs_call_to_action_section_title'=>'','cs_content_type'=>'','cs_call_action_title'=>'','cs_call_action_contents'=>'','cs_contents_color'=>'', 'cs_call_action_icon'=>'','cs_icon_color'=>'#FFF','cs_call_to_action_icon_background_color'=>'','cs_call_to_action_button_text'=>'','cs_call_to_action_button_link'=>'#','cs_call_to_action_bg_img'=>'','animate_style'=>'slide','class'=>'cs-article-box','cs_call_to_action_class'=>'','cs_call_to_action_animation'=>'','cs_custom_animation_duration'=>'1');
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = "";
		$call_to_action_element_size = '100';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key = $values;
		 }
		$name = 'cs_pb_call_to_action';
		$coloumn_class = 'column_'.$call_to_action_element_size;
	
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}	
	
	?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="call_to_action" data="<?php echo element_size_data_array_index($call_to_action_element_size)?>">
  <?php cs_element_setting($name,$cs_counter,$call_to_action_element_size,'','info-circle');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[call_to_action {{attributes}}]{{content}}[/call_to_action]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Call To Action Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php
		 if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_call_to_action_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_call_to_action_section_title);?>" />
            <div class='left-info'><p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Type','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select id="cs_content_type" name="cs_content_type[]">
              <option value="normal" <?php if($cs_content_type == 'normal'){echo 'selected="selected"';}?>><?php _e('Normal','LMS');?></option>
              <option value="with_center_icon" <?php if($cs_content_type == 'with_center_icon'){echo 'selected="selected"';}?>><?php _e('With Center Icon','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('Select the display type for the call to action','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" size="12" maxlength="150" value="<?php echo cs_allow_special_char($cs_call_action_title);?>" class="" name="cs_call_action_title[]">
            <div class='left-info'><p><?php _e('Put the title for action element','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Short Text','LMS');?></label>
          </li>
          <li class="to-field">
            <textarea row="10" name="cs_call_action_contents[]"  data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
            <div class='left-info'><p><?php _e('Enter short detail about your call to action content','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Text Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color" name="cs_contents_color[]" value="<?php echo esc_attr($cs_contents_color);?>" />
            <div class='left-info'><p><?php _e('Provide a hex colour code here (include #) if you want to override the default','LMS');?> </p></div>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label><?php _e('Fontawsome Icon','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="hidden" class="cs-search-icon-hidden" name="cs_call_action_icon[]" value="<?php echo esc_attr($cs_call_action_icon);?>">
            <?php cs_fontawsome_icons_box($cs_call_action_icon,$name.$cs_counter);?>
            <div class='left-info'><p><?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Icon Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color"  value="<?php echo esc_attr($cs_icon_color);?>" name="cs_icon_color[]">
            <div class='left-info'><p><?php _e('set custom colour for icon','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Image','LMS');?></label>
          </li>
          <li class="to-field">
            <input id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>" name="cs_call_to_action_bg_img[]" type="hidden" class="" value="<?php echo esc_attr($cs_call_to_action_bg_img);?>"/>
            <input name="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/>
            <div class='left-info'><p><?php _e('Select the background image for action element','LMS');?></p></div>
          </li>
        </ul>
        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($cs_call_to_action_bg_img) && trim($cs_call_to_action_bg_img) !='' ? 'inline' : 'none';?>" id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_box" >
          <div class="gal-active">
            <div class="dragareamain" style="padding-bottom:0px;">
              <ul id="gal-sortable">
                <li class="ui-state-default" id="">
                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_call_to_action_bg_img);?>"  id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_img" width="100" height="150"  />
                    <div class="gal-edit-opts"> <a href="javascript:del_media('cs_call_to_action_bg_img<?php echo esc_js($cs_counter)?>')" class="delete"></a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input class="bg_color" value="<?php echo esc_attr($cs_call_to_action_icon_background_color);?>" name="cs_call_to_action_icon_background_color[]">
            <div class='left-info'><p><?php _e('Provide a hex colour code here (include #) if you want to override the default','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Text','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" size="55" name="cs_call_to_action_button_text[]" value="<?php echo esc_attr($cs_call_to_action_button_text);?>" >
            <div class='left-info'><p><?php _e('Text on the button','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Link','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_button_link[]" value="<?php echo esc_attr($cs_call_to_action_button_link);?>" />
            <div class='left-info'><p><?php _e('Button link','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_class[]" class="txtfield"  value="<?php echo esc_attr($cs_call_to_action_class)?>" />
           <div class='left-info'> <p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Animation Class','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="cs_call_to_action_animation[]">
              <option value=""><?php _e('Select Animation','LMS')?></option>
              <?php 
				$animation_array = cs_animation_style();
				foreach($animation_array as $animation_key=>$animation_value){
					echo '<optgroup label="'.$animation_key.'">';	
					foreach($animation_value as $key=>$value){
						$active_class = '';
						if($cs_call_to_action_animation == $key){$active_class = 'selected="selected"';}
						echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
					}
				}
               ?>
            </select>
            <div class='left-info'><p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="call_to_action" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_call_to_action', 'cs_pb_call_to_action');
}

//======================================================================
// Counter html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_counter' ) ) {
	function cs_pb_counter($die = 0){
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_counter';
		$cs_counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array(  
				'column_size' => '1/1',
				'counter_style' => '',
				'counter_icon_type' => '',
				'cs_counter_logo' => '',
				'counter_icon'=>'',
				'counter_icon_color' => '#21cdec',
				'counter_numbers' => '',
				'counter_number_color' => '#333333',
				'counter_title' => '',
				'counter_link_title' => '',
				'counter_link_url' => '',
				'counter_text_color' => '#818181',
				'counter_border' => '',
				'counter_class' => '',
				'counter_animation' => '',
				'cs_custom_animation_duration' => '1'
			 );
			
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = "";
			
		$counter_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_counter';
		$coloumn_class = 'column_'.$counter_element_size;
	
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}	
	$counter_count = rand(345, 6565349);
	?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter);?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="counter" data="<?php echo element_size_data_array_index($counter_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$counter_element_size,'','clock-o');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter);?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter);?>" data-shortcode-template="[cs_counter {{attributes}}]{{content}}[/cs_counter]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Counter Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Style','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_style[]" class="dropdown" >
                <option value="plain" <?php if($counter_style=="plain")echo "selected";?> ><?php _e('Plain View w/top Image','LMS');?></option>
                <option value="pattern" <?php if($counter_style=="pattern")echo "selected";?> ><?php _e('Pattern View w/Left image','LMS');?></option>
                <option value="simple"  <?php if($counter_style=="simple")echo "selected";?> ><?php _e('Simple View w/Right Border','LMS');?></option>
              </select>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose Icon/Image','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_icon_type[]" class="dropdown" onchange="cs_counter_image(this.value,'<?php echo cs_allow_special_char($counter_count)?>','')">
                <option <?php if($counter_icon_type=="icon")echo "selected";?> value="icon" ><?php _e('Icon','LMS');?></option>
                <option <?php if($counter_icon_type=="image")echo "selected";?> value="image" ><?php _e('Image','LMS');?></option>
              </select>
              <div class='left-info'><p><?php _e('choose a icon/image for the counter','LMS');?></p></div>
            </div>
          </li>
        </ul>
        <div class="selected_icon_type" id="selected_icon_type<?php echo cs_allow_special_char($counter_count)?>"  <?php if($counter_icon_type<>"image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo cs_allow_special_char($name.$cs_counter);?>">
            <li class='to-label'>
              <label><?php _e('Fontawsome Icon','LMS');?></label>
            </li>
            <li class="to-field">
              <input type="hidden" class="cs-search-icon-hidden" name="counter_icon[]" value="<?php echo cs_allow_special_char($counter_icon);?>">
              <?php cs_fontawsome_icons_box($counter_icon,$name.$cs_counter);?>
              <div class='left-info'><p> <?php _e('select the fontawsome Icons you would like to add to your menu items','LMS');?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Color','LMS');?></label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="counter_icon_color[]" class="bg_color"  value="<?php echo cs_allow_special_char($counter_icon_color)?>" />
                <div class='left-info'><p><?php _e('set a color for the counter icon','LMS');?></p></div>
              </div>
            </li>
          </ul>
        </div>
        <div class="selected_image_type" id="selected_image_type<?php echo esc_attr($counter_count)?>" <?php if($counter_icon_type=="image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Image','LMS');?></label>
            </li>
            <li class="to-field">
              <input id="cs_counter_logo<?php echo cs_allow_special_char($counter_count);?>" name="cs_counter_logo[]" type="hidden" class="" value="<?php echo cs_allow_special_char($cs_counter_logo);?>"/>
              <input name="cs_counter_logo<?php echo cs_allow_special_char($counter_count);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden; <?php if($counter_icon_type=="image"){ echo "display:block";} else { echo "display:none";}?>" id="cs_counter_logo<?php echo cs_allow_special_char($counter_count);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo cs_allow_special_char($cs_counter_logo);?>"  id="cs_counter_logo<?php echo cs_allow_special_char($counter_count);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_counter_logo<?php echo cs_allow_special_char($counter_count)?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements bcevent_title">
          <li class="to-label">
            <label><?php _e('Set Number','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="counter_numbers[]" value="<?php if(isset($counter_numbers)){echo esc_attr($counter_numbers);}?>" />
              <div class="color-picker"><input type="text" name="counter_number_color[]" value="<?php if(isset($counter_number_color)){echo esc_attr($counter_number_color);}?>" class="bg_color" /></div>
              
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Sub Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_title[]" value="<?php echo cs_allow_special_char($counter_title);?>" class="txtfield"  />
            <div class='left-info'><p><?php _e('Enter a sub title for the counter','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Content','LMS');?></label>
          </li>
          <li class="to-field">
            <textarea type="text" name="counter_text[]" class="txtfield" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Text Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_text_color[]"  value="<?php echo esc_attr($counter_text_color);?>" class="bg_color"  />
            <div class='left-info'><p><?php _e('Provide a hex colour code here (include #) if you want to override the default','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_link_title[]" value="<?php echo cs_allow_special_char($counter_link_title);?>" class="txtfield" />
            <div class='left-info'><p><?php _e('Text on the button','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Url','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_link_url[]" value="<?php echo esc_attr($counter_link_url);?>" class="txtfield"/>
            <div class='left-info'><p><?php _e('Button external&internal Url','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Border Frame','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_border[]" class="dropdown">
                <option <?php if($counter_border=="on")echo "selected";?> value="on" ><?php _e('Yes','LMS');?></option>
                <option <?php if($counter_border=="off")echo "selected";?> value="off" ><?php _e('No','LMS');?></option>
              </select>
             <div class='left-info'> <p><?php _e('Set yes/no border frame form the dropdown','LMS');?> </p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_class[]" class="txtfield"   value="<?php echo esc_attr($counter_class);?>" />
            <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Animation Class','LMS');?> </label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="counter_animation[]">
              <option value=""><?php _e('Select Animation','LMS')?></option>
              <?php 
				$animation_array = cs_animation_style();
				foreach($animation_array as $animation_key=>$animation_value){
					echo '<optgroup label="'.$animation_key.'">';	
					foreach($animation_value as $key=>$value){
						$selected = '';
						if($counter_animation == $key){$selected = 'selected="selected"';}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
			 ?>
            </select>
            <div class='left-info'><p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="counter" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_counter', 'cs_pb_counter');
}

//======================================================================
//Progressbars html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_progressbars' ) ) {
	function cs_pb_progressbars($die = 0){
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$PREFIX = 'cs_progressbars|progressbar_item';
		$parseObject 	= new ShortcodeParse();
		$progressbars_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/1','cs_progressbars_style'=>'skills-sec','progressbars_class'=>'','progressbars_animation'=>'');
		
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
		
		if(is_array($atts_content))
			$progressbars_num = count($atts_content);
			
		$progressbars_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_progressbars';
		$coloumn_class = 'column_'.$progressbars_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="progressbars" data="<?php echo element_size_data_array_index($progressbars_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$progressbars_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Progress Bars Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/cs_progressbars]" data-shortcode-child-template="[progressbar_item {{attributes}}] {{content}} [/progressbar_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_progressbars {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Progress Bars Style','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select class="cs_progressbars_style" name="cs_progressbars_style[]">
                  <option value="round-strip-progressbar" <?php if($cs_progressbars_style=='round-strip-progressbar'){echo 'selected="selected"';}?>><?php _e('Strip Progress bar','LMS');?></option>
                  <option value="strip-progressbar" <?php if($cs_progressbars_style=='strip-progressbar'){echo 'selected="selected"';}?>><?php _e('Pattern Progress bar','LMS');?></option>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Custom Id','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_class[]" class="txtfield"  value="<?php echo esc_attr($progressbars_class)?>" />
                <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p></div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Animation Class','LMS');?></label>
              </li>
              <li class="to-field select-style">
                <select class="dropdown" name="progressbars_animation[]">
                  <option value=""><?php _e('Select Animation','LMS')?></option>
                  <?php 
						$animation_array = cs_animation_style();
						foreach($animation_array as $animation_key=>$animation_value){
							echo '<optgroup label="'.$animation_key.'">';	
							foreach($animation_value as $key=>$value){
								$active_class = '';
								if($progressbars_animation == $key){$active_class = 'selected="selected"';}
								echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
							}
						}
				
				 ?>
                </select>
                <div class='left-info'><p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p></div>
              </li>
            </ul>
          </div>
       <?php
		if ( isset($progressbars_num) && $progressbars_num <> '' && isset($atts_content) && is_array($atts_content)){
			foreach ( $atts_content as $progressbars ){
				$rand_id = $cs_counter.''.cs_generate_random_string(3);
				$defaults = array('progressbars_title'=>'','progressbars_color'=>'#4d8b0c','progressbars_percentage'=>'50');
				foreach($defaults as $key=>$values){
					if(isset($progressbars['atts'][$key]))
						$$key = $progressbars['atts'][$key];
					else 
						$$key =$values;
				 }
          echo '<div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content" id="cs_infobox_'.$rand_id.'">'; ?>
            <header>
              <h4><i class='fa fa-arrows'></i><?php _e('Progress Bar','LMS');?></h4>
              <a href='#' class='deleteit_node'><i class='fa fa-minus-circle'></i><?php _e('Remove','LMS');?></a></header>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Progress Bars Title','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_title[]" class="txtfield" value="<?php echo cs_allow_special_char($progressbars_title)?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Skill (in percentage)','LMS');?></label>
              </li>
              <li class="to-field">
                <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($progressbars_percentage)?>"></div>
                <input  class="cs-range-input"  name="progressbars_percentage[]" type="text" value="<?php echo esc_attr($progressbars_percentage)?>"   />
                <div class='left-info'><p><?php _e('Set the Skill (In %)','LMS');?></p></div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Progress Bars Color','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_color[]" class="bg_color" value="<?php echo balanceTags($progressbars_color) ?>" />
              </li>
            </ul>
          </div>
          <?php
			}
		}
		?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="progressbars_num[]" value="<?php echo esc_attr($progressbars_num)?>" class="fieldCounter"/>
        </div>
        <div class="wrapptabbox" style="padding:0">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('progressbars', 'shortcode-item-<?php echo esc_js($cs_counter);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')"><i class="fa fa-plus-circle"></i><?php _e('Add Progress bar','LMS');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="progressbars" />
                <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_progressbars', 'cs_pb_progressbars');
}

//======================================================================
//PieCharts html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_piecharts' ) ) {
	function cs_pb_piecharts($die = 0){
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_piechart';
		$counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/2','piechart_section_title'=>'','piechart_info'=>'','piechart_text'=>'','piechart_dimensions'=>'250','piechart_width'=>'10','piechart_fontsize'=>'50','piechart_percent'=>'35','piechart_icon'=>'','piechart_icon_color'=>'','piechart_icon_size'=>'20','piechart_fgcolor'=>'#61a9dc','piechart_bg_color'=>'#eee','piechart_bg_image'=>'','piechart_class'=>'','piechart_animation'=>'');
			
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
			
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
			
		$piecharts_element_size = '50';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_piecharts';
		$cs_count_node++;
		$coloumn_class = 'column_'.$piecharts_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		
	?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="piecharts" data="<?php echo element_size_data_array_index($piecharts_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$piecharts_element_size,'','tachometer');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" data-shortcode-template="[cs_piechart {{attributes}}]{{content}}[/cs_piechart]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Pie Charts Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_section_title[]" class="txtfield" value="<?php echo cs_allow_special_char($piechart_section_title);?>" />
            <div class='left-info'><p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Data Info','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_info[]" class="txtfield" value="<?php echo esc_attr($piechart_info)?>" />
            <div class='left-info'><p><?php _e('Give the info abot your data','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Data Percentage','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="cs-drag-slider" data-slider-min="1" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($piechart_percent)?>"></div>
            <input  class="cs-range-input"  name="piechart_percent[]" type="text" value="<?php echo (int)$piechart_percent?>"   />
            <div class='left-info'><p><?php _e('Set currently data in percentage','LMS');?> </p></div>
          </li>
        </ul>
        <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
          <li class='to-label'>
            <label><?php _e('Fontawsome Icon','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="hidden" class="cs-search-icon-hidden" name="piechart_icon[]" value="<?php echo esc_url($piechart_icon);?>">
            <?php cs_fontawsome_icons_box($piechart_icon,$name.$cs_counter);?>
            <div class='left-info'><p><?php _e('Select the fontawsome Icons you would like to add to your menu items','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Icon Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_icon_color[]" class="bg_color" value="<?php echo esc_attr($piechart_icon_color)?>" />
            <div class='left-info'><p><?php _e('Set a icon color','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_fgcolor[]" class="bg_color" value="<?php echo esc_attr($piechart_fgcolor)?>" />
            <div class='left-info'><p><?php _e('Change icon color','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_bg_color[]" class="bg_color" value="<?php echo esc_attr($piechart_bg_color)?>" />
            <div class='left-info'><p><?php _e('Set background color','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Pattern Image','LMS');?></label>
          </li>
          <li class="to-field">
            <input id="piechart_bg_image<?php echo esc_attr($cs_counter)?>" name="piechart_bg_image[]" type="hidden" class="" value="<?php echo esc_url($piechart_bg_image);?>"/>
            <input name="piechart_bg_image<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/>
            <div class='left-info'><p><?php _e('Set background images','LMS');?></p></div>
          </li>
        </ul>
        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($piechart_bg_image) && trim($piechart_bg_image) !='' ? 'inline' : 'none';?>" id="piechart_bg_image<?php echo esc_attr($cs_counter);?>_box" >
          <div class="gal-active">
            <div class="dragareamain" style="padding-bottom:0px;">
              <ul id="gal-sortable">
                <li class="ui-state-default" id="">
                  <div class="thumb-secs"> <img src="<?php echo esc_url($piechart_bg_image);?>"  id="piechart_bg_image<?php echo esc_attr($cs_counter);?>_img" width="100" height="150"  />
                    <div class="gal-edit-opts"> <a   href="javascript:del_media('piechart_bg_image<?php echo esc_attr($cs_counter);?>')" class="delete"></a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="piechart_class[]" class="txtfield"  value="<?php echo esc_attr($piechart_class)?>" />
           <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Animation Class','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="piechart_animation[]">
              <option value=""><?php _e('Select Animation','LMS')?></option>
              <?php 
					$animation_array = cs_animation_style();
					foreach($animation_array as $animation_key=>$animation_value){
						echo '<optgroup label="'.$animation_key.'">';	
						foreach($animation_value as $key=>$value){
							$active_class = '';
							if($piechart_animation == $key){$active_class = 'selected="selected"';}
							echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
						}
					}
			 ?>
            </select>
            <div class='left-info'><p><?php _e('Select Entrance animation type from the dropdown','LMS');?></p></div>
          </li>
        </ul>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="piecharts" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_piecharts', 'cs_pb_piecharts');
}

//======================================================================
// services html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_services' ) ) {
	function cs_pb_services($die = 0){
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_services';
		$cs_counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array( 'service_title' => '', 'column_size'=>'1/2', 'service_type' => 'boxed','service_icon_color' => '','service_icon_bg_color' => '','cs_service_icon' => '','service_icon_postion' => 'left','service_icon_type' => 'icon','service_bg_image' => '','service_link_url' => '#','service_image_size' => '','service_text_color'=>'','service_class' => '','service_animation' => '', 'service_animation_duration'=>'1');
			
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = "";
			
		$services_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_services';
		$coloumn_class = 'column_'.$services_element_size;
	
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}	
	$counter_count = $cs_counter;
	$rand_counter = rand(222,5555);
	?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="services" data="<?php echo element_size_data_array_index($services_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$services_element_size,'','check-square-o');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_services {{attributes}}]{{content}}[/cs_services]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Service Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Service View:','LMS');?></label>
          </li>
          <li class='to-field select-style'>
            <div class='input-sec'>
              <select name='service_type[]' class='dropdown'>
                <option value='boxed' <?php if($service_type == 'boxed'){echo 'selected="selected"';}?>><?php _e('Boxed','LMS');?></option>
                <option value='circle' <?php if($service_type == 'circle'){echo 'selected="selected"';}?>><?php _e('Circle','LMS');?></option>
                <option value='rectangler' <?php if($service_type == 'rectangler'){echo 'selected="selected"';}?>><?php _e('Rectangle','LMS');?></option>
                <option  value="classic" <?php if($service_type == 'classic'){echo 'selected="selected"';}?> ><?php _e('Classic','LMS');?></option>
                <option value='elite' <?php if($service_type == 'elite'){echo 'selected="selected"';}?>><?php _e('Elite','LMS');?></option>
              </select>
              <p class='left-info'><?php _e('Set a view from the dropdown','LMS');?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose Icon','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="service_icon_type[]" class="dropdown" onchange="cs_counter_image(this.value,'<?php echo esc_attr($counter_count);?>', jQuery(this))">
                <option <?php if($service_icon_type=="icon")echo "selected";?> value="icon" ><?php _e('Icon','LMS');?></option>
                <option <?php if($service_icon_type=="image")echo "selected";?> value="image" ><?php _e('Image','LMS');?></option>
              </select>
              <div class='left-info'><p><?php _e('Choose a icon/image type form the dropdown','LMS');?></p></div>
            </div>
          </li>
        </ul>
        <div class="selected_icon_type" id="selected_icon_type<?php echo esc_attr($counter_count)?>" <?php if($service_icon_type<>"image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
            <li class='to-label'>
              <label><?php _e('Fontawsome Icon','LMS');?></label>
            </li>
            <li class="to-field">
              <input type="hidden" class="cs-search-icon-hidden" name="cs_service_icon[]" value="<?php echo esc_attr($cs_service_icon)?>">
              <?php cs_fontawsome_icons_box($cs_service_icon,$name.$cs_counter);?>
              <div class='left-info'><p><?php _e('Select the fontawsome Icons you would like to add to your menu items','LMS');?></p></div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Color','LMS');?></label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="service_icon_color[]" class="bg_color"  value="<?php echo esc_attr($service_icon_color);?>" />
                <div class='left-info'><p><?php _e('Set custom colour for icon','LMS');?></p></div>
              </div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Background Color','LMS');?></label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="service_icon_bg_color[]" class="bg_color"  value="<?php echo esc_attr($service_icon_bg_color);?>" />
                <div class='left-info'><p><?php _e('Set background color','LMS');?></p></div>
              </div>
            </li>
          </ul>
        </div>
        <div class="selected_image_type" id="selected_image_type<?php echo esc_attr($counter_count);?>" <?php if($service_icon_type=="image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Background Image','LMS');?></label>
            </li>
            <li class="to-field">
              <input id="service_bg_image<?php echo esc_attr($rand_counter);?>" name="service_bg_image[]" type="hidden" class="" value="<?php echo esc_url($service_bg_image);?>"/>
              <input name="service_bg_image<?php echo esc_attr($rand_counter);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($service_bg_image) && trim($service_bg_image) !='' ? 'inline' : 'none';?>" id="service_bg_image<?php echo esc_attr($rand_counter);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($service_bg_image);?>"  id="service_bg_image<?php echo esc_attr($rand_counter);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('service_bg_image<?php echo esc_attr($rand_counter);?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Icon/Image Size','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_image_size" name="service_image_size[]">
              <option value="img-small" <?php if($service_image_size == 'img-small'){echo 'selected="selected"';}?>><?php _e('Small','LMS');?></option>
              <option value="img-medum" <?php if($service_image_size == 'img-medum'){echo 'selected="selected"';}?>><?php _e('Medium','LMS');?></option>
              <option value="img-large" <?php if($service_image_size == 'img-large'){echo 'selected="selected"';}?>><?php _e('Large','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('Give image/icon size here','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Icon/Image Postion','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_icon_postion" name="service_icon_postion[]">
              <option value="left" <?php if($service_icon_postion == 'left'){echo 'selected="selected"';}?>><?php _e('left','LMS');?></option>
              <option value="right" <?php if($service_icon_postion == 'right'){echo 'selected="selected"';}?>><?php _e('Right','LMS');?></option>
              <option value="top" <?php if($service_icon_postion == 'top'){echo 'selected="selected"';}?>><?php _e('Top','LMS');?></option>
              <option value="center" <?php if($service_icon_postion == 'center'){echo 'selected="selected"';}?>><?php _e('Center','LMS');?></option>
            </select>
            <div class='left-info'><p><?php _e('Give the image position','LMS');?></p></div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Title','LMS');?></label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='service_title[]' value="<?php echo cs_allow_special_char($service_title);?>" />
            </div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Title Url','LMS');?></label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='service_link_url[]' value="<?php echo esc_url($service_link_url);?>" />
              <div class='left-info'><p><?php _e('Give a external&internal link for the services title','LMS');?></p></div>
            </div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Contents','LMS');?></label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <textarea class='txtfield'  data-content-text="cs-shortcode-textarea" name='service_text[]'><?php echo esc_textarea($atts_content);?></textarea>
             <div class='left-info'> <p><?php _e('Enter the content','LMS');?></p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Text Color','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="service_text_color[]" class="bg_color"  value="<?php echo esc_attr($service_text_color)?>" />
            <div class='left-info'><p><?php _e('Provide a hex colour code here (include #) if you want to override the default','LMS');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="service_class[]" class="txtfield"  value="<?php echo esc_attr($service_class)?>" />
            <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','LMS');?></p></div>
          </li>
        </ul>
        <ul class="form-elements" style="display:none;">
          <li class="to-label">
            <label><?php _e('Animation Class','LMS');?> </label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="service_animation[]">
              <option value=""><?php _e('Select Animation','LMS')?></option>
              <?php 
				$animation_array = cs_animation_style();
				foreach($animation_array as $animation_key=>$animation_value){
					echo '<optgroup label="'.$animation_key.'">';	
					foreach($animation_value as $key=>$value){
						$selected = '';
						if($service_animation == $key){$selected = 'selected="selected"';}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
			
			 ?>
            </select>
           <div class='left-info'> <p><?php _e('Select Entrance animation type from the dropdown','LMS');?> </p></div>
          </li>
        </ul>
      </div>
 
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="services" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_services', 'cs_pb_services');
}

//======================================================================
// Table html form for page builder
//======================================================================
if ( ! function_exists( 'cs_pb_table' ) ) {
	function cs_pb_table($die = 0){
		global $cs_node, $cs_count_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_table';
		$defaultAttributes	= false;
		$parseObject 	= new ShortcodeParse();
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
			$defaultAttributes	= true;
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
	    $defaults = array('column_size'=>'1/2','cs_table_section_title'=>'','table_style'=>'','cs_table_content'=>'','cs_table_class'=>'','cs_table_animation'=>'','cs_table_animation_duration'=>'');
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		$atts_content = '[table]
							[thead]
							  [tr]
								[th]Column 1[/th]
								[th]Column 2[/th]
								[th]Column 3[/th]
								[th]Column 4[/th]
							  [/tr]
							[/thead]
							[tbody]
							  [tr]
								[td]Item 1[/td]
								[td]Item 2[/td]
								[td]Item 3[/td]
								[td]Item 4[/td]
							  [/tr]
							  [tr]
								[td]Item 11[/td]
								[td]Item 22[/td]
								[td]Item 33[/td]
								[td]Item 44[/td]
							  [/tr]
							[/tbody]
					 [/table]';
		
		if ( $defaultAttributes ) {
			$atts_content	= $atts_content;
		} else {
			if(isset($output['0']['content']))
				$atts_content = $output['0']['content'];
			else 
				$atts_content = "";
		}
			
		$table_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_table';
		$cs_count_node++;
		$coloumn_class = 'column_'.$table_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="table" data="<?php echo element_size_data_array_index($table_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$table_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>"  data-shortcode-template="[cs_table {{attributes}}] {{content}} [/cs_table]"  style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Table Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_table_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_table_section_title);?>"   />
            <div class='left-info'>
              <div class='left-info'><p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','LMS');?> </p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Table Style','LMS');?></label>
          </li>
          <li class="to-field">
          	<div class="select-style">
                <select class="table_style" name="table_style[]">
                  <option value="modren" <?php if($table_style == 'modren'){echo 'selected="selected"'; }?>><?php _e('Modern Style','LMS');?></option>
                  <option value="classic" <?php if($table_style == 'classic'){echo 'selected="selected"'; }?>><?php _e('Classic','LMS');?></option>
                </select>
            </div>
            <div class='left-info'>
              <div class='left-info'><p><?php _e('Select a table style','LMS');?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Table Content','LMS');?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <textarea name="cs_table_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
              <div class='left-info'>
                <div class='left-info'><p><?php _e('Enter the content','LMS');?></p>
              </div>
            </div>
          </li>
        </ul>
        <?php 
			if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
				cs_shortcode_custom_dynamic_classes($cs_table_class,$cs_table_animation,$cs_table_animation_duration,'cs_table');
			}
		?>
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
        <ul class="form-elements insert-bg noborder" style="padding-top: 15px; margin: -15px 0px 0px 0px;">
          <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
        </ul>
        <div id="results-shortocde"></div>
        <?php } else {?>
        <ul class="form-elements noborder">
          <li class="to-label"></li>
          <li class="to-field">
            <input type="hidden" name="cs_orderby[]" value="table" />
            <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
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
	add_action('wp_ajax_cs_pb_table', 'cs_pb_table');
}

//======================================================================
// FAQ html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_faq' ) ) {
	function cs_pb_faq($die = 0){
		global $cs_node, $count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$PREFIX = 'cs_faq|faq_item';
		$parseObject 	= new ShortcodeParse();
		$accordion_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/1', 'class' => 'cs-faq','faq_class' => '','faq_animation' => '','cs_faq_section_title'=>'');
		
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
		
		if(is_array($atts_content))
			$faq_num = count($atts_content);
			
		$faq_element_size = '50';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_faq';
		$coloumn_class = 'column_'.$faq_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		
		$ranD_id = rand(0, 99999);
	?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="faq" data="<?php echo element_size_data_array_index($faq_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$faq_element_size,'','question-circle');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter); ?>" data-shortcode-template="[cs_faq {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Faq Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>" data-shortcode-template="{{child_shortcode}}[/cs_faq]" data-shortcode-child-template="[faq_item {{attributes}}] {{content}} [/faq_item]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[cs_faq {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','LMS');?></label>
              </li>
              <li class="to-field">
                <input  name="cs_faq_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_faq_section_title)?>"   />
              </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Custom Id','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="faq_class[]" class="txtfield"  value="<?php echo esc_attr($faq_class);?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Animation Class','LMS');?> </label>
              </li>
              <li class="to-field select-style">
                <select class="dropdown" name="faq_animation[]">
                  <option value=""><?php _e('Select Animation','LMS')?></option>
                  <?php 
						$animation_array = cs_animation_style();
						foreach($animation_array as $animation_key=>$animation_value){
							echo '<optgroup label="'.$animation_key.'">';	
							foreach($animation_value as $key=>$value){
								$active_class = '';
								if($faq_animation == $key){$active_class = 'selected="selected"';}
								echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
							}
						}
					
					 ?>
                </select>
              </li>
            </ul>
          </div>
          <?php
			if ( isset($faq_num) && $faq_num <> '' && isset($atts_content) && is_array($atts_content)){
				foreach ( $atts_content as $faq ){
					$rand_id = $cs_counter.''.cs_generate_random_string(6);
					$faq_text = $faq['content'];
					$defaults = array( 'faq_title' => 'Title','faq_active' => 'yes','cs_faq_icon' => '');
					foreach($defaults as $key=>$values){
						if(isset($faq['atts'][$key]))
							$$key = $faq['atts'][$key];
						else 
							$$key =$values;
					 }
					
					if ( $faq_active == "yes" ) 
					{
						$faq_active = "selected"; 
					} else { 
						$faq_active = ""; 
					}
					?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='fa fa-arrows'></i><?php _e('FAQ','LMS');?></h4>
              <a href='#' class='deleteit_node'><i class='fa fa-minus-circle'></i><?php _e('Remove','LMS');?></a>
            </header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Active','LMS');?></label>
              </li>
              <li class='to-field select-style'>
                <select name='faq_active[]'>
                  <option value="no" ><?php _e('No','LMS');?></option>
                  <option value="yes" <?php echo esc_attr($faq_active);?>><?php _e('Yes','LMS');?></option>
                </select>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Faq Title','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='faq_title[]' value="<?php echo cs_allow_special_char($faq_title);?>" />
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
              <li class='to-label'>
                <label><?php _e('Title Fontawsome Icon','LMS');?></label>
              </li>
              <li class="to-field">
                <input type="hidden" class="cs-search-icon-hidden" name="cs_faq_icon[]" value="<?php echo cs_allow_special_char($cs_faq_icon);?>">
                <?php cs_fontawsome_icons_box($cs_faq_icon,$rand_id);?>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Faq Text','LMS');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='faq_text[]'><?php echo esc_textarea($faq_text);?></textarea>
                </div>
              </li>
            </ul>
          </div>
          <?php
			}
		}
		?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="faq_num[]" value="<?php echo (int)$faq_num?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('faq', 'shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="fa fa-plus-circle"></i><?php _e('Add Faq','LMS');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg noborder">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($ranD_id);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="faq" />
                <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_faq', 'cs_pb_faq');
}

//======================================================================
// Register html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_register' ) ) {
	function cs_pb_register($die = 0){
		global $cs_node, $count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$cs_counter = $_POST['counter'];
		$PREFIX = 'cs_register';
		$parseObject 	= new ShortcodeParse();
		$accordion_num = 0;
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		
		$defaults = array('column_size'=>'1/1','register_title'=>'','register_text'=>'','register_role' => 'contributor','cs_register_class'=>'','cs_register_animation'=>'');
		
		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$atts_content = $output['0']['content'];
		else 
			$atts_content = array();
		
		if(is_array($atts_content))
			$register_num = count($atts_content);
			
		$register_element_size = '100';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_register';
		$coloumn_class = 'column_'.$register_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($register_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$register_element_size,'','external-link');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[cs_register {{attributes}}] {{content}} [/cs_register]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Register Form Options','LMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Form Title','LMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="register_title[]" class="txtfield" value="<?php echo cs_allow_special_char($register_title)?>" />
          </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('User Role','LMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="dropdown" name="register_role[]">
                <option value=""><?php _e('Select User Role','LMS');?></option>
                <option <?php if($register_role == 'subscriber') echo 'selected="selected"'; ?> value="subscriber"><?php _e('Subscriber','LMS');?></option>
                <option <?php if($register_role == 'staff') echo 'selected="selected"'; ?> value="staff"><?php _e('Staff','LMS');?></option>
                <option <?php if($register_role == 'member') echo 'selected="selected"'; ?> value="member"><?php _e('Member','LMS');?></option>
                <option <?php if($register_role == 'instructor') echo 'selected="selected"'; ?> value="instructor"><?php _e('Instructor','LMS');?></option>
                <option <?php if($register_role == 'shop_manager') echo 'selected="selected"'; ?> value="shop_manager"><?php _e('Shop Manager','LMS');?></option>
                <option <?php if($register_role == 'customer') echo 'selected="selected"'; ?> value="customer"><?php _e('Customer','LMS');?></option>
                <option <?php if($register_role == 'contributor') echo 'selected="selected"'; ?> value="contributor"><?php _e('Contributor','LMS');?></option>
                <option <?php if($register_role == 'author') echo 'selected="selected"'; ?> value="author"><?php _e('Author','LMS');?></option>
                <option <?php if($register_role == 'editor') echo 'selected="selected"'; ?> value="editor"><?php _e('Editor','LMS');?></option>
                <option <?php if($register_role == 'administrator') echo 'selected="selected"'; ?> value="administrator"><?php _e('Administrator','LMS');?></option>
            </select>
          </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label>Content</label>
          </li>
          <li class="to-field">
            <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name="register_text[]"><?php echo esc_textarea($register_text)?></textarea>
          </li>
        </ul>
        
        <?php 
		if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
			cs_shortcode_custom_dynamic_classes($cs_register_class,$cs_register_animation,'','cs_register');
		}
		?>
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','LMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="register" />
          <input type="button" value="<?php _e('Save','LMS');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
    </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_register', 'cs_pb_register');
}