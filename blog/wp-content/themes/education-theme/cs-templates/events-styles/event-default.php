<?php
/**
 * Event Default Page
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
global $cs_node, $cs_theme_options,$cs_xmlObject,$post_xml,$img_class,$image_url,$post,$content_view,$isEventSidebar;
	
	if ( $isEventSidebar == true ){
		$width  = 570;
		$height = 428;
	} else {
		$width  = 860;
		$height = 418;
	}
	
	$img_class = '';
	$content_section	= '12';
	$counter_section	= '12';
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	
	if($image_url == ''){
		$img_class = 'no-image';
		$content_section	= '7';
		$counter_section	= '5';	
	}
	$dynamic_post_event_from_date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);
	
	$cs_layout = $cs_xmlObject->sidebar_layout->cs_page_layout;
	if ( $cs_layout == 'left' ||  $cs_layout == 'right' ){
		$sectionClass	= 'section-fullwidth';
	} else {
		$sectionClass	= 'section-fullwidth';
	}
	
?>
<div class="<?php echo cs_allow_special_char($sectionClass);?>">
    <div class="col-md-<?php echo cs_allow_special_char($counter_section);?>">
        <div class="cs-table">
            <div class="cs-row">
                <?php if($image_url != ''){ ?>
                <div class="cs-cell dt-first">
                    <figure class="detailpost <?php echo cs_allow_special_char($img_class);?>"><a>
                    <img src="<?php echo esc_url($image_url);?>" alt=""></a></figure>
                </div>
                <?php }?>
                <?php if ( $content_view != 'none' ) {?>
                <div class="cs-cell dt-secnd">
                    <!-- EventInfo -->
                    <div class="event-info">
                        <h6> 
						
					<?php _e('Event CountDown','LMS');?>	
						
						 </h6>
                        <!-- Countdown -->
                        <?php  get_template_part('cs-templates/events-styles/event','countdown');?>
                        <!-- Countdown -->
                        <!-- List -->
                        <ul>
                            <li>
                                <i class="fa fa-calendar"></i> <span><?php  _e('Event Date','LMS');;?></span>
                                <small><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_event_from_date); ?>
								&nbsp;-&nbsp;	
                                <?php 
                                
                                if(isset($cs_xmlObject->dynamic_post_event_all_day) && $cs_xmlObject->dynamic_post_event_all_day == 'on'){
                                    _e('all day', 'LMS');
                                }else{
                                  if(isset($cs_xmlObject->dynamic_post_event_start_time) && $cs_xmlObject->dynamic_post_event_start_time <> ''){
                                    echo date_i18n(get_option('time_format'),strtotime($cs_xmlObject->dynamic_post_event_start_time)).' ';
                                  }
                                  if($cs_xmlObject->dynamic_post_event_start_time <> '' && $cs_xmlObject->dynamic_post_event_end_time <> ''){
                                    _e('to', 'LMS');
                                  }
                                  if(isset($cs_xmlObject->dynamic_post_event_end_time) && $cs_xmlObject->dynamic_post_event_end_time <> ''){
                                    echo ' '.date_i18n(get_option('time_format'),strtotime($cs_xmlObject->dynamic_post_event_end_time));
                                  }
                                }
                                  
                            ?></small>
                            </li>
                            <li><i class="fa fa-map-marker"></i> <span>
<?php _e('Event Venue','LMS');?></span> <small><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_location_address);?></small></li>
							
                            <?php if($cs_xmlObject->dynamic_post_event_contact_no <> ''){ ?>
                            <li><i class="fa fa-phone"></i><span>
							<?php  _e('Contact','LMS');?></span> <small><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_event_contact_no);?></small></li>
                            <?php } ?>
                            
                            <?php if($cs_xmlObject->dynamic_post_event_email <> '' && is_email($cs_xmlObject->dynamic_post_event_email)){ ?>
                            <li><i class="fa fa-envelope"></i><span>
							<?php _e('email','LMS'); ?></span> <small><a href="mailto:<?php echo sanitize_email($cs_xmlObject->dynamic_post_event_email);?>"><?php echo sanitize_email($cs_xmlObject->dynamic_post_event_email);?></a></small></li>
                            <?php } ?>
                            
                            <?php  if (isset($cs_xmlObject->cs_post_price_saleprice_option) && $cs_xmlObject->cs_post_price_saleprice_option == "on"){?>
                            <li class="center-align">
                                <div class="cs-carprice">
                                   <span>
                                        <?php if(isset($cs_xmlObject->dynamic_post_sale_oldprice) && $cs_xmlObject->dynamic_post_sale_oldprice <> ''){?>
                                                <span><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_sale_oldprice);?></span>
                                        <?php }?>
                                        <?php if(isset($cs_xmlObject->dynamic_post_sale_newprice) && $cs_xmlObject->dynamic_post_sale_newprice <> ''){?>
                                        <big><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_sale_newprice); ?></big>
                                        <?php } ?>
                                    </span>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                        <!-- List -->
                       <?php 
                        $event_ticket_color = '';
                        if(isset($cs_xmlObject->dynamic_post_event_ticket_color) && $cs_xmlObject->dynamic_post_event_ticket_color <> ''){
							$color	= $cs_xmlObject->dynamic_post_event_ticket_color;
					  		$event_ticket_color	= ' style="background-color:'.$color.' !important; color:#FFF !important; border-color:'.$color.' !important;"';
                        }
                        if(isset($cs_xmlObject->dynamic_post_event_ticket_options) && $cs_xmlObject->dynamic_post_event_ticket_options <> ''){?>
                            <?php if(isset($cs_xmlObject->dynamic_post_event_buy_now) && $cs_xmlObject->dynamic_post_event_buy_now <> ''){?>
                                    <a class="custom-btn" href="<?php echo esc_url($cs_xmlObject->dynamic_post_event_buy_now);?>" <?php echo balanceTags($event_ticket_color, false);?>><?php echo cs_allow_special_char($cs_xmlObject->dynamic_post_event_ticket_options);?></a>
                            <?php }?>
            
                      <?php }?>
                    </div>
                    <!-- EventInfo -->
                </div>
                <?php }?>
            </div>
        </div>
      </div>
    <div class="col-md-<?php echo cs_allow_special_char($content_section);?>">
        <div class="rich_editor_text">
            <p><strong><?php the_title();?></strong> </p>
            <p>
                <?php 
                the_content();
                wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'LMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                ?>
             </p>
        </div>
    </div>
    <!-- Col End -->    
    
    <!-- Col Map Start -->    
    <?php 
	
		
		if ( isset($cs_xmlObject->event_map_switch) && $cs_xmlObject->event_map_switch == "on" ) {
			include 'event-map.php';
		}
	?>
    <!-- Col Map End --> 
    
    <!-- Col Speakers Start -->    
    <?php 
		include 'event-members.php';
	?>
    <!-- Col Speakers End -->  
    
    <!-- Col Start -->
    <?php 
        if ( isset($cs_xmlObject->cs_post_tags_show) && $cs_xmlObject->cs_post_tags_show == "on" ) {
            $before_cat = '<div class="col-md-12"><div class="content_tag"><i class="fa fa-bookmark"></i>';
            $tags_list = get_the_term_list ( get_the_id(), 'events-tags', $before_cat, ',', '</div></div>' );
            if ( $tags_list ){
                printf( __( '%1$s', 'LMS'),$tags_list );
            }
        }
    ?>
    <!-- Col End -->
    
    <!-- Col Start -->
    <?php  if (isset($cs_xmlObject->cs_post_social_sharing) && $cs_xmlObject->cs_post_social_sharing == "on"){?>
    <div class="col-md-12">
        <!-- SharePost -->
        <div class="cs-share-post-section">	 
		   <?php
            if ( empty( $cs_xmlObject->cs_post_social_sharing_text ) ) { 
                $post_social_sharing_text = __('Share now', 'LMS'); 
            } else {
                $post_social_sharing_text = $cs_xmlObject->cs_post_social_sharing_text;
            }
            if ( function_exists( 'cs_social_share' ) ) { cs_social_share(false,true,$post_social_sharing_text); }
             ?>  
        </div>
        <!-- SharePost -->
    </div>
   <?php }?>
    <!-- Col End -->
    
    <!-- Col Start -->
    <?php if (isset($cs_xmlObject->cs_post_pagination_show) && $cs_xmlObject->cs_post_pagination_show == "on" ) { ?>
    <div class="col-md-12">
	 <?php px_next_prev_custom_links('cs-events'); ?>
    </div>
    <?php }?>
    <!-- Col End -->
    
    <!-- Col Start -->
    <?php if (isset($cs_xmlObject->cs_post_author_info_show) && $cs_xmlObject->cs_post_author_info_show == "on" ) { ?>
    <div class="col-md-12">
     <?php cs_author_description('show');?>    
    </div> 
    <?php }?>
    <!-- Col End -->
    
    <!-- Col Recent Posts Start -->
	<?php 
	if($cs_xmlObject->cs_related_post =='on'){
	if ( empty($cs_xmlObject->cs_related_post_title) ) $cs_related_post_title = __('Related Posts', 'LMS'); else $cs_related_post_title = $cs_xmlObject->cs_related_post_title;
	
	 ?>
    <div class="col-md-12 post-recent">
    <div class="cs-section-title">
      <h2><?php echo cs_allow_special_char($cs_related_post_title);?></h2>
    </div>
    <div class="row">
      <?php 
          $custom_taxterms='';
          $width  = 370;
          $height = 278;
          $custom_taxterms = wp_get_object_terms( $post->ID, array('events-categories','events-tags'), array('fields' => 'ids') );
          $args = array(
              'post_type' => 'cs-events',
              'post_status' => 'publish',
              'posts_per_page' => 3,
              'orderby' => 'DESC',
              'post__not_in' => array ($post->ID),
          );
		  
		  if( isset( $custom_taxterms ) && !empty( $custom_taxterms ) ) {
			  $args['tax_query'] = array('relation' => 'OR');
			  $args['tax_query'][] = array(
											  'taxonomy' => 'events-tags',
											  'field' => 'id',
											  'terms' => $custom_taxterms
										  );
										  
			   $args['tax_query'][] = array(
											  'taxonomy' => 'events-categories',
											  'field' => 'id',
											  'terms' => $custom_taxterms
										  );
		  }
		 
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
              <figure class="<?php echo cs_allow_special_char($img_class);?>"> <a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image_url);?>" alt=""></a>
                <a href="<?php the_permalink();?>" class="blog-hover"><i></i></a>
              </figure>
              <?php }?>
              <section class="bloginfo">
                <!-- Post Option -->
                <ul class="post-option">
                  <li>
                    <time datetime="<?php echo date_i18n('Y-m-d',strtotime(get_the_date()));?>">
                        <?php  _e('Post On','LMS');?>
                        <?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></time>
                  </li>
                </ul>
                <!-- Post Option Close -->
                 <h2><a href="<?php the_permalink();?>"> <?php the_title();?> </a> </h2>
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
</div>