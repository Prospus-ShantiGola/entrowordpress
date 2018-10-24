<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * A class to manage various stuff in the WordPress admin area.
 *
 * @package Avada
 * @subpackage Includes
 * @since 3.8.0
 */
class Avada_Admin {

	/**
	 * Holds the current theme version.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @var string
	 */
	private $theme_version;

	/**
	 * Holds the WP_Theme object of Avada.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @var WP_Theme object
	 */
	private $theme_object;


	/**
	 * Holds the URL to the Avada live demo site.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @var string
	 */
	private $theme_url = 'https://avada.theme-fusion.com/';


	/**
	 * Holds the URL to ThemeFusion company site.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 * @var string
	 */
	private $theme_fusion_url = 'https://theme-fusion.com/';

	/**
	 * Construct the admin object.
	 *
	 * @since 3.9.0
	 */
	public function __construct() {

		$this->set_theme_version();
		$this->set_theme_object();

		add_action( 'wp_before_admin_bar_render', array( $this, 'add_wp_toolbar_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_init', array( $this, 'init_permalink_settings' ) );
		add_action( 'admin_init', array( $this, 'save_permalink_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_head', array( $this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'edit_admin_menus' ) );
		add_action( 'after_switch_theme', array( $this, 'activation_redirect' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );

		add_filter( 'tgmpa_notice_action_links', array( $this, 'edit_tgmpa_notice_action_links' ) );
		$prefix = ( defined( 'WP_NETWORK_ADMIN' ) && WP_NETWORK_ADMIN ) ? 'network_admin_' : '';
		add_filter( "tgmpa_{$prefix}plugin_action_links", array( $this, 'edit_tgmpa_action_links' ), 10, 4 );

		// Get demos data on theme activation.
		add_action( 'after_switch_theme', array( 'Avada_Importer_Data', 'get_data' ), 5 );

		/*
		// Beta versioning.
		// add_action( 'admin_enqueue_scripts', array( $this, 'add_beta_testing_script' ) ); wpcs fix.
		*/

		// Load jQuery in the demos page.
		if ( isset( $_GET['page'] ) && 'avada-demos' === $_GET['page'] ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'add_jquery' ) );
		}
	}

	/**
	 * Adds jQuery.
	 *
	 * @since 5.0.0
	 * @access public
	 * @return void
	 */
	public function add_jquery() {
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Adds a script for beta testing only.
	 *
	 * @since 5.0.0
	 * @access public
	 * @return void
	 */
	public function add_beta_testing_script() {
		$ver = Avada::get_theme_version();
		wp_enqueue_script( 'avada_beta_testing', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-beta-testing.js', array(), $ver );
	}

	/**
	 * Adds the news dashboard widget.
	 *
	 * @since 3.9.0
	 * @access public
	 * @return void
	 */
	public function add_dashboard_widget() {
		// Create the widget.
		wp_add_dashboard_widget( 'themefusion_news', apply_filters( 'avada_dashboard_widget_title', esc_attr__( 'ThemeFusion News', 'Avada' ) ), array( $this, 'display_news_dashboard_widget' ) );

		// Make sure our widget is on top off all others.
		global $wp_meta_boxes;

		// Get the regular dashboard widgets array.
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

		// Backup and delete our new dashboard widget from the end of the array.
		$avada_widget_backup = array( 'themefusion_news' => $normal_dashboard['themefusion_news'] );
		unset( $normal_dashboard['themefusion_news'] );

		// Merge the two arrays together so our widget is at the beginning.
		$sorted_dashboard = array_merge( $avada_widget_backup, $normal_dashboard );

		// Save the sorted array back into the original metaboxes.
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}

	/**
	 * Renders the news dashboard widget.
	 *
	 * @since 3.9.0
	 * @access public
	 * @return void
	 */
	public function display_news_dashboard_widget() {

		// Create two feeds, the first being just a leading article with data and summary, the second being a normal news feed.
		$feeds = array(
			'first' => array(
				'link'         => 'http://theme-fusion.com/blog/',
				'url'          => 'http://theme-fusion.com/feed/',
				'title'        => esc_attr__( 'ThemeFusion News', 'Avada' ),
				'items'        => 1,
				'show_summary' => 1,
				'show_author'  => 0,
				'show_date'    => 1,
			),
			'news' => array(
				'link'         => 'http://theme-fusion.com/blog/',
				'url'          => 'http://theme-fusion.com/feed/',
				'title'        => esc_attr__( 'ThemeFusion News', 'Avada' ),
				'items'        => 4,
				'show_summary' => 0,
				'show_author'  => 0,
				'show_date'    => 0,
			),
		);

		wp_dashboard_primary_output( 'themefusion_news', $feeds );
	}

	/**
	 * Create the admin toolbar menu items.
	 *
	 * @since 3.8.0
	 * @access public
	 * @return void
	 */
	public function add_wp_toolbar_menu() {

		global $wp_admin_bar;

		if ( current_user_can( 'edit_theme_options' ) ) {

			$registration_complete = false;
			$token = Avada()->registration->get_token();
			if ( '' !== $token ) {
				$registration_complete = true;
			}
			$avada_parent_menu_title = '<span class="ab-icon"></span><span class="ab-label">Avada</span>';

			$this->add_wp_toolbar_menu_item( $avada_parent_menu_title, false, admin_url( 'admin.php?page=avada' ), array( 'class' => 'avada-menu' ), 'avada' );

			if ( ! $registration_complete ) {
				$this->add_wp_toolbar_menu_item( esc_attr__( 'Product Registration', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada' ) );
			}
			$this->add_wp_toolbar_menu_item( esc_attr__( 'Support', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-support' ) );
			$this->add_wp_toolbar_menu_item( esc_attr__( 'Install Demos', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-demos' ) );
			$this->add_wp_toolbar_menu_item( esc_attr__( 'Plugins', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-plugins' ) );
			$this->add_wp_toolbar_menu_item( esc_attr__( 'System Status', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-system-status' ) );
			$this->add_wp_toolbar_menu_item( esc_attr__( 'Theme Options', 'Avada' ), 'avada', admin_url( 'themes.php?page=avada_options' ) );

		}

	}

	/**
	 * Add the top-level menu item to the adminbar.
	 *
	 * @since 3.8.0
	 * @access public
	 * @param  string       $title       The title.
	 * @param  string|false $parent      The parent node.
	 * @param  string       $href        Link URL.
	 * @param  array        $custom_meta An array of custom meta to apply.
	 * @param  string       $custom_id   A custom ID.
	 */
	public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {

		global $wp_admin_bar;

		if ( current_user_can( 'edit_theme_options' ) ) {
			if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
				return;
			}

			// Set custom ID.
			if ( $custom_id ) {
				$id = $custom_id;
			} else { // Generate ID based on $title.
				$id = strtolower( str_replace( ' ', '-', $title ) );
			}

			// Links from the current host will open in the current window.
			$meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // External links open in new tab/window.
			$meta = array_merge( $meta, $custom_meta );

			$wp_admin_bar->add_node( array(
				'parent' => $parent,
				'id'     => $id,
				'title'  => $title,
				'href'   => $href,
				'meta'   => $meta,
			) );
		}

	}

	/**
	 * Modify the menu.
	 *
	 * @since 3.8.0
	 * @access public
	 * @return void
	 */
	public function edit_admin_menus() {
		global $submenu;

		if ( current_user_can( 'edit_theme_options' ) ) {
			$submenu['avada'][0][0] = esc_attr__( 'Product Registration', 'Avada' ); // Change Avada to Product Registration.
		}
	}

	/**
	 * Redirect to admin page on theme activation.
	 *
	 * @since 3.8.0
	 * @access public
	 * @return void
	 */
	public function activation_redirect() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			// Do not redirect if a migration is needed for Avada 5.0.0.
			if ( true === Fusion_Builder_Migrate::needs_migration() ) {
				return;
			}
			header( 'Location:' . admin_url() . 'admin.php?page=avada' );
		}
	}

	/**
	 * Actions to run on initial theme activation.
	 *
	 * @since 3.8.0
	 * @access public
	 * @return void
	 */
	public function admin_init() {

		if ( current_user_can( 'edit_theme_options' ) ) {

			if ( isset( $_GET['avada-deactivate'] ) && 'deactivate-plugin' === $_GET['avada-deactivate'] ) {
				check_admin_referer( 'avada-deactivate', 'avada-deactivate-nonce' );

				$plugins = TGM_Plugin_Activation::$instance->plugins;

				foreach ( $plugins as $plugin ) {
					if ( $plugin['slug'] == $_GET['plugin'] ) {
						deactivate_plugins( $plugin['file_path'] );
					}
				}
			}
			if ( isset( $_GET['avada-activate'] ) && 'activate-plugin' === $_GET['avada-activate'] ) {
				check_admin_referer( 'avada-activate', 'avada-activate-nonce' );

				$plugins = TGM_Plugin_Activation::$instance->plugins;

				foreach ( $plugins as $plugin ) {
					if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {
						activate_plugin( $plugin['file_path'] );

						wp_redirect( admin_url( 'admin.php?page=avada-plugins' ) );
						exit;
					}
				}
			}
		}
	}

	/**
	 * Adds the admin menu.
	 *
	 * @access  public
	 * @return void
	 */
	public function admin_menu() {

		if ( current_user_can( 'edit_theme_options' ) ) {
			// Work around for theme check.
			$avada_menu_page_creation_method    = 'add_menu_page';
			$avada_submenu_page_creation_method = 'add_submenu_page';

			$welcome_screen = $avada_menu_page_creation_method( 'Avada', 'Avada', 'administrator', 'avada', array( $this, 'welcome_screen' ), 'dashicons-fusiona-logo', '2.111111' );

			$support       = $avada_submenu_page_creation_method( 'avada', esc_attr__( 'Avada Support', 'Avada' ), esc_attr__( 'Support', 'Avada' ), 'administrator', 'avada-support', array( $this, 'support_tab' ) );
			$demos         = $avada_submenu_page_creation_method( 'avada', esc_attr__( 'Install Avada Demos', 'Avada' ), esc_attr__( 'Install Demos', 'Avada' ), 'administrator', 'avada-demos', array( $this, 'demos_tab' ) );
			$plugins       = $avada_submenu_page_creation_method( 'avada', esc_attr__( 'Plugins', 'Avada' ), esc_attr__( 'Plugins', 'Avada' ), 'administrator', 'avada-plugins', array( $this, 'plugins_tab' ) );
			$status        = $avada_submenu_page_creation_method( 'avada', esc_attr__( 'System Status', 'Avada' ), esc_attr__( 'System Status', 'Avada' ), 'administrator', 'avada-system-status', array( $this, 'system_status_tab' ) );
			$theme_options = $avada_submenu_page_creation_method( 'avada', esc_attr__( 'Theme Options', 'Avada' ), esc_attr__( 'Theme Options', 'Avada' ), 'administrator', 'themes.php?page=avada_options' );

			if ( ! class_exists( 'AvadaReduxFrameworkPlugin' ) ) {
				$theme_options_global = $avada_submenu_page_creation_method( 'themes.php', esc_attr__( 'Theme Options', 'Avada' ), esc_attr__( 'Theme Options', 'Avada' ), 'administrator', 'themes.php?page=avada_options' );
			}

			add_action( 'admin_print_scripts-' . $welcome_screen, array( $this, 'welcome_screen_scripts' ) );
			add_action( 'admin_print_scripts-' . $support, array( $this, 'support_screen_scripts' ) );
			add_action( 'admin_print_scripts-' . $demos, array( $this, 'demos_screen_scripts' ) );
			add_action( 'admin_print_scripts-' . $plugins, array( $this, 'plugins_screen_scripts' ) );
			add_action( 'admin_print_scripts-' . $status, array( $this, 'status_screen_scripts' ) );
		}
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function welcome_screen() {
		require_once( 'admin-screens/welcome.php' );
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function support_tab() {
		require_once( 'admin-screens/support.php' );
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function demos_tab() {
		require_once( 'admin-screens/install-demos.php' );
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function plugins_tab() {
		require_once( 'admin-screens/fusion-plugins.php' );
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function system_status_tab() {
		require_once( 'admin-screens/system-status.php' );
	}

	/**
	 * Renders the admin screens header with title, logo and tabs.
	 *
	 * @since 5.0.0
	 *
	 * @access  public
	 * @param string $screen The current screen.
	 * @return void
	 */
	public function get_admin_screens_header( $screen = 'welcome' ) {
		?>
		<h1><?php _e( 'Welcome to Avada!', 'Avada' ); ?></h1>

		<?php if ( 'demos' === $screen ) : ?>
			<div class="updated error importer-notice importer-notice-1" style="display: none;">
				<p><strong><?php esc_attr_e( "We're sorry but the demo data could not be imported. It is most likely due to low PHP configurations on your server. There are two possible solutions.", 'Avada' ); ?></strong></p>

				<p><strong><?php esc_attr_e( 'Solution 1:', 'Avada' ); ?></strong> <?php esc_attr_e( 'Import the demo using an alternate method.', 'Avada' ); ?><a href="https://theme-fusion.com/avada-doc/demo-content-info/alternate-demo-method/" class="button-primary" target="_blank" style="margin-left: 10px;"><?php esc_attr_e( 'Alternate Method', 'Avada' ); ?></a></p>
				<p><strong><?php esc_attr_e( 'Solution 2:', 'Avada' ); ?></strong> <?php printf( __( 'Fix the PHP configurations in the System Status that are reported in <strong style="color: red;">RED</strong>, then use the %s, then reimport.', 'Avada' ), '<a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472">' . esc_attr__( 'Reset WordPress Plugin', 'Avada' ) . '</a>' ); ?><a href="<?php echo admin_url( 'admin.php?page=avada-system-status' ); ?>" class="button-primary" target="_blank" style="margin-left: 10px;"><?php esc_attr_e( 'System Status', 'Avada' ); ?></a></p>
			</div>

			<div class="updated importer-notice importer-notice-2" style="display: none;"><p><?php printf( esc_html__( 'Demo data successfully imported. Now, please install and run %s plugin once.', 'Avada' ), '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472' ) . ' class="thickbox" title="' . esc_attr__( 'Regenerate Thumbnails', 'Avada' ) . '">' . esc_attr__( 'Regenerate Thumbnails', 'Avada' ) . '</a>' ); ?></p></div>

			<div class="updated error importer-notice importer-notice-3" style="display: none;">
				<p><strong><?php esc_attr_e( "We're sorry but the demo data could not be imported. It is most likely due to low PHP configurations on your server. There are two possible solutions.", 'Avada' ); ?></strong></p>

				<p><strong><?php esc_attr_e( 'Solution 1:', 'Avada' ); ?></strong> <?php esc_attr_e( 'Import the demo using an alternate method.', 'Avada' ); ?><a href="https://theme-fusion.com/avada-doc/demo-content-info/alternate-demo-method/" class="button-primary" target="_blank" style="margin-left: 10px;"><?php esc_attr_e( 'Alternate Method', 'Avada' ); ?></a></p>
				<p><strong><?php esc_attr_e( 'Solution 2:', 'Avada' ); ?></strong> <?php printf( __( 'Fix the PHP configurations in the System Status that are reported in <strong style="color: red;">RED</strong>, then use the %s, then reimport.', 'Avada' ), '<a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472">' . esc_attr__( 'Reset WordPress Plugin', 'Avada' ) . '</a>' ); ?><a href="<?php echo admin_url( 'admin.php?page=avada-system-status' ); ?>" class="button-primary" target="_blank" style="margin-left: 10px;"><?php esc_attr_e( 'System Status', 'Avada' ); ?></a></p>
			</div>
		<?php endif; ?>
		<div class="about-text"><?php printf( esc_html__( 'Avada is now installed and ready to use! Get ready to build something beautiful. Please register your purchase to get automatic theme updates, import Avada demos and install premium plugins. Read below for additional information. We hope you enjoy it! %s', 'Avada' ), '<a href="//youtube.com/embed/X92mpPz1COM?rel=0?KeepThis=true&TB_iframe=true" class="thickbox" title="' . esc_attr__( 'Guided Tour of Avada', 'Avada' ) . '">' . esc_attr__( 'Watch Our Quick Guided Tour!', 'Avada' ) . '</a>' ); ?></div>
		<div class="avada-logo"><span class="avada-version"><?php _e( 'Version', 'Avada' ); ?> <?php echo $this->theme_version; ?></span></div>
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo ( 'welcome' === $screen ) ? '#' : esc_url_raw( admin_url( 'admin.php?page=avada' ) ); ?>" class="<?php echo ( 'welcome' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Product Registration', 'Avada' ); ?></a>
			<a href="<?php echo ( 'support' === $screen ) ? '#' : esc_url_raw( admin_url( 'admin.php?page=avada-support' ) ); ?>" class="<?php echo ( 'support' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Support', 'Avada' ); ?></a>
			<a href="<?php echo ( 'demos' === $screen ) ? '#' : esc_url_raw( admin_url( 'admin.php?page=avada-demos' ) ); ?>" class="<?php echo ( 'demos' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Install Demos', 'Avada' ); ?></a>
			<a href="<?php echo ( 'plugins' === $screen ) ? '#' : esc_url_raw( admin_url( 'admin.php?page=avada-plugins' ) ); ?>" class="<?php echo ( 'plugins' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Plugins', 'Avada' ); ?></a>
			<a href="<?php echo ( 'system-status' === $screen ) ? '#' : esc_url_raw( admin_url( 'admin.php?page=avada-system-status' ) ); ?>" class="<?php echo ( 'system-status' === $screen ) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'System Status', 'Avada' ); ?></a>
		</h2>
		<?php
	}

	/**
	 * Add styles to admin.
	 *
	 * @access  public
	 * @return void
	 */
	public function admin_scripts() {
		?>
		<?php if ( is_admin() && current_user_can( 'edit_theme_options' ) ) : ?>
			<style type="text/css">
				@media screen and (max-width: 782px) {
					#wp-toolbar > ul > .avada-menu {
						display: block;
					}

					#wpadminbar .avada-menu > .ab-item .ab-icon {
						padding-top: 6px !important;
						height: 40px !important;
						font-size: 30px !important;
					}
				}
				#wpadminbar .avada-menu > .ab-item .ab-icon:before,
				.dashicons-fusiona-logo:before{
					content: "\e62d";
					font-family: 'icomoon';
					speak: none;
					font-style: normal;
					font-weight: normal;
					font-variant: normal;
					text-transform: none;
					line-height: 1;

					/* Better Font Rendering. */
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
				}

				.avada-install-plugins .theme .update-message { display: block !important; cursor: default; }
			</style>

			<?php
			global $pagenow;

			$ver = Avada::get_theme_version();

			// Add script to check for fusion option slider changes.
			if ( 'post-new.php' == $pagenow || 'edit.php' == $pagenow || 'post.php' == $pagenow ) {
				wp_enqueue_script( 'slider_preview', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/fusion-builder-slider-preview.js', array(), $ver );
			}
			if ( 'themes.php' == $pagenow || 'update-core.php' == $pagenow ) {
				wp_enqueue_script( 'welcome_screen', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-theme-update.js', array(), $ver );
			}
		endif;
	}

	/**
	 * Enqueues scripts & styles.
	 *
	 * @access  public
	 * @return void
	 */
	public function welcome_screen_scripts() {
		$ver = Avada::get_theme_version();
		wp_enqueue_style( 'avada_admin_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-admin.css', array(), $ver );
		wp_enqueue_style( 'welcome_screen_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-welcome-screen.css', array(), $ver );
		wp_enqueue_script( 'welcome_screen', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-welcome-screen.js', array(), $ver );
	}

	/**
	 * Enqueues scripts & styles.
	 *
	 * @access  public
	 * @return void
	 */
	public function support_screen_scripts() {
		$ver = Avada::get_theme_version();
		wp_enqueue_style( 'avada_admin_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-admin.css', array(), $ver );
	}

	/**
	 * Enqueues scripts & styles.
	 *
	 * @access  public
	 * @return void
	 */
	public function demos_screen_scripts() {
		$ver = Avada::get_theme_version();
		wp_enqueue_style( 'avada_admin_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-admin.css', array(), $ver );
		wp_enqueue_script( 'avada_admin_js', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-admin.js', array(), $ver );
	}

	/**
	 * Enqueues scripts & styles.
	 *
	 * @access  public
	 * @return void
	 */
	public function plugins_screen_scripts() {
		$ver = Avada::get_theme_version();
		wp_enqueue_style( 'avada_admin_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-admin.css', array(), $ver );
		wp_enqueue_script( 'avada_admin_js', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-admin.js', array(), $ver );
	}

	/**
	 * Enqueues scripts & styles.
	 *
	 * @access  public
	 * @return void
	 */
	public function status_screen_scripts() {
		$ver = Avada::get_theme_version();
		wp_enqueue_style( 'avada_admin_css', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/css/avada-admin.css', array(), $ver );
		wp_enqueue_script( 'avada_admin_js', trailingslashit( Avada::$template_dir_url ) . 'assets/admin/js/avada-admin.js', array(), $ver );
	}

	/**
	 * Get the plugin link.
	 *
	 * @access  public
	 * @param array $item The plugin in question.
	 * @return  array
	 */
	public function plugin_link( $item ) {
		$installed_plugins = get_plugins();

		$item['sanitized_plugin'] = $item['name'];

		$actions = array();

		// We have a repo plugin.
		if ( ! $item['version'] ) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
		}

		$disable_class = '';
		$data_version  = '';
		if ( 'fusion-builder' == $item['slug'] && false !== get_option( 'avada_previous_version' ) ) {
			$fusion_core_version = TGM_Plugin_Activation::$instance->get_installed_version( TGM_Plugin_Activation::$instance->plugins['fusion-core']['slug'] );

			if ( version_compare( $fusion_core_version, '3.0', '<' ) ) {
				$disable_class = ' disabled fusion-builder';
				$data_version = ' data-version=' . $fusion_core_version;
			}
		} elseif ( ( 'LayerSlider' == $item['slug'] || 'revslider' == $item['slug'] ) && ! Avada()->registration->is_registered() ) {
			$disable_class = ' disabled avada-no-token';
		}

		// We need to display the 'Install' hover link.
		if ( ! isset( $installed_plugins[ $item['file_path'] ] ) ) {
			if ( ! $disable_class ) {
				$url = esc_url( wp_nonce_url(
					add_query_arg(
						array(
							'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
							'plugin'        => urlencode( $item['slug'] ),
							'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
							'tgmpa-install' => 'install-plugin',
							'return_url'    => 'fusion_plugins',
						),
						TGM_Plugin_Activation::$instance->get_tgmpa_url()
					),
					'tgmpa-install',
					'tgmpa-nonce'
				) );
			} else {
				$url = '#';
			}
			$actions = array(
				'install' => '<a href="' . $url . '" class="button button-primary' . $disable_class . '"' . $data_version . ' title="' . sprintf( esc_attr__( 'Install %s', 'Avada' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Install', 'Avada' ) . '</a>',
			);
		} elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			// We need to display the 'Activate' hover link.
			if ( ! $disable_class ) {
				$url = esc_url( add_query_arg(
					array(
						'plugin'               => urlencode( $item['slug'] ),
						'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
						'avada-activate'       => 'activate-plugin',
						'avada-activate-nonce' => wp_create_nonce( 'avada-activate' ),
					),
					admin_url( 'admin.php?page=avada-plugins' )
				) );
			} else {
				$url = '#';
			}

			$actions = array(
				'activate' => '<a href="' . $url . '" class="button button-primary' . $disable_class . '"' . $data_version . ' title="' . sprintf( esc_attr__( 'Activate %s', 'Avada' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Activate' , 'Avada' ) . '</a>',
			);
		} elseif ( version_compare( $installed_plugins[ $item['file_path'] ]['Version'], $item['version'], '<' ) ) {
			$disable_class = '';
			// We need to display the 'Update' hover link.
			$url = wp_nonce_url(
				add_query_arg(
					array(
						'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
						'plugin'        => urlencode( $item['slug'] ),
						'tgmpa-update'  => 'update-plugin',
						'version'       => urlencode( $item['version'] ),
						'return_url'    => 'fusion_plugins',
					),
					TGM_Plugin_Activation::$instance->get_tgmpa_url()
				),
				'tgmpa-update',
				'tgmpa-nonce'
			);
			if ( ( 'LayerSlider' == $item['slug'] || 'revslider' == $item['slug'] ) && ! Avada()->registration->is_registered() ) {
				$disable_class = ' disabled avada-no-token';
			}
			$actions = array(
				'update' => '<a href="' . $url . '" class="button button-primary' . $disable_class . '" title="' . sprintf( esc_attr__( 'Update %s', 'Avada' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Update', 'Avada' ) . '</a>',
			);
		} elseif ( is_plugin_active( $item['file_path'] ) ) {
			$url = esc_url( add_query_arg(
				array(
					'plugin'                 => urlencode( $item['slug'] ),
					'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
					'avada-deactivate'       => 'deactivate-plugin',
					'avada-deactivate-nonce' => wp_create_nonce( 'avada-deactivate' ),
				),
				admin_url( 'admin.php?page=avada-plugins' )
			) );
			$actions = array(
				'deactivate' => '<a href="' . $url . '" class="button button-primary" title="' . sprintf( esc_attr__( 'Deactivate %s', 'Avada' ), $item['sanitized_plugin'] ) . '">' . esc_attr__( 'Deactivate', 'Avada' ) . '</a>',
			);
		}

		return $actions;
	}

	/**
	 * Removes install link for Fusion Builder, if Fusion Core was not updated to 3.0
	 *
	 * @since 5.0.0
	 * @param array  $action_links The action link(s) for a required plugin.
	 * @param string $item_slug The slug of a required plugin.
	 * @param array  $item Data belonging to a required plugin.
	 * @param string $view_context Specifying the kind of action (install, activate, update).
	 * @return array The action link(s) for a required plugin.
	 */
	public function edit_tgmpa_action_links( $action_links, $item_slug, $item, $view_context ) {
		if ( 'fusion-builder' === $item_slug && 'install' === $view_context ) {
			$fusion_core_version = TGM_Plugin_Activation::$instance->get_installed_version( TGM_Plugin_Activation::$instance->plugins['fusion-core']['slug'] );

			if ( version_compare( $fusion_core_version, '3.0', '<' ) ) {
				$action_links['install'] = '<span class="avada-not-installable" style="color:#555555;">' . esc_attr__( 'Fusion Builder will be installable, once Fusion Core plugin is updated.', 'Avada' ) . '<span class="screen-reader-text">' . esc_attr__( 'Fusion Builder', 'Avada' ) . '</span></span>';
			}
		}

		return $action_links;
	}

	/**
	 * Removes install link for Fusion Builder, if Fusion Core was not updated to 3.0
	 *
	 * @since 5.0.0
	 * @param array $action_links The action link(s) for a required plugin.
	 * @return array The action link(s) for a required plugin.
	 */
	public function edit_tgmpa_notice_action_links( $action_links ) {
		$fusion_core_version = TGM_Plugin_Activation::$instance->get_installed_version( TGM_Plugin_Activation::$instance->plugins['fusion-core']['slug'] );
		$current_screen = get_current_screen();

		if ( 'avada_page_avada-plugins' == $current_screen->id ) {
			$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="#avada-install-plugins">' . esc_attr__( 'Manage Plugins Below', 'Avada' ) . '</a>';
			$action_links  = array( 'install' => $link_template );
		} elseif ( version_compare( $fusion_core_version, '3.0', '<' ) ) {
			$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="' . esc_url( self_admin_url( 'admin.php?page=avada-plugins' ) ) . '#avada-install-plugins">' . esc_attr__( 'Go Manage Plugins', 'Avada' ) . '</a>';
			$action_links  = array( 'install' => $link_template );
		}

		return $action_links;
	}

	/**
	 * Initialize the permalink settings.
	 *
	 * @since 3.9.2
	 */
	public function init_permalink_settings() {
		add_settings_field(
			'avada_portfolio_category_slug',                        // ID.
			esc_attr__( 'Avada portfolio category base', 'Avada' ), // Setting title.
			array( $this, 'permalink_slug_input' ),                 // Display callback.
			'permalink',                                            // Settings page.
			'optional',                                             // Settings section.
			array( 'taxonomy' => 'portfolio_category' )             // Args.
		);

		add_settings_field(
			'avada_portfolio_skills_slug',
			esc_attr__( 'Avada portfolio skill base', 'Avada' ),
			array( $this, 'permalink_slug_input' ),
			'permalink',
			'optional',
			array( 'taxonomy' => 'portfolio_skills' )
		);

		add_settings_field(
			'avada_portfolio_tag_slug',
			esc_attr__( 'Avada portfolio tag base', 'Avada' ),
			array( $this, 'permalink_slug_input' ),
			'permalink',
			'optional',
			array( 'taxonomy' => 'portfolio_tags' )
		);
	}

	/**
	 * Show a slug input box.
	 *
	 * @since 3.9.2
	 * @access  public
	 * @param  array $args The argument.
	 */
	public function permalink_slug_input( $args ) {
		$permalinks     = get_option( 'avada_permalinks' );
		$permalink_base = $args['taxonomy'] . '_base';
		$input_name     = 'avada_' . $args['taxonomy'] . '_slug';
		$placeholder    = $args['taxonomy'];
		?>
		<input name="<?php echo $input_name; ?>" type="text" class="regular-text code" value="<?php echo ( isset( $permalinks[ $permalink_base ] ) ) ? esc_attr( $permalinks[ $permalink_base ] ) : ''; ?>" placeholder="<?php echo esc_attr( $placeholder ) ?>" />
		<?php
	}

	/**
	 * Save the permalink settings.
	 *
	 * @since 3.9.2
	 */
	public function save_permalink_settings() {

		if ( ! is_admin() ) {
			return;
		}

		if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['category_base'] ) ) {
			// Cat and tag bases.
			$portfolio_category_slug = ( isset( $_POST['avada_portfolio_category_slug'] ) ) ? sanitize_text_field( $_POST['avada_portfolio_category_slug'] ) : '';
			$portfolio_skills_slug   = ( isset( $_POST['avada_portfolio_skills_slug'] ) ) ? sanitize_text_field( $_POST['avada_portfolio_skills_slug'] ) : '';
			$portfolio_tags_slug     = ( isset( $_POST['avada_portfolio_tags_slug'] ) ) ? sanitize_text_field( $_POST['avada_portfolio_tags_slug'] ) : '';

			$permalinks = get_option( 'avada_permalinks' );

			if ( ! $permalinks ) {
				$permalinks = array();
			}

			$permalinks['portfolio_category_base']	= untrailingslashit( $portfolio_category_slug );
			$permalinks['portfolio_skills_base']	= untrailingslashit( $portfolio_skills_slug );
			$permalinks['portfolio_tags_base']		= untrailingslashit( $portfolio_tags_slug );

			update_option( 'avada_permalinks', $permalinks );
		}
	}

	/**
	 * Sets the theme version.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function set_theme_version() {
		$theme_version = Avada()->get_normalized_theme_version();

		$this->theme_version = $theme_version;
	}

	/**
	 * Sets the WP_Object for the theme.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function set_theme_object() {
		$theme_object = wp_get_theme();
		if ( $theme_object->parent_theme ) {
			$template_dir = basename( Avada::$template_dir_path );
			$theme_object = wp_get_theme( $template_dir );
		}

		$this->theme_object = $theme_object;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
