<?php
/**
 * Fusion Framework
 *
 * WARNING: This file is part of the Fusion Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @version: 1.0.0
 * @package  Fusion/Template
 * @author   ThemeFusion
 * @link     http://theme-fusion.com
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Add the first level menu style dropdown to the menu fields.
add_action( 'wp_nav_menu_item_custom_fields', 'avada_add_menu_button_fields', 10, 4 );
/**
 * Adds the menu button fields.
 *
 * @param string $item_id The ID of the menu item.
 * @param object $item    The menu item object.
 * @param int    $depth   The depth of the current item in the menu.
 * @param array  $args    Menu arguments.
 */
function avada_add_menu_button_fields( $item_id, $item, $depth, $args ) {
	$name  = 'menu-item-fusion-menu-style';
	?>
	<p class="description description-wide fusion-menu-style">
		<label for="<?php echo $name . '-' . $item_id; ?>>">
			<?php esc_attr_e( 'Menu First Level Style', 'Avada' ); ?><br />
			<select id="<?php echo $name . '-' . $item_id; ?>" class="widefat edit-menu-item-target" name="<?php echo $name . '[' . $item_id . ']'; ?>">
				<option value="" <?php selected( $item->fusion_menu_style, '' ); ?>><?php esc_attr_e( 'Default Style', 'Avada' ); ?></option>
				<option value="fusion-button-small" <?php selected( $item->fusion_menu_style, 'fusion-button-small' ); ?>><?php esc_attr_e( 'Button Small', 'Avada' ); ?></option>
				<option value="fusion-button-medium" <?php selected( $item->fusion_menu_style, 'fusion-button-medium' ); ?>><?php esc_attr_e( 'Button Medium', 'Avada' ); ?></option>
				<option value="fusion-button-large" <?php selected( $item->fusion_menu_style, 'fusion-button-large' ); ?>><?php esc_attr_e( 'Button Large', 'Avada' ); ?></option>
				<option value="fusion-button-xlarge" <?php selected( $item->fusion_menu_style, 'fusion-button-xlarge' ); ?>><?php esc_attr_e( 'Button xLarge', 'Avada' ); ?></option>
			</select>
		</label>
	</p>
	<p class="field-megamenu-icon description description-wide">
		<label for="edit-menu-item-megamenu-icon-<?php echo $item_id; ?>">
			<?php esc_attr_e( 'Menu Icon (use full font awesome name)', 'Avada' ); ?>
			<input type="text" id="edit-menu-item-megamenu-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-icon" name="menu-item-fusion-megamenu-icon[<?php echo $item_id; ?>]" value="<?php echo $item->fusion_megamenu_icon; ?>" />
		</label>
	</p>
<?php }

// Add the mega menu custom fields to the menu fields.
if ( Avada()->settings->get( 'disable_megamenu' ) ) {
	add_action( 'wp_nav_menu_item_custom_fields', 'avada_add_megamenu_fields', 20, 4 );
}

/**
 * Adds the menu markup.
 *
 * @param string $item_id The ID of the menu item.
 * @param object $item    The menu item object.
 * @param int    $depth   The depth of the current item in the menu.
 * @param array  $args    Menu arguments.
 */
