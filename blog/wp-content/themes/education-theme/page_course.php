<?php
/**
 * The template for displaying Courses
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
*/
	global $cs_node,$post,$cs_theme_options,$cs_xmlObject,$wpdb,$cs_counter_node,$wpdb,$course_id,$add_to_cart_url,$add_to_cart_product_url,$cs_sidebarLayout,$isSectionSidebar;
	$cs_courses_orderby = 'DESC';
	if ( !isset($cs_node->var_pb_course_per_page) || empty($cs_node->var_pb_course_per_page) ) { $cs_node->var_pb_course_per_page = -1; }
	if ( !isset($cs_node->cs_courses_orderby) || empty($cs_node->cs_courses_orderby) ) { $cs_courses_orderby = 'DESC'; } else {$cs_courses_orderby = (string)$cs_node->cs_courses_orderby;}
	$timeline_html_start = '';
	$timeline_html_end = '';
 	$width  = 370;
	$height = 278;
	$title_limit = '';
	$moreCourses	= false;
	$gridTitleClass	= '';
	
	if($cs_node->course_element_size == '100'){
		$course_element_size = 'col-md-12';
	} else if($cs_node->course_element_size == '75'){
		$course_element_size = 'col-md-9';
	} else if($cs_node->course_element_size == '50'){
		$course_element_size = 'col-md-6';
	} else if($cs_node->course_element_size == '33'){
		$course_element_size = 'col-md-4';
	} else {
		$course_element_size = 'col-md-3';
	}
	
	$courselisting_size = 'col-md-12';
	
	if ( $cs_node->var_pb_course_view == 'classic' ) {
		$course_listing_class = 'cs-list list_v3';
		$width  = 370;
		$height = 278;
	} else if ( $cs_node->var_pb_course_view == 'plain' ) {
		$course_listing_class = 'cs-list list_v3 has_border';
		$width  = 370;
		$height = 278;
	} else if ( $cs_node->var_pb_course_view == 'three-column' ) {
		$course_listing_class = 'cs-list list_v1 img_position_top has_border ';
		$courselisting_size = 'col-md-4';
		$title_limit = 36;
		$width  = 370;
		$height = 278;
	} else if ( $cs_node->var_pb_course_view == 'four-column' ) {
		$course_listing_class = 'cs-list list_v1 img_position_top has_border has_shadow';
		$courselisting_size = 'col-md-3';
		$title_limit = 36;
		$width  = 370;
		$height = 278;
	} else if ( $cs_node->var_pb_course_view == 'timeline' ) {
		$course_listing_class = 'cs-list list_v4 has_border';
		$timeline_html_start = '<div class="cs-list-wrapp">';
		$timeline_html_end = '</div>';
		$width  = 374;
		$height = 210;
	} else if ($cs_node->var_pb_course_view == 'flat') {
		$course_listing_class = 'cs-list cs-flat-view';
		$width  = 370;
		$height = 278;
	} else if ($cs_node->var_pb_course_view == 'flat-grid') {
		$course_listing_class = 'cs-list  img_position_top has_border has_shadow cs-flat-grid-view';
		$width  = 370;
		$height = 278;
		$title_limit = 36;
		
		if ( $cs_node->var_pb_course_filterable == 'yes' ||  $isSectionSidebar == 'left' || $isSectionSidebar == 'right' || $cs_sidebarLayout == 'left' || $cs_sidebarLayout == 'right' ) {
			$courselisting_size   = 'col-md-4';
		} else if ( $cs_node->var_pb_course_filterable == 'no' &&  ( $cs_sidebarLayout == 'none' ||  $cs_sidebarLayout == '' || $isSectionSidebar == 'none' ||  $isSectionSidebar == '' ) ) {
			$courselisting_size   = 'col-md-3';
		} else {
			$courselisting_size   = 'col-md-4';
		}
		
	} else if ( $cs_node->var_pb_course_view == 'grid-slider' ) {
		$course_listing_class = 'cs-list list_v1 img_position_top has_border ';
		$courselisting_size = '';
		$title_limit = 36;
		$width  = 370;
		$height = 278;
		$gridTitleClass	= 'grid-title';
		
		cs_owl_carousel();
		$owlcount = rand(40, 9999999);
		$moreCourses	= true;
		?>
        <script>  jQuery(document).ready(function($) {
			$("#owl-grid-<?php echo esc_js($owlcount);?>").owlCarousel({
				nav: true,
				margin: 30,
				navText: [
					"<i class='fa fa-angle-left'></i>",
					"<i class='fa fa-angle-right'></i>"
				],
				responsive: {
					0: {
						items: 1 // In this configuration 1 is enabled from 0px up to 479px screen size 
					},
					480: {
						items: 1, // from 480 to 677 
						nav: false // from 480 to max 
					},
					678: {
						items: 2, // from this breakpoint 678 to 959
						center: false // only within 678 and next - 959
					},
					960: {
						items: 3, // from this breakpoint 960 to 1199
						center: false,
						loop: false
		
					},
					1200: {
						items: 4
					}
				}
				}); }); 
			</script>

	<?php } else if ($cs_node->var_pb_course_view == 'minimal') {
		$course_listing_class = 'cs-list cs-minimal-view';
	} else if ($cs_node->var_pb_course_view == 'modren') {
		$course_listing_class = 'cs-list cs-modren-view';
		$width  = 374;
		$height = 210;
	} else if ($cs_node->var_pb_course_view == 'list') {
		$course_listing_class = 'cs-list cs-list-view';
		$width  = 374;
		$height = 210;
	} else if ($cs_node->var_pb_course_view == 'big') {
		$course_listing_class = 'cs-list cs-big-view';
		$width  = 370;
		$height = 278;
	} else if ($cs_node->var_pb_course_view == 'unique') {
		$course_listing_class = 'cs-list cs-unique-view';
		
		
		if ( $cs_node->var_pb_course_filterable == 'yes' && ( $cs_sidebarLayout == 'left' || $cs_sidebarLayout == 'right' ) ) {
			$courselisting_size   = 'col-md-6';
		} else if ( $cs_node->var_pb_course_filterable == 'yes' ||  $cs_sidebarLayout == 'left' || $cs_sidebarLayout == 'right' ) {
			$courselisting_size   = 'col-md-4';
		} else if ( $cs_node->var_pb_course_filterable == 'no' &&  $cs_sidebarLayout == 'none' ) {
			$courselisting_size   = 'col-md-3';
		} else{
			$courselisting_size   = 'col-md-3';
		}
		
	} else {
		$course_listing_class = 'cs-list list_v3';
		$width  = 370;
		$height = 278;
	}
	
	wp_reset_query();
	if ( !isset($cs_node->var_pb_course_view) || empty($cs_node->var_pb_course_view) ) { $cs_node->var_pb_course_view = 'classic'; }
 		$meta_compare = '';
        $filter_category = '';
		$filter_category_array = array();
        $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from ".$wpdb->prefix."terms WHERE slug = %s",$cs_node->var_pb_course_cat ));

        if ( isset($_GET['filter_category']) ) { 
 			$filter_category_array = $_GET['filter_category'];
			$catname = '';
			$contcat = ',';
			foreach($filter_category_array as $cat_name){
				$catname .= $cat_name.',';
 			}
			$filter_category = rtrim($catname,',');
 		}
        else {
            if(isset($row_cat->slug)){
            	$filter_category = $row_cat->slug;
            }
        }
		$cs_counter_course = 0;
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'courses',
				'post_status'				=> 'publish',
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
			);
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$course_category_array = array('course-category' => "$filter_category");
				$args = array_merge($args, $course_category_array);
			}
			
			
            $custom_query = new WP_Query($args);
			
            $count_post = 0;
			$counter = 1;
			
			$count_post = $custom_query->post_count;
			
			
		    $cs_course_layout = 'col-md-12';
		  if ($cs_node->var_pb_course_filterable == 'yes') {
			  	
				$qrystr= "";
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				$cs_course_layout = 'col-md-12';
		 
		  }
			$sort = '';
 			if(isset($_GET['sort']) and $_GET['sort'] <> '' ){ $sort = $_GET['sort']; }
			if(isset($_GET['sort']) and $_GET['sort']=='alphabetical'){
				
				$args = array('posts_per_page'=> "$cs_node->var_pb_course_per_page", 'paged'=> $_GET['page_id_all'], 'post_type'=> 'courses', 'post_status'=> 'publish','orderby'=> 'title', 'order'=> $cs_courses_orderby,);
				
			}elseif(isset($_GET['sort']) and $_GET['sort']=='members'){
				
				$args = array('posts_per_page'=> "$cs_node->var_pb_course_per_page",'paged'=> $_GET['page_id_all'],'post_type'=> 'courses','post_status'=> 'publish','meta_key'=> 'var_cp_course_members','orderby'=> 'meta_value_num','order'=> $cs_courses_orderby,);
			
			}elseif(isset($_GET['sort']) and $_GET['sort']=='rating'){
				
				$args = array('posts_per_page' => "$cs_node->var_pb_course_per_page",'paged' => $_GET['page_id_all'],'post_type' => 'courses','post_status' => 'publish','meta_key' => 'cs_course_review_rating','orderby' => 'meta_value','order' => $cs_courses_orderby,);
			
			}else{
				$args = array(
					'posts_per_page'			=> "$cs_node->var_pb_course_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'courses',
					'post_status'				=> 'publish',
					'order'						=> $cs_courses_orderby,
				 );
			}
 			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
 				$course_category_array = array('course-category' => "$filter_category");
 				$args = array_merge($args, $course_category_array);
			}
			
			$custom_query = new WP_Query($args);
			
			$post_count='';
			if ( isset($_GET['filter_category']) ) { 
				$post_count = $custom_query->post_count;
			}
			$element_size = 100;
  			
			if ( $cs_node->var_pb_course_filterable == 'yes' ) {
				$element_size = 75;
				if ( function_exists( 'cs_get_course_filters' ) ) {
					echo '<div class="element-size-25">';
						cs_get_course_filters($filter_category_array,$sort,$post_count); 
					echo '</div>';
				}
			}
			
			if ( $custom_query->have_posts() <> "" ) {
				
			?>
      			<div class="element-size-<?php echo esc_attr($element_size); ?>">
                <?php if ($cs_node->var_pb_course_title <> '') {
				
					 ?>
                	<div class="cs-section-title col-md-12 <?php echo esc_attr($gridTitleClass);?>">
                    	<h2><?php echo esc_html($cs_node->var_pb_course_title);?></h2>
                    </div>
                <?php }?>
					
				<?php  if ( $cs_node->var_pb_course_view == 'grid-slider' ) { ?>
                    <div class="row owl-carousel nxt-prv-v2 cs-theme-carousel cs-crslider col-md-12" id="owl-grid-<?php echo esc_attr($owlcount);?>">
                <?php }
							
							$counterItems	= 0;
							$var_cp_course_product = '';
						    while ( $custom_query->have_posts() ): $custom_query->the_post();
								
								$counterItems++;
						 		$course_id = $course_post_id = $post->ID;
								$var_pb_course_excerpt = (int)$cs_node->var_pb_course_excerpt;
								$excerpt	= cs_get_the_excerpt((int)$cs_node->var_pb_course_excerpt,false, '');
								$applyNowButton	= get_the_permalink();
                                $cs_course = get_post_meta($post->ID, "cs_course", true);
                                if ( $cs_course <> "" ) {
                                    $cs_xmlObject = new SimpleXMLElement($cs_course);
                                	$var_cp_course_id = $cs_xmlObject->course_id;
                                    $course_duration = $cs_xmlObject->course_duration;
									$var_cp_course_members = $cs_xmlObject->var_cp_course_members;
									$var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
									$course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
                                }
                                else{
                               	 	$var_cp_course_product = $var_cp_course_members = $var_cp_course_product = '';
                               	    $course_duration = '';	
									$course_subheader_bg_color = '';
                                }
								
 								$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
 								$course_class = $course_listing_class;
 							    if($image_url == ''){
                                    $course_class = ' no-img '.$course_listing_class;
                                }
								 if($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column'){
								 	$thumbnail	= 'hover-gallery';
								 } else {
								 	$thumbnail	= 'img-thumbnail';
								 }
								 
								 
								 if ( trim($cs_node->cs_course_animation) !='' ) {
									$cs_course_animation	= 'wow'.' '.$cs_node->cs_course_animation;
								 } else {
									$cs_course_animation	= '';
								 }
								 
								 if ( isset( $course_subheader_bg_color ) && $course_subheader_bg_color !='' && $cs_node->var_pb_course_view == 'unique' ){
									$course_background	= 'style="background-color:'.$course_subheader_bg_color.'"';
									$course_background_hover	= '';	
								 } else {
								 	$course_background	= '';
									$course_background_hover	= 'style="background-color:'.$course_subheader_bg_color.'"';;
										
								 }
								 $firstChild	= '';
								 if ( $counterItems == 1 ) {
								 	$firstChild	= 'cs-first-child';
								 }
								 
								 if ( $image_url == '' ) {
									if ( $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider' ) {
										$image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
									 }
								   } else {
										$image_url	= $image_url;
								   }
								   
							?>
                            <div class="<?php echo esc_attr($cs_course_animation.' '. $courselisting_size);?>">
                            	<article <?php post_class($course_class.' '.$firstChild); echo balanceTags($course_background, false);?> >
							<?php echo balanceTags($timeline_html_start, false);
                                    if( $image_url <> '' && $cs_node->var_pb_course_view <> 'unique' ){ ?>
                                     <?php if( $cs_node->var_pb_course_view == 'flat' ){ echo '<div class="cr-flat">';}?>
                                     <figure class="<?php echo esc_attr($thumbnail);?>  fig-<?php echo absint($post->ID);?>">
                                         <?php 
										 		$user = cs_get_user_id();
												$cs_wishlist = array();
												$cs_wishlist =  get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
												if (!is_user_logged_in() ) { 
													echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">';?> <?php  _e('Add to Favourite','LMS');  echo '</a>';
												}elseif(isset($user) and $user<>''){
													$cs_wishlist = get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
													if(is_array($cs_wishlist) && in_array($post->ID,$cs_wishlist)){
														echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>'.__('Already Favourite','LMS').'</a>';
													 }else{
													?>
                                                		<a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>','<?php echo esc_js(absint($post->ID));?>','post')">
                                                			<i class="fa fa-heart"></i> 
 <?php  _e('Add to Favourite','LMS');?>
                                                		</a>
                                                <?php } } ?>
                                         <img src="<?php echo esc_url($image_url);?>" alt="">
                                         <a class="blog-hover" <?php echo balanceTags($course_background_hover, false);?> href="<?php the_permalink();?>"><i></i></a>
                                    </figure>
                                    <?php if( $cs_node->var_pb_course_view == 'flat' ){?>
                                        		<a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php  _e('Apply Now','LMS');?></a>
                                                
                                    <?php  echo '</div>';}
                                     }?>
                                    
                                    <?php if( $cs_node->var_pb_course_view != 'unique' ){?>
                                     <div class="text-section">
                                        <div class="cs-top-sec">
                                        	<div class="seideleft">
                                              <?php } ?>
                                            	<div class="left_position">
                                                	<?php 
														$headingTypeStart	= '<h2>';
														$headingTypeEnd		= '</h2>';
														if($cs_node->var_pb_course_view == 'minimal'){
															$headingTypeStart	= '<h5>';
															$headingTypeEnd	= '</h5>';
														}else{
															$headingTypeStart	= '<h2>';
															$headingTypeEnd	= '</h2>';
														}
													
													 echo balanceTags($headingTypeStart, false);
													 ?>
                                                    <a href="<?php the_permalink();?>" class="colrhvr">
														<?php if($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider'){?>
														<?php echo substr(get_the_title(),0, $title_limit); if(strlen(get_the_title())>$title_limit){echo '...';}?>
                                                        <?php } else {
															echo get_the_title();
														 }?>
                                                    </a>
                                                    <?php 
													echo balanceTags($headingTypeEnd, false);
													
													if($cs_node->var_pb_course_view != 'minimal'){

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
													wp_reset_postdata();
													if($var_cp_rating){
														$var_cp_rating = $var_cp_rating/$reviews_count;
													}
			
                                                    ?>
                                                    <?php  
													 if( ( $cs_node->var_pb_course_view != 'unique' )) { 
													 if( ( $cs_node->var_pb_course_view == 'list' || $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider' ||  $cs_node->var_pb_course_view == 'flat' )) { 
													
														if ( isset($reviews_count) && $reviews_count <> '' &&  $reviews_count > 0 ) {
															echo '<ul class="listoption">';
														} else {
															echo '';
														}
														
													 } else {?>
                                                    <ul class="listoption">
                                                    <?php }?>
                                                        <?php 
															if($cs_node->var_pb_course_view == 'flat'){ 
																 if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															} else if( $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column'  || $cs_node->var_pb_course_view == 'grid-slider' ){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															
															} else if($cs_node->var_pb_course_view == 'list'){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); } 
															
															} else if($cs_node->var_pb_course_view == 'big'){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															  if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); } 
															
															} else if($cs_node->var_pb_course_view == 'flat-grid' ){ 
															 
															   if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															
															} else if($cs_node->var_pb_course_view == 'plain'){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															  if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
															
															} else if($cs_node->var_pb_course_view == 'timeline'){ 
															 
															 if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); } 
															  if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
															
															} else if($cs_node->var_pb_course_view == 'classic'){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															  if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
															
															}else if($cs_node->var_pb_course_view == 'modren'){ 
															 
															  if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
															  if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
															
															}
															
                                                         ?>
                                                     
												   <?php   if( ( $cs_node->var_pb_course_view == 'list' || $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider' || $cs_node->var_pb_course_view == 'flat' )) { 
                                                
                                                    if ( isset($reviews_count) && $reviews_count <> '' &&  $reviews_count > 0 ) {
                                                        echo '</ul>';
                                                    } else {
                                                        echo '';
                                                    }
													?>
                                                    <?php } else {?>
                                                     </ul>
                                                    <?php } }?>
                                                     
													 <?php if($cs_node->var_pb_course_view == 'list'){ ?>
                                                         <div  class="listoption">
                                                             <ul>
                                                               <?php 
                                                                     if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); } 
                                                                     if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); } 
                                                                     if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); } 
                                                                 ?>
                                                             </ul>
                                                        </div>
                                                     <?php }?>
                                             		
                                                 </div>
                                          	 
											 <?php  if( $cs_node->var_pb_course_view != 'unique' ){?> </div><?php }?>
                                           
                                            <?php  if( $cs_node->var_pb_course_view == 'timeline'){?>
                                                <div class="cs-cat-list">
                                                    <ul>
                                                        <?php 
                                                                if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id, $var_cp_course_paid); }
                                                                if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
                                                                if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
                                                        ?>	
                                                    </ul>
                                                </div>
											<?php }?>
                                            <?php  if( $cs_node->var_pb_course_view == 'unique'){?>
                                               <div class="cr-unique">
                                               <div  class="listoption">
                                                    <ul>
                                                        <?php 
																if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); } 
                                                                if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
                                                        ?>	
                                                    </ul>
                                                </div>
											<?php }?>
                                         
                                           <?php  if( $cs_node->var_pb_course_view != 'flat' && $cs_node->var_pb_course_view != 'unique' ){?> </div><?php }?>
                                         <?php if($cs_node->var_pb_course_view <> 'timeline' && $cs_node->var_pb_course_view <> 'list'  && $cs_node->var_pb_course_view <> 'three-column' && $cs_node->var_pb_course_view <> 'four-column' && $cs_node->var_pb_course_view <> 'unique' && $cs_node->var_pb_course_view <> 'modren' && $cs_node->var_pb_course_view <> 'grid-slider'){?>
                                             <div class="cs-peragraph">
                                                <p><?php echo esc_attr($excerpt);?></p> 
                                             </div>
                                         <?php }?>
                                         
                                         <?php if($cs_node->var_pb_course_view != 'big' && $cs_node->var_pb_course_view != 'flat-grid' && $cs_node->var_pb_course_view != 'timeline' ){ ?>
                                         
                                          <?php  
											 if( ( $cs_node->var_pb_course_view == 'unique' )) { 
											
												if ( isset($reviews_count) && $reviews_count <> '' &&  $reviews_count > 0 ) {
													echo ' <div class="cs-cat-list">';
												} else {
													echo '';
												}
												
											 } else {?>
											 <div class="cs-cat-list">
											<?php }?>
                                         	<ul>
                                            	<?php
													if($cs_node->var_pb_course_view == 'unique'){ 
														if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
													} else if($cs_node->var_pb_course_view == 'flat'){ 
														 if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
														 if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
														 if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
													} else if($cs_node->var_pb_course_view == 'plain' || $cs_node->var_pb_course_view == 'classic' ){
														if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id, $var_cp_course_paid); }
														if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
														if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
													
													} else if($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'grid-slider'){ 
														
														if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
														if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id, $var_cp_course_paid); }
													
													} else if($cs_node->var_pb_course_view == 'modren'){ 
														
														if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id, $var_cp_course_paid); }
														if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
														if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
														
													}else if($cs_node->var_pb_course_view == 'list'){ 
													
														if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id,$var_cp_course_paid); }
													
													}
												?>
                                            </ul>
                                            <?php 
										 		if(isset($add_to_cart_url) && $add_to_cart_url <> '' && $cs_node->var_pb_course_view == 'list'){?>
                                        		<a href="<?php echo the_permalink(); ?>" class="custom-btn"><i class="fa fa-file-text"></i> <?php  _e('Apply Now','LMS');?></a>
                                           <?php  }?>
                                         
                                           <?php   if( $cs_node->var_pb_course_view == 'unique' ) { 
                                                
                                                    if ( isset($reviews_count) && $reviews_count <> '' &&  $reviews_count > 0 ) {
                                                        echo '</div>';
                                                    } else {
                                                        echo '';
                                                    }
													?>
                                                    <?php } else {?>
                                                     </div>
                                               <?php } ?>
                                                    
                                         
                                         <?php  }?>
                                         <?php  if( $cs_node->var_pb_course_view == 'unique' ){?> </div><?php }?>
                                         <?php  if( $cs_node->var_pb_course_view == 'flat'){?> </div><?php }?>
                                         <?php if($cs_node->var_pb_course_view == 'big'){?>
                                                 <ul class="cr-listing">
												 	<?php echo cs_get_course_price($course_post_id, $var_cp_course_paid);?>
                                                 	<li><a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php _e('Apply Now','LMS');?></a>
                                                    </li>
                                                 </ul>
                                          <?php }
										  if( $cs_node->var_pb_course_view != 'list' && $cs_node->var_pb_course_view != 'big' && $cs_node->var_pb_course_view != 'flat' && $cs_node->var_pb_course_view != 'unique'){ global $cs_theme_options,$wpdb; ?>
                                        		<a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php  _e('Apply Now','LMS');?></a>
                                         <?php  } }?>
                                     
                                     <?php  if( $cs_node->var_pb_course_view != 'unique' ){?> </div>
							
							<?php }
								echo balanceTags($timeline_html_end, false);
							?>
                            </article>
                        	</div>
                            <?php 
							
							endwhile;
						
							if ( $cs_node->var_pb_course_view == 'grid-slider' ) { 
								
								echo '</div>';
								if ( $moreCourses && ( $cs_node->var_pb_course_cat != '0' && $cs_node->var_pb_course_cat !='' ) ) { ?> 
                                 <div class="course-more col-md-12 <?php echo esc_attr($cs_course_animation);?>">
                                    <a href="<?php echo esc_url(home_url()); ?>/course-category/<?php echo esc_html($row_cat->slug);?>"><?php _e('View More Courses','LMS');?></a>
                                 </div>
                                <?php }?>
								
							<?php }	
							
							 if ( $cs_node->var_pb_course_view != 'grid-slider' ) {
								  $qrystr = '';
								  if ( $cs_node->var_pb_course_pagination == "Show Pagination" and $count_post > $cs_node->var_pb_course_per_page and $cs_node->var_pb_course_per_page > 0) 
								   {
										if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".absint($_GET['page_id']);
											if ( function_exists( 'cs_pagination' ) ) { echo cs_pagination($count_post, esc_attr($cs_node->var_pb_course_per_page),$qrystr); } 
									}
								  }
							  
							  }else {?> 
								<div class="col-md-12"><?php  _e('No Course Found','LMS');?></div>
							 <?php }?> 
                         </div>
 