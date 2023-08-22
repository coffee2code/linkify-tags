# Developer Documentation

This plugin provides a [hook](#hook) and a [template tag](#template-tag).

## Template Tag

The plugin provides one template tag for use in your theme templates, functions.php, or plugins.

### Functions

* `<?php c2c_linkify_tags( $tags, $before = '', $after = '', $between = ', ', $before_last = '', $none = '' ) ?>`
Displays links to each of any number of tags specified via tag IDs/slugs

### Arguments

* `$tags` _(string|int|array)_
A single tag ID/slug, or multiple tag IDs/slugs defined via an array, or multiple tag IDs/slugs defined via a comma-separated and/or space-separated string

* `$before` _(string)_
Optional. Text to appear before the entire tag listing (if tags exist or if 'none' setting is specified). Default is an empty string.

* `$after` _(string)_
Optional. Text to appear after the entire tag listing (if tags exist or if 'none' setting is specified). Default is an empty string.

* `$between` _(string)_
Optional. Text to appear between tags. Default is ", ".

* `$before_last` _(string)_
Optional. Text to appear between the second-to-last and last element, if not specified, 'between' value is used. Default is an empty string.

* `$none` _(string)_
Optional. Text to appear when no tags have been found. If blank, then the entire function doesn't display anything. Default is an empty string.

### Examples

These are all valid calls:

```php
<?php c2c_linkify_tags(43); ?>
<?php c2c_linkify_tags("43"); ?>
<?php c2c_linkify_tags("books"); ?>
<?php c2c_linkify_tags("43 92 102"); ?>
<?php c2c_linkify_tags("book movies programming-notes"); ?>
<?php c2c_linkify_tags("book 92 programming-notes"); ?>
<?php c2c_linkify_tags("43,92,102"); ?>
<?php c2c_linkify_tags("book,movies,programming-notes"); ?>
<?php c2c_linkify_tags("book,92,programming-notes"); ?>
<?php c2c_linkify_tags("43, 92, 102"); ?>
<?php c2c_linkify_tags("book, movies, programming-notes"); ?>
<?php c2c_linkify_tags("book, 92, programming-notes"); ?>
<?php c2c_linkify_tags(array(43,92,102)); ?>
<?php c2c_linkify_tags(array("43","92","102")); ?>
<?php c2c_linkify_tags(array("book","movies","programming-notes")); ?>
<?php c2c_linkify_tags(array("book",92,"programming-notes")); ?>
```

Though, for consistency, you'd be better off not using a mix of IDs and slugs  (with a preference for the former, especially if using hardcoded values).

* `<?php c2c_linkify_tags("43 92"); ?>`

Outputs something like:

`<a href="https://example.com/archives/tags/books">Books</a>, <a href="https://example.com/archives/tags/movies">Movies</a>`

* `<?php c2c_linkify_tags("43, 92", "<li>", "</li>", "</li><li>"); ?></ul>`

Outputs something like:

`<ul><li><a href="https://example.com/archives/tags/books">Books</a></li><li><a href="https://example.com/archives/tags/movies">Movies</a></li></ul>`

* `<?php c2c_linkify_tags(""); // Assume you passed an empty string as the first value ?>`

Displays nothing.

* `<?php c2c_linkify_tags("", "", "", "", "", "No related tags."); // Assume you passed an empty string as the first value ?>`

Outputs:

`No related tags.`


## Hook

The plugin exposes one action for hooking.

### `c2c_linkify_tags` _(action)_

The `c2c_linkify_tags` hook allows you to use an alternative approach to safely invoke `c2c_linkify_tags()` in such a way that if the plugin were to be deactivated or deleted, then your calls to the function won't cause errors in your site.

#### Arguments:

* same as for `c2c_linkify_tags()`

#### Example:

Instead of:

`<?php c2c_linkify_tags( "43, 92", 'Tags: ' ); ?>`

Do:

`<?php do_action( 'c2c_linkify_tags', "43, 92", 'Tags: ' ); ?>`
