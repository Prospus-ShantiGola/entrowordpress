<?php
/**
 * Contains all framework specific functions that are not part of a separate class
 *
 * @author      ThemeFusion
 * @package     FusionFramework
 * @since       Version 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! function_exists( 'fusion_get_related_posts' ) ) {
	/**
	 * Get related posts by category
	 *
	 * @param  integer $post_id      Current post id.
	 * @param  integer $number_posts Number of posts to fetch.
	 * @return object                Object with posts info.
	 */
	function fusion_get_related_posts( $post_id, $number_posts = -1 ) {

		$args = '';

		if ( 0 == $number_posts ) {
			$query = new WP_Query();
			return $query;
		}

		$args = wp_parse_args( $args, array(
			'category__in'        => wp_get_post_categories( $post_id ),
			'ignore_sticky_posts' => 0,
			'posts_per_page'      => $number_posts,
			'post__not_in'        => array( $post_id ),
		) );

		// If placeholder images are disabled,
		// add the _thumbnail_id meta key to the query to only retrieve posts with featured images.
		if ( ! Avada()->settings->get( 'featured_image_placeholder' ) ) {
			$args['meta_key'] = '_thumbnail_id';
		}

		return avada_cached_query( $args );

	}
}

if ( ! function_exists( 'fusion_get_custom_posttype_related_posts' ) ) {
	/**
	 * Get related posts by a custom post type category taxonomy.
	 *
	 * @param  integer $post_id      Current post id.
	 * @param  integer $number_posts Number of posts to fetch.
	 * @param  string  $post_type    The custom post type that should be used.
	 * @return object                Object with posts info.
	 */
	function fusion_get_custom_posttype_related_posts( $post_id, $number_posts = 8, $post_type = 'avada_portfolio' ) {

		$query = new WP_Query();

		$args = '';

		if ( 0 == $number_posts ) {
			return $query;
		}

		$post_type = str_replace( 'avada_', '', $post_type );

		$item_cats = get_the_terms( $post_id, $post_type . '_category' );

		$item_array = array();
		if ( $item_cats ) {
			foreach ( $item_cats as $item_cat ) {
				$item_array[] = $item_cat->term_id;
			}
		}

		if ( ! empty( $item_array ) ) {
			$args = wp_parse_args( $args, array(
				'ignore_sticky_posts' => 0,
				'posts_per_page'      => $number_posts,
				'post__not_in'        => array( $post_id ),
				'post_type'           => 'avada_' . $post_type,
				'tax_query'           => array(
					array(
						'field'    => 'id',
						'taxonomy' => $post_type . '_category',
						'terms'    => $item_array,
					),
				),
			) );

			// If placeholder images are disabled, add the _thumbnail_id meta key to the query to only retrieve posts with featured images.
			if ( ! Avada()->settings->get( 'featured_image_placeholder' ) ) {
				$args['meta_key'] = '_thumbnail_id';
			}

			$query = avada_cached_query( $args );

		}

		return $query;
	}
}

if ( ! function_exists( 'fusion_attr' ) ) {
	/**
	 * Function to apply attributes to HTML tags.
	 * Devs can override attr in a child theme by using the correct slug
	 *
	 * @param  string $slug         Slug to refer to the HTML tag.
	 * @param  array  $attributes   Attributes for HTML tag.
	 * @return string               Attributes in attr='value' format.
	 */
	function fusion_attr( $slug, $attributes = array() ) {

		$out  = '';
		$attr = apply_filters( "fusion_attr_{$slug}", $attributes );

		if ( empty( $attr ) ) {
			$attr['class'] = $slug;
		}

		foreach ( $attr as $name => $value ) {
			$out .= ' ' . esc_html( $name );
			if ( ! empty( $value ) ) {
				$out .= '="' . esc_attr( $value ) . '"';
			}
		}

		return trim( $out );

	}
}

