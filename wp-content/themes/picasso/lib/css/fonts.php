<?php header("Content-type: text/css");
require_once('../../../../../wp-load.php');
require_once('../../../../../wp-includes/post.php');
?>

/*-----------------------------------------------------------------------------------------------*/
/*	Google Fonts are defined here
/*-----------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------
	0. Primary Font
	1. Secondary Font
	
-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	0.	Primary Font
/*-----------------------------------------------------------------------------------*/

/* Google Font Integration */
h1, h2, h3, h4, h5, h6, thead, #bg_slide_caption p, ul#navigation a, .side_meta span.date, .side_meta span.month, .dropcap {
	font-family: '<?php echo $global_font_name; ?>', Arial, Helvetica, sans-serif;
}

/* Headings */
h1, h2, h3, h4, h5, h6 {
	line-height: 20px;
	font-weight: normal;
	letter-spacing: 1px;
	color: #CCCCCC !important;
}

h1 { font-size: 24px; }
h2 { font-size: 22px; }
h3 { font-size: 20px; }
h4 { font-size: 18px; }
h5 { font-size: 16px; }
h6 { font-size: 14px; }

/* Table */
.ms_table thead {
    font-size: 17px;
    line-height: 45px;
}

/* Primary Navigation */
ul#navigation a {
	color: #ffffff;
	font-size: 14px;
	letter-spacing: 1px;
}
ul#navigation ul a {
	font-size: 13px;
	font-weight: normal;
	text-transform: capitalize;
}

/* Page Header */
#main_content_header h3 {
	font-size: 24px !important;
	line-height: 75px !important;
	text-transform: uppercase;
}
#main_content_header h3 span {
	font-size: 15px !important;
}

/* Widget */
.widget h3 {
	text-transform: uppercase;
}

/* Side Meta */
.side_meta span.date, .side_meta span.month {
	color: #fff;
}
.side_meta span.date {
	font-size: 24px;
}
.side_meta span.month {
	font-size: 17px;
	text-transform: uppercase;
}

/* Dropcap */
.dropcap {
  font-size: 22px;
  line-height: 25px;
}


/*-----------------------------------------------------------------------------------*/
/*	1.	Secondary Font
/*-----------------------------------------------------------------------------------*/

@font-face {
    font-family: 'DroidSans';
    src: url('_fonts/DroidSans-webfont.eot');
    src: url('_fonts/DroidSans-webfont.eot?#iefix') format('embedded-opentype'),
         url('_fonts/DroidSans-webfont.woff') format('woff'),
         url('_fonts/DroidSans-webfont.ttf') format('truetype'),
         url('_fonts/DroidSans-webfont.svg#DroidSans') format('svg');
    font-weight: normal;
    font-style: normal;
}

body {
	font: 12px/20px "DroidSans","Helvetica Neue",Helvetica,Arial,sans-serif;
}
input, textarea {
	font: 12px/20px "DroidSans","Helvetica Neue",Helvetica,Arial,sans-serif;
}
