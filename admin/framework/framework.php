<?php

if (!class_exists('TERMINUS_FRAMEWORK')) {

	class TERMINUS_FRAMEWORK {

		const TERMINUS_FRAMEWORK_VERSION = '0.3';
		public static $path = array();
		public $global_data;
		public $paths;
		private static $_instance;

		public static function getInstance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->paths['frameworkPath'] = get_template_directory() . '/admin/framework/';
			$this->paths['frameworkURL'] = get_template_directory_uri() . '/admin/framework/';
			$this->paths['frameworkPHP'] = $this->paths['frameworkPath'] . 'php/';

			$this->paths['assetsPath']	= trailingslashit( $this->paths['frameworkPath'] ) . 'assets/';
			$this->paths['assetsURL']	= trailingslashit( $this->paths['frameworkURL'] ) . 'assets/';

			$this->paths['assetsJsURL']	= $this->paths['assetsURL'] . 'js/';
			$this->paths['assetsCssURL'] = $this->paths['assetsURL'] . 'css/';

			$this->paths['imagesURL']	= trailingslashit( $this->paths['frameworkURL'] ) . 'images/';
			$this->paths['configPath']	= $this->paths['frameworkPath'] . 'config/';

			self::$path = $this->paths;
			$this->loadLibraries();
			$this->global_data = new TERMINUS_GLOBAL_OBJECT();
		}

		public function get_global_data() {
			return $this->global_data;
		}

		public function loadLibraries() {
			require_once($this->paths['frameworkPHP'] . 'functions-helper.php');
			require_once($this->paths['frameworkPHP'] . 'sidebar-generator.class.php');
			require_once($this->paths['frameworkPHP'] . 'global-object.class.php');
			require_once($this->paths['frameworkPHP'] . 'adminpages.class.php');
			require_once($this->paths['frameworkPHP'] . 'html-helper.class.php');
			require_once($this->paths['frameworkPHP'] . 'functions-ajax.php');
			require_once($this->paths['frameworkPHP'] . 'config-import-export/export-class.php');
			require_once($this->paths['frameworkPHP'] . 'dynamic-style-creator.class.php');
		}

		public function theme_data() {
			if (function_exists('wp_get_theme')) {
				$wp_theme_obj = wp_get_theme();
				$theme_data['title'] = $wp_theme_obj->get('Name');
				$theme_data['author'] = $wp_theme_obj->get('Author');
				$theme_data['name'] = strtolower($theme_data['title']);

				if (is_child_theme()) {
					$theme_data['name'] = strtolower($wp_theme_obj->get('Template'));
				}

				$theme_data['prefix'] = strtolower($theme_data['title']);
				$theme_data['version'] = strtolower($wp_theme_obj->get('Version'));
				return $theme_data;
			}
		}

	}

	if ( ! function_exists( 'terminus_framework' ) ) {
		function terminus_framework() {
			return TERMINUS_FRAMEWORK::getInstance();
		}
		terminus_framework();
	}

	if ( ! function_exists( 'terminus_get_global_data' ) ) {
		function terminus_get_global_data() {
			return terminus_framework()->get_global_data();
		}
	}

}