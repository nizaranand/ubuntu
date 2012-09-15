<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// BG Type Array
	$bg_type_array = array(
		'image' => __('Image', 'framework'),
		'video' => __('Video', 'framework'),
	);
	
	// BG Transition Styles
	$bg_slideshow_transition = array(
		'0' => __('None', 'framework'),
		'1' => __('Fade', 'framework'),
		'2' => __('Slide Top', 'framework'),
		'3' => __('Slide Right', 'framework'),
		'4' => __('Slide Bottom', 'framework'),
		'5' => __('Slide Left', 'framework'),
		'6' => __('Carousel Right', 'framework'),
		'7' => __('Carousel Left', 'framework')
	);
	
	// BG Overlay Styles
	$overlay_style_array = array(
		'0' => __('None', 'framework'),
		'1' => __('Style # 1', 'framework'),
		'2' => __('Style # 2', 'framework'),
		'3' => __('Style # 3', 'framework'),
		'4' => __('Style # 4', 'framework'),
		'5' => __('Style # 5', 'framework'),
		'6' => __('Style # 6', 'framework'),
		'7' => __('Style # 7', 'framework'),
		'8' => __('Style # 8', 'framework'),
		'9' => __('Style # 9', 'framework'),
		'10' => __('Style # 10', 'framework'),
		'11' => __('Style # 11', 'framework'),
		'12' => __('Style # 12', 'framework'),
		'13' => __('Style # 13', 'framework'),
		'14' => __('Style # 14', 'framework')
	);
	
	// BG Image Stretching - Array
	$bg_img_stretching = array(
		'1' => __('Never Crop BG Images', 'framework'),
		'2' => __('Stretch BG Image to Width', 'framework'),
		'3' => __('Stretch BG Image to Height', 'framework')
	);

	// BG Image Stretching - Defaults
	$bg_img_stretching_defaults = array(
		'3' => '1'
	);
	
	// BG Video Configuration -  Array
	$bg_vid_configuration = array(
		'1' => __('Disable Autoplay', 'framework'),
		'2' => __('Disable Loop', 'framework'),
		'3' => __('Disable Audio', 'framework')
	);

	// BG Video Configuration - Defaults
	$bg_vid_configuration_defaults = array(
		'1' => '0',
		'2' => '0',
		'3' => '0',
	);
	
	// BG Audio Configuration -  Array
	$bg_aud_configuration = array(
		'1' => __('Enable Audio', 'framework'),
		'2' => __('Disable Autoplay', 'framework'),
		'3' => __('Disable Loop', 'framework')
	);

	// BG Audio Configuration - Defaults
	$bg_aud_configuration_defaults = array(
	);
	
	// Predefined Skins
	$predefined_skins_array = array(
		'custom' => __('Custom', 'framework'),
		'green' => __('Green', 'framework'),
		'blue' => __('Blue', 'framework'),
		'red' => __('Red', 'framework'),
		'brown' => __('Brown', 'framework')
	);
	
	
	
	
	
	
	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('General', 'framework'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Site Image Logo', 'framework'),
		'desc' => __('Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)', 'framework'),
		'id' => 'ms_site_img_logo',
		'std' => get_template_directory_uri().'/lib/img/logo.png',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Logo X-Offset', 'framework'),
		'desc' => __('Enter left & right margin of logo from container', 'framework'),
		'id' => 'ms_logo_x_offset',
		'std' => '40',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Logo Y-Offset', 'framework'),
		'desc' => __('Enter top & bottom margin of logo from container', 'framework'),
		'id' => 'ms_logo_y_offset',
		'std' => '30',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Admin Login Logo', 'framework'),
		'desc' => __('Upload a logo for your theme admin login panel, or specify the image address of your online logo. (http://example.com/logo.png)', 'framework'),
		'id' => 'ms_admin_login_logo',
		'std' => get_template_directory_uri().'/lib/img/admin-logo.png',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Custom Favicon', 'framework'),
		'desc' => __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', 'framework'),
		'id' => 'ms_custom_favicon',
		'std' => get_template_directory_uri().'/favicon.png',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Image Resizing', 'framework'),
		'desc' => __('Disable Image Resizing', 'framework'),
		'id' => 'ms_img_resizing',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Date Meta', 'framework'),
		'desc' => __('Disable Date Meta', 'framework'),
		'id' => 'ms_date_meta',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Blog Meta', 'framework'),
		'desc' => __('Disable Blog Meta', 'framework'),
		'id' => 'ms_blog_meta',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Footer Scripts', 'framework'),
		'desc' => __('Enter javascript code which will be inserted in wordpress footer', 'framework'),
		'id' => 'ms_footer_script',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Copyright Text', 'framework'),
		'desc' => __('Enter the text you would like to display in the footer of your site', 'framework'),
		'id' => 'ms_copyright_text',
		'std' => '&copy; 2012 - 2013 MsTrends Photography Theme',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Social Profiles', 'framework'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Flickr Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_flickr_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_twitter_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Facebook Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_facebook_profile',
		'std' => '',
		'type' => 'text');
	
	
	$options[] = array(
		'name' => __('Dribbble Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_dribbble_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Skype Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_skype_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Youtube Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_youtube_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Vimeo Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_vimeo_profile',
		'std' => '',
		'type' => 'text');
	
	
	$options[] = array(
		'name' => __('Linkedin Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_linkedin_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Last FM Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_last_fm_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Deviant Art Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_deviant_art_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Picasa Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_picasa_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('My Space Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_my_space_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_google_plus_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Pinterest Profile', 'framework'),
		'desc' => __('Enter url of your profile.', 'framework'),
		'id' => 'ms_pinterest_profile',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('RSS Url', 'framework'),
		'desc' => __('Enter url of your RSS.', 'framework'),
		'id' => 'ms_rss_profile',
		'std' => get_bloginfo('rss_url'),
		'type' => 'text');
	
	

	$options[] = array(
		'name' => __('Background', 'framework'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Global Background Type', 'framework'),
		'desc' => __('Select slideshow transition animation for background slideshow', 'framework'),
		'id' => 'ms_bg_type',
		'std' => 'image',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $bg_type_array);
	
	$options[] = array(
		'name' => __('Default BG Image - Url', 'framework'),
		'desc' => __('Enter default url for your default Image background.', 'framework'),
		'id' => 'ms_bg_img_url',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Default BG Image - Caption', 'framework'),
		'desc' => __('Enter default caption for your default Image background.', 'framework'),
		'id' => 'ms_bg_img_caption',
		'class' => 'mini',
		'std' => 'Global BG Image Caption',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Slideshow Transition', 'framework'),
		'desc' => __('Select slideshow transition anumation for background slideshow', 'framework'),
		'id' => 'ms_bg_transition',
		'std' => '1',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $bg_slideshow_transition);
	
	$options[] = array(
		'name' => __('Transition Speed', 'framework'),
		'desc' => __('Enter default animation speed in milli seconds for your slideshow background', 'framework'),
		'id' => 'ms_bg_transition_speed',
		'class' => 'mini',
		'std' => '2500',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Slide Interval', 'framework'),
		'desc' => __('Enter backround images timeout in milli seconds after which they will be changed', 'framework'),
		'id' => 'ms_bg_slide_interval',
		'class' => 'mini',
		'std' => '5000',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('BG Image Stretching', 'framework'),
		'id' => 'ms_bg_img_stretching',
		'std' => $bg_img_stretching_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $bg_img_stretching);
	
	$options[] = array(
		'name' => __('Default Video Poster - Url', 'framework'),
		'desc' => __('Enter url for your video background image poster.', 'framework'),
		'id' => 'ms_bg_vid_poster_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Default BG Mp4 Video - Url', 'framework'),
		'desc' => __('Enter url for your mp4 video background.', 'framework'),
		'id' => 'ms_bg_vid_mp4_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Default BG Ogv Video - Url', 'framework'),
		'desc' => __('Enter url for your ogv video background.', 'framework'),
		'id' => 'ms_bg_vid_ogv_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Default BG Webm Video - Url', 'framework'),
		'desc' => __('Enter url for your webm video background.', 'framework'),
		'id' => 'ms_bg_vid_webm_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Default BG Video - Caption', 'framework'),
		'desc' => __('Enter default caption for your default video background.', 'framework'),
		'id' => 'ms_bg_vid_caption',
		'class' => 'mini',
		'std' => 'Global BG Video Caption',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('BG Video Configuration', 'framework'),
		'id' => 'ms_bg_vid_config',
		'std' => $bg_vid_configuration_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $bg_vid_configuration);
	
	$options[] = array(
		'name' => __('Default BG Mp3 Audio - Url', 'framework'),
		'desc' => __('Enter default url for your mp3 audio background.', 'framework'),
		'id' => 'ms_bg_aud_mp3_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Default BG Oga Audio - Url', 'framework'),
		'desc' => __('Enter default url for your oga audio background.', 'framework'),
		'id' => 'ms_bg_aud_oga_url',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('BG Audio Configuration', 'framework'),
		'id' => 'ms_bg_aud_config',
		'std' => $bg_aud_configuration_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $bg_aud_configuration);


	$options[] = array(
		'name' => __('Style & Typography', 'framework'),
		'type' => 'heading' );
	
	$options[] = array(
		'name' => __('Predefined Skins', 'framework'),
		'desc' => __('Select skin color for theme from predefined list', 'framework'),
		'id' => 'ms_predefined_skins',
		'std' => 'green',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $predefined_skins_array);
	
	$options[] = array(
		'name' => __('Skin Color', 'framework'),
		'desc' => __('Select skin color for theme', 'framework'),
		'id' => 'ms_skin_color',
		'std' => '',
		'type' => 'color' );
	
	
	$options[] = array(
		'name' => __('Google Font Name', 'framework'),
		'desc' => __('Enter name of the font from Google which you want to use', 'framework'),
		'id' => 'ms_primary_font_name',
		'std' => 'Yanone Kaffeesatz',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Font Weight', 'framework'),
		'desc' => __('Enter numeric value of font weight(s) which u want to use (usually 400)', 'framework'),
		'id' => 'ms_primary_font_weight',
		'std' => '300',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Font Subsets', 'framework'),
		'desc' => __('Enter comma seperated values of font subset(s) which u want to use', 'framework'),
		'id' => 'ms_primary_font_subset',
		'std' => 'latin',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Background Overlay Style', 'framework'),
		'desc' => __('Select background pattern overlay style', 'framework'),
		'id' => 'ms_bg_overlay',
		'std' => '4',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $overlay_style_array);
	
	$options[] = array(
		'name' => __('Background Overlay Opacity', 'framework'),
		'desc' => __('Enter opacity value betweeb 1 to 100 for your site background overlay.', 'framework'),
		'id' => 'ms_bg_overlay_opacity',
		'std' => '30',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Custom CSS', 'framework'),
		'desc' => __('Quickly add some CSS to your theme by adding it to this block', 'framework'),
		'id' => 'ms_custom_css',
		'std' => '',
		'type' => 'textarea');

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>

<?php
}