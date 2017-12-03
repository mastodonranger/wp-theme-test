<?php
if ( !class_exists('terminus_pricing_box') ) {

	class terminus_pricing_box {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map_pricing_box'));
		}
		
		function add_map_pricing_box() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box", 'terminus' ),
					   "base" => "vc_mad_pricing_box",
					   "class" => "vc_mad_pricing_box",
					   "icon" => "icon-wpb-mad-pricing-box",
						'category' => esc_html__( 'Terminus', 'terminus' ),
						"description" => esc_html__('Styled pricing tables', 'terminus'),
					   "as_parent" => array('only' => 'vc_mad_pricing_box_item'),
					   "content_element" => true,
					   "show_settings_on_create" => true,
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
								   esc_html__( '3 Columns', 'terminus' ) => 3,
								   esc_html__( '4 Columns', 'terminus' ) => 4,
								   esc_html__( '5 Columns', 'terminus' ) => 5,
								   esc_html__( '6 Columns', 'terminus' ) => 6
							   ),
							   'std' => 4,
							   'description' => esc_html__( 'How many columns should be displayed?', 'terminus' )
						   )
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box Item", 'terminus'),
					   "base" => "vc_mad_pricing_box_item",
					   "class" => "vc_mad_pricing_box_item",
					   "icon" => "icon-wpb-mad-pricing-box",
					   "category" => esc_html__('Pricing Box', 'terminus'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_pricing_box'),
					   "is_container" => false,
					   "params" => array(
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Name / Title', 'terminus' ),
							   "param_name" => "title",
							   "holder" => "h4",
							   "description" => esc_html__( 'Enter the package name or table heading.', 'terminus' ),
							   "value" => esc_html__( 'Free', 'terminus' ),
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Currency', 'terminus' ),
							   "param_name" => "currency",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter currency symbol or text, e.g., $ or USD.', 'terminus' ),
							   "value" => '$'
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Price', 'terminus' ),
							   "param_name" => "price",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter the price for this package', 'terminus' ),
							   "value" => '15'
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Price Unit', 'terminus' ),
							   "param_name" => "time",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter the price unit for this package. e.g. per month', 'terminus' ),
							   "value" => esc_html__( 'per month', 'terminus' )
						   ),
						   array(
							   "type" => "textarea_html",
							   "heading" => esc_html__( 'Features', 'terminus' ),
							   "param_name" => "features",
							   "holder" => "span",
							   "description" => esc_html__( 'Create the features list using un-ordered list elements. Divide values with linebreaks (Enter). Example: Up to 50 users|Limited team members', 'terminus' ),
							   "value" => esc_html__( 'Up to 50 users | Limited team members | Limited disk space | Custom Domain | PayPal Integration | Basecamp Integration | Email Tech Support | Unlimited Projects', 'terminus' )
						   ),
						   array(
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the whole box (optional)', 'terminus' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'checkbox',
							   'heading' => esc_html__( 'Featured', 'terminus' ),
							   'param_name' => 'add_label',
							   'description' => esc_html__( 'Adds a nice label to your pricing box.', 'terminus' ),
							   'value' => array( esc_html__( 'Yes, please', 'terminus' ) => true )
						   )
					    )
					)
				);

			}
		}

	}

	if ( class_exists('WPBakeryShortCodesContainer') ) {
		class WPBakeryShortCode_vc_mad_pricing_box extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$title = $tag_title = $title_color = $description = $columns = $extraclass = '';

				extract(shortcode_atts(array(
					'title' => '',
					'tag_title' => 'h2',
					'title_color' => '',
					'description' => '',
					'columns' => 4,
					'extraclass' => ''
				), $atts));

				$css_class = array('pricing-box', 'col-' . absint($columns));

				ob_start(); ?>

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

				<div class="<?php echo esc_attr(implode(' ', $css_class)); ?>">
					<?php echo wpb_js_remove_wpautop( $content, false ) ?>
				</div><!--/ .pricing-box-->

				<?php return ob_get_clean() ;
			}

		}

		class WPBakeryShortCode_vc_mad_pricing_box_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {
				$title = $currency = $price = $time = $features = $add_label = $link = "";

				extract(shortcode_atts(array(
					'title' => esc_html__('Free', 'terminus'),
					'currency' => '$',
					'price' => '15',
					'time' => 'per month',
					'features' => 'Up to 50 users | Limited team members | Limited disk space | Custom Domain | PayPal Integration | Basecamp Integration | Email Tech Support | Unlimited Projects',
					'link' => '',
					'add_label' => false
				),$atts));

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';

				ob_start(); ?>

				<div class="price-item">
					<section class="pricing_table <?php if ($add_label): ?>labeled<?php endif; ?>" <?php if ($add_label): ?>data-label-text="<?php esc_html_e('Recommended', 'terminus') ?>"<?php endif; ?>>

						<header>
							<h5 class="pt_title"><?php echo esc_html($title); ?></h5>
							<div class="pt_price"><?php echo esc_html($currency . $price); ?></div>
							<?php echo esc_html($time); ?>
						</header>

						<ul class="pt_options_list">
							<?php
							$features = explode('|', wp_strip_all_tags($features));
							$feature_list = '';
							if (is_array($features)) {
								foreach ($features as $feature) {
									$feature_list .= "<li>{$feature}</li>";
								}
							}
							?>
							<?php echo wp_kses( $feature_list, array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array()
							)); ?>
						</ul>

						<?php if ( !empty($a_title) ): ?>
							<footer>
								<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn small rd-black"><?php echo esc_html($a_title); ?></a>
							</footer>
						<?php endif; ?>

					</section>
				</div><!--/ .price-item-->

				<?php return ob_get_clean() ;
			}

		}
	}

	$terminus_pricing_box = new terminus_pricing_box();

}