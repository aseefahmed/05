<?php
// Text Custom Fields
if ( ! function_exists( 'cs_pb_text' ) ) {
	function cs_pb_text($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div  class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="text" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Text','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
				<div class="pbwp-form-rows required-field">
					<label><?php _e('Required','LMS');?></label>
					<div class="pbwp-form-sub-fields select-style">
		  
						<select name="text[cs_customfield_required][]">
							<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
							<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						</select>
						
					</div>
				</div>
				<!-- .pbwp-form-rows -->
				
				<div class="pbwp-form-rows required-field">
					<label><?php _e('Sticky','LMS');?></label>
					<div class="pbwp-form-sub-fields select-style">
						<select name="text[cs_customfield_sticky][]">
							<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
							<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						</select>
						
					</div>
				</div>
				<!-- That will show on listing -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Field Label','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="text[cs_customfield_label][]" data-type="label"></div>
				<!-- .pbwp-form-rows -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Field Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop50" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="text[cs_customfield_name][]" data-type="name">	
				</div>
				<!-- .pbwp-form-rows -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Help text','LMS');?></label>
					<textarea title="" class="smallipopInput sipInitialized smallipop51" name="text[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
				</div>
				<!-- .pbwp-form-rows -->	
				<div class="pbwp-form-rows" id="custom-field-fontawsome<?php echo esc_attr($counter);?>">
					<label><?php _e('FontAwsome Icon','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label">
					<p><?php _e('Click','LMS');?> <a onclick="cs_fontawsome_popup('<?php echo esc_js(admin_url('admin-ajax.php'));?>','custom-field-fontawsome<?php echo esc_attr($counter);?>')"><?php _e('here','LMS');?></a><?php _e('to get Fontawsome icon','LMS');?> </p>
				</div>
				<!-- .pbwp-form-rows -->	
				<div class="pbwp-form-rows">
					<label><?php _e('CSS Class Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop52" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="text[cs_customfield_css][]"></div>
				<!-- .pbwp-form-rows -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Placeholder text','LMS');?></label>
					<input type="text" value="<?php if(isset($cs_node->cs_customfield_placeholder)){echo esc_attr($cs_node->cs_customfield_placeholder);}?>" title="" name="text[cs_customfield_placeholder][]" class="smallipopInput sipInitialized smallipop53"></div>
				<!-- .pbwp-form-rows -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Default value','LMS');?></label>
					<input type="text" value="<?php if(isset($cs_node->cs_customfield_default)){echo esc_attr($cs_node->cs_customfield_default);}?>" title="" name="text[cs_customfield_default][]" class="smallipopInput sipInitialized smallipop54"></div>
				<!-- .pbwp-form-rows -->	
	
				<div class="pbwp-form-rows">
					<label><?php _e('Size','LMS');?></label>
					<input type="text" value="<?php if(isset($cs_node->cs_customfield_size)){echo esc_attr($cs_node->cs_customfield_size);} else {echo '40';}?>" title="" name="text[cs_customfield_size][]" class="smallipopInput sipInitialized smallipop55"></div>
			
			  <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
						 $shortcode = '[cs_custom_text ';
						 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
						 $shortcode .= ' ]';
						 ?>		
							<div class="pbwp-form-rows">
								<label><?php _e('Shortcode','LMS');?></label>
								<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
							</div>
				<?php }?>
			</div>
		</div>
		
		<?php
		if($die<>1) die();
		
	}
	add_action('wp_ajax_cs_pb_text', 'cs_pb_text');
}
// Textarea Custom Fields
if ( ! function_exists( 'cs_pb_textarea' ) ) {
	function cs_pb_textarea($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
			<input type="hidden" name="cs_customfield_order[]" value="textarea" />
			<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Textarea','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
				 <div class="pbwp-form-holder">
						<div class="pbwp-form-rows required-field">
							<label><?php _e('Required','LMS');?></label>
							<div class="pbwp-form-sub-fields select-style">
								<select name="textarea[cs_customfield_required][]">
								   <option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
							<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
								</select>
							</div>
						</div>
						
						<div class="pbwp-form-rows required-field">
							<label><?php _e('Sticky','LMS');?></label>
							<div class="pbwp-form-sub-fields select-style">
				  
								<select name="text[cs_customfield_sticky][]">
									<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
									<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
								</select>
								
							</div>
						</div>
				
						<div class="pbwp-form-rows">
							<label><?php _e('Field Label','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop56" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="textarea[cs_customfield_label][]" data-type="label">
						</div>
						
						<div class="pbwp-form-rows">
							<label><?php _e('Meta Key','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop57" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="textarea[cs_customfield_name][]" data-type="name">
						</div>
						
						<div class="pbwp-form-rows">
							<label><?php _e('Help text','LMS');?></label>
							<textarea title="" class="smallipopInput sipInitialized smallipop58" name="textarea[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
						</div>
						<!-- .pbwp-form-rows -->	
						<div class="pbwp-form-rows">
							<label> <?php _e('FontAwsome Icon','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
						<div class="pbwp-form-rows">
							<label><?php _e('CSS Class Name','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop59" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="textarea[cs_customfield_css][]">
						</div>
				
						 <div class="pbwp-form-rows">
							<label><?php _e('Rows','LMS');?></label>
							<input type="text" value="<?php if(isset($cs_node->cs_customfield_rows)){echo esc_attr($cs_node->cs_customfield_rows);} else {echo '5';}?>" title="" name="textarea[cs_customfield_rows][]" class="smallipopInput sipInitialized smallipop60">
						</div>
				
						<div class="pbwp-form-rows">
							<label><?php _e('Columns','LMS');?></label>
							<input type="text" value="<?php if(isset($cs_node->cs_customfield_cols)){echo esc_attr($cs_node->cs_customfield_cols);} else {echo '25';}?>" title="" name="textarea[cs_customfield_cols][]" class="smallipopInput sipInitialized smallipop61">
						</div>
				
						<div class="pbwp-form-rows">
							<label><?php _e('Placeholder text','LMS');?></label>
							<input type="text" value="<?php if(isset($cs_node->cs_customfield_placeholder)){echo esc_attr($cs_node->cs_customfield_placeholder);}?>" title="" name="textarea[cs_customfield_placeholder][]" class="smallipopInput sipInitialized smallipop62">
						</div>
				
						<div class="pbwp-form-rows">
							<label><?php _e('Default value','LMS');?></label>
							<input type="text" value="<?php if(isset($cs_node->cs_customfield_default)){echo esc_attr($cs_node->cs_customfield_default);}?>" title="" name="textarea[cs_customfield_default][]" class="smallipopInput sipInitialized smallipop63">
						</div>
				
						<div class="pbwp-form-rows">
							<label><?php _e('Textarea','LMS');?></label>
							<div class="pbwp-form-sub-fields">
								<label><input type="radio"  <?php if(isset($cs_node->cs_customfield_editor) && $cs_node->cs_customfield_editor=="normal"){echo 'checked="checked"';}?> value="normal" name="textarea_rich[cs_customfield_editor][<?php echo esc_attr($counter);?>]"> <?php _e('Normal','LMS');?></label>
								<label><input type="radio"  <?php if(isset($cs_node->cs_customfield_editor) && $cs_node->cs_customfield_editor=="rich_textarea"){echo 'checked="checked"';}?> value="rich_textarea" name="textarea_rich[cs_customfield_editor][<?php echo esc_attr($counter);?>]"> <?php _e('Rich textarea','LMS');?></label>
								<label><input type="radio"  <?php if(isset($cs_node->cs_customfield_editor) && $cs_node->cs_customfield_editor=="teeny"){echo 'checked="checked"';}?> value="teeny" name="textarea_rich[cs_customfield_editor][<?php echo esc_attr($counter);?>]"> <?php _e('Teeny Rich textarea','LMS');?></label>
							</div>
						</div> 
						
						<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
								 $shortcode = '[cs_custom_textarea ';
								 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
								 $shortcode .= ' ]';
								 ?>		
									<div class="pbwp-form-rows">
										<label><?php _e('Shortcode','LMS');?></label>
										<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
									</div>
						<?php }?>
					   
					  </div>
					</div>
		
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_textarea', 'cs_pb_textarea');
}
// Dropdown Custom Fields
if ( ! function_exists( 'cs_pb_dropdown' ) ) {
	function cs_pb_dropdown($die='0'){
		global $post,$cs_node,$cs_count_node;
		
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>	
		<div class="pb-item-container">
		<div title="Dropdown" class="pbwp-legend">
			   <input type="hidden" name="cs_customfield_order[]" value="dropdown" />
			   <input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Dropdown','LMS');?> <?php if(isset($cs_node->cs_dropdown_label)){echo esc_attr($cs_node->cs_dropdown_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
		<div class="pbwp-form-holder">
			 <div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="dropdown[cs_customfield_required][]">
					   <option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					   <option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
	  
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
					
				</div>
			</div>
	
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop64" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="dropdown[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Meta Key','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop65" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="dropdown[cs_customfield_name][]" data-type="name">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop66" name="dropdown[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label> <?php _e('FontAwsome Icon','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop67" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="dropdown[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Select Text','LMS');?></label>
				<input type="text" title="" value="<?php if(isset($cs_node->cs_customfield_first)){echo esc_attr($cs_node->cs_customfield_first);} else {echo '- select -';}?>" name="dropdown[cs_customfield_first][]" class="smallipopInput sipInitialized smallipop68">
			</div> <!-- .pbwp-form-rows -->
	
					<div class="pbwp-form-rows">
						<label><?php _e('Options','LMS');?></label>
						<div class="pbwp-form-sub-fields pbwp-options">
						<label class="pbwp-show-field-value" for="pbwp-options_12">
						<div class="pbwp-option-label-value"><span><?php _e('Label','LMS');?></span></div>
						<?php
						if(isset($cs_node->options)){
						
							$option_counter = 0;
							$option_radio_counter = 1;
							 foreach($cs_node->options as $options_names){
						?>
								<div class="pbwp-clone-field">
									<input type="radio" <?php if((int)$option_radio_counter == (int)$cs_node->selected){echo 'checked="checked"';}?> name="cs_dropdown_option[selected][<?php echo esc_attr($counter);?>][]" value="<?php echo esc_attr($option_radio_counter);?>">
									<input type="text" value="<?php echo esc_attr($options_names);?>" name="cs_dropdown_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<input type="text" value="<?php echo esc_attr($cs_node->options_values[$option_counter]);?>" name="cs_dropdown_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
							$option_counter++;
							$option_radio_counter++;
							}
						} else {
								?>
								<div class="pbwp-clone-field">
									<input type="radio" checked="checked" name="cs_dropdown_option[selected][<?php echo esc_attr($counter);?>][]" value="1">
									<input type="text" value="" name="cs_dropdown_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<input type="text" value="" name="cs_dropdown_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
							
						}
						?>
						   
						</div> <!-- .pbwp-form-sub-fields -->
					</div> <!-- .pbwp-form-rows -->
					
					<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
								 $shortcode = '[cs_custom_dropdown ';
								 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
								 $shortcode .= ' ]';
								 ?>		
									<div class="pbwp-form-rows">
										<label><?php _e('Shortcode','LMS');?></label>
										<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
									</div>
					<?php }?> 
				</div>
			</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_dropdown', 'cs_pb_dropdown');
}
// Date Custom Fields
if ( ! function_exists( 'cs_pb_date' ) ) {
	function cs_pb_date($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
		<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="date" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Date','LMS');?> <?php if(isset($cs_node->cs_cusotmfield_label)){echo esc_attr($cs_node->cs_cusotmfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
		<div class="pbwp-form-holder">
		   <div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
					<select name="date[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
				</div>
			</div>
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop69" value="<?php if(isset($cs_node->cs_cusotmfield_label)){echo esc_attr($cs_node->cs_cusotmfield_label);}?>" name="date[cs_cusotmfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
             <div class="pbwp-form-rows">
                <label><?php _e('Field Name','LMS');?></label>
                <input type="text" title="" class="smallipopInput sipInitialized smallipop70" value="<?php if(isset($cs_node->cs_cusotmfield_name)){echo esc_attr($cs_node->cs_cusotmfield_name);}?>" name="date[cs_cusotmfield_name][]" data-type="name">
            </div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop71" name="date[cs_cusotmfield_help][]"><?php if(isset($cs_node->cs_cusotmfield_help)){echo esc_attr($cs_node->cs_cusotmfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label><?php _e('FontAwsome Icon','LMS');?> </label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop72" value="<?php if(isset($cs_node->cs_cusotmfield_css)){echo esc_attr($cs_node->cs_cusotmfield_css);}?>" name="date[cs_cusotmfield_css][]">
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('Date Format','LMS');?></label>
				<input type="text" title="" value="<?php if(isset($cs_node->cs_cusotmfield_format)){echo esc_attr($cs_node->cs_cusotmfield_format);} else {echo 'dd/mm/yy';}?>" name="date[cs_cusotmfield_format][]" class="smallipopInput sipInitialized smallipop73">
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('Time','LMS');?></label>
				<div class="pbwp-form-sub-fields">
					<label>
					  <input type="checkbox" value="yes" <?php if(isset($cs_node->cs_cusotmfield_time) && $cs_node->cs_cusotmfield_time=="yes"){echo 'checked="checked"';}?> name="date[cs_cusotmfield_time][]">
						<?php _e('Enable time input','LMS');?>                       </label>
				</div>
			</div> <!-- .pbwp-form-rows -->
			 <?php if(isset($cs_node->cs_cusotmfield_name)){
					 $shortcode = '[date ';
					 $shortcode .= 'name="'.$cs_node->cs_cusotmfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
					<div class="pbwp-form-rows">
						<label><?php _e('Shortcode','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
					</div>
			  <?php }?> 
			 <!-- .pbwp-form-rows -->
			</div>
		</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_date', 'cs_pb_date');
}
// Email Custom Fields
if ( ! function_exists( 'cs_pb_email' ) ) {
	function cs_pb_email($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
               <div title="Click and Drag to rearrange" class="pbwp-legend">
                    <input type="hidden" name="cs_customfield_order[]" value="email" />
                    <input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
                    <div class="pbwp-label"><?php _e('Custom field: Email','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
                    <div class="pbwp-actions">
                        <a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
                        <a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
                    </div>
                </div>
				<div class="pbwp-form-holder" style="display: block;">
					<div class="pbwp-form-rows required-field">
						<label><?php _e('Required','LMS');?></label>
						<div class="pbwp-form-sub-fields select-style">
							<select name="email[cs_customfield_required][]">
								<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
								<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
							</select>
						</div>
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows required-field">
						<label><?php _e('Sticky','LMS');?></label>
						<div class="pbwp-form-sub-fields select-style">
			  
							<select name="text[cs_customfield_sticky][]">
								<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
								<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
							</select>
						</div>
					</div>
					<div class="pbwp-form-rows">
						<label><?php _e('Field Label','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop31" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="email[cs_customfield_label][]" data-type="label">
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows">
						<label><?php _e('Meta Key','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop32" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="email[cs_customfield_name][]" data-type="name">
					</div> <!-- .pbwp-form-rows -->
					
					<div class="pbwp-form-rows">
						<label><?php _e('Help text','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop33" name="email[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
					</div> <!-- .pbwp-form-rows -->
					<!-- .pbwp-form-rows -->	
				<div class="pbwp-form-rows">
					<label><?php _e('FontAwsome Icon','LMS');?> </label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
					<div class="pbwp-form-rows">
						<label><?php _e('CSS Class Name','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop34" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="email[cs_customfield_css][]">
					</div> <!-- .pbwp-form-rows -->
			
					 <div class="pbwp-form-rows">
						<label><?php _e('Placeholder text','LMS');?></label>
						<input type="text" value="<?php if(isset($cs_node->cs_customfield_placeholder)){echo esc_attr($cs_node->cs_customfield_placeholder);}?>" title="" name="email[cs_customfield_placeholder][]" class="smallipopInput sipInitialized smallipop35">
					</div> <!-- .pbwp-form-rows -->
			
					<div class="pbwp-form-rows">
						<label><?php _e('Default value','LMS');?></label>
						<input type="text" value="<?php if(isset($cs_node->cs_customfield_default)){echo esc_attr($cs_node->cs_customfield_default);}?>" title="" name="email[cs_customfield_default][]" class="smallipopInput sipInitialized smallipop36">
					</div> <!-- .pbwp-form-rows -->
			
					<div class="pbwp-form-rows">
						<label><?php _e('Size','LMS');?></label>
						<input type="text" value="<?php if(isset($cs_node->cs_customfield_size)){echo esc_attr($cs_node->cs_customfield_size);} else {echo '40';}?>" title="" name="email[cs_customfield_size][]" class="smallipopInput sipInitialized smallipop37">
					</div> <!-- .pbwp-form-rows -->
					
					<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
						 $shortcode = '[email ';
						 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
						 $shortcode .= ' ]';
					 ?>		
						<div class="pbwp-form-rows">
							<label><?php _e('Shortcode','LMS');?></label>
							<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
						</div>
				  <?php }?> 
		
				</div>
			</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_email', 'cs_pb_email');
}
// Radio Button Custom Fields
if ( ! function_exists( 'cs_pb_radio' ) ) {
	function cs_pb_radio($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
		<div title="Click and Drag to rearrange" class="pbwp-legend">
			<input type="hidden" name="cs_customfield_order[]" value="radio" />
			<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
			<div class="pbwp-label"><?php _e('Custom field: Radio','LMS');?></div>
			<div class="pbwp-actions">
				<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
				<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
			</div>
		</div>
		
		<div class="pbwp-form-holder">
			 <div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
					 <select name="radio[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
	  
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
				</div>
			</div>
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				 <input type="text" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" title="" name="radio[cs_customfield_label][]" class="smallipopInput sipInitialized smallipop31">
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop32" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="radio[cs_customfield_name][]" data-type="name">
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop33" name="radio[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label> <?php _e('FontAwsome Icon','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop34" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="radio[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
            
            <div class="pbwp-form-rows">
            <label><?php _e('Options','LMS');?></label>
            <div class="pbwp-form-sub-fields pbwp-options">
	
			<div class="pbwp-option-label-value"><span>Label</span><span style="display: none;" class="pbwp-option-value"><?php _e('Value','LMS');?></span></div>
			
			<div class="pbwp-clone-field">
				<?php
				if(isset($cs_node->options)){
				
					$option_counter = 0;
					$option_radio_counter = 1;
					 foreach($cs_node->options as $options_names){
						?>
						<div class="pbwp-clone-field">
							<input type="radio" <?php if((int)$option_radio_counter == (int)$cs_node->selected){echo 'checked="checked"';}?> name="cs_radio_option[selected][<?php echo esc_attr($counter);?>][]" value="<?php echo esc_attr($option_radio_counter);?>">
							<input type="text" value="<?php echo esc_attr($options_names);?>" name="cs_radio_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
							<input type="text" value="<?php echo esc_attr($cs_node->options_values[$option_counter]);?>" name="cs_radio_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
						</div>
					<?php 
					$option_counter++;
					$option_radio_counter++;
					}
				} else {
						?>
						<div class="pbwp-clone-field">
							<input type="radio" checked="checked" name="cs_radio_option[selected][<?php echo esc_attr($counter);?>][]" value="1">
							<input type="text" value="" name="cs_radio_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
							<input type="text" value="" name="cs_radio_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
						</div>
					<?php 
					
				}
				?>        
			</div>
			<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
					 $shortcode = '[radio ';
					 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
					<div class="pbwp-form-rows">
						<label><?php _e('Shortcode','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
					</div>
			  <?php }?>
			
				
				</div> <!-- .pbwp-form-sub-fields -->
			</div> <!-- .pbwp-form-rows -->
		</div>
		</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_radio', 'cs_pb_radio');
}
// Multiselect Custom Fields
if ( ! function_exists( 'cs_pb_multiselect' ) ) {
	function cs_pb_multiselect($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="multiselect" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Multi select','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="multiselect[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
	  
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
					
				</div>
			</div>
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop35" value=" <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="multiselect[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
						<div class="pbwp-form-rows">
					<label><?php _e('Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop36" value=" <?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="multiselect[cs_customfield_name][]" data-type="name">
				</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop37" name="multiselect[cs_customfield_help][]"> <?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
				<div class="pbwp-form-rows">
					<label> <?php _e('FontAwsome Icon','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop38" value=" <?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="multiselect[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Select Text','LMS');?></label>
				<input type="text" title="" value=" <?php if(isset($cs_node->cs_customfield_first)){echo esc_attr($cs_node->cs_customfield_first);} else {echo ' - select -';}?>" name="multiselect[cs_customfield_first][]" class="smallipopInput sipInitialized smallipop39">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-clone-field">
				<?php
				if(isset($cs_node->options)){
				
					$option_counter = 0;
					$option_radio_counter = 1;
					 foreach($cs_node->options as $options_names){
						?>
						<div class="pbwp-clone-field">
							<input type="radio" <?php if((int)$option_radio_counter == (int)$cs_node->selected){echo 'checked="checked"';}?> name="cs_multiselect_option[selected][<?php echo esc_attr($counter);?>][]" value="<?php echo esc_attr($option_radio_counter);?>">
							<input type="text" value="<?php echo esc_attr($options_names);?>" name="cs_multiselect_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
							<input type="text" value="<?php echo esc_attr($cs_node->options_values[$option_counter]);?>" name="cs_multiselect_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
						</div>
					<?php 
					$option_counter++;
					$option_radio_counter++;
					}
				} else {
						?>
						<div class="pbwp-clone-field">
							<input type="radio" checked="checked" name="cs_multiselect_option[selected][<?php echo esc_attr($counter);?>][]" value="1">
							<input type="text" value="" name="cs_multiselect_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
							<input type="text" value="" name="cs_multiselect_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
							<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
						</div>
					<?php 
				}
				?>        
			</div> <!-- .pbwp-form-rows -->
			<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
					 $shortcode = '[multiselect ';
					 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
					<div class="pbwp-form-rows">
						<label><?php _e('Shortcode','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
					</div>
			  <?php }?>
				</div>
		</div>
		<?php 
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_multiselect', 'cs_pb_multiselect');
}
// checkbox Custom Fields
if ( ! function_exists( 'cs_pb_dcpt' ) ) {
	function cs_pb_checkbox($die='0'){
		global $post,$cs_node,$cs_count_node;
		
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
		<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="checkbox" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Check Box','LMS');?> <?php if(isset($cs_node->cs_checkbox_label)){echo esc_attr($cs_node->cs_checkbox_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
				<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
								<label><?php _e('Required','LMS');?></label>
								<div class="pbwp-form-sub-fields select-style">
									 <select name="checkbox[cs_customfield_required][]">
										<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
										<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
									</select>
								</div>
							</div> <!-- .pbwp-form-rows -->
							<div class="pbwp-form-rows required-field">
								<label><?php _e('Sticky','LMS');?></label>
								<div class="pbwp-form-sub-fields select-style">
									<select name="text[cs_customfield_sticky][]">
										<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
										<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
									</select>
								</div>
							</div>
							<div class="pbwp-form-rows">
								<label><?php _e('Field Label','LMS');?></label>
								<input type="text" title="" class="smallipopInput sipInitialized smallipop74" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="checkbox[cs_customfield_label][]" data-type="label">
							</div> <!-- .pbwp-form-rows -->
	
						<div class="pbwp-form-rows">
							<label><?php _e('Meta Key','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop75" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="checkbox[cs_customfield_name][]" data-type="name">
						</div> <!-- .pbwp-form-rows -->
			
						<div class="pbwp-form-rows">
							<label><?php _e('Help text','LMS');?></label>
							<textarea title="" class="smallipopInput sipInitialized smallipop76" name="checkbox[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
						</div> <!-- .pbwp-form-rows -->
						<!-- .pbwp-form-rows -->	
				<div class="pbwp-form-rows">
					<label> <?php _e('FontAwsome Icon','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
						<div class="pbwp-form-rows">
							<label><?php _e('CSS Class Name','LMS');?></label>
							<input type="text" title="" class="smallipopInput sipInitialized smallipop77" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="checkbox[cs_customfield_css][]">
						</div> <!-- .pbwp-form-rows -->
			
					<div class="pbwp-form-rows">
						<label><?php _e('Options','LMS');?></label>
	
						<div class="pbwp-form-sub-fields pbwp-options">
						
			<div class="pbwp-option-label-value"><span><?php _e('Label','LMS');?></span><span class="pbwp-option-value"><?php _e('Value','LMS');?></span></div>
					
					<?php
						if(isset($cs_node->options)){
							$option_counter = 0;
							$option_radio_counter = 1;
							 foreach($cs_node->options as $options_names){
								?>
								<div class="pbwp-clone-field">
									<input type="radio" <?php if((int)$option_radio_counter == (int)$cs_node->selected){echo 'checked="checked"';}?> name="cs_checkbox_option[selected][<?php echo esc_attr($counter);?>][]" value="<?php echo esc_attr($option_radio_counter);?>" >
									<input type="text" value="<?php echo esc_attr($options_names);?>" name="cs_checkbox_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<input type="text" value="<?php echo esc_attr($cs_node->options_values[$option_counter]);?>" name="cs_checkbox_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
							$option_counter++;
							$option_radio_counter++;
							}
						} else {
								?>
								<div class="pbwp-clone-field">
									<input type="radio" checked="checked" name="cs_checkbox_option[selected][<?php echo esc_attr($counter);?>][]" value="1">
									<input type="text" value="" name="cs_checkbox_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<input type="text" value="" name="cs_checkbox_option[options_values][<?php echo esc_attr($counter);?>][]" data-type="option_value">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
						}
						?>
						</div> <!-- .pbwp-form-sub-fields -->
								 <!-- .pbwp-form-rows -->
							</div> <!-- .pbwp-form-rows -->
							
						 <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
								 $shortcode = '[cs_custom_checkbox ';
								 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
								 $shortcode .= ' ]';
								 ?>		
									<div class="pbwp-form-rows">
										<label><?php _e('Shortcode','LMS');?></label>
										<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
									</div>
						<?php }?>  
							
				</div>
			</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_checkbox', 'cs_pb_checkbox');
}
// url Custom Field
if ( ! function_exists( 'cs_pb_url' ) ) {
	function cs_pb_url($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="url" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Url','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="url[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
	  
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
					
				</div>
			</div>
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop40" value=" <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="url[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop41" value=" <?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="url[cs_customfield_name][]" data-type="name">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop42" name="url[cs_customfield_help][]"> <?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label> <?php _e('FontAwsome Icon','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop43" value=" <?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="url[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
	
									<div class="pbwp-form-rows">
				<label><?php _e('Placeholder text','LMS');?></label>
				<input type="text" value=" <?php if(isset($cs_node->cs_customfield_placeholder)){echo esc_attr($cs_node->cs_customfield_placeholder);}?>" title="" name="url[cs_customfield_placeholder][]" class="smallipopInput sipInitialized smallipop44">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Default value','LMS');?></label>
				<input type="text" value=" <?php if(isset($cs_node->cs_customfield_default)){echo esc_attr($cs_node->cs_customfield_default);}?>" title="" name="url[cs_customfield_default][]" class="smallipopInput sipInitialized smallipop45">
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Size','LMS');?></label>
				<input type="text" value=" <?php if(isset($cs_node->cs_customfield_size)){echo esc_attr($cs_node->cs_customfield_size);} else {echo '40';}?>" title="" name="url[cs_customfield_size][]" class="smallipopInput sipInitialized smallipop46">
			</div> <!-- .pbwp-form-rows -->
			  <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
					 $shortcode = '[url ';
					 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
					<div class="pbwp-form-rows">
						<label><?php _e('Shortcode','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
					</div>
			  <?php }?>
			</div>
			
		 </div>
		
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_url', 'cs_pb_url');
}
// Hidden Field Custom Field
if ( ! function_exists( 'cs_pb_hiddenfield' ) ) {
	function cs_pb_hiddenfield($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="hiddenfield" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Hidden Field','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
				<div class="pbwp-form-rows">
					<label><?php _e('Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop19" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="hiddenfield[cs_customfield_name][]">
				</div> <!-- .pbwp-form-rows -->
		
				<div class="pbwp-form-rows">
					<label><?php _e('Value','LMS');?></label>
					<input type="text" value="<?php if(isset($cs_node->cs_customfield_meta_value)){echo esc_attr($cs_node->cs_customfield_meta_value);}?>" name="hiddenfield[cs_customfield_meta_value][]" title="" class="smallipopInput sipInitialized smallipop20">
				</div>
				 <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
					 $shortcode = '[cs_custom_hiddenfield ';
					 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
						<div class="pbwp-form-rows">
							<label><?php _e('Shortcode','LMS');?></label>
							<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
						</div>
				  <?php }?>
			</div>
			
		 </div>
		
		<?php
		
	}
	add_action('wp_ajax_cs_pb_hiddenfield', 'cs_pb_hiddenfield');
}

// Imageupload Custom Field
if ( ! function_exists( 'cs_pb_imageupload' ) ) {
	function cs_pb_imageupload($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="image" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Image','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="image[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows required-field">
				<label><?php _e('Sticky','LMS');?></label>
				<div class="pbwp-form-sub-fields select-style">
	  
					<select name="text[cs_customfield_sticky][]">
						<option value="yes" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
						<option value="no" <?php if(isset($cs_node->cs_customfield_sticky) && $cs_node->cs_customfield_sticky=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					</select>
					
				</div>
			</div>
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop28" value=" <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="image[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
				<div class="pbwp-form-rows">
					<label><?php _e('Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop29" value=" <?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="image[cs_customfield_name][]" data-type="name">
				</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop30" name="image[cs_customfield_help][]"> <?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label> <?php _e('FontAwsome Icon','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop31" value=" <?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="image[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Max. file size','LMS');?></label>
				<input type="text" title="" value=" <?php if(isset($cs_node->cs_customfield_max_size)){echo esc_attr($cs_node->cs_customfield_max_size);} else {echo '1024';}?>" name="image[cs_customfield_max_size][]" class="smallipopInput sipInitialized smallipop32">
			</div> <!-- .pbwp-form-rows -->
	
			 <!-- .pbwp-form-rows -->
			  <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
						 $shortcode = '[image ';
						 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
						 $shortcode .= ' ]';
					 ?>		
						<div class="pbwp-form-rows">
							<label><?php _e('Shortcode','LMS');?></label>
							<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
						</div>
				  <?php }?>
		</div>
		</div>
		<?php 
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_imageupload', 'cs_pb_imageupload');
}
// Fileupload Custom Field
if ( ! function_exists( 'cs_pb_fileupload' ) ) {
	function cs_pb_fileupload($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="fileupload" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: File Upload','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="fileupload[cs_customfield_required][]">
					   <option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
					   <option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop34" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="fileupload[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
				 <div class="pbwp-form-rows">
					<label><?php _e('Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop35" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="fileupload[cs_customfield_name][]" data-type="name">
				</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop36" name="fileupload[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop37" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="fileupload[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
	
			
			<div class="pbwp-form-rows">
				<label><?php _e('Max. file size','LMS');?></label>
				<input type="text" title="" value="<?php if(isset($cs_node->cs_customfield_max_size)){echo esc_attr($cs_node->cs_customfield_max_size);} else {echo '1024';}?>" name="fileupload[cs_customfield_max_size][]" class="smallipopInput sipInitialized smallipop38">
			</div> <!-- .pbwp-form-rows -->
	
 			  <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
					 $shortcode = '[fileupload ';
					 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
					 $shortcode .= ' ]';
				 ?>		
					<div class="pbwp-form-rows">
						<label><?php _e('Shortcode','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
					</div>
			  <?php }?>
	  </div>
	
		</div>
		<?php 
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_fileupload', 'cs_pb_fileupload');
}
// Repeat Custom Field
if ( ! function_exists( 'cs_pb_repeatfield' ) ) {
	function cs_pb_repeatfield($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			<div title="Click and Drag to rearrange" class="pbwp-legend">
				<input type="hidden" name="cs_customfield_order[]" value="repeatfield" />
				<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Repeat Field','LMS');?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					<select name="repeatfield[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop40" value="" name="repeatfield[cs_customfield_label][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
	
				 <div class="pbwp-form-rows">
					<label><?php _e('Name','LMS');?></label>
					<input type="text" title="" class="smallipopInput sipInitialized smallipop41" value="" name="repeatfield[cs_customfield_name][]" data-type="name">
				</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop42" name="repeatfield[cs_customfield_help][]"></textarea>
			</div> <!-- .pbwp-form-rows -->
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop43" value="" name="repeatfield[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows">
						<label><?php _e('Multiple Column','LMS');?></label>
						<div class="pbwp-form-sub-fields">
							<label><input type="checkbox" value="true" name="repeatfield[cs_customfield_multiple][]" class="multicolumn"><?php _e('Enable Multi Column','LMS');?> </label>
						</div>
					</div>
					<div class="pbwp-form-rows">
						<label><?php _e('Placeholder text','LMS');?></label>
						<input type="text" value="" title="" name="repeatfield[cs_customfield_placeholder][]" class="smallipopInput sipInitialized smallipop44">
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows">
						<label><?php _e('Default value','LMS');?></label>
						<input type="text" value="" title="" name="repeatfield[cs_customfield_default][]" class="smallipopInput sipInitialized smallipop45">
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows">
						<label><?php _e('Size','LMS');?></label>
						<input type="text" value="40" title="" name="repeatfield[cs_customfield_size][] pbwp_input[8][size]" class="smallipopInput sipInitialized smallipop46">
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows column-names pbwp-hide">
						<label><?php _e('Columns','LMS');?></label>
					   <div class="pbwp-form-sub-fields">
						<?php
						if(isset($cs_node->options)){
							$option_counter = 0;
							 foreach($cs_node->options as $options_names){
								?>
								 <div>
									<input type="text" value="<?php echo esc_attr($options_names);?>" name="cs_repeatfield_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
							$option_counter++;
							}
						} else {
								?>
								<div>
									<input type="text" value="" name="cs_repeatfield_option[options][<?php echo esc_attr($counter);?>][]" data-type="option">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/add.png');?>" class="pbwp-clone-field" title="add another choice" alt="add another choice" style="cursor:pointer; margin:0 3px;">
									<img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/remove.png');?>" title="remove this choice" alt="remove this choice" class="pbwp-remove-field" style="cursor:pointer;">
								</div>
							<?php 
						}
						?>        
					</div> <!-- .pbwp-form-rows -->
				  </div> <!-- .pbwp-form-rows -->
				   <?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
							 $shortcode = '[repeatfield ';
							 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
							 $shortcode .= ' ]';
						 ?>		
							<div class="pbwp-form-rows">
								<label><?php _e('Shortcode','LMS');?></label>
								<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
							</div>
					  <?php }?>
			   </div>
		 </div>
		<?php
		if($die<>1) die();
		
	}
	add_action('wp_ajax_cs_pb_repeatfield', 'cs_pb_repeatfield');
}

// Google Map
if ( ! function_exists( 'cs_pb_googlemap' ) ) {
	function cs_pb_googlemap($die='0'){
		global $post,$cs_node,$cs_count_node;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
				<div title="Click and Drag to rearrange" class="pbwp-legend">
					<input type="hidden" name="cs_customfield_order[]" value="googlemap" />
					<input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
					<div class="pbwp-label"><?php _e('Custom Field: Google Map','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
					<div class="pbwp-actions">
						<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
						<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
					</div>
				</div>
			
				<div class="pbwp-form-holder">
				  <div class="pbwp-form-rows required-field">
						<label><?php _e('Required','LMS');?></label>
						<div class="pbwp-form-sub-fields select-style">
							<select name="googlemap[cs_customfield_required][]">
								<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
								<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
							</select>
						</div>
					</div> <!-- .pbwp-form-rows -->
	
					<div class="pbwp-form-rows">
						<label><?php _e('Field Label','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop47" value=" <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="googlemap[cs_customfield_label][]" data-type="label">
					</div> <!-- .pbwp-form-rows -->
			
					<div class="pbwp-form-rows">
						<label><?php _e('Name','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop48" value=" <?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="googlemap[cs_customfield_name][]" data-type="name">
					</div> <!-- .pbwp-form-rows -->
					
					<div class="pbwp-form-rows">
						<label><?php _e('Help text','LMS');?></label>
						<textarea title="" class="smallipopInput sipInitialized smallipop49" name="googlemap[cs_customfield_help][]"> <?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
					</div> <!-- .pbwp-form-rows -->
					<!-- .pbwp-form-rows -->	
					<div class="pbwp-form-rows">
						<label><?php _e('FontAwsome Icon','LMS');?> </label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
					<div class="pbwp-form-rows">
						<label><?php _e('CSS Class Name','LMS');?></label>
						<input type="text" title="" class="smallipopInput sipInitialized smallipop50" value=" <?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="googlemap[cs_customfield_css][]">
					</div> <!-- .pbwp-form-rows -->
			
					<div class="pbwp-form-rows">
						<label><?php _e('Zoom Level','LMS');?></label>
						<input type="text" title="" value=" <?php if(isset($cs_node->cs_customfield_zoom)){echo esc_attr($cs_node->cs_customfield_zoom);} else {echo '12';}?>" name="googlemap[cs_customfield_zoom][]" class="smallipopInput sipInitialized smallipop51">
					</div> <!-- .pbwp-form-rows -->
	
					<div class="pbwp-form-rows">
						<label><?php _e('Default Co-ordinate','LMS');?></label>
						<input type="text" title="" value=" <?php if(isset($cs_node->cs_customfield_default_pos)){echo esc_attr($cs_node->cs_customfield_default_pos);} else {echo '40.7143528,-74.0059731';}?>" name="googlemap[cs_customfield_default_pos][]" class="smallipopInput sipInitialized smallipop52">
					</div> <!-- .pbwp-form-rows -->
					<div class="pbwp-form-rows">
						<label><?php _e('Address Button','LMS');?></label>
						<div class="pbwp-form-sub-fields">
							<label>
								<input type="hidden" value="no" name="googlemap_address[cs_customfield_address][<?php echo esc_attr($counter);?>]">
								<input type="checkbox" <?php if(isset($cs_node->cs_customfield_address) && $cs_node->cs_customfield_address=="yes"){echo 'checked="checked"';}?> value="yes" name="googlemap_address[cs_customfield_address][<?php echo esc_attr($counter);?>]">
								<?php _e('Show address find button','LMS');?>                        </label>
						</div>
					</div> <!-- .pbwp-form-rows -->
	
					<div class="pbwp-form-rows">
						<label><?php _e('Show Latitude/Longitude','LMS');?></label>
						<div class="pbwp-form-sub-fields">
							<label>
								<input type="hidden" value="no" name="googlemap_address[cs_customfield_show_lat][<?php echo esc_attr($counter);?>]">
								<input type="checkbox" <?php if(isset($cs_node->cs_customfield_show_lat) && $cs_node->cs_customfield_show_lat=="yes"){echo 'checked="checked"';}?> value="yes" name="googlemap_address[cs_customfield_show_lat][<?php echo esc_attr($counter);?>]">
								<?php _e('Show latitude and longitude input box value ','LMS');?>                       </label>
						</div>
					</div> <!-- .pbwp-form-rows -->
					<?php if(isset($cs_node->cs_customfield_name) && $cs_node->cs_customfield_name <> ''){
							 $shortcode = '[googlemap ';
							 $shortcode .= 'name="'.$cs_node->cs_customfield_name.'" ';
							 $shortcode .= ' ]';
						 ?>		
							<div class="pbwp-form-rows">
								<label><?php _e('Shortcode','LMS');?></label>
								<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
							</div>
					  <?php }?>
			 </div>
		
		 </div>
		
		<?php
		if($die<>1) die();
		
	}
	add_action('wp_ajax_cs_pb_googlemap', 'cs_pb_googlemap');
}
//  Dynamic Post Post Type
if ( ! function_exists( 'cs_pb_custom_post_type' ) ) {
	function cs_pb_custom_post_type($die='0'){
		global $post,$cs_node,$cs_count_node,$wp_post_types;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			
			<div title="Click and Drag to rearrange" class="pbwp-legend">
			  <input type="hidden" name="cs_customfield_order[]" value="custom_post_type" />
			  <input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Post Type','LMS');?> <?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					 <select name="custom_post_type[cs_customfield_required][]">
							<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
							<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop40" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="custom_post_type[cs_customfield_label][]" data-type="label">
			</div>
		   
		   <div class="pbwp-form-rows">
				<label><?php _e('Name','LMS');?></label>
				 <input type="text" title="" class="smallipopInput sipInitialized smallipop40" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="custom_post_type[cs_customfield_name][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop68" name="custom_post_type[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label> <?php _e('FontAwsome Icon','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop69" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="custom_post_type[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows select-style">
				<label><?php _e('Type','LMS');?></label>
				<select name="custom_post_type[cs_customfield_post_type][]">
					<?php 
						foreach($wp_post_types as $key=>$wp_post_types_values){
							if($key){
								echo '<option value="'.$key.'" >'.$key.'</option>';
							}
						}
					?>
				</select>
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows select-style">
				<label><?php _e('Order','LMS');?></label>
				<select name="custom_post_type[cs_customfield_order][]">
					<option selected="selected" value="ASC"><?php _e('Asc','LMS');?></option>
					<option value="DESC"><?php _e('DESC','LMS');?></option>
				</select>
			</div> <!-- .pbwp-form-rows -->
	
		 </div>
		<?php if(isset($cs_node->cs_cusotmfield_name)){
			 $shortcode = '[cs_cusotm_post_dropdown ';
			 $shortcode .= 'name="'.$cs_node->cs_cusotmfield_name.'" ';
			 $shortcode .= ' ]';
		 ?>		
			<div class="pbwp-form-rows">
				<label><?php _e('Shortcode','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
			</div>
	  <?php }?>
		 
		</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_custom_post_type', 'cs_pb_custom_post_type');
}
//  Dynamic Post Categories Custom Fields
if ( ! function_exists( 'cs_pb_custom_categories' ) ) {
	function cs_pb_custom_categories($die='0'){
		global $post,$cs_node,$cs_count_node,$wp_post_types;
		if(isset($_REQUEST['counter'])){
			$counter = $_REQUEST['counter'];
		} else {
			$counter = $cs_count_node;
		}
		?>
		<div class="pb-item-container">
			
			<div title="Click and Drag to rearrange" class="pbwp-legend">
			  <input type="hidden" name="cs_customfield_order[]" value="custom_post_type" />
			  <input type="hidden" name="cs_customfield_id[]" value="<?php echo esc_attr($counter);?>" />
				<div class="pbwp-label"><?php _e('Custom field: Post Type ','LMS');?><?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?></div>
				<div class="pbwp-actions">
					<a class="pbwp-remove" href="#"><i class="fa fa-times"></i></a>
					<a class="pbwp-toggle" href="#"><i class="fa fa-sort-down"></i></a>
				</div>
			</div>
			<div class="pbwp-form-holder">
							<div class="pbwp-form-rows required-field">
				<label><?php _e('Required','LMS');?></label>
	
				<div class="pbwp-form-sub-fields select-style">
					 <select name="custom_post_type[cs_customfield_required][]">
						<option value="no" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="no"){echo 'selected="selected"';}?>><?php _e('No','LMS');?></option>
						<option value="yes" <?php if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required=="yes"){echo 'selected="selected"';}?>><?php _e('Yes','LMS');?></option>
					</select>
				</div>
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Field Label','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop40" value="<?php if(isset($cs_node->cs_customfield_label)){echo esc_attr($cs_node->cs_customfield_label);}?>" name="custom_post_type[cs_customfield_label][]" data-type="label">
			</div>
		   
		   <div class="pbwp-form-rows">
				<label><?php _e('Name','LMS');?></label>
				 <input type="text" title="" class="smallipopInput sipInitialized smallipop40" value="<?php if(isset($cs_node->cs_customfield_name)){echo esc_attr($cs_node->cs_customfield_name);}?>" name="custom_post_type[cs_customfield_name][]" data-type="label">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Help text','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop68" name="custom_post_type[cs_customfield_help][]"><?php if(isset($cs_node->cs_customfield_help)){echo esc_attr($cs_node->cs_customfield_help);}?></textarea>
			</div> <!-- .pbwp-form-rows -->
			<!-- .pbwp-form-rows -->	
			<div class="pbwp-form-rows">
				<label><?php _e('FontAwsome Icon','LMS');?> </label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop49" value="<?php if(isset($cs_node->cs_customfield_icon)){echo esc_attr($cs_node->cs_customfield_icon);}?>" name="text[cs_customfield_icon][]" data-type="label"></div>
			<div class="pbwp-form-rows">
				<label><?php _e('CSS Class Name','LMS');?></label>
				<input type="text" title="" class="smallipopInput sipInitialized smallipop69" value="<?php if(isset($cs_node->cs_customfield_css)){echo esc_attr($cs_node->cs_customfield_css);}?>" name="custom_post_type[cs_customfield_css][]">
			</div> <!-- .pbwp-form-rows -->
			
			<div class="pbwp-form-rows">
				<label><?php _e('Type','LMS');?></label>
				<select name="custom_post_type[cs_customfield_post_type][]">
					<?php 
						foreach($wp_post_types as $key=>$wp_post_types_values){
							if($key){
								echo '<option value="'.esc_attr($key).'" >'.esc_attr($key).'</option>';
							}
						}
					?>
				</select>
			</div> <!-- .pbwp-form-rows -->
	
			<div class="pbwp-form-rows">
				<label><?php _e('Order','LMS');?></label>
				<select name="custom_post_type[cs_customfield_order][]">
					<option selected="selected" value="ASC"><?php _e('Asc','LMS');?></option>
					<option value="DESC"><?php _e('DESC','LMS');?></option>
				</select>
			</div> <!-- .pbwp-form-rows -->
	
		 </div>
		<?php if(isset($cs_node->cs_cusotmfield_name)){
			 $shortcode = '[cs_cusotm_post_dropdown ';
			 $shortcode .= 'name="'.$cs_node->cs_cusotmfield_name.'" ';
			 $shortcode .= ' ]';
		 ?>		
			<div class="pbwp-form-rows">
				<label><?php _e('Shortcode','LMS');?></label>
				<textarea title="" class="smallipopInput sipInitialized smallipop76" ><?php echo esc_attr($shortcode);?></textarea>
			</div>
	  <?php }?>
		 
		</div>
		<?php
		if($die<>1) die();
	}
	add_action('wp_ajax_cs_pb_custom_post_type', 'cs_pb_custom_categories');
}

// Render Dynamic Post Custom Fields
if ( ! function_exists( 'cs_custom_fields_render' ) ) {
	function cs_custom_fields_render($key='', $param='') {
		global $post,$cs_node,$cs_xmlObject;
		//print_r($cs_xmlObject->cs_text_name);
		$cs_value = '';
		//$cs_value = get_post_meta($post->ID, $key, true);
		$html = '';
		$cs_customfield_required = '';
		if(isset($cs_node->cs_customfield_required) && $cs_node->cs_customfield_required == 'yes'){
			$cs_customfield_required = 'required';
		}
		switch( $cs_node->getName() )
		{
			case 'text' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input type="text" size="'. $cs_node->cs_customfield_size . '" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input '.$cs_node->cs_customfield_css.' " name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" '.$cs_customfield_required.' /></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';

				// append
				$html .= $output;

				break;
			
			case 'email' :

				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input type="email" size="'. $cs_node->cs_customfield_size . '" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input '.$cs_node->cs_customfield_css.' " name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" '.$cs_customfield_required.' /></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';

				// append
				$html .= $output;

				break;
			case 'url' :

				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input type="url" '.$cs_customfield_required.' size="'. $cs_node->cs_customfield_size . '" placeholder="' . $cs_node->cs_customfield_placeholder . '" class="cs-form-text cs-input '.$cs_node->cs_customfield_css.' " name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" value="' . $cs_value . '" /></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';

				// append
				$html .= $output;

				break;
			case 'googlemap' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default_pos;
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input '.$cs_customfield_required.' id="'.trim($cs_node->cs_customfield_css).'" name="dcpt['.trim($cs_node->cs_customfield_name).']" value="'.$cs_node->$cs_value.'" type="text" class="small" /></div>';
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></di>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;
				break;
			case 'image' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input '.$cs_customfield_required.' id="'.trim($cs_node->cs_customfield_css).'" name="'.trim($cs_node->cs_customfield_name).'" value="'.$cs_node->$cs_value.'" type="text" class="small" />';
                $output .= '<input id="'.trim($cs_node->cs_customfield_css).'" name="'.trim($cs_node->cs_customfield_name).'" type="button" class="uploadfile left" value="'. __( 'Browse', 'LMS' ) .'"/>';
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;
				break;
			case 'fileupload' :
				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input '.$cs_customfield_required.' id="'.trim($cs_node->cs_customfield_css).'" name="dcpt_fileupload['.trim($cs_node->cs_customfield_name).']" value="'.$cs_node->$cs_value.'" type="file"/>';
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';

				// append
				$html .= $output;

				break;
				
			case 'hiddenfield' :

				$output .= '<input type="hidden" value="'.$cs_node->cs_customfield_meta_value.'" name="dcpt['.$cs_node->cs_customfield_name.']" >';

				// append
				$html .= $output;

				break;
			case 'date' :

				// prepare
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_cusotmfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<script>
					jQuery(function($) {
						$("#' . $cs_node->cs_customfield_name . '").datepicker({
							dateFormat: "' . $cs_node->cs_cusotmfield_format . '",
							timeFormat:  "HH:mm"
						});
					});
				</script>';
				
				$output .= '<li class="to-label"><label>'.$cs_node->cs_cusotmfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><input '.$cs_customfield_required.' type="text" size="'. $cs_node->cs_cusotmfield_size . '" placeholder="' . $cs_node->cs_cusotmfield_placeholder . '" class="cs-form-text cs-input '.$cs_node->cs_cusotmfield_css.' " name="dcpt[' . $cs_node->cs_cusotmfield_name . ']" id="' . $cs_node->cs_cusotmfield_name . '" value="' . $cs_value . '" />' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc"> Date Fromat: ' . $cs_node->cs_cusotmfield_format . '</span><span class="cs-form-desc">' . $cs_node->cs_cusotmfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;

				break;
			
			case 'radio' :
				if(isset($cs_xmlObject)){
					
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;

				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
					$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li><li class="to-field"><div class="input-sec">';
					$radio_counter = 0;
					foreach( $cs_node->options as $value => $option )
					{
						$radio_counter++;	
						$checked = '';
						if($cs_value == $cs_node->options_values[$radio_counter]){$checked = 'checked="checked"';}
						$output .= '<input type="radio" name="dcpt[' . $cs_node->cs_customfield_name . '][]" '.$checked.' value="'.$cs_node->options_values[$radio_counter].'" id="' . $cs_node->cs_customfield_name .'_'. $radio_counter. '" class="cs-form-textarea cs-input '.$cs_node->cs_customfield_css.'">' . $option . ' ' . "\n";
					}
					
					$output .= '</div><div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n </li>";
				$output .= '</ul>';
				// append
				$html .= $output;

				break;
				
			case 'multiselect' :

				// prepare
				
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_label;
					$cs_value = $cs_xmlObject->$key;
					$cs_value = explode(',',$cs_value);
			
					
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li><li class="to-field"><div class="input-sec">';
				$multiselect_counter = 0;
				$output .= '<select style="min-height:100px;" name="dcpt[' . $cs_node->cs_customfield_name . '][]" id="' . $cs_node->cs_customfield_name . '" class="cs-form-select cs-input '.$cs_node->cs_customfield_css.'" multiple="multiple">' . "\n";

				foreach( $cs_node->options as $value => $option )
				{
					$selected = '';
					if(is_array($cs_value) && in_array($cs_node->options_values[$multiselect_counter], $cs_value)) $selected = 'selected="selected"';
					$output .= '<option '.$selected.' value="' . $cs_node->options_values[$multiselect_counter] . '">' . $option . '</option>' . "\n";
					$multiselect_counter++;
				}
				$output .= '</select></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;

				break;

			case 'textarea' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li>';
				$output .= '<li class="to-field"><div class="input-sec"><textarea '.$cs_customfield_required.' rows="'.$cs_node->cs_customfield_rows.'" cols="'.$cs_node->cs_customfield_cols.'" name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" class="cs-form-textarea cs-input '.$cs_node->cs_customfield_css.'">' . $cs_value . '</textarea></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;
				break;
			case 'dropdown' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<li class="to-field"><div class="input-sec"><select  '.$cs_customfield_required.' name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" class="cs-form-select cs-input">' . "\n</li>";
				if(isset($cs_node->cs_customfield_first)){$output .= '<option value="' . $value . '">' . $cs_node->cs_customfield_first . '</option>' . "\n";}
				$multiselect_counter=0;
				foreach( $cs_node->options as $value => $option )
				{
					$selected = '';
					if($option==$cs_value){ $selected = 'selected="selected"';}
					$output .= '<option value="' . $cs_node->options_values[$multiselect_counter] . '" '.$selected.' >' . $option . '</option>' . "\n";
					$multiselect_counter++;
				}
				$output .= '</select></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;
				break;
			case 'checkbox' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
					$cs_value = explode(',',$cs_value);
				}
				// prepare
				$output .= '<ul class="form-elements noborder">';
				$output = '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label></li><li class="to-field"><div class="input-sec">';
				$option_counter = 0;
				foreach($cs_node->options as $options_names){
					$checked  = '';
					if(is_array($cs_value) && in_array($cs_node->options_values[$option_counter],$cs_value)){$checked = 'checked="checked"';}
					$output .= '<label class="pbwp-checkboxx"><input '.$cs_customfield_required.' type="checkbox" value="'.$cs_node->options_values[$option_counter].'" name="dcpt[' . $cs_node->cs_customfield_name . '][]" id="' . $cs_node->cs_customfield_label . '" class="cs-form-checkbox cs-input"' .$checked. '><span class="pbwp-box">'.$options_names.'</span></label>' . "\n";
					$option_counter++;
				}
				$output .= '</div><div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div></li>';
				$output .= '</ul>';
				$html .= $output;
				break;
			case 'custom_post_type' :
				if(isset($cs_xmlObject)){
					$key = $cs_node->cs_customfield_name;
					$cs_value = $cs_xmlObject->$key;
				} else {
					$cs_value = $cs_node->cs_customfield_default;
				}
				$output .= '<ul class="form-elements noborder">';
				$output .= '<li class="to-label"><label>'.$cs_node->cs_customfield_label.'</label>';
				$output .= '<li class="to-field"><div class="input-sec"><select '.$cs_customfield_required.' name="dcpt[' . $cs_node->cs_customfield_name . ']" id="' . $cs_node->cs_customfield_name . '" class="cs-form-select cs-input">' . "\n</li>";
				//if(isset($cs_node->cs_customfield_first)){$output .= '<option value="' . $value . '">' . $cs_node->cs_customfield_first . '</option>' . "\n";}
				query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'orderby'=>'ID', 'order'=>"$cs_node->cs_customfield_order", 'post_type' => "$cs_node->cs_customfield_post_type") );
				while ( have_posts()) : the_post();
					$selected = '';
					if(get_the_ID()==$cs_value) $selected = "selected";
					$output .= '<option '.$selected.' value="' . get_the_ID() . '">' . get_the_title() . '</option>' . "\n";
				endwhile;
				$output .= '</select></div>' . "\n";
				$output .= '<div class="left-info"><span class="cs-form-desc">' . $cs_node->cs_customfield_help . '</span></div>' . "\n</li>";
				$output .= '</ul>';
				// append
				$html .= $output;
				break;
			default :
				break;
		}
		return $html;
	}
}
?>