if ( ! function_exists( 'fusion_pagination' ) ) {
	/**
	 * Number based pagination
	 *
	 * @param  string  $pages         Maximum number of pages.
	 * @param  integer $range         Our range.
	 * @param  string  $current_query The current query.
	 * @return void
	 */
	function fusion_pagination( $pages = '', $range = 2, $current_query = '' ) {
		$showitems = ( $range * 2 ) + 1;

		if ( '' == $current_query ) {
			global $paged;
			if ( empty( $paged ) ) {
				$paged = 1;
			}
		} else {
			$paged = $current_query->query_vars['paged'];
		}

		if ( '' == $pages ) {
			if ( '' == $current_query ) {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if ( ! $pages ) {
					$pages = 1;
				}
			} else {
				$pages = $current_query->max_num_pages;
			}
		}
		?>

		<?php if ( 1 != $pages ) : ?>
			<?php if ( ( 'Pagination' != Avada()->settings->get( 'blog_pagination_type' ) && ( is_home() || is_search() || ( 'post' == get_post_type() && ( is_author() || is_archive() ) ) ) ) || ( 'Pagination' != Avada()->settings->get( 'grid_pagination_type' ) && ( is_post_type_archive( 'avada_portfolio' ) || is_tax( 'portfolio_category' ) || is_tax( 'portfolio_skills' )  || is_tax( 'portfolio_tags' ) ) ) ) : ?>
				<div class='pagination infinite-scroll clearfix' style="display:none;">
			<?php else : ?>
				<div class='pagination clearfix'>
			<?php endif; ?>

			<?php if ( 1 < $paged ) : ?>
				<a class="pagination-prev" href="<?php echo get_pagenum_link( $paged - 1 ); ?>">
					<span class="page-prev"></span>
					<span class="page-text"><?php esc_html_e( 'Previous', 'Avada' ); ?></span>
				</a>
			<?php endif; ?>

			<?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
				<?php if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) : ?>
					<?php if ( $paged == $i ) : ?>
						<span class="current"><?php echo $i; ?></span>
					<?php else : ?>
						<a href="<?php echo get_pagenum_link( $i ); ?>" class="inactive"><?php echo $i; ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endfor; ?>

			<?php if ( $paged < $pages ) : ?>
				<a class="pagination-next" href="<?php echo get_pagenum_link( $paged + 1 ); ?>">
					<span class="page-text"><?php esc_html_e( 'Next', 'Avada' ); ?></span>
					<span class="page-next"></span>
				</a>
			<?php endif; ?>

			</div>
			<?php
			// Needed for Theme check.
			ob_start();
			posts_nav_link();
			ob_get_clean();
			?>
		<?php endif;

	}
}

if ( ! function_exists( 'fusion_breadcrumbs' ) ) {
	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php.
	 *
	 * @return void
	 */
	function fusion_breadcrumbs() {
		$breadcrumbs = Fusion_Breadcrumbs::get_instance();
		$breadcrumbs->get_breadcrumbs();
	}
}

if ( ! function_exists( 'fusion_strip_unit' ) ) {
	/**
	 * Strips the unit from a given value.
	 *
	 * @param  string $value The value with or without unit.
	 * @param  string $unit_to_strip The unit to be stripped.
	 * @return string	the value without a unit.
	 */
	function fusion_strip_unit( $value, $unit_to_strip = 'px' ) {
		$value_length = strlen( $value );
		$unit_length = strlen( $unit_to_strip );

		if ( $value_length > $unit_length &&
			 substr_compare( $value, $unit_to_strip, $unit_length * (-1), $unit_length ) === 0
		) {
			return substr( $value, 0, $value_length - $unit_length );
		} else {
			return $value;
		}
	}
}

add_filter( 'feed_link', 'fusion_feed_link', 1, 2 );
if ( ! function_exists( 'fusion_feed_link' ) ) {
	/**
	 * Replace default WP RSS feed link with theme option RSS feed link.
	 *
	 * @param  string $output Feed link.
	 * @param  string $feed   Feed type.
	 * @return string         Return modified feed link.
	 */
	function fusion_feed_link( $output, $feed ) {
		if ( Avada()->settings->get( 'rss_link' ) ) {
			$feed_url = Avada()->settings->get( 'rss_link' );

			$feed_array = array( 'rss' => $feed_url, 'rss2' => $feed_url, 'atom' => $feed_url, 'rdf' => $feed_url, 'comments_rss2' => '' );
			$feed_array[ $feed ] = $feed_url;
			$output = $feed_array[ $feed ];
		}

		return $output;
	}
}

