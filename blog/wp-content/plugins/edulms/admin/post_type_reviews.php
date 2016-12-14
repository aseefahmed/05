<?php
	// Reviews start
		//adding columns start
		add_filter('manage_cs-reviews_posts_columns', 'reviews_columns_add');
			function reviews_columns_add($columns) {
				$columns['users'] =__('Users','EDULMS');
				$columns['rating'] =__('Rating','EDULMS');
				$columns['courses'] =__('Courses','EDULMS');
				$columns['author'] =__('Author','EDULMS');
				return $columns;
		}
		add_action('manage_cs-reviews_posts_custom_column', 'reviews_columns',10, 2);
			function reviews_columns($name) {
				global $post;
				$var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
				$var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
				$var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
				switch ($name) {
					case 'users':
 						echo get_the_author_meta('display_name', $var_cp_reviews_members);
 					break;
					case 'rating':
						echo esc_attr($var_cp_rating);
						
					break;
					case 'courses':
						echo get_the_title($var_cp_courses);
					break;
					case 'author':
						echo get_the_author();
					break;
				}
			}
		//adding columns end
		
if(!class_exists('post_type_reviews')){
	
	class post_type_reviews{
	
			/**
			 * The Constructor
			 */
			public function __construct()
			{
				// register actions
				add_action('init', array(&$this, 'cs_reviews_init'));
				add_action('admin_init', array(&$this, 'cs_reviews_admin_init'));
				
				add_action('wp_ajax_cs_add_reviews', array(&$this, 'cs_add_reviews'));
				add_action('wp_ajax_nopriv_cs_add_reviews', array(&$this, 'cs_add_reviews'));
				
				//if ( isset($_POST['reviews_form']) and $_POST['reviews_form'] == 1 ) {
						add_action( 'save_post', array(&$this, 'cs_reviews_save') );
				//}
			}
			/**
			 * hook into WP's init action hook
			 */
			public function cs_reviews_init()
			{
				// Initialize Post Type
				$this->cs_reviews_register();
			}
			
			public function cs_add_reviews(){
			global $post,$cs_theme_options,$cs_course_options;
			$user_id = cs_get_user_id();
			$user_reviews_count = count_user_posts_by_type( $user_id, 'cs-reviews' );
				if ( $_SERVER["REQUEST_METHOD"] == "POST"){
						$reviews_title = $_POST['reviews_title'];
						$course_id = $_POST['course_id'];
						$reviews_description = $_POST['reviews_description'];
						$var_cp_reviews_rating = $_POST['var_cp_reviews_rating'];
						$cs_course_options = $cs_course_options;
						$reviewStatus	= $cs_course_options['cs_review_status'];
						if ( $reviewStatus == 'Pending' ) {
							$status	= 'pending';
							
						} else if ( $reviewStatus == 'Aproved' ) {
							$status	= 'publish';
						}
						$reviews_post = array(
						  'post_title'    => $reviews_title ,
						  'post_content'  => $reviews_description,
						  'post_status'   => $status,
						  'post_author'   => $user_id,
						  'post_type'   => 'cs-reviews',
						);
						$post_id = wp_insert_post( $reviews_post );
						if($post_id){
							update_post_meta($post_id, "cs_reviews_rating", $var_cp_reviews_rating);
							update_post_meta($post_id, "cs_reviews_user", $user_id);
							update_post_meta($post_id, "cs_reviews_course", $course_id);
							$this->cs_update_rating($course_id);
							$json	= array();
							if ( $reviewStatus == 'Pending' ) {
								$json['type']	= 'pending';
								$json['message']	= __('Your Given Review will be Sent to Administrators. Once your Review has been Approved.Review Will be Posted publicly on the web','EDULMS');
							} else if ( $reviewStatus == 'Aproved' ) {
								$json['type']	= 'aproved';
								$json['message']	=__('Your Given Review has been Approved and Will be Posted publicly on the web','EDULMS');
							}
						echo json_encode($json);
						die();
						}
				}
			exit;
			}
			
			public function cs_reviews_register()
			{
				$labels = array(
					'name' =>__('Reviews','EDULMS'),
					'add_new_item' =>__('Add New Reviews','EDULMS'),
					'edit_item' =>__('Edit Reviews','EDULMS'),
					'new_item' =>__('New Reviews Item','EDULMS'),
					'add_new' =>__('Add New Reviews','EDULMS'),
					'view_item' =>__('View Reviews Item','EDULMS'),
					'search_items' =>__('Search v','EDULMS'),
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
					'supports' => array('title','editor')
				); 
				register_post_type( 'cs-reviews' , $args );
				
			}
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_reviews_admin_init()
			{           
				// Add metaboxes
				add_action( 'add_meta_boxes',  array(&$this, 'cs_meta_reviews_add') );
			}
			/**
			 * hook into WP's add_meta_boxes action hook
			 */
			public function cs_meta_reviews_add()
			{  
				add_meta_box( 'cs_meta_reviews', __('Reviews Options','EDULMS'), array(&$this, 'cs_meta_reviews'), 'cs-reviews', 'normal', 'high' );  
			}
			
			/**
			 * Reviews Meta attributes Array
			 */
			public function cs_reviews_meta_attributes()
			{
				return array(
							'title'=>'Reviews Options',
							'description'=>'',
							'meta_attributes' => array(
								'cs_reviews_user' => array(
									'name' => 'cs_reviews_user',
									'type' => 'dropdown_user',
									'id' => 'cs_reviews_user',
									'dropdown_type' => 'single',
									'title' =>__('Select User','EDULMS'),
									'description' =>__('Select The User.','EDULMS'),
									'options' => get_users('orderby=nicename'),
								),
								'cs_reviews_rating' => array(
									'name' => 'cs_reviews_rating',
									'type' => 'dropdown',
									'id' => 'cs_reviews_rating',
									'dropdown_type' => 'single',
									'title' =>__('Rating','EDULMS'),
									'description' =>__('Select The Rating.','EDULMS'),
									'options' =>  range(1,5),
								),
								'cs_reviews_course' => array(
									'name' => 'cs_reviews_course',
									'type' => 'dropdown_query',
									'id' => 'cs_reviews_course',
									'dropdown_type' => 'single',
									'title' =>__('Select Course','EDULMS'),
									'description' =>__('Select The Course.','EDULMS'),
									'options' => array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'courses'),
								),

								'reviews_form' => array(
									'name' => 'reviews_form',
									'type' => 'hidden',
									'id' => 'reviews_form',
									'title' => '',
									'description' => '',
									'value' => '1',
								),
							),
						);
			}
			
			public function cs_meta_reviews( $post ) 
			{
				
				global $cs_xmlObject, $post;
				
				$reviews_attributes = $this->cs_reviews_meta_attributes();
				
				$html = '<div class="page-wrap">
							<div class="option-sec" style="margin-bottom:0;">
								<div class="opt-conts">';
									foreach($reviews_attributes['meta_attributes'] as $key=>$attribute_values){
										if($attribute_values['type'] == 'hidden'){
											$html .= '<input type="hidden" name="'.$attribute_values['id'].'" value="'.$attribute_values['value'].'" />';
										} else {
											$html .= '<ul class="form-elements  noborder">
													  <li class="to-label"><label>'.$attribute_values['title'].'</label></li>
													  <li class="to-field">
														<div class="input-sec">';
															
															switch( $attribute_values['type'] )
															{
																
																case 'dropdown' :
																	
																	$html .= '<select name="'.$attribute_values['id'].'" id="' . $attribute_values['id'] . '" class="cs-form-select cs-input">' . "\n";
																	foreach( $attribute_values['options'] as $value => $option )
																	{
																		$selected = '';
																		
																		if($option == get_post_meta($post->ID, $attribute_values['id'], true)){$selected = 'selected = "selected"';}
																		
																		$html .= '<option value="' . $option . '" '.$selected.'>' . $option . '</option>' . "\n";
																	}
																	$html .= '</select>' . "\n";
																	$html .= '<p class="cs-form-desc">' . $attribute_values['description'] . '</p>' . "\n";
																	break;
																case 'dropdown_user' :
																	$html .= '<select name="'.$attribute_values['id'].'" id="' . $attribute_values['id'] . '" class="cs-form-select cs-input">' . "\n";
																	foreach( $attribute_values['options'] as  $user )
																	{
																		if($user->ID == get_post_meta($post->ID, $attribute_values['id'], true)){
																			  $selected =' selected="selected"';
																		  }else{ 
																			  $selected = '';
																		  }
																																				
																		$html .= '<option value="' . $user->ID . '" '.$selected.'>' .$user->display_name. '</option>' . "\n";
																	}
																	$html .= '</select>' . "\n";
																	$html .= '<p class="cs-form-desc">' . $attribute_values['description'] . '</p>' . "\n";
																	break;
																case 'file' :
																	$html .= '<input id="'. $attribute_values['id'].'" name=" '.$attribute_values['id'].'" value="'.$var_cp_assignment_file.'" type="text" class="small" />
																	<input id="' . $attribute_values['id'] . '" name="'.$attribute_values['id'].'" type="button" class="uploadfile left" value="Browse"/>';
																	break;
																case 'dropdown_query' :
																	$var_cp_course = get_post_meta($post->ID, $attribute_values['id'], true);
																	$html .= '<select name="'.$attribute_values['id'].'" id="' . $attribute_values['id'] . '" class="cs-form-select cs-input">' . "\n";
																	query_posts($attribute_values['options']);
                                        							while (have_posts() ) : the_post();
                                                                          $cs_courses_id = get_the_id();
                                                                  			
                                                                          if($cs_courses_id == $var_cp_course){
                                                                                  $selected =' selected="selected"';
                                                                              }else{ 
                                                                                  $selected = '';
                                                                              }
                                                                         $html.='<option value="'.$cs_courses_id.'" '.$selected.'>'.get_the_title().'</option>';
                                                                          
                                                                	 endwhile; wp_reset_query();
																	 $html.='</select>';
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
			public function cs_reviews_save( $post_id ){ 
				
				if ( isset($_POST['reviews_form']) and $_POST['reviews_form'] == 1 ) {
					
						$sxe = new SimpleXMLElement("<reviews></reviews>");
						
						if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
						$this->cs_update_rating($_POST["var_cp_courses"]);
						
						$reviews_attributes = $this->cs_reviews_meta_attributes();
						foreach($reviews_attributes['meta_attributes'] as $key=>$value)
						  {
							  if(isset($key)){
								  $value = (empty($_POST[$key]))? '' : $_POST[$key];
								  update_post_meta($post_id, $key, $value);
							  }
						  }
						$counter = 0;
						update_post_meta( $post_id, 'cs_meta_reviews', $sxe->asXML() );
				}
			}
			
		  public function cs_update_rating($id){

			global $post,$wpdb;
			
			$reviews_args = array(
				'posts_per_page'			=> "-1",
				'post_type'				=> 'cs-reviews',
				'post_status'				=> 'publish',
				'meta_key'				=> 'cs_reviews_course',
				'meta_value'				=> $id,
				'meta_compare'			=> "=",
				'orderby'					=> 'meta_value',
				'order'					=> 'ASC',
			);
			$reviews_query = new WP_Query($reviews_args);
			$reviews_count = $reviews_query->post_count;
			$var_cp_rating = 0;
			
			if ( $reviews_query->have_posts() <> "" ) {
				while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
					$var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
				endwhile;
			}
			
			if($var_cp_rating){
				$var_cp_rating = $var_cp_rating/$reviews_count;
			}
			
			update_post_meta($id, "cs_course_review_rating", $var_cp_rating);
			
  }
	}
	
}

?>