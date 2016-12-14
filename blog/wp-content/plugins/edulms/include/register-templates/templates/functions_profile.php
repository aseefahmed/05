<?php
function cs_user_profile_link($page_id = '', $profile_page = '', $uid = ''){
	if(!isset($page_id) or $page_id == ''){
		$user_link = home_url().'?author='.$uid;
	}
	else{
		$user_link = add_query_arg( array('action'=>$profile_page,'uid'=>$uid), get_permalink($page_id) );
	}
	
	return $user_link;
}

// Profile Menu
function cs_profile_menu($action = '',$uid = ''){
global $current_user,$cs_course_options, $wp_roles,$userdata,$cs_theme_options,$post;
$user_role = get_the_author_meta('roles',$uid );
$cs_course_options = $cs_course_options;
$cs_page_id = $cs_course_options['cs_dashboard'];
$cs_lms = get_option('cs_lms_plugin_activation');
?>
    <ul class="cs-user-menu">
        <li <?php if($action == 'dashboard'){ echo 'class="active"'; }?>>
            <a href="<?php echo cs_user_profile_link($cs_page_id, 'dashboard', $uid); ?>">
            <i class="fa fa-info-circle"></i><?php _e('About Me','EDULMS'); ?></a>
        </li>
       
		<?php
            if ( is_user_logged_in() and $current_user->ID == $uid) {
		?>
        	 <li <?php if($action  == 'my-courses'){ echo 'class="active"'; } ?>>
                <a href="<?php echo cs_user_profile_link($cs_page_id, 'my-courses', $uid); ?>">
                    <i class="fa fa-book"></i><?php _e('My Courses','EDULMS'); ?>
                </a>
            </li>
            <li <?php if(isset($_GET['action']) && $_GET['action'] == 'user-invoice'){ echo 'class="active"'; } ?>>
                <a href="<?php echo cs_user_profile_link($cs_page_id, 'user-invoices', $uid); ?>">
                    <i class="fa fa-calculator"></i><?php _e('Statement','EDULMS');?>
                </a>
            </li>
            <?php 
			
				$certificates_user_array = get_user_meta($uid, "user_certificates", true);
				if (isset( $certificates_user_array ) && $certificates_user_array !='' ) { 
				?>
                <li <?php if( ( isset($_GET['action']) && $_GET['action'] == 'certificates' ) || ( isset($_GET['cr']) && $_GET['cr'] != '' )){ echo 'class="active"'; } ?>>
                    <a href="<?php echo cs_user_profile_link($cs_page_id, 'certificates', $uid); ?>">
                        <i class="fa fa-certificate"></i><?php _e('Certificates','EDULMS');?>
                    </a>
                </li>
            <?php }?>
            <!--<li <?php if(isset($_GET['action']) && $_GET['action'] == 'add-course'){ echo 'class="active"'; } ?>>
                <a href="<?php echo cs_user_profile_link($cs_page_id, 'add-course', $uid); ?>">
                    <i class="fa fa-calculator"></i><?php _e('Statement','EDULMS');?>
                </a>
            </li>-->
             <?php
                 $args = array(
                        'post_type'					=> 'courses',
                        'post_status'				=> 'publish',
                        'meta_key'					=> 'var_cp_course_instructor',
                        'meta_value'				=> $uid,
                        'meta_compare'				=> "=",
                        'orderby'					=> 'meta_value',
                        'order'						=> 'ASC',
                );
                $custom_query = new WP_Query($args);
                $LMS_count=$custom_query->post_count;
                if($LMS_count > 0){
            ?>
                <li <?php if($action  == 'LMS'){ echo 'class="active"'; } ?>>
                    <a href="<?php echo cs_user_profile_link($cs_page_id, 'LMS', $uid); ?>">
                        <i class="fa fa-check-square-o"></i><?php _e('LMS','EDULMS'); ?>
                    </a>
                </li>
            <?php }
			
					do_action('cs_quiz_tabs',$action,$uid,$cs_page_id);
				
				
                    $reviews_args = array(
                        'post_type'					=> 'cs-reviews',
                        'post_status'				=> 'publish',
                        'meta_key'					=> 'cs_reviews_user',
                        'meta_value'				=> $uid,
                        'meta_compare'				=> "=",
                        'orderby'					=> 'meta_value',
                        'order'						=> 'ASC',
                    );
                    $reviews_query = new WP_Query($reviews_args);
                    $review_count =$reviews_query->post_count;
                    if($review_count > 0){
            	?>
            		<li <?php if($action  == 'user-reviews'){ echo 'class="active"'; } ?>>
                        <a href="<?php echo cs_user_profile_link($cs_page_id, 'user-reviews', $uid); ?>"><i class="fa fa-star-half-o"></i>
                        <?php _e('Reviews','EDULMS'); ?>
                        </a>
                    </li>
            	<?php } ?>   
                <li <?php if($action  == 'wishlist'){ echo 'class="active"'; } ?>>
                    <a href="<?php echo cs_user_profile_link($cs_page_id, 'wishlist', $uid); ?>">
                        <i class="fa fa-heart"></i><?php _e('Favorites','EDULMS'); ?>
                    </a>
                </li>
                <li <?php if($action  == 'profile-setting'){ echo 'class="active"'; } ?>>
                    <a href="<?php echo cs_user_profile_link($cs_page_id, 'profile-setting', $uid); ?>">
                        <i class="fa fa-cog"></i><?php _e('Profile Settings','EDULMS'); ?>
                    </a>
                </li>
                
        <?php   if ( is_user_logged_in() ) {
                        echo ' <li class="cs-user-logout" ><a  href="'.wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']).'">
                        <i class="fa fa-user"></i>'.__('Logout','EDULMS').'</a></li>';
                    }
		
		}?> 
             
     </ul>
<?php }

