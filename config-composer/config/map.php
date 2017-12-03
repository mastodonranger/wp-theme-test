<?php

//global $terminus_config;

$target_arr = array(
	esc_html__( 'Same window', 'terminus' ) => '_self',
	esc_html__( 'New window', 'terminus' ) => '_blank',
);

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Background position",
	"param_name" => "background_position",
	"value" => array(
		'' => esc_html__('None', 'terminus'),
		"center center" => "center center",
		"center top" => "center top",
		"center bottom" => "center bottom",
		'right bottom' => 'right bottom',
		'right top' => 'right top',
		'left bottom' => 'left bottom',
		'left top' => 'left top'
	),
	'group' => esc_html__( 'Design Options', 'terminus' ),
));

function terminus_vc_map_add_css_animation( $label = true ) {
	$data = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'terminus' ),
		'param_name' => 'css_animation',
		'admin_label' => $label,
		'value' => array(
			esc_html__( 'No', 'terminus' ) => '',
			esc_html__( 'Fade In Up', 'terminus' ) => 'fadeInUp',
			esc_html__( 'Zoom In Down', 'terminus' ) => 'zoomInDown',
			esc_html__( 'Flip In Y', 'terminus' ) => 'flipInY',
		),
		'group' => esc_html__( 'Animations', 'terminus' ),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'terminus' )
	);

	return apply_filters( 'terminus_vc_map_add_css_animation', $data, $label );
}

function terminus_vc_map_add_animation_delay( $label = true ) {
	$data = array(
		'type' => 'number',
		'heading' => esc_html__( 'Animation delay', 'terminus' ),
		'param_name' => 'animation_delay',
		'admin_label' => $label,
		'description' => esc_html__( 'Animation delay', 'terminus' ),
		'value' => 0,
		'dependency' => array(
			'element' => 'css_animation',
			'not_empty' => true
		),
		'group' => esc_html__( 'Animations', 'terminus' )
	);

	return apply_filters( 'terminus_vc_map_add_animation_delay', $data, $label );
}

function terminus_vc_map_add_scroll_factor( $label = true ) {
	$data = array(
		'type' => 'number',
		'heading' => esc_html__( 'Scroll factor', 'terminus' ),
		'param_name' => 'scroll_factor',
		'admin_label' => $label,
		'description' => esc_html__( 'Scroll factor', 'terminus' ),
		'value' => '-240',
		'dependency' => array(
			'element' => 'css_animation',
			'not_empty' => true
		),
		'group' => esc_html__( 'Animations', 'terminus' )
	);

	return apply_filters( 'terminus_vc_map_add_scroll_factor', $data, $label );
}

function terminus_vc_map_add_short_css_animation( $label = true ) {
	$data = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'terminus' ),
		'param_name' => 'css_animation',
		'admin_label' => $label,
		'value' => array(
			esc_html__( 'No', 'terminus' ) => '',
			esc_html__( 'Yes', 'terminus' ) => 'yes'
		),
		'group' => esc_html__( 'Animations', 'terminus' ),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'terminus' )
	);

	return apply_filters( 'terminus_vc_map_add_short_css_animation', $data, $label );
}

/* Default Custom Shortcodes
/* --------------------------------------------------------------------- */

/* Row
----------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Row' , 'terminus' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Place content elements inside the row', 'terminus' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Row stretch', 'terminus' ),
			'param_name' => 'full_width',
			'value' => array(
				esc_html__( 'Default', 'terminus' ) => '',
				esc_html__( 'Stretch row', 'terminus' ) => 'stretch_row',
				esc_html__( 'Stretch row and content', 'terminus' ) => 'stretch_row_content',
				esc_html__( 'Stretch row and content (no paddings)', 'terminus' ) => 'stretch_row_content_no_spaces',
			),
			'description' => esc_html__( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns gap', 'terminus' ),
			'param_name' => 'gap',
			'value' => array(
				'0px' => '0',
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
			'std' => '0',
			'description' => esc_html__( 'Select gap between columns in row.', 'terminus' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Full height row?', 'terminus' ),
			'param_name' => 'full_height',
			'description' => esc_html__( 'If checked row will be set to full height.', 'terminus' ),
			'value' => array( esc_html__( 'Yes', 'terminus' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns position', 'terminus' ),
			'param_name' => 'columns_placement',
			'value' => array(
				esc_html__( 'Middle', 'terminus' ) => 'middle',
				esc_html__( 'Top', 'terminus' ) => 'top',
				esc_html__( 'Bottom', 'terminus' ) => 'bottom',
				esc_html__( 'Stretch', 'terminus' ) => 'stretch',
			),
			'description' => esc_html__( 'Select columns position within row.', 'terminus' ),
			'dependency' => array(
				'element' => 'full_height',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Equal height', 'terminus' ),
			'param_name' => 'equal_height',
			'description' => esc_html__( 'If checked columns will be set to equal height.', 'terminus' ),
			'value' => array( esc_html__( 'Yes', 'terminus' ) => 'yes' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Content position', 'terminus' ),
			'param_name' => 'content_placement',
			'value' => array(
				esc_html__( 'Default', 'terminus' ) => '',
				esc_html__( 'Top', 'terminus' ) => 'top',
				esc_html__( 'Middle', 'terminus' ) => 'middle',
				esc_html__( 'Bottom', 'terminus' ) => 'bottom',
			),
			'description' => esc_html__( 'Select content position within columns.', 'terminus' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use video background?', 'terminus' ),
			'param_name' => 'video_bg',
			'description' => esc_html__( 'If checked, video will be used as row background.', 'terminus' ),
			'value' => array( esc_html__( 'Yes', 'terminus' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'YouTube link', 'terminus' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			'description' => esc_html__( 'Add YouTube link.', 'terminus' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Parallax', 'terminus' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				esc_html__( 'Simple', 'terminus' ) => 'content-moving'
			),
			'description' => esc_html__( 'Add parallax type background for row.', 'terminus' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Parallax', 'terminus' ),
			'param_name' => 'parallax',
			'value' => array(
				esc_html__( 'None', 'terminus' ) => '',
				esc_html__( 'Simple', 'terminus' ) => 'content-moving',
				__( 'With pattern', 'terminus' ) => 'content-moving-pattern'
			),
			'description' => esc_html__( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'terminus' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			)
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'terminus' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'terminus' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
			'group' => esc_html__( 'Parallax', 'terminus' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Overlay background color', 'terminus' ),
			'param_name' => 'overlay_color',
			'description' => esc_html__( 'Select custom overlay color for background.', 'terminus' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
			'group' => esc_html__( 'Parallax', 'terminus' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax opacity', 'terminus' ),
			'param_name' => 'parallax_opacity',
			'value' => '0.5',
			'description' => esc_html__( 'The opacity property can take a value from 0.0 - 1.0. The lower value, the more transparent. (Note: Default value is 0.5, min value 0 max value is 1)', 'terminus' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true
			),
			'group' => esc_html__( 'Parallax', 'terminus' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax speed', 'terminus' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => esc_html__( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'terminus' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax speed', 'terminus' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => esc_html__( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'terminus' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Row ID', 'terminus' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'terminus' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable row', 'terminus' ),
			'param_name' => 'disable_element', // Inner param name.
			'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'terminus' ),
			'value' => array( esc_html__( 'Yes', 'terminus' ) => 'yes' ),
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
			'group' => esc_html__( 'Design Options', 'terminus' ),
		),
	),
	'js_view' => 'VcRowView',
) );

vc_map(
	array(
		'name' => esc_html__( 'Text Block', 'terminus' ),
		'base' => 'vc_column_text',
		'icon' => 'icon-wpb-layer-shape-text',
		'wrapper_class' => 'clearfix',
		'category' => esc_html__( 'Content', 'terminus' ),
		'description' => esc_html__( 'A block of text with WYSIWYG editor', 'terminus' ),
		'params' => array(
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Text', 'terminus' ),
				'param_name' => 'content',
				'value' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'terminus' ),
			),
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
		),
	)
);

/* Theme Shortcodes
/* ---------------------------------------------------------------- */

