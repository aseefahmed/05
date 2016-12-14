<?php
/**
 * Event Members
 * @package LMS
 * @copyright Copyright (c) 2014, Chimp Studio 
 */
	global $cs_node, $cs_theme_options,$cs_xmlObject,$post_xml;
	$description_limit = 97;
?>
<style scoped="scoped">
.event_map .col-md-12 {
	padding:0px;
}
</style>
<?php
	$event_organizer = $cs_xmlObject->event_organizer;
	
	if ( isset( $event_organizer ) && $event_organizer !='' ) {
		$members	= explode(',',$event_organizer);	
						 				
	
	?>
<div class="col-md-12">
  <div class="cs-section-title">
    <h2><?php //_e('Event Speakers','LMS');
			   _e('Event Speakers','LMS');?>	
	 </h2>
  </div>
  
  <?php if ( isset( $members ) && $members !='' ){?>
	 <div class="cs-team">
         <div class="cs-team wow default_team_view   animated" style="visibility: visible;">
           <div class="row">
            <?php   foreach ( $members as $member ) {
                    $cs_display_image = '';
                    $uid	= absint(trim($member));
                    $cs_display_image = get_the_author_meta('user_avatar_display',$uid );
            ?>
              
              	<div class="col-md-4">
                <article class="size_large has_border member-<?php echo intval($uid);?>">
                <figure>
                <?php 
                    if($cs_display_image <> ''){
                        echo '<img src="'.esc_url($cs_display_image).'"  />';	
                    }else{
                        echo get_avatar(get_the_author_meta('user_email',$uid), apply_filters('LMS_author_bio_avatar_size', 300));	
                    }
            
                    $facebook = $twitter = $linkedin = $pinterest = $google_plus = $instagram = $skype = $email = '';
                    
                    $facebook = get_the_author_meta('facebook',$uid ); 
                    $twitter  = get_the_author_meta('twitter',$uid );
                    $linkedin  = get_the_author_meta('linkedin',$uid );
                    $pinterest  = get_the_author_meta('pinterest',$uid );
                    $google_plus = get_the_author_meta('google_plus',$uid );
                    $instagram  = get_the_author_meta('instagram',$uid );
                    $skype  = get_the_author_meta('skype',$uid );
                    $email = get_the_author_meta('email',$uid );
                    $user_info = get_userdata( $uid );  
                    $count = 0;
                  ?>
                  <figcaption class="has_caption_soc">
                    <p class="social-media">
                         <?php 
                            if(isset($facebook) and $facebook <> ''){
                                echo '  <a target="_blank" style="background-color:#2d5faa;" href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a>';
                            $count++; } 
                            if(isset($twitter) and $twitter <> ''){
                                echo '  <a target="_blank" style="background-color:#21cdec;" href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a>';
                            $count++; }
                            if(isset($linkedin) and $linkedin <> ''){
                                echo '  <a target="_blank" style="background-color:#007bb5;" href="'.esc_url($linkedin).'"><i class="fa fa-linkedin"></i></a>';
                            $count++; }
                            if(isset($pinterest) and $pinterest <> ''){
                                echo '  <a target="_blank" style="background-color:#cb2027;" href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a>';
                            $count++; }
                            
                            if(isset($google_plus) and $google_plus <> ''){
                                if( $count == 4) {echo "<br><br>";}
                                echo '  <a target="_blank" style="background-color:#cc1515;" href="'.esc_url($google_plus).'"><i class="fa fa-google-plus"></i></a>';
                            $count++; }
                            
                            if(isset($instagram) and $instagram <> ''){
                                if( $count == 4) {echo "<br><br>";}
                                echo '  <a target="_blank" style="background-color:#125688;" href="'.esc_url($instagram).'"><i class="fa fa-instagram"></i></a>';
                            $count++; }
                            
                            if(isset($skype) and $skype <> ''){
                                if( $count == 4) {echo "<br><br>";}
                                echo '  <a style="background-color:#12A5F4;" href="skype:'.$skype.'"><i class="fa fa-skype"></i></a>';
                            $count++; }
                            
                            if(isset($email) and $email <> '' && is_email($email)){
                                if( $count == 4) {echo "<br><br>";}
                                echo '  <a style="background-color:#cca715;" href="mailto:'.sanitize_email($email).'"><i class="fa fa-envelope-o"></i></a>';
                            $count++; } 
                         ?>
                    </p>
                  </figcaption>
                </figure>
                <div class="text ">
                  <header>
                    <h2 class="cs-post-title"><a href="<?php echo get_author_posts_url($uid); ?>"><?php echo get_the_author_meta( 'display_name', $uid );?></a></h2>
                    <?php if ( isset( $user_info ) && $user_info !='' ) {?>
                    <ul class="post-option">
                      <li class="has-border"><?php echo ucwords( implode(',', $user_info->roles) );?></li>
                    </ul>
                     <?php } ?>
                  </header>
                  <p><?php echo substr(get_the_author_meta( 'description', $uid ),0, $description_limit); if(strlen(get_the_author_meta( 'description', $uid ))>$description_limit){echo '...';}?></p>
                </div>
              </article>
              </div>
      <?php } ?>
           </div>
         </div>
    </div>
  <?php }
	}
  ?>
</div>
