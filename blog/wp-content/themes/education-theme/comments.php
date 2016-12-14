<?php
/**
 * The template for displaying Comment form
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 
	global $cs_theme_options;
	if ( comments_open() ) {
		if ( post_password_required() ) return;
	}
?>
		<?php if ( have_comments() ) : ?>
        <div class="col-md-12">
        <section class="pix-comment-area">
            <div id="comment">
                <div class="cs-section-title">
                    <h2><?php _e('Post Comments','LMS'); ?>
				 
					</h2>
                </div>
                    <div id="comments" class="comments group">
                         <h2 class="cs-section-title"><?php echo comments_number(__('No Comments', 'LMS'), __('1 Comment', 'LMS'), __('% Comments', 'LMS') );?></h2>
                         <ul>
                            <?php wp_list_comments( array( 'callback' => 'cs_comment' ) );	?>
                        </ul>
                        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                            <div class="navigation">
                                <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'LMS') ); ?></div>
                                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'LMS') ); ?></div>
                            </div> <!-- .navigation -->
                        <?php endif; // check for comment navigation ?>
                        
                        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                            <div class="navigation">
                                <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'LMS') ); ?></div>
                                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'LMS') ); ?></div>
                            </div><!-- .navigation -->
                        <?php endif; ?>
                    </div>
		</div>
       </section>
      </div>
		<?php endif; // end have_comments() ?>
<div class="col-md-12">
    <div class="comment-area">
		<?php 
        global $post_id;
        $you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'LMS');
        $must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', 'LMS');
        $logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'LMS');
        $required_fields_mark = ' ' . __('Required fields are marked %s', 'LMS');
        $required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );

        $defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
            array(
                'notes' => '<p class="comment-notes"></p>',
                
                'author' => '<p class="comment-form-author">'.
                '<label class="required-label">' . __( 'Name', 'LMS').'</label><span class="icon-input">' . __( '', 'LMS').
                ''.( $req ? __( '', 'LMS') : '' ) .'<input id="author" placeholder="'.__('Title, Keyword, Company','LMS').'" name="author" class="nameinput" type="text" value=""' .
                esc_attr( $commenter['comment_author'] ) . ' tabindex="1">' .
                '</span></p><!-- #form-section-author .form-section -->',
                
                'email'  => '<p class="comment-form-email">' .
                '<label>' . __( 'Email', 'LMS').'</label><span class="icon-input">'. __( '', 'LMS').
                ''.( $req ? __( '', 'LMS') : '' ) .''.
                '<input id="email"  placeholder="'.__('Email','LMS').'"  name="email" class="emailinput" type="text"  value=""' . 
                esc_attr(  $commenter['comment_author_email'] ) . ' size="30" tabindex="2">' .
                '</span></p><!-- #form-section-email .form-section -->',
                
                'url'    => '<p class="comment-form-website">' .
                '<label>' . __( 'Website', 'LMS').'</label><span class="icon-input">' . __( '', 'LMS') . '' .
                '<input id="url" name="url"  placeholder="'.__('Website','LMS').'" type="text" class="websiteinput"  value="" size="30" tabindex="3">' .
                '</span></p><!-- #<span class="hiddenSpellError" pre="">form-section-url</span> .form-section -->' ) ),
                
                'comment_field' => '<p class="comment-form-comment fullwidth">'.
                ''.__( '', 'LMS'). ''.( $req ? __( '', 'LMS') : '' ) .'' .
                '<label>' . __( 'Message', 'LMS').'</label><textarea id="comment_mes" name="comment"  class="commenttextarea" rows="4" cols="39"></textarea>' .
                '</p><!-- #form-section-comment .form-section -->',
                
                'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
                'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
                'comment_notes_before' => '',
                'comment_notes_after' =>  '',
                'class_form' => 'comform',
                'id_form' => 'commentform',
                'id_submit' => 'submit-comment',
                'title_reply' => __( 'Leave us a reply', 'LMS' ),
                'title_reply_to' => __( 'Leave a Reply to %s', 'LMS' ),
                'cancel_reply_link' => __( 'Cancel reply', 'LMS' ),
                'label_submit' => __( 'Submit', 'LMS' ),); 
                comment_form($defaults, $post_id); 
            ?>
    </div>
</div>
<!-- Col Start -->