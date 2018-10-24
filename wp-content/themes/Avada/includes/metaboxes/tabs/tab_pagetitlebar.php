<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$this->select(
	'page_title',
	esc_attr__( 'Page Title Bar', 'Avada' ),
	array(
		'default'         => esc_attr__( 'Default', 'Avada' ),
		'yes'             => esc_attr__( 'Show Bar and Content', 'Avada' ),
		'yes_without_bar' => esc_attr__( 'Show Content Only', 'Avada' ),
		'no'              => esc_attr__( 'Hide', 'Avada' ),
	),
	esc_html__( 'Choose to show or hide the page title bar.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bar', '', 'select' )
);

// Dependency check that page title bar not hidden.
$page_title_dependency = array(
	array(
		'field'      => 'page_title',
		'value'      => 'no',
		'comparison' => '!=',
	),
);
if ( 'hide' == Avada()->settings->get( 'page_title_bar' ) ) {
	$page_title_dependency[] = array(
		'field'      => 'page_title',
		'value'      => 'default',
		'comparison' => '!=',
	);
}

$this->radio_buttonset(
	'page_title_breadcrumbs_search_bar',
	esc_html__( 'Breadcrumbs/Search Bar', 'Avada' ),
	array(
		'default'     => esc_attr__( 'Default', 'Avada' ),
		'breadcrumbs' => esc_attr__( 'Breadcrumbs', 'Avada' ),
		'searchbar'   => esc_attr__( 'Search Bar', 'Avada' ),
		'none'        => esc_attr__( 'None', 'Avada' ),
	),
	esc_html__( 'Choose to display the breadcrumbs, search bar or none.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bar_bs', '', 'select' ),
	$page_title_dependency
);

$this->radio_buttonset(
	'page_title_text',
	esc_html__( 'Page Title Bar Text', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'yes'     => esc_attr__( 'Show', 'Avada' ),
		'no'      => esc_attr__( 'Hide', 'Avada' ),
	),
	esc_html__( 'Choose to show or hide the page title bar text.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bar_text', '', 'showhide' ),
	$page_title_dependency
);

$page_title_text_dependency = $page_title_dependency;
$page_title_text_dependency[] = array(
	'field'      => 'page_title_text',
	'value'      => 'no',
	'comparison' => '!=',
);
if ( 0 == Avada()->settings->get( 'page_title_bar_text' ) ) {
	$page_title_text_dependency[] = array(
		'field'      => 'page_title_text',
		'value'      => 'default',
		'comparison' => '!=',
	);
}

