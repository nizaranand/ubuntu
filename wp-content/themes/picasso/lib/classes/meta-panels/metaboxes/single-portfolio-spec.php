<?php

$single_portfolio_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_single_portfolio_meta',
	'title' => 'Project Details',
	'types' => array('ms_portfolio'), // added only for Portfolio custom post type
	'priority' => 'high', // same as above, defaults to "high"
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/single-portfolio-meta.php',
));

/* eof */