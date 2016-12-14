<?php
/**
 * The template for displaying header
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
global $options, $cs_theme_options, $cs_position, $cs_page_builder, $cs_meta_page, $cs_node, $cs_xmlObject, $options, $page_option, $post, $page_colors;
$slider_position = '';
$header_style = '';
$global_var_set = 0;
if (is_page()) {
    $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
    $cs_xmlData = new stdClass();
    if (isset($cs_page_bulider) && $cs_page_bulider <> '') {
        $cs_xmlData = new SimpleXMLElement($cs_page_bulider);
        $slider_position = (!empty($cs_xmlData->slider_position)) ? $cs_xmlData->slider_position : '';
        $header_style = (!empty($cs_xmlData->header_banner_style)) ? $cs_xmlData->header_banner_style : '';
    }
    $cs_page_options = (!empty($cs_xmlData->cs_page_options)) ? $cs_xmlData->cs_page_options : '';
    if (isset($cs_page_options) and $cs_page_options != 'default' and $cs_page_options <> '') {
        $cs_page_options = trim($cs_page_options);
        $settings = $page_option['theme_options'][$cs_page_options]['theme_option'];
        $page_setting = json_decode($settings, true);
        $cs_theme_options = $page_setting;
        $global_var_set = 1;
    }
}
// assign un assigned variables with empty string again
include (get_template_directory() . '/include/theme-components/theme_gobal.php');
/* theme unit testing code start */
if (!get_option('cs_theme_options')) {
    $activation_data = theme_default_options();
    $cs_theme_options = $activation_data;
    $cs_theme_options['cs_default_layout_sidebar'] = 'sidebar-1';
    $cs_theme_options['cs_footer_widget'] = 'off';
}
/* theme unit testing code end */
$cs_builtin_seo_fields = $cs_theme_options['cs_builtin_seo_fields'];

