<div class="my_meta_control">
 

        <p class="trigger"><label><?php _e( 'Read More Text', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter custom text for read more button, leave it blank to disable read more button', 'framework' ); ?></p>
        
        <p>
            <?php $metabox->the_field('project_read_more_txt'); ?>
			<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = __('Read More', 'framework'); // set default value ?>
            
            <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Entry Custom Link', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter custom link (including http://) for this entry', 'framework' ); ?></p>
        
        <p>
            <?php $metabox->the_field('project_custom_link'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Project Button Text', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter custom text for visit site button', 'framework' ); ?></p>
        
        <p>
            <?php $metabox->the_field('project_txt'); ?>
			<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = __('Visit Site', 'framework'); // set default value ?>
            
            <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Project Link', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter link (including http://) of this project, leave it blank to disable visit site button', 'framework' ); ?></p>
        
        <p>
            <?php $metabox->the_field('project_link'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
            
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Project Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define your project enhancement settings', 'framework' ); ?></p>
        
        <p>
        <?php $metabox->the_field('project_slider'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Slider', 'framework' ); ?> <span class="checkbox_caption"><?php _e( '(for single project page)', 'framework' ); ?></span><br/>
        
        </p>
        <hr class="hidden_hr">


</div>	

