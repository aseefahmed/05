<?php 
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $current_user, $cs_course_options,$wp_roles,$userdata,$cs_theme_options;
 	$uid= $current_user->ID;
  	$cs_course_per_page = get_option('posts_per_page');
	$user_role = get_the_author_meta('roles',$uid );
	$cs_course_options = $cs_course_options;
	$cs_counter_node  = 1;
	$cs_page_id = $cs_course_options['cs_dashboard'];
 	if(isset($_GET['uid']) && $_GET['uid'] <> ''){ $uid = $_GET['uid']; }
	$action = (isset($_GET['action']) && $_GET['action'] <> '') ? $_GET['action'] : $action	= '';
	if ( function_exists( 'cs_user_exists' ) ) { cs_user_exists($uid); }
	if ( function_exists( 'update_user_info' ) ) { update_user_info(); }
	
	$error = '';
	$flag = 'false';
	cs_user_avatar();
	
	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' && $uid == $current_user->ID) {
 		if($current_user->user_login =='lms-admin'){
				$error = __('You are not able to update profile setting from demo account.', 'EDULMS');
 			}
		if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
			
			if ( $_POST['pass1'] == $_POST['pass2'] )
				wp_update_user( array( 'ID' => $uid, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
			else
				$error = __('The passwords you entered do not match.  Your password was not updated.', 'EDULMS');
		}
		if ( !empty( $_POST['email'] ) ){
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
 				//update_user_meta( $uid, 'user_email', esc_attr( $_POST['email'] ) );
				wp_update_user( array( 'ID' => $uid, 'user_email' => esc_attr( $_POST['email'] ) ) );
			} else {
				$error = __('Please enter a valid email address.','EDULMS');
			}
		}
  		 if(isset($_POST['mobile'])) {
			update_user_meta( $uid, 'mobile', esc_attr( $_POST['mobile'] ) );
		 }
		 if(isset($_POST['landline'])) {
			 update_user_meta( $uid, 'landline', esc_attr( $_POST['landline'] ) );
		 }
 		/* Update user information. */
 		//update_user_meta( $uid, 'user_avatar_display', $_POST['user_avatar_display'] );
 		update_user_meta( $uid,'first_name', esc_attr( $_POST['first_name'] ) );
		update_user_meta( $uid,'gender', esc_attr( $_POST['gender'] ) );
		update_user_meta( $uid,'tagline', esc_attr( $_POST['tagline'] ) );
		update_user_meta( $uid, 'user_profile_public', $_POST['user_profile_public'] );
		update_user_meta( $uid, 'user_contact_form', $_POST['user_contact_form'] );
		//update_user_meta( $uid, 'user_switch', $_POST['user_switch'] );
		update_user_meta( $uid, 'description', html_entity_decode( $_POST['description'] ) );
		/* Extra Profile Information */
		$user_id = wp_update_user( array( 'ID' => $uid, 'user_url' => $_POST['website'] ) );
		update_user_meta( $uid, 'facebook', esc_attr( $_POST['facebook'] ) );	
		update_user_meta( $uid, 'twitter', esc_attr( $_POST['twitter'] ) );
		update_user_meta( $uid, 'google_plus',esc_attr( $_POST['google_plus'] ));
		update_user_meta( $uid, 'linkedin', $_POST['linkedin'] );	
		update_user_meta( $uid, 'pinterest', $_POST['pinterest'] );	
		update_user_meta( $uid, 'skype', $_POST['skype'] );
		update_user_meta( $uid, 'instagram', $_POST['instagram'] );		
		/* Redirect so the page will show updated info. */
		if (!$error) {
			$flag = 'true';
		}
	}
 	get_header();
	$user_profile_public = get_the_author_meta('user_profile_public',$uid );
	if(isset($user_profile_public) and $user_profile_public=='1'){ 
	}
