<?php
/**
 * File Type: Loops Shortcode Function
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
//======================================================================
// Adding Clients Start
//======================================================================

if (!function_exists('cs_clients_shortcode')) {

    function cs_clients_shortcode($atts, $content = "") {
        global $cs_clients_view, $cs_client_border, $cs_client_gray;
        $defaults = array('column_size' => '', 'cs_clients_view' => '', 'cs_client_gray' => '', 'cs_client_border' => '', 'cs_client_section_title' => '', 'cs_client_class' => '', 'cs_client_animation' => '', 'cs_custom_animation_duration' => '1');
        extract(shortcode_atts($defaults, $atts));

        $CustomId = '';
        if (isset($cs_client_class) && $cs_client_class) {
            $CustomId = 'id="' . $cs_client_class . '"';
        }

        if (trim($cs_client_animation) != '') {
            $cs_client_animation = 'wow' . ' ' . $cs_client_animation;
        } else {
            $cs_client_animation = '';
        }

        $column_class = cs_custom_column_class($column_size);
        $cs_client_border = $cs_client_border == 'yes' ? 'has_border' : 'no-clients-border';
        $owlcount = rand(40, 9999999);
        $section_title = '';
        if (isset($cs_client_section_title) && trim($cs_client_section_title) <> '') {
            $section_title = '<div class="cs-section-title"><h2>' . $cs_client_section_title . '</h2></div>';
        }
        $html = '';
        $html .= '<div ' . $CustomId . ' class="' . $column_class . ' ' . $cs_client_animation . ' ' . $cs_client_class . '">';
        $html .= $section_title;
        if ($cs_clients_view == 'grid') {
            $html .= '<div class="cs-partner ' . $cs_client_border . '">';
            $html .= '<ul class="row">';
            $html .= do_shortcode($content);
            $html .= '</ul>';
            $html .= '</div>';
        } else {
            cs_owl_carousel();
            ?>
            <script>
                jQuery(document).ready(function ($) {
                    $("#owl-demo-three-<?php echo esc_js($owlcount); ?>").owlCarousel({
                        nav: true,
                        margin: 30,
                        navText: [
                            "<i class='fa fa-angle-left'></i>",
                            "<i class='fa fa-angle-right'></i>"
                        ],
                        responsive: {
                            0: {
                                items: 1 // In this configuration 1 is enabled from 0px up to 479px screen size 
                            },
                            480: {
                                items: 1, // from 480 to 677 
                                nav: false // from 480 to max 
                            },
                            678: {
                                items: 2, // from this breakpoint 678 to 959
                                center: false // only within 678 and next - 959
                            },
                            960: {
                                items: 3, // from this breakpoint 960 to 1199
                                center: false,
                                loop: false

                            },
                            1200: {
                                items: 6
                            }
                        }
                    });
                });
            </script>
            <?php
            $html .= '<div class="cs-partner partnerslide ' . $cs_client_border . '">';
            $html .= '<ul class="row owl-carousel nxt-prv-v2 cs-theme-carousel " id="owl-demo-three-' . $owlcount . '">';
            $html .= do_shortcode($content);
            $html .= '</ul>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    add_shortcode('cs_clients', 'cs_clients_shortcode');
}

//======================================================================
// Adding Clients Logo Start
//======================================================================
if (!function_exists('cs_clients_item_shortcode')) {

    function cs_clients_item_shortcode($atts, $content = "") {
        global $cs_clients_view, $cs_client_border, $cs_client_gray;
        $defaults = array('cs_bg_color' => '', 'cs_website_url' => '', 'cs_client_title' => '', 'cs_client_logo' => '');
        extract(shortcode_atts($defaults, $atts));

        $html = '';
        $grayScale = '';

        if (isset($cs_client_gray) && $cs_client_gray == 'yes') {
            $grayScale = 'grayscale';
        }

        $tooltip = '';

        if (isset($cs_client_title) && $cs_client_title != '') {
            $tooltip = 'title="' . $cs_client_title . '"';
        }

        $cs_url = $cs_website_url ? $cs_website_url : 'javascript:;';
        if ($cs_clients_view == 'grid') {
            if (isset($cs_client_logo) && !empty($cs_client_logo)) {

                $html .= '<li class="col-md-2"  style="background-color:' . $cs_bg_color . '"><figure><a ' . $tooltip . ' href="' . $cs_url . '"><img class="' . $grayScale . '" src="' . $cs_client_logo . '" alt="" ></a></figure></li>';
            }
        } else {
            if (isset($cs_client_logo) && !empty($cs_client_logo)) {
                $html .= '<li class="item" style="background-color:' . $cs_bg_color . '"><figure><a href="' . $cs_url . '" ' . $tooltip . '><img class="' . $grayScale . '" src="' . $cs_client_logo . '" alt=""></a></figure></li>';
            }
        }
        return $html;
    }

    add_shortcode('clients_item', 'cs_clients_item_shortcode');
}
// Adding Clients Logo End
//======================================================================
// Adding Content Slider ( Custom Posts ) Start 
//======================================================================
if (!function_exists('cs_contentslider_shortcode')) {

    function cs_contentslider_shortcode($atts) {
        global $post, $wpdb;
        $defaults = array('column_size' => '1/1', 'cs_contentslider_title' => '', 'cs_contentslider_dcpt_cat' => '', 'cs_contentslider_orderby' => 'DESC', 'orderby' => 'ID', 'cs_contentslider_description' => 'yes', 'cs_contentslider_excerpt' => '255', 'cs_contentslider_num_post' => '10', 'cs_contentslider_class' => '', 'cs_contentslider_animation' => '', 'cs_custom_animation_duration' => '');
        extract(shortcode_atts($defaults, $atts));

        $CustomId = '';
        if (isset($cs_contentslider_class) && $cs_contentslider_class) {
            $CustomId = 'id="' . $cs_contentslider_class . '"';
        }

        if (trim($cs_contentslider_animation) != '') {
            $cs_custom_animation = 'wow' . ' ' . $cs_contentslider_animation;
        } else {
            $cs_custom_animation = '';
        }

        $column_class = cs_custom_column_class($column_size);
        $owlcount = rand(40, 9999999);
        ob_start();

        $width = 860;
        $height = 418;

        //==Get Post Type	
        $args_all = array('posts_per_page' => "$cs_contentslider_num_post", 'post_type' => 'post', 'order' => $cs_contentslider_orderby, 'orderby' => $orderby, 'post_status' => 'publish');

        if (isset($cs_dcpt_cat) && $cs_dcpt_cat <> '' && $cs_dcpt_cat <> '0') {
            $blog_category_array = array('category_name' => "$cs_dcpt_cat");
            $args_all = array_merge($args_all, $blog_category_array);
        }
        if (isset($cs_contentslider_title) && $cs_contentslider_title <> '') {
            echo '<div class="' . cs_allow_special_char($column_class) . '"><div class="cs-section-title"><h2>' . cs_allow_special_char($cs_contentslider_title) . '</h2></div></div>';
        }
        ?>
        <div <?php echo cs_allow_special_char($CustomId); ?> class="col-md-12 <?php echo cs_allow_special_char($cs_contentslider_animation . ' ' . $cs_contentslider_class); ?>" style="animation-duration:<?php echo cs_allow_special_char($cs_custom_animation_duration); ?>s">
            <?php
            $query = new WP_Query($args_all);
            $post_count = $query->post_count;
            cs_owl_carousel();
            if ($query->have_posts()) {
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#owl-contents-slider-<?php echo esc_js($owlcount); ?>').owlCarousel({
                            loop: true,
                            nav: true,
                            autoplay: true,
                            margin: 15,
                            navText: [
                                "<i class='fa fa-angle-left'></i>",
                                "<i class='fa fa-angle-right'></i>"
                            ],
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 1
                                },
                                1000: {
                                    items: 1
                                }
                            }
                        });
                    });
                </script>
                <div id="syncsliders">
                    <div  class="owl-carousel content-slider" id="owl-contents-slider-<?php echo esc_attr($owlcount); ?>">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <?php $image_url = cs_attachment_image_src(get_post_thumbnail_id((int) get_the_id()), $width, $height); ?>
                            <div class="item">
                                <figure><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>" alt=""></a>
                <?php if ($cs_contentslider_description == 'yes') { ?>  
                                        <figcaption>
                                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <p><?php echo cs_get_the_excerpt((int) $cs_contentslider_excerpt, false, ''); ?>  </p>
                                        </figcaption>
                            <?php } ?>
                                </figure>  
                            </div>               
                <?php endwhile;
                wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php
            }
            $post_data = ob_get_clean();
            return $post_data;
        }

        add_shortcode('cs_contentslider', 'cs_contentslider_shortcode');
    }
//  Adding Content Slider ( Custom Posts ) End 
//======================================================================
// Adding Blog Posts Start
//======================================================================
    if (!function_exists('cs_blog_shortcode')) {

        function cs_blog_shortcode($atts) {
            global $post, $wpdb, $cs_theme_options, $cs_counter_node;
            $defaults = array('column_size' => '', 'cs_blog_section_title' => '', 'cs_blog_view' => '', 'cs_blog_cat' => '', 'cs_blog_orderby' => 'DESC', 'orderby' => 'ID', 'cs_blog_description' => 'yes', 'cs_blog_excerpt' => '255', 'cs_blog_filterable' => '', 'cs_blog_num_post' => '10', 'blog_pagination' => '', 'cs_blog_class' => '', 'cs_blog_animation' => '', 'cs_custom_animation_duration' => '');
            extract(shortcode_atts($defaults, $atts));

            $CustomId = '';
            if (isset($cs_blog_class) && $cs_blog_class) {
                $CustomId = 'id="' . $cs_blog_class . '"';
            }

            if (trim($cs_blog_animation) != '') {
                $cs_custom_animation = 'wow' . ' ' . $cs_blog_animation;
            } else {
                $cs_custom_animation = '';
            }
            $owlcount = rand(40, 9999999);
            $cs_counter_node++;
            ob_start();

            //==Filters
            $filter_category = '';
            $filter_tag = '';
            $author_filter = '';

            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from " . $wpdb->prefix . "terms WHERE slug = %s", $cs_blog_cat));

            if (isset($_GET['filter_category']) && $_GET['filter_category'] <> '' && $_GET['filter_category'] <> '0') {
                $filter_category = $_GET['filter_category'];
                $filter_category_array = $_GET['filter_category'];
                $catname = '';
                $contcat = ',';
                foreach ($filter_category_array as $cat_name) {
                    $catname .= $cat_name . ',';
                }
                $filter_category = rtrim($catname, ',');
            } else {
                if (isset($row_cat->slug)) {
                    $filter_category = $row_cat->slug;
                }
            }
            //==Filters End
            //==Sorting

            if (isset($_GET['sort']) and $_GET['sort'] == 'asc') {
                $order = 'ASC';
            } else {
                $order = $cs_blog_orderby;
            }

            if (isset($_GET['sort']) and $_GET['sort'] == 'alphabetical') {
                $orderby = 'title';
                $order = $cs_blog_orderby;
            } else {
                $orderby = 'meta_value';
            }

            //==Sorting End 

            if (empty($_GET['page_id_all']))
                $_GET['page_id_all'] = 1;

            $cs_blog_num_post = $cs_blog_num_post ? $cs_blog_num_post : '-1';

            $args = array('posts_per_page' => "-1", 'post_type' => 'post', 'order' => $cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);


            if (isset($cs_blog_cat) && $cs_blog_cat <> '' && $cs_blog_cat <> '0') {
                $blog_category_array = array('category_name' => "$cs_blog_cat");
                $args = array_merge($args, $blog_category_array);
            }
            if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {

                if (isset($_GET['filter-tag'])) {
                    $filter_tag = $_GET['filter-tag'];
                }
                if ($filter_tag <> '') {
                    $blog_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                } else {
                    $blog_category_array = array('category_name' => "$filter_category");
                }
                $args = array_merge($args, $blog_category_array);
            }

            if (isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0') {
                $filter_tag = $_GET['filter-tag'];
                if ($filter_tag <> '') {
                    $course_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                    $args = array_merge($args, $course_category_array);
                }
            }
            if (isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0') {
                $author_filter = $_GET['by_author'];
                if ($author_filter <> '') {
                    $authorArray = array('author' => "$author_filter");
                    $args = array_merge($args, $authorArray);
                }
            }


            $query = new WP_Query($args);
            $post_count = cs_query_total_posts('post');
            $count_post = $query->post_count;

            $cs_blog_num_post = $cs_blog_num_post ? $cs_blog_num_post : '-1';
            $args = array('posts_per_page' => "$cs_blog_num_post", 'post_type' => 'post', 'paged' => $_GET['page_id_all'], 'order' => $cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);

            if (isset($cs_blog_cat) && $cs_blog_cat <> '' && $cs_blog_cat <> '0') {
                $blog_category_array = array('category_name' => "$cs_blog_cat");
                $args = array_merge($args, $blog_category_array);
            }

            if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {

                if (isset($_GET['filter-tag'])) {
                    $filter_tag = $_GET['filter-tag'];
                }
                if ($filter_tag <> '') {
                    $blog_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                } else {
                    $blog_category_array = array('category_name' => "$filter_category");
                }
                $args = array_merge($args, $blog_category_array);
            }

            if (isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0') {
                $filter_tag = $_GET['filter-tag'];
                if ($filter_tag <> '') {
                    $course_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                    $args = array_merge($args, $course_category_array);
                }
            }
            if (isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0') {
                $author_filter = $_GET['by_author'];
                if ($author_filter <> '') {
                    $authorArray = array('author' => "$author_filter");
                    $args = array_merge($args, $authorArray);
                }
            }

            if ($cs_blog_cat != '' && $cs_blog_cat != '0') {

                $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from " . $wpdb->prefix . "terms WHERE  slug =%s", $cs_blog_cat));
            }
            //==Blog View

            $title_limit = '';
            $width = '';
            $height = '';
            $blog_boxed = '';
            $no_image = '';
            $masonary_row = '';
            $masonary_class = '';
            $thumbnail = '';
            $post_thumb_view = '';

            $column_class_name = 'col-md-12';
            if ($cs_blog_view == 'default') {
                $blogViewClass = 'blog-lrg';
                $column_class_name = 'col-md-12';
                $width = '860';
                $height = '418';
                $title_limit = 1000;
            } else if ($cs_blog_view == 'small') {
                $blogViewClass = 'blog-medium blog-small';
                $column_class_name = 'col-md-12';
                $width = '370';
                $height = '278';
                $title_limit = 40;
            } else if ($cs_blog_view == 'clean') {
                $blogViewClass = 'blog-clean';
                $column_class_name = 'col-md-12';
                $width = '374';
                $height = '210';
                $title_limit = 60;
            } else if ($cs_blog_view == 'medium') {
                $blogViewClass = 'blog-medium lg-thumb';
                $column_class_name = 'col-md-12';
                $width = '300';
                $height = '300';
                $masonary_row = 'cs-blog-medium';
                $title_limit = 32;
            } else if ($cs_blog_view == 'grid') {
                $blogViewClass = 'blog-grid';
                $masonary_class = 'blogmasnery';
                $column_class_name = ' col-md-4';
                $width = '374';
                $height = '210';
                $title_limit = 40;
            } else if ($cs_blog_view == 'masonry') {
                $blogViewClass = '';
                $masonary_class = 'blogmasnery';
                $masonary_row = 'mas-isotope';
                $column_class_name = 'item col-md-4';
                echo '<script>
						jQuery(document).ready(function($){
							cs_masonary_js();
						});	
				</script>';
                $width = '374';
                $height = '210';
                $title_limit = 40;
            } else if ($cs_blog_view == 'boxed') {
                $blogViewClass = 'blog-lrg';
                $column_class_name = ' col-md-4';
                $width = '370';
                $height = '278';
                $blog_boxed = 'blog_thumb';
                $title_limit = 40;
            } else if ($cs_blog_view == 'timeline') {
                $blogViewClass = 'has_bullet_br blog-medium';
                $column_class_name = ' col-md-12';
                $width = '272';
                $height = '186';
                $title_limit = 40;
            }
            $section_title = '';

            $cs_likes_title = __('Likes', 'LMS');

            if (isset($cs_blog_section_title) && trim($cs_blog_section_title) <> '') {
                $section_title = '<div class="cs-section-title col-md-12"><h2>' . $cs_blog_section_title . '</h2></div>';
            }
            cs_get_blog_filters($cs_blog_cat, $author_filter, $filter_category, $filter_tag, $cs_blog_filterable, $cs_blog_animation);
            $query = new WP_Query($args);
            $post_count = $query->post_count;
            if ($query->have_posts()) {
                $postCounter = 0;
                ?>
                <?php
                if ($cs_blog_view == 'masonry' || $cs_blog_view == 'grid') {
                    cs_isotope_enqueue();
                };
                echo cs_allow_special_char($section_title);

                while ($query->have_posts()) : $query->the_post();
                    $postCounter++;
                    if ($postCounter % 2 === 0) {
                        $numClass = 'odd';
                    } else {
                        $numClass = 'even';
                    }
                    $lastChild = '';
                    if ($post_count == $postCounter) {
                        $lastChild = 'cs-last';
                    }
                    ?>
                    <div <?php echo esc_attr($CustomId); ?> class="<?php echo esc_attr($column_class_name); ?>">
                        <!-- Article -->
                                <?php
                                $thumbnail = cs_get_post_img_src((int) $post->ID, $width, $height);

//echo $thumbnail ;
                                ?>
                <?php if ($cs_blog_view == 'boxed') { ?>
                            <article class="cs-blog item <?php echo cs_allow_special_char($blog_boxed . ' ' . $no_image . ' ' . $numClass . ' ' . $cs_blog_animation . ' ' . $cs_blog_class . ' ' . $masonary_class); ?>">
                <?php } else { ?>
                                <article class="cs-blog <?php echo cs_allow_special_char($blogViewClass . ' ' . $no_image . ' ' . $cs_blog_animation . ' ' . $cs_blog_class . ' ' . $masonary_class . ' ' . $lastChild); ?>">
                                <?php } ?>
                                <?php if ($cs_blog_view == 'timeline') { ?>
                                    <!-- Bullet Crl -->
                                    <div class="bullet-crl">
                                        <span class="fa-stack fa-lg">
                                            <i style="color: #dbdbdb; font-size: 26px; position: relative; right: -7px; top: -7px;" class="fa fa-circle fa-stack-3x"></i>
                                            <i style="font-size: 16px; top: 3px; left: -1px; color: #ffffff; " class="fa fa-circle fa-stack-2x"></i>
                                            <i style="font-size: 7px; top: -9px; left: -1px;" class="fa fa-circle fa-stack-1x"></i>
                                        </span>
                                    </div>
                                    <!-- BLog Inn -->
                                <?php
                                }

                                $post_xml = get_post_meta(get_the_id(), "post", true);
                                $cs_meta_gallery_options = get_post_meta(get_the_id(), "cs_meta_gallery_options", true);
                                if ($post_xml <> "") {
                                    $cs_xmlObject = new SimpleXMLElement($post_xml);
                                    $sub_title = $cs_xmlObject->sub_title;
                                    $post_thumb_view = $cs_xmlObject->post_thumb_view;
                                    $post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
                                    $post_thumb_slider = $cs_xmlObject->post_thumb_slider;
                                    $post_thumb_slider_type = $cs_xmlObject->post_thumb_slider_type;
                                    $inside_post_thumb_view = $cs_xmlObject->inside_post_thumb_view;
                                    $inside_post_featured_image_as_thumbnail = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
                                    $inside_post_thumb_audio = $cs_xmlObject->inside_post_thumb_audio;
                                    $inside_post_thumb_video = $cs_xmlObject->inside_post_thumb_video;
                                    $inside_post_thumb_slider = $cs_xmlObject->inside_post_thumb_slider;
                                    $inside_post_thumb_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
                                    $post_social_sharing = $cs_xmlObject->post_social_sharing;
                                    $post_author_info_show = $cs_xmlObject->post_author_info_show;
                                    $cs_related_post = $cs_xmlObject->cs_related_post;
                                    $post_tags_show = $cs_xmlObject->post_tags_show;
                                    $post_pagination_show = $cs_xmlObject->post_pagination_show;
                                }
                                ?>
                                <div class="blog-inn">

                                    <?php if ($post_thumb_view == 'Single Image') { ?>
                                        <?php
                                        if ($thumbnail == '') {

                                            if ($cs_blog_view == 'grid') {
                                                $image_url = get_template_directory_uri() . '/assets/images/no-image16x9.jpg';
                                            } else if ($cs_blog_view == 'boxed') {
                                                $image_url = get_template_directory_uri() . '/assets/images/no-image4x3.jpg';
                                            } else {
                                                $image_url = '';
                                            }
                                        } else {
                                            $image_url = $thumbnail;
                                        }

                                        if ($image_url != '') {
                                            ?>

                                            <figure>
                                                    <?php cs_featured(); ?>
                                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url; //esc_url($image_url);?>" alt=""></a>
                                                    <?php if ($cs_blog_view != 'boxed') { ?>
                                                    <a class="blog-hover"  href="<?php the_permalink(); ?>"><i></i></a>
                                                    <?php } ?>
                                                <figcaption>
                                                    <?php
                                                    if ($cs_blog_view == 'boxed') {

                                                        if (isset($cs_blog_cat) && $cs_blog_cat != '' && $cs_blog_cat != '0') {
                                                            echo '<ul><li><a href="' . site_url() . '?cat=' . $row_cat->term_id . '">' . $row_cat->name . '</a></li></ul>';
                                                        } else {
                                                            /* Get All Tags */
                                                            $before_cat = "<ul><li>";
                                                            $categories_list = get_the_term_list(get_the_id(), 'category', $before_cat, ' ', '</li></ul>');
                                                            if ($categories_list) {
                                                                printf(__('%1$s', 'LMS'), $categories_list);
                                                            }
                                                            // End if Tags 
                                                        }
                                                    }
                                                    ?>
                                                </figcaption>
                                            </figure>
                                                <?php }
                                            } else if ($post_thumb_view == 'Slider') { ?>
                                        <figure>
                                                <?php cs_featured(); ?>
                                                <?php cs_post_flex_slider($width, $height, get_the_id(), 'post-list'); ?>
                                            <figcaption>
                                        <?php
                                        if ($cs_blog_view == 'boxed') {

                                            if (isset($cs_blog_cat) && $cs_blog_cat != '' && $cs_blog_cat != '0') {
                                                echo '<a href="' . site_url() . '?cat=' . $row_cat->term_id . '">' . $row_cat->name . '</a>';
                                            } else {
                                                /* Get All Tags */
                                                $before_cat = "";
                                                $categories_list = get_the_term_list(get_the_id(), 'category', $before_cat, '', '');
                                                if ($categories_list) {
                                                    printf(__('%1$s', 'LMS'), $categories_list);
                                                }
                                                // End if Tags 
                                            }
                                        }
                                        ?>
                                            </figcaption>
                                        </figure>
                                                <?php } ?>
                                                <?php
                                                if ($cs_blog_view == 'default') {
                                                    echo '<div class="blog-icon">';
                                                    echo cs_get_post_thumb_view($post_thumb_view, $inside_post_thumb_view);
                                                    echo '</div>';
                                                }
                                                ?>
                                    <section class="bloginfo">
                                        <!-- Post Option -->
                                                <?php if ($cs_blog_view != 'boxed') { ?>
                                            <ul class="post-option">
                                                <li>
                                                    <?php if ($cs_blog_view != 'clean') {
                                                        _e('Posted On', 'LMS');
                                                    } ?>
                                                    <?php echo get_the_date(); ?>
                                                </li>

                                                    <?php if ($cs_blog_view == 'clean' || $cs_blog_view == 'small' || $cs_blog_view == 'masonry' || $cs_blog_view == 'timeline' || $cs_blog_view == 'medium' || $cs_blog_view == 'default') { ?>
                                                    <li>
                                                        <?php _e('By', 'LMS'); ?><a class="cs-color" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a>
                                                    </li>
                                            <?php } ?>
                                            </ul>
                                            <?php } ?>
                                        <!-- Post Option Close -->

                                        <h2>
                                            <a href="<?php the_permalink(); ?>">
                                            <?php
                                        echo substr(get_the_title(), 0, $title_limit);

                                        if (strlen(get_the_title()) > $title_limit) {
                                            echo '...';
                                        }
                                        ?></a></h2>
                                                <?php if ($cs_blog_view == 'boxed') { ?>
                                            <ul class="post-option"><li>
                    <?php
                    echo cs_get_post_thumb_view($post_thumb_view, $inside_post_thumb_view);
                    _e(' Posted On', 'LMS');
                    echo get_the_date();
                    ?>
                                                </li></ul>
                <?php } ?>
                                                            <?php if ($cs_blog_view != 'boxed' && $cs_blog_view != 'grid') { ?>
                                            <p> <?php
                                                                if ($cs_blog_description == 'yes') {

                                                                    echo cs_get_the_excerpt($cs_blog_excerpt, 'ture', '');
                                                                }
                                                                ?> </p>
                                                    <?php } ?>


                                                <?php if ($cs_blog_view != 'grid' && $cs_blog_view != 'boxed' && $cs_blog_view != 'masonry' && $cs_blog_view != 'clean') { ?>
                                            <div class="blog-bottom">
                                                <ul class="blog-left">
                    <?php if ($cs_blog_view != 'medium' && $cs_blog_view != 'default') { ?>
                                                        <li>
                                                            <a>
                                                                <i class="fa fa-eye"></i>
                                                                <span><?php echo cs_get_post_views(get_the_ID()); ?></span>
                                                            </a>
                                                        </li>
                                                <?php } ?>
                                                    <li>
                                                        <a href="<?php comments_link(); ?>"><span class="counter">
                                            <?php if ($cs_blog_view == 'medium' || $cs_blog_view == 'default') {
                                                echo comments_number(__('0 Comment', 'LMS'), __('1 Comment', 'LMS'), __('% Comments', 'LMS'));
                                            } else {
                                                echo comments_number(__('0', 'LMS'), __('1', 'LMS'), __('%', 'LMS'));
                                            }; ?>
                                                            </span><i class="fa fa-comment-o"></i></a>
                                                    </li>
                                                    <li>
                    <?php
                    cs_like_counter($cs_likes_title);
                    $post_social_sharing = isset($post_social_sharing) ? $post_social_sharing : '';
                    ?>
                                                    </li>
                        <?php if ($post_social_sharing == 'on' && $cs_blog_view != 'medium' && $cs_blog_view != 'default') { ?>
                                                        <li>
                            <?php cs_addthis_script_init_method(); ?>
                                                            <a class="btnshare addthis_button_compact"><i class="fa fa-share-alt"></i></a>
                                                        </li>
                        <?php } ?>
                                                </ul>
                        <?php if ($cs_blog_view != 'timeline' && $cs_blog_view != 'medium' && $cs_blog_description == 'yes') { ?>
                                                    <div class="blog-right">
                                                        <a class="custom-btn" href="<?php echo get_permalink(); ?>"><?php _e('Read More', 'LMS'); ?></a>
                                                    </div>
                        <?php } ?>       
                                            </div>
                    <?php } ?>
                    <?php if (( $cs_blog_view == 'masonry' || $cs_blog_view == 'medium' ) && $cs_blog_description == 'yes') { ?>
                                            <a class="custom-btn" href="<?php echo get_permalink(); ?>">
                        <?php
                        global $cs_theme_options, $wpdb;
                        _e('Read More', 'LMS');
                        ?></a> 
                    <?php } ?>
                                    </section>
                                </div>
                                <!-- BLog Inn Close --> 
                            </article>
                            <!-- Article Close -->
                    </div>
                    <?php
                endwhile;
                //==Pagination Start
                if ($blog_pagination == "Show Pagination" && $count_post > $cs_blog_num_post && $cs_blog_num_post > 0) {
                    $qrystr = '';
                    if (isset($_GET['page_id']))
                        $qrystr .= "&amp;page_id=" . $_GET['page_id'];
                    if (isset($_GET['by_author']))
                        $qrystr .= "&amp;by_author=" . $_GET['by_author'];
                    if (isset($_GET['sort']))
                        $qrystr .= "&amp;sort=" . $_GET['sort'];
                    if (isset($_GET['filter_category']))
                        $qrystr .= "&amp;filter_category=" . $_GET['filter_category'];
                    if (isset($_GET['filter-tag']))
                        $qrystr .= "&amp;filter-tag=" . $_GET['filter-tag'];

                    echo cs_pagination($count_post, $cs_blog_num_post, $qrystr, 'Show Pagination');
                }
                //==Pagination End	
            }

            //echo '</div>';  
            wp_reset_postdata();

            $post_data = ob_get_clean();
            return $post_data;
        }

        add_shortcode('cs_blog', 'cs_blog_shortcode');
    }

