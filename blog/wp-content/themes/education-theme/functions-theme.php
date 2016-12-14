<?php
// Flexslider function
if ( ! function_exists( 'cs_flex_slider' ) ) {
	function cs_flex_slider($width,$height,$slider_id){
		global $cs_node,$cs_theme_options,$cs_counter_node;
		$cs_counter_node++;
		if($slider_id == ''){
	$slider_id = $cs_node->slider;
		}
		if($cs_theme_options['flex_auto_play'] == 'on'){$auto_play = 'true';}
			else if($cs_theme_options['flex_auto_play'] == ''){$auto_play = 'false';}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
		?>
		<!-- Flex Slider -->
		<div id="flexslider<?php echo esc_attr($cs_counter_node); ?>">
		  <div class="<flexsl></flexsl>ider" style="display: none;">
			  <ul class="slides">
				<?php 
					$cs_counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						?>
                        <li>
                            <figure>
                                <img src="<?php echo esc_url($image_url) ?>" alt="">   
                                <?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								?>         
                                <figcaption>
                                	<div class="container">
                                    <?php 
										if($as_node->title <> ''){
											echo '<h2 class="colr">';
											if($as_node->link <> ''){ 
												 echo '<a href="'.esc_url($as_node->link).'" target="'.$as_node->link_target.'">' . esc_html($as_node->title) . '</a>';
											} else {
												echo esc_attr($as_node->title);
 											}
											echo '</h2>';
                                           	}
											if($as_node->description <> ''){
												echo '<p>';
                                                echo substr(esc_attr($as_node->description), 0, 220);
                                                if ( strlen(esc_attr($as_node->description)) > 220 ) echo "...";
												echo '</p>';
                                         }
										?>
									</div>
                                 </figcaption>
                               <?php }?>
                             </figure>
                         </li>
 					<?php 
 					$cs_counter++;
 					}
 				?>
 		 	  </ul>
 		  </div>
 		</div>
 		<?php cs_enqueue_flexslider_script(); ?>
		<!-- Slider height and width -->
		<!-- Flex Slider Javascript Files -->
		<script type="text/javascript">
			cs_flex_slider(<?php echo esc_js($cs_theme_options['flex_animation_speed']); ?>, <?php echo esc_js($cs_theme_options['flex_pause_time']); ?>, <?php echo esc_js($cs_counter_node); ?>, <?php echo esc_js($cs_theme_options['flex_effect']); ?>, <?php echo esc_js($auto_play); ?>);
		</script>
	<?php
	}
}
 
 
// Content pages Meta Class

if ( ! function_exists( 'cs_default_pages_meta_content_class' ) ) { 

	function cs_default_pages_meta_content_class($layout){
		if ( $layout == '' or $layout == 'none' ) {
			echo "col-md-12";
		}
		else if ( $layout <> '' and $layout == 'right' ) {
			echo "content-left col-md-9";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "content-right col-md-9";
		}
		else if ( $layout <> '' and $layout == 'both' ) {
			echo "content-right col-md-6";
		}
	}	
}
// custom pagination start

