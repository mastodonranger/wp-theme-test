<?php

if ( !function_exists('terminus_pre_dynamic_stylesheet') ) {

	function terminus_pre_dynamic_stylesheet () {

		$options = terminus_get_option();
		$styles	= $custom = array();

		foreach ($options as $key => $option) {
			if (strpos($key, 'styles-') === 0) {
				$explode_key = explode('-', $key);
				$styles[$explode_key[1]] = $option;
			}
		}

		if ( empty($styles['body_bg_image']) ) $styles['body_bg_image'] = "";

		if ( $styles['bg_img'] == 'custom' ) {
			$body_bg_color = empty($styles['general_body_bg_color']) ? "" : $styles['general_body_bg_color'];
			$url = empty($styles['body_bg_image']) ? "" : "url(" . $styles['body_bg_image'] . ")";
			$styles['body_bg'] = "$body_bg_color $url " . $styles['body_repeat'] . " " . $styles['body_position'] . " " . $styles['body_attachment'];
		} else {
			$body_bg_color = empty($styles['general_body_bg_color']) ? "" : $styles['general_body_bg_color'];
			$styles['body_bg'] = "$body_bg_color";
		}

		extract($styles);
		extract($custom);

		require( get_template_directory() . '/css/dynamic-global-css.php' );
	}
}

/*  Generate Dynamic Styles
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_dynamic_styles') ) {
	function terminus_dynamic_styles() {
		terminus_pre_dynamic_stylesheet();
	}
	add_action('init', 'terminus_dynamic_styles', 15);
	add_action('admin_init', 'terminus_dynamic_styles', 15);
}

if ( !function_exists('terminus_generate_styles') ) {

	function terminus_generate_styles() {
		$globalObject = terminus_get_global_data();
		$globalObject->reset_options();
		$prefix_name = sanitize_file_name($globalObject->theme_data['prefix']);
		terminus_pre_dynamic_stylesheet();
		$generate_styles = new TERMINUS_DYNAMIC_STYLES(false);
		$styles = $generate_styles->create_styles();

		$wp_upload_dir  = wp_upload_dir();
		$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_terminus_dir';
		$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);
		terminus_backend_create_folder($stylesheet_dynamic_dir);

		$stylesheet = trailingslashit($stylesheet_dynamic_dir) . $prefix_name . '.css';
		$create = terminus_write_to_file($stylesheet, $styles, 0777);

		if ( $create === true ) {
			update_option('exists_stylesheet' . $prefix_name, true);
			update_option('stylesheet_version' . $prefix_name, uniqid());
		}
	}

	add_action('terminus_ajax_after_save_options_page', 'terminus_generate_styles', 25);
	add_action('terminus_after_import_hook', 'terminus_generate_styles', 28);

}

/*  Create folder
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_backend_create_folder')) {
	function terminus_backend_create_folder(&$folder, $addindex = true) {
		if ( is_dir($folder) && $addindex == false ) {
			return true;
		}
		$created = wp_mkdir_p(trailingslashit($folder));
		@chmod($folder, 0777);

		if ( $addindex == false ) return $created;

		return $created;
	}
}

/*  Write To File
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_write_to_file')) {

	function terminus_write_to_file($filename, $content = '', $chmod) {

		global $wp_filesystem;

		if ( empty($wp_filesystem) ) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		if ( !$wp_filesystem->put_contents( $filename, $content, $chmod ) ) {
			return false;
		}

		return true;
	}

}


/*  Elements decode
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_deep_decode')) {

	function terminus_deep_decode($elements) {
		if (is_array($elements) || is_object($elements)) {
			foreach ($elements as $key => $element) {
				$elements[$key] = terminus_deep_decode($element);
			}
		} else {
			$elements = html_entity_decode($elements, ENT_COMPAT, get_bloginfo('charset'));
		}
		return $elements;
	}

}

/*  Get Option
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_get_option')) {
	function terminus_get_option($key = false, $default = "", $decode = false) {
		$terminus_global_data = terminus_get_global_data();
		$result = $terminus_global_data->options;

		if (is_array($key)) {
			$result = $result[$key[0]];
		} else {
			$result = $result['terminus'];
		}

		if ($key === false) {
		} else if(isset($result[$key])) {
			$result = $result[$key];
		} else {
			$result = $default;
		}

		if ($decode) { $result = terminus_deep_decode($result); }
		if ($result == "") { $result = $default; }
		return $result;
	}
}

/*  Header types
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_options_header_types') ) {
	function terminus_options_header_types() {
		return array(
			'1' => array( 'alt' => esc_html__('Header Type 1', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_01.jpg' ),
			'2' => array( 'alt' => esc_html__('Header Type 2', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_02.jpg' ),
			'3' => array( 'alt' => esc_html__('Header Type 3', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_03.jpg' ),
			'4' => array( 'alt' => esc_html__('Header Type 4', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_04.jpg' ),
			'5' => array( 'alt' => esc_html__('Header Type 5', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_05.jpg' ),
			'6' => array( 'alt' => esc_html__('Header Type 6', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_06.jpg' ),
			'7' => array( 'alt' => esc_html__('Header Type 7', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_07.jpg' ),
			'8' => array( 'alt' => esc_html__('Header Type 8', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_08.jpg' ),
			'9' => array( 'alt' => esc_html__('Header Type 9', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_09.jpg' ),
			'10' => array( 'alt' => esc_html__('Header Type 10', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_10.jpg' ),
			'11' => array( 'alt' => esc_html__('Header Type 11', 'terminus'), 'img' => get_template_directory_uri() . '/admin/framework/images/headers/header_11.jpg' )
		);
	}
}

