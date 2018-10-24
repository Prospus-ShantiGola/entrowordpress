<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fusion_Builder_Admin {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_save_fb_settings', array( $this, 'settings_save' ) );
	}

	/**
	 * Admin Menu.
	 *
	 * @access public
	 */
	function admin_menu() {
		global $submenu;

		$whatsnew = add_menu_page( esc_attr__( 'Fusion Builder', 'fusion-builder' ) , esc_attr__( 'Fusion Builder', 'fusion-builder' ), 'manage_options', 'fusion-builder-options', array( $this, 'whatsnew' ), 'dashicons-fusiona-logo', '2.222222' );
		if ( ! class_exists( 'Avada' ) ) {
			$register = add_submenu_page( 'fusion-builder-options', esc_attr__( 'Product Registration', 'fusion-builder' ), esc_attr__( 'Product Registration', 'fusion-builder' ), 'manage_options', 'fusion-builder-product-registration', array( $this, 'register_tab' ) );
		}
		$support  = add_submenu_page( 'fusion-builder-options', esc_attr__( 'Support', 'fusion-builder' ), esc_attr__( 'Support', 'fusion-builder' ), 'manage_options', 'fusion-builder-support', array( $this, 'support_tab' ) );
		$faq      = add_submenu_page( 'fusion-builder-options', esc_attr__( 'FAQ', 'fusion-builder' ), esc_attr__( 'FAQ', 'fusion-builder' ), 'manage_options', 'fusion-builder-faq', array( $this, 'faq_tab' ) );
		$settings = add_submenu_page( 'fusion-builder-options', esc_attr__( 'Settings', 'fusion-builder' ), esc_attr__( 'Settings', 'fusion-builder' ), 'manage_options', 'fusion-builder-settings', array( $this, 'settings' ) );
		$addons = add_submenu_page( 'fusion-builder-options', esc_attr__( 'Add Ons', 'fusion-builder' ), esc_attr__( 'Add Ons', 'fusion-builder' ), 'manage_options', 'fusion-builder-addons', array( $this, 'addons' ) );

		if ( current_user_can( 'edit_theme_options' ) ) {
			$submenu['fusion-builder-options'][0][0] = __( 'Welcome', 'fusion-builder' );
		}

		add_action( 'admin_print_scripts-' . $whatsnew, array( $this, 'admin_scripts' ) );
		if ( ! class_exists( 'Avada' ) ) {
			add_action( 'admin_print_scripts-' . $register, array( $this, 'admin_scripts_with_js' ) );
		}
		add_action( 'admin_print_scripts-' . $support, array( $this, 'admin_scripts' ) );
		add_action( 'admin_print_scripts-' . $faq, array( $this, 'admin_scripts_with_js' ) );
		add_action( 'admin_print_scripts-' . $settings, array( $this, 'admin_scripts_with_js' ) );
		add_action( 'admin_print_scripts-' . $addons, array( $this, 'admin_scripts' ) );
	}

	/**
	 * Admin scripts.
	 *
	 * @access public
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'fusion_builder_admin_css', FUSION_BUILDER_PLUGIN_URL . 'css/fusion-builder-admin.css' );
	}

	/**
	 * Admin scripts including js.
	 *
	 * @access public
	 */
	public function admin_scripts_with_js() {
		wp_enqueue_style( 'fusion_builder_admin_css', FUSION_BUILDER_PLUGIN_URL . 'css/fusion-builder-admin.css' );
		wp_enqueue_script( 'fusion_builder_admin_faq_js', FUSION_BUILDER_PLUGIN_URL . 'js/admin/fusion-builder-admin.js' );
	}

	/**
	 * Loads the template file.
	 *
	 * @access public
	 */
	public function whatsnew() {
		require_once( 'admin-screens/whatsnew.php' );
	}

	/**
	 * Loads the template file.
	 *
	 * @access public
	 */
	public function register_tab() {
		require_once( 'admin-screens/register.php' );
	}

	/**
	 * Loads the template file.
	 *
	 * @access public
	 */
	public function support_tab() {
		require_once( 'admin-screens/support.php' );
	}

	/**
	 * Loads the template file.
	 *
	 * @access public
	 */
	public function faq_tab() {
		require_once( 'admin-screens/faq.php' );
	}

	/**
	 * Loads the template file.
	 *
	 * @access public
	 */
	public function settings() {
		require_once( 'admin-screens/settings.php' );
	}

	/**
	 * Loads the template file.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function addons() {
		require_once( 'admin-screens/addons.php' );
	}
	/**
	 * Add the title.
	 *
	 * @static
	 * @access protected
	 * @since 1.0
	 * @param string $title The title.
	 * @param string $page  The page slug.
	 */
	protected static function admin_tab( $title, $page ) {

		if ( isset( $_GET['page'] ) ) {
			$active_page = $_GET['page'];
		}

		if ( $active_page == $page ) {
			$link = 'javascript:void(0);';
			$active_tab = ' nav-tab-active';
		} else {
			$link = 'admin.php?page=' . $page;
			$active_tab = '';
		}

		echo '<a href="' . $link . '" class="nav-tab' . $active_tab . '">' . $title . '</a>';

	}

	/**
	 * Adds the footer.
	 *
	 * @static
	 * @access public
	 */
	public static function footer() {
		?>
		<div class="fusion-builder-thanks">
			<p class="description"><?php esc_html_e( 'Thank you for choosing Fusion Builder. We are honored and are fully dedicated to making your experience perfect.', 'fusion-builder' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Adds the header.
	 *
	 * @static
	 * @access public
	 */
	public static function header() {
		?>
		<h1><?php esc_html_e( 'Welcome to Fusion Builder!', 'fusion-builder' ); ?></h1>
		<div class="updated registration-notice-1" style="display: none;">
			<p><strong><?php esc_attr_e( 'Thanks for registering your purchase. You will now receive the automatic updates.', 'fusion-builder' ); ?></strong></p>
		</div>
		<div class="updated error registration-notice-2" style="display: none;">
			<p><strong><?php esc_attr_e( 'Please provide all the three details for registering your copy of Avada.', 'fusion-builder' ); ?>.</strong></p>
		</div>
		<div class="updated error registration-notice-3" style="display: none;">
			<p><strong><?php esc_attr_e( 'Something went wrong. Please verify your details and try again.', 'fusion-builder' ); ?></strong></p>
		</div>
		<div class="about-text">
			<?php printf( __( 'Fusion Builder is now installed and ready to use! Get ready to build something beautiful. Please <a href="%1$s" target="%2$s">register your purchase</a> to receive automatic updates and single page Avada Demo imports. We hope you enjoy it!', 'fusion-builder' ), admin_url( 'admin.php?page=avada' ), '_blank' ); ?>
		</div>
		<div class="avada-logo">
			<span class="fusion-builder-version">
				<?php printf( esc_attr__( 'Version %s', 'fusion-builder' ), FUSION_BUILDER_VERSION ); ?>
			</span>
		</div>
		<h2 class="nav-tab-wrapper">
			<?php
			self::admin_tab( esc_attr__( 'Welcome', 'fusion-builder' ), 'fusion-builder-options' );
			if ( ! class_exists( 'Avada' ) ) {
				self::admin_tab( esc_attr__( 'Product Registration', 'fusion-builder' ), 'fusion-builder-product-registration' );
			}
			self::admin_tab( esc_attr__( 'Support', 'fusion-builder' ), 'fusion-builder-support' );
			self::admin_tab( esc_attr__( 'FAQ', 'fusion-builder' ), 'fusion-builder-faq' );
			self::admin_tab( esc_attr__( 'Settings', 'fusion-builder' ), 'fusion-builder-settings' );
			self::admin_tab( esc_attr__( 'Add Ons', 'fusion-builder' ), 'fusion-builder-addons' );
			?>
		</h2>
		<?php
	}

	/**
	 * Handles the saving of settings in admin area.
	 *
	 * @access private
	 * @since 1.0
	 */
	public function settings_save() {
		update_option( 'fusion_builder_settings', $_POST );
		wp_redirect( admin_url( 'admin.php?page=fusion-builder-settings' ) );
		exit;
	}

	/**
	 * Checks if account belonging to tken has builder purchased
	 *
	 * @access public
	 * @since 1.0
	 * @return bool
	 */
	public function token_account_has_builder_purchased() {
		$plugins = envato_market()->api()->plugins();

		foreach ( $plugins as $plugin ) {
			if ( isset( $plugin['name'] ) ) {
				if ( 'fusion builder' == strtolower( $plugin['name'] ) ) {
					return true;
				}
			}
		}
		return false;
	}
}
new Fusion_Builder_Admin();
