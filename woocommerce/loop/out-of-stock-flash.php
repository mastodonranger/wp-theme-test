<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
global $product;

if ( !$product->is_in_stock() ) {
	$label  = apply_filters( 'terminus_out_of_stock_add_to_cart_text', esc_html__( 'Out of stock', 'terminus' ) ); ?>

	<?php printf( '<span class="out-of-stock">%s</span>', $label ); ?>

	<?php
}