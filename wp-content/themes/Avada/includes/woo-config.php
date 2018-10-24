<?php
/**
 * Fusion Framework
 * WARNING: This file is part of the Fusion Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Fusion/Template
 * @author   ThemeFusion
 * @link     http://theme-fusion.com
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Don't duplicate me!
if ( ! class_exists( 'Avada_Woocommerce' ) ) {

	/**
	 * Class to apply woocommerce templates.
	 *
	 * @since 4.0.0
	 */
	class Avada_Woocommerce {

		/**
		 * Constructor.
		 */
		function __construct() {

			add_filter( 'woocommerce_show_page_title', array( $this, 'shop_title' ), 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			add_action( 'woocommerce_before_main_content', array( $this, 'before_container' ), 10 );
			add_action( 'woocommerce_after_main_content', array( $this, 'after_container' ), 10 );

			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_action( 'woocommerce_sidebar', array( $this, 'add_sidebar' ), 10 );

			/**
			 * Products Loop.
			 */
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'avada_woocommerce_add_product_wrappers_open' ), 30 );
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'product_title' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'avada_woocommerce_add_product_wrappers_close' ), 20 );

			add_action( 'avada_woocommerce_buttons_on_rollover',  array( $this, 'avada_woocommerce_template_loop_add_to_cart' ), 10 );
			add_action( 'avada_woocommerce_buttons_on_rollover',  array( $this, 'avada_woocommerce_rollover_buttons_linebreak' ), 15 );
			add_action( 'avada_woocommerce_buttons_on_rollover', array( $this, 'show_details_button' ), 20 );

			if ( 'clean' === Avada()->settings->get( 'woocommerce_product_box_design' ) ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
				remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'before_shop_item_buttons' ), 9 );

			} else {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'avada_show_product_loop_outofstock_flash' ), 10 );
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'avada_woocommerce_before_shop_loop_item_title_open' ), 5 );
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'avada_woocommerce_before_shop_loop_item_title_close' ), 20 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'before_shop_item_buttons' ), 5 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'avada_woocommerce_template_loop_add_to_cart' ), 10 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'show_details_button' ), 15 );
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'after_shop_item_buttons' ), 20 );
			}

			/**
			 * Single Product Page
			 */
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

			add_action( 'woocommerce_single_product_summary', array( $this, 'add_product_border' ), 19 );
			add_action( 'woocommerce_single_product_summary', array( $this, 'avada_woocommerce_template_single_title' ), 5 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary',  array( $this, 'avada_woocommerce_stock_html' ), 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );

			add_action( 'woocommerce_proceed_to_checkout', array( $this, 'avada_woocommerce_proceed_to_checkout' ), 10 );

			add_action( 'woocommerce_before_account_navigation', array( $this, 'avada_top_user_container' ), 10 );

			// Add welcome user bar to checkout page.
			add_action( 'woocommerce_before_checkout_form', array( $this, 'avada_top_user_container' ), 1 );

			// Filter the pagination.
			add_filter( 'woocommerce_pagination_args', array( $this, 'change_pagination' ) );

			/**
			 * Version sensitive hooks.
			 */
			if ( version_compare( self::get_wc_version(), '2.6', '>=' ) ) {
				// Account Page.
				add_action( 'woocommerce_account_dashboard', array( $this, 'avada_woocommerce_account_dashboard' ), 5 );
				add_action( 'woocommerce_before_account_orders', array( $this, 'avada_woocommerce_before_account_content_heading' ) );
				add_action( 'woocommerce_before_account_downloads', array( $this, 'avada_woocommerce_before_account_content_heading' ) );
				add_action( 'woocommerce_before_account_payment_methods', array( $this, 'avada_woocommerce_before_account_content_heading' ) );
				add_action( 'woocommerce_edit_account_form_start', array( $this, 'avada_woocommerce_before_account_content_heading' ) );
			} else {
				add_filter( 'woocommerce_template_path', array( $this, 'backwards_compatibility' ) );

				// Account Page.
				add_action( 'woocommerce_before_my_account', array( $this, 'avada_woocommerce_pre26_before_my_account' ) );
				add_action( 'woocommerce_after_my_account', array( $this, 'avada_woocommerce_pre26_after_my_account' ) );
			}

			// Fix for WPML.
			if ( class_exists( 'SitePress' ) ) {
				add_filter( 'woocommerce_add_to_cart_hash', array( $this, 'add_to_cart_hash' ), 5, 2 );
				add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'cart_loaded_from_session' ), 5 );
				add_action( 'woocommerce_set_cart_cookies', array( $this, 'set_cart_cookies' ) );
			}
		}

		/**
		 * Filter method to modify path to WooCommerce files if WooCommerce is a version less than 2.6.
		 *
		 * @since 3.7.2
		 * @param string $path The path.
		 * @return string      The relative path of WooCommerce template files within the theme.
		 */
		function backwards_compatibility( $path ) {
			return 'woocommerce/compatibility/2.5/';
		}

		/**
		 * Helper method to get the version of the currently installed WooCommerce.
		 *
		 * @since 3.7.2
		 * @return string woocommerce version number or null.
		 */
		private static function get_wc_version() {
			return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
		}

		/**
		 * Add content before the container.
		 *
		 * @access public
		 */
		public function before_container() {
			ob_start();
			Avada()->layout->add_class( 'content_class' );
			$content_class = ob_get_clean();

			ob_start();
			Avada()->layout->add_style( 'content_style' );
			$content_css = ob_get_clean();

			echo '<div class="woocommerce-container"><div id="content" ' . $content_class . ' ' . $content_css . '>';
		}

		/**
		 * Returns false.
		 *
		 * @access public
		 * @return false
		 */
		public function shop_title() {
			return false;
		}

		/**
		 * Closes 2 divs that were previously opened.
		 *
		 * @access public
		 */
		public function after_container() {
			echo '</div></div>';
		}

		/**
		 * Adds the sidebar.
		 *
		 * @access public
		 */
		function add_sidebar() {
			do_action( 'avada_after_content' );
		}

		/**
		 * Prints the out of stock warning.
		 *
		 * @access public
		 */
		public function avada_show_product_loop_outofstock_flash() {
			global $product; ?>
			<?php if ( ! $product->is_in_stock() ) : ?>
				<div class="fusion-out-of-stock">
					<div class="fusion-position-text">
						<?php esc_attr_e( 'Out of stock', 'Avada' ); ?>
					</div>
				</div>
			<?php endif;
		}

		/**
		 * Adds the link to permalink.
		 *
		 * @access public
		 */
		public function avada_woocommerce_before_shop_loop_item_title_open() {
			?>
			<a href="<?php the_permalink(); ?>" class="product-images">
			<?php
		}

		/**
		 * Closes the link.
		 *
		 * @access public
		 */
		public function avada_woocommerce_before_shop_loop_item_title_close() {
			?>
			</a>
			<?php
		}

		/**
		 * Content before the item buttons.
		 *
		 * @access public
		 */
		function before_shop_item_buttons() {
			global $post;
			$html = '';
			$buttons_container = '<div class="product-buttons"><div class="product-buttons-container clearfix">';
			if ( isset( $_SERVER['QUERY_STRING'] ) ) {
				parse_str( $_SERVER['QUERY_STRING'], $params );
				if ( isset( $params['product_view'] ) ) {
					$product_view = $params['product_view'];
					if ( 'list' == $product_view ) {
						$html = '<div class="product-excerpt product-' . $product_view . '">';
						$html .= '<div class="product-excerpt-container">';
						$html .= '<div class="post-content">';
						$html .= do_shortcode( $post->post_excerpt );
						$html .= '</div>';
						$html .= '</div>';
						$html .= $buttons_container;
						$html .= ' </div>';

						echo $html;
					} else {
						echo $buttons_container;
					}
				} else {
					echo $buttons_container;
				}
			} else {
				echo $buttons_container;
			}
		}

		/**
		 * Add to cart loop.
		 *
		 * @access public
		 * @param array $args The arguments.
		 */
		function avada_woocommerce_template_loop_add_to_cart( $args = array() ) {
			global $product;

			if ( $product && ( ( $product->is_purchasable() && $product->is_in_stock() ) || $product->is_type( 'external' ) ) ) {

				if ( version_compare( self::get_wc_version(), '2.5', '>=' ) ) {

					$defaults = array(
						'quantity' => 1,
						'class'    => implode( ' ', array_filter( array(
							'button',
							'product_type_' . $product->product_type,
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
						) ) ),
					);

					$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
				}

				wc_get_template( 'loop/add-to-cart.php' , $args );
			}
		}

		/**
		 * Adds the linebreak where needed.
		 *
		 * @access public
		 */
		public function avada_woocommerce_rollover_buttons_linebreak() {
			global $product; ?>
			<?php if ( $product && ( ( $product->is_purchasable() && $product->is_in_stock() ) || $product->is_type( 'external' ) ) ) : ?>
				<span class="fusion-rollover-linebreak">
					<?php echo ( 'clean' === Avada()->settings->get( 'woocommerce_product_box_design' ) ) ? '/' : ''; ?>
				</span>
			<?php endif;
		}

		/**
		 * Renders the "Details" button.
		 *
		 * @access public
		 */
		public function show_details_button() {
			global $product;

			$styles = '';
			if ( ( ! $product->is_purchasable() || ! $product->is_in_stock() ) && ! $product->is_type( 'external' ) ) {
				$styles = ' style="float:none;max-width:none;text-align:center;"';
			}
			echo '<a href="' . get_permalink() . '" class="show_details_button"' . $styles . '>' . esc_attr__( 'Details', 'Avada' ) . '</a>';
		}

		/**
		 * Closes 2 divs that were previously opened.
		 *
		 * @access public
		 */
		public function after_shop_item_buttons() {
			echo '</div></div>';
		}

		/**
		 * Adds a div that is used for borders.
		 *
		 * @access public
		 */
		function add_product_border() {
			echo '<div class="product-border"></div>';
		}

		/**
		 * Modifies the pagination.
		 *
		 * @access public
		 * @param array $options An array of our options.
		 * @return array         The options, modified.
		 */
		public function change_pagination( $options ) {
			$options['prev_text'] 	= '<span class="page-prev"></span><span class="page-text">' . __( 'Previous', 'Avada' ) . '</span>';
			$options['next_text'] 	= '<span class="page-text">' . __( 'Next', 'Avada' ) . '</span><span class="page-next"></span>';
			$options['type']		= 'plain';

			return $options;
		}

		/**
		 * Open wrapper divs.
		 *
		 * @access public
		 */
		public function avada_woocommerce_add_product_wrappers_open() {
			?>
			<div class="product-details">
				<div class="product-details-container">
			<?php
		}

		/**
		 * Renders the product title.
		 *
		 * @access public
		 */
		public function product_title() {
			?>
			<h3 class="product-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
			<div class="clearfix">
			<?php
		}

		/**
		 * Closes previously opened wrappers.
		 *
		 * @access public
		 */
		public function avada_woocommerce_add_product_wrappers_close() {
			?>
					</div>
					<div class="fusion-content-sep"></div>
				</div>
			</div>
			<?php
		}


		/**
		 * Single Product Page functions.
		 *
		 * @access public
		 */
		public function avada_woocommerce_template_single_title() {
			?>
			<h2 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h2>
			<?php
		}

		/**
		 * Add the availability HTML.
		 *
		 * @access public
		 */
		public function avada_woocommerce_stock_html() {
			global $product;

			// Availability.
			$availability      = $product->get_availability();
			$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
			?>
			<div class="avada-availability">
				<?php echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product ); ?>
			</div>
			<?php
		}

		/**
		 * Cart Page functions.
		 */
		public function avada_woocommerce_proceed_to_checkout() {
			?>
			<a href="" class="fusion-button button-default button-medium button default medium fusion-update-cart"><?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?></a>
			<?php
		}

		/**
		 * Account Page functions.
		 *
		 * @access public
		 */
		public function avada_top_user_container() {
			global $woocommerce, $current_user;
			?>
			<div class="avada-myaccount-user">
				<span class="username">
					<?php if ( $current_user->display_name ) { ?>
						<span class="hello">
							<?php printf(
								__( 'Hello %1$s (not %2$s? %3$s)', 'Avada' ),
								'<strong>' . esc_html( $current_user->display_name ) . '</strong></span><span class="not-user">',
								esc_html( $current_user->display_name ),
								'<a href="' . esc_url( wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ) ) . '">' . esc_attr__( 'Sign Out', 'Avada' ) . '</a>'
							); ?>
						</span>
					<?php } else { ?>
						<span class="hello"><?php esc_attr_e( 'Hello', 'Avada' ); ?></span>
					<?php } ?>

				</span>

				<?php if ( Avada()->settings->get( 'woo_acc_msg_1' ) ) : ?>
					<span class="msg"><?php echo wp_kses_post( Avada()->settings->get( 'woo_acc_msg_1' ) ); ?></span>
				<?php endif; ?>

				<?php if ( Avada()->settings->get( 'woo_acc_msg_2' ) ) : ?>
					<span class="msg"><?php echo wp_kses_post( Avada()->settings->get( 'woo_acc_msg_2' ) ); ?></span>
				<?php endif; ?>
				<span class="view-cart"><a href="<?php echo get_permalink( get_option( 'woocommerce_cart_page_id' ) ); ?>"><?php esc_attr_e( 'View Cart', 'Avada' ); ?></a></span>
			</div>
			<?php
		}

		/**
		 * The account dashboard.
		 *
		 * @access public
		 */
		public function avada_woocommerce_account_dashboard() {
			?>
			<style>
			.woocommerce-MyAccount-content{ display: -webkit-flex;display: -ms-flexbox;display:flex;-webkit-flex-flow: column wrap;flex-flow: column nowrap; }
			.avada-woocommerce-myaccount-heading{ -ms-flex-order: 0;-webkit-order: 0;order: 0; }
			.woocommerce-MyAccount-content > p, .woocommerce-MyAccount-content > div, .woocommerce-MyAccount-content > span{ -ms-flex-order: 1;-webkit-order: 1;order: 1; }
			.woocommerce-MyAccount-content > p:first-child { display: none; }
			</style>
			<?php
			self::avada_woocommerce_before_account_content_heading();
		}

		/**
		 * Content injected before the content heading.
		 *
		 * @access public
		 */
		public function avada_woocommerce_before_account_content_heading() {
			if ( is_account_page() ) {
				$account_items = wc_get_account_menu_items();
				$heading_content = __( 'Dashboard', 'Avada' );

				if ( is_wc_endpoint_url( 'orders' ) ) {
					$heading_content = $account_items['orders'];
				} elseif ( is_wc_endpoint_url( 'downloads' ) ) {
					$heading_content = $account_items['downloads'];
				} elseif ( is_wc_endpoint_url( 'payment-methods' ) ) {
					$heading_content = $account_items['payment-methods'];
				} elseif ( is_wc_endpoint_url( 'edit-account' ) ) {
					$heading_content = $account_items['edit-account'];
				}
				?>
				<h2 class="avada-woocommerce-myaccount-heading">
					<?php echo $heading_content; ?>
				</h2>
				<?php
			}
		}

		/**
		 * WooCommerce pre 2.6 compatibility functions.
		 *
		 * @access public
		 * @param string|int $order_count  The number of posts in the query.
		 * @param bool       $edit_address If we want to edit the address or not.
		 */
		public function avada_woocommerce_pre26_before_my_account( $order_count, $edit_address = false ) {
			global $woocommerce;
			$edit_address = is_wc_endpoint_url( 'edit-address' );

			$this->avada_top_user_container();
			?>

			<ul class="woocommerce-side-nav avada-myaccount-nav avada-woocommerce-pre26">
				<?php if ( $downloads = WC()->customer->get_downloadable_products() ) : ?>
					<li <?php echo ( ! $edit_address ) ? 'class="is-active"' : ''; ?>>
						<a class="downloads" href="#">
							<?php esc_attr_e( 'View Downloads', 'Avada' ); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php

				if ( function_exists( 'wc_get_order_types' ) && function_exists( 'wc_get_order_statuses' ) ) {
					$customer_orders = avada_cached_get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
						'numberposts' => $order_count,
						'meta_key'    => '_customer_user',
						'meta_value'  => get_current_user_id(),
						'post_type'   => wc_get_order_types( 'view-orders' ),
						'post_status' => array_keys( wc_get_order_statuses() ),
					) ) );
				} else {
					$customer_orders = avada_cached_get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
						'numberposts' => $order_count,
						'meta_key'    => '_customer_user',
						'meta_value'  => get_current_user_id(),
						'post_type'   => 'shop_order',
						'post_status' => 'publish',
					) ) );
				}

				if ( $customer_orders ) : ?>
					<li <?php echo ( ! $edit_address && ! WC()->customer->get_downloadable_products() ) ? 'class="is-active"' : ''; ?>>
						<a class="orders" href="#"><?php esc_attr_e( 'View Orders', 'Avada' ); ?></a>
					</li>
				<?php endif; ?>
				<li <?php echo ( $edit_address || ! WC()->customer->get_downloadable_products() && ! $customer_orders ) ? 'class="is-active"' : ''; ?>>
					<a class="address" href="#"><?php esc_attr_e( 'Change Address', 'Avada' ); ?></a>
				</li>
				<li>
					<a class="account" href="#"><?php esc_attr_e( 'Edit Account', 'Avada' ); ?></a>
				</li>
			</ul>

			<div class="woocommerce-content-box avada-myaccount-data">
			<?php
		}

		/**
		 * Edit account form.
		 *
		 * @access public
		 * @param array $args The arguments.
		 */
		function avada_woocommerce_pre26_after_my_account( $args ) {
			global $woocommerce, $wp;

			$user = wp_get_current_user();

			?>

			<h2 class="edit-account-heading"><?php _e( 'Edit Account', 'Avada' ); ?></h2>

			<form class="edit-account-form" action="" method="post">
				<p class="form-row form-row-first">
					<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
				</p>

				<p class="form-row form-row-last">
					<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
				</p>

				<p class="form-row form-row-wide">
					<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
				</p>

				<p class="form-row form-row-wide">
					<label for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_current" id="password_current" />
				</p>

				<p class="form-row form-row-wide">
					<label for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_1" id="password_1" />
				</p>

				<p class="form-row form-row-wide">
					<label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_2" id="password_2" />
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_edit_account_form' ); ?>

				<p><input type="submit" class="fusion-button button-default button-medium button default medium alignright"
						  name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>"/></p>

				<?php wp_nonce_field( 'save_account_details' ); ?>
				<input type="hidden" name="action" value="save_account_details"/>

				<div class="clearboth"></div>
			</form>

		</div>

		<?php

		}

		/**
		 * Dealing with mini-cart cache in internal browser storage.
		 * Response to action 'woocommerce_add_to_cart_hash', which overwrites the default WC cart hash and cookies.
		 *
		 * @access public
		 * @since 5.0.2
		 * @param string $hash Default WC hash.
		 * @param array  $cart WC variable holding contents of the cart without language information.
		 */
		public function add_to_cart_hash( $hash, $cart ) {

			$hash = $this->get_cart_hash( $cart );
			if ( ! headers_sent() ) {
				wc_setcookie( 'woocommerce_cart_hash', $hash );
			}
			return $hash;
		}

		/**
		 * Dealing with mini-cart cache in internal browser storage.
		 *
		 * @access private
		 * @since 5.0.2
		 * @param  array $cart WC variable holding contents of the cart without language information.
		 * @return string Cart hash with language information
		 */
		private function get_cart_hash( $cart ) {

			$lang = Avada_Multilingual::get_active_language();
			return md5( wp_json_encode( $cart ) . $lang );

		}

		/**
		 * Dealing with mini-cart cache in internal browser storage.
		 * Sets 'woocommerce_cart_hash' cookie.
		 *
		 * @access private
		 * @since 5.0.2
		 * @param array $cart wc variable holding contents of the cart without language information.
		 */
		private function set_cookies_cart_hash( $cart ) {

			$hash = $this->get_cart_hash( $cart );
			wc_setcookie( 'woocommerce_cart_hash', $hash );

		}

		/**
		 * Dealing with mini-cart cache in internal browser storage.
		 * Response to action 'woocommerce_cart_loaded_from_session'.
		 *
		 * @access public
		 * @since 5.0.2
		 * @param WC_Cart $wc_cart wc object without language information.
		 */
		public function cart_loaded_from_session( $wc_cart ) {

			if ( headers_sent() ) {
				return;
			}
			$cart = $wc_cart->get_cart_for_session();
			$this->set_cookies_cart_hash( $cart );

		}

		/**
		 * Dealing with mini-cart cache in internal browser storage.
		 * Response to action 'woocommerce_set_cart_cookies', which overwrites the default WC cart hash and cookies.
		 *
		 * @access public
		 * @since 5.0.2
		 * @param bool $set is true if cookies need to be set, otherwse they are unset in calling function.
		 */
		public function set_cart_cookies( $set ) {

			if ( $set ) {
				$wc = WC();
				$wc_cart = $wc->cart;
				$cart = $wc_cart->get_cart_for_session();
				$this->set_cookies_cart_hash( $cart );
			}
		}

	} // end Avada_Woocommerce() class.
}

