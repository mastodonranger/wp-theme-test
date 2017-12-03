<?php
/**
 * The template for displaying lookbook single posts
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="section-content">

			<article id="<?php echo get_the_ID() ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

			</article>

		</div>

		<!-- - - - - - - - - - - - - - End of Entry Body - - - - - - - - - - - - - - - - -->

		<?php if ( terminus_get_option('blog-single-link-pages') ): ?>
			<div class="section-content">
				<?php get_template_part( 'template-parts/single', 'link-pages' ); ?>
			</div>
		<?php endif; ?>

	<?php endwhile ?>

<?php endif; ?>

<?php get_footer(); ?>