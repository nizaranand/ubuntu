			<?php if ( !is_home() &&  !is_page_template('template-fullscreen.php') ) { // don't show if 'index.php' or 'template-fullscreen.php' is being shown ?> 
               
            </div>
            <!-- Main Body (Body + Sidebar) ends here -->
            
            <!-- Desktop Footer starts here -->
            <footer id="desktop_footer" class="footer high_res_block <?php if ( is_active_sidebar( 'footer-high-res-widget-area' ) ) { ?>extended<?php } ?>">
            
				<?php if ( is_active_sidebar( 'footer-high-res-widget-area' ) ) { ?>
                
                <div class="footer_extended">
                
					<?php dynamic_sidebar( 'footer-high-res-widget-area' ); ?>
                    <div class="clear"></div>

                 </div>
                
                <?php } ?>
            
                <div class="footer_compact">
                
                    <p class="left"><?php echo of_get_option('ms_copyright_text'); ?></p>
                    
                    <nav id="desktop_secondry_nav" class="right">
						<?php echo ms_social_profiles('footer_social_nav'); ?>
                    </nav>
                
                </div>
            
            </footer>
            <!-- Desktop Footer ends here -->
            
            <!-- Smart Footer starts here -->
            <footer id="smartphone_footer" class="footer low_res_block <?php if ( is_active_sidebar( 'footer-low-res-widget-area' ) ) { ?>extended<?php } ?>">
            
				<?php if ( is_active_sidebar( 'footer-low-res-widget-area' ) ) { ?>
                
                <div class="footer_extended">
                
                    <div class="flex-container">
                        <div class="flexslider low_res_footer_slider">
                        	
                            <ul class="slides">
                               <?php dynamic_sidebar( 'footer-low-res-widget-area' ); ?> 
                            </ul>
                            
                        </div>
                        <div class="low_res_footer_nav"></div>
                        
                    </div>   
                    <div class="clear"></div>
                    
                </div>
                
                <?php } ?>
            
                <div class="footer_compact">
                    <p class="left"><?php echo of_get_option('ms_copyright_text'); ?></p>
                </div>
            
            </footer>
            <!-- Smart Footer ends here -->
            
            
        </div>
    
    
            <?php } ?> 
            
    </div>
    <!-- Wrapper ends here -->
    
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>