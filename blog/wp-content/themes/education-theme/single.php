        <?php
/**
 * The template for displaying all single posts
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	cs_slider_gallery_template_redirect();
	global $cs_node,$post,$cs_theme_options,$cs_counter_node;
	
	$cs_uniq = rand(40, 9999999);
	if ( is_single() ) {
		cs_set_post_views($post->ID);
	}
		
	$cs_node = new stdClass();
  	get_header();
 	$cs_layout = '';
	$leftSidebarFlag	= false;
	$rightSidebarFlag	= false;
	?>
<!-- PageSection Start -->

<section class="page-section" style=" padding: 0; "> 
  <!-- Container -->
  <div class="container"> 
    <!-- Row -->
    <div class="row">
      <?php
	if (have_posts()):
		while (have_posts()) : the_post();	
		$cs_tags_name = 'post_tag';
		$cs_categories_name = 'category';
		$postname = 'post';
		$image_url = cs_get_post_img_src($post->ID, 860, 418);	

		$post_xml = get_post_meta($post->ID, "post", true);	
			if ( $post_xml <> "" ) {
			
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$cs_layout 			= $cs_xmlObject->sidebar_layout->cs_page_layout;
				$cs_sidebar_left 	= $cs_xmlObject->sidebar_layout->cs_page_sidebar_left;
				$cs_sidebar_right   = $cs_xmlObject->sidebar_layout->cs_page_sidebar_right;
				if(isset($cs_xmlObject->cs_related_post))
					$cs_related_post = $cs_xmlObject->cs_related_post;
				else 
					$cs_related_post = '';
				
				if(isset($cs_xmlObject->cs_post_tags_show))
					$post_tags_show = $cs_xmlObject->cs_post_tags_show;
				else 
					$post_tags_show = '';
				
				if(isset($cs_xmlObject->post_social_sharing))
					$cs_post_social_sharing = $cs_xmlObject->post_social_sharing;
				else 
					$cs_post_social_sharing = '';
				
				if(isset($cs_xmlObject->cs_post_author_info_show))
					 $cs_post_author_info_show = $cs_xmlObject->cs_post_author_info_show;
				else 
					$cs_post_author_info_show = '';

				if ( $cs_layout == "left") {
					$cs_layout = "page-content blog-editor";
					$custom_height = 408;
					$leftSidebarFlag	= true;
				}
				else if ( $cs_layout == "right" ) {
					$cs_layout = "page-content blog-editor";
					$custom_height = 408;
					$rightSidebarFlag	= true;
				}
				else {
					$cs_layout = "col-md-12";
					$custom_height = 408;
				}
				$postname = 'post';
			}else{
				$cs_layout = isset($cs_theme_options['cs_single_post_layout']) ? $cs_theme_options['cs_single_post_layout']  : '';
				if ( isset( $cs_layout ) && $cs_layout == "sidebar_left") {
					$cs_layout = "page-content blog-editor";
					$cs_sidebar_left	= $cs_theme_options['cs_single_layout_sidebar'];
					$custom_height = 408;
					$leftSidebarFlag	= true;
				} else if ( isset( $cs_layout ) && $cs_layout == "sidebar_right" ) {
					$cs_layout = "page-content blog-editor";
					$cs_sidebar_right	= $cs_theme_options['cs_single_layout_sidebar'];
					$custom_height = 408;
					$rightSidebarFlag	= true;
				} else {
					$cs_layout = "col-md-12";
					$custom_height = 408;
				}
  				$post_pagination_show = 'on';
				$post_tags_show = '';
				$cs_related_post = '';
				$post_social_sharing = '';
				$post_social_sharing = '';
				$cs_post_author_info_show = '';
				$postname = 'post';
				$cs_post_social_sharing = '';
			}
			if ($post_xml <> "") {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$post_view = $cs_xmlObject->post_thumb_view;
				$inside_post_view = $cs_xmlObject->inside_post_thumb_view;
				$post_video = $cs_xmlObject->inside_post_thumb_video;
				$post_audio = $cs_xmlObject->inside_post_thumb_audio;
				$post_slider = $cs_xmlObject->inside_post_thumb_slider;
				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$cs_related_post = $cs_xmlObject->cs_related_post;
				$cs_post_social_sharing = $cs_xmlObject->post_social_sharing;
				$post_tags_show = $cs_xmlObject->post_tags_show;
				$post_pagination_show = $cs_xmlObject->post_pagination_show;
				$cs_post_author_info_show = $cs_xmlObject->post_author_info_show;
				$postname = 'post';
				
			}
			else {
				$cs_xmlObject = new stdClass();
				$post_view = '';
				$post_video = '';
				$post_audio = '';
				$post_slider = '';
				$post_slider_type = '';
				$cs_related_post = '';
				$post_pagination_show = '';
				$image_url = '';
				$width = 0;
				$height = 0;
				$image_id = 0;
				$cs_post_author_info_show = '';
				$postname = 'post';
				
				$cs_xmlObject->post_social_sharing = '';
			}		
			
		if( $leftSidebarFlag == false && $rightSidebarFlag == false ) {
			$cs_layout = isset($cs_theme_options['cs_single_post_layout']) ? $cs_theme_options['cs_single_post_layout'] : '';
			if ( isset( $cs_layout ) && $cs_layout == "sidebar_left") {
				$cs_layout = "page-content blog-editor";
				$cs_sidebar_left	= $cs_theme_options['cs_single_layout_sidebar'];
				$custom_height = 408;
				$leftSidebarFlag	= true;
			} else if ( isset( $cs_layout ) && $cs_layout == "sidebar_right" ) {
				$cs_layout = "page-content blog-editor";
				$cs_sidebar_right	= $cs_theme_options['cs_single_layout_sidebar'];
				$custom_height = 408;
				$rightSidebarFlag	= true;
			}
		}
		
		$custom_height = 408;	
		$width = 860;
		$height = 418;
		$image_url = cs_get_post_img_src((int)$post->ID, $width, $height);
		?>
      <!--Left Sidebar Starts-->
      <?php if ($leftSidebarFlag == true){ ?>
      <aside class="page-sidebar">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?>
        <?php endif; ?>
      </aside>
      <?php } ?>
      <!--Left Sidebar End--> 
      
      <!-- Blog Detail Start -->
      <div class="<?php echo esc_attr($cs_layout); ?>"> 
        <!-- Blog Start --> 
        <!-- Row -->
 		 	<?php 
				if (isset($inside_post_view) and $inside_post_view <> '') {
					if( $inside_post_view == "Slider"){
						echo '<div class="col-md-12"><figure class="detail_figure">';
							cs_post_flex_slider($width,$height,get_the_id(),'post');
						echo '</figure></div>';
					} else if ($inside_post_view == "Single Image" && $image_url <> '') { 
						echo '<div class="col-md-12"><figure class="detailpost">';
							echo '<img src="'.$image_url.'" alt="" >';
						echo '</figure></div>';
					} elseif ( $inside_post_view == "Video" and $post_video <> '' and $inside_post_view <> '' ) {
					   	$url = parse_url($post_video);
					   	if($url['host'] == $_SERVER["SERVER_NAME"]) {?>
							<div class="col-md-12">
                            	<video width="<?php echo esc_attr($width);?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo esc_aurl($post_video) ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo esc_url($image_url); } ?>" controls preload="none"></video>
                            </div>
					<?php
					  } else {
							echo '<div class="col-md-12">';
							$video	= wp_oembed_get($post_video,array('height' => $custom_height));
							$search = array('webkitallowfullscreen', 'mozallowfullscreen', 'frameborder="0"');
							echo  str_replace($search,'',$video);
							echo '</div>';
					  }
 				} elseif ($inside_post_view == "Audio" and $inside_post_view <> ''){  
					cs_media_element();
				?>
                    <div class="col-md-12">
                        <figure class="detail_figure">
                          <audio  type="audio/mp3" controls width="100%">
                            <source src="<?php echo esc_url($post_audio); ?>" type="audio/mpeg">
                          </audio>
                        </figure>
                   </div>
            <?php    
				}
            }
			?>
          <!-- Post Content Start-->
          <div class="col-md-12">
            <!-- Title Start-->
            <h2><?php the_title();?></h2>
            <!-- Title End-->
            <!-- Autehr Start-->
            <div class="post-option-panel">
              	<div class="cs-thumb">
                  <?php 
				  	global $current_user;
					$custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
					$size = 50;
					if(isset($custom_image_url) && $custom_image_url <> '') {
						  echo '<img src="'.esc_url($custom_image_url).'" class="avatar photo" id="upload_media" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($current_user->display_name) .'" />';
						  
					} else {
						?>
					  <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
						<?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?>
						
					</a>
					<?php 
					}
				  ?>
                  </div>
                <ul class="post-options">
                  <li>
                    <time datetime="<?php echo date_i18n('Y-m-d', strtotime(get_the_date()));?>">
						<?php _e('Posted On','LMS');?>
						<?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?>
                        
                    </time>
                  	<span><?php _e(' By','LMS');?> <a class="cs-color" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author();?></a></span>
                  </li>
                  <li>
                    <?php _e(' Posted In','LMS');?>
                    <?php 
						$before_cat = "";
 						$categories_list = get_the_term_list ( get_the_id(), strtolower($cs_categories_name), $before_cat,', ', '' );
						if ( $categories_list ){
							printf( __( '%1$s', 'LMS'),$categories_list );
						}
					?>
                  </li>
                </ul>
                <ul class="cs-views-area">
                  <li class="cs-likes">
                    <?php
					
					 $cs_likes_title = __('Likes','LMS');
					cs_like_counter($cs_likes_title);
					?>
                  </li>
                </ul>
              </div>
            <!-- Autehr End-->
              
            <div class="rich_editor_text blog-editor"> 
              <?php the_content();?>
            </div>
          </div>
          <!-- Post Content End--> 
          
          <!-- Col Tags Start -->
          <?php if(isset($post_tags_show) &&  $post_tags_show == 'on'){ ?>
          <div class="col-md-12">
            <div class="content_tag">
              <?php  
			  if ( empty($cs_xmlObject->post_tags_show_text) ) $post_tags_show_text = __('Tags', 'LMS'); else $post_tags_show_text = $cs_xmlObject->post_tags_show_text;
					  $categories_list = get_the_term_list ( get_the_id(), 'post_tag', '', ', ', '' );
					  if ( $categories_list ){?>
                      <i class="fa fa-bookmark"></i>
                     
                      <?php printf( __( '%1$s', 'LMS'),$categories_list );
				  }
			?>
            </div>
          </div>
          <?php }?>
          <!-- Col Tags End --> 
          
          <!-- Col Share & Show All Start -->
          <div class="col-md-12"> 
            <!-- SharePost -->
            <div class="cs-share-post-section">
            	<?php  
			  		if ($cs_post_social_sharing == "on"){
						if ( empty($cs_xmlObject->post_social_sharing_text) ) 
					   	$post_social_sharing_text = __('Share', 'LMS'); else $post_social_sharing_text = $cs_xmlObject->post_social_sharing_text;
                       	cs_social_share(false,true,$post_social_sharing_text);
				 }?>
            </div>
            <!-- SharePost --> 
          </div>
          <!-- Col Share & Show All End --> 
          
          <!-- Post Button Start-->
          <div class="col-md-12">
          <?php if(isset($post_pagination_show) &&  $post_pagination_show == 'on'){
                  px_next_prev_custom_links('post');
             }
          ?>
          </div>
          <!-- Post Button Close--> 
          
          <!-- Col Author Start -->
          <?php if(isset($cs_post_author_info_show) &&  $cs_post_author_info_show == 'on'){ ?>
          <div class="col-md-12">
			 <?php cs_author_description('show');?>    
          </div>
          <!-- Col Author End --> 
          
          <!-- Col Seprator Start --> 
          <div class="col-md-12"><span class="divider1 detail-divider"></span></div>
          <!-- Col Seprator End -->
          
          <?php } ?>

          <!-- Col Recent Posts Start -->
          <?php if($cs_related_post =='on'){
						if ( empty($cs_xmlObject->cs_related_post_title) ) $cs_related_post_title = __('Related Posts', 'LMS'); else $cs_related_post_title = $cs_xmlObject->cs_related_post_title;
						
						 ?>
          <div class="col-md-12 post-recent">
            <div class="cs-section-title">
              <h2><?php echo esc_attr($cs_related_post_title);?></h2>
            </div>
            <div class="row">
              <?php 
				  $custom_taxterms='';
				  $width  = 370;
				  $height = 278;
				  $custom_taxterms = wp_get_object_terms( $post->ID, array($cs_categories_name, $cs_tags_name), array('fields' => 'ids') );
				  $args = array(
					  'post_type' => $postname,
					  'post_status' => 'publish',
					  'posts_per_page' => 3,
					  'orderby' => 'DESC',
					  'tax_query' => array(
						  'relation' => 'OR',
						  array(
							  'taxonomy' => $cs_tags_name,
							  'field' => 'id',
							  'terms' => $custom_taxterms
						  ),
						  array(
							  'taxonomy' => $cs_categories_name,
							  'field' => 'id',
							  'terms' => $custom_taxterms
						  )
					  ),
					  'post__not_in' => array ($post->ID),
				  );
				 $custom_query = new WP_Query($args);
				 while ($custom_query->have_posts()) : $custom_query->the_post();
					$image_url = cs_get_post_img_src($post->ID, $width, $height);
					
					if($image_url == ''){
						$img_class = 'no-image';	
						$image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
					}else{
						$img_class  = '';
					}						 
					?>
             
              	<div class="col-md-4">
                  <!-- Article -->
                  <article class="cs-blog blog-grid"> 
                    <!-- BLog Inn -->
                    <div class="blog-inn">
                      <?php if($image_url <> ""){?>
                      <figure class="<?php echo esc_attr($img_class);?>"> <a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image_url);?>" alt=""></a>
                        <a href="<?php the_permalink();?>" class="blog-hover"><i></i></a>
                      </figure>
                      <?php }?>
                      <section class="bloginfo">
                        <!-- Post Option -->
                        <ul class="post-option">
                          <li>
                            <time datetime="<?php echo date_i18n('Y-m-d', strtotime(get_the_date()));?>">
                                <?php   _e('Post On','LMS');?>
                                <?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></time>
                          </li>
                        </ul>
                        <!-- Post Option Close -->
                         <h2><a href="<?php the_permalink();?>"> <?php the_title();?> </a>
                        </h2>
                       
                      </section>
                    </div>
                    <!-- BLog Inn Close --> 
                  </article>
                  <!-- Article Close -->
              </div>
              <?php endwhile; wp_reset_postdata(); ?>
          </div>
          </div>
       <?php } ?>
          <!-- Col Recent Posts End --> 
          
          <!-- Col Comments Start -->
          <?php comments_template('', true); ?>
          <!-- Col Comments End --> 
          
          <!-- Blog Post End --> 
        <!-- Blog End --> 
      </div>
      <!-- Blog Detail End --> 
      <!-- Right Sidebar Start --> 
		<?php if ($rightSidebarFlag == true){ ?>
      		<aside class="page-sidebar">
       			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : endif; ?>
      		</aside>
      <?php } ?>
      <!-- Right Sidebar End -->
      <?php endwhile;   
		endif;?>
    </div>
  </div>
</section>
<!-- PageSection End --> 
<!-- Footer -->
<?php get_footer(); ?>