<?php
/**
 * Extra files & functions are hooked here.
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Avada
 * @subpackage Avada
 * @since 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Include the main Avada class.
 */
include_once get_template_directory() . '/includes/class-avada.php';

/**
 * Define basic properties in the Avada class.
 */
Avada::$template_dir_path   = get_template_directory();
Avada::$template_dir_url    = get_template_directory_uri();
Avada::$stylesheet_dir_path = get_stylesheet_directory();
Avada::$stylesheet_dir_url  = get_stylesheet_directory_uri();

/**
 * Include the autoloader.
 */
include_once Avada::$template_dir_path . '/includes/class-avada-autoload.php';

/**
 * Instantiate the autoloader.
 */
new Avada_Autoload();

/**
 * Must-use Plugins.
 */
include_once Avada::$template_dir_path . '/includes/plugins/multiple_sidebars.php';
require_once Avada::$template_dir_path . '/includes/plugins/post-link-plus.php';
require_once Avada::$template_dir_path . '/includes/plugins/multiple-featured-images/multiple-featured-images.php';

/**
 * If Fusion-Builder is installed, add the options.
 */
if ( ( defined( 'FUSION_BUILDER_PLUGIN_DIR' ) && is_admin() ) || ! is_admin() ) {
	new Fusion_Builder_Redux_Options();
}

/**
 * Load Fusion functions for later usage
 */
require_once( Avada::$template_dir_path . '/includes/fusion-functions.php' );
require_once( Avada::$template_dir_path . '/includes/ajax-functions.php' );

/**
 * Include the main Avada class.
 */
require_once( Avada::$template_dir_path . '/includes/class-avada.php' );

/**
 * Make sure the Avada_Multilingual class has been instantiated.
 */
$avada_multilingual = new Avada_Multilingual();

/**
 * Instantiates the Avada_Options class.
 */
function avada_init_options() {
	Avada::$options = Avada_Options::get_instance();
}

// When in the dashboard delay the instantiation of the Avada_Options class.
// This helps put all sidebars (both default & custom) in the Theme Options panel.
if ( is_admin() ) {
	// Has to be widgets_init hook, as it is called before init with priority 1.
	add_action( 'init', 'avada_init_options', 1 );
} else {
	avada_init_options();
}

/**
 * Instantiate Avada_Upgrade classes.
 * Don't instantiate the class when DOING_AJAX to avoid issues
 * with the WP HeartBeat API.
 */
if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
	// Only instantiate the Upgrade class when in the dashboard.
	// We don't want the updates to run when in the frontend.
	Avada_Upgrade::get_instance();
}

// @codingStandardsIgnoreStart
/**
 * Instantiates the Avada class.
 * Make sure the class is properly set-up.
 * The Avada class is a singleton
 * so we can directly access the one true Avada object using this function.
 *
 * @return object Avada
 */
function Avada() {
	return Avada::get_instance();
}
// @codingStandardsIgnoreEnd

/**
 * Instantiate the Avada_Admin class.
 * We need this both in the front & back to make sure the admin menu is properly added.
 */
new Avada_Admin();

/**
 * Instantiate the Avada_Multiple_Featured_Images object.
 */
new Avada_Multiple_Featured_Images();

/**
 * Instantiate Avada_Sidebars.
 */
new Avada_Sidebars();

/**
 * Instantiate Avada_Portfolio.
 * This is only needed on the frontend, doesn't do anything for the dashboard.
 */
if ( ! is_admin() ) {
	new Avada_Portfolio();
}

/**
 * Instantiate Avada_Social_Icons.
 * This is only needed on the frontend, doesn't do anything for the dashboard.
 */
global $social_icons;
if ( ! is_admin() ) {
	$social_icons = new Avada_Social_Icons();
}

/**
 * Instantiate Avada_fonts.
 * Only do this while in the dashboard, not needed on the frontend.
 */
if ( is_admin() ) {
	new Avada_Fonts();
}

/**
 * Instantiate Avada_Scripts.
 */
new Avada_Scripts();

/**
 * Instantiate Avada_Layout_bbPress.
 * We only need to do this for the frontend, when bbPress is installed.
 */
if ( ! is_admin() && class_exists( 'bbPress' ) ) {
	new Avada_Layout_bbPress();
}

/**
 * Instantiate Avada_EventsCalendar
 * We only need to do this on the frontend if Events Calendar is installed
 */
