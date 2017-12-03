<?php
/**
 * Custom Terminus template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Terminus
 * @since Terminus 1.0
 */

if ( ! function_exists( 'terminus_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own twentysixteen_excerpt() function to override in a child theme.
	 *
	 * @since Terminus 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function terminus_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo sanitize_html_class($class); ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo sanitize_html_class($class); ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists( 'terminus_single_page_links' ) ) :
	/**
	* Displays the .
	*
	*/
	function terminus_single_page_links() {
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		$next_post_url = $prev_post_url = "";
		$next_post_title = $prev_post_title = "";

		if ( is_object($next_post) ) {
			$next_post_url = get_permalink($next_post->ID);
			$next_post_title = $next_post->post_title;
		}
		if ( is_object($prev_post) ) {
			$prev_post_url = get_permalink($prev_post->ID);
			$prev_post_title = $prev_post->post_title;
		}

		if ( !empty($prev_post_url) || !empty($next_post_url) ): ?>

			<?php if ( !empty($prev_post_url) ): ?>
				<a class="btn rd-black nav_prev" href="<?php echo esc_url($prev_post_url) ?>" title="<?php echo esc_attr($prev_post_title) ?>"></a>
			<?php endif; ?>

			<?php if ( !empty($next_post_url) ): ?>
				<a class="btn rd-black nav_next" href="<?php echo esc_url($next_post_url) ?>" title="<?php echo esc_attr($next_post_title) ?>"></a>
			<?php endif; ?>

		<?php endif;

	}
endif;

if ( ! function_exists( 'terminus_entry_date' ) ) :
	/**
	 * Prints HTML with date information for current post.
	 *
	 */
	function terminus_entry_date($id) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U', $id ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c', $id ) ),
			get_the_date('j F Y', $id),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		if ( is_single($id) ) {
			printf( '<li><span class="posted-on">%1$s</span></li>',
				$time_string
			);
		} else {
			printf( '<li><span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span></li>',
				esc_url( get_permalink($id) ),
				$time_string
			);
		}

	}
endif;


if ( ! function_exists( 'terminus_get_excerpt' ) ) :
	/**
	 * Displays the get excerpt.
	 *
	 */
	function terminus_get_excerpt( $post_content, $limit = 150 ) {
		$content = terminus_string_truncate( $post_content, $limit, ' ', "...", true, '' );
		$content = apply_filters( 'the_content', $content );
		$content = do_shortcode($content);
		return $content;
	}
endif;


if ( ! function_exists( 'terminus_single_social_links' ) ) :
	/**
	 * Displays the social links for single pages.
	 *
	 */
	function terminus_single_social_links( $id = '' ) {
		$post_id = terminus_post_id();

		if ( absint($id) ) $post_id = $id;

		$facebook = rwmb_meta( 'terminus_tm_facebook', '', $post_id );
		$twitter = rwmb_meta( 'terminus_tm_twitter', '', $post_id );
		$gplus = rwmb_meta( 'terminus_tm_gplus', '', $post_id );
		$instagram = rwmb_meta( 'terminus_tm_instagram', '', $post_id );
		$linkedin = rwmb_meta( 'terminus_tm_linkedin', '', $post_id );
		$mailto = rwmb_meta( 'terminus_tm_mail', '', $post_id );
		?>
		<ul class="social_links">

			<?php if ( !empty($facebook) ): ?>
				<li>
					<a href="<?php echo esc_url($facebook) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('Facebook', 'terminus') ?></span><i class="icon-facebook"></i>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( !empty($twitter) ): ?>
				<li>
					<a href="<?php echo esc_url($twitter) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('Twitter', 'terminus') ?></span><i class="icon-twitter"></i>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( !empty($gplus) ): ?>
				<li>
					<a href="<?php echo esc_url($gplus) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('Google+', 'terminus') ?></span><i class="icon-gplus"></i>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( !empty($instagram) ): ?>
				<li>
					<a href="<?php echo esc_url($instagram) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('Instagram', 'terminus') ?></span><i class="icon-instagram"></i>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( !empty($linkedin) ): ?>
				<li>
					<a href="<?php echo esc_url($linkedin) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('LinkedIn', 'terminus') ?></span><i class="icon-linkedin"></i>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( !empty($mailto) ): ?>
				<li>
					<a href="mailto:<?php echo antispambot($mailto, 1) ?>" class="btn icon_only middle rd-grey tooltip_container">
						<span class="tooltip top"><?php esc_html_e('Mail Me', 'terminus') ?></span><i class="icon-mail-alt"></i>
					</a>
				</li>
			<?php endif; ?>

		</ul>
		<?php
	}
endif;


