<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main theme class.
 */
class Avada {

	/**
	 * The template directory path.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_path = '';

	/**
	 * The template directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_url = '';

	/**
	 * The stylesheet directory path.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $stylesheet_dir_path = '';

	/**
	 * The stylesheet directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $stylesheet_dir_url = '';

	/**
	 * The one, true instance of the Avada object.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * The theme version.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $version = '5.0.2';

	/**
	 * The original option name.
	 * This is the untainted option name, without using any languages.
	 * If you want the property including language, use $option_name instead.
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $original_option_name = 'avada_theme_options';

	/**
	 * The option name including the language suffix.
	 * If you want the option name without language, use $original_option_name.
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $option_name = '';

	/**
	 * The language we're using.
	 * This is used to modify $option_name.
	 * It is the language code prefixed with a '_'
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $lang = '';

	/**
	 * Determine if the language has been applied to the $option_name.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $lang_applied = false;

	/**
	 * Dertermine if the current language is set to "all".
	 *
	 * @static
	 * @access private
	 * @var bool
	 */
	private static $language_is_all = false;

	/**
	 * Determine if we're currently upgrading/migration options.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $is_updating  = false;

	/**
	 * Avada_Settings.
	 *
	 * @access public
	 * @var object
	 */
	public $settings;

	/**
	 * Avada_Options.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $options = null;

	/**
	 * Bundled Plugins.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $bundled_plugins = array();

	/**
	 * Avada_Init.
	 *
	 * @access public
	 * @var object
	 */
	public $init;

	/**
	 * Avada_Social_Sharing.
	 *
	 * @access public
	 * @var object
	 */
	public $social_sharing;

	/**
	 * Avada_Template.
	 *
	 * @access public
	 * @var object
	 */
	public $template;

	/**
	 * Avada_Blog.
	 *
	 * @access public
	 * @var object
	 */
	public $blog;

	/**
	 * Avada_Images.
	 *
	 * @access public
	 * @var object
	 */
	public $images;

	/**
	 * Avada_Head.
	 *
	 * @access public
	 * @var object
	 */
	public $head;

	/**
	 * Avada_Layout.
	 *
	 * @access public
	 * @var object
	 */
	public $layout;

	/**
	 * Avada_Dynamic_CSS.
	 *
	 * @access public
	 * @var object
	 */
	public $dynamic_css;

	/**
	 * Avada_GoogleMap.
	 *
	 * @access public
	 * @var object
	 */
	public $google_map;

	/**
	 * Avada_EventsCalendar.
	 *
	 * @access public
	 * @var object Avada_EventsCalendar.
	 */
	public $events_calendar;

	/**
	 * Avada_Remote_installer.
	 *
	 * @access public
	 * @var object Avada_Remote_installer.
	 */
	public $remote_install;

	/**
	 * Avada_Product_registration
	 *
	 * @access public
	 * @var object Avada_Product_registration.
	 */
	public $registration;

	/**
	 * Avada_Theme_Updater.
	 *
	 * @access public
	 * @var object Avada_Theme_Updater.
	 */
	public $theme_updater;

	/**
	 * The current page ID.
	 *
	 * @access public
	 * @var bool|int
	 */
	public static $c_page_id = false;

	/**
	 * Access the single instance of this class.
	 *
	 * @return Avada
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Avada();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to get the settings.
	 */
	public static function settings() {
		return self::get_instance()->settings->get_all();
	}

	/**
	 * The class constructor
	 */
	private function __construct() {

		// Add a non-persistent cache group.
		if ( ! class_exists( 'WpeCommon' ) ) {
			wp_cache_add_non_persistent_groups( 'avada' );
		}

		// Set static vars.
		if ( '' === self::$template_dir_path ) {
			self::$template_dir_path = get_template_directory();
		}
		if ( '' === self::$template_dir_url ) {
			self::$template_dir_url = get_template_directory_uri();
		}
		if ( '' === self::$stylesheet_dir_path ) {
			self::$stylesheet_dir_path = get_stylesheet_directory();
		}
		if ( '' === self::$stylesheet_dir_url ) {
			self::$stylesheet_dir_url = get_stylesheet_directory_uri();
		}

		$this->set_is_updating();

		// Multilingual handling.
		self::multilingual_options();
		// Make sure that $option_name is set.
		// This is run AFTER the multilingual option as a fallback.
		if ( empty( self::$option_name ) ) {
			self::$option_name = self::get_option_name();
		}

		// Initialize bundled plugins array.
		self::$bundled_plugins = array(
			'fusion_core' => array( 'slug' => 'fusion-core', 'name' => 'Fusion Core', 'version' => '3.0.2' ),
			'fusion_builder' => array( 'slug' => 'fusion-builder', 'name' => 'Fusion Builder', 'version' => '1.0.2' ),
			'layer_slider' => array( 'slug' => 'LayerSlider', 'name' => 'LayerSlider WP', 'version' => '5.6.10' ),
			'slider_revolution' => array( 'slug' => 'revslider', 'name' => 'Slider Revolution', 'version' => '5.2.6' ),
		);

		// Instantiate secondary classes.
		$this->settings       = Avada_Settings::get_instance();
		$this->registration   = new Avada_Product_Registration();
		$this->init           = new Avada_Init();
		$this->social_sharing = new Avada_Social_Sharing();
		$this->template       = new Avada_Template();
		$this->blog           = new Avada_Blog();
		$this->images         = new Avada_Images();
		$this->head           = new Avada_Head();
		$this->dynamic_css    = new Avada_Dynamic_CSS();
		$this->layout         = new Avada_Layout();
		$this->google_map     = new Avada_GoogleMap();
		$this->remote_install = new Avada_Remote_installer();
		$this->theme_updater  = new Avada_Theme_Updater();
		add_action( 'wp', array( $this, 'set_page_id' ) );
	}

	/**
	 * Checks if we're in the migration page.
	 * It does that by checking _GET, and then sets the $is_updating property.
	 */
	public function set_is_updating() {
		if ( ! self::$is_updating && $_GET && isset( $_GET['avada_update'] ) && '1' == $_GET['avada_update'] ) {
			self::$is_updating = true;
		}
	}

	/**
	 * Gets the theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Gets the normalized theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_normalized_theme_version() {
		$theme_version = self::$version;
		$theme_version_array = explode( '.', $theme_version );

		if ( isset( $theme_version_array[2] ) && '0' === $theme_version_array[2] ) {
			$theme_version = $theme_version_array[0] . '.' . $theme_version_array[1];
		}

		return $theme_version;
	}

	/**
	 * Gets the bundled plugins.
	 *
	 * @since 5.0
	 *
	 * @return array Array of bundled plugins.
	 */
	public static function get_bundled_plugins() {
		return self::$bundled_plugins;
	}

	/**
	 * Gets the current page ID.
	 *
	 * @return string The current page ID.
	 */
	public function get_page_id() {
		return self::$c_page_id;
	}

	/**
	 * Sets the current page ID.
	 *
	 * @uses self::c_page_id
	 */
	public function set_page_id() {
		self::$c_page_id = self::c_page_id();
	}

	/**
	 * Gets the current page ID.
	 *
	 * @return bool|int
	 */
	private static function c_page_id() {
		$object_id = get_queried_object_id();

		$c_page_id = false;

		if ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) {
			$c_page_id = get_option( 'page_for_posts' );
		} else {
			// Use the $object_id if available.
			if ( isset( $object_id ) ) {
				$c_page_id = $object_id;
			}
			// If we're not on a singular post, set to false.
			if ( ! is_singular() ) {
				$c_page_id = false;
			}
			// Front page is the posts page.
			if ( isset( $object_id ) && 'posts' == get_option( 'show_on_front' ) && is_home() ) {
				$c_page_id = $object_id;
			}
			// The woocommerce shop page.
			if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
				$c_page_id = get_option( 'woocommerce_shop_page_id' );
			}
		}

		return $c_page_id;
	}

	/**
	 * Sets the $lang property for this object.
	 * Languages are prefixed with a '_'
	 *
	 * If we're not currently performing a migration
	 * it also checks if the options for the current language are set.
	 * If they are not, then we will copy the options from the main language.
	 */
	public static function multilingual_options() {
		// Set the self::$lang.
		if ( ! in_array( Avada_Multilingual::get_active_language(), array( '', 'en', 'all' ) ) ) {
			self::$lang = '_' . Avada_Multilingual::get_active_language();
		}
		// Make sure the options are copied if needed.
		if ( ! in_array( self::$lang, array( '', 'en', 'all' ) ) && ! self::$lang_applied ) {
			// Set the $option_name property.
			self::$option_name = self::get_option_name();
			// Get the options without using a language (defaults).
			$original_options = get_option( self::$original_option_name, array() );
			// Get options with a language.
			$options = get_option( self::$original_option_name . self::$lang, array() );
			// If we're not currently performing a migration and the options are not set
			// then we must copy the default options to the new language.
			if ( ! self::$is_updating && ! empty( $original_options ) && empty( $options ) ) {
				update_option( self::$original_option_name . self::$lang, get_option( self::$original_option_name ) );
			}
			// Modify the option_name to include the language.
			self::$option_name  = self::$original_option_name . self::$lang;
			// Set $lang_applied to true. Makes sure we don't do the above more than once.
			self::$lang_applied = true;
		}
	}

	/**
	 * Get the private $option_name.
	 * If empty returns the original_option_name.
	 *
	 * @return string
	 */
	public static function get_option_name() {
		if ( empty( self::$option_name ) ) {
			return self::$original_option_name;
		}
		return self::$option_name;
	}

	/**
	 * Get the private $original_option_name.
	 *
	 * @return string
	 */
	public static function get_original_option_name() {
		return self::$original_option_name;
	}

	/**
	 * Change the private $option_name.
	 *
	 * @param  false|string $option_name The option name to use.
	 */
	public static function set_option_name( $option_name = false ) {
		if ( false !== $option_name && ! empty( $option_name ) ) {
			self::$option_name = $option_name;
		}
	}

	/**
	 * Change the private $language_is_all property.
	 *
	 * @static
	 * @access public
	 * @param bool $is_all Whether we're on the "all" language option or not.
	 * @return null|void
	 */
	public static function set_language_is_all( $is_all ) {
		if ( true === $is_all ) {
			self::$language_is_all = true;
			return;
		}
		self::$language_is_all = false;
	}

	/**
	 * Get the private $language_is_all property.
	 *
	 * @static
	 * @access public
	 * @return bool
	 */
	public static function get_language_is_all() {
		return self::$language_is_all;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
