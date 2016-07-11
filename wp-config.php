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
define('DB_NAME', 'blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Ru$UpU*i`$DP>YC?blGjN6GnZvBKf8&=f(HEPto4)59KBFYvZ^Iml7}:s^*=0cI>');
define('SECURE_AUTH_KEY',  'ToLC0^2jJX8gYNViqHZHK,MEHQG+w&,!IJuYd1`@>=t>/po@q|Y#qAE*57*Wl4h:');
define('LOGGED_IN_KEY',    's^@zq.~Fb<Sb7CfyJ:Fz$Ipc$MWE~[LX-ZG>ssR}rD=Beq_YQ8!MIZS8#+ZfZ >b');
define('NONCE_KEY',        'pWki*WiA0:=g<:VRr#KIZyHKpk3*w}p%-.RSw$K=!5eX<Rk[+%RqkAnhwJeFq=@J');
define('AUTH_SALT',        '=/La33Op5.vp][^3>Xl Z/*@^<O.G`2jX[IfJ#Gr?h>s;L%ozH83}t+v%7o_Tkes');
define('SECURE_AUTH_SALT', ':70vJUpJ>lN++9s;^Z(NrB,GsaZdC#Fpm.aq&#[jm>r,0.<61!-*gA0Qj|x4uhG!');
define('LOGGED_IN_SALT',   'dRtk>wX0,Sh]k<9$L?l3/_EkdJ7C;7@wKMw+g!,AzyLy*x`4R,68rUaKiRub{bP+');
define('NONCE_SALT',       'M$we<Pvm[Q ^zsnS5di0eQ/BLzc<8U) p8ixcQT^jTKf9.mf%o%{>n3ssv#gILgM');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'blog_';

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
