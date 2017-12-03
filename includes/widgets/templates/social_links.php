<ul class="social_links">

	<?php if ($facebook_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($facebook_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Facebook', 'terminus') ?></span><i class="icon-facebook"></i></a></li>
	<?php endif; ?>

	<?php if ($twitter_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($twitter_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Twitter', 'terminus') ?></span><i class="icon-twitter"></i></a></li>
	<?php endif; ?>

	<?php if ($gplus_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($gplus_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Google+', 'terminus') ?></span><i class="icon-gplus"></i></a></li>
	<?php endif; ?>

	<?php if ($pinterest_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($pinterest_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Pinterest', 'terminus') ?></span><i class="icon-pinterest-circled"></i></a></li>
	<?php endif; ?>

	<?php if ($instagram_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($instagram_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Instagram', 'terminus') ?></span><i class="icon-instagram"></i></a></li>
	<?php endif; ?>

	<?php if ($linkedin_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($linkedin_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('LinkedIn', 'terminus') ?></span><i class="icon-linkedin"></i></a></li>
	<?php endif; ?>

	<?php if ($vimeo_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($vimeo_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Vimeo', 'terminus') ?></span><i class="icon-vimeo-squared"></i></a></li>
	<?php endif; ?>

	<?php if ($youtube_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($youtube_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Youtube', 'terminus') ?></span><i class="icon-youtube-play"></i></a></li>
	<?php endif; ?>

	<?php if ($flickr_links != '') : ?>
		<li><a target="_blank" href="<?php echo esc_url($flickr_links); ?>" class="tooltip_container"><span class="tooltip top"><?php esc_html_e('Flickr', 'terminus') ?></span><i class="icon-flickr"></i></a></li>
	<?php endif; ?>

</ul><!--/ .social_links-->