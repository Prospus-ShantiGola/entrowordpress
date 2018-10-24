<?php
/**
 * This file contains functions that have been deprecated.
 * They will still work, but it we recommend you switch to the new methods instead.
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * How comments are displayed
 * This is simply a wrapper for the comment_template method in the Avada_Template class
 * Kept for backwards-compatibility
 */
function avada_comment( $comment, $args, $depth ) {
	Avada()->template->comment_template( $comment, $args, $depth );
}

/**
 * Retrieve protected post password form content.
 * This is simply a wrapper for the get_the_password_form method in the Avada_Template class
 * Kept for backwards-compatibility
 */
function avada_get_the_password_form() {
	return get_the_password_form();
}

if ( ! function_exists( 'tf_content' ) ) :
	/**
	 * Retrieve the content and apply and read-more modifications needed.
	 * This is simply a wrapper for the content method in the Avada_Blog class
	 * Kept for backwards-compatibility
	 */
	function tf_content( $limit, $strip_html ) {
		Avada()->blog->content( $limit, $strip_html );
	}
endif;

/**
 * Strip the content and buid the excerpt
 * This is simply a wrapper for the avada_get_content_stripped_and_excerpted method in the Avada_Blog class
 * Kept for backwards-compatibility
 */
function avada_get_content_stripped_and_excerpted( $excerpt_length, $content ) {
	return Avada()->blog->get_content_stripped_and_excerpted( $excerpt_length, $content );
}

if ( ! function_exists( 'tf_content' ) ) {
	/**
	 * The content.
	 */
	function tf_content( $limit, $strip_html ) {
		return Avada()->blog->content( $limit, $strip_html );
	}
}

if ( ! function_exists( 'tf_checkIfMenuIsSetByLocation' ) ) {
	/**
	 * Simply for backwards-compatibility purposes.
	 */
	function tf_checkIfMenuIsSetByLocation( $menu_location = '' ) {
		return ( has_nav_menu( $menu_location ) ) ? true : false;
	}
}

if ( ! function_exists( 'avada_slider_name' ) ) {
	/**
	 * This is simply a wrapper for the slider_name method in the Avada_Helper class
	 * Kept for backwards-compatibility
	 */
	function avada_slider_name( $name ) {
		return Avada_Helper::slider_name( $name );
	}
}

if ( ! function_exists( 'avada_get_slider_type' ) ) {
	/**
	 * This is simply a wrapper for the get_slider_type method in the Avada_Helper class
	 * Kept for backwards-compatibility
	 */
	function avada_get_slider_type( $post_id ) {
		return Avada_Helper::get_slider_type( $post_id );
	}
}

add_filter( 'avada_load_more_posts_name', 'avada_handle_deprecated_load_more_posts_filter' );
/**
 * Make sure that the wrongly spelled avada_load_more_pots_name filter can still be used
 * Kept for backwards-compatibility
 */
function avada_handle_deprecated_load_more_posts_filter( $text ) {
	$load_more_posts_text = apply_filters( 'avada_load_more_pots_name', '' );

	if ( $load_more_posts_text ) {
		return $load_more_posts_text;
	} else {
		return $text;
	}
}

add_filter( 'avada_read_more_name', 'avada_handle_deprecated_blog_read_more_link_filter' );
/**
 * Make sure that the wrongly spelled avada_load_more_pots_name filter can still be used
 * Kept for backwards-compatibility
 */
function avada_handle_deprecated_blog_read_more_link_filter( $text ) {
	$read_more_text = apply_filters( 'avada_blog_read_more_link', '' );

	if ( $read_more_text ) {
		return $read_more_text;
	} else {
		return $text;
	}
}

add_filter( 'fusion_faq_all_filter_name', 'avada_handle_deprecated_faq_all_filter_name_filter' );
/**
 * Keep Backwards-compatibility.
 *
 * @since 5.0.0
 */
function avada_handle_deprecated_faq_all_filter_name_filter( $filter_name_default ) {
	$filter_name = apply_filters( 'avada_faq_all_filter_name', '' );

	if ( $filter_name ) {
		return $filter_name;
	} else {
		return $filter_name_default;
	}
}

add_action( 'avada_before_main_container', 'avada_handle_deprecated_before_main_action' );
/**
 * Keep Backwards-compatibility.
 */
function avada_handle_deprecated_before_main_action() {
	do_action( 'avada_before_main' );
}

add_action( 'avada_after_content', 'avada_handle_deprecated_after_content_action' );
/**
 * Keep Backwards-compatibility.
 */
function avada_handle_deprecated_after_content_action() {
	do_action( 'fusion_after_content' );
}

add_action( 'fusion_portfolio_shortcode_content', 'avada_handle_deprecated_recent_works_content' );
/**
 * Keep Backwards-compatibility.
 */
function avada_handle_deprecated_recent_works_content() {
	do_action( 'fusion_recent_works_shortcode_content' );
}

/**
 * Alias for the Avada_Megamenu_Framework class.
 * Kept for child-themes compatibility.
 */
class FusionMegaMenuFramework extends Avada_Megamenu_Framework {}

/**
 * Alias for the Avada_Megamenu class.
 * Kept for child-themes compatibility.
 */
class FusionMegaMenu extends Avada_Megamenu {}

/**
 * Alias for the Avada_Nav_Walker class.
 * Kept for child-themes compatibility.
 */
class FusionCoreFrontendWalker extends Avada_Nav_Walker {}

/**
 * Alias for the Avada_Nav_Walker_Megamenu class.
 * Kept for child-themes compatibility.
 */
class FusionCoreMegaMenus extends Avada_Nav_Walker_Megamenu {}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
