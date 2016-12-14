<?php
global $cs_theme_options;
require_once (get_template_directory() . '/include/theme-components/theme_gobal.php');

function cs_comment_tut_fields() {

    $you_may_use = __('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'LMS');
    $cs_comment_opt_array = array(
        'std' => '',
        'id' => '',
        'classes' => 'commenttextarea',
        'extra_atr' => ' rows="55" cols="15"',
        'cust_id' => 'comment_mes',
        'cust_name' => 'comment',
        'return' => true,
        'required' => false
    );
    $req = isset($req) ? $req : '';
    $html = '<p class="comment-form-comment fullwidth">' .
            '' . __('', 'LMS') . '' . ( $req ? __('', 'LMS') : '' ) . '' .
            '<label>' . __('Message', 'LMS') . '</label><textarea id="comment_mes" name="comment"  class="commenttextarea" rows="4" cols="39"></textarea>' .
            '</p>';

    echo force_balance_tags($html);
}

function cs_filter_comment_form_field_comment($field) {

    return '';
}

// add the filter
add_filter('comment_form_field_comment', 'cs_filter_comment_form_field_comment', 10, 1);

add_action('comment_form_logged_in_after', 'cs_comment_tut_fields');
add_action('comment_form_after_fields', 'cs_comment_tut_fields');

remove_filter('the_title_rss', 'strip_tags');
add_action('after_setup_theme', 'cs_theme_setup');

require_once ABSPATH . '/wp-admin/includes/file.php';
if (!function_exists('cs_theme_setup')) :

    function cs_theme_setup() {
        global $wpdb, $pagenow, $cs_theme_options;
        /* Add theme-supported features. */
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('LMS', get_template_directory() . '/languages');
        if (!isset($content_width)) {
            $content_width = 1170;
        }
        $args = array(
            'default-color' => '',
            'flex-width' => true,
            'flex-height' => true,
            'default-image' => '',
        );
        add_theme_support('custom-background', $args);
        add_theme_support('custom-header', $args);
        add_theme_support("title-tag");
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        add_theme_support('woocommerce');
        /* Add custom actions. */
        if (!session_id()) {
            session_start();
        }
        if (!($cs_theme_options)) {
            cs_get_google_init_arrays();
        }
        if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
            if (!($cs_theme_options)) {
                add_action('init', 'cs_activation_data');
                // Google Fonts array update
            }
            add_action('admin_head', 'cs_activate_widget');
        }
        add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
        //wp_enqueue_scripts
        add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
        add_action('pre_get_posts', 'cs_get_search_results');
        /* Add custom filters. */
        add_filter('widget_text', 'do_shortcode');
        if (class_exists('edulms')) {
            add_filter('user_contactmethods', 'cs_profile_fields', 10, 1);
            add_filter('edit_user_profile', 'cs_contact_options', 10, 1);
            add_filter('show_user_profile', 'cs_contact_options', 10, 1);
            add_action('personal_options_update', 'cs_contact_options_save');
            add_action('edit_user_profile_update', 'cs_contact_options_save');
        }
        add_action('wp_login', 'cs_user_login', 10, 2);
        add_filter('login_message', 'cs_user_login_message');
        add_filter('the_password_form', 'cs_password_form');
        add_filter('wp_page_menu', 'cs_add_menuid');
        add_filter('wp_page_menu', 'cs_remove_div');
        add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
        add_filter('pre_get_posts', 'cs_change_query_vars');
        add_action('init', 'add_oembed_soundcloud');
        if (isset($_GET['activated']) && is_admin()) {
            //	cs_posttype_importer();
            add_action('admin_head', 'cs_posttype_importer');
        }
    }

endif;
// tgm class for (internal and WordPress repository) plugin activation start
require_once dirname(__FILE__) . '/include/theme-components/cs-activation-plugins/tgm_plugin_activation.php';
add_action('tgmpa_register', 'cs_register_required_plugins');
add_action('add_meta_boxes', 'cs_remove_post_meta_boxes');
if (!function_exists('cs_remove_post_meta_boxes')) :

    function cs_remove_post_meta_boxes() {
        //remove_meta_box( 'submitdiv', 'dcpt', 'normal' );
        remove_meta_box('edit-slug-box', 'dcpt', 'side');
        remove_meta_box('edit-slug-box', 'cs_design', 'side');
        //edit-slug-box
    }

endif;
add_action('add_meta_boxes', 'cs_remove_publish_metabox');
if (!function_exists('cs_remove_publish_metabox')) :

    function cs_remove_publish_metabox() {
        //  remove_meta_box( 'minor-publishing', 'cs_design', 'side' );
    }

endif;
if (!function_exists('cs_register_required_plugins')) :

    function cs_register_required_plugins() {
        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(
            // This is an example of how to include a plugin from the WordPress Plugin Repository
            array(
                'name' => 'Revolution Slider',
                'slug' => 'revslider',
                'source' => 'http://chimpgroup.com/wp-demo/download-plugin/revslider.zip',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => 'edulms',
                'slug' => 'edulms',
                'source' => get_stylesheet_directory() . '/include/theme-components/cs-activation-plugins/edulms.zip',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
                'required' => false,
            ),
            array(
                'name' => 'Loco Translate',
                'slug' => 'loco-translate',
                'required' => false,
            ),
            array(
                'name' => 'Woocommerce',
                'slug' => 'woocommerce',
                'required' => false,
            ),
            array(
                'name' => 'Envato Wordpress Toolkit',
                'slug' => 'envato-wordpress-toolkit',
                'source' => 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
                'required' => false,
            )
        );
        // Change this to your theme text domain, used for internationalising strings
        $theme_text_domain = 'LMS';
        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain' => 'LMS', // Text domain - likely want to be the same as your theme.
            'default_path' => '', // Default absolute path to pre-packaged plugins
            'parent_slug' => 'themes.php', // Default parent menu slug
            'menu' => 'install-required-plugins', // Menu slug
            'has_notices' => true, // Show admin notices or not
            'is_automatic' => true, // Automatically activate plugins after installation or not
            'message' => '', // Message to output right before the plugins table
            'strings' => array(
                'page_title' => __('Install Required Plugins', 'LMS'),
                'menu_title' => __('Install Plugins', 'LMS'),
                'installing' => __('Installing Plugin: %s', 'LMS'), // %1$s = plugin name
                'oops' => __('Something went wrong with the plugin API.', 'LMS'),
                'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s)
                'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s)
                'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s)
                'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
                'activate_link' => _n_noop('Activate installed plugin', 'Activate installed plugins'),
                'return' => __('Return to Required Plugins Installer', 'LMS'),
                'plugin_activated' => __('Plugin activated successfully.', 'LMS'),
                'complete' => __('All plugins installed and activated successfully. %s', 'LMS'), // %1$s = dashboard link
                'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );
        tgmpa($plugins, $config);
    }

endif;
// tgm class for (internal and WordPress repository) plugin activation end
// adding custom images while uploading media start
// Blog large
add_image_size('cs_media_1', 860, 418, true);
// Event Detail
add_image_size('cs_media_2', 570, 428, true);
// Courses => Modren View,List View ,Time Line || Events => Plain,Grid ||  Blog=> Grid
add_image_size('cs_media_3', 374, 210, true);
// Course => Grid,Default,Flat Grid,Flat New || Events => Default ,Listing,ELite || Blog => Small,Boxed,Big View
add_image_size('cs_media_4', 370, 278, true);
// Blog Timeline,Course Small
add_image_size('cs_media_5', 272, 186, true);
// Events Timeline
add_image_size('cs_media_6', 152, 114, true);
//Single files paths
if (!function_exists('get_custom_post_type_template')) :

    function get_custom_post_type_template($single_template) {
        global $post;
        $single_path = dirname(__FILE__);
        if ($post->post_type == 'cs-events') {
            $single_template = $single_path . '/cs-templates/events-styles/single-cs-events.php';
        }
        /* if ($post->post_type == 'cs-assigments') {
          $single_template = $single_path.'/cs-templates/course-styles/single-cs-assigments.php';
          } */
        /* if ($post->post_type == 'quiz') {
          $single_template = $single_path.'/cs-templates/course-styles/single-quiz.php';
          } */
        if ($post->post_type == 'courses') {
            $single_template = $single_path . '/cs-templates/course-styles/single-courses.php';
        }

        return $single_template;
    }

endif;
add_filter('single_template', 'get_custom_post_type_template');
/* Display navigation to next/previous for single.php */
if (!function_exists('cs_next_prev_post')) {

    function cs_next_prev_post() {
        global $post;
        posts_nav_link();
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);
        if (!$next && !$previous)
            return;
        ?>
        <aside class="cs-post-sharebtn">
            <?php
            previous_post_link('%link', '<i class="fa fa-angle-left"></i>');
            next_post_link('%link', '<i class="fa fa-angle-right"></i>');
            ?>
        </aside>
        <?php
    }

}

/// Next post link class
if (!function_exists('cs_posts_link_next_class')) :

    function cs_posts_link_next_class($format) {
        $format = str_replace('href=', 'class="pix-nextpost" href=', $format);
        return $format;
    }

endif;
add_filter('next_post_link', 'cs_posts_link_next_class');
/// prev post link class
if (!function_exists('cs_posts_link_prev_class')) :

    function cs_posts_link_prev_class($format) {
        $format = str_replace('href=', 'class="pix-prevpost" href=', $format);
        return $format;
    }

endif;
add_filter('previous_post_link', 'cs_posts_link_prev_class');


// author description custom function
if (!function_exists('cs_author_description')) {

    function cs_author_description($type = '') {
        global $cs_theme_options, $current_user;
        ?>
        <div class="about-author">
            <figure>
                <?php
                $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                $size = 80;
                if (isset($custom_image_url) && $custom_image_url <> '') {
                    echo '<img src="' . $custom_image_url . '" class="avatar photo" id="upload_media" width="' . $size . '" height="' . $size . '" alt="' . $current_user->display_name . '" />';
                } else {
                    ?>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?> </a>
                    <?php
                }
                ?>
            </figure>
            <div class="text">
                <h2><?php echo get_the_author(); ?></h2>
                <p>
                    <?php
                    $author_meta = get_the_author_meta('description');
                    if (strlen($author_meta) > 200) {
                        echo substr($author_meta, 0, 200) . '...';
                    } else {
                        echo balanceTags($author_meta);
                    }
                    ?>
                </p>
                <?php
                if ($type == 'show') {
                    echo '<div class="by-user">';
                    _e('More Posts By', 'LMS');
                    ?>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a> </div>
                <?php
                $uid = get_the_author_meta('ID');
                $facebook = $twitter = $linkedin = $pinterest = $google_plus = '';
                $facebook = get_the_author_meta('facebook', $uid);
                $twitter = get_the_author_meta('twitter', $uid);
                $linkedin = get_the_author_meta('linkedin', $uid);
                $pinterest = get_the_author_meta('pinterest', $uid);
                $google_plus = get_the_author_meta('google_plus', $uid);
                $instagram = get_the_author_meta('instagram', $uid);
                $skype = get_the_author_meta('skype', $uid);
                echo '<p class="social-media">';
                if (isset($facebook) and $facebook <> '') {
                    echo '<a href="' . $facebook . '" data-original-title="Facebook" style="color:#2d5faa;"><i class="fa fa-facebook"></i></a>';
                }
                if (isset($twitter) and $twitter <> '') {
                    echo '<a href="' . $twitter . '" data-original-title="Twitter" style="color:#3ba3f3;"><i class="fa fa-twitter"></i></a>';
                }
                if (isset($linkedin) and $linkedin <> '') {
                    echo '<a href="' . $linkedin . '" data-original-title="Linkedin" style="color:#0077B5;"><i class="fa fa-linkedin"></i></a>';
                }
                if (isset($pinterest) and $pinterest <> '') {
                    echo '<a href="' . $pinterest . '" data-original-title="Pinterest" style="color:#a82626;">
                    <i class="fa fa-pinterest"></i></a>';
                }
                if (isset($google_plus) and $google_plus <> '') {
                    echo '<a href="' . $google_plus . '"  data-original-title="Google Plus" style="color:#f33b3b;">
                    <i class="fa fa-google-plus"></i></a>';
                }
                if (isset($instagram) and $instagram <> '') {
                    echo '<a href="' . $instagram . '"  data-original-title="Instagram" style="color:#48769B;">
                    <i class="fa fa-instagram"></i></a>';
                }
                if (isset($skype) and $skype <> '') {
                    echo '<a href="skype:' . $skype . '?chat"  data-original-title="Skype" style="color:#00AFF0;">
                    <i class="fa fa-skype"></i></a>';
                }
                echo '</p>';
            }
            ?>
        </div>
        </div>
        <?php
    }

}
// Navigation
if (!function_exists('cs_navigationn')) {

    function cs_navigationn($nav = '', $menus = 'menus', $menu_class = '') {
        global $cs_theme_option;
        // Menu parameters
        $defaults = array(
            'theme_location' => "$nav",
            'menu' => '',
            'container' => '',
            'container_class' => '',
            'container_id' => '',
            'menu_class' => "$menu_class",
            'menu_id' => "$menus",
            'echo' => false,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%1$s">%3$s</ul>',
            'depth' => 0,
            'walker' => '',);

        echo do_shortcode(wp_nav_menu($defaults));
    }

}

