<?php
//=====================================================================
// Adding column start
//=====================================================================
if (!function_exists('cs_column_shortocde')) {
	function cs_column_shortocde($atts, $content = "") {
		$defaults = array('column_size'=>'1/1','flex_column_section_title'=>'','cs_column_class'=>'','cs_column_animation'=>'','cs_column_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class = cs_custom_column_class($column_size);
		
		$section_title = '';
		if ( trim($cs_column_animation) !='' ) {
			$cs_column_animation	= 'wow'.' '.$cs_column_animation;
		} else {
			$cs_column_animation	= '';
		}
		
		if ( trim($cs_column_class) !='' ) {
			$cs_column_class_id = ' id="'.$cs_column_class.'"';
		}
		else{
			$cs_column_class_id = '';
		}
		
		if ($flex_column_section_title && trim($flex_column_section_title) !='') {
			$section_title	= '<div class="cs-section-title"><h2>'.$flex_column_section_title.'</h2></div>';
		}
	 
		$html = do_shortcode($content);
		return '<div class="'.$cs_column_animation.' '.$cs_column_class.' '.$column_class.'"'.$cs_column_class_id.'>'.$section_title.' '.$html.'</div>';
	}
	add_shortcode('cs_column', 'cs_column_shortocde');
}
// adding column end

//=====================================================================
// Adding Tooltip start
//=====================================================================
if (!function_exists('cs_tooltip_shortcode')) {
	function cs_tooltip_shortcode($atts, $content = "") {
		$defaults = array( 'tooltip_hover_title' => '','tooltip_data_placement' => 'top','cs_tooltip_class'=>'', 'cs_tooltip_animation'=>'', 'cs_tooltip_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$html = "<script>
			jQuery(document).ready(function($) {
				$('.tolbtn').tooltip('hide');
				$('.tolbtn').popover('hide')
			});
		</script>";
		if ( trim($cs_tooltip_animation) !='' ) {
			$cs_tooltip_animation	= 'wow'.' '.$cs_tooltip_animation;
		} else {
			$cs_tooltip_animation	= '';
		}
		$html .= '<a class="tolbtn '.$cs_tooltip_class.' '.$cs_tooltip_animation.'" id="'.$cs_tooltip_class.'" data-toggle="tooltip" data-placement="'.$tooltip_data_placement.'" title="'.$tooltip_hover_title.'" style=" animation-duration: '.$cs_tooltip_animation_duration.'s;">'.$content.'</a>';
		return $html;
	}

	add_shortcode('cs_tooltip', 'cs_tooltip_shortcode');
}
// adding Tooltip end

//=====================================================================
// Adding dropcap start
//=====================================================================
if (!function_exists('cs_dropcap_shortcode')) {
	function cs_dropcap_shortcode($atts, $content = "") {
		$defaults = array( 'column_size' => '1/1', 'cs_dropcap_section_title' => '', 'dropcap_style' => 'dropcap','dropcap_bg_color' => '#4D8B0C','dropcap_color' => '#fff','dropcap_size' => '', 'cs_dropcap_class'=>'', 'cs_dropcap_animation'=>'', 'cs_dropcap_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$randomID = rand(0, 999);
		$randomIDD = rand(0, 999);
		$column_class 			= cs_custom_column_class($column_size);
		$dropcap_style_class 	= '';
		$dropcap_css 	= '';

		$font_color				= $dropcap_color ? $dropcap_color : '#FFF';
		$font_size				= $dropcap_size ? $dropcap_size : '40';
		$bg_color				= $dropcap_bg_color ? $dropcap_bg_color : '#21CDEC';
		

		$html = '';
		$section_title = '';
		if ( trim($cs_dropcap_animation) !='' ) {
			$cs_dropcap_animation	= 'wow'.' '.$cs_dropcap_animation;
		} else {
			$cs_dropcap_animation	= '';
		}
		if ($cs_dropcap_section_title && trim($cs_dropcap_section_title) !='') {
			$section_title	= '<div class="cs-section-title"><h2 class="'.$cs_dropcap_animation.'">'.$cs_dropcap_section_title.'</h2></div>';
		}
		
		if(isset($dropcap_style) && $dropcap_style == 'three-d'){
			$text = '<span>'.substr(do_shortcode($content),0,1).'</span>';
		
       		echo '<style scoped="scoped">
					.dropcap-one.dropcap-'.$randomID.' span {
						background: none repeat scroll 0 0 '.$bg_color.' !important;
						color: '.$font_color.' !important;
						font-size: '.$font_size.'px !important;
					}
				 </style>';
			if($cs_dropcap_class <> '') { $id ="id=".$cs_dropcap_class."";}else{ $id = '';}			
			$html = ''.$dropcap_css.' <div class="'.$dropcap_style_class . ' '.$cs_dropcap_class.' '.$cs_dropcap_animation.'" '.$id.'><div class="dropcap-one dropcap-'.$randomID.'">'.$text.substr(do_shortcode($content),1).'</div></div>';
		
		} else {
				$bg_color	= $dropcap_bg_color ? $dropcap_bg_color : '';
				echo '<style scoped="scoped">
						.dropcap-two.dropcap-'.$randomID.':first-letter{
							background: none repeat scroll 0 0 '.$bg_color.' !important;
							color: '.$font_color.' !important;
							font-size: '.$font_size.'px !important;
						}
					 </style>';	
				$html = ''.$dropcap_css.' <div class="'.$dropcap_style_class . ' '.$cs_dropcap_class.' '.$cs_dropcap_animation.'" id="'.$cs_dropcap_class.$randomID.'" style=" animation-duration: '.$cs_dropcap_animation_duration.'s;"><div class="dropcap-two dropcap-'.$randomID.'">'.do_shortcode($content).'</div></div>';

		}
		return '<div class="'.$column_class.'" id="'.$cs_dropcap_class.$randomIDD.'">'.$section_title.$html.'</div>';
		
		
	}
	add_shortcode('cs_dropcap', 'cs_dropcap_shortcode');
}
// adding dropcap end

//=====================================================================
// Diveder Shortcode Start
//=====================================================================
if (!function_exists('cs_divider_shortcode')) {
	function cs_divider_shortcode($atts) {
		$defaults = array( 'column_size' => '1/1', 'divider_style' => 'divider1','divider_height' => '1','divider_backtotop' => '','divider_margin_top' => '','divider_margin_bottom' =>'','line' => 'Wide','color'=>'#000', 'cs_divider_class'=>'','cs_divider_animation'=>'','cs_divider_animation_duration' => '1');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$column_class = '';
		if ($divider_style != 'divider2' ){
			$column_class = cs_custom_column_class($column_size);
		}
		
		$html  = '';
		$backtotop = '';
		if ( trim($cs_divider_animation) !='' ) {
			$cs_divider_animation	= 'wow'.' '.$cs_divider_animation;
		} else {
			$cs_divider_animation	= '';
		}
		if ($divider_backtotop == 'yes' ){
			$backtotop = '<span class="backtotop"><a class="btn-back-top btnnext" href="#"></a></span>';
		}
		if ($divider_style == 'fullwidth-sepratore' ){
			$html .= '<div class="fullwidth-sepratore '.$cs_divider_class.' '.$cs_divider_animation.'" style="animation-duration: '.$cs_divider_animation_duration.'s; margin-top:'.$divider_margin_top.'px; margin-bottom:'.$divider_margin_bottom.'px; height: '.$divider_height.'px;"><span class="dividerstyle"></span>'.$backtotop.'</div>';
		} else {
		
			
			if ($divider_style == 'divider4' ){
				$html .= ' <i class="seprator-brdr"></i>';
			}
			if ($divider_style == 'divider3' ){
				$html .= '<img src="'. get_template_directory_uri().'/assets/images/diver-bg.png" alt="icon">';
			}
			
			$cs_divider_class_id = '';
			if($cs_divider_class <> ''){
				$cs_divider_class_id = ' id="'.$cs_divider_class.'"';
			}
			
			$html = '<div class="cs-seprator '.$column_class.' '.$cs_divider_class.' '.$cs_divider_animation.'"'.$cs_divider_class_id.' style="animation-duration: '.$cs_divider_animation_duration.'s; margin-top:'.$divider_margin_top.'px; margin-bottom:'.$divider_margin_bottom.'px;height: '.$divider_height.'px;">
						<span class="'.$divider_style.'" >
							'.$html.'
						</span>'.$backtotop.'
					 </div>';
		}
		return do_shortcode($html);
	}
	add_shortcode('cs_divider', 'cs_divider_shortcode');
}
// Diveder Shortcode end

//=====================================================================
// Quote Shortcode Shortcode Start
//=====================================================================
if (!function_exists('cs_quote_shortcode')) {
	function cs_quote_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'column_size' => '1/1',
			'quote_style' => 'default',
			'cs_quote_section_title' => '',
			'quote_cite'   => '',
			'quote_cite_url'   => '#',
			'quote_text_color'   => '',
			'quote_align'   => 'center',
			'cs_quote_class'   => '',
			'cs_quote_animation_duration'   => '1',
			'cs_quote_animation'   => ''
	    ), $atts));
		$author_name = '';
		$html		 = '';
		
		$column_class = cs_custom_column_class($column_size);
		
		if ( trim($cs_quote_animation) !='' ) {
			$cs_quote_animation	= 'wow'.' '.$cs_quote_animation;
		} else {
			$cs_quote_animation	= '';
		}
		
		if(isset($quote_cite) && $quote_cite <> ''){
			$author_name .= '<br><div class="cs-user-name"><span>';
			if(isset($quote_cite_url) && $quote_cite_url <> ''){
				$author_name .= '<a href="'.esc_url($quote_cite_url).'">';
			}
			$author_name .= '<i class="fa fa-user"></i>'.$quote_cite;
			if(isset($quote_cite_url) && $quote_cite_url <> ''){
				$author_name .= '</a>';
			}
			
			$author_name .= '</span></div>';
		}
		
		if(isset($quote_align)){
			if($quote_align == 'left') $quote_align = 'text-left-align';
			if($quote_align == 'right') $quote_align = 'text-right-align';
			if($quote_align == 'center') $quote_align = 'text-center-align';
		}
		
		$section_title = '';
		if ($cs_quote_section_title && trim($cs_quote_section_title) !='') {
			$section_title = '<div class="cs-section-title"><h2 class="'.$cs_quote_animation.'">'.$cs_quote_section_title.'</h2></div>';
		}
		
		$html	.= '<blockquote class="'.$cs_quote_class.' '.$quote_align.' '.$cs_quote_animation.'" id="'.$cs_quote_class.'" style="animation-duration: '.$cs_quote_animation_duration.'s; color:'.$quote_text_color.'"><q>' . do_shortcode($content) .'</q>'. $author_name .'</blockquote>';
		
		return '<div class="'.$column_class.'">'.$section_title.$html.'</div>';
	}
	add_shortcode('cs_quote', 'cs_quote_shortcode');
}
// Quote Shortcode Shortcode End

