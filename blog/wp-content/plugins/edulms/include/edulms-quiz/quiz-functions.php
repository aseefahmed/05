<?php
/**
 * IP Address
 */
if ( ! function_exists( 'cs_getIp' ) ) { 
	function cs_getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip;
	}
}

/**
 * Complete Quiz Submission
 */
if ( ! function_exists( 'cs_quiz_submit' ) ) { 
	function cs_quiz_submit(){
		global $post;
		$user_id = cs_get_user_id();
		$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
			$quiz_id = $post_id = $_POST['post_id'];
			$total_marks = $_POST['total_marks'];
			if(isset($post_id) && $post_id <> ''){
					if(isset($_POST['question_ids_array']) && is_array($_POST['question_ids_array']) && count($_POST['question_ids_array'])>0){
						$user_quiz_questions_data = array();
						$quiz_answer_array = array();
						$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
						$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-quiz-nswers', true);
						foreach($_POST['question_ids_array'] as $question_id){
							$transaction_id = $_POST['transaction_id'];
							$i = $question_id;
							$quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$post_id;
							$quiz_complete = get_option($quiz_complete_key);
							if(!isset($quiz_complete)){
								$quiz_complete = 1;
							} else if(isset($quiz_complete) && $quiz_complete == ''){
								$quiz_complete = 1;
							}
							$question_no = "question_$i";
							$total_marks = $_POST['total_marks'];
							$question_answer = '';
							if(isset($_POST[$question_no]))
								$question_answer = $_POST[$question_no];
							$question_no_array = array();
							$question_no_array = $user_quiz_questions_data[$i];
							if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
								if(isset($question_answer) && $question_answer <> '')
									$question_answer = implode("||",$question_answer);
							}
							$question_no_array['user_answer'] = $question_answer;
							$question_point = 0;
							if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
								if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
									$question_point = $user_quiz_questions_data[$i]['question_marks'];
								}
							}
							$question_no_array['user_question_point'] = $question_point;
							$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
						}
					}
					$quiz_result_array = array();
					$result_percentage = 0;
					$user_marks = 0;
					$result_wait = 0;
					$question_marks_points = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$remarks = 'Pending';
					$review_status = 'Pending';
					$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
					$quiz_auto_results = '';
					if(isset($user_quiz_info['quiz_auto_results'])){
						$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
					}
					if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
						$user_marks = 0;
						foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
							if($question_keys){
								if(isset($question_values['question_marks'])){
									$question_marks_points = $question_marks_points+$question_values['question_marks'];
								}
								if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
									if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
										$user_marks = $user_marks+$question_values['question_marks'];
									}
								} else {
									$result_wait = 1;
								}
							}
						}
						if($question_marks_points>0){
							$result_percentage = ($user_marks / $question_marks_points) * 100;
							$result_percentage = round($result_percentage, 2);
						}
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
							$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
							if($result_percentage>$quiz_passing_marks){
								$remarks = 'Pass';
							} else  {
								$remarks = 'Fail';
							}
						}
						if($result_wait == 1){
							$remarks = 'Pending';							
						}
						$review_status = $remarks;
					}
					$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
					$quiz_result_array['ip_address'] = cs_getIp();
					$quiz_result_array['user_id'] = cs_get_user_id();
					$quiz_result_array['total_marks'] = $question_marks_points;
					$quiz_result_array['marks'] = $user_marks;
					$quiz_result_array['review_status'] = $review_status;
					$quiz_result_array['remarks'] = $remarks;
					$quiz_result_array['grade'] = '';
					$quiz_result_array['marks_percentage'] = $result_percentage;
					$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
					$quiz_success_message = '';
					if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
						$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
					$quiz_complete++;
					update_option($quiz_complete_key, $quiz_complete);
					$last_quiz_complete_key = cs_get_user_id().'_'.$post_id.'_'.$transaction_id.'_last';
					update_option($last_quiz_complete_key, 'yes');
					update_user_meta($user_id,'cs-quiz-nswers',$quiz_answer_array);
					echo esc_attr($quiz_success_message);
			}
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_quiz_submit", "cs_quiz_submit");
	add_action('wp_ajax_cs_quiz_submit', 'cs_quiz_submit');
}


/**
 * Quiz Result Remarks
 */
if ( ! function_exists( 'cs_quiz_result_remarks' ) ) { 
	function cs_quiz_result_remarks(){
		global $post;
		$user_id = cs_get_user_id();
		//print_r($_POST);
		$quiz_marks_array = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				$post_id = $_POST['post_id'];
				$user_id = $_POST['user_id'];
				$total_marks = $_POST['marks'];
				$remarks = $_POST['remarks'];
				
				
				if(isset($post_id) && $post_id <> '' && $_POST['user_id'] <> ''){
					$quiz_marks_array = get_user_meta($user_id,'cs-quiz_result', true);
					$quiz_marks_array[$post_id]['marks'] = $total_marks;
					$quiz_marks_array[$post_id]['remarks'] = $remarks;
					
					if(isset($_POST['attempts']) && $_POST['attempts'] <> ''){
						$attempts = $_POST['attempts'];
						$quiz_marks_array[$post_id]['quiz_attempts'] = $attempts;
					}
					update_user_meta($user_id,'cs-quiz_result',$quiz_marks_array);
					echo "<span>Record updated Successfully</span>";
					
				
				}
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_quiz_result_remarks", "cs_quiz_result_remarks");
	add_action('wp_ajax_cs_quiz_result_remarks', 'cs_quiz_result_remarks');
}

 
/**
 * Single Question Data
 */
if ( ! function_exists( 'cs_quiz_single_question_submit' ) ) { 
	function cs_quiz_single_question_submit(){
		global $post;
		$user_id = cs_get_user_id();
		//$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				$quiz_id = $post_id = $_POST['post_id'];
				$transaction_id = $_POST['transaction_id'];
				$i = $_POST['question_key'];
				
				$quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$post_id;
				$quiz_complete = get_option($quiz_complete_key);
				if(!isset($quiz_complete)){
					$quiz_complete = 1;
				} else if(isset($quiz_complete) && $quiz_complete == ''){
					$quiz_complete = 1;
				}
				$review_status = 'Pending';
				$question_number = $_POST['question_no'];
				$total_questions = $_POST['total_questions'];
				$question_no = "question_$i";
				$total_marks = $_POST['total_marks'];
				$question_answer = '';
				if(isset($_POST[$question_no]))
					$question_answer = $_POST[$question_no];
				// Quuiz Question and answers Array
				$question_no_array = array();
				$user_quiz_questions_data = array();
				$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
				$question_no_array = $user_quiz_questions_data[$i];
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if(isset($question_answer) && $question_answer <> '')
						$question_answer = implode("||",$question_answer);
				}
				$question_no_array['user_answer'] = $question_answer;
				$question_point = 0;
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
						$question_point = $user_quiz_questions_data[$i]['question_marks'];
					}
				}
				
				$question_no_array['user_question_point'] = $question_point;
				$quiz_answer_array = array();
				$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-quiz-nswers', true);
				$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
				$last_quiz_complete_key = cs_get_user_id().'_'.$post_id.'_'.$transaction_id.'_last';
				update_option($last_quiz_complete_key, 'no');
				// Last Question Check
				if($question_number == $total_questions){
					$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
					$quiz_auto_results = '';
					if(isset($user_quiz_info['quiz_auto_results'])){
						$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
					}
					$user_marks = '';
					// Quiz Auto result Calculation
					$quiz_result_array = array();
					$result_percentage = 0;
					$user_marks = 0;
					$result_wait = 0;
					$question_marks_points = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$remarks = 'Pending';
					$quiz_passing_marks = 0;
					$answer_title_multiple_option_correct = '';
					if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
						foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
							if($question_keys){
								if(isset($question_values['question_marks'])){
									$question_marks_points = $question_marks_points+(int)$question_values['question_marks'];
								}
								if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
									if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
										$user_marks = $user_marks+$question_values['question_marks'];
									}
								} else {
									$result_wait = 1;
								}
							}
						}
						if($question_marks_points>0){
							$result_percentage = ($user_marks / $question_marks_points) * 100;
							$result_percentage = round($result_percentage, 2);
						}
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
							$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
							if($result_percentage>$quiz_passing_marks){
								$remarks = 'Pass';
							} else {
								$remarks = 'Fail';
							}
						}
						if($result_wait == 1){
							$remarks = 'Pending';							
						}
						$review_status = $remarks;
					}
					// Marks Array
					$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
					$quiz_result_array['ip_address'] = cs_getIp();
					$quiz_result_array['user_id'] = cs_get_user_id();
					$quiz_result_array['total_marks'] = $question_marks_points;
					$quiz_result_array['marks'] = $user_marks;
					$quiz_result_array['review_status'] = $review_status;
					$quiz_result_array['remarks'] = $remarks;
					$quiz_result_array['grade'] = '';
					$quiz_result_array['marks_percentage'] = $result_percentage;
					$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
					$quiz_success_message = '';
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
					if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
						$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
					$quiz_complete++;
					update_option($quiz_complete_key, $quiz_complete);
					update_option($last_quiz_complete_key, 'yes');
						echo esc_attr($quiz_success_message);
				}
				$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
				update_user_meta($user_id,'cs-quiz-nswers',$quiz_answer_array);
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_quiz_single_question_submit", "cs_quiz_single_question_submit");
	add_action('wp_ajax_cs_quiz_single_question_submit', 'cs_quiz_single_question_submit');
}

/**
 * Free Quiz Single Submit
 */
if ( ! function_exists( 'cs_free_quiz_submit' ) ) { 
	function cs_free_quiz_submit(){
		global $post;
		$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				$quiz_id = $post_id = $_POST['post_id'];
				$course_ID = $_POST['course_id'];
				$total_marks = $_POST['total_marks'];
				if(isset($post_id) && $post_id <> ''){
					if(isset($_POST['question_ids_array']) && is_array($_POST['question_ids_array']) && count($_POST['question_ids_array'])>0){
						$user_quiz_questions_data = array();
						$quiz_answer_array = array();
						$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
						$quiz_answer_array = get_transient( "cs_course_quiz".$course_ID.$quiz_id );
						foreach($_POST['question_ids_array'] as $question_id){
							$transaction_id = $_POST['transaction_id'];
							$i = $question_id;
							$quiz_complete = 1;
							$question_no = "question_$i";
							$total_marks = $_POST['total_marks'];
							$question_answer = '';
							if(isset($_POST[$question_no]))
								$question_answer = $_POST[$question_no];
							$question_no_array = array();
							$question_no_array = $user_quiz_questions_data[$i];
							if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
								if(isset($question_answer) && $question_answer <> '')
									$question_answer = implode("||",$question_answer);
							}
							$question_no_array['user_answer'] = $question_answer;
							$question_point = 0;
							
							if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
								if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
									$question_point = $user_quiz_questions_data[$i]['question_marks'];
								}
							}
							$question_no_array['user_question_point'] = $question_point;
							$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
						}
					}
					$quiz_result_array = array();
					$result_percentage = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$remarks = 'Pending';
					$review_status = 'Pending';
					$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
					$quiz_auto_results = '';
					if(isset($user_quiz_info['quiz_auto_results'])){
						$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
					}
					if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
						$user_marks = 0;
						foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
							if($question_keys){
								if(isset($question_values['question_marks'])){
									$question_marks_points = $question_marks_points+$question_values['question_marks'];
								}
								if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
									if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
										$user_marks = $user_marks+$question_values['question_marks'];
									}
								} else {
									$result_wait = 1;
								}
							}
						}
						if($question_marks_points>0){
							$result_percentage = ($user_marks / $question_marks_points) * 100;
							$result_percentage = round($result_percentage, 2);
						}
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
							$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
							if($result_percentage>$quiz_passing_marks){
								$remarks = 'Pass';
							} else  {
								$remarks = 'Fail';
							}
						}
						$review_status = $remarks;
					}
					$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
					$quiz_result_array['ip_address'] = cs_getIp();
					$quiz_result_array['total_marks'] = $question_marks_points;
					$quiz_result_array['user_id'] = cs_get_user_id();
					$quiz_result_array['marks'] = $user_marks;
					$quiz_result_array['remarks'] = $remarks;
					$quiz_result_array['review_status'] = $review_status;
					$quiz_result_array['grade'] = '';
					$quiz_result_array['marks_percentage'] = $result_percentage;
					$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
					$quiz_success_message = '';
					if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
						$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
					set_transient( "cs_course_quiz".$course_ID.$post->ID, $quiz_answer_array );
					echo esc_attr($quiz_success_message);
				}
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_free_quiz_submit", "cs_free_quiz_submit");
	add_action('wp_ajax_cs_free_quiz_submit', 'cs_free_quiz_submit');
}



/**
 * Free Quiz Single Question Data
 */
