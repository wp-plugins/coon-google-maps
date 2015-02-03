=== Plugin Name ===
Contributors: Andrico
Tags: Google, Maps, Wordpress, Shortcode
Requires at least: 3.0.1
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

You can insert google maps in your site. It's very easy to use, and you can show routes, markers.

== Description ==

You can insert google maps in your site. It's very easy to use, and you can show routes, markers.

coonprogramer.com

== Installation ==

1. Upload `coon-google-maps` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[map address="Example Address"][/map]` in your pages, posts or custom post types.

== Frequently Asked Questions ==

= How to use the plugin? =

You have to put in your editor (in pages, posts, or custom post types):
`[map centerlat='' centerlng='' width='' height=''][/map]`
`[map address='' width='' height=''][/map]`
`[map to='' from='' pancontrol='true|false' zoomcontrol='true|false' scalecontrol='true|false' zoom='10'][/map]`

= How I can put a marker? =

`[map address='XXXXX']
[marker lat='-33' lng='-66'][/marker]
[/map]`

= How I can put a marker in the center map? =

`[map address='XXXXX']
[marker lat='map' lng='map'][/marker]
[/map]`

== Changelog ==

= 1.0 =
* New Plugin!

