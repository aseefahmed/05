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
define('DB_NAME', 'aseefahm_blog');

/** MySQL database username */
define('DB_USER', 'aseefahm_blog');

/** MySQL database password */
define('DB_PASSWORD', '1FS@rp@20K');

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
define('AUTH_KEY',         'nekkciwms0pcfipmxwbpe9txwu2y1jp9oqjxpnsutfjl69fjcbmyyr8a66rxfflk');
define('SECURE_AUTH_KEY',  'jce3wvkgm82mulsknimc56dy5pzl1czpfuhm8wwvmtheszqocm2cthhemo4huvjz');
define('LOGGED_IN_KEY',    '2fvfcix2yvstvfokx4i37zkgk7zrq8f53jqyschtlycai10tuzjwpshy68y60fnz');
define('NONCE_KEY',        'oi7hxbctw5noisveosw2losauyiaaixat0r7zlisyhdvm0dvcdcvdltoxzhgsk0n');
define('AUTH_SALT',        '6yja2zl4qe3e7ym1nkplomvyjww8cucndaxxyjm703x9it5iybf4gsditgn4lazu');
define('SECURE_AUTH_SALT', 'sytn0tb2de2gfzdcfwspuruac2ylffklui1kgo2ufhmwhgo2nko9z6goitulojnq');
define('LOGGED_IN_SALT',   'iukzxp18udhamrap8xv974jnkdcoiprrdlq1cllruqp1fzz3ffvhlogbtrqgnbdd');
define('NONCE_SALT',       'c2qrjkmaktccxr3zutipnkdthubpnbwsv0brpdcoocxreojaktsz6rxcpyw5vkr8');

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
