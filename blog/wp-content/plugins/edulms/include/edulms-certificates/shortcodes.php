<?php
/**
 * File Type : Certificates & Badges Shortcodes
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */


//=====================================================================
// Certificates Shortcode Templates Start
//=====================================================================


//=====================================================================
// Get Member Name
//=====================================================================
if (!function_exists('cs_member_name')) {
	function cs_member_name($atts) {
		global $current_user;
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
 		$userID	= $current_user->ID;
		if(isset($_POST['course_id']))
			$course_id	= $_POST['course_id'];
		if(isset($_POST['transection_id']))
			$transection_id	= $_POST['transection_id'];
		$certificates_user_array = get_user_meta($userID, "user_certificates", true);
		if(isset($transection_id) && $transection_id <> ''){
			$certificateArray = $certificates_user_array[$transection_id];
			return $certificateArray['cs_username'];
		}
	}
	add_shortcode('cs_member_name', 'cs_member_name');
}


//=====================================================================
// Get Course Name
//=====================================================================
if (!function_exists('cs_course_name')) {
	function cs_course_name($atts) {
		global $current_user;
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
 		$userID	= $current_user->ID;
		if(isset($_POST['course_id']))
			$course_id	= $_POST['course_id'];
		if(isset($_POST['transection_id']))
			$transection_id	= $_POST['transection_id'];
		$certificates_user_array = get_user_meta($userID, "user_certificates", true);
		if(isset($transection_id) && $transection_id <> ''){
			$certificateArray = $certificates_user_array[$transection_id];
			return $certificateArray['cs_course_name'];
		}
	}
	add_shortcode('cs_course_name', 'cs_course_name');
}


//=====================================================================
// Get Taken Marks
//=====================================================================
if (!function_exists('cs_taken_marks')) {
	function cs_taken_marks($atts) {
		global $current_user;
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
 		$userID			= $current_user->ID;
		if(isset($_POST['course_id']))
			$course_id = $_POST['course_id'];
		if(isset($_POST['transection_id']))
			$transection_id	= $_POST['transection_id'];
		//$certificates_user_array = get_user_meta($userID, "user_certificates", true);
		//$certificateArray		 = $certificates_user_array[$transection_id];
		if(isset($transection_id) && $transection_id <> '' && isset($course_id) && $course_id <> '' ){
			$takenMarks = cs_courses_taken_marks($course_id,$userID,$transection_id);
			return $takenMarks;
		}
	}
	add_shortcode('cs_taken_marks', 'cs_taken_marks');
}


//=====================================================================
// Get Completion Date
//=====================================================================
if (!function_exists('cs_completion_date')) {
	function cs_completion_date($atts) {
		global $current_user;
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
 		$userID	 = $current_user->ID;
		if(isset($_POST['course_id']))
			$course_id = $_POST['course_id'];
		if(isset($_POST['transection_id']))
			$transection_id = $_POST['transection_id'];
		$certificates_user_array = get_user_meta($userID, "user_certificates", true);
		if(isset($transection_id) && $transection_id <> ''){
			$certificateArray = $certificates_user_array[$transection_id];
			return date('F j, Y',strtotime($certificateArray['cs_completion_date']));
		}
	}
	add_shortcode('cs_completion_date', 'cs_completion_date');
}


//=====================================================================
// Get Certificate Code
//=====================================================================
if (!function_exists('cs_certificate_code')) {
	function cs_certificate_code($atts) {
		global $current_user;
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
 		$userID					 = $current_user->ID;
		if(isset($_POST['course_id']))
			$course_id  = $_POST['course_id'];
		if(isset($_POST['transection_id']))
			$transection_id	  = $_POST['transection_id'];
		
		$certificates_user_array = get_user_meta($userID, "user_certificates", true);
		if(isset($transection_id) && $transection_id <> ''){
			$certificateArray		 = $certificates_user_array[$transection_id];
			return $certificateArray['cs_certificate_code'];
		}
	}
	add_shortcode('cs_certificate_code', 'cs_certificate_code');
}


//=====================================================================
// Badges Shortcode Start
//=====================================================================
if (!function_exists('cs_badges_shortcode')) {
	function cs_badges_shortcode($atts) {
		$defaults = array( 'column_size' => '1/1', 'cs_numbering'=>'', 'cs_badges_class'=>'','cs_badges_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$html  = '';
		$html .= '<div class="col-md-12 cs-member dir-list" id="members-dir-list">';   
		$html .= '<ul class="item-list" id="members-list">';
		$cs_badges_list	=  get_option('cs_badges');
		$i	= 0;
		$counter	= 0;
		$badges = isset($cs_badges_list['badges_net_icons']) ? $cs_badges_list['badges_net_icons'] : '';		
		if(isset($badges) and $badges <> ''){
			foreach($badges as $badge){
				$badge_name = $cs_badges_list['badges_net_icons'][$i];
				$badge_short = $cs_badges_list['badges_net_icons_short_name'][$i];
				$badge_img = $cs_badges_list['badges_net_icons_paths'][$i];
				$badge_save = $badge_name.','.$badge_short.','.$badge_img;
				$get_s_badge = array();
				$counter++;
				$html .= '<li>';
				if (isset( $badge_img ) && $badge_img != '' ) { 
					$html .= '<figure>';
					$html .= '<a href=""><img width="60" height="60" class="avatar avatar-60 photo" src="'.$badge_img.'" alt="'.$badge_name.'" title="'.$badge_name.'"> </a>';
					$html .= '</figure>';
				}
				
				if (isset( $badge_name ) && $badge_name != '' ) { 
					$html .= '<div class="left-sp">';
					$html .= '<h4><a href="">'.$badge_name.'</a></h4>';
				}
				
				if (isset( $badge_short ) && $badge_short != '' ) { 
					$html .= '<p>'.$badge_short.'</p>';
				}
				
				$html .= '</div>';
				if (isset( $cs_numbering ) && $cs_numbering == 'yes' ) { 
					$html .= '<span>'.$counter.'</span>';
				}
				$html .= '</li>';
				$i++;
			}
		} else {
			$html .= '<li>No Badges Found</li>';
		}
		$html .= '</ul>';
		$html .= '</div>';
        
		return do_shortcode($html);
	}
	add_shortcode('cs_badges', 'cs_badges_shortcode');
}