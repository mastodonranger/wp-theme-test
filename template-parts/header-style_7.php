<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section middle">

	<div class="sticky_part">

		<div class="container">

			<div class="table_row_md">

				<div class="col-lg-3 col-md-2 col-sm-12">

					<div class="left_edge">

						<!-- - - - - - - - - - - - - - Logo - - - - - - - - - - - - - - - - -->

						<div class="logo_wrap">

							<?php $logo_type = terminus_get_option('logo_type'); ?>

							<?php
							switch ($logo_type) {
								case 'text':
									$logo_text = terminus_get_option('logo_text');

									if (empty($logo_text)) {
										$logo_text = get_bloginfo('name');
									}

									if (!empty($logo_text)): ?>

										<h1 id="logo" class="logo">
											<a title="<?php bloginfo('description'); ?>"
											   href="<?php echo esc_url(home_url('/')); ?>">
												<?php echo html_entity_decode($logo_text); ?>
											</a>
										</h1>

									<?php endif;

									break;
								case 'upload':

									$logo_image = terminus_get_option('logo_image');

									if (!empty($logo_image)) {
										?>

										<a id="logo" class="logo" title="<?php bloginfo('description'); ?>"
										   href="<?php echo esc_url(home_url('/')); ?>">
											<img src="<?php echo esc_attr($logo_image); ?>" alt="<?php bloginfo('description'); ?>"/>
										</a>

										<?php
									}

									break;
							}
							?>

						</div><!--/ .logo_wrap -->

						<!-- - - - - - - - - - - - - - End of Logo - - - - - - - - - - - - - - - - -->

					</div><!--/ .left_edge -->

				</div>

				<div class="col-lg-7 col-md-8 col-sm-9">

					<div class="align_center">

						<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

						<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(); ?></nav>

						<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

					</div><!--/ .align_center -->

				</div>

				<div class="col-md-2 col-sm-3">

					<div class="right_edge">

						<ul class="header_actions">

							<li>

								<?php if ( terminus_is_shop_installed() ): ?>

									<?php $accountPage = get_permalink(get_option('woocommerce_myaccount_page_id')); ?>

									<?php if ( is_user_logged_in() ): ?>

										<a class="link-logout info_link" href="<?php echo wp_logout_url(esc_url(home_url('/'))) ?>">
											<span class="si-icon si-logout"></span>
											<span class="welcome_username">
											<?php esc_html_e('Logout', 'terminus') ?>
										</a>

									<?php else: ?>

										<a class="to-login info_link" data-modal-action="terminus_action_login_popup" data-modal-nonce="<?php echo esc_attr(wp_create_nonce('terminus_action_login_popup')) ?>" data-href="<?php echo esc_url($accountPage) ?>" href="<?php echo esc_url($accountPage); ?>">
											<span class="si-icon si-login"></span><?php esc_html_e('Login', 'terminus'); ?>
										</a>

									<?php endif; ?>

								<?php else: ?>

									<?php if ( is_user_logged_in() ): ?>

										<a class="link-logout info_link" href="<?php echo wp_logout_url(esc_url(home_url('/'))) ?>">
											<span class="si-icon si-logout"></span>
											<span class="welcome_username">
											<?php esc_html_e('Logout', 'terminus') ?>
										</a>

									<?php else: ?>

										<a class="info_link" href="<?php echo esc_url(wp_login_url()); ?>">
											<span class="si-icon si-login"></span><?php esc_html_e('Login', 'terminus'); ?>
										</a>

									<?php endif; ?>

								<?php endif; ?>

							</li>

							<?php if ( terminus_get_option('show_btn_float_aside_type_7') ): ?>
								<li>
									<a class="float_aside_btn" href="javascript:void(0)">
										<span class="si-icon si-icon-menu"></span>
									</a>
								</li>
							<?php endif; ?>

						</ul>

					</div><!--/ .right_edge -->

				</div>

			</div><!--/ .row -->

		</div><!--/ .container -->

	</div><!--/ .sticky_part -->

</div><!--/ .header_section-->

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->