/* Gallery/Slideshow
---------------------------------------------------------- */
vc_map( array(
	'name' => esc_html__( 'Image Gallery', 'terminus' ),
	'base' => 'vc_gallery',
	'icon' => 'icon-wpb-images-stack',
	'category' => esc_html__( 'Content', 'terminus' ),
	'description' => esc_html__( 'Responsive image gallery', 'terminus' ),
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
			'heading' => esc_html__( 'Image source', 'terminus' ),
			'param_name' => 'source',
			'value' => array(
				esc_html__( 'Media library', 'terminus' ) => 'media_library',
				esc_html__( 'External links', 'terminus' ) => 'external_link',
			),
			'std' => 'media_library',
			'description' => esc_html__( 'Select image source.', 'terminus' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'terminus' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'terminus' ) => 2,
				esc_html__( '3 Columns', 'terminus' ) => 3,
				esc_html__( '4 Columns', 'terminus' ) => 4,
				esc_html__( '5 Columns', 'terminus' ) => 5,
				esc_html__( '6 Columns', 'terminus' ) => 6
			),
			'std' => 4,
			'description' => esc_html__( 'How many columns should be displayed?', 'terminus' )
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'terminus' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'terminus' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library',
			),
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'External links', 'terminus' ),
			'param_name' => 'custom_srcs',
			'description' => esc_html__( 'Enter external link for each gallery image (Note: divide links with linebreaks (Enter)).', 'terminus' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link',
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Image size', 'terminus' ),
			'param_name' => 'img_size',
			'value' => 'thumbnail',
			'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'terminus' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library',
			),
			'std' => '275x275'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Image size', 'terminus' ),
			'param_name' => 'external_img_size',
			'value' => '',
			'description' => esc_html__( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'terminus' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link',
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'terminus' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'terminus' ),
			'value' => array( esc_html__( 'Yes, please', 'terminus' ) => true )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'On click action', 'terminus' ),
			'param_name' => 'onclick',
			'value' => array(
				esc_html__( 'Open lightbox', 'terminus' ) => 'link_image',
				esc_html__( 'Open custom link', 'terminus' ) => 'custom_link',
			),
			'description' => esc_html__( 'Select action for click action.', 'terminus' ),
			'std' => 'link_image',
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'Custom links', 'terminus' ),
			'param_name' => 'custom_links',
			'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'terminus' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' ),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Custom link target', 'terminus' ),
			'param_name' => 'custom_links_target',
			'description' => esc_html__( 'Select where to open  custom links.', 'terminus' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link', 'img_link_large' ),
			),
			'value' => $target_arr,
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
			'group' => esc_html__( 'Design Options', 'terminus' ),
		),
	),
) );

