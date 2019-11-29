=== Linkify Tags ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: tags, link, linkify, archives, list, widget, template tag, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.3
Tested up to: 5.1
Stable tag: 2.2.2

Turn a string, list, or array of tag IDs and/or slugs into a list of links to those tags. Provides a widget and template tag.

== Description ==

The plugin provides a widget called "Linkify Tags" as well as a template tag, `c2c_linkify_tags()`, which allow you to easily specify tags to list and how to list them. Tags are specified by either ID or slug. See other parts of the documentation for example usage and capabilities.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/linkify-tags/) | [Plugin Directory Page](https://wordpress.org/plugins/linkify-tags/) | [GitHub](https://github.com/coffee2code/linkify-tags/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `linkify-tags.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Optional: Use the `c2c_linkify_tags()` template tag in one of your templates (be sure to pass it at least the first argument indicating what tag IDs and/or slugs to linkify -- the argument can be an array, a space-separate list, or a comma-separated list). Other optional arguments are available to customize the output.
4. Optional: Use the "Linkify Tags" widget in one of the sidebars provided by your theme.


== Screenshots ==

1. The plugin's widget configuration.


== Frequently Asked Questions ==

= What happens if I tell it to list something that I have mistyped, haven't created yet, or have deleted? =

If a given ID/slug doesn't match up with an existing tag then that item is ignored without error.

= How do I get items to appear as a list (using HTML tags)? =

Whether you use the template tag or the widget, specify the following information for the appropriate fields/arguments:

Before text: `<ul><li>` (or `<ol><li>`)
After text: `</li></ul>` (or `</li></ol>`)
Between tags: `</li><li>`

= Does this plugin include unit tests? =

Yes.


== Template Tags ==

The plugin provides one template tag for use in your theme templates, functions.php, or plugins.

= Functions =

* `<?php c2c_linkify_tags( $tags, $before = '', $after = '', $between = ', ', $before_last = '', $none = '' ) ?>`
Displays links to each of any number of tags specified via tag IDs/slugs

= Arguments =

* `$tags`
A single tag ID/slug, or multiple tag IDs/slugs defined via an array, or multiple tags IDs/slugs defined via a comma-separated and/or space-separated string

* `$before`
(optional) To appear before the entire tag listing (if tags exist or if 'none' setting is specified)

* `$after`
(optional) To appear after the entire tag listing (if tags exist or if 'none' setting is specified)

* `$between`
(optional) To appear between tags

* `$before_last`
(optional) To appear between the second-to-last and last element, if not specified, 'between' value is used

* `$none`
(optional) To appear when no tags have been found. If blank, then the entire function doesn't display anything

= Examples =

* These are all valid calls:

`<?php c2c_linkify_tags(43); ?>`
`<?php c2c_linkify_tags("43"); ?>`
`<?php c2c_linkify_tags("books"); ?>`
`<?php c2c_linkify_tags("43 92 102"); ?>`
`<?php c2c_linkify_tags("book movies programming-notes"); ?>`
`<?php c2c_linkify_tags("book 92 programming-notes"); ?>`
`<?php c2c_linkify_tags("43,92,102"); ?>`
`<?php c2c_linkify_tags("book,movies,programming-notes"); ?>`
`<?php c2c_linkify_tags("book,92,programming-notes"); ?>`
`<?php c2c_linkify_tags("43, 92, 102"); ?>`
`<?php c2c_linkify_tags("book, movies, programming-notes"); ?>`
`<?php c2c_linkify_tags("book, 92, programming-notes"); ?>`
`<?php c2c_linkify_tags(array(43,92,102)); ?>`
`<?php c2c_linkify_tags(array("43","92","102")); ?>`
`<?php c2c_linkify_tags(array("book","movies","programming-notes")); ?>`
`<?php c2c_linkify_tags(array("book",92,"programming-notes")); ?>`


* `<?php c2c_linkify_tags("43 92"); ?>`

Outputs something like:

`<a href="http://yourblog.com/archives/tags/books">Books</a>, <a href="http://yourblog.com/archives/tags/movies">Movies</a>`

* `<?php c2c_linkify_tags("43, 92", "<li>", "</li>", "</li><li>"); ?></ul>`

Outputs something like:

`<ul><li><a href="http://yourblog.com/archives/tags/books">Books</a></li><li><a href="http://yourblog.com/archives/tags/movies">Movies</a></li></ul>`

* `<?php c2c_linkify_tags(""); // Assume you passed an empty string as the first value ?>`

Displays nothing.

* `<?php c2c_linkify_tags("", "", "", "", "", "No related tags."); // Assume you passed an empty string as the first value ?>`

Outputs:

`No related tags.`


== Hooks ==

The plugin exposes one action for hooking.

**c2c_linkify_tags (action)**

The 'c2c_linkify_tags' hook allows you to use an alternative approach to safely invoke `c2c_linkify_tags()` in such a way that if the plugin were to be deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_linkify_tags()`

Example:

Instead of:

`<?php c2c_linkify_tags( "43, 92", 'Tags: ' ); ?>`

Do:

`<?php do_action( 'c2c_linkify_tags', "43, 92", 'Tags: ' ); ?>`


== Changelog ==

= 2.2.2 (2019-02-03) =
* New: Add README.md
* Change: Escape text used in markup attributes (hardening)
* Change: Add GitHub link to readme
* Change: Unit tests: Minor whitespace tweaks to bootstrap
* Change: Rename readme.txt section from 'Filters' to 'Hooks'
* Change: Modify formatting of hook name in readme to prevent being uppercased when shown in the Plugin Directory
* Change: Note compatibility through WP 5.1+
* Change: Update copyright date (2019)
* Change: Tweak plugin description
* Change: Update License URI to be HTTPS

= 2.2.1 (2017-02-27) =
* Fix: Bug fixes for unit tests
    * Don't declaring test class variable as static
    * Remove iteration of nonexistent variable
* Change: Update unit test bootstrap
    * Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable
    * Enable more error output for unit tests
* Change: Note compatibility through WP 4.7+
* Change: Minor readme.txt content and formatting tweaks
* Change: Update copyright date (2017)

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/linkify-tags/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 2.2.2 =
Trivial update: minor hardening, noted compatibility through WP 5.1+, and updated copyright date (2019)

= 2.2.1 =
Trivial update: fixed some unit tests, noted compatibility through WP 4.7+, updated copyright date

= 2.2 =
Minor update: minor updates to widget code and unit tests; verified compatibility through WP 4.4; updated copyright date (2016).

= 2.1.3 =
Bugfix update: Prevented PHP notice under PHP7+ for widget; noted compatibility through WP 4.3+

= 2.1.2 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date

= 2.1.1 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

= 2.1 =
Moderate update: better validate data received; added unit tests; noted compatibility through WP 3.8+

= 2.0.4 =
Trivial update: noted compatibility through WP 3.5+

= 2.0.3 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 2.0.2 =
Trivial update: noted compatibility through WP 3.3+ and minor readme.txt tweaks

= 2.0.1 =
Trivial update: noted compatibility through WP 3.2+ and minor code formatting changes (spacing)

= 2.0 =
Feature update: added widget, deprecated `linkify_tags()` in favor of `c2c_linkify_tags()`, renamed action from 'linkify_tags' to 'c2c_linkify_tags', added Template Tags, Screenshots, and FAQ sections to readme, noted compatibility with WP 3.1+, and updated copyright date (2011).

= 1.2 =
Minor update. Highlights: added filter to allow alternative safe invocation of function; verified WP 3.0 compatibility.
