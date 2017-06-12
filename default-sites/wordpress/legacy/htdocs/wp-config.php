<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'legacy.wordpress.pv' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY', 'IXdGaF8o%W;w5,Me?>?Z,W-<C0U;,r}mDAG<aTUdA{v3,MtzSn-6.<G`p=5HYrbz' );
define( 'SECURE_AUTH_KEY', '+?Rv`G*7fyxpd>-VfMb2sQoi-xG>{ie^8oEb8-Y(;>;qIOXkw@LUU4PUr7bd+6?>' );
define( 'LOGGED_IN_KEY', 'ul>#s*F}/AF|+ .X=~E|r<}O6=I[1 5|v.Lde<|;xD|[Rum.u.~UP[9 +M;+c-->' );
define( 'NONCE_KEY', '<d^G*J8_[AMzbZ%8&*eKc3l=Hq}(<Lp@Xqbgbx {p{`Q+(qWub&dJbYyUM`wf|ja' );
define( 'AUTH_SALT', 'VKEv0<%v}Zb}8[K>4u^`+z U?tw_4K&X<H21!@]CG-.gIX~F8QNZ!<e!DvZ{<c.N' );
define( 'SECURE_AUTH_SALT', ';7+`jQ-Qz{2x+)EN*?=O}$eXBt-V-b72|xXxX0I2f?YaXs~(iHt3_]G`}piBHly.' );
define( 'LOGGED_IN_SALT', '9@n~:utmG/4/4@mGs,<.]~k~l4Grgesi@_sMR)-RR,-[u<Mp$&+85j8}8O%+K>M5' );
define( 'NONCE_SALT', 'Cg5C8xg){3t%Y-_Fw(/7;-@?Ui|QO|:LVJPk1.WG_sy3&5FY=P_(&WHM4GfPj!xB' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
define( 'WP_LOCAL_DEV', true );
define( 'JETPACK_DEV_DEBUG', true );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'WP_CONTENT_DIR', '/var/www/default-sites/wordpress/content' );
define( 'WP_CONTENT_URL', 'http://legacy.wordpress.pv/content' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