/* Tooltip
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__('Tooltip', 'terminus'),
	'base' => 'vc_mad_tooltip',
	'category' => esc_html__('Terminus', 'terminus'),
	'icon' => 'icon-wpb-mad-tooltip',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Text', 'terminus'),
			'param_name' => 'text',
			'admin_label' => true,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link", 'terminus'),
			"param_name" => "link",
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Link target', 'terminus' ),
			'param_name' => 'target_link',
			'description' => esc_html__( 'Select where to open link.', 'terminus' ),
			'value' => $target_arr,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Tooltip Text', 'terminus'),
			'param_name' => 'tooltip_text',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tooltip Position', 'terminus' ),
			'param_name' => 'tooltip_position',
			'value' => array(
				esc_html__('Top', 'terminus')     => 'top',
				esc_html__('Right', 'terminus')   => 'right',
				esc_html__('Bottom', 'terminus')  => 'bottom',
				esc_html__('Left', 'terminus')    => 'left'
			)
		)
	)
) );

/* Highlight
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__('Highlight', 'terminus'),
	'base' => 'vc_mad_highlight',
	'category' => esc_html__('Terminus', 'terminus'),
	'icon' => 'icon-wpb-mad-highlight',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Text', 'terminus'),
			'param_name' => 'text',
			'admin_label' => true,
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Background Color', 'terminus' ),
			'param_name' => 'bg_color',
			'description' => esc_html__( 'Select custom color for background.', 'terminus' ),
		)
	)
) );

/* List Styles
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'List Styles', 'terminus' ),
	'base' => 'vc_mad_list_styles',
	'icon' => 'icon-wpb-mad-list-styles',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'List styles', 'terminus' ),
	'params' => array(
		array(
			"type" => "choose_icons",
			"heading" => esc_html__("Icon", 'terminus'),
			"param_name" => "icon",
			"value" => 'none',
			"description" => esc_html__( 'Select icon from library for you list styles. If you do not select an icon get a numbered list', 'terminus')
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'List Items', 'terminus' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Input list items values. Divide values with linebreaks (Enter). Example: Development|Design', 'terminus' ),
			'value' => 'Nulla venenatis. In pede mi|Aliquet sit amet euismod|In auctor ut ligula aliquam dapibus|Tincidunt metus praesent'
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for icon', 'terminus' ),
			'param_name' => 'icon_color',
			'description' => esc_html__( 'Select custom color for icon.', 'terminus' ),
		)
	)
) );

/* Team Members
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Team Members', 'terminus' ),
	'base' => 'vc_mad_team_members',
	'icon' => 'icon-wpb-mad-team-members',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Team Members post type', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'terminus' ),
			'param_name' => 'items',
			'value' => Terminus_Vc_Config::array_number(1, 6, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
		),
		array(
			"type" => "get_terms",
			"term" => "team_category",
			'heading' => esc_html__( 'Which categories should be used for the team?', 'terminus' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show team from only those categories.', 'terminus'),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'terminus' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'terminus' ) => 'date',
				esc_html__( 'ID', 'terminus' ) => 'ID',
				esc_html__( 'Author', 'terminus' ) => 'author',
				esc_html__( 'Title', 'terminus' ) => 'title',
				esc_html__( 'Modified', 'terminus' ) => 'modified',
				esc_html__( 'Random', 'terminus' ) => 'rand',
				esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
				esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
			),
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'terminus' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'terminus' ) => 'DESC',
				esc_html__( 'ASC', 'terminus' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'terminus' )
		)
	)
) );

/* Testimonials
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Testimonials', 'terminus' ),
	'base' => 'vc_mad_testimonials',
	'icon' => 'icon-wpb-mad-testimonials',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Testimonials post type', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for text', 'terminus' ),
			'param_name' => 'text_color',
			'description' => esc_html__( 'Select custom color for text.', 'terminus' ),
			'group' => esc_html__( 'Styling', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('type_4')
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Testimonial Style', 'terminus' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Default', 'terminus' ) => 'type_default',
				esc_html__( 'Carousel', 'terminus' ) => 'type_carousel',
				esc_html__( 'With a big image', 'terminus' ) => 'type_2',
				esc_html__( 'Style with red line', 'terminus' ) => 'type_3',
				esc_html__( 'Style with lines', 'terminus' ) => 'type_4'
			),
			'description' => esc_html__( 'Here you can select how to display the testimonials.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'terminus' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '1 Column', 'terminus' ) => 1,
				esc_html__( '2 Columns', 'terminus' ) => 2
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'terminus' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('type_default', 'type_carousel')
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'terminus' ),
			'param_name' => 'items',
			'value' => Terminus_Vc_Config::array_number(1, 20, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
		),
		array(
			"type" => "get_terms",
			"term" => "testimonials_category",
			'heading' => esc_html__( 'Which categories should be used for the testimonials?', 'terminus' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show testimonials from only those categories.', 'terminus'),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'terminus' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'terminus' ) => 'date',
				esc_html__( 'ID', 'terminus' ) => 'ID',
				esc_html__( 'Author', 'terminus' ) => 'author',
				esc_html__( 'Title', 'terminus' ) => 'title',
				esc_html__( 'Modified', 'terminus' ) => 'modified',
				esc_html__( 'Random', 'terminus' ) => 'rand',
				esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
				esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'terminus' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'terminus' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'terminus' ) => 'DESC',
				esc_html__( 'ASC', 'terminus' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'terminus' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL button to the testimonials (optional)', 'terminus' ),
			"param_name" => "link"
		),
		terminus_vc_map_add_css_animation()
	)
) );

/* Experience List
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Experience List', 'terminus' ),
	'base' => 'vc_mad_experience_list',
	'icon' => 'icon-wpb-mad-info-list',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Experience list', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'terminus' ),
			'param_name' => 'title',
			'edit_field_class' => 'vc_col-sm-6',
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'terminus' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for experience list - name, position and time.', 'terminus' ),
			'value' => urlencode( json_encode( array(
				array(
					'name' => esc_html__( 'Inner Systems, LLC, Dallas, TX', 'terminus' ),
					'position' => esc_html__('Field Sales Representative', 'terminus'),
					'time' => '2/2014-Present',
				),
				array(
					'name' => esc_html__( 'Aural Tech, Inc., Seattle, WA', 'terminus' ),
					'position' => esc_html__('Territory Manager', 'terminus'),
					'time' => '3/2011-2/2014',
				),
				array(
					'name' => esc_html__( 'Self-Employed, Tulsa, OK', 'terminus' ),
					'position' => esc_html__('Sales Manager', 'terminus'),
					'time' => '10/2009-3/2011',
				),
				array(
					'name' => esc_html__( 'Tru Commuter Air, LLC, Dallas, TX', 'terminus' ),
					'position' => esc_html__('Intern', 'terminus'),
					'time' => '5/2008-10/2009',
				)
			) ) ),
			'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Company Name', 'terminus' ),
						'param_name' => 'name',
						'description' => esc_html__( 'Enter text used as company name.', 'terminus' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Position', 'terminus' ),
						'param_name' => 'position',
						'description' => esc_html__( 'Enter position.', 'terminus' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Work Time', 'terminus' ),
						'param_name' => 'time',
						'description' => esc_html__( 'Enter work time.', 'terminus' ),
						'admin_label' => true,
					)
				)
			)
		)
) );

/* Countdown
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__( "Countdown", 'terminus' ),
	"base" => "vc_mad_countdown",
	"icon" => "icon-wpb-mad-countdown",
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Countdown', 'terminus' ),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'terminus' ),
			"param_name" => "title",
			"value" => '',
		),
		array(
			"type" => "datetimepicker",
			"class" => "",
			"heading" => esc_html__("Target Time For Countdown", 'terminus'),
			"param_name" => "datetime",
			"value" => "",
			"description" => esc_html__("Date and time format (yyyy/mm/dd hh:mm:ss).", 'terminus'),
		),
//		array(
//			"type" => "textarea_html",
//			"holder" => "div",
//			"class" => "",
//			"heading" => esc_html__( "Description", 'terminus' ),
//			"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
//			"value" => esc_html__( "<p>I am test text block. Click edit button to change this text.</p>", 'terminus' ),
//			"description" => esc_html__( "Enter your content.", 'terminus' )
//		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Text align", 'terminus'),
			"param_name" => "text_align",
			"value" => array(
				esc_html__("Left",'terminus') => "left",
				esc_html__("Right",'terminus') => "right",
				esc_html__("Center",'terminus') => "center"
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'terminus' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'terminus' )
		)
	)
) );

/* Brands Logo
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Pie Chart', 'terminus' ),
	'base' => 'vc_mad_pie_chart',
	'icon' => 'icon-wpb-mad-chart-pie',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Animated pie chart', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'terminus' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'terminus' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'HTML', 'terminus' ),
					'value' => '75'
				),
				array(
					'label' => esc_html__( 'CSS', 'terminus' ),
					'value' => '85',
				),
				array(
					'label' => esc_html__( 'Javascript', 'terminus' ),
					'value' => '60',
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
					'description' => esc_html__( 'Enter value of pie chart.', 'terminus' ),
					'admin_label' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon', 'terminus' ),
					'param_name' => 'icon',
					'value' => array(
						esc_html__('None', 'terminus') => '',
						'html5' => 'e9c6',
						'css3' => 'e9ad',
						'cog' => 'e884'
					),
					'admin_label' => true,
					'description' => esc_html__( 'Select icon for you pie chart.', 'terminus' )
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'terminus' ),
					'param_name' => 'customcolor',
					'description' => esc_html__( 'Select custom pie chart border color.', 'terminus' )
				)
			)
		)
	)
) );

/* Brands Logo
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Brands Logo', 'terminus' ),
	'base' => 'vc_mad_brands_logo',
	'icon' => 'icon-wpb-mad-brands-logo',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Brands logo', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'terminus' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'terminus' )
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__( 'Links', 'terminus' ),
			"param_name" => "links",
			"holder" => "span",
			"description" => esc_html__( 'Input links values. Divide values with linebreaks (|). Example: http://brand.com | http://brand2.com', 'terminus' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'terminus' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'terminus' ),
			'value' => array( esc_html__( 'Yes, please', 'terminus' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'terminus' ),
			'param_name' => 'autoplay',
			'description' => esc_html__( 'Enables autoplay mode.', 'terminus' ),
			'value' => array( esc_html__( 'Yes, please', 'terminus' ) => 'yes' )
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'terminus' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'terminus' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		terminus_vc_map_add_css_animation()
	)
) );


/* Text Block with Image
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Text Block with Image', 'terminus' ),
	'base' => 'vc_mad_text_block',
	'icon' => 'icon-wpb-mad-info-block',
	'wrapper_class' => 'clearfix',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'A block of text with WYSIWYG editor and with image', 'terminus' ),
	'params' => array(
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'terminus' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment image', 'terminus' ),
			'param_name' => 'alignment',
			'value' => array(
				esc_html__( 'Left', 'terminus' ) => 'left',
				esc_html__( 'Right', 'terminus' ) => 'right'
			),
			'description' => esc_html__( 'Here you can select alignment image.', 'terminus' )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'terminus' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'terminus' ),
		)

	)
) );


/* Blockquotes
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blockquotes', 'terminus' ),
	'base' => 'vc_mad_blockquotes',
	'icon' => 'icon-wpb-mad-testimonials',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Blockquotes styles', 'terminus' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'terminus' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Style 1', 'terminus' ) => 'type_1',
				esc_html__( 'Style 2', 'terminus' ) => 'type_2',
				esc_html__( 'Style 3', 'terminus' ) => 'type_3',
			),
			'description' => esc_html__( 'Choose the default style for blockquote.', 'terminus' )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'terminus' ),
			'param_name' => 'content',
			'value' => esc_html__( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'terminus' ),
		)

	)
));

/* Blog Posts
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blog Posts', 'terminus' ),
	'base' => 'vc_mad_blog_posts',
	'icon' => 'icon-wpb-mad-blog-posts',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Blog posts', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Blog Layout', 'terminus' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Layout 1', 'terminus' ) => 'layout_1',
				esc_html__( 'Layout 2', 'terminus' ) => 'layout_2',
				esc_html__( 'Layout 3', 'terminus' ) => 'layout_3',
				esc_html__( 'Layout 4', 'terminus' ) => 'layout_4'
			),
			'std' => 'layout_1',
			'description' => esc_html__( 'Choose the default blog layout here.', 'terminus' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'First post big?', 'terminus' ),
			'param_name' => 'first_big_post',
			'description' => '',
			'dependency' => array(
				'element' => 'layout',
				'value' => array('layout_3')
			),
			'value' => array( esc_html__( 'Yes, please', 'terminus' ) => 'yes' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Blog Style', 'terminus' ),
			'param_name' => 'blog_style',
			'value' => array(
				esc_html__( 'Big Thumbs', 'terminus' ) => 'blog-big-thumbs',
				esc_html__( 'Small Thumbs', 'terminus' ) => 'blog-small-thumbs',
				esc_html__( 'Grid', 'terminus' ) => 'blog-grid',
				esc_html__( 'Masonry', 'terminus' ) => 'blog-masonry'
			),
			'std' => 'blog-grid',
			'dependency' => array(
				'element' => 'layout',
				'value' => array('layout_4')
			),
			'description' => esc_html__( 'Choose the default blog layout here.', 'terminus' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'terminus' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'terminus' ),
			'value' => array( esc_html__( 'Yes, please', 'terminus' ) => true ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array('layout_1', 'layout_2')
			)
		),
		array(
			"type" => "get_terms",
			"term" => "category",
			'heading' => esc_html__( 'Which categories should be used for the blog?', 'terminus' ),
			"param_name" => "category",
			"holder" => "div",
			'description' => esc_html__('The Page will then show entries from only those categories.', 'terminus'),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'terminus' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'terminus' ) => 'date',
				esc_html__( 'ID', 'terminus' ) => 'ID',
				esc_html__( 'Author', 'terminus' ) => 'author',
				esc_html__( 'Title', 'terminus' ) => 'title',
				esc_html__( 'Modified', 'terminus' ) => 'modified',
				esc_html__( 'Random', 'terminus' ) => 'rand',
				esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
				esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'terminus' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'terminus' ) => 'DESC',
				esc_html__( 'ASC', 'terminus' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'terminus' ),
			'param_name' => 'layout_columns',
			'value' => array(
				esc_html__( '2 Columns', 'terminus' ) => 2,
				esc_html__( '3 Columns', 'terminus' ) => 3,
				esc_html__( '4 Columns', 'terminus' ) => 4
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'terminus' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array('layout_1', 'layout_2', 'layout_3')
			),
			'std' => 3,
			'group' => esc_html__( 'Blog Grid', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'terminus' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'terminus' ) => 2,
				esc_html__( '3 Columns', 'terminus' ) => 3,
				esc_html__( '4 Columns', 'terminus' ) => 4,
				esc_html__( '5 Columns', 'terminus' ) => 5,
				esc_html__( '6 Columns', 'terminus' ) => 6
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'terminus' ),
			'dependency' => array(
				'element' => 'blog_style',
				'value' => array('blog-grid', 'blog-masonry')
			),
			'std' => 3,
			'group' => esc_html__( 'Blog Grid', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'terminus' ),
			'param_name' => 'items',
			'value' => Terminus_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 10,
			'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'terminus' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'terminus' ) => 'pagination',
				esc_html__( 'No option to view additional entries', 'terminus' ) => 'none'
			),
			'description' => esc_html__( 'Should a pagination be displayed?', 'terminus' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Items per page', 'terminus' ),
			'param_name' => 'items_per_page',
			'description' => esc_html__( 'Number of items to show per page.', 'terminus' ),
			'value' => 5,
			'dependency' => array(
				'element' => 'paginate',
				'value' => array('load_more')
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		terminus_vc_map_add_css_animation()
	)
) );

/* Blog Posts Slider
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blog Posts Slider', 'terminus' ),
	'base' => 'vc_mad_blog_posts_slider',
	'icon' => 'icon-wpb-mad-blog-posts',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Blog posts carousel', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			"type" => "get_terms",
			"term" => "category",
			'heading' => esc_html__( 'Which categories should be used for the blog?', 'terminus' ),
			"param_name" => "category",
			"holder" => "div",
			'description' => esc_html__('The Page will then show entries from only those categories.', 'terminus'),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'terminus' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'terminus' ) => 'date',
				esc_html__( 'ID', 'terminus' ) => 'ID',
				esc_html__( 'Author', 'terminus' ) => 'author',
				esc_html__( 'Title', 'terminus' ) => 'title',
				esc_html__( 'Modified', 'terminus' ) => 'modified',
				esc_html__( 'Random', 'terminus' ) => 'rand',
				esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
				esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'terminus' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'terminus' ) => 'DESC',
				esc_html__( 'ASC', 'terminus' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'terminus' ),
			'param_name' => 'items',
			'value' => Terminus_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 10,
			'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
		)
	)
) );

/* Portfolio
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Portfolio', 'terminus' ),
	'base' => 'vc_mad_portfolio',
	'icon' => 'icon-wpb-mad-portfolio',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Displayed for portfolio items', 'terminus' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'terminus' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Grid', 'terminus' ) => 'grid',
				esc_html__( 'Classic', 'terminus' ) => 'grid-classic',
				esc_html__( 'Carousel', 'terminus' ) => 'carousel',
				esc_html__( 'Masonry', 'terminus' ) => 'masonry'
			),
			'description' => esc_html__( 'Layout be displayed?', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Spacing between items', 'terminus' ),
			'param_name' => 'spacing',
			'value' => array(
				esc_html__( 'With Spacing', 'terminus' ) => 'with_spacing',
				esc_html__( 'Without Spacing', 'terminus' ) => 'without_spacing'
			),
			'description' => esc_html__( 'Select spacing mode', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'With or without actions', 'terminus' ),
			'param_name' => 'actions',
			'value' => array(
				esc_html__( 'With Actions', 'terminus' ) => 'with_actions',
				esc_html__( 'Without Actions', 'terminus' ) => 'without_actions'
			),
			'description' => esc_html__( 'Select with or without actions', 'terminus' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Excerpt hide?', 'terminus' ),
			'param_name' => 'excerpt_hidden',
			'description' => esc_html__( 'If checked excerpt will be hidden.', 'terminus' ),
			'value' => array( esc_html__( 'Yes', 'terminus' ) => true ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Filter', 'terminus' ),
			'param_name' => 'sort',
			'value' => array(
				esc_html__( 'No', 'terminus' ) => '',
				esc_html__( 'Yes', 'terminus' ) => 'yes'
			),
			'description' => esc_html__( 'Should the sorting options based on categories be displayed?', 'terminus' )
		),
		array(
			"type" => "get_terms",
			"term" => "portfolio_categories",
			'heading' => esc_html__( 'Which categories should be used for the portfolio?', 'terminus' ),
			"param_name" => "categories",
			'description' => esc_html__('The Page will then show portfolio from only those categories.', 'terminus'),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'terminus' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'terminus' ) => 'date',
				esc_html__( 'ID', 'terminus' ) => 'ID',
				esc_html__( 'Author', 'terminus' ) => 'author',
				esc_html__( 'Title', 'terminus' ) => 'title',
				esc_html__( 'Modified', 'terminus' ) => 'modified',
				esc_html__( 'Random', 'terminus' ) => 'rand',
				esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
				esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'terminus' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'terminus' ) => 'DESC',
				esc_html__( 'ASC', 'terminus' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'terminus' ),
			'group' => esc_html__( 'Data Settings', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'terminus' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '1 Column', 'terminus' ) => 1,
				esc_html__( '2 Columns', 'terminus' ) => 2,
				esc_html__( '3 Columns', 'terminus' ) => 3,
				esc_html__( '4 Columns', 'terminus' ) => 4,
				esc_html__( '5 Columns', 'terminus' ) => 5,
				esc_html__( '6 Columns', 'terminus' ) => 6
			),
			'std' => 3,
			'description' => esc_html__( 'How many columns should be displayed?', 'terminus' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Image size', 'terminus' ),
			'param_name' => 'img_size',
			'value' => '',
			'description' => esc_html__( 'Enter image size. Example: Enter image size in pixels: 480*480 (Width x Height). Leave empty to use default size.', 'terminus' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array('grid', 'grid-classic', 'carousel')
			),
			'std' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'terminus' ),
			'param_name' => 'items',
			'value' => Terminus_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'terminus' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'terminus' ) => 'pagination',
				esc_html__( 'Load more button', 'terminus' ) => 'load-more',
				esc_html__( 'Lazy loading', 'terminus' ) => 'lazy-load',
				esc_html__( 'No option to view additional entries', 'terminus' ) => 'none'
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'terminus' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Items per page', 'terminus' ),
			'param_name' => 'items_per_page',
			'description' => esc_html__( 'Number of items to show per page.', 'terminus' ),
			'value' => 10,
			'dependency' => array(
				'element' => 'paginate',
				'value' => array('load-more', 'lazy-load')
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group' => esc_html__( 'Pagination', 'terminus' )
		),
		terminus_vc_map_add_css_animation()
	)
) );

/* Banners
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Banners', 'terminus' ),
	'base' => 'vc_mad_banners',
	'icon' => 'icon-wpb-mad-banners',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'banners', 'terminus' ),
	'params' => array(
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'terminus' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'terminus' )
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__( 'Links', 'terminus' ),
			"param_name" => "links",
			"holder" => "span",
			"description" => esc_html__( 'Input links values. Divide values with linebreaks (|). Example: http://brand.com | http://brand2.com', 'terminus' )
		),
		terminus_vc_map_add_css_animation()
	)
) );

if (class_exists('WooCommerce')) {

	/* Product Grid
	---------------------------------------------------------- */

	vc_map( array(
		'name' => esc_html__( 'Products', 'terminus' ),
		'base' => 'vc_mad_products',
		'icon' => 'icon-wpb-mad-woocommerce',
		'category' => esc_html__( 'Terminus', 'terminus' ),
		'description' => esc_html__( 'Displayed for product grid', 'terminus' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'terminus' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
				'type' => 'textfield',
				'heading' => esc_html__( 'Description', 'terminus' ),
				'param_name' => 'description',
				'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Grid or Carousel', 'terminus' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Grid Style', 'terminus') => 'view-grid',
					esc_html__('Carousel', 'terminus') => 'view-carousel'
				),
				'std' => '',
				'description' => esc_html__('Choose the type style.', 'terminus')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'terminus' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__('Type 1', 'terminus') => 'type_1',
					esc_html__('Type 2', 'terminus') => 'type_2'
				),
				'std' => 'type_1',
				'description' => esc_html__('Choose layout style.', 'terminus')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'terminus' ),
				'param_name' => 'columns',
				'value' => array(
					esc_html__( '1 Column', 'terminus' ) => 1,
					esc_html__( '2 Columns', 'terminus' ) => 2,
					esc_html__( '3 Columns', 'terminus' ) => 3,
					esc_html__( '4 Columns', 'terminus' ) => 4,
					esc_html__( '5 Columns', 'terminus' ) => 5,
					esc_html__( '6 Columns', 'terminus' ) => 6
				),
				'std' => 4,
				'description' => esc_html__( 'How many columns should be displayed?', 'terminus' ),
				'param_holder_class' => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Count Items', 'terminus' ),
				'param_name' => 'items',
				'value' => Terminus_Vc_Config::array_number(1, 30, 1, array('All' => -1)),
				'std' => 9,
				'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show', 'terminus' ),
				'param_name' => 'show',
				'value' => array(
					esc_html__( 'All Products', 'terminus' ) => '',
					esc_html__( 'Featured Products', 'terminus' ) => 'featured',
					esc_html__( 'On-sale Products', 'terminus' ) => 'onsale',
					esc_html__( 'Best Selling Products', 'terminus' ) => 'bestselling',
					esc_html__( 'Top Rated Products', 'terminus' ) => 'toprated',
					esc_html__( 'New', 'terminus' ) => 'new'
				),
				'description' => '',
				'std' => '',
				'group' => esc_html__( 'Data Settings', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Order by', 'terminus' ),
				'param_name' => 'orderby',
				'value' => array(
					esc_html__('Default sorting', 'terminus' ) => 'menu_order',
					esc_html__('Sort by popularity', 'terminus' ) => 'popularity',
					esc_html__('Sort by average rating', 'terminus' ) => 'rating',
					esc_html__('Sort by newness', 'terminus' ) => 'date',
					esc_html__('Sort by price: low to high', 'terminus' ) => 'price',
					esc_html__('Sort by price: high to low', 'terminus' ) => 'price-desc'
				),
				'description' => esc_html__( 'Here you can choose how to display the products', 'terminus' ),
				'group' => esc_html__( 'Data Settings', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Sorting Order', 'terminus' ),
				'param_name' => 'order',
				'value' => array(
					esc_html__( 'ASC', 'terminus' ) => 'asc',
					esc_html__( 'DESC', 'terminus' ) => 'desc'
				),
				'description' => esc_html__( 'Here you can choose how to display the products', 'terminus' ),
				'std' => 'desc',
				'group' => esc_html__( 'Data Settings', 'terminus' )
			),
			array(
				'type' => 'autocomplete',
				'settings' => array(
					'multiple' => true,
					// is multiple values allowed? default false
					// 'sortable' => true, // is values are sortable? default false
					'min_length' => 2,
					// min length to start search -> default 2
					// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
					'groups' => true,
					// In UI show results grouped by groups, default false
					'unique_values' => true,
					// In UI show results except selected. NB! You should manually check values in backend, default false
					'display_inline' => true,
					// In UI show results inline view, default false (each value in own line)
					'delay' => 500,
					// delay for search. default 500
					'auto_focus' => true,
					// auto focus input, default true
					// 'values' => $taxonomies_list,
				),
				'heading' => esc_html__( 'Select identificators', 'terminus' ),
				'param_name' => 'by_id',
				'admin_label' => true,
				'group' => esc_html__( 'Data Settings', 'terminus' ),
				'description' => esc_html__('Input product ID or product SKU or product title to see suggestions', 'terminus')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Filter', 'terminus' ),
				'param_name' => 'filter',
				'value' => array(
					esc_html__( 'No', 'terminus' ) => '',
					esc_html__( 'Yes', 'terminus' ) => 'yes'
				),
				'std' => '',
				'description' => esc_html__( 'Should the filter options based on categories be displayed?', 'terminus' )
			),
			array(
				"type" => "get_terms",
				"term" => "product_cat",
				'heading' => esc_html__( 'Which categories should be used for the products?', 'terminus' ),
				"param_name" => "categories",
				'admin_label' => true,
				'group' => esc_html__( 'Filter', 'terminus' ),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('yes')
				),
				'description' => esc_html__('The Page will then show products from only those categories.', 'terminus')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pagination', 'terminus' ),
				'param_name' => 'pagination',
				'value' => array(
					esc_html__( 'No', 'terminus' ) => 'no',
					esc_html__( 'Yes', 'terminus' ) => 'yes'
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array(''),
				),
				'std' => 'no',
				'description' => esc_html__( 'Should a pagination be displayed?', 'terminus' )
			),
			terminus_vc_map_add_css_animation()
		)
	) );

	$Vc_Vendor_Woocommerce = new Vc_Vendor_Woocommerce();

	//Filters For autocomplete param:
	//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
	add_filter( 'vc_autocomplete_vc_mad_products_by_id_callback', array($Vc_Vendor_Woocommerce, 'productIdAutocompleteSuggester' ), 10, 1 );
	// Get suggestion(find). Must return an array
	add_filter( 'vc_autocomplete_vc_mad_products_by_id_render', array($Vc_Vendor_Woocommerce, 'productIdAutocompleteRender' ), 10, 1 );
	// Render exact product. Must return an array (label,value)
	//For param: ID default value filter
	add_filter( 'vc_form_fields_render_field_vc_mad_products_by_id_param_value', array($Vc_Vendor_Woocommerce, 'productIdDefaultValue' ), 10, 4 );
	// Defines default value for param if not provided. Takes from other param value.

	/* Lookbooks
	---------------------------------------------------------- */

	vc_map( array(
		'name' => esc_html__( 'Lookbooks', 'terminus' ),
		'base' => 'vc_mad_lookbooks',
		'icon' => 'icon-wpb-mad-woocommerce',
		'category' => esc_html__( 'Terminus', 'terminus' ),
		'description' => esc_html__( 'Displayed for lookbooks', 'terminus' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'terminus' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
				'type' => 'textfield',
				'heading' => esc_html__( 'Description', 'terminus' ),
				'param_name' => 'description',
				'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Grid or Carousel', 'terminus' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Grid Style', 'terminus') => 'view-grid',
					esc_html__('Carousel', 'terminus') => 'view-carousel'
				),
				'std' => '',
				'description' => esc_html__('Choose the type style.', 'terminus')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'terminus' ),
				'param_name' => 'columns',
				'value' => array(
					esc_html__( '2 Columns', 'terminus' ) => 2,
					esc_html__( '3 Columns', 'terminus' ) => 3,
					esc_html__( '4 Columns', 'terminus' ) => 4,
					esc_html__( '5 Columns', 'terminus' ) => 5
				),
				'std' => 4,
				'description' => esc_html__( 'How many columns should be displayed?', 'terminus' ),
				'param_holder_class' => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Count Items', 'terminus' ),
				'param_name' => 'items',
				'value' => Terminus_Vc_Config::array_number(1, 30, 1, array('All' => -1)),
				'std' => 9,
				'description' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Order by', 'terminus' ),
				'param_name' => 'orderby',
				'value' => array(
					esc_html__( 'Date', 'terminus' ) => 'date',
					esc_html__( 'ID', 'terminus' ) => 'ID',
					esc_html__( 'Author', 'terminus' ) => 'author',
					esc_html__( 'Title', 'terminus' ) => 'title',
					esc_html__( 'Modified', 'terminus' ) => 'modified',
					esc_html__( 'Random', 'terminus' ) => 'rand',
					esc_html__( 'Comment count', 'terminus' ) => 'comment_count',
					esc_html__( 'Menu order', 'terminus' ) => 'menu_order'
				),
				'description' => esc_html__( 'Here you can choose how to display the lookbooks', 'terminus' ),
				'group' => esc_html__( 'Data Settings', 'terminus' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Sorting Order', 'terminus' ),
				'param_name' => 'order',
				'value' => array(
					esc_html__( 'ASC', 'terminus' ) => 'asc',
					esc_html__( 'DESC', 'terminus' ) => 'desc'
				),
				'description' => esc_html__( 'Here you can choose how to display the lookbooks', 'terminus' ),
				'std' => 'desc',
				'group' => esc_html__( 'Data Settings', 'terminus' )
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__( 'Add URL button to the lookbooks (optional)', 'terminus' ),
				"param_name" => "link"
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pagination', 'terminus' ),
				'param_name' => 'pagination',
				'value' => array(
					esc_html__( 'No', 'terminus' ) => 'no',
					esc_html__( 'Yes', 'terminus' ) => 'yes'
				),
				'description' => esc_html__( 'Should a pagination be displayed?', 'terminus' )
			),
			terminus_vc_map_add_css_animation()
		)
	) );

}

