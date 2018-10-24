<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Set values in builder specific to Avada.
 */
class Fusion_Builder_Filters {

	/**
	 * A single instance of this object.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var null|object
	 */
	private static $instance = null;

	/**
	 * The shortcode > option map description array.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var array
	 */
	private static $shortcode_option_map_descriptions = array();

	/**
	 * The shortcode > option map default array.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var array
	 */
	private static $shortcode_option_map_defaults = array();

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @since 5.0.0
	 * @return Fusion_Builder_Filters
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new Fusion_Builder_Filters();
		}
		return self::$instance;

	}

	/**
	 * The class constructor.
	 *
	 * @access private
	 */
	private function __construct() {
		self::set_shortcode_option_map_descriptions();
		self::set_shortcode_option_map_defaults();

		add_filter( 'fusion_builder_option_description', array( $this, 'set_builder_descriptions' ), 10, 3 );
		add_filter( 'fusion_builder_option_default', array( $this, 'set_builder_defaults' ), 10, 3 );
		add_filter( 'fusion_builder_option_value', array( $this, 'set_builder_values' ), 10, 3 );
		add_filter( 'fusion_builder_option_dependency', array( $this, 'set_builder_dependencies' ), 10, 3 );
		add_filter( 'fusion_builder_import_message', array( $this, 'add_builder_import_message' ) );
		add_filter( 'fusion_builder_import_title', array( $this, 'add_builder_import_title' ) );

	}

	/**
	 * Set builder description with default appended.
	 *
	 * @since   5.0.0
	 * @param   string $description description being used.
	 * @param   string $shortcode name of shortcode.
	 * @param   string $option name of option.
	 * @return  string combined description with default value text.
	 */
	public function set_builder_descriptions( $description, $shortcode, $option ) {
		$default = '';
		$shortcode_option_map = self::$shortcode_option_map_descriptions;

		if ( 'animation_offset' === $option ) {
			$default = Avada()->settings->get_default_description( 'animation_offset', '', 'select' );

		}
		// Find and add relevant description.
		if ( isset( $shortcode_option_map[ $option ][ $shortcode ] ) ) {
			array( 'theme-option' => 'container_padding', 'subset' => array( 'top', 'right', 'bottom', 'left' ) );
			$setting = $shortcode_option_map[ $option ][ $shortcode ]['theme-option'];
			$subset = ( isset( $shortcode_option_map[ $option ][ $shortcode ]['subset'] ) ) ? $shortcode_option_map[ $option ][ $shortcode ]['subset'] : '';
			$type = ( isset( $shortcode_option_map[ $option ][ $shortcode ]['type'] ) ) ? $shortcode_option_map[ $option ][ $shortcode ]['type'] : '';

			if ( 'fusion_builder_container' === $shortcode && 'dimensions' === $option ) {
				$default = rtrim( Avada()->settings->get_default_description( $setting . '_default', $subset, $type ), '.' );
				$default .= __( ' on default template. ', 'Avada' );
				$default .= rtrim( Avada()->settings->get_default_description( $setting . '_100', $subset, $type ), '.' );
				$default .= __( ' on 100% width template.', 'Avada' );
			} else {
				$default = Avada()->settings->get_default_description( $setting, $subset, $type );
			}

			if ( 'range' === $type || isset( $shortcode_option_map[ $option ][ $shortcode ]['reset'] ) ) {
				$default .= '  <span class="fusion-builder-default-reset"><a href="#" id="default-' . $option . '" class="fusion-range-default fusion-hide-from-atts" type="radio" name="' . $option . '" value="" data-default="' . Avada()->settings->get( $setting, $subset ) . '">' . esc_attr( 'Reset to default.', 'Avada' ) . '</a><span>' . esc_attr( 'Using default value.', 'Avada' ) . '</span></span>';
			}
		}
		if ( 'hide_on_mobile' == $option ) {
			$link = '<a href="' . Avada()->settings->get_setting_link( 'visibility_small' ) . '" target="_blank" rel="noopener noreferrer">' . esc_attr( 'Theme Options' , 'Avada' ) . '</a>';
			$default = sprintf( __( '  Each of the 3 sizes has a custom width setting on the Fusion Builder Elements tab in the %s.', 'Avada' ), $link );
		}

		return $description . $default;
	}

	/**
	 * Set the element > option mapping for description appendix.
	 *
	 * @since   5.0.0
	 * @return  void
	 */
	public function set_shortcode_option_map_descriptions() {
		$shortcode_option_map = array();

		// Button.
		$shortcode_option_map['size']['fusion_button'] = array( 'theme-option' => 'button_size', 'type' => 'select' );
		$shortcode_option_map['stretch']['fusion_button'] = array( 'theme-option' => 'button_span', 'type' => 'select' );
		$shortcode_option_map['type']['fusion_button'] = array( 'theme-option' => 'button_type', 'type' => 'select' );
		$shortcode_option_map['shape']['fusion_button'] = array( 'theme-option' => 'button_shape', 'type' => 'select' );
		$shortcode_option_map['button_gradient_top_color']['fusion_button'] = array( 'theme-option' => 'button_gradient_top_color', 'reset' => true );
		$shortcode_option_map['button_gradient_bottom_color']['fusion_button'] = array( 'theme-option' => 'button_gradient_bottom_color', 'reset' => true );
		$shortcode_option_map['button_gradient_top_color_hover']['fusion_button'] = array( 'theme-option' => 'button_gradient_top_color_hover', 'reset' => true );
		$shortcode_option_map['button_gradient_bottom_color_hover']['fusion_button'] = array( 'theme-option' => 'button_gradient_bottom_color_hover', 'reset' => true );
		$shortcode_option_map['accent_color']['fusion_button'] = array( 'theme-option' => 'button_accent_color', 'reset' => true );
		$shortcode_option_map['accent_hover_color']['fusion_button'] = array( 'theme-option' => 'button_accent_hover_color', 'reset' => true );
		$shortcode_option_map['bevel_color']['fusion_button'] = array( 'theme-option' => 'button_bevel_color', 'reset' => true );
		$shortcode_option_map['border_width']['fusion_button'] = array( 'theme-option' => 'button_border_width', 'type' => 'range' );

		$shortcode_option_map['button_fullwidth']['fusion_login'] = array( 'theme-option' => 'button_span', 'type' => 'yesno' );
		$shortcode_option_map['button_fullwidth']['fusion_register'] = array( 'theme-option' => 'button_span', 'type' => 'yesno' );
		$shortcode_option_map['button_fullwidth']['fusion_lost_password'] = array( 'theme-option' => 'button_span', 'type' => 'yesno' );

		$shortcode_option_map['button_size']['fusion_tagline_box'] = array( 'theme-option' => 'button_size', 'type' => 'select' );
		$shortcode_option_map['button_type']['fusion_tagline_box'] = array( 'theme-option' => 'button_type', 'type' => 'select' );
		$shortcode_option_map['button_shape']['fusion_tagline_box'] = array( 'theme-option' => 'button_shape', 'type' => 'select' );

		// Checklist.
		$shortcode_option_map['iconcolor']['fusion_checklist'] = array( 'theme-option' => 'checklist_icons_color', 'reset' => true );
		$shortcode_option_map['circle']['fusion_checklist'] = array( 'theme-option' => 'checklist_circle', 'type' => 'yesno' );
		$shortcode_option_map['circlecolor']['fusion_checklist'] = array( 'theme-option' => 'checklist_circle_color', 'reset' => true );

		// Columns.
		$shortcode_option_map['dimension_margin']['fusion_builder_column'] = array( 'theme-option' => 'col_margin', 'subset' => array( 'top', 'bottom' ) );
		$shortcode_option_map['dimension_margin']['fusion_builder_column_inner'] = array( 'theme-option' => 'col_margin', 'subset' => array( 'top', 'bottom' ) );

		// Container.
		$shortcode_option_map['background_color']['fusion_builder_container'] = array( 'theme-option' => 'full_width_bg_color', 'reset' => true );
		$shortcode_option_map['border_size']['fusion_builder_container'] = array( 'theme-option' => 'full_width_border_size', 'type' => 'range' );
		$shortcode_option_map['border_color']['fusion_builder_container'] = array( 'theme-option' => 'full_width_border_color', 'reset' => true );
		$shortcode_option_map['dimensions']['fusion_builder_container'] = array( 'theme-option' => 'container_padding', 'subset' => array( 'top', 'right', 'bottom', 'left' ) );

		// Content Box.
		$shortcode_option_map['backgroundcolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_bg_color', 'reset' => true );
		$shortcode_option_map['title_size']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_title_size' );
		$shortcode_option_map['title_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_title_color', 'reset' => true );
		$shortcode_option_map['body_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_body_color', 'reset' => true );
		$shortcode_option_map['icon_size']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_size' );
		$shortcode_option_map['iconcolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_color', 'reset' => true );
		$shortcode_option_map['icon_circle']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_circle', 'type' => 'select' );
		$shortcode_option_map['icon_circle_radius']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_circle_radius' );
		$shortcode_option_map['circlecolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_color', 'reset' => true );
		$shortcode_option_map['circlebordercolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_color', 'reset' => true );
		$shortcode_option_map['outercirclebordercolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_color', 'reset' => true );
		$shortcode_option_map['circlebordersize']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_size', 'type' => 'range' );
		$shortcode_option_map['outercirclebordersize']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_size' , 'type' => 'range' );
		$shortcode_option_map['icon_hover_type']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_hover_type', 'type' => 'select' );
		$shortcode_option_map['hover_accent_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_hover_animation_accent_color', 'reset' => true );
		$shortcode_option_map['link_type']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_link_type', 'type' => 'select' );
		$shortcode_option_map['link_area']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_link_area', 'type' => 'select' );
		$shortcode_option_map['link_target']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_link_target', 'type' => 'select' );
		$shortcode_option_map['margin_top']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_margin', 'subset' => 'top' );
		$shortcode_option_map['margin_bottom']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_margin', 'subset' => 'bottom' );

		$shortcode_option_map['backgroundcolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_bg_color', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['iconcolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_color', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['icon_circle_radius']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_circle_radius', 'type' => 'child' );
		$shortcode_option_map['circlecolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_color', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['circlebordercolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_color', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['outercirclebordercolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_color', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['circlebordersize']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_size', 'type' => 'child', 'reset' => true );
		$shortcode_option_map['outercirclebordersize']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_size', 'type' => 'child', 'reset' => true );

		// Countdown.
		$shortcode_option_map['timezone']['fusion_countdown'] = array( 'theme-option' => 'countdown_timezone', 'type' => 'select' );
		$shortcode_option_map['show_weeks']['fusion_countdown'] = array( 'theme-option' => 'countdown_show_weeks', 'type' => 'yesno' );
		$shortcode_option_map['background_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_background_color', 'reset' => true );
		$shortcode_option_map['background_image']['fusion_countdown'] = array( 'theme-option' => 'countdown_background_image', 'subset' => 'thumbnail' );
		$shortcode_option_map['background_repeat']['fusion_countdown'] = array( 'theme-option' => 'countdown_background_repeat' );
		$shortcode_option_map['background_position']['fusion_countdown'] = array( 'theme-option' => 'countdown_background_position' );
		$shortcode_option_map['counter_box_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_counter_box_color', 'reset' => true );
		$shortcode_option_map['counter_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_counter_text_color', 'reset' => true );
		$shortcode_option_map['heading_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_heading_text_color', 'reset' => true );
		$shortcode_option_map['subheading_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_subheading_text_color', 'reset' => true );
		$shortcode_option_map['link_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_link_text_color', 'reset' => true );
		$shortcode_option_map['link_target']['fusion_countdown'] = array( 'theme-option' => 'countdown_link_target',  'type' => 'select' );

		// Counter box.
		$shortcode_option_map['color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_color', 'reset' => true );
		$shortcode_option_map['title_size']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_title_size' );
		$shortcode_option_map['icon_size']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_icon_size' );
		$shortcode_option_map['body_color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_body_color', 'reset' => true );
		$shortcode_option_map['body_size']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_body_size' );
		$shortcode_option_map['border_color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_border_color', 'reset' => true );
		$shortcode_option_map['icon_top']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_icon_top', 'type' => 'yesno' );

		// Counter Circle.
		$shortcode_option_map['filledcolor']['fusion_counter_circle'] = array( 'theme-option' => 'counter_filled_color', 'reset' => true );
		$shortcode_option_map['unfilledcolor']['fusion_counter_circle'] = array( 'theme-option' => 'counter_unfilled_color', 'reset' => true );

		// Dropcap.
		$shortcode_option_map['color']['fusion_dropcap'] = array( 'theme-option' => 'dropcap_color', 'shortcode' => 'fusion_dropcap', 'reset' => true );

		// Flipboxes.
		$shortcode_option_map['background_color_front']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_bg', 'reset' => true );
		$shortcode_option_map['title_front_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_heading', 'reset' => true );
		$shortcode_option_map['text_front_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_text', 'reset' => true );
		$shortcode_option_map['background_color_back']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_bg', 'reset' => true );
		$shortcode_option_map['title_back_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_heading', 'reset' => true );
		$shortcode_option_map['text_back_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_text', 'reset' => true );
		$shortcode_option_map['border_size']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_border_size', 'type' => 'range' );
		$shortcode_option_map['border_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_border_color' );
		$shortcode_option_map['border_radius']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_border_radius' );

		// Icon Element.
		$shortcode_option_map['circlecolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_circle_color', 'reset' => true );
		$shortcode_option_map['circlebordercolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_border_color', 'reset' => true );
		$shortcode_option_map['iconcolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_color', 'reset' => true );

		// Image Frame.
		$shortcode_option_map['bordercolor']['fusion_imageframe'] = array( 'theme-option' => 'imgframe_border_color', 'reset' => true );
		$shortcode_option_map['bordersize']['fusion_imageframe'] = array( 'theme-option' => 'imageframe_border_size', 'type' => 'range' );
		$shortcode_option_map['borderradius']['fusion_imageframe'] = array( 'theme-option' => 'imageframe_border_radius' );
		$shortcode_option_map['stylecolor']['fusion_imageframe'] = array( 'theme-option' => 'imgframe_style_color', 'reset' => true );

		// Modal.
		$shortcode_option_map['background']['fusion_modal'] = array( 'theme-option' => 'modal_bg_color', 'reset' => true );
		$shortcode_option_map['border_color']['fusion_modal'] = array( 'theme-option' => 'modal_border_color', 'reset' => true );

		// Person.
		$shortcode_option_map['background_color']['fusion_person'] = array( 'theme-option' => 'person_background_color', 'reset' => true );
		$shortcode_option_map['pic_bordercolor']['fusion_person'] = array( 'theme-option' => 'person_border_color', 'reset' => true );
		$shortcode_option_map['pic_bordersize']['fusion_person'] = array( 'theme-option' => 'person_border_size', 'type' => 'range' );
		$shortcode_option_map['pic_borderradius']['fusion_person'] = array( 'theme-option' => 'person_border_radius' );
		$shortcode_option_map['pic_style_color']['fusion_person'] = array( 'theme-option' => 'person_style_color', 'reset' => true );
		$shortcode_option_map['content_alignment']['fusion_person'] = array( 'theme-option' => 'person_alignment', 'type' => 'select' );
		$shortcode_option_map['icon_position']['fusion_person'] = array( 'theme-option' => 'person_icon_position', 'type' => 'select' );

		// Popover.
		$shortcode_option_map['title_bg_color']['fusion_popover'] = array( 'theme-option' => 'popover_heading_bg_color', 'reset' => true );
		$shortcode_option_map['content_bg_color']['fusion_popover'] = array( 'theme-option' => 'popover_content_bg_color', 'reset' => true );
		$shortcode_option_map['bordercolor']['fusion_popover'] = array( 'theme-option' => 'popover_border_color', 'reset' => true );
		$shortcode_option_map['textcolor']['fusion_popover'] = array( 'theme-option' => 'popover_text_color', 'reset' => true );
		$shortcode_option_map['placement']['fusion_popover'] = array( 'theme-option' => 'popover_placement', 'type' => 'select' );

		// Portfolio.
		$shortcode_option_map['portfolio_layout_padding']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_layout_padding', 'subset' => array( 'top', 'right', 'bottom', 'left' ) );
		$shortcode_option_map['picture_size']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_featured_image_size', 'type' => 'select' );
		$shortcode_option_map['boxed_text']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_text_layout', 'type' => 'select' );
		$shortcode_option_map['portfolio_text_alignment']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_text_alignment', 'type' => 'select' );
		$shortcode_option_map['column_spacing']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_column_spacing', 'type' => 'range' );
		$shortcode_option_map['number_posts']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_items', 'type' => 'range' );
		$shortcode_option_map['pagination_type']['fusion_portfolio'] = array( 'theme-option' => 'grid_pagination_type', 'type' => 'select' );
		$shortcode_option_map['content_length']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_content_length', 'type' => 'select' );
		$shortcode_option_map['excerpt_length']['fusion_portfolio'] = array( 'theme-option' => 'excerpt_length_portfolio', 'type' => 'range' );
		$shortcode_option_map['portfolio_title_display']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_title_display', 'type' => 'select' );
		$shortcode_option_map['strip_html']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_strip_html_excerpt', 'type' => 'yesno' );

		// Pricing table.
		$shortcode_option_map['backgroundcolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_bg_color', 'reset' => true );
		$shortcode_option_map['bordercolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_border_color', 'reset' => true );
		$shortcode_option_map['dividercolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_divider_color', 'reset' => true );

		// Progress bar.
		$shortcode_option_map['height']['fusion_progress'] = array( 'theme-option' => 'progressbar_height' );
		$shortcode_option_map['text_position']['fusion_progress'] = array( 'theme-option' => 'progressbar_text_position', 'type' => 'select' );
		$shortcode_option_map['filledcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_color', 'reset' => true );
		$shortcode_option_map['filledbordercolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_border_color', 'reset' => true );
		$shortcode_option_map['filledbordersize']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_border_size', 'type' => 'range' );
		$shortcode_option_map['unfilledcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_unfilled_color', 'reset' => true );
		$shortcode_option_map['textcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_text_color', 'reset' => true );

		// Section Separator.
		$shortcode_option_map['backgroundcolor']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_bg', 'reset' => true );
		$shortcode_option_map['bordersize']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_border_size', 'type' => 'range' );
		$shortcode_option_map['bordercolor']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_border_color', 'reset' => true );
		$shortcode_option_map['icon_color']['fusion_section_separator'] = array( 'theme-option' => 'icon_color', 'reset' => true );

		// Separator.
		$shortcode_option_map['border_size']['fusion_separator'] = array( 'theme-option' => 'separator_border_size', 'type' => 'range' );
		$shortcode_option_map['icon_circle']['fusion_separator'] = array( 'theme-option' => 'separator_circle', 'type' => 'yesno' );
		$shortcode_option_map['sep_color']['fusion_separator'] = array( 'theme-option' => 'sep_color', 'reset' => true );

		// Social Icons.
		$shortcode_option_map['color_type']['fusion_social_links'] = array( 'theme-option' => 'social_links_color_type', 'type' => 'select' );
		$shortcode_option_map['icon_colors']['fusion_social_links'] = array( 'theme-option' => 'social_links_icon_color' );
		$shortcode_option_map['icons_boxed']['fusion_social_links'] = array( 'theme-option' => 'social_links_boxed', 'type' => 'yesno' );
		$shortcode_option_map['box_colors']['fusion_social_links'] = array( 'theme-option' => 'social_links_box_color' );
		$shortcode_option_map['icons_boxed_radius']['fusion_social_links'] = array( 'theme-option' => 'social_links_boxed_radius' );
		$shortcode_option_map['tooltip_placement']['fusion_social_links'] = array( 'theme-option' => 'social_links_tooltip_placement', 'type' => 'select' );

		// Social Icons for Person.
		$shortcode_option_map['social_icon_font_size']['fusion_person'] = array( 'theme-option' => 'social_links_font_size' );
		$shortcode_option_map['social_icon_padding']['fusion_person'] = array( 'theme-option' => 'social_links_boxed_padding' );
		$shortcode_option_map['social_icon_color_type']['fusion_person'] = array( 'theme-option' => 'social_links_color_type', 'type' => 'select' );
		$shortcode_option_map['social_icon_colors']['fusion_person'] = array( 'theme-option' => 'social_links_icon_color' );
		$shortcode_option_map['social_icon_boxed']['fusion_person'] = array( 'theme-option' => 'social_links_boxed', 'type' => 'yesno' );
		$shortcode_option_map['social_icon_boxed_colors']['fusion_person'] = array( 'theme-option' => 'social_links_box_color' );
		$shortcode_option_map['social_icon_boxed_radius']['fusion_person'] = array( 'theme-option' => 'social_links_boxed_radius' );
		$shortcode_option_map['social_icon_tooltip']['fusion_person'] = array( 'theme-option' => 'social_links_tooltip_placement', 'type' => 'select' );

		// Sharing Box.
		$shortcode_option_map['backgroundcolor']['fusion_sharing'] = array( 'theme-option' => 'social_bg_color', 'reset' => true );
		$shortcode_option_map['icons_boxed']['fusion_sharing'] = array( 'theme-option' => 'social_links_boxed', 'type' => 'yesno' );
		$shortcode_option_map['icons_boxed_radius']['fusion_sharing'] = array( 'theme-option' => 'social_links_boxed_radius' );
		$shortcode_option_map['tagline_color']['fusion_sharing'] = array( 'theme-option' => 'sharing_box_tagline_text_color', 'reset' => true );
		$shortcode_option_map['tooltip_placement']['fusion_sharing'] = array( 'theme-option' => 'sharing_social_links_tooltip_placement', 'type' => 'select' );
		$shortcode_option_map['color_type']['fusion_sharing'] = array( 'theme-option' => 'social_links_color_type', 'type' => 'select' );
		$shortcode_option_map['icon_colors']['fusion_sharing'] = array( 'theme-option' => 'social_links_icon_color' );
		$shortcode_option_map['box_colors']['fusion_sharing'] = array( 'theme-option' => 'social_links_box_color' );

		// Tabs.
		$shortcode_option_map['backgroundcolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_bg_color', 'shortcode' => 'fusion_tabs', 'reset' => true );
		$shortcode_option_map['inactivecolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_inactive_color', 'shortcode' => 'fusion_tabs', 'reset' => true );
		$shortcode_option_map['bordercolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_border_color', 'shortcode' => 'fusion_tabs', 'reset' => true );

		// Tagline.
		$shortcode_option_map['backgroundcolor']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_bg', 'reset' => true );
		$shortcode_option_map['bordercolor']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_border_color', 'reset' => true );
		$shortcode_option_map['margin_top']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_margin', 'subset' => 'top' );
		$shortcode_option_map['margin_bottom']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_margin', 'subset' => 'bottom' );

		// Testimonials.
		$shortcode_option_map['backgroundcolor']['fusion_testimonials'] = array( 'theme-option' => 'testimonial_bg_color', 'reset' => true );
		$shortcode_option_map['textcolor']['fusion_testimonials'] = array( 'theme-option' => 'testimonial_text_color', 'reset' => true );
		$shortcode_option_map['random']['fusion_testimonials'] = array( 'theme-option' => 'testimonials_random', 'type' => 'yesno' );

		// Title.
		$shortcode_option_map['style_type']['fusion_title'] = array( 'theme-option' => 'title_style_type', 'type' => 'select' );
		$shortcode_option_map['sep_color']['fusion_title'] = array( 'theme-option' => 'title_border_color', 'reset' => true );
		$shortcode_option_map['dimensions']['fusion_title'] = array( 'theme-option' => 'title_margin', 'subset' => array( 'top', 'bottom' ) );

		// Toggles.
		$shortcode_option_map['divider_line']['fusion_accordion'] = array( 'theme-option' => 'accordion_divider_line', 'type' => 'yesno' );

		// User Login Element.
		$shortcode_option_map['text_align']['fusion_login'] = array( 'theme-option' => 'user_login_text_align', 'type' => 'select' );
		$shortcode_option_map['form_background_color']['fusion_login'] = array( 'theme-option' => 'user_login_form_background_color', 'reset' => true );
		$shortcode_option_map['text_align']['fusion_register'] = array( 'theme-option' => 'user_login_text_align', 'type' => 'select' );
		$shortcode_option_map['form_background_color']['fusion_register'] = array( 'theme-option' => 'user_login_form_background_color', 'reset' => true );
		$shortcode_option_map['text_align']['fusion_lost_password'] = array( 'theme-option' => 'user_login_text_align', 'type' => 'select' );
		$shortcode_option_map['form_background_color']['fusion_lost_password'] = array( 'theme-option' => 'user_login_form_background_color', 'reset' => true );
		$shortcode_option_map['link_color']['fusion_login'] = array( 'theme-option' => 'link_color' );
		$shortcode_option_map['link_color']['fusion_register'] = array( 'theme-option' => 'link_color' );
		$shortcode_option_map['link_color']['fusion_lost_password'] = array( 'theme-option' => 'link_color' );

		// FAQs.
		$shortcode_option_map['featured_image']['fusion_faq'] = array( 'theme-option' => 'faq_featured_image', 'type' => 'yesno' );
		$shortcode_option_map['filters']['fusion_faq'] = array( 'theme-option' => 'faq_filters', 'type' => 'select' );

		self::$shortcode_option_map_descriptions = $shortcode_option_map;
	}

	/**
	 * Set builder defaults from TO where necessary.
	 *
	 * @access public
	 * @since   5.0.0
	 * @param   string $default default currently being used.
	 * @param   string $shortcode name of shortcode.
	 * @param   string $option name of option.
	 * @return  string new default from theme options.
	 */
	public function set_builder_defaults( $default, $shortcode, $option ) {
		$shortcode_option_map = self::$shortcode_option_map_defaults;

		// If needs default, add it.
		if ( isset( $shortcode_option_map[ $option ][ $shortcode ] ) ) {
			return Avada()->settings->get( $shortcode_option_map[ $option ][ $shortcode ]['theme-option'] );
		}
		return $default;
	}

	/**
	 * Set element option mapping for defaults.
	 *
	 * @access public
	 * @since   5.0.0
	 * @return  void
	 */
	public function set_shortcode_option_map_defaults() {

		$shortcode_option_map = array();

		// Button.
		$shortcode_option_map['button_gradient_top_color']['fusion_button'] = array( 'theme-option' => 'button_gradient_top_color' );
		$shortcode_option_map['button_gradient_bottom_color']['fusion_button'] = array( 'theme-option' => 'button_gradient_bottom_color' );
		$shortcode_option_map['button_gradient_top_color_hover']['fusion_button'] = array( 'theme-option' => 'button_gradient_top_color_hover' );
		$shortcode_option_map['button_gradient_bottom_color_hover']['fusion_button'] = array( 'theme-option' => 'button_gradient_bottom_color_hover' );
		$shortcode_option_map['accent_color']['fusion_button'] = array( 'theme-option' => 'button_accent_color' );
		$shortcode_option_map['accent_hover_color']['fusion_button'] = array( 'theme-option' => 'button_accent_hover_color' );
		$shortcode_option_map['bevel_color']['fusion_button'] = array( 'theme-option' => 'button_bevel_color' );
		$shortcode_option_map['border_width']['fusion_button'] = array( 'theme-option' => 'button_border_width', 'type' => 'range' );

		// Checklist.
		$shortcode_option_map['iconcolor']['fusion_checklist'] = array( 'theme-option' => 'checklist_icons_color' );
		$shortcode_option_map['circlecolor']['fusion_checklist'] = array( 'theme-option' => 'checklist_circle_color' );

		// Container.
		$shortcode_option_map['background_color']['fusion_builder_container'] = array( 'theme-option' => 'full_width_bg_color' );
		$shortcode_option_map['border_size']['fusion_builder_container'] = array( 'theme-option' => 'full_width_border_size', 'type' => 'range' );
		$shortcode_option_map['border_color']['fusion_builder_container'] = array( 'theme-option' => 'full_width_border_color' );

		// Content Box.
		$shortcode_option_map['backgroundcolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_bg_color' );
		$shortcode_option_map['title_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_title_color' );
		$shortcode_option_map['body_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_body_color' );
		$shortcode_option_map['iconcolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_color' );
		$shortcode_option_map['circlecolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_color' );
		$shortcode_option_map['circlebordercolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_color' );
		$shortcode_option_map['outercirclebordercolor']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_color' );
		$shortcode_option_map['circlebordersize']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_size', 'type' => 'range' );
		$shortcode_option_map['outercirclebordersize']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_size' , 'type' => 'range' );
		$shortcode_option_map['hover_accent_color']['fusion_content_boxes'] = array( 'theme-option' => 'content_box_hover_animation_accent_color' );

		$shortcode_option_map['backgroundcolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_bg_color', 'type' => 'child' );
		$shortcode_option_map['iconcolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_color', 'type' => 'child' );
		$shortcode_option_map['icon_circle_radius']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_circle_radius', 'type' => 'child' );
		$shortcode_option_map['circlecolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_color', 'type' => 'child' );
		$shortcode_option_map['circlebordercolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_color', 'type' => 'child' );
		$shortcode_option_map['outercirclebordercolor']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_color', 'type' => 'child' );
		$shortcode_option_map['circlebordersize']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_inner_border_size', 'type' => 'child' );
		$shortcode_option_map['outercirclebordersize']['fusion_content_box'] = array( 'theme-option' => 'content_box_icon_bg_outer_border_size', 'type' => 'child' );

		// Countdown.
		$shortcode_option_map['background_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_background_color' );
		$shortcode_option_map['counter_box_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_counter_box_color' );
		$shortcode_option_map['counter_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_counter_text_color' );
		$shortcode_option_map['heading_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_heading_text_color' );
		$shortcode_option_map['subheading_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_subheading_text_color' );
		$shortcode_option_map['link_text_color']['fusion_countdown'] = array( 'theme-option' => 'countdown_link_text_color' );

		// Counter box.
		$shortcode_option_map['color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_color' );
		$shortcode_option_map['body_color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_body_color' );
		$shortcode_option_map['border_color']['fusion_counters_box'] = array( 'theme-option' => 'counter_box_border_color' );

		// Counter Circle.
		$shortcode_option_map['filledcolor']['fusion_counter_circle'] = array( 'theme-option' => 'counter_filled_color' );
		$shortcode_option_map['unfilledcolor']['fusion_counter_circle'] = array( 'theme-option' => 'counter_unfilled_color' );

		// Dropcap.
		$shortcode_option_map['color']['fusion_dropcap'] = array( 'theme-option' => 'dropcap_color', 'shortcode' => 'fusion_dropcap' );

		// Flipboxes.
		$shortcode_option_map['background_color_front']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_bg' );
		$shortcode_option_map['title_front_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_heading' );
		$shortcode_option_map['text_front_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_front_text' );
		$shortcode_option_map['background_color_back']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_bg' );
		$shortcode_option_map['title_back_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_heading' );
		$shortcode_option_map['text_back_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_back_text' );
		$shortcode_option_map['border_size']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_border_size', 'type' => 'range' );
		$shortcode_option_map['border_color']['fusion_flip_box'] = array( 'theme-option' => 'flip_boxes_border_color' );

		// Icon Element.
		$shortcode_option_map['circlecolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_circle_color' );
		$shortcode_option_map['circlebordercolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_border_color' );
		$shortcode_option_map['iconcolor']['fusion_fontawesome'] = array( 'theme-option' => 'icon_color' );

		// Image Frame.
		$shortcode_option_map['bordercolor']['fusion_imageframe'] = array( 'theme-option' => 'imgframe_border_color' );
		$shortcode_option_map['bordersize']['fusion_imageframe'] = array( 'theme-option' => 'imageframe_border_size', 'type' => 'range' );
		$shortcode_option_map['stylecolor']['fusion_imageframe'] = array( 'theme-option' => 'imgframe_style_color' );

		// Modal.
		$shortcode_option_map['background']['fusion_modal'] = array( 'theme-option' => 'modal_bg_color' );
		$shortcode_option_map['border_color']['fusion_modal'] = array( 'theme-option' => 'modal_border_color' );

		// Person.
		$shortcode_option_map['background_color']['fusion_person'] = array( 'theme-option' => 'person_background_color' );
		$shortcode_option_map['pic_bordercolor']['fusion_person'] = array( 'theme-option' => 'person_border_color' );
		$shortcode_option_map['pic_bordersize']['fusion_person'] = array( 'theme-option' => 'person_border_size', 'type' => 'range' );
		$shortcode_option_map['pic_style_color']['fusion_person'] = array( 'theme-option' => 'person_style_color' );

		// Popover.
		$shortcode_option_map['title_bg_color']['fusion_popover'] = array( 'theme-option' => 'popover_heading_bg_color' );
		$shortcode_option_map['content_bg_color']['fusion_popover'] = array( 'theme-option' => 'popover_content_bg_color' );
		$shortcode_option_map['bordercolor']['fusion_popover'] = array( 'theme-option' => 'popover_border_color' );
		$shortcode_option_map['textcolor']['fusion_popover'] = array( 'theme-option' => 'popover_text_color' );

		// Portfolio.
		$shortcode_option_map['column_spacing']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_column_spacing', 'type' => 'range' );
		$shortcode_option_map['number_posts']['fusion_portfolio'] = array( 'theme-option' => 'portfolio_items', 'type' => 'range' );
		$shortcode_option_map['excerpt_length']['fusion_portfolio'] = array( 'theme-option' => 'excerpt_length_portfolio', 'type' => 'range' );

		// Pricing table.
		$shortcode_option_map['backgroundcolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_bg_color' );
		$shortcode_option_map['bordercolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_border_color' );
		$shortcode_option_map['dividercolor']['fusion_pricing_table'] = array( 'theme-option' => 'pricing_divider_color' );

		// Progress bar.
		$shortcode_option_map['filledcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_color' );
		$shortcode_option_map['filledbordercolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_border_color' );
		$shortcode_option_map['filledbordersize']['fusion_progress'] = array( 'theme-option' => 'progressbar_filled_border_size', 'type' => 'range' );
		$shortcode_option_map['unfilledcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_unfilled_color' );
		$shortcode_option_map['textcolor']['fusion_progress'] = array( 'theme-option' => 'progressbar_text_color' );

		// Section Separator.
		$shortcode_option_map['backgroundcolor']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_bg' );
		$shortcode_option_map['bordersize']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_border_size', 'type' => 'range' );
		$shortcode_option_map['bordercolor']['fusion_section_separator'] = array( 'theme-option' => 'section_sep_border_color' );
		$shortcode_option_map['icon_color']['fusion_section_separator'] = array( 'theme-option' => 'icon_color' );

		// Separator.
		$shortcode_option_map['border_size']['fusion_separator'] = array( 'theme-option' => 'separator_border_size', 'type' => 'range' );
		$shortcode_option_map['sep_color']['fusion_separator'] = array( 'theme-option' => 'sep_color' );

		// Sharing Box.
		$shortcode_option_map['backgroundcolor']['fusion_sharing'] = array( 'theme-option' => 'social_bg_color' );
		$shortcode_option_map['tagline_color']['fusion_sharing'] = array( 'theme-option' => 'sharing_box_tagline_text_color' );
		$shortcode_option_map['icon_colors']['fusion_sharing'] = array( 'theme-option' => 'social_links_icon_color' );
		$shortcode_option_map['box_colors']['fusion_sharing'] = array( 'theme-option' => 'social_links_box_color' );

		// Tabs.
		$shortcode_option_map['backgroundcolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_bg_color', 'shortcode' => 'fusion_tabs' );
		$shortcode_option_map['inactivecolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_inactive_color', 'shortcode' => 'fusion_tabs' );
		$shortcode_option_map['bordercolor']['fusion_tabs'] = array( 'theme-option' => 'tabs_border_color', 'shortcode' => 'fusion_tabs' );

		// Tagline.
		$shortcode_option_map['backgroundcolor']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_bg' );
		$shortcode_option_map['bordercolor']['fusion_tagline_box'] = array( 'theme-option' => 'tagline_border_color' );

		// Testimonials.
		$shortcode_option_map['backgroundcolor']['fusion_testimonials'] = array( 'theme-option' => 'testimonial_bg_color' );
		$shortcode_option_map['textcolor']['fusion_testimonials'] = array( 'theme-option' => 'testimonial_text_color' );

		// Title.
		$shortcode_option_map['sep_color']['fusion_title'] = array( 'theme-option' => 'title_border_color' );

		// User Login Element.
		$shortcode_option_map['form_background_color']['fusion_login'] = array( 'theme-option' => 'user_login_form_background_color' );
		$shortcode_option_map['form_background_color']['fusion_register'] = array( 'theme-option' => 'user_login_form_background_color' );
		$shortcode_option_map['form_background_color']['fusion_lost_password'] = array( 'theme-option' => 'user_login_form_background_color' );
		$shortcode_option_map['link_color']['fusion_login'] = array( 'theme-option' => 'link_color' );
		$shortcode_option_map['link_color']['fusion_register'] = array( 'theme-option' => 'link_color' );
		$shortcode_option_map['link_color']['fusion_lost_password'] = array( 'theme-option' => 'link_color' );

		self::$shortcode_option_map_defaults = $shortcode_option_map;
	}

	/**
	 * Set builder defaults from TO where necessary.
	 *
	 * @access public
	 * @since   5.0.0
	 * @param   string $value value currently being used.
	 * @param   string $shortcode name of shortcode.
	 * @param   string $option name of option.
	 * @return  string new default from theme options.
	 */
	public function set_builder_values( $value, $shortcode, $option ) {

		$shortcode_option_map = array();

		// If needs custom color schemes, add in.
		if ( ( 'color' === $option && 'fusion_button' == $shortcode ) || ( 'buttoncolor' === $option && 'fusion_tagline_box' == $shortcode )  ) {
			return Avada()->settings->get_custom_color_schemes( $value );
		}
		return $value;

	}

	/**
	 * Set builder dependencies, for those which involve TO.
	 *
	 * @since  5.0.0
	 * @param  array  $dependencies currently active dependencies.
	 * @param  string $shortcode name of shortcode.
	 * @param  string $option name of option.
	 * @return array  dependency checks.
	 */
	public function set_builder_dependencies( $dependencies, $shortcode, $option ) {
		$shortcode_option_map = array();

		// Portfolio.
		$shortcode_option_map['portfolio_layout_padding']['fusion_portfolio'][] = array(
			'check' => array(
				'theme-option' => 'portfolio_text_layout',
				'value' => 'unboxed',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'boxed_text',
				'value' => 'default',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['excerpt_length']['fusion_portfolio'][] = array(
			'check' => array(
				'theme-option' => 'portfolio_content_length',
				'value' => 'Full Content',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'content_length',
				'value' => 'default',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['strip_html']['fusion_portfolio'][] = array(
			'check' => array(
				'theme-option' => 'portfolio_content_length',
				'value' => 'Full Content',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'content_length',
				'value' => 'default',
				'operator' => '!=',
			),
		);

		// Progress.
		$shortcode_option_map['filledbordercolor']['fusion_progress'][] = array(
			'check' => array(
				'theme-option' => 'progressbar_filled_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'filledbordersize',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Social links.
		$shortcode_option_map['icons_boxed_radius']['fusion_social_links'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icons_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['box_colors']['fusion_social_links'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icons_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['icon_colors']['fusion_social_links'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'color_type',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['box_colors']['fusion_social_links'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'color_type',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Sharing box.
		$shortcode_option_map['icons_boxed_radius']['fusion_sharing'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icons_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['box_colors']['fusion_sharing'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'color_type',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['box_colors']['fusion_sharing'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icons_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['icon_colors']['fusion_sharing'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'color_type',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Checklist.
		$shortcode_option_map['circlecolor']['fusion_checklist'][] = array(
			'check' => array(
				'theme-option' => 'checklist_circle',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'circle',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Imageframe.
		$shortcode_option_map['bordercolor']['fusion_imageframe'][] = array(
			'check' => array(
				'theme-option' => 'imageframe_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'bordersize',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Button.
		$shortcode_option_map['bevel_color']['fusion_button'][] = array(
			'check' => array(
				'theme-option' => 'button_type',
				'value' => 'Flat',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'type',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Person.
		$shortcode_option_map['social_icon_boxed_radius']['fusion_person'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'social_icon_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['social_icon_boxed_colors']['fusion_person'][] = array(
			'check' => array(
				'theme-option' => 'social_links_boxed',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'social_icon_boxed',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['social_icon_boxed_colors']['fusion_person'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'social_icon_color_type',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['social_icon_colors']['fusion_person'][] = array(
			'check' => array(
				'theme-option' => 'social_links_color_type',
				'value' => 'brand',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'social_icon_color_type',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Content boxes.
		$shortcode_option_map['hover_accent_color']['fusion_content_boxes'][] = array(
			'check' => array(
				'theme-option' => 'content_box_icon_hover_type',
				'value' => 'none',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icon_hover_type',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['circlebordercolor']['fusion_content_boxes'][] = array(
			'check' => array(
				'theme-option' => 'content_box_icon_bg_inner_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'circlebordersize',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['outercirclebordercolor']['fusion_content_boxes'][] = array(
			'check' => array(
				'theme-option' => 'content_box_icon_bg_outer_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'outercirclebordersize',
				'value' => '',
				'operator' => '!=',
			),
		);
		$boxed_content_boxes = array(
			'check' => array(
				'theme-option' => 'content_box_icon_circle',
				'value' => 'no',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icon_circle',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['icon_circle_radius']['fusion_content_boxes'][] = $boxed_content_boxes;
		$shortcode_option_map['circlecolor']['fusion_content_boxes'][] = $boxed_content_boxes;
		$shortcode_option_map['circlebordercolor']['fusion_content_boxes'][] = $boxed_content_boxes;
		$shortcode_option_map['circlebordersize']['fusion_content_boxes'][] = $boxed_content_boxes;
		$shortcode_option_map['outercirclebordercolor']['fusion_content_boxes'][] = $boxed_content_boxes;
		$shortcode_option_map['outercirclebordersize']['fusion_content_boxes'][] = $boxed_content_boxes;

		$parent_boxed_content_boxes = array(
			'check' => array(
				'theme-option' => 'content_box_icon_circle',
				'value' => 'no',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'parent_icon_circle',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['circlecolor']['fusion_content_box'][] = $parent_boxed_content_boxes;
		$shortcode_option_map['circlebordercolor']['fusion_content_box'][] = $parent_boxed_content_boxes;
		$shortcode_option_map['circlebordersize']['fusion_content_box'][] = $parent_boxed_content_boxes;
		$shortcode_option_map['outercirclebordercolor']['fusion_content_box'][] = $parent_boxed_content_boxes;
		$shortcode_option_map['outercirclebordersize']['fusion_content_box'][] = $parent_boxed_content_boxes;

		// Flip boxes.
		$shortcode_option_map['border_color']['fusion_flip_box'][] = array(
			'check' => array(
				'theme-option' => 'flip_boxes_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'border_size',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Container.
		$shortcode_option_map['border_color']['fusion_builder_container'][] = array(
			'check' => array(
				'theme-option' => 'full_width_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'border_size',
				'value' => '',
				'operator' => '!=',
			),
		);
		$shortcode_option_map['border_style']['fusion_builder_container'][] = array(
			'check' => array(
				'theme-option' => 'full_width_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'border_size',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Section separator.
		$shortcode_option_map['bordercolor']['fusion_section_separator'][] = array(
			'check' => array(
				'theme-option' => 'section_sep_border_size',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'bordersize',
				'value' => '',
				'operator' => '!=',
			),
		);

		// Separator.
		$shortcode_option_map['icon_circle_color']['fusion_separator'][] = array(
			'check' => array(
				'theme-option' => 'separator_circle',
				'value' => '0',
				'operator' => '==',
			),
			'output' => array(
				'element' => 'icon_circle',
				'value' => '',
				'operator' => '!=',
			),
		);

		// If has TO related dependency, do checks.
		if ( isset( $shortcode_option_map[ $option ][ $shortcode ] ) && is_array( $shortcode_option_map[ $option ][ $shortcode ] ) ) {
			foreach ( $shortcode_option_map[ $option ][ $shortcode ] as $option_check ) {
				$option_value = Avada()->settings->get( $option_check['check']['theme-option'] );
				$pass = false;

				// Check the result of check.
				if ( '==' == $option_check['check']['operator'] ) {
					$pass = ( $option_value == $option_check['check']['value'] ) ? true : false;
				}
				if ( '!=' == $option_check['check']['operator'] ) {
					$pass = ( $option_value != $option_check['check']['value'] ) ? true : false;
				}

				// If check passes then add dependency for checking.
				if ( $pass ) {
					$dependencies[] = $option_check['output'];
				}
			}
		}
		return $dependencies;
	}

	/**
	 * Add import demo title.
	 *
	 * @access public
	 * @since  5.0.0
	 * @param  string $title The message to output.
	 * @return string
	 */
	function add_builder_import_title( $title ) {

		// Check registration.
		if ( ! Avada()->registration->is_registered() ) {
			return sprintf( esc_attr__( 'Your product must be registered to receive Avada demo pages. Go to the %s tab to complete registration.', 'Avada' ), '<a href="' . admin_url( 'admin.php?page=avada' ) . '">' . esc_attr__( 'Product Registration', 'Avada' ) . '</a>' );
		}
		// Check we can download the demos.
		if ( false === Fusion_Builder_Demos_Importer::can_write() ) {
			return sprintf( esc_attr__( 'It looks like the %s folder in your WordPress installation is not writable. Please make sure to change the file/folder permissions to allow downloading the Fusion-Builder demos before using them.', 'Avada' ), '<code>wp-content/uploads/fusion-builder-avada-pages</code>' );
		}
		// Return the title.
		return $title;

	}

	/**
	 * Add import demo message.
	 *
	 * @access public
	 * @since  5.0.0
	 * @param  string $message The message to output.
	 * @return string
	 */
	function add_builder_import_message( $message ) {

		// Check registration.
		if ( ! Avada()->registration->is_registered() ) {
			return esc_attr__( 'Once you register your Avada theme purchase, you will be able to select any Avada demo, view each page it contains and import any of them individually.', 'Avada' );
		}
		// Check we can download the demos.
		if ( false === Fusion_Builder_Demos_Importer::can_write() ) {
			return esc_attr__( 'Once the demos are downloaded, you will be able to select any Avada demo, view each page it contains and import any of them individually.', 'Avada' );
		}

		// Return the default message.
		return _e( 'Importing a single demo page is to receive the skeleton layout only. <strong>You will not receive demo images, fusion theme options, custom post types or sliders so there will be differences in style and layout compared to the online demos.</strong> The items that import are the builder layout, page template, fusion page options and image placeholders. If you wish to import everything from a demo, you need to import the full demo on the Avada > Install Demos tab.', 'Avada' );

	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
