<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Handle migrations for Avada 4.0.0.
 *
 * @since 5.0.0
 */
class Avada_Upgrade_400 extends Avada_Upgrade_Abstract {

	/**
	 * The version.
	 *
	 * @access protected
	 * @since 5.0.0
	 * @var string
	 */
	protected $version = '4.0.0';

	/**
	 * The actual migration process.
	 *
	 * @access protected
	 * @since 5.0.0
	 */
	protected function migration_process() {

		Avada_AvadaRedux_Migration::get_instance();

	}
}