// tgm class for (internal and WordPress repository) plugin activation end
// stripslashes / htmlspecialchars for theme option save start
if (!function_exists('stripslashes_htmlspecialchars')) {

    function stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}
// stripslashes / htmlspecialchars for theme option save end
//Home Page Services
if (!function_exists('cs_services')) {

    function cs_services() {
        global $cs_theme_option;
        if (isset($cs_theme_option['varto_services_shortcode']) and $cs_theme_option['varto_services_shortcode'] <> "") {
            ?>
            <div class="parallax-fullwidth services-container">
                <div class="container">
                    <?php if ($cs_theme_option['varto_sevices_title'] <> "") { ?>
                        <header class="cs-heading-title">
                            <h2 class="cs-section-title"><?php echo esc_attr($cs_theme_option['varto_sevices_title']); ?></h2>
                        </header>
                        <?php
                    }
                    echo do_shortcode(esc_attr($cs_theme_option['varto_services_shortcode']));
                    ?>
                </div>
            </div>
            <div class="clear"></div>
            <?php
        }
    }

}

//Countries Array
if (!function_exists('cs_get_countries')) :

    function cs_get_countries() {

        $get_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
            "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands",
            "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China",
            "Colombia", "Comoros", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic People's Republic of Korea", "Democratic Republic of the Congo", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "French Polynesia",
            "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
            "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
            "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia",
            "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
            "Myanmar(Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Ireland",
            "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico",
            "Qatar", "Republic of the Congo", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
            "San Marino", "Saudi Arabia", "Scotland", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
            "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
            "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
            "Uzbekistan", "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Wales", "Yemen", "Zambia", "Zimbabwe");

        return $get_countries;
    }

endif;


// installing tables on theme activating start
global $pagenow;

// Admin scripts enqueue
if (!function_exists('cs_admin_scripts_enqueue')) :

    function cs_admin_scripts_enqueue() {
        if (is_admin()) {
            $template_path = get_template_directory_uri() . '/include/assets/scripts/media_upload.js';
            wp_enqueue_media();
            wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
            wp_enqueue_script('datetimepicker1_js', get_template_directory_uri() . '/include/assets/scripts/jquery_datetimepicker.js', '', '', true);
            wp_enqueue_script('admin_theme-option-fucntion_js', get_template_directory_uri() . '/include/assets/scripts/theme_option_fucntion.js', '', '', true);
            wp_enqueue_script('admin_bootstrap_js', get_template_directory_uri() . '/assets/scripts/bootstrap_min.js', '', '', true);
            wp_enqueue_style('datetimepicker1_css', get_template_directory_uri() . '/include/assets/css/jquery_datetimepicker.css');
            wp_enqueue_style('fontawesome_iconpicker_min', get_template_directory_uri() . '/include/assets/css/fontawesome.css');
            wp_enqueue_style('fontawesome_iconpicker', get_template_directory_uri() . '/include/assets/css/fontawesome_iconpicker.css');
            wp_enqueue_script('iconpicker_min_awesome', get_template_directory_uri() . '/include/assets/scripts/fontawesome_iconpicker_min.js');
            wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/include/assets/css/admin_style.css');
            wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_functions.js');
            //wp_enqueue_script('custom_page_builder_wp_admin_script', get_template_directory_uri() . '/scripts/admin/jquery_fonticonpicker_min.js');
            wp_enqueue_script('custom_page_builder_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_page_builder_functions.js');
            //wp_enqueue_script('quiz-assignments_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/quiz_assignments_js_func.js');
            wp_enqueue_style('wp-color-picker');
        }
    }

endif;


// Backend functionality files
require_once (get_template_directory() . '/include/theme-components/cs-googlefont/fonts.php');
require_once (get_template_directory() . '/include/theme-components/cs-googlefont/google_fonts.php');
require_once (get_template_directory() . '/functions-theme.php');
require_once (get_template_directory() . '/include/page_builder.php');
require_once (get_template_directory() . '/include/post_meta.php');
require_once (get_template_directory() . '/include/page_options.php');
require_once (get_template_directory() . '/include/admin_functions.php');
require_once (get_template_directory() . '/include/theme-components/cs-importer/theme_importer.php');
/* require_once (get_template_directory()  . '/include/theme-components/cs-social-login/cs_social_login.php');
  require_once (get_template_directory()  . '/include/theme-components/cs-social-login/google/cs-google-connect.php'); */

require_once (get_template_directory() . '/include/theme-components/cs-mega-menu/custom_walker.php');
require_once (get_template_directory() . '/include/theme-components/cs-mega-menu/edit_custom_walker.php');
require_once (get_template_directory() . '/include/theme-components/cs-mega-menu/menu_functions.php');

require_once (get_template_directory() . '/include/theme-components/cs-widgets/import/class-widget-data.php');
require_once (get_template_directory() . '/include/theme-components/cs-widgets/widgets.php');
require_once (get_template_directory() . '/include/theme-components/cs-header/header_functions.php');

require_once (get_template_directory() . '/include/dcpt/post_options.php');
require_once (get_template_directory() . '/include/dcpt/post_type_dynamic.php');
require_once (get_template_directory() . '/include/dcpt/dynmaic_custom_post_options.php');
require_once (get_template_directory() . '/include/dcpt/dynamic_custom_fields.php');
require_once (get_template_directory() . '/include/dcpt/dynamic_cusotm_fields_elements.php');
require_once (get_template_directory() . '/include/dcpt/dynamic_design_settings.php');
require_once (get_template_directory() . '/include/dcpt/page_elements.php');
require_once (get_template_directory() . '/include/dcpt/functions.php');

require_once (get_template_directory() . '/include/shortcodes/shortcode_elements.php');
require_once (get_template_directory() . '/include/shortcodes/shortcode_functions.php');
require_once (get_template_directory() . '/include/shortcodes/typography_elements.php');
require_once (get_template_directory() . '/include/shortcodes/typography_function.php');
require_once (get_template_directory() . '/include/shortcodes/common_elements.php');
require_once (get_template_directory() . '/include/shortcodes/common_function.php');
require_once (get_template_directory() . '/include/shortcodes/media_elements.php');
require_once (get_template_directory() . '/include/shortcodes/media_function.php');
require_once (get_template_directory() . '/include/shortcodes/contentblock_elements.php');
require_once (get_template_directory() . '/include/shortcodes/contentblock_function.php');
require_once (get_template_directory() . '/include/shortcodes/loops_elements.php');
require_once (get_template_directory() . '/include/shortcodes/loops_function.php');

require_once (get_template_directory() . '/include/theme-components/cs-mailchimp/mailchimp.class.php');
require_once (get_template_directory() . '/include/theme-components/cs-mailchimp/mailchimp_functions.php');

require_once (get_template_directory() . '/include/theme_colors.php');
require_once (get_template_directory() . '/include/shortcodes/class_parse.php');


require_once (get_template_directory() . '/include/theme-options/theme_options.php');
require_once (get_template_directory() . '/include/theme-options/theme_options_fields.php');
require_once (get_template_directory() . '/include/theme-options/theme_options_functions.php');
require_once (get_template_directory() . '/include/theme-options/theme_options_arrays.php');

/////// Require Woocommerce///////

if (class_exists('woocommerce')) {
    require_once( get_template_directory() . '/include/theme-components/cs-woocommerce/config.php' );
    require_once (get_template_directory() . '/include/theme-components/cs-woocommerce/product_meta.php');
}


/////////////////////////////////

if (current_user_can('administrator')) {
    // Addmin Menu CS Theme Option
    if (current_user_can('administrator')) {
        // Addmin Menu CS Theme Option
        add_action('admin_menu', 'cs_theme');

        function cs_theme() {
            add_theme_page('CS Theme Option', __('CS Theme Option', 'LMS'), 'read', 'cs_options_page', 'cs_options_page');
            add_theme_page("Import Demo Data", __("Import Demo Data", 'LMS'), 'read', 'cs_demo_importer', 'cs_demo_importer');
        }

    }
}




if (!function_exists('cs_user_login')) :

    function cs_user_login($user_login, $user) {

        // Get user meta
        $disabled = get_user_meta($user->ID, 'user_switch', true);

        // Is the use logging in disabled?
        if ($disabled == '1') {
            // Clear cookies, a.k.a log user out
            wp_clear_auth_cookie();
            // Build login URL and then redirect
            $login_url = site_url('wp-login.php', 'login');
            $login_url = add_query_arg('disabled', '1', $login_url);
            wp_redirect($login_url);
            exit;
        }
    }

endif;
/* show error message */
if (!function_exists('cs_user_login_message')) :

    function cs_user_login_message($message) {
        // Show the error message if it seems to be a disabled user
        if (isset($_GET['disabled']) && $_GET['disabled'] == 1)
            $message = '<div id="cs_login_error">Account Disable</div>';
        return $message;
    }

endif;

if (!function_exists('cs_slider_gallery_template_redirect')) :

    function cs_slider_gallery_template_redirect() {

        if (get_post_type() == "cs_gallery" or get_post_type() == "cs_slider") {

            global $wp_query;

            $wp_query->set_404();

            status_header(404);

            get_template_part(404);
            exit();
        }
    }

endif;

// enqueue scripts for footer
if (!function_exists('footer_enqueue_scripts')) :

    function footer_enqueue_scripts() {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_enqueue_scripts');
        remove_action('wp_head', 'wp_enqueue_scripts');
        add_action('wp_footer', 'wp_print_scripts', 5);
        add_action('wp_footer', 'wp_enqueue_scripts', 5);
        add_action('wp_footer', 'wp_print_head_scripts', 5);
    }

endif;

