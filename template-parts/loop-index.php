<?php

$blog_style = terminus_get_option('blog_style', 'blog-big-thumbs');
$columns = terminus_get_option( 'blog_columns', 3 );

$this_post = array();
$this_post['post_id'] = $id = get_the_ID();
$this_post['url'] = $link = get_permalink();
$this_post['title'] = $title = get_the_title();
$this_post['post_format'] = $format = get_post_format() ? get_post_format() : 'standard';
$this_post['image_size'] = terminus_blog_alias( $format, '', $blog_style, 'layout_4', $columns );
$this_post['blog_style'] = $blog_style;
$this_post['content'] = get_the_content();
$this_post = apply_filters( 'terminus-entry-format-'. $format, $this_post );

extract($this_post);

$post_content = has_excerpt() ? get_the_excerpt() : $content;

switch ($blog_style) {
	case 'blog-big-thumbs':
		$excerpt_count_blog = terminus_get_option('excerpt_count_blog_big');
		break;
	case 'blog-small-thumbs':
		$excerpt_count_blog = terminus_get_option('excerpt_count_blog_small');
		break;
	case 'blog-grid':
		$excerpt_count_blog = terminus_get_option('excerpt_count_blog_grid');
		break;
	default:
		$excerpt_count_blog = terminus_get_option('excerpt_count_blog');
		break;
}

$classes = array( 'entry', 'entry-' . $blog_style );
?>

<?php $post_formats = array( 'link', 'quote' ); ?>

<div class="isotope_item">

	<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

	<article id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', $classes ) ); ?>>

		<!-- - - - - - - - - - - - - - Entry Header - - - - - - - - - - - - - - - - -->

		<header class="entry_header">

			<?php echo terminus_blog_post_meta($id); ?>

			<?php if ( !in_array($format, $post_formats) ): ?>

				<h1 class="entry_title">
					<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
				</h1>

			<?php endif; ?>

		</header><!--/ .entry_header-->

		<!-- - - - - - - - - - - - - - End of Entry Header - - - - - - - - - - - - - - - - -->

		<div class="entry-extra">

			<!-- - - - - - - - - - - - - - Entry Media - - - - - - - - - - - - - - - - -->

			<?php if ( !empty($before_content)): ?>

				<div class="entry-media">
					<?php echo sprintf('%s', $before_content) ?>
				</div>

			<?php endif; ?>

			<!-- - - - - - - - - - - - - - End of Entry Media - - - - - - - - - - - - - - - - -->

			<div class="entry-post-content">

				<?php if ( !in_array($format, $post_formats) ): ?>

					<?php
					if ( has_excerpt() ) {
						echo terminus_get_excerpt( $post_content, $excerpt_count_blog, false );
					} else {
						echo '<div class="entry_content">';
						echo apply_filters( 'the_content', $content );
						wp_link_pages(array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'terminus' ) . ':</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '%',
							'separator'   => ''
						));
						echo '</div>';
					}
					?>

				<?php endif; ?>

				<div class="post-buttons">

					<a class="btn rd-grey middle" href="<?php echo esc_url($link) ?>"><?php esc_html_e('Continue Reading', 'terminus') ?></a>

					<?php echo terminus_base_post_share_btn($id); ?>

				</div><!--/ .post-buttons-->

			</div>

		</div><!--/ .entry-extra-->

	</article>

	<!-- - - - - - - - - - - - - - End of Entry - - - - - - - - - - - - - - - - -->

</div><!--/ .isotope_item-->