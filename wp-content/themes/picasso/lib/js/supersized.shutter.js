/*

	Supersized - Fullscreen Slideshow jQuery Plugin
	Version : 3.2.7
	Theme 	: Shutter 1.1
	
	Site	: www.buildinternet.com/project/supersized
	Author	: Sam Dunn
	Company : One Mighty Roar (www.onemightyroar.com)
	License : MIT License / GPL License

*/

(function($){
	
	theme = {
	 	
	 	
	 	/* Initial Placement
		----------------------------*/
	 	_init : function(){
	 		
    		if (!api.options.autoplay){
				if ($(vars.play_button).removeClass('pause').addClass('play'));	// If pause play button is image, swap src
			}
			
			
			/* Navigation Items
			----------------------------*/
		    $(vars.next_slide).click(function() {
		    	api.nextSlide();
		    });
		    
		    $(vars.prev_slide).click(function() {
		    	api.prevSlide();
		    });
		    
		    $(vars.play_button).click(function() {
				api.playToggle();						    
		    });
			
			
	 	},
	 	
	 	/* Play & Pause Toggle
		----------------------------*/
	 	playToggle : function(state){
	 		
	 		if (state =='play'){
	 			// If image, swap to pause
	 			if ($(vars.play_button).removeClass('play').addClass('pause'));
	 		} else if (state == 'pause') {
	 			// If image, swap to play
	 			if ($(vars.play_button).removeClass('pause').addClass('play'));
	 		}
	 		
	 	},
	 	
	 	
	 	/* Before Slide Transition
		----------------------------*/
	 	beforeAnimation : function(direction){
			
			var windowWidth = $(window).width();
			var wrapperWidth = $('#wrapper').width();
			var captionLeft = (windowWidth - wrapperWidth) / 2;
			
		  	
		  	// Update slide caption and hide
		   	if ($(vars.slide_caption).length){
		   		(api.getField('title')) ? $(vars.slide_caption).html(api.getField('title')).hide() : $(vars.slide_caption).html('');
		   	}
			
			// fadeIn new side caption
			$(vars.slide_caption).animate({ paddingLeft : captionLeft+'px', opacity : 1 }, 650, '' );
			
			
			// center caption in small resolution devies
			if( window.innerWidth <= 1023 ) { // If Res. is upto 1023
			
				var captionWidth = $(vars.slide_caption).width();
				var captionLeft = (windowWidth - captionWidth - 40) / 2;
				
				$('#bg_slide_caption').css('margin-left', captionLeft+'px');
				
			}
		    
	 	},
	 	
	 	
	 	/* After Slide Transition
		----------------------------*/
	 	afterAnimation : function(){
			
			
	 	},
	 	
	 	
	 
	 };
	 
	 
	 /* Theme Specific Variables
	 ----------------------------*/
	 $.supersized.themeVars = {
													
		// General Elements							
		play_button			:	'#toggle_slide',		// Play/Pause button
		next_slide			:	'#next_slide',		// Next slide button
		prev_slide			:	'#prev_slide',		// Prev slide button
		
		slide_caption		:	'#bg_slide_caption h2',	// Slide caption
		slide_current		:	'.slidenumber',		// Current slide number
		slide_total			:	'.totalslides',		// Total Slides
		slide_list			:	'#bg_pagination',		// Slide jump list	
		
	 	// Internal Variables
		progress_delay		:	false,				// Delay after resize before resuming slideshow
		thumb_page 			: 	false,				// Thumbnail page
		thumb_interval 		: 	false,				// Thumbnail interval
		
													
		// General Elements							
		next_thumb			:	false,		// Next slide thumb button
		prev_thumb			:	false,		// Prev slide thumb button
		
		thumb_tray			:	false,		// Thumbnail tray
		thumb_list			:	false,		// Thumbnail list
		thumb_forward		:	false,	// Cycles forward through thumbnail list
		thumb_back			:	false,		// Cycles backwards through thumbnail list
		tray_arrow			:	false,		// Thumbnail tray button arrow
		tray_button			:	false,		// Thumbnail tray button
		
		progress_bar		:	false		// Progress bar		 
													
		
	 };												
	
	 /* Theme Specific Options
	 ----------------------------*/												
	 $.supersized.themeOptions = {					
	 						   
		progress_bar		:	0,		// Timer for each slide											
		mouse_scrub			:	0		// Thumbnails move with mouse
		
	 };
	
	
})(jQuery);