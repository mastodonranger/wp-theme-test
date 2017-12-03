<?php
/**
* The template for displaying pages
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages and that
* other "pages" on your WordPress site will use a different template.
*
* @package WordPress
* @subpackage Terminus
* @since Terminus 1.0
*/

get_header(); ?>

<!-- - - - - - - - - - - - - Page - - - - - - - - - - - - - - - -->

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<div class="entry_content">

			<?php the_content(); ?>

			<?php
			$wp_link_pages_args = apply_filters('terminus_wp_link_pages_args', array(
				'before' =>'<nav class="pagination-split-post">',
				'after'  =>'</nav>',
				'pagelink' => '<span>%</span>',
				'separator' => ' '
			));
			wp_link_pages($wp_link_pages_args);
			?>

		</div>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	endwhile; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>

<!-- - - - - - - - - - - - -/ Page - - - - - - - - - - - - - - -->


<?php get_footer(); ?>

