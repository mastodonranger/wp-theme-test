<?php

if (!class_exists('TERMINUS_WOOCOMMERCE_CONFIG')) {

	class TERMINUS_WOOCOMMERCE_CONFIG {

		public $action_product_share = 'terminus_action_product_share';
		public $action_quick_view = 'terminus_action_add_product_popup';
		public $action_login = 'terminus_action_login_popup';
		public $paths = array();
		public static $pathes = array();

		public function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file) {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct() {

			// Woocommerce support
			add_theme_support('woocommerce');

			$dir = get_template_directory() . '/config-woocommerce';

			define('TERMINUS_WOO_CONFIG', true);

			$this->paths = array(
				'PHP' => $dir . '/php/',
				'TEMPLATES' => $dir . '/templates/',
				'ASSETS_DIR_NAME' => 'assets',
				'WIDGETS_DIR' => $dir . '/widgets/',
				'BASE_URI' => get_template_directory_uri() . '/config-woocommerce/'
			);

			self::$pathes = $this->paths;

			include( $this->paths['PHP'] . 'functions.php' );
			include( $this->paths['PHP'] . 'ordering.class.php' );
			include( $this->paths['PHP'] . 'new-badge.class.php' );
			include( $this->paths['PHP'] . 'common-tab.class.php' );

			include( $this->paths['PHP'] . 'dropdown-cart.class.php' );
			include( $this->paths['PHP'] . 'quick-popups.class.php' );

			add_action('wp_loaded', array($this, 'wp_loaded'));

			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('wp_enqueue_scripts', array(&$this, 'add_enqueue_scripts'));
			add_action('terminus_pre_import_hook', array(&$this, 'woo_product_settings_update'));

			include( $this->paths['PHP'] . 'currency-switcher.class.php' );
		}

		public function wp_loaded() {
			$this->global_config();
			$this->remove_actions();
			$this->add_actions();
			$this->add_filters();
		}

		public function admin_init() {
			add_filter("manage_product_posts_columns", array(&$this, "manage_columns"));
		}

		public function custom_get_option($key = false, $default = "") {

			$result = get_option('terminus_options');

			if (is_array($key) ) {
				$result = $result[$key[0]];
			} else {
				$result = $result['terminus'];
			}

			if ( $key === false ) {
			} else if ( isset($result[$key]) ) {
				$result = $result[$key];
			} else {
				$result = $default;
			}

			if ($result == "") { $result = $default; }
			return $result;
		}

		public function global_config() {
			global $terminus_config;

			$terminus_config['shop_overview_column_count']  = $this->custom_get_option('woocommerce_column_count');
			$terminus_config['shop_overview_product_count'] = $this->custom_get_option('woocommerce_product_count');

			if ( empty($terminus_config['shop_overview_column_count']) )
				$terminus_config['shop_overview_column_count'] = 4;

			if ( empty($terminus_config['shop_overview_product_count']) )
				$terminus_config['shop_overview_product_count'] = 12;

		}

		public function add_filters() {
			add_filter('woocommerce_enqueue_styles', '__return_empty_array');

			add_filter('woocommerce_general_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_page_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_catalog_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_inventory_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_shipping_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_tax_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_product_settings', array(&$this, 'woocommerce_general_settings_filter'));

			add_filter('woocommerce_available_variation', array($this, 'woocommerce_available_variation'), 10, 3);

			add_filter('loop_shop_columns', array(&$this, 'woocommerce_loop_columns'));
			add_filter('loop_shop_per_page', array(&$this, 'woocommerce_product_count'));
		}

		public function remove_actions() {
			remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
			remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

			remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
			remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

			remove_action('woocommerce_product_tabs', 'woocommerce_default_product_tabs');
		}

		public function add_actions() {

			/* Archive Hooks */
			add_action('woocommerce_product_tabs', array(&$this, 'woocommerce_default_product_tabs'));
			add_action('woocommerce_archive_description', array(&$this, 'woocommerce_ordering_products'));
			add_action('woocommerce_before_single_product_summary', 'terminus_woocommerce_show_product_loop_out_of_sale_flash');

			/* Content Product Hooks */
			add_action('woocommerce_before_shop_loop_item_title', array(&$this, 'template_loop_product_thumbnail'));
			add_action('woocommerce_shop_loop_item_title', array(&$this, 'template_loop_product_title'));
			add_action('woocommerce_after_shop_loop_item_title', array(&$this, 'template_after_shop_loop_item_title'));

			add_action('terminus_after_product_thumbs', array($this, 'template_after_product_thumbs'));

			/* Single Product Hooks */
			add_action('woocommerce_before_add_to_cart_form', array(&$this, 'before_add_to_cart_form'), 10);
			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
			add_action('woocommerce_single_product_summary', array($this, 'template_single_countdown'), 10);
			add_action('woocommerce_after_add_to_cart_form', array(&$this, 'after_add_to_cart_form'), 10);

			add_action('woocommerce_share', array($this, 'share_btn'));

			// Ajax
			add_action( 'wp_ajax_' . $this->action_quick_view, array(&$this, 'ajax_product_popup') );
			add_action( 'wp_ajax_nopriv_' . $this->action_quick_view, array(&$this, 'ajax_product_popup') );
			add_action( 'wp_ajax_nopriv_' . $this->action_login, array(&$this, 'ajax_form_login') );
			add_action( 'wp_ajax_' . $this->action_product_share, array($this, 'ajax_product_share') );
			add_action( 'wp_ajax_nopriv_' . $this->action_product_share, array($this, 'ajax_product_share') );
		}

		public function template_loop_product_thumbnail() {
			terminus_woocommerce_show_product_loop_out_of_sale_flash();
			$this->product_thumbnail();
		}

		public function ajax_product_share() {
			check_ajax_referer($this->action_product_share);

			$post_id = $_REQUEST['post_id'];
			$image = esc_url(wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ));
			$permalink = esc_url(get_the_permalink( $post_id ));
			$title = esc_attr(get_the_title( $post_id ));
			?>
			<div class="share_popup">
				<h3><?php esc_html_e('Share This Product', 'terminus') ?>:</h3>
				<ul class="social_links">
					<li><a target="_blank" href="http://www.facebook.com/sharer.php?m2w&amp;s=100&amp;p&#091;url&#093;=<?php echo $permalink ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo $image ?>&amp;p&#091;title&#093;=<?php echo $title ?>" class="btn icon_only large rd-white tooltip_container" title="<?php esc_html_e('Facebook', 'terminus') ?>"><span class="tooltip top"><?php esc_html_e('Facebook', 'terminus') ?></span><i class="icon-facebook"></i></a></li>
					<li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title ?>&amp;url=<?php echo $permalink ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Twitter', 'terminus') ?></span><i class="icon-twitter"></i></a></li>
					<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Google+', 'terminus') ?></span><i class="icon-gplus"></i></a></li>
					<li><a target="_blank" href="https://pinterest.com/pin/create/link/?url=<?php echo $permalink ?>&amp;media=<?php echo $image ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Pinterest', 'terminus') ?></span><i class="icon-pinterest-circled"></i></a></li>
					<li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink ?>&amp;title=<?php echo $title ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('LinkedIn', 'terminus') ?></span><i class="icon-linkedin"></i></a></li>
				</ul>
			</div>
			<?php wp_die();
		}

		public function share_btn($post_id) {
			?>
			<a class="product-share-button btn rd-grey middle" href="javascript:void(0)" data-post-id="<?php echo esc_attr($post_id) ?>" data-modal-action="<?php echo esc_attr($this->action_product_share) ?>" data-modal-nonce="<?php echo esc_attr(wp_create_nonce($this->action_product_share)) ?>"><?php esc_html_e('Share', 'terminus') ?></a>
			<?php
		}

		public function template_loop_product_title() {
			echo '<a class="product_name" href="'. esc_url(get_the_permalink()) .'">' . terminus_string_truncate(get_the_title(), terminus_get_option('excerpt_count_product_title', 100), ',') . '</a>';
		}

		public function template_after_shop_loop_item_title() {
			woocommerce_template_loop_price();
			$this->short_description_output();
			$this->actions_output();
			$this->buttons_actions_output();
		}

		public function manage_columns($columns) {
			unset($columns['wpseo-title']);
			unset($columns['wpseo-metadesc']);
			unset($columns['wpseo-focuskw']);

			return $columns;
		}

		function woocommerce_available_variation($variations, $product, $variation) {

			if ( has_post_thumbnail( $variation->get_variation_id() ) ) {
				$attachment_id = get_post_thumbnail_id( $variation->get_variation_id() );

				$image_thumb_link = wp_get_attachment_image_src($attachment_id, 'shop_thumbnail');
				$variations = array_merge( $variations, array( 'image_thumb' => $image_thumb_link[0] ) );

				$image_thumb_link = wp_get_attachment_image_src($attachment_id, 'shop_single');
				$variations = array_merge( $variations, array( 'image_src' => $image_thumb_link[0] ) );
			} else if ( has_post_thumbnail() ) {
				$attachment_id = get_post_thumbnail_id();

				$image_thumb_link = wp_get_attachment_image_src($attachment_id, 'shop_thumbnail');
				$variations = array_merge( $variations, array( 'image_thumb' => $image_thumb_link[0] ) );

				$image_thumb_link = wp_get_attachment_image_src($attachment_id, 'shop_single');
				$variations = array_merge( $variations, array( 'image_src' => $image_thumb_link[0] ) );
			}
			return $variations;
		}

		public function woocommerce_loop_columns() {
			global $terminus_config;

			$woocommerce_columns = $terminus_config['shop_overview_column_count'];
			$overview_column_count = terminus_get_meta_value('overview_column_count');

			if (!empty($overview_column_count) ) { $woocommerce_columns = $overview_column_count; }

			return $woocommerce_columns;
		}

		public function woocommerce_product_count() {
			global $terminus_config;
			return $terminus_config['shop_overview_product_count'];
		}

		public function ajax_product_popup() {
			check_ajax_referer($this->action_quick_view);

			$popups = new TERMINUS_QUICK_POPUPS(absint($_POST['id']));
			echo $popups->output_quick_view_html();
			wp_die();
		}

		public function ajax_form_login() {
			check_ajax_referer($this->action_login);

			$popups = new TERMINUS_QUICK_POPUPS($_POST['href']);
			echo $popups->output_login_html();
			wp_die();
		}

		public function add_enqueue_scripts() {

			$css_file = $this->assetUrl('css/woocommerce-mod' . (WP_DEBUG ? '' : '.min') . '.css');
			$woo_mod_file = $this->assetUrl('js/woocommerce-mod' . (WP_DEBUG ? '' : '.min') . '.js');
			$woo_zoom_file = $this->assetUrl('js/elevatezoom.min.js');

			wp_enqueue_style( 'terminus_woocommerce-mod', $css_file );
			wp_enqueue_script( 'terminus_woocommerce-mod', $woo_mod_file, array('jquery', 'terminus_plugins', 'terminus_core'), 1, true );
			wp_enqueue_script( 'terminus_elevate-zoom', $woo_zoom_file, array('jquery', 'terminus_woocommerce-mod') );

			wp_localize_script('terminus_woocommerce-mod', 'terminus_woocommerce_mod', array(
				'ajaxurl' => version_compare( WC()->version, '2.4', '>=' ) ? WC_AJAX::get_endpoint( "%%endpoint%%" ) : admin_url( 'admin-ajax.php', 'relative' ),
				'nonce_cart_item_remove' => wp_create_nonce( 'terminus_cart_item_remove' ),
				'action_quick_view' => $this->action_quick_view,
				'action_login' => $this->action_login
			));

		}

		public function woocommerce_ordering_products() {
			$ordering = new TERMINUS_CATALOG_ORDERING( $this->custom_get_option('products_filter') );
			echo $ordering->output();
		}

		public function product_thumbnail() {
			global $product;
			$shop_catalog = wc_get_image_size( 'shop_catalog' );
			$thumbnail_id[] = get_post_thumbnail_id();
			$gallery_ids = $product->get_gallery_image_ids();
			$attachment_ids = array_merge($thumbnail_id, $gallery_ids);
			?>

			<div class="product_image_area">

				<a class="product_images" href="<?php echo esc_url(get_the_permalink()); ?>">
					<?php
					$thumb_image = TERMINUS_HELPER::get_the_post_thumbnail(get_the_ID(), $shop_catalog['width'] . '*' . $shop_catalog['height'], $shop_catalog['crop'], '', array('class' => 'front_img', 'alt' => get_the_title()));
					if ( !$thumb_image ) {
						$thumb_image = wc_placeholder_img( 'shop_catalog' );
					}
					echo $thumb_image;
					echo $this->second_thumbnail();
					?>
				</a>

				<?php echo $this->actions_output(); ?>

				<?php if ( terminus_get_option('product_thumbs') ): ?>

					<?php if ( $attachment_ids && count($attachment_ids) > 1 ): ?>

						<!-- - - - - - - - - - - - - - Product Thumbs - - - - - - - - - - - - - - - - -->

						<div class="product_thumbs_wrap move_scroll">

							<ul class="product_thumbs move_scroll_inner">

								<?php
								$loop = 0;
								foreach ( $attachment_ids as $attachment_id ) {
									$classes = array();

									if ( $loop == 0 )
										$classes[] = 'active';

									$image_src = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );

									if ( ! $image_src )
										continue;

									$image_class = esc_attr( implode( ' ', $classes ) );
									$image_title = esc_attr( get_the_title( $attachment_id ) );
									$image = wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, array( 'alt' => $image_title ) );
									echo sprintf( '<li class="%s" data-large-image="%s">%s</li>', $image_class, $image_src[0], $image );
									$loop++;
								}
								?>

							</ul><!--/ .product_thumbs-->

						</div><!--/ .product_thumbs_wrap-->

						<!-- - - - - - - - - - - - - - End of Product Thumbs - - - - - - - - - - - - - - - - -->

					<?php endif; ?>

				<?php endif; ?>

				<?php do_action('terminus_after_product_thumbs'); ?>

			</div><!--/. product_image_area-->

			<?php do_action('woocommerce_after_thumbnail'); ?>

		<?php
		}

		public function second_thumbnail() {
			$id = terminus_post_id();
			$shop_catalog = wc_get_image_size('shop_catalog');
			$product_gallery = get_post_meta( $id, '_product_image_gallery', true );

			if ( !empty($product_gallery) ) {
				$gallery  = explode(',', $product_gallery);
				$image_id = $gallery[0];

				$image = TERMINUS_HELPER::get_the_thumbnail( $image_id, $shop_catalog['width'] . '*' . $shop_catalog['height'], $shop_catalog['crop'], '', array('class' => 'back_img', 'alt' => get_the_title()) );

				if ( !empty($image) ) return $image;
			}
		}

		function woocommerce_general_settings_filter($options) {
			$delete = array('woocommerce_enable_lightbox');

			foreach ( $options as $key => $option ) {
				if (isset($option['id']) && in_array($option['id'], $delete)) {
					unset($options[$key]);
				}
			}
			return $options;
		}

		public static function content_truncate($string, $limit, $break = ".", $pad = "...") {
			if (strlen($string) <= $limit) { return $string; }

			if (false !== ($breakpoint = strpos($string, $break, $limit))) {
				if ($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
			if (!$breakpoint && strlen(strip_tags($string)) == strlen($string)) {
				$string = substr($string, 0, $limit) . $pad;
			}
			return $string;
		}

		public static function create_data_string($data = array()) {
			$data_string = "";

			foreach($data as $key => $value) {
				if (is_array($value)) $value = implode(", ", $value);
				$data_string .= " data-$key={$value} ";
			}
			return $data_string;
		}

		function short_description_output() {
			global $product;
			$post_content = !empty($product->post_excerpt) ? $product->post_excerpt : '';
			$post_content = apply_filters('the_excerpt', $post_content);
			?>
			<?php if ( !empty($post_content) ): ?>
				<div class="product_description"><?php echo str_replace(']]>', ']]&gt;', $post_content); ?></div>
			<?php endif; ?>
		<?php
		}

		public function actions_output() { ?>

			<!-- - - - - - - - - - - - - - Product actions - - - - - - - - - - - - - - - - -->

			<div class="product_actions">

				<?php if ( terminus_get_option('quick_view') ): ?>
					<div class="quick-view-button">
						<a href="javascript:void(0)" data-id="<?php echo get_the_ID() ?>" data-modal-action="<?php echo esc_attr($this->action_quick_view); ?>" data-modal-nonce="<?php echo esc_attr(wp_create_nonce($this->action_quick_view)) ?>" class="quick-view tooltip_container">
							<span class="tooltip"><?php esc_html_e('Quick View', 'terminus') ?></span>
							<div class="si-btn-quick-view"></div>
						</a>
					</div>
				<?php endif; ?>

				<?php do_action('terminus-product-actions'); ?>

			</div><!--/ .product_actions-->

			<!-- - - - - - - - - - - - - - End of product actions - - - - - - - - - - - - - - - - -->

			<?php
		}

		public function buttons_actions_output() {
			?>
				<div class="buttons_set">

					<?php woocommerce_template_loop_add_to_cart(); ?>

					<?php do_action('terminus-product-actions'); ?>

					<?php if (terminus_get_option('quick_view')): ?>
						<div class="quick-view-button">
							<a href="javascript:void(0)" data-id="<?php echo get_the_ID() ?>" data-modal-action="<?php echo esc_attr($this->action_quick_view); ?>" data-modal-nonce="<?php echo esc_attr(wp_create_nonce($this->action_quick_view)) ?>" class="quick-view tooltip_container">
								<span class="tooltip"><?php esc_html_e('Quick View', 'terminus') ?></span>
								<div class="si-btn-quick-view"></div>
							</a>
						</div>
					<?php endif; ?>

				</div><!--/ .buttons_set-->
			<?php
		}

		public function before_add_to_cart_form() { echo '<div class="description_section">'; }
		public function after_add_to_cart_form()  { echo '</div>'; }

		public function template_single_countdown() {
			global $product;

			if ( trim( $product->get_type() ) != 'variable' ) {
				$time_from = get_post_meta($product->get_id(), "_sale_price_dates_from", true);
				$time_end = get_post_meta($product->get_id(), "_sale_price_dates_to", true);

				if ( $time_from && $time_end ) { ?>
					<div class="description_section">
						<div class="limited">
							<span><?php esc_html_e('This limited offer ends in', 'terminus') ?>:</span>
							<?php echo $this->template_woocommerce_countdown('single_'); ?>
						</div>
					</div>
					<?php
				}
			}
		}

		public function template_after_product_thumbs() {
			$this->template_woocommerce_countdown();
		}

		function template_woocommerce_countdown($prefix = '') {
			global $product;

			if ( trim( $product->get_type()  ) != 'variable' ) {
				$time_from = get_post_meta( $product->get_id(), "_sale_price_dates_from", true );
				$time_end  = get_post_meta( $product->get_id(), "_sale_price_dates_to", true );

				if ( $time_from && $time_end ) { ?>

					<?php
					$date_text = ', showText:0';
					$localization = ', localization:{ days: "' . esc_html__( 'Days', 'terminus' ) . '", hours: "' . esc_html__( 'Hours', 'terminus' ) . '", minutes: "' . esc_html__( 'Minutes', 'terminus' ) . '", seconds: "' . esc_html__( 'Seconds', 'terminus' ) . '" }';
					$current_time = strtotime( current_time( "Y-m-d G:i:s" ) );
					$rand = rand(9, 999);

					if ( $current_time < $time_from ) {
						$time = $time_from;
					} else {
						$time = $time_end;
					} ?>

					<div class="countdown" id="<?php echo esc_attr($prefix) ?>countdown_<?php echo absint($rand); ?>"></div>

					<?php echo "<script type='text/javascript'>
						jQuery(function () {
							jQuery('#" . esc_attr($prefix) . "countdown_" . absint($rand) . "').mbComingsoon({ expiryDate: new Date(" . date( "Y", $time ) . ", " . ( date( "m", $time ) - 1 ) . ", " . date( "d", $time ) . "), speed: 500, gmt:" . get_option( 'gmt_offset' ) . ' ' . $localization .  " });
						});
					</script>";
				}
			}

		}

		function woocommerce_default_product_tabs( $tabs = array() ) {
			global $product, $post;

			// Description tab - shows product content
			if ( $post->post_excerpt ) {
				$tabs['description'] = array(
					'title'    => esc_html__( 'Description', 'terminus' ),
					'priority' => 10,
					'callback' => 'woocommerce_product_description_tab'
				);
			}

			// Additional information tab - shows attributes
			if ( $product && ( $product->has_attributes() || ( $product->enable_dimensions_display() && ( $product->has_dimensions() || $product->has_weight() ) ) ) ) {
				$tabs['additional_information'] = array(
					'title'    => esc_html__( 'Additional Information', 'terminus' ),
					'priority' => 20,
					'callback' => 'woocommerce_product_additional_information_tab'
				);
			}

			// Reviews tab - shows comments
			if ( comments_open() ) {
				$tabs['reviews'] = array(
					'title'    => sprintf( __( 'Reviews (%d)', 'terminus' ), $product->get_review_count() ),
					'priority' => 30,
					'callback' => 'comments_template'
				);
			}

			return $tabs;
		}

		public function woo_product_settings_update() {

			$wc_product_settings = array(
				'woocommerce_default_country' => 'US:CA',
				'wc_currency_codes' => 'USD
				EUR
				GBP',
				'woocommerce_default_catalog_orderby' => 'menu_order',
				'woocommerce_currency' => 'USD',
				'woocommerce_shop_page_id' => '267',
				'woocommerce_cart_page_id' => '268',
				'woocommerce_checkout_page_id' => '269',
				'woocommerce_terms_page_id' => '',
				'woocommerce_myaccount_page_id' => '270',
				'yith_wcwl_wishlist_page_id' => '201',
				'woocommerce_enable_myaccount_registration' => 1
			);

			foreach ($wc_product_settings as $key => $option) {
				update_option($key, $option);
			}

		}

	}

	new TERMINUS_WOOCOMMERCE_CONFIG();

}