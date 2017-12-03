<?php

class WPBakeryShortCode_VC_mad_products extends WPBakeryShortCode {

	public $atts = array();
	public $products = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' 	 => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' 	 => '',
			'type' 		 => 'view-grid',
			'layout' 	 => 'type_1',
			'columns' 	 => 4,
			'items' 	 => 6,
			'show' => '',
			'orderby' => 'menu_order',
			'order' => '',
			'by_id' => '',
			'filter' 	 => '',
			'categories' => '',
			'pagination' => 'no',
			'link' => '',
			'taxonomy' => 'product_cat',
			'css_animation' => ''
		), $atts, 'vc_mad_products');

		global $woocommerce;
		if (!is_object($woocommerce) || !is_object($woocommerce->query)) return;

		$this->query();
		return $this->html();
	}

	protected function stringToArray( $value ) {
		$valid_values = array();
		$list = preg_split( '/\,[\s]*/', $value );
		foreach ( $list as $v ) {
			if ( strlen( $v ) > 0 ) {
				$valid_values[] = $v;
			}
		}
		return $valid_values;
	}

	public function query() {

		global $woocommerce;

		$params = $this->atts;
		$number = $params['items'];
		$orderby = sanitize_title( $params['orderby'] );
		$order = sanitize_title( $params['order'] );
		$show = $params['show'];

		// Meta query
		$meta_query = $tax_query = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
		$meta_query[] = $woocommerce->query->stock_status_meta_query();
		$meta_query = array_filter($meta_query);

		if ( !empty($params['categories']) ) {

			$categories = explode(',', $params['categories']);

			if (is_array($categories)) {
				$categories = $categories;
			} else {
				$categories = array($categories);
			}

			$tax_query = array(
				'relation' => 'AND',
					array(
						'taxonomy' => 'product_cat',
						'field' => 'id',
						'terms' => $categories
					)
			);
		}

		$query = array(
			'post_type' 	 => 'product',
			'post_status' 	 => 'publish',
			'ignore_sticky_posts'	=> 1,
			'order'   		 => $order == 'asc' ? 'asc' : 'desc',
			'meta_query' 	 => $meta_query,
			'tax_query' 	 => $tax_query,
			'posts_per_page' => $number
		);

		if ( !empty($params['by_id']) ) {
			$in = $not_in = array();
			$by_ids = $params['by_id'];
			$ids = $this->stringToArray( $by_ids );

			foreach ( $ids as $id ) {
				$id = (int) $id;
				if ( $id < 0 ) {
					$not_in[] = abs( $id );
				} else {
					$in[] = $id;
				}
			}
			$query['post__in'] = $in;
			$query['post__not_in'] = $not_in;
		}

		if ( $params['pagination'] == 'yes' ) {
			$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
			$query['paged'] = $paged;
		}

		if ( $orderby != '' ) {
			switch ( $orderby ) {
				case 'rand' :
					$query['orderby']  = 'rand';
					break;
				case 'date' :
					$query['orderby']  = 'date ID';
					$query['order']    = $order == 'ASC' ? 'ASC' : 'DESC';
					break;
				case 'price' :
					$query['orderby']  = "meta_value_num ID";
					$query['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
					$query['meta_key'] = '_price';
					break;
				case 'popularity' :
					$query['meta_key'] = 'total_sales';

					// Sorting handled later though a hook
					add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
					break;
				case 'rating' :
					// Sorting handled later though a hook
					add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
					break;
				case 'title' :
					$query['orderby']  = 'title';
					$query['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
					break;
				default :
					$query['orderby']  = $params['orderby'];
					break;
			}
		} else {
			$query['orderby'] = get_option('woocommerce_default_catalog_orderby');
		}

		switch ( $show ) {
			case 'featured' :
				$query['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query['post__in'] = $product_ids_on_sale;
				break;
			case 'bestselling':
				$query['ignore_sticky_posts'] = 1;
				$query['meta_key'] = 'total_sales';
				$query['orderby'] = 'meta_value_num';
				break;
			case 'toprated' :
				$query['ignore_sticky_posts'] = 1;
				$query['no_found_rows'] = 1;
				break;
			case 'new':
				add_filter( 'posts_where', array(&$this, 'filter_where') );
				break;
		}

		if ( $show == 'toprated' ) {
			add_filter( 'posts_clauses', array( WC()->query , 'order_by_rating_post_clauses' ) );
		}

		$this->products = new WP_Query( $query );

		if ( $show == 'new' ) {
			remove_filter( 'posts_where', array(&$this, 'filter_where') );
		}

		global $woocommerce_loop;
		$woocommerce_loop['loop'] = 0;

		if ( $show == 'toprated' ) {
			remove_filter( 'posts_clauses', array( WC()->query , 'order_by_rating_post_clauses' ) );
		}

	}

	public function order_by_popularity_post_clauses( $args ) {
		global $wpdb;
		$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
		return $args;
	}

	public function order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
		$args['where']  .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
		$args['join']   .= "
			LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";
		$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}

	public function filter_where( $where = '' ) {
		$newness = get_option( 'wc_nb_newness' );
		$where .= " AND post_date > '" . date(wc_date_format(), strtotime('-'. $newness .' days')) . "'";
		return $where;
	}

	protected function sort_cat_links( $products, $params ) {

		$get_categories = get_categories(array(
			'taxonomy'	 => $params['taxonomy'],
			'hide_empty' => 1
		));

		$current_cats = $current_parents = array();
		$display_cats = is_array($params['categories']) ? $params['categories'] : array_filter(explode(',', $params['categories']));

		foreach ($products->posts as $entry) {

			if ($current_item_cats = get_the_terms( $entry->ID, $params['taxonomy'] )) {

				if (isset($current_item_cats) && !empty($current_item_cats)) {
					foreach ($current_item_cats as $current_item_cat) {

						if (in_array($current_item_cat->term_id, $display_cats)) {

							$current_parents[$current_item_cat->term_id] = $current_item_cat->term_id;

							if(!isset($current_cats[$current_item_cat->term_id] )) {
								$current_cats[$current_item_cat->term_id] = 0;
							}

							$current_cats[$current_item_cat->term_id] ++;
						}

						if (in_array($current_item_cat->parent, $display_cats)) {

							$current_parents[$current_item_cat->parent] = $current_item_cat->parent;

							if(!isset($current_cats[$current_item_cat->parent] )) {
								$current_cats[$current_item_cat->parent] = 0;
							}

							$current_cats[$current_item_cat->parent] ++;
						}

					}
				}
			}

		}

		$current_cats = array_merge($current_cats, $current_parents);

		ob_start(); ?>

		<ul class="products-filter">

			<?php foreach ($get_categories as $category):

				if (in_array($category->term_id, $current_cats)) {

					$nicename = str_replace('%', '', $category->category_nicename); ?>

					<?php if (in_array($category->term_id, $current_cats)): ?>
						<li><a href="javascript:void(0)" data-filter="<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)) ?></a></li>
					<?php endif; ?>

				<?php } ?>

			<?php endforeach; ?>

		</ul><!--/ .products-filter-->

		<?php return ob_get_clean();
	}

	public function add_filter_classes($params) {
		if ( $params['filter'] == 'yes' ) {
			add_filter('post_class', array(&$this, 'post_class_filter'));
		}
	}

	public function post_class_filter($classes) {

		$params = $this->atts;
		$current_cats = $current_parents = array();
		$display_cats = is_array($params['categories']) ? $params['categories'] : array_filter(explode(',', $params['categories']));

		if ($current_item_cats = get_the_terms( get_the_ID(), $params['taxonomy'] )) {

			if (isset($current_item_cats) && !empty($current_item_cats)) {
				foreach ($current_item_cats as $current_item_cat) {

					if (in_array($current_item_cat->term_id, $display_cats)) {
						$current_cats[$current_item_cat->slug];
					}

					if (in_array($current_item_cat->parent, $display_cats)) {
						$current_parents[$current_item_cat->parent] = $current_item_cat->parent;
					}

				}
			}
		}

		$terms = array();
		$current_cats = array_merge($current_cats, $current_parents);

		if ( !empty($current_cats) ) {
			foreach( $current_cats as $cat ) {
				$term = get_term($cat, 'product_cat');
				$terms[] = $term->slug;
			}
		}

		$classes[] = str_replace('%', '', implode(' ', $terms));
		return $classes;
	}

	public function post_new_filter($classes) {
		$postdate 		= get_the_time( 'Y-m-d' );
		$postdatestamp 	= strtotime( $postdate );
		$newness 		= get_option( 'wc_nb_newness' );
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
			$classes[] = 'new-badge';
		}
		return $classes;
	}

	protected function html() {

		if ( empty($this->products) || empty($this->products->posts) ) return;

		$products = $this->products;
		$params = $this->atts;
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';
		$title = $tag_title = $title_color = $description = $type = $layout = $columns = $filter = $pagination = '';

		$data_attributes = array();

		extract($params);

		ob_start();

		if ( $products->have_posts() ) : ?>

			<?php
				$atts = array(
					'columns' => $columns,
					'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
				);

				$css_classes = array(
					'wpb_content_element',
					'products-container',
					$type, $layout,
					'shop-columns-' . absint($columns),
					'paginate-' . $pagination
				);

				if ( $type == 'view-grid' ) {
					$css_classes[] = 'isotope_products';
				}

				if ( $filter == 'yes' ) { $css_classes[] = 'with-filter'; }

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
			?>

			<div <?php echo TERMINUS_HELPER::create_data_string($atts) ?> class="<?php echo esc_attr( trim( $css_class ) ) ?>">

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

				<?php if ( $filter == 'yes' ): ?>
					<?php echo $this->sort_cat_links( $products, $params ); ?>
				<?php endif; ?>

				<?php woocommerce_product_loop_start(); ?>

				<?php $delay = 0; ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php $this->add_filter_classes( $params ); ?>

					<?php
					$classes = array('product_item');

					if ( '' !== $css_animation ) {
						$classes[] = 'terminus_animated';
						$data_attributes[''] = TERMINUS_HELPER::create_data_string_animation( $css_animation, $delay, '' );
					}
					?>

					<div <?php post_class( $classes ); ?> <?php echo implode( ' ', array_filter($data_attributes) ) ?>>

						<div class="product_box">

							<?php
							/**
							 * woocommerce_before_shop_loop_item hook.
							 *
							 * @hooked woocommerce_template_loop_product_link_open - 10
							 */
							do_action( 'woocommerce_before_shop_loop_item' );

							/**
							 * woocommerce_before_shop_loop_item_title hook.
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

							<div class="product_details_area">

								<div class="details_outer">

									<div class="details_inner">

										<?php
										/**
										 * woocommerce_shop_loop_item_title hook.
										 *
										 * @hooked woocommerce_template_loop_product_title - 10
										 */
										do_action( 'woocommerce_shop_loop_item_title' );

										/**
										 * woocommerce_after_shop_loop_item_title hook.
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );

										/**
										 * woocommerce_after_shop_loop_item hook.
										 *
										 * @hooked woocommerce_template_loop_product_link_close - 5
										 * @hooked woocommerce_template_loop_add_to_cart - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item' );
										?>

									</div>
								</div>
							</div><!--/ .product_details_area-->

						</div><!--/ .product_box-->

					</div><!--/ .product_item-->

					<?php $delay = $delay + 100; ?>

				<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php if ( $pagination == 'yes' && $filter == '' ): ?>
					<?php echo terminus_pagination($this->products); ?>
				<?php endif; ?>

			</div><!--/ .products-container-->

		<?php else : ?>

			<?php if (!woocommerce_product_subcategories(array('before' => '<ul class="products">', 'after' => '</ul>' ))) : ?>
				<div class="woocommerce-error">
					<div class="messagebox_text">
						<p><?php esc_html_e( 'No products found which match your selection.', 'terminus' ) ?></p>
					</div><!--/ .messagebox_text-->
				</div><!--/ .woocommerce-error-->
			<?php endif; ?>

		<?php endif; ?>

		<?php
			woocommerce_reset_loop();
			wp_reset_postdata();
		?>

		<?php return ob_get_clean();
	}

}