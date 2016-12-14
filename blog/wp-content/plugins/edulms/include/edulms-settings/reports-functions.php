<?php
/**
 * Assignments Reports
 */ 
if ( ! function_exists( 'cs_assignment_reports' ) ) {
	function cs_assignment_reports(){
		$url = admin_url('edit.php?post_type=courses&page=quiz_assignments_listing_page&action=assignment-listing');
		if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by'] <> ''){
			$sort_by = $_REQUEST['sort_by'];
		} else {
			$sort_by = 'all';
		}
		$all_assignment = $Pass_assignment = $Fail_assignment = $Pending_assignment = $Remaining_assignment = 0;
		$assignment_listing_count = cs_count_assignment_listing_status();
		if(isset($assignment_listing_count['all']))
			$all_assignment = $assignment_listing_count['all'];
		if(isset($assignment_listing_count['Pass']))
			$Pass_assignment = $assignment_listing_count['Pass'];
		if(isset($assignment_listing_count['Fail']))
			$Fail_assignment = $assignment_listing_count['Fail'];
		if(isset($assignment_listing_count['Pending']))
			$Pending_assignment = $assignment_listing_count['Pending'];
		if(isset($assignment_listing_count['Remaining']))
			$Remaining_assignment = $assignment_listing_count['Remaining'];
		?> 
		<div id="settings">
				<div class="tab-title"><h3><?php _e('Assignments Results','EDULMS');?></h3></div>
				  <label> 
					<select name="cs_statement_start_date" id="cs_statement_start_date" aria-controls="revenue" onchange="cs_user_statements_date_value(this.value,'<?php echo esc_js($url);?>')">
						<option value="all" <?php if($sort_by == 'all'){echo 'selected';}?>><?php _e('All','EDULMS');?> (<?php echo esc_attr($all_assignment);?>)</option>
						<option value="Pass" <?php if($sort_by == 'Pass') echo 'selected';?>><?php _e('Pass','EDULMS');?> (<?php echo esc_attr($Pass_assignment);?>)</option>
						<option value="Fail" <?php if($sort_by == 'Fail') echo 'selected';?>><?php _e('Fail','EDULMS');?> (<?php echo esc_attr($Fail_assignment);?>)</option>
						<option value="Pending" <?php if($sort_by == 'Pending') echo 'selected';?>><?php _e('Pending','EDULMS');?> (<?php echo esc_attr($Pending_assignment);?>)</option>
						<option value="Remaining" <?php if($sort_by == 'Remaining') echo 'selected';?>><?php _e('Remaining','EDULMS');?> (<?php echo esc_attr($Remaining_assignment);?>)</option>
					</select>
				  </label>
					<?php 
						$user_course_ids_data = array();
						$cs_course_register_option = array();
						$cs_course_register_option = get_option("cs_course_register_option", true);
						if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
							$cs_course_register_option = array();	
						}
						if(isset($cs_course_register_option['cs_user_ids_option']))
							$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
						if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
							?>
							<div class="my-courses">
								<table id="report" class="display" cellspacing="0" width="100%">
								<tr>
									<th><?php _e('Assignment Name','EDULMS');?></th>
									<th><?php _e('Submission','EDULMS');?></th>
									<th><?php _e('Username','EDULMS');?></th>
									<th><?php _e('Email','EDULMS');?></th>
									<th><?php _e('Instructor Name','EDULMS');?></th>
									<th><?php _e('ip Address','EDULMS');?></th>
									<th><?php _e('Required','EDULMS');?>%</th>
									<th><?php _e('Marks','EDULMS');?></th>
									<th><?php _e('Score','EDULMS');?></th>
									<th><?php _e('Review Status','EDULMS');?></th>
									<th><?php _e('Attempts','EDULMS');?></th>
									<th></th>
								</tr>
									<?php
									foreach ($user_course_ids_data as $user_key=>$user_login) {
										if(!isset($user_key))
											continue;
										$user_id  = $user_key;
										$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
										$counter_assignments = 900;
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
															$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
															$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
															$assignment_complete = get_option($assignment_complete_key);
															if(!isset($assignment_complete)){
																$assignment_complete = 1;
															} else if(isset($assignment_complete) && $assignment_complete == ''){
																$assignment_complete = 1;
															}
															$attempt_no = $assignment_complete-1;
															
															   $user_assignment_info = array(); 
																if(isset($assignment_array['course_assignment_info']))
																	$user_assignment_info = $assignment_array['course_assignment_info'];
																$assignments_title = $user_assignment_info['assignments_title'];
																$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
																$course_type = '';
																if(isset($user_assignment_info['course_type']))
																	$course_type = $user_assignment_info['course_type'];
																if($course_type == 'registered_user_access'){
																	$course_type = ' (Free Assignment)';
																}
																$assignment_total_marks = $user_assignment_info['assignment_total_marks'];
																if(empty($assignment_total_marks))
																	$assignment_total_marks = 100;
																$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
																if(isset($user_assignment_info['course_instructor']))
																	$course_instructor = $user_assignment_info['course_instructor'];
																else 
																	$course_instructor = '';
															for($attempt_no=1; $attempt_no<$assignment_attempt_no; $attempt_no++){
																
																if(isset($assignment_array[$attempt_no]) && is_array($assignment_array[$attempt_no])){
																		$user_assignment_data = array(); 
																		if(isset($assignment_array[$attempt_no]['assignment_data']))
																			$user_assignment_data = $assignment_array[$attempt_no]['assignment_data'];
																		$user_assignments_title = '';
																		if(isset($user_assignment_data['user_assignments_title']))
																			$user_assignments_title = $user_assignment_data['user_assignments_title'];
																		$review_status = 'Pending';
																		if(isset($user_assignment_data['review_status']))
																			$review_status = $user_assignment_data['review_status'];	
																		if($sort_by <> 'all' && $review_status <> $sort_by){
																			continue;
																		}		
																		$attempt_date = $user_assignment_data['attempt_date'];
																		$review_status = 'Pending';
																		if(isset($user_assignment_data['review_status']) && $user_assignment_data['review_status'] <> '')
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
																		if($assignment_marks == '')
																			$assignment_marks = '-';
																			
																			
																			$counter_assignments++;
																			$counter_assignments = $counter_assignments.rand(1,9999);
																			?>
																			<tr id="assignment-row-<?php echo esc_attr($counter_assignments);?>">
																				<td><?php 
																				if(isset($user_assignment_info['assignments_title'])) echo esc_attr($user_assignment_info['assignments_title']);
																				if(isset($user_assignments_title) && $user_assignments_title <> '') echo ' ( '.esc_attr($user_assignments_title).' )';
																				if(isset($course_type) && $course_type <> '') echo esc_attr($course_type);
																				?></td>
																				<td><?php if(isset($attempt_date)) echo esc_attr($attempt_date);?></td>
																				<td><a href="<?php echo get_edit_user_link($user_key);?>" target="_blank"><?php if(isset($user_login)) echo esc_attr($user_login);?></a></td>
																				<td><?php if(isset($user_email) && !empty($user_email)) echo esc_attr($user_email); else echo '--';?></td>
																				<td><?php if(isset($course_instructor) && !empty($course_instructor)) echo esc_attr($course_instructor); else echo '--';?></td>
																				<td><?php if(isset($ip_address)) echo esc_attr($ip_address);?></td>
																				<td><?php if(isset($assignment_passing_marks)) echo esc_attr($assignment_passing_marks);?>%</td>
																				<td><?php if(isset($question_marks_points) && isset($assignment_marks)) echo esc_attr($assignment_marks).'/'.esc_attr($question_marks_points);?></td>
																				<td><?php if(isset($result_percentage)) echo esc_attr($result_percentage);?>%</td>
																				<td><?php if(isset($review_status)) echo esc_attr($review_status);?></td>
																				<td><?php echo esc_attr($attempt_no).'/'.esc_attr($assignment_retakes_no);?></td>
																				<td>
																					<script>
																					  jQuery(document).ready(function($){
																						  $('#toggle-<?php echo esc_js($counter_assignments);?>').click(function() {
																							  if ($('#toggle-div-<?php echo esc_js($counter_assignments);?>').hasClass('cs-click')){
																								$('#toggle-div-<?php echo esc_js($counter_assignments);?>').slideToggle(200);
																							  }
																						  });
																					  });
																					</script>
																					<a href="#" id="toggle-<?php echo esc_attr($counter_assignments);?>" onclick="cs_user_assignment_record('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_assignments);?>')"><i class="fa fa-plus"></i></a>
																					<a href="#" id="toggle-<?php echo esc_attr($counter_assignments);?>" onclick="cs_user_assignment_record_del('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_assignments);?>')"><i class="fa fa-trash-o"></i></a>
																				</td>
																			</tr>
																			<tr class="toggle-static-class toggle-div-class-<?php echo esc_attr($counter_assignments);?>" id="toggle-div-<?php echo esc_attr($counter_assignments);?>">
																				<td colspan="12">
																				   <div class="toggle-sec">
																						<!--Quiz Questions listing-->
																						<div id="toggle-div-data-<?php echo esc_attr($counter_assignments);?>"></div>
																					</div>
																				</td>
																			</tr>
																			<?php
																}
														}
													}
												}
											}
									}	
								}
								?>
								</table>
							</div>
							<?php 
						}
						?>
			</div>
		<?php
	}
	add_action('cs_assignment_listing_report','cs_assignment_reports');
}
/**
 * Assignment Delete
 */
