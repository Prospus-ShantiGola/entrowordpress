<?php
/**
 * Fusion Builder helper functions.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Fix shortcode content. Remove p and br tags.
 *
 * @since 1.0
 * @param string $content The content.
 * @return string
 */
function fusion_builder_fix_shortcodes( $content ) {
	$replace_tags_from_to = array(
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
		"<br />\n[" => '[',
	);

	return strtr( $content, $replace_tags_from_to );
}

/**
 * Get video prodiver.
 *
 * @since 1.0
 * @param string $video_string The video as entered by the user.
 * @return array
 */
function fusion_builder_get_video_provider( $video_string ) {

	$video_string = trim( $video_string );

	// Check for YouTube.
	$video_id = false;
	if ( preg_match( '/youtube\.com\/watch\?v=([^\&\?\/]+)/', $video_string, $id ) ) {
		if ( count( $id > 1 ) ) {
			$video_id = $id[1];
		}
	} else if ( preg_match( '/youtube\.com\/embed\/([^\&\?\/]+)/', $video_string, $id ) ) {
		if ( count( $id > 1 ) ) {
			$video_id = $id[1];
		}
	} else if ( preg_match( '/youtube\.com\/v\/([^\&\?\/]+)/', $video_string, $id ) ) {
		if ( count( $id > 1 ) ) {
			$video_id = $id[1];
		}
	} else if ( preg_match( '/youtu\.be\/([^\&\?\/]+)/', $video_string, $id ) ) {
		if ( count( $id > 1 ) ) {
			$video_id = $id[1];
		}
	}

	if ( ! empty( $video_id ) ) {
		return array(
			'type' => 'youtube',
			'id'   => $video_id,
		);
	}

	// Check for Vimeo.
	if ( preg_match( '/vimeo\.com\/(\w*\/)*(\d+)/', $video_string, $id ) ) {
		if ( count( $id > 1 ) ) {
			$video_id = $id[ count( $id ) - 1 ];
		}
	}

	if ( ! empty( $video_id ) ) {
		return array(
			'type' => 'vimeo',
			'id'   => $video_id,
		);
	}

	// Non-URL form.
	if ( preg_match( '/^\d+$/', $video_string ) ) {
		return array(
			'type' => 'vimeo',
			'id'   => $video_string,
		);
	}

	return array(
		'type' => 'youtube',
		'id'   => $video_string,
	);
}

/**
 * Create animation data and class.
 *
 * @since 1.0
 * @param string $animation_type      The animation type.
 * @param string $animation_direction Animation direction.
 * @param string $animation_speed     The animation speed (in miliseconds).
 * @param string $animation_offset    The animation offset.
 */
function fusion_builder_animation_data( $animation_type = '', $animation_direction = '', $animation_speed = '', $animation_offset = '' ) {

	$animation = array();
	$animation['data'] = '';
	$animation['class'] = '';

	if ( ! empty( $animation_type ) ) {

		if ( ! in_array( $animation_type, array( 'bounce', 'flase', 'shake', 'rubberBand' ), true ) ) {
			$animation_type = sprintf( '%1$sIn%2$s', $animation_type, ucfirst( $animation_direction ) );
		}

		$animation['data'] .= ' data-animationType=' . esc_attr( $animation_type );
		$animation['data'] .= ' data-animationDuration=' . esc_attr( $animation_speed );
		$animation['class'] = ' fusion-animated';

		if ( $animation_offset ) {
			if ( 'top-into-view' === $animation_offset ) {
				$offset = '100%';
			} else if ( 'top-mid-of-view' === $animation_offset ) {
				$offset = '50%';
			} else {
				$offset = $animation_offset;
			}
			$animation['data'] .= ' data-animationOffset=' . esc_attr( $offset );
		}
	}

	return $animation;
}

/**
 * List of available animation types.
 *
 * @since 1.0
 */
function fusion_builder_available_animations() {

	$animations = array(
		esc_attr__( 'None', 'fusion-builder' )       => '',
		esc_attr__( 'Bounce', 'fusion-builder' )     => 'bounce',
		esc_attr__( 'Fade', 'fusion-builder' )       => 'fade',
		esc_attr__( 'Flash', 'fusion-builder' )      => 'flash',
		esc_attr__( 'Rubberband', 'fusion-builder' ) => 'rubberBand',
		esc_attr__( 'Shake', 'fusion-builder' )      => 'shake',
		esc_attr__( 'Slide', 'fusion-builder' )      => 'slide',
		esc_attr__( 'Zoom', 'fusion-builder' )       => 'zoom',
	);

	return $animations;
}

/**
 * Return accepted value range.
 *
 * @since 1.0
 * @param int $from Lower value.
 * @param int $to   Higher value.
 */
function fusion_builder_value_range( $from, $to ) {
	$i = $from;
	$value = array();

	while ( $i <= $to ) {
		$value[ strval( $i ) ] = strval( $i );
		$i++;
	}

	return $value;
}

/**
 * Check value type ( % or px ).
 *
 * @since 1.0
 * @param string $value The value we'll be checking.
 * @return string
 */
function fusion_builder_check_value( $value ) {
	if ( strpos( $value, '%' ) === false && strpos( $value, 'px' ) === false ) {
		$value = $value . 'px';
	}
	return $value;
}

/**
 * Returns array of layerslider slide groups.
 *
 * @since 1.0
 * @return array slide keys array.
 */
function fusion_builder_get_layerslider_slides() {
	global $wpdb;
	$slides_array['Select a slider'] = 'fusion_0';
	// Table name.
	$table_name = $wpdb->prefix . 'layerslider';

	// Check if table exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
		// Get sliders.
		$sliders = $wpdb->get_results( "SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY date_c ASC" );

		if ( ! empty( $sliders ) ) {
			foreach ( $sliders as $key => $item ) {
				$slides[ $item->id ] = '';
			}
		}

		if ( isset( $slides ) && $slides ) {
			foreach ( $sliders as $slide ) {
				$slides_array[ $slide->name . ' #' . $slide->id ] = $slide->id;
			}
		}
	}

	return $slides_array;
}

/**
 * Returns array of rev slider slide groups.
 *
 * @since 1.0
 * @return array slide keys array.
 */
function fusion_builder_get_revslider_slides() {

	global $wpdb;
	$revsliders['Select a slider'] = 'fusion_0';
	$table_name = $wpdb->prefix . 'revslider_sliders';
	// Check if table exists.
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
		if ( function_exists( 'rev_slider_shortcode' ) ) {
			$get_sliders = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders' );
			if ( $get_sliders ) {
				foreach ( $get_sliders as $slider ) {
					$revsliders[ $slider->title ] = $slider->alias;
				}
			}
		}
	}

	return $revsliders;
}

