<?php
$sidebar_position = TERMINUS_HELPER::template_layout_class('sidebar_position');
?>

			<?php if ( $sidebar_position != 'no_sidebar' ): ?>

				</main><!--/ #main-->

				<?php get_sidebar(); ?>

					</div><!--/ .row-->
				</div><!--/ .container-->

			<?php else: ?>

						</div><!--/ .col-sm-12-->
					</div><!--/ .row-->
				</div><!--/ .container-->

			<?php endif; ?>

			<?php if ( is_singular('portfolio') ): ?>

				<!-- - - - - - - - - - - - - - Portfolio Navigation - - - - - - - - - - - - - - - - -->

				<?php
				$terminus_next_post = get_next_post();
				$terminus_prev_post = get_previous_post();
				$terminus_next_post_url = $terminus_prev_post_url = "";
				$terminus_next_post_title = $terminus_prev_post_title = "";

				if ( is_object($terminus_next_post) ) {
					$terminus_next_post_url = get_permalink($terminus_next_post->ID);
					$terminus_next_post_title = $terminus_next_post->post_title;
				}

				if ( is_object($terminus_prev_post) ) {
					$terminus_prev_post_url = get_permalink($terminus_prev_post->ID);
					$terminus_prev_post_title = $terminus_prev_post->post_title;
				}
				?>

				<div class="portfolio_nav_section">

					<div class="container">

						<div class="portfolio_nav">

							<?php if ( !empty($terminus_prev_post_url) ): ?>
								<a href="<?php echo esc_url($terminus_prev_post_url) ?>" class="btn rd-black nav_prev tooltip_container">
									<span class="tooltip top"><?php echo esc_html($terminus_prev_post_title) ?></span>
								</a>
							<?php endif; ?>

							<a href="<?php echo get_post_type_archive_link('portfolio') ?>" class="tooltip_container">
								<span class="si-icon si-icon-portfolio"></span>
								<span class="tooltip top"><?php esc_html_e('Back to Portfolio', 'terminus') ?></span>
							</a>

							<?php if ( !empty($terminus_next_post_url) ): ?>
								<a href="<?php echo esc_url($terminus_next_post_url) ?>" class="btn rd-black nav_next tooltip_container">
									<span class="tooltip top"><?php echo esc_html($terminus_next_post_title) ?></span>
								</a>
							<?php endif; ?>

						</div>

					</div>

				</div><!--/ .portfolio_nav_section-->

				<!-- - - - - - - - - - - - - - End of Portfolio Navigation - - - - - - - - - - - - - - - - -->

				<?php
					if ( is_singular('portfolio') ) {
						$related_items = rwmb_meta( 'terminus_related_items', '', terminus_post_id() );

						if ( !$related_items ) {
							$related_portfolio = new Terminus_Portfolio_Related( terminus_post_id(), array(
								'title' => esc_html__( 'Recent Projects', 'terminus' )
							));
							$related_portfolio->output();
						}
					}
				?>

			<?php endif; ?>

		</div><!--/ .page_wrap -->

		<!-- - - - - - - - - - - -/ Page Content - - - - - - - - - - - - - - -->

			<?php
				/**
				 * terminus_after_content hook
				 *
				 * @hooked terminus_after_content - 10
				 */
				do_action('terminus_after_content');
			?>

		<!-- - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->

		<?php if ( !rwmb_meta( 'terminus_hide_footer', array(), terminus_post_id() ) ): ?>

			<footer id="footer">

				<?php
				/**
				 * terminus_footer_in_top_part hook
				 *
				 * @hooked footer_in_top_part_widgets - 10
				 */

				do_action('terminus_footer_in_top_part');
				?>

				<div class="footer_section copyright">

					<?php $copyright = terminus_get_option('copyright'); ?>

					<?php if ( empty($copyright) ): ?>
						<?php echo terminus_get_option('copyright', "&copy; 2016 " . "<span><a href='" . esc_url( home_url('/') ) . "'>" . ucfirst(get_bloginfo('name')) . "</a>.</span> " . esc_html__('All Rights Reserved.', 'terminus')) ?>
					<?php else: ?>
						<?php echo wp_kses($copyright, array(
							'a' => array(
								'href' => true,
								'title' => true
							),
							'br' => array(),
							'span' => array(),
							'em' => array(),
							'strong' => array()
						)); ?>
					<?php endif; ?>

				</div><!--/ .footer_section -->

			</footer><!--/ #footer-->

		<?php elseif ( rwmb_meta( 'terminus_coming_soon' ) ): ?>

			<footer id="footer">

				<div class="footer_section copyright">

					<?php $copyright = terminus_get_option('copyright'); ?>

					<?php if ( empty($copyright) ): ?>
						<?php echo terminus_get_option('copyright', "&copy; 2016 " . "<span><a href='" . esc_url( home_url('/') ) . "'>" . ucfirst(get_bloginfo('name')) . "</a>.</span> " . esc_html__('All Rights Reserved.', 'terminus')) ?>
					<?php else: ?>
						<?php echo wp_kses($copyright, array(
							'a' => array(
								'href' => true,
								'title' => true
							),
							'br' => array(),
							'span' => array(),
							'em' => array(),
							'strong' => array()
						)); ?>
					<?php endif; ?>

				</div><!--/ .footer_section -->

			</footer><!--/ #footer-->

		<?php endif; ?>

		<!-- - - - - - - - - - - - - -/ Footer - - - - - - - - - - - - - - - - -->

	</div><!--/ [layout]-->

</div><!--/ #theme-wrapper-->

<?php wp_footer(); ?>

</body>
</html>