<?php
/**
 * Plugin Name: Vimeo oEmbed Modifications
 * Plugin URI: https://github.com/salcode/vimeo-oembed-modifications
 * Description: Adds a filter "fe_vimeo_oembed_mods" that can be used to add URL arguments to the oEmbed request
 * Version: 1.2.1
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * GitHub Plugin URI: https://github.com/salcode/vimeo-oembed-modifications
 * Text Domain: vimeo-oembed-modifications
 * Domain Path: /languages
 *
 * @package salcode/vimeo-oembed-modifications
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'oembed_fetch_url', 'fe_vom_oembed_fetch_url', 10, 3 );

register_activation_hook( __FILE__, 'fe_vom_flush_cached_vimeo_oembeds' );
register_deactivation_hook( __FILE__, 'fe_vom_flush_cached_vimeo_oembeds' );

/**
 * Apply additional URL paramaters to the provider URL for Vimeo oEmbeds
 *
 * @param string $provider URL of the oEmbed provider.
 * @param string $url URL of the content to be embedded.
 * @param string $args arguments, usually passed from a shortcode.
 */
function fe_vom_oembed_fetch_url( $provider, $url, $args = array() ) {

	// Make no changes unless this is a vimeo video.
	if ( false === strpos( $provider, 'vimeo.com/api/oembed.json' ) ) { return $provider; }

	$str_to_add = apply_filters( 'fe_vimeo_oembed_mods', '', $provider, $url, $args );

	if ( '' === $str_to_add ) { return $provider; }

	$provider .= ( '&' !== $str_to_add[0] ? '&' : '' ) .  $str_to_add;

	return $provider;
}

/**
 * Remove all cached Vimeo oEmbeds from the database
 */
function fe_vom_flush_cached_vimeo_oembeds() {
	global $wpdb;

	$sql = "DELETE FROM {$wpdb->postmeta} WHERE `meta_key` LIKE '_oembed_%' AND `meta_value` LIKE '%_player.vimeo.com/video_%'";

	$wpdb->query( $sql );

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'Plugin Vimeo oEmbed Modifications Flushed Vimeo oEmbeds (due to plugin activation or deactivation)' );
	}
}
