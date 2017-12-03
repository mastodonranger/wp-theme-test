<!-- - - - - - - - - - - - - - Special Message - - - - - - - - - - - - - - - - -->

<?php if (terminus_get_option('show_special_message_type_2')): ?>

	<div class="special_message">
		<?php echo terminus_get_option('header_banner_text', html_entity_decode(esc_html__("<b>Free Shipping On Orders Over $99!</b> <a href='#'>Click Here For Details</a>", 'terminus'))); ?>
		<a href="javascript:void(0)" class="close"></a>
	</div><!--/ .special_message-->

<?php endif; ?>

<!-- - - - - - - - - - - - - - End of Special Message - - - - - - - - - - - - - - - - -->


<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section">

	<!-- - - - - - - - - - - - - - Site Settings - - - - - - - - - - - - - - - - -->

	<ul class="alignleft h_info_list">

		<!-- - - - - - - - - - - - - - Language Section - - - - - - - - - - - - - - - - -->

		<?php if ( defined('ICL_LANGUAGE_CODE') ): ?>
			<?php if (terminus_get_option('show_language_type_2')): ?>
				<?php echo TERMINUS_WC_WPML_CONFIG::wpml_header_languages_list(); ?>
			<?php endif; ?>
		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Language Section - - - - - - - - - - - - - - - - -->

		<!-- - - - - - - - - - - - - - Currency Section - - - - - - - - - - - - - - - - -->

		<?php if ( defined('TERMINUS_WOO_CONFIG') ): ?>
			<?php if ( terminus_get_option('show_currency_type_2') ): ?>
				<?php echo TERMINUS_WC_CURRENCY_SWITCHER::output_switcher_html(); ?>
			<?php endif; ?>
		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Currency Section - - - - - - - - - - - - - - - - -->

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

		<?php if (terminus_get_option('show_call_us_type_2', 1)): ?>
			<li><?php esc_html_e('Call Us', 'terminus') ?>: <b><?php echo terminus_get_option('call_us_type_2', '800-987-65-43'); ?></b></li>
		<?php endif; ?>

	</ul><!--/ .h_info_list-->

	<!-- - - - - - - - - - - - - - End of Site Settings - - - - - - - - - - - - - - - - -->

	<!-- - - - - - - - - - - - - - Customer's Products  - - - - - - - - - - - - - - - - -->

	<ul class="alignright h_info_list">

		<?php if ( terminus_get_option('show_wishlist_type_2') ): ?>

			<?php if (defined('YITH_WCWL') && defined('TERMINUS_WOO_CONFIG')):
				$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
				$wishlist_count = YITH_WCWL()->count_products();
				$wishlist_active = '';

				if (is_page($wishlist_page_id)) $wishlist_active = 'active';
				?>

				<li>
					<a href="<?php echo esc_url(get_permalink($wishlist_page_id)); ?>" class="info_link <?php echo esc_attr($wishlist_active); ?>" data-amount="<?php echo esc_attr($wishlist_count) ?>">
						<span class="si-icon si-icon-heart"></span><?php esc_html_e('Wishlist', 'terminus'); ?>
					</a>
				</li>

			<?php endif; ?>

		<?php endif; ?>

		<?php if ( terminus_get_option('show_compare_type_2') ):
			$view_compare = '';
			$count_compare = 0;

			if (defined('YITH_WOOCOMPARE') && defined('TERMINUS_WOO_CONFIG')):
				global $yith_woocompare;
				$count_compare = count($yith_woocompare->obj->products_list);
				?>

			<li class="product">
				<a href="<?php echo esc_url(add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() )) ?>" class="compare added info_link" data-amount="<?php echo esc_html($count_compare) ?>">
					<span class="si-icon si-icon-compare"></span>
					<?php esc_html_e('Compare', 'terminus') ?>
				</a>
			</li>

			<?php endif; ?>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - Shopping Cart  - - - - - - - - - - - - - - - - -->

		<?php if ( defined('TERMINUS_WOO_CONFIG') ): ?>

			<?php if (terminus_get_option('show_cart_type_2')):
				global $woocommerce;
				$count = count( $woocommerce->cart->get_cart() );
			?>

				<li>

					<div class="dropdown_wrap sc_wrap">

						<a href="javascript:void(0)" id="shopping_cart_btn" class="info_link" data-amount="<?php echo esc_attr($count) ?>">
							<span class="si-icon si-icon-bag"></span><?php esc_html_e('Cart', 'terminus') ?>
						</a>

						<div class="dropdown shopping_cart">
							<div class="widget_shopping_cart_content"></div>
						</div>

					</div>

				</li>

			<?php endif; ?>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Shopping Cart  - - - - - - - - - - - - - - - - -->

	</ul><!--/ .alignright h_info_list-->

	<!-- - - - - - - - - - - - - - End of Customer's Products - - - - - - - - - - - - - - - - -->

</div><!--/ .header_section-->

<!-- - - - - - - - - - - - - - End of Header Section - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->

<div class="header_section middle">

	<div class="sticky_part">

		<div class="container">

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

						<nav class="nav_wrap"><?php echo TERMINUS_HELPER::main_navigation(); ?></nav>

						<!-- - - - - - - - - - - - - - End of Main Navigation - - - - - - - - - - - - - - - - -->

						<ul class="header_actions">

							<?php if ( terminus_get_option('show_search_type_2') ): ?>
								<li><?php echo terminus_base_search_btn(); ?></li>
							<?php endif; ?>

							<?php if ( terminus_get_option('show_btn_float_aside_type_2') ): ?>
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