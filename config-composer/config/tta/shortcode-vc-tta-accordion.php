<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => esc_html__( 'Accordion', 'terminus' ),
	'base' => 'vc_tta_accordion',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'vc_tta_section',
	),
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Collapsible content panels', 'terminus' ),
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
			'std' => 'h3',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'terminus' )
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
			'description' => esc_html__( 'Select accordion display style.', 'terminus' ),
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
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion shape.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'color',
			'value' => getVcShared( 'colors-dashed' ),
			'std' => 'grey',
			'heading' => esc_html__( 'Color', 'terminus' ),
			'description' => esc_html__( 'Select accordion color.', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'param_holder_class' => 'vc_colored-dropdown',
		),
		array(
			'type' => 'checkbox',
			'param_name' => 'no_fill',
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
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion spacing.', 'terminus' ),
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
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion gap.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'c_align',
			'value' => array(
				esc_html__( 'Left', 'terminus' ) => 'left',
				esc_html__( 'Right', 'terminus' ) => 'right',
				esc_html__( 'Center', 'terminus' ) => 'center',
			),
			'heading' => esc_html__( 'Alignment', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion section title alignment.', 'terminus' ),
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
			'description' => esc_html__( 'Select auto rotate for accordion in seconds (Note: disabled by default).', 'terminus' ),
		),
		array(
			'type' => 'checkbox',
			'param_name' => 'collapsible_all',
			'heading' => esc_html__( 'Allow collapse all?', 'terminus' ),
			'description' => esc_html__( 'Allow collapse all accordion sections.', 'terminus' ),
		),
		// Control Icons
		array(
			'type' => 'dropdown',
			'param_name' => 'c_icon',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				esc_html__( 'Chevron', 'terminus' ) => 'chevron',
				esc_html__( 'Plus', 'terminus' ) => 'plus',
				esc_html__( 'Triangle', 'terminus' ) => 'triangle',
			),
			'std' => 'plus',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion navigation icon.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'param_name' => 'c_position',
			'value' => array(
				esc_html__( 'Left', 'terminus' ) => 'left',
				esc_html__( 'Right', 'terminus' ) => 'right',
			),
			'dependency' => array(
				'element' => 'c_icon',
				'not_empty' => true,
			),
			'heading' => esc_html__( 'Position', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('classic', 'modern', 'flat', 'outline'),
			),
			'description' => esc_html__( 'Select accordion navigation icon position.', 'terminus' ),
		),
		// Control Icons END
		array(
			'type' => 'textfield',
			'param_name' => 'active_section',
			'heading' => esc_html__( 'Active section', 'terminus' ),
			'value' => 1,
			'description' => esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'terminus' ),
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
	'js_view' => 'VcBackendTtaAccordionView',
	'custom_markup' => '
<div class="vc_tta-container" data-vc-action="collapseAll">
	<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
	   <div class="vc_tta-panels vc_clearfix {{container-class}}">
	      {{ content }}
	      <div class="vc_tta-panel vc_tta-section-append">
	         <div class="vc_tta-panel-heading">
	            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
	               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
	                   <span class="vc_tta-title-text">' . esc_html__( 'Add Section', 'terminus' ) . '</span>
	                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
					</a>
	            </h4>
	         </div>
	      </div>
	   </div>
	</div>
</div>',
	'default_content' => '[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'terminus' ), 1 ) . '"][/vc_tta_section][vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'terminus' ), 2 ) . '"][/vc_tta_section]',
);
