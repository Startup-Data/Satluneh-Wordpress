<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define('WP_MEMORY_LIMIT', '256M');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress-0' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ss123456' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'M&Wu!PmGZyeJp;DRZz*tDlQ;&+>U0NMoE/TXzRb)&,}XjZ&T[5:&#2kej>W_DMt5' );
define( 'SECURE_AUTH_KEY',  '%he-f sTmCslEQ/Zdj;6$4Dy8Cho$$<#P5xGCPF@xhSj:7[irE9=%Pb&]4=d psX' );
define( 'LOGGED_IN_KEY',    'E4!-|vF#@#4NI@,=(wywT2ecuo#U:h<^GUff?qjMtcDdDmw[r;}yRKHIN+[(,|uk' );
define( 'NONCE_KEY',        'JeZ{/m.O7BgD~v*6LrMe)inru7RXWe=k7 {*f6O{jkGfBLdtgwb)~~}JccxDkL%C' );
define( 'AUTH_SALT',        '&Vf->@*9|>laJzwFW<vi!GX$pn1OwR*U]Z#l*O=K7JAi!OOKS>$eAMVSxgJ,7]OZ' );
define( 'SECURE_AUTH_SALT', '~v5cIx62c`F!^ *Edk!2[Ij41U3bnCc>p3?A4DTpx|<^Dpfe<_Wrf_j/rhg34xDr' );
define( 'LOGGED_IN_SALT',   'q `)Dk%},zC6!;9&{D+O{Wo>Rdz/.|i9g&,<3FPq{T1J?$BCC8qcuJ2xuiC6ZKM%' );
define( 'NONCE_SALT',       'Ez5Tv2Q}ss2v*~/^V@Hhp3M;V[y(wq{CM>Tf(h+Scf,I6hSdto=+|1<CUPE2{dH;' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
