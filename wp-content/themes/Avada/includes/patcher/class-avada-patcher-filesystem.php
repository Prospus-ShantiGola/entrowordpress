<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Handles writing patches to the filesystem.
 *
 * @since 4.0.0
 */
class Avada_Patcher_Filesystem {

	/**
	 * Is this for the avada theme, or the fusion-core plugin?
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $target = 'avada';

	/**
	 * The remote source.
	 *
	 * @static
	 * @access public
	 * @var null|string
	 */
	public static $source = null;

	/**
	 * The path of the target.
	 *
	 * @static
	 * @access public
	 * @var null|string
	 */
	public static $destination = null;

	/**
	 * Whether the file-writing was successful or not.
	 *
	 * @access public
	 * @var bool
	 */
	public $status = false;

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param string      $target      The context (avada/fusion-core/fusion-builder).
	 * @param string|null $source      The remote source.
	 * @param string|null $destination The destination path.
	 */
	public function __construct( $target = 'avada', $source = null, $destination = null ) {
		if ( is_null( $source ) || is_null( $destination ) ) {
			return;
		}
		self::$target      = $target;
		self::$source      = $source;
		self::$destination = $destination;
		// Instantiate the WordPress filesystem.
		$this->init_filesystem();
		// Write the source contents to the destination.
		$this->write_file();
	}

	/**
	 * Make sure the WordPress Filesystem class in properly instatiated.
	 *
	 * @access public
	 * @return void
	 */
	public function init_filesystem() {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
	}

	/**
	 * Get remote contents
	 *
	 * @access public
	 * @param  string $url  The URL we're getting our data from.
	 * @return false|string The contents of the remote URL, or false if we can't get it.
	 */
	public function get_remote( $url ) {
		$response = wp_remote_get( $url );
		if ( is_array( $response ) ) {
			return $response['body'];
		}
		// Add a message so that the user knows what happened.
		new Avada_Patcher_Admin_Notices( 'no-patch-contents', esc_attr__( 'The Avada patch contents cannot be retrieved. Please contact your host to unblock the "https://gist.github.com/" domain.', 'Avada' ) );
		return false;
	}

	/**
	 * Write our contents to the destination file.
	 *
	 * @access public
	 * @return bool Returns true if the process was successful, false otherwise.
	 */
	public function write_file() {
		$contents = $this->get_remote( self::$source );
		if ( ! $contents ) {
			$this->status = false;
			// Add a message to users for debugging purposes.
			new Avada_Patcher_Admin_Notices( 'patch-empty', esc_attr__( 'Patch empty.', 'Avada' ) );
			return false;
		}

		$target = false;
		if ( 'avada' === self::$target ) {
			$target = Avada::$template_dir_path;
		} elseif ( 'fusion-core' === self::$target && defined( 'FUSION_CORE_PATH' ) ) {
			$target = FUSION_CORE_PATH;
		} elseif ( 'fusion-builder' === self::$target && defined( 'FUSION_BUILDER_PLUGIN_DIR' ) ) {
			$target = FUSION_BUILDER_PLUGIN_DIR;
		}
		if ( false === $target ) {
			$this->status = false;
			// Add a message to users for debugging purposes.
			new Avada_Patcher_Admin_Notices( 'invalid-patch-target', esc_attr__( 'Invalid Patch target.', 'Avada' ) );
			return false;
		}
		global $wp_filesystem;
		$path = wp_normalize_path( $target . '/' . self::$destination );

		$this->status = $wp_filesystem->put_contents( $path, $contents, FS_CHMOD_FILE );
		if ( ! $this->status ) {
			// Add a message to users for debugging purposes.
			new Avada_Patcher_Admin_Notices( 'write-permissions-' . md5( $path ), sprintf( esc_attr__( 'Unable to write file %s to the filesystem.', 'Avada' ), $path ) );
		}
		return $this->status;
	}
}