//======================================================================
// Adding Blog Posts thumb image
//=====================================================================
    if (!function_exists('cs_get_post_thumb_view')) {

        function cs_get_post_thumb_view($post_thumb_view = '', $inside_post_thumb_view = '') {

            $iconType = '';
            if ($post_thumb_view == 'Single Image') {
                if ($inside_post_thumb_view == 'Audio') {
                    $iconType = '<i class="fa fa-microphone"></i>';
                } else if ($inside_post_thumb_view == 'Single Image') {
                    $iconType = '<i class="fa fa fa-photo"></i>';
                } else if ($inside_post_thumb_view == 'Slider') {
                    $iconType = '<i class="fa fa-slideshare"></i>';
                } else if ($inside_post_thumb_view == 'Video') {
                    $iconType = '<i class="fa fa-play-circle"></i>';
                } else {
                    $iconType = '<i class="fa fa fa-photo"></i>';
                }
            } else {
                $iconType = '<i class="fa fa-slideshare"></i>';
            }
            return $iconType;
        }

    }

// Adding Blog Posts End
//======================================================================
// Adding Post Attachments
//=====================================================================
    function cs_post_attachments($gallery_meta_form) {
        $galleryConter = rand(40, 9999999);
        ?>		
        <div class="to-social-network">
            <div class="gal-active">
                <div class="clear"></div>
                <div class="dragareamain">
                    <div class="placehoder"><?php _e('Gallery is Empty. Please Select Media', 'LMS'); ?> <img src="<?php echo esc_url(get_template_directory_uri() . '/include/assets/images/bg-arrowdown.png'); ?>" alt="" />
                    </div>
                    <ul id="gal-sortable" class="gal-sortable-<?php echo esc_attr($gallery_meta_form); ?>">
    <?php
    global $cs_node, $cs_xmlObject, $cs_counter, $post;

    if ($gallery_meta_form == 'gallery_slider_meta_form') {
        $type = 'gallery_slider';
    } else {
        $type = 'gallery';
    }
    $cs_counter_gal = 0;
    if (isset($cs_xmlObject->$type) and count($cs_xmlObject->$type) > 0) {
        foreach ($cs_xmlObject->$type as $cs_node) {
            $cs_counter_gal++;
            $cs_counter = $post->ID . $cs_counter_gal;
            if ($type == 'gallery_slider') {
                cs_slider_clone();
            } else {
                cs_gallery_clone();
            }
        }
    }
    ?>
                    </ul>
                </div>
            </div>
            <div class="to-social-list">
                <div class="soc-head">
                    <h5>Select Media</h5>
                    <div class="right">
    <?php if ($gallery_meta_form == 'gallery_slider_meta_form') { ?>
                            <input type="button" class="button reload" value="Reload" onclick="refresh_media_slider(<?php echo esc_attr($galleryConter); ?>)" />
    <?php } else { ?>
                            <input type="button" class="button reload" value="Reload" onclick="refresh_media(<?php echo esc_attr($galleryConter); ?>)" />
    <?php } ?>
                        <input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="<?php _e('Upload Media', 'LMS'); ?>" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <script type="text/javascript">
                    function show_next(page_id, total_pages) {
                        //var dataString = 'action=media_pagination&id='+id+'&func='+func+'&page_id='+page_id+'&total_pages='+total_pages;
                        var dataString = 'action=media_pagination&page_id=' + page_id + '&total_pages=' + total_pages;
                        /*if (func == 'slider') {
                         var	pagination	= 'pagination_slider';
                         } else {
                         var	pagination	= 'pagination_clone';
                         }*/
                        jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri() . '/include/assets/images/ajax_loading.gif')) ?>' />");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery("#pagination").html(response);
                            }
                        });
                    }
                    function slider_show_next(page_id, total_pages) {
                        //var dataString = 'action=media_pagination&id='+id+'&func='+func+'&page_id='+page_id+'&total_pages='+total_pages;
                        var dataString = 'action=slider_media_pagination&page_id=' + page_id + '&total_pages=' + total_pages;
                        /*if (func == 'slider') {
                         var	pagination	= 'pagination_slider';
                         } else {
                         var	pagination	= 'pagination_clone';
                         }*/
                        jQuery(".pagination_slider").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri())) ?>/include/assets/images/ajax_loading.gif' />");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery(".pagination_slider").html(response);
                            }
                        });
                    }
                    function refresh_media(id) {
                        var dataString = 'action=media_pagination&id=' + id + '&func=slider';
                        jQuery(".pagination_clone").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri())) ?>/include/assets/images/ajax_loading.gif' />");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery(".pagination_clone").html(response);
                            }
                        });
                    }

                    function refresh_media_slider(id) {
                        var dataString = 'action=slider_media_pagination&id=' + id + '&func=slider';
                        jQuery(".pagination_slider").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri())) ?>/include/assets/images/ajax_loading.gif' />");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery(".pagination_slider").html(response);
                            }
                        });
                    }
                </script>
                <script>
                    jQuery(document).ready(function ($) {
                        $(".gal-sortable-<?php echo esc_js($galleryConter); ?>").sortable({
                            cancel: 'li div.poped-up',
                        });
                        //$(this).append("#gal-sortable").clone() ;
                    });
                    var counter = 0;
                    var count_items = <?php echo esc_js($cs_counter_gal) ?>;
                    if (count_items > 0) {
                        jQuery(".dragareamain").addClass("noborder");
                    }

                    function clone(path, id) {
                        counter = counter + 1;
                        var cls = 'gal-sortable-gallery_meta_form';
                        var dataString = 'path=' + path + '&counter=' + counter + '&action=gallery_clone';
                        jQuery("." + cls).append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri())) ?>/include/assets/images/ajax_loading.gif' /></li>");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery("#loading").remove();
                                jQuery("." + cls).append(response);
                                count_items = jQuery("." + cls + ' ' + "li").length;
                                if (count_items > 0) {
                                    jQuery(".dragareamain").addClass("noborder");
                                }
                            }
                        });
                    }

                    function slider(path, id) {
                        counter = counter + 1;
                        var cls = 'gal-sortable-gallery_slider_meta_form';
                        var dataString = 'path=' + path + '&counter=' + counter + '&action=slider_clone';
                        jQuery("." + cls).append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri())) ?>/include/assets/images/ajax_loading.gif' /></li>");
                        jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>",
                            data: dataString,
                            success: function (response) {
                                jQuery("#loading").remove();
                                jQuery("." + cls).append(response);
                                count_items = jQuery("." + cls + ' ' + "li").length;
                                if (count_items > 0) {
                                    jQuery(".dragareamain").addClass("noborder");
                                }
                            }
                        });
                    }
                    function del_this(div, id) {
                        jQuery("#" + div + ' ' + "#" + id).remove();
                        count_items = jQuery("#gal-sortable li").length;
                        if (count_items == 0) {
                            jQuery(".dragareamain").removeClass("noborder");
                        }
                    }
                </script>
        <?php if ($gallery_meta_form == 'gallery_slider_meta_form') { ?>
                    <div id="pagination" class="pagination_slider"><?php slider_media_pagination($gallery_meta_form, 'slider'); ?></div>
    <?php } else { ?>
                    <div id="pagination" class="pagination_clone"><?php media_pagination($gallery_meta_form, 'clone'); ?></div>
                        <?php }
                    ?>

                <input type="hidden" name="<?php echo esc_attr($gallery_meta_form); ?>" value="1" />
                <div class="clear"></div>
            </div>
        </div>
                    <?php
                }

