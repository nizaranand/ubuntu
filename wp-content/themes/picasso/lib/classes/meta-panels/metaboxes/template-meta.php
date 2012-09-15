<?php 
/* Get Categories */
$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
$wp_cats['root'] = 'All'; // set default item of array
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}

/* Get Portfolio Terms */
$portfolio_terms =  get_terms( 'project-type', 'orderby=none&hide_empty' );;
$wp_portfolio_terms = array();
$wp_portfolio_terms['root'] = 'All'; // set default item of array
foreach ($portfolio_terms as $terms_list ) {
       $wp_portfolio_terms[$terms_list->term_id] = $terms_list->name;
}
?>

<div class="my_meta_control">
 
    <div id="template_type_wrapper"> 
    
      
       <!-- Unique: Home Template -->
        <div class="template-fullscreen">
        
            <p class="meta_info"><?php _e( 'Their is no option for this template to define.', 'framework' ); ?></p>
            <hr class="hidden_hr">
            
        </div> 	
        
        <!-- Common: Default + Blog + Portfolio + Gallery + Contact -->
        <div class="default template-blog template-portfolio template-gallery template-contact">
        
            <p class="trigger"><label><?php _e( 'Custom Page Heading', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define custom page heading which will be displayed on page header', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('page_custom_heading'); ?>
                <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            </p>
            <hr>
        
            <p class="trigger"><label><?php _e( 'Page Sub Heading', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define sub heading for this page, it will be shown just beside main page heading', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('page_sub_heading'); ?>
                <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            </p>
            <hr>
            
        </div> 	
        
       <!-- Unique: Default Template -->
        <div class="default">
        
            <p class="trigger"><label><?php _e( 'Template Configuration', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define your template enhancement settings', 'framework' ); ?></p>
            
            <p>
            <?php $metabox->the_field('page_sidebar'); ?>
            <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Sidebar', 'framework' ); ?> <span class="checkbox_caption"><?php _e( '(check to have a full width page)', 'framework' ); ?></span><br/>
            
            </p>
            <hr class="hidden_hr">
            
        </div> 	
        
        <!-- Common: Blog + Portfolio -->
        <div class="template-blog">
        
            <p class="trigger"><label><?php _e( 'Category', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Select category for your blog, by default blog will grab posts from all root level categories', 'framework' ); ?></p>
            <p>
            <?php $metabox->the_field('template_category'); ?>
            <select name="<?php $metabox->the_name(); ?>" style="width: 200px;">
                <?php foreach ($wp_cats as $option) { ?>
                    <option value="<?php echo $option; ?>"<?php $metabox->the_select_state($option); ?>><?php echo $option; ?></option>
                <?php } ?>
            </select>
            <hr>
            
        </div> 	
        
        <!-- Common: Blog + Portfolio  -->
        <div class="template-blog template-portfolio">
        
            <p class="trigger"><label><?php _e( 'Entries Per Page', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define how many entries to show per page, if you define -1 it will show all available entries on one page', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('entries_per_page'); ?>
                <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '10'; // set default value ?>
                
                <input type="text" style="width:5%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            </p>
            <hr>
            
        </div>
        
    
       <!-- Unique: Blog -->
        <div class="template-blog">
        
            <p class="trigger"><label><?php _e( 'Blog Style', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Select appropriate layout for your blog', 'framework' ); ?></p>
            
            <p>
                <?php $clients = array('Standard', 'List', 'Magazine'); ?>
            
                <?php foreach ($clients as $i => $client): ?>
                    <?php $metabox->the_field('blog_style'); ?>
					<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'standard'; // set default value ?>
                    
                    <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
                <?php endforeach; ?>
            </p>
            <hr>
        
            <p class="trigger"><label><?php _e( 'Blog Enhancement', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define your blog enhancement settings', 'framework' ); ?></p>
            
            <p>
            <?php $metabox->the_field('blog_sidebar'); ?>
            <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Sidebar', 'framework' ); ?><br/>
            <?php $metabox->the_field('blog_full_content'); ?>
            <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>enable</code> Full Content', 'framework' ); ?> <span class="checkbox_caption"><?php _e( '(only for standard layout)', 'framework' ); ?></span><br/>
            </p>
            <hr class="hidden_hr">
            
        </div> 	
        
       <!-- Unique: Gallery -->
        <div class="template-gallery">
        
            <p class="trigger"><label><?php _e( 'Gallery Style', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Select appropriate layout for your Gallery', 'framework' ); ?></p>
            
            <p>
                <?php $clients = array('2 Column', '3 Column', '4 Column', '5 Column', 'Grid', 'Galleria'); ?>
            
                <?php foreach ($clients as $i => $client): ?>
                    <?php $metabox->the_field('gallery_style'); ?>
					<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '5-column'; // set default value ?>
                    
                    <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
                <?php endforeach; ?>
            </p>
            <hr>
            
            <div id="columnar_gallery_wrapper">
            
                    <!-- Unique: Columns Gallery -->
                    <div class="2-column 3-column 4-column 5-column grid">
                    
                        <p class="trigger"><label><?php _e( 'Images Per Page', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
                        <p class="toggle_container"><?php _e( 'Define how many images to show per page, if you define -1 it will show all available images on one page', 'framework' ); ?></p>
                        <p>
                            <?php $metabox->the_field('images_per_page'); ?>
                            <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '10'; // set default value ?>
                            
                            <input type="text" style="width:5%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
                        </p>
                        <hr>
                    
                        <p class="trigger"><label><?php _e( 'Lightbox Script', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
                        <p class="toggle_container"><?php _e( 'Select any lightbox script for your gallery images', 'framework' ); ?></p>
             
                        <p>
                        <?php $clients = array('None', 'PrettyPhoto', 'ColorBox', 'FancyBox'); ?>
                    
                        <?php foreach ($clients as $i => $client): ?>
                            <?php $metabox->the_field('gallery_lightbox_script'); ?>
							<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'fancybox'; // set default value ?>
                            
                            <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
                        <?php endforeach; ?>
                        </p>
                        <hr>
                        
                        <p class="trigger"><label><?php _e( 'Gallery Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
                        <p class="toggle_container"><?php _e( 'Define your gallery enhancement settings', 'framework' ); ?></p>
                        
                        <p>
                        <?php $metabox->the_field('gallery_masonry'); ?>
                        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>enable</code> Masonry', 'framework' ); ?> <span class="checkbox_caption"><?php _e( '(to have gallery thumbnails with flexible height)', 'framework' ); ?></span><br/>
                        
                        </p>
                        <hr class="hidden_hr">
                    
                    </div>
                    
            </div>
        
        </div>
        
       <!-- Unique: Portfolio -->
        <div class="template-portfolio">
        
            <p class="trigger"><label><?php _e( 'Category', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Select category for your portfolio, by default portfolio will grab projects from all root level categories', 'framework' ); ?></p>
            <p>
            <?php $metabox->the_field('portfolio_project_type'); ?>
            
            <select name="<?php $metabox->the_name(); ?>" style="width: 200px;">
                <?php foreach ($wp_portfolio_terms as $option_key => $option_value) { ?>
                    <option value="<?php echo $option_key; ?>"<?php $metabox->the_select_state($option_key); ?>><?php echo $option_value; ?></option>
                <?php } ?>
            </select>
            <hr>
            
            <p class="trigger"><label><?php _e( 'Lightbox Script', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Select any lightbox script for your portfolio featured image', 'framework' ); ?></p>
 
            <p>
            <?php $clients = array('PrettyPhoto', 'ColorBox', 'FancyBox'); ?>
        
            <?php foreach ($clients as $i => $client): ?>
                <?php $metabox->the_field('portfolio_lightbox_script'); ?>
                <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'prettyphoto'; // set default value ?>
                
                <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
            <?php endforeach; ?>
            </p>
            <hr>
        
            <p class="trigger"><label><?php _e( 'Portfolio Enhancement', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define your portfolio enhancement settings', 'framework' ); ?></p>
            
            <p>
            <?php $metabox->the_field('portfolio_filteration_sorting'); ?>
            <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>enable</code> Filteration &amp; Sorting', 'framework' ); ?><br/>
            
            <?php $metabox->the_field('portfolio_full_content'); ?>
            <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>enable</code> Full Content', 'framework' ); ?><br/>
            </p>
            <hr class="hidden_hr">
            
        </div> 	
        
       <!-- Unique: Contact -->
        <div class="template-contact">
        
            <p class="trigger"><label><?php _e( 'Email Address', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Provide email address to whom mail would be sent. By default admin email address is used', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('contact_email'); ?>
				<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = get_option('admin_email'); // set default value ?>
                
                <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            </p>
            <hr>
            
            <p class="trigger"><label><?php _e( 'Default Message', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define message which would be appear just above the contact form when form is not submitted', 'framework' ); ?></p>
				<?php $metabox->the_field('contact_default_msg'); ?>
                <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = __('If you have any question, feel free to contact us through form below.', 'framework'); // set default value ?>
                
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"><?php $metabox->the_value(); ?></textarea>
            <hr>
            
            <p class="trigger"><label><?php _e( 'Success Message', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define message which would be appear when form is submitted succefullly', 'framework' ); ?></p>
				<?php $metabox->the_field('contact_success_msg'); ?>
                <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = __('Thanks! your email was sent successfully.', 'framework'); // set default value ?>
                
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"><?php $metabox->the_value(); ?></textarea>
            <hr>
        
            <p class="trigger"><label><?php _e( 'Failure Message', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define message which would be appear when form is not submitted succesfully', 'framework' ); ?></p>
				<?php $metabox->the_field('contact_failure_msg'); ?>
                <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = __('Apologies! but your message was not sent successfully.', 'framework'); // set default value ?>
              
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"><?php $metabox->the_value(); ?></textarea>
            <hr class="hidden_hr">
        
        </div> 	
        
    </div>

</div>	

