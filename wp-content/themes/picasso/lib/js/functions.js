/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/

(function($) {
	
$(function() { 	//same as $(document).ready(); (Document is ready when the only HTML DOM is loaded, NOT its content e.g Images, Videos etc)

	
/*-----------------------------------------------------------------------------------*/
/*	Global Variables
/*-----------------------------------------------------------------------------------*/

		var bgType = $('body').attr('data-bg-type');
	
	
/*-----------------------------------------------------------------------------------*/
/*	Superfish Settings - http://users.tpg.com.au/j_birch/plugins/superfish/
/*-----------------------------------------------------------------------------------*/

		$("ul#navigation").superfish({
			delay: 800,
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			autoArrows: false,
			dropShadows: false
		}).supposition();  // call supersubs first, then superfish, so that subs are 
						 // not display:none when measuring. Call before initialising 
						 // containing tabs for same reason.
						 
						 
/*-----------------------------------------------------------------------------------*/
/*	Remove no-js class onLoad
/*-----------------------------------------------------------------------------------*/
	
		$('body').removeClass('no-js');	
		
		
/*-----------------------------------------------------------------------------------*/
/*	Background Video
/*-----------------------------------------------------------------------------------*/


		var bgVideoContainer = $('#video_background');
		var bgVideoOrigWidth = 16;
		var bgVideoOrigHeight = 9;

		function centerVideoBg() { // Centeralize Video BG
		  
			var videoWidth = bgVideoContainer.width();
			var videoHeight = bgVideoContainer.height();
			var marginLeft = -(videoWidth / 2);
			var marginTop = -(videoHeight / 2);
			
			bgVideoContainer.css('margin-left', marginLeft+'px');
			bgVideoContainer.css('margin-top', marginTop+'px');
				
		}
		
		var getProportion = function () { // Get Original Aspect Ratio of Video BG
		  var windowWidth = $(window).width();
		  var windowHeight = $(window).height();
		  var windowProportion = windowWidth / windowHeight;
		  var origProportion = bgVideoOrigWidth / bgVideoOrigHeight;
		  var proportion = windowHeight / bgVideoOrigHeight;
		  
		  if (windowProportion >= origProportion) {
			proportion = windowWidth / bgVideoOrigWidth;
		  }
		  
		  return proportion;
		}
		
		var setProportion = function () { // Make Video Full Screen
		  var proportion = getProportion();
		  bgVideoContainer.width(proportion*bgVideoOrigWidth);
		  bgVideoContainer.height(proportion*bgVideoOrigHeight);
		}
		
		
		// Initiate Function onLoad
		bgVideoContainer.fadeIn(2000);
		setProportion();
		centerVideoBg();
		
		// Initiate Function onResize
		$(window).resize(function() { 
								  
			setProportion();
			centerVideoBg();
			
		});


	
		
		if ( bgType == 'video' ) {
			
			var bgVideo = $('body').attr('data-bg-video').split(',');
			var bgVideoAuto = bgVideo[0];
			var bgVideoLoop = bgVideo[1];
			var bgVideoAudio = bgVideo[2];
			
			
			if ( bgVideoAudio == 1 ) { // if audio enabled
				
				// Video Audio
				$('#toggle_audio').toggle(function() {
					$(this).removeClass('play').addClass('pause');
					$("#video_background").prop('muted', true); //mute
				}, function() {
					$(this).removeClass('pause').addClass('play');
					$("#video_background").prop('muted', false); //unmute
				});
				
			}			
			
			// Video Play/Pause
			$('#toggle_slide').on('click', function() {
													
				if($('#video_background').get(0).paused || $('#video_background').get(0).ended) {
					$(this).removeClass('play').addClass('pause');
					$('#video_background').get(0).play();
				} else {
					$(this).removeClass('pause').addClass('play');
					$('#video_background').get(0).pause();
				}					
					
			});
				
			
			if ( bgVideoAuto == 1 ) { // if autoplay enabled
			
				$('#toggle_slide').removeClass('play').addClass('pause');
				
			} else if ( bgVideoAuto == 0 ) { // if autoplay disabled
				
				$('#toggle_slide').removeClass('pause').addClass('play');
				
			}
			
			if ( bgVideoLoop == 0 ) { // if not loop
			
				//on video ending
				$('#video_background').livequery('ended', function () {
					$('#toggle_slide').removeClass('pause').addClass('play');
				});
				
			}
			
			
			// Remove Supersized Elements
			$('#supersized, #supersized-loader').remove();
		
		}
		
		
/*-----------------------------------------------------------------------------------*/
/*	Background Audio
/*-----------------------------------------------------------------------------------*/

		var bgAudio = $('body').attr('data-bg-audio').split(',');
		
		var bgAudioMp3 = bgAudio[0];
		var bgAudioOga = bgAudio[1];
		
		var bgAudioEnable = bgAudio[2];
		var bgAudioAuto = bgAudio[3];
		var bgAudioLoop = (bgAudio[4] == 1 ? true : false);
		
		
		if ( bgAudioEnable == 1 ) { // initiate audio only if enabled
		
		
			var bgAudio = new buzz.sound([ bgAudioMp3, bgAudioOga ], {
				loop: bgAudioLoop			
			});	
			
			
			if ( bgAudioAuto == 1 ) { // if autoplay enabled
			
				bgAudio.play().fadeIn();	
				
				$('#toggle_audio').toggle(function() {
					$(this).removeClass('play').addClass('pause');
					bgAudio.pause();
				}, function() {
					$(this).removeClass('pause').addClass('play');
					bgAudio.play();
				});
			
			} else { // if not autoplay
				
				$('#toggle_audio').removeClass('play').addClass('pause');
				
				$('#toggle_audio').toggle(function() {
					$(this).removeClass('pause').addClass('play');
					bgAudio.play();
				}, function() {
					$(this).removeClass('play').addClass('pause');
					bgAudio.pause();
				});
			
			}		
			
			
			
		}
		
		
		
/*-----------------------------------------------------------------------------------*/
/*	Flex Slider Configuration
/*-----------------------------------------------------------------------------------*/
		
		
		// fadeIn slides after image loading
		$('.flexslider .slides > li:first-child, .flexslider .nested_slides > li:first-child').each(function(e) {
			$(this).imagesLoaded( function(){
										   
					$(this).fadeIn();
					
			});														
		});
		
		
		// Footer (Lower Resolution)
		$('.flexslider:not(#smartphone_footer .flexslider, .quote_widget .flexslider)').livequery(function() {
		
			$(this).flexslider({
				directionNav: true,
				slideshow: false,
			});	
		
		});
		
		// Footer (Lower Resolution)
		$('#smartphone_footer .flexslider:not(.quote_widget .flexslider)').livequery(function() {
		
			$(this).flexslider({
				slideshow: false,
				directionNav: true,
				controlNav: false
			});	
		
		});
		
		// Twitter Widget
		$('.quote_widget .flexslider').livequery(function() {
		
			$(this).flexslider({
				slideshow: false,
				directionNav: true,
				controlNav: false,
				slidesContainer: ".nested_slides"
			});	
		
		});
		
		
		// Portfolio Directional Navigation
		$('.flex_img_slider').hover(function() {
			$('.flex-direction-nav', this).fadeIn();
		}, function() {
			$('.flex-direction-nav', this).fadeOut();
		});
		
		
/*-----------------------------------------------------------------------------------*/
/*	Initiate Lighbox
/*-----------------------------------------------------------------------------------*/

	//load colorbox
	$('a[rel^="colorbox"]').colorbox();	
	
	//load prettyphoto
	$('a[rel^="prettyphoto"]').prettyPhoto({
		animationSpeed: 'normal',
		show_title: true,
		theme:'dark_square',
		overlay_gallery: true,
		social_tools: false
	});
	
	//load facnybox
		$('a[rel^="fancybox"]').fancybox({
		'titlePosition'		: 'outside',								 
		'overlayOpacity'	: '0.9',
		'overlayColor' 		: 'black',
		'transitionIn' : 'elastic',
		'transitionOut' : 'fade',
		'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
		    return '<span class="title_content">' + title +'</span><div id="fancybox-title-over"><span class="gallery_counter"> image ' +  (currentIndex + 1) + ' of ' + currentArray.length + '</span></div>';
		}		
	});	
		
		
/*-----------------------------------------------------------------------------------*/
/*	Thumbnail Overlay
/*-----------------------------------------------------------------------------------*/

		$('span.thumb_img').after('<span class="thumb_overlay"></span>');	
		
		function thumb_hover() {
		
			$('ul.slides:not(.no_thumb_overlay) li, ul.gallery_entries:not(.no_thumb_overlay) li, ul.similiar_entries:not(.no_thumb_overlay) li').hoverIntent(function() {
				$(this).find("span.thumb_overlay").fadeTo('slow', 0.6);
				$(this).find(".flex-caption").fadeTo('slow', 0);
			}, function() {
				$(this).find("span.thumb_overlay").fadeTo('slow', 0);
				$(this).find(".flex-caption").fadeTo('slow', 1);
			});
		
		}
		
		thumb_hover(); // initiate thumbnail hover effect
		
		
		
/*-----------------------------------------------------------------------------------*/
/*	Make List Blog Thumb Vertically Center
/*-----------------------------------------------------------------------------------*/


		function centeralizeBlogThumb() {
		
			$('.blog_list .blog_entry .flexslider li .thumb_img').imagesLoaded( function(){
																						 
			
				if( window.innerWidth <= 767 ) { // If Res. is upto 767
				
					$(this).each(function(e) {
																						
						var imgContainerHeight = $(this).height();
						var imgHeight = $('img', this).height();
						var imgMarginTop = -(imgHeight - imgContainerHeight) / 2;
						
						$('img', this).css('margin-top', imgMarginTop +'px');
						
					
					});
					
				} else {
					
						$('.blog_list .blog_entry .flexslider li .thumb_img img').css('margin-top', 0);
					
				}
				
				
			});														

		}
		
		centeralizeBlogThumb(); /* Set Dimension on Load */
		
		$(window).resize(function() { /* Set Margin on Resize */
								  
			centeralizeBlogThumb();
			
		});
		
		
			
/*-----------------------------------------------------------------------------------*/
/*	Masonry Grid Layout
/*-----------------------------------------------------------------------------------*/

		var galleryMasonry = $('.gallery_entries').hasClass('masonry_enabled');
		var gridEntryWidth = $('.gallery_entries').hasClass('gallery_grid') ? 0 : 2;
		
		if(galleryMasonry) { // execute only if masonry is enabled
		
			function msMasonry() {
				
					var columnWidth = $('.grid_entry').width() + gridEntryWidth;
					var columnMargin = parseInt( $('.grid_entry').css('marginRight') );
					
					// Execute Masonry AFTER images loading
					$('.gallery_entries').imagesLoaded( function(){
																 
						  $(this).masonry({
								// options
								itemSelector: '.grid_entry',
								gutterWidth: columnMargin,
								isAnimated: true,
								columnWidth: function( containerWidth  ) {
									return columnWidth; /* << */
								}
						  });
					  
					});	
	
			}
			
			msMasonry(); /* Set Dimension on Load */
			
			$(window).resize(function() { /* Set Dimension on Resize */
									  
				msMasonry();
				
			});
		
		}
			
			
		
/*-----------------------------------------------------------------------------------*/
/*	Cenrtralize Caption - (In Low Res. Devices)
/*-----------------------------------------------------------------------------------*/
		
		function centeralizeCaption() {
		
			var windowWidth = $(window).width();
			var wrapperWidth = $('#wrapper').width();
			var captionLeft = (windowWidth - wrapperWidth) / 2;
			
			
			$('#bg_slide_caption h2').animate({ paddingLeft : captionLeft+'px', opacity : 1 }, 650, '' );
			
			// center caption in small resolution devies
			if( window.innerWidth <= 1023 ) { // If Res. is upto 1023
			
				var captionWidth = $('#bg_slide_caption h2').width();
				var captionLeft = (windowWidth - captionWidth - 40) / 2;
				
				$('#bg_slide_caption').css('margin-left', captionLeft+'px');
				
			}
		
		}
		
		centeralizeCaption();
		
		$(window).resize(function() { /* Set position on Resize */
								  
			centeralizeCaption();
			
		});
		
			
				
				
/*-----------------------------------------------------------------------------------*/
/*	Smartphone Main Menu
/*-----------------------------------------------------------------------------------*/

		
		$('#menu_button a').toggle(function() { // first click
											
			
			
			// set menu postion from top and change controller icon
			var headerHeight = $('.site_header').height();
			var compactFoldTop = headerHeight + 18;
			
			$(this).removeClass('plus').addClass('minus');
			$('#smart_menu').css('top', compactFoldTop+'px');
											
			
			// fadeIn menu
			if ( $('#main_content').length > 0 ) { // if not home page
				
				makeFoldCompact();
				$('#main_body, #smartphone_footer.low_res_block').fadeOut('normal', function() {
														  
					$('#smart_menu').fadeIn();
														  
				});
				
			} else { // if home page
				
				$('#bg_slide_caption').fadeOut('normal', function() {
														  
					$('#smart_menu').fadeIn();
														  
				});
				
				if( window.innerWidth <= 767 ) { // If Res. is upto 767
				
					$('#bg_nav').fadeOut();
					
				}
				
			
			}
			
		}, function() { // second click
			
			// fadeOut menu and change controller icon
			$(this).removeClass('minus').addClass('plus');
			$('#smart_menu').fadeOut('normal', function() {
													  
				$('#main_body, #smartphone_footer.low_res_block').fadeIn();
													  
			});
			
			if ( $('#main_content').length <= 0 ) { // if home page
				
				$('#bg_slide_caption, #bg_nav').fadeIn();	
				
			}
			
			
			
		});
		
		
		
/*-----------------------------------------------------------------------------------*/
/*	Resize Elements Adjuster
/*-----------------------------------------------------------------------------------*/

		
		$(window).resize(function() {
								  
			if( window.innerWidth >= 1024 ) { // If Res. is above 1024 x 768
			
					makeFoldCompact();
					
					$('#main_body, #bg_nav').fadeIn();
					// $('#smart_menu, #footer.low_res_block').fadeOut();
			
			}
			
		});
		
		
/*-----------------------------------------------------------------------------------*/
/*	Toggle Fold Style
/*-----------------------------------------------------------------------------------*/

		function makeFoldFull() {
		
			// set fold postion from top
			var wrapperHeight = $(window).height();
			var fullFoldTop = wrapperHeight - 74;
			
			$('#main_content').removeClass('compact').addClass('full').animate({ top : fullFoldTop+'px' });
			
			// change fold icon, fadeIn caption & pagination
			$('#toggle_fold a').removeClass('collapse').addClass('expand')
			
			
			if( window.innerWidth == 480 ) { // if iphone landscape
			
				$('#main_content').animate({ top : '450px' });
			
			}
			
			if( window.innerWidth <= 767 ) { // If Res. is upto 767
			
				$('#bg_nav').fadeIn();
				
			}
		}
		
		function makeFoldCompact() {
		
			var headerHeight = $('.site_header').height();
			var compactFoldTop = headerHeight + 18;
			
			$('#main_content').removeClass('full').css('top', '').addClass('compact').animate({ top : compactFoldTop+'px' });
			$('#toggle_fold a').removeClass('expand').addClass('collapse');
			
			if( window.innerWidth <= 767 ) { // If Res. is upto 767
			
				$('#bg_nav').fadeOut();
				
			}
			
		}
		
		// set fold postion from top on load
		$('.site_logo .img_logo').imagesLoaded( function(){
											 
			
			if ( $('#main_content').length > 0 ) { // if not home page
				
				makeFoldCompact();
				
			}
			
			if ( $('#main_content').length <= 0 && window.innerWidth == 480 ) { // if home page and iphone landscape
				
				$('#wrapper').height(460);
				
			}
				
			
		
		});	
		
		
		$('#toggle_fold').toggle(function() {
										  
			 makeFoldFull();
			
		}, function() {
			
			 makeFoldCompact();
			
		});
		
		
		$(window).resize(function() { /* set fold postion from top on resize */
			
			if ( $('#toggle_fold a').hasClass('expand') ) {
				
				makeFoldFull();
			
			} else if ( $('#toggle_fold a').hasClass('collapse') ) {
				
				makeFoldCompact();
				
			}
			
		});
		
		
	
/*-----------------------------------------------------------------------------------*/
/*	Forms
/*-----------------------------------------------------------------------------------*/
	
		// submit form
		$('.submit_button').click(function(e) {
			e.preventDefault();
			$(this).parents('form:first').submit();
		});
		
		// inline labels
		$('input, textarea').focus(function() {
			$(this).parent().find('label').fadeOut('fast');
		});
		
		$('input, textarea').focusout(function() {
		  if($(this).val().length == 0) {
				$(this).parent().find('label').fadeIn('fast');
		  }
		});
		
		
	
	
/*-----------------------------------------------------------------------------------*/
/*	Adjust Wrapper Height
/*-----------------------------------------------------------------------------------*/

		var documentHeight = $(document).height();
		
		$('#wrapper.home').height(documentHeight);
		
		
	
/*-----------------------------------------------------------------------------------*/
/*	Expandable Categories Menu
/*-----------------------------------------------------------------------------------*/
			
		$('ul.menu ul.sub-menu, .widget ul ul.children').hide();
		
		$('ul.menu li ul, .widget ul li ul').click(function(e) {
			e.stopPropagation();
		});
		
		$('ul.menu li:has(> ul), .widget ul li:has(> ul)').toggle(function() {
			$(this).children().slideDown('slow');
			$(this).css('padding-bottom','0');
		}, function() {
			$(this).children('ul').slideUp('slow');
			$(this).css('padding-bottom','10px');
		});
	
	
/*-----------------------------------------------------------------------------------*/
/*	Smooth Scrolling
/*-----------------------------------------------------------------------------------*/
	
	  // Scroll to Top
	  $("#back_to_top a").hide();
	   
		if( window.innerWidth >= 768 ) { // If Res. is above or equal 768
		
		   $(window).scroll(function() {
				if ($(window).scrollTop() == "0") {
					$('#back_to_top a').fadeOut()
				} else {
					$('#back_to_top a').fadeIn()
				}
			});	
			
			$('#back_to_top a').click(function(e) {
				e.preventDefault();							   
				$.scrollTo("#wrapper", 800);
			})
			
		} 
		
		
		// Scroll to Page Header
		$('.top_link a').click(function(e) {
			e.preventDefault();
			$.scrollTo("#main_content_header", 800); // Scroll To Breadcrumbs
		});
		
		
/*-----------------------------------------------------------------------------------*/
/*	Tabs & Accordions
/*-----------------------------------------------------------------------------------*/
		
		
		// jQuery Tabs
		$('.tabs_container .tabs li:first-child').addClass("current");	
		$('.tabs_container .panes .pane:not(:first-child)').each(function(e) {
				$(this).hide();													
		});
		
		$('.tabs_container .tabs li').click(function(e) {
			e.preventDefault();
			var tab = $(this).index() + 1;
			
			$(this).parents().find('.tabs_container .tabs li').removeClass('current');
			$(this).addClass('current');
			
			$('.tabs_container .panes .pane').hide();
			$('.tabs_container .panes .pane:nth-child('+ tab +')').fadeIn("slow");
		});
		
		
		// jQuery Accordion
		$('.accordion .pane:not(:first)').hide();
		$('.accordion .tab').click(function() {
			if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
				$('.accordion .pane').slideUp();
				$(this).next().slideToggle();	
			}
		});
		
		
		// jQuery Toggle
		$('.toggle .pane').hide();
		$('.toggle .tab').click(function() {
			$(this).next().slideToggle();	
		});
		
		
		
/*-----------------------------------------------------------------------------------*/
/*	IE Fixes
/*-----------------------------------------------------------------------------------*/

		$('.accordion .tab:first-child, .accordion .tab:first-child, .toggle .tab:first-child').css('border-top', '1px solid #0c1013');
  	
});


$(window).bind("load", function() {
		
/*-----------------------------------------------------------------------------------*/
/*	Hide Loader and FadeIn Backround Images
/*-----------------------------------------------------------------------------------*/
		
			//$('#body_loader').hide().remove();
		
});
	
})(jQuery);