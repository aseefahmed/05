<?php
// DCPT Members
function cs_dcpt_members($type=''){
		global $post,$cs_xmlObject;
		$event_organizer = array();
		if(isset($cs_xmlObject->cs_event_members))
		$cs_event_members = $cs_xmlObject->cs_event_members;
		if (isset( $cs_event_members ) && $cs_event_members ){
			$cs_event_members = explode(",", $cs_event_members);
		}
		
		if(isset($cs_xmlObject->event_organizer))
			$event_organizer = $cs_xmlObject->event_organizer;
			if ( isset( $event_organizer ) && $event_organizer ){
				$event_organizer = explode(",", $event_organizer);
			}
		
		if( $type == 'member' ) {?>
                <ul class="form-elements" id="event_organizer_user_select" style="display:<?php //if (isset($cs_xmlObject->event_organizer_switch) && $cs_xmlObject->event_organizer_switch == "on") { echo "block"; } else { echo 'none'; } ?>">
                      <li class="to-label">
                        <label>Select Members</label>
                      </li>
                      <li class="to-field">
                            <select name="cs_event_members[<?php echo absint($post->ID);?>][]" multiple="multiple" class="multiselect" style="min-height:100px; max-height:500px !important;">
                              <?php 
                                      $eventusers = get_users('orderby=nicename');
                                      foreach ($eventusers as $user) {
                                            if ( in_array( $user->ID,$cs_event_members ) ){
                                                $selected = ' selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
                                    }?>
                            </select>
                      </li>
                 </ul>
  		<?php } else if ( $type == 'organizer' ){?>
        	<ul class="form-elements" id="event_organizer_user_select">
              <li class="to-label">
                <label><?php _e('Select Event Organizer','LMS');?></label>
              </li>
              <li class="to-field">
                    <select name="event_organizer[<?php echo absint($post->ID);?>][]" multiple="multiple" class="multiselect" style="min-height:100px; max-height:500px !important;">
                      <?php 
                              $eventusers = get_users('orderby=nicename');
                              foreach ($eventusers as $user) {
                                    if ( in_array( $user->ID,$event_organizer ) ){
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="'.$user->ID.'" '.$selected.'>'.$user->display_name.'</option>';
                            }?>
                    </select>
              </li>
            </ul>
    	<?php }
		
}