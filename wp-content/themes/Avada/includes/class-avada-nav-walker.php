<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

// Dont duplicate me!
if ( ! class_exists( 'Avada_Nav_Walker' ) ) {

	/**
	 * The main navwalker.
	 */
	class Avada_Nav_Walker extends Walker_Nav_Menu {

		/**
		 * Do we use default styling or a button?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_style = '';

		/**
		 * Are we currently rendering a mega menu?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_status = '';

		/**
		 * Use full width mega menu?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_width = '';

		/**
		 * How many columns should the mega menu have?
		 *
		 * @access  private
		 * @var int
		 */
		private $num_of_columns = 0;

		/**
		 * Mega menu allow for 6 columns at max.
		 *
		 * @access  private
		 * @var int
		 */
		private $max_num_of_columns = 6;

		/**
		 * Total number of columns for a single megamenu?
		 *
		 * @access  private
		 * @var int
		 */
		private $total_num_of_columns = 0;

		/**
		 * Number of rows in the mega menu.
		 *
		 * @access  private
		 * @var int
		 */
		private $num_of_rows = 1;

		/**
		 * Holds number of columns per row.
		 *
		 * @access  private
		 * @var array
		 */
		private $submenu_matrix = array();

		/**
		 * How large is the width of a column?
		 *
		 * @access  private
		 * @var int|string
		 */
		private $menu_megamenu_columnwidth = 0;

		/**
		 * How large is the width of each row?
		 *
		 * @access  private
		 * @var array
		 */
		private $menu_megamenu_rowwidth_matrix = array();

		/**
		 * How large is the overall width of a column?
		 *
		 * @access  private
		 * @var int
		 */
		private $menu_megamenu_maxwidth = 0;

		/**
		 * Should a colum title be displayed?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_title = '';

		/**
		 * Should one column be a widget area?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_widget_area = '';

		/**
		 * Does the item have an icon?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_icon = '';

		/**
		 * Does the item have a thumbnail?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_thumbnail = '';

		/**
		 * Middle logo menu breaking point
		 *
		 * @access  private
		 * @var init
		 */
		private $middle_logo_menu_break_point = null;

		/**
		 * Middle logo menu number of top level items displayed
		 *
		 * @access  private
		 * @var init
		 */
		private $no_of_top_level_items_displayed = 0;

		/**
		 * Sets the overall width of the megamenu wrappers
		 */
		private function set_megamenu_max_width() {

			// Set overall width of megamenu.
			$site_width         = (int) str_replace( 'px', '', Avada()->settings->get( 'site_width' ) );
			$megamenu_max_width = (int) Avada()->settings->get( 'megamenu_max_width' );
			$megmanu_width      = 0;

			$megamenu_width = $megamenu_max_width;
			// Site width in px.
			if ( false !== strpos( Avada()->settings->get( 'site_width' ), 'px' ) ) {
				$megamenu_width = $site_width;
				if ( $site_width > $megamenu_max_width && 0 < $megamenu_max_width ) {
					$megamenu_width = $megamenu_max_width;
				}
			}
			$this->menu_megamenu_maxwidth = $megamenu_width;
		}

		/**
		 * Start level.
		 *
		 * @see Walker::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth Depth of page. Used for padding.
		 * @param  array  $args Not used.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {

			if ( 0 === $depth && 'enabled' === $this->menu_megamenu_status ) {
				// Set overall width of megamenu.
				if ( ! $this->menu_megamenu_maxwidth ) {
					$this->set_megamenu_max_width();
				}
				$output .= '{first_level}';
				$output .= '<div class="fusion-megamenu-holder" {megamenu_final_width}><ul class="fusion-megamenu {megamenu_border}">';
			} elseif ( 2 <= $depth && 'enabled' === $this->menu_megamenu_status ) {
				$output .= '<ul class="sub-menu deep-level">';
			} else {
				$output .= '<ul class="sub-menu">';
			}

		}

		/**
		 * End level.
		 *
		 * @see Walker::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth Depth of page. Used for padding.
		 * @param  array  $args Not used.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {

			$row_width = '';

			if ( 0 === $depth && 'enabled' === $this->menu_megamenu_status ) {

				$output .= '</ul></div><div style="clear:both;"></div></div></div>';

				if ( $this->total_num_of_columns < $this->max_num_of_columns ) {
					$col_span = ' col-span-' . $this->total_num_of_columns * 2;
				} else {
					$col_span = ' col-span-' . $this->max_num_of_columns * 2;
				}

				if ( 'fullwidth' === $this->menu_megamenu_width ) {
					$col_span = ' col-span-12 fusion-megamenu-fullwidth';
					// Overall megamenu wrapper width in px is max width for fullwidth megamenu.
					$wrapper_width = $this->menu_megamenu_maxwidth;
				} else {
					// Calc overall megamenu wrapper width in px.
					$wrapper_width = max( $this->menu_megamenu_rowwidth_matrix ) * $this->menu_megamenu_maxwidth;
				}

				$output = str_replace( '{first_level}', '<div class="fusion-megamenu-wrapper {fusion_columns} columns-' . $this->total_num_of_columns . $col_span . '" data-maxwidth="' . $this->menu_megamenu_maxwidth . '"><div class="row">', $output );

				$output = str_replace( '{megamenu_final_width}', 'style="width:' . $wrapper_width . 'px;" data-width="' . $wrapper_width . '"', $output );

				if ( $this->total_num_of_columns > $this->max_num_of_columns ) {
					$output = str_replace( '{megamenu_border}', 'fusion-megamenu-border', $output );
				} else {
					$output = str_replace( '{megamenu_border}', '', $output );
				}

				foreach ( $this->submenu_matrix as $row => $columns ) {
					$layout_columns = 12 / $columns;
					$layout_columns = ( '5' == $columns ) ? 2 : $layout_columns;

					if ( $columns < $this->max_num_of_columns ) {
						$row_width = 'style="width:' . $columns / $this->max_num_of_columns * 100 . '% !important;"';
					}

					$output = str_replace( '{row_width_' . $row . '}', $row_width, $output );

					if ( ( $row - 1 ) * $this->max_num_of_columns + $columns < $this->total_num_of_columns ) {
						$output = str_replace( '{row_number_' . $row . '}', 'fusion-megamenu-row-columns-' . $columns . ' fusion-megamenu-border', $output );
					} else {
						$output = str_replace( '{row_number_' . $row . '}', 'fusion-megamenu-row-columns-' . $columns, $output );
					}
					$output = str_replace( '{current_row_' . $row . '}', 'fusion-megamenu-columns-' . $columns . ' col-lg-' . $layout_columns . ' col-md-' . $layout_columns . ' col-sm-' . $layout_columns, $output );

					$output = str_replace( '{fusion_columns}', 'fusion-columns-' . $columns . ' columns-per-row-' . $columns, $output );
				}
			} else {
				$output .= '</ul>';
			}
		}

		/**
		 * Start element.
		 *
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args The arguments.
		 * @param int    $id Menu item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$item_output = $class_columns = '';

			if ( Avada()->settings->get( 'header_layout' ) == 'v7' ) {
				if ( ! isset( $this->middle_logo_menu_break_point ) ) {

					$is_search_icon_enabled = Avada()->settings->get( 'main_nav_search_icon' );
					$is_cart_icon_enabled = Avada()->settings->get( 'woocommerce_cart_link_main_nav' );

					$middle_logo_menu_elements = wp_get_nav_menu_items( $args->menu );
		      		$middle_logo_menu_top_level_elements = 0;

					foreach ( $middle_logo_menu_elements as $menu_element ) {
						if ( '0' === $menu_element->menu_item_parent ) {
							$middle_logo_menu_top_level_elements++;
						}
					}

					if ( $is_search_icon_enabled ) {
						$middle_logo_menu_top_level_elements++;
					}

					if ( $is_cart_icon_enabled ) {
						$middle_logo_menu_top_level_elements++;
					}

					$top_level_menu_items_count = count( $middle_logo_menu_top_level_elements );

					if ( 0 === $top_level_menu_items_count ) {
						$this->middle_logo_menu_break_point = $middle_logo_menu_top_level_elements / 2;
					} else {
						if ( $is_search_icon_enabled || $is_cart_icon_enabled ) {
							$this->middle_logo_menu_break_point = floor( $middle_logo_menu_top_level_elements / 2 );
						} else {
							$this->middle_logo_menu_break_point = ceil( $middle_logo_menu_top_level_elements / 2 );
						}
					}
				}
			}

			// Set some vars.
			// Megamenu is enabled.
			if ( Avada()->settings->get( 'disable_megamenu' ) ) {
				if ( 0 === $depth ) {
					$this->menu_megamenu_status = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_status', true );
					$this->menu_megamenu_width  = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_width', true );
					$allowed_columns = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_columns', true );
					if ( 'auto' !== $allowed_columns ) {
						$this->max_num_of_columns = $allowed_columns;
					}
					$this->num_of_columns                                      = $this->total_num_of_columns = 0;
					$this->num_of_rows                                         = 1;
					$this->menu_megamenu_rowwidth_matrix                       = array();
					$this->menu_megamenu_rowwidth_matrix[ $this->num_of_rows ] = 0;
				}

				$this->menu_style               = get_post_meta( $item->ID, '_menu_item_fusion_menu_style', true );
				$this->menu_megamenu_title      = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_title', true );
				$this->menu_megamenu_widgetarea = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_widgetarea', true );
				$this->menu_megamenu_icon       = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_icon', true );
				$this->menu_megamenu_thumbnail  = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_thumbnail', true );
				// Megamenu is disabled.
			} else {
				$this->menu_megamenu_status = 'disabled';
				$this->menu_style           = get_post_meta( $item->ID, '_menu_item_fusion_menu_style', true );
				$this->menu_megamenu_icon   = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_icon', true );
			}
			// We are inside a megamenu.
			if ( 1 === $depth && 'enabled' === $this->menu_megamenu_status ) {

				if ( get_post_meta( $item->ID, '_menu_item_fusion_megamenu_columnwidth', true ) ) {
					$this->menu_megamenu_columnwidth = get_post_meta( $item->ID, '_menu_item_fusion_megamenu_columnwidth', true );
				} else {
					if ( 'fullwidth' === $this->menu_megamenu_width && $this->max_num_of_columns ) {
						$this->menu_megamenu_columnwidth = 100 / $this->max_num_of_columns . '%';
					} elseif ( '1' == $this->max_num_of_columns ) {
						$this->menu_megamenu_columnwidth = '100%';
					} else {
						$this->menu_megamenu_columnwidth = '16.6666%';
					}
				}

				$this->num_of_columns++;
				$this->total_num_of_columns++;

				// Check if we need to start a new row.
				if ( $this->num_of_columns > $this->max_num_of_columns ) {
					$this->num_of_columns = 1;
					$this->num_of_rows++;

					// Start new row width calculation.
					$this->menu_megamenu_rowwidth_matrix[ $this->num_of_rows ] = floatval( $this->menu_megamenu_columnwidth ) / 100;

					$output .= '</ul><ul class="fusion-megamenu fusion-megamenu-row-' . $this->num_of_rows . ' {row_number_' . $this->num_of_rows . '}" {row_width_' . $this->num_of_rows . '}>';
				} else {
					$this->menu_megamenu_rowwidth_matrix[ $this->num_of_rows ] += floatval( $this->menu_megamenu_columnwidth ) / 100;
				}

				$this->submenu_matrix[ $this->num_of_rows ] = $this->num_of_columns;

				if ( $this->max_num_of_columns < $this->num_of_columns ) {
					$this->max_num_of_columns = $this->num_of_columns;
				}

				$title = apply_filters( 'the_title', $item->title, $item->ID );

				if ( ! ( ( empty( $item->url ) || '#' === $item->url || 'http://' === $item->url )  && 'disabled' === $this->menu_megamenu_title ) ) {
					$heading      = do_shortcode( $title );
					$link         = '';
					$link_closing = '';
					$target       = '';
					$link_class   = '';

					if ( ! empty( $item->url ) && '#' !== $item->url && 'http://' !== $item->url ) {

						if ( ! empty( $item->target ) ) {
							$target = ' target="' . $item->target . '"';
						}
						if ( 'disabled' === $this->menu_megamenu_title ) {
							$link_class = ' class="fusion-megamenu-title-disabled"';
						}

						$link         = '<a href="' . $item->url . '"' . $target . $link_class . '>';
						$link_closing = '</a>';
					}

					// Check if we need to set an image.
					$title_enhance = '';
					if ( ! empty( $this->menu_megamenu_thumbnail ) ) {
						$title_enhance = '<span class="fusion-megamenu-icon"><img src="' . $this->menu_megamenu_thumbnail . '"></span>';
					} elseif ( ! empty( $this->menu_megamenu_icon ) ) {
						$title_enhance = '<span class="fusion-megamenu-icon"><i class="fa glyphicon ' . avada_font_awesome_name_handler( $this->menu_megamenu_icon ) . '"></i></span>';
					} elseif ( 'disabled' === $this->menu_megamenu_title ) {
						$title_enhance = '<span class="fusion-megamenu-bullet"></span>';
					}

					$heading = $link . $title_enhance . $title . $link_closing;

					if ( 'disabled' !== $this->menu_megamenu_title ) {
						$item_output .= "<div class='fusion-megamenu-title'>" . $heading . '</div>';
					} else {
						$item_output .= $heading;
					}
				}

				if ( $this->menu_megamenu_widgetarea && is_active_sidebar( $this->menu_megamenu_widgetarea ) ) {
					ob_start();
					dynamic_sidebar( $this->menu_megamenu_widgetarea );
					$item_output .= '<div class="fusion-megamenu-widgets-container second-level-widget">' . ob_get_clean() . '</div>';
				}

				$class_columns  = ' {current_row_' . $this->num_of_rows . '}';

			} elseif ( 2 === $depth && 'enabled' === $this->menu_megamenu_status && $this->menu_megamenu_widgetarea ) {

				if ( is_active_sidebar( $this->menu_megamenu_widgetarea ) ) {
					ob_start();
					dynamic_sidebar( $this->menu_megamenu_widgetarea );
					$item_output .= '<div class="fusion-megamenu-widgets-container third-level-widget">' . ob_get_clean() . '</div>';
				}
			} else {

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? esc_attr( $item->attr_title ) : '';
				$atts['target'] = ! empty( $item->target )     ? esc_attr( $item->target )     : '';
				$atts['rel']    = ! empty( $item->xfn )        ? esc_attr( $item->xfn )        : '';
				$atts['href']   = ! empty( $item->url )        ? esc_attr( $item->url )        : '';

				if ( 'v7' === Avada()->settings->get( 'header_layout' ) && '0' === $item->menu_item_parent ) {
					$atts['class'] = 'fusion-top-level-link';
				}

				if ( '_blank' === $atts['target'] ) {
					$atts['rel'] = ( ( $atts['rel'] ) ? $atts['rel'] . ' noopener noreferrer' : 'noopener noreferrer' );
				}
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}

				$item_output .= $args->before . '<a ' . $attributes . '>';

				// For right side header add the caret icon at the beginning.
				if ( 0 === $depth && $args->has_children && Avada()->settings->get( 'menu_display_dropdown_indicator' ) && 'v6' !== Avada()->settings->get( 'header_layout' ) && 'Right' === Avada()->settings->get( 'header_position' ) ) {
					$item_output .= ' <span class="fusion-caret"><i class="fusion-dropdown-indicator"></i></span>';
				}

				// Check if we need to set an image.
				$icon_wrapper_class = 'fusion-megamenu-icon';
				if ( 0 === $depth && $this->menu_style ) {
					$icon_wrapper_class = ( is_rtl() ) ? 'button-icon-divider-right' : 'button-icon-divider-left';
				}

				$icon = '';
				if ( ! empty( $this->menu_megamenu_thumbnail ) && 'enabled' === $this->menu_megamenu_status ) {
					$icon = '<span class="' . $icon_wrapper_class . ' fusion-megamenu-image"><img src="' . $this->menu_megamenu_thumbnail . '"></span>';
				} elseif ( ! empty( $this->menu_megamenu_icon ) ) {
					$icon = '<span class="' . $icon_wrapper_class . '"><i class="fa glyphicon ' . $this->menu_megamenu_icon . '"></i></span>';
				} elseif ( 0 !== $depth && 'enabled' === $this->menu_megamenu_status ) {
					$icon = '<span class="fusion-megamenu-bullet"></span>';
				}

				$classes = '';
				// Check if we have a menu button.
				if ( 0 === $depth ) {
					$classes = 'menu-text';
					if ( $this->menu_style ) {
						$classes .= ' fusion-button button-default ' . str_replace( 'fusion-', '', $this->menu_style );
						// Button should have 3D effect.
						if ( '3d' === Avada()->settings->get( 'button_type' ) ) {
							$classes .= ' button-3d';
						}
					}

					$item_output .= '<span class="' . $classes . '">' . $icon;
					// Normal menu item.
				} else {
					$item_output .= $icon . '<span class="' . $classes . '">';
				}

				$title = $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

				if ( false !== strpos( $icon, 'button-icon-divider-left' ) ) {
					$title = '<span class="fusion-button-text-left">' . $title . '</span>';
				} elseif ( false !== strpos( $icon, 'button-icon-divider-right' ) ) {
					$title = '<span class="fusion-button-text-right">' . $title . '</span>';
				}

				$item_output .= $title;
				$item_output .= '</span>';

				// For top header and left side header add the caret icon at the end.
				if ( 0 === $depth && $args->has_children && Avada()->settings->get( 'menu_display_dropdown_indicator' ) && 'v6' !== Avada()->settings->get( 'header_layout' ) && 'Right' !== Avada()->settings->get( 'header_position' ) ) {
					$item_output .= ' <span class="fusion-caret"><i class="fusion-dropdown-indicator"></i></span>';
				}

				$item_output .= '</a>' . $args->after;

			}

			// Check if we need to apply a divider.
			if ( 'enabled' !== $this->menu_megamenu_status && ( ( 0 == strcasecmp( $item->attr_title, 'divider' ) ) || ( 0 == strcasecmp( $item->title, 'divider' ) ) ) ) {

				$output .= '<li role="presentation" class="divider">';

			} else {

				$class_names  = '';
				$column_width = '';
				$custom_class_data = '';
				$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[]    = 'menu-item-' . $item->ID;

				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

				if ( 0 === $depth && $args->has_children ) {
					$class_names .= ( 'enabled' === $this->menu_megamenu_status ) ? ' fusion-megamenu-menu' : ' fusion-dropdown-menu';
				}

				if ( 0 === $depth && $this->menu_style ) {
					$class_names .= ' fusion-menu-item-button';
				}

				if ( 1 === $depth ) {
					if ( 'enabled' === $this->menu_megamenu_status ) {
						$class_names .= ' fusion-megamenu-submenu';

						if ( 'disabled' === $this->menu_megamenu_title ) {
							$class_names .= ' fusion-megamenu-submenu-notitle';
						}

						if ( 'fullwidth' !== $this->menu_megamenu_width ) {
							$width        = $this->menu_megamenu_maxwidth * floatval( $this->menu_megamenu_columnwidth ) / 100;
							$column_width = 'style="width:' . $width . 'px;max-width:' . $width . 'px;" data-width="' . $width . '"';
						}
					} else {
						$class_names .= ' fusion-dropdown-submenu';
					}
				}

				if ( isset( $item->classes[0] ) && ! empty( $item->classes[0] ) ) {
					$custom_class_data = ' data-classes="' . $item->classes[0] . '"';
				}

				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . $class_columns . '"' : '';

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

				$output .= '<li ' . $id . ' ' . $class_names . ' ' . $column_width . $custom_class_data . ' >';
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		/**
		 * End Element.
		 *
		 * @see Walker::end_el()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Page data object. Not used.
		 * @param int    $depth Depth of page. Not Used.
		 * @param  array  $args Not used.
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			$output .= '</li>';

			if ( '0' === $item->menu_item_parent ) {
				$this->no_of_top_level_items_displayed++;
			}

			if ( 'v7' === Avada()->settings->get( 'header_layout' ) && 'Top' === Avada()->settings->get( 'header_position' ) && $this->middle_logo_menu_break_point == $this->no_of_top_level_items_displayed && '0' === $item->menu_item_parent ) {
				ob_start();
				get_template_part( 'templates/logo' );
				$output .= ob_get_clean();
			}
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @see Walker::start_el()
		 * @since 2.5.0
		 *
		 * @param object $element Data object.
		 * @param array  $children_elements List of elements to continue traversing.
		 * @param int    $max_depth Max depth to traverse.
		 * @param int    $depth Depth of current element.
		 * @param array  $args The arguments.
		 * @param string $output Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			$id_field = $this->db_fields['id'];

			// Display this element.
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a manu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'manage_options' ) ) {
				return null;
			}
		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
