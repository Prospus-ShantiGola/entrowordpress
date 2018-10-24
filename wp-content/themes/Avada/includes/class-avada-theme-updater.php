<?php
/**
 * Envato API class.
 *
 * @package Avada_Theme_Updater
 */

if ( ! class_exists( 'Avada_Theme_Updater' ) ) :

	/**
	 * Creates the Envato API connection.
	 *
	 * @class Avada_Theme_Updater
	 * @version 5.0.0
	 * @since 5.0.0
	 */
	class Avada_Theme_Updater {

		/**
		 * The single class instance.
		 *
		 * @since 5.0.0
		 * @access private
		 *
		 * @var object
		 */
		private static $_instance = null;

		/**
		 * The Envato API personal token.
		 *
		 * @static
		 * @since 5.0.0
		 * @var string
		 */
		public static $token;

		/**
		 * Constructor
		 *
		 * @since 5.0.0
		 * @access public
		 */
		public function __construct() {

			// Get the token.
			$option = get_option( 'avada_registration', array( 'token' => '' ) );
			self::$token = $option['token'];

			// Inject theme updates into the response array.
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'update_themes' ) );
			add_filter( 'pre_set_transient_update_themes', array( $this, 'update_themes' ) );

			add_filter( 'http_request_args', array( $this, 'update_check' ), 5, 2 );

			// Deferred Download.
			add_action( 'upgrader_package_options', array( $this, 'maybe_deferred_download' ), 99 );

		}

		/**
		 * Deferred item download URL.
		 *
		 * @since 5.0.0
		 *
		 * @param int $id The item ID.
		 * @return string.
		 */
		public function deferred_download( $id ) {
			if ( empty( $id ) ) {
				return '';
			}

			$args = array(
				'deferred_download' => true,
				'item_id' => $id,
			);
			return add_query_arg( $args, esc_url( admin_url( 'admin.php?page=avada' ) ) );
		}

		/**
		 * Get the item download.
		 *
		 * @since 5.0.0
		 *
		 * @param  int   $id The item ID.
		 * @param  array $args The arguments passed to `wp_remote_get`.
		 * @return bool|array The HTTP response.
		 */
		public function download( $id, $args = array() ) {
			if ( empty( $id ) ) {
				return false;
			}

			$url = 'https://api.envato.com/v2/market/buyer/download?item_id=' . $id . '&shorten_url=true';
			$response = Avada()->registration->envato_api()->request( $url, $args );

			// @todo Find out which errors could be returned & handle them in the UI.
			if ( is_wp_error( $response ) || empty( $response ) || ! empty( $response['error'] ) ) {
				return false;
			}

			if ( ! empty( $response['wordpress_theme'] ) ) {
				return $response['wordpress_theme'];
			}

			if ( ! empty( $response['wordpress_plugin'] ) ) {
				return $response['wordpress_plugin'];
			}

			return false;
		}

		/**
		 * Inject update data for premium themes.
		 *
		 * @since 5.0.0
		 *
		 * @param object $transient The pre-saved value of the `update_themes` site transient.
		 * @return object
		 */
		public function update_themes( $transient ) {
			// Process Avada updates.
			if ( isset( $transient->checked ) ) {

				// Get the installed version of Avada.
				$current_avada_version = Avada::get_normalized_theme_version();

				// Get the themes from the Envato API.
				$themes = Avada_Product_Registration::envato_api()->themes();

				// Get latest Avada version.
				$latest_avada = array(
					'id'      => '',
					'name'    => '',
					'url'     => '',
					'version' => '',
				);
				foreach ( $themes as $theme ) {
					if ( isset( $theme['name'] ) && 'avada' === strtolower( $theme['name'] ) ) {
						$latest_avada = $theme;
						break;
					}
				}

				if ( version_compare( $current_avada_version, $latest_avada['version'], '<' ) ) {
					$transient->response[ $latest_avada['name'] ] = array(
						'theme'       => $latest_avada['name'],
						'new_version' => $latest_avada['version'],
						'url'         => $latest_avada['url'],
						'package'     => $this->deferred_download( $latest_avada['id'] ),
					);
				}
			}

			return $transient;
		}

		/**
		 * Disables requests to the wp.org repository for Avada.
		 *
		 * @since 5.0.0
		 *
		 * @param array  $request An array of HTTP request arguments.
		 * @param string $url The request URL.
		 * @return array
		 */
		public function update_check( $request, $url ) {

			// Theme update request.
			if ( false !== strpos( $url, '//api.wordpress.org/themes/update-check/1.1/' ) ) {

				// Decode JSON so we can manipulate the array.
				$data = json_decode( $request['body']['themes'] );

				// Remove Avada.
				unset( $data->themes->Avada );

				// Encode back into JSON and update the response.
				$request['body']['themes'] = wp_json_encode( $data );
			}
			return $request;
		}

		/**
		 * Defers building the API download url until the last responsible moment to limit file requests.
		 *
		 * Filter the package options before running an update.
		 *
		 * @since 5.0.0
		 *
		 * @param array $options {
		 *     Options used by the upgrader.
		 *
		 *     @type string $package                     Package for update.
		 *     @type string $destination                 Update location.
		 *     @type bool   $clear_destination           Clear the destination resource.
		 *     @type bool   $clear_working               Clear the working resource.
		 *     @type bool   $abort_if_destination_exists Abort if the Destination directory exists.
		 *     @type bool   $is_multi                    Whether the upgrader is running multiple times.
		 *     @type array  $hook_extra                  Extra hook arguments.
		 * }
		 */
		public function maybe_deferred_download( $options ) {
			$package = $options['package'];
			if ( false !== strrpos( $package, 'deferred_download' ) && false !== strrpos( $package, 'item_id' ) ) {
				parse_str( parse_url( $package, PHP_URL_QUERY ), $vars );
				if ( $vars['item_id'] ) {
					$args = $this->set_bearer_args();
					$options['package'] = $this->download( $vars['item_id'], $args );
				}
			}
			return $options;
		}

		/**
		 * Returns the bearer arguments for a request with a single use API Token.
		 *
		 * @since 5.0.0
		 * @return array
		 */
		public function set_bearer_args() {
			$args = array();
			if ( ! empty( self::$token ) ) {
				$args = array(
					'headers' => array(
						'Authorization' => 'Bearer ' . self::$token,
						'User-Agent' => 'WordPress - Avada ' . Avada::get_normalized_theme_version(),
					),
					'timeout' => 20,
				);
			}
			return $args;
		}
	}

endif;
