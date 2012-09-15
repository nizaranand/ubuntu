<div class="my_meta_control">


<!-- Entry Type -->
<p class="trigger"><label><?php _e( 'Shortcode Type', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
<p class="toggle_container"><?php _e( 'Select shortcode type of your from list', 'framework' ); ?></p>
 
    <p>
		<?php $metabox->the_field('shortcode_type'); ?>
        <select name="<?php $metabox->the_name(); ?>" style="width: 150px;">
            <option value="">Select...</option>
            <option value="video">Video</option>
            <option value="columns">Columns</option>
            <option value="gallery">Gallery</option>
            <option value="slider">Slider</option>
            <option value="tab">Tabs</option>
            <option value="accordion">Accordions</option>
            <option value="toggle">Toggle</option>
            <option value="map">Google Map</option>
            <option value="buttons">Custom Buttons</option>
            <option value="boxes">Custom Boxes</option>
            <option value="quote">Block Quote</option>
            <option value="dropcap">Dropcap</option>
            <option value="high_light">Highlight</option>
            <option value="divider">Divider</option>
        </select>
    </p>
<hr>

<div id="shortcode_type_wrapper"> 
 
   <!-- Unique: Video -->
    <div class="video">
    
        <p class="trigger"><label><?php _e( 'Video Type', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select appropriate video type for shortcode', 'framework' ); ?></p>
        <p>
            <?php $clients = array('Youtube', 'Facebook', 'Vimeo', 'Dailymotion'); ?>
        
            <?php foreach ($clients as $i => $client): ?>
                <?php $metabox->the_field('video_type'); ?>
				<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'youtube'; // set default value ?>
                
                <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
            <?php endforeach; ?>
        </p>
        <hr>
        
        <div id="video_type_wrapper">
        
           <!-- Unique: Other Video -->
            <div class="youtube facebook vimeo dailymotion">
            
                <p class="trigger"><label><?php _e( 'Clip ID', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
                <p class="toggle_container"><?php _e( 'Provide unique ID of video', 'framework' ); ?></p>
                <p>
                    <?php $metabox->the_field('video_clip_id'); ?>
                    <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
                </p>
                <hr>
                
            </div>
            
            
        </div>  <!-- END: Video Type Wrapper -->
        
    </div>
    
   <!-- Unique: Columns -->
    <div class="columns">
    
        <p class="trigger"><label><?php _e( 'Columns Layout', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select columns layout from the list.', 'framework' ); ?></p>
         
            <p>
                <?php $metabox->the_field('columns_layout'); ?>
                <select name="<?php $metabox->the_name(); ?>" style="width: 210px;">
                    <option value="">Select...</option>
                    <option value="1">2 Columns</option>
                    <option value="2">3 Columns</option>
                    <option value="3">4 Columns</option>
                    <option value="4">5 Columns</option>
                    <option value="5">6 Columns</option>
                    <option value="6">1/4 Column + 3/4 Column</option>
                    <option value="7">3/4 Column + 1/4 Column</option>
                    <option value="8">2/3 Column + 1/3 Column</option>
                    <option value="9">1/3 Column + 2/3 Column</option>
                </select>
            </p>
        <hr>
    
    </div>
    
   <!-- Unique: Gallery -->
    <div class="gallery">
    
        <p class="trigger"><label><?php _e( 'Lightbox Script', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select any lightbox script for your gallery images', 'framework' ); ?></p>

        <p>
        <?php $clients = array('None', 'PrettyPhoto', 'Colorbox', 'FancyBox'); ?>
    
        <?php foreach ($clients as $i => $client): ?>
            <?php $metabox->the_field('lightbox_script'); ?>
            <?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'fancybox'; // set default value ?>
            
            <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
        <?php endforeach; ?>
        </p>
        <hr>

		<?php while($metabox->have_fields_and_multi('gallery_shortcode')): ?>
        <?php $metabox->the_group_open(); ?>
        
        <div class="gallery_index">
            <a href="#" class="dodelete button" style="float: right; margin: 0 10px 8px 0;"><?php _e( 'Del', 'framework' ); ?></a>
        
            <p class="trigger"><label><?php _e( 'Url', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Enter url of your gallery image', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('gallery_img_url'); ?>
                <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
            </p>
            <hr class="hidden_hr">
            
            <p class="trigger"><label><?php _e( 'Link', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define link for image provided above', 'framework' ); ?></p>
                    <?php $metabox->the_field('gallery_img_link'); ?>
                    <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
            <hr>
        </div>
                    
        <?php $metabox->the_group_close(); ?>
        <?php endwhile; ?>
        <p><a href="#" style="float: right; margin: 0 5px 0 0;" class="docopy-gallery_shortcode button"><?php _e( 'Add', 'framework' ); ?></a></p>
    
    </div>
    
   <!-- Unique: Slider -->
    <div class="slider">
    
		<?php while($metabox->have_fields_and_multi('slider_shortcode')): ?>
        <?php $metabox->the_group_open(); ?>
        
        <div class="slider_index">
            <a href="#" class="dodelete button" style="float: right; margin: 0 10px 8px 0;"><?php _e( 'Del', 'framework' ); ?></a>
        
            <p class="trigger"><label><?php _e( 'Url', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Enter url of your slider image', 'framework' ); ?></p>
            <p>
                <?php $metabox->the_field('slider_img_url'); ?>
                <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
            </p>
            <hr class="hidden_hr">
            
            <p class="trigger"><label><?php _e( 'Link', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
            <p class="toggle_container"><?php _e( 'Define link for image provided above', 'framework' ); ?></p>
                    <?php $metabox->the_field('slider_img_link'); ?>
                    <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
            <hr>
        </div>
                    
        <?php $metabox->the_group_close(); ?>
        <?php endwhile; ?>
        <p><a href="#" style="float: right; margin: 0 5px 0 0;" class="docopy-slider_shortcode button"><?php _e( 'Add', 'framework' ); ?></a></p>
    
    </div>
    
    
   <!-- Unique: Toggle -->
    <div class="toggle">
    
        <p class="trigger"><label><?php _e( 'Title', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter title for your toggle', 'framework' ); ?></p>
        <p>
			<?php $metabox->the_field('toggle_title'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Content', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define custom text for toggle content', 'framework' ); ?></p>
                <?php $metabox->the_field('toggle_content'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr class="hidden_hr">
    
    </div>
    
   <!-- Unique: Tabs -->
    <div class="tab">
    
    <?php while($metabox->have_fields_and_multi('tab_shortcode')): ?>
    <?php $metabox->the_group_open(); ?>
    
    <div class="tab_index">
        <a href="#" class="dodelete button" style="float: right; margin: 0 10px 8px 0;"><?php _e( 'Del', 'framework' ); ?></a>
    
        <p class="trigger"><label><?php _e( 'Title', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter title for your tab', 'framework' ); ?></p>
        <p>
			<?php $metabox->the_field('tab_title'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr class="hidden_hr">
        
        <p class="trigger"><label><?php _e( 'Content', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define custom text for tab content', 'framework' ); ?></p>
                <?php $metabox->the_field('tab_content'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr>
    </div>
                
    <?php $metabox->the_group_close(); ?>
    <?php endwhile; ?>
    <p><a href="#" style="float: right; margin: 0 5px 0 0;" class="docopy-tab_shortcode button"><?php _e( 'Add', 'framework' ); ?></a></p>
    
    </div>
    
   <!-- Unique: Accordion -->
    <div class="accordion">
    
    <?php while($metabox->have_fields_and_multi('accordion_shortcode')): ?>
    <?php $metabox->the_group_open(); ?>
    
    <div class="accordion_index">
        <a href="#" class="dodelete button" style="float: right; margin: 0 10px 8px 0;"><?php _e( 'Del', 'framework' ); ?></a>
    
        <p class="trigger"><label><?php _e( 'Title', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Enter title for your accordion', 'framework' ); ?></p>
        <p>
			<?php $metabox->the_field('accordion_title'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr class="hidden_hr">
        
        <p class="trigger"><label><?php _e( 'Content', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define custom text for accordion content', 'framework' ); ?></p>
                <?php $metabox->the_field('accordion_content'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr>
    </div>
                
    <?php $metabox->the_group_close(); ?>
    <?php endwhile; ?>
    <p><a href="#" style="float: right; margin: 0 5px 0 0;" class="docopy-accordion_shortcode button"><?php _e( 'Add', 'framework' ); ?></a></p>
    
    </div>
    
   <!-- Unique: Map -->
    <div class="map">
    
        <p class="trigger"><label><?php _e( 'Map Type', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select appropriate map type', 'framework' ); ?></p>
        <p>
            <?php $clients = array('Roadmap', 'Hybrid', 'Satellite', 'Terrain'); ?>
        
            <?php foreach ($clients as $i => $client): ?>
                <?php $metabox->the_field('map_type'); ?>
				<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 'roadmap'; // set default value ?>
                
                <input type="radio" name="<?php $metabox->the_name(); ?>" value="<?php echo str_replace(' ', '-', strtolower($client)); ?>"<?php $metabox->the_radio_state(str_replace(' ', '-', strtolower($client))); ?>/> <?php echo $client; ?>
            <?php endforeach; ?>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Map Address', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'The address to show in the map', 'framework' ); ?></p>
        <p>
            <?php $metabox->the_field('map_address'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr>
        
        
        <p class="trigger"><label><?php _e( 'Map Dimension', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define dimension of chart in (width x height) format', 'framework' ); ?></p>
        <p>
        <?php $metabox->the_field('map_width'); ?>
		<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '100%'; // set default value ?>
        
        <input type="text"  style="width:10%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        <strong class="suffix" style="margin-left:10px">x</strong>  
              
		<?php $metabox->the_field('map_height'); ?>
		<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '500px'; // set default value ?>
                
        <input type="text"  style="width:10%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Zoom', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Zoom level - use number 1-19', 'framework' ); ?></p>
        <p>
            <?php $metabox->the_field('map_zoom'); ?>
			<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = '14'; // set default value ?>
            
            <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Info Window', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'What to show in the popup, defaults to address.', 'framework' ); ?></p>
                <?php $metabox->the_field('map_info_window'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Map Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define your map enhancement settings.', 'framework' ); ?></p>
        
        <p>
        <?php $metabox->the_field('show_popup'); ?>
			<?php if(is_null($metabox->get_the_value())) $metabox->meta[$metabox->name] = 1; // set default value ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>show</code> Popup', 'framework' ); ?><br/>
        </p>
        <hr>
        
    </div>
    
   <!-- Unique: Buttons -->
    <div class="buttons">
    
        <p class="trigger"><label><?php _e( 'Button Color', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select color of the button from the list', 'framework' ); ?></p>
         
            <p>
                <?php $metabox->the_field('button_color'); ?>
                <select name="<?php $metabox->the_name(); ?>" style="width: 150px;">
                    <option value="">Select...</option>
                    <option value="default_button"<?php $metabox->the_select_state('default_button'); ?>>Default</option>
                    <option value="gray"<?php $metabox->the_select_state('gray'); ?>>Gray</option>
                    <option value="white"<?php $metabox->the_select_state('white'); ?>>White</option>
                    <option value="orange"<?php $metabox->the_select_state('orange'); ?>>Orange</option>
                    <option value="red"<?php $metabox->the_select_state('red'); ?>>Red</option>
                    <option value="blue"<?php $metabox->the_select_state('blue'); ?>>Blue</option>
                    <option value="rosy"<?php $metabox->the_select_state('rosy'); ?>>Rosy</option>
                    <option value="green"<?php $metabox->the_select_state('green'); ?>>Green</option>
                    <option value="pink"<?php $metabox->the_select_state('pink'); ?>>Pink</option>
                </select>
            </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Button Text', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Provide text for your button', 'framework' ); ?></p>
        <p>
            <?php $metabox->the_field('button_text'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Button Link', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Provide absolute url (including http://) to which your button will link', 'framework' ); ?></p>
        <p>
            <?php $metabox->the_field('button_link'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr>
        
        
    </div>
    
   <!-- Unique: Boxes -->
    <div class="boxes">
    
        <p class="trigger"><label><?php _e( 'Box Color', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select color of the box from the list', 'framework' ); ?></p>
         
            <p>
                <?php $metabox->the_field('box_color'); ?>
                <select name="<?php $metabox->the_name(); ?>" style="width: 150px;">
                    <option value="">Select...</option>
                    <option value="default"<?php $metabox->the_select_state('default'); ?>>Default</option>
                    <option value="gray"<?php $metabox->the_select_state('gray'); ?>>Gray</option>
                    <option value="white"<?php $metabox->the_select_state('white'); ?>>White</option>
                    <option value="orange"<?php $metabox->the_select_state('orange'); ?>>Orange</option>
                    <option value="red"<?php $metabox->the_select_state('red'); ?>>Red</option>
                    <option value="blue"<?php $metabox->the_select_state('blue'); ?>>Blue</option>
                    <option value="rosy"<?php $metabox->the_select_state('rosy'); ?>>Rosy</option>
                    <option value="green"<?php $metabox->the_select_state('green'); ?>>Green</option>
                    <option value="pink"<?php $metabox->the_select_state('pink'); ?>>Pink</option>
                </select>
            </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Content', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define custom text for box content', 'framework' ); ?></p>
                <?php $metabox->the_field('box_content'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr>
        
        
    </div>
    
   <!-- Unique: Block Quote -->
    <div class="quote">
    
        <p class="trigger"><label><?php _e( 'Source', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Provide source/author of this qoute', 'framework' ); ?></p>
        <p>
            <?php $metabox->the_field('quote_source'); ?>
            <input type="text" name="<?php $metabox->the_name(); ?>" value=""/>
        </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Content', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define text for quote content', 'framework' ); ?></p>
                <?php $metabox->the_field('quote_content'); ?>
                <textarea name="<?php $metabox->the_name(); ?>" rows="3"></textarea>
        <hr>
        
        
    </div>
    
   <!-- Unique: Dropcap -->
    <div class="dropcap">
    
        <p class="trigger"><label><?php _e( 'Dropcap Color', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select color of dropcap from the list', 'framework' ); ?></p>
         
            <p>
                <?php $metabox->the_field('dropcap_color'); ?>
                <select name="<?php $metabox->the_name(); ?>" style="width: 150px;">
                    <option value="">Select...</option>
                    <option value="default"<?php $metabox->the_select_state('default'); ?>>Default</option>
                    <option value="transparent"<?php $metabox->the_select_state('transparent'); ?>>Transparent</option>
                    <option value="gray"<?php $metabox->the_select_state('gray'); ?>>Gray</option>
                    <option value="white"<?php $metabox->the_select_state('white'); ?>>White</option>
                    <option value="orange"<?php $metabox->the_select_state('orange'); ?>>Orange</option>
                    <option value="red"<?php $metabox->the_select_state('red'); ?>>Red</option>
                    <option value="blue"<?php $metabox->the_select_state('blue'); ?>>Blue</option>
                    <option value="rosy"<?php $metabox->the_select_state('rosy'); ?>>Rosy</option>
                    <option value="green"<?php $metabox->the_select_state('green'); ?>>Green</option>
                    <option value="pink"<?php $metabox->the_select_state('pink'); ?>>Pink</option>
                </select>
            </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Dropcap Text', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define text for dropcap', 'framework' ); ?></p>
        <p>
        <?php $metabox->the_field('dropcap_text'); ?>
        <input type="text"  style="width:10%;" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        </p>
        <hr>
        
        
    </div>
    
   <!-- Unique: Highlight -->
    <div class="high_light">
    
        <p class="trigger"><label><?php _e( 'Highlight Color', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Select highlight color from the list', 'framework' ); ?></p>
         
            <p>
                <?php $metabox->the_field('highlight_color'); ?>
                <select name="<?php $metabox->the_name(); ?>" style="width: 150px;">
                    <option value="">Select...</option>
                    <option value="default"<?php $metabox->the_select_state('default'); ?>>Default</option>
                    <option value="gray"<?php $metabox->the_select_state('gray'); ?>>Gray</option>
                    <option value="white"<?php $metabox->the_select_state('white'); ?>>White</option>
                    <option value="orange"<?php $metabox->the_select_state('orange'); ?>>Orange</option>
                    <option value="red"<?php $metabox->the_select_state('red'); ?>>Red</option>
                    <option value="blue"<?php $metabox->the_select_state('blue'); ?>>Blue</option>
                    <option value="rosy"<?php $metabox->the_select_state('rosy'); ?>>Rosy</option>
                    <option value="green"<?php $metabox->the_select_state('green'); ?>>Green</option>
                    <option value="pink"<?php $metabox->the_select_state('pink'); ?>>Pink</option>
                </select>
            </p>
        <hr>
        
        <p class="trigger"><label><?php _e( 'Highlight Text', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define text which is to be highlighted', 'framework' ); ?></p>
        <p>
        <?php $metabox->the_field('highlight_text'); ?>
        <input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
        </p>
        <hr>
        
        
    </div>
    
   <!-- Unique: Divider -->
    <div class="divider">
    
        <p class="trigger"><label><?php _e( 'Divider Enhancements', 'framework' ); ?></label><a href="#" class="more_info"><?php _e( '[+] more info', 'framework' ); ?></a></p>
        <p class="toggle_container"><?php _e( 'Define your divider enhancement settings', 'framework' ); ?></p>
        
        <p>
        <?php $metabox->the_field('divider_top'); ?>
        <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php $metabox->the_checkbox_state('1'); ?>/> <?php _e( '<code>enable</code> Top Link', 'framework' ); ?><br/>
        </p>
        <hr>
        
        
    </div>
    
    
</div>

<!-- Shotcode generator Button -->
<p><a href="#" id="create_shortcode" class="right button"><?php _e( 'Create Shortcode', 'framework' ); ?></a></p>
<hr class="hidden_hr">

</div>