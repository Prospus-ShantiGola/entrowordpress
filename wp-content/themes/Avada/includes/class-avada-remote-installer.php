<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Remote installer for premium plugins.
 * This only works with our custom server plugin.
 *
 * @since 5.0.0
 */
class Avada_Remote_installer {

	/**
	 * The remote API URL.
	 *
	 * @access private
	 * @var string
	 */
	private $api_url = 'http://updates.theme-fusion.com/';

	/**
	 * The constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		$this->api_url = trailingslashit( $this->api_url );
	}

	/**
	 * Checks token against API
	 *
	 * @access private
	 * @param string $download The name of the download..
	 * @param string $token    The token.
	 * @return false|string    Returns false if invalid.
	 *                         If valid, then returns a nonce from the remote server.
	 */
	private function _get_nonce( $download, $token ) {

		// Get any existing copy of our transient data.
		if ( false === ( $saved_nonce = get_transient( 'avada_ri_' . $download . $token ) ) ) {
			// It wasn't there, so regenerate the data and save the transient.
			$url      = $this->api_url . '?avada_action=request_download&item_name=' . urlencode( $download ) . '&token=' . $token;
			$response = wp_remote_get( $url );
			$body     = wp_remote_retrieve_body( $response );

			// Check for errors.
			$error_responses = array(
				'Product not defined' => 'download-undefined',
				'Invalid Token'       => 'invalid-token',
			);
			foreach ( $error_responses as $key => $value ) {
				if ( false !== strpos( $body, $key ) ) {
					return false;
				}
			}
			$trimmed = trim( $body );
			$parts   = explode( '|', $body );

			$saved_nonce = array();

			if ( 2 === count( $parts ) ) {

				$saved_nonce = array(
					esc_attr( $parts[0] ),
					esc_attr( $parts[1] ),
				);
			}

			set_transient( 'avada_ri_' . $download . $token, $saved_nonce, 600 );
		}

		return $saved_nonce;

	}

	/**
	 * Gets the download URL for a plugin.
	 *
	 * @access public
	 * @since 5.0.0
	 * @param string $download The plugin to download.
	 * @return string|false
	 */
	public function get_package( $download ) {

		// Try to get a cached response.
		$download_src = get_transient( 'avada_remote_installer_package_' . $download );

		// If we've got it cached, then return it.
		if ( false !== $download_src ) {
			return $download_src;
		}

		// Source is not cached, retrieve it and cache it.
		// Check for token and then install if it's valid.
		$nonces = $this->_get_nonce( $download,  Avada()->registration->get_token() );
		if ( false !== $nonces && Avada()->registration->is_registered() ) {
			$api_args = array(
				'avada_action' => 'get_download',
				'item_name'    => urlencode( $download ),
				'nonce'        => isset( $nonces[0] ) ? $nonces[0] : '',
				't'            => isset( $nonces[1] ) ? $nonces[1] : '',
			);

			$download_src = add_query_arg( $api_args, $this->api_url );
			set_transient( 'avada_remote_installer_package_' . $download, $download_src, 300 );

			return $download_src;
		}

		// Something went wrong, return false.
		return false;
	}
}
