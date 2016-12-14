<?php
/**
 * The template Theme Colors
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
 
/** 
 * @Set Theme Colors
 */
 
 
 if ( ! function_exists( 'cs_theme_colors' ) ) {
	function cs_theme_colors(){
		global $post,$cs_theme_options,$page_colors;
 		$cs_theme_color = $cs_theme_options['cs_theme_color'];
		$sub_header_border_color = isset($cs_theme_options['cs_sub_header_border_color']) ? $cs_theme_options['cs_sub_header_border_color'] : '';
		$main_header_border_color = isset($cs_theme_options['cs_header_border_color']) ? $cs_theme_options['cs_header_border_color'] : '';
		
		$page_header_style = '';
		$page_header_border_colr = '';
		$page_subheader_border_color = '';
		if(is_page() || is_single()){
			$cs_post_type = get_post_type($post->ID);
			switch($cs_post_type){
				case 'courses':
					$post_type_meta = 'cs_course';
					break;
				case 'post':
					$post_type_meta = 'post';
					break;
				default:
					$post_type_meta = 'cs_page_builder';
			}
			
			$cs_page_bulider = get_post_meta($post->ID, "$post_type_meta", true);
			$cs_xmlObject = new stdClass();
			if(isset($cs_page_bulider) && $cs_page_bulider <> ''){
				$cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
				$page_header_style = $cs_xmlObject->header_banner_style;
				$page_header_border_colr = $cs_xmlObject->page_main_header_border_color;
				$page_subheader_border_color = $cs_xmlObject->page_subheader_border_color;
			}
		}
 ?>
<style type="text/css">
/*!
* Theme Color File */

/*!
* Theme Color */
.cs-color, .cs-colorhover:hover, /* EventListing */ .bullet-crl .fa-circle.fa-stack-1x, /* Tabs */ .cs-tabs .nav-tabs > li.active > a, .cs-tabs .nav-tabs > li.active > i, /* Blockquote */ blockquote:before, .serach-result .post-option li a, /* Search */ .cs-search.cs-searchv2 form label:before, .cs-list h2 a:hover, .widget_instrector .left-sp h5, .bloginfo h2 a:hover, .cs-widget-info a, .widget_instrector ul li h5 a, .bullet-crl .fa-stack-1x, .cs-list.list_v4 .cs-list-wrapp:after,.has-login.cs-signup .cs-user-menu li:hover a,ul.ev-option li a,/* EventView */.cs-ev-default .cstime,.event-list:hover h2 a,.cs-login-form-section h6 a,.panel-title > a:hover,.accordion-v1 .panel-title a:after,.courses a.custom-btn,.cs-blog .bloginfo a.custom-btn,.cs-ev-elite .cstime,
.content_tag a:hover,.by-user a,.comment-reply-link,.post-option-panel .post-options li a, /* Woocommerce */.cs_course_categories.cat-plain ul li:hover i,.cs_course_categories.cat-plain ul li:hover a,.cs_course_categories.cat-clean ul li:hover a,.cs_course_categories.cat-clean ul li i,.cs-ev-plain figure .cstime,.cs-ev-listing .cstime,
.portfoliopage article:hover .text p, .portfoliopage article:hover .text p a, .portfoliopage article:hover .text h2 a, .portfoliopage article:hover .text p i,.cs-ev-timeline .cstime,.ev-btn,
.cs-team.team_grid_sh .social-media a:hover i, .cs-team.team_grid_sh .social-media a:hover,.course-more a,.widget_instrector a.custom-btn,
/* ShopButton */.woocommerce ul.products li.product a.add_to_cart_button, .woocommerce-page ul.products li.product a.add_to_cart_button,
.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button /* ShopButton */ {
 color:<?php echo esc_attr($cs_theme_color);
?> !important;
}
/*!
* Theme Background Color */
.cs-bg-color, .cs-bg-colorhover:hover, /* Navigation */ .navigation > li:hover > a, .navigation li a span, .filter-pager a.active, .filter-pager a:hover, /* PlayList */ .mejs-playlist li:hover, .mejs-playlist li.current, /* Pagination */ .pagination ul li a:hover, /* Widget Calendar */ .widget_calendar tfoot tr td a, /* TagCloud */ .tagcloud a:hover, /* UnderConstrucion */ #underconstrucion:before, /* Signup */ .user-signup input[type="submit"], /* WidgetUserList */ /* Widget_nav_menu */.widget_nav_menu ul li a:hover, .cs-widget-info ul li a:hover, .widget_categories ul li:hover, .widget_archive ul li:hover, .widget_pages > ul > li:hover, .widget_recent_comments ul li:hover, .widget_recent_entries ul li:hover, .widget_meta ul li:hover, /* EventList View */ .ev-attend, /* Blockquote */ blockquote .cs-user-name span, /* Accordion */ .accordion-v3 .panel-default > .panel-heading a:after, .accordion-v3 .panel-title a.collapsed:after, .accordion-v2 .panel-title a.collapse,/* Services */ .cs-services article.size_large:hover figure i, .cs-filter-menu li a.addclose, .cs-filter-menu li a:hover,/* RegistorPage */ .registor-log a, /* WidgetBlog */ /* Form7 */ .wpcf7 form p input[type="submit"], /* Detail Share Section */ .cs-share-post-section a:hover, /* Woocommerce */ .woocommerce ul.products li.product:hover a.add_to_cart_button, .woocommerce-page ul.products li.product:hover a.add_to_cart_button, .woocommerce ul.products li.product:hover a.add_to_cart_button:after, .woocommerce-page ul.products li.product:hover a.add_to_cart_button:after,/* Woocommerce */ /* Header */ .strip-listing li span.amount, .cs-team .social-media a:hover,/* EventsCalendar */ .eventsCalendar-daysList li.today a, .eventsCalendar-daysList li.dayWithEvents a,.blog-hover,.blog-icon,.flex-direction-nav a:hover,.blog_thumb figure figcaption a,/* EventLisitng */.cs-ev-modren:before,.cs-ev-listing figcaption:before,.cs-ev-grid .cstime,.cs-ev-grid figcaption:before,/* CoursesListing */ article.cs-minimal-view:hover,/* EventInfo */.event-info h6,.event-info .custom-btn,.filters input[type=submit],#process_newsletter_1,.cs-unique-view:hover,.widget_calendar tbody tr td a,.quiz-pagination li.active a,.ans-section,.grid_team_view .text:before,.cs-testimonial p:before,
.widget-recent-blog .recent-inn:before,.cs_course_categories ul li:hover .cat-inner,.cs_counter a.custom-btn,.cs_assigment_tabs ul li.active:before,.cs-user:hover,.password_protected input[type="submit"],.password_protected .protected-icon,.portfoliopage article figure figcaption:before, .filter_nav ul li.active a, .filter_nav ul li:hover a, .custom-btn:hover,
.ev-btn:hover,.cs-user:hover,.cs-login-sec:hover .cs-user-login,.widget_product_search input[type="submit"],.content-slider .owl-nav div:hover,.nxt-prv-v2 .owl-nav div:hover,
.course-more a:hover,/* ShopButton */
.woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover,/* ShopButton */
.widget_dfreview .dfreview_inn a.custom-btn  {
 background-color:<?php echo esc_attr($cs_theme_color); ?> !important;
}
/*!
* Theme Border Color */
.cs-bor-color, .cs-bor-colorhover:hover, /* Header */ #main-header.has_border, .sub-menu .dropdown-menu, .mega-grid, #lang_sel ul ul, .cs-search.cs-searchv2,.courses a.custom-btn,.ev-btn,
.course-more a,
/* ShopButton */.woocommerce ul.products li.product a.add_to_cart_button, .woocommerce-page ul.products li.product a.add_to_cart_button,
.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button /* ShopButton */ {
 border-color:<?php echo esc_attr($cs_theme_color);
?> !important;
}
.cs-tabs.nav_position_left .tab-content, .cs-tabs .tab-content {
 border-bottom-color:<?php echo esc_attr($cs_theme_color);
?> !important;
}

<?php
if((is_page() || is_single()) and ($page_header_style == 'breadcrumb_header' and $page_subheader_border_color <> '')){
	?>
	.breadcrumb-sec {
		border-top: 1px solid <?php echo cs_allow_special_char($page_subheader_border_color); ?> !important;
		border-bottom: 1px solid <?php echo cs_allow_special_char($page_subheader_border_color); ?> !important;
	}
	<?php
}
else{
	if($sub_header_border_color <> ''){
	?>
		.breadcrumb-sec {
			border-top: 1px solid <?php echo cs_allow_special_char($sub_header_border_color); ?> !important;
			border-bottom: 1px solid <?php echo cs_allow_special_char($sub_header_border_color); ?> !important;
		}
	<?php
	}
}

if((is_page() || is_single()) and ($page_header_style == 'no-header' and $page_header_border_colr <> '')){
	?>
	#main-header {
		border-bottom: 1px solid <?php echo cs_allow_special_char($page_header_border_colr); ?> !important;
	}
	<?php
}
else{
	if(isset($cs_theme_options['cs_default_header']) and $cs_theme_options['cs_default_header'] == 'No sub Header'){
		if($main_header_border_color <> ''){
		?>
			#main-header {
				border-bottom: 1px solid <?php echo cs_allow_special_char($main_header_border_color); ?> !important;
			}
		<?php
		}
	}
}
?>

