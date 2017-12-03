<?php

class WPBakeryShortCode_VC_mad_list_styles extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'icon' => '',
			'values' => 'Nulla venenatis. In pede mi|Aliquet sit amet euismod|In auctor ut ligula aliquam dapibus|Tincidunt metus praesent',
			'icon_color' => ''
		), $atts, 'vc_mad_list_styles');

		return $this->html();
	}

	public function html() {

	 	$icon = $list_items = $list_styles = $values = $icon_color = $style = '';

		extract($this->atts);

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_list_styles wpb_content_element', $this->settings['base'], $this->atts );

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<?php $values = explode('|', $values); ?>

			<?php if ( is_array($values) ): ?>

				<?php if ( $icon !== ' ' ): ?>

					<?php
						if ( !empty( $icon_color ) ) {
							$color = vc_get_css_color( 'color', $icon_color );
							$style = 'style="' . $color . '"';
						}

						$icon = '<i '. $style .' class="'. $icon .'"></i>';
					?>

				<?php endif; ?>

				<?php foreach( $values as $value ) {
					$list_items .= "<li>{$icon}{$value}</li>";
				} ?>

			<?php endif; ?>

			<div class="<?php echo esc_attr($css_class); ?>">
				<?php if ( $icon !== '' ): ?>
					<ul class="list-styles"><?php echo wp_kses( $list_items,
							array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array(),
								'i' => array(
									'class' => true,
									'style' => true
								),
								'strong' => array()
							)
						) ?></ul>
				<?php else: ?>
					<ol class="list-styles"><?php echo wp_kses( $list_items,
							array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array(),
								'i' => array(
									'class' => true,
									'style' => true
								),
								'strong' => array()
							)
						) ?></ol>
				<?php endif; ?>
			</div><!--/ .wpb_list_styles-->

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}