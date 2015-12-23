<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'u440522676_hcoop');

/** MySQL database username */
define('DB_USER', 'u440522676_hcoop');

/** MySQL database password */
define('DB_PASSWORD', 'tkddn12');

/** MySQL hostname */
define('DB_HOST', 'mysql.hostinger.kr');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '-2<sPvs@-v*euo+:j~*{8D9Oa9$4%dHn9yUgD//x.H<:,48G/.d}J! 8kHS]/36|');
define('SECURE_AUTH_KEY',  'YzbFMyM;x9QR^;looFp|%vxkf2/$P!~8cI-xO9Ql,wNR6|bt- oO}-+^wRu*A721');
define('LOGGED_IN_KEY',    '8 ~FwGmbqP!dUgWU?4GC33:6]1AG8VubLb~+LbZ+SA)dSYJv)jTmP(<SfX_3,wC/');
define('NONCE_KEY',        '@-LheUx/LajU=3,je13VGk-ys3|HJ[}aAr&nVA(LyPs[R|_tFh~PWq+ o6Og^/G>');
define('AUTH_SALT',        ',Ha!_4Rzl7H!kr7LUzQ^*4*Hi+-oROn[|g}>*@LQi1.X.QET?%I+teJMSFDhG!!Y');
define('SECURE_AUTH_SALT', '.k8=av=s-YXGJ]Z8t+7}AN:hEd}09IY3y&[@S7C!c*T-2[KzMexjjffV5}Uw{j(c');
define('LOGGED_IN_SALT',   ' f|M?_X[9Mksg-Wv wCAaJo_,P3.lI.e~#{`66U7Fg|_+/MXy7eJYn_BPgV}89jw');
define('NONCE_SALT',       'BsF!-*+vt}vC-e,O#:bK{:G@1~.|24~5I>646d`>B$`$0#AJz.BH7?}N[s>}8+Jp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');


/** Increase PHP Memory to 64MB */
define( 'WP_MEMORY_LIMIT', '64M' );

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
