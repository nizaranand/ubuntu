<?php

$shortcode_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_shortcode_meta',
	'title' => 'Shortcode Generator',
	'types' => array('post', 'page', 'ms_portfolio'), // added for posts, pages and portfolio
	'priority' => 'high', // same as above, defaults to "high"
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/shortcode-meta.php',
));

/* eof */