if ( ! function_exists( 'cs_admin_user_assignment_record_del_ajax' ) ) {
	function cs_admin_user_assignment_record_del_ajax() {
		$transaction_id = $assignment_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['assignment_id']))  $assignment_id = $_POST['assignment_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_assingments_array = array();
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		if(isset($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]) && is_array($user_assingments_array[$transaction_id][$assignment_id][$attempt_no])){
			$user_assingments_array_index = $user_assingments_array[$transaction_id][$assignment_id][$attempt_no];
			$user_assignment_data = $user_assingments_array_index['assignment_data'];
			$assignment_upload_attachment = $user_assignment_data['assignment_upload_attachment'];
			$assignment_upload_path = $user_assignment_data['assignment_upload_path'];
			if (file_exists($assignment_upload_path)) {
				@unlink($assignment_upload_path);	
			}
			unset($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]);
		}
		update_user_meta($user_id, "cs-user-assignments", $user_assingments_array);
		if(isset($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]) && is_array($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]) && count($user_assingments_array[$transaction_id][$assignment_id][$attempt_no])<0){
			$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
			delete_option($assignment_complete_key);
		}
		echo __('Assignment Record Deleted', 'EDULMS');
		exit;
	}
	add_action('wp_ajax_cs_admin_user_assignment_record_del_ajax', 'cs_admin_user_assignment_record_del_ajax');
}

