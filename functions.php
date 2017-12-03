<?php
/**
 * Terminus functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @since Terminus 1.0
 */

/* 	Basic Settings
/* ---------------------------------------------------------------------- */

/**
 * Include the product registration
 */
//require_once( get_template_directory() . '/includes/class-product-registration.php' );

/**
 * Include the main Terminus class.
 */
//require_once( get_template_directory() . '/includes/class-terminus.php' );
//
//function Terminus() {
//	return Terminus::get_instance();
//}
//Terminus();

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Terminus 1.0
 */
function terminus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'terminus_content_width', 1140 );
}
add_action( 'after_setup_theme', 'terminus_content_width', 0 );

/*  Add Widgets
/* ---------------------------------------------------------------------- */

require_once( get_template_directory() . '/includes/widgets/abstract-widget.php' );
require_once( get_template_directory() . '/includes/widgets.php' );

/* Load Theme Helpers
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/helpers/aq_resizer.php' );
require_once( get_template_directory() . '/includes/helpers/theme-helper.php' );
require_once( get_template_directory() . '/includes/helpers/post-format-helper.php' );

/*  Load Base Functions
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/classes/register-page.class.php' );
require_once( get_template_directory() . '/includes/classes/register-admin-user-profile.class.php' );
require_once( get_template_directory() . '/includes/functions-base.php' );

/*  Load Functions Files
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/functions-core.php' );

/*  Metadata
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/functions-metadata.php' );

/*  Include Framework
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/admin/framework/framework.php' );

/*  Load hooks
/* ---------------------------------------------------------------------- */
if ( !is_admin() ) {
	require_once( get_template_directory() . '/includes/templates-hooks.php' );
}

/*  Custom template tags for this theme.
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/template-tags.php' );

/*  Include Plugins
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/admin/plugin-bundle.php' );
require_once( get_template_directory() . '/config-plugins/config.php');

/*  Add Meta Boxes
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/includes/meta-box/meta-box.php' );
require_once( get_template_directory() . '/includes/config-meta.php' );
require_once( get_template_directory() . '/includes/page-title/config.php' );

/*  Include Config Widget Meta Box
/* ---------------------------------------------------------------------- */
require_once( get_template_directory() . '/config-widget-meta-box/config.php' );

/*  Include Config Composer
/* ---------------------------------------------------------------------- */

if ( class_exists('Vc_Manager') ) {
	require_once( get_template_directory() . '/config-composer/config.php');
}

/*  Include Config DHVC Forms
/* ---------------------------------------------------------------------- */

if ( defined('WPCF7_VERSION') ) {
	require_once( get_template_directory() . '/config-contact-form-7/config.php' );
}

/*  Include Config WooCommerce
/* ---------------------------------------------------------------------- */

if ( class_exists('WooCommerce') ) {
	require_once( get_template_directory() . '/config-woocommerce/config.php' );
}

/*  Include Config Mega Menu
/* ---------------------------------------------------------------------- */

if ( class_exists('mega_main_init') ) {
	require_once( get_template_directory() . '/config-megamenu/config.php' );
}

/*  Include Config WPML
/* ---------------------------------------------------------------------- */

if ( defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE') ) {
	require_once( get_template_directory() . '/config-wpml/config.php' );
}

/*  Get user name
/* ---------------------------------------------------------------------- */

if ( !function_exists("terminus_get_user_name") ) {

	function terminus_get_user_name($current_user) {

		if ( !$current_user->user_firstname && !$current_user->user_lastname ) {

			if ( terminus_is_shop_installed() ) {

				$firstname_billing = get_user_meta( $current_user->ID, "billing_first_name", true );
				$lastname_billing = get_user_meta( $current_user->ID, "billing_last_name", true );

				if ( !$firstname_billing && !$lastname_billing ) {
					$user_name = $current_user->user_nicename;
				} else {
					$user_name = $firstname_billing . ' ' . $lastname_billing;
				}

			} else {
				$user_name = $current_user->user_nicename;
			}

		} else {
			$user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
		}

		return $user_name;
	}

}

/*  Is shop installed
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_is_shop_installed')) {
	function terminus_is_shop_installed() {
		global $woocommerce;
		if ( isset( $woocommerce ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*  Is product
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_product') ) {
	function terminus_is_product() {
		return is_singular( array( 'product' ) );
	}
}

/*  Is product category
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_product_category') ) {
	function terminus_is_product_category( $term = '' ) {
		return is_tax( 'product_cat', $term );
	}
}

/*  Is product tag
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_product_tag') ) {
	function terminus_is_product_tag( $term = '' ) {
		return is_tax( 'product_tag', $term );
	}
}

/*  Get WC page id
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_wc_get_page_id') ) {
	function terminus_wc_get_page_id( $page ) {

		if ( $page == 'pay' || $page == 'thanks' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "pay" and "thanks" pages are no-longer used - an endpoint is added to the checkout instead. To get a valid link use the WC_Order::get_checkout_payment_url() or WC_Order::get_checkout_order_received_url() methods instead.' );

			$page = 'checkout';
		}
		if ( $page == 'change_password' || $page == 'edit_address' || $page == 'lost_password' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "change_password", "edit_address" and "lost_password" pages are no-longer used - an endpoint is added to the my-account instead. To get a valid link use the wc_customer_edit_account_url() function instead.' );

			$page = 'myaccount';
		}

		$page = apply_filters( 'woocommerce_get_' . $page . '_page_id', get_option('woocommerce_' . $page . '_page_id' ) );

		return $page ? absint( $page ) : -1;
	}
}

/*  Is shop
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_shop') ) {
	function terminus_is_shop() {
		return is_post_type_archive( 'product' ) || is_page( terminus_wc_get_page_id( 'shop' ) );
	}
}

/*  Is product tax
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_product_tax') ) {
	function terminus_is_product_tax() {
		return is_tax( get_object_taxonomies( 'product' ) );
	}
}

/*  Is really woocommerce pages
/* ---------------------------------------------------------------------- */

if ( ! function_exists('terminus_is_realy_woocommerce_page') ) {
	function terminus_is_realy_woocommerce_page( $archive = true ) {

		if ( $archive ) {
			if ( terminus_is_shop() || terminus_is_product_tax() || terminus_is_product() ) {
				return true;
			}
		}

		$woocommerce_keys = array("terminus_woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id");
		foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID() == get_option($wc_page_id, 0 ) ) {
				return true;
			}
		}
		return false;
	}
}