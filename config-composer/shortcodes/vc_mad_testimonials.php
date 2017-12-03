<?php

class WPBakeryShortCode_VC_mad_testimonials extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'text_color' => '',
			'description' => '',
			'items' => 6,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'style' => 'type_default',
			'columns' => 1,
			'link' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_testimonials');

		$this->query_entries();
		return $this->html();
	}

	public function query_entries() {
		$params = $this->atts;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if (!$page || $params['pagination'] == 'no') $page = 1;

		$tax_query = array();

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'testimonials_category',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'testimonials',
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'posts_per_page' => $params['items'],
			'tax_query' 	 => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if (empty($this->entries) || empty($this->entries->posts)) return;

		$wrapper_attributes = array();
		$title = $tag_title = $title_color = $text_color = $description = $style = $columns = $items = $categories = $orderby = $order = $style = $link = $css_animation = '';

		extract($this->atts);
		$css_classes = array( 'testimonials', $style );

		$link = ($link == '||') ? '' : $link;
		$link = vc_build_link($link);
		$a_href = $link['url'];
		$a_title = $link['title'];
		($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';

		if ( $style == 'type_default' || $style == 'type_carousel' ) {
			$css_classes[] = 'columns-' . $columns;
		}

		if ( $style == 'type_carousel' ) {
			$css_classes[] = 'testimonials_carousel';
		}

		if ( '' !== $css_animation ) {
			$css_classes[] = 'terminus_animated';
			$wrapper_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, 0, '' );
		}

		if  ( !empty($a_href) ) {
			$css_classes[] = 'with_link';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<div class="wpb_content_element">

			<?php if ( $style == 'type_default' || $style == 'type_carousel' ): ?>

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

				<div data-columns="<?php echo esc_attr($columns) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$place = rwmb_meta( 'terminus_tm_place', '', $id );
						$content = has_excerpt($id) ? terminus_string_truncate( apply_filters( 'the_excerpt', $entry->post_excerpt ), terminus_get_option('excerpt_count_testimonials_content') ) : '';

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

						<!-- - - - - - - - - - - - - - Testimonial - - - - - - - - - - - - - - - - -->

						<div class="testimonial">

							<blockquote><?php echo do_shortcode($content); ?></blockquote>

							<div class="author">

								<?php if ( has_post_thumbnail($id) ): ?>

									<div class="a_avatar">
										<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, '80*80', true, $thumbnail_atts) ?>
									</div><!--/ .a_avatar -->

								<?php endif; ?>

								<div class="a_info">

									<span class="a_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($name) ?></a></span>
									<span class="a_position"><?php echo esc_html($place) ?></span>

								</div><!--/ .name_position -->

							</div><!--/ .author -->

						</div><!--/ .testimonial-->

						<!-- - - - - - - - - - - - - - End of Testimonial - - - - - - - - - - - - - - - - -->

					<?php endforeach; ?>

				</div>

				<?php if ( !empty($a_href) ): ?>
					<a href="<?php echo esc_url($a_href) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn rd-grey middle"><?php echo esc_html($a_title) ?></a>
				<?php endif; ?>

			<?php elseif ( $style == 'type_2' ): ?>

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$place = rwmb_meta( 'terminus_tm_place', '', $id );
						$content = has_excerpt($id) ? terminus_string_truncate( apply_filters( 'the_excerpt', $entry->post_excerpt ), terminus_get_option('excerpt_count_testimonials_content') ) : '';

						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						if (empty($alt)) {
							$attachment = get_post($id);
							$alt = trim(strip_tags($attachment->post_title));
						}

						$thumbnail_atts = array(
							'title'	=> trim(strip_tags($entry->post_title)),
							'alt' => $alt
						);
						?>

						<!-- - - - - - - - - - - - - - Testimonial - - - - - - - - - - - - - - - - -->

						<div class="testimonial-extra">

							<?php if ( has_post_thumbnail($id) ): ?>

								<div class="testimonial-image" style="background-image: url(<?php echo TERMINUS_HELPER::get_post_featured_image($id, '945*500', true, $thumbnail_atts) ?>);"></div>

							<?php endif; ?>

							<div class="testimonial-inner">

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

								<div class="testimonial">

									<blockquote><p><?php echo do_shortcode($content); ?></p></blockquote>

									<div class="author">

										<div class="a_info">

											<span class="a_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($name) ?></a></span>
											<span class="a_position"><?php echo esc_html($place) ?></span>

										</div><!--/ .name_position -->

									</div><!--/ .author -->

								</div><!--/ .testimonial-->

								<a href="<?php echo esc_url(get_the_permalink($id)) ?>" class="btn middle rd-grey"><?php echo esc_html__('Read More Testimonials', 'terminus') ?></a>

							</div>

						</div>

						<!-- - - - - - - - - - - - - - End of Testimonial - - - - - - - - - - - - - - - - -->

					<?php endforeach; ?>

				</div>

			<?php elseif ( $style == 'type_3' ): ?>

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

					<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$content = has_excerpt($id) ? terminus_string_truncate( apply_filters( 'the_excerpt', $entry->post_excerpt ), terminus_get_option('excerpt_count_testimonials_content') ) : '';
						?>

						<!-- - - - - - - - - - - - - - Testimonial - - - - - - - - - - - - - - - - -->

						<div class="testimonial">

							<blockquote><?php echo do_shortcode($content); ?></blockquote>

							<div class="author"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($name) ?></a></div><!--/ .author -->

						</div><!--/ .testimonial-->

						<!-- - - - - - - - - - - - - - End of Testimonial - - - - - - - - - - - - - - - - -->

					<?php endforeach; ?>

				</div>

			<?php elseif ( $style == 'type_4' ): ?>

				<?php
				$styles = $attributes = array();

				if ( $text_color ) {
					$styles[] = vc_get_css_color( 'color', $text_color );
				}

				if ( $styles ) {
					$attributes[] = 'style="' . implode( ' ', $styles ) . '"';
				}

				?>

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

					<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$place = rwmb_meta( 'terminus_tm_place', '', $id );
						$content = has_excerpt($id) ? terminus_string_truncate( apply_filters( 'the_excerpt', $entry->post_excerpt ), terminus_get_option('excerpt_count_testimonials_content') ) : '';

						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						if (empty($alt)) {
							$attachment = get_post($id);
							$alt = trim(strip_tags($attachment->post_title));
						}

						$thumbnail_atts = array(
							'title'	=> trim(strip_tags($entry->post_title)),
							'alt' => $alt
						);
						?>

						<!-- - - - - - - - - - - - - - Testimonial - - - - - - - - - - - - - - - - -->

						<div class="testimonial">

							<?php if ( has_post_thumbnail($id) ): ?>

								<div class="a_avatar">
									<?php echo TERMINUS_HELPER::get_the_post_thumbnail($id, '80*80', true, $thumbnail_atts) ?>
								</div><!--/ .a_avatar -->

							<?php endif; ?>

							<div class="quote">

								<blockquote <?php echo implode( ' ', $attributes ) ?>><?php echo do_shortcode($content); ?></blockquote>

								<div class="author">

									<div class="a_info">

										<span class="a_name"><a <?php echo implode( ' ', $attributes ) ?> href="<?php echo esc_url($link) ?>"><?php echo esc_html($name) ?></a></span>
										<span class="a_position" <?php echo implode( ' ', $attributes ) ?>><?php echo esc_html($place) ?></span>

									</div><!--/ .name_position -->

								</div><!--/ .author -->

							</div><!--/ .quote -->

						</div>

						<!-- - - - - - - - - - - - - - End of Testimonial - - - - - - - - - - - - - - - - -->

					<?php endforeach; ?>

				</div>

			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

}