/**
 * Quiz Reports
 */
 if ( ! function_exists( 'cs_quiz_reports' ) ) { 
 	function cs_quiz_reports() {
		$url = admin_url('edit.php?post_type=courses&page=quiz_assignments_listing_page&action=quiz-listing');
				if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by'] <> ''){
					$sort_by = $_REQUEST['sort_by'];
				} else {
					$sort_by = 'all';
				}
				$all_quiz = $Pass_quiz = $Fail_quiz = $Remaining_quiz = 0;
				$quiz_listing_count = cs_count_quiz_listing_reviews();
				if(isset($quiz_listing_count['all']))
					$all_quiz = $quiz_listing_count['all'];
				if(isset($quiz_listing_count['Pass']))
					$Pass_quiz = $quiz_listing_count['Pass'];
				if(isset($quiz_listing_count['Fail']))
					$Fail_quiz = $quiz_listing_count['Fail'];
				if(isset($quiz_listing_count['Pending']))
					$Pending_quiz = $quiz_listing_count['Pending'];
				if(isset($quiz_listing_count['Remaining']))
					$Remaining_quiz = $quiz_listing_count['Remaining'];
				
			?> 
              <div id="settings">
              <div class="tab-title"><h3><?php _e('Quiz Results','EDULMS');?></h3></div>
                <label> 
                    <select name="cs_statement_start_date" id="cs_statement_start_date" aria-controls="revenue" onchange="cs_user_statements_date_value(this.value,'<?php echo esc_js($url);?>')">
                        <option value="all" <?php if($sort_by == 'all'){echo 'selected';}?>><?php _e('All','EDULMS');?> (<?php echo esc_attr($all_quiz);?>)</option>
                        <option value="Pass" <?php if($sort_by == 'Pass') echo 'selected';?>><?php _e('Pass','EDULMS');?> (<?php echo esc_attr($Pass_quiz);?>)</option>
                        <option value="Fail" <?php if($sort_by == 'Fail') echo 'selected';?>><?php _e('Fail','EDULMS');?> (<?php echo esc_attr($Fail_quiz);?>)</option>
                        <option value="Pending" <?php if($sort_by == 'Pending') echo 'selected';?>><?php _e('Pending','EDULMS');?> (<?php echo esc_attr($Pending_quiz);?>)</option>
                        <option value="Remaining" <?php if($sort_by == 'Remaining') echo 'selected';?>><?php _e('Remaining','EDULMS');?> (<?php echo esc_attr($Remaining_quiz);?>)</option>
                    </select>
                </label>
					<?php 
                        $user_course_ids_data = array();
                        $cs_course_register_option = array();
                        $cs_course_register_option = get_option("cs_course_register_option", true);
                        if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
                            $cs_course_register_option = array();	
                        }
                        if(isset($cs_course_register_option['cs_user_ids_option']))
                            $user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
                        if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
                            ?>
                            <div class="my-courses">
                   
                                    <table id="report" class="display" cellspacing="0" width="100%">
                                        <tr>
                                            <th><?php _e('Quiz Name','EDULMS');?></th>
                                            <th><?php _e('Submission','EDULMS');?></th>
                                            <th><?php _e('Username','EDULMS');?></th>
                                            <th><?php _e('Email','EDULMS');?></th>
                                            <th><?php _e('Instructor Name','EDULMS');?></th>
                                            <th><?php _e('ip Address','EDULMS');?></th>
                                            <th><?php _e('Required','EDULMS');?>%</th>
                                            <th><?php _e('Q-Taken','EDULMS');?></th>
                                            <th><?php _e('Marks','EDULMS');?></th>
                                            <th><?php _e('Score','EDULMS');?></th>
                                            <th><?php _e('Remarks','EDULMS');?></th>
                                            <th><?php _e('Review Status','EDULMS');?></th>
                                            <th><?php _e('Attempts','EDULMS');?></th>
                                            <th></th>
                                        </tr>
                                        <?php
										   foreach ($user_course_ids_data as $user_key=>$user_login) {
											if(!isset($user_key))
												continue;
												$user_id  = $user_key;
												$display_name = $user_login;
												$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
												$counter_courses = 420;
												if(isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0){
													foreach($quiz_answer_array as $transaction_id=>$quiz_answer_values){
														foreach($quiz_answer_values as $quiz_id=>$quiz_answers){	
																	$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
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
																if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){		
																	$user_quiz_array = array();
																	$remaining_attempts = 0;
																	if(isset($quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'])){
																		$no_of_retakes_allowed = (int)$quiz_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
																		$remaining_attempts = $no_of_retakes_allowed-$attempt_no;
																	}
																	if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]))
																		$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
																  
																	  
																	 $user_quiz_result_info = array();   
																	if(isset($user_quiz_array['quiz_result']))	
																		$user_quiz_result_info = $user_quiz_array['quiz_result'];
																	$review_status = 'Pending';
																	if(isset($user_quiz_result_info['review_status']))
																		$review_status = $user_quiz_result_info['review_status'];	
																	if($sort_by <> 'all' && $review_status <> $sort_by){
																		continue;
																	}
																	if(isset($user_quiz_array['quiz_information']))	
																		$user_quiz_info = $user_quiz_array['quiz_information'];
																														
																	if(isset($user_quiz_info['quiz_question_show']))
																		$quiz_question_show = $user_quiz_info['quiz_question_show'];
																	else 
																		$quiz_question_show = 10;
																	
																	if(isset($user_quiz_result_info['attempt_date']))		
																		$attempt_date = $user_quiz_result_info['attempt_date'];
																	
																	$quiz_passing_marks = 33;
																	if(isset($user_quiz_info['quiz_passing_marks']))
																		$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
																	$user_course_information = array();
																	if(isset($user_quiz_array['course_information']))	
																		$user_course_information = $user_quiz_array['course_information'];
																	$user_course_id = '';
																	
																	
																	if(isset($user_course_information['course_id']))	
																		$user_course_id = $user_course_information['course_id'];	
																		$obj = new cs_settings();
																		$course_info = $obj->cs_user_course_data_info($user_id, $user_course_id);
																	if(isset($course_info['course_instructor'])){
																		$course_instructor = $course_info['course_instructor'];
																	} else {
																		$course_instructor = '';
																	}
																	if(isset($course_info['course_user_email'])){
																		$course_user_email = $course_info['course_user_email'];
																	} else {
																		$course_user_email = '';
																	}
																	$course_title = '';
																	if(isset($user_course_information['course_title']))
																		$course_title = $user_course_information['course_title'];
																	$user_quiz_questions = array();
																	if(isset($user_quiz_array['questions']))	
																		$user_quiz_questions = $user_quiz_array['questions'];
																	$attempt_questions = 0;
																	
																	$total_questions = count($user_quiz_questions);
																	$user_points = 0;
																	$question_marks_points = 0;
																	$result_percentage = 0;
																	$resutl_remarks = '';
																	$questions_points = 0;
																	$user_question_points = 0;
																	if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
																		$resutl_remarks = $user_quiz_result_info['remarks'];
																	if(isset($resutl_remarks) && $resutl_remarks <> 'Pending'){
																		if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
																			$user_points = $user_quiz_result_info['marks'];
																		$question_marks_points = 0;
																		if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
																			$question_marks_points = $user_quiz_result_info['total_marks'];
																		if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
																			$result_percentage = $user_quiz_result_info['marks_percentage'].'%';
																	}
																	foreach($user_quiz_questions as $questions_key=>$questions_values){
																		if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
																			$attempt_questions++;
																			
																		if(isset($questions_values['question_marks']) && $questions_values['question_marks'] <> ''){
																			$questions_points = $questions_points+$questions_values['question_marks'];
																		}
																		$user_question_points = $user_question_points+(int)$questions_values['user_question_point'];
																	}
																	if(empty($question_marks_points))
																		$question_marks_points = $questions_points;
																	if(empty($user_points))
																		$user_points = $user_question_points;
																	
																	$attempt_date = '';
																	$ip_address = '';
																	
																	
																	if(isset($user_quiz_result_info['ip_address']))
																		$ip_address = $user_quiz_result_info['ip_address'];
																	
																	if(isset($user_quiz_result_info['attempt_date']))
																		$attempt_date = $user_quiz_result_info['attempt_date'];
																
																		$counter_courses++;
																		$rand_key = rand(5,9);
																		?>
																		<tr id="quiz-row-<?php echo esc_attr($counter_courses.$rand_key);?>">
																			<td>
																			<?php
																			 if(!empty($course_title))echo esc_attr($course_title).' - ';
																			 if(isset($user_quiz_info['title'])) echo esc_attr($user_quiz_info['title']);?></td>
																			<td><?php echo esc_attr($attempt_date);?></td>
																			<td><a href="<?php echo get_edit_user_link($user_key);?>" target="_blank"><?php echo esc_attr($display_name);?></a></td>
																			<td><?php if(isset($course_user_email) && !empty($course_user_email))echo esc_attr($course_user_email); else echo '--';?></td>
																			<td><?php if(isset($course_instructor) && !empty($course_instructor))echo esc_attr($course_instructor); else echo '--';?></td>
																			<td><?php if(isset($ip_address))echo esc_attr($ip_address);?></td>
																			<td><?php if(isset($quiz_passing_marks ))echo esc_attr($quiz_passing_marks);?>%</td>
																			<td><?php echo esc_attr($attempt_questions).'/'.esc_attr($total_questions);?></td>
																			<td><?php if(isset($question_marks_points)) echo esc_attr($user_points).'/'.esc_attr($question_marks_points);?></td>
																			<td><?php if(isset($result_percentage))echo esc_attr($result_percentage);?></td>
																			<td><?php if(isset($resutl_remarks))echo esc_attr($resutl_remarks);?></td>
																			<td><?php echo esc_attr($review_status);?></td>
																			<td><?php echo esc_attr($attempt_no).'/'.esc_attr($no_of_retakes_allowed);?></td>
																			<td>
																				<script>
																				  jQuery(document).ready(function($){
																					  $('#toggle-<?php echo esc_js($counter_courses.$rand_key);?>').click(function() {
																						  
																						  $('#toggle-div-<?php echo esc_js($counter_courses.$rand_key);?>').slideToggle('slow', function() {});
																					  });
																				  });
																				</script>
																				<a id="toggle-<?php echo esc_attr($counter_courses.$rand_key);?>" onclick="cs_user_quiz_assignment_record_report('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses.$rand_key);?>','paid')"><i class="fa fa-plus"></i></a>
																				<a id="toggle-<?php echo esc_attr($counter_courses.$rand_key);?>" onclick="cs_user_quiz_assignment_record_report_del('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses.$rand_key);?>','paid')"><i class="fa fa-trash-o"></i></a>
																				
																				
																			</td>
																		</tr>
																		<tr class="toggle-static-class toggle-div-class-<?php echo esc_attr($counter_courses.$rand_key);?>" id="toggle-div-<?php echo esc_attr($counter_courses.$rand_key);?>">
																			<td colspan="12">
																			   <div class="toggle-sec">
																					<!--Quiz Questions listing-->
																					<div id="toggle-div-data-<?php echo esc_attr($counter_courses.$rand_key);?>"></div>
																				</div>
																			</td>
																		</tr>
																		<?php
																}
															}
														}
													}
												}
												
												//Free Quiz Listing Array
												$counter_courses = 400888;
												$quiz_registereduser_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
												$uid = $user_id;
												if(isset($quiz_registereduser_answer_array) && is_array($quiz_registereduser_answer_array) && count($quiz_registereduser_answer_array)>0){
													foreach($quiz_registereduser_answer_array as $transaction_id=>$quiz_answer_values){
														foreach($quiz_answer_values as $quiz_id=>$quiz_answers){	
																	$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
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
																if(isset($quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no])){		
																	$user_quiz_array = array();
																	$remaining_attempts = 0;
																	if(isset($quiz_registereduser_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'])){
																		$no_of_retakes_allowed = (int)$quiz_registereduser_answer_array[$transaction_id][$quiz_id]['quiz_attempt']['no_of_retakes_allowed'];
																		$remaining_attempts = $no_of_retakes_allowed-$attempt_no;
																	}
																	if(isset($quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no]))
																		$user_quiz_array = $quiz_registereduser_answer_array[$transaction_id][$quiz_id][$attempt_no];
																  
																	  
																	 $user_quiz_result_info = array();   
																	if(isset($user_quiz_array['quiz_result']))	
																		$user_quiz_result_info = $user_quiz_array['quiz_result'];
																	$review_status = 'Pending';
																	if(isset($user_quiz_result_info['review_status']))
																		$review_status = $user_quiz_result_info['review_status'];	
																	if($sort_by <> 'all' && $review_status <> $sort_by){
																		continue;
																	}
																	if(isset($user_quiz_array['quiz_information']))	
																		$user_quiz_info = $user_quiz_array['quiz_information'];
																														
																	if(isset($user_quiz_info['quiz_question_show']))
																		$quiz_question_show = $user_quiz_info['quiz_question_show'];
																	else 
																		$quiz_question_show = 10;
																	
																	if(isset($user_quiz_result_info['attempt_date']))		
																		$attempt_date = $user_quiz_result_info['attempt_date'];
																	
																	$quiz_passing_marks = 33;
																	if(isset($user_quiz_info['quiz_passing_marks']))
																		$quiz_passing_marks = $user_quiz_info['quiz_passing_marks'];
																	$user_course_information = array();
																	if(isset($user_quiz_array['course_information']))	
																		$user_course_information = $user_quiz_array['course_information'];
																	$user_course_id = '';
																	
																	
																	if(isset($user_course_information['course_id']))	
																		$user_course_id = $user_course_information['course_id'];	
																		$obj = new cs_settings();
																		$course_info = $obj->cs_user_course_data_info($user_id, $user_course_id);
																	if(isset($course_info['course_instructor'])){
																		$course_instructor = $course_info['course_instructor'];
																	} else {
																		$course_instructor = '';
																	}
																	if(isset($course_info['course_user_email'])){
																		$course_user_email = $course_info['course_user_email'];
																	} else {
																		$course_user_email = '';
																	}
																	$course_title = '';
																	if(isset($user_course_information['course_title']))
																		$course_title = $user_course_information['course_title'];
																	$user_quiz_questions = array();
																	if(isset($user_quiz_array['questions']))	
																		$user_quiz_questions = $user_quiz_array['questions'];
																	$attempt_questions = 0;
																	
																	$total_questions = count($user_quiz_questions);
																	$user_points = 0;
																	$question_marks_points = 0;
																	$result_percentage = 0;
																	$resutl_remarks = '';
																	$questions_points = 0;
																	$user_question_points = 0;
																	if(isset($user_quiz_result_info['remarks']) && !empty($user_quiz_result_info['remarks']))
																		$resutl_remarks = $user_quiz_result_info['remarks'];
																	if(isset($resutl_remarks) && $resutl_remarks <> 'Pending'){
																		if(isset($user_quiz_result_info['marks']) && !empty($user_quiz_result_info['marks']))
																			$user_points = $user_quiz_result_info['marks'];
																		$question_marks_points = 0;
																		if(isset($user_quiz_result_info['total_marks']) && !empty($user_quiz_result_info['total_marks']))
																			$question_marks_points = $user_quiz_result_info['total_marks'];
																		if(isset($user_quiz_result_info['marks_percentage']) && !empty($user_quiz_result_info['marks_percentage']))
																			$result_percentage = $user_quiz_result_info['marks_percentage'].'%';
																	}
																	foreach($user_quiz_questions as $questions_key=>$questions_values){
																		if(isset($questions_values['user_answer']) && $questions_values['user_answer'] <> '')
																			$attempt_questions++;
																			
																		if(isset($questions_values['question_marks']) && $questions_values['question_marks'] <> ''){
																			$questions_points = $questions_points+$questions_values['question_marks'];
																		}
																		$user_question_points = $user_question_points+(int)$questions_values['user_question_point'];
																	}
																	if(empty($question_marks_points))
																		$question_marks_points = $questions_points;
																	if(empty($user_points))
																		$user_points = $user_question_points;
																	
																	$attempt_date = '';
																	$ip_address = '';
																	
																	
																	if(isset($user_quiz_result_info['ip_address']))
																		$ip_address = $user_quiz_result_info['ip_address'];
																	
																	if(isset($user_quiz_result_info['attempt_date']))
																		$attempt_date = $user_quiz_result_info['attempt_date'];
																
																		$counter_courses++;
																		$rand_key = rand(5,9898);
																		?>
																		<tr id="quiz-row-<?php echo esc_attr($counter_courses.$rand_key);?>">
																			<td>
																			<?php
																			 if(!empty($course_title))echo esc_attr($course_title).' - ';
																			 if(isset($user_quiz_info['title'])) echo esc_attr($user_quiz_info['title']); 
																			 echo ' (Free Quiz)';
																			 ?></td>
																			<td><?php echo esc_attr($attempt_date);?></td>
																			<td><a href="<?php echo get_edit_user_link($user_key);?>" target="_blank"><?php echo esc_attr($display_name);?></a></td>
																			<td><?php echo get_the_author_meta('user_email');?></td>
																			<td><?php if(isset($course_instructor) && !empty($course_instructor))echo esc_attr($course_instructor); else echo '--';?></td>
																			<td><?php if(isset($ip_address))echo esc_attr($ip_address);?></td>
																			<td><?php if(isset($quiz_passing_marks ))echo esc_attr($quiz_passing_marks);?>%</td>
																			<td><?php echo esc_attr($attempt_questions).'/'.esc_attr($total_questions);?></td>
																			<td><?php if(isset($question_marks_points)) echo esc_attr($user_points).'/'.esc_attr($question_marks_points);?></td>
																			<td><?php if(isset($result_percentage))echo esc_attr($result_percentage);?></td>
																			<td><?php if(isset($resutl_remarks))echo esc_attr($resutl_remarks);?></td>
																			<td><?php echo esc_attr($review_status);?></td>
																			<td><?php echo esc_attr($attempt_no).'/'.esc_attr($no_of_retakes_allowed);?></td>
																			<td>
																				<script>
																				  jQuery(document).ready(function($){
																					  $('#toggle-<?php echo esc_js($counter_courses.$rand_key);?>').click(function() {
																						  
																						  $('#toggle-div-<?php echo esc_js($counter_courses.$rand_key);?>').slideToggle('slow', function() {});
																					  });
																				  });
																				</script>
																				<a id="toggle-<?php echo esc_attr($counter_courses.$rand_key);?>" onclick="cs_user_quiz_assignment_record_report('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses.$rand_key);?>','free')"><i class="fa fa-plus"></i></a>
																				<a id="toggle-<?php echo esc_attr($counter_courses.$rand_key);?>" onclick="cs_user_quiz_assignment_record_report_del('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($counter_courses.$rand_key);?>','free')"><i class="fa fa-trash-o"></i></a>
																				
																				
																			</td>
																		</tr>
																		<tr class="toggle-static-class toggle-div-class-<?php echo esc_attr($counter_courses.$rand_key);?>" id="toggle-div-<?php echo esc_attr($counter_courses.$rand_key);?>">
																			<td colspan="12">
																			   <div class="toggle-sec">
																					<!--Quiz Questions listing-->
																					<div id="toggle-div-data-<?php echo esc_attr($counter_courses.$rand_key);?>"></div>
																				</div>
																			</td>
																		</tr>
																		<?php
																}
															}
														}
													}
												}
												
												
												
									 }
                                ?>
                              </table>
                        </div>
                            <?php
                        }
                     ?>
              </div>
            <?php 
	}
	add_action('cs_quiz_listing_report','cs_quiz_reports');
 }
 /**
 * Quiz Delete
 */
