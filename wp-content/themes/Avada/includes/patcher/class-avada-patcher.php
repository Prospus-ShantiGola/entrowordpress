<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main Patcher class for Avada.
 *
 * @since 4.0.0
 */
class Avada_Patcher {

	/**
	 * The one, true instance.
	 *
	 * @since 4.0.0
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * The class constructor.
	 * This is a singleton class so please use the ::get_instance() method instead.
	 */
	private function __construct() {

		if ( is_admin() && ( ( ( isset( $_GET['page'] ) && 'avada-support' === $_GET['page'] ) ) || ( isset( $_SERVER['HTTP_REFERER'] ) && false !== strpos( $_SERVER['HTTP_REFERER'], 'avada-support' ) ) ) ) {
			new Avada_Patcher_Apply_Patch();
			new Avada_Patcher_Admin_Screen();
		}

	}

	/**
	 * Get the one true instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Avada_Patcher();
		}
		return self::$instance;
	}
}
