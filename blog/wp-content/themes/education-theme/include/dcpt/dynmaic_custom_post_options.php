<?php
global $cs_theme_options,$post;

$cs_query = new WP_Query(array('post_type' => array('dcpt')));
while ($cs_query->have_posts()) : $cs_query->the_post();
	global $post;
		$cs_public = get_post_meta($post->ID, 'cs_public', true);
		if ($cs_public == "on") {
			$cs_public = true;
		}
		else {
			$cs_public = false;
		}
		$cs_publicly_queryable = get_post_meta($post->ID, 'cs_publicly_queryable', true);
		if ($cs_publicly_queryable == "on") {
			$cs_publicly_queryable = true;
		}
		else {
			$cs_publicly_queryable = false;
		}
		$cs_show_ui = get_post_meta($post->ID, 'cs_show_ui', true);
		if ($cs_show_ui == "on") {
			$cs_show_ui = true;
		}
		else {
			$cs_show_ui = false;
		}
		$cs_show_in_menu = get_post_meta($post->ID, 'cs_show_in_menu', true); //
		if ($cs_show_in_menu == "on") {
			$cs_show_in_menu = true;
		}
		else {
			$cs_show_in_menu = false;
		}
		$cs_query_var = get_post_meta($post->ID, 'cs_query_var', true); //
		if ($cs_query_var == "on") {
			$cs_query_var = true;
		}
		else {
			$cs_query_var = false;
		}
		$cs_rewrite = get_post_meta($post->ID, 'cs_rewrite', true); //
		if ($cs_rewrite == "on") {
			$cs_rewrite = true;
		}
		else {
			$cs_rewrite = false;
		}
		$cs_has_archive = get_post_meta($post->ID, 'cs_has_archive', true); //
		if ($cs_has_archive == "on") {
			$cs_has_archive = true;
		}
		else {
			$cs_has_archive = false;
		}
		$cs_hierarchical = get_post_meta($post->ID, 'cs_hierarchical', true);
		if ($cs_hierarchical == "on") {
			$cs_hierarchical = true;
		}
		else {
			$cs_hierarchical = false;
		}
		$cs_capability_type = get_post_meta($post->ID, 'cs_capability_type', true);
		$cs_menu_position = get_post_meta($post->ID, 'cs_menu_position', true);
		$cs_s = array();
		$cs_s_title = get_post_meta($post->ID, 'cs_s_title', true);
		if ($cs_s_title == "on") {
			$cs_s[] = 'title';
		}
		$cs_s_editor = get_post_meta($post->ID, 'cs_s_editor', true);
		if ($cs_s_editor == "on") {
			$cs_s[] = 'editor';
		}
		$cs_s_author = get_post_meta($post->ID, 'cs_s_author', true);
		if ($cs_s_author == "on") {
			$cs_s[] = 'author';
		}
		$cs_s_thumbnail = get_post_meta($post->ID, 'cs_s_thumbnail', true);
		if ($cs_s_thumbnail == "on") {
			$cs_s[] = 'thumbnail';
		}
		$cs_s_excerpt = get_post_meta($post->ID, 'cs_s_excerpt', true);
		if ($cs_s_excerpt == "on") {
			array_push($cs_s, 'excerpt');
		}
		$cs_s_comments = get_post_meta($post->ID, 'cs_s_comments', true);
		if ($cs_s_comments == "on") {
			array_push($cs_s, 'comments');
		}
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
		
		$cs_categories_name = get_post_meta($post->ID, 'cs_categories_name', true);
		$cs_category_menu_name = get_post_meta($post->ID, 'cs_category_menu_name', true);
		$cs_tags_menu_name = get_post_meta($post->ID, 'cs_tags_menu_name', true);
		$cs_tags_name = get_post_meta($post->ID, 'cs_tags_name', true);
		
		if(empty($cs_general_name)) $cs_general_name = get_the_title();
		if(empty($cs_singular_name)) $cs_singular_name = get_the_title();
		if(empty($cs_add_new_item)) $cs_add_new_item = 'Add New '.get_the_title();
		if(empty($cs_all_items)) $cs_all_items = 'All '.get_the_title();
		if(empty($cs_view_item)) $cs_view_item = 'View '.get_the_title();
		if(empty($cs_search_items)) $cs_search_items = 'Search '.get_the_title();
		if(empty($cs_not_found)) $cs_not_found = 'Not Found ';

		$labels = array(
        'name' => $cs_general_name,
        'singular_name' => $cs_singular_name,
        'add_new' => $cs_add_new_item,
        'add_new_item' => $cs_add_new_item,
        'edit_item' => $cs_edit_item,
        'new_item' => $cs_new_item,
        'all_items' => $cs_all_items,
        'view_item' => $cs_view_item,
        'search_items' => $cs_search_items,
        'not_found' => $cs_not_found,
        'not_found_in_trash' => $cs_not_found_in_trash,
        'parent_item_colon' => '',
        'menu_name' => $cs_general_name
	);
	//$cs_hierarchical
    $args = array(
        'labels' => $labels,
        'public' => $cs_public,
        'publicly_queryable' => $cs_publicly_queryable,
        'show_ui' => $cs_show_ui,
        'show_in_menu' => $cs_show_in_menu,
        'query_var' => $cs_query_var,
        'rewrite' => $cs_rewrite,
        'capability_type' => $cs_capability_type,
        'has_archive' => $cs_has_archive,
        'hierarchical' => true,
        'menu_position' => $cs_menu_position,
        'supports' => $cs_s
    );
	
	
	
	
	
	
	
	
	
	
	
	
	
    register_post_type($post->post_name, $args);
	// adding cat start
	if(isset($cs_category_menu_name) && $cs_category_menu_name <> ''){
		  $labels = array(
			'name' => $cs_category_menu_name,
			'search_items' => 'Search '.$cs_category_menu_name,
			'edit_item' => 'Edit '.$cs_category_menu_name,
			'update_item' => 'Update '.$cs_category_menu_name,
			'add_new_item' => 'Add New '.$cs_category_menu_name,
			'menu_name' => $cs_category_menu_name,
		  ); 	
		 $custom_post = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => strtolower($cs_categories_name) ),
		  );
		  register_taxonomy(strtolower($cs_categories_name),$post->post_name, $custom_post);
	}
	if(isset($cs_tags_menu_name) && $cs_tags_menu_name <> ''){
		  $labels = array(
			'name' => $cs_tags_menu_name,
			'singular_name' => $cs_tags_menu_name,
			'search_items' => 'Search '.$cs_tags_menu_name,
			'popular_items' => 'Popular '.$cs_tags_menu_name,
			'all_items' => 'All '.$cs_tags_menu_name,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => 'Edit '.$cs_tags_menu_name, 
			'update_item' => 'Update '.$cs_tags_menu_name,
			'add_new_item' => 'Add New '.$cs_tags_menu_name,
			'new_item_name' => 'New '.$cs_tags_menu_name.' Name',
			'separate_items_with_commas' => 'Separate '.$cs_tags_menu_name.' with commas',
			'add_or_remove_items' => 'Add or remove '.$cs_tags_menu_name,
			'choose_from_most_used' => 'Choose from the most used '.$cs_tags_menu_name,
			'menu_name' => $cs_tags_menu_name,
		  ); 
		  register_taxonomy(strtolower($cs_tags_name),$post->post_name,array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => strtolower($cs_tags_name) ),
		  ));
	}
	// adding tag end
	$postname = '';
	if(isset($_GET['post_type']) && $_GET['post_type'] == 'dcpt'){
		$postname = 'dcpt';
	} else {
		$postname = $post->post_name;
	}
	if($postname <> 'dcpt'){
		add_action( 'add_meta_boxes', 'cs_meta_dynamic_post_adddd' );
	}
	
	
