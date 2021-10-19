<?php
define( 'WP_CACHE', true /* Modified by NitroPack */ );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'new-restires' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'v6neZ_1{@T AB=e]AGT:AfEG&G0joPf^`}m1`AUBJb>,ZRw3lU&DDguu7Ne#YQID' );
define( 'SECURE_AUTH_KEY',  ';zanvoeh0Rg7-rSVl~Fy^ T[Np^,;!/9h]tok_W`?<KJ{u9+vYxt]t1@ MxxW,~C' );
define( 'LOGGED_IN_KEY',    '5}Cs>Sn>VixvCp[8@!$@8j~c9_pahFU}2%.`Sn[OGG> KB9QS>vm3vu8<~gPux!K' );
define( 'NONCE_KEY',        'W7|q4CC0u~hc+OHWx@xe$g$siAo@WQPgUzFu1A-b]slHZO)-#3C//7crC>8@&=h&' );
define( 'AUTH_SALT',        ':d;0S5(RC8aLcH`UJi[TZ[)IhHj`%/wU[#/bQ+P4o>Jtm,kSja6/{.,;<}?wG<:Z' );
define( 'SECURE_AUTH_SALT', '=PKP$B4 igL3PpUzw%62P*e?ca7b59-MMX<Uc|Y .:mjC9rH/T%#!Drk{dx<N;!1' );
define( 'LOGGED_IN_SALT',   '!qHf}?XnAs^bSsc{D4x)i;bOrY^,HX3`,GSh32Da^6tt2lw%je!#qDjfyEeIXiD)' );
define( 'NONCE_SALT',       '*Okttn$l+`)vLIHt_IvVyXR48@xMhPS_x,3A(9{Y?Np|0$[<k~I0OPyx&*P^;=(y' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
