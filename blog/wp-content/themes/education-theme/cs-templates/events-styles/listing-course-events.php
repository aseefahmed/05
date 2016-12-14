<?php
/**
 * Event Modren View
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $cs_theme_options,$cs_dcpt_post_time,$dynamic_post_event_from_date,$cs_event_meta,$cs_dcpt_post_excerpt,$cs_dcpt_post_category;
	
	$width	= '150';
	$height	= '150';
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	$title_limit = 46;
	$background	= '';
	
?>
<?php if ( $image_url ) { ?>
<figure>
	<a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image_url);?>" alt=""  /></a>
    <figcaption>
    	<a class="blog-hover" href="<?php the_permalink();?>"><i></i></a>
    </figcaption>
</figure>
<?php }?>
<section class="ev-text">
   
   <div class="ev-left">
       <ul class="ev-option">
                <li><time datetime="<?php echo date_i18n('Y-m-d',strtotime($dynamic_post_event_from_date));?>">
                <?php 
                      if( isset( $cs_event_meta->dynamic_post_event_start_time ) && $cs_event_meta->dynamic_post_event_start_time <> ''){
                        echo date_i18n(get_option('time_format'),strtotime($cs_event_meta->dynamic_post_event_start_time)).' ';
                      }
					  
                      if(isset($cs_event_meta->dynamic_post_event_end_time) && $cs_event_meta->dynamic_post_event_end_time <> ''){
                        _e('To', 'LMS');
                        echo ' '.date_i18n(get_option('time_format'),strtotime($cs_event_meta->dynamic_post_event_end_time));
                      }
                 ?>
                </time>
               </li>
               <?php  get_template_part('cs-templates/events-styles/listing','categories');?>
       </ul>
       <h2><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0, $title_limit); if(strlen(get_the_title())>$title_limit){echo '...';}?></a></h2>
      
   </div>
    <ul class="ev-location">
         <?php if ( isset( $dynamic_post_event_from_date ) && $dynamic_post_event_from_date !='' ){?>
         	<li><i class="fa fa-calendar"></i><?php echo date_i18n('F j, Y',strtotime($dynamic_post_event_from_date));?></li>
         <?php }
		
		if( isset( $cs_event_meta->dynamic_post_location_address ) && $cs_event_meta->dynamic_post_location_address <> '' ){ ?>
                <li>
                    <i class="fa fa-map-marker"></i> <span><?php 
					 echo esc_attr($cs_event_meta->dynamic_post_location_address);?></span>
                </li>
        <?php }?>
       </ul>
   <?php
        if ( isset( $cs_event_meta->dynamic_post_event_ticket_color ) && $cs_event_meta->dynamic_post_event_ticket_color !=''){
            $event_ticket_color = 'style="color:#FFF"';
        } else {
            $event_ticket_color = '';
        }
       
	    if(isset($cs_event_meta->dynamic_post_event_ticket_options) && $cs_event_meta->dynamic_post_event_ticket_options <> '' ){?>
   				
                <?php if ( isset( $cs_event_meta->dynamic_post_event_ticket_color ) &&  $cs_event_meta->dynamic_post_event_ticket_color !='' ) {
					 	$color	= $cs_event_meta->dynamic_post_event_ticket_color;
					  	$background	= ' style="background-color:'.$color.' !important; color:#FFF !important; border-color:'.$color.' !important;"';
					  }?>
                <a class="ev-btn" <?php echo balanceTags($background, false);?> href="<?php echo esc_url($cs_event_meta->dynamic_post_event_buy_now);?>"><?php echo esc_attr($cs_event_meta->dynamic_post_event_ticket_options);?></a>
    <?php  }?>
    
</section>