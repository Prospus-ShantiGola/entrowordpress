<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Get & set setting values.
 */
class Avada_Settings {

	/**
	 * A single instance of this object.
	 *
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Options array.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $options_with_id = array();

	/**
	 * Saved options array.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $saved_options = array();

	/**
	 * Cached options array.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	private static $cached_options = array();

	/**
	 * Custom color schemes array.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $custom_color_schemes = array();

	/**
	 * Access the single instance of this class.
	 *
	 * @return Avada_Settings
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Avada_Settings();
		}
		return self::$instance;
	}

	/**
	 * The class constructor.
	 */
	public function __construct() {

		self::$saved_options        = get_option( Avada::get_option_name(), array() );
		self::$options_with_id      = Avada_Options::get_option_fields();
		self::$custom_color_schemes = get_option( 'avada_custom_color_schemes' );
	}

	/**
	 * Get all settings.
	 */
	public function get_all() {

		return get_option( Avada::get_option_name(), array() );

	}

	/**
	 * Gets the value of a single setting.
	 * This is a proxy methof for _get to avoid re-processing
	 * already retrieved options.
	 *
	 * @param  null|string  $setting The setting.
	 * @param  false|string $subset If the result is an array, return the value of the defined key.
	 * @return  string|array
	 */
	public function get( $setting = null, $subset = false ) {

		if ( is_null( $setting ) || empty( $setting ) ) {
	        return '';
	    }

		// We don't need a subset.
		if ( ! $subset || empty( $subset ) ) {
			// Cache the value.
			if ( ! isset( self::$cached_options[ $setting ] ) ) {
				self::$cached_options[ $setting ] = $this->_get( $setting );
			}
			// Return cached value.
			return self::$cached_options[ $setting ];
		}

		// If we got this far, we need a subset.
		if ( ! isset( self::$cached_options[ $setting ] ) || ! isset( self::$cached_options[ $setting ][ $subset ] ) ) {
			if ( ! isset( self::$cached_options[ $setting ] ) ) {
				self::$cached_options[ $setting ] = array();
			}
			if ( ! isset( self::$cached_options[ $setting ] ) || ! is_array( self::$cached_options[ $setting ] ) ) {
				self::$cached_options = array();
			}
			self::$cached_options[ $setting ][ $subset ] = $this->_get( $setting, $subset );
		}
		// Return the cached value.
		return self::$cached_options[ $setting ][ $subset ];

	}

	/**
	 * Gets the value of a single setting.
	 *
	 * @param  null|string  $setting The setting.
	 * @param  false|string $subset If the result is an array, return the value of the defined key.
	 * @return  string|array
	 */
	public function _get( $setting = null, $subset = false ) {

		if ( is_null( $setting ) || empty( $setting ) ) {
			return '';
		}

		$settings   = self::$saved_options;
		$all_fields = Avada_Options::get_option_fields();

		if ( is_array( $settings ) && isset( $settings[ $setting ] ) ) {
			// Setting is saved so retrieve it from the db.
			$value = apply_filters( "avada_setting_get_{$setting}", $settings[ $setting ] );

			// Strip http: & https: from URLs.
			if ( isset( $all_fields[ $setting ]['type'] ) && 'media' === $all_fields[ $setting ]['type'] ) {
				if ( isset( $value['url'] ) && ! empty( $value['url'] ) ) {
					$value['url'] = str_replace( array( 'http://', 'https://' ), '//', $value['url'] );
				}
			}

			if ( $subset ) {
				// Hack for typography fields.
				if ( isset( $all_fields[ $setting ]['type'] ) && 'typography' === $all_fields[ $setting ]['type'] ) {
					if ( 'font-family' === $subset ) {
						if ( isset( $value['font-family'] ) && 'select font' === strtolower( $value['font-family'] ) ) {
							return apply_filters( "avada_setting_get_{$setting}[{$subset}]", '' );
						}
					} elseif ( 'color' === $subset ) {
						if ( isset( $value['color'] ) && ( empty( $value['color'] ) || empty( $value['color'] ) ) ) {
							// Get the default value. Colors should not be empty.
							return apply_filters( "avada_setting_get_{$setting}[{$subset}]", $this->get_default( $setting, $subset ) );
						}
					}
				}

				if ( is_array( $value ) && isset( $value[ $subset ] ) ) {
					// The subset is set so we can just return it.
					return apply_filters( "avada_setting_get_{$setting}[{$subset}]", $value[ $subset ] );
				} else {
					// If we've reached this point then the setting has not been set in the db.
					// We'll need to get the default value.
					return apply_filters( "avada_setting_get_{$setting}[{$subset}]", $this->get_default( $setting, $subset ) );
				}
			} else {
				// Hack for color & color-alpha fields.
				if ( isset( $all_fields[ $setting ]['type'] ) && in_array( $all_fields[ $setting ]['type'], array( 'color', 'color-alpha' ), true ) ) {
					if ( empty( $value ) ) {
						return apply_filters( "avada_setting_get_{$setting}[{$subset}]", $this->get_default( $setting, $subset ) );
					}
				}
				// We don't want a subset so just return the value.
				return $value;
			}
		} else {
			// If we've reached this point then the setting has not been set in the db.
			// We'll need to get the default value.
			if ( $subset ) {
				return apply_filters( "avada_setting_get_{$setting}[{$subset}]", $this->get_default( $setting, $subset ) );
			}
			return apply_filters( "avada_setting_get_{$setting}", $this->get_default( $setting ) );
		}
	}

