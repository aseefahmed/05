<?php

if ( ! function_exists( 'cs_pop_certificate' ) ) {
	function cs_pop_certificate() {
	   global $current_user;
	   $course_id		= $_POST['course_id'];
	   $transection_id	= $_POST['transection_id'];
	   $id				= $_POST['id'];
	   $uid				= $current_user->ID;
	   $certificates_user_array = array();
	   ob_start();
	   
	   $certificates_user_array = get_user_meta($uid, "user_certificates", true);
	   if ( isset($course_id) && $course_id != '' && array_key_exists($transection_id, $certificates_user_array) ) {
			$certificates_user_array = array();
			$certificates_user_array = get_user_meta($uid, "user_certificates", true);
			$certificateArray		 = $certificates_user_array[$transection_id];
			$content_post 			 = get_post($certificateArray['cs_user_certificate']);
			$content = $content_post->post_content;
			
			$cs_meta_certificate = get_post_meta($certificateArray['cs_user_certificate'], "cs_meta_certificate", true);
			$cs_certificate_print = '';
			if ( $cs_meta_certificate <> "" ) {
				$cr_xmlObject = new SimpleXMLElement($cs_meta_certificate);
				$cs_certificate_print = (string)$cr_xmlObject->var_cp_certificate_print;
			}

			$content = apply_filters('the_content', $content);
			
			$cs_certificate_name	= $certificateArray['cs_certificate_name'];
			
			$background_image	= '';
			$var_cp_background_image = $cr_xmlObject->var_cp_background_image;
			if ( isset ( $var_cp_background_image ) && $var_cp_background_image !='' ) {
				$background_image	= 'style="background:url('.$var_cp_background_image.'); background-repeat: no-repeat; background-position: bottom left;"';
			} else {
				//$background_image	= 'style="background:url('.get_template_directory_uri().'/assets/images/innerglobe.png); background-repeat: no-repeat; background-position: bottom left;"';
			}
			
			$signature_css = '';
			$var_cp_signature_css = $cr_xmlObject->var_cp_signature_css;
			if ( isset ( $var_cp_signature_css ) && $var_cp_signature_css !='' ) {
				$signature_css	= '<style scoped="scoped" type="text/css">'.$var_cp_signature_css.'</style>';
			}
			?>
			<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">"<?php echo esc_attr( $cs_certificate_name );?>" <?php esc_html_e('Certificate','EDULMS');?></h4>
                </div>
                <div class="modal-body">
			<?php if ( isset ( $cs_certificate_print ) && $cs_certificate_print == 'on' ) {?>
            <?php echo $signature_css;?>
            <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script> 
            <script type="text/javascript">
				var win=null;
				function printIt(printThis)
				{
					win = window.open();
					self.focus();
					win.document.open();
					win.document.write("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
					win.document.write('<html><head><title><?php echo esc_attr( $cs_certificate_name );?></title>');
					win.document.write('<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css" type="text/css" />');
					win.document.write(printThis);
					win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
					win.document.close();
					win.print();
					win.close();
				}

                function PrintElem(elem)
                {
					printIt($('#'+elem).html());
                }
            
                /*function Popup(data) 
                {
					var printWindow = window.open('', '', 'height=600,width=800');
					printWindow.document.write("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
					printWindow.document.write('<html><head><title><?php echo esc_attr( $cs_certificate_name );?></title>');
					printWindow.document.write('<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css" type="text/css" />');
					printWindow.document.write('</head><body >');
					printWindow.document.write(data);
					printWindow.document.write('</body></html>');
					printWindow.document.close();
					printWindow.print();
                }*/
            </script>
			<a href="javascript:;" onclick="PrintElem('print-certificate-<?php echo esc_js($id);?>')"><i class="fa fa-print"></i></a>
			<?php }?>
                  <div id="print-certificate-<?php echo esc_attr( $id );?>">
                      <div id="<?php echo str_replace(' ','',$cs_certificate_name);?>" <?php echo $background_image ;?>>
                        <?php echo do_shortcode($content);?>
                       </div>
                  </div>
			   </div>
			 </div>
		   </div>
		</div>
			
	<?php	
			$certificateData = ob_get_clean();
			echo  balanceTags( $certificateData, false );
			die(0);
		}
	}
	add_action('wp_ajax_cs_pop_certificate', 'cs_pop_certificate');
}