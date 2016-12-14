<?php
// Create page option Fields
if ( ! function_exists( 'cs_create_option_fields' ) ) {
	function cs_create_option_fields($key, $param) {
		global $post;
		$cs_value = $param['title'] ;
		
		$cs_meta_value = get_post_meta($post->ID, $key, true);
		if(isset($cs_meta_value) && $cs_meta_value <> ''){
			$cs_value = $cs_meta_value;
		}
		
		$html = '';
	//	$html .= '<td>' . $param['title']. ':</td>';
		switch( $param['type'] )
		{
			case 'text' :
				// prepare
				$output = '<td>';
				$output .= '<input type="text" class="cs-form-text cs-input " name="dcpt_options[' . $key . ']" id="' . $key . '" value="' . $cs_value . '" />' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>' . "\n";
				// append
				$html .= $output;
				break;
			case 'textarea' :
				// prepare
				$output = '<td>';
				$output .= '<textarea rows="10" cols="30" name="dcpt_options[' . $key . ']" id="' . $key . '" class="cs-form-textarea cs-input">' . $cs_value . '</textarea>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'select' :

				// prepare
				$output = '<td>';
				$output .= '<select name="dcpt_options[' . $key . ']" id="' . $key . '" class="cs-form-select cs-input">' . "\n";

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
				//cs_post_social_sharing
				$cs_value = '';
				$checked  = '';
			
				$cs_value = get_post_meta($post->ID, $key, true);
				if($cs_value == 'on'){$checked = 'checked="checked"';}
				$output = '<td>	';
				$output .= '<input type="hidden" name="dcpt_options[' . $key . ']" value="" />';
				$output .= '<label class="pbwp-checkbox"><input type="checkbox" value="on" name="dcpt_options[' . $key . ']" id="' . $key . '" class="cs-form-checkbox cs-input"' .$checked. '><span class="pbwp-box"></span></label>' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span></td>';

				$html .= $output;

				break;

			default :
				break;
		}

		return $html;
	}
}
// Dynamic post options array
if ( ! function_exists( 'cs_dynamic_custom_post_options_array' ) ) {
	function cs_dynamic_custom_post_options_array(){
		$dynamic_post_options_meta['meta'] = array(
		'title' =>__('Meta Options', 'LMS'),
		'id' => 'dctp-meta-option',
		'notes' =>__('Meta Options', 'LMS'),
		'params' => array(
			'social_shareing' => array(
				'title' => 'Social Sharing',
				'cs_post_social_sharing' => array(
					'name' => 'cs_post_social_sharing',
					'type' => 'checkbox',
					'title' => 'Social Sharing',
					'description' => '',
				),
				'cs_post_social_share_input' => array(
					'name' => 'cs_post_social_share_input',
					'type' => 'text',
					'title' => 'Social Sharing',
					'description' => '',
				),
				'cs_post_social_share_forntend_input' => array(
					'name' => 'cs_post_social_share_forntend_input',
					'type' => 'text',
					'title' => 'Social Sharing',
					'description' => '',
				),
			),
			'author_info' => array(
				'title' => 'Author Info',
				'cs_post_author_info_show' => array(
					'name' => 'cs_post_author_info_show',
					'type' => 'checkbox',
					'title' => 'Author Info',
					'description' => '',
				),
				'cs_post_author_info_show_input' => array(
					'name' => 'cs_post_author_info_show_input',
					'type' => 'text',
					'title' => 'Author Info',
					'description' => '',
				),
				'cs_post_author_info_show_frontend_input' => array(
					'name' => 'cs_post_author_info_show_frontend_input',
					'type' => 'text',
					'title' => 'Author Info',
					'description' => '',
				),
			),
			'post_tags' => array(
				'title' => 'Tags',
				'cs_post_tags_show' => array(
					'name' => 'cs_post_tags_show',
					'type' => 'checkbox',
					'title' => 'Tags',
					'description' => '',
				),
				'cs_post_tags_show_input' => array(
					'name' => 'cs_post_tags_show_input',
					'type' => 'text',
					'title' => 'Tags',
					'description' => '',
				),
				'cs_post_tags_show_frontend_input' => array(
					'name' => 'cs_post_tags_show_frontend_input',
					'type' => 'text',
					'title' => 'Tags',
					'description' => '',
				),
			),
			'related_post' => array(
				'title' => 'Related Post',
				'cs_related_post' => array(
					'name' => 'cs_related_post',
					'type' => 'checkbox',
					'title' => 'Related Post',
					'description' => '',
				),
				'cs_related_post_input' => array(
					'name' => 'cs_related_post_input',
					'type' => 'text',
					'title' => 'Related Post',
					'description' => '',
				),
				'cs_related_post_frontend_input' => array(
					'name' => 'cs_related_post_frontend_input',
					'type' => 'text',
					'title' => 'Related Post',
					'description' => '',
				),
			),
			'post_pagination' => array(
				'title' => 'Show Pagination',
				'cs_post_pagination_show' => array(
					'name' => 'cs_post_pagination_show',
					'type' => 'checkbox',
					'title' => 'Show Pagination',
					'description' => '',
				),
				'cs_post_pagination_input' => array(
					'name' => 'cs_post_pagination_input',
					'type' => 'text',
					'title' => 'Show Pagination',
					'description' => '',
				),
				'cs_post_pagination_frontend_input' => array(
					'name' => 'cs_post_pagination_frontend_input',
					'type' => 'text',
					'title' => 'Show Pagination',
					'description' => '',
				),
			),
			'post_sidebar' => array(
				'title' => 'Choose Sidebar',
				'cs_post_sidebar_show' => array(
					'name' => 'cs_post_sidebar_show',
					'type' => 'checkbox',
					'title' => 'Choose Sidebar',
					'description' => '',
				),
				'cs_post_sidebar_input' => array(
					'name' => 'cs_post_sidebar_input',
					'type' => 'text',
					'title' => 'Choose Sidebar',
					'description' => '',
				),
				'cs_post_sidebar_frontend_input' => array(
					'name' => 'cs_post_sidebar_frontend_input',
					'type' => 'text',
					'title' => 'Choose Sidebar',
					'description' => '',
				),
			),
			
			'post_faqs' => array(
				'title' => 'FAQS',
				'cs_post_faqs_option' => array(
					'name' => 'cs_post_faqs_option',
					'type' => 'checkbox',
					'title' => 'FAQS',
					'description' => '',
				),
				'cs_post_faqs_input' => array(
					'name' => 'cs_post_faqs_input',
					'type' => 'text',
					'title' => 'FAQS',
					'description' => '',
				),
				'cs_post_faqs_frontend_input' => array(
					'name' => 'cs_post_faqs_frontend_input',
					'type' => 'text',
					'title' => 'FAQS',
					'description' => '',
				),
			),
			'post_price' => array(
				'title' => 'Price/Saleprice',
				'cs_post_price_saleprice_option' => array(
					'name' => 'cs_post_price_saleprice_option',
					'type' => 'checkbox',
					'title' => 'Price/Saleprice',
					'description' => '',
				),
				'cs_post_price_saleprice_input' => array(
					'name' => 'cs_post_price_saleprice_input',
					'type' => 'text',
					'title' => 'Price/Saleprice Settings',
					'description' => '',
				),
				'cs_post_price_saleprice_frontend_input' => array(
					'name' => 'cs_post_price_saleprice_frontend_input',
					'type' => 'text',
					'title' => 'Price/Saleprice',
					'description' => '',
				),
			),
			'post_memebers' => array(
				'title' => 'Members',
				'cs_post_memebers_option' => array(
					'name' => 'cs_post_memebers_option',
					'type' => 'checkbox',
					'title' => 'Members',
					'description' => '',
				),
				'cs_post_memebers_input' => array(
					'name' => 'cs_post_memebers_input',
					'type' => 'text',
					'title' => 'Members Settings',
					'description' => '',
				),
				'cs_post_memebers_frontend_input' => array(
					'name' => 'cs_post_memebers_frontend_input',
					'type' => 'text',
					'title' => 'Member',
					'description' => '',
				),
			),
			'post_location' => array(
				'title' => 'Location',
				'cs_post_location_option' => array(
					'name' => 'cs_post_location_option',
					'type' => 'checkbox',
					'title' => 'Location',
					'description' => '',
				),
				'cs_post_location_input' => array(
					'name' => 'cs_post_location_input',
					'type' => 'text',
					'title' => 'Location Settings',
					'description' => '',
				),
				'cs_post_location_frontend_input' => array(
					'name' => 'cs_post_location_frontend_input',
					'type' => 'text',
					'title' => 'Location',
					'description' => '',
				),
			),
			'post_event' => array(
				'title' => 'Events',
				'cs_post_event_option' => array(
					'name' => 'cs_post_event_option',
					'type' => 'checkbox',
					'title' => 'Event',
					'description' => '',
				),
				'cs_post_event_input' => array(
					'name' => 'cs_post_event_input',
					'type' => 'text',
					'title' => 'Event Settings',
					'description' => '',
				),
				'cs_post_location_frontend_input' => array(
					'name' => 'cs_post_event_frontend_input',
					'type' => 'text',
					'title' => 'Events',
					'description' => '',
				),
			),
			'post_image' => array(
				'title' => 'Media attachment ',
				'cs_post_image_option' => array(
					'name' => 'cs_post_image_option',
					'type' => 'checkbox',
					'title' => 'Media attachment ',
					'description' => '',
				),
				'cs_post_image_input' => array(
					'name' => 'cs_post_image_input',
					'type' => 'text',
					'title' => 'Media attachment ',
					'description' => '',
				),
				'cs_post_image_frontend_input' => array(
					'name' => 'cs_post_image_frontend_input',
					'type' => 'text',
					'title' => 'Media attachment ',
					'description' => '',
				),
			),
			'post_couponcode' => array(	
				'title' => 'Coupon Code',
				'cs_post_couponcode_option' => array(
					'name' => 'cs_post_couponcode_option',
					'type' => 'checkbox',
					'title' => 'Coupon Code',
					'description' => '',
				),
				'cs_post_couponcode_input' => array(
					'name' => 'cs_post_couponcode_input',
					'type' => 'text',
					'title' => 'Coupon Code',
					'description' => '',
				),
				'cs_post_couponcode_frontend_input' => array(
					'name' => 'cs_post_couponcode_frontend_input',
					'type' => 'text',
					'title' => 'Coupon Code',
					'description' => '',
				),
			),
			'post_shortlist' => array(	
				'title' => 'Shortlist',
				'cs_post_shortlist_option' => array(
					'name' => 'cs_post_shortlist_option',
					'type' => 'checkbox',
					'title' => 'Shortlist',
					'description' => '',
				),
				'cs_post_shortlist_input' => array(
					'name' => 'cs_post_shortlist_input',
					'type' => 'text',
					'title' => 'shortlist',
					'description' => '',
				),
				'cs_post_shortlist_frontend_input' => array(
					'name' => 'cs_post_shortlist_frontend_input',
					'type' => 'text',
					'title' => 'shortlist',
					'description' => '',
				),
			),
			'post_adminapprovals' => array(		
				'title' => 'Admin Approvals',
				'cs_post_adminapprovals_option' => array(
					'name' => 'cs_post_adminapprovals_option',
					'type' => 'checkbox',
					'title' => 'Admin Approvals',
					'description' => '',
				),
				'cs_post_adminapprovals_input' => array(
					'name' => 'cs_post_adminapprovals_input',
					'type' => 'text',
					'title' => 'Admin Approvals',
					'description' => '',
				),
				'cs_post_adminapprovals_frontend_input' => array(
					'name' => 'cs_post_adminapprovals_frontend_input',
					'type' => 'text',
					'title' => 'Admin Approvals',
					'description' => '',
				),
			),
			'post_subheader' => array(		
				'title' => 'Subheader',
				'cs_post_subheader_option' => array(
					'name' => 'cs_post_subheader_option',
					'type' => 'checkbox',
					'title' => 'Subheader',
					'description' => '',
				),
				'cs_post_subheader_input' => array(
					'name' => 'cs_post_subheader_input',
					'type' => 'text',
					'title' => 'Subheader',
					'description' => '',
				),
				'cs_post_subheader_frontend_input' => array(
					'name' => 'cs_post_subheader_frontend_input',
					'type' => 'text',
					'title' => 'Subheader',
					'description' => '',
				),
			),
			'post_seosettings' => array(		
				'title' => 'Seo Options',
				'cs_post_seosettings_option' => array(
					'name' => 'cs_post_seosettings_option',
					'type' => 'checkbox',
					'title' => 'Seo Options',
					'description' => '',
				),
				'cs_post_seosettings_input' => array(
					'name' => 'cs_post_seosettings_input',
					'type' => 'text',
					'title' => 'Seo Options',
					'description' => '',
				),
				'cs_post_seosettings_frontend_input' => array(
					'name' => 'cs_post_seosettings_frontend_input',
					'type' => 'text',
					'title' => 'Seo Options ',
					'description' => '',
				),
			),
			'post_projects' => array(		
				'title' => 'Projects',
				'cs_post_projects_option' => array(
					'name' => 'cs_post_projects_option',
					'type' => 'checkbox',
					'title' => 'Projects',
					'description' => '',
				),
				'cs_post_projects_input' => array(
					'name' => 'cs_post_projects_input',
					'type' => 'text',
					'title' => 'Projects',
					'description' => '',
				),
				'cs_post_projects_frontend_input' => array(
					'name' => 'cs_post_projects_frontend_input',
					'type' => 'text',
					'title' => 'Projects ',
					'description' => '',
				),
			),
			'post_lms_projects' => array(		
				'title' => 'Lms Projects',
				'cs_post_lms_projects_option' => array(
					'name' => 'cs_post_lms_projects_option',
					'type' => 'checkbox',
					'title' => 'Projects',
					'description' => '',
				),
				'cs_post_lms_projects_input' => array(
					'name' => 'cs_post_lms_projects_input',
					'type' => 'text',
					'title' => 'Lms Projects',
					'description' => '',
				),
				'cs_post_projects_lms_frontend_input' => array(
					'name' => 'cs_post_lms_projects_frontend_input',
					'type' => 'text',
					'title' => 'Lms Projects ',
					'description' => '',
				),
			),

			'post_sermons' => array(		
				'title' => 'Sermons',
				'cs_post_sermons_option' => array(
					'name' => 'cs_post_sermons_option',
					'type' => 'checkbox',
					'title' => 'Sermons',
					'description' => '',
				),
				'cs_post_sermons_input' => array(
					'name' => 'cs_post_sermons_input',
					'type' => 'text',
					'title' => 'Sermons',
					'description' => '',
				),
				'cs_post_sermons_frontend_input' => array(
					'name' => 'cs_post_sermons_frontend_input',
					'type' => 'text',
					'title' => 'Sermons ',
					'description' => '',
				),
			),
				
		)
		);
		
		return $dynamic_post_options_meta['meta'];
	}
}
// Dynamic post type array
if ( ! function_exists( 'cs_post_type_array' ) ) {
	function cs_post_type_array(){
		return array(
									'main_settings' => array('title'=>'Main Settings', 'description'=>'',
											'cs_public' => array(
												'name' => 'cs_public',
												'type' => 'checkbox',
												'title' => 'Public',
												'description' => '',
											),
											'cs_publicly_queryable' => array(
												'name' => 'cs_publicly_queryable',
												'type' => 'checkbox',
												'title' => 'Publicly Queryable',
												'description' => '',
											),
											'cs_show_ui' => array(
												'name' => 'cs_show_ui',
												'type' => 'checkbox',
												'title' => 'Show UI',
												'description' => '',
											),
											'cs_show_in_menu' => array(
												'name' => 'cs_show_in_menu',
												'type' => 'checkbox',
												'title' => 'Show in Menu',
												'description' => '',
											),
											'cs_query_var' => array(
												'name' => 'cs_query_var',
												'type' => 'checkbox',
												'title' => 'Query Vars',
												'description' => '',
											),
											'cs_rewrite' => array(
												'name' => 'cs_rewrite',
												'type' => 'checkbox',
												'title' => 'Rewrite',
												'description' => '',
											),
											'cs_has_archive' => array(
												'name' => 'cs_has_archive',
												'type' => 'checkbox',
												'title' => 'Has Archive',
												'description' => '',
											),
											'cs_hierarchical' => array(
												'name' => 'cs_hierarchical',
												'type' => 'checkbox',
												'title' => 'Heirarchical',
												'description' => '',
											)
								),
								'selectoptions' => array('title'=>'', 'description'=>'',
										'cs_capability_type' => array(
											'name' => 'cs_capability_type',
											'type' => 'select',
											'title' => 'Capability Type',
											'description' => '',
											'options' => array(
												'post' => 'Post',
												'page' => 'Page'
											 ),
										),
										'cs_menu_position' => array(
											'name' => 'cs_menu_position',
											'type' => 'select',
											'title' => 'Menu Position',
											'description' => '',
											'options' => array(
												'5' => 'below Posts',
												'10' => 'below Media',
												'15' => 'below Links',
												'20' => 'below Pages',
												'25' => 'below comments',
												'60' => 'below first separator',
												'65' => 'below Plugins',
												'70' => 'below Users',
												'75' => 'below Tools',
												'80' => 'below Settings',
												'100' => 'below second separator'
											 ),
										)
									),
								'supports' => array('title'=>'Supports', 'description'=>'',
								
											'cs_s_title' => array(
												'name' => 'cs_s_title',
												'type' => 'checkbox',
												'title' => 'Title',
												'description' => '',
											),
											'cs_s_editor' => array(
												'name' => 'cs_s_editor',
												'type' => 'checkbox',
												'title' => 'Editor',
												'description' => '',
											),
											'cs_s_author' => array(
												'name' => 'cs_s_author',
												'type' => 'checkbox',
												'title' => 'Author',
												'description' => '',
											),
											'cs_s_thumbnail' => array(
												'name' => 'cs_s_thumbnail',
												'type' => 'checkbox',
												'title' => 'Thumbnails',
												'description' => '',
											),
											'cs_s_comments' => array(
												'name' => 'cs_s_comments',
												'type' => 'checkbox',
												'title' => 'Comments',
												'description' => '',
											)
									),
							'labels' => array('title'=>'Labels:', 'description'=>'',
											'cs_general_name' => array(
												'name' => 'cs_general_name',
												'type' => 'text',
												'title' => 'General Name',
												'description' => '',
											),
											'cs_singular_name' => array(
												'name' => 'cs_singular_name',
												'type' => 'text',
												'title' => 'Singular Name',
												'description' => '',
											),
											'cs_general_name' => array(
												'name' => 'cs_general_name',
												'type' => 'text',
												'title' => 'General Name',
												'description' => '',
											),
											'cs_add_new_item' => array(
												'name' => 'cs_add_new_item',
												'type' => 'text',
												'title' => 'Add New Item',
												'description' => '',
											),
											'cs_all_items' => array(
												'name' => 'cs_all_items',
												'type' => 'text',
												'title' => 'All Item',
												'description' => '',
											),
											'cs_view_item' => array(
												'name' => 'cs_view_item',
												'type' => 'text',
												'title' => 'View Item',
												'description' => '',
											),
											'cs_search_items' => array(
												'name' => 'cs_search_items',
												'type' => 'text',
												'title' => 'Search Item',
												'description' => '',
											),
											'cs_not_found' => array(
												'name' => 'cs_not_found',
												'type' => 'text',
												'title' => 'Not Found',
												'description' => '',
											),
											'cs_not_found_in_trash' => array(
												'name' => 'cs_not_found_in_trash',
												'type' => 'text',
												'title' => 'Nothing found in Trash',
												'description' => '',
											),
											'cs_parent_item_colon' => array(
												'name' => 'cs_parent_item_colon',
												'type' => 'text',
												'title' => 'Parent Item Colon',
												'description' => 'Parent Item Colon',
											)
								),
							'categories' => array('title'=>'Category Labels:', 'description'=>'',
											'cs_categories_name' => array(
												'name' => 'cs_categories_name',
												'type' => 'text',
												'title' => 'Categories Name',
												'description' => '',
											),
											'cs_category_menu_name' => array(
												'name' => 'cs_category_menu_name',
												'type' => 'text',
												'title' => 'Category Menu Name',
												'description' => '',
											)
								),
							'tags' => array('title'=>'Tags Labels:', 'description'=>'',
											'cs_tags_name' => array(
												'name' => 'cs_tags_name',
												'type' => 'text',
												'title' => 'Tags Name',
												'description' => '',
											),
											'cs_tags_menu_name' => array(
												'name' => 'cs_tags_menu_name',
												'type' => 'text',
												'title' => 'Menu Name',
												'description' => '',
											)
								)
							);	
	}
}
// Dynamic custom post options array
if ( ! function_exists( 'cs_dynamic_custom_post_options' ) ) {
	function cs_dynamic_custom_post_options(){
		global $post;
	
		$html = '';
		$meta_options = cs_dynamic_custom_post_options_array();
		if(is_array($meta_options)){
			$html .= '<div class="cs-sortable">';
			$html .= '<table id="clone-' . $meta_options['id'] . '" class="cs-clone-template">
				<thead>
					<tr>
						<th></th>
						<th>'.__('Actions','LMS').'</th>
						<th>'.__('Backend Title','LMS').'</th>
						<th class="hidden-xs">'.__('Frontend Title','LMS').'</th>
					</tr>
				</thead>
			<tbody>';
			foreach( $meta_options['params'] as $table_key=>$tablerows ) {
				$html .= '<tr>';
				$html .= '<td>' . $tablerows['title']. ':</td>';
				foreach( $tablerows as $key=>$param ) {
					if(is_array($param )){
						$html .= cs_create_option_fields($key, $param);
					}
				}
				$html .= '</tr>';
			}
			$html .= '</tbody></table></div>';
		}
		return $html;	
	}
}