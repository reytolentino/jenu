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
define('DB_NAME', 'jenu');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '102806');

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
define('AUTH_KEY',         '^qDIUsp-;G+C&k.aLbyhXc0+|4Arw ma^~H)=-{*H Ux+hU|O7kRu+gj~VM(B`U7');
define('SECURE_AUTH_KEY',  'i/{a+fgy ,|UX+GxIGih$LFHV(mgypp@f|a6+OlQkh W)#AYU@A;o6Q(-7I055ql');
define('LOGGED_IN_KEY',    'Xi.yC/Vypxq[1-~?uddO]E}~=%EFmOXpuHs]%|w3bR~62} |j{;K(KMyJe2Mm|?V');
define('NONCE_KEY',        '+^_~nO|Z|e+Z+Fc@ZJ3shtH&1o+g*22z_9]Pzt,K4[1rFQNT7Xb]~>`Ss_X6KAWd');
define('AUTH_SALT',        '-ptf2SS0~t[3p]]J4-E@z<E#jCR3_|3^D1u?_Vi2ab&Qy;o0L+ud*cQS[-bInp)o');
define('SECURE_AUTH_SALT', '!sb (tz/jGGP:}[hdZ6)uM{;HV}fENfNU;zQcye@p{#`@C+Y. c(aH^ADfC[W- R');
define('LOGGED_IN_SALT',   'UEe4A62:l+PMM%1HK|c=+lyW-8.tSspEARl11BP!!BqT?NkVio.J2<3X*v5:uiyM');
define('NONCE_SALT',       'D7HHsP!|Qx]c*HbHptK3,T)vjI+LHp@#[,Z2=3LSx:|bRpi|rpgyP2bxT)h<;%W@');

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