add_filter( 'get_product_search_form', 'avada_product_search_form' );
/**
 * Changes the markup for the product search form.
 *
 * @param string $form The HTML of the form.
 * @return string      Modified HTML of the form.
 */
function avada_product_search_form( $form ) {
	$form = '<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
	<div>
	<input type="text" value="' . get_search_query() . '" name="s" class="s" placeholder="' . __( 'Search...', 'Avada' ) . '" />
	<input type="hidden" name="post_type" value="product" />
	</div>
	</form>';

	return $form;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

if ( Avada()->settings->get( 'woocommerce_avada_ordering' ) ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	add_action( 'woocommerce_before_shop_loop', 'avada_woocommerce_catalog_ordering', 30 );
}

/**
 * Modified the ordering of products.
 */
function avada_woocommerce_catalog_ordering() {

	$query_string = '';
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );
		$query_string = '?' . $_SERVER['QUERY_STRING'];
	}

	// Replace it with theme option.
	$per_page = 12;
	if ( Avada()->settings->get( 'woo_items' ) ) {
		$per_page = Avada()->settings->get( 'woo_items' );
	}

	$pob = ! empty( $params['product_orderby'] ) ? $params['product_orderby'] : get_option( 'woocommerce_default_catalog_orderby' );

	if ( ! empty( $params['product_order'] ) ) {
		$po = $params['product_order'];
	} else {
		switch ( $pob ) {
			case 'default':
			case 'menu_order':
				$po = 'asc';
				break;
			case 'date':
				$po = 'desc';
				break;
			case 'price':
				$po = 'asc';
				break;
			case 'price-desc':
				$po = 'desc';
				break;
			case 'popularity':
				$po = 'desc';
				break;
			case 'rating':
				$po = 'desc';
				break;
			case 'name':
				$po = 'asc';
				break;
		}
	}

	$order_string = __( 'Default Order', 'Avada' );

	switch ( $pob ) {
		case 'date':
			$order_string = __( 'Date', 'Avada' );
			break;
		case 'price':
		case 'price-desc':
			$order_string = __( 'Price', 'Avada' );
			break;
		case 'popularity':
			$order_string = __( 'Popularity', 'Avada' );
			break;
		case 'rating':
			$order_string = __( 'Rating', 'Avada' );
			break;
		case 'name':
			$order_string = __( 'Name', 'Avada' );
			break;
	}

	$pc = ! empty( $params['product_count'] ) ? $params['product_count'] : $per_page;
	?>

	<div class="catalog-ordering clearfix">
		<div class="orderby-order-container">
			<ul class="orderby order-dropdown">
				<li>
					<span class="current-li">
						<span class="current-li-content">
							<a aria-haspopup="true"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . $order_string . '</strong>' ); ?></a>
						</span>
					</span>
					<ul>
						<li class="<?php echo ( 'menu_order' == $pob ) ? 'current' : ''; ?>">
							<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'default' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Default Order', 'Avada' ) . '</strong>' ); ?></a>
						</li>
						<li class="<?php echo ( 'name' == $pob ) ? 'current' : ''; ?>">
							<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'name' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Name', 'Avada' ) . '</strong>' ); ?></a>
						</li>
						<li class="<?php echo ( 'price' == $pob || 'price-desc' == $pob ) ? 'current' : ''; ?>">
							<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'price' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Price', 'Avada' ) . '</strong>' ); ?></a>
						</li>
						<li class="<?php echo ( 'date' == $pob ) ? 'current' : ''; ?>">
							<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'date' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Date', 'Avada' ) . '</strong>' ); ?></a>
						</li>
						<li class="<?php echo ( 'popularity' == $pob ) ? 'current' : ''; ?>">
							<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'popularity' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Popularity', 'Avada' ) . '</strong>' ); ?></a>
						</li>
						<?php if ( 'no' !== get_option( 'woocommerce_enable_review_rating' ) ) : ?>
							<li class="<?php echo ( 'rating' == $pob ) ? 'current' : ''; ?>">
								<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_orderby', 'rating' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'Avada' ), '<strong>' . esc_attr__( 'Rating', 'Avada' ) . '</strong>' ); ?></a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>

			<ul class="order">
				<?php if ( isset( $po ) ) : ?>
					<?php if ( 'desc' == $po ) : ?>
						<li class="desc"><a aria-haspopup="true" href="<?php echo fusion_add_url_parameter( $query_string, 'product_order', 'asc' ); ?>"><i class="fusion-icon-arrow-down2 icomoon-up"></i></a></li>
					<?php else : ?>
						<li class="asc"><a aria-haspopup="true" href="<?php echo fusion_add_url_parameter( $query_string, 'product_order', 'desc' ); ?>"><i class="fusion-icon-arrow-down2"></i></a></li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
		</div>

		<ul class="sort-count order-dropdown">
			<li>
				<span class="current-li"><a aria-haspopup="true"><?php printf( __( 'Show <strong>%s Products</strong>', 'Avada' ), $per_page ); ?></a></span>
				<ul>
					<li class="<?php echo ( $pc == $per_page ) ? 'current' : ''; ?>">
						<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_count', $per_page ); ?>"><?php printf( __( 'Show <strong>%s Products</strong>', 'Avada' ), $per_page ); ?></a>
					</li>
					<li class="<?php echo ( $pc == $per_page * 2 ) ? 'current' : ''; ?>">
						<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_count', $per_page * 2 ); ?>"><?php printf( __( 'Show <strong>%s Products</strong>', 'Avada' ), $per_page * 2 ); ?></a>
					</li>
					<li class="<?php echo ( $pc == $per_page * 3 ) ? 'current' : ''; ?>">
						<a href="<?php echo fusion_add_url_parameter( $query_string, 'product_count', $per_page * 3 ); ?>"><?php printf( __( 'Show <strong>%s Products</strong>', 'Avada' ), $per_page * 3 ); ?></a>
					</li>
				</ul>
			</li>
		</ul>

		<?php $woocommerce_toggle_grid_list = Avada()->settings->get( 'woocommerce_toggle_grid_list' ); ?>
		<?php $product_view = 'grid'; ?>
		<?php if ( isset( $_SERVER['QUERY_STRING'] ) ) : ?>
			<?php parse_str( $_SERVER['QUERY_STRING'], $params ); ?>
			<?php if ( isset( $params['product_view'] ) ) : ?>
				<?php $product_view = $params['product_view']; ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $woocommerce_toggle_grid_list ) : ?>
			<ul class="fusion-grid-list-view">
				<li class="fusion-grid-view-li<?php echo ( 'grid' === $product_view ) ? ' active-view' : ''; ?>">
					<a class="fusion-grid-view" aria-haspopup="true" href="<?php echo fusion_add_url_parameter( $query_string, 'product_view', 'grid' ); ?>"><i class="fusion-icon-grid icomoon-grid"></i></a>
				</li>
				<li class="fusion-list-view-li<?php echo ( 'list' == $product_view ) ? ' active-view' : ''; ?>">
					<a class="fusion-list-view" aria-haspopup="true" href="<?php echo fusion_add_url_parameter( $query_string, 'product_view', 'list' ); ?>"><i class="fusion-icon-list icomoon-list"></i></a>
				</li>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}

