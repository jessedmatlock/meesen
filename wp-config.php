<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'devsite');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('DISALLOW_FILE_EDIT', TRUE); // Sucuri Security: Fri, 07 Aug 2015 03:26:26 +0000




/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'g{e@_bw_x(5:o:bdaJ3p1?Oea}rg/A7I|;US[9bn%`MhQg+ ,29B 4M6%Dy`DPr.');
define('SECURE_AUTH_KEY',  '>wyDl|+l1ppyAO$enp!e$gZq-i*3i>g<kEbL+wt,-%ClCp94|IBH(yDwZ`|2T!8b');
define('LOGGED_IN_KEY',    'WBU:ZgEc|T&,Hv}8Dfv- 8YB?C1$P[,lz6%4CU+]d{uz+-p6A^!4nTY7@b:Nyt9B');
define('NONCE_KEY',        'uNoi7W&kG:hD:l<e=sRyk{A1>ckf>0V<kj7@wk:[(r4Ltb-N:^0aoF|D+q),~d<E');
define('AUTH_SALT',        '|)gT>EUv3=7YifYacJznKGy+NGzqdSp<_B|>]6f%|-B(H(y;$e_AikUgD{ZW_%!{');
define('SECURE_AUTH_SALT', 'e}pB?znJ{j3YC0~XG(AEdW:k:0t5?|nOE$9QcBgSL87pIW2.WL@m+LVR?BQ m2Gl');
define('LOGGED_IN_SALT',   '2iuE43zxm.A>?Fw6<u <U{,qc+^ Ch~k>;W-W+,IC7VrK4Cz.q@FdE~M+N:bJyDj');
define('NONCE_SALT',       'dq]V:?N6&n:XPH!-|42MN+B}eD;/$>HnlN%L2O/m~D:-L/x,+3KsUL*<3~rGz8s[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
// Hide the version of WP we're using to help thwart potential hackers from knowing it
remove_action('wp_head', 'wp_generator');