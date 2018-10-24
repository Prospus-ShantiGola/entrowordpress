<?php global $all_fusion_builder_elements; ?>

<div class="wrap about-wrap fusion-builder-wrap fusion-builder-settings">

	<?php Fusion_Builder_Admin::header(); ?>
	<?php $existing_settings = get_option( 'fusion_builder_settings' ); ?>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

		<div class="fusion-builder-important-notice">
			<p class="about-description">
				<?php esc_html_e( 'Fusion Builder elements are fully customizable through a global set of options in the Fusion Theme Options Panel. Click the button below to go to Fusion Theme Options to see all the style settings available for of each element. Additionally, there are options below for general Fusion Builder settings.', 'fusion-builder' ); ?><br/>
				<a href="<?php echo admin_url( 'themes.php?page=avada_options#tab-fusion_builder_elements' ); ?>" class="button button-primary button-large avada-large-button"><?php esc_attr_e( 'Go To Fusion Theme Options', 'fusion-builder' );?></a>
			</p>
		</div>

		<div class="fusion-builder-settings">

			<div class="fusion-builder-option">
				<div class="fusion-builder-option-title">
					<h3><?php esc_attr_e( 'Fusion Builder Auto Activation', 'fusion-builder' ); ?></h3>
					<span class="fusion-builder-option-label">
						<?php esc_attr_e( 'Turn on to enable the Fusion Builder user interface by default when opening a page or post. Turn off to enable the default WP editor view.', 'fusion-builder' ); ?>
					</span>
				</div>

				<div class="fusion-builder-option-field">
					<div class="fusion-form-radio-button-set ui-buttonset enable-builder-ui">
						<?php
						$enable_builder_ui_by_default = '0';
						if ( isset( $existing_settings['enable_builder_ui_by_default'] ) ) {
							$enable_builder_ui_by_default = $existing_settings['enable_builder_ui_by_default'];
						}
						?>
						<input type="hidden" class="button-set-value" value="<?php echo $enable_builder_ui_by_default; ?>" name="enable_builder_ui_by_default" id="enable_builder_ui_by_default">
						<a data-value="1" class="ui-button buttonset-item<?php echo ( $enable_builder_ui_by_default ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'On', 'fusion-builder' ); ?></a>
						<a data-value="0" class="ui-button buttonset-item<?php echo ( ! $enable_builder_ui_by_default ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'Off', 'fusion-builder' ); ?></a>
					</div>
				</div>
			</div>

			<div class="fusion-builder-option">
				<div class="fusion-builder-option-title">
					<h3><?php esc_attr_e( 'Fusion Builder Elements', 'fusion-builder' ); ?></h3>
					<span class="fusion-builder-option-label">
						<p><?php esc_attr_e( 'Each Fusion Builder element can be enabled or disabled. This can increase performance if you are not using a specific element. Check the box to enable, uncheck to disable.', 'fusion-builder' ); ?></p>
						<p><?php esc_attr_e( 'NOTE: Elements for plugins like WooCommere or The Events Calendar will only be available in the builder, if the corresponding options are activated here and if those plugins are active.', 'fusion-builder' ); ?></p>
						<p><?php esc_attr_e( 'WARNING: Use with caution. Disabling an element will remove it from all pages/posts, old and new. If it was on a previous page/post, it will render as regular element markup on the frontend.', 'fusion-builder' ); ?></p>
					</span>
				</div>

				<div class="fusion-builder-option-field">
					<ul>
						<?php
						$i = 0;
						$plugin_elements = array(
							'fusion_featured_products_slider' => array(
								'name'      => esc_attr__( 'Woo Featured', 'fusion-builder' ),
								'shortcode' => 'fusion_featured_products_slider',
							),
							'fusion_products_slider' => array(
								'name'      => esc_attr__( 'Woo Carousel', 'fusion-builder' ),
								'shortcode' => 'fusion_products_slider',
							),
							'fusion_woo_shortcodes' => array(
								'name'              => esc_attr__( 'Woo Shortcodes', 'fusion-builder' ),
								'shortcode'         => 'fusion_woo_shortcodes',
							),
							'layerslider' => array(
								'name'       => esc_attr__( 'Layer Slider', 'fusion-builder' ),
								'shortcode'  => 'layerslider',
							),
							'rev_slider' => array(
								'name'       => esc_attr__( 'Revolution Slider', 'fusion-builder' ),
								'shortcode'  => 'rev_slider',
							),
							'fusion_events' => array(
								'name'      => esc_attr__( 'Events', 'fusion-builder' ),
								'shortcode' => 'fusion_events',
							),
							'fusion_fontawesome' => array(
								'name'       => esc_attr__( 'Font Awesome Icon', 'fusion-builder' ),
								'shortcode'  => 'fusion_fontawesome',
							),
							'fusion_fusionslider' => array(
								'name'              => esc_attr__( 'Fusion Slider', 'fusion-builder' ),
								'shortcode'         => 'fusion_fusionslider',
							),
						);

						$all_fusion_builder_elements = array_merge( $all_fusion_builder_elements, apply_filters( 'fusion_builder_plugin_elements', $plugin_elements ) );

						usort( $all_fusion_builder_elements, fusion_element_sort( 'name' ) );
						foreach ( $all_fusion_builder_elements as $module ) :
							if ( empty( $module['hide_from_builder'] ) ) {
								$i++;
								$checked = '';

								if ( ( isset( $existing_settings['fusion_elements'] ) && is_array( $existing_settings['fusion_elements'] ) && in_array( $module['shortcode'],  $existing_settings['fusion_elements'] ) ) ||
									 ( ! isset( $existing_settings['fusion_elements'] ) || ! is_array( $existing_settings['fusion_elements'] ) )
								 ) {
									 $checked = 'checked';
								 }
								echo '<li>';
								echo '<label for="hide_from_builder_' . $i . '">';
								echo '<input name="fusion_elements[]" type="checkbox" value="' . $module['shortcode'] . '" ' . $checked . ' id="hide_from_builder_' . $i . '"/>';
								echo $module['name'] . '</label>';
								echo '</li>';
							}
						endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="fusion-builder-option">
				<div class="fusion-builder-option-title">
					<h3><?php esc_attr_e( 'Post Types', 'fusion-builder' ); ?></h3>
					<span class="fusion-builder-option-label">
						<?php esc_html_e( 'Fusion Builder can be enabled or disabled on registered post types. Check the box to enable, uncheck to disable. Please note the Fusion element generator will still be active on any post type that is disabled.', 'fusion-builder' ); ?>
					</span>
				</div>

				<div class="fusion-builder-option-field">
					<ul>
						<input type="hidden" name="post_types[]" value=" " />
						<?php
						$args = array(
							'public' => true,
						);
						$post_types = get_post_types( $args, 'names', 'and' );
						// Filter out not relevant post types (can add filter later).
						$disabled_post_types = array( 'attachment', 'slide', 'themefusion_elastic' );
						foreach ( $disabled_post_types as $disabled ) {
							unset( $post_types[ $disabled ] );
						}
						$defaults = FusionBuilder::default_post_types();
						$i = 0;
						foreach ( $post_types as $post_type ) :
							$i++;
							$post_type_obj = get_post_type_object( $post_type );
							// Either selected in options saved, or in array of default post types.
							$checked = (
								( isset( $existing_settings['post_types'] ) && is_array( $existing_settings['post_types'] ) && in_array( $post_type,  $existing_settings['post_types'] ) ) ||
								( ! isset( $existing_settings['post_types'] ) && in_array( $post_type, $defaults ) ) )
								? 'checked' : '';
							echo '<li>';
							echo '<label for="fusion_post_type_' . $i . '">';
							echo '<input type="checkbox" name="post_types[]" value="' . $post_type . '" ' . $checked . ' id="fusion_post_type_' . $i . '"/>';
							echo $post_type_obj->labels->singular_name . '</label>';
							echo '</li>';
						endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="fusion-builder-option">
				<div class="fusion-builder-option-title">
					<h3><?php esc_attr_e( 'Import Fusion Builder Content', 'fusion-builder' ); ?></h3>
					<span class="fusion-builder-option-label">
						<?php esc_html_e( 'Choose to import Fusion Builder content; custom saved containers / columns / elements or full page templates. Click "Choose File" and select your Fusion Builder XML file.', 'fusion-builder' ); ?>
					</span>
				</div>

				<div class="fusion-builder-option-field">
					<form id="fusion-importer-form" method="post" enctype="multipart/form-data" name="fusion-importer-form">
						<input type="file" id="fusion-builder-import-file" name="fusion-builder-import-file" size="25" value="" accept=".xml" />

						<input type="submit" name="submit" id="submit" class="button fusion-builder-import-data" value="Import" disabled />

					</form>
					<div class="fusion-builder-import-success"><?php esc_attr_e( 'Content Successfully  Imported', 'fusion-builder' ); ?></div>
				</div>
			</div>

			<div class="fusion-builder-option">
				<div class="fusion-builder-option-title">
					<h3><?php esc_attr_e( 'Export Fusion Builder Content', 'fusion-builder' ); ?></h3>
					<span class="fusion-builder-option-label">
						<?php esc_html_e( 'Choose to export Fusion Builder content; custom saved containers / columns / elements or full page templates. An XML file will be downloaded to your computer.' ); ?>
					</span>
				</div>

				<div class="fusion-builder-option-field">
					<a href="<?php echo admin_url( 'admin.php?page=fusion-builder-options&fusion_action=export&fusion_export_type=fusion_element' ); ?>" class="button" title="<?php esc_attr_e( 'Export Fusion Elements from your Library', 'fusion-builder' ); ?>"><?php esc_attr_e( 'Export Content', 'fusion-builder' ); ?></a>

					<a href="<?php echo admin_url( 'admin.php?page=fusion-builder-options&fusion_action=export&fusion_export_type=fusion_template' ); ?>" class="button" title="<?php esc_attr_e( 'Export Fusion Templates from your Library', 'fusion-builder' ); ?>"><?php esc_attr_e( 'Export Templates', 'fusion-builder' ); ?></a>
				</div>
			</div>

			<?php if ( false !== get_option( 'fusion_core_unconverted_posts_converted', false ) ) : ?>
				<div class="fusion-builder-option">
					<div class="fusion-builder-option-title">
						<h3><?php esc_attr_e( 'Revert Fusion-Builder Migration', 'fusion-builder' ); ?></h3>
						<span class="fusion-builder-option-label">
							<?php printf( __( 'Caution: By reverting the migration, your content will revert to the state it was in before you installed Avada 5.0. You can manually re-trigger the migration at a later time from the <a href="%s">system status</a> page. Non-migrated pages/posts that use the old shortcodes will no longer function properly if Avada 5.0 is activated.', 'fusion-builder' ), admin_url( 'admin.php?page=avada-system-status' ) ); ?>
						</span>
					</div>

					<div class="fusion-builder-option-field">
						<a href="<?php echo admin_url( 'index.php?fusion_builder_migrate=1&ver=500&revert=1' ); ?>" class="button" title="<?php esc_attr_e( 'Revert Shortcodes Migration', 'fusion-builder' ); ?>"><?php esc_attr_e( 'Revert Shortcodes Migration', 'fusion-builder' ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<input type="hidden" name="action" value="save_fb_settings">

			<input type="submit" class="button button-primary fusion-builder-save-settings" value="<?php esc_attr_e( 'Save Settings', 'fusion-builder' ); ?>" />

		</div>

	</form>

	<?php Fusion_Builder_Admin::footer(); ?>
</div>
