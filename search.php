<?php
	/**
	 * The template for displaying Search Results pages.
	 */
	get_header();

?>
<div class="template-search">

	<?php if ( !empty($_GET['s']) || have_posts() ): ?>

		<?php if ( have_posts() ): ?>

			<?php
			$wrapper_attributes = array();
			$blog_style = terminus_get_option( 'blog_style_search', 'blog-big-thumbs' );
			$columns = terminus_get_option( 'blog_columns', 3 );

			$atts = array(
				'columns' => $columns,
				'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
			);

			$css_classes = array(
				'blog-area',
				'layout_4',
				'paginate-pagination',
				$blog_style
			);

			switch ( $blog_style ) {
				case 'blog-grid':
					$css_classes[] = 'grid-columns-' . absint($columns);
					break;
				case 'blog-masonry':
					$css_classes[] = 'grid-columns-' . absint($columns);
					$css_classes[] = 'isotope_container';
					$atts['isotope-layout'] = 'masonry';
					break;
			}

			$wrapper_attributes[] = TERMINUS_HELPER::create_data_string($atts);

			$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
			$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
			?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/loop', 'index' );
				endwhile;
				?>

			</div><!--/ .post-area-->

			<?php echo terminus_pagination(); ?>

		<?php else:

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</div><!--/ .template-search-->

<?php get_footer(); ?>