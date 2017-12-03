<?php

if (!class_exists('TERMINUS_QUICK_POPUPS')) {

	class TERMINUS_QUICK_POPUPS {

		protected $id;

		function __construct($id) {
			$this->id = $id;
			$this->add_hooks();
		}

		public function add_hooks() {

			remove_action('woocommerce_before_single_product', 'wc_print_notices', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		}

		public function output_quick_view_html() {
			$query = array(
				'post_type' => 'product',
				'post__in' => array($this->id)
			);
			$the_query = new WP_Query( $query );
			?>

			<div class="quick_view_popup popup">

				<a href="javascript:void(0)" class="close arcticmodal-close"></a>

				<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
					<?php wc_get_template_part( 'content', 'single-product' ); ?>
				<?php endwhile; ?>

			</div>

			<?php

		}

		public function output_login_html() { ?>

			<!-- - - - - - - - - - - - - - Login Popup - - - - - - - - - - - - - - - - -->

			<div class="popup login">

				<a href="javascript:void(0)" class="close arcticmodal-close"></a>

				<div class="table_row_xs">

					<div class="col-xs-6">
						<h3><?php esc_html_e( 'Log In', 'terminus' ) ?></h3>
					</div>

					<div class="col-xs-6 align_right">
						<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )) ?>" class="btn rd-grey small">
							<?php esc_html_e( 'Register', 'terminus' ) ?>
						</a>
					</div>

				</div><!--/ .table_row_xs -->

				<div class="popup_inner">

					<form method="post" class="login grey_skin">

						<p class="form-row">
							<input type="text" class="input-text" name="username" id="username" placeholder="<?php esc_html_e( 'Enter your email address *', 'terminus' ) ?>" />
						</p>

						<p class="form-row">
							<input type="password" class="input-text" name="password" id="password" placeholder="<?php esc_html_e( 'Password *', 'terminus' ) ?>" />
						</p>

						<p class="form-row">
							<input name="rememberme" class="small" type="checkbox" id="rememberme" value="forever" />
							<label for="rememberme" class="inline"><?php esc_html_e( 'Remember me', 'terminus' ); ?></label>
						</p>

						<p class="form-row">

							<div class="table_row_xs">

								<div class="col-xs-4">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<input type="submit" class="btn rd-black small" name="login" value="<?php esc_html_e( 'Login', 'terminus' ) ?>" />
								</div>

								<div class="col-xs-8 align_right">
									<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>" class="small_link"><?php esc_html_e( 'Forgot your password?', 'terminus' ) ?></a>
								</div>

							</div><!--/ .table_row_xs -->

						</p>

					</form>

				</div><!--/ .popup_inner -->

			</div>

			<!-- - - - - - - - - - - - - - End of Login Popup - - - - - - - - - - - - - - - - -->

			<?php
		}

	}

}
