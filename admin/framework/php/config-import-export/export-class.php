<?php

if (!class_exists('TERMINUS_WP_THEME_SETTINGS_EXPORT')) {

	class TERMINUS_WP_THEME_SETTINGS_EXPORT  {

		function __construct($globalObject) {

			if ( !isset($_GET['theme_settings_export']) ) return;

			$this->globalObject = $globalObject;
			$this->sub_pages = $globalObject->sub_pages;
			$this->options  = $globalObject->options;
			$this->db_prefix = $globalObject->option_prefix;
			
			add_action('admin_init',array(&$this, 'init'), 100);
		}

		public function init() {

			foreach($this->sub_pages as $key => $subpage) {
				$options[$key] = $this->exportArray($this->globalObject->option_page_data, $this->options[$key], $subpage);
			}

			// Export options
			$options = json_encode($options);

			// Widget settings
			$widget_settings = json_encode($this->exportWidgets());

			// Sidebar settings
			$sidebar_settings = json_encode($this->exportSidebars());

			// Woof settings
			$woof_settings = json_encode($this->exportWoof());

			// Meta settings
			$meta_settings = json_encode($this->metaData());

			if (isset($_GET['generate_file'])) {
				$this->generateExportFile($options);
			}

			echo '<pre>'."\n"; echo '$options = "'; print_r(htmlentities($options)); echo '";</pre>'."\n\n";
			echo '<pre>'."\n"; echo '$widget_settings = "'; print_r($widget_settings); echo '";</pre>';
			echo '<pre>'."\n"; echo '$sidebar_settings = "'; print_r($sidebar_settings); echo '";</pre>'."\n\n";
			echo '<pre>'."\n"; echo '$woof_settings = "'; print_r($woof_settings); echo '";</pre>'."\n\n";
			echo '<pre>'."\n"; echo '$meta_settings = "'; print_r($meta_settings); echo '";</pre>'."\n\n";

			exit();
		}

       	public function generateExportFile($export_data) {
            $getdate = getdate();
            $name_file = $getdate['mon'] . '-' . $getdate['mday'] . '-' . $getdate['hours'] . '-' . $getdate['minutes'] ;
			$export_file = sanitize_file_name( 'terminus_theme-settings-'. $name_file .'.txt' );

            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=" . urlencode($export_file));
            header("Pragma: no-cache");
            header("Expires: 0");

            print $export_data;
            die();
        }

		function exportWoof() {
			$woof_settings = get_option('woof_settings');
			return $woof_settings;
		}

		public function exportWidgets() {

			global $wp_registered_widgets;
			$saved_widgets = $options = array();

			foreach ($wp_registered_widgets as $registered) {
				if ( isset($registered['callback'][0]) && isset($registered['callback'][0]->option_name)) {
					$options[] = $registered['callback'][0]->option_name;
				}
			}

			foreach ($options as $key) {
				$widget = get_option($key, array());
				$treshhold = 1;
				if (array_key_exists("_multiwidget", $widget)) $treshhold = 2;

				if ($treshhold <= count($widget)) {
					$saved_widgets[$key] = $widget;
				}
			}

			$saved_widgets['sidebars_widgets'] = get_option('sidebars_widgets');
			return $saved_widgets;
		}

		function exportSidebars() {
			$custom_sidebars = get_option('terminus_sidebars');

			if (!empty($custom_sidebars)) {
				return $custom_sidebars;
			}
		}

		public function metaData() {
			global $wpdb;

			$meta_settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}product_catmeta", ARRAY_A);
			return $meta_settings;
		}

		function exportArray($elements, $options, $subpage) {

			$export_array = array();

			foreach ( $elements as $element ) {

				if ( in_array($element['slug'], $subpage) && isset($element['id']) && isset($options[$element['id']]) ) {

					if ( $element['type'] != 'tab_group_start' || $element['type'] != 'tab_group_end' ) {

						if ( isset($element['options']) && !is_array($element['options']) ) {
							$taxonomy = false;
							$value = $this->get_post_page_name_by_id($options[$element['id']] , $element['options'], $taxonomy);
						} else {
							$value = $options[$element['id']];
						}

						if ( isset($value) ) {
							$element['std'] = $value;
							$export_array[$element['id']] = $element;
						}

					}

				}
			}

			return $export_array;
		}

		function get_post_page_name_by_id($id, $type, $taxonomy = false) {
			switch ($type) {
				case 'page':
				case 'post':
					$post = get_post($id);
					if(isset($post->post_title)) {
						return $post->post_title;
					}
					break;
				case 'custom_sidebars':
				case 'range':
					return $id;
				break;
			}
		}

	}
}


