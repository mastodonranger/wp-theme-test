<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce_loop, $terminus_config;

$woocommerce_columns = $terminus_config['shop_overview_column_count'];
$overview_column_count = terminus_get_meta_value('overview_column_count');

if ( !empty($overview_column_count) ) { $woocommerce_columns = $overview_column_count; }

$css_classes = array(
	'products-container',
	'view-grid'
);

if ( !terminus_is_product() ) {
	$css_classes[] = 'isotope_products';
}

$shop_view = terminus_get_option('shop-view');
if ( empty($shop_view) ) $shop_view = 'view-grid';

$product_layout = terminus_get_option('shop-layout');
if ( empty($product_layout) ) { $product_layout = 'type_1'; }

if ( empty($shop_view) ) {
	$shop_view = terminus_get_meta_value('shop_view');
}

if ( !empty($shop_view) ) { $css_classes[] = $shop_view; }

if ( !terminus_is_product() ) {
	if (!empty( $woocommerce_columns ) ) { $css_classes[] = 'shop-columns-' . absint($woocommerce_columns); }
	if (!empty( $product_layout ) ) 	 { $css_classes[] = $product_layout; }
}

$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
?>

<div class="<?php echo esc_attr( trim( $css_class ) ) ?>">