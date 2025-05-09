<?php

defined( 'ABSPATH' ) or die();

class Linkify_Tags_Test extends WP_UnitTestCase {

	private $tag_ids = array();

	public function setUp(): void {
		parent::setUp();
		$this->tag_ids = $this->factory->tag->create_many( 5 );
	}


	//
	//
	// HELPER FUNCTIONS
	//
	//


	protected function get_slug( $tag_id ) {
		return get_tag( $tag_id )->slug;
	}

	/**
	 * Returns the expected output.
	 *
	 * @param int    $count     The number of tags to list.
	 * @param int    $tag_index Optional. The index into the $tag_ids array to start at. Default 0.
	 * @param string $between   Optional. The string to appear between tags. Default ', '.
	 * @param int    $tag_num   Optional. The tag number. Default 1.
	 * @return string
	 */
	protected function expected_output( $count, $tag_index = 0, $between = ', ', $tag_num = 1 ) {
		$str = '';
		for ( $n = 1; $n <= $count; $n++, $tag_index++ ) {
			if ( ! empty( $str ) ) {
				$str .= $between;
			}
			$tag = get_term( $this->tag_ids[ $tag_index ] );
			$str .= '<a href="http://example.org/?tag=' . $tag->slug . '" title="View all posts in ' . $tag->name . '">' . $tag->name . '</a>';
		}
		return $str;
	}

	protected function get_results( $args, $direct_call = true ) {
		ob_start();

		$function = 'c2c_linkify_tags';

		if ( $direct_call ) {
			call_user_func_array( $function, $args );
		} else {
			do_action_ref_array( $function, $args );
		}

		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}


	//
	//
	// TESTS
	//
	//


	public function test_widget_class_name() {
		$this->assertTrue( class_exists( 'c2c_LinkifyTagsWidget' ) );
	}

	public function test_widget_version() {
		$this->assertEquals( '006', c2c_LinkifyTagsWidget::version() );
	}

	public function test_widget_hooks_widgets_init() {
		$this->assertEquals( 10, has_filter( 'widgets_init', array( 'c2c_LinkifyTagsWidget', 'register_widget' ) ) );
	}

	public function test_widget_made_available() {
		$this->assertContains( 'c2c_LinkifyTagsWidget', array_keys( $GLOBALS['wp_widget_factory']->widgets ) );
	}

	public function test_single_id() {
		$this->assertEquals( $this->expected_output( 1 ), $this->get_results( array( $this->tag_ids[0] ) ) );
	}

	public function test_array_of_ids() {
		$this->assertEquals( $this->expected_output( 5 ), $this->get_results( array( $this->tag_ids ) ) );
	}

	public function test_single_slug() {
		$tag = get_tag( $this->tag_ids[0] );
		$this->assertEquals( $this->expected_output( 1 ), $this->get_results( array( $tag->slug ) ) );
	}

	public function test_array_of_slugs() {
		$tag_slugs = array_map( array( $this, 'get_slug' ), $this->tag_ids );
		$this->assertEquals( $this->expected_output( 5 ), $this->get_results( array( $tag_slugs ) ) );
	}

	public function test_all_empty_tags() {
		$this->assertEmpty( $this->get_results( array( '' ) ) );
		$this->assertEmpty( $this->get_results( array( array() ) ) );
		$this->assertEmpty( $this->get_results( array( array( array(), '' ) ) ) );
	}

	public function test_an_empty_tag() {
		$tag_ids = array_merge( array( '' ), $this->tag_ids );
		$this->assertEquals( $this->expected_output( 5 ), $this->get_results( array( $tag_ids ) ) );
	}

	public function test_all_invalid_tags() {
		$this->assertEmpty( $this->get_results( array( 99999999 ) ) );
		$this->assertEmpty( $this->get_results( array( 'not-a-tag' ) ) );
	}

	public function test_an_invalid_tag() {
		$tag_ids = array_merge( array( 99999999 ), $this->tag_ids );
		$this->assertEquals( $this->expected_output( 5 ), $this->get_results( array( $tag_ids ) ) );
	}

	public function test_arguments_before_and_after() {
		$expected = '<div>' . $this->expected_output( 5 ) . '</div>';
		$this->assertEquals( $expected, $this->get_results( array( $this->tag_ids, '<div>', '</div>' ) ) );
	}

	public function test_argument_between() {
		$expected = '<ul><li>' . $this->expected_output( 5, 0, '</li><li>' ) . '</li></ul>';
		$this->assertEquals( $expected, $this->get_results( array( $this->tag_ids, '<ul><li>', '</li></ul>', '</li><li>' ) ) );
	}

	public function test_argument_before_last() {
		$before_last = ', and ';
		$expected = $this->expected_output( 4 ) . $before_last . $this->expected_output( 1, 4, ', ', 5 );
		$this->assertEquals( $expected, $this->get_results( array( $this->tag_ids, '', '', ', ', $before_last ) ) );
	}

	public function test_argument_none() {
		$missing = 'No tags to list.';
		$expected = '<ul><li>' . $missing . '</li></ul>';
		$this->assertEquals( $expected, $this->get_results( array( array(), '<ul><li>', '</li></ul>', '</li><li>', '', $missing ) ) );
	}

	public function test_unsafe_markup_is_omitted() {
		$before_last = ', and ';
		$boom = 'alert("boom!");';
		$expected = $boom . $this->expected_output( 1, 0 ) . $before_last . $boom . $this->expected_output( 1, 1, "," ) . $boom;
		$this->assertEquals(
			$expected,
			$this->get_results( array(
				array_slice( $this->tag_ids, 0, 2 ),
				"<script>$boom</script>",
				"<script>$boom</script>",
				"<script>$boom</script>",
				$before_last . "<script>$boom</script>"
			) )
		);
	}

	/*
	 * __c2c_linkify_tags_get_tag_link()
	 */

	 public function test___c2c_linkify_tags_get_tag_link() {
		$tag = get_tag( $this->tag_ids[0] );
		$title = $tag->name;
		$slug = $tag->slug;

		$expected = sprintf(
			'<a href="http://example.org/?tag=%s" title="View all posts in %s">%s</a>',
			$slug,
			esc_attr( $title ),
			esc_html( $title )
		);

		$this->assertEquals(
			$expected,
			__c2c_linkify_tags_get_tag_link( $this->tag_ids[0] )
		);
	}

	public function test___c2c_linkify_tags_get_tag_link_with_invalid_id() {
		$this->assertEmpty( __c2c_linkify_tags_get_tag_link( -1 ) );
	}

}
