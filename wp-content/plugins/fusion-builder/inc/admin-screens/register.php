<div class="wrap about-wrap fusion-builder-wrap">

	<?php Fusion_Builder_Admin::header(); ?>

	<div class="feature-section">
		<div class="fusion-builder-important-notice">
			<p class="about-description"><?php esc_html_e( 'Thank you for choosing Fusion Builder! Your product must be registered to receive all the included demos and auto theme updates. The instructions below must be followed exactly.', 'fusion-builder' ); ?></p>
		</div>

		<div class="fusion-builder-admin-toggle">
			<div class="fusion-builder-admin-toggle-heading">
				<h3><?php esc_html_e( 'Instructions For Generating A Token', 'fusion-builder' ); ?></h3>
				<span class="fusion-builder-admin-toggle-icon dashicons dashicons-plus"></span>
			</div>
			<div class="fusion-builder-admin-toggle-content">
				<ol>
					<li><?php _e( 'Log into the Themeforest account that purchased Fusion Builder and come back to this area. <strong>This is highly important</strong>.', 'fusion-builder' ); ?></li>
					<li><?php printf( __( 'Click on the <a href="%s" target="_blank">generate a personal token</a> link to be directed to the token creation page.</li>', 'fusion-builder' ), 'https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t' ); ?>
					<li><?php _e( 'Enter a name for your token, then check the boxes for <strong>Download Your Purchased Items, Verify Purchases You\'ve Made</strong> and <strong>List Purchases You\'ve Made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token button</strong>', 'fusion-builder' ); ?></li>
					<li><?php _e( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the <strong>Submit</strong> button.', 'fusion-builder' ); ?></li>
					<li><?php _e( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above corectly.', 'fusion-builder' ); ?></li>
				</ol>
			</div>
		</div>

		<div class="fusion-builder-important-notice registration-form-container">
			<?php if ( ! Fusion_Builder_Admin::token_account_has_builder_purchased() ) : ?>
				<p class="about-description"><?php esc_attr_e( 'Please enter your Envato token to complete registration.', 'fusion-builder' ); ?></p>
			<?php endif; ?>
			<div class="avada-registration-form">
				<form id="avada_product_registration" method="post" action="options.php">
					<?php
					$invalid_token = false;
					$token = envato_market()->get_option( 'token' );
					settings_fields( envato_market()->get_slug() );
					?>
					<?php if ( $token && ! empty( $token ) ) : ?>
						<?php if ( Fusion_Builder_Admin::token_account_has_builder_purchased() ) : ?>
							<span class="dashicons dashicons-yes avada-icon-key"></span>
						<?php else : ?>
							<span class="dashicons dashicons-no avada-icon-key"></span>
							<?php $invalid_token = true; ?>
						<?php endif; ?>
					<?php else : ?>
						<span class="dashicons dashicons-admin-network avada-icon-key"></span>
					<?php endif; ?>
					<input type="text" name="envato_market[token]" value="<?php echo esc_attr( $token ); ?>" />
					<?php submit_button( esc_attr__( 'Submit', 'fusion-builder' ), array( 'primary', 'large', 'avada-large-button', 'avada-register' ) ); ?>
				</form>
				<?php if ( $invalid_token ) : ?>
					<p class="error-invalid-token"><?php esc_attr_e( 'Invalid token, or account does not have Fusion Builder purchased.', 'fusion-builder' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php Fusion_Builder_Admin::footer(); ?>
</div>
