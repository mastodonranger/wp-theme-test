<?php

class WPBakeryShortCode_VC_mad_portfolio extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		global $terminus_config;
		$sidebar_position = isset($terminus_config['sidebar_position']) ? $terminus_config['sidebar_position'] : 'no_sidebar';

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'layout' => 'grid',
			'spacing' => 'with_spacing',
			'actions' => 'with_actions',
			'excerpt_hidden' => 0,
			'sort' => '',
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'columns' 	=> 3,
			'img_size' => '',
			'items' 	=> 6,
			'paginate' => 'none',
			'items_per_page' => 10,
			'css_animation' => '',
			'animation_delay' => 0,
			'offset' => 0,
			'sidebar_position' => $sidebar_position,
			'action' => 'terminus_portfolio_ajax_isotope_items_more'
		), $atts, 'vc_mad_portfolio');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	protected function sort_links($entries, $params) {

		$categories = get_categories(array(
			'taxonomy'	=> 'portfolio_categories',
			'hide_empty'=> 0
		));
		$current_cats = array();
		$display_cats = is_array($params['categories']) ? $params['categories'] : array_filter(explode(',', $params['categories']));

		foreach ( $entries as $entry ) {
			if ( $current_item_cats = get_the_terms( $entry->ID, 'portfolio_categories' ) ) {
				if ( !empty($current_item_cats) ) {
					foreach ($current_item_cats as $current_item_cat) {
						if (empty($display_cats) || in_array($current_item_cat->term_id, $display_cats)) {
							$current_cats[$current_item_cat->term_id] = $current_item_cat->term_id;
						}
					}
				}
			}
		}

		$css_classes = array(
			'btn', 'rd-grey', 'middle'
		);

		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';

		$data_attributes = array();
		if ( '' !== $css_animation ) {
			$css_classes[] = 'terminus_animated';
			$data_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, 0, '' );
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<div class="buttons_set isotope_filter filter_offset">

			<a href="javascript:void(0)" class="<?php echo esc_attr($css_class) ?> active" <?php echo implode( ' ', $data_attributes ) ?> data-animation-delay="130" data-scroll-factor="-120" data-filter="*"><?php esc_html_e('All', 'terminus') ?></a>

			<?php $delay = 230;  ?>

			<?php foreach ( $categories as $category ): ?>
				<?php if ( in_array($category->term_id, $current_cats) ): ?>
					<?php $nicename = str_replace('%', '', $category->category_nicename); ?>
						<a href="javascript:void(0)" class="<?php echo esc_attr($css_class) ?>" <?php echo implode( ' ', $data_attributes ) ?> data-animation-delay="<?php echo esc_attr($delay) ?>" data-scroll-factor="-120" data-filter=".<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)); ?></a>
					<?php $delay += 100 ?>
				<?php endif; ?>

			<?php endforeach ?>

		</div><!--/ .buttons_set-->

		<?php return ob_get_clean();
	}

	public function get_sort_class( $id ) {
		$classes = "";
		$item_categories = get_the_terms( $id, 'portfolio_categories' );
		if (is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				$classes .= $cat->slug . ' ';
			}
		}
		return str_replace( '%', '', $classes );
	}

	public function query_entries($params = array()) {

		if ( empty($params) ) $params = $this->atts;

		$tax_query = array();

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page || $params['paginate'] == 'none' ) $page = 1;

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'portfolio_categories',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'portfolio',
			'post_status'  => 'publish',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'tax_query' => $tax_query
		);

		if ( $params['paginate'] == 'load-more' || $params['paginate'] == 'lazy-load' ) {
			$query['offset'] = $params['offset'];
		}

		$this->entries = new WP_Query($query);
		$this->prepare_entries($params);
	}

	public function html() {

		if ( empty($this->loop) ) return;

		$atts = $this->atts;
		$title = !empty($atts['title']) ? $atts['title'] : '';
		$tag_title = !empty($atts['tag_title']) ? $atts['tag_title'] : '';
		$title_color = !empty($atts['title_color']) ? $atts['title_color'] : '';
		$description = !empty($atts['description']) ? $atts['description'] : '';
		$layout = !empty($atts['layout']) ? $atts['layout'] : 'grid';
		$spacing = !empty($atts['spacing']) ? $atts['spacing'] : 'with_spacing';
		$actions = !empty($atts['actions']) ? $atts['actions'] : 'with_actions';
		$excerpt_hidden = $atts['excerpt_hidden'] ? false : true;
		$columns = !empty($atts['columns']) ? $atts['columns'] : 3;
		$sort = $atts['sort'] == 'yes' ? true : false;
		$css_animation = !empty($atts['css_animation']) ? $atts['css_animation'] : '';
		$paginate = !empty($atts['paginate']) ? $atts['paginate'] : 'pagination';
		$data_rel = 'data-rel=portfolio-'. rand() .'';

		$defaults = array(
			'id' => '',
			'link' => '',
			'items_per_page' => 10,
			'sort_classes' => '',
			'cur_terms' => '',
			'item_size' => '',
			'image_size' => '640*420'
		);

		$css_classes = array(
			'portfolio-holder',
			$layout . '-layout',
			$spacing, $actions,
			'paginate-' . $paginate,
			'grid-columns-' . absint($columns)
		);

		if ( $layout == 'grid' || $layout == 'grid-classic' || $layout == 'masonry' ) {
			$css_classes[] = 'isotope_container';
		} elseif ( $layout == 'carousel' ) {
			$css_classes[] = 'projects_carousel';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$item_classes = array( 'project' );

		$data_attributes = array();
		if ( '' !== $css_animation ) {
			$item_classes[] = 'terminus_animated';
			$data_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, 0, '' );
		}

		$item_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $item_classes ) ) );

		$attributes = array(
			'columns' => $columns,
			'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
		);

		if ( $layout == 'masonry' ) {
			$attributes['isotope-layout'] = 'masonry';
			$attributes['type-layout'] = 'portfolio';
		} elseif ( $layout == 'carousel' ) {
			$attributes['margin'] = 30;

			if ( $spacing == 'without_spacing' ) {
				$attributes['without_spacing'] = 1;
			}

		}

		if ( $paginate == 'lazy-load' ) {
			$attributes['lazy-load'] = 'true';
			$attributes['action'] = $atts['action'];
			$attributes['offset'] = $atts['offset'];
			$attributes['items'] = $atts['items'];
			$attributes['layout'] = $atts['layout'];
			$attributes['spacing'] = $atts['spacing'];
			$attributes['actions'] = $atts['actions'];
			$attributes['excerpt_hidden'] = $atts['excerpt_hidden'] ? 0 : 1;
			$attributes['items_per_page'] = $atts['items_per_page'];
			$attributes['img_size'] = $atts['img_size'];
			$attributes['sidebar_position'] = $atts['sidebar_position'];
		}

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

			<?php echo ($sort) ? $this->sort_links($this->entries->posts, $atts) : ""; ?>

			<div <?php echo TERMINUS_HELPER::create_data_string($attributes) ?> class="<?php echo esc_attr( trim( $css_class ) ) ?>">

				<?php $delay = 0; $i = 1; ?>

				<?php foreach ($this->loop as $entry): extract(array_merge($defaults, $entry)); ?>

					<?php if ( $i == 1 && $layout == 'masonry' ): ?>
						<div class="grid-sizer"></div>
					<?php endif; ?>

					<div class="isotope_item <?php echo esc_attr($item_size) ?> <?php echo esc_attr($sort_classes) ?>">

						<!-- - - - - - - - - - - - - - Portfolio Item - - - - - - - - - - - - - - - - -->

						<div class="<?php echo esc_attr($item_class) ?>" <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-80" data-animation-delay="<?php echo esc_attr($delay) ?>">

							<div class="overlay_box">

								<!-- - - - - - - - - - - - - - Project Image - - - - - - - - - - - - - - - - -->

								<?php echo TERMINUS_HELPER::get_the_post_thumbnail( $id, $image_size, true, array(), array( 'class' => 'ov_img', 'alt' => esc_attr($title) ) ); ?>

								<!-- - - - - - - - - - - - - - End of Project Image - - - - - - - - - - - - - - - - -->

								<div class="ov_blackout">

									<?php if ( $layout != 'grid-classic' ): ?>

										<div class="ov_text_outer">

											<!-- - - - - - - - - - - - - - Project Title & Cats - - - - - - - - - - - - - - - - -->

											<div class="ov_text_inner">

												<h3 class="project_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h3>

												<?php if ( terminus_get_option('show-portfolio-categories') ): ?>
													<?php if ( !empty($cur_terms) ): ?>
														<ul class="project_cats">
															<?php foreach($cur_terms as $cur_term): ?>
																<li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
															<?php endforeach; ?>
														</ul>
													<?php endif; ?>
												<?php endif; ?>

											</div><!--/ .ov_text_inner-->

											<!-- - - - - - - - - - - - - - End of Project Title & Cats - - - - - - - - - - - - - - - - -->

										</div><!--/ .ov_text_outer -->

									<?php endif; ?>

									<?php if ( $actions == 'with_actions' ): ?>

										<ul class="ov_actions">
											<li>
												<a href="<?php echo TERMINUS_HELPER::get_post_featured_image( $id, '' ) ?>" <?php echo esc_attr($data_rel) ?> class="fancybox" title="<?php echo esc_attr($title) ?>">
													<span class="si-icon si-icon-plus"></span>
												</a>
											</li>
											<li>
												<a href="<?php echo esc_url($link) ?>">
													<span class="si-icon si-icon-link"></span>
												</a>
											</li>
										</ul>

									<?php endif; ?>

								</div><!--/ .ov_blackout -->

							</div><!--/ .overlay_box -->

							<?php if ( $layout == 'grid-classic' ): ?>

								<figcaption class="project_details_area">

									<h3 class="project_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h3>

									<?php if ( terminus_get_option('show-portfolio-categories') ): ?>
										<?php if ( !empty($cur_terms) ): ?>
											<ul class="project_cats">
												<?php foreach($cur_terms as $cur_term): ?>
													<li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									<?php endif; ?>

									<?php if ( $excerpt_hidden ): ?>
										<?php echo ( $post_content != '' ) ? '<p>' . "{$post_content}" . '</p>' : ''; ?>
									<?php endif; ?>

								</figcaption>

							<?php endif; ?>

						</div>

						<!-- - - - - - - - - - - - - - End of Portfolio Item - - - - - - - - - - - - - - - - -->

					</div>

					<?php $delay+=150; $i++; ?>

				<?php endforeach; ?>

				<?php wp_reset_postdata(); ?>

			</div>

			<?php if ( $paginate == 'load-more' ): ?>
				<?php echo $this->load_more_button(); ?>
			<?php elseif ( $paginate == "lazy-load" ): ?>
				<?php echo $this->load_more_button('hidden'); ?>
			<?php elseif ( $paginate == "pagination" && $terminus_pagination = terminus_pagination($this->entries) ) : ?>
				<?php echo $terminus_pagination; ?>
			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

	public function load_more_button($class = '') {
		?>
		<div class="post-load-more">
			<a class="btn load_more rd-grey middle <?php echo esc_attr($class) ?>" href="javasript:void(0)" <?php echo TERMINUS_HELPER::create_data_string($this->atts); ?>>
				<?php esc_html_e('Load More', 'terminus') ?>
			</a>
		</div><!--/ .post-load-more-->
		<?php
	}

	public function prepare_entries($params) {
		$this->loop = array();

		if ( empty($params )) $params = $this->atts;
		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		$sidebar_position = $params['sidebar_position'];

		foreach ($this->entries->posts as $key => $entry) {
			$this->loop[$key]['id'] = $id = $entry->ID;
			$this->loop[$key]['link'] = get_permalink($id);
			$this->loop[$key]['title'] = get_the_title($id);
			$this->loop[$key]['sort_classes'] = $this->get_sort_class($id);
			$this->loop[$key]['img_size'] = '';
			$this->loop[$key]['cur_terms'] = get_the_terms( $id, 'portfolio_categories' );
			$this->loop[$key]['post_content'] = has_excerpt($id) ? terminus_string_truncate($entry->post_excerpt, terminus_get_option('excerpt_count_portfolio'), ' ', "...", true, '') : '';

			$custom_img_size = '';

			if ( !empty($params['img_size']) && strpos($params['img_size'], '*') ) {

				$custom_img_size = $params['img_size'];

			} elseif( $params['layout'] == 'masonry' ) {

				$image_size = rwmb_meta( 'terminus_image_size', '', $id );

				switch ( $image_size ) {
					case 'medium':
						$this->loop[$key]['item_size'] = 'size_2';
					break;
				}

			}

			$this->loop[$key]['image_size'] = Terminus_Custom_Content_Types_and_Taxonomies::get_image_sizes( $params, rwmb_meta( 'terminus_image_size', '', $id ), $sidebar_position, $custom_img_size );
		}

	}

}