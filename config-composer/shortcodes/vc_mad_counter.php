<?php

class WPBakeryShortCode_VC_mad_counter extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'values' => ''
		), $atts, 'vc_mad_counter');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $tag_title = $title_color = $description = $values = $icon = '';

		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element">

				<?php
				echo Terminus_Vc_Config::getParamTitle(
					$title,
					$tag_title,
					$description,
					array(
						'title_color' => $title_color
					)
				);
				?>

				<div class="counters">

					<?php foreach( $values as $value ): ?>

						<?php $css_classes = array( 'counter_item' ); ?>
						<?php
							$icon = '';

							if ( !empty($value['icon']) ) {
								$icon = trim($value['icon']);
							}

						?>

						<?php if ( !empty($icon) ): ?>
							<?php $css_classes[] = 'with_icon'; ?>
						<?php endif; ?>

						<?php $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) ); ?>

						<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">

							<?php if ( !empty($icon) ): ?>
								<span class="si-icon sa-size-70"><i class="<?php echo trim($value['icon']) ?>"></i></span>
							<?php endif; ?>

							<div class="counter" data-amount="<?php echo esc_attr($value['value']) ?>"><?php echo esc_html($value['label']) ?></div>

						</div><!--/ .counter_item-->

					<?php endforeach; ?>

				</div><!--/ .counters-->

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}