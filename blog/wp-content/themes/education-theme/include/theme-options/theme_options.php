<?php
// Theme option function
if (!function_exists('cs_options_page')) {

    function cs_options_page() {
        global $cs_theme_options, $options;
        $cs_theme_options = get_option('cs_theme_options');
        ?>
        <div class="theme-wrap fullwidth">
            <div class="inner">
                <div class="outerwrapp-layer">
                    <div class="loading_div">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                        <br>
                        <?php esc_html_e('Saving changes...', 'LMS'); ?>
                    </div>
                    <div class="form-msg">
                        <i class="fa fa-check-circle-o"></i>
                        <div class="innermsg"></div>
                    </div>
                </div>
                <div class="row">   
                    <form id="frm" method="post">
                        <?php
                        $theme_options_fields = new theme_options_fields();
                        $return = $theme_options_fields->cs_fields($options);
                        ?>
                        <div class="col1">
                            <nav class="admin-navigtion">
                                <div class="logo">
                                    <a href="#" class="logo1"><img src="<?php echo get_template_directory_uri() ?>/include/assets/images/logo-themeoption.png" /></a>
                                    <a href="#" class="nav-button"><i class="fa fa-align-justify"></i></a>
                                </div>
                                <ul>
                                    <?php echo force_balance_tags($return[1], true); ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="col2">
                            <?php echo force_balance_tags($return[0], true); /* Settings */ ?>
                        </div>
                        <div class="clear"></div>
                        <div class="footer">
                            <input type="button" id="submit_btn" name="submit_btn" class="bottom_btn_save" value="<?php _e('Save All Settings', 'LMS'); ?>" onclick="javascript:theme_option_save('<?php echo esc_js(admin_url('admin-ajax.php')) ?>', '<?php echo esc_js(get_template_directory_uri()); ?>');" />
                            <input type="hidden" name="action" value="theme_option_save"  />
                            <input class="bottom_btn_reset" name="reset" type="button" value="<?php _e('Reset All Options', 'LMS'); ?>"  
                                   onclick="javascript:cs_rest_all_options('<?php echo esc_js(admin_url('admin-ajax.php')) ?>', '<?php echo esc_js(get_template_directory_uri()) ?>');" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!--wrap-->
        <script type="text/javascript">
            // Sub Menus Show/hide
            jQuery(document).ready(function ($) {
                jQuery(".sub-menu").parent("li").addClass("parentIcon");
                $("a.nav-button").click(function () {
                    $(".admin-navigtion").toggleClass("navigation-small");
                });

                $("a.nav-button").click(function () {
                    $(".inner").toggleClass("shortnav");
                });

                $(".admin-navigtion > ul > li > a").click(function () {
                    var a = $(this).next('ul')
                    $(".admin-navigtion > ul > li > a").not($(this)).removeClass("changeicon")
                    $(".admin-navigtion > ul > li ul").not(a).slideUp();
                    $(this).next('.sub-menu').slideToggle();
                    $(this).toggleClass('changeicon');
                });
            });

            function show_hide(id) {
                var link = id.replace('#', '');
                jQuery('.horizontal_tab').fadeOut(0);
                jQuery('#' + link).fadeIn(400);
            }

            function toggleDiv(id) {
                jQuery('.col2').children().hide();
                jQuery(id).show();
                location.hash = id + "-show";
                var link = id.replace('#', '');
                jQuery('.categoryitems li').removeClass('active');
                jQuery(".menuheader.expandable").removeClass('openheader');
                jQuery(".categoryitems").hide();
                jQuery("." + link).addClass('active');
                jQuery("." + link).parent("ul").show().prev().addClass("openheader");
            }
            jQuery(document).ready(function () {
                jQuery(".categoryitems").hide();
                jQuery(".categoryitems:first").show();
                jQuery(".menuheader:first").addClass("openheader");
                jQuery(".menuheader").live('click', function (event) {
                    if (jQuery(this).hasClass('openheader')) {
                        jQuery(".menuheader").removeClass("openheader");
                        jQuery(this).next().slideUp(200);
                        return false;
                    }
                    jQuery(".menuheader").removeClass("openheader");
                    jQuery(this).addClass("openheader");
                    jQuery(".categoryitems").slideUp(200);
                    jQuery(this).next().slideDown(200);
                    return false;
                });

                var hash = window.location.hash.substring(1);
                var id = hash.split("-show")[0];
                if (id) {
                    jQuery('.col2').children().hide();
                    jQuery("#" + id).show();
                    jQuery('.categoryitems li').removeClass('active');
                    jQuery(".menuheader.expandable").removeClass('openheader');
                    jQuery(".categoryitems").hide();
                    jQuery("." + id).addClass('active');
                    jQuery("." + id).parent("ul").slideDown(300).prev().addClass("openheader");
                }
            });
            jQuery(function ($) {
                $("#cs_launch_date").datepicker({
                    defaultDate: "+1w",
                    dateFormat: "dd/mm/yy",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onSelect: function (selectedDate) {
                        $("#cs_launch_date").datepicker("option", "minDate", selectedDate);
                    }
                });
            });
        </script>
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()) ?>/include/assets/css/jquery_ui_datepicker.css">
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()) ?>/include/assets/css/jquery_ui_datepicker_theme.css">
        <?php
    }

}

