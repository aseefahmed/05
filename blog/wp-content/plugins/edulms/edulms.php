<?php

/*
  Plugin Name: EDULMS
  Plugin URI: http://edulms.chimpgroup.com/edufuture/
  Description: Education Learning Management System
  Version: 1.3
  Author: ChimpStudio
  Author URI: http://edulms.chimpgroup.com
  License: GPL2

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

if (!class_exists('edulms')) {

    class edulms {

        public $plugin_url;

        /**
         * Construct
         */
        public function __construct() {
            global $post, $wp_query, $cs_course_options;
            
            add_action('init', array($this, 'load_plugin_textdomain'), 0);
            
            $this->plugin_url = plugin_dir_url(__FILE__);
            require_once ('include/plugin_global.php');
            require_once('admin/post_type_course.php');
            require_once('admin/post_type_quiz.php');
            require_once('admin/post_type_assignments.php');
            require_once('admin/post_type_reviews.php');
            require_once('admin/post_type_curriculums.php');
            require_once('include/edulms-faqs/post_type_faqs.php');
            require_once('include/register-templates/class-register-templates.php');

            if (class_exists('edulms_regiser_templates')) {
                $edulms_regiser_templates = new edulms_regiser_templates();
            }


            if (class_exists('post_type_courses')) {
                $course_object = new post_type_courses();
                require_once ('include/edulms-courses/course-functions.php');
            }
            if (class_exists('post_type_curriculums')) {
                $curriculums_object = new post_type_curriculums();
            }
            if (class_exists('post_type_quiz')) {
                $quiz_object = new post_type_quiz();
            }
            if (class_exists('post_type_reviews')) {
                $reviews_object = new post_type_reviews();
            }
            if (class_exists('post_type_assignments')) {
                $assignments_object = new post_type_assignments();
            }
            require_once ( 'admin/post_type_certificates.php' );
            if (class_exists('post_type_certificates')) {
                $certificates = new post_type_certificates();
            }
            add_filter('template_include', array(&$this, 'cs_single_template_function'));
            require_once ('include/edulms-quiz/quiz-functions.php');
            require_once ('include/edulms-assignments/assignment-functions.php');
            require_once ('include/edulms-settings/settings.php');
            require_once ('include/edulms-courses/members.php');
            require_once ('include/edulms-courses/members-listing.php');
            require_once ('include/edulms-courses/course-categories.php');
            require_once ('include/edulms-certificates/certificates-functions.php');
            require_once ('include/edulms-certificates/shortcodes.php');

            require_once ('include/edulms-faqs/ajax_functions.php');
            require_once ('include/edulms-faqs/faq_functions.php');

            require_once ('include/edulms-login/login-functions.php');
            require_once ('include/edulms-login/login-forms.php');
            require_once ('include/edulms-login/shortcodes.php');
            //widgets
            require_once ('include/edulms-widgets/cs-latest-reviews.php');

            require_once ('include/register-templates/templates/functions_profile.php');
            require_once ('include/edulms-login/cs-social-login/cs_social_login.php');

            require_once ('include/edulms-login/cs-social-login/google/cs-google-connect.php');

            add_action('wp_enqueue_scripts', array(&$this, 'cs_defaultfiles_plugin_enqueue'));
            add_action('admin_enqueue_scripts', array(&$this, 'cs_defaultfiles_plugin_enqueue'));
        }

        public function load_plugin_textdomain() {
            $cs_theme_options = get_option('cs_theme_options');
            $locale = apply_filters('plugin_locale', get_locale(), 'EDULMS');
            $dir = trailingslashit(WP_LANG_DIR);
            $languageFile = isset($cs_theme_options['cs_language_file']) ? $cs_theme_options['cs_language_file'] : '';
            if (isset($languageFile) && $languageFile != '') {
                load_textdomain('EDULMS', plugin_dir_path(__FILE__) . "languages/" . $cs_theme_options['cs_language_file']);
            } else {
                load_textdomain('EDULMS', $dir . 'EDULMS-ar.mo');
            }
        }

        // Add actions

        /**
         * Activate the plugin
         */
        public static function activate() {
            add_option('cs_lms_plugin_activation', 'installed');
            add_option('cs_lms', '1');
            $cs_course_options = $cs_course_options;
            if (!isset($cs_course_options) || empty($cs_course_options) || !is_array($cs_course_options)) {
                $cs_course_options = array('cs_dashboard' => '', 'cs_currency_symbol' => '$', 'cs_review_status' => 'Pending');
                add_option("cs_course_options", $cs_course_options);
            }
        }

        /**
         * Deactivate the plugin
         */
        static function deactivate() {
            delete_option('cs_lms_plugin_activation');
            delete_option('cs_lms', false);
        }

        /**
         * Include Default Scripts and styles
         */
        public function cs_defaultfiles_plugin_enqueue() {
            wp_enqueue_script('jquery');
            wp_enqueue_media();
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_style('font-awesome_css', plugins_url('/assets/css/font-awesome.css', __FILE__));
            wp_enqueue_script('lms_quiz_functions_js', plugins_url('/assets/scripts/quiz_assignments_func.js', __FILE__), '', '', true);
            wp_enqueue_script('socialconnect_js', plugins_url('/include/edulms-login//cs-social-login/media/js/cs-connect.js', __FILE__));
            if (is_admin()) {
                wp_enqueue_style('lms_style_css', plugins_url('/assets/css/admin_style.css', __FILE__));
                wp_enqueue_script('admin_bootstrap_js', plugins_url('/assets/scripts/bootstrap_min.js', __FILE__), '', '', true);
                wp_enqueue_script('dataTables_js', plugins_url('/assets/scripts/jquery_datatables.js', __FILE__), '', '', true);
                wp_enqueue_style('dataTables_css', plugins_url('/assets/css/jquery_datatables.css', __FILE__));
            } else {
                //wp_enqueue_style('style_css', plugins_url('/assets/css/style.css' , __FILE__ ));
                wp_enqueue_script('bootstrap_min_js', plugins_url('/assets/scripts/bootstrap_min.js', __FILE__), '', '', true);
            }
        }

        /**
         * Include Assets
         */
        public function cs_quiz_plugin_enqueue() {

            wp_enqueue_script('lms_quiz_functions_js', plugins_url('/assets/scripts/quiz_assignments_func.js', __FILE__), '', '', true);
            if (is_admin()) {
                wp_enqueue_style('lms_style_css', plugins_url('/assets/css/admin_style.css', __FILE__));
                wp_enqueue_script('dataTables_js', plugins_url('/assets/scripts/jquery_datatables.js', __FILE__), '', '', true);
                wp_enqueue_style('dataTables_css', plugins_url('/assets/css/jquery_datatables.css', __FILE__));
            }
        }

        /**
         * Include Assets
         */
        public static function cs_course_files_enqueue() {
            wp_enqueue_script('lms_jquery_timepicker_js', plugins_url('/assets/scripts/jquery_timepicker.js', __FILE__), '', '', true);
            wp_enqueue_script('lms_course_functions_js', plugins_url('/assets/scripts/course_functions.js', __FILE__), '', '', true);
            wp_enqueue_script('lms_jquery_bootstrap_transfer_js', plugins_url('/assets/scripts/bootstrap_transfer.js', __FILE__), '', '', true);
        }

        // jQuery Data Tables
        public static function cs_reprotstables_script_enqueue() {
            wp_enqueue_script('dataTables_js', plugins_url('/assets/scripts/jquery_datatables.js', __FILE__), '', '', true);
            wp_enqueue_style('dataTables_css', plugins_url('/assets/css/jquery_datatables.css', __FILE__));
        }

        /**
         * Plugin URL
         */
        public static function plugin_url() {
            return plugin_dir_url(__FILE__);
        }

        public static function plugin_dir() {
            return plugin_dir_path(__FILE__);
        }

        /**
         * Include Single Templates
         */
        public function cs_single_template_function($single_template) {
            global $post;
            $single_path = dirname(__FILE__);
            if (get_post_type() == 'quiz') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'include/edulms-quiz/single-quiz.php';
                }
            } else if (get_post_type() == 'cs-assignments') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'include/edulms-assignments/single-assignments.php';
                }
            } else if (get_post_type() == 'courses') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'include/edulms-courses/single-courses.php';
                }
            } else if (get_post_type() == 'cs-curriculums') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'include/edulms-curriculums/single-cs-curriculums.php';
                }
            } else if (get_post_type() == 'cs-certificates') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'include/edulms-certificates/single-certificates.php';
                }
            }
            return $single_template;
        }

    }

    // End Class
}

if (class_exists('edulms')) {
    // instantiate the plugin class
    $cs_lms = new edulms();
    register_activation_hook(__FILE__, array('edulms', 'activate'));
    register_deactivation_hook(__FILE__, array('edulms', 'deactivate'));
}





/*function ap_action_init(){
			// Localization
			load_plugin_textdomain('EDULMS', plugin_dir_path( __FILE__ ), plugin_dir_path( __FILE__ ));
}
add_action('init', 'ap_action_init');*/