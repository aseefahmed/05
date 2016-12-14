<?php
/**
 * The template for displaying Achive(s) pages
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	get_header();
	global $cs_node,$cs_theme_options,$cs_counter_node;
	$cs_layout 	= '';
 			if(isset($cs_theme_options['cs_excerpt_length']) && $cs_theme_options['cs_excerpt_length'] <> ''){ $default_excerpt_length = $cs_theme_options['cs_excerpt_length']; }else{ $default_excerpt_length = '255';}; 
			$cs_layout =isset($cs_theme_options['cs_default_page_layout'])? $cs_theme_options['cs_default_page_layout']:'col-md-12';
			if ( isset( $cs_layout ) && $cs_layout == "sidebar_left") {
				$cs_layout = "content-right col-md-9";
				$custom_height = 390;
			} else if ( isset( $cs_layout ) && $cs_layout == "sidebar_right" ) {
				$cs_layout = "content-left col-md-9";
				$custom_height = 390;
			} else {
				$cs_layout = "col-md-12";
				$custom_height = 390;
			}
			$cs_sidebar	= $cs_theme_options['cs_default_layout_sidebar'];
			$cs_tags_name = 'post_tag';
			$cs_categories_name = 'category';
 	?>
	<!-- PageSection Start -->
        <section class="page-section" style=" padding: 0; ">
            <!-- Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <!--Left Sidebar Starts-->
                    <?php if ($cs_layout == 'content-right col-md-9'){ ?>
                        <div class="content-lt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar) ) : ?><?php endif; ?></div>
                    <?php } ?>
                    <!--Left Sidebar End-->
                    <!-- Page Detail Start -->
                    <div class="<?php echo esc_attr($cs_layout); ?>">
    
                    <!-- Blog Post Start -->
                     <?php 
                     if(is_author()){
                         global $author;
                         $userdata = get_userdata($author);
                     }
                     if(category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))){
                        echo '<div class="widget evorgnizer">';
                        if(is_author()){?>
                                <figure><a><?php echo get_avatar($userdata->user_email, apply_filters('PixFill_author_bio_avatar_size', 70));?></a></figure>
                                <div class="left-sp">
                                    <h5><a><?php echo esc_attr($userdata->display_name); ?></a></h5>
                                    <p><?php echo esc_attr($userdata->description); ?></p>
                                </div>
                        <?php } elseif ( is_category()) {
                                $category_description = category_description();
                                if ( ! empty( $category_description ) ) {
                                ?>
                                <div class="left-sp">
                                    <p><?php  echo category_description();?></p>
                                </div>
                               <?php }?>
                        <?php } elseif(is_tag()){  
                                $tag_description = tag_description();
                                if ( ! empty( $tag_description ) ) {
                                ?>
                                <div class="left-sp">
                                    <p><?php echo apply_filters( 'tag_archive_meta', $tag_description );?></p>
                                </div>
                            <?php }
                        }
                        echo '</div>';
                    }
                        if (empty($_GET['page_id_all']))
                            $_GET['page_id_all'] = 1;
                        if (!isset($_GET["s"])) {
                            $_GET["s"] = '';
                        }
                        $taxonomy = 'category';
                        $taxonomy_tag = 'post_tag';
                        $args_cat = array();
                        if(is_author()){
                            $args_cat = array('author' => $wp_query->query_vars['author']);
                            $post_type = array( 'courses');
                        } elseif(is_date()){
                            if(is_month() || is_year() || is_day() || is_time()){
                                $args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
                            }
                            $post_type = array( 'courses');
                        } else if ( isset( $wp_query->query_vars['taxonomy']) && !empty( $wp_query->query_vars['taxonomy'] ) ) {
                            $taxonomy = $wp_query->query_vars['taxonomy'];
                            $taxonomy_category='';
                            $taxonomy_category=$wp_query->query_vars[$taxonomy];
                            if ( $wp_query->query_vars['taxonomy']=='course-category' || $wp_query->query_vars['taxonomy']=='course-tag') {
                              $args_cat = array( $taxonomy => "$taxonomy_category");
                              $post_type='courses';
                            } else {
                                $taxonomy = 'category';
                                $args_cat = array();
                                $post_type='post';
                            }
                        } else if( is_category() ) {
                            
                            $taxonomy = 'category';
                            $args_cat = array();
                            $category_blog = $wp_query->query_vars['cat'];
                            $post_type='post';
                            $args_cat = array( 'cat' => "$category_blog");
                        
                        } else if ( is_tag() ) {
                            
                            $taxonomy = 'category';
                            $args_cat = array();
                            $tag_blog = $wp_query->query_vars['tag'];
                            $post_type='post';
                            $args_cat = array( 'tag' => "$tag_blog");
                        
                        } else {
                            $taxonomy = 'category';
                            $args_cat = array();
                            $post_type='post';
                        }
                        
                        $args = array( 
                        'post_type'		 => $post_type, 
                        'paged'			 => $_GET['page_id_all'],
                        'post_status'	 => 'publish', 
                        'order'			 => 'ASC',
                    );
    
                    $args = array_merge( $args_cat,$args );
                    $custom_query = new WP_Query( $args );
                     ?>
                    <?php if ( $custom_query->have_posts() ):
                        while ( $custom_query->have_posts() ) : $custom_query->the_post();
                        $cs_course = get_post_meta($post->ID, "cs_course", true);
                        $course_id = $course_post_id = $post->ID;
                          if ( $cs_course <> "" ) {
                              $cs_xmlObject = new SimpleXMLElement($cs_course);
                              //$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
                            
                              $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
                          }
                          else{
                              $var_cp_course_product = $var_cp_course_paid = '';
                          }
                        $image_url = cs_attachment_image_src(get_post_thumbnail_id( $post->ID), 370, 278 );
                        $post_class = '';
                         if($image_url == ''){
                          $post_class = ' no-image';
                          $image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
                         }
                        $event_from_date = get_post_meta( $post->ID, "cs_event_from_date", true ); 
                        $applyNowButton	= get_the_permalink(); 
                        ?> 
                        <div class="col-md-4">
                            <article class="cs-list list_v1 img_position_top has_border post-<?php the_ID(); ?>">
                               <!-- BLog Inn -->
                               
                                  <?php if($image_url <> ""){ ?>
                                    <figure> 
                                             <?php 
                                                    $user = cs_get_user_id();
                                                    $cs_wishlist = array();
                                                    $cs_wishlist =  get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
                                                    if (!is_user_logged_in() ) { 
                                                        echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">'.__('Login','LMS').'</a>';
    
                                                    }elseif(isset($user) and $user<>''){
                                                        $cs_wishlist = get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
                                                        if(is_array($cs_wishlist) && in_array($post->ID,$cs_wishlist)){
                                                            echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>'.__('Already Favourite','LMS').'</a>';
                                                         }else{
                                                        ?>
                                                            <a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_url(admin_url('admin-ajax.php'));?>','<?php echo absint($post->ID);?>','post')">
                                                                <i class="fa fa-heart"></i> 
                                                            <?php  _e('Add to Favourite','LMS');?>
                                                            </a>
                                                    <?php } } ?>
                                                <a href="<?php the_permalink();?>" ><img src="<?php echo esc_url($image_url);?>" alt="" ></a>
                                        
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
                                                        <ul>
                                                            <?php 
                                                             if ( function_exists( 'cs_get_course_price' ) ) { cs_get_course_price($course_post_id, $var_cp_course_paid); }
                                                            ?>	
                                                        </ul>
                                                </div>
                                               <a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php
                                                        global $cs_theme_options,$wpdb;
                                                        _e('Apply Now','LMS');?>															 
                                                </a>                                                                                                                                                                 		
                                          </div>
                                  <!-- Text Start -->
                         
                      </article>
                        </div>
                            
                    <?php endwhile; 
                    else:
                        if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(); }
                    endif;  
                         $qrystr = '';
                        // pagination start
						if ($custom_query->found_posts > get_option('posts_per_page')) {
							 if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".absint($_GET['page_id']);
							 if ( isset($_GET['author']) ) $qrystr .= "&author=".esc_attr($_GET['author']);
							 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".esc_attr($_GET['tag']);
							 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".esc_attr($_GET['cat']);
							 if ( isset($_GET['course-category']) ) $qrystr .= "&course-category=".esc_attr($_GET['course-category']);
							 if ( isset($_GET['course-tag']) ) $qrystr .= "&course-tag=".esc_attr($_GET['course-tag']);
							 if ( isset($_GET['m']) ) $qrystr .= "&m=".esc_attr($_GET['m']);
							 
							 if ( function_exists( 'cs_pagination' ) ) {  echo cs_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr); }
									
						}
                    ?>
               </div>
                    <!-- Page Detail End -->
                    <!-- Right Sidebar Start -->
                    <?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
                       <div class="content-rt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar) ) : ?><?php endif; ?></div>
                    <?php } ?>
                    <!-- Right Sidebar End -->
              </div>
            </div>
         </section>
<?php get_footer(); ?>  