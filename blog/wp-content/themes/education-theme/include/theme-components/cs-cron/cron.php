<?php
/**
 * File Type: Course Update Certificates and badges ( Cron Job)
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */

//======================================================================
// Badges Cron
//======================================================================

function cs_update_badges_cron() {
		
		$args = array('posts_per_page' => "-1", 'post_type' => 'courses','order' => 'DESC', 'orderby' => 'ID', 'post_status' => 'publish');
		$query = new WP_Query( $args );
		$count_post = $query->post_count;
		if ( $query->have_posts() ) {  
			while ( $query->have_posts() ) { $query->the_post();
				 $cs_course = get_post_meta(get_the_ID, "cs_course", true);
				 if ( $cs_course <> "" ) {
                    $cs_xmlObject = new SimpleXMLElement($cs_course);
					$var_cp_course_id = $cs_xmlObject->course_id;
					$var_cp_course_members = $cs_xmlObject->var_cp_course_members;
					
				 }
				
			}
		}
}
							
?>