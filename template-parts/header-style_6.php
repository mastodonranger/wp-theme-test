
<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section">

	<div class="fw_row">

		<div class="col-lg-10 col-lg-offset-1 pseudo_container">

			<div class="table_row">

				<div class="col-sm-6">

					<div class="left_edge">

						<ul class="h_info_list">

							<?php if (terminus_get_option('show_call_us_type_6', 1)): ?>
								<li><?php esc_html_e('Call Us', 'terminus') ?>: <b><?php echo terminus_get_option('call_us_type_6', '800-987-65-43'); ?></b></li>
							<?php endif; ?>

							<?php if (terminus_get_option('show_email_type_6', 1)): ?>
								<?php $email = terminus_get_option('email_us_type_6', 'info@companyname.com') ?>
								<li><?php esc_html_e('Email', 'terminus') ?>: <a href="mailto:<?php echo antispambot($email, 1); ?>"><b><?php echo esc_html($email) ?></b></a></li>
							<?php endif; ?>

						</ul>

					</div><!--/ .left_edge -->

				</div>

				<div class="col-sm-6">

					<div class="right_edge">

						<?php if ( terminus_get_option('show_social_links_type_6', 1) ): ?>
							<?php echo terminus_header_social_links(); ?>
						<?php endif; ?>

					</div><!--/ .right_edge -->

				</div>

			</div><!--/ .row -->

		</div><!--/ .container -->

	</div><!--/ .fw_row -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section middle">

	<div class="sticky_part">

		<div class="fw_row">

			<div class="col-lg-10 col-lg-offset-1 pseudo_container">

				<div class="table_row">

					<div class="col-md-3 col-sm-2">

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

										$logo_image = terminus_get_option('logo_image_second');

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

					<div class="col-md-9 col-sm-10">

						<div class="right_edge">

							<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

							<nav class="nav_wrap">
								<?php echo TERMINUS_HELPER::main_navigation(); ?>
							</nav>

							<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

							<ul class="header_actions">

								<?php if ( terminus_get_option('show_search_type_6') ): ?>
									<li><?php echo terminus_base_search_btn(); ?></li>
								<?php endif; ?>

								<?php if ( terminus_get_option('show_btn_float_aside_type_6') ): ?>
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

		</div><!--/ .fw_row -->

	</div><!--/ .sticky_part -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->