//=====================================================================
// Adding Posts flexslider 
//=====================================================================
                if (!function_exists('cs_post_flex_slider')) {

                    function cs_post_flex_slider($width, $height, $postid, $view) {
                        global $cs_node, $cs_theme_options, $cs_counter_node;
                        $cs_post_counter = rand(40, 9999999);
                        $cs_counter_node++;

                        if ($view == 'post-list') {
                            $viewMeta = 'post';
                        } else {
                            $viewMeta = $view;
                        }

                        $cs_meta_slider_options = get_post_meta("$postid", $viewMeta, true);
                        $totaImages = '';
                        $cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
                        $as_node = new stdClass();
                        ?>
            <!-- Flex Slider -->
            <div id="flexslider<?php echo esc_attr($cs_post_counter); ?>">
                <div class="flexslider" style="display: none;">
                    <ul class="slides">
                                    <?php
                                    $cs_counter = 1;

                                    if ($view == 'post') {
                                        $path = 'cs_slider_path';
                                        $sliderData = $cs_xmlObject_flex->children()->gallery_slider;
                                        $totaImages = count($cs_xmlObject_flex->children()->gallery_slider);
                                    } else if ($view == 'post-list') {
                                        $path = 'path';
                                        $sliderData = $cs_xmlObject_flex->children()->gallery;
                                        $totaImages = count($cs_xmlObject_flex->children()->gallery);
                                    } else {
                                        $path = 'path';
                                        $sliderData = $cs_xmlObject_flex->children();
                                        $totaImages = count($cs_xmlObject_flex->children());
                                    }

                                    foreach ($sliderData as $as_node) {
                                        $image_url = cs_attachment_image_src((int) $as_node->$path, $width, $height);
                                        echo '<li>
									<figure>
			                        	<img src="' . esc_url($image_url) . '" alt="">';
                                        if ($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != '') {
                                            ?>         
                                <figcaption>
                                    <div class="container">
                <?php if ($as_node->title <> '') { ?>
                                            <h2 class="colr">
                    <?php
                    if ($as_node->link <> '') {
                        echo '<a href="' . esc_url($as_node->link) . '" target="' . esc_attr($as_node->link_target) . '">' . esc_attr($as_node->title) . '</a>';
                    } else {

                        echo esc_attr($as_node->title);
                    }
                    ?>
                                            </h2>
                <?php
                }
                if ($as_node->description <> '') {
                    echo '<p>' . substr($as_node->description, 0, 220);
                    if (strlen($as_node->description) > 220)
                        echo "...</p>";
                }
                ?>
                                    </div>
                                </figcaption>
                <?php } ?>

                            </figure>
                            </li>
                <?php
                $cs_counter++;
            }
            ?>
                    </ul>
                    <span class='cs-flex-total-slides'></span>
                </div>
            </div>
            <?php cs_enqueue_flexslider_script(); ?>

            <!-- Slider height and width -->

            <!-- Flex Slider Javascript Files -->

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('#flexslider<?php echo esc_js($cs_post_counter); ?> .flexslider .cs-flex-total-slides').html("<?php echo esc_js($totaImages); ?> / ");
                    var speed = '6000';
                    var slidespeed = '500';
                    jQuery('#flexslider<?php echo esc_js($cs_post_counter); ?> .flexslider').flexslider({
                        animation: "slide", // fade
                        slideshow: true,
                        slideshowSpeed: speed,
                        animationSpeed: slidespeed,
                        prevText: "<em class='fa fa-arrow-left'></em>",
                        nextText: "<em class='fa fa-arrow-right'></em>",
                        start: function (slider) {
                            jQuery('.flexslider').fadeIn();
                        }
                    });
                });
            </script>
            <?php
        }

    }

