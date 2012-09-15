<div class="my_meta_control">
 

<!-- Backround Type -->
<p class="trigger"><label><?php _e( 'Background Type', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
<p class="toggle_container"><?php _e( 'Select background type for this entry', 'framework' ); ?></p>
 
	<p>
	<?php $clients = array('Image', 'Video'); ?>

	<?php foreach ($clients as $i => $client): ?>
		<?php $metabox->the_field('background_type'); ?>
        <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'image'; // set default value ?>
        
		<input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
	<?php endforeach; ?>
	</p>
<hr>

<div id="bg_wrapper">


    <!-- Unique: Image -->
    <div class="image">

        <p class="trigger"><label><?php _e( 'Background Image', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Upload background image(s) and define caption(s) for them', 'framework' ); ?></p>
       
            <?php while($metabox->have_fields_and_multi('bg_images')): ?>
            <?php $metabox->the_group_open(); ?>
            <a href="#" class="dodelete button" style="float:right;"><?php _e( 'Del', 'framework' ); ?></a>
           
            <p>
                <strong class="prefix" style="width:4%; display: inline-block;"><?php _e( 'Url', 'framework' ); ?></strong>
                <?php $metabox->the_field('bg_img_url'); ?>
                <input type="text"  style="width:38%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
                
                <strong class="prefix" style="width:7%; display: inline-block; margin-left: 15px;"><?php _e( 'Caption', 'framework' ); ?></strong>
                <?php $metabox->the_field('bg_img_caption'); ?>
                <input type="text"  style="width:38%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        
            </p>
            <?php $metabox->the_group_close(); ?>
            <?php endwhile; ?>
        <p><a href="#" style="clear: both; margin-top: 5px;" class="docopy-bg_images button"><?php _e( 'Add', 'framework' ); ?></a></p>
        <hr>
    
        <p class="trigger"><label><?php _e( 'Background Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define your image background enhancement settings', 'framework' ); ?></p>
        
        <p>
        <?php $metabox->the_field('bg_img_autoplay'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Autoplay', 'framework' ); ?><br/>
        
        <?php $metabox->the_field('bg_img_random'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>display</code> Random', 'framework' ); ?><br/>
        </p>
        <hr class="hidden_hr">
    
    </div>

    <!-- Unique: Video -->
    <div class="video">
    
        <p class="trigger"><label><?php _e( 'Backround Video', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Upload video file in different formats for cross browser compatibility', 'framework' ); ?></p>
        
        <strong class="prefix" style="width:11%; display: inline-block;"><?php _e( 'Poster Image', 'framework' ); ?></strong>
        <?php $metabox->the_field('bg_poster_img_url'); ?>
        <input type="text"  style="width:36%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        
        <strong class="prefix" style="width:11%; display: inline-block; margin-left: 15px;"><?php _e( 'Mp4 Source', 'framework' ); ?></strong>
        <?php $metabox->the_field('bg_mp4_video_url'); ?>
        <input type="text"  style="width:36%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        
        <strong class="prefix" style="width:11%; display: inline-block;"><?php _e( 'Ogv Source', 'framework' ); ?></strong>
        <?php $metabox->the_field('bg_ogg_video_url'); ?>
        <input type="text"  style="width:36%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        
        <strong class="prefix" style="width:11%; display: inline-block; margin-left: 15px;"><?php _e( 'Webm Source', 'framework' ); ?></strong>
        <?php $metabox->the_field('bg_webm_video_url'); ?>
        <input type="text"  style="width:36%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>

        <hr>
        
        <p class="trigger"><label><?php _e( 'Video Caption', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter caption for your background video defined above', 'framework' ); ?></p>
        
        <?php $metabox->the_field('bg_vid_caption'); ?>
        <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Background Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define your video background enhancement settings', 'framework' ); ?></p>
        
        <p>
        <?php $metabox->the_field('bg_vid_autoplay'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Autoplay', 'framework' ); ?><br/>
        
        <?php $metabox->the_field('bg_vid_loop'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Loop', 'framework' ); ?><br/>
        
        <?php $metabox->the_field('bg_vid_audio'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Audio', 'framework' ); ?> <span class="checkbox_caption"><?php _e( '(check to mute video audio and use seperate background audio)', 'framework' ); ?></span><br/>
        
        </p>
        <hr class="hidden_hr">
    
    </div>

</div>

</div>	