if ( ! function_exists( 'cs_admin_user_quiz_record_del_ajax' ) ) {
	function cs_admin_user_quiz_record_del_ajax() {
		$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['quiz_id']))  $quiz_id = $_POST['quiz_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['quiz_type']))  $quiz_type = $_POST['quiz_type'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_quiz_questions = array();
		//$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
		if(isset($quiz_type) && $quiz_type == 'free'){
			$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
		} else {
			$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);	
		}

		if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
			unset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]);
		}
		if(isset($quiz_type) && $quiz_type == 'free'){
			update_user_meta($user_id,'cs-registered-free-quiz-answers', $quiz_answer_array);
		} else {
			update_user_meta($user_id,'cs-quiz-nswers', $quiz_answer_array);
		}
		
		if(isset($quiz_answer_array[$transaction_id][$quiz_id]) && is_array($quiz_answer_array[$transaction_id][$quiz_id]) && count($quiz_answer_array[$transaction_id][$quiz_id])<1){
			$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;	
			delete_option($quiz_complete_key);
		}
		echo 'Quiz Record Dleted';
		exit;
	}
	add_action('wp_ajax_cs_admin_user_quiz_record_del_ajax', 'cs_admin_user_quiz_record_del_ajax');
}
/**
 * Quiz Reports Questions Listing
 */
