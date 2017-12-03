<?php

/* General */
/*---------------------------------*/

$output = "";

$output .= "

	::selection {
		background-color: $highlight_bg_color;
		color: $highlight_text_color;
	}

	::-moz-selection {
		background-color: $highlight_bg_color;
		color: $highlight_text_color;
	}

	mark, ins {
		background-color: $highlight_bg_color;
		color: $highlight_text_color;
	}

	body {
		color: $general_font_color;
	}

	body,
	.infoblock .infoblock-item,
	.team_member,
	.project,
	.pricing-box .pricing_table,
	.comment-form .comment-form-author,
	.comment-form .comment-form-email,
	.comment-form .comment-form-rating,
	.comment-form .comment-form-comment,
	.logged-in-as
	 {
		font-size: $general_font_size;
	}

	body { background: $body_bg; }

";

/* Header */
/*---------------------------------*/

$output .= "

	#header:not(.white_style) .sticky_enabled,
	#header.transparent_type:not(.white_style) .sticky_enabled
	{
		background-color: $header_sticky_bg_color;
	}

	#header.white_style
	{
		background-color: $white_header_sticky_bg_color;
	}

";

/* Logo */
/*---------------------------------*/

$output .= "

	#header h1.logo {
		font-size: $logo_font_size;
	}

		#header h1.logo a {
			color: $logo_font_color;
		}

		#header.style_3 h1.logo a,
		#header.style_6.white_style h1.logo a,
		#header.style_8.white_style h1.logo a,
		#header.style_9.white_style h1.logo a { color: $logo_font_color_excl; }

";

/* Footer */
/*---------------------------------*/

$output .= "

	#footer { background-color: $footer_bg_color; }

";

/* Headings */
/*---------------------------------*/

$output .= "
	h1 {
		color: $h1_font_color;
		font-size: $h1_font_size;
	}
	h2 {
		color: $h2_font_color;
		font-size: $h2_font_size;
	}
	h3 {
		color: $h3_font_color;
		font-size: $h3_font_size;
	}
	h4 {
		color: $h4_font_color;
		font-size: $h4_font_size;
	}
	h5 {
		color: $h5_font_color;
		font-size: $h5_font_size;
	}
	h6 {
		color: $h6_font_color;
		font-size: $h6_font_size;
	}
";

/* Primary Color */
/*---------------------------------*/

$output .= "

	a:hover,
	a:active,
	a:focus,
	tfoot th,
	tfoot td,
	blockquote,
	.cta_title,
	.mono_color_col,
	.caption_404,
	.slide-price,
	.project_item a:hover,
	.slide-caption-red,
	.blockquote.type_3,
	.post-quote blockquote,
	.post-quote blockquote::before,
	.post-quote blockquote::after,
	.link_container .si-icon.si-icon-link,
	.contact_info i[class|=icon],
	.introduce_text_box a,
	.footer_section a:hover,
	.footer_section a:active,
	.link_container .si-icon.si-icon-link,
	.entries_slider .byline a:hover,
	.entries_slider .entry_title a:hover,
	.vc_row-has-fill .breadcrumbs a:hover,
	.page_title.media_type .breadcrumbs a:hover
	.tabs_nav.services_nav .owl-item a.active span,
	.infoblock .infoblock-item.type_2 .icon_box .box_title,
	.infoblock .infoblock-item.type_4 .icon_box:hover .si-icon,
	.side_header #header.transparent_type .social_links.type_2 li:hover > a
	{
		color: $primary_color;
	}

	mark,
	.sticky-post,
	#advanced-menu-hide,
	.pricing-box .pricing_table.labeled::before,
	.infoblock .infoblock-item.type_2 .icon_box:hover,
	.infoblock .infoblock-item.type_5 .icon_box .back_side,
	.entry .mejs-controls .mejs-time-rail .mejs-time-current,
	.entry .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current
	{
		background-color: $primary_color;
	}

	.blockquote.type_2,
	.testimonials.type_3 .testimonial,
	.pricing-box .pricing_table.labeled,
	.pricing-box .pricing_table.labeled header,
	.pricing-box .pricing_table.labeled footer,
	.infoblock .infoblock-item.type_4 .icon_box:hover .si-icon
	{
		border-color: $primary_color;
	}

	.infoblock.steps .infoblock-item .front_side::before,
	.infoblock.steps .infoblock-item .back_side::before
	{
		border-left-color: $primary_color;
	}

";

/* Navigation Color */
/*---------------------------------*/

