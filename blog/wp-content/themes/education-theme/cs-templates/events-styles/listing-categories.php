<?php
/**
 * Get Event Categories
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $cs_theme_options,$cs_dcpt_post_time,$dynamic_post_event_from_date,$cs_event_meta,$cs_dcpt_post_excerpt,$cs_dcpt_post_category;

?>

<li>
<?php 
if ( $cs_dcpt_post_category !='' && $cs_dcpt_post_category !='0'){ 
	$row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from ".$wpdb->prefix."terms WHERE slug = %s",$cs_dcpt_post_category ));
}

if ( isset($cs_dcpt_post_category) && $cs_dcpt_post_category !='' && $cs_dcpt_post_category !='0'){ 
	$category_page_link = add_query_arg( 'cat', $row_cat->term_id, site_url() );
	echo '<a href="'.esc_url($category_page_link).'">'.$row_cat->name.'</a>';
 } else {
	 /* Get All Tags */
	  $before_cat = "";
	  $categories_list = get_the_term_list ( get_the_id(), 'events-categories', $before_cat , ', ', '' );
	  if ( $categories_list ){
		printf( __( '%1$s', 'LMS'),$categories_list );
	  } 
	 // End if Tags 
 }
 ?>	
</li>  


