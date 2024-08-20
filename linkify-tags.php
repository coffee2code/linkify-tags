<?php
/**
 * Plugin Name: Linkify Tags
 * Version:     2.4
 * Plugin URI:  https://coffee2code.com/wp-plugins/linkify-tags/
 * Author:      Scott Reilly
 * Author URI:  https://coffee2code.com/
 * Text Domain: linkify-tags
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Turn a string, list, or array of tag IDs and/or slugs into a list of links to those tag archives. Provides a widget and template tag.
 *
 * Compatible with WordPress 3.3 through 6.6+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/linkify-tags/
 *
 * @package Linkify_Tags
 * @author  Scott Reilly
 * @version 2.4
 */

/*
	Copyright (c) 2009-2024 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'linkify-tags.widget.php' );

if ( ! function_exists( 'c2c_linkify_tags' ) ) :
/**
 * Displays links to each of any number of tags specified via tag IDs and/or slugs
 *
 * @since 2.0
 *
 * @param int|string|array $tags A single tag ID/slug, or multiple tag IDs/slugs defined via an array, or multiple tag IDs/slugs defined
 *                               via a comma-separated and/or space-separated string.
 * @param string $before         Optional. Text to appear before the entire tag listing (if tags exist or if 'none' setting is specified). Default empty string.
 * @param string $after          Optional. Text to appear after the entire tag listing (if tags exist or if 'none' setting is specified). Default empty string.
 * @param string $between        Optional. Text to appear between all tags. Default ', '.
 * @param string $before_last    Optional. Text to appear between the second-to-last and last element, if not specified, 'between' value is used. Default empty string.
 * @param string $none           Optional. Text to appear when no tags have been found.  If blank, then the entire function doesn't display anything. Default empty string.
 */
function c2c_linkify_tags( $tags, $before = '', $after = '', $between = ', ', $before_last = '', $none = '' ) {
	if ( empty( $tags ) ) {
		$tags = array();
	} elseif ( ! is_array( $tags ) ) {
		$tags = explode( ',', str_replace( array( ', ', ' ', ',' ), ',', $tags ) );
	}

	if ( empty( $tags ) ) {
		$response = '';
	} else {
		$links = array();
		foreach ( $tags as $id ) {
			if ( 0 == (int) $id ) {
				if ( ! is_string( $id ) ) {
					continue;
				}
				$tag = get_term_by( 'slug', $id, 'post_tag' );
				if ( $tag ) {
					$id = $tag->term_id;
				}
			} else {
				$tag = get_term( $id, 'post_tag' );
			}
			if ( ! $tag ) {
				continue;
			}

			$link = __c2c_linkify_tags_get_tag_link( $id );
			if ( $link ) {
				$links[] = $link;
			}
		}
		if ( empty( $before_last ) ) {
			$response = implode( $between, $links );
		} else {
			switch ( $size = sizeof( $links ) ) {
				case 1:
					$response = $links[0];
					break;
				case 2:
					$response = $links[0] . $before_last . $links[1];
					break;
				default:
					$response = implode( $between, array_slice( $links, 0, $size-1 ) ) . $before_last . $links[ $size-1 ];
			}
		}
	}
	if ( empty( $response ) ) {
		if ( empty( $none ) ) {
			return;
		}
		$response = $none;
	}

	// Output categories (which is permitted to include markup).
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $before . $response . $after;
}
add_action( 'c2c_linkify_tags', 'c2c_linkify_tags', 10, 6 );
endif;

/**
 * Returns the archive link for a tag.
 *
 * @access private
 *
 * @param int $tag_id The tag ID.
 * @return string
 */
function __c2c_linkify_tags_get_tag_link( $tag_id ) {
	$tag = get_tag( $tag_id );
	$title = '';

	if ( is_object( $tag ) ) {
		$title = $tag->name;
	}

	if ( ! $title ) {
		return '';
	}

	return sprintf(
		'<a href="%1$s" title="%2$s">%3$s</a>',
		esc_url( get_tag_link( $tag_id ) ),
		/* translators: %s: Tag's name */
		esc_attr( sprintf( __( "View all posts in %s", 'linkify-tags' ), $title ) ),
		esc_attr( $title )
	);
}
