<?php
/*
Template Name: Blog Template
*/

get_header(); ?>

<?php 
	// Globalizing Meta Variables
	global $template_metabox, $thumb_resize_parameters;
	$template_meta = $template_metabox->the_meta();
	
	// Pagination Variables
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}	
	
	// Image Resizing Parameters
	$ft_img_fix_height = 0; // 0 - for proportinate fetaured image height , 1 - for fixed featured image heigt
	
	if ( !isset($template_meta['blog_sidebar']) ) { // if sidebar is NOT disabled
	
		switch ($template_meta['blog_style']) {
			case "standard":
				$thumb_resize_parameters = ($ft_img_fix_height == 1) ? '565, 250, 1' : '565, 9999, 0'; // width, height, fixed height (0,1)
				break;
			case "list":
				$thumb_resize_parameters = '408, 408, 1'; // width, height, fixed height (0,1)
				break;
			case "magazine":
				$thumb_resize_parameters = '565, 250, 1'; // width, height, fixed height (0,1)
				break;
		}
	
	} else { // else if sidebar IS disabled
		
		switch ($template_meta['blog_style']) {
			case "standard":
				$thumb_resize_parameters = ($ft_img_fix_height == 1) ? '888, 400, 1' : '888, 9999, 0'; // width, height, fixed height (0,1)
				break;
			case "list":
				$thumb_resize_parameters = '408, 408, 1'; // width, height, fixed height (0,1)
				break;
			case "magazine":
				$thumb_resize_parameters = '888, 400, 1'; // width, height, fixed height (0,1)
				break;
		}
		
	}
	
	
	// Lightbox
	$pg_lightbox_script = 'none'; // use script name to use specific one, 'null' to use global var. value
	$lightbox_script = ( !is_null($pg_lightbox_script) ? $pg_lightbox_script : $global_lightbox_script );
	
	// Blog Sidebar Class
	$blog_sidebar = isset($template_meta['blog_sidebar']) ? 'without_sidebar' : 'with_sidebar';
