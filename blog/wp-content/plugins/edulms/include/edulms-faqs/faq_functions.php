<?php
if( !class_exists('faq_functions') ):
    
class faq_functions extends edulms{
	
	public function add_question() {
		global $post, $current_user;
		$u_name = '';
		$u_email = '';
		if( is_user_logged_in() ){
			$u_name = $current_user->display_name;
			$u_email = $current_user->user_email;
		}
	?>
    	
        <div class="course-faqs-model">
        	<!--<a href="#inline-course-faqs" class="add_faq_btn custom-btn circle btn-lg cs-bg-color" rel="prettyPhoto" ><?php _e('Ask Question','EDULMS'); ?></a>
            <button class="add_faq_btn custom-btn circle btn-lg cs-bg-color" data-toggle="modal" data-target=".cs-add-faqs-model"><?php  _e('Add Reviews','EDULMS');?></button>-->
            <div id="inline-course-faqs" class="modal fade cs-add-faqs-model hideee">
              <div class="modal-dialog">
                <div class="modal-content">
                    <form name="faqs-form" id="cs-faqs-form">
                        <input type="hidden" name="action" value="cs_add_faqs" />
                        <input type="hidden" name="course_id" id="course_id" value="<?php echo absint($post->ID);?>" />
                          <div class="modal-header">
                            <button type="button" id="closemodel" class="close" data-dismiss="modal" aria-hidden="true">&#x3A7;</button>
                            <h4 class="modal-title"><?php _e('Add Faq Question','EDULMS');	?></h4>
                          </div>
                          <div class="modal-body">
                            <div id="loading"></div>
                            <div id="add_ques_response" class="faq-message-type succ_mess" style="display:none"></div>
                            <h3><?php echo ucwords( get_the_title() );?></h3>
                            <ul class="faqs-modal">
                                <li>
                                    <label><?php _e('Name','EDULMS');?></label>
                                    <input type="text" id="faqs_user" name="faqs_user" value="<?php echo esc_attr($u_name); ?>" />
                                </li>
                                <li>
                                    <label><?php _e('Email','EDULMS');?></label>
                                    <input type="text" id="faqs_email" name="faqs_email" value="<?php echo sanitize_email($u_email); ?>" />
                                </li>
                                <li>
                                    <label><?php _e('Question','EDULMS');?></label>
                                    <textarea name="faqs_question" id="faqs_question"></textarea>
                                </li>
                             </ul>
                          </div>
                          <div class="modal-footer">
                            <button type="button" id="closemodel" class="btn btn-default" data-dismiss="modal"><?php _e('Close','EDULMS');?></button>
                            <button type="button" class="btn btn-primary" onclick="cs_faqs_submission('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js($this->plugin_url); ?>');"><?php _e('Submit','EDULMS');?></button>
                          </div>
                      </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
         </div>
         <br />
	<?php
	}
	
	public function faqs_list() {
		global $post;
		
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
					
					echo $this->add_question();
					
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
			echo $this->add_question();			
		}
	}
}
endif;
if( class_exists('faq_functions') ) {
	$faq_functions = new faq_functions();
	$GLOBALS['faq_functions'] = $faq_functions;
}