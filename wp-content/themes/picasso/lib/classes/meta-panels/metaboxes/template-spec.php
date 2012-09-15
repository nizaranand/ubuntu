<?php

$template_metabox  = new WPAlchemy_MetaBox(array
(
	'id' => '_template_meta',
	'title' => 'Template Configuration',
	'types' => array('page'), // added only for pages
	'priority' => 'high', // same as above, defaults to "high"
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/template-meta.php',
));

/* eof */