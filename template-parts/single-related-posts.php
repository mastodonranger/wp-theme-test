<?php
$this_id = get_the_ID();
$tag_ids = array();
$tags = wp_get_post_terms($this_id, 'post_tag');

if (!empty($tags) && is_array($tags)) {

	$post_count = terminus_get_option('related_posts_count');

	$query = array(
		'post_type' => 'post',
		'numberposts' => $post_count,
		'ignore_sticky_posts'=> 1,
		'post__not_in' => array($this_id)
	);

	foreach ($tags as $tag) {
		$tag_ids[] = (int) $tag->term_id;
	}

	if (!empty($tag_ids)) {
		$query['tag__in'] = $tag_ids;

		$entries = get_posts($query);

		switch ($post_count) {
			case 3: $class_count = 'posts-count-3'; break;
			case 6: $class_count = 'posts-count-6'; break;
			case 9: $class_count = 'posts-count-9'; break;
			default:  $class_count = 'posts-count-3'; break;
		}
		?>

		<?php if ( !empty($entries) ): ?>

			<h4><?php esc_html_e('Related Posts', 'terminus'); ?></h4>

			<div class="related_posts inline_posts <?php echo esc_attr($class_count) ?>">

				<?php foreach($entries as $post): setup_postdata($post); ?>

					<?php
						$id = get_the_ID();
						$post_class = "entry";
						$comments_count = get_comments_number();
						$link = get_permalink();
						$title = get_the_title();
					?>

					<article <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">

						<!-- - - - - - - - - - - - - - Entry Image - - - - - - - - - - - - - - - - -->

						<?php if ( has_post_thumbnail() ):
							$thumbnail_atts = array(
								'alt'	=> trim(strip_tags(get_the_excerpt())),
								'title'	=> trim(strip_tags(get_the_title()))
							);
							?>

							<div class="entry_image">
								<a href="<?php esc_url(the_permalink()) ?>" title="<?php the_title(); ?>" class="lightbox-added">
									<?php echo TERMINUS_HELPER::get_the_post_thumbnail( $id, '100*100', true, $thumbnail_atts ); ?>
								</a>
							</div>

						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Entry Image - - - - - - - - - - - - - - - - -->

						<!-- - - - - - - - - - - - - - Entry Body - - - - - - - - - - - - - - - - -->

						<div class="entry_body">
							<ul class="byline">
								<?php
									$time_string = '<time datetime="%1$s">%2$s</time>';
									$time_string = sprintf( $time_string,
										esc_attr( get_the_date( 'c' ) ),
										get_the_date('j F Y')
									);
									printf( '<li>%1$s </li>', $time_string );
								?>
							</ul>
							<h6 class="entry_title"><a href="<?php esc_url(the_permalink()) ?>"><?php the_title(); ?></a></h6>
						</div>

						<!-- - - - - - - - - - - - - - End of Entry Body - - - - - - - - - - - - - - - - -->

					</article><!--/ .entry-->

				<?php endforeach; ?>

			</div><!--/ .related_posts-->

			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	<?php
	}
}