if ( ! function_exists( 'cs_free_quiz_single_question_submit' ) ) { 
	function cs_free_quiz_single_question_submit(){
		global $post;
		//$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				$quiz_id = $post_id = $_POST['post_id'];
				$course_ID = $_POST['course_id'];
				$transaction_id = $_POST['transaction_id'];
				$i = $_POST['question_key'];
				$quiz_complete = 1;
				$question_number = $_POST['question_no'];
				$total_questions = $_POST['total_questions'];
				$question_no = "question_$i";
				$total_marks = $_POST['total_marks'];
				$question_answer = '';
				if(isset($_POST[$question_no]))
					$question_answer = $_POST[$question_no];
				// Quuiz Question and answers Array
				$question_no_array = array();
				$user_quiz_questions_data = array();
				
				$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
				$question_no_array = $user_quiz_questions_data[$i];
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if(isset($question_answer) && $question_answer <> '')
						$question_answer = implode("||",$question_answer);
				}
				$question_no_array['user_answer'] = $question_answer;
				$question_point = 0;
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
						$question_point = $user_quiz_questions_data[$i]['question_marks'];
					}
				}
				$question_no_array['user_question_point'] = $question_point;
				$quiz_answer_array = array();
				$quiz_answer_array = get_transient( "cs_course_quiz".$course_ID.$quiz_id.$transaction_id );
				$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
				$last_quiz_complete_key = $course_ID.'_'.$post_id.'_'.$transaction_id.'_last';
				update_option($last_quiz_complete_key, 'no');
				// Last Question Check
				if($question_number == $total_questions){
					$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
					$quiz_auto_results = '';
					if(isset($user_quiz_info['quiz_auto_results'])){
						$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
					}
					$user_marks = '';
					// Quiz Auto result Calculation
					$quiz_result_array = array();
					$result_percentage = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$user_marks = 0;
					$result_wait = 0;
					$question_marks_points = 0;
					$remarks = 'Pending';
					$review_status = 'Pending';
					$quiz_passing_marks = 0;
					if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
						foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
							if($question_keys){
								if(isset($question_values['question_marks'])){
									$question_marks_points = $question_marks_points+(int)$question_values['question_marks'];
								}
								if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
									if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
										$user_marks = $user_marks+$question_values['question_marks'];
									}
								} else {
									$result_wait = 1;
								}
								
							}
						}
						if($question_marks_points>0){
							$result_percentage = ($user_marks / $question_marks_points) * 100;
							$result_percentage = round($result_percentage, 2);
						}
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
							$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
							if($result_percentage>$quiz_passing_marks){
								$remarks = 'Pass';
							} else {
								$remarks = 'Fail';
							}
						}
						if($result_wait == 1){
							$remarks = 'Pending';							
						}
						$review_status = $remarks;
					}
					// Marks Array
					$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
					$quiz_result_array['ip_address'] = cs_getIp();
					$quiz_result_array['total_marks'] = $question_marks_points;
					$quiz_result_array['marks'] = $user_marks;
					$quiz_result_array['remarks'] = $remarks;
					$quiz_result_array['review_status'] = $review_status;
					$quiz_result_array['grade'] = '';
					$quiz_result_array['marks_percentage'] = $result_percentage;
					$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
					$quiz_success_message = '';
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
					if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
						$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
					echo esc_attr($quiz_success_message);
				}
				$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
				set_transient( "cs_course_quiz".$course_ID.$post_id.$transaction_id, $quiz_answer_array );
	
				
				if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
					$counter_courses = 420;
					if(isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0){
					?>
					<h3><?php _e('Quiz Results', 'EDULMS');?></h3>
					<div class="my-courses">
						<ul class="top-sec">
							<li><?php _e('Quiz Name', 'EDULMS');?></li>
							<li><?php _e('Submission', 'EDULMS');?></li>
							<li><?php _e('Q-Taken', 'EDULMS');?></li>
							<li><?php _e('Marks', 'EDULMS');?></li>
							<li><?php _e('Score', 'EDULMS');?></li>
							<li><?php _e('Remarks', 'EDULMS');?></li>
							<li></li>
						</ul>
					
					<?php
						foreach($quiz_answer_array as $transaction_id=>$quiz_answer_values){
							foreach($quiz_answer_values as $quiz_id=>$quiz_answers){	
								$attempt_no = $quiz_complete = 1;
								$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
								$user_quiz_info = $user_quiz_array['quiz_information'];
								$quiz_passing_marks = 33;
								if(isset($user_quiz_info['quiz_passing_marks']))
									$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
								$user_quiz_result_info = $user_quiz_array['quiz_result'];
								$user_course_information = $user_quiz_array['course_information'];
								if(isset($user_course_information['course_title']))
									$course_title = $user_course_information['course_title'];
								$user_quiz_questions = $user_quiz_array['questions'];
								$attempt_questions = 0;
								$total_questions = count($user_quiz_questions);
								foreach($user_quiz_questions as $questions_key=>$questions_values){
									if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
										$attempt_questions++;
								}
								$user_points = '-';
								$question_marks_points = '-';
								$result_percentage = '-';
								$resutl_remarks = '';
								if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
									$resutl_remarks = $user_quiz_result_info['remarks'];
								if(isset($resutl_remarks) && $resutl_remarks <> 'Pending'){
									if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
										$user_points = $user_quiz_result_info['marks'];
									$question_marks_points = '-';
									if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
										$question_marks_points = $user_quiz_result_info['total_marks'];
									if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
										$result_percentage = $user_quiz_result_info['marks_percentage'].'%';
								}
								$attempt_date = '';
								if(isset($user_quiz_result_info['attempt_date']))
									$attempt_date = $user_quiz_result_info['attempt_date'];
									if(isset($user_quiz_info)){
										$counter_courses++;
									?>
									<script>
									  jQuery(document).ready(function($){
										  $('#toggle-<?php echo esc_js($counter_courses);?>').click(function() {
											  $('#toggle-div-<?php echo esc_js($counter_courses);?>').slideToggle('slow', function() {});
										  });
									  });
									</script>
									
										<ul class="bottom-sec">
											<li><?php echo esc_attr($course_title.' - '.$user_quiz_info['title']);?></li>
											<li><?php echo esc_attr($attempt_date);?></li>
											<li><?php echo esc_attr($attempt_questions.'/'.$total_questions);?></li>
											 <li><?php echo esc_attr($user_points.'/'.$question_marks_points);?></li>
											  <li><?php echo esc_attr($result_percentage);?></li>
											   <li><?php echo esc_attr($resutl_remarks);?></li>
											<li><a href="#" id="toggle-<?php echo esc_attr($counter_courses);?>" ><i class="fa fa-plus"></i></a></li>
										</ul>
										<div class="toggle-sec">
											<!--Quiz Questions listing-->
											<div class="toggle-div" id="toggle-div-<?php echo esc_attr($counter_courses);?>">
											<?php
													if($total_questions>0){
														?>
													<ul class="pagination quiz-pagination">
													  <?php 
															$counter_rand_no = rand(999,88888);
															$counter_rand_no_j = $counter_rand_no;
															$counter_rand_no_k = $counter_rand_no;
															for($j=1; $j<=$total_questions; $j++){
																$active_class = '';
																if($j==1){$active_class = 'active';}
															?>
																<li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"> <a onclick="cs_quiz_result_show_pagination('<?php echo esc_js($counter_rand_no);?>','<?php echo esc_js($counter_rand_no_j);?>',<?php echo esc_js($counter_rand_no+$total_questions);?>, <?php echo esc_js($j);?>)"><?php echo absint($j);?></a> </li>
													  <?php 
															$counter_rand_no_j++;
															}
															?>
													</ul>
													<?php 
															$counter  = 0;
															foreach ( $user_quiz_questions as $question_key=>$question ){
																$question_title = $question['question_title'];
																$question_marks = $question['question_marks'];
																$answer_type = $question['answer_type'];
																$user_answer = $question['user_answer'];
																$user_question_point = $question['user_question_point'];
															$counter++;
															$style_class = '';
															if($counter <> 1){
																$style_class = 'style="display:none;"';	
															}
														?>
													<div class="question-number question-<?php echo esc_attr($counter_rand_no_k);?>" <?php echo $style_class;?>>
													  <h5 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($question_title);?></h5>
													  <?php
														  $counter_rand_no_k++;
														  if(isset($answer_type) && $answer_type == 'multiple-option'){
																  $question_grade = '';
																  $answer_title_multiple_option = $question['answer_title_multiple_option'];
																  $answer_title_multiple_option_correct = $question['answer_title_multiple_option_correct'];
																  if($user_answer == $answer_title_multiple_option_correct)
																	  $question_grade = 'right';
																  else if($user_answer <> $answer_title_multiple_option_correct)
																	  $question_grade = 'wrong';
																  $answer_title_multiple_option = explode('||',$answer_title_multiple_option);
																  $answer_title_multiple_option_correct = explode('||',$answer_title_multiple_option_correct);
																  $answer_user_answer = explode('||',$user_answer);
														?>
													  <ul class="check-box">
														<?php 
															$counter_option = 0;
															foreach($answer_title_multiple_option as $answeroption_value){
																$counter_option++;
																$checked_value = '';
																if(in_array($counter_option, $answer_title_multiple_option_correct)){
																	$correct_flag = 1;
																} else {
																	$correct_flag = 0;
																}
																if(in_array($counter_option, $answer_user_answer)){
																	$user_flag = 1;
																} else {
																	$user_flag = 0;
																}
																if($correct_flag == 1 && $user_flag == 1){
																	$checkbox_class = 'right-click';
																	$checked_value = 'checked';
																}else if($correct_flag == 0 && $user_flag == 0)
																	$checkbox_class = '';
																else if(($correct_flag == 0 && $user_flag == 1)){
																	$checked_value = 'checked';
																	$checkbox_class = 'wrong-click';
																}else if(($correct_flag == 1 && $user_flag == 0)){
																	$checked_value = '';
																	$checkbox_class = 'right-click';
																}else if(($correct_flag == 0 && $user_flag == 1) || ($correct_flag == 1 && $user_flag == 0))
																	$checkbox_class = 'wrong-click';
														?>
														<li>
														  <input id="checkbox1" type="checkbox" <?php echo esc_attr($checked_value);?> disabled="disabled" />
														  <label for="checkbox1" class="<?php echo esc_attr($checkbox_class);?>"><?php echo esc_attr($answeroption_value);?></label>
														</li>
														<?php 
																				}
																			?>
													  </ul>
													  <?php } else if(isset($answer_type) && $answer_type == 'large-text'){
																	$answer_large_text = $question['answer_large_text'];
																	if($user_answer == $answer_large_text)
																		$question_grade = 'right';
																	else if($user_answer <> $answer_large_text)
																		$question_grade = 'wrong';
													  ?>
													  <div class="textarea-sec">
														<textarea><?php echo esc_textarea($user_answer);?></textarea>
														<h6><?php _e('Remarks', 'EDULMS');?></h6>
														<textarea class="bg-textarea"><?php echo esc_textarea($answer_large_text);?></textarea>
													  </div>
													  <?php }?>
													  <div class="score-sec">
														<ul class="left-sec">
														  <li>
															<label><?php _e('Score', 'EDULMS');?></label>
															<!--  <input type="text" placeholder="0" />--> 
															<span><?php echo absint($user_question_point).'/'.absint($question_marks);?></span> 
															<!--<a href="#">update</a>--> 
														  </li>
														</ul>
														<ul class="right-sec <?php echo esc_attr($question_grade);?>-click-icon">
														  <li>
															<?php if($question_grade == 'right')
																	 echo 'Correct';
																  else if($question_grade == 'wrong')
																	echo 'Wrong';
																 else 
																	echo 'Chosen';
															 ?>
														  </li>
														</ul>
													  </div>
													</div>
													<?php
															}
														
														} else {
															_e('There are no questions against this quiz', 'EDULMS');
														}
											?>
											
											</div>
										</div>
									<?php
									}
							}
						}
					?>
					</div>
					<?php
					} else {
						_e('There are no records avaialble', 'EDULMS');
					}
				}
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_free_quiz_single_question_submit", "cs_free_quiz_single_question_submit");
	add_action('wp_ajax_cs_free_quiz_single_question_submit', 'cs_free_quiz_single_question_submit');
}


/**
 * Complete Quiz Submission
 */
if ( ! function_exists( 'cs_registereduser_quiz_submit' ) ) { 
	function cs_registereduser_quiz_submit(){
		global $post;
		$user_id = cs_get_user_id();
		$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				$quiz_id = $post_id = $_POST['post_id'];
				$total_marks = $_POST['total_marks'];
				if(isset($post_id) && $post_id <> ''){
						if(isset($_POST['question_ids_array']) && is_array($_POST['question_ids_array']) && count($_POST['question_ids_array'])>0){
							$user_quiz_questions_data = array();
							$quiz_answer_array = array();
							$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
							$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-registered-free-quiz-answers', true);
							foreach($_POST['question_ids_array'] as $question_id){
								$transaction_id = $_POST['transaction_id'];
								$i = $question_id;
								$quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$post_id;
								$quiz_complete = get_option($quiz_complete_key);
								if(!isset($quiz_complete)){
									$quiz_complete = 1;
								} else if(isset($quiz_complete) && $quiz_complete == ''){
									$quiz_complete = 1;
								}
								$question_no = "question_$i";
								$total_marks = $_POST['total_marks'];
								$question_answer = '';
								if(isset($_POST[$question_no]))
									$question_answer = $_POST[$question_no];
								$question_no_array = array();
								$question_no_array = $user_quiz_questions_data[$i];
								if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
									if(isset($question_answer) && $question_answer <> '')
										$question_answer = implode("||",$question_answer);
								}
								$question_no_array['user_answer'] = $question_answer;
								$question_point = 0;
								if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
									if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
										$question_point = $user_quiz_questions_data[$i]['question_marks'];
									}
								}
								$question_no_array['user_question_point'] = $question_point;
								$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
							}
						}
						$quiz_result_array = array();
						$result_percentage = 0;
						$user_marks = 0;
						$result_wait = 0;
						$question_marks_points = 0;
						$user_marks = 0;
						$question_marks_points = 0;
						$remarks = 'Pending';
						$review_status = 'Pending';
						$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
						$quiz_auto_results = '';
						if(isset($user_quiz_info['quiz_auto_results'])){
							$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
						}
						if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
							$user_marks = 0;
							foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
								if($question_keys){
									if(isset($question_values['question_marks'])){
										$question_marks_points = $question_marks_points+$question_values['question_marks'];
									}
									if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
										if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
											$user_marks = $user_marks+$question_values['question_marks'];
										}
									} else {
										$result_wait = 1;
									}
								}
							}
							if($question_marks_points>0){
								$result_percentage = ($user_marks / $question_marks_points) * 100;
								$result_percentage = round($result_percentage, 2);
							}
							if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
								$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
								if($result_percentage>$quiz_passing_marks){
									$remarks = 'Pass';
								} else  {
									$remarks = 'Fail';
								}
							}
							if($result_wait == 1){
								$remarks = 'Pending';							
							}
							$review_status = $remarks;
						}
						$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
						$quiz_result_array['ip_address'] = cs_getIp();
						$quiz_result_array['user_id'] = cs_get_user_id();
						$quiz_result_array['total_marks'] = $question_marks_points;
						$quiz_result_array['marks'] = $user_marks;
						$quiz_result_array['review_status'] = $review_status;
						$quiz_result_array['remarks'] = $remarks;
						$quiz_result_array['grade'] = '';
						$quiz_result_array['marks_percentage'] = $result_percentage;
						$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
						$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
						$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
						$quiz_success_message = '';
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
							$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
						$quiz_complete++;
						update_option($quiz_complete_key, $quiz_complete);
						$last_quiz_complete_key = cs_get_user_id().'_'.$post_id.'_'.$transaction_id.'_last';
						update_option($last_quiz_complete_key, 'yes');
						update_user_meta($user_id,'cs-registered-free-quiz-answers',$quiz_answer_array);
						echo esc_attr($quiz_success_message);
				}
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_registereduser_quiz_submit", "cs_registereduser_quiz_submit");
	add_action('wp_ajax_cs_registereduser_quiz_submit', 'cs_registereduser_quiz_submit');
}

/**
 * Registered User Single Question Data
 */
if ( ! function_exists( 'cs_registered_user_quiz_single_question_submit' ) ) { 
	function cs_registered_user_quiz_single_question_submit(){
		global $post;
		//$quiz_answers = array();
		if ( $_SERVER["REQUEST_METHOD"] == "POST"){
		/*	echo '<pre>';
			print_r($_POST);
			echo '</pre>';*/
				$quiz_id = $post_id = $_POST['post_id'];
				$user_id = $_POST['user_id'];
				$course_ID = $_POST['course_id'];
				$transaction_id = $_POST['transaction_id'];
				$i = $_POST['question_key'];
				$quiz_complete = 1;
				$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$post_id;
				$quiz_complete = get_option($quiz_complete_key);
				if(!isset($quiz_complete)){
					$quiz_complete = 1;
				} else if(isset($quiz_complete) && $quiz_complete == ''){
					$quiz_complete = 1;
				}
				$review_status = 'Pending';
				$question_number = $_POST['question_no'];
				$total_questions = $_POST['total_questions'];
				$question_no = "question_$i";
				$total_marks = $_POST['total_marks'];
				$question_answer = '';
				if(isset($_POST[$question_no]))
					$question_answer = $_POST[$question_no];
				// Quuiz Question and answers Array
				$question_no_array = array();
				$user_quiz_questions_data = array();
				$user_quiz_questions_data = get_post_meta($post_id, "cs_quiz_questions_meta", true);
				$question_no_array = $user_quiz_questions_data[$i];
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if(isset($question_answer) && $question_answer <> '')
						$question_answer = implode("||",$question_answer);
				}
				$question_no_array['user_answer'] = $question_answer;
				$question_point = 0;
				if(isset($question_no_array['answer_type']) && $question_no_array['answer_type'] <> 'large-text'){
					if(isset($user_quiz_questions_data[$i]['answer_title_multiple_option_correct']) and $user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
						$question_point = $user_quiz_questions_data[$i]['question_marks'];
					}
				}
				$question_no_array['user_question_point'] = $question_point;
				$quiz_answer_array = array();
				$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
				//$quiz_answer_array = get_transient( "cs_course_quiz".$course_ID.$quiz_id.$transaction_id );
				$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
				$last_quiz_complete_key = $course_ID.'_'.$post_id.'_'.$transaction_id.'_last';
				update_option($last_quiz_complete_key, 'no');
				// Last Question Check
				if($question_number == $total_questions){
					$user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
					$quiz_auto_results = '';
					if(isset($user_quiz_info['quiz_auto_results'])){
						$quiz_auto_results = $user_quiz_info['quiz_auto_results'];
					}
					$user_marks = '';
					// Quiz Auto result Calculation
					$quiz_result_array = array();
					$result_percentage = 0;
					$user_marks = 0;
					$question_marks_points = 0;
					$user_marks = 0;
					$result_wait = 0;
					$question_marks_points = 0;
					$remarks = 'Pending';
					$review_status = 'Pending';
					$quiz_passing_marks = 0;
					if(isset($quiz_auto_results) && (string)$quiz_auto_results == 'on'){
						foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
							if($question_keys){
								if(isset($question_values['question_marks'])){
									$question_marks_points = $question_marks_points+(int)$question_values['question_marks'];
								}
								if(isset($question_values['answer_type']) && $question_values['answer_type'] <> 'large-text'){
									if(isset($question_values['answer_title_multiple_option_correct']) and $question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
										$user_marks = $user_marks+$question_values['question_marks'];
									}
								} else {
									$result_wait = 1;
								}
							}
						}
						if($question_marks_points>0){
							$result_percentage = ($user_marks / $question_marks_points) * 100;
							$result_percentage = round($result_percentage, 2);
						}
						if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'])){
							$quiz_passing_marks = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_passing_marks'];
							if($result_percentage>$quiz_passing_marks){
								$remarks = 'Pass';
							} else {
								$remarks = 'Fail';
							}
						}
						if($result_wait == 1){
							$remarks = 'Pending';							
						}
						$review_status = $remarks;
					}
					// Marks Array
					$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
					$quiz_result_array['ip_address'] = cs_getIp();
					$quiz_result_array['total_marks'] = $question_marks_points;
					$quiz_result_array['marks'] = $user_marks;
					$quiz_result_array['remarks'] = $remarks;
					$quiz_result_array['review_status'] = $review_status;
					$quiz_result_array['grade'] = '';
					$quiz_result_array['marks_percentage'] = $result_percentage;
					$quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
					$quiz_success_message = '';
					$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
					if(isset($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message']))
						$quiz_success_message = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information']['quiz_success_message'];
					$quiz_complete++;
					update_option($quiz_complete_key, $quiz_complete);
					update_option($last_quiz_complete_key, 'yes');
					echo esc_attr($quiz_success_message);
				}
				$quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
				update_user_meta($user_id, 'cs-registered-free-quiz-answers', $quiz_answer_array);
				//print_r($quiz_answer_array);
				//set_transient( "cs_course_quiz".$course_ID.$post_id.$transaction_id, $quiz_answer_array );
		}
		exit;
	}
	add_action("wp_ajax_nopriv_cs_registered_user_quiz_single_question_submit", "cs_registered_user_quiz_single_question_submit");
	add_action('wp_ajax_cs_registered_user_quiz_single_question_submit', 'cs_registered_user_quiz_single_question_submit');
}

/**
 * Check Results
 */
