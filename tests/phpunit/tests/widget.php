<?php

defined( 'ABSPATH' ) or die();

class Linkify_Widget_Test extends WP_UnitTestCase {

	private $tag_ids = array();

	public function setUp() {
		parent::setUp();
		$this->tag_ids = $this->factory->tag->create_many( 5 );
	}


	//
	//
	// HELPER FUNCTIONS
	//
	//

	protected function get_results( $widget, $args, $instance, $full_widget_content = true ) {
		ob_start();

		$function = $full_widget_content ? 'widget' : 'widget_content';

		call_user_func_array( array( $widget, $function ), array( $args, $instance ) );

		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	private function widget_init( $config = array() ) {
		c2c_LinkifyTagsWidget::register_widget();
		$widget = new c2c_LinkifyTagsWidget();

		$default_config = array();
		foreach ( $widget->get_config() as $key => $val ) {
			$default_config[ $key ] = $val['default'];
		}
		$config = array_merge( $default_config, $config );

		$settings = array(
			'before_title'  => '<h3>',
			'before_widget' => '<div class="my-widget">',
			'after_title'   => '</h3>',
			'after_widget'  => '</div>'
		);

		return array( $widget, $config, $settings );
	}


	//
	//
	// TESTS
	//
	//


	public function test_widget_class_exists() {
		$this->assertTrue( class_exists( 'c2c_LinkifyTagsWidget' ) );
	}

	public function test_widget_version() {
		$this->assertEquals( '005', c2c_LinkifyTagsWidget::version() );
	}

	public function test_widget_framework_class_name() {
		$this->assertTrue( class_exists( 'c2c_LinkifyWidget' ) );
	}

	public function test_widget_framework_version() {
		$this->assertEquals( '005', c2c_LinkifyWidget::version() );
	}

	public function test_widget_hooks_widgets_init() {
		$this->assertEquals( 10, has_filter( 'widgets_init', array( 'c2c_LinkifyTagsWidget', 'register_widget' ) ) );
	}

	public function test_widget_made_available() {
		$this->assertArrayHasKey( 'c2c_LinkifyTagsWidget', $GLOBALS['wp_widget_factory']->widgets );
	}

	public function test_get_config() {
		list( $widget, $config, $settings ) = $this->widget_init( array( 'tags' => $this->tag_ids[0], 'before' => 'Tag: ', 'after' => '.' )  );

		$this->assertEqualsCanonicalizing(
			[ 'after', 'before', 'before_last', 'between', 'none', 'tags', 'title' ],
			array_keys( $widget->get_config() )
		);

		$this->assertEqualsCanonicalizing(
			[ 'default', 'help', 'input', 'label' ],
			array_keys( $widget->get_config()['tags'] )
		);
	}

	public function test_widget_body() {
		list( $widget, $config, $settings ) = $this->widget_init( array( 'tags' => $this->tag_ids[0], 'before' => 'Tag: ', 'after' => '.' )  );

		$this->assertEquals(
			sprintf( '<div class="my-widget"><h3>Tags</h3>Tag: %s.</div>', __c2c_linkify_tags_get_tag_link( $this->tag_ids[0] ) ),
			$this->get_results( $widget, $settings, $config )
		);
	}

	public function test_widget_body_with_multiple_tags() {
		list( $widget, $config, $settings ) = $this->widget_init( array( 'tags' => $this->tag_ids[0] . ',' . $this->tag_ids[1], 'before' => '<ul><li>', 'after' => '</li></ul>', 'between' => '</li><li>' )  );

		$this->assertEquals(
			sprintf(
				'<div class="my-widget"><h3>Tags</h3><ul><li>%s</li><li>%s</li></ul></div>',
				__c2c_linkify_tags_get_tag_link( $this->tag_ids[0] ),
				__c2c_linkify_tags_get_tag_link( $this->tag_ids[1] )
			),
			$this->get_results( $widget, $settings, $config )
		);
	}

	public function test_widget_body_with_invalid_tags() {
		list( $widget, $config, $settings ) = $this->widget_init( array( 'tags' => 'bogus', 'before' => '<ul><li>', 'after' => '</li></ul>', 'between' => '</li><li>' )  );

		$this->assertEquals(
			'<div class="my-widget"><h3>Tags</h3><ul><li>No tags specified to be displayed</li></ul></div>',
			$this->get_results( $widget, $settings, $config )
		);
	}

	public function test_widget_body_with_no_specified_tags() {
		list( $widget, $config, $settings ) = $this->widget_init( array( 'tags' => '', 'before' => '<ul><li>', 'after' => '</li></ul>', 'between' => '</li><li>' )  );

		$this->assertEquals(
			'<div class="my-widget"><h3>Tags</h3><ul><li>No tags specified to be displayed</li></ul></div>',
			$this->get_results( $widget, $settings, $config )
		);
	}

}
