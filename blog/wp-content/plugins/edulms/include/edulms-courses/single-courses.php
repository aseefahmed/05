<?php
/**
 * The template for displaying all Single Courses
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */

    get_header();
	global $post,$node,$cs_course_options,$cs_theme_options,$woocommerce,$product,$cs_xmlObject, $current_user;
 	$cs_layout = '';
	$activeClass	= '';
	$user_id = cs_get_user_id();
	$cs_course_options = $cs_course_options;
	$user_right = '';
	$bgcolor_style = '';
	$width = '370';
	$height = '278';
	$leftSidebarFlag	= false;
	$rightSidebarFlag	= false;
	$isDouble	= false;
	if ( have_posts() ) while ( have_posts() ) : the_post();
	$post_xml = get_post_meta($post->ID, "cs_course", true);	
	$var_cp_course_product = '';
	$args = array(
		'post_type'  => 'product',
		'meta_key'   => 'cs_select_course',
		'meta_value' => $post->ID,
		'meta_compare' => '=',
		'order'      => 'ASC'
		
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ): $the_query->the_post(); 
			$var_cp_course_product = get_the_ID();
		endwhile;
	}
	wp_reset_postdata();
	$cs_lms = get_option('cs_lms_plugin_activation');	
	$course_id = $course_ID = $post->ID;
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
 		$cs_layout = $cs_xmlObject->sidebar_layout->cs_page_layout;
 		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_page_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_page_sidebar_right;
		$course_duration = $cs_xmlObject->course_duration;
		if ( empty($cs_xmlObject->course_event_excerpt_length) ) $course_event_excerpt_length = "255"; else $course_event_excerpt_length = $cs_xmlObject->course_event_excerpt_length;
		$var_cp_course_members = $cs_xmlObject->var_cp_course_members;
		$var_cp_course_instructor = (int)$cs_xmlObject->var_cp_course_instructor;
		if ( empty($cs_xmlObject->var_cp_course_paid) ) $var_cp_course_paid = ""; else $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
		if ( empty($cs_xmlObject->course_curriculums_tabs_display) ) $course_curriculums_tabs_display = ""; else $course_curriculums_tabs_display = $cs_xmlObject->course_curriculums_tabs_display;
		if ( empty($cs_xmlObject->dynamic_post_course_view) ) $dynamic_post_course_view = ""; else $dynamic_post_course_view = $cs_xmlObject->dynamic_post_course_view;
		if ( empty($cs_xmlObject->course_subheader_bg_color) ) $course_subheader_bg_color = ""; else $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
		if($course_subheader_bg_color <> ''){
			$bgcolor_style = 'background-color: '.$course_subheader_bg_color.';';	
		}
		$user_access = 0;
		$display_course = 0;
		$user_access_array = cs_user_course_access($var_cp_course_paid, $course_ID, $course_curriculums_tabs_display);
		
		if(isset($user_access_array) && is_array($user_access_array)){
			$user_access = $user_access_array['user_access'];
			$display_course = $user_access_array['display_course'];
		}
		$course_breif_section_display_title = '<i class="fa fa-graduation-cap"></i> '.__('Course Brief','EDULMS');
		$course_event_section_title = '<i class="fa fa-calendar"></i> '.__('Events','EDULMS');
		$course_reviews_section_display_title = '<i class="fa fa-star-o"></i> '.__('Reviews','EDULMS');
		$course_members_section_title = '<i class="fa fa-users"></i> '.__('Members','EDULMS');
		$course_curriculm_section_title = '<i class="fa fa-folder-open"></i> '.__('Course Units','EDULMS');
		$dynamic_post_faq_title = '<i class="fa fa-question-circle"></i> '.__('FAQS','EDULMS');
		
		//$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
 		$sectionRightSidebar	= '';
		if ( $cs_layout == "left") {
			$cs_layout = "page-content";
			$leftSidebarFlag	= true;
			$isDouble	= true;
 		} else if ( $cs_layout == "right" ) {
			$cs_layout = "page-content";
			$rightSidebarFlag	= true;
			$sectionRightSidebar	= 'sec-right-bar';
			$isDouble	= true;
 		} else {
			$cs_layout = "section-fullwidth";
		}
  	} else {
		$course_duration = '';
		$var_cp_course_product = '';
 	}
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	$user_course_data = '';
	$user_subscription_count = 0;
	$user_course_members_data = cs_course_members_count($course_ID);
	if ( isset($user_course_members_data) && is_array($user_course_members_data) && count($user_course_members_data)>0) {
		if(isset($user_course_members_data['0']))
			$user_course_data = $user_course_members_data['0'];
		if(isset($user_course_members_data['1']))
			$user_subscription_count = $user_course_members_data['1'];
	}
	$user_right = cs_check_user_right($post->ID);
	//$course_user_meta_array = get_user_meta($user_id, "cs_user_course_meta", true);
	$course_user_meta_array = get_option($user_id."_cs_course_data", true);
	if(isset($course_user_meta_array[$course_ID]) && is_array($course_user_meta_array[$course_ID]) && $course_user_meta_array[$course_ID]['transaction_id']){
		$transaction_id = $course_user_meta_array[$course_ID]['transaction_id'];
	}
	
	?>
