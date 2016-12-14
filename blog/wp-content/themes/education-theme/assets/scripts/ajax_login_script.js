jQuery(document).ready(function($) {
 
	 jQuery('form#ControlForm').on('submit', function(e){
        jQuery('.login-from div.status').html('<i class="fa fa-spinner fa-spin"></i>').fadeIn();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'user_login': jQuery('form#ControlForm #user_login').val(), 
                'user_pass': jQuery('form#ControlForm #user_pass').val(),
				'redirect_to': jQuery('form#ControlForm #redirect_to').val(), 
                'security': jQuery('form#ControlForm #security').val() },
            success: function(data){
				jQuery('.fa-spin').remove();
 				jQuery('.login-from div.status').addClass('status-message');
				
                if (data.loggedin == false){
                    jQuery('.status-message').html(data.message);
                }else if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });
});