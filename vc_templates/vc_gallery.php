<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $type
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $external_img_size
 * @var $images
 * @var $custom_srcs
 * @var $el_class
 * @var $interval
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_gallery
 */
$thumbnail = '';
$title = $tag_title = $source = $type = $onclick = $custom_links = $custom_links_target = $img_size = $external_img_size = $images = $custom_srcs = $carousel = $el_class = $interval = $css = '';
$large_img_src = '';

$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $attributes );

$default_src = vc_asset_url( 'vc/no_image.png' );

$gal_images = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$css_classes = array(
	'grid-gallery'
);

if ( $carousel ) {
	$css_classes[] = 'fw_projects_carousel';
} else {
	$css_classes[] = 'grid-columns-' . absint($columns);
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$el_class = $this->getExtraClass( $el_class );
$slides_wrap_start = '<div ' . implode( ' ', $wrapper_attributes ) . ' >';
$slides_wrap_end = '</div>';
$el_start = '<div class="grid-item"><div class="overlay_box">';
$el_end = '</div></div>';

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

$pretty_rel_random = ' data-rel="gallery_[rel-' . get_the_ID() . '-' . rand() . ']"';

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

switch ( $source ) {
	case 'media_library':
		$images = explode( ',', $images );
		break;

	case 'external_link':
		$images = vc_value_from_safe( $custom_srcs );
		$images = explode( ',', $images );

		break;
}
foreach ( $images as $i => $image ) {
	switch ( $source ) {
		case 'media_library':
			if ( $image > 0 ) {
				$img = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size, 'class' => 'ov_img' ) );
				$thumbnail = $img['thumbnail'];
				$large_img_src = $img['p_img_large'][0];
			} else {
				$large_img_src = $default_src;
				$thumbnail = '<img src="' . $default_src . '" />';
			}
			break;

		case 'external_link':
			$image = esc_attr( $image );
			$dimensions = vcExtractDimensions( $external_img_size );
			$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
			$thumbnail = '<img ' . $hwstring . ' src="' . $image . '" />';
			$large_img_src = $image;
			break;
	}

	$link_start = '<div class="ov_blackout">';
	$link_end = '';

	switch ( $onclick ) {
		case 'img_link_large':
			$link_start .= "<ul class='ov_actions'><li><a href='{$large_img_src}' target='{$custom_links_target}'>";
			$link_end .= "<span class='si-icon si-icon-plus'></span></a></li></ul>";
			break;

		case 'link_image':
			$link_start .= "<ul class='ov_actions'><li><a class='fancybox' href='{$large_img_src}' {$pretty_rel_random}>";
			$link_end .= "<span class='si-icon si-icon-plus'></span></a></li></ul>";
			break;

		case 'custom_link':
			if ( ! empty( $custom_links[ $i ] ) ) {
				$link_start .= "<ul class='ov_actions'><li><a href='{$custom_links[ $i ]}' ". ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) .">";
				$link_end .= "<span class='si-icon si-icon-plus'></span></a></li></ul>";
			}
			break;
	}

	$link_end .= '</div>';

	$gal_images .= $el_start . $thumbnail . $link_start  . $link_end . $el_end;
}

$class_to_filter = 'wpb_gallery wpb_content_element vc_clearfix';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output = '';
$output .= '<div class="' . $css_class . '">';
	$output .= '<div class="wpb_wrapper">';
		$output .= Terminus_Vc_Config::getParamTitle($title, $tag_title);
		$output .= $slides_wrap_start . $gal_images . $slides_wrap_end;
$output .= '</div>';
$output .= '</div>';

echo $output;