</style>
<?php } 
}


/** 
 * @Set Header color Css
 */
if ( ! function_exists( 'cs_header_color' ) ) {
	function cs_header_color(){
		global $cs_theme_options;
		
		$cs_header_bgcolor	= (isset($cs_theme_options['cs_header_bgcolor']) and $cs_theme_options['cs_header_bgcolor']<>'') ? $cs_theme_options['cs_header_bgcolor']: '';
		
		$cs_nav_bgcolor =  (isset($cs_theme_options['cs_nav_bgcolor']) and $cs_theme_options['cs_nav_bgcolor']<>'') ? $cs_theme_options['cs_nav_bgcolor']: '';
		
		$cs_menu_color = (isset($cs_theme_options['cs_menu_color']) and $cs_theme_options['cs_menu_color']<>'') ? $cs_theme_options['cs_menu_color']:'';
		
		$cs_menu_active_color = (isset($cs_theme_options['cs_menu_active_color']) and $cs_theme_options['cs_menu_active_color']<>'') ? $cs_theme_options['cs_menu_active_color']: '';
		
		$cs_submenu_bgcolor = (isset($cs_theme_options['cs_submenu_bgcolor']) and $cs_theme_options['cs_submenu_bgcolor']<>'' ) ? $cs_theme_options['cs_submenu_bgcolor']: '';
		
		$cs_submenu_color = (isset($cs_theme_options['cs_submenu_color']) and $cs_theme_options['cs_submenu_color']<>'') ? $cs_theme_options['cs_submenu_color']: '';
		
		$cs_submenu_hover_color = (isset($cs_theme_options['cs_submenu_hover_color']) and $cs_theme_options['cs_submenu_hover_color']<>'') ? $cs_theme_options['cs_submenu_hover_color']: '';
		
		$cs_topstrip_bgcolor = (isset($cs_theme_options['cs_topstrip_bgcolor']) and $cs_theme_options['cs_topstrip_bgcolor']<>'') ? $cs_theme_options['cs_topstrip_bgcolor']: '';
		
		$cs_topstrip_text_color = (isset($cs_theme_options['cs_topstrip_text_color']) and $cs_theme_options['cs_topstrip_text_color']<>'') ? $cs_theme_options['cs_topstrip_text_color']: '';
		
		$cs_topstrip_link_color = (isset($cs_theme_options['cs_topstrip_link_color']) and $cs_theme_options['cs_topstrip_link_color']<>'') ? $cs_theme_options['cs_topstrip_link_color']: '';
		
		$cs_menu_activ_bg = (isset($cs_theme_options['cs_theme_color'])) ? $cs_theme_options['cs_theme_color']: '';
		
		/* logo margins*/
		$cs_logo_margintb = (isset($cs_theme_options['cs_logo_margintb']) and  $cs_theme_options['cs_logo_margintb'] <> '') ? $cs_theme_options['cs_logo_margintb']: '0';
		$cs_logo_marginlr = (isset($cs_theme_options['cs_logo_marginlr']) and  $cs_theme_options['cs_logo_marginlr'] <> '') ? $cs_theme_options['cs_logo_marginlr']: '0';

		/* font family */
		$cs_content_font = (isset($cs_theme_options['cs_content_font'])) ? $cs_theme_options['cs_content_font']: '';
		$cs_content_font_att = (isset($cs_theme_options['cs_content_font_att'])) ? $cs_theme_options['cs_content_font_att']: '';
		
		$cs_mainmenu_font = (isset($cs_theme_options['cs_mainmenu_font'])) ? $cs_theme_options['cs_mainmenu_font']: '';
		$cs_mainmenu_font_att = (isset($cs_theme_options['cs_mainmenu_font_att'])) ? $cs_theme_options['cs_mainmenu_font_att']: '';
		
		$cs_heading_font = (isset($cs_theme_options['cs_heading_font'])) ? $cs_theme_options['cs_heading_font']: '';
		$cs_heading_font_att = (isset($cs_theme_options['cs_heading_font_att'])) ? $cs_theme_options['cs_heading_font_att']: '';
		
		$cs_widget_heading_font = (isset($cs_theme_options['cs_widget_heading_font'])) ? $cs_theme_options['cs_widget_heading_font']: '';
		$cs_widget_heading_font_att = (isset($cs_theme_options['cs_widget_heading_font_att'])) ? $cs_theme_options['cs_widget_heading_font_att']: '';
		
		// setting content fonts
		$cs_content_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_content_font_att);
		
		$cs_content_font_atts = cs_get_font_att_array($cs_content_fonts);
		
		// setting main menu fonts
		$cs_mainmenu_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_mainmenu_font_att);
		
		$cs_mainmenu_font_atts = cs_get_font_att_array($cs_mainmenu_fonts);
		
		// setting heading fonts
		$cs_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_heading_font_att);
		
		$cs_heading_font_atts = cs_get_font_att_array($cs_heading_fonts);
		
		// setting widget heading fonts
		$cs_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_widget_heading_font_att);
		
		$cs_widget_heading_font_atts = cs_get_font_att_array($cs_widget_heading_fonts);
 		
		/* font size */
		$cs_content_size = (isset($cs_theme_options['cs_content_size'])) ? $cs_theme_options['cs_content_size']: '';
		$cs_mainmenu_size = (isset($cs_theme_options['cs_mainmenu_size'])) ? $cs_theme_options['cs_mainmenu_size']: '';
		$cs_heading_1_size = (isset($cs_theme_options['cs_heading_1_size'])) ? $cs_theme_options['cs_heading_1_size']: '';
		$cs_heading_2_size = (isset($cs_theme_options['cs_heading_2_size'])) ? $cs_theme_options['cs_heading_2_size']: '';
		$cs_heading_3_size = (isset($cs_theme_options['cs_heading_3_size'])) ? $cs_theme_options['cs_heading_3_size']: '';
		$cs_heading_4_size = (isset($cs_theme_options['cs_heading_4_size'])) ? $cs_theme_options['cs_heading_4_size']: '';
		$cs_heading_5_size = (isset($cs_theme_options['cs_heading_5_size'])) ? $cs_theme_options['cs_heading_5_size']: '';
		$cs_heading_6_size = (isset($cs_theme_options['cs_heading_6_size'])) ? $cs_theme_options['cs_heading_6_size']: '';
		
		/* font Color */
		$cs_heading_h1_color = (isset($cs_theme_options['cs_heading_h1_color']) and $cs_theme_options['cs_heading_h1_color'] <> '') ? $cs_theme_options['cs_heading_h1_color']: '';
		$cs_heading_h2_color = (isset($cs_theme_options['cs_heading_h2_color']) and $cs_theme_options['cs_heading_h2_color'] <> '') ? $cs_theme_options['cs_heading_h2_color']: '';
		$cs_heading_h3_color = (isset($cs_theme_options['cs_heading_h3_color']) and $cs_theme_options['cs_heading_h3_color'] <> '') ? $cs_theme_options['cs_heading_h3_color']: '';
		$cs_heading_h4_color = (isset($cs_theme_options['cs_heading_h4_color']) and $cs_theme_options['cs_heading_h4_color'] <> '') ? $cs_theme_options['cs_heading_h4_color']:'';
		$cs_heading_h5_color = (isset($cs_theme_options['cs_heading_h5_color']) and $cs_theme_options['cs_heading_h5_color'] <> '') ? $cs_theme_options['cs_heading_h5_color']: '';
		$cs_heading_h6_color = (isset($cs_theme_options['cs_heading_h6_color']) and $cs_theme_options['cs_heading_h6_color'] <> '') ? $cs_theme_options['cs_heading_h6_color']: '';
		$cs_text_color = $cs_theme_options['cs_text_color'];
 		
		
		$cs_widget_heading_size = (isset($cs_theme_options['cs_widget_heading_size'])) ? $cs_theme_options['cs_widget_heading_size']: '';
  		if(
			( isset( $cs_theme_options['cs_custom_font_woff'] ) && $cs_theme_options['cs_custom_font_woff'] <> '' ) &&
			( isset( $cs_theme_options['cs_custom_font_ttf'] ) && $cs_theme_options['cs_custom_font_ttf'] <> '' ) &&
			( isset( $cs_theme_options['cs_custom_font_svg'] ) && $cs_theme_options['cs_custom_font_svg'] <> '' ) &&
			( isset( $cs_theme_options['cs_custom_font_eot'] ) && $cs_theme_options['cs_custom_font_eot'] <> '' )
		):
		
		$font_face_html = "
		@font-face {
			font-family: 'cs_custom_font';
			src: url('".$cs_theme_options['cs_custom_font_eot']."');
			src:
				url('".$cs_theme_options['cs_custom_font_eot']."?#iefix') format('eot'),
				url('".$cs_theme_options['cs_custom_font_woff']."') format('woff'),
				url('".$cs_theme_options['cs_custom_font_ttf']."') format('truetype'),
				url('".$cs_theme_options['cs_custom_font_svg']."#cs_custom_font') format('svg');
			font-weight: 400;
			font-style: normal;
		}";
		
        $custom_font = true; else: $custom_font = false; endif;
 	?>
		<style type="text/css">
			<?php 
				if($custom_font == true){
					echo balanceTags($font_face_html, true);
				}
				else{
					echo cs_get_font_family($cs_content_font, $cs_content_font_att);
					echo cs_get_font_family($cs_mainmenu_font, $cs_mainmenu_font_att);
					echo cs_get_font_family($cs_heading_font, $cs_heading_font_att);
					echo cs_get_font_family($cs_widget_heading_font, $cs_widget_heading_font_att);
				}
			?>
	body,.main-section p {
		<?php 
		if($custom_font == true){
			echo 'font-family: cs_custom_font;';
			echo 'font-size: '.$cs_content_size.';';
		}
		else{
			echo cs_font_font_print($cs_content_font_atts, $cs_content_size, $cs_content_font);
		}
		?>
 		color:<?php echo esc_attr($cs_text_color);?>;
	}
	.logo{
		margin:<?php echo esc_attr($cs_logo_margintb);?>px <?php echo esc_attr($cs_logo_marginlr);?>px !important;
   	}
	.nav li a {
		<?php 
		if($custom_font == true){
			echo 'font-family: cs_custom_font;';
			echo 'font-size: '.$cs_mainmenu_size.';';
		}
		else{
			echo cs_font_font_print($cs_mainmenu_font_atts, $cs_mainmenu_size, $cs_mainmenu_font, true);
		}
		?>
	}
 	h1{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_1_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_1_size, $cs_heading_font, true);
	}
	 
	?>}
	h2{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_2_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_2_size, $cs_heading_font, true);
	}
	
	?>}
	h3{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_3_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_3_size, $cs_heading_font, true);
	}
	
	?>}
	h4{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_4_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_4_size, $cs_heading_font, true);
	}
	
	?>}
	h5{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_5_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_5_size, $cs_heading_font, true);
	}
	
	?>}
	h6{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_heading_6_size.';';
	}
	else{
		echo cs_font_font_print($cs_heading_font_atts, $cs_heading_6_size, $cs_heading_font, true);
	}
	
	?>}
	
	.main-section h1, .main-section h1 a {color: <?php echo esc_attr($cs_heading_h1_color);?> !important;}
	.main-section h2, .main-section h2 a{color: <?php echo esc_attr($cs_heading_h2_color);?> !important;}
	.main-section h3, .main-section h3 a{color: <?php echo esc_attr($cs_heading_h3_color);?> !important;}
	.main-section h4, .main-section h4 a{color: <?php echo esc_attr($cs_heading_h4_color);?> !important;}
	.main-section h5, .main-section h5 a{color: <?php echo esc_attr($cs_heading_h5_color);?> !important;}
	.main-section h6, .main-section h6 a{color: <?php echo esc_attr($cs_heading_h6_color);?> !important;}
	.widget .widget-section-title h2{
		<?php
		if($custom_font == true){
			echo 'font-family: cs_custom_font;';
			echo 'font-size: '.$cs_widget_heading_size.';';
		}
		else{
			echo cs_font_font_print($cs_widget_heading_font_atts, $cs_widget_heading_size, $cs_widget_heading_font, true);
		}
		?>
	}
	.top-strip {background-color:<?php echo esc_attr($cs_topstrip_bgcolor);?>;}
	.top-strip p{color:<?php echo esc_attr($cs_topstrip_text_color);?> !important;}
	.top-strip a,.top-strip i{color:<?php echo esc_attr($cs_topstrip_link_color);?> !important;}
 	.middle-sec{background:<?php echo esc_attr($cs_header_bgcolor);?> !important;}
	.main-head {background:<?php echo esc_attr($cs_nav_bgcolor);?> !important;}
	.navigation .nav > li > a, .cs-login-sec ul li a i,li.parentIcon a:after,.cs-user,.cs-user-login {color:<?php echo esc_attr($cs_menu_color);?> !important;}
	.navbar-nav > li > .dropdown-menu,.navbar-nav > li > .dropdown-menu > li > .dropdown-menu,.mega-grid{ background-color:<?php echo esc_attr($cs_submenu_bgcolor);?> !important;}
	.navbar-nav .sub-menu .dropdown-menu li a{color:<?php echo esc_attr($cs_submenu_color);?> !important;}
	.navbar-nav .sub-menu .dropdown-menu > li:hover > a,ul ul li.current-menu-ancestor.parentIcon > a:after,ul ul li.parentIcon:hover > a:after {border-bottom-color:<?php echo esc_attr($cs_submenu_hover_color);?>;color:<?php echo esc_attr($cs_submenu_hover_color);?> !important;}
	.navigation .navbar-nav > li.current-menu-item > a,.navigation .navbar-nav > li.current-menu-ancestor > a,.navigation .navbar-nav > li:hover > a,li.current-menu-ancestor.parentIcon > a:after,li.parentIcon:hover > a:after {color:<?php echo esc_attr($cs_menu_active_color);?> !important;}
	.navigation .navbar-nav > .active > a:before, .navigation .navbar-nav > li > a:before{ border-bottom-color:<?php echo esc_attr($cs_menu_active_color);?> !important; }
	.cs-user,.cs-user-login { border-color:<?php echo esc_attr($cs_menu_active_color);?> !important; }
	{
		box-shadow: 0 4px 0 <?php echo esc_attr($cs_topstrip_bgcolor); ?> inset !important;
	}
	.header_2 .nav > li:hover > a,.header_2 .nav > li.current-menu-ancestor > a {
       
	}
	</style>