if ( Avada()->settings->get( 'woocommerce_avada_ordering' ) ) {
	add_action( 'woocommerce_get_catalog_ordering_args', 'avada_woocommerce_get_catalog_ordering_args', 20 );
}

/**
 * Gets the catalogue ordering arguments.
 *
 * @param array $args The arguments.
 * @return array
 */
function avada_woocommerce_get_catalog_ordering_args( $args ) {
	global $woocommerce;
	$woo_default_catalog_orderby = get_option( 'woocommerce_default_catalog_orderby' );

	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );
	}

	$pob = ! empty( $params['product_orderby'] ) ? $params['product_orderby'] : get_option( 'woocommerce_default_catalog_orderby' );

	if ( empty( $params['product_order'] ) ) {
		if ( ! isset( $args['order'] ) ) {
			if ( 'date' == $woo_default_catalog_orderby || 'popularity' == $woo_default_catalog_orderby  ) {
				$po = 'desc';
			} else {
				$po = 'asc';
			}
		} else {
			$po = $args['order'];
		}
	} else {
		$po = $params['product_order'];
	}

	// Remove posts_clause filter, if default ordering is set to rating or popularity to make custom ordering work correctly.
	if ( 'default' != $pob ) {
		if ( 'rating' == $woo_default_catalog_orderby || 'popularity' == $woo_default_catalog_orderby ) {
			WC()->query->remove_ordering_args();
		}
	}

	$orderby  = 'date';

	$meta_key = '';

	switch ( $pob ) {
		case 'menu_order':
		case 'default':
			$orderby  = $args['orderby'];
			$order    = $args['order'];
			break;
		case 'date':
			$order    = 'desc';
			break;
		case 'price':
			$orderby  = 'meta_value_num';
			$order    = 'asc';
			$meta_key = '_price';
			break;
		case 'popularity':
			$orderby  = 'meta_value_num';
			$order    = 'desc';
			$meta_key = 'total_sales';
			break;
		case 'rating':
			$orderby  = 'meta_value_num';
			$order    = 'desc';
			$meta_key = 'average_rating';
			break;
		case 'name':
			$orderby  = 'title';
			$order    = 'asc';
			break;
	}

	switch ( strtolower( $po ) ) {
		case 'desc':
			$order = 'desc';
			break;
		case 'asc':
			$order = 'asc';
			break;
		default:
			$order = 'asc';
			break;
	}

	$args['orderby']  = $orderby;
	$args['order']    = $order;
	$args['meta_key'] = $meta_key;

	if ( 'popularity' == $pob ) {
		add_filter( 'posts_clauses', 'fusion_order_by_popularity_post_clauses' );
	}

	if ( 'rating' == $pob ) {
		$args['orderby']  = 'menu_order title';
		$args['order']    = 'desc' == $po ? 'desc' : 'asc';
		$args['order']    = strtoupper( $args['order'] );
		$args['meta_key'] = '';

		add_filter( 'posts_clauses', 'fusion_order_by_rating_post_clauses' );
	}
	return $args;
}

