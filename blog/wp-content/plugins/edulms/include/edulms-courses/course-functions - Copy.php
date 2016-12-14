<?php
if ( ! function_exists( 'cs_get_post_img_src' ) ) {
	function cs_get_post_img_src($post_id, $width, $height) {
	
		if(has_post_thumbnail()){
	
			$image_id = get_post_thumbnail_id($post_id);
	
			$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
	
			if ($image_url[1] == $width and $image_url[2] == $height) {
	
				return $image_url[0];
	
			} else {
	
				$image_url = wp_get_attachment_image_src($image_id, "full", true);
	
				return $image_url[0];
	
			}
	
		}
	
	}
}

if ( ! function_exists( 'cs_get_user_id' ) ) {
	function cs_get_user_id() {
		global $current_user;
		//wp_get_current_user();
		$current_user = wp_get_current_user();
		if ( 0 == $current_user->ID ) {
			return false;
		} else {
			return $current_user->ID;
		}
		//return $current_user->ID;
	}
}
if ( function_exists( 'wp_get_current_user' ) ) { wp_get_current_user(); }
// Course Short Description Area
if ( ! function_exists( 'cs_course_shortdescription_area' ) ) { 
	function cs_course_shortdescription_area(){
		global $post, $cs_xmlObject;
		$bgcolor_style	= '';
		if ( empty($cs_xmlObject->course_subheader_bg_color) ) $course_subheader_bg_color = ""; else $course_subheader_bg_color = $cs_xmlObject->course_subheader_bg_color;
		
		if($course_subheader_bg_color <> ''){
			$bgcolor_style = 'style="background-color: '.$course_subheader_bg_color.';"';	
		}
		$width = 370;
		$height = 278;
		$image_url = cs_get_post_img_src($post->ID, $width, $height);
		if($image_url == ''){
			$course_detail_layout = 'col-md-12';
		} else {
			$course_detail_layout = 'col-md-9';
		}
		?>
			<figure class="detailpost col-md-12">
			<!-- Course Detail -->
			<div class="course-detail" <?php echo balanceTags($bgcolor_style, false);?>>
				<div class="row">
					<div class="<?php echo esc_attr($course_detail_layout);?>">
						<?php 
							$before_cat = "<span>";
							$categories_list = get_the_term_list ( get_the_id(), 'course-category', $before_cat, '</span> &nbsp;<span> ', '</span>' );
							
							if ( $categories_list ){
								//printf( __( '%1$s', 'EDULMS'),$categories_list );
							}
							
							$terms = get_the_terms( $post->ID, 'course-category' );
							if( is_array($terms) ){
								$term = current($terms);
								echo '<span><a href="'.get_term_link($term->slug, 'course-category').'">'.$term->name.'</a></span>';
							}
						?>
					    <h2><?php the_title(); ?></h2>
						<?php if(isset($cs_xmlObject->course_short_description))echo '<p>'.$cs_xmlObject->course_short_description.'</p>';?>
						 <?php 
						 	
							if(isset($cs_xmlObject->post_tags_show) &&  $cs_xmlObject->post_tags_show == 'on'){
								if ( empty($cs_xmlObject->post_tags_show_text) ) $post_tags_show_text = __('Tags', 'EDULMS'); else $post_tags_show_text = $cs_xmlObject->post_tags_show_text;
								/* translators: used between list items, there is a space after the comma */
								$before_tag = "<div class='content_tag'><h6>".$post_tags_show_text."</h6>";
							    // $before_cat = "<i class='fa fa-tags'></i>";
								$tags_list = get_the_term_list ( get_the_id(), 'course-tag', $before_tag, ' ', '</div>' );
								if ( $tags_list ){
									printf( __( '%1$s', 'EDULMS'),$tags_list );
								} // End if categories 
							}
							?>
					</div>
					
					<?php if($image_url <> ''){?><div class="col-md-3"><a class="crsimg"><img src="<?php echo esc_url($image_url);?>" alt=""></a></div><?php }?>
					
				</div>
			</div>
			<!-- Course Detail -->
			</figure>
		<?php 
	}
}

// Course Detail Short Description
if ( ! function_exists( 'cs_course_shortdescription_single' ) ) { 
	function cs_course_shortdescription_single($cs_xmlObject_course){
		
		//var_dump($cs_xmlObject_course); die;
		if ( empty($cs_xmlObject_course->course_subheader_bg_color) ) $course_subheader_bg_color = ""; else $course_subheader_bg_color = $cs_xmlObject_course->course_subheader_bg_color;
		
		$course_id	= (int)$cs_xmlObject_course->course_id;
		if($course_subheader_bg_color <> ''){
			$bgcolor_style = 'style="background-color: '.$course_subheader_bg_color.';"';	
		}
		$width = 200;
		$height = 150;
		
		$image_id = get_post_thumbnail_id($course_id);

		$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);

		if ($image_url[1] == $width and $image_url[2] == $height) {
			$image_url =  $image_url[0];
		} else {
			$image_url = wp_get_attachment_image_src($image_id, "full", true);
			$image_url = $image_url[0];
		}
		
		if($image_url == ''){
			$course_detail_layout = 'col-md-12';
		} else {
			$course_detail_layout = 'col-md-9';
		}
		?>
			<figure class="detailpost">
			<!-- Course Detail -->
			<div class="course-detail" <?php echo balanceTags($bgcolor_style, false);?>>
				<div class="row">
					<div class="<?php echo esc_attr($course_detail_layout);?>">
						<?php 
							$before_cat = "<span>";
							$categories_list = get_the_term_list ($course_id, 'course-category', $before_cat, '</span> &nbsp;<span> ', '</span>' );
							
							if ( $categories_list ){
								//printf( __( '%1$s', 'EDULMS'),$categories_list );
							}
							
							$terms = get_the_terms( $course_id, 'course-category' );
							$term = current($terms);
							echo '<span><a href="'.get_term_link($term->slug, 'course-category').'">'.$term->name.'</a></span>';

						?>
					   <h2><?php echo get_the_title( $course_id );?></h2>
						<?php if(isset($cs_xmlObject_course->course_short_description))echo '<p>'.$cs_xmlObject_course->course_short_description.'</p>';?>
						<?php 
						 	
							if(isset($cs_xmlObject_course->post_tags_show) &&  $cs_xmlObject_course->post_tags_show == 'on'){
								if ( empty($cs_xmlObject_course->post_tags_show_text) ) $post_tags_show_text = __('Tags', 'EDULMS'); else $post_tags_show_text = $cs_xmlObject->post_tags_show_text;
								/* translators: used between list items, there is a space after the comma */
								$before_tag = "<div class='content_tag'><h6>".$post_tags_show_text."</h6>";
							    // $before_cat = "<i class='fa fa-tags'></i>";
								$tags_list = get_the_term_list ( $course_id, 'course-tag', $before_tag, ' ', '</div>' );
								if ( $tags_list ){
									printf( __( '%1$s', 'EDULMS'),$tags_list );
								} // End if categories
							}
						?>
					</div>
					
					<?php if($image_url <> ''){?><div class="col-md-3"><a class="crsimg"><img src="<?php echo esc_url($image_url);?>" alt=""></a></div><?php } ?>
					
				</div>
			</div>
			<!-- Course Detail -->
			</figure>
		<?php 
	}
}

//Course enroll Redirect function
if (!function_exists('redirect_to_checkout')) {
	function redirect_to_checkout() {
		global $woocommerce;
		$course_id = $_REQUEST['course_url'];
		$course_url = '?course_url='.$course_id;
		$checkout_url = $woocommerce->cart->get_checkout_url().$course_url;
		return $checkout_url;
	}
}
//add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
if (!function_exists('cs_check_user_exists_by_id')) {
	function cs_check_user_exists_by_id($user_ID){
		global $wpdb;
		$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = '$user_ID'"));
		return $count;
	}
}

