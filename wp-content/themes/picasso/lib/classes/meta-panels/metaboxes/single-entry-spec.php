<?php

$single_entry_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_single_entry_meta',
	'title' => 'Entry Details',
	'types' => array('post'), // added only for pages
	'priority' => 'high', // same as above, defaults to "high"
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/single-entry-meta.php',
));

/* eof */