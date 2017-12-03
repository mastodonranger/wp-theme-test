<?php

class WPBakeryShortCode_VC_mad_dropcap extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'type' => 'dropcap_type_default',
			'letter' => '',
			'dropcap_color' => ''
		), $atts, 'vc_mad_dropcap');

		$this->content = $content;
		$html = $this->html();

		return $html;
	}

	public function html() {

		$type = $style = $letter = $output = $class = $dropcap = $dropcap_color = "";

		extract($this->atts);

		if ( '' !== $letter ) {

			if ( !empty( $dropcap_color ) ) {

				switch($type) {
					case 'dropcap_type_default':
					case 'dropcap_type_secondary':
						$color = vc_get_css_color( 'color', $dropcap_color );
					break;
					case 'dropcap_type_circle':
					case 'dropcap_type_square':
						$color = vc_get_css_color( 'background-color', $dropcap_color );
					break;
				}

				$style = 'style="' . $color . '"';
			}

			$dropcap .= '<span '. $style .' class="dropcap-letter">'. esc_html($letter) .'</span>';

		}

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_dropcap wpb_content_element ' . $type, $this->settings['base'], $this->atts );

		$output .= "<div class='{$css_class}'>";
			$output .= $dropcap;
			$output .= wpb_js_remove_wpautop($this->content, true);
		$output .= '</div>';

		return $output;
	}

}