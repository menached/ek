<?php

/** The name of the database for WordPress */
define('DB_NAME', 'ek-construction');// Load external MySQL credentials
$envPath = '/mnt/data/envs/.env.mysql';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) {
            continue;
        }
        list($key, $value) = array_map('trim', explode('=', $line, 2));
        $value = trim($value, '"');
        putenv("$key=$value");
    }
}


define('DB_USER', getenv('MYSQL_USER'));
define('DB_PASSWORD', getenv('MYSQL_PASS'));
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');


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

define('AUTH_KEY', 'KxYJsrVb5VB&-So^q4^v3F `EjY >-`oe9/,}wslZ$x#^DOf<vk8.s<Zlo|8VLwn');
define('SECURE_AUTH_KEY', 'o)O!kU~DOK-S10&(&=cx:y(|YQlRL`sA`*`TB,}D)T,&VRGT3KLDQ2{.w]er[ %X');
define('LOGGED_IN_KEY', '%^MH?9azt3lmkrqc7**Bn~p=UXr,Tz2>CX<Sx=hgLdv#~dcZ[-}}X?g-Q7+EZ((i');
define('NONCE_KEY', '6Vfi{$bqj,.`*wo|}},b{uz=wuq1IJQKS<W){:Xv~X}Vxld?Kt[!ilVEI0u#Z+wz');
define('AUTH_SALT', '6r3tT6+]K,csl(nsE0Z}q0UL=*,V?v6+b]+!6{ZoV^o*rTUCFD0x@DTdr)U2Zo.e');
define('SECURE_AUTH_SALT', 'I$Mn-DN1+{%e,ol=|),ycPJE5Tw|SIBGcLo>SNm9v:F!?kKHX_<~9evFDzNE$NE0');
define('LOGGED_IN_SALT', 'PH&X0(B:%&B>E<.S+:31go~%0.*-lI4|{{MwL*9x[fb`2${HZV]IoM$Im.IE,V8T');
define('NONCE_SALT', 'm-0iq/FG|X9|K!7?+PM:WdgXY3>_a=HvdwQ+JSL}fhtN0Ra3X[`I:]e=}~=V3w+G');

$table_prefix = 'wp_';

define('WP_DEBUG', false);

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
