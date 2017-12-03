<?php

class WPBakeryShortCode_VC_mad_blog_posts extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'layout' => 'layout_1',
			'first_big_post' => '',
			'blog_style' => 'blog-grid',
			'carousel' => '',
			'category' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'layout_columns' => 3,
			'columns' => 4,
			'items' => 10,
			'items_per_page' => 5,
			'paginate' => 'pagination',
			'css_animation' => '',
			'action' => 'terminus_posts_ajax_isotope_items_more'
		), $atts, 'vc_mad_blog_posts');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {
		$params = $this->atts;

		$query = array(
			'post_type' => 'post',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'ignore_sticky_posts'=> 1,
			'post_status' => array('publish')
		);

		if (!empty($params['category'])) {
			$categories = explode(',', $params['category']);
			$query['category__in'] = $categories;
		}

		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
		$query['paged'] = $paged;

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		$entries = $this->entries;
		$params = $this->atts;

		$post_loop = 1;
		$wrapper_attributes = array();
		$title = !empty($params['title']) ? $params['title'] : '';
		$description = !empty($params['description']) ? $params['description'] : '';

		$tag_title = $title_color = $layout = $first_big_post = $blog_style = $carousel = $layout_columns = $columns = $paginate = $before_content = $css_animation = '';

		extract($params);

		$atts = array(
			'columns' => $columns,
			'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
		);

		$css_classes = array(
			'blog-area', $layout,
			'paginate-' . $paginate
		);

		if ( $carousel ) {
			$css_classes[] = 'news_carousel';
			$atts['columns'] = $layout_columns;
		} else {
			$css_classes[] = $blog_style;

			switch ( $blog_style ) {
				case 'blog-grid':

					if ( $layout == 'layout_3' ) {
						$css_classes[] = 'grid-columns-' . absint($layout_columns);
					} else {
						$css_classes[] = 'grid-columns-' . absint($columns);
					}

					break;
				case 'blog-masonry':
					$css_classes[] = 'grid-columns-' . absint($columns);
					$css_classes[] = 'isotope_container';
					$atts['isotope-layout'] = 'masonry';
					break;
			}

		}

		$data_attributes = $item_classes = array();
		if ( '' !== $css_animation ) {
			$item_classes[] = 'terminus_animated';
			$data_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, 0, '' );
		}

		$wrapper_attributes[] = TERMINUS_HELPER::create_data_string($atts);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<div class="wpb_content_element">

			<?php
			echo Terminus_Vc_Config::getParamTitle(
				$title,
				$tag_title,
				$description,
				array(
					'title_color' => $title_color
				)
			);
			?>

			<?php $delay = 0; ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ($entries->posts as $entry):

					$first_post = $first_big_post && $post_loop == 1;
					$this_post = array();
					$this_post['post_id'] = $id = $entry->ID;
					$this_post['url'] = $link = get_permalink($id);
					$this_post['title'] = $title = $entry->post_title;
					$this_post['post_format'] = $format = get_post_format($id) ? get_post_format($id) : 'standard';
					$this_post['image_size'] = terminus_blog_alias( $format, '', $blog_style, $layout, $columns );
					$this_post['blog_style'] = $blog_style;
					$this_post['content'] = $entry->post_content;
					$this_post = apply_filters( 'terminus-entry-format-'. $format, $this_post );

					extract($this_post);

					$post_content = has_excerpt($id) ? $entry->post_excerpt : $content;

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


					$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
					if ( empty($alt) ) {
						$attachment = get_post($id);
						$alt = trim(strip_tags($attachment->post_title));
					}

					$thumbnail_atts = array(
						'title'	=> trim(strip_tags($entry->post_title)),
						'alt' => $alt
					);

					$classes = array( 'entry', 'entry-' . $blog_style );

					if ( '' !== $css_animation ) { $classes[] = 'terminus_animated'; }

					?>

					<?php switch ( $layout ):

					case 'layout_1': ?>

						<div class="isotope_item">

							<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

							<article id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', $classes ), $id ); ?> <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-120" data-animation-delay="<?php echo esc_attr($delay) ?>">

								<!-- - - - - - - - - - - - - - Entry Header - - - - - - - - - - - - - - - - -->

								<header class="entry_header">

									<?php echo terminus_blog_post_meta($id); ?>

									<h3 class="entry_title">
										<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
									</h3>

								</header><!--/ .entry_header-->

								<!-- - - - - - - - - - - - - - End of Entry Header - - - - - - - - - - - - - - - - -->

								<!-- - - - - - - - - - - - - - Entry Media - - - - - - - - - - - - - - - - -->

								<div class="entry-media" style="background-image: url(<?php echo TERMINUS_HELPER::get_post_featured_image($id, $image_size) ?>);"></div>

								<!-- - - - - - - - - - - - - - End of Entry Media - - - - - - - - - - - - - - - - -->

								<?php
								if ( has_excerpt($id) ) {
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

							</article>

							<!-- - - - - - - - - - - - - - End of Entry - - - - - - - - - - - - - - - - -->

						</div><!--/ .isotope_item-->

						<?php break; ?>

					<?php case 'layout_2': ?>

						<div class="isotope_item">

							<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

							<article id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', $classes ), $id ); ?> <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-120" data-animation-delay="<?php echo esc_attr($delay) ?>">

								<!-- - - - - - - - - - - - - - Entry Media - - - - - - - - - - - - - - - - -->

								<div class="entry-media">
									<a href="<?php echo esc_url($link) ?>">
										<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, $image_size, true, $thumbnail_atts) ?>
									</a>
								</div>

								<!-- - - - - - - - - - - - - - End of Entry Media - - - - - - - - - - - - - - - - -->

								<!-- - - - - - - - - - - - - - Entry Header - - - - - - - - - - - - - - - - -->

								<header class="entry_header">

									<?php echo terminus_blog_post_meta($id); ?>

									<h3 class="entry_title">
										<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
									</h3>

								</header><!--/ .entry_header-->

								<!-- - - - - - - - - - - - - - End of Entry Header - - - - - - - - - - - - - - - - -->

								<?php
								if ( has_excerpt($id) ) {
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

							</article>

							<!-- - - - - - - - - - - - - - End of Entry - - - - - - - - - - - - - - - - -->

						</div><!--/ .isotope_item-->

						<?php break; ?>

					<?php case 'layout_3': ?>

						<div class="isotope_item <?php if ( $first_post ) { echo 'entry-big-post'; } ?>">

							<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

							<article id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', $classes ), $id ); ?> <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-120" data-animation-delay="<?php echo esc_attr($delay) ?>">

								<!-- - - - - - - - - - - - - - Entry Header - - - - - - - - - - - - - - - - -->

								<header class="entry_header">

									<?php echo terminus_blog_post_meta($id); ?>

									<h3 class="entry_title">
										<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
									</h3>

								</header><!--/ .entry_header-->

								<!-- - - - - - - - - - - - - - End of Entry Header - - - - - - - - - - - - - - - - -->

								<?php if ( $first_post ): ?>

									<!-- - - - - - - - - - - - - - Entry Media - - - - - - - - - - - - - - - - -->

									<div class="entry-media">
										<a href="<?php echo esc_url($link) ?>">
											<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, '750*500', true, $thumbnail_atts) ?>
										</a>
									</div>

									<!-- - - - - - - - - - - - - - End of Entry Media - - - - - - - - - - - - - - - - -->

								<?php else: ?>

									<!-- - - - - - - - - - - - - - Entry Media - - - - - - - - - - - - - - - - -->

									<div class="entry-media">
										<a href="<?php echo esc_url($link) ?>">
											<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, $image_size, true, $thumbnail_atts) ?>
										</a>
									</div>

									<!-- - - - - - - - - - - - - - End of Entry Media - - - - - - - - - - - - - - - - -->

								<?php endif; ?>

								<?php
								if ( has_excerpt($id) ) {
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

								<?php if ( $first_post ): ?>

									<div class="post-buttons">
										<a href="<?php echo esc_url($link) ?>" class="btn rd-grey middle"><?php esc_html_e('Continue Reading', 'terminus') ?></a>
									</div>

								<?php endif; ?>

							</article>

							<!-- - - - - - - - - - - - - - End of Entry - - - - - - - - - - - - - - - - -->

						</div><!--/ .isotope_item-->

						<?php break; ?>

					<?php case 'layout_4': ?>

						<?php $post_formats = array( 'link', 'quote' ); ?>

						<div class="isotope_item">

							<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

							<article id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', $classes ), $id ); ?> <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-120" data-animation-delay="<?php echo esc_attr($delay) ?>">

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
											if ( has_excerpt($id) ) {
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

						<?php break; ?>

					<?php default: ?>

					<?php endswitch; ?>

					<?php $delay += 100; $post_loop ++; ?>

				<?php endforeach; ?>

				<?php wp_reset_postdata(); ?>

			</div><!--/ .blog-area-->

			<?php if ( $paginate == "pagination" && $terminus_pagination = terminus_pagination($entries) ): ?>
				<?php echo $terminus_pagination; ?>
			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

}