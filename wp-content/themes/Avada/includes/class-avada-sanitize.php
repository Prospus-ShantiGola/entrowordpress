<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * A collection of sanitization methods.
 */
class Avada_Sanitize {

	/**
	 * Sanitize values like for example 10px, 30% etc.
	 *
	 * @param  string $value The value to sanitize.
	 * @return  string
	 */
	public static function size( $value ) {

		// Trim the value.
		$value = trim( $value );

		if ( in_array( $value, array( 'auto', 'inherit', 'initial' ) ) ) {
			return $value;
		}

		// Return empty if there are no numbers in the value.
		// Prevents some CSS errors.
		if ( ! preg_match( '#[0-9]#' , $value ) ) {
			return;
		}

		return self::number( $value ) . self::get_unit( $value );

	}

	/**
	 * Return the unit of a given value.
	 *
	 * @since 4.0
	 *
	 * @param  string $value A value with unit.
	 * @return string The unit of the given value.
	 */
	public static function get_unit( $value ) {

		$unit_used = '';

		// Trim the value.
		$value = trim( $value );

		// The array of valid units.
		$units = array( 'px', 'rem', 'em', '%', 'vmin', 'vmax', 'vh', 'vw', 'ex', 'cm', 'mm', 'in', 'pt', 'pc', 'ch' );

		foreach ( $units as $unit ) {

			// Find what unit we're using.
			if ( false !== strpos( $value, $unit ) ) {
				$unit_used = $unit;
				break;
			}
		}

		return $unit_used;

	}

	/**
	 * Adds a specified unit to a unitless value and keeps the value unchanged if a unit is present.
	 * A forced unit replace can also be done.
	 *
	 * @param string $value			A value like a margin setting etc., with or without unit.
	 * @param string $unit  		A unit that should be appended to unitless values.
	 * @param string $unit_handling 'add': only add $unit if $value is unitless.
	 *								'force_replace': replace the unit of $value with $unit.
	 */
	public static function get_value_with_unit( $value, $unit = 'px', $unit_handling = 'add' ) {

		$value = trim( $value );

		if ( in_array( $value, array( 'auto', 'inherit', 'initial' ) ) ) {
			return $value;
		}

		// Return empty if there are no numbers in the value.
		// Prevents some CSS errors.
		if ( ! preg_match( '#[0-9]#' , $value ) ) {
			return;
		}

		// Trim the value.
		$raw_value = self::number( $value );

		// If the value already has an unit, return the original string.
		if ( $value == $raw_value ) {
			return $raw_value . $unit;
		} elseif ( 'force_replace' == $unit_handling ) {
			return $raw_value . $unit;
		}

		return $value;
	}

	/**
	 * Sanitises a HEX value.
	 * (part of the Kirki Toolkit).
	 * The way this works is by splitting the string in 6 substrings.
	 * Each sub-string is individually sanitized, and the result is then returned.
	 *
	 * @param string $color The hex value of a color.
	 * @return string
	 */
	public static function hex( $color ) {
		return Avada_Color::new_color( $color )->to_css( 'hex' );
	}

	/**
	 * Sanitizes an rgba color value.
	 * (part of the Kirki Toolkit).
	 *
	 * @param  string $value The value to sanitize.
	 * @return  string
	 */
	public static function rgba( $value ) {
		return Avada_Color::new_color( $value )->to_css( 'rgba' );
	}

	/**
	 * Sanitize colors.
	 * (part of the Kirki Toolkit).
	 * Determine if the current value is a hex or an rgba color and call the appropriate method.
	 *
	 * @since 0.8.5
	 *
	 * @param  string $value   string  hex or rgba color.
	 * @return string
	 */
	public static function color( $value ) {
		$color_obj = Avada_Color::new_color( $value );
		$mode      = ( is_array( $value ) ) ? 'rgba' : $color_obj->mode;
		return $color_obj->to_css( $mode );
	}

