<?php 
	global $current_user;
	
	//if(isset($current_user->user_login) && $current_user->user_login == 'cs-chimpstudio'){
		add_action('save_post', 'cs_dynamic_custom_post_type_save_postdata');
		add_action('add_meta_boxes', 'cs_dynamic_custom_post_type_add_meta_boxes');
		add_action('init', 'init_custom_post_types');
	//}
// Custom Post type	

	function init_custom_post_types(){
	
		$labels = array(
			'name' => _x('DCPT', 'post type general name','LMS'),
			'singular_name' => _x('DCPT', 'post type singular name','LMS'),
			'add_new' => _x('Add New DCPT', 'CS: Dynamic Custom Posty Type','LMS'),
			'add_new_item' => __('Add New Post type','LMS'),
			'edit_item' => __('Edit DCPT','LMS'),
			'new_item' => __('New DCPT','LMS'),
			'all_items' => __('All DCPT','LMS'),
			'view_item' => __('View DCPT','LMS'),
			'search_items' => __('Search DCPT','LMS'),
			'not_found' => __('No DCPT','LMS'),
			'not_found_in_trash' => __('No DCPT found in Trash','LMS'),
			'parent_item_colon' => '',
			'menu_name' => __('DCPT','LMS')
		);
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title')
		);
		//register_post_type('dcpt', $args);
		
		register_post_type( 'dcpt',	array(
									'labels'              => array(
									'name'               => __( 'DCPT', 'LMS' ),
									'singular_name'      => __( 'DCPT', 'LMS' ),
									'menu_name'          => _x( 'DCPT', 'Admin menu name', 'LMS' ),
									'add_new'            => __( 'Add DCPT', 'LMS' ),
									'add_new_item'       => __( 'Add New DCPT', 'LMS' ),
									'edit'               => __( 'Edit', 'LMS' ),
									'edit_item'          => __( 'Edit DCPT', 'LMS' ),
									'new_item'           => __( 'New DCPT', 'LMS' ),
									'view'               => __( 'View DCPT', 'LMS' ),
									'view_item'          => __( 'View DCPT', 'LMS' ),
									'search_items'       => __( 'Search DCPT', 'LMS' ),
									'not_found'          => __( 'No DCPT found', 'LMS' ),
									'not_found_in_trash' => __( 'No DCPT found in trash', 'LMS' ),
									'parent'             => __( 'Parent DCPT', 'LMS' )
								),
							'description'         => __( 'This is where you can add new DCPT.', 'LMS' ),
							'public'              => true,
							'show_ui'             => true,
							'capability_type'     => 'post',
						 	'show_in_menu' 		  => false,
							'map_meta_cap'        => true,
							'publicly_queryable'  => true,
							'exclude_from_search' => false,
							'hierarchical'        => false, 
							'rewrite'             => false,
							'query_var'           => true,
							'supports'            => '',
							'has_archive'         => 'dcpt',
						)
					);
		
		
		
		
		
		
		
		
		
	}
	
	function cs_dynamic_custom_post_type_add_meta_boxes() {
		add_meta_box('cs_dynamic_custom_post_type_meta_id', 'Custom Post Type Settings', 'cs_dynamic_custom_post_type_inner_custom_box', 'dcpt', 'normal');
	}
	function cs_dynamic_custom_post_type_inner_custom_box() {
		global $post;
		$cs_public = get_post_meta($post->ID, 'cs_public', true);
		$cs_publicly_queryable = get_post_meta($post->ID, 'cs_publicly_queryable', true);
		$cs_show_ui = get_post_meta($post->ID, 'cs_show_ui', true);
		$cs_show_in_menu = get_post_meta($post->ID, 'cs_show_in_menu', true);
		$cs_query_var = get_post_meta($post->ID, 'cs_query_var', true);
		$cs_rewrite = get_post_meta($post->ID, 'cs_rewrite', true);
		$cs_has_archive = get_post_meta($post->ID, 'cs_has_archive', true);
		$cs_hierarchical = get_post_meta($post->ID, 'cs_hierarchical', true);
		$cs_capability_type = get_post_meta($post->ID, 'cs_capability_type', true);
		$cs_menu_position = get_post_meta($post->ID, 'cs_menu_position', true);
		$cs_s_title = get_post_meta($post->ID, 'cs_s_title', true);
		$cs_s_editor = get_post_meta($post->ID, 'cs_s_editor', true);
		$cs_s_author = get_post_meta($post->ID, 'cs_s_author', true);
		$cs_s_thumbnail = get_post_meta($post->ID, 'cs_s_thumbnail', true);
		$cs_s_excerpt = get_post_meta($post->ID, 'cs_s_excerpt', true);
		$cs_s_comments = get_post_meta($post->ID, 'cs_s_comments', true);
		$cs_general_name = get_post_meta($post->ID, 'cs_general_name', true);
		$cs_singular_name = get_post_meta($post->ID, 'cs_singular_name', true);
		$cs_add_new = get_post_meta($post->ID, 'cs_add_new', true);
		$cs_add_new_item = get_post_meta($post->ID, 'cs_add_new_item', true);
		$cs_edit_item = get_post_meta($post->ID, 'cs_edit_item', true);
		$cs_new_item = get_post_meta($post->ID, 'cs_new_item', true);
		$cs_all_items = get_post_meta($post->ID, 'cs_all_items', true);
		$cs_view_item = get_post_meta($post->ID, 'cs_view_item', true);
		$cs_search_items = get_post_meta($post->ID, 'cs_search_items', true);
		$cs_not_found = get_post_meta($post->ID, 'cs_not_found', true);
		$cs_not_found_in_trash = get_post_meta($post->ID, 'cs_not_found_in_trash', true);
		$cs_parent_item_colon = get_post_meta($post->ID, 'cs_parent_item_colon', true);
		
	?>
					<div class="tabs horizontal" id="pbwp-options">
						<ul id="myTab" class="reports-tabs">
							<li class="active"><a href="#tab-posttype-settings" data-toggle="tab"><i class="fa fa-facebook"></i> <?php _e('Post type Settings','LMS');?> </a></li>
							
							<li class=""><a href="#tab-options" data-toggle="tab"><i class="fa fa-youtube"></i><?php _e('Options','LMS');?></a></li>
							
							<li class=""><a href="#tab-custom-fileds" data-toggle="tab"><i class="fa fa-twitter"></i> <?php _e('Custom Fields','LMS');?></a></li>
							
							<li class=""><a href="#tab1-packages" data-toggle="tab"><i class="fa fa-youtube"></i><?php _e('Packages','LMS');?></a></li>
							<!--<li class=""><a href="#tab-transactions" data-toggle="tab"><i class="fa fa-youtube"></i>Transactions</a></li>-->
							<li class=""><a href="#tab-design-settings" data-toggle="tab"><i class="fa fa-youtube"></i><?php _e('Design Settings','LMS');?></a></li>
							<!--<li class=""><a href="#tab-import-xport" data-toggle="tab"><i class="fa fa-youtube"></i>IMPORT/EXPERT</a></li>-->
							<li class="pull-right"><?php submit_button( __( 'Publish','LMS' ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?></li>
							
						</ul>
						<div class="tab-content">
							
							<div id="tab-posttype-settings" class="tab-pane fade active in">
								<div class="row">
									<div class="col-md-8">
								<?php
									$cs_dynamic_custom_post_type_meta_options = cs_post_type_array();
									foreach($cs_dynamic_custom_post_type_meta_options as $cs_dynamic_custom_post_type_meta_options_key=>$cs_dynamic_custom_post_type_meta_options_value){
										// if($cs_dynamic_custom_post_type_meta_options_value['title']){
										// 	echo '<ul class="form-elements">
										// 		<li class="to-label"><label>'.$cs_dynamic_custom_post_type_meta_options_value['title'].'</label></li>
										// 	</ul>';
										// }
										if(is_array($cs_dynamic_custom_post_type_meta_options_value) && $cs_dynamic_custom_post_type_meta_options_value){
											foreach($cs_dynamic_custom_post_type_meta_options_value as $key=>$value){
											if(is_array($value) && $value){	
										
												if($value['type'] == 'text'){	
													$option_db_value = get_post_meta($post->ID, $key, true);
													echo '<ul class="form-elements">
														<li class="to-label"><label>'.$value['title'].'</label></li>
														<li class="to-field">
															<input type="text" value="'.$option_db_value.'" name="dcpt['.$key.']">
														</li>
													</ul>';
												} else if($value['type'] == 'checkbox'){
													$checked  = '';
													$option_db_value_checkbox = get_post_meta($post->ID, $key, true);
													if(!isset($option_db_value_checkbox) && $option_db_value_checkbox == ''){$option_db_value_checkbox='on';}
													if($option_db_value_checkbox == 'on'){$checked = 'checked="checked"';}
													echo '<ul class="form-elements">
														<li class="to-label"><label>'.$value['title'].'</label></li>
														<li class="to-field">
															<label class="pbwp-checkbox"><input type="hidden" name="dcpt['.$key.']" value="" /><input type="checkbox" name="dcpt['.$key.']" '.$checked.' /><span class="pbwp-box"></span></label>
														</li>
													</ul>';
												} else if($value['type'] == 'select'){
													$option_db_value = get_post_meta($post->ID, $key, true);
													
													$options = '';
													foreach($value['options'] as $option_key=>$option_value){
														$selected  = '';
														if($option_db_value == $option_key){$selected = 'selected="selected"';}
															$options .= '<option value="'.$option_key.'" '.$selected.'>'.$option_value.'</option>';
													}
													//$options = 
													echo '<ul class="form-elements">
														<li class="to-label"><label>'.$value['title'].'</label></li>
														<li class="to-field">
															<div class="select-style">
																<select name="dcpt['.$key.']">'.$options.'</select>
															</div>
														</li>
													</ul>';
													
												}
											 }
											}
										}
										echo '<input type="hidden" value="true" name="dcpt-hidd" />';
									}
								
								?>
							</div>
							<div class="col-md-4">
								
							<section class="pbwp-noticebox">
								<div class="pbwp-notice-content">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, sunt, animi, eveniet voluptatibus eligendi illum ad ipsa cum molestiae distinctio non quasi dolorem vitae sint doloribus aliquid numquam suscipit. Quibusdam, commodi, architecto, similique dolor quos ullam ipsam voluptates neque rerum sunt quia dolore ipsum tenetur repudiandae eligendi perferendis pariatur. Autem, enim at aliquam numquam in ullam repudiandae ipsum nostrum quae placeat animi mollitia minus nobis nemo fugit dicta iste sit libero porro expedita tenetur vel aspernatur natus. Quidem nulla hic neque ad cupiditate ullam exercitationem molestiae illum modi. Saepe, sint maiores vitae iste dignissimos et voluptas nisi. Accusantium, nam, incidunt, tenetur, libero maiores enim aspernatur at nisi facilis ex odit totam nihil doloribus eos molestias similique nemo ut. Quas, dolorum ipsa quidem totam dicta id. Doloribus, voluptates, tenetur consectetur dicta inventore aliquid dolorem voluptate eum sint nobis magni porro quasi beatae commodi repudiandae distinctio magnam blanditiis reiciendis vitae velit voluptatum.
								</div>
								<footer class="pbwp-notice-footer"><i class="fa fa-angle-down"></i></footer>
							</section>
							</div>
								</div>
							</div>
							<div id="tab-options" class="tab-pane fade">
								<div class="row">
									<div class="col-md-8">
										<?php  
			
										echo cs_dynamic_custom_post_options(); ?>
									</div>
									<aside class="col-md-4">
										<section class="pbwp-noticebox">
											<div class="pbwp-notice-content">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, eum, neque, delectus harum soluta eligendi illo voluptates doloribus nisi cumque veritatis cum aut natus iste totam ad voluptatum dolores impedit tempora dicta numquam maxime voluptatibus sed doloremque explicabo repellendus necessitatibus deleniti! Odio, labore deleniti voluptas enim autem aliquid dicta provident consectetur id earum! Alias, harum, rerum, velit voluptas voluptate enim aperiam qui quae architecto provident modi eos sunt quidem incidunt neque beatae deserunt quaerat iusto nulla quo cum officia laboriosam reiciendis. Aliquid, quia, eius commodi doloremque omnis delectus laudantium dolor reiciendis non nulla saepe itaque! Quo, eum in culpa mollitia.
											</div>
											<footer class="pbwp-notice-footer"><i class="fa fa-angle-down"></i></footer>
										</section>
										<script>
											jQuery(document).ready(function($) {
												$(".pbwp-noticebox") .each(function(index, el) {
													var a = $(".pbwp-notice-content").text();
													if (a.length > 700 ) {
														$(this).find(".pbwp-notice-content").html(a.substr(0,700)+"<span class='hide-text'>"+a.substr(700)+"</span>")
													}
												});
												$(".pbwp-notice-footer") .click(function(event) {
													$(this).toggleClass("active").prev().find(".hide-text").fadeToggle(300);
												});
											});
										</script>
										</aside>
								</div>
							</div>
							<div id="tab-custom-fileds" class="tab-pane fade">
								<?php 
									cs_dynamic_custom_fields();
								?>	
							</div>
							<div id="tab1-packages" class="tab-pane fade">
								<h2><?php _e('Packages','LMS');?></h2>
							</div>
							
							<div id="tab-transactions" class="tab-pane fade">
								<h2><?php _e('Transactions','LMS');?></h2>
							</div>
							
							<div id="tab-design-settings" class="tab-pane fade">
								<h2><?php _e('Design Settings','LMS');?></h2>
								<?php  echo cs_dynamic_design_settings(); ?>
							</div>
							
							<div id="tab-import-xport" class="tab-pane fade">
								<h2><?php _e('Import/Export','LMS');?></h2>
							</div>
							
							
							<?php
								submit_button( __( 'Publish','LMS' ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) );
							?>
						 </div>
					</div>
					
					<?php 
				
	}
	// Save Post Data
	function cs_dynamic_custom_post_type_save_postdata(){
		global $post;
		if (isset($_POST['dcpt-hidd']) && $_POST['dcpt-hidd'] == 'true') {
			if(isset($_REQUEST['dcpt'])){
				foreach ( $_REQUEST['dcpt'] as $keys=>$values) {
					$cs_value = get_post_meta($post->ID, $keys, true);
					update_post_meta($post->ID, $keys, $values, $cs_value);
			
				}
			}
			if(isset($_REQUEST['dcpt_options'])){
				foreach ( $_REQUEST['dcpt_options'] as $keys=>$values) {
					update_post_meta($post->ID, $keys, $values);
				}
			}
			$sxe = new SimpleXMLElement("<cs_dynamic_post_design></cs_dynamic_post_design>");
			//$design = $sxe->addChild('designs_settings');
			if(isset($_REQUEST['design_title_array']) && !empty($_REQUEST['design_title_array'])){
				$design_counter = 0;
				foreach ( $_POST['design_title_array'] as $type ){
					$design_list = $sxe->addChild('designs');
					$design_list->addChild('design_title', htmlspecialchars($_POST['design_title_array'][$design_counter]) );
					$design_list->addChild('design_value', htmlspecialchars($_POST['design_value_array'][$design_counter]) );
					$design_list->addChild('design_section_title', htmlspecialchars($_POST['design_section_title_array'][$design_counter]) );
					$design_list->addChild('design_post_listing_type', htmlspecialchars($_POST['design_post_listing_type_array'][$design_counter]) );
					$design_list->addChild('design_post_categories', htmlspecialchars($_POST['design_post_categories_array'][$design_counter]) );
					$design_list->addChild('design_excerpt_length', htmlspecialchars($_POST['design_excerpt_length_array'][$design_counter]) );
					$design_list->addChild('design_default_excerpt_length', htmlspecialchars($_POST['design_default_excerpt_length_array'][$design_counter]) );
					$design_list->addChild('design_show_time', htmlspecialchars($_POST['design_show_time_array'][$design_counter]) );
					$design_list->addChild('design_post_categories', htmlspecialchars($_POST['design_post_categories_array'][$design_counter]) );
					$design_list->addChild('design_excerpt_length', htmlspecialchars($_POST['design_excerpt_length_array'][$design_counter]) );
					$design_list->addChild('design_default_excerpt_length', htmlspecialchars($_POST['design_default_excerpt_length_array'][$design_counter]) );
					$design_list->addChild('design_show_time', htmlspecialchars($_POST['design_show_time_array'][$design_counter]) );
					$design_list->addChild('design_filterable', htmlspecialchars($_POST['design_filterable_array'][$design_counter]) );
					$design_list->addChild('design_post_per_page', htmlspecialchars($_POST['design_post_per_page_array'][$design_counter]) );
					$design_list->addChild('design_pagination', htmlspecialchars($_POST['design_pagination_array'][$design_counter]) );
					$design_counter++;
				}
			}
			update_post_meta( $post->ID, 'dcpt_design_settings', $sxe->asXML() );
			if(isset($_REQUEST['design_settings_html'])){
				foreach ( $_REQUEST['design_settings_html'] as $keys=>$values) {
					$html_values = htmlentities($values);
					update_option($keys,$html_values);
				}
			}
		}
	}

// Post Meta Fields
	function cs_post_meta_dynamic_fields($post_id, $key, $param, $cs_value = ''){
		global $post,$cs_xmlObject;
		if(!isset($cs_value) || $cs_value == ''){
			$cs_value = $param['default'];
		}
		$backend_title = get_post_meta($post_id, $param['backend'], true);
		if(empty($backend_title))
			$backend_title = $param['title'];
		$html = '<tr>';
		$html .= '<td>' . $backend_title . ':</td>';
		switch( $param['type'] )
		{
			case 'text' :
				// prepare
				$output = '<td>';
				$output .= '<input type="text" class="cs-form-text cs-input ' . $param['class'] . '" name="dcpt[' . $key . ']" id="' . $key . '" value="' . $cs_value . '" />' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>' . "\n";
				// append
				$html .= $output;
				break;

			case 'textarea' :

				// prepare
				$output = '<td>';
				$output .= '<textarea rows="10" cols="30" name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-textarea cs-input">' . $cs_value . '</textarea>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'select' :

				// prepare
				$output = '<td>';
				$output .= '<select name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-select cs-input">' . "\n";

				foreach( $param['options'] as $value => $option )
				{
					$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
				}

				$output .= '</select>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>' . "\n";
				// append
				$html .= $output;
				break;

			case 'checkbox' :
				// prepare
				$checked  = '';
				if($cs_value == 'on'){$checked = 'checked="checked"';}
				$output = '<td><ul class="form-elements noborder">	';
				$output .= '<li class="to-field"><label class="pbwp-checkbox"><input type="checkbox"  value="on" name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-checkbox cs-input"' .$checked. '><span class="pbwp-box"></span></label>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></li></ul></td>';

				$html .= $output;

				break;

			default :
				break;
		}
		$html .= '</tr>';	
		return $html;
	}
	
	// Build hmtl Fields
	function cs_create_input_fields($key, $param) {
		global $post;
		$cs_value = get_post_meta($post->ID, $key, true);
		$html = '<tr>';
		$html .= '<td>' . $param['title']. ':</td>';
		switch( $param['type'] )
		{
			case 'text' :

				// prepare
				$output = '<td>';
				$output .= '<input type="text" class="cs-form-text cs-input ' . $param['class'] . '" name="dcpt[' . $key . ']" id="' . $key . '" value="' . $cs_value . '" />' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'textarea' :

				// prepare
				$output = '<td>';
				$output .= '<textarea rows="10" cols="30" name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-textarea cs-input">' . $cs_value . '</textarea>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'select' :

				// prepare
				$output = '<td>';
				$output .= '<select name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-select cs-input">' . "\n";

				foreach( $param['options'] as $value => $option )
				{
					$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
				}

				$output .= '</select>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'checkbox' :

				// prepare
				$checked  = '';
				if($cs_value == 'on'){$checked = 'checked="checked"';}
				$output = '<td><ul class="form-elements noborder">	';
				$output .= '<li class="to-field">
					<label class="pbwp-checkbox"><input type="checkbox"  value="on" name="dcpt[' . $key . ']" id="' . $key . '" class="cs-form-checkbox cs-input"' .$checked. '><span class="pbwp-box"></span></label>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['desc'] . '</span></li></ul></td>';
				$html .= $output;

				break;

			default :
				break;
		}
		$html .= '</tr>';

		return $html;
	}
	
	
