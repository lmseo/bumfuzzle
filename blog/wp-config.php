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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/content/38/11054938/html/blog/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'eopiatesWPBlog');

/** MySQL database username */
define('DB_USER', 'eopiatesWPBlog');

/** MySQL database password */
define('DB_PASSWORD', 'Masselin104!@#');

/** MySQL hostname */
define('DB_HOST', 'eopiatesWPBlog.db.11054938.hostedresource.com');

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
define('AUTH_KEY',         '0zDddC+fya9d=~MN6&$k(1b6gzpnd<g%-&8C0%HB&EUHg4,ekFg|Iy~kLsp8>$1?');
define('SECURE_AUTH_KEY',  'C9~(/36@dbV3I392S_Z`sbL*M,XN&/oaX=X,cqE|?b?dnQn)]Qg+m/{gS [ooiH-');
define('LOGGED_IN_KEY',    '+~v]aj^Qj)4zgH5eNZ|eDE2gX-s~;<,;P5&n9TN`SgL|F-HcbmeeHx:rQ~A~x/!&');
define('NONCE_KEY',        '|dhV]Ug,G.?R*#A;-z+Mo-uA|c )ORagiZ!|e%l*D!:UUASD:q-g<NSTxWN=cqO+');
define('AUTH_SALT',        '#6eAL~U#DP>.G-o:8FE+$3Uv29/~xbY#$R~;CLOXiJ1MBq({nL1}1Jt^M+PpT@+]');
define('SECURE_AUTH_SALT', '2 (d+HbZ7A/Ket7(1D_!?tc]G$u|s/mmy1wd&E:>0O$#X6M#^Z!!C=Qf:7|K,C3C');
define('LOGGED_IN_SALT',   '%|euc~kGG(v@Ud.s!mldCty}@yz_xvDgo3T2@Cwg.j>?C{R8{/4b2(z[wg-)Jp 8');
define('NONCE_SALT',       ')Qt6vc,<TW%jC^)`#K8_sURIK >&Y#Ljs|[;t %|QpThJw=1W<,!FIV#&ClWiue<');

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
define('WPLANG', '');

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