//add_action('after_setup_theme', 'footer_enqueue_scripts');
// enque style and scripts front 
// Enqueue frontend style and scripts
if (!function_exists('cs_front_scripts_enqueue')) {

    function cs_front_scripts_enqueue() {
        global $cs_theme_options;
        wp_enqueue_script('jquery', '/wp-includes/js/jquery/jquery.js', '', '', false);

        if (!is_admin()) {
            //wp_enqueue_media();
            //wp_enqueue_script( 'wp-playlist' );
            wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.css');
            wp_enqueue_style('bootstrap-theme_css', get_template_directory_uri() . '/assets/css/bootstrap-theme.css');

            if (isset($cs_theme_options['cs_responsive']) && $cs_theme_options['cs_responsive'] == "on") {
                echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
                wp_enqueue_style('responsive_css', get_template_directory_uri() . '/assets/css/responsive.css');
            }

            wp_enqueue_style('style_css', get_stylesheet_directory_uri() . '/style.css');
            wp_enqueue_style('widget_css', get_template_directory_uri() . '/assets/css/widget.css');

            wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/assets/css/font-awesome.css');
            wp_enqueue_style('theme-typo_css', get_template_directory_uri() . '/assets/css/theme-typo.css');
            wp_enqueue_style('social_connect_css', get_template_directory_uri() . '/include/theme-components/cs-twitter/cs-social-login/media/css/cs-social-style.css');
            if (function_exists('is_woocommerce')) {
                wp_enqueue_style('shp_css', get_template_directory_uri() . '/assets/css/cs_woocommerce.css');
            }
            if (isset($cs_theme_options['cs_smooth_scroll']) and $cs_theme_options['cs_smooth_scroll'] == 'on') {
                wp_enqueue_script('jquery_nicescroll', get_template_directory_uri() . '/assets/scripts/jquery.nicescroll.min.js', '', '', true);
            }
            wp_enqueue_script('bootstrap_min_js', get_template_directory_uri() . '/assets/scripts/bootstrap_min.js', '', '', true);
            wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/assets/scripts/modernizr.js', '', '', true);
            wp_enqueue_script('wow_js', get_template_directory_uri() . '/assets/scripts/wow.js', '', '', true);
            wp_enqueue_script('functions_js', get_template_directory_uri() . '/assets/scripts/functions.js', '', '', true);
            if (is_rtl()) {
                wp_enqueue_style('rtl_css', get_template_directory_uri() . '/assets/css/rtl.css');
            }


            wp_enqueue_style('animate_css', get_template_directory_uri() . '/assets/css/animate.css');
        }
    }

}

// Media element 
if (!function_exists('cs_media_element')) {

    function cs_media_element() {
        wp_enqueue_style('wp-mediaelement', '', '', '', true);
    }

}


// Portfolio Filters
if (!function_exists('cs_filterable')) {

    function cs_filterable() {
        wp_enqueue_script('filterable_js', get_template_directory_uri() . '/assets/scripts/filterable.js', '', '', true);
    }

}

if (!function_exists('cs_enqueue_rating_style_script')) {

    // rating script
    function cs_enqueue_rating_style_script() {
        wp_enqueue_style('jRating_css', get_template_directory_uri() . '/assets/css/jRating.jquery.css');
        wp_enqueue_script('jquery_rating_js', get_template_directory_uri() . '/assets/scripts/jRating.jquery.js', '', '', true);
    }

}


// scroll to fix
if (!function_exists('cs_scrolltofix')) :

    function cs_scrolltofix() {
        wp_enqueue_script('sticky_header_js', get_template_directory_uri() . '/assets/scripts/sticky_header.js', '', '', true);
    }

endif;
// scroll to fix
// social Connect
if (!function_exists('cs_social_connect')) :

    function cs_social_connect() {
        wp_enqueue_script('socialconnect_js', get_template_directory_uri() . '/include/theme-components/cs-social-login/media/js/cs-connect.js', '', '', true);
    }

endif;
// Event Calendar Script
if (!function_exists('cs_eventcalendar_enqueue')) {

    function cs_eventcalendar_enqueue() {
        wp_enqueue_style('eventcalendar_css', get_template_directory_uri() . '/assets/css/event_calendar.css');
        wp_enqueue_script('eventcalendar_js', get_template_directory_uri() . '/assets/scripts/jquery_eventcalendar.js', '', '', true);
    }

}
// Isotope
if (!function_exists('cs_isotope_enqueue')) {

    function cs_isotope_enqueue() {
        wp_enqueue_script('isotope_js', get_template_directory_uri() . '/assets/scripts/isotope_min.js', '', '', true);
    }

}
// Prettyphoto
if (!function_exists('cs_prettyphoto_enqueue')) {

    function cs_prettyphoto_enqueue() {
        wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/assets/css/prettyphoto.css');
        wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/assets/scripts/jquery.prettyphoto.js', '', '', true);
    }

}
// Countdown js
if (!function_exists('cs_countdown_enqueue_scripts')) {

    function cs_countdown_enqueue_scripts() {
        wp_enqueue_script('jquery.countdown.min_js', get_template_directory_uri() . '/assets/scripts/jquery_countdown.js', '', '', TRUE);
    }

}

if (!function_exists('cs_enqueue_validation_script')) {

    function cs_enqueue_validation_script() {
        wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate_metadata.js', '', '', true);
        wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate.js', '', '', true);
    }

}
// Location Search Google map
if (!function_exists('cs_enqueue_location_gmap_script')) {

    function cs_enqueue_location_gmap_script() {
        wp_enqueue_script('jquery.googleapis_js', 'http://maps.googleapis.com/maps/api/js?sensor=false', '', '', true);
        wp_enqueue_script('jquery.gmaps-latlon-picker_js', get_template_directory_uri() . '/include/assets/scripts/jquery_gmaps_latlon_picker.js', '', '', true);
    }

}
// Flexslider Script
if (!function_exists('cs_enqueue_flexslider_script')) {

    function cs_enqueue_flexslider_script() {
        wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/assets/css/flexslider.css');
        wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/assets/scripts/jquery.flexslider-min.js', '', '', true);
    }

}
// Count Numbers
if (!function_exists('cs_count_numbers_script')) {

    function cs_count_numbers_script() {
        wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
    }

}
// Skillbar
if (!function_exists('cs_skillbar_script')) {

    function cs_skillbar_script() {
        wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
        wp_enqueue_script('circliful_js', get_template_directory_uri() . '/assets/scripts/jquery_circliful.js', '', '', true);
    }

}

// Masonry Style and Script enqueue
if (!function_exists('cs_addthis_script_init_method')) {

    function cs_addthis_script_init_method() {
        wp_enqueue_script('cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
    }

}

// carousel script for related posts
if (!function_exists('cs_owl_carousel')) {

    function cs_owl_carousel() {
        wp_enqueue_style('cs_owl_carousel_css', get_template_directory_uri() . '/assets/css/owl.carousel.css');
        wp_enqueue_script('owl.carousel_js', get_template_directory_uri() . '/assets/scripts/owl_carousel_min.js', '', '', true);
    }

}

// Favicon and header code in head tag//
if (!function_exists('cs_header_settings')) {

    function cs_header_settings() {
        global $cs_theme_options;
        ?>
        <link rel="shortcut icon" href="<?php echo esc_url($cs_theme_options['cs_custom_favicon']) ? esc_url($cs_theme_options['cs_custom_favicon']) : '#'; ?>">
        <?php
    }

}

// Favicon and header code in head tag//
if (!function_exists('cs_footer_settings')) {

    function cs_footer_settings() {
        global $cs_theme_options;
        ?>
        <!--[if lt IE 9]><link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/ie8.css" /><![endif]-->
        <?php
        if (isset($cs_theme_options['analytics'])) {
            echo htmlspecialchars_decode(esc_attr($cs_theme_options['cs_custom_js']));
        }
    }

}

// Front End Functions END
// post date/categories/tags
if (!function_exists('cs_posted_on')) {

    function cs_posted_on() {
        ?>
        <ul class="post-meta group">
            <li><i class="fa fa-calendar-o"></i><a href="#"><?php echo get_the_date(); ?></a></li>
            <?php /* ?><li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li><?php */ ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $before_cat = "<li><i class='fa fa-folder-o'></i>" . __('', 'LMS') . "";
            $categories_list = get_the_term_list(get_the_id(), 'category', $before_cat, ', ', '</li>');
            if ($categories_list) {
                printf(__('%1$s', 'LMS'), $categories_list);
            }
            if (comments_open()) {
                echo "<li>
			<i class='fa fa-comment-o'></i>";
                comments_popup_link(__('0 Comment', 'LMS'), __('1 Comment', 'LMS'), __('% Comment', 'LMS'));
            }
            ?>
            <li>
                <?php
                edit_post_link(__('<i class="fa fa-pencil-square-o"></i>Edit', 'LMS'), '', '');
                ?>
            </li>
        </ul>
        <?php
    }

}

// search varibales start
if (!function_exists('cs_get_search_results')) :

    function cs_get_search_results($query) {

        if (!is_admin() and ( is_search())) {

            $query->set('post_type', array('post', 'cs-events', 'courses'));

            remove_action('pre_get_posts', 'cs_get_search_results');
        }
    }

endif;
// password protect post/page

if (!function_exists('cs_password_form')) {

    function cs_password_form() {

        global $post, $cs_theme_option;

        $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );

        $o = '<div class="password_protected">

				<div class="protected-icon"><a href="#"><i class="fa fa-unlock-alt fa-4x"></i></a></div>

				<h3>' . __("This post is password protected. To view it please enter your password below:", 'LMS') . '</h3>';

        $o .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">

					<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>

					<input class="bgcolr" type="submit" name="Submit" value="' . __("Submit", "LMS") . '" />

				</form>

			</div>';

        return balanceTags($o, false);
    }

}
// add menu id
if (!function_exists('cs_add_menuid')) :

    function cs_add_menuid($ulid) {

        return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
    }

endif;
// remove additional div from menu
if (!function_exists('cs_remove_div')) :

    function cs_remove_div($menu) {

        return preg_replace(array('#^<div[^>]*>#', '#</div>$#'), '', $menu);
    }

endif;
// add parent class

if (!function_exists('cs_add_parent_css')) :

    function cs_add_parent_css($classes, $item) {
        global $cs_menu_children;
        if ($cs_menu_children)
            $classes[] = 'parent';
        return $classes;
    }

endif;
// change the default query variable start

if (!function_exists('cs_change_query_vars')) :

    function cs_change_query_vars($query) {

        if (is_search() || is_home()) {

            if (empty($_GET['page_id_all']))
                $_GET['page_id_all'] = 1;

            $query->query_vars['paged'] = $_GET['page_id_all'];

            return $query;
        }

        // Return modified query variables
    }

endif;
// Filter shortcode in text areas
if (!function_exists('cs_textarea_filter')) {

    function cs_textarea_filter($content = '') {
        return do_shortcode($content);
    }

}
//////////////// Header Cart ///////////////////

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
if (!function_exists('woocommerce_header_add_to_cart_fragment')) :

    function woocommerce_header_add_to_cart_fragment($fragments) {
        if (class_exists('woocommerce')) {
            global $woocommerce;
            ob_start();
            ?>
            <div class="cart-sec"> <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"> <i class="fa fa-shopping-cart"></i><span class="amount"><?php echo intval($woocommerce->cart->cart_contents_count); ?></span> </a> </div>
            <?php
            $fragments['div.cart-sec'] = ob_get_clean();
            return $fragments;
        }
    }

endif;