if ( ! function_exists( 'cs_check_question_result' ) ) { 
	function cs_check_question_result($post_id, $result, $ques_no){
		$post_xml = get_post_meta($post_id, "cs_quiz", true);	
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
			$counter=0;
			$question_no = 0;
			$ques_no = str_replace('question_','',$ques_no);
			foreach ( $cs_xmlObject->question as $question ){
				$question_no++;
				$question_id = $question->question_id;
				if($question_id == $ques_no){
					$answer_type = $question->answer_type;
					$question_marks = $question->question_marks;
					
					
					if($answer_type == 'single-option'){
						$answer_arrray = array();
						$answer_title_single_option_1_true = $question->answer_title_single_option_1_true;
						if($answer_title_single_option_1_true == 'correct'){
							$answer_arrray[] = $answer_title_single_option_1_true;
						}
						$answer_title_single_option_2_true = $question->answer_title_single_option_2_true;
						if($answer_title_single_option_2_true == 'correct'){
							$answer_arrray[] = $answer_title_single_option_2_true;
						}
						//$result = $a === array_intersect($result, $answer_arrray);
						
						if($result === $answer_arrray){
							return $question_marks;
						} else {
							return 0;
						}
						
					} else if($answer_type == 'multiple-option'){
						$result = (array)$result;
						$title_multiple_option_correct =  "answer_title_multiple_option_correct_$question_no";
						$multioption_array_correct = (string)$question->$title_multiple_option_correct;
						$multiple_option_correct = explode("||",$multioption_array_correct);
						$multiple_option_correct = (array)$multiple_option_correct;
						if($result === $multiple_option_correct){
							return $question_marks;
						} else {
							return 	0;
						}
					} else if($answer_type == 'one-word-answer'){
						$answer_title_one_word = $question->answer_title_one_word;
						if(strtolower($result) == strtolower($answer_title_one_word)){
							return $question_marks;
						} else {
							return 0;
						}
					} else if($answer_type == 'large-text'){
						$answer_large_text = $question->answer_large_text;
						if(strtolower($result) == strtolower($answer_large_text)){
							return $question_marks;
						} else {
							return 0;
						}
					
					} else if($answer_type == 'true-false'){	
						$true_false_correnct_answer = $question->true_false_correnct_answer;
						if(strtolower($result) == strtolower($true_false_correnct_answer)){
							return $question_marks;
						} else {
							return 0;
						}
					}
				}
				
			 $counter++;	
			}
			
		}
	}
}

/**
 * Courses Quiz and Assignments Listing
 */
if ( ! function_exists( 'cs_courses_quiz_assignment_records_ajax' ) ) { 
	function cs_courses_quiz_assignment_records_ajax(){
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
	
		$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		$pending_result = 0;
		 if((isset($quiz_answer_array[$transaction_id]) && count($quiz_answer_array[$transaction_id])>0 && array_key_exists((string)$transaction_id, $quiz_answer_array)) || (isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array))){
			 ?>
				<table>
				  <thead>
					<tr>
					  <th class="first-th"><?php _e('Quiz and Assignments', 'EDULMS');?></th>
					  <th><?php _e('Attempts', 'EDULMS');?></th>
					  <th><?php _e('Required (%)', 'EDULMS');?></th>
					  <th><?php _e('Score', 'EDULMS');?></th>
					  <th><?php _e('Review', 'EDULMS');?></th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
						$average_percentage = 0;
						$counter_recoreds = 0;
						$average_getting_marks = 0;
						$avarage_passing_marks = 0;
						$average_total_marks = 0;
						$Fail_result = 0;
						
						// Course Attempted Quiz Listing
						if(isset($quiz_answer_array[$transaction_id]) && count($quiz_answer_array[$transaction_id])>0 && array_key_exists((string)$transaction_id, $quiz_answer_array)){
							if (array_key_exists((string)$transaction_id, $quiz_answer_array)) {
							foreach($quiz_answer_array[$transaction_id] as $quiz_id=>$quiz_answers){	
							$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
							$quiz_complete = get_option($quiz_complete_key);
							if(!isset($quiz_complete)){
								$quiz_complete = 1;
							} else if(isset($quiz_complete) && $quiz_complete == ''){
								$quiz_complete = 1;
							}
							$attempt_no = $quiz_complete-1;
							
							if(isset($quiz_answers['quiz_attempt']['quiz_attempt_no'])){
								$attempt_no = $user_quiz_attempts = $quiz_answers['quiz_attempt']['quiz_attempt_no'];
							}
							
							$no_of_retakes_allowed = '1';
							if(isset($quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed']))
								$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
							
							if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
							$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
							$user_quiz_info = array();
							if(isset($user_quiz_array['quiz_information']))
								$user_quiz_info = $user_quiz_array['quiz_information'];
							$user_quiz_result_info = $user_quiz_array['quiz_result'];
							$user_quiz_questions = $user_quiz_array['questions'];
							$attempt_questions = 0;
							$total_questions = count($user_quiz_questions);
							foreach($user_quiz_questions as $questions_key=>$questions_values){
								if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
									$attempt_questions++;
							}
							$user_points = 0;
							$question_marks_points = 0;
							$result_percentage = 0;
							$resutl_remarks = '';
							if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
								$resutl_remarks = $user_quiz_result_info['remarks'];
							if(isset($user_quiz_result_info['review_status']) && !empty($user_quiz_result_info['review_status']))
								$review_status = $user_quiz_result_info['review_status'];
								if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
									$user_points = $user_quiz_result_info['marks'];
								if(empty($user_points))
									$user_points = 0;
								if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
									$question_marks_points = $user_quiz_result_info['total_marks'];
								$average_total_marks  =$average_total_marks+$question_marks_points;
								if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
									$result_percentage = $user_quiz_result_info['marks_percentage'];
							$attempt_date = '';
							if(isset($user_quiz_result_info['attempt_date']))
								$attempt_date = $user_quiz_result_info['attempt_date'];
							$quiz_passing_marks = '';
							if(isset($user_quiz_info['quiz_passing_marks'])){
								$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
							}
							if(isset($review_status) && ($review_status == 'Fail')){
								$Fail_result = 1;
							} else if(isset($review_status) && ($review_status == 'Pass')){
								 $avarage_passing_marks = $avarage_passing_marks+$quiz_passing_marks;
								 $average_percentage = $average_percentage+$result_percentage;
								 $average_getting_marks  =$average_getting_marks+$user_points;
								 
							}
							if(isset($review_status) && ($review_status == 'Pending' ||  $review_status == 'Remaining')){	
								$pending_result = 1;	
							}
							$counter_recoreds++;
							$quiz_post_status = get_post_status( $quiz_id );
							$quiz_permalink = '';
							$ratake_var = '';
							if( $quiz_post_status == 'publish' && $attempt_no<$no_of_retakes_allowed){
								$ratake_var = 'Retake';
								$quiz_permalink = get_permalink($quiz_id).'?course_id='.$course_id;
							} else {
								$quiz_permalink = '#';
							}
							
							?>
                                <tr>
                                  <td class="first-td"><?php if(isset($user_quiz_info['title']))echo __('Quiz:', 'EDULMS').esc_attr($user_quiz_info['title']);?></td>
                                  <td>
                                    <a href="<?php echo esc_url($quiz_permalink);?>" class="retake" target="_blank"><small><?php echo esc_attr($attempt_no.'/'.$no_of_retakes_allowed); ?></small><?php echo esc_attr($ratake_var);?></a>
                                  </td>
                                  <td><?php echo esc_attr($quiz_passing_marks);?>%</td>
                                  
                                  <td><?php echo esc_attr($result_percentage);?>%</td>
                                  <td><?php if(isset($review_status)) echo esc_attr($review_status);?></td>
                                </tr>
							<?php
								}
							}
								if(isset($user_quiz_array['course_information']))
									$user_course_info = $user_quiz_array['course_information'];
								$course_pass_marks = 0;
								if(isset($user_course_info['course_pass_marks']))
									$course_pass_marks = $user_course_info['course_pass_marks'];
						}
						
						}
						
					// Course Attempted Assignments Listing
					if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array)){	
						if (array_key_exists((string)$transaction_id, $user_assingments_array)) {
							if($transaction_id){
								$assingment_ids_info = array();
								if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
									$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
									$assingment_ids_info = array_unique($assingment_ids_info_array);
								}
							}
							$counter_assign = 0;
							foreach($assingment_ids_info as $assignment_id){	
								if(isset($user_assingments_array[$transaction_id][$assignment_id]) && is_array($user_assingments_array[$transaction_id][$assignment_id]) && count($user_assingments_array[$transaction_id][$assignment_id])>2){
										$assignment_array = $user_assingments_array[$transaction_id][$assignment_id];
										$assignment_marks = 0;
										$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
										$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
										$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
										$assignment_complete = get_option($assignment_complete_key);
										if(!isset($assignment_complete)){
											$assignment_complete = 1;
										} else if(isset($assignment_complete) && $assignment_complete == ''){
											$assignment_complete = 1;
										}
										$attempt_no = $assignment_complete-1;
										if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
										   $user_assignment_info = array(); 
											if(isset($assignment_array['course_assignment_info']))
												$user_assignment_info = $assignment_array['course_assignment_info'];
												
											$assignments_course_id = $user_assignment_info['course_id'];
											
											if($course_id <> $assignments_course_id)
												continue;
											$assignments_title = $user_assignment_info['assignments_title'];
											$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
											if(isset($user_assignment_info['assignment_total_marks']) && !empty($user_assignment_info['assignment_total_marks']))
												$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
											else 
												$assignment_total_marks = 100;
												
											$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
											
											$user_assignment_data = array(); 
											if(isset($assignment_array[$attempt_no]['assignment_data']))
												$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
										$attempt_date = $user_assignment_data['attempt_date'];
										$review_status = $user_assignment_data['review_status'];
										
										$user_email = $user_assignment_data['user_email'];
										if(isset($user_assignment_data['assignment_marks']) && $user_assignment_data['assignment_marks'] <> ''){
											$assignment_marks = $user_assignment_data['assignment_marks'];
										} else {
											$assignment_marks = 0;
										}
										$assignment_remarks = $user_assignment_data['assignment_remarks'];
										$ip_address = $user_assignment_data['ip_address'];
										$question_marks_points = $assignment_total_marks;
										$result_percentage = 0;
										$remaining_attempts = $assignment_retakes_no-$assignment_attempt_no;
										if($assignment_marks > 0 && $question_marks_points>0)
											$result_percentage = ($assignment_marks/$question_marks_points)*100;
										if($assignment_marks == '' )
											$assignment_marks = '-';
										$course_post_status = get_post_status( $course_id );
										$course_permalink = '#';
										$counter_recoreds++;
										$average_total_marks  =$average_total_marks+$assignment_total_marks;
										if($review_status == 'Published' || $review_status == 'Pass'){
											$average_percentage = $average_percentage+$result_percentage;
											$avarage_passing_marks = $avarage_passing_marks+$assignment_passing_marks;
											$average_getting_marks  =$average_getting_marks+$assignment_marks;
										} else if(isset($review_status) && ($review_status == 'Fail')){
											$Fail_result = 1;
										} else {
											$pending_result = 1;	
										}
										$ratake_var = '';
										if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){
												$ratake_var = 'Retake';
											  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';
										} else {
											$course_permalink = '#';
										}
											?>
											   <tr>
												  <td class="first-td"><?php if(isset($user_assignment_info['assignments_title'])) echo __('Assignment:', 'EDULMS').' '.$user_assignment_info['assignments_title'];?></td>
												  <td>
													<a href="<?php echo esc_url($course_permalink);?>" class="retake" target="_blank"><small><?php echo esc_attr($attempt_no.'/'.$assignment_retakes_no); ?></small><?php echo esc_attr($ratake_var);?></a>
												  </td>
												  <td><?php if(isset($assignment_passing_marks)) echo esc_attr($assignment_passing_marks);?>%</td>
												  <td><?php if(isset($result_percentage)) echo esc_attr($result_percentage);?>%</td>
												  <td><?php if(isset($review_status)) echo esc_attr($review_status);?></td>
											  </tr>
											<?php
										}
								}
							}
						}
					}
						
						
					// Course Remaining Quiz and Listings
					$course_post_statuss = get_post_status( $course_id );
					if($course_id && $course_post_statuss == 'publish'){
							$post_xml = get_post_meta($course_id, "cs_course", true);
							$cs_xmlObject = new SimpleXMLElement($post_xml);
						}
						if(isset($cs_xmlObject->course_curriculms) && count($cs_xmlObject->course_curriculms )>0){
							foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
								$listing_type = $curriculm->listing_type;
								if($listing_type == 'quiz'){
									$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
									if ((!isset($quiz_answer_array) || !is_array($quiz_answer_array) || empty($quiz_answer_array)) || (is_array($quiz_answer_array) && !isset($quiz_answer_array[(string)$transaction_id]) ) || (is_array($quiz_answer_array) && isset($quiz_answer_array[(string)$transaction_id]) && is_array($quiz_answer_array[(string)$transaction_id]) && !array_key_exists((int)$var_cp_course_quiz_list, $quiz_answer_array[(string)$transaction_id]))) {
										$quiz_passing_marks = $curriculm->quiz_passing_marks;
										$quiz_retakes_no = $curriculm->quiz_retakes_no;
										
										$quiz_post_status = get_post_status( $quiz_id );
										$quiz_permalink = '#';
										$attempt_no = 0;
										$pending_result = 1;
										
										if( $quiz_post_status == 'publish' && $attempt_no<$quiz_retakes_no){  $quiz_permalink = get_permalink((int)$var_cp_course_quiz_list).'?course_id='.$course_id;} else {$quiz_permalink = '#';}
										?>
										<tr>
										  <td class="first-td"><?php echo __('Quiz:', 'EDULMS').' '.get_the_title((int)$var_cp_course_quiz_list);?></td>
										  <td><a href="<?php echo esc_url($quiz_permalink);?>" class="retake" target="_blank"><small><?php echo absint($attempt_no).'/'.absint($quiz_retakes_no); ?></small><?php _e('Attempts', 'EDULMS');?></a></td>
										  <td><?php echo esc_attr($quiz_passing_marks);?>%</td>
										  <td></td>
										  <td><?php _e('Remaining', 'EDULMS');?></td>
										</tr>
										<?php
									}
									
								} else if($listing_type == 'assigment'){
									$assignment_id = $curriculm->assignment_id;
									$assignment_id = (int)$curriculm->var_cp_assignment_title;
									if($assignment_id){
									if ((!isset($user_assingments_array) || !is_array($user_assingments_array) || empty($user_assingments_array)) || (is_array($user_assingments_array) && !isset($user_assingments_array[(string)$transaction_id]) ) || (is_array($user_assingments_array) && isset($user_assingments_array[(string)$transaction_id]) && is_array($user_assingments_array[(string)$transaction_id]) && !array_key_exists((int)$assignment_id, $user_assingments_array[(string)$transaction_id]))) {
										$assignment_passing_marks = $curriculm->assignment_passing_marks;
										$assignment_total_marks = $curriculm->assignment_total_marks;
										$assignment_retakes_no = $curriculm->assignment_retakes_no;
										$var_cp_assignment_title = $curriculm->var_cp_assignment_title;
										$average_total_marks = $average_total_marks+$assignment_total_marks;
										$attempt_no = 0;
										$course_permalink = '#';
										$pending_result = 1;
										$course_post_status = get_post_status( $course_id );
										if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';} else {$course_permalink = '#';}
										?>
											<tr>
											  <td class="first-td"><?php echo __('Assignment','EDULMS').': '.get_the_title($assignment_id);?></td>
											  <td><a href="<?php echo esc_url($course_permalink);?>" class="retake" target="_blank"><small><?php echo absint($attempt_no).'/'.absint($assignment_retakes_no); ?></small><?php _e('Attempts', 'EDULMS');?></a></td>
											  <td><?php echo esc_attr($assignment_passing_marks);?>%</td>
											  <td></td>
											   <td><?php _e('Remaining', 'EDULMS');?></td>
											</tr>
										<?php
									}
									}
								}
							}
						}	
							if(isset($pending_result) && $pending_result <> 1){
									$total_percentage = 0;
									if($average_percentage>0 && $counter_recoreds>0)
										$total_percentage = $average_percentage/$counter_recoreds;
								if($counter_recoreds>0 )       
									$avarage_passing_marks  = $avarage_passing_marks/$counter_recoreds;
								if(isset($avarage_passing_marks))	
									$avarage_passing_marks = round($avarage_passing_marks, 2);
									
									
								$average_percentage = 0;
								if($average_getting_marks>0 && $average_total_marks > 0){
									$average_percentage = ($average_getting_marks / $average_total_marks) * 100;
									$average_percentage = round($average_percentage, 2);
								}	
							} else {
								$average_getting_marks = '-';
								$average_total_marks = '-';
								$total_percentage = '';
								$average_percentage = '';
							}
						?>
						 <tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Required Passing %', 'EDULMS');?></td>
						  <td class="bg-gray" colspan="2"><?php if(isset($course_pass_marks) && !empty($course_pass_marks)){echo esc_attr($course_pass_marks); } else { echo esc_attr($avarage_passing_marks);}?>%</td>
						</tr>
						<tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Obtained Marks %', 'EDULMS');?></td>
						  <td class="bg-gray" colspan="2"><?php if(isset($average_percentage) && $average_percentage <> '') echo esc_attr($average_percentage).'%'; else echo '-';?></td>
						</tr>
						<tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Status', 'EDULMS');?></td>
						  <td class="bg-gray" colspan="2">
								<?php 
								 if(isset($pending_result) && $pending_result <> 1){
								   if($Fail_result <> 1){
										if(isset($course_pass_marks) && !empty($course_pass_marks)){
											$requied_marks = $course_pass_marks; 
										} else {
											 $requied_marks = $avarage_passing_marks;
										}
										if(isset($average_percentage) && $average_percentage <> ''){
											$average_percentage = $average_percentage;
											if($average_percentage>$requied_marks){
												echo 'Pass';
												$randiclass = rand(55,6666);
												$complete_dynmc_cls = $transaction_id.'-'.$course_id.'-'.$user_id.'-'.$randiclass;
												$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
												global $cs_course_options;
												if(is_array($user_course_complete_backup_array) && isset($user_course_complete_backup_array[$course_id]) && is_array($user_course_complete_backup_array[$course_id]) && array_key_exists((int)$course_id, $user_course_complete_backup_array) && count($user_course_complete_backup_array[$course_id])>2){
													$cs_course_options = $cs_course_options;
													$cs_page_id = $cs_course_options['cs_dashboard'];
													
													?>
													<a class="<?php echo esc_attr($complete_dynmc_cls);?>" onclick="cs_user_course_complete__backup('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($course_id);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($complete_dynmc_cls);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>')" title="Click here to complete the Course"><?php _e('Complete', 'EDULMS');?></a>
													<a title="" data-placement="top" data-toggle="tooltip" class="fa fa-download btn-default <?php echo esc_attr($complete_dynmc_cls);?>-crtfct-download" href="<?php echo cs_user_profile_link($cs_page_id, 'certificates', $user_id); ?>" data-original-title="Download Certificate" ></a>
													<?php
												} else {
													?>	
													<a class="<?php echo esc_attr($complete_dynmc_cls);?>" onclick="cs_user_course_complete__backup('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($course_id);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($complete_dynmc_cls);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>')" title="Click here to complete the Course"><?php _e('Complete', 'EDULMS');?></a>
													<?php
												}
											}
										}
								   } else {
									   _e('Fail', 'EDULMS');
								   }
								 } else {
									 _e('Pending', 'EDULMS');
								 }
								 ?>
						  </td>
						</tr>
			  </tbody>
			</table>
			<?php
			 }  else {
				 _e('There are no records available', 'EDULMS');
			 }
			exit;	
	}
	add_action('wp_ajax_cs_courses_quiz_assignment_records_ajax', 'cs_courses_quiz_assignment_records_ajax');
}

