<?php

class Terminus_Vc_Config {

	public $paths = array();
	private static $_instance;

	function __construct() {

		$dir = get_template_directory() . '/config-composer';

		$this->paths = array(
			'APP_ROOT' => $dir,
			'HELPERS_DIR' => $dir . '/helpers',
			'CONFIG_DIR' => $dir . '/config',
			'ASSETS_DIR_NAME' => 'assets',
			'BASE_URI' => get_template_directory_uri() . '/config-composer/',
			'PARTS_VIEWS_DIR' => $dir . '/shortcodes/views/',
			'TEMPLATES_DIR' => $dir . '/shortcodes/',
			'MODULES_DIR' => $dir . '/modules/'
		);

		require_once $this->path( 'HELPERS_DIR', 'helpers.php' );

		// Add New param
		$this->ShortcodeParams();
		$this->add_hooks();

		// Load
		$this->autoloadLibraries($this->path('TEMPLATES_DIR'));
		$this->init();
	}

	/**
	 *
	 * @return self
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function init() {

		add_action('vc_build_admin_page', array(&$this, 'autoremoveElements'), 11);
		add_action('vc_load_shortcode', array(&$this, 'autoremoveElements'), 11);

		if ( is_admin() ) {
			add_action('load-post.php', array($this, 'admin_init') , 4);
			add_action('load-post-new.php', array($this, 'admin_init') , 4 );
		} else {
			add_action('wp_enqueue_scripts', array(&$this, 'front_init'), 5);
		}

	}

	public function add_hooks() {
		add_action('terminus_pre_import_hook', array(&$this, 'wpb_content_types'));
		add_action('vc_before_init', array(&$this, 'before_init'), 1);
		add_action('vc_mapper_init_after', array(&$this, 'mapper_init_after'), 5);
		add_filter('vc_font_container_get_allowed_tags', array(&$this, 'font_container_get_allowed_tags'));
		add_action('init', array(&$this, 'isotope_ajax_hooks'));
	}

	public function mapper_init_after() {
		$vc_config_path = $this->paths['CONFIG_DIR'];
		vc_lean_map( 'vc_progress_bar', null, $vc_config_path . '/content/shortcode-vc-progress-bar.php' );
		vc_lean_map( 'vc_message', null, $vc_config_path . '/content/shortcode-vc-message.php' );
		vc_lean_map( 'vc_tta_accordion', null, $vc_config_path . '/tta/shortcode-vc-tta-accordion.php' );
		vc_lean_map( 'vc_tta_tabs', null, $vc_config_path . '/tta/shortcode-vc-tta-tabs.php' );
		vc_lean_map( 'vc_toggle', null, $vc_config_path . '/tta/shortcode-vc-toggle.php' );
		vc_lean_map( 'vc_btn', null, $vc_config_path . '/buttons/shortcode-vc-btn.php' );
	}

	public function before_init() {
		require_once( $this->path('CONFIG_DIR', 'map.php') );
		$this->autoloadLibraries( $this->path('MODULES_DIR') );
	}

	public $removeElements = array(
		'vc_gmaps', 'mega_main_menu',

		'products', 'product', 'product_attribute', 'recent_products', 'add_to_cart',
		'add_to_cart_url', 'product_category', 'product_categories', 'featured_products',
		'sale_products', 'best_selling_products', 'top_rated_products'
	);

	public $removeParams = array();

	public function isotope_ajax_hooks() {
		add_action('wp_ajax_terminus_portfolio_ajax_isotope_items_more', array(&$this, 'portfolio_ajax_load_more'));
		add_action('wp_ajax_nopriv_terminus_portfolio_ajax_isotope_items_more', array(&$this, 'portfolio_ajax_load_more'));
	}

	public function portfolio_ajax_load_more() {
		$masonry_entries = new terminus_portfolio_isotope_masonry_entries($_POST);
		$output = $masonry_entries->html();
		echo '{terminus-isotope-loaded}' . $output;
		exit();
	}

	public function ShortcodeParams() {
		WpbakeryShortcodeParams::addField('choose_icons', array(&$this, 'param_icon_field'), $this->assetUrl('js/js_shortcode_param_icon.js'));
		WpbakeryShortcodeParams::addField('table_number', array(&$this, 'param_table_number_field'), $this->assetUrl('js/js_shortcode_tables.js'));
		WpbakeryShortcodeParams::addField('table_hidden', array(&$this, 'param_hidden_field'));
		WpbakeryShortcodeParams::addField('datetimepicker', array(&$this, 'param_datetimepicker'), $this->assetUrl('js/bootstrap-datetimepicker.min.js'));
		WpbakeryShortcodeParams::addField('number', array(&$this, 'param_number_field'));
		WpbakeryShortcodeParams::addField('get_terms', array(&$this, 'param_woocommerce_terms'), $this->assetUrl('js/js_shortcode_products.js'));
		WpbakeryShortcodeParams::addField('get_by_id', array(&$this, 'param_woocommerce_get_by_id'), $this->assetUrl('js/js_shortcode_products.js'));

		vc_add_param( 'vc_custom_heading', array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use theme default font family?', 'terminus' ),
			'param_name' => 'use_theme_fonts',
			'value' => array( esc_html__( 'Yes', 'terminus' ) => 'yes' ),
			'description' => esc_html__( 'Use font family from the theme.', 'terminus' ),
			'std' => 'yes'
		) );

		vc_remove_param( 'vc_custom_heading', 'css_animation' );

	}

	public function admin_init() {
		add_action('admin_enqueue_scripts', array(&$this, 'admin_extend_js_css'));
	}

	public function front_init() {
		$this->enqueue_styles();
		$this->enqueue_js();

		wp_enqueue_script( 'vc-icon-picker' );
		wp_enqueue_style( 'vc-icon-picker-main-css' );
		wp_enqueue_style( 'vc-icon-picker-main-css-theme' );

		//  Fonts
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'vc_openiconic' );
		wp_enqueue_style( 'vc_typicons' );
		wp_enqueue_style( 'vc_entypo' );
		wp_enqueue_style( 'vc_linecons' );
		wp_enqueue_style( 'vc_monosocialiconsfont' );
	}

	public function admin_extend_js_css() {
		wp_enqueue_style( 'terminus_extend-admin', $this->assetUrl('css/js_composer_backend_editor.css'), false, WPB_VC_VERSION );
		wp_enqueue_style( 'terminus_admin_linea', get_template_directory_uri() . '/css/linea.css', false, WPB_VC_VERSION );
		wp_enqueue_style( 'terminus_bootstrap-datetimepicker', $this->assetUrl('css/bootstrap-datetimepicker-admin.css'), false, WPB_VC_VERSION );
	}

	public function path( $name, $file = '' ) {
		$path = $this->paths[ $name ] . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );
		return $path;
	}

	public function enqueue_styles() {
		wp_deregister_style('js_composer_front');
		$front_css_file = $this->assetUrl('css/css_composer_front.css');
		wp_enqueue_style( 'js_composer_front', $front_css_file, array( 'terminus_style' ), WPB_VC_VERSION, 'all' );
	}

	public function enqueue_js() {

		wp_enqueue_script( 'terminus_wpb_composer_front_js', $this->assetUrl('js/js_composer_front.js'), array( 'jquery' ), WPB_VC_VERSION, true );

		if ( !is_404() && !is_search() ) {

			global $post;

			if ( !$post ) return false;

			$post_content = $post->post_content;

			if ( stripos( $post_content, '[vc_mad_google_map') ) {
				if ( defined('TERMINUS_DISABLE_GOOGLE_MAP_API') && (TERMINUS_DISABLE_GOOGLE_MAP_API == true || TERMINUS_DISABLE_GOOGLE_MAP_API == 'true') ) {
					$load_map_api = false;
				} else {
					$load_map_api = true;
				}

				if ( $load_map_api ) wp_enqueue_script('terminus-vc-googleapis');
			}

		}

	}

	public function autoremoveElements() {
		foreach ( $this->removeParams as $name => $element ) {
			foreach ( $element as $attribute_name ) {
				vc_remove_param($name, $attribute_name);
			}
		}

		foreach ( $this->removeElements as $element ) {
			vc_remove_element($element);
		}
	}

	protected function autoloadLibraries($path) {
		foreach ( glob($path. '*.php') as $file ) {
			require_once($file);
		}
	}

	public function assetUrl( $file ) {
		return preg_replace( '/\s/', '%20', $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file));
	}

	function fieldAttachedImages( $att_ids = array() ) {
		$output = '';

		foreach ( $att_ids as $th_id ) {
			$thumb_src = wp_get_attachment_image_src( $th_id, 'thumbnail' );
			if ( $thumb_src ) {
				$thumb_src = $thumb_src[0];
				$output .= '
						<li class="added">
							<img rel="' . $th_id . '" src="' . $thumb_src . '" />
							<input type="text" name=""/>
							<a href="#" class="icon-remove"></a>
						</li>';
			}
		}
		if ( $output != '' ) {
			return $output;
		}
	}

	public function param_icon_field($settings, $value) {
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$icons = array( ' ', 'icon-basic-accelerator', 'icon-basic-alarm', 'icon-basic-anchor', 'icon-basic-anticlockwise', 'icon-basic-archive', 'icon-basic-archive-full', 'icon-basic-ban', 'icon-basic-battery-charge', 'icon-basic-battery-empty', 'icon-basic-battery-full', 'icon-basic-battery-half', 'icon-basic-bolt', 'icon-basic-book', 'icon-basic-book-pen', 'icon-basic-book-pencil', 'icon-basic-bookmark', 'icon-basic-calculator', 'icon-basic-calendar', 'icon-basic-cards-diamonds', 'icon-basic-cards-hearts', 'icon-basic-case', 'icon-basic-chronometer', 'icon-basic-clessidre', 'icon-basic-clock', 'icon-basic-clockwise', 'icon-basic-cloud', 'icon-basic-clubs', 'icon-basic-compass', 'icon-basic-cup', 'icon-basic-diamonds', 'icon-basic-display', 'icon-basic-download', 'icon-basic-exclamation', 'icon-basic-eye', 'icon-basic-eye-closed', 'icon-basic-female', 'icon-basic-flag1', 'icon-basic-flag2', 'icon-basic-floppydisk', 'icon-basic-folder', 'icon-basic-folder-multiple', 'icon-basic-gear', 'icon-basic-geolocalize-01', 'icon-basic-geolocalize-05', 'icon-basic-globe', 'icon-basic-gunsight', 'icon-basic-hammer', 'icon-basic-headset', 'icon-basic-heart', 'icon-basic-heart-broken', 'icon-basic-helm', 'icon-basic-home', 'icon-basic-info', 'icon-basic-ipod', 'icon-basic-joypad', 'icon-basic-key', 'icon-basic-keyboard', 'icon-basic-laptop', 'icon-basic-life-buoy', 'icon-basic-lightbulb', 'icon-basic-link', 'icon-basic-lock', 'icon-basic-lock-open', 'icon-basic-magic-mouse', 'icon-basic-magnifier', 'icon-basic-magnifier-minus', 'icon-basic-magnifier-plus', 'icon-basic-mail', 'icon-basic-mail-multiple', 'icon-basic-mail-open', 'icon-basic-mail-open-text', 'icon-basic-male', 'icon-basic-map', 'icon-basic-message', 'icon-basic-message-multiple', 'icon-basic-message-txt', 'icon-basic-mixer2', 'icon-basic-mouse', 'icon-basic-notebook', 'icon-basic-notebook-pen', 'icon-basic-notebook-pencil', 'icon-basic-paperplane', 'icon-basic-pencil-ruler', 'icon-basic-pencil-ruler-pen', 'icon-basic-photo', 'icon-basic-picture', 'icon-basic-picture-multiple', 'icon-basic-pin1', 'icon-basic-pin2', 'icon-basic-postcard', 'icon-basic-postcard-multiple', 'icon-basic-printer', 'icon-basic-question', 'icon-basic-rss', 'icon-basic-server', 'icon-basic-server2', 'icon-basic-server-cloud', 'icon-basic-server-download', 'icon-basic-server-upload', 'icon-basic-settings', 'icon-basic-share', 'icon-basic-sheet', 'icon-basic-sheet-multiple', 'icon-basic-sheet-pen', 'icon-basic-sheet-pencil', 'icon-basic-sheet-txt', 'icon-basic-signs', 'icon-basic-smartphone', 'icon-basic-spades', 'icon-basic-spread', 'icon-basic-spread-bookmark', 'icon-basic-spread-text', 'icon-basic-spread-text-bookmark', 'icon-basic-star', 'icon-basic-tablet', 'icon-basic-target', 'icon-basic-todo', 'icon-basic-todo-pen', 'icon-basic-todo-pencil', 'icon-basic-todo-txt', 'icon-basic-todolist-pen', 'icon-basic-todolist-pencil', 'icon-basic-trashcan', 'icon-basic-trashcan-full', 'icon-basic-trashcan-refresh', 'icon-basic-trashcan-remove', 'icon-basic-upload', 'icon-basic-usb', 'icon-basic-video', 'icon-basic-watch', 'icon-basic-webpage', 'icon-basic-webpage-img-txt', 'icon-basic-webpage-multiple', 'icon-basic-webpage-txt', 'icon-basic-world', 'icon-ecommerce-bag', 'icon-ecommerce-bag-check', 'icon-ecommerce-bag-cloud', 'icon-ecommerce-bag-download', 'icon-ecommerce-bag-minus', 'icon-ecommerce-bag-plus', 'icon-ecommerce-bag-refresh', 'icon-ecommerce-bag-remove', 'icon-ecommerce-bag-search', 'icon-ecommerce-bag-upload', 'icon-ecommerce-banknote', 'icon-ecommerce-banknotes', 'icon-ecommerce-basket', 'icon-ecommerce-basket-check', 'icon-ecommerce-basket-cloud', 'icon-ecommerce-basket-download', 'icon-ecommerce-basket-minus', 'icon-ecommerce-basket-plus', 'icon-ecommerce-basket-refresh', 'icon-ecommerce-basket-remove', 'icon-ecommerce-basket-search', 'icon-ecommerce-basket-upload', 'icon-ecommerce-bath', 'icon-ecommerce-cart', 'icon-ecommerce-cart-check', 'icon-ecommerce-cart-cloud', 'icon-ecommerce-cart-content', 'icon-ecommerce-cart-download', 'icon-ecommerce-cart-minus', 'icon-ecommerce-cart-plus', 'icon-ecommerce-cart-refresh', 'icon-ecommerce-cart-remove', 'icon-ecommerce-cart-search', 'icon-ecommerce-cart-upload', 'icon-ecommerce-cent', 'icon-ecommerce-colon', 'icon-ecommerce-creditcard', 'icon-ecommerce-diamond', 'icon-ecommerce-dollar', 'icon-ecommerce-euro', 'icon-ecommerce-franc', 'icon-ecommerce-gift', 'icon-ecommerce-graph1', 'icon-ecommerce-graph2', 'icon-ecommerce-graph3', 'icon-ecommerce-graph-decrease', 'icon-ecommerce-graph-increase', 'icon-ecommerce-guarani', 'icon-ecommerce-kips', 'icon-ecommerce-lira', 'icon-ecommerce-megaphone', 'icon-ecommerce-money', 'icon-ecommerce-naira', 'icon-ecommerce-pesos', 'icon-ecommerce-pound', 'icon-ecommerce-receipt', 'icon-ecommerce-receipt-bath', 'icon-ecommerce-receipt-cent', 'icon-ecommerce-receipt-dollar', 'icon-ecommerce-receipt-euro', 'icon-ecommerce-receipt-franc', 'icon-ecommerce-receipt-guarani', 'icon-ecommerce-receipt-kips', 'icon-ecommerce-receipt-lira', 'icon-ecommerce-receipt-naira', 'icon-ecommerce-receipt-pesos', 'icon-ecommerce-receipt-pound', 'icon-ecommerce-receipt-rublo', 'icon-ecommerce-receipt-rupee', 'icon-ecommerce-receipt-tugrik', 'icon-ecommerce-receipt-won', 'icon-ecommerce-receipt-yen', 'icon-ecommerce-receipt-yen2', 'icon-ecommerce-recept-colon', 'icon-ecommerce-rublo', 'icon-ecommerce-rupee', 'icon-ecommerce-safe', 'icon-ecommerce-sale', 'icon-ecommerce-sales', 'icon-ecommerce-ticket', 'icon-ecommerce-tugriks', 'icon-ecommerce-wallet', 'icon-ecommerce-won', 'icon-ecommerce-yen', 'icon-ecommerce-yen2', 'icon-arrows-anticlockwise', 'icon-arrows-anticlockwise-dashed', 'icon-arrows-button-down', 'icon-arrows-button-off', 'icon-arrows-button-on', 'icon-arrows-button-up', 'icon-arrows-check', 'icon-arrows-circle-check', 'icon-arrows-circle-down', 'icon-arrows-circle-downleft', 'icon-arrows-circle-downright', 'icon-arrows-circle-left', 'icon-arrows-circle-minus', 'icon-arrows-circle-plus', 'icon-arrows-circle-remove', 'icon-arrows-circle-right', 'icon-arrows-circle-up', 'icon-arrows-circle-upleft', 'icon-arrows-circle-upright', 'icon-arrows-clockwise', 'icon-arrows-clockwise-dashed', 'icon-arrows-compress', 'icon-arrows-deny', 'icon-arrows-diagonal', 'icon-arrows-diagonal2', 'icon-arrows-down', 'icon-arrows-down-double', 'icon-arrows-downleft', 'icon-arrows-downright', 'icon-arrows-drag-down', 'icon-arrows-drag-down-dashed', 'icon-arrows-drag-horiz', 'icon-arrows-drag-left', 'icon-arrows-drag-left-dashed', 'icon-arrows-drag-right', 'icon-arrows-drag-right-dashed', 'icon-arrows-drag-up', 'icon-arrows-drag-up-dashed', 'icon-arrows-drag-vert', 'icon-arrows-exclamation', 'icon-arrows-expand', 'icon-arrows-expand-diagonal1', 'icon-arrows-expand-horizontal1', 'icon-arrows-expand-vertical1', 'icon-arrows-fit-horizontal', 'icon-arrows-fit-vertical', 'icon-arrows-glide', 'icon-arrows-glide-horizontal', 'icon-arrows-glide-vertical', 'icon-arrows-hamburger1', 'icon-arrows-hamburger-2', 'icon-arrows-horizontal', 'icon-arrows-info', 'icon-arrows-keyboard-alt', 'icon-arrows-keyboard-cmd', 'icon-arrows-keyboard-delete', 'icon-arrows-keyboard-down', 'icon-arrows-keyboard-left', 'icon-arrows-keyboard-return', 'icon-arrows-keyboard-right', 'icon-arrows-keyboard-shift', 'icon-arrows-keyboard-tab', 'icon-arrows-keyboard-up', 'icon-arrows-left', 'icon-arrows-left-double-32', 'icon-arrows-minus', 'icon-arrows-move', 'icon-arrows-move2', 'icon-arrows-move-bottom', 'icon-arrows-move-left', 'icon-arrows-move-right', 'icon-arrows-move-top', 'icon-arrows-plus', 'icon-arrows-question', 'icon-arrows-remove', 'icon-arrows-right', 'icon-arrows-right-double', 'icon-arrows-rotate', 'icon-arrows-rotate-anti', 'icon-arrows-rotate-anti-dashed', 'icon-arrows-rotate-dashed', 'icon-arrows-shrink', 'icon-arrows-shrink-diagonal1', 'icon-arrows-shrink-diagonal2', 'icon-arrows-shrink-horizonal2', 'icon-arrows-shrink-horizontal1', 'icon-arrows-shrink-vertical1', 'icon-arrows-shrink-vertical2', 'icon-arrows-sign-down', 'icon-arrows-sign-left', 'icon-arrows-sign-right', 'icon-arrows-sign-up', 'icon-arrows-slide-down1', 'icon-arrows-slide-down2', 'icon-arrows-slide-left1', 'icon-arrows-slide-left2', 'icon-arrows-slide-right1', 'icon-arrows-slide-right2', 'icon-arrows-slide-up1', 'icon-arrows-slide-up2', 'icon-arrows-slim-down', 'icon-arrows-slim-down-dashed', 'icon-arrows-slim-left', 'icon-arrows-slim-left-dashed', 'icon-arrows-slim-right', 'icon-arrows-slim-right-dashed', 'icon-arrows-slim-up', 'icon-arrows-slim-up-dashed', 'icon-arrows-square-check', 'icon-arrows-square-down', 'icon-arrows-square-downleft', 'icon-arrows-square-downright', 'icon-arrows-square-left', 'icon-arrows-square-minus', 'icon-arrows-square-plus', 'icon-arrows-square-remove', 'icon-arrows-square-right', 'icon-arrows-square-up', 'icon-arrows-square-upleft', 'icon-arrows-square-upright', 'icon-arrows-squares', 'icon-arrows-stretch-diagonal1', 'icon-arrows-stretch-diagonal2', 'icon-arrows-stretch-diagonal3', 'icon-arrows-stretch-diagonal4', 'icon-arrows-stretch-horizontal1', 'icon-arrows-stretch-horizontal2', 'icon-arrows-stretch-vertical1', 'icon-arrows-stretch-vertical2', 'icon-arrows-switch-horizontal', 'icon-arrows-switch-vertical', 'icon-arrows-up', 'icon-arrows-up-double-33', 'icon-arrows-upleft', 'icon-arrows-upright', 'icon-arrows-vertical', 'icon-music-beginning-button', 'icon-music-bell', 'icon-music-cd', 'icon-music-diapason', 'icon-music-eject-button', 'icon-music-end-button', 'icon-music-fastforward-button', 'icon-music-headphones', 'icon-music-ipod', 'icon-music-loudspeaker', 'icon-music-microphone', 'icon-music-microphone-old', 'icon-music-mixer', 'icon-music-mute', 'icon-music-note-multiple', 'icon-music-note-single', 'icon-music-pause-button', 'icon-music-play-button', 'icon-music-playlist', 'icon-music-radio-ghettoblaster', 'icon-music-radio-portable', 'icon-music-record', 'icon-music-recordplayer', 'icon-music-repeat-button', 'icon-music-rewind-button', 'icon-music-shuffle-button', 'icon-music-stop-button', 'icon-music-tape', 'icon-music-volume-down', 'icon-music-volume-up', 'icon-software-add-vectorpoint', 'icon-software-box-oval', 'icon-software-box-polygon', 'icon-software-box-rectangle', 'icon-software-box-roundedrectangle', 'icon-software-character', 'icon-software-crop', 'icon-software-eyedropper', 'icon-software-font-allcaps', 'icon-software-font-baseline-shift', 'icon-software-font-horizontal-scale', 'icon-software-font-kerning', 'icon-software-font-leading', 'icon-software-font-size', 'icon-software-font-smallcapital', 'icon-software-font-smallcaps', 'icon-software-font-strikethrough', 'icon-software-font-tracking', 'icon-software-font-underline', 'icon-software-font-vertical-scale', 'icon-software-horizontal-align-center', 'icon-software-horizontal-align-left', 'icon-software-horizontal-align-right', 'icon-software-horizontal-distribute-center', 'icon-software-horizontal-distribute-left', 'icon-software-horizontal-distribute-right', 'icon-software-indent-firstline', 'icon-software-indent-left', 'icon-software-indent-right', 'icon-software-lasso', 'icon-software-layers1', 'icon-software-layers2', 'icon-software-layout', 'icon-software-layout-2columns', 'icon-software-layout-3columns', 'icon-software-layout-4boxes', 'icon-software-layout-4columns', 'icon-software-layout-4lines', 'icon-software-layout-8boxes', 'icon-software-layout-header', 'icon-software-layout-header-2columns', 'icon-software-layout-header-3columns', 'icon-software-layout-header-4boxes', 'icon-software-layout-header-4columns', 'icon-software-layout-header-complex', 'icon-software-layout-header-complex2', 'icon-software-layout-header-complex3', 'icon-software-layout-header-complex4', 'icon-software-layout-header-sideleft', 'icon-software-layout-header-sideright', 'icon-software-layout-sidebar-left', 'icon-software-layout-sidebar-right', 'icon-software-magnete', 'icon-software-pages', 'icon-software-paintbrush', 'icon-software-paintbucket', 'icon-software-paintroller', 'icon-software-paragraph', 'icon-software-paragraph-align-left', 'icon-software-paragraph-align-right', 'icon-software-paragraph-center', 'icon-software-paragraph-justify-all', 'icon-software-paragraph-justify-center', 'icon-software-paragraph-justify-left', 'icon-software-paragraph-justify-right', 'icon-software-paragraph-space-after', 'icon-software-paragraph-space-before', 'icon-software-pathfinder-exclude', 'icon-software-pathfinder-intersect', 'icon-software-pathfinder-subtract', 'icon-software-pathfinder-unite', 'icon-software-pen', 'icon-software-pen-add', 'icon-software-pen-remove', 'icon-software-pencil', 'icon-software-polygonallasso', 'icon-software-reflect-horizontal', 'icon-software-reflect-vertical', 'icon-software-remove-vectorpoint', 'icon-software-scale-expand', 'icon-software-scale-reduce', 'icon-software-selection-oval', 'icon-software-selection-polygon', 'icon-software-selection-rectangle', 'icon-software-selection-roundedrectangle', 'icon-software-shape-oval', 'icon-software-shape-polygon', 'icon-software-shape-rectangle', 'icon-software-shape-roundedrectangle', 'icon-software-slice', 'icon-software-transform-bezier', 'icon-software-vector-box', 'icon-software-vector-composite', 'icon-software-vector-line', 'icon-software-vertical-align-bottom', 'icon-software-vertical-align-center', 'icon-software-vertical-align-top', 'icon-software-vertical-distribute-bottom', 'icon-software-vertical-distribute-center', 'icon-software-vertical-distribute-top' );

		ob_start(); ?>

		<div id="mad-param-icon">
			<input type="hidden" name="<?php echo esc_attr($param_name) ?>" class="wpb_vc_param_value <?php echo esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) ?> " value="<?php echo esc_attr($value) ?>" id="mad-trace" />
			<div class="mad-icon-preview"><i class="<?php echo esc_attr($value) ?>"></i></div>
			<input class="mad-search" type="text" placeholder="<?php esc_html_e('Search icon', 'terminus') ?>" />
			<div id="mad-icon-dropdown">
				<ul class="mad-icon-list">

					<?php foreach ( $icons as $icon ): ?>

						<?php if ( !empty($icon) ): ?>

							<?php $selected = ($icon == $value) ? 'class="selected"' : ''; ?>

							<li <?php echo esc_attr($selected) ?> data-icon="<?php echo esc_attr($icon) ?>">
								<span class="si-icon <?php echo esc_attr($icon) ?>"></span>
							</li>

						<?php endif; ?>

					<?php endforeach; ?>

				</ul><!--/ .mad-icon-list-->
			</div><!--/ #mad-icon-dropdown-->
		</div>

		<?php return ob_get_clean();
	}

	function param_table_number_field($settings, $value) {
		ob_start(); ?>
		<div class="mad_number_block">
			<input id="<?php echo esc_attr($settings['param_name']) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field'  ?>" type="number" value="<?php echo esc_attr($value) ?>"/>
		</div><!--/ .mad_number_block-->
		<?php return ob_get_clean();
	}

	function param_hidden_field($settings, $value) {
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		ob_start(); ?>
		<input type="hidden" name="<?php echo esc_attr($param_name) ?>" class="wpb_vc_param_value wpb_el_type_table_hidden <?php echo esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) ?>" value="<?php echo esc_attr(trim($value)) ?>" />
		<?php return ob_get_clean();
	}

	function param_datetimepicker($settings, $value) {
		$dependency = '';
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$uni = uniqid('datetimepicker-'.rand());
		$output = '<div id="ult-date-time' . $uni . '" class="ult-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="'.$value.'" '.$dependency.'/><div class="add-on"></div></div>';
		return $output;
	}

	function param_number_field($settings, $value) {
		ob_start(); ?>
		<div class="mad_number_block">
			<input id="<?php echo esc_attr($settings['param_name']) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field'  ?>" type="number" value="<?php echo esc_attr($value) ?>"/>
		</div><!--/ .mad_number_block-->
		<?php return ob_get_clean();
	}

	function get_product_terms( $term_id, $tax, $inserted_vals ) {
		$html = $selected = '';
		$args = array( 'taxonomy' => $tax, 'hide_empty' => 0, 'parent' => $term_id );
		$terms = get_terms($args);

		foreach ($terms as $term) {
			$html .= '<li><a ';

				if ( in_array($term->term_id, $inserted_vals) ) {
					$html .= ' class="selected"';
				}

				$html .= 'data-val="'. $term->term_id .'" title="'. $term->term_id .'" href="javascript:void(0);">' . $term->name . '</a>';

				if ( $list = $this->get_product_terms( $term->term_id, $tax, $inserted_vals )) {
					$html .= '<ul class="second_level">'. $list .'</ul>';
				}

			$html .= '</li>';
		}
		return $html;
	}

	function param_woocommerce_terms($settings, $value) {

		$html = '';
		$terms = get_terms(
			array(
				'taxonomy' => $settings['term'],
				'hide_empty' => 0,
				'parent' => 0
			)
		);
		$inserted_vals = explode(',', $value);

		ob_start(); ?>

		<input type="text" value="<?php echo esc_attr($value) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>" id="<?php echo esc_attr($settings['param_name']); ?>">

		<div class="mad-custom-wrapper">

			<ul class="mad-custom">

				<?php

					foreach ($terms as $term) {
						$html .= '<li class="top_li">';

							$html .= '<a ';

							if ( in_array($term->term_id, $inserted_vals) ) {
								$html .= ' class="selected"';
							}

							$html .= 'data-val="'. esc_attr($term->term_id) .'" title="'. esc_attr($term->term_id) .'" href="javascript:void(0);">' . esc_html($term->name) . '</a>';

							if ( $list = $this->get_product_terms( $term->term_id, $settings['term'], $inserted_vals )) {
								$html .= '<ul class="second_level">'. $list .'</ul>';
							}

						$html .= '</li>';
					}
					echo $html;
				?>

			</ul><!--/ .mad-custom-->

		</div><!--/ .mad-custom-wrapper-->

		<?php return ob_get_clean();
	}

	public function param_woocommerce_get_by_id($settings, $value) {

		$html = '';
		$inserted_vals = explode(',', $value);

		$args = array(
			'post_type' => $settings["post_type"],
			'numberposts' => -1
		);

		$posts = get_posts( $args );

		ob_start(); ?>

		<input type="text" value="<?php echo esc_attr($value) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>" id="<?php echo esc_attr($settings['param_name']); ?>">

		<div class="mad-custom-wrapper">

			<ul class="mad-custom">

				<?php

				foreach ($posts as $post) {
					$html .= '<li class="top_li">';

					$html .= '<a ';

					if ( in_array($post->ID, $inserted_vals) ) {
						$html .= ' class="selected"';
					}

					$html .= 'data-val="'. esc_attr($post->ID) .'" title="'. esc_attr($post->ID) .'" href="javascript:void(0);">' . esc_html($post->post_title) . '</a>';

					$html .= '</li>';
				}

				if ($html != '') { echo $html; }
				?>

			</ul><!--/ .mad-custom-->

		</div><!--/ .mad-custom-wrapper-->

		<?php return ob_get_clean();
	}

	public static function getParamTitle( $title, $tag_title = 'h3', $description = '', $params = array() ) {
		if ( empty($title) ) return;

		$style = '';
		$css_classes = array( 'section_heading' );
		$desc_css_classes = array( 'section_subheading' );
		$extraclass = ( isset( $params['extraclass'] ) ) ? ' ' . $params['extraclass'] : '';
		$title_color = ( isset( $params['title_color'] ) ) ? trim($params['title_color']) : '';

		if ( $extraclass ) {
			$css_classes[] = $extraclass;
		}

		if ( $tag_title == 'h3' ) {
			$css_classes[] = 'align_left';
			$desc_css_classes[] = 'align_left';
		}

		if ( $title_color ) {
			$style = 'style="' . vc_get_css_color( 'color', $title_color ) . '"';
		}

		$css_class = implode( ' ', array_filter( $css_classes ) );
		$desc_css_class = implode( ' ', array_filter( $desc_css_classes ) );

		if ( isset( $description ) && strlen( $description ) > 0 ) {
			echo "<h5 class='". esc_attr(trim($desc_css_class)) ."'>" . esc_html($description) . "</h5>";
		}

		if ( isset( $title ) && strlen( $title ) > 0 ) {
			echo "<{$tag_title} $style class='". esc_attr(trim($css_class)) ."'>" . esc_html($title) ."</{$tag_title}>";
		}

	}

	public static function array_number($from = 0, $to = 50, $step = 1, $array = array()) {
		for ($i = $from; $i <= $to; $i += $step) {
			$array[$i] = $i;
		}
		return $array;
	}

	public static function get_order_sort_array() {
		return array('ID' => 'ID', 'date' => 'date', 'post_date' => 'post_date', 'title' => 'title',
			'post_title' => 'post_title', 'name' => 'name', 'post_name' => 'post_name', 'modified' => 'modified',
			'post_modified' => 'post_modified', 'modified_gmt' => 'modified_gmt', 'post_modified_gmt' => 'post_modified_gmt',
			'menu_order' => 'menu_order', 'parent' => 'parent', 'post_parent' => 'post_parent',
			'rand' => 'rand', 'comment_count' => 'comment_count', 'author' => 'author', 'post_author' => 'post_author');
	}

	public function font_container_get_allowed_tags($allowed_tags) {
		array_unshift($allowed_tags, 'h1');
		return $allowed_tags;
	}

	public function wpb_content_types() {
		$wpb_content_types = array( 'post', 'page', 'portfolio', 'product', 'testimonials', 'team-members' );
		update_option('wpb_js_content_types', $wpb_content_types);
	}

	public static function create_data_string($data = array()) {
		$data_string = "";

		if (empty($data)) return;

		foreach ($data as $key => $value) {
			if (is_array($value)) $value = implode(", ", $value);
			$data_string .= " data-$key={$value} ";
		}
		return $data_string;
	}

}

/**
 * Main Visual composer manager config.
 * @var Terminus_Vc_Config $terminus_vc_config - instance of composer management.
 */
global $terminus_vc_config;
if ( ! $terminus_vc_config ) {
	$terminus_vc_config = Terminus_Vc_Config::getInstance();
}
