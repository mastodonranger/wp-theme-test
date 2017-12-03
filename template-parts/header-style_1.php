	<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

	<div class="header_section middle">

		<div class="sticky_part">

			<div class="container">

				<div class="table_row">

					<div class="col-sm-3">

						<div class="left_edge">

							<!-- - - - - - - - - - - - - - Logo - - - - - - - - - - - - - - - - -->

							<div class="logo_wrap">

								<?php $logo_type = terminus_get_option('logo_type'); ?>

								<?php
								switch ($logo_type) {
									case 'text':
										$logo_text = terminus_get_option('logo_text');

										if ( empty($logo_text) ) {
											$logo_text = get_bloginfo('name');
										}

										if ( !empty($logo_text) ): ?>

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

										if ( !empty($logo_image) ) {
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

					<div class="col-sm-9">

						<div class="right_edge">

							<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

							<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(); ?></nav>

							<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

						</div><!--/ .right_edge -->

					</div>

				</div><!--/ .row -->

			</div><!--/ .container -->

		</div><!--/ .sticky_part -->

	</div><!--/ .header_section-->

	<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->