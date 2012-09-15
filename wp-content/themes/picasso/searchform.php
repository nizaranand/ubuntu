<?php
/**
 * Search Form Template
 */
?>

<form method="get" class="search_form" id="desktop_search" action="<?php echo home_url(); ?>/">
    <p class="bottom">
        <label for="s"><?php _e('Type and hit go ...', 'framework') ?></label>
        <input type="text" class="search_field" name="s" value="" id="s">
        <button type="submit" class="search_button"><?php _e('Go', 'framework') ?></button>    
    </p>
</form>