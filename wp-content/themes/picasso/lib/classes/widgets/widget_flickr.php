<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Flickr Photostream
	Plugin URI: http://www.themesforest.net
	Description: A widget that displays your Flickr photos
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://www.themesforest.net

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'ms_flickr_widgets' );

// Register widget
function ms_flickr_widgets() {
	register_widget( 'ms_flickr_widget' );
}

// Widget class
class ms_flickr_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function ms_flickr_widget() {

	// Widget settings
	$widget_ops = array(
		'classname' => 'ms_flickr_widget',
		'description' => __('A widget that displays your Flickr photos.', 'framework')
	);

	// Widget control settings
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'ms_flickr_widget'
	);

	// Create the widget
	$this->WP_Widget( 'ms_flickr_widget', __('Flickr Photostream', 'framework'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$flickr_ID = $instance['flickr_ID'];
	$no_entries = $instance['no_entries'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		$syled_title = explode(" ", $title);
		echo $before_title . $syled_title[0] . ' <span>' . $syled_title[1] .  '</span>' . $after_title;

	// Display Flickr Photos
	 ?>
		<?php echo parseFlickrFeed($flickr_ID, $no_entries); ?>
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
	$instance['flickr_ID'] = strip_tags( $new_instance['flickr_ID'] );

	// No need to strip tags
	$instance['no_entries'] = $new_instance['no_entries'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'My Photostream',
		'flickr_ID' => '53695860@N04',
		'no_entries' => '9',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<!-- Flickr ID: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'flickr_ID' ); ?>"><?php _e('Flickr ID:', 'framework') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'flickr_ID' ); ?>" name="<?php echo $this->get_field_name( 'flickr_ID' ); ?>" value="<?php echo $instance['flickr_ID']; ?>" />
	</p>
	
	<!-- Post Count: Select Box -->
	<p>
		<label for="<?php echo $this->get_field_id( 'no_entries' ); ?>"><?php _e('Number of Photos:', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'no_entries' ); ?>" name="<?php echo $this->get_field_name( 'no_entries' ); ?>" class="widefat">
			<option <?php if ( '3' == $instance['no_entries'] ) echo 'selected="selected"'; ?>>3</option>
			<option <?php if ( '6' == $instance['no_entries'] ) echo 'selected="selected"'; ?>>6</option>
			<option <?php if ( '9' == $instance['no_entries'] ) echo 'selected="selected"'; ?>>9</option>
			<option <?php if ( '12' == $instance['no_entries'] ) echo 'selected="selected"'; ?>>12</option>
		</select>
	</p>
	
	<?php
	}
}
?>