if ( ! function_exists( 'cs_pagination' ) ) {
	function cs_pagination($total_records, $per_page, $qrystr = '',$show_pagination='Show Pagination') {
	if($show_pagination<> 'Show Pagination'){
		return;
	} else if($total_records < $per_page){
		return;
	}  else {	
		$html = '';
		$dot_pre = '';
		$dot_more = '';
		$total_page = ceil($total_records / $per_page);
		$page_id_all	= 0;
		if(isset($_GET['page_id_all']) && $_GET['page_id_all'] !=''){
			$page_id_all	= $_GET['page_id_all'];
		}													
		$loop_start = $page_id_all - 2;
		$loop_end = $page_id_all + 2;
		if ($page_id_all < 3) {
			$loop_start = 1;
			if ($total_page < 5)
				$loop_end = $total_page;
			else
				$loop_end = 5;
		}
		else if ($page_id_all >= $total_page - 1) {
			if ($total_page < 5)
				$loop_start = 1;
			else
				$loop_start = $total_page - 4;
			$loop_end = $total_page;
		}
		$html .= "<nav class='pagination'><ul>";
		if ($page_id_all > 1)

			$html .= "<li class='pgprev'><a href='?page_id_all=" . ($page_id_all - 1) . "$qrystr' >".__('<i class="fa fa-chevron-left"></i>', 'LMS')."</a></li>";

		if ($page_id_all > 3 and $total_page > 5)

			$html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";

		if ($page_id_all > 4 and $total_page > 6)

			$html .= "<li> <a>. . .</a> </li>";

		if ($total_page > 1) {

			for ($i = $loop_start; $i <= $loop_end; $i++) {

				if ($i <> $page_id_all)

					$html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";

				else

					$html .= "<li><a class='active'>" . $i . "</a></li>";

			}

		}

		if ($loop_end <> $total_page and $loop_end <> $total_page - 1)

			$html .= "<li> <a>. . .</a> </li>";

		if ($loop_end <> $total_page)

			$html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";

		if ($page_id_all < $total_records / $per_page)

			$html .= "<li class='pgnext'><a class='icon' href='?page_id_all=" . ($page_id_all + 1) . "$qrystr' >".__('<i class="fa fa-chevron-right"></i>', 'LMS')."</a></li>";
		$html .= "</ul></nav>";
		return $html;
	}

	}

}

// pagination end

// Social Share Function

if ( ! function_exists( 'cs_social_share' ) ) {

	function cs_social_share($default_icon='false',$title='true',$post_social_sharing_text = '') {

		global $cs_theme_options;
		$html = '';
 		$twitter = isset($cs_theme_options['cs_twitter_share']) ? $cs_theme_options['cs_twitter_share'] : '';
		$facebook = isset($cs_theme_options['cs_facebook_share']) ? $cs_theme_options['cs_facebook_share'] : '';
		$google_plus = isset($cs_theme_options['cs_google_plus_share']) ? $cs_theme_options['cs_google_plus_share'] : '';
		$pinterest = isset($cs_theme_options['cs_pintrest_share']) ? $cs_theme_options['cs_pintrest_share'] : '';
		$tumblr = isset($cs_theme_options['cs_tumblr_share']) ? $cs_theme_options['cs_tumblr_share'] : '';
		$dribbble = isset($cs_theme_options['cs_dribbble_share']) ? $cs_theme_options['cs_dribbble_share'] : '';
		$instagram = isset($cs_theme_options['cs_instagram_share']) ? $cs_theme_options['cs_instagram_share'] : '';
		$share = isset($cs_theme_options['cs_share_share']) ? $cs_theme_options['cs_share_share'] : '';
		$stumbleupon = isset($cs_theme_options['cs_stumbleupon_share']) ? $cs_theme_options['cs_stumbleupon_share'] : '';
		$youtube = isset($cs_theme_options['cs_youtube_share']) ? $cs_theme_options['cs_youtube_share'] : '';

		 cs_addthis_script_init_method();

		$html = '';

 
		$path = get_template_directory_uri() . "/include/assets/images/";
 		
		if($twitter=='on' or $facebook=='on' or $google_plus=='on' or $pinterest=='on' or $tumblr=='on' or $dribbble=='on' or $instagram=='on' or $share=='on' or $stumbleupon=='on' or $youtube=='on'){
			  
			  $html ='<div class="followus float-left">';
			  $html .='<span>'.$post_social_sharing_text.'</span>';
			  if($default_icon <> '1'){
					  
					if (isset($facebook) && $facebook == 'on') {
						$html .='<a class="addthis_button_facebook fa fa-facebook fa-1x"></a>';
					}
		
					if (isset($twitter) && $twitter == 'on') {
						$html .='<a class="addthis_button_twitter fa fa-twitter fa-1x"></a>';
					}
		
					if (isset($google_plus) && $google_plus == 'on') { 
						$html .='<a class="addthis_button_google fa fa-google-plus fa-1x"></a>';
					}
		
					if (isset($pinterest ) && $pinterest  == 'on') {
						$html .='<a class="addthis_button_pinterest fa fa-pinterest fa-1x"></a>';
					}
		
					if (isset($tumblr) && $tumblr == 'on') { 
						$html .='<a class="addthis_button_tumblr fa fa-tumblr fa-1x"></a>';
					}
		
					if (isset($dribbble) && $dribbble == 'on') {
						$html .='<a class="addthis_button_dribbble fa fa-dribbble fa-1x"></a>';
					}
		
					if (isset($instagram) && $instagram == 'on') {
						$html .='<a class="addthis_button_instagram fa fa-instagram fa-1x"></a>';
					}
					
					if (isset($stumbleupon) && $stumbleupon == 'on') {
						$html .='<a class="addthis_button_stumbleupon fa fa-stumbleupon fa-1x"></a>';
					}
					
					if (isset($youtube) && $youtube == 'on') {
						$html .='<a class="addthis_button_youtube fa fa-youtube fa-1x"></a>';
					}
			  }
				  if (isset($share) && $share == 'on') {
					  $html .='<a class="cs-btnsharenow btnshare addthis_button_compact"><i class="fa fa-share-alt"></i></a>';
				  }
	  
				  $html .='</div>';
		}
			
			echo force_balance_tags($html);

	}

}
// Social network

