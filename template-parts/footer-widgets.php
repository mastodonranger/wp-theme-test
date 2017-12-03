<?php

if ( terminus_is_product() || terminus_is_product_category() || terminus_is_product_tag() || is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ) {
	$post_id = terminus_get_option('shop_get_widgets_page_id');
} else {
	$post_id = terminus_post_id();
}

$result = TERMINUS_WIDGETS_META_BOX::get_settings_from_post_meta($post_id);
extract($result);

if ( empty($footer_row_top_show) ) {
	$footer_row_top_show = (terminus_get_option('show_row_top_widgets') != '0') ? 'yes' : 'no';
}
if ( empty($footer_row_middle_show) ) {
	$footer_row_middle_show = (terminus_get_option('show_row_middle_widgets') != '0') ? 'yes' : 'no';
}
if ( empty($footer_row_bottom_show) ) {
	$footer_row_bottom_show = (terminus_get_option('show_row_bottom_widgets') != '0') ? 'yes' : 'no';
}
if ( empty($footer_row_top_columns_variations) ) {
	$footer_row_top_columns_variations = terminus_get_option('footer_row_top_columns_variations');
}
if ( empty($footer_row_middle_columns_variations) ) {
	$footer_row_middle_columns_variations = terminus_get_option('footer_row_middle_columns_variations');
}
if ( empty($footer_row_bottom_columns_variations) ) {
	$footer_row_bottom_columns_variations = terminus_get_option('footer_row_bottom_columns_variations');
}

if ( empty($get_sidebars_top_widgets) ) {
	$get_sidebars_top_widgets = array(
		'Footer Row - widget 11',
		'Footer Row - widget 12',
		'Footer Row - widget 13',
		'Footer Row - widget 14',
		'Footer Row - widget 15'
	);
}

if ( empty($get_sidebars_middle_widgets) ) {
	$get_sidebars_middle_widgets = array(
		'Footer Row - widget 1',
		'Footer Row - widget 2',
		'Footer Row - widget 3',
		'Footer Row - widget 4',
		'Footer Row - widget 5'
	);
}

if ( empty($get_sidebars_bottom_widgets) ) {
	$get_sidebars_bottom_widgets = array(
		'Footer Row - widget 6',
		'Footer Row - widget 7',
		'Footer Row - widget 8',
		'Footer Row - widget 9',
		'Footer Row - widget 10'
	);
}

?>

<?php if ( $footer_row_top_show == 'yes' || $footer_row_middle_show == 'yes' || $footer_row_bottom_show == 'yes' ): ?>

	<?php if ( $footer_row_top_show == 'yes' ): ?>

		<div class="footer_section small">

			<?php if ( $footer_row_top_full_width == 'yes' ): ?>

				<div class="fw_row">

			<?php else: ?>

				<div class="container">
					<div class="row">

			<?php endif; ?>

					<?php if (!empty($footer_row_top_columns_variations)):
						$number_of_top_columns = key( json_decode( html_entity_decode ( $footer_row_top_columns_variations ), true ) );
						$columns_top_array = json_decode( html_entity_decode ( $footer_row_top_columns_variations ), true );
						?>

						<?php for ($i = 1; $i <= $number_of_top_columns; $i++): ?>

							<div class="footer-col-<?php echo absint($columns_top_array[$number_of_top_columns][0][$i-1]); ?>">
								<?php if ( !dynamic_sidebar($get_sidebars_top_widgets[$i-1]) ) : endif; ?>
							</div>

						<?php endfor; ?>

					<?php endif; ?>

				<?php if ( $footer_row_top_full_width == 'yes' ): ?>

					</div><!--/ .fw_row-->

			<?php else: ?>

					</div><!--/ .row-->
				</div><!--/ .container-->

			<?php endif; ?>

		</div><!--/ .footer_section-->

	<?php endif; ?>

	<?php if ( $footer_row_middle_show == 'yes' ): ?>

		<div class="footer_section middle">

			<?php if ( $footer_row_middle_full_width == 'yes' ): ?>

				<div class="fw_row">

			<?php else: ?>

				<div class="container">
					<div class="row">

			<?php endif; ?>

				<?php if ( !empty($footer_row_middle_columns_variations) ):
					$number_of_middle_columns = key( json_decode( html_entity_decode ( $footer_row_middle_columns_variations ), true));
					$columns_middle_array = json_decode( html_entity_decode ( $footer_row_middle_columns_variations ), true );
					?>

					<?php for ( $i = 1; $i <= $number_of_middle_columns; $i++ ): ?>

						<div class="footer-col-<?php echo esc_attr($columns_middle_array[$number_of_middle_columns][0][$i-1]); ?>">
							<?php if ( !dynamic_sidebar($get_sidebars_middle_widgets[$i-1]) ) : endif; ?>
						</div>

					<?php endfor; ?>

				<?php endif; ?>

			<?php if ( $footer_row_middle_full_width == 'yes' ): ?>

					</div><!--/ .fw_row-->

				<?php else: ?>

						</div><!--/ .row-->
					</div><!--/ .container-->

			<?php endif; ?>

		</div><!--/ .footer_section-->

	<?php endif; ?>

	<?php if ( $footer_row_bottom_show == 'yes' ): ?>

		<div class="footer_section middle">

			<?php if ( $footer_row_bottom_full_width == 'yes' ): ?>

				<div class="fw_row">

			<?php else: ?>

				<div class="container">
					<div class="row">

			<?php endif; ?>

					<?php if ( !empty($footer_row_bottom_columns_variations) ):
						$number_of_bottom_columns = key( json_decode( html_entity_decode ( $footer_row_bottom_columns_variations ), true));
						$columns_bottom_array = json_decode( html_entity_decode ( $footer_row_bottom_columns_variations ), true );
						?>

						<?php for ( $i = 1; $i <= $number_of_bottom_columns; $i++ ): ?>

							<div class="footer-col-<?php echo esc_attr($columns_bottom_array[$number_of_bottom_columns][0][$i-1]); ?>">
								<?php if ( !dynamic_sidebar($get_sidebars_bottom_widgets[$i-1]) ) : endif; ?>
							</div>

						<?php endfor; ?>

					<?php endif; ?>

			<?php if ( $footer_row_bottom_full_width == 'yes' ): ?>

					</div><!--/ .fw_row-->

				<?php else: ?>

						</div><!--/ .row-->
					</div><!--/ .container-->

			<?php endif; ?>

		</div><!--/ .footer_section-->

	<?php endif; ?>

<?php endif; ?>