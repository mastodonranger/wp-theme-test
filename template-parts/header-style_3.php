
<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section middle">

	<div class="sticky_part">

		<div class="fw_row">

			<div class="col-xs-12">

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

										$logo_image = terminus_get_option('logo_image');
										$logo_image_second = terminus_get_option('logo_image_second');

										if (!empty($logo_image_second)) {
											?>

											<a class="dark_logo" title="<?php bloginfo('description'); ?>"
											   href="<?php echo esc_url(home_url('/')); ?>">
												<img src="<?php echo esc_attr($logo_image_second); ?>" alt="<?php bloginfo('description'); ?>"/>
											</a>

											<?php
										}

										if (!empty($logo_image)) {
											?>

											<a class="logo" title="<?php bloginfo('description'); ?>"
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

							<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(array('navigation', 'one_page'), 'onepage'); ?></nav>

							<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

						</div><!--/ .right_edge -->

					</div>

				</div><!--/ .table_row -->

			</div>

		</div><!--/ .fw_row -->

	</div><!--/ .sticky_part -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->