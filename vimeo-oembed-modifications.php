<?php
/*
 * Plugin Name: Vimeo oEmbed Modifications
 * Plugin URI: https://github.com/salcode/vimeo-oembed-modifications
 * Description: Adds a filter "fe_vimeo_oembed_mods" that can be used to add URL arguments to the oEmbed request
 * Version: 1.1.0
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

add_filter('oembed_fetch_url', 'fe_vom_oembed_fetch_url', 10, 3);

register_activation_hook(   __FILE__, 'fe_vom_flush_cached_vimeo_oembeds' );
register_deactivation_hook( __FILE__, 'fe_vom_flush_cached_vimeo_oembeds' );

function fe_vom_oembed_fetch_url( $provider, $url, $args = array() ) {

	// make no changes unless this is a vimeo video
	if ( false === strpos( $provider, 'vimeo.com/api/oembed.json' ) ) { return $data; }

	$str_to_add = apply_filters( 'fe_vimeo_oembed_mods', '', $provider, $url, $args );

	if ( '' === $str_to_add ) { return $data; }

	$provider .= $str_to_add;

	return $provider;
}

function fe_vom_flush_cached_vimeo_oembeds() {
	global $wpdb;

	$sql = "DELETE FROM {$wpdb->postmeta} WHERE `meta_key` LIKE '_oembed_%' AND `meta_value` LIKE '%_player.vimeo.com/video_%'";

	$wpdb->query( $sql );

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'Plugin Vimeo oEmbed Modifications Flushed Vimeo oEmbeds (due to plugin activation or deactivation)' );
	}
}
