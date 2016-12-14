<?php
/**
 * File Type: Common Elements Shortcode Functions
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */

//======================================================================
// Adding pricetable
//======================================================================
if (!function_exists('cs_pricetable_shortcode')) {
	function cs_pricetable_shortcode($atts, $content = "") {
		global $pricetable_style;
		$defaults = array('column_size'=>'1/1','pricetable_style'=>'','pricetable_title'=>'','pricetable_price'=>'','pricetable_img'=>'','pricetable_period'=>'','pricetable_bgcolor'=>'#000','btn_text'=>'','btn_link'=>'','btn_bg_color'=>'','pricetable_featured'=>'','pricetable_class'=>'','pricetable_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		
		$CustomId	= '';
		if ( isset( $pricetable_class ) && $pricetable_class ) {
			$CustomId	= 'id="'.$pricetable_class.'"';
		}
		
		if ( trim($pricetable_animation) !='' ) {
			$pricetable_animation	= 'wow'.' '.$pricetable_animation;
		} else {
			$pricetable_animation	= '';
		}
		
		$pricetableViewClass = '';
		
		if(isset($pricetable_style) && $pricetable_style == 'classic'){
			$pricetableViewClass = ' pr-classic';
		} else if(isset($pricetable_style) && $pricetable_style == 'simple'){
			$pricetableViewClass = ' pr-simple';
		} else if(isset($pricetable_style) && $pricetable_style == 'clean'){
			$pricetableViewClass = ' pr-clean';
		} else {
			
		}
		
		$html = '';

		$bgcolor_style = '';
		
		if(isset($btn_bg_color) && trim($btn_bg_color) <> ''){
			$btn_bg_color = ' style="background-color:'.$btn_bg_color.'"';
		}
		
		if(isset($pricetable_bgcolor) && trim($pricetable_bgcolor) <> ''){
			$bgcolor_style = ' style="background-color:'.$pricetable_bgcolor.'"';
		}
		
		if(isset($pricetable_featured) && $pricetable_featured == 'Yes'){
			$featured = 'featured';
		} else {
			$featured = '';
		}
		
		if(isset($pricetable_style) && ( $pricetable_style == 'classic' || $pricetable_style == 'clean' )){

			$html .= '<div class="cs-price" '.$bgcolor_style.'>';
			
			if(isset($pricetable_img) && $pricetable_img !=''){
				$html .= '<figure><img src="'.$pricetable_img.'"></figure>';
			}
			
			if(isset($pricetable_price) && $pricetable_price !=''){
				$html .= $pricetable_price;
			}
			
			if(isset($pricetable_period) && $pricetable_period !=''){
				$html .= '<small>'.$pricetable_period.'</small>';
			}
			
			if(isset($pricetable_title) && $pricetable_title !=''){
				$html .= '<h3 style="color:#FFF !important;">'.$pricetable_title .'</h3>';
			}
			
			$html .= '</div>';
			$html .= '<ul class="features">';
			$html .= do_shortcode($content);
			$html .= '</ul>';
			$html .= ' <a class="custom-btn sigun_up" href="'.esc_url($btn_link).'" '.$btn_bg_color.'>'.$btn_text.'</a>';
			
			return '<div '.$CustomId.' class="'.$column_class.' cs-price-table '.$pricetableViewClass.' '.$pricetable_animation.' '.$pricetable_class.' '.$featured.'">'.$html.'</div>';
			
		} else {
			
			$html .= '<article class="cs-price-table '.$pricetableViewClass.' '.$pricetable_animation.' '.$pricetable_class.' '.$featured.'">';
			if(isset($pricetable_title) && $pricetable_title !=''){
				$html .= '<h3 style="color:#FFF !important;">'.$pricetable_title .'</h3>';
			}
			
			$btn_text = $btn_text ? $btn_text : 'Sign Up';
			$html .= '<div class="cs-price" '.$bgcolor_style.'>';
			
			if(isset($pricetable_img) && $pricetable_img !=''){
				$html .= '<figure><img src="'.$pricetable_img.'"></figure>';
			}
			
			if(isset($pricetable_price) && $pricetable_price !=''){
				$html .= $pricetable_price;
			}
			
			if(isset($pricetable_period) && $pricetable_period !=''){
				$html .= '<small>'.$pricetable_period.'</small>';
			}
			
			$html .= '</div>';
			$html .= '<ul class="features">';
			$html .= do_shortcode($content);
			$html .= '</ul>';
			$html .= ' <a class="custom-btn sigun_up" href="'.$btn_link.'" '.$btn_bg_color.'>'.$btn_text.'</a>';
			$html .= '</article>';
			return '<div '.$CustomId.' class="'.$column_class.'">'.$html.'</div>';
		}
	}
	add_shortcode('cs_pricetable', 'cs_pricetable_shortcode');
}

//======================================================================
// Pricing Item
//======================================================================
if (!function_exists('cs_pricing_item')) {
	function cs_pricing_item($atts, $content = "") {
		global $pricetable_style;
		$defaults = array('pricing_feature' => '');
		extract( shortcode_atts( $defaults, $atts ) );
		$html	 = '';
		$priceCheck	= '';
		if ( $pricetable_style =='classic' || $pricetable_style =='clean' ) {
			$priceCheck	= '<i class="fa fa-check"></i>';
		}
		
		if ( isset( $pricing_feature ) && $pricing_feature !='' ){
			$html	.= '<li>'.$priceCheck.$pricing_feature.'</li>';
		}
		
		return $html;
	}
	add_shortcode('pricing_item', 'cs_pricing_item');
}

//======================================================================
//Table Start
//======================================================================
if (!function_exists('cs_table_shortcode_func')) {
	function cs_table_shortcode_func($atts, $content = "") {
		global $table_style;
		$defaults = array('table_style'=>'modern','cs_table_section_title'=>'','column_size'=>'1/1','cs_table_class'=>'','cs_table_animation'=>'','cs_table_custom_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$CustomId	= '';
		if ( isset( $cs_table_class ) && $cs_table_class ) {
			$CustomId	= 'id="'.$cs_table_class.'"';
		}
		
		$column_class  = cs_custom_column_class($column_size);
		
		if ( trim($cs_table_animation) !='' ) {
			$cs_table_animation	= 'wow'.' '.$cs_table_animation;
		} else {
			$cs_table_animation	= '';
		}

		$section_title = '';
		
		if(isset($cs_table_section_title) && trim($cs_table_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2>'.$cs_table_section_title.'</h2></div>';
		}
		return '<div '.$CustomId.' class="'.$column_class.' '.$cs_table_class.' '.$cs_table_animation.'">'.$section_title.do_shortcode($content).'</div>';
	}
	add_shortcode('cs_table', 'cs_table_shortcode_func');
}

//======================================================================
// Adding table
//======================================================================

if (!function_exists('cs_table_shortcode')) {
	function cs_table_shortcode($atts, $content = "") {
		global $table_style;
		$defaults = array('column_size'=>'1/1','cs_table_section_title'=>'','cs_table_content'=>'','cs_table_class'=>'','cs_table_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$content = str_replace('<br />','',$content);
		$table_data = '';
		$class = '';
		if($table_style == 'classic'){
			$class = 'table table-v2';
		}else if( $table_style == 'modren' ) {
			$class = 'table table-v1';
		}
		/*if(isset($color) && $color <> ''){
			$table_class = "table_" . rand(55,6555);
		}*/
		return $table_data . '<table class="'.$class.'">'.do_shortcode($content).'</table>';
	}
	add_shortcode('table', 'cs_table_shortcode');
}

//======================================================================
// Table Head
//======================================================================
if (!function_exists('cs_table_body_shortcode')) {
	function cs_table_body_shortcode($atts, $content = "") {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		return '<tbody>'.do_shortcode($content).'</tbody>';
	}
	add_shortcode('tbody', 'cs_table_body_shortcode');
}

//======================================================================
// Table Head
//======================================================================
if (!function_exists('cs_table_head_shortcode')) {
	function cs_table_head_shortcode($atts, $content = "") {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		return '<thead>'.do_shortcode($content).'</thead>';
	}
	add_shortcode('thead', 'cs_table_head_shortcode');
}

//======================================================================
// Table Row
//======================================================================
if (!function_exists('cs_table_row_shortcode')) {
	function cs_table_row_shortcode($atts, $content = "") {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		return '<tr>'.do_shortcode($content).'</tr>';
	
	}
	add_shortcode('tr', 'cs_table_row_shortcode');
}

//======================================================================
// Table Heading
//======================================================================
if (!function_exists('cs_table_heading_shortcode')) {
	function cs_table_heading_shortcode($atts, $content = "") {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		$html	 = '';
		$html	.= '<th>';
		$html	.= do_shortcode($content);
		$html	.= '</th>';
		
		return $html;
	}
	add_shortcode('th', 'cs_table_heading_shortcode');
}

//======================================================================
// Table data
//======================================================================
if (!function_exists('cs_table_data_shortcode')) {
	function cs_table_data_shortcode($atts, $content = "") {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		return '<td>'.do_shortcode($content).'</td>';
	}
	add_shortcode('td', 'cs_table_data_shortcode');
}

//======================================================================
// adding accordion
//======================================================================
if (!function_exists('cs_accordion_shortcode')) {
	function cs_accordion_shortcode($atts, $content = "") {
		global $acc_counter,$accordian_style;
		$acc_counter = rand(40, 9999999);;
		$html	= '';
		$defaults = array('column_size'=>'1/1', 'class' => 'cs-accrodian','accordian_style' => '','accordion_class' => '','accordion_animation' => '','cs_accordian_section_title'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		
		$CustomId	= '';
		if ( isset( $accordion_class ) && $accordion_class ) {
			$CustomId	= 'id="'.$accordion_class.'"';
		}
		
		if ( trim($accordion_animation) !='' ) {
			$accordion_animation	= 'wow'.' '.$accordion_animation;
		} else {
			$accordion_animation	= '';
		}
		$section_title = '';
		if(isset($cs_accordian_section_title) && trim($cs_accordian_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2>'.$cs_accordian_section_title.'</h2></div><div class="clear"></div>';
		}
		if ( $accordian_style == 'colored' ) {
			$styleClass	= 'accordion-v2';
		} else {
			$styleClass	= 'accordion-v1';
		}
		$html   .= '<div '.$CustomId.' class="'.$column_class.'">';
		$html	.= '<div class="panel-group '.$styleClass.' '.$accordion_class.' '.$accordion_animation.'" id="accordion-' . $acc_counter . '">'.$section_title.do_shortcode($content).'</div>';
		$html	.= '</div>';
		return $html;
	}
	
	add_shortcode('cs_accordian', 'cs_accordion_shortcode');
}

//======================================================================
// Adding accordion item start
//======================================================================
if (!function_exists('cs_accordion_item_shortcode')) {
	function cs_accordion_item_shortcode($atts, $content = "") {
		global $acc_counter,$accordian_style,$accordion_animation;
		$defaults = array( 'accordion_title' => 'Title','accordion_active' => 'yes','cs_accordian_icon' => '');
		extract( shortcode_atts( $defaults, $atts ) );
		$accordion_count = 0;
		$accordion_count = rand(40, 9999999);
		$html = "";
		$active_in = '';
		$active_class = '';
		$styleColapse = '';
		
		if ( $accordian_style == 'colored' ) {
			$styleColapse	= 'collapse collapsed';
		} else if ( $accordian_style == 'normal' ){
			$styleColapse	= 'collapsed';
		}
		if(isset($accordion_active) && $accordion_active == 'yes'){
			if ( $accordian_style == 'colored' ) {
				$styleColapse	= 'collapse';
				$active_in = 'in';
				$active_class = '';
			} else if ( $accordian_style == 'normal' ){
				$styleColapse	= 'collapse';
				$active_in = 'in';
				$active_class = '';
			}
		}
		$faq_style = '';
		
		$cs_accordian_icon_class = '';
		if(isset($cs_accordian_icon)){
			$cs_accordian_icon_class = '<i class="fa '.$cs_accordian_icon.'"></i>';
		}
		$html = '<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion-'.$acc_counter.'" href="#accordion-'.$accordion_count.'" class="'.$styleColapse.' '.$active_class.'">
						   '. $faq_style . $cs_accordian_icon_class . $accordion_title . '
						</a>
					  </h4>
					</div>
					<div id="accordion-'.$accordion_count.'" class="panel-collapse collapse '.$active_in.' ">
					  <div class="panel-body">'.$content.'</div>
					</div>
				  </div>';
		return $html;
	}
	add_shortcode('accordian_item', 'cs_accordion_item_shortcode');
}

//======================================================================
// Tabs Shortcodes 
//======================================================================
if (!function_exists('cs_tabs_shortcode')) {
	function cs_tabs_shortcode( $atts, $content = null ) {
		global $tabs_content;
		$tabs_content = '';
		extract(shortcode_atts(array(  
			'cs_tab_style' => '',
			'cs_tabs_class' => '',
			'column_size'=>'1/1', 
			'cs_tabs_section_title' => '',
			'cs_tabs_animation' => '',
			'cs_custom_animation_duration' => ''
		), $atts));  
		$column_class  = cs_custom_column_class($column_size);
		
		$CustomId	= '';
		if ( isset( $cs_tabs_class ) && $cs_tabs_class ) {
			$CustomId	= 'id="'.$cs_tabs_class.'"';
		}
		
		if ( trim($cs_tabs_animation) !='' ) {
			$cs_tabs_animation	= 'wow'.' '.$cs_tabs_animation;
		} else {
			$cs_tabs_animation	= '';
		}
		$randid = rand(8,9999);
		$section_title = '';
		$tabs_output = '';
		if ( isset($cs_tabs_section_title) && trim($cs_tabs_section_title) !='' ) {
			$section_title	= '<div class="cs-section-title"><h2>'.$cs_tabs_section_title.'</h2></div>';
		}
		$tabs_output .= '<div class="cs-tabs '.$cs_tab_style.' '.$cs_tabs_animation.'"  id="cstabs'.$randid.'" style="animation-duration: '.$cs_custom_animation_duration.'s;">';
		$tabs_output .= $section_title;
		$tabs_output .= '<ul class="nav-tabs '.$cs_tabs_class.'" > ';
		$tabs_output .= do_shortcode($content);
		$tabs_output .= '</ul>';
		$tabs_output .= '<div class="tab-content">'.$tabs_content.'</div>';
		$tabs_output .= '</div>';
		return '<div '.$CustomId.' class="'.$column_class.' '.$cs_tabs_class.'">'.$tabs_output.'</div>';  
	}  
	add_shortcode('cs_tabs', 'cs_tabs_shortcode');
}

//======================================================================
// Tab Items 
//======================================================================
if (!function_exists('cs_tab_item_shortcode')) {
	function cs_tab_item_shortcode($atts, $content = null) {  
		global $tabs_content;
		extract(shortcode_atts(array(  
			'cs_tab_icon' => '',
			'tab_title' => '',
			'cs_tab_icon' => '',
			'tab_active'=>'no' 
		), $atts));  
		$activeClass = $tab_active == 'yes' ? 'active in' :'';
		$fa_icon='';
		if($cs_tab_icon){
			$fa_icon = '<i class="fa '.$cs_tab_icon.'"></i> ';
		}
		$randid = rand(877,9999);
		$output = ' <li class="'.$activeClass.'"> <a href="#cs-tab-'.sanitize_title($tab_title).$randid.'"  data-toggle="tab">'.$fa_icon.$tab_title.'</a></li>';
		$tabs_content.= '<div class="tab-pane fade '.$activeClass.'" id="cs-tab-'.sanitize_title($tab_title).$randid.'">'.do_shortcode($content).'</div>';
		return $output;
	}
	add_shortcode( 'tab_item', 'cs_tab_item_shortcode' );
}

//======================================================================
// Toggle Start
//======================================================================
if (!function_exists('cs_toggle_shortcode')) {
	function cs_toggle_shortcode($atts, $content = "") {
		$defaults = array( 'column_size'=>'1/1','cs_toggle_section_title' => '','cs_toggle_title' => '','cs_toggle_state' => '','cs_toggle_icon' => '','cs_toggle_custom_class' => '','cs_toggle_custom_animation' => '','cs_toggle_custom_animation_duration' => '1');
		extract( shortcode_atts( $defaults, $atts ) );
		$toggle_counter = rand(1,99999);
		$active = "";
		$collapse = "collapsed";
		$cs_toggle_icon_class = '';
		$column_class  = cs_custom_column_class($column_size);
		
		$CustomId	= '';
		if ( isset( $cs_toggle_custom_class ) && $cs_toggle_custom_class ) {
			$CustomId	= 'id="'.$cs_toggle_custom_class.'"';
		}
		
		if ( trim($cs_toggle_custom_animation) !='' ) {
			$cs_toggle_custom_animation	= 'wow'.' '.$cs_toggle_custom_animation;
		} else {
			$cs_toggle_custom_animation	= '';
		}
		
		if ( $cs_toggle_state == "open" ){ $active = "in"; }
		if ( $cs_toggle_icon <> "" ){ $cs_toggle_icon_class = '<i class="fa '.$cs_toggle_icon.'"></i>';}
		$section_title = '';
		if(isset($cs_toggle_section_title) && trim($cs_toggle_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2>'.$cs_toggle_section_title.'</h2></div>';
		}
		$html = '<div class="panel-group" id="#accordion' . $toggle_counter . '">
				  <div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion' . $toggle_counter . '" href="#toggle' . $toggle_counter . '">
						  '.$cs_toggle_icon_class.$cs_toggle_title.'
						</a>
					  </h4>
					</div>
					<div id="toggle' . $toggle_counter . '" class="panel-collapse collapse '.$active.'">
					  <div class="panel-body">
					   <p>' . do_shortcode($content) . '</p>
					  </div>
					</div>
				  </div>
				</div>';
		
		return '<div '.$CustomId.' class="'.$column_class.'"><div class="'.$cs_toggle_custom_class.' '.$cs_toggle_custom_animation.'" style="animation-duration: '.$cs_toggle_custom_animation_duration.'s;">'.do_shortcode($html) . '</div></div>';
	}
	add_shortcode('cs_toggle', 'cs_toggle_shortcode');
}

//======================================================================
// button shortcode start
//======================================================================
if (!function_exists('cs_button_shortcode')) {
	function cs_button_shortcode($atts) {
		$defaults = array( 'button_size'=>'btn-lg','button_border' => '','border_button_color' => '','button_title' => '','button_link' => '#','button_color' => '#fff','button_bg_color' => '#000','button_icon_position' => 'left','button_icon'=>'', 'button_type' => 'rounded','button_target' => '_self','cs_button_class' => '','cs_button_animation' => 'cs-button-shortcode');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$CustomId	= '';
		if ( isset( $cs_button_class ) && $cs_button_class ) {
			$CustomId	= 'id="'.$cs_button_class.'"';
		}
		
		$button_type_class = 'no_circle';
		 if ( trim($cs_button_animation) !='' ) {
			$cs_button_animation	= '';
		 } else {
			$cs_button_animation	= '';
		 }
		$border	= '';
		$has_icon = '';	
		
		if(isset($button_border) && $button_border == 'yes'){
			$border = ' border: 1px solid '.$border_button_color.';';	
		}
		
		if(isset($button_type) && $button_type == 'rounded'){
			$button_type_class = 'circle';
		}
		if(isset($button_type) && $button_type == 'three-d'){
			$button_type_class = 'fancy-custombutton';
			$border	= '';
		}
		
		if(isset($button_icon) && $button_icon <> ''){
			$has_icon = 'has_icon';	
		}
		
		$html  = '';
		$html .= '<div '.$CustomId.' class="button_style">';
		$html .= '<a href="' . $button_link. '" class="custom-btn '.$button_type_class. ' ' . $button_size. ' bg-color ' . $cs_button_class. ' ' . $cs_button_animation. ' '.$has_icon.'" style="'.$border.'  background-color: ' . $button_bg_color . '; color:' . $button_color . ' ;">';
		if(isset($button_icon) && $button_icon <> ''){
			$html .= '<i class="fa '.$button_icon.' button-icon-'. $button_icon_position.'"></i>';
		}
		if(isset($button_title) && $button_title <> ''){
			$html .= $button_title;
		}
		$html .= '</a>';
		$html .= '</div>';
		return do_shortcode($html);
	}
	add_shortcode('cs_button', 'cs_button_shortcode');
}

//======================================================================
// Number Counter Item Shortcode Start
//======================================================================
if (!function_exists('cs_counter_item_shortcode')) {
	function cs_counter_item_shortcode($atts, $content = null) {
		global $counter_style;
		extract(shortcode_atts(array(  
			'column_size' => '1/1',
			'counter_style' => '',
			'counter_icon_type' => '',
			'cs_counter_logo' => '',
			'counter_icon'=>'',
			'counter_icon_color' => '#21cdec',
			'counter_numbers' => '',
			'counter_number_color' => '#333333',
			'counter_title' => '',
			'counter_link_title' => '',
			'counter_link_url' => '',
			'counter_text_color' => '#818181',
			'counter_border' => '',
			'counter_class' => '',
			'counter_animation' => '',
			'cs_custom_animation_duration' => '1'
		 ), $atts));
		 
		 $column_class  = cs_custom_column_class($column_size);
		 
		 $CustomId	= '';
		 if ( isset( $counter_class ) && $counter_class ) {
			$CustomId	= 'id="'.$counter_class.'"';
		 }
		 
		 if ( trim($counter_animation) !='' ) {
			$counter_animation	= 'wow'.' '.$counter_animation;
		 } else {
			$counter_animation	= '';
		 }
			$rand_id = rand(98,56666);
			$output = '';
			$counter_style_class = '';
			$pattren_bg          = '';
			$has_border 	= '';
			$output = '';
			$border_class =  '';
			
			if( $counter_border == 'on'){
				$border_class = 'has_border';
			}
			cs_count_numbers_script();
			
			$output .= '<script>
					jQuery(document).ready(function($){
						jQuery(".custom-counter-'.esc_js($rand_id).'").counterUp({
							delay: 10,
							time: 1000
						});
					});	
				</script>
				';
			if($counter_style == 'plain'){
				$counter_style_class = 'cs_counter';
				$output .= '<figure>';
				if($counter_icon_type == 'icon' && $counter_icon <> ''){
					$output .= '<i class="fa '.$counter_icon.' fa-2x" style=" color: '.$counter_icon_color.'; "></i>';
				} else if($counter_icon_type == 'image' && $cs_counter_logo <> ''){
					$output .= '<img src="'.$cs_counter_logo.'" alt="">';
				}
				
				$output .= '<figcaption>';
				if($counter_numbers <> ''){
					$output .= '<a class="cs-numcount custom-counter-'.$rand_id.'" style=" color: '.$counter_number_color.'; ">'.$counter_numbers.'</a>';
				}
				
				if($counter_title <> ''){
					$output .= '<h3 style="color:'.$counter_text_color.' !important;">'.$counter_title.'</h3>';
				}
				$output .= '<p style=" color: '.$counter_text_color.' !important; ">'.do_shortcode($content).'</p>';
				if($counter_link_url <> '' || $counter_link_title <> ''){
					$counter_link_title = $counter_link_title ? $counter_link_title : 'Read More';
					$output .= '<a class="custom-btn" href="'.$counter_link_url.'" style="padding:11px 35px;">'.$counter_link_title.'</a>';
				}
				$output .= '</figcaption>';
				$output .= '</figure>';
			} else if($counter_style == 'pattern'){
				
				$counter_style_class = 'cs_counter has_pattern left';
				$output .= '<figure>';
				if($counter_icon_type == 'icon' && $counter_icon <> ''){
					$output .= '<i class="fa '.$counter_icon.' fa-2x" style=" color: '.$counter_icon_color.'; "></i>';
				} else if($counter_icon_type == 'image' && $cs_counter_logo <> ''){
					$output .= '<img src="'.$cs_counter_logo.'" alt="">';
				}
				$output .= '<figcaption>';
				if($counter_numbers <> ''){
					$output .= '<a class="cs-numcount custom-counter-'.$rand_id.'" style=" color: '.$counter_number_color.'; ">'.$counter_numbers.'</a>';
				}
				if($counter_title <> ''){
					$output .= '<h3 style="color:'.$counter_text_color.' !important; ">'.$counter_title.'</h3>';
				}
				$output .= '<p style=" color: '.$counter_text_color.' !important;">'.do_shortcode($content).'</p>';
				if($counter_link_url <> '' || $counter_link_title <> ''){
					$counter_link_title = $counter_link_title ? $counter_link_title : 'Read More';
					$output .= '<a class="custom-btn" href="'.$counter_link_url.'" style="padding:11px 35px;">'.$counter_link_title.'</a>';
				}
				$output .= '</figcaption>';
				$output .= '</figure>';
			} else if($counter_style == 'simple'){
				
				$counter_style_class = 'cs_counter has_rightbdr';
				$output .= '<figure>';
				
				if($counter_icon_type == 'icon' && $counter_icon <> ''){
					$output .= '<i class="fa '.$counter_icon.' fa-2x" style=" color: '.$counter_icon_color.'; "></i>';
				} else if($counter_icon_type == 'image' && $cs_counter_logo <> ''){
					$output .= '<img src="'.$cs_counter_logo.'" alt="">';
				}
				$output .= '<figcaption>';
				if($counter_numbers <> ''){
					$output .= '<a class="cs-numcount custom-counter-'.$rand_id.'" style=" color: '.$counter_number_color.'; ">'.$counter_numbers.'</a>';
				}
				if($counter_title <> ''){
					$output .= '<h3 style="color:'.$counter_text_color.'; !important">'.$counter_title.'</h3>';
				}

				$output .= '<p style=" color: '.$counter_text_color.' !important; ">'.do_shortcode($content).'</p>';
				if($counter_link_url <> '' || $counter_link_title <> ''){
					$counter_link_title = $counter_link_title ? $counter_link_title : 'Read More';
					$output .= '<a class="custom-btn" href="'.$counter_link_url.'" style="padding:11px 35px;">'.$counter_link_title.'</a>';
				}
				$output .= '</figcaption>';
				$output .= '</figure>';
				
			}
			$html = '<div '.$CustomId.' class="'.$column_class.' '.$counter_animation.'"><article  class="'.$counter_style_class.' '.$counter_class.' '.$border_class.'">'.$output.'</article></div>';
		return $html;
	}
	add_shortcode( 'cs_counter', 'cs_counter_item_shortcode' );
}

//======================================================================
// Services Shortcode Start
//======================================================================
if (!function_exists('cs_services_shortcode')) {
	function cs_services_shortcode( $atts, $content = null ) {
		global $service_type;
		$defaults = array('class'=>'cs-services-shortcode','cs_service_section_title'=>'','column_size' => '1/1',);
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		$section_title = '';
		if(isset($cs_service_section_title) && trim($cs_service_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2>'.$cs_service_section_title.'</h2></div>';
		}
		$output = '<div class="'.$column_class.'">'.$section_title.'<div class="cs-services '.$class.'"><div class="row">' . do_shortcode( $content ) . '</div></div></div>';
		return $output;
	}
	add_shortcode( 'cs_services_old', 'cs_services_shortcode' );
}

//======================================================================
// Services item
//======================================================================
if (!function_exists('cs_service_item')) {
	function cs_service_item( $atts, $content = null ) {
		global $service_type,$servicesNode;
		
		$defaults = array( 'service_title' => '', 'column_size'=>'1/1', 'service_type' => 'boxed','service_icon_color' => '','service_icon_bg_color' => '','cs_service_icon' => '','service_icon_postion' => 'left','service_icon_type' => 'icon','service_bg_image' => '','service_link_url' => '#','service_image_size' => '','service_text_color'=>'','service_class' => '','service_animation' => '', 'service_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		$serviceChild	 = '';
		if ( $servicesNode  == 'Firstchild' ){
			$serviceChild	= 'cs-first';
		}
		
		$servicesNode = '';
		$CustomId	= '';
		if ( isset( $service_class ) && $service_class ) {
			$CustomId	= 'id="'.$service_class.'"';
		}
		
		if ( trim($service_animation) !='' ) {
			$service_animation	= '';
		} else {
			$service_animation	= '';
		}
		
		$html = '';
		$border = '';
		$output = '';
		$figure_output = '';
		$title_seprator = '';
		if($service_type == 'boxed'){
			$title_seprator = ' class="sprater"';
		} else if($service_type == 'elite') {	
			$title_seprator = ' class="sprater"';
			$service_icon_postion = $service_icon_postion;
		}
		$text_color = '';
		$figcaption	= '';
		if($service_text_color <> ''){
			$text_color = 'color: '.$service_text_color.' !important;';
		}
		$figcaption .= '<figcaption>';	
			if($service_title <> ''){
				if($service_link_url <> ''){
					$figcaption .= '<a style="'.$text_color.'" href="'.$service_link_url.'"><h4 style="'.$text_color.'" '.$title_seprator.'>'.$service_title.'</h4></a>';	
				} else {
					$figcaption .= '<h4 '.$title_seprator.' style="'.$text_color.'">'.$service_title.'</h4>';	
				}
			}
			if($service_type == 'boxed'){
				$figcaption .= '<hr class="divider4">';
			}
			$figcaption .= '<p style="'.$text_color.'">'.do_shortcode($content).'</p>';	
				
		$figcaption .= '</figcaption>';	
		
		
		if($service_icon_type == 'icon' && $cs_service_icon <> ''){
			$icons_color = '';
			$icons_bg_color = '';
			if($service_icon_color <> ''){
				$icons_color = 'color: '.$service_icon_color.';';
			}
			if($service_icon_bg_color <> ''){
				$icons_bg_color = 'background-color: '.$service_icon_bg_color.' !important;';
			}
			if($service_type == 'classic'){	
				$figure_output .= '<figure>
								   <i class="fa '.$cs_service_icon.'" style="'.$icons_color.' '.$icons_bg_color.'"></i>
								   '.$figcaption.'
								   </figure>';
			} else if($service_type == 'elite'){	
				$figure_output .= '<figure><i class="fa '.$cs_service_icon.'" style="'.$icons_color.' '.$icons_bg_color.'"></i>'.$figcaption.'</figure>';
			} else if($service_type == 'rectangler'){	
					$figure_output .= '<figure>
											<i class="fa '.$cs_service_icon.'" style="'.$icons_color.' '.$icons_bg_color.'"></i>
									  '.$figcaption.'
									  </figure>';
			} else {
				$figure_output .= '<figure>
									<i class="fa '.$cs_service_icon.'" style="'.$icons_color.' '.$icons_bg_color.'"></i>
								  '.$figcaption.'
								   </figure>';
			}
		} else if($service_icon_type == 'image' &&  $service_bg_image <> ''){
			$figure_output .= '<figure>
								<img src="'.$service_bg_image.'" alt="">
								'.$figcaption.'
								</figure>';
		}
		$output .= '<div '.$CustomId.' class="services-sec '.$column_class.' ' . $service_class . ' '.$service_animation .'">';
		$output .= '<article class="cs-services '.$service_icon_postion.' '.$service_type.' '.$service_image_size.' '.$serviceChild.'">';
		$output .= $figure_output;
		
		$output .= '</article>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'cs_services', 'cs_service_item' );
}

//======================================================================
// Services Content
//======================================================================
if (!function_exists('cs_service_content')) {
	function cs_service_contentt( $atts, $content = null ) {
		$defaults = array( 'content' => '' );
		extract( shortcode_atts( $defaults, $atts ) );
		return '<p>'. $content .'</p>';
	}
	add_shortcode( 'content', 'cs_service_content' );
}

//======================================================================
// Adding Call to Action start
//======================================================================
if (!function_exists('cs_call_to_action_shortcode')) {
	function cs_call_to_action_shortcode($atts, $content = "") {
		
		$defaults = array('column_size'=>'1/1','cs_call_to_action_section_title'=>'','cs_content_type'=>'','cs_call_action_title'=>'','cs_call_action_contents'=>'','cs_contents_color'=>'', 'cs_call_action_icon'=>'','cs_icon_color'=>'#FFF','cs_call_to_action_icon_background_color'=>'','cs_call_to_action_button_text'=>'','cs_call_to_action_button_link'=>'#','cs_call_to_action_bg_img'=>'','animate_style'=>'slide','class'=>'cs-article-box','cs_call_to_action_class'=>'','cs_call_to_action_animation'=>'','cs_custom_animation_duration'=>'1');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		$CustomId	= '';
		if ( isset( $cs_call_to_action_class ) && $cs_call_to_action_class ) {
			$CustomId	= 'id="'.$cs_call_to_action_class.'"';
		}
		if ( trim($cs_call_to_action_animation) !='' ) {
			$cs_call_to_action_animation	= 'wow'.' '.$cs_call_to_action_animation;
		} else {
			$cs_call_to_action_animation	= '';
		}
		$section_title = '';
		if(isset($cs_call_to_action_section_title) && trim($cs_call_to_action_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2 class="'.$cs_call_to_action_animation .' ">'.$cs_call_to_action_section_title.'</h2></div>';
		}
		$image = '';
		if (trim($cs_call_to_action_bg_img)) {
			$image	= 'background-image:url('.$cs_call_to_action_bg_img.');';
		}
		$html	= '';
		if ($cs_content_type == 'normal'){
		$html	.= '<div class="actions ' . $cs_call_to_action_class . ' '.$cs_call_to_action_animation .'" style=" background-color:'.$cs_call_to_action_icon_background_color.'; background-image: url('.$cs_call_to_action_bg_img.');  animation-duration: '.$cs_custom_animation_duration.'s; '.$image.' " >';
		} else {
			$html	.= '<div class="actions actionsv3 ' . $cs_call_to_action_class . ' '.$cs_call_to_action_animation .' '.$column_class.'" style="background: url('.$cs_call_to_action_bg_img.');  background-color:'.$cs_call_to_action_icon_background_color.';  '.$image.' " >';
		}
		$action_icon	= $cs_call_action_icon ?  $cs_call_action_icon : '';
		$cs_contents_color	= $cs_contents_color ? $cs_contents_color :'#FFF';
		if ($cs_content_type == 'normal'){
				$html	.= '<div class="cell">';
				$html	.= '<i style=" color: '.$cs_icon_color.'; " class="fa '.$action_icon.'"></i>';
				$html	.= '</div>';
				$html	.= '<div class="cell csactn">';
				$html	.= '<div class="ac-text">';
				if (isset ($cs_call_action_title) && $cs_call_action_title !="") {
					$html	.= '<h3 style=" color: '.$cs_contents_color.' !important; ">' .$cs_call_action_title. '</h3>';
				}
				if (isset ($content) && $content !="") {
					$html	.= '<p style=" color: '.$cs_contents_color.';">'. do_shortcode($content). '</p>';
				}
				$html	.= '</div>';
				$html	.= '</div>';
				if ($cs_call_to_action_button_text <> '') {
					$html	.= '<div class="cell">';
						$html	.= '<a class="custom-btn transparent-bg" href="'.$cs_call_to_action_button_link.'" style=" color: '.$cs_contents_color.' !important;">'. $cs_call_to_action_button_text .'</a>';
					$html	.= '</div>';
				}
		} else if ($cs_content_type == 'with_center_icon') {
			if (isset ($cs_call_action_title) && $cs_call_action_title !="") {
				$html	.= '<div class="cell csactn-two">';
					$html	.= '<div class="ac-text">';
						$html	.= '<h3 style=" color: '.$cs_contents_color.' !important; ">' .$cs_call_action_title. '</h3>';
					$html	.= '</div>';
				$html	.= '</div>';
			}
			$html	.= '<div class="cell">';
			if ( $cs_call_to_action_button_link <> '') {
				$html	.= '<a href="'.$cs_call_to_action_button_link.'"><i style=" color: '.$cs_icon_color.' !important;" class="fa '.$action_icon.'"></i></a>';
			} else {
				$html	.= '<i style=" color: '.$cs_icon_color.' !important; " class="fa '.$action_icon.'"></i>';
			}
			$html	.= '</div>';
			if (isset ($content) && $content != "") {
				$html	.= '<div class="cell csactn-two">';
					$html	.= '<div class="ac-text">';
						$html	.= '<p style=" color: '.$cs_contents_color.' !important;">'. do_shortcode($content). '</p>';
					$html	.= '</div>';
				$html	.= '</div>';
			}
			if ($cs_call_to_action_button_text <> '') {
					$html	.= '<div class="cell">';
						$html	.= '<a class="custom-btn transparent-bg" href="'.$cs_call_to_action_button_link.'" style=" color: '.$cs_contents_color.' !important;">'. $cs_call_to_action_button_text .'</a>';
					$html	.= '</div>';
				}
		}
		$html	.= '</div>';
		return '<div '.$CustomId.' class="'.$column_class.'">'.$section_title.'' . $html . '</div>';
	}
	add_shortcode('call_to_action', 'cs_call_to_action_shortcode');
}
//======================================================================
// adding progressbars start
//======================================================================
if (!function_exists('cs_progressbars_shortcode')) {
	function cs_progressbars_shortcode($atts, $content = "") {
		global $cs_progressbars_style;
		$defaults = array('column_size'=>'1/1','cs_progressbars_style'=>'skills-sec','progressbars_class'=>'','progressbars_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		$CustomId	= '';
		if ( isset( $progressbars_class ) && $progressbars_class ) {
			$CustomId	= 'id="'.$progressbars_class.'"';
		}
		if ( trim($progressbars_animation) !='' ) {
			$progressbars_animation	= 'wow'.' '.$progressbars_animation;
		} else {
			$progressbars_animation	= '';
		}
		cs_skillbar_script();
		$output = '<script>
						jQuery(document).ready(function($){
							cs_skill_bar();
						});	
				</script>';
		$progressbars_style_class = '';
		$progressbars_bar_class_v2 = '';
		$progressbars_bar_class = 'skills-v3';
		$heading_size = 'h4';
		if(isset($cs_progressbars_style) && $cs_progressbars_style == 'strip-progressbar'){
			$progressbars_bar_class_v2 = 'skills-v2';
			$heading_size = 'h6';
			$progressbars_bar_class = '';
		}
		$output .= '<div '.$CustomId.' class="skills-sec '.$cs_progressbars_style.' '.$progressbars_bar_class_v2.' ' . $progressbars_class . ' '.$progressbars_animation .'">';
		$output .= do_shortcode($content);	
		$output .= '</div>';
		return $output;
	}
	add_shortcode('cs_progressbars', 'cs_progressbars_shortcode');
}

//======================================================================
// adding progressbars Item start
//======================================================================
if (!function_exists('cs_progressbar_item_shortcode')) {
	function cs_progressbar_item_shortcode($atts, $content = "") {
		global $cs_progressbars_style;
		$defaults = array('progressbars_title'=>'','progressbars_color'=>'#4d8b0c','progressbars_percentage'=>'50');
		extract( shortcode_atts( $defaults, $atts ) );
		$output = '';
		$output_title ='';
		$progressbars_style_class = '';
		$heading_size = 'h4';
		if(isset($cs_progressbars_style) && $cs_progressbars_style == 'strip-progressbar'){
			$progressbars_bar_class_v2 = 'skills-v2';
			$heading_size = 'h6';
			$progressbars_bar_class = '';
		} else {
			$progressbars_bar_class = 'skills-v3';
		}
		if(isset($progressbars_title) && $progressbars_title <>''){
			$output_title .= '<'.$heading_size.'>'.$progressbars_title.'</'.$heading_size.'>';
		}
		if(isset($progressbars_percentage) && $progressbars_percentage <>''){
			
			if(isset($cs_progressbars_style) && $cs_progressbars_style == 'strip-progressbar'){
				$output .= $output_title;
			}
			$output .= '<div class="skillbar '.$progressbars_bar_class.'" data-percent="'.$progressbars_percentage.'%">';
			if(isset($cs_progressbars_style) && $cs_progressbars_style == 'strip-progressbar'){
				$output .= '<div class="skillbar-bar" style="background-color: '.$progressbars_color.' !important;width:'.$progressbars_percentage.'%;"><small>'.$progressbars_percentage.'%</small></div>';
			} else {
				$output .= '<div class="skillbar-bar" style="background: '.$progressbars_color.' !important;width:'.$progressbars_percentage.'%;">'.$output_title.'<small>'.$progressbars_percentage.'%</small></div>';
			}
			$output .= '</div>';
		}
		return $output;
	}
	add_shortcode('progressbar_item', 'cs_progressbar_item_shortcode');
}

//======================================================================
// adding piecharts start
//======================================================================
if (!function_exists('cs_piecharts_shortcode')) {
	function cs_piecharts_shortcode($atts, $content = "") {
		$defaults = array('column_size'=>'1/1','piechart_section_title'=>'','piechart_info'=>'','piechart_text'=>'','piechart_dimensions'=>'250','piechart_width'=>'10','piechart_fontsize'=>'50','piechart_percent'=>'35','piechart_icon'=>'','piechart_icon_color'=>'','piechart_icon_size'=>'20','piechart_fgcolor'=>'#61a9dc','piechart_bg_color'=>'#eee','piechart_bg_image'=>'','piechart_class'=>'','piechart_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		cs_skillbar_script();
		$CustomId	= '';
		if ( isset( $piechart_class ) && $piechart_class ) {
			$CustomId	= 'id="'.$piechart_class.'"';
		}
		$rand_id = rand(98,56666);
		$column_class  = cs_custom_column_class($column_size);
		if ( trim($piechart_animation) !='' ) {
			$piechart_animation	= 'wow'.' '.$piechart_animation;
		} else {
			$piechart_animation	= '';
		}
		$output = '<script>
						jQuery(document).ready(function($){
							// Circul Progress Function
							$("#chart'.esc_js($rand_id).'").waypoint(function(direction) {
								$(this).circliful();
							}, {
								offset: "100%",
								triggerOnce: true
							});
						});	
		</script>';
		$section_title = '';
		if ($piechart_section_title && trim($piechart_section_title) !='') {
			$section_title	= '<div class="cs-section-title"><h2 class="' . $piechart_class . ' '.$piechart_animation .'">'.$piechart_section_title.'</h2></div>';
		}
		$piechart_data_elements = '';
		if(isset($piechart_info) && $piechart_info !=''){
			$piechart_data_elements .= ' data-info="'.$piechart_info.'"';
		}
		if(isset($piechart_dimensions) && $piechart_dimensions !=''){
			$piechart_data_elements .= ' data-dimension="'.$piechart_dimensions.'"';
		}
		if(isset($piechart_width) && $piechart_width !=''){
			$piechart_data_elements .= ' data-width="'.$piechart_width.'"';
		}
		if(isset($piechart_fontsize) && $piechart_fontsize !=''){
			$piechart_data_elements .= ' data-fontsize="'.$piechart_fontsize.'"';
		}
		if(isset($piechart_percent) && $piechart_percent !=''){
			$piechart_data_elements .= ' data-text="'.$piechart_percent.'%"';
			$piechart_data_elements .= ' data-percent="'.$piechart_percent.'"';
		}
		if(isset($piechart_icon) && $piechart_icon !=''){
			$piechart_data_elements .= ' data-icon="'.$piechart_icon.'"';
		}
		if(isset($piechart_icon_size) && $piechart_icon_size !=''){
			$piechart_data_elements .= ' data-iconsize="'.$piechart_icon_size.'"';
		}
		if(isset($piechart_icon_color) && $piechart_icon_color !=''){
			$piechart_data_elements .= ' data-iconcolor="'.$piechart_icon_color.'"';
		}
		if(isset($piechart_fgcolor) && $piechart_fgcolor !=''){
			$piechart_data_elements .= ' data-fgcolor="'.$piechart_fgcolor.'"';
		}
		if(isset($piechart_bg_color) && $piechart_bg_color !=''){
			$piechart_data_elements .= ' data-bgcolor="'.$piechart_bg_color.'"';
		}
		if(isset($piechart_bg_image) && $piechart_bg_image !=''){
			$piechart_data_elements .=  ' data-bgimage="'.$piechart_bg_image.'"';
		}
		$output .= '<div id="chart'.$rand_id.'" class="chartskills ' . $piechart_class . ' '.$piechart_animation .'" '.$piechart_data_elements.'></div>';
		return '<div '.$CustomId.' class="'.$column_class.'">'.$section_title.'<div class="piechart col-md-12">'.$output.'</div></div>';
	}
	add_shortcode('cs_piechart', 'cs_piecharts_shortcode');
}

//======================================================================
// adding Faq
//======================================================================
if (!function_exists('cs_faq_shortcode')) {
	function cs_faq_shortcode($atts, $content = "") {
		global $acc_counter;
		$acc_counter = rand(40, 9999999);
		$html	= '';
		$defaults = array('column_size'=>'1/1', 'class' => 'cs-faq','faq_class' => '','faq_animation' => '','cs_faq_section_title'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		
		$CustomId	= '';
		if ( isset( $faq_class ) && $faq_class ) {
			$CustomId	= 'id="'.$faq_class.'"';
		}
		
		if ( trim($faq_animation) !='' ) {
			$faq_animation	= 'wow'.' '.$faq_animation;
		} else {
			$faq_animation	= '';
		}
		
		$section_title = '';
		if(isset($cs_faq_section_title) && trim($cs_faq_section_title) <> ''){
			$section_title = '<div class="cs-section-title"><h2>'.$cs_faq_section_title.'</h2></div><div class="clear"></div>';
		}
		$styleClass	= 'accordion-v3';
		$html   .= '<div '.$CustomId.' class="'.$column_class.'">';
		$html	.= '<div class="panel-group '.$styleClass.' '.$faq_class.' '.$faq_animation.'" id="faq-' . $acc_counter . '">'.$section_title.do_shortcode($content).'</div>';
		$html	.= '</div>';
		return $html;
	}
	
	add_shortcode('cs_faq', 'cs_faq_shortcode');
}

//======================================================================
// Adding Faq item start
//======================================================================
if (!function_exists('cs_faq_item_shortcode')) {
	function cs_faq_item_shortcode($atts, $content = "") {
		global $acc_counter,$faq_animation;
		$defaults = array( 'faq_title' => 'Title','faq_active' => 'yes','cs_faq_icon' => '');
		extract( shortcode_atts( $defaults, $atts ) );
		$faq_count = 0;
		$faq_count = rand(40, 9999999);
		$html = "";
		$active_in = '';
		$active_class = '';
		$styleColapse = '';
		
		$styleColapse	= 'collapsed';
		
		if(isset($faq_active) && $faq_active == 'yes'){
			$styleColapse	= '';
			$active_in = 'in';
			$active_class = '';
		}
		
		$cs_faq_icon_class = '';
		if(isset($cs_faq_icon)){
			$cs_faq_icon_class = '<i class="fa '.$cs_faq_icon.'"></i>';
		}
		$html = '<div class="panel panel-default">
					<div class="panel-heading">
					  <p class="panel-title">
						<a data-toggle="collapse" data-parent="#faq-'.$acc_counter.'" href="#faq-'.$faq_count.'" class="'.$styleColapse.' '.$active_class.'">
						   '.$cs_faq_icon_class . $faq_title . '
						</a>
					  </p>
					</div>
					<div id="faq-'.$faq_count.'" class="panel-collapse collapse '.$active_in.' ">
					  <div class="panel-body">'.$content.'</div>
					</div>
				  </div>';
		return $html;
	}
	add_shortcode('faq_item', 'cs_faq_item_shortcode');
}

//======================================================================
// adding progressbars start
//======================================================================
if (!function_exists('cs_register_shortcode')) {
	function cs_register_shortcode($atts, $content = "") {
		global $wpdb, $cs_theme_options;
		$defaults = array('column_size'=>'1/1','register_title'=>'','register_text'=>'','register_role' => 'contributor','cs_register_class'=>'','cs_register_animation'=>'');
		extract( shortcode_atts( $defaults, $atts ) );
		$column_class  = cs_custom_column_class($column_size);
		
		$user_disable_text = __('User Registration is disabled','LMS');
		
		$output = '';
		$CustomId = '';
		
		$rand_id = rand(5,99999);
		
		if ( is_user_logged_in() ){
			$output .= 
			'<div class="registor-log"> 
				<a href="'.wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).'">
					<i class="fa fa-sign-out"></i>
				</a>
				<h2 class="warning">'.__("You must be logged out for registration.", "LMS").'</h2>
			</div>';
		}else{
		
		$role = $register_role;
		
		$output .='
		  <div class="col-md-6 register-page '.$cs_register_class.' '.$cs_register_animation.'">
            <section class="cs-signup" style="display:block;">
                <div class="login-from login-form-id-'.$rand_id.'">
                    <h2>'.__('Sign In','LMS').'</h2>
                    <form method="post" class="wp-user-form webkit" id="ControlForm_'.$rand_id.'">
                        <fieldset>
                            <p> 
                            <span class="input-icon"><i class="fa fa-user"></i>
                                <input type="text" name="user_login" size="20" id="user_login" tabindex="11" onfocus="if(this.value ==\'UserName\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'UserName\'; }" value="UserName" />
                            </span> 
                            </p>
                            <p> 
                            <span class="input-icon"><i class="fa fa-unlock-alt"></i>
                            <input type="password" name="user_pass" size="20" id="user_pass" tabindex="12" onfocus="if(this.value ==\'User Name\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'User Name\'; }" value="User Name" />
                            </span> 
                            </p>
                            <p> 
                            <input name="rememberme" value="forever" type="checkbox">
                            '.__('Remember me','LMS').'
                            <span class="status status-message" style="display:none"></span>
                            </p>
                            <p>
                            <input type="button" name="user-submit" class="user-submit backcolr"  value="'.__('Log in','LMS').'" onclick="javascript:cs_user_authentication(\''.admin_url("admin-ajax.php").'\',\''.$rand_id.'\')" />
                            <input type="hidden" name="redirect_to" value="'.get_permalink().'" />
                            <input type="hidden" name="user-cookie" value="1" />
                            <input type="hidden" value="ajax_login" name="action">
                            <input type="hidden" name="login" value="login" />
                            </p>
                        </fieldset>
                    </form>
                </div>
                <h6 class="forget-link">
                <a href="'.wp_lostpassword_url( ).'">
                '.__('Forget Password','LMS').'
                </a>
                </h6>';
				ob_start();
                if( class_exists( 'edulms' ) ){ $output .= do_action('login_form'); }
				$output .= ob_get_clean();
			$output .= '
            </section>
		   </div>';
		   
		   $isRegistrationOn = get_option('users_can_register');
		   if ( $isRegistrationOn ) {
           
           $output .='
		   <div class="col-md-6 register-page '.$cs_register_class.' '.$cs_register_animation.'">
				
				<div class="cs-user-register">
				  <h2>'.$register_title.'</h2>
				  <form method="post" class="wp-user-form" id="wp_signup_form_'.$rand_id.'" enctype="multipart/form-data">
				
					<ul class="upload-file">
					  <li>
					  <i class="fa fa-user"></i>
						<input type="text" name="user_login" size="20" tabindex="101" onfocus="if(this.value ==\'UserName\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'UserName\'; }" value="UserName" />
					  </li>
					  <li>
					  <i class="fa fa-envelope"></i>
						<input type="text" name="user_email" size="25" id="user_email" tabindex="101" onfocus="if(this.value ==\'Email\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'Email\'; }" value="Email" />
					  </li>
					</ul>
					<ul class="upload-file">
					  <li>';
					  ob_start();
					  $output .= do_action('register_form');
					  $output .= ob_get_clean();
						$output .= '
						<input type="button" name="user-submit" id="submitbtn" value="'.__('Sign Up','LMS').'" class="user-submit" tabindex="103" onclick="javascript:cs_registration_validation(\''.admin_url("admin-ajax.php").'\',\''.$rand_id.'\')" />
						<div id="result_'.$rand_id.'" class="status-message"><p class="status"></p></div>
						<input type="hidden" name="role" value="'.$role.'" />
						<input type="hidden" name="action" value="cs_registration_validation" />
					  </li>
					</ul>
				  </form>
				  <div class="register_content">'.do_shortcode($content.$register_text).'</div>
				</div>
			</div>';
		  } else {
          $output .='
			<div class="col-md-6 register-page">
				 <div class="cs-user-register">
					  <div class="cs-section-title">
						<h2>'.__('Register','LMS').'</h2>
					  </div>
					  <p>'.$user_disable_text.'</p>
				 </div>
		   </div>';
           
		  }
		}
			
		return $output;
	}
	add_shortcode('cs_register', 'cs_register_shortcode');
}

//======================================================================
// Adding Course Search Form Start
//======================================================================
if (!function_exists('cs_course_search_shortcode')) {
	function cs_course_search_shortcode($atts, $content = "") {
		$defaults = array( 'course_search_title'=>'',);
		extract( shortcode_atts( $defaults, $atts ) );

		$html  = '';
		$sort_by = '';
		
		$html.='<div class="cs-course-search col-md-12">
					<form  method="get" action="'.home_url().'"  role="search">
						<ul>
							<li><input name="s" placeholder="'.__('Enter Title, Keyword, Company','LMS').'"  value="" type="text" /> </li>';
						
		$categories = get_categories('taxonomy=course-category');
		$select_cat = "<li><div class='select-style-one'><select name='course_cat' id='course_cat' class='form-control'>";
		$select_cat.= "<option value='0'>".__('Select category','LMS')."</option>";
				foreach($categories as $category){
				  if($category->count > 0){
					  $select_cat.= "<option value='".$category->slug."'>".$category->name."</option>";
				  }
				}
		$select_cat.= "</select></div></li>";
		
		$sort_by .= '<li><div class="select-style-one">
							<select name="sort" id="sort" class="form-control">
							  <option value="date">'.__('Date Published','LMS').' </option>
							  <option value="alphabetical">'.__('Alphabetical','LMS').' </option>
							  <option value="members">'.__('Most Members','LMS').' </option>
							  <option value="rating">'.__('Highest Rated','LMS').'  </option>
						  </select></div></li>';
		
		$html.=$select_cat.$sort_by.'<li><input type="submit" class="cs-bg-color" value="'. __('Search', 'LMS').'" />
					<input type="hidden" name="post_type" value="courses" /></li>
						</ul>
					</form>
				</div>';
		return do_shortcode($html);
	}
	add_shortcode('cs_course_search', 'cs_course_search_shortcode');
}
/**
*@ Alow Spcial Char For Textfield 
*
**/
function cs_allow_special_char($input = ''){
	$output  = $input;
	return $output;
}