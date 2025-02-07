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
		add_filter( 'embed_oembed_html', [ $this, 'filter_embed_oembed_html' ] );
		add_filter( 'the_content', [ $this, 'filter_the_content' ], 100 );

		if ( class_exists( 'ACF' ) ) {
			add_filter( 'acf/format_value/type=oembed', [ $this, 'filter_acf_oembed' ], 100, 3);
		}
	}

	/**
	 * Modify the oEmbed HTML.
	 */
	public function filter_embed_oembed_html( $html ) {
		if ( str_contains( $html, 'youtube.com' ) ) {
			$html = str_replace( 'youtube.com', 'youtube-nocookie.com', $html );
		}
		return $html;
	}

	/**
	 * Modify the post content.
	 */
	public function filter_the_content( $content ) {
		if ( str_contains( $content, 'youtube.com/embed' ) ) {
			$content = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed', $content );
		}
		return $content;
	}

	/**
	 * Modify ACF oEmbed field.
	 */
	public function filter_acf_oembed( $value, $post_id, $field ) {
		if ( str_contains( $value, 'youtube.com' ) ) {
			$value = str_replace( 'youtube.com', 'youtube-nocookie.com', $value );
		} else if ( str_contains( $value, 'youtu.be' ) ) {
			$value = str_replace( 'youtu.be/', 'www.youtube-nocookie.com/embed/', $value );
		}
		return $value;
	}

}

new WP_Youtube_No_Cookie;
