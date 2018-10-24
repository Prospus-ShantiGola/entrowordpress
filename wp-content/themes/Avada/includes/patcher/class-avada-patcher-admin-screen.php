<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The admin screen class for teh patcher.
 *
 * @since 4.0.0
 */
class Avada_Patcher_Admin_Screen {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		// Call register settings function.
		add_action( 'admin_init', array( $this, 'settings' ) );
		// Add the patcher to the support screen.
		add_action( 'avada/admin_pages/support/after_list', array( $this, 'form' ) );

	}

	/**
	 * Register the settings.
	 *
	 * @access public
	 * @return void
	 */
	public function settings() {

		// Get the patches.
		$patches = Avada_Patcher_Client::get_patches();
		if ( ! empty( $patches ) ) {

			// Register settings for the patch contents.
			foreach ( $patches as $key => $value ) {
				register_setting( 'avada_patcher_' . $key, 'avada_patch_contents_' . $key );
			}
		}
	}

	/**
	 * The page contents.
	 *
	 * @access public
	 * @return void
	 */
	public function form() {

		// Get the patches.
		$patches = Avada_Patcher_Client::get_patches();
		// Get the fusion-core plugin version.
		$fusion_core_version = ( class_exists( 'FusionCore_Plugin' ) ) ? FusionCore_Plugin::VERSION : false;
		// Get the fusion-builder plugin version.
		$fusion_builder_version = ( class_exists( 'FusionBuilder' ) ) ? FUSION_BUILDER_VERSION : false;
		// Get the avada theme version.
		$avada_version = Avada::get_theme_version();

		// Determine if there are available patches, and build an array of them.
		$available_patches = array();
		$context = array(
			'avada'          => false,
			'fusion-core'    => false,
			'fusion-builder' => false,
		);
		foreach ( $patches as $patch_id => $patch_args ) {
			if ( ! isset( $patch_args['patch'] ) ) {
				continue;
			}
			foreach ( $patch_args['patch'] as $key => $unique_patch_args ) {
				switch ( $unique_patch_args['context'] ) {
					case 'avada':
						if ( $avada_version == $unique_patch_args['version'] ) {
							$available_patches[] = $patch_id;
							$context['avada'] = true;
						}
						break;
					case 'fusion-core':
						if ( $fusion_core_version == $unique_patch_args['version'] ) {
							$available_patches[] = $patch_id;
							$context['fusion-core'] = true;
						}
						break;
					case 'fusion-builder':
						if ( $fusion_builder_version == $unique_patch_args['version'] ) {
							$available_patches[] = $patch_id;
							$context['fusion-builder'] = true;
						}
						break;
				}
			}
		}
		// Make sure we have a unique array.
		$available_patches = array_unique( $available_patches );
		// Sort the array by value and re-index the keys.
		sort( $available_patches );

		// Get an array of the already applied patches.
		$applied_patches = get_site_option( 'avada_applied_patches', array() );

		// Get an array of patches that failed to be applied.
		$failed_patches = get_site_option( 'avada_failed_patches', array() );

		// Check if the server is adequate to handle the patcher.
		$time_limit = ini_get( 'max_execution_time' );
		if (
			( Avada_Helper::let_to_num( WP_MEMORY_LIMIT ) < 128000000 ) ||
			( 180 > $time_limit && 0 != $time_limit )
		) {
			new Avada_Patcher_Admin_Notices( 'server-status-notice', sprintf(
				esc_attr__( 'We\'ve checked the PHP configurations on your server and there are one or more low values which could cause the patches install to fail. You can see them in red on our %s tab. There are links to show you how to adjust them or you can contact your host for assistance.', 'Avada' ),
				'<a href="?page=avada-system-status">' . esc_attr__( 'System Status', 'Avada' ) . '</a>'
			) );
		}

		// Get the array of messages to display.
		$messages = Avada_Patcher_Admin_Notices::get_messages();
		?>
		<div class="avada-important-notice avada-auto-patcher">

			<div class="avada-patcher-heading">
				<p class="description">
					<?php if ( empty( $available_patches ) ) : ?>
						<?php printf( esc_html__( 'Avada Patcher: There Are No Available Patches For Avada v%s', 'Avada' ), $avada_version ); ?>
					<?php else : ?>
						<?php printf( esc_html__( 'Avada Patcher: The following patches are available for Avada %s', 'Avada' ), $avada_version ); ?>
					<?php endif; ?>
					<span class="avada-auto-patcher learn-more"><a href="https://theme-fusion.com/avada-doc/avada-patcher/" target="_blank" rel="noopener noreferrer"><?php esc_attr_e( 'Learn More', 'Avada' ); ?></a></span>
				</p>
				<?php if ( ! empty( $available_patches ) ) : ?>
					<p class="sub-description">
						<?php esc_html_e( 'The status column displays if a patch was applied. However, a patch can be reapplied if necessary.', 'Avada' ); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $messages ) ) : ?>
				<?php foreach ( $messages as $message ) : ?>
					<p class="avada-patcher-error"><?php echo wp_kses_post( $message ); ?></p>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if ( ! empty( $available_patches ) ) : // Only display the table if we have patches to apply. ?>
				<table class="avada-patcher-table">
					<tbody>
						<tr class="avada-patcher-headings">
							<th><?php esc_attr_e( 'Patch #', 'Avada' ); ?></th>
							<th><?php esc_attr_e( 'Issue Date', 'Avada' ); ?></th>
							<th><?php esc_attr_e( 'Description', 'Avada' ); ?></th>
							<th><?php esc_attr_e( 'Status', 'Avada' ); ?></th>
							<th></th>
						</tr>
						</tr>
						<?php foreach ( $available_patches as $key => $patch_id ) :

							// Do not allow applying the patch initially.
							// We'll have to check if they can later.
							$can_apply = false;

							// Make sure the patch exists.
							if ( ! array_key_exists( $patch_id, $patches ) ) {
								continue;
							}

							// Get the patch arguments.
							$patch_args = $patches[ $patch_id ];

							// Has the patch been applied?
							$patch_applied = ( in_array( $patch_id, $applied_patches ) ) ? true : false;

							// Has the patch failed?
							$patch_failed = ( in_array( $patch_id, $failed_patches ) ) ? true : false;

							// If there is no previous patch, we can apply it.
							if ( ! isset( $available_patches[ $key - 1 ] ) ) {
								$can_apply = true;
							}

							// If the previous patch exists and has already been applied,
							// then we can apply this one.
							if ( isset( $available_patches[ $key - 1 ] ) ) {
								if ( in_array( $available_patches[ $key - 1 ], $applied_patches ) ) {
									$can_apply = true;
								}
							}
							?>

							<tr class="avada-patcher-table-head">
								<td class="patch-id">#<?php echo intval( $patch_id ); ?></td>
								<td class="patch-date"><?php echo $patch_args['date'][0]; ?></td>
								<td class="patch-description">
									<?php if ( $patch_failed ) : ?>
										<div class="patch-failed-warning">
											<?php if ( defined( 'FS_METHOD' ) && 'direct' === FS_METHOD ) : ?>
												<?php
												printf(
													__( 'The patch could not be applied due to your server configuration. Please contact <a href="%s" target="_blank" rel="noopener noreferrer">Avada support</a> providing your FTP credentials so that a representative can apply the patch manually.', 'Avada' ),
													'https://theme-fusion.com/avada-doc/getting-started/avada-theme-support/'
												); ?>
											<?php else : ?>
												<?php printf(
													__( "The patch could not be applied. Please try adding <code>define( 'FS_METHOD', 'direct' );</code> in your wp-config.php file and try again, or contact <a href='%s' target='_blank' rel='noopener noreferrer'>Avada support</a> providing your FTP credentials so that a representative can apply the patch manually.", 'Avada' ),
													'https://theme-fusion.com/avada-doc/getting-started/avada-theme-support/'
												); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									<?php echo $patch_args['description'][0]; ?>
								</td>
								<td class="patch-status">
									<?php if ( $patch_failed ) : ?>
										<span style="color:#E53935;" class="dashicons dashicons-no"></span>
									<?php elseif ( $patch_applied ) : ?>
										<span style="color:#4CAF50;" class="dashicons dashicons-yes"></span>
									<?php endif; ?>
								</td>
								<td class="patch-apply">
									<?php if ( $can_apply ) : ?>
										<form method="post" action="options.php">
											<?php settings_fields( 'avada_patcher_' . $patch_id ); ?>
											<?php do_settings_sections( 'avada_patcher_' . $patch_id ); ?>
											<input type="hidden" name="avada_patch_contents_<?php echo $patch_id; ?>" value="<?php echo self::format_patch( $patch_args ); ?>" />
											<?php if ( $patch_applied ) : ?>
												<?php submit_button( esc_attr__( 'Patch Applied', 'Avada' ) ); ?>
											<?php else : ?>
												<?php submit_button( esc_attr__( 'Apply Patch', 'Avada' ) ); ?>
											<?php endif; ?>
										</form>
									<?php else : ?>
										<span class="button disabled button-small">
											<?php if ( isset( $available_patches[ $key - 1 ] ) ) : ?>
												<?php printf( esc_html__( 'Please apply patch #%s first.', 'Avada' ), $available_patches[ $key - 1 ] ); ?>
											<?php else : ?>
												<?php esc_html_e( 'Patch cannot be currently aplied.', 'Avada' ); ?>
											<?php endif; ?>
										</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
		// Delete the messages.
		Avada_Patcher_Admin_Notices::remove_messages_option();
	}

	/**
	 * Format the patch.
	 * We're encoding everything here for security reasons.
	 * We're also going to check the current versions of Avada & Fusion-Core,
	 * and then build the hash for this patch using the files that are needed.
	 *
	 * @since 4.0.0
	 * @access private
	 * @param array $patch The patch array.
	 * @return string
	 */
	private static function format_patch( $patch ) {
		// Get the fusion-core plugin version.
		$fusion_core_version = ( class_exists( 'FusionCore_Plugin' ) ) ? FusionCore_Plugin::VERSION : false;
		// Get the avada theme version.
		$avada_version = Avada::get_theme_version();
		// Get the fusion-builder plugin version.
		$fusion_builder_version = ( class_exists( 'FusionBuilder' ) ) ? FUSION_BUILDER_VERSION : false;

		$patches = array();
		if ( ! isset( $patch['patch'] ) ) {
			return;
		}
		foreach ( $patch['patch'] as $key => $args ) {
			if ( ! isset( $args['context'] ) || ! isset( $args['path'] ) || ! isset( $args['reference'] ) ) {
				continue;
			}
			switch ( $args['context'] ) {

				case 'avada':
					$v1 = Avada_Helper::normalize_version( $avada_version );
					$v2 = Avada_Helper::normalize_version( $args['version'] );
					if ( version_compare( $v1, $v2, '==' ) ) {
						$patches[ $args['context'] ][ $args['path'] ] = $args['reference'];
					}
					break;
				case 'fusion-core':
					$v1 = Avada_Helper::normalize_version( $fusion_core_version );
					$v2 = Avada_Helper::normalize_version( $args['version'] );
					if ( version_compare( $v1, $v2, '==' ) ) {
						$patches[ $args['context'] ][ $args['path'] ] = $args['reference'];
					}
					break;
				case 'fusion-builder':
					$v1 = Avada_Helper::normalize_version( $fusion_builder_version );
					$v2 = Avada_Helper::normalize_version( $args['version'] );
					if ( version_compare( $v1, $v2, '==' ) ) {
						$patches[ $args['context'] ][ $args['path'] ] = $args['reference'];
					}
					break;

			}
		}
		return base64_encode( wp_json_encode( $patches ) );
	}
}
