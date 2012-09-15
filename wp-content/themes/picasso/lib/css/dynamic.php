<?php header("Content-type: text/css");
require_once('../../../../../wp-load.php');
require_once('../../../../../wp-includes/post.php');
?>

/*-----------------------------------------------------------------------------------------------*/
/*	All Dynamically generated CSS styles goes here
/*-----------------------------------------------------------------------------------------------*/

/* Background Overlay Pattern */
#bg_overlay.pattern {
	background: url(../img/overlays/<?php echo of_get_option('ms_bg_overlay'); ?>.png) repeat;
	
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=<?php echo of_get_option('ms_bg_overlay_opacity'); ?>)"; /* IE 8 */
    filter: alpha(opacity=<?php echo of_get_option('ms_bg_overlay_opacity'); ?>); /* IE 4, 5, 6 and 7 */
	-moz-opacity: <?php echo of_get_option('ms_bg_overlay_opacity') / 100; ?>;
	-khtml-opacity: <?php echo of_get_option('ms_bg_overlay_opacity') / 100; ?>;
	opacity: <?php echo of_get_option('ms_bg_overlay_opacity') / 100; ?>;
}

/* Logo Offset */
.site_logo h1 {
	margin: <?php echo of_get_option('ms_logo_y_offset'); ?>px <?php echo of_get_option('ms_logo_x_offset'); ?>px;  /* use this for logo positioning */
}


/* Rounded Corners - IE8 FIX */
ul#social_nav, ul#bg_nav, ul#navigation a, .tagcloud a, span.read_more a, ul.default-list .date,
#footer, #main_body, .page-numbers a, .page-numbers span.current, input, textarea, button, #portfolio_nav a, form span.error, .site_logo, 
ul#navigation, ul#navigation ul, ul#navigation ul ul, .comment a.comment_author, .side_meta, form span.field_icon, .dropcap, ul.tabs, ul.tabs li a, .tabs_container .panes,
.css_button, #bg_slide_caption h2, ul.social_nav, .footer, ul.entries-list .date, .gallery_entries li .thumb_img:after, .similiar_entries li .thumb_img:after,
.gallery_entries li .thumb_img img, .similiar_entries li .thumb_img img, .portfolio_images li .thumb_img img 
{
	behavior: url("<?php echo get_template_directory_uri() . '/lib/css/_patches/PIE.htc'; ?>");
}

/*-----------------------------------------------------------------------------------------------*/
/*	'Custom CSS' from Theme Options
/*-----------------------------------------------------------------------------------------------*/

<?php echo of_get_option('ms_custom_css'); ?>
