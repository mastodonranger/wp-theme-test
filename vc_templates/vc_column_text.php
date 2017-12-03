<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css_animation
 * @var $animation_delay
 * @var $scroll_factor
 * @var $css
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_text
 */
$el_class = $css = $css_animation = $dropcap = $dropcap_color = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_classes = $data_attributes = array();
if ( '' !== $css_animation  ) {
	$css_classes[] = 'terminus_animated';
	$data_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
}

$class_to_filter = 'wpb_text_column wpb_content_element ' . implode( ' ', $css_classes );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output = '
	<div class="' . esc_attr( $css_class ) . '" ' . implode( ' ', $data_attributes ) . '>
		<div class="wpb_wrapper">
			' . wpb_js_remove_wpautop( $content, true ) . '
		</div>
	</div>
';

echo $output;