// Background Count function
if (!function_exists('cs_bgcount')) {

    function cs_bgcount($name, $count) {
        for ($i = 0; $i <= $count; $i++) {
            $pattern['option' . $i] = $name . $i;
        }
        return $pattern;
    }

}
add_action('init', 'cs_theme_options');
if (!function_exists('cs_theme_options')) {

    function cs_theme_options() {
        global $options, $header_colors, $cs_theme_options, $edulms;
        $cs_theme_options = get_option('cs_theme_options');
        $on_off_option = array("show" => "on", "hide" => "off");
        $navigation_style = array("left" => "left", "center" => "center", "right" => "right");
        $google_fonts = array('google_font_family_name' => array('', '', ''), 'google_font_family_url' => array('', '', ''));
        $social_network = array('social_net_icon_path' => array('', '', '', '', '', ''), 'social_net_awesome' => array('fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-skype', 'fa-pinterest', 'fa-envelope-o'), 'social_net_url' => array('https://www.facebook.com/', 'https://www.twitter.com/', 'https://plus.google.com/', 'https://www.skype.com/', 'https://www.pintrest.com/', 'https://www.mail.com/'), 'social_net_tooltip' => array('Facebook', 'Twitter', 'Google Plus', 'Skype', 'Pintrest', 'Mail'), 'social_font_awesome_color' => array('#2d5faa', '#3ba3f3', '#f33b3b', '#22b6f4', '#a82626', '#f4ca22'));


        $sidebar = array('sidebar' => array('default_pages' => 'Default Pages', 'course_sidebar' => 'Course Sidebar', 'events_sidebar' => 'Events Sidebar', 'blogs_sidebar' => 'Blogs Sidebar', 'pages_sidebar' => 'Pages Sidebar', 'shop_listing_sidebar' => 'Shop Listing Sidebar', 'shop_detail_sidebar' => 'Shop Detail Sidebar', 'contact' => 'Contact'));
        $menus_locations = array_flip(get_nav_menu_locations());
        $breadcrumb_option = array("option1" => "option1", "option2" => "option2", "option3" => "option3");
        $deafult_sub_header = array('breadcrumbs_sub_header' => 'Breadcrumbs Sub Header', 'slider' => 'Revolution Slider', 'no_header' => 'No sub Header');
        $padding_sub_header = array('Default' => 'default', 'Custom' => 'custom');
        //Menus List
        $menu_option = get_registered_nav_menus();
        foreach ($menu_option as $key => $menu) {
            $menu_location = $key;
            $menu_locations = get_nav_menu_locations();
            $menu_object = (isset($menu_locations[$menu_location]) ? wp_get_nav_menu_object($menu_locations[$menu_location]) : null);
            $menu_name[] = (isset($menu_object->name) ? $menu_object->name : '');
        }
        //Mailchimp List
        $mail_chimp_list[] = '';
        if (isset($cs_theme_options['cs_mailchimp_key'])) {
            $mailchimp_option = $cs_theme_options['cs_mailchimp_key'];
            if ($mailchimp_option <> '') {
                $mc_list = cs_mailchimp_list($mailchimp_option);
                if (is_array($mc_list) && isset($mc_list['data'])) {
                    foreach ($mc_list['data'] as $list) {
                        $mail_chimp_list[$list['id']] = $list['name'];
                    }
                }
            }
        }
        $cs_course_view = array('plain' => 'Default', 'classic' => 'Classic', 'three-column' => 'Grid 3 Column', 'four-column' => 'Grid 4 Column', 'timeline' => 'Timeline', 'flat' => 'Flat', 'flat-grid' => 'Flat Grid', 'grid-slider' => 'Grid Slider', 'minimal' => 'Minimal', 'modren' => 'Modren', 'list' => 'List', 'big' => 'Big', 'unique' => 'Unique');
        //google fonts array
        $g_fonts = cs_googlefont_list();

        $g_fonts_atts = cs_get_google_font_attribute();

        global $cs_theme_options;
        if (isset($cs_theme_options) and $cs_theme_options <> '') {
            if (isset($cs_theme_options['sidebar']) and count($cs_theme_options['sidebar']) > 0) {
                $cs_sidebar = array('sidebar' => $cs_theme_options['sidebar']);
            } elseif (!isset($cs_theme_options['sidebar'])) {
                $cs_sidebar = array('sidebar' => array());
            }
        } else {
            $cs_sidebar = $sidebar;
        }
        // Set the Options Array
        $options = array();
        $header_colors = cs_header_setting();
        /* general setting options */
        $options[] = array(
            "name" => __("General", 'LMS'),
            "fontawesome" => 'fa fa-cogs',
            "type" => "heading",
            "options" => array(
                'tab-global-setting' => __('global', 'LMS'),
                'tab-header-options' => __('Header', 'LMS'),
                'tab-sub-header-options' => __('Sub Header', 'LMS'),
                'tab-footer-options' => __('Footer', 'LMS'),
                'tab-social-setting' => __('social icons', 'LMS'),
                'tab-social-network' => __('social sharing', 'LMS'),
                'tab-custom-code' => __('custom code', 'LMS'),
            )
        );
        $options[] = array(
            "name" => __("color", 'LMS'),
            "fontawesome" => 'fa fa-magic',
            "hint_text" => "",
            "type" => "heading",
            "options" => array(
                'tab-general-color' => __('general', 'LMS'),
                'tab-header-color' => __('Header', 'LMS'),
                'tab-footer-color' => __('Footer', 'LMS'),
                'tab-heading-color' => __('headings', 'LMS'),
            )
        );
        $options[] = array(
            "name" => __("typography / fonts", 'LMS'),
            "fontawesome" => 'fa fa-font',
            "desc" => "",
            "hint_text" => "",
            "type" => "heading",
            "options" => array(
                'tab-custom-font' => __('Custom Font', 'LMS'),
                'tab-font-family' => __('font family', 'LMS'),
                'tab-font-size' => __('font size', 'LMS'),
            )
        );
        $options[] = array(
            "name" => __("sidebar", 'LMS'),
            "fontawesome" => 'fa fa-columns',
            "id" => "tab-sidebar",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $options[] = array(
            "name" => __("Seo", 'LMS'),
            "fontawesome" => 'fa fa-globe',
            "id" => "tab-seo",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        $options[] = array(
            "name" => __("global", 'LMS'),
            "id" => "tab-global-setting",
            "type" => "sub-heading"
        );
        $options[] = array(
            "name" => __("Layout", 'LMS'),
            "desc" => "",
            "hint_text" => __("Layout type", 'LMS'),
            "id" => "cs_layout",
            "std" => "full_width",
            "options" => array(
                "boxed" => __("boxed", 'LMS'),
                "full_width" => __("full width", 'LMS')
            ),
            "type" => "layout",
        );

        $options[] = array(
            "name" => "",
            "id" => "cs_horizontal_tab",
            "class" => "horizontal_tab",
            "type" => "horizontal_tab",
            "std" => "",
            "options" => array('Background' => 'background_tab', 'Pattern' => 'pattern_tab', 'Custom Image' => 'custom_image_tab')
        );

        $options[] = array(
            "name" => __("Background image", 'LMS'),
            "desc" => "",
            "hint_text" => __('Choose from Predefined Background images.', 'LMS'),
            "id" => "cs_bg_image",
            "class" => "cs_background_",
            "path" => "background",
            "tab" => "background_tab",
            "std" => "bg1",
            "type" => "layout_body",
            "display" => "block",
            "options" => cs_bgcount('bg', '10')
        );

        $options[] = array("name" => "Background pattern",
            "desc" => "",
            "hint_text" => "Choose from Predefined Pattern images.",
            "id" => "cs_bg_image",
            "class" => "cs_background_",
            "path" => "patterns",
            "tab" => "pattern_tab",
            "std" => "bg1",
            "type" => "layout_body",
            "display" => "none",
            "options" => cs_bgcount('pattern', '27')
        );
        $options[] = array(
            "name" => "Custom image",
            "desc" => "",
            "hint_text" => "This option can be used only with Boxed Layout.",
            "id" => "cs_custom_bgimage",
            "std" => "",
            "tab" => "custom_image_tab",
            "display" => "none",
            "type" => "upload logo"
        );
        $options[] = array("name" => __('Background image position', 'LMS'),
            "desc" => "",
            "hint_text" => __('Choose image position for body background', 'LMS'),
            "id" => "cs_bgimage_position",
            "std" => "Center Repeat",
            "type" => "select",
            "options" => array(
                "option1" => "no-repeat center top",
                "option2" => "repeat center top",
                "option3" => "no-repeat center",
                "option4" => "Repeat Center",
                "option5" => "no-repeat left top",
                "option6" => "repeat left top",
                "option7" => "no-repeat fixed center",
                "option8" => "no-repeat fixed center / cover"
            )
        );
        $options[] = array("name" => __('Custom favicon', 'LMS'),
            "desc" => "",
            "hint_text" => __('Custom favicon for your site', 'LMS'),
            "id" => "cs_custom_favicon",
            "std" => get_template_directory_uri() . "/assets/images/favicon.png",
            "type" => "upload logo"
        );


        /* 	$options[] = array( "name" => "User Profile Page",
          "desc" => "",
          "hint_text" => "Select page for user profile here",
          "id" =>   "cs_dashboard",
          "std" => "",
          "type" => "select_dashboard",
          "options" => ''
          ); */

        /* 	$options[] = array( "name" => "Currency",
          "desc" => "",
          "hint_text" => "Set currency symbol like($,£,¥)",
          "id" =>   "cs_currency_symbol",
          "std" => "$",
          "type" => "text",
          ); */
        $options[] = array("name" => __("Smooth Scroll", 'LMS'),
            "desc" => "",
            "hint_text" => __("Lightweight Script for Page Scrolling animation", "LMS"),
            "id" => "cs_smooth_scroll",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $options[] = array("name" => __("Responsive", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set responsive design layout for mobile devices On/Off here", 'LMS'),
            "id" => "cs_responsive",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );
		
		if(class_exists('edulms')){
			$dir = edulms::plugin_dir() . 'languages/';
			$cs_plugin_language[''] = 'Select Language File';
			
			if (is_dir($dir)) {
			
				if ($dh = opendir($dir)) {
					 
					while (($file = readdir($dh)) !== false) {
					   
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						if ($ext == 'mo') {
							$cs_plugin_language[$file] = $file;
						}
					}
					closedir($dh);
				}
			}
			
			$options[] = array("name" => __("Select Language", 'LMS'),
				"desc" => "",
				"id" => "cs_language_file",
				"std" => "off",
				"type" => "select",
				"options" => $cs_plugin_language
			);
		}
		
        // Header options start
        $options[] = array("name" => __("header", 'LMS'),
            "id" => "tab-header-options",
            "type" => "sub-heading"
        );

        $options[] = array("name" => __("Logo", 'LMS'),
            "desc" => "",
            "hint_text" => __("Upload your custom logo in .png .jpg .gif formats only", 'LMS'),
            "id" => "cs_custom_logo",
            "std" => get_template_directory_uri() . "/include/assets/images/logo.png",
            "type" => "upload logo"
        );
        $options[] = array("name" => __("Logo Height", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set exact logo height otherwise logo will not display normally", 'LMS'),
            "id" => "cs_logo_height",
            "min" => '0',
            "max" => '200',
            "std" => "41",
            "type" => "range"
        );
        $options[] = array("name" => __("logo width", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set exact logo width otherwise logo will not display normally", 'LMS'),
            "id" => "cs_logo_width",
            "min" => '0',
            "max" => '250',
            "std" => "159",
            "type" => "range"
        );

        $options[] = array("name" => __("Logo margin top and bottom", 'LMS'),
            "desc" => "",
            "hint_text" => __("Logo spacing/margin from top and bottom.", 'LMS'),
            "id" => "cs_logo_margintb",
            "min" => '0',
            "max" => '200',
            "std" => "25",
            "type" => "range"
        );
        $options[] = array("name" => __("Logo margin left and right", 'LMS'),
            "desc" => "",
            "hint_text" => __("Logo spacing/margin from left and right.", 'LMS'),
            "id" => "cs_logo_marginlr",
            "min" => '0',
            "max" => '200',
            "std" => "0",
            "type" => "range"
        );
        $options[] = array("name" => __("Header Styles", 'LMS'),
            "desc" => "",
            "hint_text" => __("Choose header style from the given options", 'LMS'),
            "id" => "cs_header_options",
            "class" => "cs_",
            "std" => "header_1",
            "type" => "layout1",
            "options" => array(
                "header_1" => "header_1",
                "header_2" => "header_2",
                "header_3" => "header_3",
                "header_4" => "header_4",
                "header_5" => "header_5",
                "header_6" => "header_6",
                "header_7" => "header_7",
            //"header_8"=>"header_8",
            ////"header_9"=>"header_9",
            //"header_10"=>"header_10"
            )
        );
        /* header element settings */

        $options[] = array("name" => __("Header Elements", 'LMS'),
            "id" => "tab-header-options",
            "std" => __("Header Elements", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Main Search", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set header search On/Off. Allow user to search site content.", 'LMS'),
            "id" => "cs_search",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $options[] = array("name" => __("Login Options", 'LMS'),
            "desc" => "",
            "hint_text" => __("Membership must be enabled from Dashboard Settings > General > Membership to allow user Registration", 'LMS'),
            "id" => "cs_login_options",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $options[] = array("name" => "WPML",
            "desc" => "",
            "hint_text" => "Set WordPress Multi Language switcher ON/OFF in header",
            "id" => "cs_wpml_switch",
            "std" => "on",
            "type" => "wpml",
            "options" => $on_off_option
        );
        $options[] = array("name" => __("Shopping cart button", 'LMS'),
            "desc" => "",
            "hint_text" => __("Shopping cart button will work when WooCommerce Plugin is installed.", 'LMS'),
            "id" => "cs_woocommerce_switch",
            "std" => "on",
            "type" => "woocommerce",
            "options" => $on_off_option
        );
        /* $options[] = array( "name" => "Header Height",
          "desc" => "",
          "hint_text" => "Set Custom Height For Header",
          "id" =>   "cs_header_height",
          "std" => "100",
          "type" => "text"); */

        $options[] = array("name" => __("Sticky Header On/Off", 'LMS'),
            "desc" => "",
            "id" => "cs_sitcky_header_switch",
            "hint_text" => __("If you enable this option , header will be fixed on top of your browser window.", 'LMS'),
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        /* $options[] = array( "name" => "Sticky Header Height",
          "desc" => "",
          "hint_text" => "Set Custom Height for sticky Menu",
          "id" =>   "cs_sticky_header_height",
          "std" => "100",
          "type" => "text"); */
        $options[] = array("name" => __("Header Position Settings", 'LMS'),
            "id" => "tab-header-options",
            "std" => __("Header Position Settings", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Select Header Position", 'LMS'),
            "desc" => "Make header position fixed as Absolute or move it",
            "hint_text" => __("Select header position as Absolute OR Relative", 'LMS'),
            "id" => "cs_header_position",
            "std" => "relative",
            "type" => "select",
            "options" => array('absolute' => 'absolute', 'relative' => 'relative')
        );
        $options[] = array("name" => __("Header Background", 'LMS'),
            "desc" => "",
            "hint_text" => __("Header settings made here will be implemented on default pages", 'LMS'),
            "id" => "cs_headerbg_options",
            "std" => "Default Header Background",
            "type" => "default header background",
            "options" => array('none' => 'None', 'cs_rev_slider' => 'Revolution Slider', 'cs_bg_image_color' => 'Bg Image / bg Color')
        );
        $options[] = array("name" => __("Revolution Slider", 'LMS'),
            "desc" => "",
            //"hint_text" => "<p>Please select Revolution Slider if already included in package. Otherwise buy Sliders from <a href='http://codecanyon.net/' target='_blank'>Codecanyon</a>. But its optional</p>",
            "id" => "cs_headerbg_slider",
            "std" => "",
            "type" => "headerbg slider",
            "options" => ''
        );
        $options[] = array("name" => __("Background Image", 'LMS'),
            "desc" => "",
            "hint_text" => __("Upload your custom background image in .png .jpg .gif formats only", 'LMS'),
            "id" => "cs_headerbg_image",
            "std" => "",
            "type" => "upload"
        );
        $options[] = array("name" => __("Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("set header background color", 'LMS'),
            "id" => "cs_headerbg_color",
            "std" => "",
            "type" => "color"
        );
        $options[] = array("name" => __("Header Top Strip", 'LMS'),
            "id" => __("tab-header-options", 'LMS'),
            "std" => __("Header Top Strip", 'LMS'),
            "type" => "section",
            "options" => ""
        );

        $options[] = array("name" => __("Header Strip", 'LMS'),
            "desc" => "",
            "hint_text" => __("Enable/Disable header top strip", 'LMS'),
            "id" => "cs_header_top_strip",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option);

        $options[] = array("name" => __("Social Icon", 'LMS'),
            "desc" => "",
            "hint_text" => __("Enable/Disable social icon. Add icons from General > social icon", 'LMS'),
            "id" => "cs_socail_icon_switch",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option);
        /* $options[] = array( "name" => "Short Text",
          "desc" => "",
          "hint_text" => "Set Tag line on/off under the logo",
          "id" =>   "cs_header_strip_tagline_switch",
          "std" => "on",
          "type" => "checkbox",
          "options" => $on_off_option
          ); */
        $options[] = array("name" => __("Top Menu", 'LMS'),
            "desc" => "",
            "hint_text" => __("Menu location can be set from Appearance > Menu > Manage Menu Locations", 'LMS'),
            "id" => "cs_top_menu_switch",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option);
        $options[] = array("name" => __("Short Text", 'LMS'),
            "desc" => "",
            "hint_text" => __("Write phone no, email or address for Header top strip", 'LMS'),
            "id" => "cs_header_strip_tagline_text",
            "std" => '<i class="fa fa-envelope-o"></i> for any inquiry: 000-111-222-33<a href="mailto: future@university.com"> future@university.com</a>',
            "type" => "textarea");
        $options[] = array("name" => __("Header add sense", 'LMS'),
            "desc" => "",
            "hint_text" => __("Embed Image/Google add sense Code", 'LMS'),
            "id" => "cs_header_banner_addsense",
            "std" => '',
            "type" => "textarea");

        /* $options[] = array( "name" => "email",
          "desc" => "",
          "hint_text" => "Write Email address  for Header top strip",
          "id" =>   "cs_top_header_email",
          "std" => "boxDirectory@mail.com",
          "type" => "text"); */

        /* $options[] = array( "name" => "Top Menu",
          "desc" => "",
          "hint_text" => "",
          "id" =>   "cs_top_menu_switch",
          "std" => "on",
          "type" => "checkbox",
          "options" => $on_off_option); */
        // Header option end

        /* $options[] = array( "name" => "Main Navigation Style",
          "desc" => "",
          "id" =>   "cs_main_nav_style",
          "std" => "on",
          "type" => "select",
          "options" => $navigation_style);

          $options[] = array( "name" => "Select Top Menu",
          "desc" => "",
          "id" =>   "cs_top_menu",
          "std" => "on",
          "type" => "select",
          "options" => $menu_name); */


        /* sub header element settings */
        $options[] = array("name" => __("sub header", 'LMS'),
            "id" => "tab-sub-header-options",
            "type" => "sub-heading"
        );
        /* $options[] = array( "name" =>__("Announcement!",'LMS'),
          "id" => "sub_header_announcement",
          "std"=>__("Change this and that and try again. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum",'LMS'),
          "type" => "announcement"
          ); */

        $options[] = array("name" => __("Default", 'LMS'),
            "desc" => "",
            "hint_text" => __("Sub Header settings made here will be implemented on all pages", 'LMS'),
            "id" => "cs_default_header",
            "std" => "Breadcrumbs Sub Header",
            "type" => "default header",
            "options" => $deafult_sub_header
        );
        $options[] = array("name" => __("Content Padding", 'LMS'),
            "desc" => "",
            "hint_text" => __("Choose default or custom padding for sub header content", 'LMS'),
            "id" => "subheader_padding_switch",
            "std" => "Default",
            "type" => "default padding",
            "options" => $padding_sub_header
        );

        $options[] = array("name" => __("Header Border Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_header_border_color",
            "std" => "#e0e0e0",
            "type" => "color"
        );

        $options[] = array("name" => "Revolution Slider",
            "desc" => "",
            //"hint_text" => "<p>Please select Revolution Slider if already included in package. Otherwise buy Sliders from <a href='http://codecanyon.net/' target='_blank'>Codecanyon</a>. But its optional</p>",
            "id" => "cs_custom_slider",
            "std" => "",
            "type" => "slider code",
            "options" => ''
        );
        $options[] = array("name" => __("Padding Top", "LMS"),
            "desc" => "",
            "hint_text" => __("Set custom padding for sub header content top area", "LMS"),
            "id" => "cs_sh_paddingtop",
            "min" => '0',
            "max" => '200',
            "std" => "45",
            "type" => "range"
        );
        $options[] = array("name" => __("Padding Bottom", "LMS"),
            "desc" => "",
            "hint_text" => __("Set custom padding for sub header content bottom area", "LMS"),
            "id" => "cs_sh_paddingbottom",
            "min" => '0',
            "max" => '200',
            "std" => "45",
            "type" => "range"
        );
        $options[] = array("name" => __("Content Text Align", 'LMS'),
            "desc" => "",
            "hint_text" => __("select the text Alignment for sub header content", 'LMS'),
            "id" => "cs_title_align",
            "std" => "on",
            "type" => "select",
            "options" => $navigation_style
        );
        $options[] = array("name" => __("Page Title", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set page title On/Off in sub header", 'LMS'),
            "id" => "cs_title_switch",
            "std" => "on",
            "type" => "checkbox"
        );


        $options[] = array("name" => __("Breadcrumbs", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_breadcrumbs_switch",
            "std" => "on",
            "type" => "checkbox"
        );

        $options[] = array("name" => __("Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_sub_header_bg_color",
            "std" => "#355c7d",
            "type" => "color"
        );
        $options[] = array("name" => __("Text Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_sub_header_text_color",
            "std" => "#999999",
            "type" => "color"
        );

        $options[] = array("name" => __("Border Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_sub_header_border_color",
            "std" => "#e0e0e0",
            "type" => "color"
        );

        $options[] = array("name" => __("Background", 'LMS'),
            "desc" => "",
            "hint_text" => __("Background Image", 'LMS'),
            "id" => "cs_background_img",
            "std" => "",
            "type" => "upload logo"
        );

        $options[] = array("name" => __("Parallax", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_parallax_bg_switch",
            "std" => "off",
            "type" => "checkbox"
        );
        /* $options[] = array( "name" => "Slider ON/OFF",
          "desc" => "",
          "hint_text" => "",
          "id" => "cs_slider_switch",
          "std" => "on",
          "type" => "checkbox"
          ); */


        // start footer options	

        $options[] = array("name" => __("footer options", 'LMS'),
            "id" => "tab-footer-options",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Footer section", 'LMS'),
            "desc" => "",
            "hint_text" => __("enable/disable footer area", 'LMS'),
            "id" => "cs_footer_switch",
            "std" => "on",
            "type" => "checkbox"
        );
        $options[] = array("name" => __("Footer Widgets", 'LMS'),
            "desc" => "",
            "hint_text" => __("enable/disable footer widget area", 'LMS'),
            "id" => "cs_footer_widget",
            "std" => "on",
            "type" => "checkbox"
        );


        $options[] = array("name" => __("Social Icons", 'LMS'),
            "desc" => "",
            "hint_text" => __("enable/disable Social Icons", 'LMS'),
            "id" => "cs_sub_footer_social_icons",
            "std" => "on",
            "type" => "checkbox");
        $options[] = array("name" => __("Footer Menu", 'LMS'),
            "desc" => "",
            "hint_text" => __("enable/disable Footer Menu", 'LMS'),
            "id" => "cs_sub_footer_menu",
            "std" => "on",
            "type" => "checkbox");
        $options[] = array("name" => __("NewsLetter Signup", 'LMS'),
            "desc" => "",
            "hint_text" => __("enable/disable NewsLetter Signup area", 'LMS'),
            "id" => "cs_footer_newsletter",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("footer logo", 'LMS'),
            "desc" => "",
            "hint_text" => __("set custom footer logo", 'LMS'),
            "id" => "cs_footer_logo",
            "std" => get_template_directory_uri() . "/assets/images/footer-logo.png",
            "type" => "upload logo");


        /* $options[] = array( "name" => "Menus",
          "desc" => "",
          "hint_text" => "",
          "id" =>   "cs_footer_navigation",
          "std" => "on",
          "type" => "select",
          "options" => $menus_locations
          ); */

        $options[] = array("name" => __("copyright text", 'LMS'),
            "desc" => "",
            "hint_text" => __("write your own copyright text", 'LMS'),
            "id" => "cs_copy_right",
            "std" => "&copy; 2014 Theme Options Wordpress All rights reserved.",
            "type" => "textarea"
        );


        /* $options[] = array( "name" => "Footer Layout",
          "desc" => "",
          "hint_text" => "choose predefined footer layout",
          "id" =>   "cs_footer_layout",
          "class" =>  "cs_footer",
          "std" => "footer_column_1",
          "type" => "layout1",
          "options" =>  array(
          "footer_column_1" => "footer_column_1",
          "footer_column_2" => "footer_column_2",
          "footer_column_3" => "footer_column_3",
          "footer_column_4" => "footer_column_4",
          "footer_column_5" => "footer_column_5",
          "footer_column_6" => "footer_column_6",
          "footer_column_half_sub_half" => "footer_column_half_sub_half",
          "footer_column_half_sub_third" => "footer_column_half_sub_third",
          "footer_column_sub_fourth_third" => "footer_column_sub_fourth_third",
          "footer_column_sub_half_half" => "footer_column_sub_half_half",
          "footer_column_sub_third_half" => "footer_column_sub_third_half",
          "footer_column_sub_third_third" => "footer_column_sub_third_third",
          "footer_column_third_sub_fourth" => "footer_column_third_sub_fourth",
          "footer_column_third_sub_third" => "footer_column_third_sub_third"

          )
          ); */
        // End footer tab setting
        /* general colors */
        $options[] = array("name" => __("general colors", 'LMS'),
            "id" => "tab-general-color",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Theme Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Choose theme skin color", 'LMS'),
            "id" => "cs_theme_color",
            "std" => "#355c7d",
            "type" => "color"
        );

        $options[] = array("name" => __("Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Choose Body Background Color", 'LMS'),
            "id" => "cs_bg_color",
            "std" => "#ffffff",
            "type" => "color"
        );

        $options[] = array("name" => __("Body Text Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Choose text color", 'LMS'),
            "id" => "cs_text_color",
            "std" => "#818181",
            "type" => "color"
        );

        // start top strip tab options
        $options[] = array("name" => __("header colors", 'LMS'),
            "id" => "tab-header-color",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("top strip colors", 'LMS'),
            "id" => "tab-top-strip-color",
            "std" => __("Top Strip", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Top Strip background color", 'LMS'),
            "id" => "cs_topstrip_bgcolor",
            "std" => "#ffffff",
            "type" => "color"
        );

        $options[] = array("name" => __("Text Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Top Strip text color", 'LMS'),
            "id" => "cs_topstrip_text_color",
            "std" => "#000000",
            "type" => "color"
        );

        $options[] = array("name" => __("Link Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Top Strip link color", 'LMS'),
            "id" => "cs_topstrip_link_color",
            "std" => "#000000",
            "type" => "color"
        );


        // end top stirp tab options
        // start header color tab options
        $options[] = array("name" => __("Header Colors", 'LMS'),
            "id" => "tab-header-color",
            "std" => __("Header Colors", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Header background color", 'LMS'),
            "id" => "cs_header_bgcolor",
            "std" => "",
            "type" => "color"
        );
        $options[] = array("name" => __("Navigation Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Header Navigation Background color", 'LMS'),
            "id" => "cs_nav_bgcolor",
            "std" => "#ffffff",
            "type" => "color"
        );



        $options[] = array("name" => __("Menu Link color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Header Menu Link color", 'LMS'),
            "id" => "cs_menu_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("Menu Active Link color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Header Menu Active Link color", 'LMS'),
            "id" => "cs_menu_active_color",
            "std" => "#355c7d",
            "type" => "color"
        );


        $options[] = array("name" => __("Submenu Background", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Submenu Background color", 'LMS'),
            "id" => "cs_submenu_bgcolor",
            "std" => "#ffffff",
            "type" => "color",
        );

        $options[] = array("name" => __("Submenu Link Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Submenu Link color", 'LMS'),
            "id" => "cs_submenu_color",
            "std" => "#666",
            "type" => "color"
        );

        $options[] = array("name" => __("Submenu Hover Link Color", 'LMS'),
            "desc" => "",
            "hint_text" => __("Change Submenu Hover Link color", 'LMS'),
            "id" => "cs_submenu_hover_color",
            "std" => "#355c7d",
            "type" => "color"
        );



        /* footer colors */
        $options[] = array("name" => __("footer colors", 'LMS'),
            "id" => "tab-footer-color",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Footer Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_footerbg_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("Footer Title Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_title_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("Footer Text Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_footer_text_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("Footer Link Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_link_color",
            "std" => "#fff",
            "type" => "color"
        );

        $options[] = array("name" => __("Footer Widget Background Color", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_sub_footerbg_color",
            "std" => "#f4f2ee",
            "type" => "color"
        );

        $options[] = array("name" => __("Copyright Text", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_copyright_text_color",
            "std" => "#666666",
            "type" => "color"
        );

        /* heading colors */
        $options[] = array("name" => __("heading colors", 'LMS'),
            "id" => "tab-heading-color",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("heading h1", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h1_color",
            "std" => "#2b2c30",
            "type" => "color"
        );

        $options[] = array("name" => __("heading h2", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h2_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("heading h3", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h3_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("heading h4", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h4_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("heading h5", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h5_color",
            "std" => "#333333",
            "type" => "color"
        );

        $options[] = array("name" => __("heading h6", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_h6_color",
            "std" => "#333333",
            "type" => "color"
        );

        // end header color tab options	

        /* start custom font family */
        $options[] = array("name" => __("Custom Fonts", 'LMS'),
            "id" => "tab-custom-font",
            "type" => "sub-heading"
        );

        $options[] = array("name" => __("Custom Font .woff", 'LMS'),
            "desc" => "",
            "hint_text" => __("Custom font for your site upload .woff format file", 'LMS'),
            "id" => "cs_custom_font_woff",
            "std" => "",
            "type" => "upload font"
        );

        $options[] = array("name" => __("Custom Font .ttf", 'LMS'),
            "desc" => "",
            "hint_text" => __("Custom font for your site upload .ttf format file.", 'LMS'),
            "id" => "cs_custom_font_ttf",
            "std" => "",
            "type" => "upload font"
        );

        $options[] = array("name" => __("Custom Font .svg", 'LMS'),
            "desc" => "",
            "hint_text" => __("Custom font for your site upload .svg format file.", 'LMS'),
            "id" => "cs_custom_font_svg",
            "std" => "",
            "type" => "upload font"
        );

        $options[] = array("name" => __("Custom Font .eot", 'LMS'),
            "desc" => "",
            "hint_text" => __("Custom font for your site upload .eot format file.", 'LMS'),
            "id" => "cs_custom_font_eot",
            "std" => "",
            "type" => "upload font"
        );

        /* start font family */
        $options[] = array("name" => __("font family", 'LMS'),
            "id" => "tab-font-family",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Content Font", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set fonts for Body text", 'LMS'),
            "id" => "cs_content_font",
            "std" => "Roboto",
            "type" => "gfont_select",
            "options" => $g_fonts
        );
        $options[] = array("name" => __("Content Font Attribute", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set Font Attribute", 'LMS'),
            "id" => "cs_content_font_att",
            "std" => "",
            "type" => "gfont_att_select",
            "options" => $g_fonts_atts
        );
        $options[] = array("name" => __("Main Menu Font", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set font for main Menu. It will be applied to sub menu as well", 'LMS'),
            "id" => "cs_mainmenu_font",
            "std" => "Roboto",
            "type" => "gfont_select",
            "options" => $g_fonts
        );
        $options[] = array("name" => __("Main Menu Font Attribute", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set Font Attribute", 'LMS'),
            "id" => "cs_mainmenu_font_att",
            "std" => "",
            "type" => "gfont_att_select",
            "options" => $g_fonts_atts
        );
        $options[] = array("name" => __("Headings Font", 'LMS'),
            "desc" => "",
            "hint_text" => __("Select font for Headings. It will apply on all posts and pages headings", 'LMS'),
            "id" => "cs_heading_font",
            "std" => "Cabin",
            "type" => "gfont_select",
            "options" => $g_fonts
        );
        $options[] = array("name" => __("Headings Font Attribute", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set Font Attribute", 'LMS'),
            "id" => "cs_heading_font_att",
            "std" => "",
            "type" => "gfont_att_select",
            "options" => $g_fonts_atts
        );
        $options[] = array("name" => __("Widget Headings Font", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set font for Widget Headings", 'LMS'),
            "id" => "cs_widget_heading_font",
            "std" => "Cabin",
            "type" => "gfont_select",
            "options" => $g_fonts
        );
        $options[] = array("name" => __("Widget Headings Font Attribute", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set Font Attribute", 'LMS'),
            "id" => "cs_widget_heading_font_att",
            "std" => "",
            "type" => "gfont_att_select",
            "options" => $g_fonts_atts
        );
        /* start font size */
        $options[] = array("name" => __("Font size", 'LMS'),
            "id" => "tab-font-size",
            "type" => "sub-heading"
        );

        $options[] = array("name" => __("Content", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_content_size",
            "min" => '6',
            "max" => '50',
            "std" => "14",
            "type" => "range"
        );
        $options[] = array("name" => __("Main Menu", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_mainmenu_size",
            "min" => '6',
            "max" => '50',
            "std" => "12",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 1", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_1_size",
            "min" => '6',
            "max" => '50',
            "std" => "24",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 2", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_2_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 3", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_3_size",
            "min" => '6',
            "max" => '50',
            "std" => "18",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 4", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_4_size",
            "min" => '6',
            "max" => '50',
            "std" => "16",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 5", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_5_size",
            "min" => '6',
            "max" => '50',
            "std" => "14",
            "type" => "range"
        );
        $options[] = array("name" => __("Heading 6", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_heading_6_size",
            "min" => '6',
            "max" => '50',
            "std" => "12",
            "type" => "range"
        );

        $options[] = array("name" => __("Widget Heading", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_widget_heading_size",
            "min" => '6',
            "max" => '50',
            "std" => "15",
            "type" => "range"
        );

        /* social icons setting */
        $options[] = array("name" => __("social icons", 'LMS'),
            "id" => "tab-social-setting",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Social Network", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_social_network",
            "std" => "",
            "type" => "networks",
            "options" => $social_network
        );
        /* social icons end */
        /* social Network setting */

        $options[] = array("name" => __("social Sharing", 'LMS'),
            "id" => "tab-social-network",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Facebook", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_facebook_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Twitter", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_twitter_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Google Plus", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_google_plus_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Pinterest", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_pintrest_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Tumblr", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_tumblr_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Dribbble", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_dribbble_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Instagram", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_instagram_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("StumbleUpon", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_stumbleupon_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("youtube", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_youtube_share",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("share more", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_share_share",
            "std" => "on",
            "type" => "checkbox");

        /* social network end */

        /* custom code setting */
        $options[] = array("name" => __("custom code", 'LMS'),
            "id" => "tab-custom-code",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Custom Css", 'LMS'),
            "desc" => "",
            "hint_text" => __("write you custom css without style tag", 'LMS'),
            "id" => "cs_custom_css",
            "std" => "",
            "type" => "textarea"
        );

        $options[] = array("name" => __("Custom JavaScript", 'LMS'),
            "desc" => "",
            "hint_text" => __("write you custom js without script tag", 'LMS'),
            "id" => "cs_custom_js",
            "std" => "",
            "type" => "textarea"
        );

        /* sidebar tab */
        $options[] = array("name" => __("sidebar", 'LMS'),
            "id" => "tab-sidebar",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Sidebar", 'LMS'),
            "desc" => "",
            "hint_text" => __("Select a sidebar from the list already given. (Nine pre-made sidebars are given)", 'LMS'),
            "id" => "cs_sidebar",
            "std" => $sidebar,
            "type" => "sidebar",
            "options" => $sidebar
        );

        $options[] = array("name" => __("post layout", 'LMS'),
            "id" => "cs_non_metapost_layout",
            "std" => __("single post layout", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Single Post Layout", 'LMS'),
            "desc" => "",
            "hint_text" => __("Use this option to set default layout. It will be applied to all posts", 'LMS'),
            "id" => "cs_single_post_layout",
            "std" => __("full width", 'LMS'),
            "type" => "layout",
            "options" => array(
                "no_sidebar" => __("full width", "LMS"),
                "sidebar_left" => __("sidebar left", "LMS"),
                "sidebar_right" => __("sidebar right", "LMS"),
            )
        );

        $options[] = array("name" => __("Single Layout Sidebar", 'LMS'),
            "desc" => "",
            "hint_text" => __("Select Single Post Layout of your choice for sidebar layout. You cannot select it for full width layout", 'LMS'),
            "id" => "cs_single_layout_sidebar",
            "std" => "",
            "type" => "select_sidebar",
            "options" => $cs_sidebar
        );

        $options[] = array("name" => __("default pages", 'LMS'),
            "id" => "default_pages",
            "std" => __("default pages", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Default Pages Layout", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set Sidebar for all pages like Search, Author Archive, Category Archive etc", 'LMS'),
            "id" => "cs_default_page_layout",
            "std" => "sidebar_right",
            "type" => "layout",
            "options" => array(
                "no_sidebar" => __("full width", 'LMS'),
                "sidebar_left" => __("sidebar left", 'LMS'),
                "sidebar_right" => __("sidebar right", 'LMS'),
            )
        );
        $options[] = array("name" => __("Sidebar", 'LMS'),
            "desc" => "",
            "hint_text" => __("Select pre-made sidebars for default pages on sidebar layout. Full width layout cannot have sidebars", 'LMS'),
            "id" => "cs_default_layout_sidebar",
            "std" => __("Blogs Sidebar", 'LMS'),
            "type" => "select_sidebar",
            "options" => $cs_sidebar
        );
        $options[] = array("name" => __("Excerpt", 'LMS'),
            "desc" => "",
            "hint_text" => __("Set excerpt length/limit from here. It controls text limit for post's content", 'LMS'),
            "id" => "cs_excerpt_length",
            "std" => "255",
            "type" => "text"
        );

        /* seo */
        $options[] = array("name" => __("SEO", 'LMS'),
            "id" => "tab-seo",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Attention for External Seo Plugins", "LMS"),
            "id" => "header_postion_attention",
            "std" => __("If you are using any external Seo plugin, Turn Off these options", 'LMS'),
            "type" => "announcement"
        );

        $options[] = array("name" => __("Built-in Seo fields", 'LMS'),
            "desc" => "",
            "hint_text" => __("Turn Seo options On/Off", 'LMS'),
            "id" => "cs_builtin_seo_fields",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Meta Description", 'LMS'),
            "desc" => "",
            "hint_text" => __("HTML attributes that explain the contents of web pages commonly used on search engine result pages (SERPs) for pages snippets", 'LMS'),
            "id" => "cs_meta_description",
            "std" => "",
            "type" => "text"
        );

        $options[] = array("name" => __("Meta Keywords", 'LMS'),
            "desc" => "",
            "hint_text" => __("Attributes of meta tags, a list of comma-separated words included in the HTML of a Web page that describe the topic of that page", 'LMS'),
            "id" => "cs_meta_keywords",
            "std" => "",
            "type" => "text"
        );

        $options[] = array("name" => __("Google Analytics", 'LMS'),
            "desc" => "",
            "hint_text" => __("Google Analytics is a service offered by Google that generates detailed statistics about a website's traffic, traffic sources, measures conversions and sales. Paste Google Analytics code here", 'LMS'),
            "id" => "cs_google_analytics",
            "std" => "",
            "type" => "textarea"
        );

        /* maintenance mode */
        $options[] = array("name" => __("Maintenance Mode", 'LMS'),
            "fontawesome" => 'fa fa-tasks',
            "id" => "tab-maintenace-mode",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        $options[] = array("name" => __("Maintenance Mode", 'LMS'),
            "id" => "tab-maintenace-mode",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Maintenace Page", 'LMS'),
            "desc" => "",
            "hint_text" => __("Users will see Maintenance page & logged in Admin will see normal site.", 'LMS'),
            "id" => "cs_maintenance_page_switch",
            "std" => "off",
            "type" => "checkbox");

        $options[] = array("name" => __("Show Logo", 'LMS'),
            "desc" => "",
            "hint_text" => __("Show/Hide logo on Maintenance. Logo can be uploaded from General > Header in CS Theme options.", 'LMS'),
            "id" => "cs_maintenance_logo_switch",
            "std" => "on",
            "type" => "checkbox");

        $options[] = array("name" => __("Maintenance Text", 'LMS'),
            "desc" => "",
            "hint_text" => __("Text for Maintenance page. Insert some basic HTML or use shortcodes here.", 'LMS'),
            "id" => "cs_maintenance_text",
            "std" => "<h1>Sorry, We are down for maintenance </h1><p>We're currently under maintenance, if all goas as planned we'll be back in</p>",
            "type" => "textarea"
        );

        $options[] = array("name" => __("Launch Date", 'LMS'),
            "desc" => "",
            "hint_text" => __("Estimated date for completion of site on Maintenance page.", 'LMS'),
            "id" => "cs_launch_date",
            "std" => gmdate("dd/mm/yy"),
            "type" => "text"
        );

        $options[] = array("name" => __("Social Network", 'LMS'),
            "desc" => "",
            "hint_text" => __("Re-direct your users to social networking links when site is on Maintenance mode.", 'LMS'),
            "id" => "cs_maintenance_social_network",
            "std" => "on",
            "type" => "checkbox");
        /* api options tab */
        $options[] = array("name" => __("api settings", 'LMS'),
            "fontawesome" => 'fa fa-chain-broken',
            "id" => "tab-api-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        //Start Twitter Api	
        $options[] = array("name" => __("all api settings", 'LMS'),
            "id" => "tab-api-options",
            "type" => "sub-heading"
        );
        $options[] = array("name" => __("Twitter", 'LMS'),
            "id" => "Twitter",
            "std" => "Twitter",
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Attention for API Settings!", 'LMS'),
            "id" => "header_postion_attention",
            "std" => __("API Settings allows admin of the site to show their activity on site semi-automatically. Set your social account API once, it will be update your social activity automatically on your site", 'LMS'),
            "type" => "announcement"
        );
        $options[] = array("name" => __("Show Twitter", 'LMS'),
            "desc" => "",
            "hint_text" => __("Turn Twitter option On/Off", 'LMS'),
            "id" => "cs_twitter_api_switch",
            "std" => "off",
            "type" => "checkbox");
			$options[] = array("name" => __("Cache Time Limit", 'dir'),
            "desc" => "",
            "hint_text" => "Please enter the time limit in minutes for refresh cache",
            "id" => "cs_cache_limit_time",
            "std" => "",
            "type" => "text");
        
        $options[] = array("name" => __("Number of tweet", 'dir'),
            "desc" => "",
            "hint_text" => "Please enter number of tweet that you get from twitter for chache file.",
            "id" => "cs_tweet_num_post",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Date Time Formate", 'dir'),
            "desc" => "",
            "hint_text" => __("Select date time formate for every tweet.", 'dir'),
            "id" => "cs_twitter_datetime_formate",
            "std" => "",
            "type" => "select_values",
            "options" => array(
                'default' => __('Displays November 06 2012', 'dir'),
                'eng_suff' => __('Displays 6th November', 'dir'),
                'ddmm' => __('Displays 06 Nov', 'dir'),
                'ddmmyy' => __('Displays 06 Nov 2012', 'dir'),
                'full_date' => __('Displays Tues 06 Nov 2012', 'dir'),
                'time_since' => __('Displays in hours, minutes etc', 'dir'),                
            )
        );
        $options[] = array("name" => __("Consumer Key", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_consumer_key",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Consumer Secret", 'LMS'),
            "desc" => "",
            "hint_text" => __("Insert consumer key. To get your account key, <a href='https://dev.twitter.com/' target='_blank'>Click Here </a>", 'LMS'),
            "id" => "cs_consumer_secret",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Access Token", 'LMS'),
            "desc" => "",
            "hint_text" => __("Insert Twitter Access Token for permissions. When you create your Twitter App, you get this Token", 'LMS'),
            "id" => "cs_access_token",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Access Token Secret", 'LMS'),
            "desc" => "",
            "hint_text" => __("Insert Twitter Access Token Secret here. When you create your Twitter App, you get this Token", 'LMS'),
            "id" => "cs_access_token_secret",
            "std" => "",
            "type" => "text");
        //end Twitter Api
        //Start Facebook Api
        $options[] = array("name" => __("Facebook", 'LMS'),
            "id" => __("Facebook", 'LMS'),
            "std" => __("Facebook", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Facebook Login On/Off", 'LMS'),
            "desc" => "",
            "hint_text" => __("Turn Facebook Login On/Off", 'LMS'),
            "id" => "cs_facebook_login_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option);

        $options[] = array("name" => __("Facebook Application Id", 'LMS'),
            "desc" => "",
            //"hint_text" =>__("To get your Facebook Aplication ID <a href='https://developers.facebook.com/docs/graph-api/reference/v2.1/app' target='_blank'>Click Here </a>",'LMS'),
            "id" => "cs_facebook_app_id",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Facebook  Secret", 'LMS'),
            "desc" => "",
            "hint_text" => __("Put your Facebook Secret here. You can find it in your facebook Application Dashboard", 'LMS'),
            "id" => "cs_facebook_secret",
            "std" => "",
            "type" => "text");

        //end facebook api
        //start google api
        $options[] = array("name" => __("Google", 'LMS'),
            "id" => "Google",
            "std" => "Google+",
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Google+ Login On/Off", 'LMS'),
            "desc" => "",
            "hint_text" => __("Turn Google+ Login On/Off", 'LMS'),
            "id" => "cs_google_login_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option);

        $options[] = array("name" => __("Google+ Client Id", 'LMS'),
            "desc" => "",
            "hint_text" => __("Type your Google Login information here", 'LMS'),
            "id" => "cs_google_client_id",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Google+ Client Secret", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_google_client_secret",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Google+ API key", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_google_api_key",
            "std" => "",
            "type" => "text");

        $options[] = array("name" => __("Fixed redirect url for login", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_google_login_redirect_url",
            "std" => "",
            "type" => "text");

        //end google api
        //start mailChimp api
        $options[] = array("name" => __("Mail Chimp", 'LMS'),
            "id" => "mailchimp",
            "std" => __("Mail Chimp", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Mail Chimp Key", 'LMS'),
            "desc" => __("Enter a valid Mail Chimp API key here to get started. Once you've done that, you can use the Mail Chimp Widget from the Widgets menu. You will need to have at least Mail Chimp list set up before the using the widget. You can get your mail chimp activation key", 'LMS'),
            //"hint_text" =>__("Get your mailchimp key by <a href='https://login.mailchimp.com/' target='_blank'>Clicking Here </a>",'LMS'),
            "id" => "cs_mailchimp_key",
            "std" => "90f86a57314446ddbe87c57acc930ce8-us2",
            "type" => "text"
        );

        $options[] = array("name" => __("Mail Chimp List", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "cs_mailchimp_list",
            "std" => "on",
            "type" => "mailchimp",
            "options" => $mail_chimp_list
        );

        $options[] = array("name" => __("Flickr API Setting", 'LMS'),
            "id" => "flickr_api_setting",
            "std" => __("Flickr API Setting", 'LMS'),
            "type" => "section",
            "options" => ""
        );
        $options[] = array("name" => __("Flickr key", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "flickr_key",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => __("Flickr secret", 'LMS'),
            "desc" => "",
            "hint_text" => "",
            "id" => "flickr_secret",
            "std" => "",
            "type" => "text");

        #import and export theme options tab
        $options[] = array("name" => __("import & export", 'LMS'),
            "fontawesome" => 'icon-database',
            "id" => "tab-import-export-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        $options[] = array("name" => __("import & export", 'LMS'),
            "id" => "tab-import-export-options",
            "type" => "sub-heading"
        );

        $options[] = array("name" => __("Theme Backup Options", 'LMS'),
            "std" => __("Theme Backup Options", 'LMS'),
            "id" => "theme-bakups-options",
            "type" => "section"
        );
        $options[] = array("name" => __("Backup", 'LMS'),
            "desc" => "",
            "hint_text" => __("", 'LMS'),
            "id" => "cs_backup_options",
            "std" => "",
            "type" => "generate_backup"
        );

        if (class_exists('cs_widget_data')) {

            $options[] = array("name" => __("Widgets Backup Options", 'LMS'),
                "std" => __("Widgets Backup Options", 'LMS'),
                "id" => "widgets-bakups-options",
                "type" => "section"
            );

            $options[] = array("name" => __("Widgets Backup", 'LMS'),
                "desc" => "",
                "hint_text" => '',
                "id" => "cs_widgets_backup",
                "std" => "",
                "type" => "widgets_backup"
            );
        }

        update_option('cs_theme_data', $options);
        //update_option('cs_theme_options',$options); 					  
    }

}

// saving all the theme options start
/**
 *
 *
 * Header Colors Setting
 */
function cs_header_setting() {
    global $header_colors;
    $header_colors = array();
    $header_colors['header_colors'] = array(
        'header_1' => array(
            'color' => array(
                'cs_topstrip_bgcolor' => '#ffffff',
                'cs_topstrip_text_color' => '#000000',
                'cs_topstrip_link_color' => '#000000',
                'cs_header_bgcolor' => '',
                'cs_nav_bgcolor' => '#ffffff',
                'cs_menu_color' => '#333333',
                'cs_menu_active_color' => '#355c7d',
                'cs_submenu_bgcolor' => '#ffffff',
                'cs_submenu_color' => '#666666',
                'cs_submenu_hover_color' => '#355c7d',
            ),
            'logo' => array(
                'cs_logo_with' => '159',
                'cs_logo_height' => '41',
                'cs_logo_margintb' => '18',
                'cs_logo_marginlr' => '0',
            )
        ),
    );

    return $header_colors;
}
