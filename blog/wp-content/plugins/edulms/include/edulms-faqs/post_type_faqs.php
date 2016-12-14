<?php
	
	// FAQ start
	//adding columns start
	//add_filter('manage_cs-faqs_posts_columns', 'faqs_columns_add');
	function faqs_columns_add($columns) {
		$columns['user'] = 'User';
	}
	
	//add_action('manage_cs-faqs_posts_custom_column', 'faqs_columns',10, 2);
	function faqs_columns($name) {
		global $post;
		$var_cp_faqs_members = get_post_meta($post->ID, "cs_faqs_user", true);
		switch ($name) {
			case 'user':
				echo get_the_author_meta('display_name', $var_cp_faqs_members);
			break;
		}
	}
	
	//adding columns end
	
	function cs_faqs_register() {  
		$labels = array(
			'name' =>__('Faqs','EDULMS'),
			'add_new_item' =>__('Add New Faq','EDULMS'),
			'edit_item' =>__('Edit Faq','EDULMS'),
			'new_item' =>__('New Faq Item','EDULMS'),
			'add_new' =>__('Add New Faq','EDULMS'),
			'view_item' =>__('View Faq Item','EDULMS'),
			'search_items' =>__('Search Faq','EDULMS'),
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
			'supports' => array('title', 'editor')
		); 
        register_post_type( 'cs-faqs' , $args );
	}
	add_action('init', 'cs_faqs_register');
	
	function faqs_status(){
		register_post_status( 'under-review', array(
			'label'                     => 'Under Review',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Under Review <span class="count">(%s)</span>', 'Under Review <span class="count">(%s)</span>' ),
		) );
	}
	add_action( 'init', 'faqs_status' );

	//  adding FAQ meta info start
	add_action( 'add_meta_boxes', 'cs_meta_faqs_add' );
	function cs_meta_faqs_add()
	{  
		add_meta_box( 'cs_meta_faqs', __('Faqs Options','EDULMS'), 'cs_meta_faqs', 'cs-faqs', 'normal', 'high' );  
	}
	
	function faq_content_by_id( $post_id=0, $more_link_text = null, $stripteaser = false ){
		global $post;
		$post = get_post($post_id);
		setup_postdata( $post, $more_link_text, $stripteaser );
		$cont = get_the_content();
		wp_reset_postdata( $post );
		return $cont;
	}
	
	function cs_meta_faqs( $post ) {
		global $cs_xmlObject, $post;
		$edulms = new edulms;
		$plugin_url = $edulms->plugin_url;
		$var_cp_faqs_members = $var_cp_courses = $var_faqs_email = $var_faqs_answer = '';
		$var_cp_faqs_members = get_post_meta($post->ID, "cs_faqs_user", true);
		$var_cp_courses = get_post_meta($post->ID, "cs_faqs_course", true);
		$var_faqs_email = get_post_meta($post->ID, "cs_faqs_email", true);
		$faq_id = $post->ID;
 	?>
    	<div class="page-wrap faqs-admin">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                	
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('User Email','EDULMS');?></label></li>
                        <li class="to-form">
                        	<div class="input-sec">
								<input type="text" id="faqs_email" name="var_faqs_email" value="<?php echo sanitize_email($var_faqs_email); ?>" />
                            </div>
                        </li>
                     </ul>
                     
                	<ul class="form-elements">
                        <li class="to-label"><label><?php _e('User Name','EDULMS');?></label></li>
                        <li class="to-form">
                        	<div class="input-sec">
                            	<input type="text" id="var_cp_faqs_members" name="var_cp_faqs_members" value="<?php echo esc_attr($var_cp_faqs_members); ?>" />
                            </div>
                        </li>
                     </ul>
                     
                     <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Select Course','EDULMS'); ?></label></li>
                        	<li class="to-form">
                                <div class="input-sec">
								<?php 
                                echo '<select name="var_cp_courses[]" id="var_cp_courses" multiple="multiple" style="height:200px;">
                                        <option value="">None</option>';
                                        query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'courses') );
                                        while (have_posts() ) : the_post(); ?>
                                        <?php
                                        
                                        $cs_courses_id = get_the_id();
                                			
											if(in_array($cs_courses_id, $var_cp_courses)){
                                                $selected =' selected="selected"';
                                            }else{ 
                                                $selected = '';
                                            }
                                        echo '<option value="'.$cs_courses_id.'" '.$selected.'>'.get_the_title().'</option>';
                                         ?>
                                <?php endwhile; wp_reset_query();
								wp_reset_postdata();
                                echo '</select>';
                             ?>
                         	</div>
                         </li>
                       </ul>
                       <ul class="form-elements">
                           <li class="to-label"><label><?php _e('Email Subject','EDULMS');?></label></li>
                           <li class="to-form">
                           		<input type="text" id="faq_email_subject" name="faq_email_subject" value="<?php echo get_the_title($faq_id); ?>" />
                           </li>
                       </ul>
                       <ul class="form-elements">
                           <li class="to-label"><label><?php _e('Email Message','EDULMS');?></label></li>
                           <li class="to-form">
                           		<?php wp_editor( faq_content_by_id($faq_id), 'faq_email_message', $settings = array('media_buttons' => false, 'tinymce' => false) ); ?> 
                                <button type="button" class="btn" onclick="cs_faqs_email('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js($plugin_url); ?>', '<?php echo esc_js($faq_id); ?>');"><?php _e('Send Mail','EDULMS');?></button>
                           </li>
                           <li class="to-label">&nbsp;</li>
                           <li class="to-form">
                                <div id="loading"></div>
                                <div id="email-response-msg" style="display:none;"></div>
                           </li>
                       </ul>
                </div>
            </div>
            <input type="hidden" name="faqs_form" value="1" />
			<div class="clear"></div>
		</div>
    <?php
	}
	// adding FAQ meta info end
	// saving FAQ meta start
	if ( isset($_POST['faqs_form']) and $_POST['faqs_form'] == 1 ) {
		add_action( 'save_post', 'cs_faqs_save' );
		function cs_faqs_save( $post_id ) {  

			$sxe = new SimpleXMLElement("<faqs></faqs>");
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
			if ( empty($_POST["var_cp_faqs_members"]) ) $_POST["var_cp_faqs_members"] = "";
			if ( empty($_POST["var_cp_courses"]) ) $_POST["var_cp_courses"] = "";
			if ( empty($_POST["var_faqs_email"]) ) $_POST["var_faqs_email"] = "";
			update_post_meta($post_id, "cs_faqs_user", $_POST['var_cp_faqs_members']);
			update_post_meta($post_id, "cs_faqs_course", $_POST["var_cp_courses"]);
			update_post_meta($post_id, "cs_faqs_email", $_POST['var_faqs_email']);
			update_post_meta( $post_id, 'cs_meta_faqs', $sxe->asXML() );
		}
	// FAQ end
	}