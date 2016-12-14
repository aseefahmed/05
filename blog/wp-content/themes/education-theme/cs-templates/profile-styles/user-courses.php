<?php
/**
 * User Register For Courses
 */
	global $current_user, $wp_roles,$userdata,$cs_theme_options;
	
	$cs_course = get_post_meta($post->ID, "cs_course", true);
	if ( $cs_course <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_course);
		$course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
	}
	else{
		$course_subheader_bg_color = '';
	}
	$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID), 370, 278 ); 
	$course_listing_class = 'cs-list img_position_top has_border has_shadow cs-flat-grid-view';
	$course_class = $course_listing_class;
	if($image_url == ''){
		$course_class = ' no-img '.$course_listing_class;
		$image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
	}
?>
<div class="col-md-4">
    <article <?php post_class($course_class);?>>
        <figure class="img-thumbnail fig-<?php echo absint($post->ID);?>">
       		<?php 
				$user = cs_get_user_id();
				$cs_wishlist = array();
				$cs_wishlist =  get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
				
				if ( !is_user_logged_in() ) { 
					echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">';?> <?php _e('Add to Favourite','LMS');  echo '</a>';
				
				}
				else if(isset($user) and $user <> ''){
					$cs_wishlist = get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
					if(is_array($cs_wishlist) && in_array($post->ID, $cs_wishlist)){
						echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>'.__('Already Favourite','LMS').'</a>';
					}else{
					?>
						<a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($post->ID);?>','post')">
						<i class="fa fa-heart"></i> 
						<?php _e('Add to Favourite','LMS'); ?>
						</a>
					<?php
					} 
				}
			?>
			<img src="<?php echo esc_url($image_url); ?>" alt="">
			<a class="blog-hover" <?php echo 'style="background-color:'.esc_attr($course_subheader_bg_color).'"'; ?> href="<?php the_permalink();?>"><i></i></a>
        </figure>
		<div class="text-section">
            <div class="cs-top-sec">
                <div class="seideleft">
                    <div class="left_position">
                        <h2><a class="colrhvr" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>