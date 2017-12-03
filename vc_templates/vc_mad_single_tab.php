<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$wrapper_attributes = array();
$title = $tab_id = $icon_type = $icon = $icon_img = '';

extract( shortcode_atts( array(
	'title' => '',
	'tab_id' => '',
	'icon_type'  => 'selector',
	'icon'  => '',
	'icon_img'  => ''
), $atts ) );

global $tabarr;

$tabarr[] = array (
	'title' => $title,
	'tab_id' => $tab_id,
	'icon_type' => $icon_type,
	'icon' => $icon,
	'icon_img' => $icon_img,
	'content' => $content
);

$wrapper_attributes[] = 'id="tab-' . esc_attr( trim($tab_id) ) . '"';
$wrapper_attributes[] = 'class="tab_container"';

ob_start(); ?>

<section <?php echo implode( ' ', $wrapper_attributes ) ?>>
	<?php echo wpb_js_remove_wpautop( $content, true ) ?>
</section>

<?php echo ob_get_clean();