/**
 * Taxonomies.
 *
 * @since 1.0
 * @param string $taxonomy           The taxonomy.
 * @param bool   $empty_choice       If this is an empty choice or not.
 * @param string $empty_choice_label The label for empty choices.
 * @return array
 */
function fusion_builder_shortcodes_categories( $taxonomy, $empty_choice = false, $empty_choice_label = false ) {

	if ( ! $empty_choice_label ) {
		$empty_choice_label = esc_attr__( 'Default', 'fusion-builder' );
	}
	$post_categories = array();

	if ( $empty_choice ) {
		$post_categories[ $empty_choice_label ] = '';
	}

	$get_categories = get_categories( 'hide_empty=0&taxonomy=' . $taxonomy );

	if ( ! is_wp_error( $get_categories ) ) {

		if ( $get_categories && is_array( $get_categories ) ) {
			foreach ( $get_categories as $cat ) {
				if ( array_key_exists( 'slug', $cat ) &&
					array_key_exists( 'name', $cat )
				) {
					$label = $cat->name . ( ( array_key_exists( 'count', $cat ) ) ? ' (' . $cat->count . ')' : '' );
					$post_categories[ $label ] = urldecode( $cat->slug );
				}
			}
		}

		if ( isset( $post_categories ) ) {
			return $post_categories;
		}
	}
}

/**
 * Column combinations.
 *
 * @since  1.0
 * @param  string $module module being triggered from.
 * @return string html output for column selection.
 */
