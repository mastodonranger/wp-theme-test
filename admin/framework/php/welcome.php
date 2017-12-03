<div class="wrap about-wrap">

    <h1><?php esc_html_e( 'Welcome to Terminus!', 'terminus' ); ?></h1>

    <div class="about-text"><?php echo esc_html__( 'Terminus is now installed and ready to use!', 'terminus' ); ?></div>

	<div class="mad-logo"></div>

    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "Welcome", 'terminus' ) );
        ?>
    </h2>

    <div class="mad-section">

		<div class="mad-notice">

			<?php if ( Terminus()->registration->is_registered() ) : ?>
				<p class="about-description"><?php esc_html_e( 'Congratulations! Your theme is registered now.', 'terminus' ); ?></p>
			<?php else : ?>
				<p class="about-description"><?php esc_html_e( 'Please enter your Envato token to complete registration.', 'terminus' ); ?></p>
			<?php endif; ?>

			<div class="mad-registration-form">

				<form id="gatsby_product_registration" method="post" action="options.php">
					<?php
					$invalid_token = false;
					$token = Terminus()->registration->get_token();
					settings_fields( Terminus()->registration->get_option_group_slug() );
					?>
					<?php if ( $token && ! empty( $token ) ) : ?>
						<?php if ( Terminus()->registration->is_registered() ) : ?>
							<span class="dashicons dashicons-yes"></span>
						<?php else : ?>
							<?php $invalid_token = true; ?>
							<span class="dashicons dashicons-no"></span>
						<?php endif; ?>
					<?php else : ?>
						<span class="dashicons dashicons-admin-network"></span>
					<?php endif; ?>
					<input type="text" name="terminus_registration[token]" value="<?php echo esc_attr( $token ); ?>" />
					<?php submit_button( esc_attr__( 'Submit', 'terminus' ), array( 'primary', 'large' ) ); ?>
				</form>

				<?php if ( $invalid_token ) : ?>
					<p class="error-invalid-token"><?php esc_attr_e( 'Invalid token, or corresponding Envato account does not have Terminus purchased.', 'terminus' ); ?></p>
				<?php endif; ?>

				<?php if ( ! Terminus()->registration->is_registered() ) : ?>

					<div class="mad-infotext">

						<h3><?php esc_html_e( 'Instructions For Generating A Token', 'terminus' ); ?></h3>
						<ol>
							<li><?php printf( __( 'Click on this <a href="%s" target="_blank">Generate A Personal Token</a> link. <strong>IMPORTANT:</strong> You must be logged into the same Themeforest account that purchased Terminus. If you are logged in already, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'terminus' ), 'https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t' ); ?></li>
							<li><?php printf( __( 'Enter a name for your token, then check the boxes for %s and %s from the permissions needed section. Check the box to agree to the terms and conditions, then click the %s', 'terminus' ), '<strong>View Your Envato Account Username, Download Your Purchased Items, List Purchases You\'ve Made</strong>', '<strong>Verify Purchases You\'ve Made</strong>', '<strong>Create Token button</strong>' ); ?></li>
							<li><?php printf( __( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the %s button.', 'terminus' ), '<strong>Submit</strong>' ); ?></li>
							<li><?php esc_html_e( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly.', 'terminus' ); ?></li>
						</ol>

					</div>

				<?php endif; ?>

			</div>

		</div>

    </div>

</div>