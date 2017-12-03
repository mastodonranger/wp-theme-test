<?php

class WPBakeryShortCode_VC_mad_team_members extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'items' => 3,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC'
		), $atts, 'vc_mad_team_members' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {
		$params = $this->atts;

		$tax_query = array();

		if (!empty($params['categories'])) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'team_category',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'team-members',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'tax_query' => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if (empty($this->entries) || empty($this->entries->posts)) return;

		$title = $tag_title = $title_color = $description = '';
		$wrapper_attributes = array();

		extract($this->atts);

		$css_classes = array(
			'team-members'
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start() ?>

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

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ($this->entries->posts as $entry): ?>

					<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$position = rwmb_meta('terminus_tm_position', '', $id);
						$content = has_excerpt($id) ? $entry->post_excerpt : $entry->post_content;
						$thumbnail_atts = array(
							'alt'	=> trim(strip_tags($entry->post_title))
						);
					?>

					<div class="team-item">

						<figure class="team_member">

							<div class="overlay_box">

								<?php if ( has_post_thumbnail($id) ): ?>
									<?php echo TERMINUS_HELPER::get_the_post_thumbnail ($id, '555*555', false, array(), $thumbnail_atts ) ?>
								<?php endif; ?>

								<div class="ov_blackout">

									<div class="ov_text_outer">
										<div class="ov_text_inner">
											<?php echo apply_filters( 'the_content', terminus_string_truncate($content, 170, ' ', "...", true, '') ); ?>
										</div><!--/ .ov_text_inner -->
									</div><!--/ .ov_text_outer -->

								</div><!--/ .ov_blackout -->

							</div><!--/. overlay_box -->

							<figcaption class="member_info">

								<h3><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a></h3>

								<div class="position"><?php echo esc_html($position) ?></div>

								<?php echo terminus_single_social_links($id); ?>

							</figcaption>

						</figure>

					</div><!--/ .team-item-->

				<?php endforeach; ?>

			</div><!--/ .team-members-->

		</div>

		<?php return ob_get_clean();
	}

}