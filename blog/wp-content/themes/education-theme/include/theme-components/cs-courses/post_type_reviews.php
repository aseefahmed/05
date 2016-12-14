<?php
	// Assignments start
		//adding columns start
		add_filter('manage_cs-reviews_posts_columns', 'reviews_columns_add');
			function reviews_columns_add($columns) {
				$columns['users'] =__('Users','LMS');
				$columns['rating'] =__('Rating','LMS');
				$columns['courses'] =__('Courses','LMS');
				$columns['author'] =__('Author','LMS');
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
	function cs_reviews_register() {  
		$labels = array(
			'name' =>__('Reviews','LMS'),
			'add_new_item' =>__('Add New Reviews','LMS'),
			'edit_item' =>__('Edit Reviews','LMS'),
			'new_item' =>__('New Reviews Item','LMS'),
			'add_new' =>__('Add New Reviews','LMS'),
			'view_item' =>__('View Reviews Item','LMS'),
			'search_items' =>__('Search Reviews','LMS'),
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
			'supports' => array('title','editor')
		); 
        register_post_type( 'cs-reviews' , $args );
	}
	add_action('init', 'cs_reviews_register');

// adding Gallery meta info start
	add_action( 'add_meta_boxes', 'cs_meta_reviews_add' );
	function cs_meta_reviews_add()
	{  
		add_meta_box( 'cs_meta_reviews', __('Reviews Options','LMS'), 'cs_meta_reviews', 'cs-reviews', 'normal', 'high' );  
	}
	function cs_meta_reviews( $post ) {
		global $cs_xmlObject, $post;
		$var_cp_reviews_members = $var_cp_courses = $var_cp_rating  = '';
		$var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
		$var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
		$var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
 	?>
    	<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                	<ul class="form-elements">
                            <li class="to-label"><label><?php _e('Select User','LMS');?></label></li>
                            <li class="to-label">
                                <div class="input-sec">
                                    <?php 
                                    $blogusers = get_users('orderby=nicename');
                                    echo '<div class="select-style"><select name="var_cp_reviews_members" id="var_cp_reviews_members">
                                            <option value="">'.__('None','LMS').'</option>';
                                              foreach ($blogusers as $user) {?>
                                            <?php
                                            if($user->ID=="$var_cp_reviews_members"){
                                                    $selected =' selected="selected"';
                                                }else{ 
                                                    $selected = '';
                                                }
                                            echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
                                             ?>
                                    <?php }
                                    echo '</select></div>';
                                 ?>
                             </div>
                         </li>
                     </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Rating','LMS');?></label></li>
                        <li class="to-label">
                        <div class="input-sec">
                        	<div class="select-style">
                            <select name="var_cp_rating" id="var_cp_rating">
								<?php 
                                    $rating = range(1,5);
                                    foreach($rating as $rate){
                                ?>
                                	<option <?php if($var_cp_rating==$rate) { echo 'selected'; } ?>><?php echo esc_attr($rate); ?></option>
                                <?php	
                                   }
                                ?>
                            </select>
                            	</div>
                            </div>
                        </li>
                     </ul>
                     
                     <ul class="form-elements noborder">
                        <li class="to-label"><label><?php _e('Select Course','LMS'); ?></label></li>
                        	<li class="to-label">
                                <div class="input-sec">
								<?php 
                                echo '<div class="select-style"><select name="var_cp_courses" id="var_cp_courses">
                                        <option value="">'.__('None','LMS').'</option>';
                                        query_posts( array('showposts' => "-1", 'post_status' => 'publish', 'post_type' => 'courses') );
                                        while (have_posts() ) : the_post(); ?>
                                        <?php
                                        
                                        $cs_courses_id = get_the_id();
                                
                                        if($cs_courses_id == $var_cp_courses){
                                                $selected =' selected="selected"';
                                            }else{ 
                                                $selected = '';
                                            }
                                        echo '<option value="'.$cs_courses_id.'" '.$selected.'>'.get_the_title().'</option>';
                                         ?>
                                <?php endwhile; wp_reset_query();
                                echo '</select></div>';
                             ?>
                         	</div>
                         </li>
                       </ul>
                </div>
            </div>
            <input type="hidden" name="reviews_form" value="1" />
			<div class="clear"></div>
		</div>
    <?php
	}
	// adding Assignment meta info end
	// saving Assignment meta start
	if ( isset($_POST['reviews_form']) and $_POST['reviews_form'] == 1 ) {
		add_action( 'save_post', 'cs_reviews_save' );
		function cs_reviews_save( $post_id ) {  
			$sxe = new SimpleXMLElement("<reviews></reviews>");
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
			if ( empty($_POST["var_cp_reviews_members"]) ) $_POST["var_cp_reviews_members"] = "";
			if ( empty($_POST["var_cp_rating"]) ) $_POST["var_cp_rating"] = "";
			if ( empty($_POST["var_cp_courses"]) ) $_POST["var_cp_courses"] = "";
 			update_post_meta($post_id, "cs_reviews_rating", $_POST['var_cp_rating']);
			update_post_meta($post_id, "cs_reviews_user", $_POST['var_cp_reviews_members']);
			update_post_meta($post_id, "cs_reviews_course", $_POST['var_cp_courses']);
 			cs_update_rating($_POST["var_cp_courses"]);
			$counter = 0;
			update_post_meta( $post_id, 'cs_meta_reviews', $sxe->asXML() );
		}
	// Assignment end
	}
	function cs_update_rating($id){
	
		global $post,$wpdb;
		
		$reviews_args = array(
			'posts_per_page'			=> "-1",
			'post_type'					=> 'cs-reviews',
			'post_status'				=> 'publish',
			'meta_key'					=> 'cs_reviews_course',
			'meta_value'				=> $id,
			'meta_compare'				=> "=",
			'orderby'					=> 'meta_value',
			'order'						=> 'ASC',
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
?>