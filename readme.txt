=== Goule 1.0.2 ===

Theme author: lichifeng
Requires at least: 4.4.2 (Lower versions of WordPress may work fine, but they are not tested.)
Tested up to: 4.4.2
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: light, white, one-column, fluid-layout, featured-image-header, featured-images, full-width-template, sticky-post
Live Demo & Documentation: http://lichifeng.com/goule

Goule is a paper-like and responsive wordpress theme built with Bootstrap framework. It has a simple yet elegant
structure which makes it compatible with all kinds of screens.

== Description ==

Goule is a paper-like and responsive wordpress theme built with Bootstrap framework. It's designed with blog content always on the center-stage. Simple yet elegant structure gives it excellent compatibility with all kinds of screens. It comes with most basic elements a small blog site needs and nothing more. For those who complains about bloated and over-decorated web design now a days, this theme will be an answer. Goule is now delivered with English(US) and Simplified Chinese translations, more translations are welcomed.

== Frequently Asked Questions ==

= Does Goule need any configuration? =

Goule is a very simple theme and need no configuration

= What if I want to load Bootstrap stylesheets and scripts from a CDN instead of locally =

Goule is delivered with bootstrap stylesheets and scripts, but it's recommended to load these files with a public CDN. To change this, just go to functions.php under theme root directory and find definition of goule_scripts(), then replace the path to bootstrap files.

= How to add Glyphicons to navigation menus =

Goule uses wp-bootstrap-navwalker for better integration with bootstrap. Some cool functions (Glyphicons included) is provided.
To add an Icon to your link simple place the Glyphicon class name in the links Title Attribute field and the class will do the rest. IE glyphicon-bullhorn.
More details can be found here: https://github.com/twittem/wp-bootstrap-navwalker