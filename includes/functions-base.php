<?php

/*  Base Function Class
/* ---------------------------------------------------------------------- */

if (!class_exists('TERMINUS_BASE_FUNCTIONS')) {

	class TERMINUS_BASE_FUNCTIONS {

		public $action_search = 'terminus_action_search';
		public $action_post_share = 'terminus_action_post_share';
		public $paths = array();
		private static $_instance;

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function getInstance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			$dir = get_template_directory() . '/includes';

			$this->paths = array(
				'HELPERS_DIR' => $dir . '/helpers',
			);

			require_once $this->path( 'HELPERS_DIR', 'helpers.php' );

			add_action('template_redirect', array($this, 'template_redirect'));
			add_action('after_setup_theme', array(&$this, 'after_setup_theme'));
			add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles_scripts'), 1);
			add_filter('body_class', array(&$this, 'body_class'), 5);

			new terminus_admin_user_profile();

			/*  Ajax
			/* --------------------------------------------- */
			add_action('wp_ajax_' . $this->action_search, array($this, 'ajax_action_search'));
			add_action('wp_ajax_nopriv_' . $this->action_search, array($this, 'ajax_action_search'));

			add_action('wp_ajax_' . $this->action_post_share, array($this, 'ajax_post_share'));
			add_action('wp_ajax_nopriv_' . $this->action_post_share, array($this, 'ajax_post_share'));

			/*  Init Classes
			/* --------------------------------------------- */
			new TERMINUS_PAGE();

			/*  Load Textdomain
			/* --------------------------------------------- */
			$this->load_textdomain();
		}

		/* 	After Setup Theme
		/* ---------------------------------------------------------------------- */

		public function after_setup_theme() {

			// Post Formats Support
			add_theme_support('post-formats', array( 'gallery', 'quote', 'video', 'audio', 'link' ));

			// Post Thumbnails Support
			add_theme_support('post-thumbnails');

			// Add default posts and comments RSS feed links to head
			add_theme_support('automatic-feed-links');

			add_theme_support('title-tag');

			add_filter( 'widget_text', 'do_shortcode' );

			// This theme uses wp_nav_menu() in one location.
			register_nav_menu( 'primary', 'Primary Menu' );
			register_nav_menu( 'onepage', 'Onepage Menu' );
			register_nav_menu( 'topbar', 'Topbar Menu' );

			// Load theme textdomain
			$this->load_textdomain();

			// Theme Activation
			$this->theme_activation();
		}

		/* 	Initialization
		/* ---------------------------------------------------------------------- */

		function template_redirect() {
			TERMINUS_HELPER::template_layout_class('header_classes');
		}

		function body_class($classes) {

			global $terminus_config;

			if ( terminus_get_option('animation') ) {
				$classes[] = 'animated-content';
			}

			if ( isset($terminus_config['header_classes']) ) {
				$classes[] = $terminus_config['header_classes'];
			}

			$enable_padding_above = rwmb_meta( 'terminus_enable_padding_above', '', terminus_post_id() );
			$enable_padding_below = rwmb_meta( 'terminus_enable_padding_below', '', terminus_post_id() );

			if ( $enable_padding_above ) $classes[] = 'padding_above';
			if ( $enable_padding_below ) $classes[] = 'padding_below';

			$header_style = rwmb_meta( 'terminus_header_style', '', terminus_post_id() );

			if ( $header_style == 'style_9' || $header_style == 'style_10' ) $classes[] = 'side_header';

			return $classes;
		}

		public function enqueue_styles_scripts() {
			$this->register_styles();
			$this->register_scripts();

			$this->enqueue_styles();
			$this->enqueue_scripts();

			self::localize_script();

			$globalObject = terminus_get_global_data();
			$prefix_name = sanitize_file_name($globalObject->theme_data['prefix']);

			if ( get_option('exists_stylesheet'. $prefix_name ) == true ) {
				$upload_dir = wp_upload_dir();
				if (is_ssl()) {
					$upload_dir['baseurl'] = str_replace("http://", "https://", $upload_dir['baseurl']);
				}
				$version = get_option('stylesheet_version' . $prefix_name);
				if (empty($version)) $version = '1';
				wp_enqueue_style( 'terminus_dynamic-styles', $upload_dir['baseurl'] . '/dynamic_terminus_dir/' . $prefix_name . '.css', array(), $version, 'all' );
			}
		}

		/* 	Theme Activation
		/* ---------------------------------------------------------------------- */

		public function theme_activation() {
			global $pagenow;
			if ( is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']) ) {
				do_action('terminus_backend_theme_activation');
				wp_redirect(admin_url('admin.php?page=terminus'));
			}
		}

		public function path( $name, $file = '' ) {
			$path = $this->paths[ $name ] . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );
			return $path;
		}

		/* 	Register Theme Styles
		/* ---------------------------------------------------------------------- */

		public function register_styles() {}

		/* 	Register Theme Scripts
		/* ---------------------------------------------------------------------- */

		public function register_scripts() {
			wp_register_script( 'terminus_cookiealert', get_template_directory_uri() . '/js/cookiealert.js', array('jquery') );
			wp_register_script( 'terminus_pie_chart', get_template_directory_uri() . '/js/plugins/pie.chart.js', array('jquery') );
		}

		/* 	WP Print Styles
		/* ---------------------------------------------------------------------- */

		public function enqueue_styles() {

			/* Vendor CSS */
			wp_enqueue_style( 'owlcarousel', get_template_directory_uri() . '/js/plugins/owl-carousel/owl.carousel.css' );
			wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/js/plugins/fancybox/jquery.fancybox.css' );
			wp_enqueue_style( 'arcticmodal', get_template_directory_uri() . '/js/plugins/arcticmodal/jquery.arcticmodal-0.3.css' );

			/* Theme CSS */
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
			wp_enqueue_style( 'square-jelly-box', get_template_directory_uri() . '/css/square-jelly-box.min.css' );

			wp_deregister_style('animate-css');
			wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/css/animate.css' );
			wp_enqueue_style( 'terminus_style', get_stylesheet_uri() );
			wp_enqueue_style( 'terminus_icons', get_template_directory_uri() . '/css/terminus_icons.css' );
			wp_enqueue_style( 'terminus_layout', get_template_directory_uri() . '/css/layout.css' );

			if ( is_rtl() ) {
				wp_enqueue_style( 'terminus_rtl',  get_template_directory_uri() . "/css/rtl.css", array( 'terminus_style', 'terminus_woocommerce-mod' ), '1', 'all' );
			}

			wp_enqueue_style( 'linea', get_template_directory_uri() . '/css/linea.css' );

			wp_enqueue_style( 'terminus_oldie', get_template_directory_uri() . '/css/oldie.css' );
			wp_style_add_data( 'terminus_oldie', 'conditional', 'lte IE 9' );

		}

		/*  WP Footer Action
		/* ---------------------------------------------------------------------- */

		public function enqueue_scripts() {

			/* Include Libs & Plugins */
			wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js' );

			wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/plugins/isotope.pkgd.min.js', array('jquery'), '', true);
			wp_enqueue_script( 'owlcarousel', get_template_directory_uri() . '/js/plugins/owl-carousel/owl.carousel.min.js', array('jquery'), '', true);

			wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/plugins/fancybox/jquery.fancybox.pack.js', array('jquery'), '', true);
			wp_enqueue_script( 'arcticmodal', get_template_directory_uri() . '/js/plugins/arcticmodal/jquery.arcticmodal-0.3.min.js', array('jquery'), '', true);

			/* Theme files */
			wp_enqueue_script( 'terminus_plugins', get_template_directory_uri() . '/js/theme.plugins' . ( WP_DEBUG ? '' : '.min' ) . '.js', array('jquery'), '', true );
			wp_enqueue_script( 'terminus_core', get_template_directory_uri() . '/js/theme.core' . ( WP_DEBUG ? '' : '.min' ) . '.js', array('jquery'), '', true );

		}

		/* 	Localize Scripts
		/* ---------------------------------------------------------------------- */

		public function localize_script() {
			global $terminus_config;
			$sticky_navigation = 0;

			if ( isset($terminus_config['header_style']) ) {

				$header_style = $terminus_config['header_style'];

				switch ( $header_style ) {
					case 'style_1': $sticky_navigation = intval(terminus_get_option('sticky_navigation_type_1', 1)); break;
					case 'style_2': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_2', 1)); break;
					case 'style_3': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_3', 1)); break;
					case 'style_4': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_4', 1)); break;
					case 'style_5': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_5', 1)); break;
					case 'style_6': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_6', 1)); break;
					case 'style_7': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_7', 1)); break;
					case 'style_8': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_8', 1)); break;
					case 'style_11': $sticky_navigation = absint(terminus_get_option('sticky_navigation_type_11', 1)); break;
					default: $sticky_navigation = 1; break;
				}
			}

			wp_localize_script('jquery', 'terminus_global_vars', array(
				'template_base_uri' => get_template_directory_uri() . '/',
				'site_url' => esc_url(get_home_url('/')),
				'ajax_nonce' => wp_create_nonce('ajax-nonce'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				'ajax_loader_url' => get_template_directory_uri() . '/images/ajax_loader.GIF',
				'sticky_navigation' => absint($sticky_navigation),
				'rtl' => is_rtl() ? 1 : 0
			));

		}

		/* 	Load Textdomain
		/* ---------------------------------------------------------------------- */

		public function load_textdomain () {
			load_theme_textdomain( 'terminus', get_template_directory()  . '/lang' );
		}

		public function ajax_action_search() {
			check_ajax_referer($this->action_search);
			?>
			<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input value="<?php echo get_search_query() ?>" type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'terminus' ); ?>">
				<button type="submit"><span class="si-icon si-icon-search"></span></button>
			</form>
			<?php wp_die();
		}

		public function search_btn() {
			?>
			<a class="search_btn" href="javasript:void(0)" data-modal-action="<?php echo esc_attr($this->action_search); ?>" data-modal-nonce="<?php echo esc_attr(wp_create_nonce($this->action_search)) ?>">
				<span class="si-icon si-icon-search"></span>
			</a>
			<?php
		}

		public function ajax_post_share() {
			check_ajax_referer($this->action_post_share);

			$post_id = $_REQUEST['post_id'];
			$image = esc_url(wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ));
			$permalink = esc_url(get_the_permalink( $post_id ));
			$title = esc_attr(get_the_title( $post_id ));

			?>
			<div class="share_popup">
				<h3><?php esc_html_e('Share This Post', 'terminus') ?>:</h3>
				<ul class="social_links">
					<li><a target="_blank" href="http://www.facebook.com/sharer.php?m2w&amp;s=100&amp;p&#091;url&#093;=<?php echo $permalink ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo $image ?>&amp;p&#091;title&#093;=<?php echo $title ?>" class="btn icon_only large rd-white tooltip_container" title="<?php esc_html_e('Facebook', 'terminus') ?>"><span class="tooltip top"><?php esc_html_e('Facebook', 'terminus') ?></span><i class="icon-facebook"></i></a></li>
					<li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title ?>&amp;url=<?php echo $permalink ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Twitter', 'terminus') ?></span><i class="icon-twitter"></i></a></li>
					<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Google+', 'terminus') ?></span><i class="icon-gplus"></i></a></li>
					<li><a target="_blank" href="https://pinterest.com/pin/create/link/?url=<?php echo $permalink ?>&amp;media=<?php echo $image ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('Pinterest', 'terminus') ?></span><i class="icon-pinterest-circled"></i></a></li>
					<li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink ?>&amp;title=<?php echo $title ?>" class="btn icon_only large rd-white tooltip_container"><span class="tooltip top"><?php esc_html_e('LinkedIn', 'terminus') ?></span><i class="icon-linkedin"></i></a></li>
				</ul>
			</div>
			<?php wp_die();
		}

		public function post_share_btn($post_id) {
			?>
			<a class="post-share-button btn rd-grey middle" href="javascript:void(0)" data-post-id="<?php echo esc_attr($post_id) ?>" data-modal-action="<?php echo esc_attr($this->action_post_share) ?>" data-modal-nonce="<?php echo esc_attr(wp_create_nonce($this->action_post_share)) ?>"><?php esc_html_e('Share', 'terminus') ?></a>
			<?php
		}

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

	}

	if ( ! function_exists('terminus_base_functions') ) {

		function terminus_base_functions() {
			// Load required classes and functions
			return TERMINUS_BASE_FUNCTIONS::getInstance();
		}

		terminus_base_functions();

	}

}