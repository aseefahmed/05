/* ---------------------------------------------------------------------------
	* FAQ Submission
 	* --------------------------------------------------------------------------- */
	function cs_faqs_submission(admin_url, url) {
		var dataString = 'course_id=' + jQuery("#course_id").val() +
			'&user_email=' + jQuery("#faqs_email").val() +
			'&faq_user=' + jQuery("#faqs_user").val() +
			'&faq_quest=' + jQuery("#faqs_question").val() +
			'&action=cs_faq_question_add';
			
		jQuery("#loading").html("<img src='" + url + "assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type: "POST",
			url: admin_url,
			data: dataString,
			success: function(response) {
				jQuery("#loading").html("");
				jQuery("#add_ques_response").html(response);
				jQuery("#add_ques_response").show();
				jQuery("#faqs_user").val('');
				jQuery("#faqs_email").val('');
				jQuery("#faqs_question").val('');
			}
		});
	}
	
/* ---------------------------------------------------------------------------
	* FAQ Email Submission
 	* --------------------------------------------------------------------------- */	
	function cs_faqs_email(admin_url, url, faq_id) {
		var dataString = 'faq_id=' + faq_id +
			'&email_subject=' + jQuery("#faq_email_subject").val() +
			'&emai_message=' + jQuery("#faq_email_message").val() +
			'&action=cs_faqs_email_submit';
			
		jQuery("#loading").html("<img src='" + url + "assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type: "POST",
			url: admin_url,
			data: dataString,
			success: function(response) {
				jQuery("#loading").html("");
				jQuery("#email-response-msg").html(response);
				jQuery("#email-response-msg").show();
			}
		});
	}

/* ---------------------------------------------------------------------------
	* Quiz Submisstions
 	* --------------------------------------------------------------------------- */
	function cs_quiz_submission(admin_url){
		'use strict';
		jQuery(".loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		 jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:jQuery('#quiz-form').serialize(), 
			success:function(response){
				jQuery("#quiz").html(response);
				jQuery(".ans-section").hide();
				jQuery(".loading").html('');
				//jQuery("#quiz-form").html(response);
			}
		});
		return false;
	}
	
	
/* ---------------------------------------------------------------------------
	* single quiz submission
 	* --------------------------------------------------------------------------- */
	function cs_single_quiz_submission(admin_url,question_no,total_questions,question_key, current_value){
		'use strict';
		jQuery(".loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		var data = jQuery('#quiz-form').serialize();
		var dataString = 'question_no=' + question_no + 
				  '&total_questions=' + total_questions +
				  '&question_key=' + question_key +
				  '&question_data=' + data +
				  '&action=cs_quiz_single_question_submit';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				if(question_no == total_questions){
					jQuery("#quiz").html(response);
					jQuery(".ans-section").hide();
				}
				jQuery(".question"+question_no).hide();
				question_no++;
				jQuery(".question"+question_no).show();
				current_value++;
				jQuery( ".quiz-pagination li" ).removeClass( "active" );
				jQuery('ul.quiz-pagination li.'+current_value+'-class').addClass('active');
				
				
				jQuery(".loading").html(response);
			}
		});
		return false;
	}


/* ---------------------------------------------------------------------------
	* Quiz Submisstions
 	* --------------------------------------------------------------------------- */
	function cs_free_quiz_submission(admin_url){
		'use strict';
		 jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:jQuery('#quiz-form').serialize(), 
			success:function(response){
				jQuery("#quiz").html(response);
				jQuery(".ans-section").hide();
				
				//jQuery("#quiz-form").html(response);
			}
		});
		return false;
	}