//======================================================================
// Adding Team start
//=====================================================================
    if (!function_exists('cs_teams_shortcode')) {

        function cs_teams_shortcode($atts, $content = "") {
            $defaults = array('column_size' => '1/1', 'cs_team_section_title' => '', 'cs_team_view' => 'default', 'cs_team_name' => '', 'cs_team_designation' => '', 'cs_team_title' => '', 'cs_team_profile_image' => '', 'cs_team_fb_url' => '', 'cs_team_twitter_url' => '', 'cs_team_googleplus_url' => '', 'cs_team_skype_url' => '', 'cs_team_email' => '', 'teams_class' => '', 'teams_animation' => '');
            extract(shortcode_atts($defaults, $atts));
            $column_class = cs_custom_column_class($column_size);

            $CustomId = '';
            if (isset($teams_class) && $teams_class) {
                $CustomId = 'id="' . $teams_class . '"';
            }

            $html = '';
            $team_view_class = '';
            $social_media_html = '';
            $teamClass = '';
            $teamIconColor = '';
            $teamIconfb = '';
            $teamIcontw = '';
            $teamIcongp = '';
            $teamIconen = '';
            $teamIconsk = '';
            $rowDivStart = '';
            $rowDivEnd = '';

            if ($column_class == 'col-md-6') {
                $column_class = 'col-md-12';
            }

            if ($cs_team_view == 'default') {
                $teamClass = 'size_large';
                $teamIconfb = 'style="background-color:#2d5faa;"';
                $teamIcontw = 'style="background-color:#21cdec;"';
                $teamIcongp = 'style="background-color:#cc1515;"';
                $teamIconsk = 'style="background-color:#21CDEC;"';
                $teamIconen = 'style="background-color:#cca715;"';
            } else if ($cs_team_view == 'list') {
                $teamClass = 'size_medium';
                $rowDivStart = '<div class="row">';
                $rowDivEnd = '</div>';
            } else {
                $teamClass = 'size_large';
            }

            if ($cs_team_view <> '' && $cs_team_view == 'grid') {
                $team_view_class = 'team_grid_sh';
            } else if ($cs_team_view <> '') {
                $team_view_class = $cs_team_view . '_team_view';
            }

            if ($cs_team_fb_url || $cs_team_twitter_url || $cs_team_googleplus_url || $cs_team_skype_url || $cs_team_email) {
                $social_media_html = '<p class="social-media">';
                if (isset($cs_team_fb_url) && $cs_team_fb_url != '') {
                    $social_media_html .='<a href="' . esc_url($cs_team_fb_url) . '" ' . $teamIconfb . ' target="_blank"><i class="fa fa-facebook"></i></a>';
                }
                if (isset($cs_team_twitter_url) && $cs_team_twitter_url != '') {
                    $social_media_html .='<a href="' . esc_url($cs_team_twitter_url) . '"  ' . $teamIcontw . ' target="_blank"><i class="fa fa-twitter"></i></a>';
                }
                if (isset($cs_team_googleplus_url) && $cs_team_googleplus_url != '') {
                    $social_media_html .='<a href="' . esc_url($cs_team_googleplus_url) . '"  ' . $teamIcongp . '  target="_blank"><i class="fa fa-google-plus"></i></a>';
                }
                if (isset($cs_team_skype_url) && $cs_team_skype_url != '') {
                    $social_media_html .='<a href="' . esc_url($cs_team_skype_url) . '"  ' . $teamIconsk . ' target="_blank"><i class="fa fa-skype"></i></a>';
                }
                if (isset($cs_team_email) && $cs_team_email != '' && is_email($cs_team_email)) {
                    $social_media_html .='<a href="mailto:' . sanitize_email($cs_team_email) . '"  ' . $teamIconen . ' target="_blank"><i class="fa fa-envelope-o"></i></a>';
                }
                $social_media_html .='</p>';
            }
            $text_class = '';

            $html .='<div ' . $CustomId . ' class="cs-team ' . $team_view_class . ' ' . $teams_class . '">';
            $html .= $rowDivStart;
            $html .='<article class="' . $teamClass . ' has_border">';
            if (isset($cs_team_profile_image) && $cs_team_profile_image != '') {
                $html .='<figure><a ><img alt="' . $cs_team_name . '" src="' . $cs_team_profile_image . '"></a>';
                if ($cs_team_view == 'default') {
                    $html .='<figcaption class="has_caption_soc">' . $social_media_html . '</figcaption>';
                }
                $html .='</figure>';
            }
            if ($cs_team_name || $cs_team_designation || $content || $cs_team_fb_url || $cs_team_twitter_url || $cs_team_googleplus_url || $cs_team_skype_url || $cs_team_email) {
                $html .='<div class="text ' . $text_class . '">';
                if ($cs_team_name || $cs_team_designation) {
                    $html .='<header>';
                    if (isset($cs_team_name) && $cs_team_name != '') {
                        $html .='<h2 class="cs-post-title"><a>' . $cs_team_name . '</a></h2>';
                    }
                    if (isset($cs_team_designation) && $cs_team_designation != '') {
                        $html .='<ul class="post-option"><li class="has-border">' . $cs_team_designation . '</li></ul>';
                    }
                    $html .='</header>';
                }
                if (isset($content) && $content != '') {
                    $html .='<p>' . do_shortcode($content) . '</p>';
                }
                if ($cs_team_view <> 'default') {
                    $html .=$social_media_html;
                }
                $html .='</div>';
            }
            $html .='</article>';
            $html .= $rowDivEnd;
            $html .='</div>';
            $section_title = '';
            if (trim($cs_team_section_title) <> '') {
                $section_title = '<div class="cs-section-title"><h2>' . $cs_team_section_title . '</h2></div>';
            }
            return '<div class="' . $column_class . '">' . $section_title . '<div class="cs-team">' . $html . '</div></div>';
        }

        add_shortcode('cs_team', 'cs_teams_shortcode');
    }
