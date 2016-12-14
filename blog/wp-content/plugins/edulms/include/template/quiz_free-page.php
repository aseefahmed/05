<?php
/**
 * Free Quiz without login
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 echo esc_attr( 'quiz free' );
 global $post,$course_ID, $cs_xmlObject;
 	if(isset($cs_xmlObject->quiz_question_show))
 		$quiz_question_show = $cs_xmlObject->quiz_question_show;
	if(isset($cs_xmlObject->quiz_auto_results))
 		$quiz_auto_results = $cs_xmlObject->quiz_auto_results;
	$quiz_answer_array = array();
 	if ( false === ( $special_query_results = get_transient( "cs_course_quiz_rand_id".$course_ID.$post->ID ) ) ) {
		$transaction_id = rand(85,999);
		set_transient( "cs_course_quiz_rand_id".$course_ID.$post->ID, $transaction_id, 12 * 432000 );
	
	if(isset($course_ID) && $course_ID <> ''){
		$course_xml = get_post_meta($course_ID, "cs_course", true);
		if ( $course_xml <> "" ) {
			$cs_course_xmlObject = new SimpleXMLElement($course_xml);
			$var_cp_course_paid = $cs_course_xmlObject->var_cp_course_paid;
			if(count($cs_course_xmlObject->course_curriculms )>0){
				foreach ( $cs_course_xmlObject->course_curriculms as $curriculm ){
					$listing_type = $curriculm->listing_type;
					if($listing_type == 'quiz'){
						$var_cp_course_quiz_list = (int)$curriculm->var_cp_course_quiz_list;
							if($var_cp_course_quiz_list == $post->ID){
								$var_cp_course_quiz_type = $curriculm->var_cp_course_quiz_type;
								$quiz_passing_marks = $curriculm->quiz_passing_marks;
								$quiz_retakes_no = $curriculm->quiz_retakes_no;
								break;
							}
					}
				}
			}
		}
	}

	$quiz_complete = 1;	
	
	if(isset($quiz_answer_array[$transaction_id][$post->ID]) && count($quiz_answer_array[$transaction_id][$post->ID]) < 2)
		update_option($quiz_complete_key,'');
	if(!is_array($quiz_answer_array)){
		$quiz_attemp_array = array();
		$quiz_attemp_array['attempts'] = 1;
		$quiz_attemp_array['no_of_retakes_allowed'] = (int)$quiz_retakes_no;
		$quiz_attemp_array['retake'] = '';
		$quiz_attemp_array['quiz_attempt_no'] = (int)$quiz_complete;
		$quiz_attemp_array['quiz_attempte_loaded'] = (string)'loaded';
		$quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt'] = $quiz_attemp_array;
	} else if(!is_array($quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt'])){
		$quiz_attemp_array = array();
		$quiz_attemp_array['attempts'] = 1;
		$quiz_attemp_array['no_of_retakes_allowed'] = (int)$quiz_retakes_no;
		$quiz_attemp_array['retake'] = '';
		$quiz_attemp_array['quiz_attempt_no'] = (int)$quiz_complete;
		$quiz_attemp_array['quiz_attempte_loaded'] = (string)'loaded';
		$quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt'] = $quiz_attemp_array;
	} else if(is_array($quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt']) && count($quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt'])<5){
		$quiz_attemp_array = array();
		$quiz_attemp_array['attempts'] = 1;
		$quiz_attemp_array['no_of_retakes_allowed'] = (int)$quiz_retakes_no;
		$quiz_attemp_array['retake'] = '';
		$quiz_attemp_array['quiz_attempt_no'] = (int)$quiz_complete;
		$quiz_attemp_array['quiz_attempte_loaded'] = (string)'loaded';
		$quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt'] = $quiz_attemp_array;
	} else {
		$quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt']['quiz_attempt_no'] = (string)$quiz_complete;
	}
	$attempt = $quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt']['quiz_attempt_no'];
	$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt']['no_of_retakes_allowed'];
	if(isset($_REQUEST['retake_quiz']) && $_REQUEST['retake_quiz'] == 1){
		
	}
	if($no_of_retakes_allowed < $attempt && !isset($_REQUEST['retake_quiz']) && isset($quiz_answer_array[(string)$transaction_id][(int)$post->ID] )&& is_array($quiz_answer_array[(string)$transaction_id][(int)$post->ID])){
		$user_questionaire_array = array();
		if(isset($quiz_answer_array[$transaction_id][$post->ID] )&& is_array($quiz_answer_array[$transaction_id][$post->ID])){
			if(isset($quiz_complete) && $quiz_complete>1)
				$attempt_no = $quiz_complete-1;
			$user_questionaire_array = $quiz_answer_array[$transaction_id][$post->ID][$attempt_no];
		}
		foreach($user_questionaire_array['questions'] as $question){
			$question_answer_options = $question['answer_title_multiple_option'];
			$question_answer_options = explode("||",$question_answer_options);
			$answer_title_multiple_option_correct = $question['answer_title_multiple_option_correct'];
			$answer_title_multiple_option_correct = explode("||",$answer_title_multiple_option_correct);
			$user_question_point = $question['user_question_point'];
			$options_counter = 0;
			?>
			<h4><?php echo esc_attr( $question['question_title'] );?>	<span> <?php _e('Question Marks:','EDULMS');?> <?php echo esc_attr( $question['question_marks'] );?></span></h4>
			<?php if(is_array($question_answer_options) && count($question_answer_options)){?>
					<ul>
						<?php foreach($question_answer_options as $question_answer_options_values){?>
								<li><?php echo esc_attr( $question_answer_options_values );?></li>
						<?php }?>
					</ul>
					<ul>
						<li><?php _e('Answers','EDULMS');?>:</li>
						<li>
						 <?php 
						 foreach($answer_title_multiple_option_correct as $answer_title_multiple_option_correct_values){
							if($answer_title_multiple_option_correct_values){
								$answer_value = $answer_title_multiple_option_correct_values-1;
								echo esc_attr( $question_answer_options[$answer_value].' ' );
							}
						 }
						 ?>
						</li>
					</ul>
					<?php if($user_question_point){?>
					<ul>
						<li><?php _e('Obtained Marks:','EDULMS');?></li>
						<li><?php echo esc_attr( $user_question_point );?></li>
					</ul>
					<?php }?>
			<?php
			}
		}
		
		}
		 else if($no_of_retakes_allowed >= $attempt){
			$quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt']['retake'] = (string)'Allowed';
			$total_questions  = count($cs_xmlObject->question);
			if($quiz_question_show<$total_questions){
				$total_questions = $quiz_question_show;
			}
			 ?>  
			   <div id="quiz">     
				   <ul class="quiz-pagination pagination">
						<?php 
							for($j=1; $j<=$total_questions; $j++){
								?>
								<li><a onclick="cs_quiz_pagination('<?php echo intval( $j );?>',<?php echo intval( $total_questions );?>)"><?php echo intval( $j );?></a></li>
								<?php
							}
						?>
				   </ul>
				   <div class="loading"></div>
				   <form id="quiz-form" name="quiz-from" method="post">
				   <input type="hidden" name="action" value="cs_free_quiz_submit" />
				   <input type="hidden" name="transaction_id" value="<?php echo esc_attr( $transaction_id );?>" />
				   <input type="hidden" name="post_id" value="<?php echo intval( $post->ID );?>" />
				   <input type="hidden" name="course_id" value="<?php echo intval( $course_ID );?>" />
				   <?php 
					if ( isset($cs_xmlObject) ) {
						$user_quiz_questions_data = get_post_meta($post->ID, "cs_quiz_questions_meta", true);
						$counter= 0;
						$total_marks = 0;
						$answer_options_coutner = 0;
						$array =  cs_ObjecttoArray($cs_xmlObject);
						$myarray = $array['question'];
						$questionsarray = cs_shuffle_assoc($myarray);
						$quiz_information_array = array();
						$quiz_information_array['quiz_ID'] = $post->ID;
						$quiz_information_array['transaction_id'] = $transaction_id;
						$quiz_information_array['title'] = get_the_title();
						$quiz_information_array['quiz_type'] = (string)$var_cp_course_quiz_type;
						$quiz_information_array['quiz_retakes_no'] = (int)$quiz_retakes_no;
						$quiz_information_array['quiz_passing_marks'] = (int)$quiz_passing_marks;
						$quiz_information_array['quiz_auto_results'] = (string)$quiz_auto_results;
						$quiz_information_array['quiz_description'] = (string)$cs_xmlObject->quiz_message;
						$quiz_information_array['quiz_duration'] = (string)$cs_xmlObject->quiz_duration;
						$quiz_information_array['quiz_success_message'] = (string)$cs_xmlObject->quiz_success_message;
						$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['quiz_information'] = $quiz_information_array;
						if(isset($course_ID) && $course_ID <> ''){
							$course_information_array = array();
							$course_information_array['course_id'] = $course_ID;
							$course_information_array['course_title'] = get_the_title($course_ID);
							$cs_course = get_post_meta($course_ID, "cs_course", true);
							$var_cp_course_instructor = get_post_meta( $course_ID, 'var_cp_course_instructor', true);
							if ( $cs_course <> "" ) {
								$course_xmlObject = new SimpleXMLElement($cs_course);
								if ( empty($course_xmlObject->course_id) ) $course_no = ""; else $course_no = (int)$course_xmlObject->course_id;
								if ( empty($course_xmlObject->course_pass_marks) ) $course_pass_marks = ""; else $course_pass_marks = (string)$course_xmlObject->course_pass_marks;
								if ( empty($course_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = (string)$course_xmlObject->course_short_description;
								if ( empty($course_xmlObject->course_duration) ) $course_duration = ""; else $course_duration = (string)$course_xmlObject->course_duration;
								$course_information_array['course_no'] = $course_no;
								$course_information_array['var_cp_course_instructor'] = $var_cp_course_instructor;
								$course_information_array['course_pass_marks'] = $course_pass_marks;
								$course_information_array['course_short_description'] = $course_short_description;
								$course_information_array['course_duration'] = $course_duration;
							}
							$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['course_information'] = $course_information_array;
						 }
						$quiz_result_array = array();
						$quiz_result_array['attempt_date'] = date('Y-m-d H:i:s');
						$quiz_result_array['marks'] = '';
						$quiz_result_array['grade'] = '';
						$quiz_result_array['marks_percentage'] = '';
						$quiz_result_array['remarks'] = '';
						$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['quiz_result'] = (array)$quiz_result_array;
						$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['questions'] = array();
						foreach ( $questionsarray as $question_key=>$question ){
							$counter++;
							if($quiz_question_show < $counter){
								break;	
							}
							$answer_type = '';
							$answer_type = $question['answer_type'];
							$question_marks = $question['question_marks'];
							$question_id = $question['question_id'];
							$answer_single_radio_option = $question['answer_single_radio_option'];
							$total_marks = $total_marks+$question_marks;
							$style_class = '';
							if($counter <> 1){
								$style_class = 'style="display:none;"';	
							}
							$question_no_array = array();
							$question_no_array = $user_quiz_questions_data[$question_id];
							$question_no_array['user_answer'] = '';
							$question_no_array['user_question_point'] = '';
							$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['questions'][$question_id] = $question_no_array;
							?>
								<input type="hidden" name="question_ids_array[]" value="<?php echo esc_attr( $question_id );?>" />
								<div class="question-number question<?php echo absint($counter);?>" <?php echo esc_attr( $style_class );?>>
									<h5 class="result-heading"><?php echo esc_attr( $question['question_title'] );?>	<i class="fa fa-question-circle"></i></h5>
									<?php if($answer_type == 'single-option'){?>
										<ul class="check-box">
											<li class="to-label">
												<input type="checkbox" name="question_<?php echo esc_attr( $question_id ); ?>[]" />
											</li>
											<li class="to-label">
												<?php echo esc_attr( $question['answer_title_single_option_1'] );?>
											</li>
										</ul>
										<ul class="check-box">
											<li class="to-label">
												<input type="checkbox" name="question_<?php echo esc_attr( $question_id );?>[]" />
											</li>
											<li class="to-label">
												<?php echo esc_attr( $question['answer_title_single_option_2'] );?>
											</li>
										</ul>
									<?php } else if(trim($answer_type) == 'multiple-option'){
											$questionnum = $question_key+1;
											$title_multiple_option =  "answer_title_multiple_option_$questionnum";
											$title_multiple_option = $question[$title_multiple_option];
											if(isset($title_multiple_option)){
												echo '<ul class="check-box">';
												$multipleoptions = explode("||",$title_multiple_option);
												$option_no = 1;
												$input_type = 'checkbox';
												if(isset($answer_single_radio_option) && $answer_single_radio_option == 'single-answer-radio-option'){$input_type = 'radio';}
												foreach($multipleoptions as $multipleoptions_title){
													if(isset($multipleoptions_title) && $multipleoptions_title <> ''){
														$answer_options_coutner++;
														?>
                                                        	<li>
                                                                <div class="<?php echo esc_attr( $input_type );?>">
                                                                    <input type="<?php echo esc_attr( $input_type );?>" value="<?php echo esc_attr( $option_no );?>" name="question_<?php echo esc_attr( $question_id );?>[]" id="checkbox<?php echo esc_attr( $answer_options_coutner );?>" />
                                                                   <label for="checkbox<?php echo esc_attr( $answer_options_coutner );?>"><?php echo esc_attr( $multipleoptions_title );?></label>
                                                                  </div>
                                                            </li>
														<?php
														$option_no++;
													}
												}
												echo '</ul>';
											}
									 } else if((string)$answer_type == 'one-word-answer'){?>
											<ul class="check-box">
												  <li class="to-label">
													<input type="text" class="small" name="question_<?php echo esc_attr( $question_id );?>" />
												</li>
											</ul>
									 <?php } else if($answer_type == 'large-text'){?>
											<ul class="check-box">
												  <li class="to-label">
													<textarea name="question_<?php echo esc_attr( $question_id );?>" rows="5" cols="30"></textarea>
												</li>
											</ul>
									<?php } else if((string)$answer_type == 'true-false'){?>
											<ul class="check-box">
												<li class="to-label">
													<div class="radio-option">
														<input type="radio" class="radioBtnClass" value="correct"  name="question_<?php echo esc_attr( $question_id );?>"/><label></label>
													</div>
													<?php _e('True','EDULMS');?>
												</li>
												<li class="to-label">
													<div class="radio-option">
														<input type="radio" class="radioBtnClass" value="wrong" name="question_<?php echo esc_attr( $question_id );?>" />
														<label></label>
														<?php _e('False','EDULMS');?>
													</div>
												</li>
											</ul>
									<?php }?>
								   <input type="button" name="submit_quiz" value="Next"   onclick="cs_single_free_quiz_submission('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js( $counter );?>','<?php echo esc_js( $total_questions );?>','<?php echo esc_js( $question_id );?>');"  />
								</div>
							<?php
						}
					}
					$quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt']['quiz_attempte_loaded'] = 'loaded';
					set_transient( "cs_course_quiz".$course_ID.$post->ID, $quiz_answer_array );
					//update_user_meta($user_id,'cs-quiz-nswers',$quiz_answer_array);
				   ?> 
				   <input type="hidden" name="total_marks" value="<?php echo absint($total_marks);?>" />
				   <input type="hidden" name="submit_quiz" value="Submit"  />
				  </form>
				  </div>
	   <?php } else {?>
			<h2><?php _e('You get all your attempts of quiz.','EDULMS');?></h2>
	<?php 
	}
} else {
		$transaction_id = get_transient( "cs_course_quiz_rand_id".$course_ID.$post->ID );
		$quiz_answer_array = get_transient( "cs_course_quiz".$course_ID.$post->ID );
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
							  $('#toggle-<?php echo esc_attr( $counter_courses );?>').click(function() {
								  $('#toggle-div-<?php echo esc_attr( $counter_courses );?>').slideToggle('slow', function() {});
							  });
						  });
						</script>
						
							<ul class="bottom-sec">
								<li><?php echo esc_attr( $course_title.' - '.$user_quiz_info['title'] );?></li>
								<li><?php echo esc_attr( $attempt_date );?></li>
								<li><?php echo esc_attr( $attempt_questions.'/'.$total_questions );?></li>
								 <li><?php echo esc_attr( $user_points.'/'.$question_marks_points );?></li>
								  <li><?php echo esc_attr( $result_percentage );?></li>
								   <li><?php echo esc_attr( $resutl_remarks );?></li>
								<li><a href="#" id="toggle-<?php echo esc_attr( $counter_courses );?>" ><i class="fa fa-plus"></i></a></li>
							</ul>
							<div class="toggle-sec">
								<!--Quiz Questions listing-->
								<div class="toggle-div" id="toggle-div-<?php echo esc_attr( $counter_courses );?>">
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
										  <li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"> <a onclick="cs_quiz_result_show_pagination('<?php echo esc_js( $counter_rand_no );?>','<?php echo esc_js( $counter_rand_no_j );?>',<?php echo esc_js( $counter_rand_no+$total_questions );?>, <?php echo esc_js($j);?>)"><?php echo intval( $j );?></a> </li>
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
										<div class="question-number question-<?php echo esc_attr( $counter_rand_no_k );?>" <?php echo esc_attr( $style_class );?>>
										  <h5 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr( $question_title );?></h5>
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
											  <input id="checkbox1" type="checkbox" <?php echo esc_attr( $checked_value );?> disabled="disabled" />
											  <label for="checkbox1" class="<?php echo esc_attr( $checkbox_class );?>"><?php echo esc_attr( $answeroption_value );?></label>
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
                                                    <textarea><?php echo esc_textarea( $user_answer );?></textarea>
                                                    <h6><?php _e('Remarks','EDULMS');?></h6>
                                                    <textarea class="bg-textarea"><?php echo esc_textarea( $answer_large_text );?></textarea>
                                                  </div>
										  <?php }?>
										  <div class="score-sec">
											<ul class="left-sec">
											  <li>
												<label><?php _e('Score','EDULMS');?></label>
												<!--  <input type="text" placeholder="0" />--> 
												<span><?php echo esc_attr( $user_question_point.'/'.$question_marks );?></span> 
												<!--<a href="#">update</a>--> 
											  </li>
											</ul>
											<ul class="right-sec <?php echo esc_attr( $question_grade );?>-click-icon">
											  <li>
												<?php if($question_grade == 'right')
														echo __( 'Correct', 'EDULMS' );
													  else if($question_grade == 'wrong')
														echo __( 'Wrong', 'EDULMS' );
													  else 
														echo __( 'Chosen', 'EDULMS' );
												 ?>
											  </li>
											</ul>
										  </div>
										</div>
										<?php
												}
											
											} else {
												echo __('There are no questions against this quiz', 'EDULMS' );	
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
			echo __( 'There are no records avaialble', 'EDULMS' );	
		}
	}