/* ---------------------------------------------------------------------------
	* single quiz submission
 	* --------------------------------------------------------------------------- */
	function cs_single_free_quiz_submission(admin_url,question_no,total_questions,question_key){
		'use strict';
		var data = jQuery('#quiz-form').serialize();
		var dataString = 'question_no=' + question_no + 
				  '&total_questions=' + total_questions +
				  '&question_key=' + question_key +
				  '&question_data=' + data +
				  '&action=cs_free_quiz_single_question_submit';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				if(question_no == total_questions){
					jQuery("#quiz").html(response);
					jQuery(".ans-section").hide();
				}
				jQuery(".question"+question_no).hide();
				question_no++;
				jQuery(".question"+question_no).show();
				jQuery(".loading").html(response);
			}
		});
		return false;
	}
	
	/* ---------------------------------------------------------------------------
	* Quiz Submisstions
 	* --------------------------------------------------------------------------- */
	function cs_registereduser_quiz_submission(admin_url){
		'use strict';
		jQuery(".loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		 jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:jQuery('#quiz-form').serialize(), 
			success:function(response){
				jQuery("#quiz").html(response);
				jQuery(".ans-section").hide();
				jQuery(".loading").html('');
				
				//jQuery("#quiz-form").html(response);
			}
		});
		return false;
	}
	
	/* ---------------------------------------------------------------------------
	* single quiz submission
 	* --------------------------------------------------------------------------- */
	function cs_single_registered_user_quiz_submission(admin_url,question_no,total_questions,question_key, current_value){
		'use strict';
		
		var data = jQuery('#quiz-form').serialize();
		jQuery(".loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		var dataString = 'question_no=' + question_no + 
				  '&total_questions=' + total_questions +
				  '&question_key=' + question_key +
				  '&question_data=' + data +
				  '&action=cs_registered_user_quiz_single_question_submit';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				if(question_no == total_questions){
					jQuery("#quiz").html(response);
					jQuery(".ans-section").hide();
				}
				jQuery(".question"+question_no).hide();
				question_no++;
				jQuery(".question"+question_no).show();
				jQuery(".loading").html(response);
				current_value++;
				jQuery( ".quiz-pagination li" ).removeClass( "active" );
				jQuery('ul.quiz-pagination li.'+current_value+'-class').addClass('active');
				
				
				
			}
		});
		return false;
	}


/* ---------------------------------------------------------------------------
	* quiz results 
 	* --------------------------------------------------------------------------- */
	function cs_quiz_result_remarks_js(admin_url){
		'use strict';
		jQuery(".loading").html('<i class="fa fa-spin"></i>');
		 jQuery.ajax({
				type:"POST",
				url: admin_url,
					data:jQuery('#quiz-result-form').serialize(), 
					success:function(response){
						jQuery(".loading").html(response);
						jQuery("#quiz-form").html(response);
					}
		});
		return false;
	}

/* ---------------------------------------------------------------------------
	* quiz pagination 
 	* --------------------------------------------------------------------------- */	
	function cs_quiz_pagination(current_value, total_record){
		'use strict';
		for(var i=1; i<=total_record; i++){
			jQuery('.question'+i).hide();
		}	
		
		jQuery('.question'+current_value).show();
		jQuery( ".quiz-pagination li" ).removeClass( "active" );
		jQuery('ul.quiz-pagination li.'+current_value+'-class').addClass('active');
		return false;
	}
	
/* ---------------------------------------------------------------------------
	* quiz results show pagination(
 	* --------------------------------------------------------------------------- */
	function cs_quiz_result_show_pagination(start_value,current_value, total_record, pagination_value){
		'use strict';
		for(var i=start_value; i<=total_record; i++){
			jQuery('.question-'+i).hide();
		}	
		jQuery('.question-'+current_value).show();
		jQuery( ".quiz-pagination li" ).removeClass( "active" );
		jQuery('ul.quiz-pagination li.'+pagination_value+'-class').addClass('active');
		
		return false;
	}
/* ---------------------------------------------------------------------------
	* Add reviews
 	* --------------------------------------------------------------------------- */
	function cs_reviews_submission(admin_url,theme_url){
		'use strict';
		jQuery("#loading").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			dataType: "json",
			data:jQuery('#cs-reviews-form').serialize(), 
			success:function(response){
				jQuery("#loading").html('');
				jQuery(".review-message-type").html(response.message);
				jQuery(".review-message-type").show();
				jQuery(".modal-footer").remove();
				jQuery(".add_review_btn").remove();
				jQuery(".modal-backdrop").remove();
				//jQuery(".no-review").remove();
				//modal-backdrop
				//jQuery(".").html(response);
			}
		});
		return false;
	}
