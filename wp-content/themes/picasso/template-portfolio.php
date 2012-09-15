<?php
/*
Template Name: Portfolio Template
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

	// Image Resizing Parameters
	$thumb_resize_parameters = '430, 225, 1'; // width, height, fixed height (0,1)
	
	// Lightbox
	$pg_lightbox_script = strtolower($template_meta['portfolio_lightbox_script']); // use script name to use specific one, 'null' to use global var. value
	$lightbox_script = ( !is_null($pg_lightbox_script) ? $pg_lightbox_script : $global_lightbox_script );
	$lightbox_script = $lightbox_script != 'fancybox' ? $lightbox_script.'['. rand() .']' : $lightbox_script; // modify variable because fancybox not working with bracket id
	
	// Portfolio Project Terms
	if( $template_meta['portfolio_project_type'] == 'root' ) { // store all root lavel project-type terms slug in an array ($tax_terms_slug)
	
		$tax_terms = get_terms( 'project-type', 'orderby=none&hide_empty' );
		foreach ($tax_terms as $term) {
			
			if ( $term->count > 0 ) { // store term in array only if it has any post
				
				$tax_terms_slug[] = $term->slug;
				
			}
			
			
		}
	
	
	} else { // else store parent and all child lavel project-type terms slug in an array ($tax_terms_slug)
	
		$tax_terms = get_term_children( $template_meta['portfolio_project_type'], 'project-type' );
		
		// store parent term slug in array ($tax_terms_slug)
		$parent_term = get_term_by( 'id', $template_meta['portfolio_project_type'], 'project-type' );
		if ( $parent_term->count > 0 ) { // store term in array only if it has any post
			
			$tax_terms_slug[] = $parent_term->slug;
			
		}
		
		// store child terms slug in array ($tax_terms_slug)
		foreach ($tax_terms as $term) {
			$term = get_term_by( 'id', $term, 'project-type' );
			if ( $term->count > 0 ) { // store term in array only if it has any post
				
				$tax_terms_slug[] = $term->slug;
				
			}
		}
	
	}
	
?>

	<?php if ( isset($template_meta['portfolio_filteration_sorting']) && !post_password_required() ) { ?>
    <!-- Portfolio Nav. starts here -->
    <div id="portfolio_nav">
        <div class="filteration_wrap">
            <span><?php _e('Filter', 'framework') ?></span>
            
            <a data-filter="*" href="<?php echo remove_query_arg( 'filter' );?>">All</a>
			
			<?php foreach ($tax_terms_slug as $term) { $term = get_term_by( 'slug', $term, 'project-type' ); ?>
                <a data-filter=".<?php echo $term->slug;?>" href="<?php echo add_query_arg(array ('paged' => '1',  'filter' => $term->slug));?>" title="<?php _e('Filter by', 'framework') ?> <?php echo $term->name;?>"><?php echo $term->name;?></a>
            <?php } ?>            
			
        </div>
        
        <div class="sort_wrap">
            <span><?php _e('Sort', 'framework') ?></span>
            
            <a href="<?php echo add_query_arg(array ('paged' => '1',  'orderby' => 'date', 'order' => 'DESC'));?>"><?php _e('Date', 'framework') ?></a>
            <a href="<?php echo add_query_arg(array ('paged' => '1',  'orderby' => 'title', 'order' => 'ASC'));?>"><?php _e('Name', 'framework') ?></a>
                        
        </div>
    </div>
    <!-- Portfolio Nav. ends here -->
	<?php } ?>   
                     
    <!-- Portfolio starts here -->
    <div id="portfolio" class="page_content">
    
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
    
        
            <?php /* Start Latest Entries Loop */  ?>
			<?php 
            $temp = $wp_query;  // assign orginal query to temp variable for later use   
            $wp_query = null;
            $post_counter = 0;
			
            $wp_query = new WP_Query( // Start a new query for our videos
            array(
                'post_type' => 'ms_portfolio', // show posts from specified custom post type
                'tax_query' => array( array( 'taxonomy' => 'project-type', 'terms' => isset($_GET['filter']) ? $_GET['filter'] : $tax_terms_slug , 'field' => 'slug' ) ), // show posts under specified taxonomy -> term -> slug
                'posts_per_page' => $template_meta['entries_per_page'], // show specified number of posts
                'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'date', // order by specified attribute (e.g. date, title)
                'order' => isset($_GET['order']) ? $_GET['order'] : 'DESC', // order by ASC or DESC
                'paged' => $paged // current page number
                )
            );  
			
            ?>
            
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
			<?php 
            // Globalizing Meta Variables
            global $single_portfolio_metabox;
            $portfolio_meta = $single_portfolio_metabox->the_meta();
			
			$current_project_ID =  get_the_ID(); // store current project ID in variable
			$current_project_tax =  get_the_terms( $post->ID, 'project-type' ); // store current project terms in variable
			
			foreach ($current_project_tax as $term) {
				$current_project_tax_slug[] = $term->slug;
			}
			
			
			// grab featured image link, [custom entry link > featured image link > (default: featured image url)]
			$featured_img_link = isset($portfolio_meta['project_custom_link']) ? $portfolio_meta['project_custom_link'] : (get_post_meta(get_post_thumbnail_id(), '_wp_attachment_url', true) ? get_post_meta(get_post_thumbnail_id(), '_wp_attachment_url', true) : wp_get_attachment_url( get_post_thumbnail_id()) );
			
			
			if (isset($portfolio_meta['project_custom_link'])) { // if custom link defined, use link icon
			
				$featured_img_link_type = 'link';
			
			} else { // else determine hover icon, based on 'link type' value (default: image)
				
				$featured_img_link_type = get_post_meta(get_post_thumbnail_id(), 'ms_link_type', true) ? get_post_meta(get_post_thumbnail_id(), 'ms_link_type', true) : 'image';
			
			}
			
			if (strpos($lightbox_script,'prettyphoto') !== false) { // if prettyphoto, apply lightbox on video and image links
				
				$final_lightbox_script =  $featured_img_link_type == 'image' || $featured_img_link_type == 'video' ? $lightbox_script : 'none';
				
			} else { // else, apply lightbox only on image links
				
				$final_lightbox_script =  $featured_img_link_type == 'image' ? $lightbox_script : 'none';
				
			}
			
			
			// post counter and project classes
			$post_counter++;
			
			$post_odd_even = $wp_query->post_count % 2 ? 'odd' : 'even';
			
			$last_posts_class = $post_odd_even == 'odd' ? ( $post_counter == $wp_query->post_count ? 'last_project' : '' ) : ( $post_counter == $wp_query->post_count || $post_counter == $wp_query->post_count - 1 ? ( $post_counter == $wp_query->post_count ? 'last_project' : 'second_last_project' ) : '' );
			$project_classes = 'portfolio_entry site_entry_two_col_full '. implode(' ', $current_project_tax_slug). ' '. $last_posts_class;
            ?>

            
                <article id="post-<?php the_ID(); ?>" data-id="post-<?php the_ID(); ?>" <?php post_class($project_classes); ?>>
                
                    <div class="flex-container">
                        <div class="flexslider">
                            <ul class="slides">
                                <li><?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ $featured_img_link, /* Caption */ null, /* Lightbox */ $final_lightbox_script, /* Image Resizer */ $thumb_resize_parameters, /* Link Attr */ 'class="'. $featured_img_link_type .'_link"', /* Image Attr */ 'title="'. get_the_title() .'" alt="'. get_the_title() .'"'); ?></li>
                            </ul>
                        </div>
                    </div>
                    
                    <h1><a href="<?php isset($portfolio_meta['project_custom_link']) ? print $portfolio_meta['project_custom_link'] : the_permalink(); ?>"><?php the_title(); ?></a></h1>
                    
                    
					<?php if ( isset($template_meta['portfolio_full_content']) ) { ?>
                    
                        <?php the_content(); ?>
                        
						<?php if ( isset($portfolio_meta['project_link']) ) { ?>
                            <span class="read_more"><a href="<?php echo $portfolio_meta['project_link']; ?>"><?php isset($portfolio_meta['project_txt']) ? print $portfolio_meta['project_txt'] : _e('Visit Site',  'framework'); ?></a></span>
                        <?php } ?>
                    
                    <?php } else { ?>
                    
                        <p><?php echo ms_truncate(get_the_excerpt(), 240, ' '); ?></p>
                        
                        <div class="entry_buttons">
                        
                            <?php if ( $portfolio_meta['project_read_more_txt'] != '0' ) { ?>
                                <span class="read_more"><a href="<?php isset($portfolio_meta['project_custom_link']) ? print $portfolio_meta['project_custom_link'] : the_permalink(); ?>"><?php isset($portfolio_meta['project_read_more_txt']) ? print $portfolio_meta['project_read_more_txt'] : _e('Read More',  'framework'); ?></a></span>
                            <?php } ?>
                            
                            <?php if ( isset($portfolio_meta['project_link']) ) { ?>
                                <span class="read_more"><a href="<?php echo $portfolio_meta['project_link']; ?>"><?php isset($portfolio_meta['project_txt']) ? print $portfolio_meta['project_txt'] : _e('Visit Site',  'framework'); ?></a></span>
                            <?php } ?>
                            
                        </div>
                    
                    <?php } ?>
                    
                </article>  
            
            <?php endwhile;// End the loop. Whew. ?>
            
			<?php ms_pagination(); ?>
        
            <?php $wp_query = null; $wp_query = $temp;?>  
            
		<?php } // finish checking password protection ?>  
        
    </div>
    <!-- Portfolio ends here -->

<?php get_footer(); ?>