if ( ! function_exists( 'cs_social_network' ) ) {

	function cs_social_network($icon_type='',$tooltip = ''){

		global $cs_theme_options;
		$tooltip_data='';

		if($icon_type=='large'){

			$icon = 'fa fa-2x';

		} else {

			$icon = '';

		}

			if(isset($tooltip) && $tooltip <> ''){

				$tooltip_data='data-placement-tooltip="tooltip"';

			}

		if ( isset($cs_theme_options['social_net_url']) and count($cs_theme_options['social_net_url']) > 0 ) {

						$i = 0;

						foreach ( $cs_theme_options['social_net_url'] as $val ){
							?>
						<?php if($val != ''){?>
          
        		            <a style="color:<?php echo esc_attr($cs_theme_options['social_font_awesome_color'][$i]); ?>;" title="" href="<?php echo esc_url($val);?>" data-original-title="<?php echo esc_attr($cs_theme_options['social_net_tooltip'][$i]);?>" data-placement="top" <?php echo esc_attr($tooltip_data);?> class="colrhover"  target="_blank"><?php if($cs_theme_options['social_net_awesome'][$i] <> '' && isset($cs_theme_options['social_net_awesome'][$i])){?> 
								 
                                 <i class="fa <?php echo esc_attr($cs_theme_options['social_net_awesome'][$i]);?> <?php echo esc_attr($icon);?>"></i>
						<?php } else {?><img src="<?php echo esc_url($cs_theme_options['social_net_icon_path'][$i]);?>" alt="<?php echo esc_attr($cs_theme_options['social_net_tooltip'][$i]);?>" /><?php }?></a><?php }
						$i++;}
		}
	}
}

// social network links
if ( ! function_exists( 'cs_social_network_widget' ) ) {

	function cs_social_network_widget($icon_type='',$tooltip = ''){

		global $cs_theme_options;
 
		$tooltip_data='';

		if($icon_type=='large'){

			$icon = 'fa fa-2x';

		} else {

			$icon = '';

		}

			if(isset($tooltip) && $tooltip <> ''){

				$tooltip_data='data-placement-tooltip="tooltip"';

			}

		if ( isset($cs_theme_options['social_net_url']) and count($cs_theme_options['social_net_url']) > 0 ) {

						$i = 0;

						foreach ( $cs_theme_options['social_net_url'] as $val ){

							?>

					<?php if($val != ''){?><a class="cs-colrhvr" title="" href="<?php echo esc_url($val);?>" data-original-title="<?php echo esc_attr($cs_theme_options['social_net_tooltip'][$i]);?>" data-placement="top" <?php echo esc_attr($tooltip_data);?> target="_blank"><?php if($cs_theme_options['social_net_awesome'][$i] <> '' && isset($cs_theme_options['social_net_awesome'][$i])){?> 
                        <i class="fa <?php echo esc_attr($cs_theme_options['social_net_awesome'][$i]);?>"></i>
					<?php } else {?><img src="<?php echo esc_url($cs_theme_options['social_net_icon_path'][$i]);?>" alt="<?php echo esc_attr($cs_theme_options['social_net_tooltip'][$i]);?>" /><?php }?>
                     </a>
					 <?php }
						$i++;
						}

		}
	}

}