function avada_add_megamenu_fields( $item_id, $item, $depth, $args ) {
	?>
	<div class="clear"></div>
	<div class="fusion-mega-menu-options">
		<p class="field-megamenu-status description description-wide">
			<label for="edit-menu-item-megamenu-status-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-status-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-status" name="menu-item-fusion-megamenu-status[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->fusion_megamenu_status, 'enabled' ); ?> />
				<strong><?php esc_attr_e( 'Enable Fusion Mega Menu (only for main menu)', 'Avada' ); ?></strong>
			</label>
		</p>
		<p class="field-megamenu-width description description-wide">
			<label for="edit-menu-item-megamenu-width-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-width-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-width" name="menu-item-fusion-megamenu-width[<?php echo $item_id; ?>]" value="fullwidth" <?php checked( $item->fusion_megamenu_width, 'fullwidth' ); ?> />
				<?php esc_attr_e( 'Full Width Mega Menu (overrides column width)', 'Avada' ); ?>
			</label>
		</p>
		<p class="field-megamenu-columns description description-wide">
			<label for="edit-menu-item-megamenu-columns-<?php echo $item_id; ?>">
				<?php esc_attr_e( 'Mega Menu Number of Columns', 'Avada' ); ?>
				<select id="edit-menu-item-megamenu-columns-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-fusion-megamenu-columns[<?php echo $item_id; ?>]">
					<option value="auto" <?php selected( $item->fusion_megamenu_columns, 'auto' ); ?>><?php esc_attr_e( 'Auto', 'Avada' ); ?></option>
					<option value="1" <?php selected( $item->fusion_megamenu_columns, '1' ); ?>>1</option>
					<option value="2" <?php selected( $item->fusion_megamenu_columns, '2' ); ?>>2</option>
					<option value="3" <?php selected( $item->fusion_megamenu_columns, '3' ); ?>>3</option>
					<option value="4" <?php selected( $item->fusion_megamenu_columns, '4' ); ?>>4</option>
					<option value="5" <?php selected( $item->fusion_megamenu_columns, '5' ); ?>>5</option>
					<option value="6" <?php selected( $item->fusion_megamenu_columns, '6' ); ?>>6</option>
				</select>
			</label>
		</p>
		<p class="field-megamenu-columnwidth description description-wide">
			<label for="edit-menu-item-megamenu-columnwidth-<?php echo $item_id; ?>">
				<?php esc_attr_e( 'Mega Menu Column Width (in percentage, ex: 30%)', 'Avada' ); ?>
				<input type="text" id="edit-menu-item-megamenu-columnwidth-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-columnwidth" name="menu-item-fusion-megamenu-columnwidth[<?php echo $item_id; ?>]" value="<?php echo $item->fusion_megamenu_columnwidth; ?>" />
			</label>
		</p>
		<p class="field-megamenu-title description description-wide">
			<label for="edit-menu-item-megamenu-title-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-title-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-title" name="menu-item-fusion-megamenu-title[<?php echo $item_id; ?>]" value="disabled" <?php checked( $item->fusion_megamenu_title, 'disabled' ); ?> />
				<?php esc_attr_e( 'Disable Mega Menu Column Title', 'Avada' ); ?>
			</label>
		</p>
		<p class="field-megamenu-widgetarea description description-wide">
			<label for="edit-menu-item-megamenu-widgetarea-<?php echo $item_id; ?>">
				<?php esc_attr_e( 'Mega Menu Widget Area', 'Avada' ); ?>
				<select id="edit-menu-item-megamenu-widgetarea-<?php echo $item_id; ?>" class="widefat code edit-menu-item-megamenu-widgetarea" name="menu-item-fusion-megamenu-widgetarea[<?php echo $item_id; ?>]">
					<option value="0"><?php esc_attr_e( 'Select Widget Area', 'Avada' ); ?></option>
					<?php global $wp_registered_sidebars; ?>
					<?php if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) : ?>
						<?php foreach ( $wp_registered_sidebars as $sidebar ) : ?>
							<option value="<?php echo $sidebar['id']; ?>" <?php selected( $item->fusion_megamenu_widgetarea, $sidebar['id'] ); ?>><?php echo $sidebar['name']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</label>
		</p>
		<a href="#" id="fusion-media-upload-<?php echo $item_id; ?>" class="fusion-open-media button button-primary fusion-megamenu-upload-thumbnail"><?php esc_attr_e( 'Set Thumbnail', 'Avada' ); ?></a>
		<p class="field-megamenu-thumbnail description description-wide">
			<label for="edit-menu-item-megamenu-thumbnail-<?php echo $item_id; ?>">
				<input type="hidden" id="edit-menu-item-megamenu-thumbnail-<?php echo $item_id; ?>" class="fusion-new-media-image widefat code edit-menu-item-megamenu-thumbnail" name="menu-item-fusion-megamenu-thumbnail[<?php echo $item_id; ?>]" value="<?php echo $item->fusion_megamenu_thumbnail; ?>" />
				<img src="<?php echo $item->fusion_megamenu_thumbnail; ?>" id="fusion-media-img-<?php echo $item_id; ?>" class="fusion-megamenu-thumbnail-image" style="<?php echo ( trim( $item->fusion_megamenu_thumbnail ) ) ? 'display:inline;' : ''; ?>" />
				<a href="#" id="fusion-media-remove-<?php echo $item_id; ?>" class="remove-fusion-megamenu-thumbnail" style="<?php echo ( trim( $item->fusion_megamenu_thumbnail ) ) ? 'display:inline;' : ''; ?>"><?php esc_attr_e( 'Remove Image', 'Avada' ); ?></a>
			</label>
		</p>
	</div><!-- .fusion-mega-menu-options-->
	<?php
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
