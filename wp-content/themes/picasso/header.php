<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link rel="icon" type="image/png" href="<?php echo of_get_option('ms_custom_favicon'); ?>">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo wp_title( '|', false, 'right' ) . get_bloginfo('name'); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php 
	// Globalizing Meta Variables
	global $template_metabox, $bg_caption_metabox, $bg_audio_metabox;
	
	$template_meta = $template_metabox->the_meta();
	$bg_caption_meta = $bg_caption_metabox->the_meta();
	$bg_audio_meta = $bg_audio_metabox->the_meta();
	
	// Background Type
	if ( is_page() || is_single() ) { // when page or single post is being shown
	
		$bg_type = isset($bg_caption_meta['background_type']) ? $bg_caption_meta['background_type'] : of_get_option('ms_bg_type');
		
	} else { // when showing uncontrollable pages
	
		$bg_type = of_get_option('ms_bg_type');
		
	}	
	
	// Background Overlay
	$bg_overlay_class = ( of_get_option('ms_bg_overlay') == 'none' ? 'none' : 'pattern');
?>


<!-- mobile scaling -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<?php 
	// Background Audio
	$bg_audio_mp3 = isset($bg_audio_meta['bg_aud_mp3_url']) ? $bg_audio_meta['bg_aud_mp3_url'] : of_get_option('ms_bg_aud_mp3_url');
	$bg_audio_oga = isset($bg_audio_meta['bg_aud_oga_url']) ? $bg_audio_meta['bg_aud_oga_url'] : of_get_option('ms_bg_aud_oga_url');
	
	if ( is_page() || is_single() ) { // when page or single post is being shown
		
		$bg_audio_enable = $bg_audio_meta['background_audio'] == "enable" ? 1 : 0;
		$bg_audio_autoplay = isset($bg_audio_meta['bg_aud_autoplay']) ? 0 : 1;
		$bg_audio_loop = isset($bg_audio_meta['bg_aud_loop']) ? 0 : 1;
		
	} else { // when showing uncontrollable pages
		
		$bg_audio_config = of_get_option('ms_bg_aud_config');
		$bg_audio_enable = ($bg_audio_config[1] == 1) ? 1 : 0;
		$bg_audio_autoplay = ($bg_audio_config[2] == 1) ? 0 : 1;
		$bg_audio_loop = ($bg_audio_config[3] == 1) ? 0 : 1;
		
	}			
	
	// Data Attribute
	$bg_audio_data = $bg_audio_mp3.','.$bg_audio_oga.','.$bg_audio_enable.','.$bg_audio_autoplay.','.$bg_audio_loop;
?>


<?php

if ($bg_type == 'video') {

	// Background Video
	$bg_video_poster_url = isset($bg_caption_meta['bg_poster_img_url']) ? $bg_caption_meta['bg_poster_img_url'] : of_get_option('ms_bg_vid_poster_url');
	$bg_video_mp4_url = isset($bg_caption_meta['bg_mp4_video_url']) ? $bg_caption_meta['bg_mp4_video_url'] : of_get_option('ms_bg_vid_mp4_url');
	$bg_video_ogg_url = isset($bg_caption_meta['bg_ogg_video_url']) ? $bg_caption_meta['bg_ogg_video_url'] : of_get_option('ms_bg_vid_ogv_url');
	$bg_video_webm_url = isset($bg_caption_meta['bg_webm_video_url']) ? $bg_caption_meta['bg_webm_video_url'] : of_get_option('ms_bg_vid_webm_url');
	$bg_video_caption = isset($bg_caption_meta['bg_vid_caption']) ? $bg_caption_meta['bg_vid_caption'] : of_get_option('ms_bg_vid_caption');
	
	
	if ( is_page() || is_single() ) { // when page or single post is being shown
	
		$bg_video_autoplay = isset($bg_caption_meta['bg_vid_autoplay']) ? 0 : 1;
		$bg_video_loop = isset($bg_caption_meta['bg_vid_loop']) ? 0 : 1; 
		$bg_video_audio = isset($bg_caption_meta['bg_vid_audio']) ? 0 : 1;
		
	} else { // when showing uncontrollable pages
	
		$bg_video_config = of_get_option('ms_bg_vid_config');
		$bg_video_autoplay = ($bg_video_config[1] == 1) ? 0 : 1;
		$bg_video_loop = ($bg_video_config[2] == 1) ? 0 : 1;
		$bg_video_audio = ($bg_video_config[3] == 1) ? 0 : 1;
	}			
	
	// Data Attribute
	$bg_video_data = $bg_video_autoplay.','.$bg_video_loop.','.$bg_video_audio;
	
	$bg_autoplay_attr = $bg_video_autoplay == 1 ? 'autoplay' : '';
	$bg_audio_attr = $bg_video_audio == 1 ? '' : 'muted';
	$bg_loop_attr = $bg_video_loop == 1 ? 'loop' : '';
}

