<?php
	// Curriculums start
		//adding columns start
		add_filter('manage_cs_curriculums_posts_columns', 'curriculums_columns_add');
			function curriculums_columns_add($columns) {
				$columns['author'] =__('Author','LMS');
				return $columns;
		}
		add_action('manage_cs_curriculums_posts_custom_column', 'curriculums_columns');
			function curriculums_columns($name) {
				global $post;
				switch ($name) {
					case 'author':
						echo get_the_author();
						break;
				}
			}
		//adding columns end
	function cs_curriculums_register() {  
		$labels = array(
			'name' =>__('Curriculums','LMS'),
			'add_new_item' =>__('Add New Curriculums','LMS'),
			'edit_item' =>__('Edit Curriculums','LMS'),
			'new_item' =>__('New Curriculums Item','LMS'),
			'add_new' =>__('Add New Curriculums','LMS'),
			'view_item' =>__('View Curriculums Item','LMS'),
			'search_items' =>__('Search Curriculums','LMS'),
			'not_found' =>__('Nothing found','LMS'),
			'not_found_in_trash' =>__('Nothing found in Trash','LMS'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-admin-post',
			'show_in_menu' => 'edit.php?post_type=courses',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail')
		); 
        register_post_type( 'cs-curriculums' , $args );
	}
	add_action('init', 'cs_curriculums_register');

// adding Curriculums meta info start
	add_action( 'add_meta_boxes', 'cs_meta_curriculums_add' );
	function cs_meta_curriculums_add()
	{  
		add_meta_box( 'cs_meta_curriculum', __('Curriculums Options','LMS'), 'cs_meta_curriculums', 'cs-curriculums', 'normal', 'high' );  
	}
	function cs_meta_curriculums( $post ) {
		global $cs_xmlObject;
		$cs_meta_curriculum = get_post_meta($post->ID, "cs_meta_curriculum", true);
		if ( $cs_meta_curriculum <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_meta_curriculum);
				$var_cp_curriculum_type = $cs_xmlObject->var_cp_curriculum_type;
				$var_cp_file = $cs_xmlObject->var_cp_file;
				$var_cp_total_marks = $cs_xmlObject->var_cp_total_marks;
				$var_cp_curriculm_paid = $cs_xmlObject->var_cp_curriculm_paid;
		}
		else {
			$var_cp_curriculum_type = $var_cp_total_marks = $var_cp_file = $var_cp_curriculm_paid = '';
		}
	?>
			
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/include/assets/scripts/jquery_datetimepicker.js"></script>
            
            <script type="text/javascript">
				 jQuery(document).ready(function($){
					jQuery('#curriculm_durationn').timepicker();
				});
			
			</script>
    	<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                     
                  <ul class="form-elements">
                    <li class="to-label"><label><?php _e('Unit Type','LMS');?></label></li>
                    <li class="to-field">
                    	<div class="input-sec">
                        	<div class="select-style">
                                <select name="var_cp_curriculum_type" id="var_cp_curriculum_type" onchange="javascript:cs_curriculum_toggle(this.value)" class="gllpSearchButton" >
                                      <option <?php if($var_cp_curriculum_type=='Text')echo "selected"?> ><?php _e('Text','LMS');?></option>
                                      <option <?php if($var_cp_curriculum_type=='Audio')echo "selected"?> ><?php _e('Audio','LMS');?></option>
                                      <option <?php if($var_cp_curriculum_type=='Video')echo "selected"?> ><?php _e('Video','LMS');?></option>
                                </select>
                            </div>
                        </div>
                    </li>
                 </ul>
                 
                  <ul class="form-elements  noborder" id="var_cp_upload_file" style="display:<?php if($var_cp_curriculum_type=='Text' || $var_cp_curriculum_type==''){echo 'none';}else {echo 'block';}?>">
                      <li class="to-label"><label><?php _e('Attach File','LMS');?></label></li>
                      <li class="to-field">
                      	<div class="input-sec">
                          <input id="var_cp_file" name="var_cp_file" value="<?php echo $var_cp_file?>" type="text" class="small" />
                          <label class="browse-icon"><input name="var_cp_file"  type="button" class="uploadMedia left" value="<?php _e('Browse','LMS')?>"/></label>
                       </div>
                      </li>
                  </ul>
          		  
                </div>
            </div>
            <input type="hidden" name="curriculums_form" value="1" />
			<div class="clear"></div>
		</div>
    <?php
	}

	// saving Curriculums meta start
	if ( isset($_POST['curriculums_form']) and $_POST['curriculums_form'] == 1 ) {
		add_action( 'save_post', 'cs_curriculums_save' );
		function cs_curriculums_save( $post_id ) {  
			$sxe = new SimpleXMLElement("<curriculums></curriculums>"); //curriculm_duration
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
			if ( empty($_POST["var_cp_curriculum_type"]) ) $_POST["var_cp_curriculum_type"] = "";
			if ( empty($_POST["var_cp_file"]) ) $_POST["var_cp_file"] = "";
			if ( empty($_POST["var_cp_total_marks"]) ) $_POST["var_cp_total_marks"] = "";
			if ( empty($_POST["var_cp_curriculm_paid"]) ) $_POST["var_cp_curriculm_paid"] = "";
			$sxe->addChild('var_cp_curriculum_type', $_POST['var_cp_curriculum_type'] );
			$sxe->addChild('var_cp_file', $_POST['var_cp_file'] );
			$sxe->addChild('var_cp_total_marks', $_POST['var_cp_total_marks'] );
			$sxe->addChild('var_cp_curriculm_paid', $_POST['var_cp_curriculm_paid'] );
			$counter = 0;
			update_post_meta( $post_id, 'cs_meta_curriculum', $sxe->asXML() );
		}
	// Curriculums end
	}
?>