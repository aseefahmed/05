<?php
/**
 * Widgets Classes & Functions
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
/**
 * @Facebook widget Class
 */
if (!class_exists('facebook_module')) {

    class facebook_module extends WP_Widget {
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */

        /**
         * @Facebook Module
         *
         *
         */
        public function __construct() {

            parent::__construct(
                    'facebook_module', // Base ID
                    __('CS : Facebook', 'logistic'), // Name
                    array('classname' => 'facebok_widget', 'description' => esc_html__('Facebook widget like box total customized with theme.', 'logistic'),) // Args
            );
        }

        /**
         * @Facebook html Form
         *
         *
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $pageurl = isset($instance['pageurl']) ? esc_attr($instance['pageurl']) : '';
            $showfaces = isset($instance['showfaces']) ? esc_attr($instance['showfaces']) : '';
            $showstream = isset($instance['showstream']) ? esc_attr($instance['showstream']) : '';
            $showheader = isset($instance['showheader']) ? esc_attr($instance['showheader']) : '';
            $fb_bg_color = isset($instance['fb_bg_color']) ? esc_attr($instance['fb_bg_color']) : '';
            $likebox_height = isset($instance['likebox_height']) ? esc_attr($instance['likebox_height']) : '';


            $width = isset($instance['width']) ? esc_attr($instance['width']) : '';
            $hide_cover = isset($instance['hide_cover']) ? esc_attr($instance['hide_cover']) : '';
            $show_posts = isset($instance['show_posts']) ? esc_attr($instance['show_posts']) : '';
            $hide_cta = isset($instance['hide_cta']) ? esc_attr($instance['hide_cta']) : '';
            $small_header = isset($instance['small_header']) ? esc_attr($instance['small_header']) : '';
            $adapt_container_width = isset($instance['adapt_container_width']) ? esc_attr($instance['adapt_container_width']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'logistic'); ?>
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size='40' name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('pageurl')); ?>"><?php esc_html_e('Page Url', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('pageurl')); ?>" size='40' name="<?php echo esc_attr($this->get_field_name('pageurl')); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
                    <br />
                    <small><?php esc_html_e('Please enter your page or User profile url example:L', 'logistic'); ?> http://www.facebook.com/profilename OR <br />
                        https://www.facebook.com/pages/wxyz/123456789101112 </small><br />
                </label>
            </p>


            <p>
                <label for="<?php echo cs_allow_special_char($this->get_field_id('fb_bg_color')); ?>"><?php esc_html_e('Background Color', 'logistic'); ?> 
                    <input type="text" name="<?php echo cs_allow_special_char($this->get_field_name('fb_bg_color')); ?>" size='4' id="<?php echo cs_allow_special_char($this->get_field_id('fb_bg_color')); ?>"  value="<?php if (!empty($fb_bg_color)) {
                echo cs_allow_special_char($fb_bg_color);
            }
            ?>" class="fb_bg_color upcoming"  />
                </label>
            </p>   

            <p>
                <label for="<?php echo cs_allow_special_char($this->get_field_id('width')); ?>"><?php esc_html_e('width', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('width')); ?>" size='2' name="<?php echo cs_allow_special_char($this->get_field_name('width')); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo cs_allow_special_char($this->get_field_id('likebox_height')); ?>"><?php esc_html_e('Like Box Height', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('likebox_height')); ?>" size='2' name="<?php echo cs_allow_special_char($this->get_field_name('likebox_height')); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('hide_cover')); ?>"><?php esc_html_e('Hide Cover', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('hide_cover')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_cover')); ?>" type="checkbox" <?php if (esc_attr($hide_cover) != '') {
                   echo 'checked';
               } ?> />
                </label>
            </p>


            <p>
                <label for="<?php echo esc_attr($this->get_field_id('showfaces')); ?>"><?php esc_html_e('Show Faces', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showfaces')); ?>" name="<?php echo esc_attr($this->get_field_name('showfaces')); ?>" type="checkbox" <?php if (esc_attr($showfaces) != '') {
                   echo 'checked';
               } ?> />
                </label>
            </p>


            <p>
                <label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>"><?php esc_html_e('Show Posts', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('show_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_posts')); ?>" type="checkbox" <?php if (esc_attr($show_posts) != '') {
                   echo 'checked';
               } ?> />
                </label>
            </p>


            <p>
                <label for="<?php echo esc_attr($this->get_field_id('hide_cta')); ?>"><?php esc_html_e('Hide Cta', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('hide_cta')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_cta')); ?>" type="checkbox" <?php if (esc_attr($hide_cta) != '') {
                   echo 'checked';
               } ?> />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('small_header')); ?>"><?php esc_html_e('Small Header', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('small_header')); ?>" name="<?php echo esc_attr($this->get_field_name('small_header')); ?>" type="checkbox" <?php if (esc_attr($small_header) != '') {
                   echo 'checked';
               } ?> />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('adapt_container_width')); ?>"><?php esc_html_e('Adapt width', 'logistic'); ?> 
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('adapt_container_width')); ?>" name="<?php echo esc_attr($this->get_field_name('adapt_container_width')); ?>" type="checkbox" <?php if (esc_attr($adapt_container_width) != '') {
                echo 'checked';
            } ?> />
                </label>
            </p>

            <?php
        }

        /**
         * @Facebook Update Form Data
         *
         *
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['pageurl'] = $new_instance['pageurl'];
            $instance['showfaces'] = $new_instance['showfaces'];
            $instance['showstream'] = $new_instance['showstream'];
            $instance['showheader'] = $new_instance['showheader'];
            $instance['fb_bg_color'] = $new_instance['fb_bg_color'];
            $instance['likebox_height'] = $new_instance['likebox_height'];

            $instance['width'] = $new_instance['width'];
            $instance['hide_cover'] = $new_instance['hide_cover'];
            $instance['show_posts'] = $new_instance['show_posts'];
            $instance['hide_cta'] = $new_instance['hide_cta'];
            $instance['small_header'] = $new_instance['small_header'];
            $instance['adapt_container_width'] = $new_instance['adapt_container_width'];


            return $instance;
        }

        /**
         * @Facebook Widget Display
         *
         *
         */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));
            $pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
            $showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
            $showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
            $showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
            $fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);
            $likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);

            $width = empty($instance['width']) ? ' ' : apply_filters('widget_title', $instance['width']);
            $hide_cover = empty($instance['hide_cover']) ? ' ' : apply_filters('widget_title', $instance['hide_cover']);
            $show_posts = empty($instance['show_posts']) ? ' ' : apply_filters('widget_title', $instance['show_posts']);
            $hide_cta = empty($instance['hide_cta']) ? ' ' : apply_filters('widget_title', $instance['hide_cta']);
            $small_header = empty($instance['small_header']) ? ' ' : apply_filters('widget_title', $instance['small_header']);
            $adapt_container_width = empty($instance['adapt_container_width']) ? ' ' : apply_filters('widget_title', $instance['adapt_container_width']);


            if (isset($showfaces) AND $showfaces == 'on') {
                $showfaces = 'true';
            } else {
                $showfaces = 'false';
            }
            if (isset($showstream) AND $showstream == 'on') {
                $showstream = 'true';
            } else {
                $showstream = 'false';
            }

            if (isset($hide_cover) AND $hide_cover == 'on') {
                $hide_cover = 'true';
            } else {
                $hide_cover = 'false';
            }
            if (isset($show_posts) AND $show_posts == 'on') {
                $show_posts = 'true';
            } else {
                $show_posts = 'false';
            }
            if (isset($hide_cta) AND $hide_cta == 'on') {
                $hide_cta = 'true';
            } else {
                $hide_cta = 'false';
            }
            if (isset($small_header) AND $small_header == 'on') {
                $small_header = 'true';
            } else {
                $small_header = 'false';
            }
            if (isset($adapt_container_width) AND $adapt_container_width == 'on') {
                $adapt_container_width = 'true';
            } else {
                $adapt_container_width = 'false';
            }


            echo cs_allow_special_char($before_widget);
            ?>
            <style scoped>
                .facebookOuter {background-color:<?php echo cs_allow_special_char($fb_bg_color); ?>; width:100%;padding:0;float:left;}
                .facebookInner {float: left; width: 100%;}
                .facebook_module, .fb_iframe_widget > span, .fb_iframe_widget > span > iframe { width: 100% !important;}
                .fb_iframe_widget, .fb-like-box div span iframe { width: 100% !important; float: left;}
            </style>
            <?php
            if (!empty($title) && $title <> ' ') {
                echo cs_allow_special_char($before_title);
                echo cs_allow_special_char($title);
                echo cs_allow_special_char($after_title);
            }
            global $wpdb, $post;
            ?>		

            <div id="fb-root"></div>
            <script>(function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>

            <?php
            $output = '';
            $output .= '<div style="background:' . esc_attr($instance['fb_bg_color']) . ';" class="fb-like-box" ';
            $output .= ' data-href="' . esc_url($pageurl) . '"';
            $output .= ' data-width="' . $width . '" ';
            $output .= ' data-height="' . $likebox_height . '" ';
            $output .= ' data-hide-cover="' . $hide_cover . '" ';
            $output .= ' data-show-facepile="' . $showfaces . '" ';
            $output .= ' data-show-posts="' . $show_posts . '">';
            $output .= ' </div>';
            echo cs_allow_special_char($output);

            echo cs_allow_special_char($after_widget);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("facebook_module");'));

/**
 * @Social Network widget Class
 */
if (!class_exists('cs_social_network_widget')) {

    class cs_social_network_widget extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @Social Network Module
         */
        public function __construct() {

            parent::__construct(
                    'cs_social_network_widget', // Base ID
                    __('CS : Social Newtork', 'directory'), // Name
                    array('classname' => 'widget-socialnetwork', 'description' => 'Social Newtork widget',) // Args
            );
        }

        /**
         * @Social Network html form
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size='40' name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <?php
        }

        /**
         * @Social Network Update from data 
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            return $instance;
        }

        /**
         * @Social Network Widget
         */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            echo balanceTags($before_widget, false);

            if (!empty($title) && $title <> ' ') {
                echo balanceTags($before_title, false);
                echo esc_attr($title);
                echo balanceTags($after_title, false);
            }
            global $wpdb, $post;
            echo '<div class="followus">';
            cs_social_network_widget();
            echo '</div>';
            echo balanceTags($after_widget, false);
        }

    }

}
//add_action( 'widgets_init', create_function('', 'return register_widget("cs_social_network_widget");') );


