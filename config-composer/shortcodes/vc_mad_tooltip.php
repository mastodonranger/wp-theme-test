<?php

class WPBakeryShortCode_VC_mad_tooltip extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$text = $link = $target_link = $tooltip_text = $tooltip_position = '';

		$this->atts = shortcode_atts(array(
			'text' => '',
			'link' => '',
			'target_link' => '_self',
			'tooltip_text' => '',
			'tooltip_position' => 'top'
		), $atts, 'vc_mad_tooltip');

		$wrapper_attributes = array();
		extract($this->atts);

		$css_classes = array( 'tooltip_container' );
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		$wrapper_attributes[] = 'href="' . esc_url($link) . '"';
		$wrapper_attributes[] = 'target="' . esc_attr($target_link) . '"';

		ob_start(); ?>

			<a <?php echo implode( ' ', $wrapper_attributes ) ?>>
				<?php echo sprintf( '%s', $text ) ?>
				<?php if ( $tooltip_text ): ?>
					<span class="tooltip <?php echo esc_attr($tooltip_position) ?>"><?php echo sprintf( '%s', $tooltip_text ) ?></span>
				<?php endif; ?>
			</a>

		<?php return ob_get_clean();
	}

}