function fusion_builder_column_layouts( $module = '' ) {

	$layouts = apply_filters( 'fusion_builder_column_layouts', array(
		array(
			'layout'   => array( '' ),
			'keywords' => esc_attr__( 'empty blank', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_1' ),
			'keywords' => esc_attr__( 'full one 1', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_2' ),
			'keywords' => esc_attr__( 'two half 2 1/2', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','1_3','1_3' ),
			'keywords' => esc_attr__( 'third thee 3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_4','1_4' ),
			'keywords' => esc_attr__( 'four fourth 4 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_3','1_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','2_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','3_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_4','1_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_4','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_2' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_2','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','4_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '4_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_5','2_5' ),
			'keywords' => esc_attr__( 'three fith two fifth 3/5 2/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_5','3_5' ),
			'keywords' => esc_attr__( 'two fifth three fifth 2/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','3_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','3_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_2' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','2_3','1_6' ),
			'keywords' => esc_attr__( 'one two six sixth 2/3 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','1_5','1_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one six sixth 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '5_6' ),
			'keywords' => esc_attr__( 'five sixth 5/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '4_5' ),
			'keywords' => esc_attr__( 'four fifth 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_4' ),
			'keywords' => esc_attr__( 'three fourth 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_3' ),
			'keywords' => esc_attr__( 'two third 2/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_5' ),
			'keywords' => esc_attr__( 'three fifth 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2' ),
			'keywords' => esc_attr__( 'one half two 1/2', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_5' ),
			'keywords' => esc_attr__( 'two fifth 2/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3' ),
			'keywords' => esc_attr__( 'one third three 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6' ),
			'keywords' => esc_attr__( 'one six sixth 1/6', 'fusion-builder' ),
		),
	) );

	// If being viewed on a section, remove empty from layout options.
	if ( ! isset( $module ) || 'container' !== $module ) {
		unset( $layouts[0] );
	}

	$html = '<ul class="fusion-builder-column-layouts fusion-builder-all-modules">';
	foreach ( $layouts as $layout ) {
		$html .= '<li data-layout="' . implode( ',', $layout['layout'] ) . '">';
		$html .= '<h4 class="fusion_module_title" style="display:none;">' . $layout['keywords'] . '</h4>';

		foreach ( $layout['layout'] as $size ) {
			$html .= '<div class="fusion_builder_layout_column fusion_builder_column_layout_' . $size . '">' . preg_replace( '/[_]+/', '/', $size ) . '</div>';
		}
		$html .= '</li>';
	}
	$html .= '</ul>';

	return $html;
}

/**
 * Nested column combinations.
 *
 * @since 1.0
 */
function fusion_builder_inner_column_layouts() {

	$layouts = apply_filters( 'fusion_builder_inner_column_layouts', array(

		array(
			'layout'   => array( '1_1' ),
			'keywords' => esc_attr__( 'full one 1', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_2' ),
			'keywords' => esc_attr__( 'two half 2 1/2', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','1_3','1_3' ),
			'keywords' => esc_attr__( 'third thee 3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_4','1_4' ),
			'keywords' => esc_attr__( 'four fourth 4 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_3','1_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','2_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','3_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_4','1_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_4','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_2' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_2','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','4_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '4_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_5','2_5' ),
			'keywords' => esc_attr__( 'three fith two fifth 3/5 2/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_5','3_5' ),
			'keywords' => esc_attr__( 'two fifth three fifth 2/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','3_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','3_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_2' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','2_3','1_6' ),
			'keywords' => esc_attr__( 'one two six sixth 2/3 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','1_5','1_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one six sixth 1/6', 'fusion-builder' ),
		),
	) );

	$html = '<ul class="fusion-builder-column-layouts fusion-builder-all-modules">';
	foreach ( $layouts as $layout ) {
		$html .= '<li data-layout="' . implode( ',', $layout['layout'] ) . '">';
		$html .= '<h4 class="fusion_module_title" style="display:none;">' . $layout['keywords'] . '</h4>';

		foreach ( $layout['layout'] as $size ) {
			$html .= '<div class="fusion_builder_layout_column fusion_builder_column_layout_' . $size . '">' . preg_replace( '/[_]+/', '/', $size ) . '</div>';
		}
		$html .= '</li>';
	}
	$html .= '</ul>';

	return $html;
}

/**
 * Column combinations.
 *
 * @since 1.0
 */
function fusion_builder_generator_column_layouts() {

	$layouts = apply_filters( 'fusion_builder_generators_column_layouts', array(
		array(
			'layout'   => array( '1_1' ),
			'keywords' => esc_attr__( 'full one 1', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_2' ),
			'keywords' => esc_attr__( 'two half 2 1/2', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','1_3','1_3' ),
			'keywords' => esc_attr__( 'third thee 3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_4','1_4' ),
			'keywords' => esc_attr__( 'four fourth 4 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_3','1_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_3','2_3' ),
			'keywords' => esc_attr__( 'two third 2/3 1/3', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','3_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_4','1_4' ),
			'keywords' => esc_attr__( 'one four fourth 1/4 3/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_4','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_4','1_2' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_4','1_2','1_4' ),
			'keywords' => esc_attr__( 'half one four fourth 1/2 1/4', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','4_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '4_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5 4/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '3_5','2_5' ),
			'keywords' => esc_attr__( 'three fith two fifth 3/5 2/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '2_5','3_5' ),
			'keywords' => esc_attr__( 'two fifth three fifth 2/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','3_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','3_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth three 1/5 3/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_2','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_2' ),
			'keywords' => esc_attr__( 'one half six sixth 1/2 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','2_3','1_6' ),
			'keywords' => esc_attr__( 'one two six sixth 2/3 1/6', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_5','1_5','1_5','1_5','1_5' ),
			'keywords' => esc_attr__( 'one five fifth 1/5', 'fusion-builder' ),
		),
		array(
			'layout'   => array( '1_6','1_6','1_6','1_6','1_6','1_6' ),
			'keywords' => esc_attr__( 'one six sixth 1/6', 'fusion-builder' ),
		),
	) );

	$html = '<ul class="fusion-builder-column-layouts">';

	foreach ( $layouts as $layout ) {
		$html .= '<li class="generator-column" data-layout="' . implode( ',', $layout['layout'] ) . '">';
		$html .= '<h4 class="fusion_module_title" style="display:none;">' . $layout['keywords'] . '</h4>';

		foreach ( $layout['layout'] as $size ) {
			$html .= '<div class="fusion_builder_layout_column fusion_builder_column_layout_' . $size . '">' . preg_replace( '/[_]+/', '/', $size ) . '</div>';
		}
		$html .= '</li>';
	}
	$html .= '</ul>';

	return $html;
}

/**
 * Save the metadata.
 *
 * @since 1.0
 * @param int    $post_id The poist-ID.
 * @param object $post    The Post object.
 */
function fusion_builder_save_meta( $post_id, $post ) {

	// Verify the nonce before proceeding.
	if ( ! isset( $_POST['fusion_builder_nonce'] ) || ! wp_verify_nonce( $_POST['fusion_builder_nonce'], 'fusion_builder_template' ) ) {

		return $post_id;
	}

	// Get the post type object.
	$post_type = get_post_type_object( $post->post_type );

	// Check if the current user has permission to edit the post.
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// If more than one set to an array.
	$names = array( '_fusion_builder_custom_css' );

	foreach ( $names as $name ) {

		// Get the posted data and sanitize it for use as an HTML class.
		if ( '_fusion_builder_custom_css' === $name ) {
			// @codingStandardsIgnoreStart
			$new_meta_value = ( isset( $_POST[ $name ] ) ? $_POST[ $name ] : '' );
			// @codingStandardsIgnoreStop
		} else {
			// @codingStandardsIgnoreStart
			$new_meta_value = ( isset( $_POST[ $name ] ) ? sanitize_html_class( $_POST[ $name ] ) : '' );
			// @codingStandardsIgnoreStop
		}

		// Get the meta key.
		$meta_key = $name;

		// Get the meta value of the custom field key.
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		// If a new meta value was added and there was no previous value, add it.
		if ( $new_meta_value && '' == $meta_value ) {
			add_post_meta( $post_id, $meta_key, $new_meta_value, true ); } // If the new meta value does not match the old value, update it.
		elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value ); } // If there is no new meta value but an old value exists, delete it.
		elseif ( '' == $new_meta_value && $meta_value ) {
			delete_post_meta( $post_id, $meta_key, $meta_value ); }
	}
}
add_action( 'save_post', 'fusion_builder_save_meta', 10, 2 );

/**
 * Print custom CSS code.
 *
 * @since 1.0
 */
function fusion_builder_custom_css() {
	global $post;

	// Early exit if $post is not defined
	if ( is_null( $post ) ) {
		return;
	}

	$saved_custom_css = esc_attr( get_post_meta( $post->ID, '_fusion_builder_custom_css', true ) );

	if ( isset( $saved_custom_css ) && '' != $saved_custom_css ) : ?>
		<style type="text/css"><?php echo stripslashes_deep( $saved_custom_css ); ?></style>
	<?php endif;

}
add_action( 'wp_head', 'fusion_builder_custom_css', 11 );

/**
 * Fusion builder text strings.
 *
 * @since 1.0
 */
function fusion_builder_textdomain_strings() {

	$text_strings = array(

		'custom_css'                                  => esc_attr__( 'Custom CSS', 'fusion-builder' ),
		'builder'                                     => esc_attr__( 'Builder', 'fusion-builder' ),
		'library'                                     => esc_attr__( 'Library', 'fusion-builder' ),
		'add_css_code_here'                           => esc_attr__( 'Add your CSS code here...', 'fusion-builder' ),
		'delete_page_layout'                          => esc_attr__( 'Delete page layout', 'fusion-builder' ),
		'undo'                                        => esc_attr__( 'Undo', 'fusion-builder' ),
		'redo'                                        => esc_attr__( 'Redo', 'fusion-builder' ),
		'save'                                        => esc_attr__( 'Save', 'fusion-builder' ),
		'delete_item'                                 => esc_attr__( 'Delete item', 'fusion-builder' ),
		'clone_item'                                  => esc_attr__( 'Clone item', 'fusion-builder' ),
		'edit_item'                                   => esc_attr__( 'Edit item', 'fusion-builder' ),
		'full_width_section'                          => esc_attr__( 'Container', 'fusion-builder' ),
		'section_settings'                            => esc_attr__( 'Container Settings', 'fusion-builder' ),
		'insert_section'                              => esc_attr__( 'Insert Container', 'fusion-builder' ),
		'clone_section'                               => esc_attr__( 'Clone Container', 'fusion-builder' ),
		'save_section'                                => esc_attr__( 'Save Container', 'fusion-builder' ),
		'delete_section'                              => esc_attr__( 'Delete Container', 'fusion-builder' ),
		'builder_sections'                            => esc_attr__( 'Builder Containers', 'fusion-builder' ),
		'click_to_toggle'                             => esc_attr__( 'Click to toggle', 'fusion-builder' ),
		'save_custom_section'                         => esc_attr__( 'Save Custom Container', 'fusion-builder' ),
		'save_custom_template'                        => esc_attr__( 'Save Custom Template', 'fusion-builder' ),
		'save_custom_section_info'                    => esc_attr__( 'Custom containers will be stored and managed on the Library tab', 'fusion-builder' ),
		'enter_name'                                  => esc_attr__( 'Enter Name...', 'fusion-builder' ),
		'column'                                      => esc_attr__( 'Column', 'fusion-builder' ),
		'columns'                                     => esc_attr__( 'Columns', 'fusion-builder' ),
		'resize_column'                               => esc_attr__( 'Resize column', 'fusion-builder' ),
		'resized_column'                              => esc_attr__( 'Resized Column to', 'fusion-builder' ),
		'column_library'                             => esc_attr__( 'Column settings', 'fusion-builder' ),
		'clone_column'                                => esc_attr__( 'Clone column', 'fusion-builder' ),
		'save_column'                                 => esc_attr__( 'Save column', 'fusion-builder' ),
		'delete_column'                               => esc_attr__( 'Delete column', 'fusion-builder' ),
		'delete_row'                                  => esc_attr__( 'Delete row', 'fusion-builder' ),
		'clone_column'                                => esc_attr__( 'Clone column', 'fusion-builder' ),
		'save_custom_column'                          => esc_attr__( 'Save Custom Column', 'fusion-builder' ),
		'save_custom_column_info'                     => esc_attr__( 'Custom elements will be stored and managed on the Library tab', 'fusion-builder' ),
		'add_element'                                 => esc_attr__( 'Add element', 'fusion-builder' ),
		'element'                                     => esc_attr__( 'Element', 'fusion-builder' ),
		'insert_columns'                              => esc_attr__( 'Insert Columns', 'fusion-builder' ),
		'search_elements'                             => esc_attr__( 'Search elements', 'fusion-builder' ),
		'builder_columns'                             => esc_attr__( 'Builder Columns', 'fusion-builder' ),
		'library_columns'                             => esc_attr__( 'Library Columns', 'fusion-builder' ),
		'library_sections'                            => esc_attr__( 'Library Containers', 'fusion-builder' ),
		'cancel'                                      => esc_attr__( 'Cancel', 'fusion-builder' ),
		'select_element'                              => esc_attr__( 'Select Element', 'fusion-builder' ),
		'builder_elements'                            => esc_attr__( 'Builder Elements', 'fusion-builder' ),
		'library_elements'                            => esc_attr__( 'Library Elements', 'fusion-builder' ),
		'inner_columns'                               => esc_attr__( 'Nested Columns', 'fusion-builder' ),
		'element_settings'                            => esc_attr__( 'Element Settings', 'fusion-builder' ),
		'clone_element'                               => esc_attr__( 'Clone Element', 'fusion-builder' ),
		'save_element'                                => esc_attr__( 'Save Element', 'fusion-builder' ),
		'delete_element'                              => esc_attr__( 'Delete Element', 'fusion-builder' ),
		'save_custom_element'                         => esc_attr__( 'Save Custom Element', 'fusion-builder' ),
		'save_custom_element_info'                    => esc_attr__( 'Custom elements will be stored and managed on the Library tab', 'fusion-builder' ),
		'add_edit_items'                              => esc_attr__( 'Add / Edit Items', 'fusion-builder' ),
		'sortable_items_info'                         => esc_attr__( 'Add or edit new items for this element.  Drag and drop them into the desired order.', 'fusion-builder' ),
		'delete_inner_columns'                        => esc_attr__( 'Delete inner columns', 'fusion-builder' ),
		'clone_inner_columns'                         => esc_attr__( 'Clone inner columns', 'fusion-builder' ),
		'save_inner_columns'                          => esc_attr__( 'Save inner columns', 'fusion-builder' ),
		'delete_inner_columns'                        => esc_attr__( 'Delete inner columns', 'fusion-builder' ),
		'save_nested_columns'                         => esc_attr__( 'Save Nested Columns', 'fusion-builder' ),
		'select_options_or_leave_blank_for_all'       => esc_attr__( 'Select Options or Leave Blank for All', 'fusion-builder' ),
		'select_categories_or_leave_blank_for_all'    => esc_attr__( 'Select Categories or Leave Blank for All', 'fusion-builder' ),
		'select_categories_or_leave_blank_for_none'   => esc_attr__( 'Select Categories or Leave Blank for None', 'fusion-builder' ),
		'please_enter_element_name'                   => esc_attr__( 'Please enter element name', 'fusion-builder' ),
		'are_you_sure_you_want_to_delete_this_layout' => esc_attr__( 'Are you sure you want to delete this layout ?', 'fusion-builder' ),
		'are_you_sure_you_want_to_delete_this'        => esc_attr__( 'Are you sure you want to delete this ?', 'fusion-builder' ),
		'please_enter_template_name'                  => esc_attr__( 'Please enter template name', 'fusion-builder' ),
		'save_page_layout'                            => esc_attr__( 'Save page layout', 'fusion-builder' ),
		'upload'                                      => esc_attr__( 'Upload', 'fusion-builder' ),
		'upload_image'                                => esc_attr__( 'Upload Image', 'fusion-builder' ),
		'attach_images'                               => esc_attr__( 'Attach Images to Gallery', 'fusion-builder' ),
		'insert'                                      => esc_attr__( 'Insert', 'fusion-builder' ),
		'pre_built_page'                              => esc_attr__( 'Pre-Built Page', 'fusion-builder' ),
		'to_get_started'                              => esc_attr__( 'To get started, add a Container, or add a pre-built page.', 'fusion-builder' ),
		'to_get_started_sub'                          => esc_attr__( 'The building process always starts with a container, then columns, then elements.', 'fusion-builder' ),
		'watch_the_video'                             => esc_attr__( 'Watch The Video!', 'fusion-builder' ),
		'edit_settings'                               => esc_attr__( 'Edit Settings', 'fusion-builder' ),
		'backward_history'                            => esc_attr__( 'Backward History', 'fusion-builder' ),
		'duplicate_content'                           => esc_attr__( 'Duplicate Content', 'fusion-builder' ),
		'forward_history'                             => esc_attr__( 'Forward History', 'fusion-builder' ),
		'save_custom_content'                         => esc_attr__( 'Save Custom Content', 'fusion-builder' ),
		'delete_content'                              => esc_attr__( 'Delete Content', 'fusion-builder' ),
		'add_content'                                 => esc_attr__( 'Add Content', 'fusion-builder' ),
		'additional_docs'                             => esc_attr__( 'Click the ? icon to view additional documentation', 'fusion-builder' ),
		'getting_started_video'                       => esc_attr__( 'Getting Started Video', 'fusion-builder' ),
		'icon_control_description'                    => esc_attr__( 'Icon Control Descriptions:', 'fusion-builder' ),
		'history'                                     => esc_attr__( 'History', 'fusion-builder' ),
		'collapse_sections'                           => esc_attr__( 'Collapse Sections', 'fusion-builder' ),
		'history_states'                              => esc_attr__( 'History States', 'fusion-builder' ),
		'empty'                                       => esc_attr__( 'Start', 'fusion-builder' ),
		'moved_column'                                => esc_attr__( 'Moved Column', 'fusion-builder' ),
		'added_custom_element'                        => esc_attr__( 'Added Custom Element: ', 'fusion-builder' ),
		'added_custom_column'                         => esc_attr__( 'Added Custom Column: ', 'fusion-builder' ),
		'added_columns'                               => esc_attr__( 'Added Columns', 'fusion-builder' ),
		'added_custom_section'                        => esc_attr__( 'Added Custom Container: ', 'fusion-builder' ),
		'deleted'                                     => esc_attr__( 'Deleted', 'fusion-builder' ),
		'cloned'                                      => esc_attr__( 'Cloned', 'fusion-builder' ),
		'moved'                                       => esc_attr__( 'Moved', 'fusion-builder' ),
		'edited'                                      => esc_attr__( 'Edited', 'fusion-builder' ),
		'added_nested_columns'                        => esc_attr__( 'Added Nested Columns', 'fusion-builder' ),
		'deleted_nested_columns'                      => esc_attr__( 'Deleted Nested Columns', 'fusion-builder' ),
		'moved_nested_column'                         => esc_attr__( 'Moved Nested Column', 'fusion-builder' ),
		'head_title'                                  => esc_attr__( 'Head Title', 'fusion-builder' ),
		'currency'                                    => esc_attr__( 'Currency', 'fusion-builder' ),
		'price'                                       => esc_attr__( 'Price', 'fusion-builder' ),
		'period'                                      => esc_attr__( 'Period', 'fusion-builder' ),
		'enter_text'                                  => esc_attr__( 'Enter Text', 'fusion-builder' ),
		'added'                                       => esc_attr__( 'Added', 'fusion-builder' ),
		'added_section'                               => esc_attr__( 'Added Container', 'fusion-builder' ),
		'cloned_nested_columns'                       => esc_attr__( 'Cloned Nested Columns', 'fusion-builder' ),
		'content_imported'                            => esc_attr__( 'Content Imported', 'fusion-builder' ),
		'table_intro'                                 => esc_attr__( 'Visually create your table below, add or subtract rows and columns', 'fusion-builder' ),
		'add_table_column'                            => esc_attr__( 'Add Column', 'fusion-builder' ),
		'add_table_row'                               => esc_attr__( 'Add Row', 'fusion-builder' ),
		'column_title'                                => esc_attr__( 'Column', 'fusion-builder' ),
		'standout_design'                             => esc_attr__( 'Standout', 'fusion-builder' ),
		'add_button'                                  => esc_attr__( 'Add Button', 'fusion-builder' ),
		'yes'                                         => esc_attr__( 'Yes', 'fusion-builder' ),
		'no'                                          => esc_attr__( 'No', 'fusion-builder' ),
		'table_options'                               => esc_attr__( 'Table Options', 'fusion-builder' ),
		'table'                                       => esc_attr__( 'Table', 'fusion-builder' ),
		'toggle_all_sections'                         => esc_attr__( 'Toggle All Containers', 'fusion-builder' ),
		'cloned_section'                              => esc_attr__( 'Cloned Container', 'fusion-builder' ),
		'deleted_section'                             => esc_attr__( 'Deleted Container', 'fusion-builder' ),
		'select_image'                                => esc_attr__( 'Select Image', 'fusion-builder' ),
		'select_video'                                => esc_attr__( 'Select Video', 'fusion-builder' ),
		'empty_section'                               => esc_attr__( 'To Add Elements, You Must First Add a Column', 'fusion-builder' ),
		'empty_section_with_bg'                       => esc_attr__( 'This is an empty container with a background image. To add elements, you must first add a column', 'fusion-builder' ),
		'to_add_images'                               => esc_attr__( 'To add images to this post or page for attachments layout, navigate to "Upload Files" tab in media manager and upload new images.', 'fusion-builder' ),
		'importing_single_page'                       => esc_attr__( 'WARNING:
Importing a single demo page will remove all other page content, fusion page options and page template. Fusion Theme Options and demo images are not imported. Click OK to continue or cancel to stop.', 'fusion-builder' ),
		'content_error_title'                         => esc_attr__( 'Content Error', 'fusion-builder' ),
		'content_error_description'                   => sprintf( __( 'Your page content could not be converted. Most likely it was created with an earlier (pre 5.0) version of Avada. To update old content to Avada 5.0 or higher, you must go through <a href="%s" target="_blank">conversion</a>.', 'fusion-builder' ), 'https://theme-fusion.com/fb-doc/technical/converting-fusion-builder-pages/' ),
		'moved_container'                             => esc_attr__( 'Moved Container', 'fusion-builder' ),
	);

	return $text_strings;
}

/**
 * Add shortcode generator toggle button to text editor.
 *
 * @since 1.0
 */
function fusion_builder_add_quicktags_button() {
	?>
	<?php if ( get_current_screen()->base == 'post' ) : ?>
		<script type="text/javascript" charset="utf-8">
			if ( typeof( QTags ) == 'function' ) {
				QTags.addButton( 'fusion_shortcodes_text_mode', ' ','', '', 'f' );
			}
		</script>
	<?php endif;
}
add_action( 'admin_print_footer_scripts', 'fusion_builder_add_quicktags_button' );

/**
 * Build Social Network Icons.
 *
 * @since 1.0
 * @param string|array $social_networks The social networks array.
 * @param string       $filter          The filter that will be used to build the attributes.
 * @param array        $defaults        Defaults array.
 * @param int          $i               Increment counter.
 * @return string
 */
function fusion_builder_build_social_links( $social_networks = '', $filter, $defaults, $i = 0 ) {

	$use_brand_colors = false;
	$icons = '';
	$shortcode_defaults = array();

	if ( '' != $social_networks && is_array( $social_networks ) ) {

		// Add compatibility for different key names in shortcodes.
		foreach ( $defaults as $key => $value ) {
			$key = ( 'social_icon_boxed'        === $key ) ? 'icons_boxed' : $key;
			$key = ( 'social_icon_colors'       === $key ) ? 'icon_colors' : $key;
			$key = ( 'social_icon_boxed_colors' === $key ) ? 'box_colors' : $key;
			$key = ( 'social_icon_color_type'   === $key ) ? 'color_type' : $key;

			$shortcode_defaults[ $key ] = $value;
		}

		extract( $shortcode_defaults );

		// Check for icon color type.
		if ( 'brand' == $color_type || ( '' == $color_type && function_exists( 'Avada' ) && 'brand' == Avada()->settings->get( 'social_links_color_type' ) ) ) {
			$use_brand_colors = true;

			$box_colors = Avada_Data::fusion_social_icons( true, true );
			// Backwards compatibility for old social network names.
			$box_colors['googleplus'] = array( 'label' => 'Google+', 'color' => '#dc4e41' );
			$box_colors['mail']       = array( 'label' => esc_html__( 'Email Address', 'fusion-builder' ), 'color' => '#000000' );

		} else {

			// Custom social icon colors.
			$icon_colors = explode( '|', $icon_colors );
			$box_colors  = explode( '|', $box_colors );

			$num_of_icon_colors = count( $icon_colors );
			$num_of_box_colors  = count( $box_colors );

			for ( $k = 0; $k < count( $social_networks ); $k++ ) {
				if ( 1 == $num_of_icon_colors ) {
					$icon_colors[ $k ] = $icon_colors[0];
				}
				if ( 1 == $num_of_box_colors ) {
					$box_colors[ $k ] = $box_colors[0];
				}
			}
		}

		// Process social networks.
		foreach ( $social_networks as $key => $value ) {

			foreach ( $value as $network => $link ) {

				if ( 'custom' == $network && is_array( $link ) ) {

					foreach ( $link as $custom_key => $url ) {

						if ( 'yes' == $icons_boxed ) {

							if ( true === $use_brand_colors ) {
								$custom_icon_box_color = ( $box_colors[ $network ]['color'] ) ? $box_colors[ $network ]['color'] : '';
							} else {
								$custom_icon_box_color = $i < count( $box_colors ) ? $box_colors[ $i ] : '';
							}
						} else {
							$custom_icon_box_color = '';
						}

						$social_media_icons = FusionBuilder::get_theme_option( 'social_media_icons' );
						if ( ! is_array( $social_media_icons ) ) {
							$social_media_icons = array();
						}
						if ( ! isset( $social_media_icons['custom_title'] ) ) {
							$social_media_icons['custom_title'] = array();
						}
						if ( ! isset( $social_media_icons['custom_source'] ) ) {
							$social_media_icons['custom_source'] = array();
						}
						if ( ! isset( $social_media_icons['custom_title'][ $custom_key ] ) ) {
							$social_media_icons['custom_title'][ $custom_key ] = '';
						}
						if ( ! isset( $social_media_icons['custom_source'][ $custom_key ] ) ) {
							$social_media_icons['custom_source'][ $custom_key ] = '';
						}

						$icon_options = array(
							'social_network' => $social_media_icons['custom_title'][ $custom_key ],
							'social_link'    => $url,
							'icon_color'     => $i < count( $icon_colors ) ? $icon_colors[ $i ] : '',
							'box_color'      => $custom_icon_box_color,
						);

						$icons .= '<a ' . FusionBuilder::attributes( $filter, $icon_options ) . '>';
						$icons .= '<img';

						if ( isset( $social_media_icons['custom_source'][ $custom_key ]['url'] ) ) {
							$icons .= ' src="' . $social_media_icons['custom_source'][ $custom_key ]['url'] . '"';
						}
						if ( isset( $social_media_icons['custom_title'][ $custom_key ] ) && '' != $social_media_icons['custom_title'][ $custom_key ] ) {
							$icons .= ' alt="' . $social_media_icons['custom_title'][ $custom_key ] . '"';
						}
						if ( isset( $social_media_icons['custom_source'][ $custom_key ]['width'] ) && $social_media_icons['custom_source'][ $custom_key ]['width'] ) {
							$width = intval( $social_media_icons['custom_source'][ $custom_key ]['width'] );
							$icons .= ' width="' . $width . '"';
						}
						if ( isset( $social_media_icons['custom_source'][ $custom_key ]['height'] ) && $social_media_icons['custom_source'][ $custom_key ]['height'] ) {
							$height = intval( $social_media_icons['custom_source'][ $custom_key ]['height'] );
							$icons .= ' height="' . $height . '"';
						}
						$icons .= ' /></a>';
					}
				} else {

					if ( true == $use_brand_colors ) {
						$icon_options = array(
							'social_network' => $network,
							'social_link'    => $link,
							'icon_color'     => ( 'yes' == $icons_boxed ) ? '#ffffff' : $box_colors[ $network ]['color'],
							'box_color'      => ( 'yes' == $icons_boxed ) ? $box_colors[ $network ]['color'] : '',
						);

					} else {
						$icon_options = array(
						'social_network' => $network,
						'social_link'    => $link,
						'icon_color'     => $i < count( $icon_colors ) ? $icon_colors[ $i ] : '',
						'box_color'      => $i < count( $box_colors ) ? $box_colors[ $i ] : '',
						);
					}
					$icons .= '<a ' . FusionBuilder::attributes( $filter, $icon_options ) . '></a>';
				}
				$i++;
			}
		}
	}
	return $icons;
}

/**
 * Get Social Networks.
 *
 * @since 1.0
 * @param array $defaults The default values.
 * @return array
 */
function fusion_builder_get_social_networks( $defaults ) {

	$social_links_array = array();

	if ( $defaults['facebook'] ) {
		$social_links_array['facebook'] = $defaults['facebook'];
	}
	if ( $defaults['twitter'] ) {
		$social_links_array['twitter'] = $defaults['twitter'];
	}
	if ( $defaults['instagram'] ) {
		$social_links_array['instagram'] = $defaults['instagram'];
	}
	if ( $defaults['linkedin'] ) {
		$social_links_array['linkedin'] = $defaults['linkedin'];
	}
	if ( $defaults['dribbble'] ) {
		$social_links_array['dribbble'] = $defaults['dribbble'];
	}
	if ( $defaults['rss'] ) {
		$social_links_array['rss'] = $defaults['rss'];
	}
	if ( $defaults['youtube'] ) {
		$social_links_array['youtube'] = $defaults['youtube'];
	}
	if ( $defaults['pinterest'] ) {
		$social_links_array['pinterest'] = $defaults['pinterest'];
	}
	if ( $defaults['flickr'] ) {
		$social_links_array['flickr'] = $defaults['flickr'];
	}
	if ( $defaults['vimeo'] ) {
		$social_links_array['vimeo'] = $defaults['vimeo'];
	}
	if ( $defaults['tumblr'] ) {
		$social_links_array['tumblr'] = $defaults['tumblr'];
	}
	if ( $defaults['googleplus'] ) {
		$social_links_array['googleplus'] = $defaults['googleplus'];
	}
	if ( $defaults['google'] ) {
		$social_links_array['googleplus'] = $defaults['google'];
	}
	if ( $defaults['digg'] ) {
		$social_links_array['digg'] = $defaults['digg'];
	}
	if ( $defaults['blogger'] ) {
		$social_links_array['blogger'] = $defaults['blogger'];
	}
	if ( $defaults['skype'] ) {
		$social_links_array['skype'] = $defaults['skype'];
	}
	if ( $defaults['myspace'] ) {
		$social_links_array['myspace'] = $defaults['myspace'];
	}
	if ( $defaults['deviantart'] ) {
		$social_links_array['deviantart'] = $defaults['deviantart'];
	}
	if ( $defaults['yahoo'] ) {
		$social_links_array['yahoo'] = $defaults['yahoo'];
	}
	if ( $defaults['reddit'] ) {
		$social_links_array['reddit'] = $defaults['reddit'];
	}
	if ( $defaults['forrst'] ) {
		$social_links_array['forrst'] = $defaults['forrst'];
	}
	if ( $defaults['paypal'] ) {
		$social_links_array['paypal'] = $defaults['paypal'];
	}
	if ( $defaults['dropbox'] ) {
		$social_links_array['dropbox'] = $defaults['dropbox'];
	}
	if ( $defaults['soundcloud'] ) {
		$social_links_array['soundcloud'] = $defaults['soundcloud'];
	}
	if ( $defaults['vk'] ) {
		$social_links_array['vk'] = $defaults['vk'];
	}
	if ( $defaults['xing'] ) {
		$social_links_array['xing'] = $defaults['xing'];
	}
	if ( $defaults['yelp'] ) {
		$social_links_array['yelp'] = $defaults['yelp'];
	}
	if ( $defaults['spotify'] ) {
		$social_links_array['spotify'] = $defaults['spotify'];
	}
	if ( $defaults['email'] ) {
		$social_links_array['mail'] = $defaults['email'];
	}
	if ( $defaults['show_custom'] && 'yes' === $defaults['show_custom'] ) {
		$social_links_array['custom'] = array();
		if ( is_array( FusionBuilder::get_theme_option( 'social_media_icons', 'icon' ) ) ) {
			foreach ( FusionBuilder::get_theme_option( 'social_media_icons', 'icon' ) as $key => $icon ) {
				$social_media_icons_url = FusionBuilder::get_theme_option( 'social_media_icons', 'url' );
				if ( 'custom' == $icon && is_array( $social_media_icons_url ) && isset( $social_media_icons_url[ $key ] ) && ! empty( $social_media_icons_url[ $key ] ) ) {
					// Check if there is a default set for this, if so use that rather than TO link.
					if ( isset( $defaults[ 'custom_' . $key ] ) && ! empty( $defaults[ 'custom_' . $key ] ) ) {
						$social_links_array['custom'][ $key ] = $defaults[ 'custom_' . $key ];
					} else {
						$social_links_array['custom'][ $key ] = $social_media_icons_url[ $key ];
					}
				}
			}
		}
	}

	return $social_links_array;
}

/**
 * Sort Social Network Icons.
 *
 * @since 1.0
 * @param array $social_networks_original Original array of social networks.
 * @return array
 */
function fusion_builder_sort_social_networks( $social_networks_original ) {

	$social_networks = array();
	$icon_order = '';

	// Get social networks order from theme options.
	$social_media_icons = FusionBuilder::get_theme_option( 'social_media_icons' );
	if ( isset( $social_media_icons['icon'] ) && is_array( $social_media_icons['icon'] ) ) {
		$icon_order = implode( '|', $social_media_icons['icon'] );
	}

	if ( ! is_array( $icon_order ) ) {
		$icon_order = explode( '|', $icon_order );
	}

	if ( is_array( $icon_order ) && ! empty( $icon_order ) ) {
		// First put the icons that exist in the theme options,
		// and order them using tha same order as in theme options.
		foreach ( $icon_order as $key => $value ) {

			// Backwards compatibility for old social network names.
			$value = ( 'google' === $value ) ? 'googleplus' : $value;
			$value = ( 'gplus'  === $value ) ? 'googleplus' : $value;
			$value = ( 'email'  === $value ) ? 'mail' : $value;

			// Check if social network from TO exists in shortcode.
			if ( ! isset( $social_networks_original[ $value ] ) ) {
				continue;
			}

			if ( 'custom' === $value ) {
				$social_networks[] = array( $value => array( $key => $social_networks_original[ $value ][ $key ] ) );
			} else {
				$social_networks[] = array( $value => $social_networks_original[ $value ] );
				unset( $social_networks_original[ $value ] );
			}
		}

		// Put any remaining icons after the ones from the theme options.
		foreach ( $social_networks_original as $name => $url ) {
			if ( 'custom' !== $name ) {
				$social_networks[] = array( $name => $url );
			}
		}
	}

	return $social_networks;
}

/**
 * Get Custom Social Networks.
 *
 * @since 1.0
 * @return array
 */
function fusion_builder_get_custom_social_networks() {
	$social_links_array = array();
	$social_media_icons = FusionBuilder::get_theme_option( 'social_media_icons' );
	if ( is_array( $social_media_icons ) && isset( $social_media_icons['icon'] ) && is_array( $social_media_icons['icon'] ) ) {
		foreach ( $social_media_icons['icon'] as $key => $icon ) {
			if ( 'custom' == $icon && isset( $social_media_icons['url'][ $key ] ) && ! empty( $social_media_icons['url'][ $key ] ) ) {
				$social_links_array[ $key ] = $social_media_icons['url'][ $key ];
			}
		}
	}
	return $social_links_array;
}
/**
 * Returns a cached query.
 * If the query is not cached then it caches it and returns the result.
 *
 * @since 1.0
 * @param string|array $args Same as in WP_Query.
 * @return object
 */
function fusion_builder_cached_query( $args ) {
	// Add a non-persistent cache group.
	wp_cache_add_non_persistent_groups( 'fusion_builder' );
	$query_id = md5( maybe_serialize( $args ) );
	$query = wp_cache_get( $query_id, 'fusion_builder' );
	if ( false === $query ) {
		$query = new WP_Query( $args );
		wp_cache_set( $query_id, $query, 'fusion_builder' );
	}
	return $query;
}

/**
 * Returns a cached query.
 * If the query is not cached then it caches it and returns the result.
 *
 * @since 1.0.0
 * @param string|array $args Same as in WP_Query.
 * @return array
 */
function fusion_builder_cached_get_posts( $args ) {
	$query = fusion_builder_cached_query( $args );
	return $query->posts;
}

/**
 * Returns an array of visibility options.
 *
 * @since 1.0
 * @param string $type whether to return full array or values only.
 * @return array
 */
function fusion_builder_visibility_options( $type ) {

	$visibility_options = array(
		esc_attr__( 'Small Screen', 'fusion-builder' )  => 'small-visibility',
		esc_attr__( 'Medium Screen', 'fusion-builder' )  => 'medium-visibility',
		esc_attr__( 'Large Screen', 'fusion-builder' ) => 'large-visibility',
		);
	if ( 'values' == $type ) {
		$visibility_options = array_values( $visibility_options );
	}
	return $visibility_options;
}

/**
 * Returns an array of default visibility options.
 *
 * @since 1.0
 * @param  string $type either array or string to return.
 * @return string|array
 */
function fusion_builder_default_visibility( $type ) {

	$default_visibility = fusion_builder_visibility_options( 'values' );
	if ( 'string' == $type ) {
		$default_visibility = implode( ', ', $default_visibility );
	}
	return $default_visibility;
}

/**
 * Reverses the visibility selection and adds to attribute array.
 *
 * @since 1.0
 * @param string|array $selection Devices selected to be shown on.
 * @param array        $attr      Current attributes to add to.
 * @return array
 */
function fusion_builder_visibility_atts( $selection, $attr ) {
	$visibility_values = fusion_builder_visibility_options( 'values' );

	// If empty, show all.
	if ( empty( $selection ) ) {
		$selection = $visibility_values;
	}

	// If no is used, change that to all options selected, as fallback.
	if ( 'no' === $selection ) {
		$selection = $visibility_values;
	}

	// If yes is used, use all selections with mobile visibility removed.
	if ( 'yes' === $selection ) {
		if ( false !== ( $key = array_search( 'small-visibility', $visibility_values ) ) ) {
		    unset( $visibility_values[ $key ] );
		    $selection = $visibility_values;
		}
	}

	// Make sure the selection is an array.
	if ( ! is_array( $selection ) ) {
		$selection = explode( ',', str_replace( ' ', '', $selection ) );
	}

	$visibility_options = fusion_builder_visibility_options( 'values' );
	foreach ( $visibility_options as $visibility_option ) {
		if ( ! in_array( $visibility_option, $selection ) ) {
			if ( is_array( $attr ) ) {
				$attr['class'] .= ( ( $attr['class'] ) ? ' fusion-no-' . $visibility_option : 'fusion-no-' . $visibility_option );
			} else {
				$attr .= ( ( $attr ) ? ' fusion-no-' . $visibility_option : 'fusion-no-' . $visibility_option );
			}
		}
	}
	return $attr;
}
/**
 * Adds fallbacks for section attributes.
 *
 * @since 1.0
 * @param array $args Array of attributes.
 * @return array
 */
function fusion_section_deprecated_args( $args ) {

	$param_mapping = array(
		'backgroundposition'    => 'background_position',
		'backgroundattachment'  => 'background_parallax',
		'background_attachment' => 'background_parallax',
		'bordersize'            => 'border_size',
		'bordercolor'           => 'border_color',
		'borderstyle'           => 'border_style',
		'paddingtop'            => 'padding_top',
		'paddingbottom'         => 'padding_bottom',
		'paddingleft'           => 'padding_left',
		'paddingright'          => 'padding_right',
		'backgroundcolor'       => 'background_color',
		'backgroundimage'       => 'background_image',
		'backgroundrepeat'      => 'background_repeat',
		'paddingBottom'         => 'padding_bottom',
		'paddingTop'            => 'padding_top',
	);

	if ( ! is_array( $args ) ) {
		$args = array();
	}

	if ( ( array_key_exists( 'backgroundattachment', $args ) && $args['backgroundattachment'] == 'scroll' ) ||
		 ( array_key_exists( 'background_attachment', $args ) && $args['background_attachment'] == 'scroll' )
	) {
		$args['backgroundattachment'] = $args['background_attachment'] = 'none';
	}

	foreach ( $param_mapping as $old => $new ) {
		if ( ! isset( $args[ $new ] ) && isset( $args[ $old ] ) ) {
			$args[ $new ] = $args[ $old ];
			unset( $args[ $old ] );
		}
	}

	return $args;
}

/**
 * Creates placeholders for empty post type shortcodes.
 *
 * @since 1.0
 * @param string $post_type name of post type.
 * @param string $label label for post type.
 * @return string
 */
function fusion_builder_placeholder( $post_type, $label ) {
	if ( current_user_can( 'publish_posts' ) ) {
		$string = sprintf( esc_html__( 'Please add %s for them to display here.', 'fusion-builder' ), $label );
		$link = admin_url( 'post-new.php?post_type=' . $post_type );
		$html = '<a href="' . $link . '" class="fusion-builder-placeholder">' . $string . '</a>';
		return $html;
	}
}

/**
 * Sorts modules.
 *
 * @since 1.0.0
 * @param string $key The key to use for sorting.
 */
function fusion_element_sort( $key ) {
	return function ( $a, $b ) use ( $key ) {
		return strnatcmp( $a[ $key ], $b[ $key ] );
	};
}

/**
 * Returns a single side dimension.
 *
 * @since 1.0
 * @param string $dimensions current dimensions combined.
 * @param string $direction which side dimension to be retrieved.
 * @return string
 */
function fusion_builder_single_dimension( $dimensions, $direction ) {
	$dimensions = explode( ' ', $dimensions );
	if ( 4 === count( $dimensions ) ) {
		list( $top, $right, $bottom, $left ) = $dimensions;
	} elseif ( 3 === count( $dimensions ) ) {
		$top = $dimensions[0];
		$right = $left = $dimensions[1];
		$bottom = $dimensions[2];
	} elseif ( 2 === count( $dimensions ) ) {
		$top = $bottom = $dimensions[0];
		$right = $left = $dimensions[1];
	} else {
		$top = $right = $bottom = $left = $dimensions[0];
	}
	return ${ $direction };
}

/**
 * Adds admin notice when visual editor is disabled
 *
 * @since 1.0
 * @return string
 */
function fusion_builder_add_notice_of_disabled_rich_editor() {
	global $current_user;
	$user_id = $current_user->ID;

	$current_uri = $_SERVER['REQUEST_URI'];
	$uri_parts = parse_url( $current_uri );
	if( ! isset( $uri_parts['query'] ) ) {
		$uri_parts['query'] = '';
	}
	$path = explode( '/', $uri_parts['path'] );
	$last = end( $path );
	$full_link = admin_url() . $last . '?' . $uri_parts['query'];

	// Check that the user hasn't already clicked to ignore the message
	if ( ! get_user_meta( $user_id, 'fusion_richedit_nag_ignore') ) {
		echo sprintf( '<div id="disabled-rich-editor" class="updated"><p>%s <a href="%s">%s</a><span class="dismiss" style="float:right;"><a href="%s&fusion_richedit_nag_ignore=0">%s</a></span></div>', __( 'Note: The visual editor, which is necesarry for Fusion Builder to work, has been disabled in your profile settings.', 'fusion-builder'), admin_url() . 'profile.php', __( 'Go to Profile', 'fusion-builder' ), $full_link, __( 'Hide Notice', 'fusion-builder' ) );
	}
}
