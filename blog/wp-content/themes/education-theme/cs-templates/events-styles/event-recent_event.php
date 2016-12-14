<?php
/**
 * Recent Events
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
global $cs_node, $cs_theme_options,$cs_xmlObject,$post_xml,$img_class,$image_url,$post;

?>
<!--Recent Posts--> 
<div class="widget widget_instrector col-md-12">
   <ul>
    <?php 
        wp_reset_query();
        $args_cat  = array('author' => get_the_author_meta('ID'));
        $post_type = array('cs-events');
        $args = array( 
                'post_type'		 => $post_type, 
                'post_status'	 => 'publish', 
                'order'			 => 'DESC',
                'posts_per_page' => 2,
            );

        $args = array_merge($args_cat,$args);
        $custom_query = new WP_Query($args);
            
         if ( $custom_query->have_posts() ): 
                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                    $event_Date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);
                ?>
                 <li id="post-<?php the_ID();?>">
                      <h5><a  href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                      <?php if ($event_Date !=''){?>
                        <p><?php echo date_i18n(get_option('date_format'),strtotime($event_Date));?></p>
                      <?php }?>
                </li>
            <?php  
                endwhile;
        endif;          
    ?>
   </ul>
</div>
<!--Recent Posts End-->