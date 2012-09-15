<?php get_header(); ?>

<section class="page_content">
    
    <div class="one_half smart_full_width">
    
        <p class="page_notice"><?php _e( 'Apologies, but no results were found for the requested archive. <br /> Perhaps searching will help find a related post.', 'framework' ); ?></p>
    
    </div>  
    
    <div class="one_half column-last smart_full_width error_404_form">
    
		<?php get_search_form(); ?> 
              
    </div>  
    
</section>

<?php get_footer(); ?>