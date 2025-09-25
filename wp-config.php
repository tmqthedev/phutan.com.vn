<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define( 'WP_CACHE', true ); // Added by AccelerateWP

define( 'ITSEC_ENCRYPTION_KEY', 'MTZsM3dGfXF0Mk0oWVVzSU89KU1MUD9NdCt9WHp7UHtGQy84eEBWIEkhaVlYQzhBLjMuUW8gXTdBWjdPODhQTQ==' );

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'aqmkbwxk_phutan' );

/** Database username */
define( 'DB_USER', 'aqmkbwxk_uphutan' );

/** Database password */
define( 'DB_PASSWORD', 'Y!qzVS7L8d3x' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0kChTX4q[V~boq&#<r8r|El^Fs@8gKXPYAYq|UGlp9~P$.-qM%|u?A9 r9Xuv}0s' );
define( 'SECURE_AUTH_KEY',  '-xj:#[qQ4RdB4-#N[ANQcr~EU?s;Neh.: dp&gOE3g,9ZM6hWC</j8hF^ bPt(M(' );
define( 'LOGGED_IN_KEY',    '!F;7b+A9?:SX:osgM=$S)9YdwjF|aaX=~j`*LDNfX1C=][{8S9Y;^ ym},@7]ug/' );
define( 'NONCE_KEY',        '-<iI$i3}|h&*c=U`=;Lw~^pKy_+t0&EYbum{^:ksfxyQ06x8=wX{O9ui.a%WI lC' );
define( 'AUTH_SALT',        '?rj*|4Iuwoh+zvw?Fy&>Wodk3 )Pxas&u*@Y>tPsjLZUr]S8iX*Dl1%eLH_N=jir' );
define( 'SECURE_AUTH_SALT', 'y}np9F&ho*2I^JM<vh9IdaMf[1u|D<7@7%+ex=hz13i]/Mkw{wBOU2^gomVkH~p!' );
define( 'LOGGED_IN_SALT',   '_@T2bmo>C`RzJGcDQ/Bl~I/b]<BJP@i:2iYTt2UZVlrh-VknnZDI)y95?^h;~E@M' );
define( 'NONCE_SALT',       'YUPFEFc|tIzDh~`a&n~zf/9(6p@H2hGF13GPV3-q(n%L3fjISaG)6(vs-IO3o2`1' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pt_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
