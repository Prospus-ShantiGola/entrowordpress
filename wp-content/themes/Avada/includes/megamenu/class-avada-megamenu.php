<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

// Don't duplicate me!
if ( ! class_exists( 'Avada_Megamenu' ) ) {

	/**
	 * Class to manipulate menus.
	 *
	 * @since 3.4
	 */
	class Avada_Megamenu extends Avada_Megamenu_Framework {

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {
			add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_menu_style_fields' ), 10, 3 );
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_menu_style_data_to_menu' ) );
			if ( Avada()->settings->get( 'disable_megamenu' ) ) {
				add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_megamenu_data_to_menu' ) );
				add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_megamenu_fields' ), 20, 3 );
			}
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'add_custom_fields' ) );
		}


		/**
		 * Function to replace normal edit nav walker for fusion core mega menus.
		 *
		 * @return string Class name of new navwalker
		 */
		public function add_custom_fields() {
			return 'Avada_Nav_Walker_Megamenu';
		}

		/**
		 * Add the custom menu style fields menu item data to fields in database.
		 *
		 * @access public
		 * @param string|int $menu_id         The menu ID.
		 * @param string|int $menu_item_db_id The menu ID from the db.
		 * @param array      $args            The arguments array.
		 * @return void
		 */
		public function save_custom_menu_style_fields( $menu_id, $menu_item_db_id, $args ) {
			$field_names = array( 'menu-item-fusion-megamenu-icon' );
			if ( ! $args['menu-item-parent-id'] ) {
				$field_names = array( 'menu-item-fusion-menu-style', 'menu-item-fusion-megamenu-icon' );
			}

			foreach ( $field_names as $name ) {
				if ( ! isset( $_REQUEST[ $name ][ $menu_item_db_id ] ) ) {
					$_REQUEST[ $name ][ $menu_item_db_id ] = '';
				}
				$value = $_REQUEST[ $name ][ $menu_item_db_id ];
				update_post_meta( $menu_item_db_id, '_' . str_replace( '-', '_', $name ), $value );
			}
		}

		/**
		 * Add custom menu style fields data to the menu.
		 *
		 * @access public
		 * @param object $menu_item A single menu item.
		 * @return object The menu item.
		 */
		public function add_menu_style_data_to_menu( $menu_item ) {
			if ( ! $menu_item->menu_item_parent ) {
				$menu_item->fusion_menu_style = get_post_meta( $menu_item->ID, '_menu_item_fusion_menu_style', true );
			}

			$menu_item->fusion_megamenu_icon = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_icon', true );

			return $menu_item;
		}


		/**
		 * Add the custom megamenu fields menu item data to fields in database.
		 *
		 * @access public
		 * @param string|int $menu_id         The menu ID.
		 * @param string|int $menu_item_db_id The menu ID from the db.
		 * @param array      $args            The arguments array.
		 * @return void
		 */
		public function save_custom_megamenu_fields( $menu_id, $menu_item_db_id, $args ) {

			$field_name_suffix = array( 'title', 'widgetarea', 'columnwidth', 'icon', 'thumbnail' );
			if ( ! $args['menu-item-parent-id'] ) {
				$field_name_suffix = array( 'status', 'width', 'columns', 'columnwidth', 'icon', 'thumbnail' );
			}

			foreach ( $field_name_suffix as $key ) {
				if ( ! isset( $_REQUEST[ 'menu-item-fusion-megamenu-' . $key ][ $menu_item_db_id ] ) ) {
					$_REQUEST[ 'menu-item-fusion-megamenu-' . $key ][ $menu_item_db_id ] = '';
				}
				$value = $_REQUEST[ 'menu-item-fusion-megamenu-' . $key ][ $menu_item_db_id ];
				update_post_meta( $menu_item_db_id, '_menu_item_fusion_megamenu_' . $key, $value );
			}
		}

		/**
		 * Add custom megamenu fields data to the menu.
		 *
		 * @access public
		 * @param object $menu_item A single menu item.
		 * @return object The menu item.
		 */
		public function add_megamenu_data_to_menu( $menu_item ) {

			if ( ! $menu_item->menu_item_parent ) {

				$menu_item->fusion_megamenu_status  = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_status', true );
				$menu_item->fusion_megamenu_width   = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_width', true );
				$menu_item->fusion_megamenu_columns = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_columns', true );

			} else {

				$menu_item->fusion_megamenu_title      = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_title', true );
				$menu_item->fusion_megamenu_widgetarea = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_widgetarea', true );

			}

			$menu_item->fusion_megamenu_columnwidth = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_columnwidth', true );
			$menu_item->fusion_megamenu_icon        = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_icon', true );
			$menu_item->fusion_megamenu_thumbnail   = get_post_meta( $menu_item->ID, '_menu_item_fusion_megamenu_thumbnail', true );

			return $menu_item;

		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
