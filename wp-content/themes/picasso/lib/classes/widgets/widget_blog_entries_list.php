<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Blog Entries Widget
	Plugin URI: http://www.themesforest.net
	Description: A widget that displays Blog entries
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://www.themesforest.net

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'ms_blog_entries_lists' );

// Register widget
function ms_blog_entries_lists() {
	register_widget( 'ms_blog_entries_list' );
}

// Widget class
class ms_blog_entries_list extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function ms_blog_entries_list() {

	// Widget settings
	$widget_ops = array(
		'classname' => 'ms_blog_entries_list',
		'description' => __('A widget that displays Blog entries.', 'framework')
	);

	// Widget control settings
	$control_ops = array(
		'width' => 300,
		'height' => 350,
		'id_base' => 'ms_blog_entries_list'
	);

	// Create the widget
	$this->WP_Widget( 'ms_blog_entries_list', __('Blog Entries List', 'framework'), $widget_ops, $control_ops );
	
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$no_entries = $instance['no_entries'];
	$category = $instance['category'];
	$sort = $instance['sort'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title . $title . $after_title;

	// Advaced Categories Variables
    global $custom_post_metabox, $theme_name_l;
    
	$category = get_cat_ID($category);
	
	$order_by_comments = ($sort == 'popular') ? 'comment_count' : '';
	?>

    <ul class="entries-list">
    
    <?php         
    $recent = new WP_Query('cat='. $category .'&showposts='. $no_entries .'&orderby='. $order_by_comments);
    while($recent->have_posts()) : $recent->the_post();
	
	// Tumbnail Resizing Variables
	$thumb_resize_parameters = '75, 50, true'; // width, height, crop
	
	?>        
        <li class="entries-list">
        
			<?php if( has_post_thumbnail() ) { ?>
            
				<?php echo ms_get_image(/* Url */ wp_get_attachment_url( get_post_thumbnail_id() ), /* Link */ NULL, /* Caption */ NULL, /* Lightbox */ 'none', /* TimThumb */ $thumb_resize_parameters, /* Link Attr */ NULL, /* Image Attr */ NULL); ?>
            
            <?php } ?>
                            
            <a href="<?php the_permalink(); ?>"><?php echo ms_truncate(get_the_title(), 30, ' '); ?></a>
            <span class="date">On <?php echo get_the_date(); ?></span>
            
        </li>
        
    <?php endwhile; ?>
    
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

	// No need to strip tags
	$instance['title'] = $new_instance['title'];
	$instance['category'] = $new_instance['category'];
	$instance['no_entries'] = $new_instance['no_entries'];
	$instance['sort'] = $new_instance['sort'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Blog',
		'no_entries' => '2',
		'category' => '',
		'sort' => 'latest',
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

	<!-- No. of Entries: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'no_entries' ); ?>"><?php _e('No. of Entries:', 'framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'no_entries' ); ?>" name="<?php echo $this->get_field_name( 'no_entries' ); ?>" value="<?php echo $instance['no_entries']; ?>" />
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
    
	<!-- Sort: Select Box -->
	<p>
		<label for="<?php echo $this->get_field_id( 'sort' ); ?>"><?php _e('Sort as:', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'sort' ); ?>" name="<?php echo $this->get_field_name( 'sort' ); ?>" class="widefat">
			<option <?php if ( 'latest' == $instance['sort'] ) echo 'selected="selected"'; ?>>latest</option>
			<option <?php if ( 'popular' == $instance['sort'] ) echo 'selected="selected"'; ?>>popular</option>
		</select>
	</p>
	
	<?php
	}
}
?>