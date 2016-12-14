<?php
/**
 * The template for Home page
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 
 get_header();
 global $cs_node,$cs_theme_options,$cs_counter_node;

	if(isset($cs_theme_options['cs_excerpt_length']) && $cs_theme_options['cs_excerpt_length'] <> ''){ $default_excerpt_length = $cs_theme_options['cs_excerpt_length']; }else{ $default_excerpt_length = '255';}; 
			
	$cs_layout 	=  $cs_theme_options['cs_default_page_layout'];
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
       <section class="page-section" style="padding:0;">
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
					<?php if ( have_posts() ) : ?>
                    <?php /* The loop */
                       if (empty($_GET['page_id_all']))
                              $_GET['page_id_all'] = 1;
                          if (!isset($_GET["s"])) {
                              $_GET["s"] = '';
                          }
                    
					while ( have_posts() ) : the_post(); 
                    $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 260, 194);
                    $post_class = '';
                    if($image_url == ''){
                    	$post_class = ' no-image';
                    }
                    
                     ?>
                     <article <?php post_class('cs-blog blog-medium'); ?> id="post-<?php the_ID(); ?>">
                            <?php if($image_url <> ""){ echo '<figure> <a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a></figure>';} ?>
                             <!-- Text Start -->
                             <section class="bloginfo">
                                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                  <ul class="post-option">
                                  		<?php if(is_sticky()){?>
                                        <li><i class="fa fa-thumb-tack"></i><?php _e('Featured','LMS');?></li>
                                        <?php }?>
                                        <li> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><i class="fa fa-user"></i><?php echo get_the_author();?></a> </li>
                                        <li><?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></li>
                                        <li>
                                           <?php 
                                              $before_cat = "<a href=''>";
                                              $categories_list = get_the_term_list ( get_the_id(), strtolower($cs_categories_name), $before_cat, ', ', '</a>' );
                                              if ( $categories_list ){
                                                  printf( __( '%1$s', 'LMS'),$categories_list );
                                              }
                                          ?>
                                        </li>
                                   </ul>
                                  <p><?php if ( function_exists( 'cs_get_the_excerpt' ) ) { echo cs_get_the_excerpt($default_excerpt_length,false);  }?></p>
                                  <div class="blog-bottom">
                                    <div class="blog-right">
                                        <a class="custom-btn" href="<?php the_permalink()?>"> 
											<?php  _e('read more','LMS');?>
                                         </a>
                                    </div>       
                                </div>
                              </section>
                            <!-- Text End --> 
                     </article>
                    <?php 
                        endwhile; 
                    else:
                         if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(); }
                    endif; 
                    ?>
                    
					<?php
                        $qrystr = '';
                        if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
						if (isset($cs_theme_options['pagination']) and $cs_theme_options['pagination'] == "Show Pagination" and $wp_query->found_posts > get_option('posts_per_page')) {
						   if ( function_exists( 'cs_pagination' ) ) { echo cs_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr); } 
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
<?php 

	

get_footer(); ?>