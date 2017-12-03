<?php

class WPBakeryShortCode_VC_mad_pie_chart extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		wp_enqueue_script( 'terminus_pie_chart' );

		$this->atts = shortcode_atts( array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'description' => '',
			'icon' => '',
			'values' => ''
		), $atts, 'vc_mad_pie_chart' );

		return $this->html();
	}

	public function html() {

		$title = $tag_title = $title_color = $description = $tag_title = $values = $icon = '';

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

				<div class="pie_charts">

					<?php foreach( $values as $value ): ?>

						<?php $css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array( 'pie_chart_container' ) ) ) ); ?>

						<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">

							<canvas class="pie_chart" width="168" height="168" data-value="<?php echo esc_attr($value['value']) ?>" <?php echo ( !empty($value['icon']) ) ? 'data-icon="'. $value['icon'] .'"' : ''  ?> <?php echo ( !empty($value['customcolor']) ) ? 'data-color="'. $value['customcolor'] .'"' : ''  ?>></canvas>

							<div class="pie_title">
								<div class="pie-label">
									<?php echo esc_html($value['label']) ?>
								</div>

								<?php if ( !empty($value['icon']) ): ?>
									<span class="unit-value"><?php echo esc_html($value['value']) . '%' ?></span>
								<?php endif; ?>
							</div>

						</div><!--/ .pie_chart_container-->

					<?php endforeach; ?>

				</div><!--/ .pie_charts-->

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean() ;
	}

}