// Adding Team  End
//=====================================================================
// Adding Twitter Tweets start
//=====================================================================
    if (!function_exists('cs_tweets_shortcode')) {

        function cs_tweets_shortcode($atts, $content = "") {
            $defaults = array('column_size' => '', 'cs_tweets_section_title' => '', 'cs_tweets_user_name' => 'default', 'cs_tweets_color' => '', 'cs_no_of_tweets' => '', 'cs_tweets_class' => '', 'cs_tweets_animation' => '', 'cs_custom_animation_duration' => '1');
            extract(shortcode_atts($defaults, $atts));
            $column_class = cs_custom_column_class($column_size);

            $CustomId = '';
            if (isset($cs_tweets_class) && $cs_tweets_class) {
                $CustomId = 'id="' . $cs_tweets_class . '"';
            }

            $rand_id = rand(5, 999999);
            $html = '';
            $section_title = '';
            if ($cs_tweets_section_title && trim($cs_tweets_section_title) != '') {
                //$section_title	= '<div class="cs-section-title '.$column_class.'"><h2>'.$cs_tweets_section_title.'</h2></div>';
            }
            //$html .= '<div '.$CustomId.' class="twitter-section '.$cs_tweets_class.'">';
            //$html .= "<div class='widget_slider'><div class='flexslider flexslider".$rand_id."'><ul class='slides'>";
            $html .= cs_get_tweets($cs_tweets_user_name, $cs_no_of_tweets, $cs_tweets_color, $CustomId, $cs_tweets_class);
            //$html .= '</ul></div></div>';
            // cs_enqueue_flexslider_script();
            /* $html.='<script type="text/javascript">
              jQuery(document).ready(function(){
              jQuery(".widget_slider .flexslider'.esc_js($rand_id).'").flexslider({
              animation: "fade",
              slideshow: true,
              slideshowSpeed: 7000,
              animationDuration: 600,
              prevText:"<em class=\'fa fa-angle-up\'></em>",
              nextText:"<em class=\'fa fa-angle-down\'></em>",
              start: function(slider) {
              jQuery(".flexslider").fadeIn();
              }
              });
              });
              </script>';
              $html .= '</div>';
             */
            return $html;
        }

        add_shortcode('cs_tweets', 'cs_tweets_shortcode');
    }

// Adding Twitter Tweets  End
//=====================================================================
// Get Twitter Tweets  Start
//=====================================================================
    if (!function_exists('cs_get_tweets')) {
        /*
          function cs_get_tweets($username,$numoftweets,$cs_tweets_color = ''){
          global $cs_theme_options;

          $username = html_entity_decode($username);
          $numoftweets = $numoftweets;
          if($numoftweets == ''){ $numoftweets = 2;}
          if(strlen($username) > 1){

          $text ='';
          $return = '';
          $cacheTime = 10000;
          $transName = 'latest-tweets';
          require_once get_template_directory() . '/include/theme-components/cs-twitter/twitteroauth.php';
          $consumerkey = $cs_theme_options['cs_consumer_key'];
          $consumersecret = $cs_theme_options['cs_consumer_secret'];
          $accesstoken = $cs_theme_options['cs_access_token'];
          $accesstokensecret = $cs_theme_options['cs_access_token_secret'];
          $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
          $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$numoftweets);
          if(!is_wp_error($tweets) and is_array($tweets)){
          set_transient($transName, $tweets, 60 * $cacheTime);
          }else{
          $tweets = get_transient('latest-tweets');
          }
          if(!is_wp_error($tweets) and is_array($tweets)){
          $twitter_text_color = '';
          if(!empty($cs_tweets_color)){
          $twitter_text_color = "style='color: $cs_tweets_color !important'";
          }
          $rand_id    = rand(5, 300);
          $exclude	= 0;
          foreach($tweets as $tweet) {
          $exclude++;
          //if($exclude > 1 ){
          $text = $tweet->{'text'};
          foreach($tweet->{'user'} as $type => $userentity) {
          if($type == 'profile_image_url') {
          $profile_image_url = $userentity;
          } else if($type == 'screen_name'){
          $screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
          }
          }
          foreach($tweet->{'entities'} as $type => $entity) {
          if($type == 'hashtags') {
          foreach($entity as $j => $hashtag) {
          $update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&amp;src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
          $text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
          }
          }
          }
          $large_ts = time();
          $n = $large_ts - strtotime($tweet->{'created_at'});
          if($n < (60)){ $posted = sprintf(__('%d seconds ago','LMS'),$n); }
          elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','%d Minutes Ago',$minutes,'LMS'),$minutes); }
          elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'LMS'),$hours); }
          elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'LMS'),$hours); }
          elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','%d Days Ago',$days,'LMS'),$days); }
          elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'LMS'),$weeks); }
          elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'LMS'),$months);}
          elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'LMS'),$years);}
          $return .='<li><div class="text" style="color:'.$cs_tweets_color.'">';
          $return .= "" . $text . "";
          //$return .= "<p><a href='https://twitter.com/".$username."'>@" . $username . "</a></p>";
          $return .= '<time datetime="2011-01-12" style="color:'.$cs_tweets_color.'">('. $posted. ')</time>';
          $return .="</div></li>";

          //	}
          }
          //$return .= "</div>";
          //if(isset($profile_image_url) && $profile_image_url <> ''){$profile_image_url = '<img src="'.$profile_image_url.'" alt="">';} else {$profile_image_url = '';}
          $return .= '<div class="follow-on">
          <div class="cs-tweet">
          <i class="fa fa-twitter"></i>
          <a href="https://twitter.com/'.$username.'" target="_blank"  style="color:'.$cs_tweets_color.'">@'. $username .'</a>
          </div>
          </div>';

          //$return .= "</div>";
          return  $return;

          }else{
          if(isset($tweets->errors[0]) && $tweets->errors[0] <> ""){
          return  '<div class="cs-twitter item" data-hash="dummy-one"><h4>'.$tweets->errors[0]->message.". Please enter valid Twitter API Keys </h4></div>";
          }else{
          return  '<div class="cs-twitter item" data-hash="dummy-two"><h4>'.__('No Tweets Found','LMS').'</h4></div>';
          }
          }
          }else{
          return  '<div class="cs-twitter item" data-hash="dummy-three"><h4>'.__('No Tweets Found','LMS').'</h4></div>';
          }
          }
         */

        function cs_get_tweets($username, $numoftweets, $cs_tweets_color = '', $CustomId, $cs_tweets_class) {

            global $cs_theme_options, $cs_twitter_arg;


            $cs_twitter_api_switch = isset($cs_theme_options['cs_twitter_api_switch']) ? $cs_theme_options['cs_twitter_api_switch'] : '';
            $cs_twitter_arg['consumerkey'] = isset($cs_theme_options['cs_consumer_key']) ? $cs_theme_options['cs_consumer_key'] : '';
            $cs_twitter_arg['consumersecret'] = isset($cs_theme_options['cs_consumer_secret']) ? $cs_theme_options['cs_consumer_secret'] : '';
            $cs_twitter_arg['accesstoken'] = isset($cs_theme_options['cs_access_token']) ? $cs_theme_options['cs_access_token'] : '';
            $cs_twitter_arg['accesstokensecret'] = isset($cs_theme_options['cs_access_token_secret']) ? $cs_theme_options['cs_access_token_secret'] : '';
            $cs_cache_limit_time = isset($cs_theme_options['cs_cache_limit_time']) ? $cs_theme_options['cs_cache_limit_time'] : '';
            $cs_tweet_num_from_twitter = isset($cs_theme_options['cs_tweet_num_post']) ? $cs_theme_options['cs_tweet_num_post'] : '';
            $cs_twitter_datetime_formate = isset($cs_theme_options['cs_twitter_datetime_formate']) ? $cs_theme_options['cs_twitter_datetime_formate'] : '';

            if ($cs_twitter_api_switch == 'on') {
                if ($cs_twitter_arg['consumerkey'] <> '' && $cs_twitter_arg['consumersecret'] <> '' && $cs_twitter_arg['accesstoken'] <> '' && $cs_twitter_arg['accesstokensecret'] <> '') {
                    require_once get_template_directory() . '/include/theme-components/cs-twitter/display-tweets.php';
                    display_tweets_shortcode($username, $cs_twitter_datetime_formate, $cs_tweet_num_from_twitter, $numoftweets, $cs_cache_limit_time, $cs_tweets_color, $CustomId, $cs_tweets_class);
                } else {
                    echo '<p>' . __('Please Set Twitter API', 'lms') . '</p>';
                }
            }
        }

    }

