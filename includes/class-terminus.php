<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main theme class.
 */
class Terminus {

	/**
	 * The template directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_url = '';

	/**
	 * The one, true instance of the Terminus object.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * The theme version.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $version = '1.0';

	/**
	 * Determine if we're currently upgrading/migration options.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $is_updating  = false;

	/**
	 * Bundled Plugins.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $bundled_plugins = array();

	/**
	 * Gatsby_Product_registration
	 *
	 * @access public
	 * @var object Gatsby_Product_registration.
	 */
	public $registration;

	/**
	 * Access the single instance of this class.
	 *
	 * @return Terminus
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Terminus();
		}
		return self::$instance;
	}

	/**
	 * The class constructor
	 */
	private function __construct() {

		// Initialize bundled plugins array.
		self::$bundled_plugins = array(
			'revolution' => array( 'slug' => 'revslider', 'name' => esc_html__('Slider Revolution', 'terminus'), 'version' => '5.3.0.2' ),
			'content_types' => array( 'slug' => 'terminus-content-types', 'name' => esc_html__('Terminus Content Types', 'terminus'), 'version' => '1.0' ),
			'easy_tables' => array( 'slug' => 'easy-tables-vc', 'name' => esc_html__('Easy Tables (vc)', 'terminus'), 'version' => '1.0.10' ),
			'envato_wordpress_toolkit' => array( 'slug' => 'envato-wordpress-toolkit-master', 'name' => esc_html__('Envato WordPress Toolkit Master', 'terminus'), 'version' => '1.7.3' ),
			'composer' => array( 'slug' => 'js_composer', 'name' => esc_html__('WPBakery Visual Composer', 'terminus'), 'version' => '5.0.1' ),
			'wpml' => array( 'slug' => 'sitepress-multilingual-cms', 'name' => esc_html__('WPML Multilingual CMS', 'terminus'), 'version' => '3.6.2' ),
		);

		// Instantiate secondary classes.
		$this->registration = new Terminus_Product_Registration();
	}

	/**
	 * Gets the theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Gets the bundled plugins.
	 *
	 * @since 5.0
	 *
	 * @return array Array of bundled plugins.
	 */
	public static function get_bundled_plugins() {
		return self::$bundled_plugins;
	}

}