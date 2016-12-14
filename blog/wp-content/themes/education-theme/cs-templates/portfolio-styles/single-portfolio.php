<?php
/**
 * The template for displaying all Single Courses
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */

    get_header();
	global $post,$node,$cs_theme_options,$cs_xmlObject;
 	$cs_layout = '';
?>
<section class="page-section" style="padding: 0px;">
	<!-- Container -->
	<div class="container">
		<!-- Row -->
		<div class="row">

	<?php
		if ( have_posts() ) while ( have_posts() ) : the_post();
		$post_xml = get_post_meta($post->ID,"dynamic_cusotm_post", true);
		
		if ( $post_xml <> "" ) {
			
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				
				$cs_layout = $cs_xmlObject->sidebar_layout->cs_page_layout;
				
				$cs_sidebar_left = (string)$cs_xmlObject->sidebar_layout->cs_page_sidebar_left;
				
				$cs_sidebar_right = (string)$cs_xmlObject->sidebar_layout->cs_page_sidebar_right;
				
				$dynamic_post_lms_project_client = $cs_xmlObject->dynamic_post_lms_project_client;
				
				$dynamic_post_lms_project_skills = $cs_xmlObject->dynamic_post_lms_project_skills;
				
				$dynamic_post_lms_project_software = $cs_xmlObject->dynamic_post_lms_project_software;
				
				$post_pagination_show = $cs_xmlObject->cs_post_pagination_show;
				
				$cs_post_tags_show = $cs_xmlObject->cs_post_tags_show;
				
				$cs_related_post = $cs_xmlObject->cs_related_post;
								
				$dynamic_post_lms_project_url = $cs_xmlObject->dynamic_post_lms_project_url;
				
				
				if ( $cs_layout == "left") {
					$cs_layout = "content-right col-md-9";
				}
				else if ( $cs_layout == "right" ) {
					$cs_layout = "content-left col-md-9";
				}
				else {
					$cs_layout = "";
				}
						
				$image_url = cs_get_post_img_src($post->ID, '860', '418');
				var_dump($image_url);
			} else {
				$dynamic_post_lms_project_client = $dynamic_post_lms_project_skills = $dynamic_post_lms_project_software = $dynamic_post_lms_project_url = $image_url='';
				$post_pagination_show = 'off';
			}
		
			if ($cs_layout == 'content-right col-md-9'){
			?>
                <div class="content-lt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : endif; ?></div>
            <?php } ?>
            
            <?php
			if($cs_layout <> ''){
			?>
            <div class="<?php echo esc_attr($cs_layout); ?>">
            <?php
			}
			?>
                
            <?php
                if($image_url<>''){?>
                    <!-- PortfolioPage Start -->
                    <figure class="post-detail col-md-12">
                        <a href=""><img src="<?php echo esc_url($image_url); ?>" alt=""></a>
                    </figure>
            <?php } ?>
           
            
            <?php the_content(); ?>
               
            <div class="col-md-4">
                 <div class="project-detail">
                     <h2><?php _e('Project Detail','LMS');?></h2>
                      <div class="project">
                      	<ul>
                          <?php if($dynamic_post_lms_project_client<>''){ ?>
                              <li>
                                  <span><?php _e('Client','LMS');?></span>
                                  <a href="#"><?php echo esc_attr($dynamic_post_lms_project_client); ?></a>
                              </li>
                          <?php } ?>
                               <li>
                                   <span><?php _e('Categories','LMS');?></span>
                                     <?php 
                                          $before_cat = "";
                                          $categories_list = get_the_term_list ( get_the_id(), 'portfolio-categories', $before_cat,', ', '' );
                                          if ( $categories_list ){
                                              printf( __( '%1$s', 'LMS'),$categories_list );
                                          }
                                      ?>
                               </li>
                            <?php 	if($dynamic_post_lms_project_software<>''){ ?>
                                <li>
                                    <span><?php _e('Software Used','LMS');?></span>
                                    <a href="#"><?php echo esc_attr($dynamic_post_lms_project_software); ?> </a>
                                </li>
                            <?php }
                                    if($dynamic_post_lms_project_url<>''){ 
                                ?>
                                <li>
                                    <span><?php _e('Project Url','LMS');?></span>
                                    <a href="<?php echo esc_url($dynamic_post_lms_project_url); ?>"><?php echo esc_attr($dynamic_post_lms_project_url); ?></a>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php if(isset($post_pagination_show) &&  $post_pagination_show == 'on'){
                        $previd = $nextid = '';
						$post_type = get_post_type($post->ID);
						$count_posts = wp_count_posts( "$post_type" )->publish;
						$px_postlist_args = array(
						   'posts_per_page'  => -1,
						   'order'           => 'ASC',
						   'post_type'       => "$post_type",
						); 
						$px_postlist = get_posts( $px_postlist_args );
						$ids = array();
						foreach ($px_postlist as $px_thepost) {
						   $ids[] = $px_thepost->ID;
						}
						$thisindex = array_search($post->ID, $ids);
						if(isset($ids[$thisindex-1])){
							$previd = $ids[$thisindex-1];
						} 
						if(isset($ids[$thisindex+1])){
							$nextid = $ids[$thisindex+1];
						} 
						echo '<div class="col-md-12"><div class="postbtn">';
						if (isset($previd) && !empty($previd) && $previd >=0 ) {
						   ?>
                            
                        	<a class="prevbtn" href="<?php echo get_permalink((int)$previd); ?>"><i class="fa fa-angle-left"></i><?php _e('Previous Post','LMS'); ?></a>
                        <?php
						}
				
						if (isset($nextid) && !empty($nextid) ) {
							?>
                            
                        	<a class="nextbtn" href="<?php echo get_permalink((int)$nextid); ?>"><?php _e('Next Post','LMS'); ?><i class="fa fa-angle-right"></i></a>
                        <?php	
						}
						echo '</div></div>';
					 wp_reset_query();
                }
          	?>
            
            <?php if(isset($cs_post_tags_show) &&  $cs_post_tags_show == 'on'){
					  
						$categories_list = get_the_term_list ( get_the_id(), 'portfolio-tags', '', ', ', '' );
						  if ( $categories_list ){?>
                          <div class="col-md-12">
						  <i class="fa fa-bookmark"></i>
						  <?php printf( __( '%1$s', 'LMS'),$categories_list );
						  echo '</div>';
						  }
            }
            ?>
			
            <?php 
			if(isset($cs_related_post) &&  $cs_related_post == 'on'){
			if ( empty($cs_xmlObject->cs_related_post_title) ) $cs_related_post_title = __('Related Posts', 'LMS'); else $cs_related_post_title = $cs_xmlObject->cs_related_post_title;
				  $custom_taxterms = wp_get_object_terms( $post->ID, array('portfolio-categories', 'portfolio-tags'), array('fields' => 'ids') );
				  $args = array(
					  'post_type' => 'portfolio',
					  'post_status' => 'publish',
					  'posts_per_page' => 4,
					  'orderby' => 'DESC',
					  'tax_query' => array(
						  'relation' => 'OR',
						  array(
							  'taxonomy' => 'portfolio-tags',
							  'field' => 'id',
							  'terms' => $custom_taxterms
						  ),
						  array(
							  'taxonomy' => 'portfolio-categories',
							  'field' => 'id',
							  'terms' => $custom_taxterms
						  )
					  ),
					  'post__not_in' => array ($post->ID),
				  );
				 $custom_query = new WP_Query($args);
				 if($custom_query->have_posts()):
				 ?>
                 <div class="col-md-12">
                 <div class="cs-section-title">
                    <h2><?php echo esc_attr($cs_related_post_title);?></h2>
                 </div>
                 <div class="portfoliopage">
				 <ul class="image-grid">
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();
						
						global $post;
						$image_id = get_post_thumbnail_id($post->ID);
						if($image_id <> ''){
							$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 370, 278);
							$full_image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 0, 0);
						}else{
							$image_url = get_template_directory_uri().'/assets/images/no-image4x3.jpg';
							$full_image_url = get_template_directory_uri().'/assets/images/no-image4x3.jpg';
						}
						?>
                        <li>
                            <!-- Article Start -->
                            <article>
                            	<?php if($image_url <> ''){ ?>
                                <figure><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>" alt=""></a>
                                <?php } ?>
                                    <figcaption>
                                        <div class="figinn lightbox">
                                            <a data-rel="prettyPhoto" href="<?php echo esc_url($full_image_url);?>" class="fa fa-search-plus"></a>
                                            <a href="<?php the_permalink(); ?>" class="fa fa-link"></a>
                                        </div>
                                    </figcaption>
                                </figure>
                                <div class="text">
                                    <h2><a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(), 0, 28); echo strlen(get_the_title()) > 28 ? '...' : ''; ?></a></h2>
                                    <?php echo get_the_term_list ( $post->ID, 'portfolio-categories', '<span><i class="fa fa-plus"></i>', ', ', '</span>' ); ?>
                                    
                                </div>
                            </article>
                            <!-- Article End -->
                        </li>
				 <?php endwhile;
				 wp_reset_postdata(); ?>
			</ul>
            </div>
            </div>
            <?php
			endif;
			}
			?>
		<?php
		if($cs_layout <> ''){
		?>
		</div>
        <?php
		}
	endwhile;
	
	 if ( $cs_layout  == 'content-left col-md-9'){ 
	 	?>
            <div class="content-rt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) :  endif; ?></div>
        <?php } ?>
    
		</div>
	</div>
</section>
 <?php get_footer(); ?>