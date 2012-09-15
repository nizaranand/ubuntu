<?php header("Content-type: text/css");
require_once('../../../../../../wp-load.php');
require_once('../../../../../../wp-includes/post.php');
?>

/*-----------------------------------------------------------------------------------------------*/
/*	All Dynamically generated CSS styles goes here
/*-----------------------------------------------------------------------------------------------*/

.current-menu-item a, .current-menu-ancestor a, .sfHover a, ul#navigation a:hover, .side_meta {
  background: <?php echo of_get_option('ms_skin_color'); ?>;
}
.side_meta span.arrow {
	border-left-color: <?php echo of_get_option('ms_skin_color'); ?>;
}
ul#navigation ul, ul#bg_nav, ul#bg_nav li#prev_slide:hover, ul#bg_nav li#next_slide:hover, ul#bg_nav li#toggle_slide:hover, ul#bg_nav li#toggle_audio:hover {
	background-color: <?php echo of_get_option('ms_skin_color'); ?>;
	background-color: rgba(<?php echo implode(', ', hex2rgb(of_get_option('ms_skin_color')));?>, 0.92);
}
.portfolio_entry ul.default_list li:before {
	color: <?php echo of_get_option('ms_skin_color'); ?>;
}
