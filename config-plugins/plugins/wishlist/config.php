<?php

if (!class_exists('TERMINUS_WISHLIST_MOD')) {

	class TERMINUS_WISHLIST_MOD {

		function __construct() {

			if ( !class_exists('WooCommerce') ) return;

			if ( defined('YITH_WCWL') ) {

				if ( terminus_get_option('show_wishlist_list') ) {
					if ( get_option( 'yith_wcwl_enabled' ) == 'yes' ) {
						add_action( 'terminus-product-actions', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ) );
						add_action( 'woocommerce_single_product_summary', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 30 );
						add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_and_stuffs' ) );
					}
				}

				add_action( 'wp_ajax_terminus_add_count_products', array( $this, 'ajax_count_products' ) );
				add_action( 'wp_ajax_nopriv_terminus_add_count_products', array( $this, 'ajax_count_products' ) );

			}

		}

		public function enqueue_styles_and_stuffs() {
			wp_deregister_style('yith-wcwl-font-awesome');
		}

		public function ajax_count_products() {
			echo YITH_WCWL()->count_products();
		}

	}

}