	/**
	 * Gets the rgba value of the $hex color.
	 * (part of the Kirki Toolkit).
	 *
	 * @param string $hex     The hex value of a color.
	 * @param int    $opacity Opacity level (1-100).
	 * @return string
	 */
	public static function get_rgba( $hex = '#fff', $opacity = 100 ) {
		$color_obj = Avada_Color::new_color( $hex );
		$alpha     = ( 1 < $opacity ) ? $opacity / 100 : $opacity;
		return $color_obj->get_new( 'alpha', $alpha )->to_css( 'rgba' );
	}

	/**
	 * Gets the rgb value of the $hex color.
	 * (part of the Kirki Toolkit).
	 *
	 * @param   string  $hex     The hex value of a color.
	 * @param   boolean $implode Whether we want to implode the values or not.
	 * @return  array|string
	 */
	public static function get_rgb( $hex, $implode = false ) {
		$color_obj = Avada_Color::new_color( $hex );
		if ( $implode ) {
			return $color_obj->to_css( 'rgb' );
		}
		return array(
			$color_obj->red,
			$color_obj->green,
			$color_obj->blue,
		);
	}


	/**
	 * Strips the alpha value from an RGBA color string.
	 *
	 * @param 	string $rgba	The RGBA color string.
	 * @return  string			The corresponding RGB string.
	 */
	public static function rgba_to_rgb( $rgba ) {
		$color_obj = Avada_Color::new_color( $rgba );
		return $color_obj->to_css( 'rgb' );
	}

	/**
	 * Properly escape some characters in image URLs so that they may be properly used in CSS.
	 * From W3C:
	 * > Some characters appearing in an unquoted URI,
	 * > such as parentheses, white space characters, single quotes (') and double quotes ("),
	 * > must be escaped with a backslash so that the resulting URI value is a URI token: '\(', '\)'.
	 *
	 * @param  string $url The URL to modify.
	 */
	public static function css_asset_url( $url ) {

		$url = esc_url_raw( $url );

		$url = str_replace( '(', '\(', $url );
		$url = str_replace( ')', '\)', $url );
		$url = str_replace( '"', '\"', $url );
		$url = str_replace( ' ', '\ ', $url );
		$url = str_replace( "'", "\'", $url );

		return $url;

	}

	/**
	 * Removes the scheme of the passed URL to fit the current page.
	 *
	 * @param string $url The URL that needs sanitation.
	 * @return string     Full URL without scheme.
	 */
	public static function get_url_with_correct_scheme( $url ) {

		$url = str_replace( 'http://', '//', str_replace( 'https://', '//', $url ) );

		return $url;
	}

	/**
	 * Sanitizes a number value.
	 *
	 * @param string|int|float $value The value to sanitize.
	 * @return float|int
	 */
	public static function number( $value ) {
		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}


	/**
	 * Orders an array like another one with the same keys.
	 *
	 * @since 4.0
	 *
	 * @param array $to_be_ordered The array that should be ordered.
	 * @param array $order_like The array that should be used to order $to_be_ordered.
	 *
	 * @return array The correctly ordered version of $to_be_ordered.
	 */
	public static function order_array_like_array( array $to_be_ordered, array $order_like ) {
		$ordered = array();

		foreach ( $order_like as $key => $value ) {
			if ( array_key_exists( $key, $to_be_ordered ) ) {
				$ordered[ $key ] = $to_be_ordered[ $key ];
				unset( $to_be_ordered[ $key ] );
			}
		}

		return $ordered + $to_be_ordered;
	}

	/**
	 * Sanitizes the envato token & refreshes the transients.
	 *
	 * @access public
	 * @param string $value The token.
	 * @return string
	 */
	public static function envato_token( $value ) {
		delete_transient( 'avada_is_envato_valid' );
		if ( is_string( $value ) ) {
			return trim( $value );
		}
		return '';
	}
}