// User Avatar
if ( ! function_exists( 'cs_user_avatar' ) ) {	
 function cs_user_avatar(){
	if(is_user_logged_in() && isset($_FILES['user_avatar'])){
			$maxi_avatar_width = 300;
			$maxi_avatar_height = 300;
		  require_once ABSPATH.'wp-admin/includes/file.php';
		  $current_user_id = get_current_user_id();
		  $cs_allowed_image_types = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'png'          => 'image/png',
			'gif'          => 'image/gif',
		  );
		 $status = wp_handle_upload($_FILES['user_avatar'], array('mimes' => $cs_allowed_image_types));
		  if(empty($status['error'])){
			//$resized = image_resize($status['file'], $maxi_avatar_width, $maxi_avatar_height, $crop = true);
			$image = wp_get_image_editor($status['file']);
			  if ( ! is_wp_error( $image ) ) {
				  $image->resize( $maxi_avatar_width, $maxi_avatar_height, true );
				  $saved = $image->save();
			  }
			if(is_wp_error($image))
			  wp_die($image->get_error_message());
			$uploads = wp_upload_dir();
			$resized_url = $uploads['url'].'/'.basename($saved['path']);
			//print_r($resized_url);
			update_user_meta($current_user_id, 'user_avatar_display', $resized_url);
		  }else{
			wp_die(sprintf(__('Upload Error: %s','EDULMS'), $status['error']));
		 }
	}	
 }
}

