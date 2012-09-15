<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Custom Comments List
	Plugin URI: http://www.themesforest.net
	Description: A widget that displays your site Latest Comments
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://www.themesforest.net

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'ms_comments_widgets' );

// Register widget
function ms_comments_widgets() {
	register_widget( 'ms_comments_widget' );
}

// Widget class
class ms_comments_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function ms_comments_widget() {

	// Widget settings
	$widget_ops = array(
		'classname' => 'ms_comments_widget',
		'description' => __('A widget that displays your site Latest Comments.', 'framework')
	);

	// Widget control settings
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'ms_comments_widget'
	);

	// Create the widget
	$this->WP_Widget( 'ms_comments_widget', __('Custom Comments List', 'framework'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$category = $instance['category'];
	$no_comments = $instance['no_comments'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title .  $title . $after_title;

	// Advaced Comments Variables
	// Advaced Categories Variables
    global $wpdb;
    
	$category = get_cat_ID($category);
	
	$children = get_categories("child_of=$category");
	$inlist = "$category";
	foreach ($children as $cat) {
	   $inlist .= ',' . $cat->cat_ID;
	}
	
	$sql =
	"SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID,
		comment_author, comment_date, comment_approved, comment_type,comment_author_url,
		SUBSTRING(comment_content,1,500) AS com_excerpt
	FROM $wpdb->term_taxonomy as t1, $wpdb->posts, $wpdb->term_relationships as r1, $wpdb->comments
	WHERE comment_approved = '1'
	   AND comment_type = ''
	   AND ID = comment_post_ID
	   AND post_password = ''
	   AND ID = r1.object_id
	   AND r1.term_taxonomy_id = t1.term_taxonomy_id
	   AND t1.taxonomy = 'category'
	   AND t1.term_id IN ($inlist)
	ORDER BY comment_date DESC LIMIT ". $no_comments ."";
	$comments = $wpdb->get_results($sql);
	?>
    
    <div class="quote_widget comments_widget">
    
        <div class="comments_wrap">
        
            <div class="flex-container">
            
                <div class="flexslider">
                    <ul class="nested_slides">
                    
					   <?php  foreach ($comments as $comment) { ?>
                    
                            <li class="entries-list">
                            
                                <?php echo ms_truncate(strip_tags($comment->com_excerpt), 100, ' '); ?>
                                
                            </li>
                        
                        <?php } ?>
                    
                    </ul>
                </div>
                <div class="quote_nav"></div>
            
            </div>
        
        </div>
    
    </div>     
    
    
    
    
    
    
    
    
	
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
	$instance['no_comments'] = strip_tags( $new_instance['no_comments'] );

	// No need to strip tags
	$instance['category'] = $new_instance['category'];
	
	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Comments',
		'category' => '',
		'no_comments' => '4',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	//Access the WordPress Categories via an Array
	$ms_categories = array();  
	$ms_categories_obj = get_categories('hide_empty=0');
	foreach ($ms_categories_obj as $ms_cat) {
		$ms_categories[$ms_cat->cat_ID] = $ms_cat->cat_name;}
	$categories_tmp = array_unshift($ms_categories, "Select ...");    
	 ?>

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>
    
	<!-- Category: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Category:', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" class="widefat">
		<?php foreach($ms_categories as $ms_cat) { ?>
        	<option <?php if ( $ms_cat == $instance['category'] ) echo 'selected="selected"'; ?>><?php echo $ms_cat; ?></option>
		<?php } ?>
		</select>
	</p>
    
	<!-- No. of Comments: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'no_comments' ); ?>"><?php _e('No. of Comments:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'no_comments' ); ?>" name="<?php echo $this->get_field_name( 'no_comments' ); ?>" value="<?php echo $instance['no_comments']; ?>" />
	</p>
	
		
	<?php
	}
}
?>