$this->radio_buttonset(
	'page_title_text_alignment',
	esc_html__( 'Page Title Bar Text Alignment', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'left'    => esc_attr__( 'Left', 'Avada' ),
		'center'  => esc_attr__( 'Center', 'Avada' ),
		'right'   => esc_attr__( 'Right', 'Avada' ),
	),
	esc_attr__( 'Choose the title and subhead text alignment', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_alignment', '', 'select' ),
	$page_title_text_dependency
);

$this->textarea(
	'page_title_custom_text',
	esc_attr__( 'Page Title Bar Custom Text', 'Avada' ),
	esc_attr__( 'Insert custom text for the page title bar.', 'Avada' ),
	'',
	$page_title_text_dependency
);

$this->text(
	'page_title_text_size',
	esc_attr__( 'Page Title Bar Text Size', 'Avada' ),
	esc_html__( 'In pixels.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_font_size' ),
	$page_title_text_dependency
);

$this->textarea(
	'page_title_custom_subheader',
	esc_attr__( 'Page Title Bar Custom Subheader Text', 'Avada' ),
	esc_html__( 'Insert custom subhead text for the page title bar.', 'Avada' ),
	'',
	$page_title_text_dependency
);

$this->text(
	'page_title_custom_subheader_text_size',
	esc_html__( 'Page Title Bar Subhead Text Size', 'Avada' ),
	esc_attr__( 'In pixels, default is 10px.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_subheader_font_size' ),
	$page_title_text_dependency
);

$this->color(
	'page_title_font_color',
	esc_attr__( 'Page Title Font Color', 'Avada' ),
	esc_html__( 'Controls the text color of the page title fonts.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_color' ),
	false,
	$page_title_text_dependency,
	Avada()->settings->get( 'page_title_color' )
);

$this->radio_buttonset(
	'page_title_100_width',
	esc_html__( '100% Page Title Width', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'yes'     => esc_attr__( 'Yes', 'Avada' ),
		'no'      => esc_attr__( 'No', 'Avada' ),
	),
	esc_html__( 'Choose to set the page title content to 100% of the browser width. Select "No" for site width. Only works with wide layout mode.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_100_width', '', 'yesno' ),
	$page_title_dependency
);

$this->text(
	'page_title_height',
	esc_attr__( 'Page Title Bar Height', 'Avada' ),
	esc_html__( 'Set the height of the page title bar. In pixels ex: 100px.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_height' ),
	$page_title_dependency
);

$this->text(
	'page_title_mobile_height',
	esc_attr__( 'Page Title Bar Mobile Height', 'Avada' ),
	esc_html__( 'Set the height of the page title bar on mobile. In pixels ex: 100px.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_mobile_height' ),
	$page_title_dependency
);

// Dependency check that background is used.
$page_title_bg_dependency = $page_title_dependency;
$page_title_bg_dependency[] = array(
	'field'      => 'page_title',
	'value'      => 'yes_without_bar',
	'comparison' => '!=',
);
if ( 'content_only' == Avada()->settings->get( 'page_title_bar' ) ) {
	$page_title_bg_dependency[] = array(
		'field'      => 'page_title',
		'value'      => 'default',
		'comparison' => '!=',
	);
}
$this->color(
	'page_title_bar_bg_color',
	esc_attr__( 'Page Title Bar Background Color', 'Avada' ),
	esc_html__( 'Controls the background color of the page title bar. Hex code, ex: #000', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bg_color' ),
	true,
	$page_title_bg_dependency,
	Avada()->settings->get( 'page_title_bg_color' )
);

$this->color(
	'page_title_bar_borders_color',
	esc_attr__( 'Page Title Bar Borders Color', 'Avada' ),
	esc_html__( 'Controls the border color of the page title bar. Hex code, ex: #000', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_border_color' ),
	true,
	$page_title_bg_dependency,
	Avada()->settings->get( 'page_title_border_color' )
);

$this->upload(
	'page_title_bar_bg',
	esc_attr__( 'Page Title Bar Background', 'Avada' ),
	esc_html__( 'Select an image to use for the page title bar background.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bg', 'thumbnail' ),
	$page_title_bg_dependency
);

// Add check that regular background image has been added.
$retina_dependency = $page_title_bg_dependency;
$retina_dependency[] = array(
	'field'      => 'page_title_bar_bg',
	'value'      => '',
	'comparison' => '!=',
);
$this->upload(
	'page_title_bar_bg_retina',
	esc_attr__( 'Page Title Bar Background Retina', 'Avada' ),
	esc_html__( 'Select an image to use for retina devices.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bg_retina', 'thumbnail' ),
	$retina_dependency
);
$this->radio_buttonset(
	'page_title_bar_bg_full',
	esc_html__( '100% Background Image', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'no'      => esc_attr__( 'No', 'Avada' ),
		'yes'     => esc_attr__( 'Yes', 'Avada' ),
	),
	esc_html__( 'Choose to have the background image display at 100%.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bg_full', '', 'yesno' ),
	$retina_dependency
);

$this->radio_buttonset(
	'page_title_bg_parallax',
	esc_html__( 'Parallax Background Image', 'Avada' ),
	array(
		'default' => esc_attr__( 'Default', 'Avada' ),
		'no'      => esc_attr__( 'No', 'Avada' ),
		'yes'     => esc_attr__( 'Yes', 'Avada' ),
	),
	esc_html__( 'Choose a parallax scrolling effect for the background image.', 'Avada' ) . Avada()->settings->get_default_description( 'page_title_bg_parallax', '', 'yesno' ),
	$retina_dependency
);

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
