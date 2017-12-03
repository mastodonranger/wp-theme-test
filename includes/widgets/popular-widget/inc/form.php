<?php extract(wp_parse_args($instance, $this->defaults)); ?>

	<p>
		<label for="<?php $this->field_id('title'); ?>"><?php esc_html_e('Title', 'terminus'); ?>
			<input class="widefat" id="<?php $this->field_id('title'); ?>" name="<?php $this->field_name('title') ?>" type="text" value="<?php echo esc_attr( $title ) ?>" />
		</label>
	</p>

	<div class="popw-tabs">

		<h4 class="popw-collapse"><?php esc_html_e( 'Type:', 'terminus'); ?><span></span></h4>
		<div style="display: block" class="popw-inner sort-type">
			<p>
				<label for="<?php $this->field_id('type-popular'); ?>">
					<input id="<?php $this->field_id('type-popular'); ?>" name="<?php $this->field_name('type'); ?>" value="popular" type="radio" <?php checked( $type, 'popular' ) ?> />
					<abbr title="Display the most viewed posts"><?php esc_html_e('Popular', 'terminus')?></abbr>
				</label> <br /><small><?php esc_html_e( 'Display the most viewed posts', 'terminus') ?></small><br />

				<label for="<?php $this->field_id( 'type-latest' )?>">
					<input id="<?php $this->field_id( 'type-latest' )?>" name="<?php $this->field_name('type'); ?>" value="latest" type="radio" <?php checked( $type, 'latest' ) ?> />
					<abbr title="Display the latest posts"><?php esc_html_e( 'Latest', 'terminus' )?></abbr>
				</label><br /><small><?php esc_html_e( 'Display the latest posts', 'terminus' ) ?></small>
			</p>
		</div>

	</div>

	<div class="popw-tabs <?php echo ($type == 'latest') ? 'disabled' : '' ?>" data-tab="calculate">
		<h4 class="popw-collapse"><?php esc_html_e('Calculate:', 'terminus')?><span></span></h4>
		<div class="popw-inner">
			<p>
				<label for="<?php $this->field_id('calculate-views'); ?>">
					<input id="<?php $this->field_id('calculate-views'); ?>" name="<?php $this->field_name('calculate'); ?>" value="views" type="radio" <?php checked($calculate, 'views') ?> />
					<abbr title="Every time the user views the page"><?php esc_html_e('Views', 'terminus'); ?></abbr>
				</label><br /><small><?php esc_html_e('Every time user views the post.', 'terminus'); ?></small><br />

				<label for="<?php $this->field_id('calculate-visits'); ?>">
					<input id="<?php $this->field_id('calculate-visits'); ?>" name="<?php $this->field_name('calculate'); ?>" value="visits" type="radio" <?php checked($calculate, 'visits') ?> />
					<abbr title="Every time the user visits the site"><?php esc_html_e('Visits', 'terminus'); ?></abbr>
				</label><br /><small><?php esc_html_e('Calculate only once per visit.', 'terminus'); ?></small>
			</p>
		</div>
	</div>

	<div class="popw-tabs">
		<h4 class="popw-collapse"><?php esc_html_e('Display:', 'terminus'); ?><span></span></h4>
		<div class="popw-inner">
			<p>
				<label for="<?php $this->field_id('counter'); ?>">
					<input id="<?php $this->field_id('counter'); ?>" name="<?php $this->field_name('counter'); ?>" type="checkbox" <?php checked('on', $counter) ?> />
					<?php esc_html_e('Display count', 'terminus'); ?>
				</label><br />

				<label for="<?php $this->field_id('thumb'); ?>">
					<input id="<?php $this->field_id('thumb'); ?>" name="<?php $this->field_name('thumb'); ?>" type="checkbox" <?php checked('on', $thumb); ?> />
					<?php esc_html_e('Display thumbnail', 'terminus'); ?>
				</label><br />

				<label for="<?php $this->field_id('excerpt'); ?>">
					<input id="<?php $this->field_id('excerpt'); ?>" name="<?php $this->field_name('excerpt'); ?>" type="checkbox" <?php checked('on', $excerpt); ?> />
					<?php esc_html_e('Display post excerpt', 'terminus'); ?>
				</label>
			</p>
			<p>
				<label for="<?php $this->field_id('limit'); ?>"><?php esc_html_e('Show how many posts?', 'terminus'); ?>
					<input id="<?php $this->field_id('limit'); ?>" name="<?php $this->field_name('limit'); ?>" size="5" type="text" value="<?php echo esc_attr($limit); ?>" />
				</label>
			</p>
			<p>
				<label for="<?php $this->field_id('excerptlength'); ?>"><?php esc_html_e('Excerpt length', 'terminus'); ?>
					<input id="<?php $this->field_id('excerptlength'); ?>" name="<?php $this->field_name('excerptlength'); ?>" size="5" type="text"
						   value="<?php echo esc_attr($excerptlength); ?>"/> <?php esc_html_e('Words', 'terminus'); ?>
				</label>
			</p>
		</div>

	</div>

<?php do_action( 'pop_admin_form' ) ?>