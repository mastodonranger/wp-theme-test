<?php
/**
 * The template for displaying single testimonials.
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<div class="template-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="row">

				<!-- - - - - - - - - - - - - - Employee's Photo - - - - - - - - - - - - - - - - -->

				<div class="col-sm-4">

					<div class="post-thumbnail">
						<?php the_post_thumbnail( array(360, 360) ); ?>
					</div><!-- .post-thumbnail -->

				</div>

				<!-- - - - - - - - - - - - - - End of Employee's Photo - - - - - - - - - - - - - - - - -->

				<!-- - - - - - - - - - - - - - Employee's Information - - - - - - - - - - - - - - - - -->

				<div class="col-sm-8">

					<h3 class="single-title"><?php the_title() ?></h3>
					<p class="position"><?php echo rwmb_meta( 'terminus_tm_place', '', get_the_ID() ) ?></p>

					<?php terminus_excerpt(); ?>
					<?php terminus_single_social_links(); ?>

				</div>

				<!-- - - - - - - - - - - - - - End of Employee's Information - - - - - - - - - - - - - - - - -->

			</div><!--/ .row -->

			<div class="entry-content">
				<?php echo the_content(); ?>
			</div>

		<?php endwhile ?>

	</div><!--/ .template-single-->

<?php else:

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content', 'none' );

endif; ?>

<?php get_footer(); ?>