/**
 * The fusion_order_by_rating_post_clauses function.
 *
 * @since 5.0.0
 * @access public
 * @param array $args The arguments array.
 * @return array The altered arguments array.
 */
function fusion_order_by_popularity_post_clauses( $args ) {
	global $wpdb;
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );
	}
	$order = empty( $params['product_order'] ) ? 'DESC' : strtoupper( $params['product_order'] );
	$args['orderby'] = "$wpdb->postmeta.meta_value+0 {$order}, $wpdb->posts.post_date {$order}";
	return $args;
}

/**
 * The fusion_order_by_rating_post_clauses function.
 *
 * @access public
 * @param array $args The arguments array.
 * @return array The altered arguments array.
 */
function fusion_order_by_rating_post_clauses( $args ) {
	global $wpdb;

	$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";

	$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";

	$args['join'] .= "
	LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
	LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
	";

	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );
	}
	$order = ! empty( $params['product_order'] ) ? $params['product_order'] : 'desc';
	$order = strtoupper( $order );

	$args['orderby'] = "average_rating {$order}, $wpdb->posts.post_date {$order}";

	$args['groupby'] = "$wpdb->posts.ID";

	return $args;
}

add_filter( 'loop_shop_per_page', 'avada_loop_shop_per_page' );

/**
 * Determine how many products we want to show per page.
 *
 * @return int
 */
