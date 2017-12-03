<?php
/**
 * The template for displaying Portfolio Archive area.
 */

get_header(); ?>

<?php if (have_posts()): ?>

	<?php
		$layout = terminus_get_option('layout_portfolio');
		$columns = terminus_get_option('portfolio_archive_column_count');
		$spacing = terminus_get_option('portfolio_spacing');
		$actions = terminus_get_option('portfolio_actions');

		$css_classes = array(
			'portfolio-holder',
			$layout . '-layout',
			$spacing, $actions,
			'paginate-pagination',
			'grid-columns-' . absint($columns)
		);

		if ( $layout == 'grid' || $layout == 'grid-classic' || $layout == 'masonry' ) {
			$css_classes[] = 'isotope_container';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$item_classes = array( 'project' );
		$item_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $item_classes ) ) );

		$attributes = array(
			'columns' => $columns,
			'sidebar' => TERMINUS_HELPER::template_layout_class('sidebar_position')
		);

		$data_rel = 'data-rel=portfolio-'. rand() .'';

		$defaults = array(
			'id' => '',
			'link' => '',
			'items_per_page' => 10,
			'sort_classes' => '',
			'cur_terms' => '',
			'item_size' => '',
			'image_size' => '640*420'
		);
	?>

	<div <?php echo terminus_create_data_string($attributes) ?> class="<?php echo esc_attr( trim( $css_class ) ) ?>">

		<?php while ( have_posts() ) : the_post(); ?>

				<?php
					$sizes = terminus_portfolio_get_image_sizes( array(
						'layout' => $layout,
						'columns' => $columns
					), get_the_ID(), TERMINUS_HELPER::template_layout_class('sidebar_position') );

					$entry = array(
						'id' => get_the_ID(),
						'link' => get_the_permalink(),
						'title' => get_the_title(),
						'sort_classes' => terminus_get_sort_class(),
						'img_size' => '',
						'cur_terms' => get_the_terms( get_the_ID(), 'portfolio_categories' ),
						'post_content' => has_excerpt() ? terminus_string_truncate( get_the_excerpt(), terminus_get_option('excerpt_count_portfolio'), ' ', "...", true, '' ) : '',
					) + $sizes;

					extract(array_merge($defaults, $entry));
				?>

				<div class="isotope_item <?php echo esc_attr($item_size) ?> <?php echo esc_attr($sort_classes) ?>">

					<!-- - - - - - - - - - - - - - Portfolio Item - - - - - - - - - - - - - - - - -->

					<div class="<?php echo esc_attr($item_class) ?>">

						<div class="overlay_box">

							<!-- - - - - - - - - - - - - - Project Image - - - - - - - - - - - - - - - - -->

							<?php echo TERMINUS_HELPER::get_the_post_thumbnail( $id, $image_size, true, array(), array( 'class' => 'ov_img', 'alt' => esc_attr($title) ) ); ?>

							<!-- - - - - - - - - - - - - - End of Project Image - - - - - - - - - - - - - - - - -->

							<div class="ov_blackout">

								<?php if ( $layout != 'grid-classic' ): ?>

									<div class="ov_text_outer">

										<!-- - - - - - - - - - - - - - Project Title & Cats - - - - - - - - - - - - - - - - -->

										<div class="ov_text_inner">

											<h3 class="project_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h3>

											<?php if ( terminus_get_option('show-portfolio-categories') ): ?>
												<?php if ( !empty($cur_terms) ): ?>
													<ul class="project_cats">
														<?php foreach($cur_terms as $cur_term): ?>
															<li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
														<?php endforeach; ?>
													</ul>
												<?php endif; ?>
											<?php endif; ?>

										</div><!--/ .ov_text_inner-->

										<!-- - - - - - - - - - - - - - End of Project Title & Cats - - - - - - - - - - - - - - - - -->

									</div><!--/ .ov_text_outer -->

								<?php endif; ?>

								<?php if ( $actions == 'with_actions' ): ?>

									<ul class="ov_actions">
										<li>
											<a href="<?php echo TERMINUS_HELPER::get_post_featured_image( $id, '' ) ?>" <?php echo esc_attr($data_rel) ?> class="fancybox" title="<?php echo esc_attr($title) ?>">
												<span class="si-icon si-icon-plus"></span>
											</a>
										</li>
										<li>
											<a href="<?php echo esc_url($link) ?>">
												<span class="si-icon si-icon-link"></span>
											</a>
										</li>
									</ul>

								<?php endif; ?>

							</div><!--/ .ov_blackout -->

						</div><!--/ .overlay_box -->

						<?php if ( $layout == 'grid-classic' ): ?>

							<figcaption class="project_details_area">

								<h3 class="project_name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h3>

								<?php if ( terminus_get_option('show-portfolio-categories') ): ?>
									<?php if ( !empty($cur_terms) ): ?>
										<ul class="project_cats">
											<?php foreach($cur_terms as $cur_term): ?>
												<li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								<?php endif; ?>

								<?php echo ( $post_content != '' ) ? '<p>' . "{$post_content}" . '</p>' : ''; ?>

							</figcaption>

						<?php endif; ?>

					</div>

					<!-- - - - - - - - - - - - - - End of Portfolio Item - - - - - - - - - - - - - - - - -->

				</div>

			<?php endwhile; ?>

	</div>

	<?php echo terminus_pagination(); ?>

<?php endif; ?>

<?php get_footer(); ?>