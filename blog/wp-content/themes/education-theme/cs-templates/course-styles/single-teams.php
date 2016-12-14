<?php
/**
 * The template for displaying Teams
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_options,$cs_counter_node,$cs_video_width;
	$cs_node = new stdClass();
  	get_header();
	$cs_layout = '';
	$height = 250;
	$width = 250;
	if (have_posts()):
	cs_addthis_script_init_method();
	while (have_posts()) : the_post();	
	$post_xml = get_post_meta($post->ID, "cs_team", true);
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
 		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-md-9";
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-md-9";
 		}
		else {
			$cs_layout = "col-md-12";
		}
 	}else{
		$cs_layout = "col-md-12";
	}
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$image_url = cs_get_post_img_src($post->ID, $width, $height);
	} else {
		$cs_xmlObject = new stdClass();
		$image_url = '';
		$width = 0;
		$height = 0;
		$image_id = 0;
		$custom_height = 250;
	}		
?>
        <!--Left Sidebar Starts-->
        <?php if ($cs_layout == 'content-right col-md-9'){ ?>
            <div class="content-lt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
        <?php } ?>
        <!--Left Sidebar End-->
        <!-- Team Detail Start -->
        <div class="<?php echo esc_attr($cs_layout); ?>">
          <div class="team-detail">
              <div class="col-left">
                <div class="element_size_100">
                    <div class="contant-info">
                      <article class="text-widget">
                      <?php if($image_url <> ''){?>
                            <figure><a><img src="<?php echo esc_url($image_url);?>" alt=""></a></figure>
                       <?php }?>
                        <div class="text">
                            <?php
                                 if($cs_xmlObject->var_cp_expertise <> ''){
                                      echo '<h5><a>'.esc_attr($cs_xmlObject->var_cp_expertise).'</a></h5>';
                                 }
                                 if($cs_xmlObject->var_cp_email <> '' && is_email($cs_xmlObject->var_cp_email)){
                                      echo '<span><a href="mailto:'.$cs_xmlObject->var_cp_email.'">'.$cs_xmlObject->var_cp_email.'</a></span>';
                                 }
                            ?>
                            <div class="followus">
                                 <?php if($cs_xmlObject->facebook <> ''){?><a href="<?php echo esc_url($cs_xmlObject->facebook);?>" target="_blank"><i class="fa fa-facebook-square"></i></a><?php }?>
                                <?php if($cs_xmlObject->twitter <> ''){?><a href="<?php echo esc_url($cs_xmlObject->twitter);?>" target="_blank"><i class="fa fa-twitter"></i></a><?php }?>
                                <?php if($cs_xmlObject->linkedin <> ''){?><a href="<?php echo esc_url($cs_xmlObject->linkedin);?>" target="_blank"><i class="fa fa-instagram"></i></a><?php }?>
                                <?php if($cs_xmlObject->google_plus <> ''){?><a href="<?php echo esc_url($cs_xmlObject->google_plus);?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php }?>
                            </div>
                    </div>
                    </article>
                        <ul>
                        <?php foreach($cs_xmlObject->social as $social){?>
                            <li>
                                <?php if($social->var_cp_image_url <> ''){?> <i class="fa <?php echo esc_url($social->var_cp_image_url);?>"></i><?php }?>
                                <p>
                                    <?php if($social->var_cp_title <> ''){?><strong><?php echo esc_attr($social->var_cp_title);?></strong><br/><?php }?>
                                    <?php if($social->var_cp_team_text <> ''){echo force_balance_tags($social->var_cp_team_text);}?>
                                </p>
                            </li>
                         <?php }?>
                           
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-right">
                <div class="element_size_100">
                    <div class="text-detail rich_editor_text">
                        <?php the_content();
                                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:','LMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                              ?>
                    </div>
                </div>
            </div>
            <div class="element_size_100">
                <?php if (isset($cs_xmlObject->team_social_sharing) && $cs_xmlObject->team_social_sharing == "on"){?>
                        <div class="share-post">
                            <a class="btnshare  addthis_button_compact"><i class="fa fa-share-square-o"></i><?php _e('Share','LMS'); ?></a>
                        </div>
                 <?php }?>
                 <!-- Comments Section------>
                <?php comments_template('', true); ?>
            </div>
        </div>
    </div>
<?php endwhile;   endif;?>
<!--Content Area End-->
    <!--Right Sidebar Starts-->
    <?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
        <div class="content-rt col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
    <?php } ?>
    <!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>
