<?php
/**
 * File Type: Settings Class ( Reports,badges,Instructors, Course Revenue, Quize, Assignments etc..)
 *
 * @package LMS
 * @since LMS  1.0
 * @Auther Chimp Solutions
 * @copyright Copyright (c) 2014, Chimp Studio 
 */


if(!class_exists('cs_settings'))
{
    class cs_settings
    {
		
	public function __construct(){
		
	}
	
	//======================================================================
	// Reports Menu Function
	//======================================================================	
	
	public function cs_datatables_enqueue(){
		add_action('wp_enqueue_scripts', array('edulms', 'cs_reprotstables_script_enqueue'));
		add_action('admin_enqueue_scripts', array('edulms', 'cs_reprotstables_script_enqueue'));	
	}
	
	public function cs_register_quiz_assignments_menu_page(){
		//add submenu page
		add_submenu_page('edit.php?post_type=courses', 'Course Settings ', 'Course Settings', 'manage_options', 'quiz_assignments_listing_page', array(&$this, 'quiz_assignments_listing_page'));
		//add_submenu_page('edit.php?post_type=courses', 'Course options', 'Course options', 'manage_options', 'cs_course_options_listing', array(&$this, 'cs_course_options_listing'));
		//add_submenu_page('edit.php?post_type=courses', 'Course Settings', 'Reports Settings', 'manage_options', 'quiz_assignments_listing_page', array(&$this, 'quiz_assignments_listing_page'));
	}
	
	
	public function cs_course_options_listing(){
			global $cs_theme_options,$cs_course_options;
			$cs_course_options = $cs_course_options;
			if(!isset($cs_course_options) || empty($cs_course_options) || !is_array($cs_course_options)){
				$cs_course_options = array('cs_dashboard'=>'','cs_currency_symbol'=>'$');	
			}
			?>
			<script type="text/javascript" language="javascript" class="init">
				jQuery(document).ready(function($) {
					$('#revenue,#revenue2,#revenue3,#revenue4').DataTable();
				} );
			</script>
		<?php 
			global $wp;
			$url = admin_url('edit.php?post_type=courses&page=cs_course_options');
			$args = array(
					  'depth'            => 0,
					  'child_of'     => 0,
					  'sort_order'   => 'ASC',
					  'sort_column'  => 'post_title',
					  'show_option_none' => 'Please select a page',
					  'hierarchical' => '1',
					  'exclude'      => '',
					  'include'      => '',
					  'meta_key'     => '',
					  'meta_value'   => '',
					  'authors'      => '',
					  'exclude_tree' => '',
					  'selected'         => $cs_course_options['cs_dashboard'],
					  'echo'             => 0,
					  'name'             => 'cs_dashboard',
					  'post_type' => 'page'
				  );
		?>
		<div class="report-table-sec">
			<!-- Nav tabs -->
			<!-- Tab panes -->
			<div class="tab-content reports-content">
              <div class="tab-pane active" id="statement">
				<div class="tab-title"><h3><?php _e('Course Options','EDULMS');?></h3></div>
                <div class="outerwrapp-layer">
					<div class="loading_div">
						<i class="fa fa-circle-o-notch fa-spin"></i>
						<br> <?php _e('Saving Course Options...','EDULMS');?>
					</div>
					<div class="form-msg">
						<i class="fa fa-check-circle-o"></i>
						<div class="innermsg"></div>
					</div>
			   </div>
            	<form id="course_options_form" name="course_options" method="post" >
                
            	<ul class="form-elements">
                <li class="to-label"><label><?php _e('User Profile Page','EDULMS');?><span><?php _e('Select page for user profile here','EDULMS');?></span></label></li>
				<li class="to-field">
                	<div class="select-style">
                    	<?php echo wp_dropdown_pages($args);?>
               		 </div>
                  </li>
                </ul>
                <ul id="cs_currency_symbol_textfield" class="form-elements">
                	<li class="to-label">
                        <label><?php _e('Currency','EDULMS');?><span><?php _e('Set currency symbol like($,£,¥)','EDULMS');?></span></label>
                    </li>
					<li class="to-field"><input type="text" class="vsmall" value="<?php echo esc_attr($cs_course_options['cs_currency_symbol']);?>" id="cs_currency_symbol" name="cs_currency_symbol"><p></p></li>
               </ul>
         
				 <div class="footer">
					<input type="button" id="submit_btn" name="submit_btn" class="bottom_btn_save" value="<?php _e('Save Options','EDULMS');?>" onclick="javascript:cs_course_options_save('<?php echo esc_js(admin_url('admin-ajax.php'))?>');" />
					<input type="hidden" name="action" value="cs_course_options"  />
					
				   
				</div>
				</form>
			 </div>
            </div>
		</div>
		<?php
	}
	
	//======================================================================
	// Course Report Function
	//======================================================================
	
	public function quiz_assignments_listing_page(){
			global $cs_theme_options,$cs_course_options;
			//$this->cs_datatables_enqueue();

			$cs_theme_options = $cs_theme_options;
			$cs_course_options = $cs_course_options;
			?>
			<div class="reports-infobox">
				<?php
					$args = array(
								'posts_per_page'			=> "-1",
								'paged'						=> "1",
								'post_type'					=> 'courses',
								'post_status'				=> 'publish',
								'orderby'					=> 'ID',
								'order'						=> 'ASC',
							);
					$custom_query = new WP_Query($args);
					$course_post_count = $custom_query->post_count;
					$course_post_count = empty($course_post_count)?'0':$course_post_count;
					$total_course = $this->cs_courses_total_earnings();
					$blogusers = get_users('role=instructor');
				?>
				<ul>
					<li>
						<div class="report-infoinner" style=" background-color: #68c49f; ">
							<div class="define-text">
								<div class="reportsinfo-icon">
									<i class="fa fa-globe"></i>
								</div>
								<span><?php _e('Total','EDULMS');?> <b><?php _e('Course','EDULMS');?></b></span>
								<big><?php echo absint($course_post_count);?></big>
							</div>
							<div class="define-percent"></div>
						</div>
					</li>
					<li>
						<div class="report-infoinner" style=" background-color: #4a525f; ">
							<div class="define-text">
								<div class="reportsinfo-icon">
									<i class="fa fa-user"></i>
								</div>
								 <span><?php _e('Total','EDULMS');?> <b><?php _e('Members','EDULMS');?></b></span>
								<big><?php echo esc_attr($total_course['total_members']);?></big>
							   
							</div>
							<div class="define-percent"></div>
						</div>
					</li>
					<li>
						<div class="report-infoinner" style=" background-color: #f67a82; ">
							<div class="define-text">
								<div class="reportsinfo-icon">
									<i class="fa fa-dollar"></i>
								</div>
								 <span><?php _e('Total','EDULMS');?> <b><?php _e('Earnings','EDULMS');?></b></span>
								<big><?php
								if(isset($cs_course_options['cs_currency_symbol']))
									$product_currency = $cs_course_options['cs_currency_symbol'];
								 else 
									$product_currency = '$';
								echo esc_attr($product_currency);
								echo esc_attr($total_course['total_earning']);
								?></big>
							</div>
							<div class="define-percent"></div>
						</div>
					</li>
					<li>
						<div class="report-infoinner" style=" background-color: #abb7b7; ">
							<div class="define-text">
								<div class="reportsinfo-icon">
									<i class="fa fa-users"></i>
								</div>
								<span><?php _e('Total','EDULMS');?> <b><?php _e('Instructors','EDULMS');?></b></span>
								<big><?php echo count($blogusers);?></big>
							</div>
							<div class="define-percent"></div>
						</div>
					</li>
				</ul>
		</div>
		<?php 
			global $wp;
			$url = admin_url('edit.php?post_type=courses&page=quiz_assignments_listing_page');
			if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by'] <> ''){
				$sort_by = $_REQUEST['sort_by'];
			} else {
				$sort_by = '';
			}
			if(isset($_REQUEST['action']) && $_REQUEST['action'] <> ''){
				$action = $_REQUEST['action'];
			} else {
				$action = 'statement';
			}
			$cs_course_options = $cs_course_options;
		?>
		<div class="report-table-sec">
			<!-- Nav tabs -->
			<ul class="reports-tabs" role="tablisttt"> 
			  <li <?php if($action == 'statement'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=statement';?>"><?php _e('Statement','EDULMS');?></a></li>
			  <li  <?php if($action == 'instructor'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=instructor';?>"><?php _e('Instructor','EDULMS');?></a></li>
			  <li  <?php if($action == 'revenue'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=revenue';?>"><?php _e('Course Revenue','EDULMS');?></a></li>
			  <?php
			  $cs_lms = get_option('cs_lms_plugin_activation');	
			  if(isset($cs_lms) && $cs_lms == 'installed'){
				  ?>
				  <li  <?php if($action == 'quiz-listing'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=quiz-listing';?>"><?php _e('Quiz','EDULMS');?></a></li>
				  <li  <?php if($action == 'assignment-listing'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=assignment-listing';?>"><?php _e('Assignment','EDULMS');?></a></li>
				  <li  <?php if($action == 'course-badges'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=course-badges';?>"><?php _e('Badges','EDULMS');?></a></li>
                  <li  <?php if($action == 'course-general-options'){echo 'class="active"';}?>><a href="<?php echo ''.$url.'&amp;action=course-general-options';?>"><?php _e('General Options','EDULMS');?></a></li>
				  <?php 
			  }
			  ?>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content reports-content">
            <script type="text/javascript" language="javascript" class="init">
				jQuery(document).ready(function($) {
					$('#revenue,#revenue2,#revenue3,#revenue4').DataTable();
				} );
			</script>
			<?php 
			if($action == 'statement'){
				$array_months = $this->cs_report_unique_months();
				arsort($array_months);
			?>
			  <div class="tab-pane active" id="statement">
				<div class="tab-title"><h3><?php _e('Statement','EDULMS');?></h3></div>
				<label> 
					<select name="cs_statement_start_date" id="cs_statement_start_date" aria-controls="revenue" onchange="cs_user_statements_date_value(this.value,'<?php echo esc_js($url);?>')">
						<option value=""><?php _e('-- Sort By --','EDULMS');?></option>
						<option value="30" <?php if($sort_by == 30){echo 'selected';}?>><?php _e('Last 30 Days','EDULMS');?></option>
						<?php 
						if(isset($array_months) && is_array($array_months) && count($array_months)>0){
							foreach($array_months as $array_months_values){
								$option_value = date_i18n('Ym',strtotime($array_months_values));
								$selected = '';
								if($sort_by == $option_value){$selected = 'selected';}
								echo '<option value="'.$option_value.'" '.$selected.'>'.date_i18n('F-Y',strtotime($array_months_values.'01')).'</option>';
							}
						}
						?>
					</select>
				</label>
				<table id="revenue" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _e('Date / Time','EDULMS');?></th>
							<th><?php _e('Transaction Id','EDULMS');?></th>
							<th><?php _e('Order Id','EDULMS');?></th>
							<th><?php _e('Payment Method','EDULMS');?></th>
							<th><?php _e('Course Name','EDULMS');?></th>
							<th><?php _e('Students','EDULMS');?></th>
							<th><?php _e('Amount','EDULMS');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$user_course_ids_data = array();
						$cs_course_register_option = array();
						$cs_course_register_option = get_option("cs_course_register_option", true);
						if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
							$cs_course_register_option = array();	
						}
						if(isset($cs_course_register_option['cs_user_ids_option']))
							$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
						if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
							foreach ($user_course_ids_data as $user_key=>$user_login) {
							if($user_key){
								$course_user_meta_array = get_option($user_key."_cs_course_data", true);
								if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
									foreach($course_user_meta_array as $course_id=>$course_values){
										$transaction_id = $course_values['transaction_id'];
										if($course_id){
											$user_course_data = get_option($course_id."_cs_user_course_data", true);
											$course_info = $this->cs_user_course_data_info($user_key, $course_id);
											$user_id  = $user_key;
											if(isset($course_info) && is_array($course_info) && count($course_info)>0){	
											$course_id = $course_info['course_id'];
											if(isset($course_info['user_display_name']))
												$user_display_name = $course_info['user_display_name'];
											else 
												$user_display_name = '';
												$transaction_id = $course_info['transaction_id'];
												$register_date = $course_info['register_date'];
												if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by'] <> ''){
													date_default_timezone_set('UTC');
													$current_time = current_time('Y-m-d H:i:s', $gmt = 0);
													if($sort_by == '30')	{
														$previous_date = date_i18n('Y-m-d H:i:s',(strtotime ( '-30 day' , strtotime ( $current_time) ) ));
														if(strtotime($register_date)<strtotime($previous_date))
															continue;
													} else {
														$current_year = $sort_by;
														$previous_date = date_i18n('Ym',strtotime ($register_date));
														if(strtotime($previous_date)<>strtotime($sort_by))
															continue;
													}
												}
												$order_id = $course_price = '';
												if(isset($course_info['order_id']))
													$order_id = $course_info['order_id'];
												if(isset($course_info['course_price']))
													$course_price = $course_info['course_price'];
												$payment_method_title = $course_info['payment_method_title'];
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
												$course_title = get_the_title($course_id);
												if($post_status == 'publish')	{
													
													$course_title = '<a href="'.get_permalink($course_id).'" target="_blank">'.get_the_title($course_id).'</a>';
												}  else {
													if(isset($course_info['course_title'])) $course_title = $course_info['course_title'];
												}
												?>
												<tr>
													<td><?php echo esc_attr($register_date);?></td>
													<td><?php echo esc_attr($transaction_id);?></td>
													<td><?php echo esc_attr($order_id);?></td>
													<td><?php echo esc_attr($payment_method_title);?></td>
													<td><?php echo esc_attr($course_title);?></td>
													<td><a href="<?php echo esc_url(admin_url('user-edit.php?user_id=').$user_id);?>" target="_blank"><?php echo esc_attr($user_display_name);?></a></td>
													<td><?php echo esc_attr($course_price);?></td>
												</tr>	
												<?php							
											}
										 }
										}
									}
								}
							}
						}
					 ?>
					</tbody>
				</table>
			  </div>
			 <?php 
			}
			 else if($action == 'instructor'){
				$user_instructors_ids_data = array();
				$cs_course_register_option = array();
				$cs_course_register_option = get_option("cs_course_register_option", true);
				$instructors_ids = array();
				if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
					$cs_course_register_option = array();	
				}
				if(isset($cs_course_register_option['cs_course_instructor_ids_option']))
					$user_instructors_ids_data = @$cs_course_register_option['cs_course_instructor_ids_option'];
		
				foreach ($blogusers as $user) {
					$user_id = $user->ID;
					$user_instructors_ids_data[$user_id] = $user->user_login;
				}
		
				?>
				  <div id="profile">
					<table id="revenue2" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php _e('Instructor Name','EDULMS');?></th>
								<th><?php _e('Instructor Id','EDULMS');?></th>
								<th><?php _e('Courses #','EDULMS');?></th>
								<th><?php _e('Students #','EDULMS');?></th>
							</tr>
						</thead>
						<tbody>
						   <?php
							if(isset($user_instructors_ids_data) && is_array($user_instructors_ids_data) && count($user_instructors_ids_data)>0){	
								foreach ($user_instructors_ids_data as $user_key=>$user_value) {
									if($user_key){
										$instructor_data = $this->cs_get_no_instructor_users($user_key,$user_value);
									?>
									<tr>
										<td><?php echo esc_attr($user_value);?></td>
										<td><a href="<?php echo get_edit_user_link($user_key);?>" target="_blank"><?php echo esc_attr($user_key);?></a></td>
										<td><?php if(isset($instructor_data['count_post']))echo esc_attr($instructor_data['count_post']);?></td>
										<td><?php if(isset($instructor_data['count_students']))echo esc_attr($instructor_data['count_students']);?></td>
									</tr>
								   <?php 
									}
								}
							}
							?>
						</tbody>
					</table>
				  </div>
				<?php 
			 }
			 else if($action == 'revenue'){
			?> 
			  <div id="settings">
			  <div class="tab-title"><h3><?php _e('Course /Revenue','EDULMS');?></h3></div>
				<table id="revenue3" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _e('Course Name','EDULMS');?></th>
							<th><?php _e('Sales','EDULMS');?></th>
							<th><?php _e('Students','EDULMS');?></th>
							<th><?php _e('Earnings','EDULMS');?></th>
						</tr>
					</thead>
					<tbody>
						<?php $this->cs_get_revenue_reports();?>
					</tbody>
				</table>
			  </div>
			 <?php 
			 }
			 else if($action == 'quiz-listing'){
				 do_action('cs_quiz_listing_report_before');
				 do_action('cs_quiz_listing_report');
				 do_action('cs_quiz_listing_report_after');
			 }
			 else if($action == 'assignment-listing'){
				 do_action('cs_assignment_listing_report_before');
				 do_action('cs_assignment_listing_report');
				 do_action('cs_assignment_listing_report_after');
			 }
			 else if($action == 'course-badges'){
				 
				$display='none';
				$output = '';
				$cs_badges_list	=  get_option('cs_badges');
				if (isset($cs_badges_list) and $cs_badges_list <> '') {
					
					$display='none';
					if(!isset($cs_badges_list['badges_net_icons'])){
						$badges_list='';
						$display='none';
					}
					else{
						$badges_list = $cs_badges_list['badges_net_icons'];
						$icons_short_name = $cs_badges_list['badges_net_icons_short_name'];
						$icons_paths = $cs_badges_list['badges_net_icons_paths'];
						$display='block';	
					}
				}
				
				$output.='
				<div class="outerwrapp-layer">
					<div class="loading_div">
						<i class="fa fa-circle-o-notch fa-spin"></i>
						<br>"'.__('Saving Badges...','EDULMS').'" 
					</div>
					<div class="form-msg">
						<i class="fa fa-check-circle-o"></i>
						<div class="innermsg"></div>
					</div>
			   </div>
			  <form id="bdg_form" method="post"><ul class="form-elements">
							<li class="to-label">
							  <label>'.__('Title','EDULMS').'</label>
							</li>
							<li class="to-field">
							  <input class="small" type="text" id="badges_net_icons_input" />
							  <label>'.__('Please enter text for Badge','EDULMS').'</label>
							</li>
							
							</ul>
							<ul class="form-elements">
							<li class="to-label">
							  <label>'.__('Short Text','EDULMS').'</label>
							</li>
							<li class="to-field">
							  <input class="small" type="text" id="badges_net_icons_short_name_input"  />
							  <label>'.__('Please enter Short Text','EDULMS').'</label>
							</li>
							
							</ul>
							<ul class="form-elements">
							<li class="to-label">
							  <label>'.__('Badge Image','EDULMS').'</label>
							</li>
							<li class="to-field">
							<div class="input-sec">
							  <input id="badges_net_icons_paths_input" type="hidden" class="small" />
							</div>
							<div class="page-wrap" style="overflow:hidden; display:none" id="badges_net_icons_paths_input_box" >
							  <div class="gal-active">
								<div class="dragareamain" style="padding-bottom:0px;">
								  <ul id="gal-sortable">
									<li class="ui-state-default" id="">
									  <div class="thumb-secs"> <img src=""  id="badges_net_icons_paths_input_img" width="100" height="150"  />
										<div class="gal-edit-opts"> <a   href="javascript:del_media(\'badges_net_icons_paths_input\')" class="delete"></a> </div>
									  </div>
									</li>
								  </ul>
								</div>
							  </div>
							</div>
							  <label class="browse-icon"><input id="badges_net_icons_paths_input" name="badges_net_icons_paths_input" type="button" class="uploadMedia left" value="'.__('Browse','EDULMS').'"/></label>
						   </li>
						   </ul>
						   <ul class="form-elements">
							
							<li class="to-label" style="width:50%;">
							  <span class="badge_spiner" style="display:none"><i class="fa fa-circle-o-notch fa-spin"></i></span>
							  <input type="button" value="Add" onclick=javascript:cs_add_badges("'.admin_url("admin-ajax.php").'") style="float:left;" />
							</li>
						  </ul>
						  <div class="clear"></div>
						  <div class="badges-area" style="display:'.$display.'">
						  <div class="theme-help" style="display:none">
							<h4 style="padding-bottom:0px;">'.__('Already Added Badges','EDULMS').'</h4>
							<div class="clear"></div>
						  </div>
						  <div class="boxes">
						  <table class="to-table" border="0" cellspacing="0">
							  <thead>
								<tr>
								  <th>'.__('Badge Image','EDULMS').'</th>
								  <th>'.__('Short Text','EDULMS').'</th>
								  <th>'.__('Name','EDULMS').'</th>
								  <th class="centr">'.__('Actions','EDULMS').'</th>
								</tr>
							  </thead>
							  <tbody id="badges_area">';
						  $i=0;
						  if( isset( $badges_list ) && $badges_list<> '' ){
							  foreach($badges_list as $badges){
								  if(isset($badges_list[$i]) || isset($badges_list[$i])){
											  $output.='<tr id="del_'.str_replace(' ','-',$badges_list[$i]).'"><td>';
											  if(isset($icons_paths[$i]) and $icons_paths[$i]<>''){
											  $output .= '<img width="50" src="' .$icons_paths[$i]. '">';
											  }else{
												 $output.=''; 
											  }
											  $output .= '</td><td>'.$icons_short_name[$i].'</td>';
											  $output .= '<td>'.$badges_list[$i].'</td>';
											  $output .= '<td class="centr"> 
															  <a class="remove-btn" onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del(\''.str_replace(' ','-',$badges_list[$i]).'\')" data-toggle="tooltip" data-placement="top" title="Remove">
															  <i class="fa fa-times"></i></a>
															  <a href="javascript:cs_toggle(\''.str_replace(' ','-',$badges_list[$i]).'\')" data-toggle="tooltip" data-placement="top" title="Edit">
																<i class="fa fa-edit"></i>
		
															  </a>
														  </td></tr>';
											$output.='<tr id="'.str_replace(' ','-',$badges_list[$i]).'" style="display:none">
													  <td colspan="3"><ul class="form-elements">
													  <li><a onclick="cs_toggle(\''.str_replace(' ','-',$badges_list[$i]).'\')"><i class="fa fa-times"></i></a></li>
															<li class="to-label">
															<label>"'.__('Title','EDULMS').'"</label>
														  </li>
														  <li class="to-field">
															<input class="small" type="text" id="badges_net_icons" name="badges_net_icons[]" value="'.$badges_list[$i].'"  />
															<p>"'.__('Please enter text for Badge Name','EDULMS').'"</p>
														  </li>
														  <li class="full">&nbsp;</li>
														  <li class="to-label">
															<label>"'.__('Short Text','EDULMS').'"</label>
														  </li>
														  <li class="to-field">
															<input class="small" type="text" id="badges_net_icons_short_name" name="badges_net_icons_short_name[]" value="'.$icons_short_name[$i].'"/>
															<p>"'.__('Please enter Short Text','EDULMS').'"</p>
														  </li>
														  <li class="full">&nbsp;</li>
														  <li class="to-label">
															<label>"'.__('Badge Image','EDULMS').'"</label>
														  </li>
														  <li class="to-field">
															<input id="badges_net_icons_paths'.$i.'" name="badges_net_icons_paths[]" value="'.$icons_paths[$i].'" type="text" class="small" />
															<label class="browse-icon"><input id="badges_net_icons_paths'.$i.'" name="badges_net_icons_paths'.$i.'" type="button" class="uploadMedia left" value="'.__('Browse','EDULMS').'"/></label>
														  </li>
														  <li class="full">&nbsp;</li>
														</ul></td>
													</tr>';
									  }
								  $i++;
								 }
						  }
						  
				$output .= '</tbody></table></div></div>';
				echo balanceTags($output, false);
				?>
				 <div class="footer">
					<input type="button" id="submit_btn" name="submit_btn" class="bottom_btn_save" value="<?php _e('Save Badges', 'EDULMS');?>" onclick="javascript:cs_badge_save('<?php echo esc_js(admin_url('admin-ajax.php'));?>', '<?php echo esc_js(get_template_directory_uri());?>');" />
					<input type="hidden" name="action" value="cs_badge_save"  />
					</form>
				   
				</div>
				<?php  
			}
			else if($action == 'course-general-options'){
				
			global $cs_theme_options,$cs_course_options;
			$cs_course_options =$cs_course_options;
			if(!isset($cs_course_options) || empty($cs_course_options) || !is_array($cs_course_options)){
				$cs_course_options = array('cs_dashboard'=>'','cs_currency_symbol'=>'$','cs_review_status'=>'Pending');	
			}
			?>
			<script type="text/javascript" language="javascript" class="init">
				jQuery(document).ready(function($) {
					$('#revenue,#revenue2,#revenue3,#revenue4').DataTable();
				} );
			</script>
				<?php 
                    global $wp;
					$url = admin_url('edit.php?post_type=courses&page=quiz_assignments_listing_page');
                    //$url = admin_url('edit.php?post_type=courses&page=cs_course_options');
                    $args = array(
                              'depth'            => 0,
                              'child_of'     => 0,
                              'sort_order'   => 'ASC',
                              'sort_column'  => 'post_title',
                              'show_option_none' => 'Please select a page',
                              'hierarchical' => '1',
                              'exclude'      => '',
                              'include'      => '',
                              'meta_key'     => '',
                              'meta_value'   => '',
                              'authors'      => '',
                              'exclude_tree' => '',
                              'selected'         => $cs_course_options['cs_dashboard'],
                              'echo'             => 0,
                              'name'             => 'cs_dashboard',
                              'post_type' => 'page'
                          );
                ?>
                    <!-- Nav tabs -->
               
                      <div class="tab-pane active" id="statement">
                        <div class="tab-title"><h3><?php _e('Course Options','EDULMS');?></h3></div>
                        <div class="outerwrapp-layer">
                            <div class="loading_div">
                                <i class="fa fa-circle-o-notch fa-spin"></i>
                                <br> <?php _e('Saving Course Options...','EDULMS');?>
                            </div>
                            <div class="form-msg">
                                <i class="fa fa-check-circle-o"></i>
                                <div class="innermsg"></div>
                            </div>
                       </div>
                        <form id="course_options_form" name="course_options" method="post" >
                        
                        <ul class="form-elements">
                        <li class="to-label"><label><?php _e('User Profile Page','EDULMS');?><span><?php _e('Select page for user profile here','EDULMS');?></span></label></li>
                        <li class="to-field">
                            <div class="select-style">
                                <?php echo wp_dropdown_pages($args);?>
                             </div>
                          </li>
                        </ul>
                        <ul class="form-elements" id="cs_review_status_select">
                            <li class="to-label"><label><?php _e('Review Status','EDULMS');?><span><?php _e('Select Review Status','EDULMS');?></span></label></li>
                            <li class="to-field">
                            <div class="input-sec">
                                    <div class="select-style">
                                    <select name="cs_review_status" id="cs_review_status">
                                        <option <?php if(isset($cs_course_options['cs_review_status']) && $cs_course_options['cs_review_status']  == 'Pending') echo 'selected="selected"';?> value="Pending"></option>
                                        <option <?php if(isset($cs_course_options['cs_review_status']) && $cs_course_options['cs_review_status']  == 'Aproved') echo 'selected="selected"';?> value="Aproved"></option>
                                    </select>
                                   </div>
                             </div>
                             <div class="left-info">
                             	<p></p>
                             </div>
                            </li>
                         </ul>
                        <ul id="cs_currency_symbol_textfield" class="form-elements">
                            <li class="to-label">
                                <label><?php _e('Currency','EDULMS');?><span><?php _e('Set currency symbol like($,£,¥)','EDULMS');?></span></label>
                            </li>
                            <li class="to-field"><input type="text" class="vsmall" value="<?php echo esc_attr($cs_course_options['cs_currency_symbol']);?>" id="cs_currency_symbol" name="cs_currency_symbol"><p></p></li>
                       </ul>
                 
                         <div class="footer">
                            <input type="button" id="submit_btn" name="submit_btn" class="bottom_btn_save" value="<?php _e('Save Options','EDULMS');?>" onclick="javascript:cs_course_options_save('<?php echo esc_js(admin_url('admin-ajax.php'))?>');" />
                            <input type="hidden" name="action" value="cs_course_options"  />
                            
                           
                        </div>
                        </form>
                     </div>
                   
               
                <?php
			}
			
			?>
			 </div>
		</div>
		<?php
	}
	
	
	//======================================================================
	// Get Course Information
	//======================================================================

	public function cs_user_course_data_info($userID='', $course_id=''){
			$course_info = array();
			$uid = $userID;
					if($course_id){
						//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
						$user_course_data = get_option($course_id."_cs_user_course_data", true);
						if(is_array($user_course_data) && count($user_course_data) > 0){
							$user_course_data_array = array_reverse($user_course_data) ;
							$key = array_search($uid, $user_course_data_array);
							$course_info = $user_course_data[$key];
							$course_key = '';
							foreach ( $user_course_data_array as $key=>$members ){
								if($uid == $members['user_id']){
									$course_key = $key;
									break;
								}
							}
							$course_info = array();
							if($course_key || $course_key == 0){
								$course_price = '';
								if(isset($user_course_data_array[$course_key]) && is_array($user_course_data_array[$course_key])){
									$course_info = $user_course_data_array[$course_key];
								 }
							}
						}
					}
			return $course_info;
		}

	
	//======================================================================
	// Get User Course Information
	//======================================================================
	
	public function cs_user_course_info($userID){
			$course_info = array();
			$uid = $userID;
			$course_user_meta_array = get_option($userID."_cs_course_data", true);
			if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
				foreach($course_user_meta_array as $course_id=>$course_values){
					$transaction_id = $course_values['transaction_id'];
					if($course_id){
						$user_course_data = get_option($course_id."_cs_user_course_data", true);
						if(is_array($user_course_data) && count($user_course_data)>0){
							$user_course_data_array = array_reverse($user_course_data) ;
							$key = array_search($uid, $user_course_data_array);
							$course_info = $user_course_data[$key];
							$course_key = '';
							foreach ( $user_course_data_array as $key=>$members ){
								if($uid == $members['user_id']){
									$course_key = $key;
									break;
								}
							}
							$course_info = array();
							if($course_key || $course_key == 0){
								$course_price = '';
								if(isset($user_course_data_array[$course_key]) && is_array($user_course_data_array[$course_key])){
									$course_info = $user_course_data_array[$course_key];
								 }
							}
						}
					}
				}
			}
			return $course_info;
		}
	
	//======================================================================
	// Course Total Earnings
	//======================================================================
	public function cs_courses_total_earnings(){
		$user_course_ids_data = array();
		$cs_course_register_option = array();
		$cs_course_register_option = get_option("cs_course_register_option", true);
		if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
			$cs_course_register_option = array();	
		}
		$coutner = 0;
		$course_earning_array = array();
		$total_earnings = 0;
		if(isset($cs_course_register_option['cs_user_ids_option']))
			$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
		if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
			foreach ($user_course_ids_data as $user_key=>$user_login) {
			if($user_key){
				$course_user_meta_array = get_option($user_key."_cs_course_data", true);
				if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
					foreach($course_user_meta_array as $course_id=>$course_values){
						$transaction_id = $course_values['transaction_id'];
						if($course_id){
							$user_course_data = get_option($course_id."_cs_user_course_data", true);
							$course_info = $this->cs_user_course_data_info($user_key, $course_id);
							$user_id  = $user_key;
							if(isset($course_info) && is_array($course_info) && count($course_info)>0){
								$coutner++;
								$course_price = 0;
								
								if(isset($course_info['course_price']))
									$course_price = (int)$course_info['course_price'];
									if(!isset($course_info['course_price']) || (isset($course_info['course_price']) && empty($course_info['course_price']))){
										$cs_course = get_post_meta($course_id, "cs_course", true);
										if ( $cs_course <> "" ) {
											$cs_xmlObject = new SimpleXMLElement($cs_course);
											$var_cp_course_product = $cs_xmlObject->var_cp_course_product;
											$product_status = get_post_status( (int)$var_cp_course_product );
											if($product_status=='publish'){
												$course_price = (int)cs_get_product_price((int)$var_cp_course_product);
											}
										}
									}
									
									$total_earnings = $total_earnings+$course_price;
							}
						}
					}
				 }
				}
			}
		  }
		 $course_earning_array['total_members'] =  $coutner;
		 $course_earning_array['total_earning'] =  $total_earnings;
		return $course_earning_array;
	}
	
	//======================================================================
	// Get no of uses for Instructor
	//======================================================================
	public function cs_get_no_instructor_users($userid,$user_value){
			global $post;
			$instructor_data = array();
			$args = array(
						'posts_per_page'			=> "-1",
						'paged'						=> "1",
						'post_type'					=> 'courses',
						'post_status'				=> 'publish',
						'meta_key'					=> "var_cp_course_instructor",
						'meta_value'				=> $userid,
						'meta_compare'				=> '=',
						'orderby'					=> 'meta_value',
						'order'						=> 'ASC',
					);
			$custom_query = new WP_Query($args);
			$instructor_data['count_post'] = $custom_query->post_count;
			$count_students = 0;
			if ( $custom_query->have_posts() <> "" ) {
				while ( $custom_query->have_posts() ): $custom_query->the_post();
					$user_course_data = get_option($post->ID."_cs_user_course_data", true);
					if(isset($user_course_data) && is_array($user_course_data) && !empty($user_course_data)){
						$user_course_data_array = array_reverse($user_course_data) ;
						$user_array = array();
						foreach($user_course_data_array as $key=>$value){
							if($value['user_id'])
								$user_array[] = $value['user_id'];
						}
						$count_students = $count_students+$this->cs_get_instrucotors_users($user_array,$user_value);
					}
				endwhile;
			}
			$instructor_data['count_students'] = $count_students;
			return $instructor_data;
	}
	
	//======================================================================
	// User Course Data
	//======================================================================
	
	public function cs_get_user_course_data($user_course_data, $instructor_name=''){
			if(is_array($user_course_data) && count($user_course_data)>0){
				$user_course_data_array = array_reverse($user_course_data) ;
				$key = array_search($uid, $user_course_data_array);
				$course_info = $user_course_data[$key];
				$course_key = '';
				foreach ( $user_course_data_array as $key=>$members ){
					if($uid == $members['user_id']){
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
					}
				}
			}
		}
	
	
	//======================================================================
	// User Instructors
	//======================================================================
	
	public function cs_get_instrucotors_users($user_array = array(), $instructor_name = ''){
			global $post;
			$count_students = 0;
			if(count($user_array)>0 && $instructor_name <> '')
				foreach($user_array as $userID){
					$course_user_meta_array = get_option($userID."_cs_course_data", true);
					if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
						foreach($course_user_meta_array as $course_id=>$course_values){
							if(isset($course_values['course_instructor']))
							$course_instructor = $course_values['course_instructor'];
							if($course_instructor == $instructor_name && $course_id==$post->ID){
								$count_students++;
							}
						}
					}
				}
				return $count_students;
		}


	//======================================================================
	// Courses Revenue Reprot
	//======================================================================
	
	public function cs_get_revenue_reports(){
			global $post;
			$instructor_data = array();
		
			$course_ids_data = array();
			$cs_course_register_option = array();
			$cs_course_register_option = get_option("cs_course_register_option", true);
			if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
				$cs_course_register_option = array();	
			}
			if(isset($cs_course_register_option['cs_course_ids_option']))
				$course_ids_data = @$cs_course_register_option['cs_course_ids_option'];
		
			if(isset($course_ids_data) && is_array($course_ids_data) && count($course_ids_data)>0){
				foreach($course_ids_data as $course_id=>$course_title){
					if($course_id){
						//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
						$user_course_data = get_option($course_id."_cs_user_course_data", true);
						//update_option($course_id."_cs_user_course_data", $user_course_data);
						if(isset($user_course_data) && is_array($user_course_data) && !empty($user_course_data)){
							$user_course_data_array = array_reverse($user_course_data) ;
							
							
							
							$user_array = array();
							$course_earning_array = array();
							foreach($user_course_data_array as $key=>$value){
								if($value['user_id']){
									$user_array[] = $value['user_id'];
									if(!in_array($value['user_id'], $course_earning_array))
										$course_earning_array[] = $value;
								}
							}
							$user_unique_array = array_unique($user_array);
							$count_price = 0;
							if($course_earning_array){
								foreach($course_earning_array as $course_value){
									if(isset($course_value['course_price']) && $course_value['course_price'] <> ''){
										$count_price = $count_price+(int)$course_value['course_price'];
									}
								}
							}
							?>
								 <tr>
									<td><a href="<?php echo get_permalink((int)$course_id);?>" target="_blank"><?php echo esc_attr($course_title);?></a></td>
									<td><?php echo count($user_course_data_array);?></td>
									<td><?php echo count($user_unique_array);?></td>
									<td>$<?php echo esc_attr($count_price);?></td>
								</tr>
							<?php
							
						}
					}
				}
			}
		}


	//======================================================================
	// Members Registeration Unique Months, Years
	//======================================================================
	public function cs_report_unique_months(){
			$user_course_ids_data = array();
			$cs_course_register_option = array();
			$cs_course_register_option = get_option("cs_course_register_option", true);
			if(isset($cs_course_register_option) && !is_array($cs_course_register_option)){
				$cs_course_register_option = array();	
			}
			if(isset($cs_course_register_option['cs_user_ids_option']))
				$user_course_ids_data = @$cs_course_register_option['cs_user_ids_option'];
			$user_registeration_months = array();
			if(isset($user_course_ids_data) && is_array($user_course_ids_data) && count($user_course_ids_data)>0){	
				foreach ($user_course_ids_data as $user_key=>$user_login) {
					if($user_key){
						$course_user_meta_array = get_option($user_key."_cs_course_data", true);
						if(isset($course_user_meta_array) && is_array($course_user_meta_array) && count($course_user_meta_array)>0){
							foreach($course_user_meta_array as $course_id=>$course_values){
								$transaction_id = $course_values['transaction_id'];
								if($course_id){
									//$user_course_data = get_post_meta($course_id, "cs_user_course_data", true);
									$user_course_data = get_option($course_id."_cs_user_course_data", true);
									$course_info = $this->cs_user_course_data_info($user_key, $course_id);
									$user_id  = $user_key;
									if(isset($course_info) && is_array($course_info) && count($course_info)>0){	
										$register_date = $course_info['register_date'];
										$register_date_key = date_i18n('Ym',strtotime ($register_date));
										$user_registeration_months[] = $register_date_key;
									}
								}
							}
						}
					}
				}
				$user_registeration_months = array_unique($user_registeration_months);
			}
			return $user_registeration_months;
		}
  
  }
}

if(class_exists('cs_settings')){
	$settings_object = new cs_settings();
	//$settings_object->cs_datatables_enqueue();
	require_once ('reports-functions.php');
	add_action('admin_menu', array(&$settings_object, 'cs_register_quiz_assignments_menu_page'));
	// Save Badges
	

}