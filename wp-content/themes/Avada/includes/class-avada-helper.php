<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Various helper fmethods for Avada.
 *
 * @since 3.8
 */
class Avada_Helper {

	/**
	 * Return the value of an echo.
	 * example: Avada_Helper::get_echo( 'function' );
	 *
	 * @param  string       $function The function name.
	 * @param  string|array $args The arguments we want to pass to the function.
	 * @return  string
	 */
	public static function get_echo( $function, $args = '' ) {

		// Early exit if function does not exist.
		if ( ! function_exists( $function ) ) {
			return;
		}

		ob_start();
		$function( $args );
		$get_echo = ob_get_clean();
		return $get_echo;

	}

	/**
	 * Modify the slider name for compatibility.
	 *
	 * @static
	 * @access  public
	 * @param  string $name The slider name.
	 * @return  string
	 */
	public static function slider_name( $name ) {

		$type = '';

		switch ( $name ) {
			case 'layer':
				$type = 'slider';
				break;
			case 'flex':
				$type = 'wooslider';
				break;
			case 'rev':
				$type = 'revslider';
				break;
			case 'elastic':
				$type = 'elasticslider';
				break;
		}

		return $type;

	}

	/**
	 * Given a post ID returns the slider type used.
	 *
	 * @static
	 * @access  public
	 * @param  int $post_id The post ID.
	 * @return  string
	 */
	public static function get_slider_type( $post_id ) {
		return get_post_meta( $post_id, 'pyre_slider_type', true );
	}

	/**
	 * Convert percent width to pixels.
	 *
	 * @static
	 * @access  public
	 * @param  int|float|string $percent   The percentage.
	 * @param  int|string       $max_width The screen max-width.
	 * @return  int
	 */
	public static function percent_to_pixels( $percent, $max_width = 1920 ) {
		return intval( ( intval( $percent ) * $max_width ) / 100 );
	}

	/**
	 * Converts ems to pixels.
	 *
	 * @static
	 * @access  public
	 * @param  int|string $ems The number of ems.
	 * @param  int|string $font_size The base font-size for conversions.
	 * @return  int
	 */
	public static function ems_to_pixels( $ems, $font_size = 14 ) {
		return intval( Avada_Sanitize::number( $ems ) * $font_size );
	}

	/**
	 * Merges 2 CSS values to pixels.
	 *
	 * @static
	 * @access  public
	 * @param array $values The CSS values we want to merge.
	 * @return  int In pixels.
	 */
	public static function merge_to_pixels( $values = array() ) {
		$final_value = 0;
		foreach ( $values as $value ) {
			if ( false !== strpos( $value, '%' ) ) {
				$value = self::percent_to_pixels( $value, 1600 );
			} elseif ( false !== strpos( $value, 'em' ) ) {
				$value = self::ems_to_pixels( $value );
			} else {
				$value = intval( $value );
			}
			$final_value = $final_value + $value;
		}
		return $final_value;
	}

	/**
	 * Converts a PHP version to 3-part.
	 *
	 * @static
	 * @access public
	 * @param  string $ver The verion number.
	 * @return string
	 */
	public static function normalize_version( $ver ) {
		if ( ! is_string( $ver ) ) {
			return $ver;
		}
		$ver_parts = explode( '.', $ver );
		$count     = count( $ver_parts );
		// Keep only the 1st 3 parts if longer.
		if ( 3 < $count ) {
			return absint( $ver_parts[0] ) . '.' . absint( $ver_parts[1] ) . '.' . absint( $ver_parts[2] );
		}
		// If a single digit, then append '.0.0'.
		if ( 1 === $count ) {
			return absint( $ver_parts[0] ) . '.0.0';
		}
		// If 2 digits, append '.0'.
		if ( 2 === $count ) {
			return absint( $ver_parts[0] ) . '.' . absint( $ver_parts[1] ) . '.0';
		}
		return $ver;
	}

	/**
	 * Check if we're in an events archive.
	 *
	 * @return bool
	 */
	public static function is_events_archive() {
		if ( function_exists( 'tribe_is_event' ) ) {
			return ( tribe_is_event() && is_archive() );
		}
		return false;
	}

	/**
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @static
	 * @access public
	 * @since 3.8.0
	 * @param string $size The size.
	 * @return int
	 */
	public static function let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}

	/**
	 * Checks if currently an admin post screen is viewed.
	 *
	 * @static
	 * @access public
	 * @since 5.0.0
	 * @param string $type The type of the post screen.
	 * @return bool true only on an admin post screen.
	 */
	public static function is_post_admin_screen( $type = null ) {
		global $pagenow;

		// If not in backend, return early.
		if ( ! is_admin() ) {
			return false;
		}

		// Edit post screen.
		if ( 'edit' === $type ) {
			return in_array( $pagenow, array( 'post.php' ) );
			// New post screen.
		} elseif ( 'new' === $type ) {
			return in_array( $pagenow, array( 'post-new.php' ) );
			// Edit or new post screen.
		} else {
			return in_array( $pagenow, array( 'post.php', 'post-new.php', 'admin-ajax.php' ) );
		}

	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
