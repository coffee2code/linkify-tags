# Changelog

## _(in-progress)_
* New: Add CHANGELOG.md and move all but most recent changelog entries into it
* Change: Update unit test install script and bootstrap to use latest WP unit test repo
* Change: Note compatibility through WP 5.3+
* Change: Add link to plugin's page in Plugin Directory to README.md
* Change: Update copyright date (2020)
* Change: Split paragraph in README.md's "Support" section into two

## 2.2.2 _(2019-02-03)_
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

## 2.2.1 _(2017-02-27)_
* Fix: Bug fixes for unit tests
    * Don't declaring test class variable as static
    * Remove iteration of nonexistent variable
* Change: Update unit test bootstrap
    * Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable
    * Enable more error output for unit tests
* Change: Note compatibility through WP 4.7+
* Change: Minor readme.txt content and formatting tweaks
* Change: Update copyright date (2017)

## 2.2 _(2016-03-14)_
* Change: Update widget to 004:
    * Add `register_widget()` and change to calling it when hooking 'admin_init'.
    * Add `version()` to return the widget's version.
    * Reformat config array.
    * Discontinue use of old-style constructor.
    * Add inline docs for class variables.
    * Late-escape attribute values.
    * Reorder some conditional expressions.
* Change: Explicitly declare methods in unit tests as public or protected.
* Change: Fix and simplify unit tests. Add tests for widget.
* New: Add 'Text Domain' to plugin header.
* New: Add LICENSE file.
* New: Add empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Use `DIRECTORY_SEPARATOR` in place of '/' when requiring widget file.
* Change: Note compatibility through WP 4.4+.
* Change: Update copyright date (2016).

## 2.1.3 _(2015-08-12)_
* Update: Discontinue use of PHP4-style constructor invocation of WP_Widget to prevent PHP notices in PHP7
* Update: Minor widget header reformatting
* Update: Minor widget file code tweaks (spacing, bracing)
* Update: Minor inline document tweaks (spacing)
* Note compatibility through WP 4.3+

## 2.1.2 _(2015-02-11)_
* Note compatibility through WP 4.1+
* Update copyright date (2015)

## 2.1.1 _(2014-08-26)_
* Minor plugin header reformatting
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

## 2.1 _(2013-12-20)_
* Validate tag is either int or string before handling
* Add unit tests
* Minor code tweaks (spacing, bracing)
* Minor documentation tweaks
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Change donate link
* Add banner

## 2.0.4
* Add check to prevent execution of code if file is directly accessed
* Note compatibility through WP 3.5+
* Update copyright date (2013)
* Create repo's WP.org assets directory
* Move screenshot into repo's assets directory

## 2.0.3
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

## 2.0.2
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 2.0.1
* Note compatibility through WP 3.2+
* Minor code formatting changes (spacing)
* Fix plugin homepage and author links in description in readme.txt

## 2.0
* Add Linkify Tags widget
* Rename `linkify_tags()` to `c2c_linkify_tags()` (but maintain a deprecated version for backwards compatibility)
* Rename `linkify_tags` action to `c2c_linkify_tags` (but maintain support for backwards compatibility)
* Add Template Tag, Screenshots, and Frequently Asked Questions sections to readme.txt
* Add screenshot of widget admin
* Changed Description in readme.txt
* Note compatibility through WP 3.1+
* Update copyright date (2011)

## 1.2
* Add filter `linkify_tags` to respond to the function of the same name so that users can use the `do_action()` notation for invoking template tags
* Fix to prevent PHP notice
* Wrap function in `if(!function_exists())` check
* Reverse order of `implode()` arguments
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Note compatibility with WP 3.0+
* Minor tweaks to code formatting (spacing)
* Add Upgrade Notice section to readme.txt
* Remove trailing whitespace

## 1.1
* Add PHPDoc documentation
* Add title attribute to link for each tag
* Minor formatting tweaks
* Note compatibility with WP 2.9+
* Drop compatibility with WP older than 2.8
* Update copyright date
* Update readme.txt (including adding Changelog)

## 1.0
* Initial release