//Course order process function
if (!function_exists('lms_custom_process_order')) {
	function lms_custom_process_order($order_id, $order_processed='') {
		global $woocommerce,$current_user;
		$var_cp_course_group = '';
		$user_id = $current_user->ID;
		$order = new WC_Order( $order_id );
		$payment_status = $order->status;
		$isBadgeAssign	= true;
		$transaction_status = 1;
		
		if ('processing' == $order->status || 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) {
			$transaction_status = 1;
		} else {
			$transaction_status = 0;
		}

		$payment_method_ = $order->payment_method_title;
		$items = $order->get_items();
		$user_course_data = array();
		$ocunter= 0;
		if ( count( $items ) > 0 ) {
			foreach($items as $item){
				if(isset($item['product_id']) && $item['product_id'] <> ''){
					$course_id = get_post_meta((int)$item['product_id'], 'cs_select_course', true );
					$user_information = get_userdata((int)$user_id);
					$user_display_name = $user_information->user_login;
					$user_email = $user_information->user_email;
					$course_instructor = '';
					$var_cp_course_instructor = get_post_meta( (int)$course_id, 'var_cp_course_instructor', true);
					if(isset($var_cp_course_instructor) && $var_cp_course_instructor <> ''){
						$user_info = get_userdata((int)$var_cp_course_instructor);
						$course_instructor = $user_info->user_login;
					}
					
					$cs_course = get_post_meta($course_id, "cs_course", true);
					$course_duration = 365;
					if ( $cs_course <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($cs_course);
						$course_duration = (int)$cs_xmlObject->course_duration;
						
						if($course_duration == ''){
							$course_duration = 365;	
						}
					}
					$randd_id = 11;
					$transaction_id = cs_generate_random_string($randd_id);
					$course_user_array = array();
					$course_user_array['transaction_id'] = $transaction_id;
					$course_user_array['payment_method_title'] = $payment_method_;
					$course_user_array['user_id'] = $user_id;
					$course_user_array['course_user_email'] = $user_email;
					$course_user_array['user_display_name'] = $user_display_name;
					$course_user_array['order_id'] = $order_id;
					$course_user_array['course_id'] = $course_id;
					$course_user_array['course_instructor'] = $course_instructor;
					$course_user_array['course_price'] = $item['line_total'];
					$course_user_array['course_title'] = get_the_title($course_id);
					$course_user_array['register_date'] = date('Y-m-d H:i:s');
					$course_user_array['expiry_date'] = date('Y-m-d H:i:s', strtotime("+$course_duration days"));
					$course_user_array['result'] = '';
					$course_user_array['remarks'] = '';
					$course_user_array['payment_status'] = $payment_status;
					$course_user_array['disable'] 		 = $transaction_status;
					
					//==update badge
					if ( $cs_course <> "" ) {
						$cs_course_badge_assign = (string)$cs_xmlObject->cs_course_badge_assign;
						if ( isset ( $cs_course_badge_assign ) && $cs_course_badge_assign !='' && $cs_course_badge_assign == 'purchase' ) {
							$cs_course_badge = (string)$cs_xmlObject->cs_course_badge;
							if ( isset ( $cs_course_badge ) && $cs_course_badge !='') {
								$badges_user_meta_array = array();
								$badges_user_meta_array = get_user_meta($user_id, "user_badges", true);
								if ( !in_array( $cs_course_badge , $badges_user_meta_array ) ) {
									$badges_user_meta_array[]   = $cs_course_badge;
									update_user_meta($user_id, 'user_badges', $badges_user_meta_array );
								}
							}
						}
					}
					//==update badge
					
					//==update Certificate
					if ( $cs_course <> "" ) {
						$cs_course_certificate_assign = (string)$cs_xmlObject->cs_course_certificate_assign;
						if ( isset ( $cs_course_certificate_assign ) && $cs_course_certificate_assign !='' && $cs_course_certificate_assign == 'purchase' ) {
							$cs_course_certificate = (string)$cs_xmlObject->cs_course_certificate;
							if ( isset ( $cs_course_certificate ) && $cs_course_certificate !='') {
								$certificates_user_meta_array = array();
								$certificates_user_meta_array = get_user_meta($user_id, "user_certificates", true);
								if(is_int($certificates_user_meta_array))
									$certificates_user_meta_array = array();
								if(!is_array($certificates_user_meta_array) || empty($certificates_user_meta_array) || $certificates_user_meta_array == '')
									$certificates_user_meta_array = array();
								$cs_meta_certificate = get_post_meta($cs_course_certificate, "cs_meta_certificate", true);
								$cs_certificate_code = '';
								if ( $cs_meta_certificate <> "" ) {
									$cr_xmlObject = new SimpleXMLElement($cs_meta_certificate);
									$cs_certificate_code = (string)$cr_xmlObject->var_cp_certificate_code;
								}
								
								$code = cs_generate_random_string('10');
								$cs_certificate_code = 'LMS-'.$code.'';
								$certificates_user_meta_array[$transaction_id] = array();
								$certificates_user_meta_array[$transaction_id]['cs_course_id'] 			= $course_id;
								$certificates_user_meta_array[$transaction_id]['cs_user_certificate'] 	= $cs_course_certificate;
								$certificates_user_meta_array[$transaction_id]['cs_username'] 		  	= $user_information->display_name;
								$certificates_user_meta_array[$transaction_id]['cs_certificate_name'] 	= get_the_title($cs_course_certificate);
								$certificates_user_meta_array[$transaction_id]['cs_course_name'] 		= get_the_title($course_id);
								$certificates_user_meta_array[$transaction_id]['cs_taken_marks'] 		= '';
								$certificates_user_meta_array[$transaction_id]['cs_completion_date'] 	= $course_user_array['expiry_date'];
								$certificates_user_meta_array[$transaction_id]['cs_certificate_code'] 	= $cs_certificate_code;
								
								update_user_meta($user_id, 'user_certificates', $certificates_user_meta_array );
								
							}
						}
					}
					
					//==update Certificate
					$user_course_data = array();
					$user_course_data = get_option($course_id."_cs_user_course_data", true);
					if(is_int($user_course_data))
						$user_course_data = array();
					if(!is_array($user_course_data) || empty($user_course_data) || $user_course_data == '')
						$user_course_data = array();
					
					
					$user_course_data[] = $course_user_array;
					$courdata_return = update_post_meta($course_id, "cs_user_course_data", $user_course_data);
					update_option($course_id."_cs_user_course_data", $user_course_data);
					// Course Data Updatd
					$course_user_meta_array = array();
					$course_user_meta_array = get_option($user_id."_cs_course_data", true);
					if(is_int($course_user_meta_array))
						$course_user_meta_array = array();
					if(!is_array($course_user_meta_array) || empty($course_user_meta_array) || $course_user_meta_array == '')
						$course_user_meta_array = array();

					$course_user_meta_array[$course_id] = array();
					$course_user_meta_array[$course_id]['transaction_id'] = $transaction_id;
					$course_user_meta_array[$course_id]['course_id'] = $course_id;
					$course_user_meta_array[$course_id]['course_instructor'] = $course_instructor;
					$course_user_meta_array[$course_id]['course_title'] = get_the_title($course_id);
					update_option($user_id."_cs_course_data", $course_user_meta_array);
					
					$cs_user_ids_option = array();
					$cs_course_ids_option = array();
					$cs_course_instructor_ids_option = array();
					$cs_course_register_option = array();
					$cs_course_register_option = get_option("cs_course_register_option", true);
					if(is_int($course_user_meta_array))
						$course_user_meta_array = array();
					if(isset($cs_course_register_option) && !is_array($cs_course_register_option)  || $cs_course_register_option == ''){
						$cs_course_register_option = array();	
					}
					if(isset($cs_course_register_option['cs_user_ids_option']))
						$cs_user_ids_option = @$cs_course_register_option['cs_user_ids_option'];
					if(isset($cs_course_register_option['cs_course_ids_option']))
						$cs_course_ids_option = @$cs_course_register_option['cs_course_ids_option'];
					if(isset($cs_course_register_option['cs_course_instructor_ids_option']))
						$cs_course_instructor_ids_option = @$cs_course_register_option['cs_course_instructor_ids_option'];
					
					$cs_user_ids_option[(int)$user_id] = $user_display_name;
					$cs_course_ids_option[(int)$post_id] = get_the_title($course_id);
					$user_instructors_ids_data[(int)$var_cp_course_instructor] = $course_instructor;
						
					$cs_course_register_option['cs_user_ids_option'] = $cs_user_ids_option;
					$cs_course_register_option['cs_course_ids_option'] = $cs_course_ids_option;
					$cs_course_register_option['cs_course_instructor_ids_option'] = $user_instructors_ids_data;
					update_option("cs_course_register_option", $cs_course_register_option);	
					
				}
			}
		}
	 }
	 
	 add_action( 'woocommerce_checkout_order_processed', 'lms_custom_process_order', 10, 1 );
	//add_action('woocommerce_thankyou', 'lms_custom_process_order', 10, 1); 
}

//Course custom fields function
if (!function_exists('cs_add_custom_fields')) {
	function cs_add_custom_fields() {
		global $woocommerce, $post;
		$product_id = $post->ID;
		echo '<div class="options_group">';
		$products_args= array('post_type' => 'product','showposts'=>-1);
		$productarray = array();
		$products_data=get_posts($products_args);
		foreach($products_data as $products_data){
			if(isset($products_data->ID) && $products_data->ID <> '' && $product_id <> $products_data->ID){
				$course_id = get_post_meta((int)$products_data->ID, 'cs_select_course', true );
				$productarray[] = $course_id;
			}
		}
		$cscourse= array('post_type' => 'courses','showposts'=>-1);
		$customarray = array();
		$courses=get_posts($cscourse);
		foreach($courses as $course){
			if(!in_array($course->ID, $productarray)){
				$customarray[$course->ID] = $course->post_title;
			}
		}
		woocommerce_wp_select(
			array(
				'id' => 'cs_select_course',
				'label' => __( 'Select Course','EDULMS'),
				'options' => $customarray
			)
		);
		echo '</div>';
		?>
        <?php
	}
}
add_action( 'woocommerce_product_options_general_product_data', 'cs_add_custom_fields' );

// Save Fields
if (!function_exists('cs_add_custom_fields_save')) {
	function cs_add_custom_fields_save(){
		global $post,$_POST;
		$woocommerce_select = $_POST['cs_select_course'];
		if( !empty( $woocommerce_select ) )
			update_post_meta( $post->ID, 'cs_select_course', esc_attr( $woocommerce_select ) );
	}
}
add_action( 'woocommerce_process_product_meta', 'cs_add_custom_fields_save' );




/**
 * @Add Course Members To List
 *
 *
 */
