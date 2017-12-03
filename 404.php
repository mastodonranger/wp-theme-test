<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage terminus
 * @since Terminus
 */

get_header(); ?>

	<div class="table_row">

		<div class="col-sm-6">
			<p class="caption_404"><?php esc_html_e('404', 'terminus') ?></p>
		</div>

		<div class="col-sm-6">

			<?php echo html_entity_decode(terminus_get_option('440_content')); ?>

			<!-- - - - - - - - - - - - - - Search Form - - - - - - - - - - - - - - - - -->

			<?php echo get_search_form(); ?>

			<!-- - - - - - - - - - - - - - End of Search Form - - - - - - - - - - - - - - - - -->

			<div class="row">

				<div class="col-sm-4">

					<div class="widget widget_archive">
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
					</div><!--/ .widget -->

				</div>

				<div class="col-sm-4">

					<div class="widget widget_meta">
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<?php wp_meta(); ?>
						</ul>
					</div><!--/ .widget -->

				</div>

				<div class="col-sm-4">

					<div class="widget">
						<?php the_widget( 'WP_Widget_Recent_Posts', array( 'title' => ' ', 'number' => 4 ), array( 'before_title' => '', 'after_title' => '' ) ); ?>
					</div>

				</div>

			</div><!--/ .row -->

		</div>

	</div><!--/ .row -->

<?php get_footer(); ?>