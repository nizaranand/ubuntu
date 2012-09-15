<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they intend to go wrong in a big way.
	You have been warned!

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Set Theme Name and Globalize
/*-----------------------------------------------------------------------------------*/

	global $theme_name;
	$theme_name = strtolower('Picasso');
	
/*-----------------------------------------------------------------------------------*/
/*	Set Content Width
/*-----------------------------------------------------------------------------------*/

	if ( ! isset( $content_width ) )
		$content_width = 960;
	
	
/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

	load_theme_textdomain('framework');
	
	
/*-----------------------------------------------------------------------------------*/
/*	Add Theme Fetaures
/*-----------------------------------------------------------------------------------*/

	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	
	
/*-----------------------------------------------------------------------------------*/
/* Options Framework Functions
/*-----------------------------------------------------------------------------------*/

	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
		require_once dirname( __FILE__ ) . '/inc/options-framework.php';
	}
	
/*-----------------------------------------------------------------------------------*/
/*	Register WP3.0+ Menus
/*-----------------------------------------------------------------------------------*/
	
	function register_menu() {
		register_nav_menu('primary-navigation', __('Primary Navigation', 'framework'));
	}
	add_action('init', 'register_menu');
	
	
/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

	function ms_widgets_init() {
		// Area 1, located at the top of the sidebar.
		register_sidebar( array(
			'name' => __( 'Sidebar', 'framework' ),
			'id' => 'sidebar-widget-area',
			'description' => __( 'This sidebar would only be shown on high resolution screen (e.g desktop computer)', 'framework' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
		// Area 2, located below the Primary Widget Area in the sidebar.
		register_sidebar( array(
			'name' => __( 'Footer (High Resolution)', 'framework' ),
			'id' => 'footer-high-res-widget-area',
			'description' => __( 'This footer widget area would only be shown on high resolution screen (e.g desktop computer)', 'framework' ),
			'before_widget' => '<div class="one_third"><div class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
		// Area 3, located below the Primary Widget Area in the sidebar.
		register_sidebar( array(
			'name' => __( 'Footer (Low Resolution)', 'framework' ),
			'id' => 'footer-low-res-widget-area',
			'description' => __( 'This footer widget area would only be shown on low resolution screen (e.g mobile, tablet)', 'framework' ),
			'before_widget' => '<li><div class="widget %2$s">',
			'after_widget' => '</div></li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
	
	}
	
	add_action( 'widgets_init', 'ms_widgets_init' );


/*-----------------------------------------------------------------------------------*/
/* Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
/*-----------------------------------------------------------------------------------*/
	 
	function widget_first_last_classes($params) {
	
		global $my_widget_num; // Global a counter array
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	
	
		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}
	
		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}
	
		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}
	
		$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options
	
		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= 'widget-first ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= 'widget-last ';
		}
	
		$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
	
		return $params;
	
	}
	add_filter('dynamic_sidebar_params','widget_first_last_classes');


/*-----------------------------------------------------------------------------------*/
/*	Global Variables
/*-----------------------------------------------------------------------------------*/

	$global_lightbox = 1;  // '0' to disable caption and '1' to enable caption
	$global_lightbox_script = 'fancybox';  // valid values [colorbox, prettyphoto, prettyphoto[gallery],  fancybox]
	$comment_reply_js = false;

/*-----------------------------------------------------------------------------------*/
/*	Function to send image to ms_grayscale_thumbs() for conversion
/*-----------------------------------------------------------------------------------*/

	function ms_get_image($img_url, $image_link, $image_caption, $lightbox_script, $thumb_resize_parameters, $link_additional_params, $img_additional_params) {
		
		// Check if Lighbox is enabled
		if( $lightbox_script != 'none' ) { 
			$lightbox_attr = 'rel="'. $lightbox_script .'"';
		} else {
			$lightbox_attr = '';
		}
		
		$thumb_resize_params = explode(',', $thumb_resize_parameters);

		
		// Create image link
		$output = '';
		
		if( $image_link != NULL ) { 
			$output .= '<a href="'. $image_link .'" '. $lightbox_attr .' '. $link_additional_params .'>';
		}
		
			if( !of_get_option('ms_img_resizing') && $thumb_resize_parameters != NULL ) { // resize if resizing is NOT disabled and resize parameters are defined 
				$output .= '<span class="thumb_img"><img '. $img_additional_params .' src="'.  fImg::resize( $img_url , $thumb_resize_params[0], $thumb_resize_params[1], $thumb_resize_params[2] != '0' ? true : false ).'" /></span>';
			} else {
				$output .= '<span class="thumb_img"><img '. $img_additional_params .' src="'.  $img_url .'" /></span>';
			}
			
			if( $image_caption != NULL ) { 
				$output .= '<p class="flex-caption">'. $image_caption .'</p>';
			}
			
		$output .= '<span class="thumb_highlight"></span>';
			
			
		if( $image_link != NULL ) { 
			$output .= '</a>';
		}
		
		return $output;
			
		
	}
	
	
/*-----------------------------------------------------------------------------------*/
/*	Template for comments and pingbacks
/*-----------------------------------------------------------------------------------*/

	function ms_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li id="li-comment-<?php comment_ID(); ?>">
		
			<div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			
				<a href="<?php comment_author_url(); ?>" class="comment_author"><?php echo get_comment_author(); ?></a>
				<p class="comment_metadata"><?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago';  ?></p>
				<?php echo get_avatar( $comment, 50 ); ?>
				<p class="comment_text"><?php echo get_comment_text(); ?></p>			
	
			
				<?php if($args['max_depth']!=$depth) { ?>
					<div class="replies-wrapper">
						<span class="reply-link"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
					</div>
				<?php } ?>  
						  
			</div>	
		
			
		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'framework'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}

	
/*-----------------------------------------------------------------------------------*/
/*	Truncate String from the given number of words
/*-----------------------------------------------------------------------------------*/

	function ms_truncate($string, $limit, $break=" ", $pad=" [&hellip;]") {
		
		// return with no change if string is shorter than $limit  
		if(strlen($string) <= $limit) return $string;
		
		// is $break present between $limit and the end of the string? 
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		 if($breakpoint < strlen($string) - 1) {
			 $string = substr($string, 0, $breakpoint) . $pad; 
		 }
		} 
		
		return $string;
	
	}
	
/*-----------------------------------------------------------------------------------*/
/*	Parsing Flickr Feed
/*-----------------------------------------------------------------------------------*/
	
	function attr($s,$attrname) { // return html attribute
		preg_match_all('#\s*('.$attrname.')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x);
		if (count($x)>=3) return $x[2][0]; else return "";
	}
	 
	// id = id of the feed
	// n = number of thumbs
	function parseFlickrFeed($id,$n) {
		$url = "http://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=it-it&format=rss_200";
		$s = file_get_contents($url);
		preg_match_all('#<item>(.*)</item>#Us', $s, $items);
		
		$out = "";
		$out.= "<ul class=\"flickr_feed\">";
		for($i=0;$i<count($items[1]);$i++) {
			if($i>=$n) break;
			$item = $items[1][$i];
			preg_match_all('#<link>(.*)</link>#Us', $item, $temp);
			$link = $temp[1][0];
			preg_match_all('#<title>(.*)</title>#Us', $item, $temp);
			$title = $temp[1][0];
			preg_match_all('#<media:thumbnail([^>]*)>#Us', $item, $temp);
			$thumb = attr($temp[0][0],"url");
			
			$out.= "<li><a href='$link' target='_blank' title=\"".str_replace('"','',$title)."\"><img src='$thumb' alt=\"".str_replace('"','',$title)."\" /></a></li>";
		}
		$out.= "</ul>";
		
		return $out;
	}	
	
/*-----------------------------------------------------------------------------------*/
/*	Parsing Twitter Stream
/*-----------------------------------------------------------------------------------*/

	function parseTwitterStream($user_name, $number_tweets) {
		
		$cache = FALSE; //Assume the cache is empty
		$cPath = dirname(__FILE__) . '/lib/cache/twitter.cache';
		if(file_exists($cPath)) {
			$modtime = filemtime($cPath);
			$timeago = time() - 1800; //30 minutes ago in Unix timestamp format (no. seconds since 1st Jan 1970) 
			if($modtime < $timeago) {
				$cache = FALSE; //Set to false just in case as the cache needs to be renewed
			} else {
				$cache = TRUE; //The cache is not too old so the cache can be used.
			}
		}
		
		if($cache === FALSE) {
			//initialize a new curl resource
			$ch = curl_init();	
			curl_setopt($ch, CURLOPT_URL, 'https://twitter.com/statuses/user_timeline/'. $user_name .'.json?count='. $number_tweets .'');
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$content = curl_exec($ch);
			curl_close($ch);
				
			if($content === FALSE) {
				//Content couldn't be retrieved... Do something. Possibly end the function prematurely hence no else.
			}
			
			//Let's save our data into the cache
			$fp = fopen($cPath, 'w');
			if(flock($fp, LOCK_EX)) {
				fwrite($fp, utf8_encode($content));
				flock($fp, LOCK_UN);	
			}
			fclose($fp);
		
		} else {
			//cache is TRUE let's load the data from the cache.
			$content = file_get_contents($cPath);
		}
		
		$content = json_decode($content);
				
		
		// return HTML output
		$out = "";
		$out.= "<div class=\"quote_widget twitter_widget\">";
		$out.= "<div class=\"twitter_wrap\">";
		$out.= "<div class=\"flex-container\">";
		$out.= "<div class=\"flexslider\">";
		$out.= "<ul class=\"nested_slides\">";
		
		foreach($content as $tweet) {
			$out.= "<li class=\"quote_single\">". $tweet->text ."</li>";
		}
		
		$out.= "</ul>";
		$out.= "</div>";
		$out.= "<div class=\"quote_nav\"></div>";
		$out.= "</div>";
		$out.= "</div>";
		$out.= "</div>";
		
		return $out;
		
	}
	
/*-----------------------------------------------------------------------------------*/
/*	Prints Meta Information for Posts
/*-----------------------------------------------------------------------------------*/

	function ms_date_meta() {
		
		echo '<!-- Date Meta starts here -->';
		
		echo '<div class="side_meta">';
		echo '<span class="arrow"></span>';
		echo '<span class="date">'. get_the_time('d') .'</span>';
		echo '<span class="month">'. get_the_time('M') .'</span>';
		echo '</div>';
		
		echo '<!-- Date Meta ends here -->';
			
	}
	
	function ms_simple_meta($meta = 'author') {
		
		echo '<!-- Simple Meta starts here -->';
		echo '<div class="simple_meta">';
		
		if ($meta == 'author') {
			echo '<span class="author">Posted By <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author() .'</a></span>';
		} elseif ($meta == 'date') {
			echo '<span class="date">Posted On <a href="'. get_month_link('', '') .'">'. get_the_time('j-n-Y') .'</a></span>';
		}
		
		echo '</div>';
		echo '<!-- Simple Meta ends here -->';
			
	}
	
	function ms_post_meta() {
		
		echo '<!-- Post Meta starts here -->';
		
		// Retrieve Category Variables
		$categories = get_the_category();
		$current_category = $categories[0]->cat_name;
		$category_ID = get_cat_ID(''. $current_category .'');
		
		echo '<ul class="bar_meta">';
		echo '<li><a class="author" href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author() .'</a></li>';
		echo '<li><a class="category" href="'. get_category_link( $category_ID ) .'">'. $current_category .'</a></li>';
		echo '<li><a class="comments" href="'. get_permalink() .'#comments">'. get_comments_number() .' '. __( 'Comments', 'framework') .'</a></li>';
		echo '</ul>';
		
		echo '<!-- Post Meta ends here -->';
			
	}

/*-----------------------------------------------------------------------------------*/
/*	Wordpress Pagination Function
/*-----------------------------------------------------------------------------------*/

	function ms_pagination() {
		
		global $wp_query, $wp_rewrite;
		
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		$pagination = array(
			'base' => @add_query_arg('paged','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'prev_text' => '',
			'next_text' => '',
			'type' => 'list'
		);
		
		if( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
		if( !empty($wp_query->query_vars['s']) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
		if( $pagination['total'] > 1 ) {
		
		echo '<!-- Pagination starts here -->';
		echo '<div class="pagination_wrapper">';
		echo '<span>'. __('Pages', 'framework') .'</span>';
		echo paginate_links( $pagination );
		echo '</div>';
		echo '<!-- Pagination ends here -->';
		
		}
	};


/*-----------------------------------------------------------------------------------*/
/*	Wordpress Password Protection
/*-----------------------------------------------------------------------------------*/

    function ms_password_form() {
        global $post;
        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$action_url = get_bloginfo('version') >= 3.4 ? '/wp-login.php?action=postpass' : '/wp-pass.php';
		
		
		$out = '';
		
		$out .= '<div class="one_half smart_full_width">';
		$out .= '<p class="page_notice">'. __('Apologies, but this content is password protected. <br /> Please enter password and hit enter to access the content.', 'framework') .'</p>';
		$out .= '</div>';
		
		$out .= '<div class="one_half column-last smart_full_width">';
		
		$out .= '<form id="custom_form" class="password_form protected-post-form" action="' . get_option('siteurl') . $action_url .'" method="post">';
		
		$out .= '<p>';
		$out .= '<input type="password" class="password_field required" name="post_password" id="' . $label . '" value="' . esc_attr__( "Login" ) . '" size="22" tabindex="1">';
		$out .= '<label for="' . $label . '">Password <small>*</small></label>';
		$out .= '<span class="field_icon password_icon"><em class="icon"></em><em class="arrow"></em></span>';
		$out .= '</p>';
		
		$out .= '</form>';
		
		$out .= '</div>';
		
		return $out;
		
    }
    add_filter( 'the_password_form', 'ms_password_form' );

	
/*-----------------------------------------------------------------------------------*/
/*	Social Profile Links
/*-----------------------------------------------------------------------------------*/

	function ms_social_profiles($list_class = 'social_nav') {
		
		// Social Profiles Array
		$social_nav_array = array (
			'flickr' => of_get_option('ms_flickr_profile'),
			'twitter' => of_get_option('ms_twitter_profile'),
			'facebook' => of_get_option('ms_facebook_profile'),
			'dribbble' => of_get_option('ms_dribbble_profile'),
			'skype' => of_get_option('ms_skype_profile'),
			'youtube' => of_get_option('ms_youtube_profile'),
			'vimeo' => of_get_option('ms_vimeo_profile'),
			'linked_in' => of_get_option('ms_linkedin_profile'),
			'last_fM' => of_get_option('ms_last_fm_profile'),
			'deviant_art' => of_get_option('ms_deviant_art_profile'),
			'picasa' => of_get_option('ms_picasa_profile'),
			'my_space' => of_get_option('ms_my_space_profile'),
			'google_plus' => of_get_option('ms_google_plus_profile'),
			'pinterest' => of_get_option('ms_pinterest_profile'),
			'rss' => of_get_option('ms_rss_profile')
		);
	
		$out = "";
		$out.= "<ul class=\"$list_class\">";
		foreach ($social_nav_array as $key => $value) {
			if ($value) {
				
				$social_icon = get_template_directory_uri(). '/lib/img/social/'. str_replace('_', '', $key) .'_16.png';
				
				$out.= "<li><a href='$value' target='_blank'><img src='$social_icon' alt=\"". str_replace('_', ' ', ucwords($key)) ."\" /></a></li>";
			
			}
		}
		$out.= "</ul>";
		
		return $out;
	
	}
	
	
/*-----------------------------------------------------------------------------------*/
/*	Google Fonts API
/*-----------------------------------------------------------------------------------*/
	
	$global_font_name = of_get_option('ms_primary_font_name');
	$global_font_css_name = str_replace(" ", "+", $global_font_name);
	$global_font_variants = of_get_option('ms_primary_font_weight'); // comma seperated values (default value = 400)
	$global_font_subsets = of_get_option('ms_primary_font_subset'); // comma seperated values (default value = latin)
	
/*-----------------------------------------------------------------------------------*/
/*	Define Directory Constants
/*-----------------------------------------------------------------------------------*/

	define('MSTRENDS_LIB', get_template_directory() . '/lib');
	define('MSTRENDS_CLASSES', MSTRENDS_LIB . '/classes');
	define('MSTRENDS_ADMIN', MSTRENDS_CLASSES . '/theme-options');
	
	define('MSTRENDS_JS', get_template_directory_uri() . '/lib/js');
	define('MSTRENDS_CSS', get_template_directory_uri() . '/lib/css');
	define('MSTRENDS_IMG', get_template_directory_uri() . '/lib/img');
	
	
/*-----------------------------------------------------------------------------------*/
/*	Load Stylesheets/JavaScripts for Site (Frond-End)
/*-----------------------------------------------------------------------------------*/

	function ms_site_scripts() {
		if ( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			
			global $is_IE, $comment_reply_js;
			
			/* Load jQuery Library */
			wp_enqueue_script( 'jquery' );
			
			/*  Load other javascript Snippets  */
			if ( $is_IE  ) {
				wp_enqueue_script( 'ie', MSTRENDS_JS .'/ie.min.js', array('jquery'));
			}
		
			wp_enqueue_script( 'jquery-form-validation', MSTRENDS_JS .'/jquery.form.validation.js', array('jquery'));
			wp_enqueue_script( 'header-js', MSTRENDS_JS .'/header.min.js', array('jquery'));
			wp_enqueue_script( 'footer-js', MSTRENDS_JS .'/footer.min.js', array('jquery'), null, true);
			
			if ( is_page_template( 'template-gallery.php' )  ) {
				wp_enqueue_script( 'galleria-js', MSTRENDS_JS .'/galleria.min.js');
			}
				
			wp_enqueue_script( 'supersized', MSTRENDS_JS .'/supersized.min.js', array('jquery'));
			wp_enqueue_script( 'supersized-theme', MSTRENDS_JS .'/supersized.shutter.js', array('jquery'));
			
			wp_enqueue_script( 'custom-js', MSTRENDS_JS .'/functions.js', array('jquery'));
			
			if ( is_singular() && $comment_reply_js == true ) wp_enqueue_script( 'comment-reply' ); 
			
		}
	}
	
	function ms_site_styles() {
		if ( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			
		global $wp_styles, $global_font_css_name, $global_font_variants, $global_font_subsets;
			
		/*  Load Css Styles  */
			wp_enqueue_style( 'style', get_template_directory_uri() .'/style.css');
			wp_enqueue_style( 'dynamic', get_template_directory_uri() .'/lib/css/dynamic.php');
			
			wp_enqueue_style( 'ie8-css', get_template_directory_uri() .'/lib/css/_patches/win-ie8.css');
			$wp_styles->add_data( 'ie8-css', 'conditional', 'lte IE 9' );
			
			wp_enqueue_style( 'higher_res', get_template_directory_uri() .'/lib/css/desktop.css', false, false, 'only screen and (min-width: 1024px)');
			wp_enqueue_style( 'lower_res', get_template_directory_uri() .'/lib/css/smart.css', false, false, 'only screen and (max-width: 989px)');
			
			wp_enqueue_style( 'mobile_landscape', get_template_directory_uri() .'/lib/css/res_480.css', false, false, 'only screen and (min-width: 480px) and (max-width: 767px)');
			wp_enqueue_style( 'tablet_potrait', get_template_directory_uri() .'/lib/css/res_768.css', false, false, 'only screen and (min-width: 768px) and (max-width: 989px)');
			wp_enqueue_style( 'mobile_potrait', get_template_directory_uri() .'/lib/css/res_320.css', false, false, 'only screen and (max-width: 479px)');
			
			if ( of_get_option('ms_predefined_skins') != 'custom') {
				wp_enqueue_style( 'theme_skin', get_template_directory_uri() .'/lib/css/_skins/'. of_get_option('ms_predefined_skins') .'.css');
			} else {
				wp_enqueue_style( 'dynamic_skin', get_template_directory_uri() .'/lib/css/_skins/dynamic_skin.php');
			}
			
			wp_enqueue_style( 'google_fonts', 'http://fonts.googleapis.com/css?family='. $global_font_css_name .':'. $global_font_variants.'&amp;subset='. $global_font_subsets.'');
			wp_enqueue_style( 'typography', get_template_directory_uri() .'/lib/css/fonts.php');
		}
	}
	
	add_action('wp_print_scripts', 'ms_site_scripts');
	add_action('wp_print_styles', 'ms_site_styles');
	
	
/*-----------------------------------------------------------------------------------*/
/*	Function to convert HEX -> RGB value
/*-----------------------------------------------------------------------------------*/

	function hex2rgb($hex) {
		// Ensure we're working only with upper-case hex values,
		// toss out any extra characters.
		$hex = preg_replace('/[^A-F0-9]/', '', strtoupper($hex));
	
		// Convert 3-letter hex RGB codes into 6-letter hex RGB codes
		$hex_len = strlen($hex);
		if ($hex_len == 3) {
			$new_hex = '';
			for ($i = 0; $i < $hex_len; ++$i) {
				$new_hex .= $hex[$i].$hex[$i];
			}
			$hex = $new_hex;
		}
	
		// Calculate the RGB values
		$rgb['r'] = hexdec(substr($hex, 0, 2));
		$rgb['g'] = hexdec(substr($hex, 2, 2));
		$rgb['b'] = hexdec(substr($hex, 4, 2));
	
		return $rgb;
	}
	
	
/*-----------------------------------------------------------------------------------*/
/*	Defining Custom Gravatar
/*-----------------------------------------------------------------------------------*/

      
    function ms_gravatar ($avatar_defaults) {  
        $myavatar = get_template_directory_uri() . '/lib/img/gravatar.png';  
        $avatar_defaults[$myavatar] = "Picasso";  
        return $avatar_defaults;  
    }
    add_filter( 'avatar_defaults', 'ms_gravatar' );  
	
	
/*-----------------------------------------------------------------------------------*/
/*	Disable New Admin Menu Bar on Fron-End
/*-----------------------------------------------------------------------------------*/

	function ms_disable_admin_bar() {
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_print_scripts-profile.php', 
			 'ms_hide_admin_bar_settings' );
	}
	add_action( 'init', 'ms_disable_admin_bar' , 9 );


/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo Support
/*-----------------------------------------------------------------------------------*/

	if (of_get_option('ms_admin_login_logo')) {
	
		function ms_custom_login_logo() {
			echo '<style type="text/css">
					h1 a { background-image:url('. of_get_option('ms_admin_login_logo') .') !important; }
				  </style>';
		}
		
		add_action('login_head', 'ms_custom_login_logo');
	
	}
	
	
/*-----------------------------------------------------------------------------------*/
/*	Change Default Excerpt Length
/*-----------------------------------------------------------------------------------*/
	
	function ms_excerpt_length($length) {
		return 80;
	}
	add_filter('excerpt_length', 'ms_excerpt_length');	
	

/*-----------------------------------------------------------------------------------*/
/*	Custom Scipts for Footer
/*-----------------------------------------------------------------------------------*/

	function ms_custom_footer_scripts() {
		$content = of_get_option('ms_footer_script');
		echo '<script type="text/javascript">'. stripslashes($content) .'</script>';
	}
	add_action('wp_footer', 'ms_custom_footer_scripts');
		
		
/*-----------------------------------------------------------------------------------*/
/* Include Misc. PHP files and classes
/*-----------------------------------------------------------------------------------*/

	require_once(MSTRENDS_CLASSES . '/meta-panels/functions.php');
	require_once(MSTRENDS_CLASSES . '/widgets/functions.php');
	require_once(MSTRENDS_CLASSES . '/shortcodes/functions.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Portfolio Custom Post Type
/*-----------------------------------------------------------------------------------*/
	
	// Register Custom Post Type
	function ms_portfolio_register() {  
		$args = array(  
			'label' => __('Portfolio', 'framework'),  
			'singular_label' => __('Project', 'framework'),  
			'public' => true,  
			'show_ui' => true,  
			'capability_type' => 'post',  
			'hierarchical' => false,  
			'rewrite' => array('slug' => 'portfolio-project'), 
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments')  
		   );  
	  
		register_post_type( 'ms_portfolio' , $args );  
	}  
	add_action('init', 'ms_portfolio_register');  
	
	// Register Custom Taxonomy
	
	$tax_attrs = array(  
		'hierarchical' => true,  
		'label' => 'Project Types',  
		'singular_label' => 'Project Type',  
		'rewrite' => true
	);  
	register_taxonomy( 'project-type' , array("ms_portfolio"), $tax_attrs );  
	
	
	// Register Custom Columns Titles
	function project_edit_columns($columns){  
			$columns = array(  
				"cb" => "<input type=\"checkbox\" />",  
				"title" => "Project",  
				"description" => "Description",  
				"link" => "Link",  
				"type" => "Type of Project",  
			);  
	  
			return $columns;  
	}  
	add_filter("manage_edit-ms_portfolio_columns", "project_edit_columns"); 
	
	
	// Register Custom Columns Content
	function project_custom_columns($column){  
			global $post;  
			switch ($column)  
			{  
				case "description":  
					the_excerpt();  
					break;  
				case "link":  
					global $single_portfolio_metabox;
					$portfolio_meta = $single_portfolio_metabox->the_meta();
					
					isset($portfolio_meta['project_link']) ? print $portfolio_meta['project_link'] : print 'No Link';  
					break;  
				case "type":  
					echo get_the_term_list($post->ID, 'project-type', '', ', ','');  
					break;  
			}  
	} 
	add_action("manage_posts_custom_column",  "project_custom_columns"); 
	
	
	// Custom Post Type Icon
	function ms_portfolio_icons() {
		
		echo '<style type="text/css" media="screen">';
		
		echo '#menu-posts-ms_portfolio .wp-menu-image {';
		echo 'background: url('. get_template_directory_uri() .'/lib/img/admin/portfolio-icon.png) no-repeat 6px 6px !important;';
		echo '}';
		
		echo '#menu-posts-ms_portfolio:hover .wp-menu-image, #menu-posts-ms_portfolio.wp-has-current-submenu .wp-menu-image {';
		echo 'background-position:6px -16px !important;';
		echo '}';
		
		echo '#icon-edit.icon32-posts-ms_portfolio {background: url('. get_template_directory_uri() .'/lib/img/admin/portfolio-32x32.png) no-repeat;}';
	
		echo '</style>';
		
	}
	add_action( 'admin_head', 'ms_portfolio_icons' );


	
/*-----------------------------------------------------------------------------------*/
/*	Allow Custom Link in Attachement 'Link Url' Field
/*-----------------------------------------------------------------------------------*/

	function _save_attachment_url($post, $attachment) {
		if ( isset($attachment['url']) ) 
			update_post_meta( $post['ID'], '_wp_attachment_url', esc_url_raw($attachment['url']) ); 
		return $post;
	}
	add_filter('attachment_fields_to_save', '_save_attachment_url', 10, 2);
	
	function _replace_attachment_url($form_fields, $post) {
		if ( isset($form_fields['url']['html']) ) {
			$url = get_post_meta( $post->ID, '_wp_attachment_url', true );
			if ( ! empty($url) )
				$form_fields['url']['html'] = preg_replace( "/value='.*?'/", "value='$url'", $form_fields['url']['html'] );
		}
		return $form_fields;
	}
	add_filter('attachment_fields_to_edit', '_replace_attachment_url', 10, 2);


/*-----------------------------------------------------------------------------------*/
/*	Exclude 'Pages' and 'Custom Post Type' from search result
/*-----------------------------------------------------------------------------------*/
 
	function ms_exclude_pages( $query ) {
		if ( $query->is_search )
			$query->set( 'post_type', 'post' );
		return $query;
	};
	add_filter( 'pre_get_posts', 'ms_exclude_pages' );


/*-----------------------------------------------------------------------------------*/
/*	Add 'Odd' and 'Even' Classes to Posts
/*-----------------------------------------------------------------------------------*/

	function oddeven_post_class ( $classes ) {
	   global $current_class;
	   $classes[] = $current_class;
	   $current_class = ($current_class == 'odd') ? 'even' : 'odd';
	   return $classes;
	}
	add_filter ( 'post_class' , 'oddeven_post_class' );
	global $current_class;
	$current_class = 'odd';
	
	
/*-----------------------------------------------------------------------------------*/
/*	Redirect to 'Theme Options' on Theme Activation
/*-----------------------------------------------------------------------------------*/

	if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
		
		wp_redirect(get_option('siteurl') . '/wp-admin/themes.php?page=options-framework'); 
	
	}
	
	
/*-----------------------------------------------------------------------------------*/
/*	Include 'Freshizer' Image Resizing PHP Class
/*-----------------------------------------------------------------------------------*/
	
	include( MSTRENDS_CLASSES. '/scripts/freshizer.php');


/*-----------------------------------------------------------------------------------*/
/*	Fucntion to Get Attachement ID from URL
/*-----------------------------------------------------------------------------------*/

	function get_image_id($image_url) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='" . $image_url . "';"));
		return $attachment[0];
	}
	

/*-----------------------------------------------------------------------------------*/
/*	Add "Link Type" option to Media Uploader
/*-----------------------------------------------------------------------------------*/

	function ms_attachment_field_link_type( $form_fields, $post ) {
	
	// Only show on the in-page media uploader
	$screen = get_current_screen();
	if( 'media-upload' !== $screen->base )
	return $form_fields;
	
	// Set up options
	$options = array( 'post' => 'Post', 'link' => 'Link', 'image' => 'Image', 'video' => 'Video' );
	
	// Get currently selected value
	$selected = get_post_meta( $post->ID, 'ms_link_type', true );
	
	// If no selected value, default to 'No'
	if( !isset( $selected ) )
	$selected = 'post';
	
	// Display each option
	foreach ( $options as $value => $label ) {
	$checked = '';
	$css_id = 'link-type-option-' . $value;
	
	if ( $selected == $value ) {
		
		$checked = " checked='checked'";
	
	}
	
	$html = "<input type='radio' name='attachments[$post->ID][ms-link-type]' id='{$css_id}' value='{$value}'$checked />";
	
	$html .= "<label for='{$css_id}'>$label</label>";
	
	$out[] = $html;
	}
	
	// Construct the form field
	$form_fields['ms-type-link'] = array(
		'label' => 'Link Type',
		'input' => 'html',
		'html' => join("\n", $out),
	);
	
	// Return all form fields
	return $form_fields;
	}
	
	add_filter( 'attachment_fields_to_edit', 'ms_attachment_field_link_type', 10, 2 );
	
	
	/**
	* Save value of "Include in Rotator" selection in media uploader
	*
	* @param $post array, the post data for database
	* @param $attachment array, attachment fields from $_POST form
	* @return $post array, modified post data
	*/
	 
	function ms_attachment_field_link_type_save( $post, $attachment ) {
		
	if( isset( $attachment['ms-link-type'] ) )
	
		update_post_meta( $post['ID'], 'ms_link_type', $attachment['ms-link-type'] );
		
		return $post;
		
	}
	
	add_filter( 'attachment_fields_to_save', 'ms_attachment_field_link_type_save', 10, 2 );


?>