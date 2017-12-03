<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>

<?php if (terminus_get_option('product_featured')): ?>

	<?php if ( $product->is_featured() ) : ?>
		<?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'terminus' ) . '</span>', $post, $product ); ?>
	<?php endif; ?>

<?php endif; ?>

<?php if (terminus_get_option('product_sale')): ?>

	<?php $percentage = 0; ?>

	<?php if ( $product->is_on_sale() ) : ?>

		<?php

		if ( $product->get_regular_price() ) {
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		}

		if ( terminus_get_option('product_sale_percent') && $percentage ) {
			$sales_html = '<span class="label_offer_percentage"><span>' . $percentage . '%</span>' . esc_html__('OFF', 'terminus') . '</span>';
		} else {
			$sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'terminus' ) . '</span>', $post, $product );
		}
		?>

		<?php echo $sales_html; ?>

	<?php endif; ?>

<?php endif; ?>