// Post image attachment function
if ( ! function_exists( 'cs_attachment_image_src' ) ) :
function cs_attachment_image_src($attachment_id, $width, $height) {

    $image_url = wp_get_attachment_image_src( (int)$attachment_id, array($width, $height), true);

     if ($image_url[1] == $width and $image_url[2] == $height)

        ;

    else

        $image_url = wp_get_attachment_image_src( (int)$attachment_id, "full", true);

    	$parts = explode('/uploads/',$image_url[0]);

		if ( count($parts) > 1 ) return $image_url[0];

}
endif;

// Post image attachment source function
if ( ! function_exists( 'cs_get_post_img_src' ) ) {
	function cs_get_post_img_src($post_id, $width, $height) {
		if(has_post_thumbnail()){
			$image_id = get_post_thumbnail_id($post_id);
			$image_url = wp_get_attachment_image_src( (int)$image_id, array($width, $height), true);
			if ($image_url[1] == $width and $image_url[2] == $height) {
				return $image_url[0];
			} else {
				$image_url = wp_get_attachment_image_src( (int)$image_id, "full", true);
				return $image_url[0];
			}
		}
	}
}

// Get Post image attachment
if ( ! function_exists( 'cs_get_post_img' ) ) :
function cs_get_post_img($post_id, $width, $height) {

    $image_id = get_post_thumbnail_id($post_id);

    $image_url = wp_get_attachment_image_src( (int)$image_id, array($width, $height), true);

    if ($image_url[1] == $width and $image_url[2] == $height) {

        return get_the_post_thumbnail( (int)$post_id, array($width, $height));

    } else {

        return get_the_post_thumbnail( (int)$post_id, "full");

    }
}
endif;

// Get Main background
if ( ! function_exists( 'cs_bg_image' ) ) :
function cs_bg_image(){

	global $cs_theme_options;
   	$cs_bg_image = '';
 	if ($cs_theme_options['cs_custom_bgimage'] == "" ) {
 		if (isset($cs_theme_options['cs_bg_image']) && $cs_theme_options['cs_bg_image'] <> '' and $cs_theme_options['cs_bg_image']<>'bg0' and $cs_theme_options['cs_bg_image']<>'pattern0'){
				$cs_bg_image = get_template_directory_uri()."/include/assets/images/background/".$cs_theme_options['cs_bg_image'].".png";
			}
		}elseif ($cs_theme_options['cs_custom_bgimage']<>'pattern0') { 
			$cs_bg_image = $cs_theme_options['cs_custom_bgimage'];
		}
  	if ( $cs_bg_image <> "" ) {
		return ' style="background:url('.$cs_bg_image.') ' .$cs_theme_options['cs_bgimage_position'].'"';
	}elseif(isset($cs_theme_options['cs_bg_color']) and $cs_theme_options['cs_bg_color'] <> ''){
		return ' style="background:'.$cs_theme_options['cs_bg_color'].'"';
	}
	
}
endif;

// Main wrapper class function
if ( ! function_exists( 'cs_wrapper_class' ) ) :
function cs_wrapper_class(){
	global $cs_theme_options;
	if ( isset($_POST['cs_layout']) ) {
		 $_SESSION['lmssess_layout_option'] = esc_attr($_POST['cs_layout']);
		 echo  esc_attr($_SESSION['lmssess_layout_option']);
	}
	elseif ( isset($_SESSION['lmssess_layout_option']) and !empty($_SESSION['lmssess_layout_option'])){
		echo esc_attr($_SESSION['lmssess_layout_option']);
	}
	else {
		echo esc_attr($cs_theme_options['cs_layout']);
		$_SESSION['lmssess_layout_option']='';
	}
}
endif;