if ( ! function_exists( 'cs_add_course_members_to_list' ) ) {
	function cs_add_course_members_to_list(){
		global $counter_members, $course_user_id, $course_user_email, $transaction_id, $order_id, $course_instructor, $course_title, $course_title, $course_price, $course_id, $user_display_name, $register_date, $expiry_date, $result, $payment_method_title, $payment_status, $remarks, $disable;
		foreach ($_POST as $keys=>$values) {
			$$keys = $values;
		}
		$cs_user_data = get_userdata($course_user_id);
		if(isset($course_user_email) && !empty($course_user_email) ){
			$course_user_email = $course_user_email;
		} else {
			$course_user_email = $cs_user_data->user_email;
		}
		if(!isset($user_display_name) || empty($user_display_name) ){
			if(isset($cs_user_data->user_login))
				$user_display_name = $cs_user_data->user_login;
		}
	?>
    <tr class="parentdelete <?php echo absint($course_user_id);?>" id="edit_track<?php echo absint($counter_members);?>">
      <td id="subject-title<?php echo absint($counter_members)?>" style="width:40%;"><?php if(isset($user_display_name))echo esc_attr($user_display_name);?> </td>
      <td id="order_id<?php echo absint($counter_members);?>" style="width:40%;"><a href="<?php echo get_edit_post_link($order_id);?>" target="_blank"><?php if(isset($order_id))echo absint($order_id); ?></a> </td>
      <td id="purchaseid-title<?php echo absint($counter_members);?>" style="width:40%;"><?php if(isset($transaction_id) && $transaction_id <> ''){echo esc_attr($transaction_id);}?> </td>
      <td class="centr" style="width:20%;"><a href="javascript:_createpop('edit_track_form<?php echo absint($counter_members)?>','filter')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
      <td style="width:0"><div  id="edit_track_form<?php echo absint($counter_members);?>" style="display: none;" class="table-form-elem">
          <div class="cs-heading-area">
            <h5 style="text-align: left;"><i class="fa fa-plus-circle"></i>Course Member Settings</h5>
            <span onclick="javascript:removeoverlay('edit_track_form<?php echo esc_js($counter_members);?>','append')" class="cs-btnclose"> <i class="fa fa-times"></i></span>
            <div class="clear"></div>
            <style>
			.xdsoft_datetimepicker{
				z-index:999999 !important;
			}
			</style>
          </div>
          <input type="hidden" id="course_id<?php echo absint($counter_members);?>" name="course_id_array[]" value="<?php echo absint($course_id);?>" />
          <input type="hidden" id="user_display_name<?php echo absint($counter_members)?>" name="user_display_name_array[]" value="<?php echo esc_attr($user_display_name);?>" />
          <input type="hidden" id="course_user_email<?php echo absint($counter_members)?>" name="course_user_email_array[]" value="<?php echo esc_attr($course_user_email);?>" />
          <input type="hidden" id="user_display_id<?php echo absint($counter_members)?>" name="user_display_id_array[]" value="<?php if(isset($course_user_id))echo absint($course_user_id);?>" />
          <input type="hidden" id="course_title<?php echo absint($counter_members)?>" name="course_title_array[]" value="<?php  if(isset($course_title))echo esc_attr($course_title);?>" />
          <input type="hidden" id="course_instructor<?php echo absint($counter_members)?>" name="course_instructor_array[]" value="<?php  if(isset($course_instructor))echo esc_attr($course_instructor);?>" />
          <input type="hidden" id="transaction_id<?php echo absint($counter_members)?>" name="transaction_id_array[]" value="<?php if(isset($transaction_id) && $transaction_id <> ''){echo esc_attr($transaction_id);}?>" />
           <script>
				jQuery(document).ready(function () { 
					jQuery(document).on('click', '#register_date<?php echo absint($counter_members)?>', function () {
						jQuery(this).datetimepicker({
							format:'Y-m-d H:i',
							formatTime:'H:i',
							step:30,  
						});
					});
					
					jQuery(document).on('click', '#expiry_date<?php echo absint($counter_members);?>', function () {
						jQuery(this).datetimepicker({
							format:'Y-m-d H:i',
							formatTime:'H:i',
							step:30,
							onShow:function( ct ){
								this.setOptions({
									minDate:jQuery('#register_date<?php echo absint($counter_members)?>').val()?jQuery('#register_date<?php echo absint($counter_members);?>').val():false
								})
							},
						});
					});
				});
			</script>
		  
          <ul class="form-elements">
            <li class="to-label">
              <label>USER </label>
            </li>
            <li class="to-field select-style">
              <?php
				$blogusers = get_users('orderby=nicename');
				echo '<select name="course_user_id_array[]" id="course_user_id'.$counter_members.'">
						<option value="">'.__('None','EDULMS').'</option>';
						  foreach ($blogusers as $user) {
						if($user->ID=="$course_user_id"){
								$selected =' selected="selected"';
							}else{ 
								$selected = '';
							}
						echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
						}
				echo '</select>';
              ?>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Order Id','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="order_id_array[]" value="<?php echo htmlspecialchars($order_id)?>" id="register_date<?php echo absint($counter_members)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Course Price','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="course_price_array[]" value="<?php echo htmlspecialchars($course_price)?>" id="course_price<?php echo absint($counter_members)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Registeration Date','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="register_date_array[]" value="<?php echo date('Y-m-d H:i', strtotime($register_date)); ?>" id="register_date<?php echo absint($counter_members)?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Expiry Date','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="expiry_date_array[]" value="<?php echo date('Y-m-d H:i', strtotime($expiry_date));?>" id="expiry_date<?php echo absint($counter_members)?>" />
            </li>
          </ul>
           <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Transaction Id','EDULMS');?></label>
            </li>
            <li class="to-field">
            
              <input type="text" name="transaction_idDDDD_array[]" value="<?php echo esc_attr($transaction_id)?>" disabled="disabled" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Result','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="result_array[]" value="<?php echo htmlspecialchars($result)?>" id="result<?php echo absint($counter_members);?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Remarks','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="remarks_array[]" value="<?php echo htmlspecialchars($remarks)?>" id="remarks<?php echo absint($counter_members);?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Payment Method Title','EDULMS');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="payment_method_title_array[]" value="<?php echo htmlspecialchars($payment_method_title)?>" id="payment_method_title<?php echo absint($counter_members);?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Payment Status','EDULMS');?></label>
            </li>
            <li class="to-field select-style">
             <select name="payment_status_array[]" id="payment_status<?php echo absint($counter_members);?>">
                <option value="completed" <?php if($payment_status=='completed'){echo 'selected="selected"';}?>><?php _e('Completed','EDULMS');?></option>
                <option value="pending" <?php if($payment_status=='pending'){echo 'selected="selected"';}?>><?php _e('Pending','EDULMS');?></option>
                <option value="processing" <?php if($payment_status=='processing'){echo 'selected="selected"';}?>><?php _e('Processing','EDULMS');?></option>
                <option value="on-hold" <?php if($payment_status=='on-hold'){echo 'selected="selected"';}?>><?php _e('On-Hold','EDULMS');?></option>
                <option value="cancelled" <?php if($payment_status=='cancelled'){echo 'selected="selected"';}?>><?php _e('Cancelled','EDULMS');?></option>
                <option value="refunded" <?php if($payment_status=='refunded'){echo 'selected="selected"';}?>><?php _e('Refunded','EDULMS');?></option>
                <option value="failed" <?php if($payment_status=='failed'){echo 'selected="selected"';}?>><?php _e('Failed','EDULMS');?></option>
            </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('User Course Status','EDULMS');?></label>
            </li>
            <li class="to-field select-style">
              <select name="disable_array[]" id="disable<?php echo absint($counter_members)?>">
                <option value="0" <?php if($disable=='0'){echo 'selected="selected"';}?>>Approved</option>
                <option value="1" <?php if($disable=='1'){echo 'selected="selected"';}?>>Pending</option>
                <option value="2" <?php if($disable=='2'){echo 'selected="selected"';}?>>Disable</option>
                <option value="3" <?php if($disable=='3'){echo 'selected="selected"';}?>>Completed</option>
                <option value="4" <?php if($disable=='4'){echo 'selected="selected"';}?>>Expired</option>
              </select>
            </li>
          </ul>
          <ul class="form-elements noborder">
            <li class="to-label">
              <label></label>
            </li>
            <li class="to-field">
              <input type="button" value="Update Member" onclick="update_title(<?php echo absint($counter_members)?>); removeoverlay('edit_track_form<?php echo absint($counter_members)?>','append')" />
            </li>
          </ul>
        </div></td>
    </tr>
<?php
	//	}
		$transaction_id = '';
		$course_user_id = $course_user_email = $transaction_id = $order_id = $course_id = $course_instructor = $course_title = $course_price = $user_display_name = $register_date = $expiry_date = $result = $payment_method_title = $payment_status =  $remarks = $disable = '';
		if ( isset($action) ) die();
	}
	add_action('wp_ajax_cs_add_course_members_to_list', 'cs_add_course_members_to_list');
}
// Course Members	
if (!function_exists('cs_get_course_members')) {	
	function cs_get_course_members($course_id=''){
		global $post;
		$user_course_data_array = array();
		//$user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
		$user_course_data_array = get_option($course_id."_cs_user_course_data", true);
		$course_user_ids = array();
		
		if ( isset($user_course_data_array) && is_array($user_course_data_array) && count($user_course_data_array)>0) {
			foreach ( $user_course_data_array as $members ){
				 $course_user_ids[] = $members['user_id'];
			}
		}
		$user_course_data = array_unique($course_user_ids);
		if(isset($user_course_data) && count($user_course_data)>0 ){
		?>
			<li><span><i class="fa fa-users"></i><?php echo count($user_course_data);?> <?php echo  _e('Students','EDULMS');?></span></li>
		<?php }
		
	}
}
// Course Price
if (!function_exists('cs_get_course_price')) {
	function cs_get_course_price($var_cp_course_product){
		global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb,$course_id,$add_to_cart_url,$add_to_cart_product_url;
		if(class_exists('Woocommerce') && trim($var_cp_course_product) !='') {?>
		<li>
			<?php
			$course_id = $post->ID;
			$args = array('post_type' => 'product','p' => "$var_cp_course_product", 'post_status' => 'publish');
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			global $product;
			$add_to_cart_url = esc_url($product->add_to_cart_url());
			$course_url = '&amp;course_url='.$course_id;
			$add_to_cart_product_url	= esc_url($product->add_to_cart_url().$course_url);
			?>
			  <div class="cs-carprice">
					<?php echo ''.$product->get_price_html(); ?>
			  </div>
			   <?php
				endwhile; 
				wp_reset_query();
				?>
		</li>
		<?php }
		
	}
}
// Course Lessons
if (!function_exists('cs_get_course_lessons')) {
	function cs_get_course_lessons($cs_xmlObject){
		global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
		$curriculum_lessions = 0;
		if(count($cs_xmlObject->course_curriculms )>0){
			foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
				if((string)$curriculm->listing_type == 'curriculum')	
					$curriculum_lessions++;
			}
		}
		if(!empty($curriculum_lessions)){
		?>
			<li><span class="cs-lessons"><i class="fa fa-file-text-o"></i><?php echo absint($curriculum_lessions);?><?php _e('Lessons','EDULMS'); ?></span></li>
		<?php
		}	
	}
}
// Course Instructor Name
if (!function_exists('cs_get_course_instructor')) {
	function cs_get_course_instructor( $cs_xmlObject ){
		global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
		$var_cp_course_instructor = $cs_xmlObject->var_cp_course_instructor;
		if($var_cp_course_instructor <> '') {?>
		  <li>
			<i class="fa fa-user"></i>
			<a><?php echo get_the_author_meta( 'display_name',(int)$var_cp_course_instructor); ?></a>
		  </li>   
	<?php }
	}
}
// Course #
if (!function_exists('cs_get_course_id')) {
	function cs_get_course_id( $var_cp_course_id ){
		global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
		if($var_cp_course_id<>'') { ?>
				<li>
					<i class="fa fa-keyboard-o"></i>
					<a><?php echo absint($var_cp_course_id);?></a>
				</li>
		<?php } 
	}
}
// Course Reviews
if (!function_exists('cs_get_course_reviews')) {
	function cs_get_course_reviews($reviews_count,$var_cp_rating){
		 global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
		 
		 if(isset($reviews_count) && $reviews_count <> ''){?>
			<li>
				<div class="cs-rating"><span class="rating-box" style="width:<?php echo absint($var_cp_rating)*20;?>%"></span></div>
				<span class="cs-rating-desc">( <?php echo absint($reviews_count);?> <?php _e('Reviews','EDULMS');?> )</span>
			</li>
		<?php }
	}
}
// Course Filters
if (!function_exists('cs_get_course_filters')) {
	function cs_get_course_filters(array $filter_category,$sort = '',$post_count=''){
  		 global $cs_node,$post,$cs_theme_options,$cs_counter_node,$wpdb;
		 $nav_count = rand(40, 9999999);
		 if ($cs_node->var_pb_course_filterable == 'yes') {?>
				<!--Sorting Navigation-->
				<?php if($cs_node->var_pb_course_view != 'list' ) ?>
                <div class="col-md-12">
                <aside class="filters">
                <h2><i class="fa fa-filter"></i> <?php _e('Filter','EDULMS'); ?><small><a class="courses-filter-reset" href="<?php the_permalink();?>">( <i class="fa fa-refresh"></i> <?php _e('All Topics','EDULMS'); ?> )</a></small></h2>
                <form action="#" method="get" name="filterable">
                	<?php if($post_count<>''){ 
                     	echo '<span>'.__('Found ','EDULMS').$post_count.'</span>';
                      } ?>
                    <h5><?php  _e('Filter by','EDULMS');?></h5>
                    
 					<select name="sort" id="sort" class="form-control">
						<option value="" <?php if($sort=='') { echo 'selected';} ?>><?php echo _e('Date Published','EDULMS');?> </option>
						<option value="alphabetical" <?php if($sort=='alphabetical') { echo 'selected';} ?>><?php echo _e('Alphabetical','EDULMS');?> </option>
						<option value="members" <?php if($sort=='members') { echo 'selected';} ?>><?php echo _e('Most Members','EDULMS');?> </option>
						<option value="rating" <?php if($sort=='rating') { echo 'selected';} ?>><?php echo _e('Highest Rated','EDULMS');?>  </option>
					</select>
                    <h5><?php  _e('Categories','EDULMS');?></h5>
 						<?php
						$qrystr = '';
						if( isset($cs_node->var_pb_course_cat) && ($cs_node->var_pb_course_cat <> "" && $cs_node->var_pb_course_cat <> "0") && isset( $row_cat->term_id )){	
							$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'course-category', 'hide_empty' => 0) );
						?>
						<a href="?<?php echo ''.$qrystr."&amp;filter_category=".$row_cat->slug; ?>" 
						class="<?php if(($cs_node->var_pb_course_cat == $filter_category)){ echo 'bgcolr';}?>">
							<?php   _e('All Categories','EDULMS'); ?>
						</a>
					 <?php
					}else{
						$categories = get_categories( array('taxonomy' => 'course-category', 'hide_empty' => 0) );
					}
					$i=0;
					foreach ($categories as $category) {
  					?>
					<div class="checkbox">
                      	<label>
                        	<input name="filter_category[<?php echo absint($i); ?>]" type="checkbox" value="<?php echo esc_attr($category->slug); ?>" 
							<?php if(in_array($category->slug, $filter_category)){ echo 'checked'; } ?> > 
							<?php echo esc_attr($category->cat_name); ?>
                        </label>
                    </div>
 					<?php $i++;}?>
 				 	<input type="submit" name="submit" value="Filter Results">
                   <!-- <input type="reset" name="reset" value="reset">-->
 				</form>
                 </aside>
               </div>
				<?php  //if($cs_node->var_pb_course_view != 'list') ?>
		  <!--Sorting Navigation End-->
		 <?php } 
								
	}
}