if ( ! function_exists( 'fusion_add_url_parameter' ) ) {
	/**
	 * Add paramater to current url.
	 *
	 * @param  string $url         URL to add param to.
	 * @param  string $param_name  Param name.
	 * @param  string $param_value Param value.
	 * @return array               params added to url data.
	 */
	function fusion_add_url_parameter( $url, $param_name, $param_value ) {
		 $url_data = wp_parse_url( $url );
		if ( ! isset( $url_data['query'] ) ) {
			$url_data['query'] = '';
		}

		$params = array();
		parse_str( $url_data['query'], $params );

		if ( is_array( $param_value ) ) {
			$param_value = $param_value[0];
		}

		$params[ $param_name ] = $param_value;

		if ( 'product_count' == $param_name ) {
			$params['paged'] = '1';
		}

		$url_data['query'] = http_build_query( $params );
		return fusion_build_url( $url_data );
	}
}

if ( ! function_exists( 'fusion_build_url' ) ) {
	/**
	 * Build final URL form $url_data returned from fusion_add_url_paramtere.
	 *
	 * @param  array $url_data  url data with custom params.
	 * @return string           fully formed url with custom params.
	 */
	function fusion_build_url( $url_data ) {
		$url = '';
		if ( isset( $url_data['host'] ) ) {
			$url .= $url_data['scheme'] . '://';
			if ( isset( $url_data['user'] ) ) {
				$url .= $url_data['user'];
				if ( isset( $url_data['pass'] ) ) {
					$url .= ':' . $url_data['pass'];
				}
				$url .= '@';
			}
			$url .= $url_data['host'];
			if ( isset( $url_data['port'] ) ) {
				$url .= ':' . $url_data['port'];
			}
		}

		if ( isset( $url_data['path'] ) ) {
			$url .= $url_data['path'];
		}

		if ( isset( $url_data['query'] ) ) {
			$url .= '?' . $url_data['query'];
		}

		if ( isset( $url_data['fragment'] ) ) {
			$url .= '#' . $url_data['fragment'];
		}

		return $url;
	}
}

if ( ! function_exists( 'fusion_color_luminance' ) ) {
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.
	 *
	 * @param string $hex     Colour as hexadecimal (with or without hash).
	 * @param float  $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() ).
	 * @return str            Lightened/Darkend colour as hexadecimal (with hash).
	 */
	function fusion_color_luminance( $hex, $percent ) {
		// Validate hex string.
		$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
		$new_hex = '#';

		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}

		// Convert to decimal and change luminosity.
		for ( $i = 0; $i < 3; $i++ ) {
			$dec = hexdec( substr( $hex, $i * 2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 );
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}
}

if ( ! function_exists( 'fusion_adjust_brightness' ) ) {
	/**
	 * Adjusts brightness of the $hex and rgba colors.
	 *
	 * @param   string $color The hex or rgba value of a color.
	 * @param   int    $steps A value between -255 (darken) and 255 (lighten).
	 * @return  string        Returns hex color or rgba, depending on input.
	 */
	function fusion_adjust_brightness( $color, $steps ) {
		$color_obj = Avada_Color::new_color( $color );
		// Steps should be between -255 and 255. Negative = darker, positive = lighter.
		$steps = max( -255, min( 255, $steps ) );
		// Adjust number of steps and keep it inside 0 to 255.
		$red   = max( 0, min( 255, $color_obj->red + $steps ) );
		$green = max( 0, min( 255, $color_obj->green + $steps ) );
		$blue  = max( 0, min( 255, $color_obj->blue + $steps ) );

		$red_hex   = str_pad( dechex( $red ), 2, '0', STR_PAD_LEFT );
		$green_hex = str_pad( dechex( $green ), 2, '0', STR_PAD_LEFT );
		$blue_hex  = str_pad( dechex( $blue ), 2, '0', STR_PAD_LEFT );

		$new_color_obj = Avada_Color::new_color( $red_hex . $green_hex . $blue_hex );
		if ( 'hex' == $color_obj->mode ) {
			return $new_color_obj->to_css( 'hex' );
		}
		$new_color_obj->alpha = $color_obj->alpha;
		return $new_color_obj->to_css( 'rgba' );
	}
}