if ( ! function_exists( 'cs_admin_user_quiz_assignment_record_ajax' ) ) { 
	function cs_admin_user_quiz_assignment_record_ajax(){
		$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['quiz_id']))  $quiz_id = $_POST['quiz_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['quiz_type']))  $quiz_type = $_POST['quiz_type'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_quiz_questions = array();
		if(isset($quiz_type) && $quiz_type == 'free'){
			$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
		} else {
			$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);	
		}
		if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]) && is_array($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]))
			$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
		$user_quiz_questions = $user_quiz_array['questions'];
		$user_quiz_result = $user_quiz_array['quiz_result'];
		$review_status = $user_quiz_result['review_status'];
		$review_remarks = $user_quiz_result['remarks'];
		$total_questions = count($user_quiz_questions);
		$rand_id = rand(888, 9999);
		$status_field_id = $transaction_id.'-'.$quiz_id.'-'.$rand_id;
		?>
			<div class="textarea-sec">
				<h6><?php _e('Review Status','EDULMS');?></h6>
				<select name="assignment_review_status" id="<?php echo esc_attr($status_field_id);?>-review">
					<option value="Pass" <?php if($review_status == 'Pass') echo 'selected';?>><?php _e('Pass','EDULMS');?></option>
					<option value="Fail" <?php if($review_status == 'Fail') echo 'selected';?>><?php _e('Fail','EDULMS');?></option>
					<option value="Pending" <?php if($review_status == 'Pending') echo 'selected';?>><?php _e('Pending','EDULMS');?></option>
					<option value="Remaining" <?php if($review_status == 'Remaining') echo 'selected';?>><?php _e('Remaining','EDULMS');?></option>
				</select>
			</div>
		<?php
		if($total_questions>0){
		?>
		<ul class="quiz-pagination">
			<?php 
			$counter_rand_no = rand(999,88888);
			$counter_rand_no_j = $counter_rand_no;
			$counter_rand_no_k = $counter_rand_no;
			for($j=1; $j<=$total_questions; $j++){
				$active_class = '';
				if($j==1){$active_class = 'active';}
			?>
				<li class="<?php echo esc_attr($active_class.' '.$j.'-class');?>">
					<a onclick="cs_quiz_result_show_pagination('<?php echo esc_js($counter_rand_no);?>','<?php echo esc_js($counter_rand_no_j);?>',<?php echo esc_js($counter_rand_no+$total_questions);?>, <?php echo esc_js($j);?>)"><?php echo absint($j);?></a>
				</li>
			<?php 
			$counter_rand_no_j++;
			}
			?>
		</ul>
		<?php 
			$counter  = 0;
			foreach ( $user_quiz_questions as $question_key=>$question ){
				
				$question_title = @$question['question_title'];
				$question_marks = @$question['question_marks'];
				$answer_type = @$question['answer_type'];
				$user_answer = @$question['user_answer'];
				$user_question_point = @$question['user_question_point'];
			$counter++;
			$style_class = '';
			if($counter <> 1){
				$style_class = 'style="display:none;"';	
			}
		?>
			<div class="question-number question-<?php echo esc_attr($counter_rand_no_k);?>" <?php echo ''.$style_class;?>>
				<h5 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($question_title);?></h5>
				<?php
				$counter_rand_no_k++;
				if(isset($answer_type) && $answer_type == 'multiple-option'){
						$question_grade = '';
						$answer_title_multiple_option = @$question['answer_title_multiple_option'];
						$answer_title_multiple_option_correct = @$question['answer_title_multiple_option_correct'];
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
									<div class="checkbox">
										<input id="checkbox1" type="checkbox" <?php echo esc_attr($checked_value);?> disabled="disabled" />
										<label for="checkbox1" class="<?php echo esc_attr($checkbox_class);?>"><?php echo esc_attr($answeroption_value);?></label>
									</div>
								</li>
							<?php 
								}
							?>
						</ul>
				<?php } else if(isset($answer_type) && $answer_type == 'large-text'){
						$answer_large_text = @$question['answer_large_text'];
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
				<?php }
					$question_text_field_id = $transaction_id.'_'.$quiz_id.'_'.$attempt_no.'_'.$user_id.'_'.$question_key.'_question';
				?>
				<div id="<?php echo esc_attr($question_text_field_id);?>-loading"></div>
					<div class="score-sec">
						<ul class="left-sec">
							<li>
								<label><?php _e('Score','EDULMS');?></label>
								  <input type="text" id="<?php echo esc_attr($question_text_field_id);?>" value="<?php echo esc_attr($user_question_point);?>" />
								<span><?php echo '/'.esc_attr($question_marks);?></span>
								<a onclick="cs_quiz_question_update_marks('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($quiz_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($question_key);?>','<?php echo esc_js($question_text_field_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js($status_field_id);?>', '<?php echo esc_js($course_id);?>', '<?php echo esc_js($quiz_type);?>');">update</a>
							</li>
						</ul>
						<ul class="right-sec <?php echo esc_attr($question_grade);?>-click-icon">
							<li>
							<?php if(@$question_grade == 'right')
									echo 'Correct';
								  else if(@$question_grade == 'wrong')
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
			echo __('There are no questions against this quiz', 'EDULMS');	
		}
		exit;
	}
	add_action('wp_ajax_cs_admin_user_quiz_assignment_record_ajax', 'cs_admin_user_quiz_assignment_record_ajax');
}

/**
 * Get Attachement function 
 */
