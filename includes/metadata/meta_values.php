<?php


if (!function_exists('terminus_cat_sidebars')) {

	function terminus_cat_sidebars() {

		$registered_sidebars = TERMINUS_HELPER::get_registered_sidebars(array());
		$registered_custom_sidebars = array();

		if (!empty($registered_sidebars)) {
			foreach($registered_sidebars as $key => $value) {
				if (strpos($key, 'Footer Row') === false) {
					$registered_custom_sidebars[$key] = $value;
				}
			}
		}

		return $registered_custom_sidebars;

	}

}


if (!function_exists('terminus_cat_meta_view')) {

	function terminus_cat_meta_view() {

		$sidebar_options = terminus_cat_sidebars();

		return array(
			'sidebar_position' => array(
				'name' => 'sidebar_position',
				'title' => esc_html__('Sidebar Position', 'terminus'),
				'desc' => esc_html__('Choose sidebar position', 'terminus'),
				'type' => 'select',
				'default' => '',
				'options' => array(
					'' => esc_html__('Default Sidebar Position', 'terminus'),
					'no_sidebar' => esc_html__('No Sidebar', 'terminus'),
					'sbl' => esc_html__('Left Sidebar', 'terminus'),
					'sbr' => esc_html__('Right Sidebar', 'terminus')
				)
			),
			'sidebar' => array(
				'name' => 'sidebar',
				'title' => esc_html__('Sidebar Setting', 'terminus'),
				'desc' => esc_html__('Select the sidebar you would like to display.', 'terminus'),
				'type' => 'select',
				'default' => '',
				'options' => $sidebar_options
			),
			'shop_view' => array(
				'name' => 'shop_view',
				'title' => esc_html__('Shop View', 'terminus'),
				'desc' => esc_html__('Choose shop view layout - grid or list', 'terminus'),
				'type' => 'select',
				'default' => 'view-grid',
				'options' => array(
					'view-grid' => esc_html__('Grid View', 'terminus'),
					'view-list' => esc_html__('List View', 'terminus')
				)
			),
			'overview_column_count' => array(
				'name' => 'overview_column_count',
				'title' => esc_html__('Column Count', 'terminus'),
				'desc' => esc_html__('This controls how many columns should be appeared on overview pages.', 'terminus'),
				'type' => 'select',
				'default' => '',
				'options' => array(
					'' => esc_html__('Default', 'terminus'),
					3 => 3,
					4 => 4
				)
			)
		);

	}

}