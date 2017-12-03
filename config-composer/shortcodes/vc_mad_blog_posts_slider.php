<?php

class WPBakeryShortCode_VC_mad_blog_posts_slider extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'category' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 10
		), $atts, 'vc_mad_blog_posts_slider');

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
			'paged' => 1,
			'post_status' => array('publish')
		);

		if (!empty($params['category'])) {
			$categories = explode(',', $params['category']);
			$query['category__in'] = $categories;
		}

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if (empty($this->entries) || empty($this->entries->posts)) return;

		$entries = $this->entries;
		$params = $this->atts;
		$wrapper_attributes = array();
		$title = !empty($params['title']) ? $params['title'] : '';
		$tag_title = !empty($params['tag_title']) ? $params['tag_title'] : 'h2';
		$title_color = !empty($params['title_color']) ? $params['title_color'] : '';
		$description = !empty($params['description']) ? $params['description'] : '';
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array( 'entries_slider' ) ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

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

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php foreach ( $entries->posts as $entry ):
				$id = $entry->ID;
				$link = get_permalink($id);
				$title = $entry->post_title;
				$commentCount = get_comments_number($id);
				$classes = array( 'entry' );

				$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
				if ( empty($alt) ) {
					$attachment = get_post($id);
					$alt = trim(strip_tags($attachment->post_title));
				}

				$thumbnail_atts = array(
					'title'	=> trim(strip_tags($entry->post_title)),
					'alt' => $alt
				);
				?>

				<!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->

				<article <?php post_class( implode( ' ', $classes ), $id ); ?>>

					<!-- - - - - - - - - - - - - - Entry Image - - - - - - - - - - - - - - - - -->

					<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, '1140*600', true, $thumbnail_atts) ?>

					<!-- - - - - - - - - - - - - - End of Entry Image - - - - - - - - - - - - - - - - -->

					<div class="entry_body">

						<!-- - - - - - - - - - - - - - Byline - - - - - - - - - - - - - - - - -->

						<ul class="byline">
							<?php
								$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
								$time_string = sprintf( $time_string,
									esc_attr( get_the_date( 'c' ) ),
									get_the_date('j F Y')
								);

								printf( '<li>%1$s </li>', $time_string );
							?>

							<?php if ( has_category('', $id) ): ?>
								<li><?php echo get_the_category_list(", ", '', $id) ?></li>
							<?php endif; ?>

							<?php if ( $commentCount != '0' || comments_open($id)):
								$link_to = $commentCount === "0" ? "#respond" : "#comments";
								$text_add = $commentCount === "1" ? esc_html__('Comment', 'terminus' ) : esc_html__('Comments', 'terminus' ); ?>
								<li><a href='<?php echo esc_url($link . $link_to); ?>'><?php echo absint($commentCount) . ' ' . $text_add  ?></a></li>
							<?php endif; ?>

						</ul><!--/ .byline-->

						<!-- - - - - - - - - - - - - - End of Byline - - - - - - - - - - - - - - - - -->

						<h2 class="entry_title h1_size">
							<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
						</h2>

						<a href="<?php echo esc_url($link) ?>" class="btn rd-white middle">
							<?php esc_html_e('Read More', 'terminus') ?>
						</a>

					</div><!--/ .entry_body -->

				</article>

				<!-- - - - - - - - - - - - - - End of Entry - - - - - - - - - - - - - - - - -->

			<?php endforeach; ?>

			<?php wp_reset_postdata(); ?>

		</div><!--/ .entries_slider-->

		<?php return ob_get_clean();
	}

}