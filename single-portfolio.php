<?php
/**
 * The template for displaying all single portfolios
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */

$post_id = terminus_post_id();
$position_post_meta = rwmb_meta( 'terminus_portfolio_position_post_meta', '', $post_id );

if ( empty($position_post_meta) ) {
	$position_post_meta = terminus_get_option( 'portfolio_position_post_meta', 'sbr' );
}

$categories = get_the_term_list( $post_id, 'portfolio_categories', '', ', ','' );
$skills = get_the_term_list( $post_id, 'skills', '', ', ','' );
$clients = get_the_term_list( $post_id, 'clients', '', ', ','' );
$websites = get_the_term_list( $post_id, 'websites', '', ', ','' );

get_header();  ?>

<?php if ( have_posts() ): ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>

			<div class="folio-container type-<?php echo esc_attr($position_post_meta) ?>">

				<?php if ( $position_post_meta == 'top'): ?>

					<div class="folio-meta">

						<div class="row">

							<div class="col-sm-3">

								<dl class="project_details">

									<dt><?php esc_html_e('Date', 'terminus') ?></dt>
									<dd>
										<?php
										$time_string = '<time datetime="%1$s">%2$s</time>';
										$time_string = sprintf( $time_string,
											esc_attr( get_the_date( 'c' ) ),
											get_the_date('j F Y')
										);

										printf( '%1$s', $time_string );
										?>
									</dd>

								</dl>

							</div>

							<div class="col-sm-3">

								<dl class="project_details">

									<?php if ( !empty($categories) ): ?>
										<dt><?php esc_html_e('Categories', 'terminus') ?></dt>
										<dd><?php echo get_the_term_list($post_id, 'portfolio_categories', '', ', ','') ?></dd>
									<?php endif; ?>

									<?php if (has_tag()):  ?>
										<dt><?php esc_html_e('Tags', 'terminus') ?></dt>
										<dd><?php echo the_tags('') ?></dd>
									<?php endif; ?>

								</dl>

							</div>

							<div class="col-sm-3">

								<dl class="project_details">

									<?php if ( !empty($skills) ): ?>
										<dt><?php esc_html_e('Skills', 'terminus') ?></dt>
										<dd><?php echo get_the_term_list($post_id, 'skills', '', ', ','') ?></dd>
									<?php endif; ?>

								</dl>

							</div>

							<div class="col-sm-3">

								<dl class="project_details">

									<?php if ( !empty($clients) ): ?>
										<dt><?php esc_html_e('Clients', 'terminus') ?></dt>
										<dd><?php echo get_the_term_list($post_id, 'clients', '', ', ','') ?></dd>
									<?php endif; ?>

									<?php if ( !empty($websites) ): ?>
										<dt><?php esc_html_e('Websites', 'terminus') ?></dt>
										<dd><?php echo get_the_term_list($post_id, 'websites', '', ', ','') ?></dd>
									<?php endif; ?>

								</dl>

							</div>

						</div><!--/ .row -->

					</div>

				<?php endif; ?>

				<div class="folio-entry"><?php the_content(); ?></div>

				<?php switch ( $position_post_meta ):

					case 'sbr':
					case 'sbl': ?>

						<div class="folio-meta scroll_sidebar">

							<!-- - - - - - - - - - - - - - Project Details - - - - - - - - - - - - - - - - -->

							<dl class="project_details">

								<?php if ( has_excerpt($post_id) ): ?>
									<dt><?php esc_html_e('Description', 'terminus') ?></dt>
									<dd><?php echo get_the_excerpt() ?></dd>
								<?php endif; ?>

								<dt><?php esc_html_e('Date', 'terminus') ?></dt>
								<dd>
									<?php
									$time_string = '<time datetime="%1$s">%2$s</time>';
									$time_string = sprintf( $time_string,
										esc_attr( get_the_date( 'c' ) ),
										get_the_date('j F Y')
									);

									printf( '%1$s', $time_string );
									?>
								</dd>

								<?php if ( !empty($categories) ): ?>
									<dt><?php esc_html_e('Categories', 'terminus') ?></dt>
									<dd><?php echo get_the_term_list($post_id, 'portfolio_categories', '', ', ','') ?></dd>
								<?php endif; ?>

								<?php if (has_tag()):  ?>
									<dt><?php esc_html_e('Tags', 'terminus') ?></dt>
									<dd><?php echo the_tags('') ?></dd>
								<?php endif; ?>

								<?php if ( !empty($skills) ): ?>
									<dt><?php esc_html_e('Skills', 'terminus') ?></dt>
									<dd><?php echo get_the_term_list($post_id, 'skills', '', ', ','') ?></dd>
								<?php endif; ?>

								<?php if ( !empty($clients) ): ?>
									<dt><?php esc_html_e('Clients', 'terminus') ?></dt>
									<dd><?php echo get_the_term_list($post_id, 'clients', '', ', ','') ?></dd>
								<?php endif; ?>

								<?php if ( !empty($websites) ): ?>
									<dt><?php esc_html_e('Websites', 'terminus') ?></dt>
									<dd><?php echo get_the_term_list($post_id, 'websites', '', ', ','') ?></dd>
								<?php endif; ?>

							</dl><!--/ .project_details-->

							<!-- - - - - - - - - - - - - - End of Project Details - - - - - - - - - - - - - - - - -->

							<?php echo terminus_base_post_share_btn($post_id); ?>

						</div><!--/ .folio-meta-->

					<?php break; ?>

					<?php case 'top': ?>

						<div class="buttons_set">
							<?php echo terminus_base_post_share_btn($post_id);

							$link_to_website = rwmb_meta('terminus_visit_to_website', '', $post_id);

							if ( isset($link_to_website) && !empty($link_to_website) ): ?>
								<a href="<?php echo esc_url($link_to_website) ?>" target="_blank" class="btn rd-grey middle"><?php esc_html_e('Visit The Website', 'terminus') ?></a>
							<?php endif; ?>
						</div>

					<?php break; ?>

					<?php case 'bottom': ?>

						<div class="folio-meta">

							<div class="row">

								<?php if ( has_excerpt($post_id) ): ?>

									<div class="col-sm-4">

										<dl class="project_details">
											<dt><?php esc_html_e('Description', 'terminus') ?></dt>
											<dd><?php echo get_the_excerpt() ?></dd>
										</dl>

									</div>

								<?php endif; ?>

								<div class="col-sm-4">

									<dl class="project_details">

										<dt><?php esc_html_e('Date', 'terminus') ?></dt>
										<dd>
											<?php
											$time_string = '<time datetime="%1$s">%2$s</time>';
											$time_string = sprintf( $time_string,
												esc_attr( get_the_date( 'c' ) ),
												get_the_date('j F Y')
											);

											printf( '%1$s', $time_string );
											?>
										</dd>

										<?php if ( !empty($categories) ): ?>
											<dt><?php esc_html_e('Categories', 'terminus') ?></dt>
											<dd><?php echo get_the_term_list($post_id, 'portfolio_categories', '', ', ','') ?></dd>
										<?php endif; ?>

										<?php if (has_tag()):  ?>
											<dt><?php esc_html_e('Tags', 'terminus') ?></dt>
											<dd><?php echo the_tags('') ?></dd>
										<?php endif; ?>

									</dl>

								</div>

								<div class="col-sm-4">

									<dl class="project_details">

										<?php if ( !empty($skills) ): ?>
											<dt><?php esc_html_e('Skills', 'terminus') ?></dt>
											<dd><?php echo get_the_term_list($post_id, 'skills', '', ', ','') ?></dd>
										<?php endif; ?>

										<?php if ( !empty($clients) ): ?>
											<dt><?php esc_html_e('Clients', 'terminus') ?></dt>
											<dd><?php echo get_the_term_list($post_id, 'clients', '', ', ','') ?></dd>
										<?php endif; ?>

										<?php if ( !empty($websites) ): ?>
											<dt><?php esc_html_e('Websites', 'terminus') ?></dt>
											<dd><?php echo get_the_term_list($post_id, 'websites', '', ', ','') ?></dd>
										<?php endif; ?>

									</dl>

									<?php echo terminus_base_post_share_btn($post_id); ?>

								</div>

							</div><!--/ .row -->

						</div>

						<div class="buttons_set">
							<?php $link_to_website = rwmb_meta('terminus_visit_to_website', '', $post_id);

							if ( isset($link_to_website) && !empty($link_to_website) ): ?>
								<a href="<?php echo esc_url($link_to_website) ?>" target="_blank" class="btn rd-grey middle"><?php esc_html_e('Visit The Website', 'terminus') ?></a>
							<?php endif; ?>
						</div>

					<?php break; ?>

				<?php endswitch; ?>

			</div><!--/ .folio-container-->

			<?php switch ( $position_post_meta ):

				case 'sbr':
				case 'sbl': ?>

					<div class="buttons_set">
						<?php $link_to_website = rwmb_meta('terminus_visit_to_website', '', $post_id);

						if ( isset($link_to_website) && !empty($link_to_website) ): ?>
							<a href="<?php echo esc_url($link_to_website) ?>" target="_blank" class="btn rd-grey middle"><?php esc_html_e('Visit The Website', 'terminus') ?></a>
						<?php endif; ?>
					</div>

				<?php break; ?>

				<?php case 'none': ?>

					<div class="buttons_set">
						<?php echo terminus_base_post_share_btn($post_id);

						$link_to_website = rwmb_meta('terminus_visit_to_website', '', $post_id);

						if ( isset($link_to_website) && !empty($link_to_website) ): ?>
							<a href="<?php echo esc_url($link_to_website) ?>" target="_blank" class="btn rd-grey middle"><?php esc_html_e('Visit The Website', 'terminus') ?></a>
						<?php endif; ?>
					</div>

				<?php break; ?>

			<?php endswitch ?>

			<!-- - - - - - - - - - - - - - Post meta - - - - - - - - - - - - - - - - -->

		</article>

	<?php endwhile ?>

<?php endif;

get_footer();  ?>