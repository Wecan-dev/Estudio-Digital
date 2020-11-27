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
define( 'DB_NAME', 'db_estudio-digital' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', '123456' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'k]QJaH;RUZD0%FM2HtKKixGD(#{|T;dK74 OJ<*VOGvMjdLtsx]dp>Q`c[|NsL^5' );
define( 'SECURE_AUTH_KEY',  '^yXEFL^:qjUj!yNl&C]t+>bVP_hGe+r$R_R,ZCl`?`V]A:3ir5jE8*rn.o4&im_4' );
define( 'LOGGED_IN_KEY',    'xvL~ok`ghBZhk{V$W:Uo885E W7H?T6Hc./[$*]ZAb.,ly+*pg;Tp4mr/!70,>,.' );
define( 'NONCE_KEY',        'Dx<)ylZ]igU<.>Q}[xN^+O,]eWRK1?q,AD+jlO2`(cTiHrQaH)a*aI<m*&2sP4]}' );
define( 'AUTH_SALT',        'sP+S$*g$|(yXA048mDL_7gjne8F@M[K+e)ro;{s+rfF9u-RgGMkeik:nY3jYS]i2' );
define( 'SECURE_AUTH_SALT', 'KdV+dSHgBEXSa}2DXAyy?cLq~5z#GMy?VP$_JFdS,ER{q_}FG{pquR5MC:)ga02K' );
define( 'LOGGED_IN_SALT',   '9REyJr&ARF:zxb+L6vbHA2{huPHc,# jyD<r{#9AO58>&lNG(_4QHYXRhR9aSE_+' );
define( 'NONCE_SALT',       '}8RfA2u`B(571Em9Cjm,rNeEo2j*:^Cf{:9+ap n!ygf@>TUZv*|}6^S0#?9M5qd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
