<?php

if (!function_exists('terminus_ajax_reset_options')) {

	function terminus_ajax_reset_options() {

		check_ajax_referer('ajax_reset_options');

		$terminus_global_data = terminus_get_global_data();
		delete_option($terminus_global_data->option_prefix);
		wp_die('reset');
	}

	add_action('wp_ajax_ajax_reset_options', 'terminus_ajax_reset_options');
}

/*  Ajax Import Data Hook
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_prepare_save_options_array')) {

	function terminus_prepare_save_options_array($data) {
		$result = array();

		foreach ($data as $option) {
			$option = explode("=", $option);
			$option[1] = stripslashes($option[1]);
			$option[1] = htmlentities(urldecode($option[1]), ENT_QUOTES, get_bloginfo('charset'));

			if ($option[0] != "" && $option[0] != 'undefined') {
				$result[$option[0]] = $option[1];
			}
		}
		return $result;
	}
}

if (!function_exists('terminus_ajax_save_options_page')) {

	function terminus_ajax_save_options_page() {

		check_ajax_referer('ajax_save_options_page');

		if (!isset($_REQUEST['data']) || !isset($_REQUEST['slug']) || !isset($_REQUEST['prefix'])) { return; }

		$data = explode("&", $_REQUEST['data']);

		$prefix = $_REQUEST['prefix'];
		$options = get_option($prefix);
		$save = terminus_prepare_save_options_array($data);
		$options[$_REQUEST['slug']] = $save;

		update_option($prefix, $options);
		do_action('terminus_ajax_after_save_options_page', $options);

		wp_die('save');
	}
	add_action('wp_ajax_ajax_save_options_page', 'terminus_ajax_save_options_page');
}

/*  Ajax Import Data Hook
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_ajax_import_options_page')) {

	function terminus_ajax_import_options_page() {
		check_ajax_referer('ajax_import_options_page');
		require_once( get_template_directory() . '/admin/framework/php/config-import-export/inc-importer.php' );
		wp_die('madImport');
	}

	add_action('wp_ajax_ajax_import_options_page', 'terminus_ajax_import_options_page');

}

/*  Ajax Import Config Options Hook
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_ajax_import_config_options')) {

	function terminus_ajax_import_config_options() {

		check_ajax_referer('ajax_import_config_options', '_wpnonce');

		require_once( get_template_directory() . '/admin/framework/php/config-import-export/import-options.php' );

		$file = $_POST['href'];

		global $wp_filesystem;

		if ( empty($wp_filesystem) ) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		$options = $wp_filesystem->get_contents( $file );

		if ( !isset($options) ) return;

		$options = json_decode($options, true);
		$terminus_global_data = terminus_get_global_data();
		$wp_import_options = new terminus_wp_import_options();

		if ( is_array($options) ) {
			foreach($terminus_global_data->option_pages as $page) {
				$database_option[$page['parent']] = $wp_import_options->import_values($options[$page['parent']]);
			}
		}

		if ( !empty($database_option) ) {
			update_option($terminus_global_data->option_prefix, $database_option);
		}

		wp_die('madImportConfig');

	}

	add_action('wp_ajax_ajax_import_config_options', 'terminus_ajax_import_config_options');

}