<?php

// Include Google Webfonts
include( get_template_directory() . '/admin/framework/config/register-google-webfonts.php' );

/* ---------------------------------------------------------------------- */
/*	Pages Elements
/* ---------------------------------------------------------------------- */

$terminus_pages = array(
	array(
		'title' =>  esc_html__('Theme Options', 'terminus'),
		'slug' => 'terminus',
		'class' => 'admin-icon-general',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Styling Options', 'terminus'),
		'slug' => 'styling',
		'class' => 'admin-icon-styling',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Header', 'terminus'),
		'slug' => 'header',
		'class' => 'admin-icon-header',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Page Title', 'terminus'),
		'slug' => 'page-title',
		'class' => 'admin-icon-header',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Pages', 'terminus'),
		'slug' => 'page',
		'class' => 'admin-icon-header',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Sidebar', 'terminus'),
		'slug' => 'sidebar',
		'class' => 'admin-icon-sidebar',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Blog', 'terminus'),
		'slug' => 'blog',
		'class' => 'admin-icon-blog',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Portfolio', 'terminus'),
		'slug' => 'portfolio',
		'class' => 'admin-icon-portfolio',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Testimonials', 'terminus'),
		'slug' => 'testimonials',
		'class' => 'admin-icon-testimonials',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Team Members', 'terminus'),
		'slug' => 'team-members',
		'class' => 'admin-icon-team-members',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Footer', 'terminus'),
		'slug' => 'footer',
		'class' => 'admin-icon-footer',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Shop', 'terminus'),
		'slug' => 'shop',
		'class' => 'admin-icon-shop',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Sitemap', 'terminus'),
		'slug' => 'sitemap',
		'class' => 'admin-icon-sitemap',
		'parent'=> 'terminus',
	),
	array(
		'title' =>  esc_html__('Import / Export', 'terminus'),
		'slug' => 'import',
		'class' => 'admin-icon-import',
		'parent'=> 'terminus',
	)
);

/* ---------------------------------------------------------------------- */
/*	General Elements
/* ---------------------------------------------------------------------- */

