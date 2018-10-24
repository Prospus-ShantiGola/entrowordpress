<?php
/**
 * Shortcodes helper functions.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// @codingStandardsIgnoreStart
global $fusion_builder_elements, $fusion_builder_multi_elements, $fusion_builder_enabled_elements, $parallax_id;
$parallax_id = 1;
// @codingStandardsIgnoreEnd

// Get builder options.
$fusion_builder_settings = get_option( 'fusion_builder_settings' );
$fusion_builder_enabled_elements = ( isset( $fusion_builder_settings['fusion_elements'] ) ) ? $fusion_builder_settings['fusion_elements'] : '';
$fusion_builder_enabled_elements = apply_filters( 'fusion_builder_enabled_elements', $fusion_builder_enabled_elements );

// Stores an array of all registered elements.
$fusion_builder_elements = array();

// Stores an array of all advanced elements.
$fusion_builder_multi_elements = array();

/**
 * Add an element to $fusion_builder_elements array.
 *
 * @param array $module The element we're loading.
 */
function fusion_builder_map( $module ) {
	global $fusion_builder_elements, $fusion_builder_enabled_elements, $fusion_builder_multi_elements, $all_fusion_builder_elements;

	$shortcode    = $module['shortcode'];
	$ignored_atts = array();

	if ( isset( $module['params'] ) ) {

		// Create an array of descriptions.
		foreach ( $module['params'] as $key => $param ) {

			// Allow filtering of description.
			if ( isset( $param['description'] ) ) {
				$param['description'] = apply_filters( 'fusion_builder_option_description', $param['description'], $shortcode, $param['param_name'] );
			}

			// Allow filtering of default.
			$current_default = ( isset( $param['default'] ) ) ? $param['default'] : '';
			$new_default = apply_filters( 'fusion_builder_option_default', $current_default, $shortcode, $param['param_name'] );
			if ( '' !== $new_default ) {
				$param['default'] = $new_default;
			}

			// Allow filtering of value.
			$current_value = ( isset( $param['value'] ) ) ? $param['value'] : '';
			$new_value = apply_filters( 'fusion_builder_option_value', $current_value, $shortcode, $param['param_name'] );
			if ( '' !== $new_value ) {
				$param['value'] = $new_value;
			}

			// Allow filtering of dependency.
			$current_dependency = ( isset( $param['dependency'] ) ) ? $param['dependency'] : '';
			$new_dependency = apply_filters( 'fusion_builder_option_dependency', $current_dependency, $shortcode, $param['param_name'] );
			if ( '' !== $new_dependency ) {
				$param['dependency'] = $new_dependency;
			}

			// Ignore attributes in the shortcode if 'remove_from_atts' is true.
			if ( isset( $param['remove_from_atts'] ) && true == $param['remove_from_atts'] ) {
				$ignored_atts[] = $param['param_name'];
			}

			// Set param key as param_name.
			$params[ $param['param_name'] ] = $param;
		}
		if ( '0' === FusionBuilder::get_theme_option( 'dependencies_status' ) ) {
			foreach ( $params as $key => $value ) {
				if ( isset( $params[ $key ]['dependency'] ) && ! empty( $params[ $key ]['dependency'] ) ) {
					unset( $params[ $key ]['dependency'] );
				}
			}
		}
		$module['params'] = $params;
		$module['remove_from_atts'] = $ignored_atts;
	}

	// Create array of unfiltered elements.
	$all_fusion_builder_elements[ $shortcode ] = $module;

	// Add multi element to an array.
	if ( isset( $module['multi'] ) && 'multi_element_parent' == $module['multi'] && isset( $module['element_child'] ) ) {
		$fusion_builder_multi_elements[ $shortcode ] = $module['element_child'];
	}

	// Remove fusion slider element if disabled from theme options.
	if ( 'fusion_fusionslider' == $shortcode && ! FusionBuilder::get_theme_option( 'status_fusion_slider' ) ) {
		unset( $all_fusion_builder_elements[ $shortcode ] );
	}

	// Remove font awesome element if disabled from theme options.
	if ( 'fusion_fontawesome' == $shortcode && ! FusionBuilder::get_theme_option( 'status_fontawesome' ) ) {
		unset( $all_fusion_builder_elements[ $shortcode ] );
	}
}

/**
 * Filter available elements with enabled elements
 */
function fusion_builder_filter_available_elements() {
	global $fusion_builder_enabled_elements, $all_fusion_builder_elements, $fusion_builder_multi_elements;

	// If settings page was not saved, all elements are enabled.
	if ( '' === $fusion_builder_enabled_elements ) {
		$fusion_builder_enabled_elements = array_keys( $all_fusion_builder_elements );
	} else {
		// Add required shortcodes to enabled elements array.
		$fusion_builder_enabled_elements[] = 'fusion_builder_container';
		$fusion_builder_enabled_elements[] = 'fusion_builder_row';
		$fusion_builder_enabled_elements[] = 'fusion_builder_row_inner';
		$fusion_builder_enabled_elements[] = 'fusion_builder_column_inner';
		$fusion_builder_enabled_elements[] = 'fusion_builder_column';
		$fusion_builder_enabled_elements[] = 'fusion_builder_blank_page';
	}

	foreach ( $all_fusion_builder_elements as $module ) {
		// Get shortcode name.
		$shortcode = $module['shortcode'];

		// Check if its a multi element child.
		$multi_parent = array_search( $shortcode, $fusion_builder_multi_elements );

		if ( $multi_parent ) {
			if ( in_array( $multi_parent, $fusion_builder_enabled_elements ) ) {
				$fusion_builder_enabled_elements[] = $shortcode;
			}
		}

		// Add available elements to an array.
		if ( in_array( $shortcode, $fusion_builder_enabled_elements ) ) {

			$fusion_builder_elements[ $shortcode ] = $module;

		} else {
			// If parent shortcode is removed, also make sure to remove child shortcode.
			if ( isset( $module['multi'] ) && 'multi_element_parent' == $module['multi'] && isset( $module['element_child'] ) ) {

				remove_shortcode( $module['element_child'] );

			}

			remove_shortcode( $shortcode );
		}
	}

	return $fusion_builder_elements;

}

/**
 * Enqueue element frontend assets.
 */
function fusion_load_element_frontend_assets() {
	global $fusion_builder_elements;

	foreach ( $fusion_builder_elements as $module ) {

		// Load element front end js.
		if ( ! empty( $module['front_enqueue_js'] ) ) {
			wp_enqueue_script( $module['shortcode'], $module['front_enqueue_js'], '', FUSION_BUILDER_VERSION, true ); }

		// Load element front end css.
		if ( ! empty( $module['front_enqueue_css'] ) ) {
			wp_enqueue_style( $module['shortcode'], $module['front_enqueue_css'], array(), FUSION_BUILDER_VERSION ); }
	}
}
add_action( 'wp_enqueue_scripts', 'fusion_load_element_frontend_assets' );
