<?php
cs_admin_function_js();
?>
<div class="cs-video video-detail tab_content_login sidebox"  id="tab_add_submission">
	<?php 
        if ( isset( $_POST['cs_video_submit'] ) ) {
            $nonce = $_REQUEST['_wpnonce'];
            if ( !wp_verify_nonce( $nonce, 'cs-add-post' ) ) {
                wp_die( __( 'You are not authorised user.','EDULMS') );
            }
            submit_post();
        }
    	?>
      <div class="detail-text">
        <div class="rich_editor_text">
          <h3><?php _e('Add New Course','EDULMS')?></h3>
          <form id="cs_course_post_form" name="cs_course_post_form" action="" enctype="multipart/form-data" method="POST">
           <?php wp_nonce_field( 'cs-add-post' ); ?>
          <ul class="upload-file">
             <?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>
                    <li>
                        <label><?php _e('Thumbnail','EDULMS')?></label>
                        <div class="file-upload"></div>
                        <input type="file" name="cs_featured_img" />
                    </li>
                <?php } else { ?>
                        <li class="info"><?php _e( 'Your theme doesn\'t support featured image', 'EDULMS' ) ?></li>
                <?php } ?>
               <li>  
                    <label><?php _e('Course title','EDULMS');?></label>
                    <input type="text" name="cs_course_title" required="required" title="" >
                </li>
               <li>
                  <label><?php _e('Category','EDULMS');?></label>
                  <?php
                    $args = array(
                            'show_option_all'    => '',
                            'show_option_none'   => 'Select Categories',
                            'orderby'            => 'ID', 
                            'order'              => 'ASC',
                            'show_count'         => 0,
                            'hide_empty'         => 1, 
                            'child_of'           => 0,
                            'exclude'            => '',
                            'echo'               => 1,
                            'selected'           => 0,
                            'hierarchical'       => 1, 
                            'name'               => 'var_course_cat',
                            'id'                 => '',
                            'class'              => 'dropdown',
                            'depth'              => 0,
                            'tab_index'          => 0,
                            'taxonomy'           => 'course-category',
                            'hide_if_empty'      => false,
                            'walker'             => ''
                        );
                    wp_dropdown_categories( $args );
                  ?>
                </li>
                <li>
                  <label><?php _e('Description','EDULMS')?></label>
                    <?php 
                        wp_editor( '', 'new-post-desc', array('textarea_name' => 'cs_course_content',
                        'editor_class' => 'requiredField',
                        'media_buttons' => false,
                        'teeny' => false,
                        'textarea_rows' => 15,
                        'tinymce' => false) ); 
                    ?>
                </li>
                <li>
                  <label><?php _e('Tags','EDULMS')?></label>
                   <input type="text" name="cs_course_tags" id="cs-post-tags" class="cs-post-tags">
                </li>
                <li>
                <?php 
                    cs_course_general_settings();
                    cs_curriculm_settings();
                    cs_faqs_section();
				?>
                </li>
                <li>
                  <label></label>
                  <input type="submit" name="submit" value="Publish">
                  <input type="hidden" name="cs_course_submit" value="yes" />
                </li>
          </ul>
          </form>
        </div>
      </div>
   </div>