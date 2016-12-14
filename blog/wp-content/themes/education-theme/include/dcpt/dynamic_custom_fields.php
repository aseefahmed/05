<?php
// RenderDynamic Custom Fields
if ( ! function_exists( 'cs_dynamic_custom_fields' ) ) {
	function cs_dynamic_custom_fields(){
		global $post;
		?>
			<div class="inside-tab-content">
				<h3><?php _e('Custom Fields','LMS');?></h3>
				<div class="row">
				<div class="col-md-4">
					<h4><?php _e('Click To add Item','LMS');?></h4>
					<div class="pb-form-buttons">
						<a href="javascript:ajaxSubmit('cs_pb_text')" title="Text" data-type="text" data-name="custom_text"><i class="fa fa-file-text"></i><?php _e('Text','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_textarea')" title="Textarea" data-type="textarea" data-name="custom_textarea"><i class="fa fa-heart"></i><?php _e('Textarea','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_dropdown')" title="Dropdown" data-type="select" data-name="custom_select"><i class="fa fa-list"></i><?php _e('Dropdown','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_checkbox')" title="Dropdown" data-type="select" data-name="custom_select"><i class="fa fa-list"></i><?php _e('Checkbox','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_date')" title="Date" data-type="date" data-name="custom_date"><i class="fa fa-calendar"></i><?php _e('Date','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_email')" title="Email" data-type="email" data-name="custom_email"><i class="fa fa-mail"></i><?php _e('Email','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_radio')" title="Radio" data-type="radio" data-name="custom_radio"><i class="fa fa-mail"></i><?php _e('Radio','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_multiselect')" title="Multiselect" data-type="multiselect" data-name="custom_multiselect"><i class="fa fa-mail"></i><?php _e('Multi select','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_url')" title="URL" data-type="url" data-name="custom_url"><i class="fa fa-mail"></i><?php _e('Url','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_hiddenfield')" title="hiddenfield" data-type="hiddenfield" data-name="custom_hiddenfield"><i class="fa fa-mail"></i><?php _e('Hidden Field','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_imageupload')" title="Image" data-type="image" data-name="custom_image"><i class="fa fa-mail"></i><?php _e('Image upload','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_fileupload')" title="URL" data-type="url" data-name="custom_url"><i class="fa fa-mail"></i><?php _e('File Upload','LMS');?></a>
						<!--<a href="javascript:ajaxSubmit('cs_pb_repeatfield')" title="URL" data-type="url" data-name="custom_url"><i class="fa fa-mail"></i>Repeat Field</a>-->
						<a href="javascript:ajaxSubmit('cs_pb_googlemap')" title="URL" data-type="url" data-name="custom_url"><i class="fa fa-mail"></i><?php _e('Google Map','LMS');?></a>
						<a href="javascript:ajaxSubmit('cs_pb_custom_post_type')" title="custom_post_type" data-type="custom_post_type" data-name="custom_custom_post_type"><i class="fa fa-mail"></i><?php _e('Post Type Dropdown','LMS');?></a>
					</div>
				</div>
				<div id="pb-formelements" class="col-md-8">
				<?php
					global $cs_node, $cs_count_node, $cs_xmlObject;
					$cs_count_node = 0;
					$count_widget = 0;
					$cs_dcpt_custom_fields = get_post_meta($post->ID, "cs_dcpt_custom_fields", true);
					if ( $cs_dcpt_custom_fields <> "" ) {
						$cs_xmlObject = new stdClass();
						$cs_xmlObject = new SimpleXMLElement($cs_dcpt_custom_fields);
							foreach ( $cs_xmlObject->children() as $cs_node ){
								if ( $cs_node->getName() == "text" ) {$cs_count_node++; cs_pb_text(1); }
								else if ( $cs_node->getName() == "textarea" ) {$cs_count_node++; cs_pb_textarea(1);}
								else if ( $cs_node->getName() == "dropdown" ) {$cs_count_node++; cs_pb_dropdown(1);}
								else if ( $cs_node->getName() == "checkbox" ) {$cs_count_node++; cs_pb_checkbox(1); }
								else if ( $cs_node->getName() == "date" ) {$cs_count_node++; cs_pb_date(1);}
								else if ( $cs_node->getName() == "email" ) {$cs_count_node++; cs_pb_email(1);}
								else if ( $cs_node->getName() == "radio" ) {$cs_count_node++; cs_pb_radio(1);}
								else if ( $cs_node->getName() == "multiselect" ) {$cs_count_node++; cs_pb_multiselect(1);}
								else if ( $cs_node->getName() == "url" ) {$cs_count_node++; cs_pb_url(1);}
								else if ( $cs_node->getName() == "hiddenfield" ) {$cs_count_node++; cs_pb_hiddenfield(1);}
								else if ( $cs_node->getName() == "image" ) {$cs_count_node++; cs_pb_imageupload(1);}
								else if ( $cs_node->getName() == "fileupload" ) {$cs_count_node++; cs_pb_fileupload(1);}
								else if ( $cs_node->getName() == "googlemap" ) {$cs_count_node++; cs_pb_googlemap(1);}
								else if ( $cs_node->getName() == "custom_post_type" ) {$cs_count_node++; cs_pb_custom_post_type(1);}
								//custom_post_type
							 }
					}
				?>
				 <div class="alert alert-warning" id="pbwp-alert"><?php _e('Please Insert Items','LMS');?></div>
				<input type="hidden" name="custom_fields_elements" value="1" />
			</div>
		</div>
			<script type="text/javascript">
				jQuery(function() {
				   cs_custom_fields_js();
				});
				var counter = <?php echo esc_js($cs_count_node); ?>;
				function ajaxSubmit(action){
					counter++;
					var newCustomerForm = "action=" + action + '&counter=' + counter;
					jQuery.ajax({
						type:"POST",
						url: "<?php echo esc_js(admin_url('admin-ajax.php'));?>",
						data: newCustomerForm,
						success:function(data){
							jQuery("#pb-formelements").append(data);
							 alertbox()
							if (count_widget > 0) jQuery("#pb-formelements").addClass('hasclass');
						}
					});
					//return false;
				}
			</script>   
			</div>
		<?php
	}
}
// Save Custom Fields
if ( ! function_exists( 'cs_custom_fields_elements_save' ) ) {
	if ( isset($_POST['custom_fields_elements']) and $_POST['custom_fields_elements'] == 1 ) {
		add_action( 'save_post', 'cs_custom_fields_elements_save' );
		function cs_custom_fields_elements_save( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( isset($_POST['custom_fields_elements']) ) {
				$cs_counter = 0;
				$cs_field_counter = 0;
				$cs_counter_text = 0;
				$cs_counter_dropdown = 0;
				$cs_counter_textarea = 0;
				$cs_counter_checkbox =0;
				$cs_counter_email = 0;
				$cs_counter_date = 0;
				$cs_counter_multiselect = 0;
				$cs_counter_radio = 0;
				$cs_counter_image = 0;
				$cs_counter_url = 0;
				$cs_counter_hiddenfield = 0;
				$cs_counter_repeatfield = 0;
				$cs_counter_googlemap = 0;
				$cs_counter_custom_post_type = 0;
				$cs_counter_fileupload = 0;
				$sxe = new SimpleXMLElement("<customfieldsbuilder></customfieldsbuilder>");
				$sxe->addChild('custom_fields_elements', $_POST['custom_fields_elements'] );
				
				if(isset($_POST['cs_customfield_order'])){
					foreach ( $_POST['cs_customfield_order'] as $count ){
					$cs_counter++;
					if ( $_POST['cs_customfield_order'][$cs_field_counter] == "text" ) {
						$text = $sxe->addChild('text');
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						foreach ( $_POST['text'] as $text_key=>$text_value ){
							$text->addChild($text_key, trim($text_value[$cs_counter_text]) );
						}
						$cs_counter_text++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "textarea" ) {
						$textarea = $sxe->addChild('textarea');
						foreach ( $_POST['textarea'] as $textarea_key=>$textarea_value ){
							$textarea->addChild($textarea_key, trim($textarea_value[$cs_counter_textarea]) );
						}
						if ( isset($_POST['cs_customfield_order'][$cs_field_counter])){
								$cs_custom_field_id = $_POST['cs_customfield_order'][$cs_field_counter];
						}
						$textarea->addChild('cs_customfield_editor', $_POST['textarea_rich']['cs_customfield_editor'][$cs_custom_field_id][0] );
						$cs_counter_textarea++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "dropdown" ) {
						$dropdown = $sxe->addChild('dropdown');
						foreach ( $_POST['dropdown'] as $dropdown_key=>$dropdown_value ){
							$dropdown->addChild($dropdown_key, $dropdown_value[$cs_counter_dropdown] );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						$dropdown->addChild('selected', $_POST['cs_dropdown_option']['selected'][$cs_custom_field_id][0] );
						
						foreach ( $_POST['cs_dropdown_option']['options'][$cs_custom_field_id] as $dropdown_key=>$dropdown_value ){
							$dropdown->addChild('options', trim($dropdown_value) );
						}
						foreach ( $_POST['cs_dropdown_option']['options_values'][$cs_custom_field_id] as $dropdown_key=>$dropdown_value ){
							$dropdown->addChild('options_values', trim($dropdown_value) );
						}
						$cs_counter_dropdown++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "checkbox" ) {
						$checkbox = $sxe->addChild('checkbox');
						foreach ( $_POST['checkbox'] as $checkbox_key=>$checkbox_value ){
							$checkbox->addChild($checkbox_key, trim($checkbox_value[$cs_counter_checkbox]) );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						$checkbox->addChild('selected', $_POST['cs_checkbox_option']['selected'][$cs_custom_field_id][0] );
					
						foreach ( $_POST['cs_checkbox_option']['options'][$cs_custom_field_id] as $dropdown_key=>$checkbox_value ){
							$checkbox->addChild('options', trim($checkbox_value) );
						}
						foreach ( $_POST['cs_checkbox_option']['options_values'][$cs_custom_field_id] as $dropdown_key=>$checkbox_value ){
							$checkbox->addChild('options_values', trim($checkbox_value) );
						}
						$cs_counter_checkbox++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "multiselect" ) {
						$multiselect = $sxe->addChild('multiselect');
						foreach ( $_POST['multiselect'] as $multiselect_key=>$multiselect_value ){
							$multiselect->addChild($multiselect_key, trim($multiselect_value[$cs_counter_multiselect]) );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						
						$multiselect->addChild('selected', $_POST['cs_multiselect_option']['selected'][$cs_custom_field_id][0] );
						
						foreach ( $_POST['cs_multiselect_option']['options'][$cs_custom_field_id] as $multiselect_key=>$multiselect_value ){
							$multiselect->addChild('options', trim($multiselect_value) );
						}
						foreach ( $_POST['cs_multiselect_option']['options_values'][$cs_custom_field_id] as $multiselect_key=>$multiselect_value ){
							$multiselect->addChild('options_values', trim($multiselect_value) );
						}
						$cs_counter_multiselect++;	
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "email" ) {
						$email = $sxe->addChild('email');
						foreach ( $_POST['email'] as $email_key=>$email_value ){
							$email->addChild($email_key, trim($email_value[$cs_counter_email]) );
						}
						$cs_counter_email++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "date" ) {
						$date = $sxe->addChild('date');
						foreach ( $_POST['date'] as $date_key=>$date_value ){
							$date->addChild($date_key, trim($date_value[$cs_counter_date]) );
						}
						$cs_counter_date++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "radio" ) {
						$radio = $sxe->addChild('radio');
						foreach ( $_POST['radio'] as $radio_key=>$radio_value ){
							$radio->addChild($radio_key, trim($radio_value[$cs_counter_radio]) );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						
						$radio->addChild('selected', $_POST['cs_radio_option']['selected'][$cs_custom_field_id][0] );
						foreach ( $_POST['cs_radio_option']['options'][$cs_custom_field_id] as $radio_key=>$radio_value ){
							$radio->addChild('options', trim($radio_value) );
						}
						foreach ( $_POST['cs_radio_option']['options_values'][$cs_custom_field_id] as $radio_key=>$radio_value ){
							$radio->addChild('options_values', trim($radio_value) );
						}
						$cs_counter_radio++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "url" ) {
						$url = $sxe->addChild('url');
						foreach ( $_POST['url'] as $url_key=>$url_value ){
							$url->addChild($url_key, trim($url_value[$cs_counter_url]) );
						}
						$cs_counter_url++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "hiddenfield" ) {
						$hiddenfield = $sxe->addChild('hiddenfield');
						foreach ( $_POST['hiddenfield'] as $hiddenfield_key=>$hiddenfield_value ){
							$hiddenfield->addChild($hiddenfield_key, trim($hiddenfield_value[$cs_counter_hiddenfield]) );
						}
						$cs_counter_hiddenfield++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "image" ) {
						$image = $sxe->addChild('image');
						foreach ( $_POST['image'] as $image_key=>$image_value ){
							$image->addChild($image_key, trim($image_value[$cs_counter_image]) );
						}
						$cs_counter_image++;	
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "fileupload" ) {
						$fileupload = $sxe->addChild('fileupload');
						foreach ( $_POST['fileupload'] as $fileupload_key=>$fileupload_value ){
							$fileupload->addChild($fileupload_key, trim($fileupload_value[$cs_counter_fileupload]) );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
				
						$cs_counter_fileupload++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "repeatfield" ) {
						$repeatfield = $sxe->addChild('repeatfield');
						foreach ( $_POST['repeatfield'] as $repeatfield_key=>$repeatfield_value ){
							$repeatfield->addChild($repeatfield_key, trim($fileupload_value[$cs_counter_repeatfield]) );
						}
						$cs_counter_repeatfield++;
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "googlemap" ) {
						$googlemap = $sxe->addChild('googlemap');
						foreach ( $_POST['googlemap'] as $googlemap_key=>$googlemap_value ){
							$googlemap->addChild($googlemap_key, trim($googlemap_value[$cs_counter_googlemap]) );
						}
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						$googlemap->addChild('cs_customfield_address', trim($_POST['googlemap_address']['cs_customfield_address'][$cs_custom_field_id]) );
						$googlemap->addChild('cs_customfield_show_lat', trim($_POST['googlemap_address']['cs_customfield_show_lat'][$cs_custom_field_id]) );
						$cs_counter_googlemap++;	
					} else if ( $_POST['cs_customfield_order'][$cs_field_counter] == "custom_post_type" ) {
						$custom_post_type = $sxe->addChild('custom_post_type');
						if ( isset($_POST['cs_customfield_id'][$cs_field_counter])){
							$cs_custom_field_id = $_POST['cs_customfield_id'][$cs_field_counter];
						}
						foreach ( $_POST['custom_post_type'] as $custom_post_type_key=>$custom_post_type_value ){
							$custom_post_type->addChild($custom_post_type_key, trim($custom_post_type_value[$cs_counter_custom_post_type]) );
						}
						$cs_counter_custom_post_type++;
					}
					$cs_field_counter++;
				}
				}
				update_post_meta( $post_id, 'cs_dcpt_custom_fields', $sxe->asXML() );
			}
		}
	}
}
// Enctype Multipart
if ( ! function_exists( 'post_edit_form_tag' ) ) {
	function post_edit_form_tag() {
		echo ' enctype="multipart/form-data"';
	}
	add_action('post_edit_form_tag', 'post_edit_form_tag');
}