$output .= "

	@media only screen and (min-width: 993px) {
		.navigation a, .sticky_enabled .navigation.one_page a,
		.side_header #header.transparent_type .vertical_navigation a,
		.side_header #header.transparent_type .social_links a,
		.transparent_type .vertical_navigation #mega_main_menu li .post_details > .post_icon > i,
		.transparent_type .vertical_navigation #mega_main_menu li .mega_dropdown .item_link *,
		.transparent_type .vertical_navigation #mega_main_menu li .mega_dropdown a,
		.transparent_type .vertical_navigation #mega_main_menu li .mega_dropdown a *,
		.transparent_type .vertical_navigation #mega_main_menu li li .post_details a,
		.transparent_type .vertical_navigation #mega_main_menu li.default_dropdown .mega_dropdown > li > .item_link,
		.transparent_type .vertical_navigation #mega_main_menu li.widgets_dropdown .mega_dropdown > li > .item_link,
		.transparent_type .vertical_navigation #mega_main_menu li.multicolumn_dropdown .mega_dropdown > li > .item_link,
		.transparent_type .vertical_navigation #mega_main_menu li.grid_dropdown .mega_dropdown > li > .item_link {
			color: $first_level_link_color;
		}
	}

	.vertical_navigation #mega_main_menu > .menu_holder > .menu_inner > ul > li.t_active > .item_link,
	.vertical_navigation #mega_main_menu > .menu_holder > .menu_inner > ul > li.t_active > .item_link *,
	.vertical_navigation #mega_main_menu li.multicolumn_dropdown .mega_dropdown > li.t_active > .item_link,
	.nav_wrap .navigation > li:hover > a,
	.nav_wrap .navigation > li.current-menu-item > a,
	.nav_wrap .navigation > li.current-menu-parent > a,
	.nav_wrap .navigation > li.current-menu-ancestor > a,
	.nav_wrap .navigation > li.current_page_item > a,
	.nav_wrap .navigation > li.current_page_parent > a,
	.nav_wrap .navigation > li.current_page_ancestor > a,
	.sticky_enabled .navigation.one_page li:hover > a,
	.sticky_enabled .navigation.one_page li.current > a,
	.vertical_navigation li:hover > a,
	.vertical_navigation li.current-menu-item > a,
	.vertical_navigation li.current-menu-parent > a,
	.vertical_navigation li.current-menu-ancestor > a,
	.vertical_navigation li.current_page_item > a,
	.vertical_navigation li.current_page_parent > a,
	.vertical_navigation li.current_page_ancestor > a,
	.white_style .navigation > li:hover > a,
	.white_style .navigation > li.current-menu-item > a,
	.white_style .navigation > li.current-menu-parent > a,
	.white_style .navigation > li.current-menu-ancestor > a,
	.white_style .navigation > li.current_page_item > a,
	.white_style .navigation > li.current_page_parent > a,
	.white_style .navigation > li.current_page_ancestor > a,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li:hover > .item_link,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li > .item_link:hover,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li > .item_link:focus,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li:hover > .item_link *,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link *,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li.current-page-ancestor > .item_link *,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li.current-post-ancestor > .item_link *,
	.white_style #mega_main_menu > .menu_holder > .menu_inner > ul > li.current-menu-item > .item_link *,
	.side_header #header.transparent_type .vertical_navigation li:hover > a,
	.side_header #header.transparent_type .vertical_navigation li.current-menu-item > a,
	.side_header #header.transparent_type .vertical_navigation li.current-menu-parent > a,
	.side_header #header.transparent_type .vertical_navigation li.current-menu-ancestor > a,
	.side_header #header.transparent_type .vertical_navigation li.current_page_item > a,
	.side_header #header.transparent_type .vertical_navigation li.current_page_parent > a,
	.side_header #header.transparent_type .vertical_navigation li.current_page_ancestor > a,
	.side_header #header.transparent_type .social_links a:hover,
	.transparent_type .vertical_navigation #mega_main_menu .mega_dropdown > li.current-menu-item > .item_link *,
	.transparent_type .vertical_navigation #mega_main_menu .mega_dropdown > li > .item_link:focus *,
	.transparent_type .vertical_navigation #mega_main_menu .mega_dropdown > li > .item_link:hover *,
	.transparent_type .vertical_navigation #mega_main_menu .mega_dropdown > li > .item_link:hover:after,
	.transparent_type .vertical_navigation #mega_main_menu > .menu_holder > .menu_inner > ul > li > .item_link:hover,
	.transparent_type .vertical_navigation #mega_main_menu > .menu_holder > .menu_inner > ul > li > .item_link:hover *,
	.float_aside .widget_nav_menu li:hover > a,
	.float_aside .widget_nav_menu li.current-menu-item > a,
	.float_aside .widget_nav_menu li.current-menu-parent > a,
	.float_aside .widget_nav_menu li.current-menu-ancestor > a,
	.float_aside .widget_nav_menu li.current_page_item > a,
	.float_aside .widget_nav_menu li.current_page_parent > a,
	.float_aside .widget_nav_menu li.current_page_ancestor > a {
		color: $first_level_link_color_hover;
	}

	.nav_wrap .navigation ul.sub-menu > li:hover > a,
	.nav_wrap .navigation ul.sub-menu > li.current-menu-item > a,
	.nav_wrap .navigation ul.sub-menu > li.current-menu-parent > a,
	.nav_wrap .navigation ul.sub-menu > li.current-menu-ancestor > a,
	.nav_wrap .navigation ul.sub-menu > li.current_page_item > a,
	.nav_wrap .navigation ul.sub-menu > li.current_page_parent > a,
	.nav_wrap .navigation ul.sub-menu > li.current_page_ancestor > a,
	.nav_wrap .navigation ul.children > li:hover > a,
	.nav_wrap .navigation ul.children > li.current-menu-item > a,
	.nav_wrap .navigation ul.children > li.current-menu-parent > a,
	.nav_wrap .navigation ul.children > li.current-menu-ancestor > a,
	.nav_wrap .navigation ul.children > li.current_page_item > a,
	.nav_wrap .navigation ul.children > li.current_page_parent > a,
	.nav_wrap .navigation ul.children > li.current_page_ancestor > a {
		color: $dropdown_link_color_hover;
	}

	@media only screen and (max-width: 992px) {

		.mobile-advanced > ul > li > a,
		.mobile-advanced .mega_main_menu_ul > li > a
		{
			background-color: $bg_color_first_level_mobile_menu;
		}

		.mobile-advanced .navigation ul.sub-menu > li:hover > a,
		.mobile-advanced .navigation ul.sub-menu > li.current-menu-item > a,
		.mobile-advanced .navigation ul.sub-menu > li.current-menu-parent > a,
		.mobile-advanced .navigation ul.sub-menu > li.current-menu-ancestor > a,
		.mobile-advanced .navigation ul.sub-menu > li.current_page_item > a,
		.mobile-advanced .navigation ul.sub-menu > li.current_page_parent > a,
		.mobile-advanced .navigation ul.sub-menu > li.current_page_ancestor > a,
		.mobile-advanced .navigation ul.children > li:hover > a,
		.mobile-advanced .navigation ul.children > li.current-menu-item > a,
		.mobile-advanced .navigation ul.children > li.current-menu-parent > a,
		.mobile-advanced .navigation ul.children > li.current-menu-ancestor > a,
		.mobile-advanced .navigation ul.children > li.current_page_item > a,
		.mobile-advanced .navigation ul.children > li.current_page_parent > a,
		.mobile-advanced .navigation ul.children > li.current_page_ancestor > a,

		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li:hover > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-item > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-parent > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-ancestor > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_item > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_parent > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_ancestor > a,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li:hover > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-item > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-parent > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current-menu-ancestor > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_item > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_parent > span,
		.mobile-advanced .mega_main_menu_ul ul.mega_dropdown > li.current_page_ancestor > span
		{
			color: $dropdown_link_color_second_level_mobile_menu;
		}

	}

