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
define( 'DB_NAME', 'ng' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '0fSbw6[+ws ^E:9-tLa^~wJS`pxE]&5CM.x<5-,zL7 #%gheJ?92`u)&^Udbz>}V' );
define( 'SECURE_AUTH_KEY',  'X0Xk^{Sf{-=-(6fhT8~/|`DTWNebbYv[i<}n}^MN%*YY&s}Asid4_/QMxCy#FN=E' );
define( 'LOGGED_IN_KEY',    'ax@)trVFOH#n;!215pJ#O~(lDprHi4QJE;)c)5Xe1Y:6@{4(Z:3G&>yR)(>yUWYO' );
define( 'NONCE_KEY',        '}e#3-vlAaP[~ZzSWJ^qVbt2%U-3?%O<A56Ti`!_ &s3S%E:jZ.R`|CfLu]F?Rk}D' );
define( 'AUTH_SALT',        '0]-) (aqzwLm,n%d%wD)Mh-/>x.R9oO`3`@gFWR,lbe._&Al~{C33&AHzal:!X7S' );
define( 'SECURE_AUTH_SALT', 'b^4Z{U#GC71}BHfsSENt=j6N~0T;W~9s?*Amt+!|;:+t^G9EPQ/$]a+I(|,h6C W' );
define( 'LOGGED_IN_SALT',   'j_B?fVlH9V{BZ!b,!E~j$Ntz]@1zVC+IHjm9~3M/-tu=oj&~1/[pJ_E)gUnd*2CL' );
define( 'NONCE_SALT',       ']zg+8QSC^=_!.8f=!@{!+$zJ,B8>U~DRUM/~>TKU8&bP:w$.1[zI [+WOY[Hea,J' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ng_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
