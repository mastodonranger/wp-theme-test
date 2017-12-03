<?php

if (!class_exists('TERMINUS_CONFIG_MEGAMENU')) {

	class TERMINUS_CONFIG_MEGAMENU {

		public $paths = array();

		protected function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file) {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct() {

			if ( !is_admin() ) {

				$dir = get_template_directory() . '/config-megamenu';

				$this->paths = array(
					'APP_ROOT' => $dir,
					'BASE_URI' => get_template_directory_uri() . '/config-megamenu/',
					'ASSETS_DIR_NAME' => 'assets'
				);

				$this->add_hooks();

			}

		}

		public function add_hooks() {
			add_action('wp_enqueue_scripts', array(&$this, 'front_init'), 1);
		}

		public function front_init() {
			$this->register_css();
		}

		public function register_css() {
			$front_css_file = $this->assetUrl('css/frontend-megamenu.css');
			wp_register_style( 'terminus_frontend_megamenu', $front_css_file, array('mmm_mega_main_menu') );
			wp_enqueue_style( 'terminus_frontend_megamenu' );
		}

	}

	new TERMINUS_CONFIG_MEGAMENU();

}