// User check to access courses
if (!function_exists('cs_check_user_right')) {
	function cs_check_user_right($course_id = ''){
		global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		$dt = get_the_date();
		$date1  = date('Y-m-d H:i:s');
		$user_id = cs_get_user_id();
		$user_right = 0;
		if ( is_user_logged_in() ) {
			//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
			$user_course_data = get_option($course_id."_cs_user_course_data", true);
			//print_r($user_course_data);
			if ( isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0) {
			$user_course_data_array = array_reverse($user_course_data) ;
			foreach ( $user_course_data_array as $members ){
				if($user_id == $members['user_id']){
					$course_user_id = $members['user_id'];
					$disable = $members['disable'];
					if(isset($disable) && $disable <> 0){
						$user_right = 0;
					} else {
						$expiry_date = $members['expiry_date'];
						if($expiry_date <> ''){
							$date2  = date('Y-m-d H:i:s', strtotime($expiry_date));
							$dDiff = strtotime($date2)-strtotime($date1);
							//if(isset($dDiff) && $dDiff >0 && $disable == 3 ){
							if(isset($dDiff) && $dDiff >0){
								$user_right = 1;
								break;
							} else {
								$user_right = 0;
							}	
						}
					}
				}
			}
  		 }
		}
		return $user_right;
	}
}

// User check to access courses
if (!function_exists('cs_check_user_course_subscription')) {
	function cs_check_user_course_subscription($course_id = ''){
		global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		
		$dt = get_the_date();
		$date1  = date('Y-m-d H:i:s');
		$user_id = cs_get_user_id();
		$user_right = 0;
		$disable 	= 2;
		$subscription_status = array();
		
		if ( is_user_logged_in() ) {
			//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
			$user_course_data = get_option($course_id."_cs_user_course_data", true);
			if ( isset($user_course_data) && is_array($user_course_data) && count($user_course_data)>0) {
			$user_course_data_array = array_reverse($user_course_data) ;
			foreach ( $user_course_data_array as $members ){
				if($user_id == $members['user_id']){
					$course_user_id = $members['user_id'];
					$disable = $members['disable'];
					if(isset($disable) && $disable == 4){
						$user_right = 0;
					} else {
						$expiry_date = $members['expiry_date'];
						if($expiry_date <> ''){
							$date2  = date('Y-m-d H:i:s', strtotime($expiry_date));
							$dDiff  = strtotime($date2)-strtotime($date1);
							//if(isset($dDiff) && $dDiff >0 && $disable == 3 ){
							if(isset($dDiff) && $dDiff >0 ){
								$user_right = 1;
								break;
							} else {
								$user_right = 0;
							}	
						}
					}
				}
			}
  		  }
		}
		$subscription_status['user_right'] = $user_right;
		$subscription_status['user_status'] = $disable;
		return $subscription_status;
	}
}

// Course Rating Count
if (!function_exists('cs_course_rating_count')) {
	function cs_course_rating_count($course_id=''){
		global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		 $reviews_args = array(
			'posts_per_page'			=> "-1",
			'post_type'					=> 'cs-reviews',
			'post_status'				=> 'publish',
			'meta_key'					=> 'cs_reviews_course',
			'meta_value'				=> $course_id,
			'meta_compare'				=> "=",
			'orderby'					=> 'meta_value',
			'order'						=> 'ASC',
		);
		$reviews_query = new WP_Query($reviews_args);
		$var_cp_rating = 0;
		if ( $reviews_query->have_posts() <> "" ) {
			while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
				$var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
			endwhile;
			wp_reset_postdata();
			return $var_cp_rating;
		}
	}
}

// Course Reviews Count
if (!function_exists('cs_course_reviews_count')) {
	function cs_course_reviews_count($course_id=''){
		global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		$recent_reviews_args = array(
			'posts_per_page'			=> "-1",
			'post_type'					=> 'cs-reviews',
			'post_status'				=> 'publish',
			'meta_key'					=> 'cs_reviews_course',
			'meta_value'				=> $course_id,
			'meta_compare'				=> "=",
			'orderby'					=> 'ID',
			'order'						=> 'DESC',
		);
		$recent_reviews_query = new WP_Query($recent_reviews_args);
		return $reviews_count = $recent_reviews_query->post_count;
	}
}

