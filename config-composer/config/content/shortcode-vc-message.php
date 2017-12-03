<?php
/* Message box 2
---------------------------------------------------------- */
$custom_colors = array(
	esc_html__( 'Informational', 'terminus' ) => 'info',
	esc_html__( 'Warning', 'terminus' ) => 'warning',
	esc_html__( 'Success', 'terminus' ) => 'success',
	esc_html__( 'Error', 'terminus' ) => 'danger'
);

return array(
	'name' => esc_html__( 'Message Box', 'terminus' ),
	'base' => 'vc_message',
	'icon' => 'icon-wpb-information-white',
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Notification box', 'terminus' ),
	'params' => array(
		array(
			'type' => 'params_preset',
			'heading' => esc_html__( 'Message Box Presets', 'terminus' ),
			'param_name' => 'color',
			// due to backward compatibility, really it is message_box_type
			'value' => '',
			'options' => array(
				array(
					'label' => esc_html__( 'Custom', 'terminus' ),
					'value' => '',
					'params' => array(),
				),
				array(
					'label' => esc_html__( 'Informational', 'terminus' ),
					'value' => 'info',
					'params' => array(
						'message_box_color' => 'info',
						'icon_type' => 'fontawesome',
						'icon_fontawesome' => 'fa fa-info-circle',
					),
				),
				array(
					'label' => esc_html__( 'Warning', 'terminus' ),
					'value' => 'warning',
					'params' => array(
						'message_box_color' => 'warning',
						'icon_type' => 'fontawesome',
						'icon_fontawesome' => 'fa fa-exclamation-triangle',
					),
				),
				array(
					'label' => esc_html__( 'Success', 'terminus' ),
					'value' => 'success',
					'params' => array(
						'message_box_color' => 'success',
						'icon_type' => 'fontawesome',
						'icon_fontawesome' => 'fa fa-check',
					),
				),
				array(
					'label' => esc_html__( 'Error', 'terminus' ),
					'value' => 'danger',
					'params' => array(
						'message_box_color' => 'danger',
						'icon_type' => 'fontawesome',
						'icon_fontawesome' => 'fa fa-times',
					),
				)
			),
			'description' => esc_html__( 'Select predefined message box design or choose "Custom" for custom styling.', 'terminus' ),
			'param_holder_class' => 'vc_message-type vc_colored-dropdown',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'terminus' ),
			'param_name' => 'message_box_style',
			'value' => getVcShared( 'message_box_styles' ),
			'description' => esc_html__( 'Select message box design style.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Shape', 'terminus' ),
			'param_name' => 'style',
			// due to backward compatibility message_box_shape
			'std' => 'rounded',
			'value' => array(
				esc_html__( 'Square', 'terminus' ) => 'square',
				esc_html__( 'Rounded', 'terminus' ) => 'rounded',
				esc_html__( 'Round', 'terminus' ) => 'round',
			),
			'description' => esc_html__( 'Select message box shape.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Color', 'terminus' ),
			'param_name' => 'message_box_color',
			'value' => $custom_colors + getVcShared( 'colors' ),
			'description' => esc_html__( 'Select message box color.', 'terminus' ),
			'param_holder_class' => 'vc_message-type vc_colored-dropdown',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Icon library', 'terminus' ),
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				esc_html__( 'Font Awesome', 'terminus' ) => 'fontawesome',
				esc_html__( 'Open Iconic', 'terminus' ) => 'openiconic',
				esc_html__( 'Typicons', 'terminus' ) => 'typicons',
				esc_html__( 'Entypo', 'terminus' ) => 'entypo',
				esc_html__( 'Linecons', 'terminus' ) => 'linecons',
				esc_html__( 'Mono Social', 'terminus' ) => 'monosocial',
			),
			'param_name' => 'icon_type',
			'description' => esc_html__( 'Select icon library.', 'terminus' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-info-circle',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_openiconic',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_typicons',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_entypo',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'entypo',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_linecons',
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'terminus' ),
			'param_name' => 'icon_monosocial',
			'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'monosocial',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'monosocial',
			),
			'description' => esc_html__( 'Select icon from library.', 'terminus' ),
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'class' => 'messagebox_text',
			'heading' => esc_html__( 'Message text', 'terminus' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am message box. Click edit button to change this text.', 'terminus' ),
		),
		vc_map_add_css_animation( false ),
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
	),
	'js_view' => 'VcMessageView_Backend',
);