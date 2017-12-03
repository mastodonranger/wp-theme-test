<?php

if ( !class_exists('Terminus_Page_Title_Config') ) {

	class Terminus_Page_Title_Config {

		public $paths = array();
		public $action_page_title = 'terminus_page_title';

		public function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file)  {
			return $this->paths['BASE_URI'] . $file;
		}

		function __construct () {

			$dir = get_template_directory() . '/includes/page-title/';

			$this->paths = array(
				'VIEW_PATH' => $dir . 'views',
				'PHP_PATH' => $dir . 'php',
				'BASE_URI' => get_template_directory_uri() . '/includes/page-title/'
			);

			require_once( $this->paths['PHP_PATH'] . '/functions-types.php' );

			$this->init();
		}

		public function init() {
			add_action( 'add_meta_boxes', array(&$this, 'add_meta_box') );
			add_action( 'save_post', array(&$this, 'save_perm_metadata') );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts_and_styles') );

			add_action('wp_ajax_' . $this->action_page_title, array($this, 'inserted_media_to_page_title'));
		}

		public function enqueue_scripts_and_styles() {
			$css_file = $this->assetUrl('css/page-title.css');
			$css_file_form_styler = $this->assetUrl('js/jQueryFormStyler/jquery.formstyler.css');
			$js_file_form_styler = $this->assetUrl('js/jQueryFormStyler/jquery.formstyler.min.js');
			$js_file = $this->assetUrl('js/page-title-config.js');

			wp_enqueue_style( 'terminus_page_title', $css_file );
			wp_enqueue_style( 'terminus_form_styler', $css_file_form_styler );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'terminus_form_styler', $js_file_form_styler, array( 'jquery' ), true);
			wp_enqueue_script( 'terminus_page_title', $js_file, array( 'jquery', 'terminus_form_styler' ), true);

			wp_localize_script( 'terminus_form_styler', 'terminus_page_title_vars', array(
				'img' => $this->paths['BASE_URI'] . 'img/default-placeholder.png'
			));
		}

		public function add_meta_box() {

			$post_types = array(
				'page',
				'post',
				'product',
				'testimonials',
				'team-members',
				'portfolio'
			);

			add_meta_box( "terminus_page_title_meta_box", esc_html__("Page Title", 'terminus'), array(&$this, 'draw_page_title_meta_box' ), $post_types, "normal", "low" );
		}

		public function draw_page_title_meta_box($post) {
			// Use nonce for verification
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			wp_nonce_field( $this->action_page_title, 'terminus_page_title_meta_box_nonce' );

			$data = $this->get_page_settings($post->ID);
			echo $this->draw_page($this->path('VIEW_PATH', 'form-meta-box.php'), $data);
		}

		public function save_perm_metadata( $post_id ) {

			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				return;

			if ( !isset( $_POST['terminus_page_title_meta_box_nonce'] ) )
				return;

			if ( !wp_verify_nonce( $_POST['terminus_page_title_meta_box_nonce'], $this->action_page_title ) )
				return;

			if ( !current_user_can('edit_post', $post_id) )
				return;

			update_post_meta( $post_id, 'terminus_page_title', $_POST['terminus_page_title'] );

		}

		public function get_theme_page_title($postid) {
			$page_title = get_post_meta( $postid, "terminus_page_title", true );
			if ( !is_array($page_title) ) {
				$page_title = array();
			}
			return $page_title;
		}

		public function get_page_settings($post_id) {
			$page_title = $this->get_theme_page_title($post_id);

			$data = array();
			$data['mode'] = isset($page_title['mode']) ? $page_title['mode'] : 'default';
			$data['options'] = $this->options();
			$data['page_title'] = $page_title;
			return $data;
		}

		public function draw_page( $pagepath, $data = array() ) {
			@extract($data);
			ob_start();
			include($pagepath);
			return ob_get_clean();
		}

		public function inserted_media_to_page_title() {

			if ( function_exists('check_ajax_referer') ) {
				check_ajax_referer($this->action_page_title, 'terminus_page_title_meta_box_nonce');
			}

			$id = esc_attr($_POST['id']);

			if ( absint($id) && $id > 0 ) {
				$html = "<div class='img-preview add_animation'><img alt='' src='". TERMINUS_HELPER::get_post_attachment_image( $id, '100*100', true ) ."'></div>";

				wp_send_json(
					array(
						'html' => $html,
						'id' => $id
					)
				);
			}

		}

		public static function output_attributes() {
			switch( terminus_page_title_get_value('mode') ) {
				case 'default':
					self::attributes_from_options();
					break;
				case 'custom':
					self::attributes_from_meta();
					break;
				default:
					$css_classes = apply_filters('terminus_page_title_classes', array(
						'page_title'
					));

					$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_unique(array_filter( $css_classes )) ) );
					$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
					echo implode( ' ', $wrapper_attributes );
					break;
			}
		}

		public static function attributes_from_options() {

			$css_classes = apply_filters('terminus_page_title_classes', array(
				'page_title'
			));

			$url = terminus_get_option('page_title_upload');
			$color = terminus_get_option('page_title_mono_color');
			$parallax = terminus_get_option('page_title_parallax');
			$zoom_out = terminus_get_option('page_title_zoom_out');
			$gradient_effect = terminus_get_option('page_title_gradient_effect');
			$uncovering_effect = terminus_get_option('page_title_uncovering_effect');
			$video_url = terminus_get_option('page_title_video');

			if ( !empty($url) ) {
				$css_classes[] = 'media_type';
				$wrapper_attributes[] = 'style="background-image: url(' . esc_attr($url) . ')"';
			}

			if ( '' !== $color ) {
				$css_classes[] = 'mono_color_title';
				$wrapper_attributes[] = 'style="background-color: '. esc_url($color) .'"';
			}

			if ( $parallax ) {
				$css_classes[] = 'large';
				$css_classes[] = 'parallax';
			}

			if ( $zoom_out ) {
				$css_classes[] = 'large';
				$css_classes[] = 'parallax';
				$css_classes[] = 'zoom_out';
			}

			if ( $gradient_effect ) {
				$css_classes[] = 'large';
				$css_classes[] = 'gradient_effect';
			}

			if ( $uncovering_effect ) {
				$css_classes[] = 'large';
				$css_classes[] = 'uncovering_title';
			}

			if ( !empty($video_url) && self::check_video_url($video_url) ) {
				$css_classes[] = 'media_type';
				$css_classes[] = 'large';
				$css_classes[] = 'video';
			}

			$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_unique(array_filter( $css_classes )) ) );
			$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
			echo implode( ' ', $wrapper_attributes );
		}

		public static function attributes_from_meta() {

			$css_classes = apply_filters('terminus_page_title_classes', array(
				'page_title'
			));

			$upload = terminus_page_title_get_value('upload');
			$color = terminus_page_title_get_value('color');
			$parallax = terminus_page_title_get_value('parallax');
			$zoom_out = terminus_page_title_get_value('zoom_out');
			$gradient_effect = terminus_page_title_get_value('gradient_effect');
			$uncovering_effect = terminus_page_title_get_value('uncovering_effect');
			$video_url = terminus_page_title_get_value('video');

			if ( absint($upload) && $upload > 0 ) {

				$url = TERMINUS_HELPER::get_post_attachment_image( $upload, '', true );

				if ( !empty($url) ) {
					$css_classes[] = 'media_type';
					$wrapper_attributes[] = 'style="background-image: url(' . esc_attr($url) . ')"';
				}

			}

			if ( '' !== $color ) {
				$css_classes[] = 'mono_color_title';
				$wrapper_attributes[] = 'style="background-color: '. esc_url($color) .'"';
			}

			if ( $parallax == 'parallax' ) {
				$css_classes[] = 'large';
				$css_classes[] = 'parallax';
			}

			if ( $zoom_out == 'zoom_out' ) {
				$css_classes[] = 'large';
				$css_classes[] = 'parallax';
				$css_classes[] = 'zoom_out';
			}

			if ( $gradient_effect == 'gradient_effect' ) {
				$css_classes[] = 'large';
				$css_classes[] = 'gradient_effect';
			}

			if ( $uncovering_effect == 'uncovering_effect' ) {
				$css_classes[] = 'large';
				$css_classes[] = 'uncovering_title';
			}

			if ( !empty($video_url) && self::check_video_url($video_url) ) {
				$css_classes[] = 'media_type';
				$css_classes[] = 'large';
				$css_classes[] = 'video';
			}

			$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_unique(array_filter( $css_classes )) ) );
			$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
			echo implode( ' ', $wrapper_attributes );
		}

		public static function output_type() {

			switch ( terminus_page_title_get_value('mode') ):

				case 'default':
					$gradient_effect = terminus_get_option('page_title_gradient_effect');
					$video_url = terminus_get_option('page_title_video'); ?>

					<?php if ( $gradient_effect ): ?>
						<div class="gradient_el"></div>
					<?php endif; ?>

					<?php if ( !empty($video_url) && self::check_video_url($video_url) ): ?>
						<div id="video-wrap" class="parallax_bg_video">
							<video id="video_background" preload="metadata" autoplay loop>
								<source src="<?php echo esc_url($video_url) ?>" type="video/mp4">
							</video>
						</div>
					<?php endif; ?>

				<?php break; ?>
				<?php case 'custom' :
					$gradient_effect = terminus_page_title_get_value('gradient_effect');
					$video_url = terminus_page_title_get_value('video'); ?>

					<?php if ( $gradient_effect == 'gradient_effect' ): ?>
						<div class="gradient_el"></div>
					<?php endif; ?>

					<?php if ( !empty($video_url) && self::check_video_url($video_url) ): ?>
						<div id="video-wrap" class="parallax_bg_video">
							<video id="video_background" preload="metadata" autoplay loop>
								<source src="<?php echo esc_url($video_url) ?>" type="video/mp4">
							</video>
						</div>
					<?php endif; ?>

				<?php break;

			endswitch;

		}

		public function options() {
			return array(
				'breadcrumb' => array(
					'name' => 'breadcrumb',
					'title' => esc_html__('Breadcrumb Navigation', 'terminus'),
					'desc' => esc_html__('Display the Breadcrumb Navigation?', 'terminus'),
					'type' => 'select',
					'default' => 'display',
					'options' => array(
						'display' => esc_html__('Display', 'terminus'),
						'hide' => esc_html__('Hide', 'terminus')
					)
				),
				'color' => array(
					'name' => 'color',
					'title' => esc_html__('Mono Color', 'terminus'),
					'desc' => esc_html__('Background mono color for the header page title', 'terminus'),
					'type' => 'color',
					'default' => ''
				),
				'upload' => array(
					'name' => 'upload',
					'title' => esc_html__('Upload Background Image', 'terminus'),
					'desc' => esc_html__('Background Image for the header page title', 'terminus'),
					'type' => 'upload',
					'default' => $this->paths['BASE_URI'] . 'img/default-placeholder.png'
				),
				'parallax' => array(
					'name'    => 'parallax',
					'title'    => esc_html__('Parallax', 'terminus'),
					'desc'    => esc_html__('Add parallax type background', 'terminus'),
					'type'    => 'checkbox',
					'default' => ''
				),
				'zoom_out' => array(
					'name'    => 'zoom_out',
					'title'    => esc_html__('Zoom Out Effect', 'terminus'),
					'desc'    => esc_html__('Add zoom out effect on background image', 'terminus'),
					'type'    => 'checkbox',
					'default' => ''
				),
				'gradient_effect' => array(
					'name'    => 'gradient_effect',
					'title'    => esc_html__('Gradient Effect', 'terminus'),
					'desc'    => esc_html__('Add gradient effect on background image', 'terminus'),
					'type'    => 'checkbox',
					'default' => ''
				),
				'uncovering_effect' => array(
					'name'    => 'uncovering_effect',
					'title'    => esc_html__('Uncovering Effect', 'terminus'),
					'desc'    => esc_html__('Add uncovering effect effect on background image', 'terminus'),
					'type'    => 'checkbox',
					'default' => ''
				),
				'video' => array(
					'name' => 'video',
					'title' => esc_html__('Video URL (mp4)', 'terminus'),
					'desc' => esc_html__('Add video on background.', 'terminus'),
					'type' => 'text',
					'default' => '',
					'options' => ''
				),
				'animation' => array(
					'name' => 'animation',
					'title' => esc_html__('Animation Title', 'terminus'),
					'desc' => esc_html__('Select type of animation if you want this title to be animated when it enters into the browsers viewport.', 'terminus'),
					'type' => 'select',
					'default' => '',
					'options' => array(
						'' => esc_html__('None', 'terminus'),
						'bounceInLeft' => 'bounceInLeft',
						'bounceInRight' => 'bounceInRight',
						'bounceInDown' => 'bounceInDown',
						'bounceIn' => 'bounceIn',
						'bounceInUp' => 'bounceInUp',
						'fadeIn' => 'fadeIn',
						'fadeInDown' => 'fadeInDown',
						'fadeInLeft' => 'fadeInLeft',
						'fadeInRight' => 'fadeInRight'
					)
				)
			);
		}

		public static function check_video_url($video_url = '') {

			if ( preg_match("/\.mp4$/", $video_url) ) {
				$video_url = trim($video_url);
			}

			return $video_url;
		}

	}

	new Terminus_Page_Title_Config();

}