if ( ! function_exists( 'wp_get_attachment' ) ) { 
	function wp_get_attachment( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		return array(
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}
}

/**
 * Assignment detail By ajax request
 */
if ( ! function_exists( 'cs_admin_user_assignment_record_ajax' ) ) { 
	function cs_admin_user_assignment_record_ajax(){
		$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = '';
		if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
		if(isset($_POST['assignment_id']))  $assignment_id = $_POST['assignment_id'];
		if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
		$user_quiz_questions = array();
		$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
		if(isset($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]) && is_array($user_assingments_array[$transaction_id][$assignment_id][$attempt_no]))
			$user_assignment_info = $user_assingments_array[$transaction_id][$assignment_id]['course_assignment_info'];
					
			$assignments_title = $user_assignment_info['assignments_title'];
			$course_title = $user_assignment_info['course_title'];
			$assignments_description = $user_assignment_info['assignments_description'];
			$assignment_retakes_no = $user_assignment_info['assignment_retakes_no'];
			$assignment_passing_marks = $user_assignment_info['assignment_passing_marks'];
			$question_marks_points = $assignment_total_marks = $user_assignment_info['assignment_total_marks'];
			if(empty($question_marks_points))
				$question_marks_points = $assignment_total_marks = 100;
		
			$user_assingments_array = $user_assingments_array[$transaction_id][$assignment_id][$attempt_no];
			$user_assignment_data = $user_assingments_array['assignment_data'];
			$assignment_marks = 0;
			$total_assignment_data = count($user_assignment_data);
			if(is_array($user_assignment_data) && $total_assignment_data>0){
				
				$user_assignments_title = $user_assignment_data['user_assignments_title'];
				$user_assignments_description = $user_assignment_data['user_assignments_description'];
				$attempt_date = $user_assignment_data['attempt_date'];
				$review_status = 'Pending';
				if(isset($user_assignment_data['review_status']) && $user_assignment_data['review_status'] <> '')
					$review_status = $user_assignment_data['review_status'];
				
				
				$assignment_marks = $user_assignment_data['assignment_marks'];
				$assignment_remarks = $user_assignment_data['assignment_remarks'];
				$assignment_upload_attachment = $user_assignment_data['assignment_upload_attachment'];
				if(isset($user_assignment_data['assignment_upload_attachment_title']))
					$assignment_upload_attachment_title = $user_assignment_data['assignment_upload_attachment_title'];
				else 
					$assignment_upload_attachment_title = $assignment_upload_attachment;
				$result_percentage = 0;
				if($assignment_marks > 0 && $question_marks_points>0)
					$result_percentage = ($assignment_marks/$question_marks_points)*100;
				
				?>
				 <h2 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($assignments_title .' - '.$course_title);?></h2>
				 <div class="textarea-sec">
				   <p><?php echo esc_textarea($assignments_description);?></p>
				</div>
					<h3 class="result-heading"><?php _e('User Assignment','EDULMS');?></h3>
					<div class="textarea-sec">
						<h5><?php echo esc_attr($user_assignments_title);?></h5>
						<textarea class="bg-textarea" disabled="disabled"><?php echo esc_textarea($user_assignments_description);?></textarea>
					</div>
					<ul class="files-sec">
						<li>
						   <?php if($assignment_upload_attachment <> ''){?>
								<a href="<?php echo esc_url($assignment_upload_attachment);?>" target="_blank"><i class="fa fa-file-archive-o"></i><?php echo esc_attr($assignment_upload_attachment_title);?></a>
							<?php }?>
							<span><?php _e('Uploaded on:','EDULMS');?> <?php echo esc_attr($attempt_date);?></span>
						</li>
					</ul>
					<?php
						$question_text_field_id = $transaction_id.'_'.$assignment_id.'_'.$attempt_no.'_'.$user_id.'_assignment';
					?>
					<div class="textarea-sec">
						<h6><?php _e('Remarks','EDULMS');?></h6>
						<textarea class="bg-textarea" id="<?php echo esc_textarea($question_text_field_id);?>-remarks"><?php echo esc_attr($assignment_remarks);?></textarea>
					</div>
					<div class="textarea-sec">
						<h6><?php _e('Review Status','EDULMS');?></h6>
						<select name="assignment_review_sttus" id="<?php echo esc_attr($question_text_field_id);?>-review">
							<option value="Pass" <?php if($review_status == 'Pass') echo 'selected';?>>Pass</option>
							<option value="Fail" <?php if($review_status == 'Fail') echo 'selected';?>>Fail</option>
							<option value="Pending" <?php if($review_status == 'Pending') echo 'selected';?>>Pending</option>
							<option value="Remaining" <?php if($review_status == 'Remaining') echo 'selected';?>>Remaining</option>
						</select>
					</div>
					<div id="<?php echo esc_attr($question_text_field_id);?>-loading"></div>
					<div class="score-sec">
						<ul class="left-sec">
							<li>
								<label><?php _e('Score','EDULMS');?></label>
								<input type="text" id="<?php echo esc_attr($question_text_field_id);?>" value="<?php echo esc_attr($assignment_marks);?>" />
								<span><?php echo '/'.$assignment_total_marks;?></span>
								<a onclick="cs_assignment_question_update_marks('<?php echo esc_js($transaction_id);?>','<?php echo esc_js($assignment_id);?>','<?php echo esc_js($attempt_no);?>','<?php echo esc_js($user_id);?>','<?php echo esc_js($question_text_field_id);?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>');">update</a>
							</li>
						</ul>
					</div> 
				<?php
			} else {
				echo __('There are no questions against this Assignment', 'EDULMS');	
			}
		exit;
	}
	add_action('wp_ajax_cs_admin_user_assignment_record_ajax', 'cs_admin_user_assignment_record_ajax');
}

/**
 * Question Marks Update
 */
if ( ! function_exists( 'cs_quiz_question_update_marks_ajax' ) ) { 
	function cs_quiz_question_update_marks_ajax(){
	$transaction_id = $quiz_id = $attempt_no = $course_id = $user_id = $quiz_type = '';
	$question_point_marks = 0;
	$review_status = 'Pending';
	if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
	if(isset($_POST['quiz_id']))  $quiz_id = $_POST['quiz_id'];
	if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
	if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
	if(isset($_POST['question_id']))  $question_id = $_POST['question_id'];
	if(isset($_POST['review_status']))  $review_status = $_POST['review_status'];
	if(isset($_POST['course_id']))  $course_id = $_POST['course_id'];
	if(isset($_POST['quiz_type']))  $quiz_type = $_POST['quiz_type'];
	if(isset($_POST['question_point_marks']))  $question_point_marks = $_POST['question_point_marks'];
	
	
	//question_point_marks
	$user_quiz_questions = array();
	if(isset($quiz_type) && $quiz_type == 'free'){
		$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
	} else {
		$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);	
	}
	$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['questions'][$question_id]['user_question_point'] = $question_point_marks;
	// Quiz Result Array
		$quiz_result_array = array();
		$result_percentage = 0;
		$user_marks = 0;
		$question_marks_points = 0;
		$user_marks = 0;
		$question_marks_points = 0;
		$remarks = 'Pending';
		$quiz_passing_marks = 0;
		foreach($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['questions'] as $question_keys=>$question_values){
			if($question_keys){
				if(isset($question_values['question_marks'])){
					$question_marks_points = $question_marks_points+(int)$question_values['question_marks'];
				}
				$user_marks = $user_marks+(int)$question_values['user_question_point'];
			}
		}
		if($question_marks_points>0){
			$result_percentage = ($user_marks / $question_marks_points) * 100;
			$result_percentage = round($result_percentage, 2);
		}
		if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_information']['quiz_passing_marks'])){
			$quiz_passing_marks = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_information']['quiz_passing_marks'];
			if($result_percentage>$quiz_passing_marks){
				$remarks = 'Pass';
			} else {
				$remarks = 'Fail';
			}
		}
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['total_marks'] = $question_marks_points;
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['marks'] = $user_marks;
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['remarks'] = $remarks;
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['review_status'] = $review_status;
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['grade'] = '';
		$quiz_answer_array[$transaction_id][$quiz_id][$attempt_no]['quiz_result']['marks_percentage'] = $result_percentage;
		if(isset($quiz_type) && $quiz_type == 'free'){
			//$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
			update_user_meta($user_id,'cs-registered-free-quiz-answers', $quiz_answer_array);	
		} else {
			update_user_meta($user_id,'cs-quiz-nswers', $quiz_answer_array);	
		}
	exit;
	}
	add_action('wp_ajax_cs_quiz_question_update_marks_ajax', 'cs_quiz_question_update_marks_ajax');
}

