<?php
add_action( 'add_meta_boxes', 'cs_meta_post_add' );
function cs_meta_post_add()
{  
	add_meta_box( 'cs_meta_post', __('Post Options','LMS'), 'cs_meta_post', 'post', 'normal', 'high' );  
}
function cs_meta_post( $post ) {
	$post_xml = get_post_meta($post->ID, "post", true);
	global $cs_xmlObject,$cs_theme_options;
	$cs_theme_options=$cs_theme_options;
	$cs_builtin_seo_fields =$cs_theme_options['cs_builtin_seo_fields'];
	$cs_header_position =$cs_theme_options['cs_header_position'];

	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
			$sub_title = $cs_xmlObject->sub_title;
			$post_thumb_view = $cs_xmlObject->post_thumb_view;
			$post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
			$post_thumb_audio = $cs_xmlObject->post_thumb_audio;
			$post_thumb_video = $cs_xmlObject->post_thumb_video;
			$post_thumb_slider = $cs_xmlObject->post_thumb_slider;
			$post_thumb_slider_type = $cs_xmlObject->post_thumb_slider_type;						
			$inside_post_thumb_view = $cs_xmlObject->inside_post_thumb_view;
			$inside_post_featured_image_as_thumbnail = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
			$inside_post_thumb_audio = $cs_xmlObject->inside_post_thumb_audio;
			$inside_post_thumb_video = $cs_xmlObject->inside_post_thumb_video;
			$inside_post_thumb_slider = $cs_xmlObject->inside_post_thumb_slider;
			$inside_post_thumb_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
	} else {
		$sub_title = '';
		$post_thumb_view = '';
		$post_featured_image_as_thumbnail = '';
		$post_thumb_audio = '';
		$post_thumb_video = '';
		$post_thumb_slider = '';
		$post_thumb_slider_type = '';
		$inside_post_thumb_view = '';
		$inside_post_featured_image_as_thumbnail = '';
		$inside_post_thumb_audio = '';
		$inside_post_thumb_video = '';
		$inside_post_thumb_slider = '';
		$inside_post_thumb_slider_type = '';

	}
