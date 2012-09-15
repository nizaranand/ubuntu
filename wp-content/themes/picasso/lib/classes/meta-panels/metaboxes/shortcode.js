/* Declare a namespace for the site */
var Site = window.Site || {};

/* Create a closure to maintain scope of the '$'
   and remain compatible with other frameworks.  */
(function($) {
		$.noConflict();
	//same as $(document).ready();
	$(function() {
		
			/****** Shortcode Generator Values ******/
			$("a#create_shortcode").click(function() {
				
				var win = window.dialogArguments || opener || parent || top;
				var shortcodeType = $('select[name="_shortcode_meta[shortcode_type]"] option:selected').val();
				
				if(shortcodeType == "video") { // Excecute if Video Shortcode is Selected
					
					var videoTypeVal = $('input[name="_shortcode_meta[video_type]"]:checked').val();

					var videoType = $('input[name="_shortcode_meta[video_type]"]:checked').val().length != 0 ? 'type="'+ $('input[name="_shortcode_meta[video_type]"]:checked').val() +'" ' : 'html-5';
					var videoId = $('input[name="_shortcode_meta[video_clip_id]"]').val().length != 0 ? 'clip_id="'+ $('input[name="_shortcode_meta[video_clip_id]"]').val() +'" ' : '';

					var finalShortcode = '[video '+ videoType + videoId +']';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "gallery") { // Excecute if Gallery Shortcode is Selected
				
					var galleryIndex = $('.gallery_index').size() - 2; // 1 for hidden div, 1 for array, array starts from 0
					var imgUrl = new Array();
					var imgLink = new Array();
					var finalShortcode = new Array();
					
					
					var lightboxScript = $('input[name="_shortcode_meta[lightbox_script]"]:checked').val().length != 0 ? 'lightbox="'+ $('input[name="_shortcode_meta[lightbox_script]"]:checked').val() +'" ' : 'fancybox';
					
					for (i=0 ;i<=galleryIndex; i++) {
					
						imgUrl[i] = $('input[name="_shortcode_meta[gallery_shortcode]['+ i +'][gallery_img_url]"]').val().length != 0 ? 'url="'+ $('input[name="_shortcode_meta[gallery_shortcode]['+ i +'][gallery_img_url]"]').val() +'" ' : '';
						imgLink[i] = $('input[name="_shortcode_meta[gallery_shortcode]['+ i +'][gallery_img_link]"]').val().length != 0 ? 'link="'+ $('input[name="_shortcode_meta[gallery_shortcode]['+ i +'][gallery_img_link]"]').val() +'" ' : '';
					
						finalShortcode[i] = '[image '+ imgUrl[i] +' '+ imgLink[i]+']<br />';
					
					} // end for loop
					
					
					win.send_to_editor('[image_gallery '+ lightboxScript +']<br />'+ finalShortcode.join("") +'[/image_gallery]');
					
				} else if(shortcodeType == "slider") { // Excecute if Slider Shortcode is Selected
				
					var sliderIndex = $('.slider_index').size() - 2; // 1 for hidden div, 1 for array, array starts from 0
					var imgUrl = new Array();
					var imgLink = new Array();
					var finalShortcode = new Array();
					
					
					for (i=0 ;i<=sliderIndex; i++) {
					
						imgUrl[i] = $('input[name="_shortcode_meta[slider_shortcode]['+ i +'][slider_img_url]"]').val().length != 0 ? 'url="'+ $('input[name="_shortcode_meta[slider_shortcode]['+ i +'][slider_img_url]"]').val() +'" ' : '';
						imgLink[i] = $('input[name="_shortcode_meta[slider_shortcode]['+ i +'][slider_img_link]"]').val().length != 0 ? 'link="'+ $('input[name="_shortcode_meta[slider_shortcode]['+ i +'][slider_img_link]"]').val() +'" ' : '';
					
						finalShortcode[i] = '[image '+ imgUrl[i] +' '+ imgLink[i]+']<br />';
					
					} // end for loop
					
					
					win.send_to_editor('[image_slider]<br />'+ finalShortcode.join("") +'[/image_slider]');
					
					
				} else if(shortcodeType == "toggle") { // Excecute if Toggle Shortcode is Selected
				
					var toggleTitle = $('input[name="_shortcode_meta[toggle_title]"]').val().length != 0 ? 'title="'+ $('input[name="_shortcode_meta[toggle_title]"]').val() +'" ' : '';
					var toggleContent = $('textarea[name="_shortcode_meta[toggle_content]"]').val().length != 0 ? $('textarea[name="_shortcode_meta[toggle_content]"]').val() : '';
					
					var finalShortcode = '[toggle  '+ toggleTitle +']'+ toggleContent +'[/toggle]';
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "tab") { // Excecute if Toggle Shortcode is Selected
				
					var tabIndex = $('.tab_index').size() - 2; // 1 for hidden div, 1 for array, array starts from 0
					var tabTitle = new Array();
					var tabContent = new Array();
					var finalShortcode = new Array();
					
					
					for (i=0 ;i<=tabIndex; i++) {
						
					tabTitle[i] = $('input[name="_shortcode_meta[tab_shortcode]['+ i +'][tab_title]"]').val().length != 0 ? 'title="'+ $('input[name="_shortcode_meta[tab_shortcode]['+ i +'][tab_title]"]').val() +'" ' : '';
					tabContent[i] = $('textarea[name="_shortcode_meta[tab_shortcode]['+ i +'][tab_content]"]').val().length != 0 ? $('textarea[name="_shortcode_meta[tab_shortcode]['+ i +'][tab_content]"]').val() : '';

					finalShortcode[i] = '[tab '+ tabTitle[i] +']' + tabContent[i] +'[/tab] <br />';
					
					} // end for loop
					
					
					win.send_to_editor('[tabs]<br />'+ finalShortcode.join("") +'[/tabs]');
					
				} else if(shortcodeType == "columns") { // Excecute if Accordion Shortcode is Selected
				
					var columnsLayout = $('select[name="_shortcode_meta[columns_layout]"] option:selected').val();
					
					if ( columnsLayout == "1" ) {
						
						finalShortcode = '[one_half]<br />Content goes here...<br />[/one_half]<br /><br />[one_half_last]<br />Content goes here...<br />[/one_half_last]<br />';
					
					} else if ( columnsLayout == "2" ) {
						
						finalShortcode = '[one_third]<br />Content goes here...<br />[/one_third]<br /><br />[one_third]<br />Content goes here...<br />[/one_third]<br /><br />[one_third_last]<br />Content goes here...<br />[/one_third_last]<br />';

					
					} else if ( columnsLayout == "3" ) {
						
						finalShortcode = '[one_fourth]<br />Content goes here...<br />[/one_fourth]<br /><br />[one_fourth]<br />Content goes here...<br />[/one_fourth]<br /><br />[one_fourth]<br />Content goes here...<br />[/one_fourth]<br /><br />[one_fourth_last]<br />Content goes here...<br />[/one_fourth_last]<br />';

					} else if ( columnsLayout == "4" ) {
						
						finalShortcode = '[one_fifth]<br />Content goes here...<br />[/one_fifth]<br /><br />[one_fifth]<br />Content goes here...<br />[/one_fifth]<br /><br />[one_fifth]<br />Content goes here...<br />[/one_fifth]<br /><br />[one_fifth]<br />Content goes here...<br />[/one_fifth]<br /><br />[one_fifth_last]<br />Content goes here...<br />[/one_fifth_last]<br />';

					} else if ( columnsLayout == "5" ) {
						
						finalShortcode = '[one_sixth]<br />Content goes here...<br />[/one_sixth]<br /><br />[one_sixth]<br />Content goes here...<br />[/one_sixth]<br /><br />[one_sixth]<br />Content goes here...<br />[/one_sixth]<br /><br />[one_sixth]<br />Content goes here...<br />[/one_sixth]<br /><br />[one_sixth]<br />Content goes here...<br />[/one_sixth]<br /><br />[one_sixth_last]<br />Content goes here...<br />[/one_sixth_last]<br />';

					} else if ( columnsLayout == "6" ) {
						
						finalShortcode = '[one_fourth]<br />Content goes here...<br />[/one_fourth]<br /><br />[three_fourth_last]<br />Content goes here...<br />[/three_fourth_last]<br />';

					} else if ( columnsLayout == "7" ) {
						
						finalShortcode = '[three_fourth]<br />Content goes here...<br />[/three_fourth]<br /><br />[one_fourth_last]<br />Content goes here...<br />[/one_fourth_last]<br />';

					} else if ( columnsLayout == "8" ) {
						
						finalShortcode = '[two_thirds]<br />Content goes here...<br />[/two_thirds]<br /><br />[one_third_last]<br />Content goes here...<br />[/one_third_last]<br />';

					} else if ( columnsLayout == "9" ) {
						
						finalShortcode = '[one_third]<br />Content goes here...<br />[/one_third]<br /><br />[two_thirds_last]<br />Content goes here...<br />[/two_thirds_last]<br />';

					}

					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "accordion") { // Excecute if Accordion Shortcode is Selected
				
					var accordionIndex = $('.accordion_index').size() - 2; // 1 for hidden div, 1 for array, array starts from 0
					var accordionTitle = new Array();
					var accordionContent = new Array();
					var finalShortcode = new Array();
					
					for (i=0 ;i<=accordionIndex; i++) {
					
					accordionTitle[i] = $('input[name="_shortcode_meta[accordion_shortcode]['+ i +'][accordion_title]"]').val().length != 0 ? 'title="'+ $('input[name="_shortcode_meta[accordion_shortcode]['+ i +'][accordion_title]"]').val() +'" ' : '';
					accordionContent[i] = $('textarea[name="_shortcode_meta[accordion_shortcode]['+ i +'][accordion_content]"]').val().length != 0 ? $('textarea[name="_shortcode_meta[accordion_shortcode]['+ i +'][accordion_content]"]').val() : '';

					finalShortcode[i] = '[accordion '+ accordionTitle[i] +']' + accordionContent[i] +'[/accordion] <br />';
					
					
					} // end for loop
					
					win.send_to_editor('[accordions]<br />'+ finalShortcode.join("") +'[/accordions]');
					
				} else if(shortcodeType == "map") { // Excecute if Google Maps Shortcode is Selected
				
					var mapType = $('input[name="_shortcode_meta[map_type]"]:checked').val().length != 0 ? 'maptype="'+ $('input[name="_shortcode_meta[map_type]"]:checked').val() +'" ' : 'ROADMAP';
					var mapWidth = $('input[name="_shortcode_meta[map_width]"]').val().length != 0 ? 'width="'+ $('input[name="_shortcode_meta[map_width]"]').val() +'" ' : '';
					var mapHeight = $('input[name="_shortcode_meta[map_height]"]').val().length != 0 ? 'height="'+ $('input[name="_shortcode_meta[map_height]"]').val() +'" ' : '';
					var mapZoom = $('input[name="_shortcode_meta[map_zoom]"]').val().length != 0 ? 'zoom="'+ $('input[name="_shortcode_meta[map_zoom]"]').val() +'" ' : '';
					var mapAddress = $('input[name="_shortcode_meta[map_address]"]').val().length != 0 ? 'address="'+  $('input[name="_shortcode_meta[map_address]"]').val() +'" ' : '';
					var mapInfo = $('textarea[name="_shortcode_meta[map_info_window]"]').val().length != 0 ? 'html="'+ $('textarea[name="_shortcode_meta[map_info_window]"]').val() +'" ' : '';
					var mapPopup = $('input[name="_shortcode_meta[show_popup]"]').is(':checked') ? 'popup="true"' : 'popup="false"';

					finalShortcode = '[gmap '+ mapType + mapWidth  + mapHeight + mapZoom  + mapAddress + mapInfo + mapPopup +'] <br />';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "buttons") { // Excecute if Buttons Shortcode is Selected
				
					
					var buttonColor = $('select[name="_shortcode_meta[button_color]"] option:selected').val().length != 0  ? 'color="'+ $('select[name="_shortcode_meta[button_color]"] option:selected').val() +'" ' : '';
					var buttonLink = $('input[name="_shortcode_meta[button_link]"]').val().length != 0 ? 'link="'+ $('input[name="_shortcode_meta[button_link]"]').val() +'"' : '';
					var buttonTxt = $('input[name="_shortcode_meta[button_text]"]').val().length != 0 ? $('input[name="_shortcode_meta[button_text]"]').val() : '';

					finalShortcode = '[button '+ buttonColor + buttonLink +']'+ buttonTxt +'[/button] <br />';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "boxes") { // Excecute if Boxes Shortcode is Selected
				
					var boxColor = $('select[name="_shortcode_meta[box_color]"] option:selected').val().length != 0 ? 'color="'+ $('select[name="_shortcode_meta[box_color]"] option:selected').val() +'"' : '';
					var boxContent = $('textarea[name="_shortcode_meta[box_content]"]').val().length != 0 ? $('textarea[name="_shortcode_meta[box_content]"]').val() : '';

					finalShortcode = '[box '+ boxColor +']'+ boxContent +'[/box] <br />';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "quote") { // Excecute if Block Quote Shortcode is Selected
				
					var quoteSource = $('input[name="_shortcode_meta[quote_source]"]').val().length != 0 ? 'source="'+ $('input[name="_shortcode_meta[quote_source]"]').val() +'"' : '';
					var quoteContent = $('textarea[name="_shortcode_meta[quote_content]"]').val().length != 0 ? $('textarea[name="_shortcode_meta[quote_content]"]').val() : '';

					finalShortcode = '[quote '+ quoteSource +']'+ quoteContent +'[/quote] <br />';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "dropcap") { // Excecute if Dropcap Shortcode is Selected
				
					var dropCapColor = $('select[name="_shortcode_meta[dropcap_color]"] option:selected').val().length != 0 ? 'color="'+ $('select[name="_shortcode_meta[dropcap_color]"] option:selected').val() +'"' : '';
					var dropCapContent = $('input[name="_shortcode_meta[dropcap_text]"]').val().length != 0 ? $('input[name="_shortcode_meta[dropcap_text]"]').val() : '';

					finalShortcode = '[dropcap '+ dropCapColor +']'+ dropCapContent +'[/dropcap]';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "high_light") { // Excecute if Highlight Shortcode is Selected
				
					var highlightColor = $('select[name="_shortcode_meta[highlight_color]"] option:selected').val().length != 0 ? 'color="'+ $('select[name="_shortcode_meta[highlight_color]"] option:selected').val() +'"' : '';
					var highlightContent = $('input[name="_shortcode_meta[highlight_text]"]').val().length != 0 ? $('input[name="_shortcode_meta[highlight_text]"]').val() : '';

					finalShortcode = '[highlight '+ highlightColor +']'+ highlightContent +'[/highlight] <br />';
					
					win.send_to_editor(finalShortcode);
					
				} else if(shortcodeType == "divider") { // Excecute if Divider Shortcode is Selected
				
					var dividerTop = $('input[name="_shortcode_meta[divider_top]"]').is(':checked') ? 'top="1"' : '';

					finalShortcode = '[divider '+ dividerTop +'] <br />';
					
					win.send_to_editor(finalShortcode);
					
					
				}
				
				return false;
				
			});
			
			
			/****** Core Function to Show/Hide Div's ******/
			function setMetaPanel(wrapper_id, value_source, default_value) {
				
				// Assign 'option_value' a value which might be saved or default value
				var saved_value = $(value_source + ':checked').val();
				var option_value = saved_value ? saved_value : default_value;
				
				// Set 'value_source' as checked if it is Null
				if ( saved_value == null ) { 
					$(value_source).filter("[value="+ default_value +"]").attr("checked","checked");
				};
				
				// Show divs based on 'option_value' onLoad
				$('#'+ wrapper_id +'').children().hide();
				$('.'+ option_value).show();
				
				
				if ( wrapper_id != null ) { 
				
					// Show div based on 'saved_value' if any value is saved before
					$(''+ value_source +'').change(function () {
						var option_value = $(this).val();
						$('#'+ wrapper_id +'').children().hide();
						$('.'+ option_value).show();
					});
					
					
				}
				
			}
			
			setMetaPanel('shortcode_type_wrapper', 'select[name="_shortcode_meta[shortcode_type]"]', null);
			setMetaPanel('video_type_wrapper', 'input[name="_shortcode_meta[video_type]"]', 'html-5');
			
			
			/****** Remove Extra Repeating Fields onLoad ******/
			$('.wpa_group-gallery_shortcode').not('.wpa_group-gallery_shortcode.first, .wpa_group-gallery_shortcode.last').remove();
			$('.wpa_group-gallery_shortcode.last input[name*="[gallery_img_url]"]').attr('name', '_shortcode_meta[gallery_shortcode][1][gallery_img_url]');
			$('.wpa_group-gallery_shortcode.last input[name*="[gallery_img_link]"]').attr('name', '_shortcode_meta[gallery_shortcode][1][gallery_img_link]');
			
			$('.wpa_group-slider_shortcode').not('.wpa_group-slider_shortcode.first, .wpa_group-slider_shortcode.last').remove();
			$('.wpa_group-slider_shortcode.last input[name*="[slider_img_url]"]').attr('name', '_shortcode_meta[slider_shortcode][1][slider_img_url]');
			$('.wpa_group-slider_shortcode.last input[name*="[slider_img_link]"]').attr('name', '_shortcode_meta[slider_shortcode][1][slider_img_link]');
			
			$('.wpa_group-tab_shortcode').not('.wpa_group-tab_shortcode.first, .wpa_group-tab_shortcode.last').remove();
			$('.wpa_group-tab_shortcode.last input[name*="[tab_title]"]').attr('name', '_shortcode_meta[tab_shortcode][1][tab_title]');
			$('.wpa_group-tab_shortcode.last textarea[name*="[tab_content]"]').attr('name', '_shortcode_meta[tab_shortcode][1][tab_content]');
			
			$('.wpa_group-accordion_shortcode').not('.wpa_group-accordion_shortcode.first, .wpa_group-accordion_shortcode.last').remove();
			$('.wpa_group-accordion_shortcode.last input[name*="[accordion_title]"]').attr('name', '_shortcode_meta[accordion_shortcode][1][accordion_title]');
			$('.wpa_group-accordion_shortcode.last textarea[name*="[accordion_content]"]').attr('name', '_shortcode_meta[accordion_shortcode][1][accordion_content]');
	});


	$(window).bind("load", function() {
		
		
	
	});
	
})(jQuery);