/**
 * Course Complete backup on completion
 */
if ( ! function_exists( 'cs_user_course_complete_backup_ajax' ) ) { 
	function cs_user_course_complete_backup_ajax(){
		$transaction_id = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		
		if(!empty($user_id) && !empty($course_id) && !empty($transaction_id)){		
			$pending_result = 0;
			$user_course_complete_backup_array = array();
			//update_user_meta($user_id,'cs-user-courses-backup', '');
			$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
			
					$random_integer = cs_generate_random_integers();
					if(!isset($user_course_complete_backup_array) || !is_array($user_course_complete_backup_array)){
						$user_course_complete_backup_array = array();
					}
					$user_course_complete_backup_array[(int)$course_id] = array();
					$course_quiz_array = array();
					$course_assignment_array = array();
					$course_certificate_array = array();
					$course_post_status = get_post_status( $course_id );
					if($course_post_status == 'publish'){
						$post_xml = get_post_meta($course_id, "cs_course", true);
						$cs_xmlObject = new SimpleXMLElement($post_xml);
	
						//==update badge
						if ( $post_xml <> "" ) {
							$cs_course_badge_assign = (string)$cs_xmlObject->cs_course_badge_assign;
							if ( isset ( $cs_course_badge_assign ) && $cs_course_badge_assign !=''  && $cs_course_badge_assign == 'completion'  ) {
								$cs_course_badge = (string)$cs_xmlObject->cs_course_badge;
								if ( isset ( $cs_course_badge ) && $cs_course_badge !='' ) {
									$badges_user_meta_array = array();
									$badges_user_meta_array = get_user_meta($user_id, "user_badges", true);
									if(is_int($badges_user_meta_array))
										$badges_user_meta_array = array();
									if(!is_array($badges_user_meta_array))
										$badges_user_meta_array = array();
									if ( !in_array( $cs_course_badge , $badges_user_meta_array ) ) {
										$badges_user_meta_array[] = $cs_course_badge;
										update_user_meta($user_id, 'user_badges', $badges_user_meta_array );
									}
								}
							}
						}
						//==update badge
						//==update Certificate
						if ( $post_xml <> "" ) {
							$cs_course_certificate_assign = (string)$cs_xmlObject->cs_course_certificate_assign;
							if ( isset ( $cs_course_certificate_assign ) && $cs_course_certificate_assign !='' && $cs_course_certificate_assign == 'completion' ) {
								$cs_course_certificate = (string)$cs_xmlObject->cs_course_certificate;
								if ( isset ( $cs_course_certificate ) && $cs_course_certificate !='') {
									$certificates_user_meta_array = array();
									$certificates_user_meta_array = get_user_meta($user_id, "user_certificates", true);
									$user_information = get_userdata((int)$user_id);
									$expiry_date = '';
									$courseData = get_post_meta($course_id, "cs_user_course_data", true);
									if ( isset ( $courseData ) && $courseData !='' ) {
										foreach( $courseData as $data) {
											if ( $data['user_id'] == $user_id ) {
												$expiry_date = $data['expiry_date'];
												break;
											}
										}
									}
									$cs_certificate_code = '';
									$code 				 = cs_generate_random_string('10');
									$cs_certificate_code = 'LMS-'.$code.'';
									$takenMarks	= cs_courses_taken_marks($course_id,$user_id,$transaction_id);
									$certificates_user_meta_array[$transaction_id] = array();
									$certificates_user_meta_array[$transaction_id]['cs_course_id'] 			= $course_id;
									$certificates_user_meta_array[$transaction_id]['cs_user_certificate'] 	= $cs_course_certificate;
									$certificates_user_meta_array[$transaction_id]['cs_username'] 		  	= $user_information->display_name;
									$certificates_user_meta_array[$transaction_id]['cs_certificate_name'] 	= get_the_title($cs_course_certificate);
									$certificates_user_meta_array[$transaction_id]['cs_course_name'] 		= get_the_title($course_id);
									$certificates_user_meta_array[$transaction_id]['cs_taken_marks'] 		= $takenMarks;
									$certificates_user_meta_array[$transaction_id]['cs_completion_date'] 	= $expiry_date;
									$certificates_user_meta_array[$transaction_id]['cs_certificate_code'] 	= $cs_certificate_code;
									update_user_meta($user_id, 'user_certificates', $certificates_user_meta_array );
								}
							}
						}
						//==update Certificate
			
						if(count($cs_xmlObject->course_curriculms )>0){
							foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
								$listing_type = $curriculm->listing_type;
								if($listing_type == 'quiz'){
									$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
									if(!empty($var_cp_course_quiz_list)){
										$quiz_passing_marks = $curriculm->quiz_passing_marks;
										$quiz_retakes_no = $curriculm->quiz_retakes_no;
										$quiz_data = array();
										$quiz_data['title'] = get_the_title((int)$var_cp_course_quiz_list);
										$quiz_data['quiz_retakes_no'] = (string)$quiz_retakes_no;
										$quiz_data['quiz_passing_marks'] = (string)$quiz_passing_marks;
										$course_quiz_array[(int)$var_cp_course_quiz_list] = $quiz_data;
									}
								} else if($listing_type == 'assigment'){
									$assignment_id = $curriculm->assignment_id;
									if(!empty($assignment_id)){
										$var_cp_assignment_title = $curriculm->var_cp_assignment_title;
										$assignment_passing_marks = $curriculm->assignment_passing_marks;
										$assignment_total_marks = $curriculm->assignment_total_marks;
										$assignment_retakes_no = $curriculm->assignment_retakes_no;
										$assignment_data = array();
										$assignment_data['assignment_title'] = (string)$var_cp_assignment_title;
										$assignment_data['assignment_passing_marks'] = (string)$assignment_passing_marks;
										$assignment_data['assignment_total_marks'] = (string)$assignment_total_marks;
										$assignment_data['assignment_retakes_no'] = (string)$assignment_retakes_no;
										$course_assignment_array[(int)$assignment_id] = $assignment_data;
									}
								}
							}
						}		
					}
					$pending_result = 0;
					$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
					$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
					if (array_key_exists((string)$transaction_id, $quiz_answer_array)) {
						foreach($quiz_answer_array[$transaction_id] as $quiz_id=>$quiz_answers){	
							if(!in_array($quiz_id, $course_quiz_array)){
								$pending_result = 1;
								break;
							}
						}
					}
					
					if($pending_result == 0){
						if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array)){	
							if (array_key_exists((string)$transaction_id, $user_assingments_array)) {
								if($transaction_id){
									$assingment_ids_info = array();
									if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
										$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
										$assingment_ids_info = array_unique($assingment_ids_info_array);
										foreach($course_assignment_array as $assignment_id=>$assignment_value){
											if(!in_array($assignment_id, $assingment_ids_info)){
												$pending_result = 1;
												break;
											}	
										}
										
									}
								}
							}
						}
						
					}
					
					$course_certificate_array['certificate_no'] = $random_integer;
					$course_certificate_array['certificate_download'] = 0;
					$course_certificate_array['certificate_allowed'] = $pending_result;
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['quiz'] = $course_quiz_array;
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['assignment'] = $course_assignment_array;
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['certificate'] = $course_certificate_array;
					update_user_meta($user_id,'cs-user-courses-backup', $user_course_complete_backup_array);
					$course_key = '';
					$user_course_data = get_option($course_id."_cs_user_course_data", true);
					if(is_array($user_course_data) && count($user_course_data)>0){
						$course_key = '';
						foreach ( $user_course_data as $key=>$members ){
							if($transaction_id == $members['transaction_id']){
								$course_key = (int)$key;
								break;
							}
						}
						if(!empty($course_key) || $course_key == 0){
							$user_course_data[$course_key]['disable'] = 3;
						}
						update_option($course_id."_cs_user_course_data", $user_course_data);
					}
		}
		exit;
	}
	add_action('wp_ajax_cs_user_course_complete_backup_ajax', 'cs_user_course_complete_backup_ajax');
}

/**
 * Quiz Assignments Results Status
 */
if ( ! function_exists( 'cs_courses_quiz_status' ) ) { 
	function cs_courses_quiz_status($course_id,$user_id,$transaction_id){
		if(isset($transaction_id))  $transaction_id = $transaction_id;
		if(isset($user_id))  $user_id = $user_id;
		if(isset($course_id))  $course_id = $course_id;
		$user_course_complete_backup_array = array();
		$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
		if(is_array($user_course_complete_backup_array) && isset($user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]) && is_array($user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]) && array_key_exists((string)$transaction_id, $user_course_complete_backup_array[$course_id]) && count($user_course_complete_backup_array[$course_id])>0){
		$quiz_ids = $user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['quiz'];
		$assingments_ids = $user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['assignment'];
		$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		$pending_result = 0;
		if((isset($quiz_answer_array) && count($quiz_answer_array)>0 && is_array($quiz_ids) && count($quiz_ids)>0) || (isset($assingments_ids) && count($assingments_ids)>0 && is_array($assingments_ids) && count($assingments_ids)>0)){
						$average_percentage = 0;
						$counter_recoreds = 0;
						$average_getting_marks = 0;
						$avarage_passing_marks = 0;
						$average_total_marks = 0;
						$Fail_result = 0;
						// Course Attempted Quiz Listing
						if(isset($quiz_answer_array) && count($quiz_answer_array)>0 && is_array($quiz_ids) && count($quiz_ids)>0){
							foreach($quiz_ids as $quiz_id=>$quiz_value){
								if($quiz_id){
									if(isset($quiz_answer_array[(string)$transaction_id][(int)$quiz_id]) && is_array($quiz_answer_array[(string)$transaction_id][(int)$quiz_id])){
										$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
										$quiz_complete = get_option($quiz_complete_key);
										if(!isset($quiz_complete)){
											$quiz_complete = 1;
										} else if(isset($quiz_complete) && $quiz_complete == ''){
											$quiz_complete = 1;
										}
										$attempt_no = $quiz_complete-1;
										if(isset($quiz_answers['quiz_attempt']['quiz_attempt_no'])){
											$attempt_no = $user_quiz_attempts = $quiz_answers['quiz_attempt']['quiz_attempt_no'];
										}
										$no_of_retakes_allowed = '1';
										if(isset($quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed']))
											$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
										
										if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
											$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
											
											$user_quiz_info = array();
											$user_quiz_questions = array();
											$user_quiz_result_info = array();
											if(isset($user_quiz_array['quiz_information']))
												$user_quiz_info = $user_quiz_array['quiz_information'];
											if(isset($user_quiz_array['quiz_result']))
												$user_quiz_result_info = $user_quiz_array['quiz_result'];
											if(isset($user_quiz_array['questions']))
												$user_quiz_questions = $user_quiz_array['questions'];
											$attempt_questions = 0;
											$total_questions = count($user_quiz_questions);
											foreach($user_quiz_questions as $questions_key=>$questions_values){
												if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
													$attempt_questions++;
											}
											$user_points = 0;
											$question_marks_points = 0;
											$result_percentage = 0;
											$resutl_remarks = '';
											if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
												$resutl_remarks = $user_quiz_result_info['remarks'];
											if(isset($user_quiz_result_info['review_status']) && !empty($user_quiz_result_info['review_status']))
												$review_status = $user_quiz_result_info['review_status'];
												if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
													$user_points = $user_quiz_result_info['marks'];
												if(empty($user_points))
													$user_points = 0;
												if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
													$question_marks_points = $user_quiz_result_info['total_marks'];
												$average_total_marks  =$average_total_marks+$question_marks_points;
												if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
													$result_percentage = $user_quiz_result_info['marks_percentage'];
											$attempt_date = '';
											if(isset($user_quiz_result_info['attempt_date']))
												$attempt_date = $user_quiz_result_info['attempt_date'];
											$quiz_passing_marks = '';
											if(isset($user_quiz_info['quiz_passing_marks'])){
												$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
											}
											if(isset($review_status) && ($review_status == 'Fail')){
												$Fail_result = 1;
											} else if(isset($review_status) && ($review_status == 'Pass')){
												 $avarage_passing_marks = $avarage_passing_marks+$quiz_passing_marks;
												 $average_percentage = $average_percentage+$result_percentage;
												 $average_getting_marks  =$average_getting_marks+$user_points;
											}
											if(isset($review_status) && ($review_status == 'Pending' ||  $review_status == 'Remaining')){	
												$pending_result = 1;	
											}
											$counter_recoreds++;
											$quiz_post_status = get_post_status( $quiz_id );
											$quiz_permalink = '';
											$ratake_var = '';
											if( $quiz_post_status == 'publish' && $attempt_no<$no_of_retakes_allowed){
												$ratake_var = 'Retake';
												$quiz_permalink = get_permalink($quiz_id).'?course_id='.$course_id;
											} else {
												$quiz_permalink = '#';
											}
											$quiz_title = '';
											if(isset($user_quiz_info['title'])){$quiz_title = 'Quiz: '.$user_quiz_info['title'];}
										}
									} else {
										$quiz_title = 'Quiz: '.$quiz_value['title'];
										$quiz_permalink = '#';
										$ratake_var = '';
										$attempt_no = 0;
										$no_of_retakes_allowed = $quiz_value['quiz_retakes_no'];
										$quiz_passing_marks = $quiz_value['quiz_passing_marks'];
										$review_status = 'Remaining';
										$result_percentage = 0;
										$pending_result = 1;
									}
									
									}
								}
								
								if(isset($user_quiz_array['course_information']))
									$user_course_info = $user_quiz_array['course_information'];
								$course_pass_marks = 0;
								if(isset($user_course_info['course_pass_marks']))
									$course_pass_marks = $user_course_info['course_pass_marks'];
						}
						// Course Attempted Assignments Listing
							$counter_assign = 0;
							foreach($assingments_ids as $assignment_id=>$assingments_values){	
							
								$assignment_id = $assingments_values['assignment_title'];
								if(!empty($assignment_id)){
										if(isset($user_assingments_array[$transaction_id][$assignment_id]) && is_array($user_assingments_array[$transaction_id][$assignment_id]) && count($user_assingments_array[$transaction_id][$assignment_id])>2){
												$assignment_array = $user_assingments_array[$transaction_id][$assignment_id];
												$assignment_marks = 0;
												$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
												$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
												$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
												$assignment_complete = get_option($assignment_complete_key);
												if(!isset($assignment_complete)){
													$assignment_complete = 1;
												} else if(isset($assignment_complete) && $assignment_complete == ''){
													$assignment_complete = 1;
												}
												$attempt_no = $assignment_complete-1;
												if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
												   $user_assignment_info = array(); 
													if(isset($assignment_array['course_assignment_info']))
														$user_assignment_info = $assignment_array['course_assignment_info'];
														
													$assignments_course_id = $user_assignment_info['course_id'];
													
													if($course_id <> $assignments_course_id)
														continue;
													$assignments_title = $user_assignment_info['assignments_title'];
													$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
													if(isset($user_assignment_info['assignment_total_marks']) && !empty($user_assignment_info['assignment_total_marks']))
														$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
													else 
														$assignment_total_marks = 100;
														
													$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
													
													$user_assignment_data = array(); 
													if(isset($assignment_array[$attempt_no]['assignment_data']))
														$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
												$attempt_date = $user_assignment_data['attempt_date'];
												$review_status = $user_assignment_data['review_status'];
												
												$user_email = $user_assignment_data['user_email'];
												if(isset($user_assignment_data['assignment_marks']) && $user_assignment_data['assignment_marks'] <> ''){
													$assignment_marks = $user_assignment_data['assignment_marks'];
												} else {
													$assignment_marks = 0;
												}
												$assignment_remarks = $user_assignment_data['assignment_remarks'];
												$ip_address = $user_assignment_data['ip_address'];
												$question_marks_points = $assignment_total_marks;
												$result_percentage = 0;
												$remaining_attempts = $assignment_retakes_no-$assignment_attempt_no;
												if($assignment_marks > 0 && $question_marks_points>0)
													$result_percentage = ($assignment_marks/$question_marks_points)*100;
												if($assignment_marks == '' )
													$assignment_marks = '-';
												$course_post_status = get_post_status( $course_id );
												$course_permalink = '#';
												$counter_recoreds++;
												$average_total_marks  =$average_total_marks+$assignment_total_marks;
												if($review_status == 'Published' || $review_status == 'Pass'){
													$average_percentage = $average_percentage+$result_percentage;
													$avarage_passing_marks = $avarage_passing_marks+$assignment_passing_marks;
													$average_getting_marks  =$average_getting_marks+$assignment_marks;
												} else if(isset($review_status) && ($review_status == 'Fail')){
													$Fail_result = 1;
												} else {
													$pending_result = 1;	
												}
												$ratake_var = '';
												if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){
														$ratake_var = 'Retake';
													  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';
												} else {
													$course_permalink = '#';
												}
												$assignments_title = '';
												if(isset($user_assignment_info['assignments_title'])) $assignments_title = 'Assignment: '.$user_assignment_info['assignments_title'];
											}
										} else {
											$assignments_title = 'Assignment: '.$assingments_values['assignment_title'];
											$quiz_permalink = '#';
											$attempt_no = 0;
											$assignment_retakes_no = $assingments_values['assignment_retakes_no'];
											$assignment_passing_marks = $assingments_values['assignment_passing_marks'];
											$review_status = 'Remaining';
											$result_percentage = 0;
											$pending_result = 1;
										}
										}
								}
						
						
							if(isset($pending_result) && $pending_result <> 1){
									$total_percentage = 0;
									if($average_percentage>0 && $counter_recoreds>0)
										$total_percentage = $average_percentage/$counter_recoreds;
								if($counter_recoreds>0 )       
									$avarage_passing_marks  = $avarage_passing_marks/$counter_recoreds;
								if(isset($avarage_passing_marks))	
									$avarage_passing_marks = round($avarage_passing_marks, 2);
									
									
								$average_percentage = 0;
								if($average_getting_marks>0 && $average_total_marks > 0){
									$average_percentage = ($average_getting_marks / $average_total_marks) * 100;
									$average_percentage = round($average_percentage, 2);
								}	
									
									
									
							} else {
								$average_getting_marks = '-';
								$average_total_marks = '-';
								$total_percentage = '';
								$average_percentage = '';
							}
						
								if(isset($pending_result) && $pending_result <> 1){
								   if($Fail_result <> 1){
										if(isset($course_pass_marks) && !empty($course_pass_marks)){
											$requied_marks = $course_pass_marks; 
										} else {
											 $requied_marks = $avarage_passing_marks;
										}
										if(isset($average_percentage) && $average_percentage <> ''){
											$average_percentage = $average_percentage;
											if($average_percentage>$requied_marks){
												return 'Pass';
											} else {
												return 'Fail';
											}
										}
								   } else {
									 return 'Fail';
								   }
								 } else {
									return 'Fail';
								 }
								 
			}  else {
				return 'Fail';
			} 
		
		}  else {
				 return 'Fail';
		}
	}
	
}

