
<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section middle">

	<div class="sticky_part">

		<div class="table_row fw_row">

			<div class="col-sm-2">

				<div class="left_edge">

					<!-- - - - - - - - - - - - - - Logo - - - - - - - - - - - - - - - - -->

					<div class="logo_wrap">

						<?php $logo_type = terminus_get_option('logo_type'); ?>

						<?php
						switch ( $logo_type ) {
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

								$logo_image = terminus_get_option('logo_image_second');

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

			<div class="col-sm-8">

				<div class="align_center">

					<!-- - - - - - - - - - - - - - Main Navigation - - - - - - - - - - - - - - - - -->

					<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(); ?></nav>

					<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

				</div><!--/ .align_center -->

			</div>

			<div class="col-sm-2">

				<div class="right_edge">

					<ul class="header_actions">

						<li>

							<!-- - - - - - - - - - - - - - Shopping Cart - - - - - - - - - - - - - - - - -->

							<?php if ( defined('TERMINUS_WOO_CONFIG') ): ?>

								<?php if ( terminus_get_option('show_cart_type_8') ):
									global $woocommerce;
									$count = count( $woocommerce->cart->get_cart() );
									?>

									<div class="dropdown_wrap sc_wrap">

										<a href="javascript:void(0)" id="shopping_cart_btn" class="info_link w_spacing" data-amount="<?php echo esc_attr($count) ?>">
											<span class="si-icon si-icon-bag"></span>
										</a>

										<div class="dropdown shopping_cart">
											<div class="widget_shopping_cart_content"></div>
										</div>

									</div>

								<?php endif; ?>

							<?php endif; ?>

							<!-- - - - - - - - - - - - - - End of Shopping Cart - - - - - - - - - - - - - - - - -->

						</li>

						<?php if ( terminus_get_option('show_btn_float_aside_type_8') ): ?>
							<li>
								<a class="float_aside_btn" href="javascript:void(0)">
									<span class="si-icon si-icon-menu"></span>
								</a>
							</li>
						<?php endif; ?>

					</ul>

				</div>

			</div>

		</div><!--/ .row -->

	</div><!--/ .sticky_part -->

</div>

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->