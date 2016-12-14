<?php
/**
 * File Type : Login Shortcodes
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */


//=====================================================================
// User Login Ajax Function
//=====================================================================

if ( ! function_exists( 'cs_get_login_nav_shortocde' ) ) {
	function cs_get_login_nav_shortocde(){
		$cs_theme_options	=  get_option('cs_theme_options');
		$cs_login_options = $cs_theme_options['cs_login_options'];
		echo '<li>';    
			if(isset($cs_login_options) and $cs_login_options=='on'){ 
			global $current_user;
			$uid= $current_user->ID;
			
			$isRegistrationOn = get_option('users_can_register');
		    $isRegistrationOnClass	= '';
			
			if ( !$isRegistrationOn ) {
				$isRegistrationOnClass	= 'no_icon';
			}
			echo '<aside class="cs-login-sec '.$isRegistrationOnClass.'">';
				if ( is_user_logged_in() ) {
					echo '<a class="cs-user-login"><i class="fa fa-user"></i>'.get_the_author_meta('display_name',$uid).'<i class="fa fa-angle-down"></i></a>';
				}else{
					echo '<a class="cs-user">'.__('User Login ','EDULMS').'</a>';
				}
				cs_login_section();
			echo '</aside>';	
			}
	   echo '</li>';
		
	}
}
add_shortcode('cs_get_login_nav', 'cs_get_login_nav_shortocde');


?>