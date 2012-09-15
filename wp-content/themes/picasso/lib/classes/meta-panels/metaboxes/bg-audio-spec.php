<?php

$bg_audio_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_bg_audio_meta',
	'title' => 'Background Audio',
	'types' => array('post', 'page', 'ms_portfolio'), // added for posts, pages and portfolio
	'template' => MSTRENDS_CLASSES . '/meta-panels/metaboxes/bg-audio-meta.php',
));

/* eof */