if ( ! is_admin() && class_exists( 'Tribe__Events__Main' ) ) {
	new Avada_EventsCalendar();
}

/**
 * Conditionally Instantiate Avada_AvadaRedux.
 */
$load_avadaredux = false;
$load_avadaredux = ( is_admin() && isset( $_GET['page'] ) && 'avada_options' === $_GET['page'] ) ? true : $load_avadaredux;
$load_avadaredux = ( isset( $_SERVER['HTTP_REFERER'] ) && false !== strpos( $_SERVER['HTTP_REFERER'], 'avada_options' ) ) ? true : $load_avadaredux;

if ( $load_avadaredux ) {
	include_once Avada::$template_dir_path . '/includes/avadaredux/avadaredux-framework/avadaredux-framework.php';
	new Avada_AvadaRedux();
} elseif ( ! is_admin() ) {
	new Avada_Google_Fonts();
}

/*
 * Include the TGM configuration
 */
require_once( Avada::$template_dir_path . '/includes/class-tgm-plugin-activation.php' );
require_once( Avada::$template_dir_path . '/includes/avada-tgm.php' );

/*
 * Include deprecated functions
 */
require_once( Avada::$template_dir_path . '/includes/deprecated.php' );

/**
 * Metaboxes
 */
if ( is_admin() ) {
	include_once Avada::$template_dir_path . '/includes/metaboxes/metaboxes.php' ;
}

/**
 * Instantiate the mega menu framework
 */
$mega_menu_framework = new Avada_Megamenu_Framework();

/**
 * Custom Functions
 */
get_template_part( 'includes/custom_functions' );
require_once( 'includes/avada-functions.php' );

/**
 * WPML Config
 */
if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	include_once Avada::$template_dir_path . '/includes/plugins/wpml.php';
}

/**
 * Include the importer
 */
if ( is_admin() ) {
	include Avada::$template_dir_path . '/includes/plugins/importer/importer.php';
}

/**
 * Woo Config
 */
if ( class_exists( 'WooCommerce' ) ) {
	include_once( Avada::$template_dir_path . '/includes/woo-config.php' );
	global $avada_woocommerce;
	$avada_woocommerce = new Avada_Woocommerce();
}

/**
 * The dynamic CSS.
 */
require_once Avada::$template_dir_path . '/includes/dynamic_css.php';
require_once Avada::$template_dir_path . '/includes/dynamic_css_helpers.php';

// Load dynamic css for plugins.
foreach ( glob( Avada::$template_dir_path . '/includes/typography/*.php', GLOB_NOSORT ) as $filename ) {
	require_once $filename;
}

/**
 * Avada Header Template functions.
 */
get_template_part( 'templates/header' );

/**
 * Set the $content_width global.
 */
global $content_width;
if ( ! is_admin() ) {
	if ( ! isset( $content_width ) || empty( $content_width ) ) {
		$content_width = (int) Avada()->layout->get_content_width();
	}
}

/**
 * Font-Awesome icon handler.
 * Adds compatibility with order versions of FA icon names.
 *
 * @param  string $icon The icon-name.
 * @return  string
 */
function avada_font_awesome_name_handler( $icon ) {
	$old_icons = Avada_Data::old_icons();
	$fa_icon   = ( 'fa-' !== substr( $icon, 0, 3 ) ) ? 'fa-' . $icon : $icon;
	if ( 'icon-' === substr( $icon, 0, 5 ) || 'fa=' !== substr( $icon, 0, 3 ) ) {
		// Replace old prefix with new one.
		$icon    = str_replace( 'icon-', 'fa-', $icon );
		$fa_icon = ( 'fa-' !== substr( $icon, 0, 3 ) ) ? 'fa-' . $icon : $icon;
		if ( array_key_exists( str_replace( 'fa-', '', $icon ), $old_icons ) ) {
			$fa_icon = 'fa-' . $old_icons[ str_replace( 'fa-', '', $icon ) ];
		}
	}
	return $fa_icon;
}

/**
 * Adds a counter span element to links.
 *
 * @param string $links The links HTML string.
 */
