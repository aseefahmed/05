<?php
/**
 * File Type : Login Functions
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */


//=====================================================================
// User Login Ajax Function
//=====================================================================

if ( ! function_exists( 'ajax_login' ) ) :
function ajax_login(){
    $credentials = array();
    $credentials['user_login'] = $_POST['user_login'];
    $credentials['user_password'] = $_POST['user_pass'];
	
	if ( isset($_POST['rememberme'])){
		$remember  = $_POST['rememberme'];
	} else {
		$remember  = '';
	}
	
	if($remember) {
		 $credentials['remember'] = true;
	} else {
		$credentials['remember'] = false;
	}
	
	if($credentials['user_login'] == ''){
		echo json_encode(array('loggedin'=>false, 'message'=>__('User name should not be empty.','EDULMS')));
		exit();
	}elseif($credentials['user_password'] == ''){
		echo json_encode(array('loggedin'=>false, 'message'=>__('Password should not be empty.','EDULMS')));
		exit();
	}else{
 		$status = wp_signon( $credentials, false );
		if ( is_wp_error($status) ){
			echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','EDULMS')));
		} else {
			echo json_encode(array('redirecturl'=> $_POST['redirect_to'],'loggedin'=>true, 'message'=>__('Login Successfully...','EDULMS')));
		}
	}

    die();
}
endif;
add_action('wp_ajax_ajax_login', 'ajax_login');
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');


?>