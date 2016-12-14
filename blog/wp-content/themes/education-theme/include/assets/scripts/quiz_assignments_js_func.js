	function cs_user_quiz_assignment_record(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course){
			var dataString = 'transaction_id=' + transaction_id + 
					  '&quiz_id=' + quiz_id +
					  '&attempt_no=' + attempt_no +
					  '&user_id=' + user_id +
					  '&course_id=' + course_id +
					  '&action=cs_admin_user_quiz_assignment_record_ajax';
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
	
	function cs_user_quiz_assignment_record_report(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course){
			
			//jQuery(".toggle-div-class-"+counter_course).show();
			var dataString = 'transaction_id=' + transaction_id + 
					  '&quiz_id=' + quiz_id +
					  '&attempt_no=' + attempt_no +
					  '&user_id=' + user_id +
					  '&course_id=' + course_id +
					  '&action=cs_admin_user_quiz_assignment_record_ajax';
			jQuery("#toggle-div-data-"+counter_course).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					//jQuery('#toggle-div-'+counter_course).slideToggle('100', function() {});
					jQuery("#toggle-div-data-"+counter_course).html(response);
					jQuery("#toggle-"+counter_course).prop("onclick", null);
					jQuery(".toggle-div-class-"+counter_course).show();
				}
			});
			return false;
	}
	
			
	function cs_user_assignment_record(transaction_id,assignment_id,attempt_no,user_id,course_id,admin_url, counter_courses){
			var dataString = 'transaction_id=' + transaction_id + 
					  '&assignment_id=' + assignment_id +
					  '&attempt_no=' + attempt_no +
					  '&user_id=' + user_id +
					  '&course_id=' + course_id +
					  '&action=cs_admin_user_assignment_record_ajax';
			jQuery("#toggle-div-data-"+counter_courses).html('<i  class="fa fa-spinner fa-spin fa-2x"></i>');
			//jQuery("#toggle-div-"+counter_courses).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					//
					jQuery("#toggle-div-data-"+counter_courses).html(response);
					jQuery("#toggle-"+counter_courses).prop("onclick", null);
					jQuery(".toggle-div-class-"+counter_courses).addClass("cs-click").fadeIn(200);
					
				}
			});
			return false;
	}
	
	function cs_quiz_question_update_marks(transaction_id,quiz_id,attempt_no,user_id,question_id,question_text_field_id,admin_url, status_id){
			var review_status= jQuery("#"+status_id+"-review").val();
			var question_point_marks = jQuery("#"+question_text_field_id).val();
			var dataString = 'transaction_id=' + transaction_id + 
					  '&quiz_id=' + quiz_id +
					  '&attempt_no=' + attempt_no +
					  '&user_id=' + user_id +
					  '&question_point_marks=' + question_point_marks +
					  '&question_id=' + question_id +
					  '&review_status=' + review_status +
					  '&action=cs_quiz_question_update_marks_ajax';
			jQuery("#"+question_text_field_id+"-loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					jQuery("#"+question_text_field_id+"-loading").html(response);
					//jQuery("#toggle-"+counter_course).prop("onclick", null);
				}
			});
			return false;
	}

	
	function cs_assignment_question_update_marks(transaction_id,assignment_id,attempt_no,user_id,question_text_field_id,admin_url){
			var question_point_marks = jQuery("#"+question_text_field_id).val();
			var assignment_remarks = jQuery("#"+question_text_field_id+'-remarks').val();
			var assignment_review_status = jQuery("#"+question_text_field_id+'-review').val();
			var dataString = 'transaction_id=' + transaction_id + 
					  '&assignment_id=' + assignment_id +
					  '&attempt_no=' + attempt_no +
					  '&assignment_remarks=' + assignment_remarks +
					  '&user_id=' + user_id +
					  '&review_status=' + assignment_review_status +
					  '&question_point_marks=' + question_point_marks +
					  '&action=cs_assignments_question_update_marks_ajax';
			jQuery("#"+question_text_field_id+"-loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					jQuery("#"+question_text_field_id+"-loading").html(response);
					//jQuery("#toggle-"+counter_course).prop("onclick", null);
				}
			});
			return false;
	}
	
	
	function cs_user_daily_earning_record(year,month,admin_url,counter_year_month){
			var dataString = 'year=' + year + 
					  '&month=' + month +
					  '&counter_year_month=' + counter_year_month +
					  '&action=cs_admin_daily_earning_record_ajax';
			jQuery("#toggle-div-"+counter_year_month).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					jQuery("#toggle-div-"+counter_year_month).html(response);
					jQuery("#toggle-"+counter_year_month).prop("onclick", null);
				}
			});
			return false;
	}
	
	function cs_user_course_complete_backup(transaction_id,course_id,user_id,admin_url){
		var dataString = 'transaction_id=' + transaction_id + 
					  '&course_id=' + course_id +
					  '&user_id=' + user_id +
					  '&action=cs_user_course_complete_backup_ajax';
			jQuery("#"+question_text_field_id+"-loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
					jQuery("#"+question_text_field_id+"-loading").html(response);
					//jQuery("#toggle-"+counter_course).prop("onclick", null);
				}
			});
			return false;
		
	}