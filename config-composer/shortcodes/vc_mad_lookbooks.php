<?php

class WPBakeryShortCode_VC_mad_lookbooks extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title'   => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description'   => '',
			'type' => 'view-grid',
			'columns' => 4,
			'items'   => 4,
			'orderby' => 'date',
			'order'   => 'desc',
			'link' => '',
			'pagination' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_products' );

		global $woocommerce;
		if (!is_object($woocommerce) || !is_object($woocommerce->query)) return;

		$this->query();
		return $this->html();
	}

	public function query() {

		$params = $this->atts;
		$number = $params['items'];
		$orderby = sanitize_title( $params['orderby'] );
		$order = sanitize_title( $params['order'] );

		$query = array(
			'post_type' 	 => 'lookbook',
			'post_status' 	 => 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby'        => $orderby,
			'order'   		 => $order == 'asc' ? 'asc' : 'desc',
			'posts_per_page' => $number
		);

		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
		$query['paged'] = $paged;

		$this->lookbooks = new WP_Query( $query );
	}

	protected function html() {

		if ( empty($this->lookbooks) || empty($this->lookbooks->posts) ) return;

		$lookbooks = $this->lookbooks;
		$params = $this->atts;
		$title = $tag_title = $title_color = $description = $type = $columns = $items = $link = $pagination = '';
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';

		extract($params);

		$link = ($link == '||') ? '' : $link;
		$link = vc_build_link($link);
		$a_href = $link['url'];
		$a_title = $link['title'];
		($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
		$data_attributes = array();

		ob_start();

		if ( $lookbooks->have_posts() ) : ?>

			<?php
				$atts = array(
					'columns' => $columns,
					'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
				);

				$css_classes = array(
					'wpb_content_element',
					'lookbooks-container',
					'lookbook-columns-' . absint($columns),
					$type
				);

				if  ( !empty($a_href) ) {
					$css_classes[] = 'with_link';
				}

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
			?>

			<div <?php echo terminus_create_data_string($atts) ?> class="<?php echo esc_attr( trim( $css_class ) ) ?>">

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

				<div class="lookbook_carousel_fw">

					<?php $delay = 0; ?>

					<?php while ( $lookbooks->have_posts() ) : $lookbooks->the_post(); ?>

						<?php
							$classes = array('lookbook-item');

							if ( '' !== $css_animation ) {
								$classes[] = 'terminus_animated';
								$data_attributes[''] = TERMINUS_HELPER::create_data_string_animation( $css_animation, $delay, '' );
							}
						?>

						<div class="<?php echo implode( ' ', $classes ); ?>" <?php echo implode( ' ', $data_attributes ) ?>>

							<!-- - - - - - - - - - - - - - Look Book Item - - - - - - - - - - - - - - - - -->

							<figure class="overlay_box">

								<?php
								echo TERMINUS_HELPER::get_the_post_thumbnail( get_the_ID(), '555*555', true, array(
									'class' => 'ov_img',
									'alt'	=> trim(strip_tags(get_the_excerpt())),
									'title'	=> trim(strip_tags(get_the_title()))
								));
								?>

								<figcaption class="ov_blackout">

									<div class="ov_text_outer">

										<div class="ov_text_inner">

											<h3 class="title"><?php echo get_the_title() ?></h3>

											<?php if ( get_the_content() ): ?>
												<p class="lb_excerpt"><?php echo terminus_string_truncate(get_the_content(), 150, ' ', "...", true, '') ?></p>
											<?php endif; ?>

											<div class="view_more">
												<a href="<?php echo esc_url(get_the_permalink()) ?>" class="btn small rd-white"><?php esc_html_e('View Look', 'terminus') ?></a>
											</div>

										</div><!--/ .ov_text_inner -->

									</div><!--/ .ov_text_outer -->

								</figcaption><!--/ .ov_blackout -->

							</figure>

							<!-- - - - - - - - - - - - - - End of Look Book Item - - - - - - - - - - - - - - - - -->

						</div>

						<?php $delay = $delay + 100; ?>

					<?php endwhile; // end of the loop. ?>

				</div><!--/ .lookbook_carousel_fw-->

				<?php if ( !empty($a_href) ): ?>

					<div class="section_btn">
						<a href="<?php echo esc_url($a_href) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn rd-grey middle"><?php echo esc_html($a_title) ?></a>
					</div><!--/ .section_btn -->

				<?php endif; ?>

			<?php if ( $pagination == 'yes' ): ?>
				<?php echo terminus_pagination($this->lookbooks); ?>
			<?php endif; ?>

			</div><!--/ .lookbooks-container-->

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

		<?php return ob_get_clean();
	}

}