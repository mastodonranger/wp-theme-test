<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-custom-heading-element.php' );
$cta_custom_heading = vc_map_integrate_shortcode( vc_custom_heading_element_params(),
		'custom_',
		esc_html__( 'Heading', 'terminus' ),
		array (
          'exclude' => array (
              'source',
              'text',
              'css',
              'link',
          ),
	    ), array (
		  'element' => 'use_custom_heading',
		  'value'   => 'true',
	    ) );

$params = array_merge( array(
        array(
            'type' => 'textfield',
            'holder' => 'h4',
            'class' => 'vc_toggle_title',
            'heading' => esc_html__( 'Toggle title', 'terminus' ),
            'param_name' => 'title',
            'value' => esc_html__( 'Toggle title', 'terminus' ),
            'description' => esc_html__( 'Enter title of toggle block.', 'terminus' ),
            'edit_field_class' => 'vc_col-sm-9',
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use custom font?', 'terminus' ),
			'param_name' => 'use_custom_heading',
			'description' => esc_html__( 'Enable Google fonts.', 'terminus' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
        array(
            'type' => 'textarea_html',
            'holder' => 'div',
            'class' => 'vc_toggle_content',
            'heading' => esc_html__( 'Toggle content', 'terminus' ),
            'param_name' => 'content',
            'value' => esc_html__( '<p>Toggle content goes here, click edit button to change this text.</p>', 'terminus' ),
            'description' => esc_html__( 'Toggle block content.', 'terminus' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Style', 'terminus' ),
            'param_name' => 'style',
            'value' => array_merge(getVcShared( 'toggle styles' ), array( esc_html__('Terminus Style Outline', 'terminus') => 'terminus_style_1', esc_html__('Terminus Style Theme', 'terminus') => 'terminus_style_2') ),
            'description' => esc_html__( 'Select toggle design style.', 'terminus' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon color', 'terminus' ),
            'param_name' => 'color',
            'value' => array( esc_html__( 'Default', 'terminus' ) => 'default' ) + getVcShared( 'colors' ),
            'description' => esc_html__( 'Select icon color.', 'terminus' ),
            'param_holder_class' => 'vc_colored-dropdown',
			'dependency' => array(
				'element' => 'style',
				'value' => array('default', 'simple', 'round', 'round_outline', 'square', 'square_outline', 'arrow', 'text_only')
			)
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Size', 'terminus' ),
            'param_name' => 'size',
            'value' => array_diff_key( getVcShared( 'sizes' ), array( 'Mini' => '' ) ),
            'std' => 'md',
            'description' => esc_html__( 'Select toggle size', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('default', 'simple', 'round', 'round_outline', 'square', 'square_outline', 'arrow', 'text_only')
			)
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Default state', 'terminus' ),
            'param_name' => 'open',
            'value' => array(
                esc_html__( 'Closed', 'terminus' ) => 'false',
                esc_html__( 'Open', 'terminus' ) => 'true',
            ),
            'description' => esc_html__( 'Select "Open" if you want toggle to be open by default.', 'terminus' ),
        ),
        vc_map_add_css_animation(),
        array(
            'type' => 'el_id',
            'heading' => esc_html__( 'Element ID', 'terminus' ),
            'param_name' => 'el_id',
            'description' => sprintf( __( 'Enter optional ID. Make sure it is unique, and it is valid as w3c specification: %s (Must not have spaces)', 'terminus' ), '<a target="_blank" href="http://www.w3schools.com/tags/att_global_id.asp">' . esc_html__( 'link', 'terminus' ) . '</a>' ),
            'settings' => array(
                'auto_generate' => true,
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'terminus' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'terminus' ),
        ),
    ), $cta_custom_heading, array(
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'terminus' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'terminus' ),
		),
) );
return array(
	'name' => esc_html__( 'FAQ', 'terminus' ),
	'base' => 'vc_toggle',
	'icon' => 'icon-wpb-toggle-small-expand',
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Toggle element for Q&A block', 'terminus' ),
	'params' => $params,
	'js_view' => 'VcToggleView',
);