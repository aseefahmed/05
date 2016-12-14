<?php
/**
 * The template for displaying Footer
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 global $wpdb,$cs_theme_options;
 ?>
        <!-- Main Section End -->
        </div>
        </main>
        <!-- Main Content Section -->
        <div class="clear"></div>
        <!-- Footer Start -->
		<?php 
			if( class_exists( 'edulms' ) ){ cs_userlogin();}
			$loop_limit = '';
			$class = '';
			$cs_footer_switch = $cs_theme_options['cs_footer_switch'];
			if(isset($cs_footer_switch) and $cs_footer_switch=='on'){
				$cs_footer_widget = $cs_theme_options['cs_footer_widget'];
				if(isset($cs_footer_widget) and $cs_footer_widget=='on'){
					?>
					<footer id="footer-sec">
						<div class="container">
							<div class="row">
								 <?php 
									if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-1') ) : endif; 
								?>
							  </div>
						</div>
					</footer>
					<!-- Footer End -->
				<?php } ?>
        <!-- Bottom Section -->
        <footer id="bottom-sec">
            <div class="container">
            	<?php 
				$cs_sub_footer_menu = isset($cs_theme_options['cs_sub_footer_menu']) ? $cs_theme_options['cs_sub_footer_menu'] : '';
				$cs_footer_newsletter = isset($cs_theme_options['cs_footer_newsletter']) ? $cs_theme_options['cs_footer_newsletter'] : '';
				if( ( isset($cs_sub_footer_social_icons) and $cs_sub_footer_menu=='on' ) || ( isset($cs_footer_newsletter) and $cs_footer_newsletter=='on' )){?>
                    <section class="footer-mid-sec">
                        <div class="row">
                            <?php if(isset($cs_sub_footer_menu) and $cs_sub_footer_menu=='on'){?>
                                <div class="col-md-6">
                                    <?php 
                                    $cs_sub_footer_social_icons = $cs_theme_options['cs_sub_footer_social_icons'];
                                    if(isset($cs_sub_footer_social_icons) and $cs_sub_footer_social_icons=='on'){?>
                                        <p class="social-media">
                                            <span><?php  _e('Follow Us','LMS');?></span>
                                            <?php if ( function_exists( 'cs_social_network' ) ) { cs_social_network(); } ?>
                                        </p>
                                    <?php }?>
                                </div>
                              <?php }?>
                            <?php if(isset($cs_footer_newsletter) and $cs_footer_newsletter=='on'){?>
                                <div class="col-md-6">
                                    <span class="news-title"><?php _e('Weekly Newsletter','LMS');?></span>
                                    <!-- User SignUp -->
                                    <?php  if ( function_exists( 'cs_custom_mailchimp' ) ) { echo cs_custom_mailchimp(); }?>
                                    <!-- User SignUp -->
                                </div>
                            <?php }?>
                        </div>
                    </section>
                <?php }	?>
                <section class="text-left-aligne <?php if($cs_sub_footer_menu <> 'on' and $cs_footer_newsletter <> 'on'){ echo 'no_border';} ?>" id="copyright">
                    <p>
                    <?php
							 if ( function_exists( 'cs_footer_logo' ) ) { cs_footer_logo(); } 
						
						$cs_copy_right = $cs_theme_options['cs_copy_right'];
						if(isset($cs_copy_right) and $cs_copy_right<>''){ 
                        	echo do_shortcode(htmlspecialchars_decode($cs_copy_right)); 
                        } else{
                        	echo '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.";  
                        }
                      ?>
                      </p>
                    	<!-- Footer Navigation -->
                        <nav class="footer-nav">
                        	<?php if ( function_exists( 'cs_navigation' ) ) { cs_navigation('footer-menu','','','1'); } ?>
                        </nav>
                        <!-- Footer Navigation -->
                </section>
            </div>
        </footer>
        <!-- Bottom Section -->
        <div class="clear"></div>
        <?php } ?>
        
        
    </div>
    <!-- Wrapper End -->
    <?php
  if(isset($cs_theme_options['cs_google_analytics']) and $cs_theme_options['cs_google_analytics']<>''){
	    echo '<script type="text/javascript">
   					'. htmlspecialchars_decode($cs_theme_options['cs_google_analytics']) .'
			  </script> ';
  }
  wp_footer();
?>
</body>
</html>