/**
 * Gets the brightness of a color.
 *
 * @param string $color The color.
 * @return int          Value between 0 and 255.
 */
function fusion_get_brightness( $color ) {
	$color_obj = Avada_Color::new_color( $color );
	// Returns brightness value from 0 to 255.
	return intval( ( ( $color_obj->red * 299 ) + ( $color_obj->green * 587 ) + ( $color_obj->blue * 114 ) ) / 1000 );
}

if ( ! function_exists( 'fusion_calc_color_brightness' ) ) {
	/**
	 * Convert Calculate the brightness of a color.
	 *
	 * @param  string $color Color (Hex) Code.
	 * @return integer brightness level.
	 */
	function fusion_calc_color_brightness( $color ) {

		if ( in_array( strtolower( $color ), array( 'black', 'navy', 'purple', 'maroon', 'indigo', 'darkslategray', 'darkslateblue', 'darkolivegreen', 'darkgreen', 'darkblue' ) ) ) {
			$brightness_level = 0;
		} elseif ( strpos( $color, '#' ) === 0 ) {
			$color = fusion_hex2rgb( $color );

			$brightness_level = sqrt( pow( $color[0], 2 ) * 0.299 + pow( $color[1], 2 ) * 0.587 + pow( $color[2], 2 ) * 0.114 );
		} else {
			$brightness_level = 150;
		}

		return $brightness_level;
	}
}

if ( ! function_exists( 'fusion_hex2rgb' ) ) {
	/**
	 * Convert Hex Code to RGB.
	 *
	 * @param  string $hex Color Hex Code.
	 * @return array       RGB values.
	 */
	function fusion_hex2rgb( $hex ) {
		if ( false !== strpos( $hex,'rgb' ) ) {

			$rgb_part = strstr( $hex, '(' );
			$rgb_part = trim( $rgb_part, '(' );
			$rgb_part = rtrim( $rgb_part, ')' );
			$rgb_part = explode( ',', $rgb_part );

			$rgb = array( $rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3] );

		} elseif ( 'transparent' == $hex ) {
			$rgb = array( '255', '255', '255', '0' );
		} else {

			$hex = str_replace( '#', '', $hex );

			if ( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );
		}

		return $rgb; // Returns an array with the rgb values.
	}
}