if (isset($cs_theme_options['cs_layout'])) {
    $cs_site_layout = $cs_theme_options['cs_layout'];
} else {
    $cs_site_layout == '';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">

        <?php cs_page_metakey(); ?>


        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php
        if (isset($cs_theme_options['cs_custom_css']) and $cs_theme_options['cs_custom_css'] <> '') {
            echo '<style type="text/css" scoped>
				' . $cs_theme_options['cs_custom_css'] . '
			</style> ';
        }
        if (isset($cs_theme_options['cs_custom_js']) and $cs_theme_options['cs_custom_js'] <> '') {
            echo '<script type="text/javascript">
   			' . $cs_theme_options['cs_custom_js'] . '
		</script> ';
        }
        if (function_exists('cs_header_settings')) {
            cs_header_settings();
        }
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');
        //=====================================================================
        // Header Colors
        //=====================================================================
        if (function_exists('cs_header_color')) {
            cs_header_color();
        }

        //=====================================================================
        // Theme Colors
        //=====================================================================
        if (function_exists('cs_footer_color')) {
            cs_footer_color();
        }
        if (function_exists('cs_theme_colors')) {
            cs_theme_colors();
        }
        wp_head();
        ?>
    </head>

    <body <?php
    body_class();
    if ($cs_site_layout != 'full_width') {
        if (function_exists('cs_bg_image')) {
            echo cs_bg_image();
        }
    }
    ?>>
            <?php
            if (function_exists('cs_under_construction')) {
                cs_under_construction();
            }
            ?>
        <!-- Wrapper Start -->
        <div class="wrapper <?php
        if (function_exists('cs_header_postion_class')) {
            echo cs_header_postion_class();
        }
        ?> wrapper_<?php
             if (function_exists('cs_wrapper_class')) {
                 cs_wrapper_class();
             }
             ?>">
            <!-- Header Start -->
            <?php
            if ($header_style == 'custom_slider' && $slider_position == 'above') {
                if (isset($_REQUEST['course_id']) && $_REQUEST['course_id'] != '') {
                    if (function_exists('cs_subheader_style')) {
                        cs_subheader_style($_REQUEST['course_id']);
                    }
                } else {
                    if (function_exists('cs_subheader_style')) {
                        cs_subheader_style();
                    }
                }
                if (function_exists('cs_get_headers')) {
                    cs_get_headers();
                }
                if (isset($cs_theme_options['cs_smooth_scroll']) and $cs_theme_options['cs_smooth_scroll'] == 'on') {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            cs_nicescroll();
                        });
                    </script>
                    <?php
                }

                if (isset($cs_theme_options['cs_sitcky_header_switch']) and $cs_theme_options['cs_sitcky_header_switch'] == "on") {
                    cs_scrolltofix();
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('.main-head').scrollToFixed();
                        });
                    </script>
                <?php } ?>
                <div class="clear"></div>
                <?php
            } else {
                if (function_exists('cs_get_headers')) {
                    cs_get_headers();
                }
                if (isset($cs_theme_options['cs_smooth_scroll']) and $cs_theme_options['cs_smooth_scroll'] == 'on') {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            cs_nicescroll();
                        });
                    </script>
                    <?php
                }
                if (isset($cs_theme_options['cs_sitcky_header_switch']) and $cs_theme_options['cs_sitcky_header_switch'] == "on") {
                    cs_scrolltofix();
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('.main-head').scrollToFixed();
                        });
                    </script>
                    <?php
                }
                ?>
                <div class="clear"></div>
                <?php
                cs_header_position_settings();
                ?>
                <!-- Breadcrumb SecTion -->
                <?php
                if (isset($_REQUEST['course_id']) && $_REQUEST['course_id'] != '') {
                    if (function_exists('cs_subheader_style')) {
                        cs_subheader_style($_REQUEST['course_id']);
                    }
                } else {
                    if (function_exists('cs_subheader_style')) {
                        cs_subheader_style();
                    }
                }
            }
            ?>
            <!-- Breadcrumb SecTion -->
            <!-- Main Content Section -->
            <main id="main-content">
                <?php
                if (is_single() && $post_type == 'courses') {
                    if (empty($cs_xmlObject->dynamic_post_course_view))
                        $dynamic_post_course_view = "";
                    else
                        $dynamic_post_course_view = $cs_xmlObject->dynamic_post_course_view;
                    if (empty($cs_xmlObject->course_subheader_bg_color))
                        $course_subheader_bg_color = "";
                    else
                        $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;

                    $bgcolor_style = '';
                    if ($course_subheader_bg_color <> '') {
                        $bgcolor_style = 'background-color: ' . $course_subheader_bg_color . ';';
                    }
                    if ($dynamic_post_course_view == 'Wide') {
                        $width = 200;
                        $height = 150;
                        $image_url = cs_get_post_img_src($post->ID, $width, $height);
                        if ($cs_xmlObject->course_short_description <> '' || $cs_xmlObject->course_tags_show == 'on' || $image_url <> '') {

                            if (function_exists('cs_course_shortdescription_area')) {
                                ?>
                                <section class="page-section <?php echo esc_attr($dynamic_post_course_view); ?>" style=" padding: 0; <?php echo esc_attr($bgcolor_style); ?> ">
                                    <!-- Container -->
                                    <div class="container">
                                        <!-- Row -->
                                        <div class="row">
                                            <!-- Col Start -->
                                            <div class="col-md-12">
                                                <!-- Row -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        if (function_exists('cs_course_shortdescription_area')) {
                                                            cs_course_shortdescription_area();
                                                        }
                                                        ?>
                                                    </div>
                                                    <!-- Col Start -->
                                                </div>
                                                <!-- Row -->
                                            </div>
                                            <!-- Col End -->
                                        </div>
                                        <!-- Row -->
                                    </div>
                                    <!-- Container -->
                                </section>

                                <?php
                            }
                        }
                    }
                }
                ?>
                <!-- Main Section Start -->
                <div class="main-section">