function avada_loop_shop_per_page() {

	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );
	}

	$per_page = 12;
	if ( Avada()->settings->get( 'woo_items' ) ) {
		$per_page = Avada()->settings->get( 'woo_items' );
	}

	return ( ! empty( $params['product_count'] ) ) ? $params['product_count'] : $per_page;
}

if ( 'clean' !== Avada()->settings->get( 'woocommerce_product_box_design' ) ) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'avada_woocommerce_thumbnail', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	/**
	 * Shows the product image.
	 */
	function avada_woocommerce_thumbnail() {
		global $product, $woocommerce;

		$items_in_cart = array();

		if ( $woocommerce->cart && $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
			foreach ( $woocommerce->cart->get_cart() as $cart ) {
				$items_in_cart[] = $cart['product_id'];
			}
		}

		$id      = get_the_ID();
		$in_cart = in_array( $id, $items_in_cart );
		$size    = 'shop_catalog';

		$attachment_image = '';
		if ( Avada()->settings->get( 'woocommerce_disable_crossfade_effect' ) ) {
			$gallery = get_post_meta( $id, '_product_image_gallery', true );

			if ( ! empty( $gallery ) ) {
				$gallery          = explode( ',', $gallery );
				$first_image_id   = $gallery[0];
				$attachment_image = wp_get_attachment_image( $first_image_id, $size, false, array( 'class' => 'hover-image' ) );
			}
		}
		$thumb_image = get_the_post_thumbnail( $id, $size );

		if ( $attachment_image ) {
			$classes = 'crossfade-images';
		} else {
			$classes = 'featured-image';
		}

		echo '<span class="' . $classes . '">';
		echo $attachment_image;
		echo $thumb_image;
		if ( $in_cart ) {
			echo '<span class="cart-loading"><i class="fusion-icon-check-square-o"></i></span>';
		} else {
			echo '<span class="cart-loading"><i class="fusion-icon-spinner"></i></span>';
		}
		echo '</span>';
	}
}

if ( Avada()->settings->get( 'woocommerce_product_box_design' ) == 'clean' ) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'avada_woocommerce_thumbnail', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	/**
	 * Shows the featured image of the product.
	 */
	function avada_woocommerce_thumbnail() {
		global $product, $woocommerce;

		$items_in_cart = array();

		if ( $woocommerce->cart && $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
			foreach ( $woocommerce->cart->get_cart() as $cart ) {
				$items_in_cart[] = $cart['product_id'];
			}
		}

		$id             = get_the_ID();
		$in_cart        = in_array( $id, $items_in_cart );
		$size           = 'shop_catalog';
		$post_permalink = get_permalink();
		$classes        = '';

		if ( $in_cart ) {
			$classes = 'fusion-item-in-cart';
		}

		$featured_image_markup = avada_render_first_featured_image_markup( $id, $size, $post_permalink, true, false, true, 'disable', 'disable', '', '', 'yes', true );
		echo '<div class="fusion-clean-product-image-wrapper ' . $classes . '">';
			echo $featured_image_markup;
		echo '</div>';
	}
}

add_filter( 'wp_nav_menu_items', 'fusion_add_woo_cart_to_widget', 20, 4 );
/**
 * Adds cart menu item.
 *
 * @param string $items The menu items.
 * @param array  $args  The menu arguments.
 * @return string
 */
function fusion_add_woo_cart_to_widget( $items, $args ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$ubermenu = false;

		if ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {
			// Disable woo cart on ubermenu navigations.
			$ubermenu = true;
		}

		if ( false == $ubermenu && 'fusion-widget-menu' == $args->container_class ) {
			$items .= fusion_add_woo_cart_to_widget_html();
		}
	}

	return $items;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'avada_woocommerce_header_add_to_cart_fragment' );
/**
 * Modify the cart ajax.
 *
 * @param array $fragments Ajax fragments handled by WooCommerce.
 * @return array
 */
