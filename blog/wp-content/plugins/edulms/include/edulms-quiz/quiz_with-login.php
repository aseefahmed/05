<?php
/**
 * Free Quiz without login
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 global $post,$course_ID, $cs_xmlObject;
 	if(isset($cs_xmlObject->quiz_question_show))
 		$quiz_question_show = $cs_xmlObject->quiz_question_show;
	if(isset($cs_xmlObject->quiz_auto_results))
 		$quiz_auto_results = $cs_xmlObject->quiz_auto_results;
	$user_id = cs_get_user_id();	
	$quiz_answer_array = array();
	$transaction_id = cs_getIp();
	if(empty($transaction_id))
		$transaction_id = rand(85,999);
	$transaction_id = $course_ID;
	$user_id = cs_get_user_id();
	$quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-registered-free-quiz-answers', true);
	$quiz_complete = 1;
	$quiz_complete_key = $user_id.'_'.$course_ID.'_'.$post->ID;
	$quiz_complete = get_option($quiz_complete_key);
	if(!isset($quiz_complete)){
		$quiz_complete = 1;
	} else if(isset($quiz_complete) && $quiz_complete == ''){
		$quiz_complete = 1;
	}
	$quiz_answer_array[$transaction_id][$post->ID][$quiz_complete] = array();
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
	if(isset($quiz_answer_array[$transaction_id][$post->ID]) && count($quiz_answer_array[$transaction_id][$post->ID])<2)
		update_option($quiz_complete_key,'');
	$quiz_attemp_array = array();
	$quiz_attemp_array['attempts'] = 1;
	$quiz_attemp_array['no_of_retakes_allowed'] = (int)$quiz_retakes_no;
	$quiz_attemp_array['retake'] = '';
	$quiz_attemp_array['quiz_attempt_no'] = (int)$quiz_complete;
	$quiz_attemp_array['quiz_attempte_loaded'] = (string)'loaded';
	$quiz_answer_array[(string)$transaction_id][$post->ID]['quiz_attempt'] = $quiz_attemp_array;		
	
	$attempt = $quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt']['quiz_attempt_no'];
	$no_of_retakes_allowed = $quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt']['no_of_retakes_allowed'];
	if(isset($_REQUEST['retake_quiz']) && $_REQUEST['retake_quiz'] == 1){
		
	}
	if($no_of_retakes_allowed >= $attempt){
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
								$active_class = '';
								if($j==1){$active_class = 'active';}
								?>
								<li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"><a onclick="cs_quiz_pagination('<?php echo esc_js($j);?>',<?php echo esc_js($total_questions);?>)"><?php echo absint($j);?></a></li>
								<?php
							}
						?>
						
				   </ul>
				   <div class="loading"></div>
				   <form id="quiz-form" name="quiz-from" method="post">
				   <input type="hidden" name="action" value="cs_registereduser_quiz_submit" />
				   <input type="hidden" name="transaction_id" value="<?php echo esc_attr($transaction_id);?>" />
				   <input type="hidden" name="post_id" value="<?php echo absint($post->ID);?>" />
                   <input type="hidden" name="user_id" value="<?php echo absint($user_id);?>" />
				   <input type="hidden" name="course_id" value="<?php echo absint($course_ID);?>" />
				   <?php 
					if ( isset($cs_xmlObject) ) {
						$user_quiz_questions_data = get_post_meta($post->ID, "cs_quiz_questions_meta", true);
						$counter= 0;
						$total_marks = 0;
						$answer_options_coutner = 0;
						$array =  cs_ObjecttoArray($cs_xmlObject);
						$myarray = $array['question'];
						//$questionsarray = cs_shuffle_assoc($myarray);
						$questionsarray = $myarray;
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
								<input type="hidden" name="question_ids_array[]" value="<?php echo esc_attr($question_id);?>" />
								<div class="question-number question<?php echo absint($counter);?>" <?php echo ''.$style_class;?>>
									<h5 class="result-heading"><?php echo esc_attr($question['question_title']);?>	<i class="fa fa-question-circle"></i></h5>
									<?php 
									if($answer_type == 'single-option'){?>
										<ul class="check-box">
											<li class="to-label">
												<input type="checkbox" name="question_<?php echo esc_attr($question_id);?>[]" />
											</li>
											<li class="to-label">
												<?php echo esc_attr($question['answer_title_single_option_1']);?>
											</li>
										</ul>
										<ul class="check-box">
											<li class="to-label">
												<input type="checkbox" name="question_<?php echo esc_attr($question_id);?>[]" />
											</li>
											<li class="to-label">
												<?php echo esc_attr($question['answer_title_single_option_2']);?>
											</li>
										</ul>
									<?php } else if($answer_type == 'multiple-option'){
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
                                                                <div class="<?php echo esc_attr($input_type);?>">
                                                                    <input type="<?php echo esc_attr($input_type);?>" value="<?php echo esc_attr($option_no);?>" name="question_<?php echo esc_attr($question_id);?>[]" id="checkbox<?php echo esc_attr($answer_options_coutner);?>" />
                                                                   <label for="checkbox<?php echo esc_attr($answer_options_coutner);?>"><?php echo esc_attr($multipleoptions_title);?></label>
                                                                  </div>
                                                            </li>
														<?php
														$option_no++;
													}
												}
												echo '</ul>';
											}
									 } else if($answer_type == 'one-word-answer'){?>
											<ul class="check-box">
												  <li class="to-label">
													<input type="text" class="small" name="question_<?php echo esc_attr($question_id);?>" />
												</li>
											</ul>
									 <?php } else if($answer_type == 'large-text'){?>
											<ul class="check-box">
												  <li class="to-label">
													<textarea name="question_<?php echo esc_attr($question_id);?>" rows="5" cols="30"></textarea>
												</li>
											</ul>
									<?php } else if($answer_type == 'true-false'){?>
											<ul class="check-box">
												<li class="to-label">
													<div class="radio-option">
														<input type="radio" class="radioBtnClass" value="correct"  name="question_<?php echo esc_attr($question_id);?>"/><label></label>
													</div>
													<?php _e('True','EDULMS');?>
												</li>
												<li class="to-label">
													<div class="radio-option">
														<input type="radio" class="radioBtnClass" value="wrong" name="question_<?php echo esc_attr($question_id);?>" />
														<label></label>
														<?php _e('False','EDULMS');?>
													</div>
												</li>
											</ul>
									<?php }?>
								   <input type="button" name="submit_quiz" value="Next"   onclick="cs_single_registered_user_quiz_submission('<?php echo esc_js(admin_url('admin-ajax.php'))?>','<?php echo esc_js($counter);?>','<?php echo esc_js($total_questions);?>','<?php echo esc_js($question_id);?>', '<?php echo esc_js($counter);?>');"  />
								</div>
							<?php
						}
					}
					$quiz_answer_array[(string)$transaction_id][(int)$post->ID]['quiz_attempt']['quiz_attempte_loaded'] = 'loaded';
					update_user_meta($user_id, 'cs-registered-free-quiz-answers', $quiz_answer_array);
				   ?> 
				   <input type="hidden" name="total_marks" value="<?php echo esc_attr($total_marks);?>" />
				   <input type="hidden" name="submit_quiz" value="Submit"  />
				  </form>
				  </div>
	   <?php } else {?>
			<h2><?php _e('You get all your attempts of quiz.','EDULMS');?></h2>
	  <?php 
		}