<?php
	}
}



/** 
 * @Set Footer colors
 */
if ( ! function_exists( 'cs_footer_color' ) ) {
	function cs_footer_color(){
		global $cs_theme_options;
		$cs_footerbg_color = (isset($cs_theme_options['cs_footerbg_color']) and $cs_theme_options['cs_footerbg_color'] <> '') ? $cs_theme_options['cs_footerbg_color']: '';
		
		$cs_title_color = (isset($cs_theme_options['cs_title_color']) and $cs_theme_options['cs_title_color'] <> '') ? $cs_theme_options['cs_title_color']: '';
		
		$cs_footer_text_color = (isset($cs_theme_options['cs_footer_text_color']) and $cs_theme_options['cs_footer_text_color'] <> '') ? $cs_theme_options['cs_footer_text_color']: '';
		
		$cs_link_color = (isset($cs_theme_options['cs_link_color']) and $cs_theme_options['cs_link_color'] <> '') ? $cs_theme_options['cs_link_color']: '';
		
		$cs_sub_footerbg_color = (isset($cs_theme_options['cs_sub_footerbg_color']) and $cs_theme_options['cs_sub_footerbg_color'] <> '') ? $cs_theme_options['cs_sub_footerbg_color']: '';
		
		$cs_copyright_text_color = (isset($cs_theme_options['cs_copyright_text_color']) and $cs_theme_options['cs_copyright_text_color'] <> '') ? $cs_theme_options['cs_copyright_text_color']: '';
?>
<style type="text/css">
        #footer-sec,#footer-sec:before {
            background-color:<?php echo esc_attr($cs_sub_footerbg_color); ?> !important;
        }
        #bottom-sec {
            background-color:<?php echo esc_attr($cs_footerbg_color); ?> !important;
        }
        #copyright p, .footer-nav ul li a {
            color:<?php echo esc_attr($cs_copyright_text_color); ?> !important;
        }
 
        #footer-sec .widget .cs-section-title h2,#footer-sec h2,#footer-sec h3,#footer-sec h4,#footer-sec h6, #footer-sec h5 a,.widget_reviews .left-sp span a {
            color:<?php echo esc_attr($cs_title_color); ?> !important;
        }
        #footer-sec .widget ul li, #footer-sec .widget ul li a, #footer-sec .widget p, #footer-sec .tagcloud a, #footer-sec .widget_calendar tr td,#footer-sec,#footer-sec p,#footer-sec h5,#footer-sec .widget h5 {
            color:<?php echo esc_attr($cs_footer_text_color); ?> !important;
        }
    </style>
<?php 
}
}