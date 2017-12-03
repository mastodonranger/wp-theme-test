<?php

class WPBakeryShortCode_VC_mad_banners extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'images' => "",
			'links' => "",
			'css_animation' => ''
		), $atts, 'vc_mad_banners');

		return $this->html();
	}

	public function html() {

		$images = $links = '';
		extract($this->atts);

		$links = !empty($links) ? explode('|', $links) : '';
		$images = explode( ',', $images);
		$css_animation = !empty($this->atts['css_animation']) ? $this->atts['css_animation'] : '';
		$data_attributes = array();

		ob_start(); ?>

		<div class="wpb_content_element">

			<div class="banners_row">

				<?php $i = 0; $img = array(); $delay = 0; ?>

				<?php foreach ($images as $id => $attach_id): ?>

					<?php
					$classes = array('banner');

					if ( '' !== $css_animation ) {
						$classes[] = 'terminus_animated';
						$data_attributes[''] = TERMINUS_HELPER::create_data_string_animation( $css_animation, $delay, '' );
					}
					?>

					<?php if ($attach_id > 0): ?>

						<?php $img = wpb_getImageBySize( array( 'attach_id' => (int) $attach_id, 'thumb_size' => 'large' ) ); ?>

					<?php else: ?>

						<?php $img['thumbnail'] = '<img alt="" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; ?>

					<?php endif; ?>

					<?php $link = (isset($links[$i]) && !empty($links[$i])) ? trim($links[$i]) : ''; ?>

					<?php if ( isset($link) && !empty($link) ): ?>
						<a href="<?php echo esc_url($link) ?>" class="<?php echo implode( ' ', $classes ) ?>" <?php echo implode( ' ', $data_attributes ) ?>>
					<?php endif; ?>

					<?php echo sprintf('%s', $img['thumbnail']); ?>

					<?php if ( isset($link) && !empty($link) ): ?>
						</a>
					<?php endif; ?>

					<?php $i++; $delay = $delay + 100; ?>

				<?php endforeach; ?>

			</div><!--/ .banners_row-->

		</div>

		<?php return ob_get_clean();
	}

}