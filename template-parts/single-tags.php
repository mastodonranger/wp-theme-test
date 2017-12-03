
<!-- - - - - - - - - - - - - - Tags Holder - - - - - - - - - - - - - - - - -->

<div class="tags_holder">

	<div class="table_row">

		<div class="col-sm-9">

			<?php if ( terminus_get_option('blog-single-meta-tags') ): ?>
				<?php if ( is_single() && has_tag() && !post_password_required() ): ?>
					<div class="tags"><?php the_tags('<span class="title-tags">' . esc_html__('TAGS: ', 'terminus') . '</span>', ', '); ?></div>
				<?php endif; ?>
			<?php endif; ?>

		</div>

		<div class="col-sm-3">
			<?php echo terminus_base_post_share_btn( get_the_ID() ); ?>
		</div>

	</div>

</div><!--/ .tags_holder-->

<!-- - - - - - - - - - - - - - End of Tags Holder - - - - - - - - - - - - - - - - -->