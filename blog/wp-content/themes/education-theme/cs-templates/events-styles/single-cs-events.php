<?php
/**
 * The template for displaying all Events
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	get_header();
	global $post_xml,$content_view,$isEventSidebar;
	
	$cs_layout = '';
	$leftSidebarFlag	= false;
	$rightSidebarFlag	= false;
	$isEventSidebar		= false;
	if ( have_posts() ) while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
   		$cs_layout = $cs_xmlObject->sidebar_layout->cs_page_layout;
		$cs_sidebar_left = (string)$cs_xmlObject->sidebar_layout->cs_page_sidebar_left;
		$cs_sidebar_right = (string)$cs_xmlObject->sidebar_layout->cs_page_sidebar_right;
		$event_view 	= (string)$cs_xmlObject->dynamic_post_event_views;
		$content_view   = $cs_xmlObject->dynamic_post_event_content_view;
		if ( $cs_layout == "left") {
			$cs_layout = "page-content";
			$leftSidebarFlag	= true;
			$isEventSidebar		= true;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "page-content";
			$rightSidebarFlag	= true;
			$isEventSidebar		= true;
 		}
		else {
			$cs_layout = "";
		}
  	}else{
		$event_view = '';
		$cs_sidebar_right = $cs_sidebar_left = '';
 	}
	?>
    <!-- PageSection -->
    <section class="page-section" style=" padding: 0; ">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
            	<!--Left Sidebar Starts-->
				<?php if ( $leftSidebarFlag == true && $cs_layout == 'page-content' ){ ?>
                    	<aside class="page-sidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
                 <?php  wp_reset_query();
                	  } 
                 ?>
                <!--Left Sidebar End-->
                <!-- Col Start -->
                <?php if ( $cs_layout == 'page-content' ) {?>
                <div class="<?php echo cs_allow_special_char($cs_layout); ?>">
                <?php }?>
                    <!-- Row -->
                    <?php get_template_part('cs-templates/events-styles/event','default');	?>
                    <!-- Row -->
                <?php if ( $cs_layout == 'page-content' ) {?>
                </div>
                <?php }?>
                <!-- Col End -->
                <?php if ( $rightSidebarFlag == true && $cs_layout == 'page-content' ){  ?>
                    <aside class="page-sidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
                <?php wp_reset_query(); } ?>
            </div>
            <!-- Row -->
        </div>
        <!-- Container -->
    </section>
    <!-- PageSection -->
<?php
endwhile;
get_footer();
?>