/* Counter Bar
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Counter", 'terminus' ),
	"base"=> 'vc_mad_counter',
	"icon" => 'icon-wpb-mad-counter',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	"description" => esc_html__( 'Animated counter', 'terminus' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'terminus' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' ),
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
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'terminus' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'terminus' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'terminus' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Years of Experience', 'terminus' ),
					'value' => '25',
					'icon' => 'time',
				),
				array(
					'label' => esc_html__( 'Satisfied Clients', 'terminus' ),
					'value' => '178',
					'icon' => 'partnership'
				),
				array(
					'label' => esc_html__( 'Completed Projects', 'terminus' ),
					'value' => '432',
					'icon'  => 'checkfile'
				),
				array(
					'label' => esc_html__( 'Cups of Coffee', 'terminus' ),
					'value' => '1257',
					'icon'  => 'cup'
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'terminus' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title.', 'terminus' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'terminus' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value.', 'terminus' ),
					'admin_label' => true,
				),
				array(
					"type" => "choose_icons",
					"heading" => esc_html__("Icon", 'terminus'),
					"param_name" => "icon",
					"value" => 'none',
					"description" => esc_html__( 'Select icon from library.', 'terminus')
				)
			)
		)
	)
));

/* Dropcap
---------------------------------------------------------- */
vc_map( array(
	'name' => esc_html__( 'Dropcap', 'terminus' ),
	'base' => 'vc_mad_dropcap',
	'icon' => 'icon-wpb-mad-dropcap',
	'category' => esc_html__( 'Terminus', 'terminus' ),
	'description' => esc_html__( 'Dropcap', 'terminus' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'terminus' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__( 'Default', 'terminus' ) => 'dropcap_type_default',
				esc_html__( 'Secondary', 'terminus' ) => 'dropcap_type_secondary',
				esc_html__( 'Circle', 'terminus' ) => 'dropcap_type_circle',
				esc_html__( 'Square', 'terminus' ) => 'dropcap_type_square'
			),
			'description' => esc_html__('Choose the first letter style.', 'terminus')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Letter', 'terminus' ),
			'param_name' => 'letter',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'terminus' ),
			'param_name' => 'content',
			'value' => ''
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for dropcap', 'terminus' ),
			'param_name' => 'dropcap_color',
			'description' => esc_html__( 'Select custom color for dropcap.', 'terminus' ),
		)
	)
));