//=====================================================================
// Adding hightlight start
//=====================================================================
if (!function_exists('cs_hightlight_shortcode')) {
	function cs_hightlight_shortcode($atts, $content = "") {
		$defaults = array( 'highlight_bg_color' => '','highlight_color' => '','cs_highlight_class' => '','cs_highlight_animation'=>'','cs_highlight_animation_duration'   => '10');
		extract( shortcode_atts( $defaults, $atts ) );
		
		if ( trim($cs_highlight_animation) !='' ) {
			$cs_highlight_animation	= 'wow'.' '.$cs_highlight_animation;
		} else {
			$cs_highlight_animation	= '';
		}
		$cs_highlight_class_id = '';
		if($cs_highlight_class_id <> ''){
			$cs_highlight_class_id = ' id="'.$cs_highlight_class.'"';
		}
		
		$html = '<mark'.$cs_highlight_class_id.' style="background:'.$highlight_bg_color.'; color:'.$highlight_color.'; animation-duration: '.$cs_highlight_animation_duration.'s;" class="highlights '.$cs_highlight_class.' '.$cs_highlight_animation.'">'.$content.'</mark>';
		return do_shortcode($html);
	}
	add_shortcode('cs_highlight', 'cs_hightlight_shortcode');
}
// adding hightlight end

