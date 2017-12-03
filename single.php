<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		global $post;
		$this_post = array();
		$this_post['post_id'] = $this_id = get_the_ID();
		$this_post['post_format'] = $format = get_post_format($this_id) ? get_post_format($this_id) : 'standard';
		$this_post['content'] = get_the_content();
		$this_post['url'] = $link = get_permalink($this_id);
		$this_post = apply_filters( 'terminus-entry-format-single', $this_post );
		extract($this_post);
		?>

		<div class="section-offset moderate">

			<article id="<?php echo get_the_ID() ?>" <?php post_class('entry'); ?>>

				<?php echo terminus_blog_post_meta( $this_id ); ?>

				<?php echo ( !empty($before_content) ) ? $before_content : ''; ?>
				<?php echo ( !empty($content) ) ? apply_filters('the_content', $content) : ''; ?>

				<?php
				$wp_link_pages_args = apply_filters('terminus_wp_link_pages_args', array(
					'before' =>'<nav class="pagination-split-post">',
					'after'  =>'</nav>',
					'pagelink' => '<span>%</span>',
					'separator' => ' '
				));
				wp_link_pages($wp_link_pages_args);
				?>

			</article><!--/ .entry-->

		</div><!--/ .section-offset-->

		<!-- - - - - - - - - - - - - - End of Entry Body - - - - - - - - - - - - - - - - -->

		<?php if (terminus_get_option('blog-single-tags-and-share')): ?>
			<?php get_template_part( 'template-parts/single', 'tags' ); ?>
		<?php endif; ?>

		<?php if (terminus_get_option('blog-single-link-pages')): ?>
			<div class="section-offset">
				<?php get_template_part( 'template-parts/single', 'link-pages' ); ?>
			</div>
		<?php endif; ?>

		<?php if (terminus_get_option('blog-single-meta-author')): ?>
			<div class="section-offset">
				<?php get_template_part( 'template-parts/single', 'author-box' ); ?>
			</div>
		<?php endif; ?>

		<?php if (terminus_get_option('blog-single-related-posts')): ?>
			<div class="section-offset">
				<?php get_template_part( 'template-parts/single', 'related-posts' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( comments_open() || '0' != get_comments_number() ): ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	<?php endwhile ?>

<?php endif; ?>

<?php get_footer(); ?>