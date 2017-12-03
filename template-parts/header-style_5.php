<!-- - - - - - - - - - - - - - Sticky Part - - - - - - - - - - - - - - - - -->

<div class="header_section sticky_part">

	<div class="container">

		<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

		<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation() ?></nav>

		<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

	</div><!--/ .container -->

</div>

<!-- - - - - - - - - - - - - - End of Sticky Part - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section large">

	<div class="container">

		<div class="table_row">

			<!-- - - - - - - - - - - - - - Language & Currency Settings - - - - - - - - - - - - - - - - -->

			<div class="col-sm-4">

				<div class="left_edge">

					<?php if ( terminus_get_option('show_social_links_type_5', 1) ): ?>
						<?php echo terminus_header_social_links(); ?>
					<?php endif; ?>

				</div><!--/ .left_edge-->

			</div>

			<!-- - - - - - - - - - - - - - End of Language & Currency Settings - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Logo Section - - - - - - - - - - - - - - - - -->

			<div class="col-sm-4">

				<div class="align_center">

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

				</div><!--/ .align_center -->

			</div>

			<!-- - - - - - - - - - - - - - End of Logo Section - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Search & Subnavigation - - - - - - - - - - - - - - - - -->

			<div class="col-sm-4">

				<div class="right_edge">

					<ul class="header_actions">

						<?php if ( terminus_get_option('show_search_type_5') ): ?>
							<li><?php echo terminus_base_search_btn(); ?></li>
						<?php endif; ?>

						<?php if ( terminus_get_option('show_btn_float_aside_type_5') ): ?>
							<li>
								<a class="float_aside_btn" href="javascript:void(0)">
									<span class="si-icon si-icon-menu"></span>
								</a>
							</li>
						<?php endif; ?>

					</ul>

				</div><!--/ .right_edge -->

			</div>

			<!-- - - - - - - - - - - - - - End of Search & Subnavigation - - - - - - - - - - - - - - - - -->

		</div><!--/ .row -->

	</div><!--/ .container -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->