/**
 * Quiz Assignments Results Auto backup
 */
if ( ! function_exists( 'cs_user_course_complete_auto_backup_after_expiration' ) ) { 
	function cs_user_course_complete_auto_backup_after_expiration($transaction_id = '',$course_id = '',  $user_id = ''){
		if(!empty($user_id) && !empty($course_id) && !empty($transaction_id)){
			$pending_result = 0;
			$user_course_complete_backup_array = array();
			$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
			
			if(!is_array($user_course_complete_backup_array) || !isset($user_course_complete_backup_array[$course_id]) || !is_array($user_course_complete_backup_array[$course_id]) || !array_key_exists((int)$course_id, $user_course_complete_backup_array) || count($user_course_complete_backup_array[$course_id])<2){
					$random_integer = cs_generate_random_integers();
					if(!isset($user_course_complete_backup_array) || !is_array($user_course_complete_backup_array)){
						$user_course_complete_backup_array = array();
					}
					$user_course_complete_backup_array[(int)$course_id] = array();
					$course_quiz_array = array();
					$course_assignment_array = array();
					$course_certificate_array = array();
					$course_post_status = get_post_status( $course_id );
					if($course_post_status == 'publish'){
							$post_xml = get_post_meta($course_id, "cs_course", true);
							$cs_xmlObject = new SimpleXMLElement($post_xml);
							
							//==update badge
							if ( $post_xml <> "" ) {
								$cs_course_badge_assign = (string)$cs_xmlObject->cs_course_badge_assign;
								if ( isset ( $cs_course_badge_assign ) && $cs_course_badge_assign !='' && ( $cs_course_badge_assign == 'expire' || $cs_course_badge_assign == 'completion' ) ) {
									$cs_course_badge = (string)$cs_xmlObject->cs_course_badge;
									if ( isset ( $cs_course_badge ) && $cs_course_badge !='') {
										$badges_user_meta_array = array();
										$badges_user_meta_array = get_user_meta($user_id, "user_badges", true);
										if ( !in_array( $cs_course_badge , $badges_user_meta_array ) ) {
											$badges_user_meta_array[] = $cs_course_badge;
											update_user_meta($user_id, 'user_badges', $badges_user_meta_array );
										}
									}
								} 
							}
							//==update badge
							
							//==update Certificate
							if ( $post_xml <> "" ) {
								$cs_course_certificate_assign = (string)$cs_xmlObject->cs_course_certificate_assign;
								if ( isset ( $cs_course_certificate_assign ) && $cs_course_certificate_assign !=''  && ( $cs_course_certificate_assign == 'expire' || $cs_course_certificate_assign == 'completion' )  ) {
									$cs_course_certificate = (string)$cs_xmlObject->cs_course_certificate;
									if ( isset ( $cs_course_certificate ) && $cs_course_certificate !='') {
										$certificates_user_meta_array = array();
										$certificates_user_meta_array = get_user_meta($user_id, "user_certificates", true);
										$user_information = get_userdata((int)$user_id);
										
										$expiry_date = '';
										$courseData = get_post_meta($course_id, "cs_user_course_data", true);
										if ( isset ( $courseData ) && $courseData !='' ) {
											foreach( $courseData as $data) {
												if ( $data['user_id'] == $user_id ) {
													$expiry_date = $data['expiry_date'];
													break;
												}
											}
										}
										
										$cs_certificate_code = '';
										$code 				 = cs_generate_random_string('10');
										$cs_certificate_code = 'LMS-'.$code.'';
										
										$takenMarks	= cs_courses_taken_marks($course_id,$user_id,$transaction_id);
										
										if ( isset ( $expiry_date ) && !empty( $expiry_date ) ) {
											
											$certificates_user_meta_array[$transaction_id] = array();
											$certificates_user_meta_array[$transaction_id]['cs_course_id'] 			= $course_id;
											$certificates_user_meta_array[$transaction_id]['cs_user_certificate'] 	= $cs_course_certificate;
											$certificates_user_meta_array[$transaction_id]['cs_username'] 		  	= $user_information->display_name;
											$certificates_user_meta_array[$transaction_id]['cs_certificate_name'] 	= get_the_title($cs_course_certificate);
											$certificates_user_meta_array[$transaction_id]['cs_course_name'] 		= get_the_title($course_id);
											$certificates_user_meta_array[$transaction_id]['cs_taken_marks'] 		= $takenMarks;
											$certificates_user_meta_array[$transaction_id]['cs_completion_date'] 	= $expiry_date;
											$certificates_user_meta_array[$transaction_id]['cs_certificate_code'] 	= $cs_certificate_code;
											update_user_meta($user_id, 'user_certificates', $certificates_user_meta_array );
										}
										
									}
								}
							}
							
							//==update Certificate
					
							if(count($cs_xmlObject->course_curriculms )>0){
								foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
									$listing_type = $curriculm->listing_type;
									if($listing_type == 'quiz'){
										$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
										if(!empty($var_cp_course_quiz_list)){
											$quiz_passing_marks = $curriculm->quiz_passing_marks;
											$quiz_retakes_no = $curriculm->quiz_retakes_no;
											$quiz_data = array();
											$quiz_data['title'] = get_the_title((int)$var_cp_course_quiz_list);
											$quiz_data['quiz_retakes_no'] = (string)$quiz_retakes_no;
											$quiz_data['quiz_passing_marks'] = (string)$quiz_passing_marks;
											$course_quiz_array[(int)$var_cp_course_quiz_list] = $quiz_data;
										}
									} else if($listing_type == 'assigment'){
										$assignment_id = $curriculm->assignment_id;
										if(!empty($assignment_id)){
											$var_cp_assignment_title = $curriculm->var_cp_assignment_title;
											$assignment_passing_marks = $curriculm->assignment_passing_marks;
											$assignment_total_marks = $curriculm->assignment_total_marks;
											$assignment_retakes_no = $curriculm->assignment_retakes_no;
											$assignment_data = array();
											$assignment_data['assignment_title'] = (string)$var_cp_assignment_title;
											$assignment_data['assignment_passing_marks'] = (string)$assignment_passing_marks;
											$assignment_data['assignment_total_marks'] = (string)$assignment_total_marks;
											$assignment_data['assignment_retakes_no'] = (string)$assignment_retakes_no;
											$course_assignment_array[(int)$assignment_id] = $assignment_data;
										}
									}
								}
						}		
					}
					$pending_result = 0;
					$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
					$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
					if (is_array($quiz_answer_array) and array_key_exists((string)$transaction_id, $quiz_answer_array)) {
						foreach($quiz_answer_array[$transaction_id] as $quiz_id=>$quiz_answers){	
							if(!in_array($quiz_id, $course_quiz_array)){
								$pending_result = 1;
								break;
							}
						}
					}
					if($pending_result == 0){
						if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array)){	
							if (array_key_exists((string)$transaction_id, $user_assingments_array)) {
								if($transaction_id){
									$assingment_ids_info = array();
									if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
										$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
										$assingment_ids_info = array_unique($assingment_ids_info_array);
										foreach($course_assignment_array as $assignment_id=>$assignment_value){
											if(!in_array($assignment_id, $assingment_ids_info)){
												$pending_result = 1;
												break;
											}	
										}
										
									}
								}
							}
						}
						
					}
					
					if(!isset($takenMarks))
						$takenMarks	 = 0;
					
					$course_certificate_array['certificate_no'] = $random_integer;
					$course_certificate_array['certificate_download'] = 0;
					$course_certificate_array['certificate_allowed'] = $pending_result;
					$course_certificate_array['certificate_marks'] = $takenMarks;
					//$certificates_user_meta_array
					if(isset($certificates_user_meta_array) && is_array($certificates_user_meta_array) && count($certificates_user_meta_array)>0){
						$certificates_user_meta = $certificates_user_meta_array;
					} else {
						$certificates_user_meta = array();
					}
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['quiz'] = $course_quiz_array;
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['assignment'] = $course_assignment_array;
					$user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['certificate'] = $course_certificate_array;
					update_user_meta($user_id,'cs-user-courses-backup', $user_course_complete_backup_array);
					$course_key = '';
					$user_course_data = get_option($course_id."_cs_user_course_data", true);
					if(is_array($user_course_data) && count($user_course_data)>0){
						$course_key = '';
						foreach ( $user_course_data as $key=>$members ){
							if($transaction_id == $members['transaction_id']){
								$course_key = (int)$key;
								break;
							}
						}
						if(!empty($course_key) || $course_key == 0){
							$user_course_data[$course_key]['disable'] = 3;
						}
						update_option($course_id."_cs_user_course_data", $user_course_data);
						$user_course_dataaaa = get_option($course_id."_cs_user_course_data", true);
					}
			}
		}
	}
}

/**
 * @Quiz Questions Listing
 */
if ( ! function_exists( 'cs_user_quiz_assignment_record_ajax' ) ) { 
	function cs_user_quiz_assignment_record_ajax(){
		$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['quiz_id']))  $quiz_id = $_POST['quiz_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_quiz_questions = array();
		$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-quiz-nswers', true);
		if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]))
			$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
		$user_quiz_questions = $user_quiz_array['questions'];
		$total_questions = count($user_quiz_questions);
		if($total_questions>0){
		?>
            <ul class="pagination quiz-pagination ">
              <?php 
                    $counter_rand_no = rand(999,88888);
                    $counter_rand_no_j = $counter_rand_no;
                    $counter_rand_no_k = $counter_rand_no;
                    for($j=1; $j<=$total_questions; $j++){
                        $active_class = '';
                        if($j==1){$active_class = 'active';}
                    ?>
                    <li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"> <a onclick="cs_quiz_result_show_pagination('<?php echo esc_js($counter_rand_no);?>','<?php echo esc_js($counter_rand_no_j);?>',<?php echo esc_js($counter_rand_no+$total_questions);?>, <?php echo esc_js($j);?>)"><?php echo (int)$j;?></a> </li>
              <?php 
                    $counter_rand_no_j++;
                    }
                    ?>
            </ul>
	<?php 
			$counter  = 0;
			foreach ( $user_quiz_questions as $question_key=>$question ){
				if(empty($question_key) || !is_array($question))
					continue;
					
				$question_title = $question_marks = $answer_type = $user_answer = $user_question_point = $question_grade = '';
				if(isset($question['question_title']))
					$question_title = $question['question_title'];
				if(isset($question['question_marks']))
					$question_marks = $question['question_marks'];
				if(isset($question['answer_type']))
					$answer_type = $question['answer_type'];
				if(isset($question['user_answer']))
					$user_answer = $question['user_answer'];
				if(isset($question['user_question_point']))
					$user_question_point = $question['user_question_point'];
				$counter++;
				$style_class = '';
				if($counter <> 1){
					$style_class = 'style="display:none;"';	
				}
			?>
            <div class="question-number question-<?php echo esc_attr($counter_rand_no_k);?>" <?php echo $style_class;?>>
              <h5 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($question_title);?></h5>
              <?php
                        $counter_rand_no_k++;
                        if(isset($answer_type) && $answer_type == 'multiple-option'){
                                $question_grade = '';
                                $answer_title_multiple_option = $question['answer_title_multiple_option'];
                                $answer_title_multiple_option_correct = $question['answer_title_multiple_option_correct'];
                                if($user_answer == $answer_title_multiple_option_correct)
                                    $question_grade = 'right';
                                else if($user_answer <> $answer_title_multiple_option_correct)
                                    $question_grade = 'wrong';
                                $answer_title_multiple_option = explode('||',$answer_title_multiple_option);
                                $answer_title_multiple_option_correct = explode('||',$answer_title_multiple_option_correct);
                                $answer_user_answer = explode('||',$user_answer);
                                ?>
                              <ul class="check-box">
                                <?php 
									$counter_option = 0;
									foreach($answer_title_multiple_option as $answeroption_value){
										$counter_option++;
										$checked_value = '';
										if(in_array($counter_option, $answer_title_multiple_option_correct)){
											$correct_flag = 1;
										} else {
											$correct_flag = 0;
										}
										if(in_array($counter_option, $answer_user_answer)){
											$user_flag = 1;
										} else {
											$user_flag = 0;
										}
										if($correct_flag == 1 && $user_flag == 1){
											$checkbox_class = 'right-click';
											$checked_value = 'checked';
										}else if($correct_flag == 0 && $user_flag == 0)
											$checkbox_class = '';
										else if(($correct_flag == 0 && $user_flag == 1)){
											$checked_value = 'checked';
											$checkbox_class = 'wrong-click';
										}else if(($correct_flag == 1 && $user_flag == 0)){
											$checked_value = '';
											$checkbox_class = 'right-click';
										}else if(($correct_flag == 0 && $user_flag == 1) || ($correct_flag == 1 && $user_flag == 0))
											$checkbox_class = 'wrong-click';
									  ?>
										<li>
										  <input id="checkbox1" type="checkbox" <?php echo esc_attr($checked_value);?> disabled="disabled" />
										  <label for="checkbox1" class="<?php echo esc_attr($checkbox_class);?>"><?php echo esc_attr($answeroption_value);?></label>
										</li>
										<?php 
										}
									?>
                              </ul>
					  <?php } else if(isset($answer_type) && $answer_type == 'large-text'){
								$answer_large_text = $question['answer_large_text'];
								if($user_answer == $answer_large_text)
									$question_grade = 'right';
								else if($user_answer <> $answer_large_text)
									$question_grade = 'wrong';
							?>
                      <div class="textarea-sec">
                        <textarea><?php echo esc_textarea($user_answer);?></textarea>
                        <h6><?php _e('Remarks','EDULMS');?></h6>
                        <textarea class="bg-textarea"><?php echo esc_textarea($answer_large_text);?></textarea>
                      </div>
                      <?php }?>
                  <div class="score-sec">
                    <ul class="left-sec">
                      <li>
                        <label><?php _e('Score','EDULMS');?></label>
                        <!--  <input type="text" placeholder="0" />--> 
                        <span><?php echo esc_attr($user_question_point).'/'.esc_attr($question_marks);?></span> 
                        <!--<a href="#">update</a>--> 
                      </li>
                    </ul>
                    <ul class="right-sec <?php echo esc_attr($question_grade);?>-click-icon">
                      <li>
                        <?php 
							if($question_grade == 'right')
								_e('Correct','EDULMS');
							else if($question_grade == 'wrong')
								_e('Wrong','EDULMS');
							else 
								_e('Chosen','EDULMS');
						 ?>
                      </li>
                    </ul>
                  </div>
            </div>
			<?php
			}
		} else {
			_e('There are no questions against this quiz','EDULMS');
		}
		exit;
	}
	add_action('wp_ajax_cs_user_quiz_assignment_record_ajax', 'cs_user_quiz_assignment_record_ajax');
}