if (!function_exists('cs_woocommerce_header_cart')) {

    function cs_woocommerce_header_cart() {
        if (class_exists('woocommerce')) {
            global $woocommerce;
            echo '<a href="' . esc_url($woocommerce->cart->get_cart_url()) . '"> <i class="fa fa-archive"></i>'
            ?>
            <span class="amount">
                <?php
                if ($woocommerce->cart->cart_contents_count > 0) {
                    echo intval($woocommerce->cart->cart_contents_count);
                } else {
                    _e('0', 'LMS');
                }
                ?>
            </span> </a>
            <?php
        }
    }

}

//////////////// Header Cart Ends ///////////////////
//	Add Featured/sticky text/icon for sticky posts.

if (!function_exists('cs_featured')) {

    function cs_featured() {

        global $cs_transwitch, $cs_theme_option;

        if (is_sticky()) {
            ?>
            <span class="featured-post">
            <?php _e('Featured', 'LMS'); ?>
            </span>
            <?php
        }
    }

}
// custom function start
// display post page title
if (!function_exists('cs_post_page_title')) {

    function cs_post_page_title() {

        if (is_author()) {

            global $author;

            $userdata = get_userdata($author);

            echo __('Author', 'LMS') . " " . __('Archives', 'LMS') . ": " . $userdata->display_name;
        } elseif (is_tag() || is_tax('event-tag')) {

            echo __('Tags', 'LMS') . " " . __('Archives', 'LMS') . ": " . single_cat_title('', false);
        } elseif (is_category() || is_tax('event-category') || is_tax('course-category')) {

            echo __('Categories', 'LMS') . " " . __('Archives', 'LMS') . ": " . single_cat_title('', false);
        } elseif (is_search()) {

            printf(__('Search Results %1$s %2$s', 'LMS'), ': ', '<span>' . get_search_query() . '</span>');
        } elseif (is_day()) {

            printf(__('Daily Archives: %s', 'LMS'), '<span>' . get_the_date() . '</span>');
        } elseif (is_month()) {

            printf(__('Monthly Archives: %s', 'LMS'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'LMS')) . '</span>');
        } elseif (is_year()) {

            printf(__('Yearly Archives: %s', 'LMS'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'LMS')) . '</span>');
        } elseif (is_404()) {

            _e('Error 404', 'LMS');
        } elseif (!is_page()) {

            _e('Archives', 'LMS');
        }
    }

}
// If no content, include the "No posts found" function
if (!function_exists('fnc_no_result_found')) {

    function fnc_no_result_found($search = true) {
        $is_search = '';
        global $cs_theme_options;
        ?>
        <div class="page-not-found">
            <header>
                <h5>
        <?php _e('No results found.', 'LMS'); ?>
                </h5>
            </header>
            <aside class="cs-icon"> <i class="fa fa-frown-o"></i> </aside>
            <div class="desc">
                <h3>
                    <?php
                    if ($search == true) {
                        if (is_home() && current_user_can('publish_posts')) :
                            printf(__('Ready to publish your first post? <a href="%1$s">Get Started Here</a>.', 'LMS'), admin_url('post-new.php'));
                            $is_search = false;
                        elseif (is_search()) :
                            _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'LMS');
                            $is_search = true;
                        else :
                            _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'LMS');
                            $is_search = true;
                        endif;
                    }
                    ?>
                </h3>
            </div>
            <?php
            if ($is_search == true) :
                get_search_form();
            endif;
            ?>
        </div>
        <?php
    }

}

if (!function_exists('wps_highlight_results')) :

    function wps_highlight_results($text) {
        if (is_search()) {
            $sr = get_query_var('s');
            $keys = explode(" ", $sr);
            $text = preg_replace('/(' . implode('|', $keys) . ')/iu', '' . $sr . '', $text);
        }
        return $text;
    }

endif;

add_filter('get_the_excerpt', 'wps_highlight_results');
//add_filter('the_title', 'wps_highlight_results');
// Custom function for next previous posts
if (!function_exists('px_next_prev_custom_links')) :

    function px_next_prev_custom_links($post_type = 'events') {
        global $post, $wpdb, $cs_theme_options, $cs_xmlObject;
        $previd = $nextid = '';
        $post_type = get_post_type($post->ID);
        $count_posts = wp_count_posts("$post_type")->publish;
        $px_postlist_args = array(
            'posts_per_page' => -1,
            'order' => 'ASC',
            'post_type' => "$post_type",
        );
        $px_postlist = get_posts($px_postlist_args);
        $ids = array();
        foreach ($px_postlist as $px_thepost) {
            $ids[] = $px_thepost->ID;
        }
        $thisindex = array_search($post->ID, $ids);
        if (isset($ids[$thisindex - 1])) {
            $previd = $ids[$thisindex - 1];
        }
        if (isset($ids[$thisindex + 1])) {
            $nextid = $ids[$thisindex + 1];
        }

        echo '<aside class="cs-post-sharebtn"><div class="cs-table"><div class="cs-row">';
        if (isset($previd) && !empty($previd) && $previd >= 0) {
            ?>
            <div class="cs-cell"> <a href="<?php echo get_permalink((int) $previd); ?>"><i class="fa fa-angle-left"></i>
                        <?php echo get_the_post_thumbnail((int) $previd, array(100, 100)); ?>
                    <small>
                        <?php
                        _e('Previous Post', 'LMS');
                        ?>
                    </small> <span><?php echo get_the_title($previd); ?></span> </a> </div>
            <?php
        }

        if (isset($nextid) && !empty($nextid)) {
            if (isset($previd) && !empty($previd) && $previd >= 0) {
                $nextClass = 'right-btn';
            } else {
                $nextClass = 'right-btn cs-single-post';
            }
            ?>
            <div class="cs-cell <?php echo cs_allow_special_char($nextClass); ?>"> <a href="<?php echo get_permalink($nextid); ?>"><i class="fa fa-angle-right"></i>
                    <?php
                    echo get_the_post_thumbnail(intval($nextid), array(100, 100));
                    ?>
                    <small>
                        <?php
                        _e('Next Post', 'LMS');
                        ?>
                    </small> <span><?php echo get_the_title(intval($nextid)); ?></span> </a> 
            </div>
            <?php
        }
        echo '</div></div></aside>';
        wp_reset_query();
    }

endif;

// 
if (!function_exists('cs_indent')) :

    function cs_indent($text, $n) {
        if (is_string($text) && is_int($n)) {
            $indent = "";
            $i = 0;
            while ($i < $n) {
                $i++;
                $indent.= "\t";
            }
            return str_replace("\n", "\n" . $indent, str_replace(array("\r\n", "\r"), "\n", $text));
        }
    }

endif;

// Calendar time
if (!function_exists('calender_time')) :

    function calender_time($event_time) {
        $mints = $mints = '';
        $seconds = '00';
        if (strlen($event_time) < 6) {
            $event_time = '0' . $event_time;
        }
        $time = $event_time;
        $time_param = str_replace("pm", '', $event_time);
        $time_param = str_replace("am", '', $time_param);
        $time_param_array = explode(':', $time_param);
        $pos = strpos($time, 'pm');
        if ($pos === false) {
            $hours = $time_param_array['0'];
            $mints = $time_param_array['1'];
        } else {
            $hours = $time_param_array['0'] + 12;
            $mints = $time_param_array['1'];
        }
        return $hours . ':' . $mints . ':' . $seconds;
    }

endif;

if (!function_exists('get_formated_date')) :

    function get_formated_date($date) {

        return mysql2date(get_option('date_format'), $date);
    }

endif;

if (!function_exists('get_formated_time')) :

    function get_formated_time($time) {
        return mysql2date(get_option('time_format'), $time, $translate = true);
        ;
    }

endif;

/* 	Function to get the events info on calander -- START	 */
add_action('get_header', 'my_filter_head');

if (!function_exists('my_filter_head')) :

    function my_filter_head() {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

endif;
/* add_filter( 'add_to_cart_text', 'woo_custom_cart_button_text' ); // < 2.1
  add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' ); // 2.1 +
  function woo_custom_cart_button_text() {
  return __('Buy Now', 'woocommerce' );
  } */

//Automatically add new users to a group
if (!function_exists('automatic_group_membership')) :

    function automatic_group_membership($user_id) {
        echo absint($user_id);
        if (!$user_id)
            return false;
        groups_accept_invite(3, 2);
    }

endif;


// Course, Quiz functions
if (!function_exists('cs_get_user_id')) {

    function cs_get_user_id() {
        global $current_user;
        return absint($current_user->ID);
    }

}

//count user posts by post type
if (!function_exists('count_user_posts_by_type')) :

    function count_user_posts_by_type($userid, $post_type = 'post') {
        global $wpdb, $post;
        //$where = get_posts_by_author_sql( $post_type, true, $userid );
        //$where .= " AND ID=".$post->ID;
        //$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts $where"));
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE ID = '%d' AND post_author='%d' AND post_type='%s'", $post->ID, $userid, $post_type));
        return apply_filters('get_usernumposts', $count, $userid);
    }

endif;


// add theme caps
if (!function_exists('add_theme_caps')) :

    function add_theme_caps() {
        //remove_role('cinstructorr');
        //remove_role('instructorr');
    }

endif;
add_action('admin_init', 'add_theme_caps');

// add course caps to admin
if (!function_exists('add_courses_caps_to_admin')) :

    function add_courses_caps_to_admin() {

        $instructor = get_role('instructor');
        if (!isset($instructor)) {
            $instructor = add_role('instructor', 'Instructor');
        }

        $instructor->add_cap('edit_courses');
        $instructor->add_cap('edit_courses');
        $instructor->add_cap('edit_other_courses');
        $instructor->add_cap('publish_courses');
        $instructor->add_cap('read_courses');
        $instructor->add_cap('read_private_courses');
        $instructor->add_cap('delete_course');
        $instructor->add_cap('edit_post');
        $instructor->add_cap('read_post');
    }

endif;
//add_action( 'admin_init', 'add_courses_caps_to_admin' );
// Attendor List
if (!function_exists('cs_attendor_list')) :

    function cs_attendor_list($post_id = "") {
        $cs_event = get_post_meta($post_id, "cs_event_transaction_meta", true);
        $cs_xmlObject_event = new SimpleXMLElement($cs_event);
        $cs_var_attendor_list = cs_ObjecttoArray($cs_xmlObject_event);
        $cs_var_attendors = $cs_xmlObject_event->transaction;
        $cs_total_attendors = count($cs_xmlObject_event->transaction);
        if ($cs_total_attendors > 1) {
            for ($i = 0; $i < $cs_total_attendors; $i++) {
                $cs_attendor = $cs_var_attendor_list[transaction][$i]['var_cp_attendor'];
                $cs_attendor_data = get_userdata($cs_attendor);
                echo '<figure>' . get_avatar($cs_attendor_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 31)) . '</figure>';
            }
        } elseif ($cs_total_attendors == 1) {
            $cs_attendor = $cs_var_attendor_list[transaction]['var_cp_attendor'];
            $cs_attendor_data = get_userdata($cs_attendor);
            echo '<figure>' . get_avatar($cs_attendor_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 31)) . '</figure>';
        }
    }

endif;

// File upload
if (!function_exists('cs_insert_attachment')) :

    function cs_insert_attachment($file_handler, $post_id, $setthumb = 'false') {
        // check to make sure its a successful upload
        if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
            __return_false();
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        $attach_id = media_handle_upload($file_handler, $post_id);
        if ($setthumb)
            update_post_meta($post_id, '_thumbnail_id', $attach_id);
        return $attach_id;
    }

endif;

