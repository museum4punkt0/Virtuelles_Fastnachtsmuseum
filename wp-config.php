<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Zu diesen Einstellungen gehören:
 *
 * * MySQL-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * Mehr Informationen zur wp-config.php gibt es auf der
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Zugangsdaten für die MySQL-Datenbank
 * bekommst du von deinem Webhoster.
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als wp-config.php mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * @package WordPress
 */

// ** MySQL-Einstellungen ** //
/**   Diese Zugangsdaten bekommst du von deinem Webhoster. **/

/**
 * Ersetze datenbankname_hier_einfuegen
 * mit dem Namen der Datenbank, die du verwenden möchtest.
 */
define('DB_NAME', 'd02adf83');

/**
 * Ersetze benutzername_hier_einfuegen
 * mit deinem MySQL-Datenbank-Benutzernamen.
 */
define('DB_USER', 'd02adf83');

/**
 * Ersetze passwort_hier_einfuegen mit deinem MySQL-Passwort.
 */
define('DB_PASSWORD', 'KdXrduYPSAbAN9N6');

/**
 * Ersetze localhost mit der MySQL-Serveradresse.
 */
define('DB_HOST', 'localhost');

/**
 * Der Datenbankzeichensatz, der beim Erstellen der
 * Datenbanktabellen verwendet werden soll
 */
define('DB_CHARSET', 'utf8');

/**
 * Der Collate-Type sollte nicht geändert werden.
 */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
 define('AUTH_KEY',         '@(Ehx2r7YFl6J%9Q=d,`~$|;#pj*<g)RCYE5+qmjkj@;ZC@h;,V6t-D5!g1Zq?Y[');
 define('SECURE_AUTH_KEY',  'szzD:/+4A{_]a(NCl5GBK!tYvY XknYKhDcuLqMDKHbipQ1iixJqHKdyCMBRZ**Q');
 define('LOGGED_IN_KEY',    'IgkxmRp5IGp~:9r3@4eXJVYd9Op1fe`d@^|{sYc.s;E:AAu(_w&Nu@2@(yQ+a!iS');
 define('NONCE_KEY',        'D?Je>}IoWLD|G}!C)/Ej(! *~;Ts+^~f@Pw3I.N}9<I1;lphpsgyhu%I h,m92Q4');
 define('AUTH_SALT',        '~NW)RNqg-o`Rw_nO%STN%Bt]nJ#?y`dR9J<su.SG=.g0-xAc>`b&ag?}wpQ4X7Y5');
 define('SECURE_AUTH_SALT', 'mDI|BVi.!1vK qi.(u 1@|a& IxT=Ko.qf>W%gJ;e2;P8Lbzm7A2t`Ok62=3WL<+');
 define('LOGGED_IN_SALT',   'n_b6l ]:eEZ=e+CqlN#8:5q|3M~FpWLK]3m-4kO264Y:c:fTWY:gSQ`1|[l6O|+w');
 define('NONCE_SALT',       'io|PDruyN#~%IkAH!ux?!)p!(d+t|,^!>p|;|z*EW%A:3>[bxjV2g;9QM{k]ZKhK');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix  = 'wp_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */
/* That's all, stop editing! Happy blogging. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once(ABSPATH . 'wp-settings.php');
