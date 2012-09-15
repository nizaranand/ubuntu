/* Declare a namespace for the site */
var Site = window.Site || {};

/* Create a closure to maintain scope of the '$'
   and remain compatible with other frameworks.  */
(function($) {
		$.noConflict();
	//same as $(document).ready();
	$(function() {
		
			/****** Activate WP Default Uploader on Meta Panels ******/
			var header_clicked = false;
			var formfield = null;
			var imgFields = 'input[name*="[bg_img_url]"], input[name*="[bg_poster_img_url]"], input[name*="[gallery_img_url]"], input[name*="[slider_img_url]"]';
			var vidFields = 'input[name*="[bg_mp4_video_url]"], input[name*="[bg_ogg_video_url]"], input[name*="[bg_webm_video_url]"]';
			var audioFields = 'input[name*="[bg_aud_mp3_url]"], input[name*="[bg_aud_oga_url]"]';
			
			$(imgFields).live('click', function() {
				formfield = $(this).attr('name');
				tb_show('Upload Image', 'media-upload.php?type=image&amp;TB_iframe=true');
				header_clicked = true;
				return false;
			});
			
			$(vidFields).live('click', function() {
				formfield = $(this).attr('name');
				tb_show('Upload Video', 'media-upload.php?type=video&amp;TB_iframe=true');
				header_clicked = true;
				return false;
			});
			
			$(audioFields).live('click', function() {
				formfield = $(this).attr('name');
				tb_show('Upload Audio', 'media-upload.php?type=audio&amp;TB_iframe=true');
				header_clicked = true;
				return false;
			});

			// Store original function
			window.original_send_to_editor = window.send_to_editor;

			// If header is not clicked, we use the original function.
			window.send_to_editor = function(html) {
				if (header_clicked) {
				 source_url = $(html).attr('href').length != 0 ? $(html).attr('href') : $('img',html).attr('src');
				 $('input[name="'+ formfield +'"]').val(source_url);
					header_clicked = false;
					tb_remove();
				} else {
					window.original_send_to_editor(html);
				}
			}
			
		
			/****** Show/Hide Description ******/
			$(".toggle_container").hide(); 
			$(".trigger").click(function(e){
				e.preventDefault();
				$(this).next().slideToggle("fast");
			});
			
			// Fucntion to set Default Meta Panel Values & Show Hide Div based on this Value
			function setMetaPanel(wrapper_id, value_source) {
				
				if ( $(value_source).length > 0 ) { // execute only if source field exists
					
					// grab selected option value and store in variable
					var option_value = $(value_source + ':checked').val() ? $(value_source + ':checked').val().replace(/.php/g, "") : $(value_source).val().replace(/.php/g, "");
					
					// onLoad: show divs based on 'option_value' 
					$('#'+ wrapper_id +'').children().hide();
					$('#'+ wrapper_id +''+ ' ' +'.'+ option_value +'').show();
					
					if ( wrapper_id != null ) { 
					
						// onLoad: show div based on 'option_value' if changed
						$(''+ value_source +'').change(function () {
							var option_value = $(this).val().replace(/.php/g, "");
							$('#'+ wrapper_id +'').children().hide();
							$('#'+ wrapper_id +''+ ' ' +'.'+ option_value +'').show();
							
						});
						
						
					}
					
				}
				
				
			}
			
			
			setMetaPanel('template_type_wrapper', '#page_template');
			setMetaPanel('bg_wrapper', 'input[name=\"_bg_caption_meta[background_type]\"]');
			setMetaPanel('columnar_gallery_wrapper', 'input[name=\"_template_meta[gallery_style]\"]');
			
			
	});


	$(window).bind("load", function() {
		
		
	
	});
	
})(jQuery);