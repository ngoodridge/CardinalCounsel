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
define( 'DB_NAME', 'wordpress-db' );

/** MySQL database username */
define( 'DB_USER', 'BarkersBoys' );

/** MySQL database password */
define( 'DB_PASSWORD', 'BarkersBoys420' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// Define site URL
define( 'WP_HOME', 'http://cardinalcounsel.net' );
define( 'WP_SITEURL', 'http://cardinalcounsel.net' );

// Increase memory limit
define( 'WP_MEMORY_LIMIT', '1000M' );

//define('WP_ALLOW_REPAIR', true);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'og;UCQrM@u-h1&U;1DN&d+lRKM9`MjQn9}KlSg-toC|5E&-opD;hPnQ}}`+95vmq');
define('SECURE_AUTH_KEY',  'EY-M.omc (yxln*_)MF{xp%]wM=zlLA`o=EIh+zh@s6 vV~<&.Bo(tRdmEe64EuO');
define('LOGGED_IN_KEY',    ';3(q-3V GjDL0(A^uYY-Xo4+H^l.gVo|jyUY_Nfl8,sqvs=Yq{A:wC;K@Y+|6m8@');
define('NONCE_KEY',        'NR0YzRT+gT`)XM!cE+v2$pZ`aQ-B[4d*NO-DJT_8iRdj/cW.a#u1Beg3dYi&abAk');
define('AUTH_SALT',        '1@8lLqlPetpu0*1(A:vi}V7^D^|FeQ<3}AvT~ie6u6HXUpHIUmnz+^V}Xj?u/{Uw');
define('SECURE_AUTH_SALT', '%&Q2*NiY+NqKXmOe1q$Y8VbiI=1+>O9N,&L_bho%^+Xp|-o4DQ9(<N[efWYG0e|z');
define('LOGGED_IN_SALT',   'mz)j|w)QU]+YkL*)v3 yR#*DTJv4|*{c`nTFMd*do0watkBt9:y*Vav~p}F@,gEN');
define('NONCE_SALT',       '<UYR41`,:W[F;R5S|^.ts/mJit[xt3|73Hn?r,ee/Sq1H?@>%l6rEi*${Ea6IRm)');

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