$terminus_elements[] = array(
	"slug"	=> 'terminus',
	"type" 	=> "hidden",
	"id" 	=> "favicon_upload",
	"desc" 	=> '',
	"std" => '',
	"dependence" => 'favicon'
);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Favicon', 'terminus'),
	"slug"	=> 'terminus',
	"type" 	=> "upload",
	"data" 	=> array(
		'title' => esc_html__('Upload Favicon', 'terminus'),
		'text' => esc_html__('Upload', 'terminus')
	),
	"id" 	=> "favicon",
	"desc" 	=> esc_html__('Display site icon meta tags.', 'terminus'),
	"std" => get_template_directory_uri() . '/images/fav_icon.png'
);

	/* ---------------------------------------------------------------------- */
	/*	Logo
	/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Logo Settings', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "heading",
		"desc" 	=> "",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Type Logo', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "buttons_set",
		"id" 	=> "logo_type",
		"options" => array(
			'text' => esc_html__('Text Logo', 'terminus'),
			'upload' => esc_html__('Upload Logo', 'terminus')
		),
		"std"	=> 'upload',
		"desc" 	=> esc_html__('Choose type logo text or image', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Text Logo', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "editor",
		"id" 	=> "logo_text",
		"desc" 	=> esc_html__("If you don't have logo image, write Your Text logo. All Logo text settings you can find in Styling Options Section", 'terminus'),
		"required" => array("logo_type", 'text'),
		"std"	=> 'terminus'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Upload Logo', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "upload",
		"id" 	=> "logo_image",
		"desc" 	=> esc_html__('Upload your logo image. Your logo image width must be no more that 166px', 'terminus'),
		"required" => array("logo_type", 'upload'),
		"std"   => get_template_directory_uri() . '/images/logo.png'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Upload Logo for white header style', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "upload",
		"id" 	=> "logo_image_second",
		"desc" 	=> esc_html__('Upload your logo image. Your logo image width must be no more that 166px. This a logo for white header style. Use for header style 6', 'terminus'),
		"required" => array("logo_type", 'upload'),
		"std"   => get_template_directory_uri() . '/images/logo_dark.png'
	);

	/* --------------------------------------------------------- */
	/* Cookie Alert Settings
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Cookie Alert Settings', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "heading",
		"desc" 	=> "",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Cookie Alert?', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "buttons_set",
		"id" 	=> "cookie_alert",
		"options" => array(
			'show'  => esc_html__('Show', 'terminus'),
			'hide' => esc_html__('Hide', 'terminus')
		),
		"std" => 'hide',
		"desc" 	=> esc_html__('Show or hide cookie alert', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Cookie Alert Message', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "textarea",
		"id" 	=> "cookie_alert_message",
		"desc" 	=> esc_html__('Message for cookie alert', 'terminus'),
		"std"   => esc_html__('Please note this website requires cookies in order to function correctly, they do not store any specific information about you personally.', 'terminus')
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Button Read More Link', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "text",
		"id" 	=> "cookie_alert_read_more_link",
		"desc" 	=> esc_html__('Input link for button read more', 'terminus'),
		"std" => 'http://www.cookielaw.org/the-cookie-law'
	);

	/* --------------------------------------------------------- */
	/* Google API
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Google Maps', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "heading",
		"desc" 	=> esc_html__('Google recently changed the way their map service works. New pages which want to use Google Maps need to register an API key for their website. Older pages should  work fine without this API key. If the google map elements of this theme do not work properly you need to register a new API key.', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Google Maps API Key', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "textarea",
		"id" 	=> "gmap_api",
		"desc" 	=> esc_html__('Enter a valid Google Maps API Key to use all map related theme functions.', 'terminus'),
		"std"   => ""
	);

	/* --------------------------------------------------------- */
	/* 404 Page Options
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('404 Page Options', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "heading",
		"desc" 	=> " ",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('404 Content', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "editor",
		"rows"  => 10,
		"id" 	=> "440_content",
		"std"   => "<h3>" . esc_html__('We\'re sorry, but we can\'t find the page you were looking for.', 'terminus') ."</h3>
			<p>" . esc_html__('It\'s probably some thing we\'ve done wrong but now we know about it and we\'ll try to fix it. In the meantime, try one of these options:', 'terminus') . "</p>",
		"desc" 	=> esc_html__("Enter your text for 404 page", 'terminus'),
	);

	/* --------------------------------------------------------- */
	/* Other Options
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Other Theme Options', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "heading",
		"desc" 	=> " ",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show preloader', 'terminus'),
		"slug"	=> 'terminus',
		"type" 	=> "switch_set",
		"id" 	=> "query-loader",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('Show preloader on pages', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Styling Elements
/* ---------------------------------------------------------------------- */

	/* --------------------------------------------------------- */
	/*	Styling Tabs
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('General Styling', 'terminus'),
		"slug"	=> "styling",
		"type" 	=> "heading",
		"desc" 	=> esc_html__('Change the theme style settings', 'terminus'),
	);

	// start tab container
	$terminus_elements[] = array(
		"slug"	=> "styling",
		"type" => "tab_group_start",
		"id" => "styling_tab_container",
		"class" => 'mad-tab-container',
		"desc" => false
	);

		// start 1 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('General', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "styling_tab_1",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('General Background Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-general_body_bg_color",
				"std" 	=> "#f4f4f4",
				"default" 	=> "#f4f4f4",
				"desc" 	=> esc_html__('General background color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('General Background Image', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "select",
				"id" 	=> "styles-bg_img",
				"options" => array(
					'' => esc_html__('No Background Image', 'terminus'),
					'custom' => esc_html__('Upload Image', 'terminus')
				),
				"desc" 	=> esc_html__('The background image of your Body', 'terminus')
			);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Upload Background Image', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "upload",
				"id" 	=> "styles-body_bg_image",
				"desc" 	=> esc_html__('Upload background image of your body', 'terminus'),
				"required" => array("styles-bg_img", 'custom'),
				"std"   => ''
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Repeat', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-body_repeat",
				"options" => array(
					'no-repeat' => esc_html__('No Repeat', 'terminus'),
					'repeat' => esc_html__('Repeat', 'terminus'),
					'repeat-x' => esc_html__('Repeat Horizontally', 'terminus'),
					'repeat-y' => esc_html__('Repeat Vertically', 'terminus')
				),
				"std" => 'no-repeat',
				"required" => array("styles-bg_img", 'custom'),
				"desc" 	=> esc_html__('Select the repeat mode for the background image', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Position', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-body_position",
				"options" => array(
					'top center' => esc_html__('Top center', 'terminus'),
					'top left' => esc_html__('Top left', 'terminus'),
					'top right' => esc_html__('Top right', 'terminus'),
					'bottom left' => esc_html__('Bottom left', 'terminus'),
					'bottom center' => esc_html__('Bottom center', 'terminus'),
					'bottom right' => esc_html__('Bottom right', 'terminus')
				),
				"std" => 'top center',
				"required" => array("styles-bg_img", 'custom'),
				"desc" 	=> esc_html__('Select the position for the background image', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Attachment', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-body_attachment",
				"options" => array(
					'fixed' => esc_html__('Fixed', 'terminus'),
					'scroll' => esc_html__('Scroll', 'terminus')
				),
				"std" => 'yes',
				"required" => array("styles-bg_img", 'custom'),
				"desc" 	=> esc_html__('Select the attachment for the background image', 'terminus'),
			);


			$terminus_elements[] = array(
				"name" 	=> esc_html__('General Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-general_font_color",
				"std" 	=> "#777",
				"default" 	=> "#777",
				"desc" 	=> esc_html__('General font color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__("General Font Size", 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-general_font_size",
				"options" => "range",
				"range" => "12-25",
				"std" => "14px",
				"desc" => esc_html__('General font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('General Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "general_google_webfont",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Sans:400,700",
				"desc" => esc_html__('General font family', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Primary Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-primary_color",
				"std" 	=> "#f76b6b",
				"default" 	=> "#f76b6b",
				"desc" 	=> esc_html__('Key color for links and other elements', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Selection Background Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-highlight_bg_color",
				"std" 	=> "#f76b6b",
				"default" 	=> "#f76b6b",
				"desc" 	=> esc_html__('Highlight and selection background color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Selection Text Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-highlight_text_color",
				"std" 	=> "#fff",
				"default" 	=> "#fff",
				"desc" 	=> esc_html__('Highlight and selection text color', 'terminus'),
			);

		// end 1 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 2 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('Header', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "styling_tab_3",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('Header Sticky Background Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-header_sticky_bg_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Header sticky background color', 'terminus'),
			);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('Header Sticky Background Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-white_header_sticky_bg_color",
				"std" 	=> "#fff",
				"default" 	=> "#fff",
				"desc" 	=> esc_html__('Header sticky background color for header white style (Style 6)', 'terminus'),
			);

		// end 2 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 4 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('Navigation', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "styling_tab_4",
			"class" => "mad_tab",
			"desc" => false
		);

		$terminus_elements[] = array(
			"name" 	=> esc_html__('Text Color Of The First Level Item', 'terminus'),
			"slug"	=> "styling",
			"type" 	=> "color",
			"id" 	=> "styles-first_level_link_color",
			"std" 	=> "#fff",
			"default" 	=> "#fff",
			"desc" 	=> ' '
		);

		$terminus_elements[] = array(
			"name" 	=> esc_html__('Text Color Of The Active First Level Item', 'terminus'),
			"slug"	=> "styling",
			"type" 	=> "color",
			"id" 	=> "styles-first_level_link_color_hover",
			"std" 	=> "#f76b6b",
			"default" 	=> "#f76b6b",
			"desc" 	=> ' '
		);

		$terminus_elements[] = array(
			"name" 	=> esc_html__('Text Color Of The Active Dropdown Menu Item', 'terminus'),
			"slug"	=> "styling",
			"type" 	=> "color",
			"id" 	=> "styles-dropdown_link_color_hover",
			"std" 	=> "#f76b6b",
			"default" 	=> "#f76b6b",
			"desc" 	=> ' '
		);

		$terminus_elements[] = array(
			"name" 	=> esc_html__('Background Color Of The First level Menu Item', 'terminus'),
			"slug"	=> "styling",
			"type" 	=> "color",
			"id" 	=> "styles-bg_color_first_level_mobile_menu",
			"std" 	=> "#f76b6b",
			"default" 	=> "#f76b6b",
			"desc" 	=> esc_html__('For mobile menu', 'terminus')
		);

		$terminus_elements[] = array(
			"name" 	=> esc_html__('Link Color Of The Second level Menu Item', 'terminus'),
			"slug"	=> "styling",
			"type" 	=> "color",
			"id" 	=> "styles-dropdown_link_color_second_level_mobile_menu",
			"std" 	=> "#f76b6b",
			"default" 	=> "#f76b6b",
			"desc" 	=> esc_html__('For mobile menu', 'terminus')
		);

		// end 4 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 5 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('Logo', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "styling_tab_5",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('Logo Text Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-logo_font_color",
				"std" 	=> "#fff",
				"default" => "#fff",
				"desc" => esc_html__('Logo text color', 'terminus'),
			);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('Logo Text Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-logo_font_color_excl",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Logo text color for header style 3, 6, 8, 9', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Logo Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-logo_font_size",
				"options" => "range",
				"range" => "30-65",
				"std" => "40px",
				"desc" => esc_html__('Logo Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Logo Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-logo_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Logo Font Family', 'terminus'),
			);

		// end 5 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 6 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('Footer', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "styling_tab_6",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] =	array(
				"name" 	=> esc_html__('Footer Background Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-footer_bg_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Footer background color', 'terminus'),
			);

		// end 6 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

	// end tab container
	$terminus_elements[] = array(
		"slug"	=> "styling",
		"type" => "tab_group_end",
		"desc" => false
	);

	/* --------------------------------------------------------- */
	/*	All Headings Styling
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('All Headings (H1-H6)', 'terminus'),
		"slug"	=> "styling",
		"type" 	=> "heading",
		"desc" 	=> esc_html__('Change All Headings style settings', 'terminus'),
	);

	// start tab container
	$terminus_elements[] = array(
		"slug"	=> "styling",
		"type" => "tab_group_start",
		"id" => "headings_tab_container",
		"class" => 'mad-tab-container',
		"desc" => false
	);

		// start 1 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H1', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h1_tab_1",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h1_font_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h1_font_size",
				"options" => "range",
				"range" => "30-40",
				"unit" => 'px',
				"std" => "36px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h1_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 1 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 2 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H2', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h2_tab_2",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h2_font_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h2_font_size",
				"options" => "range",
				"range" => "26-36",
				"unit" => 'px',
				"std" => "30px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h2_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 2 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 3 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H3', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h3_tab_3",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h3_font_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h3_font_size",
				"options" => "range",
				"range" => "20-28",
				"unit" => 'px',
				"std" => "24px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h3_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 3 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 4 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H4', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h4_tab_4",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h4_font_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h4_font_size",
				"options" => "range",
				"range" => "16-22",
				"unit" => 'px',
				"std" => "18px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h4_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 4 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 5 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H5', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h5_tab_5",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h5_font_color",
				"std" 	=> "#c6c6c6",
				"default" 	=> "#c6c6c6",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h5_font_size",
				"options" => "range",
				"unit" => 'px',
				"range" => "14-20",
				"std" => "16px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h5_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Sans:400,700",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 5 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

		// start 6 tab
		$terminus_elements[] = array(
			'name'=> esc_html__('H6', 'terminus'),
			"slug"	=> "styling",
			"type" => "tab_group_start",
			"id" => "h6_tab_6",
			"class" => "mad_tab",
			"desc" => false
		);

			$terminus_elements[] = array(
				"name" 	=> esc_html__('Font Color', 'terminus'),
				"slug"	=> "styling",
				"type" 	=> "color",
				"id" 	=> "styles-h6_font_color",
				"std" 	=> "#333",
				"default" 	=> "#333",
				"desc" 	=> esc_html__('Heading Color', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Size', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h6_font_size",
				"options" => "range",
				"range" => "12-18",
				"unit" => 'px',
				"std" => "14px",
				"desc" => esc_html__('Font size', 'terminus'),
			);

			$terminus_elements[] = array(
				"name" => esc_html__('Font Family', 'terminus'),
				"slug" => "styling",
				"type" => "select",
				"id" => "styles-h6_font_family",
				"options" => $terminus_google_webfonts,
				"std" => "Droid Serif:400,700,400italic,700italic",
				"desc" => esc_html__('Choose Font Family', 'terminus'),
			);

		// end 6 tab
		$terminus_elements[] = array(
			"slug"	=> "styling",
			"type" => "tab_group_end",
			"desc" => false
		);

	// end tab container
	$terminus_elements[] = array(
		"slug"	=> "styling",
		"type" => "tab_group_end",
		"desc" => false
	);

	/* --------------------------------------------------------- */
	/*	Custom Quick CSS
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Custom Quick CSS', 'terminus'),
		"slug"	=> "styling",
		"type" 	=> "textarea",
		"id" 	=> "custom_quick_css",
		"desc" 	=> esc_html__('Here you can make some quick changes in CSS', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Header Elements
/* ---------------------------------------------------------------------- */

	$terminus_header_type = terminus_options_header_types();

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Header Type', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "image_select",
		"id" 	=> "header-type",
		"options" => $terminus_header_type,
		"std" => 1,
		"desc" 	=> esc_html__(' ', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_1",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 1 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 1', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_2",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 2 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 2', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_3",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 3 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 3', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_4",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 4 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 4', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_5",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 5 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 5', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_6",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 6 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 6', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_7",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 7 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 7', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_8",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 8 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 8', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sticky Navigation', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "switch_set",
		"id" 	=> "sticky_navigation_type_11",
		"options" => array(
			'on'  => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"required" => array( "header-type", 11 ),
		"desc" 	=> esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information. For header type 8', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Special Message', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_special_message_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Language', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_language_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Currency', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_currency_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Call Us', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_call_us_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Wishlist', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_wishlist_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Compare', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_compare_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Cart', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_cart_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Search', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_search_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_2",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 2 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Feedback phone number', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "number",
		"id" 	=> "call_us_type_2",
		"std"	=> "",
		"required" => array( "header-type", 2 ),
		"desc" 	=> esc_html__('Enter your phone number for feedback', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Call Us', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_call_us_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Language', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_language_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Currency', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_currency_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Search', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_search_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Cart', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_cart_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_4",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 4 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Feedback phone number', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "number",
		"id" 	=> "call_us_type_4",
		"std"	=> "",
		"required" => array( "header-type", 4 ),
		"desc" 	=> esc_html__('Enter your phone number for feedback', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Social Links', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_social_links_type_5",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 5 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Search', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_search_type_5",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 5 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_5",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 5 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Email', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "email_us_type_6",
		"desc" 	=> esc_html__("Enter Email", 'terminus'),
		"required" => array( "header-type", 6 ),
		"std" => ""
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Feedback phone number', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "number",
		"id" 	=> "call_us_type_6",
		"std"	=> "",
		"required" => array( "header-type", 6 ),
		"desc" 	=> esc_html__('Enter your phone number for feedback', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Call Us', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_call_us_type_6",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 6 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Email', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_email_type_6",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 6 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Social Links', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_social_links_type_6",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 6 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Search', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_search_type_6",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 6 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_6",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 6 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_7",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 7 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Cart', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_cart_type_8",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 8 ),
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show button for Widget Area', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_btn_float_aside_type_8",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 8 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Social Links', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_social_links_type_9",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 9 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Social Links', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "show_social_links_type_10",
		"desc" 	=> " ",
		"label" => esc_html__('If checked show', 'terminus'),
		"required" => array( "header-type", 10 ),
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Facebook Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "facebook_link",
		"desc" 	=> " ",
		"std" => "http://www.facebook.com",
		"class" => 'mad_2col'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Twitter Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "twitter_link",
		"desc" 	=> " ",
		"std" => "https://twitter.com",
		"class" => 'mad_2col',
		"clear" => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Google Plus Link ', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "gplus_link",
		"desc" 	=> " ",
		"std" => "https://plus.google.com/",
		"class" => 'mad_2col'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('RSS Link ', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "rss_link",
		"desc" 	=> " ",
		"std" => "",
		"class" => 'mad_2col',
		"clear" => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Pinterest Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "pinterest_link",
		"desc" 	=> " ",
		"std" => "https://www.pinterest.com/",
		"class" => 'mad_2col'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Instagram Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "instagram_link",
		"desc" 	=> " ",
		"std" => "https://instagram.com",
		"class" => 'mad_2col',
		'clear' => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Vimeo Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "vimeo_link",
		"desc" 	=> " ",
		"std" => "https://vimeo.com",
		"class" => 'mad_2col'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Youtube Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "youtube_link",
		"desc" 	=> " ",
		"std" => "https://youtube.com",
		"class" => 'mad_2col',
		'clear' => 'both'
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Flickr Link', 'terminus'),
		"slug"	=> "header",
		"type" 	=> "text",
		"id" 	=> "flickr_link",
		"desc" 	=> " ",
		"std" => "https://flickr.com",
		"class" => 'mad_2col'
	);

//	$terminus_elements[] = array(
//		"name" 	=> esc_html__('Header top banner', 'terminus'),
//		"slug"	=> 'header',
//		"type" 	=> "editor",
//		"id" 	=> "header_banner_text",
//		"desc" 	=> esc_html__("Header top banner ( for header Style 2 )", 'terminus'),
//		"std"	=> ''
//	);

/* ---------------------------------------------------------------------- */
/*	Page Title Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Mono Color', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "color",
		"id" 	=> "page_title_mono_color",
		"std" 	=> "",
		"default" 	=> "",
		"desc" 	=> esc_html__('Background mono color for the header page title', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Breadcrumb Navigation', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "buttons_set",
		"id" 	=> "page_title_breadcrumb",
		"options" => array(
			'display' => esc_html__('Display', 'terminus'),
			'hide' => esc_html__('Hide', 'terminus')
		),
		"std" => 'display',
		"desc" 	=> esc_html__('Display the breadcrumb navigation?', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Upload Background Image', 'terminus'),
		"slug"	=> 'page-title',
		"type" 	=> "upload",
		"id" 	=> "page_title_upload",
		"desc" 	=> esc_html__('Background Image for the header page title', 'terminus'),
		"std"   => ''
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Parallax', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "checkbox",
		"std"   => 0,
		"id" 	=> "page_title_parallax",
		"label" => esc_html__('Add parallax type background', 'terminus'),
		"desc" 	=> " "
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Zoom Out Effect', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "checkbox",
		"std"   => 0,
		"id" 	=> "page_title_zoom_out",
		"label" => esc_html__('Add zoom out effect on background image', 'terminus'),
		"desc" 	=> " "
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Gradient Effect', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "checkbox",
		"std"   => 0,
		"id" 	=> "page_title_gradient_effect",
		"label" => esc_html__('Add gradient effect on background image', 'terminus'),
		"desc" 	=> " "
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Uncovering Effect', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "checkbox",
		"std"   => 0,
		"id" 	=> "page_title_uncovering_effect",
		"label" => esc_html__('Add uncovering effect effect on background image', 'terminus'),
		"desc" 	=> " "
	);

	$terminus_elements[] =	array(
		"name" 	=> esc_html__('Video URL (mp4)', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "text",
		"id" 	=> "page_title_video",
		"std"   => '',
		"desc" 	=> esc_html__('Add video on background.', 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Animation Title', 'terminus'),
		"slug"	=> "page-title",
		"type" 	=> "select",
		"id" 	=> "page_title_animation",
		"options" => array(
			'' => esc_html__('None', 'terminus'),
			'bounceInLeft' => 'bounceInLeft',
			'bounceInRight' => 'bounceInRight',
			'bounceInDown' => 'bounceInDown',
			'bounceIn' => 'bounceIn',
			'bounceInUp' => 'bounceInUp',
			'fadeIn' => 'fadeIn',
			'fadeInDown' => 'fadeInDown',
			'fadeInLeft' => 'fadeInLeft',
			'fadeInRight' => 'fadeInRight'
		),
		"std" => '',
		"desc" => esc_html__('Select type of animation if you want this title to be animated when it enters into the browsers viewport.', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Page Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Breadcrumbs on page', 'terminus'),
		"slug"	=> "page",
		"type" 	=> "switch_set",
		"id" 	=> "page_breadcrumbs",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('Show or hide breadcrumbs by default on page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Breadcrumbs on single page', 'terminus'),
		"slug"	=> "page",
		"type" 	=> "switch_set",
		"id" 	=> "single_breadcrumbs",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('Show or hide breadcrumbs by default on single page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar Setting', 'terminus'),
		"slug"	=> "page",
		"type" 	=> "select",
		"id" 	=> "sidebar_setting_page",
		"options" => 'custom_sidebars',
		'std' => '',
		"desc" 	=> esc_html__('Choose the page sidebar setting', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Animation on Pages', 'terminus'),
		"slug"	=> "page",
		"type" 	=> "switch_set",
		"id" 	=> "animation",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus'),
		),
		"std" => true,
		"desc" 	=> esc_html__('Choose yes for shortcodes animation', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Sidebar Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar Settings', 'terminus'),
		"slug"	=> "sidebar",
		"type" 	=> "heading",
		"heading" => "h4",
		"desc" 	=> esc_html__('Parameters for sidebar', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar on Pages', 'terminus'),
		"slug"	=> "sidebar",
		"type" 	=> "buttons_set",
		"id" 	=> "sidebar_page_position",
		"options" => array(
			'sbl' => esc_html__('Left', 'terminus'),
			'sbr' => esc_html__('Right', 'terminus'),
			'no_sidebar' => esc_html__('No Sidebar', 'terminus')
		),
		"std" => 'sbr',
		"desc" 	=> esc_html__('Choose the default page sidebar position', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar on Single Post Pages', 'terminus'),
		"slug"	=> "sidebar",
		"type" 	=> "buttons_set",
		"id" 	=> "sidebar_post_position",
		"options" => array(
			'sbl' => esc_html__('Left', 'terminus'),
			'sbr' => esc_html__('Right', 'terminus'),
			'no_sidebar' => esc_html__('No Sidebar', 'terminus')
		),
		"std" => 'sbr',
		"desc" 	=> esc_html__('Choose the blog post sidebar position', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar on Archive Pages', 'terminus'),
		"slug"	=> "sidebar",
		"type" 	=> "buttons_set",
		"id" 	=> "sidebar_archive_position",
		"options" => array(
			'sbl' => esc_html__('Left', 'terminus'),
			'sbr' => esc_html__('Right', 'terminus'),
			'no_sidebar' => esc_html__('No Sidebar', 'terminus')
		),
		"std" => 'sbr',
		"desc" 	=> esc_html__('Choose the archive sidebar position', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Blog Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Post List Settings', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "heading",
		"heading" => "h4",
		"desc" 	=> esc_html__('Parameters for posts list on blog page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Excerpt count', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "number",
		"id" 	=> "excerpt_count_blog",
		"min" => 50,
		"max" => 500,
		"std"   => 130,
		"desc" 	=> esc_html__('Excerpt count ( min-50, max-500 symbols)', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Excerpt count blog big', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "number",
		"id" 	=> "excerpt_count_blog_big",
		"min" => 50,
		"max" => 800,
		"std"   => 450,
		"desc" 	=> esc_html__('Excerpt count ( min-50, max-800 symbols)', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Excerpt count blog small', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "number",
		"id" 	=> "excerpt_count_blog_small",
		"min" => 50,
		"max" => 500,
		"std"   => 250,
		"desc" 	=> esc_html__('Excerpt count ( min-50, max-500 symbols)', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Excerpt count blog grid and masonry', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "number",
		"id" 	=> "excerpt_count_blog_grid",
		"min" => 50,
		"max" => 800,
		"std"   => 250,
		"desc" 	=> esc_html__('Excerpt count ( min-50, max-800 symbols)', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Date', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-listing-meta-date",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Comment', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-listing-meta-comment",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Category', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-listing-meta-category",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col',
		"clear" => 'both'
	);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Single Post Settings', 'terminus'),
	"slug"	=> "blog",
	"type" 	=> "heading",
	"heading" => "h4",
	"desc" 	=> esc_html__('Parameters for standart elements on Post page', 'terminus'),
);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Date', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-meta-date",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Comment', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-meta-comment",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Category', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-meta-category",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Tags', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-meta-tags",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Tags and Share', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-tags-and-share",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Post Author', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-meta-author",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Related Posts', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-related-posts",
		"label" => esc_html__('If checked show', 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__("Link Pages", 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "checkbox",
		"std"   => 1,
		"id" 	=> "blog-single-link-pages",
		"label" => esc_html__("If checked show", 'terminus'),
		"desc" 	=> " ",
		"class" => 'mad_3col',
		"clear" => 'both'
	);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Related Posts Settings', 'terminus'),
	"slug"	=> "blog",
	"type" 	=> "heading",
	"heading" => "h4",
	"desc" 	=> esc_html__('Parameters for related posts on Post single page', 'terminus')
);

	$terminus_elements[] = array(
		"name" 	=> esc_html__("Post's Count", 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "buttons_set",
		"id" 	=> "related_posts_count",
		"options" => array(
			3 => 3,
			6 => 6,
			9 => 9
		),
		"std" => 3,
		"desc" 	=> esc_html__('Show to display count items', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Archive Posts Settings', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "heading",
		"heading" => "h4",
		"desc" 	=> esc_html__('Parameters for posts on archive page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Style for archive', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "buttons_set",
		"id" 	=> "blog_style",
		"options" => array(
			'blog-big-thumbs' => esc_html__('Big Thumbs', 'terminus'),
			'blog-small-thumbs' => esc_html__('Small Thumbs', 'terminus'),
			'blog-grid' => esc_html__('Grid', 'terminus'),
			'blog-masonry' => esc_html__('Masonry', 'terminus')
		),
		"std" => 'blog-big-thumbs',
		"desc" 	=> esc_html__('Choose the default blog style here for archive', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Style for search', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "buttons_set",
		"id" 	=> "blog_style_search",
		"options" => array(
			'blog-big-thumbs' => esc_html__('Big Thumbs', 'terminus'),
			'blog-small-thumbs' => esc_html__('Small Thumbs', 'terminus'),
			'blog-grid' => esc_html__('Grid', 'terminus'),
			'blog-masonry' => esc_html__('Masonry', 'terminus')
		),
		"std" => 'blog-big-thumbs',
		"desc" 	=> esc_html__('Choose the default blog style here for archive', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Blog Columns', 'terminus'),
		"slug"	=> "blog",
		"type" 	=> "buttons_set",
		"id" 	=> "blog_columns",
		"options" => array(
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6
		),
		"std" => 2,
		"desc" 	=> esc_html__('How many columns should be displayed?', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Portfolio Elements
/* ---------------------------------------------------------------------- */

/* --------------------------------------------------------- */
/*	Portfolio item Settings
/* --------------------------------------------------------- */

$terminus_elements[] = array(
	"name" 	=> esc_html__('Portfolio item Settings', 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "heading",
	"heading" => "h4",
	"desc" 	=> esc_html__('Parameters for portfolio item', 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Categories', 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "checkbox",
	"std"   => 1,
	"id" 	=> "show-portfolio-categories",
	"label" => esc_html__('If checked show', 'terminus'),
	"desc" 	=> " ",
	"class" => 'mad_3col',
	"clear" => 'both'
);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Excerpt count for portfolio', 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "number",
	"id" 	=> "excerpt_count_portfolio",
	"min" => 50,
	"max" => 500,
	"std"   => 150,
	"desc" 	=> esc_html__('Excerpt count ( min-50, max-500 symbols)', 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__("Sidebar on Archive page", 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "sidebar_portfolio_archive_position",
	"options" => array(
		'sbl' => esc_html__('Left', 'terminus'),
		'sbr' => esc_html__('Right', 'terminus'),
		'no_sidebar' => esc_html__('No Sidebar', 'terminus')
	),
	"std" => 'no_sidebar',
	"desc" 	=> esc_html__("Choose the portfolio archive sidebar position", 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__('Layout on Archive page', 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "layout_portfolio",
	"options" => array(
		'grid' => esc_html__('Grid', 'terminus'),
		'grid-classic' => esc_html__('Classic', 'terminus')
	),
	"std" => 'grid-classic',
	"desc" 	=> esc_html__('Layout be displayed?', 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__("Columns on Archive page", 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "portfolio_archive_column_count",
	"options" => array(
		2 => 2,
		3 => 3,
		4 => 4
	),
	"std" => 3,
	"desc" 	=> esc_html__("This controls how many columns should be appeared on the portfolio archive page", 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__("Spacing between items", 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "portfolio_spacing",
	"options" => array(
		'with_spacing' => esc_html__('With Spacing', 'terminus'),
		'without_spacing' => esc_html__('Without Spacing', 'terminus')
	),
	"std" => 'with_spacing',
	"desc" 	=> esc_html__("Select spacing mode", 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__("With or without actions", 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "portfolio_actions",
	"options" => array(
		'with_actions' => esc_html__('With Actions', 'terminus'),
		'without_actions' => esc_html__('Without Actions', 'terminus')
	),
	"std" => 'with_actions',
	"desc" 	=> esc_html__("Select with or without actions", 'terminus'),
);

/* --------------------------------------------------------- */
/*	Portfolio Single Settings
/* --------------------------------------------------------- */

$terminus_elements[] = array(
	"name" 	=> esc_html__('Portfolio single Settings', 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "heading",
	"heading" => "h4",
	"desc" 	=> esc_html__('Parameters for portfolio single', 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=> esc_html__("Post Meta Position", 'terminus'),
	"slug"	=> "portfolio",
	"type" 	=> "buttons_set",
	"id" 	=> "portfolio_position_post_meta",
	"options" => array(
		'top' => esc_html__('Top', 'terminus'),
		'bottom' => esc_html__('Bottom', 'terminus'),
		'sbl' => esc_html__('Left', 'terminus'),
		'sbr' => esc_html__('Right', 'terminus')
	),
	"std" => 'sbr',
	"desc" 	=> esc_html__("Choose portfolio meta post position", 'terminus'),
);

/* ---------------------------------------------------------------------- */
/*	Testimonials Elements
/* ---------------------------------------------------------------------- */

$terminus_elements[] = array(
	"name" 	=> esc_html__('Breadcrumbs on single page', 'terminus'),
	"slug"	=> "testimonials",
	"type" 	=> "switch_set",
	"id" 	=> "single_testimonials_breadcrumbs",
	"options" => array(
		'on' => esc_html__('Yes', 'terminus'),
		'off' => esc_html__('No', 'terminus')
	),
	"std" => true,
	"desc" 	=> esc_html__('Show or hide breadcrumbs by default on single page', 'terminus'),
);

$terminus_elements[] = array(
	"name" 	=>  esc_html__('Excerpt count countent in shortcode', 'terminus'),
	"slug"	=> "testimonials",
	"type" 	=> "number",
	"id" 	=> "excerpt_count_testimonials_content",
	"min" => 10,
	"max" => 1000,
	"std"   => 200,
	"desc" 	=> esc_html__('Excerpt count ( min-10, max-1000 symbols)', 'terminus'),
);

/* ---------------------------------------------------------------------- */
/*	Team Members Elements
/* ---------------------------------------------------------------------- */

$terminus_elements[] = array(
	"name" 	=> esc_html__('Breadcrumbs on single page', 'terminus'),
	"slug"	=> "team-members",
	"type" 	=> "switch_set",
	"id" 	=> "single_team_members_breadcrumbs",
	"options" => array(
		'on' => esc_html__('Yes', 'terminus'),
		'off' => esc_html__('No', 'terminus')
	),
	"std" => true,
	"desc" 	=> esc_html__('Show or hide breadcrumbs by default on single page', 'terminus'),
);

/* ---------------------------------------------------------------------- */
/*	Footer Elements
/* ---------------------------------------------------------------------- */

	/* --------------------------------------------------------- */
	/* Row Widgets for pages
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" => esc_html__('Show Footer Row Top widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 0,
		"id" => "show_row_top_widgets",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Full width Row Top widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 1,
		"id" => "row_top_full_width",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Footer Row Top Widget positions', 'terminus'),
		"slug"	=> "footer",
		"type" => "widget_positions",
		"std" => '{"5":[["6","3","3","6","6"]]}',
		"id" => "footer_row_top_columns_variations",
		"desc" => esc_html__('Here you can select how your footer row top widgets will be displayed.', 'terminus'),
		"columns" => 5,
		"selectname" => 'get_sidebars_top_widgets'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Show Footer Row Middle widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 1,
		"id" => "show_row_middle_widgets",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Full width Row Middle widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 1,
		"id" => "row_middle_full_width",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Footer Row Middle Widget positions', 'terminus'),
		"slug"	=> "footer",
		"type" => "widget_positions",
		"std" => '{"5":[["6","3","3","6","6"]]}',
		"id" => "footer_row_middle_columns_variations",
		"desc" => esc_html__('Here you can select how your footer row middle widgets will be displayed.', 'terminus'),
		"columns" => 5,
		"selectname" => 'get_sidebars_middle_widgets'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Show Footer Row Bottom widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 0,
		"id" => "show_row_bottom_widgets",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Full width Row Bottom widgets ?', 'terminus'),
		"slug"	=> "footer",
		"type" => "checkbox",
		"std" => 1,
		"id" => "row_bottom_full_width",
		"desc" => " ",
		"label" => esc_html__('Show it if the checkbox is checked', 'terminus'),
		"class" => 'mad_2col',
		"clear" => 'both'
	);

	$terminus_elements[] = array(
		"name" => esc_html__('Footer Row Bottom Widget positions', 'terminus'),
		"slug"	=> "footer",
		"type" => "widget_positions",
		"std" => '{"5":[["6","3","3","6","6"]]}',
		"id" => "footer_row_bottom_columns_variations",
		"desc" => esc_html__('Here you can select how your footer row bottom widgets will be displayed.', 'terminus'),
		"columns" => 5,
		"selectname" => 'get_sidebars_bottom_widgets'
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Copyright', 'terminus'),
		"slug"	=> "footer",
		"type" 	=> "textarea",
		"id" 	=> "copyright",
		"std"   => '',
		"desc" 	=> esc_html__('Write your copyright text for the footer', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Shop Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('General Shop Settings', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "heading",
		"heading" => 'h4',
		"desc" 	=> esc_html__('General parameters for the shop', 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Breadcrumbs on Shop Pages', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "shop_breadcrumbs",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('Show or hide breadcrumbs by default on shop page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar on Archive Pages', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "buttons_set",
		"id" 	=> "sidebar_product_archive_position",
		"options" => array(
			'sbl' => esc_html__('Left', 'terminus'),
			'sbr' => esc_html__('Right', 'terminus'),
			'no_sidebar' => esc_html__('No Sidebar', 'terminus')
		),
		"std" => 'sbr',
		"desc" 	=> esc_html__('Choose the sidebar position for product archive', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sidebar Setting', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "select",
		"id" 	=> "sidebar_setting_product",
		"options" => 'custom_sidebars',
		'std' => 'Shop',
		"desc" 	=> esc_html__('Choose the product pages sidebar setting', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Shop View', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "buttons_set",
		"id" 	=> "shop-view",
		"options" => array(
			'view-grid' => esc_html__('Grid View', 'terminus'),
			'view-list' => esc_html__('List View', 'terminus')
		),
		"std" => 'view-grid',
		"desc" 	=> esc_html__('Choose shop view layout - grid or list', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Shop Layout', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "buttons_set",
		"id" 	=> "shop-layout",
		"options" => array(
			'type_1' => esc_html__('Layout 1', 'terminus'),
			'type_2' => esc_html__('Layout 2', 'terminus')
		),
		"std" => 'type_1',
		"desc" 	=> esc_html__('Choose default layout view for the Grid view Shop page', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Enable Image Hover Effect', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "widget-image-hover",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('Enable Image Hover Effect for products list widget', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Product Item Settings', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "heading",
		"heading" => 'h4',
		"desc" 	=> esc_html__('Parameters for product item', 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=>  esc_html__('Excerpt count product title', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "number",
		"id" 	=> "excerpt_count_product_title",
		"min" => 10,
		"max" => 300,
		"std"   => 100,
		"desc" 	=> esc_html__('Excerpt count ( min-10, max-300 symbols)', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show "Sale" Label', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "product_sale",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> " ",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show saved sale price percentage', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "product_sale_percent",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> " ",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show "Featured" Label', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "product_featured",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> " ",
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__("Quick View", 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "quick_view",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__("If you choose Yes, you will see quick view on the product box", 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Compare', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "show_compare_list",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__("If you choose Yes, you will see compare on the product box", 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Wishlist', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "show_wishlist_list",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__("If you choose Yes, you will see wishlist on the product box", 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__("Product Thumbs", 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "product_thumbs",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__("If you choose Yes, you will see product thumbs on the product box", 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Single Product Settings', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "heading",
		"heading" => 'h4',
		"desc" 	=> esc_html__('Parameters for single product', 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Lightbox', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "lightbox_on_product_image",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('If you choose Yes, you will see lightbox in the product image on single product', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Zoom', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "zoom_on_product_image",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('If you choose Yes, you will see zoom in the product image on single product', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Show Review Tab', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "switch_set",
		"id" 	=> "show_review_tab",
		"options" => array(
			'on' => esc_html__('Yes', 'terminus'),
			'off' => esc_html__('No', 'terminus')
		),
		"std" => true,
		"desc" 	=> esc_html__('If you choose Yes, you will see reviews tab on single product', 'terminus'),
	);

	$itemcount = array();
	for ($i = 3; $i < 51; $i++) {
		$itemcount[$i] = $i;
	}

	/* --------------------------------------------------------- */
	/*	Wishlist and Compare Plugin Settings
	/* --------------------------------------------------------- */

//	$terminus_elements[] = array(
//		"name" 	=> esc_html__('Wishlist and Compare', 'terminus'),
//		"slug"	=> "shop",
//		"type" 	=> "heading",
//		"heading" => 'h4',
//		"desc" 	=> esc_html__('Parameters for wishlist and compare', 'terminus')
//	);

	/* --------------------------------------------------------- */
	/*	Column and Product Settings
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Column and Product Count', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "heading",
		"heading" => 'h4',
		"desc" 	=> esc_html__('The following settings allow you to choose how many columns and items should be appeared on your default shop overview page and on your product archive pages.', 'terminus')
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Column Count', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "select",
		"id" 	=> "woocommerce_column_count",
		"options" => array(
			3 => 3,
			4 => 4
		),
		"std" => 3,
		"desc" 	=> esc_html__('This controls how many columns should be appeared on overview pages.', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Product Count', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "select",
		"id" 	=> "woocommerce_product_count",
		"options" => $itemcount,
		"std" => 12,
		"desc" 	=> esc_html__('This controls how many products should be appeared on overview pages.', 'terminus'),
	);

	/* --------------------------------------------------------- */
	/*	Row Widgets for shop pages
	/* --------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Footer Settings', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "heading",
		"heading" => "h4",
		"desc" 	=> esc_html__('Editor widgets in the footer for shop pages', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Get widgets for footer from page', 'terminus'),
		"slug"	=> "shop",
		"type" 	=> "select",
		"id" 	=> "shop_get_widgets_page_id",
		"options" => 'page',
		"desc" 	=> esc_html__('Get widgets for footer from page on shop pages. You can model the footer of any page and then use it to the product pages', 'terminus'),
	);

/* ---------------------------------------------------------------------- */
/*	Sitemap Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Sitemap Settings', 'terminus'),
		"slug"	=> "sitemap",
		"type" 	=> "heading",
		"desc" 	=> esc_html__('You can use any of the following shortcodes in the content of your pages (or posts) to display a dynamic sitemap.', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Shortcodes', 'terminus'),
		"slug"	=> "sitemap",
		"desc"  => " ",
		"type" 	=> "sitemap"
	);

/* ---------------------------------------------------------------------- */
/*	Import Elements
/* ---------------------------------------------------------------------- */

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Import demo files', 'terminus'),
		"slug"	=> "import",
		"type" 	=> "heading",
		"desc" 	=> esc_html__('If you are WordPress newbie or want to get the theme look like one of our demos, then you can make import dummy posts and pages here. It will help you to understand how everything is organized.', 'terminus'),
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Import Default Content', 'terminus'),
		"slug"	=> "import",
		"desc" 	=> wp_kses(__("<p>
			<strong>View demo:</strong>
			<a target='_blank' href='http://velikorodnov.com/wordpress/terminus/'>View Demo Online</a>
			</p> You can import default content dummy posts and pages here
			<strong>Before Import Data install you must install and activate the following plugins: </strong>
			<ul>
				<li>Terminus Content Types</li>
				<li>WPBakery Visual Composer</li>
				<li>LayerSlider WP</li>
				<li>Revolution Slider</li>
				<li>Mega Main Menu</li>
				<li>WPML Multilingual CMS</li>
				<li><a target='_blank' href='https://wordpress.org/plugins/woocommerce/'>Woocommerce</a></li>
				<li><a target='_blank' href='https://wordpress.org/plugins/yith-woocommerce-compare/'>YITH WooCommerce Compare</a></li>
				<li><a target='_blank' href='https://wordpress.org/plugins/yith-woocommerce-wishlist/'>YITH WooCommerce Wishlist</a></li>
				<li><a target='_blank' href='https://wordpress.org/plugins/contact-form-7/'>Contact Form 7</a></li>
			</ul>", 'terminus'), array('p' => array(), 'strong' => array(), 'a' => array('href' => array(), 'target' => array()), 'strong' => array(), 'ul' => array(), 'li' => array(), 'br' => array())),
		"id" 	=> "import_default",
		"type" 	=> "import",
		"path" => "admin/demo/default/default",
		"source" => "admin/demo/default",
		"image" => "admin/demo/default/default.jpg"
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Export Theme Settings', 'terminus'),
		"slug"	=> "import",
		"desc" 	=> esc_html__('Export a theme configuration file here.', 'terminus'),
		"id" 	=> "export_config_file",
		"type" 	=> "export_config_file"
	);

	$terminus_elements[] = array(
		"name" 	=> esc_html__('Import Theme Settings', 'terminus'),
		"slug"	=> "import",
		"desc" 	=> esc_html__('Upload a theme configuration file here.', 'terminus'),
		"id" 	=> "import_config_file",
		"type" 	=> "import_config_file"
	);