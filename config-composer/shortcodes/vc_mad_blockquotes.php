<?php

class WPBakeryShortCode_VC_mad_blockquotes extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$style = '';

		$this->atts = shortcode_atts(array(
			'style' => 'type_1'
		), $atts, 'vc_mad_blockquotes');

		$wrapper_attributes = array();
		extract($this->atts);

		$css_classes = array( 'blockquote', $style );

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<blockquote <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<?php if ( !empty($content) ): ?>
				<p><?php echo wpb_js_remove_wpautop( $content, false ) ?></p>
			<?php endif; ?>
		</blockquote>

		<?php return ob_get_clean();
	}

}