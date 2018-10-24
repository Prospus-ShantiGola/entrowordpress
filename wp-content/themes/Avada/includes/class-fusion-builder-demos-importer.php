<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Demos importer.
 */
class Fusion_Builder_Demos_Importer {

	/**
	 * The remote API URL.
	 *
	 * @static
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private static $remote_api_url = 'http://updates.theme-fusion.com/avada_demo/?fusion_builder_demos=1&compressed=1';

	/**
	 * The demo we want to import.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $demo = '';

	/**
	 * The Remote URL of the file containing the demo pages.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $demo_remote_url = '';

	/**
	 * The path to the demo file locally.
	 *
	 * @access private
	 * @since 5.0.0
	 * @var string
	 */
	private $local_demo_path = '';

	/**
	 * The class constructor.
	 *
	 * @access public
	 * @since 5.0.0
	 * @param string $demo The demo slug.
	 */
	public function __construct( $demo ) {

		// Set $this->demo.
		$this->demo = $demo;

		// Set the local path for this demo.
		$this->local_demo_path = $this->get_local_demo_path();

	}

	/**
	 * Get the local demo path.
	 * If the path doesn't exist, it creates the folder for that path.
	 *
	 * @access private
	 * @since 5.0.0
	 * @return string
	 */
	private function get_local_demo_path() {

		// Get the basedir.
		$wp_upload_dir = wp_upload_dir();
		$basedir       = $wp_upload_dir['basedir'];

		// Build the path to the parent folder.
		// If the folder doesn't exist, create it.
		$parent_folder = wp_normalize_path( $basedir . '/fusion-builder-avada-pages' );
		if ( ! file_exists( $parent_folder ) ) {
			wp_mkdir_p( $parent_folder );
		}

		$path = wp_normalize_path( $parent_folder . '/' . str_replace( 'avada-', '', $this->demo . '.php' ) );
		if ( ! file_exists( $path ) ) {
			$this->get_file_path();
		}
		return $path;

	}

	/**
	 * Gets the path to the file containing the data.
	 * We're first checking if the data exists locally.
	 * If the file doesn't exist, then we'll need to get it remotely first.
	 *
	 * @access public
	 * @since 5.0.0
	 * @return string
	 */
	public function get_file_path() {

		// If Avada is not properly registered, return false.
		if ( ! Avada()->registration->is_registered() ) {
			return false;
		}

		// If the file doesn't exist, then we need to get it remotely.
		if ( ! file_exists( $this->local_demo_path ) ) { /* TODO: if ( ! file_exists( $this->local_demo_path ) || WEEK_IN_SECONDS < time() - filemtime( $this->local_demo_path ) ) { */

			// Early exit if we can't write to the destination folder.
			$can_write = self::can_write();
			if ( false === $can_write ) {
				return false;
			}

			$wp_upload_dir   = wp_upload_dir();
			$zip_folder_path = wp_normalize_path( $wp_upload_dir['basedir'] . '/fusion-builder-avada-pages/' );
			$zip_file_path   = wp_normalize_path( $zip_folder_path . 'data.zip' );

			$response = avada_wp_get_http( self::$remote_api_url, $zip_file_path );

			// Initialize the Wordpress filesystem.
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			$unzipfile = unzip_file( $zip_file_path, $zip_folder_path );
			if ( ! $unzipfile ) {
				return false;
			}
		}

		if ( file_exists( $this->local_demo_path ) ) {
			return $this->local_demo_path;
		}
		return false;
	}

	/**
	 * Is the folder writable?
	 *
	 * @static
	 * @access public
	 * @since 5.0.2
	 * @return bool
	 */
	public static function can_write() {

		$wp_upload_dir   = wp_upload_dir();
		$zip_folder_path = wp_normalize_path( $wp_upload_dir['basedir'] . '/fusion-builder-avada-pages/' );
		// If the folder doesn't exist, attempt to create it.
		if ( ! file_exists( $zip_folder_path ) ) {
			$new_folder = wp_mkdir_p( $zip_folder_path );
			// Return false if we were unable to create the folder.
			if ( false === $new_folder ) {
				return false;
			}
		}
		// Return true/false based on the target folder's writability.
		return wp_is_writable( $zip_folder_path );

	}
}
