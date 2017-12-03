<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php if (is_product()): ?>

	<h3 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h3>

<?php else: ?>

	<h3 itemprop="name" class="product_title entry-title">
		<a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
	</h3>

<?php endif; ?>