//======================================================================
// Adding Clients Logo Start
//======================================================================
    if (!function_exists('cs_course_shortcode')) {

        function cs_course_shortcode($atts, $content = "") {
            global $cs_node, $wpdb, $post;
            $defaults = array('column_size' => '1/1', 'var_pb_course_title' => '', 'var_pb_course_cat' => '', 'var_pb_course_view' => '', 'var_pb_course_filterable' => '', 'cs_courses_orderby' => '', 'var_pb_course_excerpt' => '', 'var_pb_course_pagination' => '', 'var_pb_course_per_page' => '', 'cs_course_class' => '', 'cs_course_animation' => '');

            extract(shortcode_atts($defaults, $atts));
            $timeline_html_start = '';
            $timeline_html_end = '';
            $cs_node = new stdClass;
            $cs_node->column_size = '';
            $cs_node->column_size = $column_size;
            $cs_node->var_pb_course_title = $var_pb_course_title;
            $cs_node->var_pb_course_cat = $var_pb_course_cat;
            $cs_node->var_pb_course_view = $var_pb_course_view;
            $cs_node->var_pb_course_filterable = $var_pb_course_filterable;
            $cs_node->cs_courses_orderby = $cs_courses_orderby;
            $cs_node->var_pb_course_excerpt = $var_pb_course_excerpt;
            $cs_node->var_pb_course_pagination = $var_pb_course_pagination;
            $cs_node->var_pb_course_per_page = $var_pb_course_per_page;
            $cs_node->cs_course_class = $cs_course_class;
            $cs_node->cs_course_animation = $cs_course_animation;


            ob_start();
            if ($cs_node->var_pb_course_view == 'classic') {
                $course_listing_class = 'cs-list list_v3';
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'plain') {
                $course_listing_class = 'cs-list list_v3 has_border';
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'three-column') {
                $course_listing_class = 'cs-list list_v1 img_position_top has_border ';
                $courselisting_size = 'col-md-4';
                $title_limit = 36;
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'four-column') {
                $course_listing_class = 'cs-list list_v1 img_position_top has_border has_shadow';
                $courselisting_size = 'col-md-3';
                $title_limit = 36;
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'timeline') {
                $course_listing_class = 'cs-list list_v4 has_border';
                $timeline_html_start = '<div class="cs-list-wrapp">';
                $timeline_html_end = '</div>';
                $width = 374;
                $height = 210;
            } else if ($cs_node->var_pb_course_view == 'flat') {
                $course_listing_class = 'cs-list cs-flat-view';
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'flat-grid') {
                $course_listing_class = 'cs-list  img_position_top has_border has_shadow cs-flat-grid-view';
                $width = 370;
                $height = 278;
                $title_limit = 36;

                if ($cs_node->var_pb_course_filterable == 'yes') {
                    $courselisting_size = 'col-md-4';
                } else if ($cs_node->var_pb_course_filterable == 'no') {
                    $courselisting_size = 'col-md-3';
                } else {
                    $courselisting_size = 'col-md-4';
                }
            } else if ($cs_node->var_pb_course_view == 'grid-slider') {
                $course_listing_class = 'cs-list list_v1 img_position_top has_border ';
                $courselisting_size = '';
                $title_limit = 36;
                $width = 370;
                $height = 278;
                $gridTitleClass = 'grid-title';

                cs_owl_carousel();
                $owlcount = rand(40, 9999999);
                $moreCourses = true;
                ?>
                <script>  jQuery(document).ready(function ($) {
                        $("#owl-grid-<?php echo esc_js($owlcount); ?>").owlCarousel({
                            nav: true,
                            margin: 30,
                            navText: [
                                "<i class='fa fa-angle-left'></i>",
                                "<i class='fa fa-angle-right'></i>"
                            ],
                            responsive: {
                                0: {
                                    items: 1 // In this configuration 1 is enabled from 0px up to 479px screen size 
                                },
                                480: {
                                    items: 1, // from 480 to 677 
                                    nav: false // from 480 to max 
                                },
                                678: {
                                    items: 2, // from this breakpoint 678 to 959
                                    center: false // only within 678 and next - 959
                                },
                                960: {
                                    items: 3, // from this breakpoint 960 to 1199
                                    center: false,
                                    loop: false

                                },
                                1200: {
                                    items: 4
                                }
                            }
                        });
                    });
                </script>

            <?php
            } else if ($cs_node->var_pb_course_view == 'minimal') {
                $course_listing_class = 'cs-list cs-minimal-view';
            } else if ($cs_node->var_pb_course_view == 'modren') {
                $course_listing_class = 'cs-list cs-modren-view';
                $width = 374;
                $height = 210;
            } else if ($cs_node->var_pb_course_view == 'list') {
                $course_listing_class = 'cs-list cs-list-view';
                $width = 374;
                $height = 210;
            } else if ($cs_node->var_pb_course_view == 'big') {
                $course_listing_class = 'cs-list cs-big-view';
                $width = 370;
                $height = 278;
            } else if ($cs_node->var_pb_course_view == 'unique') {
                $course_listing_class = 'cs-list cs-unique-view';


                if ($cs_node->var_pb_course_filterable == 'yes') {
                    $courselisting_size = 'col-md-4';
                } else if ($cs_node->var_pb_course_filterable == 'no') {
                    $courselisting_size = 'col-md-3';
                } else {
                    $courselisting_size = 'col-md-3';
                }
            } else {
                $course_listing_class = 'cs-list list_v3';
                $width = 370;
                $height = 278;
            }

            wp_reset_query();
            if (!isset($cs_node->var_pb_course_view) || empty($cs_node->var_pb_course_view)) {
                $cs_node->var_pb_course_view = 'classic';
            }
            $meta_compare = '';
            $filter_category = '';
            $filter_category_array = array();
            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from " . $wpdb->prefix . "terms WHERE slug = %s", $cs_node->var_pb_course_cat));

            if (isset($_GET['filter_category'])) {
                $filter_category_array = $_GET['filter_category'];
                $catname = '';
                $contcat = ',';
                foreach ($filter_category_array as $cat_name) {
                    $catname .= $cat_name . ',';
                }
                $filter_category = rtrim($catname, ',');
            } else {
                if (isset($row_cat->slug)) {
                    $filter_category = $row_cat->slug;
                }
            }
            $cs_counter_course = 0;
            if (empty($_GET['page_id_all']))
                $_GET['page_id_all'] = 1;
            $args = array(
                'posts_per_page' => "-1",
                'post_type' => 'courses',
                'post_status' => 'publish',
                'orderby' => 'meta_value',
                'order' => 'ASC',
            );
            if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {
                $course_category_array = array('course-category' => "$filter_category");
                $args = array_merge($args, $course_category_array);
            }


            $custom_query = new WP_Query($args);

            $count_post = 0;
            $counter = 1;

            $count_post = $custom_query->post_count;


            $cs_course_layout = 'col-md-12';
            if ($cs_node->var_pb_course_filterable == 'yes') {

                $qrystr = "";
                if (isset($_GET['page_id']))
                    $qrystr = "&page_id=" . $_GET['page_id'];
                $cs_course_layout = 'col-md-12';
            }
            $sort = '';
            if (isset($_GET['sort']) and $_GET['sort'] <> '') {
                $sort = $_GET['sort'];
            }
            if (isset($_GET['sort']) and $_GET['sort'] == 'alphabetical') {

                $args = array('posts_per_page' => "$cs_node->var_pb_course_per_page", 'paged' => $_GET['page_id_all'], 'post_type' => 'courses', 'post_status' => 'publish', 'orderby' => 'title', 'order' => $cs_courses_orderby,);
            } elseif (isset($_GET['sort']) and $_GET['sort'] == 'members') {

                $args = array('posts_per_page' => "$cs_node->var_pb_course_per_page", 'paged' => $_GET['page_id_all'], 'post_type' => 'courses', 'post_status' => 'publish', 'meta_key' => 'var_cp_course_members', 'orderby' => 'meta_value_num', 'order' => $cs_courses_orderby,);
            } elseif (isset($_GET['sort']) and $_GET['sort'] == 'rating') {

                $args = array('posts_per_page' => "$cs_node->var_pb_course_per_page", 'paged' => $_GET['page_id_all'], 'post_type' => 'courses', 'post_status' => 'publish', 'meta_key' => 'cs_course_review_rating', 'orderby' => 'meta_value', 'order' => $cs_courses_orderby,);
            } else {
                $args = array(
                    'posts_per_page' => "$cs_node->var_pb_course_per_page",
                    'paged' => $_GET['page_id_all'],
                    'post_type' => 'courses',
                    'post_status' => 'publish',
                    'order' => $cs_courses_orderby,
                );
            }
            if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {
                $course_category_array = array('course-category' => "$filter_category");
                $args = array_merge($args, $course_category_array);
            }

            $custom_query = new WP_Query($args);

            $post_count = '';
            if (isset($_GET['filter_category'])) {
                $post_count = $custom_query->post_count;
            }
            $element_size = 100;

            if ($cs_node->var_pb_course_filterable == 'yes') {
                $element_size = 75;
                if (function_exists('cs_get_course_filters')) {
                    echo '<div class="element-size-25">';
                    cs_get_course_filters($filter_category_array, $sort, $post_count);
                    echo '</div>';
                }
            }

            if ($custom_query->have_posts() <> "") {
                ?>
                <div class="element-size-<?php echo esc_attr($element_size); ?>">
                        <?php if ($cs_node->var_pb_course_title <> '') {
                            ?>
                        <div class="cs-section-title col-md-12 <?php echo esc_attr($gridTitleClass); ?>">
                            <h2><?php echo esc_html($cs_node->var_pb_course_title); ?></h2>
                        </div>
                        <?php } ?>

                        <?php if ($cs_node->var_pb_course_view == 'grid-slider') { ?>
                        <div class="row owl-carousel nxt-prv-v2 cs-theme-carousel cs-crslider col-md-12" id="owl-grid-<?php echo esc_attr($owlcount); ?>">
                        <?php
                        }

                        $counterItems = 0;
                        $var_cp_course_product = '';
                        while ($custom_query->have_posts()): $custom_query->the_post();

                            $counterItems++;
                            $course_id = $course_post_id = $post->ID;
                            $var_pb_course_excerpt = (int) $cs_node->var_pb_course_excerpt;
                            $excerpt = cs_get_the_excerpt((int) $cs_node->var_pb_course_excerpt, false, '');
                            $applyNowButton = get_the_permalink();
                            $cs_course = get_post_meta($post->ID, "cs_course", true);
                            if ($cs_course <> "") {
                                $cs_xmlObject = new SimpleXMLElement($cs_course);
                                $var_cp_course_id = $cs_xmlObject->course_id;
                                $course_duration = $cs_xmlObject->course_duration;
                                $var_cp_course_members = $cs_xmlObject->var_cp_course_members;
                                $var_cp_course_paid = $cs_xmlObject->var_cp_course_paid;
                                $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
                            } else {
                                $var_cp_course_product = $var_cp_course_members = $var_cp_course_product = '';
                                $course_duration = '';
                                $course_subheader_bg_color = '';
                            }

                            $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), $width, $height);
                            $course_class = $course_listing_class;
                            if ($image_url == '') {
                                $course_class = ' no-img ' . $course_listing_class;
                            }
                            if ($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column') {
                                $thumbnail = 'hover-gallery';
                            } else {
                                $thumbnail = 'img-thumbnail';
                            }


                            if (trim($cs_node->cs_course_animation) != '') {
                                $cs_course_animation = 'wow' . ' ' . $cs_node->cs_course_animation;
                            } else {
                                $cs_course_animation = '';
                            }

                            if (isset($course_subheader_bg_color) && $course_subheader_bg_color != '' && $cs_node->var_pb_course_view == 'unique') {
                                $course_background = 'style="background-color:' . $course_subheader_bg_color . '"';
                                $course_background_hover = '';
                            } else {
                                $course_background = '';
                                $course_background_hover = 'style="background-color:' . $course_subheader_bg_color . '"';
                                ;
                            }
                            $firstChild = '';
                            if ($counterItems == 1) {
                                $firstChild = 'cs-first-child';
                            }

                            if ($image_url == '') {
                                if ($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider') {
                                    $image_url = get_template_directory_uri() . '/assets/images/no-image4x3.jpg';
                                }
                            } else {
                                $image_url = $image_url;
                            }
                            ?>
                            <div class="<?php echo esc_attr($cs_course_animation . ' ' . $courselisting_size); ?>">
                                <article <?php post_class($course_class . ' ' . $firstChild);
                    echo balanceTags($course_background, false); ?> >
                                                <?php echo balanceTags($timeline_html_start, false);
                                                if ($image_url <> '' && $cs_node->var_pb_course_view <> 'unique') {
                                                    ?>
                                                        <?php if ($cs_node->var_pb_course_view == 'flat') {
                                                            echo '<div class="cr-flat">';
                                                        } ?>
                                        <figure class="<?php echo esc_attr($thumbnail); ?>  fig-<?php echo absint($post->ID); ?>">
                                                        <?php
                                                        $user = cs_get_user_id();
                                                        $cs_wishlist = array();
                                                        $cs_wishlist = get_user_meta(cs_get_user_id(), 'cs-courses-wishlist', true);
                                                        if (!is_user_logged_in()) {
                                                            echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">';
                                                            ?> <?php
                                                            _e('Add to Favourite', 'LMS');
                                                            echo '</a>';
                                                        } elseif (isset($user) and $user <> '') {
                                                            $cs_wishlist = get_user_meta(cs_get_user_id(), 'cs-courses-wishlist', true);
                                                            if (is_array($cs_wishlist) && in_array($post->ID, $cs_wishlist)) {
                                                                echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>' . __('Already Favourite', 'LMS') . '</a>';
                                                            } else {
                                                                ?>
                                                    <a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>', '<?php echo esc_js(absint($post->ID)); ?>', 'post')">
                                                        <i class="fa fa-heart"></i> 
                                                                <?php _e('Add to Favourite', 'LMS'); ?>
                                                    </a>
                                                            <?php }
                                                        } ?>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                                            <a class="blog-hover" <?php echo balanceTags($course_background_hover, false); ?> href="<?php the_permalink(); ?>"><i></i></a>
                                        </figure>
                                                        <?php if ($cs_node->var_pb_course_view == 'flat') { ?>
                                            <a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php _e('Apply Now', 'LMS'); ?></a>

                                                            <?php echo '</div>';
                                                        }
                                                    }
                                                    ?>

                                                    <?php if ($cs_node->var_pb_course_view != 'unique') { ?>
                                        <div class="text-section">
                                            <div class="cs-top-sec">
                                                <div class="seideleft">
                                                    <?php } ?>
                                                <div class="left_position">
                                                    <?php
                                                    $headingTypeStart = '<h2>';
                                                    $headingTypeEnd = '</h2>';
                                                    if ($cs_node->var_pb_course_view == 'minimal') {
                                                        $headingTypeStart = '<h5>';
                                                        $headingTypeEnd = '</h5>';
                                                    } else {
                                                        $headingTypeStart = '<h2>';
                                                        $headingTypeEnd = '</h2>';
                                                    }

                                                    echo balanceTags($headingTypeStart, false);
                                                    ?>
                                                    <a href="<?php the_permalink(); ?>" class="colrhvr">
                                                    <?php if ($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider') 
                                                        { ?>
                                                        <?php echo substr(get_the_title(), 0, $title_limit);
                                                        if (strlen(get_the_title()) > $title_limit) {
                                                            echo '...';
                                                        } ?>
                                                    <?php
                                                    } else {
                                                        echo get_the_title();
                                                    }
                                                    ?>
                                                    </a>
                                                        <?php
                                                        echo balanceTags($headingTypeEnd, false);

                                                        if ($cs_node->var_pb_course_view != 'minimal') {

                                                            $reviews_args = array(
                                                                'posts_per_page' => "-1",
                                                                'post_type' => 'cs-reviews',
                                                                'post_status' => 'publish',
                                                                'meta_key' => 'cs_reviews_course',
                                                                'meta_value' => $post->ID,
                                                                'meta_compare' => "=",
                                                                'orderby' => 'meta_value',
                                                                'order' => 'ASC',
                                                            );
                                                            $reviews_query = new WP_Query($reviews_args);
                                                            $reviews_count = $reviews_query->post_count;
                                                            $var_cp_rating = 0;
                                                            if ($reviews_query->have_posts() <> "") {
                                                                while ($reviews_query->have_posts()): $reviews_query->the_post();
                                                                    $var_cp_rating = $var_cp_rating + get_post_meta($post->ID, "cs_reviews_rating", true);
                                                                endwhile;
                                                            }
                                                            wp_reset_postdata();
                                                            if ($var_cp_rating) {
                                                                $var_cp_rating = $var_cp_rating / $reviews_count;
                                                            }
                                                            ?>
                                                            <?php
                                                            if (( $cs_node->var_pb_course_view != 'unique')) {
                                                                if (( $cs_node->var_pb_course_view == 'list' || $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider' || $cs_node->var_pb_course_view == 'flat')) {

                                                                    if (isset($reviews_count) && $reviews_count <> '' && $reviews_count > 0) {
                                                                        echo '<ul class="listoption">';
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                <ul class="listoption">
                                                                <?php } ?>
                                                                <?php
                                                                if ($cs_node->var_pb_course_view == 'flat') {
                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'grid-slider') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'list') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'big') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                    if (function_exists('cs_get_course_instructor')) {
                                                                        cs_get_course_instructor($cs_xmlObject);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'flat-grid') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'plain') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                    if (function_exists('cs_get_course_instructor')) {
                                                                        cs_get_course_instructor($cs_xmlObject);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'timeline') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                    if (function_exists('cs_get_course_instructor')) {
                                                                        cs_get_course_instructor($cs_xmlObject);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'classic') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                    if (function_exists('cs_get_course_instructor')) {
                                                                        cs_get_course_instructor($cs_xmlObject);
                                                                    }
                                                                } else if ($cs_node->var_pb_course_view == 'modren') {

                                                                    if (function_exists('cs_get_course_reviews')) {
                                                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                                                    }
                                                                    if (function_exists('cs_get_course_instructor')) {
                                                                        cs_get_course_instructor($cs_xmlObject);
                                                                    }
                                                                }
                                                                ?>

                                                    <?php
                                                    if (( $cs_node->var_pb_course_view == 'list' || $cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'flat-grid' || $cs_node->var_pb_course_view == 'grid-slider' || $cs_node->var_pb_course_view == 'flat')) {

                                                        if (isset($reviews_count) && $reviews_count <> '' && $reviews_count > 0) {
                                                            echo '</ul>';
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                            <?php } else { ?>
                                                                </ul>
                                                            <?php }
                                                        } ?>

                                                        <?php if ($cs_node->var_pb_course_view == 'list') { ?>
                                                            <div  class="listoption">
                                                                <ul>
                                                            <?php
                                                            if (function_exists('cs_get_course_instructor')) {
                                                                cs_get_course_instructor($cs_xmlObject);
                                                            }
                                                            if (function_exists('cs_get_course_members')) {
                                                                cs_get_course_members($course_post_id);
                                                            }
                                                            if (function_exists('cs_get_course_lessons')) {
                                                                cs_get_course_lessons($cs_xmlObject);
                                                            }
                                                            ?>
                                                                </ul>
                                                            </div>
                                                        <?php } ?>

                                                    </div>

                                                        <?php if ($cs_node->var_pb_course_view != 'unique') { ?> </div><?php } ?>

                                                        <?php if ($cs_node->var_pb_course_view == 'timeline') { ?>
                                                    <div class="cs-cat-list">
                                                        <ul>
                                                        <?php
                                                        if (function_exists('cs_get_course_price')) {
                                                            cs_get_course_price($course_post_id, $var_cp_course_paid);
                                                        }
                                                        if (function_exists('cs_get_course_members')) {
                                                            cs_get_course_members($course_post_id);
                                                        }
                                                        if (function_exists('cs_get_course_lessons')) {
                                                            cs_get_course_lessons($cs_xmlObject);
                                                        }
                                                        ?>	
                                                        </ul>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($cs_node->var_pb_course_view == 'unique') { ?>
                                                    <div class="cr-unique">
                                                        <div  class="listoption">
                                                            <ul>
                                                    <?php
                                                    if (function_exists('cs_get_course_instructor')) {
                                                        cs_get_course_instructor($cs_xmlObject);
                                                    }
                                                    if (function_exists('cs_get_course_members')) {
                                                        cs_get_course_members($course_post_id);
                                                    }
                                                    ?>	
                                                            </ul>
                                                        </div>
                                        <?php } ?>

                                        <?php if ($cs_node->var_pb_course_view != 'flat' && $cs_node->var_pb_course_view != 'unique') { ?> </div><?php } ?>
                                        <?php if ($cs_node->var_pb_course_view <> 'timeline' && $cs_node->var_pb_course_view <> 'list' && $cs_node->var_pb_course_view <> 'three-column' && $cs_node->var_pb_course_view <> 'four-column' && $cs_node->var_pb_course_view <> 'unique' && $cs_node->var_pb_course_view <> 'modren' && $cs_node->var_pb_course_view <> 'grid-slider') { ?>
                                                    <div class="cs-peragraph">
                                                        <p><?php echo esc_attr($excerpt); ?></p> 
                                                    </div>
                                <?php } ?>

                                <?php if ($cs_node->var_pb_course_view != 'big' && $cs_node->var_pb_course_view != 'flat-grid' && $cs_node->var_pb_course_view != 'timeline') { ?>

                                <?php
                                if (( $cs_node->var_pb_course_view == 'unique')) {

                                    if (isset($reviews_count) && $reviews_count <> '' && $reviews_count > 0) {
                                        echo ' <div class="cs-cat-list">';
                                    } else {
                                        echo '';
                                    }
                                } else {
                                    ?>
                                                        <div class="cs-cat-list">
                                <?php } ?>
                                                        <ul>
                                <?php
                                if ($cs_node->var_pb_course_view == 'unique') {
                                    if (function_exists('cs_get_course_reviews')) {
                                        cs_get_course_reviews($reviews_count, $var_cp_rating);
                                    }
                                } else if ($cs_node->var_pb_course_view == 'flat') {
                                    if (function_exists('cs_get_course_instructor')) {
                                        cs_get_course_instructor($cs_xmlObject);
                                    }
                                    if (function_exists('cs_get_course_members')) {
                                        cs_get_course_members($course_post_id);
                                    }
                                    if (function_exists('cs_get_course_lessons')) {
                                        cs_get_course_lessons($cs_xmlObject);
                                    }
                                } else if ($cs_node->var_pb_course_view == 'plain' || $cs_node->var_pb_course_view == 'classic') {
                                    if (function_exists('cs_get_course_price')) {
                                        cs_get_course_price($course_post_id, $var_cp_course_paid);
                                    }
                                    if (function_exists('cs_get_course_members')) {
                                        cs_get_course_members($course_post_id);
                                    }
                                    if (function_exists('cs_get_course_lessons')) {
                                        cs_get_course_lessons($cs_xmlObject);
                                    }
                                } else if ($cs_node->var_pb_course_view == 'three-column' || $cs_node->var_pb_course_view == 'four-column' || $cs_node->var_pb_course_view == 'grid-slider') {

                                    if (function_exists('cs_get_course_lessons')) {
                                        cs_get_course_lessons($cs_xmlObject);
                                    }
                                    if (function_exists('cs_get_course_price')) {
                                        cs_get_course_price($course_post_id, $var_cp_course_paid);
                                    }
                                } else if ($cs_node->var_pb_course_view == 'modren') {

                                    if (function_exists('cs_get_course_price')) {
                                        cs_get_course_price($course_post_id, $var_cp_course_paid);
                                    }
                                    if (function_exists('cs_get_course_members')) {
                                        cs_get_course_members($course_post_id);
                                    }
                                    if (function_exists('cs_get_course_lessons')) {
                                        cs_get_course_lessons($cs_xmlObject);
                                    }
                                } else if ($cs_node->var_pb_course_view == 'list') {

                                    if (function_exists('cs_get_course_price')) {
                                        cs_get_course_price($course_post_id, $var_cp_course_paid);
                                    }
                                }
                                ?>
                                                        </ul>
                        <?php if (isset($add_to_cart_url) && $add_to_cart_url <> '' && $cs_node->var_pb_course_view == 'list') { ?>
                                                            <a href="<?php echo the_permalink(); ?>" class="custom-btn"><i class="fa fa-file-text"></i> <?php _e('Apply Now', 'LMS'); ?></a>
                        <?php } ?>

                        <?php
                        if ($cs_node->var_pb_course_view == 'unique') {

                            if (isset($reviews_count) && $reviews_count <> '' && $reviews_count > 0) {
                                echo '</div>';
                            } else {
                                echo '';
                            }
                            ?>
                        <?php } else { ?>
                                                        </div>
                        <?php } ?>


                    <?php } ?>
                    <?php if ($cs_node->var_pb_course_view == 'unique') { ?> </div><?php } ?>
                    <?php if ($cs_node->var_pb_course_view == 'flat') { ?> </div><?php } ?>
                    <?php if ($cs_node->var_pb_course_view == 'big') { ?>
                                            <ul class="cr-listing">
                        <?php echo cs_get_course_price($course_post_id, $var_cp_course_paid); ?>
                                                <li><a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php _e('Apply Now', 'LMS'); ?></a>
                                                </li>
                                            </ul>
                    <?php }
                    if ($cs_node->var_pb_course_view != 'list' && $cs_node->var_pb_course_view != 'big' && $cs_node->var_pb_course_view != 'flat' && $cs_node->var_pb_course_view != 'unique') {
                        global $cs_theme_options, $wpdb;
                        ?>
                                            <a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i><?php _e('Apply Now', 'LMS'); ?></a>
                    <?php }
                } ?>

                <?php if ($cs_node->var_pb_course_view != 'unique') { ?> </div>

                <?php
                }
                echo balanceTags($timeline_html_end, false);
                ?>
                            </article>
                        </div>
                <?php
            endwhile;

            if ($cs_node->var_pb_course_view == 'grid-slider') {

                echo '</div>';
                if ($moreCourses && ( $cs_node->var_pb_course_cat != '0' && $cs_node->var_pb_course_cat != '' )) {
                    ?> 
                            <div class="course-more col-md-12 <?php echo esc_attr($cs_course_animation); ?>">
                                <a href="<?php echo esc_url(home_url()); ?>/course-category/<?php echo esc_html($row_cat->slug); ?>"><?php _e('View More Courses', 'LMS'); ?></a>
                            </div>
                <?php } ?>

            <?php
            }

            if ($cs_node->var_pb_course_view != 'grid-slider') {
                $qrystr = '';
                if ($cs_node->var_pb_course_pagination == "Show Pagination" and $count_post > $cs_node->var_pb_course_per_page and $cs_node->var_pb_course_per_page > 0) {
                    if (isset($_GET['page_id']))
                        $qrystr = "&page_id=" . absint($_GET['page_id']);
                    if (function_exists('cs_pagination')) {
                        echo cs_pagination($count_post, esc_attr($cs_node->var_pb_course_per_page), $qrystr);
                    }
                }
            }
        } else {
            ?> 
                    <div class="col-md-12"><?php _e('No Course Found', 'LMS'); ?></div>
        <?php } ?> 
            </div>
        <?php
        $post_data = ob_get_clean();
        return $post_data;
    }

    add_shortcode('cs_course', 'cs_course_shortcode');
}
//Get Twitter Tweets  Start