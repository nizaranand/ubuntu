<?php
/*
Template Name: Gallery Template
*/

get_header(); ?>

<?php 
	// Globalizing Meta Variables
	global $template_metabox;
	$template_meta = $template_metabox->the_meta();
	
	// Pagination Variables
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}	

	// Lightbox
	$pg_lightbox_script = strtolower($template_meta['gallery_lightbox_script']); // use script name to use specific one, 'null' to use global var. value
	$lightbox_script = ( !is_null($pg_lightbox_script) ? $pg_lightbox_script : $global_lightbox_script );
	$lightbox_script = $lightbox_script != 'fancybox' ? $lightbox_script.'['. rand() .']' : 'fancybox'; // modify variable because fancybox not working with bracket id

	
	// Image Resizing Parameters
	$thumb_resize_parameters = '430, 430, 0'; // width, height, fixed height (0,1)
	
	// Gallery Layout
	switch ($template_meta['gallery_style']) {
		case "2-column":
			$gallery_layout = "two_column";
			break;
		case "3-column":
			$gallery_layout = "three_column";
			break;	
		case "4-column":
			$gallery_layout = "four_column";
			break;	
		case "5-column":
			$gallery_layout = "five_column";
			break;
		case "galleria":
			$gallery_layout = "galleria";
			break;
		default:
			$gallery_layout = "grid";
			break;
	}
	
?>

    <!-- Gallery starts here -->
    <section id="gallery" class="page_content">
    
		<?php if( post_password_required() ) { // if password protected ?> 
       
			<?php the_content(); // display password form ?>
            
		<?php } else { // if NOT password protected ?> 
        
        
			<?php while ( have_posts() ) : the_post(); // Loop to display any custom content  ?>
            
				<?php if($post->post_content != "") { ?>
            
                    <div class="template_content">
                        <?php the_content(); ?>
                    </div>
                    
				<?php } // End checking if content is empty ?>
            
            <?php endwhile; // End the loop ?>
            
            
            <?php  
                $temp = $wp_query;  // assign orginal query to temp variable for later use   
                $wp_query = null;
            
                $wp_query = new WP_Query( // Start a new query for our videos
                array(
                    'post_parent' => $post->ID, // Get data from the current post
                    'post_type' => 'attachment', // Only bring back attachments
                    'post_mime_type' => 'image', // Only bring back attachments that are images
                    'posts_per_page' => $gallery_layout != 'galleria' ? $template_meta['images_per_page'] : '-1', // Show us the first result
                    'post_status' => 'inherit', // Attachments default to "inherit", rather than published. Use "inherit" or "all". 
                    'orderby' => 'menu_order', // Order the attachments randomly  
                    'order' => 'ASC',
                    'paged' => $paged
                    )
                );  			
            ?>  
            
            <?php if ( $gallery_layout != 'galleria' ) { // if NOT galleria layout ?>
            
                <ul class="gallery_entries gallery_<?php echo $gallery_layout; ?> clearfix <?php isset($template_meta['gallery_masonry']) ? print 'masonry_enabled' : print 'masonry_disabled'; ?>">  
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
						<?php
                        // grab attachement image link, (default: attachement image url)
                        $gallery_img_link = get_post_meta(get_image_id( wp_get_attachment_url() ), '_wp_attachment_url', true) ? get_post_meta(get_image_id( wp_get_attachment_url() ), '_wp_attachment_url', true) : wp_get_attachment_url();
                        
                        // grab attachement image link type, (default: image)
                        $gallery_img_link_type = get_post_meta(get_image_id( wp_get_attachment_url() ), 'ms_link_type', true) ? get_post_meta( get_image_id( wp_get_attachment_url() ), 'ms_link_type', true) : 'image';
                        
                        if (strpos($lightbox_script,'prettyphoto') !== false) { // if prettyphoto, apply lightbox on video and image links
                            
                            $final_lightbox_script =  $gallery_img_link_type == 'image' || $gallery_img_link_type == 'video' ? $lightbox_script : 'none';
                            
                        } else { // else, apply lightbox only on image links
                            
                            $final_lightbox_script =  $gallery_img_link_type == 'image' ? $lightbox_script : 'none';
                            
                        }
                        ?>
                        <li class="grid_entry"><?php echo ms_get_image(/* Url */ wp_get_attachment_url(), /* Link */ $gallery_img_link, /* Caption */ get_the_excerpt(), /* Lightbox */ $final_lightbox_script, /* Image Resizer */ $thumb_resize_parameters, /* Link Attr */ 'class="lightbox_group '. $gallery_img_link_type .'_link" title="'. get_the_title() .'"', /* Image Attr */ 'alt="'. get_the_title() .'"'); ?></li>
                    <?php endwhile;// End the loop. Whew. ?>  
                </ul>  
                
                <?php ms_pagination(); ?>
                
			<?php } else { // if galleria layout ?>  
            
                <ul id="galleria">  
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <li><?php echo ms_get_image(/* Url */ wp_get_attachment_url(), /* Link */ wp_get_attachment_url(), /* Caption */ get_the_excerpt(), /* Lightbox */ 'none', /* Image Resizer */ NULL, /* Link Attr */ 'class="lightbox_group"', /* Image Attr */ 'data-title="'. get_the_title() .'" data-description="'. get_the_content() .'" alt="'. get_the_title() .'"'); ?></li>
                    <?php endwhile;// End the loop. Whew. ?>  
                </ul>  
                
                <?php
				
				function ms_galleria_script() {
					echo '<script>';
					echo 'Galleria.loadTheme("'. get_template_directory_uri() .'/lib/js/galleria.classic.min.js");';
					echo 'Galleria.run("#galleria");';
					echo '</script>';
				}
				add_action('wp_footer', 'ms_galleria_script');
				
				?>
                
            <?php } // finish checking gallery layout ?>  
            
			<?php $wp_query = null; $wp_query = $temp; ?>  
        
		<?php } // finish checking password protection ?>  
              
    </section>
    <!-- Gallery ends here -->
    
<?php get_footer(); ?>