function avada_cat_count_span( $links ) {
	preg_match_all( '#\((.*?)\)#', $links, $matches );
	if ( ! empty( $matches ) ) {
		$i = 0;
		foreach ( $matches[0] as $val ) {
			$links = str_replace( '</a> ' . $val, ' ' . $val . '</a>', $links );
			$links = str_replace( '</a>&nbsp;' . $val, ' ' . $val . '</a>', $links );
			$i++;
		}
	}
	return $links;
}
add_filter( 'get_archives_link', 'avada_cat_count_span' );
add_filter( 'wp_list_categories', 'avada_cat_count_span' );

/**
 * Modify admin CSS
 */
function avada_custom_admin_styles() {
	echo '<style type="text/css">.widget input { border-color: #DFDFDF !important; }</style>';
}
add_action( 'admin_head', 'avada_custom_admin_styles' );

/**
 * Add admin messages.
 */
function avada_admin_notice() {
	?>
	<?php if ( isset( $_GET['imported'] ) && 'success' === $_GET['imported'] ) : ?>
		<div id="setting-error-settings_updated" class="updated settings-error">
			<p><?php esc_attr_e( 'Sucessfully imported demo data!', 'Avada' ); ?></p>
		</div>
	<?php endif;
}
add_action( 'admin_notices', 'avada_admin_notice' );

/**
 * Ignore nag messages.
 */
function avada_nag_ignore() {
	global $current_user;
	$user_id = $current_user->ID;

	// If user clicks to ignore the notice, add that to their user meta.
	if ( isset( $_GET['fusion_richedit_nag_ignore'] ) && '0' == $_GET['fusion_richedit_nag_ignore'] ) {
		add_user_meta( $user_id, 'fusion_richedit_nag_ignore', 'true', true );
	}

	// If user clicks to ignore the notice, add that to their user meta.
	if ( isset( $_GET['avada_uber_nag_ignore'] ) && '0' == $_GET['avada_uber_nag_ignore'] ) {
		update_option( 'avada_ubermenu_notice', true );
		update_option( 'avada_ubermenu_notice_hidden', true );
		$referer = esc_url( $_SERVER['HTTP_REFERER'] );
		wp_redirect( $referer );
	}
}
add_action( 'admin_init', 'avada_nag_ignore' );

if ( function_exists( 'rev_slider_shortcode' ) ) {
	add_action( 'admin_init', 'avada_disable_revslider_notice' );
	add_action( 'admin_init', 'avada_revslider_styles' );
}

/**
 * Disable revslider notice.
 */
function avada_disable_revslider_notice() {
	update_option( 'revslider-valid-notice', 'false' );
}

/**
 * Add revslider styles.
 */
