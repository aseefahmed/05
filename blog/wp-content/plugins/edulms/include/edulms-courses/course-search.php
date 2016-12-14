<?php
if( !function_exists('cs_course_search_func')){
	function cs_course_search_func($course_id = ''){
		global $post,$cs_theme_options;
		$var_cp_course_product = '';
		$post_class = '';
		$image_url = '';
		
		$cs_course = get_post_meta($course_id, "cs_course", true);
		if ( $cs_course <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_course);
			$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
		}
		$image_url = cs_attachment_image_src(get_post_thumbnail_id( $course_id), 370, 278 );
		if($image_url == ''){
			$post_class = ' no-image';
			$image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
		}
		$event_from_date = get_post_meta( $post->ID, "cs_event_from_date", true ); 
		$applyNowButton	= get_the_permalink(); 
	?>
	<div class="col-md-4">
		<article class="cs-list list_v1 img_position_top has_border post-<?php echo absint($course_id); ?>">
			<?php 
				if($image_url <> ""){
					echo '<figure>';
						$user = cs_get_user_id();
						$cs_wishlist = array();
						$cs_wishlist =  get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
						if (!is_user_logged_in() ) { 
							echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">'.__('Login','EDULMS').'</a>';
						}elseif(isset($user) and $user<>''){
							$cs_wishlist = get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
							if(is_array($cs_wishlist) && in_array($post->ID,$cs_wishlist)){
								echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>'.__('Already Favourite','EDULMS').'</a>';
						}else{
						?>
						<a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($course_id);?>','post')">
							<i class="fa fa-heart"></i> 
							<?php  _e('Add to Favourite','EDULMS');?>
						</a>
				<?php } 
				} ?>
				<a href="<?php echo the_permalink();?>" ><img src="<?php echo esc_url($image_url);?>" alt="" ></a>
				</figure>
				<?php }?>
				<div class="text-section">
					<div class="cs-top-sec">
						<div class="seideleft">
							<div class="left_position">
								  <h2><a href="<?php the_permalink(); ?>" class="colrhvr"><?php the_title(); ?></a></h2>
								  <?php 
								  $reviews_args = array(
									'posts_per_page'			=> "-1",
									'post_type'					=> 'cs-reviews',
									'post_status'				=> 'publish',
									'meta_key'					=> 'cs_reviews_course',
									'meta_value'				=> $post->ID,
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
								
								if ( function_exists( 'cs_get_course_reviews' ) ) { echo '<ul class="listoption">';cs_get_course_reviews($reviews_count,$var_cp_rating);echo '</ul>'; }
								  ?>													                                                                                                                                                                 
							</div>
						</div>                                           
					</div>                                                                                  
					<div class="cs-cat-list">
						<?php 
							if ( function_exists( 'cs_get_course_price' ) ) {
								echo '<ul>';
									cs_get_course_price($var_cp_course_product); 
								echo '</ul>';
							}
						?>	
					</div>
					<a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i>
						<?php
							  _e('Apply Now','EDULMS');?>															 
					</a>                                                                                                                                                                 		
			  </div>
		</article>
	</div>
	<?php
	}
}