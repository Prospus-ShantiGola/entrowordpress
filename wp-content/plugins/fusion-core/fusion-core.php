<?php
/*
Plugin Name: Fusion Core
Plugin URI: http://theme-fusion.com
Description: ThemeFusion Core Plugin for ThemeFusion Themes
Version: 3.0.2
Author: ThemeFusion
Author URI: http://theme-fusion.com
*/

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

// plugin path
define( 'FUSION_CORE_PATH', plugin_dir_path( __FILE__ ) );

if ( ! class_exists( 'FusionCore_Plugin' ) ) {
	class FusionCore_Plugin {
		/**
		 * Plugin version, used for cache-busting of style and script file references.
		 *
		 * @since   1.0.0
		 *
		 * @var  string
		 */
		const VERSION = '3.0.2';

		/**
		 * Instance of the class.
		 *
		 * @since   1.0.0
		 *
		 * @var   object
		 */
		protected static $instance = null;

		/**
		 * Initialize the plugin by setting localization and loading public scripts
		 * and styles.
		 *
		 * @since    1.0.0
		 */
		private function __construct() {
			add_action( 'after_setup_theme', array( &$this, 'load_fusion_core_text_domain' ) );
		}

		/**
		 * Register the plugin text domain.
		 *
		 * @return void
		 */
		function load_fusion_core_text_domain() {
			load_plugin_textdomain( 'fusion-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Return an instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @return  object  A single instance of the class.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set yet, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;

		}

		/**
		 * Gets the value of a theme option.
		 *
		 * @since 3.0
		 *
		 * @access public
		 * @param string|null  $option The option.
		 * @param string|false $subset The sub-option in case of an array.
		 */
		public static function get_theme_option( $option = null, $subset = false ) {

			$value = '';

			// If Avada is installed, use it to get the theme-option.
			if ( class_exists( 'Avada' ) ) {
				$value = Avada()->settings->get( $option, $subset );
			}

			return apply_filters( 'fusion_core_get_theme_option', $value, $option, $subset );

		}
	}
}
// Load the instance of the plugin
add_action( 'plugins_loaded', array( 'FusionCore_Plugin', 'get_instance' ) );


/**
 * Fusion Slider
 */
include_once 'fusion-slider.php';

/**
 * Elastic Slider admin menu
 */
add_action( 'admin_menu', 'fusion_admin_menu' );
function fusion_admin_menu() {
	global $submenu;

	unset( $submenu['edit.php?post_type=themefusion_elastic'][10] );
}

/**
 * Register custom post types
 */
add_action( 'init', 'fusion_register_post_types' );
function fusion_register_post_types() {
	$permalinks = get_option( 'avada_permalinks' );

	// Portfolio
	register_post_type(
		'avada_portfolio',
		array(
			'labels'      => array(
				'name'          => _x( 'Portfolio', 'Post Type General Name', 'fusion-core' ),
				'singular_name' => _x( 'Portfolio', 'Post Type Singular Name', 'fusion-core' ),
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array(
				'slug' => FusionCore_Plugin::get_theme_option( 'portfolio_slug' ),
			),
			'supports'    => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
			'can_export'  => true,
		)
	);

	register_taxonomy(
		'portfolio_category',
		'avada_portfolio',
		array(
			'hierarchical' => true,
			'label'        => __( 'Portfolio Categories', 'fusion-core' ),
			'query_var'    => true,
			'rewrite'      => array(
				'slug'       => empty( $permalinks['portfolio_category_base'] ) ? _x( 'portfolio_category', 'slug', 'fusion-core' ) : $permalinks['portfolio_category_base'],
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'portfolio_skills',
		'avada_portfolio',
		array(
			'hierarchical' => true,
			'label'        => __( 'Skills', 'fusion-core' ),
			'query_var'    => true,
			'rewrite'      => array(
				'slug'       => empty( $permalinks['portfolio_skills_base'] ) ? _x( 'portfolio_skills', 'slug', 'fusion-core' ) : $permalinks['portfolio_skills_base'],
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'portfolio_tags',
		'avada_portfolio',
		array(
			'hierarchical' => false,
			'label'        => __( 'Tags', 'fusion-core' ),
			'query_var'    => true,
			'rewrite'      => array(
				'slug'       => empty( $permalinks['portfolio_tags_base'] ) ? _x( 'portfolio_tags', 'slug', 'fusion-core' ) : $permalinks['portfolio_tags_base'],
				'with_front' => false,
			),
		)
	);

	// FAQ
	register_post_type(
		'avada_faq',
		array(
			'labels' => array(
				'name'          => _x( 'FAQs', 'Post Type General Name', 'fusion-core' ),
				'singular_name' => _x( 'FAQ', 'Post Type Singular Name', 'fusion-core' ),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'faq-items' ),
			'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
			'can_export' => true,
		)
	);

	register_taxonomy(
		'faq_category',
		'avada_faq',
		array(
			'hierarchical' => true,
			'label'        => 'FAQ Categories',
			'query_var'    => true,
			'rewrite'      => true,
		)
	);

	// Elastic Slider
	if ( FusionCore_Plugin::get_theme_option( 'status_eslider' ) ) {
		register_post_type(
			'themefusion_elastic',
			array(
				'public' => true,
				'has_archive' => false,
				'rewrite' => array( 'slug' => 'elastic-slide' ),
				'supports' => array( 'title', 'thumbnail' ),
				'can_export' => true,
				'menu_position' => 100,
				'labels' => array(
					'name'               => _x( 'Elastic Sliders', 'Post Type General Name', 'fusion-core' ),
					'singular_name'      => _x( 'Elastic Slider', 'Post Type Singular Name', 'fusion-core' ),
					'menu_name'          => esc_attr__( 'Elastic Slider', 'fusion-core' ),
					'parent_item_colon'  => esc_attr__( 'Parent Slide:', 'fusion-core' ),
					'all_items'          => esc_attr__( 'Add or Edit Slides', 'fusion-core' ),
					'view_item'          => esc_attr__( 'View Slides', 'fusion-core' ),
					'add_new_item'       => esc_attr__( 'Add New Slide', 'fusion-core' ),
					'add_new'            => esc_attr__( 'Add New Slide', 'fusion-core' ),
					'edit_item'          => esc_attr__( 'Edit Slide', 'fusion-core' ),
					'update_item'        => esc_attr__( 'Update Slide', 'fusion-core' ),
					'search_items'       => esc_attr__( 'Search Slide', 'fusion-core' ),
					'not_found'          => esc_attr__( 'Not found', 'fusion-core' ),
					'not_found_in_trash' => esc_attr__( 'Not found in Trash', 'fusion-core' ),
				),
			)
		);

		register_taxonomy(
			'themefusion_es_groups',
			'themefusion_elastic',
			array(
				'hierarchical' => false,
				'query_var' => true,
				'rewrite' => true,
				'labels' => array(
					'name'                       => _x( 'Groups', 'Taxonomy General Name', 'fusion-core' ),
					'singular_name'              => _x( 'Group', 'Taxonomy Singular Name', 'fusion-core' ),
					'menu_name'                  => __( 'Add or Edit Groups', 'fusion-core' ),
					'all_items'                  => __( 'All Groups', 'fusion-core' ),
					'parent_item_colon'          => __( 'Parent Group:', 'fusion-core' ),
					'new_item_name'              => __( 'New Group Name', 'fusion-core' ),
					'add_new_item'               => __( 'Add Groups', 'fusion-core' ),
					'edit_item'                  => __( 'Edit Group', 'fusion-core' ),
					'update_item'                => __( 'Update Group', 'fusion-core' ),
					'separate_items_with_commas' => __( 'Separate groups with commas', 'fusion-core' ),
					'search_items'               => __( 'Search Groups', 'fusion-core' ),
					'add_or_remove_items'        => __( 'Add or remove groups', 'fusion-core' ),
					'choose_from_most_used'      => __( 'Choose from the most used groups', 'fusion-core' ),
					'not_found'                  => __( 'Not Found', 'fusion-core' ),
				),
			)
		);
	}

	// qTranslate and mqTranslate custom post type support
	if ( function_exists( 'qtrans_getLanguage' ) ) {
		add_action( 'portfolio_category_add_form', 'qtrans_modifyTermFormFor' );
		add_action( 'portfolio_category_edit_form', 'qtrans_modifyTermFormFor' );
		add_action( 'portfolio_skills_add_form', 'qtrans_modifyTermFormFor' );
		add_action( 'portfolio_skills_edit_form', 'qtrans_modifyTermFormFor' );
		add_action( 'portfolio_tags_add_form', 'qtrans_modifyTermFormFor' );
		add_action( 'portfolio_tags_edit_form', 'qtrans_modifyTermFormFor' );
		add_action( 'faq_category_edit_form', 'qtrans_modifyTermFormFor' );
	}
}
