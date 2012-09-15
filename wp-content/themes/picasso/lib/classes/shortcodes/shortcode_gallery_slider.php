<?php
/*-----------------------------------------------------------------------------------*/
/* Gallery Grid Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_gallery_grid($atts, $content = null ) {
	extract(shortcode_atts(array(
		'id' => rand(),
		'lightbox' => 'fancybox',
	), $atts));
	
	
	$lightbox = $lightbox != 'fancybox' ? $lightbox.'['.$id.']' : 'fancybox'; // modify variable because fancybox not working with bracket id

	if (!preg_match_all("/(.?)\[(image)\b(.*?)(?:(\/))?\](?:(.+?)\[\/image\])?(.?)/s", $content, $parsed_attrs)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($parsed_attrs[0]); $i++) {
			$parsed_attrs[3][$i] = shortcode_parse_atts($parsed_attrs[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($parsed_attrs[0]); $i++) {
			$output .= '<li class="grid_entry">';
			$output .= ms_get_image(/* Url */ $parsed_attrs[3][$i]['url'], /* Link */ isset($parsed_attrs[3][$i]['link']) ? $parsed_attrs[3][$i]['link'] : $parsed_attrs[3][$i]['url'], /* Caption */ NULL, /* Lightbox */ $lightbox, /* Image Resizer */ NULL, /* Link Attr */ 'class="lightbox_group image_link"', /* Image Attr */ NULL);
			$output .= '</li>';
			
		}

		return '<ul class="gallery_entries gallery_grid clearfix masonry_disabled">' . $output . '</ul>';
	}

}
add_shortcode("image_gallery", "ms_gallery_grid");

/*-----------------------------------------------------------------------------------*/
/* Image Slider Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_image_slider($atts, $content = null ) {
	
	if (!preg_match_all("/(.?)\[(image)\b(.*?)(?:(\/))?\](?:(.+?)\[\/image\])?(.?)/s", $content, $parsed_attrs)) {
		return do_shortcode($content);
	} else {
		
		for($i = 0; $i < count($parsed_attrs[0]); $i++) {
			$parsed_attrs[3][$i] = shortcode_parse_atts($parsed_attrs[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($parsed_attrs[0]); $i++) {
			$output .= '<li class="grid_entry">';
			$output .= ms_get_image(/* Url */ $parsed_attrs[3][$i]['url'], /* Link */ isset($parsed_attrs[3][$i]['link']) ? $parsed_attrs[3][$i]['link'] : NULL, /* Caption */ NULL, /* Lightbox */ 'none', /* Image Resizer */ NULL, /* Link Attr */ 'target="_blank"', /* Image Attr */ NULL);
			$output .= '</li>';
			
		}

		return '<div class="flex-container"><div class="flexslider flex_img_slider"><ul class="slides no_thumb_overlay slider_enable">' . $output . '</ul></div></div>';
	}
	
}
add_shortcode("image_slider", "ms_image_slider");


?>