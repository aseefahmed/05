<?php
/**
 * The template for displaying all Course related Curriculums
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
get_header();
	global $node,$woocommerce,$product;
 	$cs_layout = '';
	$user_id = cs_get_user_id();
	if ( isset ( $_REQUEST['course_id'] ) && $_REQUEST['course_id'] !='' ) {
		$cs_meta_course = get_post_meta($_REQUEST['course_id'], "cs_course", true);
		$cs_xmlObject_course = new SimpleXMLElement($cs_meta_course);
	} else { 
		$cs_xmlObject_course = '';
	}
	
	if ( empty($cs_xmlObject_course->dynamic_post_course_view) ) $dynamic_post_course_view = ""; else $dynamic_post_course_view = $cs_xmlObject_course->dynamic_post_course_view;
	if ( have_posts() ) while ( have_posts() ) : the_post();
		$cs_meta_curriculum = get_post_meta($post->ID, "cs_meta_curriculum", true);
		if ( $cs_meta_curriculum <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_meta_curriculum);
			$var_cp_curriculum_type = $cs_xmlObject->var_cp_curriculum_type;
			$var_cp_curriculum_text = $cs_xmlObject->var_cp_curriculum_text;
			$var_cp_file = $cs_xmlObject->var_cp_file;
			$curriculm_duration = $cs_xmlObject->curriculm_duration;
			$course_curriculm_section_title = '<i class="fa fa-folder-open"></i> '.__('Course curriculum','EDULMS');
		}
	
	$width = 980;
	$height = 408;
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	$curriculm_id = $post->ID;
	if(isset($_REQUEST['course_id']) && $_REQUEST['course_id'] <> ''){
		$course_id = $course_ID = $_REQUEST['course_id'];
		$post_xml = get_post_meta($course_ID, "cs_course", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$course_duration = $cs_xmlObject->course_duration;
		$var_cp_course_members = (int)$cs_xmlObject->var_cp_course_instructor;
		if ( empty($cs_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
		if ( empty($cs_xmlObject->course_curriculums_tabs_display) ) $course_curriculums_tabs_display = ""; else $course_curriculums_tabs_display = $cs_xmlObject->course_curriculums_tabs_display;
		$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
   	}
	$user_access = 0;
	$display_course = 0;
	$user_subscription_count = 0;
	$user_course_data = 0;
	$user_access_array = cs_user_course_access($var_cp_course_paid, $course_ID, $course_curriculums_tabs_display);
	if(isset($user_access_array) && is_array($user_access_array)){
		$user_access = $user_access_array['user_access'];
		$display_course = $user_access_array['display_course'];
	}
	$course_id = $course_ID;
	$user_right = cs_check_user_right($course_ID);

	}
	?>
   <!-- PageSection -->
        <section class="page-section" style=" padding: 0; ">
            <!-- Container -->
            <div class="container">
                <!-- Row -->
                    <div class="row">      
                        <?php if (  isset ( $course_id )  && $course_id != '' ) {?>
                            <div class="section-content">
                            	<div class="curriculm-detail">
                                <?php if (isset($var_cp_course_paid) && (($var_cp_course_paid <> 'registered_user_access' && cs_get_user_id() <> '' && $user_right == '1') || ($var_cp_course_paid == 'registered_user_access'))) {?>
                                    
                                        <div class="col-md-12">
                                            <div class="courselisting">
                                             <h2><?php the_title();?></h2>
                                            <h2><?php the_content();?></h2>
                                            <?php if($var_cp_curriculum_type == 'Text'){?>
                                                <h2><?php //the_title();?></h2>
                                                <div class="paging">
                                                <?php 
                                                    $posts_list	= array();
                                                    foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
                                                        $listing_type = $curriculm->listing_type;
                                                        if ( $listing_type == 'curriculum' ){
                                                                if ( $var_cp_course_paid == 'free' ){
                                                                    $posts_list[]	=   (int)$curriculm->var_cp_course_curriculum;
                                                                } else {
                                                                    $posts_list[]	=   (int)$curriculm->var_cp_course_curriculum;
                                                                }
                                                        }
                                                    }
                                                    px_next_prev_curriculum_links('cs-curriculums',$course_id,$posts_list);
                                                ?>
                                            </div>
                                           <?php }?>
                                           
                                        </div>
                                        </div>
                                        <?php 
                                        $qrystr= "";
                                        if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                        ?>
                                        <div class="col-md-12">
                                            <div class="detail_text rich_editor_text">
                                                <div class="detailpost">
                                          <?php 
                                                if($var_cp_curriculum_type=='Text'){
                                                    //the_content();
                                                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'EDULMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                                                    edit_post_link(__('Edit', 'EDULMS'),'<span class="edit-link">','</span>');
                                                    
                                                } elseif($var_cp_curriculum_type == "Video" and $var_cp_curriculum_type <> '' and $var_cp_file <> ''){
                                                     $url = parse_url($var_cp_file);
                                                     if($url['host'] == $_SERVER["SERVER_NAME"]){
                                                     ?>
                                                     <video width="<?php echo esc_attr($width);?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo esc_url($var_cp_file) ?>"  id="player1" poster="<?php echo esc_url($image_url);  ?>" controls="controls" preload="none"></video>
                                                    <?php
                                                    }else{
                                                        echo wp_oembed_get($var_cp_file, array('width'=>$width, 'height'=>$height) );
                                                    }
                                            } elseif($var_cp_curriculum_type == "Audio" and $var_cp_curriculum_type <> '' && $var_cp_file<>''){
                                               ?>
                                               <figure class="detail_figure">
                                                    <audio controls width="100%">
                                                        <source src="<?php echo esc_url($var_cp_file); ?>" type="audio/mpeg">
                                                    </audio>
                                                </figure>
                                                <?php
                                             }
                                             ?>
                                            
                                            </div>
                                            </div>
                                         </div>
                                            <?php 
                                            $user_curriculms_mark_read = get_post_meta($post->ID, "cs_user_curriculms_mark_read", true);
                                            if ( $user_curriculms_mark_read ) {
                                                if(!isset($user_curriculms_mark_read[$user_id][$post->ID]) && $user_curriculms_mark_read[$user_id][$post->ID] <> '1' && isset($user_id) && $user_id <> ''){
                                                ?>
                                                    <div class="col-md-12">
                                                        <div class="curriculm-mark-read-btn">
                                                            <button type="button" class="btn btn-primary" onclick="cs_curriculm_mark_read('<?php echo absint($post->ID)?>','<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>');"><?php _e('Mark Read','EDULMS');?></button>
                                                        </div>
                                                    </div>
                                                <?php 
                                                }
                                            }
											
											
											?>
                                     
                                <?php } else {
										 ?>
										 <h2><?php _e('Please Subscribe to Course for curriculums','EDULMS');?></h2>
										 <?php
									  }
								?>
                                </div>
                            </div>
                            <aside class="course-sidebar">
                                 <div class="courses courselisting"> 
                                     <div class="cs-curriculum fullwidth" id="course-curriculam">
                                        <div class="cs-section-title"><h2><?php echo $course_curriculm_section_title;?></h2></div>
                                         <?php if(count($cs_xmlObject->course_curriculms )>0){
                                                $assignments_counter = 0;
                                                echo '<ul>';
                                                     foreach ( $cs_xmlObject->course_curriculms as $curriculm ){				 
                                                        $var_cp_course_id = (int)$curriculm->var_cp_course_curriculum;
                                                        $iconType	= '';
                                                        if ( $var_cp_course_id && $var_cp_course_id != '0' ) {
                                                            $var_cp_curriculum_type = get_post_meta((int)$curriculm->var_cp_course_curriculum, "cs_meta_curriculum", true);
                                                            $cs_xmlObject_type = new SimpleXMLElement($var_cp_curriculum_type);
                                                            $iconType	= $cs_xmlObject_type->var_cp_curriculum_type;
                                                        }
                                                        if ( $iconType == 'Audio' ) {
                                                            $icon	= 'fa-microphone';
                                                        } else  if ( $iconType == 'Video') {
                                                            $icon	= 'fa-play-circle';
                                                        } else {
                                                            $icon	= 'fa-file';
                                                        }
                                                        $listing_type = $curriculm->listing_type;
                                                        $listing_type_class = '';
                                                        if($listing_type == 'title'){
                                                            $listing_type_class = 'listing_type_title';
                                                        }
                                                       	echo '<li class="'.$listing_type_class.' post-'.(int)$curriculm->var_cp_course_curriculum.'">';
                                                        if($listing_type == 'title'){
                                                            echo '<div class="cs-curriculm-sections">';
                                                                echo esc_attr($curriculm->subject_title);
                                                            echo '</div>';
                                                        } else if($listing_type == 'assigment'){
                                                                $icon_curriculms = '<div class="rg-sec"><a class="cr-button cs-assignment">Assignment</a></div>';
                                                                $assignments_counter++;
                                                                $var_cp_assignment_title = (int)$curriculm->var_cp_assignment_title;
                                                                $assignment_permalink = add_query_arg( 'course_id', $course_ID, get_permalink($var_cp_assignment_title) );
                                                                $assignment_popup = 1;
                                                                if($var_cp_course_paid <> 'registered_user_access' && cs_get_user_id() <> '' && $user_right == '1'){
                                                                     echo '<i class="fa '.$icon.'"></i><a href="'.$assignment_permalink.'" >'.get_the_title($var_cp_assignment_title).'</a>'.$icon_curriculms;
                                                                } else if ( $var_cp_course_paid == 'registered_user_access'){
                                                                     echo '<i class="fa '.$icon.'"></i><a href="'.$assignment_permalink.'" >'.get_the_title($var_cp_assignment_title).'</a>'.$icon_curriculms;
                                                                     $assignment_popup = 0;
                                                                 } else {
                                                                     $assignment_popup = 0;
                                                                     echo'<i class="fa fa-lock"></i>'. get_the_title($var_cp_assignment_title).$icon_curriculms;
                                                                 }
                                                            } else if($listing_type == 'quiz'){
                                                                $icon_curriculms	= '<div class="rg-sec"><a class="cr-button cs-quiz">Quiz</a></div>';
                                                                $var_cp_course_quiz_list = (int)$curriculm->var_cp_course_quiz_list;
                                                                $var_cp_course_quiz_type = $curriculm->var_cp_course_quiz_type;
                                                                $quiz_permalink = add_query_arg( 'course_id', $course_ID, get_permalink($var_cp_course_quiz_list) );
                                                                if($var_cp_course_paid == 'registered_user_access'){
                                                                     echo '<i class="fa '.$icon.'"></i><a href="'.$quiz_permalink.'">'.get_the_title($var_cp_course_quiz_list).'</a>'.$icon_curriculms;	 
                                                                 } else if($var_cp_course_paid <> 'registered_user_access' && cs_get_user_id() <> '' && $user_right == '1'){
                                                                     echo '<i class="fa '.$icon.'"></i><a href="'.$quiz_permalink.'">'.get_the_title($var_cp_course_quiz_list).'</a>'.$icon_curriculms;
                                                                 } else {
                                                                     echo '<i class="fa fa-lock"></i>'.get_the_title($var_cp_course_quiz_list).$icon_curriculms;
                                                                 }
															} else if($listing_type == 'curriculum'){
																	$icon_curriculms	= '';
																	$var_cp_course_curriculum = (int)$curriculm->var_cp_course_curriculum;
																	$curriculum_permalink = add_query_arg( 'course_id', $course_ID, get_permalink($var_cp_course_curriculum) );
																	if ( ( cs_get_user_id() <> '' && $user_right == '1' && $var_cp_course_paid == 'paid') || ($var_cp_course_paid == 'registered_user_access' && cs_get_user_id() <> '') ) {
																		 echo '<i class="fa '.$icon.'"></i><a href="'.$curriculum_permalink.'">'.get_the_title($var_cp_course_curriculum).'</a>'.$icon_curriculms;
																	} else if ( $var_cp_course_paid == 'registered_user_access' ) {
																		 echo '<i class="fa '.$icon.'"></i><a href="'.$curriculum_permalink.'">'.get_the_title($var_cp_course_curriculum).'</a>'.$icon_curriculms;
																	 } else {
																		 echo '<i class="fa fa-lock"></i>'.get_the_title($var_cp_course_curriculum).$icon_curriculms;
																	 }
															}
                                                        echo '</li>';
                                                     }
                                                echo '</ul>';	 
                                         } ?>
                                    </div>
                                </div>
                            </aside>
                        <?php }?>
                   </div>
           </div>   
        </section>                                                       
 <?php 
 endwhile;
 get_footer(); ?>