/**
 * @Quiz Questions Listing
 */
if ( ! function_exists( 'cs_registereduser_quiz_assignment_record_ajax' ) ) { 
	function cs_registereduser_quiz_assignment_record_ajax(){
		$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['quiz_id']))  $quiz_id = $_POST['quiz_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$course_id = $transaction_id;
		$user_quiz_questions = array();
		//$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-quiz-nswers', true);
		
		$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
		if(isset($quiz_answer_array[$course_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$course_id][$quiz_id][$attempt_no]))
			$user_quiz_array = $quiz_answer_array[$course_id][$quiz_id][$attempt_no];
		$user_quiz_questions = $user_quiz_array['questions'];
		$total_questions = count($user_quiz_questions);
		if($total_questions>0){
		?>
	<ul class="pagination quiz-pagination ">
	  <?php 
			$counter_rand_no = rand(999,88888);
			$counter_rand_no_j = $counter_rand_no;
			$counter_rand_no_k = $counter_rand_no;
			for($j=1; $j<=$total_questions; $j++){
				$active_class = '';
				if($j==1){$active_class = 'active';}
			?>
			<li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"> <a onclick="cs_quiz_result_show_pagination('<?php echo esc_js($counter_rand_no);?>','<?php echo esc_js($counter_rand_no_j);?>',<?php echo esc_js($counter_rand_no+$total_questions);?>, <?php echo esc_js($j);?>)"><?php echo (int)$j;?></a> </li>
	  		<?php 
			$counter_rand_no_j++;
			}
			?>
	</ul>
	<?php 
			$counter  = 0;
			foreach ( $user_quiz_questions as $question_key=>$question ){
				if(empty($question_key) || !is_array($question))
					continue;
				$question_title = $question_marks = $answer_type = $user_answer = $user_question_point = $question_grade = '';
				if(isset($question['question_title']))
					$question_title = $question['question_title'];
				if(isset($question['question_marks']))
					$question_marks = $question['question_marks'];
				if(isset($question['answer_type']))
					$answer_type = $question['answer_type'];
				if(isset($question['user_answer']))
					$user_answer = $question['user_answer'];
				if(isset($question['user_question_point']))
					$user_question_point = $question['user_question_point'];
				$counter++;
				$style_class = '';
				if($counter <> 1){
					$style_class = 'style="display:none;"';	
				}
			?>
            <div class="question-number question-<?php echo esc_attr($counter_rand_no_k);?>" <?php echo $style_class;?>>
              <h5 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($question_title);?></h5>
              <?php
                        $counter_rand_no_k++;
                        if(isset($answer_type) && $answer_type == 'multiple-option'){
                                $question_grade = '';
                                $answer_title_multiple_option = $question['answer_title_multiple_option'];
                                $answer_title_multiple_option_correct = $question['answer_title_multiple_option_correct'];
                                if($user_answer == $answer_title_multiple_option_correct)
                                    $question_grade = 'right';
                                else if($user_answer <> $answer_title_multiple_option_correct)
                                    $question_grade = 'wrong';
                                $answer_title_multiple_option = explode('||',$answer_title_multiple_option);
                                $answer_title_multiple_option_correct = explode('||',$answer_title_multiple_option_correct);
                                $answer_user_answer = explode('||',$user_answer);
                                ?>
                              <ul class="check-box">
                                <?php 
                                                    $counter_option = 0;
                                                    foreach($answer_title_multiple_option as $answeroption_value){
                                                        $counter_option++;
                                                        $checked_value = '';
                                                        if(in_array($counter_option, $answer_title_multiple_option_correct)){
                                                            $correct_flag = 1;
                                                        } else {
                                                            $correct_flag = 0;
                                                        }
                                                        if(in_array($counter_option, $answer_user_answer)){
                                                            $user_flag = 1;
                                                        } else {
                                                            $user_flag = 0;
                                                        }
                                                        if($correct_flag == 1 && $user_flag == 1){
                                                            $checkbox_class = 'right-click';
                                                            $checked_value = 'checked';
                                                        }else if($correct_flag == 0 && $user_flag == 0)
                                                            $checkbox_class = '';
                                                        else if(($correct_flag == 0 && $user_flag == 1)){
                                                            $checked_value = 'checked';
                                                            $checkbox_class = 'wrong-click';
                                                        }else if(($correct_flag == 1 && $user_flag == 0)){
                                                            $checked_value = '';
                                                            $checkbox_class = 'right-click';
                                                        }else if(($correct_flag == 0 && $user_flag == 1) || ($correct_flag == 1 && $user_flag == 0))
                                                            $checkbox_class = 'wrong-click';
                                                      ?>
                                <li>
                                  <input id="checkbox1" type="checkbox" <?php echo esc_attr($checked_value);?> disabled="disabled" />
                                  <label for="checkbox1" class="<?php echo esc_attr($checkbox_class);?>"><?php echo esc_attr($answeroption_value);?></label>
                                </li>
                                <?php 
                                                        }
                                                    ?>
                              </ul>
					  <?php } else if(isset($answer_type) && $answer_type == 'large-text'){
								$answer_large_text = $question['answer_large_text'];
								if($user_answer == $answer_large_text)
									$question_grade = 'right';
								else if($user_answer <> $answer_large_text)
									$question_grade = 'wrong';
                       ?>
                      <div class="textarea-sec">
                        <textarea><?php echo esc_textarea($user_answer);?></textarea>
                        <h6><?php _e('Remarks','EDULMS');?></h6>
                        <textarea class="bg-textarea"><?php echo esc_textarea($answer_large_text);?></textarea>
                      </div>
                      <?php }?>
                  <div class="score-sec">
                    <ul class="left-sec">
                      <li>
                        <label><?php _e('Score','EDULMS');?></label>
                        <!--  <input type="text" placeholder="0" />--> 
                        <span><?php echo esc_attr($user_question_point).'/'.esc_attr($question_marks);?></span> 
                        <!--<a href="#">update</a>--> 
                      </li>
                    </ul>
                    <ul class="right-sec <?php echo esc_attr($question_grade);?>-click-icon">
                      <li>
                        <?php 
							if($question_grade == 'right')
								_e('Correct','EDULMS');
							else if($question_grade == 'wrong')
								_e('Wrong','EDULMS');
							else 
								_e('Chosen','EDULMS');
						 ?>
                      </li>
                    </ul>
                  </div>
            </div>
	<?php
			}
		
		} else {
			_e('There are no questions against this quiz','EDULMS');
		}
		exit;
	}
	add_action('wp_ajax_cs_registereduser_quiz_assignment_record_ajax', 'cs_registereduser_quiz_assignment_record_ajax');
}

/**
 * @Complete Course Quiz and Assignments Listing
 */
 if ( ! function_exists( 'cs_courses_complete_quiz_assignment_record_ajax' ) ) { 
 
	function cs_courses_complete_quiz_assignment_record_ajax(){
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_course_complete_backup_array = array();
		$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
		if(is_array($user_course_complete_backup_array) && isset($user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]) && is_array($user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]) && array_key_exists((string)$transaction_id, $user_course_complete_backup_array[$course_id]) && count($user_course_complete_backup_array[$course_id])>0){
		$quiz_ids = $user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['quiz'];
		$assingments_ids = $user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['assignment'];
		$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		$pending_result = 0;
		
		if((isset($quiz_answer_array) && count($quiz_answer_array)>0 && is_array($quiz_ids) && count($quiz_ids)>0) || (isset($assingments_ids) && count($assingments_ids)>0 && is_array($assingments_ids) && count($assingments_ids)>0)){
	
			 ?>
				<table>
				  <thead>
					<tr>
					  <th class="first-th"><?php _e('Quiz and Assignments','EDULMS');?></th>
					  <th><?php _e('Attempts','EDULMS');?></th>
					  <th><?php _e('Required%','EDULMS');?></th>
					  <th><?php _e('Score','EDULMS');?></th>
					  <th><?php _e('Review','EDULMS');?></th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
						$average_percentage = 0;
						$counter_recoreds = 0;
						$average_getting_marks = 0;
						$avarage_passing_marks = 0;
						$average_total_marks = 0;
						$Fail_result = 0;
						// Course Attempted Quiz Listing
						if(isset($quiz_answer_array) && count($quiz_answer_array)>0 && is_array($quiz_ids) && count($quiz_ids)>0){
							foreach($quiz_ids as $quiz_id=>$quiz_value){
								if($quiz_id){
									if(isset($quiz_answer_array[(string)$transaction_id][(int)$quiz_id]) && is_array($quiz_answer_array[(string)$transaction_id][(int)$quiz_id])){
										$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
										$quiz_complete = get_option($quiz_complete_key);
										if(!isset($quiz_complete)){
											$quiz_complete = 1;
										} else if(isset($quiz_complete) && $quiz_complete == ''){
											$quiz_complete = 1;
										}
										$attempt_no = $quiz_complete-1;
										if(isset($quiz_answers['quiz_attempt']['quiz_attempt_no'])){
											$attempt_no = $user_quiz_attempts = $quiz_answers['quiz_attempt']['quiz_attempt_no'];
										}
										$no_of_retakes_allowed = '1';
										if(isset($quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed']))
											$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
										
										if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
											$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
											
											$user_quiz_info = array();
											$user_quiz_questions = array();
											$user_quiz_result_info = array();
											if(isset($user_quiz_array['quiz_information']))
												$user_quiz_info = $user_quiz_array['quiz_information'];
											if(isset($user_quiz_array['quiz_result']))
												$user_quiz_result_info = $user_quiz_array['quiz_result'];
											if(isset($user_quiz_array['questions']))
												$user_quiz_questions = $user_quiz_array['questions'];
											$attempt_questions = 0;
											$total_questions = count($user_quiz_questions);
											foreach($user_quiz_questions as $questions_key=>$questions_values){
												if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
													$attempt_questions++;
											}
											$user_points = 0;
											$question_marks_points = 0;
											$result_percentage = 0;
											$resutl_remarks = '';
											if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
												$resutl_remarks = $user_quiz_result_info['remarks'];
											if(isset($user_quiz_result_info['review_status']) && !empty($user_quiz_result_info['review_status']))
												$review_status = $user_quiz_result_info['review_status'];
												if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
													$user_points = $user_quiz_result_info['marks'];
												if(empty($user_points))
													$user_points = 0;
			
												if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
													$question_marks_points = $user_quiz_result_info['total_marks'];
												$average_total_marks  =$average_total_marks+$question_marks_points;
												if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
													$result_percentage = $user_quiz_result_info['marks_percentage'];
											
											$attempt_date = '';
											if(isset($user_quiz_result_info['attempt_date']))
												$attempt_date = $user_quiz_result_info['attempt_date'];
											$quiz_passing_marks = '';
											if(isset($user_quiz_info['quiz_passing_marks'])){
												$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
											}
			
											if(isset($review_status) && ($review_status == 'Fail')){
												$Fail_result = 1;
											} else if(isset($review_status) && ($review_status == 'Pass')){
												 $avarage_passing_marks = $avarage_passing_marks+$quiz_passing_marks;
												 $average_percentage = $average_percentage+$result_percentage;
												 $average_getting_marks  =$average_getting_marks+$user_points;
											}
											if(isset($review_status) && ($review_status == 'Pending' ||  $review_status == 'Remaining')){	
												$pending_result = 1;	
											}
											$counter_recoreds++;
											$quiz_post_status = get_post_status( $quiz_id );
											$quiz_permalink = '';
											$ratake_var = '';
											if( $quiz_post_status == 'publish' && $attempt_no<$no_of_retakes_allowed){
												$ratake_var = 'Retake';
												$quiz_permalink = get_permalink($quiz_id).'?course_id='.$course_id;
											} else {
												$quiz_permalink = '#';
											}
											$quiz_title = '';
											if(isset($user_quiz_info['title'])){$quiz_title = 'Quiz: '.$user_quiz_info['title'];}
										
										}
								} else {
									$quiz_title = 'Quiz: '.$quiz_value['title'];
									$quiz_permalink = '#';
									$ratake_var = '';
									$attempt_no = 0;
									$no_of_retakes_allowed = $quiz_value['quiz_retakes_no'];
									$quiz_passing_marks = $quiz_value['quiz_passing_marks'];
									$review_status = 'Remaining';
									$result_percentage = 0;
									$pending_result = 1;
								}
									?>
									 <tr>
									  <td class="first-td"><?php echo esc_attr($quiz_title);?></td>
									  <td><a class="retake"><small><?php echo esc_attr($attempt_no).'/'.esc_attr($no_of_retakes_allowed); ?></small></a></td>
									  <td><?php echo esc_attr($quiz_passing_marks);?>%</td>
									  <td><?php echo esc_attr($result_percentage);?>%</td>
									  <td><?php if(isset($review_status)) echo (string)$review_status;?></td>
									</tr>
									<?php
									}
								}
								
								if(isset($user_quiz_array['course_information']))
									$user_course_info = $user_quiz_array['course_information'];
								$course_pass_marks = 0;
								if(isset($user_course_info['course_pass_marks']))
									$course_pass_marks = $user_course_info['course_pass_marks'];
						}
						// Course Attempted Assignments Listing
							$counter_assign = 0;
							foreach($assingments_ids as $assignment_id=>$assingments_values){
								$assignment_id = $assingments_values['assignment_title'];
								if(!empty($assignment_id)){
										if(isset($user_assingments_array[$transaction_id][$assignment_id]) && is_array($user_assingments_array[$transaction_id][$assignment_id]) && count($user_assingments_array[$transaction_id][$assignment_id])>2){
												$assignment_array = $user_assingments_array[$transaction_id][$assignment_id];
												$assignment_marks = 0;
												$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
												$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
												$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
												$assignment_complete = get_option($assignment_complete_key);
												if(!isset($assignment_complete)){
													$assignment_complete = 1;
												} else if(isset($assignment_complete) && $assignment_complete == ''){
													$assignment_complete = 1;
												}
												$attempt_no = $assignment_complete-1;
												if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
												   $user_assignment_info = array(); 
													if(isset($assignment_array['course_assignment_info']))
														$user_assignment_info = $assignment_array['course_assignment_info'];
														
													$assignments_course_id = $user_assignment_info['course_id'];
													
													if($course_id <> $assignments_course_id)
														continue;
													$assignments_title = $user_assignment_info['assignments_title'];
													$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
													if(isset($user_assignment_info['assignment_total_marks']) && !empty($user_assignment_info['assignment_total_marks']))
														$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
													else 
														$assignment_total_marks = 100;
														
													$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
													
													$user_assignment_data = array(); 
													if(isset($assignment_array[$attempt_no]['assignment_data']))
														$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
												$attempt_date = $user_assignment_data['attempt_date'];
												$review_status = $user_assignment_data['review_status'];
												
												$user_email = $user_assignment_data['user_email'];
												if(isset($user_assignment_data['assignment_marks']) && $user_assignment_data['assignment_marks'] <> ''){
													$assignment_marks = $user_assignment_data['assignment_marks'];
												} else {
													$assignment_marks = 0;
												}
												$assignment_remarks = $user_assignment_data['assignment_remarks'];
												$ip_address = $user_assignment_data['ip_address'];
												$question_marks_points = $assignment_total_marks;
												$result_percentage = 0;
												$remaining_attempts = $assignment_retakes_no-$assignment_attempt_no;
												if($assignment_marks > 0 && $question_marks_points>0)
													$result_percentage = ($assignment_marks/$question_marks_points)*100;
												if($assignment_marks == '' )
													$assignment_marks = '-';
												$course_post_status = get_post_status( $course_id );
												$course_permalink = '#';
												$counter_recoreds++;
												$average_total_marks  =$average_total_marks+$assignment_total_marks;
												if($review_status == 'Published' || $review_status == 'Pass'){
													$average_percentage = $average_percentage+$result_percentage;
													$avarage_passing_marks = $avarage_passing_marks+$assignment_passing_marks;
													$average_getting_marks  =$average_getting_marks+$assignment_marks;
												} else if(isset($review_status) && ($review_status == 'Fail')){
													$Fail_result = 1;
												} else {
													$pending_result = 1;	
												}
												$ratake_var = '';
												if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){
														$ratake_var = 'Retake';
													  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';
												} else {
													$course_permalink = '#';
												}
												$assignments_title = '';
												if(isset($user_assignment_info['assignments_title'])) $assignments_title = 'Assignment: '.get_the_title((int)$assignment_id);
											}
										} else {
											$assignments_title = 'Assignment: '.get_the_title((int)$assignment_id);
											$quiz_permalink = '#';
											$attempt_no = 0;
											$assignment_retakes_no = $assingments_values['assignment_retakes_no'];
											$assignment_passing_marks = $assingments_values['assignment_passing_marks'];
											$review_status = 'Remaining';
											$result_percentage = 0;
											$pending_result = 1;
										}
											?>
											   <tr>
												  <td class="first-td"><?php echo (string)$assignments_title;?></td>
												  <td><a class="retake" target="_blank"><small><?php echo esc_attr($attempt_no).'/'.esc_attr($assignment_retakes_no); ?></small></a></td>
												  <td><?php if(isset($assignment_passing_marks)) echo esc_attr($assignment_passing_marks);?>%</td>
												  <td><?php if(isset($result_percentage)) echo esc_attr($result_percentage);?>%</td>
												  <td><?php if(isset($review_status)) echo esc_attr($review_status);?></td>
												</tr>
											<?php
										}
								}
						
						
							if(isset($pending_result) && $pending_result <> 1){
									$total_percentage = 0;
									if($average_percentage>0 && $counter_recoreds>0)
										$total_percentage = $average_percentage/$counter_recoreds;
								if($counter_recoreds>0 )       
									$avarage_passing_marks  = $avarage_passing_marks/$counter_recoreds;
								if(isset($avarage_passing_marks))	
									$avarage_passing_marks = round($avarage_passing_marks, 2);
									
									
								$average_percentage = 0;
								if($average_getting_marks>0 && $average_total_marks > 0){
									$average_percentage = ($average_getting_marks / $average_total_marks) * 100;
									$average_percentage = round($average_percentage, 2);
								}	
									
									
									
							} else {
								$average_getting_marks = '-';
								$average_total_marks = '-';
								$total_percentage = '';
								$average_percentage = '';
							}
						?>
						 <tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Required Passing','EDULMS');?> %</td>
						  <td class="bg-gray" colspan="2"><?php if(isset($course_pass_marks) && !empty($course_pass_marks)){echo esc_attr($course_pass_marks); } else { echo esc_attr($avarage_passing_marks);}?>%</td>
						</tr>
						<tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Obtained Marks','EDULMS');?> %</td>
						  <td class="bg-gray" colspan="2"><?php if(isset($average_percentage) && $average_percentage <> '') echo esc_attr($average_percentage).'%'; else echo '-';?></td>
						</tr>
						<tr>
						  <td class="first-td no-border" colspan="2"></td>
						  <td class="bg-gray" colspan="2"><?php _e('Status','EDULMS');?></td>
						  <td class="bg-gray" colspan="2">
								<?php 
								if(isset($pending_result) && $pending_result <> 1){
								   if($Fail_result <> 1){
										if(isset($course_pass_marks) && !empty($course_pass_marks)){
											$requied_marks = $course_pass_marks; 
										} else {
											 $requied_marks = $avarage_passing_marks;
										}
										if(isset($average_percentage) && $average_percentage <> ''){
											$average_percentage = $average_percentage;
											if($average_percentage>$requied_marks){
												echo 'Pass';
												$randiclass = rand(55,6666);
												$complete_dynmc_cls = $transaction_id.'-'.$course_id.'-'.$user_id.'-'.$randiclass;
												
												$course_certificate_array = $user_course_complete_backup_array[(int)$course_id][(string)$transaction_id]['certificate'];
												$certificate_no = $course_certificate_array['certificate_no'];
												$certificate_download = $course_certificate_array['certificate_download'];
												$certificate_allowed = $course_certificate_array['certificate_allowed'];
												if(empty($certificate_allowed) && $certificate_allowed <> '1'){
													$user_course_complete_backup_array[(int)$course_id]['certificate']['certificate_allowed'] = 1;
													update_user_meta($user_id,'cs-user-courses-backup', $user_course_complete_backup_array);
													$certificate_allowed = 1;
												} else if($certificate_allowed == 1 && $certificate_download <1 ){
													global $cs_course_options;
													$cs_course_options = $cs_course_options;
													$cs_page_id = $cs_course_options['cs_dashboard'];
													?>	
													<a title="" data-placement="top" data-toggle="tooltip" class="fa fa-download btn-default <?php echo (string)$complete_dynmc_cls;?>-crtfct-download" href="<?php echo cs_user_profile_link($cs_page_id, 'certificates', $user_id); ?>" data-original-title="<?php _e('Download Certificate','EDULMS');?>" ></a>
													<?php
													
												}
												
											}
										}
								   } else {
									   _e('Fail','EDULMS');
								   }
								 } else {
									 _e('Fail','EDULMS');
								 }
								 ?>
						  </td>
						</tr>
			  </tbody>
			</table>
			<?php
			}  else {
				_e('There are no records available','EDULMS');
			} 
		
		}  else {
			_e('There are no records available','EDULMS');
		}
			exit;	
	}
	add_action('wp_ajax_cs_courses_complete_quiz_assignment_record_ajax', 'cs_courses_complete_quiz_assignment_record_ajax');
 }



