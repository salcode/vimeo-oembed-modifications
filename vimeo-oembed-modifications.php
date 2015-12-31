<?php
/*
 * Plugin Name: Vimeo oEmbed Modifications
 * Plugin URI: https://github.com/salcode/vimeo-oembed-modifications
 * Description: Adds a filter "fe_vimeo_oembed_mods" that can be used to add URL parameters to the src attribute
 * Version: 1.0.1
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * GitHub Plugin URI: https://github.com/salcode/vimeo-oembed-modifications
 * Text Domain: vimeo-oembed-modifications
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter('oembed_result', 'fe_vom_oembed_result', 10, 3);

function fe_vom_oembed_result( $data, $url, $args = array() ) {

	// make no changes unless this is a vimeo video
	if ( false === strpos( $data, 'player.vimeo.com' ) ) { return $data; }

	$str_to_add = apply_filters( 'fe_vimeo_oembed_mods', '' );;

	if ( '' === $str_to_add ) { return $data; }

	// find where the iframe src attribute name begins
	$src_name_begins = strpos( $data, 'src="' );

	if ( false === $src_name_begins ) {
		if ( defined( WP_DEBUG ) && WP_DEBUG ) {
			error_log( 'Unable to add oEmbed URL Parameters because the oEmbed data did not include "src="' );
		}
		return $data;
	}

	$src_start = $src_name_begins + strlen( 'src="' );
	$src_end   = strpos( $data, '"', $src_start );

	$pre  = substr( $data, 0,          $src_start );
	$src  = substr( $data, $src_start, $src_end - $src_start );
	$post = substr( $data, $src_end );

	$src .= false === strpos( $src, '?' ) ? '?' : '&amp;';

	$src .= $str_to_add;

	return $pre . $src . $post;
}
