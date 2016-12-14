<?php
/**
 * File Type : Login Form Html
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	
//=====================================================================
// Sign In With Social Media
//=====================================================================
if (!function_exists('cs_social_login_form')) {
	function cs_social_login_form( $args = NULL ) {
		global $cs_theme_options;
		$display_label = false;
		if(get_option('users_can_register')) {
		if( $args == NULL )
			$display_label = true;
		elseif ( is_array( $args ) )
			extract( $args );
		
		if( !isset( $images_url ) )
			$images_url = get_template_directory_uri().'/include/theme-components/cs-social-login/media/img/';
			$images_url = get_template_directory_uri().'/include/theme-components/cs-social-login/media/img/';
		
		$facebook_app_id = '';
		$facebook_secret = '';
		
		if(isset($cs_theme_options['cs_dashboard'])){
			$cs_dashboard_link = get_permalink($cs_theme_options['cs_dashboard']);
		}
		$twitter_enabled = $cs_theme_options['cs_twitter_api_switch'];
		$facebook_enabled = $cs_theme_options['cs_facebook_login_switch'];
		if(isset($cs_theme_options['cs_facebook_app_id']))
			$facebook_app_id = $cs_theme_options['cs_facebook_app_id'];
		if(isset($cs_theme_options['cs_facebook_secret']))
			$facebook_secret = $cs_theme_options['cs_facebook_secret'];
		$google_enabled = $cs_theme_options['cs_google_login_switch'];
		
		if(isset($cs_theme_options['cs_consumer_key']))
			$twitter_app_id = $cs_theme_options['cs_consumer_key'];
		
		if(isset($cs_theme_options['cs_google_client_id']))
		
			$google_app_id = $cs_theme_options['cs_google_client_id'];
			
		if ($twitter_enabled || $facebook_enabled || $google_enabled) :
		$rand_id = cs_generate_random_string(5);
		
		$isRegistrationOn = get_option('users_can_register');
		   if ( $isRegistrationOn ) {?>
    		<div class="footer-element comment-form-social-connect social_login_ui <?php if( strpos( $_SERVER['REQUEST_URI'], 'wp-signup.php' ) ) echo 'mu_signup'; ?>">
	  <div class="cs-section-title">
		<h6><?php _e('Sign in with Social Account','EDULMS');?></h6>
	  </div>
	  <div class="social_login_facebook_auth">
		<input type="hidden" name="client_id" value="<?php echo esc_attr($facebook_app_id); ?>" />
		<input type="hidden" name="redirect_uri" value="<?php echo home_url('index.php?social-login=facebook-callback'); ?>" />
	  </div>
	  <div class="social_login_twitter_auth">
		<input type="hidden" name="client_id" value="<?php echo esc_attr($twitter_app_id); ?>" />
		<input type="hidden" name="redirect_uri" value="<?php echo home_url('index.php?social-login=twitter'); ?>" />
	  </div>
	  <div class="social_login_google_auth">
		<input type="hidden" name="client_id" value="<?php echo esc_attr($google_app_id); ?>" />
		<input type="hidden" name="redirect_uri" value="<?php  echo cs_google_login_url() . (isset($_GET['redirect_to']) ? '&redirect=' . $_GET['redirect_to'] : '');?>" />
	  </div>
	  <p class="social-media social_login_form">	 
	  <?php if( $facebook_enabled ) :
                echo apply_filters('social_login_login_facebook','<a href="javascript:void(0);" title="Facebook" id="cs-social-login-'.$rand_id.'fb"  data-original-title="Facebook" class="social_login_login_facebook"><span class="social-mess-top fb-social-login" style="display:none">'.__('Please set API key','EDULMS').'</span><i class="fa fa-facebook"></i>'.__('Login With Facebook','EDULMS').'</a>');
            endif; 
            if( $twitter_enabled ) :
                echo apply_filters('social_login_login_twitter','<a href="javascript:void(0);" title="Twitter" id="cs-social-login-'.$rand_id.'tw" data-original-title="twitter" class="social_login_login_twitter"><span class="social-mess-top tw-social-login" style="display:none">'.__('Please set API key','EDULMS').'</span><i class="fa fa-twitter"></i>'.__('Login With twitter','EDULMS').'</a>');
            endif; 
            if( $google_enabled ) :
                echo apply_filters('social_login_login_google','<a  href="javascript:void(0);" rel="nofollow" title="google-plus" id="cs-social-login-'.$rand_id.'gp" data-original-title="google-plus" class="social_login_login_google"><span class="social-mess-top gplus-social-login" style="display:none">'.__('Please set API key','EDULMS').'</span><i class="fa fa-google-plus"></i>'.__('Login with Google Plus','EDULMS').'</a>');

            endif; 
        $social_login_provider = isset( $_COOKIE['social_login_current_provider']) ? $_COOKIE['social_login_current_provider'] : '';
        do_action ('social_login_auth'); ?>  
	  </p>
		 
	</div>
    	<?php }?>
	<!-- End of social_login_ui div -->
	<?php endif;
		}
	
	}
}

add_action( 'login_form',          'cs_social_login_form', 10 );
add_action( 'social_form',          'cs_social_login_form', 10 );
add_action( 'after_signup_form',   'cs_social_login_form', 10 );
add_action( 'social_login_form', 'cs_social_login_form', 10 );


//=====================================================================
// General Sign In Section ( Form )
//=====================================================================
if ( ! function_exists( 'cs_login_section' ) ) {
	function cs_login_section($login='', $logout=''){
	global $current_user,$cs_theme_options;
	$rand_id	 = rand(5,999999);
		?>
<section id="cs-signup" class="<?php if ( is_user_logged_in() ) { echo 'has-login cs-signup';} else {echo 'cs-signup';}?>"> 
  <!-- Header Element -->
  <?php  
				
	if ( is_user_logged_in() ) { 
	 $qrystr= "";
	 if(isset($cs_theme_options['cs_dashboard'])){
			$cs_page_id = $cs_theme_options['cs_dashboard'];
	 }
	 $uid= $current_user->ID;
	$uid = get_current_user_id();
	$action = (isset($_GET['action']) && $_GET['action'] <> '') ? $_GET['action'] : $action	= '';
	if ( function_exists( 'cs_profile_menu' ) ) {
		cs_profile_menu( $action ,$uid);
	}
  }else{?>
      <div class="cs-login-form-section"> 
        <script>
            jQuery(document).ready(function(){
            jQuery("#cs-signup-form-section").hide();
            jQuery("#accout-already").hide();
              jQuery("#signup-now").click(function(){
                jQuery("#login-from-<?php echo esc_js($rand_id);?>").hide();
                jQuery("#signup-now").hide();
                jQuery("#cs-signup-form-section").show();
                jQuery("#accout-already").show();
              });
              jQuery("#accout-already").click(function(){
                jQuery("#login-from-<?php echo esc_js($rand_id);?>").show();
                jQuery("#signup-now").show();
                jQuery("#cs-signup-form-section").hide();
                jQuery("#accout-already").hide();
              });
            });
         </script>
        <div class="header-element login-from login-form-id-<?php echo esc_attr($rand_id);?>" id="login-from-<?php echo esc_attr($rand_id);?>">
          <h6>
            <?php _e('Sign In','EDULMS');?>
          </h6>
          <form method="post" class="wp-user-form webkit" id="ControlForm_<?php echo esc_attr($rand_id);?>">
            <fieldset>
              <p> 
                <span class="input-icon"><i class="fa fa-user"></i>
                <input type="text" name="user_login" size="20"  tabindex="11" onfocus="if(this.value =='<?php _e('Username','EDULMS');?>') { this.value = ''; }" onblur="if(this.value == '') { this.value ='<?php _e('Username','EDULMS');?>'; }" value="<?php _e('Username','EDULMS');?>" />
                </span> 
              </p>
              <p> 
                <span class="input-icon"><i class="fa fa-unlock-alt"></i>
                <input type="password" name="user_pass" size="20" tabindex="12" onfocus="if(this.value =='<?php _e('Password','EDULMS');?>') { this.value = ''; }" onblur="if(this.value == '') { this.value ='<?php _e('Password','EDULMS');?>'; }" value="<?php _e('Password','EDULMS');?>" />
                </span> 
              </p>
              <p>
                <input name="rememberme" value="forever" type="checkbox">
                <span class="remember-me">
                <?php _e('Remember me','EDULMS'); ?>
                </span> <span class="status status-message" style="display:none"></span> 
              </p>
              <p>
                <input type="button" name="user-submit" class="user-submit backcolr" value="<?php _e('login','EDULMS'); ?>" onclick="javascript:cs_user_authentication('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($rand_id);?>')" />
                <input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>" />
                <input type="hidden" name="user-cookie" value="1" />
                <input type="hidden" value="ajax_login" name="action">
                <input type="hidden" name="login" value="login" />
              </p>
              <p><a href="<?php echo wp_lostpassword_url(); ?>">
                <?php _e('Forget Password?','EDULMS');?>
                </a>
              </p>
            </fieldset>
          </form>
        </div>
        <?php  $isRegistrationOn = get_option('users_can_register');
               if ( $isRegistrationOn ) {?>
                 <div class="header-element cs-signup-form-section" id="cs-signup-form-section">
            <div class="cs-user-register">
              <h6><?php _e('Sign Up','EDULMS');?></h6>
              <form method="post" class="wp-user-form" id="wp_signup_form_<?php echo esc_attr($rand_id);?>" enctype="multipart/form-data">
                <ul class="upload-file">
                  <li>
                  <i class="fa fa-user"></i>
                    <input type="text" name="user_login" value="<?php _e('User Name','EDULMS');?>" onfocus="if(this.value =='<?php _e('User Name','EDULMS');?>') { this.value = ''; }" onblur="if(this.value == '') { this.value =<?php _e('User Name','EDULMS');?>''; }"  size="20" tabindex="101" />
                  </li>
                  <li>
                  <i class="fa fa-envelope"></i>
                    <input type="text" name="user_email" value="<?php _e('Email','EDULMS');?>" onfocus="if(this.value =='<?php _e('Email','EDULMS');?>') { this.value = ''; }" onblur="if(this.value == '') { this.value ='<?php _e('Email','EDULMS');?>'; }"  size="25" id="user_email" tabindex="101" />
                  </li>
                </ul>
                <ul class="upload-file">
                  <li>
                    <?php echo do_action('register_form');?>
                    <input type="button" name="user-submit"  value="<?php _e('Register Now','EDULMS');?>" class="user-submit backcolr"  onclick="javascript:cs_registration_validation('<?php echo esc_js(admin_url("admin-ajax.php"));?>','<?php echo esc_js($rand_id);?>')" />
                    <div id="result_<?php echo esc_attr($rand_id);?>" class="status-message"><p class="status"></p></div>
                    <input type="hidden" name="role" value="member" />
                    <input type="hidden" name="action" value="cs_registration_validation" />
                  </li>
                </ul>
              </form>
            </div>
        </div>
        <?php }?>
    </div>
     <?php  $isRegistrationOn = get_option('users_can_register');
		   if ( $isRegistrationOn ) {?>
				<?php do_action('login_form'); ?>
                <h6 id="signup-now" class="forget-link"><?php _e('Not a Member ?','EDULMS');?> <a href="#" style="font-size:12px;"><?php _e('Signup Now','EDULMS');?></a></h6>
                <h6 id="accout-already" class="login-link"><?php _e('Already have an account?','EDULMS');?> <a href="#" style="font-size:12px;"><?php _e('Login','EDULMS');?> </a></h6>
           <?php }?>
   <?php } ?>
  <!-- Footer Element --> 
  
</section>
	<?php
	}
}
//=====================================================================
// General Sign In Section ( Add to Wishlist Form )
//=====================================================================
if ( ! function_exists( 'cs_userlogin' ) ) {
	function cs_userlogin(){
		global $cs_theme_options;
		$rand_id	 = rand(5,999999);
		$isRegistrationOn = get_option('users_can_register');
		$isRegistrationOnClass	= '';
			
			if ( !$isRegistrationOn ) {
				$isRegistrationOnClass	= 'no_icon';
			}
		?>
	<!-- Modal -->
	<div class="modal fade model-wishlist <?php echo esc_attr($isRegistrationOnClass);?>" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-body">
			<section class="cs-signup" style="display:block;">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <div class="header-element login-from login-form-id-<?php echo esc_attr($rand_id);?>" id="login-from-<?php echo esc_attr($rand_id);?>">
		  <h6>
			<?php _e('Sign in','EDULMS');?>
		  </h6>
		  <form method="post" class="wp-user-form webkit" id="ControlForm_<?php echo esc_attr($rand_id);?>">
			<fieldset>
			  <p> <span class="input-icon"><i class="fa fa-user"></i>
				<input type="text" name="user_login" size="20" tabindex="11" onfocus="if(this.value =='User Name') { this.value = ''; }" onblur="if(this.value == '') { this.value ='User Name'; }" value="User Name" />
				</span> 
			  </p>
			  <p> 
				<span class="input-icon"><i class="fa fa-unlock-alt"></i>
				<input type="password" name="user_pass" size="20" tabindex="12" onfocus="if(this.value =='Password') { this.value = ''; }" onblur="if(this.value == '') { this.value ='Password'; }" value="Password" />
				</span> 
			  </p>
			  <p>
				<input name="rememberme" value="forever" type="checkbox">
				<span class="remember-me">
				<?php _e('Remember me','EDULMS'); ?>
				</span> <span class="status status-message" style="display:none"></span> </p>
			  <p>
				<input type="button" name="user-submit" class="user-submit backcolr"  value="<?php _e('login','EDULMS'); ?>" onclick="javascript:cs_user_authentication('<?php echo esc_js(admin_url('admin-ajax.php'))?>','<?php echo esc_js($rand_id);?>')" />
				<input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>" />
				<input type="hidden" name="user-cookie" value="1" />
				<input type="hidden" value="ajax_login" name="action">
				<input type="hidden" name="login" value="login" />
			  </p>
			  <p><a href="<?php echo wp_lostpassword_url( ); ?>">
				<?php _e('Forget Password?','EDULMS');?>
				</a>
			  </p>
			</fieldset>
		  </form>
		</div>
			  <?php do_action('login_form'); ?>
			</section>
		  </div>
		</div>
	  </div>
	</div>
	<?php
	}
}