/**
 * Assignments Marks Update
 */
if ( ! function_exists( 'cs_assignments_question_update_marks_ajax' ) ) { 
	function cs_assignments_question_update_marks_ajax(){
	  $transaction_id = $assignment_id = $attempt_no = $course_id = $user_id = '';
	  $assignment_marks = 0;
	  $assignment_remarks = '';
	  if(isset($_POST['transaction_id']))  $transaction_id = $_POST['transaction_id'];
	  if(isset($_POST['assignment_id']))  $assignment_id = $_POST['assignment_id'];
	  if(isset($_POST['attempt_no']))  $attempt_no = $_POST['attempt_no'];
	  if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
	  if(isset($_POST['review_status']))  $assignment_review_status = $_POST['review_status'];
	  if(isset($_POST['question_point_marks']))  $assignment_marks = $_POST['question_point_marks'];
	  if(isset($_POST['assignment_remarks']))  $assignment_remarks = $_POST['assignment_remarks'];
		$assignment_answer_array = get_user_meta($user_id,'cs-user-assignments', true);
		if(!empty($assignment_review_status))
			$assignment_answer_array[$transaction_id][$assignment_id][$attempt_no]['assignment_data']['review_status'] = $assignment_review_status;
		$assignment_answer_array[$transaction_id][$assignment_id][$attempt_no]['assignment_data']['assignment_marks'] = $assignment_marks;
		$assignment_answer_array[$transaction_id][$assignment_id][$attempt_no]['assignment_data']['assignment_remarks'] = $assignment_remarks;
		update_user_meta($user_id,'cs-user-assignments', $assignment_answer_array);
		exit;
	}
	add_action('wp_ajax_cs_assignments_question_update_marks_ajax', 'cs_assignments_question_update_marks_ajax');
}

/**
 * Assignments Marks Update
 */
if ( ! function_exists( 'cs_assignments_question_update_marks_ajax' ) ) { 

}

/**
 * Quiz Status Reviews
 */
if ( ! function_exists( 'cs_count_quiz_listing_reviews' ) ) {
	function cs_count_quiz_listing_reviews(){
			$user_course_ids_data = array();
			$cs_course_register_option = array();
			$counter_quizes = 0;
			$pending_quizes = 0;
			$Pass_quizes = 0;
			$Fail_quizes = 0;
			$Remaining_quizes = 0;
			$cs_course_register_option = get_option("cs_course_register_option", true);
			if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
				$cs_course_register_option = array();	
			}
			if(isset($cs_course_register_option['cs_user_ids_option']))
				$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
				if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
						foreach ($user_course_ids_data as $user_key=>$user_login) {
							if(!isset($user_key))
								continue;
								$user_id  = $user_key;
								$display_name = $user_login;
								$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
								if(isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0){
									foreach($quiz_answer_array as $transaction_id=>$quiz_answer_values){
										foreach($quiz_answer_values as $quiz_id=>$quiz_answers){
											$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
											$quiz_complete = get_option($quiz_complete_key);
											if(!isset($quiz_complete)){
												$quiz_complete = 1;
											} else if(isset($quiz_complete) && $quiz_complete == ''){
												$quiz_complete = 1;
											}
											$attempt_no = $attempt_no_total = $quiz_complete-1;
											if($attempt_no < 1){
												$attempt_no = 1;
												$quiz_complete = $attempt_no_total =  1;
											}
											for($attempt_no = 1; $attempt_no <= $attempt_no_total; $attempt_no++){
												$user_quiz_array = array();
												if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
													$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
													if(isset($user_quiz_array['quiz_result']))	
														$user_quiz_result_info = $user_quiz_array['quiz_result'];
													$review_status = 'Pending';
													if(isset($user_quiz_result_info['review_status']))
														$review_status = $user_quiz_result_info['review_status'];	
													
													$counter_quizes++;	
													if($review_status == 'Pending')	{
														$pending_quizes++;
													} else if($review_status == 'Pass'){
														$Pass_quizes++;
													} else if($review_status == 'Fail'){
														$Fail_quizes++;
													} else if($review_status == 'Remaining'){
														$Remaining_quizes++;
													}
												}
											}
										}
									}
								}
								
								//$quiz_answer_array = get_user_meta($user_id,'cs-quiz-nswers', true);
								$quiz_answer_array = get_user_meta($user_id,'cs-registered-free-quiz-answers', true);
								if(isset($quiz_answer_array) && is_array($quiz_answer_array) && count($quiz_answer_array)>0){
									foreach($quiz_answer_array as $transaction_id=>$quiz_answer_values){
										foreach($quiz_answer_values as $quiz_id=>$quiz_answers){
											$quiz_complete_key = $user_id.'_'.$transaction_id.'_'.$quiz_id;
											$quiz_complete = get_option($quiz_complete_key);
											if(!isset($quiz_complete)){
												$quiz_complete = 1;
											} else if(isset($quiz_complete) && $quiz_complete == ''){
												$quiz_complete = 1;
											}
											$attempt_no = $attempt_no_total = $quiz_complete-1;
											if($attempt_no < 1){
												$attempt_no = 1;
												$quiz_complete = 1;
											}
											for($attempt_no = 1; $attempt_no <= $attempt_no_total; $attempt_no++){
												$user_quiz_array = array();
												if(isset($quiz_answer_array[$transaction_id][$quiz_id][$attempt_no])){
													$user_quiz_array = $quiz_answer_array[$transaction_id][$quiz_id][$attempt_no];
													if(isset($user_quiz_array['quiz_result']))	
														$user_quiz_result_info = $user_quiz_array['quiz_result'];
													$review_status = 'Pending';
													if(isset($user_quiz_result_info['review_status']))
														$review_status = $user_quiz_result_info['review_status'];	
													$counter_quizes++;	
													if($review_status == 'Pending')	{
														$pending_quizes++;
													} else if($review_status == 'Pass'){
														$Pass_quizes++;
													} else if($review_status == 'Fail'){
														$Fail_quizes++;
													} else if($review_status == 'Remaining'){
														$Remaining_quizes++;
													}
												}
											}
										}
									}
								}
						}
				}
				$count_quiz_array = array();
				$count_quiz_array['all'] = $counter_quizes;
				$count_quiz_array['Pending'] = $pending_quizes;
				$count_quiz_array['Pass'] = $Pass_quizes;
				$count_quiz_array['Fail'] = $Fail_quizes;
				$count_quiz_array['Remaining'] = $Remaining_quizes;
				return $count_quiz_array;
	}
}

/**
 * Assignments Status Reviews
 */