// Course Curriclulms Count
if (!function_exists('cs_course_curriculms_count')) {
		function cs_course_curriculms_count($course_id=''){
			global $post;
			if(!isset($course_id) && empty($course_id)){
				$course_id = $post->ID;
			}
			 $cs_course = get_post_meta($course_id, "cs_course", true);
			 if ( $cs_course <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_course);
			 }
			$curriculum_lessions = 0;
			if(count($cs_xmlObject->course_curriculms )>0){
				foreach ( $cs_xmlObject->course_curriculms as $curriculm ){
					if((string)$curriculm->listing_type == 'curriculum')	
						$curriculum_lessions++;
				}
				return $curriculum_lessions;
			}
		}
}

// Course Instructor Widget
if (!function_exists('cs_course_instructor_widget')) {
	function cs_course_instructor_widget($course_id='',$cs_user_data){
		global $post,$cs_course_options;
		$description_limit = '150';
		$uid	= $cs_user_data->ID;
		$user_info = get_userdata( $uid ); 
		$cs_course_options = get_option('cs_course_options');
		$cs_page_id = $cs_course_options['cs_dashboard'];
		 
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		?>
		<div class="col-md-12 widget widget_instrector">
            <div class="widget-section-title">
              <h2><?php _e('Taught By','EDULMS');?></h2>
            </div>
            <figure><a><?php echo get_avatar($cs_user_data->user_email, apply_filters('PixFill_author_bio_avatar_size', 60));?></a></figure>
            <div class="left-sp">
                <h5><a href="<?php echo cs_user_profile_link($cs_page_id, 'dashboard', $uid); ?>"><?php echo get_the_author_meta( 'display_name', $uid );?></a></h5>
                <span>
				 <?php 
				     if ( isset( $user_info ) && $user_info !='' ) {
                    		echo ucwords( implode(',', $user_info->roles) );
                     } ?>
				</span>
                <?php
					
                    $facebook = $twitter = $linkedin = $google_plus ='';
                    $facebook = get_the_author_meta('facebook',$uid ); 
                    $twitter  = get_the_author_meta('twitter',$uid );
                    $linkedin = get_the_author_meta('linkedin',$uid );
                    $google_plus = get_the_author_meta('google_plus',$uid );
					
                    echo '<p class="social-media">';
                    
					if(isset($twitter) and $twitter <> ''){
                        echo '<a href="'.$twitter.'" data-original-title="Twitter" style="color:#3ba3f3;">
						<i class="fa fa-twitter"></i></a>';
                    }
                    if(isset($google_plus) and $google_plus <> ''){
                        echo '<a href="'.$google_plus.'"  data-original-title="Google Plus" style="color:#f33b3b;">
                        <i class="fa fa-google-plus"></i></a>';
                    }
					if(isset($facebook) and $facebook <> ''){
                        echo '<a href="'.$facebook.'" data-original-title="Facebook" style="color:#2d5faa;"><i class="fa fa-facebook"></i></a>';
                    }
					if(isset($linkedin) and $linkedin <> ''){
                        echo '<a href="'.$linkedin.'" data-original-title="linkedin" style="color:#a82626;">
                        <i class="fa fa-linkedin"></i></a>';
                    }
					
					echo '</p>';
				?>
            </div>
              <p><?php echo substr(get_the_author_meta( 'description', $uid ),0, $description_limit); if(strlen(get_the_author_meta( 'description', $uid ))>$description_limit){echo '...';}?></p>
              
            <div class="by-user">
             <?php _e('More From ','EDULMS');?>
             	<a href="<?php echo cs_user_profile_link($cs_page_id, 'dashboard', $uid); ?>"><?php echo get_the_author_meta( 'display_name', $uid );?></a>
            </div>
            <?php 
                $args_cat  = array('author' => $cs_user_data->ID);
                $current_post	=  get_the_ID();
                $post_type = array('courses');
                $args = array(
                    'posts_per_page'			=> "2",
                    'post_type'					=> $post_type,
                    'post_status'				=> 'publish',
                    'post__not_in'				=> array($current_post),
                    'meta_key'					=> 'var_cp_course_instructor',
                    'meta_value'				=> (int)$cs_user_data->ID,
                    'meta_compare'				=> "=",
                    'orderby'					=> 'ID',
                    'order'						=> 'DESC',
                );
                $custom_query = new WP_Query($args);
                 if ( $custom_query->have_posts() ): 
                    echo '<ul>';
                        while ( $custom_query->have_posts() ) : $custom_query->the_post();
							$reviews_count = cs_course_reviews_count($post->ID);
							$width = 150;
							$height = 150;
							$image_url = cs_get_post_img_src($post->ID, $width, $height);
                        ?>
                        <li>
                         	<?php if ( isset($image_url) && $image_url !='' ){?><figure><img src="<?php echo esc_url($image_url);?>" alt="" /></figure><?php }?>
                            <h5><a id="post-<?php echo absint($post->ID);?>"  href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                            
							<?php if ( $reviews_count > 0 ) {?>
                            <div class="cs-rating"><span class="rating-box" style="width:<?php echo absint($reviews_count)*20;?>%"></span></div>
                             <span class="cs-rating-desc">( <?php echo absint($reviews_count);?> )</span>
							<?php }?>
                            
                        </li>
                         <?php  
                            endwhile;
                        echo '</ul>';
                    endif;
                    wp_reset_postdata();
                ?>
        </div>        
		<?php
	}
}

// Course Product CD INFO
if (!function_exists('cs_course_cd_widget')) {
	function cs_course_cd_widget($course_id='',$var_cp_course_cds_product){
		 global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		if(class_exists('Woocommerce')) {
			if($var_cp_course_cds_product != ''){
					$args = array('post_type' => 'product','p' => "$var_cp_course_cds_product", 'post_status' => 'publish');
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
					$width = 272;
					$height = 202;
					$image_url = cs_get_post_img_src($post->ID, $width, $height);
					global $product;
					$add_to_cart_url = esc_url($product->add_to_cart_url());
					?>
						<div class="col-md-12 widget widget_complete_review">
							<div class="widget-section-title">
							  <h2><?php echo _e('Download Videos','EDULMS');?></h2>
							</div>
							<section class="review-info fullwidth">
								<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
								<a href="<?php the_permalink();?>" class="custom-btn circle center-align"><?php echo _e('Buy Now','EDULMS');?></a>
							</section>
					 </div>
				 <?php
				endwhile; 
				wp_reset_postdata();
			}
		}
	}
}

// Course Recent Reviews
if (!function_exists('cs_course_recent_reviews_widget')) {
	function cs_course_recent_reviews_widget($course_id=''){
		 global $post,$cs_theme_options;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		// Course Recent Views
		 $recent_reviews_args = array(
			'posts_per_page'			=> "1",
			'post_type'					=> 'cs-reviews',
			'post_status'				=> 'publish',
			'meta_key'					=> 'cs_reviews_course',
			'meta_value'				=> $course_id,
			'meta_compare'				=> "=",
			'orderby'					=> 'ID',
			'order'						=> 'DESC',
		);
		$recent_reviews_query = new WP_Query($recent_reviews_args);
		$reviews_count = cs_course_reviews_count($course_id);
		if ( $recent_reviews_query->have_posts() <> "" ) {?>
			<div class="col-md-12 widget widget_instrector">
				<div class="widget-section-title">
				  <h2>Recent Review</h2>
				</div>
			<?php
			while ( $recent_reviews_query->have_posts() ): $recent_reviews_query->the_post();
				$var_cp_rating = get_post_meta($post->ID, "cs_reviews_rating", true);
				$var_cp_reviews_members = get_post_meta($post->ID, "cs_reviews_user", true);
				$var_cp_courses = get_post_meta($post->ID, "cs_reviews_course", true);
 				
				?>
           		 <div class="inner-sec">
                    <figure>
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $var_cp_reviews_members)); ?>">
                        <?php echo get_avatar(get_the_author_meta('user_email', $var_cp_reviews_members), apply_filters('PixFill_author_bio_avatar_size', 60)); ?>
                        </a>
                    </figure>
                    <div class="left-sp">
                        <h5><a ><?php echo get_the_author_meta('display_name', $var_cp_reviews_members); ?></a></h5>
                       <div class="cs-rating"><span class="rating-box" style="width:<?php echo absint($var_cp_rating)*20;?>%"></span></div>
                       <span class="cs-rating-desc">(<?php echo (int)$reviews_count.' '; _e('Reviews','EDULMS');?> )</span>
                    </div>
                    <p><?php echo cs_get_the_excerpt('135',false, '');?></p>
                </div>
				<?php 
				
                endwhile;
                wp_reset_postdata();
                ?>
           	 <a class="custom-btn circle center-align" href="<?php the_permalink($course_id);?>?filter_action=course-reviews">
                <?php _e('View All Reviews','EDULMS');?>
             </a>
            
		</div>
		<?php 
        }
	}
}