function avada_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	$header_top_cart = avada_nav_woo_cart( 'secondary' );
	$fragments['.fusion-secondary-menu-cart'] = $header_top_cart;

	$header_cart = avada_nav_woo_cart( 'main' );
	$fragments['.fusion-main-menu-cart'] = $header_cart;

	$widget_cart = fusion_add_woo_cart_to_widget_html();
	$fragments['.fusion-widget-cart'] = $widget_cart;

	return $fragments;
}

/**
 * Opens a div.
 */
function avada_woocommerce_single_product_summary_open() {
	echo '<div class="summary-container">';
}
add_action( 'woocommerce_single_product_summary', 'avada_woocommerce_single_product_summary_open', 1 );

/**
 * Closes the div.
 */
function avada_woocommerce_single_product_summary_close() {
	echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'avada_woocommerce_single_product_summary_close', 100 );

add_action( 'woocommerce_after_single_product_summary', 'avada_woocommerce_after_single_product_summary', 15 );
/**
 * Markupo to add after the summary on single products.
 */
function avada_woocommerce_after_single_product_summary() {

	$nofollow = ' rel="noopener noreferrer"';
	if ( Avada()->settings->get( 'nofollow_social_links' ) ) {
		$nofollow = ' rel="noopener noreferrer nofollow"';
	}
	$social = '<div class="fusion-clearfix"></div>';
	if ( Avada()->settings->get( 'woocommerce_social_links' ) ) {

		if ( ! wp_is_mobile() ) {
			$facebook_url = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . wp_strip_all_tags( get_the_title(), true );
		} else {
			$facebook_url = 'https://m.facebook.com/sharer.php?u=' . get_permalink();
		}

		$social .= '<ul class="social-share clearfix">
		<li class="facebook">
			<a href="' . $facebook_url . '" target="_blank"' . $nofollow . '>
				<i class="fontawesome-icon medium circle-yes fusion-icon-facebook"></i>
				<div class="fusion-woo-social-share-text"><span>' . __( 'Share On Facebook', 'Avada' ) . '</span></div>
			</a>
		</li>
		<li class="twitter">
			<a href="https://twitter.com/share?text=' . wp_strip_all_tags( get_the_title(), true ) . '&amp;url=' . urlencode( get_permalink() ) . '" target="_blank"' . $nofollow . '>
				<i class="fontawesome-icon medium circle-yes fusion-icon-twitter"></i>
				<div class="fusion-woo-social-share-text"><span>' . __( 'Tweet This Product', 'Avada' ) . '</span></div>
			</a>
		</li>
		<li class="pinterest">';
		$full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$social .= '<a href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;description=' . urlencode( wp_strip_all_tags( get_the_title(), true ) ) . '&amp;media=' . urlencode( $full_image[0] ) . '" target="_blank"' . $nofollow . '>
				<i class="fontawesome-icon medium circle-yes fusion-icon-pinterest"></i>
				<div class="fusion-woo-social-share-text"><span>' . __( 'Pin This Product', 'Avada' ) . '</span></div>
			</a>
		</li>
		<li class="email">
			<a href="mailto:?subject=' . rawurlencode( html_entity_decode( wp_strip_all_tags( get_the_title(), true ), ENT_COMPAT, 'UTF-8' ) ) . '&body=' . get_permalink() . '" target="_blank"' . $nofollow . '>
				<i class="fontawesome-icon medium circle-yes fusion-icon-mail"></i>
				<div class="fusion-woo-social-share-text"><span>' . __( 'Mail This Product', 'Avada' ) . '</span></div>
			</a>
		</li>
	</ul>';

		echo $social;
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'avada_woocommerce_output_related_products', 15 );
/**
 * Add related products.
 */
function avada_woocommerce_output_related_products() {
	global $post;

	$number_of_columns = get_post_meta( $post->ID, 'pyre_number_of_related_products', true );
	if ( in_array( get_post_meta( $post->ID, 'pyre_number_of_related_products', true ), array( 'default', '' ) ) || ! get_post_meta( $post->ID, 'pyre_number_of_related_products', true ) ) {
		$number_of_columns = Avada()->settings->get( 'woocommerce_related_columns' );
	}

	$args = array(
		'posts_per_page' => $number_of_columns,
		'columns'        => $number_of_columns,
		'orderby'        => 'rand',
	);

	echo '<div class="fusion-clearfix"></div>';
	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'avada_woocommerce_upsell_display', 10 );
/**
 * Displays upsells.
 */
function avada_woocommerce_upsell_display() {
	global $product, $woocommerce_loop, $post;

	$upsells = $product->get_upsells();

	if ( count( $upsells ) == 0 ) {
		return;
	}
	?>
	<div class="fusion-clearfix"></div>
	<?php
	$number_of_columns = get_post_meta( $post->ID, 'pyre_number_of_related_products', true );
	if ( in_array( get_post_meta( $post->ID, 'pyre_number_of_related_products', true ), array( 'default', '' ) ) || ! get_post_meta( $post->ID, 'pyre_number_of_related_products', true ) ) {
		$number_of_columns = Avada()->settings->get( 'woocommerce_related_columns' );
	}
	woocommerce_upsell_display( - 1, $number_of_columns );
}

/* variations hooks */


/* end variations hooks */

/* cart hooks */
add_action( 'woocommerce_before_cart_table', 'avada_woocommerce_before_cart_table', 20 );
/**
 * Add markup before the cart table.
 *
 * @param array $args Not really used here.
 */
function avada_woocommerce_before_cart_table( $args ) {
	global $woocommerce;

	$html = '<div class="woocommerce-content-box full-width clearfix">';

	if ( $woocommerce->cart->get_cart_contents_count() == 1 ) {
		$html .= '<h2>' . sprintf( __( 'You Have %d Item In Your Cart', 'Avada' ), $woocommerce->cart->get_cart_contents_count() ) . '</h2>';
	} else {
		$html .= '<h2>' . sprintf( __( 'You Have %d Items In Your Cart', 'Avada' ), $woocommerce->cart->get_cart_contents_count() ) . '</h2>';
	}

	echo $html;
}

add_action( 'woocommerce_after_cart_table', 'avada_woocommerce_after_cart_table', 20 );
/**
 * Adds markup after the cart table.
 *
 * @param array $args Not used here.
 */
function avada_woocommerce_after_cart_table( $args ) {
	echo '</div>';
}

/**
 * Display cross-sell template.
 *
 * @param int    $posts_per_page Number of posts in the query.
 * @param int    $columns        Number of culumns.
 * @param string $orderby        Determines how the query will order the posts.
 */
function woocommerce_cross_sell_display( $posts_per_page = 3, $columns = 3, $orderby = 'rand' ) {
	wc_get_template( 'cart/cross-sells.php', array(
		'posts_per_page' => $posts_per_page,
		'orderby'        => $orderby,
		'columns'        => $columns,
	) );
}

/**
 * Adds shipping calculation markup & form.
 */
function cart_shipping_calc() {
	global $woocommerce;

	if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) {
		return;
	}
	?>

	<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

	<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

		<h2><span href="#" class="shipping-calculator-button"><?php _e( 'Calculate Shipping', 'woocommerce' ); ?></span>
		</h2>

		<div class="avada-shipping-calculator-form">

			<p class="form-row form-row-wide">
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
					<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
					<?php
					foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					}
					?>
				</select>
			</p>

			<div class="<?php if ( Avada()->settings->get( 'avada_styles_dropdowns' ) ) : ?>avada-select-parent fusion-layout-column fusion-one-half fusion-spacing-yes<?php endif; ?>">
				<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states( $current_cc );
				?>

				<?php if ( is_array( $states ) && empty( $states ) ) : // Hidden Input. ?>

					<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>" />

				<?php elseif ( is_array( $states ) ) : // Dropdown Input. ?>

					<span>
						<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>">
							<option value=""><?php _e( 'Select a state&hellip;', 'woocommerce' ); ?></option>
							<?php
							foreach ( $states as $ckey => $cvalue ) {
								echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
							}
							?>
						</select>
					</span>

				<?php else : // Standard Input. ?>

					<input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / county', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />

				<?php endif; ?>
			</div>

			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

				<p class="form-row form-row-wide">
					<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
				</p>

			<?php endif; ?>

			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

				<div class="form-row form-row-wide fusion-layout-column fusion-one-half fusion-spacing-yes fusion-column-last">
					<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
				</div>

			<?php endif; ?>

			<p>
				<button type="submit" name="calc_shipping" value="1" class="fusion-button button-default button-small button small default"><?php _e( 'Update Totals', 'woocommerce' ); ?></button>
			</p>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>

