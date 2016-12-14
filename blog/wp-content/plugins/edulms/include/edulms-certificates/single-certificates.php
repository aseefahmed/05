<?php
/**
 * The template for displaying all Course related Quiz
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $post,$course_ID, $cs_xmlObject;
	$cs_node = new stdClass();
	get_header();
	$user_id = cs_get_user_id();
	if (have_posts()):
		while (have_posts()) : the_post();	
		$post_xml = get_post_meta($post->ID, "cs_meta_certificate", true);	
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
		}else{
			$cs_layout = "col-md-12";
		}
		$cs_layout = "content-right col-md-12";
		if ( $post_xml <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($post_xml);
			$width = 980;
			$height = 408;
			$image_url = cs_get_post_img_src($post->ID, $width, $height);
		} else {
			$cs_xmlObject = new stdClass();
		}
		$var_cp_course_paid = '';
		?>
        <!-- Columns Start -->
                <div class="clear"></div>
                <!-- Content Section Start -->
    			<div id="main" role="main">	
    			<!-- Container Start -->
					<div class="container">
        			<!-- Row Start -->
                        <div class="row">
                        <!-- Blog Detail Start -->
                        <div class="<?php echo esc_attr($cs_layout); ?>">
							<!-- Blog Start -->
 							<!-- Blog Post Start -->
                            <div class="blog blog_detail">
                                <article >
                                    <div class="detail_text rich_editor_text">
                                        <?php
                                             the_content();
                                             wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'EDULMS' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                                         ?>
                                    </div>
                               </article>
                           </div>
                         </div>
                        </div>
                   </div>
               </div>
                           
			
	
	<?php 
		endwhile;   endif;
	?>
<!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>