/*** Visual Composer Content elements refresh ***/
class terminusVcSharedLibrary {
	// Here we will store plugin wise (shared) settings. Colors, Locations, Sizes, etc...
	/**
	 * @var array
	 */
	private static $colors = array(
		'Blue' => 'blue',
		'Turquoise' => 'turquoise',
		'Pink' => 'pink',
		'Violet' => 'violet',
		'Peacoc' => 'peacoc',
		'Chino' => 'chino',
		'Mulled Wine' => 'mulled_wine',
		'Vista Blue' => 'vista_blue',
		'Black' => 'black',
		'Grey' => 'grey',
		'Orange' => 'orange',
		'Sky' => 'sky',
		'Green' => 'green',
		'Juicy pink' => 'juicy_pink',
		'Sandy brown' => 'sandy_brown',
		'Purple' => 'purple',
		'White' => 'white'
	);

	/**
	 * @var array
	 */
	public static $icons = array(
		'Glass' => 'glass',
		'Music' => 'music',
		'Search' => 'search'
	);

	/**
	 * @var array
	 */
	public static $sizes = array(
		'Mini' => 'xs',
		'Small' => 'sm',
		'Normal' => 'md',
		'Large' => 'lg'
	);

	/**
	 * @var array
	 */
	public static $button_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'3D' => '3d',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $message_box_styles = array(
		'Standard' => 'standard',
		'Solid' => 'solid',
		'Solid icon' => 'solid-icon',
		'Outline' => 'outline',
		'3D' => '3d',
	);

