<?php get_header(); ?>

<?php 
	// Globalizing Meta Variables
	global $single_portfolio_metabox, $global_lightbox_script;
	$portfolio_meta = $single_portfolio_metabox->the_meta();

	// Image Resizing Parameters
	$thumb_resize_parameters = '565, 420, 0'; // width, height, fixed height (0,1)
	
	// Lightbox
	$pg_lightbox_script = 'none'; // use script name to use specific one, 'null' to use global var. value
	$lightbox_script = ( !is_null($pg_lightbox_script) ? $pg_lightbox_script : $global_lightbox_script );
	
	// Comments
	$post_comments = '0'; // '0' to disable comments, '1' to enable comments
?>


    <!-- Page Content starts here -->
    <section class="page_content">
    
        <?php if( post_password_required() ) { // if password protected ?> 
        
            <?php the_content(); // used to display password form ?>
            
        <?php } else { // if NOT password protected ?> 
    
            <?php while (have_posts()) : the_post(); ?> 
            
            <?php 
            $current_project_ID =  get_the_ID(); // store current project ID in variable
            $current_project_tax =  get_the_terms( $post->ID, 'project-type' ); // store current project terms in variable
            
            foreach ($current_project_tax as $term) {
                $current_project_tax_slug[] = $term->slug;
            }
            ?>
                          
                <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio_entry portfolio_single_entry clearfix'); ?>>
                    
                    <div class="entry_header">
                    
                       <?php if ( of_get_option('ms_date_meta') != 1 ) { ?>
                       
                           <?php ms_date_meta(); ?>
                           
                       <?php } ?>
                   
                    </div>
                   
                    <?php  
                    
                        $args = array(  
                        'numberposts' => -1, // Using -1 loads all posts  
                        'orderby' => 'menu_order', // This ensures images are in the order set in the page media manager  
                        'order'=> 'ASC',  
                        'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos  
                        'post_parent' => $post->ID, // Important part - ensures the associated images are loaded 
                        'post_status' => null, 
                        'post_type' => 'attachment'  
                        );  
                        
                        $images = get_children( $args );  
                         ?>  
                        <div class="portfolio_images"> 
                        
                            <?php if( !isset($portfolio_meta['project_slider']) ){ // if project slider is NOT disabled ?>
                            <div class="flex-container">
                                <div class="flexslider flex_img_slider">
                            <?php } ?>
                            
                                    <ul class="slides no_thumb_overlay <?php isset($portfolio_meta['project_slider']) ? print 'slider_disable' : print 'slider_enable'; ?>">
                                        <?php if($images){ // if gallery images exist ?>
                                        
                                            <?php foreach($images as $image) { ?>  
                                                <li class="grid_entry"><?php echo ms_get_image(/* Url */ $image->guid, /* Link */ NULL, /* Caption */ NULL, /* Lightbox */ $lightbox_script, /* ImageResizer */ $thumb_resize_parameters, /* Link Attr */ null, /* Image Attr */ 'title="'. $image->post_title .'" alt="'. $image->post_title .'"'); ?></li>
                                            <?php } ?> 
                                            
                                        <?php } else { // else use featured image ?>  
                                        
                                            <li class="grid_entry"><?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ NULL, /* Caption */ NULL, /* Lightbox */ $lightbox_script, /* ImageResizer */ $thumb_resize_parameters, /* Link Attr */ null, /* Image Attr */ 'alt="'. get_the_title() .'"'); ?></li>
                                        
                                        <?php } ?>  
                                    </ul>
                                    
                            <?php if( !isset($portfolio_meta['project_slider']) ){ // if project slider is NOT disabled ?>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                                    
                        <div class="portfolio_desc">
                            
                            <span class="sidebar_top"></span>
                            
                            <div class="sidebar_inner">
                            
                                <h1><?php the_title(); ?></h1>
                                
                                <p><?php the_content(); ?></p>
                                
								<?php wp_link_pages(); ?>                
                                
                                <?php if ( isset($portfolio_meta['project_link']) ) { ?>
                                    <span class="read_more medium_button"><a href="<?php echo $portfolio_meta['project_link']; ?>"><?php isset($portfolio_meta['project_txt']) ? print $portfolio_meta['project_txt'] : _e('Visit Site', 'framework'); ?></a></span>
                                <?php } ?>
                                
                            </div>
                       
                    	   <span class="sidebar_bottom"></span>
                       
                        </div>
                                                
                </article> 
                
            <?php endwhile; ?>
            
            
            <?php /* Start Similiar Projects Loop */  ?>
            <?php 
            $temp = $wp_query;  // assign orginal query to temp variable for later use   
            $wp_query = null;
            $post_counter = 0;
            
            $wp_query = new WP_Query( // Start a new query for our videos
            array(
                'post_type' => 'ms_portfolio', // show posts from specified custom post type
                'tax_query' => array( array( 'taxonomy' => 'project-type', 'terms' => $current_project_tax_slug , 'field' => 'slug' ) ), // show posts under specified taxonomy -> term -> slug
                'posts_per_page' => 4, // show specified number of posts
                'orderby' => 'date', // order by specified attribute (e.g. date, title)
                'order' => 'DESC', // order by ASC or DESC
                'post__not_in' => array($current_project_ID) // use post ids. Specify post NOT to retrieve. 
                )
            );  			
            ?>
            
            <?php if ( have_posts() ) : ?>
            
            <section id="similiar_projects">
            
                <h1><?php _e( 'Similiar Projects', 'framework' ); ?></h1>
                <p class="comment-notes"><?php _e( 'If you like above project, you might also like some similiar project below', 'framework' ); ?></p>
         
                <ul class="similiar_projects similiar_entries clearfix">
                
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    
						<?php
						// Globalizing Meta Variables
						$similiar_portfolio_meta = $single_portfolio_metabox->the_meta();
						
                        // grab project entry link, (default: project single post)
                        $featured_img_link = isset($similiar_portfolio_meta['project_custom_link']) ? $similiar_portfolio_meta['project_custom_link'] : get_permalink();
                        
						 // if custom link defined use link icon, (default: post)
						$featured_img_link_type = isset($similiar_portfolio_meta['project_custom_link']) ? 'link' : 'post';
						?>
                    
                        <li class="grid_entry"><?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ $featured_img_link, /* Caption */ get_the_title(), /* Lightbox */ 'none', /* ImgResize Params */ '205, 135, 1', /* Link Attr */ 'class="'. $featured_img_link_type .'_link"', /* Image Attr */ null); ?></li>
                    
					<?php endwhile;// End the loop. Whew. ?>
               
                </ul>
                
            </section>
            
            <?php endif; ?>
        
            <?php $wp_query = null; $wp_query = $temp;?>  
            
            
        <?php } // finish checking password protection ?>  
        
    </section>
    <!-- Page Content ends here -->
                
<?php get_footer(); ?>