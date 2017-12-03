<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Terminus for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once get_template_directory() . '/admin/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'terminus_register_required_plugins' );

if (!function_exists('terminus_added_admin_action')) {

	function terminus_added_admin_action() {
		add_action( 'admin_enqueue_scripts', 'terminus_added_plugin_style' );
	}

	function terminus_added_plugin_style() {
		wp_enqueue_style( 'terminus_admin_plugins', get_template_directory_uri() . '/css/admin-plugin.css', array() );
	}

	add_action( 'load-plugins.php', 'terminus_added_admin_action', 1 );

}
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function terminus_register_required_plugins() {

	// disable visual composer automatic update
	global $vc_manager;
	if ( $vc_manager ) {

		$vc_updater = $vc_manager->updater();

		if ( $vc_updater ) {
			remove_filter('upgrader_pre_download', array(&$vc_updater, 'upgradeFilterFromEnvato'));
			remove_filter('upgrader_pre_download', array(&$vc_updater, 'preUpgradeFilter'));
			remove_action('wp_ajax_nopriv_vc_check_license_key', array(&$vc_updater, 'checkLicenseKeyFromRemote'));
		}
	}

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		/*
				// This is an example of how to include a plugin pre-packaged with a theme.
				array(
					'name'               => 'TGM Example Plugin', // The plugin name.
					'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
					'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				),
		*/
		// This is an example of how to include a plugin from a private repo in your theme.
		/*
        array(
            'name'               => 'TGM New Media Plugin', // The plugin name.
            'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
            'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
        ),
		*/

		array(
			'name'     => esc_html__('WooCommerce', 'terminus'),
			'slug'     => 'woocommerce',
			'required' => false
		),

		array(
			'name'     => esc_html__('Yith WooCommerce Compare', 'terminus'),
			'slug'     => 'yith-woocommerce-compare',
			'required' => false
		),

		array(
			'name'     => esc_html__('Yith WooCommerce Wishlist', 'terminus'),
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false
		),

		array(
			'name'     => esc_html__('Contact Form 7', 'terminus'),
			'slug'     => 'contact-form-7',
			'required' => false
		),

		array(
			'name'      => esc_html__('Newsletter', 'terminus'),
			'slug'      => 'newsletter',
			'required'  => false
		),

		array(
			'name'               => esc_html__('Latest Tweets Widget', 'terminus'),
			'slug'               => 'latest-tweets-widget',
			'required'           => false
		),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.

		array(
			'name'               => esc_html__('Slider Revolution', 'terminus'),
			'slug'               => 'revslider',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/revslider.zip',
			'required'           => false,
			'version'            => '5.3.1.5',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('LayerSlider WP', 'terminus'),
			'slug'               => 'LayerSlider',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/LayerSlider.zip',
			'required'           => false,
			'version'            => '6.0.5',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Terminus Content Types', 'terminus'),
			'slug'               => 'terminus-content-types',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/terminus-content-types.zip',
			'required'           => false,
			'version'            => '1.0',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Easy Tables (vc)', 'terminus'),
			'slug'               => 'easy-tables-vc',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/easy-tables-vc.zip',
			'required'           => false,
			'version'            => '1.0.10',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('WOOF - WooCommerce Products Filter', 'terminus'),
			'slug'               => 'woocommerce-products-filter',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginus/woocommerce-products-filter.zip',
			'required'           => false,
			'version'            => '2.1.6.1',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Envato WordPress Toolkit Master', 'terminus'),
			'slug'               => 'envato-wordpress-toolkit-master',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginus/envato-wordpress-toolkit-master.zip',
			'required'           => false,
			'version'            => '1.7.3',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('WPBakery Visual Composer', 'terminus'),
			'slug'               => 'js_composer',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginus/js_composer.zip',
			'required'           => false,
			'version'            => '5.0.1',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Ultimate WooCommerce Brands Plugin', 'terminus'),
			'slug'               => 'mgwoocommercebrands',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginus/mgwoocommercebrands.zip',
			'required'           => false,
			'version'            => '1.5',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Mega Main Menu', 'terminus'),
			'slug'               => 'mega-main-menu',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/mega-main-menu.zip',
			'required'           => false,
			'version'            => '2.1.2',
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => esc_html__('Indeed Smart PopUp', 'terminus'),
			'slug'               => 'indeed-smart-popup',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/terminus/pluginus2/indeed-smart-popup.zip',
			'required'           => false,
			'version'            => '4.6',
			'force_activation'   => false,
			'force_deactivation' => false
		)

// 		array(
//			'name'               => esc_html__('WPML Multilingual CMS', 'terminus'), // The plugin name.
//			'slug'               => 'sitepress-multilingual-cms', // The plugin slug (typically the folder name).
//			'source'             => 'http://velikorodnov.com/wordpress/sample-data/plugins/sitepress-multilingual-cms.zip', // The plugin source.
//			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
//			'version'            => '3.6.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
//			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
//			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
//			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
//		)

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'terminus',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => ''
	);

	tgmpa( $plugins, $config );

}