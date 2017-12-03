<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product; ?>

<?php if (terminus_get_option('product_featured')): ?>

	<?php if ( $product->is_featured() ) : ?>
		<?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'terminus' ) . '</span>', $post, $product ); ?>
	<?php endif; ?>

<?php endif; ?>

<?php if (terminus_get_option('product_sale')): ?>

	<?php
		$percentage = 0;

		if ( class_exists('TERMINUS_FLASHSALE_MOD') ) {
			$flash_sale_percentage = TERMINUS_FLASHSALE_MOD::on_price_percentage();
		}
	?>

	<?php if ( $product->is_on_sale() || !empty($flash_sale_percentage) ) : ?>

		<?php

		if ( $product->get_regular_price() ) {
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		}

		if ( !empty($flash_sale_percentage) ) {
			$percentage = $flash_sale_percentage;
		}

		if ( terminus_get_option('product_sale_percent') && $percentage ) {
			echo '<span class="label_offer_percentage"><span>' . $percentage . '%</span>' . esc_html__('OFF', 'terminus') . '</span>';
		} else {
			echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'terminus' ) . '</span>', $post, $product );
		}
		?>

	<?php endif; ?>

<?php endif; ?>
