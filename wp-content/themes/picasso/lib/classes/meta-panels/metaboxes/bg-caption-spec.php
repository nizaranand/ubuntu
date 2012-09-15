<?php

$bg_caption_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_bg_caption_meta',
	'title' => 'Background & Caption',
	'types' => array('post', 'page', 'ms_portfolio'), // added for posts, pages and portfolio
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/bg-caption-meta.php',
));

/* eof */