?>

<?php 

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	 
	wp_head();
?>

</head>


<body <?php body_class('no-js'); ?> data-bg-type="<?php echo $bg_type; ?>" data-bg-video="<?php isset($bg_video_data) ? print $bg_video_data : print 'none'; ?>" data-bg-audio="<?php isset($bg_audio_data) ? print $bg_audio_data : print 'none'; ?>">

	<script>
    
    /* Create a closure to maintain scope of the '$'
       and remain compatible with other frameworks.  */
    (function($) {
        
        //same as $(document).ready();
        $(function() {
            
    
            <?php if ($bg_type == 'image') { ?>
            
                /*-----------------------------------------------------------------------------------*/
                /*	Background Fullscreen Image(s)
                /*-----------------------------------------------------------------------------------*/
                
                <?php
                // Slideshow Images
                $bg_default_img_array = array ('0' => array ('bg_img_url' => of_get_option('ms_bg_img_url') , 'bg_img_caption' => of_get_option('ms_bg_img_caption')));
                $bg_tmp_img_array = !empty($bg_caption_meta['bg_images']) ? $bg_caption_meta['bg_images'] : NULL;
                $bg_img_array = isset($bg_tmp_img_array) ? $bg_tmp_img_array : $bg_default_img_array;
                $bg_img_count = count($bg_img_array);
                
                // Functionality
                $bg_autoplay = isset($bg_caption_meta['bg_img_autoplay']) ? 0 : 1;
                $bg_start_slide = isset($bg_caption_meta['bg_img_random']) ? 0 : 1; // 0 for random
                
                $bg_stretching = of_get_option('ms_bg_img_stretching');
                $bg_fit_alway = $bg_stretching[1] == 1 ? 1 : 0;
                $bg_fit_landscape = $bg_stretching[2] == 1 ? 1 : 0;
                $bg_fit_portrait = $bg_stretching[3] == 1 ? 1 : 0;
                
                // Transitions
                $bg_slide_interval = of_get_option('ms_bg_slide_interval');
                $bg_transition = of_get_option('ms_bg_transition');
                $bg_transition_speed = of_get_option('ms_bg_transition_speed');
                
                ?>
        
        
                $.supersized({
                
                    // Functionality
                    autoplay				: 	<?php print $bg_autoplay; ?>,				// Determines whether slideshow begins playing when page is loaded
                    performance				: 	0,											// Quality during transition (Options: 0-No adjustments, 1-Lowers image quality during transitions and restores after completed, 2-Higher image quality, 3-Faster transition speed, lower image quality)
                    fit_always				: 	<?php print $bg_fit_alway; ?>,				// Prevents the image from ever being cropped. Ignores minimum width and height
                    fit_landscape			: 	<?php print $bg_fit_landscape; ?>,			// Prevents the image from being cropped by locking it at 100% width
                    fit_portrait			: 	<?php print $bg_fit_portrait; ?>,			// Prevents the image from being cropped by locking it at 100% height
                    start_slide             :   <?php print $bg_start_slide; ?>,			// Start slide (0 is random)
                    
                    // Transitions
                    slide_interval          :   <?php print $bg_slide_interval; ?>,			// Length between transitions
                    transition              :   <?php print $bg_transition; ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed		:	<?php print $bg_transition_speed; ?>,		// Speed of transition
                                                               
                    // Slideshow Images							
                    slides 					:  	[			
                                                 
                                                        <?php
                                                        $i = 0;
                                                        foreach ($bg_img_array as $bg_img) {
                                                        ?>
                                                        
                                                        {image : <?php print "'". $bg_img['bg_img_url'] ."'"; ?>, title : <?php print "'". $bg_img['bg_img_caption'] ."'"; ?>}
                                                        <?php if ($i != $bg_img_count - 1) { echo ','; } // FIX for IE 8 ?>
                                                        
                                                        
                                                        <?php
                                                        $i++;
                                                        }
                                                        ?>
                                                        
                                                ]
                    
                });
            
            <?php }  ?>
            
        
        });
                
    
    })(jQuery);
    
    </script>
    
	<?php if ($bg_type == 'video') { ?>
    
        <!-- Video Tag starts here -->
        <div id="video_bg_container">
        
            <video id="video_background" <?php echo $bg_autoplay_attr .' '. $bg_audio_attr .' '. $bg_loop_attr; ?> preload="auto" poster="<?php echo $bg_video_poster_url; ?>">
            
                <source type="video/mp4" src="<?php echo $bg_video_mp4_url; ?>">
                <source type="video/ogv" src="<?php echo $bg_video_ogg_url; ?>">
                <source type="video/webm" src="<?php echo $bg_video_webm_url; ?>">
                
            </video>
            
        </div>        
        <!--Video Tag ends here -->
    
        <!--Video Caption starts here-->
        <div id="bg_slide_caption">
            <h2><?php echo $bg_video_caption; ?></h2>
        </div>
        <!--Video Caption ends here-->
        
        <!-- Background Navigation starts here -->
        <ul id="bg_nav">
            <li id="toggle_slide" class="pause"><a href="#">Toggle Slide</a></li>
            <?php if( $bg_video_audio == 1 || ($bg_video_audio == 0 && $bg_audio_enable == 1) ) { ?>
            <li id="toggle_audio" class="play"><a href="#">Toggle Audio</a></li>
            <?php } ?>
        </ul>  
        <!-- Background Navigation ends here -->
    
  	<?php } ?>
    
    <!-- Pattern Overlay starts here -->
    <div id="bg_overlay" class="<?php echo $bg_overlay_class; ?>"></div>
    <!-- Pattern Overlay ends here -->
    
    <!-- Back To Top Link starts here -->
    <div id="back_to_top"><a href="#"></a></div>
    
    
	<?php if ($bg_type == 'image') { ?>
    
    <!--Slide captions starts here-->
    <div id="bg_slide_caption">
        <h2></h2>
    </div>
    <!--Slide captions ends here-->
    
		<?php if ($bg_img_count > 1) { // if multiple background mages ?>
        
            <!-- Background Navigation starts here -->
            <ul id="bg_nav">
                <li id="next_slide"><a href="#">Next Slide</a></li>
                <li id="toggle_slide" class="pause"><a href="#">Toggle Slide</a></li>
                <li id="prev_slide"><a href="#">Previous Slide</a></li>
                
				<?php if ($bg_audio_enable == 1) { // if multiple image background and audio is enabled ?>
                    <li id="toggle_audio" class="play"><a href="#">Toggle Audio</a></li>
				<?php } ?>
            </ul>  
            <!-- Background Navigation ends here -->
        
		<?php } elseif ($bg_img_count <= 1 && $bg_audio_enable == 1) { // if single image background and audio is enabled ?>
        
            <!-- Background Navigation starts here -->
            <ul id="bg_nav">
                <li id="toggle_audio" class="play"><a href="#">Toggle Audio</a></li>
            </ul>  
            <!-- Background Navigation ends here -->
            
		<?php } ?>
        
    
	<?php } ?>
    
    
    <!-- Wrapper starts here -->
    <div id="wrapper">
    
		<?php if ( $bg_type == 'image' && $bg_img_count > 1 ) {  // if multiple background images ?>
      
            <!-- Background Pagination starts here -->
            <ul id="bg_pagination"></ul>
        
        <?php } ?>

        <!-- Social Navigation starts here -->
        <?php echo ms_social_profiles(); ?>
        <!-- Social Navigation ends here -->
        
        
        <!-- Smart Menu starts here -->
        <section id="smart_menu" class="low_res_block">
        
            <div class="smart_inner_wrapepr">
            
                <div class="widget">
                    <h3>Menu</h3>
                    
					<?php 
                    $args = array(
                      'theme_location'  => 'primary-navigation',
                      'container'       => false,
                      'menu_id'			=> 'smartphone_menu',
                      'menu_class'		=> 'menu',
                      'fallback_cb'     => false);
                    ?>
                    <?php wp_nav_menu($args); ?> 
                    
                    <?php if(!has_nav_menu('primary-navigation')) { ?>
                    <ul id="smartphone_menu" class="menu">
                        <?php wp_list_pages('title_li=&sort_column=menu_order'); ?>
                    </ul>
                    <?php } ?>
                    
                </div>
                <div class="clear"></div>
            
            </div> 
            
        </section>
        <!-- Smart Menu ends here -->
        
        <!-- Low Res. Header starts here -->
        <header id="smart_header" class="site_header low_res_block">
        
            <!-- Social Navigation starts here -->
			<?php echo ms_social_profiles(); ?>
            <!-- Social Navigation ends here -->
        
            <!-- Logo start here -->
            <div id="smart_logo" class="site_logo">
                <h1><a class="img_logo" href="<?php echo home_url( '/' ); ?>"><img src="<?php echo of_get_option('ms_site_img_logo'); ?>" alt="<?php echo get_bloginfo('description'); ?>"></a></h1>
            </div>
            <!-- Logo ends here -->
            
            <span id="menu_button"><a class="plus" href="#"></a></span>
            
        </header>
        <!-- Low Res. Header ends here -->
        

        <!-- High Res. Header starts here -->
        <header id="desktop_header" class="site_header high_res_block">
        
                <!-- Logo start here -->
                <div id="desktop_logo" class="site_logo">
                    <h1><a class="img_logo" href="<?php echo home_url( '/' ); ?>"><img src="<?php echo of_get_option('ms_site_img_logo'); ?>" alt="<?php echo get_bloginfo('description'); ?>"></a></h1>
                </div>
                <!-- Logo ends here -->
                
                <!-- Main Navigation start here -->
                <?php 
                $args = array(
                  'theme_location'  => 'primary-navigation',
                  'container'       => 'nav',
                  'container_id'    => 'navigation_wrapper',
                  'menu_id'			=> 'navigation',
				  'menu_class'		=> '',
                  'fallback_cb'     => false);
                ?>
                <?php wp_nav_menu($args); ?> 
                
                <?php if(!has_nav_menu('primary-navigation')) { ?>
                <nav id="navigation_wrapper">
                    <ul id="navigation">
                        <?php wp_list_pages('title_li=&sort_column=menu_order'); ?>
                    </ul>
                </nav>
                <?php } ?>
                <!-- Main Navigation ends here -->
                
        </header>
        <!-- Header ends here -->
        
        <?php if ( !is_home() &&  !is_page_template('template-fullscreen.php') ) { // don't show if 'index.php' or 'template-fullscreen.php' is being shown ?> 
        
           
        <!-- Main Content (Body + Sidebar + Footer) starts here -->
        <div id="main_content" class="compact">
        
            <!-- Main Body (Body + Sidebar) starts here -->
            <div id="main_body" class="shadow clearfix">
            
                <!-- Main Content Header starts here -->
                <header id="main_content_header">
                	<?php if( is_singular( 'ms_portfolio' ) ) { ?>
                        <h3><?php _e( 'Portfolio', 'framework' ); ?> <span><?php _e( '(Single Entry)', 'framework' ); ?></span></h3>
                	<?php } elseif( is_single() ) { ?>
                        <h3><?php _e( 'Blog', 'framework' ); ?> <span><?php _e( '(Single Entry)', 'framework' ); ?></span></h3>
                	<?php } elseif( is_404() ) { ?>
                        <h3><?php _e( 'Not Found', 'framework' ); ?> <span><?php _e( '(Error 404)', 'framework' ); ?></span></h3>
                	<?php } elseif( is_search() ) { ?>
                        <h3><?php _e( 'Search', 'framework' ); ?> <span>(<?php echo get_search_query(); ?>)</span></h3>
                	<?php } elseif( is_category() ) { ?>
                        <h3><?php _e( 'Category', 'framework' ); ?> <span>(<?php $category = get_the_category(); echo $category[0]->cat_name; ?>)</span></h3>
                	<?php } elseif( is_author() ) { ?>
                        <h3><?php _e( 'Author', 'framework' ); ?> <span>(<?php $author = get_userdata( get_query_var('author') ); echo $author->display_name; ?>)</span></h3>
                	<?php } elseif( is_date() ) { ?>
                        <h3><?php _e( 'Archive', 'framework' ); ?> <span>(<?php the_time('F, Y'); ?>)</span></h3>
                	<?php } elseif( is_tag() ) { ?>
                        <h3><?php _e( 'Tag', 'framework' ); ?> <span>(<?php single_tag_title(); ?>)</span></h3>
					<?php } else { ?>
                        <h3><?php isset($template_meta['page_custom_heading']) ? print $template_meta['page_custom_heading'] : the_title(); ?> <?php isset($template_meta['page_sub_heading']) ? print '<span>('. $template_meta['page_sub_heading'] . ')</span>' : ''; ?></h3>
                	<?php } ?>
                    <span id="toggle_fold"><a class="collapse" href="#"></a></span>
                </header>
                <!-- Main Content Header ends here -->
        
		<?php } ?>        
