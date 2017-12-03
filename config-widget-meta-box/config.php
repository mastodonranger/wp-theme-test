<?php

if (!class_exists('TERMINUS_WIDGETS_META_BOX')) {

	class TERMINUS_WIDGETS_META_BOX {

		public $paths = array();

		public function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file)  {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct () {

			$dir = get_template_directory() . '/config-widget-meta-box';

			$this->paths = array(
				'PHP' => $dir . '/php/',
				'ASSETS_DIR_NAME' => 'assets',
				'BASE_URI' => get_template_directory_uri() . '/config-widget-meta-box/'
			);

			$this->init();
		}

		public function init() {

			if ( is_admin() ) {
				add_action('add_meta_boxes', array(&$this, 'add_meta_box') );
				add_action('save_post', array(&$this, 'save_post'));
				add_action('load-post.php', array($this, 'admin_enqueue_scripts'));
				add_action('load-post-new.php', array($this, 'admin_enqueue_scripts'));
				add_action('admin_enqueue_scripts', array(&$this, 'add_json') );
			}

		}

		public function admin_enqueue_scripts() {

			if ( is_admin() && function_exists( 'get_current_screen' ) ) {

				$screen = get_current_screen();

				if ( 'page' == $screen->post_type || 'portfolio' == $screen->post_type ) {

					$css_file = $this->assetUrl('css/widget-meta-box.css');
					$js_file = $this->assetUrl('js/widget-meta-box.js');
					wp_enqueue_style( 'terminus_widget-meta-box', $css_file );
					wp_enqueue_script( 'terminus_widget-meta-box', $js_file, array('jquery'), 1, true );

				}

			}

		}

		public function add_meta_box() {
			add_meta_box("terminus_widets_footer_meta_box", esc_html__("Widgets Row Footer", 'terminus'), array(&$this, 'draw_widgets_meta_box' ), array('page', 'portfolio'), "normal", "low");
		}

		public function add_json() {

			if ( is_admin() && function_exists( 'get_current_screen' ) ) {
				?>
				<script type='text/html' id='terminus-tmpl-options-hidden'>
					<?php echo json_encode($this->columns_grid()); ?>
				</script>
				<?php
			}

		}

		public function columns_grid() {
			return array( "1" => array( array( "24" ) ) ,
						  "2" => array( array( "12", "12" ) ) ,
						  "3" => array( array( "8", "8", "8" ) , array( "7", "10", "7") ) ,
						  "4" => array( array( "6", "6", "6", "6" ), array( "6", "4", "6", "8" ) ),
						  "5" => array( array( "6", "3", "3", "6", "6" ), array( "6", "4", "6", "3", "5" ), array( "7", "3", "3", "4", "7" ), array( "4", "4", "6", "6", "4" ) )
			);
		}

		public static function get_settings_from_post_meta($post_id) {
			$result = array();

			$result['footer_row_top_show'] = get_post_meta($post_id, 'footer_row_top_show', true);
			$result['footer_row_middle_show'] = get_post_meta($post_id, 'footer_row_middle_show', true);
			$result['footer_row_bottom_show'] = get_post_meta($post_id, 'footer_row_bottom_show', true);

			$result['footer_row_top_full_width'] = get_post_meta($post_id, 'footer_row_top_full_width', true);
			$result['footer_row_middle_full_width'] = get_post_meta($post_id, 'footer_row_middle_full_width', true);
			$result['footer_row_bottom_full_width'] = get_post_meta($post_id, 'footer_row_bottom_full_width', true);

			$result['get_sidebars_top_widgets'] = get_post_meta($post_id, 'get_sidebars_top_widgets', true);
			$result['get_sidebars_middle_widgets'] = get_post_meta($post_id, 'get_sidebars_middle_widgets', true);
			$result['get_sidebars_bottom_widgets'] = get_post_meta($post_id, 'get_sidebars_bottom_widgets', true);

			$result['footer_row_top_columns_variations'] = get_post_meta($post_id, 'footer_row_top_columns_variations', true);
			$result['footer_row_middle_columns_variations'] = get_post_meta($post_id, 'footer_row_middle_columns_variations', true);
			$result['footer_row_bottom_columns_variations'] = get_post_meta($post_id, 'footer_row_bottom_columns_variations', true);

			return $result;
		}

		public function get_page_settings($post_id) {
			$custom = get_post_custom($post_id);

			$data = array();
			$data['columns_variations'] = $this->columns_grid();

			$data['footer_row_top_show'] = @$custom["footer_row_top_show"][0];
			$data['footer_row_middle_show'] = @$custom["footer_row_middle_show"][0];
			$data['footer_row_bottom_show'] = @$custom["footer_row_bottom_show"][0];

			$data['footer_row_top_full_width'] = @$custom["footer_row_top_full_width"][0];
			$data['footer_row_middle_full_width'] = @$custom["footer_row_middle_full_width"][0];
			$data['footer_row_bottom_full_width'] = @$custom["footer_row_bottom_full_width"][0];

			$data['footer_row_top_columns_variations'] = @$custom["footer_row_top_columns_variations"][0];
			$data['footer_row_middle_columns_variations'] = @$custom["footer_row_middle_columns_variations"][0];
			$data['footer_row_bottom_columns_variations'] = @$custom["footer_row_bottom_columns_variations"][0];

			$data['get_sidebars_top_widgets'] = @$custom["get_sidebars_top_widgets"][0];
			$data['get_sidebars_middle_widgets'] = @$custom["get_sidebars_middle_widgets"][0];
			$data['get_sidebars_bottom_widgets'] = @$custom["get_sidebars_bottom_widgets"][0];

			if ($data['footer_row_top_columns_variations'] == null) {
				$data['footer_row_top_columns_variations'] = terminus_get_option('footer_row_top_columns_variations');
			}

			if ($data['footer_row_middle_columns_variations'] == null) {
				$data['footer_row_middle_columns_variations'] = terminus_get_option('footer_row_middle_columns_variations');
			}

			if ($data['footer_row_bottom_columns_variations'] == null) {
				$data['footer_row_bottom_columns_variations'] = terminus_get_option('footer_row_bottom_columns_variations');
			}

			$footer_row_top_show = (terminus_get_option('show_row_top_widgets') != '0') ? 'yes' : 'no';
			$footer_row_middle_show = (terminus_get_option('show_row_middle_widgets') != '0') ? 'yes' : 'no';
			$footer_row_bottom_show = (terminus_get_option('show_row_bottom_widgets') != '0') ? 'yes' : 'no';
			$footer_row_top_full_width = (terminus_get_option('row_top_full_width') != '0') ? 'yes' : 'no';
			$footer_row_middle_full_width = (terminus_get_option('row_middle_full_width') != '0') ? 'yes' : 'no';
			$footer_row_bottom_full_width = (terminus_get_option('row_bottom_full_width') != '0') ? 'yes' : 'no';

			if (!isset($data["footer_row_top_show"])) {
				$data['footer_row_top_show'] = $footer_row_top_show;
			}

			if (!isset($data["footer_row_middle_show"])) {
				$data['footer_row_middle_show'] = $footer_row_middle_show;
			}

			if (!isset($data["footer_row_bottom_show"])) {
				$data['footer_row_bottom_show'] = $footer_row_bottom_show;
			}

			if (!isset($data["footer_row_top_full_width"])) {
				$data['footer_row_top_full_width'] = $footer_row_top_full_width;
			}

			if (!isset($data["footer_row_middle_full_width"])) {
				$data['footer_row_middle_full_width'] = $footer_row_middle_full_width;
			}

			if (!isset($data["footer_row_bottom_full_width"])) {
				$data['footer_row_bottom_full_width'] = $footer_row_bottom_full_width;
			}

			if ($data['get_sidebars_top_widgets'] == null) {
				$data['get_sidebars_top_widgets'] = 'a:5:{i:0;s:21:"Footer Row - widget 1";i:1;s:21:"Footer Row - widget 2";i:2;s:21:"Footer Row - widget 3";i:3;s:21:"Footer Row - widget 4";i:4;s:21:"Footer Row - widget 5";}';
			}

			if ($data['get_sidebars_middle_widgets'] == null) {
				$data['get_sidebars_middle_widgets'] = 'a:5:{i:0;s:21:"Footer Row - widget 1";i:1;s:21:"Footer Row - widget 2";i:2;s:21:"Footer Row - widget 3";i:3;s:21:"Footer Row - widget 4";i:4;s:21:"Footer Row - widget 5";}';
			}

			if ($data['get_sidebars_middle_widgets'] == null) {
				$data['get_sidebars_bottom_widgets'] = 'a:5:{i:0;s:21:"Footer Row - widget 1";i:1;s:21:"Footer Row - widget 2";i:2;s:21:"Footer Row - widget 3";i:3;s:21:"Footer Row - widget 4";i:4;s:21:"Footer Row - widget 5";}';
			}

			$data['get_sidebars'] = $this->get_registered_sidebars();
			$data['columns'] = 5;
			return $data;
		}

		public function get_registered_sidebars() {
			$registered_sidebars = TERMINUS_HELPER::get_registered_sidebars();
			$registered_footer_sidebars = array();

			foreach($registered_sidebars as $key => $value) {
				if (strpos($key, 'Footer Row') !== false) {
					$registered_footer_sidebars[$key] = $value;
				}
			}
			return $registered_footer_sidebars;
		}

		public function draw_widgets_meta_box() {
			global $post;

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Use nonce for verification
			wp_nonce_field( 'terminus-post-meta-box', 'terminus-post-meta-box-nonce' );

			$data = $this->get_page_settings($post->ID);
			echo $this->draw_page($this->path('PHP', 'meta_box.php'), $data);
		}

		public function save_post($post_id) {
			global $post;

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

			if ( !isset( $_POST['terminus-post-meta-box-nonce'] ) )
				return;

			if ( !wp_verify_nonce( $_POST['terminus-post-meta-box-nonce'], 'terminus-post-meta-box' ) )
				return;

			if (is_object($post) AND !empty($_POST)) {
				update_post_meta($post_id, "footer_row_top_show", @$_POST["footer_row_top_show"]);
				update_post_meta($post_id, "footer_row_middle_show", @$_POST["footer_row_middle_show"]);
				update_post_meta($post_id, "footer_row_bottom_show", @$_POST["footer_row_bottom_show"]);

				update_post_meta($post_id, "footer_row_top_full_width", @$_POST["footer_row_top_full_width"]);
				update_post_meta($post_id, "footer_row_middle_full_width", @$_POST["footer_row_middle_full_width"]);
				update_post_meta($post_id, "footer_row_bottom_full_width", @$_POST["footer_row_bottom_full_width"]);

				update_post_meta($post_id, "footer_row_top_columns_variations", @$_POST["footer_row_top_columns_variations"]);
				update_post_meta($post_id, "footer_row_middle_columns_variations", @$_POST["footer_row_middle_columns_variations"]);
				update_post_meta($post_id, "footer_row_bottom_columns_variations", @$_POST["footer_row_bottom_columns_variations"]);

				update_post_meta($post_id, "get_sidebars_top_widgets", @$_POST["get_sidebars_top_widgets"]);
				update_post_meta($post_id, "get_sidebars_middle_widgets", @$_POST["get_sidebars_middle_widgets"]);
				update_post_meta($post_id, "get_sidebars_bottom_widgets", @$_POST["get_sidebars_bottom_widgets"]);
			}
		}

		public function draw_page($pagepath, $data = array()) {
			@extract($data);
			ob_start();
			include $pagepath;
			return ob_get_clean();
		}

	}

	new TERMINUS_WIDGETS_META_BOX();

}