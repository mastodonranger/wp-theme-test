<?php

class WPBakeryShortCode_VC_mad_highlight extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$text = $bg_color = '';

		$this->atts = shortcode_atts(array(
			'text' => '',
			'bg_color' => ''
		), $atts, 'vc_mad_highlight');

		$wrapper_attributes = array();
		extract($this->atts);

		if ( !empty($bg_color) ) {
			$wrapper_attributes[] = 'style="' . vc_get_css_color( 'background-color', $bg_color ) . '"';
		}

		ob_start(); ?>
			<mark <?php echo implode( ' ', $wrapper_attributes ) ?>><?php echo sprintf( '%s', $text ) ?></mark>
		<?php return ob_get_clean();
	}

}