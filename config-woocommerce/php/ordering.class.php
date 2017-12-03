<?php

if (!class_exists('TERMINUS_CATALOG_ORDERING')) {

	class TERMINUS_CATALOG_ORDERING {

		public $filter = true;

		function __construct($filter) {
			$this->filter = $filter;
		}

		public function woo_build_query_string ($params = array(), $key, $value) {
			$params[$key] = $value;
			$paged = (array_key_exists('product_count', $params)) ? 'paged=1&' : '';
			return "?" . $paged . http_build_query($params);
		}

		public function woo_active_class($key1, $key2) {
			if ($key1 == $key2) return " class='selected'";
		}

		public function output_html_without_filter() {

			global $terminus_config;
			parse_str($_SERVER['QUERY_STRING'], $params);

			$per_page = terminus_get_option('woocommerce_product_count');

			if ( !$per_page ) {
				$per_page = get_option('posts_per_page');
			}

			$product_order = array();
			$product_order['default'] 	= esc_html__("Default",'terminus');
			$product_order['title'] 	= esc_html__("Name",'terminus');
			$product_order['price'] 	= esc_html__("Price",'terminus');
			$product_order['date'] 		= esc_html__("Date",'terminus');
			$product_order['popularity'] = esc_html__("Popularity",'terminus');

			$product_sort['asc'] = esc_html__("Click to order products ascending",  'terminus');
			$product_sort['desc'] = esc_html__("Click to order products descending",  'terminus');

			$product_order_key = !empty($terminus_config['woocommerce']['product_order']) ? $terminus_config['woocommerce']['product_order'] : 'default';
			$product_sort_key =  !empty($terminus_config['woocommerce']['product_sort'])  ? $terminus_config['woocommerce']['product_sort'] : 'asc';
			$product_count_key = !empty($terminus_config['woocommerce']['product_count']) ? $terminus_config['woocommerce']['product_count'] : $per_page;

			$product_sort_key = strtolower($product_sort_key);
			?>

			<div class="col-sm-9">

				<div class="sort_item">

					<span><?php esc_html_e('Sort by', 'terminus') ?>:</span>

					<div class="custom_select">

						<div class="active_option"><?php echo esc_html($product_order[$product_order_key]) ?></div>

						<ul class="options_list">
							<li><a <?php echo esc_attr($this->woo_active_class($product_order_key, 'default')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'default')) ?>"><?php echo esc_html($product_order['default']) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_order_key, 'title')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'title')) ?>"><?php echo esc_html($product_order['title']) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_order_key, 'price')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'price')) ?>"><?php echo esc_html($product_order['price']) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_order_key, 'date')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'date')) ?>"><?php echo esc_html($product_order['date']) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_order_key, 'popularity')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'popularity')) ?>"><?php echo esc_html($product_order['popularity']) ?></a></li>
						</ul>

					</div><!--/ .custom_select-->

					<?php if ( $product_sort_key == 'desc' ): ?>
						<a title="<?php echo sprintf('%s', $product_sort['asc']) ?>" class="btn rd-grey big icon_only order-param-asc"  href="<?php echo esc_url($this->woo_build_query_string($params, 'product_sort', 'asc')) ?>"><i class="icon-sort-alt-down"></i></a>
					<?php endif; ?>

					<?php if ( $product_sort_key == 'asc' ): ?>
						<a title="<?php echo sprintf('%s', $product_sort['desc']) ?>" class="btn rd-grey big icon_only order-param-desc"  href="<?php echo esc_url($this->woo_build_query_string($params, 'product_sort', 'desc')) ?>"><i class="icon-sort-alt-down"></i></a>
					<?php endif; ?>

				</div><!--/ .sort_item -->

				<div class="sort_item">

					<span><?php esc_html_e('Show items per page', 'terminus') ?>:</span>

					<div class="custom_select items_per_page">

						<div class="active_option"><?php echo esc_html($product_count_key) ?></div>

						<ul class="options_list">
							<li><a <?php echo esc_attr($this->woo_active_class($product_count_key, $per_page)); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_count', $per_page)) ?>"><?php echo (int) esc_html($per_page) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_count_key, $per_page * 2)); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_count', $per_page * 2)) ?>"><?php echo (int) esc_html($per_page * 2) ?></a></li>
							<li><a <?php echo esc_attr($this->woo_active_class($product_count_key, $per_page * 3)); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_count', $per_page * 3)) ?>"><?php echo (int) esc_html($per_page * 3) ?></a></li>
						</ul>

					</div><!--/ .custom_select -->

				</div><!--/ .sort_item -->

			</div>

			<?php
		}

		public function output() {

			?>

			<header class="shop-page-meta">

				<div class="sort_settings">

					<div class="row">

						<?php echo $this->output_html_without_filter(); ?>

						<div class="col-sm-3">

							<?php
								$shop_view = terminus_get_meta_value('shop_view');
								if ( !isset($shop_view) || empty($shop_view) ) { $shop_view = terminus_get_option('shop-view', 'view-grid'); }
							?>

							<div class="sort_view">
								<a href="javascript:void(0)" data-view="view-grid" class="<?php if ( $shop_view == 'view-grid' ): ?>active<?php endif ?> btn rd-grey big icon_only tooltip_container"><span class="tooltip top"><?php esc_html_e('Grid View', 'terminus') ?></span><i class="icon-th"></i></a>
								<a href="javascript:void(0)" data-view="view-list" class="<?php if ( $shop_view == 'view-list' ): ?>active<?php endif ?> btn rd-grey big icon_only tooltip_container"><span class="tooltip top"><?php esc_html_e('List View', 'terminus') ?></span><i class="icon-menu"></i></a>
							</div>

						</div>

					</div>

				</div>

			</header><!--/ .shop-page-meta-->

			<?php
		}

	}
}

?>
