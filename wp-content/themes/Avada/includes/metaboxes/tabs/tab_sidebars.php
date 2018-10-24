<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$post_type = get_post_type();
$sidebar_post_types = array(
	'page' => array(
		'global'   => 'pages_global_sidebar',
		'sidebar'  => 'pages_sidebar',
		'position' => 'default_sidebar_pos',
	),
	'post' => array(
		'global'   => 'posts_global_sidebar',
		'sidebar'  => 'posts_sidebar',
		'position' => 'blog_sidebar_position',
	),
	'avada_portfolio' => array(
		'global'   => 'portfolio_global_sidebar',
		'sidebar'  => 'portfolio_sidebar',
		'position' => 'portfolio_sidebar_position',
	),
	'product' => array(
		'global'   => 'woo_global_sidebar',
		'sidebar'  => 'woo_sidebar',
		'position' => 'woo_sidebar_position',
	),
	'tribe_events' => array(
		'global'   => 'ec_global_sidebar',
		'sidebar'  => 'ec_sidebar',
		'position' => 'ec_sidebar_pos',
	),
	'forum' => array(
		'global'   => 'bbpress_global_sidebar',
		'sidebar'  => 'ppbress_sidebar',
		'position' => 'bbpress_sidebar_position',
	),
	'topic' => array(
		'global'   => 'bbpress_global_sidebar',
		'sidebar'  => 'ppbress_sidebar',
		'position' => 'bbpress_sidebar_position',
	),
	'reply' => array(
		'global'   => 'bbpress_global_sidebar',
		'sidebar'  => 'ppbress_sidebar',
		'position' => 'bbpress_sidebar_position',
	),
);
$post_type_options = '';
if ( isset( $sidebar_post_types[ $post_type ] ) ) {
	$post_type_options = $sidebar_post_types[ $post_type ];
}
sidebar_generator::edit_form( $post_type_options );
$this->radio_buttonset(
	'sidebar_position',
	esc_attr__( 'Sidebar 1 Position', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'right'   => esc_attr__( 'Right', 'Avada' ),
		'left'    => esc_attr__( 'Left', 'Avada' ),
	),
	esc_html__( 'Select the sidebar 1 position. If sidebar 2 is selected, it will display on the opposite side.', 'Avada' ) . ( ( ! empty( $post_type_options ) ) ? Avada()->settings->get_default_description( $post_type_options['position'], '', 'select' ) : '' )
);
$this->color(
	'sidebar_bg_color',
	esc_attr__( 'Sidebar Background Color', 'Avada' ),
	esc_html__( 'Controls the background color of the sidebar. Hex code, ex: #000', 'Avada' ) . ( ( 'tribe_events' === $post_type ) ? Avada()->settings->get_default_description( 'ec_sidebar_bg_color' ) : Avada()->settings->get_default_description( 'sidebar_bg_color' ) ),
	true,
	array(),
	( ( 'tribe_events' === $post_type ) ? Avada()->settings->get( 'ec_sidebar_bg_color' ) : Avada()->settings->get( 'sidebar_bg_color' ) )
);

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
