<?php
/**
 * Tests for Vimeo oEmbed Modifications Plugin
 *
 * @package salcode/vimeo-oembed-modifications
 */

/**
 * Tests Vimeo oEmbed Modifications
 */
class Tests_Vimeo_Oembed_Modifications extends WP_UnitTestCase {

	/**
	 * Provide Vimeo URL for testing
	 *
	 * @return string URL for Vimeo video
	 */
	function get_example_vimeo_url() {
		return 'https://vimeo.com/66966424';
	}

	/**
	 * Parameters to apply to the oEmbed call
	 *
	 * This function is applied to the filter in the plugin
	 *
	 * @param  string $str_to_add initial URL paramters to add to oembed call.
	 * @return string modified URL parameters to add to the ombed call
	 */
	function filter_fe_vimeo_oembed_mods( $str_to_add ) {
		return 'portrait=0&api=1';
	}

	/**
	 * Test oEmbed call returns proper markup
	 *
	 * This includes the additional parameters applied to the src attribute
	 */
	function test_wp_oembed_get() {
		add_filter( 'fe_vimeo_oembed_mods', array( $this, 'filter_fe_vimeo_oembed_mods' ) );

		$example_url = $this->get_example_vimeo_url();

		$actual = wp_oembed_get( $example_url );

		$expected = '<iframe src="https://player.vimeo.com/video/66966424?portrait=0&api=1" width="660" height="371" frameborder="0" title="5DMK3 Raw Video Example" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

		$this->assertEquals( $expected, $actual );
	}
}
