<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Handle enqueueing scrips.
 */
class Avada_Scripts {

	/**
	 * The theme version.
	 *
	 * @static
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private static $version;

	/**
	 * The class construction
	 */
	public function __construct() {

		self::$version = Avada::get_theme_version();

		if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'script_loader_tag', array( $this, 'add_async' ), 10, 2 );
		}

		if ( class_exists( 'WooCommerce' ) ) {
			add_filter( 'woocommerce_enqueue_styles', array( $this, 'remove_woo_scripts' ) );
		}

		add_action( 'admin_head', array( $this, 'admin_css' ) );

	}

	/**
	 * Takes care of enqueueing all our scripts.
	 */
	public function enqueue_scripts() {

		global $wp_styles, $woocommerce;

		wp_enqueue_script( 'jquery', false, array(), self::$version, true );

		// The comment-reply script.
		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( function_exists( 'novagallery_shortcode' ) ) {
			wp_deregister_script( 'novagallery_modernizr' );
		}

		if ( function_exists( 'ccgallery_shortcode' ) ) {
			wp_deregister_script( 'ccgallery_modernizr' );
		}

		if ( Avada()->settings->get( 'status_gmap' ) ) {
			$map_protocol = 'http' . ( ( is_ssl() ) ? 's' : '' );
			$map_key = ( ( Avada()->settings->get( 'gmap_api' ) ) ? 'key=' . Avada()->settings->get( 'gmap_api' ) . '&' : '' );
			$map_api = $map_protocol . '://maps.googleapis.com/maps/api/js?' . $map_key . 'language=' . substr( get_locale(), 0, 2 );
			wp_register_script( 'google-maps-api', $map_api, array(), self::$version, true );
			wp_register_script( 'google-maps-infobox', Avada::$template_dir_url . '/assets/js/infobox_packed.js', array(), self::$version, true );
		}

		if ( Avada()->settings->get( 'dev_mode' ) ) {

			$main_js = Avada::$template_dir_url . '/assets/js/theme.js';
			wp_deregister_script( 'bootstrap' );
			wp_register_script( 'bootstrap', Avada::$template_dir_url . '/assets/js/bootstrap.js', array(), self::$version, true );
			wp_enqueue_script( 'bootstrap' );

			wp_deregister_script( 'cssua' );
			wp_register_script( 'cssua', Avada::$template_dir_url . '/assets/js/cssua.js', array(), self::$version, true );
			wp_enqueue_script( 'cssua' );

			wp_deregister_script( 'jquery.easyPieChart' );
			wp_register_script( 'jquery.easyPieChart', Avada::$template_dir_url . '/assets/js/jquery.easyPieChart.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.easyPieChart' );

			wp_deregister_script( 'Froogaloop' );
			wp_register_script( 'Froogaloop', Avada::$template_dir_url . '/assets/js/Froogaloop.js', array(), self::$version, true );
			wp_enqueue_script( 'Froogaloop' );

			wp_deregister_script( 'imagesLoaded' );
			wp_register_script( 'imagesLoaded', Avada::$template_dir_url . '/assets/js/imagesLoaded.js', array(), self::$version, true );
			wp_enqueue_script( 'imagesLoaded' );

			wp_deregister_script( 'jquery.infinitescroll' );
			wp_register_script( 'jquery.infinitescroll', Avada::$template_dir_url . '/assets/js/jquery.infinitescroll.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.infinitescroll' );

			wp_deregister_script( 'isotope' );
			wp_register_script( 'isotope', Avada::$template_dir_url . '/assets/js/isotope.js', array(), self::$version, true );
			wp_enqueue_script( 'isotope' );

			wp_deregister_script( 'jquery.appear' );
			wp_register_script( 'jquery.appear', Avada::$template_dir_url . '/assets/js/jquery.appear.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.appear' );

			wp_deregister_script( 'jquery.touchSwipe' );
			wp_register_script( 'jquery.touchSwipe', Avada::$template_dir_url . '/assets/js/jquery.touchSwipe.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.touchSwipe' );

			wp_deregister_script( 'jquery.carouFredSel' );
			wp_register_script( 'jquery.carouFredSel', Avada::$template_dir_url . '/assets/js/jquery.carouFredSel.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.carouFredSel' );

			wp_deregister_script( 'jquery.countTo' );
			wp_register_script( 'jquery.countTo', Avada::$template_dir_url . '/assets/js/jquery.countTo.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.countTo' );

			wp_deregister_script( 'jquery.countdown' );
			wp_register_script( 'jquery.countdown', Avada::$template_dir_url . '/assets/js/jquery.countdown.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.countdown' );

			wp_deregister_script( 'jquery.cycle' );
			wp_register_script( 'jquery.cycle', Avada::$template_dir_url . '/assets/js/jquery.cycle.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.cycle' );

			wp_deregister_script( 'jquery.easing' );
			wp_register_script( 'jquery.easing', Avada::$template_dir_url . '/assets/js/jquery.easing.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.easing' );

			wp_deregister_script( 'jquery.elasticslider' );
			wp_register_script( 'jquery.elasticslider', Avada::$template_dir_url . '/assets/js/jquery.elasticslider.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.elasticslider' );

			wp_deregister_script( 'jquery.fitvids' );
			wp_register_script( 'jquery.fitvids', Avada::$template_dir_url . '/assets/js/jquery.fitvids.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.fitvids' );

			wp_deregister_script( 'jquery.flexslider' );
			wp_register_script( 'jquery.flexslider', Avada::$template_dir_url . '/assets/js/jquery.flexslider.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.flexslider' );

			wp_deregister_script( 'jquery.fusion_maps' );
			wp_register_script( 'jquery.fusion_maps', Avada::$template_dir_url . '/assets/js/jquery.fusion_maps.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.fusion_maps' );

			wp_deregister_script( 'jquery.hoverflow' );
			wp_register_script( 'jquery.hoverflow', Avada::$template_dir_url . '/assets/js/jquery.hoverflow.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.hoverflow' );

			wp_deregister_script( 'jquery.hoverIntent' );
			wp_register_script( 'jquery.hoverIntent', Avada::$template_dir_url . '/assets/js/jquery.hoverIntent.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.hoverIntent' );

			wp_deregister_script( 'jquery.placeholder' );
			wp_register_script( 'jquery.placeholder', Avada::$template_dir_url . '/assets/js/jquery.placeholder.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.placeholder' );

			wp_deregister_script( 'jquery.toTop' );
			wp_register_script( 'jquery.toTop', Avada::$template_dir_url . '/assets/js/jquery.toTop.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.toTop' );
			wp_localize_script( 'jquery.toTop', 'toTopscreenReaderText', array( 'label' => esc_attr__( 'Go to Top', 'Avada' ) ) );

			wp_deregister_script( 'jquery.waypoints' );
			wp_register_script( 'jquery.waypoints', Avada::$template_dir_url . '/assets/js/jquery.waypoints.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.waypoints' );

			wp_deregister_script( 'modernizr' );
			wp_register_script( 'modernizr', Avada::$template_dir_url . '/assets/js/modernizr.js', array(), self::$version, true );
			wp_enqueue_script( 'modernizr' );

			wp_deregister_script( 'jquery.requestAnimationFrame' );
			wp_register_script( 'jquery.requestAnimationFrame', Avada::$template_dir_url . '/assets/js/jquery.requestAnimationFrame.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.requestAnimationFrame' );

			wp_deregister_script( 'jquery.mousewheel' );
			wp_register_script( 'jquery.mousewheel', Avada::$template_dir_url . '/assets/js/jquery.mousewheel.js', array(), self::$version, true );
			wp_enqueue_script( 'jquery.mousewheel' );

			if ( Avada()->settings->get( 'status_lightbox' ) ) {
				wp_deregister_script( 'ilightbox.packed' );
				wp_register_script( 'ilightbox.packed', Avada::$template_dir_url . '/assets/js/ilightbox.js', array(), self::$version, true );
				wp_enqueue_script( 'ilightbox.packed' );
			}

			wp_deregister_script( 'avada-lightbox' );
			wp_register_script( 'avada-lightbox', Avada::$template_dir_url . '/assets/js/avada-lightbox.js', array(), self::$version, true );
			wp_enqueue_script( 'avada-lightbox' );

			wp_deregister_script( 'avada-header' );
			wp_register_script( 'avada-header', Avada::$template_dir_url . '/assets/js/avada-header.js', array(), self::$version, true );
			wp_enqueue_script( 'avada-header' );

			wp_deregister_script( 'avada-select' );
			wp_register_script( 'avada-select', Avada::$template_dir_url . '/assets/js/avada-select.js', array(), self::$version, true );
			wp_enqueue_script( 'avada-select' );

			wp_deregister_script( 'avada-parallax' );
			wp_register_script( 'avada-parallax', Avada::$template_dir_url . '/assets/js/avada-parallax.js', array(), self::$version, true );
			wp_enqueue_script( 'avada-parallax' );

			wp_deregister_script( 'avada-video-bg' );
			wp_register_script( 'avada-video-bg', Avada::$template_dir_url . '/assets/js/avada-video-bg.js', array(), self::$version, true );
			wp_enqueue_script( 'avada-video-bg' );

			if ( class_exists( 'WooCommerce' ) ) {
				wp_dequeue_script( 'avada-woocommerce' );
				wp_register_script( 'avada-woocommerce', Avada::$template_dir_url . '/assets/js/avada-woocommerce.js' , array( 'jquery' ), self::$version, true );
				wp_enqueue_script( 'avada-woocommerce' );
			}
			if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
				wp_dequeue_script( 'avada-bbpress' );
				wp_register_script( 'avada-bbpress', Avada::$template_dir_url . '/assets/js/avada-bbpress.js' , array( 'jquery' ), self::$version, true );
				wp_enqueue_script( 'avada-bbpress' );
			}

			if ( class_exists( 'Tribe__Events__Main' ) && ( tribe_is_event() || Avada_Helper::is_events_archive() ) ) {
				wp_dequeue_script( 'avada-events' );
				wp_register_script( 'avada-events', Avada::$template_dir_url . '/assets/js/avada-events.js' , array( 'jquery' ), self::$version, true );
				wp_enqueue_script( 'avada-events' );
			}

			if ( Avada()->settings->get( 'smooth_scrolling' ) ) {
				wp_dequeue_script( 'jquery.nicescroll' );
				wp_register_script( 'jquery.nicescroll', Avada::$template_dir_url . '/assets/js/jquery.nicescroll.js' , array( 'jquery' ), self::$version, true );
				wp_enqueue_script( 'jquery.nicescroll' );

				wp_dequeue_script( 'avada-nicescroll' );
				wp_register_script( 'avada-nicescroll', Avada::$template_dir_url . '/assets/js/avada-nicescroll.js' , array( 'jquery' ), self::$version, true );
				wp_enqueue_script( 'avada-nicescroll' );
			}
		} else {

			$main_js = Avada::$template_dir_url . '/assets/js/main.min.js';

		}

		wp_deregister_script( 'avada' );
		wp_register_script( 'avada', $main_js, array(), self::$version, true );
		wp_enqueue_script( 'avada' );
		wp_localize_script( 'avada', 'toTopscreenReaderText', array( 'label' => esc_attr__( 'Go to Top', 'Avada' ) ) );

		// Conditional loading for older IE versions.
		wp_register_script( 'avada-ie9', Avada::$template_dir_url . '/assets/js/avada-ie9.js', array(), self::$version, true );
		wp_enqueue_script( 'avada-ie9' );
		wp_script_add_data( 'avada-ie9', 'conditional', 'IE 9' );

		wp_register_script( 'avada-ie8', Avada::$template_dir_url . '/assets/js/respond.js', array(), self::$version, true );
		wp_enqueue_script( 'avada-ie8' );
		wp_script_add_data( 'avada-ie8', 'conditional', 'lt IE 9' );

		wp_register_script( 'html5shiv', Avada::$template_dir_url . '/assets/js/html5shiv.js', array(), self::$version, false );
		wp_enqueue_script( 'html5shiv' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		wp_register_script( 'excanvas', Avada::$template_dir_url . '/assets/js/excanvas.js', array(), self::$version, false );
		wp_enqueue_script( 'excanvas' );
		wp_script_add_data( 'excanvas', 'conditional', 'lt IE 9' );

		wp_register_script( 'avada-ie8', Avada::$template_dir_url . '/assets/js/avada-ie8.js', array(), self::$version, true );
		wp_enqueue_script( 'avada-ie8' );
		wp_script_add_data( 'avada-ie8', 'conditional', 'lt IE 9' );

		$smooth_height = ( 'auto' == get_post_meta( Avada()->get_page_id(), 'pyre_fimg_width', true ) && 'half' == get_post_meta( Avada()->get_page_id(), 'pyre_width', true ) ) ? 'true' : 'false';

		if ( get_post_meta( 'auto' == Avada()->get_page_id(), 'pyre_fimg_width', true ) && 'half' == get_post_meta( Avada()->get_page_id(), 'pyre_width', true ) ) {
			$flex_smooth_height = 'true';
		} else {
			$flex_smooth_height = ( Avada()->settings->get( 'slideshow_smooth_height' ) ) ? 'true' : 'false';
		}

		$db_vars = Avada()->settings->get_all();

		$db_vars['slideshow_autoplay'] = ( ! Avada()->settings->get( 'slideshow_autoplay' ) ) ? false : true;
		$db_vars['slideshow_speed']    = ( ! Avada()->settings->get( 'slideshow_speed' ) ) ? 7000 : Avada()->settings->get( 'slideshow_speed' );

		$current_page_template = get_page_template_slug( Avada()->get_page_id() );
		$portfolio_image_size  = avada_get_portfolio_image_size( Avada()->get_page_id() );
		$isotope_type          = ( 'full' == $portfolio_image_size ) ? 'masonry' : 'fitRows';

		if ( is_archive() ) {

			$portfolio_layout_setting = strtolower( Avada()->settings->get( 'portfolio_archive_layout' ) );
			$isotope_type = ( Avada()->settings->get( 'portfolio_featured_image_size' ) == 'full' || strpos( $portfolio_layout_setting, 'grid' ) ) ? 'masonry' : 'fitRows';

		}

		$layout = ( get_post_meta( Avada()->get_page_id(), 'pyre_page_bg_layout', true ) == 'boxed' || get_post_meta( Avada()->get_page_id(), 'pyre_page_bg_layout', true ) == 'wide' ) ? get_post_meta( Avada()->get_page_id(), 'pyre_page_bg_layout', true ) : Avada()->settings->get( 'layout' );

		$avada_rev_styles = ( 'no' == get_post_meta( Avada()->get_page_id(), 'pyre_avada_rev_styles', true ) || ( Avada()->settings->get( 'avada_rev_styles' ) && 'yes' != get_post_meta( Avada()->get_page_id(), 'pyre_avada_rev_styles', true ) ) ) ? 1 : 0;

		$available_languages = Avada_Multilingual::get_available_languages();

		$local_variables = array(
			'admin_ajax'                    => admin_url( 'admin-ajax.php' ),
			'admin_ajax_nonce'              => wp_create_nonce( 'avada_admin_ajax' ),
			'protocol'                      => is_ssl(),
			'theme_url'                     => Avada::$template_dir_url,
			'dropdown_goto'                 => __( 'Go to...', 'Avada' ),
			'mobile_nav_cart'               => __( 'Shopping Cart', 'Avada' ),
			'page_smoothHeight'             => $smooth_height,
			'flex_smoothHeight'             => $flex_smooth_height,
			'language_flag'                 => ( ! empty( $available_languages ) ) ? Avada_Multilingual::get_active_language() : '',
			'infinite_blog_finished_msg'    => '<em>' . __( 'All posts displayed.', 'Avada' ) . '</em>',
			'infinite_finished_msg'         => '<em>' . __( 'All items displayed.', 'Avada' ) . '</em>',
			'infinite_blog_text'            => '<em>' . __( 'Loading the next set of posts...', 'Avada' ) . '</em>',
			'portfolio_loading_text'        => '<em>' . __( 'Loading Portfolio Items...', 'Avada' ) . '</em>',
			'faqs_loading_text'             => '<em>' . __( 'Loading FAQ Items...', 'Avada' ) . '</em>',
			'order_actions'                 => __( 'Details' , 'Avada' ),
			'avada_rev_styles'              => $avada_rev_styles,
			'avada_styles_dropdowns'        => Avada()->settings->get( 'avada_styles_dropdowns' ),
			'blog_grid_column_spacing'      => Avada()->settings->get( 'blog_grid_column_spacing' ),
			'blog_pagination_type'          => Avada()->settings->get( 'blog_pagination_type' ),
			'carousel_speed'                => Avada()->settings->get( 'carousel_speed' ),
			'counter_box_speed'           	=> intval( Avada()->settings->get( 'counter_box_speed' ) ),
			'content_break_point'           => intval( Avada()->settings->get( 'content_break_point' ) ),
			'disable_mobile_animate_css'    => Avada()->settings->get( 'disable_mobile_animate_css' ),
			'disable_mobile_image_hovers'   => Avada()->settings->get( 'disable_mobile_image_hovers' ),
			'portfolio_pagination_type'     => Avada()->settings->get( 'grid_pagination_type' ),
			'form_bg_color'                 => Avada()->settings->get( 'form_bg_color' ),
			'header_transparency'           => ( ( 1 !== Avada_Color::new_color( Avada()->settings->get( 'header_bg_color' ) )->alpha && ! get_post_meta( Avada()->get_page_id(), 'pyre_header_bg_opacity', true ) ) || ( '' != get_post_meta( Avada()->get_page_id(), 'pyre_header_bg_opacity', true ) && 1 > get_post_meta( Avada()->get_page_id(), 'pyre_header_bg_opacity', true ) ) ) ? 1 : 0,
			'header_padding_bottom'         => Avada()->settings->get( 'header_padding', 'bottom' ),
			'header_padding_top'            => Avada()->settings->get( 'header_padding', 'top' ),
			'header_position'               => Avada()->settings->get( 'header_position' ),
			'header_sticky'                 => Avada()->settings->get( 'header_sticky' ),
			'header_sticky_tablet'          => Avada()->settings->get( 'header_sticky_tablet' ),
			'header_sticky_mobile'          => Avada()->settings->get( 'header_sticky_mobile' ),
			'header_sticky_type2_layout'    => Avada()->settings->get( 'header_sticky_type2_layout' ),
			'sticky_header_shrinkage'       => Avada()->settings->get( 'header_sticky_shrinkage' ),
			'is_responsive'                 => Avada()->settings->get( 'responsive' ),
			'is_ssl'                        => is_ssl() ? 'true' : 'false',
			'isotope_type'                  => $isotope_type,
			'layout_mode'                   => strtolower( $layout ),
			'lightbox_animation_speed'      => Avada()->settings->get( 'lightbox_animation_speed' ),
			'lightbox_arrows'               => Avada()->settings->get( 'lightbox_arrows' ),
			'lightbox_autoplay'             => Avada()->settings->get( 'lightbox_autoplay' ),
			'lightbox_behavior'             => Avada()->settings->get( 'lightbox_behavior' ),
			'lightbox_desc'                 => Avada()->settings->get( 'lightbox_desc' ),
			'lightbox_deeplinking'          => Avada()->settings->get( 'lightbox_deeplinking' ),
			'lightbox_gallery'              => Avada()->settings->get( 'lightbox_gallery' ),
			'lightbox_opacity'              => Avada()->settings->get( 'lightbox_opacity' ),
			'lightbox_path'                 => Avada()->settings->get( 'lightbox_path' ),
			'lightbox_post_images'          => Avada()->settings->get( 'lightbox_post_images' ),
			'lightbox_skin'                 => Avada()->settings->get( 'lightbox_skin' ),
			'lightbox_slideshow_speed'      => (int) Avada()->settings->get( 'lightbox_slideshow_speed' ),
			'lightbox_social'               => Avada()->settings->get( 'lightbox_social' ),
			'lightbox_title'                => Avada()->settings->get( 'lightbox_title' ),
			'lightbox_video_height'         => Avada_Sanitize::number( Avada()->settings->get( 'lightbox_video_dimensions', 'height' ) ),
			'lightbox_video_width'          => Avada_Sanitize::number( Avada()->settings->get( 'lightbox_video_dimensions', 'width' ) ),
			'logo_alignment'                => Avada()->settings->get( 'logo_alignment' ),
			'logo_margin_bottom'            => Avada()->settings->get( 'logo_margin', 'bottom' ),
			'logo_margin_top'               => Avada()->settings->get( 'logo_margin', 'top' ),
			'megamenu_max_width'            => (int) Avada()->settings->get( 'megamenu_max_width' ),
			'mobile_menu_design'            => Avada()->settings->get( 'mobile_menu_design' ),
			'nav_height'                    => (int) Avada()->settings->get( 'nav_height' ),
			'nav_highlight_border'          => (int) Avada()->settings->get( 'nav_highlight_border' ),
			'page_title_fading'             => Avada()->settings->get( 'page_title_fading' ),
			'pagination_video_slide'        => Avada()->settings->get( 'pagination_video_slide' ),
			'related_posts_speed'           => Avada()->settings->get( 'related_posts_speed' ),
			'submenu_slideout'              => Avada()->settings->get( 'mobile_nav_submenu_slideout' ),
			'side_header_break_point'       => (int) Avada()->settings->get( 'side_header_break_point' ),
			'sidenav_behavior'              => Avada()->settings->get( 'sidenav_behavior' ),
			'site_width'                    => Avada()->settings->get( 'site_width' ),
			'slider_position'               => ( get_post_meta( Avada()->get_page_id(), 'pyre_slider_position', true ) && 'default' != get_post_meta( Avada()->get_page_id(), 'pyre_slider_position', true ) ) ? get_post_meta( Avada()->get_page_id(), 'pyre_slider_position', true ) : strtolower( Avada()->settings->get( 'slider_position' ) ),
			'slideshow_autoplay'            => Avada()->settings->get( 'slideshow_autoplay' ),
			'slideshow_speed'               => Avada()->settings->get( 'slideshow_speed' ),
			'smooth_scrolling'              => Avada()->settings->get( 'smooth_scrolling' ),
			'status_lightbox'               => Avada()->settings->get( 'status_lightbox' ),
			'status_totop_mobile'           => Avada()->settings->get( 'status_totop_mobile' ),
			'status_vimeo'                  => Avada()->settings->get( 'status_vimeo' ),
			'status_yt'                     => Avada()->settings->get( 'status_yt' ),
			'submenu_slideout'              => Avada()->settings->get( 'mobile_nav_submenu_slideout' ),
			'testimonials_speed'            => Avada()->settings->get( 'testimonials_speed' ),
			'tfes_animation'                => Avada()->settings->get( 'tfes_animation' ),
			'tfes_autoplay'                 => Avada()->settings->get( 'tfes_autoplay' ),
			'tfes_interval'                 => (int) Avada()->settings->get( 'tfes_interval' ),
			'tfes_speed'                    => (int) Avada()->settings->get( 'tfes_speed' ),
			'tfes_width'                    => (int) Avada()->settings->get( 'tfes_width' ),
			'title_style_type'              => Avada()->settings->get( 'title_style_type' ),
			'title_margin_top'				=> Avada()->settings->get( 'title_margin', 'top' ),
			'title_margin_bottom'			=> Avada()->settings->get( 'title_margin', 'bottom' ),
			'typography_responsive'         => Avada()->settings->get( 'typography_responsive' ),
			'typography_sensitivity'        => Avada()->settings->get( 'typography_sensitivity' ),
			'typography_factor'             => Avada()->settings->get( 'typography_factor' ),
			'woocommerce_shop_page_columns' => Avada()->settings->get( 'woocommerce_shop_page_columns' ),
			'woocommerce_checkout_error'	=> esc_attr__( 'Not all fields have been filled in correctly.', 'Avada' ),
		);

		$local_variables['side_header_width'] = ( 'Top' != Avada()->settings->get( 'header_position' ) ) ? intval( Avada()->settings->get( 'side_header_width' ) ) : '0';

		wp_localize_script( 'avada', 'avadaVars', $local_variables );

		wp_enqueue_style( 'avada-stylesheet', Avada::$template_dir_url . '/assets/css/style.min.css', array(), self::$version );

		wp_enqueue_style( 'avada-shortcodes', Avada::$template_dir_url . '/shortcodes.css', array(), self::$version );
		$wp_styles->add_data( 'avada-shortcodes', 'conditional', 'lte IE 9' );

		if ( Avada()->settings->get( 'status_fontawesome' ) ) {
			wp_enqueue_style( 'fontawesome', Avada::$template_dir_url . '/assets/fonts/fontawesome/font-awesome.css', array(), self::$version );
			wp_enqueue_style( 'avada-IE-fontawesome', Avada::$template_dir_url . '/assets/fonts/fontawesome/font-awesome.css', array(), self::$version );
			$wp_styles->add_data( 'avada-IE-fontawesome', 'conditional', 'lte IE 9' );
		}

		wp_enqueue_style( 'avada-IE8', Avada::$template_dir_url . '/assets/css/ie8.css', array(), self::$version );
		$wp_styles->add_data( 'avada-IE8', 'conditional', 'lte IE 8' );

		wp_enqueue_style( 'avada-IE', Avada::$template_dir_url . '/assets/css/ie.css', array(), self::$version );
		$wp_styles->add_data( 'avada-IE', 'conditional', 'IE' );

		if ( Avada()->settings->get( 'status_lightbox' ) ) {
			wp_enqueue_style( 'avada-iLightbox', Avada::$template_dir_url . '/ilightbox.css', array(), self::$version );
		}

		if ( Avada()->settings->get( 'use_animate_css' ) ) {
			wp_enqueue_style( 'avada-animations', Avada::$template_dir_url . '/animations.css', array(), self::$version );
		}

		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_style( 'avada-woocommerce', Avada::$template_dir_url . '/assets/css/woocommerce.css', array(), self::$version );
		}

		if ( class_exists( 'bbPress' ) ) {
			wp_enqueue_style( 'avada-bbpress', Avada::$template_dir_url . '/assets/css/bbpress.css', array(), self::$version );
		}

		if ( Avada()->settings->get( 'status_lightbox' ) && class_exists( 'WooCommerce' ) ) {
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'avada-rtl', Avada::$template_dir_url . '/assets/css/rtl.css', array(), self::$version );
		}

	}

	/**
	 * Removes WooCommerce scripts.
	 *
	 * @access public
	 * @since 5.0.0
	 * @param array $scripts The WooCommerce scripts.
	 * @return array
	 */
	public function remove_woo_scripts( $scripts ) {

		if ( isset( $scripts['woocommerce-layout'] ) ) {
			unset( $scripts['woocommerce-layout'] );
		}
		if ( isset( $scripts['woocommerce-smallscreen'] ) ) {
			unset( $scripts['woocommerce-smallscreen'] );
		}
		if ( isset( $scripts['woocommerce-general'] ) ) {
			unset( $scripts['woocommerce-general'] );
		}
		return $scripts;

	}

	/**
	 * Add admin CSS
	 */
	public function admin_css() {

		echo '<link rel="stylesheet" type="text/css" href="' . Avada::$template_dir_url . '/assets/admin/css/admin_css.css?vesion=' . self::$version . '">';
		echo '<style type="text/css">.widget input { border-color: #DFDFDF !important; }</style>';

	}

	/**
	 * Add async to avada javascript file for performance
	 *
	 * @param  string $tag    The script tag.
	 * @param  string $handle The script handle.
	 */
	public function add_async( $tag, $handle ) {
		return ( 'avada' == $handle ) ? preg_replace( '/(><\/[a-zA-Z][^0-9](.*)>)$/', ' async $1 ', $tag ) : $tag;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
