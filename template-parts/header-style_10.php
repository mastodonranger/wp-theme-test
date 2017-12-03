<div class="move_scroll_inner">

	<!-- - - - - - - - - - - - - - Logo - - - - - - - - - - - - - - - - -->

	<div class="logo_wrap">

		<?php $logo_type = terminus_get_option('logo_type'); ?>

		<?php
		switch ($logo_type) {
			case 'text':
				$logo_text = terminus_get_option('logo_text');

				if (empty($logo_text)) {
					$logo_text = get_bloginfo('name');
				}

				if (!empty($logo_text)): ?>

					<h1 id="logo" class="logo">
						<a title="<?php bloginfo('description'); ?>"
						   href="<?php echo esc_url(home_url('/')); ?>">
							<?php echo html_entity_decode($logo_text); ?>
						</a>
					</h1>

				<?php endif;

				break;
			case 'upload':

				$logo_image = terminus_get_option('logo_image');

				if (!empty($logo_image)) {
					?>

					<a id="logo" class="logo" title="<?php bloginfo('description'); ?>"
					   href="<?php echo esc_url(home_url('/')); ?>">
						<img src="<?php echo esc_attr($logo_image); ?>" alt="<?php bloginfo('description'); ?>"/>
					</a>

					<?php
				}

				break;
		}
		?>

	</div><!--/ .logo_wrap -->

	<!-- - - - - - - - - - - - - - End of Logo - - - - - - - - - - - - - - - - -->

	<!-- - - - - - - - - - - - - - Vertical Navigation - - - - - - - - - - - - - - - - -->

	<nav class="main_nav">
		<div class="vertical_navigation"><?php echo TERMINUS_HELPER::main_navigation(''); ?></div>
	</nav>

	<!-- - - - - - - - - - - - - - End of Vertical Navigation - - - - - - - - - - - - - - - - -->

	<!-- - - - - - - - - - - - - - Social Links - - - - - - - - - - - - - - - - -->

	<?php if ( terminus_get_option('show_social_links_type_10', 1) ): ?>
		<?php echo terminus_header_social_links(); ?>
	<?php endif; ?>

	<!-- - - - - - - - - - - - - - End of Social Links - - - - - - - - - - - - - - - - -->

</div><!--/ .move_scroll_inner-->