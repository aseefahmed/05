<?php
if (!function_exists('cs_members_listing_func')) {

    function cs_members_listing_func($atts, $content = "") {
        global $post, $cs_node, $cs_theme_options,$cs_course_options, $member_column;
        $user_id = cs_get_user_id();
        $cs_course_options = $cs_course_options;
        $defaults = array('column_size' => '1/1', 'var_pb_members_title' => '', 'var_pb_member_view' => 'default', 'var_pb_members_roles' => '', 'var_pb_members_profile_inks' => 'on', 'var_pb_members_filterable' => 'on', 'var_pb_members_all_tab' => '', 'var_pb_members_pagination' => 'single', 'var_pb_members_per_page' => '10', 'cs_members_class' => '', 'cs_members_animation' => '', 'cs_custom_animation_duration' => '1',);
        extract(shortcode_atts($defaults, $atts));
        $coloumn_class = cs_custom_column_class($column_size);
        ob_start();
        $filter_action = '';
        if (isset($cs_course_options['cs_dashboard'])) {
            $cs_page_id = $cs_course_options['cs_dashboard'];
        } else {
            $cs_page_id = '';
        }
        ?>
        <!-- Container -->
        <?php if ($var_pb_members_title != '') { ?>
            <div class="cs-section-title col-md-12">
                <h2><?php echo esc_attr($var_pb_members_title); ?></h2>
            </div>
        <?php } ?>
        <div class="<?php echo esc_attr($cs_members_class . ' ' . $cs_members_animation); ?> "  style="animation-duration: <?php echo esc_attr($cs_custom_animation_duration); ?>">
            <?php
            if (isset($var_pb_members_roles) && $var_pb_members_roles <> '') {
                $course_member_roles = array();
                $qrystr = "";
                if (isset($_GET['page_id']))
                    $qrystr = "&page_id=" . $_GET['page_id'];
                $course_member_roles = explode(',', $var_pb_members_roles);
                $filter_action = '';
                if (count($course_member_roles) > 0) {
                    if ($var_pb_members_filterable == "on") {
                        echo '<nav class="cs_assigment_tabs col-md-12">';
                        echo '<ul>';
                        $first_user_role = 0;
                        if (isset($_GET['filter_action']) && $_GET['filter_action'] != '') {
                            $filter_action = $_GET['filter_action'];
                        } else {
                            $filter_action = '';
                        }
                        $all_tab = 1;
                        if (isset($var_pb_members_all_tab) && $var_pb_members_all_tab == 'on') {
                            $all_tab = '';
                            if (isset($_GET['filter_action']) && $_GET['filter_action'] == 'all') {
                                $activeClass = 'active';
                                $filter_action = '';
                            } else if (!isset($_GET['filter_action'])) {
                                $activeClass = 'active';
                            } else {
                                $activeClass = '';
                            }
                            ?>
                            <li class="<?php echo esc_attr($activeClass); ?>"><a href="?<?php echo $qrystr . '&amp;filter_action=all'; ?>"><?php _e('All', 'EDULMS'); ?></a></li>
                            <?php
                        }
                        foreach ($course_member_roles as $member_roles) {
                            $first_user_role++;
                            if ($first_user_role == 1 && $all_tab <> '') {
                                $activeClass = 'active';
                                $filter_action = $member_roles;
                            }
                            if (isset($_GET['filter_action']) && $_GET['filter_action'] <> 'all' && $_GET['filter_action'] == $member_roles) {
                                $activeClass = 'active';
                                $filter_action = $_GET['filter_action'];
                            } else {
                                $activeClass = '';
                            }
                            ?>
                            <li class="<?php echo esc_attr($activeClass); ?>"><a href="?<?php echo $qrystr . '&amp;filter_action=' . $member_roles; ?>">
                                    <?php echo ucfirst($member_roles); ?></a></li>
                            <?php
                        }
                        echo '</ul>';
                        echo '</nav>';
                    } else {
                        
                    }
                    if ($var_pb_member_view == "default") {
                        ?>
                        <div class="col-md-12 cs-member dir-list <?php echo esc_attr($var_pb_member_view); ?>" id="members-dir-list">      
                            <ul class="item-list" id="members-list">
                                <?php
                                $members_counter = 0;
                                $members = 0;
                                $isNoUser = true;
                                foreach ($course_member_roles as $member_roles) {
                                    if (isset($_GET['filter_action']) && $_GET['filter_action'] != '' && $_GET['filter_action'] != 'all') {
                                        $filter_action = $_GET['filter_action'];
                                    } else {
                                        $filter_action = $member_roles;
                                    }
                                    if (empty($_GET['page_id_all'])) {
                                        $_GET['page_id_all'] = 1;
                                        $offset = 0;
                                    } else {
                                        $page_id_all = $_GET['page_id_all'] - 1;
                                        $offset = $page_id_all * $var_pb_members_per_page;
                                    }
                                    $wp_user_query = new WP_User_Query(array('role' => $filter_action));
                                    $users_count = $wp_user_query->get_total();
                                    $wp_user_query = new WP_User_Query(array('role' => $filter_action, 'number' => $var_pb_members_per_page, 'offset' => $offset));
                                    $authors = $wp_user_query->get_results();
                                    if (!empty($authors)) {
                                        if ($member_roles == $filter_action) {
                                            $isNoUser = false;
                                            foreach ($authors as $cs_user_data) {
                                                $members_counter++;
                                                $members++;
                                                ?>
                                                <li>
                                                    <figure>
                                                        <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>
                                                            <?php
                                                            $user_profile_public = get_the_author_meta('user_profile_public', $cs_user_data->ID);
                                                            if (isset($cs_page_id) && $cs_page_id != '' && isset($user_profile_public) && $user_profile_public == '1') {
                                                                ?>
                                                                <a href="<?php echo get_permalink($cs_page_id); ?>?action=dashboard&amp;uid=<?php echo absint($cs_user_data->ID); ?>">
                                                                <?php } else { ?>
                                                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $cs_user_data->ID)); ?>">
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php echo get_avatar($cs_user_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 60)); ?>
                                                                <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>
                                                                </a>
                                                            <?php } ?>
                                                    </figure>
                                                    <div class="left-sp">
                                                        <h4>
                                                            <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>
                                                                <?php
                                                                $user_profile_public = get_the_author_meta('user_profile_public', $cs_user_data->ID);
                                                                if (isset($cs_page_id) && $cs_page_id != '' && isset($user_profile_public) && $user_profile_public == '1') {
                                                                    $array_params = array('action' => 'dashboard', 'uid' => absint($cs_user_data->ID));
                                                                    $member_permalink = add_query_arg($array_params, get_permalink($cs_page_id));
                                                                    ?>
                                                                    <a href="<?php echo esc_url($member_permalink); ?>">
                                                                    <?php } else { ?>
                                                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $cs_user_data->ID)); ?>">
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php echo esc_attr($cs_user_data->display_name); ?>
                                                                    <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>
                                                                    </a>
                                                                <?php } ?>
                                                        </h4>
                                                        <p><?php echo substr(get_the_author_meta('tagline', $cs_user_data->ID), 0, 25); ?></p>
                                                    </div>
                                                    <span><?php echo absint($members_counter); ?></span>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                            if ($members <= 0 && $isNoUser) {
                                echo '<div class="error_mess"><p>' . __('No User found.', 'EDULMS') . '</p></div>';
                                $isNoUser = false;
                            }
                            ?>
                        </div>
                    <?php } elseif ($var_pb_member_view == "grid") { ?>
                        <div class="col-md-12 cs-team cs-grid-member grid_team_view team_grid col-md-12"> 
                            <div class="row">   
                                <?php
                                $members = 0;
                                $members_counter = 0;
                                $isNoUser = true;
                                foreach ($course_member_roles as $member_roles) {
                                    if (isset($_GET['filter_action']) && $_GET['filter_action'] != '' && $_GET['filter_action'] != 'all') {
                                        $filter_action = $_GET['filter_action'];
                                    } else {
                                        $filter_action = $member_roles;
                                    }
                                    if (empty($_GET['page_id_all'])) {
                                        $_GET['page_id_all'] = 1;
                                        $offset = 0;
                                    } else {
                                        $page_id_all = $_GET['page_id_all'] - 1;
                                        $offset = $page_id_all * $var_pb_members_per_page;
                                    }


                                    $wp_user_query = new WP_User_Query(array('role' => $filter_action));
                                    $users_count = $wp_user_query->get_total();
                                    $wp_user_query = new WP_User_Query(array('role' => $filter_action, 'number' => $var_pb_members_per_page, 'offset' => $offset));
                                    $authors = $wp_user_query->get_results();
                                    if (!empty($authors)) {
                                        if ($member_roles == $filter_action) {
                                            $isNoUser = false;
                                            foreach ($authors as $cs_user_data) {
                                                $members_counter++;
                                                ?>
                                                <article class="col-md-3">
                                                    <figure>
                                                        <?php
                                                        if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') {
                                                            $user_profile_public = get_the_author_meta('user_profile_public', $cs_user_data->ID);
                                                            if (isset($cs_page_id) && $cs_page_id != '' && isset($user_profile_public) && $user_profile_public == '1') {
                                                                $array_params = array('action' => 'dashboard', 'uid' => absint($cs_user_data->ID));
                                                                $member_permalink = add_query_arg($array_params, get_permalink($cs_page_id));
                                                                ?>
                                                                <a href="<?php echo esc_url($member_permalink); ?>">
                                                                <?php } else { ?>
                                                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $cs_user_data->ID)); ?>">
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <?php echo get_avatar($cs_user_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 500)); ?>
                                                                <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>
                                                                </a>
                                                            <?php } ?>
                                                    </figure>
                                                    <div class="text">
                                                        <header>
                                                            <h2 class="cs-post-title">
                                                                <?php if (isset($var_pb_members_profile_inks) && $var_pb_members_profile_inks == 'on') { ?>                                                                          <?php
                                                                    $user_profile_public = get_the_author_meta('user_profile_public', $cs_user_data->ID);
                                                                    if (isset($cs_page_id) && $cs_page_id != '' && isset($user_profile_public) && $user_profile_public == '1') {
                                                                        $array_params = array('action' => 'dashboard', 'uid' => absint($cs_user_data->ID));
                                                                        $member_permalink = add_query_arg($array_params, get_permalink($cs_page_id));
                                                                        ?>
                                                                        <a href="<?php echo esc_url($member_permalink); ?>">
                                                                        <?php } else { ?>
                                                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $cs_user_data->ID)); ?>">
                                                                            <?php } ?>         	 
                                                                            <?php echo esc_attr($cs_user_data->display_name); ?>
                                                                        </a>
                                                                        <?php
                                                                    } else {
                                                                        echo esc_attr($cs_user_data->display_name);
                                                                    }
                                                                    ?>
                                                            </h2>
                                                            <?php
                                                            $autherDescription = substr(get_the_author_meta('tagline', $cs_user_data->ID), 0, 25);
                                                            if ($autherDescription) {
                                                                ?>
                                                                <ul class="post-option">
                                                                    <li class="has-border"><?php echo esc_textarea($autherDescription); ?></li>
                                                                </ul>
                                                            <?php } ?>
                                                        </header>
                                                        <p class="social-media">
                                                            <?php
                                                            $facebook = $twitter = $linkedin = $pinterest = $google_plus = '';
                                                            $facebook = get_the_author_meta('facebook', $cs_user_data->ID);
                                                            $twitter = get_the_author_meta('twitter', $cs_user_data->ID);
                                                            $linkedin = get_the_author_meta('linkedin', $cs_user_data->ID);
                                                            $pinterest = get_the_author_meta('pinterest', $cs_user_data->ID);
                                                            $google_plus = get_the_author_meta('google_plus', $cs_user_data->ID);
                                                            $instagram = get_the_author_meta('instagram', $cs_user_data->ID);
                                                            $skype = get_the_author_meta('skype', $cs_user_data->ID);
                                                            if (isset($facebook) && $facebook <> '') {
                                                                echo '<a href="' . $facebook . '" data-original-title="Facebook">
                                                                            <i class="fa fa-facebook"></i>
                                                                        </a>';
                                                            }
                                                            if (isset($twitter) && $twitter <> '') {
                                                                echo '<a href="' . $twitter . '" data-original-title="Twitter">
                                                                        <i class="fa fa-twitter"></i>
                                                                        </a>';
                                                            }
                                                            if (isset($linkedin) && $linkedin <> '') {
                                                                echo '<a href="' . $linkedin . '" data-original-title="Linkedin">
                                                                        <i class="fa fa-linkedin"></i>
                                                                        </a>';
                                                            }
                                                            if (isset($pinterest) && $pinterest <> '') {
                                                                echo '<a href="' . $pinterest . '" data-original-title="Pinterest">
                                                                        <i class="fa fa-pinterest"></i></a>';
                                                            }
                                                            if (isset($google_plus) && $google_plus <> '') {
                                                                echo '<a href="' . $google_plus . '"  data-original-title="Google Plus">
                                                                        <i class="fa fa-google-plus"></i></a>';
                                                            }
                                                            if (isset($skype) && $skype <> '') {
                                                                echo '<a href="skype:' . $skype . '?chat"  data-original-title="Google Plus">
                                                                        <i class="fa fa-skype"></i></a>';
                                                            }
                                                            if (isset($instagram) && $instagram <> '') {
                                                                echo '<a href="' . $instagram . '"  data-original-title="Google Plus">
                                                                        <i class="fa fa-instagram"></i></a>';
                                                            }
                                                            ?>                              
                                                        </p>
                                                    </div>
                                                </article>
                                                <?php
                                            }
                                        }
                                    } else {
                                        
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if ($members <= 0 && $isNoUser) {
                                echo '<div class="error_mess"><p>' . __('No User found.', 'EDULMS') . '</p></div>';
                                $isNoUser = false;
                            }
                            ?>
                        </div>                                 
                        <?php
                    }
                    $pageqrystr = '';
                    if ($var_pb_members_pagination == "Show Pagination" and $users_count > $var_pb_members_per_page and $var_pb_members_per_page > 0) {
                        echo '<div class="col-md-12">';
                        if (isset($_GET['page_id']))
                            $pageqrystr = "&page_id=" . $_GET['page_id'];
                        if (isset($_GET['filter_action']))
                            $pageqrystr = "&filter_action=" . $_GET['filter_action'];
                        echo cs_pagination($users_count, $var_pb_members_per_page, $pageqrystr);
                        echo '</div>';
                    }
                    ?>								 
                    <?php
                }
            }
            ?>
        </div>

        <?php
        $memberspost_data = ob_get_clean();

        return $memberspost_data;
    }

    add_shortcode('cs_members', 'cs_members_listing_func');
}