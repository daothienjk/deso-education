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
define('DB_NAME', 'deso-education');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

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
define('AUTH_KEY',         'ff*PHC}J?Pu}(8a^$wl51tm=y_ajL$W6?0%S8pmFG8r7k}i#fR#r0ru[/BT@ikA`');
define('SECURE_AUTH_KEY',  'o@=$V8vsTxY=(_}ZDd@o&jK*(aOocEw`WLq5,+F9I`a~oYO9!,l2j~Y{,-&,)m?P');
define('LOGGED_IN_KEY',    'pWC6:/{l9rH4.K-G_N[u?:QqE{0cS~C1G+z7RA9q/~;;68=Wn^#$%<35:R0>lZ j');
define('NONCE_KEY',        'E+;{tBc7bZ,-.@o9:y$cWocJB*h]h-8%!9ecr eSH<ArVA=+Jd2qI7phj6I]&kd)');
define('AUTH_SALT',        'K9}MER.WPQg#,a)xQ5dD ^Uu%/$${E_M?lLz~%k)V,WM9J0j,mfsvGpay5/i6#nP');
define('SECURE_AUTH_SALT', 'w9l`iO/#ZE%vd1%Vsr>OFqslR*O-?e/rj=lA|egoyPiH1WD_JO?EA5=JfAy8#T(,');
define('LOGGED_IN_SALT',   ';$tLcJy`!5sC@npU_7PIE2 P{Xu49(?dqpd/5GNXq.x9tD?!YK|F]Hg,p.c(nXXd');
define('NONCE_SALT',       '+BrF@.x/@?fzv(4:YHYs&LT6q=Qn/C6E/i/t+_E{C=M*Z5,3nG5CChVGh)S8_x{N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ds_';

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