/**
 * User Profile Quiz tab
 */
if ( ! function_exists( 'cs_quiz_tab_list' ) ) { 
	function cs_quiz_tab_list($action,$uid,$cs_page_id) {
		?>
        <li <?php if($action  == 'Scores'){ echo 'class="active"'; } ?>>
            <a href="<?php echo cs_user_profile_link($cs_page_id, 'scores', $uid); ?>">
                <i class="fa fa-graduation-cap"></i><?php _e('Quiz Results  ','EDULMS'); ?>
            </a>
        </li>
       <?php
	}
	add_action('cs_quiz_tabs','cs_quiz_tab_list', 10, 3);
}

/**
 * User Profile Quiz tab
 */
if ( ! function_exists( 'cs_quiz_results_listing' ) ) { 
	function cs_quiz_results_listing($action) {
			if(isset($_GET['uid']) && $_GET['uid'] <> ''){
				$uid = $user_id = $_GET['uid'];
			} else {
				$uid = $user_id = cs_get_user_id();
			}
			
				$quiz_answer_array = get_user_meta($uid,'cs-quiz-nswers', true);
				
				
			
				$counter_courses = 420;
				
				
				$counter_registered_quiz = 400888;
				$quiz_registereduser_answer_array = get_user_meta($uid,'cs-registered-free-quiz-answers', true);
				
				$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
				$counter_assignments = 900888;
				$counter_assignments++;
			
				if((isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0)|| (isset($quiz_registereduser_answer_array) && is_array($quiz_registereduser_answer_array) && count($quiz_registereduser_answer_array)>0) || (isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0)){
				
				?>
				<div class="cs-section-title about-title"><h3><?php _e('Quiz and Assignment Results','EDULMS');?></h3></div>
				<div class="my-courses">
					<ul class="top-sec">
						<li><?php _e('Quiz/Assignments', 'EDULMS');?></li>
						<li><?php _e('Submission','EDULMS');?></li>
						<!--<li>Q-Taken</li>-->
						<li><?php _e('Marks','EDULMS');?></li>
						<li><?php _e('Score','EDULMS');?></li>
						<li><?php _e('Remarks','EDULMS');?></li>
						<li></li>
					</ul>
				<?php
					// Quiz Listing Array
					if(isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0){
						
						foreach($quiz_answer_array as $transaction_id=>$quiz_answer_values){
						foreach($quiz_answer_values as $quiz_id=>$quiz_answers){
							/*$quiz_complete_key = $uid.'_'.$transaction_id.'_'.$quiz_id;
							$quiz_complete = get_option($quiz_complete_key);
							if(!isset($quiz_complete)){
								$quiz_complete = 1;
							} else if(isset($quiz_complete) && $quiz_complete == ''){
								$quiz_complete = 1;
							}
							$attempt_no = $attempt_no_i = $quiz_complete-1;*/
							
							
							
							$quiz_complete_key = $uid.'_'.$transaction_id.'_'.$quiz_id;
							$quiz_complete = get_option($quiz_complete_key);
							if(!isset($quiz_complete)){
								$quiz_complete = 1;
							} else if(isset($quiz_complete) && $quiz_complete == ''){
								$quiz_complete = 1;
							}
							$attempt_no = $quiz_complete-1;
							if($attempt_no < 1){
								$attempt_no = 1;
								$quiz_complete = 1;
							}
							
							
							for($attempt_no=1; $attempt_no<=$quiz_complete; $attempt_no++){
							//for($attempt_no = 1; $attempt_no <= $attempt_no_i &&  $attempt_no++;){
								
								if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
							$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
								
							$user_quiz_result_info = array();
							$user_course_information = array();
							$user_quiz_questions = array();
							$user_quiz_info = array();
							
							if(isset($user_quiz_array['quiz_information']))
								$user_quiz_info = $user_quiz_array['quiz_information'];
							
							$quiz_passing_marks = 33;
							if(isset($user_quiz_info['quiz_passing_marks']))
								$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
							if(isset($user_quiz_array['quiz_result']))
								$user_quiz_result_info = $user_quiz_array['quiz_result'];
							if(isset($user_quiz_array['course_information']))
								$user_course_information = $user_quiz_array['course_information'];
							
							
							if(isset($user_course_information['course_title']))
								$course_title = $user_course_information['course_title'];
							if(!isset($course_title) || empty($course_title))	
							{
								if(isset($user_course_information['course_id'])){
									$course_id = $user_course_information['course_id'];
									$course_title = get_the_title($course_id);
								}
							}
							
							$user_quiz_questions = $user_quiz_array['questions'];
							$attempt_questions = 0;
							$total_questions = count($user_quiz_questions);
							
							if(is_array($user_quiz_questions) && count($user_quiz_questions)>0)
								foreach($user_quiz_questions as $questions_key=>$questions_values){
									if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
										$attempt_questions++;
								}
							$user_points = 0;
							$question_marks_points = 0;
							$result_percentage = 0;
							$resutl_remarks = '';
							if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
								$resutl_remarks = $user_quiz_result_info['remarks'];
							if(isset($resutl_remarks) && $resutl_remarks <> 'Pending'){
								if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
									$user_points = $user_quiz_result_info['marks'];
								$question_marks_points = 0;
								if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
									$question_marks_points = $user_quiz_result_info['total_marks'];
								if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
									$result_percentage = $user_quiz_result_info['marks_percentage'];
							}
							$attempt_date = '';
							if(isset($user_quiz_result_info['attempt_date']))
								$attempt_date = $user_quiz_result_info['attempt_date'];
								if(isset($user_quiz_info)){
									$counter_courses++;
							$quiz_title = '';
							if(isset($user_quiz_info['title']))
								$quiz_title = $user_quiz_info['title'];
							
								?>
								<script>
								  jQuery(document).ready(function($){
									  $('#toggle-<?php echo esc_js($counter_courses);?>').click(function() {
										  $('#toggle-div-<?php echo esc_js($counter_courses);?>').slideToggle('slow', function() {});
									  });
								  });
								</script>
									<ul class="bottom-sec">
										<li><?php 
										if(isset($course_title))
											echo esc_attr($course_title).' - ';
										if(isset($quiz_title))
											echo esc_attr($quiz_title);
										?></li>
										<li><?php echo esc_attr($attempt_date);?></li>
										<!--<li><?php echo absint($attempt_questions).'/'.absint($total_questions);?></li>-->
										 <li><?php echo absint($user_points).'/'.absint($question_marks_points);?></li>
										  <li><?php echo absint($result_percentage);?>%</li>
										   <li><?php echo (string)$resutl_remarks;?></li>
										<li><a href="#" id="toggle-<?php echo esc_attr($counter_courses);?>" onclick="cs_user_profile_quiz_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($uid);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses);?>')"><i class="fa fa-plus"></i></a></li>
									</ul>
									<div class="toggle-sec">
										<!--Quiz Questions listing-->
										<div class="toggle-div" id="toggle-div-<?php echo esc_js($counter_courses);?>"></div>
									</div>
								<?php
								}
						   }
							}
							
						}
					 }
					}
					
					//Free Quiz Listing Array
					if(isset($quiz_registereduser_answer_array) && is_array($quiz_registereduser_answer_array) && count($quiz_registereduser_answer_array)>0){
						foreach($quiz_registereduser_answer_array as $transaction_id=>$quiz_answer_values){
						 foreach($quiz_answer_values as $quiz_id=>$quiz_answers){
							$quiz_complete_key = $uid.'_'.$transaction_id.'_'.$quiz_id;
							$quiz_complete = get_option($quiz_complete_key);
							if(!isset($quiz_complete)){
								$quiz_complete = 1;
							} else if(isset($quiz_complete) && $quiz_complete == ''){
								$quiz_complete = 1;
							}
							$attempt_no = $attempt_no_i = $quiz_complete-1;
							
							for($attempt_no = 1; $attempt_no <= $attempt_no_i &&  $attempt_no++;){
								if(isset($quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no])){
							$user_quiz_array = $quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no];
						
							$user_quiz_result_info = array();
							$user_course_information = array();
							$user_quiz_questions = array();
							$user_quiz_info = array();
							
							if(isset($user_quiz_array['quiz_information']))
								$user_quiz_info = $user_quiz_array['quiz_information'];
							$quiz_passing_marks = 33;
							if(isset($user_quiz_info['quiz_passing_marks']))
								$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
							if(isset($user_quiz_array['quiz_result']))
								$user_quiz_result_info = $user_quiz_array['quiz_result'];
							if(isset($user_quiz_array['course_information']))
								$user_course_information = $user_quiz_array['course_information'];
							if(isset($user_course_information['course_title']))
								$course_title = $user_course_information['course_title'];
							$user_quiz_questions = $user_quiz_array['questions'];
							$attempt_questions = 0;
							$total_questions = count($user_quiz_questions);
							
							if(is_array($user_quiz_questions) && count($user_quiz_questions)>0)
								foreach($user_quiz_questions as $questions_key=>$questions_values){
									if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
										$attempt_questions++;
								}
							$user_points = 0;
							$question_marks_points = 0;
							$result_percentage = 0;
							$resutl_remarks = '';
							if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
								$resutl_remarks = $user_quiz_result_info['remarks'];
							if(isset($resutl_remarks) && $resutl_remarks <> 'Pending'){
								if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
									$user_points = $user_quiz_result_info['marks'];
								$question_marks_points = 0;
								if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
									$question_marks_points = $user_quiz_result_info['total_marks'];
								if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
									$result_percentage = $user_quiz_result_info['marks_percentage'];
							}
							$attempt_date = '';
							if(isset($user_quiz_result_info['attempt_date']))
								$attempt_date = $user_quiz_result_info['attempt_date'];
								if(isset($user_quiz_info)){
									$counter_registered_quiz++;
							$quiz_title = '';
							if(isset($user_quiz_info['title']))
								$quiz_title = $user_quiz_info['title'];
								?>
								<script>
								  jQuery(document).ready(function($){
									  $('#toggle-<?php echo esc_js($counter_registered_quiz);?>').click(function() {
										  $('#toggle-div-<?php echo esc_js($counter_registered_quiz);?>').slideToggle('slow', function() {});
									  });
								  });
								</script>
									<ul class="bottom-sec">
										<li><?php 
										if(isset($course_title))
											echo esc_attr($course_title);
										if(isset($course_title) && isset($quiz_title) &&  $course_title <> '' && $quiz_title <> '')
											echo ' - ';	
										if(isset($quiz_title))
											echo esc_attr($quiz_title);
											
										echo __('(Free Quiz)', 'EDULMS');
										?></li>
										<li><?php echo esc_attr($attempt_date);?></li>
										<!--<li><?php echo esc_attr($attempt_questions).'/'.esc_attr($total_questions);?></li>-->
										 <li><?php echo esc_attr($user_points).'/'.esc_attr($question_marks_points);?></li>
										  <li><?php echo esc_attr($result_percentage);?>%</li>
										   <li><?php echo esc_attr($resutl_remarks);?></li>
										<li><a href="#" id="toggle-<?php echo esc_attr($counter_registered_quiz);?>" onclick="cs_registereduser_profile_quiz_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($uid);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_registered_quiz);?>')"><i class="fa fa-plus"></i></a></li>
									</ul>
									<div class="toggle-sec">
										<!--Quiz Questions listing-->
										<div class="toggle-div" id="toggle-div-<?php echo esc_attr($counter_registered_quiz);?>"></div>
									</div>
								<?php
								}
						}
							}
							
						}
					}
					}
										
					// Assignment Listing Array
					if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0){
						foreach($user_assingments_array as $transaction_id=>$assingments_answer_values){
						if($transaction_id){
							$assingment_ids_info = array();
							if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
								$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
								$assingment_ids_info = array_unique($assingment_ids_info_array);
							}
						}
						$counter_assign = 0;
						foreach($assingment_ids_info as $assignment_id){	
							if(isset($assingments_answer_values[$assignment_id]) && is_array($assingments_answer_values[$assignment_id]) && count($assingments_answer_values[$assignment_id])>2){
									$assignment_array = $assingments_answer_values[$assignment_id];
									
									$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
						
									$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
									$assignment_complete = get_option($assignment_complete_key);
									if(!isset($assignment_complete)){
										$assignment_complete = 1;
									} else if(isset($assignment_complete) && $assignment_complete == ''){
										$assignment_complete = 1;
									}
									$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
									$attempt_no = $attempt_no_i = $assignment_attempt_no-1;
									
									for($attempt_no = 1; $attempt_no <= $attempt_no_i &&  $attempt_no++;){
										if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
									   $user_assignment_info = array(); 
										if(isset($assignment_array['course_assignment_info']))
											$user_assignment_info = $assignment_array['course_assignment_info'];
										$assignments_title = $user_assignment_info['assignments_title'];
										$course_type = '';
										if(isset($user_assignment_info['course_type']))
											$course_type = $user_assignment_info['course_type'];
										if($course_type == 'registered_user_access'){
											$course_type = ' (Free Assignment)';
										}
										$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
										if(isset($user_assignment_info['assignment_total_marks']) && !empty($user_assignment_info['assignment_total_marks']))
											$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
										else 
											$assignment_total_marks = 100;
										$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
										if(isset($user_assignment_info['course_instructor']))
											$course_instructor = $user_assignment_info['course_instructor'];
										else 
											$course_instructor = '';
										//for($attempt_no=1; $attempt_no<$assignment_attempt_no; $attempt_no++)	{
											$user_assignment_data = array(); 
											
											if(isset($assignment_array[$attempt_no]['assignment_data']))
												$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
											$attempt_date = $user_assignment_data['attempt_date'];
											$user_email = $user_assignment_data['user_email'];
											if(isset($user_assignment_data['assignment_marks']) && $user_assignment_data['assignment_marks'] <> ''){
												$assignment_marks = $user_assignment_data['assignment_marks'];
											} else {
												$assignment_marks = 0;
											}
											$assignment_remarks = $user_assignment_data['assignment_remarks'];
											$review_status = $user_assignment_data['review_status'];
											$ip_address = $user_assignment_data['ip_address'];
											$question_marks_points = $assignment_total_marks;
											$result_percentage = 0;
											$remaining_attempts = $assignment_retakes_no-$assignment_attempt_no;
											if($assignment_marks > 0 && $question_marks_points>0)
												$result_percentage = ($assignment_marks/$question_marks_points)*100;
											if($assignment_marks == '' )
												$assignment_marks = '-';
												$counter_assignments++;
											?>
												<script>
													  jQuery(document).ready(function($){
														  $('#toggle-<?php echo esc_js($counter_assignments);?>').click(function() {
															  $('#toggle-div-<?php echo esc_js($counter_assignments);?>').slideToggle('slow', function() {});
														  });
													  });
												</script>
												<ul class="bottom-sec">
													<li>
													<?php
													 if(isset($user_assignment_info['assignments_title'])) echo __('Assignment: ', 'EDULMS').esc_attr($user_assignment_info['assignments_title']);
													if(isset($course_type) && $course_type <> '') echo esc_attr($course_type);
													
													?></li>
													<li><?php if(isset($attempt_date)) echo esc_attr($attempt_date);?></li>
													<li><?php if(isset($question_marks_points) && isset($assignment_marks)) echo esc_attr($assignment_marks.'/'.$question_marks_points);?></li>
													<li><?php if(isset($result_percentage)) echo esc_attr($result_percentage);?>%</li>
													<li><?php if(isset($review_status)) echo esc_attr($review_status);?></li>
													<li><a href="#" id="toggle-<?php echo esc_attr($counter_assignments);?>" onclick="cs_user_profile_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_assignments);?>')"><i class="fa fa-plus"></i></a></li>
												</ul>
												<div class="toggle-sec">
													<!--Quiz Questions listing-->
													<div class="toggle-div" id="toggle-div-<?php echo esc_js($counter_assignments);?>"></div>
												</div>
											<?php
										
									}
							}
									}
						}
					}
					}
				?>
				</div>
					<script>
						function cs_user_profile_quiz_assignment_record(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course){
								var dataString = 'transaction_id=' + transaction_id + 
										  '&quiz_id=' + quiz_id +
										  '&attempt_no=' + attempt_no +
										  '&user_id=' + user_id +
										  '&course_id=' + course_id +
										  '&action=cs_user_quiz_assignment_record_ajax';
								jQuery("#toggle-div-"+counter_course).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
								jQuery.ajax({
									type:"POST",
									url: admin_url,
									data:dataString, 
									success:function(response){
										jQuery("#toggle-div-"+counter_course).html(response);
										jQuery("#toggle-"+counter_course).prop("onclick", null);
									}
								});
								return false;
						}
						function cs_registereduser_profile_quiz_assignment_record(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course){
								var dataString = 'transaction_id=' + transaction_id + 
										  '&quiz_id=' + quiz_id +
										  '&attempt_no=' + attempt_no +
										  '&user_id=' + user_id +
										  '&course_id=' + course_id +
										  '&action=cs_registereduser_quiz_assignment_record_ajax';
								jQuery("#toggle-div-"+counter_course).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
								jQuery.ajax({
									type:"POST",
									url: admin_url,
									data:dataString, 
									success:function(response){
										jQuery("#toggle-div-"+counter_course).html(response);
										jQuery("#toggle-"+counter_course).prop("onclick", null);
									}
								});
								return false;
						}
						function cs_user_profile_assignment_record(transaction_id,assignment_id,attempt_no,user_id,course_id,admin_url, counter_courses){
								var dataString = 'transaction_id=' + transaction_id + 
										  '&assignment_id=' + assignment_id +
										  '&attempt_no=' + attempt_no +
										  '&user_id=' + user_id +
										  '&course_id=' + course_id +
										  '&action=cs_user_assignment_record_ajax';
								jQuery("#toggle-div-"+counter_courses).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
								jQuery.ajax({
									type:"POST",
									url: admin_url,
									data:dataString, 
									success:function(response){
										jQuery("#toggle-div-"+counter_courses).html(response);
										jQuery("#toggle-"+counter_courses).prop("onclick", null);
									}
								});
								return false;
							}
					</script>
				<?php
				
				} else {
					echo 'There are no records availble';	
				}
		
	}
	add_action('cs_quiz_results_page','cs_quiz_results_listing');
}



