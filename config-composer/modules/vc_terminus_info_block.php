<?php
if (!class_exists('terminus_info_block')) {

	class terminus_info_block {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map_infoblock'));
		}

		function add_map_infoblock() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Infoblock", 'terminus' ),
					   "base" => "vc_mad_info_block",
					   "class" => "vc_mad_info_block",
					   "icon" => "icon-wpb-mad-info-block",
						'category' => esc_html__( 'Terminus', 'terminus' ),
						"description" => esc_html__('Styled info blocks', 'terminus'),
					   "as_parent" => array('only' => 'vc_mad_info_block_item'),
					   "content_element" => true,
					   "show_settings_on_create" => false,
					   "params" => array(
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Title', 'terminus' ),
							   'param_name' => 'title',
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'terminus' )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Tag for title', 'terminus' ),
							   'param_name' => 'tag_title',
							   'value' => array(
								   'h2' => 'h2',
								   'h3' => 'h3'
							   ),
							   'std' => 'h2',
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Choose tag for title.', 'terminus' )
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title', 'terminus' ),
							   'param_name' => 'title_color',
							   'description' => esc_html__( 'Select custom color for title.', 'terminus' ),
						   ),
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Description', 'terminus' ),
							   'param_name' => 'description',
							   'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'terminus' )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Columns', 'terminus' ),
							   'param_name' => 'columns',
							   'value' => array(
								   esc_html__( '1 Columns', 'terminus' ) => 1,
								   esc_html__( '2 Columns', 'terminus' ) => 2,
								   esc_html__( '3 Columns', 'terminus' ) => 3,
								   esc_html__( '4 Columns', 'terminus' ) => 4
							   ),
							   'std' => 3,
							   'description' => esc_html__( 'How many columns should be displayed?', 'terminus' )
						   ),
						   array(
							   "type" => "checkbox",
							   "heading" => "",
							   "param_name" => "counter",
							   "value" => array(
								   esc_html__("Enable to increase the value for title", "terminus") => true,
							   )
						   )
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Info Block Item", 'terminus'),
					   "base" => "vc_mad_info_block_item",
					   "class" => "vc_mad_info_block_item",
					   "icon" => "icon-wpb-mad-info-block",
					   "category" => esc_html__('Infoblock', 'terminus'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_info_block'),
					   "is_container" => true,
					   "params" => array(
						   array(
							   "type" => "dropdown",
							   "heading" => esc_html__( 'Select type', 'terminus' ),
							   "param_name" => "type",
							   "value" => array(
								   esc_html__('Type 1', 'terminus') => 'type_1',
								   esc_html__('Type 2', 'terminus') => 'type_2',
								   esc_html__('Type 3', 'terminus') => 'type_3',
								   esc_html__('Type 4', 'terminus') => 'type_4',
								   esc_html__('Type 5', 'terminus') => 'type_5',
							   ),
							   "std" => 'type_1',
							   "description" => esc_html__( 'Choose type for this info block.', 'terminus' )
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Title', 'terminus' ),
							   "param_name" => "title",
							   "holder" => "h4",
							   "description" => ''
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title', 'terminus' ),
							   'param_name' => 'title_color',
							   'description' => esc_html__( 'Select custom color for title.', 'terminus' ),
						   ),
						   array(
							   "type" => "choose_icons",
							   "heading" => esc_html__("Icon", 'terminus'),
							   "param_name" => "icon",
							   "value" => 'none',
							   'dependency' => array(
									'element' => 'type',
									'value' => array('type_1', 'type_3', 'type_4', 'type_5')
								),
							   "description" => esc_html__( 'Select icon from library.', 'terminus')
						   ),
						   array(
							   'type' => 'textarea_html',
							   'holder' => 'div',
							   'heading' => esc_html__( 'Text', 'terminus' ),
							   'param_name' => 'content',
							   'value' => wp_kses(__( '<p>Click edit button to change this text.</p>', 'terminus' ), array('p' => array()) )
						   ),
						   array(
							   'type' => 'vc_link',
							   'heading' => esc_html__( 'URL (Link)', 'terminus' ),
							   'param_name' => 'link',
							   'dependency' => array(
								   'element' => 'type',
								   'value' => array('type_2')
							   ),
							   'description' => esc_html__( 'Add link to custom heading.', 'terminus' )
						   ),
						   terminus_vc_map_add_css_animation(),
						   terminus_vc_map_add_animation_delay(),
						   terminus_vc_map_add_scroll_factor()
					    )
					) 
				);							

			}
		}

	}

	if (class_exists('WPBakeryShortCodesContainer')) {

		class WPBakeryShortCode_vc_mad_info_block extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$title = $tag_title = $title_color = $description = $counter = $columns = '';

				extract(shortcode_atts(array(
					'title' => '',
					'tag_title' => 'h2',
					'title_color' => '',
					'description' => '',
					'columns' => 3,
					'counter' => false
				), $atts));

				$css_class = array(
					'infoblock',
					'infoblock-columns-' . absint($columns)
				);

				if ( $counter ) {
					$css_class[] = 'steps';
				}

				ob_start(); ?>

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

					<section class="<?php echo esc_attr(implode(' ', $css_class)); ?>">
						<?php echo wpb_js_remove_wpautop($content, false) ?>
					</section><!--/ .infoblock-->

				</div>

				<?php return ob_get_clean() ;

			}

		}

		class WPBakeryShortCode_vc_mad_info_block_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {

				$wrapper_attributes = array();
				$title = $title_color = $style = $type = $icon = $css_animation = $animation_delay = $scroll_factor = $link = '';

				extract(shortcode_atts(array(
					'title' => '',
					'tag_title' => 'h2',
					'title_color' => '',
					'type' => 'type_1',
					'icon' => '',
					'link' => '',
					'css_animation' => '',
					'animation_delay' => '',
					'scroll_factor' => ''
				),$atts));

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';

				$css_classes = array(
					'infoblock-item',
					$type
				);

				if ( '' !== $css_animation  ) {
					$css_classes[] = 'terminus_animated';
					$wrapper_attributes[] = TERMINUS_HELPER::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
				}

				if ( $title_color ) {
					$style = 'style="color: '. $title_color .' !important"';
				}

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
				$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

				ob_start(); ?>

				<section <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<div class="icon_box">

					<?php switch ($type):

						case 'type_1': ?>

							<?php if ( $icon != '' ): ?>
								<span class="si-icon sa-size-70"><i class="<?php echo esc_attr($icon) ?>"></i></span>
							<?php endif; ?>

							<div class="wrapper">

								<?php if ( !empty($title) ): ?>
									<h3 class="box_title" <?php echo sprintf('%s', $style) ?>><?php echo esc_html($title); ?></h3>
								<?php endif; ?>

								<?php if ( !empty($a_href) ) {
									$content .= ' ' . '<a href="'. esc_url($a_href) .'" target="'. esc_attr($a_target) .'" class="read_more">'. esc_html($a_title) .'</a>';
								} ?>

								<?php echo wpb_js_remove_wpautop($content, true) ?>

							</div>

						<?php break; ?>
						<?php case 'type_2': ?>

							<div class="wrapper">

								<?php if ( !empty($title) ): ?>
									<h3 class="box_title" <?php echo sprintf('%s', $style) ?>><?php echo esc_html($title); ?></h3>
								<?php endif; ?>

								<?php if ( !empty($a_href) ) {
									$content .= ' ' . '<a href="'. esc_url($a_href) .'" target="'. esc_attr($a_target) .'" class="read_more">'. esc_html($a_title) .'</a>';
								} ?>

								<?php echo wpb_js_remove_wpautop($content, true) ?>

							</div>

						<?php break; ?>
						<?php case 'type_3': ?>

							<?php if ( $icon != '' ): ?>
								<span class="si-icon sa-size-42"><i class="<?php echo esc_attr($icon) ?>"></i></span>
							<?php endif; ?>

							<div class="wrapper">

								<?php if ( !empty($title) ): ?>
									<h3 class="box_title" <?php echo sprintf('%s', $style) ?>><?php echo esc_html($title); ?></h3>
								<?php endif; ?>

								<?php if ( !empty($a_href) ) {
									$content .= ' ' . '<a href="'. esc_url($a_href) .'" target="'. esc_attr($a_target) .'" class="read_more">'. esc_html($a_title) .'</a>';
								} ?>

								<?php echo wpb_js_remove_wpautop($content, true) ?>

							</div>

						<?php break; ?>
						<?php case 'type_4': ?>

							<?php if ( $icon != '' ): ?>
								<span class="si-icon sa-size-48"><i class="<?php echo esc_attr($icon) ?>"></i></span>
							<?php endif; ?>

							<div class="wrapper">

								<?php if ( !empty($title) ): ?>
									<h3 class="box_title" <?php echo sprintf('%s', $style) ?>><?php echo esc_html($title); ?></h3>
								<?php endif; ?>

								<?php if ( !empty($a_href) ) {
									$content .= ' ' . '<a href="'. esc_url($a_href) .'" target="'. esc_attr($a_target) .'" class="read_more">'. esc_html($a_title) .'</a>';
								} ?>

								<?php echo wpb_js_remove_wpautop($content, true) ?>

							</div>

						<?php break; ?>
						<?php case 'type_5': ?>

							<div class="front_side">

								<div class="fs_outer">

									<div class="fs_inner">

										<?php if ( !empty($title) ): ?>

											<h4 class="box_title" <?php echo sprintf('%s', $style) ?>>

												<?php if ( $icon != '' ): ?>
													<span class="si-icon sa-size-48"><i class="<?php echo esc_attr($icon) ?>"></i></span>
												<?php endif; ?>

												<?php echo esc_html($title); ?>

											</h4>

										<?php endif; ?>

									</div><!--/ .fs_inner -->

								</div><!--/ .fs_outer -->

							</div><!--/ .front_side -->

							<div class="back_side">

								<div class="box_inner">

									<?php if ( !empty($title) ): ?>
										<h4 class="box_title" <?php echo sprintf('%s', $style) ?>><?php echo esc_html($title); ?></h4>
									<?php endif; ?>

									<?php echo wpb_js_remove_wpautop( $content, true ) ?>

								</div>

							</div><!--/ .back_side -->

						<?php break; ?>
						<?php default: ?>

					<?php endswitch; ?>

					</div>

				</section>

				<?php return ob_get_clean();
			}

		}

	}

	new terminus_info_block();
}