//=====================================================================
// Adding heading start
//=====================================================================
if (!function_exists('cs_heading_shortcode')) {
	function cs_heading_shortcode($atts, $content = "") {
		$defaults = array( 'column_size'=>'1/1','heading_title' => '','color_title'=>'','heading_color' => '#000', 'class'=>'cs-heading-shortcode', 'heading_style'=>'1','heading_style_type'=>'1', 'heading_size'=>'', 'font_weight'=>'', 'heading_font_style'=>'', 'heading_align'=>'center', 'heading_font' => '', 'heading_divider'=>'', 'heading_color' => '', 'heading_content_color' => '', 'heading_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class = cs_custom_column_class($column_size);
		$html = '';
		$css = '';
		
		if ( isset($heading_font) and $heading_font <> "" ) {
			$css .= '<style scoped="scoped">';
				$css .= "@import url(http://fonts.googleapis.com/css?family=".$heading_font.");";
			$css .= '</style>';
		}
		echo $css;
		$html .= '<div  class="'.$heading_animation.' '.$column_class.'" >';
			if($heading_title <> ''){
				if ( $heading_font ){
					$font_family	= 'font-family: '.$heading_font.', sans-serif !important;';
				} else {
					$font_family	= '';
				}
				if($color_title<>''){
					$color_title ='&nbsp;<span class="cs-color">'.$color_title.'</span>';
				}
				$html .= '<h'.$heading_style.' style="color:'.$heading_color.' !important; '.$font_family.' font-size: '.$heading_size.'px !important;; text-align: '.$heading_align.';">'.$heading_title.$color_title.'</h'.$heading_style.'>';
				
			}
			if($heading_divider == 'on'){
				$html	.= '<div class="cs-seprator" style="text-align: '.$heading_align.';"><span class="divider5"></span></div>';
			}
			if($content <> ''){
				$html	.= '<div class="heading-description" style="color:'.$heading_content_color.' !important; text-align: '.$heading_align.';">'.do_shortcode($content).'</div>';
		
			}
		$html .= '</div>';
		return do_shortcode($html);
	}
	add_shortcode('cs_heading', 'cs_heading_shortcode');
}
// adding heading end

//=====================================================================
// Adding list start
//=====================================================================
if (!function_exists('cs_list_shortcode')) {
	function cs_list_shortcode($atts, $content = "") {
		global $cs_border,$cs_list_type;
		$defaults = array('column_size'=>'','cs_list_section_title'=>'','cs_list_type'=>'','cs_list_icon'=>'','cs_border'=>'','cs_list_item'=>'','cs_list_class'=>'','cs_list_animation'=>'','cs_list_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$customID = '';
		if ( isset( $column_size ) && $column_size !='' ) {
			$column_class = cs_custom_column_class($column_size);
		} else {
			$column_class = '';
		}
		
		if ( isset( $cs_list_class ) && $cs_list_class !='' ) {
			$customID = 'id="'.$cs_list_class.'"';
		}
		
		$html	 = "";
		$cs_list_typeClass	= '';
		$section_title = '';
		if ($cs_list_section_title && trim($cs_list_section_title) !='' ) {
			$section_title	= '<div class="cs-section-title"><h2>'.$cs_list_section_title.'</h2></div>';
		}
		
		$cs_list_type	= $cs_list_type ? $cs_list_type : 'cs-bulletslist';
		
		if ($cs_list_type == 'none'){
			$cs_list_typeClass	= 'cs-unorderedlist';
		} else if ($cs_list_type == 'icon'){
			$cs_list_typeClass	= 'cs-unorderedlist';
		} else if ($cs_list_type == 'built'){
			$cs_list_typeClass	= 'cs-bulletslist';
		} else if ($cs_list_type == 'decimal'){
			$cs_list_typeClass	= 'cs-orderedlist';
		} else if ($cs_list_type == 'alphabatic'){
			$cs_list_typeClass	= 'cs-alphaedlist';
		}

		$html	.= '<div '.$customID.' class="'.$column_class.' '.$cs_list_animation.' '.$cs_list_class.'">';
		$html	.= $section_title;
		$html	.= '<div class="liststyle">';
		$html	.= '<ul class="' .$cs_list_typeClass. '">';
		$html	.= do_shortcode($content);
		$html	.= '</ul>';
		$html	.= '</div>';
		$html	.= '</div>';
		return $html;
	}
	add_shortcode('cs_list', 'cs_list_shortcode');
}

//=====================================================================
// Adding list item start
//=====================================================================
if (!function_exists('cs_list_item_shortcode')) {
	function cs_list_item_shortcode($atts, $content = "") {
		global $cs_border,$cs_list_type;
		$html='';
		$defaults = array('cs_list_icon'=>'','cs_list_item'=>'','cs_cusotm_class'=>'','cs_custom_animation'=>'','cs_custom_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		
		if ($cs_border == 'yes') {
			$border	= 'has_border';
		} else {
			$border	= '';
		}
		
		if ($cs_list_icon && $cs_list_type == 'icon' ) {
			$html	.= '<li class="'.$border.'"><i class="fa '.$cs_list_icon.'"></i>' .do_shortcode($content). '</li>'; 
		} else {
			$html	.= '<li class="'.$border.'">' .do_shortcode($content). '</li>';
		}
		return $html;
	}
	add_shortcode('list_item', 'cs_list_item_shortcode');
}
// adding list item end

//=====================================================================
// Adding Contact Us Form start
//=====================================================================
if (!function_exists('cs_contactus_shortcode')) {
	function cs_contactus_shortcode($atts, $content = "") {
		$defaults = array( 'column_size' => '1/1', 'cs_contactus_section_title' => '', 'cs_contactus_type' => '', 'cs_contactus_label' => '','cs_contactus_send' => '','cs_success' => '','cs_error' => '','cs_contact_class' => '','cs_contact_animation' => '','cs_contact_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class	= cs_custom_column_class($column_size);
		$cs_email_counter 	= cs_generate_random_string(3);
		$html 	 = '';
		$class	 = '';
		$userIcon		= '';
		$emailIcon		= '';
		$eubjectIcon	= '';
		$section_title = '';
		
		if ($cs_contactus_section_title && trim($cs_contactus_section_title) !='') {
			$section_title	= '<div class="cs-section-title"><h2 class="'.$cs_contact_animation.'">'.$cs_contactus_section_title.'</h2></div>';
		}
			 
		if ( $cs_contactus_type == 'classic' ) {
			$class	 = 'cs-classic';
		} else {
			 $class	 		= 'cs-plan';
			 $userIcon		= '<span class="input-icon"><i class=" fa fa-user"></i></span>';
			 $emailIcon		= '<span class="input-icon"><i class=" fa fa-envelope-o"></i></span>';
			 $eubjectIcon	= '<span class="input-icon"><i class=" fa fa-book"></i></span>';
		}
		
		if (trim($cs_success) && trim($cs_success) !='') {
			$success	= $cs_success;
		} else {
			$success	=__('Email has been sent Successfully','LMS');
		}
		
		if (trim($cs_error) && trim($cs_error) !='') {
			$error	= $cs_error;
		} else {
			$error	=__('An error Occured, please try again later','LMS');
		}

		?>
        <script type="text/javascript">
			function frm_submit<?php echo esc_js($cs_email_counter);?>(){
				
				var $ = jQuery;
				$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('<img src="<?php echo esc_js(esc_url(get_template_directory_uri()));?>/assets/images/ajax-loader.gif" alt="" />');
				$("#loading_div<?php echo esc_js($cs_email_counter);?>").show();
				$("#message<?php echo esc_js($cs_email_counter);?>").html('');
				var datastring =$('#frm<?php echo esc_js($cs_email_counter);?>').serialize() +"&cs_contact_email=<?php echo esc_js($cs_contactus_send);?>&cs_contact_succ_msg=<?php echo esc_js($success);?>&cs_contact_error_msg=<?php echo esc_js($error);?>&action=cs_contact_form_submit";

				$.ajax({
					type:'POST', 
					url: '<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>',
					data: datastring, 
					dataType: "json",
					success: function(response) {
						
						if (response.type == 'error'){
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('');
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").hide();
							$("#message<?php echo esc_js($cs_email_counter);?>").addClass('error_mess');
							$("#message<?php echo esc_js($cs_email_counter);?>").show();
							$("#message<?php echo esc_js($cs_email_counter)?>").html(response.message);
						} else if (response.type == 'success'){
							$("#frm<?php echo esc_js($cs_email_counter);?>").slideUp();
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('');
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").hide();
							$("#message<?php echo esc_js($cs_email_counter);?>").addClass('succ_mess');
							$("#message<?php echo esc_js($cs_email_counter)?>").show();
							$("#message<?php echo esc_js($cs_email_counter);?>").html(response.message);
						}
						
					}
				});
			}
    	 </script>
        <?php 
		
		if ( trim($cs_contact_animation) !='' ) {
			$cs_contact_animation	= 'wow'.' '.$cs_contact_animation;
		} else {
			$cs_contact_animation	= '';
		}
		
		
		$html	.= '<div class="'.$cs_contact_animation.' '.$cs_contact_class.' cs_form_styling">';
		$html	.= '<div class="form-style" id="contact_form'.$cs_email_counter.'">';
		$html	.= '<form id="frm'.$cs_email_counter.'" name="frm'.$cs_email_counter.'" method="post" action="javascript:frm_submit'.$cs_email_counter.'(\''.admin_url("admin-ajax.php").'\');" >';
		
		if ( isset( $cs_contactus_label ) && $cs_contactus_label == 'on' ) {
			$html	.= '<label>'.__('Enter Your Name','LMS').'</label>';
		}
		
		$html	.= '<p>'.$userIcon.'<input type="text" name="contact_name" onfocus="if(this.value == \'Full Name\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'Full Name\'; }" value="Full Name" class="'.$class.'" required /></p>';
		
		if ( isset( $cs_contactus_label ) && $cs_contactus_label == 'on' ) {
			$html	.= '<label>'.__('Enter Your Email Address','LMS').'</label>';
		}
		
		$html	.= '<p>'.$emailIcon.'<input type="email" name="contact_email" onfocus="if(this.value == \'example@example.com\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'example@example.com\'; }" value="example@example.com" class="'.$class.'" required /></p>';
		
		if ( isset( $cs_contactus_label ) && $cs_contactus_label == 'on' ) {
			$html	.= '<label>'.__('Enter Subject','LMS').'</label>';
		}
		
		$html	.= '<p>'.$eubjectIcon.'<input type="text" name="subject" onfocus="if(this.value == \'Subject\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'Subject\'; }" value="Subject" class="'.$class.'" required /></p>';
		
		if ( isset( $cs_contactus_label ) && $cs_contactus_label == 'on' ) {
			$html	.= '<label>'.__('Message','LMS').'</label>';
		}
		
		$html	.= '<textarea class="'.$class.'" placeholder="'.__('Message','LMS').'" name="contact_msg" required></textarea>';
		$html	.= '<input type="submit" value="'.__('Submit','LMS').'" class="custom-btn circle btn-lg cs-bg-color" id="submit_btn'.$cs_email_counter.'">';
		$html	.= '</form>';
		$html	.= '<div id="loading_div'.$cs_email_counter.'"></div>';
		$html	.= '<div id="message'.$cs_email_counter.'"  style="display:none;"></div>';
		$html	.= '</div>';
		$html	.= '</div>';
		
		$cs_contact_class_id = '';
		if($cs_contact_class <> ''){
			$cs_contact_class_id = ' id="'.$cs_contact_class.'"';
		}
		return '<div class="'.$column_class.'"'.$cs_contact_class_id.'>'.$section_title.$html.'</div>';
	}
	add_shortcode('cs_contactus', 'cs_contactus_shortcode');
}
// adding Contact Us Form  End

//=====================================================================
// Adding message start
//=====================================================================
if (!function_exists('cs_message_shortcode')) {
	function cs_message_shortcode($atts, $content = "") {
		$defaults = array( 'column_size' => '1/1', 'cs_msg_section_title' => '', 'cs_message_title' => '','cs_message_type' => '','cs_alert_style' => '','cs_message_style' => '','cs_style_type' => '', 'cs_message_icon' => '','cs_title_color' => '','cs_icon_bg_color' => '','cs_button_text' => '','cs_button_link' => '','cs_icon_color' => '','cs_message_close' => '','cs_message_class' => '','cs_message_animation' => '','cs_message_animation_duration' => '');
		extract( shortcode_atts( $defaults, $atts ) ); 
		$html = '';
		$column_class	= cs_custom_column_class($column_size);
		$section_title = '';
		
		if ( trim($cs_message_animation) !='' ) {
			$cs_message_animation	= 'wow'.' '.$cs_message_animation;
		} else {
			$cs_message_animation	= '';
		}
		
		if ($cs_msg_section_title && trim($cs_msg_section_title) !='' ) {
			$html	.= '<div class="cs-section-title"><h2 class="'.$cs_message_animation.'">'.$cs_msg_section_title.'</h2></div>';
		}
		$html	.= '<div class="'.$cs_message_animation.' '.$cs_message_class.'">';
		if(isset($cs_message_type) && $cs_message_type <> 'message'){
			
			$fancyClass	= '';
			$no_border	= '';
			$text_color	=  '#FFF'; 
			
			if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'error_messagebox') {
				
				$html	.= '<div class="messagebox-v2 alert alert-info align-left close_btn_style " style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; background:#b92317; color:#65a31b; border:1px solid #b92317;">';
			
			} 
			else if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'success_messagebox') {
				$html	.= '<div class="messagebox-v2 alert alert-info align-left close_btn_style " style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; background:#8c9b1e; color:#65a31b; border:1px solid #6e7b0b;">';
			
			}
			else if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'warning_messagebox') {
				$html	.= '<div class="messagebox-v2 alert alert-info align-left close_btn_style " style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; background:#be8624; color:#65a31b; border:1px solid #be8624;">';
			
			}
			else if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'col_info_messagebox') {
				
				$html	.= '<div class="messagebox-v2 alert alert-info align-left close_btn_style " style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; background:#4a83b7; color:#65a31b; border:1px solid #4a83b7;">';
			
			}
			else if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'simp_info_messagebox') {
				
				$html	.= '<div class="messagebox-v2 messagebox-v3 alert alert-info align-left close_btn_style margin_bottom no_border" style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; background:#f2f2f2; color:#65a31b; border:1px solid #e2e2e2;">';
			
			} 
			if (isset($cs_message_close) && $cs_message_close =='yes'){
				if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'error_messagebox') {
					$html .= '<button type="button" class="close" data-dismiss="alert" style="background:#f63d26; border:1px solid #eb5439;"><em class="fa fa-times"></em></button>';
				}
				if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'success_messagebox') {
					
					$html .= '<button type="button" class="close" data-dismiss="alert" style="background:#b4d601; border:1px solid #98c601;"><em class="fa fa-times"></em></button>';
				}
				if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'warning_messagebox') {
					$html .= '<button type="button" class="close" data-dismiss="alert" style="background:#f5b62e; border:1px solid #fab418;"><em class="fa fa-times"></em></button>';
				}
				if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'col_info_messagebox') {
					$html .= '<button type="button" class="close" data-dismiss="alert" style="background:#3aa5ec;border:1px solid #4d8fcb; "><em class="fa fa-times"></em></button>';
				}
				if ( $cs_alert_style == 'threed_messagebox' && $cs_style_type == 'simp_info_messagebox') {
					$no_border	= 'no_border';
					$html .= '<button type="button" class="close" data-dismiss="alert" style="background:#c1c1c1;border:1px solid #b8b8b8; "><em class="fa fa-times"></em></button>';
				}
			}
			if (isset($cs_message_icon) and $cs_message_icon <> ""){
					$html .= '<i class="fa ' . $cs_message_icon .' '.$no_border.'"></i>';
			}
			$html .= '<span>';
			if (isset($cs_message_title) and $cs_message_title <> ""){
				$html	.= do_shortcode( $cs_message_title );
			}
			if ( $cs_alert_style == 'threed_messagebox') {
				$html 	.= '<a>'.do_shortcode($content).'</a>';
			}
			$html	.= '</span>';
			$html	.= '</div>';
		} else {
				$bg_icon	= '';
				if($cs_message_style == 'bg_icon'){
					$bg_icon	= 'has_bgicon';
				}
				$cs_icon_color	= $cs_icon_color ? $cs_icon_color : '#FFF';
				if ($cs_message_style == 'bg_icon') {
					$cs_icon_color	= '#21CDEC';
				}
						
				$cs_icon_bg_color	= $cs_icon_bg_color ? $cs_icon_bg_color : 'transparent;';
				
				if($cs_message_style == 'cirle_style'){
				echo '<style scoped="scoped"> 
							.messagebox.icon_position_left .'.$cs_message_icon.' {
							border-radius: 100%;
							color: '.$cs_icon_color.'  !important;
							display: inline-block;
							font-size: 30px;
							height: 68px;
							line-height: 68px;
							text-align: center;
							width: 68px;
							background-color: '.$cs_icon_bg_color.' !important;
						}
						 </style>';
				}
				
				$html .= '<div style="background:url('. get_template_directory_uri().'/assets/images/massag-bg.png) repeat; color:#999999; border:1px solid #e2e2e2; box-shadow:0px 3px 0px 0px '.$cs_icon_color.';" class=" messagebox messagebox-v1 alert alert-info align-left icon_position_left '.$bg_icon.'">';
				
				if (isset($cs_message_close) && $cs_message_close=='yes'){
					$html .= '<button data-dismiss="alert" class="close" type="button" ><em class="fa fa-times"></em></button>';
				}
				
				if (isset($cs_message_icon) and $cs_message_icon <> "" and $bg_icon ==''){
						
						if ($cs_message_style == 'cirle_style') {
							$cs_icon_color	= $cs_icon_color ? $cs_icon_color : '#FFF';
						}
						
						$html .= '<i style="color:'.$cs_icon_color.'; background-color:'.$cs_icon_bg_color.'" class="fa ' . $cs_message_icon . '"></i>';
				}
				
				if (isset($cs_message_title) and $cs_message_title <> ""){
					$html .= '<h3 style="color:'.$cs_title_color.'">' . do_shortcode( $cs_message_title ) . '</h3>';
				}
				
				$html .= '<p>' . do_shortcode($content) . '</p>';
				
				if ($cs_message_style == 'btn_style') {
					$cs_button_text	= $cs_button_text ?  $cs_button_text : 'Buy Now';
					$cs_button_link	= $cs_button_link ?  $cs_button_link : '#';
					$html .= '<a href="'.$cs_button_link.'"><span class="custom-btn cs-bg-color" style="background-color:'.$cs_icon_color.' !important;">'.$cs_button_text.'</span></a>';
				}
				
				$html .= '</div>';
			
		}
		$cs_message_class_id = '';
		if($cs_message_class <> ''){
			$cs_message_class_id = ' id="'.$cs_message_class.'"';
		}
		$html .= '</div>';
		return do_shortcode('<div class="'.$column_class.'"'.$cs_message_class_id.'>'.$html.'</div>');
	}
	add_shortcode('cs_message', 'cs_message_shortcode');
}
// adding message end

