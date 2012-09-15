<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

if ($_SERVER["HTTP_HOST"] === 'ubuntu.onlinepitstop.nl') {
	$dbname = 'ubuntu';
	$dbuser = 'root';
	$dbpassword = '';
	$dbhost = '';
} else if ($_SERVER["HTTP_HOST"] === 'ubuntu.local') {
	$dbname = 'ubuntu';
	$dbuser = 'root';
	$dbpassword = 'Tubbiee6';
	$dbhost = 'localhost';
	}

define('DB_NAME', $dbname);

/** MySQL database username */
define('DB_USER', $dbuser);

/** MySQL database password */
define('DB_PASSWORD', $dbpassword);

/** MySQL hostname */
define('DB_HOST', $dbhost);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'p@x?+FMpgBAmm>|dmlAa?d3*XcIa|N{lRzW~]C+IVM+--hP- ^|nivmNv6#d;ke|');
define('SECURE_AUTH_KEY',  'C#KF,MM}-:u`l56<{BC$*(-&xF#} ,0uu$!-}hSuX|%H]]PodbXpSgzc|E|Wu3(^');
define('LOGGED_IN_KEY',    'poH7V4bOfVkt93]Q%Fx2lBK(zi`Ty$_.3loVC^U.SO1m[l&l^Gw>!@[:/x:vO{K.');
define('NONCE_KEY',        '(1#Gh(6EG{#.;+&H+(CW1xV-CAO(@CA`l|B!P-7+:l5Q3O|IU` !g_o&b)OZkA7J');
define('AUTH_SALT',        'LG.gOi+#nt_LIs(IS0rC--`++cxF]kZ;v_15zKcqjrXr[ra>po8Fp}ip5M1-IIxE');
define('SECURE_AUTH_SALT', 'h:o|(=I=1m:R]-6->/9;R6/XC}HTB_$0qb2pPo_/ {wc1|$$[abWCIYg9=o+TK=-');
define('LOGGED_IN_SALT',   'x^jgcY[jI#Znd|4D$PJzQl}>xEO}wRG^6U&%:e9bY0bxLr0bCk4_,WmTcZ`tK7-y');
define('NONCE_SALT',       'JUM+^xgpC?0md3J t-STT,3A, _Uqz4qqoYWC-E7[n~M#WcP.v-EPc8Pn8oWe7pc');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'nl_NL');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');