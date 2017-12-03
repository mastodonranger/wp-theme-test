<?php

if (!class_exists('terminus_wp_import')) {

	class terminus_wp_import extends WP_Import {

		function save_settings($option_file) {

			if ( $option_file ) @include_once($option_file);
			if ( !isset($options) ) { return false; }

			$options = json_decode($options, true);
			$terminus_global_data = terminus_get_global_data();

			if ( is_array($options) ) {
				foreach($terminus_global_data->option_pages as $page) {
					$database_option[$page['parent']] = $this->import_values($options[$page['parent']]);
				}
			}

			if ( !empty($database_option) ) {
				update_option($terminus_global_data->option_prefix, $database_option);
			}

			if ( !empty($widget_settings) ) {
				$widget_settings = json_decode($widget_settings, true);
				if ( !empty($widget_settings) ) {
					foreach( $widget_settings as $key => $setting ) {
						update_option( $key, $setting );
					}
				}
			}

			if ( !empty($sidebar_settings) ) {
				$sidebar_settings = json_decode($sidebar_settings, true);
				if ( !empty($sidebar_settings) && is_array($sidebar_settings) ) {
					update_option( 'terminus_sidebars', $sidebar_settings );
				}
			}

			if ( !empty($woof_settings) ) {
				$woof_settings = json_decode($woof_settings, true);
				if ( !empty($woof_settings) ) {
					update_option('woof_settings', $woof_settings);
				}
			}

			if ( !empty($meta_settings) ) {
				$meta_settings = json_decode($meta_settings, true);
				if ( !empty($meta_settings) ) {
					$this->importMetaData($meta_settings);
				}
			}

			update_option( 'page_on_front', 3205 );
			update_option( 'show_on_front', 'page' );
			update_option( 'wc_nb_newness', 1000 );
			update_option( 'yith_woocompare_compare_button_in_products_list', 'yes' );
			update_option( 'yith_wcwl_button_position', 'shortcode' );

			$notices = array_diff( get_option( 'woocommerce_admin_notices', array() ), array( 'install', 'update' ) );
			update_option( 'woocommerce_admin_notices', $notices );
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );
		}

		public function importMetaData($meta_settings) {
			global $wpdb;

			if ( is_array($meta_settings) ) {
				foreach($meta_settings as $meta) {
					$wpdb->insert($wpdb->prefix . 'product_catmeta', $meta, array('%d', '%d', '%s', '%s' ) );
				}
			}

		}

		public function importSliders() {

			if ( defined('RS_PLUGIN_PATH') ) {

				$sliders_needle_revolution = array(
					'Home1.zip',
					'home4.zip',
					'image-hero8.zip',
					'personal.zip',
					'photography.zip',
					'content-tabs.zip'
				);

				foreach ($sliders_needle_revolution as $zip_path) {
					$slider = new RevSlider();
					$slider->importSliderFromPost(true, true, RS_PLUGIN_PATH . 'demo/' . $zip_path);
				}

			}

			if ( defined('LS_ROOT_PATH') ) {

				include LS_ROOT_PATH . '/classes/class.ls.importutil.php';

				$sliders_needle = array(
					'home-page-6',
					'home-page-2'
				);

				if ( !empty($sliders_needle) ) {
					foreach ( $sliders_needle as $slider ) {

						if ( $item = LS_Sources::getDemoSlider($slider) ) {

							if ( file_exists($item['file']) ) {
								new LS_ImportUtil($item['file']);
							}
						}
					}
				}

			}

		}

		public function import_values($elements) {

			$values = array();

			foreach ($elements as $element) {
				if (isset($element['id'])) {

					if (!isset($element['std'])) $element['std'] = "";

					if ($element['type'] == 'select' && !is_array($element['options'])) {
						$values[$element['id']] = $this->getSelectValues($element['options'], $element['std']);
					} else {
						$values[$element['id']] = $element['std'];
					}
				}
			}

			return $values;
		}

		public function getSelectValues($type, $name) {
			switch ($type) {
				case 'page':
				case 'post':
					$post_page = get_page_by_title($name, 'OBJECT', $type);
					if (isset($post_page->ID)) {
						return $post_page->ID;
					}
					break;
				case 'custom_sidebars':
				case 'range':
					return $name;
					break;
			}
		}

		public function menu_install() {

			$locations = array();
			$get_menus = wp_get_nav_menus();

			if ( !empty($get_menus) ) {

				$nav_needle = array(
					'primary' => 'Primary Menu',
					'onepage' => 'Onepage Menu',
					'topbar' => 'Topbar Menu'
				);

				foreach ( $get_menus as $menu ) {
					if ( is_object($menu) && in_array($menu->name, $nav_needle) ) {
						$key = array_search($menu->name, $nav_needle);
						if ( $key ) {
							$locations[$key] = $menu->term_id;
						}
					}
				}

				if ( $locations ) {
					set_theme_mod( 'nav_menu_locations', $locations );
				}

			}

		}


	}

}