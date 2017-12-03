<?php

/* ---------------------------------------------------------------------- */
/*	Product Custom Tab Filter
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_woocommerce_product_custom_tab') ) {

	function terminus_woocommerce_product_custom_tab($key) {
		global $post;

		$title_product_tab = $content_product_tab = '';
		$custom_tabs_array = get_post_meta($post->ID, 'terminus_custom_tabs', true);
		$custom_tab = $custom_tabs_array[$key];

		extract($custom_tab);

		if ( $title_product_tab != '' ) {

			preg_match("!\[embed.+?\]|\[video.+?\]!", $content_product_tab, $match_video);
			preg_match("!\[(?:)?gallery.+?\]!", $content_product_tab, $match_gallery);

			if (!empty($match_video)) {

				global $wp_embed;

				$video = $match_video[0];
				$before = "<div class='iframe_wrap entry_media'>";
				$before .= do_shortcode($wp_embed->run_shortcode($video));
				$before .= "</div>";
				echo apply_filters('the_content', $before);

			} elseif ( !empty($match_gallery) ) {

				$gallery = $match_gallery[0];
				if (strpos($gallery, 'vc_') === false) {
					$gallery = str_replace("gallery", 'terminus_gallery image_size="848*370"', $gallery);
				}
				echo do_shortcode(apply_filters('the_content', $gallery));

			} else {
				echo do_shortcode($content_product_tab);
			}

		}

	}
}

/* ---------------------------------------------------------------------- */
/*	Out of stock flash
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_woocommerce_show_product_loop_out_of_sale_flash') ) {
	function terminus_woocommerce_show_product_loop_out_of_sale_flash() {
		wc_get_template( 'loop/out-of-stock-flash.php' );
	}
}

/* ---------------------------------------------------------------------- */
/*	Single variation add to cart button
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_woocommerce_single_variation_add_to_cart_button') ) {
	function terminus_woocommerce_single_variation_add_to_cart_button() {
		global $product;
		?>
		<div class="variations_button">

			<table class="description-table">
				<tbody>
				<tr>
					<td><?php esc_html_e('Qty', 'terminus'); ?>:</td>
					<td class="product-quantity">
						<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
					</td>
				</tr>
				</tbody>
			</table><!--/ .description-table-->-

			<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />
		</div>
		<?php
	}
}

/* ---------------------------------------------------------------------- */
/*	Overwrite catalog ordering
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_overwrite_catalog_ordering') ) {

	function terminus_overwrite_catalog_ordering($args) {

		global $terminus_config;

		$keys = array('product_order', 'product_count', 'product_sort');
		if (empty($terminus_config['woocommerce'])) $terminus_config['woocommerce'] = array();

		foreach ($keys as $key) {
			if (isset($_GET[$key]) ) {
				$_SESSION['terminus_woocommerce'][$key] = esc_attr($_GET[$key]);
			}
			if (isset($_SESSION['terminus_woocommerce'][$key]) ) {
				$terminus_config['woocommerce'][$key] = $_SESSION['terminus_woocommerce'][$key];
			}
		}

		if(isset($_GET['product_order']) && !isset($_GET['product_sort']) && isset($_SESSION['terminus_woocommerce']['product_sort']))
		{
			unset($_SESSION['terminus_woocommerce']['product_sort'], $terminus_config['woocommerce']['product_sort']);
		}

		extract($terminus_config['woocommerce']);

		if (isset($product_order) && !empty($product_order)) {
			switch ( $product_order ) {
				case 'date'  : $orderby = 'date'; $order = 'desc'; $meta_key = '';  break;
				case 'price' : $orderby = 'meta_value_num'; $order = 'asc'; $meta_key = '_price'; break;
				case 'popularity' : $orderby = 'meta_value_num'; $order = 'desc'; $meta_key = 'total_sales'; break;
				case 'title' : $orderby = 'title'; $order = 'asc'; $meta_key = ''; break;
				case 'default':
				default : $orderby = 'menu_order title'; $order = 'asc'; $meta_key = ''; break;
			}
		}

		if (!empty($product_count) && is_numeric($product_count)) {
			$terminus_config['shop_overview_product_count'] = (int) $product_count;
		}

		if (!empty($product_sort)) {
			switch ( $product_sort ) {
				case 'desc' : $order = 'desc'; break;
				case 'asc' : $order = 'asc'; break;
				default : $order = 'asc'; break;
			}
		}

		if (isset($orderby)) $args['orderby'] = $orderby;
		if (isset($order)) 	$args['order'] = $order;

		if (!empty($meta_key)) {
			$args['meta_key'] = $meta_key;
		}

		$terminus_config['woocommerce']['product_sort'] = $args['order'];

		return $args;
	}

	add_action( 'woocommerce_get_catalog_ordering_args', 'terminus_overwrite_catalog_ordering');

}

/* ---------------------------------------------------------------------- */
/*	Change product thumbnail in products widget
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_widget_product_thumbnail') ) {

	function terminus_widget_product_thumbnail() {
		$id = get_the_ID();
		$size = 'shop_thumbnail';

		$gallery = get_post_meta($id, '_product_image_gallery', true);
		$attachment_image = '';
		if ( !empty($gallery) && terminus_get_option('widget-image-hover') ) {
			$gallery = explode(',', $gallery);
			$first_id = $gallery[0];
			$attachment_image = wp_get_attachment_image( $first_id , $size, false, array('class' => 'hover-image ') );
		}

		$thumb_image = get_the_post_thumbnail($id , $size);
		if ( !$thumb_image ) {
			if ( wc_placeholder_img_src() ) {
				$thumb_image = wc_placeholder_img( $size );
			}
		}

		$output = '<div class="inner'.(($attachment_image) ?' img-effect' : '').'">';

		// show images
		$output .= $thumb_image;
		$output .= $attachment_image;

		$output .= '</div>';

		echo $output;
	}

}
