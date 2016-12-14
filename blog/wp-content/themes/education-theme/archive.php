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
						$post_type = array( 'post', 'cs-events');
					} elseif(is_date()){
						if(is_month() || is_year() || is_day() || is_time()){
							$args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
						}
						$post_type = array( 'post');
					} else if ( isset( $wp_query->query_vars['taxonomy']) && !empty( $wp_query->query_vars['taxonomy'] ) ) {
						$taxonomy = $wp_query->query_vars['taxonomy'];
						$taxonomy_category='';
						$taxonomy_category=$wp_query->query_vars[$taxonomy];
						if ( $wp_query->query_vars['taxonomy']=='events-categories' || $wp_query->query_vars['taxonomy']=='events-tags') {
						  $args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='cs-events';
						} else if ( $wp_query->query_vars['taxonomy']=='course-category' || $wp_query->query_vars['taxonomy']=='course-tag') {
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
					'ignore_sticky_posts' => 1,
					'order'			 => 'ASC',

				);
				
				$args = array_merge( $args_cat,$args );
				
				
				$custom_query = new WP_Query( $args );
                 ?>
                <?php if ( $custom_query->have_posts() ): ?>
	            <?php
				    while ( $custom_query->have_posts() ) : $custom_query->the_post();
					$image_url = cs_attachment_image_src(get_post_thumbnail_id( $post->ID), 370, 278 );
					$post_class = '';
					 if($image_url == ''){
					  $post_class = ' no-image';
					 }
 						$event_from_date = get_post_meta( $post->ID, "cs_event_from_date", true );  
					?> 
                    <div class="col-md-12">
						<article class="cs-blog blog-medium blog-small" id="post-<?php the_ID(); ?>">
                           <!-- BLog Inn -->
                           <div class="blog-inn">
							  <?php if($image_url <> ""){ ?>
							 	<figure> <a href="<?php the_permalink();?>" ><img src="<?php echo esc_url($image_url);?>" alt="" ></a>
                                	<a class="blog-hover" href="<?php the_permalink();?>"><i></i></a>
                                </figure>
                               <?php }?>
                              <!-- Text Start -->
                              <section class="bloginfo">
                                  <ul class="post-option">
                                        <li><?php  _e('Posted On','LMS');?><?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></li>
                                        <li><?php _e('By','LMS');?><a class="cs-color" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a> </li>
                                   </ul>
                                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                  <p><?php if ( function_exists( 'cs_get_the_excerpt' ) ) { echo cs_get_the_excerpt($default_excerpt_length,false,''); } ?></p>
                            
                                  <div class="blog-bottom">
                                  		<ul class="blog-left">
                                            <li>
                                                <a>
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo cs_get_post_views(get_the_ID()); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                               <a href="<?php comments_link(); ?>"><span class="counter">
                                                <?php  echo comments_number(__('0', 'LMS'), __('1', 'LMS'), __('%', 'LMS') );?>
                                                </span><i class="fa fa-comment-o"></i></a>
                                            </li>
                                            <li> <?php cs_like_counter('');?> </li>
                                            <li>
                                                <?php cs_addthis_script_init_method();?>
                                                <a class="btnshare addthis_button_compact"><i class="fa fa-share-alt"></i></a>
                                           </li>
                                        </ul>
                                        <div class="blog-right">
                                        	<a class="custom-btn" href="<?php the_permalink()?>"> 
											<?php  _e('read more','LMS');?></a>  
                                        </div>    
                                </div>
                              </section>
                      </div>
                  </article>
                  	</div>
						
                <?php endwhile; 
				else:
					if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(); }
				endif;  
				?>
        		
                <?php
					 $qrystr = '';
					// pagination start
						if ($custom_query->found_posts > get_option('posts_per_page')) {
						 if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".absint($_GET['page_id']);
						 if ( isset($_GET['author']) ) $qrystr .= "&author=".esc_attr($_GET['author']);
						 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".esc_attr($_GET['tag']);
						 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".esc_attr($_GET['cat']);
						 if ( isset($_GET['events-categories']) ) $qrystr .= "&events-categories=".esc_attr($_GET['events-categories']);
						 if ( isset($_GET['events-tags']) ) $qrystr .= "&events-tags=".esc_attr($_GET['events-tags']);
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