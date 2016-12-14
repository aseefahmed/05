<?php

// Curriculums start
	//adding columns start
	add_filter('manage_cs_curriculums_posts_columns', 'curriculums_columns_add');
		function curriculums_columns_add($columns) {
			$columns['author'] = 'Author';
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

if(!class_exists('post_type_curriculums')){
		/**
		 * Curriculums Post Type Class
		 */
		class post_type_curriculums
		{
			/**
			 * The Constructor
			 */
			public function __construct()
			{
				// register actions
				add_action('init', array(&$this, 'cs_curriculums_init'));
				add_action('admin_init', array(&$this, 'cs_curriculums_admin_init'));
				add_action( 'save_post', array(&$this,'cs_curriculums_save') );
			} 
			
			/**
			 * hook into WP's init action hook
			 */
			public function cs_curriculums_init()
			{
				// Initialize Post Type
				$this->cs_curriculums_register();
			}
			
			/**
			 * Create the Curriculums post type
			 */
			public function cs_curriculums_register()
			{
				  $labels = array(
					  'name' =>__('Curriculums','EDULMS'),
					  'add_new_item' =>__('Add New Curriculums','EDULMS'),
					  'edit_item' =>__('Edit Curriculums','EDULMS'),
					  'new_item' =>__('New Curriculums Item','EDULMS'),
					  'add_new' =>__('Add New Curriculums','EDULMS'),
					  'view_item' =>__('View Curriculums Item','EDULMS'),
					  'search_items' =>__('Search Curriculums','EDULMS'),
					  'not_found' =>__('Nothing found','EDULMS'),
					  'not_found_in_trash' =>__('Nothing found in Trash','EDULMS'),
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
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_curriculums_admin_init()
			{           
				// Add metaboxes
				add_action('add_meta_boxes', array(&$this, 'cs_meta_curriculums_add'));
			}
			
			/**
			 * hook into WP's add_meta_boxes action hook
			 */
			public function cs_meta_curriculums_add()
			{  
				add_meta_box( 'cs_meta_curriculum', __('Curriculums Options','EDULMS'),  array(&$this, 'cs_meta_curriculums'),'cs-curriculums', 'normal', 'high' ); 
			}
			
			/**
			 * Curriculums Meta attributes Array
			 */
			public function cs_curriculum_attributes()
			{
				return array(
							'title'=>'Curriculums Options',
							'description'=>'',
							'meta_attributes' => array(
								'var_cp_curriculum_type' => array(
									'name' => 'var_cp_curriculum_type',
									'type' => 'dropdown',
									'id' => 'var_cp_curriculum_type',
									'dropdown_type' => 'single',
									'title' =>__('Unit Type','EDULMS'),
									'description' => '',
									'options' => array('Text','Audio','Video'),
								),
								'var_cp_file' => array(
									'name' => 'var_cp_file',
									'type' => 'file',
									'id' => 'var_cp_file',
									'title' => '&nbsp;',
									'description' => '',
									'value' => '1',
								),
									'curriculums_form' => array(
									'name' => 'curriculums_form',
									'type' => 'hidden',
									'id' => 'curriculums_form',
									'title' => '',
									'description' => '',
									'value' => '1',
								),
							),
						);	
			}
			
			/**
			 * Curriculums General Meta Fields
			 */
			public function cs_meta_curriculums( $post ) 
			{
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
                <?php
				$curriculm_attributes = $this->cs_curriculum_attributes();
				$counter = rand(0,100);
				$html = '<div class="page-wrap">
							<div class="option-sec" style="margin-bottom:0;">
								<div class="opt-conts">';
								
									foreach($curriculm_attributes['meta_attributes'] as $key=>$attribute_values){
										
										if($attribute_values['id'] == 'var_cp_file' and $var_cp_curriculum_type == 'Text'){
											$html.='<style>
															#'.$attribute_values['id'].$counter.'{
																display:none;
															}
												</style>';
											}
										if($attribute_values['type'] == 'hidden'){
											$html .= '<input type="hidden" name="'.$attribute_values['id'].'" value="'.$attribute_values['value'].'" />';
										} else {
											$html .= '<ul class="form-elements  " id="'.$attribute_values['id'].$counter.'">
													  <li class="to-label"><label>'.$attribute_values['title'].'</label></li>
													  <li class="to-field">
														<div class="input-sec">';
															switch( $attribute_values['type'] )
															{
																case 'dropdown' :
																
																	$html .= '<div class="select-style"><select name="'.$attribute_values['id'].'" id="' . $attribute_values['id'] . '" class="cs-form-select cs-input" onChange="javascript:cs_curriculum_toggle(this.value,\''.$counter.'\')">' . "\n";
																	foreach( $attribute_values['options'] as $value => $option )
																	{
																		$selected = '';
																		if($option == $var_cp_curriculum_type){$selected = 'selected = "selected"';}
																		
																		$html .= '<option value="' . $option . '" '.$selected.'>' . $option . '</option>' . "\n";
																	}
																	$html .= '</select></div>' . "\n";
																	$html .= '<p class="cs-form-desc">' . $attribute_values['description'] . '</p>' . "\n";
																	break;
																case 'file' :
																	$html .= '<input id="'.$attribute_values['id'].'" name="'.$attribute_values['id'].'" value="'.$var_cp_file.'" type="text" class="small" />
																	<input id="' . $attribute_values['id'] . '" name="'.$attribute_values['id'].'" type="button" class="uploadfile left" value="'.__('Browse','EDULMS').'"/>';
																	break;
															}
												$html .= '</div>
													 </li>
												  	</ul>';
										}
									}
						$html .= '</div>
						</div>
					<div class="clear"></div>
				</div>';
				echo balanceTags($html, true);
			}
			
			function cs_curriculums_save( $post_id ) { 
				if ( isset($_POST['curriculums_form']) and $_POST['curriculums_form'] == 1 ) {
					$sxe = new SimpleXMLElement("<curriculums></curriculums>"); //curriculm_duration
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
						$curriculm_attributes = $this->cs_curriculum_attributes();
						foreach($curriculm_attributes['meta_attributes'] as $key=>$value)
						  {
							  if(isset($key)){
								  $value = (empty($_POST[$key]))? '' : $_POST[$key];
								  $sxe->addChild($key,$value);
							  }
						  }
					$counter = 0;
					update_post_meta( $post_id, 'cs_meta_curriculum', $sxe->asXML() );
				}
			}
	// Curriculums end
			
		}
		
}

?>