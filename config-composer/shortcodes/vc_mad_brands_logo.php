<?php

class WPBakeryShortCode_VC_mad_brands_logo extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => "",
			'tag_title' => 'h2',
			'title_color' => '',
			'description'   => '',
			'images' => "",
			'links' => "",
			'carousel' => '',
			'autoplay' => '',
			'autoplaytimeout' => 5000,
			'css_animation' => ""
		), $atts, 'vc_mad_brands_logo');

		return $this->html();
	}

	public function html() {

		$wrapper_attributes = array();
		$css_classes = array('clients-holder');
		$title = $tag_title = $title_color = $description = $images = $links = $carousel = $autoplay = $autoplaytimeout = $css_animation = '';

		extract($this->atts);

		$data_attributes = $item_classes = array();
		if ( '' !== $css_animation ) {
			$item_classes[] = 'terminus_animated';
			$data_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, 0, '' );
		}

		$links = !empty($links) ? explode('|', $links) : '';
		$images = explode( ',', $images);

		if ( $carousel ) {
			$css_classes[] = 'clients_carousel';
			$css_classes[] = 'clients_fw';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<?php echo Terminus_Vc_Config::getParamTitle(
			$title,
			$tag_title,
			$description,
			array(
				'title_color' => $title_color
			)
		); ?>

		<ul <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<!-- - - - - - - - - - - - - - Item- - - - - - - - - - - - - - - - -->

			<?php $delay = 0; $i = 0; $img = array(); ?>

			<?php foreach ($images as $id => $attach_id): ?>

				<?php if ($attach_id > 0): ?>

					<?php $img = wpb_getImageBySize( array( 'attach_id' => (int) $attach_id, 'thumb_size' => 'large' ) ); ?>

				<?php else: ?>

					<?php $img['thumbnail'] = '<img alt="" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; ?>

				<?php endif; ?>

				<?php $link = (isset($links[$i]) && !empty($links[$i])) ? trim($links[$i]) : ''; ?>

				<li class="<?php echo implode( ' ', $item_classes ) ?>" <?php echo implode( ' ', $data_attributes ) ?> data-animation-delay="<?php echo esc_attr($delay) ?>" data-scroll-factor="-120">
					<?php if (isset($link) && !empty($link)): ?>
						<a href="<?php echo esc_url($link) ?>" class="client">
					<?php endif; ?>

						<?php echo sprintf('%s', $img['thumbnail']); ?>

					<?php if (isset($link) && !empty($link)): ?>
						</a>
					<?php endif; ?>
				</li>

				<?php $delay += 100; $i++; ?>

			<?php endforeach; ?>

			<!-- - - - - - - - - - - - - - End of Item - - - - - - - - - - - - - - - - -->

		</ul><!--/ .owl_carousel-->

		<?php return ob_get_clean();
	}

}