//=====================================================================
// Adding Testimonial start
//=====================================================================
if (!function_exists('cs_testimonials_shortcode')) {
	function cs_testimonials_shortcode( $atts, $content = null ) {
		global $testimonial_style,$cs_testimonial_class,$column_class,$testimonial_text_color,$section_title;
		$randomid = rand(0,999);
		cs_owl_carousel();
		$defaults = array('testimonial_style'=>'','testimonial_text_color'=>'','column_size'=>'1/1','cs_testimonial_section_title'=>'','cs_testimonial_class'=>'','cs_testimonial_animation'=>'','cs_testimonial_animation_duration' => '');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class = cs_custom_column_class($column_size);
		$html = '';
		$section_title = '';
		
		if ( trim($cs_testimonial_animation) !='' ) {
			$cs_testimonial_animation	= 'wow'.' '.$cs_testimonial_animation;
		} else {
			$cs_testimonial_animation	= '';
		}
		
		if ($cs_testimonial_section_title && trim($cs_testimonial_section_title) !='' ) {
			$section_title	= '<div class="cs-section-title '.$column_class.'"><h2 class="'.$cs_testimonial_animation.'">'.$cs_testimonial_section_title.'</h2></div>';
		}
		
		$customID	= '';
		if ( isset ( $cs_testimonial_class )  && $cs_testimonial_class !='' ) {
			$customID	= 'id="'.$cs_testimonial_class.'"';
		}
		$randomid = rand(32423,5464645);
		cs_enqueue_flexslider_script();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#cs-testimonial-<?php echo esc_js($randomid); ?> .flexslider').flexslider({
					animation: "fade",
					slideshow: true,
					smoothHeight: true,
					controlNav: false,
					directionNav: false,
					slideshowSpeed: 7000,
					animationDuration: 600,
					prevText:"<em class='fa fa-arrow-left'></em>",
					nextText:"<em class='fa fa-arrow-right'></em>",
					start: function(slider) {
						jQuery('.flexslider').fadeIn();
					}
				});
			});
		</script>
        <?php        
		if(isset($testimonial_style) && $testimonial_style == 'slider'){
			$output = '';
			
		    $output .= '<div class="cs-testimonial '.$cs_testimonial_animation.'"  '.$customID.'>
						  '.$section_title.'
						  <div class="has_border testimonial-'.$testimonial_style.'" id="cs-testimonial-'.$randomid.'">
						    <div class="flexslider" style="display: none;">
							  <ul class="slides">
								' . do_shortcode( $content ) . 
							  '</ul>
							</div>
						   </div>
					   </div>';
		
		}else if(isset($testimonial_style) && $testimonial_style == 'modren') {
			$output = '<div class="cs-testimonial '.$testimonial_style.' '.$cs_testimonial_animation.'">
						'.$section_title.' 
							<div class="'.$column_class.'" '.$customID.'>
								<div class="has_border testimonial-'.$testimonial_style.'" id="cs-testimonial-'.$randomid.'">
								   <div class="flexslider" style="display: none;">
									<ul class="slides">
									  '. do_shortcode( $content ) . 
									'</ul>
								   </div>
								 </div>
							 </div>
					   </div>';
		} else {
			$output = '<div class="cs-testimonial '.$testimonial_style.' '.$cs_testimonial_animation.'">
						'.$section_title.' 
						<div class="'.$column_class.'" '.$customID.'>
						   <div class="has_border testimonial-'.$testimonial_style.'" id="cs-testimonial-'.$randomid.'">
							<div class="flexslider" style="display: none;">
							  <ul class="slides">
							 '. do_shortcode( $content ) . 
							 '</ul>
							</div>
						  </div>
						</div>
					   </div>';
		}
		
		return  $output;
	}
	add_shortcode( 'cs_testimonials', 'cs_testimonials_shortcode' );
}
// adding Testimonial end