// Rigistration Validation
function cs_registration_validation($atts =''){
	global $wpdb,$cs_theme_options;
 		
		$username = esc_sql($_POST['user_login']);  
		$json	= array();
		if(empty($username)) { 
			$json['type']		=  "error";
			$json['message']	=  "User name should not be empty.";
			echo json_encode( $json );
			exit();
		}
		
		$email = esc_sql($_POST['user_email']); 
		if(empty($email)) { 
			$json['type']		=  "error";
			$json['message']	=  "Email should not be empty.";
			echo json_encode( $json );
			exit();
		}

		if( filter_var($email, FILTER_VALIDATE_EMAIL) === false ) { 
			
			$json['type']		=  "error";
			$json['message']	=  "Please enter a valid email.";
			echo json_encode( $json );
			die;
		}
		 $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
 		 $role = esc_sql($_POST['role']);
		 $status = wp_create_user( $username,$random_password, $email );
			if ( is_wp_error($status) ) { 
				$json['type']		=  "error";
				$json['message']	=  "User already exists. Please try another one.";
				echo json_encode( $json );
				die;
			} else {
				wp_update_user(array('ID'=>$status,'role'=>$role,'user_status' => 1));
				$wpdb->query('UPDATE '.$wpdb->prefix.'users SET user_status = 1 WHERE ID = '.$status);
				update_user_meta( $status, 'show_admin_bar_front', false );
				cs_wp_new_user_notification($status, $random_password);
				
				$json['type']		=  "success";
				$json['message']	=  "Please check your email for login details.";
				echo json_encode( $json );
				die;
			}
	die();
}
add_action('wp_ajax_cs_registration_validation', 'cs_registration_validation');
add_action('wp_ajax_nopriv_cs_registration_validation', 'cs_registration_validation');
//==================================================================================
// header , footer
/* get user list*/
function cs_getuser_list(){
	global $current_user;
 
	$user_info = get_userdata( $current_user->ID);
	$username = $user_info->display_name;
    $user_url = $user_info->user_url;
    $user_email = $user_info->user_email;
	$usermeta =get_user_meta($current_user->ID);
	$usermeta= array_map( function( $a ){ return $a[0]; }, $usermeta );
	echo '<div class="cs-user-info"> 
			<img src="'.$usermeta['user_avatar'].'" width="100" height="100" />';
			echo esc_attr($username);
	 		echo esc_url($user_url);
	 		echo '<p>'.$usermeta['description'].'</p>';
	 		echo '<ul>
					<li>'.$usermeta['facebook'].'</li>
					<li>'.$usermeta['twitter'].'</li>
					<li>'.$usermeta['linkedin'].'</li>
					<li>'.$usermeta['pinterest'].'</li>
					<li>'.$usermeta['google_plus'].'</li>
					<li>'.$usermeta['instagram'].'</li>
			</ul>';
	 echo '</div>';
}

function update_user_info(){
	global $cs_theme_options,$cs_course_options;
	$cs_theme_options = get_option('cs_theme_options');
	if(isset($_GET['uid']) && $_GET['uid'] <> ''){
		$user_id = $uid = $_GET['uid'];
	} else {
		$user_id = $uid = cs_get_user_id();
	}
	$cs_course_options = $cs_course_options;
	$course_user_meta_array = get_option($user_id."_cs_course_data", true);
	if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
		$cs_lms = get_option('cs_lms_plugin_activation');	

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
										} else if( $disable == "3" ){
											
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
										}
									 }
								  }
							  }
						}
					}
	}
}



/**==================================================================**/
/**																	 **/
/**					Admin Profile Settings	Functions                **/ 
/**																	 **/															
/**==================================================================**/


//=====================================================================
// User Profile Custom Fields
//=====================================================================
if ( ! function_exists( 'cs_profile_fields' ) ) {
	
	function cs_profile_fields( $userid ) {
		$userfields['tagline']	= 'Tag Line';	
		$userfields['mobile'] 	= 'Mobile';	
		$userfields['landline'] = 'Landline';	
		$userfields['facebook'] = 'Facebook';	
		$userfields['twitter'] 	= 'Twitter';
		$userfields['linkedin'] = 'Linkedin';
		$userfields['pinterest']= 'Pinterest';
		$userfields['google_plus']= 'Google Plus';
		$userfields['instagram']= 'Instagram';
		$userfields['skype'] = 'Skype';	
		return $userfields;
	}
}

