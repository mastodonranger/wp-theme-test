<?php

if (!class_exists('TERMINUS_GLOBAL_OBJECT')) {

	class TERMINUS_GLOBAL_OBJECT extends TERMINUS_FRAMEWORK {

		public $theme_data;
		public $option_pages = array();
		public $option_page_data = array();
		public $sub_pages = array();
		public $options;
		public $option_prefix;

		public function __construct() {
			$this->theme_data = $this->theme_data();
			$this->option_prefix = 'terminus_options';
			$this->create_options();

			new TERMINUS_DYNAMIC_STYLES();
			new TERMINUS_ADMIN_PAGES($this);

			if ( is_admin() ) {
				new TERMINUS_WP_THEME_SETTINGS_EXPORT($this);
			}

			new TERMINUS_SIDEBAR($this->options);
		}

		protected function create_options() {

			include( TERMINUS_FRAMEWORK::$path['configPath'] . 'register-theme-options.php' );

			if (isset($terminus_pages)) {
				$this->option_pages = $terminus_pages;
			}

			if (isset($terminus_elements)) {
				$this->option_page_data = $terminus_elements;
			}

			foreach($this->option_pages as $page) {
				$this->sub_pages[$page['parent']][] = $page['slug'];
			}

			$option_database = get_option($this->option_prefix);

			foreach ( $terminus_pages as $page ) {
				if ( !isset($option_database[$page['parent']]) || $option_database[$page['parent']] == "" ) {
					$option_database[$page['parent']] = $this->default_value($this->option_page_data, $page, $this->sub_pages);
				}
			}

			$this->options = $option_database;
		}

		public function default_value($elements, $page, $subpages) {
			$vals = array();

			foreach ($elements as $element) {

				if ( in_array($element['slug'], $subpages[$page['parent']]) ) {

					if ( !isset($element['std']) ) { $element['std'] = ""; }
					if ( !isset($element['id']) ) continue;

					$vals[$element['id']] = htmlentities($element['std'], ENT_QUOTES);

				}
			}

			return $vals;
		}

		public function reset_options() {
			unset($this->option_pages, $this->option_page_data, $this->subpages, $this->options);
			$this->create_options();
		}

	}

}
