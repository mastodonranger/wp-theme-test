<?php

if ( ! function_exists( 'terminus_vc_manager' ) ) {
	function terminus_vc_manager() {
		return Terminus_Vc_Config::getInstance();
	}
}

if ( ! function_exists( 'terminus_vc_asset_url' ) ) {
	function terminus_vc_asset_url( $file ) {
		return terminus_vc_manager()->assetUrl( $file );
	}
}

if ( ! function_exists( 'terminus_get_sort_class' ) ) {
	function terminus_get_sort_class() {
		$classes = "";
		$item_categories = get_the_terms( get_the_ID(), 'portfolio_categories' );
		if ( is_object($item_categories) || is_array($item_categories) ) {
			foreach ($item_categories as $cat) {
				$classes .= $cat->slug . ' ';
			}
		}
		return str_replace( '%', '', $classes );
	}
}

if ( ! function_exists( 'terminus_portfolio_get_image_sizes') ) {
	function terminus_portfolio_get_image_sizes( $params, $id, $sidebar_position ) {
		$sizes = array();

		if ( $params['layout'] == 'masonry' ) {

			$image_size = rwmb_meta( 'terminus_image_size', '', $id );

			switch ( $image_size ) {
				case 'medium':
					$sizes['item_size'] = 'size_2';
					break;
			}

		}

		$sizes['image_size'] = Terminus_Custom_Content_Types_and_Taxonomies::get_image_sizes( $params, '', $sidebar_position, '' );
		return $sizes;
	}
}
