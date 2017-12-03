<?php

if (!class_exists('TERMINUS_COMPARE_MOD')) {

	class TERMINUS_COMPARE_MOD extends TERMINUS_PLUGINS_CONFIG {

		public $action_recount = 'action_recount';
		public $action_recount_after_remove = 'action_recount_after_remove';
		public $cookie_name = 'yith_woocompare_list';

		public $products_list = array();

		public $action_add = 'yith-woocompare-add-product';

		function __construct() {

			global $woocommerce;

			if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) { return; }

			if ( !class_exists('YITH_Woocompare_Frontend') ) return;

			if ( defined( 'YITH_WOOCOMPARE' ) ) {

				$frontend = new YITH_Woocompare_Frontend();

				remove_action('woocommerce_single_product_summary', array($frontend, 'add_compare_link'), 35);

				if ( terminus_get_option('show_compare_list') ) {
					if ( get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
						add_action( 'terminus-product-actions', array($this, 'compare_button') );
					}
				}

				if ( terminus_get_option('show_compare_list') ) {
					if ( get_option('yith_woocompare_compare_button_in_product_page') == 'yes' )  {
						add_action( 'woocommerce_single_product_summary', array( $this, 'compare_button_on_single' ), 35 );
					}
				}

				add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ), 1 );

				$this->products_list = isset( $_COOKIE[ $this->cookie_name ] ) && !empty($_COOKIE[ $this->cookie_name ]) ? maybe_unserialize( $_COOKIE[ $this->cookie_name ] ) : array();

				add_action( 'wp_ajax_' . $this->action_recount, array( $this, 'refresh_recount' ) );
				add_action( 'wp_ajax_nopriv_' . $this->action_recount, array( $this, 'refresh_recount' ) );

				add_action( 'wp_ajax_' . $this->action_recount_after_remove, array( $this, 'refresh_recount_after_remove' ) );
				add_action( 'wp_ajax_nopriv_' . $this->action_recount_after_remove, array( $this, 'refresh_recount_after_remove' ) );

			}

		}

		public function compare_button_on_single($product_id) {
			global $post, $product;
			$product_id = isset( $post->id ) ? $post->id : $product->get_id() ? $product->get_id() : 0;

			// return if product doesn't exist
			if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
				return;

			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Add to Compare', 'terminus' ) );
			?><div class="add-to-compare"><a href="<?php echo esc_url($this->add_product_url( $product_id )) ?>" class="mod-compare tooltip_container" data-product_id="<?php echo esc_attr($product_id) ?>" rel="nofollow"><?php echo esc_html($button_text) ?></a></div><?php
		}

		public function compare_button() {
			global $post, $product;
			$product_id = isset( $post->id ) ? $post->id : $product->get_id() ? $product->get_id() : 0;

			// return if product doesn't exist
			if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
				return;

			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Add to Compare', 'terminus' ) ); ?>
			<div class="compare-button">
				<a href="<?php echo esc_url($this->add_product_url( $product_id )) ?>" class="compare tooltip_container" data-product_id="<?php echo esc_attr($product_id) ?>" rel="nofollow">
					<span class="tooltip"><?php echo esc_html($button_text) ?></span>
					<div class="si-btn-compare"></div>
				</a>
			</div>
			<?php
		}

		public function add_product_url( $product_id ) {
			$url_args = array(
				'action' => $this->action_add,
				'id' => $product_id
			);
			return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args ) ), $this->action_add );
		}

		public function enqueue_scripts_and_styles() {

			$colorbox_css = self::$pathes['BASE_URI'] . 'compare/css/colorbox.css';
			$woocompare_js = self::$pathes['BASE_URI'] . 'compare/js/woocompare-mod.js';

			wp_enqueue_script('terminus_yith-woocompare-main', $woocompare_js, array('jquery', 'yith-woocompare-main'), '', true );
			wp_localize_script( 'terminus_yith-woocompare-main', 'terminus_yith_woocompare_mod', array(
				'action_recount' => $this->action_recount,
				'action_recount_after_remove' => $this->action_recount_after_remove,
			));

			wp_deregister_style( 'jquery-colorbox' );
			wp_enqueue_style( 'jquery-colorbox', $colorbox_css );

		}

		public function get_products_list() {
			$products_list = isset( $_COOKIE[ $this->cookie_name ] ) && !empty($_COOKIE[ $this->cookie_name ]) ? maybe_unserialize( $_COOKIE[ $this->cookie_name ] ) : array();
			return $products_list;
		}

		public function output_count() {
			$products_list = $this->products_list;

			if (!empty($products_list) && $products_list > 0) {
				echo count($products_list);
			} else {
				echo '0';
			}
		}

		public function refresh_recount() {
			echo $this->recount();
			die();
		}

		public function recount() {
			$this->output_count();
		}

		public function refresh_recount_after_remove() {
			echo $this->recount_after_remove();
			die();
		}

		public function recount_after_remove() {

			if ( ! isset( $_REQUEST['id'] ) ) die();

			if ( $_REQUEST['id'] == 'all' ) {
				$products = $this->products_list;
				foreach ( $products as $product_id ) {
					$this->remove_product_from_compare( intval( $product_id ) );
				}
			} else {
				$this->remove_product_from_compare( intval( $_REQUEST['id'] ) );
			}

			$this->output_count();

		}

		public function remove_product_from_compare( $product_id ) {
			foreach ( $this->products_list as $k => $id ) {
				if ( $product_id == $id ) unset( $this->products_list[$k] );
			}
			setcookie( $this->cookie_name, serialize( $this->products_list ), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
		}

	}

}