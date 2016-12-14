<?php
/**
 * File Type: Courses Class
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */


if(!class_exists('cs_course'))
{
    class cs_course
    {
		
	public function __construct(){
		require_once ('course-functions.php');
		//add_filter( 'template_include', array(&$this, 'cs_single_template_function'));
		
	}
	
	//======================================================================
	// Include Course Template
	//======================================================================
	public function cs_single_template_function( $single_template )
	{
		global $post;
		$single_path = dirname( __FILE__ );
		if ( get_post_type() == 'courses' ) {
			if ( is_single() ) {
				$single_template = plugin_dir_path( __FILE__ ) . 'single-courses.php';
			}
		} 
		return $single_template;
	}
  }
}