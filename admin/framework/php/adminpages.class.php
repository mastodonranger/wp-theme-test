<?php

if (!class_exists('TERMINUS_ADMIN_PAGES')) {

	class TERMINUS_ADMIN_PAGES extends TERMINUS_FRAMEWORK {

		public $globalObject;

		function __construct(&$globalObject) {
			if (is_admin()) {
				$this->globalObject = $globalObject;

				add_action('admin_menu', array(&$this, 'admin_menu'));
				add_action('admin_head', array(&$this, 'admin_head'), 1);
				add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'), 102);
			} else {
				add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'), 102);
			}
		}

		function admin_head() {
			echo "<link rel='stylesheet' id='terminus-google-webfont' href='//fonts.googleapis.com/css?family=Roboto:300,400,700' type='text/css' media='all'/> \n";
		}

		function admin_menu() {

//			add_theme_page( 'terminus', 'Product Registration', 'administrator', 'terminus_welcome', array( $this, 'welcome' ), 'dashicons-admin-post', 60 );

			if (!isset($this->globalObject->option_pages)) return;

			foreach ($this->globalObject->option_pages as $key => $data_set) {

				if ($key === 0) {
					$the_title = $this->globalObject->theme_data['title'];
					$page = add_theme_page( $the_title, $the_title, 'manage_options', 'terminus', array(&$this, 'create_page'));
				}

				if (!empty($page)) {
					add_action('admin_enqueue_scripts', array(&$this, 'required_scripts'));
					add_action('admin_enqueue_scripts', array(&$this, 'required_styles'));
				}

			}

		}

		public function welcome() {
			require_once( get_template_directory() . '/admin/framework/php/welcome.php' );
		}

		function admin_bar_menu () {

			if (!current_user_can('manage_options')) return;

			global $wp_admin_bar;

			$terminus_global_data = terminus_get_global_data();

			if ( empty($terminus_global_data->option_pages) ) return;

			$admin_url = admin_url('admin.php');

			foreach ($terminus_global_data->option_pages as $page) {
				$slug = $page['slug'];

				$menu = array(
					'id' => $slug,
					'title' => strip_tags($page['title']),
					'href' => $admin_url."?page=". $slug,
					'meta' => array('target' => 'blank')
				);

				if ($page['slug'] != $page['parent'] ) {
					$menu['parent'] = $page['parent'];
					$menu['href'] = $admin_url . "?page=". $page['parent'] . "#to_" . $slug;
				}
				if (is_admin()) $menu['meta'] = array('onclick' => 'self.location.replace(encodeURI("'.$menu['href'].'")); window.location.reload(true);  ');

				$wp_admin_bar->add_menu($menu);
			}
		}

		function create_page() {
			$slug = $_GET['page'];
			$this->globalObject->page_slug = $slug;
			$option_pages = $this->globalObject->option_pages;

			$html = new TERMINUS_HTML_BUILD($this->globalObject);

			echo $html->page_header($option_pages);
			foreach ($option_pages as $option_page) {
				echo $html->create_container($option_page);
			}
			echo $html->page_footer();
		}

		function required_scripts($hook) {

			if ('appearance_page_terminus' != $hook) return;

			wp_enqueue_script('thickbox');
			wp_enqueue_script('jquery-ui');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('wp-color-picker');

			if (function_exists('wp_enqueue_media') && (isset($_REQUEST['page']) && $_REQUEST['page'] == 'terminus')) {
				wp_enqueue_media();
			}
			wp_enqueue_script( 'terminus_upload', self::$path['assetsJsURL'] . 'upload-media.js', array('jquery', 'media-upload'), self::TERMINUS_FRAMEWORK_VERSION);
			wp_enqueue_script( 'terminus_modernizr', self::$path['assetsJsURL'] . 'modernizr.custom.js', array('jquery'), self::TERMINUS_FRAMEWORK_VERSION);
			wp_enqueue_script( 'terminus_options-behavior', self::$path['assetsJsURL'] . 'options-behavior.js', array('jquery'), self::TERMINUS_FRAMEWORK_VERSION);

			$this->localize_popup_text();
		}

		function required_styles($hook) {

			if ('appearance_page_terminus' != $hook) return;

			wp_enqueue_style('thickbox');
			wp_enqueue_style('wp-color-picker');

			wp_enqueue_style( 'terminus_admin_options_styles', self::$path['assetsCssURL'] . 'framework-styles.css');

			if (is_rtl()) {
				wp_enqueue_style( 'terminus_admin_options_styles-rtl',  self::$path['assetsCssURL'] . 'rtl.css', array( 'terminus_admin_options_styles' ), '1', 'all' );
			}

			wp_enqueue_style( 'terminus_admin_fontello', self::$path['assetsCssURL'] . 'fontello.css' );
		}

		public function localize_popup_text() {
			wp_localize_script( 'terminus_modernizr', 'terminus_framework_localize', array(
				'errorText' => esc_html__('Data is not preserved!', 'terminus'),
				'successText' => esc_html__('All options are saved successfully!', 'terminus'),
				'importsuccessText' => esc_html__('Import demo successfully!', 'terminus'),
				'importsuccessOptions' => esc_html__('Import options successfully!', 'terminus'),
				'resetText' => esc_html__('Are you sure you want to delete all of the options?', 'terminus'),
				'importText' => esc_html__('By importing the dummy data all your current theme option settings will be overwritten. Continue anyway?', 'terminus')
			));
		}

	}

}
