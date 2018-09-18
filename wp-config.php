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
define('DB_NAME', 'innova');

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
define('AUTH_KEY',         '/@wCOSSFSb3@Je7gO5r}R2Jk{pMU|zf;d#`ZeF9NDVA?MneJjs&V^lzcCv1%:wqm');
define('SECURE_AUTH_KEY',  'D}zorHajco(pQia@6ia9m5lB.@*vL]OV%miKXrtL=-8bY7hDk$VOaVsP?J_ML[N*');
define('LOGGED_IN_KEY',    'zP=!v}Vm%kHEsr?G:Ksj-2gqZ9xUNMMuj:M((M5)_~qd@0Nn.=rg()V_ X_U)v~>');
define('NONCE_KEY',        '<c~`Sa3,fgPQRC[imC2CAm&wfn;5jS;O;&0Vw,32DRe-gddV~A*^/>3YRoWTKJA8');
define('AUTH_SALT',        'x|.}}wB uLTqS-<:r=:P, Y06WkotWUcU$2YNz|?YDP.kkk@p^qts8S JA=&h4gJ');
define('SECURE_AUTH_SALT', 'F_U(-H{x!$:394jH7yz$UfJ1&+Y.|KbzSaLKf2.hUi~dK#2m-lQgEW:FT3v6~bC(');
define('LOGGED_IN_SALT',   '#RcAXu`|nTtbHu>K*sWpKraR<=zzJh|h7n^Q0%S:/Z/}_C>lWP/G-3,-mYN`G=+<');
define('NONCE_SALT',       'ah]?N>DDN>DAK2;./Gu3`s4ea:]Qmd`2=Dn34;ml0C&wFRXAer|6un2@$Dm=< k;');

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

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
