<?php
/**
 * Fusion MegaMenu Functions
 *
 * WARNING: This file is part of the Mega Menu Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Fusion/MegaMenu
 * @author   ThemeFusion
 * @link	 http://theme-fusion.com
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Don't duplicate me!
if ( ! class_exists( 'Avada_Megamenu_Framework' ) ) {

	/**
	 * Main Avada_Megamenu_Framework Class
	 */
	class Avada_Megamenu_Framework {

		/**
		 * URL to the current folder.
		 *
		 * @static
		 * @access public
		 * @var string
		 */
		public static $_url;

		/**
		 * An array of URLs.
		 *
		 * @static
		 * @access public
		 * @var array
		 */
		public static $_urls;

		/**
		 * Path to the current folder.
		 *
		 * @static
		 * @access public
		 * @var string
		 */
		public static $_dir;

		/**
		 * An array of paths.
		 *
		 * @static
		 * @access public
		 * @var array
		 */
		public static $_dirs;

		/**
		 * Array of objects.
		 *
		 * @static
		 * @access public
		 * @var mixed
		 */
		public static $_classes;

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {

			$this->init();

			add_action( 'fusion_init', 				array( $this, 'include_functions' ) );

			add_action( 'admin_enqueue_scripts', 	array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts',	array( $this, 'register_stylesheets' ) );

			do_action( 'fusion_init' );

		}

		/**
		 * Things to run when this object is first instantiated.
		 *
		 * @static
		 * @access public
		 */
		public static function init() {

			// Windows-proof constants: replace backward by forward slashes. Thanks to: @peterbouwmeester.
			self::$_dir	 = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
			$wp_content_dir = trailingslashit( str_replace( '\\', '/', WP_CONTENT_DIR ) );
			$relative_url   = str_replace( $wp_content_dir, '', self::$_dir );
			$wp_content_url = ( is_ssl() ? str_replace( 'http://', 'https://', WP_CONTENT_URL ) : WP_CONTENT_URL );
			self::$_url	 = trailingslashit( $wp_content_url ) . $relative_url;

			self::$_urls = array(
				'parent'	=> Avada::$template_dir_url . '/',
				'child' 	=> Avada::$stylesheet_dir_path . '/',
				'framework'	=> self::$_url . 'framework',
			);

			self::$_urls['admin-js']  = Avada::$template_dir_url . '/assets/js';
			self::$_urls['admin-css'] = Avada::$template_dir_url . '/assets/css';

			self::$_dirs = array(
				'parent' 	=> Avada::$template_dir_path . '/',
				'child' 	=> Avada::$stylesheet_dir_path . '/',
				'framework' => self::$_dir . 'frameowrk',
			);

		}

		/**
		 * Instantiates the Avada_Megamenu class.
		 *
		 * @access public
		 */
		public function include_functions() {

			// Load functions.
			require_once( 'mega-menus.php' );

			self::$_classes['menus'] = new Avada_Megamenu();

		}

		/**
		 * Register megamenu javascript assets.
		 *
		 * @since  3.4
		 * @access public
		 * @param string $hook The hook we're currently on.
		 * @return void
		 */
		public function register_scripts( $hook ) {
			if ( 'nav-menus.php' == $hook ) {
				$theme_info = wp_get_theme();

				// Scripts.
				wp_enqueue_media();
				wp_register_script( 'avada-megamenu', trailingslashit( Avada::$template_dir_url ) . 'assets/js/mega-menu.js', array(), $theme_info->get( 'Version' ) );
				wp_enqueue_script( 'avada-megamenu' );
			}
		}

		/**
		 * Enqueue megamenu stylesheets
		 *
		 * @since  3.4
		 * @access public
		 * @param string $hook The hook we're currently on.
		 * @return void
		 */
		public function register_stylesheets( $hook ) {
			if ( 'nav-menus.php' == $hook ) {
				$theme_info = wp_get_theme();

				wp_enqueue_style( 'avada-megamenu', trailingslashit( Avada::$template_dir_url ) . 'assets/css/mega-menu.css', false, $theme_info->get( 'Version' ) );
			}
		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
