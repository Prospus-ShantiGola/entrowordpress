<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="wrap about-wrap avada-wrap">
	<?php $this->get_admin_screens_header( 'welcome' ); ?>

	<!-- <p class="about-description"><span class="dashicons dashicons-admin-network avada-icon-key"></span><?php _e( 'Your Purchase Must Be Registered To Receive Theme Support & Auto Updates', 'Avada' ); ?></p> -->
	<div class="feature-section">
		<div class="avada-important-notice">
			<p class="about-description"><?php _e( 'Thank you for choosing Avada! Your product must be registered to receive the Avada demos, auto theme updates and included premium plugins. The instructions below in toggle format must be followed exactly.', 'Avada' ); ?></p>
		</div>

		<div class="avada-important-notice registration-form-container">
			<?php if ( Avada()->registration->is_registered() ) : ?>
				<p class="about-description"><?php _e( 'Congratulations! Your product is registered now.', 'Avada' ); ?></p>
			<?php else : ?>
				<p class="about-description"><?php _e( 'Please enter your Envato token to complete registration.', 'Avada' ); ?></p>
			<?php endif; ?>
			<div class="avada-registration-form">
				<form id="avada_product_registration" method="post" action="options.php">
					<?php
					$invalid_token = false;
					$token = Avada()->registration->get_token();
					settings_fields( Avada()->registration->get_option_group_slug() );
					?>
					<?php if ( $token && ! empty( $token ) ) : ?>
						<?php if ( Avada()->registration->is_registered() ) : ?>
							<span class="dashicons dashicons-yes avada-icon-key"></span>
						<?php else : ?>
							<?php $invalid_token = true; ?>
							<span class="dashicons dashicons-no avada-icon-key"></span>
						<?php endif; ?>
					<?php else : ?>
						<span class="dashicons dashicons-admin-network avada-icon-key"></span>
					<?php endif; ?>
					<input type="text" name="avada_registration[token]" value="<?php echo esc_attr( $token ); ?>" />
					<?php submit_button( esc_attr__( 'Submit', 'Avada' ), array( 'primary', 'large', 'avada-large-button', 'avada-register' ) ); ?>
				</form>
				<?php if ( $invalid_token ) : ?>
					<p class="error-invalid-token"><?php esc_attr_e( 'Invalid token, or corresponding Envato account does not have Avada purchased.', 'Avada' ); ?></p>
				<?php endif; ?>

				<?php if ( ! Avada()->registration->is_registered() ) : ?>

					<div style="font-size:17px;line-height:27px;margin-top:1em;padding-top:1em">
						<hr>

						<h3><?php _e( 'Instructions For Generating A Token', 'Avada' ); ?></h3>
						<ol>
							<li><?php printf( __( 'Click on this <a href="%s" target="_blank">Generate A Personal Token</a> link. <strong>IMPORTANT:</strong> You must be logged into the same Themeforest account that purchased Avada. If you are logged in already, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'Avada' ), 'https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t' ); ?></li>
							<li><?php _e( 'Enter a name for your token, then check the boxes for <strong>View Your Envato Account Username, Download Your Purchased Items, Verify Purchases You\'ve Made</strong> and <strong>List Purchases You\'ve Made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token button</strong>', 'Avada' ); ?></li>
							<li><?php _e( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the <strong>Submit</strong> button.', 'Avada' ); ?></li>
							<li><?php printf( __( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly. You can also view our <a %s>documentation post</a> for various fallback methods.', 'Avada' ), 'href="https://theme-fusion.com/avada-doc/getting-started/how-to-register-your-purchase/" target="_blank"' ); ?></li>
						</ol>

					</div>

				<?php endif; ?>
			</div>
		</div>

	</div>
	<div class="avada-thanks">
		<p class="description"><?php _e( 'Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.', 'Avada' ); ?></p>
	</div>
</div>
