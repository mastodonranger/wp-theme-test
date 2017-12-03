<?php
/**
 * The template for displaying Author archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */
get_header(); ?>

<?php if ( have_posts() ) : ?>

	<div class="template-box">

		<?php
			$id = get_query_var('author');
			$name  =  get_the_author_meta('display_name', $id);
			$email =  get_the_author_meta('email', $id);
			$heading      = esc_html__("About", 'terminus') ." ". $name;
			$description  = get_the_author_meta('description', $id);

			if (current_user_can('edit_users') || get_current_user_id() == $id) {
				$description .= " <a href='" . esc_url(admin_url( 'profile.php?user_id=' . $id )) . "'>". esc_html__( '[ Edit the profile ]', 'terminus' ) ."</a>";
			}
		?>

		<div class="template-image-format">
			<?php echo get_avatar($email, '90', '', esc_html($name)); ?>
		</div><!--/ .template-image-format-->

		<div class="template-description">
			<h3 class="template-title"><?php echo esc_html($heading); ?></h3>
			<div class="template-text"><?php echo wp_kses( $description, array(
					'a' => array(
						'href' => true,
						'title' => true
					),
					'br' => array(),
					'em' => array(),
					'strong' => array()
				)); ?>
			</div><!--/ .template-text-->
		</div><!--/ .template-description-->

		<div class="clear"></div>

	</div><!--/ .template-box-->

	<?php
	$wrapper_attributes = array();
	$blog_style = terminus_get_option( 'blog_style', 'blog-big-thumbs' );
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

<?php get_footer(); ?>