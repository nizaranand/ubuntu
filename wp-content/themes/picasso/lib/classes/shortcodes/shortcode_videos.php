<?php
/*-----------------------------------------------------------------------------------*/
/* Video Shortcode Main Function
/*-----------------------------------------------------------------------------------*/

function ms_video_shortcode($atts){
	if(isset($atts['type'])){
		switch($atts['type']){
			case 'youtube':
				return ms_video_youtube($atts);
				break;
			case 'vimeo':
				return ms_video_vimeo($atts);
				break;
			case 'facebook':
				return ms_video_facebook($atts);
				break;
			case 'dailymotion':
				return ms_video_dailymotion($atts);
				break;
		}
	}
	return '';
}
add_shortcode('video', 'ms_video_shortcode');

/*-----------------------------------------------------------------------------------*/
/* Youtube Video
/*-----------------------------------------------------------------------------------*/

function ms_video_youtube($atts, $content=null) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
	), $atts));
	
	if (!empty($clip_id)){
		return "<div class='video_wrapper'><iframe frameborder='0' src='http://www.youtube.com/embed/$clip_id'></iframe></div>";
	}
}


/*-----------------------------------------------------------------------------------*/
/* Vimeo Video
/*-----------------------------------------------------------------------------------*/

function ms_video_vimeo($atts) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
	), $atts));

	if (!empty($clip_id) && is_numeric($clip_id)){
		return "<div class='video_wrapper'><iframe src='http://player.vimeo.com/video/$clip_id?title=0&amp;amp;byline=0&amp;amp;portrait=0' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>";
	}
}

/*-----------------------------------------------------------------------------------*/
/* Facebook Video
/*-----------------------------------------------------------------------------------*/

function ms_video_facebook($atts, $content=null) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
	), $atts));
	
	if (!empty($clip_id)){
		return "<div class='video_wrapper'><object type='application/x-shockwave-flash' data='http://www.facebook.com/v/$clip_id\'><param name='wmode' value='transparent' /><param name='autostart' value='false' /><param name='movie' value='http://www.facebook.com/v/$clip_id' /></object></div>";
	}
}

/*-----------------------------------------------------------------------------------*/
/* Daily Motion Video
/*-----------------------------------------------------------------------------------*/

function ms_video_dailymotion($atts, $content=null) {

	extract(shortcode_atts(array(
		'clip_id' 	=> '',
	), $atts));
	
	if (!empty($clip_id)){
		return "<div class='video_wrapper'><iframe src='http://www.dailymotion.com/embed/video/$clip_id?theme=none&amp;foreground=%23F7FFFD&amp;highlight=%23FFC300&amp;background=%23171D1B&amp;start=&amp;animatedTitle=&amp;iframe=1&amp;additionalInfos=0&amp;autoPlay=0&amp;hideInfos=0'></iframe></div>";
	}
}