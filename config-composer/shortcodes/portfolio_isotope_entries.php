<?php

if (!class_exists('terminus_portfolio_isotope_masonry_entries')) {

	class terminus_portfolio_isotope_masonry_entries {

		public $atts = array();
		public $entries = '';
		public $settings = array();

		function __construct($atts = array()) {

			global $terminus_config;
			$sidebar_position = isset($terminus_config['sidebar_position']) ? $terminus_config['sidebar_position'] : 'no_sidebar';

			$this->atts = shortcode_atts(array(
				'title' => '',
				'description' => '',
				'layout' => 'grid',
				'spacing' => 'with_spacing',
				'actions' => 'with_actions',
				'sort' => '',
				'categories' => array(),
				'orderby' => 'date',
				'order' => 'DESC',
				'columns' 	=> 3,
				'items' 	=> 6,
				'paginate' => 'none',
				'items_per_page' => 10,
				'css_animation' => '',
				'animation_delay' => 0,
				'offset' => 0,
				'sidebar_position' => $sidebar_position,
				'action' => 'terminus_portfolio_ajax_isotope_items_more'
			), $atts);

			$this->query_entries($atts);

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
			if (!$page || $params['paginate'] == 'none') $page = 1;

			if (!empty($params['categories'])) {
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
				'tax_query' => $tax_query,
				'offset' => $params['offset']
			);

			$this->entries = new WP_Query($query);
			$this->prepare_entries($params);
		}

		protected function getTerms($id, $params, $slug) {
			$classes = "";
			$item_categories = get_the_terms($id, 'portfolio_categories');
			if (is_object($item_categories) || is_array($item_categories)) {
				foreach ($item_categories as $cat) {
					$classes .= $cat->$slug . ' ';
				}
			}
			return $classes;
		}

		public function html() {

			if ( empty($this->loop) ) return;

			$id = $link = $title = $items_per_page = $excerpt_hidden = $sort_classes = $cur_terms = $item_size = $image_size = $layout = $actions = '';

			extract($this->atts);
			$data_attributes = array();
			$item_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array( 'project' ) ) ) );

			$excerpt_hidden = $excerpt_hidden ? false : true;

			$defaults = array(
				'id' => '',
				'link' => '',
				'title' => '',
				'items_per_page' => 10,
				'sort_classes' => '',
				'cur_terms' => '',
				'item_size' => '',
				'image_size' => '640*420'
			);

			ob_start(); ?>

			<?php foreach ( $this->loop as $entry ): extract( array_merge($defaults, $entry) ); ?>

				<div class="isotope_item">

					<div class="<?php echo esc_attr($item_class) ?>" <?php echo implode( ' ', $data_attributes ) ?> data-scroll-factor="-80" data-animation-delay="<?php echo esc_attr($delay) ?>">

						<div class="overlay_box">

							<!-- - - - - - - - - - - - - - Project Image - - - - - - - - - - - - - - - - -->

							<?php echo TERMINUS_HELPER::get_the_post_thumbnail( $id, $image_size, true, array( 'class' => 'ov_img', 'alt' => esc_attr($title) ) ); ?>

							<!-- - - - - - - - - - - - - - End of Project Image - - - - - - - - - - - - - - - - -->

							<div class="ov_blackout">

								<?php if ( $layout != 'grid-classic' ): ?>

									<div class="ov_text_outer">

										<!-- - - - - - - - - - - - - - Project Title & Cats - - - - - - - - - - - - - - - - -->

										<div class="ov_text_inner">

											<h3 class="project_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h3>

											<?php if ( terminus_get_option('show-portfolio-categories') ): ?>
												<?php if (!empty($cur_terms)): ?>
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

								<?php if (terminus_get_option('show-portfolio-categories')): ?>
									<?php if (!empty($cur_terms)): ?>
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

				</div>

			<?php endforeach; ?>

			<?php return ob_get_clean();
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

				} elseif ( $params['layout'] == 'masonry' ) {

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

}