<?php
}

/**
 * Gets the shipping calculator template.
 */
function woocommerce_shipping_calculator() {
	if ( ! is_cart() ) {
		wc_get_template( 'cart/shipping-calculator.php' );
	}
}

add_action( 'woocommerce_cart_collaterals', 'avada_woocommerce_cart_collaterals', 5 );
/**
 * Adds coupon code form.
 *
 * @param array $args The formarguments.
 */
function avada_woocommerce_cart_collaterals( $args ) {
	global $woocommerce;
	?>
	<div class="shipping-coupon">
		<?php echo cart_shipping_calc(); ?>
		<?php if ( WC()->cart->coupons_enabled() ) : ?>
			<div class="coupon">
				<h2><?php esc_attr_e( 'Have A Promotional Code?', 'Avada' ); ?></h2>
				<input type="text" name="coupon_code" class="input-text" id="avada_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
				<input type="submit" class="fusion-apply-coupon fusion-button fusion-button-default fusion-button-small button default small" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'Avada' ); ?>" />
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</div>
		<?php endif; ?>
	</div>
<?php
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_cart_collaterals', 'avada_woocommerce_cross_sell_display', 5 );
/**
 * Displays cross-sell.
 */
function avada_woocommerce_cross_sell_display() {
	global $product, $woocommerce_loop, $post;

	$crosssells = WC()->cart->get_cross_sells();

	if ( 0 == count( $crosssells ) ) {
		return;
	}

	$number_of_columns = Avada()->settings->get( 'woocommerce_related_columns' );

	woocommerce_cross_sell_display( apply_filters( 'woocommerce_cross_sells_total', - 1 ), $number_of_columns );
}

/* end cart hooks */

/* begin checkout hooks */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_before_checkout_form', 'avada_woocommerce_checkout_coupon_form', 10 );
/**
 * Adds coupon form in the checkout page.
 *
 * @param array $args The form arguments.
 */
function avada_woocommerce_checkout_coupon_form( $args ) {
	global $woocommerce;

	if ( ! WC()->cart->coupons_enabled() ) {
		return;
	}
	?>

	<form class="woocommerce-content-box full-width checkout_coupon" method="post">

		<h2 class="promo-code-heading fusion-alignleft"><?php _e( 'Have A Promotional Code?', 'Avada' ); ?></h2>

		<div class="coupon-contents fusion-alignright">
			<div class="form-row form-row-first fusion-alignleft coupon-input">
				<input type="text" name="coupon_code" class="input-text"
				       placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value=""/>
			</div>

			<div class="form-row form-row-last fusion-alignleft coupon-button">
				<input type="submit" class="fusion-button button-default button-small button default small"
				       name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>"/>
			</div>

			<div class="clear"></div>
		</div>
	</form>
<?php
}

if ( ! Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
	add_action( 'woocommerce_before_checkout_form', 'avada_woocommerce_before_checkout_form' );
}
/**
 * Markup to add before the checkout form.
 *
 * @param array $args Not used in this context.
 */
function avada_woocommerce_before_checkout_form( $args ) {
	global $woocommerce;
	?>

	<ul class="woocommerce-side-nav woocommerce-checkout-nav">
		<li class="is-active">
			<a data-name="col-1" href="#">
				<?php _e( 'Billing Address', 'Avada' ); ?>
			</a>
		</li>
		<?php if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() ) : ?>
			<li>
				<a data-name="col-2" href="#">
					<?php _e( 'Shipping Address', 'Avada' ); ?>
				</a>
			</li>
		<?php
		elseif ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) :

			if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

				<li>
					<a data-name="col-2" href="#">
						<?php esc_attr_e( 'Additional Information', 'Avada' ); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<li>
			<a data-name="order_review" href="#">
				<?php _e( 'Review &amp; Payment', 'Avada' ); ?>
			</a>
		</li>
	</ul>

	<div class="woocommerce-content-box avada-checkout">

<?php

}

if ( ! Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
	add_action( 'woocommerce_after_checkout_form', 'avada_woocommerce_after_checkout_form' );
}

/**
 * Closes the div after the checkout form.
 *
 * @param array $args The arguments (not used here).
 */
function avada_woocommerce_after_checkout_form( $args ) {
	echo '</div>';
}

if ( Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
	add_action( 'woocommerce_checkout_before_customer_details', 'avada_woocommerce_checkout_before_customer_details' );
}
/**
 * Markup to add before the customer details form.
 *
 * @param array $args The form arguments. Not used in the context of this function.
 */
function avada_woocommerce_checkout_before_customer_details( $args ) {
	global $woocommerce;

	if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() || apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) && ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) ) {
		return;
	} else {
		echo '<div class="avada-checkout-no-shipping">';
	}
}

if ( Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
	add_action( 'woocommerce_checkout_after_customer_details', 'avada_woocommerce_checkout_after_customer_details' );
}
/**
 * Adds markup after the customer details form.
 *
 * @param array $args The form arguments. Not used in the context of this function.
 */
function avada_woocommerce_checkout_after_customer_details( $args ) {
	global $woocommerce;

	if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() || apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) && ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) ) {
		echo '<div class="clearboth"></div>';
	} else {
		echo '<div class="clearboth"></div></div>';
	}
	echo '<div class="woocommerce-content-box full-width">';
}


add_action( 'woocommerce_checkout_billing', 'avada_woocommerce_checkout_billing', 20 );
/**
 * Add checkout billing markup.
 *
 * @param array $args The form arguments. Not used in the context of this function.
 */
function avada_woocommerce_checkout_billing( $args ) {
	global $woocommerce;

	$data_name = 'order_review';
	if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() || apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) && ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) ) {
		$data_name = 'col-2';
	}

	if ( ! Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
		?>

		<a data-name="<?php echo esc_attr( $data_name ); ?>" href="#"
		   class="fusion-button button-default button-medium  button default medium continue-checkout"><?php esc_attr_e( 'Continue', 'Avada' ); ?></a>
		<div class="clearboth"></div>
		<?php
	}

}

add_action( 'woocommerce_checkout_shipping', 'avada_woocommerce_checkout_shipping', 20 );
/**
 * Add checkout shipping markup.
 *
 * @param array $args The form arguments. Not used in the context of this function.
 */
function avada_woocommerce_checkout_shipping( $args ) {

	if ( ! Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
		?>
		<a data-name="order_review" href="#"
		   class="fusion-button button-default button-medium continue-checkout button default medium"><?php _e( 'Continue', 'Avada' ); ?></a>
		<div class="clearboth"></div>
		<?php
	}

}

