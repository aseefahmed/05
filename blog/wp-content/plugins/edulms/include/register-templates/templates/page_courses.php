<?php 
global $cs_theme_options,$cs_course_options;
$cs_theme_options = $cs_theme_options;
if(isset($_GET['uid']) && $_GET['uid'] <> ''){
	$user_id = $uid = $_GET['uid'];
} else {
	$user_id = $uid = cs_get_user_id();
}
$cs_course_options = $cs_course_options;
$course_user_meta_array = get_option($user_id."_cs_course_data", true);
if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
	$cs_lms = get_option('cs_lms_plugin_activation');	
	?>
    <div class="my-courses">
    	<div class="cs-table">
            <ul class="top-sec">
                <li><?php _e('Course Name','EDULMS'); ?></li>
                <li><?php _e('Course instructor','EDULMS'); ?></li>
                <li><?php _e('Status','EDULMS'); ?></li>
                <li></li>
            </ul>
        </div>
        <?php
        $counter_courses = 855;
        foreach($course_user_meta_array as $course_id=>$course_values){
            $transaction_id = $course_values['transaction_id'];
            if($course_id){
                $course_title = $course_values['course_title'];
                $course_instructor = '';
                if(isset($course_values['course_instructor']) && $course_values['course_instructor'] <> '')
                    $course_instructor = $course_values['course_instructor'];
					$user_course_data = get_option($course_id."_cs_user_course_data", true);
					if(is_array($user_course_data) && count($user_course_data)>0){
						$user_course_data_array = array_reverse($user_course_data) ;
						$key = array_search($uid, $user_course_data_array);
						$course_info = $user_course_data[$key];
						$course_key = '';
						foreach ( $user_course_data_array as $key=>$members ){
							if($transaction_id == $members['transaction_id']){
								$course_key = $key;
								break;
							}
						}
						$course_info = array();
							if($course_key || $course_key == 0){
								$course_price = '';
								if(isset($user_course_data_array[$course_key]) && is_array($user_course_data_array[$course_key])){
									$course_info = $user_course_data_array[$course_key];
									$course_id = $course_info['course_id'];
									if(isset($course_info['course_instructor']))
										$course_instructor = $course_info['course_instructor'];
									$transaction_id = $course_info['transaction_id'];
									$register_date = $course_info['register_date'];
									$expiry_date = $course_info['expiry_date'];
									if(isset($course_info['course_price']) && $course_info['course_price'] <> ''){
										if(isset($cs_course_options['cs_currency_symbol']))
											$product_currency = $cs_course_options['cs_currency_symbol'];
										 else 
											$product_currency = '$';
										$course_price = $product_currency.$course_info['course_price'];
									} else {
										$cs_course = get_post_meta($course_id, "cs_course", true);
										if ( $cs_course <> "" ) {
											$cs_xmlObject = new SimpleXMLElement($cs_course);
											$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
											$product_status = get_post_status( (int)$var_cp_course_product );
											if($product_status=='publish'){
												$course_price = cs_get_product_price((int)$var_cp_course_product);
											}
										}
									}
									$result = $course_info['result'];
									$remarks = $course_info['remarks'];
									$disable = $course_info['disable'];
									$post_status = get_post_status( $course_id );
									if($disable == "1"){
										$course_status = 'Pending';
									} else if($disable == "2"){
										$course_status = 'Disable';
									} else if($disable == "4"){
										$status	= cs_courses_quiz_status($course_id,$user_id,$transaction_id);
										if ( $status == 'Pass' ) {
											$course_status = 'Completed';
										} else if ( $status == 'Pending' ) {
											$course_status = 'Pending';
										} else if ( $status == 'Fail' ) {
											$course_status = 'Expired';
										} else if ( $status == 'Fail' ) {
											$course_status = 'Expired';
										} else {
											$course_status = 'Completed';
										}
										$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
										if(!is_array($user_course_complete_backup_array) 
											|| !isset($user_course_complete_backup_array[$course_id]) 
											|| !is_array($user_course_complete_backup_array[$course_id]) 
											|| !array_key_exists((int)$course_id, $user_course_complete_backup_array) 
											|| count($user_course_complete_backup_array[$course_id])<2){
													
											cs_user_course_complete_auto_backup_after_expiration($transaction_id,$course_id,  $user_id);
										}
									} else if($disable == "3"){
										if ( function_exists( 'cs_user_course_complete_auto_backup_after_expiration' ) ) {
											$user_course_complete_backup_array = get_user_meta($user_id,'cs-user-courses-backup', true);
											if(!is_array($user_course_complete_backup_array) 
												|| !isset($user_course_complete_backup_array[$course_id]) 
												|| !is_array($user_course_complete_backup_array[$course_id]) 
												|| !array_key_exists((int)$course_id, $user_course_complete_backup_array) 
												|| count($user_course_complete_backup_array[$course_id])<2){
														
												cs_user_course_complete_auto_backup_after_expiration($transaction_id,$course_id,  $user_id);
											}
											
											$status	= cs_courses_quiz_status($course_id,$user_id,$transaction_id);
											if ( $status == 'Pass' ) {
												$course_status = 'Completed';
											} else if ( $status == 'Pending' ) {
												$course_status = 'Pending';
											} else if ( $status == 'Fail' ) {
												$course_status = 'Expired';
											} else {
												$course_status = 'Completed';
											}
										}
										
									} else {
										$course_status = 'In Progress..';
										$current_dte = date('Y-m-d H:i:s');
										$dDiff = strtotime($expiry_date)-strtotime($current_dte);
										if(isset($dDiff) && $dDiff > 0){
											$course_status = 'In Progress..';
										} else {
											if ( function_exists( 'cs_user_course_complete_auto_backup_after_expiration' ) ) { 
												cs_user_course_complete_auto_backup_after_expiration($transaction_id,$course_id,  $user_id);
											}
											$course_status ='Completed';
										}
									}
									if(isset($course_status) && ($course_status == 'In Progress..' || $course_status == 'Completed' || $course_status == 'Expired' || $course_status == 'Pending' )){
									$counter_courses++;
									?>
									<script>
									  jQuery(document).ready(function($){
										  $('#toggle-<?php echo esc_js($counter_courses);?>').click(function() {
											  $('#toggle-div-<?php echo esc_js($counter_courses);?>').slideToggle('slow', function() {});
										  });
									  });
									</script>
                                    <div class="cs-table">	
										<ul class="bottom-sec">
											<li>
												<?php 
												if($post_status == 'publish')
													 echo '<a href="'.get_permalink($course_id).'" target="_blank">'.get_the_title($course_id).'</a>';
												else 
													echo esc_attr($course_title);
												?>
												<time datetime="<?php echo date_i18n(get_option( 'Y-m-d' ),strtotime($register_date));?>"><?php _e('Date', 'EDULMS');?>: <?php echo date_i18n(get_option( 'date_format' ),strtotime($register_date));?>/<?php echo date_i18n(get_option( 'date_format' ),strtotime($expiry_date));?></time>
											</li>
											<li><?php echo esc_attr($course_instructor);?></li>
											<li><?php echo esc_attr($course_status);?></li>
                                            <li>
                                            <?php
											do_action('cs_course_quiz_assignment_restults', $transaction_id, $user_id, $course_id, $counter_courses, $course_status );
											?>
                                            </li>
										</ul>
                                    </div>
										<?php 
										// Quiz Listing Start
										?>
										<div class="toggle-sec">
											<div id="toggle-div-<?php echo absint($counter_courses);?>" class="toggle-div">
											  </div>
										   </div>
										 <?php
									// Quiz Listing End
									}
								 }
							}
						}
                    }
                }
            ?>
    </div>
<?php 
} else {
	_e('There are no records avaialble','EDULMS');
}