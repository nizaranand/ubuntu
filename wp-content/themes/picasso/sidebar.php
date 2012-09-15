<?php
/**
 * Sidebar Template
 */
?>

<!-- Sidebar starts here -->
<aside id="sidebar">

    <span class="sidebar_top"></span>
    
   
   <div class="sidebar_inner">
    <?php if ( is_active_sidebar( 'sidebar-widget-area' ) ) { ?>
    
        <?php dynamic_sidebar( 'sidebar-widget-area' ); ?>
    
    <?php } ?>
    </div>
    
    <span class="sidebar_bottom"></span>
    
</aside>  
<!-- Sidebar ends here -->
