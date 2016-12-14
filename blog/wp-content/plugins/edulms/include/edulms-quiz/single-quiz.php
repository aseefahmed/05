<?php
/**
 * The template for displaying all Course related Quiz
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $post,$course_ID, $cs_xmlObject;
	$plugin_url = plugin_dir_url( __FILE__ );
	$cs_node = new stdClass();
  	get_header();
	$user_id = cs_get_user_id();
	if (have_posts()):
		while (have_posts()) : the_post();	
		$post_xml = get_post_meta($post->ID, "cs_quiz", true);	
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
		}else{
			$cs_layout = "col-md-12";
		}
		$cs_layout = "content-right col-md-9";
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
			$quiz_duration = $cs_xmlObject->quiz_duration;
			if(empty($quiz_duration) || $quiz_duration == '00' || $quiz_duration == '00:00')
			{
				$quiz_duration = '12:00';
			}
			$quiz_duration = explode(':',$quiz_duration);
			$time_hour = $quiz_duration['0']*60;
			$quiz_duration_minutes = $time_hour+$quiz_duration['1'];
			$quiz_message = $cs_xmlObject->quiz_message;
			$quiz_auto_results = (string)$cs_xmlObject->quiz_auto_results;
			$total_questions = $quiz_question_show = (int)$cs_xmlObject->quiz_question_show;
			$width = 980;
			$height = 408;
			$image_url = cs_get_post_img_src($post->ID, $width, $height);
		} else {
			$cs_xmlObject = new stdClass();
			$quiz_duration = '';
			$quiz_auto_results = '';
			$quiz_message = '';
		}
		$attempt = 1;
		$var_cp_course_paid = '';
		$var_cp_course_product = '';
 		$transaction_id = '';
		$var_cp_course_quiz_type = '';
		$quiz_retakes_no = '1';
		$quiz_passing_marks = '30';
		if(isset($_REQUEST['course_id']) && $_REQUEST['course_id'] <> ''){
			$course_id = $course_ID = $_REQUEST['course_id'];
			$user_right = cs_check_user_right($course_ID);
			$course_user_meta_array = get_option($user_id."_cs_course_data", true);
			if(isset($course_user_meta_array[$course_id])){
				$transaction_id = $course_user_meta_array[$course_id]['transaction_id'];
				if(isset($transaction_id)){
					$user_course_data = get_option($course_ID."_cs_user_course_data", true);
					if(isset($course_user_meta_array[$course_ID]) && is_array($course_user_meta_array[$course_ID]) && is_array($course_user_meta_array[$course_ID]['transaction_id']) && $course_user_meta_array[$course_ID]['transaction_id'])
					$transaction_id = $course_user_meta_array[$course_ID]['transaction_id'];
				}
			}
			$course_xml = get_post_meta($course_ID, "cs_course", true);
			if ( $course_xml <> "" ) {
				$cs_course_xmlObject = new SimpleXMLElement($course_xml);
				if ( empty($cs_course_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_course_xmlObject->var_cp_course_paid;
			
				$var_cp_course_product = $cs_course_xmlObject->var_cp_course_product;
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

		if(!isset($_REQUEST['start_test']) || empty($_REQUEST['start_test'])){
			if(isset($var_cp_course_paid) && $var_cp_course_paid == 'registered_user_access' ){
				$transaction_id = $course_ID;
			}
			$quiz_allowed_attempt = 1;	
			$quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$post->ID;
			$quiz_allowed_attempt = $attempt = get_option($quiz_complete_key);
			if(!isset($quiz_allowed_attempt)){
				$quiz_allowed_attempt = 1;
			} else if(isset($quiz_allowed_attempt) && $quiz_allowed_attempt == ''){
				$quiz_allowed_attempt = 1;
			}
			echo '<section >';
					echo '<div class="container">';
						echo '<div class="row">';
							echo '<div class="col-md-12">';
								echo '<div class="cs-quiz-start">';
									if(isset($var_cp_course_paid) && $var_cp_course_paid == 'registered_user_access' ){
										$quiz_allowed_attempt = 1;	
										$quiz_complete_key = cs_get_user_id().'_'.$course_ID.'_'.$post->ID;
										$quiz_allowed_attempt = get_option($quiz_complete_key);
										
										if(!isset($quiz_allowed_attempt)){
											$quiz_allowed_attempt = 1;
										} else if(isset($quiz_allowed_attempt) && $quiz_allowed_attempt == ''){
											$quiz_allowed_attempt = 1;
										}
										if(is_user_logged_in()){
											$array_params = array( 'course_id' => $course_ID, 'start_test' => 'start' );
											$quiz_permalink = add_query_arg( $array_params, get_permalink());
											echo '<a href="'.$quiz_permalink.'" class="custom-btn circle cs-bg-color ">Start Test</a><br /><br />';
										} else {
											$array_params = array( 'course_id' => $course_ID, 'start_test' => 'start' );
											$quiz_permalink = add_query_arg( 'course_id', $course_ID, get_permalink() );
											echo __('You need to login for this quiz. ','EDULMS');
											echo '<a href="'. wp_login_url( $quiz_permalink ).'" title="Login" class="custom-btn circle cs-bg-color">'.__('Login','EDULMS').'</a><br /><br />';
											//echo '<a href="'.$quiz_permalink.'" class="custom-btn circle cs-bg-color">Start Test</a><br /><br />';
										}
									} else {
										$array_params = array( 'course_id' => $course_ID, 'start_test' => 'start' );
										$quiz_permalink = add_query_arg( $array_params, get_permalink());
										echo '<a href="'.$quiz_permalink.'" class="custom-btn circle cs-bg-color ">Start Test</a><br /><br />';
									}
									$quiz_allowed_attempt_no = $quiz_allowed_attempt-1;
									echo '<h2>'.__('Quiz Detail', 'EDULMS').'</h2>';
									echo '<div class="quiz-instructions">';
										echo '<span>'.__('Quiz Name:', 'EDULMS').' '.get_the_title().'</span>';			
										echo '<span>'.__('Time Allowed:', 'EDULMS').' '.$quiz_duration_minutes.' '.__('Minutes', 'EDULMS').'</span>';	
										echo '<span>'.__('Attempts: Allowed', 'EDULMS').' '.$quiz_retakes_no.'  '.__('Completed ', 'EDULMS').$quiz_allowed_attempt_no.'</span>';					
									echo '</div>';
									echo '<h2>'.__('Instructions', 'EDULMS').'</h2>';
									echo '<p>'.$quiz_message.'</p>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';					
				echo '</section>';
		} else {
			
		?>
			<!-- Columns Start -->
			<div class="clear"></div>
			<!-- Content Section Start -->
			<div id="main" role="main">	
			<!-- Container Start -->
				<div class="container">
				<!-- Row Start -->
					<div class="row">
					<!-- Blog Detail Start -->
					<div class="<?php echo esc_attr($cs_layout); ?>">
						<?php
                        if(isset($_REQUEST['start_test']) && isset($var_cp_course_paid) && ($var_cp_course_paid == 'free' || $var_cp_course_paid == 'registered_user_access')){
                            if(is_user_logged_in()){
								$quiz_allowed_attempt = 1;	
								$quiz_complete_key = cs_get_user_id().'_'.$course_ID.'_'.$post->ID;
								$quiz_allowed_attempt = $attempt = get_option($quiz_complete_key);
								if(!isset($quiz_allowed_attempt)){
									$quiz_allowed_attempt = 1;
								} else if(isset($quiz_allowed_attempt) && $quiz_allowed_attempt == ''){
									$quiz_allowed_attempt = 1;
								}
                                echo '<section >';
                                    echo '<div class="container">';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-12">';
                                                include_once( 'quiz_with-login.php');
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';					
                                echo '</section>';
                            } else {
                                $quiz_permalink = add_query_arg( 'course_id', $course_ID, get_permalink() );
                                echo '<section >';
                                    echo '<div class="container">';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-9">';
                                                echo __('You need to login for this quiz. ','EDULMS');
                                                echo '<a href="'. wp_login_url( $quiz_permalink ).'" title="Login">'.__('Login','EDULMS').'</a>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';					
                                echo '</section>';
                                
                            }
                        } else if(isset($_REQUEST['start_test']) && ($var_cp_course_paid <> 'registered_user_access')) {
                            if(isset($_POST['submit_quiz']) && $_POST['submit_quiz'] <> '' && $_POST['post_id']<>'' && isset($var_cp_course_paid) && $var_cp_course_paid <> 'registered_user_access'){
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
                                        $quiz_complete_key = cs_get_user_id().'_'.$post_id;
                                        $quiz_complete = get_option($quiz_complete_key);
                                        if(!isset($quiz_complete)){
                                            $quiz_complete = 1;
                                        }
                                        $question_no = "question_$i";
                                        $total_marks = $_POST['total_marks'];
                                        $question_answer = $_POST[$question_no];
                                        $question_no_array = array();
                                        $question_no_array = $user_quiz_questions_data[$i];
                                        $question_answer = implode("||",$question_answer);
                                        $question_no_array['user_answer'] = $question_answer;
                                        $question_point = 0;
                                        if($user_quiz_questions_data[$i]['answer_title_multiple_option_correct'] == $question_answer){
                                            $question_point = $user_quiz_questions_data[$i]['question_marks'];
                                        }
                                        $question_no_array['user_question_point'] = $question_point;
                                        $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'][$i] = $question_no_array;
                                    }
                                }
                                    /* Quiz Information Array */
                                    $post_xml = get_post_meta($post_id, "cs_quiz", true);	
                                    if ( $post_xml <> "" ) {
                                        $cs_xmlObject = new SimpleXMLElement($post_xml);
                                        $quiz_auto_results = (string)$cs_xmlObject->quiz_auto_results;
                                        $quiz_question_show = (int)$cs_xmlObject->quiz_question_show;
                                        $total_question = count($cs_xmlObject->question);
                                        if($quiz_question_show>$total_question){
                                            $total_questions = $total_question;
                                        } 
                                        if(!is_array($quiz_answer_array[$transaction_id][$post_id][$quiz_complete])){
                                            $quiz_answer_array[$transaction_id][$post_id][$quiz_complete] = array();
                                        }
                                        if (!array_key_exists("quiz_information",$quiz_answer_array[$transaction_id][$post_id][$quiz_complete])){
                                            $quiz_information_array = array();
                                            $quiz_information_array['quiz_ID'] = $quiz_id;
                                            $quiz_information_array['transaction_id'] = $transaction_id;
                                            $quiz_information_array['quiz_question_show'] = (int)$quiz_question_show;
                                            $quiz_information_array['title'] = get_the_title($quiz_id);
                                            $quiz_information_array['quiz_description'] = (string)$cs_xmlObject->quiz_message;
                                            $quiz_information_array['quiz_type'] = (string)$var_cp_course_quiz_type;
                                            $quiz_information_array['quiz_retakes_no'] = (string)$quiz_retakes_no;
                                            $quiz_information_array['quiz_passing_marks'] = (string)$quiz_passing_marks;
                                            $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'] = $quiz_information_array;
                                        }
                                    }
                                    /* Course Information */
                                    $course_id = $_POST['course_id'];
                                    if(isset($course_id) && $course_id <> ''){
                                        $course_information_array = array();
                                        $course_information_array['course_id'] = $course_id;
                                        $course_information_array['course_title'] = get_the_title($course_id);
                                        $cs_course = get_post_meta($course_id, "cs_course", true);
                                        if ( $cs_course <> "" ) {
                                            $course_xmlObject = new SimpleXMLElement($cs_course);
                                            if ( empty($course_xmlObject->course_id) ) $course_no = ""; else $course_no = $cosurse_xmlObject->course_id;
                                            if ( empty($course_xmlObject->course_pass_marks) ) $course_pass_marks = ""; else $course_pass_marks = (string)$course_xmlObject->course_pass_marks;
                                            if ( empty($course_xmlObject->course_short_description) ) $course_short_description = ""; else $course_short_description = (string)$course_xmlObject->course_short_description;
                                            if ( empty($course_xmlObject->course_duration) ) $course_duration = ""; else $course_duration = (string)$course_xmlObject->course_duration;
                                            $course_information_array['course_no'] = $course_no;
                                            $course_information_array['course_pass_marks'] = $course_pass_marks;
                                            $course_information_array['course_short_description'] = $course_short_description;
                                            $course_information_array['course_duration'] = $course_duration;
                                        }
                                        $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['course_information'] = $course_information_array;
                                    }
                                        $quiz_result_array = array();
                                        $user_marks = '';
                                        $user_quiz_info = $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_information'];
                                        $quiz_auto_results = '';
                                        if(isset($user_quiz_info['quiz_auto_results'])){
                                            $quiz_auto_results = $user_quiz_info['quiz_auto_results'];
                                        }
                                        if(isset($quiz_auto_results) && $quiz_auto_results == 'on' && is_array($quiz_answer_array[$transaction_id][$post_id][$quiz_complete])  && count($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'])>0){
                                            $user_marks = 0;
                                            foreach($quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['questions'] as $question_keys=>$question_values){
                                                if($question_keys){
                                                    if($question_values['answer_title_multiple_option_correct'] == $question_values['user_answer']){
                                                        $user_marks = $user_marks+$question_values['question_marks'];
                                                    }
                                                }
                                            }
                                        }
                                        $quiz_result_array['marks'] = $user_marks;
                                        $quiz_result_array['remarks'] = '';
                                        $quiz_result_array['review_status'] = 'pending';
                                        $quiz_answer_array[$transaction_id][$post_id][$quiz_complete]['quiz_result'] = $quiz_result_array;
                                        $quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempt_no'] = $quiz_complete;
                                        $quiz_answer_array[$transaction_id][$post_id]['quiz_attempt']['quiz_attempte_loaded'] = 'completed';
                                        $quiz_complete++;
                                        update_option($quiz_complete_key, $quiz_complete);
                                        $last_quiz_complete_key = cs_get_user_id().'_'.$post_id.'_last';
                                        update_option($last_quiz_complete_key, 'yes');
                                        update_user_meta($user_id,'cs-quiz-nswers',$quiz_answer_array);
                            }
                        }
                       ?>
							<!-- Blog Start -->
 							<!-- Blog Post Start -->
                            <div class="blog blog_detail">
                                <article>
                                    <div class="detail_text rich_editor_text">
                                        <?php
                                             the_content();
                                             wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'EDULMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                                         ?>
                                    </div>
                               <?php 
                                if(cs_get_user_id() && isset($course_ID)){
                                $quiz_answer_array = array();	
                                //update_user_meta($user_id, 'cs-quiz-nswers', '');
                                $quiz_complete = 1;	
                                $transaction_id = (string)$transaction_id;
                                $quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$post->ID;
                                //$quiz_complete = get_option($quiz_complete_key);
                                $quiz_answer_array = get_user_meta(cs_get_user_id(),'cs-quiz-nswers', true);
                                if(count($quiz_answer_array)<1){
                                    update_option($quiz_complete_key,'1');
                                    
                                }
                                //update_option($quiz_complete_key,'');
                                $quiz_complete = get_option($quiz_complete_key);
                                if(!isset($quiz_complete)){
                                    $quiz_complete = 1;
                                } else if(isset($quiz_complete) && $quiz_complete == ''){
                                    $quiz_complete = 1;
                                }
                                if(isset($quiz_answer_array[(string)$transaction_id][(int)$post->ID]) && count($quiz_answer_array[(string)$transaction_id][(int)$post->ID])<1){
                                    update_option($quiz_complete_key,'');
                                }
                                
                                $quiz_attemp_array = array();
                                $quiz_attemp_array['attempts'] = 1;
                                $quiz_attemp_array['no_of_retakes_allowed'] = (int)$quiz_retakes_no;
                                $quiz_attemp_array['retake'] = '';
                                $quiz_attemp_array['quiz_attempt_no'] = (int)$quiz_complete;
                                $quiz_attemp_array['quiz_attempte_loaded'] = (string)'loaded';
                                $quiz_answer_array[(string)$transaction_id][$post->ID]['quiz_attempt'] = $quiz_attemp_array;
                                 
                                $attempt = (int)$quiz_complete;
                                $no_of_retakes_allowed = (int)$quiz_retakes_no;
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
                                                        <li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>"><a onclick="cs_quiz_pagination('<?php echo esc_js($j);?>',<?php echo esc_js($total_questions);?>)"><?php echo esc_js($j);?></a></li>
                                                        <?php
                                                    }
                                                ?>
                                           </ul>
                                           <div class="loading"></div>
                                           <form id="quiz-form" class="quiz-form" name="quiz-from" method="post">
                                           <input type="hidden" name="action" value="cs_quiz_submit" />
                                           <input type="hidden" name="transaction_id" value="<?php echo esc_attr($transaction_id);?>" />
                                           <input type="hidden" name="post_id" value="<?php echo absint($post->ID);?>" />
                                           <input type="hidden" name="course_id" value="<?php echo absint($course_ID);?>" />
                                           <?php 
                                            if ( $post_xml <> "" ) {
                                                $answer_options_coutner = 0;
                                                $user_quiz_questions_data = get_post_meta($post->ID, "cs_quiz_questions_meta", true);
                                                $quiz_answers = get_user_meta(cs_get_user_id(),'cs-quiz_answers', true);
                                                $counter= 0;
                                                $total_marks = 0;
                                                $array =  cs_ObjecttoArray($cs_xmlObject);
                                                $myarray = $array['question'];
                                               // $questionsarray = cs_shuffle_assoc($myarray);
                                                $questionsarray = $myarray;
                                                $quiz_information_array = array();
                                                $quiz_information_array['quiz_ID'] = $post->ID;
                                                $quiz_information_array['transaction_id'] = $transaction_id;
                                                $quiz_information_array['title'] = get_the_title();
                                                $quiz_information_array['quiz_type'] = (string)$var_cp_course_quiz_type;
                                                $quiz_information_array['quiz_retakes_no'] = (int)$quiz_retakes_no;
                                                $quiz_information_array['quiz_question_show'] = (int)$quiz_question_show;
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
                                                $quiz_result_array['review_status'] = 'pending';
                                                $quiz_result_array['grade'] = '';
                                                $quiz_result_array['marks_percentage'] = '';
                                                $quiz_result_array['remarks'] = '';
                                                $quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['quiz_result'] = (array)$quiz_result_array;
                                                $quiz_answer_array[$transaction_id][$post->ID][$quiz_complete]['questions'] = array();
                                                $button_value = 'Next';
                                                foreach ( $questionsarray as $question_key=>$question ){
                                                    $counter++;
                                                    if($quiz_question_show < $counter){
                                                        break;	
                                                    }
                                                    if($quiz_question_show == $counter){
                                                        $button_value = 'Save';	
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
                                                    if(!isset($answer_type) || trim($answer_type) == '' || empty($answer_type))
                                                        $answer_type = 'multiple-option';
                                                    
                                                    
                                                    ?>
                                                        <input type="hidden" name="question_ids_array[]" value="<?php echo esc_attr($question_id);?>" />
                                                        <div class="question-number question<?php echo absint($counter);?>" <?php echo $style_class;?>>
                                                            <h5 class="result-heading"><?php echo esc_attr($question['question_title']);?></h5>
                                                            <?php if($answer_type == 'single-option'){?>
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
                                                             } else if((string)$answer_type == 'one-word-answer'){?>
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
                                                            <?php } else if((string)$answer_type == 'true-false'){?>
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
                                                           <input type="button" name="submit_quiz" value="<?php echo esc_attr($button_value);?>"   onclick="cs_single_quiz_submission('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter);?>','<?php echo esc_js($total_questions);?>','<?php echo esc_js($question_id);?>', '<?php echo esc_js($counter);?>');"  />
                                                        </div>
                                                    <?php
                                                }
                                            }
                                            $quiz_answer_array[$transaction_id][$post->ID]['quiz_attempt']['quiz_attempte_loaded'] = 'loaded';
                                            update_user_meta($user_id, 'cs-quiz-nswers', $quiz_answer_array);
                                           ?> 
                                           <input type="hidden" name="total_marks" value="<?php echo esc_attr($total_marks);?>" />
                                           <input type="hidden" name="submit_quiz" value="Submit"  />
                                          </form>
                                          </div>
                               <?php }
                                else {?>
                                    <h2><?php _e('You get all your attempts of quiz.','EDULMS');?></h2>
                                <?php 
                                }
                            } else if(cs_get_user_id() && !isset($course_ID)  && $course_ID <> ''){
                             ?>
                                <h2><?php _e('You can take quiz from Course page','EDULMS');?></h2>
                             <?php
                            } else {
                               ?>
                                <h2><?php _e('Please Subscribe to Course for Quiz','EDULMS');?></h2>
                          <?php }?>
                          </article>
                            <!-- Post tags Section -->
                     <!-- Blog Post End -->
                     </div>
			<?php }?>
	<!--Content Area End-->
	<!--Right Sidebar Starts-->
    	</div>
    	<div class="col-lg-3 col-md-3 col-sm-3">
		<?php 
		if(isset($no_of_retakes_allowed) && $no_of_retakes_allowed >= $attempt){?>
                 <div class="ans-section">
                    <div class="cs-top-sec">
                        <time><?php _e('Time Left','EDULMS');?></time>
                        <script type="text/javascript">	
							jQuery(document).ready(function($) {
								var timeLeft = <?php echo esc_js($quiz_duration_minutes)*60;?>; // 5 minutes
								var timer = window.setInterval(function() {
									timeLeft--;
									var minutesLeft = Math.floor(timeLeft / 60);
									var secondsLeft = timeLeft % 60;
									console.log('Time left: ' + minutesLeft + ':' + secondsLeft);
									jQuery(".cs-time-interval").html( minutesLeft + ':' + secondsLeft);
										if (timeLeft == 0) {
											window.clearInterval(timer);
											var form_length = jQuery("#quiz-form").length;
											if(form_length){
												jQuery.ajax({
													type:"POST",
													url: '<?php echo esc_js(admin_url('admin-ajax.php'));?>',
														data:jQuery('#quiz-form').serialize(), 
														success:function(response){
															jQuery("#quiz").html(response);
															jQuery(".ans-section").hide();
														}
												});
											}
									}
								}, 1000);
								 function finishpage()
								{
									document.quiz-from.submit();
								}
								window.onbeforeunload= function() {
									setTimeout('document.quiz-from.submit()',1);
								}
							});	
						</script>
                        <div class="cs-time-interval"></div>
                        <div class="submit-progress"></div>
                        <?php
						if(isset($_REQUEST['start_test']) && ($var_cp_course_paid == 'registered_user_access')) {
						?>
                        <input type="button" name="submit_quiz" value="Submit"   onclick="cs_registereduser_quiz_submission('<?php echo esc_js(admin_url('admin-ajax.php'));?>');"  />
						<?php	
						} else {
						?>
                        	<input type="button" name="submit_quiz" value="Submit"   onclick="cs_quiz_submission('<?php echo esc_js(admin_url('admin-ajax.php'));?>');"  />
                        <?php
						}
						?>
                    </div>
                    <div class="cs-bottom-section">
                     	<p><?php if(isset($cs_xmlObject))echo esc_attr($total_questions);?> <?php _e('Question','EDULMS');?></p>
                    </div>
                </div>
        <?php }?>
         <div class="courses courselisting">
         	<div class="clear"></div>
			  <?php 
				  if(isset($course_ID) && $course_ID <> ''){
						$var_cp_course_instructor =  get_post_meta( $course_ID, 'var_cp_course_instructor', true);
						$cs_user_data = get_userdata((int)$var_cp_course_instructor);
						if(!isset($user_course_data)) $user_course_data = '';
						/* Course Detail Information */
						cs_course_detail_info_widget($course_ID,$user_course_data,$var_cp_course_product,$var_cp_course_paid);
						/* Course  Instructor Information */
						if($cs_user_data <> ''){ 
							cs_course_instructor_widget($course_ID,$cs_user_data);
						}
						/* Course Recent Views */
						cs_course_recent_reviews_widget($course_ID);
				  }
               ?>
        </div>
        <?php
	}
	endwhile;   endif;
	?>
<!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>