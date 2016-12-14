<?php
/**
 * Assignments Submission
 */
if ( ! function_exists( 'cs_assignment_submission' ) ) { 
	function cs_assignment_submission(){
		global $post;
		$user_id = cs_get_user_id();
			if ( $_SERVER["REQUEST_METHOD"] == "POST"){
				
				$user_assignments_title = trim($_POST['assignments_title']);
				if(strlen($user_assignments_title)< 1){
					echo '<p style="padding:15px;background-color: #f2dede;">Title Should not empty</p>';
					die();
				}
				$assignment_id = $_POST['assignment_id'];
				$user_assignments_description = $_POST['assignments_description'];
				$transaction_id = $_POST['transaction_id'];
				$course_id = $_POST['course_id'];
				$course_type = $_POST['course_type'];
				$assignment_passing_marks = 33;
				$assignment_retakes_no = 1;
				$assignment_upload_size = 2;
				$max_upload_size = 2;
				$filetitle='';
				$newupload = $uploadpath ='';
				$var_cp_assignment_description = '';
				$course_xml = get_post_meta($course_id, "cs_course", true);
				if ( $course_xml <> "" ) {
					$cs_course_xmlObject = new SimpleXMLElement($course_xml);
					if ( empty($cs_course_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = (string)"registered_user_access"; else $var_cp_course_paid = (string)$cs_course_xmlObject->var_cp_course_paid;
					if(count($cs_course_xmlObject->course_curriculms )>0){
						foreach ( $cs_course_xmlObject->course_curriculms as $curriculm ){
							$listing_type = $curriculm->listing_type;
							if($listing_type == 'assigment'){
								$var_cp_assignment_title_id = (string)$curriculm->var_cp_assignment_title;
								$var_cp_assignment_title = get_the_title((int)$var_cp_assignment_title_id);
								$var_cp_assignment_description = get_the_content((int)$var_cp_assignment_title_id);
								$assignment_id_value = $curriculm->assignment_id;
									if($var_cp_assignment_title_id == $assignment_id){
										 $assignment_passing_marks = (string)$curriculm->assignment_passing_marks;
										 $assignment_total_marks = (string)$curriculm->assignment_total_marks;
										 $assignment_upload_size = (int)$curriculm->assignment_upload_size;
										 $assignment_retakes_no = (string)$curriculm->assignment_retakes_no;
										 $var_cp_assigment_type = (string)$curriculm->var_cp_assigment_type;
										break;
									}
							}
						}
					}
				}
				$assignment_error = array();
				$user_id = $_POST['user_id'];
				if (strlen($_FILES['assignment_upload_attachment']['name']) > 3) {
					$uploadfiles = $_FILES['assignment_upload_attachment'];
					if (is_array($uploadfiles)) {
						$upload_dir = wp_upload_dir();
						  $post = get_post($assignment_id);
						  $var_cp_assignment_description = apply_filters('the_content', $post->post_content);;
						  $time = (!empty($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : (time() + (get_option('gmt_offset') * 3600)); // Fallback of now
						  $post_type = 'cs-assignments';
						  if (!empty($post)) {
							// Grab the posted date for use later
							$time = ($post->post_date == '0000-00-00 00:00:00') ? $time : strtotime($post->post_date);
							$post_type = $post->post_type;
						  }
						  $date = explode(" ", date('Y m d H i s', $time));
						 $timestamp = strtotime(date('Y m d H i s'));
						 if($post_type)
						 {
							  $upload_dir = array(
								'path' => WP_CONTENT_DIR . '/uploads/' . $post_type . '/' . $date[0],
								'url' => WP_CONTENT_URL . '/uploads/' . $post_type . '/' . $date[0],
								'subdir' => '',
								'basedir' => WP_CONTENT_DIR . '/uploads',
								'baseurl' => WP_CONTENT_URL . '/uploads',
								'error' => false,
							  );
						 }
						if(!is_dir($upload_dir['path'])){
						   wp_mkdir_p($upload_dir['path']);
						}
						$uploadfiles = array(
							'name'     => $_FILES['assignment_upload_attachment']['name'],
							'type'     => $_FILES['assignment_upload_attachment']['type'],
							'tmp_name' => $_FILES['assignment_upload_attachment']['tmp_name'],
							'error'    => $_FILES['assignment_upload_attachment']['error'],
							'size'     => $_FILES['assignment_upload_attachment']['size']
						);
						$error_assignment = 0;
					  // look only for uploded files
					  if ($uploadfiles['error'] == 0) {
						$filetmp = $uploadfiles['tmp_name'];
						$filename = $uploadfiles['name'];
						$filesize = $uploadfiles['size'];
						$max_upload_size = $assignment_upload_size*1048576;
 						if($max_upload_size<$filesize){
							$assignment_error[] = '<p style="padding:15px;background-color: #f2dede;">Maximum upload File size allowed '.$assignment_upload_size.'MB</p>';
							$error_assignment = 1;
						}
							$file_type_match = 0;
							$var_cp_assigment_type_array = array();
							 if($var_cp_assigment_type){
								 $var_cp_assigment_type_array = explode(',',$var_cp_assigment_type);
							 }
							 if(in_array($uploadfiles['type'], $var_cp_assigment_type_array)){
								$file_type_match = 1;
							 }
							 /**
							 * Check File Size
							 */
							if($file_type_match <> 1){
								$assignment_error[] = '<p style="padding:15px;background-color: #f2dede;">Please upload file with extension'.$var_cp_assigment_type.'</p>';
								$error_assignment = 1;
							}
							// get file info
							// @fixme: wp checks the file extension....
							$filetype = wp_check_filetype( basename( $filename ), null );
							$filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
							$filename = $filetitle . $timestamp . '.' . $filetype['ext'];
							/**
							 * Check if the filename already exist in the directory and rename the
							 * file if necessary
							 */
							$i = 0;
							while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
							  $filename = $filetitle . $timestamp . '_' . $i . '.' . $filetype['ext'];
							  $i++;
							}
							$filedest = $upload_dir['path'] . '/' . $filename;
							/**
							 * Check write permissions
							 */
							if ( !is_writeable( $upload_dir['path'] ) ) {
							  $assignment_error[] = '<p style="padding:15px;background-color: #f2dede;">Unable to write to directory %s. Is this directory writable by the server?</p>';
							  $error_assignment = 1;
							}
							/**
							 * Save temporary file to uploads dir
							 */
							if($error_assignment <> 1){
								if ( !@move_uploaded_file($filetmp, $filedest) ){
								  $assignment_error[] = '<p style="padding:15px;background-color: #f2dede;">Error, the file $filetmp could not moved to : $filedest ';
								  $error_assignment = 1;
								}
								$newupload = $upload_dir['url'].'/'.$filename;
								$uploadpath = $upload_dir['path'].'/'.$filename;
							}
						  }
					  }
				}else{
						echo '<p style="padding:15px;background-color: #f2dede;">Please Upload a File</p>';
						die();
				}
				if($error_assignment == 1){
					foreach($assignment_error as $error_value){
						echo __($error_value, 'EDULMS');	
						echo '<br/>';
					}
					die();
				}				
				$assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
				$assignment_complete = get_option($assignment_complete_key);
				if(!isset($assignment_complete)){
					$assignment_complete = 1;
					update_option($assignment_complete_key, '1');
				} else if(isset($assignment_complete) && $assignment_complete == ''){
					$assignment_complete = 1;
					update_option($assignment_complete_key, '1');
				}
				$user_assingments_array  = array();
				$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
				
				$assingment_ids_info = array();
				if (isset($user_assingments_array[$transaction_id]) && is_array($user_assingments_array[$transaction_id]) && array_key_exists('assingment_ids_info', $user_assingments_array[$transaction_id])) {
					$assingment_ids_info = $user_assingments_array[$transaction_id]['assingment_ids_info'];
				}
				$assingment_ids_info[] = $assignment_id;
				$user_assingments_array[$transaction_id]['assingment_ids_info'] = array_unique($assingment_ids_info);
				$assingment_id_array = array();
				if(isset($user_assingments_array[$transaction_id][$assignment_id]) && is_array($user_assingments_array[$transaction_id][$assignment_id])){
					$assingment_id_array = $user_assingments_array[$transaction_id][$assignment_id];
				}
				$user_information = get_userdata((int)$user_id);
				// Course Assignment Information
				$var_cp_course_instructor = get_post_meta( $course_id, 'var_cp_course_instructor', true);
				$user_display_name = $user_information->user_login;
				$course_instructor = '';
				if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
					$user_info = get_userdata((int)$var_cp_course_instructor);
					$course_instructor = $user_info->user_login;
				}
				$assignment_info_array = array();
				$assignment_info_array['course_id'] = $course_id;
				$assignment_info_array['course_title'] = get_the_title($course_id);
				$assignment_info_array['course_type'] = $var_cp_course_paid;
				$assignment_info_array['course_instructor'] = $course_instructor;
				$assignment_info_array['user_login'] = $user_display_name;
				$assignment_info_array['assignments_title'] = (string)$var_cp_assignment_title;
				$assignment_info_array['assignments_description'] = (string)$var_cp_assignment_description;
				$assignment_info_array['assignment_retakes_no'] = (string)$assignment_retakes_no;
				$assignment_info_array['assignment_upload_size'] = (int)$assignment_upload_size;
				$assignment_info_array['assignment_passing_marks'] = (string)$assignment_passing_marks;
				$assignment_info_array['assignment_total_marks'] = (string)$assignment_total_marks;
				$assignment_info_array['assignment_id'] = (string)$assignment_id;
				$assignment_info_array['var_cp_assigment_type'] = (string)$var_cp_assigment_type;
				$user_assingments_array[$transaction_id][$assignment_id]['course_assignment_info'] = $assignment_info_array;
				
				$assingment_attempt_info = array();
				if (array_key_exists('assingment_attempt_info', $user_assingments_array[$transaction_id])) {
					$assingment_attempt_info = $user_assingments_array[$transaction_id][$assignment_id]['assingment_attempt_info'];
				}
				$assingment_attempt_info['assignment_attempt_no'] = $assignment_complete+1;
				$user_assingments_array[$transaction_id][$assignment_id]['assingment_attempt_info'] = $assingment_attempt_info;
				$user_email = $user_information->user_email;
				$assignment_user_array = array();
				$assignment_user_array['user_assignments_title'] = $user_assignments_title;
				$assignment_user_array['user_assignments_description'] = $user_assignments_description;
				$assignment_user_array['user_id'] = $user_id;
				$assignment_user_array['user_email'] = $user_email;
				$assignment_user_array['ip_address'] = cs_getIp();
				$assignment_user_array['course_id'] = $course_id;
				$assignment_user_array['assignments_id'] = $assignment_id;
				$assignment_user_array['assignment_upload_attachment_title'] = $filetitle;
				$assignment_user_array['assignment_upload_attachment'] = $newupload;
				$assignment_user_array['assignment_upload_path'] = addslashes($uploadpath);
				$assignment_user_array['transaction_id'] = $transaction_id;
				$assignment_user_array['attempt_date'] = date('Y-m-d H:i:s');
				$assignment_user_array['assignment_marks'] = '';
				$assignment_user_array['assignment_remarks'] = '';
				$assignment_user_array['review_status'] = 'Pending';
				$assignment_user_array['assignment_retake'] = $assignment_retakes_no;
				$user_assingments_array[$transaction_id][$assignment_id][$assignment_complete]['assignment_data'] = $assignment_user_array;
				update_user_meta($user_id, "cs-user-assignments", $user_assingments_array);
				//$user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
				$assignment_complete++;
				update_option($assignment_complete_key, $assignment_complete);
				echo '<p style="padding:15px;background-color: #dff0d8;">Your assignment submitted successfully.</div>';
				die();
		}
		exit;
	}
	add_action('wp_ajax_cs_assignment_submission', 'cs_assignment_submission');
}

/**
 * Assignment Record Listing
 */
if ( ! function_exists( 'cs_user_assignment_record_ajax' ) ) { 
	function cs_user_assignment_record_ajax(){
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
				$assignment_upload_attachment = $user_assignment_data['assignment_upload_attachment'];
				if(isset($user_assignment_data['assignment_upload_attachment_title']))
					$assignment_upload_attachment_title = $user_assignment_data['assignment_upload_attachment_title'];
				else 
					$assignment_upload_attachment_title = $assignment_upload_attachment;
				$result_percentage = 0;
				if($assignment_marks > 0 && $question_marks_points>0)
					$result_percentage = ($assignment_marks/$question_marks_points)*100;
				
				if($assignment_marks == '')
					$assignment_marks = '-';
				
				?>
				 <h2 class="result-heading"><i class="fa fa-question-circle"></i><?php echo esc_attr($assignments_title .' - '.$course_title);;?></h2>
				 <div class="textarea-sec">
				   <p><?php echo balanceTags($assignments_description, true);?></p>
				</div>
					<h3 class="result-heading"><?php _e('User Assignment','EDULMS');?></h3>
					<div class="textarea-sec">
						<h5><?php echo esc_attr($user_assignments_title);?></h5>
						<textarea class="bg-textarea" disabled="disabled"><?php echo esc_attr($user_assignments_description);?></textarea>
					</div>
					<ul class="files-sec">
						<li>
						   <?php if($assignment_upload_attachment <> ''){?>
								<a href="<?php echo esc_attr($assignment_upload_attachment);?>" target="_blank"><i class="fa fa-file-archive-o"></i><?php echo esc_attr($assignment_upload_attachment_title);?></a>
							<?php }?>
							<span><?php _e('Uploaded on','EDULMS');?>: <?php echo esc_attr($attempt_date);?></span>
						</li>
					</ul>
					<?php
						$question_text_field_id = $transaction_id.'_'.$assignment_id.'_'.$attempt_no.'_'.$user_id.'_assignment';
					?>
					<div class="textarea-sec">
						<h6><?php _e('Remarks','EDULMS');?></h6>
						<textarea class="bg-textarea" id="<?php echo esc_attr($question_text_field_id);?>-remarks"><?php echo esc_attr($assignment_remarks);?></textarea>
					</div>
					 <div class="textarea-sec">
						<h6><?php _e('Review Status','EDULMS');?>: <?php echo esc_attr($review_status);?></h6>
					</div>
					<div id="<?php echo esc_attr($question_text_field_id);?>-loading"></div>
					<div class="score-sec">
						<ul class="left-sec">
							<li>
								<label><?php _e('Score','EDULMS');?></label>
								<span><?php echo esc_attr($assignment_marks.'/'.$assignment_total_marks);?></span>
							
							</li>
						</ul>
					</div> 
				<?php
			} else {
				_e('There are no questions against this Assignment','EDULMS');
			}
		exit;
	}
	add_action('wp_ajax_cs_user_assignment_record_ajax', 'cs_user_assignment_record_ajax');
}


//add_filter('upload_dir', 'cs_assignment_upload_dir');
//$upload = wp_upload_dir();
function cs_assignment_upload_dir( $upload ) {
	$id = $_REQUEST['post_id'];
	$parent = get_post( $id )->post_parent;
	if( "cs-assignments" == get_post_type( $id ) || "cs-assignments" == get_post_type( $parent ) )
	$upload['subdir'] = '/assignments-dir' . $upload['subdir'];
	$upload['path'] = $upload['basedir'] . $upload['subdir'];
	$upload['url']  = $upload['baseurl'] . $upload['subdir'];
	return $upload;
}

function fileupload_process() { 
  $uploadfiles = $_FILES['assignment_upload_attachment'];

  if (is_array($uploadfiles)) {

    foreach ($uploadfiles['name'] as $key => $value) {

      // look only for uploded files
      if ($uploadfiles['error'][$key] == 0) {

        $filetmp = $uploadfiles['tmp_name'][$key];

        //clean filename and extract extension
        $filename = $uploadfiles['name'][$key];

        // get file info
        // @fixme: wp checks the file extension....
        $filetype = wp_check_filetype( basename( $filename ), null );
        $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
        $filename = $filetitle . '.' . $filetype['ext'];
        $upload_dir = wp_upload_dir();

        /**
         * Check if the filename already exist in the directory and rename the
         * file if necessary
         */
        $i = 0;
        while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
          $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
          $i++;
        }
        $filedest = $upload_dir['path'] . '/' . $filename;

        /**
         * Check write permissions
         */
        if ( !is_writeable( $upload_dir['path'] ) ) {
          $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
          return;
        }

        /**
         * Save temporary file to uploads dir
         */
        if ( !@move_uploaded_file($filetmp, $filedest) ){
          $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
          continue;
        }

        $attachment = array(
          'post_mime_type' => $filetype['type'],
          'post_title' => $filetitle,
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $filedest );
        require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filedest );
        wp_update_attachment_metadata( $attach_id,  $attach_data );
      }
    }
  }
}