function avada_revslider_styles() {
	// @codingStandardsIgnoreStart
	global $wpdb, $revSliderVersion;
	$plugin_version = $revSliderVersion;
	// @codingStandardsIgnoreEnd

	$table_name = $wpdb->prefix . 'revslider_css';
	if ( $table_name == $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) && function_exists( 'rev_slider_shortcode' ) && get_option( 'avada_revslider_version' ) != $plugin_version ) {

		$old_styles = array( '.avada_huge_white_text', '.avada_huge_black_text', '.avada_big_black_text', '.avada_big_white_text', '.avada_big_black_text_center', '.avada_med_green_text', '.avada_small_gray_text', '.avada_small_white_text', '.avada_block_black', '.avada_block_green', '.avada_block_white', '.avada_block_white_trans' );

		foreach ( $old_styles as $handle ) {
			$wpdb->delete( $table_name, array( 'handle' => '.tp-caption' . $handle ) );
		}

		$styles = array(
			'.tp-caption.avada_huge_white_text'       => '{"position":"absolute","color":"#ffffff","font-size":"130px","line-height":"45px","font-family":"museoslab500regular"}',
			'.tp-caption.avada_huge_black_text'       => '{"position":"absolute","color":"#000000","font-size":"130px","line-height":"45px","font-family":"museoslab500regular"}',
			'.tp-caption.avada_big_black_text'        => '{"position":"absolute","color":"#333333","font-size":"42px","line-height":"45px","font-family":"museoslab500regular"}',
			'.tp-caption.avada_big_white_text'        => '{"position":"absolute","color":"#fff","font-size":"42px","line-height":"45px","font-family":"museoslab500regular"}',
			'.tp-caption.avada_big_black_text_center' => '{"position":"absolute","color":"#333333","font-size":"38px","line-height":"45px","font-family":"museoslab500regular","text-align":"center"}',
			'.tp-caption.avada_med_green_text'        => '{"position":"absolute","color":"#A0CE4E","font-size":"24px","line-height":"24px","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
			'.tp-caption.avada_small_gray_text'       => '{"position":"absolute","color":"#747474","font-size":"13px","line-height":"20px","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
			'.tp-caption.avada_small_white_text'      => '{"position":"absolute","color":"#fff","font-size":"13px","line-height":"20px","font-family":"PTSansRegular, Arial, Helvetica, sans-serif","text-shadow":"0px 2px 5px rgba(0, 0, 0, 0.5)","font-weight":"700"}',
			'.tp-caption.avada_block_black'           => '{"position":"absolute","color":"#A0CE4E","text-shadow":"none","font-size":"22px","line-height":"34px","padding":["1px", "10px", "0px", "10px"],"margin":"0px","border-width":"0px","border-style":"none","background-color":"#000","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
			'.tp-caption.avada_block_green'           => '{"position":"absolute","color":"#000","text-shadow":"none","font-size":"22px","line-height":"34px","padding":["1px", "10px", "0px", "10px"],"margin":"0px","border-width":"0px","border-style":"none","background-color":"#A0CE4E","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
			'.tp-caption.avada_block_white'           => '{"position":"absolute","color":"#fff","text-shadow":"none","font-size":"22px","line-height":"34px","padding":["1px", "10px", "0px", "10px"],"margin":"0px","border-width":"0px","border-style":"none","background-color":"#000","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
			'.tp-caption.avada_block_white_trans'     => '{"position":"absolute","color":"#fff","text-shadow":"none","font-size":"22px","line-height":"34px","padding":["1px", "10px", "0px", "10px"],"margin":"0px","border-width":"0px","border-style":"none","background-color":"rgba(0, 0, 0, 0.6)","font-family":"PTSansRegular, Arial, Helvetica, sans-serif"}',
		);

		foreach ( $styles as $handle => $params ) {
			$test = $wpdb->get_var( $wpdb->prepare( 'SELECT handle FROM ' . $table_name . ' WHERE handle = %s', $handle ) );

			if ( $test != $handle ) {
				$wpdb->replace(
					$table_name,
					array(
						'handle' => $handle,
						'params' => $params,
						'settings' => '{"hover":"false","type":"text","version":"custom","translated":"5"}',
					),
					array(
						'%s',
						'%s',
						'%s',
					)
				);
			}
		}
		update_option( 'avada_revslider_version', $plugin_version );
	}
}

/**
 * Woo Products Shortcode Recode.
 *
 * @param  array $atts The attributes.
 * @return string
 */
function avada_woo_product( $atts ) {
	global $woocommerce_loop;

	if ( empty( $atts ) ) {
		return;
	}

	$args = array(
		'post_type'       => 'product',
		'posts_per_page'  => 1,
		'no_found_rows'   => 1,
		'post_status'     => 'publish',
		'columns'         => 1,
		'meta_query'      => array(
			array(
				'key'     => '_visibility',
				'value'   => array( 'catalog', 'visible' ),
				'compare' => 'IN',
			),
		),
	);

	if ( isset( $atts['sku'] ) ) {
		$args['meta_query'][] = array(
			'key'     => '_sku',
			'value'   => $atts['sku'],
			'compare' => '=',
		);
	}

	if ( isset( $atts['id'] ) ) {
		$args['p'] = $atts['id'];
	}

	ob_start();

	if ( isset( $args['columns'] ) && 1 < $args['columns'] ) {
		$woocommerce_loop['columns'] = $args['columns'];
	}

	$products = avada_cached_query( $args );

	if ( $products->have_posts() ) : ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // End of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	<?php endif;

	wp_reset_postdata();

	return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}

add_action( 'wp_loaded', 'remove_product_shortcode' );
/**
 * Changes the default WooCommerce product shortcode
 * with a customized Avada version.
 */
function remove_product_shortcode() {
	if ( class_exists( 'WooCommerce' ) ) {
		// First remove the shortcode.
		remove_shortcode( 'product' );
		// Then recode it.
		add_shortcode( 'product', 'avada_woo_product' );
	}
}


// Support email login on my account dropdown.
if ( isset( $_POST['fusion_woo_login_box'] ) && 'true' == $_POST['fusion_woo_login_box'] ) {
	add_filter( 'authenticate', 'avada_email_login_auth', 10, 3 );
}