	/**
	 * Toggle styles
	 * @var array
	 */
	public static $toggle_styles = array(
		'Default' => 'default',
		'Simple' => 'simple',
		'Round' => 'round',
		'Round Outline' => 'round_outline',
		'Rounded' => 'rounded',
		'Rounded Outline' => 'rounded_outline',
		'Square' => 'square',
		'Square Outline' => 'square_outline',
		'Arrow' => 'arrow',
		'Text Only' => 'text_only',
	);

	/**
	 * Animation styles
	 * @var array
	 */
	public static $animation_styles = array(
		'Bounce' => 'easeOutBounce',
		'Elastic' => 'easeOutElastic',
		'Back' => 'easeOutBack',
		'Cubic' => 'easeinOutCubic',
		'Quint' => 'easeinOutQuint',
		'Quart' => 'easeOutQuart',
		'Quad' => 'easeinQuad',
		'Sine' => 'easeOutSine'
	);

	/**
	 * @var array
	 */
	public static $cta_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $txt_align = array(
		'Left' => 'left',
		'Right' => 'right',
		'Center' => 'center',
		'Justify' => 'justify'
	);

	/**
	 * @var array
	 */
	public static $el_widths = array(
		'100%' => '',
		'90%' => '90',
		'80%' => '80',
		'70%' => '70',
		'60%' => '60',
		'50%' => '50'
	);