// Course Detail Info
if (!function_exists('cs_course_detail_info_widget')) {
	function cs_course_detail_info_widget($course_id='',$user_course_data,$var_cp_course_product = '',$var_cp_course_paid=''){
		 global $post, $cs_theme_options,$cs_xmlObject,$cs_course_options;
		 $user_id = cs_get_user_id();
		 $cs_course_options = $cs_course_options;
		 if(isset($cs_course_options['cs_currency_symbol']) && $cs_course_options['cs_currency_symbol'] <> ''){
			 $currency_symbol = $cs_course_options['cs_currency_symbol'];
		 } else {
			$currency_symbol = '$'; 
		 }
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		$var_cp_course_instructor =  get_post_meta( $course_id, 'var_cp_course_instructor', true);
	   $cs_user_data = get_userdata((int)$var_cp_course_instructor);
	   $reviews_count = cs_course_reviews_count($course_id);
	   ?>
		<div class="col-md-12 widget widget_dfreview">
				<?php 
				//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
				$user_course_data 		= get_option($course_id."_cs_user_course_data", true);
				$subscription_course 	= cs_check_user_course_subscription($course_id);
				$user_right 			= $subscription_course['user_right'];
				$subscription_status 	= $subscription_course['user_status'];
				
				if(isset($user_right) && $user_right == '1' && ($subscription_status == '0' || $subscription_status == '1')){
						$cs_page_id = $cs_course_options['cs_dashboard'];
					?>
					<div class="dfreview_inn">  
                    	<div class="cs-subscription-info">
							<?php 
                                if($subscription_status == 1){
                                    _e('Your subscription is pending. It needs approval of admin','EDULMS');
									$action_link = 'user-invoices';
                                } else {
                                    _e('You subscribed this course','EDULMS');
									$action_link = 'my-courses';
                                }
                            ?>
                        </div>
                        <a  href="<?php echo get_permalink($cs_page_id); ?>/?action=<?php echo esc_attr($action_link);?>&uid=<?php echo absint($user_id); ?>" target="_blank" class="custom-btn circle cs-bg-color fullwidth center-align">
                        <i class="fa fa-custom-icon"></i>
						<?php 
							if($subscription_status == 1){
								_e('Pending','EDULMS');
								
							} else {
								_e('Subscribed','EDULMS');
							}
						?>
                        </a>
                    </div>
                    <?php
				} else {
					if(class_exists('Woocommerce') && isset($var_cp_course_paid) && ($var_cp_course_paid == 'paid-with-woocommerce')) {
						
							if(isset($var_cp_course_paid) && ($var_cp_course_paid == 'paid-with-woocommerce')){
								if(isset($var_cp_course_product) && $var_cp_course_product <> ''){
								 $args = array('post_type' => 'product','p' => "$var_cp_course_product", 'post_status' => 'publish');
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post(); 
									global $product;
									$add_to_cart_url = esc_url($product->add_to_cart_url());
									$price_html = $product->get_price_html();
									?>
                                	<div class="dfreview_inn">    
										<?php if(isset($price_html) && $price_html <> ''){?>
                                                    <div class="cs-carprice">
                                                        <small><?php _e('Price','EDULMS');?></small>
                                                        <?php echo ''.$price_html; ?>
                                                    </div>
                                         <?php }?>
                                         <?php if(isset($add_to_cart_url) && $add_to_cart_url <> ''){
                                                    $course_url = '&amp;course_url='.$course_id;?>
                                                <a href="<?php echo esc_url($product->add_to_cart_url().$course_url); ?>" class="custom-btn circle fullwidth center-align">
                                                    <i class="fa fa-custom-icon"></i><?php _e('TAKE THIS COURSE','EDULMS');?>
                                                </a>
                                        <?php }?>
                           		    </div>
						<?php endwhile; 
							wp_reset_postdata();
							}
						}
					} else if(isset($var_cp_course_paid) && ($var_cp_course_paid == 'paid-with-paypal')){
						if ( empty($cs_xmlObject->course_paid_price) ) $course_paid_price = ""; else $course_paid_price = $cs_xmlObject->course_paid_price;
						if ( empty($cs_xmlObject->course_paypal_email) ) $course_paypal_email = ""; else $course_paypal_email = $cs_xmlObject->course_paypal_email;
						?>
                        <div class="dfreview_inn">    
                            <?php 
							if(isset($course_paid_price) && $course_paid_price <> ''){?>
                                <div class="cs-carprice">
                                    <small><?php _e('Price','EDULMS');?></small>
                                    <?php echo esc_attr($currency_symbol.$course_paid_price); ?>
                                </div>
                             <?php 
							 }
							 echo cs_take_course($course_paypal_email,$course_paid_price);
							 ?>
                        </div>
						<?php
					} else if(isset($var_cp_course_paid) && ($var_cp_course_paid == 'paid')){
						if ( empty($cs_xmlObject->course_paid_price) ) $course_paid_price = ""; else $course_paid_price = $cs_xmlObject->course_paid_price;
						if ( empty($cs_xmlObject->course_custom_payment_url) ) $course_custom_payment_url = "#"; else $course_custom_payment_url = $cs_xmlObject->course_custom_payment_url;
						?>
                        <div class="dfreview_inn">    
                            <?php 
							if(isset($course_paid_price) && $course_paid_price <> ''){?>
                                <div class="cs-carprice">
                                    <small><?php _e('Price','EDULMS');?></small>
                                    <?php echo esc_attr($currency_symbol.$course_paid_price); ?>
                                </div>
                             <?php 
							 }
							 ?>
                             <a href="<?php echo esc_url($course_custom_payment_url);?>" target="_blank" class="custom-btn circle fullwidth center-align">
                                <i class="fa fa-custom-icon"></i><?php _e('TAKE THIS COURSE','EDULMS');?>
                            </a>
                        </div>
						<?php
					}
				}
				if(isset($reviews_count) && $reviews_count <> ''){
					$var_cp_rating = cs_course_rating_count($course_id);
					if($var_cp_rating){
						$var_cp_rating = $var_cp_rating/$reviews_count;
					}
				?>
					<ul class="listoption">
						<li>
							<div class="cs-rating"><span class="rating-box" style="width:<?php echo absint($var_cp_rating)*20;?>%"></span></div>
							<span>(<?php echo absint($reviews_count);?> REVIEWS )</span>
						</li>
					</ul>
			<?php }?>
		</div>
	  <!--Course  Instructor Information-->
      <?php
	}
}


if (!function_exists('cs_take_course')) {
	function cs_take_course($course_paypal_email = '', $course_price = ''){
		global $post, $cs_theme_option;
		$cs_paypal_options = array('paypal_currency_sign'=>'','paypal_currency'=>'','paypal_ipn_url'=>'','paypal_email'=>'');
		if(isset($course_paypal_email) && $course_paypal_email <> ''){
			$cs_course_paypal_email = $course_paypal_email;
		} else {
			$cs_course_paypal_email = $cs_paypal_options['paypal_email'];
		}
		$post_type = get_post_type($post->ID);
		if($post_type == 'courses'){
			$course_id = $post->ID;
		}
		$paypal_content_button = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">  
		<input type="hidden" name="cmd" value="_xclick">  
		<input type="hidden" name="business" value="'.$cs_course_paypal_email.'">
		<label><span>'.$cs_paypal_options['paypal_currency_sign'].'</span><input type="hidden" class="cause-amount" type="hidden" value="'.$course_price.'" name="amount"></label> 
		<input type="hidden" name="item_name" value="'.get_the_title().'"> 
		<input type="hidden" name="no_shipping" value="2">
		<input type="hidden" name="item_number" value="'.$post->ID.'">  
		<input name = "cancel_return" value = "'.get_permalink($post->ID).'" type = "hidden">  
		<input type="hidden" name="no_note" value="1">  
		<input type="hidden" name="currency_code" value="'.$cs_paypal_options['paypal_currency'].'">  
		<input type="hidden" name="notify_url" value="'.$cs_paypal_options['paypal_ipn_url'].'">
		<input type="hidden" name="lc" value="AU">  
		<input type="hidden" name="return" value="'.get_permalink($post->ID).'">  
		<span class="donate-btn btn"><input class="custom-btn circle fullwidth center-align" type="submit" value="'.__('TAKE THIS COURSE','EDULMS').'"> </span>
		</form> ';
		return $paypal_content_button;
	}
}

// Course Members Count
if (!function_exists('cs_course_members_count')) {
	function cs_course_members_count($course_id=''){
		global $post;
		if(!isset($course_id) && empty($course_id)){
			$course_id = $post->ID;
		}
		$user_id = cs_get_user_id();
		//$user_course_data_array = get_post_meta($course_id, "cs_user_course_data", true);
		$user_course_data_array = get_option($course_id."_cs_user_course_data", true);
		$course_user_ids = array();
		$user_subscription_count = 0;
		if ( isset($user_course_data_array) && is_array($user_course_data_array) && count($user_course_data_array)>0) {
			foreach ( $user_course_data_array as $members ){
				if($user_id == $members['user_id']){
					$user_subscription_count++;	
				}
				 $course_user_ids[] = $members['user_id'];
			}
		}
		$course_data_array = array();
		$user_course_data = array_unique($course_user_ids);
		$course_data_array[] = $user_course_data;
		$course_data_array[] = $user_subscription_count;
		return $course_data_array;
	}
}

// Custom function for next previous posts
if (!function_exists('px_next_prev_curriculum_links')) {
 function px_next_prev_curriculum_links($post_type = 'cs-curriculums',$course_id,$posts_list){
	 	global $post,$cs_xmlObject;
		if ($posts_list && $course_id) {
			$previd = $nextid = '';
			$post_type   = get_post_type($post->ID);
			$count_posts = wp_count_posts( "$post_type" )->publish;
			
			$px_postlist_args = array(
			   'posts_per_page'  => -1,
			   'post_type'       => "$post_type",
			   'include'		 =>  $posts_list,
			   'orderby' 		 => 'post__in'
			); 
			$px_postlist = get_posts( $px_postlist_args );
			$ids = array();
			foreach ($px_postlist as $px_thepost) {
			   $ids[] = $px_thepost->ID;
			}
			$thisindex = array_search($post->ID, $ids);
			if(isset($ids[$thisindex-1])){
				$previd = $ids[$thisindex-1];
			} 
			if(isset($ids[$thisindex+1])){
				$nextid = $ids[$thisindex+1];
			} 
			echo '<div class="cs-post-sharebtn">';
				if (isset($previd) && !empty($previd) && $previd >=0 ) {
			   		?>
					<a href="<?php echo add_query_arg( 'course_id', absint($course_id), get_permalink($previd) );?>"><i class="fa fa-angle-left"></i></a>
					<?php
				}
				if (isset($nextid) && !empty($nextid) ) {
				?>
					<a href="<?php echo add_query_arg( 'course_id', absint($course_id), get_permalink($nextid) );?>" ><i class="fa fa-angle-right"></i></a>
				<?php	
				}
			echo '</div>';
		 wp_reset_query();
		}
 }
}
 
 // Single Product Price
