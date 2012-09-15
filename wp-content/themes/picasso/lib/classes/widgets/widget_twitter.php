<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Twitter Stream
	Plugin URI: http://www.themesforest.net
	Description: A widget that displays latest tweets from Twitter
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://www.themesforest.net

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'ms_twitter_widgets' );

// Register widget
function ms_twitter_widgets() {
	register_widget( 'ms_twitter_widget' );
}

// Widget class
class ms_twitter_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function ms_twitter_widget() {

	// Widget settings
	$widget_ops = array(
		'classname' => 'ms_twitter_widget',
		'description' => __('A widget that displays latest tweets from Twitter.', 'framework')
	);

	// Widget control settings
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'ms_twitter_widget'
	);

	// Create the widget
	$this->WP_Widget( 'ms_twitter_widget', __('Twitter Stream', 'framework'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$twitter_user = $instance['twitter_user'];
	$no_tweets = $instance['no_tweets'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title . $title . $after_title;

	// Display Twitter Stream
	 ?>
     
	<?php echo parseTwitterStream($twitter_user, $no_tweets); ?>
     
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
	$instance['twitter_user'] = strip_tags( $new_instance['twitter_user'] );
	$instance['no_tweets'] = strip_tags( $new_instance['no_tweets'] );

	// No need to strip tags

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Twitter',
		'twitter_user' => 'TheRock',
		'no_tweets' => '5',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<!-- Twitter Username: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'twitter_user' ); ?>"><?php _e('Username:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_user' ); ?>" name="<?php echo $this->get_field_name( 'twitter_user' ); ?>" value="<?php echo $instance['twitter_user']; ?>" />
	</p>
	
	<!-- Number of Tweets: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'no_tweets' ); ?>"><?php _e('Number of Tweets:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'no_tweets' ); ?>" name="<?php echo $this->get_field_name( 'no_tweets' ); ?>" value="<?php echo $instance['no_tweets']; ?>" />
	</p>
		
	<?php
	}
}
?>