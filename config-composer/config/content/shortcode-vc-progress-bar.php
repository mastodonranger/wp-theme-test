<?php
return array(
	'name' => esc_html__( 'Progress Bar', 'terminus' ),
	'base' => 'vc_progress_bar',
	'icon' => 'icon-wpb-graph',
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Animated progress bar', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'terminus' ),
			'param_name' => 'title',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'terminus' ),
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
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'terminus' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Light Horizontal', 'terminus') => 'light_horizontal',
				esc_html__('Large Horizontal', 'terminus') => 'large_horizontal',
				esc_html__('Light Vertical', 'terminus') => 'light_vertical',
				esc_html__('Large Vertical', 'terminus') => 'large_vertical'
			),
			'std' => '',
			'description' => esc_html__( 'Select progress bar display style.', 'terminus' )
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'terminus' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'terminus' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Development', 'terminus' ),
					'value' => '90',
				),
				array(
					'label' => esc_html__( 'Design', 'terminus' ),
					'value' => '80',
				),
				array(
					'label' => esc_html__( 'Marketing', 'terminus' ),
					'value' => '70',
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'terminus' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title of bar.', 'terminus' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'terminus' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value of bar.', 'terminus' ),
					'admin_label' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color', 'terminus' ),
					'param_name' => 'color',
					'value' => array(
							esc_html__( 'Default', 'terminus' ) => '',
						) + array(
							esc_html__( 'Classic Grey', 'terminus' ) => 'bar_grey',
							esc_html__( 'Classic Blue', 'terminus' ) => 'bar_blue',
							esc_html__( 'Classic Turquoise', 'terminus' ) => 'bar_turquoise',
							esc_html__( 'Classic Green', 'terminus' ) => 'bar_green',
							esc_html__( 'Classic Orange', 'terminus' ) => 'bar_orange',
							esc_html__( 'Classic Red', 'terminus' ) => 'bar_red',
							esc_html__( 'Classic Black', 'terminus' ) => 'bar_black',
						) + getVcShared( 'colors-dashed' ) + array(
							esc_html__( 'Custom Color', 'terminus' ) => 'custom',
						),
					'description' => esc_html__( 'Select single bar background color.', 'terminus' ),
					'admin_label' => true,
					'param_holder_class' => 'vc_colored-dropdown',
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'terminus' ),
					'param_name' => 'customcolor',
					'description' => esc_html__( 'Select custom single bar background color.', 'terminus' ),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom text color', 'terminus' ),
					'param_name' => 'customtxtcolor',
					'description' => esc_html__( 'Select custom single bar text color.', 'terminus' ),
					'dependency' => array(
						'element' => 'color',
						'value' => array( 'custom' ),
					),
				),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Units', 'terminus' ),
			'param_name' => 'units',
			'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Color', 'terminus' ),
			'param_name' => 'bgcolor',
			'value' => array(
					esc_html__( 'Classic Grey', 'terminus' ) => 'bar_grey',
					esc_html__( 'Classic Blue', 'terminus' ) => 'bar_blue',
					esc_html__( 'Classic Turquoise', 'terminus' ) => 'bar_turquoise',
					esc_html__( 'Classic Green', 'terminus' ) => 'bar_green',
					esc_html__( 'Classic Orange', 'terminus' ) => 'bar_orange',
					esc_html__( 'Classic Red', 'terminus' ) => 'bar_red',
					esc_html__( 'Classic Black', 'terminus' ) => 'bar_black',
				) + getVcShared( 'colors-dashed' ) + array(
					esc_html__( 'Custom Color', 'terminus' ) => 'custom',
				),
			'description' => esc_html__( 'Select bar background color.', 'terminus' ),
			'admin_label' => true,
			'param_holder_class' => 'vc_colored-dropdown',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Bar custom background color', 'terminus' ),
			'param_name' => 'custombgcolor',
			'description' => esc_html__( 'Select custom background color for bars.', 'terminus' ),
			'dependency' => array(
				'element' => 'bgcolor',
				'value' => array( 'custom' ),
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Bar custom text color', 'terminus' ),
			'param_name' => 'customtxtcolor',
			'description' => esc_html__( 'Select custom text color for bars.', 'terminus' ),
			'dependency' => array(
				'element' => 'bgcolor',
				'value' => array( 'custom' ),
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Options', 'terminus' ),
			'param_name' => 'options',
			'value' => array(
				esc_html__( 'Add stripes', 'terminus' ) => 'striped',
				esc_html__( 'Add animation (Note: visible only with striped bar).', 'terminus' ) => 'animated',
			),
		),
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
			'group' => esc_html__( 'Design Options', 'terminus' )
		)
	)
);