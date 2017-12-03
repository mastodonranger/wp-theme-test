<?php

if (!class_exists('TERMINUS_META')) {

	class TERMINUS_META {

		function __construct() {
			add_action('init', array(&$this, 'init') );
		}

		public function init() {
			add_filter('rwmb_meta_boxes', array(&$this, 'meta_boxes_array'));
		}

		public function meta_boxes_array($meta_boxes) {

			/*	Meta Box Definitions
			/* ---------------------------------------------------------------------- */

			$prefix = 'terminus_';

			/*	Layout Settings
			/* ---------------------------------------------------------------------- */

			$pages = get_pages('title_li=&orderby=name');
			$list_pages = array('' => 'None');
			foreach ($pages as $key => $entry) {
				$list_pages[$entry->ID] = $entry->post_title;
			}

			$registered_sidebars = TERMINUS_HELPER::get_registered_sidebars(array("" => 'Default Sidebar'), array('General Widget Area'));
			$registered_custom_sidebars = array();

			foreach($registered_sidebars as $key => $value) {
				if (strpos($key, 'Footer Row') === false) {
					$registered_custom_sidebars[$key] = $value;
				}
			}

			$meta_boxes[] = array(
				'id'       => 'layout-settings',
				'title'    => esc_html__('Layout', 'terminus'),
				'pages'    => array('post', 'page', 'product', 'lookbook'),
				'context'  => 'side',
				'priority' => 'default',
				'fields'   => array(
					array(
						'name'    => esc_html__('Header Style', 'terminus'),
						'id'      => $prefix . 'header_style',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose your header style', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							'style_1' => esc_html__('Style 1', 'terminus'),
							'style_2' => esc_html__('Style 2', 'terminus'),
							'style_3' => esc_html__('Style 3', 'terminus'),
							'style_4' => esc_html__('Style 4', 'terminus'),
							'style_5' => esc_html__('Style 5', 'terminus'),
							'style_6' => esc_html__('Style 6', 'terminus'),
							'style_7' => esc_html__('Style 7', 'terminus'),
							'style_8' => esc_html__('Style 8', 'terminus'),
							'style_9' => esc_html__('Style 9 ( located to the left )', 'terminus'),
							'style_10' => esc_html__('Style 10 ( located to the left and transparent )', 'terminus'),
							'style_11' => esc_html__('Style 11', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Sidebar Position', 'terminus'),
						'id'      => $prefix . 'page_sidebar_position',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose page sidebar position', 'terminus'),
						'options' => array(
							'' => esc_html__('Default Sidebar Position', 'terminus'),
							'no_sidebar' => esc_html__('No Sidebar', 'terminus'),
							'sbl' => esc_html__('Left Sidebar', 'terminus'),
							'sbr' => esc_html__('Right Sidebar', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Sidebar Setting', 'terminus'),
						'id'      => $prefix . 'page_sidebar',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose a custom sidebar', 'terminus'),
						'options' => $registered_custom_sidebars
					),
					array(
						'name'    => esc_html__('Before Content', 'terminus'),
						'id'      => $prefix . 'before_content',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Display content before main content', 'terminus'),
						'options' => $list_pages
					),
					array(
						'name'    => esc_html__('Padding between header and content', 'terminus'),
						'id'      => $prefix . 'enable_padding_above',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: if checked enable padding', 'terminus'),
					),
					array(
						'name'    => esc_html__('Padding between content and footer', 'terminus'),
						'id'      => $prefix . 'enable_padding_below',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: if checked enable padding', 'terminus'),
					),
					array(
						'name'    => esc_html__('Hide Footer', 'terminus'),
						'id'      => $prefix . 'hide_footer',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: Hide Footer', 'terminus'),
					)
				)
			);

			$meta_boxes[] = array(
				'id'       => 'page-settings',
				'title'    => esc_html__('Page Settings', 'terminus'),
				'pages'    => array('page'),
				'context'  => 'side',
				'priority' => 'default',
				'fields'   => array(
					array(
						'name'    => esc_html__('Coming Soon', 'terminus'),
						'id'      => $prefix . 'coming_soon',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: page coming soon', 'terminus'),
					)
				)
			);

			/*	Body Background
			/* ---------------------------------------------------------------------- */

			$meta_boxes[] = array(
				'id'       => 'body-background',
				'title'    => esc_html__('Body Background', 'terminus'),
				'pages'    => array('page'),
				'context'  => 'side',
				'priority' => 'default',
				'fields'   => array(
					array(
						'name'    => esc_html__('Background color', 'terminus'),
						'id'      => $prefix . 'bg_color',
						'type'    => 'color',
						'std'     => '',
						'desc'    => esc_html__('Select the background color of the body', 'terminus')
					),
					array(
						'name'    => esc_html__('Background image', 'terminus'),
						'id'      => $prefix . 'bg_image',
						'type'    => 'thickbox_image',
						'std'     => '',
						'desc'    => esc_html__('Select the background image', 'terminus')
					),
					array(
						'name'    => esc_html__('Background repeat', 'terminus'),
						'id'      => $prefix . 'bg_image_repeat',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Select the repeat mode for the background image', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							'repeat' => esc_html__('Repeat', 'terminus'),
							'no-repeat' => esc_html__('No Repeat', 'terminus'),
							'repeat-x' => esc_html__('Repeat Horizontally', 'terminus'),
							'repeat-y' => esc_html__('Repeat Vertically', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Background position', 'terminus'),
						'id'      => $prefix . 'bg_image_position',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Select the position for the background image', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							'top left' => esc_html__('Top left', 'terminus'),
							'top center' => esc_html__('Top center', 'terminus'),
							'top right' => esc_html__('Top right', 'terminus'),
							'bottom left' => esc_html__('Bottom left', 'terminus'),
							'bottom center' => esc_html__('Bottom center', 'terminus'),
							'bottom right' => esc_html__('Bottom right', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Background attachment', 'terminus'),
						'id'      => $prefix . 'bg_image_attachment',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Select the attachment for the background image ', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							'scroll' => esc_html__('Scroll', 'terminus'),
							'fixed' => esc_html__('Fixed', 'terminus')
						)
					),
				)
			);

			/*	Team Settings
			/* ---------------------------------------------------------------------- */

			$meta_boxes[] = array(
				'id'       => 'team-settings',
				'title'    => esc_html__('Team Settings', 'terminus'),
				'pages'    => array('team-members'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'name' => esc_html__('Position', 'terminus'),
						'id'   => $prefix . 'tm_position',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					)
				)
			);

			$meta_boxes[] = array(
				'id'       => 'team-social-settings',
				'title'    => esc_html__('Team Social Links', 'terminus'),
				'pages'    => array('team-members'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'name' => esc_html__('Facebook', 'terminus'),
						'id'   => $prefix . 'tm_facebook',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Twitter', 'terminus'),
						'id'   => $prefix . 'tm_twitter',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Google Plus', 'terminus'),
						'id'   => $prefix . 'tm_gplus',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Instagram', 'terminus'),
						'id'   => $prefix . 'tm_instagram',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('LinkedIn', 'terminus'),
						'id'   => $prefix . 'tm_linkedin',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Mail Me', 'terminus'),
						'id'   => $prefix . 'tm_mail',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					)
				)
			);

			/*	Testimonials Settings
			/* ---------------------------------------------------------------------- */

			$meta_boxes[] = array(
				'id'       => 'testimonials-settings',
				'title'    => esc_html__('Testimonials Settings', 'terminus'),
				'pages'    => array('testimonials'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'name' => esc_html__('Place', 'terminus'),
						'id'   => $prefix . 'tm_place',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
				)
			);

			$meta_boxes[] = array(
				'id'       => 'testimonials-social-settings',
				'title'    => esc_html__('Testimonials Social Links', 'terminus'),
				'pages'    => array('testimonials'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'name' => esc_html__('Facebook', 'terminus'),
						'id'   => $prefix . 'tm_facebook',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Twitter', 'terminus'),
						'id'   => $prefix . 'tm_twitter',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Google Plus', 'terminus'),
						'id'   => $prefix . 'tm_gplus',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Instagram', 'terminus'),
						'id'   => $prefix . 'tm_instagram',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('LinkedIn', 'terminus'),
						'id'   => $prefix . 'tm_linkedin',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					),
					array(
						'name' => esc_html__('Mail Me', 'terminus'),
						'id'   => $prefix . 'tm_mail',
						'type' => 'text',
						'std'  => '',
						'desc' => ''
					)
				)
			);

			/*	Portfolio Settings
			/* ---------------------------------------------------------------------- */

			$meta_boxes[] = array(
				'id'       => 'portfolio-settings',
				'title'    => esc_html__('Portfolio Settings', 'terminus'),
				'pages'    => array('portfolio'),
				'context'  => 'side',
				'priority' => 'default',
				'fields'   => array(
					array(
						'name'    => esc_html__('Breadcrumb Navigation', 'terminus'),
						'id'      => $prefix . 'breadcrumb',
						'type'    => 'select',
						'std'     => true,
						'desc'    => esc_html__('Display the Breadcrumb Navigation?', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							true => esc_html__('Display breadcrumbs', 'terminus'),
							false => esc_html__('Hide', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Top Image', 'terminus'),
						'id'      => $prefix . 'top_image',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: Show top image from featured', 'terminus'),
					),
					array(
						'name'    => esc_html__('Post Meta Position', 'terminus'),
						'id'      => $prefix . 'portfolio_position_post_meta',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose portfolio meta post position', 'terminus'),
						'options' => array(
							'' => esc_html__('Default', 'terminus'),
							'top' => esc_html__('Top', 'terminus'),
							'bottom' => esc_html__('Bottom', 'terminus'),
							'sbl' => esc_html__('Left', 'terminus'),
							'sbr' => esc_html__('Right', 'terminus'),
							'none' => esc_html__('None', 'terminus')
						)
					),
					array(
						'name'    => esc_html__('Image Size', 'terminus'),
						'id'      => $prefix . 'image_size',
						'type'    => 'select',
						'options' => array(
							"small" => esc_html__('Small', 'terminus'),
							"medium" => esc_html__('Medium', 'terminus'),
							"large" => esc_html__('Large', 'terminus')
						),
						'std'  => 'small',
						'desc' => esc_html__('Preset image size for the masonry cover image', 'terminus')
					),
					array(
						'name'    => esc_html__('Portfolio Link', 'terminus'),
						'id'      => $prefix . 'visit_to_website',
						'type'    => 'url',
						'std'     => '',
						'desc'    => esc_html__('External Link for the Portfolio', 'terminus'),
					),
					array(
						'name'    => esc_html__('Related Items', 'terminus'),
						'id'      => $prefix . 'related_items',
						'type'    => 'checkbox',
						'std'     => '0',
						'desc'    => esc_html__('Boolean: Hide related items', 'terminus'),
					)

				)
			);

			return $meta_boxes;
		}

	}

	new TERMINUS_META;
}