if ( ! function_exists( 'fusion_rgb2hsl' ) ) {
	/**
	 * Convert RGB to HSL color model.
	 *
	 * @param  string $hex_color Color Hex Code of RGB color.
	 * @return array             HSL values.
	 */
	function fusion_rgb2hsl( $hex_color ) {

		$hex_color  = str_replace( '#', '', $hex_color );

		if ( strlen( $hex_color ) < 3 ) {
			str_pad( $hex_color, 3 - strlen( $hex_color ), '0' );
		}

		$add      = strlen( $hex_color ) == 6 ? 2 : 1;
		$aa       = 0;
		$add_on   = 1 == $add ? ( $aa = 16 - 1 ) + 1 : 1;

		$red         = round( ( hexdec( substr( $hex_color, 0, $add ) ) * $add_on + $aa ) / 255, 6 );
		$green     = round( ( hexdec( substr( $hex_color, $add, $add ) ) * $add_on + $aa ) / 255, 6 );
		$blue       = round( ( hexdec( substr( $hex_color, ( $add + $add ) , $add ) ) * $add_on + $aa ) / 255, 6 );

		$hsl_color  = array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

		$minimum     = min( $red, $green, $blue );
		$maximum     = max( $red, $green, $blue );

		$chroma   = $maximum - $minimum;

		$hsl_color['lum'] = ( $minimum + $maximum ) / 2;

		if ( 0 == $chroma ) {
			$hsl_color['lum'] = round( $hsl_color['lum'] * 100, 0 );

			return $hsl_color;
		}

		$range = $chroma * 6;

		$hsl_color['sat'] = $hsl_color['lum'] <= 0.5 ? $chroma / ( $hsl_color['lum'] * 2 ) : $chroma / ( 2 - ( $hsl_color['lum'] * 2 ) );

		if ( $red <= 0.004 ||
			$green <= 0.004 ||
			$blue <= 0.004
		) {
			$hsl_color['sat'] = 1;
		}

		if ( $maximum == $red ) {
			$hsl_color['hue'] = round( ( $blue > $green ? 1 - ( abs( $green - $blue ) / $range ) : ( $green - $blue ) / $range ) * 255, 0 );
		} elseif ( $maximum == $green ) {
			$hsl_color['hue'] = round( ( $red > $blue ? abs( 1 - ( 4 / 3 ) + ( abs( $blue - $red ) / $range ) ) : ( 1 / 3 ) + ( $blue - $red ) / $range ) * 255, 0 );
		} else {
			$hsl_color['hue'] = round( ( $green < $red ? 1 - 2 / 3 + abs( $red - $green ) / $range : 2 / 3 + ( $red - $green ) / $range ) * 255, 0 );
		}

		$hsl_color['sat'] = round( $hsl_color['sat'] * 100, 0 );
		$hsl_color['lum']  = round( $hsl_color['lum'] * 100, 0 );

		return $hsl_color;
	}
}

if ( ! function_exists( 'fusion_get_theme_option' ) ) {
	/**
	 * Get theme option value.
	 *
	 * @param  string $theme_option ID of theme option.
	 * @return string               Value of theme option.
	 */
	function fusion_get_theme_option( $theme_option ) {

		if ( $theme_option && null !== Avada()->settings->get( $theme_option ) ) {
			return Avada()->settings->get( $theme_option );
		}

		return false;
	}
}

if ( ! function_exists( 'fusion_get_page_option' ) ) {
	/**
	 * Get page option value.
	 *
	 * @param  string  $page_option ID of page option.
	 * @param  integer $post_id     Post/Page ID.
	 * @return string               Value of page option.
	 */
	function fusion_get_page_option( $page_option, $post_id ) {
		if ( $page_option && $post_id ) {
			if ( 0 === strpos( $page_option, 'pyre_' ) ) {
				$page_option = str_replace( 'pyre_', '', $page_option );
			}
			return get_post_meta( $post_id, 'pyre_' . $page_option, true );
		}

		return false;
	}
}

