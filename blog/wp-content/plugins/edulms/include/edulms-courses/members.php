<?php
/**
 * @Page builder Members Shortcode 
 *
 *
 */
if ( ! function_exists( 'cs_pb_members' ) ) {
	function cs_pb_members($die = 0){
		global $cs_node, $post, $wp_roles;
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
			$PREFIX = 'cs_members';
			$parseObject 	= new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array('var_pb_members_title' => '','var_pb_members_profile_inks'=>'','var_pb_members_roles'=>'','var_pb_members_filterable'=>'','var_pb_members_pagination'=>'','var_pb_members_all_tab'=>'', 'var_pb_members_per_page'=>get_option("posts_per_page"),'var_pb_member_view'=>'','cs_members_class' => '','cs_members_animation' => '');
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			$members_element_size = '50';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$name = 'cs_pb_members';
			$coloumn_class = 'column_'.$members_element_size;
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		if ($var_pb_members_roles){
			$var_pb_members_roles = explode(",", $var_pb_members_roles);
			echo '<script type="text/javascript">
					jQuery(".multiselect").multiselect();
			</script>';
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
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="column" data="<?php echo element_size_data_array_index($members_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$members_element_size);?>
  <div class="cs-wrapp-class-<?php echo absint($cs_counter);?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" data-shortcode-template="[cs_members {{attributes}}]"  style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Members Options','EDULMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','EDULMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="var_pb_members_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_members_title)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Member Views','EDULMS');?></label>
          </li>
          <li class="to-field select-style">
            <select class="cs_size" name="var_pb_member_view[]">
              <option value="default" <?php if($var_pb_member_view == 'default'){echo 'selected="selected"';}?>><?php _e('Number View','EDULMS');?></option>
              <option value="grid" <?php if($var_pb_member_view == 'grid'){echo 'selected="selected"';}?>><?php _e('Grid View','EDULMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Member Roles','EDULMS');?></label>
          </li>
          <li class="to-field">
            <select name="var_pb_members_roles[<?php echo absint($cs_counter);?>][]" multiple="multiple" class="multiselect" style="min-height:100px;">
              <?php 
				 foreach($var_pb_members_roles as $role){
					echo '<option value="'.$role.'" selected="selected">'.$role.'</option>';	 
				 }
				 $roles = $wp_roles->get_names();
				foreach($roles as $role_key=>$role){
					if(!in_array($role_key,$var_pb_members_roles)) {
						echo '<option value="'.$role_key.'" >'.$role.'</option>';
				  } 
				}
			 ?>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Filterable','EDULMS');?></label>
          </li>
          <li class="to-field select-style">
            <select name="var_pb_members_filterable[]" onchange="cs_members_all_tab(this.value, <?php echo esc_js($cs_counter);?>)">
              <option value="on" <?php if($var_pb_members_filterable=="on")echo "selected";?>><?php _e('On','EDULMS');?></option>
              <option value="off" <?php if($var_pb_members_filterable=="off")echo "selected";?>><?php _e('Off','EDULMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements" id="members_all_tab<?php echo absint($cs_counter);?>" <?php if($var_pb_members_filterable=="on"){ echo 'style="display: block;"';} else { echo 'style="display: none;"';}?>>
          <li class="to-label">
            <label><?php _e('Show All Tab','EDULMS');?></label>
          </li>
          <li class="to-field select-style">
            <select name="var_pb_members_all_tab[]">
              <option value="on" <?php if($var_pb_members_all_tab=="on")echo "selected";?>><?php _e('On','EDULMS');?></option>
              <option value="off" <?php if($var_pb_members_all_tab=="off")echo "selected";?>><?php _e('Off','EDULMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e("Profile's Link On/Off",'EDULMS');?></label>
          </li>
          <li class="to-field select-style">
            <select name="var_pb_members_profile_inks[]">
              <option value="on" <?php if($var_pb_members_profile_inks=="on")echo "selected";?>><?php _e('On','EDULMS');?></option>
              <option value="off" <?php if($var_pb_members_profile_inks=="off")echo "selected";?>><?php _e('Off','EDULMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Pagination','EDULMS');?></label>
          </li>
          <li class="to-field select-style">
            <select name="var_pb_members_pagination[]" class="dropdown" >
              <option <?php if($var_pb_members_pagination=="Show Pagination")echo "selected";?> ><?php _e('Show Pagination','EDULMS');?></option>
              <option <?php if($var_pb_members_pagination=="Single Page")echo "selected";?> ><?php _e('Single Page','EDULMS');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('No. of Members Per Page','EDULMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="var_pb_members_per_page[]" class="txtfield" value="<?php echo esc_attr($var_pb_members_per_page);?>" />
            <p><?php _e('To display all the records, leave this field blank.','EDULMS');?></p>
          </li>
        </ul>
        <?php 
			if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
				cs_shortcode_custom_dynamic_classes($cs_members_class,$cs_members_animation,'','cs_members');
			}
		?>
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
        <ul class="form-elements">
          <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" >Insert</a> </li>
        </ul>
        <div id="results-shortocde"></div>
        <?php } else {?>
        <ul class="form-elements noborder">
          <li class="to-label"></li>
          <li class="to-field">
            <input type="hidden" name="cs_orderby[]" value="members" />
            <input type="hidden" name="cs_members_counter[]" value="<?php echo absint($cs_counter)?>" />
            <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" />
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
	add_action('wp_ajax_cs_pb_members', 'cs_pb_members');
}