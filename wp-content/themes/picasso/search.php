<?php get_header(); ?>

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
?>

                <!-- Page Content starts here -->
                <section class="page_content with_sidebar">
                
					<?php if ( ! have_posts() ) : ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog_entry site_entry_one_col_side'); ?>>
                            <h1><?php _e( 'Not Found', 'framework' ); ?></h1>
                            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'framework' ); ?></p>
                            <?php get_search_form(); ?>
                    </article>
                    <?php endif; ?>
                    
					<?php /* Start Latest Entries Loop */ ?>
					<?php 
					$post_counter = 0;
					while ( have_posts() ) : the_post(); // Default Loop Starts Here
					?>
                    
						<?php 
						// Globalizing Meta Variables
						global $single_entry_metabox;
						$single_meta = $single_entry_metabox->the_meta();
						
						// post counter and special class for last entry
						$post_counter++;
						$post_class = 'blog_entry site_entry_one_col_side '. ($post_counter == $wp_query->post_count ? 'last_entry' : '');
						?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
                            
                            <div class="entry_header">
                            
                                <h1><a href="<?php isset($single_meta['entry_custom_link']) ? print $single_meta['entry_custom_link'] : print get_permalink(); ?>"><?php the_title(); ?></a></h1>
                               
                               <?php if ( of_get_option('ms_date_meta') != 1 ) { ?>
                               
                                   
                                   <?php ms_date_meta(); ?>
                                   
                               <?php } ?>
                               
                               <?php if ( of_get_option('ms_blog_meta') != 1 ) { ?>
                                        
                                   <?php ms_post_meta(); ?>
                                    
                               <?php } ?>
                               
                            </div>
                            
                            <p><?php echo ms_truncate(get_the_excerpt(), 265, ' '); ?></p>
                            
							<?php if ( $single_meta['entry_read_more_txt'] != '0' ) { ?>
                                <span class="read_more"><a href="<?php isset($single_meta['entry_custom_link']) ? print $single_meta['entry_custom_link'] : print get_permalink(); ?>"><?php isset($single_meta['entry_read_more_txt']) ? print $single_meta['entry_read_more_txt'] : _e('Read More', 'framework'); ?></a></span>
                            <?php } ?>
                            
                        </article>  
                        
                        
					<?php endwhile;// End the loop. Whew. ?>
                                                
                </section>
                
				<?php get_sidebar(); ?>
                    
                <!-- Page Content ends here -->


<?php get_footer(); ?>