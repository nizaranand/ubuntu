<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Contact Info
	Plugin URI: http://www.themesforest.net
	Description: A widget that displays some Contact Information
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://www.themesforest.net

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'ms_contact_info_widgets' );

// Register widget
function ms_contact_info_widgets() {
	register_widget( 'ms_contact_info_widget' );
}

// Widget class
class ms_contact_info_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function ms_contact_info_widget() {

	// Widget settings
	$widget_ops = array(
		'classname' => 'ms_contact_info_widget',
		'description' => __('A widget that displays some Contact Information', 'framework')
	);

	// Widget control settings
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'ms_contact_info_widget'
	);

	// Create the widget
	$this->WP_Widget( 'ms_contact_info_widget', __('Contact Info', 'framework'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$name = $instance['name'];
	$email = $instance['email'];
	$phone = $instance['phone'];
	$address = $instance['address'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title . $title . $after_title;

	// Display Flickr Photos
	 ?>
     
    <ul class="menu contact_info">
    
    	<?php if( !empty($name) ) { ?>
            <li><p class="name"><?php echo $name; ?></p></li>
    	<?php } ?>
        
    	<?php if( !empty($email) ) { ?>
            <li><p class="email"><?php echo $email; ?></p></li>
    	<?php } ?>
        
    	<?php if( !empty($phone) ) { ?>
            <li><p class="phone"><?php echo $phone; ?></p></li>
    	<?php } ?>
        
    	<?php if( !empty($address) ) { ?>
            <li><p class="address"><?php echo $address; ?></p></li>
    	<?php } ?>
        
    </ul>
      
	<?php

	// After widget (defined by theme functions file)
	echo $after_widget;
	
}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
	
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	// Strip tags to remove HTML (important for text inputs)
	$instance['title'] = strip_tags( $new_instance['title'] );
	$instance['name'] = strip_tags( $new_instance['name'] );
	$instance['email'] = strip_tags( $new_instance['email'] );
	$instance['phone'] = strip_tags( $new_instance['phone'] );
	$instance['address'] = strip_tags( $new_instance['address'] );

	// No need to strip tags

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Info',
		'name' => '',
		'email' => get_option('admin_email'),
		'phone' => '',
		'address' => '',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<!-- Name: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Name:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" />
	</p>
	
	<!-- Email: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" />
	</p>
    
	<!-- Phone: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" />
	</p>
    
	<!-- Address: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Address:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" />
	</p>
		
	<?php
	}
}
?>