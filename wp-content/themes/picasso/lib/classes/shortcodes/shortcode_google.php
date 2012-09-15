<?php
/*-----------------------------------------------------------------------------------*/
/* Google Map by http://gis.yohman.com
/*-----------------------------------------------------------------------------------*/

function google_map_scripts() {
	// Register 'em
	wp_register_script( 'gmap',  MSTRENDS_JS .'/jquery.gmap.min.js', array('jquery'), '3.0' );
    
    // Enque 'em
    wp_enqueue_script( 'gmap' );
}
add_action( 'wp_enqueue_scripts', 'google_map_scripts' );

function google_map_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'maptype' 	=> 'roadmap',  	// hybrid, satellite, roadmap, terrain
		'zoom'		=> 14,			// 1-19
		'address'	=> '',			// Ex: 6921 Brayton Drive, Anchorage, Alaska
		'html'		=> '',			// Will default to Address if left empty
		'popup'		=> 'true',		// true/false
		'width'		=> '',			// Leave blank for 100%, need to use 'px' or '%'
		'height'	=> '500px'		// Need to use 'px' or '%'
	), $atts ) );
	
	// Map type
	$maptype = strtoupper( $maptype );
	
	// HTML
	if( ! $html )
		$html = $address;
		
	// Width/Height
	$styles = 'height:'.$height;
	if( $width )
		$styles .= ';width:'.$width;
	
	// Unique ID
	$id = rand();
	
	// Start output
	ob_start();
?>
	<!-- INCLUDE GOOGLE MAP API (can't be enqueue'd by WP) -->	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	
	<!-- RUN gMap() -->
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#gmap_<?php echo $id; ?>").gMap({
			maptype: "<?php echo $maptype; ?>",
			zoom: <?php echo $zoom; ?>,
			markers: [
				{
					address: "<?php echo $address; ?>",
					popup: <?php echo $popup; ?>,
					html: "<?php echo $html; ?>"
				}
			],
			controls: {
				panControl: true,
				zoomControl: true,
				mapTypeControl: true,
				scaleControl: true,
				streetViewControl: false,
				overviewMapControl: false
			}
		});
	});
	</script>
	<div id="gmap_<?php echo $id; ?>" class="gmap" style="<?php echo $styles; ?>"></div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'gmap', 'google_map_shortcode' );
?>