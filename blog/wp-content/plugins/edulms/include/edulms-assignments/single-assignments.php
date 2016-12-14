<?php
/**
 * The template for displaying all Course related assignments
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
    get_header();
	global $post,$node,$woocommerce,$product;
 	$cs_layout = '';
	$user_id = cs_get_user_id();
	if ( have_posts() ) while ( have_posts() ) : the_post();
		$assignment_id = $post->ID;
	$width = 980;
	$height = 408;
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	$curriculm_id = $post->ID;
	$assignment_passing_marks = 30;
	$assignment_retakes_no = 1;
	$var_cp_course_assignment_type = '';
	$var_cp_course_paid = "";
	$assignment_upload_size = 2;
	$assignment_retake = 'no';
	if(isset($_REQUEST['course_id']) && $_REQUEST['course_id'] <> ''){
		$course_id = $course_ID = $_REQUEST['course_id'];
		$post_xml = get_post_meta($course_ID, "cs_course", true);	
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
			$course_duration = $cs_xmlObject->course_duration;
			$var_cp_course_members = (int)$cs_xmlObject->var_cp_course_instructor;
			if ( empty($cs_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
			$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
			
			$var_cp_course_cds_product = $cs_xmlObject->var_cp_course_cds_product;
				if(count($cs_xmlObject->course_curriculms )>0){
					foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
						$listing_type = $curriculm->listing_type;
						if($listing_type == 'assigment'){
							$var_cp_course_assignment = (int)$curriculm->var_cp_assignment_title;
								if($var_cp_course_assignment == $post->ID){
									$assignment_passing_marks = (int)$curriculm->assignment_passing_marks;
									$assignment_retakes_no = (int)$curriculm->assignment_retakes_no;
									$assignment_upload_size = (int)$curriculm->assignment_upload_size;
									$assignment_total_marks = (int)$curriculm->assignment_total_marks;
									$var_cp_assigment_type = $curriculm->var_cp_assigment_type;
									break;
								}
						}
					}
				}
		}
		$user_course_data = '';
		$user_subscription_count = '';
		$user_course_data = cs_course_members_count($course_ID);
		if(isset($user_course_data) && is_array($user_course_data)){
			if(isset($user_course_data['0']))
				$user_course_data = $user_course_data['0'];
			if(isset($user_course_data['1']))
				$user_subscription_count = $user_course_data['1'];
		}
		$user_right = cs_check_user_right($course_ID);
		$course_user_meta_array = get_option($user_id."_cs_course_data", true);
		if(isset($course_user_meta_array[$course_id]) && is_array($course_user_meta_array[$course_ID])){
			$transaction_id = $course_user_meta_array[$course_id]['transaction_id'];
			if(isset($transaction_id)){
				$user_course_data = get_option($course_ID."_cs_user_course_data", true);
				if(isset($course_user_meta_array[$course_ID]) && is_array($course_user_meta_array[$course_ID]) && is_array($course_user_meta_array[$course_ID]['transaction_id']) && $course_user_meta_array[$course_ID]['transaction_id'])
				$transaction_id = $course_user_meta_array[$course_ID]['transaction_id'];
			}
		} else {
			$assignment_retake = 'no';
		}
		
	}
	$noimg = '';
	if($image_url == '')
	 	$noimg = 'no-image';
	
	?>
   <!-- PageSection -->
    <section class="page-section" style=" padding: 0; ">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
                <div class="row">      
                    <div class="col-md-9">
                    <?php 
					if($var_cp_course_paid == 'registered_user_access' && !is_user_logged_in()){
								$assignment_permalink = add_query_arg( 'course_id', $course_ID, get_permalink() );
                                echo '<section >';
                                    echo '<div class="container">';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-9">';
                                                echo __('You need to login for this Assignment. ','EDULMS');
                                                echo '<a href="'. wp_login_url( $assignment_permalink ).'" title="Login">'.__('Login','EDULMS').'</a>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';					
                                echo '</section>';
						
					} else {
					
					if(isset($var_cp_course_paid) && $var_cp_course_paid == 'registered_user_access'){
						 $transaction_id = $course_ID;
					}
					if(isset($user_right) && ($user_right == '1' || $var_cp_course_paid == 'registered_user_access')){?>
                            <div class="assignment-detail">
                                    <div class="cs-course-info courselisting">
                                        <article <?php post_class($noimg);?>>
                                            <?php if($image_url <> ''){?>
                                                    <div class="row-sec">
                                                        <figure class="fig-<?php echo absint($post->ID);?>">
                                                            <img src="<?php echo esc_url($image_url);?>" alt="">
                                                        </figure>
                                                    </div>
                                             <?php }?>
                                        </article>
                                    </div>
                                    <?php 
                                    $qrystr= "";
                                    $assignment_attempt_no = 0;
                                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                    if (isset($var_cp_course_paid) && $var_cp_course_paid <> 'free'){
                                        $user_assingments_array = get_user_meta($user_id,'cs-user-assignments', true);
                                       $assignment_complete_key = $user_id.'_'.$transaction_id.'_'.$assignment_id;
                                       $assignment_complete = get_option($assignment_complete_key);
                                        if(!isset($assignment_complete)){
                                            $assignment_complete = 1;
											update_option($assignment_complete_key, '1');
                                        } else if(isset($assignment_complete) && $assignment_complete == ''){
                                            $assignment_complete = 1;
											update_option($assignment_complete_key, '1');
                                        }
										$assignment_complete = $assignment_complete-1;
                                        $user_assingments_data = array();
                                        $assignment_attempt_no = $assignment_complete;
                                        if(isset($user_assingments_array) && is_array($user_assingments_array) && count($user_assingments_array)>0){
                                            $assingment_id_array = array();
                                            $assignment_id = (int)$assignment_id;
                                            if(isset($user_assingments_array[$transaction_id])){
                                                if(isset($user_assingments_array[$transaction_id][$assignment_id])){
                                                    $assingment_id_array = $user_assingments_array[$transaction_id][$assignment_id];
                                                }
                                                if (array_key_exists('course_assignment_info', $assingment_id_array)) {
                                                    $assignment_attempt_no = $assingment_id_array['assingment_attempt_info']['assignment_attempt_no'];
													$assignment_attempt_no = $assignment_attempt_no-1;
                                                }
                                            }
                                        }
                                        if($assignment_retakes_no>$assignment_attempt_no)
                                            $assignment_retake = 'yes';
                                        else
                                            $assignment_retake = 'no';
                                    }
                                    ?>
                                     <div class="cs-assignment-detail">
                                        <?php 
                                            echo '<div class="cs-assignment-start">';
                                              
                                                echo '<h2>'.__('Assignment Detail', 'EDULMS').'</h2>';
                                                echo '<div class="assignment-instructions">';
                                                    echo '<span>'.__('Assignment Name', 'EDULMS').': '.get_the_title().'</span>';			
                                                    echo '<span>'.__('Attempts: Allowed', 'EDULMS').' '.$assignment_retakes_no.' '.__('Completed', 'EDULMS').' '.$assignment_attempt_no.'</span>';						
                                                echo '</div>';
                                                echo '<h2>Instructions</h2>';
                                                the_content();
                                                wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'EDULMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                                               if(!isset($_REQUEST['start_assignment']) || (isset($_REQUEST['start_assignment']) && $_REQUEST['start_assignment'] <> 'start')){ 
                                                 if($assignment_retake == 'yes'){
                                                    $array_params = array( 'course_id' => $course_ID, 'start_assignment' => 'start' );
                                                    $assignment_permalink = add_query_arg( $array_params, get_permalink());
                                                    
                                                    echo '<p><br/><br/></p><div class="assignment-btn"><a href="'.$assignment_permalink.'" class="custom-btn circle cs-bg-color add-assignment-btn">'.__('Add Assignments', 'EDULMS').'</a></div>';
                                                 }
											   }
                                            echo '</div>';
                                            ?>
                                        </div>
                                    <?php 
                                    if($assignment_retake == 'yes' && isset($_REQUEST['start_assignment']) && $_REQUEST['start_assignment'] == 'start'){
										if(!isset($var_cp_course_paid) || $var_cp_course_paid <> ''){$var_cp_course_paid = 'registered_user_access';}
                                        ?>
                                        <div class="clear"></div>
                                        <div class="cs-add-assignments-model">
                                            <div id="loading"></div>
                                            <form name="c-assignments-form" id="cs-assignments-form" enctype="multipart/form-data">
                                                <input type="hidden" name="action" value="cs_assignment_submission" />
                                                <input type="hidden" name="assignment_id" value="<?php echo absint($post->ID);?>" />
                                                <input type="hidden" name="user_id" value="<?php echo absint($user_id);?>" />
                                                <input type="hidden" name="course_type" value="<?php echo esc_attr($var_cp_course_paid);?>" />
                                                <input type="hidden" name="transaction_id" value="<?php echo esc_attr($transaction_id);?>" />
                                                <input type="hidden" name="course_id" value="<?php echo absint($course_ID);?>" />
                                             
                                              <ul class="asg-form-elements">
                                                    <li>
                                                        <label><?php _e('Assignment Title','EDULMS');?></label>
                                                        <input type="text" id="assignments_title" name="assignments_title" value="" />
                                                    </li>
                                                    <li>
                                                        <label><?php _e('Assignment Description','EDULMS');?></label>
                                                        <textarea name="assignments_description" id="assignments_description"></textarea>
                                                    </li>
                                                    <li>
                                                        <label><?php _e('Assignments Attachment','EDULMS');?></label>
                                                        <input type="file" name="assignment_upload_attachment" /><div class="clear"></div>
                                                        <label><?php _e('Please upload file with extension','EDULMS');?><?php echo esc_attr($var_cp_assigment_type);?>.</label>
                                                    </li>
                                                </ul>
                                              <div class="asgn-footer">
                                                <label><?php _e('Maximum upload File size allowed '.$assignment_upload_size.'MB','EDULMS');?></label>
                                                <button type="button" class="custom-btn cs-bg-color" onclick="cs_assignments_submission('<?php echo esc_url(admin_url('admin-ajax.php'));?>', '<?php echo esc_url(get_template_directory_uri())?>');"><?php _e('Save changes','EDULMS');?></button>
                                              </div>
                                              </form>
                                        </div><!-- /.modal -->
                                     <?php }?>
                               </div>
                        <?php }
						
					}
						
                        if(isset($var_cp_course_paid) && $var_cp_course_paid <> 'registered_user_access' && (!isset($transaction_id) || empty($transaction_id))){
                             ?>
                             <h2><?php _e('Please Subscribe to Course for Assignment','EDULMS');?></h2>
                             <?php
                        }
                        ?>
                    </div>
                    <aside class="sidebar-right col-md-3">
                         <div class="courses courselisting">
                              <?php 
                             if(isset($course_ID) && $course_ID <> ''){
                                $var_cp_course_instructor =  get_post_meta( $course_ID, 'var_cp_course_instructor', true);
                                $cs_user_data = get_userdata((int)$var_cp_course_instructor);
                                /* Course Detail Information */
								if(!isset($user_course_data)) $user_course_data = '';
                                cs_course_detail_info_widget($course_ID,$user_course_data,$var_cp_course_product,$var_cp_course_paid);
                                /* Course  Instructor Information */
                                if($cs_user_data <> ''){ 
                                    cs_course_instructor_widget($course_ID,$cs_user_data);
                                }
                                /* Course Product CD INFO */
                                if(isset($var_cp_course_cds_product) && $var_cp_course_cds_product <> ''){
                                    cs_course_cd_widget($post->ID,$var_cp_course_cds_product);
                                }
                                /* Course Recent Views */
                                cs_course_recent_reviews_widget($course_ID);
                             }
                           ?>
                        </div>
                    </aside>
               </div>
       </div>   
    </section>                                                       
 <?php 
 endwhile;
 get_footer();