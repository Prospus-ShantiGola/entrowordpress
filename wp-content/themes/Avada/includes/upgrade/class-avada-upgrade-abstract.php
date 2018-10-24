<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The Avada_Upgrade_Version is meant to be extended
 * by version-specific upgrade classes.
 *
 * @since 5.0.0
 */
abstract class Avada_Upgrade_Abstract {

	/**
	 * The version.
	 *
	 * @access protected
	 * @since 5.0.0
	 * @var string
	 */
	protected $version = '';

	/**
	 * An array of all avada options.
	 *
	 * @access protected
	 * @var array
	 */
	protected $avada_options;

	/**
	 * The theme version as stored in the db.
	 *
	 * @access protected
	 * @var string
	 */
	protected $database_theme_version;

	/**
	 * The class constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		// Set the database_theme_version.
		$this->database_theme_version = get_option( 'avada_version', true );
		// If the setting is not set, then set to current version.
		if ( ! $this->database_theme_version ) {
			$this->database_theme_version = Avada::get_theme_version();
		}
		if ( is_array( $this->database_theme_version ) ) {
			$this->database_theme_version = end( $this->database_theme_version );
		}
		// Make sure the version saved in the db is properly formatted.
		$this->database_theme_version = Avada_Helper::normalize_version( $this->database_theme_version );

		// Make sure the current version is properly formatted.
		$this->version = Avada_Helper::normalize_version( $this->version );

		// Set the options.
		$this->avada_options = get_option( Avada::get_option_name(), array() );

		// Trigger the migration.
		$this->migration_process();

		// Set the version.
		$this->update_version();

	}

	/**
	 * Updates the version.
	 *
	 * @access protected
	 * @since 5.0.0
	 */
	protected function update_version() {

		// Only update the version in the db when in the dashboard.
		if ( ! is_admin() ) {
			return;
		}

		// Do not update the version in the db
		// if the current version is greater than the one we're updating to.
		if ( ! $this->database_theme_version || empty( $this->database_theme_version ) ) {
			return;
		}
		if ( version_compare( $this->database_theme_version, $this->version, '>=' ) ) {
			return;
		}

		update_option( 'avada_version', $this->version );

	}

	/**
	 * The actual migration process.
	 * Empty on the parent class, meant to be overriden in version-specific classes.
	 *
	 * @access protected
	 * @since 5.0.0
	 */
	abstract protected function migration_process();

}
