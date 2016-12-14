<?php
/**
 * Event Count Down
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
global $cs_node, $cs_theme_options,$cs_xmlObject,$post_xml,$img_class,$image_url;
$dynamic_post_event_from_date = get_post_meta($post->ID, "cs_dynamic_event_from_date_time", true);
//date_default_timezone_set('UTC');
$year_event  = date("Y",$dynamic_post_event_from_date);
$month_event = date("m",$dynamic_post_event_from_date);
$date_event  = date("d", $dynamic_post_event_from_date);
	
	if ( function_exists( 'cs_countdown_enqueue_scripts' ) ) { cs_countdown_enqueue_scripts();}
	
	$dateBefore = date('m/d/Y', strtotime($dynamic_post_event_from_date.' '.$cs_xmlObject->dynamic_post_event_start_time));
	$dateAfter = date('m/d/Y g:i a');
	if($dynamic_post_event_from_date  > strtotime($dateAfter)){
		
		if ( isset($cs_xmlObject->dynamic_post_event_all_day) && $cs_xmlObject->dynamic_post_event_all_day != "on" ) {
				$hours = date("H",$dynamic_post_event_from_date);
				$mints = date("i", $dynamic_post_event_from_date);
			} else {
		$hours = '00';
		$mints = '00';
		
	}
	?> 
	<!-- Countdown -->
	 <script>
		jQuery(document).ready(function($) {
			cs_event_countdown('<?php echo esc_js($year_event);?>','<?php echo esc_js($month_event);?>','<?php echo esc_js($date_event);?>',<?php echo esc_js($hours);?>,<?php echo esc_js($mints);?>,'<?php echo esc_js(absint($post->ID));?>');
		});
	</script>
	
	<div class="evcountdown">
		<div id="defaultCountdown<?php echo absint($post->ID);?>"></div>
	</div>
	<!-- Countdown -->
 <?php }?>