	/**
	 * Sets the value of a single setting.
	 *
	 * @param  string                  $setting The setting.
	 * @param  string|array|bool|float $value   The value we want to set.
	 */
	public function set( $setting, $value ) {

		$settings = self::$saved_options;
		$settings[ $setting ] = $value;
		update_option( Avada::get_option_name(), $settings );

	}

	/**
	 * Gets the default value of a single setting.
	 *
	 * @param  null|string  $setting The setting.
	 * @param  false|string $subset If the result is an array, return the value of the defined key.
	 * @return  string|array
	 */
	public function get_default( $setting = null, $subset = false ) {

		if ( is_null( $setting ) || empty( $setting ) ) {
			return '';
		}

		$all_fields = Avada_Options::get_option_fields();

		if ( ! is_array( $all_fields ) || ! isset( $all_fields[ $setting ] ) || ! isset( $all_fields[ $setting ]['default'] ) ) {
			return '';
		}

		$default = $all_fields[ $setting ]['default'];

		if ( ! $subset || ! is_array( $default ) ) {
			return $default;
		}

		if ( ! isset( $default[ $subset ] ) ) {
			return '';
		}

		return $default[ $subset ];

	}

	/**
	 * Gets the option value combined with relevant description.
	 *
	 * @since	4.1
	 * @param	string $setting name of option.
	 * @param	string $subset name of subset of option.
	 * @param	string $type description of option type.
	 * @return	array  $classes Classes to apply to the sidebar including sidebar name.
	 */
	public function get_default_description( $setting = null, $subset = false, $type = null ) {

		if ( is_null( $setting ) || empty( $setting ) ) {
			return '';
		}

		if ( 'menu' !== $type ) {
			if ( ! is_array( $subset ) ) {
				$setting_value = $this->get( $setting, $subset );
			} else {
				$setting_values = array();
				foreach ( $subset as $sub ) {
					$setting_values[] = $this->get( $setting, $sub );
				}
				$setting_value = implode( ', ', $setting_values );
			}
		}

		if ( 'rollover' === $type ) {
			$link_status = $this->get( 'link_image_rollover' );
			$zoom_status = $this->get( 'zoom_image_rollover' );
			if ( $link_status && $zoom_status ) {
				$setting_value = __( 'Link & Zoom', 'Avada' );
			}
			if ( $link_status && ! $zoom_status ) {
				$setting_value = esc_attr__( 'Link', 'Avada' );
			}
			if ( ! $link_status && $zoom_status ) {
				$setting_value = esc_attr__( 'Zoom', 'Avada' );
			}
			if ( ! $link_status && ! $zoom_status ) {
				$setting_value = esc_attr__( 'No Icons', 'Avada' );
			}
		}
		if ( 'header_bg_opacity' === $setting ) {
			$setting_value = Avada_Color::new_color( $this->get( 'header_bg_color' ) )->alpha;
			$setting = 'header_bg_color';
		}
		if ( 'menu' !== $type ) {
			$setting_link  = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
		}

		switch ( $type ) {

			case 'select':
				$all_fields = Avada_Options::get_option_fields();
				if ( isset( $all_fields[ $setting ]['choices'][ $setting_value ] ) ) {
					$setting_value = $all_fields[ $setting ]['choices'][ $setting_value ];
				} else {
					$setting_value = ucwords( str_replace( '_', '', $setting_value ) );
				}
				$setting_link = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'showhide':
				$setting_value = ( 1 == $setting_value ) ? esc_html__( 'Show', 'Avada' ) : esc_html__( 'Hide', 'Avada' );
				$setting_link  = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'yesno':
				$setting_value = ( 1 == $setting_value ) ? esc_html__( 'Yes', 'Avada' ) : esc_html__( 'No', 'Avada' );
				$setting_link  = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'reverseyesno':
				$setting_value = ( 1 == $setting_value ) ? esc_html__( 'No', 'Avada' ) : esc_html__( 'Yes', 'Avada' );
				$setting_link  = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'menu':
				$menu_name = $setting;
				$locations = get_nav_menu_locations();
				$menu_id   = ( isset( $locations[ $menu_name ] ) ) ? $locations[ $menu_name ] : false;
				$menu      = ( false !== $menu_id ) ? wp_get_nav_menu_object( $menu_id ) : false;

				$setting_value = ( false !== $menu ) ? $menu->name : esc_attr__( 'undefined', 'Avada' );
				$setting_link  = '<a href="' . admin_url( 'nav-menus.php?action=locations' ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';

				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'sidebar':
				$setting_value = ucwords( str_replace( '_', '', $setting_value ) );
				$setting_link  = '<a href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer">' . $setting_value . '</a>';
				return $setting_description = sprintf( esc_html__( '  Global sidebar is currently active and will override selection with %s.', 'Avada' ), $setting_link );
				break;

			case 'range':
				return $setting_description = sprintf( esc_html__( '  Default currently set to %s.', 'Avada' ), $setting_link );
				break;

			case 'child':
				return $setting_description = sprintf( esc_html__( '  Leave empty for value set in parent options.  If that is also empty, the Theme Options value of %s will be used.', 'Avada' ), $setting_link );
				break;

			default:
				if ( '' !== $setting_value ) {
					return $setting_description = sprintf( esc_html__( '  Leave empty for default value of %s.', 'Avada' ), $setting_link );
				}
				return $setting_description = sprintf( __( '  Current no default selected. Can be set globally from the <a %s>Theme Options</a>.', 'Avada' ), 'href="' . $this->get_setting_link( $setting, $subset ) . '" target="_blank" rel="noopener noreferrer"' );
				break;
		}
	}

	/**
	 * Gets the link to the setting.
	 *
	 * @since	4.1
	 * @param	string $setting name of option.
	 * @param	string $subset name of subset of option.
	 * @return	string URL to options page with option hash appended.
	 */
	public function get_setting_link( $setting = null, $subset = false ) {

		$options_page = admin_url( 'themes.php?page=avada_options&disable_dependencies=' . $setting );
		$option_anchor = '#' . $setting;

		return $options_page . $option_anchor;
	}

	/**
	 * Gets the color scheme names as an array.
	 *
	 * @since	5.0.0
	 * @param   array $standard_schemes array to which we need to add custom color schemes.
	 * @return	array of color scheme names.
	 */
	public function get_custom_color_schemes( $standard_schemes = array() ) {

		$custom_color_schemes = self::$custom_color_schemes;
		if ( is_array( $custom_color_schemes ) ) {
			foreach ( $custom_color_schemes as $key => $color_scheme ) {
				$standard_schemes[ $color_scheme['name'] ] = 'scheme-' . $key;
			}
		}
		return $standard_schemes;
	}

	/**
	 * Gets a value from specific custom color scheme.
	 *
	 * @since	5.0.0
	 * @param   integer $scheme_id   key of custom color scheme to check.
	 * @param   string  $option_name option name to find value for.
	 * @return	array of color scheme names.
	 */
	public function get_custom_color( $scheme_id, $option_name = false ) {

		$custom_color_schemes = self::$custom_color_schemes;
		if ( $option_name ) {
			return ( isset( $custom_color_schemes[ $scheme_id ] ) ) ? $custom_color_schemes[ $scheme_id ]['values'][ $option_name ] : '';
		} else {
			return ( isset( $custom_color_schemes[ $scheme_id ] ) ) ? $custom_color_schemes[ $scheme_id ]['values'] : '';
		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