	/**
	 * @var array
	 */
	public static $sep_widths = array(
		'1px' => '',
		'2px' => '2',
		'3px' => '3',
		'4px' => '4',
		'5px' => '5',
		'6px' => '6',
		'7px' => '7',
		'8px' => '8',
		'9px' => '9',
		'10px' => '10'
	);

	/**
	 * @var array
	 */
	public static $sep_styles = array(
		'Border' => '',
		'Dashed' => 'dashed',
		'Dotted' => 'dotted',
		'Double' => 'double'
	);

	/**
	 * @var array
	 */
	public static $box_styles = array(
		'Default' => '',
		'Rounded' => 'vc_box_rounded',
		'Border' => 'vc_box_border',
		'Outline' => 'vc_box_outline',
		'Shadow' => 'vc_box_shadow',
		'Bordered shadow' => 'vc_box_shadow_border',
		'3D Shadow' => 'vc_box_shadow_3d',
		'Round' => 'vc_box_circle', //new
		'Round Border' => 'vc_box_border_circle', //new
		'Round Outline' => 'vc_box_outline_circle', //new
		'Round Shadow' => 'vc_box_shadow_circle', //new
		'Round Border Shadow' => 'vc_box_shadow_border_circle', //new
		'Circle' => 'vc_box_circle_2', //new
		'Circle Border' => 'vc_box_border_circle_2', //new
		'Circle Outline' => 'vc_box_outline_circle_2', //new
		'Circle Shadow' => 'vc_box_shadow_circle_2', //new
		'Circle Border Shadow' => 'vc_box_shadow_border_circle_2' //new
	);

