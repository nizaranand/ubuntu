<?php
/*-----------------------------------------------------------------------------------*/
/* Code Wrapper Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_code_snippet( $content = null ) {
	return '<pre><code>' . $content . '</code></pre>';
}
add_shortcode('code', 'ms_code_snippet');


/*-----------------------------------------------------------------------------------*/
/* Divider Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_divider($atts, $content = null ) {
	extract(shortcode_atts(array(
		'hide' => '0',
		'top' => '1'
	), $atts));
      
	return '<div class="'.  (($hide == 0 && $top == 1) ? 'divider divider_visible top_link' : ( ($hide == 0 && $top == 0) ? 'divider divider_visible' : 'divider')) .'">'. ( ($top == 1 && $hide != 1)? '<a href="#breadcrumb">Top</a>' : '') .'</div>';

}
add_shortcode("divider", "ms_divider");


/*-----------------------------------------------------------------------------------*/
/* CSS Buttons Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_css_buttons($atts, $content = null ) {
	extract(shortcode_atts(array(
		'color' => 'gray',
		'link' => '#'
	), $atts));
	
	return '<a class="css_button '. $color .'" href="'. $link .'">'. $content .'</a>';

}
add_shortcode("button", "ms_css_buttons");


/*-----------------------------------------------------------------------------------*/
/* CSS Boxes Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_css_boxes($atts, $content = null ) {
	extract(shortcode_atts(array(
		'color' => 'gray',
	), $atts));
	
	return '<div class="css_box '. $color .'_box">'. $content .'</div>';

}
add_shortcode("box", "ms_css_boxes");


/*-----------------------------------------------------------------------------------*/
/* Block Quote Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_block_quote($atts, $content = null ) {
	extract(shortcode_atts(array(
		'source' => '',
	), $atts));
	
	return '<blockquote>'. $content .'<cite>'. ($source ? '- '. $source : '') .'</cite></blockquote>';

}
add_shortcode("quote", "ms_block_quote");


/*-----------------------------------------------------------------------------------*/
/* Highlight Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_highlight($atts, $content = null ) {
	extract(shortcode_atts(array(
		'color' => '',
	), $atts));
	
	return '<span class="highlight highlight_'. $color .'">'. $content .'</span>';

}
add_shortcode("highlight", "ms_highlight");


/*-----------------------------------------------------------------------------------*/
/* Dropcap Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_dropcap($atts, $content = null ) {
	extract(shortcode_atts(array(
		'color' => '',
	), $atts));
	
	return '<span class="dropcap '. $color .'">'. $content .'</span>';

}
add_shortcode("dropcap", "ms_dropcap");

?>