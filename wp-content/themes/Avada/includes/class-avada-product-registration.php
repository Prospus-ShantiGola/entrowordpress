<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * A class to handle everything related to product registration
 *
 * @since 5.0.0
 */
class Avada_Product_Registration {

	/**
	 * The option group name.
	 *
	 * @since 5.0.0
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $option_group_slug = 'avada_registration';

	/**
	 * The option name.
	 *
	 * @since 5.0.0
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $option_name = 'avada_registration';

	/**
	 * The option array.
	 *
	 * @since 5.0.0
	 *
	 * @static
	 * @access private
	 * @var array
	 */
	private static $option;

	/**
	 * The Envato token.
	 *
	 * @since 5.0.0
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $token;

	/**
	 * Whether the token is valid and for Avada or not.
	 *
	 * @since 5.0.0
	 *
	 * @static
	 * @access private
	 * @var bool
	 */
	private static $registered;

	/**
	 * The class constructor.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		self::init_globals();

		// Register the settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );

	}

	/**
	 * Initialize the variables..
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @return void
	 */
	private function init_globals() {
		self::$option = get_option( self::$option_name );
		self::$token = self::$option['token'];
		self::$registered = get_option( 'avada_registered' );
	}

	/**
	 * Returns the option group name.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return string The option group name.
	 */
	public static function get_option_group_slug() {
		return self::$option_group_slug;
	}

	/**
	 * Sets a new token.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @param string $token A new token.
	 * @return void
	 */
	public static function set_token( $token ) {
		self::$token = $token;
	}

	/**
	 * Returns the current token.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return string The current token.
	 */
	public static function get_token() {
		return self::$token;
	}

	/**
	 * Registers the setting field(s) for the registration form.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function register_settings() {
		// Setting.
		register_setting( self::$option_group_slug, self::$option_name, array( $this, 'check_registration' ) );

		// Token setting.
		add_settings_field(
			'token',
			__( 'Token', 'Avada' ),
			array( $this, 'render_token_setting_callback' ),
			self::$option_group_slug
		);
	}

	/**
	 * Renders the token settings field.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function render_token_setting_callback() {
		?>
		<input type="text" name="<?php echo esc_attr( self::$option_name ); ?>[token]" class="widefat" value="<?php echo esc_html( self::$token ); ?>" autocomplete="off">
		<?php
	}

	/**
	 * Envato API class.
	 *
	 * @since 5.0.0
	 *
	 * @return Avada_Envato_API
	 */
	public static function envato_api() {
		if ( ! class_exists( 'Avada_Envato_API' ) ) {
			require_once( Avada::$template_dir_path . '/includes/class-avada-envato-api.php' );
		}
		return Avada_Envato_API::instance();
	}

	/**
	 * Checks if Avada is part of the themes purchased by the user belonging to the token.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @param string $new_value The new token to check.
	 */
	public function check_registration( $new_value ) {

		// Get the old value.
		$old_value   = false;
		$old_setting = get_option( 'avada_registration', false );
		if ( is_array( $old_setting ) && isset( $old_setting['token'] ) ) {
			$old_value = $old_setting['token'];
		}
		if ( false === $old_value || empty( $old_value ) ) {
			$old_value = array( 'token' => '' );
		}

		// Check that the new value is properly formatted.
		if ( is_array( $new_value ) && isset( $new_value['token'] ) ) {
			// If token field is empty, copy is not registered.
			if ( empty( $new_value['token'] ) ) {
				$registered = false;
			} else {
				// Remove spaces from the beginning and end of the token.
				$new_value['token'] = trim( $new_value['token'] );
				// If field contents changed, we have to check if new token is valid.
				if ( ! isset( $old_value['token'] ) || ( $old_value['token'] != $new_value['token'] ) ) {
					$registered = self::is_avada_in_themes( $new_value['token'] );
				}
			}
		} else {
			$new_value = array( 'token' => '' );
		}
		// Update the 'avada_registered' option.
		update_option( 'avada_registered', $registered );
		// Return the new value.
		return $new_value;
	}

	/**
	 * Checks if Avada is part of the themes purchased by the user belonging to the token.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @param string $token A token to check.
	 * @return bool
	 */
	private static function is_avada_in_themes( $token = '' ) {
		// Set the new token for the API call.
		if ( '' !== $token ) {
			self::envato_api()->set_token( $token );
		}

		$themes = self::envato_api()->themes();

		// If a WP Error object is returned we need to check if API is down.
		if ( is_wp_error( $themes ) ) {
			// 403 means the token is invalid, so in any other case set a transient to allow bypassing registration.
			if ( 403 !== $themes->get_error_code() ) {
				set_site_transient( 'avada_envato_api_down', true, 3600 );
			}

			return false;
		}

		// Check iv Avada is part of the purchased themes.
		foreach ( $themes as $theme ) {
			if ( isset( $theme['name'] ) ) {
				if ( 'avada' == strtolower( $theme['name'] ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Has user associated with current token purchased Avada?
	 *
	 * @access public
	 * @since 5.0.0
	 * @return bool
	 */
	public static function is_registered() {
		// If no token is set, the product is not registered.
		if ( empty( self::$token ) ) {
			return false;
		} elseif ( self::$registered ) {
			return true;
		} elseif ( get_site_transient( 'avada_envato_api_down' ) ) {
			return true;
		} else {
			return false;
		}
	}
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */
