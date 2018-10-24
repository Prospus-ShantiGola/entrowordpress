<?php

/**
 * The class responsible for importing data remotely.
 */
class Avada_Importer_Data {

	/**
	 * The name of the demo we're trying to import
	 *
	 * @access protected
	 * @var string
	 */
	protected $demo;

	/**
	 * The demo data.
	 *
	 * @access protected
	 * @var array
	 */
	protected $demo_data = array();

	/**
	 * The root of the remote server where demos are off-loaded.
	 *
	 * @static
	 * @access protected
	 * @var string
	 */
	protected static $remote_server = 'https://updates.theme-fusion.com/avada_demo/?compressed=1';

	/**
	 * The path where we'll be writing our files.
	 *
	 * @access protected
	 * @var string
	 */
	protected $basedir = '';

	/**
	 * An array of files we want to get from the remote server.
	 *
	 * @access protected
	 * @var array
	 */
	protected $files = array();

	/**
	 * The class constructor
	 *
	 * @access public
	 * @param string|null $demo The demo name.
	 */
	public function __construct( $demo = null ) {

		// If no demo has been defined, early exit.
		if ( is_null( $demo ) ) {
			return;
		}

		// Set the demo's $demo property.
		$this->demo = $demo;

		$demos = self::get_data();

		// If the demo does not exist, early exit.
		if ( ! isset( $demos[ $demo ] ) ) {
			return;
		}
		$this->demo_data = $demos[ $demo ];

		// Where will we be saving our files?
		$upload_dir    = wp_upload_dir();
		$this->basedir = wp_normalize_path( $upload_dir['basedir'] . '/avada-demo-data' );
		// Attempt to create the necessary folders if they don't exist.
		$this->mkdir();

		// Get remote files and save them locally.
		$this->get_remote_files();

	}

	/**
	 * Gets the demos data from the remote server (or locally if remote is unreachable)
	 * decodes the JSON object and returns an array.
	 *
	 * @static
	 * @access public
	 * @since 5.0.0
	 * @return array
	 */
	public static function get_data() {

		$demos = get_transient( 'avada_demos' );
		// Reset demos if reset_transient=1.
		if ( isset( $_GET['reset_transient'] ) && '1' == $_GET['reset_transient'] ) {
			$demos = false;
		}
		// If the transient does not exist or we've reset it, continue to get the JSON.
		if ( false === $demos ) {
			// Get the local demos first.
			$demos = file_get_contents( Avada::$template_dir_path . '/includes/plugins/importer/demos.json' );
			$demos = json_decode( $demos, true );

			// Get the demo details from the remote server.
			$remote_demos = wp_remote_retrieve_body( wp_remote_get( self::$remote_server ) );
			$remote_demos = json_decode( $remote_demos, true );
			if ( ! empty( $remote_demos ) && $remote_demos && json_last_error() === JSON_ERROR_NONE ) {
				$demos = $remote_demos;
			}
			set_transient( 'avada_demos', $demos, WEEK_IN_SECONDS );
		}
		return $demos;
	}

	/**
	 * Create the necessary local folders if they don't already exist
	 *
	 * @access protected
	 */
	protected function mkdir() {

		if ( ! file_exists( $this->basedir ) ) {
			wp_mkdir_p( $this->basedir );
		}
		$demo_data_path = wp_normalize_path( $this->basedir . '/' . $this->demo . '_demo' );
		if ( ! file_exists( $demo_data_path ) ) {
			wp_mkdir_p( $demo_data_path );
		}
	}

	/**
	 * Ping the remote server
	 * Get the demo data
	 * Save the data locally
	 *
	 * @access protected
	 */
	protected function get_remote_files() {

		$folder_path = wp_normalize_path( $this->basedir . '/' . $this->demo . '_demo/' );

		if ( ! file_exists( $folder_path . 'data.zip' ) || DAY_IN_SECONDS < time() - filemtime( $folder_path . 'data.zip' ) ) {
			$response = avada_wp_get_http( $this->demo_data['zipFile'], $folder_path . 'data.zip' );
		}

		// Initialize the Wordpress filesystem.
		global $wp_filesystem;
		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
		}
		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
		}
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$unzipfile = unzip_file( $folder_path . 'data.zip', $folder_path );

		if ( $unzipfile ) {
			return true;
		}

		// Attempt to manually extract the zip.
		if ( class_exists( 'ZipArchive' ) ) {
			$zip = new ZipArchive;
			if ( true === $zip->open( $folder_path . 'data.zip' ) ) {
				$zip->extractTo( $folder_path );
				$zip->close();
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the path to the locally-saved files.
	 *
	 * @access public
	 * @param string $file Example: "avada.xml", "widget_data.json".
	 * @return string      Absolute path.
	 */
	public function get_path( $file ) {

		if ( 'theme_options.json' === $file || 'widget_data.json' === $file || 'fusion_slider.zip' === $file ) {
			$file = str_replace( '_', '-', $file );
		}
		return wp_normalize_path( $this->basedir . '/' . $this->demo . '_demo/' . $file );

	}

	/**
	 * Get the $remote_server static property.
	 *
	 * @static
	 * @access public
	 * @return string
	 */
	public static function get_remote_server_url() {
		return self::$remote_server;
	}

	/**
	 * Get the revslider property of this object.
	 *
	 * @access public
	 * @return false|array
	 */
	public function get_revslider() {

		// Early exit if we don't have anything.
		if ( ! isset( $this->demo_data['revSliders'] ) || empty( $this->demo_data['revSliders'] ) ) {
			return array();
		}
		return $this->demo_data['revSliders'];

	}


	/**
	 * Get the layerslider property of this object.
	 *
	 * @access public
	 * @return false|array
	 */
	public function get_layerslider() {

		// Early exit if we don't have anything.
		if ( ! isset( $this->demo_data['layerSliders'] ) || empty( $this->demo_data['layerSliders'] ) ) {
			return array();
		}
		return $this->demo_data['layerSliders'];

	}

	/**
	 * Is this demo a shop demo or not?
	 *
	 * @access public
	 * @return bool
	 */
	public function is_shop() {
		if ( isset( $this->demo_data['shop'] ) && true === $this->demo_data['shop'] ) {
			return true;
		}
		return false;
	}

	/**
	 * Get the sidebars data.
	 *
	 * @access public
	 * @return false|array
	 */
	public function get_sidebars() {
		if ( isset( $this->demo_data['sidebars'] ) && false != $this->demo_data['sidebars'] ) {
			return $this->demo_data['sidebars'];
		}
		return false;
	}

	/**
	 * Get the homepage title.
	 *
	 * @access public
	 * @return string
	 */
	public function get_homepage_title() {
		if ( isset( $this->demo_data['homeTitle'] ) ) {
			return $this->demo_data['homeTitle'];
		}
		return 'Home';
	}

	/**
	 * Get the woo pages.
	 *
	 * @access public
	 * @return false|array
	 */
	public function get_woopages() {
		if ( isset( $this->demo_data['woopages'] ) && false != $this->demo_data['woopages'] ) {
			return $this->demo_data['woopages'];
		}
		return false;
	}
}