// get date gap
if (!function_exists('dateDiff')) {

    function dateDiff($d1, $d2) {
        $date1 = strtotime($d1);
        $date2 = strtotime($d2);
        $seconds = $date1 - $date2;
        $weeks = floor($seconds / 604800);
        $seconds -= $weeks * 604800;
        $days = floor($seconds / 86400);
        $seconds -= $days * 86400;
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        $months = round(($date1 - $date2) / 60 / 60 / 24 / 30);
        $years = round(($date1 - $date2) / (60 * 60 * 24 * 365));
        $diffArr = array("Seconds" => $seconds,
            "minutes" => $minutes,
            "Hours" => $hours,
            "Days" => $days,
            "Weeks" => $weeks,
            "Months" => $months,
            "Years" => $years
        );
        $diffArr = array_filter($diffArr);
        return $diffArr;
    }

}
// login action

if (!function_exists('cs_get_ID_by_page_name')) :

    function cs_get_ID_by_page_name($page_name) {
        global $wpdb;
        $page_name_id = $wpdb->get_var($wpdb->prepare("SELECT ID from " . $wpdb->prefix . "posts WHERE post_name =%s,", $page_name));
        return $page_name_id;
    }

endif;

// query total post number
if (!function_exists('cs_query_total_posts')) :

    function cs_query_total_posts($post_type) {
        global $cs_node;
        $args = array('posts_per_page' => "-1", 'post_type' => $post_type, 'post_status' => 'publish');
        if (isset($cs_node->cs_blog_cat) && $cs_node->cs_blog_cat <> '' && $cs_node->cs_blog_cat <> '0') {
            $args['category_name'] = $cs_node->cs_blog_cat;
        }
        $custom_query = new WP_Query($args);
        return $post_count = $custom_query->post_count;
    }

endif;

// get custom query args
if (!function_exists('cs_query_args')) :

    function cs_query_args($post_type = 'post', $page_id_all = '1', $cs_category = '', $cs_num_post = '10', $cs_orderby = 'ID', $category_name = 'category_name') {
        global $cs_node;
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
        $args = array('posts_per_page' => "$cs_num_post", 'post_type' => $post_type, 'paged' => $_GET['page_id_all'], 'order' => "$cs_node->cs_blog_orderby");
        if (isset($cs_category) && $cs_category <> '' && $cs_category <> '0') {
            $args[$category_name] = $cs_category;
        }
        return $custom_query = new WP_Query($args);
    }

endif;

// get page builder section title
if (!function_exists('cs_section_title')) :

    function cs_section_title($heading_class = 'cs-heading-title', $heading_tag = 'h2', $element_class = 'cs-section-title') {
        global $cs_node;
        $heading = '';
        if ($cs_node->cs_dcpt_title <> '') {
            $heading .= '<header class="' . $heading_class . '">';
            $heading .= '<' . $heading_tag . ' class="' . $element_class . '">' . $cs_node->cs_dcpt_title . '</' . $heading_tag . '>';
            $heading .= '</header>';
        }
        return $heading;
    }

endif;

// get dynamic post taxonomy
if (!function_exists('cs_taxanomy_name')) :

    function cs_taxanomy_name($postname, $category_name = 'category') {
        if ($postname <> 'post') {
            $args = array(
                'name' => (string) $postname,
                'post_type' => 'dcpt',
                'post_status' => 'publish',
                'showposts' => 1,
            );
            $get_posts = get_posts($args);
            if ($get_posts) {
                $dcpt_id = (int) $get_posts[0]->ID;
            }
            wp_reset_query();
            if (isset($category_name) && $category_name == 'tags') {
                return $cs_tags_name = get_post_meta($dcpt_id, 'cs_tags_name', true);
            } else if (isset($category_name) && $category_name == 'category') {
                return $cs_categories_name = get_post_meta($dcpt_id, 'cs_categories_name', true);
            }
        } else {
            if (isset($category_name) && $category_name == 'tags') {
                return 'post_tag';
            } else if (isset($category_name) && $category_name == 'category') {
                return 'category';
            }
        }
    }

endif;

// get dynamic post type id
if (!function_exists('cs_get_parent_custom_posttype_id')) :

    function cs_get_parent_custom_posttype_id($postname) {
        if ($postname <> 'post') {
            $args = array(
                'name' => (string) $postname,
                'post_type' => 'dcpt',
                'post_status' => 'publish',
                'showposts' => 1,
            );
            $get_posts = get_posts($args);

            if ($get_posts) {
                return $dcpt_id = (int) $get_posts[0]->ID;
            }
        }
    }

endif;

// get post default values
if (!function_exists('cs_post_query_data')) :

    function cs_post_query_data() {
        global $default_view;
        echo do_shortcode(html_entity_decode(stripslashes($default_view)));
    }

endif;
// Get Google Fonts

if (!function_exists('cs_get_google_fonts')) :

    function cs_get_google_fonts() {
        $fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
            "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
            "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
            "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
            "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
            "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
            "Roboto", "Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
            "Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz", "Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra",
            "Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard",
            "Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One",
            "Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
            "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge",
            "Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo",
            "PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy",
            "Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn", "Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura",
            "Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre",
            "Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC",
            "Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market",
            "Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed",
            "Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One",
            "Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky",
            "Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand",
            "Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover",
            "Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore",
            "Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid",
            "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim",
            "Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas",
            "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut",
            "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico",
            "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P",
            "Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script",
            "Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two",
            "Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil",
            "Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut",
            "Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat",
            "Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
        return $fonts;
    }

endif;

// enqueue timepicker scripts
if (!function_exists('cs_enqueue_timepicker_script')) :

    function cs_enqueue_timepicker_script() {
        if (is_admin()) {
            wp_enqueue_script('custom_timepicker_script', get_template_directory_uri() . '/include/assets/scripts/jquery_timepicker.js');
        }
    }

endif;
add_action('admin_enqueue_scripts', 'my_admin_scripts');

// enqueue admin scripts
if (!function_exists('my_admin_scripts')) :

    function my_admin_scripts() {
        if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {
            wp_enqueue_media();
            wp_register_script('my-admin-js', WP_PLUGIN_URL . '/my-plugin/my-admin.js', array('jquery'));
            wp_enqueue_script('my-admin-js');
        }
    }

endif;

// register theme menu
if (!function_exists('cs_register_my_menus')) :

    function cs_register_my_menus() {
        register_nav_menus(
                array(
                    'main-menu' => __('Main Menu', 'LMS'),
                    'footer-menu' => __('Footer Menu', 'LMS'),
                    'top-menu' => __('Top Menu', 'LMS')
                )
        );
    }

endif;
add_action('init', 'cs_register_my_menus');


//== Post Functions Start
// Get Tags of Post Start 
if (!function_exists('cs_get_tags')) {

    function cs_get_tags($seprator, $post_id, $attr, $is_seprator) {
        global $post;
        $tags = wp_get_post_tags($post_id, $attr);
        $totalItems = count($tags);
        $seprator = '';
        $html = '';
        $i = 0;
        if ($is_seprator == true) {
            $seprator = $seprator ? $seprator : ',';
        }
        if ($tags) {
            foreach ($tags as $tag) {
                $i++;
                $seprator = $totalItems == $i ? '' : $seprator;
                $tag_link = get_tag_link($tag->term_id);
                $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                $html .= "" . ucwords($tag->name) . "</a>" . $seprator;
            }
        }
        return $html;
    }

}

// Get Tags of Post End
//  Set Post Veiws Start
if (!function_exists('cs_set_post_views')) :

    function cs_set_post_views($postID) {
        //   $visited = get_transient($key); //get transient and store in variable
        if (!isset($_COOKIE["cs_count_views" . $postID])) {
            setcookie("cs_count_views" . $postID, 'post_view_count', time() + 86400);
            //  set_transient( $key, $value, 60*60*12);
            $count_key = 'cs_count_views';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }

endif;
//  Set Post Veiws End
//  Get Post Veiws Start
if (!function_exists('cs_get_post_views')) :

    function cs_get_post_views($postID) {
        $count_key = 'cs_count_views';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 ";
        }
        return number_format($count);
    }

endif;

//  Get Post Veiws End
//  Excerpt Default Length 
if (!function_exists('cs_custom_excerpt_length')) :

    function cs_custom_excerpt_length($length) {
        return 200;
    }

endif;

add_filter('excerpt_length', 'cs_custom_excerpt_length');
// Custom excerpt function 
if (!function_exists('cs_get_the_excerpt')) {

    function cs_get_the_excerpt($charlength = '255', $readmore = 'true', $readmore_text = 'Read More') {
        global $post, $cs_theme_option;
        $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));

        if (strlen($excerpt) > $charlength) {
            /* 			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
              $exwords = explode( ' ', $subex );
              $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) ); */
            if ($charlength > 0) {
                $excerpt = substr($excerpt, 0, $charlength);
            } else {
                $excerpt = $excerpt;
            }
            if ($readmore == 'true') {
                $more = '... <a href="' . get_permalink() . '" class="cs-read-more colr"><i class="fa fa-caret-right"></i>' . $readmore_text . '</a>';
            } else {
                $more = '...';
            }
            return $excerpt . $more;
        } else {
            return $excerpt;
        }
    }

}
/* Excerpt Read More  */
if (!function_exists('cs_excerpt_more')) :

    function cs_excerpt_more($more = '...') {
        return '....';
    }

endif;
add_filter('excerpt_more', 'cs_excerpt_more');


/* get tag list from course categories */
if (!function_exists('cs_get_tags_list')) :

    function cs_get_tags_list($filter_category = '', $filter_tag = '') {
        global $post;
        $args = array('posts_per_page' => -1, 'post_type' => 'courses', 'course-category' => $filter_category);
        $project_query = new WP_Query($args);
        while ($project_query->have_posts()) : $project_query->the_post();
            $posttags = get_the_terms($post->ID, 'course-tag');
            if ($posttags) {
                foreach ($posttags as $tag) {
                    $all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
                }
            }
        endwhile;
        if (is_array($all_tags_arr) && count($all_tags_arr) > 0):
            $tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
            foreach ($tags_arr as $tag):
                $active_class = '';
                $el = get_term_by('name', $tag, 'course-tag');
                $arr[] = '"tag-' . $el->slug . '"';
                if ($filter_tag == $el->slug) {
                    $active_class = "class='active'";
                }
                echo '<a href="?filter_category=' . $filter_category . '&amp;filter-tag=' . $el->slug . '" id="taglink-tag-' . $el->slug . '" title="tag-' . $el->slug . '" ' . $active_class . ' >' . $el->name . '</a>';
            endforeach;
        endif;
    }

endif;

// get events tags list
if (!function_exists('cs_get_event_tags_list')) :

    function cs_get_event_tags_list($filter_category = '', $filter_tag = '', $organizer_filter = '') {
        global $post;
        $args = array('posts_per_page' => -1, 'post_type' => 'cs-events', 'events-categories' => $filter_category);
        $project_query = new WP_Query($args);
        while ($project_query->have_posts()) : $project_query->the_post();
            $posttags = get_the_terms($post->ID, 'events-tags');
            if ($posttags) {
                foreach ($posttags as $tag) {
                    $all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
                }
            }
        endwhile;
        if (is_array($all_tags_arr) && count($all_tags_arr) > 0):
            $tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
            foreach ($tags_arr as $tag):
                $active_class = '';
                $el = get_term_by('name', $tag, 'events-tags');
                $arr[] = '"tag-' . $el->slug . '"';
                if ($filter_tag == $el->slug) {
                    $active_class = "class='active'";
                }

                echo '<a href="?organizer=' . $organizer_filter . '&amp;?filter_category=' . $filter_category . '&amp;filter-tag=' . $el->slug . '" id="taglink-tag-' . $el->slug . '" title="tag-' . $el->slug . '" ' . $active_class . ' >' . $el->name . '</a>';
            endforeach;
        endif;
    }