//=====================================================================
// Adding Testimonial Item start
//=====================================================================
if (!function_exists('cs_testimonial_item')) {
	function cs_testimonial_item( $atts, $content = null ) {
		global $testimonial_style,$cs_testimonial_class,$column_class,$testimonial_text_color;
		$defaults = array('testimonial_author' =>'','testimonial_img' => '','testimonial_company' => '');
		extract( shortcode_atts( $defaults, $atts ) );
		$figure = '';
		
		if(isset($testimonial_img) && $testimonial_img <> ''){
			$figure = '<figure><img src="'.$testimonial_img.'" alt="" /></figure>';
		}
		$tc_color = '';
		if(isset($testimonial_text_color) && $testimonial_text_color <> ''){
			$tc_color = 'style=color:'.$testimonial_text_color.'!important';
		}
		
		if(isset($testimonial_style) && $testimonial_style == 'modren'){
			
	   return '<li>
				<article class="item" >
					<div class="question-mark">
						<p '.$tc_color.'>'. do_shortcode( $content ) .'</p>
						'.$figure.'
						<h4 class="cs-author" '.$tc_color.'>'. $testimonial_author .'
							<br/>
							<span '.$tc_color.'>'. $testimonial_company.'</span>
						</h4>
					</div>
				</article>
			 </li>';
		
		} else if(isset($testimonial_style) && $testimonial_style == 'slider'){
			return '<li>
						<article class="item" >
							<div class="question-mark">
								<span class="ts-quote">"</span><br/>
								<p '.$tc_color.'>'. do_shortcode( $content ) .'</p>
								'.$figure.'
								<h4 class="cs-author" '.$tc_color.'>
									 '.$testimonial_author .'<br>
									<span '.$tc_color.'>'. $testimonial_company .'</span>
								</h4>
							</div>
						</article>
					</li>';
		} else {
			
			 return '<li>
						<article class="item" >
							<div class="question-mark">
								<p '.$tc_color.'>'. do_shortcode( $content ) .'</p>
								'.$figure.'
								<h4 class="cs-author" '.$tc_color.'>'. $testimonial_author .'
									<br/>
									<span '.$tc_color.'>'. $testimonial_company.'</span>
								</h4>
							</div>
						</article>
				   </li>';
		} 
	}
	add_shortcode( 'testimonial_item', 'cs_testimonial_item' );
}
// adding Testimonial Item end