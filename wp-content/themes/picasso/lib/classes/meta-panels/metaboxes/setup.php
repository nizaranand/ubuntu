<?php

include_once MSTRENDS_CLASSES . '/meta-panels/wpalchemy/MetaBox.php';
 
// global styles for the meta boxes

if (is_admin())  {

	function ms_meta_panel_scripts() {
		wp_enqueue_script('wpalchemy-metabox-js', get_stylesheet_directory_uri() . '/lib/classes/meta-panels/metaboxes/meta.js');
		wp_enqueue_script('wpalchemy-shortcode-js', get_stylesheet_directory_uri() . '/lib/classes/meta-panels/metaboxes/shortcode.js');
	 }
	
	function ms_meta_panel_styles() {
		wp_enqueue_style('wpalchemy-metabox-css', get_stylesheet_directory_uri() . '/lib/classes/meta-panels/metaboxes/meta.css');
	 }
	 
	 
	 
	switch (basename($_SERVER['SCRIPT_FILENAME'])) {
		case "post.php":
		case "post-new.php":
		case "page.php":
		case "page-new":

			add_action('admin_print_scripts', 'ms_meta_panel_scripts');
			add_action('admin_print_styles', 'ms_meta_panel_styles');
			break;
		
		default:
			return;
	}
	 
	 
	 

}
/* eof */