// custom sidebar start
global $cs_theme_options;
$cs_theme_sidebar = $cs_theme_options;

if ( isset($cs_theme_sidebar['sidebar']) and !empty($cs_theme_sidebar['sidebar'])) {

	foreach ( $cs_theme_sidebar['sidebar'] as $sidebar ){
		
		$sidebar_id =strtolower(str_replace(' ','_',$sidebar));
		//foreach ( $parts as $val ) {

		register_sidebar(array(

			'name' => $sidebar,

			'id' => $sidebar_id,

			'description' => 'This widget will be displayed on right side of the page.',

			'before_widget' => '<div class="widget element-size-100 %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<div class="widget-section-title"><h2>',

			'after_title' => '</h2></div>'

		));

	}

}

// custom sidebar end


//primary widget
register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'LMS' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the right.','LMS'),
  		'before_widget' => '<article class="element-size-100 group widget %2$s">',
 		'after_widget' => '</article>',
 		'before_title' => '<div class="widget-section-title"><h2>',
 		'after_title' => '</h2></div>'
	) );

/** 
 * @footer widget Area
 */
register_sidebar( array(
	'name' => 'Footer Widget',
	'id' => 'footer-widget-1',
	'description' => 'This Widget Show the Content in Footer Area.',
	'before_widget' => '<aside class="col-md-3 group widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<div class="widget-section-title"><h2>',
	'after_title' => '</h2></div>'
) );
if (!function_exists('cs_comment')) :

     /**

     * Template for comments and pingbacks.

    
     * To override this walker in a child theme without modifying the comments template

     * simply create your own cs_comment(), and that function will be used instead.

    
     * Used as a callback by wp_list_comments() for displaying the comments.

    
     */

	function cs_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	$args['reply_text'] = '<i class="fa fa-share-square"></i>';
 	switch ( $comment->comment_type ) :

		case '' :

	?>
		<li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" <?php //comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div class="thumblist" id="comment-<?php comment_ID(); ?>">
                <ul>
                    <li>
                        <figure>
                            <a><?php echo get_avatar( $comment, 66 ); ?></a>
                        </figure>
                        <div class="text-box">
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <p><div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'LMS' ); ?></div></p>
                            <?php endif; ?>
                            <strong class="auther"><a href="<?php get_comment_author_url(); ?>"><?php comment_author(  ); ?></a></strong>
                            <?php printf( __( '<time datetime="2014-11-14">%1$s</time>', 'LMS' ), get_comment_date().' - '.get_comment_time()); ?>
                             <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth) ) ); ?>
                            <div class="cs_comments_entry">
                            <?php comment_text(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
         	
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
	<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'LMS' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
 	endif;

 /* Under Construction Page */

if ( ! function_exists( 'cs_under_construction' ) ) {

	function cs_under_construction(){ 

		global $cs_theme_options, $post,$cs_uc_options;
		$cs_uc_options = $cs_theme_options;
   		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }
		if ( ($cs_uc_options['cs_maintenance_page_switch'] == "on" and !(is_user_logged_in())) or $post_name == "pf-under-construction") { 
		?>
		<script>
			jQuery(function($){
				$('#underconstrucion').css({'height':(($(window).height())-0)+'px'});
			
				$(window).resize(function(){
				$('#underconstrucion').css({'height':(($(window).height())-0)+'px'});
				});
			});
        </script>
        <section id="underconstrucion">
        <!-- ROW -->
        <div class="row">
            <!-- Col -->
            <div class="col-md-12">
                <div class="cons-icon-area">
                    <span class="icon-wrapp">
                        <?php if(isset($cs_uc_options['cs_maintenance_logo_switch']) and $cs_uc_options['cs_maintenance_logo_switch'] == "on"){ cs_logo(); } else { echo '<i class="fa fa-gears"></i>';}?>
                    </span>
                </div>
                <!-- Cons Text -->
                <div class="cons-text-wrapp">
                    <h1><?php _e('Sorry, We are down for maintenance','LMS'); ?></h1>
                    <p>
					<?php if ($cs_uc_options['cs_maintenance_text']) {
						  		echo force_balance_tags(stripslashes(htmlspecialchars_decode($cs_uc_options['cs_maintenance_text'])));
						   } else {
								_e('Sorry, We are down for maintenance','LMS');				
							}
					?>
                    </p>
                </div>
                <!-- Cons Text ENd -->
                <!-- Countdown -->
                <?php 
				 $launch_date = trim($cs_uc_options['cs_launch_date']);
				 $launch_date = str_replace('/', '-', $launch_date);
 				 $year = date("Y", strtotime($launch_date));
				 $month = date_i18n("m", strtotime($launch_date));
				 $month_event_c = date_i18n("M", strtotime($launch_date));							
				 $day = date_i18n("d", strtotime($launch_date));
				 $time_left = date_i18n("H,i,s", strtotime($launch_date));
			   ?>

			   <script type="text/javascript" src="<?php echo esc_js(get_template_directory_uri()); ?>/assets/scripts/jquery_countdown.js"></script>
               <script>
			   function cs_mailchimp_submit(theme_url,counter,admin_url){
						'use strict';
						$ = jQuery;
						$('#btn_newsletter_'+counter).hide();
						$('#process_'+counter).html('<div id="process_newsletter_'+counter+'"><i class="fa fa-refresh fa-spin"></i></div>');
						$.ajax({
							type:'POST', 
							url: admin_url,
							data:$('#mcform_'+counter).serialize()+'&action=cs_mailchimp', 
							success: function(response) {
								$('#mcform_'+counter).get(0).reset();
								$('#newsletter_mess_'+counter).fadeIn(600);
								$('#newsletter_mess_'+counter).html(response);
								$('#btn_newsletter_'+counter).fadeIn(600);
								$('#process_'+counter).html('');
							}
						});
					}
					jQuery(function () {
						var austDay = new Date();
						//austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
						austDay = new Date(<?php echo esc_js($year); ?>,<?php echo esc_js($month); ?>-1,<?php echo esc_js($day); ?>);
						
						jQuery('#countdown_underconstruction').countdown({
							until: austDay,
							 format: 'wdhms',
							layout: '<div class="main-digit-wrapp"><span class="digit-wrapp"><span class="cs-digit">{w10}</span><span class="cs-digit">{w1}</span></span><span class="countdown-period">Weeks</span></div>' +
							'<div class="main-digit-wrapp"><span class="digit-wrapp"><span class="cs-digit">{d10}</span><span class="cs-digit">{d1}</span></span><span class="countdown-period">days</span></div>' +
							'<div class="main-digit-wrapp"><span class="digit-wrapp"><span class="cs-digit">{h10}</span><span class="cs-digit">{h1}</span></span><span class="countdown-period">hours</span></div>' +
							'<div class="main-digit-wrapp"><span class="digit-wrapp"><span class="cs-digit">{m10}</span><span class="cs-digit">{m1}</span></span><span class="countdown-period">minutes</span></div>' +
							'<div class="main-digit-wrapp"><span class="digit-wrapp"><span class="cs-digit">{s10}</span><span class="cs-digit">{s1}</span></span><span class="countdown-period">seconds</span></div>' 
						});
					});
				</script>
               <div id="countdownwrapp">
                    <div id="countdown_underconstruction"></div>
               </div>
               <!-- Countdown End -->
               <div class="user-signup">
                   <?php echo cs_custom_mailchimp();?>
               </div>
               <?php if($cs_uc_options['cs_maintenance_social_network'] == "on"){?>
                   <!-- Footer Widgets Start -->
                       <footer>
                        <p class="social-media">
                            <!-- Social Network Start -->
                            <?php echo cs_social_network(); ?> 
                            <!-- Social Network End -->
                       </p>
                       </footer>
                <?php }?>
            </div>
            <!-- Col End -->
        </div>
        <!-- ROW END-->
        <!-- Footer Start -->
    </section>
<?php die();
	 }
	}
}


