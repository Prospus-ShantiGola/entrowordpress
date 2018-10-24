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
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/var/www/html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'statheentropolis');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 't#3en+r0');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY', '}VN7m)`^96-SG8tDGG9xy$~)}nPr[2[u');
define('SECURE_AUTH_KEY', 'aqY*HQR4m]58i7qE2O6wACifD*=A/Cd~');
define('LOGGED_IN_KEY', 'HIYEhAkU8YY/_4Yst4Lqo3A34G9tpc7#');
define('NONCE_KEY', 'zl6gEI5pe{(/[79Sk39vVMh_)757b!rL');
define('AUTH_SALT', 'lDa/u3F%Pav(87:oe[)G`~26#9-{l$,z');
define('SECURE_AUTH_SALT', ' yT9cCm7~#=k>uiH?G_T/Ub _[3Xxp=I');
define('LOGGED_IN_SALT', 's6R7k)6iXo7aQ,:EA7KOf=<@N9v50X=6');
define('NONCE_SALT', 'd?WU7-KA2Vsco+:f;DM7v8%BuDthgF7M');

###FTP 
define('FS_METHOD', 'direct');
define('WP_MEMORY_LIMIT', '256M');
define('FTP_HOST', 'clubkidpreneur.com:21');
define('FTP_USER', 'clubkid1');
define('FTP_PASS', '2In33zPZ');
define('FS_TIMEOUT', 900);
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'qwml_';

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

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# protect wp-config.php
