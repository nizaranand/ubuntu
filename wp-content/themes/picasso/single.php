<?php get_header(); ?>

<?php 
	// Globalizing Meta Variables
	global $single_entry_metabox, $global_lightbox_script;
	$single_meta = $single_entry_metabox->the_meta();

	// Image Resizing Parameters
	$ft_img_fix_height = 0; // 0 - for proportinate fetaured image height , 1 - for fixed featured image heigt
	
	if ( !isset($single_meta['single_blog_sidebar']) ) { // if sidebar is NOT disabled

		$thumb_resize_parameters = ($ft_img_fix_height == 1) ? '565, 250, 1' : '565, 9999, 0'; // width, height, fixed height (0,1)
	
	} else { // else if sidebar IS disabled
	
		$thumb_resize_parameters = ($ft_img_fix_height == 1) ? '888, 400, 1' : '888, 9999, 0'; // width, height, fixed height (0,1)
		
	}
	
	// Lightbox
	$pg_lightbox_script = 'none'; // use script name to use specific one, 'null' to use global var. value
	$lightbox_script = ( !is_null($pg_lightbox_script) ? $pg_lightbox_script : $global_lightbox_script );
	
	// Comments
	$post_comments = '0'; // '0' to disable comments, '1' to enable comments
	
	// Blog Sidebar Class
	$single_blog_sidebar = isset($single_meta['single_blog_sidebar']) ? 'without_sidebar' : 'with_sidebar';
?>

    
    <!-- Page Content starts here -->
    <section class="page_content <?php echo $single_blog_sidebar; ?>">
    
    <?php if( post_password_required() ) { // if password protected ?> 
    
        <?php the_content(); // used to display password form ?>
        
    <?php } else { // if NOT password protected ?> 
    
        <?php while (have_posts()) : the_post(); ?>
        
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog_entry single_entry'); ?>>
                
                <div class="entry_header">
                
                    <h1><?php the_title(); ?></h1>
                   
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
                        <ul class="slides no_thumb_overlay">
                            <li class="article_entry"><?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ NULL, /* Caption */ null, /* Lightbox */ $lightbox_script, /* Image Resize Params */ $thumb_resize_parameters, /* Link Attr */ null, /* Image Attr */ 'alt="'. get_the_title() .'"'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <?php } ?>
                
                
                <p><?php the_content(); ?></p>
                
				<?php wp_link_pages(); ?>                
                
            </article>  
            
            <?php comments_template( '', true ); ?>
            
            
        <?php endwhile; // End the loop. Whew. ?>
        
        
    <?php } // finish checking password protection ?>  
    
    
    </section>
    
    <?php if ( !isset($single_meta['single_blog_sidebar']) ) { ?>
    
		<?php get_sidebar(); ?>
    
    <?php } ?>
    <!-- Page Content ends here -->

<?php get_footer(); ?>