if (!function_exists('cs_get_product_price')) { 
 function cs_get_product_price($product_id = ''){
	 global $cs_theme_options,$cs_course_options;
	 $cs_course_options = $cs_course_options;
	 $sale_price = get_post_meta( $product_id, '_price', true);
	 if($sale_price == ""){
		$regular_price = get_post_meta( $product_id, '_regular_price', true);
		$sale_price = $regular_price;
	 }
	 if(isset($cs_course_options['cs_currency_symbol']))
		$product_currency = $cs_course_options['cs_currency_symbol'];
	 else 
	 	$product_currency = '$';
	 
	return $product_currency.$sale_price;
 }
}

// Course Access condition
if (!function_exists('cs_user_course_access')) { 
	 function cs_user_course_access($var_cp_course_paid = '', $course_id = '', $course_curriculums_tabs_display = ''){
		 global $post;
		 $course_access = array();
		 if(isset($var_cp_course_paid) && $var_cp_course_paid <> '' || $var_cp_course_paid == 'paid'){
			 $user_id = cs_get_user_id();
			 $flag_course = 0;
			 $display_course = 0;
			 if($var_cp_course_paid == 'free'){
				 $flag_course = 1;
				 $display_course = 1;
			 } else if($var_cp_course_paid == 'registered_user_access'){
				 if($user_id <> ''){
					 $flag_course = 1;
					 $display_course = 1;
				 } else {
					 $display_course = 1;
				 }
			 } else if($var_cp_course_paid == 'paid-with-woocommerce' && $user_id <> ''){
				 if($user_id <> ''){
					  $user_right = cs_check_user_right($course_id);
					 if($user_right == 1){
						 $flag_course = 1;
						 $display_course = 1;
					 }
					 
				 }
				 if($course_curriculums_tabs_display == 'on'){
					 $display_course = 1;
				 } else {
					 $display_course = 0;
				 }
			 } else if($var_cp_course_paid == 'paid-with-paypal' && $user_id <> ''){
				 
				 $user_right = cs_check_user_right($course_id);
				 if($user_right == 1 || $course_curriculums_tabs_display == 'on'){
					 $flag_course = 1;
				 }	 
			 } else if($var_cp_course_paid == 'paid' && $user_id <> ''){
				 if($user_id <> ''){
					  $user_right = cs_check_user_right($course_id);
					 if($user_right == 1){
						 $flag_course = 1;
						 $display_course = 1;
					 }
				 }
				 if($course_curriculums_tabs_display == 'on'){
					 $display_course = 1;
				 } else {
					 $display_course = 0;
				 }
				 
			 }
			 $course_access['user_access'] = $flag_course;
			 $course_access['display_course'] = $display_course;
			 return $course_access;
		 }
	 }
}

if( !function_exists('cs_course_search_func')){
	function cs_course_search_func($course_id = ''){
		global $post,$cs_theme_options;
		$var_cp_course_product = '';
		$post_class = '';
		$image_url = '';
		
		$cs_course = get_post_meta($course_id, "cs_course", true);
		if ( $cs_course <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_course);
			$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
		}
		$image_url = cs_attachment_image_src(get_post_thumbnail_id( $course_id), 370, 278 );
		if($image_url == ''){
			$post_class = ' no-image';
			$image_url	= get_template_directory_uri().'/assets/images/no-image4x3.jpg';
		}
		$event_from_date = get_post_meta( $post->ID, "cs_event_from_date", true ); 
		$applyNowButton	= get_the_permalink(); 
	?>
	<div class="col-md-4">
		<article class="cs-list list_v1 img_position_top has_border post-<?php echo absint($course_id); ?>">
			<?php 
				if($image_url <> ""){
					echo '<figure>';
						$user = cs_get_user_id();
						$cs_wishlist = array();
						$cs_wishlist =  get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
						if (!is_user_logged_in() ) { 
							echo '<a class="cs-add-wishlist" data-toggle="modal" data-target="#myModal">'.__('Login','EDULMS').'</a>';
						}elseif(isset($user) and $user<>''){
							$cs_wishlist = get_user_meta(cs_get_user_id(),'cs-courses-wishlist', true);
							if(is_array($cs_wishlist) && in_array($post->ID,$cs_wishlist)){
								echo '<a class="cs-add-wishlist" ><i class="fa fa-plus cs-bgcolr"></i>'.__('Already Favourite','EDULMS').'</a>';
						}else{
						?>
						<a class="cs-add-wishlist" onclick="cs_addto_wishlist('<?php echo esc_js(admin_url('admin-ajax.php'));?>','<?php echo esc_js($course_id);?>','post')">
							<i class="fa fa-heart"></i> 
							<?php _e('Add to Favourite','EDULMS');?>
						</a>
				<?php } 
				} ?>
				<a href="<?php echo the_permalink();?>" ><img src="<?php echo esc_url($image_url);?>" alt="" ></a>
				</figure>
				<?php }?>
				<div class="text-section">
					<div class="cs-top-sec">
						<div class="seideleft">
							<div class="left_position">
								  <h2><a href="<?php the_permalink(); ?>" class="colrhvr"><?php the_title(); ?></a></h2>
								  <?php 
								  $reviews_args = array(
									'posts_per_page'			=> "-1",
									'post_type'					=> 'cs-reviews',
									'post_status'				=> 'publish',
									'meta_key'					=> 'cs_reviews_course',
									'meta_value'				=> $post->ID,
									'meta_compare'				=> "=",
									'orderby'					=> 'meta_value',
									'order'						=> 'ASC',
									
								);
								$reviews_query = new WP_Query($reviews_args);
								$reviews_count = $reviews_query->post_count;
								$var_cp_rating = 0;
								if ( $reviews_query->have_posts() <> "" ) {
									while ( $reviews_query->have_posts() ): $reviews_query->the_post();	
										$var_cp_rating = $var_cp_rating+get_post_meta($post->ID, "cs_reviews_rating", true);
									endwhile;
								}
								if($var_cp_rating){
									$var_cp_rating = $var_cp_rating/$reviews_count;
								}
								
								if ( function_exists( 'cs_get_course_reviews' ) ) { echo '<ul class="listoption">';cs_get_course_reviews($reviews_count,$var_cp_rating);echo '</ul>'; }
								  ?>													                                                                                                                                                                 
							</div>
						</div>                                           
					</div>                                                                                  
					<div class="cs-cat-list">
						<?php 
							if ( function_exists( 'cs_get_course_price' ) ) {
								echo '<ul>';
									cs_get_course_price($var_cp_course_product); 
								echo '</ul>';
							}
						?>	
					</div>
					<a href="<?php echo esc_url($applyNowButton); ?>" class="custom-btn"><i class="fa fa-file-text"></i>
						<?php _e('Apply Now','EDULMS');?>															 
					</a>                                                                                                                                                                 		
			  </div>
		</article>
	</div>
	<?php
	}
}

