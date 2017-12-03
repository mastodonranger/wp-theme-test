<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => esc_html__( 'Tabs', 'terminus' ),
	'base' => 'vc_tta_tabs',
	'icon' => 'icon-wpb-ui-tab-content',
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'vc_tta_section',
	),
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Tabbed content', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'param_name' => 'title',
			'heading' => esc_html__( 'Widget title', 'terminus' ),
			'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'terminus' ),
			'edit_field_class' => 'vc_col-sm-6'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'terminus' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'terminus' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'terminus' ),
			'param_name' => 'title_color',
			'description' => esc_html__( 'Select custom color for title.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Classic', 'terminus' ) => 'classic',
				esc_html__( 'Modern', 'terminus' ) => 'modern',
				esc_html__( 'Flat', 'terminus' ) => 'flat',
				esc_html__( 'Outline', 'terminus' ) => 'outline',
				esc_html__( 'Theme', 'terminus' ) => 'theme'
			),
			'heading' => esc_html__( 'Style', 'terminus' ),
			'description' => esc_html__( 'Select tabs display style.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'shape',
			'value' => array(
				esc_html__( 'Rounded', 'terminus' ) => 'rounded',
				esc_html__( 'Square', 'terminus' ) => 'square',
				esc_html__( 'Round', 'terminus' ) => 'round',
			),
			'heading' => esc_html__( 'Shape', 'terminus' ),
			'description' => esc_html__( 'Select tabs shape.', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'color',
			'heading' => esc_html__( 'Color', 'terminus' ),
			'description' => esc_html__( 'Select tabs color.', 'terminus' ),
			'value' => getVcShared( 'colors-dashed' ),
			'std' => 'grey',
			'param_holder_class' => 'vc_colored-dropdown',
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
		),
		array(
			'type' => 'checkbox',
			'param_name' => 'no_fill_content_area',
			'heading' => esc_html__( 'Do not fill content area?', 'terminus' ),
			'description' => esc_html__( 'Do not fill content area with color.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'spacing',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				'1px' => '1',
				'2px' => '2',
				'3px' => '3',
				'4px' => '4',
				'5px' => '5',
				'10px' => '10',
				'15px' => '15',
				'20px' => '20',
				'25px' => '25',
				'30px' => '30',
				'35px' => '35',
			),
			'heading' => esc_html__( 'Spacing', 'terminus' ),
			'description' => esc_html__( 'Select tabs spacing.', 'terminus' ),
			'std' => '1',
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'gap',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				'1px' => '1',
				'2px' => '2',
				'3px' => '3',
				'4px' => '4',
				'5px' => '5',
				'10px' => '10',
				'15px' => '15',
				'20px' => '20',
				'25px' => '25',
				'30px' => '30',
				'35px' => '35',
			),
			'heading' => esc_html__( 'Gap', 'terminus' ),
			'description' => esc_html__( 'Select tabs gap.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'tab_position',
			'value' => array(
				esc_html__( 'Top', 'terminus' ) => 'top',
				esc_html__( 'Bottom', 'terminus' ) => 'bottom',
			),
			'heading' => esc_html__( 'Position', 'terminus' ),
			'description' => esc_html__( 'Select tabs navigation position.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'alignment',
			'value' => array(
				esc_html__( 'Left', 'terminus' ) => 'left',
				esc_html__( 'Right', 'terminus' ) => 'right',
				esc_html__( 'Center', 'terminus' ) => 'center',
			),
			'heading' => esc_html__( 'Alignment', 'terminus' ),
			'description' => esc_html__( 'Select tabs section title alignment.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'autoplay',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => 'none',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'10' => '10',
				'20' => '20',
				'30' => '30',
				'40' => '40',
				'50' => '50',
				'60' => '60',
			),
			'std' => 'none',
			'heading' => esc_html__( 'Autoplay', 'terminus' ),
			'description' => esc_html__( 'Select auto rotate for tabs in seconds (Note: disabled by default).', 'terminus' ),
		),
		array(
			'type' => 'textfield',
			'param_name' => 'active_section',
			'heading' => esc_html__( 'Active section', 'terminus' ),
			'value' => 1,
			'description' => esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'pagination_style',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				esc_html__( 'Square Dots', 'terminus' ) => 'outline-square',
				esc_html__( 'Radio Dots', 'terminus' ) => 'outline-round',
				esc_html__( 'Point Dots', 'terminus' ) => 'flat-round',
				esc_html__( 'Fill Square Dots', 'terminus' ) => 'flat-square',
				esc_html__( 'Rounded Fill Square Dots', 'terminus' ) => 'flat-rounded',
			),
			'heading' => esc_html__( 'Pagination style', 'terminus' ),
			'description' => esc_html__( 'Select pagination style.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'pagination_color',
			'value' => getVcShared( 'colors-dashed' ),
			'heading' => esc_html__( 'Pagination color', 'terminus' ),
			'description' => esc_html__( 'Select pagination color.', 'terminus' ),
			'param_holder_class' => 'vc_colored-dropdown',
			'std' => 'grey',
			'dependency' => array(
				'element' => 'pagination_style',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'terminus' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'terminus' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'terminus' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'terminus' ),
		),
	),
	'js_view' => 'VcBackendTtaTabsView',
	'custom_markup' => '
<div class="vc_tta-container" data-vc-action="collapse">
	<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
		<div class="vc_tta-tabs-container">'
		. '<ul class="vc_tta-tabs-list">'
		. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
		. '</ul>
		</div>
		<div class="vc_tta-panels vc_clearfix {{container-class}}">
		  {{ content }}
		</div>
	</div>
</div>',
	'default_content' => '
[vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'terminus' ), 1 ) . '"][/vc_tta_section]
[vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'terminus' ), 2 ) . '"][/vc_tta_section]
	',
	'admin_enqueue_js' => array(
		vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
	),
);
