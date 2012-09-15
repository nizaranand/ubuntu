<div class="my_meta_control">
 

<!-- Backround Audio -->
<p class="trigger"><label><?php _e( 'Background Audio', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
<p class="toggle_container"><?php _e( 'Select an option to enable or disable background audio', 'framework' ); ?></p>
 
	<p>
	<?php $clients = array('Enable', 'Disable'); ?>

	<?php foreach ($clients as $i => $client): ?>
		<?php $metabox->the_field('background_audio'); ?>
        
        <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'disable'; // set default value ?>
        
		<input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
	<?php endforeach; ?>
	</p>
<hr>

<p class="trigger"><label><?php _e( 'Audio Details', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
<p class="toggle_container"><?php _e( 'Upload audio file in different formats for cross browser compatibility', 'framework' ); ?></p>

<strong class="prefix" style="width:10%; display: inline-block;"><?php _e( 'Mp3 Source', 'framework' ); ?></strong>
<?php $metabox->the_field('bg_aud_mp3_url'); ?>
<input type="text"  style="width:37%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>

<strong class="prefix" style="width:10%; display: inline-block; margin-left: 15px;"><?php _e( 'Oga Source', 'framework' ); ?></strong>
<?php $metabox->the_field('bg_aud_oga_url'); ?>
<input type="text"  style="width:37%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>

<hr>

<p class="trigger"><label><?php _e( 'Background Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
<p class="toggle_container"><?php _e( 'Define your background audio enhancement settings', 'framework' ); ?></p>

<p>
<?php $metabox->the_field('bg_aud_autoplay'); ?>
<input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Autoplay', 'framework' ); ?><br/>

<?php $metabox->the_field('bg_aud_loop'); ?>
<input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>disable</code> Loop', 'framework' ); ?><br/>

</p>
<hr class="hidden_hr">

</div>	