//404 page markeup
if ( ! function_exists( 'cs_page_404' ) ) {

	function cs_page_404(){
		global $cs_theme_options, $post; 
		$cs_seo_description = $cs_theme_options['cs_meta_description'];
		$cs_seo_keywords = $cs_theme_options['cs_meta_keywords'];
		?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta name="keywords" content="<?php echo esc_html($cs_seo_keywords) ?>">
        <meta name="description" content="<?php echo esc_html($cs_seo_description) ?>">
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/style.css');?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/font-awesome.css') ?>" />
        <?php
        if (is_rtl()) {
        ?>
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/rtl.css') ?>" />
        <?php
		}
        if 	(isset($cs_theme_options['cs_responsive']) && $cs_theme_options['cs_responsive'] == "on") {
        ?>
        <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/assets/css/responsive.css') ?>" />
        <?php
        }
        ?>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>">
        </head>
        <body>
                <div class="page-not-found">
                    <!-- Header -->
                    <header>
                        <h2><?php _e('ERROR 404','LMS') ?></h2>
                    </header>
                    <!-- Header End -->
                    <div class="cs-content404">
                        <aside class="cs-icon">
                            <i class="fa fa-warning"></i>
                        </aside>
                        <div class="desc">
                            <h3><?php _e('It seems we can not find what you are looking for.','LMS') ?></h3>
                        </div>
                        <a class="go-home" href="<?php echo esc_url(site_url('/'));?>"><?php _e('Go Back To Home','LMS') ?></a>
                    </div>
                    <?php get_search_form(); ?>
                </div>
        </body>
        </html>
	<?php }
}
// breadcrumb function
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		global $wp_query, $cs_theme_options,$post;
		/* === OPTIONS === */
		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = '%s'; // text for a search results page
		$text['tag']      = '%s'; // text for a tag page
		$text['author']   = '%s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page
	
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="active">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb
		/* === END OF OPTIONS === */
		$current_page = __('Current Page','LMS');
		$homeLink = home_url() . '/';
		$linkBefore = '<li>';
		$linkAfter = '</li>';
		$linkAttr = '';
		$link = $linkBefore . '<a' . esc_url($linkAttr) . ' href="%1$s">%2$s</a>' . $linkAfter;
		$linkhome = $linkBefore . '<a' . esc_url($linkAttr) . ' href="%1$s">%2$s</a>' . $linkAfter;
	
		if(is_home() || is_front_page()) {
	
			if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . esc_url($homeLink) . '">' . $text['home'] . '</a>'.$after.'</ul></div>';
	
		}else {
			echo '<div class="breadcrumbs"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo balanceTags($cats);
				}
				echo balanceTags($before);
				echo sprintf($text['category'], single_cat_title('', false));
				echo balanceTags($after);
			} elseif ( is_search() ) {
				echo balanceTags($before . sprintf($text['search'], get_search_query()) . $after);
			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo balanceTags($before . get_the_time('d') . $after);
			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo balanceTags($before) . get_the_time('F') . balanceTags($after);
			} elseif ( is_year() ) {
				echo balanceTags($before) . get_the_time('Y') . balanceTags($after);
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					if ( get_post_type() == 'cs-curriculums' && isset($_REQUEST['course_id']) && $_REQUEST['course_id'] !='' ) {
						if (trim((int)$_REQUEST['course_id']) == '' ){
							$slug 		= 'courses';
							$post_type  = 'courses';
						} elseif(isset($_REQUEST['course_id'])) {
							$slug =  get_post_type( (int)$_REQUEST['course_id'] );
							$post_type = get_post_type_object(get_post_type( (int)$_REQUEST['course_id'] ));
						}
						
						printf($link, $homeLink . '' . $slug . '/', $post_type->labels->singular_name);
					
					}else{
							printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					}
 					if ($showCurrent == 1) echo balanceTags($delimiter . $before . $current_page . $after);
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo balanceTags($cats);
					
 					if ($showCurrent == 1) echo balanceTags($before . $current_page . $after);
				}
			} elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && !is_404() ) {
					$post_type = get_post_type_object(get_post_type());
					echo balanceTags($before);
					echo balanceTags($post_type->labels->singular_name);
					echo balanceTags($after);
			} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
				$taxonomy = $taxonomy_category = '';
				$taxonomy = $wp_query->query_vars['taxonomy'];
				echo balanceTags($before . $wp_query->query_vars[$taxonomy] . $after);

			}elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo balanceTags($before. get_the_title() . $after);
	
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo balanceTags($breadcrumbs[$i]);
					if ($i != count($breadcrumbs)-1) echo balanceTags($delimiter);
				}
				if ($showCurrent == 1) echo balanceTags($delimiter . $before . get_the_title() . $after);
	
			} elseif ( is_tag() ) {
				echo balanceTags($before);
				sprintf($text['tag'], single_tag_title('', true));
				echo balanceTags($after);
	
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo balanceTags($before);
				echo sprintf($text['author'], $userdata->display_name);
				echo balanceTags($after);
	
			} elseif ( is_404() ) {
				echo balanceTags($before);
				echo balanceTags($text['404']); 
				echo balanceTags($after);
				
			}
			
			//echo "<pre>"; print_r($wp_query->query_vars); echo "</pre>";
			if ( get_query_var('paged') ) {
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				// echo __('Page') . ' ' . get_query_var('paged');
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}
			echo '</ul></div>';
	
		}
	}
}
/** 
 * @Footer Logo 
 */

