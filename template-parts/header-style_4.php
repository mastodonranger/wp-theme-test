
<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section">

	<div class="container">

		<div class="table_row">

			<!-- - - - - - - - - - - - - - Login & Call Us Box - - - - - - - - - - - - - - - - -->

			<div class="col-sm-5">

				<div class="left_edge">

					<ul class="h_info_list">

						<li>

							<?php if ( terminus_is_shop_installed() ): ?>

								<?php $accountPage = get_permalink(get_option('woocommerce_myaccount_page_id')); ?>

								<?php if ( is_user_logged_in() ): ?>

									<a class="link-logout info_link" href="<?php echo wp_logout_url(esc_url(home_url('/'))) ?>">
										<span class="si-icon si-logout"></span><?php esc_html_e('Logout', 'terminus') ?>
									</a>

								<?php else: ?>

									<a class="to-login info_link" data-modal-action="terminus_action_login_popup" data-modal-nonce="<?php echo esc_attr(wp_create_nonce('terminus_action_login_popup')) ?>" data-href="<?php echo esc_url($accountPage) ?>" href="<?php echo esc_url($accountPage); ?>">
										<span class="si-icon si-login"></span><?php esc_html_e('Login', 'terminus'); ?>
									</a>

								<?php endif; ?>

							<?php else: ?>

								<?php if ( is_user_logged_in() ): ?>

									<a class="link-logout info_link" href="<?php echo wp_logout_url(esc_url(home_url('/'))) ?>">
										<span class="si-icon si-logout"></span><?php esc_html_e('Logout', 'terminus') ?>
									</a>

								<?php else: ?>

									<a class="info_link" href="<?php echo esc_url(wp_login_url()); ?>">
										<span class="si-icon si-login"></span><?php esc_html_e('Login', 'terminus'); ?>
									</a>

								<?php endif; ?>

							<?php endif; ?>

						</li>

						<?php if (terminus_get_option('show_call_us_type_4', 1)): ?>
							<li><?php esc_html_e('Call Us', 'terminus') ?>: <b><?php echo terminus_get_option('call_us_type_4', '800-987-65-43'); ?></b></li>
						<?php endif; ?>

					</ul>

				</div><!--/ .left_edge -->

			</div>

			<!-- - - - - - - - - - - - - - End of Login & Call Us Box - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Subnavigation - - - - - - - - - - - - - - - - -->

			<div class="col-sm-7">

				<div class="right_edge">
					<?php echo TERMINUS_HELPER::main_navigation('sub_nav', 'topbar'); ?>
				</div><!--/ .right_edge -->

			</div>

			<!-- - - - - - - - - - - - - - End of Subnavigation - - - - - - - - - - - - - - - - -->

		</div><!--/ .row -->

	</div><!--/ .container -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section large">

	<div class="container">

		<div class="table_row">

			<!-- - - - - - - - - - - - - - Language & Currency Settings - - - - - - - - - - - - - - - - -->

			<div class="col-sm-3">

				<div class="left_edge">

					<ul class="site_settings">

						<!-- - - - - - - - - - - - - - Language Section - - - - - - - - - - - - - - - - -->

						<?php if ( defined('ICL_LANGUAGE_CODE') ): ?>
							<?php if ( terminus_get_option('show_language_type_4') ): ?>
								<?php echo TERMINUS_WC_WPML_CONFIG::wpml_header_languages_list(); ?>
							<?php endif; ?>
						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Language Section - - - - - - - - - - - - - - - - -->

						<!-- - - - - - - - - - - - - - Currency Section - - - - - - - - - - - - - - - - -->

						<?php if ( defined('TERMINUS_WOO_CONFIG') ): ?>
							<?php if ( terminus_get_option('show_currency_type_4') ): ?>
								<?php echo TERMINUS_WC_CURRENCY_SWITCHER::output_switcher_html(); ?>
							<?php endif; ?>
						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Currency Section - - - - - - - - - - - - - - - - -->

					</ul>

				</div><!--/ .right_edge -->

			</div>

			<!-- - - - - - - - - - - - - - End of Language & Currency Settings - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Logo Section - - - - - - - - - - - - - - - - -->

			<div class="col-sm-6">

				<div class="logo_wrap align_center">

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

			</div>

			<!-- - - - - - - - - - - - - - End of Logo Section - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Language & Currency Settings - - - - - - - - - - - - - - - - -->

			<div class="col-sm-3">

				<div class="right_edge">

					<ul class="header_actions">

						<li>

							<!-- - - - - - - - - - - - - - Searchform - - - - - - - - - - - - - - - - -->

							<?php if ( terminus_get_option('show_search_type_4') ): ?>
								<?php echo terminus_base_search_btn(); ?>
							<?php endif; ?>

							<!-- - - - - - - - - - - - - - End of Searchform - - - - - - - - - - - - - - - - -->

						</li>

						<?php if ( defined('TERMINUS_WOO_CONFIG') ): ?>

							<?php if ( terminus_get_option('show_cart_type_4') ):
								global $woocommerce;
								$count = count( $woocommerce->cart->get_cart() ); ?>

								<li>

									<!-- - - - - - - - - - - - - - Shopping Cart - - - - - - - - - - - - - - - - -->

									<div class="dropdown_wrap sc_wrap">

										<a href="javascript:void(0)" id="shopping_cart_btn" class="info_link w_spacing" data-amount="<?php echo esc_attr($count) ?>">
											<span class="si-icon si-icon-bag"></span>
										</a>

										<div class="dropdown shopping_cart">
											<div class="widget_shopping_cart_content"></div>
										</div>

									</div>

									<!-- - - - - - - - - - - - - - End of Shopping Cart - - - - - - - - - - - - - - - - -->

								</li>

							<?php endif; ?>

						<?php endif; ?>

						<?php if ( terminus_get_option('show_btn_float_aside_type_4') ): ?>
							<li>
								<a class="float_aside_btn" href="javascript:void(0)">
									<span class="si-icon si-icon-menu"></span>
								</a>
							</li>
						<?php endif; ?>

					</ul>

				</div><!--/ .left_edge -->

			</div>

			<!-- - - - - - - - - - - - - - End of Language & Currency Settings - - - - - - - - - - - - - - - - -->

		</div><!--/ .row -->

	</div><!--/ .container -->

</div><!--/ .header_section-->

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Sticky Part - - - - - - - - - - - - - - - - -->

<div class="sticky_part header_section">

	<div class="container">

		<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

		<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(); ?></nav>

		<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

	</div><!--/ .container -->

</div><!--/ .sticky_part -->

<!-- - - - - - - - - - - - - - End of Sticky Part - - - - - - - - - - - - - - - - -->
