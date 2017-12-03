<?php

if (!class_exists('TERMINUS_TEMPLATES_HOOKS')) {

	class TERMINUS_TEMPLATES_HOOKS {

		function __construct() {
			$this->init();
		}

		public function init() {
			$this->add_hooks();
		}

		public function add_hooks() {

			add_action('terminus_header_layout', array(&$this, 'template_header_layout_hook'));

//			if ( terminus_get_option('cookie_alert') == 'show' ) {
//				if (!self::getcookie('cwallowcookies')) {
//					add_action('wp_enqueue_scripts', array(&$this, 'cookie_alert_enqueue_scripts'), 1);
//					add_action('wp_head', array(&$this, 'top_cookie_alert_localize'), 3);
//					add_action('terminus_body_append', array(&$this, 'top_cookie_alert'));
//				}
//			}

			if ( terminus_get_option('query-loader') ) {
				add_action('terminus_body_append', array( &$this, 'preloader' ));
			}

			add_action( 'terminus_header_after', array( &$this, 'header_after' ) );
			add_action( 'terminus_before_content', array( &$this, 'before_content' ) );

			add_action( 'terminus_footer_in_top_part', array( &$this, 'template_footer_widgets' ) );
		}

		public function header_after() {
			$this->float_aside();
			$this->portfolio_top_image();
			$this->page_title_and_breadcrumbs();
		}

		public function template_header_layout_hook($type) {

			if ( rwmb_meta( 'terminus_coming_soon' ) ) {
				get_template_part( 'template-parts/header', 'coming-soon' );
			} else {
				get_template_part( 'template-parts/header', $type );
			}

		}

		public function template_footer_widgets() {
			get_template_part( 'template-parts/footer', 'widgets' );
		}

		public function before_content() {
			$terminus_post_id = terminus_post_id();
			$terminus_before_content = rwmb_meta( 'terminus_before_content', '', $terminus_post_id ); ?>

			<?php if ( $terminus_before_content && $terminus_before_content > 0 ): ?>

				<?php
				$terminus_page = get_pages(array(
					'include' => $terminus_before_content
				));
				?>

				<?php if ( !empty($terminus_page) ): ?>
					<div class="before-container">
						<?php echo do_shortcode($terminus_page[0]->post_content); ?>
					</div>
				<?php endif; ?>

			<?php endif;

		}

		public function preloader() {
			?><div id="preloader"><div class="la-square-jelly-box"><div></div><div></div></div></div><?php
		}

		public function cookie_alert_enqueue_scripts() {
			wp_enqueue_script( 'terminus_cookiealert' );
		}

		public function top_cookie_alert_localize() {
			wp_localize_script('jquery', 'cwmessageObj', array(
				'cwmessage' => esc_html__("Please note this website requires cookies in order to function correctly, they do not store any specific information about you personally.", 'terminus'),
				'cwagree' => esc_html__("Accept Cookies", 'terminus'),
				'cwmoreinfo' => esc_html__("Read more...", 'terminus'),
				'cwmoreinfohref' => is_ssl() ? "https://" : "http://" . "www.cookielaw.org/the-cookie-law"
			));
		}

		public function top_cookie_alert() {

			$cookie_alert_message = terminus_get_option('cookie_alert_message', esc_html__('Please note this website requires cookies in order to function correctly, they do not store any specific information about you personally.', 'terminus'));
			$cookie_alert_read_more_link = terminus_get_option('cookie_alert_read_more_link');
			?>
			<script type="text/javascript">
				jQuery(document).ready(function () {

					var cwmessageObj = {
						cwmessage: "Please note this website requires cookies in order to function correctly, they do not store any specific information about you personally.",
						cwmoreinfohref: "http://www.cookielaw.org/the-cookie-law"
					}

					<?php if (!empty($cookie_alert_message)): ?>
						cwmessageObj['cwmessage'] = "<?php echo esc_html($cookie_alert_message); ?>";
					<?php endif; ?>

					<?php if (!empty($cookie_alert_read_more_link)): ?>
						cwmessageObj['cwmoreinfohref'] = "<?php echo esc_url($cookie_alert_read_more_link); ?>";
					<?php endif; ?>

					jQuery('body').cwAllowCookies(cwmessageObj);
				});
			</script>
		<?php
		}

		public function float_aside() {

			$header_style = rwmb_meta( 'terminus_header_style', '', terminus_post_id() );

			if ( empty($header_style) ) {
				$header_type = terminus_get_option('header-type');
				if ( absint($header_type) ) {
					$header_style = 'style_' . absint($header_type);
				}
			}

			if ( $header_style == 'style_1' ||
				$header_style == 'style_3' ||
				$header_style == 'style_9' ||
				$header_style == 'style_10' ||
				$header_style == 'style_11'
			) return;

			?>

			<?php if ( is_active_sidebar('aside-panel-widget-area') ): ?>

				<!-- - - - - - - - - - - - - - Float Aside - - - - - - - - - - - - - - - - -->

				<div class="float_aside_overlay">

					<div class="float_aside">

						<!-- - - - - - - - - - - - - - Widget - - - - - - - - - - - - - - - - -->

						<?php dynamic_sidebar('Aside Panel Widget Area'); ?>

						<!-- - - - - - - - - - - - - - End of Widget - - - - - - - - - - - - - - - - -->

					</div>

				</div>

				<!-- - - - - - - - - - - - - - End of Float Aside - - - - - - - - - - - - - - - - -->

			<?php endif;
		}

		public function portfolio_top_image() {
			if ( is_singular('portfolio') ) {
				if ( has_post_thumbnail() ) {
					if ( rwmb_meta('terminus_top_image') ) {
						echo '<div class="folio-top-image">';
						echo TERMINUS_HELPER::get_the_post_thumbnail( get_the_ID(), '1920*500', true, array() );
						echo '</div>';
					}
				}
			}
		}

		public function page_title_and_breadcrumbs() {

			$mode = terminus_page_title_get_value('mode');

			switch ($mode) {
				case 'default':
					$breadcrumb = terminus_get_option('page_title_breadcrumb');
				break;
				case 'custom':
					$breadcrumb = terminus_page_title_get_value('breadcrumb');
				break;
				default:
					$breadcrumb = terminus_get_option('page_title_breadcrumb');
					break;
			}

			if ( $mode == 'none' || is_404() || is_front_page() ) return; ?>

			<div <?php echo Terminus_Page_Title_Config::output_attributes(); ?>>

				<?php echo Terminus_Page_Title_Config::output_type(); ?>

				<div class="container">
					<div class="row">
						<div class="col-xs-12">

							<?php if ( is_page() ): ?>

								<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php if ( terminus_get_option('page_breadcrumbs') ): ?>

									<?php if ( $breadcrumb == 'display' ): ?>

										<nav class="breadcrumbs">
											<?php echo terminus_breadcrumbs(array(
												'separator' => '/'
											)); ?>
										</nav>

									<?php endif; ?>

								<?php endif; ?>

							<?php elseif ( is_post_type_archive('product') || terminus_is_product_category() || terminus_is_product_tag() || is_singular('product') ): ?>

								<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

									<?php if ( is_singular('product') ): ?>

										<?php
										echo terminus_title(array(
											'heading' => 'h1',
											'title' => get_the_title()
										));
										?>

									<?php else: ?>

										<?php
										echo terminus_title(array(
											'heading' => 'h1',
											'title' => woocommerce_page_title(false)
										));
										?>

									<?php endif; ?>

								<?php endif; ?>

								<?php if ( terminus_get_option('shop_breadcrumbs') ): ?>

									<?php if ( is_post_type_archive('product') || terminus_is_product_category() || terminus_is_product_tag() ): ?>

										<nav class="breadcrumbs">
											<?php woocommerce_breadcrumb(array(
												'delimiter' => ' / '
											)); ?>
										</nav>

									<?php elseif ( is_singular('product') ): ?>

										<?php if ( $breadcrumb == 'display' ): ?>

											<nav class="breadcrumbs">
												<?php woocommerce_breadcrumb(array(
													'delimiter' => ' / '
												)); ?>
											</nav>

										<?php endif; ?>

									<?php endif; ?>

								<?php endif; ?>

							<?php elseif ( is_singular('portfolio') ): ?>

								<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php if ( $breadcrumb == 'display' ): ?>

									<nav class="breadcrumbs">
										<?php echo terminus_breadcrumbs(array(
											'separator' => '/'
										)); ?>
									</nav>

								<?php endif; ?>

							<?php elseif ( is_singular('testimonials') ): ?>

								<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php if ( terminus_get_option('single_testimonials_breadcrumbs') ): ?>

									<?php if ( $breadcrumb == 'display' ): ?>

										<nav class="breadcrumbs">
											<?php echo terminus_breadcrumbs(array(
												'separator' => '/'
											)); ?>
										</nav>

									<?php endif; ?>

								<?php endif; ?>

								<?php echo terminus_single_page_links(); ?>

							<?php elseif ( is_singular('team-members') ): ?>

								<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php if ( terminus_get_option('single_team_members_breadcrumbs') ): ?>

									<?php if ( $breadcrumb == 'display' ): ?>

										<nav class="breadcrumbs">
											<?php echo terminus_breadcrumbs(array(
												'separator' => '/'
											)); ?>
										</nav>

									<?php endif; ?>

								<?php endif; ?>

								<?php echo terminus_single_page_links(); ?>

							<?php elseif ( is_single() ): ?>

								<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php if ( terminus_get_option('single_breadcrumbs') ): ?>

									<?php if ( $breadcrumb == 'display' ): ?>

										<nav class="breadcrumbs">
											<?php echo terminus_breadcrumbs(array(
												'separator' => '/'
											)); ?>
										</nav>

									<?php endif; ?>

								<?php endif; ?>

							<?php else: ?>

								<?php if ( is_archive() ): ?>

									<?php
									echo terminus_title(
										array(
											'title' => get_the_archive_title(),
											'subtitle' => get_the_archive_description(),
											'heading' => 'h1'
										));
									?>

									<?php if ( terminus_get_option('single_breadcrumbs') ): ?>

										<?php if ( $breadcrumb == 'display' ): ?>

											<nav class="breadcrumbs">
												<?php echo terminus_breadcrumbs(array(
													'separator' => '/'
												)); ?>
											</nav>

										<?php endif; ?>

									<?php endif; ?>

								<?php else: ?>

									<?php echo terminus_title(array( 'heading' => 'h1' )); ?>

								<?php endif; ?>

							<?php endif; ?>

						</div>
					</div><!--/ .row -->
				</div><!--/ .container -->
			</div><!--/ .page_title-->
			<?php
		}

		/* 	Get Cookie
		/* ---------------------------------------------------------------------- */

		public static function getcookie( $name ) {
			if ( isset( $_COOKIE[$name] ) )
				return maybe_unserialize( stripslashes( $_COOKIE[$name] ) );

			return array();
		}

	}

	new TERMINUS_TEMPLATES_HOOKS();
}