/**
 * @Flickr widget Class
 */
if (!class_exists('cs_flickr')) {

    class cs_flickr extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @init Flickr Module
         */
        public function __construct() {

            parent::__construct(
                    'cs_flickr', // Base ID
                    __('CS : Flickr Gallery', 'directory'), // Name
                    array('classname' => 'cs-fancy-widget-flickr widget_gallery', 'description' => 'Type a user name to show photos in widget',) // Args
            );
        }

        /**
         * @Flickr html form
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $username = isset($instance['username']) ? esc_attr($instance['username']) : '';
            $no_of_photos = isset($instance['no_of_photos']) ? esc_attr($instance['no_of_photos']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('username')); ?>"> Flickr username:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('username')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('no_of_photos')); ?>"> Number of Photos:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('no_of_photos')); ?>" size='2' name="<?php echo esc_attr($this->get_field_name('no_of_photos')); ?>" type="text" value="<?php echo intval($no_of_photos); ?>" />
                </label>
            </p>
            <?php
        }

        /**
         * @Flickr update form data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['username'] = $new_instance['username'];
            $instance['no_of_photos'] = $new_instance['no_of_photos'];

            return $instance;
        }

        /**
         * @Display Flickr widget
         */
        function widget($args, $instance) {
            global $cs_theme_options;

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $username = empty($instance['username']) ? ' ' : apply_filters('widget_title', $instance['username']);
            $no_of_photos = empty($instance['no_of_photos']) ? ' ' : apply_filters('widget_title', $instance['no_of_photos']);
            if ($instance['no_of_photos'] == "") {
                $instance['no_of_photos'] = '3';
            }

            echo balanceTags($before_widget, false);

            if (!empty($title) && $title <> ' ') {
                echo balanceTags($before_title, false);
                echo esc_attr($title);
                echo balanceTags($after_title, false);
            }

            $get_flickr_array = array();

            $apiKey = $cs_theme_options['flickr_key'];
            $apiSecret = $cs_theme_options['flickr_secret'];

            if ($apiKey <> '') {

                // Getting transient
                $cachetime = 86400;
                $transient = 'flickr_gallery_data';
                $check_transient = get_transient($transient);

                // Get Flickr Gallery saved data
                $saved_data = get_option('flickr_gallery_data');

                $db_apiKey = '';
                $db_user_name = '';
                $db_total_photos = '';

                if ($saved_data <> '') {
                    $db_apiKey = isset($saved_data['api_key']) ? $saved_data['api_key'] : '';
                    $db_user_name = isset($saved_data['user_name']) ? $saved_data['user_name'] : '';
                    $db_total_photos = isset($saved_data['total_photos']) ? $saved_data['total_photos'] : '';
                }


                if ($check_transient === false || ($apiKey <> $db_apiKey || $username <> $db_user_name || $no_of_photos <> $db_total_photos)) {

                    $user_id = "https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=" . $apiKey . "&username=" . $username . "&format=json&nojsoncallback=1";
                    $response = wp_remote_get(esc_url_raw($user_id));
                    $user_info = json_decode(wp_remote_retrieve_body($response), true);
                    if ($user_info['stat'] == 'ok') {

                        $user_get_id = $user_info['user']['id'];

                        $get_flickr_array['api_key'] = $apiKey;
                        $get_flickr_array['user_name'] = $username;
                        $get_flickr_array['user_id'] = $user_get_id;

                        $url = "https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=" . $apiKey . "&user_id=" . $user_get_id . "&per_page=" . $no_of_photos . "&format=json&nojsoncallback=1";

                        $response = wp_remote_get(esc_url_raw($url));
                        $content = json_decode(wp_remote_retrieve_body($response), true);
                        if ($content['stat'] == 'ok') {
                            $counter = 0;
                            echo '<ul class="gallery-list">';
                            foreach ((array) $content['photos']['photo'] as $photo) {

                                $image_file = "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_s.jpg";

                                $img_headers = get_headers($image_file);
                                if (strpos($img_headers[0], '200') !== false) {

                                    $image_file = $image_file;
                                } else {
                                    $image_file = "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_q.jpg";
                                    $img_headers = get_headers($image_file);
                                    if (strpos($img_headers[0], '200') !== false) {

                                        $image_file = $image_file;
                                    } else {
                                        $image_file = get_template_directory_uri() . '/assets/images/no_image_thumb.jpg';
                                    }
                                }

                                echo '<li>';
                                echo "<a target='_blank' title='" . $photo['title'] . "' href='https://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
                                echo "<img alt='" . $photo['title'] . "' src='" . $image_file . "'>";
                                echo "</a>";
                                echo '</li>';

                                $counter++;

                                $get_flickr_array['photo_src'][] = $image_file;
                                $get_flickr_array['photo_title'][] = $photo['title'];
                                $get_flickr_array['photo_owner'][] = $photo['owner'];
                                $get_flickr_array['photo_id'][] = $photo['id'];
                            }
                            echo '</ul>';

                            $get_flickr_array['total_photos'] = $counter;

                            // Setting Transient
                            set_transient($transient, true, $cachetime);
                            update_option('flickr_gallery_data', $get_flickr_array);

                            if ($counter == 0)
                                _e('No result found.', 'pc');
                        }

                        else {
                            echo 'Error:' . $content['code'] . ' - ' . $content['message'];
                        }
                    } else {
                        echo 'Error:' . $user_info['code'] . ' - ' . $user_info['message'];
                    }
                } else {
                    if (get_option('flickr_gallery_data') <> '') {

                        $flick_data = get_option('flickr_gallery_data');
                        echo '<ul class="gallery-list">';
                        if (isset($flick_data['photo_src'])):
                            $i = 0;
                            foreach ($flick_data['photo_src'] as $ph) {
                                echo '<li>';
                                echo "<a target='_blank' title='" . $flick_data['photo_title'][$i] . "' href='https://www.flickr.com/photos/" . $flick_data['photo_owner'][$i] . "/" . $flick_data['photo_id'][$i] . "/'>";
                                echo "<img alt='" . $flick_data['photo_title'][$i] . "' src='" . $flick_data['photo_src'][$i] . "'>";
                                echo "</a>";
                                echo '</li>';
                                $i++;
                            }
                        endif;
                        echo '</ul>';
                    } else {
                        _e('No result found.', 'pc');
                    }
                }
            } else {
                _e('Please Enter Flickr API key from Theme Options.', 'LMS');
            }
            echo balanceTags($after_widget, false);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("cs_flickr");'));


/**
 * @Recent posts widget Class
 */
if (!class_exists('recentposts')) {

    class recentposts extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @init Recent posts Module
         */
        public function __construct() {

            parent::__construct(
                    'recentposts', // Base ID
                    __('CS : Recent Posts', 'directory'), // Name
                    array('classname' => 'widget-recent-blog', 'description' => 'Recent Posts from category',) // Args
            );
        }

        /**
         * @Recent posts html form
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $select_category = isset($instance['select_category']) ? esc_attr($instance['select_category']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            $thumb = isset($instance['thumb']) ? esc_attr($instance['thumb']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('select_category')); ?>"> Select Category:
                    <select id="<?php echo esc_attr($this->get_field_id('select_category')); ?>" name="<?php echo esc_attr($this->get_field_name('select_category')); ?>" style="width:225px">
                        <option value="" >All</option>
            <?php
            $categories = get_categories();
            if ($categories <> "") {
                foreach ($categories as $category) {
                    ?>
                                <option <?php if ($select_category == $category->slug) {
                        echo 'selected';
                    } ?> value="<?php echo esc_attr($category->slug); ?>" ><?php echo esc_attr($category->name); ?></option>
                    <?php
                }
            }
            ?>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('showcount')); ?>"> Number of Posts To Display:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showcount')); ?>" size='2' name="<?php echo esc_attr($this->get_field_name('showcount')); ?>" type="text" value="<?php echo intval($showcount); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('thumb')); ?>"> Display Thumbinals:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('thumb')); ?>" size='2' name="<?php echo esc_attr($this->get_field_name('thumb')); ?>" value="true" type="checkbox"  <?php if (isset($instance['thumb']) && $instance['thumb'] == 'true') echo 'checked="checked"'; ?> />
                </label>
            </p>
            <?php
        }

        /**
         * @Recent posts update form data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['select_category'] = $new_instance['select_category'];
            $instance['showcount'] = $new_instance['showcount'];
            $instance['thumb'] = $new_instance['thumb'];

            return $instance;
        }

        /**
         * @Display Recent posts widget
         */
        function widget($args, $instance) {
            global $cs_theme_options, $cs_node;

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);
            $showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);

            $thumb = isset($instance['thumb']) ? esc_attr($instance['thumb']) : '';
            if ($instance['showcount'] == "") {
                $instance['showcount'] = '-1';
            }

            echo balanceTags($before_widget, false);

            if (!empty($title) && $title <> ' ') {
                echo balanceTags($before_title, false);
                echo esc_attr($title);
                echo balanceTags($after_title, false);
            }

            global $wpdb, $post;
            ?>
            <?php
            wp_reset_query();

            /**
             * @Display Recent posts
             */
            if (isset($select_category) and $select_category <> ' ' and $select_category <> '') {
                $args = array('posts_per_page' => "$showcount", 'post_type' => 'post', 'category_name' => "$select_category");
            } else {

                $args = array('posts_per_page' => 2, 'post_type' => 'post', 'ignore_sticky_posts' => 1);
            }

            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts() <> "") {
                echo '<ul>';
                while ($custom_query->have_posts()) : $custom_query->the_post();
                    $post_xml = get_post_meta($post->ID, "post", true);
                    $cs_xmlObject = new stdClass();
                    if ($post_xml <> "") {
                        $cs_xmlObject = new SimpleXMLElement($post_xml);
                        $width = 60;
                        $height = 60;
                        $image_url = cs_get_post_img_src($post->ID, $width, $height);
                        if ($image_url == '') {
                            $cs_noimage = 'cs-noimage';
                        } else {
                            $cs_noimage = '';
                        }
                    }//43
                    ?>
                    <li class="<?php echo esc_attr($cs_noimage); ?>">
                        <div class="time-sec">
                            <time datetime="<?php echo date_i18n('Y-m-d', strtotime(get_the_date())); ?>"><?php echo date_i18n(get_option('date_format'), strtotime(get_the_date())); ?></time>

                            <span> <?php _e('By', 'LMS'); ?> <?php printf(__('%s', 'LMS'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" >' . get_the_author() . '</a>'); ?></span>
                        </div>
                        <div class="recent-inn">
                    <?php
                    if ($thumb == "true") {
                        if ($image_url <> '') {
                            echo "<figure><img src='" . $image_url . "' alt=''><a href='" . get_the_permalink() . "' class='hover-btn'><i></i></a></figure>";
                        }
                    }
                    ?>
                            <div class="infotext"> <a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(), 0, 26);
                    if (strlen(get_the_title()) > 26) echo "..."; ?></a> </div>
                        </div>

                    </li>

                <?php endwhile; ?>
                </ul>

                <?php
            }
            else {
                if (function_exists('fnc_no_result_found')) {
                    fnc_no_result_found(false);
                }
            }
            ?>
            <?php
            echo balanceTags($after_widget, false);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("recentposts");'));


/**
 * @Twitter Tweets widget Class
 */
if (!class_exists('cs_twitter_widget')) {

    class cs_twitter_widget extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @init Twitter Module
         */
        public function __construct() {

            parent::__construct(
                    'cs_twitter_widget', // Base ID
                    __('CS : Twitter Widget', 'edulms'), // Name
                    array('classname' => 'cs_twitter_widget', 'description' => 'Twitter Widget',) // Args
            );
        }

        /**
         * @Twitter html form
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $username = isset($instance['username']) ? esc_attr($instance['username']) : '';
            $numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';
            ?>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <span>Title: </span>
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
            <label for="screen_name">User Name<span class="required">(*)</span>: </label>
            <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('username')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            <label for="tweet_count">
                <span>Num of Tweets: </span>
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('numoftweets')); ?>" size="2" name="<?php echo esc_attr($this->get_field_name('numoftweets')); ?>" type="text" value="<?php echo intval($numoftweets); ?>" />
                <div class="clear"></div>
            </label>
            <?php
        }

        /**
         * @Twitter update form data 
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['username'] = $new_instance['username'];
            $instance['numoftweets'] = $new_instance['numoftweets'];

            return $instance;
        }

        //Updated Widget
        function widget($args, $instance) {
            global $cs_theme_options, $cs_twitter_arg;
            $cs_twitter_api_switch = isset($cs_theme_options['cs_twitter_api_switch']) ? $cs_theme_options['cs_twitter_api_switch'] : '';
            $cs_twitter_arg['consumerkey'] = isset($cs_theme_options['cs_consumer_key']) ? $cs_theme_options['cs_consumer_key'] : '';
            $cs_twitter_arg['consumersecret'] = isset($cs_theme_options['cs_consumer_secret']) ? $cs_theme_options['cs_consumer_secret'] : '';
            $cs_twitter_arg['accesstoken'] = isset($cs_theme_options['cs_access_token']) ? $cs_theme_options['cs_access_token'] : '';
            $cs_twitter_arg['accesstokensecret'] = isset($cs_theme_options['cs_access_token_secret']) ? $cs_theme_options['cs_access_token_secret'] : '';
            $cs_cache_limit_time = isset($cs_theme_options['cs_cache_limit_time']) ? $cs_theme_options['cs_cache_limit_time'] : '';
            $cs_tweet_num_from_twitter = isset($cs_theme_options['cs_tweet_num_post']) ? $cs_theme_options['cs_tweet_num_post'] : '';
            $cs_twitter_datetime_formate = isset($cs_theme_options['cs_twitter_datetime_formate']);

            if ($cs_cache_limit_time == '') {
                $cs_cache_limit_time = 60;
            }
            if ($cs_twitter_datetime_formate == '') {
                $cs_twitter_datetime_formate = 'time_since';
            }
            if ($cs_tweet_num_from_twitter == '') {
                $cs_tweet_num_from_twitter = 5;
            }
            if ($cs_twitter_api_switch == 'on') {
                extract($args, EXTR_SKIP);
                $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
                $title = htmlspecialchars_decode(stripslashes($title));
                $username = $instance['username'];
                $numoftweets = $instance['numoftweets'];
                if ($numoftweets == '') {
                    $numoftweets = 2;
                }
                echo cs_allow_special_char($before_widget);
                // WIDGET display CODE Start
                if (!empty($title) && $title <> ' ') {
                    echo cs_allow_special_char($before_title . $title . $after_title);
                }
                if (strlen($username) > 1) {

                    if ($cs_twitter_arg['consumerkey'] <> '' && $cs_twitter_arg['consumersecret'] <> '' && $cs_twitter_arg['accesstoken'] <> '' && $cs_twitter_arg['accesstokensecret'] <> '') {
                        require_once get_template_directory() . '/include/theme-components/cs-twitter/display-tweets.php';
                        display_tweets($username, $cs_twitter_datetime_formate, $cs_tweet_num_from_twitter, $numoftweets, $cs_cache_limit_time);
                    } else {
                        echo '<p>' . __('Please Set Twitter API', 'awaken') . '</p>';
                    }
                }
                echo cs_allow_special_char($after_widget);
            }
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));

/**
 * @Upcoming Events widget Class
 */
if (!class_exists('upcoming_events')) {

    class upcoming_events extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @init Upcoming Events Module
         */
        public function __construct() {

            parent::__construct(
                    'upcoming_events', // Base ID
                    __('CS : Upcoming Events', 'directory'), // Name
                    array('classname' => 'widget-latest-event', 'description' => 'Select Event to show its countdown',) // Args
            );
        }

        /**
         * @Upcoming Events html form 
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => '', 'widget_names_events' => 'new'));
            $title = $instance['title'];
            $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>"> Select Event:
                    <select id="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>" name="<?php echo esc_attr($this->get_field_name('get_post_slug')); ?>" style="width:225px">
                        <option value=""> Select Category</option>
            <?php
            global $wpdb, $post;
            $categories = get_categories('taxonomy=events-categories&child_of=0&hide_empty=0');
            if ($categories != '') {
                
            }
            foreach ($categories as $category) {
                ?>
                            <option <?php if (esc_attr($get_post_slug) == $category->slug) {
                    echo 'selected';
                } ?> value="<?php echo esc_attr($category->slug); ?>" > <?php echo substr($category->name, 0, 20);
                if (strlen($category->name) > 20) echo "..."; ?> </option>
            <?php } ?>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('showcount')); ?>"> Number of Events:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showcount')); ?>" size="2" name="<?php echo esc_attr($this->get_field_name('showcount')); ?>" type="text" value="<?php echo intval($showcount); ?>" />
                </label>
            </p>
            <?php
        }

        /**
         * @Upcoming Events Update data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['get_post_slug'] = $new_instance['get_post_slug'];
            $instance['showcount'] = $new_instance['showcount'];
            return $instance;
        }

        /**
         * @Display Upcoming Events widget
         */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            if (empty($showcount)) {
                $showcount = '4';
            }
            // WIDGET display CODE Start
            echo balanceTags($before_widget, false);
            wp_reset_query();
            if (!empty($title) && $title <> ' ') {
                echo balanceTags($before_title . $title . $after_title, false);
            }
            global $wpdb, $post;
            date_default_timezone_set('UTC');
            $current_time = strtotime(current_time('m/d/Y H:i', $gmt = 0));
            $meta_key = 'cs_dynamic_event_from_date_time';

            $newterm = get_term_by('slug', $get_post_slug, 'events-categories');
            if (isset($get_post_slug) and $get_post_slug <> '') {
                $args = array('posts_per_page' => $showcount, 'post_type' => 'cs-events', 'events-category' => "$get_post_slug", 'meta_key' => $meta_key, 'meta_value' => $current_time, 'meta_compare' => '>', 'post_status' => 'publish', 'orderby' => 'meta_value', 'order' => 'ASC');
            } else {
                $args = array('posts_per_page' => $showcount, 'post_type' => 'cs-events', 'meta_key' => $meta_key, 'meta_value' => $current_time, 'meta_compare' => '>', 'post_status' => 'publish', 'orderby' => 'meta_value', 'order' => 'ASC');
            }
            $custom_query = new WP_Query($args);
            if ($custom_query->have_posts() <> "") {
                $cs_counter_events = 0;
                while ($custom_query->have_posts()): $custom_query->the_post();
                    $cs_counter_events++;
                    $cs_event_from_date = get_post_meta($post->ID, "cs_dynamic_event_from_date_time", true);
                    $year_event = date("Y", $cs_event_from_date);
                    $month_event = date("M", $cs_event_from_date);
                    $day_event = date("d", $cs_event_from_date);
                    $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                    if ($cs_event_meta <> "") {
                        $cs_event_meta = new SimpleXMLElement($cs_event_meta);
                        $event_start_time = $cs_event_meta->event_start_time;
                        $event_end_time = $cs_event_meta->event_end_time;
                    }
                    $cs_event_loc = get_post_meta("$post->ID", "cs_event_loc_meta", true);
                    ?>
                    <article>
                        <div class="calendar-date"> <span><?php echo date_i18n('d', $cs_event_from_date); ?></span> <?php echo date_i18n('M', $cs_event_from_date); ?> </div>
                        <div class="text">
                            <h2 class="cs-post-title"> <a href="<?php echo get_permalink(); ?>" class="cs-colrhvr">
                    <?php
                    echo substr(get_the_title(), 0, 21);
                    if (strlen(get_the_title()) > 21)
                        echo "...";
                    ?>
                                </a> </h2>
                            <ul class="post-options">
                                <li><i class="fa fa-map-marker"></i><?php echo get_the_title((int) $cs_event_meta->event_address); ?></li>
                            </ul>
                        </div>
                    </article>
                    <!-- Events Widget End -->
                            <?php endwhile; ?>
                        <?php
                        }else {
                            fnc_no_result_found(false);
                        }
                        echo balanceTags($after_widget, false);
                    }

                }

            }
//add_action( 'widgets_init', create_function('', 'return register_widget("upcoming_events");') );


            /**
             * @Event Map widget Class
             */
            if (!class_exists('events_map')) {

                class events_map extends WP_Widget {
                    /**
                     * Outputs the content of the widget
                     * @param array $args
                     * @param array $instance
                     */

                    /**
                     * @init Event Map Module
                     */
                    public function __construct() {

                        parent::__construct(
                                'events_map', // Base ID
                                __('CS : Events Map', 'directory'), // Name
                                array('classname' => 'widget-events-map fullwidth', 'description' => 'Select Event to show its countdown',) // Args
                        );
                    }

                    /**
                     * @Event Map html form 
                     */
                    function form($instance) {
                        $instance = wp_parse_args((array) $instance, array('title' => '', 'widget_names_events' => 'new'));
                        $title = $instance['title'];
                        $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
                        $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
                        ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>"> Select Event:
                    <select id="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>" name="<?php echo esc_attr($this->get_field_name('get_post_slug')); ?>" style="width:225px">
                        <option value=""> Select Category</option>
            <?php
            global $wpdb, $post;
            $categories = get_categories('taxonomy=events-categories&child_of=0&hide_empty=0');
            if ($categories != '') {
                
            }
            foreach ($categories as $category) {
                ?>
                            <option <?php if (esc_attr($get_post_slug) == $category->slug) {
                    echo 'selected';
                } ?> value="<?php echo esc_attr($category->slug); ?>" > <?php echo substr($category->name, 0, 20);
                if (strlen($category->name) > 20) echo "..."; ?> </option>
            <?php } ?>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('showcount')); ?>"> Number of Events:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showcount')); ?>" size="2" name="<?php echo esc_attr($this->get_field_name('showcount')); ?>" type="text" value="<?php echo intval($showcount); ?>" />
                </label>
            </p>
            <?php
        }

        /**
         * @Event Map update data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['get_post_slug'] = $new_instance['get_post_slug'];
            $instance['showcount'] = $new_instance['showcount'];
            return $instance;
        }

        /**
         * @Display Event Map widget
         */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            if (empty($showcount)) {
                $showcount = '4';
            }
            echo balanceTags($before_widget, false);
            wp_reset_query();
            if (!empty($title) && $title <> ' ') {
                echo balanceTags($before_title . $title . $after_title, false);
            }
            global $wpdb, $post;
            if ($get_post_slug <> '') {
                $newterm = get_term_by('slug', $get_post_slug, 'events-categories');
                $args = array(
                    'posts_per_page' => $showcount,
                    'post_type' => 'cs-events',
                    'events-categories' => $get_post_slug,
                    'post_status' => 'publish',
                    'order' => 'ASC'
                );
                $custom_query = new WP_Query($args);
                if ($custom_query->have_posts() <> "") {
                    $cs_counter_events = rand(44, 564654654654);
                    while ($custom_query->have_posts()): $custom_query->the_post();
                        $cs_counter_events++;
                        $counter_first = 0;
                        $post_xml = get_post_meta("$post->ID", "dynamic_cusotm_post", true);
                        if ($post_xml <> "") {
                            $cs_xmlObject = new SimpleXMLElement($post_xml);
                            $loc_country = $cs_xmlObject->loc_country;
                            $event_loc_lat = $cs_xmlObject->dynamic_post_location_latitude;
                            $event_loc_long = $cs_xmlObject->dynamic_post_location_longitude;
                            $loc_address = $cs_xmlObject->dynamic_post_location_address;
                        }
                        $event_map_title = get_the_title();
                        if ($event_loc_lat && $event_loc_long && $loc_address) {
                            $map_list .= "{pos:{lat:" . $event_loc_lat . ",lng:" . $event_loc_long . "},address:'" . addslashes($loc_address) . ' ' . addslashes($loc_country) . "',title:'" . addslashes($event_map_title) . "'},";
                        }
                        if ($counter_first == '0') {
                            $event_loc_lat_first = $cs_xmlObject->dynamic_post_location_latitude;
                            $event_loc_long_first = $cs_xmlObject->dynamic_post_location_longitude;
                            $title_first_id = get_the_title();
                            $counter_first++;
                        }
                    endwhile;

                    //$cs_counter_events = rand(44,564654654654);
                    ?>
                    <div class="gigs-area-map" id="gigs-area-map" style="width:300px; height:300px;">
                        <div id="map_canvas_<?php echo intval($cs_counter_events); ?>" style="width:100%;height:100%"></div>
                    </div>
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
                    <script type="text/javascript">
                        var map;
                        var markers = [];
                        var lastinfowindow;
                        var locIndex;
                        //Credit: MDN
                        if (!Array.prototype.forEach) {
                            Array.prototype.forEach = function (fn, scope) {
                                for (var i = 0, len = this.length; i < len; ++i) {
                                    fn.call(scope, this[i], i, this);
                                }
                            }
                        }
                        /*
                         This is the data as a JS array. It could be generated by CF of course. This
                         drives the map and the div on the side.
                         */
                        var data = [<?php echo esc_js($map_list); ?>];
                        //A utility function that translates a given type to an icon
                        function getIcon(type) {
                            switch (type) {
                                // case "pharmacy": return "images/map-marker.png";
                                // case "hospital": return "images/map-marker.png";
                                // case "lab": return "images/map-marker.png";
                                default:
                                    return "<?php echo get_template_directory_uri(); ?>/images/map-marker.png";
                            }
                        }
                        //console.log(results[0].geometry.location.lat()+','+results[0].geometry.location.lng(),mapData.title);
                        function initialize() {
                            var latlng = new google.maps.LatLng(<?php echo esc_js($event_loc_lat_first); ?>,<?php echo esc_js($event_loc_long_first); ?>);
                            var myOptions = {
                                zoom: 4,
                                center: latlng,
                                scrollwheel: true,
                                draggable: true,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                disableDefaultUI: false
                            };
                            map = new google.maps.Map(document.getElementById("map_canvas_<?php echo esc_js($cs_counter_events); ?>"), myOptions);
                            geocoder = new google.maps.Geocoder();
                            data.forEach(function (mapData, idx) {
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: new google.maps.LatLng(mapData.pos.lat, mapData.pos.lng),
                                    title: mapData.title,
                                    icon: getIcon(mapData.type)
                                });
                                var contentHtml = "<div style='width:200px;height:100px'><h3>" + mapData.title + "</h3>" + mapData.address + "</div>";
                                var infowindow = new google.maps.InfoWindow({
                                    content: contentHtml
                                });
                                google.maps.event.addListener(marker, 'click', function () {
                                    infowindow.open(map, marker);
                                });
                                jQuery(".minict_wrapper ul li").live('click', function () {
                                    infowindow.close();
                                });
                                marker.locid = idx + 1;
                                marker.infowindow = infowindow;
                                markers[markers.length] = marker;
                                var sideHtml = '<p class="loc" data-locid="' + marker.locid + '"><b>' + mapData.title + '</b><br/>';
                                sideHtml += mapData.address + '</p>';
                                jQuery("#locs").append(sideHtml);
                                //Are we all done? Not 100% sure of this
                                if (markers.length == data.length)
                                    doFilter();
                            });
                            /*
                             Run on every change to the checkboxes. If you add more checkboxes to the page,
                             we should use a class to make this more specific.
                             */
                            function doFilter() {
                                if (!locIndex) {
                                    locIndex = {};
                                    //I reverse index markers to figure out the position of loc to marker index
                                    for (var x = 0, len = markers.length; x < len; x++) {
                                        locIndex[markers[x].locid] = x;
                                    }
                                }
                                var checked = jQuery(".minict_wrapper input[type^='radio']:checked");
                                var selTypes = [];
                                for (var i = 0, len = checked.length; i < len; i++) {
                                    selTypes.push(jQuery(checked[i]).val());
                                }
                                for (var i = 0, len = data.length; i < len; i++) {
                                    var sideDom = "p.loc[data-locid=" + (i + 1) + "]";
                                    //Only hide if length != 0
                                    if (checked.length != 0 && selTypes.indexOf(data[i].type) < 0) {
                                        jQuery(sideDom).hide();
                                        markers[locIndex[i + 1]].setVisible(false);
                                    } else {
                                        jQuery(sideDom).show();
                                        markers[locIndex[i + 1]].setVisible(true);
                                        map.panTo(markers[i].getPosition());
                                    }
                                }
                            }
                            jQuery(".select-area").on("change", "input[type^='radio']", doFilter);
                        }
                        google.maps.event.addDomListener(window, 'load', initialize);
                    </script>
                <?php
                } else {
                    if (function_exists('fnc_no_result_found')) {
                        fnc_no_result_found(false);
                    }
                }
            }
            echo balanceTags($after_widget, false); // WIDGET display CODE End
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("events_map");'));