?>
    <div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
        <div class="option-sec" style="margin-bottom:0;">
            <div class="opt-conts">
                <div class="elementhidden">
                    <div class="tabs vertical">
                        <nav class="admin-navigtion">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active"><a href="#tab-general-settings" data-toggle="tab"><i class="fa fa-toggle-right"></i><?php _e('General Settings','LMS');?></a></li>
                                <li><a href="#tab-subheader-options" data-toggle="tab"><i class="fa fa-list-alt"></i> <?php _e('Sub Header Options','LMS');?> </a></li>
                                <?php if($cs_builtin_seo_fields == 'on'){?>
                                <li><a href="#tab-seo-advance-settings" data-toggle="tab"><i class="fa fa-dribbble"></i> <?php _e('Seo Options','LMS');?></a></li>
                                <?php }?>
                                <li><a href="#tab-post-options" data-toggle="tab"><i class="fa fa-list-alt"></i> <?php _e('Post Settings','LMS');?> </a></li>
                                 <?php if($cs_header_position == 'absolute'){?>
                 				<li><a href="#tab-header-position-settings" data-toggle="tab"><i class="fa fa-forward"></i><?php _e('Header Absolute','LMS');?></a></li>
                 				<?php }?>
                                 
                          </ul>
                      </nav>
                        <div class="tab-content">
                         <div id="tab-general-settings" class="tab-pane fade active in">
                            <?php cs_general_settings_element(); ?>
                            <?php cs_sidebar_layout_options();?>
                        </div>
                        <div id="tab-subheader-options" class="tab-pane fade">
                            <?php cs_subheader_element();?>
                        </div>
                        <div id="tab-post-options" class="tab-pane fade">
                        	<?php if ( function_exists( 'cs_blog_post_general_options' ) ) {cs_blog_post_general_options();}?>
                        </div>
                       
                       <?php if($cs_builtin_seo_fields == 'on'){?>
                            <div id="tab-seo-advance-settings" class="tab-pane fade">
                                <div class="theme-help">
                                    <h4 style="padding-bottom:0px;"><?php _e('Seo Options','LMS');?></h4>
                                    <div class="clear"></div>
                                </div>
                                <?php cs_seo_settitngs_element();?>
                            </div>
                        <?php }
						if($cs_header_position == 'absolute'){?>
                        <!--- Content Tab --->
                        <div id="tab-header-position-settings" class="tab-pane fade">
                             <?php cs_header_postition_element();?>
                        </div>
                        <!--- Content Tab --->
                    <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
           <input type="hidden" name="post_meta_form" value="1" />
        </div>
    </div>
    <div class="clear"></div>
<?php
}
	if ( isset($_POST['post_meta_form']) and $_POST['post_meta_form'] == 1 ) {
		add_action( 'save_post', 'cs_meta_post_save' );
		function cs_meta_post_save( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
				if ( empty($_POST['post_social_sharing']) ) $_POST['post_social_sharing'] = "";
				if (empty($_POST["post_thumb_view"])){ $_POST["post_thumb_view"] = "";}
				if (empty($_POST["post_featured_image_as_thumbnail"])){ $_POST["post_featured_image_as_thumbnail"] = "";}
				if (empty($_POST["post_thumb_audio"])){ $_POST["post_thumb_audio"] = "";}
				if (empty($_POST["post_thumb_video"])){ $_POST["post_thumb_video"] = "";}
				if (empty($_POST["post_thumb_slider"])){ $_POST["post_thumb_slider"] = "";}
				if (empty($_POST["post_thumb_slider_type"])){ $_POST["post_thumb_slider_type"] = "";}
				if (empty($_POST["inside_post_thumb_view"])){ $_POST["inside_post_thumb_view"] = "";}
				if (empty($_POST["inside_post_featured_image_as_thumbnail"])){ $_POST["inside_post_featured_image_as_thumbnail"] = "";}
				if (empty($_POST["inside_post_thumb_audio"])){ $_POST["inside_post_thumb_audio"] = "";}
				if (empty($_POST["inside_post_thumb_video"])){ $_POST["inside_post_thumb_video"] = "";}
				if (empty($_POST["inside_post_thumb_slider"])){ $_POST["inside_post_thumb_slider"] = "";}
				if (empty($_POST["inside_post_thumb_slider_type"])){ $_POST["inside_post_thumb_slider_type"] = "";}
					$sxe = new SimpleXMLElement("<cs_meta_post></cs_meta_post>");
						$sxe->addChild('post_thumb_view', esc_attr($_POST['post_thumb_view']) );
						$sxe->addChild('post_featured_image_as_thumbnail', esc_attr($_POST['post_featured_image_as_thumbnail']) );
						$sxe->addChild('post_thumb_audio', esc_attr($_POST['post_thumb_audio']) );
						$sxe->addChild('post_thumb_video', esc_attr($_POST['post_thumb_video']) );
						$sxe->addChild('post_thumb_slider', esc_attr($_POST['post_thumb_slider']) );
						$sxe->addChild('post_thumb_slider_type', esc_attr($_POST['post_thumb_slider_type']) );
						$sxe->addChild('inside_post_thumb_view', esc_attr($_POST['inside_post_thumb_view']) );
						$sxe->addChild('inside_post_featured_image_as_thumbnail', $_POST['inside_post_featured_image_as_thumbnail'] );
						$sxe->addChild('inside_post_thumb_audio', esc_attr($_POST['inside_post_thumb_audio']) );
						$sxe->addChild('inside_post_thumb_video', esc_attr($_POST['inside_post_thumb_video']) );
						$sxe->addChild('inside_post_thumb_slider', esc_attr($_POST['inside_post_thumb_slider']) );
						$sxe->addChild('inside_post_thumb_slider_type', esc_attr($_POST['inside_post_thumb_slider_type']) );
						if ( isset($_POST['gallery_meta_form']) and $_POST['gallery_meta_form'] == 1 ) {
						$cs_counter = 0;
							if ( isset($_POST['path']) ) {
								foreach ( $_POST['path'] as $count ) {
										if (empty($_POST['path'][$cs_counter])){ $_POST['path'][$cs_counter] = "";}
										if (empty($_POST['title'][$cs_counter])){ $_POST['title'][$cs_counter] = "";}
										if (empty($_POST['use_image_as'][$cs_counter])){ $_POST['use_image_as'][$cs_counter] = "";}
										if (empty($_POST['video_code'][$cs_counter])){ $_POST['video_code'][$cs_counter] = "";}
										if (empty($_POST['link_url'][$cs_counter])){ $_POST['link_url'][$cs_counter] = "";}
										$gallery = $sxe->addChild('gallery');
										$gallery->addChild('path', esc_attr($_POST['path'][$cs_counter]) );
										$gallery->addChild('title', htmlspecialchars($_POST['title'][$cs_counter]) );
										$gallery->addChild('use_image_as', esc_attr($_POST['use_image_as'][$cs_counter]) );
										$gallery->addChild('video_code', htmlspecialchars($_POST['video_code'][$cs_counter]) );
										$gallery->addChild('link_url', htmlspecialchars($_POST['link_url'][$cs_counter]) );
										$cs_counter++;
								}
							}
						}
						if ( isset($_POST['gallery_slider_meta_form']) and $_POST['gallery_slider_meta_form'] == 1 ) {
						$cs_counter = 0;
							if ( isset($_POST['cs_slider_path']) ) {
								
								
								foreach ( $_POST['cs_slider_path'] as $count ) {
										if (empty($_POST['cs_slider_path'][$cs_counter])){ $_POST['cs_slider_path'][$cs_counter] = "";}
										if (empty($_POST['cs_slider_title'][$cs_counter])){ $_POST['cs_slider_title'][$cs_counter] = "";}
										if (empty($_POST['slider_use_image_as'][$cs_counter])){ $_POST['slider_use_image_as'][$cs_counter] = "";}
										if (empty($_POST['slider_video_code'][$cs_counter])){ $_POST['slider_video_code'][$cs_counter] = "";}
										if (empty($_POST['cs_slider_link'][$cs_counter])){ $_POST['cs_slider_link'][$cs_counter] = "";}
										$galleryInside = $sxe->addChild('gallery_slider');
										
										$galleryInside->addChild('cs_slider_path', esc_attr($_POST['cs_slider_path'][$cs_counter]) );
										$galleryInside->addChild('cs_slider_title', htmlspecialchars($_POST['cs_slider_title'][$cs_counter]) );
										$galleryInside->addChild('slider_use_image_as', esc_attr($_POST['slider_use_image_as'][$cs_counter]) );
										$galleryInside->addChild('slider_video_code', htmlspecialchars($_POST['slider_video_code'][$cs_counter]) );
										$galleryInside->addChild('cs_slider_link', htmlspecialchars($_POST['cs_slider_link'][$cs_counter]) );
										$cs_counter++;
								}
							}
						}
						$sxe = cs_page_options_save_xml($sxe);
						update_post_meta( $post_id, 'post', $sxe->asXML() );
			}
		}
 			if ( ! function_exists( 'cs_blog_post_general_options' ) ) {
				function cs_blog_post_general_options() {
					global $cs_xmlObject;
					if ( empty($cs_xmlObject->post_thumb_view) ) $post_thumb_view = ""; else $post_thumb_view = $cs_xmlObject->post_thumb_view;
					if ( empty($cs_xmlObject->post_featured_image_as_thumbnail) ) $post_featured_image_as_thumbnail = ""; else $post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
					if ( empty($cs_xmlObject->post_thumb_audio) ) $post_thumb_audio = ""; else $post_thumb_audio = $cs_xmlObject->post_thumb_audio;
					if ( empty($cs_xmlObject->post_thumb_video) ) $post_thumb_video = ""; else $post_thumb_video = $cs_xmlObject->post_thumb_video;
					if ( empty($cs_xmlObject->post_thumb_slider) ) $post_thumb_slider = ""; else $post_thumb_slider = $cs_xmlObject->post_thumb_slider;
					if ( empty($cs_xmlObject->post_thumb_slider_type) ) $post_thumb_slider_type = ""; else $post_thumb_slider_type = $cs_xmlObject->post_thumb_slider_type;
					if ( empty($cs_xmlObject->inside_post_thumb_view) ) $inside_post_thumb_view = ""; else $inside_post_thumb_view = $cs_xmlObject->inside_post_thumb_view;
					if ( empty($cs_xmlObject->inside_post_featured_image_as_thumbnail) ) $inside_post_featured_image_as_thumbnail = ""; else $inside_post_featured_image_as_thumbnail = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
					if ( empty($cs_xmlObject->inside_post_thumb_audio) ) $inside_post_thumb_audio = ""; else $inside_post_thumb_audio = $cs_xmlObject->inside_post_thumb_audio;
					if ( empty($cs_xmlObject->inside_post_thumb_video) ) $inside_post_thumb_video = ""; else $inside_post_thumb_video = $cs_xmlObject->inside_post_thumb_video;
					if ( empty($cs_xmlObject->inside_post_thumb_slider) ) $inside_post_thumb_slider = ""; else $inside_post_thumb_slider = $cs_xmlObject->inside_post_thumb_slider;
					if ( empty($cs_xmlObject->inside_post_thumb_slider_type) ) $inside_post_thumb_slider_type = ""; else $inside_post_thumb_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
					?>
                    <ul class="form-elements noborder">
                    <li class="to-label"><label><?php _e('Thumbnail View','LMS');?></label></li>
                    <li class="to-field">
                    	<div class="input-sec">
                            <div class="select-style">
                                <select name="post_thumb_view" class="dropdown" onchange="javascript:new_toggle(this.value)">
                                    <option <?php if($post_thumb_view=="Single Image")echo "selected";?> ><?php _e('Single Image','LMS');?></option>
                                    <option <?php if($post_thumb_view=="Slider")echo "selected";?> ><?php _e('Slider','LMS');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="left-info">
                        	<p id="post_thumb_image" style="display:<?php if($post_thumb_view=="Single Image" or $post_thumb_view == "")echo 'inline"';else echo 'none';?>"><?php _e('Use Featured Image as Thumbnail','LMS');?></p>
                        </div>
                    </li>
                        <ul class="form-elements" id="post_thumb_audio" style="display:<?php if($post_thumb_view=="Audio")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label><?php _e('Audio Url','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="input-sec">
                                    <input type="text" id="post_thumb_audio2" name="post_thumb_audio" value="<?php echo htmlspecialchars($post_thumb_audio)?>" class="txtfield" />
                                    <label class="cs-browse">
                                    	<input type="button" id="post_thumb_audio2" name="post_thumb_audio2" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
                                    </label>
                                </div>
                                <div class="left-info">
                                	<p><?php _e('Enter Specific Audio Url (Youtube, Vimeo and all otheres wordpress supported)','LMS');?></p>
                                </div>
                            </li>
                        </ul>
                        <ul class="form-elements" id="post_thumb_video" style="display:<?php if($post_thumb_view=="Video")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label><?php _e('Use featured image as video thumbnail','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="input-sec">
                                    <label class="pbwp-checkbox">
                                        <input type="checkbox" name="post_featured_image_as_thumbnail" value="on" class="styled" <?php if($post_featured_image_as_thumbnail=='on')echo "checked"?> />
                                        <span class="pbwp-box"></span>
                                        <input type="hidden" value="" name="showlogo">
                                    </label>
                                </div>
                                <div class="left-info">
                                	<p><?php _e('It will work only for self hosted vide','LMS');?>o</p>
                                </div>
                            </li>
                            <li class="full">&nbsp;</li>
                            <li class="to-label"><label><?php _e('Thumbnail Video Url','LMS');?></label></li>
                            <li class="to-field">
                            	<div class="input-sec">
                                    <input id="post_thumb_video2" name="post_thumb_video" value="<?php echo esc_attr($post_thumb_video);?>" type="text" class="small" />
                                    <label class="cs-browse">
	                                    <input id="post_thumb_video2" name="post_thumb_video2" type="button" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
                                    </label>
                                </div>
                                <div class="left-info">
                                	<p><?php _e('Enter Specific Video Url (Youtube, Vimeo and all otheres wordpress supported) OR you can select it from your media library','LMS');?></p>
                                </div>
                            </li>
                        </ul>
                </ul>
                    <div class="noborder post_slider" id="post_thumb_slider" style="display:<?php if($post_thumb_view=="Slider")echo 'inline';else echo 'none';?>" >
                       <?php echo cs_post_attachments('gallery_meta_form');?>
                    </div>
                    <ul class="form-elements noborder">
                        <li class="to-label"><label><?php _e('Inside Post Thumbnail View','LMS');?></label></li>
                        <li class="to-field">
                            <div class="input-sec">
                                <div class="select-style">
                                    <select name="inside_post_thumb_view" class="dropdown" onchange="javascript:new_toggle_inside_post(this.value)">
                                        <option <?php if($inside_post_thumb_view=="Single Image")echo "selected";?> ><?php _e('Single Image','LMS');?></option>
                                        <option <?php if($inside_post_thumb_view=="Audio")echo "selected";?> ><?php _e('Audio','LMS');?></option>
                                        <option <?php if($inside_post_thumb_view=="Video")echo "selected";?> value="Video"><?php _e('Video/Soundcloud','LMS');?></option>
                                        <option <?php if($inside_post_thumb_view=="Slider")echo "selected";?> ><?php _e('Slider','LMS');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="left-info">
                                <p id="inside_post_thumb_image" style="display:<?php if($inside_post_thumb_view=="Single Image" or $inside_post_thumb_view=="")echo 'inline"';else echo 'none';?>"><?php _e('Use Featured Image as Thumbnail','LMS');?></p>
                            </div>
                        </li>
                            <ul class="form-elements" id="inside_post_thumb_audio" style="display:<?php if($inside_post_thumb_view=="Audio")echo 'inline"';else echo 'none';?>" >
                                <li class="to-label"><label><?php _e('Audio Url','LMS');?></label></li>
                                <li class="to-field">
                                    <div class="input-sec">
                                        <input type="text" id="inside_post_thumb_audio2" name="inside_post_thumb_audio" value="<?php echo htmlspecialchars($inside_post_thumb_audio)?>" class="txtfield" />
                                        <label class="cs-browse">
                                            <input type="button" id="inside_post_thumb_audio2" name="inside_post_thumb_audio2" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
                                        </label>
                                    </div>
                                    <div class="left-info">
                                        <p><?php _e('Enter Specific Audio Url (Youtube, Vimeo and all otheres wordpress supported)','LMS');?></p>
                                    </div>
                                </li>
                            </ul>
                            <ul class="form-elements" id="inside_post_thumb_video" style="display:<?php if($inside_post_thumb_view=="Video")echo 'inline"';else echo 'none';?>" >
                                <li class="to-label"><label><?php _e('Use featured image as video thumbnail','LMS');?></label></li>
                                <li class="to-field">
                                    <div class="input-sec">
                                        <label class="pbwp-checkbox">
                                            <input type="checkbox" name="inside_post_featured_image_as_thumbnail" value="on" class="styled" <?php if($inside_post_featured_image_as_thumbnail=='on')echo "checked"?> />
                                            <span class="pbwp-box"></span>
                                            <input type="hidden" value="" name="showlogo">
                                        </label>
                                    </div>
                                    <div class="left-info">
                                        <p><?php _e('It will work only for self hosted video','LMS');?></p>
                                    </div>
                                </li>
                                <li class="full">&nbsp;</li>
                                <li class="to-label"><label><?php _e('Thumbnail Video Url','LMS');?></label></li>
                                <li class="to-field">
                                    <div class="input-sec">
                                        <input id="inside_post_thumb_video2" name="inside_post_thumb_video" value="<?php echo esc_attr($inside_post_thumb_video)?>" type="text" class="small" />
                                        <label class="cs-browse">
                                            <input id="inside_post_thumb_video2" name="inside_post_thumb_video2" type="button" class="uploadfile left" value="<?php _e('Browse','LMS')?>"/>
                                        </label>
                                    </div>
                                    <div class="left-info">
                                        <p><?php _e('Enter Specific Video Url(Youtube, Vimeo and all otheres wordpress supported) OR you can select it from your media library','LMS');?></p>
                                    </div>
                                </li>
                            </ul>
                    </ul>
                    <div class="" id="inside_post_thumb_slider" style="display:<?php if($inside_post_thumb_view=="Slider") echo 'inline';else echo 'none';?>" >
                         <?php echo cs_post_attachments('gallery_slider_meta_form');?>
                    </div>
                    <?php
				}
			}
	?>