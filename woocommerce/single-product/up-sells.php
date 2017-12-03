<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop, $terminus_config;

$terminus_config['shop_single_up_sells_column'] = ($terminus_config['sidebar_position'] != 'no_sidebar') ? 3 : 4;
$woocommerce_loop['columns'] = $columns;

if ( $upsells ) : ?>

	<div class="section-offset">

		<div class="upsells">

			<h3><?php esc_html_e( 'You may also like&hellip;', 'terminus' ) ?></h3>

			<div data-sidebar="<?php echo esc_attr($terminus_config['sidebar_position']); ?>" class="products-container view-carousel type_1 <?php echo 'shop-columns-' . absint($terminus_config['shop_single_up_sells_column']) ?>">

				<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

				<?php woocommerce_product_loop_end(); ?>

			</div>

		</div>

	</div>

<?php endif;

wp_reset_postdata();
