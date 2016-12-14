<?php
/**
 * The template for displaying Search Result
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	get_header();
	global  $cs_theme_options; 
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
	if(!isset($GET['page_id'])) $GET['page_id_all']=1;
	
	global $wp_query;
	?>
    <section class="page-section" style=" padding:0; ">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">        
			<?php if ($cs_layout == 'content-right col-md-9'){ ?>
                <div class="content-lt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar) ) : ?><?php endif; ?></div>
            <?php } ?>
            	
   			<div class="<?php echo esc_attr($cs_layout); ?>">
              <div class="search-title"><h2><?php _e('Showing result for "'.get_search_query().'"','LMS'); ?></h2></div>
              
			
         	<!-- Blog Post Start -->
             <?php
			 	if(isset($_REQUEST['post_type']) and $_REQUEST['post_type']=='courses'){
					
			 	$sort = '';
 				$args = array(
                	'post_type'			=> sanitize_text_field($_REQUEST['post_type']),
					'posts_per_page'    => '-1',
                	's'					=> sanitize_text_field($_REQUEST['s']),
					'course-category'	=> sanitize_text_field($_REQUEST['course_cat']),
                  );
  				
				$custom_query = new WP_Query($args);
				$post_count = $custom_query->post_count;
				$sort = '';
				$cs_courses_orderby = 'ASC';
				
				if(isset($_GET['sort']) and $_GET['sort'] <> '' ){ $sort = sanitize_text_field($_GET['sort']); }
				if($sort=='alphabetical'){
					
					$args = array('orderby'=> 'title',);
					
				}elseif($sort=='members'){
					
					$args = array('meta_key'=> 'var_cp_course_members','orderby'=> 'meta_value_num',);
				
				}elseif($sort=='rating'){
					
					$args = array('meta_key' => 'cs_course_review_rating','orderby' => 'meta_value',);
				
				}else{
					$args = array(
						//'post_type'			=> $_REQUEST['post_type'],
						//'posts_per_page'    => '2',
						 'orderby' => 'date',
						//'course-category'	=> $_REQUEST['course_cat'],
						//'paged'				=> $GET['page_id_all']
					 );
				}
				$course_array = array('s'=> sanitize_text_field($_REQUEST['s']),'course-category' => $_REQUEST['course_cat'],'posts_per_page'=> get_option('posts_per_page'),'paged'=> $_GET['page_id_all'],'post_type'=> 'courses','post_status'=> 'publish','order' => $cs_courses_orderby);
				$args = array_merge($args, $course_array);
                //query_posts($args);
				
				$custom_query = new WP_Query($args);
 				if ( $custom_query->have_posts() ):
					global $post;
					while ( $custom_query->have_posts() ) : $custom_query->the_post();
						if( function_exists('cs_course_search_func')){
							cs_course_search_func(get_the_ID());
						}
					endwhile;
				  else:
				  		fnc_no_result_found();
				endif;
				}else{
  			    if ( have_posts() ) : 
                     while ( have_posts() ) : the_post();
                       $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 260, 194);	
                        $post_class = '';
                         if($image_url == ''){
                          $post_class = ' no-image';
                         }
                            
                     ?>	
                        <article class="cs-blog blog-medium serach-result" id="post-<?php the_ID(); ?>">
                            <div class="blog-inn">
                            	<section class="bloginfo">
                                   <ul class="post-option">
                                        <li>
											<?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?>
											<?php  echo cs_get_the_excerpt('50',false);?>
                                        </li>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></li>
                                   </ul>
                                  </section>
                            </div>			   
                         </article>
                    <?php  
                    endwhile;   
                else:
                    fnc_no_result_found(); 
                endif;
			}
                 $qrystr = '';
				if(isset($_REQUEST['post_type']) and $_REQUEST['post_type']=='courses'){
					if ( isset($_GET['s']) ) $qrystr = "&amp;s=".sanitize_text_field($_REQUEST['s'])."&amp;course_cat=".esc_attr($_REQUEST['course_cat'])."&amp;sort=".esc_attr($_REQUEST['sort'])."&amp;post_type=".esc_attr($_REQUEST['post_type']);
                        if ( isset($_GET['page_id']) ) $qrystr .= "&amp;page_id=".$_GET['page_id'];
                        echo cs_pagination($post_count, get_option('posts_per_page'), $qrystr);
				}elseif ($wp_query->found_posts > get_option('posts_per_page')) {
                        if ( isset($_GET['s']) ) $qrystr = "&amp;s=".sanitize_text_field($_GET['s']);
                        if ( isset($_GET['page_id']) ) $qrystr .= "&amp;page_id=".absint($_GET['page_id']);
                        echo cs_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
                }
            ?>  
           </div>                  
			
			<?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
               <div class="content-rt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar) ) : ?><?php endif; ?></div>
            <?php } ?> 
        </div>
      </div>
   </section>
<?php 

get_footer();
?>
<!-- Columns End -->