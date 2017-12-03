<?php

/**
 * New button implementation
 * array_merge is needed due to merging other shortcode data into params.
 * @since 4.5
 */

$pixel_icons = vc_pixel_icons();
require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-icon-element.php' );

$icons_params = vc_map_integrate_shortcode( vc_icon_element_params(), 'i_', '', array(
		'include_only_regex' => '/^(type|icon_\w*)/',
		// we need only type, icon_fontawesome, icon_blabla..., NOT color and etc
	), array(
		'element' => 'add_icon',
		'value' => 'true',
	) );
// populate integrated vc_icons params.
if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
	foreach ( $icons_params as $key => $param ) {
		if ( is_array( $param ) && ! empty( $param ) ) {
			if ( 'i_type' === $param['param_name'] ) {
				// append pixelicons to dropdown
				$icons_params[ $key ]['value'][ esc_html__( 'Pixel', 'terminus' ) ] = 'pixelicons';
			}
			if ( isset( $param['admin_label'] ) ) {
				// remove admin label
				unset( $icons_params[ $key ]['admin_label'] );
			}
		}
	}
}
$params = array_merge( array(
	array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Text', 'terminus' ),
		'param_name' => 'title',
		// fully compatible to btn1 and btn2
		'value' => esc_html__( 'Text on the button', 'terminus' ),
	),
	array(
		'type' => 'vc_link',
		'heading' => esc_html__( 'URL (Link)', 'terminus' ),
		'param_name' => 'link',
		'description' => esc_html__( 'Add link to button.', 'terminus' ),
		// compatible with btn2 and converted from href{btn1}
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Style', 'terminus' ),
		'description' => esc_html__( 'Select button display style.', 'terminus' ),
		'param_name' => 'style',
		// partly compatible with btn2, need to be converted shape+style from btn2 and btn1
		'value' => array(
			esc_html__( 'Modern', 'terminus' ) => 'modern',
			esc_html__( 'Classic', 'terminus' ) => 'classic',
			esc_html__( 'Flat', 'terminus' ) => 'flat',
			esc_html__( 'Outline', 'terminus' ) => 'outline',
			esc_html__( '3d', 'terminus' ) => '3d',
			esc_html__( 'Custom', 'terminus' ) => 'custom',
			esc_html__( 'Outline custom', 'terminus' ) => 'outline-custom',
			esc_html__( 'Gradient', 'terminus' ) => 'gradient',
			esc_html__( 'Gradient Custom', 'terminus' ) => 'gradient-custom'
		),
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Gradient Color 1', 'terminus' ),
		'param_name' => 'gradient_color_1',
		'description' => esc_html__( 'Select first color for gradient.', 'terminus' ),
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => getVcShared( 'colors-dashed' ),
		'std' => 'turquoise',
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'gradient' ),
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Gradient Color 2', 'terminus' ),
		'param_name' => 'gradient_color_2',
		'description' => esc_html__( 'Select second color for gradient.', 'terminus' ),
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => getVcShared( 'colors-dashed' ),
		'std' => 'blue',
		// must have default color grey
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'gradient' ),
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Gradient Color 1', 'terminus' ),
		'param_name' => 'gradient_custom_color_1',
		'description' => esc_html__( 'Select first color for gradient.', 'terminus' ),
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => '#dd3333',
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'gradient-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Gradient Color 2', 'terminus' ),
		'param_name' => 'gradient_custom_color_2',
		'description' => esc_html__( 'Select second color for gradient.', 'terminus' ),
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => '#eeee22',
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'gradient-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Button Text Color', 'terminus' ),
		'param_name' => 'gradient_text_color',
		'description' => esc_html__( 'Select button text color.', 'terminus' ),
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => '#ffffff',
		// must have default color grey
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'gradient-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Background', 'terminus' ),
		'param_name' => 'custom_background',
		'description' => esc_html__( 'Select custom background color for your element.', 'terminus' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'custom' ),
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'std' => '#ededed',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Text', 'terminus' ),
		'param_name' => 'custom_text',
		'description' => esc_html__( 'Select custom text color for your element.', 'terminus' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'custom' ),
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'std' => '#666',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Outline and Text', 'terminus' ),
		'param_name' => 'outline_custom_color',
		'description' => esc_html__( 'Select outline and text color for your element.', 'terminus' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'outline-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
		'std' => '#666',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Hover background', 'terminus' ),
		'param_name' => 'outline_custom_hover_background',
		'description' => esc_html__( 'Select hover background color for your element.', 'terminus' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'outline-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
		'std' => '#666',
	),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Hover text', 'terminus' ),
		'param_name' => 'outline_custom_hover_text',
		'description' => esc_html__( 'Select hover text color for your element.', 'terminus' ),
		'dependency' => array(
			'element' => 'style',
			'value' => array( 'outline-custom' ),
		),
		'edit_field_class' => 'vc_col-sm-4 vc_column',
		'std' => '#fff',
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Shape', 'terminus' ),
		'description' => esc_html__( 'Select button shape.', 'terminus' ),
		'param_name' => 'shape',
		// need to be converted
		'value' => array(
			esc_html__( 'Rounded', 'terminus' ) => 'rounded',
			esc_html__( 'Square', 'terminus' ) => 'square',
			esc_html__( 'Round', 'terminus' ) => 'round',
		),
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Color', 'terminus' ),
		'param_name' => 'color',
		'description' => esc_html__( 'Select button color.', 'terminus' ),
		// compatible with btn2, need to be converted from btn1
		'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
		'value' => array(
				// Btn1 Colors
				esc_html__( 'Classic Grey', 'terminus' ) => 'default',
				esc_html__( 'Classic Blue', 'terminus' ) => 'primary',
				esc_html__( 'Classic Turquoise', 'terminus' ) => 'info',
				esc_html__( 'Classic Green', 'terminus' ) => 'success',
				esc_html__( 'Classic Orange', 'terminus' ) => 'warning',
				esc_html__( 'Classic Red', 'terminus' ) => 'danger',
				esc_html__( 'Classic Black', 'terminus' ) => 'inverse',
				// + Btn2 Colors (default color set)
			) + getVcShared( 'colors-dashed' ),
		'std' => 'grey',
		// must have default color grey
		'dependency' => array(
			'element' => 'style',
			'value_not_equal_to' => array(
				'custom',
				'outline-custom',
				'gradient',
				'gradient-custom',
			),
		),
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Size', 'terminus' ),
		'param_name' => 'size',
		'description' => esc_html__( 'Select button display size.', 'terminus' ),
		// compatible with btn2, default md, but need to be converted from btn1 to btn2
		'std' => 'md',
		'value' => getVcShared( 'sizes' ),
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Alignment', 'terminus' ),
		'param_name' => 'align',
		'description' => esc_html__( 'Select button alignment.', 'terminus' ),
		// compatible with btn2, default left to be compatible with btn1
		'value' => array(
			esc_html__( 'Inline', 'terminus' ) => 'inline',
			esc_html__( 'Left', 'terminus' ) => 'left',
			esc_html__( 'Right', 'terminus' ) => 'right',
			esc_html__( 'Center', 'terminus' ) => 'center',
		),
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Set full width button?', 'terminus' ),
		'param_name' => 'button_block',
		'dependency' => array(
			'element' => 'align',
			'value_not_equal_to' => 'inline',
		),
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Add icon?', 'terminus' ),
		'param_name' => 'add_icon',
	),
	array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon Alignment', 'terminus' ),
		'description' => esc_html__( 'Select icon alignment.', 'terminus' ),
		'param_name' => 'i_align',
		'value' => array(
			esc_html__( 'Left', 'terminus' ) => 'left',
			// default as well
			esc_html__( 'Right', 'terminus' ) => 'right',
		),
		'dependency' => array(
			'element' => 'add_icon',
			'value' => 'true',
		),
	),
), $icons_params, array(
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'i_icon_pixelicons',
			'value' => 'vc_pixel_icon vc_pixel_icon-alert',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'pixelicons',
				'source' => $pixel_icons,
			),
			'dependency' => array(
				'element' => 'i_type',
				'value' => 'pixelicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
	), array(
		terminus_vc_map_add_css_animation(),
		terminus_vc_map_add_animation_delay(),
		terminus_vc_map_add_scroll_factor(),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'terminus' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'terminus' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'terminus' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'terminus' ),
		),
	) );
/**
 * @class WPBakeryShortCode_VC_Btn
 */
return array(
	'name' => __( 'Button', 'terminus' ),
	'base' => 'vc_btn',
	'icon' => 'icon-wpb-ui-button',
	'category' => array(
		__( 'Content', 'terminus' ),
	),
	'description' => __( 'Eye catching button', 'terminus' ),
	'params' => $params,
	'js_view' => 'VcButton3View',
	'custom_markup' => '{{title}}<div class="vc_btn3-container"><button class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-{{ params.shape }} vc_btn3-style-{{ params.style }} vc_btn3-color-{{ params.color }}">{{{ params.title }}}</button></div>',
);