/**
 * Allow loging-in via email.
 *
 * @param  object $user     The user.
 * @param  string $username The username.
 * @param  string $password The password.
 */
function avada_email_login_auth( $user, $username, $password ) {
	if ( is_a( $user, 'WP_User' ) ) {
		return $user;
	}

	if ( ! empty( $username ) ) {
		$username = str_replace( '&', '&amp;', stripslashes( $username ) );
		$user = get_user_by( 'email', $username );
		if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status ) {
			$username = $user->user_login;
		}
	}

	return wp_authenticate_username_password( null, $username, $password );
}

// No redirect on woo my account dropdown login when it fails.
if ( isset( $_POST['fusion_woo_login_box'] ) && 'true' == $_POST['fusion_woo_login_box'] ) {
	add_action( 'init', 'avada_load_login_redirect_support' );
}

/**
 * Tweaks the login redirect for WooCommerce.
 */
function avada_load_login_redirect_support() {
	if ( class_exists( 'WooCommerce' ) ) {

		// When on the my account page, do nothing.
		if ( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-login' ) ) {
			return;
		}

		add_action( 'login_redirect', 'avada_login_fail', 10, 3 );
	}
}

/**
 * Avada Login Fail Test.
 *
 * @param  string $url     The URL.
 * @param  string $raw_url The Raw URL.
 * @param  string $user    User.
 * @return string
 */
function avada_login_fail( $url = '', $raw_url = '', $user = '' ) {
	if ( ! is_account_page() ) {

		if ( isset( $_SERVER ) && isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] ) {
			$referer_array = wp_parse_url( $_SERVER['HTTP_REFERER'] );
			$referer = '//' . $referer_array['host'] . $referer_array['path'];

			// If there's a valid referrer, and it's not the default log-in screen.
			if ( ! empty( $referer ) && ! strstr( $referer, 'wp-login' ) && ! strstr( $referer, 'wp-admin' ) ) {
				if ( is_wp_error( $user ) ) {
					// Let's append some information (login=failed) to the URL for the theme to use.
					wp_redirect( add_query_arg( array( 'login' => 'failed' ), $referer ) );
				} else {
					wp_redirect( $referer );
				}
				exit;
			} else {
				return $url;
			}
		} else {
			return $url;
		}
	}
}

/**
 * Show a shop page description on product archives
 */
function woocommerce_product_archive_description() {
	if ( is_post_type_archive( 'product' ) && 0 == get_query_var( 'paged' ) ) {
		$shop_page   = get_post( woocommerce_get_page_id( 'shop' ) );
		if ( $shop_page ) {
			$description = apply_filters( 'the_content', $shop_page->post_content );
			if ( $description ) {
				echo '<div class="post-content">' . $description . '</div>';
			}
		}
	}
}

/**
 * Layerslider API
 */
function avada_layerslider_ready() {
	if ( class_exists( 'LS_Sources' ) ) {
		LS_Sources::addSkins( Avada::$template_dir_path . '/includes/ls-skins' );
	}
	if ( defined( 'LS_PLUGIN_BASE' ) ) {
		remove_action( 'after_plugin_row_' . LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice', 10, 3 );
	}
}
add_action( 'layerslider_ready', 'avada_layerslider_ready' );

/**
 * Custom Excerpt function for Sermon Manager.
 *
 * @param  bool $archive True if an archive, else false.
 */
function avada_get_sermon_content( $archive = false ) {
	global $post;

	$sermon_content = '';

	// Get the date.
	ob_start();
	wpfc_sermon_date( get_option( 'date_format' ), '<span class="sermon_date">', '</span> ' );
	$date = ob_get_clean();

	// Print the date.
	ob_start(); ?>
	<p>
		<?php printf( esc_attr__( 'Date: %s', 'Avada' ), $date ); ?>
		<?php echo the_terms( $post->ID, 'wpfc_service_type', ' <span class="service_type">(', ' ', ')</span>' ); ?>
	</p>
	<?php $sermon_content .= ob_get_clean(); ?>

	<?php ob_start(); ?>
	<p>
		<?php wpfc_sermon_meta( 'bible_passage', '<span class="bible_passage">' . esc_attr__( 'Bible Text: ', 'Avada' ), '</span> | ' ); ?>
		<?php echo the_terms( $post->ID, 'wpfc_preacher',  '<span class="preacher_name">', ', ', '</span>' ); ?>
		<?php echo the_terms( $post->ID, 'wpfc_sermon_series', '<p><span class="sermon_series">' . esc_attr__( 'Series: ', 'Avada' ), ' ', '</span></p>' ); ?>
	</p>

	<?php if ( $archive ) : ?>
		<?php $sermonoptions = get_option( 'wpfc_options' ); ?>
		<?php if ( isset( $sermonoptions['archive_player'] ) ) : ?>
			<div class="wpfc_sermon cf">
				<?php wpfc_sermon_files(); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! $archive ) : ?>
		<?php wpfc_sermon_files(); ?>
		<?php wpfc_sermon_description(); ?>
		<?php wpfc_sermon_attachments(); ?>
		<?php echo the_terms( $post->ID, 'wpfc_sermon_topics', '<p class="sermon_topics">' . esc_attr__( 'Topics: ', 'sermon-manager' ), ',', '', '</p>' ); ?>
	<?php endif; ?>

	<?php $sermon_content .= ob_get_clean(); ?>

	<?php if ( $archive ) : ?>
		<?php ob_start(); ?>
		<?php wpfc_sermon_description(); ?>
		<?php $description = ob_get_clean(); ?>
		<?php $excerpt_length = fusion_get_theme_option( 'excerpt_length_blog' ); ?>

		<?php $sermon_content .= Avada()->blog->get_content_stripped_and_excerpted( $excerpt_length, $description ); ?>
	<?php endif;

	return $sermon_content;
}

