<?php
/*
Plugin Name: LMS- Quiz & Assignment
Plugin URI: http://edulms.chimpgroup.com/edufuture/
Description: LMS- Quiz & Assignment
Version: 1.0
Author: ChimpStudio
Author URI: http://edulms.chimpgroup.com
License: GPL2
*/
/*
Copyright 2012  ChimpStudio  (email : info@ChimpStudio.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, United Kingdom
*/

if(!class_exists('cs_lms_quiz_assignment'))
{
    class cs_lms_quiz_assignment
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
			
			
    		//register_deactivation_hook(__FILE__, array('cs_lms_quiz_assignment', 'deactivate'));	
            
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
           add_option( 'Activated_Plugin', 'cs-lms-quiz-assignment' );
		   add_option( 'cs_lms', '1' );
        } // END public static function activate

        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
            
        } // END public static function deactivate
    } // END class cs_lms_quiz_assignment
} // END if(!class_exists('cs_lms_quiz_assignment'))


if(class_exists('cs_lms_quiz_assignment'))
{
    // instantiate the plugin class
	register_activation_hook(__FILE__, array('cs_lms_quiz_assignment', 'activate'));
   // $cs_lms = new cs_lms_quiz_assignment();
}