	/**
	 * @return array
	 */
	public static function getColors() {
		return self::$colors;
	}

	/**
	 * @return array
	 */
	public static function getIcons() {
		return self::$icons;
	}

	/**
	 * @return array
	 */
	public static function getSizes() {
		return self::$sizes;
	}

	/**
	 * @return array
	 */
	public static function getButtonStyles() {
		return self::$button_styles;
	}

	/**
	 * @return array
	 */
	public static function getMessageBoxStyles() {
		return self::$message_box_styles;
	}

	/**
	 * @return array
	 */
	public static function getToggleStyles() {
		return self::$toggle_styles;
	}

	/**
	 * @return array
	 */
	public static function getAnimationStyles() {
		return self::$animation_styles;
	}

	/**
	 * @return array
	 */
	public static function getCtaStyles() {
		return self::$cta_styles;
	}

	/**
	 * @return array
	 */
	public static function getTextAlign() {
		return self::$txt_align;
	}

	/**
	 * @return array
	 */
	public static function getBorderWidths() {
		return self::$sep_widths;
	}

	/**
	 * @return array
	 */
	public static function getElementWidths() {
		return self::$el_widths;
	}

	/**
	 * @return array
	 */
	public static function getSeparatorStyles() {
		return self::$sep_styles;
	}

	/**
	 * @return array
	 */
	public static function getBoxStyles() {
		return self::$box_styles;
	}

	public static function getColorsDashed() {
		$colors = array(
			esc_html__( 'Blue', 'terminus' ) => 'blue',
			esc_html__( 'Turquoise', 'terminus' ) => 'turquoise',
			esc_html__( 'Pink', 'terminus' ) => 'pink',
			esc_html__( 'Violet', 'terminus' ) => 'violet',
			esc_html__( 'Peacoc', 'terminus' ) => 'peacoc',
			esc_html__( 'Chino', 'terminus' ) => 'chino',
			esc_html__( 'Mulled Wine', 'terminus' ) => 'mulled-wine',
			esc_html__( 'Vista Blue', 'terminus' ) => 'vista-blue',
			esc_html__( 'Black', 'terminus' ) => 'black',
			esc_html__( 'Grey', 'terminus' ) => 'grey',
			esc_html__( 'Orange', 'terminus' ) => 'orange',
			esc_html__( 'Sky', 'terminus' ) => 'sky',
			esc_html__( 'Green', 'terminus' ) => 'green',
			esc_html__( 'Juicy pink', 'terminus' ) => 'juicy-pink',
			esc_html__( 'Sandy brown', 'terminus' ) => 'sandy-brown',
			esc_html__( 'Purple', 'terminus' ) => 'purple',
			esc_html__( 'White', 'terminus' ) => 'white'
		);

		return $colors;
	}
}

/**
 * @param string $asset
 *
 * @return array
 */
function terminusgetVcShared( $asset = '' ) {
	switch ( $asset ) {
		case 'colors':
			return terminusVcSharedLibrary::getColors();
			break;

		case 'colors-dashed':
			return terminusVcSharedLibrary::getColorsDashed();
			break;

		case 'icons':
			return terminusVcSharedLibrary::getIcons();
			break;

		case 'sizes':
			return terminusVcSharedLibrary::getSizes();
			break;

		case 'button styles':
		case 'alert styles':
			return terminusVcSharedLibrary::getButtonStyles();
			break;
		case 'message_box_styles':
			return terminusVcSharedLibrary::getMessageBoxStyles();
			break;
		case 'cta styles':
			return terminusVcSharedLibrary::getCtaStyles();
			break;

		case 'text align':
			return terminusVcSharedLibrary::getTextAlign();
			break;

		case 'cta widths':
		case 'separator widths':
			return terminusVcSharedLibrary::getElementWidths();
			break;

		case 'separator styles':
			return terminusVcSharedLibrary::getSeparatorStyles();
			break;

		case 'separator border widths':
			return terminusVcSharedLibrary::getBorderWidths();
			break;

		case 'single image styles':
			return terminusVcSharedLibrary::getBoxStyles();
			break;

		case 'toggle styles':
			return terminusVcSharedLibrary::getToggleStyles();
			break;

		case 'animation styles':
			return terminusVcSharedLibrary::getAnimationStyles();
			break;

		default:
			# code...
			break;
	}

	return '';
}