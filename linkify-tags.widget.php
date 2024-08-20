<?php
/**
 * Linkify Tags plugin widget code
 *
 * Copyright (c) 2011-2024 by Scott Reilly (aka coffee2code)
 *
 * @package Linkify_Tags_Widget
 * @author  Scott Reilly
 * @version 005
 */

defined( 'ABSPATH' ) or die();

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'linkify-widget.php' );

if ( class_exists( 'WP_Widget' ) && ! class_exists( 'c2c_LinkifyTagsWidget' ) ) :

class c2c_LinkifyTagsWidget extends c2c_LinkifyWidget {

	/**
	 * Returns the version of the widget.
	 *
	 * @since 004
	 */
	public static function version() {
		return '005';
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		$config = array(
			// input can be 'checkbox', 'multiselect', 'select', 'short_text', 'text', 'textarea', 'hidden', or 'none'
			// datatype can be 'array' or 'hash'
			// can also specify input_attributes
			'title' => array(
				'input'   => 'text',
				'default' => __( 'Tags', 'linkify-tags' ),
				'label'   => __( 'Title', 'linkify-tags' ),
			),
			'tags' => array(
				'input'   => 'text',
				'default' => '',
				'label'   => __( 'Tags', 'linkify-tags' ),
				'help'    => __( 'A single tag ID/name, or multiple tag IDs/names defined via a comma-separated and/or space-separated string.', 'linkify-tags' ),
			),
			'before' => array(
				'input'   => 'text',
				'default' => '',
				'label'   => __( 'Before text', 'linkify-tags' ),
				'help'    => __( 'Text to display before all tags.', 'linkify-tags' ),
			),
			'after' => array(
				'input'   => 'text',
				'default' => '',
				'label'   => __( 'After text', 'linkify-tags' ),
				'help'    => __( 'Text to display after all tags.', 'linkify-tags' ),
			),
			'between' => array(
				'input'   => 'text',
				'default' => ', ',
				'label'   => __( 'Between tags', 'linkify-tags' ),
				'help'    => __( 'Text to appear between tags.', 'linkify-tags' ),
			),
			'before_last' => array(
				'input'   => 'text',
				'default' => '',
				'label'   => __( 'Before last tag', 'linkify-tags' ),
				'help'    => __( 'Text to appear between the second-to-last and last element, if not specified, \'between\' value is used.', 'linkify-tags' ),
			),
			'none' => array(
				'input'   => 'text',
				'default' => __( 'No tags specified to be displayed', 'linkify-tags' ),
				'label'   => __( 'None text', 'linkify-tags' ),
				'help'   => __( 'Text to appear when no tags have been found.  If blank, then the entire function doesn\'t display anything.', 'linkify-tags' ),
			),
		);

		parent::__construct(
			'linkify_tags',
			__( 'Linkify Tags', 'linkify-tags' ),
			__( 'Converts a list of tags (by name or ID) into links to those tags.', 'linkify-tags' ),
			$config
		);
	}

	/**
	 * Outputs the main content within the body of the widget.
	 *
	 * @since 005
	 *
	 * @param array $args Widget args.
	 * @param array $instance Widget instance.
	 */
	public function widget_content( $args, $instance ) {
		extract( $args );
		c2c_linkify_tags( $tags, $before, $after, $between, $before_last, $none );
	}

} // end class c2c_LinkifyTagsWidget

add_action( 'widgets_init', array( 'c2c_LinkifyTagsWidget', 'register_widget' ) );

endif; // end if !class_exists()
