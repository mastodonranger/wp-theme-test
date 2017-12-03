<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $tag_title = $description = $title_color = $el_class = '';

extract( shortcode_atts( array(
	'title' => '',
	'tag_title' => 'h2',
	'title_color' => '',
	'description' => '',
	'el_class' => ''
), $atts ) );

global $tabarr;
$tabarr = array();

do_shortcode( $content );

ob_start(); ?>

	<div class="wpb_content_element">

		<?php
		echo Terminus_Vc_Config::getParamTitle(
			$title,
			$tag_title,
			$description,
			array(
				'title_color' => $title_color
			)
		);
		?>

		<div class="t_tabs <?php echo sanitize_html_class($el_class) ?>">

			<div class="tabs_nav services_nav">

				<?php if ( isset($tabarr) && !empty($tabarr) ): ?>

					<?php foreach( $tabarr as $key => $value ): ?>

						<a class="t-tab-link" href="#tab-<?php echo esc_attr($value['tab_id']) ?>">

							<?php if ( $value['icon_type'] == 'selector' ): ?>

								<?php if ($value['icon']): ?>

									<span class="si-icon"><i class="<?php echo esc_attr($value['icon']) ?> vc_mad_tab_icon"></i></span>

								<?php endif; ?>

							<?php elseif ( $value['icon_type'] == 'custom' ): ?>

								<?php if ( absint($value['icon_img']) ): ?>

									<span class="si-icon icon-with-image"><?php echo TERMINUS_HELPER::get_the_thumbnail($value['icon_img'], '', true, '', array('alt' => ' ')) ?></span>

								<?php endif; ?>

							<?php endif; ?>

							<?php if ($value['title']): ?>
								<span class="tab_text"><?php echo esc_html($value['title']) ?></span>
							<?php endif; ?>

						</a>

					<?php endforeach; ?>

				<?php endif; ?>

			</div>

			<div class="tab_containers_wrap">
				<?php echo wpb_js_remove_wpautop( $content ) ?>
			</div>

		</div><!--/ .t_tabs-->

	</div>

<?php echo ob_get_clean();