add_filter( 'woocommerce_enable_order_notes_field', 'avada_enable_order_notes_field' );
/**
 * Determines if we should enable order notes or not.
 *
 * @return bool
 */
function avada_enable_order_notes_field() {
	return ( ! Avada()->settings->get( 'woocommerce_enable_order_notes' ) ) ? 0 : 1;
}

if ( Avada()->settings->get( 'woocommerce_one_page_checkout' ) ) {
	add_action( 'woocommerce_checkout_after_order_review', 'avada_woocommerce_checkout_after_order_review', 20 );
}

/**
 * Closes the div.
 */
function avada_woocommerce_checkout_after_order_review() {
	echo '</div>';
}

// Function under myaccount hooks.
remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
add_action( 'woocommerce_thankyou', 'avada_woocommerce_view_order', 10 );
/* End checkout hooks */

/* Begin my-account hooks */

/**
 * Open a div if needed.
 */
function avada_woocommerce_before_customer_login_form() {
	global $woocommerce;
	if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		echo '<div id="customer_login" class="woocommerce-content-box full-width">';
	}
}
add_action( 'woocommerce_before_customer_login_form', 'avada_woocommerce_before_customer_login_form' );

add_action( 'woocommerce_after_customer_login_form', 'avada_woocommerce_after_customer_login_form' );
/**
 * Markup to add after the customer-login form.
 */
function avada_woocommerce_after_customer_login_form() {
	global $woocommerce;
	if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		echo '</div>';
	}
}
/* End my-account hooks */

/* Begin order hooks */
remove_action( 'woocommerce_view_order', 'woocommerce_order_details_table', 10 );
add_action( 'woocommerce_view_order', 'avada_woocommerce_view_order', 10 );
/**
 * Add the view-order markup.
 *
 * @param int $order_id The ID of the order we're querying.
 */
function avada_woocommerce_view_order( $order_id ) {
	global $woocommerce;

	$order = new WC_Order( $order_id );

	?>
	<div class="avada-order-details woocommerce-content-box full-width">
		<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
		<table class="shop_table order_details">
			<thead>
			<tr>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
			</thead>
			<tfoot>
				<?php if ( $totals = $order->get_order_item_totals() ) : ?>
					<?php foreach ( $totals as $total ) : ?>
						<tr>
							<td class="filler-td">&nbsp;</td>
							<th scope="row"><?php echo $total['label']; ?></th>
							<td class="product-total"><?php echo $total['value']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tfoot>
			<tbody>
			<?php if ( count( $order->get_items() ) > 0 ) : ?>

				<?php foreach ( $order->get_items() as $item ) : ?>
					<?php $_product  = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item ); ?>
					<?php $item_meta = new WC_Order_Item_Meta( $item['item_meta'] ); ?>

					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
						<td class="product-name">
							<span class="product-thumbnail">
								<?php $thumbnail = $_product->get_image(); ?>
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo $thumbnail; ?>
								<?php else : ?>
									<a href="<?php echo $_product->get_permalink(); ?>"><?php echo $thumbnail; ?></a>
								<?php endif; ?>
							</span>

							<div class="product-info">
								<?php if ( $_product && ! $_product->is_visible() ) : ?>
									<?php echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item ); ?>
								<?php else : ?>
									<?php echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item ); ?>
								<?php endif; ?>
								<?php
								// Meta data.
								do_action( 'woocommerce_order_item_meta_start', $item['product_id'], $item, $order );
								$order->display_item_meta( $item );
								$order->display_item_downloads( $item );
								do_action( 'woocommerce_order_item_meta_end', $item['product_id'], $item, $order );
								?>
							</div>
						</td>
						<td class="product-quantity">
							<?php echo apply_filters( 'woocommerce_order_item_quantity_html', $item['qty'], $item ); ?>
						</td>
						<td class="product-total">
							<?php echo $order->get_formatted_line_subtotal( $item ); ?>
						</td>
					</tr>
					<?php if ( in_array( $order->status, array( 'processing', 'completed' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) : ?>
						<tr class="product-purchase-note">
							<td colspan="3"><?php echo apply_filters( 'the_content', $purchase_note ); ?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_order_items_table', $order ); ?>
			</tbody>
		</table>
		<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	</div>

	<div class="avada-customer-details woocommerce-content-box full-width">
		<header>
			<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
		</header>
		<dl class="customer_details">
			<?php if ( $order->billing_email ) : ?>
				<?php echo '<dt>' . __( 'Email:', 'woocommerce' ) . '</dt> <dd>' . $order->billing_email . '</dd><br />'; ?>
			<?php endif; ?>
			<?php if ( $order->billing_phone ) : ?>
				<dt><?php esc_attr_e( 'Telephone:', 'woocommerce' ); ?></dt> <dd><?php echo esc_html( $order->billing_phone ); ?></dd>
			<?php endif; ?>

			<?php
			// Additional customer details hook.
			do_action( 'woocommerce_order_details_after_customer_details', $order );
			?>
		</dl>

		<?php if ( 'no' === get_option( 'woocommerce_ship_to_billing_address_only' ) && 'no' !== get_option( 'woocommerce_calc_shipping' ) ) : ?>

		<div class="col2-set addresses">

			<div class="col-1">

				<?php endif; ?>

				<header class="title">
					<h3><?php esc_attr_e( 'Billing Address', 'woocommerce' ); ?></h3>
				</header>
				<address>
					<p>
						<?php if ( ! $order->get_formatted_billing_address() ) : ?>
							<?php esc_attr_e( 'N/A', 'woocommerce' ); ?>
						<?php else : ?>
							<?php echo $order->get_formatted_billing_address(); ?>
						<?php endif; ?>
					</p>
				</address>

				<?php if ( 'no' === get_option( 'woocommerce_ship_to_billing_address_only' ) && 'no' !== get_option( 'woocommerce_calc_shipping' ) ) : ?>

			</div>
			<!-- /.col-1 -->

			<div class="col-2">

				<header class="title">
					<h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
				</header>
				<address>
					<p>
						<?php if ( ! $order->get_formatted_shipping_address() ) : ?>
							<?php esc_attr_e( 'N/A', 'woocommerce' ); ?>
						<?php else : ?>
							<?php echo $order->get_formatted_shipping_address(); ?>
						<?php endif; ?>
					</p>
				</address>

			</div>
			<!-- /.col-2 -->

		</div>
		<!-- /.col2-set -->

	<?php endif; ?>

		<div class="clear"></div>

	</div>

<?php
}
/* End order hooks */
add_filter( 'post_class', 'avada_change_product_class' );
if ( ! function_exists( 'avada_change_product_class' ) ) {
	/**
	 * The avada_change_product_class hook - Function to add 'product-list-view' class if the list view is being displayed.
	 *
	 * @param  array $classes - An array containing class names for the particular post / product.
	 * @return array $classes - An array containing additional class 'product-list-view' if the product view is set to list.
	 */
	function avada_change_product_class( $classes ) {
		if ( isset( $_SERVER['QUERY_STRING'] ) ) {
			parse_str( $_SERVER['QUERY_STRING'], $params );
			if ( isset( $params['product_view'] ) ) {
				$product_view = $params['product_view'];
				if ( 'list' == $product_view ) {
					$classes[] = 'product-list-view';
				}
			}
		}
		return $classes;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
