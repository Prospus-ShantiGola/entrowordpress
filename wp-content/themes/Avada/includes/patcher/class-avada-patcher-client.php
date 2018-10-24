<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Handles getting patches remotely and preparing them for Avada.
 *
 * @since 4.0.0
 */
class Avada_Patcher_Client {

	/**
	 * Patches array.
	 *
	 * @var bool|array
	 */
	public static  $patches;

	/**
	 * The name of the transient we'll be using.
	 *
	 * @var string
	 */
	private static $transient_name = 'avada_patches';

	/**
	 * The URL of the patches remote server.
	 *
	 * @var string
	 */
	public $remote_patches_uri = 'http://updates.theme-fusion.com/avada_patch/';

	/**
	 * The Avada version.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $avada_version = false;

	/**
	 * The Fusion-Core version.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $fusion_core_version = false;

	/**
	 * The Fusion-Builder version.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $fusion_builder_version = false;

	/**
	 * Gets an array of all our patches.
	 * If we have these cached then use caches,
	 * otherwise query the server.
	 *
	 * @return array
	 */
	public static function get_patches() {
		$client = new self();
		if ( $client->get_cached() ) {
			self::$patches = $client->get_cached();
		} else {
			self::$patches = $client->query_patch_server();
			$client->cache_response();
		}
		return $client->prepare_patches( self::$patches );
	}

	/**
	 * Queries the patches server for a list of patches.
	 *
	 * @return bool|array
	 */
	private function query_patch_server() {

		// Get the fusion-core version.
		$this->fusion_core_version = ( class_exists( 'FusionCore_Plugin' ) ) ? FusionCore_Plugin::VERSION : false;
		// Get the fusion-builder plugin version.
		$this->fusion_builder_version = ( class_exists( 'FusionBuilder' ) ) ? FUSION_BUILDER_VERSION : false;
		// Get the avada theme version.
		$this->avada_version = Avada::get_theme_version();

		// Build the remote server URL using the theme version.
		$args = array();
		if ( $this->avada_version ) {
			$args['avada_version'] = $this->avada_version;
		}
		if ( $this->fusion_builder_version ) {
			$args['fusion_builder_version'] = $this->fusion_builder_version;
		}
		if ( $this->fusion_core_version ) {
			$args['fusion_core_version'] = $this->fusion_core_version;
		}
		$url = add_query_arg( $args, $this->remote_patches_uri );

		// Get the server response.
		$response = wp_remote_get( $url, array( 'user-agent' => 'avada-patcher-client' ) );

		// Return false if we couldn't get to the server.
		if ( is_wp_error( $response ) ) {
			// Add a message so that the user knows what happened.
			new Avada_Patcher_Admin_Notices( 'server-unreachable', esc_attr__( 'The Avada patches server could not be reached. Please contact your host to unblock the "https://theme-fusion.com/" domain.', 'Avada' ) );
			return false;
		}

		// Return false if the response does not have a body.
		if ( ! isset( $response['body'] ) ) {
			return false;
		}
		$json = $response['body'];

		// Response may have comments from caching plugins making it invalid.
		if ( false !== strpos( $response['body'], '<!--' ) ) {
			$json = explode( '<!--', $json );
			return json_decode( $json[0] );
		}
		return json_decode( $json );
	}

	/**
	 * Decodes patches if needed.
	 *
	 * @return array
	 */
	private function prepare_patches() {
		self::$patches = (array) self::$patches;
		$patches = array();

		if ( ! empty( self::$patches ) ) {
			foreach ( self::$patches as $patch_id => $patch_args ) {
				$patches[ $patch_id ] = (array) $patch_args;
				if ( empty( $patch_args ) ) {
					continue;
				}
				foreach ( $patch_args as $key => $patch ) {
					$patches[ $patch_id ][ $key ] = (array) $patch;
					foreach ( $patches[ $patch_id ]['patch'] as $patch_key => $args ) {
						$args = (array) $args;
						$args['reference'] = base64_decode( $args['reference'] );
						$patches[ $patch_id ]['patch'][ $patch_key ] = $args;
					}
				}
			}
		}
		return $patches;
	}

	/**
	 * Gets the cached patches.
	 */
	private function get_cached() {
		// Force getting new options from the server if needed.
		if ( $_GET && isset( $_GET['avada-reset-cached-patches'] ) ) {
			$this->reset_cache();
			return false;
		}
		return get_site_transient( self::$transient_name );
	}

	/**
	 * Caches the patches using transients.
	 *
	 * @return void
	 */
	private function cache_response() {
		if ( false !== self::$patches && ! empty( self::$patches ) ) {
			// Cache for 30 minutes.
			set_site_transient( self::$transient_name, self::$patches, 30 * 60 );
		}
	}

	/**
	 * Resets the transient cache.
	 *
	 * @return void
	 */
	private function reset_cache() {
		delete_site_transient( self::$transient_name );
	}
}
