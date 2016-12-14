<?php
	if(!class_exists('post_type_quiz')){
		/**
		 * Quiz Post Type Class
		 */
		class post_type_quiz
		{
			/**
			 * The Constructor
			 */
			public function __construct()
			{
				// register actions
				add_action('init', array(&$this, 'cs_init'));
				add_action('admin_init', array(&$this, 'cs_admin_init'));
				add_action('wp_ajax_cs_add_questions_to_list', array(&$this, 'cs_add_questions_to_list'));
			} 
			
			/**
			 * hook into WP's init action hook
			 */
			public function cs_init()
			{
				// Initialize Post Type
				$this->cs_quiz_register();
				if ( isset($_POST['quiz_meta_form']) and $_POST['quiz_meta_form'] == 1 ) {
					add_action('save_post', array(&$this, 'cs_meta_quiz_save'));
				}
			}
			
			/**
			 * Create the Quiz post type
			 */
			public function cs_quiz_register() {
				
				register_post_type( 'quiz',	array(
										'labels'              => array(
										'name'               => __( 'Quiz', 'EDULMS' ),
										'singular_name'      => __( 'Quiz', 'EDULMS' ),
										'menu_name'          => _x( 'Quiz', 'Admin menu name', 'EDULMS' ),
										'add_new'            => __( 'Add Quiz', 'EDULMS' ),
										'add_new_item'       => __( 'Add New Quiz', 'EDULMS' ),
										'edit'               => __( 'Edit', 'EDULMS' ),
										'edit_item'          => __( 'Edit Quiz', 'EDULMS' ),
										'new_item'           => __( 'New Quiz', 'EDULMS' ),
										'view'               => __( 'View Quiz', 'EDULMS' ),
										'view_item'          => __( 'View Quiz', 'EDULMS' ),
										'search_items'       => __( 'Search Quiz', 'EDULMS' ),
										'not_found'          => __( 'No Quiz found', 'EDULMS' ),
										'not_found_in_trash' => __( 'No Quiz found in trash', 'EDULMS' ),
										'parent'             => __( 'Parent Quiz', 'EDULMS' )
									),
								'description'         => __( 'This is where you can add new Quiz.', 'EDULMS' ),
								'public'              => true,
								'show_ui'             => true,
								'capability_type'     => 'post',
								'show_in_menu' => 'edit.php?post_type=courses',
								'map_meta_cap'        => true,
								'publicly_queryable'  => true,
								'exclude_from_search' => false,
								'hierarchical'        => false, 
								'rewrite'             => false,
								'query_var'           => true,
								'supports'            => array( 'title', 'excerpt', 'custom-fields' ),
								'has_archive'         => 'quiz',
							)
						);
			}
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_admin_init()
			{           
				// Add metaboxes
				add_action('add_meta_boxes', array(&$this, 'cs_meta_questions_add'));
				add_action('add_meta_boxes', array(&$this, 'cs_meta_quiz_add'));
			}
			
			/**
			 * hook into WP's add_meta_boxes action hook
			 */
			public function cs_meta_questions_add()
			{  
				add_meta_box( 'cs_meta_quiz_questions', __('Quiz Options','EDULMS'), array(&$this, 'cs_meta_quiz_questions'), 'quiz', 'normal', 'high' );  
			}
			
			/**
			 * hook into WP's add_meta_boxes action hook
			 */
			public function cs_meta_quiz_add()
			{  
				add_meta_box( 'cs_meta_quiz', __('Quiz Options','EDULMS'), array(&$this, 'cs_meta_quiz'), 'quiz', 'normal', 'high' );  
			}
			
			/**
			 * Quiz General Meta Fields
			 */
			public function cs_meta_quiz( $post ) {
				$cs_quiz = get_post_meta($post->ID, "cs_quiz", true);
				global $cs_xmlObject;
				if ( $cs_quiz <> "" ) {
					$cs_xmlObject = new SimpleXMLElement($cs_quiz);
					$quiz_duration = $cs_xmlObject->quiz_duration;
					$quiz_message = $cs_xmlObject->quiz_message;
					$quiz_auto_results = $cs_xmlObject->quiz_auto_results;
					$quiz_question_show = $cs_xmlObject->quiz_question_show;
					$quiz_success_message = $cs_xmlObject->quiz_success_message;
				} else {
					$quiz_duration = '';
					$quiz_auto_results = '';
					$quiz_question_show = '10';
					$quiz_message = '';
					$quiz_success_message = '';
				}
				?>
                    <div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;"> 
                      <script type="text/javascript">
                                 jQuery(document).ready(function($){
                                    $('.bg_color').wpColorPicker();
                                });
                            </script>
                          <div class="option-sec" style="margin-bottom:0;">
                            <div class="opt-conts">
                              <ul class="form-elements">
                                <li class="to-label">
                                  <label><?php _e('Quiz instructions', 'EDULMS');?>:</label>
                                </li>
                                <li class="to-field">
                                  <textarea name="quiz_message" rows="5" cols="20" ><?php echo htmlspecialchars($quiz_message)?></textarea>
                                </li>
                              </ul>
                              <ul class="form-elements">
                                <li class="to-label">
                                  <label><?php _e('Message to display on Completion', 'EDULMS');?>:</label>
                                </li>
                                <li class="to-field">
                                  <textarea name="quiz_success_message" rows="5" cols="20" ><?php echo htmlspecialchars($quiz_success_message)?></textarea>
                                </li>
                              </ul>
                              <ul class="form-elements">
                                <li class="to-label">
                                  <label><?php _e('Number of questions to Answer', 'EDULMS');?>:</label>
                                </li>
                                <li class="to-field">
                                  <input type="text" name="quiz_question_show" value="<?php echo htmlspecialchars($quiz_question_show)?>" />
                                </li>
                              </ul>
                              
                              
                              <ul class="form-elements">
                                <li class="to-label">
                                  <label><?php _e('Auto Evaluate Results', 'EDULMS');?></label>
                                </li>
                                <li class="to-field">
                                  <div class="on-off">
                                    <label class="pbwp-checkbox">
                                      <input type="hidden" value="" name="var_cp_course_paid">
                                      <input type="checkbox" name="quiz_auto_results" value="on" class="myClass" <?php if($quiz_auto_results=='on')echo "checked"?> />
                                      <span class="pbwp-box"></span> </label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="form-elements noborder">
                                <li class="to-label">
                                  <label><?php _e('Quiz Duration', 'EDULMS');?></label>
                                </li>
                                <li class="to-field">
                                  <div class="input-append bootstrap-timepicker">
                                  <input id="quiz_duration" name="quiz_duration" data-format="hh:mm:ss" value="<?php echo htmlspecialchars($quiz_duration)?>" type="text" class="vsmall" />
                                  <p><?php _e('hh:mm:ss', 'EDULMS');?></p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <input type="hidden" name="quiz_meta_form" value="1" />
                          <div class="clear"></div>
                        </div>
				<div class="clear"></div>
				<?php
            }
		
			/**
			 * @Add Course Questions To list 
			 */
			public function cs_add_questions_to_list($j=0){
					global $counter_question, $question_title, $question_marks, $answer_type, $counter_multipleoptions,$true_false_correnct_answer,$answer_title_one_word,$answer_title_single_option_1,$answer_title_single_option_2,$answer_title_single_option_1_true,$answer_title_single_option_2_true, $multipleoptions,$multiple_option_correct,$answer_large_text, $question_id, $answer_single_radio_option;
					foreach ($_POST as $keys=>$values) {
						$$keys = $values;
					}
					if(isset($_POST['question_title']) && $_POST['question_title'] <> ''){
						$question_id = time();
					}
					if(empty($question_id)){
						$question_id = $counter_question;
					}
					?>
                    <tr class="parentdelete" id="edit_track<?php echo absint($counter_question);?>">
                      <td id="question_title-title<?php echo absint($counter_question);?>" style="width:40%;"><?php echo esc_attr($question_title);?></td>
                      <td class="centr" style="width:20%;"><a href="javascript:openpopedup('edit_track_form<?php echo absint($counter_question);?>')"><i class="fa fa-pencil-square-o"></i></a> <a href="#" style="background-color:red;" class="delete-it btndeleteit"><i class="fa fa-times"></i></a>
                        <input type="hidden" name="question_id[]" value="<?php echo absint($question_id);?>"  />
                        <div class="poped-up question-pop" id="edit_track_form<?php echo absint($counter_question);?>">
                          <div class="cs-heading-area">
                            <h5><?php _e('Question Settings', 'EDULMS');?></h5>
                            <a href="javascript:closepopedup('edit_track_form<?php echo absint($counter_question);?>')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                          </div>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Question Title', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <input type="text" name="question_title[]" value="<?php echo htmlspecialchars($question_title)?>" id="question_title<?php echo absint($counter_question)?>" />
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Marks', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <input type="text" name="question_marks[]" value="<?php echo htmlspecialchars($question_marks)?>" id="question_marks<?php echo absint($counter_question)?>" />
                            </li>
                          </ul>
                          <ul class="form-elements"  style="display: <?php if($answer_type == 'multiple-option'){?>block;<?php } else {?> none; <?php }?>">
                            <li class="to-label">
                              <label><?php _e('Single Answer Option', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                            	<ul class="check-box">
                                    <li>
                                        <div class="checkbox">
                              				<input type="checkbox" name="answer_single_radio_option[<?php echo absint($question_id);?>][]" <?php if($answer_single_radio_option == 'single-answer-radio-option'){echo 'checked';} ?> value="single-answer-radio-option" id="answer_single_radio_option<?php echo esc_attr($answer_single_radio_option.$j);?>" />
                            				<label for="answer_single_radio_option<?php echo esc_attr($answer_single_radio_option.$j);?>"></label>
                            			</div>
                            		</li>
                            	</ul>
                            </li>
                          </ul>
                    
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Answer Type', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <input type="text" name="answer_type[]" value="<?php echo htmlspecialchars($answer_type)?>" id="answer_type<?php echo absint($counter_question);?>" />
                            </li>
                          </ul>
                          <?php if($answer_type == 'single-option'){?>
                          <div style="display:<?php if($answer_type == 'single-option'){echo 'inline';} else {echo 'none;';}?>">
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Answer Title 1', 'EDULMS');?></label>
                              </li>
                              <li class="to-label">
                                <input type="text" id="answer_title_single_option_1<?php echo absint($counter_question);?>" name="answer_title_single_option_1[]" value="<?php echo esc_attr($answer_title_single_option_1);?>" />
                              </li>
                              <li class="to-label">
                                <input type="checkbox" name="answer_title_single_option_1_true[]" value="correct" id="answer_title_single_option_1_true<?php echo absint($counter_question);?>" <?php if($answer_title_single_option_1_true == 'correct'){echo 'checked="checked"';}?> />
                                <label><?php _e('check it if its correct', 'EDULMS');?></label>
                              </li>
                            </ul>
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Answer Title 2', 'EDULMS');?></label>
                              </li>
                              <li class="to-label">
                                <input type="text" id="answer_title_single_option_2<?php echo absint($counter_question);?>" name="answer_title_single_option_2[]" value="<?php echo esc_attr($answer_title_single_option_2);?>" />
                              </li>
                              <li class="to-label">
                                <input type="checkbox" name="answer_title_single_option_2_true[]" value="correct" id="answer_title_single_option_2_true<?php echo absint($counter_question);?>"  <?php if($answer_title_single_option_2_true == 'correct'){echo 'checked="checked"';}?> />
                                <label><?php _e('check it if its correct', 'EDULMS');?></label>
                              </li>
                            </ul>
                          </div>
                          <?php } elseif($answer_type == 'one-word-answer'){?>
                          <ul class="form-elements" style="display:<?php if($answer_type == 'one-word-answer'){echo 'inline';} else {echo 'none;';}?>">
                            <li class="to-label">
                              <label><?php _e('Answer Title', 'EDULMS');?></label>
                            </li>
                            <li class="to-label">
                              <input type="text" id="answer_title_one_word<?php echo absint($counter_question);?>" name="answer_title_one_word[]" value="<?php echo esc_attr($answer_title_one_word);?>" />
                            </li>
                          </ul>
                          <?php } elseif($answer_type == 'large-text'){?>
                          <ul class="form-elements" style="display:<?php if($answer_type == 'large-text'){echo 'inline';} else {echo 'none;';}?>">
                            <li class="to-label">
                              <label><?php _e('Answer', 'EDULMS');?></label>
                            </li>
                            <li class="to-label">
                              <textarea name="answer_large_text[]" id="answer_large_text<?php echo absint($counter_question);?>" rows="5" cols="20"><?php echo esc_textarea($answer_large_text)?></textarea>
                            </li>
                          </ul>
                          <?php } elseif($answer_type == 'true-false'){?>
                          <ul class="form-elements" style="display:<?php if($answer_type == 'true-false'){echo 'inline';} else {echo 'none;';}?>">
                            <li class="to-label">
                              <label><?php _e('Correct Answer', 'EDULMS');?> <?php echo esc_attr($true_false_correnct_answer);?></label>
                            </li>
                            <li class="to-label">
                              <input type="radio" class="radioBtnClass" name="true_false_correnct_answer[]" value="correct" <?php if($true_false_correnct_answer == 'correct'){echo 'checked="checked"';}?> />
                              <?php _e('True', 'EDULMS');?> </li>
                            <li class="to-label">
                              <input type="radio" class="radioBtnClass" name="true_false_correnct_answer[]" value="wrong" <?php if($true_false_correnct_answer <> 'correct'){echo 'checked="checked"';}?> />
                              <?php _e('False', 'EDULMS');?> </li>
                          </ul>
                          <?php } elseif($answer_type == 'multiple-option'){?>
                          <div style="display:<?php if($answer_type == 'multiple-option'){echo 'inline';} else {echo 'none;';}?>">
                            <?php 
                                echo '<input type="hidden" name="counter_multipleoptions[]" value="'.$counter_multipleoptions.'"/>';
                                    if(isset($_POST['counter_multipleoptions']) && $_POST['counter_multipleoptions'] <> ''){
                                            
                                        for($i = 1; $i<=$counter_multipleoptions; $i++){
                                            $title_multiple_option =  "answer_title_multiple_option_$i";
                                            $answer_title_multiple_option_correct =  "answer_title_multiple_option_correct_$i";
                                            $selectedcheck = '';
                                            
                                            if($$answer_title_multiple_option_correct == 'correct'){$selectedcheck = 'checked';}
                                                echo '<ul class="form-elements">
                                                    <li class="to-label"><label>'.__('Answer Title','EDULMS').' '.$i.'</label></li>
                                                    <li class="to-label">
                                                        <input type="text" id="answer_title_multiple_option_'.$i.'[]" value="'.$$title_multiple_option .'" class="small multipleoption-class" name="answer_title_multiple_option_'.$counter_question.'[]" />
                                                    </li>
                                                    <li class="to-label">
													<div class="check-box">
                                                       <input type="checkbox" name="answer_title_multiple_option_correct_'.$counter_question.'[]" value="'.$i.'" class="multipleoption-answer-class" '.$selectedcheck.'  /><label>check it if its correct</label>
                                                    </div>
													</li>
                                                </ul>';
                                            }
                                        } else {
                                        $array_counter=0;
                                        $i = 1;
                                        foreach($multipleoptions as $multipleoptions_title){
                                            $selectedcheck = $correct = '';
                                            if (in_array($i, $multiple_option_correct)) {$selectedcheck = 'checked="checked"'; $correct ='right-click';}
                                                echo '<ul class="form-elements">
                                                    <li class="to-label"><label>'.__('Answer Title','EDULMS').' '.$i.'</label></li>
                                                    <li class="to-field">
                                                        <input type="text" id="answer_title_multiple_option_'.$i.'[]" value="'.$multipleoptions_title .'" class="small multipleoption-class" name="answer_title_multiple_option_'.$counter_question.'[]" />
                                                    <ul class="check-box">
														<li>
															<div class="checkbox">
                                                       			<input type="checkbox" id="checkbox'.$i.$j.'" name="answer_title_multiple_option_correct_'.$counter_question.'[]" value="'.$i.'" class="multipleoption-answer-class" '.$selectedcheck.'  /><label for="checkbox'.$i.$j.'" class="'.$correct.'" >check it if its correct</label>
															</div>
														</li>
													</ul>
                                                    </li>
                                                </ul>';
                                                $array_counter++;
                                                $i++;
                                        }
                                    }
                                ?>
                          </div>
                          <?php }?>
                          <ul class="form-elements noborder">
                            <li class="to-label">
                              <label></label>
                            </li>
                            <li class="to-field">
                              <input type="button" value="<?php _e('Update Question', 'EDULMS');?>" onclick="update_title(<?php echo absint($counter_question);?>); closepopedup('edit_track_form<?php echo absint($counter_question);?>')" />
                            </li>
                          </ul>
                        </div></td>
                    </tr>
					<?php
					if ( isset($action) ) die();
			}
				
			/**
			 * Quiz Questions Meta Fields
			 */	
			public function cs_meta_quiz_questions( $post ) {
				$cs_quiz = get_post_meta($post->ID, "cs_quiz", true);
				global $cs_xmlObject;
				if ( $cs_quiz <> "" ) {
					$cs_xmlObject = new SimpleXMLElement($cs_quiz);
					$quiz_duration = $cs_xmlObject->quiz_duration;
					$quiz_message = $cs_xmlObject->quiz_message;
					$quiz_auto_results = $cs_xmlObject->quiz_auto_results;
					$quiz_question_show = $cs_xmlObject->quiz_question_show;
					$user_quiz_questions_data = get_post_meta($post->ID, "cs_quiz_questions_meta", true);
				} else {
					$quiz_duration = '00:30';
					$quiz_auto_results = 'on';
					$quiz_question_show = '10';
					$quiz_message = '';
				}
		       ?>
                    <div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
                      <div class="boxes tracklists">
                        <div id="add_track" class="poped-up">
                        <a href="javascript:closepopedup('add_track')" class="closeit"><i class="fa fa-times"></i></a>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Question Title', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <input type="text" id="question_title" name="question_title" value="Question Title" />
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Marks', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <input type="text" id="question_marks" name="question_marks" value="1" />
                            </li>
                          </ul>
                          <ul class="form-elements">
                            <li class="to-label">
                              <label><?php _e('Answer Type', 'EDULMS');?></label>
                            </li>
                            <li class="to-field">
                              <div class="select-style">
                                <select name="answer_type" id="answer_type" class="dropdown" onchange="cs_change_answer_type(this.value)">
                                  <option value=""><?php _e('Select Option', 'EDULMS');?></option>
                                  <option value="multiple-option"><?php _e('Multiple Choice', 'EDULMS');?></option>
                                  <option value="large-text"><?php _e('Large Text', 'EDULMS');?></option>
                                </select>
                              </div>
                            </li>
                          </ul>
                          <div class="one-word-answer" id="one-word-answer" style="display:none;">
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Answer', 'EDULMS');?></label>
                              </li>
                              <li class="to-label">
                                <input type="text" id="answer_title_one_word" name="answer_title_one_word" />
                              </li>
                            </ul>
                          </div>
                          <div class="large-text" id="large-text" style="display:none;">
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Answer', 'EDULMS');?></label>
                              </li>
                              <li class="to-label">
                                <textarea name="answer_large_text" id="answer_large_text" rows="5" cols="20"></textarea>
                              </li>
                            </ul>
                          </div>
                          <div class="true-false" id="true-false" style="display:none;">
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Correct Answer', 'EDULMS');?></label>
                              </li>
                              <li class="to-label">
                                <input type="radio" class="radioBtnClass" value="correct" name="true_false_correnct_answer" checked="checked"/>
                                True </li>
                              <li class="to-label">
                                <input type="radio" class="radioBtnClass" value="wrong" name="true_false_correnct_answer" />
                                False </li>
                            </ul>
                          </div>
                          <div class="multiple-option" id="multiple-option" style="display:none;">
                            <div id="multiple-answer-option">
                              <ul class="form-elements">
                                <li class="to-label">
                                  <label><?php _e('Answer Title 1', 'EDULMS');?></label>
                                </li>
                                <li class="to-field">
                                  <input type="text" id="answer_title_multiple_option_1" class="small multipleoption-class" name="answer_title_multiple_option_1" />
                                </li>
                                <li class="to-label">
                                	<ul class="check-box">
										<li>
											<div class="checkbox">
                               				  <input type="checkbox" name="answer_title_multiple_option_correct_1" value="correct" id="answer_title_multiple_option_correct_1"  class="multipleoption-answer-class" />
                                              <label for="answer_title_multiple_option_correct_1"><?php _e('Correct Answer?', 'EDULMS');?></label>
                                  			</div>
                                  		</li>
                                 	</ul>
                                  
                                </li>
                                <li class="to-label red">
                                  <label><i class="fa fa-times"></i> <?php _e('Remove', 'EDULMS');?></label>
                                </li>
                              </ul>
                              <ul class="form-elements">
                                  <li class="to-label">
                                    <label><?php _e('Answer Title 2', 'EDULMS');?></label>
                                  </li>
                                  <li class="to-field">
                                  
                                    <input type="text" id="answer_title_multiple_option_2" class="small multipleoption-class" name="answer_title_multiple_option_2" />
                                  </li>
                                  <li class="to-label">
                                  	<ul class="check-box">
										<li>
											<div class="checkbox">
                                   			  <input type="checkbox" name="answer_title_multiple_option_correct_2" id="answer_title_multiple_option_correct_2" value="correct" class="multipleoption-answer-class" />
                                   			  <label for="answer_title_multiple_option_correct_2"><?php _e('Correct Answer?', 'EDULMS');?></label>
                                            </div>
                                        </li>
                                    </ul>
                                  </li>
                                  <li class="to-label red">
                                    <label><i class="fa fa-times"></i> <?php _e('Remove', 'EDULMS');?></label>
                                  </li>
                                </ul>
                            </div>
                            <ul class="form-elements">
                            	<li class="to-field">
                                	<button type="button" id='AddMoreFileBox'><i class="fa fa-plus-circle"></i> <?php _e('Add Answer', 'EDULMS');?></button>
                            	</li>
                            </ul>
                            
                            <ul class="form-elements last">
                              <li class="to-label">
                                <label>
                                  <input type="checkbox" id="answer_single_radio_option" name="answer_single_radio_option" value="single-answer-radio-option"  />
                                  <?php _e('If you want to use single option check this box.', 'EDULMS');?></label>
                              </li>
                            </ul>
                          </div>
                          <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                              <input type="button" value="Add Question to List" onclick="add_question_to_list('<?php echo esc_js(admin_url());?>', '<?php echo esc_js(get_template_directory_uri());?>')" />
                            </li>
                          </ul>
                        </div>
                        <script>
							jQuery(document).ready(function($) {
								$("#total_tracks").sortable({
									cancel : 'td div.poped-up',
								});
							});
                        </script>
                        <table class="to-table" style="background:#FFF;" border="0" cellspacing="0">
                          <thead>
                            <tr>
                              <th style="width:40%;"><?php _e('Question Title', 'EDULMS');?></th>
                              <th style="width:80%;" class="centr"><?php _e('Actions', 'EDULMS');?></th>
                            </tr>
                          </thead>
                          <tbody id="total_tracks">
                            <?php
							global $counter_question, $question_title,$multipleoptions,$multiple_option_correct, $question_marks, $answer_type, $counter_multipleoptions,$true_false_correnct_answer,$answer_title_one_word,$answer_title_single_option_1,$answer_title_single_option_2,$answer_title_single_option_1_true,$answer_title_single_option_2_true,$answer_large_text,$question_id,$question_no, $answer_single_radio_option;
							$counter_question = $post->ID;
							if ( $cs_quiz <> "" ) {
								$multipleoptions = array();
								$multiple_option_correct = array();
								$counter_question = 0;
								$question_no = 0;
								foreach ( $cs_xmlObject as $track ){
									
									if ( $track->getName() == "question" ) {
										$question_no++;
										$multipleoptions = array();
										$multiple_option_correct = array();
										$question_title = $track->question_title;
										$question_marks = $track->question_marks;
										$answer_type = $track->answer_type;
										$question_id = $track->question_id;
										$answer_single_radio_option = $track->answer_single_radio_option;
										if($answer_type == 'single-option'){
											$answer_title_single_option_1_true = $track->answer_title_single_option_1_true;
											$answer_title_single_option_1 = $track->answer_title_single_option_1;
											$answer_title_single_option_2 = $track->answer_title_single_option_2;
											$answer_title_single_option_2_true = $track->answer_title_single_option_2_true;
										} elseif($answer_type == 'one-word-answer'){
											$answer_title_one_word = $track->answer_title_one_word;
										 } elseif($answer_type == 'true-false'){
											$true_false_correnct_answer = $track->true_false_correnct_answer;
										} elseif($answer_type == 'large-text'){
											$answer_large_text = $track->answer_large_text;
										} else if($answer_type == 'multiple-option'){
											$title_multiple_option =  "answer_title_multiple_option_$question_no";
											$title_multiple_option = $track->$title_multiple_option;
											$multipleoptions = explode("||",$title_multiple_option);
											$title_multiple_option_correct =  "answer_title_multiple_option_correct_$question_no";
											$multioption_array_correct = (string)$track->$title_multiple_option_correct;
											$multiple_option_correct = explode("||",$multioption_array_correct);
											$counter_multipleoptions = (int)count($multipleoptions);
										}
										$counter_question++;
										$this->cs_add_questions_to_list($counter_question);
										
									}
								}
							}
						?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                <div class="opt-head"> <a href="javascript:openpopedup('add_track')" class="add-btn"><i  class="fa fa-plus-circle"></i> <?php _e('Add Questions', 'EDULMS');?></a>
                  <div class="clear"></div>
                </div>
                <div class="clear"></div>
		<?php
		}
			/**
			 * Save Meta Fields
			 */
			public function cs_meta_quiz_save( $post_id ){ 
			
				$sxe = new SimpleXMLElement("<quiz></quiz>"); //quiz_type
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( empty($_POST["quiz_duration"]) ) $_POST["quiz_duration"] = "";
					if ( empty($_POST["quiz_message"]) ) $_POST["quiz_message"] = "";
					if ( empty($_POST["quiz_success_message"]) ) $_POST["quiz_success_message"] = "";
					if ( empty($_POST["quiz_auto_results"]) ) $_POST["quiz_auto_results"] = "";
					if ( empty($_POST["quiz_question_show"]) ) $_POST["quiz_question_show"] = "";
					$sxe->addChild('quiz_duration', htmlspecialchars($_POST['quiz_duration']) );
					$sxe->addChild('quiz_message', htmlspecialchars($_POST['quiz_message']) );
					$sxe->addChild('quiz_success_message', htmlspecialchars($_POST['quiz_success_message']) );
					$sxe->addChild('quiz_auto_results', htmlspecialchars($_POST['quiz_auto_results']) );
					$sxe->addChild('quiz_question_show', htmlspecialchars($_POST['quiz_question_show']) );
 					$counter = $multiplecounter = $true_false_counter = $single_option_counter = $one_word_counter = $answer_large_text_counter = 0;
					$multioptions_counter = 1;
					$user_quiz_questions_data = array();
					if(isset($_POST['question_title']) && is_array($_POST['question_title']) && count($_POST['question_title'])){
						foreach ( $_POST['question_title'] as $count ){
						$quiz_questions_meta_array = array();
							$track = $sxe->addChild('question');
							$answer_type = $_POST['answer_type'][$counter];
								$track->addChild('question_title', htmlspecialchars($_POST['question_title'][$counter]) );
								$track->addChild('question_marks', htmlspecialchars($_POST['question_marks'][$counter]) );
								$track->addChild('answer_type', htmlspecialchars($_POST['answer_type'][$counter]) );
								$track->addChild('question_id', htmlspecialchars($_POST['question_id'][$counter]) );
								$question_id = $_POST['question_id'][$counter];
								$answer_single_radio_option = '';
								if(isset($_POST['answer_single_radio_option'][$question_id]['0'])){
									$answer_single_radio_option = $_POST['answer_single_radio_option'][$question_id]['0'];
								}
								$track->addChild('answer_single_radio_option', htmlspecialchars($answer_single_radio_option) );
								$quiz_questions_meta_array['question_title'] = $_POST['question_title'][$counter];
								$quiz_questions_meta_array['question_marks'] = $_POST['question_marks'][$counter];
								$quiz_questions_meta_array['answer_type'] = $_POST['answer_type'][$counter];
								$quiz_questions_meta_array['question_id'] = $_POST['question_id'][$counter];
								$quiz_questions_meta_array['answer_single_radio_option'] = htmlspecialchars($answer_single_radio_option);
									if($answer_type == 'single-option'){
										$track->addChild('answer_title_single_option_1', htmlspecialchars($_POST['answer_title_single_option_1'][$single_option_counter]) );
										$track->addChild('answer_title_single_option_1_true', htmlspecialchars($_POST['answer_title_single_option_1_true'][$single_option_counter]) );
										$track->addChild('answer_title_single_option_2', htmlspecialchars($_POST['answer_title_single_option_2'][$single_option_counter]) );
										$track->addChild('answer_title_single_option_2_true', htmlspecialchars($_POST['answer_title_single_option_2_true'][$single_option_counter]) );
										$quiz_questions_meta_array['answer_title_single_option_1'] = htmlspecialchars($_POST['answer_title_single_option_1'][$single_option_counter]);
										$quiz_questions_meta_array['answer_title_single_option_1_true'] = htmlspecialchars($_POST['answer_title_single_option_1_true'][$single_option_counter]);
										$quiz_questions_meta_array['answer_title_single_option_2'] = htmlspecialchars($_POST['answer_title_single_option_2'][$single_option_counter]);
										$quiz_questions_meta_array['answer_title_single_option_2_true'] = htmlspecialchars($_POST['answer_title_single_option_2_true'][$single_option_counter]);
										$single_option_counter++;
									} elseif($answer_type == 'one-word-answer'){
										$track->addChild('answer_title_one_word', htmlspecialchars($_POST['answer_title_one_word'][$one_word_counter]) );
										$quiz_questions_meta_array['answer_title_one_word'] = htmlspecialchars($_POST['answer_title_one_word'][$true_false_counter]);
										$one_word_counter++;
									} elseif($answer_type == 'true-false'){
										$track->addChild('true_false_correnct_answer', htmlspecialchars($_POST['true_false_correnct_answer'][$true_false_counter]) );
										$quiz_questions_meta_array['true_false_correnct_answer'] = htmlspecialchars($_POST['true_false_correnct_answer'][$true_false_counter]);
										$true_false_counter++;
									} elseif($answer_type == 'large-text'){
										$track->addChild('answer_large_text', htmlspecialchars($_POST['answer_large_text'][$answer_large_text_counter]) );
										$quiz_questions_meta_array['answer_large_text'] = htmlspecialchars($_POST['answer_large_text'][$answer_large_text_counter]);
										$answer_large_text_counter++;
									} else if($answer_type == 'multiple-option'){
										$title_multiple_option =  "answer_title_multiple_option_$multioptions_counter";
										$multioption_array = $_POST[$title_multiple_option];
										$multioption_array = implode("||",$multioption_array);
										$track->addChild($title_multiple_option, $multioption_array );
										$quiz_questions_meta_array['answer_title_multiple_option'] = $multioption_array;
										$title_multiple_option_correct =  "answer_title_multiple_option_correct_$multioptions_counter";
										$title_multiple_option_correct_array = $_POST[$title_multiple_option_correct];
										$multioption_array_correct = implode("||",$title_multiple_option_correct_array);
										$track->addChild($title_multiple_option_correct, $multioption_array_correct );
										$quiz_questions_meta_array['answer_title_multiple_option_correct'] = $multioption_array_correct;
									}
								$counter++;
								$multioptions_counter++;
								$user_quiz_questions_data[$question_id] = $quiz_questions_meta_array;
						}
					}
				update_post_meta( $post_id, 'cs_quiz_questions_meta', $user_quiz_questions_data );
				update_post_meta( $post_id, 'cs_quiz', $sxe->asXML() );
			}
		} // END class PostTypeTemplate
	}