<?php
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'winamco_local');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY', '5BsOuU.h`pd-JR%|O#E+_-%esZ9P0l&8@kOj%:]+Ox<PkkO]10z5 ~Db?nw3qki$');
define('SECURE_AUTH_KEY', '=:muTse583E<qr(o~I09)~{Y7X,/ql_PsitBODi4/<u$9Jhw@#r5`K2EdEm`8 ne');
define('LOGGED_IN_KEY', 'Y5>=8%i@ALl3dnPg6!Mo$4sF${i?DfmsOHwpX?/h.)f1K@=VK)Fhi|7EHREJYv.S');
define('NONCE_KEY', 'Bn`YpgC!}?Cx>N>DAr*@g05j<lZMI:e(ZMvY .<<ly!~@&IEej9nmu(V}<@UNEkb');
define('AUTH_SALT', 'd!rg`*)}k)~(]FLT0Zgpx:OPC>?0`|fc*{7@]HZVpx<LBL1<1!8P/-T1]4|DZ.mQ');
define('SECURE_AUTH_SALT', '?g@`CE_M$%P#UMBux:17Vn)mR8>}sUr$TKnZQ4CbQJSlEWJ3j{xCHFF.0K`,hzzT');
define('LOGGED_IN_SALT', 'oyjMjeG-MBi^9MB:!Tai7xQ,^jm^I,Hc5nBDt0)a}0HkL(8WpdqS2^oQoXEntJ2J');
define('NONCE_SALT', 'Rey)I0h`.6.a5w:P[!FrK9I0G{wrHUM_tB?N5Bg0,7{0r;)>ahPX@NGN|u/_OTwN');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'w04072023_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';