endwhile;
wp_reset_postdata();
wp_reset_query();
function get_page_id_by_slug($slug, $post_type){
	global $wpdb;
	//$id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = '".$slug."'AND post_type = '".$post_type."'"));
	return $id;
}
function cs_meta_dynamic_post_adddd($post){  
	global $dpost,$postid,$post,$wpdb,$cs_theme_options;
		$dcpt_post_type = '';
		$postname = get_post_type($post->ID);
		if(isset($postname) && $postname <> 'dcpt'){
			$argsss=array(
			  'name' => (string)$postname,
			  'post_type' => 'dcpt',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
 			$get_posts = get_posts($argsss);
			if($get_posts){
				$dcpt_id = (int)$get_posts[0]->ID;
				$dcpt_post_type = get_post_type($dcpt_id);
				if(isset($dcpt_post_type) && $dcpt_post_type <> ''){
					add_meta_box( 'cs_custom_meta_post', __('Meta Options','LMS'), 'cs_custom_meta_post', $postname, 'normal', 'high' ); 
				}
			}
		}
}

function cs_custom_meta_post( $post ) {
		global $postid,$cs_xmlObject,$cs_node,$cs_theme_options;
		$postname = get_post_type($post->ID);
		if(isset($postname) && $postname <> ''){
			$args=array(
			  'name' => (string)$postname,
			  'post_type' => 'dcpt',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
			$get_posts = get_posts($args);
			if($get_posts){
				$post_id = (int)$get_posts[0]->ID;
			}
		}
		$dynamic_post_options_meta['meta'] = array(
										'title' => __('Meta Options', 'LMS'),
										'id' => 'dctp-meta-option',
										'notes' => __('Meta Options', 'LMS'),
										'params' => array(
												'cs_post_social_sharing' => array(
													'name' => 'cs_post_social_sharing',
													'type' => 'checkbox',
													'title' =>__('Social Sharing', 'LMS'),
													'frontend' => 'cs_post_social_share_forntend_input',
													'backend' => 'cs_post_social_share_input',
													'description' =>__('Show Social Sharing', 'LMS'),
													'default' => '',
													
												),
												'cs_post_author_info_show' => array(
													'name' => 'cs_post_author_info_show',
													'type' => 'checkbox',
													'title' =>__('Author Info', 'LMS'),
													'frontend' => 'cs_post_author_info_show_frontend_input',
													'backend' => 'cs_post_author_info_show_input',
													'description' =>__('Show Author Info', 'LMS'),
													'default' => '',
												),
												'cs_post_tags_show' => array(
													'name' => 'cs_post_tags_show',
													'type' => 'checkbox',
													'title' => 'Tags',
													'frontend' => 'cs_post_tags_show_frontend_input',
													'backend' => 'cs_post_tags_show_input',
													'description' =>__('Show Tags', 'LMS'),
													'default' => '',
												),
												'cs_related_post' => array(
													'name' => 'cs_related_post',
													'type' => 'checkbox',
													'title' =>__('Related Post', 'LMS'),
													'frontend' => 'cs_related_post_frontend_input',
													'backend' => 'cs_related_post_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_pagination_show' => array(
													'name' => 'cs_post_pagination_show',
													'type' => 'checkbox',
													'title' =>__('Pagination', 'LMS'),
													'frontend' => 'cs_post_pagination_frontend_input',
													'backend' => 'cs_post_pagination_input',
													'description' =>__('Show Next Previous Post', 'LMS'),
													'default' => '',
												),
												
												'cs_post_price_saleprice_option' => array(
													'name' => 'cs_post_price_saleprice_option',
													'type' => 'checkbox',
													'title' => ' ',
													'frontend' => 'cs_post_price_saleprice_frontend_input',
													'backend' => 'cs_post_price_saleprice_input',
													'description' =>__('Show Sale/Price', 'LMS'),
													'default' => '',
												),
												
												/*
												'cs_post_faqs_option' => array(
													'name' => 'cs_post_faqs_option',
													'type' => 'checkbox',
													'title' => 'cs_post_faqs_input',
													'frontend' => 'cs_post_faqs_frontend_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_location_option' => array(
													'name' => 'cs_post_location_option',
													'type' => 'checkbox',
													'title' => 'cs_post_location_input',
													'frontend' => 'cs_post_location_frontend_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_image_option' => array(
													'name' => 'cs_post_image_option',
													'type' => 'checkbox',
													'title' => 'cs_post_image_input',
													'frontend' => 'cs_post_image_frontend_input',
													'description' => '',
													'default' => '',
												),*/
												'cs_post_couponcode_option' => array(
													'name' => 'cs_post_couponcode_option',
													'type' => 'checkbox',
													'title' => 'Coupon code',
													'frontend' => 'cs_post_couponcode_frontend_input',
													'backend' => 'cs_post_couponcode_input',
													'description' => 'Show Coupon code',
													'default' => '',
												),
												'cs_post_shortlist_option' => array(
													'name' => 'cs_post_shortlist_option',
													'type' => 'checkbox',
													'title' => 'Shortlist',
													'frontend' => 'cs_post_shortlist_frontend_input',
													'backend' => 'cs_post_shortlist_input',
													'description' => 'Shortlist',
													'default' => '',
												),
												'cs_post_adminapprovals_option' => array(
													'name' => 'cs_post_adminapprovals_option',
													'type' => 'checkbox',
													'title' => 'Admin Approvals',
													'frontend' => 'cs_post_adminapprovals_frontend_input',
													'backend' => 'cs_post_adminapprovals_input',
													'description' => 'Admin Approvals',
													'default' => '',
												),
										)
									);
		$dynamic_post_other_options['meta'] = array(
										'title' => __('Meta Options', 'LMS'),
										'id' => 'dctp-meta-option',
										'notes' => __('Meta Options', 'LMS'),
										'params' => array(
												'cs_post_faqs_option' => array(
													'name' => 'cs_post_faqs_option',
													'type' => 'checkbox',
													'title' => 'cs_post_faqs_input',
													'frontend' => 'cs_post_faqs_frontend_input',
													'backend' => 'cs_post_faqs_input',
													'description' => 'Show  Faqs',
													'default' => '',
												),
												
												'cs_post_location_option' => array(
													'name' => 'cs_post_location_option',
													'type' => 'checkbox',
													'title' => 'cs_post_location_input',
													'frontend' => 'cs_post_location_frontend_input',
													'backend' => 'cs_post_location_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_memebers_option' => array(
													'name' => 'cs_post_memebers_option',
													'type' => 'checkbox',
													'title' => 'Members',
													'frontend' => 'cs_post_memebers_frontend_input',
													'backend' => 'cs_post_memebers_input',
													'description' => '',
													'default' => '',
												),
												
												'cs_post_image_option' => array(
													'name' => 'cs_post_image_option',
													'type' => 'checkbox',
													'title' => 'cs_post_image_input',
													'frontend' => 'cs_post_image_frontend_input',
													'backend' => 'cs_post_image_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_event_option' => array(
													'name' => 'cs_post_event_option',
													'type' => 'checkbox',
													'title' => 'cs_post_event_input',
													'frontend' => 'cs_post_event_frontend_input',
													'backend' => 'cs_post_event_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_price_saleprice_option' => array(
													'name' => 'cs_post_price_saleprice_option',
													'type' => 'checkbox',
													'title' => 'cs_post_price_saleprice_frontend_input',
													'frontend' => 'cs_post_price_saleprice_frontend_input',
													'backend' => 'cs_post_price_saleprice_input',
													'description' => '',
													'default' => '',
												),
												'cs_post_couponcode_option' => array(
													'name' => 'cs_post_couponcode_option',
													'type' => 'checkbox',
													'title' => 'cs_post_couponcode_input',
													'frontend' => 'cs_post_couponcode_frontend_input',
													'backend' => 'cs_post_couponcode_input',
													'description' => 'Show Coupon Code',
													'default' => '',
												),
												'cs_post_sidebar_show' => array(
													'name' => 'cs_post_sidebar_show',
													'type' => 'checkbox',
													'title' => 'Choose Sidebar',
													'frontend' => 'cs_post_sidebar_frontend_input',
													'backend' => 'cs_post_sidebar_input',
													'description' => 'on',
													'default' => '',
												),
												'cs_post_subheader_option' => array(
													'name' => 'cs_post_subheader_option',
													'type' => 'checkbox',
													'title' => 'Sub Header',
													'frontend' => 'cs_post_subheader_frontend_input',
													'backend' => 'cs_post_subheader_input',
													'description' => 'on',
													'default' => '',
												),
												'cs_post_seosettings_option' => array(
													'name' => 'cs_post_seosettings_option',
													'type' => 'checkbox',
													'title' => 'SEO Options',
													'frontend' => 'cs_post_seosettings_frontend_input',
													'backend' => 'cs_post_seosettings_input',
													'description' => 'on',
													'default' => '',
												),
												'cs_post_projects_option' => array(
													'name' => 'cs_post_projects_option',
													'type' => 'checkbox',
													'title' => 'Projects',
													'frontend' => 'cs_post_projects_frontend_input',
													'backend' => 'cs_post_projects_input',
													'description' => 'on',
													'default' => '',
												),
												'cs_post_lms_projects_option' => array(
													'name' => 'cs_post_lms_projects_option',
													'type' => 'checkbox',
													'title' => 'LMS Projects',
													'frontend' => 'cs_post_lms_projects_frontend_input',
													'backend' => 'cs_post_lms_projects_input',
													'description' => 'on',
													'default' => '',
												),
												'cs_post_sermons_option' => array(
													'name' => 'cs_post_sermons_option',
													'type' => 'checkbox',
													'title' => 'Sermons Settings',
													'frontend' => 'cs_post_sermons_frontend_input',
													'backend' => 'cs_post_sermons_input',
													'description' => 'on',
													'default' => '',
												),
										)
									);							
		$post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
		global $cs_xmlObject;
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
		}
		$html = '';
		$html_data = '';
		foreach( $dynamic_post_options_meta as $key => $meta_options ) {
			$html .= '<div class="cs-sortable">';
			$html .= '<table id="clone-' . $meta_options['id'] . '" class="cs-clone-template"><tbody>';
			foreach( $meta_options['params'] as $key => $param ) {
				$meta_option_on = get_post_meta($post_id, $key, true);
				if($meta_option_on == 'on'){
					$$key = $meta_option_on;
					$db_meta_value = @$cs_xmlObject->$key;
					$html_data .= cs_post_meta_dynamic_fields($post_id, $key, $param, $db_meta_value);
				}
			}
			$html .= $html_data;
			$html .= '</tbody></table></div>';
		}
		foreach( $dynamic_post_other_options as $key => $meta_options ) {
			foreach( $meta_options['params'] as $key => $param ) {
 				$meta_option_on = get_post_meta($post_id, $key, true);
				if($meta_option_on == 'on'){
					$$key = $meta_option_on;
					$key_input = $param['backend'];
					$keyinputtitle = get_post_meta($post_id, $key_input, true);
					if(empty($keyinputtitle))
						$keyinputtitle = $param['title'];
					$$key_input = $keyinputtitle;
				}
			}
		}
		$cs_builtin_seo_fields =$cs_theme_options['cs_builtin_seo_fields'];
?>
        <div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
          <div class="option-sec" style="margin-bottom:0;">
            <div class="opt-conts">
              <div class="elementhidden">
                <div class="tabs vertical">
                  <nav class="admin-navigtion">
                    <ul id="myTab" class="nav nav-tabs">
                   	  <?php if((isset($cs_post_sidebar_show) && $cs_post_sidebar_show == 'on') || $html_data <> ''){?>
                      <li class="active"><a href="#tab-general-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-cog"></i> General</a></li>
                      <?php }?>
                      <?php if(isset($cs_post_subheader_option) && $cs_post_subheader_option == 'on'){?>
                      	<li><a href="#tab-subheader-options-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-indent"></i> <?php echo esc_attr($cs_post_subheader_input);?></a></li>
                      <?php }?>
                      <?php if($cs_builtin_seo_fields == 'on' && isset($cs_post_seosettings_option) && $cs_post_seosettings_option == 'on'){?>
                      	<li><a href="#tab-seo-advance-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-dribbble"></i>  <?php echo esc_attr($cs_post_seosettings_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_event_option) && $cs_post_event_option == 'on'){?>
                      	<li><a href="#tab-events-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-calendar"></i> <?php echo esc_attr($cs_post_event_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_projects_option) && $cs_post_projects_option == 'on'){?>
                      	<li><a href="#tab-projects-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-calendar"></i><?php echo esc_attr($cs_post_projects_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_lms_projects_option) && $cs_post_lms_projects_option == 'on'){?>
                      	<li><a href="#tab-lms-projects-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-calendar"></i><?php echo esc_attr($cs_post_lms_projects_input);?></a></li>
                      <?php }?>

                      <?php if(isset($cs_post_sermons_option) && $cs_post_sermons_option == 'on'){?>
                      	<li><a href="#tab-sermons-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-calendar"></i> <?php echo esc_attr($cs_post_sermons_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_location_option) && $cs_post_location_option == 'on'){?>
                     	 <li><a href="#tab-location-settings-<?php echo esc_attr($postname);?>" id="location-mytab" data-toggle="tab"><i class="fa fa-globe"></i><?php echo esc_attr($cs_post_location_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_couponcode_option) && $cs_post_couponcode_option == 'on'){?>
                      <li><a href="#tab-coupon-settings-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-money"></i><?php echo esc_attr($cs_post_couponcode_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_faqs_option) && $cs_post_faqs_option == 'on'){?>
                      <li><a href="#tab-faqs-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-question-circle"></i><?php echo esc_attr($cs_post_faqs_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_price_saleprice_option) && $cs_post_price_saleprice_option == 'on'){?>
                      <li><a href="#tab-saleprice-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-question-circle"></i> <?php echo esc_attr($cs_post_price_saleprice_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_image_option) && $cs_post_image_option == 'on'){?>
                      <li><a href="#tab-media-attachment-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-picture-o"></i><?php echo esc_attr($cs_post_image_input);?></a></li>
                      <?php }?>
                      <?php if(isset($cs_post_memebers_option) && $cs_post_memebers_option == 'on'){?>
                      	<li><a href="#tab-members-options-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-indent"></i> <?php echo esc_attr($cs_post_memebers_input);?></a></li>
                      <?php }?>
                      <?php 
						$custom_fields = '';
						$cs_dcpt_custom_fields = get_post_meta($post_id, "cs_dcpt_custom_fields", true);
						if ( $cs_dcpt_custom_fields <> "" ) {
							$cs_customfields_object = new SimpleXMLElement($cs_dcpt_custom_fields);
							if(isset($cs_customfields_object->custom_fields_elements) && $cs_customfields_object->custom_fields_elements == '1'){
								if(count($cs_customfields_object)>1){
						?>
						<li><a href="#tab-custom-fields-<?php echo esc_attr($postname);?>" data-toggle="tab"><i class="fa fa-sitemap"></i><?php _e('Custom Fields','LMS');?></a></li>
						<?php 
								}
							}
						}?>
                    </ul>
                  </nav>
                  <div class="tab-content">
                    <div id="tab-subheader-options-<?php echo esc_attr($postname);?>" class="tab-pane fade">
						<?php 
                        	cs_subheader_element();
						?>
                    </div>
                    <?php if($cs_builtin_seo_fields == 'on'){?>
                    <div id="tab-seo-advance-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php cs_seo_settitngs_element();?>
                    </div>
                    <?php }?>
                    <div id="tab-members-options-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
						  cs_dcpt_members('organizer');
					  ?>
                    </div>
                    <div id="tab-general-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade active in"> 
                   <?php 
				   			if($html_data <> ''){
				   				echo balanceTags($html);
							}
					  		if(isset($cs_post_sidebar_show) && $cs_post_sidebar_show == 'on'){
                            	cs_sidebar_layout_options();
							}
                        ?>
                    </div>
                    <?php if(isset($cs_post_event_option) && $cs_post_event_option == 'on'){?>
                    <div id="tab-events-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
                            global $cs_xmlObject;
                            cs_cusotm_post_event_fields();
                        ?>
                    </div>
                    <?php }?>
                    <?php if(isset($cs_post_location_option) && $cs_post_location_option == 'on'){?>
                        <div id="tab-location-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                          <?php 
						  		if ( function_exists( 'cs_location_fields' ) ) {
                               		cs_location_fields();
								}
                            ?>
                        </div>
                    <?php }?>
                    <?php if(isset($cs_post_projects_option) && $cs_post_projects_option == 'on'){?>
                        <div id="tab-projects-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                          <?php 
                                cs_projects_listing_section();
                            ?>
                        </div>
                    <?php }?>
                     <?php if(isset($cs_post_lms_projects_option) && $cs_post_lms_projects_option == 'on'){?>
                        <div id="tab-lms-projects-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                          <?php 
                                cs_lms_projects_listing_section();
                            ?>
                        </div>
                    <?php }?>
                    <?php if(isset($cs_post_sermons_option) && $cs_post_sermons_option == 'on'){?>
                        <div id="tab-sermons-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                          <?php 
                                cs_sermons_listing_section();
                            ?>
                        </div>
                    <?php }?>
                    <?php if(isset($cs_post_couponcode_option) && $cs_post_couponcode_option == 'on'){?>
                    <div id="tab-coupon-settings-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
                        cs_coupons_fields();
                      ?>
                    </div>
                    <?php }?>
                    <?php if(isset($cs_post_faqs_option) && $cs_post_faqs_option == 'on'){?>
                    <div id="tab-faqs-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
                            global $cs_xmlObject;
                            cs_faqs_section();
                        ?>
                    </div>
                    <?php }?>
                    <?php if(isset($cs_post_price_saleprice_option) && $cs_post_price_saleprice_option == 'on'){?>
                    <div id="tab-saleprice-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
                            global $cs_xmlObject;
                            cs_sale_fields();
                        ?>
                    </div>
                    <?php }?>
                    <div id="tab-custom-fields-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                      <?php 
                            $custom_fields = '';
                            $cs_dcpt_custom_fields = get_post_meta($post_id, "cs_dcpt_custom_fields", true);
                            if ( $cs_dcpt_custom_fields <> "" ) {
                                $cs_customfields_object = new SimpleXMLElement($cs_dcpt_custom_fields);
                                if(isset($cs_customfields_object->custom_fields_elements) && $cs_customfields_object->custom_fields_elements == '1'){
                                    if(count($cs_customfields_object)>1){
                                        echo '';	
                                        foreach ( $cs_customfields_object->children() as $cs_node ){
                                            $custom_fields .= '<div class="pbwp-form-rows">';
                                                $custom_fields .= cs_custom_fields_render();
                                            $custom_fields .= '</div>';
                                        }
                                    }
                                }
                            }
                            echo '<div class="pbwp-form-holder">';
                                echo esc_attr($custom_fields);
                            echo '</div>';
                        ?>
                    </div>
                    <?php if(isset($cs_post_image_option) && $cs_post_image_option == 'on'){?>
                    <div id="tab-media-attachment-<?php echo esc_attr($postname);?>" class="tab-pane fade">
                        <?php cs_media_attachments();?>
                    </div>
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="dynamic_post_meta_form" value="1" />
          </div>
        </div>
	<div class="clear"></div>
<?php
}
if ( isset($_POST['dynamic_post_meta_form']) and $_POST['dynamic_post_meta_form'] == 1 ) {
	add_action( 'save_post', 'cs_meta_dcpt_save' );
	function cs_meta_dcpt_save( $post_id ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		$sxe = new SimpleXMLElement("<cs_dynamic_cusotm_post></cs_dynamic_cusotm_post>");
		if (isset($_REQUEST['dcpt'])){
			foreach ( $_REQUEST['dcpt'] as $keys=>$values) {
				if(is_array($values)){
					$values = implode(",", $values);
				}				
				$sxe->addChild($keys, htmlspecialchars($values));
			}
		}
		if (isset($_REQUEST['dcpt_fileupload'])){
			foreach ( $_REQUEST['dcpt_fileupload'] as $keys=>$values) {
			}
		}
		if ( isset($_POST['gallery_meta_form']) and $_POST['gallery_meta_form'] == 1 ) {
			$cs_counter = 0;
			if ( isset($_POST['path']) ) {
				foreach ( $_POST['path'] as $count ) {
					$gallery = $sxe->addChild('gallery');
						$gallery->addChild('path', $_POST['path'][$cs_counter] );
						$gallery->addChild('title', htmlspecialchars($_POST['title'][$cs_counter]) );
						$gallery->addChild('use_image_as', $_POST['use_image_as'][$cs_counter] );
						$gallery->addChild('video_code', htmlspecialchars($_POST['video_code'][$cs_counter]) );
						$gallery->addChild('link_url', htmlspecialchars($_POST['link_url'][$cs_counter]) );
						$cs_counter++;
				}
			}
		}
		if (isset($_POST['dynamic_post_location']) && $_POST['dynamic_post_location'] == '1') {
			
			update_post_meta( $post_id, 'dynamic_post_event_from_date', $_POST['dynamic_post_event_from_date'] );
			
			if (empty($_POST['dynamic_post_event_from_date'])){ $_POST['dynamic_post_event_from_date'] = "";}
			if (empty($_POST['dynamic_post_event_to_date'])){ $_POST['dynamic_post_event_to_date'] = "";}
			if (empty($_POST['dynamic_post_event_start_time'])){ $_POST['dynamic_post_event_start_time'] = "";}
			if (empty($_POST['dynamic_post_event_end_time'])){ $_POST['dynamic_post_event_end_time'] = "";}
			if (empty($_POST['dynamic_post_event_all_day'])){ $_POST['dynamic_post_event_all_day'] = "";}
			if (empty($_POST['dynamic_post_event_address'])){ $_POST['dynamic_post_event_address'] = "";}
			if (empty($_POST['dynamic_post_event_ticket_options'])){ $_POST['dynamic_post_event_ticket_options'] = "";}
			if (empty($_POST['dynamic_post_event_buy_now'])){ $_POST['dynamic_post_event_buy_now'] = "";}
			if (empty($_POST['dynamic_post_event_ticket_color'])){ $_POST['dynamic_post_event_ticket_color'] = "";}
			if (empty($_POST['dynamic_post_event_contact_no'])){ $_POST['dynamic_post_event_contact_no'] = "";}
			if (empty($_POST['dynamic_post_event_email'])){ $_POST['dynamic_post_event_email'] = "";}
			
			
			if (empty($_POST['event_organizer'][$post_id])){ $event_organizer = "";} else { $event_organizer = implode(",", $_POST['event_organizer'][$post_id]);}
			if (empty($_POST['cs_event_members'][$post_id])){ $cs_event_members = "";} else { $cs_event_members = implode(",", $_POST['cs_event_members'][$post_id]);}
			if (empty($_POST['dynamic_post_event_content_view'])){ $_POST['dynamic_post_event_content_view'] = "";}
			update_post_meta( $post_id, 'event_organizer', esc_attr($event_organizer) );
			
			$sxe->addChild('dynamic_post_location', '1');
			$sxe->addChild('dynamic_post_event_from_date', esc_attr($_POST['dynamic_post_event_from_date']));
			$sxe->addChild('dynamic_post_event_to_date', esc_attr($_POST['dynamic_post_event_to_date']));
			$sxe->addChild('dynamic_post_event_start_time',esc_attr( $_POST['dynamic_post_event_start_time']));
			$sxe->addChild('dynamic_post_event_end_time', esc_attr($_POST['dynamic_post_event_end_time']));
			$sxe->addChild('dynamic_post_event_all_day', esc_attr($_POST['dynamic_post_event_all_day']));
			$sxe->addChild('dynamic_post_event_address', esc_attr($_POST['dynamic_post_event_address']));
			$sxe->addChild('dynamic_post_event_ticket_options', esc_attr($_POST['dynamic_post_event_ticket_options']));
			$sxe->addChild('dynamic_post_event_buy_now', esc_attr($_POST['dynamic_post_event_buy_now']));
			$sxe->addChild('dynamic_post_event_ticket_color', esc_attr($_POST['dynamic_post_event_ticket_color']));
			$sxe->addChild('dynamic_post_event_contact_no', esc_attr($_POST['dynamic_post_event_contact_no'])); 
			$sxe->addChild('dynamic_post_event_email', esc_attr($_POST['dynamic_post_event_email'])); 

			$sxe->addChild('event_organizer', $event_organizer); 
			$sxe->addChild('cs_event_members', $cs_event_members); 
			$sxe->addChild('dynamic_post_event_content_view', esc_attr($_POST['dynamic_post_event_content_view']));
			
			
			
		}
		
		if (isset($_POST['dynamic_post_lms_project']) && $_POST['dynamic_post_lms_project'] == '1') {
 			
			if (empty($_POST['dynamic_post_lms_project_client'])){ $_POST['dynamic_post_lms_project_client'] = "";}
			if (empty($_POST['dynamic_post_lms_project_skills'])){ $_POST['dynamic_post_lms_project_skills'] = "";}
			if (empty($_POST['dynamic_post_lms_project_software'])){ $_POST['dynamic_post_lms_project_software'] = "";}
			if (empty($_POST['dynamic_post_lms_project_url'])){ $_POST['dynamic_post_lms_project_url'] = "";}
			
			$sxe->addChild('dynamic_post_lms_project', '1');
			$sxe->addChild('dynamic_post_lms_project_client', esc_attr($_POST['dynamic_post_lms_project_client']));
			$sxe->addChild('dynamic_post_lms_project_skills', esc_attr($_POST['dynamic_post_lms_project_skills']));
			$sxe->addChild('dynamic_post_lms_project_software', esc_attr($_POST['dynamic_post_lms_project_software']));
			$sxe->addChild('dynamic_post_lms_project_url', esc_attr($_POST['dynamic_post_lms_project_url']));
		
		}
		$donor_counter = 0;
		if (isset($_POST['dynamic_post_donors']) && $_POST['dynamic_post_donors'] == '1' && isset($_POST['address_name_array']) && is_array($_POST['address_name_array'])) 		{
			$sxe->addChild('dynamic_post_donors', esc_attr($_POST['dynamic_post_donors']));
			foreach ( $_POST['address_name_array'] as $type ){
				$donor_list = $sxe->addChild('donors');
				$donor_list->addChild('address_name', htmlspecialchars($_POST['address_name_array'][$donor_counter]) );
				$donor_list->addChild('payer_email', htmlspecialchars($_POST['payer_email_array'][$donor_counter]) );
				$donor_list->addChild('payment_gross', htmlspecialchars($_POST['payment_gross_array'][$donor_counter]) );
				$donor_list->addChild('txn_id', htmlspecialchars($_POST['txn_id_array'][$donor_counter]) );
				$donor_list->addChild('payment_date', htmlspecialchars($_POST['payment_date_array'][$donor_counter]) );
				$donor_list->addChild('payment_gross', htmlspecialchars($_POST['payment_gross_array'][$donor_counter]) );
				$donor_counter++;
			}
		}
		$project_counter = 0;
		if (isset($_POST['dynamic_post_projects']) && $_POST['dynamic_post_projects'] == '1' && isset($_POST['project_title_array']) && is_array($_POST['project_title_array'])) {
			$sxe->addChild('dynamic_post_projects', $_POST['dynamic_post_projects']);
			foreach ( $_POST['project_title_array'] as $type ){
				$project_list = $sxe->addChild('projects');
				$project_list->addChild('project_title', htmlspecialchars($_POST['project_title_array'][$project_counter]) );
				$project_list->addChild('project_start_date', htmlspecialchars($_POST['project_start_date_array'][$project_counter]) );
				$project_list->addChild('project_end_date', htmlspecialchars($_POST['project_end_date_array'][$project_counter]) );
				$project_list->addChild('project_url', htmlspecialchars($_POST['project_url_array'][$project_counter]) );
				$project_counter++;
			}
		}
		$sermon_counter = 0;
		if (isset($_POST['dynamic_post_sermons']) && $_POST['dynamic_post_sermons'] == '1' && isset($_POST['sermon_title_array']) && is_array($_POST['sermon_title_array'])) {
			$sxe->addChild('dynamic_post_sermons', $_POST['dynamic_post_sermons']);
			$sxe->addChild('cs_sermon_short_summary', $_POST['cs_sermon_short_summary']);
			foreach ( $_POST['sermon_title_array'] as $type ){
				$sermon_list = $sxe->addChild('sermons');
				$sermon_list->addChild('sermon_title', htmlspecialchars($_POST['sermon_title_array'][$sermon_counter]) );
				$sermon_list->addChild('sermon_type', htmlspecialchars($_POST['sermon_type_array'][$sermon_counter]) );
				$sermon_list->addChild('sermon_file_url', htmlspecialchars($_POST['sermon_file_url_array'][$sermon_counter]) );
				$sermon_counter++;
			}
		}
		$faq_counter = 0;
		if (isset($_POST['dynamic_post_faq']) && $_POST['dynamic_post_faq'] == '1' && is_array($_POST['faq_title_array'])) {
			foreach ( $_POST['faq_title_array'] as $type ){
				$faq_list = $sxe->addChild('faqs');
				$faq_list->addChild('faq_title', htmlspecialchars($_POST['faq_title_array'][$faq_counter]) );
				$faq_list->addChild('faq_description', htmlspecialchars($_POST['faq_description_array'][$faq_counter]) );
				$faq_counter++;
			}
		}
		$sxe = cs_page_options_save_xml($sxe);
		
		// repeating events start
		if (isset($_POST['dynamic_post_event_repeat']) && $_POST['dynamic_post_event_repeat'] <> '0') {
			if ( isset($_POST['dynamic_post_event_num_repeat'] ) ) {
				global $wpdb;
				$post_thumbnail_id = get_post_thumbnail_id( $post_id );
				$post = get_post($post_id);
				$from_date = $_POST["dynamic_post_event_from_date"];
					for ( $i = 1; $i < $_POST['dynamic_post_event_num_repeat']; $i++ ) {
						$wpdb->insert( $wpdb->prefix.'posts',
								array(
									'post_date'			=> $post->post_date,
									'post_date_gmt'		=> $post->post_date_gmt,
									'post_content'		=> $post->post_content,
									'post_title'		=> $post->post_title,
									'post_excerpt'		=> $post->post_excerpt,
									'post_status'		=> $post->post_status,
									'comment_status'	=> $post->comment_status,
									'ping_status'		=> $post->ping_status,
									'post_name'			=> $post->post_name."-".$i,
									'post_modified'		=> $post->post_modified,
									'post_modified_gmt'	=> $post->post_modified_gmt,
									'post_type'			=> $post->post_type
								)
						);
						$inserted_id = (int) $wpdb->insert_id;
						// adding categories start
							$terms = wp_get_post_terms($post->ID, "events-categories");
							foreach ( $terms as $val ) {
								$wpdb->insert( $wpdb->prefix.'term_relationships',
										array(
											'object_id'	=> $inserted_id,
											'term_taxonomy_id'	=> $val->term_id,
											'term_order'	=> 0
										)
								);
							}
						// adding categories end
						// adding tag start
							$terms = wp_get_post_terms($post->ID, "events-tags");
							foreach ( $terms as $val ) {
								$wpdb->insert( $wpdb->prefix.'term_relationships',
										array(
											'object_id'	=> $inserted_id,
											'term_taxonomy_id'	=> $val->term_id,
											'term_order'	=> 0
										)
								);
							}
						// adding tag end
						// adding feature image start
							if ( $post_thumbnail_id ) update_post_meta( $inserted_id, '_thumbnail_id', $post_thumbnail_id );
						// adding feature image end
							update_post_meta( $inserted_id, 'dynamic_cusotm_post', $sxe->asXML() );
						if ( $_POST['dynamic_post_event_repeat'] <> 0 ) {
							$from_date = strtotime(date("Y/m/d", strtotime($from_date . $_POST["dynamic_post_event_repeat"])));
							$from_date = date('Y/m/d', $from_date);
							update_post_meta( $inserted_id, 'dynamic_post_event_from_date', $from_date );
						}
					}
			}
		}
		// repeating events end
		
		if ( isset ( $_POST["dynamic_post_event_from_date"] ) && $_POST["dynamic_post_event_from_date"] != '') {
			$cs_event_datetime = esc_attr($_POST["dynamic_post_event_from_date"].' '.$_POST["dynamic_post_event_start_time"]);
  			update_post_meta( $post_id, 'cs_dynamic_event_from_date_time',strtotime($cs_event_datetime));
		}
		
		update_post_meta( $post_id, 'dynamic_cusotm_post', $sxe->asXML() );
 		
	}
}