if ( ! function_exists( 'cs_footer_logo' ) ) {
	function cs_footer_logo(){
		global $cs_theme_options;
		$logo = isset($cs_theme_options['cs_footer_logo']) ? $cs_theme_options['cs_footer_logo'] : '';
		if($logo<>''){
		?>
		<img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">
		<?php
		}
	}
}
if ( ! function_exists( 'cs_page_metakey' ) ) {
	function cs_page_metakey(){
		global $cs_theme_options;
		$cs_builtin_seo_fields =$cs_theme_options['cs_builtin_seo_fields'];
		$cs_seo_title  ='';
 		if(isset($cs_builtin_seo_fields) && $cs_builtin_seo_fields == 'on'){
			$post_type = get_post_type(get_the_ID());
			if(is_page()){
				$meta_element = 'cs_page_builder';
			} else {
				$meta_element = 'post';
			}
			$post_meta = get_post_meta(get_the_ID(), "$meta_element", true);
			if ( $post_meta <> "" ) {
				$cs_seo_xmlObject = new SimpleXMLElement($post_meta);
			}
			$cs_seo_title = isset($cs_seo_xmlObject->seosettings->cs_seo_title) ? $cs_seo_xmlObject->seosettings->cs_seo_title : '';
			$cs_seo_description = isset($cs_seo_xmlObject->seosettings->cs_seo_description) ? $cs_seo_xmlObject->seosettings->cs_seo_description : $cs_theme_options['cs_meta_description'];
			$cs_seo_keywords = isset($cs_seo_xmlObject->seosettings->cs_seo_keywords) ? $cs_seo_xmlObject->seosettings->cs_seo_keywords : $cs_theme_options['cs_meta_keywords'];
			if ( empty($cs_seo_xmlObject->slider_position) ) $cs_slider_position = ""; else $cs_slider_position = htmlspecialchars($cs_seo_xmlObject->slider_position);
			if ( empty($cs_seo_xmlObject->header_banner_style) ) $cs_header_style = ""; else $cs_header_style = $cs_seo_xmlObject->header_banner_style;
			?>
            <meta name="title" content="<?php echo esc_attr( $cs_seo_title )?>">
            <meta name="keywords" content="<?php echo esc_attr( $cs_seo_keywords )?>">
          	<meta name="description" content="<?php echo esc_attr( $cs_seo_description )?>">
				  <?php
		}
	}
}

function cs_video_type($video = ''){
	$file_type = wp_check_filetype($video);
	 if(isset($file_type['type']) && $file_type['type'] <> ''){
	  	$file_type = $file_type['type'];
	 } else {
	  	$file_type = 'video/mp4';
	 }
	 return $file_type;
}