//=====================================================================
// User Profile Contact Options
//=====================================================================
if ( ! function_exists( 'cs_contact_options' ) ) {
	function cs_contact_options( $contactoptions ) {
		global $cs_theme_options;
		// Only show this option to users who can delete other users
		if ( !current_user_can( 'edit_users' ) )
			return;
			$display_img_url = '';
			$display =$display_image = 'block';
			$display_img_url =	get_the_author_meta( 'user_avatar_display', $contactoptions->ID );
			if($display_img_url == ''){
				$display_image = 'none';
			}		
		?>
	<table class="form-table">
	  <tbody>
		<tr>
		  <th> <label for="user_switch">
			  <?php _e('Gender', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td>
			<?php 
			//get dropdown saved value
			$selected = get_the_author_meta( 'gender', $contactoptions->ID ); 
			?>
			<select name="gender" id="gender">
			  <option value="male" 	<?php cs_selected($selected,'male'); ?> >Male</option>
			  <option value="female" 	<?php cs_selected($selected,'female'); ?>>Female</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <th> <label for="user_switch">
			  <?php _e('Display Photo', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td><input type="hidden" name="user_avatar_display" id="user_avatar_display"  value="<?php echo get_the_author_meta( 'user_avatar_display', $contactoptions->ID ); ?>" />
			<input type="button" name="user_avatar_display" class="uploadMedia"  value="Browse" /></td>
		</tr>
		<tr>
		  <td><div class="page-wrap" style="overflow:hidden;display:<?php echo esc_url($display_image); ?>" id="user_avatar_display_box" >
			  <div class="gal-active">
				<div class="dragareamain" style="padding-bottom:0px;">
				  <ul id="gal-sortable">
					<li class="ui-state-default" id="">
					  <div class="thumb-secs"> <img src="<?php echo get_the_author_meta( 'user_avatar_display', $contactoptions->ID ); ?>"  id="user_avatar_display_img"  />
						<div class="gal-edit-opts"> <a href=javascript:del_media("user_avatar_display") class="delete"></a> </div>
					  </div>
					</li>
				  </ul>
				</div>
			  </div>
			</div></td>
		</tr>
		<tr>
		  <th> <label for="user_switch">
			  <?php _e('Profile Public On/Off', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td><input type="checkbox" name="user_profile_public" id="user_switch" value="1" 
						<?php checked( 1, get_the_author_meta( 'user_profile_public', $contactoptions->ID ) ); ?> /></td>
		</tr>
		<tr>
		  <th> <label for="user_switch">
			  <?php _e('Contact Form On/Off', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td><input type="checkbox" name="user_contact_form" id="user_contact_form" value="1" 
						<?php checked( 1, get_the_author_meta( 'user_contact_form', $contactoptions->ID ) ); ?> /></td>
		</tr>
	  <tr>
		  <th> <label for="user_switch">
			  <?php _e('User Badges', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td>
				<?php
				$get_badges = get_the_author_meta( 'user_badges', $contactoptions->ID );
				
				if(!is_array($get_badges) && $get_badges == ''){
					$get_badges	= array();
				}
				
				$cs_badges_list	=  get_option('cs_badges');
				$badges = isset($cs_badges_list['badges_net_icons']) ? $cs_badges_list['badges_net_icons'] : '';	
				if(isset($badges) and $badges <> ''){
		
					$i = 0;
					foreach($badges as $badge){
						$badge_name = $cs_badges_list['badges_net_icons'][$i];
						$badge_short = $cs_badges_list['badges_net_icons_short_name'][$i];
						$badge_img = $cs_badges_list['badges_net_icons_paths'][$i];
						$badge_save = $badge_name.','.$badge_short.','.$badge_img;
						$get_s_badge = array();
						?>
						<span style="padding:5px; border:1px dotted #CCC; margin-right:5px; float:left; position:relative;">
						<img src="<?php echo esc_url($badge_img); ?>" title="<?php echo esc_attr($badge_name); ?>"  alt="<?php echo esc_attr($badge_name); ?>" width="40" />
						<input type="checkbox" style="position:absolute; top:0px;right: -2px;" name="user_badges[]" id="user_badges_<?php echo absint($i); ?>" value="<?php echo esc_attr($badge_name); ?>" <?php if(in_array($badge_name,$get_badges)) echo 'checked'; ?> />
						</span>
						
						<?php
						$i++;
					}
				}
				?>
			  </td>
	  </tr>
	  <tr>
		  <th> <label for="user_switch">
			  <?php _e('Certificates', 'EDULMS' ); ?>
			</label>
		  </th>
		  <td>
		  <?php
				
			$get_certificates = array();
			$get_certificates = get_user_meta($contactoptions->ID, "user_certificates", true);
			if ( isset ( $get_certificates ) && !empty( $get_certificates ) ) {
				foreach ($get_certificates as $certificate){
					 echo '<span style="padding:5px; border:1px dotted #CCC; margin-right:5px;">'.$certificate['cs_certificate_name'].'</span>';
				}
			}
		  ?>
		  <a href="javascript:;" style="margin-bottom:10px; box-shadow:none !important; outline:none" onclick="javascript:cs_toggle('cs-award')">Award Certificate</a>
		  <div class="cs-ward" id="cs-award" style="display:none; margin-top:15px;">
			  <select name="cs_certtificate">
				<option value="0">Select Certificate</option>
				<?php
					$args = array('posts_per_page' => "-1", 'post_type' => 'cs-certificates','order' => 'DESC', 'orderby' => 'ID', 'post_status' => 'publish');
					$query = new WP_Query( $args );
					$count_post = $query->post_count;
					if ( $query->have_posts() ) {  
						while ( $query->have_posts() ) { $query->the_post();
						?>
						<option value="<?php  echo get_the_ID();?>"><?php  echo the_title();;?></option>
						
					 <?php    }
					}?>
					
				 </select><br />	
			  <select name="cs_course">
				<option value="0"><?php _e('Select Course', 'EDULMS');?></option>
				<?php
					$args = array('posts_per_page' => "-1", 'post_type' => 'courses','order' => 'DESC', 'orderby' => 'ID', 'post_status' => 'publish');
					$query = new WP_Query( $args );
					$count_post = $query->post_count;
					if ( $query->have_posts() ) {  
						while ( $query->have_posts() ) { $query->the_post();
						?>
						<option value="<?php echo get_the_ID();?>"><?php echo the_title(); ?></option>
						
					 <?php    }
					}?>
					
				 </select><br />
			  <p>Add Course Taken Marks in %</p>
			  <input type="text" name="cs_taken_marks" placeholder="85%" /><br />
			  <p>Date Formate : YYYY-DD-MM H:I:S</p>
			  <input type="text" name="cs_completion_date" value="" placeholder="2014-01-25 00:00:00" /><br />
			  <p>Add Certificate Code Prefix (LMS-)</p>
			  <input type="text" name="cs_certificate_code" value="LMS-" /><br />
		   </div>
		  </td>
		</tr>
	  <tbody>
	</table>
	<?php 
	}

}


//=====================================================================
// User Profile Contact Options Save Function
//=====================================================================
if ( ! function_exists( 'cs_contact_options_save' ) ) {
	function cs_contact_options_save( $user_id ) {
		if ( !current_user_can( 'edit_users' ) )
		return;
		//update_user_meta( $user_id, 'country_list', $_POST['country_list'] );
		$user_profile_public=isset($_POST['user_profile_public']) and $_POST['user_profile_public'] <> '' ? $_POST['user_profile_public']: '';
		$user_contact_form=isset($_POST['user_contact_form']) and $_POST['user_contact_form'] <> '' ? $_POST['user_contact_form']: '';
		$user_switch=isset($_POST['user_switch']) and $_POST['user_switch'] <> '' ? $_POST['user_switch']: '';
		$user_badges	= '';
		if ( isset($_POST['cs_taken_marks']) && $_POST['cs_taken_marks'] <> '' ){ $cs_taken_marks = $_POST['cs_taken_marks']; } else { $cs_taken_marks = ''; }
		if ( isset($_POST['cs_certificate_code']) && $_POST['cs_certificate_code'] <> '' ){ $cs_certificate_code = $_POST['cs_certificate_code']; } else { $cs_certificate_code = ''; }
		if ( isset($_POST['cs_completion_date']) && $_POST['cs_completion_date'] <> '' ){ $cs_completion_date = $_POST['cs_completion_date']; } else { $cs_completion_date = ''; }
	
		if ( isset ( $_POST['cs_certtificate'] ) && isset ( $_POST['cs_course'] ) &&  $_POST['cs_certtificate'] && $_POST['cs_course'] ) {
			$certificates_user_meta_array = array();
			$certificates_user_meta_array = get_user_meta($user_id, "user_certificates", true);
			
			$course_id	= $_POST['cs_course'];
			$user_information = get_userdata((int)$user_id);
			
			$certificates_user_meta_array[$course_id] = array();
			$certificates_user_meta_array[$course_id]['cs_course_id'] 			= $course_id;
			$certificates_user_meta_array[$course_id]['cs_user_certificate'] 	= $_POST['cs_certtificate'];
			$certificates_user_meta_array[$course_id]['cs_username'] 		  	= $user_information->display_name;
			$certificates_user_meta_array[$course_id]['cs_certificate_name'] 	= get_the_title($_POST['cs_certtificate']);
			$certificates_user_meta_array[$course_id]['cs_course_name'] 		= get_the_title($course_id);
			$certificates_user_meta_array[$course_id]['cs_taken_marks'] 		= $cs_taken_marks;
			$certificates_user_meta_array[$course_id]['cs_completion_date'] 	= $cs_completion_date;
			$certificates_user_meta_array[$course_id]['cs_certificate_code'] 	= $cs_certificate_code;
			
			update_user_meta($user_id, 'user_certificates', $certificates_user_meta_array );
										
		}
		
		if( isset( $_POST['user_badges'] ) && $_POST['user_badges'] !='' ){							
			$user_badges	= $_POST['user_badges'];
		}
		
		
		update_user_meta( $user_id, 'gender', $_POST['gender'] );
		update_user_meta( $user_id, 'user_profile_public',$user_profile_public);
		update_user_meta( $user_id, 'user_contact_form',$user_contact_form );
		update_user_meta( $user_id, 'user_switch',$user_switch );
		update_user_meta( $user_id, 'user_avatar_display', $_POST['user_avatar_display'] );
		update_user_meta( $user_id, 'user_badges', $user_badges );
	
	}
}

// Redefine user notification function
if ( !function_exists('cs_wp_new_user_notification') ) {

	function cs_wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
		
		$user = get_userdata( $user_id );
		
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$message = sprintf(__('New user registration on your site %s:','EDULMS'), $blogname) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s','EDULMS'), $user->user_login) . "\r\n\r\n";
		$message .= sprintf(__('E-mail: %s','EDULMS'), $user->user_email) . "\r\n";
	
		mail(get_option('admin_email'), sprintf(__('[%s] New User Registration','EDULMS'), $blogname), $message);
	
		if ( empty($plaintext_pass) )
			return;
	
		$message = sprintf(__('Username: %s','EDULMS'), $user->user_login) . "\r\n";
		$message .= sprintf(__('Password: %s','EDULMS'), $plaintext_pass) . "\r\n";
		$message .= esc_url(home_url('/')). "\r\n";
	
		mail($user->user_email, sprintf(__('[%s] Your username and password','EDULMS'), $blogname), $message);
		
	}
}