<!-- PageSection -->
<section class="page-section <?php echo esc_attr($dynamic_post_course_view);?>" style=" padding: 0; ">
    <!-- Container -->
    <div class="container">
	   <?php if($dynamic_post_course_view == 'Fullwidth'){
                 if($cs_xmlObject->course_short_description <> '' || $cs_xmlObject->course_tags_show == 'on' || $image_url <> ''){?>
                     <?php cs_course_shortdescription_area();?>
            <?php 		
                }
            }
        ?>
        <!-- Row -->
            <div class="row"> 
                <!--Left Sidebar Starts-->
                <?php if ($leftSidebarFlag == true){ ?>
                   <aside class="page-sidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
                   <?php wp_reset_query();
				 } ?>
                <!--Left Sidebar End-->
                <div class="<?php echo esc_attr($cs_layout);?>">
                    	<?php
						/*$user_meta = get_user_meta(get_current_user_id());
						$user_badges = $user_meta["user_badges"];
						$user_badges = unserialize($user_badges[0]);
						if(is_array($user_badges)){
							$b_count = 0;
							foreach($user_badges as $b){
								$b_count++;
							}
						}*/
						?>
                        <!-- Row -->
                            <!--Course Detail Info Start-->
                            <div class="section-content">
                            <?php if($dynamic_post_course_view == 'InPost'){
									 if($cs_xmlObject->course_short_description <> '' || $cs_xmlObject->course_tags_show == 'on' || $image_url <> ''){
										   cs_course_shortdescription_area();
									 }
                           		 }
								$reviews_count = cs_course_reviews_count($post->ID);
								$tab_view = $cs_xmlObject->cs_tabs_style;
								
									if ( $tab_view  == 'modren') {
										$cs_tab_view = 'cs_assigment_tabs';
										$ContentClass		= 'detail_text rich_editor_text'; 
										$tabSidebarStart	= '';
										$tabSidebarEnd		= '';
										$tabBgStart			= '';
										$tabBgEnd			= '';
										$tabRowStart		= '';
										$tabRowEnd			= '';
										$listId	 			= ' id="scroll-nav"';
									} else{
										$cs_tab_view 		= 'shortcode-nav';
										if ( $isDouble == true ) {
											$tabSidebarStart	= '<aside class="col-md-12">';
										} else {
											$tabSidebarStart	= '<aside class="col-md-3">';
										}
										
										$tabSidebarEnd		= '</aside>';
										$tabBgStart			= '<div class="navin cs-bg-color">';
										$tabBgEnd			= '</div>';
										$tabRowStart		= '';
										$tabRowEnd			= '';
										$listId	 			= ' id="scroll-nav"';
										if ( $isDouble == true ) {
											$ContentClass		= 'col-md-12'; 
										} else {
											$ContentClass		= 'col-md-9'; 
										}
										
									}
                                    $qrystr= "";
                                    $leftTabs	= false;
									if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                    
									if ( $tabSidebarStart == '<aside class="col-md-3">' ) {
                                      	$leftTabs	= true;
                                    }
									
									$colSettingStart	= '';
									$colSettingEEnd		= '';
										
									if ( 	$leftTabs == true &&  $isDouble == false ) {
										$colSettingStart	= '';
										$colSettingEEnd		= '';
									} else if ( $leftTabs == false &&  $isDouble == true ) {
										if ( $tab_view  == 'modren' ) {
											$colSettingStart	= '<div class="col-md-12">';
											$colSettingEEnd		= '</div>';
										}
									} else if ( $leftTabs == false &&  $isDouble == false ) {
										$colSettingStart	= '<div class="col-md-12">';
										$colSettingEEnd		= '</div>';
									} 
									
									if ($user_access == 1 || $display_course == 1) {
									
									 echo balanceTags($tabSidebarStart, false);
                                    
									 echo balanceTags($colSettingStart, false); 
									 ?>
                                         <nav class="<?php echo esc_attr($cs_tab_view);?>">
                                           <?php echo balanceTags($tabBgStart, false);?>
                                            <ul<?php echo balanceTags($listId, false);?>>
                                            <?php
											$get_course = isset($_GET['courses']) ? $_GET['courses'] : 0;
											$tabs_link = home_url().'?courses='.$get_course;
											$tabs_link = get_permalink();
											
                                            if ( isset($cs_xmlObject->course_breif_section_display) && (string)$cs_xmlObject->course_breif_section_display == 'on' && ($user_access == 1 || $display_course == 1) ){
                                                     if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-breif'){
                                                        $activeClass	= 'active';
                                                    } else {
                                                             $activeClass	= '';
															 if (isset($_GET['filter_action']) && $_GET['filter_action'] <> ''){
															  	 $is_Filter	= $_GET['filter_action'];
															 } else {
															 	 $is_Filter	= '';
															 }
															
                                                             if ( $is_Filter == ''){
                                                                $activeClass	= 'active';
                                                             }
                                                        }
                                                ?>
                                                <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-breif', get_permalink() );?>"><?php echo balanceTags($course_breif_section_display_title, false);?></a></li>
                                            <?php 
                                            }
                                            if ( isset($cs_xmlObject->course_curriculm_section_display) && (string)$cs_xmlObject->course_curriculm_section_display == 'on' && ($user_access == 1 || $display_course == 1) ){
                                                    if(count($cs_xmlObject->course_curriculms )>0){
                                                        if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-curriculm'){
                                                            $activeClass	= 'active';
                                                        } else {
                                                            $activeClass	= '';
                                                        }
                                                ?>
                                                        <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-curriculm', get_permalink() );?>"><?php echo balanceTags($course_curriculm_section_title, false);?></a></li>
                                                <?php
                                                     }                                       
                                            }
                                            if ( isset($cs_xmlObject->course_quiz_section_display) && (string)$cs_xmlObject->course_quiz_section_display == 'on' && ($user_access == 1 || $display_course == 1) ){
                                                    if(count($cs_xmlObject->course_curriculms )>0){
                                                        if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-curriculm'){
                                                            $activeClass	= 'active';
                                                        } else {
                                                            $activeClass	= '';
                                                        }
                                                ?>
                                                        <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-curriculm', get_permalink() );?>"><?php echo balanceTags($course_curriculm_section_title, false);?></a></li>
                                                <?php
                                                     }                                       
                                            }
                                            if ( isset($cs_xmlObject->course_members_section_display) && (string)$cs_xmlObject->course_members_section_display == 'on' && ($user_access == 1 || $display_course == 1) ){
                                                
                                                if(isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0){
                                                    if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-members'){
                                                        $activeClass	= 'active';
                                                    } else {
                                                            $activeClass	= '';
                                                    }
                                                ?>
                                                <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-members', get_permalink() );?>"><?php echo balanceTags($course_members_section_title, false);?></a></li>
                                                <?php
                                                }
                                            }
                                            if ( isset($cs_xmlObject->course_events_section_display) && (string)$cs_xmlObject->course_events_section_display == 'on' && ($user_access == 1 || $display_course == 1) ){
                                                if(isset($cs_xmlObject->var_cp_course_event) && $cs_xmlObject->var_cp_course_event<> ''){
                                                    $course_event = array();
                                                    $course_event = explode(',',$cs_xmlObject->var_cp_course_event);
                                                    if(isset($course_event)){
                                                        if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-events'){
                                                            $activeClass	= 'active';
                                                       } else {
                                                            $activeClass	= '';
                                                       }
                                            ?>
                                                <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-events', get_permalink() );?>"><?php echo balanceTags($course_event_section_title, false);?></a></li>
                                                 <?php 
                                                    }
                                                }
                                            }
                                            if ( class_exists('faq_functions') && ($user_access == 1 || $display_course == 1) ){
												if ( isset($cs_xmlObject->dynamic_post_faq_display) && $cs_xmlObject->dynamic_post_faq_display == 'on'){
                                                    if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-faqs'){
                                                        $activeClass	= 'active';
                                                    } else {
                                                        $activeClass	= '';
                                                    }
                                                    ?>
                                                    <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-faqs', get_permalink() );?>"><?php _e('FAQs', 'EDULMS'); ?></a></li>
                                                <?php 
												}
                                            }
                                            if ( isset($cs_xmlObject->course_reviews_section_display) && $cs_xmlObject->course_reviews_section_display == 'on' && ($user_access == 1 || $display_course == 1)){
                                                    if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'course-reviews'){
                                                        $activeClass	= 'active';
                                                    } else {
                                                            $activeClass	= '';
                                                    }
                                                ?>
                                                <li class="<?php echo esc_attr($activeClass);?>"><a href="<?php echo add_query_arg( 'filter_action', 'course-reviews', get_permalink() );?>"><?php echo balanceTags($course_reviews_section_display_title, false);?></a></li>
                                        <?php
                                        }
                                        ?>
                                            </ul>
                                           <?php echo balanceTags($tabBgEnd, false);?>
                                           </nav>
									<?php echo balanceTags($colSettingEEnd, false);?>
                                    
									<?php echo balanceTags($tabSidebarEnd, false);?>
                                   
                                    <?php }?>
									
										<?php echo balanceTags($colSettingStart, false);?>
                                   		<div class="<?php echo esc_attr($ContentClass);?>">
                                        <?php 
                                        if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-curriculm' && ($user_access == 1 || $display_course == 1)){?>
                                        <div class="cs-curriculum fullwidth" id="course-curriculam">
                                            <?php 	
												if(count($cs_xmlObject->course_curriculms )>0){
													$assignments_counter = 0;
												echo '<ul>';
												$freeButton	= '<div class="rg-sec cs-free"><a class="cr-button">Free</a></div>';
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
															if ( ( cs_get_user_id() <> '' && $user_right == '1' && $var_cp_course_paid <> 'registered_user_access') || ($var_cp_course_paid == 'registered_user_access' && cs_get_user_id() <> '') ) {
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
												 }	  
                                             ?>
                                        </div>
                                     <?php } 
									 
									 	else if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-members'  && ($user_access == 1 || $display_course == 1)){?>
                                        <div class="course-members" id="buddypress">
											<?php 
                                            $use_group = array();
                                            if(isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0){
                                                ?>
                                                <div class="cs-member dir-list" id="members-dir-list">      
                                                  <ul class="item-list" id="members-list">
                                                 <?php
                                                    $members_counter = 0;
													if(isset($cs_course_options['cs_dashboard'])){ $cs_page_id =$cs_course_options['cs_dashboard']; }else{ $cs_page_id ='';}
                                                    foreach($user_course_data as $course_data){
                                                        $cs_user_data = get_userdata($course_data);
                                                         if($cs_user_data <> ''){ 
                                                            $members_counter++;
                                                        ?>
                                                                <li>
                                                                  <figure>
                                                                        <?php 
																		$user_profile_public = get_the_author_meta('user_profile_public',$cs_user_data->ID );
																		if( isset( $cs_page_id ) && $cs_page_id !='' && isset($user_profile_public) && $user_profile_public=='1' ){
																			$array_params = array( 'action' => 'dashboard', 'uid' => absint($cs_user_data->ID) );
																			$member_permalink = add_query_arg( $array_params, get_permalink($cs_page_id));
																			?>
                                                                       		<a href="<?php echo esc_url($member_permalink);?>">
                                                                        <?php } else { ?>
                                                                        	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID',$cs_user_data->ID)); ?>">
                                                                        <?php }?>
                                                                        <?php echo get_avatar($cs_user_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 60));?>
                                                                       		</a>
                                                                   </figure>
                                                                    <div class="left-sp">
                                                                       <h4>
                                                                        <?php 
																			$user_profile_public = get_the_author_meta('user_profile_public',$cs_user_data->ID );
																			if( isset( $cs_page_id ) && $cs_page_id !='' && isset($user_profile_public) && $user_profile_public=='1' ){
																				$array_params = array( 'action' => 'dashboard', 'uid' => absint($cs_user_data->ID) );
																				$member_permalink = add_query_arg( $array_params, get_permalink($cs_page_id));
																				?>
                                                                       		<a href="<?php echo esc_url($member_permalink);?>">
                                                                        <?php } else { ?>
                                                                        	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID',$cs_user_data->ID)); ?>">
                                                                        <?php }?>
																			<?php echo esc_attr($cs_user_data->display_name); ?>
                                                                        </a>
                                                                       </h4>
                                                                        <p><?php echo substr(get_the_author_meta('tagline',$cs_user_data->ID),0,20);?></p>
                                                                   </div>
                                                                   <span><?php echo absint($members_counter);?></span>
                                                               </li>
                                                        <?php
                                                         }
                                                    }
                                                    ?>
                                                  </ul>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="clear"></div>
                                              </div>
									<?php	} 
										
										else if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-events'  && ($user_access == 1 || $display_course == 1)){
												if(isset($cs_xmlObject->var_cp_course_event) && $cs_xmlObject->var_cp_course_event<> ''){
													$course_event = array();
													$course_event = explode(',',$cs_xmlObject->var_cp_course_event);
													if(isset($course_event)){
														$custom_event_query = new WP_Query( array( 'post_type' => 'cs-events','posts_per_page'=>'-1','post__in' => $course_event ) );
														$count_post = $custom_event_query->post_count;
														$cs_event_post_per_page = get_option("posts_per_page");
														$paged	= '';
														if(isset($_GET['page_id_all']) && $_GET['page_id_all'] !=''){
															$paged	= $_GET['page_id_all'];
														}
														$custom_query = new WP_Query( array( 'post_type' => 'cs-events','posts_per_page'=>$cs_event_post_per_page,'paged'=>$paged, 'post__in' => $course_event ) );
														if ( $custom_query->have_posts() ):
														?>
														<div class="main-ev-listing" id="course-events">
															<?php 
															while ( $custom_query->have_posts() ): $custom_query->the_post();
																global $dynamic_post_event_from_date,$cs_event_meta;
																$dynamic_post_event_from_date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);
																$cs_event_meta = get_post_meta($post->ID, "dynamic_cusotm_post", true);
																if ( $cs_event_meta <> "" ) {
																	$cs_event_meta = new SimpleXMLElement($cs_event_meta);
																}
															?>
																<div class="row">
																	<div class="col-md-12">
																		<article class="event-list cs-ev-modren">
																			<?php get_template_part('cs-templates/events-styles/listing','course-events');?>
																		</article>
																	</div>
															   </div>
															<?php endwhile;?>
														</div>
													   <?php 
														$qrystr = '';
														$cs_reviews_post_per_page = get_option("posts_per_page");
														if (  $count_post > $cs_reviews_post_per_page) {
															if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
															if ( isset($_GET['filter_action']) ) $qrystr = "&filter_action=".$_GET['filter_action'];
																echo cs_pagination($count_post, $cs_event_post_per_page,$qrystr);
														}
														endif;
													}
												}
                                            	wp_reset_postdata();
                                       } else if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-faqs'  && ($user_access == 1 || $display_course == 1)){
										   if ( isset($cs_xmlObject->dynamic_post_faq_display) && $cs_xmlObject->dynamic_post_faq_display == 'on'){
											if(class_exists('faq_functions')){
												global $faq_functions;
												$faqs_args = array(
													'posts_per_page'			=> "-1",
													'post_type'					=> 'cs-faqs',
													'post_status'				=> 'publish',
													'meta_key'					=> 'cs_faqs_course',
													'meta_value'				=> "$post->ID",
													'meta_compare'				=> 'LIKE',
													'orderby'					=> 'meta_value',
													'order'						=> 'ASC',
												);
												$faqs_query = new WP_Query($faqs_args);
												if ( $faqs_query->have_posts() <> "" ) {
												?>
													<div id="course-faqs" class="course-faqs">
														<div id="accordion-1" class="panel-group accordion-v4">
															<?php
															_e(sprintf("<p class='no-faqs'>Find Answers to the most frequently asked questions about %s.</p>", get_the_title()), 'EDULMS');
															
															echo $faq_functions->add_question();
															
															while ( $faqs_query->have_posts() ): $faqs_query->the_post();
															?>
															<div class="panel panel-default">
																<div class="panel-heading"> 
																	<p class="panel-title"> 
																		<a class="accordion-toggle backcolorhover collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#accordion-faq-<?php echo absint($post->ID);?>">
																			<i class="fa fa-question-circle"></i>
																			<?php the_title(); ?>
																		</a> 
																	</p> 
																</div>
																<div class="accordion-body collapse" id="accordion-faq-<?php echo absint($post->ID);?>" style="height: 0px;">
																	<div class="panel-body"><?php the_content(); ?></div>
																</div>
															</div>
															<?php
															endwhile;
															
															wp_reset_postdata();
															?>
														</div>
													</div>
												<?php
												}
												else{
													_e(sprintf("<p class='no-faqs'>There are currently no FAQs about %s.</p>", get_the_title()), 'EDULMS');
													?>
                                                    <div class="course-faqs-model">
                                                    	<button class="add_faq_btn custom-btn circle btn-lg cs-bg-color" data-toggle="modal" data-target=".cs-add-faqs-model"><?php  _e('Ask Question','EDULMS');?></button>
                                                    </div>
												<?php	
												}
											}
										   }
										}
										else if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-reviews' && ($user_access == 1 || $display_course == 1) ){
											   
											   $cs_reviews_post_per_page = get_option("posts_per_page");
											   $page_id_all	= '';
											   if(isset($_GET['page_id_all']) && $_GET['page_id_all'] !=''){
													$page_id_all	= $_GET['page_id_all'];
											   }
											   $reviews_args = array(
													'posts_per_page'			=> "$cs_reviews_post_per_page",
													'paged'						=> $page_id_all,
													'post_type'					=> 'cs-reviews',
													'post_status'				=> 'publish',
													'meta_key'					=> 'cs_reviews_course',
													'meta_value'				=> $post->ID,
													'meta_compare'				=> "=",
													'orderby'					=> 'meta_value',
													'order'						=> 'ASC',
												);
                                            	$reviews_query = new WP_Query($reviews_args);
                                        	?>
                                             <div class="course-reviews" id="course-reviews">
                                                    
                                                    <div class="widget_instrector fullwidth course-detail-reviews-listing">
                                                     <?php 
                                                     if ( $reviews_query->have_posts() <> "" ){
                                                        while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
                                                            $var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
                                                            $var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
                                                            $var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
															$var_cp_review_status = get_post_meta($post->ID, "cs_review_status", true);
                                                            ?>
                                                            <article class="reviews reviews-<?php echo absint($post->ID);?>">
                                                                 <figure>
                                                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $var_cp_reviews_members)); ?>">
                                                                        <?php echo get_avatar(get_the_author_meta('user_email', $var_cp_reviews_members), apply_filters('PixFill_author_bio_avatar_size', 60)); ?>
                                                                    </a>
                                                                 </figure>
                                                                <div class="left-sp">
                                                                     <h5><?php echo get_the_author_meta('display_name', $var_cp_reviews_members); ?></h5>
                                                                     <div class="cs-rating"><span class="rating-box" style="width:<?php echo absint($var_cp_rating)*20;?>%"></span></div>
                                                                     <?php echo '<span class="cs-rating-desc">'.get_the_title().'</span>';?>
                                                                </div>
                                                                <?php echo '<p class="cs-review-description">'.the_content().'</p>';?>
                                                            </article>
                                                       <?php
                                                         endwhile;
                                                     }else{
															$user_reviews_pending_args = array(
																'posts_per_page'			=> "-1",
																'post_type'					=> 'cs-reviews',
																'post_status'				=> 'pending',
																'author' 					=> $current_user->ID,
																'meta_key'					=> 'cs_reviews_course',
																'meta_value'				=> $post->ID,
																'meta_compare'				=> "=",
																'orderby'					=> 'meta_value',
																'order'						=> 'ASC',
															);
															$reviews_pending_query = new WP_Query($user_reviews_pending_args);
															$reviews_pending_count = $reviews_pending_query->post_count;
															if($reviews_pending_count){
																_e(sprintf("<p class='no-review'>Your Review will be published after approval For %s.</p>", get_the_title()), 'EDULMS');
															} else {
																_e(sprintf("<p class='no-review'>There are currently no Reviews For %s.</p>", get_the_title()), 'EDULMS');
															}
	
															$cur_course_id = $post->ID;
															
															//cs_add_review_button($current_user->ID, $cur_course_id);
														}
														wp_reset_postdata();
                                                       ?>
                                                   </div>
												   <?php 
                                                   $user_id = cs_get_user_id();

												   if(isset($reviews_pending_count) && $reviews_pending_count < 1){
														?>
														<div class="course-reviews-model">
															<button class="add_review_btn custom-btn circle btn-lg cs-bg-color" style="display: none;" data-toggle="modal" data-target=".cs-add-reviews-model"><?php  _e('Add Reviews', 'EDULMS');?></button>
														</div>
														<?php
													}
                                                    $qrystr = '';
                                                    if (  $reviews_count > $cs_reviews_post_per_page) {
                                                        if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                                        if ( isset($_GET['filter_action']) ) $qrystr .= "&filter_action=".$_GET['filter_action'];
                                                            echo cs_pagination($reviews_count, $cs_reviews_post_per_page,$qrystr);
                                                    } 
                                                   ?>
                                        </div>
                                        <?php 
										} 
										else if($user_access == 1 || $display_course == 1){
										?>
                                            <div id="course-breif">
											<?php
												the_content();
												wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'EDULMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
											?>
                                            </div>
											<?php 
										} else {
											_e('<div class="error_mess"><p>You are not authorized to access it. Please subscribe to this course.</p></div>','EDULMS');									  
										}
										?>  
                                     </div>
										<?php echo balanceTags($colSettingEEnd, false);?>
                                <?php 
                                if (isset($cs_xmlObject->course_related) && $cs_xmlObject->course_related == 'on') {
                                ?>
                                    <div class="cs-blog blog-grid">
                                        <?php if ($cs_xmlObject->course_related_title <> '') { ?>
                                                <header class="cs-section-title">
                                                  <h2><?php echo esc_attr($cs_xmlObject->course_related_title);?> </h2>
                                                </header>
                                        <?php }?>
                                       <div class="cs-related-post">
                                            <div class="row">
                                              <?php 
                                                $custom_taxterms='';
                                               $custom_taxterms = wp_get_object_terms( $post->ID, array('course-category','course-tag'), array('fields' => 'ids') );
                                                $args = array(
                                                'post_type' => 'courses',
                                                'post_status' => 'publish',
                                                'posts_per_page' => 3, // you may edit this number
                                                'orderby' => 'DESC',
                                                'tax_query' => array(
                                                    'relation' => 'OR',
                                                    array(
                                                        'taxonomy' => 'course-tag',
                                                        'field' => 'id',
                                                        'terms' => $custom_taxterms
                                                    ),
                                                    array(
                                                        'taxonomy' => 'course-category',
                                                        'field' => 'id',
                                                        'terms' => $custom_taxterms
                                                    )
                                                ),
                                                'post__not_in' => array ($post->ID),
                                                ); 
                                            $custom_query = new WP_Query($args);
                                            if($custom_query->have_posts()):
                                            while ( $custom_query->have_posts() ): $custom_query->the_post(); 
                                                $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), '302','225');
                                                $no_image = '';
                                                if($image_url == ""){
                                                        $no_image = 'no-img';
                                                }
                                               ?>
                                            <!-- Element Size Start -->
                                                  <article <?php post_class($no_image.' cs-list list_v1 img_position_top has_borde col-md-4') ?>>
                                                    <figure class="hover-gallery">
                                                          <?php if($image_url <> ""){?>
                                                          <a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image_url);?>" alt=""></a>
                                                          <?php }?>
                                                          <figcaption>
                                                                <a href="<?php the_permalink();?>" class="custom-btn btn-border"> <i class="fa fa-plus"></i></a>
                                                          </figcaption>
                                                    </figure>
                                                    <!-- Text Section -->
                                                    <div class="text-section">
                                                            <div class="cs-top-sec">
                                                                <div class="seideleft">
                                                                    <div class="left_position">
                                                                        <h4><a href="<?php the_permalink();?>" class="colrhvr"><?php echo substr(get_the_title(),0, 40); if(strlen(get_the_title())>40){echo '...';}?></a></h4>
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
                                                                            <?php if(isset($reviews_count) && $reviews_count <> ''){?>
                                                                            <li>
                                                                                <div class="cs-rating"><span class="rating-box" style="width:<?php echo esc_attr($var_cp_rating*20);?>%"></span></div><span>( <?php echo (int)$reviews_count;?> <?php echo _e('REVIEWS','EDULMS');?>)</span></li><?php }?>
                                                                            <?php if($var_cp_course_id<>'') { ?>
                                                                                    <li>
                                                                                        <i class="fa fa-mortar-board"></i>
                                                                                        <a><?php echo absint($var_cp_course_id); ?></a>
                                                                                    </li>
                                                                            <?php } ?>
                                                                            <?php 
                                                                                    //$user_course_data = get_post_meta($post->ID, "cs_user_course_data", true);
																					$user_course_data = get_option($post->ID."_cs_user_course_data", true);
                                                                                  if(isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0){ 
                                                                                ?>
                                                                                        <li><i class="fa fa-users"></i><a><?php echo count($user_course_data).' '; _e('Students','EDULMS');?></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                     </div>
                                                                </div>
                                                             </div>
                                                             <div class="cs-cat-list">
                                                                <ul>
                                                                    <?php
                                                                    $curriculum_lessions = 0;
                                                                    if(count($cs_xmlObject->course_curriculms )>0){
                                                                        foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
                                                                            if((string)$curriculm->listing_type == 'curriculum')	
                                                                                $curriculum_lessions++;
                                                                        }
                                                                    }
                                                                    if(!empty($curriculum_lessions)){
                                                                    ?>
                                                                        <li>
                                                                        	<span class="cs-lessons"><i class="fa fa-file-text-o"></i><?php echo absint($curriculum_lessions);?>
																				<?php _e('Lessons','EDULMS');?>
                                                                            </span>
                                                                        </li>
                                                                    <?php
                                                                    }
                                                                    $user_course_data = array();
                                                                    //$user_course_data_array = get_post_meta($post->ID, "cs_user_course_data", true);
																	$user_course_data_array = get_option($post->ID."_cs_user_course_data", true);
                                                                    $course_related_user_ids = array();
                                                                    
                                                                    if ( isset($user_course_data_array) && count($user_course_data_array)>0) {
                                                                        foreach ( $user_course_data_array as $members ){
                                                                             $course_related_user_ids[] = $members['user_id'];
                                                                        }
                                                                    }
                                                                    $user_course_data = array_unique($course_related_user_ids);
                                                                    if(isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0){
                                                                    ?>
                                                                        <li><span><i class="fa fa-users"></i><?php echo count($user_course_data);?> <?php _e('Students','EDULMS'); ?></span></li>
                                                                    <?php }?>
                                                                    
																	<?php 
                                                                    $add_to_cart_url = '';
                                                                    if(class_exists('Woocommerce')) {?>
                                                                        <li>
                                                                        <?php
                                                                        $course_id = $post->ID;
                                                                        $args = array('post_type' => 'product','p' => "$var_cp_course_product", 'post_status' => 'publish');
                                                                        $loop = new WP_Query( $args );
                                                                        while ( $loop->have_posts() ) : $loop->the_post();
                                                                         global $product;
                                                                            $add_to_cart_url = esc_url($product->add_to_cart_url());
                                                                        ?>
                                                                              <div class="cs-carprice">
                                                                                    <?php echo $product->get_price_html(); ?>
                                                                              </div>
                                                                       <?php
                                                                        endwhile; 
                                                                        wp_reset_query();
                                                                        ?>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                             </div>
                                                             <?php 
															 	if(isset($add_to_cart_url) && $add_to_cart_url  <> ''){
																 	$cart_url = add_query_arg( 'course_url', $course_id, $product->add_to_cart_url());
																?>
                                                                    <a href="<?php echo esc_url($cart_url); ?>" class="custom-btn"><i class="fa fa-custom-icon"></i><?php _e('Apply Now','EDULMS');?></a>
                                                            <?php 
																}
															?>
                                                         </div>
                                                    <!-- Text Section --> 
                                                  </article>
                                              <!-- Element Size End -->
                                              <?php endwhile; endif; wp_reset_postdata();?>
                                            </div>
                                         </div>
                                      </div>
                                 <?php }?>
                            </div>       
                            <!--Course Detail Info End-->
                            <!--Start Course Detail aside info -->
                            <aside class="course-sidebar <?php echo esc_attr($sectionRightSidebar);?>">
                                 <div class="courses courselisting">
                                    <?php 
									   $var_cp_course_instructor =  get_post_meta( $post->ID, 'var_cp_course_instructor', true);
									   $cs_user_data = get_userdata((int)$var_cp_course_instructor);
										//== Course Detail Information
										cs_course_detail_info_widget($post->ID,$user_course_data,$var_cp_course_product,$var_cp_course_paid);	
										//== Course  Instructor Information
										if( $cs_user_data <> ''){ 
											cs_course_instructor_widget($post->ID,$cs_user_data);
										}
										cs_course_recent_reviews_widget($post->ID);
                                    ?>
                                </div>
                           </aside> 
                            <!--End Course Detail aside info -->
                         <!-- Row end --> 
                </div>   
                 <!-- col-layout end-->
                 <?php 
				 if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-faqs'  && ($user_access == 1 || $display_course == 1)){
					 if(class_exists('faq_functions') && isset($faq_functions)){
						echo $faq_functions->add_question();
					 }
				 }
				 if(isset($_REQUEST['filter_action']) && $_REQUEST['filter_action'] == 'course-reviews' && ($user_access == 1 || $display_course == 1) ){
					$user_id = cs_get_user_id();
					if(isset($var_cp_course_paid) && $var_cp_course_paid == 'registered_user_access' ){
						$user_subscription_count = 1;
					}
					 $user_reviews_args = array(
						'posts_per_page'			=> "-1",
						'post_type'					=> 'cs-reviews',
						'post_status'				=> 'any',
						'author' 					=> $user_id,
						'meta_key'					=> 'cs_reviews_course',
						'meta_value'				=> $post->ID,
						'meta_compare'				=> "=",
						'orderby'					=> 'meta_value',
						'order'						=> 'ASC',
					);
					$user_reviews_query = new WP_Query($user_reviews_args);
					$user_reviews_count = $user_reviews_query->post_count;
					$user_subscription_count;
					if(isset($user_reviews_count) && $user_reviews_count < $user_subscription_count){
						$cur_course_id = $post->ID;
						cs_add_review_button($user_id, $cur_course_id, $var_cp_course_paid);
					}
					$qrystr = '';
				 }
				   ?>
                <!-- Right Sidebar Start -->
				<?php if ($rightSidebarFlag == true){ ?>
                   <div class="page-sidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
                <?php } ?>
                <!-- Right Sidebar End -->
            </div>
            <!-- Row end -->
     </div>
     <!-- Container end -->
</section>
<!-- Section end -->
 <?php 
 endwhile;
get_footer();