endif;

//=====================================================================
// Events filtering methods
//=====================================================================
if (!function_exists('cs_get_event_filters')) :

    function cs_get_event_filters($cs_dcpt_post_category, $cs_dcpt_post_filterable, $filter_category, $filter_tag, $userArray, $organizer_filter, $cs_custom_animation) {
        global $post, $cs_theme_options, $cs_counter_node, $wpdb;
        $nav_count = rand(40, 9999999);
        if (isset($cs_dcpt_post_filterable) && $cs_dcpt_post_filterable == 'Yes') {
            ?>
            <!--Sorting Navigation-->
            <div class="col-md-12">
                <nav class="wow filter-nav <?php echo esc_attr($cs_custom_animation); ?>">
                    <ul class="cs-filter-menu pull-left">
                        <li> <a href="#pager-1<?php echo intval($nav_count); ?>"> <i class="fa fa-search"></i><?php _e('Filter By', 'LMS'); ?>  
                            </a> </li>
                        <li><a href="#pager-2<?php echo intval($nav_count); ?>"><i class="fa fa-list"></i><?php
                    _e('Categories', 'LMS');
            ?></a></li>
                        <li><a href="#pager-3<?php echo intval($nav_count); ?>"><i class="fa fa-tags"></i><?php
                    _e('Tags', 'LMS');
            ?></a></li>
                        <li><a href="#pager-4<?php echo intval($nav_count); ?>"><i class="fa fa-user"></i><?php
                    _e('Organizers', 'LMS');
                    ?></a></li>
                    </ul>
                    <a href="<?php the_permalink(); ?>" class="pull-right cs-btnshowall"> <i class="fa fa-check-circle-o"></i> 
                        <?php _e('Show All', 'LMS'); ?>  
                    </a>
                    <div id="pager-1<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;"> <a class="<?php
                                                                                                                       if (isset($_GET['sort']) and $_GET['sort'] == 'asc') {
                                                                                                                           echo 'active';
                                                                                                                       }
                                                                                                                       ?>" href="?<?php echo 'organizer=' . $organizer_filter . '&amp;sort=asc&amp;filter_category=' . $filter_category . '&amp;filter-tag=' . $filter_tag; ?>"> <?php _e('Date Published', 'LMS'); ?> </a> <a class="<?php
                            if (isset($_GET['sort']) and $_GET['sort'] == 'alphabetical') {
                                echo 'active';
                            }
                            ?>" href="?<?php echo 'organizer=' . $organizer_filter . '&amp;sort=alphabetical&amp;filter_category=' . $filter_category . '&amp;filter_tag=' . $filter_tag; ?>"> <?php
                        echo _e('Alphabetical', 'LMS');
                        _e('Alphabetical', 'LMS');
                        ?> </a> </div>
                    <div id="pager-2<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
                        <?php
                           $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from " . $wpdb->prefix . "terms WHERE slug =%s", $cs_dcpt_post_category));
                           if (isset($cs_dcpt_post_category) && ($cs_dcpt_post_category <> "" && $cs_dcpt_post_category <> "0") && isset($row_cat->term_id)) {
                               $categories = get_categories(array('child_of' => "$row_cat->term_id", 'taxonomy' => 'events-categories', 'hide_empty' => 0));
                               ?>
                            <a href="?<?php echo "organizer=" . $organizer_filter . "&amp;filter_category=" . $filter_category; ?>"class="<?php
                            if (($cs_dcpt_post_category == $filter_category)) {
                                echo 'bgcolr';
                            }
                            ?>">
                            <?php _e('All Categories', 'LMS'); ?>  
                            </a>
                            <?php
                           } else {
                               $categories = get_categories(array('taxonomy' => 'events-categories', 'hide_empty' => 0));
                           }
                           foreach ($categories as $category) {
                               ?>
                            <a href="?<?php echo "organizer=" . $organizer_filter . "&amp;filter_category=" . $category->slug ?>" 
                            <?php
                            if ($category->slug == $filter_category) {
                                echo 'class="active"';
                            }
                            ?>> <?php echo esc_attr($category->cat_name); ?> </a>
                        <?php } ?>
                    </div>
                    <div id="pager-3<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
                        <?php cs_get_event_tags_list($filter_category, $filter_tag, $organizer_filter); ?>
                    </div>
                    <div id="pager-4<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
                            <?php
                            $eventusers = get_users('orderby=nicename');
                            if ($userArray) {
                                foreach ($eventusers as $user) {
                                    if (in_array($user->ID, $userArray)) {
                                        ?>
                                    <a <?php
                                        if (isset($_GET['organizer']) && $user->ID == $_GET['organizer']) {
                                            echo 'class="active"';
                                        }
                                        ?> href="?<?php echo 'organizer=' . $user->ID . '&amp;filter_category=' . $filter_category . '&amp;filter_tag=' . $filter_tag; ?>"> <?php echo esc_attr($user->display_name); ?> </a>
                    <?php
                    }
                }
            } else {
                ?>
                            <a>
                <?php _e('No Organizer Found.', 'LMS'); ?>
                            </a>
            <?php } ?>
                    </div>
                </nav>
            </div>
            <!--Sorting Navigation End-->
            <?php
        }
    }

endif;

//=====================================================================
// Blog filtering methods
//=====================================================================
if (!function_exists('cs_get_blog_filters')) :

    function cs_get_blog_filters($cs_blog_cat, $author_filter, $filter_category, $filter_tag, $cs_blog_filterable, $cs_custom_animation) {
        global $post, $cs_theme_options, $cs_counter_node, $wpdb;
        $nav_count = rand(40, 9999999);
        if (isset($cs_blog_filterable) && $cs_blog_filterable == 'yes') {
            ?>
            <!--Sorting Navigation-->
            <div class="col-md-12">
                <nav class="wow filter-nav <?php echo esc_attr($cs_custom_animation); ?>">
                    <ul class="cs-filter-menu pull-left">
                        <li> <a href="#pager-1<?php echo intval($nav_count); ?>"> <i class="fa fa-search"></i><?php
                                //echo _e('Filter By','LMS');
                                _e('Filter By', 'LMS');
                                ?>  
                            </a> </li>
                        <li><a href="#pager-2<?php echo intval($nav_count); ?>"><i class="fa fa-list"></i><?php
            //echo _e('Categories','LMS');
            _e('Categories', 'LMS');
            ?></a></li>
                        <li><a href="#pager-3<?php echo intval($nav_count); ?>"><i class="fa fa-tags"></i><?php
                           //echo _e('Tags','LMS');
                           _e('Tags', 'LMS');
                           ?></a></li>
                        <li><a href="#pager-4<?php echo intval($nav_count); ?>"><i class="fa fa-user"></i><?php
               //echo _e('Tags','LMS');
               _e('Author', 'LMS');
                           ?></a></li>
                    </ul>
                    <a href="<?php the_permalink(); ?>" class="pull-right cs-btnshowall"> <i class="fa fa-check-circle-o"></i> <?php //echo _e('Show All','LMS');?> 
                        <?php _e('Show All', 'LMS'); ?>  
                    </a>
                    <div id="pager-1<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;"> 
                        <a class="<?php
            if (isset($_GET['sort']) and $_GET['sort'] == 'asc') {
                echo 'active';
            }
            ?>" href="?<?php echo 'by_author=' . $author_filter . '&amp;sort=asc&amp;filter_category=' . $filter_category . '&amp;filter-tag=' . $filter_tag; ?>"> <?php _e('Date Published', 'LMS'); ?> </a>
                        <a class="<?php
                        if (isset($_GET['sort']) and $_GET['sort'] == 'alphabetical') {
                            echo 'active';
                        }
                        ?>" href="?<?php echo 'by_author=' . $author_filter . '&amp;sort=alphabetical&amp;filter_category=' . $filter_category . '&amp;filter_tag=' . $filter_tag; ?>"> <?php echo _e('Alphabetical', 'LMS'); ?> </a> </div>
                    <div id="pager-2<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
                        <?php
                        $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from " . $wpdb->prefix . "terms WHERE  slug =%s", $cs_blog_cat));
                        if (isset($cs_blog_cat) && ($cs_blog_cat <> "" && $cs_blog_cat <> "0") && isset($row_cat->term_id)) {
                            $categories = get_categories(array('child_of' => "$row_cat->term_id", 'taxonomy' => 'category', 'hide_empty' => 1));
                            ?>
                            <a href="?<?php echo "by_author=" . $author_filter . "&amp;filter_category=" . $filter_category; ?>"class="<?php
                if (($cs_blog_cat == $filter_category)) {
                    echo 'bgcolr';
                }
                ?>">

                            <?php _e('All Categories', 'LMS'); ?>  

                            </a>
                            <?php
                        } else {
                            $categories = get_categories(array('taxonomy' => 'category', 'hide_empty' => 1));
                        }
                        foreach ($categories as $category) {
                            ?>
                            <a href="?<?php echo "by_author=" . $author_filter . "&amp;filter_category=" . $category->slug ?>" 
                            <?php
                            if ($category->slug == $filter_category) {
                                echo 'class="active"';
                            }
                            ?>> <?php echo esc_attr($category->cat_name); ?> </a>
                            <?php } ?>
                    </div>
                    <div id="pager-3<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
            <?php cs_get_post_tags_list($filter_category, $filter_tag, $author_filter); ?>
                    </div>
                    <div id="pager-4<?php echo intval($nav_count); ?>" class="filter-pager" style="display: none;">
            <?php
            $user_ids = get_users(array(
                'fields' => 'all',
                'orderby' => 'post_count',
                'order' => 'DESC',
                'who' => 'authors',
            ));
            foreach ($user_ids as $user) {
                $post_count = count_user_posts($user->ID);
                // Move on if user has not published a post (yet).
                if ($post_count) {
                    ?>
                                <a <?php
                    if (isset($_GET['by_author']) && $user->ID == $_GET['by_author']) {
                        echo 'class="active"';
                    }
                    ?> href="?<?php echo 'by_author=' . $user->ID . '&amp;filter_category=' . $filter_category . '&amp;filter_tag=' . $filter_tag; ?>"> <?php echo esc_attr($user->display_name); ?> </a>
                    <?php
                }
            }
            ?> 
                    </div>
                </nav>
            </div>
            <!--Sorting Navigation End-->
            <?php
        }
    }

endif;

//=====================================================================
// Get events tags list
//=====================================================================
if (!function_exists('cs_get_post_tags_list')) :

    function cs_get_post_tags_list($filter_category = '', $filter_tag = '', $author_filter = '') {
        global $post;
        $args = array('posts_per_page' => -1, 'post_type' => 'post', 'catgory' => $filter_category);
        $project_query = new WP_Query($args);
        while ($project_query->have_posts()) : $project_query->the_post();
            $posttags = get_the_terms($post->ID, 'post_tag');
            if ($posttags) {
                foreach ($posttags as $tag) {
                    $all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
                }
            }
        endwhile;
        if (is_array($all_tags_arr) && count($all_tags_arr) > 0):
            $tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
            foreach ($tags_arr as $tag):
                $active_class = '';
                $el = get_term_by('name', $tag, 'post_tag');
                $arr[] = '"tag-' . $el->slug . '"';
                if ($filter_tag == $el->slug) {
                    $active_class = "class='active'";
                }

                echo '<a href="?by_author=' . $author_filter . '&amp;filter_category=' . $filter_category . '&amp;filter-tag=' . $el->slug . '" id="taglink-tag-' . $el->slug . '" title="tag-' . $el->slug . '" ' . $active_class . ' >' . $el->name . '</a>';
            endforeach;
        endif;
    }