?>

    <!-- Page Content starts here -->
    <section class="page_content <?php echo $blog_sidebar; ?> blog_<?php echo $template_meta['blog_style']; ?>">
    
    <?php if( post_password_required() ) { // if password protected ?> 
    
        <?php the_content(); // used to display password form ?>
        
    <?php } else { // if NOT password protected ?> 
    
    
        <?php while ( have_posts() ) : the_post(); // Loop to display any custom content  ?>
        
            <?php if($post->post_content != "") { ?>
        
                <div class="template_content">
                    <?php the_content(); ?>
                </div>
                
            <?php } // End checking if content is empty ?>
        
        <?php endwhile; // End the loop ?>
    
    
        <?php if ( ! have_posts() ) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('blog_entry site_entry_one_col_side'); ?>>
                <h1><?php _e( 'Not Found', 'framework' ); ?></h1>
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'framework' ); ?></p>
                <?php get_search_form(); ?>
        </article>
        <?php endif; ?>
        
        <?php /* Start Latest Entries Loop */ ?>
        <?php 
        $temp = $wp_query;  // assign orginal query to temp variable for later use   
        $wp_query = null;
        $post_counter = 0;
         
        $wp_query = new WP_Query( // Start a new query for our blog
        array(
            'posts_per_page' => $template_meta['entries_per_page'], // Show us the first result
            'cat' => get_cat_ID( $template_meta['template_category'] ), // Attachments default to "inherit", rather than published. Use "inherit" or "all". 
            'paged' => $paged
            )
        );  			
        ?>
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        
			<?php
            // Globalizing Meta Variables
            global $single_entry_metabox;
            $single_meta = $single_entry_metabox->the_meta();
			
			// Featured Image check
			$has_featured_img = has_post_thumbnail() ? 'has_featured_image' : 'no_featured_image';
			
			// grab featured image link, [custom entry link > featured image link > (default: single entry url)]
			$featured_img_link = isset($single_meta['entry_custom_link']) ? $single_meta['entry_custom_link'] : (get_post_meta(get_post_thumbnail_id(), '_wp_attachment_url', true) ? get_post_meta(get_post_thumbnail_id(), '_wp_attachment_url', true) : get_permalink() );
           
			if (isset($single_meta['entry_custom_link'])) { // if custom link defined, use link icon
			
				$featured_img_link_type = 'link';
			
			} else { // else determine hover icon, based on 'link type' value (default: post)
				
				$featured_img_link_type = get_post_meta(get_post_thumbnail_id(), 'ms_link_type', true) ? get_post_meta(get_post_thumbnail_id(), 'ms_link_type', true) : 'post';
			
			}
			
            
            // post counter and special class for last entry
			$post_counter++;
			
			if ( $paged == 1 && $template_meta['blog_style'] == 'magazine' ) {
			
				$not_first_posts_class = $post_counter == 1 ? 'first_post' : 'not_first_post';
				$magazine_counter = $post_counter - 1;
				$post_odd_even = ($wp_query->post_count - 1) % 2 ? 'odd' : 'even';
			
			} else {
				
				$not_first_posts_class = 'not_first_post';
				$magazine_counter = $post_counter;
				$post_odd_even = $wp_query->post_count % 2 ? 'odd' : 'even';
				
			}
			
			if ( $template_meta['blog_style'] == 'magazine' ) {
			
				$magazine_class = $magazine_counter % 2 ? 'odd_magazine' : 'even_magazine';
				$last_posts_class = $post_odd_even == 'odd' ? ( $post_counter == $wp_query->post_count ? 'last_entry' : '' ) : ( $post_counter == $wp_query->post_count || $post_counter == $wp_query->post_count - 1 ? ( $post_counter == $wp_query->post_count ? 'last_entry' : 'second_last_entry' ) : '' );
			
			} else {
				
				$magazine_class = '';
				$last_posts_class = $post_counter == $wp_query->post_count ? 'last_entry' : '';
            
			}
			
			$post_class = 'blog_entry site_entry_one_col_side '. $has_featured_img. ' '. $not_first_posts_class. ' '. $magazine_class. ' '. $last_posts_class;
		   ?>
                    
            <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
                
                <div class="entry_header">
                
                       <?php if ( of_get_option('ms_date_meta') != 1 &&  $template_meta['blog_style'] == 'magazine' ) { ?>
                       
                           <?php ms_simple_meta($meta = 'date'); ?>
                           
                       <?php } elseif ( $template_meta['blog_style'] == 'list' ) { ?>
                       
                           <?php ms_simple_meta($meta = 'author'); ?>
                       
                       <?php } ?>
                       
                        <h1><a href="<?php isset($single_meta['entry_custom_link']) ? print $single_meta['entry_custom_link'] : print get_permalink(); ?>"><?php the_title(); ?></a></h1>
                        
                        <?php if ( of_get_option('ms_date_meta') != 1 ) { ?>
                        
                           <?php ms_date_meta(); ?>
                           
                        <?php } ?>
                        
                        <?php if ( of_get_option('ms_blog_meta') != 1 ) { ?>
                        
                            <?php ms_post_meta(); ?>
                            
                        <?php } ?>
                   
                </div>
                
                <?php if( has_post_thumbnail() ) { ?>
                
                <div class="flex-container">
                    <div class="flexslider">
                        <ul class="slides">
                            <li class="article_entry"><?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ $featured_img_link, /* Caption */ null, /* Lightbox */ $lightbox_script, /* TimThumb */ $thumb_resize_parameters, /* Link Attr */ 'class="'. $featured_img_link_type .'_link"', /* Image Attr */ 'alt="'. get_the_title() .'"'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <?php } ?>
                
                
                <div class="entry_desc">
                
                
                	<?php if ( !isset($template_meta['blog_sidebar']) && ($template_meta['blog_style'] == 'standard') ) { // if sidebar is NOT disabled and standard layout ?>
                    
						<?php if ( isset($template_meta['blog_full_content']) ) { // if full content IS enabled ?>
                        
                            <?php the_content(); ?>
                        
                        <?php } elseif ( !isset($template_meta['blog_full_content']) ) {  // if full content is NOT enabled ?>
                        
                            <p><?php echo ms_truncate(get_the_excerpt(), 265, ' '); ?></p>
                            
                        <?php } ?>
                    
                    <?php } elseif ( isset($template_meta['blog_sidebar']) && ($template_meta['blog_style'] == 'standard') ) { // if sidebar IS disabled and standard layout ?>
                
						<?php if ( isset($template_meta['blog_full_content']) ) { // if full content IS enabled ?>
                        
                            <?php the_content(); ?>
                        
                        <?php } elseif ( !isset($template_meta['blog_full_content']) ) {  // if full content is NOT enabled ?>
                        
                            <?php the_excerpt(); ?>
                            
                        <?php } ?>
					
					<?php }  ?>
                    
                    
					<?php if ( !isset($template_meta['blog_sidebar']) && $template_meta['blog_style'] == 'magazine' ) { // if sidebar is NOT disabled and magazine layout ?>
                
                            <?php if ( $post_counter == 1 && $paged == 1 ) { ?>
                            
                                <p><?php echo ms_truncate(get_the_excerpt(), 300, ' '); ?></p>
                            
                            <?php } else { ?>
                            
                                <p><?php echo ms_truncate(get_the_excerpt(), 145, ' '); ?></p>
                                
                            <?php } ?>

					<?php } elseif ( isset($template_meta['blog_sidebar']) && $template_meta['blog_style'] == 'magazine' ) { // if sidebar IS disabled and magazine layout ?>
               
                            <?php if ( $post_counter == 1 && $paged == 1 ) { ?>
                            
                                <p><?php echo ms_truncate(get_the_excerpt(), 300, ' '); ?></p>
                            
                            <?php } else { ?>
                            
                                <p><?php echo ms_truncate(get_the_excerpt(), 240, ' '); ?></p>
                                
                            <?php } ?>
					
					<?php } ?>
                    
                    
					<?php if ( !isset($template_meta['blog_sidebar']) && $template_meta['blog_style'] == 'list' ) { // if sidebar is NOT disabled and list layout ?>
                
                            <p><?php echo ms_truncate(get_the_excerpt(), 145, ' '); ?></p>

					<?php } elseif ( isset($template_meta['blog_sidebar']) && $template_meta['blog_style'] == 'list' ) { // if sidebar IS disabled and list layout ?>
               
                            <p><?php echo ms_truncate(get_the_excerpt(), 300, ' '); ?></p>
					
					<?php } ?>
                    
                    
					<?php if ( $single_meta['entry_read_more_txt'] != '0' && ($template_meta['blog_style'] == 'list' || $template_meta['blog_style'] == 'magazine') ) { ?>
                    
                        <span class="read_more"><a href="<?php isset($single_meta['entry_custom_link']) ? print $single_meta['entry_custom_link'] : print get_permalink(); ?>"><?php isset($single_meta['entry_read_more_txt']) ? print $single_meta['entry_read_more_txt'] : _e('Read More', 'framework'); ?></a></span>
                    
					<?php } elseif ( $single_meta['entry_read_more_txt'] != '0' && ($template_meta['blog_style'] == 'standard') && !isset($template_meta['blog_full_content']) ) { ?>
                     
                        <span class="read_more"><a href="<?php isset($single_meta['entry_custom_link']) ? print $single_meta['entry_custom_link'] : print get_permalink(); ?>"><?php isset($single_meta['entry_read_more_txt']) ? print $single_meta['entry_read_more_txt'] : _e('Read More', 'framework'); ?></a></span>
                    
					<?php } ?>
                    
                    
                </div>
                
            </article>  
            
        <?php endwhile;// End the loop. Whew. ?>
        
            <div class="clear"></div>
        
        <?php ms_pagination(); ?>
    
        <?php $wp_query = null; $wp_query = $temp;?>  
        
    <?php } // finish checking password protection ?>  
        
                                    
    </section>
    
    <?php if ( !isset($template_meta['blog_sidebar']) ) { ?>
    
		<?php get_sidebar(); ?>
    
    <?php } ?>
    
    <!-- Page Content ends here -->


<?php get_footer(); ?>