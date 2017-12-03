
<?php
// reset all previous queries
wp_reset_postdata();

$terminus_post_id = terminus_post_id();
$terminus_custom_sidebar = '';

if ( is_singular() && !empty($terminus_post_id) ) {
	$terminus_custom_sidebar = rwmb_meta( 'terminus_page_sidebar', '', $terminus_post_id);
}

if ( empty($terminus_custom_sidebar) ) {
	$terminus_custom_sidebar = terminus_get_option('sidebar_setting_page');
}

if ( is_post_type_archive('product') || terminus_is_product_category() || terminus_is_product_tag() ) {

	$terminus_woo_shop_page_id = get_option('woocommerce_shop_page_id');

	if ( $terminus_woo_shop_page_id ) {
		$terminus_custom_sidebar = rwmb_meta( 'terminus_page_sidebar', '', $terminus_woo_shop_page_id);
	}

	if ( terminus_is_product_category() ) {
		$terminus_custom_sidebar = terminus_get_meta_value('sidebar');
	}

	if ( empty($terminus_custom_sidebar) ) {
		$terminus_custom_sidebar = terminus_get_option('sidebar_setting_product');
	}

} elseif ( terminus_is_product() ) {

	if ( !empty($terminus_post_id) ) {
		$terminus_custom_sidebar = rwmb_meta( 'terminus_page_sidebar', '', $terminus_post_id);
	}

	if (empty($terminus_custom_sidebar)) {
		$terminus_custom_sidebar = terminus_get_option('sidebar_setting_product');
	}

}

?>

<aside id="sidebar" class="col-sm-4">
	<?php
	if ( !empty($terminus_custom_sidebar) ) {
		dynamic_sidebar($terminus_custom_sidebar);
	} else {
		if (is_active_sidebar('general-widget-area')) {
			dynamic_sidebar('General Widget Area');
		} else {
		 ?>
			<div class="widget widget_archive">
				<h3 class="widget_title"><?php esc_html_e('Archives', 'terminus'); ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</div><!--/ .widget -->

			<div class="widget widget_meta">
				<h3 class="widget_title"><?php esc_html_e('Meta', 'terminus'); ?></h3>
				<ul>
					<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</div><!--/ .widget -->
		<?php
		}
	}
	?>
</aside>


