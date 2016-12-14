<?php
/**
 * Event Sidebar
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
global $cs_node, $cs_theme_options,$cs_xmlObject,$post_xml,$img_class,$image_url,$content_view;
	$width  = 860;
	$height = 418;
	$img_class = '';
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	if($image_url == ''){
		$img_class = 'no-image';	
	}
	$dynamic_post_event_from_date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);

?>
<div class="section-content">
  <div class="row">
    <?php if($image_url != ''){ ?>
        <div class="col-md-12">
            <figure class="detailpost <?php echo esc_attr($img_class);?>">
                <a><img src="<?php echo esc_url($image_url);?>" alt=""></a>
            </figure>
        </div>
     <?php }?>
        <div class="col-md-12">
            <div class="rich_editor_text">
                <p><strong><?php the_title();?></strong></p>
                <?php 
					the_content();
                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'LMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                ?> 
            </div>
        </div>
        <!-- Col Start -->
        <?php 
            if ( isset($cs_xmlObject->post_tags_show) && $cs_xmlObject->post_tags_show == "on" ) {
                if ( empty($cs_xmlObject->post_tags_show_text) ) $post_tags_show_text = __('Tags', 'LMS'); else $post_tags_show_text = $cs_xmlObject->post_tags_show_text;
                $before_cat = '<div class="col-md-12"><div class="content_tag"><i class="fa fa-quote-right"></i><h6>'.esc_attr($post_tags_show_text).':</h6>';
                $tags_list = get_the_term_list ( get_the_id(), 'events-tags', $before_cat, '', '</div></div>' );
                if ( $tags_list ){
                    printf( __( '%1$s', 'LMS'),$tags_list );
                }
            }
        ?>
        <!-- Col End -->
        
        <!-- Col Start -->
        <div class="col-md-12">
            <!-- SharePost -->
            <div class="cs-share-post-section">
               <?php  if (isset($cs_xmlObject->post_social_sharing) && $cs_xmlObject->post_social_sharing == "on"){
                        if ( empty($cs_xmlObject->post_social_sharing_text) ) 
                        $post_social_sharing_text = __('Share now', 'LMS'); else $post_social_sharing_text = $cs_xmlObject->post_social_sharing_text;
                        if ( function_exists( 'cs_social_share' ) ) { cs_social_share(false,true,$post_social_sharing_text); }			
                 }?>
            <!-- Post Button Start-->
            <?php if (isset($cs_xmlObject->post_pagination_show) && $cs_xmlObject->post_pagination_show == "on" ) {cs_next_prev_post(); }?>
            <!-- Post Button Close-->
            </div>
            <!-- SharePost -->
        </div>
        <!-- Col End -->
        
        <!-- Col Comments Start -->    
        <?php comments_template('', true); ?>
        <!-- Col Comments End -->   
  </div>
</div>
<aside class="section-sidebar">
	<?php if ($content_view != 'none') {?>
        <div class="event-info">
               <h6> 
				<?php  _e('Event CountDown','LMS');?>		   
			   
			   </h6>
               <!-- Countdown -->
               <?php  get_template_part('cs-templates/events-styles/event','countdown');?>
               <!-- Countdown -->
               
               <!-- List -->
                <ul>
                    <li><i class="fa fa-calendar"></i> <span><?php  _e('Event Date','LMS');?>
					</span> <p><?php echo date_i18n(get_option('date_format'),strtotime($dynamic_post_event_from_date));?></p></li>
                    <li><i class="fa fa-calendar"></i> <span><?php _e('Event Timing','LMS'); ?>	
					<?php _e('Event Timing','LMS'); ?>	
					</span> <p><?php 
                          if(isset($cs_xmlObject->dynamic_post_event_start_time) && $cs_xmlObject->dynamic_post_event_start_time <> ''){
                            echo date_i18n(get_option('time_format'),strtotime($cs_xmlObject->dynamic_post_event_start_time)).' ';
                          }
                          if(isset($cs_xmlObject->dynamic_post_event_end_time) && $cs_xmlObject->dynamic_post_event_end_time <> ''){
                            _e('to', 'LMS');
                            echo ' '.date_i18n(get_option('time_format'),strtotime($cs_xmlObject->dynamic_post_event_end_time));
                          }
                     ?></p></li>
                    <li><i class="fa fa-calendar"></i> <span><?php _e('Event Venue','LMS'); ?>
					</span> <p><?php echo esc_attr($cs_xmlObject->dynamic_post_location_address);?></p></li>
                    <?php  if (isset($cs_xmlObject->cs_post_price_saleprice_option) && $cs_xmlObject->cs_post_price_saleprice_option == "on"){?>
                    <li class="center-align">
                        <div class="cs-carprice">
                           <span>
                                <?php if(isset($cs_xmlObject->dynamic_post_sale_oldprice) && $cs_xmlObject->dynamic_post_sale_oldprice <> ''){?>
                                        <span><?php echo esc_attr($cs_xmlObject->dynamic_post_sale_oldprice);?></span>
                                <?php }?>
                                <?php if(isset($cs_xmlObject->dynamic_post_sale_newprice) && $cs_xmlObject->dynamic_post_sale_newprice <> ''){?>
                                <big><?php echo esc_attr($cs_xmlObject->dynamic_post_sale_newprice);?></big>
                                <?php }?>
                            </span>
                        </div>
                    </li>
                   <?php }?>
                </ul>
               <!-- List -->
               <?php 
                $event_ticket_color = '';
                if(isset($cs_xmlObject->dynamic_post_event_ticket_color) && $cs_xmlObject->dynamic_post_event_ticket_color <> ''){
                    $event_ticket_color = 'style="background-color: '.$cs_xmlObject->dynamic_post_event_ticket_color.' !important;"';
                }
                if(isset($cs_xmlObject->dynamic_post_event_ticket_options) && $cs_xmlObject->dynamic_post_event_ticket_options <> ''){?>
                    <?php if(isset($cs_xmlObject->dynamic_post_event_buy_now) && $cs_xmlObject->dynamic_post_event_buy_now <> ''){?>
                            <a class="custom-btn circle cs-bg-color" href="<?php echo esc_attr($cs_xmlObject->dynamic_post_event_buy_now);?>" <?php echo balanceTags($event_ticket_color, false);?>>
                            <?php echo esc_attr($cs_xmlObject->dynamic_post_event_ticket_options);?>
                            </a>
                    <?php }?>
    
              <?php }?>
            </div>
    <?php }?>    
    <!-- Widget Map -->
    <?php if(isset($cs_xmlObject->event_map_switch) && $cs_xmlObject->event_map_switch == 'on'){?>
            <div class="widget widget_map event_map">
                <?php  get_template_part('cs-templates/events-styles/event','map');?>
            </div>
    <?php }?>
    <!-- Widget Map -->
    <!-- EventOrgnizer -->
     <?php if(isset($cs_xmlObject->event_organizer_switch) && $cs_xmlObject->event_organizer_switch == 'on' && (int)$cs_xmlObject->event_organizer !=''){ 
            $user_info = get_userdata((int)$cs_xmlObject->event_organizer); ?>
            <div class="widget evorgnizer">
                <div class="cs-section-title">
                  <h2><?php _e('Event Organizer','LMS'); ?></h2>
                </div>
                <figure><a href="<?php  echo get_author_posts_url( (int)$user_info->ID, $user_info->user_nicename ); ?>"><?php echo get_avatar($user_info->user_email, apply_filters('PixFill_author_bio_avatar_size', 70));?></a></figure>
                <div class="left-sp">
                    <h5><a href="<?php  echo get_author_posts_url( (int)$user_info->ID, $user_info->user_nicename ); ?>"><?php echo esc_attr($user_info->display_name); ?></a></h5>
                </div>
                <p><?php echo get_the_author_meta('description',(int)$user_info->ID); ?></p>
           </div>
   <?php }?>
    <?php  get_template_part('cs-templates/events-styles/event','recent_event');?>
    <!-- EventOrgnizer -->
</aside>