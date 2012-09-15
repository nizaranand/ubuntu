////////////////////////////////////////////
// Simple Form Validation
// URL: http://themeforest.net/user/MsTrends
// By: Muhammad Faisal
////////////////////////////////////////////

(function($) {
	
	//same as $(document).ready();
	$(function() {
		
			/* PLUGIN: Code Starts Here */
			
			
			// Validation for Contact Form
			
				var requiredFields = 'input[class*="required"], textarea[class*="required"]';
				var emailField = 'input[name="sender_email"], input[class*="email_field"]';
				var spamField = 'input[name="question"]';
				var urlField = 'input[class*="url_field"]';
								   
				var allRequiredFields = requiredFields + ", " + emailField + ", " + spamField;
				var allSpecialFields = emailField + ", " + spamField;
				
				
				var spamProtection = $('form').attr('data-spam-enable');
				var reqEmail = $('form').attr('data-req-email');
				
								
				if(spamProtection == 1) {				
					var spamAnswer = $('input[name="answer"]').val().toLowerCase();
				}
				
				var emailFilter = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				var urlFilter = /^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/;
				
				$(allRequiredFields).val(''); // Reset Form Values on Refresh
				
				
				$('#contact_form, #commentform, #custom_form').submit( function(){ // Validate On Submit 
				var error = false;
				
				$(this).find(requiredFields).not(allSpecialFields).each(function(){ // Check if any required (excluding special fields) field is empty
					if ($.trim(this.value).length == 0) {
						$(this).next('span').remove();
						$(this).addClass('error').after('<span class="error">Required!</span>').fadeIn();
						error = true;
					} else {
						$(this).next('span').fadeOut();
						$(this).removeClass('error');
					}
				});
				
				$(this).find(emailField).each(function(){ // validate Email field
					if ($.trim(this.value).length == 0 && reqEmail != 0) {
						$(this).next('span').fadeOut();
						$(this).addClass('error').after('<span class="error">Required!</span>');
						error = true;
					} else if(!emailFilter.test($(this).val())) { // Email field requires validation even if not required
						$(this).next('span').fadeOut();
						$(this).addClass('error').after('<span class="error">Invalid!</span>');
						error = true;
					  } else {
						$(this).next('span').fadeOut();
						$(this).removeClass('error');
					  }
				});
				
				if(spamProtection == 1) {
					$(this).find(spamField).each(function(){ // validate Spam Protection field
						if ($.trim(this.value).length == 0) {
							$(this).next('span').fadeOut();
							$(this).addClass('error').after('<span class="error">Required!</span>');
							error = true;
						} else if($(this).val().toLowerCase() != spamAnswer) {
							$(this).next('span').fadeOut();
							$(this).addClass('error').after('<span class="error">Wrong Answer!</span>');
							error = true;
						} else {
							$(this).next('span').fadeOut();
							$(this).removeClass('error');
						}
					});
				}
				
					$(this).find(urlField).each(function(){ // validate URL field
						if(!urlFilter.test($(this).val()) && $.trim(this.value).length != 0) {
							$(this).next('span').fadeOut();
							$(this).addClass('error').after('<span class="error">Invalid!</span>');
							error = true;
						} else {
							$(this).next('span').fadeOut();
							$(this).removeClass('error');
						}
					});
				
				if (error) { // Do not submit form if 'error' is set to 'true'
					return false;
				} else {
					return true;
				}
					
					// update user interface
					$('#contact_form').html('Sending your message...');
					
				});
				
				

			/* PLUGIN: Code Ends Here */
	
	});
			

})(jQuery);