if ( ! function_exists( 'fusion_get_option' ) ) {
	/**
	 * Get theme option or page option.
	 *
	 * @param  string  $theme_option Theme option ID.
	 * @param  string  $page_option  Page option ID.
	 * @param  integer $post_id      Post/Page ID.
	 * @return string                Theme option or page option value.
	 */
	function fusion_get_option( $theme_option, $page_option, $post_id ) {
		if ( $theme_option && $page_option && ( $post_id || '0' == $post_id ) ) {
			$page_option = strtolower( fusion_get_page_option( $page_option, $post_id ) );
			$theme_option = strtolower( Avada()->settings->get( $theme_option ) );

			if ( 'default' != $page_option && ! empty( $page_option ) ) {
				return $page_option;
			} else {
				return $theme_option;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'fusion_get_mismatch_option' ) ) {
	/**
	 * Get theme option or page option when mismatched.
	 *
	 * @param  string  $theme_option Theme option ID.
	 * @param  string  $page_option  Page option ID.
	 * @param  integer $post_id      Post/Page ID.
	 * @since  4.0
	 * @return string                Theme option or page option value.
	 */
	function fusion_get_mismatch_option( $theme_option, $page_option, $post_id ) {
		if ( $theme_option && $page_option && $post_id ) {
			$page_option = strtolower( fusion_get_page_option( $page_option, $post_id ) );
			$theme_option = strtolower( Avada()->settings->get( $theme_option ) );
			if ( 1 == $theme_option ) {
				$theme_option = 0;
			} else {
				$theme_option = 1;
			}

			if ( 'default' != $page_option && ! empty( $page_option ) ) {
				return $page_option;
			} else {
				return $theme_option;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'fusion_compress_css' ) ) {
	/**
	 * Compress CSS
	 *
	 * @param  string $minify CSS to compress.
	 * @return string         Compressed CSS.
	 */
	function fusion_compress_css( $minify ) {
		// Remove comments.
		$minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );

		// Remove tabs, spaces, newlines, etc.
		return str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $minify );
	}
}

/**
 * Returns the excerpt length for portfolio posts.
 *
 * @since 4.0.0
 * @param  string $page_id        The id of the current page or post.
 * @return string/boolean The excerpt length for the post; false if full content should be shown.
 **/
function avada_get_portfolio_excerpt_length( $page_id = '' ) {
	$excerpt_length = false;

	if ( fusion_get_option( 'portfolio_content_length', 'portfolio_content_length', $page_id ) == 'excerpt' ) {
		// Determine the correct excerpt length.
		if ( fusion_get_page_option( 'portfolio_excerpt', $page_id ) ) {
			$excerpt_length = fusion_get_page_option( 'portfolio_excerpt', $page_id );
		} else {
			$excerpt_length = Avada()->settings->get( 'excerpt_length_portfolio' );
		}
	} elseif ( ! $page_id && 'Excerpt' === Avada()->settings->get( 'portfolio_content_length' ) ) {
		$excerpt_length = Avada()->settings->get( 'excerpt_length_portfolio' );
	}

	return $excerpt_length;

}

if ( ! function_exists( 'fusion_get_post_content' ) ) {
	/**
	 * Return the post content, either excerpted or in full length.
	 *
	 * @param  string  $page_id        The id of the current page or post.
	 * @param  string  $excerpt        Can be either 'blog' (for main blog page), 'portfolio' (for portfolio page template) or 'yes' (for shortcodes).
	 * @param  integer $excerpt_length Length of the excerpts.
	 * @param  boolean $strip_html     Can be used by shortcodes for a custom strip html setting.
	 * @return string Post content.
	 **/
	function fusion_get_post_content( $page_id = '', $excerpt = 'blog', $excerpt_length = 55, $strip_html = false ) {

		$content_excerpted = false;

		// Main blog page.
		if ( 'blog' == $excerpt ) {

			// Check if the content should be excerpted.
			if ( strtolower( Avada()->settings->get( 'content_length' ) ) === 'excerpt' ) {
				$content_excerpted = true;

				// Get the excerpt length.
				$excerpt_length = Avada()->settings->get( 'excerpt_length_blog' );
			}

			// Check if HTML should be stripped from contant.
			if ( Avada()->settings->get( 'strip_html_excerpt' ) ) {
				$strip_html = true;
			}

			// Portfolio page templates.
		} elseif ( 'portfolio' == $excerpt ) {
			// Check if the content should be excerpted.
			$portfolio_excerpt_length = avada_get_portfolio_excerpt_length( $page_id );
			if ( false !== $portfolio_excerpt_length ) {
				$excerpt_length = $portfolio_excerpt_length;
				$content_excerpted = true;
			}

			// Check if HTML should be stripped from contant.
			if ( Avada()->settings->get( 'portfolio_strip_html_excerpt' ) ) {
				$strip_html = true;
			}
			// Shortcodes.
		} elseif ( 'yes' == $excerpt ) {
			$content_excerpted = true;
		}

		// Sermon specific additional content.
		if ( 'wpfc_sermon' == get_post_type( get_the_ID() ) ) {
			return avada_get_sermon_content( true );
		}

		// Return excerpted content.
		if ( $content_excerpted ) {
			return fusion_get_post_content_excerpt( $excerpt_length, $strip_html );
		}

		// Return full content.
		ob_start();
		the_content();
		return ob_get_clean();

	}
}

if ( ! function_exists( 'fusion_get_post_content_excerpt' ) ) {
	/**
	 * Do the actual custom excerpting for of post/page content.
	 *
	 * @param  string  $limit      Maximum number of words or chars to be displayed in excerpt.
	 * @param  boolean $strip_html Set to TRUE to strip HTML tags from excerpt.
	 * @return string 				The custom excerpt.
	 **/
	function fusion_get_post_content_excerpt( $limit, $strip_html ) {
		global $more;

		$content = '';

		$limit = intval( $limit );

		// If excerpt length is set to 0, return empty.
		if ( 0 === $limit ) {
			return $content;
		}

		// Set a default excerpt limit if none is set.
		if ( ! $limit && 0 != $limit ) {
			$limit = 285;
		}

		// Make sure $strip_html is a boolean.
		if ( 'true' == $strip_html || true == $strip_html ) {
			$strip_html = true;
		} else {
			$strip_html = false;
		}

		$custom_excerpt = false;

		$post = get_post( get_the_ID() );

		// Check if the more tag is used in the post.
		$pos = strpos( $post->post_content, '<!--more-->' );

		// Check if the read more [...] should link to single post.
		$read_more_text = apply_filters( 'avada_blog_read_more_excerpt', '&#91;...&#93;' );

		if ( Avada()->settings->get( 'link_read_more' ) ) {
			$read_more = ' <a href="' . get_permalink( get_the_ID() ) . '">' . $read_more_text . '</a>';
		} else {
			$read_more = ' ' . $read_more_text;
		}

		if ( ! Avada()->settings->get( 'disable_excerpts' ) ) {
			$read_more = '';
		}

		// HTML tags should be stripped.
		if ( $strip_html ) {
			$more = 0;
			$raw_content = wp_strip_all_tags( get_the_content( '{{read_more_placeholder}}' ), '<p>' );

			// Strip out all attributes.
			$raw_content = preg_replace( '/<(\w+)[^>]*>/', '<$1>', $raw_content );
			$raw_content = str_replace( '{{read_more_placeholder}}', $read_more, $raw_content );

			if ( $post->post_excerpt || false !== $pos ) {
				$more = 0;
				if ( ! $pos ) {
					if ( strlen( get_the_excerpt() ) === strpos( get_the_excerpt(), '[...]' ) + 5 ) {
						$raw_content = substr( $raw_content, 0, -5 );
					}
					$raw_content = wp_strip_all_tags( get_the_excerpt(), '<p>' ) . $read_more;
				}

				$custom_excerpt = true;
			}
			// HTML tags remain in excerpt.
		} else {
			$more = 0;
			$raw_content = get_the_content( $read_more );
			if ( $post->post_excerpt || false !== $pos ) {
				$more = 0;
				if ( ! $pos ) {
					if ( strlen( get_the_excerpt() ) === strpos( get_the_excerpt(), '[...]' ) + 5 ) {
						$raw_content = substr( $raw_content, 0, -5 );
					}
					$raw_content = wp_strip_all_tags( get_the_excerpt(), '<p>' ) . $read_more;
				}
				$custom_excerpt = true;
			}
		}

		// We have our raw post content and need to cut it down to the excerpt limit.
		if ( ( $raw_content && false === $custom_excerpt ) || 'product' == $post->post_type ) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback( "/$pattern/s", 'avada_extract_shortcode_contents', $raw_content );

			// Check if the excerpting should be char or word based.
			if ( Avada()->settings->get( 'excerpt_base' ) == 'Characters' ) {
				$content = mb_substr( $content, 0, $limit );
				if ( 0 != $limit && Avada()->settings->get( 'disable_excerpts' ) ) {
					$content .= $read_more;
				}
				// Excerpting is word based.
			} else {
				$content = explode( ' ', $content, $limit + 1 );
				if ( count( $content ) > $limit ) {
					array_pop( $content );
					if ( ! Avada()->settings->get( 'disable_excerpts' ) ) {
						$content = implode( ' ', $content );
					} else {
						$content = implode( ' ', $content );
						if ( 0 != $limit ) {
							if ( Avada()->settings->get( 'link_read_more' ) ) {
								$content .= $read_more;
							} else {
								$content .= $read_more;
							}
						}
					}
				} else {
					$content = implode( ' ', $content );
				}
			}

			if ( 0 != $limit && ! $strip_html ) {
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
			} else {
				$content = '<p>' . $content . '</p>';
			}

			$content = do_shortcode( $content );

			return $content;
		}

		// If we have a custom excerpt, e.g. using the <!--more--> tag.
		if ( true == $custom_excerpt ) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback( "/$pattern/s", 'avada_extract_shortcode_contents', $raw_content );
			if ( true == $strip_html ) {
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
				$content = do_shortcode( $content );
			} else {
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
			}
		}

		// If the custom excerpt field is used, just use that contents.
		if ( has_excerpt() && 'product' != $post->post_type ) {
			$content = '<p>' . do_shortcode( get_the_excerpt() ) . '</p>';
		}

		return $content;
	}
}

