<?php
	if(!class_exists('post_type_assignments')){
		/**
		 * Assignment Post Type Class
		 */
		class post_type_assignments
		{
			/**
			 * The Constructor
			 */
			public function __construct()
			{
				// register actions
				add_action('init', array(&$this, 'cs_assignment_init'));
				//add_action('admin_init', array(&$this, 'cs_assignment_admin_init'));
			} 
			
			/**
			 * hook into WP's init action hook
			 */
			public function cs_assignment_init()
			{
				// Initialize Post Type
				$this->cs_assignment_register();
			}
			
			/**
			 * Create the Assignment post type
			 */
			public function cs_assignment_register()
			{
				 register_post_type( 'cs-assignments',	array(
									'labels'              => array(
									'name'               => __( 'Assignments', 'EDULMS' ),
									'singular_name'      => __( 'Assignment', 'EDULMS' ),
									'menu_name'          => _x( 'Assignments', 'Admin menu name', 'EDULMS' ),
									'add_new'            => __( 'Add Assignment', 'EDULMS' ),
									'add_new_item'       => __( 'Add New Assignment', 'EDULMS' ),
									'edit'               => __( 'Edit', 'EDULMS' ),
									'edit_item'          => __( 'Edit Assignment', 'EDULMS' ),
									'new_item'           => __( 'New Assignment', 'EDULMS' ),
									'view'               => __( 'View Assignment', 'EDULMS' ),
									'view_item'          => __( 'View Assignment', 'EDULMS' ),
									'search_items'       => __( 'Search Assignment', 'EDULMS' ),
									'not_found'          => __( 'No Assignment found', 'EDULMS' ),
									'not_found_in_trash' => __( 'No Assignment found in trash', 'EDULMS' ),
									'parent'             => __( 'Parent Assignment', 'EDULMS' )
								),
							'description'         => __( 'This is where you can add new Assignment.', 'EDULMS' ),
							'public'              => true,
							'show_ui'             => true,
							'capability_type'     => 'post',
							'show_in_menu' => 'edit.php?post_type=courses',
							'map_meta_cap'        => true,
							'publicly_queryable'  => true,
							'exclude_from_search' => false,
							'hierarchical'        => false, 
							'rewrite'             => false,
							'query_var'           => true,
							'supports'            => array( 'title', 'editor', 'thumbnail'),
							'has_archive'         => 'cs-assignments',
						)
					);
			}
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_assignment_admin_init()
			{           
				// Add metaboxes
				add_action('add_meta_boxes', array(&$this, 'cs_meta_assignments_add'));
			}
			
			/**
			 * hook into WP's add_meta_boxes action hook
			 */
			public function cs_meta_assignments_add()
			{  
				add_meta_box( 'cs_meta_assignments', __('Assignments Options','EDULMS'), array(&$this, 'cs_meta_assignments'), 'cs-assignments', 'normal', 'high' );  
			}
			
			/**
			 * Assignment Meta attributes Array
			 */
			public function cs_assignments_meta_attributes()
			{
				return array(
							'title'=>'Assignments Options',
							'description'=>'',
							'meta_attributes' => array(
								'var_cp_assigment_type' => array(
									'name' => 'var_cp_assigment_type',
									'type' => 'dropdown',
									'id' => 'var_cp_assigment_type',
									'dropdown_type' => 'single',
									'title' =>__('Assignment Type','EDULMS'),
									'description' =>__('Select the Assignment type','EDULMS'),
									'options' => array(
													'doc' => 'doc',
													'docx' => 'docx',
													'pdf' => 'pdf',
													'gif' => 'gif',
													'png' => 'png',
													'jpeg' => 'jpeg',
												),
								),
								/*'var_cp_assignment_file' => array(
									'name' => 'var_cp_assignment_file',
									'type' => 'file',
									'id' => 'var_cp_assignment_file',
									'title' => 'Attach Assignment',
									'description' => '',
									'value' => '',
									
								),*/
								'assignment_form' => array(
									'name' => 'assignment_form',
									'type' => 'hidden',
									'id' => '',
									'title' => '',
									'description' => '',
									'value' => '1',
								),
							),
						);	
			}
			
			/**
			 * Assignment General Meta Fields
			 */
			public function cs_meta_assignments( $post ) 
			{
				global $cs_xmlObject;
				$cs_meta_assigment = get_post_meta($post->ID, "cs_meta_assignment", true);
				if ( $cs_meta_assigment <> "" ) {
					$cs_xmlObject = new SimpleXMLElement($cs_meta_assigment);
					$var_cp_assigment_type = $cs_xmlObject->var_cp_assigment_type;
					$var_cp_assignment_file = $cs_xmlObject->var_cp_assignment_file;
				} else {
					$var_cp_assignment_file = $var_cp_assigment_type = '';
				}
				
				$assignment_attributes = $this->cs_assignments_meta_attributes();
				$html = '<div class="page-wrap">
							<div class="option-sec" style="margin-bottom:0;">
								<div class="opt-conts">';
									foreach($assignment_attributes['meta_attributes'] as $key=>$attribute_values){
										if($attribute_values['type'] == 'hidden'){
											$html .= '<input type="hidden" name="assignment_meta_options[' . $key . ']" value="'.$attribute_values['value'].'" />';
										} else {
											$html .= '<ul class="form-elements  noborder">
													  <li class="to-label"><label>'.$attribute_values['title'].'</label></li>
													  <li class="to-field">
														<div class="input-sec">';
															switch( $attribute_values['type'] )
															{
																case 'dropdown' :
																	$html .= '<select name="assignment_meta_options[' . $key . ']" id="' . $attribute_values['id'] . '" class="cs-form-select cs-input">' . "\n";
																	foreach( $attribute_values['options'] as $value => $option )
																	{
																		$selected = '';
																		if($value == $var_cp_assigment_type){$selected = 'selected = "selected"';}
																		
																		$html .= '<option value="' . $value . '" '.$selected.'>' . $option . '</option>' . "\n";
																	}
																	$html .= '</select>' . "\n";
																	$html .= '<p class="cs-form-desc">' . $attribute_values['description'] . '</p>' . "\n";
																	break;
																case 'file' :
																	$html .= '<input id="' . $attribute_values['id'] . '" name="assignment_meta_options[' . $key . ']" value="'.$var_cp_assignment_file.'" type="text" class="small" />
																	<input id="' . $attribute_values['id'] . '" name="assignment_meta_options[' . $key . ']" type="button" class="uploadfile left" value="Browse"/>';
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
			
			/**
			 * Save Meta Fields
			 */
			public function cs_assignment_save( $post_id ){ 
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
				$sxe = new SimpleXMLElement("<assignment></assignment>");
				$assignment_attributes = $this->cs_assignments_meta_attributes();
				foreach($_POST['assignment_meta_options'] as $key=>$value)
				{
					if(isset($key)){
						$value = (empty($value))? '' : $value;
						$sxe->addChild($key, $value);
					}
				}
				update_post_meta( $post_id, 'cs_meta_assignment', $sxe->asXML() );
			}
		} // END class
	}