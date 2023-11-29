<?php
/*
Plugin Name: WP YouTube Nocookie
Description: Modifies YouTube embeds to use the youtube-nocookie.com domain to prevent issues with the GDPR.
Version: 1.0
Author: Aj Clarke
Author URI: https://www.wpexplorer.com/
License: GPLv2
*/

final class WP_Youtube_No_Cookie {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'embed_oembed_html', [ $this, 'filter_embed_oembed_html' ], 10, 4 );
	}

	/**
	 * Modify the oEmbed HTMl.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/embed_oembed_html/
	 */
	public function filter_embed_oembed_html( $html, $url, $attr, $post_id ) {
		if ( str_contains( $url, 'youtube.com' ) ) {
			$html = str_replace( 'youtube.com', 'youtube-nocookie.com', $html );
		}
		return $html;
	}

}
new WP_Youtube_No_Cookie;