if ( ! function_exists( 'cs_count_assignment_listing_status' ) ) {
	function cs_count_assignment_listing_status(){
		$user_course_ids_data = array();
			$cs_course_register_option = array();
			$counter_assignment = 0;
			$pending_assignment = 0;
			$Pass_assignment = 0;
			$Fail_assignment = 0;
			$Remaining_assignment = 0;
			$cs_course_register_option = get_option("cs_course_register_option", true);
			if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
				$cs_course_register_option = array();	
			}
			if(isset($cs_course_register_option['cs_user_ids_option']))
				$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
			if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
				$blogusers = get_users();
				foreach ($blogusers as $user) {
					if(!in_array($user->ID, $user_course_ids_data)){
						$user_course_ids_data[$user->ID] = $user->display_name;
					}
				}
				foreach ($user_course_ids_data as $user_key=>$user_login) {
						if(!isset($user_key))
							continue;
						$user_id  = $user_key;
						$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
						$counter_assignments = 900;
					 if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0){
							foreach($user_assingments_array as $transaction_id=>$assingments_answer_values){
								if($transaction_id){
									$assingment_ids_info = array();
									if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
										$assingment_ids_info_array = $user_assingments_array[$transaction_id]['assingment_ids_info'];
										$assingment_ids_info = array_unique($assingment_ids_info_array);
									}
								}
								foreach($assingment_ids_info as $assignment_id){
									if(isset($assingments_answer_values[$assignment_id]) && is_array($assingments_answer_values[$assignment_id]) && count($assingments_answer_values[$assignment_id])>2){
											$assignment_array = $assingments_answer_values[$assignment_id];
											$assingment_attempt_info = $assignment_array['assingment_attempt_info'];
											$assignment_attempt_no = $assingment_attempt_info['assignment_attempt_no'];
											$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
											$assignment_complete = get_option($assignment_complete_key);
											if(!isset($assignment_complete)){
												$assignment_complete = 1;
											} else if(isset($assignment_complete) && $assignment_complete == ''){
												$assignment_complete = 1;
											}
											 $attempt_no = $attempt_no_total = $assignment_complete;
											for($i=1; $i<(int)$attempt_no; $i++){
												if(isset($assignment_array[$i]) && is_array($assignment_array[$i])){
														$user_assignment_data = array(); 
														if(isset($assignment_array[$i]['assignment_data']))
															$user_assignment_data = $assignment_array[$i]['assignment_data'];
														$review_status = 'Pending';
														if(isset($user_assignment_data['review_status']))
															$review_status = $user_assignment_data['review_status'];	
														$counter_assignment++;	
														if($review_status == 'Pending')	{
															$pending_assignment++;
														} else if($review_status == 'Pass'){
															$Pass_assignment++;
														} else if($review_status == 'Fail'){
															$Fail_assignment++;
														} else if($review_status == 'Remaining'){
															$Remaining_assignment++;
														}
												}
											}
									}
								}
							}
					 }
				}
			}
		$count_assignment_array = array();
		$count_assignment_array['all'] = $counter_assignment;
		$count_assignment_array['Pass'] = $Pass_assignment;
		$count_assignment_array['Fail'] = $Fail_assignment;
		$count_assignment_array['Remaining'] = $Remaining_assignment;
		$count_assignment_array['Pending'] = $pending_assignment;
		return $count_assignment_array;
	}
}


/**
 * Set empty values for all courses members, Assignments, Quiz
 */
if ( ! function_exists( 'cs_set_default_courses_values' ) ) {
	function cs_set_default_courses_values(){
		global $post;
		$abc = array();
		update_option("cs_user_ids_data", $abc);
		update_option("cs_course_register_option", $abc);
		update_option("cs_instructors_ids_data", $abc);
		update_option("cs_course_ids_data", '');
		
		$args = array(
					'posts_per_page'			=> "-1",
					'paged'						=> "1",
					'post_type'					=> 'courses',
					'post_status'				=> 'publish',
					'orderby'					=> 'ID',
					'order'						=> 'ASC',
				);
		$custom_query = new WP_Query($args);
		$instructor_data['count_post'] = $custom_query->post_count;
		$count_students = 0;
		if ( $custom_query->have_posts() <> "" ) {
			while ( $custom_query->have_posts() ): $custom_query->the_post();
				update_post_meta($post->ID, "cs_user_course_data", $abc);
				update_option($post->ID."_cs_user_course_data", $abc);
			endwhile;
		}
		
		$blogusers = get_users('orderby=nicename');
		foreach ($blogusers as $user) {
			update_user_meta($user->ID, "cs_user_course_meta", $abc);
			update_option($user->ID."_cs_course_data", $abc);
			update_user_meta($user->ID, "cs-user-assignments", $abc);
			update_user_meta($user->ID, "cs-quiz-nswers", $abc);
			
		}
	}
}
if ( ! function_exists( 'cs_course_options' ) ) {
	function cs_course_options() {
		global $reset_date,$options;
		$_POST = edulms_stripslashes_htmlspecialchars($_POST);
		update_option( "cs_course_options",$_POST );
		echo "Course Options Saved";
		
		die();
	}
	add_action('wp_ajax_cs_course_options', 'cs_course_options');
}


/**
 * @Add Badges
 *
 *
 */
$counter_icon = 0;
if ( ! function_exists( 'add_badge' ) ) {
	function add_badge(){
	
		$template_path = get_template_directory_uri() . '/include/assets/scripts/media_upload.js';
	
		wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
		if($_POST['badges_net_icons']){
			 
			$badge_list = $_POST['badges_net_icons'];
		}
		if(isset($_POST['badges_net_icons_paths']) and $_POST['badges_net_icons_paths']<>''){$badge_image = '<img width="50" src="' .$_POST['badges_net_icons_paths']. '">';}else{$badge_image = '';}
		$badge_list=get_option('badges_net_icons');
		echo '<tr id="del_' .str_replace(' ','-',$_POST['badges_net_icons']).'"> 
	
			<td>'.$badge_image.'</td> 
			
			<td>' .$_POST['badges_net_icons_short_name']. '</td> 
	
			<td>' .$_POST['badges_net_icons'].'</td> 
	
			<td class="centr"> 
				<a class="remove-btn" onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del(\''.str_replace(' ','-',$_POST['badges_net_icons']).'\')"><i class="fa fa-times"></i></a>
				 <a href="javascript:cs_toggle(\''.str_replace(' ','-',$_POST['badges_net_icons']).'\')"><i class="fa fa-edit"></i></a>
			</td></tr> 
	
		</tr>';
		
		echo '<tr id="'.str_replace(' ','-',$_POST['badges_net_icons']).'" style="display:none">
			  <td colspan="3"><ul class="form-elements">
			  <li><a onclick="cs_toggle(\''.str_replace(' ','-',$_POST['badges_net_icons']).'\')"><i class="fa fa-times"></i></a></li>
				<li class="to-label">
					<label>Title</label>
				  </li>
				  <li class="to-field">
					<input class="small" type="text" id="badges_net_icons" name="badges_net_icons[]" value="'.$_POST['badges_net_icons'].'"  />
					<p>Please enter text for icon tooltip.</p>
				  </li>
				  <li class="to-label">
					<label>Short Text</label>
				  </li>
				  <li class="to-field">
					<input class="small" type="text" id="badges_net_icons_short_name" name="badges_net_icons_short_name[]" value="'.$_POST['badges_net_icons_short_name'].'"/>
					<p>Please enter Short Text.</p>
				  </li>
				  <li class="full">&nbsp;</li>
				  <li class="to-label">
					<label>Badge Image</label>
				  </li>
				  <li class="to-field">
					<input id="badges_net_icons_paths'.$counter_icon.'" name="badges_net_icons_paths[]" value="'.$_POST['badges_net_icons_paths'].'" type="text" class="small" />
					<label class="browse-icon"><input id="badges_net_icons_paths'.$counter_icon.'" name="badges_net_icons_paths'.$i.'" type="button" class="uploadMedia left" value="Browse"/></label>
				  </li>
				  <li class="full">&nbsp;</li>
				</ul></td>
			</tr>';
			$counter_icon++;
		die;
	
	}
	add_action('wp_ajax_add_badge', 'add_badge');
}

// Save Badges
if ( ! function_exists( 'cs_badge_save' ) ) {
	function cs_badge_save() {
		global $reset_date,$options;
		$_POST = edulms_stripslashes_htmlspecialchars($_POST);
		update_option( "cs_badges",$_POST );
		echo "Badges Saved";
		die();
	}
	add_action('wp_ajax_cs_badge_save', 'cs_badge_save');
}
