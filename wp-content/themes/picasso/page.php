<?php get_header(); ?>

<?php 
	// Globalizing Meta Variables
	global $template_metabox;
	$template_meta = $template_metabox->the_meta();
?>

<!-- Default Page starts here -->
<section id="default_page" class="page_content <?php if ( !isset($template_meta['page_sidebar']) ) { ?>with_sidebar<?php } ?>">

	<?php if( post_password_required() ) { // if password protected ?> 
   
        <?php the_content(); // used to display password form ?>
        
    <?php } else { // if NOT password protected ?> 
        
		<?php while ( have_posts() ) : the_post(); // Default Loop Starts Here  ?>
        
			<?php the_content(); ?>
        
        <?php endwhile; // End the loop. Whew. ?>
        
    <?php } // finish checking password protection ?>  
          
</section>
<!-- Default Page ends here -->

<?php if ( !isset($template_meta['page_sidebar']) ) { ?> 
	<?php get_sidebar(); ?>
<?php } ?>    

<?php get_footer(); ?>