?>
	<!-- PageSection -->
    <section class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
            <?php if(isset($user_profile_public) and $user_profile_public=='1' or $current_user->ID ==$uid){ ?>
                <aside class="col-md-3">
                    <?php 
                        $cs_display_image = '';
                        $cs_display_image = get_the_author_meta('user_avatar_display',$uid );
                    ?>
                    <article class="st-userinfo">
                      <?php 
                            if($cs_display_image <> ''){
                                echo '<figure><img src="'.$cs_display_image.'"  /></figure>';	
                            }else{
                                echo '<figure>'.get_avatar(get_the_author_meta('user_email',$uid), apply_filters('PixFill_author_bio_avatar_size', 500)).'</figure>';	
                            }
                        ?>
                        <!-- Nav Assigment -->
                         <nav class="cs_assigment_tabs">
                        <?php 
                            if ( get_current_user_id()== $uid ){
                                    cs_profile_menu( $action,$uid );
                            }
                        ?>
                        </nav>
                        <!-- Nav Assigment -->
                        <div class="text">	
                           
                            <ul>
                                <?php 
                                    $cs_mobile = $cs_landline = $cs_email = $cs_skype = $cs_user_url ='';
                                    $cs_mobile = get_the_author_meta('mobile',$uid ); 
                                    $cs_landline = get_the_author_meta('landline',$uid );
                                    $cs_email = get_the_author_meta('email',$uid );
                                    $cs_skype = get_the_author_meta('skype',$uid );
                                    $cs_user_url = get_the_author_meta('user_url',$uid );
                                    if($cs_mobile <> ''){
                                        echo '<li><i class="fa  fa-mobile-phone"></i>'.$cs_mobile.'</li>';
                                    }
                                    if($cs_landline <> ''){
                                        echo '<li><i class="fa fa-phone"></i>'.$cs_landline.'</li>';
                                    }
                                    if($cs_email <> ''){
                                        echo '<li><i class="fa fa-envelope"></i>'.$cs_email.'</li>';
                                    }
                                    if($cs_skype <> ''){
                                        echo '<li><i class="fa fa-skype"></i>'.$cs_skype.'</li>';
                                    }
                                    if($cs_user_url <> ''){
                                        echo '<li><i class="fa fa-link"></i>
                                            <a href="'.$cs_user_url.'" target="_blank">'.$cs_user_url.'</a>
                                        </li>';
                                    }
                                ?>
                            </ul>
                            <p class="social-media">
                                <?php 
                                    $facebook = $twitter = $linkedin = $pinterest = $google_plus ='';
                                    $facebook = get_the_author_meta('facebook',$uid ); 
                                    $twitter  = get_the_author_meta('twitter',$uid );
                                    $linkedin = get_the_author_meta('linkedin',$uid );
                                    $pinterest = get_the_author_meta('pinterest',$uid );
                                    $google_plus = get_the_author_meta('google_plus',$uid );
                                    $instagram = get_the_author_meta('instagram',$uid );
                                    $skype = get_the_author_meta('skype',$uid );
                                    if(isset($facebook) and $facebook <> ''){
                                        echo '<a href="'.$facebook.'" data-original-title="Facebook" style="background-color:#2d5faa;"><i class="fa fa-facebook"></i></a>';
                                    }
                                    if(isset($twitter) and $twitter <> ''){
                                        echo '<a href="'.$twitter.'" data-original-title="Twitter" style="background-color:#3ba3f3;"><i class="fa fa-twitter"></i></a>';
                                    }
                                    if(isset($linkedin) and $linkedin <> ''){
                                        echo '<a href="'.$linkedin.'" data-original-title="Linkedin" style="background-color:#2d5faa;"><i class="fa fa-linkedin"></i></a>';
                                    }
                                    if(isset($pinterest) and $pinterest <> ''){
                                        echo '<a href="'.$pinterest.'" data-original-title="Pinterest" style="background-color:#a82626;">
                                        <i class="fa fa-pinterest"></i></a>';
                                    }
                                    if(isset($google_plus) and $google_plus <> ''){
                                        echo '<a href="'.$google_plus.'"  data-original-title="Google Plus" style="background-color:#f33b3b;">
                                        <i class="fa fa-google-plus"></i></a>';
                                    }
                                    if(isset($skype) and $skype <> ''){
                                        echo '<a href="skype:'.$skype.'?chat"  data-original-title="Google Plus" style="background-color:#3ba3f3;">
                                        <i class="fa fa-skype"></i></a>';
                                    }
                                    if(isset($instagram) and $instagram <> ''){
                                        echo '<a href="'.$instagram.'"  data-original-title="Google Plus" style="background-color:#f33b3b;">
                                        <i class="fa fa-instagram"></i></a>';
                                    }
                                ?>                              
                            </p>
                            <p>
                            <?php
                                $get_badges = get_the_author_meta( 'user_badges', $uid );
                                
								if(!is_array($get_badges) && $get_badges == ''){
									$get_badges	= array();
								}
                                if(isset($get_badges) and $get_badges <> '' && !empty($get_badges) ){?>
                                     <h3><?php _e('Badges','EDULMS');?></h3>
                                <?php }
                                
                                $cs_badges_list	=  get_option('cs_badges');
                                $badges = isset($cs_badges_list['badges_net_icons']) ? $cs_badges_list['badges_net_icons'] : '';	
                                if(isset($badges) and $badges <> ''){
                        
                                    $i = 0;
                                    foreach($badges as $badge){
                                        $badge_name = $cs_badges_list['badges_net_icons'][$i];
                                        $badge_short = $cs_badges_list['badges_net_icons_short_name'][$i];
                                        $badge_img = $cs_badges_list['badges_net_icons_paths'][$i];
                                        $badge_save = $badge_name.','.$badge_short.','.$badge_img;
                                        $get_s_badge = array();
                                        if(is_array($get_s_badge) and in_array($badge_name,$get_badges)) {
                                        ?>
                                            <img src="<?php echo esc_url($badge_img); ?>" title="<?php echo esc_attr($badge_name); ?>"  alt="<?php echo esc_attr($badge_name); ?>" width="40" />
                                        <?php
                                        }
                                        $i++;
                                    }
                                }
                                ?>
                            </p>
                         </div>
                    </article>
                 </aside>
                <div class="col-md-9">
                    <!-- Row -->
                    <div class="row">
                        <!-- col-md-12 -->
                         <div class="col-md-12">
                            <div id="post-<?php the_ID(); ?>" >
                                <div class="entry-content">
                                    <?php
                                        if (have_posts()):
                                            while (have_posts()) : the_post();
                                                the_content();
                                            endwhile;
                                        endif;
                                        wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages:', 'EDULMS'), "</div>\n", 'number');
                                    ?>
                                </div>
                            </div>
                            <?php if((isset($_GET['action']) && $_GET['action'] == 'dashboard') || !isset($_GET['action'])){
                                     $cs_contact_email		= get_the_author_meta( 'user_email', $uid );
                                     $cs_contact_succ_msg	= 'Email has been sent Successfully.';
                                     $cs_contact_error_msg	= 'An error Occured, please try again later.';
                                    cs_enqueue_validation_script(); ?>
                                    <script type="text/javascript">
                                        jQuery().ready(function($) {
                                            var container = $('');
                                            var validator = jQuery("#frm<?php echo esc_js($cs_counter_node)?>").validate({
                                                rules: {
                                                     contact_name: "required",
                                                     phone: "required",
                                                     contact_msg: "required",
                                                     contact_email: {
                                                       required: true,
                                                       email: true
                                                     }
                                                },
                                                messages:{
                                                    contact_name: '<?php _e('Please enter a username.','EDULMS');?>',
                                                    phone: '<?php _e('Please enter a phone number.','EDULMS');?>',
                                                    contact_msg: '<?php _e('Please enter a message.','EDULMS');?>',
                                                    contact_email:{
                                                        required:'<?php _e('Please enter a email address.','EDULMS');?>',
                                                        email:'<?php _e('Please enter a valid email address.','EDULMS');?>',
                                                    },
                                                },
                                                errorContainer: container,
                                                errorLabelContainer: jQuery(container),
                                                errorElement:'div',
                                                errorClass:'frm_error',
                                                meta: "validate"
                                            });
                                        });
                                        function frm_submit<?php echo esc_js($cs_counter_node)?>(){
                                            var $ = jQuery;
                                            $("#loading_div<?php echo esc_js($cs_counter_node)?>").html('<img src="<?php echo get_template_directory_uri()?>/assets/images/ajax-loader.gif" alt="" />');
                                            $.ajax({
                                                type:'POST', 
                                                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                                                data:$('#frm<?php echo esc_js($cs_counter_node)?>').serialize() + "&cs_contact_email=<?php echo esc_js(sanitize_email($cs_contact_email));?>&cs_contact_succ_msg=<?php echo esc_js($cs_contact_succ_msg);?>&cs_contact_error_msg=<?php echo esc_js($cs_contact_error_msg);?>", 
                                                dataType: "json",
                                                success: function(response) {
                                                    if (response.type == 'error'){
                                                        $("#loading_div<?php echo esc_js($cs_counter_node)?>").html('');
                                                        $("#loading_div<?php echo esc_js($cs_counter_node)?>").hide();
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").addClass('error_mess');
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").show();
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").html(response.message);
                                                    } else if (response.type == 'success'){
                                                        $("#frm<?php echo esc_js($cs_counter_node)?>").slideUp();
                                                        $("#loading_div<?php echo esc_js($cs_counter_node)?>").html('');
                                                        $("#loading_div<?php echo esc_js($cs_counter_node);?>").hide();
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").addClass('succ_mess');
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").show();
                                                        $("#message<?php echo esc_js($cs_counter_node)?>").html(response.message);
                                                    }
                                                }
                                            });
                                        }
                                    </script>
                                        <!-- .post -->
                                        <div class="row">
                                            <div class="rich_editor_text col-md-12">
                                                <div class="cs-section-title about-title"><h3><a><?php echo __('About','EDULMS').' '.get_the_author_meta('display_name',$uid );  ?></a></h3></div>
                                                <p><?php echo apply_filters("the_content",get_the_author_meta('description',$uid));?></p>
                                            </div>
                                        </div>
                                        <?php
                                        // args
                                        $args = array(
                                            'number_of_posts' => -1,
                                            'post_type' => 'courses',
                                            'meta_key' => 'var_cp_course_instructor',
                                            'meta_value' => "$uid"
                                        );
                                        
                                        // get results
                                        $custom_query = new WP_Query( $args );
                                        
                                        // The Loop
                                        if( $custom_query->have_posts() ):
                                             echo '<div class="row">';
                                             ?>
                                                <div class="cs-section-title about-title col-md-12">
                                                    <h3><?php _e('Courses', 'EDULMS'); ?></h3>
                                                </div>
                                                <?php
                                                while ($custom_query->have_posts()) : $custom_query->the_post();
                                                    
                                                     get_template_part('cs-templates/profile-styles/user','courses');
                                                     
                                                endwhile;
                                            echo '</div>';
                                        endif;
                                        
                                        wp_reset_query();
										
                                         if(get_the_author_meta('user_contact_form',$uid) =="1" and  $current_user->ID != $uid and isset($current_user->ID) and $current_user->ID <> '0' ){ ?>
                                            <div class="inputforms respond">
                                                
                                                    <div class="cs-section-title about-title">
                                                        <h3><?php echo __('Contact','EDULMS').' '.get_the_author_meta('display_name',$uid );  ?></h3>
                                                    </div> 
                                                    <div class="textsection">
                                                        <div class="succ_mess" id="succ_mess<?php echo esc_attr($cs_counter_node)?>"  style="display:none;"></div>
                                                    </div>
                                                    <div class="respond fullwidth" id="respond">
                                                        <form id="frm<?php echo esc_attr($cs_counter_node);?>" name="frm<?php echo esc_attr($cs_counter_node) ?>" method="post" action="javascript:<?php echo "frm_submit".$cs_counter_node."()";?>" novalidate>   
                                                            <p class="comment-form-author">
                                                                <label><?php _e('Name', 'EDULMS'); ?><span>*</span></label>
                                                                <span class="icon-input">
                                                                    <input type="text" name="contact_name" id="contact_name" class="required"   value="" />                                                      </span>
                                                            </p>
                                                            <p class="comment-form-email">
                                                                <label><?php _e('Email', 'EDULMS'); ?><span>*</span></label>
                                                                <span class="icon-input">
                                                                    <input type="text" name="contact_email" id="contact_email" class="required"   value="" />
                                                                </span>
                                                            </p>
                                                            <p class="comment-form-contact">
                                                                <label><?php  _e('Phone Number','EDULMS'); ?></label>
                                                                <span class="icon-input">
                                                                    <input type="text" name="phone" id="phone" class="required" value="" />
                                                                </span>
                                                            </p>
                                                            <p class="comment-form-comment">
                                                                <label><?php _e('Message','EDULMS'); ?><span>*</span></label>
                                                                <textarea name="contact_msg"   id="contact_msg" class="required"></textarea>
                                                             </p>
                                                            <p class="form-submit">
                                                                <input type="submit" value="submit" name="submit" id="submit_btn<?php echo esc_attr($cs_counter_node); ?>">
                                                                <input type="hidden" name="counter_node" value="<?php echo esc_attr($cs_counter_node) ?>">
                                                                <i id="loading_div<?php echo esc_attr($cs_counter_node);?>"></i>
                                                                <i id="message<?php echo esc_attr($cs_counter_node);?>" style="display:none;"></i>
                                                            </p>
                                                        </form>
                                                    </div>
                                                
                                            </div>  
                                        <?php } 
                                     }elseif(isset($_GET['action']) && $_GET['action'] == 'register-courses' && $current_user->ID == $uid){ ?>
                                <div class="courses">
                                    <div class="row">
                                         <?php 
                                        //$course_user_meta_array = get_user_meta($uid, "cs_user_course_meta", true);
                                        $course_user_meta_array = get_option($uid."_cs_course_data", true);
                                        foreach($course_user_meta_array as $course_id=>$course_values){
                                            if($course_id){
                                                $transaction_id = $course_values['transaction_id'];
                                                $course_id = $course_values['course_id'];
                                                $course_title = $course_values['course_title'];
                                                //$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
                                                $user_course_data = get_option($course_id."_cs_user_course_data", true);
                                                $user_course_data_array = array_reverse($user_course_data);
                                                    $key = array_search($uid, $user_course_data);
                                                    $course_info = $user_course_data[$key];
                                                    if(is_array($user_course_data)){
                                                        $user_course_data_array = array_reverse($user_course_data);
                                                        $course_key = '';
                                                        foreach ( $user_course_data_array as $key=>$members ){
                                                            if($uid == $members['user_id']){
                                                                $course_key = $key;
                                                                break;
                                                            }
                                                        }
                                                        $course_info = array();
                                                        if($course_key || $course_key == 0){
                                                            if(isset($user_course_data_array[$course_key]) && is_array($user_course_data_array[$course_key])){
                                                                $course_info = $user_course_data_array[$course_key];
                                                                $course_id = $course_info['course_id'];
                                                                $transaction_id = $course_info['transaction_id'];
                                                                $register_date = $course_info['register_date'];
                                                                $expiry_date = $course_info['expiry_date'];
                                                                $result = $course_info['result'];
                                                                $remarks = $course_info['remarks'];
                                                                $disable = $course_info['disable'];
                                                                $post_status = get_post_status( $course_id );
                                                                if($post_status=='publish'){
                                                                    echo '<h2><a href="'.get_permalink($course_id).'" target="_blank">'.get_the_title($course_id).'</a></h2>';
                                                                    echo 'Date: '.date_i18n(get_option( 'date_format' ),strtotime($register_date)).'/'.date_i18n(get_option( 'date_format' ),strtotime($expiry_date));
                                                                } else {
                                                                    echo '<h2>'.$course_title.'</h2>';
                                                                    echo 'Date: '.date_i18n(get_option( 'date_format' ),strtotime($register_date)).'/'.date_i18n(get_option( 'date_format' ),strtotime($expiry_date));	
                                                                }
                                                                $quiz_answer_array = get_user_meta($uid,'cs-quiz-nswers', true);
                                                                if(isset($quiz_answer_array[$transaction_id]) && is_array($quiz_answer_array[$transaction_id])){
                                                                    $quiz_details = $quiz_answer_array[$transaction_id];
                                                                    foreach($quiz_details as $quiz_key=>$quizvalues){
                                                                        $quiz_complete = 1;	
                                                                        if(isset($quiz_answer_array[$transaction_id][$quiz_key] )&& is_array($quiz_answer_array[$transaction_id][$quiz_key])){
                                                                            $quiz_complete_key = cs_get_user_id().'_'.$transaction_id.'_'.$quiz_key;
                                                                            $quiz_complete = get_option($quiz_complete_key);
                                                                            if(!isset($quiz_complete)){
                                                                                $quiz_complete = 1;
                                                                            } else if(isset($quiz_complete) && $quiz_complete == ''){
                                                                                $quiz_complete = 1;
                                                                            }
                                                                            $attempt_no = $quiz_complete-1;
                                                                            $user_questionaire_array = $quiz_answer_array[$transaction_id][$quiz_key][$attempt_no];
                                                                            
                                                                            if(isset($user_questionaire_array['quiz_information']) && is_array($user_questionaire_array['quiz_information'])){
                                                                                $quiz_detail = $user_questionaire_array['quiz_information'];
                                                                                $quiz_ID = $quiz_detail['quiz_ID'];
                                                                                $title = $quiz_detail['title'];
                                                                                $quiz_passing_marks = $quiz_detail['quiz_passing_marks'];
                                                                                $quiz_description = $quiz_detail['quiz_description'];
                                                                                $marks = $quiz_detail['marks'];
                                                                                    echo '<h2>'.$title.'</a>';
                                                                                    echo '<p>'.$quiz_description.'</p>';
                                                                                    echo '<p>'.__('Passing Marks:', 'EDULMS').$quiz_passing_marks.' '.__('Total Marks:','EDULMS').$marks.'</p>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
    
                                                            }
                                                        }		
                                                    }	
                                               }
                                          }
                                        ?>
                                    </div>
                                 </div>
                                <?php }
                                elseif(isset($_GET['action']) && $_GET['action'] == 'add-course'){
                                    //include "profile/page_add_courses.php";
                                } 
                                elseif(isset($_GET['action']) && $_GET['action'] == 'my-courses' and $current_user->ID == $uid){
                                    //////////////////////////////////////// My Courses
									echo '<div class="cs-section-title about-title"><h3>Course Listing</h3></div>';
                                    include "page_courses.php";
                                }
								elseif(isset($_GET['action']) && $_GET['action'] == 'certificates' and $current_user->ID == $uid){?>
                                <div class="col-md-12 cs-member dir-list" id="members-dir-list">  
                                     <ul class="item-list crt-listing" id="members-list">
                                     <?php
                                        $certificates_user_array = array();
                                        $certificates_user_array = get_user_meta($uid, "user_certificates", true);
										if ( isset ( $certificates_user_array ) && $certificates_user_array != '' ){
											foreach ($certificates_user_array as $key => $certificate){
												$rand_id = cs_generate_random_string(7);
												$userID					 = $current_user->ID;
												$course_id				 = $certificate['cs_course_id'];
												$transection_id			 = $key;
												$certificates_user_array = get_user_meta($userID, "user_certificates", true);
												$certificateArray		 = $certificates_user_array[$transection_id];
												$cs_certificate_code =  $certificateArray['cs_certificate_code'];
												$expiry_date =  date('F j, Y',strtotime($certificateArray['cs_completion_date']));

            //                                         echo "<pre>";
            // Var_dump($certificates_user_array);
            // echo "</pre>";
												?>
											
												<li>
													<div class="cr-inner-lst">
                                                        <figure>
                                                        <a data-toggle="modal" data-target="#myCertificates-<?php echo esc_attr($rand_id);?>" onclick="cs_pop_certificate('<?php echo esc_js(admin_url("admin-ajax.php"));?>','<?php echo esc_js($certificate['cs_course_id']);?>','<?php echo esc_js($rand_id);?>','<?php echo esc_js($key);?>');" href="javascript:;"><i class="fa fa-certificate"></i></a>
                                                         </figure>
                                                        <div class="left-sp">
                                                            <h4><a data-toggle="modal" data-target="#myCertificates-<?php echo esc_attr($rand_id);?>" onclick="cs_pop_certificate('<?php echo esc_js(admin_url("admin-ajax.php"));?>','<?php echo esc_js($certificate['cs_course_id']);?>','<?php echo esc_js($rand_id);?>','<?php echo esc_js($key);?>');" href="javascript:;"><?php echo esc_attr($certificate['cs_certificate_name']);?></a></h4>
                                                        <span class="crt-expiry"><?php esc_html_e('Certificate Code','EDULMS');?><?php echo esc_attr( $cs_certificate_code );?></span>
                                                        </div>
                                                    </div>
												</li>
                                                <div id="myCertificates-<?php echo esc_attr($rand_id);?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
											<?php }
											} else {
												echo '<div class="error_mess"><p>'.__('No certificate Awarded to you.', 'EDULMS').'</p></div>';
											}
                                     ?>
                                     </ul>
                                     </div>
                                         
                                <?php 		
							    }
                                elseif(isset($_GET['action']) && $_GET['action'] == 'user-invoices'){
                                        //$course_user_meta_array = get_user_meta($uid, "cs_user_course_meta", true);
                                        $course_user_meta_array = get_option($uid."_cs_course_data", true);
                                        if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
                                            
                                            if(isset($cs_course_options['cs_currency_symbol']))
                                                $product_currency = $cs_course_options['cs_currency_symbol'];
                                             else 
                                                $product_currency = '$';
                                            ?>
                                            <div class="cs-section-title about-title"><h3><?php _e('Statement','EDULMS');?></h3></div>
                                            <div class="result-table">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th><?php _e('Course Name','EDULMS');?></th>
                                                            <th><?php _e('Start Date','EDULMS');?></th>
                                                            <th><?php _e('Expiration','EDULMS');?></th>
                                                            <th><?php _e('Purchase Id','EDULMS');?></th>
                                                            <th><?php _e('Price','EDULMS');?></th>
                                                            <th><?php _e('Status','EDULMS');?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        foreach($course_user_meta_array as $course_id=>$course_values){
                                                            $course_title = $course_values['course_title'];
                                                            if($course_id){
                                                                $user_course_data = get_option($course_id."_cs_user_course_data", true);
                                                                if(is_array($user_course_data) && count($user_course_data)>0){
                                                                    $user_course_data_array = array_reverse($user_course_data) ;
                                                                    $key = array_search($uid, $user_course_data);
                                                                    $course_info = $user_course_data[$key];
                                                                    $user_course_data_array = array_reverse($user_course_data) ;
                                                                    $course_key = '';
                                                                    foreach ( $user_course_data_array as $key=>$members ){
                                                                        if($uid == $members['user_id']){
                                                                            $course_key = $key;
                                                                            break;
                                                                        }
                                                                    }
                                                                    $course_info = array();
                                                                        if($course_key || $course_key == 0){
                                                                            $course_price = '';
                                                                            if(isset($user_course_data_array[$course_key]) && is_array($user_course_data_array[$course_key])){
                                                                                $course_info = $user_course_data_array[$course_key];
                                                                                $course_id = $course_info['course_id'];
                                                                                $transaction_id = $course_info['transaction_id'];
                                                                                $register_date = $course_info['register_date'];
                                                                                $expiry_date = $course_info['expiry_date'];
                                                                                
                                                                                if(isset($course_info['course_price']) && $course_info['course_price'] <> ''){
                                                                                    $course_price = $product_currency.$course_info['course_price'];
                                                                                } else {
                                                                                    $cs_course = get_post_meta($course_id, "cs_course", true);
                                                                                    if ( $cs_course <> "" ) {
                                                                                        $cs_xmlObject = new SimpleXMLElement($cs_course);
                                                                                        $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
                                                                                        $product_status = get_post_status( (int)$var_cp_course_product );
                                                                                        if($product_status=='publish'){
                                                                                            $course_price = cs_get_product_price((int)$var_cp_course_product);
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $result = $course_info['result'];
                                                                                $remarks = $course_info['remarks'];
                                                                                $disable = $course_info['disable'];
            
                                                                               $post_status = get_post_status( $course_id );
                                                                               
                                                                                if($disable == "1"){
                                                                                    $course_status = 'Pending';
                                                                                } else if($disable == "2"){
                                                                                    $course_status = 'Disable';
                                                                                } else {
                                                                                    $course_status = 'Approved';
                                                                                    $dDiff = strtotime($expiry_date)-strtotime($register_date);
                                                                                    if(isset($dDiff) && $dDiff >0){
                                                                                        $course_status = 'Approved';
                                                                                    } else {
                                                                                        $course_status ='Completed';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="table-heading">
                                                                                    <?php 
                                                                                    if($post_status == 'publish')
                                                                                         echo '<a href="'.get_permalink($course_id).'" target="_blank">'.get_the_title($course_id).'</a>';
                                                                                    else 
                                                                                        echo esc_attr($course_title);
                                                                                    ?></td>
                                                                                    <td><?php echo date_i18n(get_option( 'date_format' ),strtotime($register_date));?></td>
                                                                                    <td><?php echo date_i18n(get_option( 'date_format' ),strtotime($expiry_date));?></td>
                                                                                    <td><?php echo esc_attr($transaction_id);?></td>
                                                                                    <td><?php echo esc_attr($course_price);?></td>
                                                                                    <td><?php echo esc_attr($course_status);?></td>
                                                                                    <!--<td><i class="fa fa-file-pdf-o"></i></td>
                                                                                    <td><i class="fa fa-times"></i></td>-->
                                                                                </tr>
                                                                              <?php
                                                                                }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                        </div>
                                        <?php
                                        } else {
                                            echo __('You are not subscribed to any course', 'EDULMS');	
                                        }
                                     ?>
                            <?php }
								elseif(isset($_GET['action']) && $_GET['action'] == 'scores'){
                                    
                                    do_action('cs_quiz_results_page');
                                    
                                }elseif(isset($_GET['action']) && $_GET['action'] == 'user-courses' && $current_user->ID == $uid){ ?>
                                 <div class="courses">
                                    <div class="row">
                                        <?php 
                                            $count_post = 0;
                                             $args = array(
                                                'posts_per_page' 	=> "-1",
                                                'post_type'			=> 'courses',
                                                'post_status'		=> 'publish',
                                                'order'				=> 'ASC',
                                            );
                                            $custom_query = new WP_Query($args);
                                            while ( $custom_query->have_posts() ): $custom_query->the_post();
                                                $course_id = $course_post_id = $post->ID;
                                                //$user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
                                                $user_course_data_array = get_option($course_id."_cs_user_course_data", true);
                                                $course_user_ids = array();
                                                if ( isset($user_course_data_array) && count($user_course_data_array)>0) {
                                                    foreach ( $user_course_data_array as $members ){
                                                         $course_user_ids[] = $members['user_id'];
                                                    }
                                                }
                                                $course_data_array = array();
                                                $user_course_data = array_unique($course_user_ids);		
                                                if(in_array($uid,$user_course_data)){
                                                    $count_post++;
                                                }								
                                            endwhile; 
                                            wp_reset_query();
                                             $args = array(
                                                'posts_per_page'			=> $cs_course_per_page ,
                                                'paged'						=> $_GET['page_id_all'],
                                                'post_type'					=> 'courses',
                                                'post_status'				=> 'publish',
                                                'order'						=> 'ASC',
                                            );
                                            $custom_query = new WP_Query($args);
                                            if($custom_query->have_posts() ){
                                                while ( $custom_query->have_posts() ): $custom_query->the_post();	
                                                    $course_id = $course_post_id = $post->ID;
                                                    $cs_course = get_post_meta($post->ID, "cs_course", true);
                                                    $user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
                                                    $user_course_data_array = get_option($course_id."_cs_user_course_data", true);
                                                    $course_user_ids = array();
                                                    if ( isset($user_course_data_array) && count($user_course_data_array)>0) {
                                                        foreach ( $user_course_data_array as $members ){
                                                             
                                                             $course_user_ids[] = $members['user_id'];
                                                        }
                                                    }
                                                    $course_data_array = array();
                                                    $user_course_data = array_unique($course_user_ids);
                                                        if(in_array($uid,$user_course_data)){
                                                            if ( $cs_course <> "" ) {
                                                                $cs_xmlObject = new SimpleXMLElement($cs_course);
                                                                 $var_cp_course_id = $cs_xmlObject->course_id;
                                                                 $course_duration = $cs_xmlObject->course_duration;
                                                                 $var_cp_course_members = $cs_xmlObject->var_cp_course_members;
                                                                 $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
                                                            }else{
                                                                $var_cp_course_product = $var_cp_course_members = $var_cp_course_product = '';
                                                                $course_duration ='';	
                                                            }
                                                            $width = 370;
                                                            $height = 278;
                                                            $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                                                            $course_class = $course_listing_class;
                                                            if($image_url == ''){
                                                                $course_class = ' no-img '.$course_listing_class;
                                                            }
                                                    ?>
                                                        <div class="wow">
                                                            <article <?php post_class('cs-list list_v3 has_border');?> >
                                                                <?php echo ''.$timeline_html_start;
                                                                    if($image_url <> ''){ ?>
                                                                        <figure class="<?php echo esc_url($thumbnail);?>  fig-<?php echo absint($post->ID);?>">
                                                                            <img src="<?php echo esc_url($image_url);?>" alt="">
                                                                        </figure>
                                                                    <?php  }?>
                                                                    <div class="text-section">
                                                                        <div class="cs-top-sec">
                                                                            <div class="seideleft">
                                                                                <div class="left_position">
                                                                                    <h4><a href="<?php the_permalink();?>" class="colrhvr"><?php the_title(); ?></a></h4>
                                                                                    <?php 
                                                                                     $reviews_args = array(
                                                                                        'posts_per_page'			=> "-1",
                                                                                        'post_type'					=> 'cs-reviews',
                                                                                        'post_status'				=> 'publish',
                                                                                        'meta_key'					=> 'cs_reviews_course',
                                                                                        'meta_value'				=> $post->ID,
                                                                                        'meta_compare'				=> "=",
                                                                                        'orderby'					=> 'meta_value',
                                                                                        'order'						=> 'ASC',
                                                                                     );
                                                                                    $reviews_query = new WP_Query($reviews_args);
                                                                                    $reviews_count = $reviews_query->post_count;
                                                                                    $var_cp_rating = 0;
                                                                                    if ( $reviews_query->have_posts() <> "" ) {
                                                                                        while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
                                                                                            $var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
                                                                                        endwhile;
                                                                                    }
                                                                                    if($var_cp_rating){
                                                                                        $var_cp_rating = $var_cp_rating/$reviews_count;
                                                                                    }
                                                                                     ?>
                                                                                        <ul class="listoption">
                                                                                         <?php 
                                                                                             if ( function_exists( 'cs_get_course_reviews' ) ) {  cs_get_course_reviews($reviews_count,$var_cp_rating); }
                                                                                             if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
                                                                                         ?>
                                                                                        </ul>
                                                                                   </div>
                                                                            </div>
                                                                         </div>
                                                                         <div class="cs-peragraph">
                                                                              <p><?php if ( function_exists( 'cs_get_the_excerpt' ) ) { echo  cs_get_the_excerpt('180',false, ''); }?></p>
                                                                          </div>
                                                                          <div class="cs-cat-list">
                                                                                <ul>
                                                                                <?php
                                                                                    if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
                                                                                    if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
                                                                                ?>
                                                                                </ul>
                                                                           </div>
                                                                           <a href="<?php echo esc_url($add_to_cart_product_url); ?>" class="custom-btn">
                                                                                <i class="fa fa-file-text"></i><?php  
     _e('Apply Now','EDULMS');?>																			
                                                                           </a>     
                                                                      </div>
                                                                 <?php echo ''.$timeline_html_end;?>
                                                            </article>
                                                        </div>
                                                    <?php } endwhile;
                                                    }else{
                                                         if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(); }
                                                }
                                                wp_reset_query();
                                            ?>
                                            </div>
                                   </div>
                                    <?php
                                    if($count_post > $cs_course_per_page){ 
                                        $qrystr = "&action=user-courses&uid=".$uid."";
                                        if ( function_exists( 'cs_pagination' ) ) { echo cs_pagination($count_post, $cs_course_per_page,$qrystr); } 
                                    }
                               }
                               elseif(isset($_GET['action']) && $_GET['action'] == 'user-reviews' && $current_user->ID == $uid){
                                    $reviews_args = array(
                                        'posts_per_page'			=> "-1",
                                        'post_type'					=> 'cs-reviews',
                                        'post_status'				=> 'publish',
                                        'meta_key'					=> 'cs_reviews_user',
                                        'meta_value'				=> $uid,
                                        'meta_compare'				=> "=",
                                        'orderby'					=> 'meta_value',
                                        'order'						=> 'ASC',
                                    );
                                    $reviews_query = new WP_Query($reviews_args);
                                    $count_post=$reviews_query->post_count;
                                    $reviews_args = array(
                                        'posts_per_page'			=> $cs_course_per_page,
                                        'paged'						=> $_GET['page_id_all'],
                                        'post_type'					=> 'cs-reviews',
                                        'post_status'				=> 'publish',
                                        'meta_key'					=> 'cs_reviews_user',
                                        'meta_value'				=> $uid,
                                        'meta_compare'				=> "=",
                                        'orderby'					=> 'meta_value',
                                        'order'						=> 'ASC',
                                    );
                                    $reviews_query = new WP_Query($reviews_args);
                            ?>
                                <div class="course-reviews" id="course-reviews">
                                    <div class="widget_instrector fullwidth course-detail-reviews-listing">
                                    <div class="cs-section-title about-title"><h3><?php _e('Reviews','EDULMS');?></h3></div>
                                    <?php 
                                     if ( $reviews_query->have_posts() <> "" ) {
                                        while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
                                            $var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
                                            $var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
                                            $var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
                                            ?>
                                            <article class="reviews reviews-<?php echo absint($post->ID);?>">
                                                 <figure>
                                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $var_cp_reviews_members)); ?>">
                                                    <?php 
                                                        echo get_avatar(get_the_author_meta('user_email', $var_cp_reviews_members), apply_filters('PixFill_author_bio_avatar_size', 60)); ?>
                                                    </a>
                                                 </figure>
                                                <div class="left-sp">
                                                     <h5><?php echo get_the_author_meta('display_name', $var_cp_reviews_members); ?></h5>
                                                     <div class="cs-rating"><span class="rating-box" style="width:<?php echo esc_url($var_cp_rating*20);?>%"></span></div>
                                                </div>
                                                <?php 
                                                    echo '<span class="cs-rating-desc">'.get_the_title().'</span>';
                                                    echo '<p class="cs-review-description">'.the_content().'</p>';
                                                ?>
                                            </article>
                                        <?php
                                            endwhile;
                                        }else{
                                              if ( function_exists( 'fnc_no_result_found' ) ) { fnc_no_result_found(); }
                                        }
                                        wp_reset_postdata();
                                       ?>
                                    </div>
                                 </div>
                                <?php 
                                    if($count_post > $cs_course_per_page){ 
                                        $qrystr = "&action=user-reviews&uid=".$uid."";
                                        if ( function_exists( 'cs_pagination' ) ) { echo cs_pagination($count_post, $cs_course_per_page,$qrystr); }
                                    }
                                }elseif(isset($_GET['action']) && $_GET['action'] == 'LMS' && $current_user->ID == $uid){?>
                                <div class="courses">
                                    <div class="row">
                                        <?php 
                                              $args = array(
                                                    'posts_per_page'			=> "-1",
                                                    'post_type'					=> 'courses',
                                                    'post_status'				=> 'publish',
                                                    'meta_key'					=> 'var_cp_course_instructor',
                                                    'meta_value'				=> $uid,
                                                    'meta_compare'				=> "=",
                                                    'orderby'					=> 'meta_value',
                                                    'order'						=> 'ASC',
                                            );
                                             $custom_query = new WP_Query($args);
                                             $count_post=$custom_query->post_count;
                                             $args = array(
                                                    'posts_per_page'			=> $cs_course_per_page,
                                                    'paged'						=> $_GET['page_id_all'],
                                                    'post_type'					=> 'courses',
                                                    'post_status'				=> 'publish',
                                                    'meta_key'					=> 'var_cp_course_instructor',
                                                    'meta_value'				=> $uid,
                                                    'meta_compare'				=> "=",
                                                    'orderby'					=> 'meta_value',
                                                    'order'						=> 'ASC',
                                            );
                                            $custom_query = new WP_Query($args);
                                            if( $custom_query->have_posts()){
                                                while ( $custom_query->have_posts() ): $custom_query->the_post();	
                                                    $course_id = $course_post_id = $post->ID;
                                                    $cs_course = get_post_meta($post->ID, "cs_course", true);
                                                    //$user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
                                                    $user_course_data_array = get_option($course_id."_cs_user_course_data", true);
                                                    $course_user_ids = array();
                                                    if ( isset($user_course_data_array) && count($user_course_data_array)>0) {
                                                        foreach ( $user_course_data_array as $members ){
                                                              $course_user_ids[] = $members['user_id'];
                                                        }
                                                    }
                                                    $course_data_array = array();
                                                    $user_course_data = array_unique($course_user_ids);
                                                        if ( $cs_course <> "" ) {
                                                            $cs_xmlObject = new SimpleXMLElement($cs_course);
                                                             $var_cp_course_id = $cs_xmlObject->course_id;
                                                            $course_duration = $cs_xmlObject->course_duration;
                                                            $var_cp_course_members = $cs_xmlObject->var_cp_course_members;
                                                            $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
                                                        }
                                                        else{
                                                            $var_cp_course_product = $var_cp_course_members = $var_cp_course_product = '';
                                                            $course_duration ='';	
                                                        }
                                                        $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                                                        $course_class = $course_listing_class;
                                                        if($image_url == ''){
                                                           $course_class = ' no-img '.$course_listing_class;
                                                        }
                                                    ?>
                                                    <div class="wow">
                                                        <article <?php post_class('cs-list list_v1 has_border');?> >
                                                            <?php echo ''.$timeline_html_start;
                                                                if($image_url <> ''){ ?>
                                                                    <figure class="fig-<?php echo absint($post->ID);?>">
                                                                        <img src="<?php echo esc_url($image_url);?>" alt="">
                                                                    </figure>
                                                                <?php  }?>
                                                                <div class="text-section">
                                                                    <div class="cs-top-sec">
                                                                        <div class="seideleft">
                                                                            <div class="left_position">
                                                                                <h4><a href="<?php the_permalink();?>" class="colrhvr"><?php the_title(); ?></a></h4>
                                                                                <?php 
                                                                                 $reviews_args = array(
                                                                                    'posts_per_page'			=> "-1",
                                                                                    'post_type'					=> 'cs-reviews',
                                                                                    'post_status'				=> 'publish',
                                                                                    'meta_key'					=> 'cs_reviews_course',
                                                                                    'meta_value'				=> $post->ID,
                                                                                    'meta_compare'				=> "=",
                                                                                    'orderby'					=> 'meta_value',
                                                                                    'order'						=> 'ASC',
                                                                                 );
                                                                                $reviews_query = new WP_Query($reviews_args);
                                                                                $reviews_count = $reviews_query->post_count;
                                                                                $var_cp_rating = 0;
                                                                                if ( $reviews_query->have_posts() <> "" ) {
                                                                                    while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
                                                                                        $var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
                                                                                    endwhile;
                                                                                }
                                                                                if($var_cp_rating){
                                                                                    $var_cp_rating = $var_cp_rating/$reviews_count;
                                                                                }
                                                                                 ?>
                                                                                <ul class="listoption">
                                                                                     <?php 
                                                                                         if ( function_exists( 'cs_get_course_reviews' ) ) { cs_get_course_reviews($reviews_count,$var_cp_rating); }
                                                                                         if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
                                                                                     ?>
                                                                                 </ul>
                                                                               </div>
                                                                        </div>
                                                                     </div>
                                                                     <div class="cs-peragraph">
                                                                          <p><?php if ( function_exists( 'cs_get_the_excerpt' ) ) { echo cs_get_the_excerpt('180',false, '');} ?></p>
                                                                      </div>
                                                                      <div class="cs-cat-list">
                                                                        <ul>
                                                                            <?php
                                                                                if ( function_exists( 'cs_get_course_members' ) ) { cs_get_course_members($course_post_id); }
                                                                                if ( function_exists( 'cs_get_course_lessons' ) ) { cs_get_course_lessons($cs_xmlObject); }
                                                                            ?>
                                                                        </ul>
                                                                       </div>
                                                                        <a href="<?php echo esc_url($add_to_cart_product_url); ?>" class="custom-btn">
                                                                            <i class="fa fa-file-text"></i><?php  
    _e('Apply Now','EDULMS');																	
                                                                            ?>
                                                                        </a>     
                                                                  </div>
                                                             <?php echo ''.$timeline_html_end;?>
                                                        </article>
                                                    </div>
                                                    <?php  endwhile;
                                                    }else{
                                                        fnc_no_result_found();
                                                }
                                                wp_reset_query();
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                    if($count_post > $cs_course_per_page){ 
                                        $qrystr = "&action=LMS&uid=".$uid."";
                                        echo cs_pagination($count_post,$cs_course_per_page,$qrystr);
                                    }
                                }elseif(isset($_GET['action']) && $_GET['action'] == 'profile-setting' && $current_user->ID == $uid){
                                    echo '<div class="cs-section-title about-title"><h3>'.__('Settings','EDULMS').'</h3></div>';	
                                ?>
                                     <!-- .post -->
                                    <div class="rich_editor_text">
                                    <!-- EDIT PROFILE STARTS HERE -->
                                    <?php 
                                        if ( !is_user_logged_in() ) {
                                            echo '<p class="warning">'.__('You must be logged in to edit your profile.', 'EDULMS').'</p>';
                                        }else { 
                                            if (!empty($error)){
                                                 echo '<p class="error form-title">' . $error . '</p>';
                                            }else{
                                              if($flag == 'true'){
                                                    echo '<p class="error form-title">'.__('user profile update successfully','EDULMS').'</p>';
                                              }
                                             }
                                        ?>
                                            
                                              <ul class="upload-file cs-display-bg">
                                                  <li>
                                                      <label for="display-photo"><?php _e('Display Photo', 'EDULMS'); ?></label>
                                                        <div class="inner-sec">
                                                            <?php 
                                                                $display_photo = trim(get_the_author_meta( 'user_avatar_display', $uid )); 
                                                                $display = 'none';
                                                                if($display_photo <> ''){
                                                                    $display = 'block';	
                                                                }
                                                            ?>
                                                             <form method="POST" enctype="multipart/form-data" action="">
                                                                <div class="browse-sec">
                                                                    <input id="uploadFile" placeholder="Choose File" disabled="disabled" />
                                                                    <div class="fileUpload">
                                                                        <span><?php _e('Upload','EDULMS'); ?></span>
                                                                        <input id="form_user_avatar" class="upload" type="file" name="user_avatar" value="" />
                                                                        <input type="hidden" name="action" value="wp_handle_upload" />
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    document.getElementById("form_user_avatar").onchange = function () {
																			document.getElementById("uploadFile").value = this.value;
																	};
                                                                </script>
                                                                <input type="submit" onclick="javascript:cs_update_profile_image('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($user_ID);?>');" value="<?php _e('Update Avatar','EDULMS')?>" class="cs-bgcolr cs-update-avatar" />
                                                                </form>
                                                          
                                                              <div class="page-wrap" style="display:<?php echo esc_attr($display);?>" id="user_avatar_display_box">
                                                                <div class="profile-loading"></div>
                                                                  <div class="gal-active">
                                                                    <div class="dragareamain" style="padding-bottom:0px;">
                                                                      <ul id="gal-sortable">
                                                                        <li class="ui-state-default" id="">
                                                                          <div class="thumb-secs"><i class="fa fa-photo"></i>  <?php echo basename(get_the_author_meta( 'user_avatar_display', $current_user->ID )); ?>
                                                                            <div class="gal-edit-opts"> <a onclick="cs_user_profile_picture_del('user_avatar_display', '<?php echo esc_js($uid);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')" class="delete"><i class="fa fa-times"></i></a> </div>
                                                                          </div>
                                                                        </li>
                                                                      </ul>
                                                                    </div>
                                                                  </div>
                                                              </div>
                                                          <ul class="cs-hint-text">
                                                            <li> <?php _e('Update your avatar manually by uploading a picture from your computer/directory. If the avatar is not set manually, the default Gravatar will be the same as your login email/user account.','EDULMS'); ?></li>
                                                            <li> <?php _e('Image file size limit: 1MB','EDULMS'); ?></li>
                                                            <li> <?php _e('Recommended dimensions: 128x128','EDULMS'); ?></li>	
                                                            <li> <?php _e('Recommended extensions: JPEG,PNG','EDULMS'); ?></li>	
                                                          </ul>
                                                       </div>
                                                  </li>
                                              </ul>
                                              <form method="post" id="edituser" class="user-forms" enctype="multipart/form-data" action="<?php the_permalink($cs_page_id); ?>?action=profile-setting&uid=<?php echo absint($uid);?>">
                                              <div class="form-title">
                                                  <h4><?php _e('About me','EDULMS')?></h4>
                                             </div>
                                              <ul class="upload-file">
                                                  <li class="first_name">
                                                      <label for="first_name"><?php _e('Full Name', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                          <input class="text-input" name="first_name" type="text" id="first_name" value="<?php the_author_meta( 'first_name', $uid ); ?>" />
                                                      </div>
                                                  </li><!-- .first_name -->
                                                  <li class="first_name">
                                                      <label for="gender"><?php _e('Gender', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                            <?php $gender=get_the_author_meta( 'gender', $uid ); ?>
                                                            <select name="gender" id="gender">
                                                                <option value="male" 	<?php cs_selected ($gender,'male');?>>Male</option>
                                                                <option value="female" 	<?php cs_selected ($gender,'female');?>>Female</option>
                                                            </select>
                                                          
                                                      </div>
                                                  </li><!-- .first_name -->
                                                  <li class="first_name">
                                                      <label for="tagline"><?php _e('TagLine', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                          <input class="text-input" name="tagline" type="text" id="tagline" value="<?php the_author_meta( 'tagline', $uid ); ?>" />
                                                      </div>
                                                  </li><!-- .first_name -->
                                                  <li class="form-description">
                                                      <label for="description"><?php _e('Biography', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                          <textarea class="text-input" name="description" id="description" rows="25" cols="30"><?php echo the_author_meta( 'description', $uid ); ?></textarea>
                                                      </div>
                                                  </li>
                                                  <li class="form-description">
                                                      <label for="description"><?php _e('Public Profile', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                            <label class="pbwp-checkbox">
                                                                <input type="hidden" name="user_profile_public" id="user_switch" value="off" />
                                                                <input type="checkbox" class="text-input" name="user_profile_public" id="user_profile_public" value="1" <?php checked( get_the_author_meta( 'user_profile_public', $uid),1 ); ?>>
                                                                <span class="pbwp-box"></span>
                                                            </label>
                                                      </div>
                                                  </li>
                                                  <li class="form-description">
                                                      <label for="description"><?php _e('Contact Form', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                          <label class="pbwp-checkbox">
                                                                <input type="hidden" name="user_contact_form" id="user_switch" value="off" />	
                                                              <input type="checkbox" class="text-input" name="user_contact_form" id="user_contact_form" value="1" <?php checked(get_the_author_meta( 'user_contact_form', $uid ),1 ); ?>>
                                                              <span class="pbwp-box"></span>
                                                          </label>
                                                      </div>
                                                  </li>
                                                  </ul>
                                                  <div class="form-title">
                                                      <h4><?php _e('Contact Detail','EDULMS')?></h4>
                                                  </div>
                                                  <ul class="upload-file">
                                                   <li class="form-twitter">
                                                    <label for="website"><?php _e('Mobile', 'EDULMS'); ?></label>
                                                    <div class="inner-sec">
                                                      <input class="text-input" name="mobile" type="text" id="mobile" value="<?php the_author_meta( 'mobile', $uid ); ?>" />
                                                    </div>
                                                  </li>
                                                  <li class="form-twitter">
                                                    <label for="website"><?php _e('Landline', 'EDULMS'); ?></label>
                                                    <div class="inner-sec">
                                                      <input class="text-input" name="landline" type="text" id="landline" value="<?php the_author_meta( 'landline', $uid ); ?>" />
                                                    </div>
                                                   </li>
                                                   <li class="form-email">
                                                      <label for="email"><?php _e('E-mail (required)', 'EDULMS'); ?></label>
                                                      <div class="inner-sec">
                                                          <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $uid ); ?>" />
                                                      </div>
                                                  </li><!-- .form-email -->
                                                    
                                                 <li class="form-website">
                                                    <label for="website"><?php _e('website', 'EDULMS'); ?></label>
                                                    <div class="inner-sec">
                                                        <input class="text-input" name="website" type="text" id="website" value="<?php the_author_meta( 'user_url', $uid ); ?>" />
                                                    </div>
                                                  </li>
                                                  <li class="form-twitter">
                                                    <label for="skype"><?php _e('Skype', 'EDULMS'); ?></label>
                                                    <div class="inner-sec">
                                                        <input class="text-input" name="skype" type="text" id="skype" value="<?php the_author_meta( 'skype', $uid ); ?>" />
                                                    </div>
                                                  </li>
                                                </ul>
                                                <div class="form-title">
                                                      <h4><?php _e('Social Media','EDULMS'); ?></h4>
                                                  </div>
                                                <ul class="upload-file">
                                                      <li class="form-facebook">
                                                          <label for="facebook"><?php _e('Facebook', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="facebook" type="text" id="facebook" value="<?php the_author_meta( 'facebook', $uid ); ?>" />
                                                          </div>
                                                      </li>
                                                      <li class="form-twitter">
                                                          <label for="twitter"><?php _e('Twitter', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="twitter" type="text" id="twitter" value="<?php the_author_meta( 'twitter', $uid ); ?>" />
                                                          </div>
                                                      </li>
                                                      <li class="form-lastfm">
                                                          <label for="lastfm"><?php _e('Linkedin', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="linkedin" type="text" id="linkedin" value="<?php the_author_meta( 'linkedin', $uid ); ?>" />
                                                          </div>
                                                      </li>
                                                      <li class="form-lastfm">
                                                          <label for="pinterest"><?php _e('Pinterest', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="pinterest" type="text" id="pinterest" value="<?php the_author_meta( 'pinterest', $uid ); ?>" />
                                                          </div>
                                                      </li>
                                                      <li class="form-lastfm">
                                                          <label for="lastfm"><?php _e('Google Plus', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="google_plus" type="text" id="google_plus" value="<?php the_author_meta( 'google_plus', $uid ); ?>" />
                                                          </div>
                                                      </li>
                                                      <li class="form-lastfm">
                                                          <label for="lastfm"><?php _e('Instagram', 'EDULMS'); ?></label>
                                                          <div class="inner-sec">
                                                              <input class="text-input" name="instagram" type="text" id="instagram" value="<?php the_author_meta( 'instagram', $uid ); ?>" />
                                                          </div>
                                                    </li>
                                                </ul>
                                                  <div class="form-title">
                                                      <h4><?php _e('Password Update','EDULMS')?></h4>
                                                  </div>
                                                  <ul class="upload-file">
                                                <li class="form-password">
                                                    <label for="pass1"><?php _e('New Password', 'EDULMS'); ?> </label>
                                                    <div class="inner-sec">
                                                      <input class="text-input" name="pass1" type="password" id="pass1" />
                                                    </div>
                                                </li><!-- .form-password -->
                                                <li class="form-password">
                                                    <label for="pass2"><?php _e('Repeat Password', 'EDULMS'); ?></label>
                                                    <div class="inner-sec">
                                                      <input class="text-input" name="pass2" type="password" id="pass2" />
                                                      <p><?php _e('Enter same password in both fields. Use an uppercase letter and a number for stronger password.','EDULMS');?></p>
                                                      
                                                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Save', 'EDULMS'); ?>" />
                                                        <?php wp_nonce_field( 'update-user' ) ?>
                                                        <input name="action" type="hidden" id="action" value="update-user" />
                                                    </div>
                                                </li><!-- .form-password -->
                                            </ul>
                                            </form><!-- #edituser -->
                                    <?php } ?>
                              </div>
                                <?php
                                }elseif(isset($_GET['action']) && $_GET['action'] == 'wishlist' && $current_user->ID == $uid){
                                    $width = 370;
                                    $height = 278;	
                                ?>
                                <div class="cs-section-title about-title"><h3><?php _e('Favorites','EDULMS');?></h3></div>
                                <div class="courses">
                                    <div class="row">
                                        <?php 
                                        global $post, $cs_theme_options;
                                        $user = cs_get_user_id();
                                        if(isset($user) && $user <> ''){
                                            $cs_wishlist = get_user_meta($user,'cs-courses-wishlist', true);
                                            if(is_array($cs_wishlist) AND !empty($cs_wishlist)){
                                                $cs_wishlist = array_filter( $cs_wishlist); 
                                            }
                                        }
                                        if(!empty($cs_wishlist) && count($cs_wishlist)>0){
                                        $args = array('post__in' => $cs_wishlist,'post_type'=> 'courses', 'order' => "ASC");
    
                                            $custom_query = new WP_Query($args);
                                            if( $custom_query->have_posts()){
                                                while ( $custom_query->have_posts() ): $custom_query->the_post();	
                                                    $course_id = $course_post_id = $post->ID;
                                                    $cs_course = get_post_meta($post->ID, "cs_course", true);
                                                    $user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
                                                    $user_course_data = get_option($course_id."_cs_user_course_data", true);
                                                    $course_user_ids = array();
                                                    if ( isset($user_course_data_array) && is_array($user_course_data_array) && count($user_course_data_array)>0) {
													    foreach ( $user_course_data_array as $members ){
                                                              $course_user_ids[] = $members['user_id'];
                                                        }
                                                    }
                                                    $course_data_array = array();
                                                    $user_course_data = array_unique($course_user_ids);
                                                        if ( $cs_course <> "" ) {
                                                            $cs_xmlObject = new SimpleXMLElement($cs_course);
                                                             $var_cp_course_id = $cs_xmlObject->course_id;
                                                            $course_duration = $cs_xmlObject->course_duration;
                                                            $var_cp_course_members = $cs_xmlObject->var_cp_course_members;
                                                            $var_cp_course_product = $cs_xmlObject->var_cp_course_product;
                                                        }
                                                        else{
                                                            $var_cp_course_product = $var_cp_course_members = $var_cp_course_product = '';
                                                            $course_duration ='';	
                                                        }
                                                        $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                                                        if($image_url == ''){
                                                           $course_class = ' no-img ';
                                                        }
                                                    ?>
                                                    <div class="wow col-md-4">
                                                        <article <?php post_class('cs-list list_v1 has_border');?> >
                                                                <div class="text-section">
                                                                    <div class="cs-top-sec">
                                                                        <div class="seideleft">
                                                                            <div class="left_position">
                                                                                <h2>
                                                                                    <a href="<?php the_permalink();?>" class="colrhvr">
                                                                                        <?php echo substr(get_the_title(),0,25).'...'; ?>
                                                                                    </a>
                                                                                </h2>
                                                                                <?php 
                                                                                 $reviews_args = array(
                                                                                    'posts_per_page'			=> "-1",
                                                                                    'post_type'					=> 'cs-reviews',
                                                                                    'post_status'				=> 'publish',
                                                                                    'meta_key'					=> 'cs_reviews_course',
                                                                                    'meta_value'				=> $post->ID,
                                                                                    'meta_compare'				=> "=",
                                                                                    'orderby'					=> 'meta_value',
                                                                                    'order'						=> 'ASC',
                                                                                 );
                                                                                $reviews_query = new WP_Query($reviews_args);
                                                                                $reviews_count = $reviews_query->post_count;
                                                                                $var_cp_rating = 0;
                                                                                if ( $reviews_query->have_posts() <> "" ) {
                                                                                    while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
                                                                                        $var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
                                                                                    endwhile;
                                                                                    wp_reset_query();
                                                                                }
                                                                                if($var_cp_rating){
                                                                                    $var_cp_rating = $var_cp_rating/$reviews_count;
                                                                                }
                                                                                 ?>
                                                                                <ul class="listoption">
                                                                                     <li>
                                                                                        <div class="cs-rating"><span class="rating-box" style="width:<?php echo esc_attr($var_cp_rating*20);?>%"></span></div>
                                                                                        <span class="cs-rating-desc">( <?php echo absint($reviews_count);?> <?php  echo _e('Reviews','EDULMS');
                                                                                        
                                                                                        
                                                                                        ?> )</span>
                                                                                    </li>
                                                                                     <?php 
                                                                                     if ( function_exists( 'cs_get_course_instructor' ) ) { cs_get_course_instructor($cs_xmlObject); }
                                                                                     ?>
                                                                                 </ul>
                                                                               </div>
                                                                        </div>
                                                                     </div>
                                                                     <a onclick="javascript:cs_delete_wishlist('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($course_id);?>')" class="custom-btn"><i class="fa fa-trash"></i><?php  echo _e('Remove','EDULMS');   ?></a>
                                                                      
                                                                  </div>
                                                        </article>
                                                    </div>
                                                    <?php  endwhile;
                                                    }else{
                                                        fnc_no_result_found();
                                                }
                                                wp_reset_query();
                                        }else{
                                            echo do_shortcode('[cs_message cs_message_style="btn_style" cs_message_icon="fa-lightbulb-o" cs_message_type="alert" cs_style_type="simp_info_messagebox" cs_message_close="no" cs_alert_style="threed_messagebox" ]No Favourite Course(s).[/cs_message]');	
                                        }
                                            ?>
                                        </div>
                                </div>
                                <?php
                            } ?>      
                        </div>
                   </div>
                </div>
                 <?php } ?>
            </div>
        </div>
    </section>            
<?php  get_footer(); ?>