endif;

/* check user exist in wp */
if (!function_exists('cs_user_exists')) :

    function cs_user_exists($user_ID = '') {
        global $wpdb, $wp_query;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = '%d'", $user_ID));
        if ($count == 0) {
            $wp_query->set_404();
            // status_header( 404 );
            get_template_part(404);
            exit();
        }
    }

endif;


if (!function_exists('remove_menu_ids')) :

    function remove_menu_ids() {
        add_filter('nav_menu_item_id', '__return_null');
    }

    add_action('init', 'remove_menu_ids');
endif;


// Return Seleced
if (!function_exists('cs_selected')) :

    function cs_selected($current, $orignal) {
        if ($current == $orignal) {
            echo 'selected=selected';
        }
    }

endif;

// page builder element size
if (!function_exists('cs_pb_element_sizes')) :

    function cs_pb_element_sizes($size = '100') {
        $element_size = 'element-size-100';
        if (isset($size) && $size == '') {
            $element_size = 'element-size-100';
        } else {
            $element_size = 'element-size-' . $size;
        }
        return $element_size;
    }

endif;

// Wishlist Functions
// add to wishlist
if (!function_exists('cs_addto_usermeta')) :

    function cs_addto_usermeta() {
        $user = cs_get_user_id();
        if (isset($user) && $user <> '') {
            if (isset($_POST['post_id']) && $_POST['post_id'] <> '') {
                $cs_wishlist = array();
                $cs_wishlist = get_user_meta(cs_get_user_id(), 'cs-courses-wishlist', true);
                $cs_wishlist[] = $_POST['post_id'];
                $cs_wishlist = array_unique($cs_wishlist);
                //	cs_update_user_meta($cs_watchlist);
                update_user_meta(cs_get_user_id(), 'cs-courses-wishlist', $cs_wishlist);
                $user_watchlist = get_user_meta(cs_get_user_id(), 'cs-courses-wishlist', true);
                if (isset($_POST['type']) && $_POST['type'] == 'post') {
                    echo '<i class="fa fa-plus cs-bgcolr"></i>' . count($user_watchlist) . ' course(s) in Favourite';
                } else {
                    echo '<i class="fa fa-plus cs-bgcolr"></i>';
                }
            }
        } else {
            _e('You have to login first.', 'LMS');
        }
        die();
    }

endif;

add_action("wp_ajax_cs_addto_usermeta", "cs_addto_usermeta");
add_action("wp_ajax_nopriv_cs_addto_usermeta", "cs_addto_usermeta");

// get user meta
if (!function_exists('cs_get_user_meta')) :

    function cs_get_user_meta($user = "") {
        if (!empty($user)) {
            $userdata = get_user_by('login', $user);
            $user_id = $userdata->ID;
            return get_user_meta($user_id, 'cs-courses-wishlist', true);
        } else {
            return get_user_meta(cs_get_user_id(), 'cs-courses-wishlist', true);
        }
    }

endif;

// update user meta
if (!function_exists('cs_update_user_meta')) :

    function cs_update_user_meta($arr) {
        return update_user_meta(cs_get_user_id(), 'cs-courses-wishlist', $arr);
    }

endif;

// Delete From Wishlist
if (!function_exists('cs_delete_wishlist')) :

    function cs_delete_wishlist() {
        if (isset($_POST['post_id']) && $_POST['post_id'] <> '') {
            $cs_wishlist = cs_get_user_meta();
            $post_id = array();
            $post_id[] = $_POST['post_id'];
            $cs_wishlist = array_diff($cs_wishlist, $post_id);
            cs_update_user_meta($cs_wishlist);
            //_e('Removed From Wishlist','LMS');
            _e('Removed From Wishlist', 'LMS');
        } else {
            //_e('You are not authorised','LMS');
            _e('You are not authorised', 'LMS');
        }
        die();
    }

endif;
add_action("wp_ajax_cs_delete_wishlist", "cs_delete_wishlist");

// search media id with source
if (!function_exists('get_attachment_id_from_src')) :

    function get_attachment_id_from_src($image_src) {
        global $wpdb;
        //$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src' AND post_type='attachment'";
        //$wpdb->prefix."attachment
        $post_type = 'attachment';
        $id = $wpdb->get_var($wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE guid = %d AND post_type = %s", $image_src, $post_type));
        return $id;
    }

endif;


if (!function_exists('cs_videos_watch_list')) :

    function cs_videos_watch_list() {
        global $cs_theme_option, $post;
        $user = cs_get_user_id();
        if (isset($user) && $user <> '') {
            $cs_video_list = cs_get_user_metavalue('cs-video-watchlist');
            if (is_array($cs_video_list) && in_array(get_the_ID(), $cs_video_list)) {
                ?>
                <a class="cs-add cs-btnadd cs-btnpopover" data-container="body" data-toggle="tooltip" data-placement="top" 
                   title="<?php _e('Already in watch list', 'LMS'); ?>"><i class="fa fa-plus cs-bgcolr"></i></a>
                <?php
            } else {
                ?>
                <a class="cs-btnadd cs-btnpopover" onclick="cs_video_watchlist('<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>', '<?php echo esc_js($post->ID); ?>', '')" data-container="body" data-toggle="tooltip" data-placement="top" title="<?php _e('Add to watch list', 'LMS'); ?>"> <i class="fa fa-plus"></i> </a>
                <?php
            }
        } else {
            cs_login_message(false);
        }
    }

endif;

if (!function_exists('enable_more_buttons')) {

    function enable_more_buttons($buttons) {
        $buttons[] = 'fontselect';
        $buttons[] = 'fontsizeselect';
        $buttons[] = 'styleselect';
        $buttons[] = 'backcolor';
        $buttons[] = 'newdocument';
        $buttons[] = 'cut';
        $buttons[] = 'copy';
        $buttons[] = 'charmap';
        $buttons[] = 'hr';
        $buttons[] = 'visualaid';
        return $buttons;
    }

    add_filter("mce_buttons_3", "enable_more_buttons");
}
/* if ( ! function_exists( 'advanceTinyMCE' ) ) {	
  function advanceTinyMCE( $in ) {
  $in['wordpress_adv_hidden'] = FALSE;
  return $in;
  }
  add_filter( 'tiny_mce_before_init', 'advanceTinyMCE' );
  } */


//add_role( 'instructor', 'instructor', array( 'edit_posts' => true, ) );
/* $wp_roles->add_cap( 'instructor', 'courses' );
  $role->add_cap( 'courses' ); */


/* add_action( 'init', 'my_deregister_heartbeat', 1 );
  if ( ! function_exists( 'my_deregister_heartbeat' ) ) :
  function my_deregister_heartbeat() {
  global $pagenow;

  if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
  wp_deregister_script('heartbeat');
  }
  endif;
 */
// Get user profile picture 
if (!function_exists('cs_admin_user_profile_picture_ajax')) {

    function cs_admin_user_profile_picture_ajax() {
        $picture_class = $user_id = '';
        if (isset($_POST['picture_class']))
            $picture_class = $_POST['picture_class'];
        if (isset($_POST['user_id']))
            $user_id = $_POST['user_id'];

        $update_meta = update_user_meta($user_id, 'user_avatar_display', '');
        if ($update_meta) {
            echo get_avatar(get_the_author_meta('user_email', $user_id), apply_filters('PixFill_author_bio_avatar_size', 500));
        } else {
            echo 'error';
        }
        exit;
    }

    add_action('wp_ajax_cs_admin_user_profile_picture_ajax', 'cs_admin_user_profile_picture_ajax');
}
// Like Counter
if (!function_exists('cs_like_counter')) :

    function cs_like_counter($cs_likes_title = '') {
        $cs_like_counter = '';
        $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
        if (!isset($cs_like_counter) or empty($cs_like_counter))
            $cs_like_counter = 0;
        if (isset($_COOKIE["cs_like_counter" . get_the_id()])) {
            ?>
            <a> <i class="fa fa-heart liked-post"></i><span><?php echo intval($cs_like_counter) . ' ' . esc_attr($cs_likes_title); ?></span></a> 
        <?php } else { ?>
            <a class="likethis<?php echo get_the_id() ?> cs-btnheart cs-btnpopover" id="like_this<?php echo get_the_id() ?>"  href="javascript:cs_like_counter('<?php echo esc_js(esc_url(get_template_directory_uri())); ?>',<?php echo get_the_id() ?>,'<?php echo esc_js($cs_likes_title); ?>','<?php echo esc_js(admin_url('admin-ajax.php')); ?>')" data-container="body" data-toggle="tooltip" data-placement="top" title="<?php _e('Like This', 'LMS'); ?>"><i class="fa fa-heart-o"></i><span><?php echo esc_attr($cs_like_counter . ' ' . $cs_likes_title); ?></span></a>

            <a class="likes likethis" id="you_liked<?php echo get_the_id() ?>" style="display:none;"><i class="fa fa-heart  liked-post"></i><span class="count-numbers like_counter<?php echo get_the_id() ?>"><?php echo esc_attr($cs_like_counter . ' ' . $cs_likes_title); ?></span> </a>

            <div id="loading_div<?php echo get_the_id() ?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
            <?php
        }
    }

endif;

//likes counter
add_action('wp_ajax_nopriv_cs_likes_count', 'cs_likes_count');
add_action('wp_ajax_cs_likes_count', 'cs_likes_count');

// Post like counter
if (!function_exists('cs_likes_count')) :

    function cs_likes_count() {
        $cs_like_counter = get_post_meta($_POST['post_id'], "cs_like_counter", true);
        if (!isset($_COOKIE["cs_like_counter" . $_POST['post_id']])) {
            setcookie("cs_like_counter" . $_POST['post_id'], 'true', time() + (10 * 365 * 24 * 60 * 60), '/');
            update_post_meta($_POST['post_id'], 'cs_like_counter', $cs_like_counter + 1);
        }
        $cs_like_counter = get_post_meta($_POST['post_id'], "cs_like_counter", true);
        if (!isset($cs_like_counter) or empty($cs_like_counter))
            $cs_like_counter = 0;
        echo esc_attr($cs_like_counter);
        die();
    }

endif;

//Mailchimp
add_action('wp_ajax_nopriv_cs_mailchimp', 'cs_mailchimp');
add_action('wp_ajax_cs_mailchimp', 'cs_mailchimp');
if (!function_exists('cs_mailchimp')) :

    function cs_mailchimp() {

        global $cs_theme_options, $counter;
        $mailchimp_key = '';
        if (isset($cs_theme_options['cs_mailchimp_key'])) {
            $mailchimp_key = $cs_theme_options['cs_mailchimp_key'];
        }
        if (isset($_POST) and ! empty($_POST['cs_list_id']) and $mailchimp_key != '') {
            if ($mailchimp_key <> '') {
                $MailChimp = new MailChimp($mailchimp_key);
            }
            $email = $_POST['mc_email'];
            $list_id = $_POST['cs_list_id'];
            $result = $MailChimp->call('lists/subscribe', array(
                'id' => $list_id,
                'email' => array('email' => $email),
                'merge_vars' => array(),
                'double_optin' => false,
                'update_existing' => false,
                'replace_interests' => false,
                'send_welcome' => true,
            ));
            if ($result <> '') {
                if (isset($result['status']) and $result['status'] == 'error') {
                    echo balanceTags($result['error']);
                } else {
                    _e('subscribe successfully', 'LMS');
                }
            }
        } else {
            _e('please set API key', 'LMS');
        }
        die();
    }

endif;
// Add SoundCloud oEmbed

if (!function_exists('add_oembed_soundcloud')) :

    function add_oembed_soundcloud() {
        wp_oembed_add_provider('http://soundcloud.com/*', 'http://api.soundcloud.com/');
    }

endif;

//Mailchimp


/**
 * Add TinyMCE to multiple Textareas (usually in backend).
 */
if (!function_exists('cs_wp_editor')) :

    function cs_wp_editor($id = '') {
        ?>
        <script type="text/javascript">
            var fullId = "<?php echo esc_js($id); ?>";

            //tinymce.execCommand('mceAddEditor', false, fullId);
            // use wordpress settings
            tinymce.init({
                selector: fullId,
                theme: "modern",
                skin: "lightgray",
                language: "en",
                selector:"#" + fullId,
                        resize: "vertical",
                menubar: false,
                wpautop: true,
                indent: false,
                quicktags: "em,strong,link",
                toolbar1: "bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink",
                //toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
                tabfocus_elements: ":prev,:next",
                body_class: "id post-type-post post-status-publish post-format-standard",
            });

            //quicktags({id : fullId});
            settings = {
                id: fullId,
                // buttons: 'strong,em,link' 
            }

            quicktags(settings);
            //init tinymce
            //tinymce.init(tinyMCEPreInit.mceInit[fullId]);

            //quicktags({id : fullId});
            /*tinymce.execCommand('mceRemoveEditor', true, fullId);
             var init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ fullId ] );
             try { tinymce.init( init ); } catch(e){}
                     
             tinymce.execCommand( 'mceRemoveEditor', false, fullId );
             tinymce.execCommand( 'mceAddEditor', false, fullId );
                     
             quicktags({id : fullId});*/
        </script><?php
    }

endif;

add_action('wp_ajax_cs_select_editor', 'cs_wp_editor');

//add extra fields to cousres categories
add_action('course-category_edit_form_fields', 'edit_extra_category_fields');
add_action('course-category_add_form_fields', 'extra_category_fields');

// Add Category Fields
if (!function_exists('extra_category_fields')) :

    function extra_category_fields($tag) {    //check for existing featured ID
        if (isset($tag->term_id)) {
            $t_id = $tag->term_id;
        } else {
            $t_id = "";
        }
        ?>

        <div class="form-field">
        <?php $box_name = 'course_cat_icon'; ?>
            <ul class="form-elements" id="cs_infobox_<?php echo esc_attr($box_name); ?>">
                <li class="to-field">
                    <input type="hidden" class="cs-search-icon-hidden" name="course_cat_icon" >

            <?php cs_fontawsome_icons_box_courses('', $box_name); ?>
                </li>
            </ul>

            <p>Icon for Course Category</p>
        </div>
        <input type="hidden" name="course_cat_meta" value="1" />
                        <?php
                    }

                endif;

// Edit Category Fields
                if (!function_exists('edit_extra_category_fields')) :

                    function edit_extra_category_fields($tag) {    //check for existing featured ID
                        if (isset($tag->term_id)) {
                            $t_id = $tag->term_id;
                        } else {
                            $t_id = "";
                        }
                        $cat_meta = get_option("course_cat_$t_id");
                        $cat_icon = $cat_meta['icon'];
                        ?>
        <tr>
        <?php $box_name = 'course_cat_icon'; ?>
            <th><label for="cat_f_icon_url"><?php _e('Choose Icon', 'LMS'); ?></label></th>
            <td>
                <ul class="form-elements" id="cs_infobox_<?php echo esc_attr($box_name); ?>">
                    <li class="to-field">
                        <input type="hidden" class="cs-search-icon-hidden" name="course_cat_icon" value="<?php echo esc_attr($cat_icon); ?>">

        <?php cs_fontawsome_icons_box_courses($cat_icon, $box_name); ?>
                    </li>
                </ul>

                <p>Icon for Course Category</p>
            </td>
        </tr>
        <input type="hidden" name="course_cat_meta" value="1" />
        <?php
    }

endif;

// save cousres categories extra fields hook
add_action('create_course-category', 'save_extra_category_fileds');
add_action('edited_course-category', 'save_extra_category_fileds');

// save extra category extra fields callback function
if (!function_exists('save_extra_category_fileds')) :

    function save_extra_category_fileds($term_id) {
        if (isset($_POST['course_cat_meta']) and $_POST['course_cat_meta'] == '1') {
            $t_id = $term_id;
            get_option("course_cat_$t_id");
            $course_cat_icon = '';
            if (isset($_POST['course_cat_icon'])) {
                $course_cat_icon = $_POST['course_cat_icon'];
            }
            $cat_meta = array(
                'icon' => $course_cat_icon,
            );
            //save the option array
            update_option("course_cat_$t_id", $cat_meta);
        }
    }

endif;

//Submit Form
add_action('wp_ajax_nopriv_cs_contact_form_submit', 'cs_contact_form_submit');
add_action('wp_ajax_cs_contact_form_submit', 'cs_contact_form_submit');

//Get attachment id
if (!function_exists('cs_get_attachment_id_from_url')) :

    function cs_get_attachment_id_from_url($attachment_url = '') {
        global $wpdb;
        $attachment_id = false;
        // If there is no url, return.
        if ('' == $attachment_url)
            return;
        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();
        if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);
            $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
        }
        return $attachment_id;
    }

