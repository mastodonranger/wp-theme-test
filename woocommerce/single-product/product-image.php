<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
$image_uniqid = uniqid();
?>

	<div class="image_preview_container" data-id="<?php echo esc_attr($image_uniqid); ?>" id="qv_preview-<?php echo esc_attr($image_uniqid) ?>">

		<?php
		if ( has_post_thumbnail() ) {

			$attachment_count = count( $product->get_gallery_image_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );

			$atts_image_single = array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
				'data-zoom-image' => $props['url'],
				'srcset' => ' '
			);

			if ( terminus_get_option('zoom_on_product_image') ) {
				$atts_image_single['id'] = 'img_zoom';
			}

			$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), $atts_image_single );

			if ( terminus_get_option('lightbox_on_product_image') ) {

				echo apply_filters(
					'woocommerce_single_product_image_html',
					sprintf(
						'%s <a href="%s" title="%s" class="open_qv"><span class="si-icon"></span></a>',
						$image,
						esc_url( $props['url'] ),
						esc_attr( $props['caption'] ),
						$gallery
					),
					$post->ID
				);

			} else {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $post->ID );
			}

		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'terminus' ) ), $post->ID );
		}
		?>

	</div><!--/ .image_preview_container-->

<?php

$featuredID[] = $post_thumbnail_id;
$gallery_ids = $product->get_gallery_image_ids();

$attachment_ids = array_merge($featuredID, $gallery_ids);

if ( $attachment_ids && count($attachment_ids) > 1 ) { ?>

	<div class="product_preview" data-output="#qv_preview-<?php echo esc_attr($image_uniqid); ?>">

		<div class="product_thumbs_carousel" id="thumbnails_<?php echo esc_attr($image_uniqid); ?>">

			<?php

			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

			foreach ( $attachment_ids as $attachment_id ) {

				$classes = array( 'elzoom' );

				if ( $loop == 0 || $loop % $columns == 0 ) $classes[] = 'first';
				if ( ( $loop + 1 ) % $columns == 0 ) $classes[] = 'last';

				$image_class = implode( ' ', $classes );
				$props = wc_get_product_attachment_props( $attachment_id, $post );

				if ( ! $props['url'] ) {
					continue;
				}

				$image_src = wp_get_attachment_image_src( $attachment_id, 'shop_single');

				echo apply_filters(
					'woocommerce_single_product_image_thumbnail_html',
					sprintf(
						'<a href="javascript:void(0)" data-image="%s" data-zoom-image="%s" class="%s" title="%s">%s</a>',
						esc_attr($image_src[0]),
						esc_url( $props['url'] ),
						esc_attr( $image_class ),
						esc_attr( $props['caption'] ),
						wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
					),
					$attachment_id,
					$post->ID,
					esc_attr( $image_class )
				);

				$loop++;
			}

			?>

		</div><!--/ .product_thumbs_carousel-->

	</div><!--/ .product_preview-->

	<?php
}
