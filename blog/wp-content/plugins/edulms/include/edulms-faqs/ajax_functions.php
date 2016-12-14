<?php
	
	if ( ! function_exists( 'cs_faq_question_add' ) ) { 
		function cs_faq_question_add(){
			global $post, $wp_error;
			
			$user_email = empty($_POST["user_email"]) ? '' : $_POST["user_email"];
			$course_ID = empty($_POST["course_id"]) ? '' : $_POST["course_id"];
			$faq_user = empty($_POST["faq_user"]) ? '' : $_POST["faq_user"];
			$faq_quest = empty($_POST["faq_quest"]) ? '' : $_POST["faq_quest"];
			
			$args = array(
			  'post_status'           => 'private', 
			  'post_type'             => 'cs-faqs',
			  'post_title'    		  => $faq_quest,
			  'post_content'  		  => '',
			  'post_author'           => '',
			  'ping_status'           => get_option('default_ping_status'), 
			  'post_parent'           => 0,
			  'menu_order'            => 0,
			  'to_ping'               =>  '',
			  'pinged'                => '',
			  'post_password'         => '',
			  'guid'                  => '',
			  'post_content_filtered' => '',
			  'post_excerpt'          => '',
			  'import_id'             => 0
			);
			
			$error = '';
			if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$error[] = "Invalid email format"; 
			}
			if($faq_user == ''){
				$error[] = 'Please type your name.';
			}
			if($faq_quest == ''){
				$error[] = 'Please put your question.';
			}
			if(strlen($faq_quest) > 250){
				$error[] = 'Too Long Question. Max Length is 250 characters.';
			}
			
			if(is_array($error)){
				echo '<div class="error_mess">';
				foreach($error as $er){
					echo '<p>'.$er.'</p>';
				}
				echo '</div>';
			}
			else{
				
				$faq_id = wp_insert_post( $args, $wp_error );
				add_action( 'save_post', 'cs_ajax_faqs_meta_save' );
				cs_ajax_faqs_meta_save($faq_id);
				
				echo '<div class="succ_mess"><p>Your Question Successfuly Sent to Administrators to answer. Once your Quesion has been answered. You will be notified on Given Email.</p></div>';
			}
			die(0);			
		}
		add_action('wp_ajax_cs_faq_question_add', 'cs_faq_question_add');
		add_action('wp_ajax_nopriv_cs_faq_question_add', 'cs_faq_question_add');
	}
	
	if ( ! function_exists( 'cs_faqs_email_submit' ) ) { 
		function cs_faqs_email_submit(){
			global $post, $current_user;
			
			$faq_id = empty($_POST["faq_id"]) ? '' : $_POST["faq_id"];
			$email_subject = empty($_POST["email_subject"]) ? '' : $_POST["email_subject"];
			$emai_message = empty($_POST["emai_message"]) ? '' : $_POST["emai_message"];
			
			$get_faqs_answer = $emai_message;
			if($get_faqs_answer <> ''){
				// Sending Mail
				$get_faqs_email = get_post_meta($faq_id, "cs_faqs_email", true);
				
				if($email_subject <> ''){
					$subjecteEmail = $email_subject;
				}
				else{
					$subjecteEmail = "Answer Recieved from (" . get_bloginfo('name') . ")";
				}
				$message = '<table width="100%" border="0"><tr><td>'.$get_faqs_answer.'</tr></td></table>';
				$headers = "From: " . get_bloginfo('name') . "\r\n";
				$headers .= "Reply-To: " . $current_user->user_email . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
				$attachments = '';
				wp_mail( $get_faqs_email, $subjecteEmail, $message, $headers, $attachments );
				
				echo 'Answer has been sent through mail.';
			}
			else{
				echo 'Please submit a Message first.';
			}
			
			die(0);
		}
		add_action('wp_ajax_cs_faqs_email_submit', 'cs_faqs_email_submit');
	}
	
	
	function cs_ajax_faqs_meta_save( $faq_id ) {  
		$faq_user = empty($_POST["faq_user"]) ? '' : $_POST["faq_user"];
		$user_email = empty($_POST["user_email"]) ? '' : $_POST["user_email"];
		$course_ID = empty($_POST["course_id"]) ? '' : array($_POST["course_id"]);
		
		$sxe = new SimpleXMLElement("<faqs></faqs>");
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
		update_post_meta($faq_id, "cs_faqs_user", $faq_user);
		update_post_meta($faq_id, "cs_faqs_course", $course_ID);
		update_post_meta($faq_id, "cs_faqs_email", $user_email);
		
		update_post_meta( $faq_id, 'cs_meta_faqs', $sxe->asXML() );
	}
	
	add_filter('wp_mail_from', 'lms_mail_from');
	add_filter('wp_mail_from_name', 'lms_mail_from_name');
	function lms_mail_from($old) {
		$email = get_option( 'admin_email' );
		return $email;
	}
	function lms_mail_from_name($old) {
		$site_name = get_option( 'blogname');
		return $site_name;
	}
		
?>