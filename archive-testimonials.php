<?php
/**
 * The template for displaying Testimonials Archive area.
 */

get_header(); ?>

<?php if (have_posts()): ?>

	<?php $title_results = terminus_which_archive(); ?>

	<div class="template-area">

		<?php if (!empty($title_results)): ?>
			<?php echo terminus_title(array('title' => $title_results)) ?>
		<?php endif; ?>

		<div class="testimonials-area">

			<div class="tm-list">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						$id = get_the_ID();
						$thumbnail_atts = array(
							'alt'	=> trim(get_the_excerpt()),
							'title'	=> trim(get_the_title()),
						);
						$content = has_excerpt($id) ? apply_filters('the_excerpt', get_the_excerpt()) : apply_filters('the_content', get_the_content());
					?>

					<div class="tm-item">
						<blockquote class="tm-blockquote">

							<div class="author_info">
								<a href="<?php echo esc_url(get_permalink()) ?>"><b><?php echo get_the_title(); ?></b></a>, <?php echo rwmb_meta( 'terminus_tm_place', '', $id ); ?>
							</div>

							<?php echo do_shortcode($content); ?>

						</blockquote>
					</div><!--/ .tm-item-->

				<?php endwhile; // end of the loop. ?>

			</div><!--/ .tm-grid-->

			<?php echo terminus_pagination(); ?>

		</div><!--/ .testimonials-area-->

	</div><!--/ .template-area-->

<?php endif; ?>

<?php get_footer(); ?>