/** 
 * @Review Button
 *
 *
 */
  if ( ! function_exists( 'cs_add_review_button' ) ) {
	function cs_add_review_button($user_id, $post_id, $var_cp_course_paid = ''){
		global $cs_theme_options,$post;
		if ( function_exists( 'cs_prettyphoto_enqueue' ) ) {
			cs_prettyphoto_enqueue();
		}
		?>
        <script type="text/javascript">
			jQuery(function ($) {
				$("a[rel^='prettyPhoto']").prettyPhoto();
				$('#closemodel').live('click', function() {
					$.prettyPhoto.close();
					return false;
				});
			});
		</script>
        <style>
			.add_review_btn{ display:block !important;}
		
		</style>
        <div class="course-reviews-model">
        	<!--<a href="#inline-course-reviews" class="add_review_btn custom-btn circle btn-lg cs-bg-color" rel="prettyPhoto" ><?php  _e('Add Reviews','EDULMS');	?></a>
             <button class="add_review_btn custom-btn circle btn-lg cs-bg-color" data-toggle="modal" data-target=".cs-add-reviews-model"><?php  _e('Add Reviews','EDULMS');?></button>-->
                <div id="inline-course-reviews" class="modal fade cs-add-reviews-model hideee">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    	<?php
						$user_course_ids = array();
						if(isset($user_id)){
							$cs_course_ids_option = array();
							$cs_course_register_option = array();
							$cs_course_register_option = get_option("cs_course_register_option", true);
							if(isset($cs_course_register_option['cs_course_ids_option']))
								$cs_course_ids_option = @$cs_course_register_option['cs_course_ids_option'];
								$user_courses = '';
								$user_courses = get_option($user_id."_cs_course_data", true);
							$user_course_ids = array();
							if(isset($user_courses) && !empty($user_courses) && is_array($user_courses)){
								foreach($user_courses as $course_id=>$course){
									if(isset($course_id))
										$user_course_ids[] = $course_id;
								}
							}
						}
						if(in_array($post_id, $user_course_ids) || (isset($var_cp_course_paid) && $var_cp_course_paid == 'registered_user_access' )){
						?>
                        <form name="reviews-form" id="cs-reviews-form">
                            <input type="hidden" name="action" value="cs_add_reviews" />
                             <input type="hidden" name="course_id" value="<?php echo absint($post->ID);?>" />
                            <input type="hidden" name="var_cp_reviews_rating" id="cs-review-rate" value="1" />
                            <input type="hidden" name="user_id" value="<?php echo absint(cs_get_user_id());?>" />
                              <div class="modal-header">
                                <button type="button" id="closemodel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?php _e('Add Reviews','EDULMS');?></h4>
                              </div>
                              <div class="modal-body">
                                <div id="loading"></div>
                              	<div class="review-message-type succ_mess" style="display:none"><p></p></div>
                                <?php  if ( is_user_logged_in() ) {
										cs_enqueue_rating_style_script();
								?> 
                               			 <!-- JS to add -->
										<script type="text/javascript">
                                          jQuery(document).ready(function(){
                                            jQuery(".course-rate").jRating({
                                              step:true, 
                                              bigStarsPath : "<?php echo esc_js(get_template_directory_uri());?>/assets/images/stars.png",
                                              smallStarsPath : "<?php echo esc_js(get_template_directory_uri());?>/assets/images/small.png",
                                              rateMax : 5,
                                              length : 5,
                                              canRateAgain : true,
                                              nbRates : 10,
                                              onClick : function(element,rate) {
                                                jQuery('#cs-review-rate').val(rate);
                                             }
                                            });
                                          });
                                        </script>
                                <h3><?php echo ucwords( get_the_title() );?></h3>
                                
                                <ul class="reviews-modal">
                                    <li>
                                        <label><?php _e('Rating','EDULMS');?></label>
                                        <div class="course-rate" data-average="1" data-id="1"></div>
                                    </li>
                                    <li>
                                        <label><?php _e('Subject','EDULMS');?></label>
                                        <input type="text" id="reviews_title" name="reviews_title" value="" />
                                    </li>
                                    <li>
                                        <label><?php _e('Reviews Description','EDULMS');?></label>
                                        <textarea name="reviews_description" id="reviews_description"></textarea>
                                        <p><?php _e('Your Review Will be Posted publicly on the web.','EDULMS');?></p>
                                    </li>
                                 </ul>
                                <?php } else { ?>
									<p><?php _e('Reviews can be given after Signup with "'.ucwords(get_the_title()).'"','EDULMS');?></p>
								<?php }?>
                              </div>
                              <?php  if ( is_user_logged_in() ) {?> 
                                      <div class="modal-footer">
                                        <button type="button" id="closemodel" class="btn btn-default" data-dismiss="modal"><?php _e('Close','EDULMS');?></button>
                                        <button type="button" class="btn btn-primary" onclick="cs_reviews_submission('<?php echo esc_js(admin_url('admin-ajax.php'))?>', '<?php echo esc_js(get_template_directory_uri())?>');"><?php _e('Save changes','EDULMS');?></button>
                                      </div>
                              <?php }?>
                          </form>
                        <?php
						} else {
						?>
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&ast;</button>
                              <h4 class="modal-title"><?php _e('Add Reviews','EDULMS');	?></h4>
                            </div>
                            <div class="modal-body">
                                <h3><?php echo ucwords( get_the_title() );?></h3>
                                <p>Reviews can be given after Signup with "<?php echo ucwords( get_the_title() );?>"</p>
                            </div>
						<?php
                        }
						?>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
             </div>
        <?php
	}
}

//check intersect array
if ( ! function_exists( 'array_intersect_array' ) ) {
	function array_intersect_array($result, $answer_arrray){
		//if($result == array_intersect($result, $multiple_option_correct)){
		if($result == $answer_arrray){
			//foreach(){
				//if(in_array())
			//}
		} else {
			return 0;	
		}
	}
}

// shuffle array keys
if ( ! function_exists( 'cs_shuffle_assoc' ) ) {
	function cs_shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 
	
	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  foreach ($keys as $key) 
		$random[$key] = $list[$key]; 
	
	  return $random; 
	}
}

// get object array
if ( ! function_exists( 'cs_ObjecttoArray' ) ) {
	function cs_ObjecttoArray($obj)
	{
		if (is_object($obj)) $obj = (array)$obj;
		if (is_array($obj)) {
			$new = array();
			foreach ($obj as $key => $val) {
				$new[$key] = cs_ObjecttoArray($val);
			}
		} else {
			$new = $obj;
		}
		return $new;
	}
}

// remove user role
$role = get_role( 'instructor' );
if(!isset($role)){
	$role = add_role( 'instructor', 'Instructor', array(
		'read' => true, // True allows that capability
		'write' => true, // True allows that capability
		'edit_posts'   => true,
        'delete_posts' => false, // Use false to explicitly deny
	) );
}
// add user role
$member_role = get_role( 'member' );
if(!isset($member_role)){
	$member_role = add_role( 'member', 'Member', array(
		'read' => true, // True allows that capability
		'write' => false, // True allows that capability
		'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
	) );
}
// add user role
$staff_role = get_role( 'staff' );
if(!isset($staff_role)){
	$staff_role = add_role( 'staff', 'Staff', array(
		'read' => true, // True allows that capability
		'write' => false, // True allows that capability
		'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
	) );
}


// curriculum read
  if ( ! function_exists( 'cs_curriculm_read' ) ) {
		function cs_curriculm_read(){
			
			global $post;
			//print_r($_FILES);
			$user_id = cs_get_user_id();
				if ( $_SERVER["REQUEST_METHOD"] == "POST"){
						$post_id = $_POST['post_id'];
						$var_cp_assigment_type = '';
						$user_curriculms_mark_read = array();
						$user_curriculms_mark_read = get_post_meta($post_id, "cs_user_curriculms_mark_read", true);
						if(!empty($user_curriculms_mark_read) && array_key_exists($user_id, $user_curriculms_mark_read)){
							$user_curriculms_mark_read[$user_id][$post_id] = '1';
						} else {
							$user_curriculms_mark_read[$user_id][$post_id] = '1';
						}
						
						if(is_array($user_curriculms_mark_read)){
							update_post_meta($post_id, "cs_user_curriculms_mark_read", $user_curriculms_mark_read);
						}
				}
				exit;
		}
		add_action('wp_ajax_cs_curriculm_read', 'cs_curriculm_read');
  }

// get date gap
 if ( ! function_exists( 'dateDiff' ) ) {
	function dateDiff($d1,$d2){
		$date1=strtotime($d1);
		$date2=strtotime($d2);
		$seconds = $date1 - $date2;
		$weeks = floor($seconds/604800);
		$seconds -= $weeks * 604800;
		$days = floor($seconds/86400);
		$seconds -= $days * 86400;
		$hours = floor($seconds/3600);
		$seconds -= $hours * 3600;
		$minutes = floor($seconds/60);
		$seconds -= $minutes * 60;
		$months=round(($date1-$date2) / 60 / 60 / 24 / 30);
		$years=round(($date1-$date2) /(60*60*24*365));
		
		$diffArr=array("Seconds"=>$seconds,
					  "minutes"=>$minutes,
					  "Hours"=>$hours,
					  "Days"=>$days,
					  "Weeks"=>$weeks,
					  "Months"=>$months,
					  "Years"=>$years
					 ) ;
			$diffArr=array_filter($diffArr);
	   return $diffArr;
	}
 }

 if ( ! function_exists( 'edulms_stripslashes_htmlspecialchars' ) ) {
	function edulms_stripslashes_htmlspecialchars($value){
		$value = is_array($value) ? array_map('edulms_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
		return $value;
	}
}

if ( ! function_exists( 'cs_enqueue_validation_script' ) ) {			
	function cs_enqueue_validation_script(){
		wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate_metadata.js', '', '', true);
		wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate.js', '', '', true);
	}
}
//======================================================================
// Course Search Html for Page Builder 
//======================================================================
if ( ! function_exists( 'cs_pb_course_search' ) ) {
	function cs_pb_course_search($die = 0){
		global $cs_node, $cs_count_node, $post;
		
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$PREFIX = 'cs_course_search';
		$counter = $_POST['counter'];
		$parseObject 	= new ShortcodeParse();
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
	
		$defaults = array( 'course_search_title'=>'',);
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			if(isset($output['0']['content']))
				$atts_content = $output['0']['content'];
			else 
				$atts_content = array();
			$course_search_element_size = '100';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$name = 'cs_pb_course_search';
			$cs_count_node++;
			$coloumn_class = 'column_'.$course_search_element_size;
		
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>

<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete <?php echo $coloumn_class;?> <?php echo $shortcode_view;?>" item="course_search" data="<?php echo element_size_data_array_index($course_search_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$course_search_element_size);?>
  <div class="cs-wrapp-class-<?php echo $cs_counter?> <?php echo $shortcode_element;?>" id="<?php echo $name.$cs_counter?>" data-shortcode-template="[cs_course_search {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Course Search Options','EDULMS');?></h5>
      <a href="javascript:removeoverlay('<?php echo $name.$cs_counter?>','<?php echo $filter_element;?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
      <div class="cs-pbwp-content">
      <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title','EDULMS');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="course_search_title[]" class="txtfield" value="<?php echo $course_search_title?>" />
          </li>
        </ul>
      
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>','<?php echo $name.$cs_counter?>','<?php echo $filter_element;?>')" ><?php _e('Insert','EDULMS');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="course_search" />
          <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
        </li>
      </ul>
      <?php }?>
    </div>
    </div>
</div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_course_search', 'cs_pb_course_search');
}
