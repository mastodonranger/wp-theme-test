
<div class="settings-box">

	<div class="group-radio">
		<label><input type="radio" <?php checked( $mode, 'default' ) ?> name="terminus_page_title[mode]" value="default"><?php esc_html_e('Default', 'terminus') ?></label>
		<label><input type="radio" <?php checked( $mode, 'custom' ) ?> name="terminus_page_title[mode]" value="custom"><?php esc_html_e('Custom', 'terminus') ?></label>
		<label><input type="radio" <?php checked( $mode, 'none' ) ?> name="terminus_page_title[mode]" value="none"><?php esc_html_e('None', 'terminus') ?></label>
	</div>

	<div class="settings-box-content <?php if ( $mode !== 'custom' ): ?>terminus-hidden<?php endif; ?>">
		<?php
			foreach($options as $option) {
				terminus_page_title_meta_html( $page_title, $option );
			}
		?>
	</div><!--/ .settings-box-content-->

</div><!--/ .settings-box-->