if ( ! function_exists( 'fusion_get_attachment_data_by_url' ) ) {
	/**
	 * Get attachment data by URL.
	 *
	 * @param  string $image_url  The Image URL.
	 * @param  string $logo_field The logo field.
	 * @return array              Image Details.
	 */
	function fusion_get_attachment_data_by_url( $image_url, $logo_field = '' ) {
		global $wpdb;

		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

		if ( $attachment ) {
			return wp_get_attachment_metadata( $attachment[0] );
		}
		// Import the image to media library.
		$import_image = fusion_import_to_media_library( $image_url, $logo_field );
		if ( $import_image ) {
			return wp_get_attachment_metadata( $import_image );
		}
		return false;
	}
}

if ( ! function_exists( 'fusion_import_to_media_library' ) ) {
	/**
	 * Imports a file to the media library.
	 *
	 * @param string $url The file URL.
	 * @param string $theme_option If we're doing this for a theme option,
	 *                             specify which option that is to properly save the data.
	 */
	function fusion_import_to_media_library( $url, $theme_option = '' ) {

		// Gives us access to the download_url() and wp_handle_sideload() functions.
		require_once( ABSPATH . 'wp-admin/includes/file.php' );

		$timeout_seconds = 30;

		// Download file to temp dir.
		$temp_file = download_url( $url, $timeout_seconds );

		if ( ! is_wp_error( $temp_file ) ) {
			// Array based on $_FILE as seen in PHP file uploads.
			$file = array(
				'name' => basename( $url ),
				'type' => 'image/png',
				'tmp_name' => $temp_file,
				'error' => 0,
				'size' => filesize( $temp_file ),
			);

			$overrides = array(
				// Tells WordPress to not look for the POST form
				// fields that would normally be present, default is true,
				// we downloaded the file from a remote server, so there
				// will be no form fields.
				'test_form' => false,

				// Setting this to false lets WordPress allow empty files, not recommended.
				'test_size' => true,

				// A properly uploaded file will pass this test.
				// There should be no reason to override this one.
				'test_upload' => true,
			);

			// Move the temporary file into the uploads directory.
			$results = wp_handle_sideload( $file, $overrides );

			if ( ! empty( $results['error'] ) ) {
				return false;
			}
			$attachment = array(
				'guid'           => $results['url'],
				'post_mime_type' => $results['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $results['file'] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			// Insert the attachment.
			$attach_id = wp_insert_attachment( $attachment, $results['file'] );

			// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Generate the metadata for the attachment, and update the database record.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $results['file'] );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			if ( $theme_option ) {
				Avada()->settings->set( $theme_option, $results['url'] );
			}

			return $attach_id;
		}
		return false;
	}
}
/* Omit closing PHP tag to avoid "Headers already sent" issues. */
