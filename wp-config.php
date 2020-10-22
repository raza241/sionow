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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sionow' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'B@.w7l7^]?tx7gpBc78r@D~[g ^Eu(j6x6%V~`vCaH1=dg9s^3ZAh~d@l9}q>*O^' );
define( 'SECURE_AUTH_KEY',  'pi0i.EcVPai1uV+t;p$.BJYq}APN:a4Q?83-_/9wla^$U>t=lqG`MHha:J1,y;=u' );
define( 'LOGGED_IN_KEY',    '0$O-#%8F kN6zz-7{!,dIIa}f(wnJ!t>Y;6gIg;4{THJM(]R!eJ!=vmJno/ETGa7' );
define( 'NONCE_KEY',        '(`.9UIe]oaL+q%Tf4pK|Xv-Q~:B`bl[)FgBIJje&zIWFY]w$1Vfd5X93l`{;vxVc' );
define( 'AUTH_SALT',        'm.IxiJ_eiI:@2 pGeY8Ei<kX+&ThPj|jDE<rVRxgVf`O.obcD}|WYk6bNpSqK=)o' );
define( 'SECURE_AUTH_SALT', '$h@W(46i?Rvmg_k;9u;OoHE7|]:%NicdB7<4bnX{]kXe@Q7:PAm<$Oe-WD)*B/@=' );
define( 'LOGGED_IN_SALT',   '/+>nqLX3{@WA %k?4u2HF_V`wJ~l!BBHjxGJ%PyQVd^+(0bymX#WiAh Ek]]~Q-H' );
define( 'NONCE_SALT',       '4)Cmi}2Mg>iJ.b~E#uH;yYcZSA<g+^r[37|rE+c~xjx|g:){P kJ^5r?XHp`z`r=' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