";

/*---------------------------------*/
/* CUSTOM */
/*---------------------------------*/

global $terminus_config;
$terminus_config['styles'] = array(

	array(
		'commenting' => esc_html__('Dynamic Styles', 'terminus'),
		'values' => array(
			'returnValue' => $output
		)
	),

	array(
		'elements' => 'body',
		'values' => array(
			'google_webfonts' => terminus_get_option('general_google_webfont')
		)
	),
	array(
		'elements' => '#header h1.logo',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-logo_font_family')
		)
	),

	// Heading H1
	array(
		'elements' => 'h1',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h1_font_family')
		)
	),
	// Heading H2
	array(
		'elements' => 'h2',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h2_font_family')
		)
	),
	// Heading H3
	array(
		'elements' => 'h3',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h3_font_family')
		)
	),
	// Heading H4
	array(
		'elements' => 'h4',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h4_font_family')
		)
	),
	// Heading H5
	array(
		'elements' => 'h5',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h5_font_family')
		)
	),
	// Heading H6
	array(
		'elements' => 'h6',
		'values' => array(
			'google_webfonts' => terminus_get_option('styles-h6_font_family')
		)
	),

	// The Quick Custom CSS
	array(
		'commenting' => 'Custom Styles',
		'values' => array(
			'returnValue' => terminus_get_option('custom_quick_css')
		)
	)
);