/**
 * @Upcoming Event Calander widget Class
 */
if (!class_exists('upcoming_events_calander')) {

    class upcoming_events_calander extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @Init Upcoming Events Module
         */
        public function __construct() {

            parent::__construct(
                    'upcoming_events_calander', // Base ID
                    __('CS :Events Calander', 'directory'), // Name
                    array('classname' => 'widget-latest-event', 'description' => 'Select Event to show its countdown',) // Args
            );
        }

        /**
         * @Upcoming Events html form 
         */
        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => '', 'widget_names_events' => 'new'));
            $title = $instance['title'];
            $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>"> Select Event:
                    <select id="<?php echo esc_attr($this->get_field_id('get_post_slug')); ?>" name="<?php echo esc_attr($this->get_field_name('get_post_slug')); ?>" style="width:225px">
                        <option value=""> Select Category</option>
            <?php
            global $wpdb, $post;

            $categories = get_categories('taxonomy=events-categories&child_of=0&hide_empty=0');

            if ($categories != '') {
                
            }

            foreach ($categories as $category) {
                ?>
                            <option <?php if (esc_attr($get_post_slug) == $category->slug) {
                    echo 'selected';
                } ?> value="<?php echo stripslashes($category->slug); ?>" > <?php echo substr($category->name, 0, 20);
                if (strlen($category->name) > 20) echo "..."; ?> </option>
            <?php } ?>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('showcount')); ?>"> <?php _e('Number of Events:', 'jobdoor'); ?>
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showcount')); ?>" size="2" name="<?php echo esc_attr($this->get_field_name('showcount')); ?>" type="text" value="<?php echo intval($showcount); ?>" />
                </label>
            </p>
                <?php
            }

            /**
             * @Upcoming Events update data
             */
            function update($new_instance, $old_instance) {
                $instance = $old_instance;
                $instance['title'] = $new_instance['title'];
                $instance['get_post_slug'] = $new_instance['get_post_slug'];
                $instance['showcount'] = $new_instance['showcount'];
                return $instance;
            }

            /**
             * @Display Upcoming Events widget
             */
            function widget($args, $instance) {
                global $cs_theme_options;
                extract($args, EXTR_SKIP);
                $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
                $get_post_slug = isset($instance['get_post_slug']) ? esc_attr($instance['get_post_slug']) : '';
                $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
                if (empty($showcount)) {
                    $showcount = '4';
                }
                // WIDGET display CODE Start
                echo balanceTags($before_widget, false);
                if (!empty($title) && $title <> ' ') {
                    echo balanceTags($before_title . $title . $after_title, false);
                }
                global $wpdb, $post;
                $count = 1;
                $seprator = ',';

                if ($get_post_slug <> '') {
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'cs-events',
                        'event-categories' => $get_post_slug,
                        'post_status' => 'publish',
                        'order' => 'ASC'
                    );
                } else {
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'cs-events',
                        'post_status' => 'publish',
                        'order' => 'ASC'
                    );
                }
                $custom_query = new WP_Query($args);
                $published_posts = $custom_query->post_count;
                $event_calendar = '[';
                if ($custom_query->have_posts() <> "") {
                    cs_eventcalendar_enqueue();
                    while ($custom_query->have_posts()): $custom_query->the_post();
                        $event_from_date = get_post_meta($post->ID, "dynamic_post_event_from_date", true);

                        $dateformat = date('Y-m-d', strtotime($event_from_date));
                        $post_meta = get_post_meta($post->ID, "dynamic_cusotm_post", true);
                        if ($post_meta <> "") {
                            $cs_xmlObject = new SimpleXMLElement($post_meta);
                            $event_from_time = $cs_xmlObject->dynamic_post_event_start_time;
                        }
                        $timeformat = date('H:i', strtotime($event_from_time));
                        $event_calendar .= '{"date":"' . $dateformat . ' ' . $timeformat . '","type":"","title":"' . get_the_title() . '","description":"","url":"' . get_permalink() . '"}';
                        if ($count != $published_posts) {
                            $event_calendar .=$seprator;
                        }
                        $count++;
                    endwhile;
                }
                $event_calendar .= ']';
                ?>
            <div class="g4">
                <?php $cs_random = rand(0, 345345); ?>
                <div id="eventCalendarLimit<?php echo $cs_random; ?>"></div>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    jQuery("#eventCalendarLimit<?php echo $cs_random; ?>").eventCalendar({
                        jsonData:<?php echo $event_calendar; ?>,
                        jsonDateFormat: 'human',
                        txt_noEvents: '<?php _e('No results found.', 'LMS'); ?>',
                        eventsLimit:<?php echo esc_js($showcount); ?>
                    });
                });
            </script>
                    <?php
                    echo balanceTags($after_widget, false); // WIDGET display CODE End
                }

            }

        }
        add_action('widgets_init', create_function('', 'return register_widget("upcoming_events_calander");'));


        /**
         * @User(s) list widget Class
         */
        if (!class_exists('cs_userlist')) {

            class cs_userlist extends WP_Widget {
                /**
                 * Outputs the content of the widget
                 * @param array $args
                 * @param array $instance
                 */

                /**
                 * @init User list Module
                 */
                public function __construct() {

                    parent::__construct(
                            'cs_userlist', // Base ID
                            __('CS : User List', 'directory'), // Name
                            array('classname' => 'widget_userlist', 'description' => 'Select user list to show in widget',) // Args
                    );
                }

                /**
                 * @User list html form
                 */
                function form($instance) {
                    $instance = wp_parse_args((array) $instance, array('title' => '', 'get_username' => 'new'));
                    $title = $instance['title'];
                    $get_username = esc_sql($instance['get_username']);
                    ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> Title:
                    <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size="40" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('get_username')); ?>">Select Users:</label>
            <?php
            $args = array(
                'role' => '',
                'meta_key' => '',
                'meta_value' => '',
                'meta_compare' => '',
                'meta_query' => array(),
                'include' => array(),
                'exclude' => array(),
                'orderby' => 'login',
                'order' => 'ASC',
                'offset' => '',
                'search' => '',
                'number' => '',
                'count_total' => false,
                'fields' => 'all',
                'who' => ''
            );
            $userlist = get_users($args);
            ?>
            </p>
            <p>
            <?php
            if ($get_username == '' || !(is_array($get_username))) {
                $get_username = array();
            }
            ?>
                <select id="<?php echo esc_attr($this->get_field_id('get_username')); ?>" name="<?php echo esc_attr($this->get_field_name('get_username')); ?>[]" style="width:225px;" multiple="multiple">
            <?php foreach ($userlist as $user) { ?>
                        <option value="<?php echo intval($user->ID); ?>" <?php if (in_array($user->ID, $get_username)) {
                    echo 'selected';
                } ?>> <?php echo esc_attr($user->display_name); ?> </option>
            <?php } ?>
                </select>
            </p>
            <?php
        }

        /**
         * @User list update data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['get_username'] = esc_sql($new_instance['get_username']);
            return $instance;
        }

        /**
         * @Display User list widget
         */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            global $wpdb, $post, $cs_theme_options;
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $get_username = $instance['get_username'];
            // WIDGET display CODE Start
            echo balanceTags($before_widget, false);
            $cs_page_id = '';
            $cs_course_options = get_option('cs_course_options');
            if (isset($cs_course_options['cs_dashboard'])) {
                $cs_page_id = $cs_course_options['cs_dashboard'];
            }
            if (strlen($title) <> 1 || strlen($title) <> 0) {
                echo balanceTags($before_title . $title . $after_title, false);
            }
            if (isset($get_username) && $get_username <> '') {
                foreach ($get_username as $userid) {
                    $user_info = get_userdata($userid);
                    if ($user_info) {
                        $username = $user_info->display_name;
                        $user_email = $user_info->user_email;
                        $role = $user_info->roles;
                    } else {
                        $username = '';
                        $user_email = '';
                        $role = '';
                    }
                    $usermeta = get_user_meta($userid);
                    //$usermeta= array_map( function( $a ){ return $a[0]; }, $usermeta );
                    if (isset($usermeta['tagline']) and $usermeta['tagline'] <> '') {
                        $tagline = substr($usermeta['tagline'], 0, 20);
                    } else {
                        $tagline = '';
                    }
                    echo '<div class="cs-user-info">';
                    if (isset($usermeta['user_avatar_display']) and $usermeta['user_avatar_display'] <> '') {
                        echo '<figure><img src="' . $usermeta['user_avatar_display'] . '" width="58" height="58" alt="' . $usermeta['tagline'] . '"></figure>';
                    } else {
                        echo '<figure>' . get_avatar($user_email, apply_filters('PixFill_author_bio_avatar_size', 58)) . '</figure>';
                    }
                    echo '<div class="cs-widget-info">
								<a href="' . get_permalink($cs_page_id) . '/?action=dashboard&amp;uid=' . $userid . '">' . $username . '</a>
								<span>' . $tagline . '</span>
 								<ul>';
                    if (isset($usermeta['facebook']) and $usermeta['facebook'] <> '') {
                        echo '<li><a href="' . $usermeta['facebook'] . '"><i class="fa fa-facebook"></i></a></li>';
                    }
                    if (isset($usermeta['twitter']) and $usermeta['twitter'] <> '') {
                        echo '<li><a href="' . $usermeta['twitter'] . '"><i class="fa fa-twitter"></i></a></li>';
                    }
                    if (isset($usermeta['linkedin']) and $usermeta['linkedin'] <> '') {
                        echo '<li><a href="' . $usermeta['linkedin'] . '"><i class="fa fa-linkedin"></i></a></li>';
                    }
                    if (isset($usermeta['lastfm']) and $usermeta['lastfm'] <> '') {
                        echo '<li><a href="' . $usermeta['lastfm'] . '"><i class="fa fa-google-plus"></i></a></li>';
                    }
                    if (isset($usermeta['evernote']) and $usermeta['evernote'] <> '') {
                        echo '<li><a href="' . $usermeta['evernote'] . '"><i class="fa fa-exchange"></i></a></li>';
                    }
                    echo '</ul></div></div>';
                }
            } else {
                fnc_no_result_found(false);
            }
            echo balanceTags($after_widget, false);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("cs_userlist");'));

/**
 * @latest reviews widget Class
 */
class contactinfo extends WP_Widget {
    /**
     * Outputs the content of the widget
     * @param array $args
     * @param array $instance
     */

    /**
     * @init Contact Info Module
     */
    public function __construct() {

        parent::__construct(
                'contactinfo', // Base ID
                __('CS : Contact info', 'directory'), // Name
                array('classname' => 'widget_text', 'description' => 'Footer Contact Information',) // Args
        );
    }

    /**
     * @Contact Info html form
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance);
        $image_url = isset($instance['image_url']) ? esc_attr($instance['image_url']) : '';
        $address = isset($instance['address']) ? esc_attr($instance['address']) : '';
        $phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
        $mobile = isset($instance['mobile']) ? esc_attr($instance['mobile']) : '';
        $email = isset($instance['email']) ? esc_attr($instance['email']) : '';
        $randomID = rand(40, 9999999);
        ?>
        <div style="margin-top:0px; float:left; width:100%;">
            <ul class="form-elements-widget">
                <li class="to-label" style="margin-top:20px;">
                    <label>Image</label>
                </li>
                <li class="to-field">
                    <input id="form-widget_cs_widget_logo<?php echo intval($randomID) ?>" name="<?php echo cs_allow_special_char($this->get_field_name('image_url')); ?>" type="hidden" class="" value="<?php echo esc_url($image_url); ?>"/>
                    <label class="browse-icon">
                        <input name="form-widget_cs_widget_logo<?php echo intval($randomID) ?>"  type="button" class="uploadMedia left" value="<?php _e('Browse', 'LMS') ?>"/>
                    </label>
                </li>
            </ul>
            <div class="page-wrap"  id="form-widget_cs_widget_logo<?php echo intval($randomID) ?>_box" style="margin-top:10px; margin-bottom:10px; float:left; overflow:hidden; display:<?php echo esc_url($image_url) && trim($image_url) != '' ? 'inline' : 'none'; ?>">
                <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                        <ul id="gal-sortable" style="margin-bottom:0px;">
                            <li class="ui-state-default" style="margin:6px">
                                <div class="thumb-secs"> <img src="<?php echo esc_url($image_url); ?>"  id="form-widget_cs_widget_logo<?php echo intval($randomID) ?>_img" style="max-height:80px; max-width:180px"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_widget_logo<?php echo intval($randomID) ?>')" class="delete"></a> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <p style="margin-top:0px; float:left;">
            <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"> Address:<br />
                <textarea cols="20" rows="5" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo cs_allow_special_char($this->get_field_name('address')); ?>" style="width:315px"><?php echo cs_allow_special_char($address); ?></textarea>
            </label>
        </p>
        <p style="margin-top:0px; float:left;">
            <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"> Phone #:<br />
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" size="40"
                       name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo cs_allow_special_char($phone); ?>" />
            </label>
        </p>

        <p style="margin-top:0px; float:left;">
            <label for="<?php echo esc_attr($this->get_field_id('mobile')); ?>"> Mobile #:<br />
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('mobile')); ?>" size="40" 
                       name="<?php echo esc_attr($this->get_field_name('mobile')); ?>" type="text" value="<?php echo cs_allow_special_char($mobile); ?>" />
            </label>
        </p>

        <p style="margin-top:0px; float:left;">
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"> Email #:<br />
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('email')); ?>" size="40" 
                       name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo is_email($email); ?>" />
            </label>
        </p>
        <?php
    }

    /**
     * @Update Info html form
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image_url'] = $new_instance['image_url'];
        $instance['address'] = $new_instance['address'];
        $instance['phone'] = $new_instance['phone'];
        $instance['mobile'] = $new_instance['mobile'];
        $instance['email'] = $new_instance['email'];
        return $instance;
    }

    /**
     * @Widget Info html form
     */
    function widget($args, $instance) {
        global $px_node;
        extract($args, EXTR_SKIP);
        $image_url = empty($instance['image_url']) ? '' : apply_filters('widget_title', $instance['image_url']);
        $address = empty($instance['address']) ? '' : apply_filters('widget_title', $instance['address']);
        $phone = empty($instance['phone']) ? '' : apply_filters('widget_title', $instance['phone']);
        $mobile = empty($instance['mobile']) ? '' : apply_filters('widget_title', $instance['mobile']);
        $email = empty($instance['email']) ? '' : apply_filters('widget_title', $instance['email']);

        echo ($before_widget);

        if (isset($image_url) && $image_url != '') {
            echo '<div class="widget-cs-contact-info"><img src="' . $image_url . '" alt="" /></div>';
        }
        if (isset($address) and $address <> '') {
            echo '<div class="cont-info-address">' . do_shortcode(htmlspecialchars_decode($address)) . '</div>';
        }
        echo '<ul>';
        if (isset($phone) and $phone <> '') {
            echo '<li><i class="fa fa-phone"></i><span>Tel: ' . $phone . '</span></li>';
        }
        if (isset($mobile) and $mobile <> '') {
            echo '<li><i class="fa fa-mobile"></i><span>Mobile: ' . $mobile . '</span></li>';
        }
        if (isset($email) and $email <> '') {
            echo '<li><i class="fa fa-envelope"></i><span>Email: <a href="mailto:' . $email . '">' . $email . '</a></span></li>';
        }
        echo '</ul>';


        echo ($after_widget);
    }

}

add_action('widgets_init', create_function('', 'return register_widget("contactinfo");'));
?>