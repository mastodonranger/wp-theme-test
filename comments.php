<?php global $post; ?>

<?php
	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
?>

<!-- - - - - - - - - - - - Comments - - - - - - - - - - - - - - -->

<?php if ( have_comments() ): ?>

	<div class="section-offset">

		<div id="comments">

			<h3><?php echo get_comments_number() . " " . esc_html__('Comments', 'terminus'); ?></h3>

			<ol class="comments-list">
				<?php wp_list_comments('avatar_size=100&callback=terminus_output_comments'); ?>
			</ol>

			<?php if (get_comment_pages_count() > 1 && get_option( 'page_comments' )): ?>
				<nav class="comments-pagination">
					<?php paginate_comments_links(); ?>
				</nav>
			<?php endif; ?>

			<?php if (! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' )): ?>
				<p class="nocomments"><?php esc_html_e('Comments are closed.', 'terminus'); ?></p>
			<?php endif; ?>

		</div><!--/ #comments-->

	</div><!--/ .section-offset-->

<?php endif; ?>

<!-- - - - - - - - - - - end Comments - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - Respond - - - - - - - - - - - - - - - -->

<?php if (comments_open()): ?>

	<div class="section-offset">
		<?php comment_form(); ?>
	</div><!--/ .section-offset-->

<?php elseif (get_comments_number()): ?>

	<div class="section-offset">
		<h3 class="commentsclosed"><?php esc_html_e( 'Comments are closed.', 'terminus' ) ?></h3>
	</div><!--/ .section-offset-->

<?php endif; ?>

<!-- - - - - - - - - - -/ end Respond - - - - - - - - - - - - - - -->
