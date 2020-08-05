=== ACF-VC Integrator ===
Contributors: nordiccustommade, Frederik Rosendahl-Kaa
Tags: ACF, Visual Composer, VC, Advanced Custom Fields, Page builder, WPBakery Page Builder, WPBakery
Requires at least: 3.4
Tested up to: 4.9.4
Stable tag: 1.2.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

The ACF-VC Plugin puts a ACF element into your WPBakery Page Builder (Visual Composer), making it easier than ever to use your custom created fields in your own page design.

== Description ==

Advanced Custom Fields right inside your WPBakery Page Builder (Visual Composer)

The ACF-VC Plugin puts a ACF element into your WPBakery Page Builder (Visual Composer), making it easier than ever to use your custom created fields in your own page design.

All standard Advanced Custom Fields are supported, and easy to target with your own CSS classes for ultimative design possibilities.

Signup for a download and newsletter on [ACF-VC.com](http://ACF-VC.com) to get news about future releases.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/acf-vc-integrator directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. The plugin requires no configuration on itself, but requires Advanced Custom Fields AND Visual Composer plugins to be active.


== Frequently Asked Questions ==

__Does ACF-VC Integrator work with ACF-Pro ?__
No, the fields of the ACF Pro version is not supported EXCEPT the repeater field.


== Changelog ==
= 1.2.4 =
Bug fixes:
* Updated Freemius WordPress SDK: https://wordpress.org/support/topic/fopen-error-after-moving-site-or-changing-web-root-path/

= 1.2.3 =
Bug fixes:
* Caused HTTP 500 error when WPBakery Page Builder is disabled

= 1.2.2 =
Bug fixes:
* Not Working with WPBakery Version 5.4.6: https://wordpress.org/support/topic/not-working-with-wpbakery-version-5-4-6/

= 1.2.1 =
Bug fixes:
* Not working with VC 5.4.5: https://wordpress.org/support/topic/not-working-with-vc-5-4-5/

= 1.2 =
New stuff
* Support for Templatera
* Freemius integration
* Hide label if there is no data
* Added support of Radio button, Multiple select, date picker, text area, number, email, WYSIWYG, oEmbed field
* Updated some outdated features
* Added support for Repeater within Repeater within Repeater
* Changed repeater from using table to use div
* Moved acf-vc admin page under the Settings menu: https://wordpress.org/support/topic/it-would-be-good-if-the-admin-menu-item-could-be-moved/
Bug fixes:
* Minor bugs and warnings
* Relationship Post ID as return format: https://wordpress.org/support/topic/not-working-trying-to-get-property-of-non-object/
* foreach warning
* has_cap warning: https://wordpress.org/support/topic/has_cap-is-deprecated-since-version-2-0-0/

= 1.1 =
New stuff
* Support for the repeater field. Supporting ACF-Pro and the standalone repeater plugin
* Supports multiple select
* New and improved core structure to support reuse of functions for repeaterfields.

Bug fixes:
* Error when no taxonomy was selected
* ACF Pro check for plugin
* Error message if ACF or ACF-pro is missing
* Logo Icon was gone on the VC element

= 1.0 =
* First version of the plugin supporting ACF version 4.4.5 and Visual Composer version 4.8.0.1