/**
 * Istantiate the auto-patcher tool.
 */
Avada_Patcher::get_instance();

/**
 * During updates sometimes there are changes that will break a site.
 * We're adding a maintenance page to make sure users don't see a broken site.
 * As soon as the update is complete the site automatically returns to normal mode.
 */
$maintenance   = false;
$users_message = esc_html__( 'Our site is currently undergoing scheduled maintenance. Please try again in a moment.', 'Avada' );
// Check if we're currently update Avada.
if ( Avada::$is_updating ) {
	$maintenance   = true;
	$admin_message = esc_html__( 'Currently updating the Avada Theme. Your site will be accessible once the update finishes', 'Avada' );
}
// Make sure that if the fusion-core plugin is activated,
// it's at least version 2.0.
if ( class_exists( 'FusionCore_Plugin' ) ) {
	$fc_version = FusionCore_Plugin::VERSION;
	if ( version_compare( $fc_version, '2.0', '<' ) ) {
		$maintenance   = true;
		$admin_message = sprintf( __( 'The Fusion-Core plugin needs to be updated before your site can exit maintenance mode. Please <a %s>follow this link</a> to update the plugin.', 'Avada' ), 'href="' . admin_url( 'themes.php?page=install-required-plugins' ) . '" style="color:#0088cc;font-weight:bold;"' );
	}
}
// If we're on maintenance mode, show the screen.
if ( $maintenance ) {
	new Avada_Maintenance( true, $users_message, $admin_message );
}

// Class for adding Avada specific data to builder.
// These only affect the dashboard so are not needed when in the front-end.
if ( Avada_Helper::is_post_admin_screen() && defined( 'FUSION_BUILDER_PLUGIN_DIR' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	Fusion_Builder_Filters::get_instance();
}

// Add Fusion Builder Demos support.
add_theme_support( 'fusion-builder-demos' );

if ( Avada_Helper::is_post_admin_screen() && defined( 'FUSION_BUILDER_PLUGIN_DIR' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || isset( $_POST['page_name'] ) ) ) {
	$demos = array(
		'agency',
		'app',
		'architecture',
		'cafe',
		'church',
		'classic',
		'fashion',
		'forum',
		'gym',
		'hosting',
		'hotel',
		'landing_product',
		'law',
		'lifestyle',
		'modern_shop',
		'photography',
		'travel',
		'resume',
		'technology',
		'wedding',
		'health',
	);

	// Load Fusion Builder demos.
	foreach ( $demos as $demo ) {
		$demo_obj = new Fusion_Builder_Demos_Importer( 'avada-' . $demo );
		$path     = $demo_obj->get_file_path();
		if ( $path ) {
			include $path;
		}
	}
}

// WIP, please ignore below.
if ( 'true' == get_option( 'avada_imported_demo' ) ) {
	flush_rewrite_rules();
	update_option( 'avada_imported_demo', 'false' );
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
