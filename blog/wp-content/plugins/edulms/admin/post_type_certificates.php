<?php
if(!class_exists('post_type_certificates')){
		/**
		 * Quiz Post Type Class
		 */
		class post_type_certificates
		{
			/**
			 * The Constructor
			 */
			public function __construct()
			{
				// register actions
				add_action('init', array(&$this, 'cs_init'));
				add_action('admin_init', array(&$this, 'cs_admin_init'));
				// Add columns
				add_filter('manage_cs_certificates_posts_columns', array(&$this, 'certificates_columns_add'));
				add_action('manage_cs_certificates_posts_custom_column', array(&$this, 'certificates_columns'));
			} 

			/**
			 * hook into WP's init action hook
			 */
			public function cs_init()
			{
				// Initialize Post Type
				$this->cs_certificates_register();
				if ( isset($_POST['certificates_form']) and $_POST['certificates_form'] == 1 ) {
					add_action('save_post', array(&$this, 'cs_certificates_save'));
				}
			} // END public function init()
			
			/**
			 * Certificate Post Type
			 */
			public function cs_certificates_register() {  
				
				register_post_type( 'cs-certificates',	array(
									'labels'             => array(
									'name'               => __( 'Certificates', 'EDULMS' ),
									'singular_name'      => __( 'Certificates', 'EDULMS' ),
									'menu_name'          => _x( 'Certificates', 'Admin menu name', 'EDULMS' ),
									'add_new'            => __( 'Add Certificates', 'EDULMS' ),
									'add_new_item'       => __( 'Add New Certificates', 'EDULMS' ),
									'edit'               => __( 'Edit', 'EDULMS' ),
									'edit_item'          => __( 'Edit Certificates', 'EDULMS' ),
									'new_item'           => __( 'New Certificates', 'EDULMS' ),
									'view'               => __( 'View Certificates', 'EDULMS' ),
									'view_item'          => __( 'View Certificates', 'EDULMS' ),
									'search_items'       => __( 'Search Certificates', 'EDULMS' ),
									'not_found'          => __( 'No Certificate found', 'EDULMS' ),
									'not_found_in_trash' => __( 'No Certificate found in trash', 'EDULMS' ),
									'parent'             => __( 'Parent Certificates', 'EDULMS' )
								),
							'description'         => __( 'This is where you can add new Certificates.', 'EDULMS' ),
							'public'              => true,
							'show_ui'             => true,
							'capability_type'     => 'post',
							'show_in_menu' 		  => 'edit.php?post_type=courses',
							'map_meta_cap'        => true,
							'menu_icon' 		  => 'dashicons-admin-post',
							'publicly_queryable'  => true,
							'exclude_from_search' => false,
							'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
							'rewrite'             => false,
							'query_var'           => true,
							'menu_position' 	  => null,
							'supports' 			  => array('title','editor','thumbnail'),
							'has_archive'         => 'cs-certificates',
						)
					);

			}// END public function cs_certificates_register
			
			/**
			 * hook into WP's admin_init action hook
			 */
			public function cs_admin_init()
			{           
				// Add metaboxes
				add_action( 'add_meta_boxes', array( &$this, 'cs_meta_certificates_add') );
				
				
			} // END public function admin_init()
			
			/**
			 * Certificate add Meta fields
			 */
			public function cs_meta_certificates_add()
			{  
				add_meta_box( 'cs_meta_certificate', __('Certificates Options','EDULMS'), array(&$this, 'cs_meta_certificates'), 'cs-certificates', 'normal', 'high' );  
			}

			public function cs_meta_certificates( $post ) {
				
				global $cs_xmlObject;
				$cs_meta_certificate = get_post_meta($post->ID, "cs_meta_certificate", true);
				if ( $cs_meta_certificate <> "" ) {
					$cs_xmlObject = new SimpleXMLElement($cs_meta_certificate);
						$var_cp_background_image = $cs_xmlObject->var_cp_background_image;
						$var_cp_certificate_print = $cs_xmlObject->var_cp_certificate_print;
						$var_cp_signature_css = $cs_xmlObject->var_cp_signature_css;
				} else {
						$var_cp_background_image = '';
						$var_cp_certificate_print = '';
						$var_cp_signature_css = '';
						$var_cp_certificate_print = 'on';
				}
				?>
                <div class="page-wrap">
                    <div class="option-sec" style="margin-bottom:0;">
                        <div class="opt-conts">
                            <ul class="form-elements">
                                <li class="to-label"><label><?php _e('Custom Background Image','EDULMS');?></label></li>
                                <li class="to-field">
                                    <div class="input-sec">
                                    <input id="var_cp_background_image" name="var_cp_background_image" value="<?php echo esc_url($var_cp_background_image);?>" type="hidden" class="small" />
                                    <input id="var_cp_background_image" name="var_cp_background_image" type="button" class="uploadMedia  left" value="<?php _e('Browse','EDULMS');?>"/>
                                    </div>
                                </li>
                            </ul>
                            <div class="page-wrap" style="overflow:hidden; display:<?php echo isset($var_cp_background_image) && trim($var_cp_background_image) !='' ? 'inline' : 'none';?>" id="var_cp_background_image_box" >
                              <div class="gal-active">
                                <div class="dragareamain" style="padding-bottom:0px;">
                                  <ul id="gal-sortable">
                                    <li class="ui-state-default" id="">
                                      <div class="thumb-secs"> <img src="<?php echo esc_url($var_cp_background_image);?>"  id="var_cp_background_image_img" width="100" height="150"  />
                                        <div class="gal-edit-opts"> <a   href="javascript:del_media('var_cp_background_image')" class="delete"></a> </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Enable Print','EDULMS');?></label>
                              </li>
                              <li class="to-field">
                                <label class="pbwp-checkbox">
                                  <input type="hidden" name="var_cp_certificate_print" value=""/>
                                  <input type="checkbox" class="myClass" name="var_cp_certificate_print" <?php if ($var_cp_certificate_print== "on") echo "checked" ?>/>
                                  <span class="pbwp-box"></span> </label>
                              </li>
                            </ul>              
                            <ul class="form-elements noborder">
                                <li class="to-label"><label><?php _e('Custom CSS','EDULMS');?></label></li>
                                <li class="to-field">
                                    <div class="input-sec">
                                    <textarea name="var_cp_signature_css" id="var_cp_signature_css" rows="10" cols="20" /><?php echo esc_attr($var_cp_signature_css) ?></textarea>
                                     </div>
                                </li>
                            </ul>   
                            <ul class="form-elements noborder">
                                <li class="to-label"><label><?php _e('NOTE','EDULMS');?></label></li>
                                <li class="to-field">
                                       <p><?php _e('USE FOLLOWING SHORTCODES TO DISPLAY RELEVANT DATA','EDULMS');?></p>
                                       <ul>
                                        <li><span>1.</span> [cs_member_name] : Displays Students Name</li>
                                        <li><span>2.</span> [cs_course_name] : Displays Course Name</li>
                                        <li><span>3.</span> [cs_taken_marks] : Displays Students Marks % in Course </li>
                                        <li><span>4.</span> [cs_completion_date] : Course Completion Date </li>
                                        <li><span>5.</span> [cs_certificate_code] : Unique code for Certificate</li>
                                     </ul>
                                </li>
                            </ul>                  
        
                        </div>
                    </div>
                    <input type="hidden" name="certificates_form" value="1" />
                    <div class="clear"></div>
                </div>
    <?php
	}
			/**
			 * Certificate Save Meta fields
			 */
			public function cs_certificates_save( $post_id ) {  
			$sxe = new SimpleXMLElement("<certificates></certificates>");
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
			if ( empty($_POST["var_cp_background_image"]) ) $_POST["var_cp_background_image"] = "";
			if ( empty($_POST["var_cp_certificate_print"]) ) $_POST["var_cp_certificate_print"] = "";
			if ( empty($_POST["var_cp_signature_css"]) ) $_POST["var_cp_signature_css"] = "";
			$sxe->addChild('var_cp_background_image', $_POST['var_cp_background_image'] );	
			$sxe->addChild('var_cp_certificate_print', $_POST['var_cp_certificate_print'] );
			$sxe->addChild('var_cp_signature_css', $_POST['var_cp_signature_css'] );
			$counter = 0;
			if ( function_exists( 'cs_page_options_save_xml' ) ) {
				//$sxe = cs_page_options_save_xml($sxe);
			}
			update_post_meta( $post_id, 'cs_meta_certificate', $sxe->asXML() );
		}
		
			/**
			 * Author Column
			 */
			public function certificates_columns_add($columns) {
				$columns['author'] = 'Author';
				return $columns;
			}
			/**
			 * Author Column
			 */
			public function certificates_columns($name) {
				global $post;
				switch ($name) {
					case 'author':
						echo get_the_author();
						break;
				}
			}
	}
}

/**
 * @Generate Random String
 *
 *
 */
if ( ! function_exists( 'cs_generate_random_string' ) ) {
	function cs_generate_random_string($length = 3) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}

/**
 * @Generate Random number
 *
 *
 */
if ( ! function_exists( 'cs_generate_random_integers' ) ) {
	function cs_generate_random_integers($length = 7) {
		$characters = '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}