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
define('DB_NAME', 'inf1606009071341');

/** MySQL database username */
define('DB_USER', 'inf1606009071341');

/** MySQL database password */
define('DB_PASSWORD', 't0W%0xBh');

/** MySQL hostname */
define('DB_HOST', 'inf1606009071341.db.2265381.hostedresource.com');

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
define('AUTH_KEY',         'Ca!cX9q2R%Bx8/IMZFE&');
define('SECURE_AUTH_KEY',  'D)4arfvP=46RUTzH@gSa');
define('LOGGED_IN_KEY',    '#hCT_+W1*gP=)8tfYqh-');
define('NONCE_KEY',        '$OK=#2ZK3@V7WDpAIRL6');
define('AUTH_SALT',        'Vz1FqZcz/E_wBwh8EZOv');
define('SECURE_AUTH_SALT', 'hrNk$#f097%GXXc@YaEF');
define('LOGGED_IN_SALT',   'MOIqr8LtJY-!+QMFVkH_');
define('NONCE_SALT',       '+z+vp%+gFAG9R6HRc%6L');

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