/* ---------------------------------------------------------------------------
	* user assignment submission
 	* --------------------------------------------------------------------------- */
	function cs_assignments_submission(admin_url,theme_url, assignment_coutner){
		'use strict';
		jQuery("#loading").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		//var formData = new FormData($(this)[0]);
		var datastring = new FormData(document.getElementById("cs-assignments-form"));
		 jQuery.ajax({
			url: admin_url,
			type: 'POST',
			//data: jQuery('#cs-assignments-form').serialize()+'&attachment='fd,
			data: datastring,
			async: false,
			success:function(response){
				if(response == 'Your assignment submitted successfully.'){
					jQuery("#cs-assignments-form").remove();
					jQuery(".add-assignment-btn").remove();
					jQuery("#loading").html(response);
				} else {
					jQuery("#loading").html(response);
					//jQuery(".cs-assignments-listing").append(response);
					return false;
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	}
/* ---------------------------------------------------------------------------
	* Curriculum Mark Read
 	* --------------------------------------------------------------------------- */
	function cs_curriculm_mark_read(post_id,admin_url,theme_url){
		'use strict';
		jQuery(".curriculm-mark-read-btn").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
		//var formData = new FormData($(this)[0]);
		var dataString = 'post_id=' + post_id + '&action=cs_curriculm_read';
			jQuery.ajax({
			url: admin_url,
			type: 'POST',
			// data: jQuery('#cs-assignments-form').serialize()+'&attachment='fd,
			data: dataString,
			async: false,
			success:function(response){
				jQuery(".curriculm-mark-read-btn").html(response);
			}
		 });
		return false;
	}
	/* ---------------------------------------------------------------------------
	* user subscribed Course backup
 	* --------------------------------------------------------------------------- */
	
	function cs_user_course_complete__backup(transaction_id,course_id,user_id,complete_dynmc_cls,admin_url){
		var dataString = 'transaction_id=' + transaction_id + 
					  '&course_id=' + course_id +
					  '&user_id=' + user_id +
					  '&action=cs_user_course_complete_backup_ajax';
			jQuery("."+complete_dynmc_cls).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data:dataString, 
				success:function(response){
						jQuery("."+complete_dynmc_cls).html(response);
						jQuery("."+complete_dynmc_cls).prop("onclick", null);
				}
			});
			return false;
		
	}
	
	

	// user Assignment Record
	function cs_user_quiz_assignment_record(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course,quiz_type){
		'use strict';
		var dataString = 'transaction_id=' + transaction_id + 
				  '&quiz_id=' + quiz_id +
				  '&attempt_no=' + attempt_no +
				  '&user_id=' + user_id +
				  '&quiz_type=' + quiz_type +
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
	// Quiz Report
	function cs_user_quiz_assignment_record_report(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course,quiz_type){
		'use strict';	
		var dataString = 'transaction_id=' + transaction_id + 
				  '&quiz_id=' + quiz_id +
				  '&attempt_no=' + attempt_no +
				  '&user_id=' + user_id +
				  '&quiz_type=' + quiz_type +
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
	
	// Quiz Report Delete
	function cs_user_quiz_assignment_record_report_del(transaction_id,quiz_id,attempt_no,user_id,course_id,admin_url, counter_course, quiz_type){
		'use strict';	
		var dataString = 'transaction_id=' + transaction_id + 
				  '&quiz_id=' + quiz_id +
				  '&attempt_no=' + attempt_no +
				  '&user_id=' + user_id +
				  '&quiz_type=' + quiz_type +
				  '&course_id=' + course_id +
				  '&action=cs_admin_user_quiz_record_del_ajax';
		jQuery("#toggle-div-data-"+counter_course).html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				//jQuery('#toggle-div-'+counter_course).slideToggle('100', function() {});.delay(3000).fadeOut("slow");
				jQuery("#toggle-div-data-"+counter_course).html(response).delay(3000000).fadeOut("slow");
				jQuery("#toggle-div-data-"+counter_course).remove();
				jQuery("#quiz-row-"+counter_course).remove();
				jQuery(".toggle-div-class-"+counter_course).remove();
				
			}
		});
		return false;
	}
	
	// user Assignment Record
	function cs_user_assignment_record(transaction_id,assignment_id,attempt_no,user_id,course_id,admin_url, counter_courses){
		'use strict';
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
	
	// user Assignment Record Delete
	function cs_user_assignment_record_del(transaction_id,assignment_id,attempt_no,user_id,course_id,admin_url, counter_courses){
		'use strict';
		var dataString = 'transaction_id=' + transaction_id + 
				  '&assignment_id=' + assignment_id +
				  '&attempt_no=' + attempt_no +
				  '&user_id=' + user_id +
				  '&course_id=' + course_id +
				  '&action=cs_admin_user_assignment_record_del_ajax';
		jQuery("#toggle-div-data-"+counter_courses).html('<i  class="fa fa-spinner fa-spin fa-2x"></i>');
		
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				jQuery("#toggle-div-data-"+counter_courses).html(response).delay(3000000).fadeOut("slow");
				jQuery("#toggle-div-data-"+counter_courses).remove();
				jQuery("#assignment-row-"+counter_courses).remove();
				//jQuery("#toggle-"+counter_courses).prop("onclick", null);
				//jQuery(".toggle-div-class-"+counter_courses).addClass("cs-click").fadeIn(200);
				
			}
		});
		return false;
	}
	// Quiz Question update marks
	function cs_quiz_question_update_marks(transaction_id,quiz_id,attempt_no,user_id,question_id,question_text_field_id,admin_url, status_id, course_id, quiz_type){
		'use strict';
		var review_status= jQuery("#"+status_id+"-review").val();
		var question_point_marks = jQuery("#"+question_text_field_id).val();
		var dataString = 'transaction_id=' + transaction_id + 
				  '&quiz_id=' + quiz_id +
				  '&attempt_no=' + attempt_no +
				  '&user_id=' + user_id +
				  '&question_point_marks=' + question_point_marks +
				  '&question_id=' + question_id +
				  '&review_status=' + review_status +
				  '&course_id=' + course_id +
				  '&quiz_type=' + quiz_type +
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

	// Assignment update marks
	function cs_assignment_question_update_marks(transaction_id,assignment_id,attempt_no,user_id,question_text_field_id,admin_url){
		'use strict';
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
	
	 // User Daily Earning Record
	function cs_user_daily_earning_record(year,month,admin_url,counter_year_month){
		'use strict';
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
	// User Course Complete backup	
	function cs_user_course_complete_backup(transaction_id,course_id,user_id,admin_url){
		'use strict';
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
	// course detail record
	function cs_courses_quiz_assignment_record(transaction_id,user_id,course_id,admin_url, counter_course){
		'use strict';
		var dataString = 'transaction_id=' + transaction_id + 
				  '&user_id=' + user_id +
				  '&course_id=' + course_id +
				  '&action=cs_courses_quiz_assignment_records_ajax';
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
	// Course Complete backup	
	function cs_courses_complete_quiz_assignment_record(transaction_id,user_id,course_id,admin_url, counter_course){
		'use strict';
		var dataString = 'transaction_id=' + transaction_id + 
				  '&user_id=' + user_id +
				  '&course_id=' + course_id +
				  '&action=cs_courses_complete_quiz_assignment_record_ajax';
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
	
	
	var counter_question = 0;
	function add_question_to_list(admin_url, theme_url) {
		//total_tracks
		var counter_question = jQuery('#total_tracks tr').length;
		counter_question++;
		var answer_data = '';
		var answer_data_titles = '';
		var answer_type = jQuery("#answer_type").val();
		var answer_single_ration_option = jQuery("#answer_single_ration_option").val();
		if (answer_type == 'single-option') {
			answer_data = '&answer_title_single_option_1=' + jQuery("#answer_title_single_option_1").val() +
				'&answer_title_single_option_1_true=' + jQuery("#answer_title_single_option_1_true").val() +
				'&answer_title_single_option_2=' + jQuery("#answer_title_single_option_2").val() +
				'&answer_title_single_option_2_true=' + jQuery("#answer_title_single_option_2_true").val();
		} else if (answer_type == 'multiple-option') {
			var counter_multipleoptions = 0;
			jQuery('#multiple-option input.multipleoption-class').each(function() {
				counter_multipleoptions++;
				var attname = jQuery(this).attr("name");
				var attvalue = jQuery(this).val();
				answer_data_titles = answer_data_titles + '&' + attname + '=' + attvalue;
			});
			
			var answer_data_answer = '';
			jQuery('#multiple-option input.multipleoption-answer-class').each(function() {
				var attname = jQuery(this).attr("name");
				if (jQuery(this).is(':checked')) {
					var attvalue = 'correct';
				} else {
					var attvalue = 'wrong';
				}
				answer_data_answer = answer_data_answer + '&' + attname + '=' + attvalue;
			});
			var counter_multipleoptions = jQuery('#multiple-option input.multipleoption-class').length;
			answer_data = answer_data_titles + answer_data_answer + '&counter_multipleoptions=' + counter_multipleoptions;
		} else if (answer_type == 'one-word-answer') {
			answer_data = '&answer_title_one_word=' + jQuery("#answer_title_one_word").val();
		} else if (answer_type == 'large-text') {
			answer_data = '&answer_large_text=' + jQuery("#answer_large_text").val();
		} else if (answer_type == 'true-false') {
			if (jQuery("input[type='radio'].radioBtnClass").is(':checked')) {
				answer_data = '&true_false_correnct_answer=' + jQuery("input[type='radio'].radioBtnClass:checked").val();
			} else {
				answer_data = '&true_false_correnct_answer=wrong';
			}
		}
		//alert(answer_data);
		//return false;
		jQuery( "input:checkbox:checked" ).val();
		var isChecked = jQuery('#answer_single_radio_option').is(':checked');
		if(isChecked){
			var single_radio_option = jQuery("#answer_single_radio_option").val();
		} else {
			var single_radio_option = '';
		}

		
		var dataString = 'counter_question=' + counter_question +
			'&question_title=' + jQuery("#question_title").val() +
			'&question_marks=' + jQuery("#question_marks").val() +
			'&answer_single_radio_option=' + single_radio_option +
			'&answer_type=' + jQuery("#answer_type").val() + answer_data +
		'&action=cs_add_questions_to_list';
		jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type: "POST",
			url: admin_url + "/admin-ajax.php",
			data: dataString,
			success: function(response) {
				jQuery("#total_tracks").append(response);
				jQuery("#loading").html("");
				closepopedup('add_track');
				jQuery("#question_title").val("Question Title");
				//jQuery("#question_marks").val("");
				jQuery("#answer_type").val(jQuery("#answer_type").val());
			}
		});
		//return false;
	}
	
	// Change Answer Type
	function cs_change_answer_type(id) {
		jQuery("#multiple-option").hide();
		jQuery("#one-word-answer").hide();
		jQuery("#true-false").hide();
		jQuery("#large-text").hide();
		jQuery("#" + id).show();
	}
	
	jQuery(document).ready(function($) {
		var MaxInputs = 10; //maximum input boxes allowed
		var InputsWrapper = jQuery("#multiple-answer-option"); //Input boxes wrapper ID
		var AddButton = jQuery("#AddMoreFileBox"); //Add button ID
		var x = InputsWrapper.length; //initlal text box count
		var FieldCount = 2; //to keep track of text box added
		jQuery(AddButton).click(function(e) //on add input button click
			{
				if (x <= MaxInputs) //max input box allowed
				{
					FieldCount++; //text box added increment
					//add input box
					var textfielddiv = '<ul class="form-elements"><li class="to-label"><label>Answer Title ' + FieldCount + '</label></li><li class="to-field"><input type="text" id="answer_title_multiple_option_' + FieldCount + '" name="answer_title_multiple_option_' + FieldCount + '"  class="multipleoption-class" /></li><li class="to-label"><ul class="check-box"><li><div class="checkbox"><input type="checkbox" id="answer_title_multiple_option_correct_' + FieldCount + '" name="answer_title_multiple_option_correct_' + FieldCount + '" value="correct" class="multipleoption-answer-class" /><label for="answer_title_multiple_option_correct_' + FieldCount + '">Correct answer?</label></div></li></ul></li><li class="to-label red"><label><i class="fa fa-times"></i> Remove</label></li></ul>';
					//$(InputsWrapper).append('<div><input type="text" name="mytext[]" id="field_'+ FieldCount +'" value="Text '+ FieldCount +'"/><a href="#" class="removeclass">&times;</a></div>');
					jQuery(InputsWrapper).append(textfielddiv);
					x++; //text box increment
				}
				return false;
			});
			jQuery("#multiple-answer-option li.red").live("click",function(){
				jQuery(this).parent('ul.form-elements').remove();
			});
			
			jQuery("body").on("click", ".removeclass", function(e) { //user click on remove text
				if (x > 1) {
					jQuery(this).parent('ul.dynamic-txt-field').remove(); //remove text box
					x--; //decrement textbox
				}
				return false;
			})
	});