endif;

// Custom File types allowed
add_filter('upload_mimes', 'custom_upload_mimes');

if (!function_exists('custom_upload_mimes')) :

    function custom_upload_mimes($existing_mimes = array()) {
        // add the file extension to the array
        $existing_mimes['woff'] = 'mime/type';
        $existing_mimes['ttf'] = 'mime/type';
        $existing_mimes['svg'] = 'mime/type';
        $existing_mimes['eot'] = 'mime/type';
        return $existing_mimes;
    }

endif;

// Contact form submit ajax
if (!function_exists('cs_contact_form_submit')) :

    function cs_contact_form_submit() {
        define('WP_USE_THEMES', false);
        $subject = '';
        $cs_contact_error_msg = '';
        $cs_contact_email = '';
        $subject_name = 'Subject';
        foreach ($_REQUEST as $keys => $values) {
            $$keys = esc_attr($values);
        }
        if (isset($phone) && $phone <> '') {
            $subject_name = 'Phone';
            $subject = $phone;
        }
        $bloginfo = get_bloginfo();
        $subjecteEmail = "(" . $bloginfo . ") Contact Form Received";
        $message = '
				<table width="100%" border="1">
				  <tr>
					<td width="100"><strong>' . __('Name', 'LMS') . '</strong></td>
					<td>' . esc_attr($contact_name) . '</td>
				  </tr>
				  <tr>
					<td><strong>' . __('Email', 'LMS') . '</strong></td>
					<td>' . sanitize_email($contact_email) . '</td>
				  </tr>
				  <tr>
					<td><strong>' . $subject_name . ':</strong></td>
					<td>' . esc_attr($subject) . '</td>
				  </tr>
				  <tr>
					<td><strong>' . __('Message', 'LMS') . '</strong></td>
					<td>' . balanceTags($contact_msg, true) . '</td>
				  </tr>
				  <tr>
					<td><strong>' . __('IP Address', 'LMS') . '</strong></td>
					<td>' . $_SERVER["REMOTE_ADDR"] . '</td>
				  </tr>
				</table>';
        $headers = "From: " . esc_attr($contact_name) . "\r\n";
        $headers .= "Reply-To: " . sanitize_email($contact_email) . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $attachments = '';

        if (wp_mail(sanitize_email($cs_contact_email), $subjecteEmail, $message, $headers, $attachments)) {
            $json = array();
            $json['type'] = "success";
            $json['message'] = '<p>' . cs_textarea_filter($cs_contact_succ_msg) . '</p>';
        } else {
            $json['type'] = "error";
            $json['message'] = '<p>' . cs_textarea_filter($cs_contact_error_msg) . '</p>';
        };

        echo json_encode($json);
        die();
    }

endif;

if (!function_exists('process_demo_login')) :

    function process_demo_login() {
        if (!is_user_logged_in()) {
            $user = wp_authenticate('lms-admin', 'admin123');
            $secure_cookie = '';
            wp_set_auth_cookie($user->ID, true, $secure_cookie);
            //do_action('wp_login', 'lms-admin');
            wp_redirect(get_home_url());
        }
    }

endif;
// get header position settings
if (!function_exists('cs_header_position_settings')) :

    function cs_header_position_settings() {
        global $cs_xmlObject, $cs_theme_options;
        // header setting start
        if (is_page() || is_single()) {
            $header_bg_options = (isset($cs_xmlObject) and $cs_xmlObject->header_bg_options <> '') ? $cs_xmlObject->header_bg_options : '';
            $cs_rev_slider_id = (isset($cs_xmlObject) and $cs_xmlObject->cs_rev_slider_id <> '') ? $cs_xmlObject->cs_rev_slider_id : '';
            $cs_header_bg_image = (isset($cs_xmlObject) and $cs_xmlObject->cs_headerbg_image <> '') ? $cs_xmlObject->cs_headerbg_image : '';
            $cs_header_bg_color = (isset($cs_xmlObject) and $cs_xmlObject->cs_headerbg_color <> '') ? $cs_xmlObject->cs_headerbg_color : '';
        } else {
            $header_bg_options = (isset($cs_theme_options['cs_headerbg_options']) and $cs_theme_options['cs_headerbg_options'] <> '') ? $cs_theme_options['cs_headerbg_options'] : '';
            $cs_rev_slider_id = (isset($cs_theme_options['cs_headerbg_slider']) and $cs_theme_options['cs_headerbg_slider'] <> '') ? $cs_theme_options['cs_headerbg_slider'] : '';
            $cs_header_bg_image = (isset($cs_theme_options['cs_headerbg_image']) and $cs_theme_options['cs_headerbg_image'] <> '') ? $cs_theme_options['cs_headerbg_image'] : '';
            $cs_header_bg_color = (isset($cs_theme_options['cs_headerbg_color']) and $cs_theme_options['cs_headerbg_color'] <> '') ? $cs_theme_options['cs_headerbg_color'] : '';
        }
        // header setting end
        if ($cs_theme_options['cs_header_position'] == 'absolute' and ( isset($header_bg_options) and $header_bg_options <> '' and $header_bg_options != 'none')) {
            ?>
            <div class="extra">
            <?php if ($header_bg_options == 'cs_bg_image_color') { ?>
                    <style scoped="scoped">
                        #main-header{
                            background-image:url('<?php echo esc_url($cs_header_bg_image); ?>');
                            background-color:<?php echo esc_attr($cs_header_bg_color); ?>;
                            min-height:250px;
                        }
                    </style>
                <?php
            } elseif ($header_bg_options == 'cs_rev_slider') {
                echo do_shortcode('[rev_slider ' . $cs_rev_slider_id . ']');
            }
            ?>
            </div>
            <?php
        }
    }

endif;
/*
 * RevSlider Extend Class 
 */
if (class_exists('RevSlider')) {

    class cs_RevSlider extends RevSlider {

        // Get sliders alias, Title, ID
        public function getAllSliderAliases() {
            $where = "";
            $response = $this->db->fetch(GlobalsRevSlider::$table_sliders, $where, "id");
            $arrAliases = array();
            $slider_array = array();
            foreach ($response as $arrSlider) {
                $arrAliases['id'] = $arrSlider["id"];
                $arrAliases['title'] = $arrSlider["title"];
                $arrAliases['alias'] = $arrSlider["alias"];
                $slider_array[] = $arrAliases;
            }
            return($slider_array);
        }

    }

}