/**
 * User Course Details link
 */
if ( ! function_exists( 'cs_course_quiz_assignment_tab' ) ) { 
	function cs_course_quiz_assignment_tab($transaction_id, $user_id, $course_id, $counter_courses, $course_status ) {
		if($course_status == 'Completed' || $course_status == 'Expired'){
			?>
				<a style="cursor:pointer;" id="toggle-<?php echo esc_attr($counter_courses);?>" onclick="cs_courses_complete_quiz_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($course_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses);?>'); return false;"><i class="fa fa-plus"></i></a>
			<?php
			} else {
			?>
				<a style="cursor:pointer;" id="toggle-<?php echo esc_attr($counter_courses);?>" onclick="cs_courses_quiz_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($course_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses);?>'); return false;"><i class="fa fa-plus"></i></a>
			<?php 
		}
	}
	add_action('cs_course_quiz_assignment_restults','cs_course_quiz_assignment_tab', 10, 5);
}
		

/**
 * @Complete Course Quiz and Assignments Taken Marks(%)
 */
 if ( ! function_exists( 'cs_courses_taken_marks' ) ) { 
 
	function cs_courses_taken_marks($course_id,$user_id,$transaction_id){
		if(isset($transaction_id))  $transaction_id = $transaction_id;
		if(isset($user_id))  $user_id = $user_id;
		if(isset($course_id))  $course_id = $course_id;
	
		$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		$pending_result = 0;
		 if((isset($quiz_answer_array[$transaction_id]) && count($quiz_answer_array[$transaction_id])>0 && array_key_exists((string)$transaction_id, $quiz_answer_array)) || (isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array))){
			 
						$average_percentage = 0;
						$counter_recoreds = 0;
						$average_getting_marks = 0;
						$avarage_passing_marks = 0;
						$average_total_marks = 0;
						$Fail_result = 0;
						
						// Course Attempted Quiz Listing
						if(isset($quiz_answer_array[$transaction_id]) && count($quiz_answer_array[$transaction_id])>0 && array_key_exists((string)$transaction_id, $quiz_answer_array)){
								if (array_key_exists((string)$transaction_id, $quiz_answer_array)) {
								foreach($quiz_answer_array[$transaction_id] as $quiz_id=>$quiz_answers){	
							
							
								$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
								$quiz_complete = get_option($quiz_complete_key);
								if(!isset($quiz_complete)){
									$quiz_complete = 1;
								} else if(isset($quiz_complete) && $quiz_complete == ''){
									$quiz_complete = 1;
								}
								$attempt_no = $quiz_complete-1;
								
								if(isset($quiz_answers['quiz_attempt']['quiz_attempt_no'])){
									$attempt_no = $user_quiz_attempts = $quiz_answers['quiz_attempt']['quiz_attempt_no'];
								}
								
								$no_of_retakes_allowed = '1';
								if(isset($quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed']))
									$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
								
										if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
											$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
											
											
											$user_quiz_info = $user_quiz_array['quiz_information'];
											$user_quiz_result_info = $user_quiz_array['quiz_result'];
											$user_quiz_questions = $user_quiz_array['questions'];
											$attempt_questions = 0;
											$total_questions = count($user_quiz_questions);
											foreach($user_quiz_questions as $questions_key=>$questions_values){
												if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
													$attempt_questions++;
											}
											$user_points = 0;
											$question_marks_points = 0;
											$result_percentage = 0;
											$resutl_remarks = '';
											if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
												$resutl_remarks = $user_quiz_result_info['remarks'];
											if(isset($user_quiz_result_info['review_status']) && !empty($user_quiz_result_info['review_status']))
												$review_status = $user_quiz_result_info['review_status'];
												if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
													$user_points = $user_quiz_result_info['marks'];
												if(empty($user_points))
													$user_points = 0;
												if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
													$question_marks_points = $user_quiz_result_info['total_marks'];
												$average_total_marks  =$average_total_marks+$question_marks_points;
												if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
													$result_percentage = $user_quiz_result_info['marks_percentage'];
											$attempt_date = '';
											if(isset($user_quiz_result_info['attempt_date']))
												$attempt_date = $user_quiz_result_info['attempt_date'];
											$quiz_passing_marks = '';
											if(isset($user_quiz_info['quiz_passing_marks'])){
												$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
											}
											if(isset($review_status) && ($review_status == 'Fail')){
												$Fail_result = 1;
											} else if(isset($review_status) && ($review_status == 'Pass')){
												 $avarage_passing_marks = $avarage_passing_marks+$quiz_passing_marks;
												 $average_percentage = $average_percentage+$result_percentage;
												 $average_getting_marks  =$average_getting_marks+$user_points;
												 
											}
											if(isset($review_status) && ($review_status == 'Pending' ||  $review_status == 'Remaining')){	
												$pending_result = 1;	
											}
											$counter_recoreds++;
											$quiz_post_status = get_post_status( $quiz_id );
											$quiz_permalink = '';
											$ratake_var = '';
											if( $quiz_post_status == 'publish' && $attempt_no<$no_of_retakes_allowed){
												$ratake_var = 'Retake';
												$quiz_permalink = get_permalink($quiz_id).'?course_id='.$course_id;
											} else {
												$quiz_permalink = '#';
											}
										 }
									}
									if(isset($user_quiz_array['course_information']))
										$user_course_info = $user_quiz_array['course_information'];
									$course_pass_marks = 0;
									if(isset($user_course_info['course_pass_marks']))
										$course_pass_marks = $user_course_info['course_pass_marks'];
							}
						}
					// Course Attempted Assignments Listing
					if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0 && array_key_exists((string)$transaction_id, $user_assingments_array)){	
						if (array_key_exists((string)$transaction_id, $user_assingments_array)) {
							if($transaction_id){
								$assingment_ids_info = array();
								if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
									$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
									$assingment_ids_info = array_unique($assingment_ids_info_array);
								}
							}
							$counter_assign = 0;
							foreach($assingment_ids_info as $assignment_id){	
								if(isset($user_assingments_array[$transaction_id][$assignment_id]) && is_array($user_assingments_array[$transaction_id][$assignment_id]) && count($user_assingments_array[$transaction_id][$assignment_id])>2){
										$assignment_array = $user_assingments_array[$transaction_id][$assignment_id];
										$assignment_marks = 0;
										$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
										$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
										$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
										$assignment_complete = get_option($assignment_complete_key);
										if(!isset($assignment_complete)){
											$assignment_complete = 1;
										} else if(isset($assignment_complete) && $assignment_complete == ''){
											$assignment_complete = 1;
										}
										$attempt_no = $assignment_complete-1;
										if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
										   $user_assignment_info = array(); 
											if(isset($assignment_array['course_assignment_info']))
												$user_assignment_info = $assignment_array['course_assignment_info'];
												
											$assignments_course_id = $user_assignment_info['course_id'];
											
											if($course_id <> $assignments_course_id)
												continue;
											$assignments_title = $user_assignment_info['assignments_title'];
											$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
											if(isset($user_assignment_info['assignment_total_marks']) && !empty($user_assignment_info['assignment_total_marks']))
												$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
											else 
												$assignment_total_marks = 100;
												
											$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
											
											$user_assignment_data = array(); 
											if(isset($assignment_array[$attempt_no]['assignment_data']))
												$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
										$attempt_date = $user_assignment_data['attempt_date'];
										$review_status = $user_assignment_data['review_status'];
										
										$user_email = $user_assignment_data['user_email'];
										if(isset($user_assignment_data['assignment_marks']) && $user_assignment_data['assignment_marks'] <> ''){
											$assignment_marks = $user_assignment_data['assignment_marks'];
										} else {
											$assignment_marks = 0;
										}
										$assignment_remarks = $user_assignment_data['assignment_remarks'];
										$ip_address = $user_assignment_data['ip_address'];
										$question_marks_points = $assignment_total_marks;
										$result_percentage = 0;
										$remaining_attempts = $assignment_retakes_no-$assignment_attempt_no;
										if($assignment_marks > 0 && $question_marks_points>0)
											$result_percentage = ($assignment_marks/$question_marks_points)*100;
										if($assignment_marks == '' )
											$assignment_marks = '-';
										$course_post_status = get_post_status( $course_id );
										$course_permalink = '#';
										$counter_recoreds++;
										$average_total_marks  =$average_total_marks+$assignment_total_marks;
										if($review_status == 'Published' || $review_status == 'Pass'){
											$average_percentage = $average_percentage+$result_percentage;
											$avarage_passing_marks = $avarage_passing_marks+$assignment_passing_marks;
											$average_getting_marks  =$average_getting_marks+$assignment_marks;
										} else if(isset($review_status) && ($review_status == 'Fail')){
											$Fail_result = 1;
										} else {
											$pending_result = 1;	
										}
										$ratake_var = '';
										if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){
												$ratake_var = 'Retake';
											  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';
										} else {
											$course_permalink = '#';
										}
									}
								}
							}
						}
					}
					// Course Remaining Quiz and Listings
					if($course_id){
							$post_xml = get_post_meta($course_id, "cs_course", true);
							$cs_xmlObject = new SimpleXMLElement($post_xml);
						}
						if(count($cs_xmlObject->course_curriculms )>0){
							foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
								$listing_type = $curriculm->listing_type;
								if($listing_type == 'quiz'){
									$var_cp_course_quiz_list = $curriculm->var_cp_course_quiz_list;
									if ((!isset($quiz_answer_array) || !is_array($quiz_answer_array) || empty($quiz_answer_array)) || (is_array($quiz_answer_array) && !isset($quiz_answer_array[(string)$transaction_id]) ) || (is_array($quiz_answer_array) && isset($quiz_answer_array[(string)$transaction_id]) && is_array($quiz_answer_array[(string)$transaction_id]) && !array_key_exists((int)$var_cp_course_quiz_list, $quiz_answer_array[(string)$transaction_id]))) {
										$quiz_passing_marks = $curriculm->quiz_passing_marks;
										$quiz_retakes_no = $curriculm->quiz_retakes_no;
										$quiz_post_status = get_post_status( $quiz_id );
										$quiz_permalink = '#';
										$attempt_no = 0;
										$pending_result = 1;
										if( $quiz_post_status == 'publish' && $attempt_no<$quiz_retakes_no){  $quiz_permalink = get_permalink((int)$var_cp_course_quiz_list).'?course_id='.$course_id;} else {$quiz_permalink = '#';}
									}
								} else if($listing_type == 'assigment'){
									$assignment_id = $curriculm->assignment_id;
									$assignment_id = (int)$curriculm->var_cp_assignment_title;
									if($assignment_id){
									if ((!isset($user_assingments_array) || !is_array($user_assingments_array) || empty($user_assingments_array)) || (is_array($user_assingments_array) && !isset($user_assingments_array[(string)$transaction_id]) ) || (is_array($user_assingments_array) && isset($user_assingments_array[(string)$transaction_id]) && is_array($user_assingments_array[(string)$transaction_id]) && !array_key_exists((int)$assignment_id, $user_assingments_array[(string)$transaction_id]))) {
										$assignment_passing_marks = $curriculm->assignment_passing_marks;
										$assignment_total_marks = $curriculm->assignment_total_marks;
										$assignment_retakes_no = $curriculm->assignment_retakes_no;
										$var_cp_assignment_title = $curriculm->var_cp_assignment_title;
										$average_total_marks = $average_total_marks+$assignment_total_marks;
										$attempt_no = 0;
										$course_permalink = '#';
										$pending_result = 1;
										$course_post_status = get_post_status( $course_id );
										if( $course_post_status == 'publish' && $attempt_no<$assignment_retakes_no){  $course_permalink = get_permalink($course_id).'?filter_action=course-curriculm';} else {$course_permalink = '#';}
									   }
									}
								}
							}
						}	
						if(isset($pending_result) && $pending_result <> 1){
								$total_percentage = 0;
								if($average_percentage>0 && $counter_recoreds>0)
									$total_percentage = $average_percentage/$counter_recoreds;
							if($counter_recoreds>0 )       
								$avarage_passing_marks  = $avarage_passing_marks/$counter_recoreds;
							if(isset($avarage_passing_marks))	
								$avarage_passing_marks = round($avarage_passing_marks, 2);
							$average_percentage = 0;
							if($average_getting_marks>0 && $average_total_marks > 0){
								$average_percentage = ($average_getting_marks / $average_total_marks) * 100;
								$average_percentage = round($average_percentage, 2);
							}	
						} else {
							$average_getting_marks = '-';
							$average_total_marks = '-';
							$total_percentage = '';
							$average_percentage = '';
						}
						if(isset($average_percentage) && $average_percentage <> '') return $average_percentage.'%'; else return '-';
			 }  else {
				 return '-';
			 }
	
	}
	add_action('wp_ajax_cs_courses_taken_marks', 'cs_courses_taken_marks');
 }